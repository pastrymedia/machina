<?php
/**
 * Machina Automatic Term Headline
 *
 * @package   MachinaAutomaticTermHeadline
 * @author    Machina Themes
 * @license   GPL-2.0+
 * @link      https://github.com/machina-automatic-term-headline
 * @copyright 2013 Machina Themes
 *
 * @wordpress-plugin
 * Plugin Name:       Machina Automatic Term Headline
 * Plugin URI:        https://github.com/machina-automatic-term-headline
 * Description:       Automatically adds a headline to the term archive page, the same as the name of taxonomy term, if no explicit value is given.
 * Version:           1.1.1
 * Author:            Machina Themes
 * Author URI:        http://machinathemes.com/
 * Text Domain:       machina-automatic-term-headline
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /lang
 * GitHub Plugin URI: https://github.com/machina-automatic-term-headline
 * GitHub Branch:     master
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'machina_before', 'machina_automatic_term_headline_remove_taxonomy_title_description' );
/**
 * Remove the existing headline and intro text.
 *
 * @since 1.1.0
 */
function machina_automatic_term_headline_remove_taxonomy_title_description() {
	remove_action( 'machina_before_loop', 'machina_do_taxonomy_title_description', 15 );
}

add_action( 'machina_before_loop', 'machina_automatic_term_headline_do_taxonomy_title_description', 15 );
/**
 * Change the behaviour of the default term headline, by making the default the name of the term.
 *
 * If the headline has been customised in some way, hen this will show instead.
 *
 * @since 1.0.0
 *
 * @author Machina Themes
 *
 * @return null Return early if not the correct archive page, not page one, or no term meta is set.
 */
function machina_automatic_term_headline_do_taxonomy_title_description() {

	global $wp_query;

	if ( ! is_category() && ! is_tag() && ! is_tax() )
		return;

	if ( get_query_var( 'paged' ) >= 2 )
		return;

	$term = is_tax() ? get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : $wp_query->get_queried_object();

	if ( ! $term || ! isset( $term->meta ) )
		return;

	if ( $term->meta['headline'] )
		$headline_text = $term->meta['headline'];
	elseif ( apply_filters( 'machina-automatic-term-headline-exclusion', false ) )
		$headline_text = '';
	else
		$headline_text = $term->name;

	$headline = sprintf( '<h1 class="archive-title">%s</h1>', strip_tags( $headline_text ) );

	$intro_text = $term->meta['intro_text'] ? apply_filters( 'machina_term_intro_text_output', $term->meta['intro_text'] ) : '';

	printf( '<div class="archive-description taxonomy-description">%s</div>', $headline . $intro_text );

}
