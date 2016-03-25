<?php
/**
 * Blog post template.
 */

global $excerpt;
?>

<div class="blog-post">
<h1>
<?php if(!is_single()){ ?>
<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
<?php }else{ ?>
<?php the_title(); ?>
<?php } ?>
</h1>

<?php if(get_opt('_blog_info')!='off' && $post->post_type!='portfolio'){?>
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
<?php }elseif(function_exists('has_post_thumbnail') && has_post_thumbnail()){?>
<br/>
<?php }
if(function_exists('has_post_thumbnail') && has_post_thumbnail()){ ?>
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
	the_content('');
	if(!is_single()){
		$ismore = @strpos( $post->post_content, '<!--more-->');
		if($ismore){?> <a href="<?php the_permalink(); ?>"><?php echo(pex_text('_read_more')); ?><span class="more-arrow">&raquo;</span></a>
	<?php 
		}
	}else{
		wp_link_pages();
	}
}else{
	the_excerpt();
}?> 
</div>
