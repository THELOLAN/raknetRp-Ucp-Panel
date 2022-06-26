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

if ( ! defined( 'IN_ACP' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly.";
	exit();
}

class admin_easypages_settings_settings extends ipsCommand
{
	public $html;
	public $form_code    = '';
	public $form_code_js = '';

	public function doExecute( ipsRegistry $registry ) 
	{
		//-----------------------------------------
		// Set up stuff
		//-----------------------------------------
		
		$this->form_code	= 'module=settings&amp;section=settings&amp;';
		$this->form_code_js	= 'module=settings&section=settings&';
		
		//-------------------------------
		// Grab, init and load settings
		//-------------------------------
		
		$classToLoad	= IPSLib::loadLibrary( IPSLib::getAppDir( 'core' ).'/modules_admin/settings/settings.php', 'admin_core_settings_settings' );
		$settings		= new $classToLoad( $this->registry );
		$settings->makeRegistryShortcuts( $this->registry );
		
		ipsRegistry::getClass('class_localization')->loadLanguageFile( array( 'admin_tools' ), 'core' );
		
		$settings->html			= $this->registry->output->loadTemplate( 'cp_skin_settings', 'core' );
		$settings->form_code	= $settings->html->form_code    = 'module=settings&amp;section=settings&amp;';
		$settings->form_code_js	= $settings->html->form_code_js = 'module=settings&section=settings&';

		$this->request['conf_title_keyword'] = 'easy_pages';
		$settings->return_after_save         = $this->settings['base_url'] . $this->form_code;
		$settings->_viewSettings();
		
		//-----------------------------------------
		// Pass to CP output hander
		//-----------------------------------------
		
		$this->registry->getClass('output')->html_main .= $this->registry->getClass('output')->global_template->global_frame_wrapper();
		$this->registry->getClass('output')->sendOutput();
	}
}
