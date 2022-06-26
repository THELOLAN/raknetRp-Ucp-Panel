<?php
/**
 * @file		media.php 	IP.Gallery media library
 *~TERABYTE_DOC_READY~
 * $Copyright: (c) 2001 - 2011 Invision Power Services, Inc.$
 * $License: http://www.invisionpower.com/company/standards.php#license$
 * $Author: AndyMillne $
 * @since		4.0.0
 * $LastChangedDate: 2013-09-16 13:26:07 -0400 (Mon, 16 Sep 2013) $
 * @version		vVERSION_NUMBER
 * $Revision: 12362 $
 */

if ( ! defined( 'IN_IPB' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded all the relevant files.";
	exit();
}

class gallery_media
{
	/**#@+
	 * Registry Object Shortcuts
	 *
	 * @var		object
	 */
	protected $registry;
	protected $DB;
	protected $settings;
	protected $request;
	protected $lang;
	protected $member;
	protected $memberData;
	protected $cache;
	protected $caches;
	/**#@-*/
	
	/**
	 * Media file extensions: fileExt => canUseFlashPlayer (int)
	 *
	 * @var		array
	 */
	protected $_ext		= array( 'flv'  => 1, 'f4v' => 1, 'mp4' => 1, 'mov' => 1, 'm4a' => 1, 'm4v' => 1, '3gp' => 1, 'avi' => 0, 'wmv' => 0, 'mpg' => 1, 'mpeg' => 1, 'mkv' => 0, 'swf' => 1 );

	/**
	 * Media file extensions: fileExt => mime-type
	 *
	 * @var		array
	 */
	protected $_mtypes	= array(
								'flv'	=> 'video/x-flv',
								'f4v'	=> 'video/x-flv',
								'mp4'	=> 'video/mp4',
								'mov'	=> 'video/quicktime',
								'm4a'	=> 'audio/mp4a-latm',
								'm4v'	=> 'video/x-m4v',
								'3gp'	=> 'video/3gpp',
								'avi'	=> 'video/x-msvideo',
								'wmv'	=> 'video/x-ms-wmv',
								'mpg'	=> 'video/mpeg',
								'mpeg'	=> 'video/mpeg',
								'mkv'	=> 'video/x-matroska',
								'swf'	=> 'application/x-shockwave-flash'
								);
	
	/**
	 * Constructor
	 *
	 * @param	object		$registry
	 * @return	@e void
	 */
	public function __construct( ipsRegistry $registry )
	{
		//-----------------------------------------
		// Registry shortcuts
		//-----------------------------------------

		$this->registry   =  $registry;
		$this->DB         =  $this->registry->DB();
		$this->settings   =& $this->registry->fetchSettings();
		$this->request    =& $this->registry->fetchRequest();
		$this->lang       =  $this->registry->getClass('class_localization');
		$this->member     =  $this->registry->member();
		$this->memberData =& $this->registry->member()->fetchMemberData();
		$this->cache      =  $this->registry->cache();
		$this->caches     =& $this->registry->cache()->fetchCaches();
	}
	
	/**
	 * Allow media within gallery?
	 *
	 * @return	@e boolean
	 */
	public function allow()
	{
		return true;
	}
	
	/**
	 * Return a mime type
	 *
	 * @return	@e array
	 */
	public function getMimeType( $ext )
	{
		if ( strstr( $ext, '.' ) )
		{
			$ext	= IPSText::getFileExtension( $ext );
		}
		
		return ( ! empty( $this->_mtypes[ $ext ] ) ) ? $this->_mtypes[ $ext ] : null;
	}
	
	/**
	 * Return an array of allowed extensions
	 *
	 * @return	@e array
	 */
	public function allowedExtensions()
	{
		return array_keys( $this->_ext );
	}
	
	/**
	 * Is this extension allowed?
	 *
	 * @return	@e array
	 */
	public function isAllowedExtension( $ext )
	{
		$ext	= IPSText::getFileExtension( $ext );
		
		return isset($this->_ext[ $ext ]) ? true : false;
	}
	
	/**
	 * Can use flash player
	 *
	 * @return	@e array
	 */
	public function canUseFlashPlayer( $image )
	{
		//-----------------------------------------
		// Using dynamic URLs?
		//-----------------------------------------

		if( !$this->settings['gallery_images_url'] )
		{
			return false;
		}

		//-----------------------------------------
		// INIT
		//-----------------------------------------

		$dir	= ( $image['image_directory'] ) ? $image['image_directory'] . '/' : '/';
		$file	= $this->settings['gallery_images_url'] . '/' . $dir . $image['image_masked_file_name'];
		$ext	= IPSText::getFileExtension( $file );

		//-----------------------------------------
		// Can only use the flash player with certain file types
		//-----------------------------------------

		if ( ! empty( $this->_ext[ $ext ] ) )
		{
			if ( $ext != 'flv' AND $ext != 'f4v' AND ! $this->_checkCodec( $file ) )
			{
				return false;
			}
			else
			{
				return true;
			}
		}

		return false;
	}
	
	/**
	 * Returns HTML for the player
	 *
	 * @param	array	Array of image data
	 * @param	array	Array of player options (size, width)
	 * @param	int		Flag to indicate if we should check if the player is forced off
	 */
	public function getPlayerHtml( $image, $playerOptions=array(), $opt=0 )
	{
		//-----------------------------------------
		// INIT
		//-----------------------------------------

		$dir	= ( $image['image_directory'] ) ? $image['image_directory'] . '/' : '/';
		
		if ( $this->settings['gallery_images_url'] )
		{
			$file	= $this->settings['gallery_images_url'] . '/' . $dir . $image['image_masked_file_name'];
		}
		else
		{
			$file	= "{$this->settings['board_url']}/index.php?app=gallery&amp;module=images&amp;section=img_ctrl&amp;img={$image['image_id']}&amp;file=mediafull";
		}

		$ext	= IPSText::getFileExtension( $image['image_masked_file_name'] );
		$mime	= $this->getMimeType( $ext );

		//-----------------------------------------
		// If we can use flash player, do so, otherwise return generic HTML embed code
		//-----------------------------------------

		if ( $this->canUseFlashPlayer( $image ) AND $opt != GALLERY_MEDIA_FORCE_NO_FLASH_PLAYER )
		{
			return $this->_getFlashPlayer( $file, $playerOptions, $mime );
		}
		else
		{
			return $this->_getEmbedPlayer( $file, $playerOptions, $mime );
		}
	}
	
	/**
	 * Build media thumbnails
	 *
	 * @since	2.1
	 * @param	array 	Image data
	 * @param	array 	Options array
	 * @return	@e bool
	 */
	public function buildThumbs( $image, $opts=array() )
	{
		//-----------------------------------------
		// Load image data if necessary and check
		//-----------------------------------------

		if ( ! is_array( $image ) )
		{
			$image	= $this->registry->gallery->helper('image')->fetchImage( $image, GALLERY_IMAGES_FORCE_LOAD );
		}

		if ( ! count($image) )
		{
			return false;
		}

		if ( ! $image['image_media'] )
		{
			return false;
		}

		//-----------------------------------------
		// INIT
		//-----------------------------------------

		$dir	= $image['image_directory'] ? $image['image_directory'] . "/" : '';
		$thumb	= $this->settings['gallery_images_path'] . '/' . $dir . 'tn_'  . $image['image_medium_file_name'];

		if ( ! isset( $opts['destination'] ) AND ! is_numeric( $image['image_id'] ) AND strlen( $image['image_id'] ) == 32 )
		{
			$opts['destination'] = 'uploads';
		}

		//-----------------------------------------
		// Verify file exists
		//-----------------------------------------

		if ( ! is_file( $this->settings['gallery_images_path'] . '/' . $dir . $image['image_medium_file_name'] ) )
		{
			return false;
		}
		
		//-----------------------------------------
		// Temporary upload or finished image?
		//-----------------------------------------

		if( $opts['destination'] == 'uploads' )
		{
			$_table		= 'gallery_images_uploads';
			$_field		= 'upload_medium_name';
			$_thumb		= 'upload_thumb_name';
			$_where		= 'upload_key=\'' . $image['image_id'] . '\'';
		}
		else
		{
			$_table		= 'gallery_images';
			$_field		= 'image_medium_file_name';
			$_thumb		= 'image_media_thumb';
			$_where		= 'image_id=' . $image['image_id'];
		}

		//-----------------------------------------
		// Setup for save array
		//-----------------------------------------
		
		if ( ! empty( $_thumb  ) )
		{
			$_save[ $_thumb ]	= '';
		}

		//-----------------------------------------
		// Format settings for image library
		//-----------------------------------------

		$settings	= array(
							'image_path'	=> $this->settings['gallery_images_path'] . '/' . $dir,
							'image_file'	=> $image['image_medium_file_name'],
							'im_path'		=> $this->settings['gallery_im_path'],
							'temp_path'		=> DOC_IPS_ROOT_PATH . '/cache/tmp',
							'jpg_quality'	=> GALLERY_JPG_QUALITY,
							'png_quality'	=> GALLERY_PNG_QUALITY
							);
			
		//-----------------------------------------
		// Get image library
		//-----------------------------------------

		require_once( IPS_KERNEL_PATH . 'classImage.php' );/*noLibHook*/
		$img	= ips_kernel_image::bootstrap( $this->settings['gallery_img_suite'] );
		
		//-----------------------------------------
		// Get rid of existing thumbnail
		//-----------------------------------------

		if ( is_file( $thumb ) )
		{
			@unlink( $thumb );
		}
		
		//-----------------------------------------
		// Generate new thumbnail
		//-----------------------------------------

		if ( $img->init( $settings ) )
		{
			if ( $this->settings['gallery_use_square_thumbnails'] )
			{
				$return	= $img->croppedResize( $this->settings['gallery_size_thumb_width'], $this->settings['gallery_size_thumb_height'] );
			}
			else
			{
				$return	= $img->resizeImage( $this->settings['gallery_size_thumb_width'], $this->settings['gallery_size_thumb_height'], false, false, array( $this->settings['gallery_size_thumb_width'], $this->settings['gallery_size_thumb_height'] ) );
			}
			
			$img->addWatermark( IPSLib::getAppDir( 'gallery' ) . '/extensions/play_watermark.png', 60 );
			$img->writeImage( $thumb );

			@chmod( $thumb, IPS_FILE_PERMISSION );
			
			if ( ! empty( $_thumb  ) )
			{
				$_save[ $_thumb ]	= 'tn_'  . $image['image_medium_file_name'];
			}
			
			unset( $img );
		}

		//-----------------------------------------
		// Save new details to DB and return
		//-----------------------------------------

		if ( count( $_save ) )
		{
			$this->DB->update( $_table, $_save, $_where );
		}
		
		return true;
	}
	
	/**
	 * Get thumbnail
	 *
	 * @param	mixed	Image ID or image data
	 * @param	array 	Options array
	 * @return	@e string
	 */
	public function getThumb( $image, $opts=array() )
	{
		//-----------------------------------------
		// Set CSS class
		//-----------------------------------------

		if( empty( $opts['thumbClass'] ) )
		{
			$opts['thumbClass']	= ( $opts['type'] == 'medium' ) ? 'galmedium' : ( ( $opts['type'] == 'small' ) ? 'galsmall' : 'galattach' );
		}

		//-----------------------------------------
		// Cover image?
		//-----------------------------------------

		if ( isset( $opts['coverImg'] ) AND $opts['coverImg'] === true )
		{
			if ( ! strstr( $opts['thumbClass'], 'cover_img___xx___' ) )
			{
				$opts['thumbClass']	.= ' cover_img___xx___';
				$opts['link-type']	= $opts['link-type'] ? $opts['link-type'] : 'container';
			}
		}

		//-----------------------------------------
		// Overlays
		//-----------------------------------------

		if( isset( $image['_isRead'] ) && ! $image['_isRead'] )
		{
			$opts['thumbClass']	.= ' hello_i_am_new';
		}

		if( isset( $image['image_approved'] ) && $image['image_approved'] == 0 )
		{
			$opts['thumbClass']	.= ' hello_i_am_unapproved';
		}

		if( isset( $image['image_approved'] ) && $image['image_approved'] == -1 )
		{
			$opts['thumbClass']	.= ' hello_i_am_hidden';
		}

		//-----------------------------------------
		// Fetch image data if necessary
		//-----------------------------------------

		if ( is_numeric( $image ) OR ( ! is_array( $image ) AND strlen( $image ) == 32 ) )
		{
			$image	= $this->registry->gallery->helper('image')->fetchImage( $image );
		}

		//-----------------------------------------
		// Sort out directory
		//-----------------------------------------

		$dir	= $image['image_directory'] ? $image['image_directory'] . "/" : '';

		//-----------------------------------------
		// Do we have a thumb?
		//-----------------------------------------

		if ( $image['image_media_thumb'] )
		{
			if ( $this->settings['gallery_images_url'] )
			{
				$imagemg_url = $this->settings['gallery_images_url'] . '/' . $dir . $image['image_media_thumb'];
			}
			else
			{
				$imagemg_url = "{$this->settings['board_url']}/index.php?app=gallery&amp;module=images&amp;section=img_ctrl&amp;img={$image['image_id']}&amp;file=media";
			}
		}
		else
		{
			$imagemg_url	= "{$this->settings['img_url']}/gallery/media_nothumb.png";
		}

		//-----------------------------------------
		// Return requested type
		//-----------------------------------------

		if ( $opts['link-type'] == 'src' )
		{
			return $imagemg_url;
		}
		else
		{
			return "<img src='{$imagemg_url}' class='{$opts['thumbClass']}' width='{$this->settings['gallery_size_thumb_width']}' height='{$this->settings['gallery_size_thumb_height']}' title='{$image['image_caption']}' alt='{$image['image_caption']}' id='tn_image_view_{$image['image_id']}' />";
		}
	}
	
	/**
	 * Checks to see if it's a h264 movie
	 *
	 * @param	string	File path
	 * @return	@e bool
	 */
	protected function _checkCodec( $file )
	{
		//-----------------------------------------
		// Does the file exist?
		//-----------------------------------------

		if ( ! is_file( $file ) )
		{
			return false;
		}
		
		//-----------------------------------------
		// INIT
		//-----------------------------------------

		$ret		= false;
		
		$flash41	= array( 20, 32 );
		$fourcc		= array( 0x66747970 );

		//-----------------------------------------
		// Read file data
		//-----------------------------------------

		$fh		= fopen( $file, 'rb');
		$_data	= fread( $fh, 8);
		fclose( $fh );

		//-----------------------------------------
		// Then check bytes
		//-----------------------------------------

		$two	= substr( $_data, 0, 2);
		$four1	= substr( $_data, 0, 4);
		$four2	= substr( $_data, 4, 4);
		
		$_t		= unpack( 'n', $two );
		$two	= $_t[1];
		
		$_t		= unpack( 'N', $four1 );
		$four1	= $_t[1];
		
		$_t		= unpack( 'N', $four2 );
		$four2	= $_t[1];

		//-----------------------------------------
		// Is it valid?
		//-----------------------------------------

		if ( in_array( $four2, $fourcc ) && in_array( $four1, $flash41 ) )
		{
			$ret = true;
		}
		
		return $ret;
	}
	
	/**
	 * Gets the HTML for the EMBED player
	 *
	 * @param	string		$file			File name
	 * @param	array		$playerOptions	Player options
	 * @param	string		$mime			Mime type
	 * @return	@e string	HTML
	 */
	protected function _getEmbedPlayer( $file, $playerOptions=array(), $mime='' )
	{
		return $this->registry->output->getTemplate('gallery_img')->mediaEmbedPlayer( $file, $playerOptions, $mime );
	}
	
	/**
	 * Gets the HTML for the flash player
	 *
	 * @param	string		$file			File name
	 * @param	array		$playerOptions	Player options
	 * @return	@e string	HTML
	 */
	protected function _getFlashPlayer( $file, $playerOptions=array(), $mime='' )
	{
		$this->registry->output->addToDocumentHead( 'raw', "<link rel='stylesheet' href='{$this->settings['public_dir']}videojs/video-js.min.css' />" );
		$this->registry->output->addToDocumentHead( 'javascript', "{$this->settings['public_dir']}videojs/video.js" );
		
		return <<<EOF
<script>
  videojs.options.flash.swf = "{$this->settings['public_dir']}videojs/video-js.swf"
</script>
<div style="width:640px; margin: 0px auto;">
  <video id="gallery_video" class="video-js vjs-default-skin" controls preload="auto" width="640" height="480" data-setup="{}">
   <source src="{$file}" type='{$mime}'>
  </video>
</div>
EOF;
	}
}
