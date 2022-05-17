<?php

namespace Media;

class Controller_Backend_Cv extends \Controller_Base_Backend {

    public function before() {

        parent::before();
        $this->dataGlobal['router_post']  = 'admin_'.$this->moduleName.'_post_';
        $this->dataGlobal['submodule'] = 'cv';

    }


    public function action_index($by = 'order_id', $desc = 'asc') {

    	$this->dataGlobal['pageTitle'] = __('module.cv.backend.post_manage');

        // Pagination
        $config = array(
            'pagination_url' => \Uri::current(),
            'total_items'    => Model_Cv::count(),
            'per_page'       => \Config::get('application.setup.page.pagination_global'),
            'uri_segment'    => 'page',
        );
        $this->data['pagination'] = $pagination = \Pagination::forge('cv_pagination', $config);

        // Get posts
        $posts = $this->data['posts'] = Model_Cv::query()
	                                ->offset($pagination->offset)
	                                ->limit($pagination->per_page)
	                                ->order_by($by, $desc)
	                                ->get();
	    $desc_inv = $desc == 'desc' ? 'asc' : 'desc';

        $this->dataGlobal['body'] = 'backend posts';

		$this->theme->set_partial('content', 'backend/cv/index')
            ->set('by', $by)
            ->set('desc', $desc)
            ->set('desc_inv', $desc_inv)
            ->set($this->data, null, false); 
    }

    public function action_force($id = null) {

        $post = Model_Cv::find($id);
        $post->edit = 0;

        if ($post->save()) {

            \Message::danger(__('backend.post_forced'));

        } else {

            \Message::danger(__('application.error'));
        }

        \Response::redirect_back(\Router::get('admin_'.$this->moduleName.'_cv'));

    }


    public function action_add($id = NULL) {
        
        $this->data['isUpdate'] = $isUpdate = ($id !== NULL) ? true : false;

        // Prepare form fieldset
        $form = \Fieldset::forge('post_form', array('form_attributes' => array('class' => 'form-horizontal')));
        $form->add_model('Media\Model_Cv');
        $form->add('add', '', array(
            'type' => 'submit',
            'value' => ($isUpdate) ? __('backend.edit') : __('backend.add'),
            'class' => 'btn btn-primary')
        );

        // Get or create the post
        
        if ($isUpdate) {
            
            $this->data['post'] = $post = Model_Cv::find($id);
            $this->dataGlobal['pageTitle'] = __('module.cv.backend.post_edit');

            if ( $post->edit == 1 && !\Input::post('add')) {

                \Message::danger(__('backend.post_in_editing'));
                \Response::redirect(\Router::get('admin_'.$this->moduleName.'_cv'));

            }
            // setup post to unique edit
            $post->edit = 1;
            $post->save();

        } else {

            $this->data['post'] = $post = Model_Cv::forge();
            $this->dataGlobal['pageTitle'] = __('module.cv.backend.post_add');
        }
        
        $form->field('user_id')->set_value( \Auth::get('id') );

        $form->populate($post);

		// If POST submit
		if (\Input::post('add')) {

			$form->validation()->run();

			if ( ! $form->validation()->error()) {

                $summary = $form->validated('summary') != NULL ? $form->validated('summary') : '';
                
				// Populate the post
				$post->from_array(array(
					'name' 			=> $form->validated('name'),
					'user_id' 		=> $form->validated('user_id'),
					'summary' 		=> $summary,
					'status' 		=> $form->validated('status'),
					'permission' 	=> $form->validated('permission'),
					'featured' 		=> $form->validated('featured'),
                    'edit'          => 0,
                    'column'        => $form->validated('column') == NULL ? 'app-thumb.bootstrap.single' : $form->validated('column'),
				));

                if ($post->save()) {
                    
					// Delete cache
                     \Cache::delete('sidebar');

					if ($isUpdate) {

						\Message::success(__('backend.post.edited'));

                    } else {

						\Message::success(__('backend.post.added'));
					    \Response::redirect_back(\Router::get('admin_'.$this->moduleName.'_cv'));
                        
                    }

                    if (\Input::post('add') == __('application.save')) {
                        
                        \Response::redirect(\Router::get('admin_'.$this->moduleName.'_cv'));
                    }
                    
                    
				}
				else
				{
					\Message::danger(__('application.error'));
				}

			} else {

				// Output validation errors		
					foreach ($form->validation()->error() as $error) {
						\Message::danger($error);
					}
				\Message::danger(__('application.fix-fields-error'));
			}
		}

		$form->repopulate();

		$base = \Config::get('server.active');

		$this->data['form'] 	          = $form;

        $this->data['id']                 = $post->id;

        $this->data['column']             = \Config::get( empty($post->column) ? 'app-thumb.bootstrap.full' : $post->column );

        // $this->data['save']               = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.save');

        $this->dataGlobal['body']         = 'backend add';
		
		$this->theme->set_partial('content', 'backend/cv/add')->set($this->data, null, false);
		
    }

    public function action_exit($id = NULL, $category = false) {
        if ($id != NULL) {
            $post = Model_Cv::find($id);
            $post->edit = 0;
            $post->save();
        }
        if ($category)
            \Response::redirect(\Router::get('admin_project_category'));
        else
            \Response::redirect(\Router::get('admin_media_cv'));


    }

    public function action_attribute($id = null, $action = null, $value = null) {

    	$post = Model_Cv::find($id);
    	$model = Model_Cv::properties();
    	$properties = $model[$action]['form']['options'];
    	$previous_propertie = $post->$action;

    	foreach ($properties as $key => $v) {
    		if ($key != $value) {
    			$status = $key;
    		}
    	}

    	if ($post) {

    		$post->$action = $status;

    		if($post->save()) {

    			if ( $post->$action != $previous_propertie ) {

					\Cache::delete('sidebar');
    			}
				

    		}
    	}

    	\Response::redirect_back(\Router::get('admin_'.$this->moduleName.'_cv'));

    }

    public function action_delete($id = null) {

        $post = Model_Cv::find($id);
        $published = ($post->status == 'published' && $post->permission == 'public') ? true : false;
        
        if ($post->delete()) {

			// Delete cache
			\Cache::delete('sidebar');

            // delete images
            $imageDB = \Model_Image::query()->where('post_id', $id)->get_one();

            if ($imageDB ) {

                $name = $imageDB->name;

                // path files
                $path = 'media/video/';
                $filename = $path . 'output/' . $name;
                $originalefilename = $path . 'original/' . $name;

                if ($imageDB->delete()) {

                    // test if file exists, if so, remove
                    if (file_exists($filename)) {
                        unlink($filename);
                    }

                    if (file_exists($originalefilename)) {
                        unlink($originalefilename);
                    }
                }
            }
        	
            \Message::success(__('backend.post.deleted'));

        } else {
        	
            \Message::danger(__('application.error'));
        }

        \Response::redirect(\Router::get('admin_'.$this->moduleName.'_cv'));
    }

    public function after($response) {
            
        $license_FroalaEditor = " $.FroalaEditor.DEFAULTS.key = '" . \Config::get('application.setup.services.froala_editor_license') . "';";
        $this->theme->asset->js($license_FroalaEditor, array(), 'script', true);
        
        return parent::after($response);
    }

}
