
(function($) {

	  $('.tooltip-post').tooltip();

	  $("#menu-close").click(function(e) {

	    e.preventDefault();
	    $("#sidebar-wrapper").toggleClass("active");
	    $(".bottom").toggleClass("rightbar");
	    $(".top").toggleClass("rightbar");
	    $("#shortnav").toggleClass("rightbar");
	    $(".container").toggleClass("rightbar");
	    $("header").toggleClass("rightbar");
	    $(".message").toggleClass("rightbar");

	  });

	  $("#menu-toggle").click(function(e) {
	    e.preventDefault();
	    // $('.close').click();
	    $("#sidebar-wrapper").toggleClass("active");
	    $(".bottom").toggleClass("rightbar");
	    $(".top").toggleClass("rightbar");
	    $("#shortnav").toggleClass("rightbar");
	    $(".container").toggleClass("rightbar");
	    $("header").toggleClass("rightbar");
	    $(".message").toggleClass("rightbar");
	  });

})(jQuery);