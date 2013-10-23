<?php
/**
 * Template for displaying Single Download pages in EDD
 *
 * Note for customisers/users: Do not edit this file!
 * ===================================================
 * If you want to customise this template, copy this file (keep same name) and place the
 * copy in your child theme's root folder or "edd" subfolder, i.e. /wp-content/themes/your-child-theme/edd/
 * (Your theme may not have a "edd" folder, so just create one.)
 * The version in the child theme's root/"edd" folder will override this template, and
 * any future updates to this plugin won't wipe out your customisations.
 *
 * @since 1.1.0
 */

add_action( 'machina_after_post_content', 'gcedd_single_after_widget' );
/**
 * Add the optional after content widget for the single download page
 *
 * @since 1.1.0
 *
 * @uses  machina_widget_area()
 */
function gcedd_single_after_widget() {

	machina_widget_area(
		'gcedd-single-after',
		array(
			'before' => '<div class="gcedd-single-after widget-area">',
			'after'  => '</div>',
		)
	);

}  // end of function gcedd_single_after_widget


/** Let Machina take over :) */
machina();