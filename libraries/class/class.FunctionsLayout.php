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
            $result .= '<div class="info position-relative">';
            if($this->theme=='product')
            {
                $flex = ($this->item['old_price']>0) ? 'd-flex justify-content-between align-items-baseline flex-wrap' : '';
                $result .= '<h3 class="name mb-1">'.$this->item['name'].'</h3>';
				if (!empty($this->item['place_from'])) {
					$result .= '<div class="place_from text-white p-2">'.$this->item['place_from'].'</div>';
				}
				if (!empty($this->item['date_tour'])) {
					$result .= '<div class="date_tour mb-1"><i class="far fa-clock mr-1"></i>'.$this->item['date_tour'].'</div>';
				}
				if (!empty($this->item['date_from'])) {
					$result .= '<div class="date_from mb-1"><i class="far fa-calendar mr-1"></i>'.date('d/m/Y', $this->item['date_from']).'</div>';
				}
				if (!empty($this->item['remain'])) {
					$result .= '<div class="remain mb-1"><i class="far fa-user mr-1"></i>'.$this->item['remain'].'</div>';
				}
                $result .= '<div class="price price text-right font-weight-bold '.$flex.'">'.$this->price($this->item['price'], $this->item['old_price']).'</div>';
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
