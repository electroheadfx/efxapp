<?php


return array(

	'backend' => array(

		'dash' => array(
			'titleicon' => 'dashboard',
		),

		// 'themes' => array(
		// 	'route' 	=> 'list_themes',
		// 	'titleicon' => 'leaf',
		// 	'style' 	=> 'theme',
		// 	'model'		=> array('themes' => 'count'),
		// ),
		'application' => array(
			'route' 	=> 'list_application',
			'titleicon' => 'tasks',
			'style' 	=> 'theme',
			'model'		=> array('application.seo.frontend' => 'count'),
		),
	),
	
);