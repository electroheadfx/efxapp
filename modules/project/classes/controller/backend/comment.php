<?php

namespace Project;

class Controller_Backend_Comment extends \Controller_Base_Backend {

    public function before() {

        parent::before();
        $this->dataGlobal['router_post']  = 'admin_'.$this->moduleName.'_comment_';

    }

    public function action_index() {

    	$this->dataGlobal['pageTitle'] = __('module.project.backend.comment.manage');

        // Pagination
        $config = array(
            'pagination_url' => \Uri::current(),
            'total_items'    => \Model_Comment::count(),
            'per_page'       => \Config::get('application.setup.page.pagination_global'),
            'uri_segment'    => 'page',
        );

        $this->data['pagination'] = $pagination = \Pagination::forge('comment_pagination', $config);

        // Get comments
        $this->data['comments'] = \Model_Comment::query()
                                        ->offset($pagination->offset)
                                        ->limit($pagination->per_page)
                                        ->order_by('created_at', 'DESC')
                                        ->get();


		$this->theme->set_partial('content', 'backend/comment/index')->set($this->data, null, false); 
    }


    public function action_show($id = null) {

        $this->data['comment'] = $comment = \Model_Comment::find($id);    
        $this->dataGlobal['pageTitle'] = __('comment');

        $this->theme->set_partial('content', 'backend/comment/show')->set($this->data, null, false);
        
    }
    

    public function action_delete($id = null) {

        $comment = \Model_Comment::find($id);
        
        if ($comment->delete()) {
        	
            \Message::success(__('module.project.backend.comment.deleted'));

        } else {
        	
            \Message::danger(__('application.error'));
        }

        \Response::redirect(\Router::get('admin_comment'));
    }

}
