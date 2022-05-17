<?php

/*
    Rest Media for submodule : sketchfab, 3d, video, gallery, blog ...

 */

namespace Media;

class Controller_Backend_Media extends \Controller_Rest {

    public function before() {

        parent::before();

        if ( ! \Auth::check() ) {

            \Response::redirect(\Router::get('user_login'));
            die('Not authorized');

        }

        $this->featured_order = 'random';
        $this->featured_max = 10;
        $this->menu_cats = array();

    }

    /*
    
        end posts
     */

    public function action_change_category() {

        $datapost = \Format::forge(\Input::post('datapost'), 'json')->to_array();
        
        if (\Input::is_ajax() && $datapost and $post_id = $datapost[0] and $action = $datapost[1] and $category = $datapost[2] ) {
            
            $category_id   = $category['category_id'];
            $category_slug = $category['category_slug'];
            $category_name = $category['category_name'];
            $exposition = $category['exposition'];

            $post = \Model_Post::find($post_id);

            switch ($action) {
                case 'selected':
                    // add selected
                    $category = \Model_Category::find($category_id);
                    $post->categories[] = $category;
                    if ( $category->exposition == 'cms' ) {
                        $post->category_id = 1;
                    }
                    $post->save();
                break;
                case 'deselected':
                    // remove deselected
                    unset($post->categories[$category_id]);
                    $post->save();
                    if ( ! \Model_Post::query()->where('id',$post_id )->related('categories')->where('categories.exposition', 'cms')->get_one() ) {
                        $post->category_id = 0;
                        $post->save();
                    }
                break;
                case 'deselected-add-uncategorized':
                    // remove deselected
                    unset($post->categories[$category_id]);
                    $post->save();
                    // add uncategorized
                    $post->categories[] = \Model_Category::find(2);
                    $post->category_id = 0;
                    $post->save();
                break;
                case 'selected-remove-uncategorized':
                    // add selected
                    $category = \Model_Category::find($category_id);
                    $post->categories[] = $category;
                    if ( $category->exposition == 'cms' ) {
                        $post->category_id = 1;
                    }
                    $post->save();
                    // remove uncategorized
                    unset($post->categories[2]);
                    $post->save();
                break;
                default:
                    \Log::error('no action on jquery chosen in admin_grid');
                break;
            }
           
           Controller_backend_Post::category_count();
           
            return $this->response(array(
                    'post_id'       => strtolower($post_id),
                    'action'        => $action,
                    'category_slug' => strtolower($category_slug),
                    'category_name' => strtolower($category_name)
                ), 200
            );
        }
        return false;

    }

    # admin_media_categorize
    public function action_categorize($id, $module, $uncategory_id) { 
        
        $posts = \Model_Post::query()->related('categories')->where('categories.id', $uncategory_id)->where('module', $module)->get();
        foreach ($posts as $post) {

            // remove uncategorized
            unset($post->categories[2]);
            $post->save();

            $post->categories[] = \Model_Category::find($id);
            $post->save();
        }
        // update category count
        Controller_backend_Post::category_count();
        // redirect to category module
        \Response::redirect(\Router::get('admin_project_category'));
    }


    public function action_force($module, $id = null) {

        $post = \Model_Post::find($id);

        if ( isset($post) ) {

            $post->edit = 0;

            if ($post->save()) {

                \Message::danger(__('module.media.backend.post_forced'));

            } else {

                \Message::danger(__('application.error'));
            }
        }

        \Response::redirect_back(\Router::get('admin_media_'.$module));

    }

    /*
        Change attributes on a module and a model

     */

    public function action_attribute_module($model_m, $module, $id = null, $action = null, $value = null) {

        // $model        $module
        // media_cv      media_cv
        // post          media_video
        // post          media_sketchfab
        // post          media_3d
        // post          media_gallery
        // category      project_category
        
        if ($model_m == '_') {
            $model_space = '';
            $model_orm = $module;

        } else {

            $model_array = explode('_', $model_m);
            
            if (isset($model_array[1])) {

                $model_space = '\\'.ucfirst($model_array[0]).'\\';
                $model_orm = ucfirst($model_array[1]);

            } else {

                $model_space = '\\';
                $model_orm = $model_array[0];

            }
        }

        // $namespace_path = '\\Media\Model_'.ucfirst($module);
        $namespace_path = $model_space.'Model_'.$model_orm;
        $post = $namespace_path::find($id);
        $model = $namespace_path::properties();
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
                    if ($action != 'featured')
                        Controller_backend_Post::category_count();
                }
                

            }
        }
        if (\Input::is_ajax()) {
            
            switch ($action) {
                case 'status':
                    $property_test = 'published';
                    $icon = \Config::get('server.application.attributes-icon.'.$action);
                    break;
                case 'permission':
                    $property_test = 'public';
                    $icon = \Config::get('server.application.attributes-icon.'.$action);
                    break;
                case 'featured':
                    $property_test = 'yes';
                    $icon = \Config::get('server.application.attributes-icon.'.$action);
                    break;
                case 'locked':
                    $property_test = 'yes';
                    $icon = \Config::get('server.application.attributes-icon.'.$action);
                    break;
                case 'visibility':
                    $property_test = 'visible';
                    $icon = \Config::get('server.application.attributes-icon.'.$action);
                    break;
            }

            // data
            // model/module/id/action/property
            // model/gallery/71/status/draft

            return $this->response(array(
                'html' => \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($status == $property_test) ? $icon[0] : $icon[1], 'title' => 'model.post.'.$action, 'value' => 'model.post.attribute.'.$action.'.'.$status ))->render(),
                'url'  => '/media/admin/media/attribute_module/'.$model_m.'/'.$module.'/'.$id.'/'.$action.'/'.$status
            ));

        } else {
            // \Response::redirect_back(\Router::get('admin_media_'.$module));
            \Response::redirect_back(\Router::get('admin_'.$module));
        }

    }

    public function action_delete($module, $ids = null) {

        if (\Input::is_ajax()) {
            return true;
        }

        $ids = explode(',', $ids);

        $success_posts = '';
        $error_posts = '';
        $success = false;
        $error = false;

        foreach ($ids as $id) {

            $post = \Model_Post::find($id);

            if ( isset($post) ) {

                // update category count
                Controller_backend_Post::category_count();

                if ($post->delete()) {

                    // Delete cache
                    \Cache::delete('sidebar');
                    
                    // delete images
                    $imageDB = \Model_Image::query()->where('post_id', $id)->get_one();
                    $imagesDB = \Model_Image::query()->where('post_id', $id)->get();
                    if ($imageDB ) {

                        $name = $imageDB->name;

                        // path files
                        $path = 'media/'.$module.'/';
                        $filename           = $path . 'output/' . $name;
                        $filename_cover     = $path . 'output/cover_' . $name;
                        $filename_thumb = $path . 'output/thumb_' . $name;
                        $filename_hd        = $path . 'output/web_hd_' . $name;
                        $originalefilename  = $path . 'original/' . $name;

                        if ($imageDB->delete()) {

                            // test if file exists, if so, remove
                            if (file_exists($filename)) {
                                unlink($filename);
                            }

                            if (file_exists($filename_cover)) {
                                unlink($filename_cover);
                            }

                            if (file_exists($filename_thumb)) {
                                unlink($filename_thumb);
                            }

                            if (file_exists($filename_hd)) {
                                unlink($filename_hd);
                            }

                            if (file_exists($originalefilename)) {
                                unlink($originalefilename);
                            }

                            // array_map('unlink', glob("some/dir/*.txt"));

                        }

                        foreach ($imagesDB as $image) {

                            if (isset($image->mode)) {
                                if ($image->mode == "image") {
                                    $name = $image->name;
                                    $filename_hd        = $path . 'output/web_hd_' . $name;
                                    $originalefilename  = $path . 'original/' . $name;

                                    if ($image->delete()) {

                                        if (file_exists($originalefilename)) {
                                            unlink($originalefilename);
                                        }

                                        if (file_exists($filename_hd)) {
                                            unlink($filename_hd);
                                        }
                                    }
                                }
                            }

                        }

                    }
                    $success = true;
                    $success_posts = $success_posts . "$id,";

                } else {
                    
                    $error = true;
                    $error_posts = $error_posts . "$id,";

                }
            }
        }

        if ($error)
            \Message::danger(__('application.error').'. Post ID '.substr($error_posts, 0, -1).'.');
        
        if ($success)
            \Message::success(__('module.media.backend.post.deleted').'. Post ID '.substr($success_posts, 0, -1).'.');

        $back = \Cookie::get($module.'_menu_id') !== NULL ? '?menu='.\Cookie::get($module.'_menu_id').'&category=all' : '';
        $back_to_submodule = \Cookie::get('back_to_submodule');
        if ( $back_to_submodule !== NULL ) {
            \Response::redirect(\Router::get('admin_media_'.$back_to_submodule).$back); 
        } else {
            \Response::redirect(\Router::get('admin_media_'.$module).$back); 
        }
    }

    public function action_exit($module = false, $id = false, $category = false) {

        if (\Input::is_ajax()) {
            return true;
        }
        $id == 'false' and $id = false;
        $module == 'false' and $module = false;
        if (!$id && !$module) {
                $back = \Cookie::get('category_menu_id') !== NULL ? '?menu='.\Cookie::get('category_menu_id') : ''; 
                \Response::redirect(\Router::get('admin_project_category').$back);
        } else {
            if ($id != NULL) {
                $post = \Model_Post::find($id);
                $post->edit = 0;
                $post->save();
            }
            $back = \Cookie::get($module.'_menu_id') !== NULL ? '?menu='.\Cookie::get($module.'_menu_id') : '';
            $back_to_submodule = \Cookie::get('back_to_submodule');
            $view = '';
            $pagination = \Cookie::get($module.'_current_pagination_menu_'.\Cookie::get($module.'_menu_id')) !== NULL ? '?page='.\Cookie::get($module.'_current_pagination_menu_'.\Cookie::get($module.'_menu_id')) : '';

            if ( \Cookie::get($module.'_view') !== NULL ) {
                \Cookie::get($module.'_view') !== 'index-grid' and $view = \Cookie::get($module.'_view');
            }

            if ( $back_to_submodule !== NULL ) {
                \Response::redirect(\Router::get('admin_media_'.$back_to_submodule).'/'.$view.$pagination);
            } else {
                \Response::redirect(\Router::get('admin_media_'.$module).'/'.$view.$pagination); 
            }
            
        }

    }
}

