<?php

return array(

	'module' => array(


		'project' => array(

			'menus' => array(

				'project' => 'Projet',

			),

			'default'	=> array(
				'category' 			=> 'Rubrique',
				'back_category' 	=> 'Aller aux rubriques',
				'categories' 		=> 'Rubriques',
				'comments' 			=> 'Commentaires',
				'cv' 				=> 'CV',
				'cvs' 			=> 'CVs',
			),

			'backend' => array(

				'project' => 'Projet',
				'back-to-category' 	=> 'Retour au rubrique',
				'back-to-comments' 	=> 'Retour aux commentaires',
				'menu_content'		=> 'Paramétrage du menu',
				'menu_logic'		=> 'Logique',
				
				'menu' => array (
					'manage' 	=> 'Gèrer les menus',
					'titletransform' 		=> 'Rendu du titre',
					'uri_state' 			=> 'Réécriture URI',
					'uri' 					=> 'Nom URI',
					'template' 				=> 'Gabarit',
					'choose-model'			=> 'Choisir un model',
					'links'					=> 'Liens',
					'uri_required' 			=> 'Un minimun de 3 caractères est requis',
					'route' 				=> 'Route Module ou URL',
					'normal' 				=> 'Normal',
					'off' 					=> 'Désactivé',
					'on' 					=> 'Activé',
					'capital' 				=> 'Capitale',
					'selectmode' 			=> 'Choix des favoris',
					'selectmode_all' 		=> 'Tous',
					'selectmode_selected' 	=> 'Sélection directe',
					'iconvisibility' 		=> 'Icône menu',
					'iconmedia' 			=> 'Icône média',
					'tooltip' 				=> 'Info bulle',
					'mediaautoclose' 		=> 'Fermeture Media',
					'autoclose' 			=> 'Auto',
					'manualclose' 			=> 'Manuelle',
					'iconversion' 			=> 'Icône à partir',
					'icontype_menu'			=> 'du menu',
					'icontype_media'		=> 'du media',
					'visible' 				=> 'Visible',
					'hidden' 				=> 'Caché',
					'scrollto' 				=> 'Animation des favoris',
					'active' 				=> 'Activé',
					'disabled' 				=> 'Désactivé',
					'all' 					=> 'Tous',
					'el1' 					=> 'Favoris 1',
					'_self'					=> 'Dans la fenêtre courante',
					'_blank'				=> 'Dans une nouvelle fenêtre',
					'target'				=> 'Ouverture du menu',
					'fa'					=> 'Icône Font Awesome',
					'no_featured'			=> 'Pas de favoris disponible dans le menu.',
					'scrollpausetime'		=> 'Pause animations (ms)',
					'all_featured'			=> 'Tous les favoris:',
					'all_posts'				=> 'Toutes les autres publications:',
					'summary_switch'		=> 'Visibilité',
					'summary_switch_on'		=> 'Intro visible',
					'summary_switch_off'	=> 'Intro cachée',
					'content_switch_on'		=> 'Contenu visible',
					'content_switch_off'	=> 'Contenu caché',
					'postmax'				=> 'Maximun de publications',
					'postselect'			=> array(
						'label'				=> 'Affichage publications',
						'all'				=> 'Toutes',
						'max'				=> 'Maximum :',
					),
					'sidercategories'		=> 'Accès catégories',
					'yes_cats'				=>	'Oui',
					'no_cats'				=>	'Non',
				),
				'category' => array (
					'manage' 	=> 'Gèrer les rubriques',
				),
				'comment' => array (
					'manage' 	=> 'Gèrer les Commentaires',
				),
				'theme'					=> array(
					'sort'				=> 'Tri des publications',
					'cms'				=> 'Intro HTML',
					'theme'				=> 'Affichage & tri',
					'template'			=> 'Affichage',
					'themecolor'		=> 'Thème',
					'slicePoint'		=> 'Max. signes résumé de desc.',
					'logocolor'			=> 'Couleur 1 du logo',
					'logocolor2'		=> 'Couleur 2 du logo',
					'bgcolor'			=> 'Fond de la page',
					'bgsidercolor'		=> 'Fond du sider',
					'navcolor'			=> 'Fond du Navbar',
					'navrightcolor'		=> 'Fond du Navbar droit',
					'default'			=> 'Thème défaut',
					'color'				=> 'Sélecteur de couleur',
					'hexa'				=> 'Couleur Héxadécimale',
					'textured'			=> 'Texture',
					'transparent'		=> 'Transparence',
					'vimeo'				=> 'Vimeo ID',
					'video'				=> 'Vidéo URL hébergé',
					'youtube'			=> 'Youtube vidéo',
					'uitextcolor'		=> 'Texte menu',
					'mediacolor'		=> 'Fond du media',
					'uitexthovercolor'	=> 'Texte survol menu',
					'uiblockhovercolor'	=> 'Block survol menu',
					'uitextactivecolor'	=> 'Texte actif menu',
					'uisidertextcolor'		=> 'Texte sider menu',
					'uisidertexthovercolor'	=> 'Texte sider survol menu',
					'uisidertextactivecolor'=> 'Texte sider actif menu',

					'navbarmargin237'	=> 'Sur le sider',
					'navbarmargin'		=> 'Décalage Navbar',
					'navvarfixed'		=> 'Figé',
					'navvarstatic'		=> 'Static',
					'navbarstate'		=> 'Etat de la navbar',
				),

			),

			'frontend' => array(

				'read-more' 		=> 'Lire la suite',
				'comment-this-post' => 'Commenter cette publication',

				'comment' => array(
					'added' 		=> 'Commentaire ajouté en attente de modération',
					'validate'		=> 'L\'administrateur validera votre commentaire',
				),

				'category' => array(
					'not-found' => 'Rubrique non trouvée',
					'private' 	=> 'Cette rubrique est privée, vous devez être autoriser pour la voir',
				),
				
			),
			

		),

		'menu' => array(
			'backend' => array(
				'post_manage' => 'Gère les menus',
				'post_edit' => 'Editer le menu',
				'post_add' => 'Ajouter un menu',
				'chosen-categories' => 'Sélection des rubriques visibles depuis ce menu',
				'chosen-categories-select' => 'Aucune rubriques sélectionnées ...',
			),

			'frontend' => array(

			),

			'model'	=> array(
				
				'name' => 'Nom du menu',
				'summary' => 'Intro page',
			),
		),
	),

);


