<?php
/**
 * Blog post template.
 */

global $excerpt;
$format = get_post_format();
$show_info = get_opt('_blog_info')!='off' && $post->post_type!='portfolio' ? true : false;
$info_class = $show_info ? 'show-post-info' : 'no-post-info';
$post_classes = array('blog-post', $info_class);

?>

<div <?php post_class( $post_classes ); ?>>

<?php 
	if($format=='quote'){
		//PRINT A QUOTE
		?>
		<blockquote><?php the_content(); ?></blockquote>
		<?php
	}elseif($format=='aside'){
		//PRINT ASIDE
		?>
		<div class="aside"><?php the_content(); ?></div>
		<?php
	}else{
		//ALL OTHER POST FORMATS
 ?>

	<h1>
	<?php if(!is_single()){ ?>
	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	<?php }else{ ?>
	<?php the_title(); ?>
	<?php } ?>
	</h1>

	<?php if($show_info){?>
	<div class="post-info">
	<ul>
		<li><span class="no-caps"> <?php echo(pex_text('_at_text')); ?></span> <a><?php echo get_the_date('F d, Y'); ?></a></li>
		<li><span class="no-caps"> <?php echo(pex_text('_by_text')); ?></span> <?php the_author_posts_link(); ?>
		</li>
		<?php 
		//print the category
		$cat = get_the_category();
		if(!empty($cat)){ ?>
			<li class="post-info-categories"><span class="no-caps"> <?php echo(pex_text('_in_text')); ?> </span><?php the_category(', ');?></li>
		<?php } ?>
		<li class="post-info-comments"><img src="<?php echo get_template_directory_uri(); ?>/images/comm.png" /><a
			href="<?php the_permalink();?>#comments"> <?php comments_number('0', '1', '%'); ?>
		</a></li>

	</ul>

	</div>
	<div class="clear"></div>
	<?php }

	if ( $format == 'gallery' ) {
		//PRINT A GALLERY
		locate_template( array( 'includes/slider-nivo-post-gallery.php' ), true, false );
	}elseif($format == 'video'){
		//PRINT A VIDEO
	 ?>
		<div class="post-video-wrapper">
			<div class="post-video">
				<?php
				$video_width = get_opt('_blog_layout')=='full' ? 900 : 590;
				$video_url = get_post_meta( $post->ID, 'video_url_value', true );
				if ( $video_url ) {
					echo pexeto_get_video_html( $video_url, $video_width);
				}
				?>
			</div>
		</div><?php

	}elseif(function_exists('has_post_thumbnail') && has_post_thumbnail()){ 
		//PRINT THE FEATURED IMAGE
		?>
		<div class="blog-post-img">
		<?php if(!is_single()){?>
		<a href="<?php the_permalink(); ?>">
		<?php } ?>
		 <?php the_post_thumbnail('post_box_img'); 
		 if(!is_single()){
		 ?>
		</a>
		<?php }?>
		</div>
	<?php } ?>

	<?php
	if(!$excerpt){

		if($format!='gallery'){
			the_content('');
		}else{
			//it is a gallery post format, strip the first gallery from the content
			if(!is_single()){
				global $more;
				$more = 0;
			}
			$content = pexeto_remove_gallery_from_content(get_the_content(''));
			echo apply_filters('the_content', $content );
		}


		if(!is_single()){
			$ismore = @strpos( $post->post_content, '<!--more-->');
			if($ismore){?> <a href="<?php the_permalink(); ?>"><?php echo(pex_text('_read_more')); ?><span class="more-arrow">&raquo;</span></a>
		<?php 
			}
		}else{
			wp_link_pages();
			echo pexeto_get_share_btns_html($post->ID, 'post');
		}
	}else{
		the_excerpt();
	}

}  //end if for post format
?> 
<div class="clear"></div>
</div>
