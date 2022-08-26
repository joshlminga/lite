<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logs extends CI_Controller
{

	/**
	 *
	 * The main controller for Administrator Backend
	 * -> The controller require user to login as Administrator
	 */

	private $Module = 'user'; //Module
	private $Folder = ''; //Set Default Folder For html files
	private $SubFolder = ''; //Set Default Sub Folder For html files and Front End Use Start with /

	private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

	private $Route = null; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default
	private $Access = 'user'; // For Access Control | Matches ModuleList for Access Level

	private $New = 'admin/login'; //New Login
	private $Save = ''; //Add New User
	private $Edit = 'admin/reset'; //Update Password

	private $ModuleName = 'user'; //Module Nmae

	/** Functions
	 * -> __construct () = Load the most required operations E.g Class Module
	 * 
	 */
	public function __construct()
	{
		parent::__construct();

		//Libraries
		$this->load->library('form_validation');
		$this->load->library('encryption');
		$this->load->helper('cookie');

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
	 * ** To some page functions which are not public, use the auth method from CoreLoad model to check is user is allowed to access the pages
	 * ** If your page is public ignore the use of auth method
	 * 
	 */
	public function pages($data, $layout = 'log')
	{

		//Layout
		$this->load->view("admin/layouts/$layout", $data);
	}

	/**
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
	public function index($notifyMessage = null)
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

	/**
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
	public function open($pageID, $message = null, $layout = 'log')
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
		if ($type == 'login') {

			$formData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("user_logname", "Logname", "trim|required|min_length[1]");
			$this->form_validation->set_rules("user_password", "Password", "trim|required|min_length[1]");
			$this->form_validation->set_rules("remember", "", "trim|max_length[5]");


			//Form Validation
			if ($this->form_validation->run() == TRUE) {

				// Login
				$formLOG['user_logname'] = $formData['user_logname'];
				$formLOG['user_password'] = $formData['user_password'];

				// Remember
				if (array_key_exists('remember', $formData)) {
					$formLOG['remember'] = $formData['remember'];
				}

				// Login User
				$log_status = $this->login($formLOG);

				if ($log_status == 'success') {
					$this->session->set_flashdata('notification', 'notify'); //Notification Type
					redirect("dashboard", "refresh"); //Redirect to Page
				} elseif ($log_status == 'wrong') {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$message = 'Failed!, wrong password or username'; //Notification Message				
					$this->index($message); //Open Page
				} elseif ($log_status == 'deactivated') {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$message = 'Failed!, your account is suspended'; //Notification Message				
					$this->index($message); //Open Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$message = 'Failed!, account does not exist'; //Notification Message				
					$this->index($message); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->index($message); //Open Page
			}
		} elseif ($type == 'reset') {
			$this->session->set_flashdata('notification', 'error'); //Notification Type
			$message = 'Sorry!, reset password will be available later'; //Notification Message				
			$this->index($message); //Open Page
		} elseif ($type == 'logout') {

			$this->session->sess_destroy(); //User Logout

			// Get CookieName
			$cookie_name = $this->CoreLoad->getCookieName();
			delete_cookie($cookie_name);

			$main_site = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'site_url', 'flg' => 1)); // Main Site URL
			redirect($main_site, 'refresh'); //Open Page
		} else {
			$this->session->set_flashdata('notification', 'notify'); //Notification Type
			$this->index(); //Open Page
		}
	}

	/**
	 *
	 * Fuction for Login Validation
	 * The fuction takes, accept form data which passed through CoreLoad Input
	 * 
	 */
	public function login($formData)
	{
		//Pluralize Module
		$tableName = $this->plural->pluralize($this->Module);
		$column_logname = $this->CoreForm->get_column_name($this->Module, 'logname'); //Logname Column
		$column_password = $this->CoreForm->get_column_name($this->Module, 'password'); //Password Column
		$column_stamp = $this->CoreForm->get_column_name($this->Module, 'stamp'); //Stamp Column
		$column_level = $this->CoreForm->get_column_name($this->Module, 'level'); //Stamp Level
		$column_flg = $this->CoreForm->get_column_name($this->Module, 'flg'); //Stamp FLG
		$column_id = $this->CoreForm->get_column_name($this->Module, 'id'); //Stamp ID

		//Get Array Data
		foreach ($formData as $key => $value) {
			if (strtolower($key) == $column_logname) {
				$logname = $value; //Set user logname
			} elseif (strtolower($key) == $column_password) {
				$password = $value; //Set user Password
			}
		}

		//Get Date Time
		$result = $this->db->select($column_stamp)->from($tableName)->where($column_logname, $logname)->limit(1)->get();
		if ($result->num_rows() === 1) {

			$row = $result->row();
			$stamp = $row->$column_stamp; //Date Time

			//Check If Enabled
			if ($this->db->select($column_flg)->where($column_logname, $logname)->get($tableName)->row()->$column_flg) {
				$hased_password = sha1($this->config->item($stamp) . $password); //Hashed Password
				$where = array($column_logname => $logname, $column_password => $hased_password); // Where Clause
				$query = $this->db->select("$column_id, $column_level")->where($where)->limit(1)->get($tableName)->result(); //Set Query Select

				if ($query) {

					//Session ID
					$session_id = $this->CoreLoad->sessionName('id');
					$newsession[$session_id] = $query[0]->$column_id;

					//Session LEVEL
					$session_level = $this->CoreLoad->sessionName('level');
					$newsession[$session_level] = $query[0]->$column_level;

					//Session LOGGED
					$session_logged = $this->CoreLoad->sessionName('logged');
					$newsession[$session_logged] = TRUE;

					$this->session->set_userdata($newsession); //Create Session

					if (array_key_exists('remember', $formData)) {
						if ($formData['remember'] == 'yes') {

							$value  = $newsession[$session_id];
							$expire = 604800; // 1 week in seconds                                                    
							$secure = False;
							$domain = base_url();

							// CookieName
							$name = $this->CoreLoad->getCookieName();

							// Get Cookie Value
							$value = $this->encryption->encrypt($value);
							set_cookie($name, $value, $expire, $secure);
						}
					}

					return 'success'; //Logged In
				} else {
					return 'wrong'; //Wrong Account Password / Logname
				}
			} else {
				return 'deactivated'; //Account Deactivated
			}
		} else {
			return 'error'; //Account Don't Exist
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

/** End of file Logs.php */
/** Location: ./application/controllers/Logs.php */
