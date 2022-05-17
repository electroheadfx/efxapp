<?php

class Controller_Base_Template extends \Controller_Base_App {

    public $template    = 'layouts/template';
    public $dataGlobal  = array();
    public $min;
    public $theme_setup;
    public $active_template;
    public $theme_assets;

    public $bottle_css = [];
    public $bottle_js = [];

    public $admin = 'frontend';
    
    public function before() {

        // If ajax or content_only, set a theme with an empty layout
        if (\Input::is_ajax())  {
            return parent::before();
        }

        parent::before();

        if ( \Cookie::get('lang') ) {
            // Cookie has lang setup to it
            \Lang::set_lang( \Cookie::get('lang'), true);      
        } else {
            // auto setup Cookie on agent lang
            $lang = explode('-', \Agent::languages()[0]);
            \Cookie::set('lang',$lang[0]);
        }

        // Get action, module and controller name
        $this->actionName = $this->dataGlobal['actionName'] = \Request::active()->action;
        $this->moduleName       = $this->dataGlobal['moduleName'] = \Request::active()->module;
        $this->controllerName   = str_replace($this->moduleName.'\\', '', strtolower(str_replace('Controller_', '', \Request::active()->controller)) );

        // setup other global variables
        ///////
        $this->dataGlobal['dataproduct'] = '';    
        $this->dataGlobal['navbar']      = 'navbar';
        // $this->dataGlobal['header_img']     = 'visuel-home.png';
        $this->dataGlobal['header_title']   = \Config::get('application.seo.frontend.title');
        $this->dataGlobal['header_on']      = true;
        $this->dataGlobal['body']           = '';
        $this->dataGlobal['active_module'] = \Uri::base(false) . \Config::get('application.setup.site.default');
        $this->dataGlobal['all_category_status'] = false;

        $this->theme_setup  = \Config::get('application.user_theme');
        $this->min          = \Config::get('server.active') == \Fuel::DEVELOPMENT ? FALSE : TRUE;
        $asset_base         = \Config::get('server.'.Config::get('server.active').'.theme.assets_folder');

        $this->theme = \Theme::instance();

        // detect frontend/backend theme and read its config theme
        if ( $this->admin == 'frontend' )
            $theme_setup = $this->theme_setup['frontend']; // ['test'] -> switch on test theme
        else
            $theme_setup = $this->theme_setup['backend'];

        // detect theme (graphic + mockup)
        $active_asset    = $theme_setup['asset'];
        $active_template = $theme_setup['template'];

        /**
         * Setup theme and template
         */
        // $this->theme->active($active_template);

        $this->theme->active(
            array(
                    'name'          => $active_template, //.'_'.$active_asset
                    'path'          => '/themes'.DS.$active_template.DS,
                    'asset_base'    => $asset_base.DS.$active_asset.DS,
                    'find_file'     => true,
                )
        );

        $this->theme->fallback('default');
        $this->theme->set_template($this->template);

        /**
         * [$segments Uri segments]
         */
        $segments = \Uri::segments();
        empty($segments) and $segments[0] = 'home';
        $this->dataGlobal['segments'] = $segments;
        $this->dataGlobal['uri'] = \Str::sub( \Uri::base(false), 0, -1);
        
        foreach ($segments as $segment) {
            $this->dataGlobal['uri'] .= '/'.$segment;
        }

        // Don't re-set Media if is an HMVC request
        !\Request::is_hmvc() and $this->setMedia();

        // Set global

        $this->dataGlobal['logo'] = file_exists(DOCROOT.$this->theme->asset_path('img/logo-inline.svg')) ? \Uri::base(false).$this->theme->asset_path('img/logo-inline.svg') : \Uri::base(false).'assets/img/logo-inline.svg';
        $this->dataGlobal['title'] = \Config::get('application.seo.frontend.site') . ' | ' .\Config::get('application.seo.frontend.title');

    }

    public function action_index() {
        
    }

    public function action_404() {

        $messages = array('Uh Oh!', 'Huh ?');
        $data['notfound_title'] = $messages[array_rand($messages)];
        $this->dataGlobal['pageTitle'] = __('application.page-not-found');
        $this->dataGlobal['menu_cats'] = array();
        $this->theme->set_partial('content', 'user/404')->set($data);
    }
    
    public function after($response) {

        !\Request::is_hmvc() and $this->theme->get_template()->set_global($this->dataGlobal);
        !\Request::is_hmvc() and \Theme::instance()->get_template()->set('messages', \Message::get(), false);
        
        // If nothing was returned set the theme instance as the response
        if (empty($response)) {
            $response = \Response::forge($this->theme);
        }

        if (!$response instanceof \Response) {
            $response = \Response::forge($response);
        }

        $this->dataGlobal['messages'] = \Message::get();
        
        return parent::after($response);
    }

    /**
     * Setup default media to load for all template controller
     */
    public function setMedia() {

        // detect the active template
        $this->active_template  = $this->theme_setup[$this->admin];

        $this->createAssetsBottle('css', 'template');
        $this->createAssetsBottle('js', 'template');      

    }

    /**
     *
     *
     *  Assets pacificator
     *  Read Assets configs and files
     *  Add them in a boottle with difference for render it at end template
     *
     * 
     */
    
    public function renderBottle($type = 'css') {

        $bottle         = 'bottle_'.$type;
        $renderfile     = 'create'.strtoupper($type);
        $renderfolder   = 'concat'.strtoupper($type);
        $rendercdn      = 'cdn'.strtoupper($type);

        foreach ($this->{$bottle} as $a) {

            $asset = reset($a);
            $key = key($a);

            if ($key == 'file') {

                $this->{$renderfile}([$asset]);

            } else if ($key == 'folder') {

                    // special asset name, not implemented in concatCSS yet :
                    // $specialasset = reset($asset);
                $filerender = key($asset);
                $this->{$renderfolder}($filerender);
                
            } else if ($key == 'cdn') {
                
                // warning cdnCSS is not yet implemented
                // implemente here cdnJS
                // 
                $filerender = key($asset);
                if ($this->min)
                    $this->{$rendercdn}([$filerender]);
                else 
                    $this->{$rendercdn}([$asset[$filerender]]);

            }

                /*
                 output test :
                    'file' => bootstrap (value) 
                    'file' => font-awesome (value) 
                    'folder' => test (key) : rendu test (value) 
                    'cdn' => http://electroheadfx.fr (key) : testcdn (value) 
                */
             
        }
    
    }
    
    public function createAssetsBottleFromFiles() {

        $this->pacificator_files($this->theme_assets, 'css');
        $this->pacificator_files($this->theme_assets, 'js');

    }
    
    public function createAssetsBottle($type = 'css', $template = 'template') {

        // Load CSS Assets config template configuration (for backend and frontend)
        $data = \Config::get('assets.'.$template)[$type];
        
        // $active_route = \Request::active()->route->path;
        // remove the 2nd segments : /media/admin and /(:id)
        $active_route = str_replace('/(:id)', '', preg_replace("/^(\\w+\\/){2}/", "", \Request::active()->route->path) );

        // foreach in config and create css bottle with root ('/') and active route
        foreach ($data as $key => $route) {

            // test value output here
            // echo 'for '.$type.' > filter: "'.$key . '" is equal to <b> '.$active_route.' </b>';
            // var_dump($key == "/" || $active_route == $key);
            // echo \Request::active()->route->path;
            // echo '<br/>';

            if ( $active_route == $key || ($key == "home" && $active_route =="_root_" ) ) {

                $this->pacificator_routes($route, $type);

            // if its _root_ it send assets to every URLs
            } else if ( $key == "_root_" ) {

                $this->pacificator_routes($route, $type);

            }

        }

        // Create CSS bottle for root files (files not declared in root theme are autoloaded without config positionned in end)
        $this->theme_assets = $this->load_assetsconfig(APPPATH.'../themes/'.$this->active_template['asset'].'/assets/');

    }
    
    private function load_assetsconfig($path) {

        // Read theme root files to autoload
        return \File::read_dir($path, 0, array(
            '!^_',                 // exclude everything that starts with an underscore.
            '!^\.',                // no hidden files/dirs
            '!^fonts',             // no fonts files/dirs
            '!^img',               // no img files/dirs
            '!^less',              // no less files/dirs
            '\.js$'     => 'file', // only get js's
            '\.css$'    => 'file', // or css files
        ));
    }

    public function pacificator_files($assets, $assettype = "css") {

        $bottle = 'bottle_'.$assettype;

        // Read root theme css files
        foreach ($assets[$assettype.'/'] as $asset) {

            // test if its a file and not : a folder (array) or not exist in config            
            if (is_string($asset)) {

                $name = str_replace('.'.$assettype, '', $asset);
                if (!\Arr::in_array_recursive($name, $this->{$bottle}))
                    $this->{$bottle}[]['file'] =  str_replace('.'.$assettype,'',$asset);
            }
        }

    }
    

    public function pacificator_routes($assetdata = array(), $assettype = "css") {

        $bottle = 'bottle_'.$assettype;

        if (is_string($assetdata)) {
            $assetdata = \Config::get('assets.'.$assetdata);
            if (empty($assetdata)) return;
        }

        foreach ($assetdata as $key => $value) {
            if (is_numeric($key)) {
                // its a file
                if (!\Arr::in_array_recursive($value, $this->{$bottle}))
                    $this->{$bottle}[]['file'] = $value;

            } else {

                if (strpos($value, 'http') === false ) {
                    // its a folder to concate
                    if (!\Arr::in_array_recursive($value, $this->{$bottle}))
                        $this->{$bottle}[]['folder']= [$key => $value];
                    
                } else {
                    // its a CDN
                    if (!\Arr::in_array_recursive($value, $this->{$bottle})) {
                        $this->{$bottle}[]['cdn'] = [$value => $key];
                    }
                }
            }
        }

    }

    
    /**
     *
     * 
     *  theme assets management for dev or dist
     *  
     *  
     */
    
    public function concat($name = '') {

        $this->concatJS($name);
        $this->concatCSS($name);

    }

    public function concatCSS($name = '', $container = 'css_core') {

        $assetFiles = [];
    
        if ($this->min) {

            $assetFiles[] = $name.'/'.$name.'.min.css';

        } else {     

            $assets = \Config::get('assetsgrunt')['css_to_concat'][$name];

            foreach ($assets as $asset) {
                
                $assetFiles[] = $name.'/'.$asset.'.css';

            }

        }

        $this->theme->asset->css($assetFiles, array(), $container, false);

    }

    public function concatJS($name = '', $container = 'footer') {

        $assetFiles = [];
    
        if ($this->min) {

            $assetFiles[] = $name.'/'.$name.'.min.js';

        } else {     

            $assets = \Config::get('assetsgrunt')['js_to_concat'][$name];

            foreach ($assets as $asset) {
                
                if ( strpos($asset, 'ie8') ) {

                    $inline  = '<!--[if lt IE 9]>';
                    $inline .= '<script src="'.$name.'/'.$asset.'.js"></script>';
                    $inline .= '<![endif]-->';
                    $this->theme->asset->js($inline, array(), $container, true);
                    
                } else {
                    $assetFiles[] = $name.'/'.$asset.'.js';

                }

            }

        }
        $this->theme->asset->js($assetFiles, array(), $container, false);

    }
    
    public function createCSS($assets = array(), $container = 'css_core') {

        $assetEnv = $this->min ? '.min' : '';
        $assetFiles = [];

        foreach ($assets as $asset) {
            
            $is_min = \Str::ends_with($asset, '.min');

            $assetFiles[] = $is_min ? $asset.'.css' : $asset.$assetEnv.'.css';

        }

        $this->theme->asset->css($assetFiles, array(), $container, false);

    }

    public function cdnJS($assets = array(), $container = 'footer') {
                
        $assetFiles = [];

        foreach ($assets as $name) {
    
            if ($this->min) {
                $cdn_url = \Config::get('assets')['cdn'][$name];
                $assetFiles[] = $cdn_url;

            } else {     

                $assetFiles[] = $name.'.js';

            }

        }

        $this->theme->asset->js($assetFiles, array(), $container, false);

    }

    public function createJS($assets = array(), $container = 'footer', $script = true) {

        $assetEnv = $this->min ? '.min' : '';
        $assetFiles = [];
        $scriptFiles = [];

        foreach ($assets as $asset) {
            
            $is_min = \Str::ends_with($asset, '.min');
            $is_script = \Str::starts_with($asset, 'script:'); 
            $asset = str_replace('script:', '', $asset);

            if ($is_min) {

                if ($is_script)

                    $assetFiles[] = $asset.'.js';
                else
                    $assetFiles[] = $asset.'.js';

            } else {

                // maybe test if min exist else not use the no minified version
                if ($is_script)

                    $scriptFiles[] = $asset.$assetEnv.'.js';
                else
                    $assetFiles[] = $asset.$assetEnv.'.js';

            }
            
        }
        $this->theme->asset->js($assetFiles, array(), $container, false);
        $this->theme->asset->js($scriptFiles, array(), 'script', true);

    }

    /* POST Methods */

    public function get_media($id = NULL, $module, $from = 'frontend') {

        $page = $id;

        if ($module == 'products') {
            $posts = $this->fetch_products($id);
        } else {
            $posts = $this->fetch($page, $module);
        }

        $images = array();
        $featured = array();
        $menu = \Project\Model_Menu::find($id);
        $scrolltofeatured = isset($menu->scrolltofeatured) ? explode(',', $menu->scrolltofeatured) : '';
        $selectmode = isset($menu->selectmode) ? $menu->selectmode : '';
        // get featured with menu sort -->
        
            foreach ($posts as $post) {

                if ($selectmode == "selected") {

                    if ( in_arrayi($post->id, $scrolltofeatured) ) {
                        $post->featured ='yes';
                        $featured[$post->id] = $post->id;
                    } else {
                        $post->featured ='no';
                    }

                } else {
                    if ($post->featured == 'yes') {
                        $featured[$post->id] = $post->id;
                    }
                }

                $post->summary_expander_ui = isset($post->summary_expander_ui) ? $post->summary_expander_ui : 'yes';
                $post->content_expander_ui = isset($post->content_expander_ui) ? $post->content_expander_ui : 'yes';
                $post->summary_to_content = isset($post->summary_to_content) ? $post->summary_to_content : 'no';

                if ( ( !empty($post->summary) && !$post->summary_to_content ) && empty($post->content) && ($post->image_output == 'text' || $post->image_output == 'thumb' ) ) {
                    $post->locked ='yes';
                }
            }

            if (!empty($featured)) {

                if ($this->featured_order == 'asc') {
                    
                    $featured = array_slice(array_reverse($featured), 0, $this->featured_max);

                } else if ($this->featured_order == 'random') {

                    $this->featured_max = $this->featured_max > count($featured) ? count($featured) : $this->featured_max;
                    $featured = array_rand($featured, $this->featured_max);
                    if ( !is_array($featured)) {
                        $featured = array($featured => $featured);
                    } else {
                        shuffle($featured);
                    }

                } else {
                    $featured = array_slice($featured, 0, $this->featured_max);
                }

            }

        // <--- featured

        $asset_gallery = false;
        $asset_video = false;
        $asset_sketchfab = false;
        $asset_3d = false;

        foreach ($posts as $post) {

            $dbimages = \Model_Image::query()->where('post_id', $post->id)->get();
            $post->images = false;
            $post->featured = in_array($post->id, $featured ) ? "yes" : "no";
            !isset($post->summary_caesura) and $post->summary_caesura = 'on';
            !isset($post->content_caesura) and $post->content_caesura = 'on';

            // For Summary
                // BG color
                $post->postbgselect = isset($post->postbgselect) ? $post->postbgselect : 'default';
                $post->postbgselectcolor = ( $post->postbgselect == 'color' || $post->postbgselect == 'hexa' ) ? 1 : 0;
                $post->postbgdata = isset($post->postbgdata) ? $post->postbgdata : '';

                // Border color and switch on/off
                $post->postborder = isset($post->postborder) ? $post->postborder == 'visible' ? 1 : 0 : 0;
                $post->postborderselect = isset($post->postborderselect) ? $post->postborderselect : 'default';
                $post->postborderselectcolor = ( $post->postborderselect == 'color' || $post->postborderselect == 'hexa' ) ? 1 : 0;
                $post->postborderdata = isset($post->postborderdata) ? $post->postborderdata : '';

            // For Content
                // BG color
                $post->contentbgselect = isset($post->contentbgselect) ? $post->contentbgselect : 'default';
                $post->contentbgselectcolor = ( $post->contentbgselect == 'color' || $post->contentbgselect == 'hexa' ) ? 1 : 0;
                $post->contentbgdata = isset($post->contentbgdata) ? $post->contentbgdata : '';

                // Border color and switch on/off
                $post->contentborder = isset($post->contentborder) ? $post->contentborder == 'visible' ? 1 : 0 : 0;
                $post->contentborderselect = isset($post->contentborderselect) ? $post->contentborderselect : 'default';
                $post->contentborderselectcolor = ( $post->contentborderselect == 'color' || $post->contentborderselect == 'hexa' ) ? 1 : 0;
                $post->contentborderdata = isset($post->contentborderdata) ? $post->contentborderdata : '';

            $not_cover = true;
            $images = NULL;
            ${'asset_'.$post->module} = true;

            $post_title = isset($post->title_size) ? $post->title_size : 'h1';
            $post->hover = $post->title;

            $post->hover = $post->title;
            !isset($post->summary_switch) and $post->summary_switch = true;
            !isset($post->content_switch) and $post->content_switch = true;

            $post->slug_categories = strtolower( implode(' ', \Arr::pluck( \Model_Category::query()->related('posts')->where('posts.id', $post->id)->get(), 'slug')) );
            
            $post->title = '<span class="title-article-expose" >'.htmlentities($post->name).'</span>';
            // gallery
            if ($post->module == "gallery") {

                foreach ($dbimages as $id => $image) {
                    // $post->cover = NULL;
                    $post->images = NULL;

                    if ($image->mode == 'gallery' ) {

                        $not_cover = false;
                        $post->cover = \Uri::base(false).$image->path.'output/cover_'.$image->name.'?'.rand();
                        
                        if (!empty($image->web_hd)) {
                            $post->hd = \Uri::base(false).$image->path.'output/web_hd_'.$image->name.'?'.rand();
                            $web_hd = \Format::forge($image->web_hd, 'json')->to_array();
                        } else {
                            $post->hd = \Uri::base(false).$image->path.'output/cover_'.$image->name.'?'.rand();
                            $web_hd = \Format::forge($image->cover, 'json')->to_array();
                        }

                        $post->width = $web_hd['width'];
                        $post->height = $web_hd['height'];
                        $post->ratio = $web_hd['ratio'];
                        $post->imageid = $image->id;
                    }

                    if ($image->mode == 'image' ) {
                        $images[$image->nth] = \Uri::base(false).$image->path.'output/web_hd_'.$image->name.'?'.rand();
                    }
                }

            } else {

                // video
                $image = \Model_Image::query()->where('post_id', $post->id)->get_one();
                if ($image) {
                    $not_cover = false;
                    $post->cover = \Uri::base(false).$image->path.'output/cover_'.$image->name.'?'.rand();;
                }

            }

            if ($not_cover) {
                $post->cover = NULL;
            }

            if ($images && count($images) > 0) {
                $post->images = $images;
                if ( $post->image_output == "thumb" ) {
                    $img = \Image::sizes(reset($images));
                    $post->gallery = $img;
                }
            } else {
                $post->images = array();
            }

            $post->image_output = isset($post->image_output) ? $post->image_output : 'thumb_image';

            $post->is_flickity = ( ( $post->image_output == 'thumb_image' && !$not_cover ) || ( $post->image_output == 'text_image' && !$not_cover ) || ( count($post->images) > 0 ) ) ? TRUE : 'false' ;

            $post->albumName = implode(' ', \Arr::pluck( \Model_Category::query()->related('posts')->where('posts.id', $post->id)->get(), 'slug'));
        
        } // endforeach post

        // Setup datas posts for view
        $this->data['posts'] = $posts;
        $this->data['page'] = \Uri::base(false).$module.'/'.$page.'#p=';

        if ($from == 'backend') {

            $this->dataGlobal['pageTitle'] = __('module.'.$this->submodule.'.backend.post_manage');
            $this->dataGlobal['icon_media'] = isset($menu->iconmedia) ? $menu->iconmedia == "visible" ? true : false : false;
            $this->dataGlobal['titleicon']  = \Config::get('modules_config.'.$this->moduleName.'.backend.'.str_replace('backend_', '', $this->controllerName ).'.titleicon');
            $this->dataGlobal['list_mode'] = empty(\Uri::segment(4)) ? '/' : '/'.\Uri::segment(4);

            $menus = array();                                                             
            $site = \Project\Model_Menu::query()->order_by('order_id', 'ASC')->get();

            foreach ($site as $key => $menu) {
                if ( $menu->route == $this->submodule ) {
                    $menus[$key] = $menu;
                    $menus[$key]['count'] = count(explode(',', $menu->categories));
                }
            }
            
            if ( \Input::get('menu') !== NULL ) {
                $activedmenu = \Input::get('menu');
                \Cookie::set($this->submodule.'_menu_id', \Input::get('menu'));
            } else {
                if ( \Cookie::get($this->submodule.'_menu_id') !== NULL ) {
                    $activedmenu = \Cookie::get($this->submodule.'_menu_id');
                } else {
                    $activedmenu = 'all';
                    \Cookie::delete($this->submodule.'_menu_id');
                }
            }
            $this->dataGlobal['menus'] = $menus;
            $this->dataGlobal['activedmenu'] = $activedmenu;
            $this->dataGlobal['list_mode'] = 'preview';

        } else {

            // Add needed JS Asset for POSTS
            if ($asset_gallery)
                $this->theme->asset->js(array("libs/isotope/flickity-pkgd.js", "libs/isotope/fullscreen.js"), array(), 'footer', false);

            if ($asset_video)
                $this->theme->asset->js("libs/plyr/3.0/plyr.js", array(), 'footer', false);
                // $this->theme->asset->js("libs/plyr/2.0/plyr.js", array(), 'footer', false);

            if ($asset_sketchfab)
                $this->theme->asset->js("libs/sketchfab/sketchfab-viewer.js", array(), 'footer', false);

            if ($asset_sketchfab)
                $this->theme->asset->js(array("libs/babylonjs/babylon-min.js","libs/babylonjs/glTF2FileLoader-min.js"), array(), 'footer', false);

            $this->dataGlobal['media_ico'] = \Config::get('modules_config')['media']['backend'];

        }
        
    }

    /**
     * 
     * Get all posts
     * 
     */
    
    public function fetch($id, $media) {
        if ($id === NULL) \Response::redirect(\Router::get('homepage_index_msg', array('msg' => __('application.no-content-available') )));

        $menu = \Project\Model_Menu::find($id);
        isset($menu->featured_order) and $this->featured_order = $menu->featured_order;
        isset($menu->featured_max) and $this->featured_max = $menu->featured_max;

        if ($menu == NULL) \Response::redirect(\Router::get('homepage_index_msg', array('msg' => __('application.no-content-available') )));
        
        if ($menu->status == 'draft' || $menu->permission == 'private') \Response::redirect(\Router::get('homepage_index_msg',array('msg' => __('application.no-content-available') )));

        if ( empty($menu->categories) ) \Response::redirect(\Router::get('homepage_index_msg',array('msg' => __('application.no-content-available') )));

        // Get menu and its actived categories
        // 
        $posts = array();
        $hoverthumb = $menu->hoverthumb;

        $menu_categories = array();
        !isset($menu->sidercategories) and $menu->sidercategories = 'yes';

        if (isset($this->dataGlobal['menu_cats'])) {
            foreach ($this->dataGlobal['menu_cats'] as $category) {

                if ( \Auth::check() )
                    $post = \Model_Post::query()->related('categories')->where('categories.id', $category->id)->where('status', 'published')->and_where_open()->where('permission', 'public')->or_where('permission', 'private')->and_where_close()->order_by('order_id', 'asc')->get();
                else
                    $post = \Model_Post::query()->related('categories')->where('categories.id', $category->id)->where('status', 'published')->where('permission', 'public')->order_by('order_id', 'asc')->get();
                
                $post = array_values($post);

                if ( count($post) > 0 || $category->slug == "all" ) { //  

                    if (count($this->dataGlobal['menu_cats']) > 2)
                        $menu_categories[] = $category;

                    foreach ($post as $p) {
                        if ($hoverthumb == 'category')
                            $hover = implode(', ', \Arr::pluck( \Model_Category::query()->related('posts')->where('posts.id', $p->id)->get(), 'name' ) );
                        else
                            $hover = isset($p->$hoverthumb) ? $p->$hoverthumb : '';

                        $p->title = $hover;
                        $posts[] = $p;
                    }
                }
            }
        }

        // Get portion of posts request or all
        !isset($menu->postselect) and $menu->postselect = 'all';

        if ( $menu->postselect == 'max') {

            !isset($menu->postmax) and $menu->postmax = '10';

            switch ($menu->sorts_default) {
                case 'desc':
                    $posts = array_slice($posts, 0, $menu->postmax);
                break;

                case 'asc':
                    $posts = array_slice($posts,  abs(count($posts)-$menu->postmax), count($posts));
                break;

                case 'random':
                    shuffle($posts);
                    $posts = array_slice($posts, 0, $menu->postmax);
                break;
                
                default:
                    //
                break;
            }
            
        }

        if ( $menu->sidercategories !== 'no' ) {
            $this->dataGlobal['menu_cats'] = $menu_categories;
        } else {
            $this->dataGlobal['menu_cats'] = array();
        }

        return \Arr::unique($posts);

    }

    /**
     * 
     * Get product
     * 
     */
    
    public function fetch_product($product) {
        
        if ($product === NULL) \Response::redirect(\Router::get('homepage_index_msg', array('msg' => __('application.no-product-available') )));
        
        $menu_categories = array();
        $posts = array();

        if ( \Auth::check() )
            $post = \Model_Post::query()->where('slug', $product)->where('status', 'published')->and_where_open()->where('permission', 'public')->or_where('permission', 'private')->and_where_close()->order_by('order_id', 'asc')->get();
        else
            $post = \Model_Post::query()->where('slug', $product)->where('status', 'published')->where('permission', 'public')->order_by('order_id', 'asc')->get();
        
        $post = array_values($post);

        foreach ($post as $p) {
            
            $hover = isset($p->name) ? $p->name : $p->slug;
            $p->title = $hover;
            $posts[] = $p;
        }

        $this->dataGlobal['menu_cats'] = $menu_categories;

        return \Arr::unique($posts);

    }

    /**
     * 
     * Get products
     * 
     */
    
    public function fetch_products($prds) {
        
        if ($prds === NULL) \Response::redirect(\Router::get('homepage_index_msg', array('msg' => __('application.no-product-available'))));
        
        $products = explode(',', $prds);
        
        $menu_categories = array();
        $posts = array();
        $post = \Model_Post::query();

        foreach ($products as $product) {
            $post = $post->or_where('slug', $product);
        }

        if ( \Auth::check() )
            $post = $post->where('status', 'published')->and_where_open()->where('permission', 'public')->or_where('permission', 'private')->and_where_close();
        else
            $post = $post->where('status', 'published')->where('permission', 'public');
        
        $post = $post->order_by('order_id', 'asc')->get();

        $post = array_values($post);

        foreach ($post as $p) {
            
            $hover = isset($p->name) ? $p->name : $p->slug;
            $p->title = $hover;
            $posts[] = $p;
        }

        $this->dataGlobal['menu_cats'] = $menu_categories;

        return \Arr::unique($posts);

    }

}


