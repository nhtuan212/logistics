<?php if(!defined('LIB')) die("Error");
    class AddonsOnline
    {
        public function __construct(){}
        private function addonTemplate($url, $width, $height, $type, $kind="", $timeOut="")
        {
            $class = $type;
            $css = ($type == 'map') ? 'style="position: relative;width:'.$width.';height:'.$height.'px"' : '';
            $result = '<div class="'.$class.'" '.$css.'></div>';
            $result .= '
                <script language="javascript" type="text/javascript">
                    $(document).ready(function(){
                        setTimeout(function(){
                            $(".'.$class.'").load("ajax/ajax_addonsOnline.php?url="+"'.$url.'"+"&width="+"'.$width.'"+"&height="+"'.$height.'"+"&kind="+"'.$kind.'"+"&type="+"'.$type.'");
                        }, "'.$timeOut.'");
                    });
                </script>
            ';
            return $result;
        }
        public function addonOnline($url, $width, $height, $type, $kind="")
        {
            switch($type)
            {
                case 'fanpage-messages':$kind = $kind;$timeOut = 120;break;
                case 'fanpage-timeline':$kind = $kind;$timeOut = 100;break;
                case 'video':$kind = $kind;$timeOut = 500;break;
                case 'map':$kind = $kind;$timeOut = 600;break;
            }
            return $this->addonTemplate($url, $width, $height, $type, $kind, $timeOut);
        }
    }
?>