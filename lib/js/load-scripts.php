<?php
/**
 * Machina Framework.
 *
 * WARNING: This file is part of the core Machina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Machina\Assets
 * @author  MachinaThemes
 * @license GPL-2.0+
 * @link    http://my.machinathemes.com/themes/machina/
 */

add_action( 'wp_enqueue_scripts', 'machina_register_scripts' );
/**
 * Register the scripts that Machina will use.
 *
 * @since 2.0.0
 *
 * @uses MACHINA_JS_URL
 * @uses PARENT_THEME_VERSION
 */
function machina_register_scripts() {

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

}

add_action( 'wp_enqueue_scripts', 'machina_load_scripts' );
/**
 * Enqueue the scripts used on the front-end of the site.
 *
 * @since 0.2.0
 *
 * @uses machina_get_option() Get theme setting value.
 */
function machina_load_scripts() {

	//* If a single post or page, threaded comments are enabled, and comments are open
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() )
		wp_enqueue_script( 'comment-reply' );

}

add_action( 'wp_head', 'machina_html5_ie_fix' );
/**
 * Load the html5 shiv for IE8 and below. Can't enqueue with IE conditionals.
 *
 * @since 2.0.0
 *
 * @return Return early if HTML5 not supported.
 *
 */
function machina_html5_ie_fix() {

	echo '<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->' . "\n";

}

add_action( 'admin_enqueue_scripts', 'machina_load_admin_scripts' );
/**
 * Conditionally enqueue the scripts used in the admin.
 *
 * Includes Thickbox, theme preview and a Machina script (actually enqueued in machina_load_admin_js()).
 *
 * @since 0.2.3
 *
 * @uses machina_load_admin_js() Enqueues the custom script and localizations used in the admin.
 * @uses machina_is_menu_page()  Check that we're targeting a specific Machina admin page.
 * @uses machina_update_check()  Ping http://api.machinatheme.com/ asking if a new version of this theme is available.
 * @uses machina_seo_disabled()  Detect whether or not Machina SEO has been disabled.
 *
 * @global WP_Post $post Post object.
 *
 * @param string $hook_suffix Admin page identifier.
 */
function machina_load_admin_scripts( $hook_suffix ) {

	//* Only add thickbox/preview if there is an update to Machina available
	if ( machina_update_check() ) {
		add_thickbox();
		wp_enqueue_script( 'theme-preview' );
		machina_load_admin_js();
	}

	//* If we're on a Machina admin screen
	if ( machina_is_menu_page( 'machina' ) || machina_is_menu_page( 'seo-settings' ) || machina_is_menu_page( 'design-settings' ) )
		machina_load_admin_js();

	global $post;

	//* If we're viewing an edit post page, make sure we need Machina SEO JS
	if ( in_array( $hook_suffix, array( 'post-new.php', 'post.php' ) ) ) {
		if ( ! machina_seo_disabled() && post_type_supports( $post->post_type, 'machina-seo' ) )
			machina_load_admin_js();
	}

}

/**
 * Enqueues the custom script used in the admin, and localizes several strings or values used in the scripts.
 *
 * Applies the `machina_toggles` filter to toggleable admin settings, so plugin developers can add their own without
 * having to recreate the whole setup.
 *
 * @since 1.8.0
 *
 * @uses MACHINA_JS_URL
 * @uses PARENT_THEME_VERSION
 */
function machina_load_admin_js() {

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'machina_admin_js', MACHINA_JS_URL . "/admin$suffix.js", array( 'jquery' ), PARENT_THEME_VERSION, true );

	$strings = array(
		'categoryChecklistToggle' => __( 'Select / Deselect All', 'machina' ),
		'saveAlert'               => __('The changes you made will be lost if you navigate away from this page.', 'machina'),
		'confirmUpgrade'          => __( 'Updating Machina will overwrite the current installed version of Machina. Are you sure you want to update?. "Cancel" to stop, "OK" to update.', 'machina' ),
		'confirmReset'            => __( 'Are you sure you want to reset?', 'machina' ),
	);

	wp_localize_script( 'machina_admin_js', 'machinaL10n', $strings );

	$toggles = array(
		// Checkboxes - when checked, show extra settings
		'update'                    => array( '#machina-settings\\[update\\]', '#machina_update_notification_setting', '_checked' ),
		'content_archive_thumbnail' => array( '#machina-settings\\[content_archive_thumbnail\\]', '#machina_image_size', '_checked' ),
		// Checkboxed - when unchecked, show extra settings
		'semantic_headings'         => array( '#machina-seo-settings\\[semantic_headings\\]', '#machina_seo_h1_wrap', '_unchecked' ),
		// Select toggles
		'nav_extras'                => array( '#machina-settings\\[nav_extras\\]', '#machina_nav_extras_twitter', 'twitter' ),
		'content_archive'           => array( '#machina-settings\\[content_archive\\]', '#machina_content_limit_setting', 'full' ),

	);

	wp_localize_script( 'machina_admin_js', 'machina_toggles', apply_filters( 'machina_toggles', $toggles ) );

}
