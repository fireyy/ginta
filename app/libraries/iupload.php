<?php

class Iupload{
  
  public static function upload($file) {
  		$storage = PATH . DS . 'public' . DS . 'content' . DS;

  		if(!is_dir($storage)) mkdir($storage);

  		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

  		// Added rtrim to remove file extension before adding again
  		$filename = slug(rtrim(time(), '.' . $ext)) . '.' . $ext;
  		$filepath = $storage . $filename;

  		if(move_uploaded_file($file['tmp_name'], $filepath)) {
  			return $filepath;
  		}

  		return false;
  	}

  	public static function process_image($file) {
  		if($file and $file['error'] === UPLOAD_ERR_OK) {
  			$name = basename($file['name']);
  			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);

  			if($filepath = static::upload($file)) {
  				$filename = basename($filepath);

  				// thumb
					$image = Image::open($filepath);

					$width = intval(250);
					$height = intval(140);
          
          $thumb = str_replace(".".$ext,"_thumb.".$ext,$filepath);
          $thumb_name = basename($thumb);

					// resize larger images
					if(
						($width and $height) and
						($image->width() > $width or $image->height() > $height)
					) {
						$image->resizeCrop($width, $height, 0, 0);

						$image->output($ext, $thumb);
					}

  				return compact('name', 'filename', 'thumb_name');
  			}else{
  			  return array("error" => 1);
  			}
  		}
  	}
}