<?php


class Asset_Instance extends Fuel\Core\Asset_Instance {

/**
	 * Find File extends for work with local file outside webroot theming
	 *
	 * Locates a file in all the asset paths.
	 *
	 * @access	public
	 * @param	string	The filename to locate
	 * @param	string	The sub-folder to look in (optional)
	 * @return	mixed	Either the path to the file or false if not found
	 */

	public function render($group = null, $raw = false)
	{
		is_null($group) and $group = '_default_';

		if (is_string($group))
		{
			isset($this->_groups[$group]) and $group = $this->_groups[$group];
		}

		is_array($group) or $group = array();

		$css = '';
		$js = '';
		$img = '';
		foreach ($group as $key => $item)
		{
			$type = $item['type'];
			$filename = $item['file'];
			$attr = $item['attr'];
			$inline = $item['raw'];

			// only do a file search if the asset is not a URI
			if ($this->_always_resolve or ! preg_match('|^(\w+:)?//|', $filename))
			{
				// and only if the asset is local to the applications base_url
				if ($this->_always_resolve or ! preg_match('|^(\w+:)?//|', $this->_asset_url) or strpos($this->_asset_url, \Config::get('base_url')) === 0)
				{	

					if ( ! ($file = $this->find_file($filename, $type)))
					{
						if ($raw or $inline)
						{
							$file = $filename;
						}
						else
						{
							if ($this->_fail_silently)
							{
								continue;
							}

							throw new \FuelException('Could not find asset: '.$filename);
						}
					}
					else
					{ 
						if ($raw or $inline)
						{
							$file = file_get_contents($file);
							$inline = true;
						}
						else
						{
							$file = $this->_asset_url.$file.($this->_add_mtime ? '?'.filemtime($file) : '');
							$file = str_replace(str_replace(DS, '/', DOCROOT), '', $file);
							/*
								EFX HACK
							 */
							$file = str_replace('/..','',$file);
							
						}
					}
				}
				else
				{
					$file = $this->_asset_url.$this->_path_folders[$type].$filename;
					if ($raw or $inline)
					{
						$file = file_get_contents($file);
						$inline = true;
					}
					else
					{
						$file = str_replace(str_replace(DS, '/', DOCROOT), '', $file);
					}
				}
			}
			else
			{
				$file = $filename;
			}

			switch($type)
			{
				case 'css':
					isset($attr['type']) or $attr['type'] = 'text/css';
					if ($inline)
					{
						$css .= html_tag('style', $attr, PHP_EOL.$file.PHP_EOL).PHP_EOL;
					}
					else
					{
						if ( ! isset($attr['rel']) or empty($attr['rel']))
						{
							$attr['rel'] = 'stylesheet';
						}
						$attr['href'] = $file;

						$css .= $this->_indent.html_tag('link', $attr).PHP_EOL;
					}
				break;
				case 'js':
					$attr['type'] = 'text/javascript';
					if ($inline)
					{
						$js .= html_tag('script', $attr, PHP_EOL.$file.PHP_EOL).PHP_EOL;
					}
					else
					{
						$attr['src'] = $file;

						$js .= $this->_indent.html_tag('script', $attr, '').PHP_EOL;
					}
				break;
				case 'img':
					$attr['src'] = $file;
					$attr['alt'] = isset($attr['alt']) ? $attr['alt'] : '';

					$img .= html_tag('img', $attr );
				break;
			}

		}

		// return them in the correct order
		return $css.$js.$img;
	}

}