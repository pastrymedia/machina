<?php
/**
 * Plugin Name: Machina Connect for Easy Digital Downloads
 * Plugin URI: http://machinathemes.com
 * Description: Integrate the Easy Digital Downloads plugin easily.
 * Version: 1.2.0
 * Author: Machina Themes
 * Author URI: http://machinathemes.com/
 * License: GPL-2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting constants.
 *
 * @since 1.0.0
 */

/** Plugin template directory */
define( 'GCEDD_TEMPLATE_DIR', dirname( __FILE__ ) . '/templates' );

/** Plugin lib directory */
define( 'GCEDD_LIB_DIR', dirname( __FILE__ ) . '/lib' );


add_action( 'init', 'ddw_gcedd_init', 1 );
/**
 * Load the text domain for translation of the plugin.
 * Load admin helper functions - only within 'wp-admin'.
 *
 * @since 1.0.0
 *
 * @uses  load_plugin_textdomain()
 * @uses  is_admin()
 * @uses  current_user_can()
 */
function ddw_gcedd_init() {

	/** Include needed helper logic/functions */
	require_once( GCEDD_LIB_DIR . '/gcedd-functions.php' );

}  // end of function ddw_gcedd_init


add_action( 'init', 'gcedd_register_widget_areas', 1 );
/**
 * Register additional widget areas
 *
 * Note: Has to be early on the "init" hook in order to display translations!
 *
 * @since 1.0.0
 *
 * @uses  get_template_directory()
 * @uses  machina_register_sidebar()
 */
function gcedd_register_widget_areas() {

		/** Add shortcode support to widgets */
		add_filter( 'widget_text', 'do_shortcode' );

		/** Set filter for "EDD Archive Top" widget title */
		$gcedd_archive_top_widget_title = apply_filters( 'gcedd_filter_archive_top_widget_title', __( 'EDD Archive Top', 'machina' ) );

		/** Set filter for "EDD Archive Top" widget description */
		$gcedd_archive_top_widget_description = apply_filters( 'gcedd_filter_archive_top_widget_description', __( 'This widget area appears at the top of the Downloads archive page/ template.', 'machina' ) );

		/** Register additional widget area/sidebar: on top of the Downloads Archive page */
		machina_register_sidebar(
			array(
				'id'          => 'gcedd-archive-top',
				'name'        => esc_attr__( $gcedd_archive_top_widget_title ),
				'description' => esc_attr__( $gcedd_archive_top_widget_description ),
			)
		);

		/** Set filter for "EDD Single After" widget title */
		$gcedd_single_after_widget_title = apply_filters( 'gcedd_filter_single_after_widget_title', __( 'EDD Single After', 'machina' ) );

		/** Set filter for "EDD Single After" widget description */
		$gcedd_single_after_widget_description = apply_filters( 'gcedd_filter_single_after_widget_description', __( 'This widget area appears after a single Download page content.', 'machina' ) );

		/** Register additional widget area/sidebar: after content section of a Download Single page */
		machina_register_sidebar(
			array(
				'id'          => 'gcedd-single-after',
				'name'        => esc_attr__( $gcedd_single_after_widget_title ),
				'description' => esc_attr__( $gcedd_single_after_widget_description ),
			)
		);

}  // end of function gcedd_register_widget_areas


add_action( 'after_setup_theme', 'ddw_gcedd_setup' );
/**
 * Setup Machina Connect for Easy Digital Downloads
 *
 * Checks whether Easy Digital Downloads and Machina Framework are active.
 * Once past these checks, loads the necessary files, actions and filters
 * for the plugin to do its thing.
 *
 * @since 1.0.0
 *
 * @uses  is_admin()
 * @uses  ddw_gcedd_download_cpt()
 */
function ddw_gcedd_setup() {

	/** Fail silently if Easy Digital Downloads is not activated */
	if ( ! in_array( 'easy-digital-downloads/easy-digital-downloads.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

		return;

	}  // end-if edd check


	/** The environment is now setup, let's do the awesome stuff :) */

	/** Load stuff only for the frontend */
	if ( ! is_admin() ) {

		/** Load the template files for "Download" post type */
		require_once( GCEDD_LIB_DIR . '/gcedd-template-loader.php' );

		/** Include needed frontend logic/functions */
		require_once( GCEDD_LIB_DIR . '/gcedd-frontend.php' );

		/** Adjust post meta info for "Downloads" */
		add_filter( 'machina_post_meta', 'gcedd_post_meta', 20 );

		/** Take control of the "Download" template loading */
		add_filter( 'template_include', 'ddw_gcedd_template_loader', 20 );

	}  // end-if frontend check

	/** Add Machina Layout and SEO options to "Download" edit screen */
	add_post_type_support( 'download', array( 'machina-layouts', 'machina-seo' ) );
	add_post_type_support( 'edd_download', array( 'machina-layouts', 'machina-seo' ) );

	/** Add plugin support for: Machina Simple Sidebars and Machina Simple Menus */
	add_post_type_support( 'download', array( 'machina-simple-sidebars', 'machina-custom-menus' ) );
	add_post_type_support( 'edd_download', array( 'machina-simple-sidebars', 'machina-custom-menus' ) );

}  // end of function ddw_gcedd_setup
