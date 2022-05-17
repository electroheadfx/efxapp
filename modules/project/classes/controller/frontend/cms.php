<?php

namespace Project;

class Controller_Frontend_Cms extends \Controller_Base_Frontend {


    public function before() {

        parent::before();
        $this->dataGlobal['themes'] = FALSE;
        $this->dataGlobal['docsheader'] = '';

    }

    /**
     * 
     * Show CMS page (managed via menu)
     * 
     */
    
    public function action_index() {

        $this->dataGlobal['body'] = 'cms frontend';
        $this->data = "";
        $this->theme->set_partial('content', 'project/frontend/cms/index')->set($this->data, null, false);
    }


}
