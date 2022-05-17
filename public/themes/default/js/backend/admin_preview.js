$(function(){

	////////////////////////
	////// Boostrap tooltip
	///////////////////////////

	$('[data-toggle="tooltip-project"],[data-toggle="tooltip-media"]').tooltip({placement: 'auto top', container: 'body',delay: { "show": 300, "hide": 200 } });

	$('.tooltip-post').tooltip({html: true, delay: { "show": 50, "hide": 20 }});
	$('.tooltip-post-thumb').tooltip({html: true, delay: { "show": 0, "hide": 0 }, template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner tooltip-inner-post-thumb"></div></div>'});

	$('.tooltip-post-thumb').hover(function(){
	}, function() {
		$(this).tooltip('hide');
	});

	 // close alert when click on page
	 $(document).click(function (event) {
	   $(".alert").hide();
	});

	////////////////////////
	////// isotope filter
	////////////////////////////

	// init isotope
	var $container = $('#articles');
	var filterValue = '*';
	var qsRegex;

	var keywordgrid = {
		layoutMode: 'packery',
		itemSelector: '.grid-item',
		filter: filterValue,
		animationOptions: {
		  duration: 500,
		  easing: 'swing'
		}
	}

	var regexgrid = {
		layoutMode: 'packery',
		itemSelector: '.grid-item',
		// filter: filterValue,
		filter: function() {
		  return qsRegex ? $(this).find('#tags').text().match( qsRegex ) : true;
		},
		animationOptions: {
		  duration: 500,
		  easing: 'swing'
		}
	}

    var $grid = $container.isotope(keywordgrid);

    // init create href media with active folder ID
    var id_menu = $('.button-category a.all').parent().next().find('a').data('id');
	  $('.create').each(function() {
		var ref = $(this).attr('href').split("?");
		var this_Url = ref[0];
		var hash = ref[1].split("=");
		var this_Hash = hash[0];
		$(this).attr('href', this_Url+'?'+this_Hash+'='+id_menu);
	  });

	// init isotope filter menu click
	
	// $filters = $('.filters .button-category a').click(function(event){
	$filters = $('.filters .button-category a').on( "click", function(event) {

	      event.preventDefault();
	      $('.collapse.navbar-collapse.navbar-right').removeClass('in');
	     
	      $('.filters a.active').removeClass('active');
	      $(this).addClass('active');

	      $('.isotope-search').val('');
	      // sort.option("disabled", false);
	 	  $('.glyphicon-move').css( "cursor", '' );
	 	  $('.glyphicon-move .fa-arrows').css( "opacity", 1 );

	      filterValue = $(this).data('filter');
	      var id = $(this).data('id');

	      // init create href media with actived folder ID
	      $('.create').each(function() {
			var ref = $(this).attr('href').split("?");
			var this_Url = ref[0];
			var hash = ref[1].split("=");
			var this_Hash = hash[0];
			$(this).attr('href', this_Url+'?'+this_Hash+'='+id);
		  });

	      location.hash = 'filter=' + encodeURIComponent( filterValue );

	      $grid.isotope({ filter: filterValue });

          Cookies.set("position_category", filterValue);

	      return false;

	 });

	/* <!-- hash change */

	    var isIsotopeInit = false;

	    function getHashFilter() {
	      var hash = location.hash;
	      // get filter=filterName
	      var matches = location.hash.match( /filter=([^&]+)/i );
	      var hashFilter = matches && matches[1];
	      return hashFilter && decodeURIComponent( hashFilter );
	    }

	    function onHashchange() {
	        var hashFilter = getHashFilter();
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
	        // alert( $filters.find('.is-checked') );
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
	    }

	/* hash change --> */
	/* <!-- hash change */

	    // trigger URL change for hash update
	    $(window).on( 'hashchange', onHashchange );
	    // trigger event handler to init Isotope hash
	    onHashchange();

	/* hash change --> */
	 
	 // Erase search
	 $('.remove').click(function(event){
	 	$('.isotope-search').val('');
	 	qsRegex = new RegExp( $quicksearch.val(), 'gi' );
	 	// sort.option("disabled", false);
	 	$('.glyphicon-move').css( "cursor", '' );
	 	$('.glyphicon-move .fa-arrows').css( "opacity", 1 );
	 	$grid.isotope(regexgrid);
 	    $.removeCookie("position_search");
	 });


	 var updateLayout = function (e) {
	     	       
	      $container.isotope('layout');

	 };

	 $('.expander').each(function(){
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
	       expandText: '<span class="fa fa-plus-circle" ></span>',
	       userCollapseText: '<span class="fa fa-minus-circle" ></span>'
	     });

	 });

	/////////////////////////////
	//////// AJAX List attributes
	/////////////////////////////////
	
	$('a.attr-status, a.attr-permission, a.attr-featured, a.attr-locked').click(function(event){
		
	    event.preventDefault();
		trigger = $(this);

		$.ajax({
			method: "POST",
			url: trigger.attr('href'),
			success: function(data) {
	       		trigger.empty().append(data.html);
	       		trigger.attr('href', data.url);

	       		// update HTML attributes
	       		attr = '.'+trigger.attr('class')+'-meta';		
	       		attribute_toggle = trigger.attr('data-attr-toggle');
	       		attribute_data = trigger.attr('data-attr');

	       		meta_el = trigger.parent().parent().parent().find(attr);
	       		data_text = meta_el.attr('data-text-'+attribute_data);
	       		meta_el.text( data_text );
	       		// trigger.find('.tooltip-post').attr('data-original-title', data_text);
	       		// console.log(trigger.find('.tooltip-post').attr('data-original-title'));

	       		// toggle attributes value
	       		trigger.attr('data-attr-toggle', attribute_data);
	       		trigger.attr('data-attr', attribute_toggle);

	       		// update search
	       		if ( $('.isotope-search').val() != '' ) {

	       			$('.isotope-search').trigger('keyup');
	       		}
	       		$('.tooltip-post').tooltip();
	        }
		});
		
	});

	///////////////////////////////////////////
	//////// quick search regex
	///////////////////////////////////////////
	
	// use value of search field to filter 
	var $quicksearch = $('.isotope-search').keyup( debounce( function() {
		// sort.option("disabled", true);
		$('.glyphicon-move').css( "cursor", 'default' );
		$('.glyphicon-move .fa-arrows').css( "opacity", 0 );
		qsRegex = new RegExp( $quicksearch.val(), 'gi' );
		$grid.isotope(regexgrid);
	    Cookies.set("position_search", $quicksearch.val());
	}, 200 ) );

	// debounce so filtering doesn't happen every millisecond
	function debounce( fn, threshold ) {
	  var timeout;
	  return function debounced() {
	    if ( timeout ) {
	      clearTimeout( timeout );
	    }
	    function delayed() {
	      fn();
	      timeout = null;
	    }
	    timeout = setTimeout( delayed, threshold || 100 );
	  }
	}

	// debug and reactive
    // if ($.cookie("position_category")) {
    // 	$('.filters .button-category a'+$.cookie("position_category") ).trigger( "click" );
    // }
    // if ($.cookie("position_search")) {
    // 	$('.isotope-search').val($.cookie("position_search")).trigger('keyup');
    // }
    

    /*                               */
    /* end lazySises load event ---> */
    /*                               */

    var addClasses = function (e) {

        if (e.target.className.indexOf('carousel-cell-image') >= 0) {
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
    // cover.addEventListener('load', addClasses, true);
    window.addEventListener('lazyloaded', addClasses);

    // Cover loading via JS API - update isotope on thumb loadsizes
      $('.content').each(function(){
        
          $container[0].addEventListener('load', (function(){
              var runs;
              var update = function(){
                runs = false;
                $container.isotope('layout');
              };
              return function(){
                if(!runs){
                  runs = true;
                  setTimeout(update, 1000);
                }
              };
           }()), true);

      });

});