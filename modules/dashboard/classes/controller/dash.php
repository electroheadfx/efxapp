<?php

namespace Dashboard;

class Controller_Dash extends \Controller_Base_Backend {


    public function action_index() {
        
        $side = \Uri::segment(1) == 'admin' ? 'backend' : 'frontend';

        $this->dataGlobal['pageTitle'] = __('application.dashboard');

        $this->data['modules']= [];

    	$config_modules = \Config::get('modules_config');

        foreach ($config_modules as $namespace => $config_module ) {
            
            
            if (array_key_exists($side, $config_module)) {

                foreach ($config_module[$side] as $function => $data) {
                    
                    if ($namespace == 'media' && !array_key_exists($function, \Config::get('server.modules'))) {

                        $actions_model = FALSE;

                    } else {
                        
                        $actions_model = isset($data['model']) ? $data['model'] : FALSE;
                    }

                    if ($actions_model) {

                        $title      = 'module.'.$namespace.'.default.'.\Inflector::pluralize($function);
                        $desc       = 'module.'.$namespace.'.backend.'.$function.'.manage';
                        $route      = \Config::get('modules_config.'.$namespace.'.'.$side.'.'.$function.'.route');
                        $titleicon  = $data['titleicon'];
                        $style      = $data['style'];

                        $module = array(
                            'title'     => __($title) != '' ? __($title) : $title,
                            'desc'      => __($desc) != '' ? __($desc) : $desc,
                            'route'     => $route,
                            'menu'      => empty(\Cookie::get($function.'_menu_id')) ? '?menu=all' : '?menu='.\Cookie::get($function.'_menu_id'),
                            'titleicon' => $titleicon,
                            'style'     => $style,
                        );
                        foreach ($actions_model as $key => $action) {

                            $func = 'data_'.$namespace;
                            $module['count'] = $this->$func($namespace, $key, $action);

                        }
                    $this->data['modules'][$namespace][] = $module;

                    }

                } // end foreach module's functions

            }

        }
        $this->theme->set_partial('content', 'panel')->set($this->data, null, false); 

    }

    protected function data_blog($namespace, $key, $action) {

        return $this->data_model($namespace, $key, $action);

    }

    protected function data_video($namespace, $key, $action) {

        return $this->data_model($namespace, $key, $action);

    }

    protected function data_gallery($namespace, $key, $action) {

        return $this->dataglobal_model($namespace, $key, $action);
        // return $this->data_model($namespace, $key, $action);

    }

    protected function data_cms($namespace, $key, $action) {

        return $this->dataglobal_model($namespace, $key, $action);
        // return $this->data_model($namespace, $key, $action);

    }

    protected function data_project($namespace, $key, $action) {

        return $this->dataglobal_model($namespace,$key, $action);
        // return $this->data_model($namespace, $key, $action);

    }

    protected function data_media($namespace, $key, $action) {

        return $this->datamedia_model($namespace, $key, $action);
        // return $this->data_model($namespace, $key, $action);

    }

    protected function data_menu($namespace, $key, $action) {

        return $this->dataglobal_model($namespace, $key, $action);
        // return $this->data_model($namespace, $key, $action);

    }

    /**
     * @param  string $namespace 
     * @param  string $key       
     * @param  string $action    
     */
    protected function data_dashboard($namespace, $key, $action) {
        
        if ($action == 'count')
            return count( \Config::get($key) );

        return NULL;

    }

    /**
     * @param  string $namespace 
     * @param  string $key       
     * @param  string $action    
     */
    protected function data_cinefoto($namespace, $key, $action) {
        
        if ($action == 'count')
            return count( 1 ); // templates render count

        return NULL;

    }

    private function dataglobal_model($namespace, $key, $action) {    
        
        $request = explode('::', $action);
        $action = $request[0];

        $namespace_path = '\\'.ucfirst($namespace).'\Model_'.ucfirst($key);
        if ( ! class_exists($namespace_path) ) {
            $namespace_path = '\Model_'.ucfirst($key);
        }

        if ($action == 'count') {
            $data = $namespace_path::query();
            if (isset($request[1]) ) {
                $data->where('module', $request[1]);
            }
            return count($data->get());
        }

        return NULL;

    }

    private function datamedia_model($namespace, $key, $action) {    
        
        $request = explode('::', $action);
    
        $action = $request[0];

        // array( 'post' => 'count::Cms', )

        $namespace_path = '\\'.ucfirst($namespace).'\Model_'.ucfirst($key);
        if ( ! class_exists($namespace_path) ) {
            $namespace_path = '\Model_'.ucfirst($key);
        }

        if ($action == 'count') {
            $data = $namespace_path::query();
            if (isset($request[1]) ) {
                if ($request[1] == 'Cms') {
                    $count = 0;
                    foreach(\Model_Category::query()->where('exposition', 'cms')->get() as $category) {
                        $count = $count + $category->post_count;
                    }
                    return $count;

                } else {
                    $data->where('module', $request[1]);
                }
            }
            return count($data->get());
        }

        return NULL;

    }


}






