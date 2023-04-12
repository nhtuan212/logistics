<?php
    class CSSminifier extends Functions {
        private $cssCache = array();
        private $fileMin = ASSETS."Cache__NHT__Module__css.min.css";
        public function __construct($debug){
            $this->debug = $debug;
        }
        public function cacheFile($cssFilePath){
            $this->cssCache[] = $cssFilePath;
        }
        public function minify(){
            $allCss = array();
            if(empty($this->cssCache)) die ("No CSS was added");
            return $this->compress_css();
        }
        private function compress_css()
        {
            if($this->debug)
            {
                foreach($this->cssCache as $css){
                    $bits = explode(".",$css);
                    $extention = $bits[count($bits)-1];
                    if($extention !== "css") die ("Only CSS allowed");
                    $file = fopen($css, "r");
                    $file = $this->remove_spaces(fread($file, filesize($css)));
                    $file = $this->remove_css_comments($file);
                    @$result .= $file;
                }
				if (!file_exists($this->fileMin)) { 
					die('File does not exist');
				}
                $handle = fopen($this->fileMin, "w");
                $result = fwrite($handle, $result);
                return $this->default_css();
            }
            $result = "\n".'<link href="'.$this->fileMin.'" type="text/css" rel="stylesheet" />'."\n";
            return $result;
        }
        private function default_css()
        {
            foreach($this->cssCache as $css){
                @$result .= "\n".'<link href="'.$css.'?'.$this->random(12).'" type="text/css" rel="stylesheet"/>';
            }
            return $result;
        }
        private function remove_spaces($string){
            $string = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $string);
            $string = str_replace("\n", "", $string);
            $string = str_replace('@CHARSET "UTF-8";', "", $string);
            $string = str_replace(': ', ':', $string);
            $string = str_replace(', ', ",", $string);
            $string = str_replace("../../assets/images", "images", $string);
            $string = str_replace('webfonts', "../".LIB."fontawesome5.12.1/webfonts", $string);
            $string = str_replace("url('fonts/", "url('css/fonts/", $string);
            $string = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $string);
            return $string;
        }
        private function remove_css_comments($css){
            $file = preg_replace("/(\/\*[\w\'\s\r\n\*\+\,\"\-\.]*\*\/)/", "", $css);
            return $file;
        }
    }
?>