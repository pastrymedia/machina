<?php
/**
 * Machina Framework.
 *
 * WARNING: This file is part of the core Machina Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Machina\Comments
 * @author  MachinaThemes
 * @license GPL-2.0+
 * @link    http://my.machinathemes.com/themes/machina/
 */

add_action( 'machina_after_entry', 'machina_get_comments_template' );
/**
 * Output the comments at the end of entries.
 *
 * Load comments only if we are on a post, page, or CPT that supports comments, and only if comments or trackbacks are enabled.
 *
 * @since 1.1.0
 *
 * @uses machina_get_option() Get theme setting value.
 *
 * @global WP_Post $post Post object.
 *
 * @return null Return early if post type does not support comments.
 */
function machina_get_comments_template() {

	global $post;

	if ( ! post_type_supports( $post->post_type, 'comments' ) )
		return;

	if ( is_singular() && ! in_array( $post->post_type, array( 'post', 'page' ) ) )
		comments_template( '', true );
	elseif ( is_singular( 'post' ) && ( machina_get_option( 'trackbacks_posts' ) || machina_get_option( 'comments_posts' ) ) )
		comments_template( '', true );
	elseif ( is_singular( 'page' ) && ( machina_get_option( 'trackbacks_pages' ) || machina_get_option( 'comments_pages' ) ) )
		comments_template( '', true );

}

add_action( 'machina_comments', 'machina_do_comments' );
/**
 * Echo Machina default comment structure.
 *
 * Does the `machina_list_comments` action.
 *
 * Applies the `machina_title_comments`, `machina_prev_comments_link_text`, `machina_next_comments_link_text`, and
 * `machina_comments_closed_text` filters.
 *
 * @since 1.1.2
 *
 * @uses machina_get_option() Get theme setting value.
 *
 * @global WP_Post  $post     Post object.
 * @global WP_Query $wp_query Query object.
 *
 * @return null Return early if on a page with Machina pages comments off, or on a post with Machina posts comments off.
 */
function machina_do_comments() {

	global $post, $wp_query;

	//* Bail if comments are off for this post type
	if ( ( is_page() && ! machina_get_option( 'comments_pages' ) ) || ( is_single() && ! machina_get_option( 'comments_posts' ) ) )
		return;

	if ( have_comments() && ! empty( $wp_query->comments_by_type['comment'] ) ) {

		machina_markup( array(
			'html'   => '<div %s>',
			'context' => 'entry-comments',
		) );

		echo apply_filters( 'machina_title_comments', __( '<h3>Comments</h3>', 'machina' ) );
		echo '<ol class="comment-list">';
			do_action( 'machina_list_comments' );
		echo '</ol>';

		//* Comment Navigation
		$prev_link = get_previous_comments_link( apply_filters( 'machina_prev_comments_link_text', '' ) );
		$next_link = get_next_comments_link( apply_filters( 'machina_next_comments_link_text', '' ) );

		if ( $prev_link || $next_link ) {

			machina_markup( array(
				'html'   => '<div %s>',
				'context' => 'comments-pagination',
			) );

			printf( '<div class="pagination-previous alignleft">%s</div>', $prev_link );
			printf( '<div class="pagination-next alignright">%s</div>', $next_link );

			echo '</div>';

		}

		echo '</div>';

	}
	//* No comments so far
	elseif ( 'open' === $post->comment_status && $no_comments_text = apply_filters( 'machina_no_comments_text', '' ) ) {
			echo sprintf( '<div %s>', machina_attr( 'entry-comments' ) ) . $no_comments_text . '</div>';

	}
	elseif ( $comments_closed_text = apply_filters( 'machina_comments_closed_text', '' ) ) {
			echo sprintf( '<div %s>', machina_attr( 'entry-comments' ) ) . $comments_closed_text . '</div>';

	}

}

add_action( 'machina_pings', 'machina_do_pings' );
/**
 * Echo Machina default trackback structure.
 *
 * Does the `machina_list_args` action.
 *
 * Applies the `machina_no_pings_text` filter.
 *
 * @since 1.1.2
 *
 * @uses machina_get_option() Get theme setting value.
 *
 * @global WP_Query $wp_query Query object.
 *
 * @return null Return early if on a page with Machina pages trackbacks off, or on a post with Machina posts trackbacks off.
 */
function machina_do_pings() {

	global $wp_query;

	//* Bail if trackbacks are off for this post type
	if ( ( is_page() && ! machina_get_option( 'trackbacks_pages' ) ) || ( is_single() && ! machina_get_option( 'trackbacks_posts' ) ) )
		return;

	//* If have pings
	if ( have_comments() && !empty( $wp_query->comments_by_type['pings'] ) ) {

		machina_markup( array(
			'html'   => '<div %s>',
			'context' => 'entry-pings',
		) );

		echo apply_filters( 'machina_title_pings', __( '<h3>Trackbacks</h3>', 'machina' ) );
		echo '<ol class="ping-list">';
			do_action( 'machina_list_pings' );
		echo '</ol>';

		echo '</div>';

	} else {

		echo apply_filters( 'machina_no_pings_text', '' );

	}

}

add_action( 'machina_list_comments', 'machina_default_list_comments' );
/**
 * Output the list of comments.
 *
 * Applies the `machina_comment_list_args` filter.
 *
 * @since 1.0.0
 *
 * @see machina_comment_callback()       XHTML callback.
 *
 */
function machina_default_list_comments() {

	$defaults = array(
		'type'        => 'comment',
		'avatar_size' => 48,
		'format'      => 'html5', //* Not necessary, but a good example
		'callback'    => 'machina_comment_callback',
	);

	$args = apply_filters( 'machina_comment_list_args', $defaults );

	wp_list_comments( $args );

}

add_action( 'machina_list_pings', 'machina_default_list_pings' );
/**
 * Output the list of trackbacks.
 *
 * Applies the `machina_ping_list_args` filter.
 *
 * @since 1.0.0
 */
function machina_default_list_pings() {

	$args = apply_filters( 'machina_ping_list_args', array(
		'type' => 'pings',
	) );

	wp_list_comments( $args );

}

/**
 * Comment callback for {@link machina_default_list_comments()} if HTML5 is active.
 *
 * Does `machina_before_comment` and `machina_after_comment` actions.
 *
 * Applies `comment_author_says_text` and `machina_comment_awaiting_moderation` filters.
 *
 * @since 2.0.0
 *
 * @param stdClass $comment Comment object.
 * @param array    $args    Comment args.
 * @param integer  $depth   Depth of current comment.
 */
function machina_comment_callback( $comment, array $args, $depth ) {

	$GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
	<article <?php echo machina_attr( 'comment' ); ?>>

		<?php do_action( 'machina_before_comment' ); ?>

		<header class="comment-header">
			<p <?php echo machina_attr( 'comment-author' ); ?>>
				<?php
				echo get_avatar( $comment, $args['avatar_size'] );

				$author = get_comment_author();
				$url    = get_comment_author_url();

				if ( ! empty( $url ) && 'http://' !== $url ) {
					$author = sprintf( '<a href="%s" rel="external nofollow" itemprop="url">%s</a>', esc_url( $url ), $author );
				}

				printf( '<span itemprop="name">%s</span> <span class="says">%s</span>', $author, apply_filters( 'comment_author_says_text', __( 'says', 'machina' ) ) );
				?>
		 	</p>

			<p class="comment-meta">
				<?php
				$pattern = '<time itemprop="commentTime" datetime="%s"><a href="%s" itemprop="url">%s %s %s</a></time>';
				printf( $pattern, esc_attr( get_comment_time( 'c' ) ), esc_url( get_comment_link( $comment->comment_ID ) ), esc_html( get_comment_date() ), __( 'at', 'machina' ), esc_html( get_comment_time() ) );

				edit_comment_link( __( '(Edit)', 'machina' ), ' ' );
				?>
			</p>
		</header>

		<div class="comment-content" itemprop="commentText">
			<?php if ( ! $comment->comment_approved ) : ?>
				<p class="alert"><?php echo apply_filters( 'machina_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'machina' ) ); ?></p>
			<?php endif; ?>

			<?php comment_text(); ?>
		</div>

		<?php
		comment_reply_link( array_merge( $args, array(
			'depth'  => $depth,
			'before' => '<div class="comment-reply">',
			'after'  => '</div>',
		) ) );
		?>

		<?php do_action( 'machina_after_comment' ); ?>

	</article>
	<?php
	//* No ending </li> tag because of comment threading

}

add_action( 'machina_comment_form', 'machina_do_comment_form' );
/**
 * Optionally show the comment form.
 *
 * Machina asks WP for the HTML5 version of the comment form - it uses {@link machina_comment_form_args()} to revert to
 * XHTML form fields when child theme doesn't support HTML5.
 *
 * @since 1.0.0
 *
 * @return null Return early if comments are closed via Machina for this page or post.
 */
function machina_do_comment_form() {

	//* Bail if comments are closed for this post type
	if ( ( is_page() && ! machina_get_option( 'comments_pages' ) ) || ( is_single() && ! machina_get_option( 'comments_posts' ) ) )
		return;

	comment_form( array( 'format' => 'html5' ) );

}

add_filter( 'comment_form_defaults', 'machina_comment_form_args' );
/**
 * Filter the default comment form arguments, used by `comment_form()`.
 *
 * Applies only to XHTML child themes, since Machina uses default HTML5 comment form where possible.
 *
 * Applies `machina_comment_form_args` filter.
 *
 * @since 1.8.0
 *
 *
 * @global string $user_identity Display name of the user.
 *
 * @param array $defaults Comment form defaults.
 *
 * @return array Filterable array.
 */
function machina_comment_form_args( array $defaults ) {

	//* Use WordPress default HTML5 comment form
		return $defaults;

	global $user_identity;

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? ' aria-required="true"' : '' );

	$author = '<p class="comment-form-author">' .
	          '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"' . $aria_req . ' />' .
	          '<label for="author">' . __( 'Name', 'machina' ) . '</label> ' .
	          ( $req ? '<span class="required">*</span>' : '' ) .
	          '</p>';

	$email = '<p class="comment-form-email">' .
	         '<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" tabindex="2"' . $aria_req . ' />' .
	         '<label for="email">' . __( 'Email', 'machina' ) . '</label> ' .
	         ( $req ? '<span class="required">*</span>' : '' ) .
	         '</p>';

	$url = '<p class="comment-form-url">' .
	       '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' .
	       '<label for="url">' . __( 'Website', 'machina' ) . '</label>' .
	       '</p>';

	$comment_field = '<p class="comment-form-comment">' .
	                 '<textarea id="comment" name="comment" cols="45" rows="8" tabindex="4" aria-required="true"></textarea>' .
	                 '</p>';

	$args = array(
		'comment_field'        => $comment_field,
		'title_reply'          => __( 'Join the Discussion', 'machina' ),
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'fields'               => array(
			'author' => $author,
			'email'  => $email,
			'url'    => $url,
		),
	);

	//* Merge $args with $defaults
	$args = wp_parse_args( $args, $defaults );

	//* Return filterable array of $args, along with other optional variables
	return apply_filters( 'machina_comment_form_args', $args, $user_identity, get_the_ID(), $commenter, $req, $aria_req );

}

add_filter( 'get_comments_link', 'machina_comments_link_filter', 10, 2 );
/**
 * Filter the comments link. If post has comments, link to #comments div. If no, link to #respond div.
 *
 * @since 2.0.1
 */
function machina_comments_link_filter( $link, $post_id ) {

	if ( 0 == get_comments_number() )
		return get_permalink( $post_id ) . '#respond';

	return $link;

}

/**
 * Remove comments frontend. Useful if replacing WP commenting with Disqus.
 *
 * @since 2.0.10
 */
// remove_action( 'machina_comments', 'machina_do_comments' );
// remove_action( 'machina_comment_form', 'machina_do_comment_form' );

/**
 * Remove pings frontend.
 *
 * @since 2.0.16
 */
// remove_action( 'machina_pings', 'machina_do_pings' );

/**
 * Remove the entire comments area frontend, including comments, reply form, and pings.
 *
 * @since 2.0.16
 */
// remove_action( 'machina_after_entry', 'machina_get_comments_template' );

