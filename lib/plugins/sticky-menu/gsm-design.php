<?php

/**
 * This file handles the creation of the Machina Post Navigation admin menu.
 */


class Machina_sticky_menu_Admin extends Machina_Admin_Boxes {


	function __construct() {

		// load CSS and javascript

		add_action( 'admin_enqueue_scripts', array( &$this, 'gsm_file_loads' ) );

		if ( is_admin() ){

			add_action('admin_notices', array(&$this, 'gsm_error_notice'));
		}

		// Specify a unique page ID.

		$page_id = 'gsm_design';

		// Set it as a child to machina, and define the menu and page titles

		$menu_ops = array(

			'submenu' => array(

				'parent_slug'	=> 'machina',

				'page_title'	=> 'Machina Sticky Menu',

				'menu_title'	=> 'Sticky Menu',

				'capability'	=> 'manage_options',

			)

		);


		// Set up page options.

		$page_ops = array(

			'save_button_text'  => 'Save Design',

			'reset_button_text' => 'Clear Design',

			'save_notice_text'  => 'Design saved.',

			'reset_notice_text' => 'Design cleared.',

		);

		// $color = machina_get_option( 'body_text', 'ihop-settings' );

		$settings_field = 'gsm-settings';

		// Set the default values

		$default_settings = array(

			// Default colors

			'gsm_bg'		    => '#111',

			'gsm_bg_hover'		=> '#f5f5f5',

			'text_color'		=> '#fff',

			'text_hover'		=> '#333'

		);



		// Create the Admin Page

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );


		// Initialize the Sanitization Filter

//		add_action( 'machina_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );

	}



	function gsm_file_loads() {

	global $current_screen;

		if ( 'machina_page_gsm_design' == $current_screen->id ) {

			// grab colorpicker because Farbtastic sucks

			wp_enqueue_script('jscolor', plugins_url('/jscolor/jscolor.js', __FILE__), array ('jquery'), null, false);

			wp_enqueue_script('gsm-init', plugins_url('/js/gsm.init.js', __FILE__), array ('jquery'), null, true);

			wp_enqueue_style( 'gsm-admin', plugins_url('/css/gsm-admin.css', __FILE__) );

		}

	}


	// check to make sure that the folder is writeable

	public function gsm_error_notice() {

		global $current_screen;

		if ( 'machina_page_gsm_design' == $current_screen->id ) {

		if(isset($this->errors) ) :

			foreach($this->errors as $err){

				echo $err;

			}

		endif;

		}

	}

	/**
	 * Set up Help Tab 	 */

	 function help() {
	 	$screen = get_current_screen();
		$screen->add_help_tab( array(
			'id'      => 'gsm-help',
			'title'   => 'General',
			'content' => '<p>Click a field to generate a color</p>',

		) );

	 }

	/**
	 * Register metaboxes on admin settings page
	 */

	function metaboxes() {
		add_meta_box('gsm-design-panel', 'Machina Sub Menu Color Options', array( $this, 'gsm_design_panel' ), $this->pagehook, 'main', 'high');
	}




	/**
	 * Callback for Design metabox
	 */

	function gsm_design_panel() {

	echo '<div class="design_group colors_group">';

	echo '<div class="dg_wrap" name="colors">';

		echo '<div class="dg_inner">';

		echo '<p><label id="bg">BackGround</label>';

		echo '<input class="color {hash:true}" type="text" name="' . $this->get_field_name( 'gsm_bg' ) . '" id="' . $this->get_field_id( 'gsm_bg' ) . '" value="' . esc_attr( $this->get_field_value( 'gsm_bg' ) ) . '" size="20" />';

		echo '</p>';



		echo '<p><label  id="bg-hover">BackGround Hover</label>';

		echo '<input class="color {hash:true}" type="text" name="' . $this->get_field_name( 'gsm_bg_hover' ) . '" id="' . $this->get_field_id( 'gsm_bg_hover' ) . '" value="' . esc_attr( $this->get_field_value( 'gsm_bg_hover' ) ) . '" size="20" />';

		echo '</p>';



		echo '<p><label  id="text">Text</label>';

		echo '<input class="color {hash:true}" type="text" name="' . $this->get_field_name( 'text_color' ) . '" id="' . $this->get_field_id( 'text_color' ) . '" value="' . esc_attr( $this->get_field_value( 'text_color' ) ) . '" size="20" />';

		echo '</p>';



		echo '<p><label  id="text-hover">Text Hover</label>';

		echo '<input class="color {hash:true}" type="text" name="' . $this->get_field_name( 'text_hover' ) . '" id="' . $this->get_field_id( 'text_hover' ) . '" value="' . esc_attr( $this->get_field_value( 'text_hover' ) ) . '" size="20" />';

		echo '</p>';


		echo '</div>';

		echo 'Check <a href="http://iniyan.in/">plugin demo here.</a> If you like this plugin, <a href="http://iniyan.in/donate">Buy me a coffee</a>.<a href="http://wordpress.org/support/view/plugin-reviews/machina-sticky-menu?rate=5#postform"> Rate this Plugin on WordPress</a>';

		// end Color options

	echo '</div>'; // end inner wrap


		if ( isset( $_GET['settins-updated'] ) )

			$save_trigger = 'true';

		if ( isset( $_GET['reset'] ) )

			$reset_trigger = 'true';

		if(!empty($save_trigger) || !empty($reset_trigger) )

			gsm_generate_css();
	}
}
add_action( 'machina_admin_menu', 'gsm_add_design_settings' );

/**

 * Instantiate the class to create the menu.

 */
function gsm_add_design_settings() {

	new Machina_sticky_menu_Admin;

}
