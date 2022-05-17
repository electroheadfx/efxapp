$(function () {

	//
	// Editor's setup
	// 
	function read_data() {
		froala_buttons = [ 'undo', 'redo', '|', 'formatUL','|', 'bold', 'italic', 'paragraphFormat', '|', 'insertHR', 'quote', 'align', 'color', '|', 'subscript', 'superscript', '|', 'insertLink', 'clearFormatting', '|', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '|', 'html', '|', 'fullscreen']; // 'savearticle',
		froala_buttons  = [ 'undo', 'redo', '|', 'bold', 'italic', 'paragraphFormat', 'fontSize', 'color', '|', 'insertHR', 'quote', 'align', '|', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'paragraphStyle', '|', 'emoticons','nowrapspace', 'wrapspace', '-', 'formatOL', 'formatUL', 'outdent', 'indent', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'clearFormatting', '|', 'html', '|', 'savearticle','|', 'fullscreen', '|'];
		// autosave desactived for cv
		// id 			= $('#edit_summary').attr("data-id");
		// save 		= $('#edit_summary').attr("data-save");
		id = undefined;
		save = undefined;
		
		crop 		= $('#edit_summary').attr("data-crop");
		size 		= $('#edit_summary').attr("data-size");
		folder 		= $('#edit_summary').attr("data-folder");
		algorythm 	= $('#edit_summary').attr("data-algorythm");
		upload 		= $('#edit_summary').attr("data-upload");
		todelete 	= $('#edit_summary').attr("data-delete");
		gallery 	= $('#edit_summary').attr("data-gallery");
	}


	//
	// Initialize start up
	// 
	 read_data();
	 editor_summary 	= $('#edit_summary');

	 image_params		= '/'+crop+'/'+size+'/'+algorythm;
	 action 			= '/'+folder+image_params;
	 load 				= '?index='+folder;

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
// alert (gallery+load);
// http://voguart.dev/efx/upload/images.json?index=cv

	 //
	 // summary editor
	 // 
	 
	 editor_summary.froalaEditor({
		toolbarInline: false,
		toolbarSticky: true,
		requestWithCORS: false,
		
		imageUploadURL: upload+action,
		imageManagerDeleteURL: todelete,
		// imageManagerLoadURL: 'http://voguart.dev/efx/upload/images.json?index=cv',
		imageManagerLoadURL: gallery+load,
		imageManagerToggleTags: true,

		imageParams: {id: "summary"},
		pastePlain: true,
		imageDefaultAlign: 'left',
		imageDefaultWidth: 100,
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
		imageResizeWithPercent: true,
		tabSpaces: 4,
		codeMirrorOptions: {
		   tabSize: 4
		},
		saveParams: {
		  id: (id != undefined ) ? id : null,
		  body: 'summary'
		},
		saveParam: 'summary',
		saveURL: (id != undefined ) ? save : null,
		enter: $.FroalaEditor.ENTER_BR,
		language: 'fr'
	 })

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
	
	// column
	// Boostrap select setup
	// 
	$('.selectpicker').selectpicker();

	$("#form_column").change(function(){
		select = $(this).val().replace('app-thumb.bootstrap.', '')
		$('#fr-column').removeClass().addClass($('#edit_summary').data('bootstrap-'+select));
	});


});