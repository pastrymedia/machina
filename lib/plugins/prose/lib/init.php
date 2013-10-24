<?php
/**
 * This file controls all parts of the Design Features Initialization.
 *
 * @package Machina
 * @author Machina Themes
 */

/**
 * Theme constants.
 */
define( 'MACHINA_DESIGN_SETTINGS_FIELD', apply_filters( 'machina_design_settings_field', 'machina-design-settings' ) );


/**
 * Theme support.
 *
 * Enable support for design features.
 *
 */
add_theme_support( 'machina-design-settings' );

/** Functions */
require_once( CHILD_DIR . '/lib/functions/design-settings.php' );

/** Structure */
require_once( CHILD_DIR . '/lib/structure/custom.php' );
require_once( CHILD_DIR . '/lib/structure/stylesheets.php' );

/** Settings pages */
if ( is_admin() ) {

	require_once( CHILD_DIR . '/lib/admin/design-settings.php' );
	require_once( CHILD_DIR . '/lib/admin/custom-code.php' );

}