<?php
// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';

Autoloader::add_classes(array(
	
	'Vimeo' 	 	 => APPPATH.'classes/efx/vimeo.php',
	'Module' 		 => APPPATH.'classes/efx/module.php',
	'Theme' 		 => APPPATH.'classes/efx/theme.php',
	'Asset_Instance' => APPPATH.'classes/efx/asset/instance.php',
	
));

// Register the autoloader
\Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
\Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : \Fuel::DEVELOPMENT);

// Initialize the framework with the config file.
\Fuel::init('config.php');
\Config::load('server', true);