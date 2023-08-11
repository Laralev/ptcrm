<?php

namespace App\Controller\Component;

require_once('ArGD.php');

use Cake\Controller\Component;
use ArabicGD;


class ImagesComponent extends Component {
	
	var $allowed_ext = array(
                 'images'=>array('jpg','jpeg','gif','png'),
                 'media'=>array('swf','flv'),
                 'doc'=>array('doc','pdf')
                 );
	var $max_upload_size = 3500;// per kilobyte
	var $Error_Msg = array();
    var $photosname = array();
    


    function fixImageOrientation($imgPath) {

        $exif = @exif_read_data($imgPath);
        
        if(!empty($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
            if($orientation != 1){

                $img = imagecreatefromjpeg($imgPath);
                
                $extension = substr($exif['MimeType'], 6);
                
                $deg = 0;
                switch ($orientation) {
                    case 3:
                        $deg = 180;
                        break;
                    case 6:
                        $deg = 270;
                        break;
                    case 8:
                        $deg = 90;
                        break;
                }
                if ($deg) {
                    $img = imagerotate($img, $deg, 0);        
                }
                
                ob_start();
                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                        imagejpeg($img);
                        break;
                    case 'png':
                        imagepng($img);
                        break;
                }
                $imageData = ob_get_contents();
                ob_end_clean();
                return $imageData;
            }
            return $imgPath;
        }
        return false;
    }

        // if($this->getExt((array)$file) == 'png'){
        //     $img = base64_decode( explode(",", $file['tmp_name'])[1] );
        // }else{
        //     $img = explode(",", $file['tmp_name'])[1];
        // }


    function uploader($path, $file, $name, $thumb, $crup=0, $watermark=false)
    {
        $file = !is_array($file) ? (array)$file : $file;  
		!empty($name) ? $newName = $name.'.'.$this->getExt((array)$file) : $newName = date('ymd').time().count($this->photosname).'.'.$this->getExt($file);
        
        if(strlen($file['tmp_name'])>255){
            $img = explode(",", $file['tmp_name'])[1];
            $isUploaded = file_put_contents($path.'/'.$newName, base64_decode($img));
        }else{
            $isUploaded = move_uploaded_file($file['tmp_name'], $path.'/'.$newName);
        }
		if($isUploaded) {
            $this->photosname[] = $newName;
            // waternmark
            if($watermark && $this->getExt($file) != 'png'){
                $this->addWaterMark_img($path.'/'.$newName, 'img/stamp.png');
            }
            // replace original image with smaller one
            $dim = getimagesize($file['tmp_name']);
            if($dim[0] > 1600 || $dim[1] > 1600){
                $thumb[] = ['dst'=>'', 'w'=>1600, 'h'=>1600, 'doThumb'=>true];
            }
            // create thumbnails
			for($i=0; $i<count($thumb); $i++){
				if($thumb[$i]['doThumb']){
					$this->resizer($path.'/'.$newName, $path.'/'.$thumb[$i]['dst'].'/'.$newName, $thumb[$i]['w'], $thumb[$i]['h'], $crup);
				}
			}
			return true;
		}else{
			return false;
		}
	}
    
    function url_uploader($path, $file, $name, $thumb, $watermark=false)
    {
        @$rawImage = file_get_contents($file);
        
        if($rawImage) {
            if(file_put_contents($path.'/'.$name, $rawImage) ){
                // waternmark
                if($watermark){
                    $this->addWaterMark($path.'/'.$name, $watermark);
                }
				for($i=0; $i<count($thumb); $i++){
					if($thumb[$i]['doThumb']){
						$this->resizer($path.'/'.$name, $path.'/'.$thumb[$i]['dst'].'/'.$name, $thumb[$i]['w'], $thumb[$i]['h'], 0);
					}
				}
                return true;
            }
        } else {
            return false;
        }
    }

    function creator($path, $imgInfo)
    {
        // $imgInfo = [
        //     "text"=>[], 
        //     "bg"=>"", 
        //     "imgName"=>"", 
        //     "thumb"=>[['doThumb'=>true, 'w'=>400, 'h'=>400, 'dst'=>'thumb']]
        // ];
        return $this->resizer($imgInfo["bg"], 'img/'.$path.'_photos/'.$imgInfo["imgName"], 800, 800, 0, $imgInfo["text"]);
    }
    
	function getPhotosNames()
    {
        $imgs = implode(",",$this->photosname);
        $this->photosname = array();
        return $imgs;
    }
    
	function addWaterMark_img($im, $stamp){

        $copy = getcwd().'/'.$im;// new image holder

        $im_info = getimagesize($im);// image w,h,more
        $stamp_info = getimagesize(getcwd().'/'.$stamp);// stamp w,h,more
        $new_height = ceil($stamp_info[1] * ($im_info[0]/$stamp_info[0]));// get aspect ratio height 

        // change the stamp size to cover the photo 
        $stamp = imagescale(@imagecreatefrompng( getcwd().'/'.$stamp ) , $im_info[0], $new_height);

        $im = $this->createImage($im);

        // centering the stamp
        if($im){
            $centerX=(imagesx($im) - imagesx($stamp)) / 2 ;
            $centerY=(imagesy($im) - imagesy($stamp)) / 2 ;

            imagecopy($im, $stamp, $centerX, $centerY, 0, 0, imagesx($stamp), imagesy($stamp));

            @imagejpeg($im, $copy, 100);
            @imagedestroy($im);
        }else{
            return false;
        }
    }
    
	function addWaterMark($img, $watermark){
        // add water mark or text
        $white = imagecolorallocate( $img, 255, 255, 255);
        $grey  = imagecolorallocate( $img, 128, 128, 128);
        $black = imagecolorallocate( $img, 0, 0, 0);
        $font = getcwd().'/fonts/a-jannat-lt-bold.otf';
        // debug($font);
        $font_size=26;
        // Text TO ARABIC 
        $do = new ArabicGD();
        $text='';
        foreach($watermark as $line){
            if(!empty($line)){
                $text .= $do->arabicText($line, "", 'normal') ."\n";
            }
        }
        // set text in center
        list($x, $y) = $this->ImageTTFCenter($img, $text, $font, $font_size);
        imagettfbbox ( $font_size , 0 , $font , $text );
        imagettftext ($img, $font_size, 0, $x, $y, $white, $font, $text);
        // Add some shadow to the text
        $this->setStroke($img, $font_size, 0, $x, $y, $black, $white , $font, $text, 15);
    }

	function createImage($src)
    {
		$type = strtolower(substr(strrchr($src,"."),1));
		switch($type){
			case 'bmp': $res = @imagecreatefromwbmp($src); break;
			case 'gif': $res = @imagecreatefromgif($src); break;
			case 'jpg': $res = @imagecreatefromjpeg($src); break;
			case 'jpeg': $res = @imagecreatefromjpeg($src); break;
			case 'png': $res = @imagecreatefrompng($src); break;
			default : $res = 'Unsupported type'; 
		}
        return $res;
    }
    
	function resizer($src, $dst, $width, $height, $crop=0, $watermark=false)
    {
		$this->Error_Msg = array();
		if(!list($w, $h) = @getimagesize($src)){
			$this->Error_Msg[] = 'dimensions_error'; 
			return "Unsupported picture type!";
		}
        $img = $this->createImage($src);
        // waternmark
		if($watermark){
            $this->addWatermark($img, $watermark);
        }
		// resize
		if($crop){
			if($w < $width or $h < $height){
				return "Picture is too small!";
				$this->Error_Msg[] = 'picture_small';
			}
			$ratio = max($width/$w, $height/$h);
			$h = $height / $ratio;
			$x = ($w - $width / $ratio) / 2;
			$w = $width / $ratio;
		}else{
			if($w < $width and $h < $height){
				return "Picture is too small!";
				$this->Error_Msg[] = 'picture_small';
			}
			$ratio = min($width/$w, $height/$h);
			$width = $w * $ratio;
			$height = $h * $ratio;
			$x = 0;
		}
		
		$new = @imagecreatetruecolor($width, $height);
		
		$type = strtolower(substr(strrchr($src,"."),1));
		// preserve transparency
		if($type == "gif" or $type == "png"){
			@imagecolortransparent($new, @imagecolorallocatealpha($new, 0, 0, 0, 127));
			@imagealphablending($new, false);
			@imagesavealpha($new, true);
		}
        
        if($img){
            @imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);
        }
        
		switch($type){
			case 'bmp': @imagewbmp($new, $dst); break;
			case 'gif': @imagegif($new, $dst); break;
			case 'jpg': @imagejpeg($new, $dst); break;
			case 'png': @imagepng($new, $dst); break;
		}
		return true;
	}
	
    private function setStroke(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {
        for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
            for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
                $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);
            return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
    }
    
    private function ImageTTFCenter($image, $text, $font, $size, $angle = 45) 
    {
        $xi = imagesx($image);
        $yi = imagesy($image);

        $box = imagettfbbox($size, $angle, $font, $text);

        $xr = abs(max($box[2], $box[4]));
        $yr = abs(max($box[5], $box[7]));

        $x = intval(($xi - $xr) / 2);
        $y = intval(($yi + $yr) / 2);

        return array($x, $y);
    }
    
	function getExt($file)
    {
		$fileext = substr($file['type'],6);
		switch($fileext){
			case 'jpeg':
			case 'jpg':
			$res = 'jpg';
			break;
			
			default:
			$res = $fileext;
			break;
		}
		return $res;
	}
	
	function deleteFile($path, $img)
    {
        if(is_array($img)){
            foreach($img as $file){
                if(is_array( $file )){continue;}            
                @unlink($path.'/'.$file);
                @unlink($path.'/thumb/'.$file);
                @unlink($path.'/middle/'.$file);
            }
            return true;
        }
		@unlink($path.'/'.$img);
		@unlink($path.'/thumb/'.$img);
		@unlink($path.'/middle/'.$img);
        return true;
	}
}
?>