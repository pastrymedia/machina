<?php
/*
Plugin Name: Connect for WooCommerce
Plugin URI: http://www.machinathemes.com
Version: 0.9.5
Author: Machina Themes
Author URI: http://www.machinathemes.com/
Description: Allows you to seamlessly integrate WooCommerce.

License: GNU General Public License v2.0 (or later)
License URI: http://www.opensource.org/licenses/gpl-license.php

*/


/** Define the Connect for WooCommerce constants */
define( 'GCW_TEMPLATE_DIR', dirname( __FILE__ ) . '/templates' );
define( 'GCW_LIB_DIR', dirname( __FILE__ ) . '/lib');



add_action( 'after_setup_theme', 'gencwooc_setup' );
/**
 * Setup GCW
 *
 * Checks whether WooCommerce is active, then checks if relevant
 * theme support exists. Once past these checks, loads the necessary
 * files, actions and filters for the plugin to do its thing.
 *
 * @since 0.9.0
 */
function gencwooc_setup() {

	/** Fail silently if WooCommerce is not activated */
	if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
		return;

	/** Fail silently if theme doesn't support GCW */
	if ( ! current_theme_supports( 'machina-connect-woocommerce' ) )
		return;

	/** Environment is OK, let's go! */

	global $woocommerce;

	/** Load GCW files */
	require_once( GCW_LIB_DIR . '/template-loader.php' );

	/** Load modified Machina breadcrumb filters and callbacks */
	if ( ! current_theme_supports( 'gencwooc-woo-breadcrumbs') )
		require_once( GCW_LIB_DIR . '/breadcrumb.php' );

	/** Ensure WooCommerce 2.0+ compatibility */
	add_theme_support( 'woocommerce' );

	/** Add Machina Layout and SEO options to Product edit screen */
	add_post_type_support( 'product', array( 'machina-layouts', 'machina-seo' ) );

	/** Add plugins support */
	add_post_type_support( 'product', array( 'machina-simple-sidebars', 'machina-custom-menus' ) );

	/** Take control of shop template loading */
	remove_filter( 'template_include', array( &$woocommerce, 'template_loader' ) );
	add_filter( 'template_include', 'gencwooc_template_loader', 20 );

}

/**
 * Integration - Machina Simple Menus
 *
 * @package machina_connect_woocommerce
 * @version 0.9.5
 * @since 0.9.0
 *
 * Machina Simple Menus (GSM) version 0.1.4
 *
 * What GCW integration needs to do:
 * 	1. add_post_type_support for 'machina-custom-menus'
 * 	2. deal with serving correct GSM menu for Shop page (product archive)
 *
 * What GCW does:
 * 	1. GCW adds post_type_support for GSM - see gencwooc_setup()
 *	2. uses Machina filters to intercept request and serve correct GSM menu on Shop Page
 *
 * Note: this file is loaded on the 'after_theme_setup' hook only if GSM
 * is activated.
 * @see gencwooc_setup() in machina-connect-woocommerce.php
 *
 */

add_filter( 'machina_pre_get_option_subnav_type', 'gencwooc_gsm_subnav_type', 9 );
/**
 * Tells Machina to load a custom menu
 *
 * @since 0.9.0
 *
 * @see Machina_Simple_Menus::wp_head()
 * @param str $nav
 * @return str 'nav-menu' which tells Machina to get a custom menu
 */
function gencwooc_gsm_subnav_type( $nav ) {
	return 'nav-menu';
}


add_filter( 'theme_mod_nav_menu_locations', 'gencwooc_gsm_theme_mod' );
/**
 * Replace the menu selected in the WordPress Menu settings with the custom one for this request
 *
 * @since 0.9.0
 *
 * @see Machina_Simple_Menus::wp_head()
 * @param array $mods Array of theme mods
 * @return array $mods Modified array of theme mods
 */
function gencwooc_gsm_theme_mod( $mods ) {

	/** Post meta key as per GSM 0.1.4 */
	$field_name = '_gsm_menu';

	$shop_id = woocommerce_get_page_id( 'shop' );

	if ( is_post_type_archive( 'product' ) && $_menu = get_post_meta( $shop_id, $field_name, true ) )
		$mods['secondary'] = (int) $_menu;

	return $mods;

}

/**
 * Integration - Machina Simple Sidebars
 *
 * @package machina_connect_woocommerce
 * @version 0.9.5
 *
 * @since 0.9.0
 *
 * Based on Machina Simple Sidebars (GSS) version 0.9.2
 *
 * What GCW integration needs to do:
 * 	1. add_post_type_support for 'machina-simple-sidebars'
 * 	2. deal with serving correct GSS sidebar(s) for Shop page (product archive)
 *
 * What GCW does:
 * 	1. GCW adds post_type_support for GSS - see gencwooc_setup()
 *	2. intercepts GSS sidebar loading functions, deals with Shop Page,
 * then hands back control of sidebar loading in all other cases to GSS
 *
 * Note: this file is loaded on the 'after_theme_setup' hook only if GSS
 * is activated.
 * @see gencwooc_setup() in machina-connect-woocommerce.php
 *
 * @TODO simply these functions
 */


add_action( 'get_header', 'gencwooc_ss_handler', 11 );
/**
 * Take control of GSS sidebar loading
 *
 * Hooked to 'get_header' with priority of 11 to ensure that GSS's
 * actions, which are unhooked here in this function, have been added
 * and therefore can be removed.
 *
 * Unhooks GSS ss_do_sidebar() and ss_do_sidebar_alt() functions and
 * hooks GCW versions of these functions to the same hooks instead.
 * @see GSS ss_sidebars_init() in machina-simple-sidebars/plugin.php
 *
 * Note for developers:
 * ====================
 * If you want to do more complex manipulations of sidebars, eg load another one
 * altogether (ie not a GSS sidebar, G Sidebar or G Sidebar Alt), unhook this
 * function and replace it with your own version.
 *
 * @since 0.9.0
 *
 */
function gencwooc_ss_handler() {

	/** Unhook GSS functions */
	remove_action( 'machina_sidebar', 'ss_do_sidebar' );
	remove_action( 'machina_sidebar_alt', 'ss_do_sidebar_alt' );

	/** Hook replacement functions */
	add_action( 'machina_sidebar', 'gencwooc_ss_do_sidebar' );
	add_action( 'machina_sidebar_alt', 'gencwooc_ss_do_sidebar_alt' );

}


/**
 * Callback for dealing with Primary Sidebar loading
 *
 * Intercepts GSS code flow, so that Shop page can be dealt with, then
 * hands back control to the GSS function for loading primary sidebars.
 * Effectively, it's just a more complex version of ss_do_sidebar()
 *
 * Checks if we're on the product archive and a GSS sidebar has been
 * assigned in the Shop WP Page editor, then, if both true, loads the relevant
 * GSS sidebar on the Shop Page.
 * If either of the above conditions return false, we hand back control to GSS
 * by executing the normal ss_do_one_sidebar() function.
 *
 * @since 0.9.0
 *
 * @uses woocommerce_get_page_id()
 *
 */
function gencwooc_ss_do_sidebar() {

	$bar = '_ss_sidebar';
	$shop_id = woocommerce_get_page_id( 'shop' );

	if ( is_post_type_archive( 'product' ) && $_bar = get_post_meta( $shop_id, $bar, true ) ) {

		dynamic_sidebar( $_bar );

	} else {

		/** Hand back control to GSS */
		if ( ! ss_do_one_sidebar( $bar ) )
			machina_do_sidebar();

	}
}


/**
 * Callback for dealing with Sidebar Alt loading
 *
 * Intercepts GSS code flow, so that Shop page can be dealt with, then
 * hands back control to the GSS function for loading secondary sidebars.
 * Effectively, it's just a more complex version of ss_do_sidebar_alt()
 *
 * Checks if we're on the product archive and a GSS sidebar has been
 * assigned in the Shop WP Page editor, then, if both true, loads the relevant
 * GSS sidebar on the Shop Page.
 * If either of the above conditions return false, we hand back control to GSS
 * by executing the normal ss_do_one_sidebar_alt() function.
 *
 * @since 0.9.0
 *
 * @uses woocommerce_get_page_id()
 *
 */
function gencwooc_ss_do_sidebar_alt() {

	$bar = '_ss_sidebar_alt';
	$shop_id = woocommerce_get_page_id( 'shop' );

	if ( is_post_type_archive( 'product' ) && $_bar = get_post_meta( $shop_id, $bar, true ) ) {
		dynamic_sidebar( $_bar );

	} else {

		/** Hand back control to GSS */
		if ( ! ss_do_one_sidebar( $bar ) )
			machina_do_sidebar_alt();

	}
}