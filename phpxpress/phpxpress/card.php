<?php
    include "include.php";

    class Card{
        private $imageSource;
        private $title;
        private $subtitle;
        private $innerText;
        private $width = 18;

        function setImageSource($imageSource){
            if(!is_string($imageSource))
                throw new InvalidArgumentException('Parameter imageSource must be a string.');

            $this->imageSource = $imageSource;
        }

        function setTitle($title){
            $this->title = $title;
        }

        function setSubTitle($subTitle){
            $this->subtitle = $subTitle;
        }

        function setInnerText($innerText){
            $this->innerText = $innerText;
        }

        function setWidth($width){
            $this->width = $width;
        }

        function draw(){
            echo '<div class="card" style="width: '.$this->width.'rem;">';

            // Image
            if(isset($this->imageSource)){
                echo '<img class="card-img-top" src="'.$this->imageSource.'" alt="Card image cap">';
            }

            echo '<div class="card-body">';
            echo '<h5 class="card-title">'. $this->title .'</h5>'; // title
            echo '<h6 class="card-subtitle mb-2 text-muted">'. $this->subtitle .'</h6>'; // subtitle
            echo '<p class="card-text">'. $this->innerText . '</p>';
            echo '</div></div>';
        }
    }
?>