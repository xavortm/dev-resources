/*
|--------------------------------------------------------------------------
| Developer mode
|--------------------------------------------------------------------------
|
| Set to true - it will allow printing in the console. Alsways check for this
| variables when running tests so you dont forget about certain console.logs.
| Id needed for development testing this variable should be used.
|
*/
var devMode = function() {
	return ! true;
};

// Disable console.log for production site.
if( devMode() ) {
	console.log = function() {}
}

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
		bodyElement: $("body")
	};

	 /**
	  * Example function. You can write jQuery code here.
	  * @return {[type]} [description]
	  */
	var _runConsoleLog = function ( event ) {

		// This will print only if devMode == true
		console.log("test");
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
		_s.bodyElement.on( 'click', _runConsoleLog );
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