<?php
/*
 Template Name: Home page
 */

get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		//get the page settings
		$title=get_the_title();
		$subtitle=get_post_meta( $post->ID, 'subtitle_value', true );
		$slider=get_post_meta( $post->ID, 'slider_value', true );
		$slider_prefix=get_post_meta( $post->ID, 'slider_name_value', true );
		if ( $slider_prefix=='default' ) {
			$slider_prefix='';
		}

		//include the page header template
		locate_template( array( 'includes/page-header.php' ), true, true );
?>

<div id="content-container" class="content-gradient">
  	<div id="full-width">
	   <!--content-->
    <?php
		the_content();
	}
} ?>

    	<div class="column-wrapper">
		<?php
		//print the services boxes
		for ( $i=1; $i<=3; $i++ ) {
			$suf=$i==3?'-3':''; ?>
			<div class="services-box three-columns<?php echo $suf; ?>">
				<h4><?php echo get_opt( '_home_box_title'.$i ); ?></h4>
				<?php if ( get_opt( '_home_box_icon'.$i )!='' ) { ?>
					<img src="<?php echo get_opt( '_home_box_icon'.$i ); ?>" class="img-frame" />
				<?php } ?>
				<?php echo get_opt( '_home_box_desc'.$i ); ?>
				<?php if ( trim( get_opt( '_home_box_btn_text'.$i ) )!='' ) { ?>
					<a href="<?php echo get_opt( '_home_box_btn_link'.$i ); ?>" ><?php echo get_opt( '_home_box_btn_text'.$i ); ?><span class="more-arrow">&raquo;</span></a>
				<?php } ?>
			</div>
		<?php } ?>
		</div>
	</div>
<div class="clear"></div>
</div>
<?php get_footer(); ?>
