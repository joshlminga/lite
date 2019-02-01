<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreSettings extends CI_Controller {

	/*
	*
	* The main controller for Administrator Backend
	* -> The controller require user to login as Administrator
	*/

	private $Core = 'core'; //Core Lite Base Name | Change this if your Controller Name does not start with word Core
	private $Module = 'setting'; //Module
	private $Folder = 'setting'; //Set Default Folder For html files setting
	private $SubFolder = ''; //Set Default Sub Folder For html files and Front End Use Start with /
	private $Escape = 'id,stamp,flg'; // Escape Column
	private $Require = ''; // Required Column
	private $Unique = ''; // Unique & Required Values

	private $Route = null; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default

	private $General = 'general/update'; //Update Settings
	private $Link = 'link/update'; //Add New User
	private $Mail = 'mail/update'; //Update User
	private $Blog = 'blog/update'; //Update User
	private $Seo = 'seo/update'; //Update User

	private $ModuleName = 'settings'; //Module Nmae

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
	* Access Requred pre-loaded data
	* The additional Model based data are applied here from passed function and join with load function
	* The pageID variable can be left as null if you do not wish to access Meta Data values
	* Initially what is passed is a pageID or Page Template Name
	* 
	*/
	public function load($pageID=null)
	{

		//Model

		//Model Query
		$data = $this->CoreLoad->open($pageID);
		$passed = $this->passed();
		$data = array_merge($data,$passed);

		return $data;
	}

	/*
	*
	* Load the model/controller based data here
	* The data loaded here does not affect the other models/controller/views
	* It only can reach and expand to this controller only
	* 
	*/
	public function passed($values=null)
	{

		//Time Zone
		date_default_timezone_set('Africa/Nairobi');
		$data['str_to_time'] = strtotime(date('Y-m-d, H:i:s'));
		$data['Module'] = $this->plural->pluralize($this->Folder);//Module Show
		$data['routeURL'] = (is_null($this->Route)) ? $this->plural->pluralize($this->Folder) : $this->Route;

		//Module Name - For Forms Title
		$data['ModuleName'] = $this->plural->pluralize($this->ModuleName);

		//Form Submit URLs
		$data['form_general'] = $this->General;
		$data['form_link'] = $this->Link;
		$data['form_mail'] = $this->Mail;
		$data['form_blog'] = $this->Blog;
		$data['form_seo'] = $this->Seo;

		return $data;
	}

	/*
	*
	* This is one of the most important functions in your project
	* All pages used by this controller should be opened using pages function
	* 1: The first passed data is an array containing all pre-loaded data N.B it can't be empty becuase page name is passed through it
	* 2: Layout -> this can be set to default so it can open a particular layout always | also you can pass other layout N.B can't be empty
	*
	* ** To some page functions which are not public, use the auth method from CoreLoad model to check is user is allowed to access the pages
	* ** If your page is public ignore the use of auth method
	* 
	*/
    public function pages($data,$layout='main')
    {
    	//Chech allowed Access
		if ($this->CoreLoad->auth($this->Module)) { //Authentication
			//Layout
			$this->load->view("administrator/layouts/$layout",$data);
		}else{
			$this->CoreLoad->notAllowed(); //Not Allowed To Access
		}
    }

    /*
    *
    * This is the first function to be accessed when a user open this controller
    * In here we can call the load function and pass data to passed as an array inorder to manupulate it inside passed function
    * 	* Set your Page name/ID here N:B Page ID can be a number if you wish to access other values linked to the page opened E.g Meta Data
    * 	* You can also set Page ID as actual pageName found in your view N:B do not put .php E.g home.php it should just be 'home'
    * 	* Set Page template 
    * 	* Set Notification here
    * 	By Default index does not allow notification Message to be passed, it uses the default message howevr you can pass using the notifyMessage variable
    * 	However we advise to use custom notification message while opening index utilize another function called open
	* 
    */
	public function index($notifyMessage=null)
	{
		//Pluralize Module
		$module = $this->plural->pluralize($this->Module);

		//Model Query
		$data = $this->load($this->plural->pluralize($this->Folder).$this->SubFolder."/list");

		//Table Select & Clause
		$where = array('level !=' => 'customer');
	   	$columns = array('id,level as level,logname as username,name as full_name,email as email,flg as status');
		$data['dataList'] = $this->CoreCrud->selectCRUD($module,$where,$columns);

		//Notification
		$notify = $this->CoreNotify->notify();
		$data['notify'] = $this->CoreNotify->$notify($notifyMessage);

		//Open Page
		$this->pages($data);		
	}

    /*
    *
    * This is the function to be accessed when a user want to open specific page which deals with same controller E.g Edit data after saving
    * In here we can call the load function and pass data to passed as an array inorder to manupulate it inside passed function
    * 	* Set your Page name/ID here N:B Page ID can be a number if you wish to access other values linked to the page opened E.g Meta Data
    * 	* You can also set Page ID as actual pageName found in your view N:B do not put .php E.g home.php it should just be 'home'
    * 	* Set Page template 
    * 	* Set Notification here
    * 	Custom notification message can be set/passed via $message
    * 	PageName / ID can be passed via $pageID
    * 	Page layout can be passed via $layout
	* 
    */
	public function open($pageID,$message=null,$layout='main')
	{

		//Pluralize Module
		$module = $this->plural->pluralize($this->Module);

		//Model Query
		$pageID = (is_numeric($pageID)) ? $pageID : $this->plural->pluralize($this->Folder).$this->SubFolder."/".$pageID;
		$data = $this->load($pageID);

		//Data
		$data['resultList'] = $this->load_settings($pageID);

		//Notification
		$notify = $this->CoreNotify->notify();
		$data['notify'] = $this->CoreNotify->$notify($message);

		//Open Page
		$this->pages($data,$layout);
	}

	/*
	*
	* Module form values are validated here
	* The function accept variable TYPE which is used to know which form element to validate by changing the validation methods
	* All input related to this Module or controller should be validated here and passed to Create/Update/Delete
	*
	* Reidrect Main : Main is the controller which is acting as the default Controller (read more on codeigniter manual : route section) | inshort it will load 
	* 				 first and most used to display the site/system home page
	* 
	*/
	public function valid($type)
	{

		//Pluralize Module
		$module = $this->plural->pluralize($this->Module);
		$coreModule = ucwords($this->Core).ucwords($module);
		$routeURL = (is_null($this->Route)) ? $module : $this->Route;

		//Check Validation
		if ($type == 'general') {

			$updateData = $this->CoreLoad->input(); //Input Data
			//Validation Data
			$validData['site_title'] = "required|min_length[1]|max_length[800]"; //Validate Data Rules
			$validData['site_slogan'] = "required|min_length[1]|max_length[800]"; //Validate Data 
			$validData['site_status'] = "required|min_length[1]|max_length[10]"; //Validate Data Rules

			//Form Validation
			if ($this->validation($updateData,$validData) == TRUE) {
				if ($this->update($updateData)) {
					$this->session->set_flashdata('notification','success'); //Notification Type
					$this->open($type);//Redirect to Page
				}else{
					$this->session->set_flashdata('notification','error'); //Notification Type
					$this->open($type);//Open Page
				}
			}else{
				$this->session->set_flashdata('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type,$message);//Open Page
			}			
		}
		elseif ($type == 'link') {

			$updateData = $this->CoreLoad->input(); //Input Data
			//Validation Data
			$validData['current_url'] = "required|min_length[1]|max_length[50]"; //Validate Data Rules

			//Form Validation
			if ($this->validation($updateData,$validData) == TRUE) {
				if ($this->update($updateData)) {

					//Update URL
					$postTitle = $this->db->select('newspost_id')->get('newsposts');
					$postData = $postTitle->result();

					foreach ($postData as $row) {
						$post_id = $row->newspost_id; //Post ID
						$url = $this->CoreCrud->postURL($post_id);

					    $sql = "UPDATE `newsposts` SET `newspost_url` = '$url' WHERE  `newspost_id` = '$post_id' ";
					    $results = $this->db->query($sql);//site_title
					}

					$this->session->set_flashdata('notification','success'); //Notification Type
					$this->open($type);//Redirect to Page
				}else{
					$this->session->set_flashdata('notification','error'); //Notification Type
					$this->open($type);//Open Page
				}
			}else{
				$this->session->set_flashdata('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type,$message);//Open Page
			}			
		}elseif ($type == 'mail') {

			$updateData = $this->CoreLoad->input(); //Input Data
			//Validation Data
			$validData['mail_protocol'] = "required|min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['smtp_host'] = "min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['smtp_user'] = "min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['smtp_pass'] = "min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['smtp_port'] = "integer|min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['smtp_timeout'] = "integer|min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['smtp_crypto'] = "min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['wordwrap'] = "required|min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['wrapchars'] = "required|integer|min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['mailtype'] = "required|min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['charset'] = "required|min_length[1]|max_length[50]"; //Validate Data Rules

			//Form Validation
			if ($this->validation($updateData,$validData) == TRUE) {
				if ($this->update($updateData)) {
					$this->session->set_flashdata('notification','success'); //Notification Type
					$this->open($type);//Redirect to Page
				}else{
					$this->session->set_flashdata('notification','error'); //Notification Type
					$this->open($type);//Open Page
				}
			}else{
				$this->session->set_flashdata('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type,$message);//Open Page
			}			
		}elseif ($type == 'mail') {

			$updateData = $this->CoreLoad->input(); //Input Data
			//Validation Data
			$validData['home_display'] = "required|min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['home_post'] = "min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['home_page'] = "min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['post_per_page'] = "required|integer|min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['post_show'] = "required|min_length[1]|max_length[50]"; //Validate Data Rules

			//Form Validation
			if ($this->validation($updateData,$validData) == TRUE) {
				if ($this->update($updateData)) {
					$this->session->set_flashdata('notification','success'); //Notification Type
					$this->open($type);//Redirect to Page
				}else{
					$this->session->set_flashdata('notification','error'); //Notification Type
					$this->open($type);//Open Page
				}
			}else{
				$this->session->set_flashdata('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type,$message);//Open Page
			}
		}elseif ($type == 'seo') {

			$updateData = $this->CoreLoad->input(); //Input Data
			//Validation Data
			$validData['seo_visibility'] = "required|min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['seo_global'] = "required|min_length[1]|max_length[50]"; //Validate Data Rules
			$validData['seo_description'] = "max_length[8000]"; //Validate Data Rules
			$validData['seo_description'] = "max_length[8000]"; //Validate Data Rules
			$validData['seo_keywords'] = "max_length[8000]"; //Validate Data Rules

			//Form Validation
			if ($this->validation($updateData,$validData) == TRUE) {
				if ($this->update($updateData)) {
					$this->session->set_flashdata('notification','success'); //Notification Type
					$this->open($type);//Redirect to Page
				}else{
					$this->session->set_flashdata('notification','error'); //Notification Type
					$this->open($type);//Open Page
				}
			}else{
				$this->session->set_flashdata('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type,$message);//Open Page
			}
		}else{
			$this->session->set_flashdata('notification','notify'); //Notification Type
			$this->index(); //Redirect Index Module
		}
	}

	/*
	* The function is used to update data in the table
	* First parameter is the data to be updated 
	*  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
	*      the array key will be used as column name and the value as inputted Data
	* 
	*/
	public function update($updateData)
	{

    	//Chech allowed Access
		if ($this->CoreLoad->auth($this->Module)) { //Authentication

			//Pluralize Module
			$tableName = $this->plural->pluralize($this->Module);

			//Update Data In The Table
			foreach ($updateData as $key => $value) {
			    $sql = "UPDATE `$tableName` SET `setting_value` = '$value' WHERE  `setting_title` = '$key' ";
			    $results = $this->db->query($sql);//site_title
			}

			if ($results) {
				
				return true; //Data Updated
			}else{

				return false; //Data Updated Failed
			}
		}
	}

	/*
	*
	* This Fuction is used to validate Input Data
	* The fuctntion accept three parameters
	* 1: The Form Data (Remember to pass them trought CoreLoad->input First)
	* 2: Should Email considered Unique or not
	* 3: Skip Deep Validation
	* 
	*/
	public function validation($formData,$validate=array(),$skip=array())
	{
		//Validation Keys
		$valid_keys = array_keys($validate);
		$check_box = 1;

		//Validation
		foreach ($formData as $key => $value) {
			$label = $this->CoreForm->get_column_label_name($key); // Label Name
			$input = $this->CoreForm->get_label_name($key); // Input Processed
			//Check Skip
			if (in_array(strtolower($key),$skip)) {				
				$this->form_validation->set_rules($key, $label, "trim|max_length[100]"); //Validate Input
			}else{
				if (empty($validate)) {
					$this->form_validation->set_rules($key, $label, "trim");//Clean None Required Values
				}else{					
					if (in_array('check_box', $valid_keys) && $check_box == 1) {
						$check_valid = $validate['check_box'];//Validate Inputs
						$this->form_validation->set_rules('check_box', 'Input', "trim|$check_valid"); //Validate Email
						$check_box = 0;
					}else{
						if (in_array($key, $valid_keys)) {
							$check_valid = $validate[$key];//Validate Inputs
							$this->form_validation->set_rules($key, $label, "trim|$check_valid"); //Validate Email
						}else{
							$this->form_validation->set_rules($key, $label, "trim");//Clean None Required Values
						}
					}
				}
			}
		}
		//Check If Validation was successful
		if ($this->form_validation->run() == TRUE) {
			return true;
		}else{
			return false;
		}
	}

	/*
	*
	* Check Which Settings Type To Open
	* Pass the Page Name
	*/
	public function load_settings($page_name)
	{
		//Set Condition
		$where = array('setting_flg' =>1);
		$page = explode('/',$page_name);

		if (end($page) == 'general') {
			$where_in = array('site_title','site_slogan','site_status','offline_message');//General Update
		}elseif (end($page) == 'link') {
			$where_in = array('current_url');//General Update
		}elseif (end($page) == 'mail') {
			$where_in = array('mail_protocol','smtp_host','smtp_user','smtp_pass','smtp_port','smtp_timeout','smtp_crypto',
			'wordwrap','wrapchars','mailtype','charset');//General Update
		}elseif (end($page) == 'blog') {
			$where_in = array('home_display','home_post','home_page','post_per_page','post_show');//General Update
		}elseif (end($page) == 'seo') {
			$where_in = array('seo_visibility','seo_keywords','seo_description ','seo_global','seo_meta_data');//General Update
		}else{
			$where_in = array('none');//General Update
		}

		//Search Data
		$resultList = $this->db->select('setting_title,setting_value')->where($where)
		              ->where_in('setting_title',$where_in)->get('settings');

		//Data Returned
		return $resultList->result();
	}

}

/* End of file CoreUsers.php */
/* Location: ./application/controllers/CoreUsers.php */