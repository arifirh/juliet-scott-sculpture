<?php

if(!function_exists('pexeto_print_additional_css')){
	function pexeto_print_additional_css(){
		$pexeto_css = array(
			'skin'=>get_opt('_skin'),
			'custom_color'=>get_opt('_custom_skin'),
			'pattern'=>get_opt('_pattern'),
			'custom_pattern'=>get_opt('_custom_pattern'),
			'body_color' => get_opt('_body_color'),
			'body_bg' => get_opt('_body_bg'),
			'body_text_size' => get_opt('_body_text_size'),
			'logo_width' => get_opt('_logo_width'),
			'logo_height' => get_opt('_logo_height'),
			'link_color' => get_opt('_link_color'),
			'heading_color' => get_opt('_heading_color'),
			'menu_link_color' => get_opt('_menu_link_color'),
			'menu_link_hover' => get_opt('_menu_link_hover'),
			'boxes_color' => get_opt('_boxes_color'),
			'subtitle_color' => get_opt('_subtitle_color'),
			'content_text_color' => get_opt('_content_text_color'),
			'comments_bg' => get_opt('_comments_bg'),
			'footer_bg' => get_opt('_footer_bg'),
			'footer_text_color' => get_opt('_footer_text_color'),
			'footer_lines_color' => get_opt('_footer_lines_color'),
			'subtitle_bg' => get_opt('_subtitle_bg'),
			'content_bg_color' => get_opt('_content_bg_color'),
			'copyright_bg' => get_opt('_copyright_bg'),
			'copyright_text' => get_opt('_copyright_text'),
			'border_color' => get_opt('_border_color'),
			'heading_font_family'=>get_opt('_heading_font_family'),
			'body_font_family'=>get_opt('_body_font_family')
		);

		$css='<style type="text/css">';


		$pexeto_main_color=$pexeto_css['custom_color']==''?$pexeto_css['skin']:$pexeto_css['custom_color'];

		/**--------------------------------------------------------------------*
		 * SET THE BACKGROUND COLOR AND PATTERN
		 *---------------------------------------------------------------------*/

		if($pexeto_main_color!=''){
			$css.= 'body{background-color:#'.$pexeto_main_color.';}';
		}

		if($pexeto_css['custom_pattern']!='' || ($pexeto_css['pattern']!='' && $pexeto_css['pattern']!='none')){
			if($pexeto_css['custom_pattern']!=''){
			$css.= 'body{background-image:url("'.$pexeto_css['custom_pattern'].'");}';
			}elseif($pexeto_css['pattern']!='none'){
			$css.= 'body{background-image:url("'.get_bloginfo('template_url').'/images/patterns/'.$pexeto_css['pattern'].'");}';
			}else{
			$css.= 'body{background-image:none;}';
			}
		}


		if($pexeto_css['body_color']!=''){
			$css.= 'body, .sidebar-box ul li a,#portfolio-big-pagination a, #accordion .pane, #content-container .wp-pagenavi a, #content-container .wp-pagenavi span.pages{color:#'.$pexeto_css['body_color'].';}';
		}

		if($pexeto_css['body_bg']!=''){
			$css.= '#menu ul ul li, #menu ul li a:hover, #menu ul ul li a, img.shadow-frame, .blog-post-img img, #site, #nivo-controlNav-holder, #accordion .pane{background-color:#'.$pexeto_css['body_bg'].';}';
		}

		if($pexeto_css['body_text_size']!=''){
			$css.= 'body, .sidebar, .sidebar-box ul li a, #footer ul li a,#footer, .sidebar-post-info a, .no-caps, .post-info{font-size:'.$pexeto_css['body_text_size'].'px;}';
		}

		/**--------------------------------------------------------------------*
		 * SET THE LOGO
		 *---------------------------------------------------------------------*/

		if($pexeto_css['logo_width']!=''){
			$css.= '#logo-container img{width:'.$pexeto_css['logo_width'].'px;}';
		}

		if($pexeto_css['logo_height']!=''){
			$css.= '#logo-container img{height:'.$pexeto_css['logo_height'].'px;}';
			if(empty($pexeto_css['logo_width'])){
				$css.='#logo-container img{width:auto;}';
			}
		}

		/**--------------------------------------------------------------------*
		 * TEXT COLORS
		 *---------------------------------------------------------------------*/

		if($pexeto_css['link_color']!=''){
			$css.= 'a,.post-info, .post-info a{color:#'.$pexeto_css['link_color'].';}';
		}

		if($pexeto_css['heading_color']!=''){
			$css.= 'h1,h2,h3,h4,h5,h6,.sidebar-box h4,.services-box h4 span,.blog-post h1, .blog-post h1 a,.portfolio-sidebar h4, #portfolio-categories ul li, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, .services-box h4, .intro-text{color:#'.$pexeto_css['heading_color'].';}';
		}

		if($pexeto_css['menu_link_color']!=''){
			$css.= '#menu ul li a{color:#'.$pexeto_css['menu_link_color'].';}';
		}

		if($pexeto_css['menu_link_hover']!=''){
			$css.= '#menu ul li a:hover{color:#'.$pexeto_css['menu_link_hover'].';}';
		}

		if($pexeto_css['content_text_color']!=''){
			$css.= '#content-slider, #content-slider h2{color:#'.$pexeto_css['content_text_color'].';}';
		}

		if($pexeto_css['subtitle_color']!=''){
			$css.= '#page-title h6{color:#'.$pexeto_css['subtitle_color'].';}';
		}

		if($pexeto_css['footer_text_color']!=''){
			$css.= '#footer,#footer ul li a,#footer ul li a:hover,#footer h4{color:#'.$pexeto_css['footer_text_color'].';}';
		}

		if($pexeto_css['copyright_text']!=''){
			$css.= '#copyrights h5, #copyrights h5 a {color:#'.$pexeto_css['copyright_text'].';}';
		}

		/**--------------------------------------------------------------------*
		 * BACKGROUNDS
		 *---------------------------------------------------------------------*/

		if($pexeto_css['comments_bg']!=''){
			$css.= '.commentContainer{background-color:#'.$pexeto_css['comments_bg'].';}';
		}

		if($pexeto_css['footer_bg']!=''){
			$css.= '#footer-container {background-color:#'.$pexeto_css['footer_bg'].';}';
		}

		if($pexeto_css['border_color']!=''){
			$css.= 'hr, ul.blogroll li, .sidebar-box h4, .sidebar-box ul li, .post-info, img.img-frame, img.shadow-frame, img.attachment-post_box_img, #portfolio-categories,.nivo-post-frame,.format-aside, .format-quote, #menu ul ul li, #content-container .wp-pagenavi a, #content-container .wp-pagenavi span.pages{border-color:#'.$pexeto_css['border_color'].';}';
		}

		if($pexeto_css['subtitle_bg']!=''){
			$css.= '#page-title {background-color:#'.$pexeto_css['subtitle_bg'].';}';
		}

		if($pexeto_css['content_bg_color']!=''){
			$css.= '#content-slider-wrapper {background-color:#'.$pexeto_css['content_bg_color'].';}';
		}

		if($pexeto_css['copyright_bg']!=''){
			$css.= '#copyrights {background-color:#'.$pexeto_css['copyright_bg'].';}';
		}

		if($pexeto_css['footer_lines_color']!=''){
			$css.= '#footer-line{background-color:#'.$pexeto_css['footer_lines_color'].';}';
			$css.= '#footer .double-hr,#footer ul li a,#footer-line, #footer ul li{border-color:#'.$pexeto_css['footer_lines_color'].';}';
		}

		if($pexeto_css['boxes_color']!=''){
			$css.= '.pricing-box{background-color:#'.$pexeto_css['boxes_color'].';}';
		}


		/**--------------------------------------------------------------------*
		 * FONTS
		 *---------------------------------------------------------------------*/
		if($pexeto_css['heading_font_family']!=''){
			$css.= 'h1,h2,h3,h4,h5,h6,.accordion-description a,#portfolio-categories ul li.selected,.table-title td,.table-description strong,table th,.tabs a, .sidebar-box h4, #copyrights h5, a.button span, a.button span, #footer h4, .services-box h4, .pricing-box h4 {font-family:'.$pexeto_css['heading_font_family'].';}';
		}

		if($pexeto_css['body_font_family']!=''){
			$css.= 'body, .content-box .post-info, .no-caps, #content-container .wp-pagenavi, #content-container .wp-pagenavi span.pages, #content-container .wp-pagenavi a.last, cite, .commentDate, #footer, .wp-caption p.wp-caption-text, .gallery-caption, .showcase-item span, #portfolio-big-pagination, #portfolio-categories, .info_box, .note_box, .tip_box, .error_box, tip_box {font-family:'.$pexeto_css['body_font_family'].';}';
		}

		/**--------------------------------------------------------------------*
		 * ADDITIONAL STYLES
		 *---------------------------------------------------------------------*/

		if(get_opt('_additional_styles')!=''){
			$css.=(get_opt('_additional_styles'));
		}

		$css.='</style>';

		echo $css;
	}
}


?>