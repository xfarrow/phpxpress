<?php

/**
 * PhpXpress v1.0.1
 *
 * @see https://github.com/xfarrow/phpxpress The PhpXpress GitHub project
 *
 * @author    Alessandro Ferro <>
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

    namespace PhpXpress;

    class BreadCrumb{

        private $locations;

        // unless otherwise specified via stating 'setActiveLocation()'
        // the active location will be the last element
        private $activeLocation;

        // unless otherwise specified, the divider character will be: "/"
        private $divider;

        /*
        ** The datasource must be an associative array.
        ** array("Home" => "xyz.com/home" , "Starred" => "xyz.com/home/starred", "Reading" => "xyz.com/home/starred/reading");
        ** Will produce:
        **                  Home / Starred / Reading
        */
        function setDataSource($dataSource){
            if(!is_array($dataSource))
                throw new InvalidArgumentException('Parameter dataSource must be an array.');

            foreach($dataSource as $caption => $link){
                $this->addElement($caption, $link);
            }
        }

        /*
        ** Adds an element at the end of the Breadcrumb
        */
        function addElement($caption, $link){

            if(isset($this->locations))
                $this->locations[$caption] = $link;

            else
                $this->locations = array($caption => $link);

            $this->activeLocation = $caption;
        }

        /*
        ** You can specify either a scalar (the (n-1)th to be activated)
        ** or a string (the caption to be activated)
        */
        function setActiveLocation($activeLocation){

            if(!is_scalar($activeLocation) && !is_string($activeLocation))
                throw new InvalidArgumentException('Parameter activeLocation can be either an int or a string. None of these provided.');

            $this->activeLocation = $activeLocation;
        }

        function setDivider($divider){
            $this->divider = $divider;
        }

        function draw(){

            $iterator = 0;

            if(!isset($this->divider))
                echo '<nav aria-label="breadcrumb">';
            else
                echo '<nav style="--bs-breadcrumb-divider: \'' . $this->divider . '\';" aria-label="breadcrumb">';

            echo '<ol class="breadcrumb">';

            foreach($this->locations as $caption => $link){

                // active location
                if(
                    (is_int($this->activeLocation) && $this->activeLocation == $iterator)
                ||  (is_string($this->activeLocation) && $this->activeLocation == $caption)
                  ){
                      echo '<li class="breadcrumb-item active" aria-current="page">' . $caption . '</li>';
                  }

                // non active location
                else{
                    echo '<li class="breadcrumb-item">';
                    echo  '<a href="' . $link . '">' . $caption;
                    echo '</a></li>';
                }

                $iterator++;
            }
            echo '</ol></nav>';
        }
    }
?>
