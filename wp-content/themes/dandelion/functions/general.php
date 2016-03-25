<?php

$pexeto_separator='|*|';
add_theme_support('automatic-feed-links');
add_theme_support('menus');


/* ------------------------------------------------------------------------*
 * ENQUEUE SCRIPTS AND STYLES
 * ------------------------------------------------------------------------*/

if(!function_exists('pexeto_enqueue_styles')){
	function pexeto_enqueue_styles(){
		//INCLUDE THE STYLES
		$cssuri = get_template_directory_uri().'/css/';
		wp_enqueue_style('pexeto-pretty-photo', $cssuri.'prettyPhoto.css');
		wp_enqueue_style('pexeto-superfish', $cssuri.'superfish.css');
		wp_enqueue_style('pexeto-nivo-slider', $cssuri.'nivo-slider.css');
		wp_enqueue_style('pexeto-stylesheet', get_bloginfo('stylesheet_url'));
		wp_enqueue_style('pexeto-css-loader', $cssuri.'cssLoader.php');

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
		//INCLUDE THE SCRIPTS
		$jsuri=get_template_directory_uri().'/script/';

		wp_enqueue_script( "jquery" );
		wp_enqueue_script( "pexeto-pretty-photo", $jsuri.'jquery.prettyPhoto.js' );
		wp_enqueue_script( "pexeto-jquery-tools", $jsuri.'jquery.tools.min.js' );
		wp_enqueue_script( "pexeto-main", $jsuri.'script.js' );

		if ( is_page_template( 'template-portfolio-gallery.php' ) ) {
			//load the scripts for the portfolio gallery template
			wp_enqueue_script( "pexeto-gallery", $jsuri.'portfolio-setter.js' );
		}

		if ( is_page_template( 'template-portfolio.php' ) ) {
			//load the scripts for the portfolio showcase template
			wp_enqueue_script( "pexeto-portfolio", $jsuri.'portfolio-previewer.js' );
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
			wp_enqueue_script( "pexeto-slider", $jsuri.$slider_file);
		}
	}
}

add_action( 'wp_enqueue_scripts', 'pexeto_enqueue_scripts');


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
	function pexeto_get_resized_image($imgurl, $width, $height, $align='c'){
		if(function_exists('get_blogaddress_by_id')){
			global $blog_id;
			//this is a WordPress Network (multi) site
			$imgurl=get_blogaddress_by_id(1).str_replace(get_blog_option($blog_id,'fileupload_url'),
														get_blog_option($blog_id,'upload_path'),
														$imgurl);
		}
		return get_template_directory_uri().'/functions/timthumb.php?src='.$imgurl.'&h='.$height.'&w='.$width.'&zc=1&q=80&a='.$align;
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
				'pexeto_main_menu' => __( 'Main Menu' )
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

