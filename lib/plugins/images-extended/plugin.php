<?php

/*
  Plugin Name: Machina Minimum Images Extended
  Version: 0.1.3
  Description: Adds a custom meta box for setting a separate banner image
 */

/* Prevent direct access to the plugin */
if ( !defined( 'ABSPATH' ) ) {
		wp_die( __( "Sorry, you are not allowed to access this page directly.", 'gmie' ) );
}

define( 'GMIE_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'GMIE_SETTINGS_FIELD', 'gmie-settings' );


add_action( 'machina_init', 'gmie_init', 15 );

/** Loads required files when needed */
function gmie_init() {

	if ( is_admin () ) {
		require_once(GMIE_PLUGIN_DIR . '/admin.php');

		if ( ! class_exists( 'cmb_Meta_Box' ) ) {
			require_once(GMIE_PLUGIN_DIR . '/classes/init.php');
		}
	}

	else {
		require_once(GMIE_PLUGIN_DIR . '/output.php');
	}
}
