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

/**
 * Register a new admin page, providing content and corresponding menu item for the Import / Export page.
 *
 * Although this class was added in 1.8.0, some of the methods were originally standalone functions added in previous
 * versions of Machina.
 *
 * @package Machina\Admin
 *
 * @since 1.8.0
 */
class Machina_Admin_Import_Export extends Machina_Admin_Basic {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * Also hook in the handling of file imports and exports.
	 *
	 * @since 1.8.0
	 *
	 * @uses \Machina_Admin::create() Create an admin menu item and settings page.
	 *
	 * @see \Machina_Admin_Import_Export::export() Handle settings file exports.
	 * @see \Machina_Admin_Import_Export::import() Handle settings file imports.
	 */
	public function __construct() {

		$page_id = 'machina-import-export';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'machina',
				'page_title'  => __( 'Machina - Import/Export', 'machina' ),
				'menu_title'  => __( 'Import/Export', 'machina' )
			)
		);

		$this->create( $page_id, $menu_ops );

		add_action( 'admin_init', array( $this, 'export' ) );
		add_action( 'admin_init', array( $this, 'import' ) );

	}

	/**
	 * Contextual help content.
	 *
	 * @since 2.0.0
	 */
	public function help() {

		$screen = get_current_screen();

		$general_settings_help =
			'<h3>' . __( 'Import/Export', 'machina' ) . '</h3>' .
			'<p>'  . __( 'This allows you to import or export Machina Settings.', 'machina' ) . '</p>' .
			'<p>'  . __( 'This is specific to Machina settings and does not includes posts, pages, or images, which is what the built-in WordPress import/export menu does.', 'machina' ) . '</p>' .
			'<p>'  . __( 'It also does not include other settings for plugins, widgets, or post/page/term/user specific settings.', 'machina' ) . '</p>';

		$import_settings_help =
			'<h3>' . __( 'Import', 'machina' ) . '</h3>' .
			'<p>'  . sprintf( __( 'You can import a file you\'ve previously exported. The file name will start with %s followed by one or more strings indicating which settings it contains, finally followed by the date and time it was exported.', 'machina' ), machina_code( 'machina-' ) ) . '</p>' .
			'<p>' . __( 'Once you upload an import file, it will automatically overwrite your existing settings.', 'machina' ) . ' <strong>' . __( 'This cannot be undone', 'machina' ) . '</strong>.</p>';

		$export_settings_help =
			'<h3>' . __( 'Export', 'machina' ) . '</h3>' .
			'<p>'  . sprintf( __( 'You can export your Machina-related settings to back them up, or copy them to another site. Child themes and plugins may add their own checkboxes to the list. The settings are exported in %s format.', 'machina' ), '<abbr title="' . __( 'JavaScript Object Notation', 'machina' ) . '">' . __( 'JSON', 'machina' ) . '</abbr>' ) . '</p>';

		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-general-settings',
			'title'   => __( 'Import/Export', 'machina' ),
			'content' => $general_settings_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-import',
			'title'   => __( 'Import', 'machina' ),
			'content' => $import_settings_help,
		) );
		$screen->add_help_tab( array(
			'id'      => $this->pagehook . '-export',
			'title'   => __( 'Export', 'machina' ),
			'content' => $export_settings_help,
		) );

		//* Add help sidebar
		$screen->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'machina' ) . '</strong></p>' .
			'<p><a href="http://my.machinathemes.com/help/" target="_blank" title="' . __( 'Get Support', 'machina' ) . '">' . __( 'Get Support', 'machina' ) . '</a></p>' .
			'<p><a href="http://my.machinathemes.com/snippets/" target="_blank" title="' . __( 'Machina Snippets', 'machina' ) . '">' . __( 'Machina Snippets', 'machina' ) . '</a></p>' .
			'<p><a href="http://my.machinathemes.com/tutorials/" target="_blank" title="' . __( 'Machina Tutorials', 'machina' ) . '">' . __( 'Machina Tutorials', 'machina' ) . '</a></p>'
		);

	}

	/**
	 * Callback for displaying the Machina Import / Export admin page.
	 *
	 * Call the machina_import_export_form action after the last default table row.
	 *
	 * @since 1.4.0
	 *
	 * @uses \Machina_Admin_Import_Export::export_checkboxes()  Echo export checkboxes.
	 * @uses \Machina_Admin_Import_Export::get_export_options() Get array of export options.
	 */
	public function admin() {

		?>
		<div class="wrap">
			<?php screen_icon( 'tools' ); ?>
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

			<table class="form-table">
				<tbody>

					<tr>
						<th scope="row"><b><?php _e( 'Import Machina Settings File', 'machina' ); ?></p></th>
						<td>
							<p><?php printf( __( 'Upload the data file (%s) from your computer and we\'ll import your settings.', 'machina' ), machina_code( '.json' ) ); ?></p>
							<p><?php _e( 'Choose the file from your computer and click "Upload file and Import"', 'machina' ); ?></p>
							<p>
								<form enctype="multipart/form-data" method="post" action="<?php echo menu_page_url( 'machina-import-export', 0 ); ?>">
									<?php wp_nonce_field( 'machina-import' ); ?>
									<input type="hidden" name="machina-import" value="1" />
									<label for="machina-import-upload"><?php sprintf( __( 'Upload File: (Maximum Size: %s)', 'machina' ), ini_get( 'post_max_size' ) ); ?></label>
									<input type="file" id="machina-import-upload" name="machina-import-upload" size="25" />
									<?php
									submit_button( __( 'Upload File and Import', 'machina' ), 'primary', 'upload', false );
									?>
								</form>
							</p>
						</td>
					</tr>

					<tr>
						<th scope="row"><b><?php _e( 'Export Machina Settings File', 'machina' ); ?></b></th>
						<td>
							<p><?php printf( __( 'When you click the button below, Machina will generate a data file (%s) for you to save to your computer.', 'machina' ), machina_code( '.json' ) ); ?></p>
							<p><?php _e( 'Once you have saved the download file, you can use the import function on another site to import this data.', 'machina' ); ?></p>
							<p>
								<form method="post" action="<?php echo menu_page_url( 'machina-import-export', 0 ); ?>">
									<?php
									wp_nonce_field( 'machina-export' );
									$this->export_checkboxes();
									if ( $this->get_export_options() )
										submit_button( __( 'Download Export File', 'machina' ), 'primary', 'download' );
									?>
								</form>
							</p>
						</td>
					</tr>

					<?php do_action( 'machina_import_export_form' ); ?>

				</tbody>
			</table>

		</div>
		<?php

	}

	/**
	 * Add custom notices that display after successfully importing or exporting the settings.
	 *
	 * @since 1.4.0
	 *
	 * @uses machina_is_menu_page() Check if we're on a Machina page.
	 *
	 * @return null Return early if not on the correct admin page.
	 */
	public function notices() {

		if ( ! machina_is_menu_page( 'machina-import-export' ) )
			return;

		if ( isset( $_REQUEST['imported'] ) && 'true' === $_REQUEST['imported'] )
			echo '<div id="message" class="updated"><p><strong>' . __( 'Settings successfully imported.', 'machina' ) . '</strong></p></div>';
		elseif ( isset( $_REQUEST['error'] ) && 'true' === $_REQUEST['error'] )
			echo '<div id="message" class="error"><p><strong>' . __( 'There was a problem importing your settings. Please try again.', 'machina' ) . '</strong></p></div>';

	}

	/**
	 * Return array of export options and their arguments.
	 *
	 * Plugins and themes can hook into the machina_export_options filter to add
	 * their own settings to the exporter.
	 *
	 * @since 1.6.0
	 *
	 * @return array Export options
	 */
	protected function get_export_options() {

		$options = array(
			'theme' => array(
				'label'          => __( 'Theme Settings', 'machina' ),
				'settings-field' => MACHINA_SETTINGS_FIELD,
			),
			'seo' => array(
				'label' => __( 'SEO Settings', 'machina' ),
				'settings-field' => MACHINA_SEO_SETTINGS_FIELD,
			)
		);

		return (array) apply_filters( 'machina_export_options', $options );

	}

	/**
	 * Echo out the checkboxes for the export options.
	 *
	 * @since 1.6.0
	 *
	 * @uses \Machina_Admin_Import_Export::get_export_options() Get array of export options.
	 *
	 * @return null Return null if there are no options to export.
	 */
	protected function export_checkboxes() {

		if ( ! $options = $this->get_export_options() ) {
			//* Not even the Machina theme / seo export options were returned from the filter
			printf( '<p><em>%s</em></p>', __( 'No export options available.', 'machina' ) );
			return;
		}

		foreach ( $options as $name => $args ) {
			//* Ensure option item has an array key, and that label and settings-field appear populated
			if ( is_int( $name ) || ! isset( $args['label'] ) || ! isset( $args['settings-field'] ) || '' === $args['label'] || '' === $args['settings-field'] )
				return;

			printf( '<p><label for="machina-export-%1$s"><input id="machina-export-%1$s" name="machina-export[%1$s]" type="checkbox" value="1" /> %2$s</label></p>', esc_attr( $name ), esc_html( $args['label'] ) );

		}

	}

	/**
	 * Generate the export file, if requested, in JSON format.
	 *
	 * After checking we're on the right page, and trying to export, loop through the list of requested options to
	 * export, grabbing the settings from the database, and building up a file name that represents that collection of
	 * settings.
	 *
	 * A .json file is then sent to the browser, named with "machina" at the start and ending with the current
	 * date-time.
	 *
	 * The machina_export action is fired after checking we can proceed, but before the array of export options are
	 * retrieved.
	 *
	 * @since 1.4.0
	 *
	 * @uses machina_is_menu_page()                             Check if we're on a Machina page.
	 * @uses \Machina_Admin_Import_Export::get_export_options() Get array of export options.
	 *
	 * @return null Return null if not correct page, or we're not exporting.
	 */
	public function export() {

		if ( ! machina_is_menu_page( 'machina-import-export' ) )
			return;

		if ( empty( $_REQUEST['machina-export'] ) )
			return;

		check_admin_referer( 'machina-export' );

		do_action( 'machina_export', $_REQUEST['machina-export'] );

		$options = $this->get_export_options();

		$settings = array();

		//* Exported file name always starts with "machina"
		$prefix = array( 'machina' );

		//* Loop through set(s) of options
		foreach ( (array) $_REQUEST['machina-export'] as $export => $value ) {
			//* Grab settings field name (key)
			$settings_field = $options[$export]['settings-field'];

			//* Grab all of the settings from the database under that key
			$settings[$settings_field] = get_option( $settings_field );

			//* Add name of option set to build up export file name
			$prefix[] = $export;
		}

		if ( ! $settings )
			return;

		//* Complete the export file name by joining parts together
		$prefix = join( '-', $prefix );

	    $output = json_encode( (array) $settings );

		//* Prepare and send the export file to the browser
	    header( 'Content-Description: File Transfer' );
	    header( 'Cache-Control: public, must-revalidate' );
	    header( 'Pragma: hack' );
	    header( 'Content-Type: text/plain' );
	    header( 'Content-Disposition: attachment; filename="' . $prefix . '-' . date( 'Ymd-His' ) . '.json"' );
	    header( 'Content-Length: ' . mb_strlen( $output ) );
	    echo $output;
	    exit;

	}

	/**
	 * Handle the file uploaded to import settings.
	 *
	 * Upon upload, the file contents are JSON-decoded. If there were errors, or no options to import, then reload the
	 * page to show an error message.
	 *
	 * Otherwise, loop through the array of option sets, and update the data under those keys in the database.
	 * Afterwards, reload the page with a success message.
	 *
	 * Calls machina_import action is fired after checking we can proceed, but before attempting to extract the contents
	 * from the uploaded file.
	 *
	 * @since 1.4.0
	 *
	 * @uses machina_is_menu_page()   Check if we're on a Machina page
	 * @uses machina_admin_redirect() Redirect user to an admin page
	 *
	 * @return null Return null if not correct admin page, we're not importing
	 */
	public function import() {

		if ( ! machina_is_menu_page( 'machina-import-export' ) )
			return;

		if ( empty( $_REQUEST['machina-import'] ) )
			return;

		check_admin_referer( 'machina-import' );

		do_action( 'machina_import', $_REQUEST['machina-import'], $_FILES['machina-import-upload'] );

		$upload = file_get_contents( $_FILES['machina-import-upload']['tmp_name'] );

		$options = json_decode( $upload, true );

		//* Check for errors
		if ( ! $options || $_FILES['machina-import-upload']['error'] ) {
			machina_admin_redirect( 'machina-import-export', array( 'error' => 'true' ) );
			exit;
		}

		//* Identify the settings keys that we should import
		$exportables = $this->get_export_options();
		$importable_keys = array();
		foreach ( $exportables as $exportable ) {
			$importable_keys[] = $exportable['settings-field'];
		}

		//* Cycle through data, import Machina settings
		foreach ( (array) $options as $key => $settings ) {
			if ( in_array( $key, $importable_keys ) )
				update_option( $key, $settings );
		}

		//* Redirect, add success flag to the URI
		machina_admin_redirect( 'machina-import-export', array( 'imported' => 'true' ) );
		exit;

	}

}