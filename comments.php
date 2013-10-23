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

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' === basename( $_SERVER['SCRIPT_FILENAME'] ) )
	die ( 'Please do not load this page directly. Thanks!' );

if ( post_password_required() ) {
	printf( '<p class="alert">%s</p>', __( 'This post is password protected. Enter the password to view comments.', 'machina' ) );
	return;
}

do_action( 'machina_before_comments' );
do_action( 'machina_comments' );
do_action( 'machina_after_comments' );

do_action( 'machina_before_pings' );
do_action( 'machina_pings' );
do_action( 'machina_after_pings' );

do_action( 'machina_before_comment_form' );
do_action( 'machina_comment_form' );
do_action( 'machina_after_comment_form' );