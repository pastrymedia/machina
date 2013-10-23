<?php
/*
 WARNING: This file is part of the core Machina Framework. DO NOT edit
 this file under any circumstances. Please do all modifications
 in the form of a child theme.
 */

/**
 * This file calls the init.php file, but only
 * if the child theme hasn't called it first.
 *
 * This method allows the child theme to load
 * the framework so it can use the framework
 * components immediately.
 *
 * This file is a core Machina file and should not be edited.
 *
 * @category Machina
 * @package  Templates
 * @author   MachinaThemes
 * @license  GPL-2.0+
 * @link     http://my.machinathemes.com/themes/machina
 */

require_once( dirname( __FILE__ ) . '/lib/init.php' );

//* Add a custom post type
add_action( 'init', 'cd_post_type' );
function cd_post_type() {
  // Portfolio custom post type
  register_post_type( 'portfolio',
    array(
      'labels' => array(
        'name' => __( 'Portfolio' ),
        'singular_name' => __( 'Portfolio' ),
      ),
      'has_archive' => true,
      'public' => true,
      'show_ui' => true, // defaults to true so don't have to include
      'show_in_menu' => true, // defaults to true so don't have to include
      'rewrite' => array( 'slug' => 'portfolio' ),
      'supports' => array( 'title', 'editor', 'machina-seo', 'thumbnail','machina-cpt-archives-settings' ),
    )
  );
}
