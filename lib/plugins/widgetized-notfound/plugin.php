<?php
/**
 * @package   Machina Widgetized Not Found & 404
 * @author    Machina Themes
 * @copyright Copyright (c) 2012-2013, Machina Themes
 *
 * Plugin Name: Machina Widgetized Not Found & 404
 * Description: Finally, use widgets to maintain and customize your 404 Error and Search Not Found pages in Machina Framework and Child Themes.
 * Version: 1.5.0
 * License: GPL-2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 * Text Domain: machina-widgetized-notfound
 * Domain Path: /languages/
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting constants.
 *
 * @since 1.0.0
 */

/** Plugin directory */
define( 'GWNF_PLUGIN_DIR', dirname( __FILE__ ) );


add_action( 'init', 'ddw_gwnf_setup', 1 );
/**
 * Setup: Register Widget Areas (Note: Has to be early on the "init" hook in order to display translations!).
 *
 * @since 1.0.0
 *
 * @uses  is_admin()
 *
 * @param bool 	$gwnf_bbpress_noresults_widgetized
 */
function ddw_gwnf_setup() {

	require_once( GWNF_PLUGIN_DIR . '/includes/gwnf-frontend.php' );
	require_once( GWNF_PLUGIN_DIR . '/includes/gwnf-widget-areas.php' );
	require_once( GWNF_PLUGIN_DIR . '/includes/gwnf-shortcodes.php' );

	/**
	 * Filter for custom disabling of the widgetized no search results area.
	 *
	 * Usage: add_filter( 'gwnf_filter_bbpress_noresults_widgetized', '__return_false' );
	 */
	$gwnf_bbpress_noresults_widgetized = (bool) apply_filters(
		'gwnf_filter_bbpress_noresults_widgetized',
		'__return_true'
	);

	/** For bbPress 2.3+: Load optional widgetized not found area */
	if ( $gwnf_bbpress_noresults_widgetized && function_exists( 'bbp_is_search' ) ) {

		require_once( GWNF_PLUGIN_DIR . '/includes/gwnf-bbpress-widgetized-noresults.php' );

		add_action( 'init', 'ddw_gwnf_bbpress_search_actions', 5 );

	}  // end-if filter & bbPress 2.3+ check

}  // end of function ddw_gwnf_setup


add_action( 'widgets_init', 'ddw_gwnf_register_widgets' );
/**
 * Register the widget, include plugin file.
 *
 * @since 1.5.0
 *
 * @uses  register_widget()
 */
function ddw_gwnf_register_widgets() {

	/** Load widget code part */
	require_once( GWNF_PLUGIN_DIR . '/includes/gwnf-widget-search.php' );

	/** Register the widget */
	register_widget( 'DDW_GWNF_Search_Widget' );

}  // end of function ddw_gwnf_register_widgets


