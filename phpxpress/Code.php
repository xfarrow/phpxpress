<?php

    namespace PhpXpress;

    class Code{

        private static $colors_array = array( "blue" => "primary",
                                        "gray" => "secondary",
                                        "green" => "success",
                                        "red" => "danger",
                                        "yellow" => "warning",
                                        "cyan" => "info",
                                        "white" => "light",
                                        "black" => "dark");

        public static function bootstrapColors($color){

            if(array_key_exists($color, self::$colors_array)){
                return self::$colors_array[$color];
            }

            if(in_array($color, self::$colors_array)){
                return $color;
            }

            throw new \InvalidArgumentException("Color $color is not valid. Available colors: blue, gray, green, red, yellow, cyan, white, black");
        }

        public static function phpxpress_version(){
            return "1.0.4";
        }

    }
?>