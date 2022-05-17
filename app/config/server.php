<?php
/**
 * The development server settings. These get merged with the global settings.
 */ 

return array(
	
	// for development config
	'development' => array(
		'domain' => array (
			'site' 	=> Uri::base(false),
			'cdn' 	=> Uri::base(false), //'http://fuelcdn.dev/'
		),
		'theme' => array (
			'url' 			=> Config::get('base_url'),		// setup config/asset.url
			'assets_folder'	=> 'dev-themes',				// setup config/theme.assets_folder
			'asset_dir' 	=> '',							// setup config/asset.img_dir .js_dir and .css_dir
		),
	),

	'production' => array(
		'domain' => array (
			'site' 		=> Uri::base(false),
			'cdn' 		=> Uri::base(false),
		),
		'theme' => array (
			'url' 			=> Config::get('base_url'),		// setup config/asset.url
			'assets_folder'	=> 'themes',					// setup config/theme.assets_folder
			'asset_dir' 	=> '',							// setup config/asset.img_dir .js_dir and .css_dir
		),

	),

	'cdn'	=> array(
		'action' => array (
			'save'						=> 'efx/upload/save',
			'upload_slim_cover'			=> 'efx/upload/slim_cover/posts',
			'video_slim_cover'			=> 'efx/upload/slim_cover/video',
			'gallery_slim_cover'		=> 'efx/upload/gallery',
			'gallery_slim_add'			=> 'efx/upload/addimage',
			'cms_slim_cover'			=> 'efx/upload/slim_cover/cms',
			'upload'					=> 'efx/upload/index',
			'delete'					=> 'efx/upload/delete',
			'gallery'					=> 'efx/upload/images.json',
		),
	),

	'application' => [

		'attributes-icon' => [

			'status'		=> ['chain', 'chain-broken'],
			'permission'	=> ['globe', 'user'],
			'featured'		=> ['heart', 'heart-o'],
			'locked'		=> ['lock', 'unlock-alt'],
			'visibility'	=> ['eye', 'eye-slash'],
			'render'		=> ['eye', 'eye-slash'],
		],
		'language' => \Config::get('language'),
		'lang-order' => ['fr', 'en'],

	],

	'attributes' => [
		'status' 		 => ['published','draft'],
		'permission' 	 => ['public','private'],
		'featured' 		 => ['yes','no'],
		'allow_comments' => ['yes','no'],
		'locked' 		 => ['yes','no'],
		'visibility' 	 => ['visible','hidden'],
		'render' 	 	=> ['home','menu'],
	]

);

// \Config::load('server', true);
// $base = \Config::get('server.active');
// 'CDN URL 	: \Config::get("server.$base.domain.cdn")
// 'Site URL 	: \Config::get("server.$base.domain.site")
// 'Asset 		: \Config::get("server.$base.domain.asset")
// 'URI upload 	: \Config::get('server.cdn.action.upload')
// 'URI gallery : \Config::get('server.cdn.action.gallery')
// 