<?php
global $slider, $subtitle, $layout, $layoutclass, $content_id;

if ( $slider!='none' && $slider!='' ) {
	locate_template( array( 'includes/'.$slider.'.php' ), true, true );
}else {?>

<div id="page-title">
	<h6><?php echo $subtitle; ?></h6>
</div>

<?php }

//set the layout variables

$layoutclass='';
if ( $layout=='left' ) {
	$layoutclass='sidebar-to-left';
}

$content_id='content';
if ( $layout=='full' ) {
	$content_id='full-width';
}

?>
</div>
