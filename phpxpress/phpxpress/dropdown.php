<script type="text/javascript" src="../bootstrap-5.1.3-dist/js/bootstrap.bundle.js"></script>
<?php

/**
 * PhpXpress v1.0
 *
 * @see https://github.com/xfarrow/phpxpress The PhpXpress GitHub project
 *
 * @author    Alessandro Ferro <>
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

    include "include.php";

    class Dropdown{

        private $title;
        private $datasource;
        private $color = 'secondary';
        private $size;
        private $darkTheme = false;

        // Associative array name => link
        public function setDataSource(Array $datasource){
            $this->datasource = $datasource;
        }

        public function setTitle($title){
            $this->title = $title;
        }

        public function setColor($color){
            $this->color = Code::bootstrapColors($color);
        }

        public function setSize($size){
            if($size == "default")
                $this->size = NULL;
            
            else if($size == "large")
                $this->size = "btn-lg";

            else if($size == "small")
                $this->size = "btn-sm";

            else
                throw new InvalidArgumentException('Parameter size must be either default, large or small.');
        }

        public function setDarkTheme($bool){
            if(!is_bool($bool))
                throw new InvalidArgumentException('Parameter must be a bool.');

            $this->darkTheme = $bool;

        }

        public function draw(){

            $btnClass = 'btn btn-' . $this->color . ' dropdown-toggle';
            if(isset($this->size)){
                $btnClass .= ' ' . $this->size;
            }

            echo '<div class="dropdown">';

            // Title
            echo '<button class="' . $btnClass .'" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">';
            echo $this->title;
            echo '</button>';

            $ulClass = "dropdown-menu";
            if($this->darkTheme){
                $ulClass .= " dropdown-menu-dark";
            }

            echo '<ul class="' . $ulClass . '" aria-labelledby="dropdownMenuButton1">';
              
            foreach($this->datasource as $name => $link){
                echo '<li><a class="dropdown-item" href="' . $link . '">' . $name . '</a></li>';
            }
            
            echo '</ul></div>';
        }
    }
?>