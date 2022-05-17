<?php

namespace Media;

class Controller_Backend_Cms extends Controller_Backend_Post {

    public function before() {

        parent::before();
        $this->dataGlobal['router_post']  = 'admin_media_cms_';
        $this->submodule = $this->dataGlobal['submodule'] = 'cms';

    }

    public function action_preview($id = 0, $cat = NULL ) {

        $this->get_media(1, $this->submodule, 'backend');
        $this->theme->set_partial('content', 'frontend/media/index')->set($this->data, null, false);
        $this->theme->set_chrome('content', 'backend/template/chrome/container', 'body')->set('is_post', empty($posts) ? false : true);

    }

    public function action_add($id = 0, $cat = NULL) {
        
        $this->add_media($id, $this->submodule, $cat);

        $this->theme->set_partial('content', 'backend/add')->set($this->data, null, false);

    }

    /*
    public function action_add($id = 0, $cat = '') {

        $this->data['isUpdate'] = $isUpdate = ($id != 0) ? true : false;

        if (! $isUpdate) {

            $this->data['post'] = $post = \Model_Post::forge();
            $this->dataGlobal['pageTitle'] = __('module.cms.backend.post_add');
            $post->from_array(array(
                'name'          => '',
                'module'        => 'cms',
                'category_id'   => 0,
                'slug'          => '',
                'user_id'       => \Auth::get('id'),
                'content'       => '',
                'summary'       => '',
                'status'        => 'published',
                'permission'    => 'public',
                'featured'      => 'no',
                'allow_comments' => 'no',
                // 'comment'       => $form->validated('comment'),
                'edit'          => 0,
                'meta'          => \Config::get('application.seo.frontend.title'),
                'column'        => 'app-thumb.bootstrap.simple',
                'column_open'   => 'app-thumb.bootstrap.triple',
            ));
            $post->save();
            $uncategorized = \Model_Category::query()->where('slug', 'uncategorized')->get_one();
            $post->categories[] = $uncategorized;
            $post->save();
            \Response::redirect(\Router::get('admin_'.$this->moduleName.'_cms_edit').$post->id);
        }

        // Prepare form fieldset
        $form = \Fieldset::forge('post_form', array('form_attributes' => array('class' => 'form-horizontal')));
        $form->add_model('Model_Post');
        $form->add('add', '', array(
            'type' => 'submit',
            'value' => __('backend.edit'),
            'class' => 'btn btn-primary')
        );
        // Create media folder field for froala image import cms
            $categories = \Model_Category::query()->get();

            $ops['all'] =  __('backend.category.all');
            foreach ($categories as $category) {
            	$ops[$category->slug] = $category->name;
            }
            $folder = 'all';
            $imagesrc = '';

        // Get or create the post
            
		$this->data['post'] = $post = \Model_Post::find($id);
        
        if ( $post->edit == 1 && !\Input::post('add')) {

            \Message::danger(__('backend.post_in_editing'));
            \Response::redirect(\Router::get('admin_'.$this->moduleName.'_cms'));

        }
        // setup post to unique edit
        $post->edit = 1;
        $post->save();
        
    	$folder = $post->id;
    	$this->dataGlobal['pageTitle'] = __('module.cms.backend.post_edit');

        // look at image cover
        $cover = \Model_Image::query()->where('post_id', $id)->get_one();
        if ($cover) {
            if ($cover->mode == 'cms') {
                $this->data['cover'] = $cover;
                $crop =  \Format::forge($cover->crop, 'json')->to_array();
                $this->data['slimCrop'] =  $crop['x'].','.$crop['y'].','.$crop['width'].','.$crop['height'];
                $this->data['rotation'] =  $cover->rotation;
                $imagesrc =  '/'.$cover->name;
                // $this->data['encode'] =  \Crypt::encode($cover->name);
            }
        }
        // \Debug::dump($cover->mode);
        // die();

        $form->add('meta', __('backend.post.meta'), array('type' => 'text', 'id' => 'meta' ));

		$form->add('short', __('backend.post.short'), array('type' => 'text', 'value' => '', 'id' => 'short' ));

        $form->add('media', __('backend.media'), array('options' => $ops, 'type' => 'select', 'value' => $folder ));

        // load thumb config
        $default = \Config::get('app-thumb.default');

        // get crop data
        $ops = \Config::get('app-thumb.crop');
        // add crop form
        $form->add('crop', __('backend.crop'), array('options' => $ops, 'type' => 'select', 'value' => $default['crop'] ));

        // get size data
        $ops = \Config::get('app-thumb.size');
        // add size form
        $form->add('size', __('backend.size'), array('options' => $ops, 'type' => 'select', 'value' => $default['size'] ));

        // get algorythm data
        $ops = \Config::get('app-thumb.algorythm');
        // create algorythm form
        $form->add('algorythm', __('backend.algorythm'), array('options' => $ops, 'type' => 'select', 'value' => $default['algorythm'] ));
        
        // $get_category = empty($cat) ? \Model_Category::query()->where('slug', 'uncategorized')->get_one() : \Model_Category::query()->where('slug', $cat)->get_one();
        $form->field('user_id')->set_value( \Auth::get('id') );

        // get column data
        $ops = array();
        foreach (\Config::get('app-thumb.column') as $key => $value) {
            $ops[$key] = __('model.column.'.$value);
        }
        
        // add column thumb form
        $form->add('column', __('model.column.label'), array('options' => $ops, 'type' => 'select', 'value' => 'app-thumb.bootstrap.simple' ));
        // add column view form
        $form->add('column_open', __('model.column.label_open'), array('options' => $ops, 'type' => 'select', 'value' => 'app-thumb.bootstrap.triple' ));

        // $form->field('name')->add_rule('required')->add_rule('min_length', 3);

        $form->populate($post);

		// If POST submit
		if (\Input::post('add')) {

			$form->validation()->run();

			if ( ! $form->validation()->error()) {

				$actual_slug = \Inflector::friendly_title($form->validated('slug'));
                $slug = empty(\Inflector::friendly_title($form->validated('name'))) ? $post->id : strtolower(\Inflector::friendly_title($form->validated('name')));

				if ($form->validated('slug') != '') {
					$slug = $slug != $actual_slug ? $slug : $actual_slug;
                } else {
                    $slug = $post->id;
                }

                $summary = $form->validated('summary') != NULL ? $form->validated('summary') : '';
                $content = $form->validated('content') != NULL ? $form->validated('content') : '';

				// Populate the post
				$post->from_array(array(
					'name' 			=> $form->validated('name'),
                    'module'        => 'cms',
					'slug' 			=> $slug,
					'user_id' 		=> $form->validated('user_id'),
					'content' 		=> $content,
					'summary' 		=> $summary,
					'status' 		=> $form->validated('status'),
					'permission' 	=> $form->validated('permission'),
                    'featured'      => $form->validated('featured'),
                    'allow_comments' => 'no',
                    // 'comment'       => $form->validated('comment'),
                    'edit'          => 0,
                    'short'         => empty($form->validated('short')) ? '' : $form->validated('short'),
                    'meta'          => empty($form->validated('meta')) ? \Config::get('application.seo.frontend.title') : $form->validated('meta'),
					'column' 		=> $form->validated('column') == NULL ? 'app-thumb.bootstrap.simple' : $form->validated('column'),
                    'column_open'   => $form->validated('column_open') == NULL ? 'app-thumb.bootstrap.triple' : $form->validated('column_open'),
				));

                if ($post->save()) {
                    
					// Delete cache
                     \Cache::delete('sidebar');

                    // Category Post count update
                    Self::category_count();

                    \Message::success(__('backend.post.edited'));

                    \Response::redirect(\Router::get('admin_'.$this->moduleName.'_cms'));
                    
				} else {
                    
                    \Message::danger(__('application.error'));
                }

			} else {

				// Output validation errors		
					foreach ($form->validation()->error() as $error) {
						\Message::danger($error);
					}
				// \Message::danger(__('application.fix-fields-error'));
			}
		}

        // if (  $post->slug == ""  ) $form->field('slug')->set_value($post->id);
        // $form->field('name')->add_rule('required')->add_rule('min_length', 3);

		$form->repopulate();

		$base = \Config::get('server.active');

		$this->data['form'] 	          = $form;

        $this->data['id']                 = $post->id;
        $this->data['slug']               = $post->slug;
        $this->data['save']               = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.save');

        $this->data['upload']             = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.upload');
        $this->data['slim_upload_cover']  = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.upload_slim_cover');
        $this->data['gallery_slim_cover'] = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.gallery_slim_cover').'/cms'.$imagesrc;
		$this->data['slim_remove_cover']  = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.slim_remove_cover');
		$this->data['delete'] 	          = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.delete');
		$this->data['cms'] 	              = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.gallery');
		$this->data['folder'] 	          = $folder;
		$this->data['crop'] 	          = $default['crop'];
		$this->data['size'] 	          = $default['size'];
		$this->data['algorythm']          = $default['algorythm'];
        $this->dataGlobal['body']         = 'backend add';
		
		$this->theme->set_partial('content', 'backend/cms/add')->set($this->data, null, false);
		
        // http://efxdesign.dev/media/admin/gallery/add/39
        // http://efxdesign.dev/media/admin/cms/add/39

    } */

}
