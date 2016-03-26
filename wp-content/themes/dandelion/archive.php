<?php
get_header();

$subtitle=pex_text( "_posts_subtitle" );
$slider='none';
$layout=get_opt( '_blog_layout' );

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
	echo pex_text('_no_posts_text');
}

?>
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
