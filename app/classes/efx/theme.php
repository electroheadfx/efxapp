<?php


class Theme extends Fuel\Core\Theme {
	
	public function find($theme) {

		foreach ($this->paths as $path) {

			if (is_dir($path.$theme)) {

				return $path.$theme.DS.'templates'.DS;
			}
		}

		return false;
	}

	public function img($src) {
		// $assets = \Config::get('server.active') == 'development' ? 'assets/' : '';
		$assets = '';
		return \Config::get('server.'.\Config::get('server.active').'.theme.url').'themes/'.\Config::get('application.user_theme.frontend.asset').'/'.$assets.'img/'.$src;
	}

}
