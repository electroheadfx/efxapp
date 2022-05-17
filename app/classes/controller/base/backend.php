<?php

class Controller_Base_Backend extends \Controller_Base_Template {

    public $template = "layouts/backend_template";
    public $lang;

    public function before() {

        parent::before();

        // Check Auth Access
        if ( ! \Auth::check()) {
            \Message::info(__('module.user.default.login.not-logged'));
            \Response::redirect(\Router::get('login'));
        }

        // Set global
        $this->dataGlobal['title']      = \Config::get('application.seo.backend.title');
        $this->dataGlobal['titleicon']  = \Config::get('modules_config.'.$this->moduleName.'.backend.'.str_replace('backend_', '', $this->controllerName ).'.titleicon');
        $this->dataGlobal['style']      = \Config::get('modules_config.'.$this->moduleName.'.backend.'.$this->controllerName.'.style');
        $this->dataGlobal['body']           = 'backend';
        $this->dataGlobal['lang']  = $this->lang = 'module.'.$this->moduleName.'.';

    }
 
    public function setMedia() {

        parent::setMedia();

        $this->createAssetsBottle('css', 'backend');
        $this->createAssetsBottle('js', 'backend');

        // autoload file theme's root at end bottles creation
        $this->createAssetsBottleFromFiles();

        $this->renderBottle('css');
        $this->renderBottle('js'); 

        // render Sidebar menu from admin for dash, project or media
        
        if ( \Uri::segment(1) == 'media' ) {

            // render for media
            $this->dataGlobal['menu_cats'] = Model_Category::query()->where('exposition',\Uri::segment(3))->or_where('exposition','all')->order_by('order_id', 'ASC')->get();
        
        } else {
            
            // render for dash
            $this->dataGlobal['menu_cats'] = array();
        }


    }


}
