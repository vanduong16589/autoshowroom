jQuery(function ($) {
	jQuery(window).load(function () {
		$(document).find('body').addClass('loaded');
		//if (jQuery('.parallax').length) {
		$('.heading-parallax').each(function () {
			$(this).parallax("50%", 0.1);
		});
		//}
	});

	$('a.page-scroll').bind('click', function (event) {
		var $anchor = $(this);
		$('html, body').stop().animate({
			scrollTop: $($anchor.attr('href')).offset().top
		}, 1000, 'easeInOutExpo');
		event.preventDefault();
	});
});