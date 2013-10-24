<?php
/**
 * Plugin Name: Machina Grid
 * Description: Use a Grid Loop for sections of your site
 * Version: 1.1
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

class BE_Machina_Grid {
	var $instance;

	/**
	 * Construct
	 *
	 * Registers our activation hook and init hook
	 *
	 * @since 1.0
	 */
	function __construct() {
		$this->instance =& $this;
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Init
	 *
	 * Register all our functions to the appropriate hook
	 *
	 * @since 1.0
	 */
	function init() {

		// Grid Loop Query Args
		add_action( 'pre_get_posts', array( $this, 'be_grid_loop_query_args' ) );

		// Grid Loop Post Classes
		add_filter( 'post_class', array( $this, 'be_grid_loop_post_classes' ) );

		// Grid Loop Featured Image
		add_filter( 'machina_pre_get_option_image_size', array( $this, 'be_grid_loop_image' ) );

		// Fix Posts Nav
		add_filter( 'machina_after_endwhile', array( $this, 'be_fix_posts_nav' ), 5 );

		// Is Grid Loop?
		add_filter( 'is_machina_grid_loop', array( $this, 'be_grid_loop_pagination' ) );

	}

	/**
	 * Grid Loop Pagination
	 * Returns false if not grid loop.
	 * Returns an array describing pagination if is grid loop
	 *
	 * To use in theme: $grid = apply_filters( 'is_machina_grid_loop', false );
	 *
	 * @param object $query
	 * @return bool is grid loop (true) or not (false)
	 */
	function be_grid_loop_pagination( $query = false ) {

		// Make sure Machina is running
		if( !function_exists( 'machina_get_option' ) )
			return false;

		// If no query is specified, grab the main query
		global $wp_query;
		if( !isset( $query ) || empty( $query ) || !is_object( $query ) )
			$query = $wp_query;

		// Sections of site that should use grid loop
		if( ! apply_filters( 'machina_grid_loop_section', (
		( $query->is_home() && machina_get_option( 'grid_on_home', 'machina-grid' ) ) ||
		( $query->is_category() && machina_get_option( 'grid_on_category', 'machina-grid' ) ) ||
		( $query->is_tag() && machina_get_option( 'grid_on_tag', 'machina-grid' ) ) ||
		( $query->is_author() && machina_get_option( 'grid_on_author', 'machina-grid' ) ) ||
		( $query->is_search() && machina_get_option( 'grid_on_search', 'machina-grid' ) )
		), $query ) )
			return false;

		// Specify pagination
		$args = array(
			'features_on_front' => (int) machina_get_option( 'features_on_front', 'machina-grid' ),
			'teasers_on_front' => (int) machina_get_option( 'teasers_on_front', 'machina-grid' ),
			'features_inside' => (int) machina_get_option( 'features_inside', 'machina-grid' ),
			'teasers_inside' => (int) machina_get_option( 'teasers_inside', 'machina-grid' ),
			'teaser_columns' => (int) machina_get_option( 'teaser_columns', 'machina-grid' ),
		);

		return apply_filters( 'machina_grid_loop_args', $args, $query );
	}

	/**
	 * Grid Loop Query Arguments
	 *
	 * @param object $query
	 * @return null
	 */
	function be_grid_loop_query_args( $query ) {
		$grid_args = $this->be_grid_loop_pagination( $query );
		if( $query->is_main_query() && !is_admin() && $grid_args ) {

			// First Page
			$page = $query->query_vars['paged'];
			if( ! $page ) {
				$query->set( 'posts_per_page', ( $grid_args['features_on_front'] + $grid_args['teasers_on_front'] ) );

			// Other Pages
			} else {
				$query->set( 'posts_per_page', ( $grid_args['features_inside'] + $grid_args['teasers_inside'] ) );
				$query->set( 'offset', ( $grid_args['features_on_front'] + $grid_args['teasers_on_front'] ) + ( $grid_args['features_inside'] + $grid_args['teasers_inside'] ) * ( $page - 2 ) );
				// Offset is posts on first page + posts on internal pages * ( current page - 2 )
			}

		}
	}

	/**
	 * Grid Loop Post Classes
	 *
	 * @param array $classes
	 * @return array $classes
	 */
	function be_grid_loop_post_classes( $classes ) {
		global $wp_query;
		$grid_args = $this->be_grid_loop_pagination();
		if( ! $grid_args )
			return $classes;

		// Convert teaser column to a class
		$teaser_columns = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
		$teaser_column = $teaser_columns[$grid_args['teaser_columns']];

		// First Page Classes
		if( ! $wp_query->query_vars['paged'] ) {

			// Features
			if( $wp_query->current_post < $grid_args['features_on_front'] ) {
				$classes[] = 'feature';

			// Teasers
			} else {
				$classes[] = $teaser_column . ' teaser';
				if( 0 == ( $wp_query->current_post - $grid_args['features_on_front'] ) || 0 == ( $wp_query->current_post - $grid_args['features_on_front'] ) % $grid_args['teaser_columns'] )
					$classes[] = 'first';
			}

		// Inner Pages
		} else {

			// Features
			if( $wp_query->current_post < $grid_args['features_inside'] ) {
				$classes[] = 'feature';

			// Teasers
			} else {
				$classes[] = $teaser_column . ' teaser';
				if( 0 == ( $wp_query->current_post - $grid_args['features_inside'] ) || 0 == ( $wp_query->current_post - $grid_args['features_inside'] ) % $grid_args['teaser_columns'] )
					$classes[] = 'first';
			}

		}

		return $classes;
	}

	/**
	 * Grid Loop Featured Image
	 *
	 * @param string image size
	 * @return string
	 */
	function be_grid_loop_image( $image_size ) {
		global $wp_query;
		$grid_args = $this->be_grid_loop_pagination();
		if( ! $grid_args )
			return $image_size;

		// Feature
		if( ( ! $wp_query->query_vars['paged'] && $wp_query->current_post < $grid_args['features_on_front'] ) || ( $wp_query->query_vars['paged'] && $wp_query->current_post < $grid_args['features_inside'] ) )
			$image_size = machina_get_option( 'feature_image_size', 'machina-grid' );

		if( ( ! $wp_query->query_vars['paged'] && $wp_query->current_post > ( $grid_args['features_on_front'] - 1 ) ) || ( $wp_query->query_vars['paged'] && $wp_query->current_post > ( $grid_args['features_inside'] - 1 ) ) )
			$image_size = machina_get_option( 'teaser_image_size', 'machina-grid' );

		return $image_size;
	}

	/**
	 * Fix Posts Nav
	 *
	 * The posts navigation uses the current posts-per-page to
	 * calculate how many pages there are. If your homepage
	 * displays a different number than inner pages, there
	 * will be more pages listed on the homepage. This fixes it.
	 *
	 */
	function be_fix_posts_nav() {

		global $wp_query;
		$grid_args = $this->be_grid_loop_pagination();
		if( ! $grid_args )
			return;

		$max = ceil ( ( $wp_query->found_posts - $grid_args['features_on_front'] - $grid_args['teasers_on_front'] ) / ( $grid_args['features_inside'] + $grid_args['teasers_inside'] ) ) + 1;
		$wp_query->max_num_pages = $max;

	}

}

new BE_Machina_Grid;


/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Child Theme Settings page.
 *
 * @since 1.0
 */
function be_register_machina_grid_settings() {

	if( ! class_exists( 'Machina_Admin_Boxes' ) )
		exit;

	class BE_Machina_Grid_Settings extends Machina_Admin_Boxes {

		/**
		 * Create an admin menu item and settings page.
		 * @since 1.0.0
		 */
		function __construct() {

			// Specify a unique page ID.
			$page_id = 'machina-grid';

			// Set it as a child to machina, and define the menu and page titles
			$menu_ops = array(
				'submenu' => array(
					'parent_slug' => 'machina',
					'page_title'  => __( 'Machina - Grid Loop', 'machina-grid' ),
					'menu_title'  => __( 'Grid Loop', 'machina-grid' ),
				)
			);

			// Set up page options. These are optional, so only uncomment if you want to change the defaults
			$page_ops = array(
			//	'screen_icon'       => 'options-general',
			//	'save_button_text'  => 'Save Settings',
			//	'reset_button_text' => 'Reset Settings',
			//	'save_notice_text'  => 'Settings saved.',
			//	'reset_notice_text' => 'Settings reset.',
			);

			// Give it a unique settings field.
			// You'll access them from machina_get_option( 'option_name', 'child-settings' );
			$settings_field = 'machina-grid';

			// Set the default values
			$default_settings = array(
				'features_on_front'   => 2,
				'teasers_on_front' => 8,
				'features_inside' => 0,
				'teasers_inside' => 10,
				'teaser_columns' => 2,
				'grid_on_home' => 1,
				'grid_on_category' => 1,
				'grid_on_tag' => 1,
				'grid_on_author' => 1,
				'grid_on_search' => 1,
				'feature_image_size' => 'large',
				'teaser_image_size' => 'medium',
			);

			// Create the Admin Page
			$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

			// Initialize the Sanitization Filter
			add_action( 'machina_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );

		}

		/**
		 * Set up Sanitization Filters
		 * @since 1.0.0
		 *
		 * See /lib/classes/sanitization.php for all available filters.
		 */
		function sanitization_filters() {

			machina_add_option_filter( 'no_html', $this->settings_field,
				array(
					'features_on_front',
					'teasers_on_front',
					'features_inside',
					'teasers_inside',
					'teaser_columns',
					'feature_image_size',
					'teaser_image_size',
 				) );

 			machina_add_option_filter( 'one_zero', $this->settings_field,
 				array(
 					'grid_on_home',
 					'grid_on_category',
 					'grid_on_tag',
 					'grid_on_author',
 					'grid_on_search',
 				) );

		}

		/**
		 * Register metaboxes on Child Theme Settings page
		 * @since 1.0.0
		 */
		function metaboxes() {

			add_meta_box( 'grid-location', __( 'Grid Location', 'machina-grid' ), array( $this, 'grid_location' ), $this->pagehook, 'main', 'high' );
			add_meta_box( 'grid_information', __( 'Grid Information', 'machina-grid' ), array( $this, 'grid_information' ), $this->pagehook, 'main', 'high' );


		}

		/**
		 * Grid Location Metabox
		 * @since 1.0.0
		 */
		function grid_location() {

			echo '<h4>' . __( 'Enable on:', 'machina-grid' ) . '</h4>';

			echo '<p>

			<input type="checkbox" name="' . $this->get_field_name( 'grid_on_home' ) . '" id="' . $this->get_field_id( 'grid_on_home' ) . '" value="1"' . checked( $this->get_field_value( 'grid_on_home' ), true, false ) . ' />
			<label for="' . $this->get_field_id( 'grid_on_home' ) . '">' . __( 'Blog Home', 'machina-grid' ) . '</label>

			<input type="checkbox" name="' . $this->get_field_name( 'grid_on_category' ) . '" id="' . $this->get_field_id( 'grid_on_category' ) . '" value="1"' . checked( $this->get_field_value( 'grid_on_category' ), true, false ) . ' />
			<label for="' . $this->get_field_id( 'grid_on_category' ) . '">' . __( 'Category Archives', 'machina-grid' ) . '</label>

			<input type="checkbox" name="' . $this->get_field_name( 'grid_on_tag' ) . '" id="' . $this->get_field_id( 'grid_on_tag' ) . '" value="1"' . checked( $this->get_field_value( 'grid_on_tag' ), true, false ) . ' />
			<label for="' . $this->get_field_id( 'grid_on_tag' ) . '">' . __( 'Tag Archives', 'machina-grid' ) . '</label>

			<input type="checkbox" name="' . $this->get_field_name( 'grid_on_author' ) . '" id="' . $this->get_field_id( 'grid_on_author' ) . '" value="1"' . checked( $this->get_field_value( 'grid_on_author' ), true, false ) . ' />
			<label for="' . $this->get_field_id( 'grid_on_author' ) . '">' . __( 'Author Archives', 'machina-grid' ) . '</label>

			<input type="checkbox" name="' . $this->get_field_name( 'grid_on_search' ) . '" id="' . $this->get_field_id( 'grid_on_search' ) . '" value="1"' . checked( $this->get_field_value( 'grid_on_search' ), true, false ) . ' />
			<label for="' . $this->get_field_id( 'grid_on_search' ) . '">' . __( 'Search Results', 'machina-grid' ) . '</label>


			</p>';
		}

		/**
		 * Grid Information Metabox
		 * @since 1.0.0
		 */
		function grid_information() {

			echo '<p><label for="' . $this->get_field_id( 'features_on_front' ) . '">' . __( 'Features on First Page', 'machina-grid' ) . '</label> <input type="text" name="' . $this->get_field_name( 'features_on_front' ) . '" id="' . $this->get_field_id( 'features_on_front' ) . '" value="' . $this->get_field_value( 'features_on_front' ) . '" size="3"></p>';

			echo '<p><label for="' . $this->get_field_id( 'teasers_on_front' ) . '">' . __( 'Teasers on First Page', 'machina-grid' ) . '</label> <input type="text" name="' . $this->get_field_name( 'teasers_on_front' ) . '" id="' . $this->get_field_id( 'teasers_on_front' ) . '" value="' . $this->get_field_value( 'teasers_on_front' ) . '" size="3"></p>';

			echo '<p><label for="' . $this->get_field_id( 'features_inside' ) . '">' . __( 'Features on Subsequent Pages', 'machina-grid' ) . '</label> <input type="text" name="' . $this->get_field_name( 'features_inside' ) . '" id="' . $this->get_field_id( 'features_inside' ) . '" value="' . $this->get_field_value( 'features_inside' ) . '" size="3"></p>';

			echo '<p><label for="' . $this->get_field_id( 'teasers_inside' ) . '">' . __( 'Teasers on Subsequent Pages', 'machina-grid' ) . '</label> <input type="text" name="' . $this->get_field_name( 'teasers_inside' ) . '" id="' . $this->get_field_id( 'teasers_inside' ) . '" value="' . $this->get_field_value( 'teasers_inside' ) . '" size="3"></p>';

			echo '<p><label for="' . $this->get_field_id( 'teaser_columns' ) . '">' . __( 'Teaser Columns (2-6)', 'machina-grid' ) . '</label> <input type="text" name="' . $this->get_field_name( 'teaser_columns' ) . '" id="' . $this->get_field_id( 'teaser_columns' ) . '" value="' . $this->get_field_value( 'teaser_columns' ) . '" size="3"></p>';


			echo '<h4>' . __( 'Image Sizes', 'machina-grid' ) . '</h4>';
			echo '<p>' . __( 'To use this feature, go to Machina > Theme Settings > Content Archives and check "Include the Featured Image". You can control the size of built-in image sizes (Thumbnail, Medium, and Large) in Settings > Media.', 'machina-grid' ) . '</p>';

			$sizes = machina_get_image_sizes();
			echo '<p>
			<label for="' . $this->get_field_id( 'feature_image_size' ) . '">' . __( 'Feature Image Size:', 'machina-grid' ) . '</label>
			<select name="' . $this->get_field_name( 'feature_image_size' ) . '" id="' . $this->get_field_id( 'feature_image_size' ) . '">';
			foreach ( (array) $sizes as $name => $size )
				echo '<option value="' . $name . '"' . selected( $this->get_field_value( 'feature_image_size' ), $name, FALSE ) . '>' . $name . ' (' . $size['width'] . ' &#215; ' . $size['height'] . ')</option>' . "\n";
			echo '</select></p>';

			echo '<p>
			<label for="' . $this->get_field_id( 'teaser_image_size' ) . '">' . __( 'Teaser Image Size:', 'machina-grid' ) . '</label>
			<select name="' . $this->get_field_name( 'teaser_image_size' ) . '" id="' . $this->get_field_id( 'teaser_image_size' ) . '">';
			foreach ( (array) $sizes as $name => $size )
				echo '<option value="' . $name . '"' . selected( $this->get_field_value( 'teaser_image_size' ), $name, FALSE ) . '>' . $name . ' (' . $size['width'] . ' &#215; ' . $size['height'] . ')</option>' . "\n";
			echo '</select></p>';


		}
	}
	global $_be_machina_grid_settings;
	$_be_machina_grid_settings = new BE_Machina_Grid_Settings;

}
add_action( 'machina_admin_menu', 'be_register_machina_grid_settings'  );
