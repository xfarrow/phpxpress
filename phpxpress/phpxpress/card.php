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

    class Card{
        
        // Structure
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

        // Events
        private $onFieldDisplayingFunctionName;

        // Layout
        private $borderColor;
        private $cardColor;
        private $textColor;

        /*
        ** https://getbootstrap.com/docs/5.1/components/card/#border
        */
        function setBorderColor($color){
            $this->borderColor = Code::bootstrapColors($color);
        }

        /*
        ** https://getbootstrap.com/docs/5.1/components/card/#background-and-color
        */
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

        /*
        ** Setting a datasource will produce a list of fields (bold caption with light value).
        ** E.G. array("Color" => "Red" , "Brand" => "Ferrari" , "Horsepower" => "700HP")
        ** will produce:
        **              Color: Red
        **              Brand: Ferrari
        **              Horsepower: 700HP
        */
        function setDataSource($datasource){
            foreach($datasource as $caption => $value){
                $this->addField($caption,$value);
            }
        }

        /*
        ** https://getbootstrap.com/docs/5.1/components/card/#titles-text-and-links
        */
        function addLink($caption, $link){
            $this->linksArray[$caption] =  $link;
        }

        /*
        ** https://getbootstrap.com/docs/5.1/components/card/#list-groups
        */
        function addArrayToList(Array $list){
            if(isset($this->list)){
                $this->list = array_merge($this->list, $list);
            }else{
                $this->list = $list;
            }
        }

        /*
        ** https://getbootstrap.com/docs/5.1/components/card/#list-groups
        */
        function addElementToList($element){
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
            echo '<p class="card-text">'. $this->innerText . '</p>'; // innertext

            // fields
            if(isset($this->fieldsArray)){
                foreach($this->fieldsArray as $field => $value){
                    if(isset($this->onFieldDisplayingFunctionName)){
                        call_user_func_array($this -> onFieldDisplayingFunctionName , array(&$field, &$value));
                    }
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

        /*
        ** The Event "onFieldDisplaying" gets fired just before the displaying of a field within
        ** a card, so you can display your own value.
        ** The function you have to provide must have this signature:
        **
        **                        function myFunction(&$field , &$value){...}
        **
        ** You can change "field" snd "value" to whichever name you want.
        **
        */
        function onFieldDisplaying($functionName){
            if(!is_callable($functionName))
                throw new InvalidArgumentException("Couldn't call $functionName. You must provide the name of a function.");

            $this -> onFieldDisplayingFunctionName = $functionName;
        }

        /*
        ** Using this overrides the card's width (known error from Bootstrap), so you should specify a width.
        ** It always has to be closed with endCardGroupLayout()
        ** https://getbootstrap.com/docs/5.1/components/card/#card-groups
        */
        static function beginCardGroupLayout($width=36){
            echo '<div class="card-group" style="width:' . $width. 'rem;">';
        } 

        static function endCardGroupLayout(){
            echo '</div>';
        }

    }
?>