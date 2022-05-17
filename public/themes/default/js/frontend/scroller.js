$(document).ready(function() {

// setup parralax for home
if (document.getElementById("intro") !== null) {

	var controllerBottom = new ScrollMagic.Controller();
	var introTl = new TimelineMax();
	introTl
	    .to($('#intro .bottom'), 0.5, {autoAlpha: 0, ease:Power0.easeNone}, '-=1.5');

	var introScene = new ScrollMagic.Scene({
	    // triggerElement: '.slide01',
	    triggerHook: 3,
	    duration: "100%"
	})
	.setTween(introTl)
	.addTo(controllerBottom);

		var controllerSlide = new ScrollMagic.Controller();

		var introTl = new TimelineMax();
		introTl
		    .to($('#intro .homeSlide.active .slide-img'), 2, {y: '400px', ease:Power0.easeNone})
		    .to($('#intro .homeSlide.active .divider'), 0.5, {autoAlpha: 0, ease:Power1.easeInOut}, '-=1');

		var introScene = new ScrollMagic.Scene({
		    // triggerElement: '.slide01',
		    triggerHook: 3,
		    duration: "100%"
		})
		.setTween(introTl)
		.addTo(controllerSlide);
		/* */
	
		/* 	// add to after 'setTween' to track scroll
			// .addIndicators({
			// 	name: 'fade scene',
			// 	colorTrigger: 'black',
			// 	colorStart: '#75C695',
			// 	colorEnd: 'pink'
			// })
		*/

		 function updateParralax() {
		 	var introTl = new TimelineMax();
		 	introTl
		 	    .to($('#intro .homeSlide.active .slide-img'), 2, {y: '400px', ease:Power0.easeNone})
		 	    .to($('#intro .homeSlide.active .divider'), 0.5, {autoAlpha: 0, ease:Power1.easeInOut}, '-=1');
		 	introScene.setTween(introTl);
		 }
		 
		 /* // Update the mains_home functions */

		 // update slide nav
		 var $slideNavNext = $(".slideNavNext"),
		 	$slideNavPrev = $(".slideNavPrev");

		 $slideNavNext.click(function (e) {

		   	updateParralax();

		 });

		 $slideNavPrev.click(function (e) {

		   	updateParralax();

		 });

		 // /*    */

}

// Setup slider
	
	var sliderController = new ScrollMagic.Controller();

	$('.slide').each(function(){
		
		var scene = new ScrollMagic.Scene({
			triggerElement: this.children[1],
			triggerHook: 0.9
		})
		.setClassToggle(this, 'fade-in')
		// .addIndicators({
		// 	name: 'fade scene',
		// 	colorTrigger: 'black',
		// 	colorStart: '#75C695',
		// 	colorEnd: 'pink'
		// })
		.addTo(sliderController);

	});

	// change behaviour of sliderController to animate scroll instead of jump
	sliderController.scrollTo(function (newpos) {
	    TweenMax.to(window, 1, {scrollTo: {y: newpos, offsetY: 90}, ease:Power1.easeInOut});
	});

	//  bind scroll to anchor links
	$(document).on("click", "a[href^='#']", function (e) {
	    var id = $(this).attr("href");
	    if ($(id).length > 0) {
	        e.preventDefault();
	 
	        // trigger scroll
	        sliderController.scrollTo(id);
	 
	        // if supported by the browser we can even update the URL.
	        if (window.history && window.history.pushState) {
	            history.pushState("", document.title, id);
	        }
	    }
	});


});

