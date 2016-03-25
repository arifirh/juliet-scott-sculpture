<?php global $static_image; ?>
<div id="slider-container">
	<div id="slider-container-shadow"></div>
	<div id="static-header-img">
		<?php if ( is_page() ) {
			if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail() ) { 
				the_post_thumbnail( 'static-header-img' );
			}
		}elseif ( isset( $static_image ) ) { ?>
		<img src="<?php echo $static_image; ?>"/>
		<?php } ?>
	</div>
</div>
