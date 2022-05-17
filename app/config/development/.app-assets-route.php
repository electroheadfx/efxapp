<?php

//-----------------------------------------------
// Assets packages declarations
//-----------------------------------------------/

return [

	//-----------------------------------------------
	// backend and frontend js and css declarations >
	//-----------------------------------------------

	"template" => [

		// backend js declarations start here :
		"js" => [

			"_root_" => [
				// "jquery-1.11.1" => "https://code.jquery.com/jquery-1.11.1.min.js", // rendu en prod en cdn
				"jquery",
				"bootstrap",
			],

		],

		// backend css declarations start here :
		"css" => [

			"_root_" => [
				'bootstrap', 'font-awesome','app',
			],
			// "admin/dashboard/themes/list" => ['toto', 'titi' ],

		]
	],
	
	//-----------------------------------------------
	// frontend js and css declarations >
	//-----------------------------------------------

	"frontend" => [

		// frontend js declarations
		"js" => [

			"_root_" => [
				// "frontend/app",
				'script:frontend/app'
			],

			"home" => [
				// "gsap/TweenLite",
				// "gsap/TimelineLite",
				// "gsap/TweenMax",
				// "gsap/CSSPlugin",
				// "gsap/ScrollToPlugin",
				// "imagesloaded",
				// "janpaepke/ScrollMagic",
				// "janpaepke/plugins/animation-gsap",
				// "janpaepke/plugins/debug.addIndicators",
			],

		],

		// frontend css declarations
		"css" => [

			"home" => [

				// "shortnav",
			
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
				// 'script:backend/admin',
			],

		],

		// backend css declarations start here :
		"css" => [

			"_root_" => [
				"backend",
			],

		]
		
	]


];