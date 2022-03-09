<?php
    include "include.php";

    class Table{
      
      // Structure
      private $dataSource;
      private $columnCaptions;

      // Events
      private $onValueDisplayingFunctionName;

      // Layout
      private $darkTheme = false;
      private $stripedRows = false;
      private $bordered = false;
      private $hoverAnimation = false;
      private $small = false;
      
      function draw(){
        
        if(!isset($this->dataSource)){
          throw new BadFunctionCallException('Error: dataSource not set.');
        }

        $tableClass = "table";

        if($this->darkTheme) $tableClass.=" table-dark";
        if($this->stripedRows) $tableClass.=" table-striped";
        if($this->bordered) $tableClass.= " table-bordered";
        if($this->hoverAnimation) $tableClass.= " table-hover";
        if($this->small) $tableClass.= " table-sm";

        echo '<table class="' . $tableClass .'">';
        
        // Print head
        echo '<thead><tr>';
        foreach($this->columnCaptions as $caption){
          echo '<th scope="col">' . $caption . '</th>';
        }
        echo '</tr></thead>';

        // Print body
        echo '<tbody>';
        foreach($this->dataSource as $obj){
          echo '<tr>';
          foreach ($obj as $name => $value) {

            if(isset( $this -> onValueDisplayingFunctionName)){
              call_user_func_array($this -> onValueDisplayingFunctionName , array($name, &$value, (array)$obj));
            }
            echo '<td>' . $value . '</td>';

          }
          echo '</tr>';
        }
        echo "</tbody></table>";

      }

      /*
      ** Datasource can be either an array of object(s) or
      ** an array of array(s).
      */
      function setDataSource(Array $dataSource){
        if(empty($dataSource))
          throw new InvalidArgumentException('Parameter cannot be empty.');
        
        $this->dataSource = $dataSource;

        // Set captions when array of objects provided
        if(is_object($dataSource[0]))
          $this->columnCaptions = array_keys(get_object_vars($this->dataSource[0]));

        // Set captione when array of arrays provided
        else if(is_array($dataSource[0]))
          $this->columnCaptions = array_keys($this->dataSource[0]);
      }

      function setCustomCaptions(Array $captions){
        if(empty($this->dataSource))
          throw new BadFunctionCallException('Before setting Custom captions, a datasource must be provided first.');
        
        if(count($this->columnCaptions) == count($captions))
          $this->columnCaptions = $captions;
        else
        throw new LengthException('Number of provided captions not matching the datasource ones.');
      }

      /*
      ** if you use addColumn() either
      ** 1) you do not use any dataSource
      ** 2) you set the dataSource prior to call this method (otherwise it won't be correctly shown)
      */
      function addColumn($captionName){

        if(isset($this->columnCaptions)){
          array_push($this->columnCaptions , $captionName);
        }
        else{
          $this->columnCaptions = array($captionName);
        }

        // Add this property to every object/array of the dataSource
        if(isset($this->dataSource)){
          foreach($this->dataSource as $obj){
            $obj->{$captionName} = null;
          }
        }

      }

      /*
      ** The Event "onValueDisplaying" gets fired just before the displaying of a value within
      ** a table body, so you can display your own value.
      ** The function you have to provide must have this signature:
      **
      **                        function myFunction($caption, &$value, $row){...}
      **
      ** You can change "caption", "value" and "row" to whichever name you want.
      **
      ** caption: the ACTUAL fieldname of the dataSource whose value belongs to
      ** value:   the value you want to display.
      ** row:     an associative array representing the row being processed
      */
      function onValueDisplaying($functionName){
        if(!is_callable($functionName))
          throw new InvalidArgumentException("Couldn't call $functionName. You must provide the name of a function.");

        $this -> onValueDisplayingFunctionName = $functionName;
      }

      function setDarkTheme($bool){
        if(!is_bool($bool)){
          throw new InvalidArgumentException('Parameter must be a boolean.');
        }
        $this->darkTheme = $bool;
      }

      function setStripedRows($bool){
        if(!is_bool($bool)){
          throw new InvalidArgumentException('Parameter must be a boolean.');
        }
        $this->stripedRows = $bool;
      }

      function setBordered($bool){
        if(!is_bool($bool)){
          throw new InvalidArgumentException('Parameter must be a boolean.');
        }
        $this->bordered = $bool;
      }

      function setHoverAnimation($bool){
        if(!is_bool($bool)){
          throw new InvalidArgumentException('Parameter must be a boolean.');
        }
        $this->hoverAnimation = $bool;
      }

      function setSmall($bool){
        if(!is_bool($bool)){
          throw new InvalidArgumentException('Parameter must be a boolean.');
        }
        $this->small = $bool;
      }
    }
?>
