/**
 * @file
 * Peek Interactions
 */
jQuery(function($){
	
	// Drawer toggle
	$('a.drawer-link').click(function(){
		$('#control').toggleClass('open');
		return false;
	});

	// Calculate some stuff
	var $header = $('#site-header');
	var contentTop = $('#content-body').offset().top;
	// window.navDocked = false;

	// Set pageTop variable for other functions to use
	window.pageTop = $(document).scrollTop();
	$(window).scroll(function(){
		window.pageTop = $(document).scrollTop();
		
		if (window.pageTop >= contentTop) {
			$header.addClass('whited');
		} else {
			$header.removeClass('whited');
		}
	});
	
	// run the script for adding behavior to the galleries
	peek_gallery_script();
});

function peek_gallery_script() {
	
	jQuery('.photo-item').each(function(){
		var $me = jQuery(this);
		$me.addClass('loading');
		$me.find('img').one("load", function() {
			$me.removeClass('loading');
		}).each(function() {
			if(this.complete) jQuery(this).load();
		});
	});
	
	// if elements should be packed, do it.
	if (jQuery('.packed').length) {
		jQuery(window).load(function(){
			var $photoGrid = jQuery('#photo-grid');

			$photoGrid.packery({
				itemSelector: '.photo-item',
				gutter: 0
			});
		});
	}
	
	// if flexslider elements, activate them
	if (jQuery('.flexslider').length) {
		jQuery('.flexslider').flexslider({
			animation: "fade",
			controlNav: false,
			slideshow: false,
			start: function(slider) {
				peek_flexslider_add_nav_current(slider);
				peek_flexslider_update_pager(slider);
			},
			before: function(slider) {
				peek_flexslider_update_pager(slider);
			},
			// smoothHeight: true
		});
	}
}

// Supporting functions
function peek_flexslider_add_nav_current(slider) {
	slider.find('.flex-direction-nav').append('<li class="flex-nav-current" />');
}
function peek_flexslider_update_pager(slider) {
	var output = '(' + (slider.animatingTo+1) + '/' + slider.count + ')';
	slider.find('.flex-nav-current').html(output);
}