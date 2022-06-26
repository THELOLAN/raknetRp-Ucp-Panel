<?php
/**
 * <pre>
 * Invision Power Services
 * IP.Board v3.4.8
 * Twitter plug in for share links library.
 * This is just the basic fallback twitter share, the front end has JS to do something more fancy
 *
 * Created by Matt Mecham
 * Last Updated: $Date: 2014-09-16 11:37:52 -0400 (Tue, 16 Sep 2014) $
 * </pre>
 *
 * @author 		$Author: mark $
 * @copyright	(c) 2001 - 2009 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/company/standards.php#license
 * @package		IP.Board
 * @link		http://www.invisionpower.com
 * @version		$Rev: 12506 $
 *
 */

/* Class name must be in the format of:
   sl_{key}
   Where {key}, place with the value of: core_share_links.share_key
 */
class sl_print
{
	/**#@+
	* Registry Object Shortcuts
	*
	* @access	protected
	* @var		object
	*/
	protected $registry;
	protected $DB;
	protected $settings;
	protected $request;
	protected $lang;
	protected $member;
	protected $memberData;
	protected $cache;
	protected $caches;
	/**#@-*/
	
	/**
	 * Construct.
	 * @access	public
	 * @param	object		Registry
	 * @return	@e void
	 */
	public function __construct( $registry )
	{
		/* Make object */
		$this->registry   =  $registry;
		$this->DB         =  $this->registry->DB();
		$this->settings   =& $this->registry->fetchSettings();
		$this->request    =& $this->registry->fetchRequest();
		$this->lang       =  $this->registry->getClass('class_localization');
		$this->member     =  $this->registry->member();
		$this->memberData =& $this->registry->member()->fetchMemberData();
		$this->cache      =  $this->registry->cache();
		$this->caches     =& $this->registry->cache()->fetchCaches();
	}
	
	/**
	 * Requires a permission check
	 *
	 * @access	public
	 * @param	array		Data array
	 * @return	boolean
	 */
	public function requiresPermissionCheck( $array )
	{
		return true;
	}
	
	/**
	 * Redirect to Print
	 * Exciting, isn't it.
	 *
	 * @access	private
	 * @param	string		Title
	 * @param	string		URL
	 */
	public function share( $title, $url )
	{
		if ( ! empty( $this->settings['ccs_root_url'] ) )
		{
			$_urls	 = explode( "\n", str_replace( "\r", '', trim( $this->settings['ccs_root_url'] ) ) );
			$_urls[] = $this->settings['_original_base_url'];
			$ok      = FALSE;
			
			foreach( $_urls as $_url )
			{
				if ( ! empty($_url) AND parse_url( $url, PHP_URL_HOST ) === parse_url( $_url, PHP_URL_HOST ) )
				{
					$ok = TRUE;
					break;
				}
			}
			
			if ( $ok !== TRUE ) 
			{
				$this->registry->output->showError( 'no_permission', 100234.2, false, null, 403 );
			}
		}
		else
		{
			if ( parse_url( $url, PHP_URL_HOST ) !== parse_url( $this->settings['_original_base_url'], PHP_URL_HOST ) )
			{
				$this->registry->output->showError( 'no_permission', 100234.3, false, null, 403 );
			}
		}
		
		$title = IPSText::convertCharsets( $title, IPS_DOC_CHAR_SET, 'utf-8' );
		
		$_qmCount	= substr_count( $url, '?' );
		$_count		= ( $this->settings['url_type'] == 'query_string' ) ? 1 : 0;
		
		if ( $_qmCount > $_count )
		{
			#?/furl?s=xxxx
			$url .= '&forcePrint=1';
		}
		else
		{
			$url .= '?forcePrint=1';
		}

		$this->registry->output->silentRedirect( $url );
	}
}