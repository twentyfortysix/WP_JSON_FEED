<?php
/*
Plugin Name: 2046 JSON feed
Plugin URI: http://2046.cz
Description: Extra feed in JSON format.
Author: 2046
Version: 0.2
Author URI: http://2046.cz
*/

function f2046_get_json_feed() {
	header('Content-Type: text/html; charset=utf-8'); // <-- just for previe
	// header('Content-Type: application/json'); // <-- run if you wanna get the JSON proper header
	$output = array();

	// The Query
	if (have_posts()) :	
		// The Loop
		$i = 0;
		while ( have_posts() ) : 
			the_post();
			$excerpt = strip_tags(get_the_excerpt());
			$title = get_the_title();
			$link = get_permalink();

			$output[$i] = array(
				"id" => $post->ID,
				"title" => $title,
				"url" => $link,
				"excerpt" => $excerpt,
			);
			$i++;
		endwhile;
	endif;
	// give me the money babe	
	echo json_encode($output);
	
}

// ignite feed where we can get the function 	result
function f2046_add_json_feed() {
	add_feed('get_json_feed','f2046_get_json_feed');
}
add_action('init','f2046_add_json_feed');
