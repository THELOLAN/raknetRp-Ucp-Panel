<?php
/*--------------------------------------------------*/
/* FILE GENERATED BY INVISION POWER BOARD 3         */
/* CACHE FILE: Skin set id: 9               */
/* CACHE FILE: Generated: Sat, 01 Aug 2015 13:33:44 GMT */
/* DO NOT EDIT DIRECTLY - THE CHANGES WILL NOT BE   */
/* WRITTEN TO THE DATABASE AUTOMATICALLY            */
/*--------------------------------------------------*/

class skin_platform_global_9 extends skinMaster{

/**
* Construct
*/
function __construct( ipsRegistry $registry )
{
	parent::__construct( $registry );
	

$this->_funcHooks = array();


}

/* -- color_picker --*/
function color_picker() {
$IPBHTML = "";
$IPBHTML .= "<li id=\"nav_colorpicker\" data-dropdown=\"right click\" class=\"right\" style='padding: 4px 10px 0 0;'>
	<span><a href=\"#\"><img src=\"{style_images_url}/_custom/colorpicker.png\" alt=\"Color Picker\" title=\"Color Picker\" /></a></span>
	<ul>
		<li><div id=\"ptColorPicker\"></div><input id=\"ptColorInput\" type=\"text\" />" . Platform::colors()->output . "</li>
	</ul>
</li>";
return $IPBHTML;
}


}


/*--------------------------------------------------*/
/* END OF FILE                                      */
/*--------------------------------------------------*/

?>