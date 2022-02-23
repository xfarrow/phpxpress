<?php
    include "include.php";

    class Table{
      private $dataSource;
      private $columnCaptions;

      private $darkTheme = false; // boolean
      private $stripedRows = false; // boolean
      private $bordered = false; //boolean
      private $hoverAnimation = false; //boolean
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

      function setDataSource($dataSource){
        if(!is_array($dataSource)){
          throw new BadFunctionCallException('DataSource must be an array.');
        }

        $this->dataSource = $dataSource;
        $this->columnCaptions = array_keys(get_object_vars($this->dataSource[0]));
      }

      function setCustomCaptions($captions){
        if(!is_array($captions)){
          throw new BadFunctionCallException('Captions must be an array.');
        }
        $this->columnCaptions = $captions;
      }

      function setDarkTheme($bool){
        if(!is_bool($bool)){
          throw new BadFunctionCallException('Parameter must be a boolean.');
        }
        $this->darkTheme = $bool;
      }

      function setStripedRows($bool){
        if(!is_bool($bool)){
          throw new BadFunctionCallException('Parameter must be a boolean.');
        }
        $this->stripedRows = $bool;
      }

      function setBordered($bool){
        if(!is_bool($bool)){
          throw new BadFunctionCallException('Parameter must be a boolean.');
        }
        $this->bordered = $bool;
      }

      function setHoverAnimation($bool){
        if(!is_bool($bool)){
          throw new BadFunctionCallException('Parameter must be a boolean.');
        }
        $this->hoverAnimation = $bool;
      }

      function setSmall($bool){
        if(!is_bool($bool)){
          throw new BadFunctionCallException('Parameter must be a boolean.');
        }
        $this->small = $bool;
      }

    }
?>
