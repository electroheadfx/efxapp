<?php

namespace Fuel\Migrations;

// many_many relation with posts_categories
class Create_Category_Post
{
	public function up()
	{
		\DBUtil::create_table('categories_posts', array(
			'category_id'  => array('constraint' => 11, 'type' => 'int'),
			'post_id'      => array('constraint' => 11, 'type' => 'int'),
		), array('category_id', 'post_id'));

		//// make relation with existant data
		// $posts = \Model_Post::query()->get();
		// $uncategorized = \Model_Category::query()->where('slug', 'uncategorized')->get_one();
		// if ($posts) {
		// 	foreach ($posts as $post) {
		// 		if ( $post->category_id > 0 ) {
		// 			$category = \Model_Category::find($post->category_id);
		// 			if ($category) {
		// 				$post->categories[] = $category;
		// 				$post->save();
		// 			} else {
		// 				$post->categories[] = $uncategorized;
		// 				$post->save();
		// 			}
		// 		} else {
		// 			$post->categories[] = $uncategorized;
		// 			$post->save();
		// 		}
		// 	}
		// }
	}

	public function down()
	{
		\DBUtil::drop_table('categories_posts');
	}
}