<?php

return array(
	
	'admin/dashboard/themes/change/(:any)/(:any)/(:any)'=> array('dashboard/backend/themes/change/$1/$2/$3','name' => 'change_theme'),

	'admin/dashboard/themes/list'		 				=> array('dashboard/backend/themes/list',		  	'name' => 'list_themes'),
	'admin/dashboard/themes/list/(:any)' 				=> array('dashboard/backend/themes/list/$1',	  	'name' => 'list_theme1'),
	'admin/dashboard/themes/list/(:any)/(:any)' 		=> array('dashboard/backend/themes/list/$1/$2',	  	'name' => 'list_theme2'),
	
	// application config setup
	'admin/dashboard/application/list'		 			=> array('dashboard/backend/application/list',		'name' => 'list_application'),
	
	'admin/dashboard/themes/savefrontend'				=> array('dashboard/backend/themes/savefrontend',	'name' => 'save_theme'),

);