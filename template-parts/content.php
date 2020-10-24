<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maester
 */

    $maester_lite_enable_blog_thumbnail = get_theme_mod('enable_blog_thumbnail', true);
    $maester_lite_enable_blog_category = get_theme_mod('enable_blog_category', true);
    $maester_lite_enable_blog_content = get_theme_mod('enable_blog_content', true);
    $maester_lite_enable_blog_author = get_theme_mod('enable_blog_author', true);
    $maester_lite_enable_blog_date = get_theme_mod('enable_blog_date', true);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-listing'); ?>>

	<?php if($maester_lite_enable_blog_thumbnail) maester_lite_post_thumbnail(); ?>

    <div class="post-content-body">
        <header class="entry-header">
            <?php

            /* translators: used between list items, there is a space after the comma */
            $maester_lite_categories_list = get_the_category_list( ', ' );
            if ( $maester_lite_enable_blog_category && $maester_lite_categories_list ) {
                /* translators: 1: list of categories. */
                printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'maester-lite' ) . '</span>', wp_kses(
	                $maester_lite_categories_list,
                    array(
                        "a" => array(
                                "href" => array(),
                                "rel" => array()
                        )
	                )
                ) );
            }

            the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
            ?>
        </header><!-- .entry-header -->

        <div class="entry-summary">
            <?php if($maester_lite_enable_blog_content) {
                the_excerpt();
            }; ?>
        </div><!-- .entry-content -->

        <?php if($maester_lite_enable_blog_author || $maester_lite_enable_blog_date) { ?>
        <footer class="entry-footer">
            <?php
                if ( 'post' === get_post_type() ) :
                    ?>
                    <div class="entry-meta">
                        <?php
                            if($maester_lite_enable_blog_author) maester_lite_posted_by();
                            if($maester_lite_enable_blog_date) maester_lite_posted_on();
                        ?>
                    </div><!-- .entry-meta -->
                <?php endif;
            ?>
        </footer><!-- .entry-footer -->
        <?php } ?>
    </div> <!--post-content-body-->
</article><!-- #post-<?php the_ID(); ?> -->
