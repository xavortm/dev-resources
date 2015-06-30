jQuery( document ).ready( function ( $ ) {
	'use strict';

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
		return true;
	};

	/**
	 * Run alert only if devMode is on. This is only for testing purposes, if the
	 * alert is needed use the normal alert().
	 */
	var devAlert = function( string ) {
		if ( devMode() ) {
			alert( devMode() );
		}
	}

	// Disable console.log for production site.
	if ( ! devMode() ) {
		console.log = function() {}
	}


	/**
	 * Those will be events like clicking, dragging, scrolling or whatever
	 * that will change afer certain user interaction with the site. Default
	 * changes that are happening whitout the controll of the user should be
	 * in another object. Keep the WordPress coding guidelines for javascript.
	 */
	var siteScripts = (function () {

		/**
		 * Settings. Its ok to use jquery selectors in the functions and not
		 * set them here, but if they are used in more then one function and
		 * can be used as setting (like fixed element height) better to  set
		 * it here.
		 */
		var _s = {
			menuIcon: $( ".menu-icon" ),
			dropdownArrow: $( "span.dropdown-arrow" ),
			menuNav: $('nav.menu-nav'),

			wavesButtonSelector: '.button'
		};

		 /**
		  * Example function. You can write jQuery code here.
		  * @return {[type]} [description]
		  */
		var _openMenu = function ( event ) {
			var headerHeight = 84;
			var adminbarHeight = 50;

			// Change button state
			$( this ).toggleClass( 'opened' );

			// Open the main menu.
			_s.menuNav.toggleClass( 'extended' ).removeClass('init');
			_s.menuNav.height( $(window).height() - headerHeight - adminbarHeight );

			$('body').toggleClass( 'menu-opened' );
		};

		var openDropdownMenu = function ( event ) {
			$(this).toggleClass( "extended" );
		}

		/**
		 * Create the toggles in homepage featured boxes.
		 */
		var featureBoxToggle = function( event ) {
			var isExtended = false;

			if ( $(this).parent().hasClass( 'extended' ) ) {
				var isExtended = true;
			}

			$( 'div.feature-box.extended' ).each(function() {
				$(this).removeClass( 'extended' );
			});

			if ( isExtended ) {
				$(this).parent().removeClass( 'extended' );
			} else {
				$(this).parent().addClass( 'extended' );
			}
		}

		var sidebarToggle = function() {
			$('aside.panel-secondary').toggleClass('extended');
			$('section.section--blog-layout').toggleClass('extended');
			$('div.sidebar-scroll-wrap').toggleClass('sidebar-opened');
		}

		/**
		 * Fire all functions that will be used in the page.
		 */
		var events = function () {

			// When header is clicked.
			_s.menuIcon.on( 'click', _openMenu );

			// Dropdown menu links
			$('li.menu-item-has-children').on( 'click', _s.dropdownArrow, openDropdownMenu );

			// Mobile only, it will add class to togle the content info.
			$('header.feature-box__heading').on( 'click', featureBoxToggle );

			// Toggle sidebar for mobile and tablet
			$('span.sidebar-icon').on( 'click', sidebarToggle );
		};

		var setHeaderHeight = function () {

			// This will fix the problem where the height is taken before the css is applied. (10ms for now)
			var renderDelayTimer = 5;
			setTimeout(function(){

				// 11 is the top green bar.
				$('div.site-header-height').height( $('.site-header').height() + 11 );

			}, renderDelayTimer);

			// The header size in console:
			console.log("Curent header height: " + $('.site-header').outerHeight());
		}

		var dropdownMenu = function () {
			$('.menu-item-has-children').each(function() {
				$(this).append("<span class='dropdown-arrow'><i class='fa fa-angle-right'></i></span>")
			});
		}

		var localhostCheck = function() {
			if (document.location.hostname == "localhost" || document.location.hostname == "127.0.0.1") {
				$("#wpadminbar").addClass("localhost");
			}
		}

		var parallaxScroll = function() {

			// 1. Make an array that can hold the parallax image objects
			var parallaxImages = [];
			var scrollPX = 0;

			if( $('section.parallax-bg').length != 0 ) {

				$('section.parallax-bg').each(function(index) {

					// 2. Inside the the loop make a new object to hold each image
					var parallaxImage = {};

					// 3. Save the information that you need from the image to that object
					parallaxImage.element = $(this);
					parallaxImage.height = parallaxImage.element.height();

					// 4. At the end of the loop push the object to the `parallaxImages` array
					parallaxImages.push(parallaxImage);

				});

				$(window).on('scroll', function() {
					console.log( "Scroll watch active!" );

					// 5. Inside the event handler we loop each cached image object from the array
					$.each(parallaxImages, function( index, parallaxImage ) {
						window.requestAnimationFrame( scrollHandler );
					});
				});

				var scrollHandler = function() {
					var el =  parallaxImages[0].element;
					var scrollHeight = 'center ' + $(window).scrollTop() / 3 + 'px';
					el.css( 'background-position', scrollHeight );
				}
			}

		}

		var init = function () {
			dropdownMenu();

			// setHeaderHeight(); // Will disable this for now.
			localhostCheck();

			// Parallax scrolling (yeah, because performance FTW) - need more testing, will leave
			// it commented out for the moment.
			parallaxScroll();
		}

		/**
		 * Call the events.
		 * -> siteScripts.watch();
		 */
		return {
			watchEvents: events,
			init: init
		};

	})();

	siteScripts.watchEvents(); // Begin watching for events.
	siteScripts.init();

	/**
	 * Initialising other plugins and setup them.
	 * ========================================================================
	 */

	Waves.init();
	Waves.attach('.button', ['waves-button', 'waves-float']);
	Waves.attach('.waves', ['waves-button', 'waves-float']);
	Waves.attach('.button.circle', ['waves-button', 'waves-float', 'waves-circle']);
	Waves.attach('.thumbnail-img', ['waves-button', 'waves-float']);

	// Smooth scroll init.
	$( 'a[href*=#]:not([href=#])' ).on( 'click', function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html,body').animate({
				scrollTop: target.offset().top
			}, 500);
				return false;
			}
		}
	} );

	// Headroom.js initialization
	var myElement = document.querySelector( "header.site-header" );
	var headroom  = new Headroom(myElement, {
		offset: 100,
		tolerance : 5
	});
	headroom.init();

	// Reading time.
	if ( $('body.single').length != 0 ) {
		var $article = $('div.entry-content');

		// Load only on single page, otherways there will be JS error for sure.
		$article.readingTime({
			readingTimeTarget: $('span.meta-length span')
		});
	}

});