<?php
/**
 * Default page template.
 */
get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		//get the page settings
		$subtitle=get_post_meta( $post->ID, 'subtitle_value', true );
		$slider=get_post_meta( $post->ID, 'slider_value', $single = true );
		$slider_prefix=get_post_meta( $post->ID, 'slider_name_value', true );
		if ( $slider_prefix=='default' ) {
			$slider_prefix='';
		}
		$layout=get_post_meta( $post->ID, 'layout_value', true );
		if ( $layout=='' ) {
			$layout='right';
		}
		$show_title=get_opt( '_show_page_title' );
		$sidebar=get_post_meta( $post->ID, 'sidebar_value', $single = true );
		if ( $sidebar=='' ) {
			$sidebar='default';
		}

		//include the page header template
		locate_template( array( 'includes/page-header.php' ), true, true );
?>

<div id="content-container" class="content-gradient <?php echo $layoutclass; ?> ">
	<div id="<?php echo $content_id; ?>">
	<!--content-->
    <?php

		if ( $show_title!='off' ) {?>
    	<h1 class="page-heading"><?php the_title(); ?></h1><hr/>
    <?php }

		the_content();
		wp_link_pages();
		echo pexeto_get_share_btns_html($post->ID, 'page');
	}
}

?>

	</div> <!-- end content-->
<?php
if ( $layout!='full' ) {
	print_sidebar( $sidebar );
}
?>
	<div class="clear"></div>
</div> <!-- end #content-container-->

<?php get_footer(); ?>
