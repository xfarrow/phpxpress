<?php
    include "include.php";

    class Table{
      private $dataSource;
      private $columnCaptions;

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
            echo '<td>' . $value . '</td>';
          }
          echo '</tr>';
        }
        echo "</tbody></table>";

      }

      function setDataSource(Array $dataSource){
        if(empty($dataSource))
          throw new InvalidArgumentException('Parameter cannot be empty.');
        
        $this->dataSource = $dataSource;
        $this->columnCaptions = array_keys(get_object_vars($this->dataSource[0]));
      }

      function setCustomCaptions(Array $captions){
        if(empty($this->dataSource))
          throw new BadFunctionCallException('Before setting Custom captions, a datasource must be provided first.');
        
        if(count($this->columnCaptions) == count($captions))
          $this->columnCaptions = $captions;
        else
        throw new LengthException('Number of provided captions not matching the datasource ones.');
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
