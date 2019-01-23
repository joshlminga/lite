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
	private $Escape = ''; // Escape Column
	private $Require = 'logname,password'; // Required Column
	private $Unique = ''; // Unique & Required Values

	private $Route = null; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default

	private $New = 'admin/login'; //New Login
	private $Save = ''; //Add New User
	private $Edit = 'admin/reset'; //Update Password

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

		//Check Validation
		if ($type == 'login') {

			$formData = $this->CoreLoad->input(); //Input Data

			//Form Validation
			if ($this->validation($formData) == TRUE) {
				if ($this->login($formData) == 'success') {
					$this->session->set_flashdata('notification','notify'); //Notification Type
					redirect("dashboard","refresh");//Redirect to Page
				}elseif ($this->login($formData) == 'wrong') {
					$this->session->set_flashdata('notification','error'); //Notification Type
					$message = 'Failed!, wrong password or username'; //Notification Message				
					$this->index($message);//Open Page
				}
				else{
					$this->session->set_flashdata('notification','error'); //Notification Type
					$message = 'Failed!, your account is suspended'; //Notification Message				
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
		$stamp = $this->db->select($column_stamp)->where($column_logname,$logname)->get($tableName)->row()->$column_stamp;

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
	public function validation($formData,$email=TRUE,$skip=array())
	{
		//Pluralize Module
		$module = $this->plural->pluralize($this->Module);

		//Validation
		foreach ($formData as $key => $value) {
			$label = $this->CoreForm->get_column_label_name($key); // Label Name
			$input = $this->CoreForm->get_label_name($key); // Input Processed
			//Check Skip
			if (in_array(strtolower($key),$skip)) {				
				$this->form_validation->set_rules($key, $label, "trim|max_length[100]"); //Validate Input
			}else{
				if (strtolower($input) == 'email') {
					if ($email == TRUE) {
						$this->form_validation->set_rules($key, $label, "trim|required|max_length[100]|valid_email|is_unique[$module.$key]"); //Validate Email
					}else{
						$this->form_validation->set_rules($key, $label, "trim|required|max_length[100]|valid_email"); //Validate Email
					}
				}else{
					$required = explode(',',strtolower($this->Require)); //Required Columns
					$unique = explode(',',strtolower($this->Unique)); //Unique Columns
					if (in_array($input, $required)) {
						$this->form_validation->set_rules($key, $label, "trim|required|min_length[1]"); //Validate Required
					}elseif (in_array($input, $unique)) {
						$this->form_validation->set_rules($key, $label, "trim|required|min_length[1]|is_unique[$module.$key]"); //Validate Required
					}else{
						$this->form_validation->set_rules($key, $label, "trim");//Clean None Required Values
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

}

/* End of file CoreLogs.php */
/* Location: ./application/controllers/CoreLogs.php */