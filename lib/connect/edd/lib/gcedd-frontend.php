<?php
/**
 * Load the needed frontend logic/functions.
 *
 * @package    Machina Connect for Easy Digital Downloads
 * @subpackage Frontend
 *
 * @author     Machina Themes
 * @link       http://machinathemes.com
 * @link       http://machinathemes.com/twitter
 *
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @copyright  Copyright (c) 2012-2013, Machina Themes
 *
 * @since      1.0.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Sets the Machina Post Meta for the Download post type
 * to use "edd_download_category" and "edd_download_tag" taxonomies
 * and for backward compatibility to use "download_category" and "download_tag" taxonomies
 *
 * @since  1.0.0
 *
 * @uses   is_page()
 * @uses   taxonomy_exists()
 * @uses   ddw_gcedd_download_cpt()
 * @uses   wp_get_object_terms()
 * @uses   get_post_type()
 * @uses   do_shortcode()
 *
 * @param  $post_meta
 * @param  $download_cpt
 * @param  $terms_edd_categories
 * @param  $terms_edd_tags
 *
 * @global $post
 *
 * @return strings Post meta info for "Download" post type taxonomies
 */
function gcedd_post_meta( $post_meta ) {

    global $post;

    /** Bail early, if we are not on a page, and, if EDD taxonomies do not exist. */
	if ( is_page() && taxonomy_exists( array( 'download_category', 'download_tag' ) ) ) {
		return;
	}

	/** Get "Download" CPT slug */
	$download_cpt = ddw_gcedd_download_cpt();

	$terms_edd_categories = wp_get_object_terms( $post->ID, 'download_category' );
	$terms_edd_tags = wp_get_object_terms( $post->ID, 'download_tag' );

	/** Modify Post Meta for EDD Downloads */
	if ( $download_cpt == get_post_type() ) {

		/** Case I: post has terms for both tax */
		if ( ( count( $terms_edd_categories ) > 0 ) && ( count( $terms_edd_tags ) > 0 ) ) {

			$post_meta = do_shortcode( '[post_terms taxonomy="' . $download_cpt . '_category"] <span class="post-meta-sep">' . _x( '&#x00B7;', 'Translators: Taxonomy separator for Machina child themes (default: &#x00B7; = &middot;)', 'machina' ) . '</span> [post_terms before="' . __( 'Tagged:', 'machina' ) . ' " taxonomy="' . $download_cpt . '_tag"]<br /><br />' );

		}

		/** Case II: post has terms only for category */
		elseif ( ( count( $terms_edd_categories ) > 0 ) && ! $terms_edd_tags ) {

			$post_meta = do_shortcode( '[post_terms taxonomy="' . $download_cpt . '_category"]<br /><br />' );

		}

		/** Case III: post has terms only for tag */
		elseif ( ! $terms_edd_categories && ( count( $terms_file_tags ) > 0 ) ) {

			$post_meta = do_shortcode( '[post_terms before="' . __( 'Tagged:', 'machina' ) . ' " taxonomy="' . $download_cpt . '_tag"]<br /><br />' );

		}

		/** Case IV: post has no terms for both tax */
		elseif ( ! $terms_edd_categories && ! $terms_edd_tags ) {

			$post_meta = '';

		}  // end-if/elseif taxonomy checks

	}  // end-if cpt check

    /** Return altered Post Meta string to Machina filter */
	return $post_meta;

}  // end of function gcedd_post_meta