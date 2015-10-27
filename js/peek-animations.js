/**
 * @file
 * Peek Animations
 */

var globalDelay = 250; // 100 miliseconds between elements.

jQuery(function($){
	$('.animate').each(function(index){
		var $el = $(this);
		delay = index*globalDelay;
		setTimeout(function(){
			$el.addClass('done');
		}, delay);
	});
	$('.ripple, .button, button').click(function(e){
		// append the wave markup if it's not already there
		if ($(this).find('.wave').length == 0) {
			$(this).append('<span class="wave"></span>');
		}
		// set a shortcut pointer to the wave element
		$wave = $(this).find('.wave');
		// remove the 'activate' class in case it has already been clicked
		$wave.removeClass('activate');
		// set size of wave
		if (!$wave.width() || !$wave.height()) {
			size = Math.max($(this).outerWidth(), $(this).outerHeight());
			$wave.css({width: size, height: size});
		}
		// get click coords
		x = e.pageX - $(this).offset().left - $wave.width()/2;
		y = e.pageY - $(this).offset().top - $wave.height()/2;
		// set the click coords
		$wave.css({left: x+'px', top: y+'px'}).addClass('activate');
	});
});
