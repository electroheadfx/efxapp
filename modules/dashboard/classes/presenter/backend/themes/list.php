<?php

namespace Dashboard;

class Presenter_Backend_Themes_List extends \Presenter {

	public function view(){

		($this->side != 'frontend' && $this->side !='backend') and $this->side = 'test';
		$this->side == 'frontend' and $this->side = 'test';
		($this->template != 'asset' && $this->template !='template') and $this->template = 'asset';

		$this->inversed 	= ($this->side == 'backend') ? 'frontend' : 'backend';

		$this->cssTabFirst = [ 'test' => '', 'backend' => '', 'asset' => '', 'template' => '' ];

		$this->cssTabFirst[$this->side] 	= 'in active';
		$this->cssTabFirst[$this->template] = 'in active';

		$this->themes = [
			'test' => [
				'asset'  	=> [],
				'template' 	=> [],
			],
			'backend' => [
				'asset'  	=> [],
				'template' 	=> [],
			]
		];

		foreach($this->data_themes as $theme) {

			$theme['icon'] 		= 'fa fa-chain-broken';
			$theme['status'] 	= __('module.dashboard.backend.themes.status-off');
			$theme['css_theme'] = 'theme';
			$theme['actived'] 	= false;

			$theme_name 		= __('module.dashboard.backend.themes.library.'.$theme['name']);
            $theme['i18n'] 		= empty($theme_name) ? $theme['name'] : $theme_name ;
             
			
			foreach ($theme['access'] as $side) {

				$side == 'frontend' and $side = 'test';
				
				switch ($theme['mode']) {
					case 'asset':
						$this->themes[$side]['asset'][] 	= $theme;
					break;
					case 'template':
						$this->themes[$side]['template'][] 	= $theme;
					break;
					case 'theme':
						$this->themes[$side]['asset'][] 	= $theme;
						$this->themes[$side]['template'][] 	= $theme;
					break;
				}
				
			} // end foreach $theme

		} // end foreach data_themes

		foreach (['test', 'backend'] as $s) {

			foreach (['asset','template'] as $t) {

				$pos = explode('.', \Arr::search($this->themes[$s][$t], $this->active[$s][$t]))[0];

				if ( $pos == 0 || intval($pos) ) {

					$this->themes[$s][$t][$pos]['icon'] 	 = 'fa fa-chain';
					$this->themes[$s][$t][$pos]['lang'] 	 = __('module.dashboard.backend.themes.status-on');
					$this->themes[$s][$t][$pos]['css_theme'] = 'theme active';
					$this->themes[$s][$t][$pos]['actived'] 	 = true;

				}

			}
		} // end foreach data_themes

		// \Debug::dump($this->themes);
		// die();

	}

}



