<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maester
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('maester-single-post'); ?>>
    <header class="entry-header">

        <?php

            if ( 'post' === get_post_type() ) {
                echo "<div class='maester-single-post-meta'>";
                    maester_lite_single_post_meta();
                echo "</div>";
            }
            the_title( '<h1 class="entry-title">', '</h1>' );
         ?>
    </header><!-- .entry-header -->

    <?php maester_lite_post_thumbnail(); ?>

    <div class="entry-content">
        <?php
        the_content( sprintf(
            wp_kses(
            /* translators: %s: Name of current post. Only visible to screen readers */
                __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'maester-lite' ),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            get_the_title()
        ) );

        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'maester-lite' ),
            'after'  => '</div>',
        ) );
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php maester_lite_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
