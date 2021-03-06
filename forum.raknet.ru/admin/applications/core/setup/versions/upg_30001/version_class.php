<?php

/**
 * <pre>
 * Invision Power Services
 * IP.Board v3.4.8
 * Upgrade Class
 *
 * Class to add options and notices for IP.Board upgrade
 * Last Updated: $Date: 2012-05-10 16:10:13 -0400 (Thu, 10 May 2012) $
 * </pre>
 * 
 * @author		Matt Mecham <matt@invisionpower.com>
 * @version		$Rev: 10721 $
 * @since		3.0
 * @copyright	(c) 2001 - 2009 Invision Power Services, Inc.
 * @license		http://www.invisionpower.com/company/standards.php#license
 * @link		http://www.invisionpower.com
 * @package		IP.Board
 */ 

class version_class_core_30001
{
	/**
	 * Constructor
	 *
	 * @param	object		$registry		Registry object
	 * @return	@e void
	 */
	public function __construct( ipsRegistry $registry ) 
	{
		/* Make object */
		$this->registry =  $registry;
		$this->DB       =  $this->registry->DB();
		$this->settings =& $this->registry->fetchSettings();
		$this->request  =& $this->registry->fetchRequest();
		$this->cache    =  $this->registry->cache();
		$this->caches   =& $this->registry->cache()->fetchCaches();
	}
	
	/**
	 * Add pre-upgrade options: Form
	 * 
	 * @return	string	 HTML block
	 */
	public function preInstallOptionsForm()
	{
return <<<EOF
	<ul>
		<li>
			<input type='checkbox' name='exportSkins' value='1' />
			Export current skin's modified template bits and CSS? (This will be saved in /cache/previousSkinFiles)
		</li>
		<li>
			<input type='checkbox' name='exportLangs' value='1' />
			Copy language PHP files into /cache/previousLangFiles before upgrading?
		</li>
		<li>
			<input type='checkbox' name='skipPms' value='1' />
			<strong>Skip</strong> PM Conversion? If so, old tables will not be removed and you can use the provided shell tool post-upgrade
		</li>
		<li>
			<input type='checkbox' name='rootAdmins' value='1' />
			<strong>Remove all "non-root" admin ACP permissions?</strong> Due to the change in permission models, root admins and admins have the same default permissions.
			You have the option to restrict all non-root admins and then manually set up their permissions after the upgrade. Not ticking this box will effectively give all
			administrators full access regardless of administrator type.
		</li>
	</ul>
EOF;
		
	}
	
	/**
	 * Add pre-upgrade options: Save
	 *
	 * Data will be saved in saved data array as: appOptions[ app ][ versionLong ] = ( key => value );
	 * 
	 * @return	array	 Key / value pairs to save
	 */
	public function preInstallOptionsSave()
	{
		/* Return */
		return array( 'exportSkins' => intval( $_REQUEST['exportSkins'] ),
					  'exportLangs' => intval( $_REQUEST['exportLangs'] ),
					  'skipPms'     => intval( $_REQUEST['skipPms'] )
					);
		
	}
	
	/**
	 * Return any post-installation notices
	 * 
	 * @return	array	 Array of notices
	 */
	public function postInstallNotices()
	{
		$options    = IPSSetUp::getSavedData('custom_options');
		$_doSkin    = $options['core'][30001]['exportSkins'];
		$_doLang    = $options['core'][30001]['exportLangs'];
		$rootAdmins = $options['core'][30001]['rootAdmins'];
		$skipPms    = $options['core'][30001]['skipPms'];
		
		$notices   = array();
		
		if ( $_doSkin )
		{
			$notices[] = "All previous skins have been exported into 'cache/previousSkinFiles'";
		}
		
		if ( $_doLang )
		{
			$notices[] = "All previous language files have been exported into 'cache/previousLangFiles'";
		}
		
		if ( $skipPms )
		{
			$notices[] = "PM Conversion was skipped. If you want to convert PMs, please use the provided shell tool found in your 'tools' directory of the download";
		}
		
		/* Notice about post content */
		$notices[] = "You should now log into your Admin CP and rebuild post content (System &gt; Recount &amp; Rebuild)";
		
		/* Notice about admin restrictions */
		$notices[] = "Due to the change in permission systems, any admins that had restrictions have been updated to have no access to any module until you edit them.";
		
		/* Notice about admin restrictions */
		if ( $rootAdmins )
		{
			$notices[] = "Due to the change in permission systems, 'Root Admins' and 'Administrators' both have full access to the ACP including SQL toolbox, etc. You chose to remove all ACP permissions on upgrade. You can restore selective permissions via the ACP.";
		}
		else
		{
			$notices[] = "Due to the change in permission systems, 'Root Admins' and 'Administrators' both have full access to the ACP including SQL toolbox, etc. You can restrict individual admins using the ACP permission system.";
		}
			
		/* Notice about custom time settings */
		$notices[] = "Due to the change in how times are shown, all custom time/clock formats have been reset.";
		
		/* Notice about FURLs */
		$notices[] = "If you wish to use Friendly URLs, you will need to edit your conf_global.php file and add: \$INFO['use_friendly_urls'] = '1';. Once this is done run also the tool in \"ACP -> System TAB -> Recount &amp; Rebuild -> Resynchronize Forums\".";
		
		return $notices;
	}
	
	
	/**
	 * Return any pre-installation notices
	 * 
	 * @return	array	 Array of notices
	 */
	public function preInstallNotices()
	{
		$notices = array();
		
		$notices[] = "Skins made for prior versions will not be compatible with this version. The default skin will be restored.";
		
		return $notices;
		
	}
}
	
