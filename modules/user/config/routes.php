<?php

return array(

	'user/login' 		=> array('user/user/login', 	'name' => 'login'),
	'user/login/(:id)' 	=> array('user/user/login/$1', 	'name' => 'login'),

	'user/logout' 	=> array('user/user/logout', 	'name' => 'logout'),
);