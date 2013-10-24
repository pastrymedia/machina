<?php
/*
Plugin Name: Machina Title Toggle
Description: Turn on/off page titles on a per page basis, and set sitewide defaults from Theme Settings. Must be using the Machina theme.
Version: 1.5
License: GPLv2
*/

class BE_Title_Toggle {
	var $instance;

	function __construct() {
		$this->instance =& $this;
		add_action( 'init', array( $this, 'init' ) );
	}

	function init() {

		// Metabox on Theme Settings, for Sitewide Default
		add_filter( 'machina_theme_settings_defaults', array( $this, 'setting_defaults' ) );
		add_action( 'machina_settings_sanitizer_init', array( $this, 'sanitization' ) );
		add_action( 'machina_theme_settings_metaboxes', array( $this, 'register_metabox' ) );

		// Metabox on Edit screen, for Page Override
		add_filter( 'cmb_meta_boxes', array( $this, 'create_metaboxes' ) );
		add_action( 'init', array( $this, 'initialize_cmb_meta_boxes' ), 50 );

		// Removes Page Title
		add_action( 'machina_before', array( $this, 'title_toggle' ) );

		// If using post formats, have to hook in later for some themes
		if( current_theme_supports( 'post-formats' ) )
			add_action( 'machina_before_post', array( $this, 'title_toggle' ), 20 );
	}



	/**
	 * Sitewide Setting - Register Defaults
	 * @link http://www.billerickson.net/machina-theme-options/
	 *
	 * @param array $defaults
	 * @return array modified defaults
	 *
	 */
	function setting_defaults( $defaults ) {
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach ( $post_types as $post_type )
			$defaults[] = array( 'be_title_toggle_' . $post_type => '' );
		return $defaults;
	}

	/**
	 * Sitewide Setting - Sanitization
	 * @link http://www.billerickson.net/machina-theme-options/
	 *
	 */
	function sanitization() {
		$fields = array();
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach ( $post_types as $post_type )
			$fields[] = 'be_title_toggle_' . $post_type;

	    machina_add_option_filter( 'one_zero', MACHINA_SETTINGS_FIELD, $fields );
	}

	/**
	 * Sitewide Setting - Register Metabox
	 * @link http://www.billerickson.net/machina-theme-options/
	 *
	 * @param string, Machina theme settings page hook
	 */

	function register_metabox( $_machina_theme_settings_pagehook ) {
		add_meta_box('be-title-toggle', __( 'Title Toggle', 'machina-title-toggle' ), array( $this, 'create_sitewide_metabox' ), $_machina_theme_settings_pagehook, 'main', 'high');
	}

	/**
	 * Sitewide Setting - Create Metabox
	 * @link http://www.billerickson.net/machina-theme-options/
	 *
	 */
	function create_sitewide_metabox() {
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach ( $post_types as $post_type )
			echo '<p><input type="checkbox" name="' . MACHINA_SETTINGS_FIELD . '[be_title_toggle_' . $post_type . ']" id="' . MACHINA_SETTINGS_FIELD . '[be_title_toggle_' . $post_type . ']" value="1" ' . checked( 1, machina_get_option( 'be_title_toggle_' . $post_type ), false ) .' /> <label for="' . MACHINA_SETTINGS_FIELD . '[be_title_toggle_' . $post_type . ']"> ' . sprintf( __( 'By default, remove titles in the <strong>%s</strong> post type.', 'machina-title-toggle' ), $post_type ) .'</label></p>';


	}

	/**
	 * Create Page Specific Metaboxes
	 * @link http://www.billerickson.net/wordpress-metaboxes/
	 *
	 * @param array $meta_boxes, current metaboxes
	 * @return array $meta_boxes, current + new metaboxes
	 *
	 */
	function create_metaboxes( $meta_boxes ) {

		// Make sure we're still in Machina, plugins like WP Touch need this check
		if ( !function_exists( 'machina_get_option' ) )
			return $meta_boxes;


		// Get all post types used by plugin and split them up into show and hide.
		// Sitewide default checked = hide by default, so metabox should let you override that and show the title
		// Sitewide default empty = display by default, so metabox should let you override that and hide the title

		$show = array();
		$hide = array();
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
		foreach ( $post_types as $post_type ) {
			$default = machina_get_option( 'be_title_toggle_' . $post_type );
			if ( !empty( $default ) ) $show[] = $post_type;
			else $hide[] = $post_type;
		}


		// Create the show and hide metaboxes that override the default

		if ( !empty( $show ) ) {
			$meta_boxes[] = array(
				'id' => 'be_title_toggle_show',
				'title' => __( 'Title Toggle', 'machina-title-toggle' ),
				'pages' => $show,
				'context' => 'normal',
				'priority' => 'high',
				'show_names' => true,
				'fields' => array(
					array(
						'name' => __( 'Show Title', 'machina-title-toggle' ),
						'desc' => __( 'By default, this post type is set to remove titles. This checkbox lets you show this specific page&rsquo;s title', 'machina-title-toggle' ),
						'id' => 'be_title_toggle_show',
						'type' => 'checkbox'
					)
				)
			);
		}

		if ( !empty( $hide ) ) {
			$meta_boxes[] = array(
				'id' => 'be_title_toggle_hide',
				'title' => __( 'Title Toggle', 'machina-title-toggle' ),
				'pages' => $hide,
				'context' => 'normal',
				'priority' => 'high',
				'show_names' => true,
				'fields' => array(
					array(
						'name' => __( 'Hide Title', 'machina-title-toggle' ),
						'desc' => __( 'By default, this post type is set to display titles. This checkbox lets you hide this specific page&rsquo;s title', 'machina-title-toggle' ),
						'id' => 'be_title_toggle_hide',
						'type' => 'checkbox'
					)
				)
			);
		}

		return $meta_boxes;
	}

	function initialize_cmb_meta_boxes() {
		$post_types = apply_filters( 'be_title_toggle_post_types', array( 'page' ) );
	    if ( !class_exists('cmb_Meta_Box') && !empty( $post_types ) ) {
	        require_once( dirname( __FILE__) . '/lib/metabox/init.php' );
	    }
	}

	function title_toggle() {
		// Make sure we're on the single page
		if ( !is_singular() )
			return;

		global $post;
		$post_type = get_post_type( $post );

		// See if post type has pages turned off by default
		$default = machina_get_option( 'be_title_toggle_' . $post_type );

		// If titles are turned off by default, let's check for an override before removing
		if ( !empty( $default ) ) {
			$override = get_post_meta( $post->ID, 'be_title_toggle_show', true );

			// If override is empty, get rid of that title
			if (empty( $override ) ) {
				remove_action( 'machina_post_title', 'machina_do_post_title' );
				remove_action( 'machina_entry_header', 'machina_do_post_title' );
			}

		// If titles are turned on by default, let's see if this specific one is turned off
		} else {
			$override = get_post_meta( $post->ID, 'be_title_toggle_hide', true );

			// If override has a value, the title's gotta go
			if ( !empty( $override ) ) {
				remove_action( 'machina_post_title', 'machina_do_post_title' );
				remove_action( 'machina_entry_header', 'machina_do_post_title' );
			}
		}
	}
}

new BE_Title_Toggle;