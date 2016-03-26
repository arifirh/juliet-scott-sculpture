<?php
/**
 * This file generates the portfolio items HTML.
 */

global $show_cat, $show_desc, $cat_id, $post_per_page, $title_link, 
		$auto_thumbnail, $column_number, $order, $pexetoImageSizes,
		$pexeto_custom_thumb_height;

//display the category filter if enabled
if ( $show_cat=='true' ) {
	echo '<div id="portfolio-categories">';
	$args=array("hide_empty"=>false, "hierarchical"=>true);
	if($cat_id!='-1'){
		$args['parent']=$cat_id;
	}
	$cats=get_terms('portfolio_category', $args);
	echo '<ul><li class="show-me">'.pex_text( '_showme_text' ).'</li><li class="all-cat">'.pex_text( '_all_text' ).'</li>';
	foreach($cats as $cat){
		echo '<li id="'.$cat->term_id.'" class="category">'.$cat->name.'</li>';
	}
	echo '</ul></div>';
}

echo '<div class="loading"></div><div class="items">';

//set the query_posts args
$args= array(
	'posts_per_page' =>-1,
	'post_type' => 'portfolio'
);

if ( $cat_id!='-1' ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'portfolio_category',
			'field' => 'term_id',
			'terms' => intval($cat_id)
		)
	);
}

//set the order arguments
if ( $order=='custom' ) {
	$args['orderby']='menu_order';
	$args['order']='asc';
}else {
	$args['orderby']='date';
	$args['order']='desc';
}


query_posts( $args );

$html='';

$imgWidth=$pexetoImageSizes[$column_number]['width'];

if(!empty($pexeto_custom_thumb_height) && intval($pexeto_custom_thumb_height)>0){
	$imgHeight = intval($pexeto_custom_thumb_height);
}else{
	$imgHeight=$pexetoImageSizes[$column_number]['height'];
}


if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();

		$post_title=get_the_title();
		$permalink=get_permalink();

		if ( $title_link=='on' ) {
			$title='<a href="'.$permalink.'" title="'.esc_attr($post_title).'">'.$post_title.'</a>';
		}else {
			$title=$post_title;
		}

		$description=get_post_meta( $post->ID, 'description_value', true );
		$descHtml=$show_desc=='true'?'<div class="item-desc" title="'.$post_title.'"><h4>'.$title.'</h4><hr/><p>'.$description.'</p></div>':'';
		//insert the description in the lightbox if descriptions are disabled
		$lightHtml=$show_desc=='true'?'':$description;
		$preview=get_post_meta( $post->ID, 'preview_value', true );
		$thumbnail=get_post_meta( $post->ID, 'thumbnail_value', true );

		if ( $auto_thumbnail=='on' ) {
			$align = get_post_meta($post->ID, 'crop_value', true);
			if(!$align){
				$align = 'c';
			}
			$thumbnail=pexeto_get_resized_image( $preview, $imgWidth, $imgHeight, $align, 200 );
		}

		$action=get_post_meta( $post->ID, 'action_value', true );
		$customlink=get_post_meta( $post->ID, 'custom_value', true );

		//set the link of the image depending on the action selected
		if ( $action=='nothing' ) {
			$openLink='';
			$closeLink='';
		}else if ( $action=='permalink' ) {
				$openLink='<a href="'.$permalink.'">';
				$closeLink='</a>';
			}else if ( $action=='custom' ) {
				$openLink='<a href="'.$customlink.'" target="_blank">';
				$closeLink='</a>';
			}else {
			$preview=$action=='video'?$customlink:$preview;
			$openLink='<a rel="lightbox[group]" class="single_image" href="'.$preview.'" title="'.esc_attr($lightHtml).'">';
			$closeLink='</a>';
		}

		//get the category IDs to which the items belong and generate a string
		//containing them, separated by commas, for example: 1,2,3
		$terms=wp_get_post_terms( $post->ID, 'portfolio_category' );
		$term_string='';
		foreach ( $terms as $term ) {
			$term_string.=( $term->term_id ).',';
		}
		$term_string=substr( $term_string, 0, strlen( $term_string )-1 );

		//generate the final item HTML
		$html.= '<div class="portfolio-item" style="width:'.($imgWidth+10).'px;" title="'.$term_string.'" >'.$openLink.'<img src="'.$thumbnail.'" class="img-frame" width="'.$imgWidth.'" height="'.$imgHeight.'" title="'.get_the_title().'"/>'.$closeLink.$descHtml.'</div>';
	}
}
echo $html;

echo '</div>';
