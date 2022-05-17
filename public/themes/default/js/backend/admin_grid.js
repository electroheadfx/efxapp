$(function(){

	////////////////////////
	////// Boostrap tooltip
	///////////////////////////

if ($('#listWithHandle').length) {

	var base_deleteLink = $('#listWithHandle').data('delete-url').replace('http://', '').split("/");
	base_deleteLink.pop();
	var url_base = base_deleteLink[0];
	base_deleteLink = 'http://'+base_deleteLink.join("/")+'/';
}

	$('[data-toggle="tooltip-project"],[data-toggle="tooltip-media"]').tooltip({placement: 'auto top', container: 'body',delay: { "show": 300, "hide": 200 } });

	$('.tooltip-post').tooltip({html: true, delay: { "show": 50, "hide": 20 }});
	$('.tooltip-post-thumb').tooltip({html: true, delay: { "show": 0, "hide": 0 }, template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner tooltip-inner-post-thumb"></div></div>'});

	$('.tooltip-post-thumb').hover(function(){
	}, function() {
		$(this).tooltip('hide');
	});

 	$('.toggle-grid-admin-select').change(function() {

 		if ( ! $(this).prop('checked') ) {
 			var id = $(this).data('post-id');
 			$(this).parent().parent().parent().next().find('.delete-post').attr('href', base_deleteLink+id);
 		}
       
		var posts_to_delete = '';
		var posts = [];
		$('.toggle-grid .toggle:not(.off) .toggle-grid-admin-select').each(function() {
				posts_to_delete += $(this).data('post-id')+',';
				posts.push($(this).parent().parent().parent().next().find('.delete-post'));
		});
		posts_to_delete = posts_to_delete.slice(0, -1);

		posts.forEach(function(item) {
			$(item).attr('href', base_deleteLink+posts_to_delete);
		});
     })

	$('.share').on('click', function(e) {
		event.preventDefault();
		var URL = 'http://'+url_base+'/p/';
		if ( $('.toggle-grid .toggle:not(.off)').length < 2 ) {
			var URL = $(this).attr('href');
		} else {
			
			$('.toggle-grid .toggle:not(.off) .toggle-grid-admin-select').each(function() {
				URL += $(this).data('post-slug')+',';
			});
			URL = URL.slice(0, -1);
		}

		$('#sharemodal #inputShareURL').val(URL);
		$('#sharemodal #paste').attr('data-clipboard-text',URL);
		$('#sharemodal #open').attr('href',URL);
		$('#sharemodal #facebook').attr('href', $('#sharemodal #facebook').data('facebook')+URL);
		$('#sharemodal #twitter').attr('href', $('#sharemodal #twitter').data('twitter')+URL);
		$('#sharemodal #google').attr('href', $('#sharemodal #google').data('google')+URL);
		$('#sharemodal #pinterest').attr('href', $('#sharemodal #pinterest').data('pinterest')+URL);
		$('#sharemodal').modal('show');
	});

	pasteboard = new ClipboardJS('.paste-url');

	$('#paste, #twitter, #facebook, #open').on('click', function(e) {
		$('#sharemodal').modal('hide');
	});

	///////////////////////////
	////// chosen select
	///////////////////////////
	$('option#uncategorized').attr('disabled','disabled');

	$('.chosen-select').chosen({allow_single_deselect:true}); // display_disabled_options: false

	/* Detect any change of option*/
	$(".chosen-select").change(function(evt, params){

		var target 			= $(this).parent();
		// var category_slug 	= target.data('cat-slug');
		var post_id 		  = target.data('post-id');
		var selected_cat_id   = $(this).find(':selected').data('cat-id');
		var selected_cat_slug = $(this).find(':selected').attr('id');
		var val_uncategorized = $('option#uncategorized').val();
		var selected 		  = $(this).find(':selected').val();
		var val				  = $(this).val();
		var exposition		  = target.data('exposition');

		// console.log('selection ID '+selected_cat_id+' - slug: '+selected_cat_slug);
		// console.log(val_uncategorized);

		var datapost = [post_id];

		if (! val) {
			// remove deselected and add uncategorized
			$(this).val(val_uncategorized).trigger("chosen:updated");
			// cat = val_uncategorized.split(','); 
			datapost.push('deselected-add-uncategorized');
			data = params.deselected;
			cat = data.split(',');
			datapost.push({'category_id': cat[0], 'category_slug': cat[1], 'category_name': cat[2], 'exposition': exposition });

		} else {
			// has one ore more categories
			$(this).find('option#uncategorized').prop("selected", false).trigger("chosen:updated");

			if (params.selected) {
				// datapost.push('selected');
				 if (val.length > 1) {
				 	// add selected
					datapost.push('selected');
				} else {
					// add selected and remove uncategorized
					datapost.push('selected-remove-uncategorized');
				}
				data = params.selected;
			} else {
				// remove deselected
				datapost.push('deselected');
				data = params.deselected;
			}
			cat = data.split(',');
			datapost.push({'category_id': cat[0], 'category_slug': cat[1], 'category_name': cat[2], 'exposition': exposition });
		}
		
		$.ajax({
			method: "POST",
			url: "/media/backend/media/change_category",
			data: 'datapost='+JSON.stringify(datapost),
      		dataType: "text",
			success: function(data) {
				data = JSON.parse(data);
				post_id		 	= data.post_id;
				action		 	= data.action;
				category_slug 	= data.category_slug;
				category_name 	= data.category_name;

				if (action == 'deselected') {

					$('#'+post_id).removeClass(category_slug);
				
				} else if (action == 'selected') {

					$('#'+post_id).addClass(category_slug);
					// $('#'+post_id).removeClass('uncategorized');

				} else {

					$('#'+post_id).addClass('uncategorized');

				}

                $grid.isotope({ filter: filterValue });

	        },
	        error: function () {
                alert("error with chosen-select");
            }
		});
		
	});

	$('.chosen-choices').attr('style', 'height: 34px!important;');

	$('.chosen-container').hover(function(){
	    el = $(this).find('.chosen-choices');
	    el.attr('style', '');
	    el.parent().attr('style', 'position:absolute; width: 238px;');

	  }, function() {
	    el.attr('style', '');
	    el.attr('style', 'height: 34px!important;');
	    el.parent().attr('style', 'width: 238px;');
	    el.parent().parent().parent().find('.tooltip-post').tooltip('hide');

	});


	////////////////////////
	////// isotope filter
	////////////////////////////

	// init isotope
	var $container = $('#listWithHandle');
	var filterValue = '*';
	var qsRegex;

	var keywordgrid = {
		layoutMode: 'packery',
		itemSelector: '.grid-item-backend',
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
	 	$(this).find('i.fa-remove').attr('class', 'fa fa-search');
	 	qsRegex = new RegExp( $quicksearch.val(), 'gi' );
	 	if ($('#listWithHandle').length) {
	 		sort.option("disabled", false);
	 	}
	 	$('.glyphicon-move').css( "cursor", '' );
	 	$('.glyphicon-move .fa-arrows').css( "opacity", 1 );
 		$grid.isotope(regexgrid);
 	    Cookies.set("position_search", $quicksearch.val());
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

if ($('#listWithHandle').length) {

	///////////////////////////////////////
	//////// List with handle move elements
	
	sort = Sortable.create(listWithHandle, {
	  	handle: '.glyphicon-move',
	  	animation: 150,
	  	// draggable: "#listWithHandle .element.active",
	  	filter: ".ignore-elements",
	  	onStart: function (/**Event*/evt) {
	  		evt.oldIndex;  // element index within parent
	  		// destroy temporary isotope en keep hidden isotope elements if filtered 
	  		$container.isotope('destroy');
	  		if (filterValue != '*') {
		  		$('#listWithHandle .element').addClass('ignore-elements');
		  		$('#listWithHandle .element'+filterValue ).removeClass('ignore-elements');
		  	}
	  	},
	  	onEnd: function (evt) {

			// evt.oldIndex;  // element's old index within parent
			// evt.newIndex;  // element's new index within parent

			var list = '';
			var i = 0;
			$('.element').each(function() { 
				if (i > 0) {
					list = list + ',' + $(this).attr('id');
				} else {
					list = $(this).attr('id');
				}
				i++;
			})

			$.ajax({
					method: "POST",
					url: "/media/backend/api/sortpost/"+list
		    })
		    // re-init isotope with filterValue
			$('#listWithHandle .element').removeClass('ignore-elements');
		    $grid.isotope({filter: filterValue});
		}
	});

	///////////////////////////////////////////
	//////// quick search regex
	///////////////////////////////////////////
	
	// use value of search field to filter 
	var $quicksearch = $('.isotope-search').keyup( debounce( function() {
		sort.option("disabled", true);
		$('.glyphicon-move').css( "cursor", 'default' );
		$('.glyphicon-move .fa-arrows').css( "opacity", 0 );
		$('.isotope-search').parent().find('i.fa-search').attr('class', 'fa fa-remove');
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
}

    if (Cookies.get("jquery_position_category")) {
    	$('.filters .button-category a'+Cookies.get("jquery_position_category") ).trigger( "click" );
    }
    if (Cookies.get("position_search")) {
    	$('.isotope-search').val(Cookies.get("position_search")).trigger('keyup');
    }

	
	/*
	
	 anchor category

	*/

	// init isotope filter menu click
	$filters = $('.filters .button-category a').on( "click", function(event) {

	      event.preventDefault();
	      
	      $('.collapse.navbar-collapse.navbar-right').removeClass('in');
	     
	      $('.filters a.active').removeClass('active');
	      $(this).addClass('active');

	      $('.isotope-search').val('');
	      if ($('#listWithHandle').length) {
	      	sort.option("disabled", false);
	  	  }
	 	  $('.glyphicon-move').css( "cursor", '' );
	 	  $('.glyphicon-move .fa-arrows').css( "opacity", 1 );

	      filterValue = $(this).data('filter');

	      var id;

	      if ( $(this).hasClass('all') ) {

	      	id = $(this).parent().next().find('a').data('id');

	      } else {
	      	
	      	id = $(this).data('id');
	      }

	      // init create href media with actived folder ID
	      $('.create').each(function() {
			var ref = $(this).attr('href').split("?");
			var this_Url = ref[0];
			$(this).attr('href', this_Url+'?cat='+id);

		  });

	      Cookies.set("jquery_position_category", $(this).data('filter'));

	      location.hash = 'filter=' + encodeURIComponent( filterValue );
	      $grid.isotope({ filter: filterValue });

	      return false;

	 });
	// init create href media with active folder ID
	var id_menu = $('.button-category a.all').parent().next().find('a').data('id');
	  $('.create').each(function() {
		var ref = $(this).attr('href').split("?");
		var this_Url = ref[0];
		$(this).attr('href', this_Url+'?cat='+id_menu);

	  });

	  /* end anchor code */

	   // close alert when click on page
	   $(document).click(function (event) {
	     $(".alert").hide();
	  });

});