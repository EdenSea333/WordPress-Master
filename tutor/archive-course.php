<?php

/**
 * Template for displaying courses
 *
 * @since v.1.0.0
 *
 * @author feehatheme
 * @url https://feeha.net
 */

get_header();
maester_lite_breadcrumbs();

?>
	<div id="content" class="site-content">
		<div class="container">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">
					<?php tutor_course_archive_filter_bar(); ?>
					<?php
						if(function_exists('maester_toolkit_course_loop')){
							maester_toolkit_course_loop();
						}else{
							if ( have_posts() ) :
								tutor_course_loop_start();
								while ( have_posts() ) : the_post();
									tutor_course_loop_before_content();
									tutor_load_template('loop.course');
									tutor_course_loop_after_content();
								endwhile;
								tutor_course_loop_end();

							else :
								tutor_load_template('course-none');
							endif;
						}
					?>
					<?php the_posts_pagination(); ?>
				</main>
			</div> <!--#primary-->
		</div> <!--.container-->
	</div> <!--.site-content-->
<?php get_footer();

