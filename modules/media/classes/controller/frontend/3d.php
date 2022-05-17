<?php

namespace Media;

class Controller_Frontend_3d extends Controller_Frontend_Post {

    public function before() {

        parent::before();
        $this->dataGlobal['body'] = 'home frontend posts 3d';
    }


    public function action_index($id = NULL) {

        $this->get_media($id, '3d');

        $this->theme->set_partial('content', 'frontend/media/index')->set($this->data, null, false);

    }

}
