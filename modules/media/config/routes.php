<?php

return array(

####################################
########## ADMIN ROUTES ############
#####################################

	####### Video routes
	'media/admin/video' 										=> array('media/backend/video/index', 				'name' => 'admin_media_video'),
	'media/admin/video/index' 									=> array('media/backend/video/index/index', 		'name' => 'admin_media_video_list'),
	'media/admin/video/preview' 								=> array('media/backend/video/preview', 			'name' => 'admin_media_video_preview'),
	'media/admin/video/preview/(:id)' 							=> array('media/backend/video/preview/$1', 			'name' => 'admin_media_video_preview_id'),

	'media/admin/video/add/(:id)' 								=> array('media/backend/video/add/$1', 				'name' => 'admin_media_video_edit'),
	'media/admin/video/add/0/(:cat)' 							=> array('media/backend/video/add/0/$1', 			'name' => 'admin_media_video_add'),

	'media/admin/video/(:any)/(:any)' 							=> array('media/backend/video/index/$1/$2', 		'name' => 'admin_media_video_by'),
	'media/admin/video/(:any)/(:any)/(:any)' 					=> array('media/backend/video/index/index/$2/$3', 	'name' => 'admin_media_video_by'),
	
	####### Gallery routes
	'media/admin/gallery' 										=> array('media/backend/gallery/index', 			'name' => 'admin_media_gallery'),
	// 'media/admin/gallery/(:category)' 							=> array('media/backend/gallery/index/$1', 			'name' => 'admin_media_gallery_category'),
	
	'media/admin/gallery/index' 								=> array('media/backend/gallery/index/index', 		'name' => 'admin_media_gallery_list'),
	'media/admin/gallery/preview' 								=> array('media/backend/gallery/preview', 			'name' => 'admin_media_gallery_preview'),
	'media/admin/gallery/preview/(:id)' 						=> array('media/backend/gallery/preview/$1', 		'name' => 'admin_media_gallery_preview_id'),
	
	'media/admin/gallery/add/(:id)' 							=> array('media/backend/gallery/add/$1', 			'name' => 'admin_media_gallery_edit'),
	'media/admin/gallery/add/0/(:cat)' 							=> array('media/backend/gallery/add/0/$1', 			'name' => 'admin_media_gallery_add'),

	// 'media/admin/gallery/(:any)/(:any)' 						=> array('media/backend/gallery/index/index/$1/$2', 'name' => 'admin_media_gallery_by'),
	'media/admin/gallery/(:any)/(:any)/(:any)' 					=> array('media/backend/gallery/index/index/$2/$3/$4', 'name' => 'admin_media_gallery_by'),

	####### CMS routes
	'media/admin/cms' 											=> array('media/backend/cms/index', 			'name' => 'admin_media_cms'),
	'media/admin/cms/index' 									=> array('media/backend/cms/index/index', 		'name' => 'admin_media_cms_list'),
	'media/admin/cms/preview' 									=> array('media/backend/cms/preview', 			'name' => 'admin_media_cms_preview'),
	'media/admin/cms/preview/(:id)' 							=> array('media/backend/cms/preview/$1', 		'name' => 'admin_media_cms_preview_id'),

	'media/admin/cms/add/(:id)' 								=> array('media/backend/cms/add/$1', 			'name' => 'admin_media_cms_edit'),
	'media/admin/cms/add/0/(:cat)' 								=> array('media/backend/cms/add/0/$1', 			'name' => 'admin_media_cms_add'),

	'media/admin/cms/(:any)/(:any)/(:any)' 						=> array('media/backend/cms/index/index/$2/$3', 'name' => 'admin_media_cms_by'),

	####### Sketchfab routes
	'media/admin/sketchfab' 									=> array('media/backend/sketchfab/index', 			'name' => 'admin_media_sketchfab'),
	'media/admin/sketchfab/index' 								=> array('media/backend/sketchfab/index/index', 	'name' => 'admin_media_sketchfab_list'),
	'media/admin/sketchfab/preview' 							=> array('media/backend/sketchfab/preview', 		'name' => 'admin_media_sketchfab_preview'),
	'media/admin/sketchfab/preview/(:id)' 						=> array('media/backend/sketchfab/preview/$1', 		'name' => 'admin_media_sketchfab_preview_id'),

	'media/admin/sketchfab/add/(:id)' 							=> array('media/backend/sketchfab/add/$1', 			'name' => 'admin_media_sketchfab_edit'),
	'media/admin/sketchfab/add/0/(:cat)' 						=> array('media/backend/sketchfab/add/0/$1', 		'name' => 'admin_media_sketchfab_add'),

	'media/admin/sketchfab/(:any)/(:any)/(:any)' 				=> array('media/backend/sketchfab/index/index/$2/$3','name' => 'admin_media_sketchfab_by'),
	
	####### 3D glTF routes
	'media/admin/3d' 									=> array('media/backend/3d/index', 			'name' => 'admin_media_3d'),
	'media/admin/3d/index' 								=> array('media/backend/3d/index/index', 	'name' => 'admin_media_3d_list'),
	'media/admin/3d/preview' 							=> array('media/backend/3d/preview', 		'name' => 'admin_media_3d_preview'),
	'media/admin/3d/preview/(:id)' 						=> array('media/backend/3d/preview/$1', 	'name' => 'admin_media_3d_preview_id'),

	'media/admin/3d/add/(:id)' 							=> array('media/backend/3d/add/$1', 		'name' => 'admin_media_3d_edit'),
	'media/admin/3d/add/0/(:cat)' 						=> array('media/backend/3d/add/0/$1', 		'name' => 'admin_media_3d_add'),

	###### Media route
	'media/admin/media/attribute/(:any)/(:any)/(:any)/(:any)' 				=> array('media/backend/media/attribute/$1/$2/$3/$4',			'name' => 'admin_media_attribute'),
	'media/admin/media/attribute_module/(:any)/(:any)/(:any)/(:any)/(:any)'	=> array('media/backend/media/attribute_module/$1/$2/$3/$4/$5',	'name' => 'admin_media_attribute_module'),
	'media/admin/media/delete/(:any)/(:any)' 								=> array('media/backend/media/delete/$1/$2', 		 			'name' => 'admin_media_delete'),
	'media/admin/media/exit/(:any)/(:any)/(:any)' 							=> array('media/backend/media/exit/$1/$2/$3', 			 		'name' => 'admin_media_exit'),
	'media/admin/media/exit/(:any)/(:any)' 									=> array('media/backend/media/exit/$1/$2', 			 			'name' => 'admin_media_exit'),
	'media/admin/media/exit/(:any)' 										=> array('media/backend/media/exit/$1', 			 	 		'name' => 'admin_media_exit_without'),
	'media/admin/media/force/(:any)/(:any)' 								=> array('media/backend/media/force/$1/$2', 		 			'name' => 'admin_media_force'),
	'media/admin/media/categorize/(:any)/(:any)/(:any)' 					=> array('media/backend/media/categorize/$1/$2/$3', 			'name' => 'admin_media_categorize'),

	// 'media/admin/gallery/attribute/(:any)/(:any)/(:any)' => array('media/backend/gallery/attribute/$1/$2/$3', 'name' => 'admin_gallery_post_attribute'),
	
	####### Cv routes
	'media/admin/cv' 									=> array('media/backend/cv/index', 					'name' => 'admin_media_cv'),

	'media/admin/cv/add' 								=> array('media/backend/cv/add', 					'name' => 'admin_media_cv_add'),
	'media/admin/cv/add/(:id)' 							=> array('media/backend/cv/add/$1', 				'name' => 'admin_media_cv_edit'),
	
	'media/admin/cv/force/(:id)' 						=> array('media/backend/cv/force/$1', 				'name' => 'admin_media_cv_force'),
	'media/admin/cv/exit/(:any)/(:any)' 				=> array('media/backend/cv/exit/$1/$2', 			'name' => 'admin_media_cv_exit'),
	'media/admin/cv/exit/(:any)' 						=> array('media/backend/cv/exit/$1', 				'name' => 'admin_media_cv_exit_1'),
	'media/admin/cv/delete/(:id)' 						=> array('media/backend/cv/delete/$1', 				'name' => 'admin_media_cv_delete'),
	// 'media/admin/cv/(:any)/(:any)' 						=> array('media/backend/cv/index/$1/$2', 			'name' => 'admin_media_cv_by'),

	// 'media/admin/cv/attribute/(:any)/(:any)/(:any)' 	=> array('media/backend/cv/attribute/$1/$2/$3', 	'name' => 'admin_media_cv_attribute'),
	'media/admin/cv/exit' 								=> array('media/backend/cv/exit', 					'name' => 'admin_media_cv_exit_without'),


#########################################
############ FRONTEND ROUTES ############
##########################################

	// default homepage
	'homepage' 			=> array('media/frontend/homepage/index', 		'name' => 'homepage_index'),
	'homepage/(:msg)' 	=> array('media/frontend/homepage/index/$1',	'name' => 'homepage_index_msg'),

	// MEDIA PAGE
	// 'video' 			=> array('media/frontend/video/index', 			'name' => 'video_index_all'),
	'video/(:id)' 		=> array('media/frontend/video/index/$1', 	'name' => 'video_index'),
	
	// 'gallery' 			=> array('media/frontend/gallery/index', 	'name' => 'gallery_index_all'),
	'gallery/(:id)' 	=> array('media/frontend/gallery/index/$1', 	'name' => 'gallery_index'),
	
	// 'sketchfab' 		=> array('media/frontend/sketchfab/index',		'name' => 'sketchfab_index_all'),
	'sketchfab/(:id)' 	=> array('media/frontend/sketchfab/index/$1','name' => 'sketchfab_index'),
	
	// 'cms' 				=> array('media/frontend/cms/index', 		'name' => 'cms_index_all'),
	'cms/(:id)' 		=> array('media/frontend/cms/index/$1', 		'name' => 'cms_index'),

	// MEDIA PRODUCT
	// /media/frontend/cms/p/Cote-juillet-94
	'p/(:id)' 			=> array('media/frontend/cms/p/$1', 			'name' => 'cms_product'),	

	// CV
	'cv/(:id)' 			=> array('media/frontend/cv/index/$1', 			'name' => 'cv_index'),

	// CATEGORY route
	// 'media/category/(:category)' 	=> array('media/frontend/cv/show_by_category/$1', 	'name' => 'video_show_post_category'),
		
	// BY AUTHOR route
	// 'media/author/(:author)' 		=> array('media/frontend/post/show_by_author/$1', 	'name' => 'video_show_post_author'),	
	
	// Global routes
	// 'media/(:segment)' 				=> array('media/frontend/post/show/$1', 			'name' => 'show_video_post'),
	// 'media/frontend/post/sidebar' 	=> array('media/frontend/post/sidebar', 			'name' => 'video_sidebar'),
	
);