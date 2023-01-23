<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomFieldsExtension extends CI_Controller
{

	/**
	 *
	 * The main controller for Administrator Backend
	 * -> The controller require to login as Administrator
	 */

	private $Module = 'fields'; //Module
	private $Folder = 'configs'; //Set Default Folder For html files and Front End Use
	private $SubFolder = '/customfieldex'; //Set Default Sub Folder For html files and Front End Use Start with /

	private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

	private $Route = 'customfieldext'; //If you have different route Name to Module name State it here |This wont be pluralized
	private $Access = 'customfield'; // For Access Control | Matches ModuleList for Access Level

	private $New = 'customfieldext/new'; //New 
	private $Save = 'customfieldext/save'; //Add New 
	private $Edit = 'customfieldext/update'; //Update 

	private $ModuleName = 'custom field extension'; //Module Nmae

	/** Functions
	 * -> __construct () = Load the most required operations E.g Class Module
	 * 
	 */
	public function __construct()
	{
		parent::__construct();

		//Libraries
		$this->load->library('form_validation');

		//Helpers
		date_default_timezone_set('Africa/Nairobi');

		//Models
		$this->load->model('CoreCrud');
		$this->load->model('CoreForm');

		// Your own constructor code

	}

	/**
	 *
	 * Access Requred pre-loaded data
	 * The additional Model based data are applied here from passed function and join with load function
	 * The pageID variable can be left as null if you do not wish to access Meta Data values
	 * Initially what is passed is a pageID or Page Template Name
	 * 
	 */
	public function load($pageID = null)
	{

		//load Passed
		$passed = $this->passed();
		//Model Query
		$data = $this->CoreLoad->open($pageID, $passed);

		return $data;
	}

	/**
	 *
	 * Load the model/controller based data here
	 * The data loaded here does not affect the other models/controller/views
	 * It only can reach and expand to this controller only
	 * 
	 */
	public function passed($values = null)
	{

		//Time Zone
		date_default_timezone_set('Africa/Nairobi');
		$data['str_to_time'] = strtotime(date('Y-m-d, H:i:s'));
		$data['Module'] = $this->plural->pluralize($this->Module); //Module Show
		$data['routeURL'] = (is_null($this->Route)) ? $this->plural->pluralize($this->Folder) : $this->Route;

		//Module Name - For Forms Title
		$data['ModuleName'] = $this->plural->pluralize($this->ModuleName);

		//Module Name - Title
		$data['actionTitle'] = '';

		//Form Submit URLs
		$data['form_new'] = $this->New;
		$data['form_save'] = $this->Save;
		$data['form_edit'] = $this->Edit;

		return $data;
	}

	/**
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
	public function pages($data, $layout = 'main')
	{
		//Check if site is online
		if ($this->CoreLoad->site_status() == TRUE) {
			//Chech allowed Access
			if ($this->CoreLoad->auth($this->Access)) { //Authentication
				//Layout
				$this->load->view("admin/layouts/$layout", $data);
			} else {
				$this->CoreLoad->notAllowed(); //Not Allowed To Access
			}
		} else {
			$this->CoreLoad->siteOffline(); //Site is offline
		}
	}

	/**
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
	public function index($notifyMessage = null)
	{

		//Check Action
		$title = $this->CoreLoad->input('title', 'GET');

		if(is_null($this->CoreCrud->selectSingleValue('customfields', 'title', ['title' => $title]))){
			$this->session->set_flashdata('notification', 'error'); //Notification Type
			redirect("customfields", "refresh"); //Redirect Index Module
		}

		//Model Query
		$data = $this->load($this->plural->pluralize($this->Folder) . $this->SubFolder . "/list");

		//Table Select & Clause
		$data['dataList'] = $this->CoreCrud->selectCRUD($module, ['title' => $title], ['id as id,title as title,flg as status']);

		// Action
		$data['actionTitle'] = $title;

		//Notification
		$data['notify'] = $this->CoreNotify->blank();

		//Module Name - For Forms Title
		$data['ModuleName'] = $this->plural->pluralize($title).' Fields Data';

		//Open Page
		$this->pages($data);

	}

	/**
	 *
	 * This is the function to be accessed when  want to open specific page which deals with same controller E.g Edit data after saving
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
	public function open($pageID, $message = null, $layout = 'main')
	{

		//Pluralize Module
		$module = $this->plural->pluralize($this->Module);

		//Model Query
		$pageID = (is_numeric($pageID)) ? $pageID : $this->plural->pluralize($this->Folder) . $this->SubFolder . "/" . $pageID;
		$data = $this->load($pageID);

		//Notification
		$notify = $this->CoreNotify->notify();
		$data['notify'] = $this->CoreNotify->$notify($message);

		//Open Page
		$this->pages($data, $layout);
	}

	/**
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
	public function edit($pageID, $inputTYPE = 'id', $inputID = null, $message = null, $layout = 'main')
	{
		//Pluralize Module
		$module = $this->plural->pluralize($this->Module);

		//Model Query
		$pageID = (is_numeric($pageID)) ? $pageID : $this->plural->pluralize($this->Folder) . $this->SubFolder . "/" . $pageID;
		$data = $this->load($pageID);

		$inputTYPE = (is_null($inputTYPE)) ? $this->CoreLoad->input('inputTYPE', 'GET') : $inputTYPE; //Access Value

		$inputID = (is_null($inputID)) ? $this->CoreLoad->input('inputID', 'GET') : $inputID; //Access Value


		if (!is_null($inputTYPE) || !is_null($inputID)) {
			//Table Select & Clause
			$where = array($inputTYPE => $inputID);
			$columns = array('id as id,title as title,data as data');
			$resultList = $this->CoreCrud->selectCRUD($module, $where, $columns);

			$data['resultList'] = $resultList;
			//Table Select & Clause
			$columns = array('id as id,inputs as inputs,filters as filters,keys as keys,default as default');
			$where = array('title' => $resultList[0]->title);
			$data['fieldList'] = $this->CoreCrud->selectCRUD('customfields', $where, $columns, 'like');

			//Notification
			$notify = $this->CoreNotify->notify();
			$data['notify'] = $this->CoreNotify->$notify($message);

			//Open Page
			$this->pages($data, $layout);
		} else {

			//Notification
			$this->session->set_flashdata('notification', 'error');

			//Error Edit | Load the Manage Page
			$this->open('list', $message = 'System could not find the detail ID');
		}
	}

	/**
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

		// Image Data
		$allowed_files = $this->AllowedFile; //Set Allowed Files
		$upoadDirectory = "../assets/media"; //Custom Upload Location

		//Check Validation
		if ($type == 'save') {

			$formData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules('title', 'Custom Field Title', 'trim|required|min_length[1]|max_length[50]');

			//Form Validation
			if ($this->form_validation->run() == TRUE) {

				//Input ID
				$title = $this->CoreLoad->input('title');

				//Unset Data
				$formData = $this->CoreCrud->unsetData($formData, array('title'));
				// Save Data
				$savedData = $this->CoreForm->saveFormField($formData, $title);

				if ($this->create($savedData)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$message = 'Data was saved successful'; //Notification Message				
					redirect("customfieldext/$title", "refresh"); //Redirect Index Module
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					redirect("customfieldext/$title", "refresh"); //Redirect Index Module
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->index($message); //Open Page
			}
		} elseif ($type == 'bulk') {

			$action = $this->input->get('action'); //Get Action
			$selectedData = json_decode($this->input->get('inputID'), true); //Get Selected Data
			$column_id = strtolower($this->CoreForm->get_column_name($this->Module, 'id')); //column name Reference column
			$column_flg = strtolower($this->CoreForm->get_column_name($this->Module, 'flg')); //Column name of Updated Input

			//Check If Selection has Value
			if (!empty($selectedData)) {
				//Check Action
				if (strtolower($action) == 'edit') {
					$this->session->set_flashdata('notification', 'notify'); //Notification Type
					$this->edit('edit', 'id', $selectedData[0]); //Open Page
				} else {
					for ($i = 0; $i < count($selectedData); $i++) { //Loop through all submitted elements
						$value_id = $selectedData[$i]; //Select Value To Update with
						if (strtolower($action) == 'activate') { //Item/Data Activation
							$updatedData = $this->CoreForm->updateFormField(array('flg' => 1), $value_id);
							$updatedData[$column_flg] = 1;
							$this->update($updatedData, $value_id); //Call Update Function
						} elseif (strtolower($action) == 'deactivate') { //Item/Data Deactivation
							$updatedData = $this->CoreForm->updateFormField(array('flg' => 0), $value_id);
							$updatedData[$column_flg] = 0;
							$this->update($updatedData, $value_id); //Call Update Function
						} elseif (strtolower($action) == 'delete') { //Item/Data Deletion
							$this->delete($value_id); //Call Delete Function
						} else {
							$this->session->set_flashdata('notification', 'error'); //Notification Type
							$message = 'Wrong data sequence received'; //Notification Message				
							$this->index($message); //Open Page
						}
					}
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					redirect($routeURL, 'refresh'); //Redirect Index Module
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please make a selection first, and try again'; //Notification Message				
				$this->index($message); //Open Page
			}
		} elseif ($type == 'update') {

			$updateData = $this->CoreLoad->input(); //Input Data		
			//Input ID
			$inputID = $this->CoreLoad->input('id');

			$this->form_validation->set_rules('id', 'Field ID', 'trim|required|min_length[1]|max_length[20]');

			//Form Validation
			if ($this->form_validation->run() == TRUE) {


				// Upload Data
				$updatedData = $this->CoreForm->updateFormField($updateData, $inputID);

				//Update Table
				if ($this->update($updatedData, $inputID)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$message = 'Data was updated successful'; //Notification Message				
					$this->edit('edit', 'id', $inputID, $message); //Open Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$message = "Data wasn't updated or you did not make any new updates"; //Notification Message				
					$this->edit('edit', 'id', $inputID, $message); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->edit('edit', 'id', $inputID, $message); //Open Page
			}
		} elseif ($type == 'delete') {
			$value_id = $this->input->get('inputID'); //Get Selected Data
			$column_id = strtolower($this->CoreForm->get_column_name($this->Module, 'id'));

			if ($this->delete($value_id) == TRUE) { //Call Delete Function
				$this->session->set_flashdata('notification', 'success'); //Notification Type
				redirect($routeURL, 'refresh'); //Redirect Index Module
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				redirect($routeURL, 'refresh'); //Redirect Index Module
			}
		}elseif ($type == 'add') {

			// Title
			$title =  strtolower(trim($this->CoreLoad->input('title', 'GET')));
			if(is_null($this->CoreCrud->selectSingleValue('customfields', 'title', ['title' => $title]))){
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				redirect("customfields", "refresh"); //Redirect Index Module
			}

			//Model Query
			$data = $this->load($this->plural->pluralize($this->Folder) . $this->SubFolder . "/add");

			//Table Select & Clause
			$columns = array('id as id,title as title,inputs as inputs,filters as filters,keys as keys,default as default');
			$data['fieldList'] = $this->CoreCrud->selectCRUD('customfields', ['title' => $title], $columns, 'like');

			// Action
			$data['actionTitle'] = $title;

			//Notification
			$data['notify'] = $this->CoreNotify->blank();

			//Module Name - For Forms Title
			$data['ModuleName'] = $this->plural->pluralize($title);

			//Open Page
			$this->pages($data);
		} else {

			// Get Title
			$title = $this->CoreCrud->selectSingleValue('customfields', 'title', ['title' => $type]);

			if(!is_null($title)){
				//Model Query
				$data = $this->load($this->plural->pluralize($this->Folder) . $this->SubFolder . "/list");

				//Table Select & Clause
				$data['dataList'] = $this->CoreCrud->selectCRUD($module, ['title' => $title], ['id as id,title as title,flg as status']);

				// Action
				$data['actionTitle'] = $title;

				//Notification
				$data['notify'] = $this->CoreNotify->blank();

				//Module Name - For Forms Title
				$data['ModuleName'] = $this->plural->pluralize($title).' Fields Data';

				//Open Page
				$this->pages($data);
			}else{
				$this->session->set_flashdata('notification', 'notify'); //Notification Type
				redirect($routeURL, 'refresh'); //Redirect Index Module
			}
		}
	}

	/**
	 * The function is used to save/insert data into table
	 * First is the data to be inserted 
	 *  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
	 *      the array key will be used as column name and the value as inputted Data
	 *  For colum default/details convert data to JSON on valid() method level
	 *
	 * Third is the data to be unset | Unset is to be used if some of the input you wish to be removed
	 * 
	 */
	public function create($insertData, $unsetData = null)
	{

		if ($this->CoreLoad->auth($this->Access)) { //Authentication

			//Save
			$savedData = $this->CoreCrud->saveField($insertData);
			if ($this->CoreCrud->fieldStatus($savedData)) {

				return $savedData['id']; //Data Inserted
			} else {

				return false; //Data Insert Failed
			}
		}
	}

	/**
	 * The function is used to update data in the table
	 * First parameter is the data to be updated 
	 *  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
	 *      the array key will be used as column name and the value as inputted Data
	 *  For colum default/details convert data to JSON on valid() method level
	 * Third is the values to be passed in where clause N:B the data needed to be in an associative array form E.g $data = array('column' => 'value');
	 * Fourth is the data to be unset | Unset is to be used if some of the input you wish to be removed
	 * 
	 */
	public function update($updateData, $valueWhere, $unsetData = null)
	{

		if ($this->CoreLoad->auth($this->Access)) { //Authentication

			//Updated
			$updatedData = $this->CoreCrud->updateField($updateData, $valueWhere);
			if ($this->CoreCrud->fieldStatus($updatedData)) {

				return true; //Data Inserted
			} else {

				return false; //Data Insert Failed
			}
		}
	}

	/**
	 * The function is used to delete data in the table
	 * First parameter is the values to be passed in where clause N:B the data needed to be in an associative array form E.g $data = array('column' => 'value');
	 * 
	 */
	public function delete($fieldValue)
	{

		if ($this->CoreLoad->auth($this->Access)) { //Authentication

			//Deleted Data In The Table
			$deleteData = $this->CoreCrud->deleteField($fieldValue);
			if ($this->CoreCrud->fieldStatus($deleteData)) {

				return true; //Data Deleted
			} else {

				return false; //Data Deletion Failed
			}
		}
	}

	/**
	 *
	 * This Fuction is used to validate File Input Data
	 * The Method can be accessed via set_rules(callback_validimage[input_name])
	 *
	 * 1: To make file required use $this->form_validation->set_rules('file_name','File Name','callback_validimage[input_name|required]');
	 * 2: To force custom file type per file use $this->form_validation->set_rules('file_name','File Name','callback_validimage[input_name|jpg,jpeg,png,doc,docx,pdf,xls,txt]');
	 * 3: To have required and custom file type per file use $this->form_validation->set_rules('file_name','File Name','callback_validimage[input_name|required|jpg,jpeg,png,doc,docx,pdf,xls,txt]');
	 *
	 * N.B 
	 * -The callback_validimage method is used to validate the file input (file/images)
	 * - The input_name is the name of the input field (must be first passed callback_validimage[])
	 * - '|' is used to separate the input name and the allowed file types/required
	 *
	 */
	public function validimage($str, $parameters)
	{
		// Image and file allowed
		$allowed_ext = (!is_null($this->AllowedFile)) ? $this->AllowedFile : 'jpg|jpeg|png|doc|docx|pdf|xls|txt';
		$allowed_types = explode('|', $allowed_ext);
		// check if method uploadSettings is defined in Class CoreField
		$config = (method_exists('CoreField', 'uploadSettings')) ? $this->CoreField->uploadSettings() : array('max_size' => 2048);
		// Check if array $config has key max_size use ternarry
		$allowed_size = (array_key_exists('max_size', $config)) ? $config['max_size'] : 2048;
		// Change KB to Bytes
		$allowed_size_byte = $allowed_size * 1024;

		// Parameters
		$passed = explode('|', $parameters);
		// File name input_name
		$input_name = (isset($passed[0])) ? $passed[0] : null;
		$second_parameter = (isset($passed[1])) ? $passed[1] : null;
		// Check if there is key 2
		$third_parameter = (isset($passed[2])) ? $passed[2] : null;

		// Required
		$required = false;
		// Second Parameter
		if (strtolower($second_parameter) == 'required') {
			$required = true;
		} else {
			// check if $second_parameter is 
			$allowed_types = (!is_null($second_parameter)) ? explode(',', $second_parameter) : $allowed_types;
		}

		//Third Parameter
		if (strtolower($third_parameter) == 'required') {
			$required = true;
		} else {
			// check if $second_parameter is 
			$allowed_types = (!is_null($third_parameter)) ? explode(',', $third_parameter) : $allowed_types;
		}

		// Types show
		$allowed_types_show = implode(', ', $allowed_types);

		// If $str is array validate each
		if (array_key_exists($input_name, $_FILES)) {
			// File To be Uploaded | File Name &_FILES ['input_name]
			$file = $_FILES[$input_name];

			// Check if file['name'] is array
			if (is_array($file['name'])) {
				// Loop through each file
				for ($i = 0; $i < count($file['name']); $i++) {
					// Uploaad Values
					$value = array(
						'name' => $file['name'][$i],
						'type' => $file['type'][$i],
						'tmp_name' => $file['tmp_name'][$i],
						'error' => $file['error'][$i],
						'size' => $file['size'][$i]
					);

					//Get Values
					$file_name = $value['name'];
					// Size to int
					$file_size = (int) $value['size'];
					// Get file_name, explode where there is . and get the last array assign as file_ext
					$file_ext = explode('.', $file_name);
					$file_ext = strtolower(end($file_ext));

					// Check if Uploaded file exist
					if ($file_size > 0) {
						// Check if file is allowed
						if (!in_array($file_ext, $allowed_types)) {
							$this->form_validation->set_message('validimage', 'The {field} must be a file of type: ' . $allowed_types_show);
							return false;
						}

						// Check if file size is allowed
						if ($file_size > $allowed_size_byte) {
							$this->form_validation->set_message('validimage', 'The {field} must be less than ' . $file_size . ' - ' . $allowed_size . 'KB');
							return false;
						}
					} else {
						if ($required) {
							$this->form_validation->set_message('validimage', 'The {field} is required');
							return false;
						}
					}
				}
				return true;
			} else {
				$file_name = $file['name'];
				//Size to int
				$file_size = (int) $file['size'];
				// Get file_name, explode where there is . and get the last array assign as file_ext
				$file_ext = explode('.', $file_name);
				$file_ext = strtolower(end($file_ext));

				// Check if Uploaded file exist
				if ($file_size > 0) {
					// Check if file is allowed
					if (!in_array($file_ext, $allowed_types)) {
						$this->form_validation->set_message('validimage', 'The {field} must be a file of type: ' . $allowed_types_show);
						return false;
					}

					// Check if file size is allowed
					if ($file_size > $allowed_size_byte) {
						$this->form_validation->set_message('validimage', 'The {field} must be less than ' . $allowed_size . 'KB');
						return false;
					}
				} else {
					if ($required) {
						$this->form_validation->set_message('validimage', 'The {field} is required');
						return false;
					}
				}
				return true;
			}
		} else {
			$this->form_validation->set_message('validimage', 'The {field} is not passed, check your form input name');
			return false;
		}
	}
}

/** End of file CustomFieldsExtension.php */
/** Location: ./application/controllers/CustomFieldsExtension.php */
