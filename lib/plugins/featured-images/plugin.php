<?php
/*
Plugin Name: Machina Featured Images
Description: The first generation of this plugin will set a default image for post thumbnails for the Machina framework.
Version: 0.4.1
License: GPLv2
*/

define( 'GFI_DOMAIN' , 'machina-featured-images' );
define( 'GFI_PLUGIN_DIR', dirname( __FILE__ ) );
define( "GFI_URL" , WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) );

/* Prevent direct access to the plugin */
if ( !defined( 'ABSPATH' ) ) {
    wp_die( __( "Sorry, you are not allowed to access this page directly.", 'GFI' ) );
}


add_action( 'machina_init', 'gfi_init', 15 );
/** Loads required files when needed */
function gfi_init() {

	require_once(GFI_PLUGIN_DIR . '/lib/default-feature-img.php');
	require_once(GFI_PLUGIN_DIR . '/lib/metaboxes.php');

}


add_action( 'get_header', 'gfi_remove_do_post_image' );
/**
 * Replace some machina_* functions hooked into somewhere for some gfi_* functions
 * of the same suffix, at the same hook and priority
 *
 *
 * @global array $wp_filter
 */
function gfi_remove_do_post_image() {

    global $wp_filter;

    // List of machina_* functions to be replaced with gfi_* functions.
    // We save some bytes and add the ubiquitous 'machina_' later on.
    $functions = array(
        'do_post_image',
    );

    // Loop through all hooks (yes, stored under the $wp_filter global)
    foreach ( $wp_filter as $hook => $priority)  {

        // Loop through our array of functions for each hook
        foreach( $functions as $function) {

            // has_action returns int for the priority
            if ( $priority = has_action( $hook, 'machina_' . $function ) ) {

                // If there's a function hooked in, remove the machina_* function
                // from whichever hook we're looping through at the time.
                remove_action( $hook, 'machina_' . $function, $priority );

                // Add a replacement function in at an earlier time.
                add_action( $hook, 'gfi_' . $function, 5 );
            }
        }
    }
}

//add_action( 'machina_entry_content' , 'gfi_do_post_image' );
function gfi_do_post_image() {
	global $prefix;
	if ( ! is_singular() && machina_get_option( 'content_archive_thumbnail' ) ) {
		if ( machina_get_custom_field( $prefix . 'custom_feat_img' ) )
			$img = machina_get_image( array( 'format' => 'html', 'size' => machina_get_custom_field( $prefix . 'custom_feat_img' ), 'attr' => array( 'class' => 'alignleft post-image' ) ) );
		else
			$img = machina_get_image( array( 'format' => 'html', 'size' => machina_get_option( 'image_size' ), 'attr' => array( 'class' => 'alignleft post-image' ) ) );
		printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
	}
}



?>