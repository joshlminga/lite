<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// This is an exampleof a Core Lite controller methods/functions
// Do not name your controller class name starting with underscore or small-caps
// If I want to  create this controller of use and not data demonstration I will name is as:
//  BaseController or Basecontroller 
//  AND save it as:
//  BaseController.php or Basecontroller.php
class _baseController extends CI_Controller {

	/*
	*
	* The main controller for Administrator Backend
	* -> The controller require user to login as Administrator
	*/

	/* Functions
	* -> __construct () = Load the most required operations E.g Class Module
	* 
	*/
	public function __construct()
	{
		parent::__construct();

		//Libraries
		$this->load->library('form_validation');

		//Helpers
		
        //Models
        
	}

	/*
	*
	* Access Requred pre-loaded data
	* The additional Model based data are applied here from passed function and join with load function
	* The page variable can be left as null if you do not wish to access Meta Data values
	* Initially what is passed is a pageID or Page Template Name
	* 
	*/
	public function load($page=null)
	{

		//Model

		//Model Query
		$data = $this->CoreLoad->open($page);
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
		// $auth = 'check if authentication is true'; //Authentication

		// if ($this->CoreLoad->auth($module='admin')) {

			//Layout
			$this->load->view("administrator/layouts/$layout",$data);

		// }else{

		// 	echo 'if failed say not allowed';
		// }
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

		//Model Query
		$data = $this->load('dashboard');

		//Notification
		$notify = $this->Notify->notify();
		$data['notify'] = $this->Notify->$notify($notifyMessage);

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
	public function open($message=null,$pageID=null,$layout=null)
	{

		//Model Query
		$data = $this->load($pageID);

		//Notification
		$notify = $this->Notify->notify();
		$data['notify'] = $this->Notify->$notify($message);

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

		//Check Validation
		if ($type == 'check Value if true') {

		}
		else{

			//Open Index
			redirect('Main','refresh');
		}
	}

	/*
	* The function is used to save/insert data into table
	* The first parameter needed is Table Name
	* Second one is the data to be inserted 
	*  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
	*      the array key will be used as column name and the value as inputted Data
	*  For colum default/details convert data to JSON on valid() method level
	*
	* Third is the data to be unset | Unset is to be used if some of the input you wish to be removed
	* 
	*/
	public function create($tableName,$insertData,$unsetData=null)
	{
		
		$insertData = $this->CoreLoad->unsetData($insertData,$unsetData); //Unset Data

		//Insert Data Into Table
		$this->db->insert($tableName, $insertData);
		if ($this->db->affected_rows() > 0) {
			
			return true; //Data Inserted
		}else{

			return false; //Data Insert Failed
		}
	}

	/*
	* The function is used to update data in the table
	* The first parameter needed is Table Name
	* Second one is the data to be updated 
	*  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
	*      the array key will be used as column name and the value as inputted Data
	*  For colum default/details convert data to JSON on valid() method level
	* Third is the values to be passed in where clause N:B the data needed to be in an associative array form E.g $data = array('column' => 'value');
	* Fourth is the data to be unset | Unset is to be used if some of the input you wish to be removed
	* 
	*/
	public function update($tableName,$updateData,$valueWhere,$unsetData=null)
	{
		
		$updateData = $this->CoreLoad->unsetData($updateData,$unsetData); //Unset Data

		//Update Data In The Table
		$this->db->update($tableName, $updateData, $valueWhere);
		if ($this->db->affected_rows() > 0) {
			
			return true; //Data Updated
		}else{

			return false; //Data Updated Failed
		}
	}

	/*
	* The function is used to delete data in the table
	* The first parameter needed is Table Name
	* Second is the values to be passed in where clause N:B the data needed to be in an associative array form E.g $data = array('column' => 'value');
	* 
	*/
	public function delete($tableName,$valueWhere)
	{

		//Deleted Data In The Table
		$this->db->delete($tableName, $valueWhere);
		if ($this->db->affected_rows() > 0) {
			
			return true; //Data Deleted
		}else{

			return false; //Data Deletion Failed
		}
	}

}

/* End of file _baseController.php */
/* Location: ./application/controllers/_baseController.php */