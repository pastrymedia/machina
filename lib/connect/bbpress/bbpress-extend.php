<?php
/**
 * Main bbPress Extend class, this does the heavy lifting
 *
 * @package  bbPressExtend
 * @since    0.8.0
 */

if ( !class_exists( 'BBP_Machina' ) ) :

class BBP_Machina {

	/** Functions *************************************************************/

	/**
	 * The main bbPress Machina loader
	 *
	 * @access public
	 * @since 0.8.0
	 */
	public function __construct() {
		$this->setup_actions();
	}

	/**
	 * Setup the Machina actions
	 *
	 * @access private
	 * @since 0.8.0
	 */
	private function setup_actions() {

		// Register forum sidebar if needed
		$this->register_machina_forum_sidebar();

		// We hook into 'machina_before' because it is the most reliable hook
		// available to bbPress in the Machina page load process.
		add_action( 'machina_before',     array( $this, 'machina_post_actions'        ) );
		add_action( 'machina_before',     array( $this, 'check_machina_forum_sidebar' ) );

		// Configure which Machina layout to apply
		add_filter( 'machina_pre_get_option_site_layout', array( $this, 'machina_layout' ) );

		// Add Layout and SEO options to Forums
		add_post_type_support( bbp_get_forum_post_type(), 'machina-layouts' );
		add_post_type_support( bbp_get_forum_post_type(), 'machina-seo'     );

	}

	/**
	 * Tweak problematic Machina post actions
	 *
	 * @access public
	 * @since 0.8.0
	 */
	public function machina_post_actions() {

		/**
		 * If the current theme is a child theme of Machina that also includes
		 * the template files bbPress needs, we can leave things how they are.
		 */
		if ( is_bbpress() ) {

			/** Remove Actions ************************************************/

			/**
			 * Remove machina breadcrumbs
			 *
			 * bbPress packs its own breadcrumbs, so we don't need the G version.
			 */
			remove_action( 'machina_before_loop', 'machina_do_breadcrumbs' );

			/**
			 * Remove post info & meta
			 *
			 * If you moved the info/meta from their default locations, you are
			 * on your own.
			 */
			remove_action( 'machina_before_post_content', 'machina_post_info'     );
			remove_action( 'machina_after_post_content',  'machina_post_meta'     );
			remove_action( 'machina_entry_header',        'machina_post_info', 12 );
			remove_action( 'machina_entry_footer',        'machina_post_meta'     );

			/**
			 * Remove Machina post image and content
			 *
			 * bbPress heavily relies on the_content() so if Machina is
			 * modifying it unexpectedly, we need to un-unexpect it.
			 */
			remove_action( 'machina_post_content',  'machina_do_post_image'     );
			remove_action( 'machina_post_content',  'machina_do_post_content'   );
			remove_action( 'machina_entry_content', 'machina_do_post_image',  8 );
			remove_action( 'machina_entry_content', 'machina_do_post_content'   );

			/**
			 * Remove authorbox
			 *
			 * In some odd cases the Machina authorbox could appear
			 */
			remove_action( 'machina_after_post',   'machina_do_author_box_single' );
			remove_action( 'machina_entry_footer', 'machina_do_author_box_single' );

			/**
			 * Remove the navigation
			 *
			 * Make sure the Machina navigation doesn't try to show after the loop.
			 */
			remove_action( 'machina_after_endwhile', 'machina_posts_nav' );

			/**
			 * Remove Machina profile fields
			 *
			 * In some use cases the Machina fields were showing (incorrectly)
			 * on the bbPress profile edit pages, so we remove them just in case.
			 */
			if ( bbp_is_single_user_edit() ) {
				remove_action( 'show_user_profile', 'machina_user_options_fields' );
				remove_action( 'show_user_profile', 'machina_user_layout_fields'  );
				remove_action( 'show_user_profile', 'machina_user_seo_fields'     );
				remove_action( 'show_user_profile', 'machina_user_archive_fields' );
			}

			/** Add Actions ***************************************************/

			/**
			 * Re-add the_content back
			 *
			 * bbPress doesn't play nice with the Machina formatted content, so
			 * we remove it above and reapply the normal version bbPress expects.
			 */
			add_action( 'machina_post_content',  'the_content' );
			add_action( 'machina_entry_content', 'the_content' );

			/** Filters *******************************************************/

			/**
			 * Remove forum/topic descriptions
			 *
			 * Many people, myself included, are not a fan of the bbPress
			 * descriptions, e.g. "This forum contains 2 topics and 4 replies".
			 * So we provided an simple option in the settings to remove them.
			 */
			if ( machina_get_option( 'bbp_forum_desc' ) ) {
				add_filter( 'bbp_get_single_forum_description', '__return_false' );
				add_filter( 'bbp_get_single_topic_description', '__return_false' );
			}
		}
	}

	/**
	 * Register forum specific sidebar if enabled
	 *
	 * @access public
	 * @since 0.8.0
	 */
	public function register_machina_forum_sidebar() {

		if ( machina_get_option( 'bbp_forum_sidebar' ) ) {
			machina_register_sidebar( array(
				'id'          => 'sidebar-machina-bbpress',
				'name'        => __( 'Forum Sidebar', 'bbpress-machina-extend' ),
				'description' => __( 'This is the primary sidebar used on the forums.', 'bbpress-machina-extend' )
				)
			);
		}
	}

	/**
	 * Setup forum specific sidebar on bbPress pages if enabled
	 *
	 * @access public
	 * @since 0.8
	 */
	public function check_machina_forum_sidebar() {

		if ( is_bbpress() && machina_get_option( 'bbp_forum_sidebar' ) ) {

			// Remove the default Machina sidebar
			remove_action( 'machina_sidebar', 'machina_do_sidebar'     );

			// If Machina Simple Sidebar plugin is in place, nuke it
			remove_action( 'machina_sidebar', 'ss_do_sidebar'          );

			// Machina Connect WooCommerce sidebar
			remove_action( 'machina_sidebar', 'gencwooc_ss_do_sidebar' );

			// Load up the Genisis-bbPress sidebar
			add_action( 'machina_sidebar', array( $this, 'load_machina_forum_sidebar' ) );
		}
	}

	/**
	 * Loads the forum specific sidebar
	 *
	 * @access public
	 * @since 0.8.0
	 */
	public function load_machina_forum_sidebar() {

		// Throw up placeholder content if the sidebar is active but empty
		if ( ! dynamic_sidebar( 'sidebar-machina-bbpress' ) ) {
			echo '<div class="widget widget_text"><div class="widget-wrap">';
				echo '<h4 class="widgettitle">';
					__( 'Forum Sidebar Widget Area', 'bbpress-machina-extend' );
				echo '</h4>';
				echo '<div class="textwidget"><p>';
					printf( __( 'This is the Forum Sidebar Widget Area. You can add content to this area by visiting your <a href="%s">Widgets Panel</a> and adding new widgets to this area.', 'bbpress-machina-extend' ), admin_url( 'widgets.php' ) );
				echo '</p></div>';
			echo '</div></div>';
		}
	}

	/**
	 * Machina bbPress layout control
	 *
	 * If you set a specific layout for a forum, that will be used for that forum
	 * and it's topics. If you set one in the Machina-bbPress setting, that gets
	 * checked next. Otherwise bbPress will display itself in Machina default layout.
	 *
	 * @access public
	 * @since 0.8.0
	 * @param string $layout
	 * @return bool layout to use
	 */
	public function machina_layout( $layout ) {

		// Bail if no bbPress
		if ( !is_bbpress() )
			return $layout;

		// Set some defaults
		$forum_id = bbp_get_forum_id( $forum_id );
		// For some reason, if we use the cached version, weird things seem to happen.
		// This needs more investigation, for now we pass false as a work around.
		$retval   = machina_get_option( 'site_layout', null, false );
		$parent   = false;

		// Check and see if a layout has been set for the parent forum
		if ( !empty( $forum_id ) ) {
			$parent = esc_attr( get_post_meta( $forum_id, '_machina_layout' , true ) );

			if ( !empty( $parent ) ) {
				return apply_filters( 'bbp_machina_layout', $parent );
			}
		}

		// Second, see if a layout has been defined in the bbPress Machina settings
		if ( empty( $parent ) || ( machina_get_option( 'bbp_forum_layout' ) !== 'machina-default' ) ) {
			$retval = machina_get_option( 'bbp_forum_layout' );
		}

		// Filter the return value
		return apply_filters( 'bbp_machina_layout', $retval, $forum_id, $parent );
	}

}
endif;

/**
 * Loads Machina helper inside bbPress global class
 *
 * @since 0.8.0
 */
function bbpge_setup() {
	// Instantiate Machina for bbPress
	new BBP_Machina();
}