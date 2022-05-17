
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
				url: "/media/backend/api/sortpost/"+list
	    })
	}
});