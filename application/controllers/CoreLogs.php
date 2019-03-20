<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreLogs extends CI_Controller {

	/*
	*
	* The main controller for Administrator Backend
	* -> The controller require user to login as Administrator
	*/

	private $Core = 'core'; //Lite
	private $Module = 'user'; //Module
	private $Folder = '/* HTML Source Folder Name */'; //Set Default Folder For html files
	private $SubFolder = ''; //Set Default Sub Folder For html files and Front End Use Start with /

	private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

	private $Route = null; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default

	private $New = 'admin/login'; //New Login
	private $Save = ''; //Add New User
	private $Edit = 'admin/reset'; //Update Password

	private $ModuleName = 'user'; //Module Nmae

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
		$data['Module'] = $this->plural->pluralize($this->Module);//Module Show
		$data['routeURL'] = (is_null($this->Route)) ? $this->plural->pluralize($this->Folder) : $this->Route;

		//Module Name - For Forms Title
		$data['ModuleName'] = $this->plural->pluralize($this->ModuleName);

		//Form Submit URLs
		$data['form_new'] = $this->New;
		$data['form_save'] = $this->Save;
		$data['form_edit'] = $this->Edit;

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
    public function pages($data,$layout='log')
    {

		//Layout
		$this->load->view("administrator/layouts/$layout",$data);

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
		$data = $this->load("login");

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
	public function open($pageID,$message=null,$layout='log')
	{

		//Pluralize Module
		$module = $this->plural->pluralize($this->Module);

		//Model Query
		$pageID = (is_numeric($pageID)) ? $pageID : $this->plural->pluralize($this->Folder).$this->SubFolder."/".$pageID;
		$data = $this->load($pageID);

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
		$routeURL = (is_null($this->Route)) ? $module : $this->Route;

		//Set Allowed Files
		$allowed_files = (is_null($this->AllowedFile))? 'jpg|jpeg|png|doc|docx|pdf|xls|txt' : $this->AllowedFile;

		//Check Validation
		if ($type == 'login') {

			$formData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("user_logname", "Logname", "trim|required|min_length[1]");
			$this->form_validation->set_rules("user_password", "Password", "trim|required|min_length[1]");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				if ($this->login($formData) == 'success') {
					$this->session->set_flashdata('notification','notify'); //Notification Type
					redirect("dashboard","refresh");//Redirect to Page
				}elseif ($this->login($formData) == 'wrong') {
					$this->session->set_flashdata('notification','error'); //Notification Type
					$message = 'Failed!, wrong password or username'; //Notification Message				
					$this->index($message);//Open Page
				}elseif ($this->login($formData) == 'deactivated') {
					$this->session->set_flashdata('notification','error'); //Notification Type
					$message = 'Failed!, your account is suspended'; //Notification Message				
					$this->index($message);//Open Page
				}
				else{
					$this->session->set_flashdata('notification','error'); //Notification Type
					$message = 'Failed!, account does not exist'; //Notification Message				
					$this->index($message);//Open Page
				}
			}else{
				$this->session->set_flashdata('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->index($message);//Open Page
			}			
		}elseif ($type == 'reset') {
			$this->session->set_flashdata('notification','error'); //Notification Type
			$message = 'Sorry!, reset password will be available later'; //Notification Message				
			$this->index($message);//Open Page
		}
		elseif ($type == 'logout') {
			$this->session->sess_destroy();//User Logout
			$this->index();//Open Page
		}
		else{
			$this->session->set_flashdata('notification','notify'); //Notification Type
			$this->index();//Open Page
		}
	}

	/*
	*
	* Fuction for Login Validation
	* The fuction takes, accept form data which passed through CoreLoad Input
	* 
	*/
	public function login($formData)
	{
		//Pluralize Module
		$tableName = $this->plural->pluralize($this->Module);
		$column_logname = $this->CoreForm->get_column_name($this->Module,'logname'); //Logname Column
		$column_password = $this->CoreForm->get_column_name($this->Module,'password'); //Password Column
		$column_stamp = $this->CoreForm->get_column_name($this->Module,'stamp'); //Stamp Column
		$column_level = $this->CoreForm->get_column_name($this->Module,'level'); //Stamp Level
		$column_flg = $this->CoreForm->get_column_name($this->Module,'flg'); //Stamp FLG
		$column_id = $this->CoreForm->get_column_name($this->Module,'id'); //Stamp ID

		//Get Array Data
		foreach ($formData as $key => $value) {
			if (strtolower($key) == $column_logname) {
				$logname = $value; //Set user logname
			}else{
				$password = $value; //Set user Password
			}
		}

		//Get Date Time
		$result = $this->db->select($column_stamp)->from($tableName)->where($column_logname,$logname)->limit(1)->get();
		if ($result->num_rows() === 1) {

			$row = $result->row();
			$stamp = $row->$column_stamp; //Date Time

			//Check If Enabled
			if ($this->db->select($column_flg)->where($column_logname,$logname)->get($tableName)->row()->$column_flg) {			
				$hased_password = sha1($this->config->item($stamp).$password);//Hashed Password
				$where = array($column_logname => $logname, $column_password => $hased_password); // Where Clause
				$query = $this->db->select("$column_id, $column_level")->where($where)->limit(1)->get($tableName)->result(); //Set Query Select

				if ($query) {							
					$newsession = array('id'=>$query[0]->$column_id,'level'=>$query[0]->$column_level,'logged'=>TRUE); //Set Session Data
					$this->session->set_userdata($newsession); //Create Session
					return 'success'; //Logged In
				}else{
					return 'wrong'; //Wrong Account Password / Logname
				}
			}else{
				return 'deactivated'; //Account Deactivated
			}
		}else{
			return 'error'; //Account Don't Exist
		}
	}

	/*
	*
	* This Fuction is used to validate File Input Data
	* The fuctntion accept one parameters
	* 1: This parameter does not required to be passed, Codeigniter will handle that
	*
	* --> Access session containing the Input Name ( $_FILR['this_name']) & required option 
	* --> before validating using this method.. 
	* 
	* -> Set Session
	*  $file_upload_session = array("file_name" => "input_name", "file_required" => true)
	*  $this->session->set_userdata($file_upload_session);
	*
	* N.B For custom validation add session $this->session->set_userdata("file_rule","identifier");
	* the check with comparison/conditional operator under else statement
	*
	*/
    public function validation($value){

    	//Used Session Key ID/Name
    	$session_keys = array('file_rule','file_name','file_required');

    	//Check Which Rule To Apply
    	if (!isset($this->session->file_rule) || empty($this->session->file_rule) || is_null($this->session->file_rule)) {

	    	// Get Allowed File Extension
	    	$allowed_extension = (!is_null($this->AllowedFile))? $this->AllowedFile : 'jpg|jpeg|png|doc|docx|pdf|xls|txt';
	    	$allowed_extension_array = explode('|',$allowed_extension);

	        $file_name = $this->session->file_name; //Upload File Name
			$file_requred = (!isset($this->session->file_required))? true : $this->session->file_required; //Check if file is requred

	        //Loop through uploaded values
	        for ($i=0; $i < count($_FILES[$file_name]['name']); $i++) {

	        	$file = $_FILES[$file_name]['name'][$i]; //Current Selected File
		        if(isset($file) && !empty($file) && !is_null($file)){

					$file_ext = pathinfo($file, PATHINFO_EXTENSION); //Get current file extension

					//Check If file extension allowed
		            if(in_array($file_ext, $allowed_extension_array)){
		                $validation_status[$i] = true; //Succeeded
		            }else{
		                $validation_status[$i] = false; //Error
		            }
		        }else{
		        	//Input Is Blank... So check if it is requred
		        	if ($file_requred == TRUE) {
			            $validation_status[$i] = 'empty'; //Error Input required
		        	}else{
		                $validation_status[$i] = true; //Succeeded , This input is allowed to be empty
		        	}
		        }
	        }

	        //Check If any validated value has an error
	        if (in_array('empty',$validation_status, true)) {
			    $this->form_validation->set_message('validation', 'Please choose a file to upload.');

	        	$this->CoreCrud->destroySession($session_keys); //Destroy Session Values
	        	return false; // Validation has an error, Input is required and is set to empty
	        }
	        elseif (in_array(false,$validation_status, true)) {
		        $this->form_validation->set_message("validation", "Please select only ".str_replace('|',',',$allowed_extension)." file(s).");

	        	$this->CoreCrud->destroySession($session_keys); //Destroy Session Values
	        	return false; // Validation has an error
	        }
	        else{

	        	$this->CoreCrud->destroySession($session_keys); //Destroy Session Values
	        	return true; // Validation was successful
	        }
	    }else{

	    	/* Your custom Validation Code Here */

	    	//Before returning validation status destroy session
	        $this->CoreCrud->destroySession($session_keys); //Destroy Session Values
	    }
    }

}

/* End of file CoreLogs.php */
/* Location: ./application/controllers/CoreLogs.php */