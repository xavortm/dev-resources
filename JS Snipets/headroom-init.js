// It will add .opened class to the WordPress default dropdown menu.

// Scroll up-down header
var myElement = document.querySelector(".site-header");
// construct an instance of Headroom, passing the element
var headroom  = new Headroom(myElement, {
	offset : headerHeight,
	onUnpin : function() {
		$('.menu-item-has-children').siblings().removeClass('opened');
	}
});
// initialise
headroom.init();