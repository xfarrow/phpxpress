<?php
    include "include.php";

    class Card{
        private $imageSource;
        private $title;
        private $subtitle;
        private $innerText;
        private $width = 18;
        private $footerText;
        private $fieldsArray;
        private $list;
        private $linksArray;
        private $button;
        private $borderColor;
        private $cardColor;
        private $textColor;

        function setBorderColor($color){
            $this->borderColor = Code::bootstrapColors($color);
        }

        function setCardColor($color){
            $this->cardColor = Code::bootstrapColors($color);
        }

        function setTextColor($color){
            $this->textColor = $color;
        }

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

        function setFooterText($footerText){
            $this->footerText = $footerText;
        }

        function setWidth($width){
            $this->width = $width;
        }

        function setButton($text, $link){
            $this->button["text"] = $text;
            $this->button["link"] = $link;
        }

        function addField($caption, $value){
            if(isset($this->fieldsArray))
                $this->fieldsArray[$caption] = $value;
            else
                $this->fieldsArray = array($caption => $value);
        }

        function setDataSource($datasource){
            foreach($datasource as $caption=>$value){
                $this->addField($caption,$value);
            }
        }

        function addLink($caption, $link){
            $this->linksArray[$caption] =  $link;
        }

        function addArrayList(Array $list){
            if(isset($this->list)){
                $this->list = array_merge($this->list, $list);
            }else{
                $this->list = $list;
            }
        }

        function addElementList($element){
            if(isset($this->list)){
                array_push($this->list, $element);
            }else{
                $list = array($element);
            }
        }

        function draw(){

            $class = "card";

            if(isset($this->borderColor)){
                $class.= ' border-' . $this->borderColor;
            }
            if(isset($this->cardColor)){
                $class.= ' bg-' . $this->cardColor;
            }
            if(isset($this->textColor)){
                $class.= ' text-' . $this->borderColor;
            }

            echo '<div class="' . $class . '" style="width: ' . $this->width . 'rem;">';

            // Image
            if(isset($this->imageSource)){
                echo '<img class="card-img-top" src="'.$this->imageSource.'" alt="Card image cap">';
            }

            echo '<div class="card-body">';
            echo '<h5 class="card-title">'. $this->title .'</h5>'; // title
            echo '<h6 class="card-subtitle mb-2 text-muted">'. $this->subtitle .'</h6>'; // subtitle
            echo '<p class="card-text">'. $this->innerText . '</p>'; // text

            if(isset($this->fieldsArray)){ // fields
                foreach($this->fieldsArray as $field => $value){
                    echo '<p class="card-text"><b>' . $field . ': </b>' . $value . '</p>';
                }
            }

            if(isset($this->list)){
                echo '</div>'; // close card-body div
                echo '<ul class="list-group list-group-flush">';
                foreach($this->list as $string){
                    echo '<li class="list-group-item">' . $string . '</li>';
                }
                echo '</ul>';
                echo '<div class="card-body">';
            }

            if(isset($this->linksArray)){ // links
               foreach($this->linksArray as $caption => $link){
                   echo '<a href="' . $link . '" class="card-link">'. $caption .'</a>';  
            }
            echo '<br/><br/>';
        }

            if(isset($this->button))
                echo '<a href="' . $this->button["link"] . '" class="btn btn-primary">' . $this->button["text"] . '</a>';

            if(isset($this->footerText))
                echo '<br/><br/><p class="card-text"><small class="text-muted">' . $this->footerText . '</small></p>'; // footer

            echo '</div></div>';
        }

        static function beginCardGroupLayout($width=36){
            /*
            ** Using this overrides the card's width (known error from Bootstrap), so you should specify a width.
            */
            echo '<div class="card-group" style="width:' . $width. 'rem;">';
        } 

        static function endCardGroupLayout(){
            echo '</div>';
        }

    }
?>