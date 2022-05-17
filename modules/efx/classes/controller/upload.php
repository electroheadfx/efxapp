<?php

namespace Efx;

use \Fuel\Upload\NoFilesException;
use Efx\Helper\Slim;


class Controller_Upload extends \Controller_Rest {
    
    public function before() {

        parent::before();

        if ( \Auth::check() ) {

            \Config::load('thumb', 'app-thumb');

        } else {

            die('Not authorized');
        }

    }

    public function action_slim_remove_image_by_nth($nth = NULL, $slim_postid, $folder = "gallery") {

        $images = \Model_Image::query()->where('post_id', $slim_postid)->get();
        $imageDB = false;
        foreach ($images as $image) {
            if (isset($image->nth)) {
                if ( $image->nth == $nth ) {
                    $imageDB = $image;
                    break;
                }
            }
        }

        if ($imageDB) {
            $path = 'media/'.$folder.'/';
            $name = $imageDB->name;
            $originalefilename = $path . 'original/' . $name;
            $filename_hd = $path . 'output/web_hd_' . $name;
            $filename_cover = $path . 'output/cover_' . $name;
            if ($imageDB->delete()) {

                // test if file exists, if so, remove
                if (file_exists($filename_cover)) {
                    unlink($filename_cover);
                }
                if (file_exists($filename_hd)) {
                    unlink($filename_hd);
                }

                if (file_exists($originalefilename)) {
                    unlink($originalefilename);
                }
                return true;
            }
        }
        return false;
    }

    public function action_slim_remove_image_by_id($id = NULL, $folder = "gallery") {

        $imageDB = \Model_Image::query()->where('id', $id)->get_one();
        if ($imageDB) {
            $path = 'media/'.$folder.'/';
            $name = $imageDB->name;
            $originalefilename = $path . 'original/' . $name;
            $filename_hd = $path . 'output/web_hd_' . $name;
            $filename_cover = $path . 'output/cover_' . $name;
            if ($imageDB->delete()) {

                // test if file exists, if so, remove
                if (file_exists($filename_cover)) {
                    unlink($filename_cover);
                }
                if (file_exists($filename_hd)) {
                    unlink($filename_hd);
                }

                if (file_exists($originalefilename)) {
                    unlink($originalefilename);
                }
                return true;
            }
        }
        return false;
    }

    public function action_slim_remove_gallery($id = NULL, $folder = "gallery") {

        if ($id !== NULL ) {

            $imageDB = \Model_Image::query()->where('id', $id)->get_one();

            if ($imageDB) {

                $name = $imageDB->name;

                // the path of the uploaded files
                $path = 'media/'.$folder.'/';

                // combine both to set path to file
                $filename_cover = $path . 'output/cover_' . $name;
                $filename_thumb = $path . 'output/thumb_' . $name;
                $filename_hd = $path . 'output/web_hd_' . $name;
                $originalefilename = $path . 'original/' . $name;

                if ($imageDB->delete()) {
                    // test if file exists, if so, remove
                    if (file_exists($filename_cover)) {
                        unlink($filename_cover);
                    }

                    if (file_exists($filename_hd)) {
                        unlink($filename_hd);
                    }

                    if (file_exists($filename_thumb)) {
                        unlink($filename_thumb);
                    }

                    if (file_exists($originalefilename)) {
                        unlink($originalefilename);
                    }

                }
            }        
        }

        return false;

    }

    static function thumb( $imgpath, $imgname, $ext ) {

        // look if there a thumb on imagesrc else not create it
        // backoffice thumb  @ 500x337 pixels
        
        $path = str_replace('app/' , '', APPPATH);

        $info = pathinfo($imgname);
        $filename = $info['filename'];
        $original_ext  = $info['extension'];

        if ($original_ext !== $ext) {
            $coverPathIn = $path . 'public/'. $imgpath . 'original/'.$filename.'.'.$ext;
        } else {
            $coverPathIn = $path . 'public/'. $imgpath . 'original/'.$imgname;
        }

        if (file_exists( $coverPathIn ) === false) {
            return \Uri::base(false).'/assets/img/remove-media.jpg';
        }

        $coverPathOut = $path . 'public/'. $imgpath . 'output/thumb_'.$imgname;
        $cover = \Uri::base(false). $imgpath . 'output/thumb_'.$imgname;

        if (file_exists( $coverPathOut ) === false) {
            // CropCenter
            // CropBalanced
            // CropEntropy
            $center = new \stojg\crop\CropBalanced($coverPathIn);
            $croppedImage = $center->resizeAndCrop(360, 238);
            $croppedImage->writeimage($coverPathOut);
            // $imageHD = new \Imagick();
            // $imageHD->readImage($coverPathIn);
            // $imageHD->setimagebackgroundcolor("#DDDDDD");
            // $imageHD->thumbnailImage(500,337,true,true);
            // $imageHD->writeImage($coverPathOut);
        }
        
        return $cover;

    }

    /*
    
        Gallery add images


     */


    public function action_addimage( $folder = 'gallery', $imagesrc = NULL, $nth = NULL, $slim_postid = NULL ) {

        if ( $imagesrc == '**NEWIMAGE**' ) $imagesrc = NULL;

        if ( $nth != NULL ) {
            // search image imagesrc in DB by nth
            $images = \Model_Image::query()->where('post_id', $slim_postid)->get();
            foreach ($images as $image) {
                if (isset($image->nth)) {
                    if ( $image->nth == $nth ) {
                        $imagesrc = $image->name;
                        break;
                    }
                }
            }
        }

        $path = 'media/'.$folder.'/';

        $apppath = str_replace('app/' , '', APPPATH);

        // get SLIM images
        $images = Slim::getImages();

        if ($images == false) {

            // No image found under the supplied input name
            \Log::error('Slim was not used to upload these images');
            echo '<p>Slim was not used to upload these images.</p>';

        } else {

            // get first image
            $image = $images[0];

            // setup outputs and image mode
            $out = $path.'output/';
            $in = $path.'original/';
            $mode = $folder;

            // decompose filename
            $file = $image['output']['name'];
            $info = pathinfo($file);
            $filename = $info['filename'];
            $ext  = $info['extension'];
            $ext == 'jpeg' and $ext = 'jpg';
            // $ext = 'jpg';
            
            $postId = $image['meta']->postId;
            $imageNth = $image['meta']->imageNth;

            // get Slug and ID post
            if ( $imagesrc == NULL ) {
                // $postSlug = md5( strtolower( $filename ) ).'-'.time().'-'.$image['meta']->postId.'-Nth'.$imageNth;
                $postSlug = md5( strtolower( $filename ) ).'-'.$image['meta']->postId.'-nths';
            } else {
                $imgsrc_parts = explode('.', $imagesrc); 
                $postSlug = $imgsrc_parts[0];
            }
            
            // create name output
            $original = $postSlug.'.'.$ext;
            $name = 'cover_'.$original;
            $action = json_encode($image['actions']);

            // get Input (originale) and Output bitmap data image from SLIM
            $data_out = $image['output']['data'];
            $data_in = $image['input']['data'];
            $rotation = isset($image['actions']['rotation']) ? $image['actions']['rotation'] : 0;

            // test if exist in DB
            $imagesDB = \Model_Image::query()->where('post_id', $postId)->get();

            // Is update image or new
            $update = false;
            if ($imagesDB) {

                foreach ($imagesDB as $img) {
                    if ($img->mode == 'image' && $img->nth == $imageNth) {
                        $update = true;
                        $imageDB = $img;
                        $name = $imageDB->name;
                        $path = 'media/'.$folder.'/';
                        // delete old Nth image
                        $filename_hd = $path . 'output/web_hd_' . $name;
                        if (file_exists($filename_hd)) {
                            unlink($filename_hd);
                        }
                        break;
                    }
                }

            }
            
            // thumb resolution
            $thumbWidth = (int) \Config::get('app-thumb.gallery.thumb.width');
            $thumbHeight = (int) \Config::get('app-thumb.gallery.thumb.height');
            
            // Web HD resolution
            $webhdWidth = (int) \Config::get('app-thumb.gallery.web_hd.width');
            $webhdHeight = (int) \Config::get('app-thumb.gallery.web_hd.height');

            // Original uploaded image
            $inputWidth = (int) $image['input']['width'];
            $inputHeight = (int) $image['input']['height'];
            
            // Thumb cropped image
            $outputWidth = (int) $image['output']['width'];
            $outputHeight = (int) $image['output']['height'];

            // setup thumb ($cover) data for DB
            $w_crop = $image['actions']['crop']['width'];
            $h_crop = $image['actions']['crop']['height'];
            if ($w_crop > $h_crop) {
                $cover['ratio']     = 'h';
            } else if ( $w_crop == $h_crop ) {
                $cover['ratio']     = 's';
            } else {
                $cover['ratio']     = 'v';
            }
            
            $cover['width']     = $outputWidth;
            $cover['height']    = $outputHeight;

            // get cropping data
            $crop['x']      = number_format($image['actions']['crop']['x'],4, '.', '');
            $crop['y']      = number_format($image['actions']['crop']['y'],4, '.', '');
            $crop['width']  = number_format($w_crop,4, '.', '');
            $crop['height'] = number_format($h_crop,4, '.', '');

            // create HD
            $imageHD = new \Imagick();
            $imageHD->readImageBlob($data_in);
            $imageHD->cropImage( (int) $crop['width'], (int) $crop['height'], (int) $crop['x'], (int) $crop['y'] );
            $inputWidth        = $w_crop;
            $inputHeight       = $h_crop;
            
            // $webhdWidth x $webhdHeight its HD config max image
            // Original uploaded image : $inputWidth x $inputHeight
            // its cropped uploaded image : $outputWidth x $outputHeight

            $ratio = (float) $inputHeight/$inputWidth;
            $hdWidth     = (int) $outputWidth;
            $hdHeight    = (int) $outputHeight;
            $adaptiveResizeImage = false;

            if ($cover['ratio'] == 'h') {

                if ($outputWidth > $webhdWidth ) {
                    $hdWidth     = (int) $webhdWidth;
                    $hdHeight    = (int) $webhdWidth * $ratio;
                    $adaptiveResizeImage = true;
                    // \Log::error(' HORYZ : hdHeight : '.$hdHeight . ' - hdWidth : '.$hdWidth . ' - ratio : ' .$ratio);
                }

            } else if ($cover['ratio'] == 'v') {

                if ($outputHeight > $webhdHeight ) {
                    $hdWidth     = (int) $webhdHeight / $ratio;
                    $hdHeight    = (int) $webhdHeight;
                    $adaptiveResizeImage = true;
                    // \Log::error(' VERTICAL : hdHeight : '.$hdHeight . ' - hdWidth : '.$hdWidth . ' - ratio : ' .$ratio);
                }

            } else {
                // ratio = s
                
                if ($outputWidth > $webhdWidth ) {
                    $hdWidth = (int) $webhdWidth;
                    $hdHeight = (int) $webhdWidth;
                    $adaptiveResizeImage = true;
                    // \Log::error(' SQUARE : hdHeight : '.$hdHeight . ' - hdWidth : '.$hdWidth . ' - ratio : ' .$ratio);
                }
            }
            // Original uploaded image after crop
            // \Log::error('hdHeight : '.$hdHeight . ' - hdWidth : '.$hdWidth . ' - ratio : ' .$ratio);

            // resize to max HD config if $outputWidth or $outputHeight > HD config : $webhdHeight or $webhdHeight
            if ($adaptiveResizeImage) $imageHD->adaptiveResizeImage($hdWidth, $hdHeight);

            // write HD image and save in $web_hd for DB
            $imageHD->writeImage('media/'.$folder.'/output/web_hd_'.$original);
            $web_hd['ratio']    = $cover['ratio'];
            $web_hd['width']    = $imageHD->getImageWidth();
            $web_hd['height']   = $imageHD->getImageHeight();

            // write images and save in DB (update or new)
            if ($update) {

                $imageDB->crop      = json_encode($crop);
                $imageDB->rotation  = $rotation;
                $imageDB->web_hd  = json_encode($web_hd);
                $imageDB->cover  = json_encode($cover);
                if ($imageDB->save() ) {
                    
                    // \Log::error('updated image');
                    $file = Slim::saveFile($data_out, $name, $out, false);

                }
                
            } else {
                 
                // write data in DB
                $storeImage = \Model_Image::forge();
                $storeImage->from_array(array(
                    'post_id'   => $postId,
                    'title'     => $filename,
                    'name'      => $original,
                    'path'      => $path,
                    'type'      => $ext,
                    'crop'      => json_encode($crop),
                    'rotation'  => $rotation,
                    'mode'      => 'image',
                    'cover'     => json_encode($cover),
                    'nth'       => $imageNth,
                    'web_hd'    => json_encode($web_hd),
                ));

                if ($storeImage->save() ) {

                    // save SLIM crop
                    $file = Slim::saveFile($data_out, $name, $out, false);
                    // save original
                    $file = Slim::saveFile($data_in, $original, $in, false);
                    return $storeImage->id;
                }
                
            } // end

        }

    }

    /*
        Gallery : controller efx/upload > action : gallery
        Parameters : folder/file if exist
        http://josselin2.dev/efx/upload/gallery/gallery/liZ2F0iDSYplE_dsdvZbQUFFeWhNbnlibWhVNXc2V3U2Xy13TEI0Z0lsbWFrVUttalVlVTJvRlV4eDA.jpg
    */
    public function action_gallery( $folder = 'gallery', $imagesrc = NULL ) {

        $path = 'media/'.$folder.'/';

        $apppath = str_replace('app/' , '', APPPATH);
        $oldCover = $apppath . 'public/'. $path . 'output/thumb_'.$imagesrc.'.jpg';
        // update thumb
        if (file_exists($oldCover)) {
            unlink($oldCover);
        }

        // get SLIM images
        $images = Slim::getImages();

        if ($images == false) {

            // No image found under the supplied input name
            \Log::error('Slim was not used to upload these images');
            echo '<p>Slim was not used to upload these images.</p>';

        } else {

            // get first image
            $image = $images[0];

            // setup outputs and image mode
            // $path = 'media/video/';
            $out = $path.'output/';
            $in = $path.'original/';
            $mode = $folder;


            // decompose filename
            $file = $image['output']['name'];
            $info = pathinfo($file);
            $filename = $info['filename'];
            $ext  = $info['extension'];
            $ext == 'jpeg' and $ext = 'jpg';

            $postId = $image['meta']->postId;

            // get Slug and ID post
            if ( $imagesrc == NULL ) {
                // $postSlug = md5( strtolower( $filename ) ).'-'.time().'-'.$image['meta']->postId;
                $postSlug = md5( strtolower( $filename ) ).'-'.$image['meta']->postId;
            } else {
                $imgsrc_parts = explode('.', $imagesrc); 
                $postSlug = $imgsrc_parts[0];
            }

            // create name output
            $source = $postSlug.'.'.$ext;
            // original format
            $original = $postSlug.'.'.$ext;
            $name = 'cover_'.$original;
            $action = json_encode($image['actions']);

            // get Input (originale) and Output bitmap data image from SLIM
            $data_out = $image['output']['data'];
            $data_in = $image['input']['data'];
            $rotation = isset($image['actions']['rotation']) ? $image['actions']['rotation'] : 0;

            // test if exist in DB
            $imageDB = \Model_Image::query()->where('post_id', $postId)->get_one();

            // Is update image or new
            $update = false;
            if ($imageDB) {

                $imageDB->mode == $mode and $update = true;

            }
            
            // thumb resolution
            $thumbWidth = (int) \Config::get('app-thumb.gallery.thumb.width');
            $thumbHeight = (int) \Config::get('app-thumb.gallery.thumb.height');
            
            // Web HD resolution
            $webhdWidth = (int) \Config::get('app-thumb.gallery.web_hd.width');
            $webhdHeight = (int) \Config::get('app-thumb.gallery.web_hd.height');

            // Original uploaded image
            $inputWidth = (int) $image['input']['width'];
            $inputHeight = (int) $image['input']['height'];
            
            // Thumb cropped image
            $outputWidth = (int) $image['output']['width'];
            $outputHeight = (int) $image['output']['height'];

            // setup thumb ($cover) data for DB
            $w_crop = $image['actions']['crop']['width'];
            $h_crop = $image['actions']['crop']['height'];
            if ($w_crop > $h_crop) {
                $cover['ratio']     = 'h';
            } else if ( $w_crop == $h_crop ) {
                $cover['ratio']     = 's';
            } else {
                $cover['ratio']     = 'v';
            }

            // \Log::error('w_crop : '.$w_crop.' - h_crop : '.$h_crop);
            
            $cover['width']     = $outputWidth;
            $cover['height']    = $outputHeight;

            // get cropping data
            $crop['x']      = number_format($image['actions']['crop']['x'],4, '.', '');
            $crop['y']      = number_format($image['actions']['crop']['y'],4, '.', '');
            $crop['width']  = number_format($w_crop,4, '.', '');
            $crop['height'] = number_format($h_crop,4, '.', '');

            // create HD
            $imageHD = new \Imagick();
            $imageHD->readImageBlob($data_in);
            $imageHD->cropImage( (int) $crop['width'], (int) $crop['height'], (int) $crop['x'], (int) $crop['y'] );
            $inputWidth        = $w_crop;
            $inputHeight       = $h_crop;
            
            // $webhdWidth x $webhdHeight its HD config max image
            // Original uploaded image : $inputWidth x $inputHeight
            // its cropped uploaded image : $outputWidth x $outputHeight
            
            if ( $folder == 'gallery' ) {

                if ($inputWidth > $thumbWidth || $inputHeight > $thumbHeight ) {
                    
                    $web_hd_exist = true; 

                    $ratio = (float) $inputHeight/$inputWidth;
                    $hdWidth     = (int) $outputWidth;
                    $hdHeight    = (int) $outputHeight;
                    $adaptiveResizeImage = false;

                    if ($cover['ratio'] == 'h') {

                        if ($outputWidth > $webhdWidth ) {
                            $hdWidth     = (int) $webhdWidth;
                            $hdHeight    = (int) $webhdWidth * $ratio;
                            $adaptiveResizeImage = true;
                            // \Log::error(' HORYZ : hdHeight : '.$hdHeight . ' - hdWidth : '.$hdWidth . ' - ratio : ' .$ratio);
                        }

                    } else if ($cover['ratio'] == 'v') {

                        if ($outputHeight > $webhdHeight ) {
                            $hdWidth     = (int) $webhdHeight / $ratio;
                            $hdHeight    = (int) $webhdHeight;
                            $adaptiveResizeImage = true;
                            // \Log::error(' VERTICAL : hdHeight : '.$hdHeight . ' - hdWidth : '.$hdWidth . ' - ratio : ' .$ratio);
                        }

                    } else {
                        // ratio = s
                        
                        if ($outputWidth > $webhdWidth ) {
                            $hdWidth = (int) $webhdWidth;
                            $hdHeight = (int) $webhdWidth;
                            $adaptiveResizeImage = true;
                            // \Log::error(' SQUARE : hdHeight : '.$hdHeight . ' - hdWidth : '.$hdWidth . ' - ratio : ' .$ratio);
                        }
                    }
                    // Original uploaded image after crop
                    // \Log::error('hdHeight : '.$hdHeight . ' - hdWidth : '.$hdWidth . ' - ratio : ' .$ratio);

                    // resize to max HD config if $outputWidth or $outputHeight > HD config : $webhdHeight or $webhdHeight
                    if ($adaptiveResizeImage) $imageHD->adaptiveResizeImage($hdWidth, $hdHeight);

                    // write HD image and save in $web_hd for DB
                    $imageHD->writeImage('media/'.$folder.'/output/web_hd_'.$original);
                    $web_hd['ratio']    = $cover['ratio'];
                    $web_hd['width']    = $imageHD->getImageWidth();
                    $web_hd['height']   = $imageHD->getImageHeight();
                    

                } else {

                    // no create HD image upload has not enough pixels 
                    $web_hd_exist = false;

                }

            } else {

                // no create HD its not a gallery
                $web_hd_exist = false;

            }

            // write images and save in DB (update SLIM or new SLIM)
            // 
            if ($update) {
                //
                // Setup for SLIM update IMAGE 
                // 

                $imageDB->crop      = json_encode($crop);
                $imageDB->rotation  = $rotation;
                $imageDB->cover  = json_encode($cover);
                if ($web_hd_exist) {
                    $imageDB->web_hd  = json_encode($web_hd);
                }

                if ($imageDB->save() ) {
                    
                    // \Log::error('updated image');
                    $file = Slim::saveFile($data_out, $name, $out, false);

                }

            } else {
                //
                // Setup for SLIM NEW IMAGE
                // 
            
                // write data in DB
                $storeImage = \Model_Image::forge();
                $storeImage->from_array(array(
                    'post_id'   => $postId,
                    'title'     => $filename,
                    'name'      => $original,
                    'path'      => $path,
                    'type'      => $ext,
                    'crop'      => json_encode($crop),
                    'rotation'  => $rotation,
                    'mode'      => $folder,
                    'cover'     => json_encode($cover),
                    // 'web_hd'    => isset($web_hd) ? json_encode($web_hd) : "",
                ));
                if ($web_hd_exist) {
                    $storeImage->web_hd  = json_encode($web_hd);
                }
                
                if ($storeImage->save() ) {
                    // raster output to jpeg format
                    $file = Slim::saveFile($data_out, $name, $out, false);
                    // output original source image
                    $file = Slim::saveFile($data_in, $source, $in, false);
                    // \Log::error('created');
                    
                }
                
            }
            // end

        }

    }


    public function action_index($index = '', $crop = '', $size = '', $algorythm = '') {

        // \Log::error('index: '.$index.' - crop:'.$crop.' - size:'.$size.' - algo:'.$algorythm);
        
        $index = empty($index) ? 'cms/gallery' : 'cms/'.$index;

        $uploadpath = DOCROOT.'uploads/original/';

        $config = array(
            'path' => $uploadpath,
            'randomize' => true,
            'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
        );


        try {

            \Upload::process($config);


            if (\Upload::is_valid()) {


                \Upload::save();
                
            
                $file = \Upload::get_files();
                $image          = new \Imagick($file[0]['saved_to'].$file[0]['saved_as']);
                $upload_to_delete_after = $file[0]['saved_to'].$file[0]['saved_as'];
                $image_height   = $image->getImageHeight();
                $image_width    = $image->getImageWidth();
                $ratio_image    = intval($image_height/$image_width);
                $this->format="json";
                $name = preg_replace('/\..*/','', $file[0]['saved_as']);
                $type = $file[0]['type']; // extension type
                $maxWidth = 1024;

                switch ($type) {
                    case 'image/jpeg':
                        $extension = 'jpg';
                    break;
                    case 'image/jpg':
                        $extension = 'jpg';
                    break;

                    case 'image/png':
                        $extension = 'png';
                    break;

                    case 'image/gif':
                        $extension = 'gif';
                    break;

                    case 'image/img':
                        $extension = 'img';
                    break;
                    
                    default:
                        $extension = 'jpg';
                    break;
                }

                $filename           = preg_replace('/\..*/','', $file[0]['name']);
                $thumbfile_variant  = preg_replace('/ +/','_', $filename);
                $link               = 'uploads/'.$index;

                // 
                // 
                // copy thumbs and variantes in DOCROOT.'uploads/'.$index // $index = folder
                // 
                // 

                // $scr        = DOCROOT.'uploads/original/'.$name.'.'.$extension;
                $scr        = $file[0]['saved_to'].$file[0]['saved_as'];
                $croparray  = explode(':',$crop);
                // $crop       = preg_replace('/:/','', $crop);

                switch ($algorythm) {
                    case 'balanced':
                        $center = new \stojg\crop\CropBalanced($scr);
                    break;
                    case 'center':
                        $center = new \stojg\crop\CropCenter($scr);
                    break;
                    case 'entropy':
                        $center = new \stojg\crop\CropEntropy($scr);
                    break;
                    default:
                        $center = new \stojg\crop\CropBalanced($scr);
                    break;
                }
                
                //
                //  here calculate the format with crop and size
                //  
                //////////////
                /////CROP/////
                ///on définit le crop

                 if ($croparray[0] > 0 && $croparray[1] > 0) {

                     $ratio = $croparray[1]/$croparray[0];
                     $croparray[2] == 's' and $ratio = 1;

                 } else {

                     $ratio = $image_height / $image_width;
                     if ($ratio > 1) {
                        $croparray[2] = 'v';
                     } else if ($ratio < 1) {
                        $croparray[2] = 'h';
                     } else {
                        $croparray[2] = 's';
                     }
                 }

                // \Log::error($croparray[0].':'.$croparray[1].':'.$croparray[2].' - image_width : '.$image_width . ' - image_height : '. $image_height . ' - ratio : '.$ratio);
                ////////////////
                //////SIZE//////
                // on calcul l'image orginale ou forcé
                
                 if ($size > 0) {
                 
                     // l'image sera au maximun de $size
                     
                    if ($croparray[2] == 'h')  {

                        $image_width < $size and $size = $image_width;
                        // faire idem avec une image > BIG
                        $width = $size;
                        $height = $ratio*$size;

                    } else if ($croparray[2] == 'v')  {

                        $image_height < $size and $size = $image_height;
                        $width = $size/$ratio;
                        $height = $size;

                    }  else {

                        $image_width < $size and $size = $image_width;
                        $width  = $size;
                        $height = $size;
                    }
                     
                 } else {

                    // l'image aura sa taille en pixel originale

                     if ($croparray[0] > 0 && $croparray[1] > 0) {
                         // crop exist
                         
                         $size = $width;
                         
                         if ($ratio < 1) {
                            
                            $image_width > $maxWidth and $image_width = $maxWidth;
                            $width = $image_width;
                            $height = $ratio*$image_height;

                        } else if ($ratio > 1) {

                            $image_height > $maxWidth and $image_height = $maxWidth;
                            $width = $image_height/($croparray[1]/$croparray[0]);
                            $height = $image_height;

                        } else {

                            $image_height > $maxWidth and $image_height = $maxWidth;
                            $width = $image_height;
                            $height = $image_height;

                        }

                     } else {
                        // no crop
                        // determine ratio crop for froala with originale image size
                        if ($ratio < 1) {
                            
                            $crop = '0:0:h';
                            if ($image_width > $maxWidth) {
                                $image_width = $maxWidth;
                                $width = $image_width;
                                $height = $image_width*$ratio;
                            } else {
                                $width = $image_width;
                                $height = $image_height;
                                $size = $width;
                            }

                        } else if ($ratio > 1) {

                            $crop = '0:0:v';
                            if ($image_height > 2500) {
                                $image_height = 2500;
                                $width = $image_height/$ratio;
                                $height = $image_height;
                                $size = $width;
                            } else {
                                $width = $image_width;
                                $height = $image_height;
                                $size = $width;
                            }
                            
                        } else {

                            $crop = '0:0:s';
                            if ($image_height > $maxWidth || $image_width > $maxWidth) {
                                $image_width = $maxWidth;
                                $width = $image_width;
                                $height = $image_width;
                                $size = $width;
                            } else {
                                $width = $image_width;
                                $height = $image_height;
                                $size = $width;
                            }
                        }



                     }
                 }

                 $fileoutput = $link . '/' . $thumbfile_variant . '+' . $crop . '+' . $size . '+' . $algorythm . '.' . $extension;

                 // \Log::error('with : '.$width . ' - height : '. $height . ' - ratio : '.$ratio);

                // crop and render image
                $croppedImage = $center->resizeAndCrop($width, $height);
                $croppedImage->writeimage(DOCROOT . $fileoutput);

                // write data in DB
                    // $image = \Model_Image::forge();
                    // $image->from_array(array(
                    //     'post_id'   => 1,
                    //     'title'     => $filename,
                    //     'name'      => $name,
                    //     'path'      => $link,
                    //     'type'      => $extension,
                    // ));
                    // $image->save();

                // delete upload HD image
                \File::delete($upload_to_delete_after);

                // return image variant to froala_editor
                return $this->response(array(
                    'link' => '/'.$fileoutput
                ));

            }

        } catch (NoFilesException $e) {
            
            echo 'No authorized access';
            // echo $e->getMessage();

        }

        return false;

    }
// http://domain.com/efx/upload/images.json?index=cv
    public function get_images() {
        $index = \Input::get('index') !== null ? \Input::get('index') : 'gallery';
        $files = [];
        $contents = \File::read_dir(DOCROOT.'uploads/cms/'.$index.'/', 0, array( 
            '!^\.', // no hidden files/dirs
            '!^private' => 'dir',  // no private dir
            '!^original'=> 'dir',  // no original dir
            '!^thumb'   => 'dir',  // no thumb dir
            '!^error'   => 'dir',  // no error dir
            '\.png$'    => 'file', // only get png's
            '\.jpg$'    => 'file', // or jpg files
            '\.gif$'    => 'file', // or gif files
            '\.img$'    => 'file', // or img files
            // '!^_', // exclude everything that starts with an underscore.
        ));

        foreach ($contents as $tag => $content) {

            $files[] = [
               'url' => \Uri::base(false).'uploads/cms/'.$index.'/'.$content,
               'thumb' => \Uri::base(false).'uploads/cms/'.$index.'/'.$content,
               // 'tag' => preg_replace('/\//', '', $tag)
            ];
        }

        return $this->response($files);

        /*

        foreach ($contents as $tag => $content) {

            if (!is_numeric($tag) && !empty($content)) {

                    // Its a folder with content
                    // echo 'folder '.$tag.' with content<br/>';

                    foreach ($content as $key => $value) {

                        if (is_numeric($key)) {

                            $files[] = [
                                'url'=> \Uri::base(false).'uploads/'.$tag.$value,
                                'thumb' => \Uri::base(false).'uploads/'.$tag.$value,
                                'tag' => preg_replace('/\//', '', $tag)
                            ];
                            // echo 'image de \''.$tag.'\' : '.\Uri::base(false).'uploads/'.$index.$value.'<br/>';
                        }
                    }
                    // echo '<hr/>';
                
            } else {

                if (is_numeric($tag)) {
                    
                    // its only 1 image -  defaut tag = Tous
                    // echo 'Image<br/>';
                    $files[] = [
                       'url' => \Uri::base(false).'/'.$index.$content,
                       'thumb' => \Uri::base(false).'/'.$index.$content,
                       // 'tag' => preg_replace('/\//', '', $tag)
                    ];
                    // echo \Uri::base(false).'uploads/'.$index.$content.'<hr/>';
                }
                
            }

        }

        return $this->response($files);
        */

    }

    public function get_test() {
        $response = new \Response();
        return $response->set_status(200);
    }

    public function get_testyoutube($id) {
        $response = new \Response();
        $video_url = @file_get_contents('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v='.$id);

        if($video_url) {

            // echo('video exists');
            return $response->set_status(200);
            
        } else {

            // echo('video does not exists');
            return $response->set_status(404);

        };
    }

    public function get_testvimeo($id) {

        $response = new \Response();

        if ( \Efx_Vimeo::getVimeoData($id) == false ) {
            
            return $response->set_status(404);

        } else {

            return $response->set_status(200);
        }

    }

    public function action_delete() {

        $pathfile = \Input::post('src');
        $file = explode('/', $pathfile);
        array_shift($file);
        array_shift($file);
        array_shift($file);
        $file = implode("/",$file);
        \File::delete(DOCROOT.'/'.$file);
        return NULL;

    }

    public function action_save() {

        $post = Model_Post::find(\Input::post('id'));

        if ( ! empty($post) ) {

            $editor = \Input::post('body');

            if ( $editor == 'content' ||  $editor == 'summary' ) {

                $post->$editor = \Input::post(\Input::post('body'));


            } else {

                $response = new Response();
                $response->set_status(404);

            }

        } else {

            $response = new Response();
            $response->set_status(404);

        }

        if (! $post->save()) {
            $response = new Response();
            $response->set_status(404);
        }

        // \Log::error('ID : '.\Input::post('id') . ' - '.\Input::post('body').' : '. \Input::post(\Input::post('body')) );

    }

    public function seo_friendly_url($string){

        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-'));

    }

    public function action_test($width = 300, $height = 100, $focus = 'entropy' ) {

        $original       = 'coco';
        $original       = 'coco2';
        $folder         = 'uploads/';
        $request        = $original . '-' . $width . '-' . $height . '-' . $focus;
        $render         = $folder . $request;
        $scr            = DOCROOT . $folder . $original . '.jpg';
        $output         = DOCROOT . $render . '.jpg';

        $output2        = DOCROOT . $render . '-center' . '.jpg';
        $url            = \Uri::base(false) . $render . '.jpg';
        $url2            = \Uri::base(false) . $render . '-center' . '.jpg';
        $originalurl    = \Uri::base(false) . $folder . $original . '.jpg';

        echo "scr : $scr<br/>";
        echo "render : $render<br/>";
        echo "output : $output<br/>";

        switch ($focus) {
            case 'balanced':
                $center = new \stojg\crop\CropBalanced($scr);
            break;
            case 'center':
                $center = new \stojg\crop\CropCenter($scr);
            break;
            case 'entropy':
                $center = new \stojg\crop\CropEntropy($scr);
            break;
            
            default:
                $center = new \stojg\crop\CropBalanced($scr);
            break;
        }
        
        $croppedImage = $center->resizeAndCrop($width, $height);
        $croppedImage->writeimage($output);
        
        $center = new \stojg\crop\CropCenter($scr);
        $croppedImage = $center->resizeAndCrop($width, $height);
        $croppedImage->writeimage($output2);

        $response = new \Response();
        $response->set_header('Content-Language', 'en');
        $response->set_header('Content-Type', 'text/html; charset=utf-8');

        $response->body( '<hr/><h1>original :</div> <div> <img src="'.$originalurl.'" /> </div> <h1>center :</div> <div> <img src="'.$url2.'" /> </div> <h1>cropped :</div> <div> <img src="'.$url.'" /> </div>' );

        return $response;

        //////// end test
    }


}
