<?php
/**
 * This is the index - blog page file. It prints all the blog posts.
 */
get_header();

//get the settings for the blog page
$subtitle = pex_text( "_posts_subtitle" );
$slider = get_opt( '_home_slider' );
$slider_prefix = get_opt( '_home_slider_name' );
if ( $slider_prefix == 'default' ) {
	$slider_prefix = '';
}
$layout = get_opt( '_blog_layout' );
$static_image = get_opt( '_blog_static_image' );

//include the page header template
locate_template( array( 'includes/page-header.php' ), true, true );
?>

<div id="content-container" class="content-gradient <?php echo $layoutclass; ?> ">
<div id="<?php echo $content_id; ?>"><?php

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		global $more;
		$more = 0;

		//include the post template
		locate_template( array( 'includes/post-template.php' ), true, false );

	}

	print_pagination();

}else {
	echo 'No posts available';
}

?>
</div>
<?php
if ( $layout != 'full' ) {
	print_sidebar( get_opt( '_blog_sidebar' ) );
}
?>

<div class="clear"></div>
</div>
<?php
get_footer();
?>
