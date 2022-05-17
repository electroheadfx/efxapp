<?php

namespace Media;

class Controller_Frontend_Cv extends \Controller_Base_Frontend {

    public function before() {

        parent::before();
        $this->dataGlobal['themes'] = FALSE;
        $this->dataGlobal['docsheader'] = '';

    }

    /**
     * 
     * Get all posts
     * 
     */
    
    public function action_index($id = NULL) {

        $this->dataGlobal['body'] = 'home frontend posts';
        
        $sorts_default = $this->dataGlobal['sorts_default'];

        if ( $sorts_default != 'desc' && $sorts_default != 'asc' ) {
            $sorts_default = 'asc';
        }

        // Get posts
        $posts = \Media\Model_Cv::query()->where('status','published')->order_by('order_id', $sorts_default)->get();
        
        $posts = $this->data['posts'] = array_values($posts);

        $this->theme->set_partial('content', 'media/frontend/cv/index')->set($this->data, null, false);
    }


}
