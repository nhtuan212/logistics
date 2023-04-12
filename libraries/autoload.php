<?php
    class autoload {
        private $dir = 'libraries';
        private $class = 'class';
        private $file = 'Include';
        private $extension = 'php';
        public function __construct()
        {
            spl_autoload_register(array($this,'_autoload'));
        }
        private function _autoload($file){
            $file = LIB.$this->class.'/'."class.".str_replace("\\","/",trim($file,'\\')).'.php';
            if(file_exists($file)){
                require_once $file;
            }
        }
        public function getFile()
        {
            return $this->dir.'/'.$this->class.'/'.$this->class.'.'.$this->file.'.'.$this->extension;
        }
    }
    $autoload = new autoload();
?>