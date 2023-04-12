<?php if(!defined('LIB')) die("Error");
    class FunctionsCart
    {
        // private $d;
        // private $config;
        private $tbl = 'product';
        private $nameSession = 'cart';

        public function __construct($d){
            $this->d = $d;
        }
        public function cart_detail($id, $column, $folder="", $resize=""){
            global $d;
            $cart = $d->rawQueryOne("select $column from #_".$this->tbl." where id=$id");
            if($folder != "")
            {
                $path = CACHE.$resize.$folder.$cart[$column];
                $result = "<img onerror=src='images/noimage.png' src=".$path.">";
            }
            else $result = $cart[$column];
            return $result;
        }
        public function countSession(){
            return !empty($_SESSION[$this->nameSession]) ? count($_SESSION[$this->nameSession]) : 0;
        }
        public function addCart($id=0, $q=1, $size=0, $color=0){
            if($id<1 or $q<1) return;
            $code = md5($id.$size.$color);
            if(is_array($_SESSION[$this->nameSession]))
            {
                if($this->product_exists($code, $q)) return;
                $countSession = $this->countSession();
                $_SESSION[$this->nameSession][$countSession]['id'] = $id;
                $_SESSION[$this->nameSession][$countSession]['qty'] = $q;
                $_SESSION[$this->nameSession][$countSession]['size'] = $size;
                $_SESSION[$this->nameSession][$countSession]['color'] = $color;
                $_SESSION[$this->nameSession][$countSession]['code'] = $code;
            }
            else
            {
                $_SESSION[$this->nameSession] = array();
                $_SESSION[$this->nameSession][0]['id'] = $id;
                $_SESSION[$this->nameSession][0]['qty'] = $q;
                $_SESSION[$this->nameSession][0]['size'] = $size;
                $_SESSION[$this->nameSession][0]['color'] = $color;
                $_SESSION[$this->nameSession][0]['code'] = $code;
            }
        }
        private function product_exists($code, $q){
            $flag = 0;
            for($i = 0; $i < $this->countSession(); $i++){
                if($code == $_SESSION[$this->nameSession][$i]['code'])
                {
                    $_SESSION[$this->nameSession][$i]['qty'] = $_SESSION[$this->nameSession][$i]['qty'] + $q;
                    $flag = 1;
                    break;
                }
            }
            return $flag;
        }
        public function remove_product($code){
            for($i = 0; $i < $this->countSession(); $i++){
                if($code == $_SESSION[$this->nameSession][$i]['code'])
                {
                    unset($_SESSION[$this->nameSession][$i]);
                    break;
                }
            }
            $_SESSION[$this->nameSession]=array_values($_SESSION[$this->nameSession]);
        }
        public function get_order_total(){
            $result = 0;
            for($i=0; $i < count($_SESSION[$this->nameSession]); $i++){
                $id = $_SESSION[$this->nameSession][$i]['id'];
                $qty = $_SESSION[$this->nameSession][$i]['qty'];
                $price = $this->cart_detail($id, 'price');
                $result += $price * $qty;
            }
            return $result;
        }
    }
?>