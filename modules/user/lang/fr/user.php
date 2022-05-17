<?php

return array(

	'module' => array(

		'user' => array(

			'default'	=> array(

				'login' => array(
					'not-logged' 		=> 'Vous n\'êtes pas connecté',
					'failure' 			=> 'Une erreur s\'est produite lors de la connexion',
					'already-logged-in' => 'Vous êtes déjà connecté',
					'logged-out' 		=> 'Vous êtes déconnecté',
					'sign-in' 			=> 'Se connecter',
					'please-signin' 	=> 'Veuillez vous authentifiez',
					'you-need-to-create' 	=> 'Vous devez créer du contenu dans le back-office.',
				),
				
			),

			'backend' => array(

			),

			'frontend' => array(

			),

		),

	),

	'model' => array(

		'user' => array(
			'username' => 'Pseudo',
			'password' => 'Mot de passe',
		),

	),

);


