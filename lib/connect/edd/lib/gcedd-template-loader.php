<?php
/**
 * Load the post type templates for Easy Digital Downloads
 *
 * @package    Machina Connect for Easy Digital Downloads
 * @subpackage Templates
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
 * Load the Machina-fied templates, instead of the EDD defaults.
 *
 * Hooked to 'template_include' filter
 *
 * This template loader determines which template file will be used for the
 * requested page, and uses the following hierarchy to find the template:
 * 1. First looks in the child theme's root folder.			// great for nativ EDD-supporting themes
 * 2. Secondly looks in the child theme's 'edd' folder.		// great for adding EDD support afterwards
 * 3. If no template found, falls back to the packaged Machina Connect EDD
 *    templates.
 *
 * For taxonomy templates, first looks in child theme's root folder, then the
 * 'edd' subfolder and searches for term specific template, then taxonomy
 * specific template, then taxonomy.php. If no template found, falls back to
 * Machina Connect EDD's taxonomy.php.
 *
 * Machina Connect EDD provides three plus two templates in the plugin's
 * 'templates' directory:
 * - single-download.php
 * - archive-download.php
 * - taxonomy.php
 * - plus: single-edd_download.php 	(for upcoming EDD post type ID/tag change!)
 * - plus: archive-edd_download.php (for upcoming EDD post type ID/tag change!)
 *
 * Users can override Machina Connect EDD templates by placing their own
 * templates in their child theme's root folder or 'edd' subfolder.
 * The 'edd' folder must be a folder in the child theme's root directory, e.g.
 * /wp-content/themes/your-child-theme/edd/
 * Permitted user templates (as per WordPress Template Hierarchy) are:
 * - single-download.php
 * - archive-download.php
 * - taxonomy-{taxonomy-name}-{term-name}.php
 * - taxonomy-{taxonomy-name}.php
 * - taxonomy.php
 * - plus: single-edd_download.php 	(for upcoming EDD post type ID/tag change!)
 * - plus: archive-edd_download.php (for upcoming EDD post type ID/tag change!)
 *
 * Note that in the case of taxonomy templates, this function accommodates ALL
 * taxonomies registered to the 'download' ('edd_download') custom post type.
 * This means that it will cater for users' own custom taxonomies as well as
 * EDD's.
 *
 * @uses    ddw_gcedd_download_cpt()
 * @uses    is_single()
 * @uses    get_post_type()
 * @uses    locate_template()
 * @uses    is_post_type_archive()
 * @uses    is_tax()
 *
 * @since   1.0.0
 *
 * @param   string $template Template file as per template hierarchy.
 * @param   string $download_cpt
 * @param   string $term
 * @param   string $tax
 * @param   string $taxonomies
 *
 * @return  string $template Specific Machina Connect EDD template if a download
 *                           page (single or archive) or a download taxonomy
 *                           term, or returns original template.
 */
function ddw_gcedd_template_loader( $template ) {

	$download_cpt = ddw_gcedd_download_cpt();

	/** Download single pages */
	if ( is_single() && $download_cpt == get_post_type() ) {

		/** Use custom template via child theme (child root) */
		$template = locate_template( array( 'single-' . $download_cpt . '.php' ) );

		/** Use custom template via child theme (edd subfolder) */
		if ( ! $template ) {
			$template = locate_template( array( 'edd/single-' . $download_cpt . '.php' ) );
		}

		/** Fallback to GCEDD template (plugin) - filterable */
		if ( ! $template ) {
			$template = apply_filters( 'gcedd_filter_template_single', GCEDD_TEMPLATE_DIR . '/single-' . $download_cpt . '.php' );
		}

	}

	/** Download archive pages */
	elseif ( is_post_type_archive( $download_cpt ) ) {

		/** Use custom template via child theme (child root) */
		$template = locate_template( array( 'archive-' . $download_cpt . '.php' ) );

		/** Use custom template via child theme (edd subfolder) */
		if ( ! $template ) {
			$template = locate_template( array( 'edd/archive-' . $download_cpt . '.php' ) );
		}

		/** Fallback to GCEDD template (plugin) - filterable */
		if ( ! $template ) {
			$template = apply_filters( 'gcedd_filter_template_archive', GCEDD_TEMPLATE_DIR . '/archive-' . $download_cpt . '.php' );
		}

	}

	/** Download taxonomy pages */
	elseif ( is_tax() && $download_cpt == get_post_type() ) {

		$term = get_query_var( 'term' );

		$tax = get_query_var( 'taxonomy' );

		/** Get an array of all relevant taxonomies */
		$taxonomies = get_object_taxonomies( $download_cpt, 'names' );

		if ( in_array( $tax, $taxonomies ) ) {

			$tax = sanitize_title( $tax );
			$term = sanitize_title( $term );

			/** Use custom template via child theme (child root) */
			$templates = array(
				'taxonomy-' . $tax . '-' . $term . '.php',
				'taxonomy-' . $tax . '.php',
				'taxonomy.php',
			);

			$template = locate_template( $templates );

			/** Use custom template via child theme (edd subfolder) */
			if ( ! $template ) {

				$templates = array(
					'edd/taxonomy-' . $tax . '-' . $term . '.php',
					'edd/taxonomy-' . $tax . '.php',
					'edd/taxonomy.php',
				);

				$template = locate_template( $templates );

			}  // end-if 'edd' folder check

			/** Fallback to GCEDD template (plugin) */
			if ( ! $template ) {

				$template = apply_filters( 'gcedd_filter_template_taxonomy', GCEDD_TEMPLATE_DIR . '/taxonomy.php' );

			}  // end-if plugin folder check

		}  // end-if tax check

	}  // end if else

	/** Finally, return the template file - filterable */
	return apply_filters( 'gcedd_filter_template_loader', $template );

}  // end of function ddw_gcedd_template_loader