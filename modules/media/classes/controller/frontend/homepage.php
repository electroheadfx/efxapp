<?php

namespace Media;

class Controller_Frontend_Homepage extends \Controller_Base_Frontend {

    public function before() {

        parent::before();
        $this->dataGlobal['themes'] = FALSE;
        $this->dataGlobal['docsheader'] = '';
        $this->dataGlobal['sorts_control'] = 'none';

    }
    
    public function action_index($msg = NULL) {

        $this->data['msg'] = $msg;

        $this->dataGlobal['menu_cats'] = array();
        
        $this->theme->set_partial('content', 'media/frontend/homepage/index')->set($this->data, null, false);

    }


}
