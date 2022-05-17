<?php
/**
 * The development server settings. These get merged with the global settings.
 */

return array(

	'active' 	=> Fuel::$env, 
	// setup to production for test it in development mode :
	// 'active' => 'production',
	
	// 'navigation' should become 'front end modules'
	'modules' => array(
		'cms' 	 	=> array( 'route' => 'cms', 	 'icon' => 'th'), 		// \Router::get('cms_index')
		'video'  	=> array( 'route' => 'video', 	 'icon' => 'video-camera' ), 	// \Router::get('video_index')
		'gallery' 	=> array( 'route' => 'gallery',  'icon' => 'picture-o'), 		// \Router::get('gallery_index')
		// 'sketchfab' => array( 'route' => 'sketchfab','icon' => 'cube'), 			// \Router::get('sketchfab_index')
		// '3d' 		=> array( 'route' => '3d',		 'icon' => 'cube'), 			// \Router::get('3d_index')
		'cv' 	 	=> array( 'route' => 'cv', 		 'icon' => 'user-circle-o'), 	// \Router::get('cv_index')
	),

	'contact' => 'readymadelefilm@gmail.com',

	'social'	=> array(
		'account' => array(
			'sendmail'		=> '/sendmail',
			// 'twitter'	=> 'url twitter',
			// 'pinterest'	=> 'url pinterest',
			// 'google-plus'	=> 'url google+',
			'instagram'	=> 'https://instagram.com/bystephanievarela?utm_source=ig_profile_share&igshid=wo7fq03x78lf',
			'imdb'		=> 'https://m.imdb.com/name/nm5130253/?ref=m_nv_sr_1',
			'facebook'	=> 'https://www.facebook.com/Stef.Varela',
		),
		'share' => array(
			'twitter' 	=> 'https://twitter.com/intent/tweet/?text=',
			'facebook' 	=> 'https://www.facebook.com/sharer/sharer.php?u=',
			'google' 	=> 'https://plus.google.com/share?url=',
			'pinterest' => 'https://www.pinterest.com/pin/create/button/?url=',

		),
	),

);