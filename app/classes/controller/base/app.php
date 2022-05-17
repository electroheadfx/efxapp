<?php

class Controller_Base_App extends \Controller_Hybrid {

    public function before() {

        // setup server type (cdn or site) uncomment for have a CDN
        // if (\Uri::base(false) == Config::get('server.'.\Config::get('server.active').'.domain.cdn')) {
        //     \Response::redirect(Config::get('server.'.\Config::get('server.active').'.domain.site'));
        // }

        /**
         * Load Application,Server, and AppLang configs
         */
        // Load assets route config
        \Config::load('app-assets-route', 'assets');
        \Config::load(\Request::active()->module.'::assets-route', 'assets');
        if (\Config::get('server.active') == \Fuel::DEVELOPMENT)
            \Config::load('app-assets-grunt.json', 'assetsgrunt');
        
        \Config::load('thumb', 'app-thumb');
        // \Config::load('slider', 'slider');
        
        \Config::load('app-themes.json', 'themes');     
        \Lang::load('app');
        

    }

}


