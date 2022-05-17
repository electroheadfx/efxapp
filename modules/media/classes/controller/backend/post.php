<?php

namespace Media;

class Controller_Backend_Post extends \Controller_Base_Backend {

    public function before() {

        parent::before();

    }

    public function action_preview($id = NULL, $cat = NULL ) {

        if ($id == NULL) {
            if ( \Cookie::get($this->submodule.'_menu_id') !== NULL )
                $id = \Cookie::get($this->submodule.'_menu_id');
            else
                $id = 1;
        }

        \Cookie::set($this->submodule.'_view', 'preview');

        $preview_menu = \Project\Model_Menu::find($id);
        $preview_categories = explode(',', $preview_menu->categories);
        $this->dataGlobal['menu_cats'] = array();
        foreach ($preview_categories as $id_cat) {
            $this->dataGlobal['menu_cats'][] = \Model_Category::find($id_cat);
        }
        $this->get_media($id, $this->submodule, 'backend');

        $this->theme->set_partial('content', 'frontend/media/index')->set($this->data, null, false);
        $this->theme->set_chrome('content', 'backend/template/chrome/container', 'body')->set('is_post', empty($posts) ? false : true);

    }

    public function add_media($id, $media, $cat) {

        $this->data['isUpdate'] = $isUpdate = ($id != 0) ? true : false;

        if (! $isUpdate) {

            $this->data['post'] = $post = \Model_Post::forge();

            $this->dataGlobal['pageTitle'] = __('module.'.$media.'.backend.post_add');
            $array_base = array(
                'name'              => '',
                'module'            => $media,
                'category_id'       => 0,
                'slug'              => '',
                'user_id'           => \Auth::get('id'),
                'content'           => '',
                'summary'           => '',
                'status'            => 'published',
                'permission'        => 'public',
                'featured'          => 'no',
                'locked'            => 'no',
                'allow_comments'    => 'no',
                // 'comment'        => $form->validated('comment'),
                'edit'              => 0,
                'meta'              => \Config::get('application.seo.frontend.title'),
                'column'            => 'app-thumb.bootstrap.simple',
                'column_open'       => 'app-thumb.bootstrap.triple',
                'image_output'      => 'thumb_image',
                'fullscreen'        => 'yes',
                'title_expander'    => 'collapse',
                'content_expander'  => 'collapse',
                'content_expander_ui'=> 'on',
                'content_caesura'   => 'on',
                'summary_caesura'   => 'on',
                'summary_expander'  => 'collapse',
                'summary_expander_ui'=> 'on',
                'summary_to_content'=> 'no',
                'postborder'        => 'hidden',
                'contentborder'     => 'hidden',
            );

            $array_media = array();

            switch ($media) {
                case 'gallery':
                    $array_media = array(
                        'flickity_nav'  => 'yes',
                        'flickity_play' => 'yes',
                        'flickity_delay'=> 3000,
                        'crops'         => 'fitprimary_crop',
                    );
                break;
                case 'video':
                    $array_media = array(
                        'enginevideo'   => 'vimeo',
                        'idvideo'       => '',
                    );
                break;
                case 'sketchfab':
                    $array_media = array(
                        'sketchfab'     => '',
                    );
                break;
                case '3d':
                    $array_media = array(
                        'bb3d'     => '',
                    );
                break;
            }

            // add $array_media to $array_base
            \Arr::insert_assoc($array_base, $array_media, 0);

            // add final array to new post
            $post->from_array($array_base);
            
            $post->save();

            if ( empty(\Input::get('cat')) ) {
                $category = \Model_Category::query()->where('slug', $cat)->get_one();
            } else {
                $category = \Model_Category::query()->where('id', \Input::get('cat'))->get_one();
            }

            if ($category === NULL ) {
                $uncategorized = \Model_Category::query()->where('slug', 'uncategorized')->get_one();
                $post->categories[] = $uncategorized;
            } else {
                $post->categories[] = $category;
            }

            $post->save();

            \Response::redirect(\Router::get('admin_'.$this->moduleName.'_'.$media.'_edit').$post->id);

        }

        // Prepare form fieldset
        $form = \Fieldset::forge('post_form', array('form_attributes' => array('class' => 'form-horizontal')));
        $form->add_model('Model_Post');
        $form->add('add', '', array(
            'type' => 'submit',
            'value' => __('backend.edit'),
            'class' => 'btn btn-primary')
        );
        $form->add('addexit', '', array(
            'type' => 'submit',
            'value' => __('backend.edit'),
            'class' => 'btn btn-primary')
        );
        // Create media folder field for froala image import media
            /*$categories = \Model_Category::query()->get();

            $ops['all'] =  __('backend.category.all');
            foreach ($categories as $category) {
                $ops[$category->slug] = $category->name;
            }
            ;*/

        $folder = 'all';
        $imagesrc = '';

        // Get or create the post
            
        $this->data['post'] = $post = \Model_Post::find($id);
        
        if ( $post->edit == 1 && !\Input::post('add') && !\Input::post('addexit')  ) {
            \Message::danger(__('backend.post_in_editing'));
            \Response::redirect(\Router::get('admin_'.$this->moduleName.'_'.$media));

        }

        // setup post to unique edit
        $post->edit = 1;
        $post->save();
        
        $folder = $post->id;
        $this->dataGlobal['pageTitle'] = __('module.'.$media.'.backend.post_edit');

        // look at image cover
        $images = \Model_Image::query()->where('post_id', $id)->get();

        $cover = false;
        $addimages = [];
        foreach ($images as $image) {
            if ($image->mode == $media) $cover = $image;
            if ($image->mode == "image") $addimages[$image->nth] = $image;
        }
        // sort array by nth
        ksort($addimages);

        if ($cover) {
            \Efx\Controller_Upload::thumb($cover->path, $cover->name, $cover->type).'?'.rand();
            $this->data['cover'] = $cover;
            $format = \Format::forge($cover->cover, 'json')->to_array();
            $this->data['cover_width'] = $format['width'];
            $this->data['cover_height'] = $format['height'];
            $crop =  \Format::forge($cover->crop, 'json')->to_array();
            $this->data['slimCrop'] =  $crop['x'].','.$crop['y'].','.$crop['width'].','.$crop['height'];
            $this->data['rotation'] =  $cover->rotation;

            // detect original image
            $info = pathinfo($cover->name);
            $filename = $info['filename'];
            $original_ext  = $info['extension'];
            $ext = $cover->type;
            
            // setup $imagesrc for SLIM
            if ($original_ext !== $ext) {
                $imagesrc =  '/'.$filename.'.'.$ext;
            } else {
                $imagesrc =  '/'.$cover->name;
            }

        }
        // slimCrop
        foreach ($addimages as $image) {
            $crop =  \Format::forge($image->crop, 'json')->to_array();
            $format = \Format::forge($image->cover, 'json')->to_array();
            $image->slimcrop = $crop['x'].','.$crop['y'].','.$crop['width'].','.$crop['height'];
            $image->cover = array('width' => $format['width'], 'height' => $format['height']);
        }
        
        $this->data['addimages'] = $addimages;

        $form->add('meta', __('backend.post.meta'), array('type' => 'text', 'id' => 'meta' ));

        $form->add('short', __('backend.post.short'), array('type' => 'text', 'value' => '', 'id' => 'short' ));

        // Froala image management
            // Image folders for Froala CMS upload
            $ops = ['gallery'=>'Gallery', 'blog' => 'Blog', 'video'=>'Video', 'menu'=>'Menu', 'sketchfab'=>'Sketchfab', 'b3d'=>'3D'];
            $form->add('media', __('backend.media'), array('options' => $ops, 'type' => 'select', 'value' => $media ))->set_value($media);

            // load thumb config
            $default = \Config::get('app-thumb.default');

            // get crop data
            $ops = \Config::get('app-thumb.crop');
            // add crop form
            $form->add('crop', __('backend.crop'), array('options' => $ops, 'type' => 'select', 'value' => $default['crop'] ));

            // get size data
            $ops = [];
            foreach (\Config::get('app-thumb.size') as $key => $value) {
                $ops[$key] = __($value);
            }
            // add size form
            $form->add('size', __('backend.size'), array('options' => $ops, 'type' => 'select', 'value' => $default['size'] ));

            // get algorythm data
            $ops = [];
            foreach (\Config::get('app-thumb.algorythm') as $key => $value) {
                $ops[$key] = __($value);
            }
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
        
        // get image_output data
        $ops = array();
        $ops['thumb']       = __('model.image.thumb');
        $ops['text']        = __('model.image.text');
        $ops['text_image']  = __('model.image.text_image');
        $ops['thumb_image'] = __('model.image.thumb_image');
        $form->add('image_output', __('model.image.image_output'), array('options' => $ops, 'type' => 'select', 'value' => 'thumb_image' ));

        // active or not fullscreen gallery
        $ops = array();
        $form->add('fullscreen', __('model.fullscreen.fullscreen'), array('type' => 'checkbox', !isset($post->fullscreen) ? 'checked' : '', 'value'=> 'yes', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('model.fullscreen.no'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('model.fullscreen.yes'), 'data-onstyle'=>'warning', 'data-offstyle'=>'default', 'id' => 'fullscreen', 'data-width' => '100%'  ));

        // get crop presets data
        $ops = array();
        $ops['16:10']   = __('model.crop_presets.1610');
        $ops['16:9']    = __('model.crop_presets.169');
        $ops['5:3']     = __('model.crop_presets.53');
        $ops['5:4']     = __('model.crop_presets.54');
        $ops['4:3']     = __('model.crop_presets.43');
        $ops['3:2']     = __('model.crop_presets.32');
        $ops['1:1']     = __('model.crop_presets.11');
        $ops['free']    = __('model.crop_presets.free');
        $form->add('crop_presets', __('model.crop_presets.crop'), array('options' => $ops, 'type' => 'select', 'value' => 'free' ));
        
        // get crop orientation data
        $form->add('orientation', __('model.orientation.orient'), array('type' => 'checkbox', !isset($post->orientation) ? 'checked' : '', 'value'=> 'horyzontale', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-toggle-off"></i> '. __('model.orientation.horyzontale'), 'data-off' => '<i class="fa fa-toggle-on"></i> '. __('model.orientation.vertical'), 'data-onstyle'=>'default', 'data-offstyle'=>'default', 'id' => 'orientation', 'data-width' => '100%' ));

         // title_expander
        $form->add('title_expander', __('model.title_expander.expander'), array('type' => 'checkbox', !isset($post->title_expander) ? 'checked' : '', 'value'=> 'expand', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('model.title_expander.collapse'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('model.title_expander.expand'), 'data-onstyle'=>'primary', 'data-offstyle'=>'default', 'id' => 'title_expander', 'data-width' => '100%' ));

        // content_expander
        $form->add('content_expander', __('model.content_expander.expander'), array('type' => 'checkbox', !isset($post->content_expander) ? 'checked' : '', 'value' => 'expand', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('model.content_expander.collapse'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('model.content_expander.expand'), 'data-onstyle'=>'primary', 'data-offstyle'=>'default', 'id' => 'content_expander', 'data-width' => '100%' ));
        
        // content_expander_ui
        $form->add('content_expander_ui', __('model.content_expander_ui.expander'), array('type' => 'checkbox', !isset($post->content_expander_ui) ? 'checked' : '', 'value' => 'on', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('model.content_expander_ui.off'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('model.content_expander_ui.on'), 'data-onstyle'=>'primary', 'data-offstyle'=>'default', 'id' => 'content_expander_ui', 'data-width' => '100%' ));

        $form->add('content_caesura', __('model.content_caesura.caesura'), array('type' => 'checkbox', !isset($post->content_caesura) ? 'checked' : '', 'value' => 'on', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('model.content_caesura.off'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('model.content_caesura.on'), 'data-onstyle'=>'primary', 'data-offstyle'=>'default', 'id' => 'content_caesura', 'data-width' => '100%' ));
        $form->add('summary_caesura', __('model.content_caesura.caesura'), array('type' => 'checkbox', !isset($post->summary_caesura) ? 'checked' : '', 'value' => 'on', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('model.content_caesura.off'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('model.content_caesura.on'), 'data-onstyle'=>'primary', 'data-offstyle'=>'default', 'id' => 'content_caesura', 'data-width' => '100%' ));

        // summary_expander
        $form->add('summary_expander', __('model.summary_expander.expander'), array('type' => 'checkbox', !isset($post->summary_expander) ? 'checked' : '', 'value' => 'expand', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('model.summary_expander.collapse'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('model.summary_expander.expand'), 'data-onstyle'=>'primary', 'data-offstyle'=>'default', 'id' => 'summary_expander', 'data-width' => '100%' ));
        
        // summary_expander_ui
        $form->add('summary_expander_ui', __('model.summary_expander_ui.expander'), array('type' => 'checkbox', !isset($post->summary_expander_ui) ? 'checked' : '', 'value' => 'on', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('model.summary_expander_ui.off'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('model.summary_expander_ui.on'), 'data-onstyle'=>'primary', 'data-offstyle'=>'default', 'id' => 'summary_expander_ui', 'data-width' => '100%' ));

        // summary_to_content
        $form->add('summary_to_content', __('model.summary_to_content.label'), array('type' => 'checkbox', !isset($post->summary_to_content) ? 'checked' : '', 'value' => 'yes', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('model.summary_to_content.no'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('model.summary_to_content.yes'), 'data-onstyle'=>'primary', 'data-offstyle'=>'default', 'id' => 'summary_to_content', 'data-width' => '100%' ));

        // summary and content visibility switcher
        $form->add('summary_switch', __('module.project.backend.menu.summary_switch'), array('type' => 'checkbox', !isset($post->summary_switch) ? 'checked' : '', 'value'=> true, 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-eye-slash"></i> '. __('module.project.backend.menu.summary_switch_off'), 'data-on' => '<i class="fa fa-eye"></i> '. __('module.project.backend.menu.summary_switch_on'), 'data-onstyle'=>'success', 'data-offstyle'=>'default', 'id' => 'summary_switch', 'data-width' => '100%' ));
        $form->add('content_switch', __('module.project.backend.menu.summary_switch'), array('type' => 'checkbox', !isset($post->content_switch) ? 'checked' : '', 'value'=> true, 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-eye-slash"></i> '. __('module.project.backend.menu.content_switch_off'), 'data-on' => '<i class="fa fa-eye"></i> '. __('module.project.backend.menu.content_switch_on'), 'data-onstyle'=>'success', 'data-offstyle'=>'default', 'id' => 'content_switch', 'data-width' => '100%' ));

        // setup summary background color
        $ops = [ 'default' => __('module.project.backend.theme.default'), 'color' => __('module.project.backend.theme.color'), 'hexa' => __('module.project.backend.theme.hexa'), 'textured' => __('module.project.backend.theme.textured'), 'transparent' => __('module.project.backend.theme.transparent')];
        $form->add('postbgselect', __('backend.post.tabs.postbg'), array('options' => $ops, 'type' => 'select', 'id' => 'postbgselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
        $form->add('postbgdata', '');

        // setup content background color
        $ops = [ 'default' => __('module.project.backend.theme.default'), 'color' => __('module.project.backend.theme.color'), 'hexa' => __('module.project.backend.theme.hexa'), 'textured' => __('module.project.backend.theme.textured'), 'transparent' => __('module.project.backend.theme.transparent')];
        $form->add('contentbgselect', __('backend.post.tabs.postbg'), array('options' => $ops, 'type' => 'select', 'id' => 'contentbgselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
        $form->add('contentbgdata', '');

        // border summer activation
        $form->add('postborder', __('model.postborder.border'), array('type' => 'checkbox', !isset($post->postborder) ? 'checked' : '', 'value'=> 'visible', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('model.postborder.visible'), 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('model.postborder.hidden'), 'data-onstyle'=>'warning', 'data-offstyle'=>'default', 'id' => 'postborder', 'data-width' => '100%' ));
        // setup post summmer border color
        $ops = [ 'default' => __('module.project.backend.theme.default'), 'color' => __('module.project.backend.theme.color'), 'hexa' => __('module.project.backend.theme.hexa')];
        $form->add('postborderselect', __('backend.post.tabs.postborder'), array('options' => $ops, 'type' => 'select', 'id' => 'postborderselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
        $form->add('postborderdata', '');

        // border content activation
        $form->add('contentborder', __('model.contentborder.border'), array('type' => 'checkbox', !isset($post->contentborder) ? 'checked' : '', 'value'=> 'visible', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('model.contentborder.visible'), 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('model.contentborder.hidden'), 'data-onstyle'=>'warning', 'data-offstyle'=>'default', 'id' => 'contentborder', 'data-width' => '100%' ));
        // setup content border color
        $ops = [ 'default' => __('module.project.backend.theme.default'), 'color' => __('module.project.backend.theme.color'), 'hexa' => __('module.project.backend.theme.hexa')];
        $form->add('contentborderselect', __('backend.post.tabs.postborder'), array('options' => $ops, 'type' => 'select', 'id' => 'contentborderselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
        $form->add('contentborderdata', '');

        // create specific form' module
        // 
        switch ($media) {
            case 'gallery':
                // get crop mode data
                $ops = array();
                $ops['fitprimary_crop']       = __('model.crops.fitprimary_crop');
                $ops['independant_crop'] = __('model.crops.independant_crop');
                $form->add('crops', __('model.crops.crops_mode'), array('options' => $ops, 'type' => 'select', 'value' => 'fitprimary_crop' ));

                // flickity_nav
                $form->add('flickity_nav', __('model.flickity_nav.nav'), array('type' => 'checkbox', !isset($post->flickity_nav) ? 'checked' : '', 'value' => 'yes', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-toggle-off"></i> '. __('model.flickity_nav.yes'), 'data-off' => '<i class="fa fa-toggle-on"></i> '. __('model.flickity_nav.no'), 'data-onstyle'=>'default', 'data-offstyle'=>'danger', 'id' => 'flickity_nav', 'data-width' => '100%' ));

                // flickity_play
                $form->add('flickity_play', __('model.flickity_play.play'), array('type' => 'checkbox', isset($post->flickity_nav) ? 'checked' : '', 'value' => 'yes', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-on"></i> '. __('model.flickity_play.no'), 'data-on' => '<i class="fa fa-toggle-off"></i> '. __('model.flickity_play.yes'), 'data-onstyle'=>'warning', 'data-offstyle'=>'default', 'id' => 'flickity_play', 'data-width' => '100%' ));

                // flickity_delay
                $form->add('flickity_delay', __('model.flickity_delay.delay'), array('type' => 'text', 'id' => 'flickity_delay', 'value' => '3000' ));
            break;
            case 'video':
                // video engine
                $ops = array('vimeo' => 'vimeo', 'youtube' => 'youtube');
                $form->add('enginevideo', __('backend.post.engine'), array('options' => $ops, 'type' => 'select', 'value' => 'vimeo' ));
            
                // ID video
                $form->add('idvideo', __('backend.post.idvideo'), array('type' => 'text', 'value' => '', 'id' => 'idvideo' ));
            break;
            case 'sketchfab':
                // sketchfab ID
                $form->add('sketchfab', __('module.sketchfab.backend.post_sketchfab'), array('type' => 'text', 'value' => '', 'id' => 'sketchfab' ));
            break;
            case '3d':
                // sketchfab ID
                $form->add('b3d', __('module.3d.backend.post_3d'), array('type' => 'text', 'value' => '', 'id' => 'b3d' ));
            break;
        }

        // Reset to blank name, summary, content labels for localisation
        $form->field('name')->set_label('');
        $form->field('summary')->set_label('');
        $form->field('content')->set_label('');

        // add name, summary, content and short localisations
        foreach (\Config::get('server.application.lang-order') as $lang) {
            if ( \Config::get('server.application.language') !== $lang ) {
                $form->add('short_'.$lang, __('backend.post.short'), array('type' => 'text', 'id' => 'short_'.$lang ));
                $form->add('name_'.$lang, '', array('type' => 'textarea', 'id' => 'name_'.$lang ));
                $form->add('summary_'.$lang, '', array('type' => 'textarea', 'id' => 'summary_'.$lang ));
                $form->add('content_'.$lang, '', array('type' => 'textarea', 'id' => 'content_'.$lang ));
            }
        }

        // $form->field('name')->add_rule('required')->add_rule('min_length', 3);
        $form->populate($post);

        // If POST submit
        if (\Input::post('add') ) {

            $form->validation()->run();

            if ( ! $form->validation()->error()) {
                
                if ( $form->validated('slug') == '' || \Model_Post::query()->where('slug', $form->validated('slug') )->get_one() ) {

                    if ( empty($form->validated('name')) ) {
                        $slug = $post->id;
                    } else {
                        $slug = \Inflector::friendly_title($form->validated('name')).'-'.$post->id;
                    }

                } else {
                    $slug = $form->validated('slug');
                }

                $content = $form->validated('content') != NULL ? $form->validated('content') : '';
                $summary = $form->validated('summary') != NULL ? $form->validated('summary') : '';
                $name    = $form->validated('name') != NULL ? $form->validated('name') : '';

                $image_output = $form->validated('image_output') == NULL ? 'thumb_image' : $form->validated('image_output');
                // $fullscreen = $image_output == 'thumb' ? 'no' : ($form->validated('fullscreen') !== NULL ? 'no' : 'yes');

                // Populate the post
                $array_base = array(
                    'name'              => $name,
                    'module'            => $media,
                    'slug'              => $slug,
                    'user_id'           => $form->validated('user_id'),
                    'content'           => $content,
                    'summary'           => $summary,
                    'status'            => $form->validated('status'),
                    'permission'        => $form->validated('permission'),
                    'featured'          => $form->validated('featured'),
                    'locked'            => $form->validated('locked'),
                    'allow_comments'    => 'no',
                    // 'comment'        => $form->validated('comment'),
                    'edit'              => 0,
                    'short'             => empty($form->validated('short')) ? '' : $form->validated('short'),
                    'meta'              => empty($form->validated('meta')) ? \Config::get('application.seo.frontend.title') : $form->validated('meta'),
                    'column'            => $form->validated('column') == NULL ? 'app-thumb.bootstrap.simple' : $form->validated('column'),
                    'column_open'       => $form->validated('column_open') == NULL ? 'app-thumb.bootstrap.triple' : $form->validated('column_open'),
                    'image_output'      => $image_output,
                    'fullscreen'        => $form->validated('fullscreen') !== NULL ? 'yes' : 'no',
                    'title_expander'    => $form->validated('title_expander') !== NULL ? 'expand' : 'collapse',
                    'content_expander'  => $form->validated('content_expander') !== NULL ? 'expand' : 'collapse',
                    'content_expander_ui'=> $form->validated('content_expander_ui') !== NULL ? 'on' : 'off',
                    'content_caesura'   => $form->validated('content_caesura') !== NULL ? 'on' : 'off',
                    'summary_caesura'   => $form->validated('summary_caesura') !== NULL ? 'on' : 'off',
                    'summary_expander'  => $form->validated('summary_expander') !== NULL ? 'expand' : 'collapse',
                    'summary_expander_ui'=> $form->validated('summary_expander_ui') !== NULL ? 'on' : 'off',
                    'summary_to_content'=> $form->validated('summary_to_content') !== NULL ? 'yes' : 'no',
                    'summary_switch'    => $form->validated('summary_switch') !== NULL ? true : false,
                    'content_switch'    => $form->validated('content_switch') !== NULL ? true : false,
                    
                    'postbgselect'      => $form->validated('postbgselect'),
                    'postbgdata'        => $form->validated('postbgdata') !== NULL ? $form->validated('navselect') == 'color' ? '#'.$form->validated('postbgdata') : $form->validated('postbgdata') : '',                    

                    'postborderselect'  => $form->validated('postborderselect'),
                    'postborderdata'    => $form->validated('postborderdata') !== NULL ? $form->validated('navselect') == 'color' ? '#'.$form->validated('postborderdata') : $form->validated('postborderdata') : '',                    
                    'postborder'        => $form->validated('postborder') !== NULL ? 'visible' : 'hidden',

                    'contentbgselect'      => $form->validated('contentbgselect'),
                    'contentbgdata'        => $form->validated('contentbgdata') !== NULL ? $form->validated('navselect') == 'color' ? '#'.$form->validated('contentbgdata') : $form->validated('contentbgdata') : '',                    

                    'contentborderselect'  => $form->validated('contentborderselect'),
                    'contentborderdata'    => $form->validated('contentborderdata') !== NULL ? $form->validated('navselect') == 'color' ? '#'.$form->validated('contentborderdata') : $form->validated('contentborderdata') : '',                    
                    'contentborder'        => $form->validated('contentborder') !== NULL ? 'visible' : 'hidden',

                );

                $array_media = array();

                switch ($media) {
                    case 'gallery':
                        $array_media = array(
                            // specific to gallery
                            'flickity_nav'  => $form->validated('flickity_nav') !== NULL ? 'yes' : 'no',
                            'flickity_play' => $form->validated('flickity_play') !== NULL ? 'yes' : 'no',
                            'flickity_delay'=> $form->validated('flickity_delay') == NULL ? 3000 : $form->validated('flickity_delay'),
                            'crops'         => $form->validated('crops') ==! NULL ? $form->validated('crops') : 'fitprimary_crop',
                        );
                    break;
                    case 'video':
                        $array_media = array(
                            // specific to video
                            'enginevideo'   => $form->validated('enginevideo') ==! NULL ? $form->validated('enginevideo') : 'null',
                            'idvideo'       => $form->validated('idvideo') ==! NULL ? $form->validated('idvideo') : 0,
                        );
                    break;
                    case 'sketchfab':
                        $array_media = array(
                            // specific to sketchfab
                            'sketchfab'     => $form->validated('sketchfab'),
                        );
                    break;
                    case '3d':
                        $array_media = array(
                            // specific to 3d
                            'b3d'     => $form->validated('b3d'),
                        );
                    break;
                }

                // add $array_media to $array_base
                \Arr::insert_assoc($array_base, $array_media, 0);

                // name localisation
                foreach (\Config::get('server.application.lang-order') as $lang) {
                    if ( \Config::get('server.application.language') !== $lang ) {
                        $array_base['name_'.$lang]     = $form->validated('name_'.$lang);
                        $array_base['short_'.$lang]    = $form->validated('short_'.$lang);
                        $array_base['content_'.$lang]  = $form->validated('content_'.$lang);
                        $array_base['summary_'.$lang]  = $form->validated('summary_'.$lang);
                    }
                }

                // add final array to new post
                $post->from_array($array_base);

                if ($post->save()) {
                    
                    // Delete cache
                     \Cache::delete('sidebar');

                    // Category Post count update
                    Self::category_count();

                    \Message::success(__('backend.post.edited'));

                    if (\Input::post('add') == __('application.save_and_quit') ) {
                        
                        $back_to_submodule = \Cookie::get('back_to_submodule');
                        $pagination = \Cookie::get($this->submodule.'_current_pagination_menu_'.\Cookie::get($this->submodule.'_menu_id')) !== NULL ? '&page='.\Cookie::get($this->submodule.'_current_pagination_menu_'.\Cookie::get($this->submodule.'_menu_id')) : '';
                        
                        $view = '';
                        if ( \Cookie::get($this->submodule.'_view') !== NULL ) {
                            \Cookie::get($this->submodule.'_view') !== 'index-grid' and $view = \Cookie::get($this->submodule.'_view');
                        }
                        if ( $back_to_submodule !== NULL ) {

                            $category = \Cookie::get('cms_category_id') !== NULL ? '?category='.\Cookie::get('cms_category_id') : '?category=all';
                            $back = \Cookie::get('cms_menu_id') !== NULL ? '&menu='.\Cookie::get('cms_menu_id') : '';
                            \Response::redirect(\Router::get('admin_media_'.$back_to_submodule).'/'.$view.$category.$back.$pagination); 

                        } else {

                            $category = \Cookie::get($media.'_category_id') !== NULL ? '?category='.\Cookie::get($media.'_category_id') : '?category=all';
                            $back = \Cookie::get($media.'_menu_id') !== NULL ? '&menu='.\Cookie::get($media.'_menu_id') : '';                        
                            \Response::redirect(\Router::get('admin_media_'.$back_to_submodule).'/'.$view.$category.$back.$pagination); 
                        }

                    }

                    \Response::redirect(\Router::get('admin_'.$this->moduleName.'_'.$media.'_edit').$post->id);

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

        // if (\Input::post('addexit')) {
        $form->repopulate();
        // }

        $base = \Config::get('server.active');

        $this->data['form']               = $form;

        $this->data['id']                 = $post->id;
        $this->dataGlobal['IDpost']       = $post->id;
        $this->dataGlobal['NAMEpost']     = \Security::strip_tags($post->name);
        $this->data['slug']               = $post->slug;
        $this->data['save']               = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.save');
        $this->data['froala_folder']      = $media;

        $this->data['slim_upload_cover']  = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.upload_slim_cover');
        $this->data['gallery_slim_cover'] = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.gallery_slim_cover').'/'.$media.$imagesrc;
        $this->data['gallery_slim_add']   = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.gallery_slim_add').'/'.$media;
        $this->data['slim_remove_cover']  = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.slim_remove_cover');
        $this->data['back_to_cms']        = \Input::get('back') == '' ? \Input::post('back') : \Input::get('back');
        $this->dataGlobal['body']         = 'backend add';
        if ($media == 'video') {
            $this->data['idvideo'] = $post->idvideo;
        }
        if ($media == 'sketchfab') {
            $this->data['idsketchfab'] = $post->sketchfab;
        }
        if ($media == '3d') {
            $this->data['b3d'] = $post->b3d;
        }
        $this->dataGlobal['menu_cats'] = '';
        $this->data['media'] = $media;
        $this->data['imagesrc_cover'] = $imagesrc;
        $this->data['image_thumb'] = isset($cover->name) ? \Config::get('base_url') . 'media/'.$media.'/output/thumb_' . $cover->name.'?'.rand() : '/assets/img/empty-media.jpg';
                
    }


    public function action_index($view = 'index-grid', $by = 'order_id', $desc = 'asc') {

        $menus = array();                                                             
        $site = \Project\Model_Menu::query()->order_by('order_id', 'ASC')->get();
        \Cookie::set($this->submodule.'_view', $view);

        foreach ($site as $key => $menu) {
            if ( $menu->route == $this->submodule ) {
                $menus[$key] = $menu;
                $menus[$key]['count'] = count(explode(',', $menu->categories));
            }
        }

        $activedmenu = \Input::get('menu');

        if ( empty($activedmenu) ) {
            if ( \Cookie::get($this->submodule.'_menu_id') !== NULL ) {
                $activedmenu = \Cookie::get($this->submodule.'_menu_id');
            } else {
                $activedmenu = 'all';
            }
        }

        // get current pagination number
        if ( !empty(\Input::get('page')) ) {
            \Cookie::set($this->submodule.'_current_pagination_menu_'.$activedmenu, \input::get('page') );
        }
        
        \Cookie::set('back_to_submodule', $this->submodule);
        \Cookie::set($this->submodule.'_menu_id', $activedmenu);

        // $get_category = \Input::get('category') !== NULL ? \Input::get('category') : 'all';
        $get_category = \Input::get('category');

        if ( empty($get_category) ) {
            if ( \Cookie::get($this->submodule.'_category_id') !== NULL ) {
                $get_category = \Cookie::get($this->submodule.'_category_id');
            } else {
                $get_category = 'all';
            }
        }
        \Cookie::set($this->submodule.'_category_id', $get_category);

        $this->dataGlobal['menus'] = $menus;
        $this->dataGlobal['activedmenu'] = $activedmenu;
        
        // Building menu_cats
        $menu_cats = \Model_Category::query();

        if ( !empty($menus) ) {

            if ( $activedmenu == 'all' ) {

                $where_start = true;

                foreach ($menus as $key => $menu) {
                    
                    $categories = explode(',', $menu->categories);

                    foreach ($categories as $id) {
                        if ($where_start) {
                            $menu_cats = $menu_cats->where('id',$id);
                            $where_start = false;
                        } else {
                            $menu_cats = $menu_cats->or_where('id',$id);
                        }
                    }
            
                }

                $this->dataGlobal['menu_cats'] = $menu_cats = $menu_cats->or_where('slug','all')->or_where('slug','uncategorized')->order_by('order_id', 'ASC')->get();
                
            } else {

                $where_start = true;

                $categories = explode(',', $menus[$activedmenu]->categories);
                foreach ($categories as $id) {

                    if ($where_start) {
                        $menu_cats = $menu_cats->where('id',$id);
                        $where_start = false;
                    } else {
                        $menu_cats = $menu_cats->or_where('id',$id);
                    }
                }
                $this->dataGlobal['menu_cats'] = $menu_cats = $menu_cats->or_where('slug','all')->order_by('order_id', 'ASC')->get();

            }

        }

        //
        //
        /* Query Posts */
        //
        //
            
            /* Count for pagination */
            
            $no_pagination = \Input::get('pagination') == 'on' ? true : false;

            // Maxpage
                $maxpage = \Config::get('application.setup.page.pagination');

            // global count
            $count_global = 0;
            foreach ($menu_cats as $key => $cat) {
                if ($cat->slug != 'all') {
                    $count_global += \DB::select('post_id')->from('categories_posts')->where('category_id', $key)->distinct()->execute()->count();
                }
            }
            // category count
            if ( $get_category != 'all' ) {
                // active category count
                $count = \DB::select('post_id')->from('categories_posts')->where('category_id', $get_category)->distinct()->execute()->count();
            } else {
                $count = $count_global;
            }

            if ($no_pagination) {
                $maxpage = $count_global;
            }

            // pagination_params
                $pagination_params = '?';
                !empty(\input::get('category')) and $pagination_params .=  'category='.\input::get('category').'&';
                !empty(\input::get('menu')) and $pagination_params .=  'menu='.\input::get('menu');
            
            // setup pagination
            $config = array(
              'pagination_url' => \Uri::current().$pagination_params,
              'total_items'    => $count,
              'per_page'       => $maxpage,
              'uri_segment'    => 'page',
              'show_first'      => true,
              'show_last'      => true,
            );
            $this->data['pagination'] = $pagination = \Pagination::forge('post_pagination', $config);
            
            // // setup current pagination number remember
            // if ( \Cookie::get($this->submodule.'_current_pagination_menu_'.$activedmenu) !== NULL ) {
            //     \Pagination::instance()->current_page = \Cookie::get($this->submodule.'_current_pagination_menu_'.$activedmenu);
            // } else {
            //     \Cookie::set($this->submodule.'_current_pagination_menu_'.$activedmenu, \Pagination::instance()->current_page);
            // }
       // echo \Debug::dump($menu->route); die();
            // get posts
            if ( $get_category == 'all'  ) {
                //+count for all routine
                    $posts = \Model_Post::query();
                    // if ( $this->submodule != 'cms' ) {
                    //   $posts = $posts->where('module',$this->submodule);
                    // }
                    $where_start = true;

                    if ($menu->route != 'cms') {
                    foreach ($menu_cats as $key => $menu) {
                      // if ($menu->slug != 'all') {
                        if ($where_start) {
                            $posts = $posts->related('categories')->where('categories.id', $key);
                            $where_start = false;
                        } else {
                            $posts = $posts->related('categories')->or_where('categories.id', $key);
                        }
                      // }
                      }
                    }
            } else {
                //+count for select categories routine
                    $posts = \Model_Post::query()->related('categories')->where('categories.id', $get_category);
            }

            $this->data['posts'] = $posts = $posts->order_by($by, $desc)
                    ->rows_offset($pagination->offset)
                    ->rows_limit($pagination->per_page)
                    ->get();
        //
        /* end query post */
        //

        // Get portion of posts request or all
        if ( $activedmenu !== 'all ') {
            $menu = \Project\Model_Menu::find($activedmenu);
        }
        
        // Working on posts data
        $desc_inv = $desc == 'desc' ? 'asc' : 'desc';
        foreach ($posts as $post) {
            $img = \Model_Image::query()->where('post_id', $post->id)->get_one();
            if ($img) {
                $post->cover = \Efx\Controller_Upload::thumb($img->path, $img->name, $img->type).'?'.rand();
            } else {
                $post->cover = NULL;
            }
            $post->meta = str_replace(' ', ', ', $post->meta);
            $categories_data = \Model_Category::query()->related('posts')->where('posts.id', $post->id)->get();
            $post->slug_categories = strtolower( implode(' ', \Arr::pluck( $categories_data, 'slug')) );
            $post->arr_categories = \Arr::pluck( $categories_data, 'slug');
            $post->name_categories = strtolower( implode(', ', \Arr::pluck( $categories_data, 'name')) );
        }

        // Filtering posts with maximun limit menu
        if ( $activedmenu !== 'all') {
            !isset($menu->postselect) and $menu->postselect = 'all';
            if ( $menu->postselect == 'max') {

                !isset($menu->postmax) and $menu->postmax = '10';

                switch ($menu->sorts_default) {
                    case 'desc':
                        $this->data['posts'] = $posts = array_slice($posts, 0, $menu->postmax);
                    break;

                    case 'asc':
                        $this->data['posts'] = $posts = array_slice($posts,  abs(count($posts)-$menu->postmax), count($posts));
                    break;

                    case 'random':
                        shuffle($posts);
                        $this->data['posts'] = $posts = array_slice($posts, 0, $menu->postmax);
                    break;
                    
                    default:
                        //
                    break;
                }
                
            }
        }

        // Setting categories
        $categories_request = \Model_Category::query()->where('slug', '!=', 'all')->order_by('order_id', 'ASC')->get();
        foreach ( $categories_request as $category) {
            $this->data['categories'][$category->slug]['id'] = $category->id;
            $this->data['categories'][$category->slug]['slug'] = strtolower($category->slug);
            $this->data['categories'][$category->slug]['name'] = $category->name;
            $this->data['categories'][$category->slug]['exposition'] = $category->exposition;
        }
        
        // setting dataGlobal
        if ($maxpage >= $count_global) {
            $this->dataGlobal['nojs'] = false;
        } else {
            $this->dataGlobal['nojs'] = true;
        }
        $this->dataGlobal['count_global'] = $count_global;
        $this->dataGlobal['media_ico'] = \Config::get('modules_config')['media']['backend'];
        $this->dataGlobal['pageTitle'] = __('module.'.$this->submodule.'.backend.post_manage');
        $this->dataGlobal['body'] = 'backend posts';
        $this->dataGlobal['list_mode'] = empty(\Uri::segment(4)) ? '/' : '/'.\Uri::segment(4);
        $this->dataGlobal['activedmenu'] = $activedmenu;
        $this->dataGlobal['activedcategory'] = $get_category;

        // setting partial for template
        $this->theme->set_partial('content', 'backend/template/'.$view)
            ->set('by', $by)
            ->set('desc', $desc)
            ->set('desc_inv', $desc_inv)
            ->set($this->data, null, false);
    }

    static function category_count() {

        foreach(\Model_Category::query()->get() as $category) {

            if ($category->exposition !== 'cms') {

                if ($category->exposition == 'all') {
                    if ($category->slug == 'all') {
                        // all posts all modules
                        $category->post_count = \Model_Post::query()->count();
                    } else {
                        // all uncategorized posts all modules
                        $category->post_count  = \Model_Post::query()->related('categories')->where('categories.id', $category->id)->count();
                    }
                } else {
                    // Categorized Posts with status:published and permission:public
                    // $category->post_count = \Model_Post::query()->where('category_id', $category->id)->where('status', 'published')->where('permission', 'public')->where('module', $category->exposition)->count();
                    // Categorized Posts without status and permission
                    $category->post_count  = \Model_Post::query()->where('module', $category->exposition)->related('categories')->where('categories.id', $category->id)->count();
                }

            } else if ($category->exposition == 'cms') {

                $gallery = \Model_Post::query()->where('module', 'Gallery')->related('categories')->where('categories.id', $category->id)->get();
                $video = \Model_Post::query()->where('module', 'Video')->related('categories')->where('categories.id', $category->id)->get();
                $sketchfab = \Model_Post::query()->where('module', 'Sketchfab')->related('categories')->where('categories.id', $category->id)->get();
                $category->post_count = count($gallery)+count($video)+count($sketchfab);
            }
            
            $category->save();

        } //end foreach cat

    }

    public function after($response) {
        
        if ( \Uri::segment(4) == 'add' ) {
            $license_FroalaEditor = " $.FroalaEditor.DEFAULTS.key = '" . \Config::get('application.setup.services.froala_editor_license') . "';";
            $this->theme->asset->js($license_FroalaEditor, array(), 'script', true);
        }
        return parent::after($response);
    }

}
