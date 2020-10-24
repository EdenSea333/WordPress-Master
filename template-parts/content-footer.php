<?php
/**
 * Template part for displaying page content in footer.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maester
 */

    $maester_lite_footerWidgets = array('footer-1', 'footer-2', 'footer-3', 'footer-4');
    $maester_lite_isFooter1 = is_active_sidebar('footer-1');
    $maester_lite_isFooter2 = is_active_sidebar('footer-2');
    $maester_lite_isFooter3 = is_active_sidebar('footer-3');
    $maester_lite_isFooter4 = is_active_sidebar('footer-4');
    $maester_lite_hasFooterWidget = $maester_lite_isFooter1 || $maester_lite_isFooter2 || $maester_lite_isFooter3 || $maester_lite_isFooter4;

    $maester_lite_enable_footer = get_theme_mod('enable_footer', true);
    $maester_lite_enable_footer_bottom = get_theme_mod('enable_footer_bottom', true);

?>

<?php if($maester_lite_enable_footer && $maester_lite_hasFooterWidget) : ?>

<div class="footer-widget-area">
    <div class="container">
        <div class='row'>
            <?php
                foreach ($maester_lite_footerWidgets as $maester_lite_widget){
                    if(!is_active_sidebar($maester_lite_widget)) continue;
                    echo "<div class='col-12 col-sm-6 col-md'>";
                        dynamic_sidebar($maester_lite_widget);
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>

<?php endif; ?>

<?php
    $maester_lite_footer_text = get_theme_mod('footer_text', sprintf("&copy; %s %s. ", date('Y') , get_bloginfo('name')) );
	$maester_lite_footer_credit = get_theme_mod('footer_credit', "credit_1");
	$maester_lite_copyright_credit = maester_lite_get_copyright_credits();
    if((!empty($maester_lite_footer_text) || !empty($maester_lite_footer_credit) || has_nav_menu('menu-3')) && $maester_lite_enable_footer_bottom) :
?>

<div class="footer-main">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md">
                <div class="site-info">
                    <p>
                        <?php

                            if($maester_lite_footer_text){
                                echo esc_html($maester_lite_footer_text). " ";
                            }

                            if('none' != $maester_lite_footer_credit){
	                            echo wp_kses(
	                            	$maester_lite_copyright_credit[$maester_lite_footer_credit],
		                            array(
			                            'a' => array(
				                            'href'   => array(),
				                            'title'  => array(),
				                            'target' => array(),
				                            'rel' => array()
			                            )
		                            )
	                            );
                            }

                        ?>
                    </p>
                </div><!-- .site-info -->
            </div>
            <div class="col-12 col-md-auto footer-menu-column">
                <?php
                    if(has_nav_menu('menu-3')){
                        wp_nav_menu(array(
                            'theme_location' => 'menu-3',
                            'menu_id'        => 'footer-menu',
                        ));
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>
