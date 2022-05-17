<?php

\Config::load('app-setup', 'application');
$uri = 'media/frontend/'.\Config::get('application.setup.site.default');

if (! \Router::process(\Request::forge($uri))) {
     $uri = '/user/login/you-need-to-create';
}

return array(
	
	// GLOBAL
	'_root_'  								=>  $uri,  		// The default route
	'_404_'   								=> 'user/404',    				// The main 404 route

	// ROUTE DEFAULT FRONTEND TO BLOG POST
	// '/' 									=> array('media/frontend/video/index', 	'name' => 'homepage'),
	// '/' 									=> array('media/frontend/homepage/index', 	'name' => 'homepage'),
	'/' 									=> array($uri, 	'name' => 'homepage'),

	// ROUTE DEFAULT BACKEND TO DASHBOARD
	'admin' 								=> array('dashboard/dash',				 'name' => 'admin'),

	// FAVICON route
	'favicon' 								=> 'favicon',

	// Login
	'login' 	=> array('/user/login', 'name' => 'user_login'),

);

