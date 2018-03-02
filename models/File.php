<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property string $files
 * @property string $url
 * @property string $imagesize
 *
 * @property Announced $announced
 */
class File extends \yii\base\Model
{
    
    public $file;
    public $files;
    public $url;
    public $imagesize;
    public $type;
    public $size;
    public $duration;
    public $name;
    
    public function scenarios() {
        $scenarios = parent::scenarios();
//        $scenarios['album'] = ['image'];
        return $scenarios;
    }
    
    public static function getFiles($path){
        $path = Yii::getAlias($path);

        $dh  = opendir($path);
        while (false !== ($filename = readdir($dh))) {
            if(!in_array($filename, ['.', '..'])){
                $files[$filename] = $filename;
            }
        }
        return $files;
    }
    
    public function upload($path = ''){
        
        
        if($this->files){
            $name_video = time();
            $extension = 'jpg';
            
            foreach ($this->files as $key => $value) {
                if($key == 'src'){
                    $name_video = preg_replace("/^(.*)\.[\d\w]{3}$/", "$1", $value->name);
                    
                    $this->url = $value->name;
                    if(!$value->saveAs($path . $value->name)){return false;};
                }else{
                    $extension = preg_replace("/^.*\.([\d\w]{3})$/", "$1", $value->name);
                    
                    if(!$value->saveAs($path . "{$name_video}.{$extension}")){ return false;};
                }
            }
        }elseif($this->file){
            $extension = preg_replace("/^.*(\.[\d\w]{3})$/", "$1", $this->file->name);
            
            $extension = ($extension == 'blob') ? '.jpg' : $extension;
            
            $user_id = Yii::$app->user->id;
            $name = hash('ripemd160', $user_id.$this->file->name.time()).$extension;

            if(!$this->file->saveAs($path . $name)){
                return false;
            }
            
            $this->url = $name;
//            list($width, $height, $type, $attr) = getimagesize($path . $this->url);
         }
        return true;
    }
    
    
    
    public function uploadCanvas($path = ''){
        
       if($this->file){
            $extension = preg_replace("/^.*\/(.*)$/", "$1", $this->file->type);
            
            $rand = rand(5, 15);
            $name = hash('ripemd160', $rand.$this->file->name.time()).".$extension";

            if(!$this->file->saveAs($path . $name)){
                return false;
            }
            
            $this->url = $name;
         }
        return true;
    }
    
    
    public static function addWatermark($pathWatermark, $pathImage, $name, $delete = true){
        $pathWatermark = Yii::getAlias($pathWatermark);
        list($widthW, $heightW) = getimagesize($pathWatermark);
        
        $result = Yii::getAlias("@webroot/images/watermark/{$name}");
        
        $pathImage = Yii::getAlias($pathImage);
       
        $newImage = \yii\imagine\Image::getImagine()
                ->open($pathImage)
                ->thumbnail(new \Imagine\Image\Box(550, 700));
        
        $newImage->save($result, ['quality' => 80]);

        list($widthImg, $heightImg) = getimagesize($result);

        $newImage = \yii\imagine\Image::watermark($result, $pathWatermark, [10, ($heightImg-$heightW-45)]);
        $newImage->save($result);

        if($delete){
            rename($result, $pathImage);
        }
        return TRUE;
    }
    
    function delFolder($dir){
        $files = array_diff(scandir($dir), array('.','..'));
        
        foreach ($files as $file) {
            if(is_dir("$dir/$file")){
                delFolder("$dir/$file");
            }else{
                (is_writable("$dir/$file")) ? unlink("$dir/$file") : null;
            }
        }
        
        $files = array_diff(scandir($dir), array('.','..'));

        return empty($files) ? rmdir($dir) : false;
    }
    
    
    
    
    public static function download($url, $out, $path){
	$command = "wget --tries=3 -O '".$path."/".$out."' '".$url."' 2>&1";
	
	$output = shell_exec($command);
        
	if($output != null){
		preg_match('|\:\s+(\d*)\s+\(.*?\)|si', $output, $matches);
		
		if(!empty($matches[1])){
			if(file_exists($path."/".$out)){
				$size1 = (int)$matches[1];
				$size2 = (int)filesize($path."/".$out);
				
				if($size1 !== $size2){
					unlink($path."/".$out);
					
					return false;
				}
				
				return true;
			}
		}
	}
	
	return false;
    }

    public static  function saveImg($url, $folder, $name){
//            vd($url);
//            $name = 'img_'.md5(microtime() . rand(999, 99999)).'.jpg';

            $i = 0;

            if(self::download($url, $name, $folder)){
                return $name;
            }

            if($i < 1){
                $i++;
                
                usleep(500);
                return self::saveImg($url, $folder);
            }
    }
    
    public static function GetImageFromUrl($link) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    public static function savefile($pathImg, $url){
        $sourcecode = self::GetImageFromUrl($url);
        
        $savefile = fopen($pathImg, 'w');
        fwrite($savefile, $sourcecode);
        fclose($savefile);
        return true;
    }

}
