<?php

return array( 
	'paths' => array('/'),

	'img_dir' 	=> Config::get('server.'.Config::get('server.active').'.theme.asset_dir').'img/',
	'js_dir' 	=> Config::get('server.'.Config::get('server.active').'.theme.asset_dir').'js/',
	'css_dir' 	=> Config::get('server.'.Config::get('server.active').'.theme.asset_dir').'css/',

	'folders' => array(
		'css' => array(),
		'js'  => array(),
		'img' => array(),
	),

	'url' => Config::get('server.'.Config::get('server.active').'.theme.url'),

	'add_mtime' => true,

	'indent_level' => 1,

	'indent_with' => "\t",

	'auto_render' => true,

	'fail_silently' => false,

	'always_resolve' => false,

);
