<?php
/*
Plugin Name: Machina Visual Hook Guide
Description: Find Machina hooks (action and filter hooks) quick and easily by seeing their actual locations inside your theme.
Version: 0.9.0
License: GPLv2
*/




add_action( 'admin_bar_menu', 'gvhg_admin_bar_links', 100 );
function gvhg_admin_bar_links() {
global $wp_admin_bar;

	if ( is_admin() )
		return;

	$wp_admin_bar->add_menu(
		array(
			'id' => 'ghooks',
			'title' => __( 'G Hook Guide', 'gvisualhookguide' ),
			'href' => '',
			'position' => 0,
		)
	);
	$wp_admin_bar->add_menu(
		array(
			'id'	   => 'ghooks_action',
			'parent'   => 'ghooks',
			'title'    => __( 'Action Hooks', 'gvisualhookguide' ),
			'href'     => add_query_arg( 'g_hooks', 'show' ),
			'position' => 10,
		)
	);
	$wp_admin_bar->add_menu(
		array(
			'id'	   => 'ghooks_filter',
			'parent'   => 'ghooks',
			'title'    => __( 'Filter Hooks', 'gvisualhookguide' ),
			'href'     => add_query_arg( 'g_filters', 'show' ),
			'position' => 10,
		)
	);
	$wp_admin_bar->add_menu(
		array(
			'id'	   => 'ghooks_markup',
			'parent'   => 'ghooks',
			'title'    => __( 'Markup', 'gvisualhookguide' ),
			'href'     => add_query_arg( 'g_markup', 'show' ),
			'position' => 10,
		)
	);

}

add_action('wp_enqueue_scripts', 'gvhg_hooks_stylesheet');
function gvhg_hooks_stylesheet() {

	 $gvhg_plugin_url = plugins_url() . '/machina-visual-hook-guide/';

	 if ( 'show' == isset( $_GET['g_hooks'] ) )
	 	wp_enqueue_style( 'gvhg_styles', $gvhg_plugin_url . 'styles.css' );

	 if ( 'show' == isset( $_GET['g_filters'] ) )
	 	wp_enqueue_style( 'gvhg_styles', $gvhg_plugin_url . 'styles.css' );

     if ( 'show' == isset( $_GET['g_markup'] ) )
     	wp_enqueue_style( 'gvhg_markup_styles', $gvhg_plugin_url . 'markup.css' );

}


add_action('get_header', 'gvhg_machina_hooker' );
function gvhg_machina_hooker() {
global $gvhg_machina_action_hooks;

	$gvhg_machina_action_hooks = array(

			'machina_doctype' => array(
				'hook' => 'machina_doctype',
				'area' => 'Document Head',
				'description' => '',
				'functions' => array(),
				),
			'machina_title' => array(
				'hook' => 'machina_title',
				'area' => 'Document Head',
				'description' => 'This hook executes between tags and outputs the doctitle. You can find all doctitle related code in /lib/structure/header.php.',
				'functions' => array(),
				),
			'machina_meta' => array(
				'hook' => 'machina_meta',
				'area' => 'Document Head',
				'description' => 'This hook executes in the section of the document source. By default, things like META descriptions and keywords are output using this hook, along with the default stylesheet and the reference to the favicon.',
				'functions' => array(),
				),
			'machina_home' => array(
				'hook' => 'machina_home',
				'area' => 'Structural',
				'description' => '',
				'functions' => array(),
				),
			'machina_before' => array(
				'hook' => 'machina_before',
				'area' => 'Structural',
				'description' => 'This hook executes immediately after the opening tag in the document source.',
				'functions' => array(),
				),
			'machina_before_header' => array(
				'hook' => 'machina_before_header',
				'area' => 'Structural',
				'description' => 'This hook executes immediately before the header (outside the #header div).',
				'functions' => array(),
				),
			'machina_header' => array(
				'hook' => 'machina_header',
				'area' => 'Structural',
				'description' => 'By default, this hook outputs the header code, including the title, description, and widget area (if necessary).',
				'functions' => array(),
				),
			'machina_header_right' => array(
				'hook' => 'machina_header_right',
				'area' => 'Structural',
				'description' => 'This hook executes immediately before the Header Right widget area inside div.widget-area.',
				),
			'machina_site_title' => array(
				'hook' => 'machina_site_title',
				'area' => 'Structural',
				'description' => 'By default, this hook outputs the site title, within the header area. It uses the user-specified SEO settings to build the site title markup appropriately.',
				'functions' => array(),
				),
			'machina_site_description' => array(
				'hook' => 'machina_site_description',
				'area' => 'Structural',
				'description' => 'By default, this hook outputs the site description, within the header area. It uses the user-specified SEO settings to build the site description markup appropriately.',
				'functions' => array(),
				),
			'machina_after_header' => array(
				'hook' => 'machina_after_header',
				'area' => 'Structural',
				'description' => 'This hook executes immediately after the header (outside the #header div).',
				'functions' => array(),
				),
			'machina_before_content_sidebar_wrap' => array(
				'hook' => 'machina_before_content_sidebar_wrap',
				'area' => 'Structural',
				'description' => 'This hook executes immediately before the div block that wraps the content and the primary sidebar (outside the #content-sidebar-wrap div).',
				'functions' => array(),
				),
			'machina_before_content' => array(
				'hook' => 'machina_before_content',
				'area' => 'Structural',
				'description' => 'This hook executes immediately before the content column (outside the #content div).',
				'functions' => array(),
				),
			'machina_before_loop' => array(
				'hook' => 'machina_before_loop',
				'area' => 'Loop',
				'description' => 'This hook executes immediately before all loop blocks. Therefore, this hook falls outside the loop, and cannot execute functions that require loop template tags or variables.',
				'functions' => array(),
				),
			'machina_loop' => array(
				'hook' => 'machina_loop',
				'area' => 'Loop',
				'description' => 'This hook outputs the actual loop. See lib/structure/loop.php and lib/structure/post.php for more details.',
				'functions' => array(),
				),
			'machina_before_entry' => array(
				'hook' => 'machina_before_entry',
				'area' => 'Loop',
				'description' => 'This hook executes before each post in all loop blocks (outside the post_class() article).',
				'functions' => array(),
				),
			'machina_entry_header' => array(
				'hook' => 'machina_entry_header',
				'area' => 'Loop',
				'description' => 'This hook executes immediately inside the article element for each post within the loop.',
				'functions' => array(),
				),
			'machina_before_entry_content' => array(
				'hook' => 'machina_entry_content',
				'area' => 'Loop',
				'description' => 'This hook executes immediately before the post/page content is output, outside the .entry-content div.',
				'functions' => array(),
				),
			'machina_entry_content' => array(
				'hook' => 'machina_entry_content',
				'area' => 'Loop',
				'description' => 'This hook outputs the actual post content and if chosen, the post image (inside the #content div).',
				'functions' => array(),
				),
			'machina_after_entry_content' => array(
				'hook' => 'machina_entry_content',
				'area' => 'Loop',
				'description' => 'This hook executes immediately after the post/page content is output, outside the .entry-content div.',
				'functions' => array(),
				),
			'machina_entry_footer' => array(
				'hook' => 'machina_entry_footer',
				'area' => 'Loop',
				'description' => 'This hook executes immediately before the close of the article element for each post within the loop.',
				'functions' => array(),
				),
			'machina_after_entry' => array(
				'hook' => 'machina_after_entry',
				'area' => 'Loop',
				'description' => 'This hook executes after each post in all loop blocks (outside the post_class() article).',
				'functions' => array(),
				),
			'machina_before_comments' => array(
				'hook' => 'machina_before_comments',
				'area' => 'Comment',
				'description' => 'This hook executes immediately before the comments block (outside the #comments div).',
				'functions' => array(),
				),
			'machina_list_comments' => array(
				'hook' => 'machina_list_comments',
				'area' => 'Comment',
				'description' => 'This hook executes inside the comments block, inside the .comment-list OL. By default, it outputs a list of comments associated with a post via the machina_default_list_comments() function.',
				'functions' => array(),
				),
			'machina_before_comment' => array(
				'hook' => 'machina_before_comment',
				'area' => 'Comment',
				'description' => 'This hook executes before the output of each individual comment (author, meta, comment text).',
				'functions' => array(),
				),
			'machina_comment' => array(
				'hook' => 'machina_comment',
				'area' => 'Comment',
				'description' => '',
				'functions' => array(),
				),
			'machina_after_comment' => array(
				'hook' => 'machina_after_comment',
				'area' => 'Comment',
				'description' => 'This hook executes after the output of each individual comment (author, meta, comment text).',
				'functions' => array(),
				),
			'machina_after_comments' => array(
				'hook' => 'machina_after_comments',
				'area' => 'Comment',
				'description' => 'This hook executes immediately after the comments block (outside the #comments div).',
				'functions' => array(),
				),
			'machina_before_pings' => array(
				'hook' => 'machina_before_pings',
				'area' => 'Comment',
				'description' => 'This hook executes immediately before the pings block (outside the #pings div).',
				'functions' => array(),
				),
			'machina_list_pings' => array(
				'hook' => 'machina_list_pings',
				'area' => 'Comment',
				'description' => 'This hook executes inside the pings block, inside the .ping-list OL. By default, it outputs a list of pings associated with a post via the machina_default_list_pings() function.',
				'functions' => array(),
				),
			'machina_after_pings' => array(
				'hook' => 'machina_after_pings',
				'area' => 'Comment',
				'description' => 'This hook executes immediately after the pings block (outside the #pings div).',
				'functions' => array(),
				),
			'machina_before_respond' => array(
				'hook' => 'machina_before_respond',
				'area' => 'Comment',
				'description' => '',
				'functions' => array(),
				),
			'machina_before_comment_form' => array(
				'hook' => 'machina_before_comment_form',
				'area' => 'Comment',
				'description' => 'This hook executes immediately before the comment form, outside the #respond div.',
				'functions' => array(),
				),
			'machina_comment_form' => array(
				'hook' => 'machina_comment_form',
				'area' => 'Comment',
				'description' => 'This hook outputs the actual comment form, including the #respond div wrapper.',
				'functions' => array(),
				),
			'machina_after_comment_form' => array(
				'hook' => 'machina_after_comment_form',
				'area' => 'Comment',
				'description' => 'This hook executes immediately after the comment form, outside the #respond div.',
				'functions' => array(),
				),
			'machina_after_respond' => array(
				'hook' => 'machina_after_respond',
				'area' => 'Comment',
				'description' => '',
				'functions' => array(),
				),
			'machina_after_endwhile' => array(
				'hook' => 'machina_after_endwhile',
				'area' => 'Loop',
				'description' => 'This hook executes after the endwhile; statement in all loop blocks.',
				'functions' => array(),
				),
			'machina_loop_else' => array(
				'hook' => 'machina_loop_else',
				'area' => 'Loop',
				'description' => 'This hook executes after the else : statement in all loop blocks.',
				'functions' => array(),
				),
			'machina_after_loop' => array(
				'hook' => 'machina_after_loop',
				'area' => 'Loop',
				'description' => 'This hook executes immediately after all loop blocks. Therefore, this hook falls outside the loop, and cannot execute functions that require loop template tags or variables.',
				'functions' => array(),
				),
			'machina_after_content' => array(
				'hook' => 'machina_after_content',
				'area' => 'Structural',
				'description' => 'This hook executes immediately after the content column (outside the #content div).',
				'functions' => array(),
				),
			'machina_before_sidebar_widget_area' => array(
				'hook' => 'machina_before_sidebar_widget_area',
				'area' => 'Structural',
				'description' => 'This hook executes immediately before the primary sidebar widget area (inside the #sidebar div).',
				'functions' => array(),
				),
			'machina_after_sidebar_widget_area' => array(
				'hook' => 'machina_after_sidebar_widget_area',
				'area' => 'Structural',
				'description' => 'This hook executes immediately after the primary sidebar widget area (inside the #sidebar div).',
				'functions' => array(),
				),
			'machina_after_content_sidebar_wrap' => array(
				'hook' => 'machina_after_content_sidebar_wrap',
				'area' => 'Structural',
				'description' => 'This hook executes immediately after the div block that wraps the content and the primary sidebar (outside the #content-sidebar-wrap div).',
				'functions' => array(),
				),
			'machina_before_sidebar_alt_widget_area' => array(
				'hook' => 'machina_before_sidebar_alt_widget_area',
				'area' => 'Structural',
				'description' => 'This hook executes immediately before the alternate sidebar widget area (inside the #sidebar-alt div).',
				'functions' => array(),
				),
			'machina_after_sidebar_alt_widget_area' => array(
				'hook' => 'machina_after_sidebar_alt_widget_area',
				'area' => 'Structural',
				'description' => 'This hook executes immediately after the alternate sidebar widget area (inside the #sidebar-alt div).',
				'functions' => array(),
				),
			'machina_before_footer' => array(
				'hook' => 'machina_before_footer',
				'area' => 'Structural',
				'description' => 'This hook executes immediately before the footer, outside the #footer div.',
				'functions' => array(),
				),
			'machina_footer' => array(
				'hook' => 'machina_footer',
				'area' => 'Structural',
				'description' => 'This hook, by default, outputs the content of the footer, including the #footer div wrapper.',
				'functions' => array(),
				),
			'machina_after_footer' => array(
				'hook' => 'machina_after_footer',
				'area' => 'Structural',
				'description' => 'This hook executes immediately after the footer, outside the #footer div.',
				'functions' => array(),
				),
			'machina_after' => array(
				'hook' => 'machina_after',
				'area' => 'Structural',
				'description' => 'This hook executes immediately before the closing tag in the document source.',
				'functions' => array(),
				)
		);

	foreach ( $gvhg_machina_action_hooks as $action )
		add_action( $action['hook'] , 'gvhg_machina_action_hook' , 1 );
}

function gvhg_machina_action_hook () {
global $gvhg_machina_action_hooks;

	$current_action = current_filter();

	if ( 'show' == isset( $_GET['g_hooks'] ) ) {

		if ( 'Document Head' == $gvhg_machina_action_hooks[$current_action]['area'] ) :

			echo "<!-- ";
				echo $current_action;
			echo " -->\n";

		else :

			echo '<div class="machina_hook" title="' . $gvhg_machina_action_hooks[$current_action]['description'] . '">' . $current_action . '</div>';

		endif;
	}

}

add_action( 'wp', 'gvhg_filter_logic' );
function gvhg_filter_logic() {

	if ( 'show' == isset( $_GET['g_filters'] ) ) {

		add_filter( 'machina_seo_title', 'gvhg_machina_seo_title', 10, 3 );
		add_filter( 'machina_seo_description', 'gvhg_machina_seo_description', 10, 3 );
		add_filter( 'machina_title_comments', 'gvhg_title_comments');
		add_filter( 'machina_comment_form_args', 'gvhg_comment_form_args');
		add_filter( 'machina_comments_closed_text', 'gvhg_comments_closed_text');
		add_filter( 'comment_author_says_text', 'gvhg_comment_author_says_text');
		add_filter( 'machina_no_comments_text', 'gvhg_no_comments_text');
		add_filter( 'machina_title_pings', 'gvhg_title_pings');
		add_filter( 'ping_author_says_text', 'gvhg_ping_author_says_text');
		add_filter( 'machina_no_pings_text', 'gvhg_no_pings_text');
		add_filter( 'machina_breadcrumb_args', 'gvhg_breadcrumb_args');
		add_filter( 'machina_footer_backtotop_text', 'gvhg_footer_backtotop_text', 100);
		add_filter( 'machina_footer_creds_text', 'gvhg_footer_creds_text', 100);
		//add_filter( 'machina_footer_output', 'gvhg_footer_output', 100, 3);
		add_filter( 'machina_author_box_title', 'gvhg_author_box_title' );
		add_filter( 'machina_post_info', 'gvhg_post_info' );
		add_filter( 'machina_post_meta', 'gvhg_post_meta' );
		add_filter( 'machina_post_title_text', 'gvhg_post_title_text');
		add_filter( 'machina_noposts_text', 'gvhg_noposts_text');
		add_filter( 'machina_search_text', 'gvhg_search_text');
		add_filter( 'machina_search_button_text', 'gvhg_search_button_text');
		add_filter( 'machina_nav_home_text', 'gvhg_nav_home_text');
		add_filter( 'machina_favicon_url', 'gvhg_favicon_url');
		add_filter( 'machina_footer_credits', 'gvhg_footer_creds_text');

	}

}

function gvhg_machina_seo_title( $title, $inside, $wrap ) {
	$title = sprintf('<%s id="title" title="Applied to the output of the machina_seo_site_title function which depending on the SEO option set by the user will either wrap the title in <h1> or <p> tags. Default value: $title, $inside, $wrap"><span class="filter">machina_seo_site_title</span></%s>', $wrap, $wrap);
	return $title;
}

function gvhg_machina_seo_description( $description, $inside, $wrap ) {
	$description = sprintf('<%s id="title" title="Applied to the output of the machina_seo_site_description function which depending on the SEO option set by the user will either wrap the description in <h1> or <p> tags. Default value: $description, $inside, $wrap"><span class="filter">machina_seo_description</span></%s>', $wrap, $wrap);
	return $description;
}

function gvhg_author_box_title() {
	$title = '<strong><span class="filter">machina_author_box_title</span></strong>';
	return $title;
}

function gvhg_comment_author_says_text($text) {
	$text = '<span class="filter">comment_author_says_text</span>';
	return $text;
}

function gvhg_ping_author_says_text($text) {
	$text = '<span class="filter">comment_author_says_text</span>';
	return $text;
}

function gvhg_footer_backtotop_text($backtotop_text) {
    $backtotop_text = '<div class="filter">machina_footer_backtotop_text</div>';
    return $backtotop_text;
}

function gvhg_footer_creds_text($creds) {
    $creds = '<div class="filter">machina_footer_creds_text</div>';
    return $creds;
}

function gvhg_footer_output($output, $backtotop_text, $creds) {
    $output = '<div class="filter">machina_footer_output</div>' . $backtotop_text . $creds;
    return $output;
}

function gvhg_breadcrumb_args($args) {
	$args['prefix'] = '<div class="breadcrumb"><span class="filter">machina_breadcrumb_args</span> ';
    $args['suffix'] = '</div>';
	$args['home'] = __('<span class="filter">[\'home\']</span>', 'machina');
    $args['sep'] = '<span class="filter">[\'sep\']</span>';
    $args['labels']['prefix'] = __('<span class="filter">[\'labels\'][\'prefix\']</span> ', 'machina');
	return $args;
}

function gvhg_title_pings() {
    echo '<h3 class="filter">machina_title_pings</h3>';
}

function gvhg_no_pings_text() {
    echo '<p class="filter">machina_no_pings_text</p>';
}

function gvhg_title_comments() {
    echo '<h3 class="filter">machina_title_comments</h3>';
}

function gvhg_comments_closed_text() {
    echo '<p class="filter">machina_comments_closed_text</p>';
}

function gvhg_no_comments_text() {
    echo '<p class="filter">machina_no_comments_text</p>';
}

function gvhg_comment_form_args($args) {
    $args['title_reply'] = '<span class="filter">machina_comment_form_args [\'title_reply\']</span>';
    $args['comment_notes_before'] = '<span class="filter">machina_comment_form_args [\'comment_notes_before\']</span>';
    $args['comment_notes_after'] = '<span class="filter">machina_comment_form_args [\'comment_notes_after\']</span>';

    return $args;
}

function gvhg_favicon_url() {
    $favicon = 'machina_favicon_url';
    return $favicon;
}

function gvhg_post_info($post_info) {
    $post_info = '<span class="filter">machina_post_info</span>';
    return $post_info;
}

function gvhg_post_meta($post_meta) {
    $post_meta = '<span class="filter">machina_post_meta</span>';
    return $post_meta;
}

function gvhg_post_title_text() {
	return '<span class="filter">machina_post_title_text</span>';
}

function gvhg_noposts_text() {
	return '<span class="filter">machina_noposts_text</span>';
}

function gvhg_search_text() {
	return esc_attr('machina_search_text');
}

function gvhg_search_button_text() {
	return esc_attr('machina_search_button_text');
}

function gvhg_nav_home_text() {
	return '<span class="filter">machina_nav_home_text</span>';
}
