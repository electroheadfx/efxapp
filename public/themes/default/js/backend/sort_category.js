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
			$('tr.element').each(function() { 
				if (i > 0) {
					list = list + ',' + $(this).attr('id');
				} else {
					list = $(this).attr('id');
				}
				i++;
			})

			$.ajax({
					method: "POST",
					url: "/project/backend/api/sortcategory/"+list
		    })
		}
	});

	$('[data-toggle="tooltip"]').tooltip({placement: 'auto bottom', container: 'body', delay: { "show": 800, "hide": 200 } });
	$('[data-toggle="tooltip-menu"]').tooltip({placement: 'auto top', container: 'body',delay: { "show": 600, "hide": 200 } });

	/////////////////////////////
	//////// AJAX List attributes
	/////////////////////////////////

	$('a.attr-status, a.attr-permission, a.attr-visibility').click(function(event){

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