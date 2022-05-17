$(function(){

	$('[data-toggle="tooltip-project"]').tooltip({placement: 'auto top', container: 'body',delay: { "show": 300, "hide": 200 } });

	//////////////////////
	/// AJAX Attributes
	//////////////////////

	$('a#attr-status, a#attr-permission, a#attr-featured').click(function(event){
		
	    event.preventDefault();
		trigger = $(this);

		$.ajax({
			method: "POST",
			url: trigger.attr('href'),
			success: function(data) {
	       		trigger.empty().append(data.html);
	       		trigger.attr('href', data.url);
	        }
		})
	});

	 // close alert when click on page
	 $(document).click(function (event) {
	   $(".alert").hide();
	});

	/////////////////////
	/// LIST SORT POST
	/////////////////////

	Sortable.create(listWithHandle, {
	  handle: '.glyphicon-move',
	  animation: 150,
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
		}
	});

    // init create href media with active folder ID
    var id_menu = $('.button-category a.all').parent().next().find('a').data('id');
	  $('.create').each(function() {
		var ref = $(this).attr('href').split("?");
		var this_Url = ref[0];
		// var hash = ref[1].split("=");
		// var this_Hash = hash[0];
		// $(this).attr('href', this_Url+'?'+this_Hash+'='+id_menu);
		$(this).attr('href', this_Url+'?cat='+id_menu);
	  });

	/////////////////////
	/// LIST SORT POST
	/////////////////////
	

	$filters = $('.filters .button-category a').click(function(event){
			
		event.preventDefault();
		$('.collapse.navbar-collapse.navbar-right').removeClass('in');
		
		$('.filters a.active').removeClass('active');
		$(this).addClass('active');

		filterValue = $(this).data('filter');

		// init create href media with actived folder ID
		$('.create').each(function() {
			var ref = $(this).attr('href').split("?");
			var this_Url = ref[0];
			var id = $(this).data('id');
			// var hash = ref[1].split("=");
			// var this_Hash = hash[0];
			// $(this).attr('href', this_Url+'?'+this_Hash+'='+id);
			$(this).attr('href', this_Url+'?cat='+id);
		});

		$('#listWithHandle .element').addClass('ignore-elements');
		$('#listWithHandle .element'+filterValue ).removeClass('ignore-elements');

	    $.ajax({
	      method: "GET",
	       url: "/media/backend/api/position.json?action=setup&category="+filterValue,
	       success: function(data) {
				console.log('position_category: '+data.position_category);
	       },
	       error: function () {
	           alert("error with position");
	       }
	    });

	});

	// position to category based on AJAX cookies
    $.ajax({
      method: "GET",
       url: "/media/backend/api/position.json",
       success: function(data) {
			console.log('position_category: '+data.position_category);
			var position_category = data.position_category;
			if ( position_category !== null ) {
				$('.filters .button-category a'+position_category ).trigger( "click" );
			}
       },
       error: function () {
           alert("error with position");
       }
    });


});