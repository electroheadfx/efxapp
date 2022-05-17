<?php

return array(

	'module' => array(
 
 		'gallery' => array(
			'backend' => array(
				'post_manage' => 'Manage gallery',
				'post_edit' => 'Edit image',
				'post_add' => 'Add an image',
				'post_setup' => 'Gallery setup',
			),

			'frontend' => array(

			),
		),

 		'cms' => array(
			'backend' => array(
				'post_manage' => 'Manage CMS',
				'post_edit' => 'Edit image',
				'post_add' => 'Add an image',
				'post_setup' => 'CMS setup',
			),

			'frontend' => array(

			),
		),

		'sketchfab' => array(
			'backend' => array(
				'post_manage' 		=> 'Manage 3D models',
				'post_edit' 		=> 'Edit 3D model',
				'post_add' 			=> 'Add 3D model',
				'post_setup' 		=> 'Sketchfab setup',
				'post_seo' 			=> 'Google SEO',
				'post_sketchfab' 	=> 'ID Sketchfab 3D model',
			),

			'frontend' => array(

			),
		),

		'3d' => array(
			'backend' => array(
				'post_manage' 		=> 'Manage 3D',
				'post_edit' 		=> 'Edit glTF model',
				'post_add' 			=> 'Add glTF model',
				'post_setup' 		=> 'Setup 3D',
				'post_seo' 			=> 'Google SEO',
				'post_3d_dropbox' 	=> 'Dropbox URL glTF folder',
			),

			'frontend' => array(

			),
		),

		'video' => array(
			'backend' => array(
				'post_manage' => 'Manage vidéos',
				'post_edit' => 'Edit video',
				'post_add' => 'Add a video',
				'post_setup' => 'Video setup',
			),

			'frontend' => array(

			),
		),

		'cv' => array(
			'backend' => array(
				'post_manage' => 'Manage Curriculum Vitae',
				'post_edit' => 'Edit CV date',
				'post_add' => 'Add a CV date',
			),

			'frontend' => array(

			),
		),

		'media' => array(
		
			'menus' => array(

				'medias' => 'Medias',

			),

			'default'	=> array(
				'category' 			=> 'Category',
				'categories' 		=> 'Categories',
				'post' 				=> 'Post',
				'posts' 			=> 'Posts',
				'cms' 				=> 'CMS',
				'video' 			=> 'Video',
				'videos' 			=> 'Video',
				'cvs' 				=> 'Curiculum Vitae',
				'galleries' 		=> 'Photo',
				'sketchfabs'		=> 'Sketchfab',
				'3ds' 				=> 'glTF',
				'comments' 			=> 'Comments',
				'comment' 			=> 'Comment',
				'comment-from'		=> 'comment from',
				'last-posts' 		=> 'Last posts',
				'go_to_previous_slide' 	=> 'Go to previous slide',
				'go_to_next_slide' 		=> 'Go to next slide',
			),

			'backend' => array(
				
				'media' 			=> 'Medias management',
				'video' 			=> 'Video section',
				'imageupload_setup' => 'Setup image upload',
				'post_content' 		=> 'Post content',
				'post_setup' 		=> 'Post setup',
				'size' 				=> 'Image size',
				'crop' 				=> 'Image crop',
				'algorythm' 		=> 'Algorythm',
				'actions' 			=> 'Actions',
				'edit' 				=> 'Edit',
				'read-comment'		=> 'Read comment',
				'add' 				=> 'Add',
				'delete' 			=> 'Delete',
				'are-you-sure' 		=> 'Are you sure ?',
				'back-to-post' 		=> 'Back to post',
				'back-to-category' 	=> 'Back to category',
				'back-to-comments' 	=> 'Back to comments',
				'from-post' 		=> 'From post',
				'show-from-video' 	=> 'Video',
				'delete' 			=> 'Delete',
				'date'				=> 'Date',
				'post_in_editing'	=> 'Force editing',
				'post_forced'		=> 'Post forced, be warning to close previous post edition (multi-users).',
				'addimage_setup' 	=> 'Add new image',

				'hover'		=> array(
					'category' 	=> 'Category',
					'name' 		=> 'Media',
					'meta' 		=> 'SEO',
					'empty' 	=> 'None',
					'label'		=> 'Hover\'title on thumbs',
				),

				'cv'		=> array(
					'manage' 	=> 'Manage CV',

				),

				'video'		=> array(
					'manage' 	=> 'Manage the videos',

				),

				'gallery'		=> array(
					'manage' 	=> 'Manage gallery',

				),

				'cms'		=> array(
					'manage' 	=> 'Manage cms',

				),

				'sketchfab'		=> array(
					'manage' 	=> 'Manage sketchfab',

				),

				'3d'		=> array(
					'manage' 	=> 'Manage glTF 3D',

				),

				'post' 		=> array(
					'manage' 	=> 'Manage video',
					'empty' 	=> 'No post found',
					'add' 		=> 'Add a new post',
					'edit' 		=> 'Edit a post',
					'added' 	=> 'Post created',
					'edited' 	=> 'Post updated',
					'deleted' 	=> 'Post(s) deleted',
					'visual' 	=> 'Post visual',
					'idvideo' 	=> 'ID Video',
					'engine' 	=> 'Video engine',
					'vimeo_test' => 'Check video',
					'video_test' => 'Check video',
					'deleteimage' => 'Delete image',
				),

			),

			'frontend' => array(

				'read-more' 		=> 'Read more',
				'comment-this-post' => 'Comment this post',

				'author' => array(

					'not-found' 			=> 'Author not found',
				),

				'post' => array(
					'empty' 				=> 'No post found',
					'not-found' 			=> 'Post not found',
					'category-not-found' 	=> 'Post forbidden from its category.',
					'category-private' 		=> 'This post private from its category, you should login to see it.',
					'private' 				=> 'This post private, you should login to see it.',
				),

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
	),

	'model'	=> array(

		'publication-date' 	=> 'Publication date',

		'post' => array(
			'id' 				=> 'ID',
			'name' 				=> 'Name',
			'category' 			=> 'Category',
			'slug' 				=> 'Slug',
			'content' 			=> 'Content',
			'summary' 			=> 'Summary',
			'status' 			=> 'Status',
			'permission' 		=> 'Permission',
			'comment' 			=> 'Comments',
			'featured' 			=> 'Featured',
			'desc' 				=> 'Descendant or Ascendant sort',
			'allow_comments' 	=> 'Allow comments',
			'category_id' 		=> 'Category',
			'user_id' 			=> 'Author',
			'no_name'			=> 'No title',

			'attribute' => array(

				'status' 		=> array(
					'draft' 	=> 'Draft',
					'published' => 'Published',
				),

				'permission' => array(
					'public' 	=> 'Public',
					'private' 	=> 'Private',
				),

				'featured' => array(
					'no' 		=> 'No',
					'yes' 		=> 'Yes',
				),

				'allow_comments' => array(
					'no' 		=> 'No',
					'yes' 		=> 'Yes',
				),
			),
		),
	),

);


