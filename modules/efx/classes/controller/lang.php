<?php

namespace Efx;

class Controller_Lang extends \Controller_Rest {

    public function get_index($lang = 'fr') {
        
        // call "/efx/lang/index/en" link to change to en     

        \Cookie::set('lang', $lang);

        \Response::redirect_back(\Router::get('admin'));

        return $this->response();

    }


}