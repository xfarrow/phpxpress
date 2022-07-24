<?php

    class Code{

        public static function doublequote($string){
            return '"' . $string . '"';
        }

        public static function bootstrapColors($color){
            if($color == 'blue')
                return 'primary';

            if($color == 'gray')
                return 'secondary';

            if($color == 'green')
                return 'success';

            if($color == 'red')
                return 'danger';
            
            if($color == 'yellow')
                return 'warning';

            if($color == 'cyan')
                return 'info';
        
            if($color == 'white')
                return 'light';
            
            if($color == 'black')
                return 'dark';

            throw new InvalidArgumentException('Color not valid. Available colors: blue, gray, green, red, yellow, cyan, white, black');
        }
    }
?>