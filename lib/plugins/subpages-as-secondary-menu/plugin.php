<?php
/*
Plugin Name: Machina Subpages as Secondary Menu
Description: Replaces the manually managed Secondary Menu with one that automatically lists the current section's subpages. You must be using the Machina Framework and have the Secondary Menu enabled (Machina > Theme Settings > Navigation Settings).
Version: 1.6
License: GPLv2
*/


// Add Subpages to Subnav
add_filter('machina_do_subnav', 'be_subnav');
function be_subnav( $subnav_output ){

	// Only run on pages
	if ( !is_page() )
		return;

	// Find top level parent
	global $post;
	$parent = $post;
	while( $parent->post_parent ) $parent = get_post( $parent->post_parent );

	// Build a menu listing top level parent's children
	$args = array(
		'child_of' => $parent->ID,
		'title_li' => '',
		'echo' => false,
	);
	$subnav = wp_list_pages( apply_filters( 'be_machina_subpages_args', $args ) );

	// Wrap the list items in an unordered list
	$wrapper = apply_filters( 'be_machina_subpages_wrapper', array( '<ul id="menu-machina-subpages" class="nav machina-nav-menu">', '</ul>' ) );

	// Output the menu if there is one (from machina/lib/structure/menu.php)
	if( !empty( $subnav ) )
		$subnav_output = sprintf( '<div id="subnav">%2$s%4$s%1$s%5$s%3$s</div>', $subnav, machina_structural_wrap( 'subnav', '<div class="wrap">', 0 ), machina_structural_wrap( 'subnav', '</div><!-- end .wrap -->', 0 ), $wrapper[0], $wrapper[1] );
	else
		$subnav_output = '';

	return $subnav_output;

}

// Let Machina know there's a subnav menu
add_filter( 'theme_mod_nav_menu_locations', 'be_subpages_for_secondary' );
function be_subpages_for_secondary( $locations ) {
	if( isset( $locations['secondary'] ) )
		$locations['secondary'] = 1;

	return $locations;
}

// Add menu-item class
add_filter( 'page_css_class', 'be_subnav_classes' );
function be_subnav_classes( $classes ) {
	$classes[] = 'menu-item';
	return $classes;
}