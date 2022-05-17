
(function($) {

	$("#contactForm").validator().on("submit", function (event) {
	    if (event.isDefaultPrevented()) {
	        formError();
	        submitMSG(false, $('#contactForm').data('properly'));
	    } else {
	        formSuccess();
	    }
	});

	function formSuccess(){
	    submitMSG(true, $('#contactForm').data('submitted'))
	}

	function formError(){
	    $("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
	        $(this).removeClass();
	    });
	}

	function submitMSG(valid, msg){
	    if(valid){
	        var msgClasses = "h5 text-center tada animated text-success";
	    } else {
	        var msgClasses = "h5 text-center text-warning";
	    }
	    $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
	}
	
})(jQuery);
