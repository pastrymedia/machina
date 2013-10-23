<?php
/**
 * Machina Framework.
 *
 * WARNING: This file is part of the core Machina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Machina\Admin
 * @author  MachinaThemes
 * @license GPL-2.0+
 * @link    http://my.machinathemes.com/themes/machina/
 */

add_action( 'after_setup_theme', 'machina_add_admin_menu' );
/**
 * Add Machina top-level item in admin menu.
 *
 * Calls the `machina_admin_menu hook` at the end - all submenu items should be attached to that hook to ensure
 * correct ordering.
 *
 * @since 0.2.0
 *
 * @global \Machina_Admin_Settings _machina_admin_settings          Theme Settings page object.
 * @global string                  _machina_theme_settings_pagehook Old backwards-compatible pagehook.
 *
 * @return null Returns null if Machina menu is disabled, or disabled for current user
 */
function machina_add_admin_menu() {

	if ( ! is_admin() )
		return;

	global $_machina_admin_settings;

	if ( ! current_theme_supports( 'machina-admin-menu' ) )
		return;

	//* Don't add menu item if disabled for current user
	$user = wp_get_current_user();
	if ( ! get_the_author_meta( 'machina_admin_menu', $user->ID ) )
		return;

	$_machina_admin_settings = new Machina_Admin_Settings;

	//* Set the old global pagehook var for backward compatibility
	global $_machina_theme_settings_pagehook;
	$_machina_theme_settings_pagehook = $_machina_admin_settings->pagehook;

	do_action( 'machina_admin_menu' );

}

add_action( 'machina_admin_menu', 'machina_add_admin_submenus' );
/**
 * Add submenu items under Machina item in admin menu.
 *
 * @since 0.2.0
 *
 * @see Machina_Admin_SEO_Settings SEO Settings class
 * @see Machina_Admin_Import_export Import / Export class
 * @see Machina_Admin_Readme Readme class
 *
 * @global string $_machina_admin_seo_settings
 * @global string $_machina_admin_import_export
 * @global string $_machina_admin_readme
 *
 * @return null Returns null if Machina menu is disabled
 */
function machina_add_admin_submenus() {

	//* Do nothing, if not viewing the admin
	if ( ! is_admin() )
		return;

	global $_machina_admin_seo_settings, $_machina_admin_import_export, $_machina_admin_readme;

	//* Don't add submenu items if Machina menu is disabled
	if( ! current_theme_supports( 'machina-admin-menu' ) )
		return;

	$user = wp_get_current_user();

	//* Add "SEO Settings" submenu item
	if ( current_theme_supports( 'machina-seo-settings-menu' ) && get_the_author_meta( 'machina_seo_settings_menu', $user->ID ) ) {
		$_machina_admin_seo_settings = new Machina_Admin_SEO_Settings;

		//* set the old global pagehook var for backward compatibility
		global $_machina_seo_settings_pagehook;
		$_machina_seo_settings_pagehook = $_machina_admin_seo_settings->pagehook;
	}

	//* Add "Import/Export" submenu item
	if ( current_theme_supports( 'machina-import-export-menu' ) && get_the_author_meta( 'machina_import_export_menu', $user->ID ) )
		$_machina_admin_import_export = new Machina_Admin_Import_Export;

	//* Add the upgraded page (no menu)
	new Machina_Admin_Upgraded;

}

add_action( 'admin_menu', 'machina_add_cpt_archive_page', 5 );
/**
 * Add archive settings page to relevant custom post type registrations.
 *
 * An instance of `Machina_Admin_CPT_Archive_Settings` is instantiated for each relevant CPT, assigned to an individual
 * global variable.
 *
 * @since 2.0.0
 *
 * @uses \Machina_Admin_CPT_Archive_Settings     CPT Archive Settings page class.
 * @uses machina_get_cpt_archive_types()         Get list of custom post types which need an archive settings page.
 * @uses machina_has_post_type_archive_support() Check post type has archive support.
 */
function machina_add_cpt_archive_page() {
	$post_types = machina_get_cpt_archive_types();

	foreach( $post_types as $post_type ) {
		if ( machina_has_post_type_archive_support( $post_type->name ) ) {
			$admin_object_name = '_machina_admin_cpt_archives_' . $post_type->name;
			global ${$admin_object_name};
			${$admin_object_name} = new Machina_Admin_CPT_Archive_Settings( $post_type );
		}
	}
}