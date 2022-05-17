<?php

class Controller_Base_Frontend extends \Controller_Base_Template {

    public $template = "layouts/frontend_template";

    private function setupTheme($menu) {

        /* sorts default */
        $this->dataGlobal['sorts_default']          = isset($menu->sorts_default) ? $menu->sorts_default : \Config::get('application.setup.site.order');
        /* navbar margin */
        $this->dataGlobal['navbarmargin']           = isset($menu->navbarmargin) ? $menu->navbarmargin == 'default' ? '0' : $menu->navbarmargin.'px' : '0';
        /* navbar state */
        $this->dataGlobal['navbarstate']            = isset($menu->navbarstate) ? $menu->navbarstate : 'fixed';

        /* logo */
        $this->dataGlobal['logoselect']             = $menu->logoselect = isset($menu->logoselect) ? $menu->logoselect : 'default';
        $this->dataGlobal['logoselectcolor']        = $menu->logoselect == 'color' || $menu->logoselect == 'hexa' ? 1 : 0;
        $this->dataGlobal['logodata']               = isset($menu->logodata) ? $menu->logodata : '';

        /* logo 2 */
        $this->dataGlobal['logo2select']            = $menu->logo2select = isset($menu->logo2select) ? $menu->logo2select : 'default';
        $this->dataGlobal['logo2selectcolor']       = $menu->logo2select == 'color' || $menu->logo2select == 'hexa' ? 1 : 0;
        $this->dataGlobal['logo2data']              = isset($menu->logo2data) ? $menu->logo2data : '';

        /* background */
        $this->dataGlobal['bgselect']               = $menu->bgselect = isset($menu->bgselect) ? $menu->bgselect : 'default';
        $this->dataGlobal['bgselectcolor']          = $menu->bgselect == 'color' || $menu->bgselect == 'hexa' ? 1 : 0;
        $this->dataGlobal['bgdata']                 = isset($menu->bgdata) ? $menu->bgdata : '';
        
        /* sider */
        $this->dataGlobal['bgsiderselect']          = $menu->bgsiderselect= isset($menu->bgsiderselect) ? $menu->bgsiderselect : 'default';
        $this->dataGlobal['bgsiderselectcolor']     = $menu->bgsiderselect == 'color' || $menu->bgsiderselect == 'hexa' ? 1 : 0;
        $this->dataGlobal['bgsiderdata']            = isset($menu->bgsiderdata) ? $menu->bgsiderdata : '';
        
        /* nav */
        $this->dataGlobal['navselect']              = $menu->navselect = isset($menu->navselect) ? $menu->navselect : 'default';
        $this->dataGlobal['navselectcolor']         = $menu->navselect == 'color' || $menu->navselect == 'hexa' ? 1 : 0;
        $this->dataGlobal['navdata']                = isset($menu->navdata) ? $menu->navdata : '';

        /* right nav */
        $this->dataGlobal['navrightselect']         = $menu->navrightselect = isset($menu->navrightselect) ? $menu->navrightselect : 'default';
        $this->dataGlobal['navrightselectcolor']    = $menu->navrightselect == 'color' || $menu->navrightselect == 'hexa' ? 1 : 0;
        $this->dataGlobal['navrightdata']           = isset($menu->navrightdata) ? $menu->navrightdata : '';
        
        /* media bg */
        $this->dataGlobal['mediaselect']            = $menu->mediaselect = isset($menu->mediaselect) ? $menu->mediaselect : 'default';
        $this->dataGlobal['mediaselectcolor']       = $menu->mediaselect == 'color' || $menu->mediaselect == 'hexa' ? 1 : 0;
        $this->dataGlobal['mediadata']              = isset($menu->mediadata) ? $menu->mediadata : '';

        /* Main text */
        $this->dataGlobal['textcolor']              = isset($menu->uitextdata) ? $menu->uitextdata : '';
        $this->dataGlobal['texthovercolor']         = isset($menu->uitexthoverdata) ? $menu->uitexthoverdata : '';
        $this->dataGlobal['blockhovercolor']        = isset($menu->uiblockhoverdata) ? $menu->uiblockhoverdata : '';
        $this->dataGlobal['textactivecolor']        = isset($menu->uitextactivedata) ? $menu->uitextactivedata : '';

        /* sider text */
        $this->dataGlobal['textsidercolor']         = isset($menu->uisidertextdata) ? $menu->uisidertextdata : '';
        $this->dataGlobal['textsiderhovercolor']    = isset($menu->uisidertexthoverdata) ? $menu->uisidertexthoverdata : '';
        $this->dataGlobal['textsideractivecolor']   = isset($menu->uisidertextactivedata) ? $menu->uisidertextactivedata : '';

    }

    public function setMedia() {

        parent::setMedia();

        $menus = \Project\Model_Menu::query()->where('status', 'published')->order_by('order_id', 'ASC')->get();
        $navigations = array();
        $i = 0;
        $actived_categories = array();

        foreach ($menus as $menu) {

            $uri = false;
            if ( isset($menu->uri_state) ) {
                $uri = true;
                if ( $menu->uri_state == 'on' ) {
                    \Config::set('assets.frontend.js.'.$menu->uri, 'frontend.js.'.$menu->route);
                    \Config::set('assets.frontend.css.'.$menu->uri, 'frontend.css.'.$menu->route);
                }
            }

            if ($menu->permission == 'public' || ( $menu->permission == 'private' && \Auth::check() )) {

                if ($menu->status == 'published' ) {
                    
                    $route = $menu->route.'/'.$menu->id;
                    $actualUri = \Uri::segment(1).'/'.\Uri::segment(2);

                    if ($uri) {
                        if ( $menu->uri_state == 'on' ) {
                            $route = $menu->uri;
                            $actualUri = \Uri::segment(1);
                        }
                    }
                    
                    $key = strtolower($menu->name);
                    $modules = $menu->modules;
                    $faicon = isset($menu->faicon) ? $menu->faicon : '';
                    $meta = isset($menu->meta) ? $menu->meta : '';
                    $navigation['name']      = isset($menu->titletransform) ? $menu->titletransform == "capital" ? strtoupper($menu->name) : $menu->name : $menu->name;
                    $navigation['modules']   = $modules;
                    $navigation['target']    = $menu->target;
                    $navigation['hover']     = $menu->hoverthumb;
                    $navigation['route']     = $route;
                    $navigation['scrollto']  = isset($menu->scrollto) ? $menu->scrollto : 'hidden';
                    $navigation['mediaautoclose']  = isset($menu->mediaautoclose) ? $menu->mediaautoclose : 'auto';
                    $navigation['scrolltofeatured']  = isset($menu->scrolltofeatured) ? $menu->scrolltofeatured : 'all';
                    $navigation['scrollpausetime']  = isset($menu->scrollpausetime) ? $menu->scrollpausetime : '2000';
                    $navigation['icon']      = isset($menu->iconvisibility) ? $menu->iconvisibility == "disabled" ? '' : $faicon : $faicon;
                    $navigation['css']       = 'menu';
                    $navigation['meta']      = $meta;
                    $navigation['slicePoint']= isset($menu->slicePoint) ? $menu->slicePoint : 0;
                    $navigation['render']    = isset($menu->render) ? $menu->render : 'menu';
                    if ( $i == 0 ) {
                        // setup for default module for home (the first menu in position)
                        $this->dataGlobal['iconversion'] = isset($menu->iconversion) ? $menu->iconversion : 'menu';
                        $this->setupTheme($menu);
                        $navigation['css'] = Uri::main() == Uri::base(false) ? 'menu active' : 'media';
                        $actived_categories = $this->dataGlobal['actived_categories'] = explode(',', $menu->categories);
                        $this->dataGlobal['show_tooltip'] = isset($menu->tooltip) ? $menu->tooltip == "visible" ? true : false : false;
                        $this->dataGlobal['sorts_control'] = isset($menu->sorts_control) ? $menu->sorts_control : 'none';
                        if ( $modules == 'module' || $modules == 'uri' )  $this->dataGlobal['category_cms'] = $menu->summary;
                        $this->dataGlobal['active_module'] = $route;
                        $this->dataGlobal['summary_switch'] = isset($menu->summary_switch) ? $menu->summary_switch : true;
                        $this->dataGlobal['icon_media'] = isset($menu->iconmedia) ? $menu->iconmedia == "visible" ? true : false : false;
                    }

                    if ( $actualUri == $route ) {

                        $this->dataGlobal['iconversion'] = isset($menu->iconversion) ? $menu->iconversion : 'media';
                        
                        $this->setupTheme($menu);
                        $navigation['css'] = 'menu active';
                        $actived_categories = $this->dataGlobal['actived_categories'] = isset($menu->categories) ? explode(',', $menu->categories) : array();
                        $this->dataGlobal['show_tooltip'] = isset($menu->tooltip) ? $menu->tooltip == "visible" ? true : false : false;
                        $this->dataGlobal['sorts_control'] = isset($menu->sorts_control) ? $menu->sorts_control : 'none';
                        if ( $modules == 'module' || $modules == 'uri'  )  $this->dataGlobal['category_cms'] = $menu->summary;
                        $this->dataGlobal['active_module']  = $route;
                        $this->dataGlobal['summary_switch'] = isset($menu->summary_switch) ? $menu->summary_switch : true;
                        $this->dataGlobal['icon_media'] = isset($menu->iconmedia) ? $menu->iconmedia == "visible" ? true : false : false;                    }
                        // \Debug::dump(isset($menu->iconmedia)); die();
                    if ( $navigation['render'] == 'menu' || $i == 0 )
                        $navigations[] = $navigation;

                }
            }
            $i++;
        }

        // \Asset::add_type('svg', 'assets/svg/', function($file, $attr, $inline) {
        //     // return the svg file
        //     return file_get_contents($file);
        // });

        $this->createAssetsBottle('css', 'frontend');
        $this->createAssetsBottle('js', 'frontend');

        // autoload file theme's root at end bottles creation
        $this->createAssetsBottleFromFiles();

        $this->renderBottle('css'); 
        $this->renderBottle('js');
                                               
        $this->dataGlobal['navigations'] = $navigations;

        // create categories Sider Nav ($menu_cats) along menu's actived_categories
        // 
        $menu_cats = \Model_Category::query();

        foreach ($actived_categories as $id) {

            $menu_cats = $menu_cats->or_where('id',$id)->where('post_count', '>', 0)->where('status','published');
        }
        
        $menu_cats = $menu_cats->or_where('slug','all')->where('post_count', '>', 0)->where('status','published')->order_by('order_id', 'ASC')->get();
        
        foreach ($menu_cats as $menu) {

            if ($menu->permission == 'public' || ( $menu->permission == 'private' && \Auth::check() ) ) {
                // if ($menu->slug == 'all' && count($menu_cats) < 3) break;
                $this->dataGlobal['menu_cats'][] = $menu;
            }

        } 
    }

}
