<?php
/**
 * Machina Framework.
 *
 * WARNING: This file is part of the core Machina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Machina\Menus
 * @author  MachinaThemes
 * @license GPL-2.0+
 * @link    http://my.machinathemes.com/themes/machina/
 */

add_action( 'after_setup_theme', 'machina_register_nav_menus' );
/**
 * Register the custom menu locations, if theme has support for them.
 *
 * Does the `machina_register_nav_menus` action.
 *
 * @since 1.8.0
 *
 * @return null Returns early if no Machina menus are supported.
 */
function machina_register_nav_menus() {

	if ( ! current_theme_supports( 'machina-menus' ) )
		return;

	$menus = get_theme_support( 'machina-menus' );

	//* Register supported menus
	foreach ( (array) $menus[0] as $id => $name ) {
		register_nav_menu( $id, $name );
	}

	do_action( 'machina_register_nav_menus' );

}

add_action( 'machina_after_header', 'machina_do_nav' );
/**
 * Echo the "Primary Navigation" menu.
 *
 * The preferred option for creating menus is the Custom Menus feature in WordPress. There is also a fallback to using
 * the Machina wrapper functions for creating a menu of Pages, or a menu of Categories (maintained only for backwards
 * compatibility).
 *
 * Either output can be filtered via `machina_do_nav`.
 *
 * @since 1.0.0
 *
 * @uses machina_nav_menu_supported() Checks for support of specific nav menu.
 * @uses machina_markup()             Contextual markup.
 * @uses machina_html5()              Check for HTML5 support.
 * @uses machina_structural_wrap()    Adds optional internal wrap divs.
 */
function machina_do_nav() {

	//* Do nothing if menu not supported
	if ( ! machina_nav_menu_supported( 'primary' ) )
		return;

	//* If menu is assigned to theme location, output
	if ( has_nav_menu( 'primary' ) ) {

		$class = 'menu machina-nav-menu menu-primary';
		if ( machina_superfish_enabled() )
			$class .= ' js-superfish';

		$args = array(
			'theme_location' => 'primary',
			'container'      => '',
			'menu_class'     => $class,
			'echo'           => 0,
		);

		$nav = wp_nav_menu( $args );

		//* Do nothing if there is nothing to show
		if ( ! $nav )
			return;

		$nav_markup_open = machina_markup( array(
			'html5'   => '<nav %s>',
			'xhtml'   => '<div id="nav">',
			'context' => 'nav-primary',
			'echo'    => false,
		) );
		$nav_markup_open .= machina_structural_wrap( 'menu-primary', 'open', 0 );

		$nav_markup_close  = machina_structural_wrap( 'menu-primary', 'close', 0 );
		$nav_markup_close .= machina_html5() ? '</nav>' : '</div>';

		$nav_output = $nav_markup_open . $nav . $nav_markup_close;

		echo apply_filters( 'machina_do_nav', $nav_output, $nav, $args );

	}

}

add_action( 'machina_after_header', 'machina_do_subnav' );
/**
 * Echo the "Secondary Navigation" menu.
 *
 * The preferred option for creating menus is the Custom Menus feature in WordPress. There is also a fallback to using
 * the Machina wrapper functions for creating a menu of Pages, or a menu of Categories (maintained only for backwards
 * compatibility).
 *
 * Either output can be filtered via `machina_do_subnav`.
 *
 * @since 1.0.0
 *
 * @uses machina_nav_menu_supported() Checks for support of specific nav menu.
 * @uses machina_markup()             Contextual markup.
 * @uses machina_html5()              Check for HTML5 support.
 * @uses machina_structural_wrap()    Adds optional internal wrap divs.
 */
function machina_do_subnav() {

	//* Do nothing if menu not supported
	if ( ! machina_nav_menu_supported( 'secondary' ) )
		return;

	//* If menu is assigned to theme location, output
	if ( has_nav_menu( 'secondary' ) ) {

		$class = 'menu machina-nav-menu menu-secondary';
		if ( machina_superfish_enabled() )
			$class .= ' js-superfish';

		$args = array(
			'theme_location' => 'secondary',
			'container'      => '',
			'menu_class'     => $class,
			'echo'           => 0,
		);

		$subnav = wp_nav_menu( $args );

		//* Do nothing if there is nothing to show
		if ( ! $subnav )
			return;

		$subnav_markup_open = machina_markup( array(
			'html5'   => '<nav %s>',
			'xhtml'   => '<div id="subnav">',
			'context' => 'nav-secondary',
			'echo'    => false,
		) );
		$subnav_markup_open .= machina_structural_wrap( 'menu-secondary', 'open', 0 );

		$subnav_markup_close  = machina_structural_wrap( 'menu-secondary', 'close', 0 );
		$subnav_markup_close .= machina_html5() ? '</nav>' : '</div>';

		$subnav_output = $subnav_markup_open . $subnav . $subnav_markup_close;

		echo apply_filters( 'machina_do_subnav', $subnav_output, $subnav, $args );

	}

}

add_filter( 'wp_nav_menu_items', 'machina_nav_right', 10, 2 );
/**
 * Filter the Primary Navigation menu items, appending either RSS links, search form, twitter link, or today's date.
 *
 * @since 1.0.0
 *
 * @uses machina_get_option() Get navigation extras settings.
 *
 * @param string   $menu HTML string of list items.
 * @param stdClass $args Menu arguments.
 *
 * @return string Amended HTML string of list items.
 */
function machina_nav_right( $menu, stdClass $args ) {

	if ( ! machina_get_option( 'nav_extras' ) || 'primary' !== $args->theme_location )
		return $menu;

	switch ( machina_get_option( 'nav_extras' ) ) {
		case 'rss':
			$rss   = '<a rel="nofollow" href="' . get_bloginfo( 'rss2_url' ) . '">' . __( 'Posts', 'machina' ) . '</a>';
			$rss  .= '<a rel="nofollow" href="' . get_bloginfo( 'comments_rss2_url' ) . '">' . __( 'Comments', 'machina' ) . '</a>';
			$menu .= '<li class="right rss">' . $rss . '</li>';
			break;
		case 'search':
			// I hate output buffering, but I have no choice
			ob_start();
			get_search_form();
			$search = ob_get_clean();
			$menu  .= '<li class="right search">' . $search . '</li>';
			break;
		case 'twitter':
			$menu .= sprintf( '<li class="right twitter"><a href="%s">%s</a></li>', esc_url( 'http://twitter.com/' . machina_get_option( 'nav_extras_twitter_id' ) ), esc_html( machina_get_option( 'nav_extras_twitter_text' ) ) );
			break;
		case 'date':
			$menu .= '<li class="right date">' . date_i18n( get_option( 'date_format' ) ) . '</li>';
			break;
	}

	return $menu;

}