<?php
/*
Plugin Name: Machina Post navigation
Plugin URI: http://iniyan.in/plugins/machina-post-navigation/
Description: Machina Post navigation plugin adds a previous and next post links on a single post in a conventional way. From the plugin settings page, you can customize the post navigation colors and also it provides an additional option to navigate posts within category. This plugin requires Machina framework.
Animations- On mouseover the previous and next links can travel from north pole to south pole :) But, I put just 20px.
Version: 3.1.0
Author: Iniyan
Author URI: http://iniyan.in
*/
/** Define our constants */
define( 'GPN_SETTINGS_FIELD', 'gpn-settings' );
define( 'GPN_PLUGIN_DIR', dirname( __FILE__ ) );



add_action( 'machina_init', 'gpn_init', 20 );

/**
 * Load admin menu and helper functions. Hooked to `machina_init`.
 *
 */

function gpn_init() {

	/** Admin Menu */

	if ( is_admin() )

	require_once( GPN_PLUGIN_DIR . '/gpn-design.php' );

	/** CSS generator function */

	require_once( GPN_PLUGIN_DIR . '/gpn-deploy.php' );

}



