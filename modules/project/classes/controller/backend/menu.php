<?php

namespace Project;

class Controller_Backend_Menu extends \Controller_Base_Backend {


    public function before() {

        parent::before();
        $this->dataGlobal['router_post']  = 'admin_'.$this->moduleName.'_post_';
        $this->dataGlobal['submodule'] = 'menu';

    }


    public function action_index($by = 'order_id', $desc = 'asc') {

    	$this->dataGlobal['pageTitle'] = __('module.menu.backend.post_manage');

        // Pagination
        $config = array(
            'pagination_url' => \Uri::current(),
            'total_items'    => Model_Menu::count(),
            'per_page'       => \Config::get('application.setup.page.pagination_global'),
            'uri_segment'    => 'page',
        );
        $this->data['pagination'] = $pagination = \Pagination::forge('menu_pagination', $config);
        // Get posts
        $posts = $this->data['posts'] = Model_Menu::query()
	                                ->offset($pagination->offset)
	                                ->limit($pagination->per_page)
	                                ->order_by($by, $desc)
	                                ->get();
	    $desc_inv = $desc == 'desc' ? 'asc' : 'desc';

        $this->dataGlobal['body'] = 'backend posts';

        // get first menu for home default here
        if ($posts) {
            $default_menu = reset($posts);
            \Config::set('application.setup.site.default', $default_menu->route.'/index/'.$default_menu->id);
            $environment = \Config::get('server.active');
            \Config::save($environment.'/app-setup','application');
        }

		$this->theme->set_partial('content', 'backend/menu/index')
            ->set('by', $by)
            ->set('desc', $desc)
            ->set('desc_inv', $desc_inv)
            ->set($this->data, null, false); 
    }

    public function action_attribute_menu($menuid = null, $render = null) {

        if ($menuid !== null && $render !== null) {
            $menu = Model_Menu::find($menuid);
            if ($menu) {
                $render = $render == 'menu' ? 'home' : 'menu';
                $menu->render = $render;
                $menu->save();
            }
        }
        \Response::redirect(\Router::get('admin_project_menu'));
    }

    public function action_force($id = null) {

        $post = Model_Menu::find($id);
        $post->edit = 0;

        if ($post->save()) {

            \Message::danger(__('backend.post_forced'));

        } else {

            \Message::danger(__('application.error'));
        }

        \Response::redirect_back(\Router::get('admin_'.$this->moduleName.'_menu'));

    }

    private function getFeaturedPostsFromMenu($id, $featured = true) {

        $menu = \Project\Model_Menu::find($id);
        $categories = \Model_Category::query();

        $cats_id = explode(',', $menu->categories);

        foreach ($cats_id as $id) {

            $categories = $categories->or_where('id',$id);
        }

        $categories = $categories->or_where('slug','all')->order_by('order_id', 'ASC')->get();

        $posts = \Model_Post::query();

        if ( $menu->route !== 'cms' ) {
            $posts = $posts->where('module', $menu->route);
        }

        if ($featured) {
            $posts = $posts->where('featured', 'yes')->and_where_open();
        } else {
            $posts = $posts->where('featured', 'no')->and_where_open();
        }

        foreach ($categories as $key => $category) {
            $posts = $posts->related('categories')->or_where('categories.id', $key);
        }

        $posts = $posts->and_where_close()->get();

        foreach ($posts as $post) {
            $img = \Model_Image::query()->where('post_id', $post->id)->get_one();
            if ($img) {
                $post->cover = \Efx\Controller_Upload::thumb($img->path, $img->name, $img->type).'?'.rand();
            } else {
                $post->cover = NULL;
            }
        }

        return $posts;

    }

    public function action_add($id = null) {

        $this->data['isUpdate'] = $isUpdate = ($id !== null) ? true : false;

        // get uri reserved name
        $reserved_uri = ['video','cms','gallery','3d','sketchfab'];
        $userroutes = \Config::get('user-routes')["meta"];
        if ( !empty($userroutes)) {
            foreach ( $userroutes as $key => $config) {
                if ( $config['id'] !== $id ) {
                    $reserved_uri[] = $key;
                }
            }
        }
        // \Debug::dump(\Config::get('user-routes')); die();

        // Prepare form fieldset
        $form = \Fieldset::forge('menu_form', array('form_attributes' => array('class' => 'form-horizontal')));
        $form->add_model('Project\Model_Menu');
        $form->add('add', '', array(
            'type' => 'submit',
            'value' => ($isUpdate) ? __('backend.edit') : __('backend.add'),
            'class' => 'btn btn-primary')
        );

        // Get or create the post
        
        if ($isUpdate) {
            $this->data['post'] = $post = Model_Menu::find($id);
            $this->dataGlobal['pageTitle'] = __('module.menu.backend.post_edit');

            /* // edit unique menu
            if ( $post->edit == 1 && !\Input::post('add')) {

                \Message::danger(__('backend.post_in_editing'));
                \Response::redirect(\Router::get('admin_'.$this->moduleName.'_menu'));

            }
            // setup post to unique edit
            $post->edit = 1;
            $post->save();
            */
           
            $featuredPosts = $this->data['featuredPosts'] = $this->getFeaturedPostsFromMenu($id);
            $nofeaturedPosts = $this->data['nofeaturedPosts'] = $this->getFeaturedPostsFromMenu($id, false);

        } else {

            $featuredPosts = $this->data['featuredPosts'] = array();
            $this->data['post'] = $post = Model_Menu::forge();
            $this->dataGlobal['pageTitle'] = __('module.menu.backend.post_add');
        }

        // get server modules
        $ops = [ 'null' => __('module.project.backend.menu.choose-model'), __('module.project.backend.menu.links') => [ 'url' => 'Url', 'uri' => 'Uri (CMS)' ] ];
        $modules = \Config::get('server.modules');
        foreach ( $modules as $key => $menu) {
            $ops['Modules'][$menu['route']] = ucfirst($key); 
        }
        // create menu datas
        $form->add('modules', __('module.project.backend.menu.template'), array('options' => $ops, 'type' => 'select', 'data-modules' => json_encode(\Config::get('server.modules')), 'id' => 'menutype' ))->add_rule('required');
        
        $ops = [ 'category' => __('module.media.backend.hover.category'), 'name' => __('module.media.backend.hover.name'), 'meta' => __('module.media.backend.hover.meta'), 'empty' => __('module.media.backend.hover.empty') ];
        $form->add('hoverthumb', __('module.media.backend.hover.label'), array('options' => $ops, 'type' => 'select', 'id' => 'hoverthumb' ))->add_rule('required')->set_value('name');
        
        $form->add('route', __('module.project.backend.menu.route'), array('type' => 'text', 'id' => 'route' ))->add_rule('required')->set_error_message('required','Un URL ou un route doit être connu.');
        $form->add('faicon', 'icon', array('type' => 'text', 'value' => isset($post->faicon) ? $post->faicon : 'none', 'id' => 'fa' ))->set_type('hidden');
        $form->add('meta', 'meta', array('type' => 'text', 'id' => 'meta' ));
        $form->add('target', __('module.project.backend.menu.target'), array('type' => 'checkbox', !isset($post->target) ? 'checked' : '', 'value' => '_self', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-thumb-tack"></i> '. __('module.project.backend.menu._self'), 'data-off' => '<i class="fa fa-external-link"></i> '. __('module.project.backend.menu._blank'), 'data-onstyle'=>'default', 'data-offstyle'=>'primary', 'id' => 'target', 'data-width' => '100%' ));
        
        // theming setup
        //
        // setup margin navbar
        $form->add('navbarmargin', __('module.project.backend.theme.navbarmargin'), array('type' => 'checkbox', !isset($post->navbarmargin) ? 'checked' : '', 'data-toggle'=>'toggle', 'value' => 'default', 'data-on' => '<i class="fa fa-toggle-off"></i> '. __('module.project.backend.theme.default'), 'data-off' => '<i class="fa fa-toggle-on"></i> '. __('module.project.backend.theme.navbarmargin237'), 'data-onstyle'=>'default', 'data-offstyle'=>'success', 'id' => 'navbarmargin', 'data-width' => '100%' ));

        $form->add('navbarstate', __('module.project.backend.theme.navbarstate'), array('type' => 'checkbox', !isset($post->navbarstate) ? 'checked' : '', 'data-toggle'=>'toggle', 'value' => 'fixed', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('module.project.backend.theme.navvarfixed'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('module.project.backend.theme.navvarstatic'), 'data-onstyle'=>'default', 'data-offstyle'=>'success', 'id' => 'navbarstate', 'data-width' => '100%' ));

        // setup slicePoint collapse text's media description
        $form->add('slicePoint', __('module.project.backend.theme.slicePoint'), array('type' => 'text', 'id' => 'slicePoint' ))->set_value('0');
        
        // add names and summary localisations
        foreach (\Config::get('server.application.lang-order') as $lang) {
            if ( \Config::get('server.application.language') !== $lang ) {
                $form->add('name_'.$lang, __('module.menu.model.name'), array('type' => 'text', 'id' => 'name_'.$lang ));
                $form->add('summary_'.$lang, '', array('type' => 'textarea', 'id' => 'summary_'.$lang ));
            }
        }

        // Reset to summary labels for localisation
        $form->field('summary')->set_label('');

        // color setup
        // 
            // setup logo (bg) 
            $ops = [ 'default' => __('module.project.backend.theme.default'), 'color' => __('module.project.backend.theme.color'), 'hexa' => __('module.project.backend.theme.hexa')];
            $form->add('logoselect', __('module.project.backend.theme.logocolor'), array('options' => $ops, 'type' => 'select', 'id' => 'logoselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
            $form->add('logodata', '');

            $form->add('logo2select', __('module.project.backend.theme.logocolor2'), array('options' => $ops, 'type' => 'select', 'id' => 'logo2select'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
            $form->add('logo2data', '');

            // setup background (bg) 
            $ops = [ 'default' => __('module.project.backend.theme.default'), 'color' => __('module.project.backend.theme.color'), 'hexa' => __('module.project.backend.theme.hexa'), 'textured' => __('module.project.backend.theme.textured'), 'vimeo' => __('module.project.backend.theme.vimeo'), 'video' => __('module.project.backend.theme.video')];
            $form->add('bgselect', __('module.project.backend.theme.bgcolor'), array('options' => $ops, 'type' => 'select', 'id' => 'bgselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
            $form->add('bgdata', '');

            // setup background sider (bg)
            $ops = [ 'default' => __('module.project.backend.theme.default'), 'color' => __('module.project.backend.theme.color'), 'hexa' => __('module.project.backend.theme.hexa'), 'textured' => __('module.project.backend.theme.textured'), 'video' => __('module.project.backend.theme.video'), 'transparent' => __('module.project.backend.theme.transparent')];
            $form->add('bgsiderselect', __('module.project.backend.theme.bgsidercolor'), array('options' => $ops, 'type' => 'select', 'id' => 'bgsiderselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
            $form->add('bgsiderdata', '');

            // setup navbar (bg)
            $ops = [ 'default' => __('module.project.backend.theme.default'), 'color' => __('module.project.backend.theme.color'), 'hexa' => __('module.project.backend.theme.hexa'), 'textured' => __('module.project.backend.theme.textured'), 'transparent' => __('module.project.backend.theme.transparent')];
            $form->add('navselect', __('module.project.backend.theme.navcolor'), array('options' => $ops, 'type' => 'select', 'id' => 'navselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
            $form->add('navdata', '');

            // setup right navbar (bg)
            $ops = [ 'default' => __('module.project.backend.theme.default'), 'color' => __('module.project.backend.theme.color'), 'hexa' => __('module.project.backend.theme.hexa'), 'textured' => __('module.project.backend.theme.textured'), 'transparent' => __('module.project.backend.theme.transparent')];
            $form->add('navrightselect', __('module.project.backend.theme.navrightcolor'), array('options' => $ops, 'type' => 'select', 'id' => 'navrightselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
            $form->add('navrightdata', '');

            // setup media (bg)
            $ops = [ 'default' => __('module.project.backend.theme.default'), 'color' => __('module.project.backend.theme.color'), 'hexa' => __('module.project.backend.theme.hexa'), 'textured' => __('module.project.backend.theme.textured'), 'transparent' => __('module.project.backend.theme.transparent')];
            $form->add('mediaselect', __('module.project.backend.theme.mediacolor'), array('options' => $ops, 'type' => 'select', 'id' => 'mediaselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
            $form->add('mediadata', '');

        // Main Text
        // Setup UI text color
        $ops = [ 'default' => __('module.project.backend.theme.default'), 'color' => __('module.project.backend.theme.color'), 'hexa' => __('module.project.backend.theme.hexa')];
        $form->add('uitextselect', __('module.project.backend.theme.uitextcolor'), array('options' => $ops, 'type' => 'select', 'id' => 'uitextselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
        $form->add('uitextdata', '');
        // Setup UI text hover color
        $form->add('uitexthoverselect', __('module.project.backend.theme.uitexthovercolor'), array('options' => $ops, 'type' => 'select', 'id' => 'uitexthoverselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
        $form->add('uitexthoverdata', '');
        // Setup UI block hover color
        $form->add('uiblockhoverselect', __('module.project.backend.theme.uiblockhovercolor'), array('options' => $ops, 'type' => 'select', 'id' => 'uiblockhoverselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
        $form->add('uiblockhoverdata', '');
        // Setup UI sider text active color
        $form->add('uitextactiveselect', __('module.project.backend.theme.uitextactivecolor'), array('options' => $ops, 'type' => 'select', 'id' => 'uitextactiveselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
        $form->add('uitextactivedata', '');

        // Setup UI sider text hover color
        // 
        // Setup UI sider text color
        $form->add('uisidertextselect', __('module.project.backend.theme.uisidertextcolor'), array('options' => $ops, 'type' => 'select', 'id' => 'uisidertextselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
        $form->add('uisidertextdata', '');
        // Setup UI sider text hover color
        $form->add('uisidertexthoverselect', __('module.project.backend.theme.uisidertexthovercolor'), array('options' => $ops, 'type' => 'select', 'id' => 'uisidertexthoverselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
        $form->add('uisidertexthoverdata', '');
        // Setup UI sider text active color
        $form->add('uisidertextactiveselect', __('module.project.backend.theme.uisidertextactivecolor'), array('options' => $ops, 'type' => 'select', 'id' => 'uisidertextactiveselect'))->set_template('<div class="control-label">{label}{required}</div><div class="btn-justified">{field} {description} {error_msg}');
        $form->add('uisidertextactivedata', '');

        // Setup Title capitalize or not
        $form->add('titletransform', __('module.project.backend.menu.titletransform'), array('type' => 'checkbox', !isset($post->titletransform) ? 'checked' : '', 'value' => 'normal', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-toggle-off"></i> '. __('module.project.backend.menu.normal'), 'data-off' => '<i class="fa fa-toggle-on"></i> '. __('module.project.backend.menu.capital'), 'data-onstyle'=>'default', 'data-offstyle'=>'success', 'id' => 'titletransform', 'data-width' => '100%' ));
        
        // show category sider
        $form->add('sidercategories', __('module.project.backend.menu.sidercategories'), array('type' => 'checkbox', !isset($post->sidercategories) ? 'checked' : '', 'value' => 'yes', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-eye"></i> '. __('module.project.backend.menu.yes_cats'), 'data-off' => '<i class="fa fa-eye-slash"></i> '. __('module.project.backend.menu.no_cats'), 'data-onstyle'=>'success', 'data-offstyle'=>'danger', 'id' => 'sidercategories', 'data-width' => '100%' ));
        
        // URI rewriting
        $form->add('uri_state', __('module.project.backend.menu.uri_state'), array('type' => 'checkbox', !isset($post->uri_state) ? 'checked' : '', 'value' => 'on', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-toggle-off"></i> '. __('module.project.backend.menu.on'), 'data-off' => '<i class="fa fa-toggle-on"></i> '. __('module.project.backend.menu.off'), 'data-onstyle'=>'success', 'data-offstyle'=>'default', 'id' => 'uri_state', 'data-width' => '100%' ));
        
        $form->add('uri', __('module.project.backend.menu.uri'), array('type' => 'text', 'id' => 'uri' ))->add_rule('required')->add_rule('min_length', 3)->set_error_message('required',__('module.project.backend.menu.uri_required'));

        // Icone visibility
        $form->add('iconvisibility', __('module.project.backend.menu.iconvisibility'), array('type' => 'checkbox', !isset($post->iconvisibility) ? 'checked' : '', 'value' => 'visible', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('module.project.backend.menu.visible'), 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('module.project.backend.menu.hidden'), 'data-onstyle'=>'warning', 'data-offstyle'=>'default', 'id' => 'iconvisibility', 'data-width' => '100%' ));
        
        // Icon Media type
        $form->add('iconmedia', __('module.project.backend.menu.iconmedia'), array('type' => 'checkbox', !isset($post->iconmedia) ? 'checked' : '', 'value' => 'disabled', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('module.project.backend.menu.hidden'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('module.project.backend.menu.visible'), 'data-onstyle'=>'success', 'data-offstyle'=>'default', 'id' => 'iconmedia', 'data-width' => '100%' ));
        
        // Show tooltip
        $form->add('tooltip', __('module.project.backend.menu.tooltip'), array('type' => 'checkbox', !isset($post->tooltip) ? 'checked' : '', 'value' => 'disabled', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('module.project.backend.menu.hidden'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('module.project.backend.menu.visible'), 'data-onstyle'=>'success', 'data-offstyle'=>'default', 'id' => 'tooltip', 'data-width' => '100%' ));
        
        // Show media auto-close
        $form->add('mediaautoclose', __('module.project.backend.menu.mediaautoclose'), array('type' => 'checkbox', !isset($post->mediaautoclose) ? 'checked' : '', 'value' => 'self', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('module.project.backend.menu.manualclose'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('module.project.backend.menu.autoclose'), 'data-onstyle'=>'success', 'data-offstyle'=>'default', 'id' => 'mediaautoclose', 'data-width' => '100%' ));

        // ScrollTo
        $form->add('scrollto', __('module.project.backend.menu.scrollto'), array('type' => 'checkbox', !isset($post->scrollto) ? 'checked' : '', 'value' => 'active', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('module.project.backend.menu.active'), 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('module.project.backend.menu.disabled'), 'data-onstyle'=>'warning', 'data-offstyle'=>'default', 'id' => 'scrollto', 'data-width' => '100%' ));
        
        // selectmode
        $form->add('selectmode', __('module.project.backend.menu.selectmode'), array('type' => 'checkbox', !isset($post->selectmode) ? 'checked' : '', 'value' => 'all', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-toggle-off"></i> '. __('module.project.backend.menu.selectmode_all'), 'data-off' => '<i class="fa fa-toggle-on"></i> '. __('module.project.backend.menu.selectmode_selected'), 'data-onstyle'=>'default', 'data-offstyle'=>'success', 'id' => 'selectmode', 'data-width' => '100%' ));
        
        // scrolltofeatured featured
        // Created through view, no scrolltofeatured fieldset but \Input::post('scrolltofeatured')

        // scrollpausetime
        $form->add('scrollpausetime', __('module.project.backend.menu.scrollpausetime'), array('type' => 'text', 'id' => 'scrollpausetime' ))->set_value('2000');

        // render
        $form->add('render', __('application.render'), array('type' => 'checkbox', !isset($post->render) ? 'checked' : '', 'value'=> 'menu', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-eye"></i> '. __('application.menu_visible'), 'data-off' => '<i class="fa fa-eye-slash"></i> '. __('application.menu_invisible'), 'data-onstyle'=>'default', 'data-offstyle'=>'danger', 'id' => 'render', 'data-width' => '100%' ));
        // sort
        $form->add('sorts_control', __('application.isotope_sorts_control'), array('type' => 'checkbox', !isset($post->sorts_control) ? 'checked' : '', 'value' => 'actif', 'data-toggle'=>'toggle', 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('application.isotope_control_actif'), 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('application.isotope_control_none'), 'data-onstyle'=>'success', 'data-offstyle'=>'default', 'id' => 'sorts_control', 'data-width' => '100%' ));

        $form->add('sorts_default', __('application.isotope_default_sorts'), array('options' => ['desc' => __('application.isotope_sorts_desc'), 'asc' => __('application.isotope_sorts_asc'), 'random' => __('application.isotope_sorts_random'), 'favorites' => __('application.isotope_sorts_favorites')], 'type' => 'select', 'id' => 'sorts_default' ))->set_value('desc');

        // featured output
        $form->add('featured_order', __('application.featured_order'), array('options' => ['desc' => __('application.featured_order_desc'), 'asc' => __('application.featured_order_asc'), 'random' => __('application.featured_order_random')], 'type' => 'select', 'id' => 'featured_order' ))->set_value('random');
        // max featured
        $ops = [];
        // $maxfeatured = count($featuredPosts);
        // for ($i=1; $i < $maxfeatured+1; $i++) { 
        //     $ops[$i] = $i;
        // }
        // Setup up to 11 featured
        for ($i=1; $i < 11; $i++) { 
            $ops[$i] = $i;
        }
        $form->add('featured_max', __('application.featured_max'), array('options' => $ops, 'type' => 'select', 'id' => 'featured_max' ))->set_value('1');

        //
        // Posts mode
            // postselect == all (checked)
            $form->add('postselect', __('module.project.backend.menu.postselect.label'), array('type' => 'checkbox', !isset($post->postselect) ? 'checked' : '', 'value' => 'all', 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-toggle-off"></i> '. __('module.project.backend.menu.postselect.max'), 'data-on' => '<i class="fa fa-toggle-on"></i> '. __('module.project.backend.menu.postselect.all'), 'data-onstyle'=>'default', 'data-offstyle'=>'primary', 'id' => 'postselect', 'data-width' => '100%' ));
            // postmax
            $form->add('postmax', __('module.project.backend.menu.postmax'), array('type' => 'text', 'id' => 'postmax' ))->set_value('10');

        //
        // Froala image management for summary
        // 
            
            // Toggle on/off summary
            $form->add('summary_switch', __('module.project.backend.menu.summary_switch'), array('type' => 'checkbox', !isset($post->summary_switch) ? 'checked' : '', 'value'=> true, 'data-toggle'=>'toggle', 'data-off' => '<i class="fa fa-eye-slash"></i> '. __('module.project.backend.menu.summary_switch_off'), 'data-on' => '<i class="fa fa-eye"></i> '. __('module.project.backend.menu.summary_switch_on'), 'data-onstyle'=>'default', 'data-offstyle'=>'danger', 'id' => 'summary_switch', 'data-width' => '100%' ));

            // Image folders for Froala CMS upload
            $ops = ['gallery'=>'Gallery', 'blog' => 'Blog', 'video'=>'Video', 'menu'=>'Menu', 'sketchfab'=>'Sketchfab', '3d'=>'3D'];
            $form->add('media', __('backend.media'), array('options' => $ops, 'type' => 'select', 'value' => 'menu' ))->set_value('menu');

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

        // find modules except Cv
        // finds categories associated with each modules and return it in HTML data
        $this->data['menu_routing'] = isset($post->route) ? $post->route :false;
        $this->data['actived_categories'] = $actived_categories = isset($post->categories) ? explode(',', $post->categories) : array();

        // remove Cv module
        unset($modules['cv']);

        // setup 'categorized' category
        $uncategorized = \Model_Category::query()->where('slug', 'uncategorized')->get_one();
        $this->data['uncategorized']['name'] = $uncategorized->name;
        $this->data['uncategorized']['slug'] = $uncategorized->slug;
        $this->data['uncategorized']['id'] = $uncategorized->id;
        $this->data['uncategorized']['selected'] = 'selected'; // make uncategorized selected by default in menu
        // if ( in_arrayi($uncategorized->id,$actived_categories) )
        //     $this->data['uncategorized']['selected'] = 'selected';
        
        foreach ($modules as $name_mod => $module) {

            $boolean_route = isset($post->route) ? $post->route == $name_mod || $post->route == 'cms' ? true : false : true;

            if ( $boolean_route ) {

                $cats = \Model_Category::query()->where('exposition', $name_mod)->get();

                foreach ($cats as $cat) {

                    $this->data['categories'][$name_mod][$cat->id]['name'] = $cat->name;
                    $this->data['categories'][$name_mod][$cat->id]['exposition'] = $cat->exposition;
                    $this->data['categories'][$name_mod][$cat->id]['slug'] = $cat->slug;
                    $this->data['categories'][$name_mod][$cat->id]['id'] = $cat->id;
                    $this->data['categories'][$name_mod][$cat->id]['selected'] = '';

                    // grab all categories to menu which are the same exposition module
                    // if ( in_arrayi($cat->id, $actived_categories) ) {
                        
                    //     $this->data['categories'][$name_mod][$cat->id]['selected'] = 'selected';

                    // }
                }
            }
        }
        // create validation for categories chosen
        $validation_categories = \Validation::forge('chosen-categories_validation');
        $validation_categories->add_field('chosen-categories', __('module.menu.backend.chosen-categories'), 'required');

        $form->populate($post);

        if ($isUpdate && $post->modules == 'module') $form->field('modules')->set_value($post->route);

        if ( \Input::post('uri_state') === NULL ) {
            $form->field('uri')->delete_rule('required');
            $form->field('uri')->delete_rule('min_length');
        }

		// If POST submit
		if (\Input::post('add')) {

			$form->validation()->run();
            $validation_categories->run();

            if ( ! $form->validation()->error()) {

                $uri = \Inflector::friendly_title($form->validated('uri'), '-', true);

                if ( in_array($uri, $reserved_uri) ) {
                    \Message::danger(__('application.uri_reserved').implode(', ', $reserved_uri) );
                    \Message::info(__('application.change_uri') );
                    \Response::redirect( \Router::get('admin_project_menu_edit', array('id' => $id)) );
                }

                $summary = $form->validated('summary') != NULL ? $form->validated('summary') : '';
                $scrolltofeatured = \Input::post('scrolltofeatured');

				// Populate the post
                $array_model = array(
                    'name'          => $form->validated('name'),
                    'summary'       => $summary,
                    'status'        => $form->validated('status'),
                    'permission'    => $form->validated('permission'),
                    'featured'      => $form->validated('featured'),
                    'edit'          => 0,
                    'modules'       => ($form->validated('modules') == 'url' || $form->validated('modules') == 'uri') ? $form->validated('modules') : 'module',
                    'uri'           => $uri,
                    'hoverthumb'    => $form->validated('hoverthumb'),
                    'faicon'        => $form->validated('faicon'),
                    'target'        => $form->validated('target') !== NULL ? '_self' : '_blank',
                    'route'         => $form->validated('route'),
                    'sorts_control' => $form->validated('sorts_control') !== NULL ? 'actif' : 'none',
                    'sorts_default' => $form->validated('sorts_default'),
                    'featured_order'=> $form->validated('featured_order') !== NULL ? $form->validated('featured_order') : '',
                    'featured_max'  => $form->validated('featured_max') !== NULL ? $form->validated('featured_max') : '',
                    'navbarmargin'  => $form->validated('navbarmargin') !== NULL ? 'default' : '237',
                    'navbarstate'   => $form->validated('navbarstate') !== NULL ? 'fixed' : 'static',
                    'render'        => $form->validated('render') !== NULL ? 'menu' : 'home',
                    'slicePoint'    => $form->validated('slicePoint'),
                    'scrollpausetime'=> $form->validated('scrollpausetime') !== NULL ? $form->validated('scrollpausetime') : '2000',

                    'sidercategories'   => $form->validated('sidercategories') !== NULL ? 'yes' : 'no',

                    'uri_state'         => $form->validated('uri_state') !== NULL ? 'on' : 'off',
                    'titletransform'    => $form->validated('titletransform') !== NULL ? 'normal' : 'capital',
                    'iconvisibility'    => $form->validated('iconvisibility') !== NULL ? 'visible' : 'disabled',
                    'iconmedia'         => $form->validated('iconmedia') !== NULL ? 'disabled' : 'visible',
                    'tooltip'           => $form->validated('tooltip') !== NULL ? 'disabled' : 'visible',
                    'mediaautoclose'    => $form->validated('mediaautoclose') !== NULL ? 'self' : 'auto',
                    'scrollto'          => $form->validated('scrollto') !== NULL ? 'active' : 'disabled',
                    'selectmode'        => $form->validated('selectmode') !== NULL ? 'all' : 'selected',
                    'scrolltofeatured'  => \Input::post('scrolltofeatured') !== NULL ? implode(",", $scrolltofeatured ) : '',

                    'summary_switch'    => $form->validated('summary_switch') !== NULL ? true : false,
                    
                    'postselect'        => $form->validated('postselect') !== NULL ? 'all' : 'max',
                    'postmax'           => $form->validated('postmax'),

                    // theme   
                        // color logo
                        'logoselect'      => $form->validated('logoselect'),
                        'logodata'        => $form->validated('logodata') !== NULL ? $form->validated('logoselect') == 'color' ? '#'.$form->validated('logodata') : $form->validated('logodata') : '',
                        // color logo
                        'logo2select'     => $form->validated('logo2select'),
                        'logo2data'       => $form->validated('logo2data') !== NULL ? $form->validated('logo2select') == 'color' ? '#'.$form->validated('logo2data') : $form->validated('logo2data') : '',
                        // Page background
                        'bgselect'      => $form->validated('bgselect'),
                        'bgdata'        => $form->validated('bgdata') !== NULL ? $form->validated('bgselect') == 'color' ? '#'.$form->validated('bgdata') : $form->validated('bgdata') : '',
                        // Page background sider
                        'bgsiderselect'      => $form->validated('bgsiderselect'),
                        'bgsiderdata'        => $form->validated('bgsiderdata') !== NULL ? $form->validated('bgsiderselect') == 'color' ? '#'.$form->validated('bgsiderdata') : $form->validated('bgsiderdata') : '',
                        // navbar background
                        'navselect'      => $form->validated('navselect'),
                        'navdata'        => $form->validated('navdata') !== NULL ? $form->validated('navselect') == 'color' ? '#'.$form->validated('navdata') : $form->validated('navdata') : '',
                        // Right navbar background
                        'navrightselect' => $form->validated('navrightselect'),
                        'navrightdata'   => $form->validated('navrightdata') !== NULL ? $form->validated('navrightselect') == 'color' ? '#'.$form->validated('navrightdata') : $form->validated('navrightdata') : '',
                        // media background
                        'mediaselect' => $form->validated('mediaselect'),
                        'mediadata'   => $form->validated('mediadata') !== NULL ? $form->validated('mediaselect') == 'color' ? '#'.$form->validated('mediadata') : $form->validated('mediadata') : '',

                        // Main text
                        // UI Main text color 
                        'uitextselect' => $form->validated('uitextselect'),
                        'uitextdata'   => $form->validated('uitextdata') !== NULL ? $form->validated('uitextselect') == 'color' ? '#'.$form->validated('uitextdata') : $form->validated('uitextdata') : '',

                        // UI Main text hover color 
                        'uitexthoverselect' => $form->validated('uitexthoverselect'),
                        'uitexthoverdata'   => $form->validated('uitexthoverdata') !== NULL ? $form->validated('uitexthoverselect') == 'color' ? '#'.$form->validated('uitexthoverdata') : $form->validated('uitexthoverdata') : '',

                        // UI Main block hover color 
                        'uiblockhoverselect' => $form->validated('uiblockhoverselect'),
                        'uiblockhoverdata'   => $form->validated('uiblockhoverdata') !== NULL ? $form->validated('uiblockhoverselect') == 'color' ? '#'.$form->validated('uiblockhoverdata') : $form->validated('uiblockhoverdata') : '',

                        // UI Main text active color 
                        'uitextactiveselect' => $form->validated('uitextactiveselect'),
                        'uitextactivedata'   => $form->validated('uitextactivedata') !== NULL ? $form->validated('uitextactiveselect') == 'color' ? '#'.$form->validated('uitextactivedata') : $form->validated('uitextactivedata') : '',

                        // Sider text
                        // UI Sider text color 
                        'uisidertextselect' => $form->validated('uisidertextselect'),
                        'uisidertextdata'   => $form->validated('uisidertextdata') !== NULL ? $form->validated('uisidertextselect') == 'color' ? '#'.$form->validated('uisidertextdata') : $form->validated('uisidertextdata') : '',

                        // UI Sider text hover color 
                        'uisidertexthoverselect' => $form->validated('uisidertexthoverselect'),
                        'uisidertexthoverdata'   => $form->validated('uisidertexthoverdata') !== NULL ? $form->validated('uisidertexthoverselect') == 'color' ? '#'.$form->validated('uisidertexthoverdata') : $form->validated('uisidertexthoverdata') : '',

                        // UI Sider text active color 
                        'uisidertextactiveselect' => $form->validated('uisidertextactiveselect'),
                        'uisidertextactivedata'   => $form->validated('uisidertextactivedata') !== NULL ? $form->validated('uisidertextactiveselect') == 'color' ? '#'.$form->validated('uisidertextactivedata') : $form->validated('uisidertextactivedata') : '',
                );

                if (! empty($form->validated('meta')) )
                    $array_model['meta'] = $form->validated('meta');

                if ( empty($validation_categories->validated('chosen-categories')) ) {
                    $array_model['categories'] = '';
                } else {
                    $array_model['categories'] = implode(',', $validation_categories->validated('chosen-categories'));
                }

                // name localisation
                foreach (\Config::get('server.application.lang-order') as $lang) {
                    if ( \Config::get('server.application.language') !== $lang ) {
                        $array_model['name_'.$lang]     = $form->validated('name_'.$lang);
                        $array_model['summary_'.$lang]  = $form->validated('summary_'.$lang);
                    }
                }

				$post->from_array($array_model);

                if ($post->save()) {
                    
                    //
                    // update the URI configs
                    //
                    // empty the config to default 
                    $menus = \Project\Model_Menu::query()->order_by('order_id', 'ASC')->get();
                    // init user-routes
                    \Config::set('user-routes.meta', array() );
                    \Config::set('user-routes.routes', array() );
                    \Config::save('user-routes','user-routes');
                    // reconstruct user-routes config
                    foreach ($menus as $menu) {
                        if ( !empty($menu->uri) && $menu->uri_state == 'on' ) {
                            \Config::set('user-routes.meta.'.$menu->uri, array('media/frontend/'.$menu->route.'/index/'.$menu->id, 'name' => 'uri_'.\Inflector::friendly_title($menu->name, '-', true), 'route'=>$menu->route, 'id'=>$menu->id ) );
                            \Config::set('user-routes.routes.'.$menu->uri, array('media/frontend/'.$menu->route.'/index/'.$menu->id, 'name' => 'uri_'.\Inflector::friendly_title($menu->name, '-', true) ) );
                        }
                    }
                    \Config::save('user-routes','user-routes');

					// Delete cache
					\Cache::delete('sidebar');

					if ($isUpdate) {

						\Message::success(__('backend.post.edited'));

                    } else {

						\Message::success(__('backend.post.added'));
					    \Response::redirect_back(\Router::get('admin_'.$this->moduleName.'_menu'));
                        
                    }

                    if ( \Input::post('add') ) {
                    
                        if (\Input::post('add') == __('application.save')) {
                            \Response::redirect( \Router::get('admin_project_menu_edit', array('id' => $id)) );
                        } else {
                            \Response::redirect(\Router::get('admin_'.$this->moduleName.'_menu'));
                        }
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

        $this->data['form']               = $form;
        
        $this->dataGlobal['IDpost']       = $post->id;
        $this->dataGlobal['NAMEpost']     = isset($post->route) ? $post->name.' @'.$post->route : $post->name.' @new';

        $this->data['id']                 = $post->id;
        $this->data['scrolltofeatured']   = isset($post->scrolltofeatured) ? explode(',', $post->scrolltofeatured) : '';
        $this->data['faicon']             = isset($post->faicon) ? $post->faicon : 'none';
        $this->data['save']               = \Config::get("server.$base.domain.cdn").\Config::get('server.cdn.action.save');
        $this->dataGlobal['body']         = 'backend add';
		
		$this->theme->set_partial('content', 'backend/menu/add')->set($this->data, null, false);
		
    }

    public function action_exit($id = NULL) {
        if ($id != NULL) {
            $post = Model_Menu::find($id);
            $post->edit = 0;
            $post->save();
        }
        \Response::redirect(\Router::get('admin_'.$this->moduleName.'_menu'));

    }

    public function action_delete($id = null) {

        $post = Model_Menu::find($id);
        $published = ($post->status == 'published' && $post->permission == 'public') ? true : false;

        if ($post->delete()) {

			// Delete cache
			\Cache::delete('sidebar');

            // update the URI configs
            $menus = \Project\Model_Menu::query()->order_by('order_id', 'ASC')->get();
            // init user-routes
            \Config::set('user-routes.meta', array() );
            \Config::set('user-routes.routes', array() );
            \Config::save('user-routes','user-routes');
            // reconstruct user-routes config
            foreach ($menus as $menu) {
                if ( !empty($menu->uri) && $menu->uri_state == 'on' ) {
                    // \Config::load('user-routes', 'user-routes');
                    \Config::set('user-routes.'.$menu->uri, array('media/frontend/'.$menu->route.'/index/'.$menu->id, 'name' => 'uri_'.\Inflector::friendly_title($menu->name, '-', true), 'route'=>$menu->route, 'id'=>$menu->id ) );
                }
            }
            \Config::save('user-routes','user-routes');

            /*
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

            } */
        	
            \Message::success(__('backend.post.deleted'));

        } else {
        	
            \Message::danger(__('application.error'));
        }

        \Response::redirect(\Router::get('admin_'.$this->moduleName.'_menu'));
    }

    public function after($response) {
            
        $license_FroalaEditor = " $.FroalaEditor.DEFAULTS.key = '" . \Config::get('application.setup.services.froala_editor_license') . "';";
        $this->theme->asset->js($license_FroalaEditor, array(), 'script', true);
        
        return parent::after($response);
    }

}
