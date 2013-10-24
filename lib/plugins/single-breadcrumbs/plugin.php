<?php
/**
 * Machina Single Breadcrumbs
 *
 * @package           Machina_Single_Breadcrumbs
 * @author            Machina Themes
 * @license           GPL-2.0+
 * @link              http://machinathemes.com/
 *
 * @wordpress-plugin
 * Plugin Name:       Machina Single Breadcrumbs
 * Description:       Adds per-entry options for breadcrumbs when a Machina child theme is active.
 * Version:           1.1.0
 * Text Domain:       machina-single-breadcrumbs
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Branch:     master
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register hooks that are fired when the plugin is activated and deactivated, respectively.
register_activation_hook( __FILE__, array( 'Machina_Single_Breadcrumbs', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Machina_Single_Breadcrumbs', 'deactivate' ) );

require plugin_dir_path( __FILE__ ) . 'class-single-breadcrumbs.php';
add_action( 'plugins_loaded', array( 'Machina_Single_Breadcrumbs', 'get_instance' ) );

require plugin_dir_path( __FILE__ ) . 'class-single-breadcrumbs-public.php';
add_action( 'plugins_loaded', array( 'Machina_Single_Breadcrumbs_Public', 'get_instance' ) );

if ( is_admin() ) {
	require plugin_dir_path( __FILE__ ) . 'class-single-breadcrumbs-admin.php';
	add_action( 'plugins_loaded', array( 'Machina_Single_Breadcrumbs_Admin', 'get_instance' ) );
}

