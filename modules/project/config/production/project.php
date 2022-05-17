<?php

 
return array(
 
	'backend' => array(
 
		'menu' => array(
			'route' 	=> 'admin_project_menu',
			'titleicon' => 'list',
			'style' 	=> 'menu',
			'model'		=> array( 'menu' => 'count', ),
		),
		
		'category' 	=> array(
			'route' 	=> 'admin_project_category',
			'titleicon' => 'folder-open',
			'style' 	=> 'gallery-category',
			'model'		=> array( 'category' => 'count', ),
		),

		// 'comment' 	=> array(
		// 	'route' 	=> 'admin_project_comment',
		// 	'titleicon' => 'bullhorn',
		// 	'style' 	=> 'danger',
		// 	'model'		=> array( 'comment' => 'count', ),
		// ),
	
	),

);
