<?php
/*
Plugin Name: Co-Authors Plus
Plugin URI: http://www.machinathemes.com
Description: Enables full support for the Co-Authors Plus plugin
Version: 1.2
Author: Machina Themes
Author URI: http://www.machinathemes.com
License: GPLv3
*/

/** Add guest author without user profile functionality via the following functions */


/**
 * Post Authors Post Link Shortcode
 *
 * @param array $atts
 * @return string $authors
 */
function be_post_authors_post_link_shortcode( $atts ) {

	$atts = shortcode_atts( array(
		'between'      => null,
		'between_last' => null,
		'before'       => null,
		'after'        => null
	), $atts );

	$authors = function_exists( 'coauthors_posts_links' ) ? coauthors_posts_links( $atts['between'], $atts['between_last'], $atts['before'], $atts['after'], false ) : $atts['before'] . get_author_posts_url() . $atts['after'];
	return $authors;
}
add_shortcode( 'post_authors_post_link', 'be_post_authors_post_link_shortcode' );


/**
 * List Authors in Machina Post Info
 *
 * @param string $info
 * @return string $info
 */
function be_post_info( $info ) {
	$info = '[post_authors_post_link before="by "]';
	return $info;
}
add_filter( 'machina_post_info', 'be_post_info' );


/**
 * Remove Machina Author Box and load our own
 *
 */
function jg_coauthors_init() {
	remove_action( 'machina_after_entry', 'machina_do_author_box_single', 8 );
	add_action( 'machina_after_entry', 'jg_author_box', 1 );
}
add_action( 'init', 'jg_coauthors_init' );


/**
 * Load Author Boxes
 *
 */
function jg_author_box() {

	if( ! is_single() )
		return;

	if( function_exists( 'get_coauthors' ) ) {

		$authors = get_coauthors();
		foreach( $authors as $author )
			jg_do_author_box( 'single', $author );

	} else {
		jg_do_author_box( 'single', get_the_author_ID() );
	}
}


/**
 * Display Author Box
 * Modified from Machina to use data from get_coauthors() function
 *
 */
function jg_do_author_box( $context = '', $author ) {

	if( ! $author )
		return;

	$gravatar_size = apply_filters( 'machina_author_box_gravatar_size', 70, $context );
	$gravatar      = get_avatar( $author->user_email , $gravatar_size );
	$title         = apply_filters( 'machina_author_box_title', sprintf( '<strong>%s %s</strong>', __( 'About', 'machina' ), $author->display_name  ), $context );
	$description   = wpautop( $author->description );

	/** The author box markup, contextual */
	$pattern = $context == 'single' ? '<div class="author-box"><div>%s %s<br />%s</div></div><!-- end .authorbox-->' : '<div class="author-box">%s<h1>%s</h1><div>%s</div></div><!-- end .authorbox-->';

	echo apply_filters( 'machina_author_box', sprintf( $pattern, $gravatar, $title, $description ), $context, $pattern, $gravatar, $title, $description );
}
