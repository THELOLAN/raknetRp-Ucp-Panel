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
 * Hook the IP.Board output module and search for any block tags to replace.
 */

IPSDebug::fireBug( 'info', array( 'Loaded sldEasyPages_PublicOutput' ) );

class sldEasyPages_PublicOutput extends (~extends~)
{
	public function templateHooks( $text )
	{
		$classToLoad = IPSLib::loadLibrary( IPSLib::getAppDir( 'easypages' ) . "/sources/classes/common.php", 'sldEasyPages_common', 'easypages' );
		$this->common = new $classToLoad( $this->registry );

		$text = $this->common->parseStaticBlocks( $text );

		return parent::templateHooks( $text );
	}
}
