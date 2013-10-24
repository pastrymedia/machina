<?php
/**
 * This file handles the creation of the custom hooks admin menu.
 */


/**
 * Registers a new admin page, providing content and corresponding menu item
 * for the Custom Hooks Settings page.
 *
 * @since 1.8.0
 */
class Machina_Admin_Hook_Settings extends Machina_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page.
	 *
	 * @since 1.8.0
	 *
	 * @uses MACHINA_HOOK_SETTINGS_FIELD settings field key
	 *
	 */
	function __construct() {

		$page_id = 'hook-settings';

		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'machina',
				'page_title'  => __( 'Machina - Hook Settings', 'machina' ),
				'menu_title'  => __( 'Hook Settings', 'machina' )
			)
		);

		$page_ops = array(
			'screen_icon' => 'plugins',
		);

		$settings_field = MACHINA_HOOK_SETTINGS_FIELD;

		$default_settings = array(

			//* Wordpress Hooks
			'wp_head' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'wp_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Internal Hooks
			'machina_pre' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_pre_framework' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_init' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_setup' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Document Hooks
			'machina_doctype' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_meta' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_before' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Header hooks
			'machina_before_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_header_right' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_site_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_site_description' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Content Hooks
			'machina_before_content_sidebar_wrap' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_content_sidebar_wrap' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_before_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Loop Hooks
			'machina_before_loop' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_loop' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_loop' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_after_endwhile' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_loop_else' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* HTML5 Entry Hooks
			'machina_before_entry' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_entry_header' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_entry_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_entry_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_entry' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* xHTML Entry Hooks
			'machina_before_post' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_post' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_before_post_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_post_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_post_title' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_before_post_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_post_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_post_content' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Comment Hooks
			'machina_before_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_list_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_comments' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_before_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_list_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_pings' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_before_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_before_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_comment' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_before_comment_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_comment_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_comment_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Sidebar Hooks
			'machina_before_sidebar' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_sidebar' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_sidebar' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_before_sidebar_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_sidebar_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_before_sidebar_alt' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_sidebar_alt' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_sidebar_alt' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_before_sidebar_alt_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_sidebar_alt_widget_area' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			'machina_before_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_after_footer' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

			//* Admin Hooks
			'machina_import_export_form' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_export' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_import' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_theme_settings_metaboxes' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),
			'machina_upgrade' => array( 'content' => '', 'php' => 0, 'shortcodes' => 0 ),

		);

		//* Create the page */
		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

	}

	/**
	 * Load the necessary scripts for this admin page.
	 *
	 * @since 1.8.0
	 *
	 */
	function scripts() {

		//* Load parent scripts as well as Machina admin scripts */
		parent::scripts();
		machina_load_admin_js();

	}

	/**
 	 * Register meta boxes on the custom hooks Settings page.
 	 *
 	 * @since 1.8.0
 	 *
 	 */
	function metaboxes() {

		add_meta_box( 'machina-hook-settings-wp-hooks', __( 'WordPress Hooks', 'machina' ), array( $this, 'wp_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'machina-hook-settings-document-hooks', __( 'Document Hooks', 'machina' ), array( $this, 'document_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'machina-hook-settings-header-hooks', __( 'Header Hooks', 'machina' ), array( $this, 'header_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'machina-hook-settings-content-hooks', __( 'Content Hooks', 'machina' ), array( $this, 'content_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'machina-hook-settings-loop-hooks', __( 'Loop Hooks', 'machina' ), array( $this, 'loop_hooks_box' ), $this->pagehook, 'main' );

		if ( current_theme_supports( 'html5' ) )
			add_meta_box( 'machina-hook-settings-entry-hooks', __( 'Entry Hooks', 'machina' ), array( $this, 'html5_entry_hooks_box' ), $this->pagehook, 'main' );
		else
			add_meta_box( 'machina-hook-settings-post-hooks', __( 'Post/Page Hooks', 'machina' ), array( $this, 'post_hooks_box' ), $this->pagehook, 'main' );

		add_meta_box( 'machina-hook-settings-comment-list-hooks', __( 'Comment List Hooks', 'machina' ), array( $this, 'comment_list_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'machina-hook-settings-ping-list-hooks', __( 'Ping List Hooks', 'machina' ), array( $this, 'ping_list_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'machina-hook-settings-comment-hooks', __( 'Single Comment Hooks', 'machina' ), array( $this, 'comment_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'machina-hook-settings-comment-form-hooks', __( 'Comment Form Hooks', 'machina' ), array( $this, 'comment_form_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'machina-hook-settings-sidebar-hooks', __( 'Sidebar Hooks', 'machina' ), array( $this, 'sidebar_hooks_box' ), $this->pagehook, 'main' );
		add_meta_box( 'machina-hook-settings-footer-hooks', __( 'Footer Hooks', 'machina' ), array( $this, 'footer_hooks_box' ), $this->pagehook, 'main' );

	}

	function wp_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'wp_head',
			'desc' => __( 'This hook executes immediately before the closing <code>&lt;/head&gt;</code> tag.', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'wp_footer',
			'desc' => __( 'This hook executes immediately before the closing <code>&lt;/body&gt;</code> tag.', 'machina' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

	function document_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'machina_title',
			'desc' => __( 'This hook executes between the main document <code>&lt;title&gt;&lt;/title&gt;</code> tags.', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_meta',
			'desc' => __( 'This hook executes in the document <code>&lt;head&gt;</code>.<br /> It is commonly used to output <code>META</code> information about the document.', 'machina' ),
			'unhook' => array( 'machina_load_favicon' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_before',
			'desc' => __( 'This hook executes immediately after the opening <code>&lt;body&gt;</code> tag.', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after',
			'desc' => __( 'This hook executes immediately before the closing <code>&lt;/body&gt;</code> tag.', 'machina' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

	function header_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_header',
			'desc' => __( 'This hook executes immediately before the header (outside the <code>#header</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_header',
			'desc' => __( 'This hook outputs the default header (the <code>#header</code> div)', 'machina' ),
			'unhook' => array( 'machina_do_header' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_header',
			'desc' => __( 'This hook executes immediately after the header (outside the <code>#header</code> div).', 'machina' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

	function content_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_content_sidebar_wrap',
			'desc' => __( 'This hook executes immediately before the div block that wraps the content and the primary sidebar (outside the <code>#content-sidebar-wrap</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_content_sidebar_wrap',
			'desc' => __( 'This hook executes immediately after the div block that wraps the content and the primary sidebar (outside the <code>#content-sidebar-wrap</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_content',
			'desc' => __( 'This hook executes immediately before the content column (outside the <code>#content</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_content',
			'desc' => __( 'This hook executes immediately after the content column (outside the <code>#content</code> div).', 'machina' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

	function loop_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_loop',
			'desc' => __( 'This hook executes immediately before all loop blocks.<br /> Therefore, this hook falls outside the loop, and cannot execute functions that require loop template tags or variables.', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_loop',
			'desc' => __( 'This hook executes both default and custom loops.', 'machina' ),
			'unhook' => array( 'machina_do_loop' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_loop',
			'desc' => __( 'This hook executes immediately after all loop blocks.<br /> Therefore, this hook falls outside the loop, and cannot execute functions that require loop template tags or variables.', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_endwhile',
			'desc' => __( 'This hook executes after the <code>endwhile;</code> statement.', 'machina' ),
			'unhook' => array( 'machina_posts_nav' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_loop_else',
			'desc' => __( 'This hook executes after the <code>else :</code> statement in all loop blocks. The content attached to this hook will only display if there are no posts available when a loop is executed.', 'machina' ),
			'unhook' => array( 'machina_do_noposts' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

	function html5_entry_hooks_box() {

		machina_hooks_form_generate(array(
			'hook' => 'machina_before_entry',
			'desc' => __( 'This hook executes before each entry in all loop blocks (outside the entry markup element).', 'machina' )
		) );

		machina_hooks_form_generate(array(
			'hook' => 'machina_entry_header',
			'desc' => __( 'This hook executes before the entry content. By default, it outputs the entry title and meta information.', 'machina' )
		) );

		machina_hooks_form_generate(array(
			'hook' => 'machina_entry_content',
			'desc' => __( 'This hook, by default, outputs the entry content.', 'machina' )
		) );

		machina_hooks_form_generate(array(
			'hook' => 'machina_entry_footer',
			'desc' => __( 'This hook executes after the entry content. By Default, it outputs entry meta information.', 'machina' )
		) );

		machina_hooks_form_generate(array(
			'hook' => 'machina_after_entry',
			'desc' => __( 'This hook executes after each entry in all loop blocks (outside the entry markup element).', 'machina' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

	function post_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_post',
			'desc' => __( 'This hook executes before each post in all loop blocks (outside the <code>post_class()</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_post',
			'desc' => __( 'This hook executes after each post in all loop blocks (outside the <code>post_class()</code> div).', 'machina' ),
			'unhook' => array( 'machina_do_author_box' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_post_title',
			'desc' => __( 'This hook executes immediately before each post/page title within the loop.', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_post_title',
			'desc' => __( 'This hook outputs the post/page title.', 'machina' ),
			'unhook' => array( 'machina_do_post_title' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_post_title',
			'desc' => __( 'This hook executes immediately after each post/page title within the loop.', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_post_content',
			'desc' => __( 'This hook executes immediately before the <code>machina_post_content</code> hook for each post/page within the loop.', 'machina' ),
			'unhook' => array( 'machina_post_info' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_post_content',
			'desc' => __( 'This hook outputs the content of the post/page, by default.', 'machina' ),
			'unhook' => array( 'machina_do_post_image', 'machina_do_post_content' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_post_content',
			'desc' => __( 'This hook executes immediately after the <code>machina_post_content</code> hook for each post/page within the loop.', 'machina' ),
			'unhook' => array( 'machina_post_meta' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

	function comment_list_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_comments',
			'desc' => __( 'This hook executes immediately before the comments block (outside the <code>#comments</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_comments',
			'desc' => __( 'This hook outputs the comments block, including the <code>#comments</code> div.', 'machina' ),
			'unhook' => array( 'machina_do_comments' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_list_comments',
			'desc' => __( 'This hook executes inside the comments block, inside the <code>.comment-list</code> OL. By default, it outputs a list of comments associated with a post via the <code>machina_default_list_comments()</code> function.', 'machina' ),
			'unhook' => array( 'machina_default_list_comments' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_comments',
			'desc' => __( 'This hook executes immediately after the comments block (outside the <code>#comments</code> div).', 'machina' )
		) );

	}

	function ping_list_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_pings',
			'desc' => __( 'This hook executes immediately before the pings block (outside the <code>#pings</code> div).', 'machina' ),
			'unhook' => array( 'machina_do_pings' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_pings',
			'desc' => __( 'This hook outputs the pings block, including the <code>#pings</code> div.', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_list_pings',
			'desc' => __( 'This hook executes inside the pings block, inside the <code>.ping-list</code> OL. By default, it outputs a list of pings associated with a post via the <code>machina_default_list_pings()</code> function.', 'machina' ),
			'unhook' => array( 'machina_default_list_pings' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_pings',
			'desc' => __( 'This hook executes immediately after the pings block (outside the <code>#pings</code> div).', 'machina' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

	function comment_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_comment',
			'desc' => __( 'This hook executes immediately before each individual comment (inside the <code>.comment</code> list item).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_comment',
			'desc' => __( 'This hook executes immediately after each individual comment (inside the <code>.comment</code> list item).', 'machina' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

	function comment_form_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_comment_form',
			'desc' => __( 'This hook executes immediately before the comment form, outside the <code>#respond</code> div.', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_comment_form',
			'desc' => __( 'This hook outputs the entire comment form, including the <code>#respond</code> div.', 'machina' ),
			'unhook' => array( 'machina_do_comment_form' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_comment_form',
			'desc' => __( 'This hook executes immediately after the comment form, outside the <code>#respond</code> div.', 'machina' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

	function sidebar_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_sidebar',
			'desc' => __( 'This hook executes immediately before the primary sidebar column (outside the <code>#sidebar</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_sidebar',
			'desc' => __( 'This hook outputs the content of the primary sidebar, including the widget area output.', 'machina' ),
			'unhook' => array( 'machina_do_sidebar' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_sidebar',
			'desc' => __( 'This hook executes immediately after the primary sidebar column (outside the <code>#sidebar</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_sidebar_widget_area',
			'desc' => __( 'This hook executes immediately before the primary sidebar widget area (inside the <code>#sidebar</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_sidebar_widget_area',
			'desc' => __( 'This hook executes immediately after the primary sidebar widget area (inside the <code>#sidebar</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_sidebar_alt',
			'desc' => __( 'This hook executes immediately before the alternate sidebar column (outside the <code>#sidebar-alt</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_sidebar_alt',
			'desc' => __( 'This hook outputs the content of the secondary sidebar, including the widget area output.', 'machina' ),
			'unhook' => array( 'machina_do_sidebar_alt' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_sidebar_alt',
			'desc' => __( 'This hook executes immediately after the alternate sidebar column (outside the <code>#sidebar-alt</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_sidebar_alt_widget_area',
			'desc' => __( 'This hook executes immediately before the alternate sidebar widget area (inside the <code>#sidebar-alt</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_sidebar_alt_widget_area',
			'desc' => __( 'This hook executes immediately after the alternate sidebar widget area (inside the <code>#sidebar-alt</code> div).', 'machina' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

	function footer_hooks_box() {

		machina_hooks_form_generate( array(
			'hook' => 'machina_before_footer',
			'desc' => __( 'This hook executes immediately before the footer (outside the <code>#footer</code> div).', 'machina' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_footer',
			'desc' => __( 'This hook, by default, outputs the content of the footer (inside the <code>#footer</code> div).', 'machina' ),
			'unhook' => array( 'machina_do_footer' )
		) );

		machina_hooks_form_generate( array(
			'hook' => 'machina_after_footer',
			'desc' => __( 'This hook executes immediately after the footer (outside the <code>#footer</code> div).', 'machina' )
		) );

		submit_button( __( 'Save Changes', 'machina' ), 'primary' );

	}

}

add_action( 'machina_admin_menu', 'machina_hooks_settings_menu' );
/**
 * Instantiate the class to create the menu.
 *
 * @since 1.8.0
 */
function machina_hooks_settings_menu() {

	new Machina_Admin_Hook_Settings;

}