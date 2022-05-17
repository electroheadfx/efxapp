<?php

namespace Media;

class Controller_Frontend_Gallery extends Controller_Frontend_Post {

    public function before() {

        parent::before();
        $this->dataGlobal['body'] = 'home frontend posts gallery';

    }

    public function action_index($id = NULL) {

        $this->get_media($id, 'gallery');

        $this->theme->set_partial('content', 'frontend/media/index')->set($this->data, null, false);

    }

}
