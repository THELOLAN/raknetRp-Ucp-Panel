
--------------------------------------------------------------------------------
> Time: 1415628377 / Mon, 10 Nov 2014 14:06:17 +0000
> URL: /admin/index.php?adsess=c56f5ccb0e1ea9a55889b95d84a98c87&app=core&&module=templates&section=importexport&do=exportSet
> Template Export: members
<?xml version="1.0" encoding="utf-8"?>
<templates application="members" templategroups="a:5:{s:14:&quot;skin_messaging&quot;;s:5:&quot;exact&quot;;s:10:&quot;skin_mlist&quot;;s:5:&quot;exact&quot;;s:11:&quot;skin_online&quot;;s:5:&quot;exact&quot;;s:12:&quot;skin_profile&quot;;s:5:&quot;exact&quot;;s:8:&quot;skin_ucp&quot;;s:5:&quot;exact&quot;;}">
  <templategroup group="skin_messaging">
    <template>
      <template_group>skin_messaging</template_group>
      <template_content><![CDATA[{parse js_module="messenger"}
<script type="text/javascript">
	ipb.messenger.disabled  = {parse expression="intval($this->memberData['members_disable_pm'])"};
</script>
<if test="PMDisabled:|:$this->memberData['members_disable_pm']">
<noscript>
	{parse template="messengerDisabled" group="messaging"}
</noscript>
</if>
<div id='messenger_utilities' class='left'>
	<!-- Show topic participants -->
	<if test="hasParticipants:|:is_array( $topicParticipants ) and count( $topicParticipants )">
		<div class='ipsSideBlock' id='participants'>
			<h3>{$this->lang->words['participants']}</h3>
			<ul id='participants_list' class='ipsList_withminiphoto fullList'>
				<foreach loop="participants:$topicParticipants as $memberID => $memberData">
					<li class='clearfix'>
						<if test="isMemberPartOpen:|:$memberData['member_id']"><a href='{parse url="showuser={$memberData['member_id']}" seotitle="{$memberData['members_seo_name']}" template="showuser" base="public"}' title='{$this->lang->words['view_profile']}' class='ipsUserPhotoLink left'></if><img src='http://mercury.raknet.ru/templates/style/img/avatars/{$memberData['Char']}.png' alt='{$this->lang->words['photo']}' class='ipsUserPhoto ipsUserPhoto_mini <if test="isMemberPartFloat:|:!$memberData['member_id']"> left</if>' /><if test="isMemberPartClose:|:$memberData['member_id']"></a></if>
						<p class='list_content'>
							<if test="userIsActive:|:$memberData['map_user_active']">
								<if test="userIsStarter:|:$memberData['map_is_starter']">
									<span class='name starter'>{parse template="userHoverCard" group="global" params="$memberData"}</span>
								<else />
									<span class='name'>{parse template="userHoverCard" group="global" params="$memberData"}</span>
								</if>
								<br />
								<span class='ipsType_smaller desc'>
									<if test="messageIsDeleted:|:$memberData['_topicDeleted']">
										<em>{$this->lang->words['topic_deleted']}</em>
									<else />
										{$this->lang->words['last_read']}
										<if test="lastReadTime:|:$memberData['map_read_time']">
											{parse date="$memberData['map_read_time']" format="short"}
										<else />
											<em>{$this->lang->words['not_yet_read']}</em>
										</if>
									</if>
									<if test="notification:|:$memberData['map_ignore_notification']">
										<span class='ipsBadge ipsBadge_lightgrey right'>{$this->lang->words['msg_no_notify']}</span>
									</if>						
								</span>
								<if test="blockUserLink:|:! $memberData['map_is_starter'] AND $memberData['_canBeBlocked'] AND ($topicParticipants[ $this->memberData['member_id'] ]['map_is_starter'] OR $this->memberData['g_is_supmod']) AND ( $memberData['map_user_id'] != $this->memberData['member_id'] ) AND !$memberData['_topicDeleted']">
									<br /><a href="{parse url="module=messaging&amp;section=view&amp;do=blockParticipant&amp;topicID={$this->request['topicID']}&amp;memberID={$memberData['map_user_id']}&amp;authKey={$this->member->form_hash}" base="publicWithApp"}" title='{$this->lang->words['block_this_user']}' class='cancel'>{$this->lang->words['block']}</a>
								</if>
							<else />
								<if test="userIsBanned:|:$memberData['map_user_banned']">
									<span class='name blocked'><a href='{parse url="showuser={$memberData['member_id']}" seotitle="{$memberData['members_seo_name']}" template="showuser" base="public"}' title='{$this->lang->words['view_profile']}'><strong>{$memberData['members_display_name_short']}</strong></a></span>
									<br />
									<span class='desc'>{$this->lang->words['user_is_blocked']}</span>
									<br />
									<if test="unbanUserLink:|:$memberData['_canBeBlocked'] AND ($topicParticipants[ $this->memberData['member_id'] ]['map_is_starter'] OR $this->memberData['g_is_supmod'])">
										<a href="{parse url="module=messaging&amp;section=view&amp;do=unblockParticipant&amp;topicID={$this->request['topicID']}&amp;memberID={$memberData['map_user_id']}&amp;authKey={$this->member->form_hash}" base="publicWithApp"}" title='{$this->lang->words['unblock_this_user']}' class='cancel'>{$this->lang->words['unblock']}</a>
									</if>
								<else />
									<span class='name left_convo'><a href='{parse url="showuser={$memberData['member_id']}" seotitle="{$memberData['members_seo_name']}" template="showuser" base="public"}' title='{$this->lang->words['view_profile']}'><strong>{$memberData['members_display_name_short']}</strong></a></span>
									<br />
									<span class='desc'>
										<if test="topicUnavailable:|:$memberData['_topicDeleted']">
										<em>{$this->lang->words['topic_deleted']}</em>
										<else />
											<if test="systemMessage:|:$memberData['map_is_system']">
												{$this->lang->words['is_unable_part']}
											<else />
												{$this->lang->words['has_left_convo']}
											</if>
										</if>
									</span>
								</if>
							</if>
						</p>
					</li>
				</foreach>					
			</ul>
			<ul class='post_controls'>
				<li>
					<a href='{parse url="module=messaging&amp;section=view&amp;do=toggleNotifications&amp;topicID={$this->request['topicID']}&amp;authKey={$this->member->form_hash}" base="publicWithApp"}' title='{$this->lang->words['toggle_noti_title']}'>
					<if test="changeNotifications:|:$topicParticipants[ $this->memberData['member_id'] ]['map_ignore_notification']">
						{$this->lang->words['turn_noti_on']}
					<else />
						{$this->lang->words['turn_noti_off']}
					</if>
					</a>
				</li>
			</ul>
		</div>
		<if test="inviteMoreParticipants:|:$this->memberData['g_max_mass_pm'] && count( $topicParticipants ) < $this->memberData['g_max_mass_pm'] && ! $deletedTopic">
			<div id='invite_more' class='ipsSideBlock'>
				<h3>{$this->lang->words['invite_part']}</h3>
				<div id='invite_more_dialogue'>
					<form method='post' action='{parse url="app=members&amp;module=messaging&amp;section=view&amp;do=addParticipants" base="public"}'>
					<input type='hidden' name='authKey' value='{$this->member->form_hash}' />
					<input type='hidden' name='topicID' value='{$this->request['topicID']}' />
					<input type='hidden' name='st' value='{$this->request['st']}' />
					<ul><li><label for='invite_more_autocomplete'>{$this->lang->words['enter_member_names']}</label> 
					<input type='text' class='input_text' name='inviteNames' id='invite_more_autocomplete' value='{$this->request['inviteNames']}' size='38' /> 
					<br /><span class='desc'>[x]{$this->lang->words['separated_with_commas']}</span> 
					</li></ul><fieldset class='submit'><input type='submit' class='input_submit' value='{$this->lang->words['part_add']}' />  
					{$this->lang->words['or']} <a href='#' id='invite_more_cancel' class='cancel' title='{$this->lang->words['cancel']}'>{$this->lang->words['cancel']}</a></fieldset></form>
				</div>
				<div id='invite_more_default'>
					<if test="unlimitedInvites:|:$this->memberData['g_max_mass_pm'] == 0">
						<p class='desc'>{$this->lang->words['can_invite_unlimited']}</p>
						<script type='text/javascript'>
							ipb.messenger.invitesLeft = parseInt( 0 );
							ipb.messenger.nameText = ipb.lang['enter_unlimited_names'];
						</script>
					<else />
						<p class='desc'>{$this->lang->words['may_invite_upto']} <strong>{parse expression="( $this->memberData['g_max_mass_pm'] - count( $topicParticipants ) )"}</strong> {$this->lang->words['more_members']}</p>
						<script type='text/javascript'>
							ipb.messenger.invitesLeft = parseInt( {parse expression="( $this->memberData['g_max_mass_pm'] - count( $topicParticipants ) )"} );
							ipb.messenger.nameText = ipb.lang['enter_x_names'].gsub(/\[x\]/, ipb.messenger.invitesLeft);
						</script>
					</if>
					<ul class='post_controls'>
						<li id='add_participants'><a href='#' title='{$this->lang->words['add_participants']}'>{$this->lang->words['part_add']}</a></li>
					</ul>
				</div>
			</div>
		</if>
	</if>
	<div id='folder_list' class='ipsSideBlock'>
		<h3>{$this->lang->words['folders']}</h3>
		<ol id='folders'>
			<if test="myDirectories:|:count($dirData)">
				<foreach loop="dirs:$dirData as $id => $data">
					<if test="protectedFolder:|:$data['protected']">
						<li class='folder protected' id='f_{$id}'>{parse replacement="folder_{$id}"}
					<else />
						<li class='folder' id='f_{$id}'>{parse replacement="folder_generic"}
					</if>
					<a href="{parse url="module=messaging&amp;section=view&amp;do=showFolder&amp;folderID={$id}" base="publicWithApp"}" title="{$this->lang->words['go_to_folder']}" rel="folder_name">{$data['real']}</a>
					<span class='total rounded'>
						<if test="allFolder:|:$id == 'all'">
							{parse expression="intval($this->memberData['msg_count_total'])"}
						<else />
							{parse expression="intval($data['count'])"}
						</if>
					</span>
					<if test="unprotectedFolder:|:! $data['protected']">
						<span class='edit_folders' style='display: none'><a href='#' id='delete_{$id}' class='f_delete' title="{$this->lang->words['delete_folder_title']}">{parse replacement="folder_delete"}</a> <a href='#' id='empty_{$id}' class='f_empty' title="{$this->lang->words['empty_folder_title']}">{parse replacement="folder_empty"}</a></span></li>
					<else />
						<span class='edit_folders' style='display: none'><a href='#' id='empty_{$id}' class='f_empty' title="{$this->lang->words['empty_folder_title']}">{parse replacement="folder_empty"}</a></span></li>
					</if>
				</foreach>
			</if>
		</ol>
		<div class='clearfix post_controls'>
			<ul class='post_controls'>
				<li id='add_folder'><a href='#' title='{$this->lang->words['add_folder']}'>{$this->lang->words['folder_add']}</a></li>
				<li id='edit_folders'><a href='#' title='{$this->lang->words['edit_folders']}'>{$this->lang->words['folders_edit']}</a></li>
			</ul>
		</div>
		<script type='text/javascript'>
		//<!#^#|CDATA|
			ipb.messenger.folderTemplate = "<li class='folder' id='f_[id]'>{parse replacement="folder_generic"} <a href='{parse url="module=messaging&amp;section=view&amp;do=showFolder&amp;folderID=[id]" base="publicWithApp"}' title='{$this->lang->words['go_to_folder']}' rel='folder_name'>[name]</a> <span class='total rounded'>[total]</span><span class='edit_folders' style='display: none'><a href='#' id='delete_[id]' class='f_delete' title='{$this->lang->words['delete_folder_title']}'>{parse replacement="folder_delete"}</a> <a href='#' id='empty_[id]' class='f_empty' title='{$this->lang->words['empty_folder_title']}'>{parse replacement="folder_empty"}</a></span></li>";
		//|#^#]>
		</script>
	</div>
	<if test="storageBar:|:$this->memberData['g_max_messages'] > 0">
		<div id='space_allowance' class='ipsSideBlock'>
			<h3>{$this->lang->words['storage']}</h3>
			<p>{$this->lang->words['your_messenger_storage']}</p>
			<p class='progress_bar' title='{parse expression="sprintf( $this->lang->words['pmpc_full_string'], $totalData['full_percent'] )"}' <if test="almostFull:|:$totalData['full_percent'] > 80">class='limit'</if>>
				<span style='width: {$totalData['full_percent']}%'>{$totalData['full_percent']}%</span>
			</p>
			<p>
				<span class='desc'>{$totalData['full_percent']}% {$this->lang->words['of_your_quota']} ({$this->memberData['g_max_messages']} {$this->lang->words['messages']})</span>
			</p>
		</div>
	</if>
	<div id='message_search' class='ipsSideBlock'>
		<h3>{$this->lang->words['search_messages']}</h3>
		<form action='{$this->settings['base_url']}app=members&amp;module=messaging&amp;section=search' method='post'>
			<fieldset>
				<input type='text' name='searchFor' class='input_text' size='15' style='width: 60%' /> <input type='submit' class='input_submit' value='{$this->lang->words['jmp_go']}' />
			</fieldset>
		</form>
	</div>
	<br />
	
	<a class='ipsButton_secondary cancel' href="{parse url="module=messaging&amp;section=view&amp;do=disableMessenger&amp;authKey={$this->member->form_hash}" base="publicWithApp"}"'>{$this->lang->words['disable_messenger']}</a>
	<!--<ul class='topic_buttons'>
		<li class='important'></li>
	</ul>-->
</div>
<div id='messenger_content' class='right'>
	<if test="inlineError:|:$inlineError">
	<div class='message error'>
		<h4>{$inlineError}</h4>
	</div>
	<br />
	</if>
	{$html}
</div>
<!-- end -->
<div id='pmDisabled' style='display:none'>
	{parse template="messengerDisabled" group="messaging"}
</div>
<br class='clear' />]]></template_content>
      <template_name>messengerTemplate</template_name>
      <template_data><![CDATA[$html, $jumpmenu, $dirData, $totalData=array(), $topicParticipants=array(), $inlineError='', $deletedTopic=0]]></template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_messaging</template_group>
      <template_content><![CDATA[<div id='message_compose' class='post_form'>
	<form id='msgForm' style='display:block' action="{parse url="module=messaging&amp;section=send&amp;do=send" base="publicWithApp"}" method="post" enctype='multipart/form-data'>
	
<if test="newTopicPreview:|:$displayData['preview']">
	{parse replacement="header_start"}<h3 class='maintitle'>{$this->lang->words['pm_preview']}</h3>{parse replacement="header_end"}
	<div class='post_wrap' id='post_preview'>
		<div class='row2' style='padding:8px'>
			<div class='post entry-content'>{$displayData['preview']}</div>
		</div>
	</div>{parse replacement="box_end"}
	<br />
</if>
{parse replacement="header_start"}<h3 class='maintitle'>{$this->lang->words['mess_new']}</h3>{parse replacement="header_end"}
<if test="newTopicError:|:is_array($displayData['errors']) AND count($displayData['errors'])">
<div class='ipsPad'>
<div class='message error'>
	<h4>{$this->lang->words['err_errors']}</h4>
	<foreach loop="newtopicerrors:$displayData['errors'] as $_error">
		<p>{$_error}</p>
	</foreach>
	<p>{$this->lang->words['pme_none_sent']}</p>
</div>
</div>
</if>
<div class='ipsBox removeDefault'>
	<div class='ipsBox_container'>
		<fieldset>
			<h3 class='bar'>{$this->lang->words['pro_recips']}</h3>
			<ul>
				<li class='field'>
					<label for='entered_name'>{$this->lang->words['to_whom']}</label>
					<input type="text" class='input_text' id='entered_name' name="entered_name" size="30" value="{$displayData['name']}" tabindex="1" />
				</li>
				<if test="newTopicInvite:|:intval($this->memberData['g_max_mass_pm'])">
					<li class='field'>
						<label for='more_members'>{$this->lang->words['other_recipients']}</label>
						<input type='text' size="50" class='input_text' name='inviteUsers' value='{$displayData['inviteUsers']}' id='more_members' tabindex='2' />
						<span class='desc'>{$this->lang->words['youmay_add_to']} <strong>{$this->memberData['g_max_mass_pm']}</strong> {$this->lang->words['youmay_suffix']}</span>
					</li>
					<li class='field'>
						<label for='send_type'>{$this->lang->words['send_to_as']}</label>
						<select name='sendType' id='send_type' tabindex='3'>
							<option value='invite'<if test="formReloadInvite:|:$this->request['sendType']=='invite'"> selected='selected'</if>>{$this->lang->words['send__invite']}</option>
							<option value='copy'<if test="formReloadCopy:|:$this->request['sendType']=='copy'"> selected='selected'</if>>{$this->lang->words['send__copy']}</option>
						</select>
						<span class='desc'>
							<strong>{$this->lang->words['send__invite']}</strong> {$this->lang->words['invite__desc']}<br />
							<strong>{$this->lang->words['send__copy']}</strong> {$this->lang->words['copy__desc']}
						</span>
					</li>				
				</if>
			</ul>
		</fieldset>
		<fieldset>
			<h3 class='bar'>{$this->lang->words['pro_message']}</h3>
			<ul>
				<li class='field'>
					<label for='message_subject'>{$this->lang->words['message_subject_send']}</label>
					<input type="text" name="msg_title" id='message_subject' class='input_text' size="40" tabindex="4" maxlength="40" value="{$displayData['title']}" />
				</li>
				<li style='padding: 10px;'>
					{$displayData['editor']}
				</li>
			</ul>
		</fieldset>
		
		<if test="newTopicUploads:|:$displayData['uploadData']['canUpload']">
		<fieldset class='attachments'>
			{parse template="uploadForm" group="post" params="$displayData['postKey'], 'msg', $displayData['uploadData']['attach_stats'], 0"}
		</fieldset>
		</if>
		<input type='hidden' name='topicID' value="{$displayData['topicID']}" />
		<input type='hidden' name="postKey" value="{$displayData['postKey']}" />
		<input type="hidden" name="auth_key" value="{$this->member->form_hash}" />
		<fieldset class='submit'>
			<input class='input_submit' name="dosubmit" type="submit" value="{$this->lang->words['submit_send']}" tabindex="50" accesskey="s" />
			<input class='input_submit alt' type="submit" value="{$this->lang->words['pm_pre_button']}" tabindex="51" name="preview" />
			<input class='input_submit alt' type="submit" value="{$this->lang->words['pms_send_later']}" tabindex="52" name="save" />
			{$this->lang->words['or']} <a href='{parse url="app=members&amp;module=messaging" base="public"}' title='{$this->lang->words['cancel']}' class='cancel' tabindex='53'>{$this->lang->words['cancel']}</a>
		</fieldset>
	</div>
</div>{parse replacement="box_end"}
</form>
</div>
{parse template="include_highlighter" group="global" params=""}
<br />]]></template_content>
      <template_name>sendNewPersonalTopicForm</template_name>
      <template_data>$displayData</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_messaging</template_group>
      <template_content><![CDATA[<div id='message_compose' class='post_form'>
	<if test="replyForm:|:$displayData['type'] == 'reply'">
		<form id='msgForm' style='display:block' action="{parse url="module=messaging&amp;section=send&amp;do=sendReply" base="publicWithApp"}" method="post" name="REPLIER">
	<else />
		<form id='msgForm' style='display:block' action="{parse url="module=messaging&amp;section=send&amp;do=sendEdit" base="publicWithApp"}" method="post" name="REPLIER">
	</if>
		<input type="hidden" name="msgID" value="{$displayData['msgID']}" />
	<input type='hidden' name='topicID' value="{$displayData['topicID']}" />
	<input type='hidden' name="postKey" value="{$displayData['postKey']}" />
	<input type="hidden" name="authKey" value="{$this->member->form_hash}" />
	{$data['upload']}	
<if test="previewPm:|:$displayData['preview']">
	{parse replacement="header_start"}<h3 class='maintitle'>{$this->lang->words['pm_preview']}</h3>{parse replacement="header_end"}
	<div class='post_wrap' id='post_preview'>
		<div class='row2' style='padding:8px'>
			<div class='post entry-content'>{$displayData['preview']}</div>
		</div>
	</div>{parse replacement="box_end"}
	<br />
</if>

<if test="formErrors:|:$displayData['errors']">
<div class='message error'>
    <h4>{$this->lang->words['err_errors']}</h4>
    <foreach loop="replyerrors:$displayData['errors'] as $_error">
        <p>{$_error}</p>
    </foreach>
    <p>{$this->lang->words['pme_none_sent']}</p>
</div><br />
</if>

{parse replacement="header_start"}<h3 class='maintitle'>
	<if test="formHeaderText:|:$displayData['type'] == 'reply'">
		{$this->lang->words['compose_reply']}
	<else />
		{$this->lang->words['editing_message']}
	</if>
</h3>{parse replacement="header_end"}
<div class='ipsBox'>
	<div class='ipsBox_container'>
		<fieldset>
			<ul>
				<li>
					{$displayData['editor']}
				</li>
			</ul>
		</fieldset>
		
		<if test="attachmentForm:|:$displayData['uploadData']['canUpload']">
		<fieldset class='attachments'>
			{parse template="uploadForm" group="post" params="$displayData['postKey'], 'msg', $displayData['uploadData']['attach_stats'], $displayData['msgID'], 0"}
		</fieldset>
		</if>
		
		<fieldset class='submit'>
			<if test="replyOptions:|:$displayData['type'] == 'reply'">
				<input class='input_submit' type="submit" value="{$this->lang->words['submit_send']}" tabindex="50" accesskey="s" />
				<input class='input_submit alt' type="submit" value="{$this->lang->words['pm_pre_button']}" tabindex="51" name="previewReply" />
				{$this->lang->words['or']} <a href='{parse url="app=members&amp;module=messaging&amp;do=showConversation&amp;topicID={$displayData['topicID']}" base="public"}' title='{$this->lang->words['cancel']}' class='cancel' tabindex='52'>{$this->lang->words['cancel']}</a>
			<else />
				<input class='input_submit' type="submit" value="{$this->lang->words['save_message_button']}" tabindex="50" accesskey="s" />
				<input class='input_submit alt' type="submit" value="{$this->lang->words['pm_pre_button']}" tabindex="51" name="previewReply" />
				{$this->lang->words['or']} <a href='{parse url="app=members&amp;module=messaging&amp;section=view&amp;do=showConversation&amp;topicID={$displayData['topicID']}" base="public"}' title='{$this->lang->words['cancel']}' class='cancel' tabindex='52'>{$this->lang->words['cancel']}</a>
			</if>
			
		</fieldset>
	</div>
</div>{parse replacement="box_end"}
</form>
</div>
<br />]]></template_content>
      <template_name>sendReplyForm</template_name>
      <template_data>$displayData</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_messaging</template_group>
      <template_content><![CDATA[<if test="disablelightbox:|:!$this->settings['disable_lightbox']">
{parse template="include_lightbox" group="global" params=""}
</if>
{parse template="include_highlighter" group="global" params="1"}
{parse js_module="topic"}
<script type="text/javascript">
//<!#^#|CDATA|
	ipb.topic.inSection = 'messenger';
//|#^#]>
</script>
<div id='conversation'>
<div class='topic_controls clearfix'>
	{$topic['_pages']}
	<ul class='topic_buttons'>
		<li><a href='{parse url="module=messaging&amp;section=send&amp;do=form" base="publicWithApp"}' title='{$this->lang->words['go_to_compose']}'>{$this->lang->words['compose_new']}</a></li>
 		<li class='important'><a id='pm_delete_t_{$topic['mt_id']}' href='{parse url="module=messaging&amp;section=view&amp;do=deleteConversation&amp;topicID={$topic['mt_id']}&amp;authKey={$this->member->form_hash}" base="publicWithApp"}'>{$this->lang->words['option__delete']}</a></li>
	</ul>
	<script type='text/javascript'>
		$('pm_delete_t_{$topic['mt_id']}').observe('click', ipb.messenger.deletePM.bindAsEventListener( this, {$topic['mt_id']} ) );
	</script>
</div>
{parse replacement="header_start"}<h3 class='maintitle'>{$topic['mt_title']}</h3>{parse replacement="header_end"}
<div class='ipsBox removeDefault'>
	<div class='ipsBox_container'>
		<foreach loop="replies:$replies as $msg_id => $msg">
			<a id='msg{$msg['msg_id']}'></a>
			<div class='post_block first hentry column_view' id='post_id_{$msg['msg_id']}'>
				<div class='post_wrap'>
					<if test="hasAuthorId:|:$members[ $msg['msg_author_id'] ]['member_id']">
						<h3>
					<else />
						<h3>
					</if>
							<div class='post_username'><if test="authorOnline:|:$members[ $msg['msg_author_id'] ]['member_id']">
								<span class="author vcard">{parse template="userHoverCard" group="global" params="$members[ $msg['msg_author_id'] ]"}</span>
							<else />
								{$members[ $msg['msg_author_id'] ]['members_display_name']}
							</if></div><div class='post_date'>{$this->lang->words['pc_sent']} {parse date="$msg['msg_date']" format="long"}</div>
							<if test="authorIpAddress:|:$msg['_ip_address'] != ''">
								<span class='ip right ipsType_small'>({$this->lang->words['ip']}:
								<if test="authorPrivateIp:|:$members[ $msg['msg_author_id'] ]['g_access_cp']">
									<em>{$this->lang->words['ip_private']}</em>
								<else />
									<if test="accessModCP:|:$this->memberData['g_is_supmod']"><a href="{parse url="app=core&amp;module=modcp&amp;fromapp=members&amp;tab=iplookup&amp;ip={$msg['_ip_address']}" base="public"}" title='{$this->lang->words['find_info_about_ip']}'>{$msg['_ip_address']}</a><else />{$msg['_ip_address']}</if>
								</if>
								)</span>
							</if>
						</h3>
					<div class='author_info'>
						{parse template="userInfoPane" group="global" params="$members[ $msg['msg_author_id'] ], $msg_id, array()"}
					</div>
					<div class='post_body'>
						<div class='post entry-content'>
							{$msg['msg_post']}
							{$msg['attachmentHtml']}
						</div>
						<if test="viewSigs:|:$this->memberData['view_sigs'] AND $members[ $msg['msg_author_id'] ]['signature']">
							{parse template="signature_separator" group="global" params="$members[ $msg['msg_author_id'] ]['signature'], $msg['msg_author_id'], IPSMember::isIgnorable( $members[ $msg['msg_author_id'] ]['member_group_id'], $members[ $msg['msg_author_id'] ]['mgroup_others'] )"}
						</if>
						<ul class='post_controls clearfix clear'>
							<if test="quickReply:|:$topic['_canReply'] AND empty( $topic['_everyoneElseHasLeft'] )">
								<li>
									<a href="{parse url="module=messaging&amp;section=send&amp;do=replyForm&amp;topicID={$topic['mt_id']}&amp;msgID={$msg['msg_id']}" base="publicWithApp"}" title="{$this->lang->words['tt_reply_to_post']}"><img src="{style_images_url}/comment_new.png" alt="" /> {$this->lang->words['pc_reply']}</a>
								</li>
							</if>
							<if test="reportPm:|:$topic['_canReport'] and $this->memberData['member_id']">
								<li class='report'>
									<a href='{parse url="app=core&amp;module=reports&amp;rcom=messages&amp;topicID={$this->request['topicID']}&amp;st={$this->request['st']}&amp;msg={$msg['msg_id']}" base="public"}'><img src="{style_images_url}/report.png" alt="" /> {$this->lang->words['pc_report']}</a>
								</li>
							</if>
							<if test="canEdit:|:$msg['_canEdit'] === TRUE">
								<li class='post_edit' id='edit_post_{$msg['msg_id']}'>
									<a href='{parse url="module=messaging&amp;section=send&amp;do=editMessage&amp;topicID={$topic['mt_id']}&amp;msgID={$msg['msg_id']}" base="publicWithApp"}' title='{$this->lang->words['edit_this_post']}'><img src="{style_images_url}/comment_edit.png" alt="" /> {$this->lang->words['pc_edit']}</a>
								</li>
							</if>
							<if test="canDelete:|:$msg['_canDelete'] === TRUE && $msg['msg_is_first_post'] != 1">
								<li class='post_del' id='del_post_{$msg['msg_id']}'>
									<a href='{parse url="module=messaging&amp;section=send&amp;do=deleteReply&amp;topicID={$topic['mt_id']}&amp;msgID={$msg['msg_id']}&amp;authKey={$this->member->form_hash}" base="publicWithApp"}' title='{$this->lang->words['delete_this_post']}' class='delete_post'><img src="{style_images_url}/comment_delete.png" alt="" /> {$this->lang->words['pc_delete']}</a>
								</li>
							</if>
						</ul>
					</div>
				</div>
			</div>
		</foreach>
	</div>
</div>{parse replacement="box_end"}

<div class='topic_controls clear'>
    {$topic['_pages']}
    <ul class='topic_buttons'>
         <li class='non_button'> <a id='email_convo_{$this->request['topicID']}' data-tooltip='{parse expression="sprintf( $this->lang->words['msg_email_convo_text'], $this->memberData['email'])"}' href='#' class='email_convo'>{$this->lang->words['msg_email_convo']}</a> </li>
    </ul>
</div>

<if test="allAlone:|: ! empty( $topic['_everyoneElseHasLeft'] )">
<div class='ipsBox'>
	<div class='ipsBox_container ipsPad'>
		<h1 class='ipsType_subtitle'>{$this->lang->words['msg_all_alone_title']}</h1>
		<p>{$this->lang->words['msg_all_alone_desc']}</p>
	</div>
</div>
<else />
	<if test="canReplyEditor:|:$topic['_canReply']">
{parse replacement="header_start"}<h3 class='maintitle'>{$this->lang->words['pc_fast_reply']}</h3>{parse replacement="header_end"}
	<div class='ipsBox removeDefault'>
		<div class='ipsBox_container ipsPad'>
			<a href="{parse url="showuser={$this->memberData['member_id']}" seotitle="{$this->memberData['members_seo_name']}" template="showuser" base="public"}" title='{$this->lang->words['your_profile']}' class='ipsUserPhotoLink left'><img src='http://mercury.raknet.ru/templates/style/img/avatars/{$this->memberData['Char']}.png' alt="{parse expression="sprintf($this->lang->words['users_photo'],$this->memberData['members_display_name'])"}" class='ipsUserPhoto ipsUserPhoto_medium' /></a>
			<div class='ipsBox_withphoto clearfix'>
				<form action='{parse url="app=members&amp;module=messaging&amp;section=send&amp;do=sendReply&amp;topicID={$topic['mt_id']}" base="public"}' method='post'>
					<input type="hidden" name="authKey" value="{$this->member->form_hash}" />
					<input type="hidden" name="fast_reply_used" value="1" />
					<input type="hidden" name="enableemo" value="yes" />
					<input type="hidden" name="enablesig" value="yes" />
					{parse editor="msgContent" options="array( 'type' => 'full', 'minimize' => 1 )"}
					<br />
					<fieldset class='right'>
						<input type='submit' name="submit" class='input_submit' value='{$this->lang->words['pc_post_button']}' tabindex='50' accesskey='s' />&nbsp;&nbsp;<input type='submit' name="previewReply" class='input_submit alt' value='{$this->lang->words['pc_use_full_reply']}' tabindex='51' />
					</fieldset>
				</form>
			</div>
		</div>
	</div>
{parse replacement="box_end"}
	</if>
</if>
</div>
{parse template="include_highlighter" group="global" params=""}]]></template_content>
      <template_name>showConversation</template_name>
      <template_data><![CDATA[$topic, $replies, $members, $jump=""]]></template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_messaging</template_group>
      <template_content><![CDATA[<script type='text/javascript'>
	ipb.messenger.curFolder = '{$currentFolderID}';
</script>
<div class='topic_controls'>
{$pages}
<if test="folderNotDrafts:|:$currentFolderID != 'drafts'">
	{parse variable="folder_all" default=""}
	{parse variable="folder_all" oncondition="$this->request['folderFilter'] == 'all' OR ! $this->request['folderFilter']" value="selected='selected'"}
	{parse variable="folder_in" default=""}
	{parse variable="folder_in" oncondition="$this->request['folderFilter'] == 'in'" value="selected='selected'"}
	{parse variable="folder_sent" default=""}
	{parse variable="folder_sent" oncondition="$this->request['folderFilter'] == 'sent'" value="selected='selected'"}
</if>
<ul class='topic_buttons'>
	<li><a href='{parse url="module=messaging&amp;section=send&amp;do=form" base="publicWithApp"}' title='{$this->lang->words['go_to_compose']}'>{$this->lang->words['compose_new']}</a></li>
</ul>
</div>
<div id='message_list'>
	<form action="{parse url="app=members&amp;module=messaging&amp;section=view&amp;do=multiFile&amp;cFolderID={$currentFolderID}" base="public"}" id='msgFolderForm' method="post">
		<input type="hidden" name="sort" value="{$this->request['sort']}" />
		<input type="hidden" name="st" value="{$this->request['st']}" />
		<input type="hidden" name="auth_key" value="{$this->member->form_hash}" />
		{parse replacement="header_start"}<div class='maintitle'>
			<span class='right'>
				<input type='checkbox' class='input_check' id='msg_checkall' value='1' /> &nbsp;
			</span>
			{$dirname}
		</div>{parse replacement="header_end"}
		<div class='ipsBox removeDefault'>
			<div class='ipsBox_container'>
				<table class='ipb_table' id='message_table'>
					<tr class='header hide'>
						<th scope='col' class='col_m_status'>&nbsp;</th>
						<th scope='col' class='col_m_subject'>{$this->lang->words['col_topic']}</th>
						<th scope='col' class='col_m_replies short'>{$this->lang->words['col_replies']}</th>
						<th scope='col' class='col_m_date'>{$this->lang->words['col_last_message']}</th>
						<th scope='col' class='col_mod short'>&nbsp;</th>
					</tr>
					<if test="folderMessages:|:count( $messages )">
						<foreach loop="folderMessages:$messages as $id => $msg">
							<tr id='{$msg['mt_id']}' class='<if test="$msg['map_has_unread']">unread</if>'>
								<td class='col_m_photo altrow short'>
									<if test="hasStarterPhoto:|:$msg['_starterMemberData']['member_id']">
										<a href='{parse url="showuser={$msg['_starterMemberData']['member_id']}" template="showuser" seotitle="{$msg['_starterMemberData']['members_seo_name']}" base="public"}' class='ipsUserPhotoLink'>
											<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$msg['_starterMemberData']['Char']}.png' class='ipsUserPhoto ipsUserPhoto_mini' />
										</a>
									<else />
										{IPSMember::buildProfilePhoto(0,'mini')}
									</if>
								</td>
								<td class='col_m_subject'>
									<if test="folderNotifications:|:$msg['mt_is_deleted'] OR $msg['map_user_banned']">
										<span class='ipsBadge ipsBadge_red'>
											{$this->lang->words['msg_deleted']}
										</span>
									</if>
									<h4>
										<if test="$msg['map_has_unread']">
											<a href='{parse url="app=members&amp;module=messaging&amp;section=view&amp;do=findMessage&amp;topicID={$msg['mt_id']}&amp;msgID=__firstUnread__" base="public"}' title='{$this->lang->words['first_unread_reply']}'>{parse replacement="f_newpost"}</a>
											<strong>
										</if>
										<a href='<if test="folderDrafts:|:$currentFolderID == 'drafts'">{parse url="app=members&amp;module=messaging&amp;section=send&amp;do=form&amp;topicID={$msg['mt_id']}" base="public"}<else />{parse url="app=members&amp;module=messaging&amp;section=view&amp;do=showConversation&amp;topicID={$msg['mt_id']}" base="public"}</if>' title='{$this->lang->words['msg_view_conversation']}'>
										{$msg['mt_title']}
										</a>
										<if test="$msg['map_has_unread']"></strong></if>
									</h4>
									<if test="folderNotificationsIgnore:|:$msg['map_ignore_notification']">
										<span class='ipsBadge ipsBadge_lightgrey'>
											{$this->lang->words['msg_no_notify']}
										</span>
									</if>
									<br />
									<span class='desc lighter blend_links'>
										{$this->lang->words['msg_startedby']}
										<if test="folderStarter:|:$msg['_starterMemberData']['members_display_name']">
											{parse template="userHoverCard" group="global" params="$msg['_starterMemberData']"},
										<else />
											<span class='desc'>{$this->lang->words['deleted_user']},</span>
										</if>
										<span class='desc lighter blend_links'>
											{$this->lang->words['msg_sentto']}
											<if test="folderToMember:|:$msg['_toMemberData']['members_display_name']">
												{parse template="userHoverCard" group="global" params="$msg['_toMemberData']"}
											<else />
												<span class='desc'>{$this->lang->words['deleted_user']}</span>
											</if>
											<if test="folderMultipleUsers:|:$msg['_otherInviteeCount'] > 0">
												<if test="folderFixPlural:|:$msg['_otherInviteeCount'] > 1">
													<span title='{parse expression="implode( ', ', $msg['_invitedMemberNames'] )"}'>({$this->lang->words['pc_and']} {$msg['_otherInviteeCount']} {$this->lang->words['pc_others']})</span>
												<else />
													<span title='{parse expression="implode( ', ', $msg['_invitedMemberNames'] )"}'>({$this->lang->words['pc_and']} {$msg['_otherInviteeCount']} {$this->lang->words['pc_other']})</span>
												</if>
											</if>
										</span>
										<if test="folderNew:|:in_array( $currentFolderID, array( 'new' ) )">
											<p class='ipsType_small desc'>{$this->lang->words['folder_prefix']} {$msg['_folderName']}</p>
										</if>
									</span>	
									<if test="folderPages:|:is_array( $msg['pages'] ) AND count( $msg['pages'] )">
										<ul class='mini_pagination'>
										<foreach loop="messagePages:$msg['pages'] as $page">
												<if test="folderLastPage:|:$page['last']">
													<li><a href="{parse url="app=members&amp;module=messaging&amp;section=view&amp;do=showConversation&amp;topicID={$msg['mt_id']}&amp;st={$page['st']}" base="public"}" title='{$this->lang->words['goto_page']} {$page['page']}'>{$page['page']} {$this->lang->words['_rarr']}</a></li>
												<else />
													<li><a href="{parse url="app=members&amp;module=messaging&amp;section=view&amp;do=showConversation&amp;topicID={$msg['mt_id']}&amp;st={$page['st']}" base="public"}" title='{$this->lang->words['goto_page']} {$page['page']}'>{$page['page']}</a></li>
												</if>
										</foreach>
										</ul>
									</if>
								</td>
								<td class='col_m_replies desc blend_links'>
									<ul>
										<li><if test="folderBannedIndicator:|:$msg['map_user_banned']">-<else />{parse expression="sprintf( $this->lang->words['msg_xreplies'], intval( $msg['mt_replies'] ) )"}</if></li>
									</ul>
								</td>
								<td class='col_f_post'>
									<if test="hasPosterPhoto:|:$msg['_lastMsgAuthor']['member_id']">
										<a href='{parse url="showuser={$msg['_lastMsgAuthor']['member_id']}" template="showuser" seotitle="{$msg['_lastMsgAuthor']['members_seo_name']}" base="public"}' class='ipsUserPhotoLink left'>
											<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$msg['_lastMsgAuthor']['Char']}.png' class='ipsUserPhoto ipsUserPhoto_mini' />
										</a>
									<else />
										<span class='left'>{IPSMember::buildProfilePhoto(0,'mini')}</span>
									</if>
									<ul class='last_post ipsType_small'>
										<if test="folderBannedUser:|:$msg['map_user_banned']">
											<li><em>{$this->lang->words['info_not_available']}</em></li>
										<else />
											<li>{$this->lang->words['pc_by']} <if test="folderToMember:|:$msg['_lastMsgAuthor']['members_display_name']">{parse template="userHoverCard" group="global" params="$msg['_lastMsgAuthor']"}<else /><span class='desc'>{$this->lang->words['deleted_user']}</span></if></li>
										</if>
										<li class='desc'>
											<a href='{parse url="app=members&amp;module=messaging&amp;section=view&amp;do=findMessage&amp;topicID={$msg['mt_id']}&amp;msgID={$msg['mt_last_msg_id']}" base="public"}' title='{$this->lang->words['goto_last_post']}'>{parse date="$msg['mt_last_post_time']" format="DATE"}</a>
										</li>
									</ul>
								</td>
								<td class='col_m_mod short'>
									<input type='checkbox' class='input_check msg_check' name='msgid[{$msg['mt_id']}]' id='msg_check_{$msg['mt_id']}' />
								</td>
							</tr>
						</foreach>
					<else />
						<tr>
							<td colspan='8' class='no_messages row1'>
								{$this->lang->words['folder_no_messages_row']}
							</td>
						</tr>
					</if>
				</table>
			</div>
		</div>{parse replacement="box_end"}
		<div id='messenger_mod' class='moderation_bar rounded with_action right'>
			<select id='pm_multifile' name='method' class='input_select'>
				<optgroup label="{$this->lang->words['with_selected_opt']}">
					<option value="delete">{$this->lang->words['option__delete']}</option>
					<if test="folderMultiOptions:|:$currentFolderID != 'drafts'">
						<option value="markread">{$this->lang->words['option__markread']}</option>
						<option value="markunread">{$this->lang->words['option__markunread']}</option>
						<option value="notifyon">{$this->lang->words['option__turnon']}</option>
						<option value="notifyoff">{$this->lang->words['option__turnoff']}</option>
					</if>
				</optgroup>
				<if test="folderJumpHtml:|:$jumpFolderHTML AND $currentFolderID != 'drafts' AND $currentFolderID != 'new'">
					<optgroup label="{$this->lang->words['move_to_opt']}">
						{$jumpFolderHTML}
					</optgroup>
				</if>
			</select>
			<input type="submit" class='input_submit alt' id='folder_moderation' value="{$this->lang->words['jmp_go']}" />
		</div>
	</form>
	<div id='messenger_filter' class='left ipsPad_half'>
		<form method='post' action='{parse url="app=members&amp;module=messaging&amp;section=view&amp;do=showFolder&amp;folderID={$currentFolderID}" base="public"}'>
			<label for='conversation_filter' class='desc'>{$this->lang->words['filter__show']} </label>
			<select id='conversation_filter' name='folderFilter' class='input_select'>
				<option value='' {parse variable="folder_all"}>{$this->lang->words['filter__all']}</option>
				<option value='in' {parse variable="folder_in"}>{$this->lang->words['filter__others']}</option>
				<option value='sent' {parse variable="folder_sent"}>{$this->lang->words['filters__i']}</option>
			</select>
			<input type='submit' class='input_submit alt' value='{$this->lang->words['filters__update']}' />
		</form>
	</div>
</div>
<br />
<div class='topic_controls clear clearfix'>
{$pages}
</div>]]></template_content>
      <template_name>showFolder</template_name>
      <template_data>$messages, $dirname, $pages, $currentFolderID, $jumpFolderHTML</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_messaging</template_group>
      <template_content><![CDATA[<script type='text/javascript'>
//<!#^#|CDATA|
	ipb.messenger.curFolder = 'in';
//|#^#]>
</script>
<if test="searchError:|:$error">
	<p class='message error'>
		{$error}
	</p>
	<br />
</if>
<if test="hasPagination:|:$pages">
	<div class='topic_controls'>
	{$pages}
	</div>
	<br />
</if>
{parse replacement="header_start"}<h2 class='maintitle clear'>{$this->lang->words['your_search_results']}</h2>{parse replacement="header_end"}
<div id='message_list'>
	<div class='ipsBox removeDefault'>
		<div class='ipsBox_container'>
			<table class='ipb_table' id='message_table'>
				<tr class='header hide'>
					<th scope='col' class='col_m_photo'>&nbsp;</th>
					<th scope='col' class='col_m_subject'>{$this->lang->words['col_subject']}</th>
					<th scope='col' class='col_m_replies short'>{$this->lang->words['col_replies']}</th>
					<th scope='col' class='col_m_date'>{$this->lang->words['col_last_message']}</th>
				</tr>
		
				<if test="searchMessages:|:count( $messages )">
					<foreach loop="messages:$messages as $id => $msg">
						<tr id='{$msg['mt_id']}' class='<if test="$msg['map_has_unread']">unread</if>'>
							<td class='col_m_photo altrow short'>
								<a href='{parse url="showuser={$msg['_starterMemberData']['member_id']}" template="showuser" seotitle="{$msg['_starterMemberData']['members_seo_name']}" base="public"}' class='ipsUserPhotoLink'>
									<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$msg['_starterMemberData']['Char']}.png' class='ipsUserPhoto ipsUserPhoto_mini' />
								</a>
							</td>
							<td>
								<if test="folderNotifications:|:$msg['mt_is_deleted'] OR $msg['map_user_banned']">
									<span class='ipsBadge ipsBadge_red'>
										{$this->lang->words['msg_deleted']}
									</span>
								</if>
								<h4><a href="{parse url="app=members&amp;module=messaging&amp;section=view&amp;do=showConversation&amp;topicID={$msg['mt_id']}" base="public"}">{$msg['mt_title']}</a></h4><br />
								<span class='desc lighter blend_links'>
									{$this->lang->words['msg_startedby']}
									<if test="folderStarter:|:$msg['_starterMemberData']['members_display_name']">
										{parse template="userHoverCard" group="global" params="$msg['_starterMemberData']"}
									<else />
										<span class='desc'>{$this->lang->words['deleted_user']}</span>
									</if>
									<span class='desc lighter blend_links'>
										, {$this->lang->words['msg_sentto']}
										<if test="folderToMember:|:$msg['_toMemberData']['members_display_name']">
											{parse template="userHoverCard" group="global" params="$msg['_toMemberData']"}
										<else />
											<span class='desc'>{$this->lang->words['deleted_user']}</span>
										</if>
										<if test="folderMultipleUsers:|:$msg['_otherInviteeCount'] > 0">
											<if test="folderFixPlural:|:$msg['_otherInviteeCount'] > 1">
												<span title='{parse expression="implode( ', ', $msg['_invitedMemberNames'] )"}'>({$this->lang->words['pc_and']} {$msg['_otherInviteeCount']} {$this->lang->words['pc_others']})</p>
											<else />
												<span title='{parse expression="implode( ', ', $msg['_invitedMemberNames'] )"}'>({$this->lang->words['pc_and']} {$msg['_otherInviteeCount']} {$this->lang->words['pc_other']})</p>
											</if>
										</if>
									</span>
									<if test="folderNew:|:in_array( $currentFolderID, array( 'new' ) )">
										<p class='ipsType_small desc'>{$this->lang->words['folder_prefix']} {$msg['_folderName']}</p>
									</if>
								</span>
								<p class='ipsType_small desc'>{$this->lang->words['label_pc']} {$msg['_folderName']}</p>
							</td>
							<td class='col_m_replies desc blend_links'>
								<ul>
									<li><if test="folderBannedIndicator:|:$msg['map_user_banned']">-<else />{parse expression="sprintf( $this->lang->words['msg_xreplies'], intval( $msg['mt_replies'] ) )"}</if></li>
								</ul>
							</td>
							<td class='col_f_post'>
								<a href='{parse url="showuser={$msg['_lastMsgAuthor']['member_id']}" template="showuser" seotitle="{$msg['_lastMsgAuthor']['members_seo_name']}" base="public"}' class='ipsUserPhotoLink left'>
									<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$msg['_lastMsgAuthor']['Char']}.png' class='ipsUserPhoto ipsUserPhoto_mini' />
								</a>
								<ul class='last_post ipsType_small'>
									<if test="folderBannedUser:|:$msg['map_user_banned']">
										<li><em>{$this->lang->words['info_not_available']}</em></li>
									<else />
										<li>{$this->lang->words['pc_by']} {parse template="userHoverCard" group="global" params="$msg['_lastMsgAuthor']"}</li>
									</if>
									<li class='desc blend_links'><a href='{parse url="app=members&amp;module=messaging&amp;section=view&amp;do=findMessage&amp;topicID={$msg['mt_id']}&amp;msgID={$msg['mt_last_msg_id']}" base="public"}' title='{$this->lang->words['goto_last_post']}'>{parse date="$msg['mt_last_post_time']" format="DATE"}</a></li>
								</ul>
							</td>
						</tr>
					</foreach>
				<else />
					<tr>
						<td colspan='5' class='no_messages row1'>
							{$this->lang->words['no_messages_row']}
						</td>
					</tr>
				</if>
			</table>
		</div>
	</div>
</div>{parse replacement="box_end"}]]></template_content>
      <template_name>showSearchResults</template_name>
      <template_data>$messages, $pages, $error</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
  </templategroup>
  <templategroup group="skin_mlist">
    <template>
      <template_group>skin_mlist</template_group>
      <template_content><![CDATA[<script type='text/javascript' src='{$this->settings['public_dir']}js/3rd_party/calendar_date_select/calendar_date_select.js'></script>
<if test="calendarlocale:|:$this->settings['calendar_date_select_locale'] AND $this->settings['calendar_date_select_locale'] != 'en'">
    <script type='text/javascript' src='{$this->settings['public_dir']}js/3rd_party/calendar_date_select/format_ipb.js'> </script>
</if>
{parse js_module="memberlist"}
<!-- SEARCH FORM -->
<h1 class='ipsType_pagetitle'>{$this->lang->words['mlist_header']}</h1>
<div class='topic_controls'>
	{$pages}	
	<ul class='topic_buttons'>
		<li><a href='#filters' title='{$this->lang->words['mlist_adv_filt']}' id='use_filters'>{$this->lang->words['mlist_adv_filt']}</a></li>
	</ul>
</div>
<div id='member_filters' class='general_box alt clear'>
	<form action="{parse url="app=members&amp;module=list" base="public" seotitle="false"}" method="post">
		<h3>{$this->lang->words['mlist_adv_filt_opt']}</h3>
	
		<ul id='filters_1'>
			<li class='field'>
				<label for='member_name'>{$this->lang->words['s_name']}</label>
				<select name="name_box" class='input_select'>
					<option value="begins"<if test="namebox_begins:|:$this->request['name_box'] == 'begins'"> selected='selected'</if>>{$this->lang->words['s_begins']}</option>
					<option value="contains"<if test="namebox_contains:|:$this->request['name_box'] == 'contains'"> selected='selected'</if>>{$this->lang->words['s_contains']}</option>
				</select>&nbsp;&nbsp;
				<input type="text" size="15" name="name" id='member_name' class='input_text' value="{parse expression="urldecode($this->request['name'])"}" />
			</li>
			<li class='field'>
				<label for='photo_only' style='line-height: 16px;'>{$this->lang->words['photo_only']}</label>
				<input class='input_check' id='photo_only' type="checkbox" value="1" name="photoonly" <if test="photoonly:|:$defaults['photoonly']">checked='checked'</if> />
			</li>
<if test="canFilterRate:|:$this->settings['pp_allow_member_rate']">
			<li class='field'>
				<label for='rating'>{$this->lang->words['m_rating_morethan']}</label>
				<select name='pp_rating_real' id='rating'>
					<option value='0'<if test="rating0:|:! $this->request['pp_rating_real']"> selected='selected'</if>>0</option>
					<option value='1'<if test="rating1:|:$this->request['pp_rating_real'] == 1"> selected='selected'</if>>1</option>
					<option value='2'<if test="rating2:|:$this->request['pp_rating_real'] == 2"> selected='selected'</if>>2</option>
					<option value='3'<if test="rating3:|:$this->request['pp_rating_real'] == 3"> selected='selected'</if>>3</option>
					<option value='4'<if test="rating4:|:$this->request['pp_rating_real'] == 4"> selected='selected'</if>>4</option>
				</select>
				{$this->lang->words['m_stars']}
			</li>
			</if>
			<if test="hascfields:|:count( $custom_fields->out_fields )">
				<foreach loop="customfields:$custom_fields->out_fields as $id => $field">
					<li class='field custom'>
						<label for='field_{$id}'>{$custom_fields->field_names[$id]}</label>
						{$field}
					</li>
				</foreach>
			</if>			
		</ul>
		<ul id='filters_2'>
			<li class='field'>
				<label for='signature'>{$this->lang->words['s_signature']}</label>
				<input type="text" class='input_text' size="28" id='signature' name="signature" value="{parse expression="urldecode($this->request['signature'])"}" />
			</li>
			<li class='field'>
				<label for='posts'>{$this->lang->words['s_posts']}</label>
				<select class="dropdown" name="posts_ltmt">
					<option value="lt"<if test="posts_ltmt_lt:|:$this->request['posts_ltmt'] == 'lt'"> selected='selected'</if>>{$this->lang->words['s_lessthan']}</option>
					<option value="mt"<if test="posts_ltmt_mt:|:$this->request['posts_ltmt'] == 'mt'"> selected='selected'</if>>{$this->lang->words['s_morethan']}</option>
				</select>
				&nbsp;<input type="text" class='input_text' id='posts' size="15" name="posts" value="{$this->request['posts']}" />
			</li>
			<li class='field'>
				<label for='joined'>{$this->lang->words['s_joined']}</label>
				<select class="dropdown" name="joined_ltmt">
					<option value="lt"<if test="joined_ltmt_lt:|:$this->request['joined_ltmt'] == 'lt'"> selected='selected'</if>>{$this->lang->words['s_before']}</option>
					<option value="mt"<if test="joined_ltmt_mt:|:$this->request['joined_ltmt'] == 'mt'"> selected='selected'</if>>{$this->lang->words['s_after']}</option>
				</select>
				&nbsp;<input type="text" class='input_text' id='joined' size="10" name="joined" value="{$this->request['joined']}" /> <img src='{$this->settings['img_url']}/date.png' alt='{$this->lang->words['generic_date']}' id='joined_date_icon' class='clickable' /> 
				<span class="desc">{$this->lang->words['s_dateformat']}</span>
			</li>
			<li class='field'>
				<label for='last_post'>{$this->lang->words['s_lastpost']}</label>
				<select class="dropdown" name="lastpost_ltmt">
					<option value="lt"<if test="lastpost_ltmt_lt:|:$this->request['lastpost_ltmt'] == 'lt'"> selected='selected'</if>>{$this->lang->words['s_before']}</option>
					<option value="mt"<if test="lastpost_ltmt_mt:|:$this->request['lastpost_ltmt'] == 'mt'"> selected='selected'</if>>{$this->lang->words['s_after']}</option>
				</select>
				&nbsp;<input type="text" class='input_text' id='last_post' size="10" name="lastpost" value="{$this->request['lastpost']}" /> <img src='{$this->settings['img_url']}/date.png' alt='{$this->lang->words['generic_date']}' id='last_post_date_icon' class='clickable' /> 
				<span class="desc">{$this->lang->words['s_dateformat']}</span>
			</li>
			<li class='field'>
				<label for='last_visit'>{$this->lang->words['s_lastvisit']}</label>
				<select class="dropdown" name="lastvisit_ltmt">
					<option value="lt"<if test="lastvisit_ltmt_lt:|:$this->request['lastvisit_ltmt'] == 'lt'"> selected='selected'</if>>{$this->lang->words['s_before']}</option>
					<option value="mt"<if test="lastvisit_ltmt_mt:|:$this->request['lastvisit_ltmt'] == 'mt'"> selected='selected'</if>>{$this->lang->words['s_after']}</option>
				</select>
				&nbsp;<input type="text" class='input_text' id='last_visit' size="10" name="lastvisit" value="{$this->request['lastvisit']}" /> <img src='{$this->settings['img_url']}/date.png' alt='{$this->lang->words['generic_date']}' id='last_visit_date_icon' class='clickable' />
				<span class="desc">{$this->lang->words['s_dateformat']}</span>
			</li>			
		</ul>
		<fieldset class='other_filters'>
			<select name='filter' class='input_select'>
				<foreach loop="filter:$dropdowns['filter'] as $k => $v">
					<option value='{$k}'<if test="filterdefault:|:$k == $defaults['filter']"> selected='selected'</if>>{$v}</option>
				</foreach>
			</select>
			{$this->lang->words['sorting_text_by']}
			<select name='sort_key' class='input_select'>
				<foreach loop="sort_key:$dropdowns['sort_key'] as $k => $v">
					<option value='{$k}'<if test="sortdefault:|:$k == $defaults['sort_key']"> selected='selected'</if>>{$this->lang->words[ $v ]}</option>
				</foreach>
			</select>
			{$this->lang->words['sorting_text_in']}
			<select name='sort_order' class='input_select'>
				<foreach loop="sort_order:$dropdowns['sort_order'] as $k => $v">
					<option value='{$k}'<if test="orderdefault:|:$k == $defaults['sort_order']"> selected='selected'</if>>{$this->lang->words[ $v ]}</option>
				</foreach>
			</select>
			{$this->lang->words['sorting_text_with']}
			<select name='max_results' class='input_select'>
				<foreach loop="max_results:$dropdowns['max_results'] as $k => $v">
					<option value='{$k}'<if test="limitdefault:|:$k == $defaults['max_results']"> selected='selected'</if>>{$v}</option>
				</foreach>
			</select>
			{$this->lang->words['sorting_text_results']}
		</fieldset>
		<fieldset class='submit clear'>
			<input type="submit" value="{$this->lang->words['sort_submit']}" class="input_submit" /> {$this->lang->words['or']} <a href='#j_memberlist' title='{$this->lang->words['cancel']}' id='close_filters' class='cancel'>{$this->lang->words['cancel']}</a>
		</fieldset>
	</form>
</div>
<script type='text/javascript'>
	$('member_filters').hide();
</script>
<br />

{parse replacement="header_start"}<div class='maintitle ipsFilterbar clear clearfix'>
    <ul class='ipsList_inline left'>
        <li <if test="filtermembers:|:$this->request['sort_key'] == 'members_display_name' || !$this->request['sort_key']">class='active'</if>>
            <a href='{parse url="app=members&amp;module=list&amp;{$url}&amp;sort_key=members_display_name&amp;sort_order=asc" template="members_list" base="public" seotitle="false"}' title='{$this->lang->words['sort_by_mname']}'>{$this->lang->words['sort_by_name']}</a>
        </li>
        <li <if test="filterposts:|:$this->request['sort_key'] == 'posts'">class='active'</if>>
            <a href='{parse url="app=members&amp;module=list&amp;{$url}&amp;sort_key=posts&amp;sort_order=desc" template="members_list" base="public" seotitle="false"}' title='{$this->lang->words['sort_by_posts']}'>{$this->lang->words['pcount']}</a>
        </li>
        <li <if test="filterjoined:|:$this->request['sort_key'] == 'joined'">class='active'</if>>
            <a href='{parse url="app=members&amp;module=list&amp;{$url}&amp;sort_key=joined" template="members_list" base="public" seotitle="false"}' title='{$this->lang->words['sorty_by_jdate']}'>{$this->lang->words['sort_by_joined']}</a>
        </li>
    </ul>
</div>{parse replacement="header_end"}

<div class='ipsBox ipsVerticalTabbed ipsLayout ipsLayout_withleft ipsLayout_tinyleft clearfix'>
	<div class='ipsVerticalTabbed_tabs ipsVerticalTabbed_minitabs ipsLayout_left' id='mlist_tabs'>
		<ul>
			<if test="letterquickjump:|:!$this->request['quickjump']">
				<li class='active'><a href='{parse url="app=members&amp;module=list" template="members_list" base="public" seotitle="false"}' title='{$this->lang->words['members_start_with']}{$letter}'>{$this->lang->words['mlist_view_all_txt']}</a></li>
			<else />
				<li><a href='{parse url="app=members&amp;module=list" template="members_list" base="public" seotitle="false"}' title='{$this->lang->words['mlist_view_all_title']}'>{$this->lang->words['mlist_view_all_txt']}</a></li>
			</if>
			<foreach loop="chars:range(65,90) as $char">
				<if test="letterdefault:|:$letter = strtoupper(chr($char))">
					<li <if test="selected:|:strtoupper( $this->request['quickjump'] ) == $letter">class='active'</if>><a href='{parse url="{$url}&amp;quickjump={$letter}" template="members_list" base="public" seotitle="false"}' title='{$this->lang->words['mlist_view_start_title']} {$letter}'>{$letter}</a></li>
				</if>
			</foreach>
		</ul>
	</div>
	<div class='ipsVerticalTabbed_content ipsLayout_content'>
		<div class='ipsBox_container ipsPad' id='mlist_content'>
			<ul class='ipsMemberList'>
				<if test="showmembers:|:is_array( $members ) and count( $members )">
					{parse striping="memberStripe" classes="row1,row2"}
					<foreach loop="members:$members as $member">
						<li id='member_id_{$member['member_id']}' class='ipsPad clearfix member_entry {parse striping="memberStripe"}'>
							<a href='{parse url="showuser={$member['member_id']}" template="showuser" seotitle="{$member['members_seo_name']}" base="public"}' title='{$this->lang->words['view_profile']}' class='ipsUserPhotoLink left'><img src='http://mercury.raknet.ru/templates/style/img/avatars/{$member['Char']}.png' alt="{parse expression="sprintf($this->lang->words['users_photo'],$member['members_display_name'])"}" class='ipsUserPhoto ipsUserPhoto_medium' /></a>
							<div class='ipsBox_withphoto'>
								<ul class='ipsList_inline right'>
									<if test="weAreSupmod:|:$this->memberData['g_is_supmod'] == 1 && $member['member_id'] != $this->memberData['member_id']">
										<li><a href='{parse url="app=core&amp;module=modcp&amp;do=editmember&amp;auth_key={$this->member->form_hash}&amp;mid={$member['member_id']}&amp;pf={$member['member_id']}" base="public"}' class='ipsButton_secondary'>{$this->lang->words['edit_member']}</a></li>
									</if>
									<if test="notus:|:$this->memberData['member_id'] AND $this->memberData['member_id'] != $member['member_id'] && $this->settings['friends_enabled'] AND $this->memberData['g_can_add_friends']">
										<if test="addfriend:|:IPSMember::checkFriendStatus( $member['member_id'] )">
											<li class='mini_friend_toggle is_friend' id='friend_mlist_{$member['member_id']}'><a href='{parse url="app=members&amp;module=list&amp;module=profile&amp;section=friends&amp;do=remove&amp;member_id={$member['member_id']}&amp;secure_key={$this->member->form_hash}" base="public"}' title='{$this->lang->words['remove_friend']}' class='ipsButton_secondary'>{parse replacement="remove_friend"}</a></li>
										<else />
											<li class='mini_friend_toggle is_not_friend' id='friend_mlist_{$member['member_id']}'><a href='{parse url="app=members&amp;module=list&amp;module=profile&amp;section=friends&amp;do=add&amp;member_id={$member['member_id']}&amp;secure_key={$this->member->form_hash}" base="public"}' title='{$this->lang->words['add_friend']}' class='ipsButton_secondary'>{parse replacement="add_friend"}</a></li>								
										</if>
									</if>
									<if test="sendpm:|:$this->memberData['g_use_pm'] AND $this->memberData['members_disable_pm'] == 0 AND IPSLib::moduleIsEnabled( 'messaging', 'members' ) && $member['member_id'] != $this->memberData['member_id']">
										<li class='pm_button' id='pm_xxx_{$member['pp_member_id']}'><a href='{parse url="app=members&amp;module=list&amp;module=messaging&amp;section=send&amp;do=form&amp;fromMemberID={$member['pp_member_id']}" base="public"}' title='{$this->lang->words['pm_member']}' class='ipsButton_secondary'>{parse replacement="send_msg"}</a></li>
									</if>
									<li><a href='{parse url="app=core&amp;module=search&amp;do=user_activity&amp;mid={$member['member_id']}" base="public"}' title='{$this->lang->words['gbl_find_my_content']}' class='ipsButton_secondary'>{parse replacement="find_topics_link"}</a></li>
									<if test="blog:|:$member['has_blog'] AND IPSLib::appIsInstalled( 'blog' )">
										<li><a href='{parse url="app=blog&amp;module=display&amp;section=blog&amp;show_members_blogs={$member['member_id']}" base="public"}' title='{$this->lang->words['view_blog']}' class='ipsButton_secondary'>{parse replacement="blog_link"}</a></li>
									</if>
									<if test="gallery:|:$member['has_gallery'] AND IPSLib::appIsInstalled( 'gallery' )">
										<li><a href='{parse url="app=gallery&amp;user={$member['member_id']}" template="useralbum" seotitle="{$member['members_seo_name']}" base="public"}' title='{$this->lang->words['view_gallery']}' class='ipsButton_secondary'>{parse replacement="gallery_link"}</a></li>
									</if>
								</ul>
								
								<h3 class='ipsType_subtitle'>
									<strong><a href='{parse url="showuser={$member['member_id']}" template="showuser" seotitle="{$member['members_seo_name']}" base="public"}' title='{$this->lang->words['view_profile']}'>{$member['members_display_name']}</a></strong>
									
									<if test="rating:|:$this->settings['pp_allow_member_rate'] && $this->request['pp_rating_real']">
										<span class='rating'> 
											<if test="rate1:|:$member['pp_rating_real'] >= 1">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if><if test="rate2:|:$member['pp_rating_real'] >= 2">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if><if test="rate3:|:$member['pp_rating_real'] >= 3">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if><if test="rate4:|:$member['pp_rating_real'] >= 4">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if><if test="rate5:|:$member['pp_rating_real'] >= 5">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if>
										</span>
									</if>
								</h3>
								<if test="repson:|:$this->settings['reputation_enabled'] && $this->settings['reputation_show_profile'] && $member['pp_reputation_points'] !== null">
									<if test="norep:|:$member['pp_reputation_points'] == 0 || !$member['pp_reputation_points']">
										<p class='reputation zero ipsType_small left' data-tooltip="{parse expression="sprintf( $this->lang->words['member_has_x_rep'], $member['members_display_name'], $member['pp_reputation_points'] )"}">
									</if>
									<if test="posrep:|:$member['pp_reputation_points'] > 0">
										<p class='reputation positive ipsType_small left' data-tooltip="{parse expression="sprintf( $this->lang->words['member_has_x_rep'], $member['members_display_name'], $member['pp_reputation_points'] )"}">
									</if>
									<if test="negrep:|:$member['pp_reputation_points'] < 0">
										<p class='reputation negative ipsType_small left' data-tooltip="{parse expression="sprintf( $this->lang->words['member_has_x_rep'], $member['members_display_name'], $member['pp_reputation_points'] )"}">
									</if>							
											<span class='number'>{$member['pp_reputation_points']}</span>
										</p>
								</if>
								<div class='left desc line_height clearfix' style='margin-top: 5px;'>
									<span class='left' style='min-width: 110px; padding-right: 10px;'>{IPSMember::makeNameFormatted( $member['group'], $member['member_group_id'] )}</span><span class='left' style='min-width: 170px; padding-right: 10px;'><span class='desc lighter'>{$this->lang->words['member_joined']}:</span> {parse date="$member['joined']" format="joined"}</span><span class='left'><if test="filterViews:|:$this->request['sort_key'] == 'members_profile_views'">{parse format_number="$member['members_profile_views']"} {$this->lang->words['m_views']}<else />{parse format_number="$member['posts']"} {$this->lang->words['member_posts']}</if></span>
								</div>
							</div>
						</li>						
					</foreach>
				<else />
					<li class='no_messages'>
						{$this->lang->words['no_results']}
					</li>
				</if>
			</ul>
		</div>
	</div>
</div>
{parse replacement="box_end"}
<script type='text/javascript'>
	$("mlist_content").setStyle( { minHeight: $('mlist_tabs').measure('margin-box-height') + 5 + "px" } );
</script>
{$pages}]]></template_content>
      <template_name>member_list_show</template_name>
      <template_data><![CDATA[$members, $pages="", $dropdowns=array(), $defaults=array(), $custom_fields=null, $url='']]></template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
  </templategroup>
  <templategroup group="skin_online">
    <template>
      <template_group>skin_online</template_group>
      <template_content><![CDATA[<div class='topic_controls'>
	{$links}
</div>
{parse replacement="header_start"}<h2 class='maintitle'>{$this->lang->words['online_page_title']}</h2>{parse replacement="header_end"}
<div class='ipsBox removeDefault'>
	<div class='ipsBox_container'>
		<table class='ipb_table ipsMemberList' summary="{$this->lang->words['users_online']}">
			<tr class='header'>
				<th scope='col' width='55'>&nbsp;</th>
				<th scope='col'>{$this->lang->words['member_name']}</th>
				<th scope='col'>{$this->lang->words['where']}</th>
				<th scope='col'>{$this->lang->words['time']}</th>
				<th scope='col'>&nbsp;</th>
			</tr>
			<if test="onlineusers:|:count($rows)">
				{parse striping="online" classes="row1,row2"}
				<foreach loop="online:$rows as $session">
					<tr class='{parse striping="online"}'>
						<td>{parse template="userSmallPhoto" group="global" params="array_merge( $session['_memberData'], array( 'alt' => sprintf($this->lang->words['users_photo'], $session['_memberData']['members_display_name'] ? $session['_memberData']['members_display_name'] : $this->lang->words['global_guestname']) ) )"}</td>
						<td>
							<if test="userid:|:$session['_memberData']['member_id']">
								{parse template="userHoverCard" group="global" params="array_merge( $session['_memberData'], array( 'members_display_name' => IPSMember::makeNameFormatted( $session['_memberData']['members_display_name'], $session['_memberData']['member_group_id'] ) ) )"}
							<else />
								<if test="username:|:$session['member_name']">
									{IPSMember::makeNameFormatted( $session['member_name'], $session['member_group'] )}
								<else />
									{$this->lang->words['global_guestname']}
								</if>
							</if>
							<if test="anonymous:|:$session['login_type'] == 1">
								<if test="viewanon:|:$this->memberData['g_access_cp'] || $session['_memberData']['member_id'] == $this->memberData['member_id']">*</if>
							</if>
							<if test="showip:|:$this->memberData['g_access_cp']">
								<br />
								<span class='ip desc lighter ipsText_smaller'>({$session['ip_address']})</span>
							</if>
						</td>
						<td>
							<if test="nowhere:|:!$session['where_line'] || $session['in_error']">
								{$this->lang->words['board_index']}
							<else />
								<if test="wheretext:|:$session['where_link'] AND !$session['where_line_more']">
									<if test="wheretextseo:|:$session['_whereLinkSeo']">
										<a href='{$session['_whereLinkSeo']}'>
									<else />
										<a href='{parse url="{$session['where_link']}" base="public"}'>
									</if>
								</if>
								{$session['where_line']} 
								<if test="moredetails:|:$session['where_line_more']">
									&nbsp;
									<if test="wheretextseo:|:$session['_whereLinkSeo']">
										<a href='{$session['_whereLinkSeo']}'>
									<else />
										<if test="detailslink:|:$session['where_link']"><a href='{parse url="{$session['where_link']}" base="public"}'></if>
									</if>
									{$session['where_line_more']}
									<if test="enddetailslink:|:$session['where_link']"></a></if>
								<else />
									<if test="nomoreenddetailslink:|:$session['where_link']"></a></if>
								</if>
							</if>
						</td>
						<td>
							{parse date="$session['running_time']" format="long" relative="false"}
						</td>
						<td>
							<if test="options:|:$session['member_id'] AND $session['member_name']">
								<ul class='ipsList_inline ipsList_nowrap right'>
									<if test="notus:|:$this->memberData['member_id'] AND $this->memberData['member_id'] != $session['member_id'] && $this->settings['friends_enabled'] AND $this->memberData['g_can_add_friends']">
										<if test="addfriend:|:IPSMember::checkFriendStatus( $session['member_id'] )">
											<li class='mini_friend_toggle is_friend' id='friend_online_{$session['member_id']}'><a href='{parse url="app=members&amp;module=profile&amp;section=friends&amp;do=remove&amp;member_id={$session['member_id']}&amp;secure_key={$this->member->form_hash}" base="public"}' title='{$this->lang->words['remove_friend']}' class='ipsButton_secondary'>{parse replacement="remove_friend"}</a></li>
										<else />
											<li class='mini_friend_toggle is_not_friend' id='friend_online_{$session['member_id']}'><a href='{parse url="app=members&amp;module=profile&amp;section=friends&amp;do=add&amp;member_id={$session['member_id']}&amp;secure_key={$this->member->form_hash}" base="public"}' title='{$this->lang->words['add_friend']}' class='ipsButton_secondary'>{parse replacement="add_friend"}</a></li>								
										</if>
									</if>
									<if test="sendpm:|:$this->memberData['member_id'] AND $this->memberData['member_id'] != $session['member_id'] AND $this->memberData['g_use_pm'] AND $this->memberData['members_disable_pm'] == 0 AND IPSLib::moduleIsEnabled( 'messaging', 'members' )">
										<li class='pm_button' id='pm_online_{$session['member_id']}'><a href='{parse url="app=members&amp;module=messaging&amp;section=send&amp;do=form&amp;fromMemberID={$session['member_id']}" base="public"}' title='{$this->lang->words['pm_member']}' class='ipsButton_secondary'>{parse replacement="send_msg"}</a></li>
									</if>
									<if test="blog:|:$session['memberData']['has_blog'] AND IPSLib::appIsInstalled( 'blog' )">
										<li><a href='{parse url="app=blog&amp;module=display&amp;section=blog&amp;show_members_blogs={$session['member_id']}" base="public"}' title='{$this->lang->words['view_blog']}' class='ipsButton_secondary'>{parse replacement="blog_link"}</a></li>
									</if>
									<if test="gallery:|:$session['memberData']['has_gallery'] AND IPSLib::appIsInstalled( 'gallery' )">
										<li><a href='{parse url="app=gallery&amp;user={$session['member_id']}" template="useralbum" seotitle="{$session['memberData']['members_seo_name']}" base="public"}' title='{$this->lang->words['view_gallery']}' class='ipsButton_secondary'>{parse replacement="gallery_link"}</a></li>
									</if>
								</ul>
							<else />
								<span class='desc'>{$this->lang->words['no_options_available']}</span>
							</if>
						</td>
					</tr>
				</foreach>
			</if>
		</table>
	</div>
</div>{parse replacement="box_end"}
<div id='forum_filter' class='ipsForm_center ipsPad'>
	<form method="post" action="{parse url="app=members&amp;section=online&amp;module=online" base="public"}">
		<label for='sort_key'>{$this->lang->words['s_by']}</label>
		<select name="sort_key" id='sort_key' class='input_select'>
			<foreach loop="sort_key:array( 'click', 'name' ) as $sort">
				<option value='{$sort}'<if test="defaultsort:|:$defaults['sort_key'] == $sort"> selected='selected'</if>>{$this->lang->words['s_sort_key_' . $sort ]}</option>
			</foreach>
		</select>
		<select name="show_mem" class='input_select'>
			<foreach loop="show_mem:array( 'reg', 'guest', 'all' ) as $filter">
				<option value='{$filter}'<if test="defaultfilter:|:$defaults['show_mem'] == $filter"> selected='selected'</if>>{$this->lang->words['s_show_mem_' . $filter ]}</option>
			</foreach>
		</select>
		<select name="sort_order" class='input_select'>
			<foreach loop="sort_order:array( 'desc', 'asc' ) as $order">
				<option value='{$order}'<if test="defaultorder:|:$defaults['sort_order'] == $order"> selected='selected'</if>>{$this->lang->words['s_sort_order_' . $order ]}</option>
			</foreach>
		</select>
		<input type="submit" value="{$this->lang->words['s_go']}" class="input_submit alt" />
	</form>
</div>
<br />
<div class='topic_controls'>
	{$links}
</div>]]></template_content>
      <template_name>showOnlineList</template_name>
      <template_data><![CDATA[$rows, $links="", $defaults=array()]]></template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
  </templategroup>
  <templategroup group="skin_profile">
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[<style type="text/css">
/* Overwrite some of the standard IPB rules */
/* Content, is the main page under the header */
/*#content {
	background: transparent url("{style_images_url}/opacity70.png");
	background: rgba(255,255,255,0.3);
}
#profile_background {
	background: transparent url("{style_images_url}/opacity70.png");
	background: rgba(255,255,255,0.3);
}
.topic_buttons li.non_button a, #footer_utilities {
	background: url('{style_images_url}/trans60.png') repeat !important;
}*/
<if test="hasBodyCustomization:|:$member['customization']['bg_color'] OR $member['customization']['_bgUrl']">
body {
	<if test="hasBackgroundColor:|:$member['customization']['bg_color']">
		background-color: #{$member['customization']['bg_color']} !important;
	</if>
	<if test="hasBackgroundImage:|:$member['customization']['_bgUrl']">
		background-image: url("{$member['customization']['_bgUrl']}?nc={$member['pp_profile_update']}") !important;
		<if test="backgroundIsFixed:|:! $member['customization']['bg_tile']">
			background-position: 0px 0px;
			background-attachment: fixed;
			background-repeat: no-repeat;
			-webkit-background-size: 100% 100%;
			-moz-background-size: 100% 100%;
			background-size: 100% 100%;
		<else />
			background-position: 0px 0px;
			background-attachment: fixed;
			background-repeat: repeat;
		</if>
	</if>
}
</if>
</style>
<script type="text/javascript">
	ipb.profile.customization = 1;
</script>]]></template_content>
      <template_name>customizeProfile</template_name>
      <template_data>$member</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[{parse js_module="friends"}
<h1 class='ipsType_pagetitle'>{$this->lang->words['m_friends_list']}</h1>
<if test="friendListPages:|:$pages">
	<div class='topic_controls'>
		$pages
	</div>
</if>
{parse replacement="header_start"}<div class='maintitle ipsFilterbar clear'>
	<ul class='ipsList_inline clearfix'>
		<if test="tabIsList:|:$this->request['tab'] == 'list' || !$this->request['tab']">
			<li class='active'><a href='{parse url="app=members&amp;section=friends&amp;module=profile&amp;do=list&amp;tab=list" base="public"}' title='{$this->lang->words['m_friends_list']}'>{$this->lang->words['m_friends_list']}</a></li>
			<li><a href='{parse url="app=members&amp;section=friends&amp;module=profile&amp;do=list&amp;tab=pending" base="public"}' title='{$this->lang->words['m_friends_pending']}'>{$this->lang->words['m_friends_pending']}</a></li>
		</if>
		<if test="tabIsPending:|:$this->request['tab'] == 'pending'">
			<li><a href='{parse url="app=members&amp;section=friends&amp;module=profile&amp;do=list&amp;tab=list" base="public"}' title='{$this->lang->words['m_friends_list']}'>{$this->lang->words['m_friends_list']}</a></li>
			<li class='active'><a href='{parse url="app=members&amp;section=friends&amp;module=profile&amp;do=list&amp;tab=pending" base="public"}' title='{$this->lang->words['m_friends_pending']}'>{$this->lang->words['m_friends_pending']}</a></li>
		</if>
	</ul>
</div>{parse replacement="header_end"}
<if test="hasFriendsList:|:is_array($friends) and count($friends) && $this->settings['friends_enabled']">
	{parse striping="memberStripe" classes="row1,row2"}
	<ul class='ipsMemberList'>
		<foreach loop="friendsList:$friends as $friend">
			<if test="loopOnPending:|:$this->request['tab'] == 'pending'">
				<li id='member_id_{$friend['member_id']}' class='ipsPad clearfix member_entry {parse striping="memberStripe"}'>
					<a href='{parse url="showuser={$friend['member_id']}" template="showuser" seotitle="{$friend['members_seo_name']}" base="public"}' title='{$this->lang->words['view_profile']}' class='ipsUserPhotoLink left'><img src='http://mercury.raknet.ru/templates/style/img/avatars/{$friend['Char']}.png' alt="{parse expression="sprintf($this->lang->words['users_photo'],$friend['members_display_name'])"}" class='ipsUserPhoto ipsUserPhoto_medium' /></a>
					<div class='ipsBox_withphoto'>
						<ul class='ipsList_inline right'>
							<li><a href='{parse url="app=members&amp;module=profile&amp;section=friends&amp;do=moderate&amp;pp_option=approve&amp;pp_friend_id[{$friend['member_id']}]=1&amp;md5check={$this->member->form_hash}" base="public"}' title='{$this->lang->words['approve_request']}' class='ipsButton_secondary'>{$this->lang->words['approve_request']}</a></li>
							<li><a href='{parse url="app=members&amp;module=profile&amp;section=friends&amp;do=moderate&amp;pp_option=delete&amp;pp_friend_id[{$friend['member_id']}]=1&amp;md5check={$this->member->form_hash}" base="public"}' title='{$this->lang->words['deny_request']}' class='ipsButton_secondary important'>{$this->lang->words['deny_request']}</a></li>
						</ul>
						
						<h3 class='ipsType_subtitle'>
							<strong><a href='{parse url="showuser={$friend['member_id']}" template="showuser" seotitle="{$friend['members_seo_name']}" base="public"}' title='{$this->lang->words['view_profile']}'>{$friend['members_display_name']}</a></strong>
						</h3>
						<if test="repson:|:$this->settings['reputation_enabled'] && $this->settings['reputation_show_profile']">
							<if test="norep:|:$friend['pp_reputation_points'] == 0 || !$friend['pp_reputation_points']">
								<p class='reputation zero ipsType_small left'>
							</if>
							<if test="posrep:|:$friend['pp_reputation_points'] > 0">
								<p class='reputation positive ipsType_small left'>
							</if>
							<if test="negrep:|:$friend['pp_reputation_points'] < 0">
								<p class='reputation negative ipsType_small left'>
							</if>							
									<span class='number'>{$friend['pp_reputation_points']}</span>
								</p>
						</if>
						<span class='desc'>
							{$this->lang->words['member_joined']} {parse date="$friend['joined']" format="joined"}<br />
							{IPSMember::makeNameFormatted( $friend['group'], $friend['member_group_id'] )} &middot; {parse format_number="$friend['posts']"} {$this->lang->words['member_posts']}
						</span>
					</div>
				</li>
			<else />
				<li id='member_id_{$friend['member_id']}' class='ipsPad clearfix member_entry {parse striping="memberStripe"}'>
					<a href='{parse url="showuser={$friend['member_id']}" template="showuser" seotitle="{$friend['members_seo_name']}" base="public"}' title='{$this->lang->words['view_profile']}' class='ipsUserPhotoLink left'><img src='http://mercury.raknet.ru/templates/style/img/avatars/{$friend['Char']}.png' alt="{parse expression="sprintf($this->lang->words['users_photo'],$friend['members_display_name'])"}" class='ipsUserPhoto ipsUserPhoto_medium' /></a>
					<div class='ipsBox_withphoto'>
						<ul class='ipsList_inline right'>
							<if test="weAreSupmod:|:$this->memberData['g_is_supmod'] == 1 && $friend['member_id'] != $this->memberData['member_id']">
								<li><a href='{parse url="app=core&amp;module=modcp&amp;do=editmember&amp;auth_key={$this->member->form_hash}&amp;mid={$friend['member_id']}&amp;pf={$friend['member_id']}" base="public"}' class='ipsButton_secondary'>{$this->lang->words['supmod_edit_member']}</a></li>
							</if>
							<if test="notus:|:$this->memberData['member_id'] AND $this->memberData['member_id'] != $friend['member_id'] && $this->settings['friends_enabled'] AND $this->memberData['g_can_add_friends']">
								<if test="addfriend:|:IPSMember::checkFriendStatus( $friend['member_id'] )">
									<li class='mini_friend_toggle is_friend' id='friend_mlist_{$friend['member_id']}'><a href='{parse url="app=members&amp;module=list&amp;module=profile&amp;section=friends&amp;do=remove&amp;member_id={$friend['member_id']}&amp;secure_key={$this->member->form_hash}" base="public"}' title='{$this->lang->words['remove_friend']}' class='ipsButton_secondary'>{parse replacement="remove_friend"}</a></li>
								<else />
									<li class='mini_friend_toggle is_not_friend' id='friend_mlist_{$friend['member_id']}'><a href='{parse url="app=members&amp;module=list&amp;module=profile&amp;section=friends&amp;do=add&amp;member_id={$friend['member_id']}&amp;secure_key={$this->member->form_hash}" base="public"}' title='{$this->lang->words['add_friend']}' class='ipsButton_secondary'>{parse replacement="add_friend"}</a></li>								
								</if>
							</if>
							<if test="sendpm:|:$this->memberData['g_use_pm'] AND $this->memberData['members_disable_pm'] == 0 AND IPSLib::moduleIsEnabled( 'messaging', 'members' ) && $friend['member_id'] != $this->memberData['member_id']">
								<li class='pm_button' id='pm_xxx_{$friend['pp_member_id']}'><a href='{parse url="app=members&amp;module=list&amp;module=messaging&amp;section=send&amp;do=form&amp;fromMemberID={$friend['pp_member_id']}" base="public"}' title='{$this->lang->words['pm_member']}' class='ipsButton_secondary'>{parse replacement="send_msg"}</a></li>
							</if>
							<li><a href='{parse url="app=core&amp;module=search&amp;do=user_activity&amp;mid={$friend['member_id']}" base="public"}' title='{$this->lang->words['gbl_find_my_content']}' class='ipsButton_secondary'>{parse replacement="find_topics_link"}</a></li>
							<if test="blog:|:$friend['has_blog'] AND IPSLib::appIsInstalled( 'blog' )">
								<li><a href='{parse url="app=blog&amp;module=display&amp;section=blog&amp;show_members_blogs={$friend['member_id']}" base="public"}' title='{$this->lang->words['view_blog']}' class='ipsButton_secondary'>{parse replacement="blog_link"}</a></li>
							</if>
							<if test="gallery:|:$friend['has_gallery'] AND IPSLib::appIsInstalled( 'gallery' )">
								<li><a href='{parse url="app=gallery&amp;user={$friend['member_id']}" seotitle="{$friend['members_seo_name']}" template="useralbum" base="public"}' title='{$this->lang->words['view_gallery']}' class='ipsButton_secondary'>{parse replacement="gallery_link"}</a></li>
							</if>
						</ul>
						
						<h3 class='ipsType_subtitle'>
							<strong><a href='{parse url="showuser={$friend['member_id']}" template="showuser" seotitle="{$friend['members_seo_name']}" base="public"}' title='{$this->lang->words['view_profile']}'>{$friend['members_display_name']}</a></strong>
						</h3>
						<if test="repson:|:$this->settings['reputation_enabled'] && $this->settings['reputation_show_profile']">
							<if test="norep:|:$friend['pp_reputation_points'] == 0 || !$friend['pp_reputation_points']">
								<p class='reputation zero ipsType_small left'>
							</if>
							<if test="posrep:|:$friend['pp_reputation_points'] > 0">
								<p class='reputation positive ipsType_small left'>
							</if>
							<if test="negrep:|:$friend['pp_reputation_points'] < 0">
								<p class='reputation negative ipsType_small left'>
							</if>							
									<span class='number'>{$friend['pp_reputation_points']}</span>
								</p>
						</if>
						<span class='desc'>
							{$this->lang->words['member_joined']} {parse date="$friend['joined']" format="joined"}<br />
							{IPSMember::makeNameFormatted( $friend['group'], $friend['member_group_id'] )} &middot; {parse format_number="$friend['posts']"} {$this->lang->words['member_posts']}
						</span>
					</div>
				</li>
			</if>
		
		</foreach>
	</ul>
<else />
	<p class='no_messages'>
		<if test="friendListNone:|:$this->request['tab'] == 'pending'">
			{$this->lang->words['no_friends_awaiting_approval']}
		<else />
			{$this->lang->words['no_friends_to_display']}
		</if>
	</p>
</if>{parse replacement="box_end"}
<if test="friendListPagesBottom:|:$pages">
	<div class='topic_controls'>
		{$pages}
	</div>
</if>]]></template_content>
      <template_name>friendsList</template_name>
      <template_data>$friends, $pages</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[{parse js_module="status"}
{parse js_module="rating"}
{parse js_module="profile"}
<script type='text/javascript'>
//<!#^#|CDATA|
	ipb.profile.viewingProfile = parseInt( {$member['member_id']} );
<if test="$this->memberData['member_id']">
	ipb.templates['remove_friend'] = "<a href='{parse url="app=members&amp;section=friends&amp;module=profile&amp;do=remove&amp;member_id={$member['member_id']}" base="public"}' title='{$this->lang->words['remove_as_friend']}'><img src='{$this->settings['img_url']}/user_delete.png' alt='{$this->lang->words['remove_as_friend']}' />&nbsp;&nbsp; {$this->lang->words['remove_as_friend']}</a>";
	ipb.templates['add_friend'] = "<a href='{parse url="app=members&amp;section=friends&amp;module=profile&amp;do=add&amp;member_id={$member['member_id']}" base="public"}' title='{$this->lang->words['add_me_friend']}'><img src='{$this->settings['img_url']}/user_add.png' alt='{$this->lang->words['add_me_friend']}' />&nbsp;&nbsp; {$this->lang->words['add_me_friend']}</a>";
</if>
	ipb.templates['edit_status'] = "<span id='edit_status'><input type='text' class='input_text' style='width: 60%' id='updated_status' maxlength='150' /> <input type='submit' value='{$this->lang->words['save']}' class='input_submit' id='save_status' /> &nbsp;<a href='#' id='cancel_status' class='cancel' title='{$this->lang->words['cancel']}'>{$this->lang->words['cancel']}</a></span>";
	<if test="friendsEnabled:|:$this->settings['friends_enabled'] AND $this->memberData['g_can_add_friends']">
		<if test="jsIsFriend:|:IPSMember::checkFriendStatus( $member['member_id'] )">
			ipb.profile.isFriend = true;
		<else />
			ipb.profile.isFriend = false;
		</if>
	</if>
//|#^#]>
</script>
<if test="hasCustomization:|:is_array($member['customization']) AND $member['customization']['type']">
	{parse template="customizeProfile" group="profile" params="$member"}
</if>
<if test="canEditUser:|:($this->memberData['member_id'] && $member['member_id'] == $this->memberData['member_id']) || $this->memberData['g_is_supmod'] == 1 || ($this->memberData['member_id'] && $member['member_id'] != $this->memberData['member_id'])">
<div class='clearfix'>
	<ul class='topic_buttons'>
		<if test="weAreSupmod:|:$this->memberData['g_is_supmod'] == 1 && $member['member_id'] != $this->memberData['member_id']">
			<li><a href='{parse url="app=core&amp;module=modcp&amp;do=editmember&amp;auth_key={$this->member->form_hash}&amp;mid={$member['member_id']}&amp;pf={$member['member_id']}" base="public"}'>{$this->lang->words['supmod_edit_member']}</a></li>
		</if>
		<if test="weAreOwner:|:$this->memberData['member_id'] && $member['member_id'] == $this->memberData['member_id']">
			<li><a href='{parse url="app=core&amp;module=usercp&amp;tab=core" base="public"}'>{$this->lang->words['edit_profile']}</a></li>
		</if>
		<if test="supModCustomization:|:($member['member_id'] == $this->memberData['member_id'] ) AND $member['customization']['type']">
			<li class='non_button'><a href='{parse url="showuser={$member['member_id']}&amp;secure_key={$this->member->form_hash}&amp;removeCustomization=1" seotitle="{$member['members_seo_name']}" template="showuser" base="public"}'>{$this->lang->words['cust_remove']}</a></li>
		</if>
	</ul>
</div>
</if>

{parse replacement="header_start"}<h3 class='maintitle'>{$member['members_display_name']}</h3>{parse replacement="header_end"}
<div class='ipsBox vcard' id='profile_background'>
	<div class='ipsVerticalTabbed ipsLayout ipsLayout_withleft ipsLayout_smallleft clearfix'>
		<div class='ipsVerticalTabbed_tabs ipsLayout_left' id='profile_tabs'>
			<p class='short photo_holder'>

				<img class="ipsUserPhoto" id='profile_photo' src='http://mercury.raknet.ru/templates/style/img/avatars/{$member['Char']}.png' alt="{parse expression="sprintf($this->lang->words['users_photo'],$member['members_display_name'])"}"  />
			</p>
			<if test="haswarn:|:$member['show_warn']">
				<div class='warn_panel clear ipsType_small'>
					<strong><a href='{parse url="app=members&amp;module=profile&amp;section=warnings&amp;member={$member['member_id']}&amp;from_app=members" base="public"}' id='warn_link_xxx_{$member['member_id']}' title='{$this->lang->words['warn_view_history']}'>{parse expression="sprintf( $this->lang->words['warn_status'], $member['warn_level'] )"}</a> </strong>
				</div>
			</if>
			<ul class='clear'>
				<li id='tab_link_core:info' class='tab_toggle <if test="$default_tab == 'core:info'">active</if>' data-tabid='user_info'><a href='#'>{$this->lang->words['pp_tab_info']}</a></li>
				<foreach loop="tabs:$tabs as $tab">
					<li id='tab_link_{$tab['app']}:{$tab['plugin_key']}' class='<if test="tabactive:|:$tab['app'].':'.$tab['plugin_key'] == $default_tab || $this->request['tab'] == $tab['plugin_key']">active</if> tab_toggle' data-tabid='{$tab['plugin_key']}'><a href='{parse url="showuser={$member['member_id']}&amp;tab={$tab['plugin_key']}" seotitle="{$member['members_seo_name']}" template="showuser" base="public"}' title='{$this->lang->words['view']} {$tab['_lang']}'>{$tab['_lang']}</a></li>
				</foreach>
			</ul>
		</div>
		<div class='ipsVerticalTabbed_content ipsLayout_content ipsBox_container' id='profile_content'>
			<div class='ipsPad'>
				<div id='profile_content_main'>
					<div id='user_info_cell'>
						<h1 class='ipsType_pagetitle'>
							<span class='fn nickname'>{$member['members_display_name']}</span>
						</h1>
						{$this->lang->words['m_member_since']} {parse date="$member['joined']" format="DATE"}<br />
                        <if test="hasWarns:|:!empty( $warns )">
                            <foreach loop="warnsLoop:array( 'ban', 'suspend', 'rpa', 'mq' ) as $k">
                                <if test="warnIsSet:|:isset( $warns[ $k ] )">
                                    <span class='ipsBadge ipsBadge_red<if test="warnClickable:|:$warns[ $k ]"> clickable</if>' <if test="warnPopup:|:$warns[ $k ]">onclick='warningPopup( this, {$warns[ $k ]} )'</if>>{$this->lang->words[ 'warnings_profile_badge_' . $k ]}</span>
                                </if>
                            </foreach>
                        </if>
						<if test="onlineDetails:|:$member['_online'] && ($member['online_extra'] != $this->lang->words['not_online'])">
							<span class='ipsBadge ipsBadge_green reset_cursor' data-tooltip="{parse expression="strip_tags($member['online_extra'])"}">{$this->lang->words['online_online']}</span>
						<else />
							<span class='ipsBadge ipsBadge_lightgrey reset_cursor'>{$this->lang->words['online_offline']}</span>
						</if>
						<span class='desc lighter'>{$this->lang->words['m_last_active']} {$member['_last_active']}</span> 
					</div>
					<if test="userStatus:|:$status['status_id']">
					<div id='user_status_cell'>
						<div id='user_latest_status'>
						<span class='status_arrow'></span>
							<div>
								{parse expression="IPSText::truncate( strip_tags( $status['status_content'] ), 180 )"}
								<span class='ipsType_smaller desc lighter blend_links'><a href='{parse url="app=members&amp;module=profile&amp;section=status&amp;type=single&amp;status_id={$status['status_id']}" seotitle="array($status['member_id'], $status['members_seo_name'])" template="members_status_single" base="public"}'>{$this->lang->words['ps_updated']} {parse date="$status['status_date']" format="manual{%d %b}" relative="true"} &middot; {parse expression="intval($status['status_replies'])"} {$this->lang->words['ps_comments']}</a></span>
							</div>
						</div>
					</div>
					</if>
					<if test="allowRate:|:$this->settings['pp_allow_member_rate']">
						<span class='rating left clear' style='margin-bottom: 10px'>
							<if test="noRateYourself:|:$this->memberData['member_id'] == $member['member_id'] || !$this->memberData['member_id']">
									<if test="rate1:|:$member['pp_rating_real'] >= 1">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if><if test="rate2:|:$member['pp_rating_real'] >= 2">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if><if test="rate3:|:$member['pp_rating_real'] >= 3">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if><if test="rate4:|:$member['pp_rating_real'] >= 4">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if><if test="rate5:|:$member['pp_rating_real'] >= 5">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if><span id='rating_text' class='desc'></span>
							<else />
									<a href='#' id='user_rate_1' title='{$this->lang->words['m_rate_1']}'><if test="rated1:|:$member['pp_rating_real'] >= 1">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if></a><a href='#' id='user_rate_2' title='{$this->lang->words['m_rate_2']}'><if test="rated2:|:$member['pp_rating_real'] >= 2">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if></a><a href='#' id='user_rate_3' title='{$this->lang->words['m_rate_3']}'><if test="rated3:|:$member['pp_rating_real'] >= 3">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if></a><a href='#' id='user_rate_4' title='{$this->lang->words['m_rate_4']}'><if test="rated4:|:$member['pp_rating_real'] >= 4">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if></a><a href='#' id='user_rate_5' title='{$this->lang->words['m_rate_5']}'><if test="rated5:|:$member['pp_rating_real'] >= 5">{parse replacement="rate_on"}<else />{parse replacement="rate_off"}</if></a> <span id='rating_text' class='desc'></span>
								<script type='text/javascript'>
									rating = new ipb.rating( 'user_rate_', { 
														url: ipb.vars['base_url'] + 'app=members&module=ajax&section=rate&member_id={$member['member_id']}&md5check=' + ipb.vars['secure_hash'],
														cur_rating: <if test="hasrating:|:isset($member['pp_rating_real'])">{$member['pp_rating_real']}<else />0</if>,
														rated: null,
														allow_rate: ( {$this->memberData['member_id']} != 0 ) ? 1 : 0,
														show_rate_text: false
													  } );
								</script>
							</if>
						</span>
					</if>
					<ul class='ipsList_inline' id='user_utility_links'>
						<if test="noFriendYourself:|:$this->memberData['member_id'] AND $this->memberData['member_id'] != $member['member_id'] && $this->settings['friends_enabled'] AND $this->memberData['g_can_add_friends']">
							<li id='friend_toggle' class='ipsButton_secondary'>
								<if test="isFriend:|:IPSMember::checkFriendStatus( $member['member_id'] )">
									<a href='{parse url="app=members&amp;section=friends&amp;module=profile&amp;do=remove&amp;member_id={$member['member_id']}&amp;secure_key={$this->member->form_hash}" base="public"}' title='{$this->lang->words['remove_friend']}'><img src='{$this->settings['img_url']}/user_delete.png' alt='{$this->lang->words['remove_friend']}' />&nbsp;&nbsp; {$this->lang->words['remove_as_friend']}</a>
								<else />
									<a href='{parse url="app=members&amp;section=friends&amp;module=profile&amp;do=add&amp;member_id={$member['member_id']}&amp;secure_key={$this->member->form_hash}" base="public"}' title='{$this->lang->words['add_friend']}'><img src='{$this->settings['img_url']}/user_add.png' alt='{$this->lang->words['add_friend']}' />&nbsp;&nbsp; {$this->lang->words['add_me_friend']}</a>
								</if>
							</li>
						</if>
						<if test="pmlink:|:($member['member_id'] != $this->memberData['member_id']) AND $this->memberData['g_use_pm'] AND $this->memberData['members_disable_pm'] == 0 AND IPSLib::moduleIsEnabled( 'messaging', 'members' ) AND $member['members_disable_pm'] == 0">
							<li class='pm_button' id='pm_xxx_{$member['member_id']}'><a href='{parse url="app=members&amp;module=messaging&amp;section=send&amp;do=form&amp;fromMemberID={$member['member_id']}" base="public"}' title='{$this->lang->words['pm_this_member']}' class='ipsButton_secondary'>{parse replacement="send_msg"}&nbsp;&nbsp; {$this->lang->words['send_message']}</a></li>
						</if>
						<li>
							<a href='{parse url="app=core&amp;module=search&amp;do=user_activity&amp;mid={$member['member_id']}" base="public"}' class='ipsButton_secondary'>{parse replacement="find_topics_link"}&nbsp;&nbsp;  {$this->lang->words['gbl_find_my_content']}</a>
						</li>
					</ul>
				</div>
				<div id='profile_panes_wrap' class='clearfix'>
					
					<div id='pane_core:info' class='ipsLayout ipsLayout_withright ipsLayout_largeright clearfix' <if test="$default_tab != 'core:info'">style='display: none'</if>>						
						<div class='ipsLayout_content'>
							<if test="$member['pp_about_me']">
								<div class='general_box clearfix'>
									<h3>{$this->lang->words['pp_tab_aboutme']}</h3>
									<div class='ipsPad'>
										
											{$member['pp_about_me']}
										
									</div>
								</div>
								<hr/>
							</if>
							<div class='general_box clearfix'>
								<h3>{$this->lang->words['community_stats']}</h3>
								<ul class='ipsList_data clearfix'>									
									<li class='clear clearfix'>
										<span class='row_title'>{$this->lang->words['m_group']}</span>
										<span class='row_data'>{$member['g_title']}</span>
									</li>
									<!--<li class='clear clearfix'>
										<span class='row_title'>{$this->lang->words['m_posts']}</span>
										<span class='row_data'>{parse format_number="$member['posts']"}</span>
									</li>-->
									<li class='clear clearfix'>
										<span class='row_title'>{$this->lang->words['m_profile_views']}</span>
										<span class='row_data'>{parse format_number="$member['members_profile_views']"}</span>
									</li>
									<if test="member_title:|:$member['title'] != ''">
										<li class='clear clearfix'>
											<span class='row_title'>{$this->lang->words['m_member_title']}</span>
											<span class='row_data'>{$member['title']}</span>
										</li>
									</if>
									<li class='clear clearfix'>
										<span class='row_title'>{$this->lang->words['m_age_prefix']}</span>
										<if test="member_age:|:$member['_age'] > 0">
											<span class='row_data'>{$member['_age']} {$this->lang->words['m_years_old']}</span>
										<else />
											<span class='row_data desc lighter'>{$this->lang->words['m_age_unknown']}</span>
										</if>
									</li>
									<li class='clear clearfix'>
										<span class='row_title'>{$this->lang->words['m_birthday_prefix']}</span>
										<if test="member_birthday:|:$member['bday_day']">
											<span class='row_data'>{$member['_bday_month']} {$member['bday_day']}<if test="member_bday_year:|:$member['bday_year']">, {$member['bday_year']}</if></span>
										<else />
											<span class='row_data desc lighter'>{$this->lang->words['m_bday_unknown']}</span>
										</if>
									</li>
									<if test="pcfields:|:$member['custom_fields']['profile_info'] != """>
										<foreach loop="pcfieldsLoop:$member['custom_fields']['profile_info'] as $key => $value">
											<if test="!empty($value)"><li class='clear clearfix'>
												{$value}
											</li></if>
										</foreach>
									</if>
								</ul>
							</div>
							
							<if test="pcfieldsOther:|:$member['custom_fields']">
								<foreach loop="pcfieldsOtherLoop:$member['custom_fields'] as $group => $mdata">
									<if test="pcfieldsOtherLoopCheck:|:$group != 'profile_info' AND $group != 'contact'">
										<if test="pcfieldsOtherLoopCheck2:|:is_array( $member['custom_fields'][ $group ] ) AND count( $member['custom_fields'][ $group ] )">
											<div class='general_box clearfix' id='custom_fields_{$group}'>
												<h3 class='bar'>{$member['custom_field_groups'][ $group ]}</h3>
												<br />
												<ul class='ipsList_data clearfix'>
													<foreach loop="pcfieldsOtherLoopCheckInner:$member['custom_fields'][ $group ] as $key => $value">
														<if test="$value"><li class='clear clearfix'>{$value}</li></if>
													</foreach>
												</ul>
											</div>
										</if>
									</if>
								</foreach>
							</if>
							
							<if test="hasContactFields:|:$this->memberData['g_access_cp'] == 1 || is_array( $member['custom_fields']['contact'] )">
								<div class='general_box clearfix'>
									<if test="showContactHead:|:$this->memberData['g_access_cp'] == 1 || $show_contact"><h3>{$this->lang->words['contact_info']}</h3></if>						
									<ul class='ipsList_data clearfix'>
										<if test="isadmin:|:$this->memberData['g_access_cp'] == 1">
											<li class='clear clearfix'>
												<span class='row_title'>{$this->lang->words['m_email']}</span>
												<span class='row_data'>
													<a href='mailto:{$member['email']}'>{$member['email']}</a>
												</span>
											</li>
										</if>
										<if test="member_contact_fields:|:is_array( $member['custom_fields']['contact'])">
											<foreach loop="cfields:$member['custom_fields']['contact'] as $field">
												<if test="$field">{$field}</if>
											</foreach>
										</if>
									</ul>
								</div>
							</if>
						</div>
						
						<div class='ipsLayout_right'>
							<if test="ourReputation:|:$this->settings['reputation_enabled'] && $this->settings['reputation_show_profile']">
								<if test="RepPositive:|:$member['pp_reputation_points'] > 0">
									<div class='reputation positive' data-tooltip="{parse expression="sprintf( $this->lang->words['rep_description'], $member['members_display_name'], $member['pp_reputation_points'])"}">
								</if>
								<if test="RepNegative:|:$member['pp_reputation_points'] < 0">
									<div class='reputation negative' data-tooltip="{parse expression="sprintf( $this->lang->words['rep_description'], $member['members_display_name'], $member['pp_reputation_points'])"}">
								</if>
								<if test="RepZero:|:$member['pp_reputation_points'] == 0">
									<div class='reputation zero' data-tooltip="{parse expression="sprintf( $this->lang->words['rep_description'], $member['members_display_name'], $member['pp_reputation_points'])"}">
								</if>
										<span class='number'>{$member['pp_reputation_points']}</span>
										<if test="RepText:|:$member['author_reputation'] && $member['author_reputation']['text']">
											<span class='title'>{$member['author_reputation']['text']}</span>
										</if>
										<if test="RepImage:|:$member['author_reputation'] && $member['author_reputation']['image']">
											<span class='image'><img src='{$member['author_reputation']['image']}' alt='{$this->lang->words['m_reputation']}' /></span>
										</if>
									</div>
								
								<br />
							</if>
							
							<if test="checkModTools:|:($member['spamStatus'] !== NULL && $member['member_id'] != $this->memberData['member_id']) || ($this->memberData['g_mem_info'] && $this->settings['auth_allow_dnames']) || (($member['member_id'] != $this->memberData['member_id'] AND $this->memberData['g_is_supmod'] ) AND $member['customization']['type'])">
								<div class='general_box clearfix'>
									<h3>{$this->lang->words['user_tools']}</h3>
									<ul class='ipsList_data'>	
										<if test="authorspammer:|:$member['spamStatus'] !== NULL && $member['member_id'] != $this->memberData['member_id']">
											<if test="authorspammerinner:|:$member['spamStatus'] === TRUE">
												<li><a href='#' onclick="return ipb.global.toggleFlagSpammer({$member['member_id']}, false)">{parse replacement="spammer_on"}&nbsp; {$this->lang->words['spm_on']}</a></li>
											<else />
												<li><a href='{$this->settings['base_url']}app=core&amp;module=modcp&amp;do=setAsSpammer&amp;member_id={$member['member_id']}&amp;auth_key={$this->member->form_hash}' onclick="return ipb.global.toggleFlagSpammer({$member['member_id']}, true)">{parse replacement="spammer_off"}&nbsp; {$this->lang->words['spm_off']}</a></li>
											</if>
										</if>
										<if test="dnameHistory:|:$this->memberData['member_id'] && $this->memberData['g_mem_info'] && $this->settings['auth_allow_dnames']">
											<li id='dname_history'><a href='{parse url="app=members&amp;module=profile&amp;section=dname&amp;id={$member['member_id']}" base="public"}' title='{$this->lang->words['view_dname_history']}'>{parse replacement="display_name"}&nbsp; {$this->lang->words['display_name_history']}</a></li>
										</if>
								
										<if test="supModCustomizationDisable:|:($member['member_id'] != $this->memberData['member_id'] AND $this->memberData['g_is_supmod'] ) AND $member['customization']['type']">
											<li><strong><a href='{parse url="showuser={$member['member_id']}&amp;secure_key={$this->member->form_hash}&amp;removeCustomization=1" seotitle="{$member['members_seo_name']}" template="showuser" base="public"}'><img src='{$this->settings['img_url']}/delete.png' alt='-' />&nbsp; {$this->lang->words['cust_remove']}</a></strong></li>
											<li><strong><a href='{parse url="showuser={$member['member_id']}&amp;secure_key={$this->member->form_hash}&amp;removeCustomization=1&amp;disableCustomization=1" seotitle="{$member['members_seo_name']}" template="showuser" base="public"}'><img src='{$this->settings['img_url']}/delete.png' alt='-' />&nbsp; {$this->lang->words['cust_disable']}</a></strong></li>
										</if>
									</ul>
								</div>
							</if>
							
							<if test="$member['pp_setting_count_friends'] and $this->settings['friends_enabled']">
								<div class='general_box clearfix' id='friends_overview'>
									<h3>{$this->lang->words['m_title_friends']}</h3>
									<div class='ipsPad'>
										<if test="hasFriends:|:count($friends) AND is_array($friends)">
											<foreach loop="friendsLoop:$friends as $friend">
												<a href='{parse url="showuser={$friend['member_id']}" base="public" template="showuser" seotitle="{$friend['members_seo_name']}"}' class='ipsUserPhotoLink'>
													<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$friend['Char']}.png' class='ipsUserPhoto ipsUserPhoto_mini' data-tooltip='{$friend['members_display_name']}' />
												</a>
											</foreach>
										<else />
											<p class='desc'>
												{$member['members_display_name']} {$this->lang->words['no_friends_yet']}
											</p>
										</if>
									</div>
								</div>
							</if>
							
							<if test="latest_visitors:|:$member['pp_setting_count_visitors']">
								<div class='general_box clearfix'>
									<h3>{$this->lang->words['latest_visitors']}</h3>
									<if test="has_visitors:|:is_array( $visitors ) && count( $visitors )">
										<ul class='ipsList_withminiphoto'>
											<foreach loop="latest_visitors_loop:$visitors as $visitor">
											<li class='clearfix'>
												<if test="visitorismember:|:$visitor['member_id']">
													<a href='{parse url="showuser={$visitor['member_id']}" seotitle="{$visitor['members_seo_name']}" template="showuser" base="public"}' title='{$this->lang->words['view_profile']}' class='ipsUserPhotoLink left'><img src='http://mercury.raknet.ru/templates/style/img/avatars/{$visitor['Char']}.png' alt='{$this->lang->words['photo']}' class='ipsUserPhoto ipsUserPhoto_mini' /></a>
												<else />
													<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$visitor['Char']}.png' alt='{$this->lang->words['photo']}' class='ipsUserPhoto ipsUserPhoto_mini left' />
												</if>
												<div class='list_content'>
													{parse template="userHoverCard" group="global" params="$visitor"}
													<br />
													<span class='desc lighter'>{$visitor['_visited_date']}</span>
												</div>
											</li>				
											</foreach>
										</ul>
									<else />
										<p class='ipsPad desc'>{$this->lang->words['no_latest_visitors']}</p>
									</if>
								</div>
							</if>
						</div>					
					</div>
					
					<if test="$default_tab != 'core:info'">
					<div id='pane_{$default_tab}'>
						{$default_tab_content}
					</div>
					</if>
				</div>				
				
			</div>			
		</div>
		
	</div>
</div>{parse replacement="box_end"}
<if test="thisIsNotUs:|:($this->memberData['member_id'] && $member['member_id'] != $this->memberData['member_id'])">
	<br />
	<ul class='topic_buttons'>
		<li class='non_button clearfix'><a href='{parse url="app=core&amp;module=reports&amp;section=reports&amp;rcom=profiles&amp;member_id={$member['member_id']}" base="public"}'>{$this->lang->words['report_member']}</a></li>
	</ul>
</if>
<script type='text/javascript'>
	$("profile_content").setStyle( { minHeight: $('profile_tabs').measure('margin-box-height') + 138 + "px" } );
</script>

<!-- ******************************************************************************************* -->
{parse template="include_highlighter" group="global" params=""}]]></template_content>
      <template_name>profileModern</template_name>
      <template_data><![CDATA[$tabs=array(), $member=array(), $visitors=array(), $default_tab='status', $default_tab_content='', $friends=array(), $status=array()]]></template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[<php>
$_first = reset($updates);
</php>
{parse js_module="status"}
{parse striping="recent_status" classes="row1,row2 altrow"}
<h1 class='ipsType_pagetitle'>{$this->lang->words['status_updates__overview']}</h1>
<br />
<div id='status_standalone_page'>
	{parse replacement="header_start"}<div class='maintitle ipsFilterbar'>
		<ul class='ipsList_inline'>
			<li id='status_all' class='<if test="tabactive:|:! $this->request['status_id'] AND ! $this->request['member_id'] AND ! $this->request['type'] OR $this->request['type'] == 'all'">active</if>'><a href='{parse url="app=members&amp;module=profile&amp;section=status&amp;type=all" seotitle="true" template="members_status_all" base="public"}'>{$this->lang->words['status__all_updates']}</a></li>
			<if test="$this->memberData['member_id'] AND $this->settings['friends_enabled']">
				<li id='status_all' class='tab_toggle <if test="tabactive2:|:$this->request['type'] == 'friends'">active</if>'><a href='{parse url="app=members&amp;module=profile&amp;section=status&amp;type=friends" seotitle="true" template="members_status_friends" base="public"}'>{$this->lang->words['status__myfriends']}</a></li>
			</if>
			<if test="$this->request['member_id']">
				<li id='status_by_id' class='active'><a href='{parse url="app=members&amp;module=profile&amp;section=status&amp;type=memberall&amp;member_id={$this->request['member_id']}" seotitle="array( $this->request['member_id'], $_first['members_seo_name'] )" template="members_status_member_all" base="public"}'>{$this->lang->words['status__membersupdats']}</a></li>
			</if>
			<if test="$this->request['status_id']">
				<li id='status_by_sid' class='active'><a href='#'>{$this->lang->words['status__singleupdate']}</a></li>
			</if>
		</ul>
	</div>{parse replacement="header_end"}
	<if test="canCreate:|:$this->memberData['member_id'] AND $this->registry->getClass('memberStatus')->canCreate( $this->memberData )">
		<div class='status_update row2'>
			<form id='statusForm' action='{$this->settings['base_url']}app=members&amp;module=profile&amp;section=status&amp;do=new&amp;k={$this->member->form_hash}&amp;id={$this->memberData['member_id']}' method='post'>
			<input type='text' id='statusUpdate_page' name='content' style='width:70%' class='input_text'> <input type='submit' class='input_submit' id='statusSubmit_page' value='{$this->lang->words['gbl_post']}' />
			<if test="update:|:(IPSLib::twitter_enabled() OR IPSLib::fbc_enabled() ) AND ( $this->memberData['fb_uid'] OR $this->memberData['twitter_id'] )">
				<p class='desc' style='padding-top:5px;'>{$this->lang->words['st_update']}
					<if test="updateTwitter:|:IPSLib::twitter_enabled() AND ( $this->memberData['twitter_id'] )"><input type='checkbox' id='su_Twitter' value='1' name='su_Twitter' /> <img src="{$this->settings['public_dir']}style_status/twitter.png" style='vertical-align:top' alt='' /></if>
					<if test="updateFacebook:|:IPSLib::fbc_enabled() AND ( $this->memberData['fb_uid'] )"><input type='checkbox' id='su_Facebook' value='1' name='su_Facebook' /> <img src="{$this->settings['public_dir']}style_status/facebook.png" style='vertical-align:top' alt='' /></if>
				</p>
			</if>
			</form>
		</div>
	</if>
	<div id="status_wrapper" class='ipsBox'>
		<if test="hasUpdates:|:count( $updates )">
			{parse template="statusUpdates" group="profile" params="$updates"}
		<else />
			<p class='no-status'>{$this->lang->words['status_updates_none']}</p>
		</if>
	</div>{parse replacement="box_end"}
<if test="hasPagination:|:$pages">
	<div class='topic_controls clearfix'>
		{$pages}
	</div>
</if>
</div>]]></template_content>
      <template_name>statusUpdatesPage</template_name>
      <template_data><![CDATA[$updates=array(), $pages='']]></template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[<div class='general_box'>
	<if test="friends:|:$this->settings['friends_enabled'] AND $this->memberData['g_can_add_friends'] AND $member['pp_setting_count_friends']">
		<div class='friend_list clear' id='friend_list'>
			<h3>{$this->lang->words['m_title_friends']}</h3>
			<if test="friends_loop:|:is_array($friends) and count($friends)">
				<ul class='clearfix'>
				<foreach loop="friends:$friends as $friend">
					<li>
						<a href='{parse url="showuser={$friend['member_id']}" seotitle="{$friend['members_seo_name']}" template="showuser" base="public"}' title='{$this->lang->words['view_profile']}' class='ipsUserPhotoLink'>
							<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$friend['Char']}.png' alt='{$this->lang->words['photo']}' class='ipsUserPhoto ipsUserPhoto_medium' />
						</a><br />
						<span class='name'>
							{parse expression="IPSMember::makeProfileLink($friend['members_display_name_short'], $friend['member_id'], $friend['members_seo_name'])"}
						</span>
					</li>
				</foreach>
				</ul>				
			<else />
				<p class='ipsPad'>
					<em>{$member['members_display_name']} {$this->lang->words['no_friends_yet']}</em>
				</p>
			</if>
		</div>
<br />
        {$pagination}
	</if>
</div>]]></template_content>
      <template_name>tabFriends</template_name>
      <template_data>$friends=array(), $member=array()</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[<div class='content_border'><div class='no_messages row1'>{$this->lang->words[ $langkey ]}</div></div>]]></template_content>
      <template_name>tabNoContent</template_name>
      <template_data>$langkey</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[<div class='content_border'>
	{$content}
</div>]]></template_content>
      <template_name>tabPosts</template_name>
      <template_data>$content</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[{parse striping="recent_status" classes="row1,row2"}
<div class='content_border'><h3 class='bar noTopBorder'>{$this->lang->words['pp_tab_statusupdates']}</h3>
<if test="canCreate:|:$this->memberData['member_id'] AND ( $this->memberData['member_id'] == $member['member_id'] ) AND $this->registry->getClass('memberStatus')->canCreate( $member )">
	<div class='status_update'>
		<form id='statusForm' action='{$this->settings['base_url']}app=members&amp;module=profile&amp;section=status&amp;do=new&amp;k={$this->member->form_hash}&amp;id={$this->memberData['member_id']}&amp;forMemberId={$member['member_id']}' method='post'>
		<input type='text' name='content' id='statusUpdate_page' class='input_text' /> <input type='submit' class='input_submit' id='statusSubmit_page' value='{$this->lang->words['gbl_post']}' />
		<if test="update:|:( IPSLib::loginMethod_enabled('facebook') AND $this->memberData['fb_uid'] ) OR ( IPSLib::loginMethod_enabled('twitter') AND $this->memberData['twitter_id'] )">
			<p class='desc' style='padding-top:5px;'>{$this->lang->words['st_update']}
				<if test="updateTwitter:|:IPSLib::loginMethod_enabled('twitter') AND $this->memberData['twitter_id']"><input type='checkbox' id='su_Twitter' value='1' name='su_Twitter' /> <img src="{$this->settings['public_dir']}style_status/twitter.png" style='vertical-align:top' alt='' /></if>
				<if test="updateFacebook:|:IPSLib::loginMethod_enabled('facebook') AND $this->memberData['fb_uid']">&nbsp;<input type='checkbox' id='su_Facebook' value='1' name='su_Facebook' /> <img src="{$this->settings['public_dir']}style_status/facebook.png" style='vertical-align:top' alt='' /></if>
			</p>
		</if>
		</form>
	</div>
</if>
<if test="leave_comment:|:$this->memberData['member_id'] && $this->memberData['member_id'] != $member['member_id'] && $member['pp_setting_count_comments'] AND $this->registry->getClass('memberStatus')->canCreate( $this->memberData, $member )">
	<div class='status_update'>
		<form id='commentForm' action='{$this->settings['base_url']}app=members&amp;module=profile&amp;section=status&amp;do=new&amp;k={$this->member->form_hash}&amp;id={$this->memberData['member_id']}&amp;forMemberId={$member['member_id']}' method='post'>
				<input type='hidden' name='member_id' value='{$member['member_id']}' />
				<input type='hidden' name='auth_key' value='{$this->member->form_hash}' />
				<div id='post_comment'>
					<input type='text' class='input_text' cols='50' rows='3' id='statusUpdate_page' name='content' data-for-member-id="{$member['member_id']}" />
					<input type='submit' class='ipsButton' value='{$this->lang->words['comment_submit_post']}' data-for-member-id="{$member['member_id']}" id='statusSubmit_page' />
				</div> 
		</form>
	</div>
</if>
<div class='ipsBox clearfix'>
	<div id="status_wrapper" data-member="{$member['member_id']}">
		<if test="hasUpdates:|:count( $updates )">
			{parse template="statusUpdates" group="profile" params="$updates"}
			<div class='short'>
				<a href='{parse url="app=members&amp;module=profile&amp;section=status&amp;type=memberall&amp;member_id={$member['member_id']}" seotitle="array($member['member_id'], $member['members_seo_name'])" template="members_status_member_all" base="public"}' class='ipsButton_secondary'>{$this->lang->words['status__viewall']}</a>
			</div>
		<else />
			<p class='ipsBox_container ipsPad' id='noStatusUpdates'>{$this->lang->words['status_updates_none']}</p>
		</if>
	</div>
</div>
</div>]]></template_content>
      <template_name>tabStatusUpdates</template_name>
      <template_data>$updates=array(), $actions, $member=array()</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[<div class='content_border'>
	{$content}
</div>]]></template_content>
      <template_name>tabTopics</template_name>
      <template_data>$content</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[<div class='vcard userpopup'>
	<h3><a href="{parse url="showuser={$member['member_id']}" seotitle="{$member['members_seo_name']}" template="showuser" base="public"}" class="fn nickname url">{$member['members_display_name']}</a></h3>
	<div class='side left ipsPad'>
		<a href="{parse url="showuser={$member['member_id']}" seotitle="{$member['members_seo_name']}" template="showuser" base="public"}" class="ipsUserPhotoLink">
			<img src="http://mercury.raknet.ru/templates/style/img/avatars/{$member['Char']}.png" alt="{$this->lang->words['get_photo']}" class='ipsUserPhoto ipsUserPhoto_medium' />
		</a>
		<br />
		<if test="cardRep:|:$this->settings['reputation_enabled'] && $this->settings['reputation_show_profile']">
			<if test="cardRepPos:|:$member['pp_reputation_points'] > 0">
				<div class='reputation positive'>
			</if>
			<if test="cardRepNeg:|:$member['pp_reputation_points'] < 0">
				<div class='reputation negative'>
			</if>
			<if test="cardRepZero:|:$member['pp_reputation_points'] == 0">
				<div class='reputation zero'>
			</if>
					<span class='number'>{$member['pp_reputation_points']}</span>
				</div>
		</if>
		<a href='{parse url="app=core&amp;module=search&amp;do=user_activity&amp;mid={$member['member_id']}" base="public"}' title='{$this->lang->words['gbl_find_my_content']}' class='ipsButton_secondary ipsType_smaller'>{$this->lang->words['gbl_find_my_content']}</a>
		<if test="cardSendPm:|:$this->memberData['member_id'] AND $this->memberData['member_id'] != $member['member_id'] AND $this->memberData['g_use_pm'] AND $this->memberData['members_disable_pm'] == 0 AND IPSLib::moduleIsEnabled( 'messaging', 'members' ) AND $member['members_disable_pm'] == 0">
			<a href='{parse url="app=members&amp;module=messaging&amp;section=send&amp;do=form&amp;fromMemberID={$member['member_id']}" base="public"}' title='{$this->lang->words['pm_this_member']}' id='pm_xxx_{$member['member_id']}' class='pm_button ipsButton_secondary ipsType_smaller'>{$this->lang->words['pm_this_member']}</a>
		</if>
	</div>
	<div class='ipsPad'>
		<if test="cardStatus:|:$member['_status']['status_content']">
			<p class='message user_status'>{$member['_status']['status_content']}</p>
		</if>
		<div class='info'>
			<dl>
				<dt>{$this->lang->words['m_group']}</dt>
				<dd>{$member['_group_formatted']}</dd>

				<dt>{$this->lang->words['m_member_since']}</dt>
				<dd>{parse date="$member['joined']" format="joined"}</dd>
				<dt>{$this->lang->words['m_last_active']}</dt>
				<dd><if test="cardOnline:|:$member['_online']"><span class='ipsBadge ipsBadge_green'>{$this->lang->words['online_online']}</span><else /><span class='ipsBadge ipsBadge_grey'>{$this->lang->words['online_offline']}</span></if> {$member['_last_active']}</dd>
				<if test="cardWhere:|:$member['_online'] && ($member['online_extra'] != $this->lang->words['not_online'])">
					<dt>{$this->lang->words['m_currently']}</dt>
					<dd>
						{$member['online_extra']}
					</dd>
				</if>
				<if test="isadmin:|:$this->memberData['g_access_cp'] == 1">
					<dt>{$this->lang->words['m_email']}</dt>
					<dd><a href='mailto:{$member['email']}'>{$member['email']}</a></dd>
				</if>
			</dl>
		</div>
		<ul class='user_controls clear'>
			<if test="authorspammer:|:$member['spamStatus'] !== NULL && $member['member_id'] != $this->memberData['member_id']">
				<if test="authorspammerinner:|:$member['spamStatus'] === TRUE">
					<li><a href='#' title='{$this->lang->words['spm_on']}' onclick="return ipb.global.toggleFlagSpammer({$member['member_id']}, false)">{parse replacement="spammer_on"}</a></li>
				<else />
					<li><a title='{$this->lang->words['spm_off']}' href='{$this->settings['base_url']}app=core&amp;module=modcp&amp;do=setAsSpammer&amp;member_id={$member['member_id']}&amp;auth_key={$this->member->form_hash}' onclick="return ipb.global.toggleFlagSpammer({$member['member_id']}, true)">{parse replacement="spammer_off"}</a></li>
				</if>
			</if>
			<if test="cardFriend:|:$this->memberData['member_id'] AND $this->memberData['member_id'] != $member['member_id'] && $this->settings['friends_enabled'] AND $this->memberData['g_can_add_friends']">
				<if test="cardIsFriend:|:IPSMember::checkFriendStatus( $member['member_id'] )">
					<li><a href='{parse url="app=members&amp;module=profile&amp;section=friends&amp;do=remove&amp;member_id={$member['member_id']}&amp;secure_key={$this->member->form_hash}" base="public"}' title='{$this->lang->words['remove_friend']}'>{parse replacement="remove_friend"}</a></li>
				<else />
					<li><a href='{parse url="app=members&amp;module=profile&amp;section=friends&amp;do=add&amp;member_id={$member['member_id']}&amp;secure_key={$this->member->form_hash}" base="public"}' title='{$this->lang->words['add_friend']}'>{parse replacement="add_friend"}</a></li>
				</if>
			</if>
			<if test="cardBlog:|:$member['has_blog'] AND IPSLib::appIsInstalled( 'blog' )">
				<li><a href='{parse url="app=blog&amp;module=display&amp;section=blog&amp;show_members_blogs={$member['member_id']}" base="public"}' title='{$this->lang->words['view_blog']}'>{parse replacement="blog_link"}</a></li>
			</if>
			<if test="cardGallery:|:$member['has_gallery'] AND IPSLib::appIsInstalled( 'gallery' )">
				<li><a href='{parse url="app=gallery&amp;user={$member['member_id']}" seotitle="{$member['members_seo_name']}" template="useralbum" base="public"}' title='{$this->lang->words['view_gallery']}'>{parse replacement="gallery_link"}</a></li>
			</if>
		</ul>
	</div>
</div>]]></template_content>
      <template_name>showCard</template_name>
      <template_data>$member, $download=0</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[<div class='ipsBox'>
	<foreach loop="$results as $data">
		<if test="$data['type'] == 'comment_id'">
			<div class='post_block hentry clear no_sidebar ipsBox_container'>
				<div class='post_wrap'>
					<if test="postMid:|:$data['comment_mid']">
						<h3 class='row2'>
					<else />
						<h3 class='guest row2'>
					</if>
						<a href="{parse url="app=calendar&amp;module=calendar&amp;section=view&amp;do=showevent&amp;event_id={$data['event_id']}" template="cal_event" seotitle="{$data['event_title_seo']}" base="public"}">{IPSText::truncate( $data['event_title'], 80)}</a>
					</h3>
					<div class='post_body'>
						<p class='posted_info desc lighter ipsType_small'>
							<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$data['Char']}.png' class='ipsUserPhoto ipsUserPhoto_tiny' /> {$this->lang->words['posted']} {$this->lang->words['by']}
							<if test="postMember:|:$data['member_id']"><span class="author vcard">{parse template="userHoverCard" group="global" params="$data"}</span><else />{$data['members_display_name']}</if>
							{$this->lang->words['on']} <abbr class="published" title="{parse expression="date( 'c', $data['comment_date'] )"}">{parse date="$data['comment_date']" format="long"}</abbr>
							{$this->lang->words['cal_in']}
							<a href="{parse url="app=calendar&amp;module=calendar&amp;section=view&amp;do=showevent&amp;event_id={$data['event_id']}" template="cal_event" seotitle="{$data['event_title_seo']}" base="public"}">{$data['event_title']}</a>
						</p>
						<div class='post entry-content clearfix'>
							{$data['comment_text']}
							<br />
							{parse template="repButtons" group="global_other" params="$data['author'], array_merge( array( 'primaryId' => $data['comment_id'], 'domLikeStripId' => 'like_comment_id_' . $data['comment_id'], 'domCountId' => 'rep_comment_id_' . $data['comment_id'], 'app' => 'calendar', 'type' => 'comment_id', 'likeFormatted' => $data['repButtons']['formatted'] ), $data )"}
						</div>
					</div>
				</div>
				<br />
			</div>
			<br />
		<else />
			<div class='post_block hentry clear no_sidebar ipsBox_container'>
				<div class='post_wrap'>
					<if test="postMid:|:$data['event_member_id']">
						<h3 class='row2'>
					<else />
						<h3 class='guest row2'>
					</if>
						<a href="{parse url="app=calendar&amp;module=calendar&amp;section=view&amp;do=showevent&amp;event_id={$data['event_id']}" template="cal_event" seotitle="{$data['event_title_seo']}" base="public"}">{IPSText::truncate( $data['event_title'], 80)}</a>
					</h3>
					<div class='post_body'>
						<p class='posted_info desc lighter ipsType_small'>
							<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$data['Char']}.png' class='ipsUserPhoto ipsUserPhoto_tiny' /> {$this->lang->words['posted']} {$this->lang->words['by']}
							<if test="postMember:|:$data['member_id']"><span class="author vcard">{parse template="userHoverCard" group="global" params="$data"}</span><else />{$data['members_display_name']}</if>
							{$this->lang->words['on']} <abbr class="published" title="{parse expression="date( 'c', $data['event_saved'] )"}">{parse date="$data['event_saved']" format="long"}</abbr>
						</p>
						<div class='post entry-content clearfix'>
							{$data['event_content']}
							<br />
							{parse template="repButtons" group="global_other" params="$data, array_merge( array( 'primaryId' => $data['event_id'], 'domLikeStripId' => 'like_event_id_' . $data['event_id'], 'domCountId' => 'rep_event_id_' . $data['event_id'], 'app' => 'calendar', 'type' => 'event_id', 'likeFormatted' => $data['repButtons']['formatted'] ), $data )"}
						</div>
					</div>
				</div>
				<br />
			</div>
			<br />
		</if>
	</foreach>
</div>]]></template_content>
      <template_name>tabReputation_calendar</template_name>
      <template_data>$results</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_profile</template_group>
      <template_content><![CDATA[<div class='ipsBox'>
	<foreach loop="$results as $data">
		<div class='post_block hentry clear no_sidebar ipsBox_container'>
			<div class='post_wrap'>
				<h3 class='<if test="postMid:|:$data['member_id']">guest </if>row2'>
					<span class='post_id right ipsType_small desc blend_links'><a href='{parse url="showtopic={$data['topic_id']}&amp;view=findpost&amp;p={$data['pid']}" template="showtopic" seotitle="{$data['title_seo']}" base="public"}' rel='bookmark' title='{$data['topic_title']}{$this->lang->words['link_to_post']} #{$data['pid']}'>#{$data['pid']}</a></span>
					<a href="{parse url="showtopic={$data['tid']}" seotitle="{$data['title_seo']}" template="showtopic" base="public"}">{IPSText::truncate( $data['topic_title'], 80)}</a>
				</h3>
				<div class='post_body'>
					<p class='posted_info desc lighter ipsType_small'>
						<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$data['Char']}.png' class='ipsUserPhoto ipsUserPhoto_tiny' /> {$this->lang->words['posted_by']} <if test="postMember:|:$data['member_id']"><span class="author vcard">{parse template="userHoverCard" group="global" params="$data"}</span><else />{parse template="userHoverCard" group="global" params="$data"}</if>
						{$this->lang->words['on']} <abbr class="published" title="{parse expression="date( 'c', $data['post_date'] )"}">{parse date="$data['post_date']" format="long"}</abbr>
						<if test="hasForumTrail:|:$data['_forum_trail']">
							in
							<foreach loop="topicsForumTrail:$data['_forum_trail'] as $i => $f">
								<if test="notLastFtAsForum:|:$i+1 == count( $data['_forum_trail'] )"><a href='{parse url="{$f[1]}" template="showforum" seotitle="{$f[2]}" base="public"}'>{$f[0]}</a></if>
							</foreach>
						</if>
					</p>
					<div class='post entry-content clearfix'>
						{$data['post']}
						<br />
						{parse template="repButtons" group="global_other" params="$data, array_merge( array( 'primaryId' => $data['pid'], 'domLikeStripId' => 'like_post_' . $data['pid'], 'domCountId' => 'rep_post_' . $data['pid'], 'app' => 'forums', 'type' => 'pid', 'likeFormatted' => $data['repButtons']['formatted'], 'has_given_rep' => $data['repButtons']['iLike'] ), $data )"}
					</div>
				</div>
			</div>
			<br />
		</div>
		<br />
	</foreach>
</div>]]></template_content>
      <template_name>tabReputation_posts</template_name>
      <template_data>$results</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
  </templategroup>
  <templategroup group="skin_ucp">
    <template>
      <template_group>skin_ucp</template_group>
      <template_content><![CDATA[<h3 class='ipsType_subtitle'>{$this->lang->words['m_attach']}</h3>
<br />
<div class='row1'>	
	<if test="hasAttachLimit:|:$info['has_limit'] == 1">
		<div id='space_allowance' class='general_box'>
			<p><strong>{$info['attach_space_used']}</strong></p>
			<p class='progress_bar <if test="attachAlmostFull:|:$info['full_percent'] > 80">limit</if>' title='{$this->lang->words['ucp_attach_allowance']} {$info['full_percent']}% {$this->lang->words['ucp_full']}'>
				<span style='width: {$info['full_percent']}%'>{$info['full_percent']}%</span>
			</p>
			<p class='desc'>{$info['attach_space_count']}</p>
		</div>
	</if>
	<if test="hasPagesTop:|:$pages">
		<div class='topic_controls'>
			{$pages}
		</div>
		<br class='clear' />
	</if>
	<!-- ATTACHMENTS TABLE -->
	<form action="{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=updateAttachments&amp;do=saveIt" base="public"}" id="checkBoxForm" method="post">
	<div class='content_border'><table class='ipb_table' summary="{$this->lang->words['ucp_user_attach']}">
		<tr class='header'>
				<th scope='col' style='width: 2%'>&nbsp;</th>
				<th scope='col' style='width: 35%'>{$this->lang->words['attach_title']}</th>
				<th scope='col' style='width: 7%'>{$this->lang->words['attach_hsize']}</th>
				<th scope='col' style='width: 27%'>{$this->lang->words['attach_topic']}</th>
				<th scope='col' class='short' style='width: 3%'><input class='input_check' id="checkAllAttachments" type="checkbox" value="{$this->lang->words['check_all']}" /></th>
			</tr>
			<if test="hasAttachments:|:count($attachments)">
				{parse striping="attach" classes="row1,row2"}
				<foreach loop="attach:$attachments as $idx => $data">
					<tr id="a{$data['attach_id']}" class='{parse striping="attach"}'>
							<td class='short altrow'>
								<if test="attachmentThumbLocation:|:$data['attach_thumb_location']">
									<a href="{parse url="app=core&amp;module=attach&amp;section=attach&amp;attach_rel_module={$data['_type']}&amp;attach_id={$data['attach_id']}" base="public"}" title="{$data['attach_file']}"><img src="{$this->settings['upload_url']}/{$data['attach_thumb_location']}" width="30" height="30" alt='{$this->lang->words['attached_file']}' /></a>
								<else />
									<img src="{$this->settings['mime_img']}/{$data['image']}" alt="{$this->lang->words['attached_file']}" />
								</if>
							</td>
							<td>
								<a href="{parse url="app=core&amp;module=attach&amp;section=attach&amp;attach_rel_module={$data['_type']}&amp;attach_id={$data['attach_id']}" base="public"}" title="{$data['attach_file']}">{$data['short_name']}</a><br />
								<span class="desc">( {$this->lang->words['attach_hits']}: {$data['attach_hits']} )</span>
							</td>
							<td class='short altrow'>{$data['real_size']}</td>
							<td>
								<if test="attachmentPost:|:$data['attach_rel_id'] > 0 AND $data['attach_rel_module'] == 'post' && $data['_link']">
									<a href="{parse url="showtopic={$data['tid']}&amp;view=findpost&amp;p={$data['attach_rel_id']}" base="public"}" title='{$this->lang->words['ucp_view_org']}'>{$data['title']}</a>
								<else />
									{$data['title']}
								</if>
								<br />
								<span class="desc">{$data['attach_date']}</span>
							</td>
							<td class='altrow short'><input type="checkbox" name="attach[{$data['attach_id']}]" value="1" class="input_check checkall" /></td>
						</tr>
				</foreach>
			<else />
				<tr>
					<td colspan="5" class='no_messages'>{$this->lang->words['splash_noattach']}</td>
				</tr>
			</if>
		</table></div>
		<if test="attachmentMultiDelete:|:count($attachments)">
			<div class='moderation_bar rounded with_action clear' id='topic_mod'>
				<input type="hidden" name="authKey" value="{$this->member->form_hash}" />
				<input type="submit" value="{$this->lang->words['attach_delete']}" class="input_submit alt" />
			</div>
		</if>
	</form>
</div>
<if test="hasPagesBottom:|:$pages">
	<div class='topic_controls'>
		{$pages}
	</div>
	<br class='clear' />
</if>
<script type='text/javascript'>
	ipb.global.registerCheckAll( 'checkAllAttachments', 'checkall' );
</script>]]></template_content>
      <template_name>coreAttachments</template_name>
      <template_data><![CDATA[$info="",$pages="",$attachments]]></template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_ucp</template_group>
      <template_content><![CDATA[<script type='text/javascript'>
//<!#^#|CDATA|
	ipb.templates['autocomplete_wrap'] = new Template("<ul id='#{id}' class='ipbmenu_content' style='width: 250px;'></ul>");
	ipb.templates['autocomplete_item'] = new Template("<li id='#{id}'><img src='#{img}' alt='' width='#{img_w}' height='#{img_h}' />&nbsp;&nbsp;#{itemvalue}</li>");
//|#^#]>
</script>
<!--<h2 class='ipsType_subtitle'>{$this->lang->words['ucp_global_prefs']}</h2>-->
<div class='ipsPad'>
	<input type='checkbox' name='donot_view_sigs' id='donot_view_sigs' value='1' <if test="canSee:|: ! $this->memberData['view_sigs']">checked='checked'</if> />
	<label class='desc' for='donot_view_sigs'>{$this->lang->words['ucp_global_prefs_desc']}</label>
</div>
<br />
<h2 class='ipsType_subtitle'>{$this->lang->words['mi5_title']}</h2>
<br />
<if test="topPagination:|:$pagination">
	{$pagination}
	<br class='clear' />
	<br />
</if>
<div class='content_border'><table class='ipb_table' summary="{$this->lang->words['ucp_ignored_users']}">
	<tr class='header'>
		<th scope='col' width="30%">{$this->lang->words['mi5_name']}</th>
		<th scope='col' width="30%">{$this->lang->words['mi5_group']}</th>
		<th scope='col' class='short'>{$this->lang->words['ucp_ignore_posts']}</th>
		<th scope='col' class='short'>{$this->lang->words['ucp_ignore_sigs']}</th>
		<th scope='col' class='short'>{$this->lang->words['ucp_ignore_msgs']}</th>
		<if test="hasChat:|:IPSLib::appIsInstalled('ipchat')"><th scope='col' class='short'>{$this->lang->words['ucp_ignore_chats']}</th></if>
		<th scope='col' class='short'>&nbsp;</th>
	</tr>
	{parse striping="members" classes="row1,row2"}
	<if test="count( $members )">
		<foreach loop="members:$members as $member">
			<tr class='{parse striping="members"}'>
				<td>
					<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$member['Char']}.png' class='ipsUserPhoto ipsUserPhoto_mini left' style='margin-right: 5px' />
					<strong>{parse template="userHoverCard" group="global" params="$member"}</strong><br />
					<span class='desc lighter'>{$this->lang->words['m_joined']} {parse date="$member['joined']" format="joined"}</span>
				</td>
				<td>{$member['g_title']}</td>
				<td class='short'>
					<if test="ignoreMemberTopics:|:$member['ignoreData']['ignore_topics'] == 1">
						<a class='ipsButton_secondary' href="{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=toggleIgnoredUser&amp;do=saveIt&amp;id={$member['member_id']}&amp;field=topics&amp;st={$this->request['st']}" base="public"}" title="{$this->lang->words['click_toggle']}"><span style='color:red'>{$this->lang->words['ucp_hide_disallow']}</span></a>
					<else />
						<a class='ipsButton_secondary' href="{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=toggleIgnoredUser&amp;do=saveIt&amp;id={$member['member_id']}&amp;field=topics&amp;st={$this->request['st']}" base="public"}" title="{$this->lang->words['click_toggle']}"><span style='color:green'>{$this->lang->words['ucp_hide_allow']}</span></a>
					</if>
				</td>
				<td class='short'>
					<if test="ignoreGlobal:|:! $this->memberData['view_sigs']">
						<span class='desc'>{$this->lang->words['ucp_ignore_sigs_glb']}</span>
					<else />
						<if test="ignoreMemberSigs:|:$member['ignoreData']['ignore_signatures'] == 1">
							<a class='ipsButton_secondary' href="{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=toggleIgnoredUser&amp;do=saveIt&amp;id={$member['member_id']}&amp;field=signatures&amp;st={$this->request['st']}" base="public"}" title="{$this->lang->words['click_toggle']}"><span style='color:red'>{$this->lang->words['ucp_hide_disallow']}</span></a>
						<else />
							<a class='ipsButton_secondary' href="{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=toggleIgnoredUser&amp;do=saveIt&amp;id={$member['member_id']}&amp;field=signatures&amp;st={$this->request['st']}" base="public"}" title="{$this->lang->words['click_toggle']}"><span style='color:green'>{$this->lang->words['ucp_hide_allow']}</span></a>
						</if>
					</if>
				</td>
				<td class='short'>
					<if test="ignoreMemberPms:|:$member['ignoreData']['ignore_messages'] == 1">
						<a class='ipsButton_secondary' href="{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=toggleIgnoredUser&amp;do=saveIt&amp;id={$member['member_id']}&amp;field=messages&amp;st={$this->request['st']}" base="public"}" title="{$this->lang->words['click_toggle']}"><span style='color:red'>{$this->lang->words['ucp_hide_disallow_msg']}</span></a>
					<else />
						<a class='ipsButton_secondary' href="{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=toggleIgnoredUser&amp;do=saveIt&amp;id={$member['member_id']}&amp;field=messages&amp;st={$this->request['st']}" base="public"}" title="{$this->lang->words['click_toggle']}"><span style='color:green'>{$this->lang->words['ucp_hide_allow_msg']}</span></a>
					</if>
				</td>
				<if test="hasChatRow:|:IPSLib::appIsInstalled('ipchat')">
					<td class='short'>
						<if test="ignoreUserchats:|:$member['ignoreData']['ignore_chats'] == 1">
							<a class='ipsButton_secondary' href="{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=toggleIgnoredUser&amp;do=saveIt&amp;id={$member['member_id']}&amp;field=chats&amp;st={$this->request['st']}" base="public"}" title="{$this->lang->words['click_toggle']}"><span style='color:red'>{$this->lang->words['ucp_hide_disallow_msg']}</span></a>
						<else />
							<a class='ipsButton_secondary' href="{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=toggleIgnoredUser&amp;do=saveIt&amp;id={$member['member_id']}&amp;field=chats&amp;st={$this->request['st']}" base="public"}" title="{$this->lang->words['click_toggle']}"><span style='color:green'>{$this->lang->words['ucp_hide_allow_msg']}</span></a>
						</if>
					</td>
				</if>
				<td class='short'><a href="{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=removeIgnoredUser&amp;do=saveIt&amp;id={$member['member_id']}" base="public"}" class='ipsButton_secondary' class='delete_ignored'>{$this->lang->words['mi5_remove']}</a></td>
			</tr>
		</foreach>
	<else />
		<tr>
			<td colspan='<if test="hasChatNone:|:IPSLib::appIsInstalled('ipchat')">7<else />6</if>' class='no_messages desc'>{$this->lang->words['no_ignored_users']}</td>
		</tr>
	</if>
</table></div>
<if test="bottomPagination:|:$pagination">
	<br />
	{$pagination}
	<br class='clear' />
</if>
<br />
<div class='row2 ipsPad'>
	<h3 class='ipsType_subtitle' style='margin-bottom: 15px'>{$this->lang->words['mi5_addem']}</h3>
	<input type="text" class='input_text' size='40' name="newbox_1" id="newbox_1" value="{$this->request['newbox_1']}" />
	 &nbsp;&nbsp;<strong>{$this->lang->words['ucp_add_prefix']}</strong>&nbsp;
	<input type='checkbox' class='input_check' name='ignore_topics' id='ignore_topics' value='1' />
	<label class='desc' for='ignore_topics'>{$this->lang->words['ucp_ignore_posts']}</label>
	&nbsp;&nbsp;
	<input type='checkbox' class='input_check' name='ignore_signatures' id='ignore_signatures' value='1' />
	<label class='desc' for='ignore_signatures'>{$this->lang->words['ucp_ignore_sigs']}</label>
	&nbsp;&nbsp;
	<input type='checkbox' class='input_check' name='ignore_messages' id='ignore_messages' value='1' />
	<label class='desc' for='ignore_messages'>{$this->lang->words['ucp_ignore_pc']}</label>
	<if test="hasChatRowCheckbox:|:IPSLib::appIsInstalled('ipchat')">
		&nbsp;&nbsp;
		<input type='checkbox' class='input_check' name='ignore_chats' id='ignore_chats' value='1' />
		<label class='desc' for='ignore_chats'>{$this->lang->words['ucp_ignore_chats']}</label>
	</if>
</div>
<script type="text/javascript">
	$('newbox_1').defaultize( "{$this->lang->words['ucp_members_name']}" );
	
	ipb.delegate.register('.delete_ignored', confirmIgnoredDelete);
	
	var confirmIgnoredDelete = function(e, elem){
		if( !confirm("{$this->lang->words['ignore_del_areusure']}") ){
			Event.stop(e);
		}
	};
	
	document.observe("dom:loaded", function(){
		var url = ipb.vars['base_url'] + 'app=core&module=ajax&section=findnames&do=get-member-names&secure_key=' + ipb.vars['secure_hash'] + '&name=';
		new ipb.Autocomplete( $('newbox_1'), { multibox: false, url: url, templates: { wrap: ipb.templates['autocomplete_wrap'], item: ipb.templates['autocomplete_item'] } } );
	});
</script>]]></template_content>
      <template_name>membersIgnoredUsersForm</template_name>
      <template_data>$members</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_ucp</template_group>
      <template_content><![CDATA[<h3 class='ipsType_subtitle'>{$this->lang->words['board_prefs']}</h3>
<fieldset class='row1'>
	<h3>{$this->lang->words['privacy_settings']}</h3>
	<ul>
		<li class='field checkbox'>
			<input type='checkbox' class='input_check' id='admin_updates' name='admin_send' value='1'<if test="allowAdminMails:|:$this->memberData['allow_admin_mails']"> checked="checked"</if>/> <label for='admin_updates'>{$this->lang->words['admin_send']}</label><br />
			<span class='desc lighter'>{$this->lang->words['admin_send_desc']} {$time}</span>
		</li>
	</ul>
</fieldset>
<fieldset class='row1'>
	<div class='message unspecific' style='margin-top: 5px;'>{$this->lang->words['notifications_info_acp']}</div>
	<php>
		$this->notifyGroups = array(
			'topics_posts' => array( 'followed_topics', 'followed_forums', 'followed_topics_digest', 'followed_forums_digest', 'post_quoted', 'new_likes' ),
			'status_updates' => array( 'reply_your_status', 'reply_any_status', 'friend_status_update' ),
			'profiles_friends' => array( 'profile_comment', 'profile_comment_pending', 'friend_request', 'friend_request_pending', 'friend_request_approve' ),
			'private_msgs' => array( 'new_private_message', 'reply_private_message', 'invite_private_message' )
		);
		
		$this->_config = $config;
		
		$this->_colCount = IPSMember::canReceiveMobileNotifications() ? 4 : 3;
		
		$this->_lastApp	= '';
	</php>
	<table class='ipb_table notification_table'>
		<tr>
			<th>&nbsp;</th>
			<th style='width: 15%' class='short'><span class='notify_icon inline'>&nbsp;</span> {$this->lang->words['notify_type_inline']}</th>
			<th style='width: 15%' class='short'><span class='notify_icon email'>&nbsp;</span> {$this->lang->words['notify_type_email']}</th>
			<if test="IPSMember::canReceiveMobileNotifications()">
			<th style='width: 15%' class='short'><span class='notify_icon mobile'>&nbsp;</span> {$this->lang->words['notify_type_mobile']}</th>
			</if>
		</tr>
		<foreach loop="notifyGroupsList:$this->notifyGroups as $groupKey => $group">
			<tr class='row2'>
				<td colspan='{$this->_colCount}'>
					<h3>{$this->lang->words[ 'notifytitle_' . $groupKey ]}</h3>
					<if test="isPrivateMsg:|:$groupKey == 'private_msgs'">
						<p class='ipsPad_half checkbox ipsType_smaller desc '>
							<input type='checkbox' class='input_check' id='show_notification_popup' name='show_notification_popup' value='1' <if test="$this->memberData['_cache']['show_notification_popup']">checked='checked'</if> /> <label for='show_notification_popup' />{$this->lang->words['show_notification_popup']}</label><br />
						</p>
					</if>
					<if test="isTopicsOrPosts:|:$groupKey == 'topics_posts'">
						<p class='ipsPad_half checkbox ipsType_smaller desc '>
							<input class='input_check' type="checkbox" id='auto_track' name="auto_track" value="1" {$emailData['auto_track']} /> <label for='auto_track' />{$this->lang->words['auto_track']}</label>
							<select name="trackchoice" id='track_choice' class='input_select'>
								<option value="none" {$emailData['trackOption']['none']}>{$this->lang->words['like_notify_freq_none']}</option>
								<option value="immediate" {$emailData['trackOption']['immediate']}>{$this->lang->words['like_notify_freq_immediate']}</option>
								<option value="offline" {$emailData['trackOption']['offline']}>{$this->lang->words['like_notify_freq_offline']}</option>
								<option value="daily" {$emailData['trackOption']['daily']}>{$this->lang->words['like_notify_freq_daily']}</option>
								<option value="weekly" {$emailData['trackOption']['weekly']}>{$this->lang->words['like_notify_freq_weekly']}</option>
							</select>
							<if test="badConfig:|:$emailData['auto_track'] AND $emailData['trackOption']['none']">
								<br />{$this->lang->words['auto_but_no_email']}
							</if>
						</p>
					</if>
				</td>
			</tr>
			<foreach loop="groupKeys:$group as $key">
				<if test="keyExists:|:$this->_config[ $key ]">
					<tr>
						<td class='notify_title desc'>{$this->lang->words['notify__' . $key]}</td>
						<td class='short'>
							<span class='notify_icon inline' title='{$this->lang->words['notify_type_inline']}'>&nbsp;</span>
							<if test="$groupKey == 'private_msgs'">
								<input type='checkbox' class='input_check' name='' checked='checked' disabled='disabled' /> <span class='ipsBadge ipsBadge_lightgrey ipsType_smaller' data-tooltip='{$this->lang->words['nots_pm_whatthef']}'>{$this->lang->words['nots_pm_list']}</span>
							<else />
								<if test="isset( $this->_config[$key]['options']['inline'] ) && $groupKey != 'private_msgs'">
                                    <input type='checkbox' class='input_check' id='inline_{$key}' name="config_{$key}[]" value="inline"<if test="hasconfignotify:|:is_array($this->_config[$key]['defaults']) AND in_array('inline',$this->_config[$key]['defaults'])"> checked="checked"</if> <if test="hasconfigdisable:|:$this->_config[$key]['disabled']"> disabled="disabled"</if> />
                                <else />
                                    <input type='checkbox' class='input_check' name='' disabled='disabled' /></if>
							</if>
						</td>
						<td class='short'>
							<span class='notify_icon email' title='{$this->lang->words['notify_type_email']}'>&nbsp;</span>
							<if test="isset( $this->_config[$key]['options']['email'] )">
								<input type='checkbox' class='input_check' id='email_{$key}' name="config_{$key}[]" value="email"<if test="hasconfignotify:|:is_array($this->_config[$key]['defaults']) AND in_array('email',$this->_config[$key]['defaults'])"> checked="checked"</if> <if test="hasconfigdisable:|:$this->_config[$key]['disabled']"> disabled="disabled"</if> />
							<else />
								<input type='checkbox' class='input_check' name='' disabled='disabled' />
							</if>
						</td>
						<if test="IPSMember::canReceiveMobileNotifications()">
						<td class='short'>
							<span class='notify_icon mobile' title='{$this->lang->words['notify_type_mobile']}'>&nbsp;</span>
							<if test="isset( $this->_config[$key]['options']['mobile'] )">
								<input type='checkbox' class='input_check' id='mobile_{$key}' name="config_{$key}[]" value="mobile"<if test="hasconfignotify:|:is_array($this->_config[$key]['defaults']) AND in_array('mobile',$this->_config[$key]['defaults'])"> checked="checked"</if> <if test="hasconfigdisable:|:$this->_config[$key]['disabled']"> disabled="disabled"</if> />
							<else />
								<input type='checkbox' class='input_check' name='' disabled='disabled' />
							</if>
						</td>
						</if>
					</tr>
					<if test="$this->_config[$key]['_done'] = 1"></if>
				</if>
			</foreach>							
		</foreach>
		<foreach loop="notifyOther:$this->_config as $key => $_config">
			<if test="keyNotDone:|:!isset( $_config['_done'] ) && $_config['_done'] != 1">
				<if test="newNotApp:|:$this->_lastApp != $_config['app']">
					<tr class='row2'>
						<td colspan='{$this->_colCount}'>
							<h3><if test="isCoreNot:|:$_config['app'] == 'core'">{$this->lang->words['notifytitle_other']}<else />{IPSLib::getAppTitle( $_config['app'] )}</if></h3>
						</td>
					</tr>
					<if test="updateLastApp:|:$this->_lastApp = $_config['app']"></if>
				</if>
				<tr>
					<td class='notify_title desc'>{$this->lang->words['notify__' . $_config['key'] ]}</h3></td>
					<td class='short'>
						<span class='notify_icon inline' title='{$this->lang->words['notify_type_inline']}'>&nbsp;</span>
						<if test="isset( $_config['options']['inline'] )">
							<input type='checkbox' class='input_check' id='inline_{$key}' name="config_{$key}[]" value="inline"<if test="hasconfignotify:|:is_array($_config['defaults']) AND in_array('inline',$_config['defaults'])"> checked="checked"</if> <if test="hasconfigdisable:|:$_config['disabled']"> disabled="disabled"</if> />
						<else />
							<input type='checkbox' class='input_check' name='' disabled='disabled' />
						</if>
					</td>
					<td class='short'>
						<span class='notify_icon email' title='{$this->lang->words['notify_type_email']}'>&nbsp;</span>
						<if test="isset( $_config['options']['email'] )">
							<input type='checkbox' class='input_check' id='email_{$key}' name="config_{$key}[]" value="email"<if test="hasconfignotify:|:is_array($_config['defaults']) AND in_array('email',$_config['defaults'])"> checked="checked"</if> <if test="hasconfigdisable:|:$_config['disabled']"> disabled="disabled"</if> />
						<else />
							<input type='checkbox' class='input_check' name='' disabled='disabled' />
						</if>
					</td>
					<if test="IPSMember::canReceiveMobileNotifications()">
					<td class='short'>
						<span class='notify_icon mobile' title='{$this->lang->words['notify_type_mobile']}'>&nbsp;</span>
						<if test="isset( $_config['options']['mobile'] )">
							<input type='checkbox' class='input_check' id='mobile_{$key}' name="config_{$key}[]" value="mobile"<if test="hasconfignotify:|:is_array($this->_config[$key]['defaults']) AND in_array('mobile',$this->_config[$key]['defaults'])"> checked="checked"</if> <if test="hasconfigdisable:|:$this->_config[$key]['disabled']"> disabled="disabled"</if> />
						<else />
							<input type='checkbox' class='input_check' name='' disabled='disabled' />
						</if>
					</td>
					</if>
				</tr>
			</if>
		</foreach>
	</table>
</fieldset>]]></template_content>
      <template_name>notificationsForm</template_name>
      <template_data>$config, $emailData</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_ucp</template_group>
      <template_content><![CDATA[{parse js_module="ucp"}
<php>
$hasMoreTabs = (is_array($tabs[ $current_tab ]['_menu']) && count($tabs[ $current_tab ]['_menu']) > 1) ? true : false;
</php>
<if test="usercp_form:|:$hide_form == 0">
	<if test="has_max_upload:|:$maxUpload">
		<form method='post' enctype="multipart/form-data" action='{parse url="app=core&amp;module=usercp&amp;tab={$current_tab}&amp;area={$current_area}" base="public"}' id='userCPForm'>
	<else />
		<form method='post' action='{parse url="app=core&amp;module=usercp&amp;tab={$current_tab}&amp;area={$current_area}" base="public"}' id='userCPForm'>
	</if>
</if>
	<fieldset>
		<input type="hidden" name="MAX_FILE_SIZE" value="{$maxUpload}" />
		<input type='hidden' name='do' value='save' />
		<input type='hidden' name='secure_hash' value='{$this->member->form_hash}' />
		<input type='hidden' name='s' value='{$this->request['s']}' />
	</fieldset>
<h1 class='ipsType_pagetitle'>{$this->lang->words['ucp_title']}</h1>
<br />
<if test="count($tabs) > 1">
	{parse replacement="header_start"}<div class='maintitle ipsFilterbar clearfix'>
		<ul class='ipsList_inline'>
			<foreach loop="tabs:$tabs as $tab_app => $tab">
				<if test="active_tab:|:$tab_app == $current_tab">
					<li class='active'><a href="{parse url="module=usercp&amp;tab={$tab_app}" base="publicWithApp"}" title="<if test="isSettings:|:$tab_app=='core'">{$this->lang->words['settings_for_coretab']}<else />{parse expression="sprintf( $this->lang->words['settings_for_ucp'], $tab['_name'] )"}</if>">{$tab['_name']}</a></li>
				<else />
					<li><a href="{parse url="module=usercp&amp;tab={$tab_app}" base="publicWithApp"}" title="<if test="isSettingsInactive:|:$tab_app=='core'">{$this->lang->words['settings_for_coretab']}<else />{parse expression="sprintf( $this->lang->words['settings_for_ucp'], $tab['_name'] )"}</if>">{$tab['_name']}</a></li>
				</if>
			</foreach>
		</ul>
	</div>{parse replacement="header_end"}
</if>
<div class='ipsBox'>
	<div class='ipsLayout<if test="hasMoreThanOneTabClass:|:$hasMoreTabs"> ipsLayout_withleft ipsLayout_smallleft ipsVerticalTabbed</if> clearfix usercp_body'>
		<if test="hasMoreThanOneTabSidebar:|:$hasMoreTabs">
			<div class='ipsVerticalTabbed_tabs ipsLayout_left' id='usercp_tabs'>
				<ul>
					<foreach loop="items:$tabs[ $current_tab ]['_menu'] as $idx => $item">
						<if test="tabsMenus_active:|:$item['area'] == $current_area OR $item['active']">
							<li class='active'><a href="{parse url="module=usercp&amp;tab={$current_tab}&amp;{$item['url']}" base="publicWithApp"}">{$item['title']}</a></li>
						<else />
							<li><a href="{parse url="module=usercp&amp;tab={$current_tab}&amp;{$item['url']}" base="publicWithApp"}">{$item['title']}</a></li>
						</if>
					</foreach>
				</ul>
			</div>
		</if>
		<div class='<if test="hasMoreThanOneTabClassContent:|:$hasMoreTabs">ipsVerticalTabbed_content </if>ipsLayout_content ipsBox_container' id='usercp_content'>
			<div class='ipsPad'>
				<if test="has_errors:|:is_array( $errors ) AND count( $errors )">
					<p class='message error'>
						<foreach loop="errors:$errors as $error">
							{$error}<br />
						</foreach>
					</p>
					<br />
				</if>
				<if test="didSave:|:$this->request['saved'] == 1">
					<p class='message'>{$this->lang->words['ucp__settings_saved']}</p>
					<br />
				</if>
				{$html}
		
				<if test="submit_button:|:$hide_form == 0">
				<fieldset class='submit'>
					<input type='submit' class='input_submit' name='submitForm' value='{$this->lang->words['ucp__save_changes']}' /> {$this->lang->words['or']} <a href='{parse url="app=core&amp;module=usercp&amp;tab={$current_tab}&amp;area={$current_area}" base="public"}' title='{$this->lang->words['cancel_edit']}' class='cancel'>{$this->lang->words['cancel']}</a>
				</fieldset>
				</if>
			</div>
		</div>
	</div>
</div>
<if test="count($tabs) > 1">{parse replacement="box_end"}</if>
<if test="end_form:|:$hide_form == 0">
</form>
</if>]]></template_content>
      <template_name>userCPTemplate</template_name>
      <template_data>$current_tab, $html, $tabs, $current_area, $errors=array(), $hide_form=0, $maxUpload=0</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_ucp</template_group>
      <template_content><![CDATA[<input type='hidden' name='updateAboutMe' id='updateAboutMe' value='0' />
<h2 class='ipsType_subtitle ipsSettings_pagetitle'>{$this->lang->words['general_account_settings']}</h2>
<div class='ipsSettings'>
	<fieldset class='ipsSettings_section'>
		<h3 class='ipsSettings_sectiontitle'>{$this->lang->words['settings_time']}</h3>
		<div>
			<ul class='ipsForm ipsForm_horizontal'>
				<li class='ipsField'>
					<label for='timezone'>{$this->lang->words['ucp_timzeone']}</label>
					<select name='timeZone' id='timezone' class='input_select'>
					<foreach loop="timezones:$times as $off => $words">
						<option value='{$off}' <if test="isOurTimezone:|:$off == $this->memberData['time_offset']"> selected="selected"</if>>{$words}</option>
					</foreach>
					</select><br />
					<span class='desc lighter'>{$this->lang->words['settings_time_txt2']} {parse date="" format="LONG" relative="false"}</span>
				</li>
				<if test="$this->settings['time_dst_auto_correction']">
					<li>
						<if test="dstError:|:$this->request['dsterror'] == 1">
							{$this->lang->words['dst_error']}
						</if>
						<input type='checkbox' class='input_check' id='dst' name="dstCheck" onclick='toggle_dst()' value="1"<if test="doAutoDst:|:$this->memberData['members_auto_dst']"> checked="checked"</if>/> &nbsp;<label for='dst'>{$this->lang->words['dst_correction_title']}</label>
					</li>
					<li id='dst-manual'>
						<input type='checkbox' class='input_check' id='dstManual' name="dstOption" value="1"<if test="doManualDst:|:$this->memberData['dst_in_use']"> checked="checked"</if>/> &nbsp;<label for='dstManual'>{$this->lang->words['ucp_dst_now']}</label>
					</li>
				<else />
					<li>
						<input type='checkbox' class='input_check' id='dstManual' name="dstOption" value="1"<if test="doManualDst:|:$this->memberData['dst_in_use']"> checked="checked"</if>/> &nbsp;<label for='dstManual'>{$this->lang->words['ucp_dst_now']}</label><br />
						<span class='desc lighter'>{$this->lang->words['ucp_dst_effect']}</span>
					</li>
				</if>
			</ul>
		</div>
	</fieldset>

	<fieldset class='ipsSettings_section'>
		<h3 class='ipsSettings_sectiontitle'>{$this->lang->words['ucp_comments']}</h3>
		<div>
			<ul>
				<li>
					<input class='input_check' type='checkbox' value='1' name='pp_setting_count_comments' value='1' <if test="showComments:|:$this->memberData['pp_setting_count_comments'] > 0">checked='checked'</if> id='comments_enable' /> &nbsp;<label for='comments_enable'>{$this->lang->words['ucp_enable_comments']}</label>
				</li>
				<!-- proposing removal -->
				<li id='approve_comments'>
					<input class='input_check' type='checkbox' value='1'  name='pp_setting_moderate_comments' id='pp_setting_moderate_comments' <if test="yesModComments:|:$this->memberData['pp_setting_moderate_comments']">checked="checked"</if> /> &nbsp;<label for='pp_setting_moderate_comments'>{$this->lang->words['op_dd_enabled']}</label>
				</li>
				<li>
					<input class='input_check' type='checkbox' value='1' name='pp_setting_count_visitors' value='1' <if test="showLastVisitors:|:$this->memberData['pp_setting_count_visitors'] > 0">checked='checked'</if> id='pp_latest_visitors' /> &nbsp;<label for='pp_latest_visitors'>{$this->lang->words['ucp_show_x_latest']}</label>
				</li>
			</ul>
		</div>
	</fieldset>
	<if test="friendsEnabled:|:$this->settings['friends_enabled'] AND $this->memberData['g_can_add_friends']">
		<fieldset class='ipsSettings_section'>
			<h3 class='ipsSettings_sectiontitle'>{$this->lang->words['ucp_friends']}</h3>
			<div>
				<ul>
					<li>
						<input class='input_check' type='checkbox' value='1' name='pp_setting_count_friends' value='1' <if test="showFriends:|:$this->memberData['pp_setting_count_friends'] > 0">checked='checked'</if> id='friends_enable' /> &nbsp;<label for='friends_enable'>{$this->lang->words['ucp_show_friends_profile']}</label>
					</li>
					<li>
						<input class='input_check' type='checkbox' value='1' name='pp_setting_moderate_friends' id='pp_setting_moderate_friends' <if test="yesModFriends:|:$this->memberData['pp_setting_moderate_friends']">checked="checked"</if> /> &nbsp;<label for='pp_setting_moderate_friends'>{$this->lang->words['ucp_friend_approve']}</label>
					</li>
				</ul>
			</div>
		</fieldset>
	</if>
	<if test="showProfileInfo:|:($day && $mon && $year) || ($this->settings['post_titlechange'] && ($this->memberData['posts'] >= $this->settings['post_titlechange']))">
		<fieldset class='ipsSettings_section'>
			<h3 class='ipsSettings_sectiontitle'>{$this->lang->words['profile_information']}</h3>
			<div>
				<ul>
					<li><a href='#' class='ipsButton_secondary' id='edit_aboutme'>{$this->lang->words['edit_my_about_me']}</a></li>
				</ul>
				<if test="changeMemberTitle:|:$this->settings['post_titlechange'] == -1 or ( $this->settings['post_titlechange'] and $this->memberData['posts'] >= $this->settings['post_titlechange'] )">
					<br />
					<ul>
						<li>
							<label for='member_title' class='ipsSettings_fieldtitle'>{$this->lang->words['member_title']}</label>
							<input type='text' class='input_text' size='40' id='member_title' name='member_title' value='{$this->memberData['title']}' />
							<br />
							<span class='desc'>{$this->lang->words['member_title_desc']}</span>
						</li>
					</ul>
				</if>
				<if test="birthdayFields:|:$day AND $mon AND $year">
					<br />
					<ul>
						<li>
							<label for='birthday' class='ipsSettings_fieldtitle'>{$this->lang->words['ucp_birthday_select']}</label>
							<select name="month">&nbsp;
								<foreach loop="months:$mon as $m">
									<option value='{$m[0]}'<if test="monthSelected:|:$m[0] == $this->memberData['bday_month']"> selected="selected"</if>>{$m[1]}</option>
								</foreach>
							</select>			
							<select name="day">&nbsp;
								<foreach loop="days:$day as $d">
									<option value='{$d[0]}'<if test="daySelected:|:$d[0] == $this->memberData['bday_day']"> selected="selected"</if>>{$d[1]}</option>
								</foreach>
							</select> 
							<select name="year">&nbsp;
								<foreach loop="years:$year as $y">
									<option value='{$y[0]}'<if test="yearSelected:|:$y[0] == $this->memberData['bday_year']"> selected="selected"</if>>{$y[1]}</option>
								</foreach>
							</select> <br />
							<span class='desc'>{$this->lang->words['ucp_birthday_optional']}</span>
						</li>
					</ul>
				</if>
			</div>
		</fieldset>
	</if>
	
	<if test="count( $custom_fields )">
		<foreach loop="$custom_fields as $cgroup => $cfields">
			<if test="count( $cfields )">
				<fieldset class='ipsSettings_section'>
					<h3 class='ipsSettings_sectiontitle'>{$group_titles[ $cgroup ]}</h3>
					<div>
						<ul>
							<foreach loop="$cfields as $fid => $cfield">
								{$cfield['field']}
							</foreach>
						</ul>
					</div>
				</fieldset>
			</if>
		</foreach>
	</if>
	
	<div id='aboutme_editor' style='display: none'>
		<h3>{$this->lang->words['cp_edit_aboutme']}</h3>
		<div>
			{$amEditor}
		</div>
		<div class='ipsForm_submit' style='margin-top: 0;'>
			<a href='#' id='close_aboutme_editor' class='ipsButton'>{$this->lang->words['finish_aboutme_edit']}</a>
		</div>
	</div>
	<if test="requiredCfields:|:$required_output">
		<fieldset class='{parse striping="usercp"}'>
			<h3>{$this->lang->words['ucp_required_info']}</h3>
			<ul>
				{$required_output}
			</ul>
		</fieldset>
	</if>
	<if test="optionalCfields:|:$optional_output">
		<fieldset class='{parse striping="usercp"}'>
			<h3>{$this->lang->words['ucp_other_info']}</h3>
			<ul>
				{$optional_output}
			</ul>
		</fieldset>
	</if>
</div>
<script type="text/javascript">
//<!#^#|CDATA|
function toggle_dst()
{
	if ( $( 'dst' ) )
	{
		if ( $( 'dst' ).checked ){
			$( 'dst-manual' ).style.display = 'none';
		} else {
			$( 'dst-manual' ).style.display = 'block';
		}
	}
}
toggle_dst();
//|#^#]>
</script>]]></template_content>
      <template_name>membersProfileForm</template_name>
      <template_data><![CDATA[$custom_fields='',$group_titles='',$day='',$mon='',$year='', $amEditor='', $times=array()]]></template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_ucp</template_group>
      <template_content/>
      <template_name>displayNameForm</template_name>
      <template_data><![CDATA[$form=array(),$error="",$okmessage="", $isFB=false]]></template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_ucp</template_group>
      <template_content/>
      <template_name>emailPasswordChangeForm</template_name>
      <template_data>$txt, $_message, $isFB=false</template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_ucp</template_group>
      <template_content><![CDATA[<h3 class='ipsType_subtitle'>{$this->lang->words['cp_current_sig']}</h3>
<div class='row1 signature'>{$signature}</div>
<br />
<input type='hidden' name='removeattachid' value='0' />
{parse striping="usercp" classes="row1,row2"}
<fieldset class='{parse striping="usercp"}'>
	<h3 class='ipsType_subtitle'>{$this->lang->words['cp_edit_sig']}</h3>
	<if test="hasSignatureLimits:|:$this->memberData['g_signature_limits']">
		<div class='ipsType_pagedesc'>
			{$this->lang->words['sig_restrictions_contain']}<br />
			<ul class='ipsList_inline' style='display: inline'>
				<if test="$sig_restrictions[1] !== ''">
					<li>&bull; {parse expression="sprintf( $this->lang->words['sig_max_imagesr'], $sig_restrictions[1] )"}</li>
				<else />
					<li>&bull; {$this->lang->words['sig_max_imagesr_nl']}</li>
				</if>
				<if test="$sig_restrictions[2] !== '' || $sig_restrictions[3] !== ''">
					<li>&bull; {parse expression="sprintf( $this->lang->words['sig_max_imgsize'], $sig_restrictions[2], $sig_restrictions[3] )"}</li>
				<else />
					<li>&bull; {$this->lang->words['sig_max_imgsize_nl']}</li>
				</if>
				<if test="$sig_restrictions[4] !== ''">
					<li>&bull; {parse expression="sprintf( $this->lang->words['sig_max_urls'], $sig_restrictions[4] )"}</li>
				<else />
					<li>&bull; {$this->lang->words['sig_max_urls_nl']}</li>
				</if>
				<if test="$sig_restrictions[5] !== ''">
					<li>&bull; {parse expression="sprintf( $this->lang->words['sig_max_lines'], $sig_restrictions[5] )"}</li>
				<else />
					<li>&bull; {$this->lang->words['sig_max_lines_nl']}</li>
				</if>
			</ul>
		</div><br />
	</if>
	<div>
		{$editor_html}
		<if test="canUseHtml:|:$this->memberData['g_dohtml']">
		<p class='ipsPad_top_bottom'>
			<input type="checkbox" name="sig_htmlstatus" class="input_check" value="1" id='sig_htmlstatus' <if test="htmlModeOn:|:$this->memberData['bw_html_sig']">checked='checked'</if> />
			<label for='sig_htmlstatus' data-tooltip='{$this->lang->words['pp_html_tooltip']}'>{$this->lang->words['pp_html']}</label>
		</p>
		</if>
	</div>
</fieldset>
<if test="disablelightbox:|:!$this->settings['disable_lightbox']">
{parse template="include_lightbox" group="global" params=""}
</if>
{parse template="include_highlighter" group="global" params="1"}
<script type="text/javascript">
if ( $('sig_htmlstatus') )
{
	ipb.textEditor.bindHtmlCheckbox( $('sig_htmlstatus') );
}
</script>]]></template_content>
      <template_name>membersSignatureForm</template_name>
      <template_data><![CDATA[$editor_html="",$sig_restrictions=array(),$signature='']]></template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
    <template>
      <template_group>skin_ucp</template_group>
      <template_content><![CDATA[<if test="hasnotifyerror:|:$error">
<p class='message error'>
	{$error}
</p>
<else />
	<if test="hasconfirm:|:$this->request['confirm']">
	<p class='message'>
		{$this->lang->words['notify_rem_suc']}
	</p>
	</if>
</if>
<div id='notificationlog'>
	<form action="{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=removeNotifications&amp;do=remove" base="public"}" id="checkBoxForm" method="post">
	<input type="hidden" name="secure_key" value="{$this->member->form_hash}" />
	<if test="hasNotifications:|:is_array( $notifications ) AND count( $notifications )">
		<div class='right ipsPad'>
			<input id="checkAllNotifications" type="checkbox" value="{$this->lang->words['check_all']}" />
		</div>
		<h2 class='ipsType_subtitle'>{$this->lang->words['arch_notifications_head']}</h2>
		<br />
		<table class='ipb_table' summary="{$this->lang->words['notifications_table_head']}">
			<tr class='header hide'>
				<th scope='col' width="5%">&nbsp;</th>
				<th scope='col' width="70%">{$this->lang->words['th_notification']}</th>
				<th scope='col' width="25%">{$this->lang->words['th_sent']}</th>
				<th scope='col' align="center" width="5%" class='short'>&nbsp;</th>
			</tr>
			{parse striping="notify" classes="row2,row1"}
			<foreach loop="categories:$notifications as $notification">
				<tr class='{parse striping="notify"} <if test="hasReadNotify:|:!$notification['notify_read']">unread</if>'>
					<td class="col_n_icon altrow short"><if test="hasReadNotify:|:$notification['notify_read']">{parse replacement="t_read_dot"}<else />{parse replacement="t_unread_dot"}</if></td>
					<td class='col_n_photo short'>
						<if test="$notification['member']['member_id']">
							<a href='{parse url="showuser={$notification['member']['member_id']}" template="showuser" seotitle="{$notification['member']['members_seo_name']}" base="public"}' class='ipsUserPhotoLink'>
								<img src='http://mercury.raknet.ru/templates/style/img/avatars/{$notification['member']['Char']}.png' class='ipsUserPhoto ipsUserPhoto_mini' />
							</a>
						<else />
							{IPSMember::buildNoPhoto(0, 'mini' )}
						</if>
					</td>
					<td>
						<h4><if test="strpos( $notification['notify_title'], '<a href' ) === false"><a href='{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=viewNotification&amp;do=view&amp;view={$notification['notify_id']}" base="public"}'></if>
						{$notification['notify_title']}
						<if test="strpos( $notification['notify_title'], '<a href' ) === false"></a></if>
						</h4>
					</td>
					<td class="col_n_date desc"><a href='{parse url="app=core&amp;module=usercp&amp;tab=core&amp;area=viewNotification&amp;do=view&amp;view={$notification['notify_id']}" base="public"}' title='{$this->lang->words['view_notification_logentry']}'>{$this->lang->words['th_sent']} {parse date="$notification['notify_sent']" format="long"}</a></td>
					<td class="short col_n_mod"><input class='input_check checkall' type="checkbox" name="notifications[]" value="{$notification['notify_id']}" /></td>
				</tr>
			</foreach>
		</table>
		<script type='text/javascript'>
			ipb.global.registerCheckAll('checkAllNotifications', 'checkall');
		</script>
	<else />
		<p class='no_messages'>{$this->lang->words['notifications_none']}</p>
	</if>
	<if test="hasNotifyForMod:|:count($notifications)">
		<br />
		<a href='{parse url="app=core&amp;module=usercp&amp;area=markNotification&amp;do=mark&amp;mark=all" base="public"}' id='ack_pm_notification' class='input_submit left'>{$this->lang->words['notificationlog_mar']}</a>
		<div class='moderation_bar rounded with_action'>
			<input type="submit" class="input_submit alt" value="{$this->lang->words['ndel_selected']}" />
		</div>
		<br />
		<div class='topic_controls'>
			{$pages}
		</div>
	</if>
</form>
</div>]]></template_content>
      <template_name>notificationsLog</template_name>
      <template_data><![CDATA[$notifications, $error='', $pages='']]></template_data>
      <template_removable>1</template_removable>
      <template_user_added>0</template_user_added>
      <template_user_edited>1</template_user_edited>
      <template_master_key/>
    </template>
  </templategroup>
</templates>

--------------------------------------------------------------------------------
> Time: 1415628377 / Mon, 10 Nov 2014 14:06:17 +0000
> URL: /admin/index.php?adsess=c56f5ccb0e1ea9a55889b95d84a98c87&app=core&&module=templates&section=importexport&do=exportSet
> CSS Export: core
<?xml version="1.0" encoding="utf-8"?>
<css>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426452</css_updated>
    <css_group>ipb_ckeditor</css_group>
    <css_content><![CDATA[/***************************************************************/
/* IP.Board 3.2 Editor CSS                                       */
/* ___________________________________________________________ */
/* By Matt Mecham					                            */
/***************************************************************/
/* Styles for the editor (colors in main css) */
/***************************************************************/

.bbcode_hilight {
    background-color: yellow;
}

.as_content {
	font-size: 1.0em;
	padding: 6px;
	margin: 8px;
	overflow: auto;
	max-height: 400px;
}
.as_buttons {
	text-align: right;
	padding: 4px 0px;
}
.as_message {
	display: inline-block;
}

.ipsEditor_textarea {
	width: 99%;
	height: 200px;
	font-size: 14px;
}
.cke_browser_webkit {outline:none !important;}
	
/* Main tool bar BG */
.cke_top {
	background: #efefef url('{style_images_url}/editor/toolbar_bg.png') repeat-x !important;
}

/* Minimized RTE */
.cke_skin_ips .cke_wrapper.minimized { 
	opacity: 0.6 !important;
	background: none !important;
	border: none !important;
}

/* Minimized STD */
.cke_skin_ips .cke_wrapper.minimized.std { 
	border: 1px solid #dddddd !important;
}

.cke_skin_ips .cke_wrapper.minimized .cke_contents,
.cke_skin_ips .cke_wrapper.minimized .cke_contents iframe{ height: 80px !important; }

/* Main Editor wrapper */
.cke_skin_ips { margin-bottom: 0px !important; }

.cke_skin_ips .cke_wrapper
{
	padding: 0px 5px 0px 3px !important;
	margin: 2px !important;
	border: 1px solid #dddddd !important;
	background-color: #efefef !important;
	background-image: none !important;
}

/* OFF state for editor buttons */
.cke_skin_ips .cke_toolgroup
{
	background-color: transparent !important;
}

/* HOVER 'off' button */
.cke_skin_ips .cke_button a:hover,
.cke_skin_ips .cke_button a:focus,
.cke_skin_ips .cke_button a:active	/* IE */
{
	background-color: #dddddd !important;
}

/* HOVER 'on' button */
.cke_skin_ips .cke_button a.cke_on,
.cke_skin_ips .cke_button a:hover.cke_on,
.cke_skin_ips .cke_button a:focus.cke_on,
.cke_skin_ips .cke_button a:active.cke_on	/* IE */
{
	background-color: #dddddd !important;
	-webkit-box-shadow: inset rgba(0,0,0,0.12) 0px 1px 2px !important;
	-moz-box-shadow: inset rgba(0,0,0,0.12) 0px 1px 2px !important;
	box-shadow: inset rgba(0,0,0,0.12) 0px 1px 2px !important;
}

/* Button group */
.cke_skin_ips .cke_toolgroup
{
	margin-right: 0px !important;
}

/* Button separator */
.cke_skin_ips .cke_separator
{
	border-left:solid 1px #dddddd;
	display:inline-block !important;
	float:left;
	height:30px;
	margin:0px 2px;
}

/* DIALOG: Modal blind */
.cke_dialog_background_cover
{
	background-color: #3e3e3e !important;
}

/* DIALOG: Title - based on .maintitle */
.cke_skin_ips .cke_dialog_title
{
	background: #444 url('{style_images_url}/highlight_faint.png') repeat-x 0 1px !important;
	color: #fff !important;
	padding: 10px 10px 11px !important;
	font-size: 16px !important;
	font-weight: 300 !important;
	text-shadow: 0 -1px 0px rgba(0,0,0,0.4);
	font-weight: normal;
}

/* Dialog: Body */
.cke_skin_ips .cke_dialog_body {
	z-index: 20000 !important;
}

/* Dialog tab bg (will usually match dialog title) */
.cke_skin_ips .cke_dialog_tabs {
	background: #444 !important;
}

/* Dialog Title close button */
.cke_skin_ips .cke_dialog_close_button
{
	background: transparent url('{style_images_url}/close_popup.png') no-repeat top left !important;
	width: 13px !important;
	height: 13px !important;
	top: 11px !important;
	right: 10px !important;
}

/* Dialog OK / Cancel buttons - based on ipsButton_secondary*/
.cke_skin_ips span.cke_dialog_ui_button
{
	height: 22px !important;
	line-height: 22px !important;
	font-size: 12px !important;
	padding: 0 10px !important;
	-moz-border-radius: 2px !important;
	-webkit-border-radius: 2px !important;
	border-radius: 2px !important;
	display: inline-block !important;
	white-space: nowrap !important;
	
	background: #646464 url('{style_images_url}/highlight_faint.png') repeat-x 0 0 !important;
	border: 1px solid #585858 !important;
	color: #fff !important;
	text-shadow: #474747 0px -1px 0px !important;
	-moz-box-shadow: rgba(0,0,0,0.43) 0px 1px 3px !important;
	-webkit-box-shadow: rgba(0,0,0,0.43) 0px 1px 3px !important;
	box-shadow: rgba(0,0,0,0.43) 0px 1px 3px !important;
	cursor: pointer !important;
}

/* Turn off resizer */
.cke_skin_ips .cke_dialog_footer .cke_resizer { display: none; }

/* Emo slide out tray */
.ipsSmileyTray
{
	position: relative;
	text-align: center;
	overflow: auto;
	margin: 0px auto 0px auto;
	padding: 4px 24px 4px 24px;
	min-width: 600px;
	width: 75%;
	height: 32px;
	border: 1px solid #dddddd;
	-moz-border-radius: 2px;
	-webkit-border-radius: 2px;
	border-radius: 2px;
	
	-moz-border-radius-topleft: 0px;
	-webkit-border-radius-topleft: 0px;
	border-top-left-radius: 0px;
	
	-moz-border-radius-topright: 0px;
	-webkit-border-radius-topright: 0px;
	border-top-right-radius: 0px;
	
	border-top: 0px;
	-moz-box-shadow: 0px 1px 4px rgba(0,0,0,0.15);
	-webkit-box-shadow: 0px 1px 4px rgba(0,0,0,0.15);
	box-shadow: 0px 1px 4px rgba(0,0,0,0.15);
	
	background: #efefef url('{style_images_url}/highlight.png') repeat-x 0 0;
	overflow-y: hidden;
}
	.ipsSmileyTray img.bbc_emoticon {
		opacity: 0.8;
		cursor: pointer;
		margin: 6px 3px 0px 3px;
		max-width: 30px;
		max-height: 30px;
	 }
	 	.ipsSmileyTray img.bbc_emoticon:hover {
			opacity: 1.0;
	 	}
	
	.ipsSmileyTray .ipsSmileyTray_next {
		background: transparent url('{style_images_url}/editor/next.png') no-repeat;
		background-position: 0px 10px;
		display: inline-block;
		position: absolute;
		right: 5px;
		top: 4px;
		width: 13px;
		height: 30px;
		cursor: pointer;
	}
	
	.ipsSmileyTray .ipsSmileyTray_prev {
		background: transparent url('{style_images_url}/editor/prev.png') no-repeat;
		background-position: 0px 10px;
		display: inline-block;
		position: absolute;
		left: 5px;
		top: 4px;
		width: 13px;
		height: 30px;
		cursor: pointer;
	}
	
	.ipsSmileyTray_all {
		display: block;
		width: auto;
		margin: 6px auto 0px auto;
		text-align: center;
		cursor: pointer;
		font-size: 11px !important;
	}
	
	
/* ACP Specific */
table.cke_editor td { padding: 0px !important; }

/* Dialogs */
.cke_dialog.cke_single_page td.cke_dialog_contents {
    height: auto !important;
}

.cke_dialog .cke_dialog_ui_textarea { height: 130% !important }

/* Extra */

.cke_text,
.cke_openbutton,
.cke_panel{
	border-color: #a4a4a4 !important;
}

.cke_skin_ips input.cke_dialog_ui_input_text,.cke_skin_ips input.cke_dialog_ui_input_password{ background: transparent none !important; }
.cke_skin_ips .cke_dialog_contents{ border-top: 1px solid #333 !important; }]]></css_content>
    <css_position>1</css_position>
    <css_app>core</css_app>
    <css_app_hide>1</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules/>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426452</css_updated>
    <css_group>ipb_common</css_group>
    <css_content><![CDATA[/************************************************************************/
/* IP.Board 3 CSS - By Rikki Tissier - (c)2008 Invision Power Services 	*/
/************************************************************************/
/* ipb_common.css														*/
/************************************************************************/

	
/************************************************************************/
/* LIGHTBOX STYLES */

#lightbox{	position: absolute;	left: 0; width: 100%; z-index: 16000 !important; text-align: center; line-height: 0;}
#lightbox img{ width: auto; height: auto;}
#lightbox a img{ border: none; }
#outerImageContainer{ position: relative; background-color: #fff; width: 250px; height: 250px; margin: 0 auto; }
#imageContainer{ padding: 10px; }
#loading{ position: absolute; top: 40%; left: 0%; height: 25%; width: 100%; text-align: center; line-height: 0; }
#hoverNav{ position: absolute; top: 0; left: 0; height: 100%; width: 100%; z-index: 10; }
#imageContainer>#hoverNav{ left: 0;}
#hoverNav a{ outline: none;}
#prevLink, #nextLink{ width: 49%; height: 100%; background-image: url('{style_images_url}/spacer.gif'); /* Trick IE into showing hover */ display: block; }
#prevLink { left: 0; float: left;}
#nextLink { right: 0; float: right;}
#prevLink:hover, #prevLink:visited:hover { background: url('{style_images_url}/lightbox/prevlabel.gif') left 15% no-repeat; }
#nextLink:hover, #nextLink:visited:hover { background: url('{style_images_url}/lightbox/nextlabel.gif') right 15% no-repeat; }
#imageDataContainer{ font: 10px Verdana, Helvetica, sans-serif; background-color: #fff; margin: 0 auto; line-height: 1.4em; overflow: auto; width: 100%	; }
#imageData{	padding:0 10px; color: #666; }
#imageData #imageDetails{ width: 70%; float: left; text-align: left; }	
#imageData #caption{ font-weight: bold;	}
#imageData #numberDisplay{ display: block; clear: left; padding-bottom: 1.0em;	}			
#imageData #bottomNavClose{ width: 66px; float: right;  padding-bottom: 0.7em; outline: none;}
#overlay{ position: fixed; top: 0; left: 0; z-index: 15000 !important; width: 100%; height: 500px; background-color: #000; }

/************************************************************************/
/*  BBCODE STYLES */
/* 	NOTE: These selectors style bbcodes throughout IPB. It is recommended that you DO NOT change these 
	styles if you are creating a skin since it may interfere with user expectation
	of what certain BBCodes look like (quote boxes are an exception to this). */

strong.bbc				{	font-weight: bold !important; }
em.bbc 					{	font-style: italic !important; }
span.bbc_underline 		{ 	text-decoration: underline !important; }
acronym.bbc 			{ 	border-bottom: 1px dotted #000; }
span.bbc_center, div.bbc_center, p.bbc_center	{	text-align: center; display: block; }
span.bbc_left, div.bbc_left, p.bbc_left		{	text-align: left; display: block; }
span.bbc_right , div.bbc_right, p.bbc_right	{	text-align: right; display: block; }
div.bbc_indent 			{	margin-left: 50px; }
del.bbc 				{	text-decoration: line-through !important; }
.post.entry-content ul, ul.bbc, .as_content ul, .comment_content ul 					{	list-style: disc outside; margin: 12px 0 12px 40px; }
	.post.entry-content ul, ul.bbc ul.bbc, .as_content ul 			{	list-style-type: circle; }
		.post.entry-content ul, ul.bbc ul.bbc ul.bbc, .as_content ul 	{	list-style-type: square; }
ul.decimal,ul.bbcol.decimal, .post.entry-content ol, .post_body ol, .as_content ol 				{ margin: 12px 0 12px 40px !important; list-style-type: decimal !important; }
	.post.entry-content ul.lower-alpha, ul.bbcol.lower-alpha		{ margin-left: 40px; list-style-type: lower-alpha; }
	.post.entry-content ul.upper-alpha, ul.bbcol.upper-alpha		{ margin-left: 40px; list-style-type: upper-alpha; }
	.post.entry-content ul.lower-roman, ul.bbcol.lower-roman		{ margin-left: 40px; list-style-type: lower-roman; }
	.post.entry-content ul.upper-roman, ul.bbcol.upper-roman		{ margin-left: 40px; list-style-type: upper-roman; }
span.bbc 					{ 	display: block; border-top: 2px solid #777; width: 100%; height: 4px; }
div.bbc_spoiler 		{	 }
div.bbc_spoiler span.spoiler_title	{ 	font-weight: bold; }
div.bbc_spoiler_wrapper	{ 	 }
div.bbc_spoiler_content	{ 	background: #fcfcfc; border: 1px dashed #e3e3e3; padding: 5px; margin-top: 5px; }
input.bbc_spoiler_show	{ 	width: 45px; font-size: .8em; margin: 0px; margin-left: 5px; padding: 0px; }
img.bbc_img { cursor: pointer; }
.signature img.bbc_img { cursor: default; }
.signature a img.bbc_img { cursor: pointer; }

pre.prettyprint, code.prettyprint {
        background-color: #fcfcfc !important;
        color: #000000;
        padding: 8px;
        border: 1px solid #e3e3e3;
        overflow: auto;
        font-size: 11px;
        line-height: 170%;
        font-family: monospace !important;
}

cite.ipb { display: none }

pre.prettyprint {
        margin: 1em auto;
        padding: 1em;
        /* white-space: pre-wrap; */
}

/* LEGACY @todo remove in IPS4 */
div.blockquote {
    font-size: 12px;
    padding: 10px;
    border: 1px solid #e3e3e3;
    background: #fcfcfc;
    color: #9f9f9f;
}

div.blockquote div.blockquote {
    margin: 0 10px 0 0;
}

div.blockquote p.citation {
    margin: 6px 10px 0 0;
}

/* Quote boxes */

p.citation {
	font-size: 12px;
	padding: 8px 10px;
	border: 1px solid #e3e3e3;
	border-bottom: 0;
	background: #f2f2f2 url('{style_images_url}/highlight.png') repeat-x 0 0;
	color: #535353;
	text-shadow: rgba(255,255,255,1) 0px 1px 0px;
	font-weight: bold;
	margin-top: 5px;
	overflow-x: auto;
}

blockquote.ipsBlockquote {
	font-size: 12px;
	padding: 10px;
	border: 1px solid #e3e3e3;
	border-top: 1px solid #e8e8e8;
	background: #fcfcfc;
	color: #9f9f9f;
	margin-bottom: 5px;
	margin: 0;
	overflow-x: auto;
}

blockquote.ipsBlockquote blockquote.ipsBlockquote {
	margin: 0 10px 0 0;
}

blockquote.ipsBlockquote p.citation {
	margin: 6px 10px 0 0;
}

blockquote.ipsBlockquote.built {
    border-top: none;
    -moz-border-top-right-radius: 0px;
    -webkit-border-top-left-radius: 0px;
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
}

._sharedMediaBbcode {
	width: 520px;
	background: #f5f5f5;
	border: 1px solid #d3d3d3;
	-moz-box-shadow: inset rgba(0,0,0,0.15) 0px 1px 4px;
	-webkit-box-shadow: inset rgba(0,0,0,0.15) 0px 1px 4px;
	box-shadow: inset rgba(0,0,0,0.15) 0px 1px 4px;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	color: #616161;
	display: inline-block;
	margin-right: 15px;
	margin-bottom: 5px;
	padding: 10px;
	min-height: 75px;
}

._sharedMediaBbcode img.bbc_img{ float: left; }

.bbcode_mediaWrap .details {
	color: #616161;
	font-size: 12px;
	line-height: 1.5;
	margin-left: 95px;
}

.bbcode_mediaWrap .details a {
	color: #616161;
	text-decoration: none;
}

.bbcode_mediaWrap .details h5, .bbcode_mediaWrap .details h5 a {
	font: 400 20px/1.3 "Helvetica Neue", Helvetica, Arial, sans-serif;
	color: #2c2c2c;
	word-wrap: break-word;
	max-width: 420px;
}

.bbcode_mediaWrap img.sharedmedia_image {
	float: left;
	position: relative;
	max-width: 80px;
}

.bbcode_mediaWrap img.sharedmedia_screenshot {
	float: left;
	position: relative;
	max-width: 80px;
}

/* Show my media label */
.cke_button_ipsmedia span.cke_label {
	display: inline !important;
}]]></css_content>
    <css_position>1</css_position>
    <css_app>core</css_app>
    <css_app_hide>0</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules/>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426452</css_updated>
    <css_group>ipb_editor</css_group>
    <css_content><![CDATA[/***************************************************************/
/* IP.Board 3 Editor CSS                                       */
/* ___________________________________________________________ */
/* By Rikki Tissier                                            */
/* (c)2008 Invision Power Services                             */
/***************************************************************/
/* ipb_editor.css - Styles for the editor (colors in main css) */
/***************************************************************/


/*********************************************************/
/* 	THESE STYLES ARE FOR THE LEGACY RTE EDITOR.			 */
/* 	THIS EDITOR IS DEPRECATED; THESE STYLES ARE LOADED	 */
/* 	ONLY ON DEMAND FOR LEGACY PURPOSES.					 */
/*********************************************************/
#ipboard_body .input_rte {
	width: 100%;
	height: 250px;
}

	#ipboard_body .ips_editor.lite_edition .input_rte {
		height: 60px;
	}
	
	#ipboard_body .ips_editor .input_rte.unloaded_editor {
		font-family: arial, verdana, tahoma, sans-serif;
		font-style: italic;
		font-size: 11px;
		color: #b4b4b4;
		padding: 5px 0px;
		text-indent: 5px;
	}
	
#ipboard_body .ips_editor {
	border: 2px solid #dbdbdb;
	margin: 8px;
	margin-right: 0px;
	position: relative;
	line-height: 100% !important;
}

	#ipboard_body .ips_editor.with_sidebar .controls,
	#ipboard_body .ips_editor.with_sidebar .editor{
		margin-right: 200px;
	}
	
	#ipboard_body .ips_editor .controls {
		position: relative;
	}
	
	/* Sidebar go bye-bye-bye (like Keith) */
	#ipboard_body .ips_editor.with_sidebar .sidebar {
		position: absolute;
		top: 0px;
		right: 1px;
		width: 195px;
		bottom: 1px;
		margin: 0;
		border-width: 1px;
		border-style: solid;
		border-color: #fafafa #dbdbdb #dbdbdb #fafafa;
	}
		
		#ipboard_body .ips_editor.with_sidebar .sidebar h4 {
			background-color: #ebebeb;
			height: 25px;
			color: #1d3652;
			font-size: 10px;
			font-weight: bold;
		}
		
			#ipboard_body .ips_editor.with_sidebar .sidebar h4 span {
				padding: 6px 0 0 6px;
				display: block;
			}
			
			#ipboard_body .ips_editor.with_sidebar .sidebar h4 img {
				float: right;
				margin: 6px 6px 0 0;
				cursor: pointer;
			}
		
		#ipboard_body .ips_editor.with_sidebar .sidebar .emoticon_holder {
			width: 100%;
			height: 93%;
			overflow: auto;
			position: absolute;
			bottom: 25px;
			top: 25px;
		}
		
		#ipboard_body .ips_editor.with_sidebar .sidebar .emoticon_holder  td {
			padding: 5px 0;
		}
		
		#ipboard_body .show_all_emoticons {
			bottom: 0px;
			position: absolute;
			width: 100%;
			text-align: center;
			background: #ebebeb;
			height: 25px;
		}
		
			#ipboard_body .ips_editor.with_sidebar .sidebar .emoticon_holder.no_bar {
				bottom: 0px;
			}

	#ipboard_body .ips_editor .toolbar {
		height: 30px;
		background: #ebebeb url('{style_images_url}/gradient_bg.png') repeat-x left 50%;
		border-width: 1px;
		border-style: solid;
		border-color: #fafafa #dbdbdb #dbdbdb #fafafa;
	}
		
		#ipboard_body .ips_editor .toolbar li {
			float: left;
			padding: 3px;
		}
		
			#ipboard_body .ips_editor .toolbar li.sep {
				padding-right: 4px;
				border-right: 1px solid #dbdbdb;
				margin-right: 4px;
			}
			
			#ipboard_body .ips_editor .toolbar li.left {
				float: left;
			}
			
			#ipboard_body .ips_editor .toolbar li.right {
				float: right;
			}
		
		#ipboard_body .ips_editor .toolbar li span {
			display: block;
			padding: 3px;
		}
		
	#ipboard_body .ips_editor ul.ipbmenu_content,
	#ipboard_body .ips_editor ul.ipbmenu_content li {
		display: block;
		float: none;
		background-color: #fff;
	}
		
#ipboard_body .ips_editor .toolbar li .rte_control.rte_menu {
	font-size: 11px;
	height: 14px;
	border: 1px solid #b7b7b7;
	margin-top: 1px;
	padding: 4px 15px 2px 7px;
	background-color: #fff;
	background-image: url('{style_images_url}/rte_icons/rte_arrow.png');
	background-repeat: no-repeat;
	background-position: right center;
}

#ipboard_body .rte_title {
	background-color: #dbdbdb;
	padding: 4px;
	margin: -4px -4px 5px -4px;
	color: #1d3652;
	font-size: 10px;
	font-weight: bold;
}

#ipboard_body .rte_fontsize {
	min-width: 50px;
}

#ipboard_body .rte_font {
	min-width: 85px;
}

#ipboard_body .rte_special {
	min-width: 90px;
}

#ipboard_body .ipb_palette {
	padding: 4px;
	background-color: #f4f4f4;
	border-width: 1px 2px 2px 1px;
	border-style: solid;
	border-color: #dbdbdb;
	font-size: 11px;

}

	#ipboard_body .ipb_palette label {
		display: block;
		font-weight: bold;
		clear: both;
		width: auto !important;
		float: none !important;
		text-align: left !important;
	}
	
	#ipboard_body .ipb_palette input {
		clear: both;
		width: 96%;
		margin-bottom: 5px;
		font-size: 11px;
		margin-right: 6px;
	}
	
	#ipboard_body .ipb_palette input[type="submit"], 
	#ipboard_body .input_submit.emoticons {
		background-color: #dbdbdb;
		border: 1px solid #dbdbdb;
		margin: 5px auto 5px auto;
		text-align: center;
		padding: 2px;
		color: #1d3652;
		font-size: 11px;
		display: block;
		width: auto !important;
	}
	
	#ipboard_body .ipb_palette.extended {
		min-width: 250px;
		max-width: 320px;
	}
	
	#ipboard_body .ipb_palette pre {
		padding: 5px 7px 10px 7px;
	}

#ipboard_body ul.fontsizes li {
	padding: 0.3em 0px !important;
}

#ipboard_body .ipb_palette table.rte_colors {
	border-collapse: separate;
	background-color: #fff;
	border-spacing: 1px;
}

#ipboard_body table.rte_colors td {
	padding: 6px;
	border: 1px solid #777;
	margin: 1px;
	font-size: 1px;
	cursor: pointer;
	height: 18px;
}

#ipboard_body .rte_control {
	cursor: pointer;
	background: #e4e4e4;
	border: 1px solid #c5c5c5;
}		

#ipboard_body .rte_hover {
	background-color: #dbdbdb;
}

#ipboard_body .rte_selected {
	background-color: #d4d4d4;
	border: 1px solid #b8b8b8;
}]]></css_content>
    <css_position>1</css_position>
    <css_app>core</css_app>
    <css_app_hide>1</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules/>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426452</css_updated>
    <css_group>ipb_help</css_group>
    <css_content><![CDATA[/************************************************************************/
/* IP.Board 3 CSS - By Rikki Tissier - (c)2008 Invision Power Services 	*/
/************************************************************************/
/* ipb_help.css													*/
/************************************************************************/
/*
	[ color ]
	[ font ]
	[ borders ]
	[ padding ]
	[ margin ]
	[ sizing ]
	[ other ]
*/

/************************************************************************/
/*  HELP & PORTAL STYLES */
	
#help_topics { }

#help_topics li {
	background-image: url({style_images_url}/help.png);
	background-repeat: no-repeat;
	background-position: 9px 12px;
	padding: 10px 32px;
}

	#help_topics li h3 { padding: 2px 0 5px 0; }

.help_doc { border: 1px solid #c9c9c9; }
	#help_topics .help_doc ul,
	#help_topics .help_doc ol {
		padding: 8px 0;
	}

	#help_topics .help_doc li {
		background: none;
		padding: 2px;
	}
	.help_doc .input_submit { padding: 1px 4px; }]]></css_content>
    <css_position>0</css_position>
    <css_app>core</css_app>
    <css_app_hide>0</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules>help</css_modules>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426452</css_updated>
    <css_group>ipb_ie</css_group>
    <css_content><![CDATA[/********************************************/
/* IE6 SPECIFIC */
/********************************************/
#header { _height: 1%; }

.maintitle, #footer_utilities, #ipboard_body .ips_editor .toolbar, #admin_bar {	_background-image: none !important; }

h2.maintitle{ _overflow:visible; _height:1% }

.statistics, #footer_utilities, #ipboard_body .ips_editor .controls, .member_entry, #search_results li { _height: 100%; }

#footer_utilities form, .rep_bar { _width: 1%; }

#context_search, #multimod { _float: right; _position: relative; _left: -50px; _margin-bottom: 5px; }

#forum_legend dt, #forum_legend dd { _height: 25px; }

#ipboard_body .rte_fontsize{ _width:50px }
#ipboard_body .rte_font { _width:85px }
#ipboard_body .rte_special{ _width:90px }
#toggle_post_options{ _overflow:visible; _height:1% }

.author_info, .post_block { _height: 100%; }

#fast_reply, #member_alpha { _clear: both; }
#ipboard_body .input_rte { _border: 1px inset #000; }


/*******************************************/
/* <= IE7 */

table{ border-collapse: collapse; }

#new_skin_menucontent li, #new_skin_menucontent a{ display: block !important; }
#new_skin_menucontent a{ float: none !important; }

a#quickNavLaunch img{ margin-top: 10px !important; }

.services img{ margin-top: 10px; }

/* general fixes */
.ipsList_inline li { zoom: 1; display: inline; }
.clearfix { height: 1%; }
table.ipb_table h4 { display: inline; zoom: 1 }

/* header fixes */
#search_wrap { width: 230px }
#search { width: 350px; display: inline; zoom: 1; }
#main_search { float: left; margin-top: 5px; }

/***********************************/
/* Gallery IE fixes 			   */

.gallery_row {
	display: block;
}

.gallery_block, .image_wrap, .image_view_wrap {
	display: inline;
	zoom: 1;
}

.gallery_row .gallery_block .wrap .pinned,
.gallery_row .gallery_block .wrap .image_mod {
	width: 20px;
}

.note_fill {
	width: 98.5%;
	height: 98.5%;
}]]></css_content>
    <css_position>0</css_position>
    <css_app>core</css_app>
    <css_app_hide>0</css_app_hide>
    <css_attributes/>
    <css_modules/>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426452</css_updated>
    <css_group>ipb_login_register</css_group>
    <css_content><![CDATA[/************************************************************************/
/* IP.Board 3 CSS - By Rikki Tissier - (c)2008 Invision Power Services	*/
/************************************************************************/
/* ipb_login_register.css - Login & Registration styles					*/
/************************************************************************/

#register_form { 
	/*width: 70%;
	margin: 0 auto;*/
}

#register_form .ipsForm_submit{ text-align: center; }
#register_form .ipsPad .ipsForm_submit{ margin: 0 -9px -9px -9px; }
#register_submit { font-size: 13px; }
/*#register_form #save_time { color: #136db5; }*/
#register_form hr, #login_form hr {
	display: block;
	width: 95%;
	clear: both;
	margin: 10px auto;
}

#captcha .ipsField_title { padding-right: 0px; }
#captcha.recaptcha .ipsField_content { margin-left: 193px; }

#tou_popup { height: 250px !important; overflow: auto; }

#register_form .f { margin: 4px 12px 4px 0; display: inline-block; vertical-align: middle; }
	
.reg_msg {	
	color: #fff;
	font-size: 0.8em;
	font-weight: bold;
	border-radius: 4px;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	padding: 3px 8px;
	position: absolute;
}

	.reg_msg img {
		display: none;
	}
	.reg_msg.reg_error {
		background-color: #ad2930;
	}
	.reg_msg.reg_accept {
		background-color: #6f8f52;
	}

#login_form { /*width: 70%; margin: 0 auto;*/ }
#other_signin { width: 35%; }

#member_login .extra {
	font-size: 0.8em;
	/*color: #69727b;*/
	padding: 5px;
	margin-right: 10px;
	float: right;
}

#facebookComplete img.servicepic {
	float: left;
	margin-top: -2px;
	margin-left: -12px;
}

#facebookComplete p {
	margin-left: 60px;
	line-height: 150%;
}

.resize_form{
	margin: 0 auto;
	width: 700px;
}]]></css_content>
    <css_position>1</css_position>
    <css_app>core</css_app>
    <css_app_hide>1</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules>global</css_modules>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426452</css_updated>
    <css_group>ipb_search</css_group>
    <css_content><![CDATA[/************************************************************************/
/* IP.Board 3 CSS - By Rikki Tissier - (c)2008 Invision Power Services	*/
/************************************************************************/
/* ipb_search.css - Search results styles								*/
/************************************************************************/

.ipsFilterbar #search_sort .submenu_indicator
{
    width: 9px; height: 5px;
    background: #244156 url({style_images_url}/header_dropdown.png ) no-repeat;
    display: inline-block;
    /* Prevent padding in sort buttons */
}

#main_search_form .ipsBox_container { margin-bottom: 10px; }
#main_search_form .ipsField { margin-bottom: 20px; }

.toggle_notify_on { display: none; }
.show_notify .toggle_notify_on { display: block; }
	.show_notify input.toggle_notify_on { display: inline; }
    .show_notify a.ipbmenu { display: none; }
.show_notify .toggle_notify_off { display: none; }	

.notify_info span {
	padding: 1px 8px;
	background: #ededed;
	-moz-border-radius: 2px;
	-webkit-border-radius: 2px;
	border-radius: 2px;
	font-size: 10px;
	font-weight: bold;
	display: inline-block;
}
	
	.notify_info img { vertical-align: bottom; }

#main_search_form .search_app {
	font-size: 12px;
	display: inline-block;
	padding: 8px 10px 8px 8px;
	margin-right: 8px;
	font-weight: bold;
	cursor: pointer;
}

#main_search_form .search_app label{ cursor: pointer; vertical-align: middle; }
#main_search_form .search_app input{ margin: 0; margin-right: 1px; vertical-align: middle; }

	#main_search_form .search_app.active {
		background: url('{style_images_url}/trans40.png') repeat;
		background: rgba(0,0,0,0.4);
		-webkit-box-shadow: inset rgba(0,0,0,0.5) 0px 1px 2px;
		-moz-box-shadow: inset rgba(0,0,0,0.5) 0px 1px 2px;
		box-shadow: inset rgba(0,0,0,0.5) 0px 1px 2px;
		text-shadow: rgba(0,0,0,0.3) 0px 1px 2px;
		color: #fff;
		border-radius: 3px;
		-moz-border-radius: 3px;
		-webkit-border-radius: 3px;
	}

#main_search_form .search_msg {
	border-bottom: 1px solid #f0f0f0;
	display: block;
	font-size: 12px;
	padding: 0 0 5px 200px;
	margin-bottom: 15px;
	color: #5c5c5c;
}

div#search_results {
	
}	
	
	div#search_results span.icon {
		float: left;
		margin-right: 15px;
	}
	
	div#search_results div.result_info {
		float: left;
		width: 68%;
	}
	
		div#search_results div.result_info span.desc.breadcrumb a {
			color: #a9a9a9;
		}
	
	div#search_results h3 {
		background: none;
		font-weight: normal;
		font-size: 1.3em;
		border: 0;
		padding: 0;
	}

	div#search_results li.liwrap {
		padding: 10px 15px 15px 15px;
		border-top: 1px solid #fff;
	}

	div#search_results p {
		color: #606060;
		margin: 4px 0 2px 0;
	}
	
	/* Further details */
	div#search_results .result_details {
		width: 30%;
		float: right;
		border-left: 1px solid #B5C0CF;
		padding-left: 15px;
		line-height: 130%;
		font-size: 11px;
	}
	
		div#search_results .result_details li {
			border: 0;
			padding: 0;
		}

	div#search_results .gutter {
		background-color: #528f6c;
		color: #fff;
		font-size: 9px;
		font-weight: bold;
		text-transform: uppercase;
		padding: 3px 8px 2px 8px;
		margin-top: 0px;
		margin-right: 15px;
		display: none;
		float: left;
	}

		div#search_results .gutter img {
			padding-right: 4px;
		}

	div#search_results .sub div.result_info {
		padding-left: 3%;/*padding-left: 45px;*/
	}

		div#search_results .sub .gutter {
			background-color: #dedede;
			color: #1d3652;
			padding: 6px 8px 5px 8px;
			margin-left: 45px;
		}

	div#search_results ol ol {
		padding: 20px 0 0 15px;
		margin: 0 0 -15px 20px;
	}
	
	.tab_filters ul {
		padding-top: 5px;
	}
	
	.tab_filters ul.padded
	{
		padding-top: 10px;
	}
	
/* as forum stuffs */
.maintitle.links,
.maintitle a {
	text-decoration: none;
	font-size: 12px;
}
.entry-content.search {}

/* These styles are duplicated Rikki, putting a note as requested */

.search_filter_container {
	height: 440px;
	max-height: 440px;
}
.search_filter_container ul.block_list {
	height: 396px; overflow: auto;
}
.search_filter_container ul.block_list > li {
	padding: 0px;
}

.search_filter_container ul.block_list > li span {
	padding: 3px 10px 3px 25px;
	display: block;
}

	.search_filter_container ul.block_list li span.heading {
		font-weight: bold;
	}

.search_filter_container ul.block_list li.active span {
	background: #af286d url({style_images_url}/icon_check_white.png ) no-repeat 6px 8px;
	color: #fff;
	font-weight: bold;
}

#vnc_filter_popup_close { 
	text-align: center;
	position: absolute;
	bottom: 0; left: 0;	right: 0;
	height: 42px;
	line-height: 42px;
	padding: 0 5px;
}

#vnc_filter_popup_close .input_submit{ line-height: 18px; }

#main_search_form .input_text{
	margin: 0 3px 2px 0;
}]]></css_content>
    <css_position>2</css_position>
    <css_app>core</css_app>
    <css_app_hide>1</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules>search</css_modules>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415511138</css_updated>
    <css_group>ipb_styles</css_group>
    <css_content><![CDATA[/************************************************************************/
/* IP.Board 3 CSS - By Rikki Tissier - (c)2011 Invision Power Services 	*/
/* Enhanced and modified by Ehren & Sebastien // http://www.skinbox.net	*/
/************************************************************************/
/* ipb_styles.css														*/
/************************************************************************/

/************************************************************************/
/* RESET (Thanks to YUI) */

body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td { margin:0; padding:0; } 
table {	border-spacing:0; }
fieldset,img { border:0; }
address,caption,cite,code,dfn,th,var { font-style:normal; font-weight:normal; }
ol,ul { list-style:none; }
caption,th { text-align:left; }
h1,h2,h3,h4,h5,h6 { font-size:100%;	font-weight:normal; }
q:before,q:after { content:''; }
abbr,acronym { border:0; }
hr { display: none; border: 0; }
address{ display: inline; }

/************************************************************************/
/* CORE ELEMENT STYLES */

body, html{ background: url('{style_images_url}/_custom/opacity75.png') repeat; }

body {
	color: #5a5a5a;
	font: normal 11px tahoma, helvetica, arial, sans-serif;
	position: relative;
	padding-bottom: 20px;
}

/* body#ipboard_body.redirector {
	background: #fff !important;
} */

input, select, textarea {
	font: normal 12px tahoma, helvetica, arial, sans-serif;
}

h3, strong { font-weight: bold; }
em { font-style: italic; }
img, .input_check, .input_radio { vertical-align: middle; }
legend { display: none; }
table { width: 100%; }
td { padding: 3px; }

a {
	color: #333;
	text-decoration: none;
}

	a:hover { color: #111; }

::-moz-selection { color: #fff;  background: #82b8e6; }
::selection      { color: #fff;  background: #82b8e6; }

#ipbwrapper {
	background-image: url('{style_images_url}/_custom/opacity90.png');
	margin: 0 auto;
	line-height: 120%;
	-webkit-border-radius: 0px;
	-moz-border-radius: 0px;
	-o-border-radius: 0px;
	-ms-border-radius: 0px;
	-khtml-border-radius:0px;
	border-radius: 0px;
	-moz-box-shadow: 0 1px 12px rgba(0,0,0,0.25);
	-webkit-box-shadow: 0 1px 12px rgba(0,0,0,0.25);
	box-shadow: 0 1px 12px rgba(0,0,0,0.25);
}

/************************************************************************/
/* LISTS */

.ipsList_inline > li {
	display: inline-block;
	margin: 0 3px;
}
	.ipsList_inline > li:first-child { margin-left: 0; }
	.ipsList_inline > li:last-child { margin-right: 0; }
	.ipsList_inline.ipsList_reset > li:first-child { margin-left: 3px; }
	.ipsList_inline.ipsList_reset > li:last-child { margin-right: 3px; }
	.ipsList_inline.ipsList_nowrap { white-space: nowrap; }
	
.ipsList_withminiphoto > li { /*margin-bottom: 8px;*/ padding: 7px; }
.ipsList_withmediumphoto > li .list_content { margin-left: 60px; }
.ipsList_withminiphoto > li .list_content { margin-left: 44px; }
#index_stats .ipsList_withtinyphoto .list_content,
.ipsList_withtinyphoto > li .list_content { margin-left: 32px; }
.list_content { word-wrap: break-word; }

.ipsList_data li { padding: 6px; line-height: 1.3; }
.ipsList_data .row_data { display: inline-block; word-wrap: break-word; max-width: 100%; }
.ipsList_data .row_title, .ipsList_data .ft {
	display: inline-block;
	float: left;
	width: 120px;
	font-weight: bold;
	text-align: right;
	padding-right: 10px;
}

.ipsList_data.ipsList_data_thin .row_title, .ipsList_data.ipsList_data_thin .ft {
	width: 80px;
}

/************************************************************************/
/* TYPOGRAPHY */

.ipsType_pagetitle, .ipsType_subtitle {
	font: 300 26px/1.4 Helvetica, Arial, sans-serif;
	color: #323232;
}
.ipsType_subtitle { font-size: 18px; }
.ipsType_sectiontitle { 
	font-size: 16px;
	font-weight: normal;
	color: #595959;
	padding: 5px 0;
}

.ipsType_pagedesc {
	color: #7f7f7f;
	line-height: 1.5;
}

.ipsType_pagedesc a { text-decoration: underline; }

.ipsType_textblock { line-height: 1.7; }

.ipsType_small { font-size: 11px; }
.ipsType_smaller, .ipsType_smaller a { font-size: 11px !important; }
.ipsType_smallest, .ipsType_smallest a { font-size: 10px !important; }

.ipsBox_container .ipsType_pagetitle{ margin-bottom: 6px; }
.ipsReset { margin: 0px !important; padding: 0px !important; }

/************************************************************************/
/* LAYOUT */

.wrapper{
	margin: 0 auto;
	min-width: 980px;
	max-width: 1600px;
	width: 90%;
}

#content {
	padding: 10px;
	line-height: 120%;
}

/************************************************************************/
/* COLORS */

.row1, .post_block.row1 { background-color: #fff; }

.row2, .post_block.row2 { background-color: #fff; }

/*.unread {	background-color: #f7fbfc; }

.unread .altrow, .unread.altrow { background-color: #E2E9F0; }*/

.unread .highlight_unread{ font-weight: bold; }

#recentajaxcontent li,
#idm_categories a,
#index_stats .status_list li,
#panel_files .file_listing li,
#panel_screenshots #ss_linked li,
.file_listing,
#cart_totals td,
div#member_filters li,
#files li,
.ipsType_sectiontitle,
#order_review td,
#package_details .package_info,
.block_list li,
.package_view_top,
.member_entry,
#help_topics li,
.ipsBox_container .ipsType_pagetitle,
.userpopup dl,
#announcements td,
.preview_info,
.sideVerticalList li,
fieldset.with_subhead ul,
.ipsList_data li,
.ipsList_withminiphoto li,
table.ipb_table td,
.store_categories li,
#mini_cart li,
#index_stats div[id*="statusReply"],
#ipg_category .ipg_category_row,
.block_inner .ipb_table td,
.gallery_pane h2,
.status_feedback li[id*="statusReply"],
.ipsSideMenu ul li,
#usercp_content .ipsType_subtitle,
.sb_login_row,
.articles .block-1,
.articles .type-1x2x2 .article_row,
#idm_category .idm_category_row,
#category_list li a,
.ipsComment{
	border-bottom: 1px solid #f3f3f3;
}

.gallery_pane h2,
.ipsBox_container .ipsType_pagetitle,
.ipsType_sectiontitle{
	border-top: 0;
}

.ipsSideMenu ul,
#register_form hr,
#login_form hr,
.ipsSettings_section,
#index_stats div[id*="statusReply"]:first-child{
	border-top: 1px solid #f3f3f3;
}

.articles .type-1x2x2 .article_row:last-child,
.store_categories ul:last-of-type li:last-of-type,
#idm_categories li:last-of-type a,
#idm_category .idm_category_row:last-of-type,
.sideVerticalList li:last-of-type,
#index_stats div[id*="statusReply"].status_reply,
.ipsList_withminiphoto li:last-of-type,
.member_entry:last-of-type,
.ipsList_data li:last-of-type,
#help_topics li:last-of-type,
table.ipb_table tr:last-of-type td{
	border-bottom: 0;
}

/* primarily used for topic preview header */
.highlighted, .highlighted .altrow { background-color: #f3f3f3; }

.border,
.statistics,
.post_block,
.ipsComment,
.popupInner,
.no_messages,
.poll_question ol,
.ipsBox_container,
.ipsFloatingAction,
.column_view .post_body{
	background: #fff;
}

.ipsBox_container {
	border: 1px solid #dcdcdc;
}

.ipsBox { background: url('{style_images_url}/transw90.png') repeat; }

    .ipsBox_container.moderated { 
        background: #f8f1f3;
        border: 1px solid #d6b0bb;
    }

	.ipsBox_notice, .ipsBox_highlight {
		background: #f4fcff;
		border-bottom: 1px solid #cae9f5;
	}

.border{
	border: 0px solid #bfbfbf;
	border-top: 0;
	-webkit-box-shadow: rgba(0,0,0,0.06) 0px 1px 3px;
	-moz-box-shadow: rgba(0,0,0,0.06) 0px 1px 3px;
	box-shadow: rgba(0,0,0,0.06) 0px 1px 3px;
}
.removeDefault .ipsBox, .removeDefault.ipsBox{ padding: 0; background: none transparent; }
.removeDefault .ipsBox_container, .removeDefault.ipsBox_container{ border: 0; }

.maintitle {
	background: #333333 url('{style_images_url}/maintitle.png') repeat-x top;
	color: #fff;
	color: rgba(255,255,255,0.8);
	padding: 9px 12px;
	font-size: 12px;
	font-weight: 300;
	-moz-border-radius: 0px 0px 0 0;
	-webkit-border-top-left-radius: 0px;
	-webkit-border-top-right-radius: 0px;
	border-radius: 0px 0px 0 0;
	border-width: 0px 0px 0 0px;
	border-color: #333333;
	border-style: solid;
	-moz-box-shadow: 0 -1px 2px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255, 0.1);
	-webkit-box-shadow: 0 -1px 2px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255, 0.1);
	box-shadow: 0 -1px 2px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255, 0.1);
	overflow: hidden;
}

h3.maintitle{ font-weight: bold; }

	.maintitle a {	color: #fff; }
	
	.collapsed .maintitle {
		opacity: 0.2;
		-moz-border-radius: 0px;
		-webkit-border-radius: 0px;
		border-radius: 0px;
	}
	
	.collapsed .maintitle:hover { opacity: 0.4; }
	
	.maintitle .toggle { 
		visibility: hidden;
		background: url('{style_images_url}/cat_minimize.png') no-repeat;
		text-indent: -3000em;
		width: 32px; 
height: 22px;
		margin: -5px -5px -10px 0;
		display: block;
		outline: 0;
	}
	
	.maintitle:hover .toggle { visibility: visible; }
	
	.collapsed .toggle {
		background-image: url('{style_images_url}/cat_maximize.png');
	}

	.category_block.collapsed .border{ opacity: 0; }
	
.header_left{ background: url('{style_images_url}/header_left.png') no-repeat 0 0; }
.header_right{ background: url('{style_images_url}/header_right.png') no-repeat 100% 0; }
.maintitle_base{ background: #363636 url('{style_images_url}/maintitle_base.png') repeat-x 0 0;	}

.maintitle_base .maintitle{
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border: 0;
	background: none transparent;
}

/* mini badges */
a.ipsBadge:hover { color: #fff; }

.ipsBadge_green { background: #7ba60d; }
.ipsBadge_purple { background: #af286d; }
.ipsBadge_grey { background: #5b5b5b; }
.ipsBadge_lightgrey { background: #b3b3b3; }
.ipsBadge_orange { background: #ED7710; }
.ipsBadge_red {	background: #bf1d00; }

.bar {
	
}
	
	.bar.altbar {
		/*background: #b6c7db;
		color: #1d3652;*/
	}

.header {
	color: #727272;
	text-shadow: rgba(255,255,255,0.5) 0px 1px 0px;
	background: #333 url('{style_images_url}/transw80.png') repeat;
}

.header th{ border-bottom: 1px solid #bfbfbf; }
	
	body .ipb_table .header a,
	body .topic_options a {
		color: #727272;
	}

.bbc_url, .bbc_email {
	color: #0f72da;
	text-decoration: underline;
}

/* Dates */
.date, .poll_question .votes {
	color: #747474;
	font-size: 11px;
}

.no_messages {
	padding: 15px 10px;
}

/* Tab bars */
.tab_bar {
	background-color: #f1f1f1;
	color: #818181;
}

	.tab_bar li.active {
		background-color: #454545;
		color: #fff;
	}
	
	.tab_bar.no_title.mini {
		border-bottom: 8px solid #454545;
	}

/* Menu popups */
.ipbmenu_content, .ipb_autocomplete {
	background: #fff;
	border: 1px solid #c6c6c6;
	-webkit-box-shadow: rgba(0,0,0,0.1) 0px 1px 5px;
	-moz-box-shadow: rgba(0,0,0,0.1) 0px 1px 5px;
	box-shadow: rgba(0,0,0,0.1) 0px 1px 5px;
}

	.ipbmenu_content li, .ipb_autocomplete li {
		border-bottom: 1px solid #ededed;
	}
	
	.ipb_autocomplete li{ padding: 3px; }
	
		.ipb_autocomplete li.active {
			background: #f5f5f5;
		}
		
	.ipbmenu_content a:hover { background: #f5f5f5; }
		
/* Forms */

.input_submit {
	background: #323232 url('{style_images_url}/highlight_faint.png') repeat-x 0 0;
	border-color: #2b2b2b;
	color: #fff;
	text-shadow: #2b2b2b 0px -1px 0px;
	-moz-box-shadow: rgba(0,0,0,0.43) 0px 1px 3px;
	-webkit-box-shadow: rgba(0,0,0,0.43) 0px 1px 3px;
	box-shadow: rgba(0,0,0,0.43) 0px 1px 3px;
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
	border-radius: 0px;
}

.input_submit:hover { 
	background-color: #434343;
	color: #fff;
}

.input_submit.alt {
	background: #646464 url('{style_images_url}/highlight_faint.png') repeat-x 0 0;
	border-color: #585858;
	color: #fff;
	text-shadow: #474747 0px -1px 0px;
	-moz-box-shadow: rgba(0,0,0,0.43) 0px 1px 3px;
	-webkit-box-shadow: rgba(0,0,0,0.43) 0px 1px 3px;
	box-shadow: rgba(0,0,0,0.43) 0px 1px 3px;
}

.input_submit.alt:hover {
	background-color: #6f6f6f;
	color: #fff;
}

.input_submit.delete {
	background: #ad2930 url('{style_images_url}/highlight_faint.png') repeat-x 0 0;
	border-color: #962D29;
	color: #fff;
	text-shadow: #771c20 0px -1px 0px;
}

.input_submit.delete:hover { background-color: #bf3631; color: #fff; }

.input_submit:active{
	-webkit-box-shadow: inset rgba(0,0,0,0.8) 0px 1px 3px;
	-moz-box-shadow: inset rgba(0,0,0,0.8) 0px 1px 3px;
	box-shadow: inset rgba(0,0,0,0.8) 0px 1px 3px;
	position: relative;
	top: 1px;
}

.input_submit.alt:active{
	-webkit-box-shadow: inset rgba(0,0,0,0.5) 0px 1px 3px;
	-moz-box-shadow: inset rgba(0,0,0,0.5) 0px 1px 3px;
	box-shadow: inset rgba(0,0,0,0.5) 0px 1px 3px;
}

#vnc_filter_popup_close,
body#ipboard_body fieldset.submit,
body#ipboard_body p.submit,
.ipsForm_submit{
	background: url('{style_images_url}/transw80.png') repeat;
	border-top: 1px solid #cccccc;
}

/* Moderated styles */
.moderated, body .moderated td, .moderated td.altrow, .post_block.moderated, .post_block.moderated .post_body,
body td.moderated, body td.moderated {
	background-color: #f8f1f3;
}
	
	.post_block.moderated { border-color: #e9d2d7; }	
	.moderated .row2, .moderated .post_controls { background-color: #f0e0e3; }
	.moderated, .moderated a { color: #6f3642; }
	.moderated h3, .moderated h3 a { color: #6f3642 !important; }
	
/************************************************************************/
/* HEADER */

#header_bar {
	background: #323232 url('{style_images_url}/highlight_faint.png') repeat-x 0 1px;
	padding: 0;
	text-align: right;
}
	
#admin_bar {
	font-size: 11px;
	line-height: 28px;
	padding: 0 12px;
	background: #323232 url('{style_images_url}/highlight_faint.png') repeat-x 0 1px;
	overflow: hidden;
	-webkit-border-radius: 0px;
	-moz-border-radius: 0px;
	border-radius: 0px;
	margin-bottom: 5px;
}
#admin_bar li{ padding-left: 10px; padding-right: 10px; }
#admin_bar li.active a { color: #fc6d35; }
#admin_bar a { color: #8a8a8a; }
#admin_bar a:hover { color: #fff; }

#user_bar{
	padding-top: 6px;
}

#user_navigation {
	float: right;
	color: #333;
	font-size: 11px;
	line-height: 36px;
	height: 36px;
	overflow: hidden;
	text-shadow: rgba(255,255,255,0.3) 0px 1px 0px;
	padding-right: 3px;
}

#user_navigation a {
	color: #222;
	float: left;
	padding: 0 12px;
	line-height: 36px;
	outline: none;
	height: 36px;
	-moz-border-radius: 0px 0px 0 0;
	-webkit-border-top-left-radius: 0px;
	-webkit-border-top-right-radius: 0px;
	border-radius: 0px 0px 0 0;
}

#user_navigation a:hover {
	background: url("{style_images_url}/transw30.png") repeat;
	background: rgba(255,255,255,0.3);
}

#user_navigation .user_photo{
	position: relative;
	vertical-align: top;
	padding: 0;
	height: 24px;
	width: auto;
	margin: 6px -6px 0px -6px;
	-webkit-box-shadow: rgba(0,0,0,0.1) 0px 1px 3px;
	-moz-box-shadow: rgba(0,0,0,0.1) 0px 1px 3px;
	box-shadow: rgba(0,0,0,0.1) 0px 1px 3px;
}

#user_navigation #sign_in img,
#user_navigation #register_link img{ vertical-align: middle; position: relative; margin: -1px 2px 0 0; }

#user_navigation .ipsList_inline li { margin: 0; padding: 0; float: left; }
	
#user_link_dd, .dropdownIndicator {
	display: inline-block;
	width: 9px; height: 5px;
	background: url('{style_images_url}/header_dropdown.png') no-repeat right;
}
	
#user_link_menucontent #links li { 
	width: 50%;
	float: left;
	margin: 3px 0;
	white-space: nowrap;
}

#user_link_menucontent #links a{ display: block; }

#user_link.menu_active #user_link_dd, .menu_active .dropdownIndicator, li.active .dropdownIndicator { background-position: right; }
#community_app_menu .menu_active .dropdownIndicator { background-position: left; }
#community_app_menu li.active .menu_active .dropdownIndicator { background-position: right; }
#user_link_menucontent #statusForm { margin-bottom: 15px; }
#user_link_menucontent #statusUpdate {	margin-bottom: 5px; }

#user_link_menucontent > div {
	margin-left: 15px;
	width: 265px;
	text-align: left;
}

#statusSubmitGlobal { margin-top: 3px; }

#user_navigation a#user_link.menu_active,
#user_navigation a#notify_link.menu_active,
#user_navigation a#inbox_link.menu_active {
	background-position: bottom;
	background-color: #fff;
	color: #323232;
	-moz-border-radius: 0px 0px 0 0;
	-webkit-border-top-left-radius: 0px;
	-webkit-border-top-right-radius: 0px;
	border-radius: 0px 0px 0 0;
	position: relative;
	z-index: 10000;
}

#notify_link, #inbox_link {
	vertical-align: middle;
	width: 20px;
	padding: 0px 8px !important;
	position: relative;
}

#notify_link img { background-image: url('{style_images_url}/icon_notify.png'); }
#inbox_link img { background-image: url('{style_images_url}/icon_inbox.png'); }

#notify_link img, #inbox_link img{
	width: 20px;
	height: 20px;
	background-repeat: no-repeat;
	background-position: 0 0;
	margin-top: -2px;
}

#notify_link.menu_active img, #inbox_link.menu_active img{ background-position: 0 -20px; }

.services img{ margin: -1px -2px 0 -2px; }

#branding {
	background: #333 url('{style_images_url}/branding_bg.png') repeat-x center;
	border-bottom: 0;
	min-height: 60px;
	-webkit-border-radius: 0px 0px 0 0;
	-moz-border-radius: 0px 0px 0 0;
	-o-border-radius: 0px 0px 0 0;
	-ms-border-radius: 0px 0px 0 0;
	-khtml-border-radius: 0px 0px 0 0;
	border-radius: 0px 0px 0 0;
	-webkit-border-top-left-radius: 0px;
	-webkit-border-top-right-radius: 0px;
}
	
#logo { float: left;}

/* Text logo */

/*#logo a{
	color: #fff;
	height: 64px;
	line-height: 64px;
	padding: 0 12px;
	font-weight: bold;
	font-size: 24px;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	display: block;
	text-decoration: none;
}*/

#primary_nav {
	background: #284b72 url('{style_images_url}/primarynav_bg.png') repeat-x top;
	font-size: 14px;
	padding: 7px;
}

	#community_app_menu > li { margin: 0px 3px 0 0; position: relative; }

	
	#community_app_menu > li > a {
		color: #b8c4ce;
		color: rgba(255,255,255,0.6);
		font-family: tahoma, 'helvetica neue', arial;
		background: transparent;
		display: block;
		padding: 0px 12px;
		line-height: 27px;
		text-shadow: 0px 1px 1px rgba(0,0,0,0.5);
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		-o-border-radius: 0px;
		-ms-border-radius: 0px;
		-khtml-border-radius: 0px;
		border-radius: 0px;
		-webkit-transition: all 250ms ease;
		-moz-transition: all 250ms ease;
		-o-transition: all 250ms ease;
		-ms-transition: all 250ms ease;
		transition: all 250ms ease;
	}

		#community_app_menu > li > .icon {
			position: relative;
			opacity: 0.8;
			margin-right: 2px;
			margin-top: -2px;
			display: none;
		}

		#community_app_menu > li > a:hover,
		#community_app_menu > li > a.menu_active {
			background: transparent url('{style_images_url}/_custom/primarylink_hover.png') repeat-x top;
			color: #fff;
			text-decoration: none;
			box-shadow: inset 0 1px 0px rgba(255,255,255,0.1);
			-webkit-box-shadow: inset 0 1px 0px rgba(255,255,255,0.1);
			-moz-box-shadow: inset 0 1px 0px rgba(255,255,255,0.1);
		}

		#community_app_menu > li > a:active {
			background: rgba(0,0,0,0.1);
			box-shadow: 0 1px 0 rgba(255,255,255,0.2), inset 0 5px 15px rgba(0,0,0,0.4);
			-webkit-box-shadow: 0 1px 0 rgba(255,255,255,0.2), inset 0 5px 15px rgba(0,0,0,0.4);
			-moz-box-shadow: 0 1px 0 rgba(255,255,255,0.2), inset 0 5px 15px rgba(0,0,0,0.4);
			color: #fff;
			text-shadow: -1px -1px -1px #000;
		}
		
			#community_app_menu > li > a:active img {
				opacity: 0.5;
			}
	
	#community_app_menu > li.active > a {
		background: rgba(0,0,0,0.3);
		box-shadow: 0 1px 0 rgba(255,255,255,0.2), inset 0 5px 15px rgba(0,0,0,0.4);
		-webkit-box-shadow: 0 1px 0 rgba(255,255,255,0.2), inset 0 5px 15px rgba(0,0,0,0.4);
		-moz-box-shadow: 0 1px 0 rgba(255,255,255,0.2), inset 0 5px 15px rgba(0,0,0,0.4);
		color: #fff;
		font-weight: bold;
		text-shadow: none;
	}

#more_apps_menucontent, .submenu_container {
	background: #173455;
	font-size: 12px;
	border: 0;
	min-width: 140px;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	-moz-border-radius: 0 0 4px 4px;
	-webkit-border-bottom-right-radius: 4px;
	-webkit-border-bottom-left-radius: 4px;
	border-radius: 0 0 4px 4px;
}
	#more_apps_menucontent li, .submenu_container li { padding: 0; border: 0; float: none !important; min-width: 150px; }
	#more_apps_menucontent a, .submenu_container a { 
		display: block;
		padding: 8px 10px;
		color: #c5d5e2;
		text-shadow: 0px -1px 0px rgba(0,0,0,0.5);
	}
	
	#more_apps_menucontent a:hover, .submenu_container a:hover { background: #1d3c5f; color: #fff; }
	
	#more_apps_menucontent li:last-child a{
		-moz-border-radius: 0 0 4px 4px;
		-webkit-border-bottom-right-radius: 4px;
		-webkit-border-bottom-left-radius: 4px;
		border-radius: 0 0 4px 4px;
	}

#community_app_menu .submenu_container { width: 260px; }
#community_app_menu .submenu_container li {width: 260px; }

#secondary_navigation{
	overflow: hidden;
	/*line-height: 28px;*/
	padding: 6px;
	margin-bottom: 8px;
	clear: both;
}

#secondary_navigation a{
	color: #757575;
}

#secondary_navigation a:hover{ color: #222; }

	#secondary_navigation #breadcrumb li {
		float: left;
	}

	#secondary_navigation #breadcrumb li a {
		padding-left: 12px;
		margin-left: -15px;
		background: url('{style_images_url}/secondary_nav.png') no-repeat 0 0;
		display: block;
		outline: none;
		text-decoration: none;
	}
	
	#secondary_navigation #breadcrumb li.first a{
		margin-left: 0;
		background: none;
		padding-left: 0px;
	}
	
	#secondary_navigation #breadcrumb li span{
		display: block;
		padding-right: 17px;
		padding-left: 4px;
		background: url('{style_images_url}/secondary_nav.png') no-repeat 100% 0;
	}
	
	#secondary_navigation #breadcrumb li > span{ padding-left: 4px; background: none transparent; }
	
	#secondary_navigation #breadcrumb li.first a span{
		padding-left: 12px;
		-webkit-border-top-left-radius: 0px;
		-webkit-border-bottom-left-radius: 0px;
		-moz-border-radius: 0px 0px 0px 0px;
		border-radius: 0px 0px 0px 0px;
	}
	
	#secondary_navigation #breadcrumb li a:hover{
		background-position: 0 -43px;
	}
	
	#secondary_navigation #breadcrumb li a:hover span{
		background-position: 100% -43px;
	}
	
	#secondary_navigation #breadcrumb li a:active{
		background-position: 0 -86px;
	}
	
	#secondary_navigation #breadcrumb li a:active span{
		background-position: 100% -86px;
	}

#secondary_links{ overflow: hidden; }
#secondary_links li{ float: left; margin: 0; }

#secondary_links a{
	padding: 0 7px;
	display: block;
}

#secondary_links img { 
	vertical-align: middle;
	width: 16px;
	height: 16px;
	position: relative;
	/*margin: 10px -4px 0 -4px;*/
	margin-left: 2px;
	opacity: 0.7;
}

#secondary_links a:hover img { opacity: 1; }

.breadcrumb {
	color: #777;
	font-size: 11px;
}
	.breadcrumb a { color: #777; }
	.breadcrumb li .nav_sep { margin: 0 5px 0 0; }
	.breadcrumb li:first-child{ margin-left: 0; }
	/*.breadcrumb.top { margin-bottom: 10px; }*/
	.breadcrumb.bottom { margin-top: 10px; width: 100%; display: none; }

.ipsHeaderMenu {
	background: #ffffff;
	padding: 10px;
	-moz-border-radius: 0 0 0px 0px;
	-webkit-border-bottom-right-radius: 0px;
	-webkit-border-bottom-left-radius: 0px;
	border-radius: 0 0 0px 0px;
	overflow: hidden;
	width: 340px;
}

.ipsHeaderMenu.boxShadow{
	-webkit-box-shadow: rgba(0,0,0,0.4) 0px 0px 10px;
	-moz-box-shadow: rgba(0,0,0,0.4) 0px 0px 10px;
	box-shadow: rgba(0,0,0,0.4) 0px 0px 10px;
}

	.ipsHeaderMenu .ipsType_sectiontitle { margin-bottom: 8px; }
	
	#user_notifications_link_menucontent.ipsHeaderMenu,
	#user_inbox_link_menucontent.ipsHeaderMenu {
		width: 300px;
	}
	
/************************************************************************/
/* SEARCH */	

#search { margin: 18px 18px 0px 0px; }

#main_search {
	font-size: 12px;
	border: 0;
	padding: 0;
	background: transparent;
	width: 138px;
	outline: 0;
	color: #fff;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
}

#main_search.inactive {	color: #fff; color: rgba(255,255,255,0.6); }

#search_wrap {
	position: relative;
	background: url('{style_images_url}/_custom/transwhite.png') repeat;
	display: block;
	padding: 0 26px 0 8px;
	height: 26px;
	line-height: 25px;
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
	border-radius: 0px;
	min-width: 230px;
}

#adv_search {
	width: 26px;
	height: 26px;
	-webkit-border-radius: 0px;
	-moz-border-radius: 0px;
	border-radius: 0px;
	background: url('{style_images_url}/advanced_search.png') no-repeat 50% 50%;
	text-indent: -3000em;
	display: inline-block;
	margin-left: 3px;
}

#adv_search:hover{ background-color: rgba(255,255,255,0.2); }

#search .submit_input {
	background: url('{style_images_url}/search_icon.png') no-repeat 50%;
	text-indent: -3000em;
	padding: 0; border: 0;
	display: block;
	width: 26px;
	height: 26px;
	position: absolute;
	right: 0; top: 0; bottom: 0;
	-moz-border-radius: 0 0px 0px 0;
	-webkit-border-top-right-radius: 0px;
	-webkit-border-bottom-right-radius: 0px;
	border-radius: 0 0px 0px 0;
}

#search .submit_input:hover{ background-color: rgba(255,255,255,0.2); }

#search_options {
	max-width: 80px;
	text-overflow:ellipsis;
	overflow: hidden;
	font-size: 10px;
	height: 20px;
	line-height: 20px;
	margin: 3px 3px 3px 0;
	padding: 0 6px;
	color: #fff;
	color: rgba(255,255,255,0.6);
	display: inline-block;
	border-right: 1px solid rgba(255,255,255,0.1);
	float: right;
}

#search_options_menucontent { min-width: 130px; padding: 0; background: #fff; border: 1px solid #c6c6c6; }
#search_options_menucontent input { margin-right: 10px; }
#search_options_menucontent li { border-bottom: 1px solid #ededed; white-space: nowrap; }
#search_options_menucontent li:last-of-type{ border-bottom: 0; }
#search_options_menucontent label:hover{ background: #f5f5f5; }
#search_options_menucontent label { cursor: pointer; display: block; padding: 0 6px; }
#search_options_menucontent li.title{ padding: 3px 6px; }
	
/************************************************************************/
/* FOOTER */	

#backtotop,
#bottomScroll{
	width: 24px;
	height: 24px;
	line-height: 20px;
	left: 50%;
	top: 50%;
	margin-left: -12px;
	margin-top: -12px;
	position: absolute;
	display: inline-block;
	background: #bdbdbd;
	-webkit-box-shadow: inset rgba(0,0,0,0.7) 0px 1px 3px;
	-moz-box-shadow: inset rgba(0,0,0,0.7) 0px 1px 3px;
	box-shadow: inset rgba(0,0,0,0.7) 0px 1px 3px;
	text-align: center;
	-moz-border-radius: 16px;
	-webkit-border-radius: 16px;
	border-radius: 16px;
	opacity: 0.4;
	outline: 0;
}

	#bottomScroll:hover, #backtotop:hover { 
		color: #fff;
		opacity: 1;
	}

#footer_utilities { 
	padding: 8px;
	position: relative;
}

#footer_utilities, #footer_utilities a{ color: #222; text-shadow: rgba(255,255,255,0.3) 0px 1px 0px; }
#footer_utilities .ipbmenu_content a{ color: #333; }
	
	#footer_utilities .ipsList_inline{ margin-top: 3px; clear: left; float: left; }
	#footer_utilities .ipsList_inline > li{ margin: 0; }
	#footer_utilities .ipsList_inline > li > a { margin-right: 0px; padding: 4px 10px; display: inline-block; }
	#footer_utilities a.menu_active { 
		background: url('{style_images_url}/trans30.png') repeat;
		background: rgba(0,0,0,0.3);
		color: #fff;
		text-shadow: rgba(0,0,0,0.3) 0px -1px 0px;
		-moz-border-radius: 0px;
		-webkit-border-radius: 0px;
		border-radius: 0px;
		-webkit-box-shadow: inset 0px 1px 3px rgba(0,0,0,0.5), rgba(255,255,255,0.16) 0px 1px 0px, rgba(255,255,255,0.05) 0px 0px 0px 1px;
		-moz-box-shadow: inset 0px 1px 3px rgba(0,0,0,0.5), rgba(255,255,255,0.16) 0px 1px 0px, rgba(255,255,255,0.05) 0px 0px 0px 1px;
		box-shadow: inset 0px 1px 3px rgba(0,0,0,0.5), rgba(255,255,255,0.16) 0px 1px 0px, rgba(255,255,255,0.05) 0px 0px 0px 1px;
	}
	
	#copyright {
		/*color: #848484;*/
		text-align: right;
		line-height: 22px;
		float: right;
	}
	
		/*#copyright a { color: #848484; }*/

#ipsDebug_footer {
	width: 900px;
	margin: 8px auto 0px auto;
	text-align: center;
	color: #404040;
	font-size: 11px;
}
	#ipsDebug_footer strong { margin-left: 20px; }
	#ipsDebug_footer a { color: #404040; }
	
#rss_menu {
	background-color: #fef3d7;
	border: 1px solid #ed7710;
}
	
	#rss_menu li { border-bottom: 1px solid #fce19b; }
	#rss_menu li:last-of-type{ border-bottom: 0; }
	#rss_menu a {
		color: #ed7710;
		padding: 5px 8px;
		text-shadow: none;
	}

		#rss_menu a:hover {
			background-color: #ed7710;
			color: #fff;
		}

/************************************************************************/
/* GENERAL CONTENT */

.ipsUserPhoto {
	padding: 1px;
	/*border: 0px solid #a1a1a1;
	background: #fff;
	-webkit-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
	-moz-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
	box-shadow: 0px 2px 2px rgba(0,0,0,0.1);*/
}
	
	.ipsUserPhotoLink:hover .ipsUserPhoto {
		border-color: #999999;
		-webkit-box-shadow: 0px 2px 2px rgba(0,0,0,0.2);
		-moz-box-shadow: 0px 2px 2px rgba(0,0,0,0.2);
		box-shadow: 0px 2px 2px rgba(0,0,0,0.2);
	}

	.ipsUserPhoto_variable { max-width: 155px; }
	.ipsUserPhoto_large { max-width: 144px; max-height: 300px; }
	.ipsUserPhoto_medium { width: 50px; height: 50px; }
	.ipsUserPhoto_mini { width: 30px; height: 30px; }
	.ipsUserPhoto_tiny { width: 20px; height: 20px;	}
	.ipsUserPhoto_icon { width: 16px; height: 16px;	}

.general_box {
	
}

.general_box .none {
	color: #bcbcbc;
}

.general_box.poll{ margin: 0; border-width: 0 0 1px 0; }

.ipsBox, .ipsPad { padding: 9px; }
	.ipsPad_double { padding: 9px 19px; } /* 19px because it's still only 1px border to account for */
	.ipsBox_withphoto { margin-left: 65px; }
	
	.ipsBox_notice {
		padding: 10px;
		line-height: 1.6;
		margin-bottom: 10px;
	}
	.ipsBox_container .ipsBox_notice {	margin: -10px -10px 10px -10px;	}	
.ipsPad_half { padding: 4px !important; }
.ipsPad_left { padding-left: 9px; }
.ipsPad_top { padding-top: 9px; }
.ipsPad_top_slimmer { padding-top: 7px; }
.ipsPad_top_half { padding-top: 4px; }
.ipsPad_top_bottom { padding-top: 9px; padding-bottom: 9px; }
.ipsPad_top_bottom_half { padding-top: 4px; padding-bottom: 4px; }
.ipsMargin_top { margin-top: 9px; }

.ipsBlendLinks_target .ipsBlendLinks_here {
		opacity: 0.5;
		-webkit-transition: all 0.1s ease-in-out;
		-moz-transition: all 0.2s ease-in-out;
	}
	.ipsBlendLinks_target:hover .ipsBlendLinks_here { opacity: 1; }
	
.block_list > li {
	padding: 5px 10px;
}

.ipsModMenu {
	width: 15px;
	height: 15px;
	display: inline-block;
	text-indent: -2000em;
	background: url('{style_images_url}/moderation_cog.png') no-repeat;
	margin-right: 5px;
	vertical-align: middle;
}

.ipsBadge {
	vertical-align: middle;
	display: inline-block;
	height: 15px;
	line-height: 15px;
	padding: 0 5px;
	font-size: 9px;
	font-weight: bold;
	text-transform: uppercase;
	color: #fff;
	text-shadow: rgba(0,0,0,0.2) 0px -1px 0px;
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
	border-radius: 0px;
	background-image: url('{style_images_url}/highlight.png');
	background-repeat: repeat-x;
	background-position: 0 -1px;
}

    .ipsBadge.has_icon img {
        max-height: 7px;
        vertical-align: baseline;
    }

	#nav_app_ipchat .ipsBadge {	position: absolute;	}
	
#ajax_loading {
	background: #000;
	color: #fff;
	text-align: center;
	padding: 5px 0 8px;
	width: 8%;
	top: 0px;
	left: 46%;
	-moz-border-radius: 0 0 5px 5px;
	-webkit-border-bottom-right-radius: 5px;
	-webkit-border-bottom-left-radius: 5px;
	border-radius: 0 0 5px 5px;
	z-index: 10000;
	position: fixed;
	-moz-box-shadow: 0px 3px 5px rgba(0,0,0,0.2);
	-webkit-box-shadow: 0px 3px 5px rgba(0,0,0,0.2);
	box-shadow: 0px 3px 5px rgba(0,0,0,0.2);
	opacity:0.6;
}

#ipboard_body.redirector {
	width: 500px;
	margin: 150px auto 0 auto;
}

#ipboard_body.minimal { padding-top: 40px; }
#ipboard_body.minimal #ipbwrapper{
	width: 900px;
	margin: 0 auto;
}
#ipboard_body.minimal #content {
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	padding: 20px 30px;
	margin-bottom: 10px;
}
#ipboard_body.minimal h1 { font-size: 32px; }
#ipboard_body.minimal .ipsType_pagedesc { font-size: 16px; }

.progress_bar {
	background-color: #fff;
	border: 1px solid #838383;
}

	.progress_bar span {
		background: #838383 url('{style_images_url}/highlight.png') repeat-x 0 0;
		color: #fff;
		font-size: 0em;
		font-weight: bold;
		text-align: center;
		text-indent: -2000em;
		height: 10px;
		display: block;
		overflow: hidden;
	}

	.progress_bar.limit span {
		background: #b13c3c url('{style_images_url}/highlight.png') repeat-x 0 0;
	}

	.progress_bar span span {
		display: none;
	}

.progress_bar.user_warn {	
	margin: 0 auto;
	width: 80%;
}

	.progress_bar.user_warn span {
		height: 6px;
	}

.progress_bar.topic_poll {
	margin-top: 2px;
	width: 40%;
}

li.rating a {
	outline: 0;
}

.antispam_img { margin: 0 3px 5px 0; }
	
span.error {
	color: #ad2930;
	font-weight: bold;
	clear: both;
}

#recaptcha_widget_div { max-width: 350px; }
#recaptcha_table { border: 0 !important; }

.mediatag_wrapper {
    position: relative;
    padding-bottom: 56.25%;
    padding-top: 30px;
    height: 0;
    overflow: hidden;
}

.mediatag_wrapper iframe,  
.mediatag_wrapper object,  
.mediatag_wrapper embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/************************************************************************/
/* GENERIC REPEATED STYLES */
/* Inline lists */
.tab_filters ul, .tab_filters li, fieldset.with_subhead span.desc, fieldset.with_subhead label,.user_controls li {
	display: inline;
}

/* Utility styles */
.right { float: right; }
.left { float: left; }
.hide { display: none; }
.short { text-align: center; }
.clear { clear: both; }
.clearfix:after { content: ".";display: block;height: 0;clear: both;visibility: hidden; overflow: hidden;}
.faded { opacity: 0.5 }
.clickable { cursor: pointer; }
.reset_cursor { cursor: default; }

/* Bullets */
.bullets ul, .bullets ol,
ul.bullets, ol.bullets {
	list-style: disc;
	margin-left: 30px;
	line-height: 150%;
	list-style-image: none;
}

.bullets li{ padding: 2px; }

/* Rounded corners */
#user_navigation #new_msg_count, .rounded {
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
	border-radius: 0px;
}

.desc, .desc.blend_links a, p.posted_info {
	font-size: 11px;
	color: #777777;
}

.desc.lighter, .desc.lighter.blend_links a {
	color: #a4a4a4;
}

/* Cancel */
.cancel {
	font-size: 0.9em;
	font-weight: bold;
}

.cancel, .cancel:hover{
	color: #ad2930;
}

/* Moderation */
em.moderated {
	font-size: 11px;
	font-style: normal;
	font-weight: bold;
}

/* Positive/Negative */
.positive {	color: #6f8f52; }
.negative {	color: #c7172b; }

/* Search highlighting */
.searchlite
{
	background-color: yellow;
	color: red;
	font-size:14px;
}

/* Users posting */
.activeuserposting {
	font-style: italic;
}
	
/************************************************************************/
/* COLUMN WIDTHS FOR TABLES */
/* col_f = forums; col_c = categories; col_m = messenger; col_n = notifications */

.col_f_post { width: 250px !important; }
	.is_mod .col_f_post { width: 210px !important; }

	td.col_c_post { 
		padding-top: 10px !important;
		width: 250px;
	}

.col_f_icon {
	padding: 0 0 0 3px !important;
	width: 24px !important;
	text-align: center;
	vertical-align: middle;
}

.col_n_icon { 
	vertical-align: middle;
	width: 24px;
	padding: 0 !important;
}
	
.col_f_views, .col_m_replies {
	width: 100px !important;
	text-align: right;
	white-space: nowrap;
}

.col_f_mod, .col_m_mod, .col_n_mod { width: 40px; text-align: right; }
.col_f_preview { 
	width: 20px !important; 
	text-align: right;
}

.col_c_icon { padding: 10px 2px 10px 8px !important; width: 33px; vertical-align: middle; }
.col_c_post .ipsUserPhoto { margin-top: 3px; }

.col_n_date { width: 250px; }
.col_m_photo, .col_n_photo { width: 30px; }
.col_m_mod { text-align: right; }
.col_r_icon { width: 3%; }
.col_f_topic, .col_m_subject { width: 49%; }
.col_f_starter, .col_r_total, .col_r_comments {	width: 10%; }
.col_m_date, .col_r_updated, .col_r_section { width: 18%; }
.col_c_stats { width: 15%; text-align: right; }
.col_c_forum { width: auto; }
.col_mod, .col_r_mod { width: 3%; }
.col_r_title { width: 26%; }

/*.col_c_forum, .col_c_stats, .col_c_icon, .col_c_post { vertical-align: top; }*/

/************************************************************************/
/* TABLE STYLES */

table.ipb_table {
	width: 100%;
	line-height: 1.3;
}
	
	table.ipb_table td {
		padding: 10px;
	}
		
		table.ipb_table tr.unread h4 { font-weight: bold; }
		table.ipb_table tr.highlighted td { border-bottom: 0; }
	
	table.ipb_table th {
		font-size: 11px;
		font-weight: bold;
		padding: 8px 6px;
	}
	
.last_post { margin-left: 45px; }
.last_post, .col_c_stats, .col_f_views, .line_height, .ipsList_withminiphoto .list_content{ line-height: 18px; }
#user_notifications_link_menucontent .list_content{ line-height: 130%; }
.col_c_post .ipsUserPhotoLink{ margin-top: -1px; }
.forum_desc{ padding-top: 5px; }

table.ipb_table h4,
table.ipb_table .topic_title {
	font-size: 12px;
	display: inline-block;
}

table.ipb_table  .unread .topic_title { font-weight: bold; }
table.ipb_table .ipsModMenu { visibility: hidden; }
table.ipb_table tr:hover .ipsModMenu, table.ipb_table tr .ipsModMenu.menu_active { visibility: visible; }

#announcements h4 { display: inline; }
#announcements td {  }
.announcement img{ margin-right: 4px; }

.forum_data {
	font-size: 11px;
	color: #5c5c5c;
	display: inline-block;
	white-space: nowrap;
	margin: 0px 0 0 8px;
}

.desc_more {
	background: url('{style_images_url}/desc_more.png') no-repeat top;
	display: inline-block;
	width: 13px; height: 13px;
	text-indent: -2000em;
}
	.desc_more:hover { background-position: bottom; }

.category_block .ipb_table h4 { /*font-size: 15px; word-wrap: break-word;*/ }

table.ipb_table .subforums {
	margin: 7px 0 3px 0px;
	overflow: hidden;
}

table.ipb_table .subforums li{
	background: url('{style_images_url}/subforum_nonew.png') no-repeat 0 50%;
	padding: 0 15px 0 15px;
	margin: 0;
	float: left;
}

table.ipb_table .subforums li.unread { font-weight: bold; background-image: url('{style_images_url}/subforum_new.png'); }

table.ipb_table .expander { 
	visibility: hidden;
	width: 16px;
	height: 16px;
	display: inline-block;
}
table.ipb_table tr:hover .expander { visibility: visible; opacity: 0.2; }
table.ipb_table td.col_f_preview { cursor: pointer; }
table.ipb_table tr td:hover .expander, .expander.open, .expander.loading { visibility: visible !important; opacity: 1; }
table.ipb_table .expander.closed { background: url('{style_images_url}/icon_expand_close.png') no-repeat 0 0; }
table.ipb_table .expander.open { background: url('{style_images_url}/icon_expand_close.png') no-repeat 0 -19px; }
table.ipb_table .expander.loading { background: url('{style_images_url}/loading.gif') no-repeat; }
table.ipb_table .preview td {
	padding: 20px 10px 20px 29px;
	z-index: 20000;
	border-top: 0;
}

	table.ipb_table .preview td > div {
		line-height: 1.4;
		position: relative;		
	}
	
	table.ipb_table .preview td {
		-webkit-box-shadow: 0px 4px 5px rgba(0,0,0,0.15);
		-moz-box-shadow: 0px 4px 5px rgba(0,0,0,0.15);
		box-shadow: 0px 4px 5px rgba(0,0,0,0.15);
	}

.preview_col {
    margin-left: 80px;
}

.preview_info {
	padding-bottom: 3px;
	margin: -3px 0 3px;
}

table.ipb_table .mini_pagination { opacity: 0.5; }
table.ipb_table tr:hover .mini_pagination { opacity: 1; }

/************************************************************************/
/* LAYOUT SYSTEM */

.ipsLayout.ipsLayout_withleft { padding-left: 210px; }
.ipsBox.ipsLayout.ipsLayout_withleft { padding-left: 220px; }
.ipsLayout.ipsLayout_withright { padding-right: 210px; clear: left; }
.ipsBox.ipsLayout.ipsLayout_withright { padding-right: 220px; }
/* Panes */
.ipsLayout_content, .ipsLayout .ipsLayout_left, .ipsLayout_right { position: relative; }
.ipsLayout_content { width: 100%; float: left; }
.ipsLayout_content img { max-width: 100%; }
.ipsLayout .ipsLayout_left { width: 200px; margin-left: -210px; float: left; }
.ipsLayout .ipsLayout_right { width: 200px; margin-right: -210px; float: right; }

/* Wider sidebars */
.ipsLayout_largeleft.ipsLayout_withleft { padding-left: 280px; }
.ipsBox.ipsLayout_largeleft.ipsLayout_withleft { padding-left: 290px; }
.ipsLayout_largeleft.ipsLayout .ipsLayout_left { width: 270px; margin-left: -280px; }
.ipsLayout_largeright.ipsLayout_withright { padding-right: 280px; }
.ipsBox.ipsLayout_largeright.ipsLayout_withright { padding-right: 290px; }
.ipsLayout_largeright.ipsLayout .ipsLayout_right { width: 270px; margin-right: -280px; }

/* Narrow sidebars */
.ipsLayout_smallleft.ipsLayout_withleft { padding-left: 150px; }
.ipsBox.ipsLayout_smallleft.ipsLayout_withleft { padding-left: 160px; }
.ipsLayout_smallleft.ipsLayout .ipsLayout_left { width: 140px; margin-left: -150px; }
.ipsLayout_smallright.ipsLayout_withright { padding-right: 150px; }
.ipsBox.ipsLayout_smallright.ipsLayout_withright { padding-right: 160px; }
.ipsLayout_smallright.ipsLayout .ipsLayout_right { width: 140px; margin-right: -150px; }

/* Tiny sidebar */
.ipsLayout_tinyleft.ipsLayout_withleft { padding-left: 40px; }
.ipsBox.ipsLayout_tinyleft.ipsLayout_withleft { padding-left: 50px; }
.ipsLayout_tinyleft.ipsLayout .ipsLayout_left { width: 40px; margin-left: -40px; }
.ipsLayout_tinyright.ipsLayout_withright { padding-right: 40px; }
.ipsBox.ipsLayout_tinyright.ipsLayout_withright { padding-right: 50px; }
.ipsLayout_tinyright.ipsLayout .ipsLayout_right { width: 40px; margin-right: -40px; }

/* Big sidebar */
.ipsLayout_bigleft.ipsLayout_withleft { padding-left: 330px; }
.ipsBox.ipsLayout_bigleft.ipsLayout_withleft { padding-left: 340px; }
.ipsLayout_bigleft.ipsLayout .ipsLayout_left { width: 320px; margin-left: -330px; }
.ipsLayout_bigright.ipsLayout_withright { padding-right: 330px; }
.ipsBox.ipsLayout_bigright.ipsLayout_withright { padding-right: 340px; }
.ipsLayout_bigright.ipsLayout .ipsLayout_right { width: 320px; margin-right: -330px; }

/* Even Wider sidebars */
.ipsLayout_hugeleft.ipsLayout_withleft { padding-left: 380px; }
.ipsBox.ipsLayout_hugeleft.ipsLayout_withleft { padding-left: 390px; }
.ipsLayout_hugeleft.ipsLayout .ipsLayout_left { width: 370px; margin-left: -380px; }
.ipsLayout_hugeright.ipsLayout_withright { padding-right: 380px; }
.ipsBox.ipsLayout_hugeright.ipsLayout_withright { padding-right: 390px; }
.ipsLayout_hugeright.ipsLayout .ipsLayout_right { width: 370px; margin-right: -380px; }

/************************************************************************/
/* NEW FORMS */

.ipsField .ipsField_title { 
	font-weight: bold;
	font-size: 12px;
	line-height: 1.6;
}

.ipsForm_required {
	color: #ab1f39;
	font-weight: bold;
}

.ipsForm_horizontal .ipsField_title {
	float: left;
	width: 185px;
	padding-right: 15px;
	padding-top: 3px;
	text-align: right;
	line-height: 1.8;
}

.ipsForm_horizontal .ipsField { margin-bottom: 15px; }
.ipsForm_horizontal .ipsField_content, .ipsForm_horizontal .ipsField_submit { margin-left: 200px; }
.ipsForm_horizontal .ipsField_checkbox { margin: 0 0 5px 200px; }
.ipsForm_horizontal .ipsField_select .ipsField_title { line-height: 1.6; }

.ipsForm_vertical .ipsField { margin-bottom: 10px; }
.ipsForm_vertical .ipsField_content { margin-top: 3px; }

.ipsForm .ipsField_checkbox .ipsField_content { margin-left: 25px; }
.ipsForm .ipsField_checkbox input { float: left; margin-top: 3px; }

.ipsField_primary input { font-size: 18px; }

.ipsForm_submit {
	padding: 5px 10px;
	text-align: right;
	margin-top: 25px;
}

.ipsForm_right { text-align: right; }
.ipsForm_left { text-align: left; }
.ipsForm_center { text-align: center; }

/************************************************************************/
/* SETTINGS SCREENS */
.ipsSettings_pagetitle { font-size: 20px; margin-bottom: 5px; }
.ipsSettings { padding: 0 0px; }
.ipsSettings_section {
	margin: 0 0 15px 0;
	padding: 15px 0 0 0;
}
	
	.ipsSettings_section > div { margin-left: 175px; }
	.ipsSettings_section > div ul li { margin-bottom: 10px; }
	.ipsSettings_section .desc { margin-top: 3px; }
	
.ipsSettings_sectiontitle {
	font: bold 13px Helvetica, Arial, sans-serif;
	width: 165px;
	padding-left: 10px;
	line-height: 18px;
	float: left;
}

.ipsSettings_fieldtitle { 
	min-width: 100px;
	margin-right: 10px;
	font-size: 14px;
	display: inline-block;
	vertical-align: top;
	padding-top: 3px;
}

/************************************************************************/
/* TOOLTIPS */

.ipsTooltip { padding: 5px; z-index: 25000;}
.ipsTooltip_inner {
	padding: 8px;
	background: #333333;
	border: 1px solid #333333;
	color: #fff;
	-webkit-box-shadow: 0px 2px 4px rgba(0,0,0,0.3), 0px 1px 0px rgba(255,255,255,0.1) inset;
	-moz-box-shadow: 0px 2px 4px rgba(0,0,0,0.3), 0px 1px 0px rgba(255,255,255,0.1) inset;
	box-shadow: 0px 2px 4px rgba(0,0,0,0.3), 0px 1px 0px rgba(255,255,255,0.1) inset;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	font-size: 12px;
	text-align: center;
	max-width: 250px;
}
	.ipsTooltip_inner a { color: #fff; }
	.ipsTooltip_inner span { font-size: 11px; color: #d2d2d2 }
	.ipsTooltip.top 	{ background: url('{style_images_url}/stems/tooltip_top.png') no-repeat bottom center; }
		.ipsTooltip.top_left 	{ background-position: bottom left; }
	.ipsTooltip.bottom	{ background: url('{style_images_url}/stems/tooltip_bottom.png') no-repeat top center; }
	.ipsTooltip.left 	{ background: url('{style_images_url}/stems/tooltip_left.png') no-repeat center right; }
	.ipsTooltip.right	{ background: url('{style_images_url}/stems/tooltip_right.png') no-repeat center left; }
	
/************************************************************************/
/* AlertFlag */

.ipsHasNotifications {
	padding: 0px 4px;
	height: 12px;
	line-height: 12px;
	background: #cf2020;
	color: #fff !important;
	font-size: 9px;
	text-align: center;
	-webkit-box-shadow: 0px 2px 4px rgba(0,0,0,0.3), 0px 1px 0px rgba(255,255,255,0.1) inset;
	-moz-box-shadow: 0px 2px 4px rgba(0,0,0,0.3), 0px 1px 0px rgba(255,255,255,0.1) inset;
	box-shadow: 0px 2px 4px rgba(0,0,0,0.3), 0px 1px 0px rgba(255,255,255,0.1) inset;
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
	border-radius: 0px;
	position: absolute;
	top: 4px;
	left: 3px;
}

.ipsHasNotifications_blank { display: none; }
#chat-tab-count.ipsHasNotifications { left: auto; top: 3px; right: 3px; text-shadow: none !important; position: absolute; }

/************************************************************************/
/* SIDEBAR STYLE */

.ipsSideMenu { padding: 10px 0; }
.ipsSideMenu h4 { 
	margin: 0 10px 5px 25px;
	font-weight: bold;
	color: #383838;
}

.ipsSideMenu ul {
	margin-bottom: 20px;
}

.ipsSideMenu ul li {
	font-size: 11px;
}

.ipsSideMenu ul li a {
	padding: 5px 10px 5px 25px;
	display: block;
}

.ipsSideMenu ul li a:hover{
	background-color: rgba(0,0,0,0.03);
}

.ipsSideMenu ul li.active a {
	background: #6b6b6b url('{style_images_url}/icon_check_white.png') no-repeat 6px 8px;
	color: #fff;
	font-weight: bold;
}

/***************************************************************************/
/* WIZARDS */

.ipsSteps {
	background: #e9e9e9;
	height: 55px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}

.ipsSteps li:first-child{
	-webkit-border-top-left-radius: 3px;
	-webkit-border-bottom-left-radius: 3px;
	-moz-border-radius: 3px 0px 0px 3px;
	border-radius: 3px 0px 0px 3px;
}

	.ipsSteps ul li {
		float: left;
		padding: 11px 33px 5px 18px;
		color: #323232;
		background-image: url('{style_images_url}/wizard_step.png');
		background-repeat: no-repeat;
		background-position: 100% -56px;
		position: relative;
		height: 39px;
		text-shadow: rgba(255,255,255,0.6) 0px 1px 0px;
	}
	
	.ipsSteps .ipsSteps_active {
		background-position: 100% 0;
		color: #fff;
		text-shadow: 0px -1px 0 rgba(0,0,0,0.8);
	}
	
	.ipsSteps .ipsSteps_done { }
	.ipsSteps_desc { font-size: 11px; }	
	.ipsSteps_arrow { display: none; }
	
	.ipsSteps_title {
		display: block;
		font-size: 14px;
		padding-bottom: 4px;
	}
	
	.ipsSteps_active .ipsSteps_arrow {
		display: block;
		position: absolute;
		left: -23px;
		top: 0;
		width: 23px;
		height: 55px;
		background: url('{style_images_url}/wizard_step.png') no-repeat 0 -112px;
	}
	
	.ipsSteps ul li:first-child .ipsSteps_arrow { display: none !important;	}

/************************************************************************/
/* VERTICAL TABS (profile etc.) */

.ipsVerticalTabbed { }

	.ipsVerticalTabbed_content {
		min-height: 400px;
	}
	
	.ipsVerticalTabbed_tabs > ul {
		width: 149px !important;
		margin-top: 10px;
		border-top: 1px solid #dcdcdc;
		border-left: 1px solid #dcdcdc;
	}
		
		.ipsVerticalTabbed_minitabs.ipsVerticalTabbed_tabs > ul { width: 40px !important; }
		
		.ipsVerticalTabbed_tabs li {
			background: #f8f8f8;
			color: #808080;
			border-bottom: 1px solid #dcdcdc;
			font-size: 12px;
		}
			
			.ipsVerticalTabbed_tabs li a {
				display: block;
				padding: 10px 8px;
				outline: 0;
				color: #8d8d8d;
			}
				
				.ipsVerticalTabbed_tabs li a:hover {
					background: #f2f2f2;
					color: #808080;
				}
				
				.ipsVerticalTabbed_tabs li.active a {
					width: 135px;
					position: relative;
					z-index: 8000;
					background: #fff;
					color: #353535;
					font-weight: bold;
				}
				
					.ipsVerticalTabbed_minitabs.ipsVerticalTabbed_tabs li.active a {
						width: 24px;
					}

/************************************************************************/
/* 'LIKE' FUNCTIONS */

.ipsLikeBar { margin: 10px 0; font-size: 11px; }
	
	.ipsLikeBar_info {
		line-height: 22px;
		background: #f4f4f4;
		padding: 0 10px;
		display: inline-block;
		-moz-border-radius: 0px;
		-webkit-border-radius: 0px;
		border-radius: 0px;
	}
	
.ipsLikeButton {
	line-height: 20px;
	padding: 0 6px 0 25px;
	font-size: 11px;
	display: inline-block;
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
	border-radius: 0px;
	text-shadow: rgba(0,0,0,0.2) 0px -1px 0px;
	color: #fff !important;
}
	.ipsLikeButton:hover { color: #fff !important; }
	
	.ipsLikeButton.ipsLikeButton_enabled {
		background: #69af31 url('{style_images_url}/like_button.png') no-repeat 0 0;
		border: 0px solid #5ea128;
	}
	
	.ipsLikeButton.ipsLikeButton_disabled {
		background: #b8b8b8 url('{style_images_url}/like_button.png') no-repeat 0 -23px;
		border: 0px solid #a4a4a4;
	}

/************************************************************************/
/* TAG LIST */

.ipsTag {
	display: inline-block;
	background: url('{style_images_url}/tag_bg.png');
	height: 20px;
	line-height: 20px;
	padding: 0 7px 0 15px;
	margin: 5px 5px 0 0;
	font-size: 11px;
	color: #fff !important;
	text-shadow: 0 -1px 0 rgba(0,0,0,0.4);
	-moz-border-radius: 0 3px 3px 0;
	-webkit-border-top-right-radius: 3px;
	-webkit-border-bottom-right-radius: 3px;
	border-radius: 0 3px 3px 0;
}

/************************************************************************/
/* TAG EDITOR STYLES */

.ipsTagBox_wrapper {
	min-height: 18px;
	width: 350px;
	line-height: 1.3;
	display: inline-block;
	margin-bottom: 3px;
}
	
	.ipsTagBox_hiddeninput { background: none transparent; }
	.ipsTagBox_hiddeninput.inactive {
		font-size: 11px;
		min-width: 200px;
	}
	
	.ipsTagBox_wrapper input { border: 0px;	outline: 0; }
	.ipsTagBox_wrapper li {	display: inline-block; }
	
	.ipsTagBox_wrapper.with_prefixes li.ipsTagBox_tag:first-child {
		background: #dbf3ff;
		border-color: #a8e3ff;
		color: #136db5;
	}
	
	.ipsTagBox_tag {
		padding: 2px 1px 2px 4px;
		background: #f4f4f4;
		border: 1px solid #dddddd;
		margin: 0 3px 2px 0;
		font-size: 11px;
		-moz-border-radius: 2px;
		-webkit-border-radius: 2px;
		border-radius: 2px;
		cursor: pointer;
	}
	
		.ipsTagBox_tag:hover {
			border-color: #bdbdbd;
		}
		
		.ipsTagBox_tag.selected {
			background: #e2e2e2 !important;
			border-color: #c0c0c0 !important;
			color: #424242 !important;
		}
		
	.ipsTagBox_closetag {
		margin-left: 2px;
		display: inline-block;
		padding: 0 3px;
		color: #c7c7c7;
		font-weight: bold;
	}
		.ipsTagBox_closetag:hover { color: #454545;	}
		.ipsTagBox_tag.selected .ipsTagBox_closetag { color: #424242; }
		.ipsTagBox_tag.selected .ipsTagBox_closetag:hover { color: #2f2f2f;	}
		.ipsTagBox_wrapper.with_prefixes li.ipsTagBox_tag:first-child .ipsTagBox_closetag { color: #4f87bb; }
		.ipsTagBox_wrapper.with_prefixes li.ipsTagBox_tag:first-child .ipsTagBox_closetag:hover { color: #003b71; }
		
	.ipsTagBox_addlink {
		font-size: 10px;
		margin-left: 3px;
		outline: 0;
	}
	
	.ipsTagBox_dropdown {
		height: 100px;
		overflow: scroll;
		background: #fff;
		border: 1px solid #dddddd;
		-webkit-box-shadow: 0px 5px 10px rgba(0,0,0,0.2);
		-moz-box-shadow: 0px 5px 10px rgba(0,0,0,0.2);
		box-shadow: 0px 5px 10px rgba(0,0,0,0.2);
		z-index: 16000;
	}
	
		.ipsTagBox_dropdown li {
			padding: 4px;
			font-size: 12px;
			cursor: pointer;
		}
		.ipsTagBox_dropdown li:hover {
			background: #dbf3ff;
			color: #003b71;
		}

/************************************************************************/
/* TAG CLOUD */
.ipsTagWeight_1 { opacity: 1.0; }
.ipsTagWeight_2 { opacity: 0.9; }
.ipsTagWeight_3 { opacity: 0.8; }
.ipsTagWeight_4 { opacity: 0.7; }
.ipsTagWeight_5 { opacity: 0.6; }
.ipsTagWeight_6 { opacity: 0.5; }
.ipsTagWeight_7 { opacity: 0.4; }
.ipsTagWeight_8 { opacity: 0.3; }
		
/************************************************************************/
/* NEW FILTER BAR */

.ipsFilterbar li {
	margin: 0px 15px 0px 0;
	font-size: 11px;
}
	
	.ipsFilterbar li a {
		color: #fff;
		opacity: 0.5;
		text-shadow: 0px -1px 0px rgba(0,0,0,0.3);
		-webkit-transition: all 0.3s ease-in-out;
		-moz-transition: all 0.3s ease-in-out;
	}

	.ipsFilterbar.bar.altbar li a { color: #244156; text-shadow: none; opacity: .8; }
	
		.ipsFilterbar:hover li a { opacity: 0.8; }

		.ipsFilterbar li a:hover {
			color: #fff;
			opacity: 1;
		}

.ipsFilterbar li img { margin-top: -3px; }

.ipsFilterbar li.active { opacity: 1; }
	
	.ipsFilterbar li.active a, .ipsFilterbar.bar.altbar li.active a {
		background: url('{style_images_url}/trans30.png') repeat;
		background: rgba(0,0,0,0.3);
		opacity: 1;
		color: #fff;
		padding: 4px 10px;
		font-weight: bold;
		-moz-border-radius: 0px;
		-webkit-border-radius: 0px !important;
		border-radius: 0px;
		-webkit-box-shadow: inset 0px 1px 3px rgba(0,0,0,0.5), rgba(255,255,255,0.16) 0px 1px 0px, rgba(255,255,255,0.05) 0px 0px 0px 1px;
		-moz-box-shadow: inset 0px 1px 3px rgba(0,0,0,0.5), rgba(255,255,255,0.16) 0px 1px 0px, rgba(255,255,255,0.05) 0px 0px 0px 1px;
		box-shadow: inset 0px 1px 3px rgba(0,0,0,0.5), rgba(255,255,255,0.16) 0px 1px 0px, rgba(255,255,255,0.05) 0px 0px 0px 1px;
	}
		
/************************************************************************/
/* POSTING FORM STYLES */
/* Additional form styles for posting forms */

.ipsPostForm { }
	
	.ipsPostForm.ipsLayout_withright {
		padding-right: 260px !important;
	}
	
	.ipsPostForm .ipsLayout_content {
		z-index: 900;
		-webkit-box-shadow: 2px 0px 4px rgba(0,0,0,0.1);
		-moz-box-shadow: 2px 0px 4px rgba(0,0,0,0.1);
		box-shadow: 2px 0px 4px rgba(0,0,0,0.1);
		float: none;
	}
	
	.ipsPostForm .ipsLayout_right {
		width: 250px;
		margin-right: -251px;
		border-left: 0;
		z-index: 800;
	}
	
	.ipsPostForm_sidebar{ margin-top: 8px; }
	
	.ipsPostForm_sidebar .ipsPostForm_sidebar_block.closed h3 {
		background-image: url('{style_images_url}/folder_closed.png');
		background-repeat: no-repeat;
		background-position: 10px 9px;
		padding-left: 26px;
		margin-bottom: 2px;
	}

/************************************************************************/
/* MEMBER LIST STYLES */
.ipsMemberList .ipsButton_secondary { opacity: 0.7; }
.ipsMemberList li:hover .ipsButton_secondary, .ipsMemberList tr:hover .ipsButton_secondary { opacity: 1; }
.ipsMemberList li .reputation { margin: 5px 10px 0 0; }
.ipsMemberList > li .ipsButton_secondary { margin-top: 15px; }
.ipsMemberList li .rating {	display: inline; }

/************************************************************************/
/* COMMENT STYLES */
.ipsComment_wrap { margin-top: 10px; }
.border > .ipsComment_wrap, .ipsBox_container > .ipsComment_wrap{ margin: 0; }
.ipsComment_wrap .ipsLikeBar { margin: 0; }
.ipsComment_wrap input[type='checkbox'] { vertical-align: middle; }
	
.ipsComment {
	padding: 10px;
}
	
.ipsComment_author, .ipsComment_reply_user {
	width: 160px;
	text-align: right;
	padding: 0 10px;
	float: left;
	line-height: 1.3;
}

	.ipsComment_author .ipsUserPhoto { margin-bottom: 5px; }
	
.ipsComment_comment {
	margin-left: 190px !important;
	line-height: 1.5;
}

	.ipsComment_comment > div { min-height: 33px; }
	
.ipsComment_controls { margin-top: 10px; }
.ipsComment_controls > li { opacity: 0.2; }
	.ipsComment:hover .ipsComment_controls > li, .ipsComment .ipsComment_controls > li.right { opacity: 1; }

.ipsComment_reply_user_photo {
    margin-left: 115px;
}

/************************************************************************/
/* FLOATING ACTION STYLES (comment moderation, multiquote etc.) */
.ipsFloatingAction {
	position: fixed;
	right: 10px;
	bottom: 10px;
	padding: 10px;
	z-index: 15000;
	border: 0px solid #464646;
	border: 0px solid rgba(0,0,0,0.75);
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
	border-radius: 0px;
	-moz-box-shadow: 0px 3px 6px rgba(0,0,0,0.4);
	-webkit-box-shadow: 0px 3px 6px rgba(0,0,0,0.4);
	box-shadow: 0px 3px 6px rgba(0,0,0,0.4);
}

    .ipsFloatingAction.left {
        right: auto;
        left: 10px;
    }
    
    .ipsFloatingAction .fixed_inner {
        overflow-y: auto;
        overflow-x: hidden;
    }
    
/* specifics for seo meta tags editor */
#seoMetaTagEditor { width: 480px; }

    #seoMetaTagEditor table { width: 450px; }
    #seoMetaTagEditor table td { width: 50%; padding-right: 0px }

/************************************************************************/
/* FORM STYLES */

body#ipboard_body fieldset.submit,
body#ipboard_body p.submit {
	padding: 15px 6px 15px 6px;
	text-align: center;
}

.iframe{ outline: none; }

.input_text, .ipsTagBox_wrapper, textarea {
	padding: 6px;
	border: 0px solid #d4d4d4;
	background: #fcfcfc;
	color: #9f9f9f;
	text-shadow: #fff 0px 1px 0px;
	-webkit-box-shadow: inset rgba(0,0,0,0.1) 0px 1px 3px;
	-moz-box-shadow: inset rgba(0,0,0,0.1) 0px 1px 3px;
	box-shadow: inset rgba(0,0,0,0.1) 0px 1px 3px;
}

	textarea:focus, .input_text:focus {
		outline: none;
		background-color: #fefefe;
		color: #555555;
		border-color: #a0a0a0;
	}
	
	input.inactive, select.inactive, textarea.inactive { color: #c4c4c4; }

	.input_text.error {
		background: #f3dddd;
		border-color: #c98282;
		color: #ad2930;
		-webkit-box-shadow: none;
		-moz-box-shadow: none;
		box-shadow: none;
	}
	.input_text.accept {
		background: #f1f6ec;
		border-color: #cddac0;
		color: #456d1d;
		-webkit-box-shadow: none;
		-moz-box-shadow: none;
		box-shadow: none;
	}

input:-webkit-input-placeholder { color: #bbb; }
input:-moz-placeholder { color: #bbb; }

.input_submit {
	text-decoration: none;
	border-width: 0px;
	border-style: solid;
	padding: 4px 10px;
	cursor: pointer;
}

a.input_submit{
	padding: 6px 10px;
	display: inline-block;
}
	
	.input_submit.alt {
		text-decoration: none;
	}		

p.field {
	padding: 15px;
}

li.field {
	padding: 5px;
	margin-left: 5px;
}

	li.field label,
	li.field span.desc {
		display: block;
	}
	
li.field.error {
	color: #ad2930;
}

	li.field.error label {
		font-weight: bold;
	}

li.field.checkbox, li.field.cbox {
	margin-left: 0;
}

li.field.checkbox .input_check,
li.field.checkbox .input_radio,
li.field.cbox .input_check,
li.field.cbox .input_radio {
	margin-right: 10px;
	vertical-align: middle;
}

	li.field.checkbox label,
	li.field.cbox label {
		width: auto;
		float: none;
		display: inline;
	}
	
	li.field.checkbox p,
	li.field.cbox p {
		position: relative;
		left: 245px;
		display: block;
	}

	li.field.checkbox span.desc,
	li.field.cbox span.desc {
		padding-left: 27px;
		margin-left: auto;
		display: block;
	}
	
/************************************************************************/
/* MESSAGE STYLES */

.message {
	background: #cde3a4 url('{style_images_url}/highlight.png') repeat-x 0 0;
	padding: 10px;
	border: 1px solid #a8c471;
	text-shadow: rgba(255,255,255,0.55) 0px 1px 0px;
	line-height: 1.6;
	font-size: 12px;
	-webkit-box-shadow: rgba(0,0,0,0.1) 0px 1px 3px;
	-moz-box-shadow: rgba(0,0,0,0.1) 0px 1px 3px;
	box-shadow: rgba(0,0,0,0.1) 0px 1px 3px;
}

.message,
.message a,
.message h3{
	color: #436500;
}

	.message h3 {
		padding: 0;
	}
	
	.message.error {
		background-color: #f3e3e6;
		border-color: #e599aa;
	}
	
	.message.error,
	.message.error a,
	.message.error h3{
		color: #80001c;
	}
	
	.message.error.usercp {
		background-image: none;
		padding: 4px;
		float: right;
	}
	
	.message.unspecific {
		background-color: #f3f3f3;
		border-color: #d4d4d4;
		color: #515151;
		margin: 0 0 10px 0;
		clear: both;
	}
	
	.message.unspecific,
	.message.unspecific a,
	.message.unspecific h3{
		color: #515151;
	}
	
.message a{ text-decoration: underline; }
	
/************************************************************************/
/* MENU & POPUP STYLES */

.ipbmenu_content, .ipb_autocomplete {
	min-width: 85px;
	z-index: 2000;
}

.ipbmenu_content{ white-space: nowrap; }
	
	.ipbmenu_content li:last-child {
		border-bottom: 0;
		padding-bottom: 0px;
	}
	
	.ipbmenu_content li:first-child { padding-top: 0px;	}
	.ipbmenu_content.with_checks a { padding-left: 26px; }
	.ipbmenu_content a .icon { margin-right: 10px; }
	.ipbmenu_content a { 
		text-decoration: none;
		text-align: left;
		display: block;
		padding: 6px 10px;
	}
	.ipbmenu_content.with_checks li.selected a {
		background-image: url('{style_images_url}/icon_check.png');
		background-repeat: no-repeat;
		background-position: 7px 10px;
	}

.popupWrapper {
	background: url('{style_images_url}/trans60.png') repeat;
	background: rgba(0,0,0,0.6);
	padding: 8px;
	-webkit-box-shadow: rgba(0,0,0,0.5) 0px 10px 20px;
	-moz-box-shadow: rgba(0,0,0,0.5) 0px 10px 20px;
	box-shadow: rgba(0,0,0,0.5) 0px 10px 20px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
}

	.popupInner {
		width: 500px;
		overflow: auto;
		-webkit-box-shadow: 0px 0px 3px rgba(0,0,0,0.4);
		-moz-box-shadow: 0px 0px 3px rgba(0,0,0,0.4);
		box-shadow: 0px 0px 3px rgba(0,0,0,0.4);
		overflow-x: hidden;
	}
	
		.popupInner.black_mode {
			background: #000;
			color: #eee;
			border: 3px solid #626262;
		}
		
		.popupInner.warning_mode {
			border: 3px solid #7D1B1B; 
		}
	
		.popupInner h3 {
			border-bottom: 1px solid #d8d8d8;
			text-shadow: rgba(255,255,255,0.8) 0px 1px 0px;
			background: #eee url('{style_images_url}/highlight.png') repeat-x 0 0;
			padding: 8px 10px 9px;
			font-size: 16px;
			font-weight: 300;
		}
		
			.popupInner h3 a { color: #727272; }
		
			.popupInner.black_mode h3 {
				background-color: #595959;
				color: #ddd;
			}
			
			.popupInner.warning_mode h3 {
				background-color: #7D1B1B;
				padding-top: 6px;
				padding-bottom: 6px;
				color: #fff;
			}
			
.popupClose {
	position: absolute;
	right: 20px;
	top: 20px;
}

.popupClose.light_close_button {
	background: transparent url('{style_images_url}/close_popup_light.png') no-repeat top left;
	opacity: 0.8;
	width: 13px;
	height: 13px;
	top: 17px;
}

.popupClose.light_close_button img {
	display: none;
}

.popup_footer {
	padding: 15px;
	position: absolute;
	bottom: 0px;
	right: 0px;
}

.popup_body {
	padding: 10px;
}

.stem {
	width: 31px;
	height: 16px;
	position: absolute;
}

	.stem.topleft { background-image: url('{style_images_url}/stems/topleft.png');	}
	.stem.topright { background-image: url('{style_images_url}/stems/topright.png'); }
	.stem.bottomleft { background-image: url('{style_images_url}/stems/bottomleft.png'); }
	.stem.bottomright { background-image: url('{style_images_url}/stems/bottomright.png');	}
	
.modal {
	background-color: #3e3e3e;
}

.userpopup h3 { font-size: 17px; }
.userpopup h3, .userpopup .side + div { padding-left: 110px; }
.userpopup .side { position: absolute; margin-top: -40px; }
.userpopup .side .ipsButton_secondary {
	display: block;
	text-align: center;
	margin-top: 5px;
	max-width: 75px;
	height: auto;
	line-height: 1;
	padding: 5px 10px;
	white-space: normal;
}
.userpopup .user_controls { text-align: left; }
.userpopup .user_status { padding: 5px; margin-bottom: 5px; }
.userpopup .reputation {
	display: block; 
	text-align: center;
	margin-top: 5px;
}

.userpopup {
	overflow: hidden;
	position: relative;
	font-size: 0.9em;
	min-height: 200px;
}

	.userpopup dl {
		padding-bottom: 10px;
		margin-bottom: 4px;
	}

.info dt {
	float: left;
	font-weight: bold;
	padding: 3px 6px;
	clear: both;
	width: 30%;
}

.info dd {
	padding: 3px 6px;
	width: 60%;
	margin-left: 35%;
}

/************************************************************************/
/* BUTTONS STYLES */

.topic_buttons li {
	float: right;
	margin: 0 0 10px 10px;
}

.topic_buttons li.important a, .topic_buttons li.important span, .ipsButton .important,
.topic_buttons li a, .topic_buttons li span, .ipsButton {
	background: #212121 url('{style_images_url}/highlight_faint.png') repeat-x 0 1px;
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
	border-radius: 0px;
	-webkit-box-shadow: 0px 1px 3px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 1px 3px rgba(0,0,0,0.2);
	box-shadow: 0px 1px 3px rgba(0,0,0,0.2);
	color: #fff;
	text-shadow: 0 -1px 0 rgba(0,0,0,0.3);
	font-size: 12px;
	font-weight: bold;
	line-height: 34px;
	height: 34px;
	padding: 0 20px;
	text-align: center;
	min-width: 70px;
	display: inline-block;
	cursor: pointer;
}

.topic_buttons li.important a, .topic_buttons li.important span, .ipsButton .important, .ipsButton.important {
	background: #8b1515 url('{style_images_url}/highlight_faint.png') repeat-x 0 1px !important;
	border-color: #790f0f;
}
	
	.topic_buttons li a:hover, .ipsButton:hover { opacity: 0.8; color: #fff; }
	
	.topic_buttons li a:active, .ipsButton:active{
		position: relative;
		top: 1px;
		-webkit-box-shadow: inset rgba(0,0,0,0.3) 0px 1px 2px;
		-moz-box-shadow: inset rgba(0,0,0,0.3) 0px 1px 2px;
		box-shadow: inset rgba(0,0,0,0.3) 0px 1px 2px;
	}
	
	.topic_buttons li.non_button a {
		background: transparent !important;
		background-color: transparent !important;
		border: 0;
		box-shadow: none !important;
		-moz-box-shadow: none !important;
		-webkit-box-shadow: none !important;
		text-shadow: none;
		min-width: 0px;
		color: #777777;
		font-weight: normal;
		padding-top: 1px;
		padding-bottom: 1px;
	}
	
	.topic_buttons li.non_button a:active{ top: 0; }
	
	.topic_buttons li.disabled a, .topic_buttons li.disabled span {
		background: #ebebeb;
		box-shadow: none;
		-moz-box-shadow: none;
		-webkit-box-shadow: none;
		text-shadow: none;
		border: 0;
		color: #7f7f7f;
	}
	
	.topic_buttons li span { cursor: default !important; }

.ipsButton_secondary,
.bbc_spoiler_show,
.user_controls li a{
	height: 24px;
	line-height: 24px;
	font-size: 11px;
	padding: 0 10px;
	background: #ececec url('{style_images_url}/highlight_strong.png') repeat-x 0 0;
	border: 1px solid #c0c0c0;
	-moz-box-shadow: 0px 1px 2px rgba(0,0,0,0.1), inset rgba(255,255,255,0.7) 0px 1px 0px;
	-webkit-box-shadow: 0px 1px 2px rgba(0,0,0,0.1), inset rgba(255,255,255,0.7) 0px 1px 0px;
	box-shadow: 0px 1px 2px rgba(0,0,0,0.1), inset rgba(255,255,255,0.7) 0px 1px 0px;
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
	border-radius: 0px;
	color: #616161;
	text-shadow: #fff 0px 1px 0px;
	display: inline-block;
	white-space: nowrap;
	cursor: pointer;
}
	.ipsButton_secondary a { color: #616161; }
	.ipsButton_secondary:hover,
	.bbc_spoiler_show:hover,
	.user_controls li a:hover{
		color: #4c4c4c;
		background-color: #f8f8f8;
	}
	
	.ipsButton_secondary.important {
		background: #ae3232 url('{style_images_url}/highlight_faint.png') repeat-x 0 0;
		border: 0px solid #a22c2c;
		color: #fbf4f4;
		text-shadow: rgba(0,0,0,0.2) 0px -1px 0px;
		-webkit-box-shadow: none;
		-moz-box-shadow: none;
		box-shadow: none;
	}
		.ipsButton_secondary.important a { color: #fbf4f4; }
		.ipsButton_secondary.important a:hover,
		a.ipsButton_secondary.important:hover{ 
			color: #fff;
			background-color: #bb3c3c;
		}

		.ipsButton_secondary:active{
			-webkit-box-shadow: inset rgba(0,0,0,0.15) 0px 1px 2px, rgba(255,255,255,0.5) 0px 1px 0px;
			-moz-box-shadow: inset rgba(0,0,0,0.15) 0px 1px 2px, rgba(255,255,255,0.5) 0px 1px 0px;
			box-shadow: inset rgba(0,0,0,0.15) 0px 1px 2px, rgba(255,255,255,0.5) 0px 1px 0px;
			position: relative;
			top: 1px;
		}		

        .ipsButton_secondary .icon {
            margin-right: 4px;
            margin-top: -3px;
        }
        
        .ipsButton_secondary img.small {
            max-height: 12px;
            margin-left: 3px;
            margin-top: -2px;
            opacity: 0.5;
        }

.ipsButton_secondary img{ vertical-align: middle; margin-top: -1px; }

/* Used in post forms */
.ipsField.ipsField_checkbox.ipsButton_secondary { line-height: 18px; }
.ipsField.ipsField_checkbox.ipsButton_secondary input { margin-top: 6px }
.ipsField.ipsField_checkbox.ipsButton_secondary .ipsField_content { margin-left: 18px; }

.ipsButton_extra {
    line-height: 22px;
    height: 22px;
    font-size: 11px;
    margin-left: 5px;
    color: #5c5c5c;
}

.ipsButton_secondary.fixed_width{ min-width: 170px; }

.ipsButton.no_width { min-width: 0; }
.topic_controls { min-height: 30px; overflow: hidden; }

ul.post_controls {
	margin: 0;
	background: #fbfbfb url("{style_images_url}/transw90.png") repeat;
	background: url("{style_images_url}/highlight.png") repeat-x 0 0, url("{style_images_url}/transw90.png") repeat;
	border-top: 0px solid #ddd;
	border-top: 0px solid rgba(0,0,0,0.1);
	margin-top: 10px;
	padding: 7px;
	clear: both;
	overflow: hidden;
}

		ul.post_controls li {
			font-size: 11px;
			float: right;
			margin: 0;
			padding: 0;
		}
		
		ul.post_controls li.report, ul.post_controls li.top{ float: left; }

		ul.post_controls a {	
			color: #f0f0f0;
			text-shadow: rgba(0,0,0,0.5) 0px -1px 0px;
			background: #444444 url('{style_images_url}/highlight_faint.png') repeat-x 0 1px;
			-webkit-border-radius: 0px;
			-moz-border-radius: 0px;
			border-radius: 0px;
			height: 26px;
			line-height: 26px;
			padding: 0 10px;
			text-decoration: none;
			margin-left: 4px;
			display: block;
		}

		ul.post_controls a:hover {
			opacity: 0.8;
			color: #fff;
		}
		
		ul.post_controls a.ipsButton_secondary {
			height: 24px;
			line-height: 24px;
		}
		
		ul.post_controls li.multiquote.selected a { 
			background: #222 url('{style_images_url}/highlight_faint.png') repeat-x 0 1px !important;
			color: #fff;
		}
		
/*.post_block .post_controls li a { opacity: 0.2; }
.post_block .post_controls li a.ipsButton_secondary { opacity: 1; }
.post_block:hover .post_controls li a { opacity: 1; }*/

.post_body ul.post_controls{ margin: 0 -12px -12px -187px; }
.column_view .post_body ul.post_controls{ margin-left: -188px; }
.post_block.no_sidebar .post_body ul.post_controls{ margin-left: 0px; }
.post_body ul.post_controls img{ vertical-align: middle; margin: -3px 2px 0px -3px; position: relative; }

.hide_signature, .sigIconStay { float: right; }
.post_block:hover .signature a.hide_signature, .sigIconStay {
	background: transparent url('{style_images_url}/cross_sml.png') no-repeat top right;
	width: 13px;
	height: 13px;
	opacity: 0.6;
	position: absolute;
	right: 10px;
}

/************************************************************************/
/* PAGINATION STYLES */

.pagination { padding: 5px 0; line-height: 22px; }
.pagination.no_numbers .page { display: none; }
.pagination .pages { text-align: center; }
.pagination .back { margin-right: 5px; }
/*.pagination .back li { margin: 0 2px 0 0; }*/
.pagination .forward { margin-left: 5px; }
/*.pagination .forward li { margin: 0 0 0 2px; }*/

.pagination a{ color: #747474; }

.pagination .page a,
.pagination .back a,
.pagination .forward a {
	background: #333 url('{style_images_url}/transw40.png') repeat;
	background: url('{style_images_url}/transw40.png') repeat, url('{style_images_url}/highlight_faint.png') repeat-x 0 1px;
	color: #fff;
	text-shadow: rgba(0,0,0,0.2) 0px -1px 0px;
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
	border-radius: 0px;
	-webkit-box-shadow: rgba(0,0,0,0.05) 0px 1px 2px;
	-moz-box-shadow: rgba(0,0,0,0.05) 0px 1px 2px;
	box-shadow: rgba(0,0,0,0.05) 0px 1px 2px;
	display: inline-block;
	padding: 1px 8px;
	text-transform: lowercase;
	font-size: 11px;
	font-weight: normal;
}
	
	.pagination .page a:hover,
	.pagination .back a:hover,
	.pagination .forward a:hover {
		/*background-color: #efefef;*/
		color: #fff;
	}

	.pagination .disabled a {
		opacity: 0.4;
		display: none;
	}
	
.pagination .pages {
	font-size: 11px;
}

	.pagination .pages a,
	.pagejump {
		display: inline-block;
	}
	
	.pagination .pagejump a { padding: 0px 7px; }
	
	.pagination .pagejump a:hover {
		text-decoration: underline;
	}
	
	.pagination li { margin: 0; }
		
	.pagination .pages li.active {
		background: #5c5c5c;
		color: #fff;
		-moz-border-radius: 0px;
		-webkit-border-radius: 0px;
		border-radius: 0px;
		-webkit-box-shadow: inset rgba(0,0,0,0.7) 0px 1px 3px, rgba(255,255,255,1) 0px 1px 0px;
		-moz-box-shadow: inset rgba(0,0,0,0.7) 0px 1px 3px, rgba(255,255,255,1) 0px 1px 0px;
		box-shadow: inset rgba(0,0,0,0.7) 0px 1px 3px, rgba(255,255,255,1) 0px 1px 0px;
		padding: 1px 8px;
		cursor: default;
	}
		
.pagination.no_pages span {
	color: #acacac;
	display: inline-block;
	line-height: 20px;
	height: 20px;
}

ul.mini_pagination {
	font-size: 0.8em;
	display: inline;
	margin-left: 7px;
}

	ul.mini_pagination li a {
		background: #5f5f5f;
		color: #fff;
		padding: 2px 6px;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius:0px;
	}
	
	ul.mini_pagination li a:hover {
		opacity: 0.8;
	}

	ul.mini_pagination li {
		display: inline;
		margin: 0px 1px 0px 0px;
	}

/************************************************************************/
/* MODERATION & FILTER STYLES */

.moderation_bar {
	text-align: right;
	padding: 8px 10px;
}

	.moderation_bar.with_action {
		background-image: url('{style_images_url}/topic_mod_arrow.png');
		background-repeat: no-repeat;
		background-position: right center;
		padding-right: 35px;
	}

/************************************************************************/
/* AUTHOR INFO (& RELATED) STYLES */

.column_view .post_wrap{
	background: #fbfbfb url("{style_images_url}/transw90.png") repeat;
	background: url("{style_images_url}/transw90.png") repeat, url("{style_images_url}/transw30.png") repeat;
}

.column_view .post_body{
	border-left: 1px solid transparent;
}

.author_info {
	width: 155px;
	float: left;
	font-size: 12px;
	text-align: center;
	padding: 10px 10px;
	line-height: 150%;
}
	
	.author_info .group_title {
		color: #5a5a5a;
		margin-top: 5px;
	}
	
	.author_info .member_title { margin-bottom: 5px; word-wrap: break-word; }
	.author_info .group_icon { margin-bottom: 3px; }
	
.custom_fields {
	color: #818181;
	margin-top: 8px;
}

.custom_fields .ft { 
	color: #505050;
	margin-right: 3px;
}

.custom_fields .fc {
    word-wrap: break-word;
}

.user_controls {
	text-align: center;
	margin: 6px 0;
}

	.user_controls li a {
		padding: 0 5px;
	}

/************************************************************************/
/* BOARD INDEX STYLES */

#board_index { position: relative; }
	#board_index.no_sidebar { padding-right: 0px; }
		#board_index.force_sidebar { padding-right: 280px; }
	
#toggle_sidebar {
	position: absolute;
	right: -5px;
	top: -12px;
	z-index: 8000;
	background: #333333;
	padding: 3px 7px;
	-webkit-border-radius: 0px;
	-moz-border-radius: 0px;
	border-radius: 0px;
	color: #fff;
	opacity: 0;
	-webkit-transition: all 0.4s ease-in-out;
	-moz-transition: all 0.4s ease-in-out;
}
	#index_stats:hover + #toggle_sidebar, #board_index.no_sidebar #toggle_sidebar { opacity: 0.1; }
	#toggle_sidebar:hover { opacity: 1 !important; }
	
.ipsSideBlock,
.general_box{
	background: #fff;
	border: 1px solid #bfbfbf;
	margin-bottom: 10px;
	-webkit-box-shadow: rgba(0,0,0,0.06) 0px 1px 3px;
	-moz-box-shadow: rgba(0,0,0,0.06) 0px 1px 3px;
	box-shadow: rgba(0,0,0,0.06) 0px 1px 3px;
}

.ipsSideBlock{
	padding: 10px;
}
	
	.bar,
	.ipsSideBlock h3,
	.general_box h3{
		border-bottom: 1px solid #bfbfbf;
		border-bottom: 1px solid rgba(0,0,0,0.15);
		text-shadow: rgba(255,255,255,0.5) 0px 1px 0px;
		background: #333 url('{style_images_url}/transw90.png') repeat;
		-webkit-box-shadow: rgba(255,255,255,0.6) 0px 1px 0px inset;
		-moz-box-shadow: rgba(255,255,255,0.6) 0px 1px 0px inset;
		box-shadow: rgba(255,255,255,0.6) 0px 1px 0px inset;
		padding: 8px;
	}
	
	.bar{ border-top: 1px solid #bfbfbf; }
	
	.ipsPostForm_sidebar .ipsPostForm_sidebar_block:first-of-type h3.bar, .bar.noTopBorder{ border-top: 0; }
	
	.ipsSideBlock h3, .ipsSideBlock h3 a, .general_box h3, .general_box h3 a, .bar, .bar a{ color: #727272; }
	
	.ipsSideBlock h3{
		margin: -10px -10px 10px -10px;
	}
	
	.ipsSideBlock h3 .mod_links { 
		color: #fff;
		opacity: 0.0;
		display: inline-block;
		padding: 1px 4px 3px 4px;
		margin-top: -2px;
		text-shadow: none;
		background: url('{style_images_url}/trans40.png') repeat;
		background: rgba(0,0,0,0.4);
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		border-radius: 3px;
		-webkit-box-shadow: inset rgba(0,0,0,0.6) 0px 1px 2px;
		-moz-box-shadow: inset rgba(0,0,0,0.6) 0px 1px 2px;
		box-shadow: inset rgba(0,0,0,0.6) 0px 1px 2px;
	}
	.ipsSideBlock h3:hover .mod_links { opacity: 1; }

.sideVerticalList, #index_stats .ipsList_withminiphoto{ margin: -10px; }
#index_stats .ipsList_withminiphoto img{ margin-bottom: -3px; }
.sideVerticalList.with_margin{ margin-bottom: 10px; }

.status_list .status_list { margin: 10px 0 0 35px; }
.status_list p.index_status_update { line-height: 120%; margin:4px 0px; }
.status_list li { position: relative; }
.status_reply {
	margin-top: 8px;
}

.status_list li .mod_links { 
	opacity: 0.1;
	-webkit-transition: all 0.4s ease-in-out;
	-moz-transition: all 0.4s ease-in-out;
}
.status_list li:hover .mod_links { opacity: 1; }

/* board stats */
#board_stats ul { text-align: center; }
	#board_stats li { margin-right: 20px; }
	#board_stats .value {
		display: inline-block;
		background: url('{style_images_url}/transw30.png') repeat;
		color: #fff;
		text-shadow: rgba(0,0,0,0.3) 0px -1px 0px;
		padding: 3px 7px;
		font-weight: bold;
		-moz-border-radius: 0px;
		-webkit-border-radius: 0px;
		border-radius: 0px;
		margin-right: 3px;
		-webkit-box-shadow: inset rgba(0,0,0,0.3) 0px 1px 2px, rgba(255,255,255,1) 0px 1px 0px;
		-moz-box-shadow: inset rgba(0,0,0,0.3) 0px 1px 2px, rgba(255,255,255,1) 0px 1px 0px;
		box-shadow: inset rgba(0,0,0,0.3) 0px 1px 2px, rgba(255,255,255,1) 0px 1px 0px;
	}

.statistics {
	margin: 20px 0 0 0;
	padding: 8px;
	line-height: 1.3;
	overflow: hidden;
	border: 0px solid #bfbfbf;
	-webkit-box-shadow: rgba(0,0,0,0.06) 0px 1px 3px;
	-moz-box-shadow: rgba(0,0,0,0.06) 0px 1px 3px;
	box-shadow: rgba(0,0,0,0.06) 0px 1px 3px;
}

	.statistics_head {
		border-top: 1px solid #bfbfbf;
		border-bottom: 1px solid #bfbfbf;
		border-top: 1px solid rgba(0,0,0,0.15);
		border-bottom: 1px solid rgba(0,0,0,0.15);
		text-shadow: rgba(255,255,255,0.5) 0px 1px 0px;
		background: #333 url('{style_images_url}/transw90.png') repeat;
		-webkit-box-shadow: rgba(255,255,255,0.6) 0px 1px 0px inset;
		-moz-box-shadow: rgba(255,255,255,0.6) 0px 1px 0px inset;
		box-shadow: rgba(255,255,255,0.6) 0px 1px 0px inset;
		font-size: 11px;
		font-weight: bold;
		padding: 8px;
		margin: -8px -8px 8px -8px;
	}
	
	.statistics_head,
	.statistics_head a{
		color: #727272;
	}
	
	.statistics .statistics_head:first-of-type{
		border-top: 0;
	}
	
	.statistics .statistics_head:not(:first-of-type){
		margin-top: 0;
	}
	
#stat_links{ font-weight: normal; }
#stat_links a{ margin: 0 5px; }

.friend_list ul li,
#top_posters li {
	text-align: center;
	padding: 8px 0 0 0;
	margin: 5px 0 0 0;
	min-width: 80px;
	height: 80px;
	float: left;
}

	.friend_list ul li span.name,
	#top_posters li span.name {
		font-size: 0.95em;
	}
	
.friend_list ul li .ipsUserPhoto{ margin-bottom: 5px; }

#hook_watched_items ul li {
	padding: 8px;
}

	body#ipboard_body #hook_watched_items fieldset.submit {
		padding: 8px;
	}
	
#hook_birthdays .list_content {
	padding-top: 8px;
}

#hook_calendar .ipsBox_container { padding: 10px; }
#hook_calendar td, #hook_calendar th { text-align: center; }
#hook_calendar th { font-weight: bold; padding: 5px 0;}

/************************************************************************/
/* FORUM VIEW (& RELATED) STYLES */

#more_topics {
	text-align: center;
	font-weight: bold;
	background: url('{style_images_url}/trans10.png') repeat;
	background: rgba(0,0,0,0.05) url('{style_images_url}/highlight.png') repeat-x 0 0;
}
	#more_topics a, #more_topics span { display: block; padding: 10px 0;}
	#more_topics, .dynamic_update { border-top: 1px dashed #b3b3b3; }

.topic_preview,
ul.topic_moderation {
	margin-top: -2px;
	z-index: 300;
}
	ul.topic_moderation li {
		float: left;
	}
	
	.topic_preview a,
	ul.topic_moderation li a {
		padding: 0 3px;
		display: block;
		float: left;
	}

span.mini_rate {
	margin-right: 12px;
	display: inline-block;
}

img.mini_rate {
	margin-right: -5px;
}

/************************************************************************/
/* TOPIC VIEW (& RELATED) STYLES */

/* Post share pop-up */
#postShareUrl { width: 95%; font-size: 18px; color: #999; }
#postShareStrip { height: 35px; margin: 10px 0px 0px 30px; }

body .ip {  }
span.post_id { margin-left: 4px; }
input.post_mod { margin:12px 5px 0px 10px; }

.post_id a img.small {
    max-height: 12px;
    margin-left: 3px;
    margin-top: -2px;
    opacity: 0.5;
}

.signature {
	clear: right;
	color: #a4a4a4;
	font-size: 0.9em;
	border-top: 1px solid #f0f0f0;
	padding: 10px;
	margin: 6px 0 4px;
	position: relative;
}

	.signature a { text-decoration: underline; }
	
.post_body .signature{ margin-left: -12px; margin-right: -12px; }
	
.post_block {
	position: relative;
}

	.post_block.no_sidebar {
		background-image: none;
	}
	
	.post_block.solved h3,
	.answerBadgeInPost{
		background: #dfedd1;
		text-shadow: rgba(255,255,255,0.8) 0px 1px 0px;
		border: 1px solid #accf8b;
	}
	
	.post_block.solved h3,
	.post_block.solved h3 *,
	.answerBadgeInPost{
		color: #436500 !important;
	}
	
	.post_block.solved h3{
		background-image: -moz-linear-gradient(top, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0) 100%);
		background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0.3)), color-stop(100%,rgba(255,255,255,0)));
		background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.3) 0%,rgba(255,255,255,0) 100%);
		background-image: -o-linear-gradient(top, rgba(255,255,255,0.3) 0%,rgba(255,255,255,0) 100%);
		background-image: -ms-linear-gradient(top, rgba(255,255,255,0.3) 0%,rgba(255,255,255,0) 100%);
		background-image: linear-gradient(to bottom, rgba(255,255,255,0.3) 0%,rgba(255,255,255,0) 100%);
		-webkit-box-shadow: inset rgba(255,255,255,0.35) 0px 1px 0px;
		-moz-box-shadow: inset rgba(255,255,255,0.35) 0px 1px 0px;
		box-shadow: inset rgba(255,255,255,0.35) 0px 1px 0px;
		border-left: 0;
		border-right: 0;
	}

	.answerBadgeInPost{
		border-top: 0;
		padding: 0 12px;
		height: 30px;
		line-height: 30px;
		position: relative;
		float: right;
		margin: -13px -2px 8px 8px;
		-webkit-border-bottom-left-radius: 3px;
		-webkit-border-bottom-right-radius: 3px;
		-moz-border-radius: 0px 0px 3px 3px;
		border-radius: 0px 0px 3px 3px;
	}
	
	.post_block.feature_box {
		background-color: #dfedd1;
		background-image: -moz-linear-gradient(top, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
		background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0.2)), color-stop(100%,rgba(255,255,255,0)));
		background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.2) 0%,rgba(255,255,255,0) 100%);
		background-image: -o-linear-gradient(top, rgba(255,255,255,0.2) 0%,rgba(255,255,255,0) 100%);
		background-image: -ms-linear-gradient(top, rgba(255,255,255,0.2) 0%,rgba(255,255,255,0) 100%);
		background-image: linear-gradient(to bottom, rgba(255,255,255,0.2) 0%,rgba(255,255,255,0) 100%);
		-webkit-box-shadow: rgba(0,0,0,0.1) 0px 1px 5px;
		-moz-box-shadow: rgba(0,0,0,0.1) 0px 1px 5px;
		box-shadow: rgba(0,0,0,0.1) 0px 1px 5px;
		border: 1px solid #accf8b;
		padding: 8px;
		min-height: 60px;
		line-height: 180%;
		font-size: 11.4px;
		word-wrap: break-word;
	}
	
	.post_block.feature_box, .post_block.feature_box *{
		color: #3a6a16 !important;
	}
	
	.post_block.feature_box .ipsType_sectiontitle {
		border-color: #accf8b;
		font-size: 11.8px;
		font-weight: bold;
	}
	
	.post_block.feature_box .ipsBadge_green, .post_block.feature_box .ipsBadge_lightgrey{
		background: #9ac472;
		-webkit-box-shadow: inset rgba(0,0,0,0.2) 0px 1px 3px, rgba(255,255,255,0.7) 0px 1px 0px;
		-moz-box-shadow: inset rgba(0,0,0,0.2) 0px 1px 3px, rgba(255,255,255,0.7) 0px 1px 0px;
		box-shadow: inset rgba(0,0,0,0.2) 0px 1px 3px, rgba(255,255,255,0.7) 0px 1px 0px;
		text-shadow: rgba(255,255,255,0.3) 0px 1px 0px;
		color: #fff !important;
		text-shadow: rgba(0,0,0,0.2) 0px -1px 0px;
		padding: 3px 9px;
		font-size: 10px;
	}
	
	.post_block.feature_box .ipsBadge_lightgrey:hover{
		background: #7eb54b;
	}
	
	.post_block.feature_box .ipsUserPhoto{
		border-color: #accf8b !important;
	}
	
	.post_block h3 {
		border-top: 1px solid #a3a3a3;
		border-bottom: 1px solid #a3a3a3;
		border-top: 1px solid rgba(0,0,0,0.1);
		border-bottom: 1px solid rgba(0,0,0,0.1);
		text-shadow: rgba(255,255,255,0.4) 0px 1px 0px;
		background: url('{style_images_url}/transw70.png') repeat;
		background: url("{style_images_url}/highlight.png") repeat-x 0 0, url('{style_images_url}/transw70.png') repeat;
		padding: 0 10px;
		height: 36px;
		line-height: 36px;
		font-weight: normal;
		font-size: 13px;
	}
	
	.post_block h3,
	.post_block h3 a{
		color: #444;
	}
	
	.post_block:first-of-type h3{ border-top: 0; }

.post_online{
	vertical-align: middle;
	margin: -3px 5px 0 0;
}
	
.post_username{
	float: left;
	min-width: 177px;
	font-weight: bold;
}

.post_date{
	color: #444;
	float: left;
	font-size: 11px;
	font-weight: normal;
}
	
	.post_wrap { top: 0px; }	

.post_body {
	margin-left: 175px;
	padding: 12px;
}
	
	.post_body .post {
color: #80808;
		line-height: 1.6;
		font-size: 12px;
	}
	
	.column_view .post_body .post{ padding-bottom: 12px; }
	
	.post_block.no_sidebar .post_body { margin-left: 0px !important; }
	
.posted_info {
	padding: 0 0 10px 0;
}

	.posted_info strong.event {
		color: #1c2837;
		font-size: 1.2em;
	}

.post_ignore {	
	background: #f8f8f8;
	color: #777;
	font-size: 0.9em;
	padding: 15px;	
}

	.post_ignore .reputation {
		text-align: center;
		padding: 2px 6px;
		float: none;
		display: inline;
	}

.rep_bar {
	white-space: nowrap;
	margin: 6px 4px;
}

	.rep_bar .reputation {
		font-size: 10px;
		padding: 2px 10px !important;
	}
		
p.rep_highlight {
	float: right;
	display: inline-block;
	margin: 5px 10px 10px 10px;
	background: #D5DEE5;
	color: #1d3652;
	padding: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
	font-size: 0.8em;
	font-weight: bold;
	text-align: center;
}

	p.rep_highlight img {
		margin-bottom: 4px;
	}

.edit {
	padding: 8px 8px 8px 28px;
	background: #ffebc8 url('{style_images_url}/comment_edit.png') no-repeat 6px 10px;
	border: 1px solid #ecc272;
	color: #ac6328;
	text-shadow: #fffaf1 0px 1px 0px;
	font-size: 11px;
	margin-top: 15px;
	line-height: 18px;
}

.poll fieldset {
	padding: 9px;
}

.poll_question {

}

	.poll_question h4 {
		background: #ebebeb;
		padding: 5px;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}

	.poll_question ol {
		padding: 20px;
	}
	
	.poll_question li {
		font-size: 0.9em;
		margin: 6px 0;
	}
	
	.poll_question .votes {
		margin-left: 5px;
	}
	
.snapback { 
	margin-right: 5px;
	padding: 1px 0 1px 1px;
}

.rating { display: block; margin-bottom: 4px; line-height: 16px; } 
	.rating img { vertical-align: top; }
#rating_text { margin-left: 4px; }
	
/************************************************************************/
/* POSTING FORM (& RELATED) STYLES */

div.post_form label {
	text-align: right;
	padding-right: 15px;
	width: 275px;
	float: left;
	clear: both;
}

	div.post_form span.desc,
	fieldset#poll_wrap span.desc {
		margin-left: 290px;
		display: block;
		clear: both;
	}

	div.post_form .checkbox input.input_check,
	#mod_form .checkbox input.input_check {
		margin-left: 295px;
	}
	
	div.post_form .antispam_img {
		margin-left: 290px;
	}
	
	div.post_form .captcha .input_text {
		float: left;
	}
	
	div.post_form fieldset {
		padding-bottom: 15px;
	}

	div.post_form h3 {
		margin-bottom: 10px;
	}
	
fieldset.with_subhead {
	margin-bottom: 0;
	padding-bottom: 0;
}

	fieldset.with_subhead h4 {
		text-align: right;	
		margin-top: 6px;
		width: 300px;
		float: left;
	}

	fieldset.with_subhead ul {
		padding-top: 10px;
		padding-bottom: 10px;
		margin: 0 15px 0px 320px;
	}

	fieldset.with_subhead span.desc,
	fieldset.with_subhead label {
		margin: 0;
		width: auto;
	}

	fieldset.with_subhead .checkbox input.input_check {
		margin-left: 0px;
	}

#toggle_post_options {
	background: transparent url('{style_images_url}/add.png') no-repeat;
	font-size: 0.9em;
	padding: 2px 0 2px 22px;
	margin: 15px;
	display: block;
}

#poll_wrap .question {
	margin-bottom: 10px;
}

		#poll_wrap .question .wrap ol {
			margin-left: 25px; 
			list-style: decimal;
		}
			#poll_wrap .question .wrap ol li {
				margin: 5px;
			}
	
.question_title { margin-left: 30px; padding-bottom: 0; }
	.question_title .input_text { font-weight: bold }

#poll_wrap { position: relative; }
#poll_footer { }
#poll_container_wrap { overflow: auto; }
#poll_popup_inner { overflow: hidden; }

.poll_control { margin-left: 20px; }
.post_form .tag_field ul { margin-left: 290px; }

/************************************************************************/
/* ATTACHMENT MANAGER (& RELATED) STYLES */

.swfupload {
	position: absolute;
	z-index: 1;
}
	
#attachments { }

	#attachments li {
		background-color: #f1f1f1;
		text-shadow: rgba(255,255,255,0.7) 0px 1px 0px;
		border: 1px solid #dcdcdc;
		padding: 6px 20px 6px 42px;
		margin-bottom: 10px;
		position: relative;
		-webkit-box-shadow: inset rgba(0,0,0,0.1) 0px 1px 4px;
		-moz-box-shadow: inset rgba(0,0,0,0.1) 0px 1px 4px;
		box-shadow: inset rgba(0,0,0,0.1) 0px 1px 4px;
	}
	
		#attachments li p.info {
			font-size: 0.8em;
			width: 300px;
		}
	
		#attachments li .links, #attachments li.error .links, #attachments.traditional .progress_bar {
			display: none;
		}
			
			#attachments li.complete .links {
				font-size: 0.9em;
				margin-right: 15px;
				/*right: 0px;
				top: 12px;*/
				display: block;
				/*position: absolute;*/
			}
			
		#attachments li .progress_bar {
			margin-right: 15px;
			width: 200px;
			/*right: 0px;
			top: 15px;
			position: absolute;*/
		}
	
		#attachments li.complete, #attachments li.in_progress, #attachments li.error {
			background-repeat: no-repeat;
			background-position: 12px 12px;
		}
	
		#attachments li.in_progress {
			background-image: url('{style_images_url}/loading.gif');
		}
	
		#attachments li.error {
			background-image: url('{style_images_url}/exclamation.png');
			background-color: #e8caca;
			border: 1px solid #ddafaf;
		}
		
			#attachments li.error .info {
				color: #8f2d2d;
			}
	
		#attachments li.complete {
			background-image: url('{style_images_url}/accept.png');
		}
		
		#attachments li .thumb_img {
			left: 6px;
			top: 6px;
			width: 30px;
			height: 30px;
			overflow: hidden;
			position: absolute;
		}
		
.attach_controls {
	background: url('{style_images_url}/icon_attach.png') no-repeat 3px top;
	padding-left: 30px;
	min-height: 82px;
}

	.attach_controls .ipsType_subtitle { margin-bottom: 5px; }
	.attach_controls iframe { display: block; margin-bottom: 5px; }
	
.attach_button { font-weight: bold;  }
#help_msg {	margin-top: 8px; }

#attach_wrap {
	margin-top: 10px;
	overflow: hidden;
}

	#attach_wrap h4 {
		font-size: 16px; padding-left: 0px;
	}
	
	#attach_wrap li {
		margin: 5px 0;
		float: left;
	}

	#attach_wrap .attachment {
		float: none;
	}
		
		#attach_wrap .desc.info {
			margin-left: 24px;
		}

#attach_error_box {	margin-bottom: 10px; }

.resized_img {
	margin: 0 5px 5px 0;
	display: inline-block;
}

/************************************************************************/
/* REPUTATION STYLES */

.reputation {
	font-weight: bold;
	padding: 3px 8px;
	display: inline-block;
	-moz-border-radius: 0px;
	-webkit-border-radius: 0px;
	border-radius: 0px;
	text-shadow: rgba(0,0,0,0.3) 0px -1px 0px;
}
	
	.reputation.positive, .members li.positive {
		background: #8db13e url('{style_images_url}/highlight_faint.png') repeat-x 0 1px;
	}
	
	.reputation.negative, .members li.negative {
		background: #b82929 url('{style_images_url}/highlight_faint.png') repeat-x 0 1px;
	}
	
	.reputation.positive, .reputation.negative {
		color: #fff;
	}
	
	.reputation.zero {
		background: #6a6a6a url('{style_images_url}/highlight_faint.png') repeat-x 0 1px;
		color: #fff;
	}

.status_main_content { white-space: break-word; }

.status_main_content h4 {
	font-weight:normal;
	font-size:1.2em;
}

.status_main_content h4 .su_links a { font-weight: normal; }

.status_main_content p {
	padding: 6px 0px 6px 0px;
}

.status_main_content h4 a {
	font-weight:bold;
	text-decoration: none;
}

.status_mini_wrap {
	padding: 7px;
	font-size: 0.95em;
	margin-top: 2px;
	background: rgba(0,0,0,0.04);
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
.status_mini_wrap img{ vertical-align: middle; position: relative; margin-top: -2px; }

.status_mini_photo {
	float: left;
}

.status_textarea {
	width: 99%;
}

#index_stats .status_textarea{
	width: 180px;
}

.status_replies_many {
	height: 300px;
	overflow: auto;
}
	
.status_update {
	background: #8a8a8a url('{style_images_url}/highlight_faint.png') repeat-x 0 0;
	color: #fff;
	text-shadow: rgba(0,0,0,0.3) 0px -1px 0px;
	padding: 15px 12px;
	text-align: center;
}

	.status_update .input_text { 
		width: 70%;
		background: #e0e0e0;
		color: #363636;
		text-shadow: rgba(255,255,255,0.8) 0px 1px 0px;
		border: 1px solid #5e5e5e;
		-webkit-box-shadow: rgba(0,0,0,0.1) 0px 1px 3px;
		-moz-box-shadow: rgba(0,0,0,0.1) 0px 1px 3px;
		box-shadow: rgba(0,0,0,0.1) 0px 1px 3px;
	}
	
	.status_update .input_submit{ padding-left: 15px; padding-right: 15px; }
	.status_submit{ padding-top: 5px; }
	/*.status_update .status_inactive { color: #bbbbbb; }*/
	#status_wrapper h4 { font-weight: bold; font-size: 14px; }
	.status_content { line-height: 1.4; }
	.status_content .mod_links { opacity: 0.2; }
	.status_content:hover .mod_links { opacity: 1; }
	.status_content .h4, .status_content .status_status { font-size: 14px; word-wrap: break-word; }
	.status_content .status_status{ padding: 2px 0 5px 0; }
	.status_feedback .status_mini_content{ line-height: 18px; }
	.status_feedback { margin: 10px 0 0 -10px; }
	/*.status_feedback .row2 { margin-bottom: 1px; }*/

/* Favorites */
.ips_like {
	background-color: #f6f6f6;
	padding: 6px;
	color: #878787;
	font-size: 1em;
	min-height: 18px;
	line-height: 130%;
	clear: both;
	overflow: hidden;
}
.ips_like a {
	color: #878787;
}

.ips_like a.ftoggle {
	float: right;
	background: #878787;
	border:1px solid #747474;
	padding: 3px 4px 2px 4px;
	color: #fff;
	text-shadow: rgba(0,0,0,0.2) 0px -1px 0px;
	font-size:0.9em;
	text-decoration: none;
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px;
	border-radius: 2px;
	margin-top: -4px;
}

.ips_like a.ftoggle.on {
	background: #545454;
	border-color: #474747;
	margin-left: 3px;
}

.ips_like a.ftoggle._newline,
.ips_like a.ftoggle.on._newline {
	float:none;
	margin-top: 5px;
	margin-left: auto;
	margin-right: 0;
	display: block;
	width: 70px;
	text-align: center;
}

.ips_like a:hover.ftoggle.on,
.ips_like a:hover.ftoggle {
	background-color: #545454;
}

.facebook-like { margin-top: 5px; }

.boxShadow {
	-webkit-box-shadow: rgba(0,0,0,0.1) 0px 1px 5px;
	-moz-box-shadow: rgba(0,0,0,0.1) 0px 1px 5px;
	box-shadow: rgba(0,0,0,0.1) 0px 1px 5px;
}

/* New notification panel */
#ipsGlobalNotification {
	position: fixed;
	left: 50%;
	margin-left: -250px;
	top: 20px;
	text-align: center;
	font-weight: bold;
	z-index: 10000;
}

#ips_NotificationCloseButton {
	background: transparent url('{style_images_url}/close_popup.png') no-repeat top left;
	opacity: 0.8;
	width: 13px;
	height: 13px;
	top: 5px;
	left: 5px;
	position: absolute;
	cursor: pointer;
}

.googlePlusOne {
	display: inline-block;
	vertical-align:middle;
	margin-top: 1px;
}

.fbLike {
	float: right !important;
	padding-left: 2px;
	max-height: 50px;
	overflow: hidden;
}

/************************************************************************/
/* SHARED MEDIA STYLES */

#mymedia_inserted {
	position: absolute;
	top: 100px; left: 50%;
	margin-left: -200px;
	width: 400px;
	padding: 20px 0;
	background: #000;
	font-size: 15px;
	font-weight: bold;
	color: #fff;
	z-index: 20000;
	text-align: center;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
}

#mymedia_toolbar { 
	position: absolute;
	bottom: 0; left: 0;	right: 0;
	height: 42px;
	line-height: 42px;
	padding: 0 5px;
	background: #dcdcdc url('{style_images_url}/highlight.png') repeat-x 0 1px;
}

#mymedia_finish { position: absolute; right: 5px; top: 5px; }
#mymedia_content { height: 339px; overflow: auto; }

.media_results li.result {
	width: 20%;
	height: 120px;
	padding: 10px 0;
	float: left;
	text-align: center;
	cursor: pointer;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
}

	.media_results li:hover { 
		background: #F9F9F9;
		background: -moz-linear-gradient(top, #F9F9F9 0%, #EDEDED 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#F9F9F9), color-stop(100%,#EDEDED));
	}
	.media_results li:active { 
		background: #EDEDED;
		background: -moz-linear-gradient(top, #EDEDED 0%, #F9F9F9 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#EDEDED), color-stop(100%,#F9F9F9));
	}
	
	.media_image {
		padding: 1px;
		background: #fff;
		border: 1px solid #d5d5d5;
		margin-bottom: 5px;
		-webkit-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
		-moz-box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
		box-shadow: 0px 2px 2px rgba(0,0,0,0.1);
	}

/********************************************************/
/* Template Error                                        */    

.templateError {
    background: #ffffff !important;
    color: #000000 !important;
    padding: 10px !important;
    border: 1px dotted black !important;
    margin: 0px !important;
}

/********************************************************/
/* ModCP styles											*/

.modcp_post_controls { padding-bottom: 15px; }
.modcp_post_controls .ipsButton_secondary { opacity: 0.7; }
.post_body:hover .modcp_post_controls .ipsButton_secondary { opacity: 1; }

#modcp_content .ipsFilterbar li.active a {
	margin-bottom: 1px;
	display: inline-block;
}

/********************************************************/
/* Advertisements from Nexus							*/

.nexusad { padding: 10px; clear: both; }

#bbcode-description {
	color: #666 !important;
	white-space: normal !important;
	word-wrap: break-word;
}

/********************************************************/
/* iPad Specific									*/
@media only screen and (device-width: 768px) {
	table.ipb_table .expander,
	table.ipb_table .ipsModMenu { visibility: visible; opacity: 0.2; }
	.post_block .post_controls { opacity: 1 !important;	}
}

.fb-like{
	height: 20px;
	overflow: hidden;
}

/* Additional */

#stats_div{
	height: 0px;
	overflow: hidden;
}

.skin_link{	float: left; padding-top: 4px; }
.skin_link, .skin_link a{ color: #666 !important; }
.skin_link a:hover{ text-decoration: underline; }

.negMargin{ margin: -9px; }
.negMarginTop{ margin-top: -9px; }
.negMarginRight{ margin-right: -9px; }
.negMarginBottom{ margin-bottom: -9px; }
.negMarginLeft{ margin-left: -9px; }
.input_submit, .ipsButton_secondary{ outline: none; }
#rss_feed{ margin-top: -1px; }
#index_stats .status_submit .input_submit{ font-size: 11px; }
div[id$="member_popup"] .general_box{ margin: 0; border: 0; }
#ipsNav_content a{ display: block; padding: 5px 10px; }
#ipsNav_content li{ padding: 0; }
.ipsList_withminiphoto.ipsPad_half{ padding: 0 !important; } /* Fix downloads sidebar padding */
.ipsList_withminiphoto > li { overflow: hidden; }
.status_list li{ margin-top: 10px; } /* Fix status updates on idx */
.fullList{ margin: -9px; } /* Must be the same as ipsPad */
#usercp_content .ipsType_subtitle{ margin-bottom: 10px; padding-bottom: 6px; padding-top: 3px; }
#modCpanel .ipsType_subtitle{ padding-top: 4px; padding-bottom: 5px; }
.col_f_icon span { margin-bottom: 6px; margin-top: 2px; } 
.idx_album_thumb img{ width: 32px; height: 32px; }
.idx_album_thumb img, .inlineimage img, #appGallLatestHook img{ 
	-webkit-border-radius: 3px;
	border-radius: 3px;
	-webkit-box-shadow: rgba(0,0,0,0.2) 0px 1px 2px;
	-moz-box-shadow: rgba(0,0,0,0.2) 0px 1px 2px;
	box-shadow: rgba(0,0,0,0.2) 0px 1px 2px;
}
.inlineimage img:hover, #appGallLatestHook img:hover{ opacity: 0.9; }
.topic_desc{ display: inline-block; padding-top: 3px; }

.sb_login h4{
	padding: 10px;
	font-weight: bold;
	font-size: 15px;
	background: rgba(0,0,0,0.05) url('{style_images_url}/highlight.png') repeat-x 0 0;
	border-bottom: 1px solid #ccc;
}

.sb_login .ipsForm_submit{ margin-top: 0; }
.sb_login .ipsBox_notice{ margin: 0; }
.sb_login_col{ float: left; width: 279px; padding: 15px 10px; }
.sb_login_col a:hover{ text-decoration: underline; }
.sb_login_row{ overflow: hidden; }
.sb_login_row label{ font-size: 1.15em; }
.sb_login .input_submit{ font-size: 13px; }

.sb_login_input {
	padding: 6px 0px 6px 28px;
	font-size: 14px;
	margin-top: 10px;
	width: 250px;
}

.sb_luser{ background-image: url("{style_images_url}/user.png"); background-repeat: no-repeat; background-position: 7px 50%; }
.sb_lpassword{ background-image: url("{style_images_url}/key.png"); background-repeat: no-repeat; background-position: 7px 50%; }

.sb_titlebox .desc{ padding: 3px 0; }

.sb_titlebox{
	/*background: #efefef;
	border: 1px solid #d6d6d6;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	border-radius: 3px;
	-webkit-box-shadow: inset rgba(0,0,0,0.1) 0px 1px 4px;
	-moz-box-shadow: inset rgba(0,0,0,0.1) 0px 1px 4px;
	box-shadow: inset rgba(0,0,0,0.1) 0px 1px 4px;
	padding: 10px;*/
	text-shadow: #fff 0px 1px 0px;
	overflow: hidden;
}

.content_border{
	border: 1px solid #ddd;
	-webkit-box-shadow: rgba(0,0,0,0.1) 0px 1px 4px;
	-moz-box-shadow: rgba(0,0,0,0.1) 0px 1px 4px;
	box-shadow: rgba(0,0,0,0.1) 0px 1px 4px;
}

.col_c_stats ul{ border-right: 1px solid rgba(0,0,0,0.1); padding-right: 10px; margin-right: -8px; }

/* Skin by www.skinbox.net */]]></css_content>
    <css_position>1</css_position>
    <css_app>core</css_app>
    <css_app_hide>0</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules/>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426452</css_updated>
    <css_group>ipb_ucp</css_group>
    <css_content>/************************************************************************/
/* IP.Board 3 CSS - By Rikki Tissier - (c)2008 Invision Power Services	*/
/************************************************************************/
/* ipb_ucp.css - UserCP styles											*/
/************************************************************************/

#usercp_content { min-height: 420px; }
#fbUserBox p.desc { left: 0px; }

.ipsSettings_section .custom .wrap { display: block; padding: 8px 0 8px 15px; }
	.ipsSettings_section .custom .wrap span.f { margin-right: 10px; }

.notify_icon {
	width: 12px;
	height: 12px;
	display: inline-block;
	vertical-align: middle;
	margin-right: 3px;
	background: url({style_images_url}/icon_notify_types.png ) no-repeat;
}

.notification_table td .notify_icon { visibility: hidden; }
.notification_table tr:hover td .notify_icon { visibility: visible; }

	.notify_icon.inline { background-position: left; }
	.notify_icon.mobile { background-position: center; }
	.notify_icon.email { background-position: right; }


div.avatar_gallery {	
	text-align: center;
	margin-top: 15px;
	width: 20%;
	float: left;
}

	div.avatar_gallery input,
	div.avatar_gallery label {
		margin-top: 10px;
		display: inline-block;
	}
	
/* Notify styles */
#usercp_content .notification_table td.notify_title {
	font-size: 0.9em;
	padding-left: 15px;
}

#usercp_content .notification_table td {
	
}</css_content>
    <css_position>1</css_position>
    <css_app>core</css_app>
    <css_app_hide>1</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules>usercp</css_modules>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426452</css_updated>
    <css_group>skinbox</css_group>
    <css_content><![CDATA[/************************************************************************/
/* Custom dropdown menu */

[data-dropdown] ul {
	background-color: #fff;
	width: 175px;
	padding: 0 !important;
	border: 1px solid #acacac;
	-moz-box-shadow: 0 0 6px rgba(0,0,0,0.25);
	-webkit-box-shadow: 0 0 6px rgba(0,0,0,0.25);
	box-shadow: 0 0 6px rgba(0,0,0,0.25);
}

	[data-dropdown] ul li {
		font-size: 0.9em !important;
		padding: 0;
		margin: 0;
		width: 100% !important;
		border-bottom: 1px solid #dedede;
	}

		[data-dropdown] ul li a {
			display: block;
			padding: 4px 6px !important;
			line-height: 160% !important;
			margin: 0;
			color: #505050 !important;
			text-shadow: none !important;
			-webkit-border-radius: 0 !important;
			-moz-border-radius: 0 !important;
			-o-border-radius: 0 !important;
			-ms-border-radius: 0 !important;
			-khtml-border-radius: 0 !important;
			border-radius: 0 !important;
		}
			[data-dropdown] ul li a:hover {
				background: #ededed !important;
				color: #000 !important;
			}
			[data-dropdown] ul li a:active {
				box-shadow: none !important;
			}

.branding_skin {	
	padding: 12px;
	text-align: left;
	clear: both;
	overflow: hidden;
}

	.branding_skin a {
		color: #000;
		text-decoration: none;
	}

	.branding_skin a:hover {
		color: #000;
		text-decoration: underline;
	}

.branding_logo {
	float: right;
	opacity: 0.7;
	margin-top: -2px;
}

	.branding_logo:hover {
		opacity: 1;
	}

	.branding_logo:active {
		opacity: 0.7;
	}

/* No Flickering */
[data-dropdown] ul, [data-box], [data-dombox], [data-store], [data-domballoon], [data-balloon] { display: none;}

/* Dropdown Menu */
[data-dropdown] { position: relative; }

/* Submenu */
[data-dropdown] ul {
	width: 200px;
	position: absolute;
	z-index: 10000;
}

[data-dropdown~=right] ul {
	right: 0;
}

/** Color picker **/

#nav_colorpicker ul {
	width: 215px;
}
	#nav_colorpicker ul li {
		padding: 10px 0 10px 10px;
		border: 0;
	}

#nav_colorpicker input {
	border: 0;
	margin: 8px 0;
	padding: 5px 8px;
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px;
	-o-border-radius: 2px;
	-ms-border-radius: 2px;
	-khtml-border-radius: 2px;
	border-radius: 2px;
	-moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.6);
	-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.6);
	box-shadow: inset 0 1px 1px rgba(0,0,0,0.6);
}

#nav_colorpicker ul a{
padding: 0 !important;
background: none transparent !important;
width: auto !important;
line-height: 16px !important;
}

.farbtastic { position: relative; }
.farbtastic * { position:absolute; cursor:crosshair; }
.farbtastic, .farbtastic .wheel { width:195px; height:195px; } 
.farbtastic .color, .farbtastic .overlay { top:47px; left:47px; width:101px; height:101px; } 
.farbtastic .wheel { background: url({style_images_url}/wheel.png) no-repeat; width:195px; height:195px } 
.farbtastic .overlay { background:url({style_images_url}/mask.png) no-repeat; }
.farbtastic .marker { width:17px; height:17px; margin: -8px 0 0 -8px; overflow:hidden; background:url({style_images_url}/marker.png) no-repeat } 
[data-target-color] span { width:12px; height:12px; display:inline-block; vertical-align: top; margin: 2px 2px 0 0; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px; }]]></css_content>
    <css_position>0</css_position>
    <css_app>core</css_app>
    <css_app_hide>0</css_app_hide>
    <css_attributes/>
    <css_modules/>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
</css>

--------------------------------------------------------------------------------
> Time: 1415628377 / Mon, 10 Nov 2014 14:06:17 +0000
> URL: /admin/index.php?adsess=c56f5ccb0e1ea9a55889b95d84a98c87&app=core&&module=templates&section=importexport&do=exportSet
> CSS Export: forums

--------------------------------------------------------------------------------
> Time: 1415628377 / Mon, 10 Nov 2014 14:06:17 +0000
> URL: /admin/index.php?adsess=c56f5ccb0e1ea9a55889b95d84a98c87&app=core&&module=templates&section=importexport&do=exportSet
> CSS Export: members
<?xml version="1.0" encoding="utf-8"?>
<css>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426453</css_updated>
    <css_group>ipb_messenger</css_group>
    <css_content><![CDATA[/************************************************************************/
/* IP.Board 3 CSS - By Rikki Tissier - (c)2008 Invision Power Services	*/
/************************************************************************/
/* ipb_messenger.css - Messenger styles									*/
/************************************************************************/

#messenger_utilities { width: 19%; }	

#messenger_content { width: 80%; }

	#messenger_content h2 {
		clear: none;
		font-size: 1.4em;
	}

#folder_list, #space_allowance,
#message_search, #participants,
#invite_more {
	position: relative;
}

#space_allowance p { line-height: 150%;}
#message_list {	clear: right; }
#message_compose .input_check {	margin-left: 245px;}
#invite_more_dialogue { display: none;}
#invite_more_dialogue ul { padding: 4px;}
#invite_more_autocomplete {	width: 99%; }

#folder_list #folders li {
	margin-bottom: 8px;
	padding: 2px;
	position: relative;
}

	#folder_list #folders img {
		margin-right: 5px;
	}

	#folder_list .total {
		background: #efefef url('{style_images_url}/highlight.png') repeat-x 0 1px;
		font-size: 0.75em;
		font-weight: bold;
		padding: 3px 6px;
		right: 0; top: 1px;
		position: absolute;
	}

	#participants #participants_list span.name.left_convo a {
		color: #8a8a8a;
		font-style: italic;
	}

	#participants #participants_list span.name.blocked a {
		color: #ad2930;
	}

#space_allowance {
	clear: both;
}

li.new_folder {
	padding-left: 20px;
}

.add_folder.input_submit {
	padding: 1px 3px;
}

.edit_folders {
	background: #efefef;
	font-size: 0.8em;
	font-weight: bold;
	margin-right: 2px;
	padding: 2px;
	right: 3px;
	position: absolute;
}

	.f_delete {
		color: #f00;
	}
	
.col_m_subject {
	width:40%;
}

.ipsSideBlock .post_controls{ margin: 10px -10px -10px -10px; }
#folder_list.ipsSideBlock .post_controls{ margin: 10px -5px -5px -5px; }]]></css_content>
    <css_position>1</css_position>
    <css_app>members</css_app>
    <css_app_hide>1</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules>messaging</css_modules>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426453</css_updated>
    <css_group>ipb_mlist</css_group>
    <css_content><![CDATA[/************************************************************************/
/* IP.Board 3 CSS - By Rikki Tissier - (c)2008 Invision Power Services	*/
/************************************************************************/
/* ipb_mlist.css - Member list styles									*/
/************************************************************************/

#mlist_tabs { margin-top: 5px; }
	#mlist_tabs li { text-align: center; }
		#mlist_tabs li a { padding: 5px 8px; }

div#member_filters {
	margin-top: 10px;
	margin-bottom: 15px;
}
	
	div#member_filters fieldset.other_filters {
		text-align: center;
		padding: 9px;
		margin-top: 10px;
		clear: both;
	}
	
	div#member_filters fieldset.submit {
		padding: 6px;
	}
	
	div#member_filters ul {
		margin-bottom: 12px;
		margin-top: 8px;
		width: 49%;
		float: left;
	}
	
	div#member_filters li {
		margin-right: 20px;
		padding: 8px 0 8px 0;
		clear: both;
	}
	
		div#member_filters li .desc {
			margin: 0;
			display: inline;
		}
	
	div#member_filters label {	
		text-align: right;
		margin-right: 15px;
		width: 150px;
		display: block;
		float: left;
		line-height: 26px;
	}
	
	div#member_filters li.field.custom input[type=text],
	div#member_filters li.field.custom textarea {
		width: 50%;
	}
	
div#member_filters li.field.custom .input_check {
	width: 5%;
}]]></css_content>
    <css_position>1</css_position>
    <css_app>members</css_app>
    <css_app_hide>1</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules/>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426453</css_updated>
    <css_group>ipb_photo_editor</css_group>
    <css_content>/************************************************************************/
/* IP.Board 3 CSS - By Matt Mecham - (c)2011 Invision Power Services	*/
/************************************************************************/
/* ipb_photo_editor.css - Photo editor styles							*/
/************************************************************************/

/* New photo stuffs */
#ips_photoWrap {
	width: 600px;
	border: 1px solid #d3d3d3;
	margin: 0px auto;
	padding: 6px;
}

#ips_sidePanel {
	float: left;
	width: 200px;
}

#ips_cropperStart, #ips_cropperControls {
	
	text-align: right;
	width: 200px;
	margin-top: 8px;
}

#ips_currentPhoto {
	
	text-align: center;
}
	#ips_currentPhoto img {
		border: 0; padding: 0;
		background: none transparent;
	}

#gravatar, #upload_photo {
	width: 150px;
}

#ips_photoOptions {
	margin-left: 210px;
}

li.ips_option {
	border: 1px solid #d3d3d3;
	min-height: 120px;
	margin-bottom: 5px;
}

.ips_photoPreview {
	width: 100px;
	height: 100px;
	display: block;
	overflow: hidden;
	margin: 6px;
	float: left;
	border: 1px solid #d3d3d3;
	
}

	.ips_photoPreview label {
		text-align: center;
		background: white;
	}
	
	.ips_photoPreview label img {
		max-width:120px; 
		max-height:120px; 
	}

.ips_photoControls {
	padding-top: 10px;
	margin-left: 120px;
}

.ips_photoOptionText {
	margin-left: 18px;
}

.imgCrop_wrap { display: inline-block; }</css_content>
    <css_position>1</css_position>
    <css_app>members</css_app>
    <css_app_hide>1</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules>photo</css_modules>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
  <cssfile>
    <css_set_id>5</css_set_id>
    <css_updated>1415426453</css_updated>
    <css_group>ipb_profile</css_group>
    <css_content><![CDATA[/************************************************************************/
/* IP.Board 3 CSS - By Rikki Tissier - (c)2008 Invision Power Services	*/
/************************************************************************/
/* ipb_profile.css - Profile specific styles							*/
/************************************************************************/

#profile_photo { max-width: 138px; max-height: 138px; }
#profile_content_main {
	min-height: 75px;
	line-height: 1.3;
	margin-bottom: 20px;
}
#pane_info .ipsLayout_right { width: 260px !important; margin-right: -290px; }
#friends_overview .ipsUserPhoto_link { margin: 0 2px 5px 2px; display: inline-block; }

#profile_content_main h1.ipsType_pagetitle{ border: 0; }

#profile_panes_wrap .reputation {
	float: none;
	margin: 0 0 5px 0;
	padding: 10px;
	text-align: center;
	font-weight: normal;
	display: block;
}
	#profile_panes_wrap .reputation .number {
		font-size: 20px;
		font-weight: bold;
		display: block;
	}

.warn_panel { text-align: center; margin: 8px 0; }
.photo_holder { position: relative; }
#change_photo { 
	position: absolute;
	top: 0; left: 0;
	background: rgba(0,0,0,0.2);
	color: #fff;
	opacity: 0.3;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	-webkit-transition: all 0.4s ease-in-out;
	-moz-transition: all 0.4s ease-in-out;
}
	.photo_holder:hover #change_photo {
		opacity: 1;
		background: #000;
	}
	
#user_info_cell {
	display: table-cell;
	white-space: nowrap;
	padding-right: 15px;
	line-height: 20px;
}
#user_status_cell {
	display: table-cell;
	width: 100%;
	vertical-align: top;
}
#user_latest_status {
	position: relative;
	padding-left: 11px;
}
#user_latest_status .status_arrow{
	position: absolute;
	left: 0px;
	top: 50%;
	margin-top: -12px;
	height: 0;
	width: 0;
	display: block;
	border-width: 11px 11px 11px 0px;
	border-color: transparent #ebebeb transparent transparent;
	border-style: solid;
}
#user_latest_status > div {
	padding: 10px 15px;
	background-color: #ebebeb;
	color: #343434;
	text-shadow: rgba(255,255,255,0.8) 0px 1px 0px;
	font-size: 14px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	min-height: 45px;
	word-wrap: break-word;
}

#user_latest_status > div > span { display: block; padding-top: 6px; }
#user_utility_links { margin-top: 10px; text-align: right; }
.rating { margin-top: 10px; }

#status_wrapper .ipsBox_container {
	margin-bottom: 9px;
}

#profile_tabs li.active a:before{ 
	content:"";
	display: inline-block;
	width: 16px; height: 16px;
	margin: -6px 8px -5px 0;
	background-image: url('{style_images_url}/profile_tab_icon.png');
	background-repeat: no-repeat;
	background-position: 50% 50%;
}

#profile_tabs li[id$="info"] a:before{ background-image: url('{style_images_url}/profile_tab_info.png'); }
#profile_tabs li[id$="status"] a:before{ background-image: url('{style_images_url}/profile_tab_status.png'); }
#profile_tabs li[id$="friends"] a:before{ background-image: url('{style_images_url}/profile_tab_friends.png'); }
#profile_tabs li[id$="topics"] a:before{ background-image: url('{style_images_url}/profile_tab_topics.png'); }
#profile_tabs li[id$="posts"] a:before{ background-image: url('{style_images_url}/profile_tab_posts.png'); }
#profile_tabs li[id$="blog"] a:before{ background-image: url('{style_images_url}/profile_tab_blog.png'); }
#profile_tabs li[id$="gallery"] a:before{ background-image: url('{style_images_url}/profile_tab_gallery.png'); }
#profile_tabs li[id$="idm"] a:before{ background-image: url('{style_images_url}/profile_tab_idm.png'); }]]></css_content>
    <css_position>1</css_position>
    <css_app>members</css_app>
    <css_app_hide>1</css_app_hide>
    <css_attributes><![CDATA[title="Main" media="screen,print"]]></css_attributes>
    <css_modules/>
    <css_removed>0</css_removed>
    <css_master_key/>
  </cssfile>
</css>

--------------------------------------------------------------------------------
> Time: 1415628377 / Mon, 10 Nov 2014 14:06:17 +0000
> URL: /admin/index.php?adsess=c56f5ccb0e1ea9a55889b95d84a98c87&app=core&&module=templates&section=importexport&do=exportSet
> Replacements Export:
<?xml version="1.0" encoding="utf-8"?>
<replacements>
  <replacement>
    <replacement_key>add_folder</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/folder_add.png' alt='{lang:add_folder}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>add_friend</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/user_add.png' alt='{lang:add_friend}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>add_poll_choice</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/add.png' alt='+' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>add_poll_question</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/add.png' alt='+' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_add_entry</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/book_add.png' alt='+' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_banish</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/layout_delete.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_blocks</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/layout_add.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_blog</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/blog.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_category</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/folder.png' alt='-' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_comments</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/comments.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_comments_new</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/comments_new.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_editor</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/blog_editor.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_group</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/blog_group.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_header</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/layout_header.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_link</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/book_open.png' alt='{lang:view_blog}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_locked</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/lock.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_option</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/option.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_owner</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/blog_owner.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_privateclub</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/blog_privateclub.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_rss_import</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/rss-import.png' alt='' title='{lang:entry_imported_from_rss}' data-tooltip='{lang:entry_imported_from_rss}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>blog_theme</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/blog/palette.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>box_end</replacement_key>
    <replacement_content><![CDATA[</div>]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>close_poll_form</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/accept.png' alt='x' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>compose_icon</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/note_add.png' alt='{lang:macro__compose}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>display_name</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/display_name.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>dropdown</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/dropdown.png' alt='+' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>edit_folder</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/folder_edit.png' alt='{lang:edit_folders}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>find_icon</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/magnifier.png' alt='{lang:macro__compose}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>find_topics_link</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/page_topic_magnify.png' alt='{lang:find_topics}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>folder_delete</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/delete.png' alt='{lang:delete_folder_title}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>folder_drafts</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/folder.png' alt='{lang:macro__folder}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>folder_empty</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/bin.png' alt='{lang:empty_folder_title}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>folder_finished</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/folder.png' alt='{lang:macro__folder}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>folder_generic</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/folder.png' alt='{lang:macro__folder}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>folder_myconvo</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/email_go.png' alt='{lang:macro__myconvo}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>folder_new</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/folder_page.png' alt='{lang:macro__new}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>f_cat_read</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/f_icon_read.png' alt='{lang:macro__readcat}' title='{lang:macro__readcat}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>f_cat_unread</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/f_icon.png' alt='{lang:macro__unreadcat}' title='{lang:macro__markread}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>f_nav_sep</replacement_key>
    <replacement_content>{lang:_rarr}</replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>f_newpost</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/new_post.png' alt='' title='{lang:first_unread_post}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>f_pass_read</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/f_icon_read.png' alt='{lang:macro__readpw}' title='{lang:macro__readpw}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>f_pass_unread</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/f_icon.png' alt='{lang:macro__unreadpw}' title='{lang:macro__markread}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>f_read</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/f_icon_read.png' alt='{lang:macro__readf}' title='{lang:macro__readf}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>f_redirect</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/f_redirect.png' alt='{lang:macro__redirect}' title='{lang:macro__redirect}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>f_unread</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/f_icon.png' alt='{lang:macro__unreadf}' title='{lang:macro__markread}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>galery_album_edit</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/folder_edit.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>gallery_album_delete</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/delete.png' alt='-' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>gallery_image</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/gallery/image_add.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>gallery_link</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/picture.png' alt='{lang:view_gallery}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>gallery_slideshow</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/gallery/pictures.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>generic_cog</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/cog.png' alt='+' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>header_end</replacement_key>
    <replacement_content><![CDATA[<div class='border'>]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>header_start</replacement_key>
    <replacement_content/>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>lim_facebook</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/loginmethods/facebook.png' alt='{lang:lim_facebook}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>lim_openid</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/loginmethods/openid.png' alt='{lang:lim_openid}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>lim_twitter</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/loginmethods/twitter.png' alt='{lang:lim_twitter}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>lim_windows</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/loginmethods/windows.png' alt='{lang:lim_windows}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>live_large</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/live.gif' alt='{lang:macro__liveicon}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>live_small</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/live.gif' alt='{lang:macro__liveicon}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>lock_icon</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/lock.png' alt='{lang:pm_locked}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>logo_img</replacement_key>
    <replacement_content>{style_image_url}/logo.png</replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>mini_rate_off</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/bullet_star_off.png' alt='-' class='mini_rate' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>mini_rate_on</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/bullet_star.png' alt='*' class='mini_rate' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>openid_large</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/openid_logo.png' alt='{lang:macro__openidlogo}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>openid_small</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/openid.gif' alt='{lang:macro__openidicon}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>pip_pip</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/bullet_black.png' alt='{lang:macro__pip}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>popular_post</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/star_big.png' alt='*' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>post_attach_link</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/attachicon.gif'	alt='{lang:macro__attachment}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>rate_off</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/star_off.png' alt='-' class='rate_img' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>rate_on</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/star.png' alt='*' class='rate_img' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>remove_friend</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/user_delete.png' alt='{lang:remove_friend}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>remove_poll_choice</replacement_key>
    <replacement_content><![CDATA[<span class='cancel' title='{lang:remove_choice}'>&times;</span>]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>remove_poll_question</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/cross.png' alt='-' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>report_green_alert</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/reports/post_alert_3.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>report_red_alert</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/reports/post_alert_1.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>rep_down</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/rep_down.png' alt='-' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>rep_up</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/rep_up.png' alt='+' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>send_msg</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/email_open.png' alt='{lang:pm_this_member}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>signin_icon</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/key.png' alt='{lang:macro__signin}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>skinlink</replacement_key>
    <replacement_content><![CDATA[<div class='branding_skin'>
<a href="http://www.skinbox.net/" title="IPB Skins and Invision Skins at Skinbox"><strong>IPB skins</strong></a> by <a href="http://www.skinbox.net/" title="IPB Skins and Invision Skins at Skinbox"><strong>Skinbox</strong></a>
<a href="http://www.skinbox.net" title="IPB Skins at Skinbox"><img src="{style_images_url}/_custom/skinbox.png" class="branding_logo" alt="IPB Skins at Skinbox" /></a>
</div>]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>snapback</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/snapback.png' alt='{lang:macro__view_post}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>sort_down</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/bullet_arrow_down.png' alt='V' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>sort_up</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/bullet_arrow_up.png' alt='^' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>spammer_off</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/spammer_off.png' alt='{lang:spm_off}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>spammer_on</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/spammer_on.png' alt='{lang:spm_on}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>topic_popup</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/topicpreview.png' alt='' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>t_announcement</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/t_announcement.png' alt='{lang:announce_row}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>t_closed</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/t_locked.png' alt='{lang:pm_locked}' /><br />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>t_moved</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/t_moved.png' alt='{lang:pm_moved}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>t_read_dot</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/t_read_dot.png' alt='{lang:you_posted_here}' title='{lang:you_posted_here}' /><br />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>t_unread</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/t_unread.png' alt='{lang:pm_open_new}' /><br />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>t_unread_dot</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/t_unread_dot.png' alt='{lang:you_posted_here}' /><br />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
  <replacement>
    <replacement_key>your_vote</replacement_key>
    <replacement_content><![CDATA[<img src='{style_image_url}/bullet_star_rated.png' alt='{lang:macro__voted}' />]]></replacement_content>
    <replacement_set_id>5</replacement_set_id>
    <replacement_master_key/>
  </replacement>
</replacements>

--------------------------------------------------------------------------------
> Time: 1415628377 / Mon, 10 Nov 2014 14:06:17 +0000
> URL: /admin/index.php?adsess=c56f5ccb0e1ea9a55889b95d84a98c87&app=core&&module=templates&section=importexport&do=exportSet
> Info Export:
<?xml version="1.0" encoding="utf-8"?>
<info>
  <data>
    <set_name>R-Style</set_name>
    <set_key>skinboxElegant_</set_key>
    <set_author_name>Skinbox.net</set_author_name>
    <set_author_url>http://www.skinbox.net</set_author_url>
    <set_output_format>html</set_output_format>
    <set_master_key>root</set_master_key>
    <ipb_human_version>3.4.6</ipb_human_version>
    <ipb_long_version>34012</ipb_long_version>
    <ipb_major_version>3</ipb_major_version>
  </data>
</info>
