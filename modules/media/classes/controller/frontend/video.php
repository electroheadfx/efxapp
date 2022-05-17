<?php

namespace Media;

class Controller_Frontend_Video extends Controller_Frontend_Post {

    public function before() {

        parent::before();
        $this->dataGlobal['body'] = 'home frontend posts video';
    }
    
    public function action_index($id = NULL) {
    	
        $this->get_media($id, 'video');

        $this->theme->set_partial('content', 'frontend/media/index')->set($this->data, null, false);

    }

}
