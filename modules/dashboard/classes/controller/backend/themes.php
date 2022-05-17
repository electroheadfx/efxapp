<?php

namespace Dashboard;

class Controller_Backend_Themes extends \Controller_Base_Backend {

	public function action_index() {


	}

	public function action_list($side = NULL, $template = NULL) {

		$this->dataGlobal['pageTitle'] = __('module.dashboard.backend.themes.manage');
		
		$this->data['side'] 	= $side;
		$this->data['template'] = $template;

		$this->data['data_themes'] 	= \Config::get('themes');
		$this->data['active'] 	= \Config::get('application.user_theme');

		$presenter = $this->theme->presenter('backend/themes/list');

		$this->theme->set_partial('content', $presenter)->set($this->data, null, false);

	}
  
    public function action_change($theme, $side, $template) {

    	if (\Auth::has_access('backend.site[modify]')) {

    		if ( $side == 'test' ) {
    			\Response::redirect(\Router::get('homepage').'?theme='.$theme.'&template='.$template);
    		}

    		\Config::set('application.user_theme.'.$side.'.'.$template, $theme);
    		\Config::save('app-setup','application');

		} else {

			\Message::danger(__('application.you-have-not-rights'));

		}
		
 		\Response::redirect(\Router::get('list_theme2', array($side, $template)));

    }

    public function action_savefrontend() {

    	if (\Auth::has_access('backend.site[modify]')) {

    		\Config::set('application.user_theme.frontend', \Config::get('application.user_theme.test'));
    		\Config::save('app-setup','application');

		} else {

			\Message::danger(__('application.you-have-not-rights'));

		}
		\Message::success(__('module.dashboard.backend.themes.front-theme-saved-successfull'));
		\Response::redirect(\Router::get('list_themes'));

    }

}
