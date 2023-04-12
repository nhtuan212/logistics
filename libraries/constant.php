<?php
	if(!@defined('LIB')) die("Error");

	/* Array folders */
	$upload_const = 'upload';
	$array_const = array('product', 'post', 'photo', 'file', 'gallery', 'user', 'temp', 'elfinder');

	/* Define - Create folders upload */
	if(!file_exists(ROOT.'/../'.$upload_const))
	{
		mkdir(ROOT.'/../'.$upload_const, 0777, true);
		chmod(ROOT.'/../'.$upload_const, 0777);
	}

	/* Define - Create folders childs */
	if(file_exists(ROOT.'/../'.$upload_const) && $array_const)
	{
		$path_htaccess = ROOT.'/../'.$upload_const.'/.htaccess';
		if(!file_exists($path_htaccess))
		{
			$content_htaccess = '';
			$content_htaccess .= '<Files ~ "\.(inc|sql|php|cgi|pl|php4|php5|asp|aspx|jsp|txt|kid|cbg|nok|shtml)$">'.PHP_EOL;
			$content_htaccess .= 'order allow,deny'.PHP_EOL;
			$content_htaccess .= 'deny from all'.PHP_EOL;
			$content_htaccess .= '</Files>';

			$file_htaccess = fopen($path_htaccess, "w") or die("Unable to open file");
			fwrite($file_htaccess, $content_htaccess);
			fclose($file_htaccess);
		}

		foreach($array_const as $vconst)
		{
			$define_upper_upload = strtoupper($upload_const);
			$define_upper_const = strtoupper($vconst);
			$define_lower_const = $vconst;
			$define_in = '../'.$upload_const.'/'.$define_lower_const.'/';
			$define_out = $upload_const.'/'.$define_lower_const.'/';
			if(!@defined($define_upper_upload.'_'.$define_upper_const) && !@defined($define_upper_upload.'_'.$define_upper_const.'_L'))
			{
				@define($define_upper_upload.'_'.$define_upper_const, $define_in);
				@define($define_upper_upload.'_'.$define_upper_const.'_L', $define_out);

				if(!file_exists(ROOT.'/../'.$upload_const.'/'.$define_lower_const))
				{
					mkdir(ROOT.'/../'.$upload_const.'/'.$define_lower_const, 0777, true);
					chmod(ROOT.'/../'.$upload_const.'/'.$define_lower_const, 0777);
				}
			}
		}
	}

    @define ( "CACHE" , 'upload/cache/');
    @define ( "WATERMARK" , 'upload/watermark/');
	
	@define ( "FORMAT_IMAGE" , "<strong>jpg | png | jpeg | gif | JPG | PNG | JPEG | GIF</strong>");
	@define ( "FORMAT_DOCUMENT" , "<strong>doc | xls | ppt | pdf | rar | win | zip | docx | pptx | xlsx | DOC | XLS | PPT | PDF | RAR | WIN | ZIP | DOCX | PPTX | XLSX</strong>");
?>