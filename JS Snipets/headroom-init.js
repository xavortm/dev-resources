 /**
  * It will add .opened class to the WordPress default dropdown menu.
  * This snipped works whitout jQuery defined.
  *
  * @version 0.7.0
  * @see http://codepen.io/WickyNilliams/pen/AFsKB
  * @CDN //cdnjs.cloudflare.com/ajax/libs/headroom/0.7.0/headroom.min.js
  */

// Scroll up-down header
var myElement = document.querySelector(".site-header");

// construct an instance of Headroom, passing the element
var headroom  = new Headroom(myElement, {
	offset : headerHeight,
	onUnpin : function() {

		// Hide all opened sub-menus.
		$('.menu-item-has-children').siblings().removeClass('opened');

		// Hide the opened menu after scrolling down.
		$('.top-bar').removeClass('expanded');
	}
});

// initialise
headroom.init();