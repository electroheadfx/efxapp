<?php

namespace Media;

class Controller_Frontend_Cms extends Controller_Frontend_Post {

    public function before() {

        parent::before();
        $this->dataGlobal['body'] = 'home frontend posts cms';

    }

    public function action_index($id = NULL) {

        $this->get_media($id, 'cms');

        $this->theme->set_partial('content', 'frontend/media/index')->set($this->data, null, false);

    }

    public function action_p($products = NULL) {

        // http://efxdesign.dev/media/frontend/cms/p/Cote-juillet-94,coco-85 -> http://efxdesign.dev/p/Cote-juillet-94,coco-85
        
        $this->dataGlobal['body'] = 'home frontend posts cms mp';
        $this->dataGlobal['dataproduct'] = $products;

        $this->get_media($products, 'products');

        $this->theme->set_partial('content', 'frontend/media/index')->set($this->data, null, false);

    }

}
