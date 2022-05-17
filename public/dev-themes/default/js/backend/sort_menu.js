$(window).load(function(){

	// List with handle
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
					url: "/project/backend/api/sortmenu/"+list
		    })
		}

	});

	$('[data-toggle="tooltip"]').tooltip({placement: 'auto bottom', html: true, container: 'body', delay: { "show": 800, "hide": 200 } });
	
	$('[data-toggle="tooltip-pasteboard"]').tooltip({placement: 'auto bottom', html: true, container: 'body', delay: { "show": 0, "hide": 300 } });

	$('[data-toggle="tooltip-pasteboard"]').hover(function(){
	}, function() {
		$(this).tooltip('hide');
	});

	pasteboard = new ClipboardJS('.pasteboard');

	/////////////////////////////
	//////// AJAX List attributes
	/////////////////////////////////

	$('a.attr-status, a.attr-permission, a.attr-featured, a.attr-visibility').click(function(event){

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

});