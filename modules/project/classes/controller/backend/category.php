<?php

namespace Project;

class Controller_Backend_Category extends \Controller_Base_Backend {

    public $router_post;

    public function before() {

        parent::before();
        $this->router_post = $this->dataGlobal['router_post']  = 'admin_'.$this->moduleName.'_category_';

    }

    public function action_index() {

    	$this->dataGlobal['pageTitle'] = __('backend.category.manage');

        // Create menus
        $menus = array();                                                                 
        $site = \Project\Model_Menu::query()->order_by('order_id', 'ASC')->get();

        foreach ($site as $key => $menu) {
                $menus[$key] = $menu;
                $menus[$key]['count'] = count(explode(',', $menu->categories));
        }

        if ( \Input::get('menu') !== NULL ) {
            $activedmenu = \Input::get('menu');
            \Cookie::set('category_menu_id', \Input::get('menu'));
        } else {
            $activedmenu = 'all';
            \Cookie::delete('category_menu_id');
        }
        
        $this->dataGlobal['menus'] = $menus;
        $this->dataGlobal['activedmenu'] = $activedmenu;

        // Pagination
        $config = array(
            'pagination_url' => \Uri::current(),
            'total_items'    => \Model_Category::count(),
            'per_page'       => \Config::get('application.setup.page.pagination_global'),
            'uri_segment'    => 'page',
        );
        $this->data['pagination'] = $pagination = \Pagination::forge('category_pagination', $config);

        // Get categories

        if ( $activedmenu == 'all' || empty($activedmenu) ) {
            
            $this->data['categories'] = \Model_Category::query()->offset($pagination->offset)
                    ->limit($pagination->per_page)
                    ->order_by('order_id', 'ASC')
                    ->get();
                               
        } else {

            $categories = explode(',', \Project\Model_Menu::find($activedmenu)->categories);
            foreach ($categories as $key => $category) {
                if ( $category !== "" ) {
                    $this->data['categories'][$key] = \Model_Category::find($category);
                    $this->data['categories'][$key]['menu_id'] = $activedmenu;
                }
            }
        }

        $uncategorized_id = $this->data['uncategorized_id'] = \Model_Category::query()->where('slug', 'uncategorized')->get_one()->id;
        $modules = \Config::get('server.modules');
        
        foreach( $modules as $key => $mod) {
            $this->data['modules'][__('model.post.attribute.exposition.'.$key)] =  'admin_media_'.$key.'_add';
        }

        $posts = \Model_Post::query()->related('categories')->where('categories.id', $uncategorized_id)->get();
        

        if ($posts) {
            foreach( $modules as $key => $mod) {
                $posts_count = \Model_Post::query()->related('categories')->where('categories.id', $uncategorized_id)->where('module', $key)->count();
                if ($posts_count > 0) {
                    $this->data['uncategorized'][$key]['name']   =  $posts_count . ' ' . __('model.category.uncategorized') . ' > ' . __('model.post.attribute.exposition.'.$key);
                    $this->data['uncategorized'][$key]['count']  =  $posts_count;
                }
            }
        }

		$this->theme->set_partial('content', 'backend/category/index')->set($this->data, null, false); 
         
    }


    public function action_add($id = null) {

        $this->data['isUpdate'] = $isUpdate = ($id !== null) ? true : false;

        // Prepare form fieldset
        $form = \Fieldset::forge('category_form', array('form_attributes' => array('class' => 'form-horizontal')));
        $form->add_model('Model_Category');
        $form->add('add', '', array(
            'type' => 'submit',
            'value' => ($isUpdate) ? __('backend.edit') : __('backend.add'),
            'class' => 'btn btn-primary')
        );

        // add names' localisations
        foreach (\Config::get('server.application.lang-order') as $lang) {
            if ( \Config::get('server.application.language') !== $lang )
                $form->add('name_'.$lang, __('model.category.name'), array('type' => 'text', 'id' => 'name_'.$lang ));
        }

        // Get or create the category
        if ($isUpdate) {
            $this->data['category'] = $category = \Model_Category::find($id);
            $this->dataGlobal['pageTitle'] = __('backend.category.edit');
            $exposition = $category->exposition;
        } else {
            $this->data['category'] = $category = \Model_Category::forge();
            $this->dataGlobal['pageTitle'] = __('backend.category.add');
		    $exposition = '';
		}
        
        if ( \Cookie::get('category_menu_id') == "") {
            \Cookie::set('category_menu_id', "all");
        } else {

            if ( \Cookie::get('category_menu_id') !== 'all' && !$isUpdate ) {
                $menu = \Project\Model_Menu::find(\Cookie::get('category_menu_id'));
                $form->field('exposition')->set_value($menu->route);
            }
        }

		$form->populate($category);

		// If category submit
		if (\Input::post('add')) {

			$form->validation()->run();

			if ( ! $form->validation()->error()) {

                $newpermission = $form->validated('exposition');

                if ($category->slug == 'uncategorized') {
                    $slug = 'uncategorized';
                } else {
                    $slug = ($form->validated('slug') != '') ? \Inflector::friendly_title($form->validated('slug')) : \Inflector::friendly_title($form->validated('name'));
                }

                $array_model = array(
                    'name'          => $form->validated('name'),
                    'exposition'    => $newpermission,
                    'slug'          => $slug,
                    'status'        => $form->validated('status'),
                    'permission'    => $form->validated('permission'),
                    'visibility'    => $form->validated('visibility') !== NULL ? 'visible' : 'hidden',
                );

                if (! $isUpdate) {
                    // look at higher order_id category available
                    $array_model['order_id'] = \Model_Category::query()->max('order_id');
                }

                // name localisation
                foreach (\Config::get('server.application.lang-order') as $lang) {
                    if ( \Config::get('server.application.language') !== $lang )
                        $array_model['name_'.$lang] = $form->validated('name_'.$lang);
                }
				
                // Populate the category
				$category->from_array($array_model);
                $folder = $category->slug;

				if ($category->save()) {

                    //here create category folder if no exist
                    // if (! file_exists(DOCROOT.'uploads/'.$folder)) {
                    //     \File::create_dir(DOCROOT.'uploads', $folder, 0755);
                    // }

					// Delete cache
					\Cache::delete('sidebar');
                    // uncategorized post with the category's exposition change
                    if ($isUpdate && $exposition != $newpermission) {
                        $uncategorized_id = \Model_Category::query()->where('slug', 'uncategorized')->get_one()->id;
                        foreach ( \Model_Post::query()->where('category_id', $category->id)->get() as $post ) {
                            $post->category_id = $uncategorized_id;
                            $post->save();
                        }
                    }

                    // update count post
                    \Media\Controller_backend_Post::category_count();

                    if ( \Cookie::get('category_menu_id') == "") {
                        \Cookie::set('category_menu_id', "all");
                    } else {
                        // store category to menu
                        if ( \Cookie::get('category_menu_id') !== 'all' && !$isUpdate ) {

                            $menu = \Project\Model_Menu::find(\Cookie::get('category_menu_id'));
                            $categories = explode(',', $menu->categories);
                            // add new category saved to menu
                            $categories[] = $category->id;
                            // store categories to menu
                            $menu->categories = implode(',', $categories);
                            // save menu
                            $menu->save();
                        }
                    }

					if ($isUpdate)
						\Message::success(__('backend.category.edited'));
					else
						\Message::success(__('backend.category.added'));

					\Response::redirect(\Router::get('admin_project_category') .'?menu=' . \Cookie::get('category_menu_id') );
				
				} else {

					\Message::danger(__('application.error'));
				}

			} else {

				// Output validation errors		
    				// foreach ($form->validation()->error() as $error) {
    				// 	\Message::danger($error);
    				// }
                \Message::danger(__('application.fix-fields-error'));
			}
		}

        if ($category->exposition == 'all') {

            $form->field('slug')->set_type('hidden')->set_value('all');
            $form->field('exposition')->set_type('hidden')->set_value('all');
            $form->field('status')->set_type('hidden')->set_value('published');
            $form->field('permission')->set_type('hidden')->set_value('public');

        }

		$form->repopulate();

		\Config::load('server', true);
		$base = \Config::get('server.active');

		$this->data['form'] = $form;
		$this->data['upload'] = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.upload');
		$this->data['gallery'] = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.gallery');

		$this->theme->set_partial('content', 'backend/category/add')->set($this->data, null, false);
		
    }

    public function action_delete($id = null) {

        $category = \Model_Category::find($id);
        
        $uncategorized_id = \Model_Category::query()->where('slug', 'uncategorized')->get_one()->id;

        // remove category from posts
        foreach (\Model_Post::query()->where('category_id', $id)->get() as $post ) {
            
            $post->category_id = $uncategorized_id;
            $post->save();
        }
        // remove category ID from all menus
        $menus = \Project\Model_Menu::query()->get();
        foreach ($menus as $menu) {
            $categories = explode(',', $menu->categories);
            $key = 0;
            $save_menu = false;
            foreach ($categories as $category_id) {
                if ( $category_id == $id ) {
                    unset($categories[$key]);
                    $save_menu = true;
                }
                $key++;
            }
            if ($save_menu) {
                $menu->categories = implode(',', $categories);
                $menu->save();
            }
        }

        if ($category->delete()) {

			// Delete cache
			\Cache::delete('sidebar');

            // update count post
            \Media\Controller_backend_Post::category_count();
        	
            \Message::success(__('backend.category.deleted'));

        } else {
        	
            \Message::danger(__('application.error'));
        }

        \Response::redirect_back(\Router::get('admin_'.$this->moduleName.'_category'));
    }

}
