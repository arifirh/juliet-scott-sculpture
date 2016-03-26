<?php
/**
 * This file contains the functionality of the accordion slider.
 */


$navigation=get_opt( '_content_navigation' );
$showarrows=( $navigation!='none'&&$navigation!='buttons' )?"true":"false";
$showbuttons=( $navigation!='none'&&$navigation!='arrows' )?"true":"false";
$autoplay=get_opt( '_content_autoplay' )=='on'?"true":"false";
$interval=get_opt( '_content_interval' );
$pauseInterval=get_opt( '_content_pause' );
$pauseOnHover=get_opt( '_content_pause_hover' )=='on'?"true":"false";
$easing=get_opt( '_content_animation' );
?>

<script type="text/javascript">
(function($){
	$(document).ready(function(){
		$('#content-slider').pexetoSlider({buttons:<?php echo $showbuttons;?>,
										   arrows:<?php echo $showarrows;?>,
										   autoplay:<?php echo $autoplay; ?>,
										   animationInterval:<?php echo $interval;?>,
										   pauseInterval:<?php echo $pauseInterval;?>,
										   pauseOnHover:<?php echo $pauseOnHover; ?>,
										   easing:"<?php echo $easing; ?>"});
	});
})(jQuery);
</script>

<div class="center">
	<div id="content-slider-wrapper">
		<div id="content-slider" class="cs-loading">
			<ul id="slider-ul">


<?php

global $slider_prefix;

$sliderImagesArray=explode( PEXETO_SEPARATOR, get_option( $slider_prefix.'_content_image_names' ) );
$linkArray= explode( PEXETO_SEPARATOR, get_option( $slider_prefix.'_content_image_links' ) );
$titleArray= explode( PEXETO_SEPARATOR, get_option( $slider_prefix.'_content_image_titles' ) );
$descArray= explode( PEXETO_SEPARATOR, get_option( $slider_prefix.'_content_image_descs' ) );

$count=count( $sliderImagesArray );
$linkCount=count( $linkArray );

for ( $i=0;$i<$count-1;$i++ ) {


	if ( get_opt( '_content_auto_resize' )=='on' ) {
		$path=pexeto_get_resized_image( $sliderImagesArray[$i], 450, 280 );
	}else {
		$path=$sliderImagesArray[$i];
	}
	echo '<li><div class="slider-text">';
	if ( $titleArray[$i]!='' ) echo '<h2>'.stripslashes( $titleArray[$i] ).'</h2>';
	if ( $descArray[$i]!='' ) echo '<p>'.do_shortcode( stripslashes( $descArray[$i] ) ).'</p>';
	if ( $linkArray[$i]!='' ) echo '<a href="'.$linkArray[$i].'" class="button header-button"><span>'.pex_text( '_learn_more' ).'</span></a>';
	echo '</div><img src="'.$path.'" alt="" class="img-frame"></li>';

}
?>

			</ul>
		</div>
	</div>
</div>
