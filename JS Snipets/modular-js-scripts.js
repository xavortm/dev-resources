jQuery(document).ready(function( $ ) {

	var siteEvents = (function () {

		/**
		 * Settings. Its ok to use jquery selectors in the functions and not
		 * set them here, but if they are used in more then one function and
		 * can be used as setting (like fixed element height) better to  set
		 * it here.
		 * @type {Object}
		 */
		var _s = {

			// Example jquery variable
			siteHeader: $(".site-header")
		};

		/**
		 * Begin custom functions
		 * --------------------------------------------------------------------
		 */

		 /**
		  * Example function. You can write jQuery code here.
		  * @return {[type]} [description]
		  */
		var _stickyHeader = function () {
			_s.siteHeader.addClass("sticky");
		};

		/**
		 * End custom functions
		 * --------------------------------------------------------------------
		 */

		/**
		 * Fire all functions that will be used in the page.
		 * @return {[type]} [description]
		 */
		var _init = function () {
			_stickyHeader();
		};

		/**
		 * Call the events.
		 * -> siteEvents.init();
		 */
		return {
			init: _init,
		};

	})();

	// Start everything
	siteEvents.init();

});