<?php
    class JSminifier extends Functions {
        private $jsCache = array();
        private $fileMin = ASSETS."Cache__NHT__Module__js.min.js";
        private $lock = array(
            'status' => false,
            'char' => ''
        );
        public function __construct($debug){
            $this->debug = $debug;
        }
        public function cacheFile($jsFileCache){
            $this->jsCache[] = $jsFileCache;
        }
        public function minify(){
            $alljs = array();
            if(empty($this->jsCache)) die ("No js was added");
            return $this->compress_js();
        }
        private function compress_js()
        {
            if($this->debug)
            {
                foreach($this->jsCache as $js){
                    $bits = explode(".",$js);
                    $extention = $bits[count($bits)-1];
                    if($extention !== "js") die ("Only js allowed");
                    $file = fopen($js, "r");
                    $fileRead = fread($file, filesize($js));
                    @$compress .= $this->handle_compress($fileRead);  
                    fclose($file);
                }
                if($compress)
                {
                    $handle = fopen($this->fileMin, "w");
                    @$result = fwrite($handle, $compress);
                    fclose($handle);
                }
            }
            $result = "\n".'<script src="'.$this->fileMin.'" type="text/javascript"></script>'."\n";
            return $result;
        }

        private function handle_compress($js)
        {
            $js = preg_replace('/^[\t ]*?\/\/.*\s?/m', '', $js);
            $js = preg_replace('/([\s;})]+)\/\/.*/m', '\\1', $js);
            $js = preg_replace('/\/\*[\s\S]*?\*\//', '', $js);
            $js = preg_replace('/^\s*/m', '', $js);
            $js = preg_replace('/\t+/m', ' ', $js);
            $js = preg_replace('/[\r\n]+/', '', $js);
            $js_substrings = preg_split('/([\'"])/', $js, -1, PREG_SPLIT_DELIM_CAPTURE);
            $js = '';
            foreach($js_substrings as $substring)
            {
                if($substring === '\'' or $substring === '"')
                {
                    if($this->lock['status'] === false)
                    {
                        $this->lock['status'] = true;
                        $this->lock['char'] = $substring;
                    }
                    else
                    {
                        if($substring === $this->lock['char'])
                        {
                            $this->lock['status'] = false;
                            $this->lock['char'] = '';
                        }
                    }
                    $js .= $substring;
                    continue;
                }
                if($this->lock['status'] === false)
                {
                    $substring = str_replace(';}', '}', $substring);
                    $substring = preg_replace('/ *([<>=+\-!\|{(},;&:?]+) */', '\\1', $substring);
                }
                $js .= $substring;
            }
            return trim($js);
        }
    }
?>