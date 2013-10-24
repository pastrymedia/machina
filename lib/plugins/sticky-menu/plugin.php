<?php
/*
Plugin Name: Machina sticky menu
Plugin URI: http://iniyan.in/plugins/machina-sticky-menu/
Description: This plugin adds a sticky menu to Machina powered site. Requires the Machina framework.
Version: 1.0.0
Author: Iniyan
Author URI: http://iniyan.in
*/
/** Define our constants */
define( 'GSM_SETTINGS_FIELD', 'gsm-settings' );
define( 'GSM_PLUGIN_DIR', dirname( __FILE__ ) );



add_action( 'machina_init', 'gsm_init', 20 );

/**
 * Load admin menu and helper functions. Hooked to `machina_init`.
 *
 * @since 1.8.0
 */

function gsm_init() {

	/** Admin Menu */

	if ( is_admin() )

	require_once( GSM_PLUGIN_DIR . '/gsm-design.php' );

	/** CSS generator function */

	require_once( GSM_PLUGIN_DIR . '/gsm-style.php' );

}

//* enqueue script *//
add_action( 'wp_enqueue_scripts', 'gsm_enqueue_script' );

function gsm_enqueue_script() {
					wp_enqueue_script( 'sticky-menu', plugins_url( 'js/sticky-menu.js', __FILE__ ), array( 'jquery' ), '', true );
}

//*Adding Sticky Menu
add_theme_support ( 'machina-menus' , array ( 'primary' => 'Primary Navigation Menu' , 'secondary' => 'Secondary Navigation Menu' ,'stickymenu' => 'Machina Sticky Menu' ) );

// Add new navbar
add_action('machina_before', 'stickymenu');

function stickymenu() {
	echo '<div id="subnav"><div class="wrap">';
	wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_id' => '' , 'menu_class' => 'menu machina-nav-menu menu-secondary', 'theme_location' => 'stickymenu') );
	echo '</div></div>';
}
