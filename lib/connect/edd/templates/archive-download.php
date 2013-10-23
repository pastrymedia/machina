<?php
/**
 * Template for displaying Downloads Archive in EDD
 *
 * Note for customisers/users: Do not edit this file!
 * ===================================================
 * If you want to customise this template, copy this file (keep same name) and place the
 * copy in your child theme's root folder or "edd" subfolder, i.e. /wp-content/themes/your-child-theme/edd/
 * (Your theme may not have a "edd" folder, so just create one.)
 * The version in the child theme's root/"edd" folder will override this template, and
 * any future updates to this plugin won't wipe out your customisations.
 *
 * @since 1.0.0
 */

add_action( 'machina_before_loop', 'gcedd_archive_top_widget' );
/**
 * Add the optional top widget for the download archive
 *
 * @since 1.0.0
 *
 * @uses  is_search()
 * @uses  machina_widget_area()
 */
function gcedd_archive_top_widget() {

	/** Only display if not on a search page */
	if ( ! is_search() ) {

		machina_widget_area(
			'gcedd-archive-top',
			array(
				'before' => '<div class="gcedd-archive widget-area">',
				'after'  => '</div>',
			)
		);

	}  // end-if is_search check

}  // end of function gcedd_archive_top_widget


/** Let Machina take over :) */
machina();