<?php
    class FunctionsLayout extends Functions
    {
        public function __construct($db)
        {
            $this->db = $db;
        }
        public function setTbl($tbl)
        {
            $this->tbl = $tbl;
        }
        public function setClass($class)
        {
            $this->class = $class;
        }
        public function setHvr($hvr)
        {
            $this->hvr = $hvr;
        }
        public function item($item)
        {
            $this->item = $item;
        }
        public function infoTheme($theme) {
            $this->theme = $theme;
        }
        public function setType($type)
        {
            $this->type = $type;
        }
        public function setImage($dir, $image, $resize)
        {
            $this->dir = $dir;
            $this->image = $image;
            $this->resize = $resize;
        }
        public function getTheme()
        {
            return $this->theme();
        }
        private function theme()
        {
            $result = '';
            $result .= '<a class="'.$this->class.'" href="'.$this->item['tenkhongdau'].'">';
            $result .= '<div class="img '.$this->hvr.'">';
            $result .= $this->get_photo(array('dir' => $this->dir,'photo' => $this->item[$this->image],'name' => $this->item['name'],'resize' => $this->resize,));
            $result .= '</div>';
            $result .= '<div class="info">';
            if($this->theme=='product')
            {
                $flex = ($this->item['old_price']>0) ? 'd-flex justify-content-between align-items-baseline flex-wrap' : '';
                $result .= '<h3 class="name mb-1">'.$this->item['name'].'</h3>';
                $result .= '<div class="price '.$flex.'">'.$this->price($this->item['price'], $this->item['old_price']).'</div>';
            }
            if($this->theme=='post') {
                $result .= '<h3 class="name mb-2 line-2">'.$this->item['name'].'</h3>';
                $result .= '<p class="desc line-3">'.$this->item['descript'].'</p>';
            }
            $result .= '</div>';
            $result .= '</a>';
            return $result;
        }
        private function getType()
        {
            global $type;
            return (isset($this->type)) ? $this->type : $type;
        }
    }
?>