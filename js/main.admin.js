(function ($) {
	'use strict';

	jQuery(document).ready(function() {
		jqueryPlugins();
	});

	/**
	 * Active All jQuery Plugins - Since: 1.0.0
	 */
	function jqueryPlugins() {
		if($.fn.wpColorPicker()){
			$('.maester_toolkit_colorpicker').wpColorPicker();
		}
	}



})(jQuery);

