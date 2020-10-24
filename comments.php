<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package maester
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<section id="comments" class="comments-area" aria-label="<?php esc_attr_e( 'Post Comments', 'maester-lite' ); ?>">

    <?php
    if ( have_comments() ) :
        ?>
        <h2 class="comments-title">
            <?php
            printf(
            // WPCS: XSS OK.
            // phpcs:ignore WordPress.Security.EscapeOutput.DeprecatedWhitelistCommentFound
            /* translators: 1: number of comments, 2: post title */
                esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'maester-lite' ) ),
                esc_html(number_format_i18n( get_comments_number() )),
                '<span>' . esc_html(get_the_title()) . '</span>'
            );
            ?>
        </h2>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through. ?>
        <nav id="comment-nav-above" class="comment-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Comment Navigation Above', 'maester-lite' ); ?>">
            <span class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'maester-lite' ); ?></span>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'maester-lite' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'maester-lite' ) ); ?></div>
        </nav><!-- #comment-nav-above -->
    <?php endif; // Check for comment navigation. ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(
                array(
                    'style'      => 'ol',
                    'short_ping' => true,
                    'callback'   => 'maester_lite_comment',
                )
            );
            ?>
        </ol><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through. ?>
        <nav id="comment-nav-below" class="comment-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Comment Navigation Below', 'maester-lite' ); ?>">
            <span class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'maester-lite' ); ?></span>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'maester-lite' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'maester-lite' ) ); ?></div>
        </nav><!-- #comment-nav-below -->
    <?php
    endif; // Check for comment navigation.

    endif;

    if ( ! comments_open() && 0 !== intval( get_comments_number() ) && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'maester-lite' ); ?></p>
    <?php
    endif;

    $maester_lite_args = apply_filters(
        'maester_lite_comment_form_args', array(
            'title_reply_before' => '<span id="reply-title" class="h3 comment-reply-title">',
            'title_reply_after'  => '</span>',
        )
    );

    comment_form( $maester_lite_args );
    ?>

</section><!-- #comments -->
