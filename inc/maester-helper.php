<?php

/**
 * @param string $taxonomy
 * @return array
 * Category List Funtion
 */
function maester_lite_category_list($taxonomy = 'category'){
    $terms = get_terms($taxonomy);
    $term_array = array();
    foreach ($terms as $term){
        $term_array[$term->slug] = $term->name;
    }
    return $term_array;
}

/**
 * Get Post Types for header search
 * @param $post_type
 * @return string
 */
function maester_lite_get_search_category_slug_by_post_type($post_type = 'post'){
    if(function_exists('tutor') && tutor()->course_post_type == $post_type){
        return 'course-category';
    }elseif(function_exists('WC') && 'product' == $post_type){
        return 'product_cat';
    }elseif('post' == $post_type){
        return 'category';
    }else{
        return false;
    }
}

/**
 * custom pagination
 */

function maester_lite_pagination(){
    ?>
    <div class="maester-pagination-wrap">
        <?php
        global $wp_query;
        $big = 999999999; // need an unlikely integer
	    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages
        ) );
        ?>
    </div>
    <?php
}
