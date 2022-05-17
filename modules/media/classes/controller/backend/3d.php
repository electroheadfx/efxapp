<?php

namespace Media;

class Controller_Backend_3d extends Controller_Backend_Post {

    public function before() {

        parent::before();
        $this->dataGlobal['router_post']  = 'admin_media_3d_';
        $this->submodule = $this->dataGlobal['submodule'] = '3d';

    }

    public function action_add($id = 0, $cat = NULL ) {
        
        $this->add_media($id, $this->submodule, $cat);

        $this->theme->set_partial('content', 'backend/add')->set($this->data, null, false);

    }

}
