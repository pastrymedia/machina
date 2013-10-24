<?php
/*
	Plugin Name: Machina Custom Hooks

	Description: Machina Custom Hooks allows you easy access to the 50+ Action Hooks in the Machina Theme.

	Version: 2.0.0

	License: GNU General Public License v2.0 (or later)
	License URI: http://www.opensource.org/licenses/gpl-license.php
*/

//* Define our constants
define( 'MACHINA_HOOK_SETTINGS_FIELD', apply_filters( 'machina_hook_settings_field', 'machina-hook-settings' ) );
define( 'MACHINA_HOOKS_DIR', dirname( __FILE__ ) );





add_action( 'machina_init', 'machina_custom_hooks_init', 20 );
/**
 * Load admin menu and helper functions. Hooked to `machina_init`.
 *
 * @since 1.8.0
 */
function machina_custom_hooks_init() {

	//* Admin Menu
	if ( is_admin() )
		require_once( MACHINA_HOOKS_DIR . '/admin.php' );

	//* Helper functions
	require_once( MACHINA_HOOKS_DIR . '/functions.php' );

}

add_action( 'machina_init', 'machina_execute_hooks', 20 );
/**
 * The following code loops through all the hooks, and attempts to
 * execute the code in the proper location.
 *
 * @uses machina_execute_hook() as a callback.
 *
 * @since 0.1
 */
function machina_execute_hooks() {

	$hooks = get_option( MACHINA_HOOK_SETTINGS_FIELD );

	foreach ( (array) $hooks as $hook => $array ) {

		//* Add new content to hook
		if ( machina_get_hook_option( $hook, 'content' ) ) {
			add_action( $hook, 'machina_execute_hook' );
		}

		//* Unhook stuff
		if ( isset( $array['unhook'] ) ) {

			foreach( (array) $array['unhook'] as $function ) {

				remove_action( $hook, $function );

			}

		}

	}

}

/**
 * The following function executes any code meant to be hooked.
 * It checks to see if shortcodes or PHP should be executed as well.
 *
 * @uses machina_get_hook_option()
 *
 * @since 0.1
 */
function machina_execute_hook() {

	$hook = current_filter();
	$content = machina_get_hook_option( $hook, 'content' );

	if( ! $hook || ! $content )
		return;

	$shortcodes = machina_get_hook_option( $hook, 'shortcodes' );
	$php = machina_get_hook_option( $hook, 'php' );

	$value = $shortcodes ? do_shortcode( $content ) : $content;

	if ( $php )
		eval( "?>$value<?php " );
	else
		echo $value;

}