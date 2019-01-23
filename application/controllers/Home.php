<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/*
	*
	* The main controller for Administrator Backend
	* -> The controller require to login as Administrator
	*/

	private $Core = ''; //Lite Main Core
	private $Module = ''; //Module
	private $Folder = ''; //Set Default Folder For html files and Front End Use
	private $SubFolder = ''; //Set Default Sub Folder For html files and Front End Use Start with /
	private $Escape = ''; // Escape Column For Form Auto Generating
	private $Require = ''; // Required Column During Form Validation
	private $Unique = ''; // Unique & Required Values During Form Validation

	private $Route = ''; //If you have different route Name to Module name State it here |This wont be pluralized

	private $New = ''; //New 
	private $Save = ''; //Add New 
	private $Edit = ''; //Update 

	private $ModuleName = '';
	private $Theme = 'starter';

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
		$this->load->model('CoreData');

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

		$passed = $this->passed(); //Passed Data

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
		$data['Module'] = $this->plural->pluralize($this->Route);//Module Show
		$data['routeURL'] = (is_null($this->Route)) ? $this->plural->pluralize($this->Folder) : $this->Route;
		$data['assets'] = 'assets/themes/starter';

		//Article
		$data['pages'] = $this->db->select('page_title,page_post')->from('pages')
						->where('page_flg',1)
			            ->get()->result();

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
	* ** To some page functions which are not public, use the auth method from CoreLoad model to check  is allowed to access the pages
	* ** If your page is public ignore the use of auth method
	* 
	*/
    public function pages($data,$layout='main')
    {
    	//Check if site is online
    	if ($this->CoreLoad->site_status() == TRUE) {
			//Layout
			$this->load->view("themes/$this->Theme/layouts/$layout",$data);
    	}else{
    		$this->CoreLoad->siteOffline(); //Site is offline
    	}
    }

    /*
    *
    * This is the first function to be accessed when  open this controller
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
		//Model Query
		$data = $this->load('home');

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

		//Model Query $this->SubFolder
		$pageID = (is_numeric($pageID)) ? $pageID : $pageID;
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

		//Check Validation
		if ($type == 'some condintion') {

		}
		else{
			$this->session->set_flashdata('notification','notify'); //Notification Type
			$this->index(); //Index Page
		}
	}

	/*
	* The function is used to save/insert data into table
	* First is the data to be inserted 
	*  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
	*      the array key will be used as column name and the value as inputted Data
	*  For colum default/details convert data to JSON on valid() method level
	* Second Value is Table Name to be Affected NB: Table will be pluralized
	* Third is the data to be unset | Unset is to be used if some of the input you wish to be removed
	* 
	*/
	public function create($insertData,$tableName,$unsetData=null)
	{
		//Pluralize Module
		$tableName = $this->plural->pluralize($tableName);
		$Module = $this->plural->singularize($tableName);

		//Column Stamp
		$stamp = strtolower($this->CoreForm->get_column_name($Module,'stamp'));
		$insertData["$stamp"] = date('Y-m-d H:i:s',time());
		//Column Flg
		$flg = strtolower($this->CoreForm->get_column_name($Module,'flg'));
		$insertData["$flg"] = 1;

		//Column Password
		$column_password = strtolower($this->CoreForm->get_column_name($Module,'password'));

		$insertData = $this->CoreLoad->unsetData($insertData,$unsetData); //Unset Data

		//Check IF there is Password
		if (array_key_exists($column_password,$insertData)) {
			$insertData[$column_password] = sha1($this->config->item($insertData["$stamp"]).$insertData[$column_password]);
		}

		$details = strtolower($this->CoreForm->get_column_name($Module,'details'));
		$insertData["$details"] = json_encode($insertData);

		//Insert Data Into Table
		$this->db->insert($tableName, $insertData);
		if ($this->db->affected_rows() > 0) {
			
			return true; //Data Inserted
		}else{

			return false; //Data Insert Failed
		}
	}

	/*
	*
	* This is function is for searching Data
	* Here we pass Category name
	* Area / Location to look for 
	* 
	*/
	public function searchData($category,$location,$subCategory=null)
	{

		//Get Business
		$where = array('column_flg' =>1,'column to look' =>'value to match');
		$business = $this->db->select('select_data1,select_data2')->where($where)->get('table')->result();

		return $business;
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

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */