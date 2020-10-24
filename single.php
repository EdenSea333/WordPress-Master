<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Maester
 */

get_header();
$maester_lite_enable_single_blog_navigation = get_theme_mod('enable_single_blog_navigation', true);
$maester_lite_enable_single_blog_comments = get_theme_mod('enable_single_blog_comments', true);
$maester_lite_enable_single_blog_sidebar = get_theme_mod('enable_single_blog_sidebar', true);
$maester_lite_blog_column_class = !$maester_lite_enable_single_blog_sidebar || !is_active_sidebar( 'sidebar-1' ) ? 'col-12' : 'col-lg-8';
maester_lite_breadcrumbs();
?>
    <div id="content" class="site-content">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr($maester_lite_blog_column_class) ?>">
                    <div id="primary" class="content-area">
                        <main id="main" class="site-main">

                            <?php
                            while ( have_posts() ) :
                                the_post();

                                get_template_part( 'template-parts/content', 'single' );

                                if($maester_lite_enable_single_blog_navigation) the_post_navigation();

                                // If comments are open or we have at least one comment, load up the comment template.
                                if ($maester_lite_enable_single_blog_comments && ( comments_open() || get_comments_number()) ) :
                                    comments_template();
                                endif;

                            endwhile; // End of the loop.
                            ?>

                        </main><!-- #main -->
                    </div><!-- #primary -->
                </div><!-- .col-md-* -->
                <?php if($maester_lite_enable_single_blog_sidebar) get_sidebar(); ?>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- #content -->
<?php
get_sidebar();
get_footer();
