<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ex_Migrate extends CI_Controller
{

	/**
	 *
	 * The main controller for Administrator Backend
	 * -> The controller require to login as Administrator
	 */

	private $Prefix = ''; //For Table Prefix
	private $Module = ''; //Module
	private $Folder = 'extensions'; //Set Default Folder For html files and Front End Use
	private $SubFolder = '/migrate'; //Set Default Sub Folder For html files and Front End Use Start with /

	private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

	private $Route = 'migrate'; //If you have different route Name to Module name State it here |This wont be pluralized
	private $Access = 'general'; // For Access Control | Matches ModuleList for Access Level

	private $New = ''; //New 
	private $Save = 'migrate/save'; //Add New 
	private $Edit = ''; //Update 

	private $ModuleName = 'Migrate Manager';

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
		$this->load->model('CoreMigrate', 'migrate');


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
		$data['routeURL'] = (is_null($this->Route)) ? $this->plural->pluralize($this->Folder) : $this->Route;

		//Module Name - For Forms Title
		$data['ModuleName'] = $this->plural->pluralize($this->ModuleName);
		$data['action'] = '';
		$data['moduleList'] = ['settings', 'levels', 'users', 'inheritances', 'autofields', 'blogs', 'pages', 'customfields', 'fields'];


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
	public function pages($data, $layout = 'extend')
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
	 * This is the default function to be accessed when  open this controller
	 * In here we can call the load function and pass data to passed as an array inorder to manupulate it inside passed function
	 * 	* Set your Page name/ID here N:B Page ID can be a number if you wish to access other values linked to the page opened E.g Meta Data
	 * 	* You can also set Page ID as actual pageName found in your view N:B do not put .php E.g home.php it should just be 'home'
	 * 	* Set Page template 
	 * 	* Set Notification here
	 * 	By Default index does not allow notification Message to be passed, it uses the default message howevr you can pass using the notifyMessage variable
	 * 	However we advise to use custom notification message while opening index utilize another function called open
	 * 
	 */
	public function migrate($page)
	{
		//Pluralize Module

		// Table
		$table = $page;
		$page = ($table == 'fieldgroup') ? 'field' : $this->plural->singularize($table);

		//Model Query
		$data = $this->load($this->plural->pluralize($this->Folder) . $this->SubFolder . "/$page");
		// Migrate
		$data = $this->migrate->load($data, $table);
		$data['action'] = $this->plural->singularize($table);
		$data['ModuleName'] = ucwords($table) . ' Migration';

		//Notification
		$notify = $this->CoreNotify->notify();
		$data['notify'] = $this->CoreNotify->$notify();

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
	public function open($pageID, $message = null, $layout = 'extend')
	{

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

		// Image Data
		$allowed_files = $this->AllowedFile; //Set Allowed Files
		$upoadDirectory = "../assets/media"; //Custom Upload Location

		//Check Validation
		if ($type == 'bulk') {

			$manage = $this->input->get('action'); //Get Action
			$selectedData = json_decode($this->input->get('inputID'), true); //Get Selected Data
			//Check If Selection has Value
			if (!empty($selectedData)) {
				//Check Action
				for ($i = 0; $i < count($selectedData); $i++) { //Loop through all submitted elements
					$value_id = $selectedData[$i]; //Select Value To Update with
					// Migrate Data
					$this->migrate->migrate($manage, $value_id);
				}
				$this->session->set_flashdata('notification', 'success'); //Notification Type
				redirect("migrate/$manage", 'refresh'); //Redirect Index Module
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please make a selection first, and try again'; //Notification Message				
				$this->migrate($manage); //Open Page
			}
		} elseif ($type == 'all') {
			$formData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("migrate", "", "trim|max_length[100]");
			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				$this->session->set_flashdata('notification', 'success'); //Notification Type
				$message = 'Migration Completed Successful'; //Notification Message				

				$migrate = $formData['migrate']; //Get Migrate Value
				//Check Action
				for ($i = 0; $i < count($migrate); $i++) { //Loop through all submitted elements
					$manage = $migrate[$i]; //Select Value To Update with
					// Migrate Data
					$status = $this->migrate->migrateAll($manage);
					if (!$status) {
						$this->session->set_flashdata('notification', 'error'); //Notification Type
						$message = 'Migration Failed Check Your Database'; //Notification Message				
						break;
					}
				}

				$this->session->set_flashdata('notification', 'success'); //Notification Type
				$message = 'Migration Completed Successful'; //Notification Message				
				$this->open('manage', $message); //Open Page

			} else {

				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please select atleast one module, and try again'; //Notification Message				
				$this->open('manage', $message); //Open Page
			}
		} else {
			$this->session->set_flashdata('notification', 'notify'); //Notification Type
			redirect($this->Route, 'refresh'); //Redirect Index Module
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

				return true; //Data Inserted
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
	 *
	 * Validate Email/Username (Logname)
	 * This function is used to validate if user email/logname already is used by another account
	 * Call this function to validate if nedited logname or email does not belong to another user
	 */
	public function lognamecheck($str)
	{
		// Set Parent Table
		$tableName = 'user';

		//Validate
		$check = (filter_var($str, FILTER_VALIDATE_EMAIL)) ? 'email' : 'logname'; //Look Email / Phone Number
		if (strtolower($str) == strtolower(trim($this->CoreCrud->selectSingleValue($tableName, $check, array('id' => $this->CoreLoad->session('id')))))) {
			return true;
		} elseif (is_null($this->CoreCrud->selectSingleValue($tableName, 'id', array($check => $str)))) {
			return true;
		} elseif ($this->CoreLoad->session('level') == 'superadmin') {
			return true;
		} else {
			$this->form_validation->set_message('lognamecheck', 'This {field} is already in use by another account');
			return false;
		}
	}

	/**
	 *
	 * Validate Mobile/Phone Number
	 * This function accept/take input field value / Session  mobilecheck
	 *
	 * * The Method can be accessed via set_rules(callback_mobilecheck['+1']) // +1 is the country code
	 */
	public function mobilecheck($str = null, $dial_code = null)
	{

		// Set Parent Table
		$tableName = 'user';

		//Get The Phone/Mobile Number
		$number = $str;

		//Check Rule
		$rules_validate = (method_exists('CoreField', 'mobileCheck')) ? $this->CoreField->mobileCheck($number) : false;
		$column_name = (filter_var($number, FILTER_VALIDATE_EMAIL)) ? 'email' : 'logname'; //Look Email / Phone Number
		//Validation
		if (!$rules_validate) {
			//Check First Letter if does not start with 0
			if (0 == substr($number, 0, 1)) {
				//Check If it Phone number belongs to you
				if (strtolower($number) == strtolower(trim($this->CoreCrud->selectSingleValue($tableName, $column_name, array('id' => $this->CoreLoad->session('id')))))) {
					return true;
				}
				//Must Be Unique
				elseif (strlen($this->CoreCrud->selectSingleValue($tableName, 'id', array($column_name => $number))) <= 0) {
					//Must be integer
					if (is_numeric($number) && strlen($number) == 10) {

						// Check Default Dial Code
						$country_code = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'country_code'));
						$default_dial_code = (method_exists('CoreField', 'defaultDialCode')) ? $this->CoreField->defaultDialCode() : $country_code;

						//Dial Code
						$dial_code = (!is_null($dial_code)) ? $dial_code : $default_dial_code; //Set Country Dial Code Here eg +1, by default it is empty
						$max_count = strlen($dial_code) - 1;
						//First Two Character
						$firstTwoNumbers = "+" . substr($number, 0, $max_count);
						//Check If number starts with country code
						if ($firstTwoNumbers != $dial_code) {
							return true;
						} else {
							$this->form_validation->set_message('mobilecheck', 'This {field} make sure your number start with "0"');
							return false;
						}
					} else {
						$this->form_validation->set_message('mobilecheck', '{field} must be 10 numbers and should not include the country code. Example: 07xxxxxxxx');
						return false;
					}
				} else {
					$this->form_validation->set_message('mobilecheck', 'This {field} is already in use by another account');
					return false;
				}
			} else {
				$this->form_validation->set_message('mobilecheck', 'This {field} make sure your number start with "0"');
				return false;
			}
		} else {
			//Check Status
			$status = $rules_validate['status'];
			$message = $rules_validate['message'];
			if ($status) {
				return true;
			} else {
				$this->form_validation->set_message('mobilecheck', "{field} $message");
				return false;
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

/** End of file Members.php */
/** Location: ./application/controllers/Members.php */
