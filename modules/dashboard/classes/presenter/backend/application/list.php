<?php

namespace Dashboard;

class Presenter_Backend_Application_List extends \Presenter {

	private $app;

	public function before() {

		$this->app = array( 
			'application.seo',
			'application.setup',
		);

	}

	public function view(){

		$this->application = [];			

		foreach ($this->app as $path) {

			$config = explode('.', $path);

			$config_name = array_pop($config);
			$config_path = str_replace('.'.$config_name, '', $path);
			$config_data = \Config::get($path);
			$lang		 = $config_path.'.'.$config_name;

			$this->application[$config_name] = [
				'LANG' => __($lang.'.'.$config_name) ? __($lang.'.'.$config_name) : $lang,
			];
			
			
			$this->application[$config_name]['FOLDER'] = true;

			if (is_array($config_data)) {
				
				foreach ($config_data as $key => $value) {
					
					$lang = $config_path.'.'.$config_name.'.'.$key;

					$this->application[$config_name]['CONTENT'][$key] = [
						'LANG' => __($lang.'.'.$key) ? __($lang.'.'.$key) : $lang,
					];

					if (is_array($value)) {

						$this->application[$config_name]['CONTENT'][$key]['FOLDER'] = true;

						foreach ($value as $title => $data) {
							
							// echo $config_name.'.'.'CONTENT'.'.'.$key.'.CONTENT.'.$title.'.FOLDER = true<br/>';

							$this->application[$config_name]['CONTENT'][$key]['CONTENT'][$title] = [
								'POST' => $config_path.'#'.$config_name.'#'.$key.'#'.$title,
								'LANG' => __($lang.'.'.$title) ? __($lang.'.'.$title) : $lang.'.'.$title,
							];
							$this->application[$config_name]['CONTENT'][$key]['CONTENT'][$title]['DATA'] = $data;
							$this->application[$config_name]['CONTENT'][$key]['CONTENT'][$title]['FOLDER'] = false;
							
						}

					} else {

						$lang = $config_path.'.'.$config_name.'.'.$key;

						$this->application[$config_name]['CONTENT'][$key] = [
							'POST' => $config_path.'#'.$config_name.'#'.$key.'#'.$value,
							'LANG' => __($lang) ? __($lang) : $lang,
						];
						$this->application[$config_name]['CONTENT'][$key]['DATA'] = $value;
						$this->application[$config_name]['CONTENT'][$key]['FOLDER'] = false;

					}
					
				}

			} else {

				$this->application[$config_name]['FOLDER'] = false;
				$this->application[$config_name]['DATA'] = $config_data;

			}
		}

	}

}



