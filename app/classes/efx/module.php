<?php


/**
 * 
 * Extends Module for Autoload Configs,Langs and Routes Modules
 * 
 */

class Module extends Fuel\Core\Module {

    
    public static function load($module, $path = null) {

        $result = parent::load($module, $path = null);

        if (is_array($module)) {
            
            /**
             * 
             * Autoload Langs modules
             * 
             */
            
            foreach ($module as $mod) {
                \Lang::load($mod.'::'.$mod);
            }

            /**
             * 
             * Autoload Configs modules
             * 
             */
            foreach ($module as $mod) {
                \Config::load($mod.'::'.$mod, $mod);
                $modules_data[$mod] = \Config::get($mod);
                \Config::delete($mod);
            }

            foreach ($modules_data as $key => $mod) {
                if (!empty($mod)) {
                    \Config::set('modules_config.'.$key, $mod );
                }
            }

            /**
             *
             * Autoload Dashboard Configs submodules
             * 
             */

            // $dashboard_config = \Config::get('modules_config.dashboard');
            // foreach ( $dashboard_config as $side_name => $side) {

            //     foreach ( $side as $sub_name => $submodule) {

            //         \Config::load('dashboard::'.$sub_name, 'modules_config.dashboard.submodules.themes' );

            //     }

            // }

            /**
             * 
             * Autoload Routes modules
             * 
             */
            
            // foreach ($module as $mod) {
            //     \Config::load($mod.'::routes', 'routes');
            // }
            // \Config::load('user-routes', 'routes');
            \Config::load('user-routes', 'user-routes');
            \Config::set('routes', array_merge(\Config::get('routes'),\Config::get('user-routes')['routes']));

        } // end load config

        return $result;

    }

}