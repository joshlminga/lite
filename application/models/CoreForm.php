<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreForm extends CI_Model {


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
    * The function generate proper multiple/single column names
    * The function accepts
    * 1: Module Name
    * 2: Column simple name(s)
    * 
    */
    public function get_column_name($module,$column)
    {
        //Singularize Module
        $module = $this->plural->singularize($module);

        if (!is_array($column) && strpos($column,",") == False) {
            $column_name = $module.'_'.$column; //Column Name
        }else{
            if (!is_array($column) && strpos($column,",") == True) { $column = explode(",", $column); /* Get Column Name */ }
            for($i = 0; $i < count($column); $i++){
                $column_name[$i] = $this->get_column_name($module,$column[$i]); //Column Name
            }
        }

        return $column_name; //Column Name
    }

    /*
    *
    * Function to remove column Name and Return Label Name
    * Pass columns name(s) array/string
    * 
    */
    public function get_label_name($column)
    {
        //Check If Value Passed is Not Array
        if (!is_array($column) && strpos($column,",") == False) {
            $label =  substr($column,strpos($column, "_") +1); //Get Current Label Name
        }else{            
            if (!is_array($column) && strpos($column,",") == True) { $column = explode(",", $column); /* Get Column Name */ }
            //Remove Module Name
            for($i = 0; $i < count($column); $i++){
                $column_name = $column[$i]; //Set Current Column Name
                $label[$i] =  substr($column_name,strpos($column_name, "_") +1); //Get Current Label Name
            }
        }
        
        return $label;//Return Label List
    }

    /*
    *
    * Function to remove column Name and Return Column Label Name
    * Pass columns name(s) array/string
    * 
    */
    public function get_column_label_name($column)
    {

        if (!is_array($column) && strpos($column,",") == False) {
            $column_label = ucwords(str_replace('_',' ',$column));
        }else{
            if (!is_array($column) && strpos($column,",") == True) { $column = explode(",", $column); /* Get Column Name */ }
            for($i = 0; $i < count($column); $i++){
                $column_name = $column[$i]; //Set Current Column Name
                $column_label[$i] =  ucwords(str_replace('_',' ',$column_name)); //Get Current Column Label Name
            }
        }

        return $column_label; //Column Label Name
    }

    /*
    *
    * Set Validation Session Data
    *
    * This function allow you to change validation Session Data with Ease during validation Process
    * This function accept
    *
    * Session Data as Array=>Key
    * 
    */
    public function validation_session($validation)
    {
        //Set Session Data
        $filename = (array_key_exists("file_name",$validation))? $validation['file_name'] : $this->session->file_name; //File Name
        $required = (array_key_exists("file_required",$validation))? $validation['file_required'] : $this->session->file_required; //Required

        //Set Upload File Values
        $file_upload_session = array('file_name'=>$filename,'file_required'=>$required);
        $this->session->set_userdata($file_upload_session);
    }

    
}

/* End of file CoreForm.php */
/* Location: ./application/models/CoreForm.php */