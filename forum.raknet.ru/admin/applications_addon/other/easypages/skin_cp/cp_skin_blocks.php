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
 * ACP templates for the blocks module
 */

class cp_skin_blocks extends output {

public function __destruct() { }

/**
 * Main index: show all blocks
 */
public function blocksMainScreen( $rows ) {
$IPBHTML = "";
//--starthtml--//

$IPBHTML .= <<<HTML
<div class='section_title'>
	<h2>{$this->lang->words['ep_manage_blocks']}</h2>
	<div class='ipsActionBar clearfix'>
		<ul>
			<li class='ipsActionButton'>
				<a href='{$this->settings['base_url']}{$this->form_code}&amp;do=addnew'>
					<img src='{$this->settings['skin_acp_url']}/images/icons/add.png' alt='' />
					{$this->lang->words['ep_add_new_block']}
				</a>
			</li>
		</ul>
	</div>
</div>

<div class='acp-box'>
	<h3>{$this->lang->words['ep_blocks']}</h3>
	<table class='ipsTable'>
		<tr>
			<th>{$this->lang->words['ep_title']}</th>
			<th>{$this->lang->words['ep_block_key']}</th>
			<th>{$this->lang->words['ep_created']}</th>
			<th>{$this->lang->words['ep_updated']}</th>
			<th style="width: 60px">{$this->lang->words['ep_options']}</th>
		</tr>
HTML;
if(count($rows) > 0) {
	foreach( $rows as $r ) {
		$created = $this->lang->formatTime( $r['block_created'], 'short' );
		$updated = $this->lang->formatTime( $r['block_updated'], 'short' );
		
		$IPBHTML .= <<<HTML
		<tr class='ipsControlRow'>
			<td><span class='larger_text'><a href='{$this->settings['base_url']}{$this->form_code}&amp;do=edit&amp;p={$r['block_id']}'>{$r['block_title']}</a></span></td>
			<td>{$r['block_key']}</td>
			<td>{$created}</td>
			<td>{$updated}</td>
			<td nowrap='nowrap'>
				<ul class='ipsControlStrip' id='menu{$r['block_id']}_menucontent'>
					<li class='i_edit'><a href='{$this->settings['base_url']}{$this->form_code}&amp;do=edit&amp;p={$r['block_id']}'>{$this->lang->words['edit']}</a></li>
					<li class='i_delete'><a href='{$this->settings['base_url']}{$this->form_code}&amp;do=delete&amp;p={$r['block_id']}' onclick='return confirm("{$this->lang->words['ep_delete_confirm']}")'>{$this->lang->words['ep_remove']}</a></li>
				</ul>
			</td>
		</tr>
HTML;
	}
}
else
	$IPBHTML .= <<<HTML
		<tr>
			<td colspan='4'>
				{$this->lang->words['ep_no_blocks_found']} 
				<a href="{$this->settings['base_url']}{$this->form_code}&amp;do=addnew" class='mini_button'>{$this->lang->words['ep_add_new_block']}</a>
			</td>
		</tr>
HTML;

$IPBHTML .= <<<HTML
	</table>
</div>
HTML;

$IPBHTML .= $this->copyleft();

//--endhtml--//
return $IPBHTML;
}

/**
 * blocks create/edit form
 */
public function blocksEditForm( $data = array() ) {

	$classToLoad = IPSLib::loadLibrary( IPSLib::getAppDir( 'easypages' ) . "/sources/classes/common.php", 'sldEasyPages_common', 'easypages' );
	$this->common = new $classToLoad( $this->registry );

	/**
	 * Prepare form values
	 */
	if( count($data) > 0 )
	{
		$type = 'doEdit';
		$title = sprintf( $this->lang->words['ep_block_editing'], $data['block_title'] );
	}
	else
	{
		$type = 'doAdd';
		$title = $this->lang->words['ep_add_new_block'];
	}

	$key_desc = sprintf( $this->lang->words['ep_block_key_desc'], '<span id="block">{parse static_block="' . ($data['block_key'] ? $data['block_key'] : $this->lang->words['ep_block_key']) . '"}</span>' );

	$form = array();
	$form['title']			= $this->registry->output->formInput( "title", $data['block_title'] );
	$form['key']			= $this->registry->output->formInput( "key", $data['block_key'], '', 30, 'text', ' onkeyup="jQuery(\'#block\').html(\'{parse static_block=&quot;\'+this.value+\'&quot;}\');"' );
	$form['content']		= $this->registry->output->formTextarea( "content", $data['block_content'], 40, 5, 'contentBox', '', 'ips_EditorTextArea' );
	$form['use_php']		= $this->registry->output->formYesNo( "use_php", $data['block_use_php'], '' );
	$form['use_bbcode']		= $this->registry->output->formYesNo( "use_bbcode", $data['block_use_bbcode'], '' );

	// $classToLoad = IPSLib::loadLibrary( IPS_ROOT_PATH . 'sources/classes/editor/composite.php', 'classes_editor_composite' );
	// $this->editor = new $classToLoad();
	// $this->editor->setAllowBbcode( 1 );
	// $this->editor->setAllowHtml( 1 );
	// $this->editor->setContent( $data['block_content'] );
	// $form['content'] = $this->editor->show( 'content', array( 'height' => 350 ) );

$IPBHTML = "";
//--starthtml--//

$IPBHTML .= $this->common->ckeditor( !$data['block_use_php'] );
$IPBHTML .= <<<HTML
<div class='section_title'>
	<h2>{$title}</h2>
</div>

<form action='{$this->settings['base_url']}{$this->form_code}' method='post' name='theAdminForm'  id='theAdminForm'>
	<input type='hidden' name='do' value='{$type}' />
	<input type='hidden' name='_admin_auth_key' value='{$this->registry->adminFunctions->getSecurityKey()}' />
	<input type='hidden' name='block_id' value='{$data['block_id']}' />
	
	<div class='acp-box'>
		<h3>{$this->lang->words['ep_block_settings']}</h3>
		<div class="ipsTabBar with_left with_right" id='tabstrip_easypages'>
			<span class='tab_left'>&laquo;</span>
			<span class='tab_right'>&raquo;</span>
			<ul>
				<li id='tab_1'>{$this->lang->words['ep_basic']}</li>
				<li id='tab_2'>{$this->lang->words['ep_advanced']}</li>
			</ul>
		</div>
		<div class="ipsTabBar_content" id="tabstrip_easypages_content">
			<div id="tab_1_content">
				<table class="ipsTable double_pad">
					<tr></tr>
					<tr>
						<td class='field_title'><strong class='title'>{$this->lang->words['ep_block_title']}</strong></td>
						<td class='field_field'>
							{$form['title']}<br />
							<span class="desctext">{$this->lang->words['ep_block_title_desc']}</span>
						</td>
					</tr>
					<tr>
						<td class='field_title'><strong class='title'>{$this->lang->words['ep_block_key']}</strong></td>
						<td class='field_field'>
							{$form['key']}<br />
							<span class="desctext">{$key_desc}</span>
						</td>
					</tr>
					<tr>
						<td class='field_title'><strong class='title'>{$this->lang->words['ep_block_content']}</strong></td>
						<td class='field_field'>
							<span class="desctext">
								{$this->lang->words['ep_block_content_desc']}
								<a href="#" id="wygify" style="display:none" class="mini_button">{$this->lang->words['ep_load_wysiwyg']}</a>
							</span>
						</td>
					</tr>
					<tr></tr>
					<tr>
						<td colspan="2">
							{$form['content']}
						</td>
					</tr>
				</table>
			</div>
			<div id="tab_2_content">
				<table class='ipsTable double_pad'>
					<tr></tr>
HTML;
if( $this->registry->getClass('class_permissions')->checkPermission( 'block_php' ) ) {
	$IPBHTML .= <<<HTML
					<tr>
						<td class='field_title'><strong class='title'>{$this->lang->words['ep_parse_php']}</strong></td>
						<td class='field_field'>
							{$form['use_php']}<br />
							<span class="desctext">{$this->lang->words['ep_block_php_desc']}</span>
						</td>
					</tr>
HTML;
}
	$IPBHTML .= <<<HTML
					<tr>
						<td class='field_title'><strong class='title'>{$this->lang->words['ep_parse_bbcode']}</strong></td>
						<td class='field_field'>
							{$form['use_bbcode']}<br />
							<span class="desctext">{$this->lang->words['ep_parse_bbcode_desc']}</span>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class='acp-actionbar'>
			<input type='submit' value='{$this->lang->words['ep_submit']}' class='button' accesskey='s' />&nbsp;
			<input type='button' value='{$this->lang->words['ep_savecontinue']}' class='button' onclick='this.form.action+="&amp;continue=1";this.form.submit();' accesskey='a' />
		</div>
	</div>
</form>
<script type='text/javascript'>
	jQ("#tabstrip_easypages").ipsTabBar({ tabWrap: "#tabstrip_easypages_content" });
</script>
HTML;

$IPBHTML .= $this->copyleft();

//--endhtml--//
return $IPBHTML;
}

public function copyleft() {
	return <<<HTML
<div id="footer">
	{$this->lang->words['ep_app_title']} v1.1.3 
	&copy; 2013 Ryan Hoerr / <a href="http://www.sublimism.com" target="_blank">Sublime Development</a> &nbsp; | &nbsp; 
	<a href="http://community.invisionpower.com/topic/343715-download-easy-pages/" target="_blank">Get Support</a>
</div>
HTML;
}

}
