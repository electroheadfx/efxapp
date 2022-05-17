<?php

namespace Media;

class Controller_Backend_Video extends Controller_Backend_Post {

    public function before() {

        parent::before();
        $this->dataGlobal['router_post']  = 'admin_media_video_';
        $this->submodule = $this->dataGlobal['submodule'] = 'video';

    }
    public function action_add($id = 0, $cat = NULL) {
        
        $this->add_media($id, $this->submodule, $cat);

        $this->theme->set_partial('content', 'backend/add')->set($this->data, null, false);

    }

    public function action_preview($id = 0, $cat = NULL ) {

        $this->get_media($id, $this->submodule, 'backend');
        $this->theme->set_partial('content', 'frontend/media/index')->set($this->data, null, false);
        $this->theme->set_chrome('content', 'backend/template/chrome/container', 'body')->set('is_post', empty($posts) ? false : true);

    }


}
