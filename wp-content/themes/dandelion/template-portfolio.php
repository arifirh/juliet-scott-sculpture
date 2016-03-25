<?php
/*
 Template Name: Portfolio Page
 */
get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		//get all the main settings for the page
		$pageTitle=get_the_title();
		$subtitle=get_post_meta( $post->ID, 'subtitle_value', true );
		$catId=get_post_meta( $post->ID, 'postCategory_value', true );
		$postNumberToShow=get_post_meta( $post->ID, 'postNumber_value', true );
		$slider=get_post_meta( $post->ID, "slider_value", $single = true );
		$slider_prefix=get_post_meta( $post->ID, 'slider_name_value', true );
		if ( $slider_prefix=='default' ) {
			$slider_prefix='';
		}
		$auto_thumbnail=get_post_meta( $post->ID, '_auto_portfolio_thumbnail_value', true );
		$order=get_post_meta( $post->ID, 'order_value', true );

		//include the page header template
		locate_template( array( 'includes/page-header.php' ), true, true );
	}
}
?>

<div id="content-container" class="content-gradient">

	<div id="portfolio-preview-container">
		<div class="loading"></div>
	</div>

	<?php
	//include the showcase template
	locate_template( array( 'includes/portfolio/portfolio-previewer.php' ), true, true );
	?>

	<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#portfolio-preview-container').portfolioPreviewer({
			itemnum:<?php echo $postNumberToShow; ?>,
			order:"<?php echo $order; ?>",
			prev:"<?php echo pex_text( '_previous_text' ); ?>",
			next:"<?php echo pex_text( '_next_text' ); ?>",
			more:"<?php echo pex_text( '_more_projects_text' ); ?>"
		});
	});
	</script>

    <div class="clear"></div>
</div>
<?php get_footer(); ?>
