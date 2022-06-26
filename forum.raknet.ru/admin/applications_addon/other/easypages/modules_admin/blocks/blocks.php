<?php
/**
 * <pre>
 * Easy Pages
 * IP.Board v3.4
 * Last Updated: 29 January, 2013
 * </pre>
 *
 * @author 		Ryan Hoerr
 * @copyright	(c) 2013 Ryan Hoerr / Sublime Development
 * @link		http://www.sublimism.com
 * @version		1.1.3 (Revision 11003)
 */

/**
 * Do all the ACP block management actions and views
 */

if ( ! defined( 'IN_ACP' ) ) {
	print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded 'admin.php'.";
	exit();
}

class admin_easypages_blocks_blocks extends ipsCommand
{
	private $html;
	private $form_code;
	private $form_code_js;
	private $han_editor;
	protected $common;

	public function doExecute( ipsRegistry $registry ) 
	{
		//-----------------------------------------
		// Load skin
		//-----------------------------------------
		
		$this->html			= $this->registry->output->loadTemplate('cp_skin_blocks');
		
		//-----------------------------------------
		// Set up stuff
		//-----------------------------------------
		
		$this->form_code	= $this->html->form_code	= 'module=blocks&amp;section=blocks';
		$this->form_code_js	= $this->html->form_code_js	= 'module=blocks&section=blocks';

		$classToLoad = IPSLib::loadLibrary( IPSLib::getAppDir( 'easypages' ) . "/sources/classes/common.php", 'sldEasyPages_common', 'easypages' );
		$this->common = new $classToLoad( $registry );
		
		//-----------------------------------------
		// Load lang
		//-----------------------------------------
		
		$this->registry->class_localization->loadLanguageFile( array( 'admin_global' ), 'easypages' );

		///-----------------------------------------
		// What to do...
		//------------------------------------------
		
		switch( $this->request['do'] )
		{
			default:
			case 'display':
				$this->_showAll();
			break;
			
			case 'addnew':
				$this->registry->getClass('class_permissions')->checkPermissionAutoMsg( 'block_create' );
				$this->_add();
			break;
			
			case 'edit':
				$this->registry->getClass('class_permissions')->checkPermissionAutoMsg( 'block_edit' );
				$this->_edit();
			break;
			
			case 'delete':
				$this->registry->getClass('class_permissions')->checkPermissionAutoMsg( 'block_delete' );
				$this->_delete();
			break;
			
			case 'doAdd':
				$this->registry->getClass('class_permissions')->checkPermissionAutoMsg( 'block_create' );
				$this->_doAdd();
			break;
			
			case 'doEdit':
				$this->registry->getClass('class_permissions')->checkPermissionAutoMsg( 'block_edit' );
				$this->_doEdit();
			break;
		}
		
		//-----------------------------------------
		// Pass to CP output hander
		//-----------------------------------------
		
		$this->registry->output->html_main .= $this->registry->output->global_template->global_frame_wrapper();
		$this->registry->output->sendOutput();
		
	}
	
	/**
	 * Show the index [all blockes we've created]
	 */
	protected function _showAll()
	{
		if( !$this->registry->getClass('class_permissions')->checkPermission( 'block_php' ) ) {
			$where = 'block_use_php=0';
		}
		else {
			$where = '1';
		}

		/**
		 * Fetch all blocks.
		 */
		$this->DB->build( array(	'select'	=> 'block_id, block_title, block_key, block_created, block_updated',
									'from'		=> 'ep_blocks',
									'where'		=> $where,
									'order'		=> 'block_key asc' ) );
		$this->DB->execute();

		$blocks = array();
		while( $r = $this->DB->fetch() ) {
			$blocks[] = $r;
		}
		
		$this->registry->output->html .= $this->html->blocksMainScreen( $blocks );
	}
	
	/**
	 * Add-a-block form
	 */
	protected function _add()
	{
		$this->registry->output->html .= $this->html->blocksEditForm();
	}
	
	/**
	 * Change-a-block form
	 */
	protected function _edit()
	{
		$block_id = intval( $this->request['p'] );
		
		if( $block_id < 1 ) {
			$this->registry->output->showError( $this->lang->words['ep_invalid_id'], 17002 );
		}
		
		/**
		 * Get the current data
		 */
		$data = $this->DB->buildAndFetch( array(	'select'	=> '*',
													'from'		=> 'ep_blocks',
													'where'		=> 'block_id=' . $block_id ) );
		
		/**
		 * Goooo
		 */
		$this->registry->output->html .= $this->html->blocksEditForm( $data );
	}
	
	/**
	 * Whack-a-block
	 */
	protected function _delete()
	{
		$block_id = intval($this->request['p']);
		
		if( $block_id < 1) {
			$this->registry->output->showError( $this->lang->words['ep_invalid_id'], 17002 );
		}
		
		$block = $this->DB->buildAndFetch( array(	'select'	=> '*',
													'from'		=> 'ep_blocks',
													'where'		=> "block_id=$block_id" ) );
		
		/**
		 * Remove all fingerprints; we don't want to be found...
		 */
		$this->DB->delete( 'ep_blocks', "block_id=$block_id" );
		
		/**
		 * Goooo
		 */
		$this->registry->adminFunctions->saveAdminLog( sprintf( $this->lang->words['ep_log_block_deleted'], $block['block_title'] ) );
		$this->registry->output->redirect( $this->settings['base_url'] . $this->form_code, $this->lang->words['ep_block_did_delete'] );
	}
	
	/**
	 * Add a block [submit]
	 */
	protected function _doAdd()
	{
		/**
		 * Take care of data validation
		 */
		$db_insert = array();
		$db_insert['block_title']		= trim( IPSText::safeslashes( $this->request['title'] ) );
		$db_insert['block_key']			= preg_replace( '#[^a-zA-Z0-9./_-]#s', '', $_POST['key'] );
		$db_insert['block_content']		= trim( IPSText::safeslashes( $_POST['content'] ) );
		$db_insert['block_use_php']		= intval( $this->registry->getClass('class_permissions')->checkPermission( 'block_php' ) && (bool) $this->request['use_php'] );
		$db_insert['block_use_bbcode']	= (bool) $this->request['use_bbcode'] ? 1 : 0;
		$db_insert['block_created']		= time();
		$db_insert['block_updated']		= time();
		
		if( $db_insert['block_title'] == '' ) {
			$this->registry->output->showError( $this->lang->words['ep_need_title'] , 17001 );
		}

		if( IPSText::mbstrlen($db_insert['block_title']) > 255 || IPSText::mbstrlen($db_insert['block_key']) > 255 ) {
			$this->registry->output->showError( $this->lang->words['ep_long_field'] , 17003 );
		}
		
		/**
		 * Insert the new block
		 */
		$this->DB->insert( 'ep_blocks', $db_insert );
		$block_id = $this->DB->getInsertId();
		
		/**
		 * Goooo
		 */
		$this->registry->adminFunctions->saveAdminLog( sprintf( $this->lang->words['ep_log_block_added'], $db_insert['block_title'] ) );

		if( $this->request['continue'] ) {
			$this->registry->output->global_message = $this->lang->words['ep_saved'];
			$this->registry->output->silentRedirectWithMessage( $this->settings['base_url'] . $this->form_code . '&amp;do=edit&amp;p=' . $block_id );
		}
		else {
			$this->registry->output->redirect( $this->settings['base_url'] . $this->form_code, $this->lang->words['ep_block_did_add'] );
		}
	}
	
	/**
	 * Edit a block [submit]
	 */
	protected function _doEdit()
	{
		/**
		 * Take care of data validation
		 */
		$db_insert = array();
		$db_insert['block_title']		= trim( IPSText::safeslashes( $this->request['title'] ) );
		$db_insert['block_key']			= preg_replace( '#[^a-zA-Z0-9./_-]#s', '', $_POST['key'] );
		$db_insert['block_content']		= trim( IPSText::safeslashes( $_POST['content'] ) );
		$db_insert['block_use_php']		= intval( $this->registry->getClass('class_permissions')->checkPermission( 'block_php' ) && (bool) $this->request['use_php'] );
		$db_insert['block_use_bbcode']	= (bool) $this->request['use_bbcode'] ? 1 : 0;
		$db_insert['block_updated']		= time();
		
		$block_id = intval($this->request['block_id']);
		
		if( $block_id < 1) {
			$this->registry->output->showError( $this->lang->words['ep_invalid_id'], 17002 );
		}
		
		if( $db_insert['block_title'] == '' ) {
			$this->registry->output->showError( $this->lang->words['ep_need_title'] , 17001 );
		}

		if( IPSText::mbstrlen($db_insert['block_title']) > 255 || IPSText::mbstrlen($db_insert['block_key']) > 255 ) {
			$this->registry->output->showError( $this->lang->words['ep_long_field'] , 17003 );
		}
		
		$old = $this->DB->buildAndFetch( array(	'select'	=> '*',
												'from'		=> 'ep_blocks',
												'where'		=> "block_id=$block_id" ) );

		/**
		 * Update the block
		 */
		$this->DB->update( 'ep_blocks', $db_insert, 'block_id=' . $block_id );

		/**
		 * Update and recache page references
		 */
		$this->DB->build( array(	'select'	=> '*',
									'from'		=> 'ep_pages',
									'where'		=> "page_use_cache=1 and page_content like '%".$old['block_key']."%'" ) );
		$q = $this->DB->execute();
		while( $r = $this->DB->fetch($q) ) {
			$r['page_content'] = str_replace( array( 'static_block=&quot;'.$old['block_key'].'&quot;', 'static_block=&#39;'.$old['block_key'].'&#39;' ), 'static_block=&quot;'.$db_insert['block_key'].'&quot;', $r['page_content'] );
			$r['page_content_cache'] = $this->common->parseText( $r );
			$r['page_cached'] = time();
			$this->DB->update( 'ep_pages', $r, 'page_id='.$r['page_id'] );
		}
		
		/**
		 * Goooo
		 */
		$this->registry->adminFunctions->saveAdminLog( sprintf( $this->lang->words['ep_log_block_edited'], $db_insert['block_key'] ) );

		if( $this->request['continue'] ) {
			$this->registry->output->global_message = $this->lang->words['ep_saved'];
			$this->registry->output->silentRedirectWithMessage( $this->settings['base_url'] . $this->form_code . '&amp;do=edit&amp;p=' . $block_id );
		}
		else {
			$this->registry->output->redirect( $this->settings['base_url'] . $this->form_code, $this->lang->words['ep_block_did_edit'] );
		}
	}
}
