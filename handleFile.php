<?php

class handlefile {
	
	public $file, $fileMime, $fileSize, $sizeFormat, $isAnimate;
	
	public function getFile($file) {
		
		if (file_exists($file)) {
			
			$this->file = stripslashes(trim($file));			
			return $this->file;
		
		} else {
			return false;
		}
	}
	
	public function size($format='k', $round=0) {
		$size = filesize($this->file);
		if ($format == 'k') $size = $size / 1024;
		if ($format == 'm') $size = $size / (1024*1024);
		if ($format == 'g') $size = $size / (1024*1024*1024);
		$size = round($size, $round);
		$this->fileSize = $size;
		$this->sizeFormat = $format;
		return $this->fileSize;
	}
	
	function mime($filename){
		$mimeLists = array('image/png' => 'png',
							'image/jpeg' => 'jpeg',
							'image/jpeg' => 'jpg',
							'image/gif' => 'gif',
							'image/bmp' => 'bmp',
							'image/x-ms-bmp' => 'bmp',
							'image/vnd.microsoft.icon' => 'ico',
							'image/x-icon' => 'ico',
							'image/webp' => 'webp',
							
							'application/zip' => 'zip',
							'application/x-rar-compressed' => 'rar',
							'application/x-rar' => 'rar',
							
							'application/x-shockwave-flash' => 'swf',
							'video/x-flv' => 'flv',
							'audio/mpeg' => 'mp3',
							'application/octet-stream' => 'mp3',
							'audio/flac' => 'flac',
							'audio/ogg' => 'ogg',
							'video/mp4' => 'mp4',
							'video/x-matroska' => 'mkv',
							'video/webm' => 'webm',
							
							'application/pdf' => 'pdf',
							'image/vnd.adobe.photoshop' => 'psd',
							'application/postscript' => 'ai',
							'application/postscript' => 'eps',
							'application/postscript' => 'ps',
							
							'application/msword' => 'doc',
							'application/msword' => 'docx',
							'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
							'application/vnd.ms-excel' => 'xls',
							'application/vnd.ms-excel' => 'xlsx',
							'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
							'application/vnd.ms-powerpoint' => 'ppt',
							'application/vnd.ms-powerpoint' => 'pptx',
							'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
							'application/rtf' => 'rtf',
							
							'application/jar' => 'app',
							'application/vnd.android.package-archive' => 'apk',
							
							//add as much as you want !
							
							);
	
		if (function_exists('finfo_open')) {

			$fileInfo = finfo_open(FILEINFO_MIME);
			$mimeType = finfo_file($fileInfo, $this->file);
			finfo_close($finfo);
			$explodeMime = explode(";", $mimeType);
			$mimeType = $explodeMime[0];
			if (isset($mimeLists[$mimeType])) {
				$this->fileMime = $mimeLists[$mimeType];
				return $this->fileMime;
			} else {
				return false;
			}

		} elseif(function_exists('mime_content_type')){

			$mimeType = mime_content_type($this->file);
			if (isset($mimeLists[$mimeType])) {
				$this->fileMime = $mimeLists[$mimeType];
				return $this->fileMime;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}
	
	function isAnimate() {
		$fileContents = file_get_contents($this->file);
		$stringLocation = 0;
		$count = 0;
		while ($count < 2) { //There is no point in continuing after 2nd frame
			$where1 = strpos($fileContents, "\x00\x21\xF9\x04", $stringLocation);
			if ($where1 === FALSE) break;
			else {
				$stringLocation = $where1 + 1;
				$where2 = strpos($fileContents, "\x00\x2C", $stringLocation);
				if ($where2 === FALSE) break;
				else {
					if ($where1 + 8 == $where2) $count++;
					$stringLocation = $where2 + 1;
				}
			}
		}
		
		if ($count > 1) {
			$this->isAnimate = true;
			return $this->isAnimate;
		} else {
			return false;
		}
	}
	
	function upload($locat, $newName='') {
		if ($newName == '') $newName = uniqid();
		if ($this->fileMime != false) {
			$fileName = $newName . '.' . $this->fileMime;
			$newPath = $locat . $fileName;
			$copied = copy($this->file, $newPath);
			if ($copied) {
				$this->file = $newPath;
				return $this->file;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function resize($newWidth, $copySuffix='', $compress=90) {
		
		if ($newWidth < 1) {
			return false;
		
		} elseif ($this->fileMime != 'jpg' && $this->fileMime != 'jpeg' && $this->fileMime != 'png' && $this->fileMime != 'gif') {
			return false;
		
		} elseif ($this->fileMime == 'gif' and $this->isAnimate == true) {
			//If you need to resize an animate gif, add resizeGIF function here and remove line blow.
			return false;
		
		} else {
			
			switch($this->fileMime) {
				case('jpg'): $creation = imagecreatefromjpeg($this->file); break;
				case('jpeg'): $creation = imagecreatefromjpeg($this->file); break;
				case('png'): $creation = imagecreatefrompng($this->file); break;
				case('gif'): $creation = imagecreatefromgif($this->file); break;
			}
			
			$width = imagesx($creation);
			$height = imagesy($creation);
			$newHeight = floor($height*($newWidth/$width));
			
			$virtual = imagecreatetruecolor($newWidth, $newHeight);
			
			if ($this->fileMime == 'png') {
				imagealphablending($virtual, false);
                imagesavealpha($virtual,true);
                $transparency = imagecolorallocatealpha($virtual, 255, 255, 255, 127);
                imagefilledrectangle($virtual, 0, 0, $newWidth, $newHeight, $transparency);
            }
            
            imagecopyresized($virtual, $creation, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			
			if ($copySuffix == '') {
				unlink($this->file);
			
			} else {
			
				$explodePath = explode("/", $this->file);
				$explodeName = explode(".", end($explodePath));
				$explodeMime = end($explodeName);
				
				array_pop($explodePath);
				array_pop($explodeName);
				
				$newPath = implode("/", $explodePath);
				$newPath .= implode("/", $explodeName);
				$newPath .= $copySuffix . '.' . $explodeMime;
				
				$this->file = $newPath;
			}
        
            switch($fileExtension) {
                case('jpg'): imagejpeg($virtual, $this->file, $compress); break;
                case('jpeg'): imagejpeg($virtual, $this->file, $compress); break;
                case('png'): imagepng($virtual, $this->file, round($compress/10)); break;
                case('gif'): imagegif($virtual, $this->file); break;
            }
			
			return $this->file;
		}
	}
	
	function watermark($watermark, $sizeRate=30, $compress=90, $positionX='left', $positionY='bottom') {
		
		if (!file_exists($watermark)) {
			return false;
		
		} else {
			
			$watermarkMime = mime($watermark);
			
			if ($watermarkMime != 'jpg' && $watermarkMime == 'jpeg' && $watermarkMime == 'png' && $watermarkMime == 'gif') {
                return false;
			
			} elseif ($this->fileMime == 'gif' and $this->isAnimate == true) {
				//If you need to watermark an animate gif, add watermarkGIF function here and remove line blow.
				return false;
			
			} else {
				
				switch($fileExtension) {
					case('jpg'): $creation = imagecreatefromjpeg($this->file); break;
                    case('jpeg'): $creation = imagecreatefromjpeg($this->file); break;
                    case('png'): $creation = imagecreatefrompng($this->file); break;
                    case('gif'): $creation = imagecreatefromgif($this->file); break;
				}
				
				switch($watermarkMime) {
					case('jpg'): $creationWM = imagecreatefromjpeg($watermark); break;
					case('jpeg'): $creationWM = imagecreatefromjpeg($watermark); break;
					case('png'): $creationWM = imagecreatefrompng($watermark); break;
					case('gif'): $creationWM = imagecreatefromgif($watermark); break;
				}
				
				imagealphablending($creation, true);
				imagesavealpha($creation, true);
				
				$fileWidth = imagesx($creation);
				$fileHeight = imagesy($creation);
				
				$watermarkWidth = imagesx($creationWM);
				$watermarkHeight = imagesy($creationWM);
				
				$watermarkNewWidth = floor($fileWidth * ($sizeRate / 100));
				$watermarkNewHeight = floor($watermarkHeight*($watermarkNewWidth/$watermarkWidth));
				
				if ($positionX == 'left') $Xpos = 0;
				else $Xpos = $fileWidth - $watermarkNewWidth;
				
				if ($positionY == 'top') $Ypos = 0;
				else $Ypos = $fileHeight - $watermarkNewHeight;
				
				imagecopyresized($creation, $creationWM, $Xpos, $Ypos, 0, 0, $watermarkNewWidth, $watermarkNewHeight, $watermarkWidth, $watermarkHeight);
				
				switch($this->fileMime) {
					case('jpg'): imagejpeg($creation, $this->file, $compress); break;
					case('jpeg'): imagejpeg($creation, $this->file, $compress); break;
					case('png'): imagepng($creation, $this->file, round($compress/10)); break;
					case('gif'): imagegif($creation, $this->file); break;
				}
				
				return $this->file; 
			}
		}
	}
	
	function crop($targetWidth, $targetHeight, $from='center'){
		
		if ($$targetWidth < 1 || $targetHeight < 1) {
			return false;
		
		} elseif ($this->fileMime != 'jpg' && $this->fileMime != 'jpeg' && $this->fileMime != 'png' && $this->fileMime != 'gif') {
			return false;
		
		} elseif ($this->fileMime == 'gif' and $this->isAnimate == true) {
			//If you need to crop an animate gif, add cropGIF function here and remove line blow.
			return false;
				
		} else {
			
			switch($this->fileMime) {
				case('jpg'): $creation = imagecreatefromjpeg($this->file); break;
                case('jpeg'): $creation = imagecreatefromjpeg($this->file); break;
                case('png'): $creation = imagecreatefrompng($this->file); break;
                case('gif'): $creation = imagecreatefromgif($this->file); break;
			}
			
			$width = imagesx($creation);
			$height = imagesy($creation);
			
			if ($width <= $height) {
				
				$newWidth = $targetWidth;
				$newHeight = floor($height*($targetWidth/$width));
				
				switch($from) {
					case('topleft'): $PosX = 0; $PosY = 0; break;
					case('topright'): $PosX = floor($new_width - $target_width); $PosY = 0; break;
					case('bottomleft'): $PosX = 0; $PosY = floor($newHeight - $targetHeight); break;
					case('bottomright'): $PosX = floor($new_width - $target_width); $PosY = floor($newHeight - $targetHeight); break;
					default: $PosX = 0; $PosY = floor(($newHeight - $targetHeight)/2);; break;
				}
				
			} else {
				$newWidth = floor($width*($targetHeight/$height));
				$newHeight = $targetHeight;
				
				switch($from) {
					case('topleft'): $PosX = 0; $PosY = 0; break;
					case('topright'): $PosX = floor($new_width - $target_width); $PosY = 0; break;
					case('bottomleft'): $PosX = 0; $PosY = floor($newHeight - $targetHeight); break;
					case('bottomright'): $PosX = floor($new_width - $target_width); $PosY = floor($newHeight - $targetHeight); break;
					default: $PosX = floor(($new_width - $target_width)/2); $PosY = 0; break;
				}
			}
			
			$virtual = imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresized($virtual, $creation, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			$option = ['x' => $PosX, 'y' => $PosY, 'width' => $targetWidth, 'height' => $targetHeight];
			$virtual = imagecrop($virtual, $option);
			imagejpeg($virtual, $image, 100);
		}
	}
}

?>