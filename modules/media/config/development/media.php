<?php


return array(

	'backend' => array(

		'cms' => array(
			'route' 	=> 'admin_media_cms',
			'titleicon' => 'th',
			'style' 	=> 'cms-post',
			'model'		=> array( 'post' => 'count::Cms', ),
		),

		'video' => array(
			'route' 	=> 'admin_media_video',
			'titleicon' => 'video-camera',
			'style' 	=> 'video-post',
			'model'		=> array( 'post' => 'count::Video', ),
		),

		'gallery' => array(
			'route' 	=> 'admin_media_gallery',
			'titleicon' => 'picture-o',
			'style' 	=> 'gallery-post',
			'model'		=> array( 'post' => 'count::Gallery', ),
		),

		'sketchfab' => array(
			'route' 	=> 'admin_media_sketchfab',
			'titleicon' => 'cube',
			'style' 	=> 'sketch-post',
			'model'		=> array( 'post' => 'count::Sketchfab', ),
		),

		'3d' => array(
			'route' 	=> 'admin_media_3d',
			'titleicon' => 'cube',
			'style' 	=> '3d-post',
			'model'		=> array( 'post' => 'count::3d', ),
		),

		'cv' => array(
			'route' 	=> 'admin_media_cv',
			'titleicon' => 'user-circle-o',
			'style' 	=> 'cv-post',
			'model'		=> array( 'cv' => 'count', ),
		),

		
	),

);
