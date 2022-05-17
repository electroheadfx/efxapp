$(function () {

	var id,save,froala_buttons,froala_name_buttons,crop,size,folder,algorythm,upload,todelete,gallery;

	//
	// Editor's setup
	// 
	function read_data() {
		id 					= $('#edit_content').attr("data-id");
		save 				= $('#edit_content').attr("data-save");
		froala_buttons 		= [ 'undo', 'redo', '|', 'bold', 'italic', 'paragraphFormat', 'fontSize', 'color', '|', 'insertHR', 'align', '|', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'paragraphStyle', '|', 'emoticons','nowrapspace', 'wrapspace', '-', 'formatOL', 'formatUL', 'outdent', 'indent', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'clearFormatting', '|', 'html', '|', 'savearticle','|', 'fullscreen', '|'];
		froala_name_buttons = [ 'undo', 'redo', '|', 'paragraphFormat', '|', 'bold', 'italic', 'fontSize', 'color', '|', 'insertHR', 'quote', 'align', '|', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'paragraphStyle', '|', 'emoticons','nowrapspace', 'clearFormatting', '|', 'html', '|'];
		crop 				= $('#edit_summary').attr("data-crop");
		size 				= $('#edit_summary').attr("data-size");
		folder 				= $('#edit_summary').attr("data-folder");
		algorythm 			= $('#edit_summary').attr("data-algorythm");
		upload 				= $('#edit_summary').attr("data-upload");
		todelete 			= $('#edit_summary').attr("data-delete");
		gallery 			= $('#edit_summary').attr("data-gallery");
	}

	function update_froala_imageUpload() {

		editor_summary.each(function() {
	    	var instance = $(this).data('froala.editor');
			instance.opts.imageUploadURL = upload+action;
			instance.opts.imageManagerLoadURL = gallery+load;
		});

		editor_content.each(function() {
	    	var instance = $(this).data('froala.editor');
			instance.opts.imageUploadURL = upload+action;
			instance.opts.imageManagerLoadURL = gallery+load;
		});
	}

	//
	// Initialize start up
	// 
	 read_data();
	 var editor_summary = $('.edit_froala_summary');
	 var editor_content = $('.edit_froala_content');
	 var editor_name 	= $('.edit_froala_name');

	 var image_params		= '/'+crop+'/'+size+'/'+algorythm;
	 var action 			= '/'+folder+image_params;
	 var load 				= '?index='+folder;

	 var addimageNth = 0;
	 var activeAddimage = 0;
	 var addcropper = [];
	 var datacrop;
	 var crops = $("#form_crops").val();
	 var media = $('#my-slim').data('media');
	 // if ( $('.gallery-thumbs .glyphicon-move').length < 1 ) {
	 // 	$('.image-setup, .gallery-controls').hide();
	 // } 
	 
	 // close alert when click on page
	 $(document).click(function (event) {
	   $(".alert").hide();
	});
	 
	 $('#moreimage').hide();
	 if (media == 'video') {
		// for video view
		// get youtube or vimeo engine
		var engine = $('#form_enginevideo').val();
		// get Vimeo or youtube ID
		var id_video = $('#idvideo').val();
	}

	// setup tab
	$('.nav-tabs a[href="#setup"]').tab('show');

	// Move image upload froala setup HTML Node for content <-> summary
	$('.nav-tabs a[href="#cms_summary"]').click(function (e) {
		var el = $('#image-resize-summary');
	    if (! el.find('#setup-image-resize').length ) {
	    	$('#image-resize-content').find('#setup-image-resize').detach().appendTo( el );
	    }
	});
	$('.nav-tabs a[href="#cms_content"]').click(function (e) {
		var el = $('#image-resize-content');
	    if (! el.find('#setup-image-resize').length ) {
	    	$('#image-resize-summary').find('#setup-image-resize').detach().appendTo( el );
	    }
	});

	// Move crop setup and fullscreen for thumb<->gallery for gallery
	if (media == 'gallery') {
		$('.nav-tabs a[href="#thumb"]').click(function (e) {
			var el = $('#cropsetup_thumb');
		    if (! el.find('#cropsetup_form').length )
		    	$('#cropsetup_media').find('#cropsetup_form').detach().appendTo( el );

			var el = $('#fullscreen_thumb');
		    if (! el.find('#fullscreen_form').length )
		    	$('#fullscreen_media').find('#fullscreen_form').detach().appendTo( el );
		    
		});
		$('.nav-tabs a[href="#media"]').click(function (e) {
			var el = $('#cropsetup_media');
		    if (! el.find('#cropsetup_form').length )
		    	$('#cropsetup_thumb').find('#cropsetup_form').detach().appendTo( el );

			var el = $('#fullscreen_media');
		    if (! el.find('#fullscreen_form').length )
		    	$('#fullscreen_thumb').find('#fullscreen_form').detach().appendTo( el );
		    
		});
	}
	//

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
		  text: 'Laurent Marques efx design',
		  href: 'http://efxdesign.fr',
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
	 // summary and localisations
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
        	// // 'froalaEditor.image.uploaded'
        	// Return false if you want to stop the image upload.
        	
      	});

	 });

	   //
	   // content editor
	   // 
	   // content and localisations
	   	 editor_content.each(function() {
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
        	// // 'froalaEditor.image.uploaded'
        	// Return false if you want to stop the image upload.
        	
      		});
	   });

	   // name and localisations
	    editor_name.each(function() {
		    var section = $(this).parent().parent().parent();
		    $(this).froalaEditor({
			   	toolbarInline: false,
			   	toolbarSticky: true,
			   	requestWithCORS: false,
			   	pastePlain: true,
			   	toolbarButtons: froala_name_buttons,
			   	toolbarButtonsMD: froala_name_buttons,
			   	toolbarButtonsSM: froala_name_buttons,
			   	toolbarButtonsXS: froala_name_buttons,
			   	inlineStyles: InlineStyle,
			   	linkList: LinkList,
			   	paragraphStyles: ParagraphStyles,
			   	dragInline: false,
			   	tabSpaces: 4,
			   	codeMirrorOptions: {
			   	   tabSize: 4
			   	},
			   	enter: $.FroalaEditor.ENTER_BR,
			   	language: $('#edit_summary').data('lang')
		    });
	    });
	    // if ( editor_name.froalaEditor('html.get') == '' ) {
	    // 	editor_name.froalaEditor('html.set', '<h1></h1>');
	    // }

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
	// Boostrap select setup
	// 
	$('.selectpicker').selectpicker();

	// Setup SLIM JS
	// 

	var crop = $('#my-slim').data('crop').split(',');
	var min_thumb_width = $('#my-slim').data('thumb-width');
	var min_thumb_height = $('#my-slim').data('thumb-height');
	var select 	= $("#form_column").val().replace('app-thumb.bootstrap.', '');
	var thumb_width = $('#my-slim').data('thumb-'+select+'-width');
	var thumb_height = $('#my-slim').data('thumb-'+select+'-height');

	var size_width = $('#my-slim').data('webhd-width');
	var size_height = $('#my-slim').data('webhd-height');

	var crop_preset = 'free';
	var orientation;
	var orientation_hory = true;

	/*SLIM Master image */

		var slim_rotation = $('#my-slim').data('rotation');
		var slim_service = $('#my-slim').data('service');
		var slim_service_add = $('#my-slim').data('serviceadd');
		var slim_postid = $('#my-slim').data('meta-post-id');
		var slim_postslug = $('#my-slim').data('meta-post-slug');

		function setup_ratio() {

			if ( crops == 'independant_crop' ) {
				// independant crop : free
				$(".slim-add").each(function() {
					var nth = $(this).data("nth");
					$('#my-slim-add'+nth).slim('ratio', crop_preset);
					$('#my-slim-add'+nth).slim('setRatio', crop_preset, function(data) {
						// console.log('SLIM #my-slim-add'+nth+' crop updated');
					});
				});
			} else {
				$(".slim-add").each(function() {
					var nth = $(this).data("nth");
					var w = $('#my-slim').data('cover-width');
					var h = $('#my-slim').data('cover-height');
					$('#my-slim-add'+nth).slim('ratio', w+":"+h);
					$('#my-slim-add'+nth).slim('setRatio', w+":"+h, function(data) {
						// console.log('SLIM #my-slim-add'+nth+' crop updated');
					});
				});
			}

		}
		
		// if ( crops == 'fitprimary_crop' ) {
		// 	$(".slim-add").each(function() {
		// 		var nth = $(this).data("nth");
		// 		$('#my-slim-add'+nth).slim('setRatio', w+":"+h, function(data) {
		// 			// console.log('SLIM #my-slim-add'+nth+' crop updated');
		// 		});
		// 	});
		// }

		function setup_ratio_image(id) {

			if ( crops == 'independant_crop' ) {
				// independant crop : free
				$('#my-slim-add'+id).slim('ratio', crop_preset);
			} else {
				$('#my-slim-add'+id).slim('ratio', $('#my-slim').data('cover-width')+":"+$('#my-slim').data('cover-height'));
			}

		}

		// create SLIM master Cropper object
		var $cropper = $('#my-slim').slim({

			didLoad: function(file, image, meta) {
				// test here before upload
				return true;
		    },
		    didEdit: function(data) {
		    	$('#my-slim').slim('ratio', crop_preset);
		    },
		  //   didCancel: function(data) {
		  //   	var w = $('#my-slim').data('cover-width');
				// var h = $('#my-slim').data('cover-height');
				// if (w !== undefined || h !== undefined) {
				// 	var crop_preset = w+':'+h;
		  //   		$('#my-slim').slim('ratio', crop_preset);
		  //   		console.log('w: '+w+' - h: '+h);
		  //   	} else {
		  //   		console.log('empty');
		  //   	}
		  //   },
			didConfirm: function(data) {
				// Show add image
				var w = data.output.width;
				var h = data.output.height;
					$('#my-slim').attr('data-cover-width', w);
					$('#my-slim').attr('data-cover-height', h);
					/* // auto crop all gallery image if fitprimary_crop
						if ( crops == 'fitprimary_crop' ) {
							$(".slim-add").each(function() {
								var nth = $(this).data("nth");
								$('#my-slim-add'+nth).slim('setRatio', w+":"+h, function(data) {
									// console.log('SLIM #my-slim-add'+nth+' crop updated');
								});
							});
						}
					*/
					$('.addimage').show();
				//efx setup store ratio to data-ratio
				$('#my-slim').attr('data-ratio', w+":"+h);
			},
		    forceMinSize:false,
		    ratio: crop_preset,
		    state: 'preview',
		    willRemove: function imageWillBeRemoved(data, remove) {

			    if (window.confirm("Est-ce que vous etes sur de supprimer l'image ?")) {
			        
			        id = $('#my-slim').data('imageid');

			        $.ajax({
			          method: "POST",
			           url: "/efx/upload/slim_remove_gallery"+"/"+id+"/"+media
			        })
			          .done(function() {
			            $('.addimage').hide();
			        	remove();
			          });
			    }
			},
		    minSize: {
		        width: min_thumb_width, // thumb_width,
		        height: min_thumb_height, // thumb_height
		    },
		    statusImageTooSmall: "L'image est trop petite, la taille minimun est de : $0 pixels",
		    size: {
		    	width: thumb_width,
		    	height: thumb_height
		    },
		    crop: {
		        x: crop[0],
		        y: crop[1],
		        width: crop[2],
		        height: crop[3]
		    },
		    filterSharpen: 20,
		    rotation: slim_rotation,
		    service: slim_service,
		    download: true,
		    push: true,
		    instantEdit: true,
		    post: ["input", "output", "actions"],
		    label: 'Glissez et déposer une image ici.',
		    buttonConfirmLabel: 'Ok',
		    meta: {
		        postId: slim_postid,
		        postSlug: slim_postslug
		    }
		    
		});

		// remove addimage if SLIM is empty
		// if ($cropper.data('state') == "empty" ) $('.addimage').hide();

	/* end SLIM Master */


	// bootstrap-select API here : https://silviomoreto.github.io/bootstrap-select/options/#events
	// thumb size select
	$("#form_column").on('hidden.bs.select', function (e) {

		select 	= $(this).val().replace('app-thumb.bootstrap.', '');
		width 	= $('#my-slim').data('thumb-'+select+'-width');
		height 	= $('#my-slim').data('thumb-'+select+'-height');
		$('#my-slim').slim('size', { width:width, height:height });
		$('#my-slim').slim('setSize', { width:width, height:height }, function(data) {
		});

	});

	// crop presets select
	$("#form_crop_presets").on('hidden.bs.select', function (e) {

		crop_preset = $(this).val();
		if ( $("#orientation:checked").val() == undefined && crop_preset != 'free') {
			val = crop_preset.split(":");
			crop_preset = val[1]+':'+val[0];
			orientation_hory = false;
		}

	});

	// crop presets select
	$("#orientation").on('change', function (e) {

		orientation = $("#orientation:checked").val() == undefined ? 'vertical' : 'horyzontale';
		crop_preset = $("#form_crop_presets").val();
		if ( orientation_hory == true && orientation == 'vertical' ) {
			crop_preset = $("#form_crop_presets").val();
			if ( crop_preset != 'free' ) {
				val = crop_preset.split(":");
				crop_preset = val[1]+':'+val[0];
			}
			orientation_hory = false;
		}

		if ( orientation_hory == false && orientation == 'horyzontale' ) {
			crop_preset = $("#form_crop_presets").val();
			orientation_hory = true;
		}

	});
	$("#form_crops").on('hidden.bs.select', function (e) {
		crops = $(this).val();
	});

	$('#run_crop').on("click", function(event) {

		event.preventDefault();
		if (window.confirm("Est-ce que vous etes sur de recader toutes les images de la galerie (effacant les cadrages actuels) ?")) {
			setup_ratio();
		}

	});

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

	// 
	// border checkbox switcher for summary
	// 
	function checkBorder(check) {
		if (check) {
			$('#bordercolorfield').show();
		} else {
			$('#bordercolorfield').hide();
		}
	}

	$('#postborder').change(function() {
      checkBorder($(this).prop('checked'));
    })

	checkBorder($('#postborder').prop('checked'));

	// 
	// border checkbox switcher for content
	// 
	function checkBorder(check) {
		if (check) {
			$('#content_bordercolorfield').show();
		} else {
			$('#content_bordercolorfield').hide();
		}
	}

	$('#contentborder').change(function() {
      checkBorder($(this).prop('checked'));
    })

	checkBorder($('#contentborder').prop('checked'));

		// 
		// content chosen checkbox switcher
		// 
		function checkContent(check) {
			if (check) {
				$('#image-resize-content').show();
				$('#froala-content').show();
			} else {
				$('#image-resize-content').hide();
				$('#froala-content').hide();
			}
		}

		$('#content_switch').change(function() {
	      checkContent($(this).prop('checked'));
	    })

		checkContent($('#content_switch').prop('checked'));

		// 
		// 
		// BG and Border post -->
		// 
		// 

		// functions for color input/select -->
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
				}
			}
		// <-- end color input/select functions

		// init color select
		setupInputSelect($('#postbgselect option:selected').val(), $('#postbgdata_wrapper'));
		setupInputSelect($('#postborderselect option:selected').val(), $('#postborderdata_wrapper'));

		setupInputSelect($('#contentbgselect option:selected').val(), $('#contentbgdata_wrapper'));
		setupInputSelect($('#contentborderselect option:selected').val(), $('#contentborderdata_wrapper'));

		// bg event for select change
		$('#postbgselect, #postborderselect, #contentbgselect, #contentborderselect').on('change', function (e) {
			var valueSelected = this.value;
			var data_default;
			var wrapper = $(this).next().next();
			wrapper.empty();
			setupInputSelect(valueSelected, wrapper);
		});
	
	// <-- End BG and Border post

	//
	// ########### GALLERY ################# //
	// 
	
	if (media == 'gallery') {

		/* SLIM Add images */

		$(".slim-add").each(function() {
			
			addimageNth = $(this).data("nth");

			imagecrop = $('#my-slim-add'+addimageNth).data('crop').split(',');
			var slim_service_images = $('#my-slim-add'+addimageNth).data('service');

			addcropper[addimageNth] = $('#my-slim-add'+addimageNth).slim({
					// ratio: $('#my-slim').data("cover-width")+":"+$('#my-slim').data("cover-height"),
				    willRemove: function imageWillBeRemoved(data, remove) {

					    if (window.confirm("Est-ce que vous etes sur de supprimer l'image ? ")) {

					        slimObj = this._element.id;		        		        
					        id = $('#'+slimObj).data('imageid');
					        nth = $('#'+slimObj).data('nth');
					        $.ajax({
					          method: "POST",
					           url: "/efx/upload/slim_remove_image_by_id"+"/"+id+"/gallery"
					        })
					          .done(function() {
					            
					        	$('#my-slim-add'+nth).parent().remove();

					          });
					    }
					},
					didEdit: function(data) {
						//efx setup data-ratio
						var addSlimID = this.data.meta.imageNth;
						setup_ratio_image(addSlimID);
					},
					// didCancel: function(data) {
						// var addSlimID = this.data.meta.imageNth;
						// need to create cover data @ init see addimage function!
						// var w = $('#my-slim-add'+addSlimID).data('cover-width');
						// var h = $('#my-slim-add'+addSlimID).data('cover-height');
						// 	if (w !== undefined || h !== undefined) {
						// 		var crop_preset = w+':'+h;
						// 		$('#my-slim-add'+addSlimID).slim('ratio', w+":"+h);
						// 		console.log('w: '+w+' - h: '+h);
						// 	} else {
						// 		console.log('empty');
						// 	}
					// },
	    			didConfirm: function(data) {
	    				// Show add image
	    				var w = data.output.width;
	    				var h = data.output.height;
	    				var addSlimID = this.data.meta.imageNth;
						$('#my-slim-add'+addSlimID).attr('data-cover-width', w);
						$('#my-slim-add'+addSlimID).attr('data-cover-height', h);
	    				$('#my-slim-add'+addSlimID).attr('data-ratio', w+":"+h);
	    			},
					rotation: slim_rotation,
					service: slim_service_images,
				    minSize: {
				        width: min_thumb_width, // thumb_width,
				        height: min_thumb_height, // thumb_height
				    },
				    statusImageTooSmall: "L'image est trop petite, la taille minimun est de : $0 pixels",
				    // size: {
				    // 	width: thumb_width,
				    // 	height: thumb_height
				    // },
				    crop: {
				        x: imagecrop[0],
				        y: imagecrop[1],
				        width: imagecrop[2],
				        height: imagecrop[3]
				    },
					download: true,
					push: true,
					instantEdit: true,
					post: ["input", "output", "actions"],
					label: 'Glissez et déposer une image ici.',
					buttonConfirmLabel: 'Ok',
					didUpload: function didUpload(err, data, res) {
						if (err == null) {
							$('.slim-loader').css('opacity',0);
						}
					},
					// slimObj = this._element.id;
					// setup meta with setMeta : $(selector).slim('meta', { postId: slim_postid, postSlug: slim_postslug, imageNth: $('#'+slimObj).data('nth') });
					meta: {
					    postId: slim_postid,
					    postSlug: slim_postslug,
					    imageNth: addimageNth,
					}
			});
			$('#moreimage').show();
		});

		// add new addimage SLIM on fly

		$('.addimage').on("click", function(event) {
			
			event.preventDefault();
			$('#moreimage').show();

			if ($('#my-slim-add'+addimageNth).data('state') != "empty" ) {

				addimageNth ++;

				var wrap_addimage = $('<div></div>', {'class': 'col-md-3 glyphicon-move-none'});
				var span_move = $('<span class="fa fa-arrows" > Image '+addimageNth+'</span>');
				
				var slim_addimage = $('<div></div>', {'id': 'my-slim-add'+addimageNth, 'class': 'slim-add', 'data-nth': addimageNth});		
				// var input_addimage = $('<input/>', {'type': 'file', 'class': 'form-control input-slim-add'});
				// 
				// <div class="col-md-3 glyphicon-move">
		         // <span class="fa fa-arrows"> Image <?= $image->nth ?></span>
				
				var new_nth = addimageNth; 

				wrap_addimage.append(span_move);
				wrap_addimage.append(slim_addimage);
				$( "#moreimage .gallery-thumbs" ).append( wrap_addimage );

				// data-crop= "<?= $slimCrop ?>"
				// 
				var ratio = $('#my-slim').data('ratio').toString();
				
				addcropper[addimageNth] = $('#my-slim-add'+addimageNth).slim({

				    willRemove: function imageWillBeRemoved(data, remove) {

					    if (window.confirm("Est-ce que vous etes sur de supprimer l'image ? ")) {

					        $.ajax({
					          method: "POST",
					           url: "/efx/upload/slim_remove_image_by_nth"+"/"+new_nth+"/"+slim_postid+"/gallery"
					        })
					          .done(function() {
					            
					            // $('.gallery-thumbs').children().length < 1
					            // $('.image-setup, .gallery-controls').hide();
					            // $('#moreimage').hide();
					        	$('#my-slim-add'+new_nth).parent().remove();

					          });
					    }

					},
					didEdit: function(data) {
						//efx setup data-ratio
						var addSlimID = this.data.meta.imageNth;
						setup_ratio_image(addSlimID);
					},
					// didCancel: function(data) {
						// var addSlimID = this.data.meta.imageNth;
						// need to create cover data @ init see addimage function!
						// var w = $('#my-slim-add'+addSlimID).data('cover-width');
						// var h = $('#my-slim-add'+addSlimID).data('cover-height');
						// 	if (w !== undefined || h !== undefined) {
						// 		var crop_preset = w+':'+h;
						// 		$('#my-slim-add'+addSlimID).slim('ratio', w+":"+h);
						// 		console.log('w: '+w+' - h: '+h);
						// 	} else {
						// 		console.log('empty');
						// 	}
					// },
				    didConfirm: function(data) {
				    	var w = data.output.width;
				    	var h = data.output.height;
						var addSlimID = this.data.meta.imageNth;
						$('#my-slim-add'+addSlimID).attr('data-cover-width', w);
						$('#my-slim-add'+addSlimID).attr('data-cover-height', h);
						$('#my-slim-add'+addSlimID).attr('data-ratio', w+":"+h);
						$('.image-setup, .gallery-controls').show();
				    },
					rotation: slim_rotation,
					service: slim_service_add+'/**NEWIMAGE**/'+new_nth+'/'+slim_postid,
				    minSize: {
				        width: min_thumb_width, // thumb_width,
				        height: min_thumb_height, // thumb_height
				    },
				    statusImageTooSmall: "L'image est trop petite, la taille minimun est de : $0 pixels",
				    // size: {
				    // 	width: thumb_width,
				    // 	height: thumb_height
				    // },
					download: true,
					push: true,
					instantEdit: true,
					post: ["input", "output", "actions"],
					label: 'Glissez et déposer une image ici.',
					buttonConfirmLabel: 'Ok',
					didUpload: function didUpload(err, data, res) {
						if (err == null) {
							$('.slim-loader').css('opacity',0);
						}
					},
					meta: {
					    postId: slim_postid,
					    postSlug: slim_postslug,
					    imageNth: addimageNth,
					}
				});
				//efx setup data-ratio
				setup_ratio_image(addimageNth);
				// $("html,body").animate({ scrollTop: $('#my-slim-add'+addimageNth).offset().top }, "slow");
			}
		});

		/*  Fix slim loader after update : $('.slim-loader').css('opacity',0);
		*/

		/* End SLIM add images */


		// List with handle
		Sortable.create(moreimage, {
		  handle: '.glyphicon-move',
		  animation: 150,
		  onEnd: function (evt) {

				// evt.oldIndex;  // element's old index within parent
				// evt.newIndex;  // element's new index within parent
				var list = '';
				var i = 0;
				$('.slim-add').each(function() { 
					// console.log();
					if (i > 0) {
						list = list + ',' + $(this).data('imageid');
					} else {
						list = $(this).data('imageid');
					}
					i++;
				})
				console.log(list);
				$.ajax({
					method: "POST",
					url: "/media/backend/api/sortgallery/"+list
			    })
			}
		});

	}

	//
	// ########### SKETCHFAB ################# //
	// 

	if (media == 'sketchfab') {

		$('#validatesketchfab').on('click', function (e) {
			$('#sketchfabmodal').modal('toggle');
		});

		$('#checksketchfab').on('click', function(e) {
			
			e.stopPropagation();

			// empty code
			$('#sketchfabcode').empty();

			id_sketchfab = $('#idsketchfab').val();
			code='<iframe id="sketchfab-viewer" class="sketchframe" src="" width="600" height="300" ></iframe>';
			$('#sketchfabcode').append(code);

			/* sketchfab init */

			  // model = $(this).data('sketchfab');
			  model = $('#idsketchfab').val();
			  // API version
			  version = '1.0.0';
			  // The iframe
			  sketch = document.getElementById( 'sketchfab-viewer' );

			  // The API client object
			  client = new Sketchfab( version, sketch );

			  // load the sketchfab model
			  client.init( model, {
			      success: function onSuccess(api) {
				      api.start();
		              $('#sketchfabmodal').modal('show');
				  },
			      error: function onError() {
				  	  // put here the modal with the error !!!
				      alert( 'Sketchfab API Error!' );
				  }
			  });

			/* */

		});

	}


	//
	// ########### VIDEO ################# //
	// 

	if (media == 'video') {

	    $("#idvideo").on("change paste keyup", function() {
	    	id= $('#idvideo').val();
			$('#checkvideo').data('vimeoidvalidate','false'); 
		});

		$( "#form_enginevideo" ).change(function() {
		  	id= $('#idvideo').val();
			$('#checkvideo').data('vimeoidvalidate','false');
		});
		
		$('#cancelvimeo').on('click', function (e) {
			$('#checkvideo').data('vimeoidvalidate','false');
		});

		$('#validatevimeo').on('click', function (e) {
			$('#checkvideo').data('vimeoidvalidate','true');
			$('#vimeomodal').modal('toggle');
		});


		$('#checkvideo').on('click', function(e) {
			
			e.stopPropagation();

			$.ajaxSetup({
				statusCode : {
				     // called on `$.get()` , `$.post()`, `$.ajax()`
				     // when response status code is `404`
				    404 : function (jqxhr, textStatus, errorThrown) {
				    	if (engine == 'vimeo') {
							alert("Prière de corriger l'ID Viméo qui n'est pas correcte.");
				    	} else {
							alert("Prière de corriger l'ID youtube qui n'est pas correcte.");
				    	}
					},
				    200 : function (jqxhr, textStatus, errorThrown) {
						$('#vimeocode').empty();
				    	if (engine == 'vimeo') {
							code='<iframe src="//player.vimeo.com/video/'+id_video+'?api=1&player_id=vimeoplayer&title=0&amp;byline=0&amp;portrait=0" name="vimeoplayer" id="nofocusvideo" width="615" height="346" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
				    	} else {
							code='<iframe width="560" height="315" src="https://www.youtube.com/embed/'+id_video+'?ecver=1" frameborder="0" allowfullscreen></iframe>';
						}
						$('#vimeocode').append(code);
						$('#vimeomodal').modal('show');
				    }
				}
			 });
			// get youtube or vimeo engine
			engine = $('#form_enginevideo').val();
			// get Vimeo or youtube ID
			id_video = $('#idvideo').val();

			// vimeo
			if (engine == 'vimeo') {

				$.get("/efx/upload/testvimeo/"+id_video);

			// youtube
			} else {

				$.get("/efx/upload/testyoutube/"+id_video);

			}
		});
	}
	// ########### END VIDEO ################# //
	
});