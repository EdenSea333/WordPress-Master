(function ($) {
    'use strict';

    jQuery(document).ready(function() {
        jqueryPlugins();
        maesterTabs();
        openSearchPopup();
        mobileMenu();
        mobileMenuToggle();
        generalScripts();
    });

    jQuery(window).on('resize', mobileMenu);

    /**
     * Responsive mobile menu - Since: 1.0.0
     */
    function mobileMenu() {
        var windowWidth = $( window ).width();
        if(windowWidth < 767){
            var $subMenuBtn = $('.menu-item-has-children > a');
            $subMenuBtn.off('click').on('click', function (e) {
                var $that = $(this);
                if(!$that.hasClass('open')){
                    e.preventDefault();
                }
                $that.siblings('ul').find('ul').slideUp(0);
                $that.siblings('ul').slideToggle();
                $that.toggleClass('open');
            });
        }

    }

    /**
     * Mobile Menu Toggle
     */
    function mobileMenuToggle(){
        $('.menu-toggle').on('click', function () {
            var menuId = $(this).attr('aria-controls');
            $('#'+menuId+'>nav>ul').slideToggle();
        });

    }

    function openSearchPopup(){
        var $searchForm = $('#maester-popup-search-form');
        $('a[href="#open_search_popup"]').on('click', function(e) {
            e.preventDefault();
            $searchForm.fadeIn();
        });

        $('.maester-popup-search-overlay').on('click', function () {
            $searchForm.fadeOut();
        });


        $(document).keyup(function(e) {
            if (e.key === "Escape") {
                $('#maester-popup-search-form').fadeOut();
            }
        });
    }

    /**
     * Custom Tabs - Since 1.0.0
     */

    function maesterTabs() {
        $('.maester-tabs').each(function () {
            var $that = $(this);
            var $tab_link = $that.find('.tab-link');
            var $tab_content = $that.find('.tab-content');
            $tab_link.on('click', function (e) {
                e.preventDefault();
                $tab_link.add($tab_content).removeClass('active');
                $that.find(".tab-link[data-tab='"+ $(this).data('tab') +"']").add($that.find('.' + $(this).data('tab'))).addClass('active');
            });
        });
    }

    /**
     * Active All jQuery Plugins - Since: 1.0.0
     */
    function jqueryPlugins() {
        if($.fn.select2()){
            $('select').select2();
        }
    }

    /**
     * General Scripts - Since 1.0.4
     */
    function  generalScripts() {
        $(document).on('click', 'a.maester-notice-dismiss', function (e) {
            e.preventDefault();
            $(this).closest('.maester-site-notice').fadeOut(100);
        });

    }



})(jQuery);

