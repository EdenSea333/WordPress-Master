<?php
	/**
	 * The template for displaying the footer
	 *
	 * Contains the closing of the #content div and all content after.
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Maester
	 */

?>

<?php do_action('maester_lite_before_footer_hook'); ?>
<footer id="colophon" class="site-footer">
	<?php get_template_part( 'template-parts/content', 'footer' ); ?>

</footer><!-- #colophon -->
<?php do_action('maester_lite_after_footer_hook'); ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
