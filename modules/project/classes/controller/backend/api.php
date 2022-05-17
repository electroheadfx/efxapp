<?php

namespace Project;


class Controller_Backend_Api extends \Controller_Rest {


     public function action_sortmenu($list) {

     	$elements = explode(',', $list);

     	$i = 0;

     	foreach ($elements as $element) {

     		$post = Model_Menu::query()->where('id', $element)->get_one();
     		$post->order_id = $i;
    		$post->save();
    		$i++;

     	}
        // get first menu for home default here
        $default_menu = Model_Menu::query()->order_by('order_id', 'ASC')->get_one();
        \Config::set('application.setup.site.default', $default_menu->route.'/index/'.$default_menu->id);
        $environment = \Config::get('server.active');
        \Config::save($environment.'/app-setup','application');

     	return true;
       
    }

     public function action_sortcategory($list) {

        $elements = explode(',', $list);

        $i = 0;

        foreach ($elements as $element) {

            $category = \Model_Category::query()->where('id', $element)->get_one();
            $category->order_id = $i;
            $category->save();
            $i++;

        }

        return true;
       
    }

     public function action_sortcomment($list) {

        $elements = explode(',', $list);

        $i = 0;

        foreach ($elements as $element) {

            $category = Model_Comment::query()->where('id', $element)->get_one();
            $category->order_id = $i;
            $category->save();
            $i++;

        }

        return true;
       
    }


}
