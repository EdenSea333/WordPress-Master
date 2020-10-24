<?php
	/**
	 * Template Name: Blank (No Header & Footer)
	 *
	 * @package WordPress
	 * @subpackage Maester
	 * @since Maester 1.0.2
	 */

	get_header('empty');

?>

	<div id="content" class="site-empty-content">
		<?php
			if(have_posts()){
				while (have_posts()){
					the_post();
					the_content();
				}
			}
		?>
	</div><!-- #content -->

<?php

	get_footer('empty');