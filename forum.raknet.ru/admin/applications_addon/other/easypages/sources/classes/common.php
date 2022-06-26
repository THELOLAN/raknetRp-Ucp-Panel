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

class sldEasyPages_common
{
	protected $registry;
	protected $DB;
	protected $settings;
	protected $request;
	protected $lang;
	protected $member;
	protected $memberData;
	protected $cache;
	protected $caches;
	protected $blockArr;

	public function __construct( ipsRegistry $registry )
	{
		/* Make objects */
		$this->registry = $registry;
		$this->DB	    = $this->registry->DB();
		$this->settings =& $this->registry->fetchSettings();
		$this->request  =& $this->registry->fetchRequest();
		$this->lang	    = $this->registry->getClass('class_localization');
		$this->member   = $this->registry->member();
		$this->memberData =& $this->registry->member()->fetchMemberData();
		$this->cache	= $this->registry->cache();
		$this->caches   =& $this->registry->cache()->fetchCaches();
	}

	/**
	 * Parse BBcode / HTML / static blocks and return.
	 */
	public function parseText( $page )
	{
		$raw = $page['page_content'];

		/**
		 * Parse the page content
		 */
		if( $page['page_use_php'] ) {
			/**
			 * Process any parse codes (PHP must be enabled)
			 */
			$raw = IPSText::replaceRecursively( $raw, '{parse', '&quot;}', array( 'sldEasyPages_common', '_processPluginTagsCallback' ) );
			
			/**
			 * Evaluate PHP
			 */
			ob_start();
			eval( "?>" . $raw . "<?php " );
			$raw = ob_get_contents();
			ob_end_clean();
		}

		if( $page['page_use_bbcode'] ) {
			$raw = $this->parseBBCode( $raw );
		}

		/**
		 * Process static blocks
		 */
		$raw = $this->parseStaticBlocks( $raw );

		/**
		 * Misc. fixes
		 */
		$raw = str_replace(	array( '<ul>', '<ol ', '<ol>', '</ol>' ),
							array( '<ul class="bbc">', '<ul ', '<ul class="bbcol decimal">', '</ul>' ),
							$raw );

		return $raw;
	}

	/**
	 * Intercept callback for parse tags
	 */
	static public function _processPluginTagsCallback( $text, $textOpen, $textClose )
	{
		// Run the standard parse code.
		$text = ipsRegistry::instance()->getClass('templateEngine')->_processPluginTagsCallback( html_entity_decode($text), $textOpen, $textClose );

		// Return for evaluation (don't have proper scope).
		return '<?php $IPBHTML = "' . $text . '"; echo $IPBHTML; ?>';
	}

	public function parseBBCode( $raw )
	{
		IPSText::getTextClass('bbcode')->parse_bbcode		= 1;
		IPSText::getTextClass('bbcode')->parse_html			= 0;
		IPSText::getTextClass('bbcode')->parse_emoticons	= 1;
		IPSText::getTextClass('bbcode')->parse_nl2br		= 0;
		IPSText::getTextClass('bbcode')->parsing_section	= 'global';
		
		return IPSText::getTextClass('bbcode')->preDisplayParse( IPSText::getTextClass('bbcode')->preDbParse( $raw ) );
	}

	public function parseStaticBlocks( $raw )
	{
		/**
		 * Find static blocks
		 */
		$fetch = array();
		preg_match_all( '/\{parse static_block=(\&quot;|\&#39;|\'|")(.*?)(\&quot;|\&#39;|\'|")\}/i', $raw, $matches, PREG_SET_ORDER );
		foreach( $matches as $match ) {
			if( empty($this->blockArr[$match]) ) {
				$fetch[] = $match[2];
			}
		}

		/**
		 * Load, parse, and insert static blocks
		 */
		if( count($fetch) ) {
			foreach( $fetch as $r ) {
				$in[] = "'" . $this->DB->addSlashes($r) . "'";
			}

			$this->DB->build( array(	'select'	=> '*',
										'from'		=> 'ep_blocks',
										'where'		=> 'block_key in (' . implode( ',', array_filter( $in ) ) . ')' ) );
			$this->DB->execute();
			while( $block = $this->DB->fetch() ) {
				if( $block['block_use_php'] ) {
					ob_start();
					eval( "?>" . $block['block_content'] . "<?php " );
					$block['block_content'] = ob_get_contents();
					ob_end_clean();
				}

				if( $block['block_use_bbcode'] ) {
					$block['block_content'] = $this->parseBBCode( $block['block_content'] );
				}

				$this->blockArr[ $block['block_key'] ] = $block['block_content'];
			}
		}
		$raw = preg_replace_callback( '/\{parse static_block=(\&quot;|\&#39;|\'|")(.*?)(\&quot;|\&#39;|\'|")\}/i', array( $this, '_blockCallback' ), $raw );

		return $raw;
	}

	protected function _blockCallback( $matches )
	{
		return $this->blockArr[ $matches[2] ];
	}

	public function ckeditor( $wysiwyg=1 )
	{
		$bbcode = IPSLib::fetchBbcodeAsJson();

		require_once( IPS_ROOT_PATH . 'sources/classes/editor/composite.php' );
		$editor = new classes_editor_composite();
		$emotes = json_encode( $editor->fetchEmoticons() );

		$HTML = <<<HTML
<script type="text/javascript" src="{$this->settings['public_dir']}js/3rd_party/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src='{$this->settings['cache_dir']}lang_cache/{$this->lang->lang_id}/ipb.lang.js' charset='{$this->settings['gb_char_set']}'></script>
<script type="text/javascript" src="{$this->settings['public_dir']}js/ips.textEditor.js"></script>
<script type="text/javascript" src="{$this->settings['public_dir']}js/ips.textEditor.bbcode.js"></script>
<script type="text/javascript">
	/* Dynamic items */
	CKEDITOR.config.IPS_BBCODE = {$bbcode};
	CKEDITOR.config.IPS_BBCODE_IMG_URL  = "{$this->settings['js_base_url']}style_extra/bbcode_icons";
	CKEDITOR.config.IPS_BBCODE_BUTTONS  = [];
	
	/* Has to go before config load */
	var IPS_smiley_path			= "{$this->settings['emoticons_url']}/";
	var IPS_smiles       		= {$emotes};
	var IPS_remove_plugins      = [];
	var IPS_extra_plugins       = [];
	
	/* Load our configuration */
	CKEDITOR.config.customConfig  = '{$this->settings['public_dir']}js/3rd_party/ckeditor/ips_config.js';
</script>
<style type="text/css">
@import url("{$this->settings['css_base_url']}style_css/{$this->registry->output->skin['_csscacheid']}/ipb_ckeditor.css");
</style>
<input type='hidden' name='noSmilies' id='noSmilies_contentBox' value='0' />
HTML;
	if( $wysiwyg ) {
		if( $this->settings['ep_load_wysiwyg'] ) {
			$HTML .= <<<HTML
<script type="text/javascript">
jQuery(document).ready(function() {
	ipb.textEditor.initialize('contentBox', {	type: 'ipsacp',
												minimize: 0,
												bypassCKEditor: 0,
												isRte: 1 } );
});
</script>
HTML;
		}
		else {
			$HTML .= <<<HTML
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#wygify').show().click(function(e) {
		wygify();
		$(this).hide();
		return false;
	});
});
function wygify() {
	ipb.textEditor.initialize('contentBox', {	type: 'ipsacp',
												minimize: 0,
												bypassCKEditor: 0,
												isRte: 1 } );
}
	</script>
HTML;
			}
		}

		return $HTML;
	}
}
