<?php

// create here class indepdant on category or post

class Efx_Api extends \Controller_Rest {

     public function action_sortcategory($list) {

     	$elements = explode(',', $list);

     	$i = 0;

     	foreach ($elements as $element) {

     		$category = Model_Category::query()->where('id', $element)->get_one();
     		$category->order_id = $i;
    		$category->save();
    		$i++;

     	}

     	return true;
       
    }

     public function action_sortpost($list) {

     	$elements = explode(',', $list);

     	$i = 0;

     	foreach ($elements as $element) {

     		$post = Model_Post::query()->where('id', $element)->get_one();
     		$post->order_id = $i;
    		$post->save();
    		$i++;

     	}

     	return true;
       
    }


}
