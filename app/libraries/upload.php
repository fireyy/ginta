<?php

class Upload{

  public function __construct() {
    //
  }
  
  public static function upload($file) {
  		$storage = APP . 'storage' . DS . 'uploads' . DS;

  		if(!is_dir($storage)) mkdir($storage);

  		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

  		// Added rtrim to remove file extension before adding again
  		$filename = slug(rtrim($file['name'], '.' . $ext)) . '.' . $ext;
  		$filepath = $storage . $filename;

  		if(move_uploaded_file($file['tmp_name'], $filepath)) {
  			return $filepath;
  		}

  		return false;
  	}

  	public static function process_image($extend) {
  		$file = Arr::get(static::files(), $extend->key);

  		if($file and $file['error'] === UPLOAD_ERR_OK) {
  			$name = basename($file['name']);
  			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

  			if($filepath = static::upload($file)) {
  				$filename = basename($filepath);

  				// thumb
  				if(isset($extend->attributes->size->width) and isset($extend->attributes->size->height)) {
  					$image = Image::open($filepath);

  					$width = intval($extend->attributes->size->width);
  					$height = intval($extend->attributes->size->height);

  					// resize larger images
  					if(
  						($width and $height) and
  						($image->width() > $width or $image->height() > $height)
  					) {
  						$image->resize($width, $height);

  						$image->output($ext, $filepath);
  					}
  				}

  				return Json::encode(compact('name', 'filename'));
  			}
  		}
  	}
}