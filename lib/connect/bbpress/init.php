<?php
/**
 * Plugin Name: bbPress Extend
 * Plugin URI:  http://machinathemes.com
 * Description: Provides basic compaitibility for bbPress.
 * Version:     1.0.1
 * Author:      Machina Themes
 * Author URI:  http://www.machinathemes.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @author     Machina Themes
 * @version    1.0.1
 * @package    bbPressExtend
 * @copyright  Copyright (c) 2012, Machina Themes
 * @link       http://machinathemes.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * bbPress Extend init class
 *
 * @since 0.8.0
 */
class bbpge_init {

	/**
	 * We hook into bbp_after_setup_theme, this way if bbPress
	 * isn't activated we won't load the plugin.
	 *
	 * @since 0.8.0
	 */
	function __construct() {

		add_action( 'bbp_after_setup_theme', array( $this, 'bbpress_extend_check' ) );
	}

	/**
	 * Check to see if  a Machina child theme is in place.
	 *
	 * @since 0.8.0
	 */
	function bbpress_extend_check() {

			add_option( 'bbpge_version', '1.0.1' );

			// The meat and gravy
			require_once( dirname( __FILE__ )  . '/bbpress-extend.php'          );
			require_once( dirname( __FILE__ )  . '/bbpress-extend-settings.php' );

			// All systems go!
			add_action( 'bbp_ready', 'bbpge_setup', 6 );

	}



}

new bbpge_init();