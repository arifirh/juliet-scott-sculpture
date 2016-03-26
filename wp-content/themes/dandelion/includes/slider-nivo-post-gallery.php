<?php 
/**
 * Prints a Nivo slider as a post gallery
 */

global $post, $pexeto_nivo_sliders;

$images = pexeto_get_first_gallery_images($post);
$slider_id = 'nivo-post-'.$post->ID;
$pexeto_nivo_sliders[]=$slider_id;

?>

<div class="nivo-post-frame">
	<div class="nivoSlider nivo-post-slider" id="<?php echo $slider_id; ?>">

	<?php foreach ($images as $img) {
		?><img src="<?php echo $img['src']; ?>" /><?php
	} ?>

	</div>
</div>
<div class="clear"></div>

