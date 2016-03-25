<?php
get_header();

$subtitle='';
$slider='none';
$layout=get_opt( '_blog_layout' );
if ( $layout=='' ) {
	$layout='right';
}

//include the page header template
locate_template( array( 'includes/page-header.php' ), true, true );
?>

<div id="content-container" class="content-gradient <?php echo $layoutclass; ?> ">
	<div id="<?php echo $content_id; ?>">

	<h2><?php echo pex_text( '_404_text' ); ?></h2>

	</div>
	<?php
	if ( $layout!='full' ) {
		print_sidebar( get_opt( '_blog_sidebar' ) );
	}
	?>
	<div class="clear"></div>
</div>
<?php
get_footer();
?>
