<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head>
<meta http-equiv="Content-Type"
	content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<title>
<?php if ( is_home() ) {
	echo bloginfo( 'name' );
} elseif ( is_category() ) {
	echo pex_text( '_category_text' ).' &raquo; ';
	wp_title( '&laquo; @ ', TRUE, 'right' );
	echo bloginfo( 'name' );
} elseif ( is_tag() ) {
	echo pex_text( '_tag_text' ).' &raquo; ';
	wp_title( '&laquo; @ ', TRUE, 'right' );
	echo bloginfo( 'name' );
} elseif ( is_search() ) {
	echo pex_text( '_search_results_text' ).' &raquo; ';
	echo the_search_query();
	echo '&laquo; @ ';
	echo bloginfo( 'name' );
} elseif ( is_404() ) {
	echo '404 '; wp_title( ' @ ', TRUE, 'right' );
	echo bloginfo( 'name' );
} else {
	echo wp_title( ' @ ', TRUE, 'right' );
	echo bloginfo( 'name' );
} ?>
</title>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS" href="<?php bloginfo( 'rss2_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if ( get_opt( '_favicon' ) ) { ?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_opt( '_favicon' ); ?>" />
<?php } 


//print the Facebook and Google+ meta tags to include the featured/preview image
//of the post/page when it is shared
global $post;
if(is_singular() && isset($post)){
	$image = pexeto_get_preview_image($post->ID, $post->post_type);

	if(!empty($image)){
	?>
<!-- facebook meta tag for image -->
<meta property="og:image" content="<?php echo $image; ?>"/>
<!-- Google+ meta tag for image -->
<meta itemprop="image" content="<?php echo $image; ?>">
<?php } 
}


wp_head();

$enable_cufon=get_opt( '_enable_cufon' );
?>

<!-- Mobile Devices Viewport Resset-->
<?php if(pexeto_enable_responsive()){ ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0">
<?php } ?>
<meta name="apple-mobile-web-app-capable" content="yes">


<script type="text/javascript">
pexetoSite.enableCufon="<?php echo $enable_cufon; ?>";
pexetoSite.ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>";
pexetoSite.lightboxOptions = <?php echo json_encode( pexeto_get_lightbox_options() ); ?>;
<?php $responsive = pexeto_enable_responsive() ? "true" : "false"; ?>
pexetoSite.isResponsive = <?php echo $responsive; ?>;
jQuery(document).ready(function($){
	pexetoSite.initSite();
});
</script>


<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<!-- enables nested comments in WP 2.7 -->


<!--[if lte IE 6]>
<link href="<?php echo get_template_directory_uri(); ?>/css/style_ie6.css" rel="stylesheet" type="text/css" />
 <input type="hidden" value="<?php echo get_template_directory_uri(); ?>" id="baseurl" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script/supersleight.js"></script>
<![endif]-->

<!--[if IE 7]>
<link href="<?php echo get_template_directory_uri(); ?>/css/style_ie7.css" rel="stylesheet" type="text/css" />
<![endif]-->


<?php 
$google_analytics = get_opt('_analytics');
if($google_analytics){
	echo($google_analytics);
}
?>

<!-- Custom Theme CSS -->
<?php pexeto_print_additional_css(); ?>


</head>

<body <?php body_class(); ?>>
	<div id="main-container">
		<div class="center">
			<div id="site">
				<div id="header" >
					<div id="header-top">
						<?php 
							$logo_image = get_opt('_logo_image');
							if(empty($logo_image)){
								$logo_image=get_template_directory_uri().'/images/logo.png';
							}
						 ?>
						<div id="logo-container" class="center">
							<a href="<?php echo home_url(); ?>">
								<img src="<?php echo $logo_image; ?>" />
							</a>
						</div>
						<div id="menu-container">
							<div id="menu">
							<?php wp_nav_menu( array( 'theme_location' => 'pexeto_main_menu' ) ); ?>
							</div>
						</div>
						<?php if(pexeto_enable_responsive()){ ?>
						<div class="mobile-nav">
							<span class="mob-nav-btn"><?php echo(pex_text('_menu_text')); ?></span>
						</div>
						<?php } ?>
						<div class="clear"></div>
					</div>
