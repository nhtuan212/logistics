<?php
    class Theme
    {
        public function __construct(){}
        public function setTbl($tbl)
        {
            $this->tbl = $tbl;
        }
        public function setDir($dir)
        {
            $this->dir = $dir;
        }
        public function setColumn($column)
        {
            $this->column = $column;
        }
        public function setResize($resize)
        {
            $this->resize = $resize;
        }
        public function getTbl()
        {
            return $this->tbl;
        }
        public function getDir()
        {
            return $this->dir;
        }
        public function getColumn()
        {
            return $this->column;
        }
        public function getResize()
        {
            return $this->resize;
        }
        public function getType()
        {
            global $type;
            return $type;
        }
    }
?>