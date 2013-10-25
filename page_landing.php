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
add_filter( 'body_class', 'add_landing_page_body_class' );
/**
 * Add page specific body class
 *
 * @param $classes array Body Classes
 * @return $classes array Modified Body Classes
 */
function add_landing_page_body_class( $classes ) {
   $classes[] = 'template-landing';
   return $classes;
}

/** Force Layout */
add_filter( 'machina_pre_get_option_site_layout', '__machina_return_full_width_content' );
add_filter( 'machina_site_layout', '__machina_return_full_width_content' );

/** Remove Header */
remove_action( 'machina_header', 'machina_header_markup_open', 5 );
remove_action( 'machina_header', 'machina_do_header' );
remove_action( 'machina_header', 'machina_header_markup_close', 15 );

/** Remove Nav */
remove_action( 'machina_after_header', 'machina_do_nav' );
remove_action( 'machina_after_header', 'machina_do_subnav', 15 );

/** Remove Breadcrumbs */
remove_action( 'machina_before_loop', 'machina_do_breadcrumbs');

/** Remove Footer Widgets */
remove_action( 'machina_before_footer', 'machina_footer_widget_areas' );

/** Remove Footer */
remove_action( 'machina_footer', 'machina_footer_markup_open', 5 );
remove_action( 'machina_footer', 'machina_do_footer' );
remove_action( 'machina_footer', 'machina_footer_markup_close', 15 );

machina();