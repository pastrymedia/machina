<?php
/**
 * Machina Framework.
 *
 * WARNING: This file is part of the core Machina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Machina\Layout
 * @author  MachinaThemes
 * @license GPL-2.0+
 * @link    http://my.machinathemes.com/themes/machina/
 */

add_filter( 'content_width', 'machina_content_width', 10, 3 );
/**
 * Filter the content width based on the user selected layout.
 *
 * @since 1.6.0
 *
 * @uses machina_site_layout() Get the site layout for current context.
 *
 * @param integer $default Default width.
 * @param integer $small   Small width.
 * @param integer $large   Large width.
 *
 * @return integer Content width.
 */
function machina_content_width( $default, $small, $large ) {

	switch ( machina_site_layout( 0 ) ) {
		case 'full-width-content':
			$width = $large;
			break;
		case 'content-sidebar-sidebar':
		case 'sidebar-content-sidebar':
		case 'sidebar-sidebar-content':
			$width = $small;
			break;
		default:
			$width = $default;
	}

	return $width;

}

add_filter( 'body_class', 'machina_custom_body_class', 15 );
/**
 * Add custom field body class(es) to the body classes.
 *
 * It accepts values from a per-post or per-page custom field, and only outputs when viewing a singular page.
 *
 * @since 1.4.0
 *
 * @uses machina_get_custom_field() Get custom field value.
 *
 * @param array $classes Existing classes.
 *
 * @return array Amended classes.
 */
function machina_custom_body_class( array $classes ) {

	$new_class = is_singular() ? machina_get_custom_field( '_machina_custom_body_class' ) : null;

	if ( $new_class )
		$classes[] = esc_attr( $new_class );

	return $classes;

}

add_filter( 'body_class', 'machina_header_body_classes' );
/**
 * Add header-* classes to the body class.
 *
 * We can use pseudo-variables in our CSS file, which helps us achieve multiple header layouts with minimal code.
 *
 * @since 0.2.2
 *
 * @uses machina_get_option() Get theme setting value.
 *
 * @param array $classes Existing classes.
 *
 * @return array Amended classes.
 */
function machina_header_body_classes( array $classes ) {

	if ( current_theme_supports( 'custom-header' ) ) {
		if ( get_theme_support( 'custom-header', 'default-text-color' ) !== get_header_textcolor() || get_theme_support( 'custom-header', 'default-image' ) !== get_header_image() )
			$classes[] = 'custom-header';
	}

	if ( 'image' === machina_get_option( 'blog_title' ) || ( get_header_image() && ! display_header_text() ) )
		$classes[] = 'header-image';

	if ( ! is_active_sidebar( 'header-right' ) && ! has_action( 'machina_header_right' ) )
		$classes[] = 'header-full-width';

	return $classes;

}

add_filter( 'body_class', 'machina_layout_body_classes' );
/**
 * Add site layout classes to the body classes.
 *
 * We can use pseudo-variables in our CSS file, which helps us achieve multiple site layouts with minimal code.
 *
 * @since 0.2.2
 *
 * @uses machina_site_layout() Return the site layout for different contexts.
 *
 * @param array $classes Existing classes.
 *
 * @return array Amended classes.
 */
function machina_layout_body_classes( array $classes ) {

	$site_layout = machina_site_layout();

	if ( $site_layout )
		$classes[] = $site_layout;

	return $classes;

}

add_filter( 'body_class', 'machina_style_selector_body_classes' );
/**
 * Add style selector classes to the body classes.
 *
 * Enables style selector support in child themes, which helps us achieve multiple site styles with minimal code.
 *
 * @since 1.8.0
 *
 * @uses machina_get_option() Get theme setting value.
 *
 * @param array $classes Existing classes.
 *
 * @return array Amended classes.
 */
function machina_style_selector_body_classes( array $classes ) {

	$current = machina_get_option( 'style_selection' );

	if ( $current )
		$classes[] = esc_attr( sanitize_html_class( $current ) );

	return $classes;

}

add_filter( 'body_class', 'machina_cpt_archive_body_class', 15 );
/**
 * Adds a custom class to the custom post type archive body classes.
 *
 * It accepts a value from the archive settings page.
 *
 * @since 2.0.0
 *
 * @uses machina_has_post_type_archive_support() Check if current CPT has archive support.
 * @uses machina_get_cpt_option()                Get CPT Archive setting.
 *
 * @param array $classes Existing classes.
 *
 * @return array Amended classes.
 */
function machina_cpt_archive_body_class( array $classes ) {

	if ( ! is_post_type_archive() || ! machina_has_post_type_archive_support() )
		return $classes;

	$new_class = machina_get_cpt_option( 'body_class' );

	if ( $new_class )
		$classes[] = esc_attr( sanitize_html_class( $new_class ) );

	return $classes;

}

add_action( 'machina_after_content', 'machina_get_sidebar' );
/**
 * Output the sidebar.php file if layout allows for it.
 *
 * @since 0.2.0
 *
 * @uses machina_site_layout() Return the site layout for different contexts.
 */
function machina_get_sidebar() {

	$site_layout = machina_site_layout();

	//* Don't load sidebar on pages that don't need it
	if ( 'full-width-content' === $site_layout )
		return;

	get_sidebar();

}

add_action( 'machina_after_content_sidebar_wrap', 'machina_get_sidebar_alt' );
/**
 * Output the sidebar_alt.php file if layout allows for it.
 *
 * @since 0.2.0
 *
 * @uses machina_site_layout() Return the site layout for different contexts.
 */
function machina_get_sidebar_alt() {

	$site_layout = machina_site_layout();

	//* Don't load sidebar-alt on pages that don't need it
	if ( in_array( $site_layout, array( 'content-sidebar', 'sidebar-content', 'full-width-content' ) ) )
		return;

	get_sidebar( 'alt' );

}
