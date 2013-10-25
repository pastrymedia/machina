<?php
/*
Plugin Name: Machina Widget Toggle
Plugin URI: https://github.com/aryaprakasa/machina-widget-toggle
Description: Machina widget toggle add additional widget area with toggle.
Author: Arya Prakasa
Author URI: http://prakasa.me/

Version: 0.3

License: GNU General Public License v2.0 (or later)
License URI: http://www.opensource.org/licenses/gpl-license.php
*/


if ( ! class_exists( 'Machina_Widget_Toggle' ) ) :

/**
 * The main class that handles the entire output, content filters, etc., for this plugin.
 *
 * @package 	Machina Widget Toggle
 * @since 		0.1
 */
class Machina_Widget_Toggle {

	/**
	 * PHP5 constructor method.
	 *
	 * @since  0.1
	 */
	public function __construct() {

		/** Load Plugin Constants*/
		add_action( 'plugins_loaded', array( $this, 'constants' ), 1 );

		/** Hook Machina Widget Toggle Admin Settings */
		add_action( 'machina_init', array( $this, 'admin' ), 15 );
		/** Register widget area */
		add_action( 'machina_init', array( $this, 'register_sidebar' ), 15 );
		/** Hook Machina Widget Toggle Admin Settings */
		add_action( 'machina_admin_menu', array( $this, 'admin_init' ), 15 );
		/** Hook the widget area at wp_footer() */
		add_action( 'wp_footer', array( $this, 'widget_toggle' ), 5 );
		/** Hook the dynamic_style() area at wp_head() */
		add_action( 'wp_head', array( $this, 'dynamic_style' ), 8 );
		/** Load plugin script and styles */
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts_and_styles' ), 999 );
	}

	/**
	 * Defines constants used by the plugin.
	 *
	 * @since  0.2
	 */
	public function constants(){
		/** Define plugin constants */
		define( 'GWT_VERSION', '0.3' );
		define( 'GWT_SETTINGS', 'gwt-settings' );
		/** Set constant path to directory. */
		define( 'GWT_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'GWT_ADMIN_DIR', GWT_PLUGIN_DIR . trailingslashit( 'admin' ) );
		define( 'GWT_ASSETS_DIR', GWT_PLUGIN_DIR . trailingslashit( 'assets' ) );
		/** Set the constant path to directory URI. */
		define( 'GWT_PLUGIN_URI', trailingslashit( plugin_dir_url(__FILE__) ) );
		define( 'GWT_ADMIN_URI', GWT_PLUGIN_URI . trailingslashit( 'admin' ) );
		define( 'GWT_ASSETS_URI', GWT_PLUGIN_URI . trailingslashit( 'assets' ) );
	}



	/**
	 * Hook the admin page for Machina Widget Toggle.
	 *
	 * @since  0.2
	 */
	public function admin() {

		/** Admin Menu */
		if ( is_admin() )
			require_once( GWT_ADMIN_DIR . 'admin.php' );
	}

	/**
	 * Add the Theme Settings Page
	 *
	 * @since 0.2
	 */
	function admin_init() {
		global $_gwt_admin_settings;
		$_gwt_admin_settings = new GWT_Admin_settings;
	}

	/**
	 * This function runs all Machina dependency hook and functions.
	 *
	 * @since 0.1
	 */
	function register_sidebar() {
		machina_register_sidebar( array(
			'id'			=> 'gwt-widget-left',
			'name'			=> __( 'Widget Toggle Left', 'widgettoggle' ),
			'description'	=> __( 'Widget Toggle left area.', 'widgettoggle' ) ) );
		machina_register_sidebar( array(
			'id'			=> 'gwt-widget-middle',
			'name'			=> __( 'Widget toggle Middle', 'widgettoggle' ),
			'description'	=> __( 'Widget toggle middle area.', 'widgettoggle' ) ) );
		machina_register_sidebar( array(
			'id'			=> 'gwt-widget-right',
			'name'			=> __( 'Widget Toggle Right', 'widgettoggle' ),
			'description'	=> __( 'Widget toggle right area.', 'widgettoggle' ) ) );
	}

	/**
	 * Function to hook Widget Toggle to 'wp_footer'.
	 *
	 * @since 0.1
	 */
	function widget_toggle(){
		if (is_active_sidebar( 'gwt-widget-left' ) ||
			is_active_sidebar( 'gwt-widget-middle' ) ||
			is_active_sidebar( 'gwt-widget-right' ) ) :

			echo '<div class="widget-toggle-container">';
				machina_markup( array(
					'html'   => '<aside %s>',
					'context' => 'widget-toggle' ) );

					echo '<div class="wrap">';

						if ( is_active_sidebar( 'gwt-widget-left' ) ) {
							echo '<div class="gwt-widget-left">'."\n";
							dynamic_sidebar( 'gwt-widget-left' );
							echo '</div>'."\n";
						}
						if ( is_active_sidebar( 'gwt-widget-middle' ) ) {
							echo '<div class="gwt-widget-middle">'."\n";
							dynamic_sidebar( 'gwt-widget-middle' );
							echo '</div>'."\n";
						}
						if ( is_active_sidebar( 'gwt-widget-right' ) ) {
							echo '<div class="gwt-widget-right">'."\n";
							dynamic_sidebar( 'gwt-widget-right' );
							echo '</div>'."\n";
						}

					echo '</div>';

				echo '</aside>';
				$toggle = machina_get_option( 'toggle_text', GWT_SETTINGS ) ? machina_get_option( 'toggle_text', GWT_SETTINGS ) : '<i class="toggle-icon"></i>';
				echo '<div class="widget-toggle-control"><a class="hide-widget-toggle" href="#">'. $toggle .'</a></div>';
			echo '</div>';

		endif;
	}

	/**
	 * Function to handle script and styles.
	 *
	 * @since 0.2
	 */
	function scripts_and_styles(){
		if (is_active_sidebar( 'gwt-widget-left' ) ||
			is_active_sidebar( 'gwt-widget-middle' ) ||
			is_active_sidebar( 'gwt-widget-right' ) ) {
			wp_enqueue_script( 'gwt-script', GWT_ASSETS_URI .'js/gwt-script.js', array( 'jquery' ), GWT_VERSION, true );
			if ( machina_get_option( 'load_css', GWT_SETTINGS ) == 1 )
				wp_enqueue_style( 'gwt-style', GWT_ASSETS_URI .'css/gwt-style.css', array(), GWT_VERSION, 'all' );
		}
	}

	/**
	 * Function to dynamic styles.
	 *
	 * @since 0.2
	 */
	public function dynamic_style(){
		$css = '';

		if ( machina_get_option( 'position', GWT_SETTINGS ) )
			$css .= '.widget-toggle-container { position: '. machina_get_option( 'position', GWT_SETTINGS ) .'}';

		if ( machina_get_option( 'gwt_background', GWT_SETTINGS ) )
			$css .= '.widget-toggle { background-color: '. machina_get_option( 'gwt_background', GWT_SETTINGS ) .'}';

		if ( machina_get_option( 'max_width', GWT_SETTINGS ) )
			$css .= '.widget-toggle .wrap { max-width: '. machina_get_option( 'max_width', GWT_SETTINGS ) .'px}';

		if ( machina_get_option( 'gwt_border', GWT_SETTINGS ) ) {
			$css .= '
				.widget-toggle-control { border-color: '. machina_get_option( 'gwt_border', GWT_SETTINGS ).' }
				.widget-toggle-control .hide-widget-toggle,
				.widget-toggle-control .show-widget-toggle { background-color: '. machina_get_option( 'gwt_border', GWT_SETTINGS ) .' }
			';
		}

		if ( machina_get_option( 'text_color', GWT_SETTINGS ) ) {
			$css .= '
				.widget-toggle,
				.widget-toggle h1,
				.widget-toggle h2,
				.widget-toggle h3,
				.widget-toggle h4,
				.widget-toggle h5,
				.widget-toggle h6,
				.widget-toggle p,
				.widget-toggle label{ color: '.machina_get_option( 'text_color', GWT_SETTINGS ).' }
			';
		}

		if ( machina_get_option( 'link_color', GWT_SETTINGS ) ) {
			$css .= '
				.widget-toggle a,
				.widget-toggle iframe a{ color: '. machina_get_option( 'link_color', GWT_SETTINGS ) .' }
			';
		}

		if ( machina_get_option( 'hover_color', GWT_SETTINGS ) ) {
			$css .= '
				.widget-toggle a:hover,
				.widget-toggle iframe a:hover{ color: '. machina_get_option( 'hover_color', GWT_SETTINGS ) .' }
			';
		}

		if ( $css <> '' ) {
			$css = "<!-- Machina Widget Toggle -->\n<style type='text/css'>". str_replace( array( "\n", "\t", "\r" ), '', $css ) ."</style>\n";
			echo $css;
		}

	}



}

global $_machina_widget_toggle;
$_machina_widget_toggle = new Machina_Widget_Toggle;

endif;