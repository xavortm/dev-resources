/*
|--------------------------------------------------------------------------
| Site Events Controlls.
|--------------------------------------------------------------------------
|
| Those will be events like clicking, dragging, scrolling or whatever
| that will change afer certain user interaction with the site. Default
| changes that are happening whitout the controll of the user should be
| in another object. Keep the WordPress coding guidelines for javascript.
|
*/
var siteEvents = (function () {
	'use strict';

	/*
	|--------------------------------------------------------------------------
	| Theme Settings
	|--------------------------------------------------------------------------
	|
	| Settings. Its ok to use jquery selectors in the functions and not
	| set them here, but if they are used in more then one function and
	| can be used as setting (like fixed element height) better to  set
	| it here.
	|
	*/
	var _s = {
		siteHeader: $( ".site-header" ) 		// Example jquery variable
	};

	 /**
	  * Example function. You can write jQuery code here.
	  * @return {[type]} [description]
	  */
	var _printConsole = function ( event ) {
		var el = $(event.target);
		console.log(el);
	};

	/*
	|--------------------------------------------------------------------------
	| Run the functions
	|--------------------------------------------------------------------------
	|
	| Fire all functions that will be used in the page.
	|
	*/
	var events = function () {

		// When header is clicked.
		_s.siteHeader.on( 'click', _printConsole );
	};

	/**
	 * Call the events.
	 * -> siteEvents.init();
	 */
	return {
		watch: events,
	};

})();


jQuery(document).ready(function( $ ) {

	// Begin watching for events.
	siteEvents.watch();

});