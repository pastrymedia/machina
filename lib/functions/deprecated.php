<?php
/**
 * Machina Framework.
 *
 * WARNING: This file is part of the core Machina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Machina\Deprecated
 * @author  MachinaThemes
 * @license GPL-2.0+
 * @link    http://my.machinathemes.com/themes/machina/
 */

/**
 * Deprecated. Used to output archive pagination in older/newer format.
 *
 * Should now use `machina_prev_next_posts_nav()` instead.
 *
 * @since 0.2.2
 * @deprecated 2.0.0
 *
 * @uses machina_prev_next_posts_nav() Output archive pagination in next / previous format.
 */
function machina_older_newer_posts_nav() {

	_deprecated_function( __FUNCTION__, '2.0.0', 'machina_prev_next_posts_nav' );

	machina_prev_next_posts_nav();

}

/**
 * Deprecated. Show Parent and Child information in the document head if specified by the user.
 *
 * This can be helpful for diagnosing problems with the theme, because you can easily determine if anything is out of
 * date, needs to be updated.
 *
 * @since 1.0.0
 * @deprecated 2.0.0
 *
 * @uses PARENT_THEME_NAME
 * @uses PARENT_THEME_VERSION
 * @uses CHILD_DIR
 * @uses machina_get_option() Get theme setting value
 *
 * @return null Return early if `show_info` setting is off
 */
function machina_show_theme_info_in_head() {

	_deprecated_function( __FUNCTION__, '2.0.0', __( 'data in style sheet files', 'machina' ) );

	if ( ! machina_get_option( 'show_info' ) )
		return;

	//* Show Parent Info
	echo "\n" . '<!-- Theme Information -->' . "\n";
	echo '<meta name="wp_template" content="' . esc_attr( PARENT_THEME_NAME ) . ' ' . esc_attr( PARENT_THEME_VERSION ) . '" />' . "\n";

	//* If there is no child theme, don't continue
	if ( ! is_child_theme() )
		return;

	global $wp_version;

	//* Show Child Info
	$child_info = wp_get_theme();
	echo '<meta name="wp_theme" content="' . esc_attr( $child_info['Name'] ) . ' ' . esc_attr( $child_info['Version'] ) . '" />' . "\n";

}

/**
 * Deprecated. Helper function for dealing with entities.
 *
 * It passes text through the g_ent filter so that entities can be converted on-the-fly.
 *
 * @since 1.5.0
 * @deprecated 2.0.0
 *
 * @param string $text Optional string containing an entity.
 *
 * @return mixed Return a string by default, but might be filtered to return another type.
 */
function g_ent( $text = '' ) {

	_deprecated_function( __FUNCTION__, '2.0.0', __( 'decimal or hexidecimal entities', 'machina' ) );

	return apply_filters( 'g_ent', $text );

}

/**
 * Deprecated. Remove the Machina theme files from the Theme Editor, except when Machina is the current theme.
 *
 * @since 1.4.0
 * @deprecated 2.0.0
 */
function machina_theme_files_to_edit() {

	_deprecated_function( __FUNCTION__, '2.0.0' );

}

/**
 * Deprecated. Add links to the contents of a tweet.
 *
 * Takes the content of a tweet, detects @replies, #hashtags, and http:// URLs, and links them appropriately.
 *
 * @since 1.1.0
 * @deprecated 2.0.0
 *
 * @link http://www.snipe.net/2009/09/php-twitter-clickable-links/
 *
 * @param string $text A string representing the content of a tweet.
 *
 * @return string Linkified tweet content.
 */
function machina_tweet_linkify( $text ) {

	_deprecated_function( __FUNCTION__, '2.0.0' );

	$text = preg_replace( "#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", '\\1<a href="\\2" target="_blank">\\2</a>', $text );
	$text = preg_replace( "#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", '\\1<a href="http://\\2" target="_blank">\\2</a>', $text );
	$text = preg_replace( '/@(\w+)/', '<a href="http://www.twitter.com/\\1" target="_blank">@\\1</a>', $text );
	$text = preg_replace( '/#(\w+)/', '<a href="http://search.twitter.com/search?q=\\1" target="_blank">#\\1</a>', $text );

	return $text;

}

/**
 * Deprecated. Provide a callback function for the custom header admin page.
 *
 * @since 1.6.0
 * @deprecated 2.0.0
 */
function machina_custom_header_admin_style() {

	_deprecated_function( __FUNCTION__, '2.0.0' );

}

/**
 * Deprecated. Filter the attributes array in the `wp_get_attachment_image()` function.
 *
 * For some reason, the `wp_get_attachment_image()` function uses the caption field value as the alt text, not the
 * Alternate Text field value. Strange.
 *
 * @since 0.1.8
 * @deprecated 1.8.0
 *
 * @param array    $attr       Associative array of image attributes and values.
 * @param stdClass $attachment Attachment (Post) object.
 */
function machina_filter_attachment_image_attributes( array $attr, $attachment ) {

	_deprecated_function( __FUNCTION__, '1.8.0' );

}

/**
 * Deprecated. Create a category checklist.
 *
 * @since 0.2
 * @deprecated 1.8.0
 *
 * @param string $name     Input name (will be an array) of checkboxes.
 * @param array  $selected Optional. Array of checked inputs. Default is empty array.
 */
function machina_page_checklist( $name, array $selected = array() ) {

	_deprecated_function( __FUNCTION__, '1.8.0' );

}

/**
 * Deprecated. Create a category checklist.
 *
 * @since 0.2
 * @deprecated 1.8.0
 *
 * @param string $name     Input name (will be an array) of checkboxes.
 * @param array  $selected Optional. Array of checked inputs. Default is empty array.
 */
function machina_category_checklist( $name, array $selected = array() ) {

	_deprecated_function( __FUNCTION__, '1.8.0' );

}

/**
 * Deprecated. Wrapper for `machina_pre` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_pre() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_pre' )" );

	do_action( 'machina_pre' );

}

/**
 * Deprecated. Wrapper for `machina_pre_framework` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_pre_framework() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_pre_framework' )" );

	do_action( 'machina_pre_framework' );

}

/**
 * Deprecated. Wrapper for `machina_init` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_init() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_init' )" );

	do_action( 'machina_init' );

}

/**
 * Deprecated. Wrapper for `machina_doctype` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_doctype() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_doctype' )" );

	do_action( 'machina_doctype' );

}

/**
 * Deprecated. Wrapper for `machina_title` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_title() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_title' )" );

	do_action( 'machina_title' );

}

/**
 * Deprecated. Wrapper for `machina_meta` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_meta() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_meta' )" );

	do_action( 'machina_meta' );

}

/**
 * Deprecated. Wrapper for `machina_before` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before' )" );

	do_action( 'machina_before' );

}

/**
 * Deprecated. Wrapper for `machina_after` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after' )" );

	do_action( 'machina_after' );

}

/**
 * Deprecated. Wrapper for `machina_before_header` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_header() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_header' )" );

	do_action( 'machina_before_header' );

}

/**
 * Deprecated. Wrapper for `machina_header` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_header() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_header' )" );

	do_action( 'machina_header' );

}

/**
 * Deprecated. Wrapper for `machina_header_right` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_header_right() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_header_right' )" );

	do_action( 'machina_header_right' );

}

/**
 * Deprecated. Wrapper for `machina_after_header` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_header() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_header' )" );

	do_action( 'machina_after_header' );

}

/**
 * Deprecated. Wrapper for `machina_site_title` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_site_title() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_site_title' )" );

	do_action( 'machina_site_title' );

}

/**
 * Deprecated. Wrapper for `machina_site_description` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_site_description() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_site_description' )" );

	do_action( 'machina_site_description' );

}

/**
 * Deprecated. Wrapper for `machina_before_content_sidebar_wrap` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_content_sidebar_wrap() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_content_sidebar_wrap' )" );

	do_action( 'machina_before_content_sidebar_wrap' );

}

/**
 * Deprecated. Wrapper for `machina_after_content_sidebar_wrap` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_content_sidebar_wrap() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_content_sidebar_wrap' )" );

	do_action( 'machina_after_content_sidebar_wrap' );

}

/**
 * Deprecated. Wrapper for `machina_before_content` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_content() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_content' )" );

	do_action( 'machina_before_content' );

}

/**
 * Deprecated. Wrapper for `machina_after_content` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_content() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_content' )" );

	do_action( 'machina_after_content' );

}

/**
 * Deprecated. Wrapper for `machina_home` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_home() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_home' )" );

	do_action( 'machina_home' );

}

/**
 * Deprecated. Wrapper for `machina_before_loop` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_loop() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_loop' )" );

	do_action( 'machina_before_loop' );

}

/**
 * Deprecated. Wrapper for `machina_loop` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_loop() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_loop' )" );

	do_action( 'machina_loop' );

}

/**
 * Deprecated. Wrapper for `machina_after_loop` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_loop() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_loop' )" );

	do_action( 'machina_after_loop' );

}

/**
 * Deprecated. Wrapper for `machina_before_post` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_post() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_post' )" );

	do_action( 'machina_before_post' );

}

/**
 * Deprecated. Wrapper for `machina_after_post` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_post() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_post' )" );

	do_action( 'machina_after_post' );

}

/**
 * Deprecated. Wrapper for `machina_before_post_title` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_post_title() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_post_title' )" );

	do_action( 'machina_before_post_title' );

}

/**
 * Deprecated. Wrapper for `machina_post_title` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_post_title() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_post_title' )" );

	do_action( 'machina_post_title' );

}

/**
 * Deprecated. Wrapper for `machina_after_post_title` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_post_title() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_post_title' )" );

	do_action( 'machina_after_post_title' );

}

/**
 * Deprecated. Wrapper for `machina_before_post_content` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_post_content() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_post_content' )" );

	do_action( 'machina_before_post_content' );

}

/**
 * Deprecated. Wrapper for `machina_post_content` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_post_content() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_post_content' )" );

	do_action( 'machina_post_content' );

}

/**
 * Deprecated. Wrapper for `machina_after_post_content` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_post_content() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_post_content' )" );

	do_action( 'machina_after_post_content' );

}

/**
 * Deprecated. Wrapper for `machina_after_endwhile` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_endwhile() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_endwhile' )" );

	do_action( 'machina_after_endwhile' );

}

/**
 * Deprecated. Wrapper for `machina_loop_else` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_loop_else() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_loop_else' )" );

	do_action( 'machina_loop_else' );

}

/**
 * Deprecated. Wrapper for `machina_before_comments` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_comments() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_comments' )" );

	do_action( 'machina_before_comments' );

}

/**
 * Deprecated. Wrapper for `machina_comments` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_comments() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_comments' )" );

	do_action( 'machina_comments' );

}

/**
 * Deprecated. Wrapper for `machina_list_comments` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_list_comments() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_list_comments' )" );

	do_action( 'machina_list_comments' );

}

/**
 * Deprecated. Wrapper for `machina_after_comments` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_comments() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_comments' )" );

	do_action( 'machina_after_comments' );

}

/**
 * Deprecated. Wrapper for `machina_before_pings` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_pings() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_pings' )" );

	do_action( 'machina_before_pings' );

}

/**
 * Deprecated. Wrapper for `machina_pings` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_pings() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_pings' )" );

	do_action( 'machina_pings' );

}

/**
 * Deprecated. Wrapper for `machina_list_pings` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_list_pings() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_list_pings' )" );

	do_action( 'machina_list_pings' );

}

/**
 * Deprecated. Wrapper for `machina_after_pings` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_pings() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_pings' )" );

	do_action( 'machina_after_pings' );

}

/**
 * Deprecated. Wrapper for `machina_before_comment` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_comment() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_comment' )" );

	do_action( 'machina_before_comment' );

}

/**
 * Deprecated. Wrapper for `machina_after_comment` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_comment() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_comment' )" );

	do_action( 'machina_after_comment' );

}

/**
 * Deprecated. Wrapper for `machina_before_comment_form` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_comment_form() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_comment_form' )" );

	do_action( 'machina_before_comment_form' );

}

/**
 * Deprecated. Wrapper for `machina_comment_form` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_comment_form() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_comment_form' )" );

	do_action( 'machina_comment_form' );

}

/**
 * Deprecated. Wrapper for `machina_after_comment_form` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_comment_form() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_comment_form' )" );

	do_action( 'machina_after_comment_form' );

}

/**
 * Deprecated. Wrapper for `machina_before_sidebar_widget_area` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_sidebar_widget_area() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_sidebar_widget_area' )" );

	do_action( 'machina_before_sidebar_widget_area' );

}

/**
 * Deprecated. Wrapper for `machina_sidebar` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_sidebar() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_sidebar' )" );

	do_action( 'machina_sidebar' );

}

/**
 * Deprecated. Wrapper for `machina_after_sidebar_widget_area` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_sidebar_widget_area() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_sidebar_widget_area' )" );

	do_action( 'machina_after_sidebar_widget_area' );

}

/**
 * Deprecated. Wrapper for `machina_before_sidebar_alt_widget_area` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_sidebar_alt_widget_area() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_sidebar_alt_widget_area' )" );

	do_action( 'machina_before_sidebar_alt_widget_area' );

}

/**
 * Deprecated. Wrapper for `machina_sidebar_alt` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_sidebar_alt() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_sidebar_alt' )" );

	do_action( 'machina_sidebar_alt' );

}

/**
 * Deprecated. Wrapper for `machina_after_sidebar_alt_widget_area` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_sidebar_alt_widget_area() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_sidebar_alt_widget_area' )" );

	do_action( 'machina_after_sidebar_alt_widget_area' );

}

/**
 * Deprecated. Wrapper for `machina_before_footer` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_before_footer() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_before_footer' )" );

	do_action( 'machina_before_footer' );

}

/**
 * Deprecated. Wrapper for `machina_footer` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_footer() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_footer' )" );

	do_action( 'machina_footer' );

}

/**
 * Deprecated. Wrapper for `machina_after_footer` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_after_footer() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_after_footer' )" );

	do_action( 'machina_after_footer' );

}

/**
 * Deprecated. Wrapper for `machina_import_export_form` action hook.
 *
 * @since 0.2.0
 * @deprecated 1.7.0
 */
function machina_import_export_form() {

	_deprecated_function( __FUNCTION__, '1.7.0', "do_action( 'machina_import_export_form' )" );

	do_action( 'machina_import_export_form' );

}

/**
 * Deprecated. Hook this function to `wp_head()` and you'll be able to use many of the new IE8 functionality.
 *
 * Not loaded by default.
 *
 * @since 0.2.3
 * @deprecated 1.6.0
 *
 * @link http://ie7-js.googlecode.com/svn/test/index.html
 */
function machina_ie8_js() {

	_deprecated_function( __FUNCTION__, '1.6.0' );

}

/**
 * Deprecated. The Machina-specific post date.
 *
 * @since 0.2.3
 * @deprecated 1.5.0
 *
 * @see machina_post_date_shortcode()
 *
 * @param string $format Optional. Date format. Default is post date format saved in settings.
 * @param string $label  Optional. Label before date. Default is empty string.
 */
function machina_post_date( $format = '', $label = '' ) {

	_deprecated_function( __FUNCTION__, '1.5.0', 'machina_post_date_shortcode()' );

	echo machina_post_date_shortcode( array( 'format' => $format, 'label' => $label ) );

}

/**
 * Deprecated. The Machina-specific post author link.
 *
 * @since 0.2.3
 * @deprecated 1.5.0
 *
 * @see machina_post_author_posts_link_shortcode()
 *
 * @param string $label Optional. Label before link. Default is empty string.
 */
function machina_post_author_posts_link( $label = '' ) {

	_deprecated_function( __FUNCTION__, '1.5.0', 'machina_post_author_posts_link_shortcode()' );

	echo machina_post_author_posts_link_shortcode( array( 'before' => $label ) );

}

/**
 * Deprecated. The Machina-specific post comments link.
 *
 * @since 0.2.3
 * @deprecated 1.5.0
 *
 * @see machina_post_comments_shortcode()
 *
 * @param string $zero Optional. Text when there are no comments. Default is "No Comments".
 * @param string $one  Optional. Text when there is exactly one comment. Default is "1 Comment".
 * @param string $more Optional. Text when there is more than one comment. Default is "% Comments".
 */
function machina_post_comments_link( $zero = false, $one = false, $more = false ) {

	_deprecated_function( __FUNCTION__, '1.5.0', 'machina_post_comments_shortcode()' );

	echo machina_post_comments_shortcode( array( 'zero' => $zero, 'one' => $one, 'more' => $more ) );

}

/**
 * Deprecated. The Machina-specific post categories link.
 *
 * @since 0.2.3
 * @deprecated 1.5.0
 *
 * @see machina_post_categories_shortcode()
 *
 * @param string $sep   Optional. Separator between categories. Default is ", ".
 * @param string $label Optional. Label before first category. Default is empty string.
 */
function machina_post_categories_link( $sep = ', ', $label = '' ) {

	_deprecated_function( __FUNCTION__, '1.5.0', 'machina_post_categories_shortcode()' );

	echo machina_post_categories_shortcode( array( 'sep' => $sep, 'before' => $label ) );

}

/**
 * Deprecated. The Machina-specific post tags link.
 *
 * @since 0.2.3
 * @deprecated 1.5.0
 *
 * @see machina_post_tags_shortcode()
 *
 * @param string $sep   Optional. Separator between tags. Default is ", ".
 * @param string $label Optional. Label before first tag. Default is empty string.
 */
function machina_post_tags_link( $sep = ', ', $label = '' ) {

	_deprecated_function( __FUNCTION__, '1.5.0', 'machina_post_tags_shortcode()' );

	echo machina_post_tags_shortcode( array( 'sep' => $sep, 'before' => $label ) );

}

/**
 */
/**
 * Deprecated. Allow a child theme to add new image sizes.
 *
 * Use `add_image_size()` instead.
 *
 * @since 0.1.7
 * @deprecated 1.2.0
 *
 * @param string  $name   Name of the image size.
 * @param integer $width  Width of the image size.
 * @param integer $height Height of the image size.
 * @param boolean $crop   Whether to crop or not.
 */
function machina_add_image_size( $name, $width = 0, $height = 0, $crop = false ) {

	_deprecated_function( __FUNCTION__, '1.2.0', 'add_image_size()' );

	add_image_size( $name, $width, $height, $crop );

}

/**
 * Deprecated. Filter intermediate sizes for WP 2.8 backward compatibility.
 *
 * @since 0.1.7
 * @deprecated 1.2.0
 *
 * @param array $sizes Array of sizes to add.
 *
 * @return array Empty array.
 */
function machina_add_intermediate_sizes( array $sizes ) {

	_deprecated_function( __FUNCTION__, '1.2.0' );

	return array();

}

/**
 * Deprecated. Was a wrapper for `machina_comment` hook, but now calls `machina_after_comment` action hook instead.
 *
 * @since 0.2.0
 * @deprecated 1.2.0
 */
function machina_comment() {

	_deprecated_function( __FUNCTION__, '1.2.0', "do_action( 'machina_after_comment' )" );

	do_action( 'machina_after_comment' );

}
