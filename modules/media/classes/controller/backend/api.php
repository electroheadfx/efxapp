<?php

namespace Media;

class Controller_Backend_Api extends \Controller_Rest {

    /**
     * get position of media page
     * @return json set or get cookie
     *
     * save category cookie :
     * "/media/backend/api/position.json?action=setup&category=toto"
     * 
     * save category and search cookies :
     * "/media/backend/api/position.json?action=setup&category=toto&search=affiche"
     *
     * get cookies category and search :
     * "/media/backend/api/position.json"
     * return json response array('position_category','position_search') 
     * 
     */
    
    public function get_position() {

        if ( \Input::get('action') !== NULL) {
            // setup cookies
            
            $arr = array();

            if ( \Input::get('action') == 'setup' ) {

                // save category cookie
                if ( \Input::get('category') !== NULL) {
                    \Cookie::set('jquery_position_category', \Input::get('category'));
                    $arr['position_category'] = 'saved';
                }
                // save search cookie
                if ( \Input::get('search') !== NULL) {
                    \Cookie::set('position_search', \Input::get('search'));
                    $arr['position_search'] = 'saved';
                    
                }

            } else {
                \Cookie::delete('position_search');
                $arr['position_search'] = 'search_deleted';
            }
            
            return $this->response($arr);

        } else {
            // action null -> get cookie

            return $this->response(array(
                'position_category' => \Cookie::get('jquery_position_category'),
                'position_search' => \Cookie::get('position_search')
            ));
        }
    }

     public function action_sortcv($list) {

     	$elements = explode(',', $list);

     	$i = 0;

     	foreach ($elements as $element) {

     		$category = Model_Cv::query()->where('id', $element)->get_one();
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

     		$post = \Model_Post::query()->where('id', $element)->get_one();
     		$post->order_id = $i;
    		$post->save();
    		$i++;

     	}

     	return true;
       
    }

     public function action_sortgallery($list) {

        $elements = explode(',', $list);

        $i = 1;

        foreach ($elements as $element) {

            $post = \Model_Image::query()->where('id', $element)->get_one();
            $post->nth = $i;
            $post->save();
            $i++;

        }

        return true;
       
    }


}
