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

do_action( 'machina_doctype' );
do_action( 'machina_title' );
do_action( 'machina_meta' );

wp_head(); //* we need this for plugins
?>
</head>
<?php
machina_markup( array(
	'html'   => '<body %s>',
	'context' => 'body',
) );
do_action( 'machina_before' );

machina_markup( array(
	'html'   => '<div %s>',
	'context' => 'site-container',
) );

do_action( 'machina_before_header' );
do_action( 'machina_header' );
do_action( 'machina_after_header' );

machina_markup( array(
	'html'   => '<div %s>',
	'context' => 'site-inner',
) );
machina_structural_wrap( 'site-inner' );
