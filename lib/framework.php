<?php
/**
 * Machina Framework.
 *
 * WARNING: This file is part of the core Machina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Machina\Framework
 * @author  MachinaThemes
 * @license GPL-2.0+
 * @link    http://my.machinathemes.com/themes/machina/
 */

/**
 * Used to initialize the framework in the various template files.
 *
 * It pulls in all the necessary components like header and footer, the basic
 * markup structure, and hooks.
 *
 * @since 1.3.0
 */
function machina() {

	get_header();

	do_action( 'machina_before_content_sidebar_wrap' );
	machina_markup( array(
		'html5'   => '<div %s>',
		'xhtml'   => '<div id="content-sidebar-wrap">',
		'context' => 'content-sidebar-wrap',
	) );

		do_action( 'machina_before_content' );
		machina_markup( array(
			'html5'   => '<main %s>',
			'xhtml'   => '<div id="content" class="hfeed">',
			'context' => 'content',
		) );
			do_action( 'machina_before_loop' );
			do_action( 'machina_loop' );
			do_action( 'machina_after_loop' );
		machina_markup( array(
			'html5' => '</main>', //* end .content
			'xhtml' => '</div>', //* end #content
		) );
		do_action( 'machina_after_content' );

	echo '</div>'; //* end .content-sidebar-wrap or #content-sidebar-wrap
	do_action( 'machina_after_content_sidebar_wrap' );

	get_footer();

}
