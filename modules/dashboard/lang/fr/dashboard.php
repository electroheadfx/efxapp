<?php

return array(

	'module' => array(

		'dashboard' => array(

			'default'	=> array(
				'themes' => 'Thèmes',
				'applications' 	=> 'Paramètres',
				'menus' 		=> 'Menus',
			),

			'backend' => array(

				'dashboard' => 'Configuration système',
				
				'themes' => array(
					'show-list-frontend'=> 'Afficher thèmes publique',
					'show-list-backend'	=> 'Afficher thèmes administration',
					'manage' 			=> 'Gestion des thèmes',
					'theme-overview' 	=> 'Informations thème',
					'empty' 			=> 'Aucun thème disponible !',
					'name'				=> 'Nom',
					'theme'				=> 'Thème',
					'view'				=> 'Vue',
					'author'			=> 'Auteur',
					'version'			=> 'Version',
					'backend'			=> 'Vue administrative',
					'frontend'			=> 'Vue publique',
					'test'				=> 'Vue publique',
					'status-on'			=> 'Thème en ligne',
					'status-off'		=> 'Thème inactif',
					'save-your-front-theme' 		=> 'Sauvegardez ou changez ce thème grâce au menu en haut à droite',
					'choosed' 						=> 'Vous avez choisi le thème : ',
					'front-theme-saved-successfull' => 'Le thème du site public a été sauvegardé avec succès !',
					'asset'					=> 'Apparence graphique',
					'template'				=> 'Gabarit de mise en page',
				),
				'application' => array (
					'manage' 	=> 'Paramètres du site',
					'saved'		=> 'Configuration des applications sauvegardée !',

				),
				
			),

			'panel' 	=> array(
				'manage' 	=> 'Tableau',
			),

		),
	),

);


