<?php
/**
 * Template Name: Home Full Width
 *
 * @package WordPress
 * @subpackage Maester
 * @since Maester 1.0.0
 */


get_header();

?>

    <div id="content" class="site-content">
        <div class="container">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <?php
                        if(have_posts()){
                            while(have_posts()){
                                the_post();
                                the_content();
                            }
                        }
                    ?>
                </main>
            </div><!-- #primary -->
        </div><!-- .container -->
    </div><!-- #content -->

<?php

get_footer();