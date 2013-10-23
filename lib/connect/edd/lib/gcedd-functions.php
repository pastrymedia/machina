<?php
/**
 * Load the needed helper logic/ functions.
 *
 * @package    Machina Connect for Easy Digital Downloads
 * @subpackage Helper Functions
 *
 * @author     Machina Themes
 * @link       http://machinathemes.com
 * @link       http://machinathemes.com/twitter
 *
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @copyright  Copyright (c) 2012-2013, Machina Themes
 *
 * @since      1.1.0
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
 * Check and retrieve the correct ID/tag of the registered post type 'Download' by EDD.
 *
 * @since  1.1.0
 *
 * @uses   post_type_exists()
 *
 * @param  $gcedd_download_cpt
 *
 * @return string "Downloads" post type slug.
 */
function ddw_gcedd_download_cpt() {

	/** Get the proper 'Download' post type ID/tag */
	if ( post_type_exists( 'edd_download' ) ) {

		$gcedd_download_cpt = 'edd_download';

	} elseif ( post_type_exists( 'download' ) ) {

		$gcedd_download_cpt = 'download';

	}

	/** EDD "Downloads" post type slug */
	return $gcedd_download_cpt;

}  // end of function ddw_gcedd_download_cpt


/**
 * Get the EDD "Downloads" CPT label name (plural).
 *
 * @since  1.2.0
 *
 * @uses   get_post_type_object()
 * @uses   ddw_gcedd_download_cpt()
 *
 * @param  $edd_cpt_object
 *
 * @return string "Downloads" post type label (the plural form here).
 */
function ddw_gcedd_downloads_label() {

	/** Get the post type object */
	$edd_cpt_object = get_post_type_object( ddw_gcedd_download_cpt() );

	/** Get the (plural) label name */
	$edd_cpt_object = $edd_cpt_object->labels->name;

	/** Return the label name - filterable */
	return apply_filters( 'gcedd_filter_downloads_label', $edd_cpt_object );

}  // end of function ddw_gcedd_downloads_label

