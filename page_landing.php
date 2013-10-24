<?php
/**
 * This file adds the Landing template.
 *
 * @author MachinaThemes
 * @package Machina
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

// Add custom body class to the head
add_filter( 'body_class', 'add_body_class' );
function add_body_class( $classes ) {
   $classes[] = 'template-landing';
   return $classes;
}

// Remove header, navigation, breadcrumbs, footer widgets, footer
add_filter( 'machina_pre_get_option_site_layout', '__machina_return_full_width_content' );
remove_action( 'machina_header', 'machina_header_markup_open', 5 );
remove_action( 'machina_header', 'machina_do_header' );
remove_action( 'machina_header', 'machina_header_markup_close', 15 );
remove_action( 'machina_after_header', 'machina_do_nav' );
remove_action( 'machina_after_header', 'machina_do_subnav', 15 );
remove_action( 'machina_before_loop', 'machina_do_breadcrumbs');
remove_action( 'machina_before_footer', 'machina_footer_widget_areas' );
remove_action( 'machina_footer', 'machina_footer_markup_open', 5 );
remove_action( 'machina_footer', 'machina_do_footer' );
remove_action( 'machina_footer', 'machina_footer_markup_close', 15 );

machina();