
(function($) {

	/*
	$('.navbar-toggle.collapsed').click(function(event){
	  $('.collapse.navbar-collapse.navbar-right').toggleClass('in');
	});

	$( window ).resize(function() {
		$('.collapse.navbar-collapse.navbar-right').removeClass('in');
	}); */


	var screenxs = 782; //767
	var navbarfixed = $("header.navbar").hasClass('navbar-fixed-top') ? true : false;

	if (window.innerWidth <= screenxs) {
	  if ( $("header.navbar").hasClass('navbar-fixed-top') ) $("header.navbar").removeClass("navbar-fixed-top").addClass("navbar-static-top");
	} else {
	  if (navbarfixed) $("header.navbar").removeClass("navbar-static-top").addClass("navbar-fixed-top");
	}

	$(window).resize(function() {
	  if (window.innerWidth <= screenxs) {
	    if ( $("header.navbar").hasClass('navbar-fixed-top') ) $("header.navbar").removeClass("navbar-fixed-top").addClass("navbar-static-top");
	  } else {
	    if (navbarfixed) $("header.navbar").removeClass("navbar-static-top").addClass("navbar-fixed-top");
	  }
	});

})(jQuery);