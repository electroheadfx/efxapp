<?php
  
//-----------------------------------------------
// Assets module declarations
//-----------------------------------------------/

return [

	//-----------------------------------------------
	// backend and frontend js and css declarations >
	//-----------------------------------------------

	"template" => [

		// backend js declarations start here :
		"js" => [


		],

		// backend css declarations start here :
		"css" => [


		]
		
	],
	
	//-----------------------------------------------
	// frontend js and css declarations >
	//-----------------------------------------------

	"frontend" => [

		// frontend js declarations
		"js" => [

			"gallery" => [
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"script:isotope-gallery",
			],

			"sendmail/index" => [
				"libs/bootstrap/validator",
				"frontend/sendmail",
			],

		],

		// frontend css declarations
		"css" => [

			"home" => [
				'custom/froala_style',
				'froala_editor/froala_efx',
				'plyr',
			],

			"home" => [
				// "slider",
			],

			"sendmail/index" => [
				"animate"
			],

		]

	],


	//-----------------------------------------------
	// backend js and css declarations >
	//-----------------------------------------------

	"backend" => [

		// backend js declarations start here :
		"js" => [

			"home" => [
				// "script:backend/admin",
			],

			"category" => [
				"sortable",
				"script:backend/sort_category",
			],

			"category/add" => [
				"libs/yamjs/js-yaml",
				"libs/jquery/chosen-jquery",
				"libs/jscolor",
				"libs/bootstrap-toggle",
				"backend/bootstrap-select",
				"script:backend/category-post",
			],

			// "cv" => [
			// 	"sortable",
			// 	"script:backend/sort_post",
			// ],

			// "cv/add" => [
			// 	"backend/bootstrap-select",
			// 	"codemirror",
			// 	"xml",
			// 	"froala_editor/froala_editor-pkgd",
			// 	"slim-jquery",
			// 	"script:backend/gallery-post",
			// ],

			#############################
			####### PROJECT MODULE ######
			#############################
			
			#------------------------#
			### MENU backend JS assets #
			#------------------------#
			"menu" => [
				"sortable",
				"libs/clipboard",
				"script:backend/sort_menu",
			],

			"menu/add" => [
				"libs/yamjs/js-yaml",
				"libs/jquery/chosen-jquery",
				"libs/jscolor",
				"libs/bootstrap-toggle",
				"backend/bootstrap-select",
				"libs/jquery/ImageSelect-jquery",
				"codemirror",
				"xml",
				"froala_editor/froala_editor-pkgd",
				"froala_editor/languages/fr",
				"script:backend/menu-post",
			],

		],

		// backend css declarations start here :
		"css" => [

			"menu/add" => [
				// "froala_editor" => "css_feditor", // assets de froala dans le dossier "froala_editor" rendu en prod dans un fichier css_editor.css
				"codemirror",
				"froala_editor/froala_editor-pkgd",
				"custom/froala_style",
				"slim",
				"jquery/chosen",
				"bootstrap-toggle",
				"ImageSelect",
			]

		]

	]


];