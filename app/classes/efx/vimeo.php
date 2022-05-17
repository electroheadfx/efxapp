<?php

class Efx_Vimeo {

	/**
	 * [getVimeoInfo info]
	 * @param  [type] $id   [Vimeo video ID]
	 * @param  string $info [thumbnail_large, title, description, url]
	 * @return [type]       [description]
	 */
	
	static $vimeo_data;
	
	public static function getVimeoData($id) {
		
		if (!function_exists('curl_init')) die('CURL is not installed!');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "vimeo.com/api/v2/video/$id.php");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		try {

			$output = unserialize(curl_exec($ch));
			curl_close($ch);
			if($output === false) {
				// no connection

				if (\Fuel::$env == \Fuel::PRODUCTION) {
					self::$vimeo_data = FALSE;
					return self::$vimeo_data;
				}
				self::$vimeo_data = '';
			} else {
				self::$vimeo_data = $output[0];
			}

		} catch(Exception $e){

		    // the ID bad , I ignore the video // echo $e->getMessage();
			// self::$vimeo_data = '';
			// if (\Fuel::$env == \Fuel::PRODUCTION) {
				self::$vimeo_data = FALSE;
				return self::$vimeo_data;
			// }
		}
		return self::$vimeo_data;

	}

	public static function getVimeoInfo($info = 'thumbnail_medium', $vimeo) {
		self::getVimeoData($vimeo);
		return self::$vimeo_data[$info];
	}
	
	public static function getTitle($product) {
		
		if (\Fuel::$env == \Fuel::DEVELOPMENT && $product->title == '' && self::$vimeo_data == '') {

			// if development mode title empty and no connection
			$product->title  = \Efx_Vimeo::getTitleReplace();

		} else if (self::$vimeo_data != '' && $product->title == '') {

			// if empty title and online (from development or production mode) => grab title on vimeo title
			$product->title   = \Efx_Vimeo::getVimeoInfo('title', $product->vimeo);
			
		}

	}

	public static function getCaption($product) {

		if (\Fuel::$env == \Fuel::DEVELOPMENT && $product->caption == '' && self::$vimeo_data  == '') {

			// if development mode caption empty and no connection
			$product->caption = \Efx_Vimeo::getContentReplace();

		} else if (self::$vimeo_data  != '' && $product->caption == '') {

			// if empty caption and online (from development or production mode) => grab title on vimeo caption
			$product->caption = \Efx_Vimeo::makeClickableLinks(\Efx_Vimeo::getVimeoInfo('description', $product->vimeo));
		} else {
			$product->caption = \Efx_Vimeo::makeClickableLinks(\Efx_Vimeo::convert_line_breaks($product->caption));
		}
	}

	public static function convert_line_breaks($string, $br = true) {
		$string = preg_replace("/(\r\n|\n|\r)/", "\n", $string);
		$string = preg_replace("/\n\n+/", "\n\n", $string);
		$string = preg_replace('/\n?(.+?)(\n\n|\z)/s', "<p>$1</p>\n", $string);
		if ($br) {
			$string = preg_replace('|(?<!</p>)\s*\n|', "<br />\n", $string);
		}
		return $string;
	}

	public static function makeClickableLinks($s) {
	    return preg_replace ("/(?<!a href=\")(?<!src=\")((http|ftp)+(s)?:\/\/[^<>\s]+)/i","<a href=\"\\0\" target=\"blank\">\\0</a>",str_replace("http://josselinbillot.com","",str_replace("www.","http://",$s)));
	}

	public static function getContentReplace() {
		return "[test] Byron, c'est l'aventure des derniers pas d'une légende, un instant de présent tourné vers la mémoire, un moment de nostalgie, où un symbole de l’age d’or du cinéma réapparaît sous la poussière d’un demi-siècle, l’espace d’un battement de coeur qu’amour et destin ont déchiré à jamais.

			Court-métrage réalisé par Patrice Costa
			Avec Pierre Lottin et Wolfgang Kleinertz
			Directeur de la photographie : Josselin Billot (Arri Alexa Prores - Cooke S4)

			Durée : 30 min
			2013 [test]";

	}

	public static function getTitleReplace() {
		return "[test] Joss Stone - Stuck On you - Director's Cut [test]";
	}


}

