<?php
	class CreateThumb
	{
		public function createThumbCache($width_thumb=0, $height_thumb=0, $zoom_crop='1', $src='', $watermark=null, $path=CACHE, $preview=false, $args=array(), $quality=100)
		{
			$t = 3600*24*1;
			$this->RemoveFilesFromDirInXSeconds(UPLOAD_TEMP_L, 1);
			if($watermark)
			{
				$this->RemoveFilesFromDirInXSeconds(WATERMARK.$path, $t);
				$this->RemoveEmptySubFolders(WATERMARK.$path);
			}
			else
			{
				$this->RemoveFilesFromDirInXSeconds($path, $t);
				$this->RemoveEmptySubFolders($path);
			}

			$src = str_replace("%20"," ",$src);
			if(!file_exists($src)) die("NO IMAGE $src");

			$image_url = $src;
			$origin_x = 0;
			$origin_y = 0;
			$new_width = $width_thumb;
			$new_height = $height_thumb;

			if($new_width < 12 && $new_height < 12 )
			{
				header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
				die("Width and height larger than 32px");
			}
			if($new_width > 2000 || $new_height > 2000)
			{
				header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
				die("Width and height less than 2000px");
			}

			$array = getimagesize($image_url);
			if($array) list($image_w, $image_h) = $array;
			else die("NO IMAGE $image_url");

			$width = $image_w;
			$height = $image_h;

			if($new_height && !$new_width) $new_width = $width * ($new_height / $height);
			else if($new_width && !$new_height) $new_height = $height * ($new_width / $width);

			$image_ext = explode('.', $image_url);
			$image_ext = trim(strtolower(end($image_ext)));
			$image_name = explode('/', $image_url);
			$image_name = trim(strtolower(end($image_name)));

			switch(strtoupper($image_ext))
			{
				case 'JPG':
				case 'JPEG':
				$image = imagecreatefromjpeg($image_url);
				$func='imagejpeg';
				$mime_type = 'jpeg';
				break;

				case 'PNG':
				$image = imagecreatefrompng($image_url);
				$func='imagepng';
				$mime_type = 'png';
				break;

				case 'GIF':
				$image = imagecreatefromgif($image_url);
				$func='imagegif';
				$mime_type = 'png';
				break;

				default: die("UNKNOWN IMAGE TYPE: $image_url");
			}

			if($zoom_crop == 3)
			{
				$final_height = $height * ($new_width / $width);
				if($final_height > $new_height) $new_width = $width * ($new_height / $height);
				else $new_height = $final_height;
			}

			$canvas = imagecreatetruecolor($new_width, $new_height);
			imagealphablending($canvas, false);
			$color = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
			imagefill ($canvas, 0, 0, $color);

			if($zoom_crop == 2)
			{
				$final_height = $height * ($new_width / $width);
				if($final_height > $new_height)
				{
					$origin_x = $new_width / 2;
					$new_width = $width * ($new_height / $height);
					$origin_x = round($origin_x - ($new_width / 2));
				}
				else
				{
					$origin_y = $new_height / 2;
					$new_height = $final_height;
					$origin_y = round($origin_y - ($new_height / 2));
				}
			}

			imagesavealpha($canvas, true);

			if($zoom_crop > 0)
			{
				$align = '';
				$src_x = $src_y = 0;
				$src_w = $width;
				$src_h = $height;

				$cmp_x = $width / $new_width;
				$cmp_y = $height / $new_height;

				if($cmp_x > $cmp_y)
				{
					$src_w = round($width / $cmp_x * $cmp_y);
					$src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
				}
				else if($cmp_y > $cmp_x)
				{
					$src_h = round($height / $cmp_y * $cmp_x);
					$src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
				}

				if($align)
				{
					if(strpos($align, 't') !== false)
					{
						$src_y = 0;
					}
					if(strpos($align, 'b') !== false)
					{
						$src_y = $height - $src_h;
					}
					if(strpos($align, 'l') !== false)
					{
						$src_x = 0;
					}
					if(strpos($align, 'r') !== false)
					{
						$src_x = $width - $src_w;
					}
				}

				imagecopyresampled($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
			}
			else
			{
				imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			}

			if($preview)
			{
				$watermark = array();
				$watermark['status'] = 'display';
				$options = $args;
				$overlay_url = $args['watermark'];
			}

			$upload_dir = '';
			$folder_old = dirname($image_url)."/";

			if($watermark['status'])
			{
				$upload_dir = WATERMARK.$path.'/'.$width_thumb.'x'.$height_thumb.'x'.$zoom_crop.'/'.$folder_old;
			}
			else
			{
				if($watermark) $upload_dir = WATERMARK.$path.'/'.$width_thumb.'x'.$height_thumb.'x'.$zoom_crop.'/'.$folder_old;
				else $upload_dir = $path.'/'.$width_thumb.'x'.$height_thumb.'x'.$zoom_crop.'/'.$folder_old;
			}

			if(!file_exists($upload_dir)) if(!mkdir($upload_dir, 0777, true)) die('Failed to create folders...');

			if($watermark['status'])
			{
				$options = (isset($options))?$options:json_decode($watermark['options'],true)['watermark'];
				$per_scale = $options['per'];
				$per_small_scale = $options['small_per'];
				$max_width_w = $options['max'];
				$min_width_w = $options['min'];
				$opacity = @$options['opacity'];
				$overlay_url = (isset($overlay_url))?$overlay_url:UPLOAD_PHOTO_L.$watermark['photo'];
				$overlay_ext = explode('.', $overlay_url);
				$overlay_ext = trim(strtolower(end($overlay_ext)));

				switch(strtoupper($overlay_ext))
				{
					case 'JPG':
					case 'JPEG':
					$overlay_image = imagecreatefromjpeg($overlay_url);
					break;

					case 'PNG':
					$overlay_image = imagecreatefrompng($overlay_url);
					break;

					case 'GIF':
					$overlay_image = imagecreatefromgif($overlay_url);
					break;

					default: die("UNKNOWN IMAGE TYPE: $overlay_url");
				}

				$this->filterOpacity($overlay_image,$opacity);
				$overlay_width = imagesx($overlay_image);
				$overlay_height = imagesy($overlay_image);
				$overlay_padding = 5;				
				imagealphablending($canvas, true);

				if(min($new_width,$new_height) <= 300) $per_scale = $per_small_scale;

				$oz = max($overlay_width,$overlay_height);				

				if($overlay_width > $overlay_height)
				{
					$scale = $new_width/$oz;
				}
				else
				{
					$scale = $new_height/$oz;
				}

				if($new_height > $new_width)
				{
					$scale = $new_height/$oz;
				}

				$new_overlay_width = (floor($overlay_width*$scale) - $overlay_padding*2)/$per_scale;
				$new_overlay_height = (floor($overlay_height*$scale) - $overlay_padding*2)/$per_scale;
				$scale_w = $new_overlay_width/$new_overlay_height;
				$scale_h = $new_overlay_height/$new_overlay_width;
				$new_overlay_height = $new_overlay_width/$scale_w;

				if($new_overlay_height > $new_height)
				{
					$new_overlay_height = $new_height / $per_scale;
					$new_overlay_width = $new_overlay_height * $scale_w;
				}
				if($new_overlay_width > $new_width)
				{
					$new_overlay_width = $new_width/$per_scale;
					$new_overlay_height = $new_overlay_width * $scale_h;
				}
				if(($new_width / $new_overlay_width) < $per_scale)
				{
					$new_overlay_width = $new_width/$per_scale;
					$new_overlay_height = $new_overlay_width * $scale_h;
				}
				if($new_height < $new_width && ($new_height / $new_overlay_height) < $per_scale)
				{
					$new_overlay_height = $new_height/$per_scale;
					$new_overlay_width = $new_overlay_height / $scale_h;
				}
				if($new_overlay_width > $max_width_w && $new_overlay_width)
				{
					$new_overlay_width = $max_width_w;
					$new_overlay_height = $new_overlay_width * $scale_h;
				}
				if($new_overlay_width < $min_width_w && $new_width <= $min_width_w*3)
				{
					$new_overlay_width = $min_width_w;	
					$new_overlay_height = $new_overlay_width * $scale_h;
				}
				$new_overlay_width = round($new_overlay_width);
				$new_overlay_height = round($new_overlay_height);

				switch($options['position'])
				{
					case 1:
					$khoancachx = $overlay_padding;
					$khoancachy = $overlay_padding;
					break;

					case 2:
					$khoancachx = abs($new_width - $new_overlay_width)/2;
					$khoancachy = $overlay_padding;
					break;

					case 3:
					$khoancachx = abs($new_width - $new_overlay_width) - $overlay_padding;
					$khoancachy = $overlay_padding;
					break;

					case 4:
					$khoancachx = $overlay_padding;
					$khoancachy = abs($new_height - $new_overlay_height)/2;
					break;

					case 5:
					$khoancachx = abs($new_width - $new_overlay_width)/2;
					$khoancachy = abs($new_height - $new_overlay_height)/2;
					break;

					case 6:
					$khoancachx = abs($new_width - $new_overlay_width) - $overlay_padding;
					$khoancachy = abs($new_height - $new_overlay_height)/2;
					break;

					case 8:
					$khoancachx = abs($new_width - $new_overlay_width)/2;
					$khoancachy = abs($new_height - $new_overlay_height) - $overlay_padding;
					break;

					case 7:
					$khoancachx = $overlay_padding;
					$khoancachy = abs($new_height - $new_overlay_height) - $overlay_padding;
					break;

					case 9:
					$khoancachx = abs($new_width - $new_overlay_width) - $overlay_padding;
					$khoancachy = abs($new_height - $new_overlay_height) - $overlay_padding;
					break;

					default:
					$khoancachx = $overlay_padding;
					$khoancachy = $overlay_padding;
					break;
				}

				$overlay_new_image = imagecreatetruecolor($new_overlay_width, $new_overlay_height);
				imagealphablending($overlay_new_image, false);
				imagesavealpha($overlay_new_image, true);
				imagecopyresampled($overlay_new_image, $overlay_image, 0, 0, 0, 0, $new_overlay_width, $new_overlay_height, $overlay_width, $overlay_height);
				imagecopy($canvas, $overlay_new_image, $khoancachx, $khoancachy, 0, 0, $new_overlay_width, $new_overlay_height);
				imagealphablending($canvas, false);
				imagesavealpha($canvas, true);
			}

			if($preview)
			{
				$upload_dir = '';
				$this->RemoveEmptySubFolders(WATERMARK.$path);
			}

			if($upload_dir)
			{
				if($func == 'imagejpeg') $func($canvas, $upload_dir.$image_name,100);
				else $func($canvas, $upload_dir.$image_name,floor($quality * 0.09));	
			}

			header('Content-Type: image/' . $mime_type);
			if($func=='imagejpeg') $func($canvas, NULL,100);
			else $func($canvas, NULL,floor($quality * 0.09));

			imagedestroy($canvas);
		}

		public function RemoveFilesFromDirInXSeconds($dir='', $seconds=3600)
		{
		    $files = glob(rtrim($dir, '/')."/*");
		    $now = time();

		    if($files)
		    {
			    foreach($files as $file)
			    {
			        if(is_file($file))
			        {
			            if($now - filemtime($file) >= $seconds)
			            {
			                unlink($file);
			            }
			        }
			        else
			        {
			            $this->RemoveFilesFromDirInXSeconds($file,$seconds);
			        }
			    }
		    }
		}
		public function RemoveEmptySubFolders($path='')
		{
			$empty = true;

			foreach(glob($path.DIRECTORY_SEPARATOR."*") as $file)
			{
				if(is_dir($file))
				{
					if(!$this->RemoveEmptySubFolders($file)) $empty = false;
				}
				else
				{
					$empty = false;
				}
			}

			if($empty)
			{
				if(is_dir($path))
				{
					rmdir($path);
				}
			}

			return $empty;
		}
		public function filterOpacity($img='', $opacity=80)
		{
			return true;
			/*
			if(!isset($opacity) || $img == '') return false;

			$opacity /= 100;
			$w = imagesx($img);
			$h = imagesy($img);
			imagealphablending($img, false);
			$minalpha = 127;

			for($x = 0; $x < $w; $x++)
			{
				for($y = 0; $y < $h; $y++)
				{
					$alpha = (imagecolorat($img, $x, $y) >> 24) & 0xFF;
					if($alpha < $minalpha) $minalpha = $alpha;
				}
			}

			for($x = 0; $x < $w; $x++)
			{
				for($y = 0; $y < $h; $y++)
				{
					$colorxy = imagecolorat($img, $x, $y);
					$alpha = ($colorxy >> 24) & 0xFF;
					if($minalpha !== 127) $alpha = 127 + 127 * $opacity * ($alpha - 127) / (127 - $minalpha);
					else $alpha += 127 * $opacity;
					$alphacolorxy = imagecolorallocatealpha($img, ($colorxy >> 16) & 0xFF, ($colorxy >> 8) & 0xFF, $colorxy & 0xFF, $alpha);
					if(!imagesetpixel($img, $x, $y, $alphacolorxy)) return false;
				}
			}

			return true;
			*/
		}
	}	
?>