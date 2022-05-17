<?php

namespace Fuel\Migrations;

class Create_category_default_entry {

	public function up() {

		// $category= \Model_Category::forge(array('status'=>'published', 'name'=> 'Toutes les rubriques', 'slug'=>'all', 'exposition'=>'all', 'post_count'=>0, 'order_id'=>NULL, 'permission'=>'public' ));
	  	// $category->save();
		\DB::insert('categories')->set(array( 'status'=>'published', 'name'=> 'Toutes les rubriques', 'slug'=>'all', 'exposition'=>'all', 'post_count'=>0, 'order_id'=>NULL, 'permission'=>'public'))->execute();

		// $category= \Model_Category::forge(array('status'=>'draft', 'name'=> 'Sans rubrique', 'slug'=>'uncategorized', 'exposition'=>'all', 'post_count'=>0, 'order_id'=>NULL, 'permission'=>'public' ));
  		// $category->save();
  		\DB::insert('categories')->set(array('status'=>'draft', 'name'=> 'Sans rubrique', 'slug'=>'uncategorized', 'exposition'=>'all', 'post_count'=>0, 'order_id'=>NULL, 'permission'=>'public' ))->execute();
		
	}

	public function down() {

		// \DBUtil::drop_table('category');

	}

}