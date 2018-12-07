<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjaxList extends CI_Controller {

	/* Functions
	* -> __construct () = Load the most required operations E.g Class Module
	* 
	*/
	public function __construct()
	{
		parent::__construct();

		//Libraries
		$this->load->library('form_validation');
		$this->load->model('CoreCrud');
		$this->load->model('CoreForm');

		//Helpers
		date_default_timezone_set('Africa/Nairobi');

        //Models
        
	}

	/*
	*
	* Category List
	* 
	*/
	public function categories()
	{

		$category = $this->CoreLoad->input('categoryNAME'); //Input Data Categories

		$where = array('fieldcustom_flg' =>1,'fieldcustom_type' =>'Categories','fieldcustom_parent' =>$category);
		$subcategories = $this->db->select('fieldcustom_child')->where($where)->get('fieldcustoms')->result();
		// $sub_categories = json_decode($subcategories, True);
		
		if (array_key_exists(0, $subcategories)) {
			$sub_categories = json_decode($subcategories[0]->fieldcustom_child, True);
			foreach ($sub_categories['sub_category'] as $key => $value){

				echo '	<label class="checkbox checkbox-inline m-r-20">
						<input type="checkbox" value="'.trim(stripcslashes($value)).'" name="sub_categories[]">
						<i class="input-helper"></i>'.
						ucwords(stripcslashes($value)).
						'</label>';
			}
		}else{
			echo "<p> Selected category has no subcategory </p>";
		}
	}
}

/* End of file AjaxList.php */
/* Location: ./application/controllers/AjaxList.php */