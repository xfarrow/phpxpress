<?php

/**
 * PhpXpress
 *
 * @see https://github.com/xfarrow/phpxpress The PhpXpress GitHub project
 *
 * @author    Alessandro Ferro <>
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

    include "include.php";
    class Table{

      /* === Structure === */

      /**
       * The datasource to provdide to the table.
       * Must be an array of arrays or an array of objects.
       * 
       * @var array
       */
      private $dataSource;

      /**
       * The column captions
       * 
       * @var array
       */
      private $columnCaptions;

      /**
       * The columns to make invisible.
       * The column whose name is a key of the array
       * of the datasource, will not be shown.
       * 
       * @var array
       */
      private $invisible_columns;

      /* === Events === */
      private $onValueDisplayingFunctionName;

      /* === Layout === */
      private $darkTheme = false;
      private $stripedRows = false;
      private $bordered = false;
      private $hoverAnimation = false;
      private $small = false;

      /* === Other === */

      /**
       * If pedantic_type_check is set to true, check
       * if the datasource's elements are all arrays
       * or all objects. A mix of them will lead
       * to unexpected results
       */
      private $pedantic_type_check = false;

      /**
       * Draw the Table.
       * 
       * @return void
       */
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

        echo "<table class = '$tableClass'>";

        /**
        **
        ** management of invisible columns.
        **
        ** $this->invisible_columns is an array containing the name
        ** of the key of the array/object not to be displayed.
        **
        ** $invisible_column_captions is an array holding the column
        ** captions of the columns to be removed, since the column captions
        ** might differ from the keys of the array/object [when using setCustomCaptions()].
        */
        if(!empty($this->invisible_columns)){
          if(is_array($this->dataSource[0])){
            $array_keys = array_keys($this -> dataSource[0]);
          }
          else{
            $array_keys = array_keys(get_object_vars($this -> dataSource[0]));
          }
        
          $invisible_columns_captions = array();
          foreach($this->invisible_columns as $invisible_column_name){
            $column_index = array_search($invisible_column_name, $array_keys);
            array_push($invisible_columns_captions, $this->columnCaptions[$column_index]);
          }
        }

        // Print head
        echo '<thead><tr>';
        foreach($this->columnCaptions as $caption){
          // do not show column head if it's hidden
          if( isset($invisible_columns_captions) && in_array($caption, $invisible_columns_captions))
            continue;

          echo '<th scope="col">' . $caption . '</th>';
        }
        echo '</tr></thead>';

        // Print body
        echo '<tbody>';
        foreach($this->dataSource as $obj){
          echo '<tr>';
          foreach ($obj as $name => $value) {
            // do not show column value if it's hidden
            if(!empty($this->invisible_columns) && in_array($name, $this->invisible_columns)){
              continue;
            }
            // fire event onValueDisplaying 
            if(isset( $this -> onValueDisplayingFunctionName)){
              call_user_func_array($this -> onValueDisplayingFunctionName , array($name, &$value, (array)$obj));
            }
            echo '<td>' . $value . '</td>';
          }
          echo '</tr>';
        }
        echo "</tbody></table>";

      }

      /**
       * Set the table's datasource.
       * Datasource can be either an array of object(s) or
       * an array of array(s).
       * 
       * @param array $datasource An array of arrays or an array of objects. 
       *
       * @return void
      */
      function setDataSource(Array $dataSource){
        if(empty($dataSource))
          throw new InvalidArgumentException('Parameter cannot be empty.');

        if(isset($this-> dataSource))
          throw new BadFunctionCallException("Cannot add datasource to a Table already having a datasource");


        $is_array_of_arrays; // if false, the datasource is an array of object(s)
        if(is_object($dataSource[0])){
          $is_array_of_arrays = false;
        }
        else if(is_array($dataSource[0])){
          $is_array_of_arrays = true;
        }
        else{
          throw new InvalidArgumentException('Parameter "datasource" must be an' .
                                            'array of array(s) or array of object(s)');
        }

        if($this -> pedantic_type_check){
          if(count(array_filter($dataSource, function($entry) use($is_array_of_arrays){
            if(is_array($entry)){
              return !$is_array_of_arrays;
            }
            else if(is_object($entry)){
              return $is_array_of_arrays;
            }
            else
              throw new InvalidArgumentException('Parameter "datasource" must be an' .
                                              'array of array(s) or array of object(s)');
          })) > 0){
            throw new InvalidArgumentException('Parameter "datasource" must be an' .
                                            'array of array(s) or array of object(s)');
          }
        }

        /**
         * If one or more addColumn() were called before setting the datasource,
         * we should add those columns in the source.
        */
        if(isset($this -> columnCaptions)){
          foreach($dataSource as &$row){
            foreach($this -> columnCaptions as $captionName){
              if($is_array_of_arrays){
                $row = array($captionName => null) + (array)$row; // append the already inserted captions at the beginning
                //$element->{$captionName} = null; // append the already inserted captions at the end
              }
              else{
                $row = (object)(array($captionName => null) + (array)$row); // append the already inserted captions at the beginning
                //$element->{$captionName} = null; // append the already inserted captions at the end
              }
            }
          }
        }

        $this -> dataSource = $dataSource;

        // Set captions when array of objects provided
        if(!$is_array_of_arrays){
            $this->columnCaptions = array_keys(get_object_vars($this -> dataSource[0]));
        }
        // Set caption when array of arrays provided
        else{
            $this->columnCaptions = array_keys($this -> dataSource[0]);
        }
      }

      /**
       * By default, the columns' captions will be the keys of the
       * array or object provided. 
       * 
       * You can override them by setting custom captions.
       */
      function setCustomCaptions(Array $captions){

        if(empty($this->dataSource))
          throw new BadFunctionCallException('Before setting Custom captions, a datasource must be provided first.');

        $provided = count($captions);
        $expected = count($this->columnCaptions);

        if($provided == $expected)
          $this -> columnCaptions = $captions;
        else
        throw new LengthException('Number of provided captions not matching the datasource ones.
                                  Provided: ' . $provided . "; Expected: " . $expected);
      }

      /**
       * Add columns to the table (setting it before or after the datasource
       * will show the column before or after the datasource)
       * 
       * @param string $captionName The name of the new column
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

      /**
       * Expected $column_name: the column to remove. To be called after the datasource
       * is set.
       *
       * Making a column invisible, rather than removing it from the datasource, might
       * be useful in those circumstances where a value is needed in the datasource
       * or in the onValueDisplaying, without actually removing it.
       * 
       * @param string $column_name: the column to remove.
       *
      */
      function invisible_column($column_name){

        if(!isset($this->dataSource))
          throw new BadFunctionCallException('Unable to call invisible_column() if the datasource is not set');

        if(is_array($this->dataSource[0])){
          $array_keys = array_keys($this -> dataSource[0]);
        }
        else{
          $array_keys = array_keys(get_object_vars($this -> dataSource[0]));
        }

        if(!in_array($column_name, $array_keys)){
          throw new InvalidArgumentException("The provided column $column_name is not present in the datasource's column keys");
        }

        if(isset($this->invisible_columns)){
          if(in_array($column_name, $this->invisible_columns))
            throw new InvalidArgumentException("The provided column $column_name is already invisible");
          
            array_push($this->invisible_columns, $column_name);
        }
        else{
          $this->invisible_columns = array($column_name);
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

      // to be used before setting the datasource
      function setPedanticTypeCheck($bool){
        if(!is_bool($bool)){
          throw new InvalidArgumentException('Parameter must be a boolean.');
        }
        if(isset($this->datasource)){
          echo "<b>Warning</b>Use of pedantic type check after datasource is set. Instruction ignored.";
          return;
        }
        $this->pedantic_type_check = $bool;
      }
    }
?>
