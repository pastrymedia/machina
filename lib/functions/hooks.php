<?php

add_action( 'machina_init', 'machina_execute_hooks', 20 );
/**
 * The following code loops through all the hooks, and attempts to
 * execute the code in the proper location.
 *
 * @uses machina_execute_hook() as a callback.
 *
 * @since 0.1
 */
function machina_execute_hooks() {

	$hooks = get_option( MACHINA_HOOK_SETTINGS_FIELD );

	foreach ( (array) $hooks as $hook => $array ) {

		//* Add new content to hook
		if ( machina_get_hook_option( $hook, 'content' ) ) {
			add_action( $hook, 'machina_execute_hook' );
		}

		//* Unhook stuff
		if ( isset( $array['unhook'] ) ) {

			foreach( (array) $array['unhook'] as $function ) {

				remove_action( $hook, $function );

			}

		}

	}

}

/**
 * The following function executes any code meant to be hooked.
 * It checks to see if shortcodes or PHP should be executed as well.
 *
 * @uses machina_get_hook_option()
 *
 * @since 0.1
 */
function machina_execute_hook() {

	$hook = current_filter();
	$content = machina_get_hook_option( $hook, 'content' );

	if( ! $hook || ! $content )
		return;

	$shortcodes = machina_get_hook_option( $hook, 'shortcodes' );
	$php = machina_get_hook_option( $hook, 'php' );

	$value = $shortcodes ? do_shortcode( $content ) : $content;

	if ( $php )
		eval( "?>$value<?php " );
	else
		echo $value;

}

/**
 * Pull an custom hook option from the database, return value
 *
 * @since 0.1
 */
function machina_get_hook_option( $hook = null, $field = null, $all = false ) {

	static $options = array();

	$options = $options ? $options : get_option( MACHINA_HOOK_SETTINGS_FIELD );

	if ( $all )
		return $options;

	if ( ! array_key_exists( $hook, (array) $options ) )
				return '';

	$option = isset( $options[$hook][$field] ) ? $options[$hook][$field] : '';

	return wp_kses_stripslashes( wp_kses_decode_entities( $option ) );

}
/**
 * Pull an custom hook option from the database, echo value
 *
 * @since 0.1
 */
function machina_hook_option($hook = null, $field = null) {

	echo machina_get_hook_option( $hook, $field );

}

/**
 * This function generates the form code to be used in the metaboxes
 *
 * @since 0.1
 */
function machina_hooks_form_generate( $args = array() ) {

?>

	<h4><code><?php echo $args['hook']; ?></code> <?php _e( 'Hook', 'machina' ); ?></h4>
	<p><span class="description"><?php echo $args['desc']; ?></span></p>

	<?php
		if ( isset( $args['unhook'] ) ) {

			foreach ( (array) $args['unhook'] as $function ) {
			?>

				<input type="checkbox" name="<?php echo MACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]" id="<?php echo MACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]" value="<?php echo $function; ?>" <?php if ( in_array( $function, (array) machina_get_hook_option( $args['hook'], 'unhook' ) ) ) echo 'checked'; ?> /> <label for="<?php echo MACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][unhook][]"><?php printf( __( 'Unhook <code>%s()</code> function from this hook?', 'machina' ), $function ); ?></label><br />

			<?php
			}

		}
	?>

	<p><textarea name="<?php echo MACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][content]" cols="70" rows="5"><?php echo htmlentities( machina_get_hook_option( $args['hook'], 'content' ), ENT_QUOTES, 'UTF-8' ); ?></textarea></p>

	<p>
		<input type="checkbox" name="<?php echo MACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]" id="<?php echo MACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]" value="1" <?php checked( 1, machina_get_hook_option( $args['hook'], 'shortcodes' ) ); ?> /> <label for="<?php echo MACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][shortcodes]"><?php _e( 'Execute Shortcodes on this hook?', 'machina' ); ?></label><br />
		<input type="checkbox" name="<?php echo MACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]" id="<?php echo MACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]" value="1" <?php checked( 1, machina_get_hook_option( $args['hook'], 'php' ) ); ?> /> <label for="<?php echo MACHINA_HOOK_SETTINGS_FIELD; ?>[<?php echo $args['hook']; ?>][php]"><?php _e( 'Execute PHP on this hook?', 'machina' ); ?></label>
	</p>

	<hr class="div" />

<?php
}