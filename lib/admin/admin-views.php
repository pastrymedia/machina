<?php
/**
 * Only show the admin bar to users who can at least use Posts
 *
 * @since 2.0.0
 */
if( !current_user_can( 'edit_posts' ) ) {
	add_filter( 'show_admin_bar', '__return_false' );
}

// add_action( 'admin_footer-post-new.php', 'bfg_media_manager_default_view' );
// add_action( 'admin_footer-post.php', 'bfg_media_manager_default_view' );
/**
 * Change the media manager default view to 'upload', instead of 'library'
 *
 * See: http://wordpress.stackexchange.com/questions/96513/how-to-make-upload-filesselected-by-default-in-insert-media
 *
 * @since 2.0.11
 */
function bfg_media_manager_default_view() {

    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            wp.media.controller.Library.prototype.defaults.contentUserSetting=false;
        });
    </script>
    <?php

}

/**
 * Add a stylesheet for TinyMCE
 *
 * @since 2.0.0
 */
// add_editor_style( 'css/editor-style.css' );

add_filter( 'tiny_mce_before_init', 'bfg_tiny_mce_before_init' );
/**
 * Modifies the TinyMCE settings array
 *
 * @since 2.0.0
 */
function bfg_tiny_mce_before_init( $options ) {

	$options['wordpress_adv_hidden'] = false;										// Shows the 'kitchen sink' by default
	$options['theme_advanced_blockformats'] = 'p,h2,h3,h4,blockquote';				// Restrict the Formats available in TinyMCE. Currently excluded: h1,h5,h6,address,pre
	return $options;

}

add_filter( 'mce_buttons', 'bfg_tinymce_buttons' );
/**
 * Enables some commonly used formatting buttons in TinyMCE
 *
 * @since 2.0.15
 */
function bfg_tinymce_buttons( $buttons ) {

	// $buttons[] = 'hr';															// Horizontal line
	$buttons[] = 'wp_page';															// Post pagination
	return $buttons;

}

add_filter( 'user_contactmethods', 'bfg_user_contactmethods' );
/**
 * Updates the user profile contact method fields for today's popular sites.
 *
 * See: http://wpmu.org/shun-the-plugin-100-wordpress-code-snippets-from-across-the-net/
 *
 * @since 2.0.0
 */
function bfg_user_contactmethods( $fields ) {

	//$fields['facebook'] = 'Facebook';												// Add Facebook
	//$fields['twitter'] = 'Twitter';												// Add Twitter
	//$fields['linkedin'] = 'LinkedIn';												// Add LinkedIn
	unset( $fields['aim'] );														// Remove AIM
	unset( $fields['yim'] );														// Remove Yahoo IM
	unset( $fields['jabber'] );														// Remove Jabber / Google Talk
	return $fields;

}

add_filter( 'login_errors', 'bfg_login_errors' );
/**
 * Prevent the failed login notice from specifying whether the username or the password is incorrect.
 *
 * See: http://wpdaily.co/top-10-snippets/
 *
 * @since 2.0.0
 */
function bfg_login_errors() {

    return 'Invalid username or password.';

}

add_action( 'admin_head', 'bfg_hide_admin_help_button' );
/**
 * Hide the top-right help pull-down button by adding some CSS to the admin <head>
 *
 * See: http://speckyboy.com/2011/04/27/20-snippets-and-hacks-to-make-wordpress-user-friendly-for-your-clients/
 *
 * @since 2.0.0
 */
function bfg_hide_admin_help_button() {

	?><style type="text/css">
		#contextual-help-link-wrap {
			display: none !important;
		}
	</style>
<?php

}