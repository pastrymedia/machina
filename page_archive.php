<?php
/**
 * Machina Framework.
 *
 * WARNING: This file is part of the core Machina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Machina\Templates
 * @author  MachinaThemes
 * @license GPL-2.0+
 * @link    http://my.machinathemes.com/themes/machina/
 */

//* Template Name: Archive

//* Remove standard post content output
remove_action( 'machina_post_content', 'machina_do_post_content' );
remove_action( 'machina_entry_content', 'machina_do_post_content' );

add_action( 'machina_entry_content', 'machina_page_archive_content' );
add_action( 'machina_post_content', 'machina_page_archive_content' );
/**
 * This function outputs sitemap-esque columns displaying all pages,
 * categories, authors, monthly archives, and recent posts.
 *
 * @since 1.6
 */
function machina_page_archive_content() { ?>

	<h4><?php _e( 'Pages:', 'machina' ); ?></h4>
	<ul>
		<?php wp_list_pages( 'title_li=' ); ?>
	</ul>

	<h4><?php _e( 'Categories:', 'machina' ); ?></h4>
	<ul>
		<?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
	</ul>

	<h4><?php _e( 'Authors:', 'machina' ); ?></h4>
	<ul>
		<?php wp_list_authors( 'exclude_admin=0&optioncount=1' ); ?>
	</ul>

	<h4><?php _e( 'Monthly:', 'machina' ); ?></h4>
	<ul>
		<?php wp_get_archives( 'type=monthly' ); ?>
	</ul>

	<h4><?php _e( 'Recent Posts:', 'machina' ); ?></h4>
	<ul>
		<?php wp_get_archives( 'type=postbypost&limit=100' ); ?>
	</ul>

<?php
}

machina();