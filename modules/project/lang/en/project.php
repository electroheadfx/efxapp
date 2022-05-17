<?php

return array(

	'module' => array(

		'project' => array(
		
			'menus' => array(

				'project' => 'Project',

			),

			'default'	=> array(
				'category' 			=> 'Category',
				'back_category' 	=> 'Go to Category',
				'categories' 		=> 'Categories',
				'comments' 			=> 'Comments',
				'cv' 				=> 'CV',
				'cvs' 				=> 'CVs',
				'menus' 			=> 'Menus',
			),

			'backend' => array(
				
				'project' => 'Project',
				'read-comment'		=> 'Read comment',
				'back-to-category' 	=> 'Back to category',
				'back-to-comments' 	=> 'Back to comments',
				'menu_content'		=> 'Menu detail',
				'menu_logic'		=> 'Logic',

				'category' => array (
					'manage' 	=> 'Manage Categories',
				),
				'comment' => array (
					'manage' 	=> 'Manage Comments',
				),
				'menu' => array (
					'manage' 				=> 'Manage Menus',
					'titletransform' 		=> 'Title Transform',
					'uri_state' 			=> 'URI rewriting',
					'uri' 					=> 'URI name',
					'template' 				=> 'Template',
					'choose-model'			=> 'Choose a model',
					'links'					=> 'Links',
					'uri_required' 			=> 'Minimun of 3 characters are required',
					'route' 				=> 'Module Route or URL',
					'normal' 				=> 'Normal',
					'off' 					=> 'Off',
					'on' 					=> 'On',
					'selectmode' 			=> 'featured choice',
					'selectmode_all' 		=> 'All',
					'selectmode_selected' 	=> 'Direct select',
					'capital' 				=> 'Capital',
					'iconvisibility' 		=> 'Icon menu',
					'iconmedia' 			=> 'Icon Media',
					'tooltip' 				=> 'Tooltip\'s post',
					'mediaautoclose' 		=> 'Media close',
					'autoclose' 			=> 'Auto',
					'manualclose' 			=> 'Self',
					'iconversion' 			=> 'Icon from',
					'icontype_menu'			=> 'Menu',
					'icontype_media'		=> 'Media',
					'visible' 				=> 'Visible',
					'hidden' 				=> 'Hidden',
					'scrollto' 				=> 'Featured Scroll',
					'active' 				=> 'Active',
					'disabled' 				=> 'Disabled',
					'all' 					=> 'All',
					'el1' 					=> 'Element 1',
					'_self'					=> 'In current window',
					'_blank'				=> 'In a new window',
					'target'				=> 'Menu open action',
					'fa'					=> 'Font Awesome Icon',
					'no_featured'			=> 'No featured post available',
					'scrollpausetime'		=> 'Pause between animations (ms)',
					'all_featured'			=> 'All the featured posts:',
					'all_posts'				=> 'All others posts:',
					'summary_switch'		=> 'Visibility',
					'summary_switch_on'		=> 'visible summary',
					'summary_switch_off'	=> 'Hidden summary',
					'content_switch_on'		=> 'Visible content',
					'content_switch_off'	=> 'Hidden content',
					'postmax'				=> 'Posts max',
					'postselect'			=> array(
						'label'				=> 'Posts render',
						'all'				=> 'All',
						'max'				=> 'Maximum :',
					),
					'sidercategories'		=> 'Categories acess',
					'yes_cats'				=>	'Yes',
					'no_cats'				=>	'No',
				),

				'theme'					=> array(
					'sort'				=> 'Posts sort',
					'cms'				=> 'HTML summary',
					'theme'				=> 'Render & sort',
					'template'			=> 'Render',
					'themecolor'		=> 'Theme',
					'slicePoint'		=> 'Max signs on desc resume',
					'logocolor'			=> 'Logo color 1',
					'logocolor2'			=> 'Logo color 2',
					'bgcolor'			=> 'Page Backgroud',
					'bgsidercolor'		=> 'Page Backgroud sider',
					'navcolor'			=> 'Navbar Backgroud',
					'navrightcolor'		=> 'Right Navbar Backgroud',
					'default'			=> 'Default',
					'color'				=> 'Color selecter',
					'hexa'				=> 'Hexa color value',
					'textured'			=> 'Textured',
					'transparent'		=> 'Transparent',
					'vimeo'				=> 'Vimeo ID',
					'video'				=> 'Hosted Video URL',
					'youtube'			=> 'Youtube video',
					'mediacolor'		=> 'Media background',
					'uitextcolor'		=> 'Text',
					'uitexthovercolor'	=> 'Text hover',
					'uitextactivecolor'	=> 'Text active',

					'uisidertextcolor'		=> 'Sider text',
					'uisidertexthovercolor'	=> 'Sider text hover',
					'uiblockhovercolor'		=> 'Sider block hover',
					'uisidertextactivecolor'=> 'Sider text active',

					'navbarmargin237'	=> 'Sider Marge',
					'navbarmargin'		=> 'Navbar marge',
					'navvarfixed'		=> 'Fixed',
					'navvarstatic'		=> 'Static',
					'navbarstate'		=> 'Navbar state',
				),

			),

			'frontend' => array(

				'read-more' 		=> 'Read more',
				'comment-this-post' => 'Comment this post',

				'comment' => array(
					'added' 		=> 'Comment added awaiting moderation',
					'validate'		=> 'The admin will validate it.'
				),

				'category' => array(
					'not-found' => 'Category not found',
					'private' 	=> 'This category is private, you should have an account to view it.',
				),
					
			),

		),

		'menu' => array(
			'backend' => array(
				'post_manage' => 'Manage the menus',
				'post_edit' => 'Edit menu',
				'post_add' => 'Add a menu',
				'chosen-categories' => 'Categories select visible since this menu',
				'chosen-categories-select' => 'None categories selected ...',
			),

			'frontend' => array(

			),

			'model'	=> array(
				
				'name' => 'Menu name',
				'summary' => 'Introduction',
			),

		),
	),

);


