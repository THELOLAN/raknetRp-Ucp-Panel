<?php
/*--------------------------------------------------*/
/* FILE GENERATED BY INVISION POWER BOARD 3         */
/* CACHE FILE: Skin set id: 2               */
/* CACHE FILE: Generated: Sat, 25 Jul 2015 17:29:11 GMT */
/* DO NOT EDIT DIRECTLY - THE CHANGES WILL NOT BE   */
/* WRITTEN TO THE DATABASE AUTOMATICALLY            */
/*--------------------------------------------------*/

class skin_boards_2 extends skinMaster{

/**
* Construct
*/
function __construct( ipsRegistry $registry )
{
	parent::__construct( $registry );
	

$this->_funcHooks = array();
$this->_funcHooks['boardIndexTemplate'] = array('unreadicon','hideDateUrl','forumRedirect','forums','cat_has_forums','categories','cats_forums');
$this->_funcHooks['hookRecentTopics'] = array('topics_hook','recenttopics');


}

/* -- boardIndexTemplate --*/
function boardIndexTemplate($lastvisit="", $stats=array(), $cat_data=array(), $show_side_blocks=true, $side_blocks=array()) {
$IPBHTML = "";
if( IPSLib::locationHasHooks( 'skin_boards', $this->_funcHooks['boardIndexTemplate'] ) )
{
$count_65f9f65d8cd25bbcf72a2df44adb11cf = is_array($this->functionData['boardIndexTemplate']) ? count($this->functionData['boardIndexTemplate']) : 0;
$this->functionData['boardIndexTemplate'][$count_65f9f65d8cd25bbcf72a2df44adb11cf]['lastvisit'] = $lastvisit;
$this->functionData['boardIndexTemplate'][$count_65f9f65d8cd25bbcf72a2df44adb11cf]['stats'] = $stats;
$this->functionData['boardIndexTemplate'][$count_65f9f65d8cd25bbcf72a2df44adb11cf]['cat_data'] = $cat_data;
$this->functionData['boardIndexTemplate'][$count_65f9f65d8cd25bbcf72a2df44adb11cf]['show_side_blocks'] = $show_side_blocks;
$this->functionData['boardIndexTemplate'][$count_65f9f65d8cd25bbcf72a2df44adb11cf]['side_blocks'] = $side_blocks;
}
$IPBHTML .= "" . (($this->settings['_onIndex'] = 1) ? ("") : ("")) . "
<div class='master_list' id='board_index'>
	" . ((is_array( $cat_data ) AND count( $cat_data )) ? ("
		".$this->__f__fcfc076aeb6893d12a3b25de6f2123f8($lastvisit,$stats,$cat_data,$show_side_blocks,$side_blocks)."	") : ("")) . "
</div>";
return $IPBHTML;
}


function __f__1b2efe498df2cdb6e68d749c5d526cc2($lastvisit="", $stats=array(), $cat_data=array(), $show_side_blocks=true, $side_blocks=array(),$_data='')
{
	$_ips___x_retval = '';
	$__iteratorCount = 0;
	foreach( $_data['forum_data'] as $forum_id => $forum_data )
	{
		
		$__iteratorCount++;
		$_ips___x_retval .= "
					" . (($forum_data['redirect_on']) ? ("
						<div class='row touch-row' id=\"forum-{$forum_data['id']}\">
							<div class='icon'>" . $this->registry->getClass('output')->getReplacement("f_redirect") . "</div>
							<div class='rowContent'>
								<a href=\"" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "showforum={$forum_data['id']}", "public",'' ), "{$forum_data['name_seo']}", "showforum" ) . "\" title='" . IPSText::striptags( IPSText::htmlspecialchars( $forum_data['name'] ) ) . "' class='title'>{$forum_data['name']}</a>
								<br /><span class='desc'>{$this->lang->words['rd_hits']}: " . $this->registry->getClass('class_localization')->formatNumber( $forum_data['redirect_hits'] ) . "</span>
							</div>
						</div>
					") : ("<div class='row touch-row' id=\"forum-{$forum_data['id']}\">
							<div class='icon'>
								" . (($forum_data['img_new_post'] != 'f_locked' && strstr( $forum_data['img_new_post'], 'unread' )) ? ("
									<a href=\"" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "app=forums&amp;module=forums&amp;section=markasread&amp;marktype=forum&amp;forumid={$forum_data['id']}&amp;returntoforumid={$this->request['f']}&amp;i=1&amp;k={$this->member->form_hash}", "public",'' ), "", "" ) . "\" title=\"{$this->lang->words['bi_markread']}\" class='forum_marker'>
										" . $this->registry->getClass('output')->getReplacement("f_unread") . "
									</a>
								") : ("
									" . $this->registry->getClass('output')->getReplacement("f_read") . "
								")) . "
							</div>
							<div class='rowContent'>
								<a href=\"" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "showforum={$forum_data['id']}", "public",'' ), "{$forum_data['name_seo']}", "showforum" ) . "\" title='" . IPSText::striptags( IPSText::htmlspecialchars( $forum_data['name'] ) ) . "' class='title'>{$forum_data['name']}</a>
								<br />
								<span class='desc'>
									<span class='number'>{$forum_data['topics']}</span> {$this->lang->words['topics']}
									" . ((! $forum_data['hide_last_info']) ? ("
										&middot; {$this->lang->words['last_post']} " . IPSText::htmlspecialchars($this->registry->getClass('class_localization')->getDate($forum_data['last_post'],"SHORT", 0)) . "
									") : ("")) . "
								</span>
							</div>
						</div>")) . "
				
";
	}
	$_ips___x_retval .= '';
	unset( $__iteratorCount );
	return $_ips___x_retval;
}

function __f__fcfc076aeb6893d12a3b25de6f2123f8($lastvisit="", $stats=array(), $cat_data=array(), $show_side_blocks=true, $side_blocks=array())
{
	$_ips___x_retval = '<!--hook.foreach.skin_boards.boardIndexTemplate.categories.outer.pre-->';
	$__iteratorCount = 0;
	foreach( $cat_data as $_data )
	{
		
		$__iteratorCount++;
		$_ips___x_retval .= "
			" . ((is_array( $_data['forum_data'] ) AND count( $_data['forum_data'] )) ? ("
				<h3 id=\"cat-{$_data['cat_data']['id']}\">{$_data['cat_data']['name']}</h3>
				".$this->__f__1b2efe498df2cdb6e68d749c5d526cc2($lastvisit,$stats,$cat_data,$show_side_blocks,$side_blocks,$_data)."			") : ("")) . "
		
";
	}
	$_ips___x_retval .= '';
	unset( $__iteratorCount );
	return $_ips___x_retval;
}

/* -- hookBoardIndexStatusUpdates --*/
function hookBoardIndexStatusUpdates($updates=array()) {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}

/* -- hookFacebookActivity --*/
function hookFacebookActivity() {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}

/* -- hookGroupNameIndicator --*/
function hookGroupNameIndicator($groups=array()) {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}

/* -- hookRecentTopics --*/
function hookRecentTopics($topics) {
$IPBHTML = "";
if( IPSLib::locationHasHooks( 'skin_boards', $this->_funcHooks['hookRecentTopics'] ) )
{
$count_f71f29a464a97ede3d20591383d4073f = is_array($this->functionData['hookRecentTopics']) ? count($this->functionData['hookRecentTopics']) : 0;
$this->functionData['hookRecentTopics'][$count_f71f29a464a97ede3d20591383d4073f]['topics'] = $topics;
}
$IPBHTML .= "" . ((is_array( $topics ) && count( $topics )) ? ("
<div class='ipsSideBlock clearfix'>
	<h3>{$this->lang->words['recently_added_topics']}</h3>
	<div class='_sbcollapsable'>
		<ul class='ipsList_withminiphoto'>
		".$this->__f__828244427888fe2b45f769da51c72fd2($topics)."		</ul>
	</div>
</div>
") : ("")) . "";
return $IPBHTML;
}


function __f__828244427888fe2b45f769da51c72fd2($topics)
{
	$_ips___x_retval = '';
	$__iteratorCount = 0;
	foreach( $topics as $r )
	{
		
		$__iteratorCount++;
		$_ips___x_retval .= "
		<li class='clearfix'>
			" . ( method_exists( $this->registry->getClass('output')->getTemplate('global'), 'userSmallPhoto' ) ? $this->registry->getClass('output')->getTemplate('global')->userSmallPhoto($r) : '' ) . "
			<div class='list_content'>
				<a href=\"" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "showtopic={$r['tid']}", "public",'' ), "{$r['title_seo']}", "showtopic" ) . "\" rel='bookmark' class='ipsType_small' title='" . strip_tags($r['topic_title']) . " {$this->lang->words['topic_started_on']} " . IPSText::htmlspecialchars($this->registry->getClass('class_localization')->getDate($r['start_date'],"LONG", 0)) . "'>{$r['topic_title']}</a>
				<p class='desc ipsType_smaller'>
					" . (($r['members_display_name']) ? ("" . ( method_exists( $this->registry->getClass('output')->getTemplate('global'), 'userHoverCard' ) ? $this->registry->getClass('output')->getTemplate('global')->userHoverCard($r) : '' ) . "") : ("{$this->settings['guest_name_pre']}{$r['starter_name']}{$this->settings['guest_name_suf']}")) . "
					- " . IPSText::htmlspecialchars($this->registry->getClass('class_localization')->getDate($r['start_date'],"short", 0)) . "
				</p>
			</div>
		</li>
		
";
	}
	$_ips___x_retval .= '';
	unset( $__iteratorCount );
	return $_ips___x_retval;
}

/* -- hooksos_topicosrecentes_parseTopic --*/
function hooksos_topicosrecentes_parseTopic($r=array()) {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}

/* -- hooksos_topicosrecentes_tema1 --*/
function hooksos_topicosrecentes_tema1($topics=array()) {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}

/* -- hooksos_topicosrecentesAjax_tema1 --*/
function hooksos_topicosrecentesAjax_tema1($topics=array()) {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}

/* -- hookTagCloud --*/
function hookTagCloud($tags) {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}

/* -- statusReplies --*/
function statusReplies($replies=array()) {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}

/* -- statusUpdates --*/
function statusUpdates($updates=array(), $smallSpace=0, $latestOnly=0) {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}

/* -- top_reputation_link --*/
function top_reputation_link($link) {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}

/* -- VNStickyGlobalMessage --*/
function VNStickyGlobalMessage($data) {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}


}


/*--------------------------------------------------*/
/* END OF FILE                                      */
/*--------------------------------------------------*/

?>