<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreForm extends CI_Model {

    private $DB = "core_cms_lite_v1";

	/*
	*
	* To load libraries/Model/Helpers/Add custom code which will be used in this Model
	* This can ease the loading work 
	* 
	*/
    public function __construct(){

        parent::__construct();

        //libraries
        
        //Helpers

        //Models

        // Your own constructor code
    }

    /*
    *
    * 
    * 
    */
    public function form_auto_generate($module,$excluded='id,flg,level,details,logname,password')
    {
        //Get The Table Columns Name & Type
        $column_name_type = $this->get_column_data($module);
        //Exclude Columns
        $included_columns = $this->columns_in_use($module,$column_name_type,$excluded);
        //Get Columns Names
        $columns_names = $this->get_column_name_type($included_columns);
        //Get Columns Data Type
        $columns_type = $this->get_column_name_type($included_columns,'TYPE');

        //Get Labels
        $labels = $this->remove_column_names($module,$columns_names);
        //Get Column Type
        $type = $this->get_columns_types($columns_type);

        /*
        * Input Type Generator 
        */
        $input_type = $this->form_input_type_auto($type);
        
        for($i = 0; $i < count($columns_names); $i++){
            
            $name = $columns_names[$i]; //Input Name
            foreach ($input_type[$i] as $key => $value) {
                $type = $key; // Input Type
                $col_class = $value; // Column Class
            }
            
            $form[$i] = $this->input_text($name,$type,null,$col_class,$id=null);

        }

        return $form;
    }

    /*
    *
    * Get Table Column Name and Column Type
    * Function accept Module name then it pluralize it to get table name
    * 
    */
    public function get_column_data($module)
    {
        //Get Table Name
        $table = $this->plural->pluralize($module);

        //Query
        $query = $this->db->query("SELECT COLUMN_NAME, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$this->DB' AND TABLE_NAME = '$table' ");
        return $query->result();
    }

    /*
    *
    * Function to generate columns name or Tyep Array
    * Pass columns Name & Type array
    * 
    */
    public function get_column_name_type($column_name_type,$get='name')
    {
        //Array to store Data
        $name_type = array();
        //Get Type/Name
        if (strtolower($get) == 'type') {
            //Get Type
            for($i = 0; $i < count($column_name_type); $i++){
                $name_type[$i] = $column_name_type[$i]->COLUMN_TYPE;// Assign Column Type
            }
        }else{
            //Get Name
            for($i = 0; $i < count($column_name_type); $i++){
                $name_type[$i] = $column_name_type[$i]->COLUMN_NAME;// Assign Column Name
            }
        }

        //Return Data
        return $name_type;
    }


    /*
    *
    * The function returns list of columns to print
    * Accept Module name
    * Exldued Columns
    * Optional column order
    */
    public function columns_in_use($module,$column_name_type=null,$excluded='id,stamp,flg')
    {

        //Singularize Module
        $module = $this->plural->singularize($module);

        //Set Up column names
        $excluded_columns = $this->get_column_names($module,$excluded); //Excluded
        $column_name_type = $this->get_column_data($module); //List of Columns

        $tempo_column_name_type = $column_name_type; //Store Data of Columns Type & Names in Temporary variable

        //Get Columns
        for($i = 0; $i < count($column_name_type); $i++){
            
            $column = $column_name_type[$i]->COLUMN_NAME;//Exclude Column Name
            if (in_array($column,$excluded_columns)) {
                unset($tempo_column_name_type[$i]); //Unset Column By Key Name/Number
            }
        }

        $column_to_use = array_values($tempo_column_name_type); //Re-arrange array

        //Columns
        return $column_to_use;
    }

    /*
    *
    * The function generate proper column names
    * The function accepts
    * Module Name
    * Column simple name
    * 
    */
    public function get_column_names($module,$column)
    {
        //Singularize Module
        $module = $this->plural->singularize($module);

        //Get Columns
        $columns = explode(",", $column);

        $column_list = array();
        for($i = 0; $i < count($columns); $i++){

            $column_list[$i] = $module.'_'.$columns[$i]; 
        }

        //Return Columns Names
        return $column_list;
    }

    //One Column
    public function get_column_name($module,$column)
    {
        //Singularize Module
        $module = $this->plural->singularize($module);
        $column_name = $module.'_'.$column; //Column Name

        return $column_name;
    }

    /*
    *
    * Function to remove column Name and Return Label Name
    * Pass module name
    * Pass columns name array
    * 
    */
    public function remove_column_names($module,$columns)
    {

        //Singularize Module
        $module = $this->plural->singularize($module);
        $module = $module."_";

        //Store Label Names
        $label = array();
        //Remove Module Name
        for($i = 0; $i < count($columns); $i++){
            $column_name = $columns[$i]; //Set Current Column Name
            $label[$i] =  substr($column_name,strpos($column_name, "_") +1); //Get Current Label Name
        }

        //Return Label List
        return $label;
    }

    //Quick Get Input Label
    public function get_label_name($column)
    {
        //Column Get
        $label =  substr($column,strpos($column, "_") +1); //Get Current Label Name

        return $label;
    }

    //Quick Get Column Name without UnderScore
    public function get_column_label_name($column)
    {
        //Get Label Name
        $label = ucwords(str_replace('_',' ',$column));

        return $label; //Label Name
    }

    /*
    *
    * Check column data TYPE
    * Check the lenght of the data TYPE
    * 
    */
    public function get_columns_types($columns)
    {
        //Store Columns Type and Value
        $type_value = array();

        for($i = 0; $i < count($columns); $i++){
            //Assign Current Column
            $column = $columns[$i];
            if (strpos($column, '(') !== false) {

                $typ_val = explode('(', $column);
                $key = $typ_val[0];
                $value = str_replace(')','',$typ_val[1]);

                $type_value[$i] = array("$key" =>"$value");

            }else{
                $type_value[$i] = array("$column" =>null);
            }
        }

        return $type_value;
    }

    /*
    *
    * Generate Auto Forms
    * Pass:
    * - input type
    * - input name
    * - input class
    * - data label
    * - bootstrap col- class (col-md-4) 
    * 
    */
    public function get_auto_form()
    {
        # code...
    }

    /*
    *
    * The Function provide input type of different table data
    * Function accept:
    * Input Data Type
    * 
    */
    public function form_input_type_auto($input_types)
    {

        $inputs = array();

        //Check Inputs And the lenght
        for($i = 0; $i < count($input_types); $i++){

            //Get Array and access Key => Value
            $current = $input_types[$i];
            foreach ($current as $key => $value) {

                //Get Input Bootstrap Class
                $class = $this->get_bootstrap_class($value); 
                $type = $this->get_form_input_type($key); 

                //chek the passed key
                if (strtolower($key) == 'varchar') {
                    $inputs[$i] = array('text' => "$class $type-$i");
                }
                elseif (strtolower($key) == 'datetime') {
                    $inputs[$i] = array('text' => "$class $type-$i");
                }else{
                    $inputs[$i] = array('text' => "$class $type-$i");
                }
            }
        }

        //Return Input Types
        return $inputs;
    }

    /*
    *
    * Get the form input Type
    * FUnction accpet the table data type
    * 
    */
    public function get_form_input_type($type='varchar')
    {
        //Check the input type
        if (strtolower($type) >= 'varchar') {
            $input_type = 'text'; //Input Type
        }
        elseif (strtolower($type) >= 'datetime') {
            $input_type = 'date'; //Input Type
        }
        else{
            $input_type = 'text'; //Input Type
        }

        return $input_type; // Selected Type
    }

    /*
    *
    * Get the input bootstrap class lenght
    * Pass the Data Type Lenght
    * 
    */
    public function get_bootstrap_class($lenght=20)
    {
        //Check the input lenght
        if ($lenght >= 120) {
            $class = 'col-md-12 col-sm-12'; //Data Class
        }
        elseif ($lenght >= 100 && $lenght < 120 ) {
            $class = 'col-md-10 col-sm-12'; //Data Class
        }
        elseif ($lenght >= 80 && $lenght < 100 ) {
            $class = 'col-md-8 col-sm-12'; //Data Class
        }
        elseif ($lenght >= 50 && $lenght < 80 ) {
            $class = 'col-md-6 col-sm-12'; //Data Class
        }
        elseif ($lenght >= 20 && $lenght < 50 ) {
            $class = 'col-md-4 col-sm-12'; //Data Class
        }
        elseif ($lenght >= 10 && $lenght < 20 ) {
            $class = 'col-md-2 col-sm-12'; //Data Class
        }
        else{
            $class = 'col-md-4 col-sm-12'; //Data Class
        }

        return $class; // Selected Class
    }

    /*
    *
    * Form Inputs List
    *  -> Text
    *  -> CheckBox
    *  -> Radio Button
    *  -> Button
    * 
    */
    public function input_text($input_name,$input_type='text',$input_label=null,$col_class='col-md-4 col-sm-12',$id=null)
    {
        //Label
        $label = ucwords((is_null($input_label))? $this->get_label_name($input_name) : $input_label);

        $input ="
                <div class='$col_class'>
                    <div class='form-group'>
                        <div class='fg-line'>
                            <label>$label</label>
                            <input type='$input_type' class='form-control' name='$input_name' id='$id'>
                        </div>
                    </div>
                </div>
        ";

        return $input;
    }

    public function input_checkbox($input_name,$value,$input_label=null,$class='check_box_class',$id=null)
    {
        //Label
        $label = ucwords( (is_null($input_label))? $this->get_label_name($input_name) : $input_label);

        $input ="
            <label class='checkbox checkbox-inline m-r-20'>
                <input type='checkbox' value='$value' name='$input_name' class='$class' id='$id'>
                <i class='input-helper'></i>
                $label
            </label>
        ";

        return $input;
    }

   public function input_radio($input_name,$value,$input_label=null,$class='radio_box_class',$id=null)
   {
        //Label
        $label = ucwords( (is_null($input_label))? $this->get_label_name($input_name) : $input_label);
        
        $input ="
            <label class='radio radio-inline m-r-20'>
                <input type='radio' name='$input_name' value='$value' class='$class' id='$id'>
                <i class='input-helper'></i>
                $label
            </label>
        ";

        return $input;
   }

   public function input_button($input_name='submit',$class='palette-Blue',$size='bg')
   {
        //Label
        $label = ucwords($input_name);
        
        $input ="
                <div class='$col_class'>
                    <button type='submit' class='btn $class $size'>$label</button>
                </div>
        ";

        return $input;
   }

   /*
   *
   * This Fuction should be used mostly with Home Controller
   * Here you pass the page name 
   * And the folder name where your view file is located NB: The value must be an associative array
   *     'Key' -> value
   *     'Key has to be the file name(passed file naem)' => Value has to be the sub folder (directory Name) 
   * 
   */
   public function sub_pages($page_name,$sub_page_route=array(null))
   {
        if (!is_null($sub_page_route)) { //Check if SubRoute Specified
            $if_page = array_keys($sub_page_route); //Check which Page Is Requested
            if (in_array(trim($page_name),$if_page)) {
                $page_route = $sub_page_route[trim($page_name)]; //Get the sub route
                $page = "$page_route/$page_name"; //Set the subroute
            }else{
                $page = $page_name;
            }
        }else{
            $page = $page_name;
        }

        return $page; //Return the route specified
   }

   /////////////////////////////////////////////////////////////////////////////////////////////
   //////////////////////////////  Quick Generated Form             ///////////////////////////
   ///////////////////////////////////////////////////////////////////////////////////////////
   
   /*
   *
   *    Input Text 
   * 
   */
   public function text_input($variable = array('div_class' =>'col-md-4 col-sm-12','div_id' =>'','label' =>'','icon' =>'','type'=>'',
                                                'field_class'=>'','field_name'=>'','field_id'=>''))
   {
        foreach ($variable as $key => $value) { $$key = $value; } //Data Values

        $input ='   
            <div class="$div_class" id="$div_id">
                <div class="form-group">
                    <div class="fg-line">
                        <label> $label;  $icon </label>
                        <input type="$type" class="form-control $field_class" name="$field_name" id="$field_id" autocomplete="off" 
                        value="set_value($field_name)">
                    </div>
                    <span class="error">form_error($field_name)</span>
                </div>
            </div>
        ';

        //Return Input
        return $input;
   }

}

/* End of file CoreForm.php */
/* Location: ./application/models/CoreForm.php */