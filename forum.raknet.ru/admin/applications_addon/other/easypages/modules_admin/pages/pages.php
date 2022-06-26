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
 * Do all the ACP page management actions and views
 */

if ( ! defined( 'IN_ACP' ) ) {
	print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded 'admin.php'.";
	exit();
}

class admin_easypages_pages_pages extends ipsCommand
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
		
		$this->html			= $this->registry->output->loadTemplate('cp_skin_pages');
		
		//-----------------------------------------
		// Set up stuff
		//-----------------------------------------
		
		$this->form_code	= $this->html->form_code	= 'module=pages&amp;section=pages';
		$this->form_code_js	= $this->html->form_code_js	= 'module=pages&section=pages';

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
				$this->registry->getClass('class_permissions')->checkPermissionAutoMsg( 'page_create' );
				$this->_add();
			break;
			
			case 'edit':
				$this->registry->getClass('class_permissions')->checkPermissionAutoMsg( 'page_edit' );
				$this->_edit();
			break;
			
			case 'delete':
				$this->registry->getClass('class_permissions')->checkPermissionAutoMsg( 'page_delete' );
				$this->_delete();
			break;
			
			case 'doAdd':
				$this->registry->getClass('class_permissions')->checkPermissionAutoMsg( 'page_create' );
				$this->_doAdd();
			break;
			
			case 'doEdit':
				$this->registry->getClass('class_permissions')->checkPermissionAutoMsg( 'page_edit' );
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
	 * Show the index [all pagees we've created]
	 */
	protected function _showAll()
	{
		if( !$this->registry->getClass('class_permissions')->checkPermission( 'page_php' ) ) {
			$where = 'page_use_php=0';
		}
		else {
			$where = '1';
		}

		/**
		 * Fetch all pages.
		 */
		$this->DB->build( array(	'select'	=> 'page_id, page_title, page_key, page_group_access, page_created, page_updated',
									'from'		=> 'ep_pages',
									'where'		=> $where,
									'order'		=> 'page_title asc' ) );
		$this->DB->execute();

		$pages = array();
		while( $r = $this->DB->fetch() ) {
			$pages[] = $r;
		}
		
		$this->registry->output->html .= $this->html->pagesMainScreen( $pages );
	}
	
	/**
	 * Add-a-page form
	 */
	protected function _add()
	{
		$this->registry->output->html .= $this->html->pagesEditForm();
	}
	
	/**
	 * Change-a-page form
	 */
	protected function _edit()
	{
		$page_id = intval( $this->request['p'] );
		
		if( $page_id < 1 ) {
			$this->registry->output->showError( $this->lang->words['ep_invalid_id'], 17002 );
		}
		
		/**
		 * Get the current data
		 */
		$data = $this->DB->buildAndFetch( array(	'select'	=> '*',
													'from'		=> 'ep_pages',
													'where'		=> 'page_id=' . $page_id ) );
		
		/**
		 * Goooo
		 */
		$this->registry->output->html .= $this->html->pagesEditForm( $data );
	}
	
	/**
	 * Whack-a-page
	 */
	protected function _delete()
	{
		$page_id = intval($this->request['p']);
		
		if( $page_id < 1) {
			$this->registry->output->showError( $this->lang->words['ep_invalid_id'], 17002 );
		}
		
		$page = $this->DB->buildAndFetch( array(	'select'	=> '*',
													'from'		=> 'ep_pages',
													'where'		=> "page_id=$page_id" ) );
		
		/**
		 * Remove all fingerprints; we don't want to be found...
		 */
		$this->DB->delete( 'ep_pages', "page_id=$page_id" );
		
		/**
		 * Goooo
		 */
		$this->registry->adminFunctions->saveAdminLog( sprintf( $this->lang->words['ep_log_page_deleted'], $page['page_title'] ) );
		$this->registry->output->redirect( $this->settings['base_url'] . $this->form_code, $this->lang->words['ep_page_did_delete'] );
	}
	
	/**
	 * Add a page [submit]
	 */
	protected function _doAdd()
	{
		/**
		 * Take care of data validation
		 */
		$db_insert = array();
		$db_insert['page_title']		= trim( IPSText::safeslashes( $this->request['title'] ) );
		$db_insert['page_key']			= preg_replace( '#[^a-zA-Z0-9./_-]#s', '', $_POST['key'] );
		$db_insert['page_content']		= trim( IPSText::safeslashes( $_POST['content'] ) );
		$db_insert['page_meta_key']		= trim( IPSText::safeslashes( $this->request['meta_key'] ) );
		$db_insert['page_meta_desc']	= trim( IPSText::safeslashes( $this->request['meta_desc'] ) );
		$db_insert['page_use_php']		= intval( $this->registry->getClass('class_permissions')->checkPermission( 'page_php' ) && (bool) $this->request['use_php'] );
		$db_insert['page_use_wrapper']	= (bool) $this->request['use_wrapper'] ? 1 : 0;
		$db_insert['page_use_bbcode']	= (bool) $this->request['use_bbcode'] ? 1 : 0;
		$db_insert['page_use_cache']	= (bool) $this->request['use_cache'] ? 1 : 0;
		$db_insert['page_created']		= time();
		$db_insert['page_updated']		= time();
		$db_insert['page_cached']		= time();
		$db_insert['page_content_cache'] = $db_insert['page_use_cache'] ? $this->common->parseText( $db_insert ) : '';
		
		if( count( $this->request['groups'] ) ) {
			foreach( $this->request['groups'] as $group ) {
				if( intval($group) > 0 )
					$db_insert['page_group_access'][] = intval($group);
			}
			$db_insert['page_group_access']	= implode(',', $db_insert['page_group_access']);
		}
		
		if( $db_insert['page_title'] == '' ) {
			$this->registry->output->showError( $this->lang->words['ep_need_title'] , 17001 );
		}

		if( IPSText::mbstrlen($db_insert['page_title']) > 255 || IPSText::mbstrlen($db_insert['page_key']) > 255 ) {
			$this->registry->output->showError( $this->lang->words['ep_long_field'] , 17003 );
		}
		
		/**
		 * Insert the new page
		 */
		$this->DB->insert( 'ep_pages', $db_insert );
		$page_id = $this->DB->getInsertId();
		
		/**
		 * Goooo
		 */
		$this->registry->adminFunctions->saveAdminLog( sprintf( $this->lang->words['ep_log_page_added'], $db_insert['page_title'] ) );

		if( $this->request['continue'] ) {
			$this->registry->output->global_message = $this->lang->words['ep_saved'];
			$this->registry->output->silentRedirectWithMessage( $this->settings['base_url'] . $this->form_code . '&amp;do=edit&amp;p=' . $page_id );
		}
		else {
			$this->registry->output->redirect( $this->settings['base_url'] . $this->form_code, $this->lang->words['ep_page_did_add'] );
		}
	}
	
	/**
	 * Edit a page [submit]
	 */
	protected function _doEdit()
	{
		/**
		 * Take care of data validation
		 */
		$db_insert = array();
		$db_insert['page_title']		= trim( IPSText::safeslashes( $this->request['title'] ) );
		$db_insert['page_key']			= preg_replace( '#[^a-zA-Z0-9./_-]#s', '', $_POST['key'] );
		$db_insert['page_content']		= trim( IPSText::safeslashes( $_POST['content'] ) );
		$db_insert['page_group_access']	= array();
		$db_insert['page_meta_key']		= trim( IPSText::safeslashes( $this->request['meta_key'] ) );
		$db_insert['page_meta_desc']	= trim( IPSText::safeslashes( $this->request['meta_desc'] ) );
		$db_insert['page_use_php']		= intval( $this->registry->getClass('class_permissions')->checkPermission( 'page_php' ) && (bool) $this->request['use_php'] );
		$db_insert['page_use_wrapper']	= (bool) $this->request['use_wrapper'] ? 1 : 0;
		$db_insert['page_use_bbcode']	= (bool) $this->request['use_bbcode'] ? 1 : 0;
		$db_insert['page_use_cache']	= (bool) $this->request['use_cache'] ? 1 : 0;
		$db_insert['page_updated']		= time();
		$db_insert['page_cached']		= time();
		$db_insert['page_content_cache'] = $db_insert['page_use_cache'] ? $this->common->parseText( $db_insert ) : '';
		
		$page_id = intval($this->request['page_id']);

		if( count( $this->request['groups'] ) ) {
			foreach( $this->request['groups'] as $group ) {
				if( intval($group) > 0 )
					$db_insert['page_group_access'][] = intval($group);
			}
			$db_insert['page_group_access']	= implode(',', $db_insert['page_group_access']);
		}
		
		if( $page_id < 1) {
			$this->registry->output->showError( $this->lang->words['ep_invalid_id'], 17002 );
		}
		
		if( $db_insert['page_title'] == '' ) {
			$this->registry->output->showError( $this->lang->words['ep_need_title'] , 17001 );
		}

		if( IPSText::mbstrlen($db_insert['page_title']) > 255 || IPSText::mbstrlen($db_insert['page_key']) > 255 ) {
			$this->registry->output->showError( $this->lang->words['ep_long_field'] , 17003 );
		}
		
		/**
		 * Update the page
		 */
		$this->DB->update( 'ep_pages', $db_insert, 'page_id=' . $page_id );
		
		/**
		 * Goooo
		 */
		$this->registry->adminFunctions->saveAdminLog( sprintf( $this->lang->words['ep_log_page_edited'], $db_insert['page_key'] ) );

		if( $this->request['continue'] ) {
			$this->registry->output->global_message = $this->lang->words['ep_saved'];
			$this->registry->output->silentRedirectWithMessage( $this->settings['base_url'] . $this->form_code . '&amp;do=edit&amp;p=' . $page_id );
		}
		else {
			$this->registry->output->redirect( $this->settings['base_url'] . $this->form_code, $this->lang->words['ep_page_did_edit'] );
		}
	}
}
