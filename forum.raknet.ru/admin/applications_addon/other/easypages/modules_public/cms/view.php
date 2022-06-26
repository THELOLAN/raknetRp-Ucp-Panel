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
 * Fetch the requested page.
 */

if ( ! defined( 'IN_ACP' ) ) {
	print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded 'admin.php'.";
	exit();
}

class public_easypages_cms_view extends ipsCommand
{
	protected $common;

	public function doExecute( ipsRegistry $registry )
	{
		/**
		 * Initialize
		 */
		$this->registry->class_localization->loadLanguageFile( array( 'public_global' ), 'easypages' );
		
		$classToLoad = IPSLib::loadLibrary( IPSLib::getAppDir( 'easypages' ) . "/sources/classes/common.php", 'sldEasyPages_common', 'easypages' );
		$this->common = new $classToLoad( $registry );

		$this->memb = $this->registry->member()->fetchMemberData();

		/**
		 * Fetch the page (if it exists)
		 */
		if( empty($this->request['page']) && !empty($this->settings['ep_default_page']) ) {
			$this->request['page'] = $this->settings['ep_default_page'];
		}

		if( !empty($this->request['page']) ) {
			$page = $this->DB->buildAndFetch( array(	'select'	=> '*',
														'from'		=> 'ep_pages',
														'where'		=> "page_key='".$this->DB->addSlashes($this->request['page'])."'" ) );
		}

		if( empty($page) ) {
			$this->registry->output->showError( 'ep_not_found', 404, false, null, 404 );
		}

		/**
		 * Check permissions
		 */
		if( !empty($page['page_group_access']) ) {
			if( !IPSMember::isInGroup( $this->memb, array_filter( explode( ',', $page['page_group_access'] ) ), true ) ) {
				$this->registry->output->showError( 'ep_access_denied', 403, false, null, 403 );
			}
		}

		/**
		 * (Re)Build the cache if necessary
		 */
		if( !$page['page_use_cache'] || empty($page['page_content_cache']) || ( $this->settings['ep_cache_ttl'] > 0 && time() > ( $page['page_cached'] + ($this->settings['ep_cache_ttl'] * 60) ) ) ) {
			$page['page_content_cache'] = $this->common->parseText( $page );

			if( $page['page_use_cache'] ) {
				$this->DB->update(	'ep_pages',
									array(	'page_cached'			=> time(),
											'page_content_cache'	=> $this->DB->addSlashes($page['page_content_cache']) ),
									'page_id=' . $page['page_id'] );
			}
		}
		
		/**
		 * Output the page contents.
		 */
		if( $page['page_use_wrapper'] ) {
			if( !empty($page['page_meta_key']) ) {
				$this->registry->output->addMetaTag( 'keywords', $page['page_meta_key'], false );
			}
			if( !empty($page['page_meta_desc']) ) {
				$this->registry->output->addMetaTag( 'description', $page['page_meta_desc'], false );
			}

			$this->registry->output->addCanonicalTag( "app=easypages&page=" . $page['page_key'], 'public', 'false' );

			$this->registry->output->addNavigation( $page['page_title'] );
			$this->registry->output->setTitle( $page['page_title'] );
			$this->registry->output->addContent( $page['page_content_cache'] );
			$this->registry->output->sendOutput();
		}
		else {
			echo $page['page_content_cache'];
		}
	}
}
