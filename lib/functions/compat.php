<?php
/**
 * Machina Framework.
 *
 * WARNING: This file is part of the core Machina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Machina\Compatibility
 * @author  MachinaThemes
 * @license GPL-2.0+
 * @link    http://my.machinathemes.com/themes/machina/
 */

//* These functions are intended to provide simple compatibilty for those that don't have the mbstring
//* extension enabled. WordPress already provides a proper working definition for mb_substr().

if ( ! function_exists( 'mb_strpos' ) ) {
function mb_strpos( $haystack, $needle, $offset = 0, $encoding = '' ) {
	return strpos( $haystack, $needle, $offset );
}
}

if ( ! function_exists( 'mb_strrpos' ) ) {
function mb_strrpos( $haystack, $needle, $offset = 0, $encoding = '' ) {
	return strrpos( $haystack, $needle, $offset );
}
}

if ( ! function_exists( 'mb_strlen' ) ) {
function mb_strlen( $string, $encoding = '' ) {
	return strlen( $string );
}
}

if ( ! function_exists( 'mb_strtolower' ) ) {
function mb_strtolower( $string, $encoding = '' ) {
	return strtolower( $string );
}
}
