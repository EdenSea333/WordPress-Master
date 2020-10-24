<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maester
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article-search'); ?>>
    <div class="entry-meta">
        <?php
            maester_lite_posted_on();
            maester_lite_posted_by();
        ?>
    </div><!-- .entry-meta -->
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header><!-- .entry-header -->

</article><!-- #post-<?php the_ID(); ?> -->
