<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Maester
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function maester_lite_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter( 'body_class', 'maester_lite_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function maester_lite_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'maester_lite_pingback_header' );


/**
 * Search Popup
 */
add_filter('maester_lite_after_footer_hook', 'maester_lite_search_pupup', 10, 2);

function maester_lite_search_pupup(){
    ?>
    <form action='<?php esc_url(home_url()); ?>' id='maester-popup-search-form' style='display: none;'>
        <div class='maester-popup-search-overlay'></div>
        <div class='maester-pupup-search-inner'>
            <input type='search' name='s' placeholder='<?php esc_attr_e('Search anything...', 'maester-lite'); ?>'>
            <input type='submit' value='<?php esc_attr_e('Search', 'maester-lite'); ?>'>
        </div>
    </form>
    <?php

}


//add_action('maester_lite_after_header_hook', 'maester_lite_breadcrumbs', 10);
function maester_lite_breadcrumbs(){
    $get_breadcrumb = maester_lite_get_breadcrumb();
    if(function_exists('maester_lite_get_breadcrumb') && !empty($get_breadcrumb)){ ?>
        <div class="maester-breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <?php
                        echo wp_kses(
	                        maester_lite_get_breadcrumb(),
	                        array(
                                'a' => array(
                                    'href' => array(),
                                    'class' => array(),
                                    'itemprop' => array(),
                                ),
		                        'i' => array(
			                        'class' => array()
		                        ),
		                        'div' => array(
			                        'class' => array(),
			                        'itemprop' => array(),
			                        'itemscope' => array(),
			                        'itemtype' => array()
		                        ),
		                        'span' => array(
			                        'class' => array(),
			                        'itemprop' => array(),
			                        'itemscope' => array(),
			                        'itemtype' => array()
		                        ),
		                        'meta' => array(
			                        'content' => array(),
			                        'itemprop' => array()
		                        )
	                        )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'maester_lite_cart_link_fragment' ) ) {
    /**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX
     *
     * @param  array $fragments Fragments to refresh via AJAX.
     * @return array            Fragments to refresh via AJAX
     */
    function maester_lite_cart_link_fragment( $fragments ) {
        global $woocommerce;

        ob_start();
        maester_lite_cart_link();
        $fragments['a.cart-contents'] = ob_get_clean();

        ob_start();
        maester_lite_handheld_footer_bar_cart_link();
        $fragments['a.footer-cart-contents'] = ob_get_clean();

        return $fragments;
    }
}


if ( ! function_exists( 'maester_lite_cart_link' ) ) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return void
     * @since  1.0.0
     */
    function maester_lite_cart_link() {
        ?>
        <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'maester-lite' ); ?>">
            <?php /* translators: %d: number of items in cart */ ?>
            <?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?> <span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'maester-lite' ), WC()->cart->get_cart_contents_count() ) ); ?></span>
        </a>
        <?php
    }
}

/**
 * Cart fragment
 *
 * @see maester_lite_cart_link_fragment()
 */
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
    add_filter( 'woocommerce_add_to_cart_fragments', 'maester_lite_cart_link_fragment' );
} else {
    add_filter( 'add_to_cart_fragments', 'maester_lite_cart_link_fragment' );
}



if ( ! function_exists( 'maester_lite_handheld_footer_bar_cart_link' ) ) {
    /**
     * The cart callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function maester_lite_handheld_footer_bar_cart_link() {
        ?>
        <a class="footer-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'maester-lite' ); ?>">
            <span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
        </a>
        <?php
    }
}


if ( ! function_exists( 'maester_lite_is_woocommerce_activated' ) ) {
    /**
     * Query WooCommerce activation
     */
    function maester_lite_is_woocommerce_activated() {
        return class_exists( 'WooCommerce' ) ? true : false;
    }
}


if ( ! function_exists( 'maester_lite_single_post_meta' ) ) {
    /**
     * Display the post meta
     *
     * @since 0.0.1
     */
    function maester_lite_single_post_meta() {
        if ( 'post' !== get_post_type() ) {
            return;
        }
        $enable_single_blog_date = get_theme_mod('enable_single_blog_date', true);
        $enable_single_blog_author = get_theme_mod('enable_single_blog_author', true);
        $enable_single_blog_comment_number = get_theme_mod('enable_single_blog_comment_number', true);

        // Posted on.
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );

        $output_time_string = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );

        $posted_on = '<span class="posted-on">' .
            /* translators: %s: post date */
            sprintf( __( 'Posted on %s', 'maester-lite' ), $output_time_string ) .
            '</span>';
        if(!$enable_single_blog_date) $posted_on = '';

        // Author.
        $author = sprintf(
            '<span class="post-author">%1$s <a href="%2$s" class="url fn" rel="author">%3$s</a></span>',
            __( 'by', 'maester-lite' ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_html( get_the_author() )
        );
        if(!$enable_single_blog_author) $author = '';


        // Comments.
        $comments = '';

        if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
            $comments_number = get_comments_number_text( __( 'Leave a comment', 'maester-lite' ), __( '1 Comment', 'maester-lite' ), __( '% Comments', 'maester-lite' ) );

            $comments = sprintf(
                '<span class="post-comments">&mdash; <a href="%1$s">%2$s</a></span>',
                esc_url( get_comments_link() ),
                $comments_number
            );
        }
        if(!$enable_single_blog_comment_number) $comments = '';

        echo wp_kses(
            sprintf( '%1$s %2$s %3$s', $posted_on, $author, $comments ), array(
                'span' => array(
                    'class' => array(),
                ),
                'a'    => array(
                    'href'  => array(),
                    'title' => array(),
                    'rel'   => array(),
                ),
                'time' => array(
                    'datetime' => array(),
                    'class'    => array(),
                ),
            )
        );
    }
}


if ( ! function_exists( 'maester_lite_comment' ) ) {
    /**
     * Maester comment template
     *
     * @param array $comment the comment array.
     * @param array $args the comment args.
     * @param int   $depth the comment depth.
     * @since 0.0.1
     */
    function maester_lite_comment( $comment, $args, $depth ) {
        if ( 'div' === $args['style'] ) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo esc_html( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body">
        <div class="comment-meta commentmetadata">
            <div class="comment-author vcard">
                <?php echo get_avatar( $comment, 128 ); ?>
                <?php printf( wp_kses_post( '<cite class="fn">%s</cite>', 'maester-lite' ), get_comment_author_link() ); ?>
            </div>
            <?php if ( '0' === $comment->comment_approved ) : ?>
                <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'maester-lite' ); ?></em>
                <br />
            <?php endif; ?>

            <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>" class="comment-date">
                <?php echo '<time datetime="' . esc_attr(get_comment_date( 'c' )) . '">' . esc_html(get_comment_date()) . '</time>'; ?>
            </a>
        </div>
        <?php if ( 'div' !== $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-content">
    <?php endif; ?>
        <div class="comment-text">
            <?php comment_text(); ?>
        </div>
        <div class="reply">
            <?php
            comment_reply_link(
                array_merge(
                    $args, array(
                        'add_below' => $add_below,
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                    )
                )
            );
            ?>
            <?php edit_comment_link( __( 'Edit', 'maester-lite' ), '  ', '' ); ?>
        </div>
        </div>
        <?php if ( 'div' !== $args['style'] ) : ?>
            </div>
        <?php endif; ?>
        <?php
    }
}

/**
 * Tutor Template Hooks
 */

function maester_lite_tutor_breadcrumb(){
    echo wp_kses(
        maester_lite_get_breadcrumb(),
        array(
            'a' => array(
                'href' => array(),
                'class' => array(),
                'itemprop' => array(),
            ),
            'i' => array(
                'class' => array()
            ),
            'div' => array(
                'class' => array(),
                'itemprop' => array(),
                'itemscope' => array(),
                'itemtype' => array()
            ),
            'span' => array(
                'class' => array(),
                'itemprop' => array(),
                'itemscope' => array(),
                'itemtype' => array()
            ),
            'meta' => array(
                'content' => array(),
                'itemprop' => array()
            )
        )
    );
}

add_action('tutor_course/single/before/wrap', 'maester_lite_breadcrumbs', 10, 2);
add_action('tutor_course/single/enrolled/before/wrap', 'maester_lite_breadcrumbs', 10, 2);


/**
 * Showing Notice
 */


function maester_lite_site_notice(){
    $maester_lite_enable_notice = get_theme_mod('maester_enable_notice', false);
    $maester_lite_notice_text = get_theme_mod('maester_notice_text', 'Notice text here');
    if($maester_lite_enable_notice){
        ?>
        <p class="maester-site-notice"><i class="fas fa-exclamation-circle"></i> <?php echo esc_html($maester_lite_notice_text) ?> <a href="#" class="maester-notice-dismiss"><i class="fas fa-times-circle"></i> <?php esc_html_e('Dissmis', 'maester-lite') ?></a></p>
        <?php
    }
}
add_action('maester_lite_after_footer_hook', 'maester_lite_site_notice');


/**
 * Get Copyright Credits
 * @param bool $strip_tags
 * @return array|mixed|void
 * @since 0.0.1
 */

function maester_lite_get_copyright_credits($strip_tags = false){
    $copyright_link = apply_filters('maester_lite_copyright_link', "http://themes.feeha.net/maester-lite/");
    $credits = apply_filters('maester_lite_copyright_credits', array(
        "credit_1" => sprintf(__("Built with %1\$s Maester Lite WordPress Theme %2\$s", 'maester-lite'), "<a href='".esc_url($copyright_link)."' rel='author'>", "</a>"),
        "credit_2" => sprintf(__("Powered by %1\$s Maester Lite by FeehaThemes %2\$s", 'maester-lite'), "<a href='".esc_url($copyright_link)."' rel='author'>", "</a>"),
        "credit_3" => sprintf(__("Proudly powered by WordPress | Theme: %1\$s Maester Lite by FeehaThemes %2\$s", 'maester-lite'), "<a href='".esc_url($copyright_link)."' rel='author'>", "</a>"),
        "credit_4" => sprintf(__("A WordPress Website | Theme: %1\$s Maester Lite by FeehaThemes %2\$s", 'maester-lite'), "<a href='".esc_url($copyright_link)."' rel='author'>", "</a>"),
        "credit_5" => sprintf(__("Theme: %1\$s Maester Lite by FeehaThemes %2\$s", 'maester-lite'), "<a href='".esc_url($copyright_link)."' rel='author'>", "</a>"),
    ));
    if($strip_tags == true){
        $credits = array_map( function($item){
            return strip_tags($item);
        }, $credits);
    }
    return $credits;
}
