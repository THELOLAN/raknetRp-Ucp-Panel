<?php
/*--------------------------------------------------*/
/* FILE GENERATED BY INVISION POWER BOARD 3         */
/* CACHE FILE: Skin set id: 3               */
/* CACHE FILE: Generated: Sat, 25 Jul 2015 17:29:18 GMT */
/* DO NOT EDIT DIRECTLY - THE CHANGES WILL NOT BE   */
/* WRITTEN TO THE DATABASE AUTOMATICALLY            */
/*--------------------------------------------------*/

class skin_topic_3 extends skinMaster{

/**
* Construct
*/
function __construct( ipsRegistry $registry )
{
	parent::__construct( $registry );
	

$this->_funcHooks = array();
$this->_funcHooks['post'] = array('repButtonsLike','canReportPost','canEdit','canDelete','replyButton','canHide');
$this->_funcHooks['show_attachment_title'] = array('attachType','attach');
$this->_funcHooks['Show_attachments'] = array('hasmime');
$this->_funcHooks['topicViewTemplate'] = array('post_data','closedButtonLink');


}

/* -- ajax__deletePost --*/
function ajax__deletePost() {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- ajax__doDeletePost --*/
function ajax__doDeletePost() {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- ajax__restoreTopicDialog --*/
function ajax__restoreTopicDialog() {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- ajaxSharePost --*/
function ajaxSharePost($topic, $post, $url, $sharelinks) {
$IPBHTML = "";
$IPBHTML .= "<!--no data in this master skin-->";
return $IPBHTML;
}

/* -- ajaxSigCloseMenu --*/
function ajaxSigCloseMenu($post) {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- announcement_show --*/
function announcement_show($announce="",$author="") {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- archiveStatusMessage --*/
function archiveStatusMessage($topic, $forum) {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- hookFacebookLike --*/
function hookFacebookLike() {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- likeSummary --*/
function likeSummary($data, $relId, $opts) {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- likeSummaryContents --*/
function likeSummaryContents($data, $relId, $opts=array()) {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- pollDisplay --*/
function pollDisplay($poll, $topicData, $forumData, $pollData, $showResults, $editPoll=1) {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- post --*/
function post($post, $displayData, $topic, $forum=array()) {
$IPBHTML = "";
if( IPSLib::locationHasHooks( 'skin_topic', $this->_funcHooks['post'] ) )
{
$count_cbcba88cb5288c9464d931eab69c99c7 = is_array($this->functionData['post']) ? count($this->functionData['post']) : 0;
$this->functionData['post'][$count_cbcba88cb5288c9464d931eab69c99c7]['post'] = $post;
$this->functionData['post'][$count_cbcba88cb5288c9464d931eab69c99c7]['displayData'] = $displayData;
$this->functionData['post'][$count_cbcba88cb5288c9464d931eab69c99c7]['topic'] = $topic;
$this->functionData['post'][$count_cbcba88cb5288c9464d931eab69c99c7]['forum'] = $forum;
}
$IPBHTML .= "<post>
					<id>{$post['post']['pid']}</id>
					<date>" . IPSText::htmlspecialchars($this->registry->getClass('class_localization')->getDate($post['post']['post_date'],"DATE", 0)) . "</date>
					<url>" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "showtopic={$post['post']['topic_id']}&amp;view=findpost&amp;p={$post['post']['pid']}", "public",'' ), "{$topic['title_seo']}", "showtopic" ) . "</url>
					<text><![CDATA[
									{$post['post']['post']}{$post['post']['attachmentHtml']}
						]]>	
					</text>
					<reputation>{$post['post']['rep_points']}</reputation>
					<user>
		" . (($post['author']['member_id']) ? ("
						<id>{$post['author']['member_id']}</id>
						<name><![CDATA[{$post['author']['members_display_name']}]]></name>
						<avatar><![CDATA[{$post['author']['pp_thumb_photo']}]]></avatar>
						<url><![CDATA[" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "showuser={$post['author']['member_id']}", "public",'' ), "{$post['author']['members_seo_name']}", "showuser" ) . "]]></url>
						<online>{$post['author']['_online']}</online>
						" . ( method_exists( $this->registry->getClass('output')->getTemplate('global'), 'userInfoPane' ) ? $this->registry->getClass('output')->getTemplate('global')->userInfoPane($post['author'], $post['post']['pid'], array()) : '' ) . "") : ("
						<id>0</id>
						<name><![CDATA[{$post['author']['members_display_name']}]]></name>
		")) . "
					</user>
		<options>
		" . ((! $topic['_isArchived']) ? ("
				" . ( method_exists( $this->registry->getClass('output')->getTemplate('global_other'), 'repButtons' ) ? $this->registry->getClass('output')->getTemplate('global_other')->repButtons($post['author'], array_merge( array( 'primaryId' => $post['post']['pid'], 'domLikeStripId' => 'like_post_' . $post['post']['pid'], 'domCountId' => 'rep_post_' . $post['post']['pid'], 'app' => 'forums', 'type' => 'pid', 'likeFormatted' => $post['post']['like']['formatted'] ), $post['post'] )) : '' ) . "
				") : ("")) . "				
			" . (($topic['_canReport'] and ( $this->memberData['member_id'] ) && ! $topic['_isArchived']) ? ("
			<reportURL><![CDATA[" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "app=core&amp;module=reports&amp;rcom=post&amp;tid={$this->request['t']}&amp;fid={$this->request['f']}&amp;pid={$post['post']['pid']}&amp;st={$this->request['st']}", "public",'' ), "", "" ) . "]]></reportURL>
			") : ("")) . "
			" . (($post['post']['_can_edit'] === TRUE) ? ("
				<editURL><![CDATA[" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "module=post&amp;section=post&amp;do=edit_post&amp;f={$this->request['f']}&amp;t={$this->request['t']}&amp;p={$post['post']['pid']}&amp;st={$this->request['st']}", "publicWithApp",'' ), "", "" ) . "]]></editURL>
			") : ("")) . "
			
			" . (($post['post']['_can_delete'] === TRUE && ! $topic['_isArchived']) ? ("
				<deleteURL><![CDATA[" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "module=moderate&amp;section=moderate&amp;do=postchoice&amp;tact=deletedo&amp;f={$topic['forum_id']}&amp;t={$topic['tid']}&amp;selectedpids[]={$post['post']['pid']}&amp;st={$this->request['st']}&amp;auth_key={$this->member->form_hash}", "publicWithApp",'' ), "", "" ) . "]]></deleteURL>
			") : ("")) . "
			" . (($post['post']['_canReply']) ? ("
				<replyURL><![CDATA[" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "module=post&amp;section=post&amp;do=reply_post&amp;f={$this->request['f']}&amp;t={$this->request['t']}&amp;qpid={$post['post']['pid']}", "publicWithApp",'' ), "", "" ) . "]]></replyURL>
			") : ("")) . "
			" . (($post['post']['_softDelete'] && ! $topic['_isArchived']) ? ("
				<hideURL><![CDATA[" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "module=moderate&amp;section=moderate&amp;do=postchoice&amp;tact=delete&amp;f={$topic['forum_id']}&amp;t={$topic['tid']}&amp;selectedpids[]={$post['post']['pid']}&amp;st={$this->request['st']}&amp;auth_key={$this->member->form_hash}", "publicWithApp",'' ), "", "" ) . "]]></hideURL>
			") : ("")) . "
			
		</options>
					
				</post>";
return $IPBHTML;
}

/* -- quickEditPost --*/
function quickEditPost($post) {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- show_attachment_title --*/
function show_attachment_title($title="",$data="",$type="") {
$IPBHTML = "";
if( IPSLib::locationHasHooks( 'skin_topic', $this->_funcHooks['show_attachment_title'] ) )
{
$count_d240665ca3d006a30e93137d09a5d039 = is_array($this->functionData['show_attachment_title']) ? count($this->functionData['show_attachment_title']) : 0;
$this->functionData['show_attachment_title'][$count_d240665ca3d006a30e93137d09a5d039]['title'] = $title;
$this->functionData['show_attachment_title'][$count_d240665ca3d006a30e93137d09a5d039]['data'] = $data;
$this->functionData['show_attachment_title'][$count_d240665ca3d006a30e93137d09a5d039]['type'] = $type;
}
$IPBHTML .= "<div id='attach_wrap' class='clearfix'>
	<h4>{$title}</h4>
	<ul>
		".$this->__f__fd5a78faa7065ef3e0f51a59027a5335($title,$data,$type)."	</ul>
</div>";
return $IPBHTML;
}


function __f__fd5a78faa7065ef3e0f51a59027a5335($title="",$data="",$type="")
{
	$_ips___x_retval = '';
	$__iteratorCount = 0;
	foreach( $data as $file )
	{
		
		$__iteratorCount++;
		$_ips___x_retval .= "
			<li class='" . (($type == 'attach') ? ("attachment") : ("")) . "'>
				{$file}
			</li>
		
";
	}
	$_ips___x_retval .= '';
	unset( $__iteratorCount );
	return $_ips___x_retval;
}

/* -- Show_attachments --*/
function Show_attachments($data="") {
$IPBHTML = "";
if( IPSLib::locationHasHooks( 'skin_topic', $this->_funcHooks['Show_attachments'] ) )
{
$count_d9be08e227cf853f16ca4d48314cfd42 = is_array($this->functionData['Show_attachments']) ? count($this->functionData['Show_attachments']) : 0;
$this->functionData['Show_attachments'][$count_d9be08e227cf853f16ca4d48314cfd42]['data'] = $data;
}
$IPBHTML .= "<a href=\"" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "app=core&amp;module=attach&amp;section=attach&amp;attach_id={$data['attach_id']}", "public",'' ), "", "" ) . "\" title=\"{$this->lang->words['attach_dl']}\"><img src=\"{$this->settings['public_dir']}" . (($data['mime_image']) ? ("{$data['mime_image']}") : ("style_extra/mime_types/unknown.gif")) . "\" alt=\"{$this->lang->words['attached_file']}\" /></a>
&nbsp;<a href=\"" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "app=core&amp;module=attach&amp;section=attach&amp;attach_id={$data['attach_id']}", "public",'' ), "", "" ) . "\" title=\"{$this->lang->words['attach_dl']}\"><strong>{$data['attach_file']}</strong></a> &nbsp;&nbsp;<span class='desc'><strong>{$data['file_size']}</strong></span>
&nbsp;&nbsp;<span class=\"desc lighter\">{$data['attach_hits']} {$this->lang->words['attach_hits']}</span>";
return $IPBHTML;
}

/* -- Show_attachments_img --*/
function Show_attachments_img($data=array()) {
$IPBHTML = "";
$IPBHTML .= "<a class='resized_img' rel='lightbox[{$data['attach_rel_id']}]' id='ipb-attach-url-{$data['_attach_id']}' href=\"" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "app=core&amp;module=attach&amp;section=attach&amp;attach_rel_module={$data['type']}&amp;attach_id={$data['attach_id']}", "public",'' ), "", "" ) . "\" title=\"{$data['location']} - {$this->lang->words['attach_size']} {$data['file_size']}, {$this->lang->words['attach_ahits']} {$data['attach_hits']}\"><img itemprop=\"image\" src=\"{$this->settings['upload_url']}/{$data['o_location']}\" class='bbc_img linked-image' alt=\"{$this->lang->words['pic_attach']}: {$data['location']}\" /></a>
" . $this->registry->output->addMetaTag( 'og:image', "{$this->settings['upload_url']}/{$data['t_location']}", false ) . "";
return $IPBHTML;
}

/* -- Show_attachments_img_thumb --*/
function Show_attachments_img_thumb($data=array()) {
$IPBHTML = "";
$IPBHTML .= "<a class='resized_img' rel='lightbox[{$data['attach_rel_id']}]' id='ipb-attach-url-{$data['_attach_id']}' href=\"" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "app=core&amp;module=attach&amp;section=attach&amp;attach_rel_module={$data['type']}&amp;attach_id={$data['attach_id']}", "public",'' ), "", "" ) . "\" title=\"{$data['location']} - {$this->lang->words['attach_size']} {$data['file_size']}, {$this->lang->words['attach_ahits']} {$data['attach_hits']}\"><img itemprop=\"image\" src=\"{$this->settings['upload_url']}/{$data['t_location']}\" id='ipb-attach-img-{$data['_attach_id']}' style='width:{$data['t_width']};height:{$data['t_height']}' class='attach' width=\"{$data['t_width']}\" height=\"{$data['t_height']}\" alt=\"{$this->lang->words['pic_attach']}: {$data['location']}\" /></a>
" . $this->registry->output->addMetaTag( 'og:image', "{$this->settings['upload_url']}/{$data['t_location']}", false ) . "";
return $IPBHTML;
}

/* -- softDeletedPostBit --*/
function softDeletedPostBit($post, $sdData, $topic) {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- topicPreview --*/
function topicPreview($topic, $posts) {
$IPBHTML = "";
$IPBHTML .= "<!-- NoData -->";
return $IPBHTML;
}

/* -- topicViewTemplate --*/
function topicViewTemplate($forum, $topic, $post_data, $displayData) {
$IPBHTML = "";
if( IPSLib::locationHasHooks( 'skin_topic', $this->_funcHooks['topicViewTemplate'] ) )
{
$count_17d1718c0af80172fd717ee0a84cff70 = is_array($this->functionData['topicViewTemplate']) ? count($this->functionData['topicViewTemplate']) : 0;
$this->functionData['topicViewTemplate'][$count_17d1718c0af80172fd717ee0a84cff70]['forum'] = $forum;
$this->functionData['topicViewTemplate'][$count_17d1718c0af80172fd717ee0a84cff70]['topic'] = $topic;
$this->functionData['topicViewTemplate'][$count_17d1718c0af80172fd717ee0a84cff70]['post_data'] = $post_data;
$this->functionData['topicViewTemplate'][$count_17d1718c0af80172fd717ee0a84cff70]['displayData'] = $displayData;
}
$IPBHTML .= "" . (($displayData['reply_button']['url']) ? ("
	<AssessoryButtonURL><![CDATA[{$displayData['reply_button']['url']}]]></AssessoryButtonURL>
") : ("")) . "

<template>viewTopic</template>
<pagination>{$topic['SHOW_PAGES']}</pagination>
<forum>
		<name><![CDATA[{$forum['name']}]]></name>
		<id>{$forum['id']}</id>
		<url><![CDATA[" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "showforum={$forum['id']}", "public",'' ), "{{$forum['name_seo']}", "showforum" ) . "]]></url>
		
" . (($forum['show_rules'] == 2) ? ("
		<rules>
			<title>{$forum['rules_title']}</title>
			<text>
				<![CDATA[
						{$forum['rules_text']}
				]]>	
			</text>
		</rules>
") : ("")) . "
" . (($forum_data['show_rules'] == 1) ? ("
		<rules>
			<title><![CDATA[{$forum['rules_title']}]]></title>
			<url><![CDATA[" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "showforum={$forum['id']}&amp;act=SR", "public",'' ), "", "" ) . "]]></url>
		</rules>
") : ("")) . "
	
		<topic>
			<id>{$topic['tid']}</id>
			<title><![CDATA[{$topic['title']}]]></title>
			<description><![CDATA[{$topic['description']}]]></description>
			<url><![CDATA[" . $this->registry->getClass('output')->formatUrl( $this->registry->getClass('output')->buildUrl( "showtopic={$topic['tid']}", "public",'' ), "{$topic['title_seo']}", "showtopic" ) . "]]></url>			
			<posts>				
" . ((is_array( $post_data ) AND count( $post_data )) ? ("".$this->__f__4fc824c3074492587c1576160db39db5($forum,$topic,$post_data,$displayData)."") : ("")) . "
			</posts>
		</topic>
	</forum>";
return $IPBHTML;
}


function __f__4fc824c3074492587c1576160db39db5($forum, $topic, $post_data, $displayData)
{
	$_ips___x_retval = '';
	$__iteratorCount = 0;
	foreach( $post_data as $pid => $post )
	{
		
		$__iteratorCount++;
		$_ips___x_retval .= "
						" . ( method_exists( $this->registry->getClass('output')->getTemplate('topic'), 'post' ) ? $this->registry->getClass('output')->getTemplate('topic')->post($post, $displayData, $topic, $forum) : '' ) . "
					
	
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