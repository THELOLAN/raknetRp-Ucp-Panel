<?php
/*--------------------------------------------------*/
/* FILE GENERATED BY INVISION POWER BOARD 3         */
/* CACHE FILE: Skin set id: 2               */
/* CACHE FILE: Generated: Sat, 25 Jul 2015 17:29:11 GMT */
/* DO NOT EDIT DIRECTLY - THE CHANGES WILL NOT BE   */
/* WRITTEN TO THE DATABASE AUTOMATICALLY            */
/*--------------------------------------------------*/

class skin_mlist_2 extends skinMaster{

/**
* Construct
*/
function __construct( ipsRegistry $registry )
{
	parent::__construct( $registry );
	

$this->_funcHooks = array();
$this->_funcHooks['member_list_show'] = array('letterdefault','selected','chars','members','showmembers');


}

/* -- member_list_show --*/
function member_list_show($members, $pages="", $dropdowns=array(), $defaults=array(), $custom_fields=null, $url='') {
$IPBHTML = "";
if( IPSLib::locationHasHooks( 'skin_mlist', $this->_funcHooks['member_list_show'] ) )
{
$count_b4ca4c7eeeae8e23990f30718c09ebb3 = is_array($this->functionData['member_list_show']) ? count($this->functionData['member_list_show']) : 0;
$this->functionData['member_list_show'][$count_b4ca4c7eeeae8e23990f30718c09ebb3]['members'] = $members;
$this->functionData['member_list_show'][$count_b4ca4c7eeeae8e23990f30718c09ebb3]['pages'] = $pages;
$this->functionData['member_list_show'][$count_b4ca4c7eeeae8e23990f30718c09ebb3]['dropdowns'] = $dropdowns;
$this->functionData['member_list_show'][$count_b4ca4c7eeeae8e23990f30718c09ebb3]['defaults'] = $defaults;
$this->functionData['member_list_show'][$count_b4ca4c7eeeae8e23990f30718c09ebb3]['custom_fields'] = $custom_fields;
$this->functionData['member_list_show'][$count_b4ca4c7eeeae8e23990f30718c09ebb3]['url'] = $url;
}

if ( ! isset( $this->registry->templateStriping['memberStripe'] ) ) {
$this->registry->templateStriping['memberStripe'] = array( FALSE, "row1","row2");
}
$IPBHTML .= "<div class='master_list' id='member_list'>
	
	<h2>{$this->lang->words['mlist_header']}</h2>
	<div class='controls'>
<div class=\"buttons\">
<a class=\"button page-button\" id=\"filter-option\">Filter &raquo;</a></div>
<div id=\"filter-letters\">
		".$this->__f__4e92831e0fd5a671a5a3557a8ef56ad8($members,$pages,$dropdowns,$defaults,$custom_fields,$url)."</div>
</div>
	" . ((is_array( $members ) and count( $members )) ? ("
				".$this->__f__53bb1ab010f70c9a8d03eeb0bb8cc8e1($members,$pages,$dropdowns,$defaults,$custom_fields,$url)."	") : ("
		<div class='no_messages'>
			{$this->lang->words['no_results']}
		</div>
	")) . "
	
	<div class='controls'><div class=\"buttons\">
		{$pages}
	</div></div>
</div>";
return $IPBHTML;
}


function __f__4e92831e0fd5a671a5a3557a8ef56ad8($members, $pages="", $dropdowns=array(), $defaults=array(), $custom_fields=null, $url='')
{
	$_ips___x_retval = '';
	$__iteratorCount = 0;
	foreach( range(65,90) as $char )
	{
		
		$__iteratorCount++;
		$_ips___x_retval .= "
			" . (($letter = strtoupper(chr($char))) ? ("") : ("")) . "
				" . ((strtoupper( $this->request['quickjump'] ) == $letter) ? ("
					<span class='letter-page active'><strong>{$letter}</strong></span>&nbsp;
				") : ("
					<span class=\"letter-page\"><a href='" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "app=members&amp;{$url}&amp;quickjump={$letter}", "public",'' ), "false", "" ) . "' title='{$this->lang->words['mlist_view_start_title']} {$letter}'>{$letter}</a></span>&nbsp;
				")) . "
		
";
	}
	$_ips___x_retval .= '';
	unset( $__iteratorCount );
	return $_ips___x_retval;
}

function __f__53bb1ab010f70c9a8d03eeb0bb8cc8e1($members, $pages="", $dropdowns=array(), $defaults=array(), $custom_fields=null, $url='')
{
	$_ips___x_retval = '';
	$__iteratorCount = 0;
	foreach( $members as $member )
	{
		
		$__iteratorCount++;
		$_ips___x_retval .= "
			<div class='row touch-row' id=\"mem-{$member['member_id']}\">
				<div class='icon'>
					<a href='" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "showuser={$member['member_id']}", "public",'' ), "{$member['members_seo_name']}", "showuser" ) . "' title='{$this->lang->words['view_profile']}'><img src='{$member['pp_mini_photo']}' alt=\"" . sprintf($this->lang->words['users_photo'],$member['members_display_name']) . "\" class='photo' /></a>	
				</div>
				<strong><a class='title' href='" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "showuser={$member['member_id']}", "public",'' ), "{$member['members_seo_name']}", "showuser" ) . "' title='{$this->lang->words['view_profile']}'>{$member['members_display_name']}</a></strong>
				<br />
				<span class='subtext'>" . $this->registry->getClass('class_localization')->formatNumber( $member['posts'] ) . " {$this->lang->words['member_posts']} &middot; {$this->lang->words['member_group']}: " . IPSMember::makeNameFormatted( $member['group'], $member['member_group_id'] ) . "
				 &middot; <a href='" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "app=core&amp;module=search&amp;do=user_activity&amp;mid={$member['member_id']}", "public",'' ), "", "" ) . "'>" . $this->registry->getClass('output')->getReplacement("find_topics_link") . " {$this->lang->words['gbl_find_my_content']}</a></span>
			</div>
		
";
	}
	$_ips___x_retval .= '';
	unset( $__iteratorCount );
	return $_ips___x_retval;
}


}


/*--------------------------------------------------*/
/* END OF FILE                                      */
/*--------------------------------------------------*/

?>