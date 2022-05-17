/* plyr.setup('.js-media-player'); */

plyr.setup('.js-media-player', {
	showPosterOnEnd: true
});

instance = document.querySelector('.js-media-player');

instance.addEventListener('play', function(event) {
    $('.plyr__controls').css({"display":"flex"});
});

instance.addEventListener('ended', function(event) {
    window.location.reload();
});

/*
// background player setup
plyr.setup('.js-media-player', {
	controls: [],
	autoplay: true
});

 */