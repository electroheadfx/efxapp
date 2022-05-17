
$(window).load(function(){

  /* both gallery and video variables setup */

  var resizeId;
  var $container = $('#articles');

  // var thumbaction = false;


  // var filterValue = '*';
  filterValue = getHashParams(location.hash).c == undefined ? '*' : getHashParams(location.hash).c;
  var active_imglow;
  var active_target;
  var active_targetplayer;
  var height;
  var width;
  var target;
  var active_article = false;
  var $el_active_article;
  /* efx change */
  var base_grid = "col-xs-6 col-sm-6 ";
  var layout;
  // grid_full obsolet
  var grid_full = "col-xs-12 col-sm-12 ";

  var grid_thumb; // "col-xs-6 col-sm-6 col-md-4 col-lg-3"
  var page = $("html, body");
  var $carousel;
  var carouselratio;
  var current_el;
  var propagation_css;
  var propagation_iteration = 0;
  var scrolltofavories  = $('.navbar-nav .menu.active').data('scrollto') == "active" ? true : false;
  var scrollpausetime   = $('.navbar-nav .menu.active').data('scrollpausetime');
  var mediaautoclose    = $('.navbar-nav .menu.active').data('mediaautoclose');
  var scrolltofeatured  = ','+$('.navbar-nav .menu.active').data('scrolltofeatured');

  var scrollto = false;
  var featured = [];

  var favoriesopened = false;

  filter = $('.filters a.active').data('filter');

  active = "active";
  pending = "pending";

  /* video variables setup */

    /* for plyr 3.5, change players to global object */
    var players = {};

    var videoID;
    var oldvideoID;
    var bgsidervideo = document.getElementById("sider-video-background"); 
    var bgvideo = document.getElementById("video-background");
    var vimeovideo = false;

    if (!bgvideo) {
      var iframe = document.getElementById('vimeo-video-background');
      if (iframe) {
        vimeovideo = $f(iframe);
      }
    }

  /* */

  /* sketchfab global variables setup */

  var model,
      version,
      sketch,
      client,
      error,
      success;
  var api = {};

  /* */

  /*            */
  /* functions */
  /*          */

    $.fn.scrollView = function () {
      return this.each(function () {
        $('html, body').animate({
          scrollTop: $(this).offset().top
        }, 1000);
      });
    }

    var postFunctions = {
          close_gallery: close_gallery,
          close_video: close_video,
          close_sketchfab: close_sketchfab
    };

    function getHashParams(aURL) {

      aURL = aURL || window.location.href;
      
      var vars = {};
      var hashes = aURL.slice(aURL.indexOf('#') + 1).split('&');

        for(var i = 0; i < hashes.length; i++) {
           var hash = hashes[i].split('=');
          
           if(hash.length > 1) {
             vars[hash[0]] = hash[1];
           } else {
            vars[hash[0]] = null;
           }      
        }

        return vars;
    }

    function hashtagToURI(post, featured) {
      if (!featured && product_cms === undefined) {
        var hash_params = getHashParams(location.hash);
        if ( hash_params.c == undefined ) {
            location.hash = 'p=' + encodeURIComponent( post.data('slug') );
        } else {
            location.hash = 'p=' + encodeURIComponent( post.data('slug') ) + '&c='+hash_params.c;
        }
      }
    }

    function getHashFilter(filt) {
      var hash = location.hash;
      // get filter=filterName
      if (filt == 'c')
        var matches = location.hash.match( /c=([^&]+)/i );
      else
        var matches = location.hash.match( /p=([^&]+)/i );

      var hashFilter = matches && matches[1];
      return hashFilter && decodeURIComponent( hashFilter );
    }


  /*                      */
  /* <-- end functions   */
  /*                    */

/* <!-- add $filters to click menu and place function after hash change code */

  $filters = $('.filters .button-category a').on("click touchstart", function(event) {
  // $filters = $('.filters .button-category a').click(function(event){

      event.preventDefault();

      $('.collapse.navbar-collapse.navbar-right').removeClass('in');

      $('.filters a.active').removeClass('active');
      $(this).addClass('active');

      filterValue = $(this).data('filter');

      var hash_params = getHashParams(location.hash);

      if ( hash_params.p ) {

          location.hash = 'c=' + hash_params.c+'&';
          location.hash = 'p=' + hash_params.p + '&c=' + encodeURIComponent( filterValue );

      } else {
        
          location.hash = 'c=' + encodeURIComponent( filterValue );
      }

      $container.isotope({ filter: filterValue });

      return false;

    });

  /* <--- filters button */

// add sorts_control actived by menu
if ( $( '#frontend-control' ).length ) {

    function sorteddesc() {
      $('#frontend-control .btn.active').removeClass('active');
      $('#desc').addClass('active');
      $container.isotope({ filter: filterValue, sortBy: 'original-order', sortAscending: true });
    }

    function sortedasc() {
      $('#frontend-control .btn.active').removeClass('active');
      $('#asc').addClass('active');
      $container.isotope({ filter: filterValue, sortBy: 'original-order', sortAscending: false });
    }

    function favorites() {
      $('#frontend-control .btn.active').removeClass('active');
      $('#favorites').addClass('active');
      $container.isotope({ filter: '.favorite', sortAscending: true });
    }

    function random() {
      $('#frontend-control .btn.active').removeClass('active');
      $('#random').addClass('active');
      $container.isotope({
        filter: filterValue,
        sortBy: 'random'
      }).isotope('updateSortData');
    }

    $('#desc').on("click touchstart", sorteddesc);
    // $('#desc').click(sorteddesc);

    $('#asc').on("click touchstart", sortedasc);
    // $('#asc').click(sortedasc);

    $('#favorites').on("click touchstart", favorites);
    // $('#favorites').click(favorites);

    $('#random').on("click touchstart", random);
    // $('#random').click(random);

    active_control = $('#frontend-control .btn.active').attr('id');
    switch (active_control) {
      case 'desc':
        sorteddesc();
        break;
      case 'asc':
        sortedasc();
        break;
      case 'favorites':
        favorites();
        break;
      case 'random':
        random();
        break;
      default:
        sorteddesc();
    }

}

/* end click menu --> */
  
  /*                               */
  /* end lazySises load event ---> */
  /*                               */

  var updateLayout = function (e) {
      
     $('.summary').one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function(event) {
        
        $container.isotope('layout');
     
     });
        $container.isotope('layout');

  };

 $('img.thumbnail.wall').addClass( 'lazyload' );
  var addClasses = function (e) {

      // event load on image thumb on isotope wall
      if ( $(e.target).parent().hasClass( "thumb-lazyloading" ) ) {
          $(e.target).parent().removeClass("thumb-lazyloading").addClass("thumb-lazyloaded");
          setTimeout(function() {
           $container.isotope('layout');
          }, 300);
      }
      // event load on carousel gallery
      if (e.target.className.indexOf('carousel-cell-image') >= 0) {
        setTimeout(function() {
          $(e.target).parent().removeClass("carousel-cell-lazyloading").addClass("carousel-cell-lazyloaded");
        }, 1000);
        player = $('#'+$(e.target).data('id')+'-player');
        if (!player.hasClass('loaded')) {
          setTimeout(function() {
            player.addClass('loaded');
          }, 1000);
        }
      }
      this.removeEventListener('load', addClasses);
  };

  // On cover lazyloaded unveilhook
  window.addEventListener('lazyloaded', addClasses);


  // expander for summary
  $('.expander.expander-summary').each(function(){
      $(this).expander({
        slicePoint: $('.menu.active').data('slicepoint'),
        preserveWords: true,
        widow: 4,
        // startExpanded: true,
        startExpanded: $(this).data('status_expander'),
        expandEffect: 'fadeIn',
        userCollapseEffect: 'fadeOut',
        // beforeExpand: expandTextLayout,
        // onCollapse: collapseTextLayout,
        afterExpand: updateLayout,
        afterCollapse: updateLayout,
        detailPrefix: ' ',
        expandPrefix: ' ',
        summaryClass: 'expandsummary',
        expandText: '<span class="fa fa-plus-circle" data-original-title="'+$(this).data('open-summary')+'" data-tooltip="expandable" ></span>',
        userCollapseText: '<span class="fa fa-minus-circle" data-original-title="'+$(this).data('close-summary')+'" data-tooltip="expandable" ></span>'
      });

  });
  //expand for content
  $('.expander.expander-content').each(function(){
      $(this).expander({
        slicePoint: $('.menu.active').data('slicepoint'),
        preserveWords: true,
        widow: 4,
        // startExpanded: true,
        startExpanded: $(this).data('status_expander'),
        expandEffect: 'fadeIn',
        userCollapseEffect: 'fadeOut',
        // beforeExpand: expandTextLayout,
        // onCollapse: collapseTextLayout,
        afterExpand: updateLayout,
        afterCollapse: updateLayout,
        detailPrefix: ' ',
        expandPrefix: ' ',
        summaryClass: 'expandsummary',
        expandText: '<span class="fa fa-plus-circle" data-original-title="Ouvrir le contenu" data-tooltip="expandable" ></span>',
        userCollapseText: '<span class="fa fa-minus-circle" data-original-title="Fermer le contenu" data-tooltip="expandable" ></span>'
      });

  });


/* <-- end info-bottom text layout expand/collapse */

/* setup tooltip based on expander span --> */
  
  $('[data-toggle="tooltip-sort"]').tooltip({placement: 'auto top', html: true, container: 'body' });
  $('[data-tooltip="navbar"]').tooltip({placement: 'auto bottom', html: true, container: 'body' });
  $('[data-tooltip="expandable"]').tooltip({placement: 'auto right', html: true, container: 'body' });

  $('[data-toggle="tooltip"]').each(function(){
    var thumb = $(this).closest('.article').find('.thumb');
    if (!thumb.hasClass('locked')) {
      var name = thumb.data('name');
      var id = thumb.data('id');
      var slug = thumb.data('slug');
      var meta = thumb.data('meta');
      var date = thumb.data('date');
      var category = thumb.data('category');
      var htmlcontent = '<div style="text-align:left; margin-bottom:10px;">';
      htmlcontent = htmlcontent + '<strong>ID : </strong>'+id + '</br>';
      if ( name !== '' )
        htmlcontent = htmlcontent + '<strong>Name : </strong>'+name + '</br>';
      htmlcontent = htmlcontent + '<strong>Slug : </strong>'+slug + '</br>';
      htmlcontent = htmlcontent + '<strong>Category : </strong>'+category.replace(' ',', ')+ '<br/>';
      htmlcontent = htmlcontent + '<strong>Meta : </strong>'+meta+'<br/>';
      htmlcontent = htmlcontent + '<strong>Date : </strong>'+date+'</div>';
      $(this).tooltip({title: htmlcontent, html: true, delay: { "show": 1600, "hide": 200 } });
    }
  });
/* <-- setup tooltip */

  /* functions for media */

  function onArrangeScrollTop(event, filteredItems) {

      if (scrolltofavories || scrollto ) {
        if (propagation_iteration < 1) {
          page.animate({
            scrollTop: current_el.find('.player').offset().top
            }, 'slow', function(){
              $container.off( 'layoutComplete', onArrangeScrollTop );
              scrollto = false;
          });
          propagation_iteration ++;

        }
      }
  }
  
  /*
      Pause/stop all widgets
   */
  function pauseAllOthersWidgets() {

      // 
      // stop all other opened video(s)
      //
      
      var activesVideo = $('#articles .article.active [data-module="video"]');
      activesVideo.each(function(){
        
        var videoID = $(this).data('id');
        if ( $('#'+videoID).attr('data-plyr') ) {
          players = Plyr.get('#plyr-instance-'+videoID);
          players[0].pause();
        }

      });

      // 
      // stop all other opened sketchfab(s)
      //
      
      var activesSketch = $('#articles .article.active [data-module="sketchfab"]');
      activesSketch.each(function(){
        var id = $(this).data('sktechid');
        api[id].stop();
      });
   
  }

  /* end */

  // 
  // post for sketchfab
  // 
  
  function openPostSketchfab(post, featured) {

    pauseAllOthersWidgets(); // call pause on all widget

    featured = featured == undefined ? false : featured;
    post.tooltip('hide');
    var open_el = post.parent().parent();
    var fullscreen = post.data('fullscreen') == 'no' ? false : true;
    var propagation_css = true;
    hashtagToURI(post, featured);
    grid_thumb = post.data('bootstrap');
    parentblock = $(this).parent();
    layout = post.data('column-open');
    open_el.find('.preview').show();
    open_el.find('.js-sketchfab').hide();
    open_el.find('.media-ico').hide();

    current_el = open_el;

    parentblock.removeClass(grid_thumb).addClass(grid_full).addClass(active);
    // switch to new template
    open_el.removeClass(grid_thumb).addClass(layout).addClass(active).addClass('animate');
    
    open_el.one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function(event) {

        event.stopPropagation();
        $(this).off(event);

        var id = post.data('sktechid');
        var preview = open_el.find('.preview');
        iframe = $('#sketch'+id);

        if (propagation_css) {
          
          propagation_css = false;
          open_el.find('.js-sketchfab .sketchframe').attr('height', preview.height());

          if ( iframe.attr('data-sketchloaded') == "no" ) {

              // setup sketchfab
              model = post.data('sketchfab');
              // API version
              version = '1.0.0';
              // The iframe
              sketch = document.getElementById( 'sketch'+id );

              // The API client object
              client = new Sketchfab( version, sketch );

              // load the sketchfab model
              client.init( model, {
                  success: function onSuccess(callback) {
                    
                    preview.fadeOut( 100, function() {
                        preview.hide();
                        open_el.find('.js-sketchfab').show();
                    });
                    // preview.hide();
                    
                    api[id] = callback;
                    api[id].start();
                },
                  error: function onError() {
                    // put here the modal with the error !!!
                    alert( 'Sketchfab API Error!' );
                }
              });

            iframe.attr('data-sketchloaded','yes');

          } else {

            open_el.find('.preview').hide();
            open_el.find('.js-sketchfab').show();
            api[id].start();

          }

          // setTimeout(function() { $container.isotope('layout'); }, 100);
          setTimeout(function() {
            current_el = open_el;
            propagation_iteration = 0;
            $container.on( 'layoutComplete', onArrangeScrollTop );
            $container.isotope('layout');
          }, 100);

        }
    });

  }

  // 
  // post for video
  // 
  
  function openPostVideo(post, featured) {

      pauseAllOthersWidgets();
      
      featured = featured == undefined ? false : featured;
      post.tooltip('hide');
      var open_el = post.parent().parent();
      var fullscreen = post.data('fullscreen') == 'no' ? false : true;
      var propagation_css = true;
      hashtagToURI(post, featured);
      // switch to new template
      grid_thumb = post.data('bootstrap');
      layout = post.data('column-open');
      open_el.removeClass(grid_thumb).addClass(layout).addClass(active).addClass('animate');
      open_el.find('.preview').show();

      open_el.one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function(event) {

          event.stopPropagation();
          $(this).off(event);

          if (bgsidervideo) bgsidervideo.pause();
          if (bgvideo) bgvideo.pause();
          if (vimeovideo) vimeovideo.api('pause');

          // create the plyr
          videoID = post.data('id');
          is_plyr = $('#plyr'+videoID).attr('data-plyr');

          if (propagation_css) {
            
            propagation_css = false;

            open_el.find('.preview').hide();

            if ( is_plyr ) {
                // players = Plyr.get('#plyr-instance-'+videoID);
                // players[0].play();
                /* plyr 3.5 */
                player = players["plyr"+videoID];
                try {
                  player.play();
                }
                catch(error) {
                  console.error(error);
                }
            } else {
              
              options = {
                 fullscreen: {
                    enabled: fullscreen
                 }
              };

              // players = plyr.setup([document.getElementById(videoID)], options);
              // var players = Plyr.setup('#plyr-instance-'+videoID, options);
              // /* plyr 3.5 */
              try {
                var player = new Plyr('#plyr-instance-'+videoID, options );
                players['plyr'+videoID] = player;
              }
              catch(error) {
                console.error(error);
              }
              

              $('#plyr'+videoID).attr('data-plyr', true);
              $('#plyr'+videoID).addClass('plyr-'+videoID);

              /* plyr 3.5 */
              try {
                if ( player !== undefined ) {
                    player.on('ready', function(event) {
                      open_el.find('.preview').hide();
                      var video = event.detail.plyr;
                      video.play();
                    });
                }
              }
              catch(error) {
                console.error(error);
              }

            }

            // open_el.on("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function(e){
            //     // do something here
            //     $(this).off(e);
            //     setTimeout(function() { $container.isotope('layout'); }, 100);
            // });

            setTimeout(function() {
              current_el = open_el;
              propagation_iteration = 0;
              $container.on( 'layoutComplete', onArrangeScrollTop );
              $container.isotope('layout');
            }, 500);
            
            setTimeout(function() { $container.isotope('layout'); }, 100);

        }
      
      });

  }

   // 
  // post for gallery
  // 
  
  function openPost(post, featured) {

      pauseAllOthersWidgets();

      featured = featured == undefined ? false : featured;
      post.tooltip('hide');
      var ratio_img, brows_h, brows_w, new_h, new_w;
      var summary_preview = post.next('.summary_preview');
      var target = post.data('target');
      var image = $('#'+target+'-img-hd');
      var player = $('#'+target+'-player');
      var open_el = post.parent().parent();
      current_el = open_el;
      var w = post.data('gallery-width') == '' ? post.data('width') : post.data('gallery-width');
      var h = post.data('gallery-height') == '' ? post.data('height') : post.data('gallery-height');

      var ratio = post.data('ratio');
      var padding_width = 0;
      var padding_height = 0;
      var fullscreen = post.data('fullscreen') == 'no' ? false : true;

      var flickity_nav = post.data('flickity_nav'); // boolean
      var flickity_play = post.data('flickity_play'); // boolean
      var flickity_delay = post.data('flickity_delay'); // value
      var title_expander = post.data('title_expander'); // boolean
      propagation_css = true;

      summary_preview.fadeOut(0);

      hashtagToURI(post, featured);

      // re-organize mansory z-index elements
      $('#articles .article').css('z-index',1);
      open_el.css('z-index', '2');

      // destroy previous active flickity
      var flick = open_el.find('.carousel.flickity-enabled.carousel');
      if (flick.length > 0) {
        flick.flickity('destroy');
      }
      flick = open_el.find('.carousel');

      open_el.find('.preview').show();

      active_article = true;

      grid_thumb = post.data('bootstrap');
      active_grid_thumb = $('#articles .article.active .thumb').data('bootstrap');
      layout = post.data('column-open');

      // hide info-bottom
      $('.article.active .player .info-bottom').hide();
      // Hide carousel
      flick.fadeTo(0,0).hide();
      
      open_el.removeClass(grid_thumb).addClass(layout).addClass(active).addClass('animate');

      open_el.one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function(event) {
            
            event.stopPropagation();
            $(this).off(event);

            if (propagation_css) {

                  propagation_css = false;

                  // show carousel
                  flick.show();

                  ratio_img = h/w;
                  var carouselratio;

                  if (ratio_img < 1) {

                    brows_w   = player.find('.js-media-player').width();
                    carouselratio = brows_w*ratio_img;
                  
                  } else {
                    
                    brows_h   = $(window).height();
                    carouselratio = brows_h/ratio_img-40;

                  }

                  player.find('.carousel .carousel-cell').css('height', carouselratio);
                  // player.css('cssText', 'height:auto !important;');

                  $carousel = flick;

                  open_el.find('.preview').fadeOut("slow");

                  $carousel.on( 'ready.flickity', function() {
                    flick.fadeTo(1000,1);
                    open_el.find('.preview').hide();
                  });

                  $carousel.flickity({
                      "lazyLoad": 1,
                      "pageDots": open_el.find('.carousel-cell').length > 1 && flickity_nav ? true : false,
                      "autoPlay": flickity_play ? flickity_delay : false,
                      "imagesLoaded": true,
                      "fullscreen": fullscreen,
                      "dragThreshold" : 10,
                      "wrapAround" : true,
                      "draggable": ">1",
                      "arrowShape": { 
                        x0: 22,
                        x1: 52, y1: 38,
                        x2: 58, y2: 38,
                        x3: 28
                      }
                      // "hash": true
                  });

                  $('[data-toggle="tooltip-fullscreen"]').tooltip({placement: 'auto bottom', html: true, container: 'body' });
                  $('[data-toggle="tooltip-close"]').tooltip({placement: 'auto bottom', html: true, container: 'body' });

                  if (fullscreen) {
                    $carousel.on( 'fullscreenChange.flickity', function( event, isFullscreen ) {
                        var id = $(this).parent().attr('id');
                        var el = $( '#'+id+"-article" );
                        if (isFullscreen) {
                          $('#articles .article:not(#'+id+'-article)').hide();
                          $('header').hide();
                          $('#sidebar').hide();
                          el.find('.carousel .carousel-cell').css('height','100%');
                        } else { 
                          el.find('.flickity-viewport').css('height', carouselratio);
                          $('header').show();
                          $('#sidebar').show();
                          $('#articles .article').show();
                          $container.isotope({ filter: '*' });
                          $container.isotope({ filter: filterValue });
                        }
                    });
                  }
                  propagation_css = true;

                  // setTimeout(function() {
                  //   current_el = open_el;
                  //   propagation_iteration = 0;
                  //   $container.on( 'layoutComplete', onArrangeScrollTop );
                  //   $container.isotope('layout');
                  // }, 100);
                  
                  $container.isotope('layout');
                  
                  if (!featured) {
                    setTimeout(function() {
                      page.animate({
                        scrollTop: open_el.find('.player').offset().top
                        }, 'slow', function(){
                          scrollto = false;
                      });
                    }, 100);
                  }

            }
            
      });
  }

  function openMedia(media, featured) {

      if (!featured) {
        scrollto = true;
      }
      if (favoriesopened) {
        $('.thumb.featured').each(function(){
            close_post($(this));
        });
        favoriesopened = false;
      }
      if (mediaautoclose == "auto") {
        close_post();
      }

      switch(media.data('module')){
          case "gallery":
            openPost(media, featured);
          break;
          case "video":
            openPostVideo(media, featured);
          break;
          case "sketchfab":
            openPostSketchfab(media, featured);
          break;
          default: 
            console.log('Unknown media. No action.');
          break;
      }
  }
  
  $('#articles .article .thumb').on("click", function(event) {

      event.preventDefault();
      if ( $(this).data('locked') == 'no' ) openMedia($(this), false);
      
  });

/* <--- end click action on image */


/*  hover image effect --> */
  $('.thumb').hover(function(){
      img = $(this).find('img');
      $('.thumb .title-hover').hide();
      current = $(this);

      if ( img.hasClass('lazyloaded') && current.find('.title-hover').text() ) {
        img.fadeTo( 150, .5, function() {
            current.find('.title-hover').show();
        });
      }

    }, function() {

      if ( img.hasClass('lazyloaded') && current.find('.title-hover').text() ) {
        img.fadeTo(50,1);
        current.find('.title-hover').hide();
      }

  });
/* <--- end hover image effect */

/* event on button article */
  
  function reset_hashtag() {
    var hash_params = getHashParams(location.hash);
    if ( hash_params.c ) {
        location.hash = 'c=' + hash_params.c;
    } else {
      
        location.hash = '';
    }
  }

  function close_video(el) {
      videoID = el.parent().parent().find('.js-media-plyr').attr('id');
      if (videoID != undefined) {
        /* plyr 3.5 */
        try {
          player = players[videoID];
          player.pause();
        }
        catch(error) {
          console.error(error);
        }
      }
      if (bgsidervideo) bgsidervideo.play();
      if (bgvideo) bgvideo.play();
      if (vimeovideo) vimeovideo.api('play');
  }

  function close_gallery(el) {
    // nothing to do with gallery
    return true;
  }

  function close_sketchfab(el) {
    // stop sketchfab
    el.find('.preview').hide();
    el.find('.media-ico').show();
    var id = el.data('sktechid');
    api[id].stop();
  }

  function close_post(el) {

      var thisarticle;
      active_article = false;

      if (el) {

        // 
        // close only one post element
        // 

        thisarticle = el.parent().parent();

        player_ui = el.find('.player .info-bottom');
        player = el.find('.player');
        grid_thumb = el.data('bootstrap');
        player_ui.fadeOut(100);
        layout = el.data('column-open');

        // call specific media context function
        // 
        postFunctions['close_'+el.data('module')](el);

        thisarticle.removeClass(layout).removeClass(active).addClass(grid_thumb);
        thisarticle.one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function(event) {
            player_ui.fadeIn(0);
            el.next('.summary_preview').fadeIn(0);              
            setTimeout(function() { $container.isotope('layout'); }, 100);
        });

      } else {

        // 
        // close all posts elements
        // 

        var elements = $('#articles .article.active');

        elements.each(function(){

            close_el = $(this);
            // close_el = $('#articles .article.active');
            player_ui = close_el.find('.player .info-bottom');
            player = close_el.find('.player');
            grid_thumb = $('#articles .article.active .thumb').data('bootstrap');
            player_ui.fadeOut(100);
            layout = $('.article.active .thumb').data('column-open');
            thumb = close_el.find('.thumb-container .thumb ');

            // call specific media context function
            // 
            postFunctions['close_'+thumb.data('module')](thumb);

            close_el.removeClass(layout).removeClass(active).addClass(grid_thumb);
            close_el.one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function(event) {
                player_ui.fadeIn(0);
                close_el.next('.summary_preview').fadeIn(0);
                setTimeout(function() { $container.isotope('layout'); }, 100);
            });
            
        });
      }

  } // end close function
    
  $('.close-article, .gallery-close').on("click touchstart", function(event) {

      event.preventDefault();
      var thumb = $(this).closest('.article.active').find('.thumb');
      close_post( thumb ); // avoid to scroll to top page, it scroll to thumb
      thumb.scrollView();
      reset_hashtag();

  });

  /* <!-- hash change */

    var isIsotopeInit = false;

    function onHashchange() {
        var hashFilter = getHashFilter('c');
        var product = getHashFilter('p');
        if ( !hashFilter && isIsotopeInit ) {
          return;
        }
        isIsotopeInit = true;
        $container.isotope({
          layoutMode: 'packery',
          itemSelector: '.grid-item',
          filter: hashFilter,
          animationOptions: {
              duration: 500,
              easing: 'swing'
          }
        });

        // set selected class on button
        if ( hashFilter ) {
          // update menu
          $('.button-category .active').removeClass('active');
          if (hashFilter == '*') {
              $('.button-category .all').addClass('active');
          } else {
              $('.button-category '+hashFilter).addClass('active');
          }
        }

        if ( product ) {

          openMedia($('[data-slug="'+product+'"]'), false);

        }

    }
    // end haschange
    // 


    // full layout screen option
    $(".navbar-toggle.x").click(function(event) {

        // event.preventDefault();
        if ( $('.navbar-brand').is(':hidden')) {

          if ( $(this).hasClass('collapsed') ) {
            // $(".navbar-toggle.x").addClass('collapsed');
            $('.tpcontainer').css('padding-left', '');
            $( "#sidebar" ).show( 200, function() {
                $container.isotope('layout');
                $(".navbar-toggle.x").removeClass('collapsed');
            });

          } else {
            
            $(this).addClass('collapsed');
            $('.tpcontainer').css('padding-left', '40px');
            $('#sidebar').hide(200);
            $( "#sidebar" ).hide( 200, function() {
                $container.isotope('layout');
                $(".navbar-toggle.x").addClass('collapsed');
            });
          }
          

        }

    });

    /* hash change --> */

    /* <!-- hash change */

      // trigger URL change for hash update
      $(window).on( 'hashchange', onHashchange );


      $(window).resize(function() {

          clearTimeout(resizeId);
          resizeId = setTimeout(doneResizing, 500);

          // fix collapse button
          if ( $('.navbar-brand').is(':hidden')) {
                $(".navbar-toggle.x").removeClass('collapsed');
          } else {
              $(".navbar-toggle.x").addClass('collapsed');
              $('.tpcontainer').css('padding-left', '');
              $('#sidebar').show();
          }

      });

      function doneResizing() {

          if (active_article) {

            $('#articles .article.active').find('.flickity-viewport').css('height', carouselratio);
            $carousel.flickity('exitFullscreen');
            $('#articles .article').show();
            $('header').show();
            $('#sidebar').show();
            // close_post();

          }
      }

      // detect scroll and stop scrollto propagation
      $(window).bind('mousewheel DOMMouseScroll', function(event){
          page.stop();
          // if (event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0) { console.log('scroll up'); } else { console.log('scroll down'); }
      });
      
      //
      //  Show Featured
      //  --->
          // open only the first featured :
          // openMedia($('.thumb.featured').first(), true);
          $($('.thumb.featured').get().reverse()).each(function(){          
              openMedia($(this), true);
              var featured_id = $(this).parent().parent().attr('id');
              var id = featured_id.replace("-article", "");
              if ( scrolltofeatured.indexOf(id) !== -1 ) {
                featured.push(featured_id);
              }
          });
      // <---
      //  end show featured
      //  
      
      //
      //  SHOW PRODUCT CMS
          var product_cms = $('#articles').data('product');
          // alert(product_cms);
          if ( product_cms !== '' ) {
            openMedia( $('[data-slug="'+product_cms+'"]'), true);
          }
          
      //
      //
      
      // 
      // scroll to featured
      // --->
        if (scrolltofavories) {
            function scrollTopToFeatured(i) {
              if (i === 0) {
                return 1;
              } else {
                setTimeout(function() {
                  page.animate({
                    scrollTop: $('#'+featured[i-1]).offset().top
                    }, 'slow', function(){
                      scrollTopToFeatured(i - 1);
                  });
                }, i == featured.length ? 1000 : scrollpausetime );
              }
            }

            scrollTopToFeatured(featured.length);
        }
      // <---
      // end scroll to featured

      onHashchange();

      // $container.on( 'layoutComplete', function( event, laidOutItems ) {
      //  console.log(event);
      // });

  });