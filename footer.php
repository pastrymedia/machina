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

machina_structural_wrap( 'site-inner', 'close' );
echo '</div>'; //* end .site-inner or #inner

do_action( 'machina_before_footer' );
do_action( 'machina_footer' );
do_action( 'machina_after_footer' );

echo '</div>'; //* end .site-container or #wrap

do_action( 'machina_after' );
wp_footer(); //* we need this for plugins
?>
</body>
</html>