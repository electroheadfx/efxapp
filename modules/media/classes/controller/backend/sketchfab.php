<?php

namespace Media;

class Controller_Backend_Sketchfab extends Controller_Backend_Post {

    public function before() {

        parent::before();
        $this->dataGlobal['router_post']  = 'admin_media_sketchfab_';
        $this->submodule = $this->dataGlobal['submodule'] = 'sketchfab';

    }

    public function action_add($id = 0, $cat = NULL ) {
        
        $this->add_media($id, $this->submodule, $cat);

        $this->theme->set_partial('content', 'backend/add')->set($this->data, null, false);

    }

}
