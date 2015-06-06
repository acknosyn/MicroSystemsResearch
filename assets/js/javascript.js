var menu = function() {

	$('.menu-icon').click(function() {
		if($('.menu').hasClass('collapsed')) {
			$('.menu').removeClass('collapsed');
			expand();
		}
		else {
			$('.menu').addClass('collapsed');
			collapse();
		}
	});

	var ease = 200;

	function expand() {
		var dist = "365px"; // 365px == width of menu

		$('.menu').animate({left: "0px"}, ease);

		$('body').animate({left: dist}, ease);

		$('.menu-icon').animate({left: dist}, ease);
	}

	function collapse() {
		var dist = "0px";

		$('.menu').animate({left: "-365px"}, ease);

		$('body').animate({left: dist}, ease);

		$('.menu-icon').animate({left: dist}, ease);
	}
}

var scroll = function() {

	var dist = 200; // distance scrolled until full opacity
	var ease = 800; // scroll animation

	$(window).scroll(function() {
		var scrollVar = $(window).scrollTop();
    	$('.scroll-to-top').css({'opacity': scrollVar / dist});
	});

	$('.scroll-to-top').click(function() {
		$('html, body').animate({scrollTop: 0}, ease);
		return false;
	});
}

$(document).ready(menu);
$(document).ready(scroll);