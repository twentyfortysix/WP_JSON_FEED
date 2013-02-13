<?php
/*
Plugin Name: 2046 JSON feed
Plugin URI: http://2046.cz
Description: Extra feed in JSON format.
Author: 2046
Version: 0.1
Author URI: http://2046.cz
*/

 //  add url variable
// function f2046_add_json_feed_variable( $qvars ){
// 	$qvars[] = 'json_feed_var';
// 	return $qvars;
// }
// add_filter('query_vars', 'f2046_add_json_feed_variable' );

// get the subtitles for a post with given custom_meta
function f2046_get_json_feed() {
	header('Content-Type: text/html; charset=utf-8');
	global $post, $wp_query;
	// mydump($wp_query->posts);
	// clean the variable 
	$output = '';
	$title = '';
	$link = '';
	$image = array();
	$excerpt = '';

	
	// The Query
	if (have_posts()) :	
		$output = "{\n";
		// The Loop
		while ( have_posts() ) : 
				the_post();
				$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
				$excerpt = strip_tags(get_the_excerpt());
				$title = get_the_title();
				$link = get_permalink();
				
				$output .= '
	"'.$post->ID.'" : {
		"title" : "'.$title.'",
		"link" : "'.$link.'",
		"image" : "'.$image[0].'",
		"excerpt" : "'.$excerpt.'"
	}';
				if($post != end($wp_query->posts)){
					$output .= ",\n";
				}
		endwhile;
		$output .= "\n}";
	endif;
	echo $output;
	// Restore original Query & Post Data
	wp_reset_query();
	wp_reset_postdata();
}

// ignite feed where we can get the function 	result
function f2046_add_json_feed() {
	add_feed('get_json_feed','f2046_get_json_feed');
}
add_action('init','f2046_add_json_feed');