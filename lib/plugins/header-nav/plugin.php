<?php
/**
 * Machina Header Nav
 *
 * @package   MachinaHeaderNav
 * @author    Machina Themes
 * @license   GPL-2.0+
 * @link      https://github.com/machina-header-nav
 * @copyright 2013 Machina Themes
 *
 * @wordpress-plugin
 * Plugin Name:       Machina Header Nav
 * Plugin URI:        https://github.com/machina-header-nav
 * Description:       Registers a menu location and displays it inside the header for a Machina Framework child theme.
 * Version:           1.2.0
 * Author:            Machina Themes
 * Author URI:        http://machinathemes.com/
 * Text Domain:       machina-header-nav
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/machina-header-nav
 * GitHub Branch:     master
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'class-header-nav.php';

Machina_Header_Nav::get_instance();
