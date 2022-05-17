<?php

namespace Efx;

class Controller_Font extends \Controller_Rest {

public function get_index() {

        // get local font
        // 
        // /efx/font/index.css?family=Open+Sans&weight=200Condensed+Light,200Condensed+Light+Italic&theme=cru2vie-default
        
        $family      = \Input::get('family');
        $family_sans = str_replace(' ', '', $family);
        $theme       = \Input::get('theme');
        $weight      = explode(',', \Input::get('weight'));
        $types       = ['eot' => 'embedded-opentype', 'woff' => 'woff', 'otf' => 'otf', 'ttf' => 'truetype', 'svg' => 'svg'];


        $content = '';
        $i=0;

        foreach ($weight as $font) {

            // e.g. $font = "400italic"
            $style  = preg_replace('/[0-9]/', '', $font);    // italic
           
            $w      = preg_replace('/[a-zA-Z]/', '', $font); // 400

            $namefont = str_replace(' ', '', $style);
        
            // $assets = \Fuel::$env == 'production' ? '' : '/assets';
            $assets = '';

            $uri = \Config::get('server.'.\Config::get('server.active').'.theme.url').'themes/'.$theme.$assets.'/fonts/'.$family_sans.'/'.$family_sans.'-'.$namefont;
            
            $src = '';

            empty($style) and $style = 'normal';
            
            foreach ($types as $type => $format) {

                $hackIE = $type == 'eot' ? '?#iefix' : '';
                $token = $type == 'svg' ? '#'.time() : '';
                $esc = <<<EOF
,

EOF;
                $end = $type != 'svg' ? $esc : '';

                $src .= <<<EOF
    url('$uri.$type$hackIE$token') format('$format')$end
EOF;
            }

            $content .= <<<EOF
@font-face {
    font-family: '$family $style';
    src: url('$uri.eot'); /* IE9 Compat Modes */
    src:$src;
    font-style: normal;
    font-weight: $w;
}

EOF;
            $i++;

        }

        // $response = new \Response($content, 404);

        $headers = array (
            'Cache-Control'     => 'no-cache, no-store, max-age=0, must-revalidate',
            'Expires'           => 'Mon, 26 Jul 1997 05:00:00 GMT',
            'Pragma'            => 'no-cache',
            'Content-Type'      => 'text/css; charset=utf-8',
        );
        $response = new \Response($content, 200, $headers);

        return $response;
        

    }

    public function get_path($asset = NULL) {

        $headers = array (
            'Cache-Control'     => 'no-cache, no-store, max-age=0, must-revalidate',
            'Expires'           => 'Mon, 26 Jul 1997 05:00:00 GMT',
            'Pragma'            => 'no-cache',
            'Content-Type'      => 'text/txt; charset=utf-8',
        );
        $config = 'server.'.\Config::get('server.active');
        $asset = str_replace('_', '.', $asset);
        $asset = str_replace(',', '?', $asset);
        $response = new \Response( \Config::get($config.'.theme.url').\Config::get($config.'.theme.assets_folder').'/fonts/'.$asset , 200, $headers);

        return $response;

    }

}