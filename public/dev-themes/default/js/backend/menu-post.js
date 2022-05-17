$(function () {

	var id,save,froala_buttons,crop,size,folder,algorythm,upload,todelete,gallery;
	//
	// Editor's setup
	// 
	function read_data() {
		id 				= $('#edit_content').attr("data-id");
		save 			= $('#edit_content').attr("data-save");
		froala_buttons  = [ 'undo', 'redo', '|', 'bold', 'italic', 'paragraphFormat', 'fontSize', 'color', '|', 'insertHR', 'quote', 'align', '|', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'paragraphStyle', '|', 'emoticons','nowrapspace', 'wrapspace', '-', 'formatOL', 'formatUL', 'outdent', 'indent', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'clearFormatting', '|', 'html', '|', 'savearticle','|', 'fullscreen', '|'];
		crop 			= $('#edit_summary').attr("data-crop");
		size 			= $('#edit_summary').attr("data-size");
		folder 			= $('#edit_summary').attr("data-folder");
		algorythm 		= $('#edit_summary').attr("data-algorythm");
		upload 			= $('#edit_summary').attr("data-upload");
		todelete 		= $('#edit_summary').attr("data-delete");
		gallery 		= $('#edit_summary').attr("data-gallery");
	}

	function update_froala_imageUpload() {

		editor_summary.each(function() {
	    	var instance = $(this).data('froala.editor');
			instance.opts.imageUploadURL = upload+action;
			instance.opts.imageManagerLoadURL = gallery+load;
		});

		// editor_content.each(function() {
	 	//  var instance = $(this).data('froala.editor');
		// 	instance.opts.imageUploadURL = upload+action;
		// 	instance.opts.imageManagerLoadURL = gallery+load;
		// });
	}

	//
	// Initialize start up
	// 
	 read_data();
	 var editor_summary 	= $('.edit_froala_summary');
	 var image_params		= '/'+crop+'/'+size+'/'+algorythm;
	 var action 			= '/'+folder+image_params;
	 var load 				= '?index='+folder;

	 // enable tabs
	 $('.nav-tabs.tab-menu a').click(function (e) {
	     e.preventDefault();
	     $(this).tab('show');
	 });

	 // close alert when click on page
	 $(document).click(function (event) {
	    $(".alert").hide();
	 });

	 $('[data-toggle="tooltip"]').tooltip({placement: 'auto bottom', html: true, container: 'body' });

	 $('a.lang-switcher').click(function (e) {
	     e.preventDefault();
	     if ( !$(this).hasClass('active') ) {
		     lang = $(this).attr('href');
		     el = $(this).parent().parent();
		     el.find('.localisation').not( ".hidden" ).addClass('hidden');
		     el.find('.localisation.'+lang).removeClass('hidden');
		     el.find('a.lang-switcher').removeClass('active');
		     $(this).addClass('active');
		 }
	 });

	 $('a.lang-switcher-textarea').click(function (e) {
	     e.preventDefault();
	     activeli = $(this).parent();
	     if ( !activeli.hasClass('active') ) {
	     	el = activeli.parent().parent();
	     	lang = $(this).attr('href');
	     	el.find('.localisation').not( ".hidden" ).addClass('hidden');
	     	el.find('.localisation.'+lang).removeClass('hidden');
	     	lang = $(this).attr('href');
	     	activeli.parent().find('li.active').removeClass('active');
	     	activeli.addClass('active');
	     }
	 });

	//
	// Custom editor's buttons
	// 
	if (id != undefined) {
		$.FroalaEditor.DefineIcon('savearticle', {NAME: 'save'});
		$.FroalaEditor.RegisterCommand('savearticle', {
			title: 'Sauvegarde',
			focus: true,
			undo: true,
			refreshAfterCallback: true,
			callback: function () {
				this.$oel.froalaEditor('save.save')
			}
		})
	}

	//
	// Inline style
	//
	InlineStyle = {
		'Big c2v': 'font-size: 20px; color: red;',
		'Small c2v': 'font-size: 14px; color: blue;'
	}

	//
	// Cru2vielinks
	//
	LinkList = [
		{
		  text: 'Pierre nogueras',
		  href: 'http://pierrenogueras.com',
		  target: '_blank',
		  rel: 'nofollow'
		},
		{
		  displayText: 'Froala',
		  href: 'https://froala.com',
		  target: '_blank'
		}
	]

	//
	// Paragraph Styles
	// 
	ParagraphStyles = {
	  'fr-text-gray': 'Gris',
	  'fr-text-bordered': 'Encadré',
	  'fr-text-spaced': 'Espacé',
	  'fr-text-uppercase': 'Capitale'
	}

	 //
	 // summary editor
	 //
	editor_summary.each(function() {
		 var section = $(this).parent().parent().parent();
		 $(this).froalaEditor({
			toolbarInline: false,
			toolbarSticky: true,
			requestWithCORS: false,

			imageUploadURL: upload+action,
			imageManagerDeleteURL: todelete,
			imageManagerLoadURL: gallery+load,

			imageParams: {id: section.attr('id')},
			pastePlain: true,
			imageDefaultAlign: 'left',
			imageDefaultWidth: 0,
			imageDefaultAlign: 'left',
			toolbarButtons: froala_buttons,
			toolbarButtonsMD: froala_buttons,
			toolbarButtonsSM: froala_buttons,
			toolbarButtonsXS: froala_buttons,
			inlineStyles: InlineStyle,
			linkList: LinkList,
			paragraphStyles: ParagraphStyles,
			dragInline: false,
			imageResize: true,
			// imageResizeWithPercent: true,
			tabSpaces: 4,
			codeMirrorOptions: {
			   tabSize: 4
			},
			saveParams: {
			  id: (id != undefined ) ? id : null,
			  body: section.attr('id')
			},
			saveParam: section.attr('id'),
			saveURL: (id != undefined ) ? save : null,
			enter: $.FroalaEditor.ENTER_BR,
			language: $('#edit_summary').data('lang')
		 }).on('froalaEditor.image.beforeUpload', function (e, editor, images) {
        	// 'froalaEditor.image.uploaded'
        	// Return false if you want to stop the image upload.
        	// $('.selector').froalaEditor('image.setSize', '300px', '300px');
        	
      	});
	});

	//
	// editors events
	// 

	if (id != undefined) {

		editor_summary.on('froalaEditor.save.after', function (e, editor, data) {
			$('.bb-alert.summary').delay(200).fadeIn().delay(1000).fadeOut();
		});

		editor_summary.on('froalaEditor.save.error', function (e, editor, error) {
			$('.bb-alert.error').delay(200).fadeIn().delay(2000).fadeOut();
		});
	}

	//
	// update froala image size
	// 
	// 

	$('.foldermedia').change(function () {
		$('#edit_summary').attr("data-folder", this.value);
		read_data();		
		load = '?index='+this.value;
		action = '/'+this.value+image_params;
		update_froala_imageUpload();
	});

	$('.size').change(function () {
		$('#edit_summary').attr("data-size", this.value);
		read_data();		
		image_params = '/'+crop+'/'+this.value+'/'+algorythm;
		action = '/'+folder+image_params;
		update_froala_imageUpload();
	});

	$('.crop').change(function () {
		$('#edit_summary').attr("data-crop", this.value);
		read_data();
		image_params = '/'+this.value+'/'+size+'/'+algorythm;
		action = '/'+folder+image_params;
		update_froala_imageUpload();
	});

	$('.algorythm').change(function () {
		$('#edit_summary').attr("data-algorythm", this.value);
		read_data();
		image_params = '/'+crop+'/'+size+'/'+this.value;
		action = '/'+folder+image_params;
		update_froala_imageUpload();
	});
	
	//
	// Boostrap select setup with FA icon
	$('.selectpicker').selectpicker();
	// $('.togglebtn').bootstrapToggle();
	
	function checkUriRewriting(check) {
		var uri = $('#uri_wrapper');
		if (check) {
			uri.show();
			$('#uri').attr("required", "required");
		} else {
			uri.hide();
			$('#uri').attr("required", false);
		}
	}

	$('#uri_state').change(function() {
      checkUriRewriting($(this).prop('checked'));
    })
    checkUriRewriting($('#uri_state').prop('checked'));

	// 
	// scrollto chosen checkbox switcher
	// 
		function checkScrollTo(check) {
			if (check) {
				$('.scrolltofeatured_wrapper').hide();
			} else {
				$('.scrolltofeatured_wrapper').show();
			}
		}

		$('#selectmode').change(function() {
	      checkScrollTo($(this).prop('checked'));
	    })

		checkScrollTo($('#selectmode').prop('checked'));

		// postmax checker
		function checkMaxpost(check) {
			if (check) {
				$('.postmax_wrapper').hide();
			} else {
				$('.postmax_wrapper').show();
			}
		}
		$('#postselect').change(function() {
	      checkMaxpost($(this).prop('checked'));
	    })
		checkMaxpost($('#postselect').prop('checked'));

		// 
		// summary chosen checkbox switcher
		// 
		function checkSummary(check) {
			if (check) {
				$('#image-resize-summary').show();
				$('#froala-summary').show();
			} else {
				$('#image-resize-summary').hide();
				$('#froala-summary').hide();
			}
		}

		$('#summary_switch').change(function() {
	      checkSummary($(this).prop('checked'));
	    })
	    checkSummary($('#summary_switch').prop('checked'));

		// chosen featured posts
		function initChosenScrolltofeatured() {
			$("#scrolltofeatured").chosen({
				width:"200",
				// max_selected_options: $("#featured_max option:selected").val(),
				html_template: '{text} <img style="border:1px solid #666;padding:0px;margin-right:4px"  class="{class_name}" src="{url}" />'
			});
		}
 
		/* // funtio for limit featured with a select number
	  	$('select#featured_max').on('change', function (e) {
      		var valueSelected = $("#scrolltofeatured option:selected").length-this.value;
      		if (valueSelected > 0) {
	      		for (var i = 1; i < this.value+1; i++) {
	      			$("#scrolltofeatured option:selected").eq(i).removeAttr('selected');
	      		}
      		}
	  	    $("#scrolltofeatured").chosen("destroy");
	  	    initChosenScrolltofeatured();	  	    
	  	});
	  	*/
	  	
	  	// at chosen change look if featured then style css
	  	$('#scrolltofeatured').on('change', function(evt, params) {
	  	    var ID = params.selected;
	  	    var seek = 'ID'+ID;
	  	    
	  	    if ( $( 'select#scrolltofeatured option[value="'+ID+'"]' ).parent().attr('id') == "scrolltofeatured_featured" ) {
		  	    select = $("#scrolltofeatured_chosen .search-choice span:contains("+seek+")");
		  	    select.parent().addClass('featured');	  	    	
	  	    }

	  	});

	  	// look at featured post in chosen option and style css
	  	$("#scrolltofeatured").on("chosen:ready" , function() {
	     
		  	$( "select#scrolltofeatured option:selected" ).each(function() {
		  	    if ( $(this).parent().attr('id') == "scrolltofeatured_featured" ) {
		  			var ID = $(this).val();
		  	    	var seek = 'ID'+ID;
			  	    var select = $("#scrolltofeatured_chosen .search-choice span:contains("+seek+")");
			  	    select.parent().addClass('featured');	  	    	
		  	    }
	  	    });

	    });

	  	initChosenScrolltofeatured();

	/// end scrollto chosen checkbox
	////////////////////////////////

	$.get('/assets/data/fa-icons.yml', function(data) {
		var parsedYaml = jsyaml.load(data);
		$('#select').append('<option value="none">Aucun</option>');
		$.each(parsedYaml.icons, function(index, icon){
			$('#select').append('<option value="fa fa-' + icon.id + '"> &#x' + icon.unicode + " " + icon.id + '</option>');
		});

		$("#select").chosen({
			enable_split_word_search: true,
			search_contains: true 
		});
		$("#select").val($("#select").data('model-faicon'));
		$("#select").trigger("chosen:updated");
	});
	/* */

	/* categories chosen */
	$('#chosen-categories').chosen({});

	/* Detect any change of option*/
	$("#select").change(function(){
		$("#modelfaicon").val($(this).val());
	});

	updateinput();
	select_open = $('select#menutype option:selected').val();
	if (  select_open == 'uri' ) {
		var name = $('#form_name');
		var route = $('#route');
		name.bind("input", function() {
			uri = name.val().toLowerCase().replace(/[^a-zA-Z0-9\s]/g, "").replace(/ /g, "-");
			route.val('/cms/'+uri);
		});
	} else if ( select_open == 'url' ) {
		$('.froala').hide();
	}

	function updateinput() {
		var valueSelected = $('select#menutype :selected').val();
		var label=$('select#menutype :selected').parent().attr('label');
		var route = $('#route');

		if (label == 'Modules') {
			
			route.attr('readonly','readonly');
		}
		if (valueSelected == 'uri') {
			
			route.attr('readonly','readonly');
		}
	}

	// data module template on select change
	$('select#menutype').on('change', function (e) {
	    var valueSelected = this.value;
	    // $.parseJSON(string)
	    var menutype = $(this).data('modules');
	    var label = this.options[this.selectedIndex].parentNode.label;

	    var route = $('#route');
		// var fa = $('#fa');
		var name = $('#form_name');
		var target = $('#form_target');
		route.removeAttr('readonly');
		name.unbind( "input" );
		$('.froala').show();

		if (label == 'Modules') {

			name.val(valueSelected.charAt(0).toUpperCase()+valueSelected.slice(1));
			var module = menutype[valueSelected].route;
			route.val(module);
			target.val('_self');
			$("#select").val('fa fa-'+menutype[valueSelected].icon);
			$("#select").trigger("chosen:updated");
			// Set data to selected
 			$("#modelfaicon").val('fa fa-'+menutype[valueSelected].icon);
 			// setup route to read only
			route.attr('readonly','readonly');

			// update chosen-categories select along module (init)
			$('#chosen-categories option').prop('selected', false);
			$('#chosen-categories option').prop('disabled', true);
			$('#chosen-categories option.'+module).prop('disabled', false);
			// select all category from module :
				// $('#chosen-categories option.'+module).prop('selected', true);
			// Select only uncategorize :
				$('#chosen-categories option.uncategorized').prop('selected', true);
			// update choosen
			$("#chosen-categories").trigger("chosen:updated");			

		} else {

			target.val('_self');

			if (valueSelected == 'url') {

				route.val('http://');
				target.val('_blank');
				$('.froala').hide();

			} else {
				uri = name.val().toLowerCase().replace(/[^a-zA-Z0-9\s]/g, "").replace(/ /g, "-");
				route.val('cms/'+uri);
				route.attr('readonly','readonly');
				name.bind("input", function() {
					uri = name.val().toLowerCase().replace(/[^a-zA-Z0-9\s]/g, "").replace(/ /g, "-");
					route.val('cms/'+uri);
				});

			}

		}

	});

	function createInputBgselect(wrapper, value, data_default) {
		var input = document.createElement('INPUT');
		var picker;
        if (value == 'color') picker = new jscolor(input);
        wrapper.append(input);
        var dataSelecter = wrapper.data(value) == undefined ? '' : wrapper.data(value);
        if (value == 'color') {
        	picker.fromString( dataSelecter.length == 0 ? data_default : dataSelecter);
        } else {
        	wrapper.find('input').val( dataSelecter.length == 0 ? data_default : dataSelecter );
        }

		wrapper.find('input').addClass('form-control').attr("name", wrapper.data('type')+"data").attr("id", wrapper.data('type')+"data");
	}

	function setupInputSelect(valueSelected, wrapper) {

		switch(valueSelected) {
		    case "color":
		        data_default = '000000';
				createInputBgselect( wrapper, valueSelected, data_default );
		    break;
		    case "hexa":
		        data_default = '#';
				createInputBgselect( wrapper, valueSelected, data_default );
		    break;
		    case "video":
		        data_default = 'http://thenewcode.com/assets/videos/polina.mp4';
				createInputBgselect( wrapper, valueSelected, data_default );
		    break;
		    case "vimeo":
		        data_default = '178087547';
				createInputBgselect( wrapper, valueSelected, data_default );
		    break;
		}
	}

	//
	// theme setup
	// 
		// Load theme data
		
		setupInputSelect($('#logoselect option:selected').val(), $('#logodata_wrapper'));
		setupInputSelect($('#logo2select option:selected').val(), $('#logo2data_wrapper'));

		setupInputSelect($('#bgselect option:selected').val(), $('#bgdata_wrapper'));
		setupInputSelect($('#mediaselect option:selected').val(), $('#mediadata_wrapper'));
		setupInputSelect($('#bgsiderselect option:selected').val(), $('#bgsiderdata_wrapper'));
		setupInputSelect($('#navselect option:selected').val(), $('#navdata_wrapper'));
		setupInputSelect($('#navrightselect option:selected').val(), $('#navrightdata_wrapper'));
		
		setupInputSelect($('#uitextselect option:selected').val(), $('#uitextdata_wrapper'));
		setupInputSelect($('#uitexthoverselect option:selected').val(), $('#uitexthoverdata_wrapper'));
		setupInputSelect($('#uiblockhoverselect option:selected').val(), $('#uiblockhoverdata_wrapper'));
		setupInputSelect($('#uitextactiveselect option:selected').val(), $('#uitextactivedata_wrapper'));

		setupInputSelect($('#uisidertextselect option:selected').val(), $('#uisidertextdata_wrapper'));
		setupInputSelect($('#uisidertexthoverselect option:selected').val(), $('#uisidertexthoverdata_wrapper'));
		setupInputSelect($('#uisidertextactiveselect option:selected').val(), $('#uisidertextactivedata_wrapper'));

		// bg event
		$('#bgselect, #mediaselect, #logoselect, #logo2select, #navselect, #navrightselect, #bgsiderselect, #uitextselect, #uitexthoverselect, #uiblockhoverselect, #uitextactiveselect, #uisidertextselect, #uisidertexthoverselect, #uisidertextactiveselect').on('change', function (e) {
			var valueSelected = this.value;
			var data_default;
			var wrapper = $(this).next().next();
			wrapper.empty();
			setupInputSelect(valueSelected, wrapper);
		});

});