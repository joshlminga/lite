<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreField extends CI_Model {

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
	* Get Parent - Child herachy
	* 
	*/
	public function allign_children($parentChild)
	{
		if (!empty($parentChild) && !is_null($parentChild)) {			
			foreach ($parentChild as $key => $value) {
				if (strpos($value, ',') !== false) { $data = explode(",",$value); }
				else{ $data = array($value); }
				for($i = 0; $i < count($data); $i++){ $list[$key][$i] = $data[$i]; }
			} return $list;
		}else{ return null; }
	}

}

/* End of file CoreField.php */
/* Location: ./application/models/CoreField.php */