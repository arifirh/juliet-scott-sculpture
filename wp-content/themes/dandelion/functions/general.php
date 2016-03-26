<?php

$pexeto_separator='|*|';
add_theme_support('automatic-feed-links');
add_theme_support('menus');
add_theme_support( 'post-formats', array( 'gallery', 'video', 'aside', 'quote' ) );


/* ------------------------------------------------------------------------*
 * ENQUEUE SCRIPTS AND STYLES
 * ------------------------------------------------------------------------*/

if(!function_exists('pexeto_enqueue_styles')){
	function pexeto_enqueue_styles(){
		//INCLUDE THE STYLES
		$ver = PEXETO_VERSION;
		$cssuri = get_template_directory_uri().'/css/';
		wp_enqueue_style('pexeto-pretty-photo', $cssuri.'prettyPhoto.css', array(), $ver);
		wp_enqueue_style('pexeto-superfish', $cssuri.'superfish.css', array(), $ver);
		wp_enqueue_style('pexeto-nivo-slider', $cssuri.'nivo-slider.css', array(), $ver);
		wp_enqueue_style('pexeto-stylesheet', get_bloginfo('stylesheet_url'), array(), $ver);

		if(pexeto_enable_responsive()){
			wp_enqueue_style('pexeto-responsive', $cssuri.'responsive.css', array(), $ver, '(min-width:0px)');
		}

		//GOOGLE FONTS
		if ( get_opt( '_enable_google_fonts' )!='off' ) {
			$fonts=pexeto_get_google_fonts();
			$i=0;
			foreach ( $fonts as $font ) {
				wp_enqueue_style('pexeto-font-'.$i++, $font);
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 'pexeto_enqueue_styles');



if(!function_exists('pexeto_enqueue_scripts')){
	function pexeto_enqueue_scripts(){
		$ver = PEXETO_VERSION;

		//INCLUDE THE SCRIPTS
		$jsuri=get_template_directory_uri().'/script/';

		wp_enqueue_script( "jquery" );
		wp_enqueue_script( "pexeto-pretty-photo", $jsuri.'jquery.prettyPhoto.js' , array('jquery'), $ver);
		wp_enqueue_script( "pexeto-jquery-tools", $jsuri.'jquery.tools.min.js' , array('jquery'), $ver);
		wp_enqueue_script( "pexeto-main", $jsuri.'script.js' , array('jquery', 'pexeto-pretty-photo', 'pexeto-jquery-tools'), $ver);

		if ( is_page_template( 'template-portfolio-gallery.php' ) ) {
			//load the scripts for the portfolio gallery template
			wp_enqueue_script( "pexeto-gallery", $jsuri.'portfolio-setter.js' , array('pexeto-main'), $ver);
		}

		if ( is_page_template( 'template-portfolio.php' ) ) {
			//load the scripts for the portfolio showcase template
			wp_enqueue_script( "pexeto-portfolio", $jsuri.'portfolio-previewer.js' , array('pexeto-main'), $ver);
		}

		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}

		//CUFON FONT REPLACEMENT
		$enable_cufon=get_opt( '_enable_cufon' );
		if ( $enable_cufon=='on' ) {
			if ( get_opt( '_custom_cufon_font' )!='' ) {
				$font_file=get_opt( '_custom_cufon_font' );
			}else {
				$font_file=get_template_directory_uri().'/script/fonts/'.get_opt( '_cufon_font' );
			}
			wp_enqueue_script( "pexeto-cufon", $jsuri.'cufon-yui.js' );
			wp_enqueue_script( "pexeto-cufon-font", $font_file );
		}

		//INCLUDE THE SLIDER FILE
		$slider_file = pexeto_get_current_page_slider_filename();
		if($slider_file){
			wp_enqueue_script( "pexeto-slider", $jsuri.$slider_file, array('pexeto-main'), $ver);
		}
	}
}

add_action( 'wp_enqueue_scripts', 'pexeto_enqueue_scripts');


if(!function_exists('pexeto_enable_responsive')){
	function pexeto_enable_responsive(){
		return get_opt('_responsive')=='off' ? false : true;
	}
}


if(!function_exists('pexeto_get_current_page_slider_filename')){
	function pexeto_get_current_page_slider_filename(){
		global $post;
		if(is_home()){
			$slider = get_opt( '_home_slider' );
		}elseif(isset($post)){
			$slider = get_post_meta($post->ID, 'slider_value', true);
		}

		$sliders = array(
			'slider-thumbnail' => 'slider.js',
			'slider-nivo' => 'jquery.nivo.slider.pack.js',
			'slider-accordion' => 'accordion-slider.js',
			'slider-content' => 'content-slider.js'
			);

		if(!empty($slider) && isset($sliders[$slider])){
			return $sliders[$slider];
		}else{
			return false;
		}
	}
}

if(!function_exists('pexeto_print_footer_scripts')){
	function pexeto_print_footer_scripts(){
		global $pexeto_nivo_sliders;

		if(!empty($pexeto_nivo_sliders)){
			$autoplay = get_opt('_nivo_post_autoplay')=='on'?'true':'false';
			$script= '<script type="text/javascript">jQuery(document).ready(function(){';
			foreach ($pexeto_nivo_sliders as $slider) {
				
				// loadNivoSlider : function(obj, effect, showButtons, showArrows, slices, speed, interval, pauseOnHover, autoplay, columns, rows) {
				$script.=sprintf('pexetoSite.loadNivoSlider(jQuery("#%s"), "fade", true, true, 15, 400, 3000, true, %s, 8, 4);', $slider, $autoplay);
			}
			$script.= '});</script>';
			echo $script;
		}
	}
}

add_action('wp_print_footer_scripts', 'pexeto_print_footer_scripts' );

if(!function_exists('pexeto_enqueue_additional_scripts')){
	function pexeto_enqueue_additional_scripts(){
		global $pexeto_nivo_sliders;

		if(!empty($pexeto_nivo_sliders)){
			wp_enqueue_script( "pexeto-nivo", get_template_directory_uri().'/script/jquery.nivo.slider.pack.js' );
		}
	}
}

add_action( 'wp_footer', 'pexeto_enqueue_additional_scripts' );


/* ------------------------------------------------------------------------*
 * BLOG POSTS QUERY
 * ------------------------------------------------------------------------*/

if(!function_exists('pexeto_set_blog_post_settings')){
	/**
	 * Filter the main blog page query according to the blog settings in the theme's Options page
	 * @param $query the WP query object
	 */
	function pexeto_set_blog_post_settings( $query ) {
	    if ( $query->is_main_query() && is_home()) {
	    	$postsPerPage=get_opt('_post_per_page_on_blog')==''?5:get_opt('_post_per_page_on_blog');
			$excludeCat=explode(',',get_opt('_exclude_cat_from_blog'));
	        $query->set( 'category__not_in', $excludeCat );  //exclude the categories
	        $query->set( 'posts_per_page', $postsPerPage );  //set the number of posts per page
	    }
	}
}
add_action( 'pre_get_posts', 'pexeto_set_blog_post_settings' );

/* ------------------------------------------------------------------------*
 * SET THE THUMBNAILS
 * ------------------------------------------------------------------------*/

if(!function_exists('pexeto_set_image_sizes')){
	function pexeto_set_image_sizes(){
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 200, 200 );
		add_image_size('post_box_img', 580, 250, true);
		add_image_size('static-header-img', 980, 370, true);
	}
}
add_action('after_setup_theme', 'pexeto_set_image_sizes');


if(!function_exists('pexeto_get_resized_image')){

	function pexeto_get_resized_image($imgurl, $width, $height, $align='c', $enlarge = 0){
		$resized_img = '';
		$align_options = array('t', 'l', 'b', 'r');
		$crop_from_position = false;
		$crop = empty($height) ? false : true;
		$w = $width;
		$h = $height;

		//enlarge the image for retina displays
		if($enlarge!==0){
			$w = intval($width+$enlarge);
			$h = empty($height) ? $height : intval($height*$w/$width);
		}

		if(!empty($align) && in_array($align, $align_options)){
			$crop_from_position = true;
			$resized_img = pexeto_resize_with_crop($imgurl, $w, $h, $align);
		}

		if(!$crop_from_position || ($crop_from_position && !$resized_img)){
			//either crop position is not set or crop position was set but it
			//failed to resize the image, so attempt to resize with aq resize
			$resized_img = aq_resize( $imgurl, $w, $h, $crop, true, true );
		}

		if(!$resized_img){
			//the Aqua Resizer script could not crop the image, return the original image
			$resized_img = $imgurl;
		}

		return $resized_img;
	}
}


/* ------------------------------------------------------------------------*
 * PAGINATION
 * ------------------------------------------------------------------------*/


/**
 * Prints the pagination. Checks whether the WP-Pagenavi plugin is installed and if so, calls
 * the function for pagination of this plugin. If not- shows prints the previous and next post links.
 */
if(!function_exists('print_pagination')){
	function print_pagination(){
		if(function_exists('wp_pagenavi')){
		 wp_pagenavi();
		}else{?>
	<div id="blog_nav_buttons" class="navigation">
	<div class="alignleft"><?php previous_posts_link('<span>&laquo;</span> '.pex_text('_previous_text')) ?>
	</div>
	<div class="alignright"><?php next_posts_link(pex_text('_next_text').' <span>&raquo;</span>') ?>
	</div>
	</div>
		<?php
		}
	}
}

/* ------------------------------------------------------------------------*
 * MENUS
 * ------------------------------------------------------------------------*/


if(!function_exists('pexeto_register_menus')){
	/**
	 * Register the main menu for the theme.
	 */
	function pexeto_register_menus() {
		register_nav_menus(
		array(
				'pexeto_main_menu' => __( 'Main Menu', 'pexeto_admin' )
		)
		);
	}
}
add_action( 'init', 'pexeto_register_menus' );



/* ------------------------------------------------------------------------*
 * SLIDERS
 * ------------------------------------------------------------------------*/

/**
 * Generates arrays containing all the sliders names, so that this data would be used in an drop down select.
 */
if(!function_exists('pexeto_get_slider_data')){
	function pexeto_get_slider_data(){
		$pexeto_slider_ids=array();
		$pexeto_slider_names=array();
		$pexeto_slider_classes=array();
		$pexeto_slider_data=array();

		$pexeto_sliders=array(array('id'=>'_thum_slider_names', 'name'=>'Thumbnail Slider'),
		array('id'=>'_accord_slider_names', 'name'=>'Accordion Slider'),
		array('id'=>'_nivo_slider_names', 'name'=>'Nivo Slider'),
		array('id'=>'_content_slider_names', 'name'=>'Content Slider'),
		);

		foreach($pexeto_sliders as $slider){
			$slider_id=convert_to_class($slider['name']);

			//set the arrays for the page meta boxes
			$pexeto_slider_ids[]='disabled';
			$pexeto_slider_names[]=$slider['name'];
			$pexeto_slider_classes[]='caption';
			$pexeto_slider_ids[]='default';
			$pexeto_slider_names[]='Default Slider';
			$pexeto_slider_classes[]=$slider_id;

			//set the arrays for the options page
			$pexeto_slider_data[]=array('id'=>'disabled', 'name'=>$slider['name'], 'class'=>'caption');
			$pexeto_slider_data[]=array('id'=>'default', 'name'=>'Default', 'class'=>$slider_id);

			$names = explode('|*|', get_option($slider['id']));

			if(sizeof($names)>1){
				array_pop($names);
				foreach($names as $slidername){
					$pexeto_slider_ids[]=convert_to_class($slidername);
					$pexeto_slider_names[]=$slidername;
					$pexeto_slider_classes[]=$slider_id;
					$pexeto_slider_data[]=array('id'=>convert_to_class($slidername), 'name'=>$slidername, 'class'=>$slider_id);
				}
			}
		}

		return array('ids'=>$pexeto_slider_ids, 'names'=>$pexeto_slider_names, 'classes'=>$pexeto_slider_classes,'data'=>$pexeto_slider_data);
	}
}


/* ------------------------------------------------------------------------*
 * LIGHTBOX
 * ------------------------------------------------------------------------*/

if(!function_exists('pexeto_get_lightbox_options')){
	function pexeto_get_lightbox_options(){
		$opt_ids=array('theme','animation_speed','overlay_gallery', 'allow_resize', 'enable_social_tools', 'autoplay_slideshow');
		$res_arr=array();

		foreach ($opt_ids as $opt_id) {
			$option = get_opt($opt_id);
			if($option){
				if($option=='on'){
					$option = true;
				}elseif($option=='off'){
					$option = false;
				}
				$res_arr[$opt_id]=$option;
			}
		}

		return $res_arr;
	}
}

/* ------------------------------------------------------------------------*
 * LOCALE AND TRANSLATION
 * ------------------------------------------------------------------------*/

load_theme_textdomain( 'pexeto', get_stylesheet_directory() . '/lang' );

/**
 * Returns a text depending on the settings set. By default the theme gets uses
 * the texts set in the Translation section of the Options page. If multiple languages enabled,
 * the default language texts are used from the Translation section and the additional language
 * texts are used from the added .mo files within the lang folder.
 * @param $textid the ID of the text
 */
function pex_text($textid){

	$locale=get_locale();
	$int_enabled=get_opt('_enable_translation')=='on'?true:false;
	$default_locale=get_opt('_def_locale');

	if($int_enabled && $locale!=$default_locale){
		//use translation - extract the text from a defined .mo file
		return __($textid, 'pexeto');
	}else{
		//use the default text settings
		return stripslashes(get_opt($textid));
	}
}


/* ------------------------------------------------------------------------*
 * OTHER
 * ------------------------------------------------------------------------*/

if(!function_exists('pexeto_add_title_to_attachment')){

	/**
	 * Adds the title parameter to the image in the quick gallery.
	 * @param  string $markup the generated markup for the image attachment link
	 * @param  int $id     the ID of the attachment
	 * @return string         the modified markup so it includes the title attribute
	 * in the markup
	 */
	function pexeto_add_title_to_attachment( $markup, $id ){
		$att = get_post( $id );
		return str_replace('<a ', '<a title="'.esc_attr($att->post_title).'" ', $markup);
	}
}
add_filter('wp_get_attachment_link', 'pexeto_add_title_to_attachment', 10, 2);



if(!function_exists('pexeto_get_first_gallery_images')){
	function pexeto_get_first_gallery_images($post){
		$pattern = get_shortcode_regex();
		$ids = array();
		$attachments = array();
		$images = array();

		//check if there is a gallery shortcode included
		if (   preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
			&& array_key_exists( 2, $matches )
			&& in_array( 'gallery', $matches[2] ) ) {

			$key = array_search( 'gallery', $matches[2] );
			$att_text = $matches[3][$key];
			$atts = shortcode_parse_atts( $att_text );
			if ( !empty( $atts['ids'] ) ) {
				$ids = explode( ',' , $atts['ids'] );
			}
		}

		$args = array(
			'post_type' => 'attachment',
			'post_mime_type' =>'image',
			'numberposts' =>-1
		);

		if ( empty( $ids ) ) {
			return $attachments;
		}else {
			//there is a gallery shortcode included
			$args['post__in'] = $ids;
		}

		$attachments = get_posts( $args );

		//the images are added via the gallery shortcode, order them as set in their IDs attribute
		
		if(sizeof($attachments)==sizeof($ids)){
			$ordered_images = array_fill( 0, sizeof( $attachments ), null );

			foreach ( $attachments as $img ) {
				$index = array_search( $img->ID, $ids );
				$ordered_images[$index] = $img;
			}

		}else{
			//overcome the WP bug about not removing the deleted images IDs
			//from the gallery shortcode
			$ordered_images=array();

			foreach ($ids as $id) {
				foreach ($attachments as $img) {
					if($img->ID == $id){
						$ordered_images[]=$img;
						break;
					}
				}
			}
		}

		$attachments = $ordered_images;
		$img_id = get_opt('_blog_layout')=='full'?'static-header-img':'post_box_img';
			
		foreach ( $attachments as $attachment ) {

			$img_src = wp_get_attachment_image_src($attachment->ID, $img_id);

			$images[]=array(
				'src'=>$img_src[0]
			);


		}

		return $images;
	}
}


if ( !function_exists( 'pexeto_remove_gallery_from_content' ) ) {

	/**
	 * Strips the first gallery shortcode from the content of the item.
	 * @param  string $content the content to strip the shortcode from
	 * @return string          the content without the gallery shortcode.
	 */
	function pexeto_remove_gallery_from_content( $content ) {
		global $post;

		if(get_post_type( $post->ID )=='post' && get_post_format()=='gallery'){
			$pattern = '/\[.?gallery[^\]]*\]/';

			$content = preg_replace( $pattern, '', $content, 1 );
		}

		return $content;
	}
}


if ( !function_exists( 'pexeto_get_video_html' ) ) {

	/**
	 * Generates a video HTML. For Flash videos uses the standard flash embed code
	 * and for other videos uses the WordPress embed tag.
	 *
	 * @param string  $video_url the URL of the video
	 * @param string  $width     the width to set to the video
	 */
	function pexeto_get_video_html( $video_url, $width=590 ) {
		$video_html='';
		//check if it is a swf file
		if ( strstr( $video_url, '.swf' ) ) {
			//print embed code for swf file
			$video_html .= '<div class="video-wrap"><OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
			WIDTH="'.$width.'" id="pexeto-flash" ALIGN=""><PARAM NAME=movie VALUE="'.$video_url.'">
			<PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#333399> <EMBED src="'.$video_url.'"
			quality=high bgcolor=#333399 WIDTH="'.$width.'" NAME="pexeto-flash" ALIGN=""
			TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer">
			</EMBED> </OBJECT></div>';
		}else {
			$video_html .= apply_filters( 'the_content', '[embed width="'.$width.'"]' . $video_url . '[/embed]' );
		}
		return $video_html;
	}
}


add_theme_support( 'woocommerce' );



if(!function_exists('pexeto_add_body_class')){

	/**
	 * Adds additional classes to the body class
	 * @param  array $classes the default WordPress classes added to the body
	 * @return array          the modified classes
	 */
	function pexeto_add_body_class($classes){
		//sticky header
		if(get_opt( '_enable_cufon' )=='on'){
			$classes[]='cufon';
		}

		return $classes;
	}
}

add_filter('body_class', 'pexeto_add_body_class');


if ( !function_exists( 'pexeto_get_share_btns_html' ) ) {

	/**
	 * Generates the sharing buttons HTML code.
	 *
	 * @param int     $post_id      the ID of the post that the buttons will be
	 * added to
	 * @param string  $content_type the type of the containing element - can
	 * be a post, page, portfolio or slider
	 * @return string               the HTML code of the buttons
	 */
	function pexeto_get_share_btns_html( $post_id, $content_type ) {
		$show_share = get_opt( '_show_share_buttons' );
		if(empty($show_share)){
			return '';
		}
		$show_share_on = explode(',', $show_share);

		if ( !in_array( $content_type, $show_share_on ) ) {
			return '';
		}
		$buttons_opt = get_opt( '_share_buttons' );

		if(empty($buttons_opt)){
			return '';
		}

		$display_buttons = explode(',', $buttons_opt);


		$permalink = get_permalink( $post_id );
		$title = get_the_title( $post_id );
		$html = '<div class="social-share"><div class="share-title">'
			.pex_text('_share_text').'</div><ul>';

		foreach ( $display_buttons as $btn ) {
			switch ( $btn ) {
			case 'facebook':
				$html.='<li title="Facebook" class="share-item share-fb" data-url="'.$permalink
					.'" data-type="'.$btn.'" data-title="'.$title.'"></li>';
				break;

			case 'googlePlus':
				$html.='<li title="Google+" class="share-item share-gp" data-url="'.$permalink
					.'" data-lang="'.get_opt( '_gplus_lang' ).'" data-title="'.$title
					.'" data-type="'.$btn.'"></li>';
				break;

			case 'twitter':
				$html.='<li title="Twitter" class="share-item share-tw" data-url="'.$permalink
					.'" data-title="'.$title.'" data-type="'.$btn.'"></li>';
				break;

			case 'pinterest':
				$img = pexeto_get_preview_image( $post_id, $content_type );
				$html.='<li title="Pinterest" class="share-item share-pn" data-url="'.$permalink
					.'" data-title="'.$title.'" data-media="'.$img.'" data-type="'.$btn.'"></li>';
				break;

			case 'linkedin':
				$html.='<li title="LinkedIn" class="share-item share-ln" data-url="'.$permalink
					.'" data-type="linkedin" data-title="'.$title.'"></li>';
				break;
			}
		}

		$html.='</ul></div><div class="clear"></div>';

		return $html;
	}
}



if ( !function_exists( 'pexeto_get_featured_image_url' ) ) {

	/**
	 * Gets the URL of the featured image of a post.
	 *
	 * @param int     $pid the ID of the post
	 * @return string the URL of the image
	 */
	function pexeto_get_featured_image_url( $pid ) {
		$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $pid ), 'single-post-thumbnail' );
		return $attachment[0];
	}
}

if(!function_exists('pexeto_get_preview_image')){
	function pexeto_get_preview_image($post_id, $post_type){
		$image = '';
		if($post_type=='portfolio'){
			//get the preview image for porfolio items
			$image = get_post_meta( $post_id, 'preview_value', true );
			if(empty($image)){
				//no preview image was set, check for a thumbnail
				$image = get_post_meta( $post_id, 'thumbnail_value', true );
			}
		}

		if(empty($image)){
			//get the featured image
			$image = pexeto_get_featured_image_url($post_id);
		}

		return $image;
	}
}