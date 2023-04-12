<?php
    class Upload extends Functions
    {
        private $file = 'upload/';
        private $marker = '/';

        public function __construct($d, $com, $act, $level)
        {
            $this->db = $d;
            $this->com = $com;
            $this->act = $act;
            $this->level = $level;
        }
        public function setTitle($str) {
            $this->title = $str;
        }
        public function setName($str) {
            $this->name = $str;
        }
        public function setData($str) {
            $this->column = $str;
        }
        public function setDir($str) {
            $this->setDir = $str;
        }
        public function setWidth($int) {
            $this->setWidth = $int;
        }
        public function setHeight($int) {
            @$this->setHeight = $int;
        }
        private function com() {
            if($this->level > 0) $result = $this->com.'-lv'.$this->level;
            elseif($this->com == 'photo')
            {
                if($this->act == 'man_static') $result = $this->com.'_static';
                if($this->act == 'add_multi' || $this->act == 'edit_multi') $result = $this->com.'_multi';
            }
            else $result = $this->com;
            return $result;
        }
        private function type() {
            global $type;
            ($type != "company" || $type == "") ? $result = $type : $result = "";
            return $result;
        }
        private function getDir() {
            ($this->com == 'product' || $this->com == 'post' || $this->com == 'user') ? $name = $this->com : $name = 'photo';
            $result = $this->file.$name.$this->marker;
            if(@$this->setDir) $result = $this->setDir;
            return $result;
        }
        private function getWidth() {
            global $config, $type;
            $result = $config[$this->com()][$type]['photo_width'];
            if(@$this->setWidth) $result = $this->setWidth;
            return $result;
        }
        private function getHeight() {
            global $config, $type;
            $result = $config[$this->com()][$type]['photo_height'];
            if(@$this->setHeight) $result = $this->setHeight;
            return $result;
        }
        public function photo($i="") { ?>
            <?php global $item, $type, $config, $tbl; ?>
            <?php $resize = $this->getWidth()."x".$this->getHeight()."x1"; ?>
            <div class="form-group">
                <div class="custom-file">
                    <label><?=$this->title?></label>
                    <div class="photoUpload" data-childrendClass="<?=$this->name.$i?>">
                        <label class="photoUpload-file <?=$this->name.$i?> mt-1" for="<?=$this->name.$i?>">
                            <div class="img d-flex align-items-center">
                                <?=$this->get_photo(array('dir' => @$this->getDir(),'photo' => @$item[$this->column],'resize' => $resize,));?>
                            </div>
                            <input type="file" name="<?=$this->name.$i?>" id="<?=$this->name.$i?>">
                            <img class="rounded mt-2"/>
                            <i class="fas fa-cloud-upload-alt mt-2"></i>
                            <p class="mb-2">Kéo và thả hình vào đây</p>
                            <div class="btn-choseImg btn btn-sm btn-danger mt-1"><i class="fas fa-camera mr-2"></i>Chọn hình</div>
                        </label>
                    </div>

                    <div class="note">
                        Width: <?=$this->getWidth()?>px - Height: <?=$this->getheight()?>px ( <?=$config[$this->com()][$type]['photo_type']?> )
                    </div>
                </div>
            </div>
        <?php }
        public function file($i="") { ?>
            <?php global $item, $type, $config, $tbl; ?>
            <div class="form-group">
                <div class="custom-file">
                    <label><?=$this->title?></label>
                    <div class="change-photo mt-2">
                        <label class="img text-center" for="file<?=$this->name.$i?>">
                            <div class="current-file"><a href="<?=$this->getDir().$item['file']?>"><?=$item[$this->column]?></a></div>
                            <div class="name-photo mt-1 font-weight-normal"></div>
                            <div class="btn btn-sm btn-success mt-1"><i class="far fa-file-alt mr-2"></i>Chọn File</div>
                        </label>
                        <input id="file<?=$this->name.$i?>" type="file" name="<?=$this->name.$i?>" class="custom-file-input d-none">
                        <div class="custom-file-label d-none"><span>Choose File</span></div>
                    </div>
                    <div class="note">
                        ( <?=$config[$this->com()][$type]['file_type']?> )
                    </div>
                </div>
            </div>
        <?php }
    }
?>