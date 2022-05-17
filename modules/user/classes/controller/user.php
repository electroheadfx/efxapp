<?php

namespace User;

class Controller_User extends \Controller_Base_Frontend {

    public $template = "layouts/backend_template";
 

    public function action_login($msg = NULL) {
        // already logged in?
        if (\Auth::check()) {

            // yes, so go back to the page the user came from, or the
            // application dashboard if no previous page can be detected
            if (isset($info)) {
                \Message::info(__('module.user.default.login.you-need-to-create'));
            } else {
                \Message::info(__('module.user.default.login.already-logged-in'));
            }
            \Response::redirect_back(\Router::get('admin'));
        }

        // was the login form posted?
        if (\Input::method() == 'POST') {

            // check the credentials.
            if (\Auth::instance()->login(\Input::param('username'), \Input::param('password'))) {

                // logged in, go back to the page the user came from, or the
                // application dashboard if no previous page can be detected
               \Response::redirect(\Router::get('admin'));
            
            } else {
                
                // login failed, show an error message
                \Message::danger(__('module.user.default.login.failure'));
            }
        }

        if (isset($msg)) \Message::info(__('module.user.default.login.'.$msg));

        // reset menu_cats to none
        $this->dataGlobal['menu_cats'] = array();
        $this->dataGlobal['logpage'] = true;

        // display the login page
        $this->theme->set_partial('content', 'login');
    }

    public function action_logout() {

        // remove the remember-me cookie, we logged-out on purpose
        \Auth::dont_remember_me();

        // logout
        \Auth::logout();

        // inform the user the logout was successful
        \Message::success(__('module.user.default.login.logged-out'));

        // and go back to where you came from (or the application
        // homepage if no previous page can be determined)
        \Response::redirect(\Router::get('login'));
    }


}
