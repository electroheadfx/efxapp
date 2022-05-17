<?php
 
 
return array(

	### GALLERY ADMIN ROUTES

	// menus setup
	'project/admin/menu'		 						=> array('project/backend/menu/index',				'name' => 'admin_project_menu'),
	'project/admin/menu/add' 							=> array('project/backend/menu/add', 				'name' => 'admin_project_menu_add'),
	'project/admin/menu/add/(:id)' 						=> array('project/backend/menu/add/$1', 			'name' => 'admin_project_menu_edit'),
	'project/admin/menu/delete/(:id)' 					=> array('project/backend/menu/delete/$1', 			'name' => 'admin_project_menu_delete'),
	// 'project/admin/menu/attribute/(:any)/(:any)/(:any)'	=> array('project/backend/menu/attribute/$1/$2/$3',	'name' => 'admin_project_menu_attribute'),
	'project/admin/menu/exit' 							=> array('project/backend/menu/exit', 			 	'name' => 'admin_project_menu_exit_without'),
	'project/admin/menu/exit/(:any)' 					=> array('project/backend/menu/exit/$1', 			'name' => 'admin_project_menu_exit'),
	'project/admin/menu/force/(:id)' 					=> array('project/backend/menu/force/$1', 		 	'name' => 'admin_project_menu_force'),
	
	'project/admin/menu/attribute_menu/(:any)/(:any)' 	=> array('project/backend/menu/attribute_menu/$1/$2','name' => 'admin_project_attribute_menu'),

	### BLOG FRONTEND ROUTES
	#
	
	// 'project/cv' 											=> array('project/frontend/cv/index', 					'name' => 'project_index'),

	// CATEGORY routes
	'project/admin/category' 								=> array('project/backend/category', 					'name' => 'admin_project_category'),
	'project/admin/category/add' 							=> array('project/backend/category/add', 				'name' => 'admin_project_category_add'),
	'project/admin/category/add/(:id)' 						=> array('project/backend/category/add/$1', 			'name' => 'admin_project_category_edit'),
	'project/admin/category/delete/(:id)' 					=> array('project/backend/category/delete/$1', 			'name' => 'admin_project_category_delete'),
	// 'project/admin/category/attribute/(:any)/(:any)/(:any)'	=> array('project/backend/category/attribute/$1/$2/$3',	'name' => 'admin_project_category_attribute'),

	// COMMENT routes
	'project/admin/comment' 								=> array('project/backend/comment', 					'name' => 'admin_project_comment'),
	'project/admin/comment/show/(:id)' 						=> array('project/backend/comment/show/$1', 			'name' => 'admin_project_comment_show'),
	'project/admin/comment/delete/(:id)' 					=> array('project/backend/comment/delete/$1', 			'name' => 'admin_project_comment_delete'),
	// 'project/admin/comment/attribute/(:any)/(:any)/(:any)'  => array('project/backend/comment/attribute/$1/$2/$3',	'name' => 'admin_project_comment_attribute'),
	

	### CMS
	'cms/(:any)' 	=> array('project/frontend/cms/index/$1', 'name' => 'cms_index'),

	### Sendmail
	'sendmail' 	=> array('project/frontend/sendmail/index', 'name' => 'sendmail_index'),

);