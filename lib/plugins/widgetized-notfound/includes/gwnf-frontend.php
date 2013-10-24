<?php
/**
 * Functions & logic for the frontend display.
 *
 * @package    Machina Widgetized Not Found & 404
 * @subpackage Frontend
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 *
 * @since      1.0.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'machina_meta', 'gwnf_404_content' );
/**
 * Add the new widgetized 404 Error Page content.
 *
 * @since 1.0.0
 *
 * @uses  is_404()
 * @uses  is_active_sidebar()
 */
function gwnf_404_content() {

	if ( is_404() && is_active_sidebar( 'gwnf-404-widget' ) ) {

		remove_action( 'machina_loop', 'machina_404' );
		add_action( 'machina_loop', 'gwnf_display_404_widget' );

	}  // end-if

}  // end of function gwnf_404_content


/**
 * Display the "404 Error Page" widget area.
 *
 * @since 1.0.0
 *
 * @uses  dynamic_sidebar()
 */
function gwnf_display_404_widget() {

	echo '<div id="gwnf-404-area" class="gwnf-area">';
		dynamic_sidebar( 'gwnf-404-widget' );
	echo '</div><!-- end #gwnf-404-area -->';

}  // end of function gwnf_display_404_widget


add_action( 'machina_meta', 'gwnf_notfound_content' );
/**
 * Logic for "Search Not Found" status.
 *
 * @since 1.5.0
 *
 * @uses  is_404()
 * @uses  is_search()
 * @uses  is_active_sidebar()
 */
function gwnf_notfound_content() {

	/** Display active widget area "Search Not Found" */
	if ( ! is_404() && is_search() ) {

		/** First, remove default Machina behaviour */
		remove_action( 'machina_loop_else', 'machina_do_noposts' );

		if ( is_active_sidebar( 'gwnf-notfound-widget' ) ) {

			/** Add widgetized area, if active */
			add_action( 'machina_loop_else', 'gwnf_display_notfound_widget' );

		} else {

			/** Otherwise, add our modified no posts/ nocontent status */
			add_action( 'machina_loop_else', 'gwnf_nocontent_status' );

		}  // end-if sidebar check

	}  // end-if status check

}  // end of function gwnf_notfound_content


/**
 * Display the "Search Not Found" widget area.
 *
 * @since 1.5.0
 *
 * @uses  dynamic_sidebar()
 */
function gwnf_display_notfound_widget() {

	echo '<div id="gwnf-notfound-area" class="gwnf-area">';
		dynamic_sidebar( 'gwnf-notfound-widget' );
	echo '</div><!-- end #gwnf-notfound-area -->';

}  // end of function gwnf_display_notfound_widget


/**
 * Modify the no content text, adding search form.
 *
 * @since 1.0.0
 *
 * @param string 	$gwnf_notfound_default
 */
function gwnf_nocontent_status() {

	/** Set filter for default "Search Not Found" message */
	$gwnf_notfound_default = apply_filters(
		'gwnf_filter_notfound_default',
		__( 'Sorry, no content matched your criteria. Try a different search?', 'machina-widgetized-notfound' )
	);

	printf(
		'<div class="gwnf-notfound-default gwnf-area">%1$s</div>
		<br />
		<div class="gwnf-search-area gwnf-area">%2$s</div>',
		$gwnf_notfound_default,
		get_search_form( $echo = FALSE )
	);

}  // end of function gwnf_nocontent_status


/**
 * Helper function for setting a Machina layout option for the '404' case.
 *
 * Usage: add_action( 'machina_meta', '__gwnf_layout_404_full_width' );
 *
 * @since 1.1.0
 *
 * @uses  is_404()
 */
function __gwnf_layout_404_full_width() {

	/** Apply the full-width layout in case of "404 Error Page" */
	if ( is_404() ) {

		add_filter( 'machina_pre_get_option_site_layout', '__machina_return_full_width_content' );

	}  // end-if

}  // end of function __gwnf_layout_404_full_width


/**
 * Helper function for setting a Machina layout option for the 'search not found' case.
 *
 * Usage: add_action( 'machina_meta', '__gwnf_layout_searchnotfound_full_width' );
 *
 * @since  1.1.0
 *
 * @uses   is_search()
 *
 * @global mixed $wp_query
 */
function __gwnf_layout_searchnotfound_full_width() {

	/** Set global */
	global $wp_query;

	/** Apply the full-width layout in case of search not found page */
	if ( is_search() && empty( $wp_query->posts ) ) {

		add_filter( 'machina_pre_get_option_site_layout', '__machina_return_full_width_content' );

	}  // end-if

}  // end of function __gwnf_layout_searchnotfound_full_width