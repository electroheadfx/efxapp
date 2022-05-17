<?php

return array(

	'column' => [

		'app-thumb.bootstrap.single' 	=> 'single',
		'app-thumb.bootstrap.double' 	=> 'double',
		'app-thumb.bootstrap.triple' 	=> 'triple',
		'app-thumb.bootstrap.full' 		=> 'full',

	],

	'bootstrap' => [

		'single'	=> 'col-xs-6 col-sm-6 col-md-4 col-lg-3' ,
		'double'	=> 'col-xs-12 col-sm-12 col-md-8 col-lg-6' ,
		'triple'	=> 'col-xs-12 col-sm-12 col-md-12 col-lg-9' ,
		'full'		=> 'col-xs-12 col-sm-12 col-md-12 col-lg-12',

	],

	'gallery' => [

		'thumb' => [
			"width" => 600,
			"height" => 200 
		],

		'column' => [
			'single' => [
				"width" => 600,
				"height" => 600
			],
			'double' => [
				"width" => 1200,
				"height" => 1200
			],
			'triple' => [
				"width" => 1400,
				"height" => 1400
			],
			'full' => [
				"width" => 1800,
				"height" => 1800
			],
		],

		'web_hd' => [
			"width" => 1800, // 1350 (0,75)
			"height" => 1200 // 900
		],

	],

	'cms' => [

		'thumb' => [
			"width" => 600,
			"height" => 600 
		],

		'column' => [
			'single' => [
				"width" => 600,
				"height" => 600
			],
			'double' => [
				"width" => 1200,
				"height" => 1200
			],
			'triple' => [
				"width" => 1400,
				"height" => 1400
			],
			'full' => [
				"width" => 1800,
				"height" => 1800
			],
		],

		'web_hd' => [
			"width" => 1800, // 1350 (0,75)
			"height" => 1200 // 900
		],

	],

	'video' => [

		'thumb' => [
			"width" => 500,
			"height" => 250
		],

		'column' => [
			'single' => [
				"width" => 500,
				"height" => 250
			],
			'double' => [
				"width" => 779,
				"height" => 390
			],
			'triple' => [
				"width" => 1173,
				"height" => 587
			],
			'full' => [
				"width" => 1569,
				"height" => 786
			],
		],

	],

	'crop' => [
		"3:2:h" 		=> "3:2 horyzontal",
		"3:2:v" 		=> "3:2 vertical",
		"16:9:h" 		=> "16:9 horyzontal",
		"16:9:v" 		=> "16:9 vertical",
		"5:3:h" 		=> "5:3 horyzontal",
		"5:3:v" 		=> "5:3 vertical",
		"5:4:h" 		=> "5:4 horyzontal",
		"5:4:v" 		=> "5:4 vertical",
		"4:3:h" 		=> "4:3 horyzontal",
		"4:3:v" 		=> "4:3 vertical",
		"1:1:s" 		=> "1:1",
		"0:0" 			=> "Aucun",
	],

	'size' => [
		"300"  	=> 'application.image-options.small',
		"600" 	=> 'application.image-options.medium',
		"1500" 	=> 'application.image-options.big',
		"0" 	=> 'application.image-options.original',
	],

	'algorythm' => [
		"balanced" => "application.image-options.balanced",
		"entropy"  => "application.image-options.entropy",
		"center"   => "application.image-options.center",
	],

	'default' => [

		'crop' 		=> '3:2:h',
		'size' 		=> "300",
		'algorythm'	=> 'entropy',

	],

);
