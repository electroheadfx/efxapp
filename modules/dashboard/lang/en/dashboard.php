<?php

return array(

	'module' => array(

		'dashboard' => array(

			'default'	=> array(
				'themes' 		=> 'Themes',
				'applications' 	=> 'Applications',
			),

			'backend' => array(

				'dashboard' => 'Config',

				'themes' => array(

					'library' => array(
						'default' 	=> 'Default',
						'newtheme' 	=> 'New test',
					),
					'show-list-frontend'			=> 'Show frontend themes',
					'show-list-backend'				=> 'Show backend themes',
					'manage' 						=> 'Manage themes',
					'theme-overview' 				=> 'Theme overview',
					'empty' 						=> 'No theme available !',		
					'name'							=> 'Name',
					'theme'							=> 'Theme',
					'view'							=> 'Side',
					'author'						=> 'Author',
					'version'						=> 'Version',
					'backend'						=> 'Backend view',
					'frontend'						=> 'Frontend view',
					'test'							=> 'Frontend view',
					'status-on'						=> 'Theme on',
					'status-off'					=> 'Theme off',
					'save-your-front-theme' 		=> 'Save or choose this front-end theme at top right',
					'choosed' 						=> 'You choosed the theme: ',
					'front-theme-saved-successfull' => 'The front-end theme was saved successfully !',
					'asset'							=> 'Visual graphic',
					'template'						=> 'Layout'
				),
				'application' => array (
					'manage' 	=> 'Applications parameters',
					'saved'		=> 'Applications config saved !',
				),

			),

			'panel' 	=> array(
				'manage' 	=> 'Panel',
			),

		),

	),

);


