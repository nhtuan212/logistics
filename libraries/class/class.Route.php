<?php
    class Route
    {
        private static $extension = "@";
        private static $source = "";
        private static $template = "";
        private static $type_og = "";
        private static $type = "";
        private static $title = "";
        public static function __callStatic($method, $params)
        {
            $callback = explode(self::$extension, $params[0]);
            self::$source = $callback[0];
            self::$template = $callback[1];
            self::$type_og = (isset($callback[2])) ? $callback[2] : "object";
            self::$type = $params[1];
            self::$title = $params[2];
        }
        public static function source(){
            return self::$source;
        }
        public static function template(){
            return self::$template;
        }
        public static function type(){
            return self::$type;
        }
        public static function title(){
            return self::$title;
        }
        public static function type_og(){
            return self::$type_og;
        }
        private static function get(){}
    }
?>