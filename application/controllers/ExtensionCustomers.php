<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExtensionCustomers extends CI_Controller {

	/*
	*
	* The main controller for Administrator Backend
	* -> The controller require user to login as Administrator
	*/

	private $Core = 'Extension'; //Core Lite Base Name | Change this if your Controller Name does not start with word Core
	private $Module = 'user'; //Module
	private $Folder = 'extensions'; //Module
	private $SubFolder = '/customers'; //Set Default Sub Folder For html files and Front End Use Start with /
	private $Escape = 'id,stamp,flg'; // Escape Column For Form Auto Generating
	private $Require = 'level,password,name,emal'; // Required Column During Form Validation
	private $Unique = 'logname'; // Unique & Required Values During Form Validation

	private $Route = 'customers'; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default

	private $New = 'customers/new'; //New customers
	private $Save = 'customers/save'; //Add New customers
	private $Edit = 'customers/update'; //Update customers

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
		$data['Module'] = $this->plural->pluralize($this->Route);//Module Show
		$data['routeURL'] = (is_null($this->Route)) ? $this->plural->pluralize($this->Folder) : $this->Route;

		//User Levels
		$where = array('level_flg' =>1,'level_default' =>'no');
		$data['level'] = $this->db->select('level_name')->where($where)->get('levels')->result();
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
	   	$columns = array('id,level as level,logname as username,name as full_name,email as email,flg as status');
	   	$where = array('level' =>'customer');
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

		//Notification
		$notify = $this->CoreNotify->notify();
		$data['notify'] = $this->CoreNotify->$notify($message);

		//Open Page
		$this->pages($data,$layout);
	}

	/*
	*
	*  This function is to be called when you want to pass the Edit form
    * In here we can call the load function and pass data to passed as an array inorder to manupulate it inside passed function
    * 	* Set your Page name/ID here N:B Page ID can be a number if you wish to access other values linked to the page opened E.g Meta Data
    * 	* You can also set Page ID as actual pageName found in your view N:B do not put .php E.g home.php it should just be 'home'
    * 	* Set Page template 
    * 	* Set Notification here
    * 	Custom notification message can be set/passed via $message
    * 	PageName / ID can be passed via $pageID
    * 	Page layout can be passed via $layout
    *
    * 	For inputTYPE and inputID
    *
    * 	--> inputTYPE
    * 	  This is the name of the column you wish to select, most of the time is coumn name 
    * 	  Remember to Pass ID or Pass data via GET request using variable inputTYPE 
    * 	  
    * 	--> inputID
    * 	  This is the value of the column you wish to match
    * 	  Remember to Pass Value or Pass data via GET request using variable inputID 
    *
    *  If either inputTYPE or inputID is not passed error message will be generated
	* 
	*/
	public function edit($pageID,$inputTYPE='id',$inputID=null,$message=null,$layout='main')
	{
		//Pluralize Module
		$module = $this->plural->pluralize($this->Module);

		//Model Query
		$pageID = (is_numeric($pageID)) ? $pageID : $this->plural->pluralize($this->Folder).$this->SubFolder."/".$pageID;
		$data = $this->load($pageID);

		$inputTYPE = (is_null($inputTYPE)) ? $this->CoreLoad->input('inputTYPE','GET') : $inputTYPE; //Access Value

		$inputID = (is_null($inputID)) ? $this->CoreLoad->input('inputID','GET') : $inputID; //Access Value


		if (!is_null($inputTYPE) || !is_null($inputID)) {
			//Table Select & Clause
			$where = array($inputTYPE =>$inputID);
	   		$columns = array('id as id,name as name,email as email,level as level,logname as logname');
			$data['resultList'] = $this->CoreCrud->selectCRUD($module,$where,$columns);

			//Notification
			$notify = $this->CoreNotify->notify();
			$data['notify'] = $this->CoreNotify->$notify($message);

			//Open Page
			$this->pages($data,$layout);
		}else{

			//Notification
			$this->session->set_flashdata('notification','error');

			//Error Edit | Load the Manage Page
			$this->open('list',$message='System could not find the detail ID');
		}
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
		if ($type == 'save') {

			$formData = $this->CoreLoad->input(); //Input Data

			//Form Validation
			if ($this->validation($formData) == TRUE) {
				if ($this->create($formData)) {
					$this->session->set_flashdata('notification','success'); //Notification Type
					$message = 'Data was saved successful'; //Notification Message				
					redirect($this->New, 'refresh');//Redirect to Page
				}else{
					$this->session->set_flashdata('notification','error'); //Notification Type
					$this->open('add');//Open Page
				}
			}else{
				$this->session->set_flashdata('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open('add',$message);//Open Page
			}			
		}
		elseif ($type == 'bulk') {

			$action = $this->input->get('action'); //Get Action
			$selectedData = json_decode($this->input->get('inputID'), true); //Get Selected Data
			$column_id = strtolower($this->CoreForm->get_column_name($this->Module,'id')); //column name Reference column
			$column_flg = strtolower($this->CoreForm->get_column_name($this->Module,'flg')); //Column name of Updated Input

			//Check If Selection has Value
			if (!empty($selectedData)) {
				//Check Action
				if (strtolower($action) == 'edit') {
					$this->session->set_flashdata('notification','notify'); //Notification Type
					$this->edit('edit','id',$selectedData[0]);//Open Page
				}else{
					for($i = 0; $i < count($selectedData); $i++){ //Loop through all submitted elements
						$value_id = $selectedData[$i]; //Select Value To Update with
						if (strtolower($action) == 'activate') { //Item/Data Activation
							$this->update(array($column_flg =>1),array($column_id =>$value_id)); //Call Update Function
						}elseif (strtolower($action) == 'deactivate'){ //Item/Data Deactivation
							$this->update(array($column_flg =>0),array($column_id =>$value_id)); //Call Update Function
						}elseif (strtolower($action) == 'delete'){ //Item/Data Deletion
							$this->delete(array($column_id => $value_id)); //Call Delete Function
						}else{
							$this->session->set_flashdata('notification','error'); //Notification Type
							$message = 'Wrong data sequence received'; //Notification Message				
							$this->index($message);//Open Page
						}
					}
					$this->session->set_flashdata('notification','success'); //Notification Type
					redirect($routeURL, 'refresh'); //Redirect Index Module
				}			
			}else{
				$this->session->set_flashdata('notification','error'); //Notification Type
				$message = 'Please make a selection first, and try again'; //Notification Message				
				$this->index($message);//Open Page
			}
		}
		elseif ($type == 'update') {

			$updateData = $this->CoreLoad->input(); //Input Data		
			$column_password = strtolower($this->CoreForm->get_column_name($this->Module,'password'));//Column Password
			$column_id = strtolower($this->CoreForm->get_column_name($this->Module,'id'));//Column ID
			$value_id = $this->CoreLoad->input('id'); //Input Value

			//Select Value To Unset && Check If Password Requested
			if (array_key_exists("$column_password",$updateData)) {
				if (!empty($this->input->post($column_password))) {	$unsetData= array('id');/*valude To Unset */}
				else{ $unsetData= array('id',$column_password);/*Unset Value*/	}
			}else{$unsetData= array('id');/*valude To Unset*/}

			//Form Validation
			if ($this->validation($updateData,false,array($column_password)) == TRUE) {
				//Update Table
				if ($this->update($updateData,array($column_id =>$value_id),$unsetData)) {
					$this->session->set_flashdata('notification','success'); //Notification Type
					$message = 'Data was saved successful'; //Notification Message				
					$this->edit('edit','id',$value_id);//Open Page
				}else{
					$this->session->set_flashdata('notification','error'); //Notification Type
					$this->edit('edit','id',$value_id);//Open Page
				}								
			}else{
				$this->session->set_flashdata('notification','error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->edit('edit','id',$value_id,$message);//Open Page
			}		
		}
		elseif ($type == 'delete') {
			$value_id = $this->input->get('inputID'); //Get Selected Data
			$column_id = strtolower($this->CoreForm->get_column_name($this->Module,'id'));

			if ($this->delete(array($column_id => $value_id)) == TRUE) { //Call Delete Function
				$this->session->set_flashdata('notification','success'); //Notification Type
				redirect($routeURL, 'refresh'); //Redirect Index Module
			}else{
				$this->session->set_flashdata('notification','error'); //Notification Type
				redirect($routeURL, 'refresh'); //Redirect Index Module
			}
		}
		else{
			$this->session->set_flashdata('notification','notify'); //Notification Type
			redirect($routeURL, 'refresh'); //Redirect Index Module
		}
	}

	/*
	* The function is used to save/insert data into table
	* First is the data to be inserted 
	*  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
	*      the array key will be used as column name and the value as inputted Data
	*  For colum default/details convert data to JSON on valid() method level
	*
	* Third is the data to be unset | Unset is to be used if some of the input you wish to be removed
	* 
	*/
	public function create($insertData,$unsetData=null)
	{

		if ($this->CoreLoad->auth($this->Module)) { //Authentication
			
			//Pluralize Module
			$tableName = $this->plural->pluralize($this->Module);

			//Column Stamp
			$stamp = strtolower($this->CoreForm->get_column_name($this->Module,'stamp'));
			$insertData["$stamp"] = date('Y-m-d H:i:s',time());
			//Column Flg
			$flg = strtolower($this->CoreForm->get_column_name($this->Module,'flg'));
			$insertData["$flg"] = 1;

			//Column Password
			$column_password = strtolower($this->CoreForm->get_column_name($this->Module,'password'));

			$insertData = $this->CoreLoad->unsetData($insertData,$unsetData); //Unset Data

			//Check IF there is Password
			if (array_key_exists($column_password,$insertData)) {
				$insertData[$column_password] = sha1($this->config->item($insertData["$stamp"]).$insertData[$column_password]);
			}

			$details = strtolower($this->CoreForm->get_column_name($this->Module,'details'));
			$insertData["$details"] = json_encode($insertData);

			//Insert Data Into Table
			$this->db->insert($tableName, $insertData);
			if ($this->db->affected_rows() > 0) {
				
				return true; //Data Inserted
			}else{

				return false; //Data Insert Failed
			}
		}
	}

	/*
	* The function is used to update data in the table
	* First parameter is the data to be updated 
	*  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
	*      the array key will be used as column name and the value as inputted Data
	*  For colum default/details convert data to JSON on valid() method level
	* Third is the values to be passed in where clause N:B the data needed to be in an associative array form E.g $data = array('column' => 'value');
	* Fourth is the data to be unset | Unset is to be used if some of the input you wish to be removed
	* 
	*/
	public function update($updateData,$valueWhere,$unsetData=null)
	{

		if ($this->CoreLoad->auth($this->Module)) { //Authentication
			
			//Pluralize Module
			$tableName = $this->plural->pluralize($this->Module);

			//Column Stamp
			$stamp = $this->CoreForm->get_column_name($this->Module,'stamp');
			$updateData["$stamp"] = date('Y-m-d H:i:s',time());

			//Column Password
			$column_password = strtolower($this->CoreForm->get_column_name($this->Module,'password'));

			$updateData = $this->CoreLoad->unsetData($updateData,$unsetData); //Unset Data

			//Check IF there is Password
			if (array_key_exists($column_password,$updateData)) {
				$updateData[$column_password] = sha1($this->config->item($updateData["$stamp"]).$updateData[$column_password]);
			}

			//Details Column Update
			$details = strtolower($this->CoreForm->get_column_name($this->Module,'details'));
			foreach ($valueWhere as $key => $value) {	$whereData = array($key => $value); /* Where Clause */ 	}

			$current_details = json_decode($this->db->select($details)->where($whereData)->get($tableName)->row()->$details, true);
			foreach ($updateData as $key => $value) { $current_details["$key"] = $value; /* Update -> Details */ }
			$updateData["$details"] = json_encode($current_details);

			//Update Data In The Table
			$this->db->update($tableName, $updateData, $valueWhere);
			if ($this->db->affected_rows() > 0) {
				
				return true; //Data Updated
			}else{

				return false; //Data Updated Failed
			}
		}
	}

	/*
	* The function is used to delete data in the table
	* First parameter is the values to be passed in where clause N:B the data needed to be in an associative array form E.g $data = array('column' => 'value');
	* 
	*/
	public function delete($valueWhere)
	{

		if ($this->CoreLoad->auth($this->Module)) { //Authentication
			
			//Pluralize Module
			$tableName = $this->plural->pluralize($this->Module);

			//Deleted Data In The Table
			$this->db->delete($tableName, $valueWhere);
			if ($this->db->affected_rows() > 0) {
				
				return true; //Data Deleted
			}else{

				return false; //Data Deletion Failed
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

/* End of file ExtensionCustomers.php */
/* Location: ./application/models/ExtensionCustomers.php */