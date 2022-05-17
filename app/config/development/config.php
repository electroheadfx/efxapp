<?php

return array(

	'profiling'        => false,
	
	'security' => array(

		/**
		 * A salt to make sure the generated security tokens are not predictable
		 */
		'token_salt'            => 'mjeipef5Ef5EF89zd354defLWzqAZeijzeqjknvjvd',
	),


	/**
	 * Localization & internationalization settings
	 */
	'language'           => 'fr', // Default language
	'language_fallback'  => 'en', // Fallback language when file isn't available for default language
	'locale'             => 'fr_FR.UTF-8', // PHP set_locale() setting, null to not set

	/**
	 * Internal string encoding charset
	 */
	'encoding'  => 'UTF-8',

	/**
	 * DateTime settings
	 *
	 * server_gmt_offset	in seconds the server offset from gmt timestamp when time() is used
	 * default_timezone		optional, if you want to change the server's default timezone
	 */
	'server_gmt_offset'  => 0,
	'default_timezone'   => 'Europe/Paris',

	/**
	 * Security settings
	 */
	'security' => array(
	
		'uri_filter'       => array('htmlentities'),

		'output_filter'  => array('Security::htmlentities'),

		'whitelisted_classes' => array(
			'Fuel\\Core\\Response',
			'Fuel\\Core\\View',
			'Fuel\\Core\\ViewModel',
			'Closure',
		),
	),

	'cookie' => array(

		'expiration'  => 60*60,

	),

	'routing' => array(

		'module_routes' => true,

	),

	'module_paths' => array(
		APPPATH.'../modules'.DS
	),
	
	'package_paths' => array(
		PKGPATH
	),

	'always_load'  => array(

		'packages'  => array(
			'orm',
			'auth',
			'message',
			'email',
			// 'mandrill/mandrill',
			// 'tinychimp',
			// 'mailchimp2',
		),
		
		'modules'  => array('project', 'media', 'user', 'dashboard', 'efx' ),

	),

);
