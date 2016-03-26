<?php
get_header();

$subtitle='';
$slider='none';
$slider_prefix='';
$layout='right';
$sidebar='default';

//include the page header template
locate_template( array( 'includes/page-header.php' ), true, true );

?>

<div id="content-container" class="content-gradient <?php echo $layoutclass; ?> ">
	<div id="<?php echo $content_id; ?>">
 
    	<h1 class="page-heading"><?php the_title(); ?></h1><hr/>
    <?php 

		woocommerce_content();

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
