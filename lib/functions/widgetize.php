<?php
/**
 * Machina Framework.
 *
 * WARNING: This file is part of the core Machina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Machina\WidgetAreas
 * @author  MachinaThemes
 * @license GPL-2.0+
 * @link    http://my.machinathemes.com/themes/machina/
 */

/**
 * Expedites the widget area registration process by taking common things, before / after_widget, before / after_title,
 * and doing them automatically.
 *
 * See the WP function `register_sidebar()` for the list of supports $args keys.
 *
 * A typical usage is:
 *
 * ~~~
 * machina_register_sidebar(
 *     array(
 *         'id'          => 'my-sidebar',
 *         'name'        => __( 'My Sidebar', 'my-theme-text-domain' ),
 *         'description' => __( 'A description of the intended purpose or location', 'my-theme-text-domain' ),
 *     )
 * );
 * ~~~
 *
 * @since 1.0.1
 *
 * @uses machina_markup() Contextual markup.
 *
 * @param string|array $args Name, ID, description and other widget area arguments.
 *
 * @return string The sidebar ID that was added.
 */
function machina_register_sidebar( $args ) {

	$defaults = (array) apply_filters(
		'machina_register_sidebar_defaults',
		array(
			'before_widget' => machina_markup( array(
				'html5' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
				'xhtml' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrap">',
				'echo'  => false,
			) ),
			'after_widget'  => machina_markup( array(
				'html5' => '</div></section>' . "\n",
				'xhtml' => '</div></div>' . "\n",
				'echo'  => false
			) ),
			'before_title'  => '<h4 class="widget-title widgettitle">',
			'after_title'   => "</h4>\n",
		),
		$args
	);

	$args = wp_parse_args( $args, $defaults );

	return register_sidebar( $args );

}

add_action( 'after_setup_theme', '_machina_builtin_sidebar_params' );
/**
 * Alters the widget area params array for HTML5 compatibility.
 *
 * @since 2.0.0
 *
 * @global $wp_registered_sidebars
 */
function _machina_builtin_sidebar_params() {

	global $wp_registered_sidebars;

	foreach ( $wp_registered_sidebars as $id => $params ) {

		if ( ! isset( $params['_machina_builtin'] ) )
			continue;

		$wp_registered_sidebars[ $id ]['before_widget'] = '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">';
		$wp_registered_sidebars[ $id ]['after_widget']  = '</div></section>';

	}

}

add_action( 'machina_setup', 'machina_register_default_widget_areas' );
/**
 * Register the default Machina widget areas.
 *
 * @since 1.6.0
 *
 * @uses machina_register_sidebar() Register widget areas.
 */
function machina_register_default_widget_areas() {

	machina_register_sidebar(
		array(
			'id'               => 'header-right',
			'name'             => is_rtl() ? __( 'Header Left', 'machina' ) : __( 'Header Right', 'machina' ),
			'description'      => __( 'This is the widget area in the header.', 'machina' ),
			'_machina_builtin' => true,
		)
	);

	machina_register_sidebar(
		array(
			'id'               => 'sidebar',
			'name'             => __( 'Primary Sidebar', 'machina' ),
			'description'      => __( 'This is the primary sidebar if you are using a two or three column site layout option.', 'machina' ),
			'_machina_builtin' => true,
		)
	);

	machina_register_sidebar(
		array(
			'id'               => 'sidebar-alt',
			'name'             => __( 'Secondary Sidebar', 'machina' ),
			'description'      => __( 'This is the secondary sidebar if you are using a three column site layout option.', 'machina' ),
			'_machina_builtin' => true,
		)
	);

	machina_register_sidebar(
		array(
			'id'               => 'after-post',
			'name'             => __( 'After Post', 'machina' ),
			'description'      => __( 'This will show up after every post.', 'machina' ),
			'_machina_builtin' => true,
		)
	);

}

add_action( 'after_setup_theme', 'machina_register_footer_widget_areas' );
/**
 * Register footer widget areas based on the number of widget areas the user wishes to create with `add_theme_support()`.
 *
 * @since 1.6.0
 *
 * @uses machina_register_sidebar() Register footer widget areas.
 *
 * @return null Return early if there's no theme support.
 */
function machina_register_footer_widget_areas() {

	$footer_widgets = get_theme_support( 'machina-footer-widgets' );

	if ( ! $footer_widgets || ! isset( $footer_widgets[0] ) || ! is_numeric( $footer_widgets[0] ) )
		return;

	$footer_widgets = (int) $footer_widgets[0];

	$counter = 1;

	while ( $counter <= $footer_widgets ) {
		machina_register_sidebar(
			array(
				'id'               => sprintf( 'footer-%d', $counter ),
				'name'             => sprintf( __( 'Footer %d', 'machina' ), $counter ),
				'description'      => sprintf( __( 'Footer %d widget area.', 'machina' ), $counter ),
				'_machina_builtin' => true,
			)
		);

		$counter++;
	}

}

/**
 * Conditionally display a sidebar, wrapped in a div by default.
 *
 * The $args array accepts the following keys:
 *
 *  - `before` (markup to be displayed before the widget area output),
 *  - `after` (markup to be displayed after the widget area output),
 *  - `default` (fallback text if the sidebar is not found, or has no widgets, default is an empty string),
 *  - `show_inactive` (flag to show inactive sidebars, default is false),
 *  - `before_sidebar_hook` (hook that fires before the widget area output),
 *  - `after_sidebar_hook` (hook that fires after the widget area output).
 *
 * Return false early if the sidebar is not active and the `show_inactive` argument is false.
 *
 * @since 1.8.0
 *
 * @param string $id   Sidebar ID, as per when it was registered
 * @param array  $args Arguments.
 *
 * @return boolean False if $args['show_inactive'] set to false and sidebar is not currently being used. True otherwise.
 */
function machina_widget_area( $id, $args = array() ) {

	if ( ! $id )
		return false;

	$args = wp_parse_args(
		$args,
		array(
			'before'              => '<aside class="widget-area">',
			'after'               => '</aside>',
			'default'             => '',
			'show_inactive'       => 0,
			'before_sidebar_hook' => 'machina_before_' . $id . '_widget_area',
			'after_sidebar_hook'  => 'machina_after_' . $id . '_widget_area',
		)
	);

	if ( ! is_active_sidebar( $id ) && ! $args['show_inactive'] )
		return false;

	//* Opening markup
	echo $args['before'];

	//* Before hook
	if ( $args['before_sidebar_hook'] )
			do_action( $args['before_sidebar_hook'] );

	if ( ! dynamic_sidebar( $id ) )
		echo $args['default'];

	//* After hook
	if( $args['after_sidebar_hook'] )
			do_action( $args['after_sidebar_hook'] );

	//* Closing markup
	echo $args['after'];

	return true;

}
