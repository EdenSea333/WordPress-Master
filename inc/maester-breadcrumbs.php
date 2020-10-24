<?php
/**
 * Breadcrumbs Functions
 */

function maester_lite_get_breadcrumb() {

    /* === OPTIONS === */

    $text['home']     = '<i class="fas fa-home"></i> '. __(' Home', 'maester-lite'); // text for the 'Home' link
	/* translators: %s: category name */
    $text['category'] =  __('Archive by Category "%s"', 'maester-lite') ;
	/* translators: %s: search term */
    $text['search']   = __('Search Results for "%s" Query', 'maester-lite');
	/* translators: %s: tag name */
    $text['tag']      = __('Posts Tagged "%s"', 'maester-lite');
	/* translators: %s: author name */
    $text['author']   = __('Articles Posted by %s', 'maester-lite');
    $text['404']      = __('Error 404', 'maester-lite'); // text for the 404 page
	/* translators: %s: page name */
    $text['page']     = __('Page %s', 'maester-lite'); // text 'Page N'
	/* translators: %s: comment page name */
    $text['cpage']    = __('Comment Page %s', 'maester-lite'); // text 'Comment Page N'
    $wrap_before    = '<div class="maester-breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; // the opening wrapper tag
    $wrap_after     = '</div><!-- .breadcrumbs -->'; // the closing wrapper tag
    $sep            = '<span class="breadcrumbs__separator"> &#8250; </span>'; // separator between crumbs
    $before         = '<span class="breadcrumbs__current">'; // tag before the current crumb
    $after          = '</span>'; // tag after the current crumb
    $show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
    $show_current   = 1; // 1 - show current page title, 0 - don't show
    $show_last_sep  = 1; // 1 - show last separator, when current page title is not displayed, 0 - don't show
    /* === END OF OPTIONS === */
    global $post;
    $home_url       = home_url('/');
    $link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
    $link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
    $link          .= '<meta itemprop="position" content="%3$s" />';
    $link          .= '</span>';
    $parent_id      = ( $post ) ? $post->post_parent : '';
    $home_link      = sprintf( $link, $home_url, $text['home'], 1 );
    $output = '';
    if ( is_home() || is_front_page() ) {
        if ( $show_on_home ) {
        	if(!is_front_page()){
		        $output .= $wrap_before . $home_link.$sep. __('Blog', 'maester-lite') . $wrap_after;
	        }else{
		        $output .= $wrap_before . $home_link . $wrap_after;
	        }
        }
    } else {
        $position = 0;
        $output .= $wrap_before;
        if ( $show_home_link ) {
            $position += 1;
            $output .= $home_link;
        }
        if ( is_category() ) {
            $parents = get_ancestors( get_query_var('cat'), 'category' );
            foreach ( array_reverse( $parents ) as $cat ) {
                $position += 1;
                if ( $position > 1 ) $output .= $sep;
                $output .= sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
            }
            if ( get_query_var( 'paged' ) ) {
                $position += 1;
                $cat = get_query_var('cat');
                $output .= $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
                $output .= $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
            } else {
                if ( $show_current ) {
                    if ( $position >= 1 ) $output .= $sep;
                    $output .= $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
                } elseif ( $show_last_sep ) $output .= $sep;
            }
        }
        elseif(is_tax(get_object_taxonomies( 'course-category' ))){
	        $parents = get_ancestors( get_query_var('cat'), 'course-category' );
	        foreach ( array_reverse( $parents ) as $cat ) {
		        $position += 1;
		        if ( $position > 1 ) $output .= $sep;
		        $output .= sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
	        }
	        if ( get_query_var( 'paged' ) ) {
		        $position += 1;
		        $cat = get_query_var('cat');
		        $output .= $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
		        $output .= $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
	        } else {
		        if ( $show_current ) {
			        if ( $position >= 1 ) $output .= $sep;
			        $output .= $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
		        } elseif ( $show_last_sep ) $output .= $sep;
	        }
        }
        elseif ( is_search() ) {
            if ( get_query_var( 'paged' ) ) {
                $position += 1;
                if ( $show_home_link ) $output .= $sep;
                $output .= sprintf( $link, $home_url . '?s=' . get_search_query(), sprintf( $text['search'], get_search_query() ), $position );
                $output .= $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
            } else {
                if ( $show_current ) {
                    if ( $position >= 1 ) $output .= $sep;
                    $output .= $before . sprintf( $text['search'], get_search_query() ) . $after;
                } elseif ( $show_last_sep ) $output .= $sep;
            }
        } elseif ( is_year() ) {
            if ( $show_home_link && $show_current ) $output .= $sep;
            if ( $show_current ) $output .= $before . get_the_time('Y') . $after;
            elseif ( $show_home_link && $show_last_sep ) $output .= $sep;
        } elseif ( is_month() ) {
            if ( $show_home_link ) $output .= $sep;
            $position += 1;
            $output .= sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position );
            if ( $show_current ) $output .= $sep . $before . get_the_time('F') . $after;
            elseif ( $show_last_sep ) $output .= $sep;
        } elseif ( is_day() ) {
            if ( $show_home_link ) $output .= $sep;
            $position += 1;
            $output .= sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position ) . $sep;
            $position += 1;
            $output .= sprintf( $link, get_month_link( get_the_time('Y'), get_the_time('m') ), get_the_time('F'), $position );
            if ( $show_current ) $output .= $sep . $before . get_the_time('d') . $after;
            elseif ( $show_last_sep ) $output .= $sep;
        } elseif ( is_single() && ! is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $position += 1;
                $post_type = get_post_type_object( get_post_type() );
                if ( $position > 1 ) $output .= $sep;
                $output .= sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->labels->name, $position );
                if ( $show_current ) $output .= $sep . $before . get_the_title() . $after;
                elseif ( $show_last_sep ) $output .= $sep;
            } else {
                $cat = get_the_category(); $catID = $cat[0]->cat_ID;
                $parents = get_ancestors( $catID, 'category' );
                $parents = array_reverse( $parents );
                $parents[] = $catID;
                foreach ( $parents as $cat ) {
                    $position += 1;
                    if ( $position > 1 ) $output .= $sep;
                    $output .= sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
                }
                if ( get_query_var( 'cpage' ) ) {
                    $position += 1;
                    $output .= $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
                    $output .= $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
                } else {
                    if ( $show_current ) $output .= $sep . $before . get_the_title() . $after;
                    elseif ( $show_last_sep ) $output .= $sep;
                }
            }
        } elseif ( is_post_type_archive() ) {
            $post_type = get_post_type_object( get_post_type() );
            if ( get_query_var( 'paged' ) ) {
                $position += 1;
                if ( $position > 1 ) $output .= $sep;
                $output .= sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label, $position );
                $output .= $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
            } else {
                if ( $show_home_link && $show_current ) $output .= $sep;
                if ( $show_current ) $output .= $before . $post_type->label . $after;
                elseif ( $show_home_link && $show_last_sep ) $output .= $sep;
            }
        } elseif ( is_attachment() ) {
            $parent = get_post( $parent_id );
            $cat = get_the_category( $parent->ID ); $catID = $cat[0]->cat_ID;
            $parents = get_ancestors( $catID, 'category' );
            $parents = array_reverse( $parents );
            $parents[] = $catID;
            foreach ( $parents as $cat ) {
                $position += 1;
                if ( $position > 1 ) $output .= $sep;
                $output .= sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
            }
            $position += 1;
            $output .= $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
            if ( $show_current ) $output .= $sep . $before . get_the_title() . $after;
            elseif ( $show_last_sep ) $output .= $sep;
        } elseif ( is_page() && ! $parent_id ) {
            if ( $show_home_link && $show_current ) $output .= $sep;
            if ( $show_current ) $output .= $before . get_the_title() . $after;
            elseif ( $show_home_link && $show_last_sep ) $output .= $sep;
        } elseif ( is_page() && $parent_id ) {
            $parents = get_post_ancestors( get_the_ID() );
            foreach ( array_reverse( $parents ) as $pageID ) {
                $position += 1;
                if ( $position > 1 ) $output .= $sep;
                $output .= sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
            }
            if ( $show_current ) $output .= $sep . $before . get_the_title() . $after;
            elseif ( $show_last_sep ) $output .= $sep;
        } elseif ( is_tag() ) {
            if ( get_query_var( 'paged' ) ) {
                $position += 1;
                $tagID = get_query_var( 'tag_id' );
                $output .= $sep . sprintf( $link, get_tag_link( $tagID ), single_tag_title( '', false ), $position );
                $output .= $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
            } else {
                if ( $show_home_link && $show_current ) $output .= $sep;
                if ( $show_current ) $output .= $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
                elseif ( $show_home_link && $show_last_sep ) $output .= $sep;
            }
        } elseif ( is_author() ) {
            $author = get_userdata( get_query_var( 'author' ) );
            if ( get_query_var( 'paged' ) ) {
                $position += 1;
                $output .= $sep . sprintf( $link, get_author_posts_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
                $output .= $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
            } else {
                if ( $show_home_link && $show_current ) $output .= $sep;
                if ( $show_current ) $output .= $before . sprintf( $text['author'], $author->display_name ) . $after;
                elseif ( $show_home_link && $show_last_sep ) $output .= $sep;
            }
        } elseif ( is_404() ) {
            if ( $show_home_link && $show_current ) $output .= $sep;
            if ( $show_current ) $output .= $before . $text['404'] . $after;
            elseif ( $show_last_sep ) $output .= $sep;
        } elseif ( has_post_format() && ! is_singular() ) {
            if ( $show_home_link && $show_current ) $output .= $sep;
            $output .= get_post_format_string( get_post_format() );
        }
        $output .= $wrap_after;
    }
    return $output;
}
