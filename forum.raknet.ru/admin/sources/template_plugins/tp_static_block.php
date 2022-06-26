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
 * Send static block parse bits through to output for the hook to handle.
 */

class tp_static_block extends output implements interfaceTemplatePlugins
{
	public function __destruct()
	{
	}
	
	public function runPlugin( $data, $options )
	{
		return '{parse static_block=\"'.$data.'\"}';
	}
	
	public function getPluginInfo()
	{
		return array( 'name'    => 'static_block',
					  'author'  => 'Ryan Hoerr',
					  'usage'   => '{parse static_block="block_key"}',
					  'options' => array() );
	}
}
