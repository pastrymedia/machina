<?php
/**
 * Register additional widget areas.
 *
 * @package    Machina Widgetized Not Found & 404
 * @subpackage Widgets
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


add_action( 'init', 'ddw_gwnf_register_widget_areas' );
/**
 * Register additional widget areas.
 *
 * Note: Has to be early on the "init" hook in order to display translations!
 *
 * @since 1.0.0
 *
 * @uses  is_admin()
 * @uses  machina_register_sidebar()
 *
 * @param string 	$gwnf_404_widget_title
 * @param string 	$gwnf_404_widget_description
 * @param string 	$gwnf_notfound_widget_title
 * @param string 	$gwnf_notfound_widget_description
 */
function ddw_gwnf_register_widget_areas() {

	/** Add shortcode support to widgets */
	if ( ! is_admin() ) {

		add_filter( 'widget_text', 'do_shortcode' );

	}  // end-if constant & !is_admin() check

	/** Set filter for "404 Error Page" widget title */
	$gwnf_404_widget_title = apply_filters(
		'gwnf_filter_404_widget_title',
		__( '404 Error Page', 'machina-widgetized-notfound' )
	);

	/** Set filter for "404 Error Page" widget description */
	$gwnf_404_widget_description = apply_filters(
		'gwnf_filter_404_widget_description',
		__( 'This is the widget area of the 404 Not Found Error Page.', 'machina-widgetized-notfound' )
	);

	/** Register the "404 Error Page" widget area */
	machina_register_sidebar(
		array(
			'id'            => 'gwnf-404-widget',
			'name'          => $gwnf_404_widget_title,
			'description'   => $gwnf_404_widget_description,
			'before_widget' => '<div id="%1$s" class="gwnf-404 widget-area %2$s">',
			'after_widget'  => '</div>',
		)
	);

	/** Set filter for "Search Not Found" widget title */
	$gwnf_notfound_widget_title = apply_filters(
		'gwnf_filter_notfound_widget_title',
		__( 'Search Not Found', 'machina-widgetized-notfound' )
	);

	/** Set filter for "Search Not Found" widget description */
	$gwnf_notfound_widget_description = apply_filters(
		'gwnf_filter_notfound_widget_description',
		__( 'This is the widget area of the search not found content section.', 'machina-widgetized-notfound' )
	);

	/** Register the "Search Not Found" widget area */
	machina_register_sidebar(
		array(
			'id'            => 'gwnf-notfound-widget',
			'name'          => $gwnf_notfound_widget_title,
			'description'   => $gwnf_notfound_widget_description,
			'before_widget' => '<div id="%1$s" class="gwnf-notfound widget-area %2$s">',
			'after_widget'  => '</div>',
		)
	);

}  // end of function ddw_gwnf_register_widget_areas