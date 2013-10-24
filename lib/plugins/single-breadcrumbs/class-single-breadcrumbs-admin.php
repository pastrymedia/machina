<?php
/**
 * Machina Single Breadcrumbs
 *
 * @package   Machina_Single_Breadcrumbs
 */

/**
 * Plugin class.
 *
 * @package Machina_Single_Breadcrumbs
 */
class Machina_Single_Breadcrumbs_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $page_hook = null;

	/**
	 * Initialize the class by hooking in methods.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Adds contextual help when this admin page loads
    	add_action( 'in_admin_header', array( $this, 'add_help' ) );
    	add_action( 'admin_menu', array( $this, 'add_box' ), 999 );
    	add_action( 'save_post', array( $this, 'save_box' ), 1, 2 );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Add contextual help.
	 *
	 * @since 1.0.0
	 */
	public function add_help() {
		$screen = get_current_screen();
		if ( 'post' !== $screen->id )
			return;

        $settings =
			'<p>'  . __( 'The disable breadcrumb checkbox allows the whole breadcrumb trail to be hidden for this entry.', 'machina-single-breadcrumbs' ) . '</p>' .
			'<p>'  . __( 'The breadcrumb title field accepts plain text (markup is stripped out). If left blank, then the entry title will be used as the default breadcrumb.', 'machina-single-breadcrumbs' ) . '</p>' .
			sprintf(
				'<p><a href="%s">%s</a></p>',
        		esc_url( 'http://github.com/GaryJones/machina-single-breadcrumbs' ),
        		__( 'Machina Single Breadcrumbs', 'machina-single-breadcrumbs' )
        	);

        $screen->add_help_tab(
        	array(
        		'id'      => 'machina_single_breadcrumbs_settings',
        		'title'   => __( 'Machina Single Breadcrumbs', 'machina-single-breadcrumbs' ),
        		'content' => $settings,
        	)
        );

	}

	/**
	 * Register a new meta box to the post or page edit screen, so that the user can set breadcrumbs options on a
	 * per-post or per-page basis.
	 *
	 * @since 1.0.0
	 *
	 * @see Machina_Single_Breadcrumbs_Admin::do_box() Generates the content in the meta box.
	 */
	public function add_box() {
		foreach ( (array) get_post_types( array( 'public' => true ) ) as $type ) {
			add_meta_box(
				'machina_single_breadcrumbs', // ID
				__( 'Breadcrumbs', 'machina-single-breadcrumbs' ), // Box title
				array( $this, 'do_box' ), // callback
				$type, // screen
				'normal', // context
				'low' // priority
			);
		}
	}

	/**
	 * Callback for in-post breadcrumbs meta box.
	 *
	 * @since 1.0.0
	 */
	function do_box() {
		wp_nonce_field( 'machina_single_breadcrumbs_save', 'machina_single_breadcrumbs_nonce' );
		?>
		<p>
			<label for="machina_single_breadcrumbs_disable"><input type="checkbox" name="machina_single_breadcrumbs[_machina_single_breadcrumbs_disable]" id="machina_single_breadcrumbs_disable" value="1" <?php checked( machina_get_custom_field( '_machina_single_breadcrumbs_disable' ) ); ?> />
			<?php _e( 'Disable breadcrumbs for this entry.', 'machina-single-breadcrumbs' ); ?></label>
		</p>
		<p>
			<label for="machina_single_breadcrumbs_title"><?php _e( 'Custom breadcrumb title:', 'machina-single-breadcrumbs' ); ?></label>
			<input class="large-text" type="text" name="machina_single_breadcrumbs[_machina_single_breadcrumbs_title]" id="machina_single_breadcrumbs_title" value="<?php echo esc_attr( machina_get_custom_field( '_machina_single_breadcrumbs_title' ) ); ?>" />
		</p>
		<?php
	}

	/**
	 * Save the breadcrumbs settings when we save a post or page.
	 *
	 * @since 1.0.0
	 *
	 * @uses machina_save_custom_fields() Perform checks and saves post meta / custom field data to a post or page.
	 *
	 * @param integer  $post_id Post ID. Not used.
	 * @param stdClass $post    Post object.
	 *
	 * @return mixed Returns post id if permissions incorrect, null if doing autosave, ajax or future post, false if update
	 *               or delete failed, and true on success.
	 */
	public function save_box( $post_id, $post ) {
		if ( ! isset( $_POST['machina_single_breadcrumbs'] ) )
			return;

		$defaults = array(
			'_machina_single_breadcrumbs_title'   => '',
			'_machina_single_breadcrumbs_disable' => '',
		);

		//* Merge user submitted options with fallback defaults
		$data = wp_parse_args( $_POST['machina_single_breadcrumbs'], $defaults );


		//* Sanitize the title, description, and tags
		foreach ( (array) $data as $key => $value ) {
			if ( in_array( $key, array( '_machina_single_breadcrumbs_title', ) ) )
				$data[ $key ] = strip_tags( $value );
		}

		machina_save_custom_fields( $data, 'machina_single_breadcrumbs_save', 'machina_single_breadcrumbs_nonce', $post );
	}

}
