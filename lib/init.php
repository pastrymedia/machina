<?php
/**
 * Machina Framework.
 *
 * WARNING: This file is part of the core Machina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Machina\Framework
 * @author  MachinaThemes
 * @license GPL-2.0+
 * @link    http://my.machinathemes.com/themes/machina/
 */

//* Run the machina_pre Hook
do_action( 'machina_pre' );

add_action( 'machina_init', 'machina_i18n' );
/**
 * Load the Machina textdomain for internationalization.
 *
 * @since 1.9.0
 *
 * @uses load_theme_textdomain()
 *
 */
function machina_i18n() {

	if ( ! defined( 'MACHINA_LANGUAGES_DIR' ) )
		define( 'MACHINA_LANGUAGES_DIR', get_template_directory() . '/lib/languages' );

	load_theme_textdomain( 'machina', MACHINA_LANGUAGES_DIR );

}

add_action( 'machina_init', 'machina_theme_support' );
/**
 * Activates default theme features.
 *
 * @since 1.6.0
 */
function machina_theme_support() {

	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'machina-inpost-layouts' );
	add_theme_support( 'machina-archive-layouts' );
	add_theme_support( 'machina-admin-menu' );
	add_theme_support( 'machina-seo-settings-menu' );
	add_theme_support( 'machina-import-export-menu' );
	add_theme_support( 'machina-readme-menu' );
	add_theme_support( 'machina-auto-updates' );
	add_theme_support( 'machina-breadcrumbs' );

	//* Maybe add support for Machina menus
	if ( ! current_theme_supports( 'machina-menus' ) )
		add_theme_support( 'machina-menus', array(
			'primary'   => __( 'Primary Navigation Menu', 'machina' ),
			'secondary' => __( 'Secondary Navigation Menu', 'machina' ),
			'footer'    => __( 'Footer Navigation Menu', 'machina' ),
			'mobile'    => __( 'Mobile Navigation Menu', 'machina' ),
		) );

	//* Maybe add support for structural wraps
	if ( ! current_theme_supports( 'machina-structural-wraps' ) )
		add_theme_support( 'machina-structural-wraps', array( 'header', 'nav',
		'subnav', 'inner', 'menu-primary', 'menu-secondary', 'footer-widgets', 'footer' ) );

	//* Turn on HTML5, responsive viewport & footer widgets if Machina is active
	if ( ! is_child_theme() ) {
		add_theme_support( 'html5' );
		add_theme_support( 'machina-responsive-viewport' );
		add_theme_support( 'machina-footer-widgets', 3 );
	}

	/**
	 * 01 Set width of oEmbed
	 * machina_content_width() will be applied; Filters the content width based on the user selected layout.
	 *
	 * @see machina_content_width()
	 * @param integer $default Default width
	 * @param integer $small Small width
	 * @param integer $large Large width
	 */
	$content_width = apply_filters( 'content_width', 600, 430, 920 );

	//Custom Image Sizes
	add_image_size( 'featured-image', 225, 160, TRUE );

	// Enable Custom Background
	//add_theme_support( 'custom-background' );

	// Enable Custom Header
	//add_theme_support('machina-custom-header');

}

add_action( 'machina_init', 'machina_post_type_support' );
/**
 * Initialize post type support for Machina features (Layout selector, SEO).
 *
 * @since 1.8.0
 */
function machina_post_type_support() {

	add_post_type_support( 'post', array( 'machina-seo', 'machina-scripts', 'machina-layouts' ) );
	add_post_type_support( 'page', array( 'machina-seo', 'machina-scripts', 'machina-layouts' ) );

}

add_action( 'machina_init', 'machina_constants' );
/**
 * This function defines the Machina theme constants
 *
 * @since 1.6.0
 */
function machina_constants() {

	//* Define Theme Info Constants
	define( 'PARENT_THEME_NAME', 'Machina' );
	define( 'PARENT_THEME_VERSION', '2.0.1' );
	define( 'PARENT_THEME_BRANCH', '2.0' );
	define( 'PARENT_DB_VERSION', '2007' );
	define( 'PARENT_THEME_RELEASE_DATE', date_i18n( 'F j, Y', '1377061200' ) );
#	define( 'PARENT_THEME_RELEASE_DATE', 'TBD' );
	define( 'PARENT_THEME_URL', 'http://www.google.com' );


	//* Define Directory Location Constants
	define( 'PARENT_DIR', get_template_directory() );
	define( 'CHILD_DIR', get_stylesheet_directory() );
	define( 'MACHINA_IMAGES_DIR', PARENT_DIR . '/images' );
	define( 'MACHINA_LIB_DIR', PARENT_DIR . '/lib' );
	define( 'MACHINA_ADMIN_DIR', MACHINA_LIB_DIR . '/admin' );
	define( 'MACHINA_ADMIN_IMAGES_DIR', MACHINA_LIB_DIR . '/admin/images' );
	define( 'MACHINA_JS_DIR', MACHINA_LIB_DIR . '/js' );
	define( 'MACHINA_CSS_DIR', MACHINA_LIB_DIR . '/css' );
	define( 'MACHINA_CLASSES_DIR', MACHINA_LIB_DIR . '/classes' );
	define( 'MACHINA_CONNECT_DIR', MACHINA_LIB_DIR . '/connect' );
	define( 'MACHINA_EXTENSIONS_DIR', MACHINA_LIB_DIR . '/extensions' );
	define( 'MACHINA_FUNCTIONS_DIR', MACHINA_LIB_DIR . '/functions' );
	define( 'MACHINA_SHORTCODES_DIR', MACHINA_LIB_DIR . '/shortcodes' );
	define( 'MACHINA_PLUGINS_DIR', MACHINA_LIB_DIR . '/plugins' );
	define( 'MACHINA_STRUCTURE_DIR', MACHINA_LIB_DIR . '/structure' );
	define( 'MACHINA_TOOLS_DIR', MACHINA_LIB_DIR . '/tools' );
	define( 'MACHINA_WIDGETS_DIR', MACHINA_LIB_DIR . '/widgets' );

	//* Define URL Location Constants
	define( 'PARENT_URL', get_template_directory_uri() );
	define( 'CHILD_URL', get_stylesheet_directory_uri() );
	define( 'MACHINA_IMAGES_URL', PARENT_URL . '/images' );
	define( 'MACHINA_LIB_URL', PARENT_URL . '/lib' );
	define( 'MACHINA_ADMIN_URL', MACHINA_LIB_URL . '/admin' );
	define( 'MACHINA_ADMIN_IMAGES_URL', MACHINA_LIB_URL . '/admin/images' );
	define( 'MACHINA_JS_URL', MACHINA_LIB_URL . '/js' );
	define( 'MACHINA_CLASSES_URL', MACHINA_LIB_URL . '/classes' );
	define( 'MACHINA_CONNECT_URL', MACHINA_LIB_URL . '/connect' );
	define( 'MACHINA_EXTENSIONS_URL', MACHINA_LIB_URL . '/extensions' );
	define( 'MACHINA_CSS_URL', MACHINA_LIB_URL . '/css' );
	define( 'MACHINA_FUNCTIONS_URL', MACHINA_LIB_URL . '/functions' );
	define( 'MACHINA_SHORTCODES_URL', MACHINA_LIB_URL . '/shortcodes' );
	define( 'MACHINA_PLUGINS_URL', MACHINA_LIB_URL . '/plugins' );
	define( 'MACHINA_STRUCTURE_URL', MACHINA_LIB_URL . '/structure' );
	define( 'MACHINA_WIDGETS_URL', MACHINA_LIB_URL . '/widgets' );

	//* Define Settings Field Constants (for DB storage)
	define( 'MACHINA_SETTINGS_FIELD', apply_filters( 'machina_settings_field', 'machina-settings' ) );
	define( 'MACHINA_SEO_SETTINGS_FIELD', apply_filters( 'machina_seo_settings_field', 'machina-seo-settings' ) );
	define( 'MACHINA_CPT_ARCHIVE_SETTINGS_FIELD_PREFIX', apply_filters( 'machina_cpt_archive_settings_field_prefix', 'machina-cpt-archive-settings-' ) );

}


add_action( 'machina_init', 'machina_load_framework' );
/**
 * Loads all the framework files and features.
 *
 * The machina_pre_framework action hook is called before any of the files are
 * required().
 *
 * If a child theme defines MACHINA_LOAD_FRAMEWORK as false before requiring
 * this init.php file, then this function will abort before any other framework
 * files are loaded.
 *
 * @since 1.6.0
 */
function machina_load_framework() {

	//* Run the machina_pre_framework Hook
	do_action( 'machina_pre_framework' );

	//* Short circuit, if necessary
	if ( defined( 'MACHINA_LOAD_FRAMEWORK' ) && MACHINA_LOAD_FRAMEWORK === false )
		return;

	//* Load Framework
	require_once( MACHINA_LIB_DIR . '/framework.php' );

	//* Load Classes
	require_once( MACHINA_CLASSES_DIR . '/admin.php' );
	require_if_theme_supports( 'machina-breadcrumbs', MACHINA_CLASSES_DIR . '/breadcrumb.php' );
	require_once( MACHINA_CLASSES_DIR . '/sanitization.php' );

	//* Load Functions
	require_once( MACHINA_FUNCTIONS_DIR . '/upgrade.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/compat.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/custom.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/general.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/options.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/image.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/markup.php' );
	require_if_theme_supports( 'machina-breadcrumbs', MACHINA_FUNCTIONS_DIR . '/breadcrumb.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/menu.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/layout.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/formatting.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/seo.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/widgetize.php' );
	require_once( MACHINA_FUNCTIONS_DIR . '/feed.php' );
	if ( apply_filters( 'machina_load_deprecated', true ) )
		require_once( MACHINA_FUNCTIONS_DIR . '/deprecated.php' );

	//* Load Shortcodes
	require_once( MACHINA_SHORTCODES_DIR . '/post.php' );
	require_once( MACHINA_SHORTCODES_DIR . '/footer.php' );

	//* Load Structure
	require_once( MACHINA_STRUCTURE_DIR . '/header.php' );
	require_once( MACHINA_STRUCTURE_DIR . '/footer.php' );
	require_once( MACHINA_STRUCTURE_DIR . '/menu.php' );
	require_once( MACHINA_STRUCTURE_DIR . '/layout.php' );
	require_once( MACHINA_STRUCTURE_DIR . '/post.php' );
	require_once( MACHINA_STRUCTURE_DIR . '/loops.php' );
	require_once( MACHINA_STRUCTURE_DIR . '/comments.php' );
	require_once( MACHINA_STRUCTURE_DIR . '/sidebar.php' );
	require_once( MACHINA_STRUCTURE_DIR . '/archive.php' );
	require_once( MACHINA_STRUCTURE_DIR . '/search.php' );

	//* Load Extensions
	require_once( MACHINA_EXTENSIONS_DIR . '/custom-menu.php' );
	require_once( MACHINA_EXTENSIONS_DIR . '/microdata-manager.php' );

	//* Load Plugins
	require_once( MACHINA_PLUGINS_DIR . '/custom-hooks/plugin.php' );
	require_once( MACHINA_PLUGINS_DIR . '/custom-sidebars/plugin.php' );
	require_once( MACHINA_PLUGINS_DIR . '/widgetized-notfound/plugin.php' );

	//* Load Connections
	require_once( MACHINA_CONNECT_DIR . '/bbpress/init.php' );
	//require_once( MACHINA_CONNECT_DIR . '/coauthors/plugin.php' );
	require_once( MACHINA_CONNECT_DIR . '/edd/plugin.php' );

	//* Load Admin
	if ( is_admin() ) :
	require_once( MACHINA_ADMIN_DIR . '/menu.php' );
	require_once( MACHINA_ADMIN_DIR . '/theme-settings.php' );
	require_once( MACHINA_ADMIN_DIR . '/seo-settings.php' );
	require_once( MACHINA_ADMIN_DIR . '/cpt-archive-settings.php' );
	require_once( MACHINA_ADMIN_DIR . '/import-export.php' );
	require_once( MACHINA_ADMIN_DIR . '/inpost-metaboxes.php' );
	require_once( MACHINA_ADMIN_DIR . '/whats-new.php' );
	endif;
	require_once( MACHINA_ADMIN_DIR . '/term-meta.php' );
	require_once( MACHINA_ADMIN_DIR . '/user-meta.php' );

	//* Load Javascript
	require_once( MACHINA_JS_DIR . '/load-scripts.php' );

	//* Load CSS
	require_once( MACHINA_CSS_DIR . '/load-styles.php' );

	//* Load Widgets
	require_once( MACHINA_WIDGETS_DIR . '/widgets.php' );

	global $_machina_formatting_allowedtags;
	$_machina_formatting_allowedtags = machina_formatting_allowedtags();

}

//* Run the machina_init hook
do_action( 'machina_init' );

//* Run the machina_setup hook
do_action( 'machina_setup' );
