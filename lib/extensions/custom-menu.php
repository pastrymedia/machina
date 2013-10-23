<?php
/*
Plugin Name: Custom Menus
Description: Allows you to select a WordPress menu for secondary navigation on individual posts/pages.
*/


/* Sample implementation of adding support for custom taxonomy

add_filter( 'machina_custom_menus_taxonomies', 'machina_menu_sample_taxonomy' );
function machina_menu_sample_taxonomy( $taxonomies ) {
	$taxonomies[] = 'taxonomy-slug';
	return array_unique( $taxonomies );
}
*/
class Machina_Custom_Menus {

	var $handle = 'machina-custom-menu-post-metabox';
	var $nonce_key = 'machina-custom-menu-post-metabox-nonce';
	var $field_name = '_machina_custom_menu';
	var $menu = null;
	var $taxonomies=null;
/*
 * constructor
 */

	function  __construct() {

		add_action( 'init', array( $this, 'init' ), 99 );

	}
/*
 * add all our base hooks into WordPress
 */
	function init() {

		if ( ! function_exists( 'machina_get_option' ) )
			return;

		add_action( 'admin_menu',	array( $this, 'admin_menu' ) );
		add_action( 'save_post',	array( $this, 'save_post' ), 10, 2 );
		add_action( 'wp_head',		array( $this, 'wp_head' ) );

		$_taxonomies = get_taxonomies( array( 'show_ui' => true, 'public' => true ) );
		$this->taxonomies = apply_filters( 'machina_custom_menus_taxonomies', array_keys( $_taxonomies ) );

		if ( empty( $this->taxonomies ) || ! is_array( $this->taxonomies ) )
			return;

		foreach( $this->taxonomies as $tax )
			add_action( "{$tax}_edit_form", array( $this, 'term_edit' ), 9, 2 );

	}
/*
 * Add the post metaboxes to the supported post types
 */
	function admin_menu() {

		foreach( (array) get_post_types( array( 'public' => true ) ) as $type ) {

			if( $type == 'post' || $type == 'page' || post_type_supports( $type, 'machina-custom-menus' ) )
				add_meta_box( $this->handle, __( 'Secondary Navigation', 'machina' ), array( $this, 'metabox' ), $type, 'side', 'low' );

		}
	}
/*
 * Does the metabox on the post edit page
 */
	function metabox() {
	?>
	<p>
		<?php
		$this->print_menu_select( $this->field_name, machina_get_custom_field( $this->field_name ), 'width: 99%;' );
		?>
	</p>
	<?php
	}
/*
 * Does the metabox on the term edit page
 */
	function term_edit( $tag, $taxonomy ) {

		// Merge Defaults to prevent notices
		$tag->meta = wp_parse_args( $tag->meta, array( $this->field_name => '' ) );
	?>
	<h3><?php _e( 'Secondary Navigation', 'machina' ); ?></h3>

	<table class="form-table">
		<tr class="form-field">
			<th scope="row" valign="top">
				<?php
				$this->print_menu_select( "machina-meta[{$this->field_name}]", $tag->meta[$this->field_name], '', 'padding-right: 10px;', '</th><td>' ); ?>
			</td>
		</tr>
	</table>
	<?php
	}
/*
 * Support function for the metaboxes, outputs the menu dropdown
 */
	function print_menu_select( $field_name, $selected, $select_style = '', $option_style = '', $after_label = '' ) {

		if ( $select_style )
			$select_style = sprintf(' style="%s"', esc_attr( $select_style ) );

		if ( $option_style )
			$option_style = sprintf(' style="%s"', esc_attr( $option_style ) );

		?>
		<label for="<?php echo $field_name; ?>"><span><?php _e( 'Secondary Navigation', 'machina' ); ?><span></label>

		<?php echo $after_label; ?>

		<select name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>"<?php echo $select_style; ?>>
			<option value=""<?php echo $option_style; ?>><?php _e( 'Default Menu', 'machina-custom-menus' ); ?></option>
			<?php
			$menus = wp_get_nav_menus( array( 'orderby' => 'name') );
			foreach ( $menus as $menu )
				printf( '<option value="%d" %s>%s</option>', $menu->term_id, selected( $menu->term_id, $selected, false ), esc_html( $menu->name ) );
			?>
		</select>
		<?php
	}
/*
 * Handles the post save & stores the menu selection in the post meta
 */
	function save_post( $post_id, $post ) {

		//	don't try to save the data under autosave, ajax, or future post.
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
		if ( defined('DOING_AJAX') && DOING_AJAX ) return;
		if ( defined('DOING_CRON') && DOING_CRON ) return;
		if ( $post->post_type == 'revision' ) return;

		$perm = 'edit_' . ( 'page' == $post->post_type ? 'page' : 'post' ) . 's';
		if ( ! current_user_can( $perm, $post_id ) )
			return;

		if ( empty( $_POST[$this->field_name] ) )
			delete_post_meta( $post_id, $this->field_name );
		else
			update_post_meta( $post_id, $this->field_name, $_POST[$this->field_name] );

	}
/*
 * Once we hit wp_head, the WordPress query has been run, so we can determine if this request uses a custom subnav
 */
	function wp_head() {

		add_filter( 'theme_mod_nav_menu_locations', array( $this, 'theme_mod' ) );

		if ( is_singular() ) {

			$obj = get_queried_object();
			$this->menu = get_post_meta( $obj->ID, $this->field_name, true );
			return;

		}

		$term = false;

		if ( is_category() && in_array( 'category', $this->taxonomies ) ) {

			$term = get_term( get_query_var( 'cat' ), 'category' );

		} elseif ( is_tag() && in_array( 'post_tag', $this->taxonomies ) ) {

			$term = get_term( get_query_var( 'tag_id' ), 'post_tag' );

		} elseif( is_tax() ) {

			foreach( $this->taxonomies as $tax ) {

				if( $tax == 'post_tag' || $tax == 'category' )
					continue;

				if( is_tax( $tax ) ) {

					$obj = get_queried_object();
					$term = get_term( $obj->term_id, $tax );
					break;

				}
			}
		}

		if ( $term && isset( $term->meta[$this->field_name] ) )
			$this->menu = $term->meta[$this->field_name];

	}
/*
 * Replace the menu selected in the WordPress Menu settings with the custom one for this request
 */
	function theme_mod( $mods ) {

		if ( $this->menu )
			$mods['secondary'] = (int)$this->menu;

		return $mods;

	}
}
/*
 *  giddyup
 */
$machina_custom_menu = new Machina_Custom_Menus();
