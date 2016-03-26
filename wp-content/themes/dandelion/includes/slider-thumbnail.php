<?php
if ( get_opt( '_thum_autoplay' )=='true' || get_opt( '_thum_autoplay' )=='on' ) {
	$autoplay='true';
}else {
	$autoplay='false';
}
$interval=get_opt( '_thum_interval' );
$pauseInterval=get_opt( '_thum_pause' );
if ( get_opt( '_thum_pause_hover' )=='true' || get_opt( '_thum_pause_hover' )=='on' ) {
	$pauseOnHover='true';
}else {
	$pauseOnHover='false';
}

$img_per_scroll = pexeto_enable_responsive() ? 2 : 8;

?>

<script type="text/javascript">
	(function($){
	$(document).ready(function(){
		$('#slider').slider({
			thumbContainerId:'slider-navigation', 
			imgPerScroll:<?php echo $img_per_scroll; ?>,
			autoplay:<?php echo $autoplay; ?>, 
			interval:<?php echo $interval;?>, 
			pauseInterval:<?php echo $pauseInterval;?>, 
			pauseOnHover:<?php echo $pauseOnHover; ?>});
	});
})(jQuery);
</script>

<div id="slider-container">
	<div class="loading"></div>
    <div id="slider" class="thumbnail-slider">
      <div id="slider-container-shadow"></div>
		
			<?php
			global $slider_prefix;
			$separator='|*|';

			//get the slider data
			$sliderImagesString = get_option( $slider_prefix.'_thum_image_names' );
			$linkString=get_option( $slider_prefix.'_thum_image_links' );
			$descString=get_option( $slider_prefix.'_thum_image_descs' );
			if ( $descString=='' ) {
				$descString=get_option( $slider_prefix.'_thum_image_desc' );
			}

			$sliderImagesArray=explode( $separator, $sliderImagesString );
			$linkArray= explode( $separator, $linkString );
			$descArray= explode( $separator, $descString );

			$count=count( $sliderImagesArray );
			$linkCount=count( $linkArray );

			//print the slider items
			for ( $i=0;$i<$count-1;$i++ ) {

				if ( $i<$linkCount && $linkArray[$i]!='' ) {
					echo '<a href="'.$linkArray[$i].'">';
				}
				echo '<img src="';
				if ( get_opt( '_thum_auto_resize' )=='true' || get_opt( '_thum_auto_resize' )=='on' ) {
					$path=pexeto_get_resized_image( $sliderImagesArray[$i], 980, 370 );
				}else {
					$path=$sliderImagesArray[$i];
				}
				echo $path;
				echo '" alt=""';
				if ( $descArray[$i]!='' ) {
					echo ' title="'.esc_attr(stripslashes( $descArray[$i] )).'"';
				}
				if ( $i==0 ) {
					echo ' class="first"';
				}
				echo '/>';
				if ( $i<$linkCount && $linkArray[$i]!='' ) {
					echo '</a>';
				}
			}
			?>

 	</div>
 	</div>
    <div id="slider-navigation-container" class="center no-arrows">
      <div id="slider-navigation-wrapper">
        <div id="slider-navigation" >
      	  <div class="items">
	      	<?php
			$closed=true;
			for ( $i=0;$i<$count-1;$i++ ) {
				if ( $i%$img_per_scroll==0 ) {
					echo '<div>';
					$closed=false;
				}
				if ( get_opt( '_thum_auto_resize' )=='true' || get_opt( '_thum_auto_resize' )=='on' ) {
					echo '<img src="'.$path=pexeto_get_resized_image( $sliderImagesArray[$i], 110, 79 ).'" alt="" />';
				}else {
					echo '<img src="'.$sliderImagesArray[$i].'" alt="" />';
				}
				if ( ( $i+1 )%$img_per_scroll==0 ) {
					echo '</div>';
					$closed=true;
				}
			}
			if ( !$closed ) {
				echo '</div>';
			}
			?>
        </div>
      </div>
    </div>
  </div>
