<?php

// get default route
$default_assets_route = explode('/', \Config::get('application.setup.site.default'))[0];

//-----------------------------------------------
// Assets module declarations
//-----------------------------------------------/

return [

	//-----------------------------------------------
	//
	// backend and frontend js and css declarations >
	// 
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
	//
	// frontend js and css declarations >
	// 
	//-----------------------------------------------

	"frontend" => [

		// frontend js declarations
		"js" => [

			"home" => 'frontend.js.'.$default_assets_route,

			###############################################
			### video for root & video frontend JS assets
			###############################################

			"video" => [
				// "libs/plyr/2.0/plyr", - setup in Post controller
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"libs/lazysizes/lazysizes",
				"libs/jquery/expander-jquery",
				"script:frontend/isotope-media",
			],

			##############################
			### gallery frontend JS assets
			##############################
			"gallery" => [
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"libs/lazysizes/lazysizes",
				"libs/jquery/expander-jquery",
				// "libs/reveal",
				// "libs/isotope/flickity-pkgd", // flickity slider - setup in Post controller
				// "libs/isotope/fullscreen", // flickity fullscreen feature - setup in Post controller
				// "libs/isotope/hash", // flickity hash feature
				"script:frontend/isotope-media",
			],

			##############################
			### CMS frontend JS assets
			##############################
			"cms" => [
				// "libs/plyr/2.0/plyr",
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"libs/lazysizes/lazysizes",
				// "libs/sketchfab/sketchfab-viewer",
				"libs/jquery/expander-jquery",
				// "libs/isotope/flickity-pkgd", // flickity slider
				// "libs/isotope/fullscreen", // flickity fullscreen feature
				"script:frontend/isotope-media",
			],

			##############################
			### PRODUCT frontend JS assets
			##############################
			"p" => 'frontend.js.cms',
			
			##############################
			### sketchfab frontend JS assets
			##############################
			"sketchfab" => [
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"libs/lazysizes/lazysizes",
				"libs/jquery/expander-jquery",
				"script:frontend/isotope-media",
			],

			##############################
			### 3D frontend JS assets
			##############################
			"3d" => [
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"libs/lazysizes/lazysizes",
				"libs/jquery/expander-jquery",
				"script:frontend/isotope-media",
			],

			##########################
			### CV frontend JS assets
			##########################
			"cv" => [
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"script:frontend/isotope-cv",
			],

		],

		// frontend css declarations
		"css" => [

			############################
			### Root frontend CSS assets
			############################

			"_root_" => [
				'custom/froala_style',
			],

			"home" => 'frontend.css.'.$default_assets_route,

			"video" => [
				'plyr',
			],

			"gallery" => [
				'flickity', // CSS flexslider slider
				'fullscreen', // CSS fullscreen flexslider actived
				'custom/flickity', // Custom CSS flexslider slider
			],

			"cms" => [
				'plyr',
				'flickity', // CSS flexslider slider
				'fullscreen', // CSS fullscreen flexslider actived
				'custom/flickity', // Custom CSS flexslider slider
			],

			##############################
			### PRODUCT frontend JS assets
			##############################
			"p" => 'frontend.css.cms',
			
			"sketchfab" => [],

			"3d" => [],

			"cv" => [],

		]

	],


	//-----------------------------------------------
	//
	// backend js and css declarations >
	// 
	//-----------------------------------------------

	"backend" => [

		// backend js declarations start here :
		"js" => [

			"home" => [
				// "script:backend/admin",
			],

		###########################
		####### MEDIA MODULE ######
		###########################
			
			#---------------------------#
			### video backend JS assets #
			#---------------------------#
			#
			// gallery images in grid mode
			"video" => [
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"libs/jquery/chosen-jquery",
				"libs/jquery/js-cookie",
				"libs/bootstrap-toggle",
				"libs/clipboard",
				"libs/lazysizes/lazysizes",
				"sortable",
				'script:backend/admin_grid' // admin contains ajaxlist, tooltip, isotope and sort list !
			],

			// gallery images in list mode
			"video/index" => [
				"sortable",
				"libs/jquery/js-cookie",
				"libs/lazysizes/lazysizes",
				"script:backend/admin_list",
			],

			"video/preview" => 'frontend.js.video',

			"video/add" => [
				"backend/bootstrap-select",
				"codemirror",
				"xml",
				"froala_editor/froala_editor-pkgd",
				"froala_editor/languages/fr",
				"slim-jquery",
				"libs/jscolor",
				"libs/bootstrap-toggle",
				"script:backend/post",
			],

			#-----------------------------#
			### gallery backend JS assets #
			#-----------------------------#

			// gallery images in grid mode
			"gallery" => [
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"libs/jquery/chosen-jquery",
				"libs/jquery/js-cookie",
				"libs/bootstrap-toggle",
				"libs/clipboard",
				"sortable",
				"libs/lazysizes/lazysizes",
				'script:backend/admin_grid' // admin contains ajaxlist, tooltip, isotope and sort list !
			],

			// gallery images in list mode
			"gallery/index" => [
				"sortable",
				"libs/jquery/js-cookie",
				"libs/lazysizes/lazysizes",
				"script:backend/admin_list",
			],
			// "gallery/preview" => 'frontend.js.gallery',
			"gallery/preview" => [
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"libs/lazysizes/lazysizes",
				"libs/jquery/expander-jquery",
				"libs/jquery/js-cookie",
				// "script:frontend/isotope-media",
				"script:backend/admin_preview",
			],

			"gallery/add" => [
				"backend/bootstrap-select",
				"sortable",
				"codemirror",
				"xml",
				"froala_editor/froala_editor-pkgd",
				"froala_editor/languages/fr",
				"slim-jquery",
				"libs/jscolor",
				"libs/bootstrap-toggle",
				"script:backend/post",
			],

			#-----------------------------#
			### CMS backend JS assets #
			#-----------------------------#
			#
			// cms images in grid mode
			"cms" => [
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"libs/jquery/chosen-jquery",
				"libs/jquery/js-cookie",
				"libs/bootstrap-toggle",
				"libs/clipboard",
				"sortable",
				"libs/lazysizes/lazysizes",
				'script:backend/admin_grid' // admin contains ajaxlist, tooltip, isotope and sort list !
			],
			// cms images in list mode
			"cms/index" => [
				"sortable",
				"libs/jquery/js-cookie",
				"libs/lazysizes/lazysizes",
				"script:backend/admin_list",
			],
			"cms/preview" => 'frontend.js.cms',

			"cms/add" => [
				"backend/bootstrap-select",
				"codemirror",
				"xml",
				"froala_editor/froala_editor-pkgd",
				"froala_editor/languages/fr",
				"slim-jquery",
				"libs/jscolor",
				"libs/bootstrap-toggle",
				"script:backend/post",
			],

			#-----------------------------#
			### sketchfab backend JS assets #
			#-----------------------------#

			// sketchfab images in grid mode
			"sketchfab" => [
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"libs/jquery/chosen-jquery",
				"libs/jquery/js-cookie",
				"libs/bootstrap-toggle",
				"libs/clipboard",
				"sortable",
				"libs/lazysizes/lazysizes",
				'script:backend/admin_grid' // admin contains ajaxlist, tooltip, isotope and sort list !
			],

			// sketchfab images in list mode
			"sketchfab/index" => [
				"sortable",
				"libs/jquery/js-cookie",
				"libs/lazysizes/lazysizes",
				"script:backend/admin_list",
			],
			"sketchfab/preview" => 'frontend.js.sketchfab',

			"sketchfab/add" => [
				"backend/bootstrap-select",
				"codemirror",
				"xml",
				"froala_editor/froala_editor-pkgd",
				"froala_editor/languages/fr",
				"slim-jquery",
				"libs/sketchfab/sketchfab-viewer",
				"libs/jscolor",
				"libs/bootstrap-toggle",
				"script:backend/post",
			],

			#-----------------------------#
			### 3D backend JS assets #
			#-----------------------------#

			// sketchfab images in grid mode
			"3d" => [
				"libs/isotope/isotope-pkgd",
				"libs/isotope/packery-mode-pkgd",
				"libs/jquery/chosen-jquery",
				"libs/jquery/js-cookie",
				"libs/bootstrap-toggle",
				"libs/clipboard",
				"sortable",
				"libs/lazysizes/lazysizes",
				'script:backend/admin_grid' // admin contains ajaxlist, tooltip, isotope and sort list !
			],

			// 3d images in list mode
			"3d/index" => [
				"sortable",
				"libs/jquery/js-cookie",
				"libs/lazysizes/lazysizes",
				"script:backend/admin_list",
			],
			"3d/preview" => 'frontend.js.3d',

			"3d/add" => [
				"backend/bootstrap-select",
				"codemirror",
				"xml",
				"froala_editor/froala_editor-pkgd",
				"froala_editor/languages/fr",
				"slim-jquery",
				// "libs/sketchfab/3d-viewer",
				"libs/jscolor",
				"libs/bootstrap-toggle",
				"script:backend/post",
			],

			#------------------------#
			### CV backend JS assets #
			#------------------------#
			"cv" => [
				"sortable",
				// "script:backend/ajaxlist",
				"script:backend/sort_cv",
			],

			"cv/add" => [
				"backend/bootstrap-select",
				"codemirror",
				"xml",
				"froala_editor/froala_editor-pkgd",
				"froala_editor/languages/fr",
				"script:backend/cv-post",
			],

		],

		// backend CSS declarations start here :
		"css" => [

			############################
			### video backend CSS assets
			############################
			"video" => [
				// "jquery/chosen",
				"bootstrap-chosen",
				"bootstrap-toggle",
			],

			"video/preview" => 'frontend.css.video',

			"video/add" => [
				"codemirror",
				"froala_editor/froala_editor-pkgd",
				"custom/froala_style",
				"bootstrap-toggle",
				"slim",
			],

			############################
			### CV backend CSS assets
			############################
			"cv/add" => [
				"codemirror",
				"froala_editor/froala_editor-pkgd",
				"custom/froala_style",
				"slim",
			],

			##############################
			### Gallery backend CSS assets
			##############################
			"gallery" => [
				// "jquery/chosen",
				"bootstrap-chosen",
				"bootstrap-toggle",
			],

			"gallery/preview" => 'frontend.css.gallery',

			"gallery/index" => [
				// "backend"
			],
			"gallery/add" => [
				"codemirror",
				"froala_editor/froala_editor-pkgd",
				"custom/froala_style",
				"bootstrap-toggle",
				"slim",
			],


			##############################
			### CMS backend CSS assets
			##############################
			"cms" => [
				// "jquery/chosen",
				"bootstrap-chosen",
				"bootstrap-toggle",
			],

			"cms/preview" => 'frontend.css.cms',

			"cms/index" => [
				// "backend"
			],
			"cms/add" => [
				"codemirror",
				"froala_editor/froala_editor-pkgd",
				"custom/froala_style",
				"bootstrap-toggle",
				"slim",
			],

			##############################
			### Sketchfab backend CSS assets
			##############################
			"sketchfab" => [
				// "jquery/chosen",
				"bootstrap-chosen",
				"bootstrap-toggle",
			],

			"sketchfab/preview" => 'frontend.css.sketchfab',

			"sketchfab/index" => [
				// "backend"
			],
			"sketchfab/add" => [
				"codemirror",
				"froala_editor/froala_editor-pkgd",
				"custom/froala_style",
				"bootstrap-toggle",
				"slim",
			],

			##############################
			### 3D backend CSS assets
			##############################
			"3d" => [
				// "jquery/chosen",
				"bootstrap-chosen",
				"bootstrap-toggle",
			],

			"3d/preview" => 'frontend.css.3d',

			"3d/index" => [
				// "backend"
			],
			"3d/add" => [
				"codemirror",
				"froala_editor/froala_editor-pkgd",
				"custom/froala_style",
				"bootstrap-toggle",
				"slim",
			],

		]

	]


];