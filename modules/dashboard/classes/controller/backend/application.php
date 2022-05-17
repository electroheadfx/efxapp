<?php

namespace Dashboard;

class Controller_Backend_Application extends \Controller_Base_Backend {

	public function action_index() {


	}

	public function action_list($side = NULL, $template = NULL) {


		if (\Input::post()) {
			
			foreach ( \Input::post() as $key => $value) {

				$param = str_replace('#', '.', $key);

				\Config::set($param, $value);
				$environment = \Config::get('server.active');
				\Config::save($environment.'/app-setup','application');

			}

			\Message::warning(__('module.dashboard.backend.application.saved'));

		}

		$this->dataGlobal['pageTitle'] = __('module.dashboard.backend.application.manage');
		
		$presenter = $this->theme->presenter('backend/application/list');

		$this->theme->set_partial('content', $presenter); // ->set($this->data, null, false);

	}
  

}
