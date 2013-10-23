<?php
/*
Plugin Name: Connect for BuddyPress
Plugin URI: http://www.machinathemes.com
Description: BuddyPress Theme Support
Version: 1.2.1
Author: Machina Themes
Author URI: http://www.machinathemes.com
*/

function machinaconnect_init() {

	if ( ! function_exists( 'bp_loaded' ) || ! function_exists( 'machina_get_option' ) )
		return;

	define( 'MACHINACONNECT_VERSION', '1.2.1' );
  define( 'MACHINACONNECT_DIR', dirname( __FILE__ ) );
	define( 'MACHINACONNECT_URL', plugin_dir_url( __FILE__ ) );
	require( MACHINACONNECT_DIR . 'lib/class.theme.php' );

}

add_action( 'machina_setup', 'machinaconnect_init', 11 );

