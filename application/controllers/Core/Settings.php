<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

	/**
	 *
	 * The main controller for Administrator Backend
	 * -> The controller require user to login as Administrator
	 */

	private $Module = 'setting'; //Module
	private $Folder = 'setting'; //Set Default Folder For html files setting
	private $SubFolder = ''; //Set Default Sub Folder For html files and Front End Use Start with /

	private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

	private $Route = null; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default
	private $Access = 'setting'; // For Access Control | Matches ModuleList for Access Level

	private $General = 'general/update'; //Settings
	private $Site = 'site/update'; //Site
	private $Link = 'link/update'; //
	private $Mail = 'mail/update'; //
	private $Blog = 'blog/update'; //
	private $Seo = 'seo/update'; //
	private $Inheritance = 'inheritance/update'; //
	private $Modulelist = 'module/update'; //
	private $Theme = 'theme/update'; //

	private $ModuleName = 'settings'; //Module Nmae

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
		$data['Module'] = $this->plural->pluralize($this->Folder); //Module Show
		$data['routeURL'] = (is_null($this->Route)) ? $this->plural->pluralize($this->Folder) : $this->Route;

		//Module Name - For Forms Title
		$data['ModuleName'] = $this->plural->pluralize($this->ModuleName);

		//Form Submit URLs
		$data['form_general'] = $this->General;
		$data['form_site'] = $this->Site;
		$data['form_link'] = $this->Link;
		$data['form_mail'] = $this->Mail;
		$data['form_blog'] = $this->Blog;
		$data['form_seo'] = $this->Seo;
		$data['form_inheritance'] = $this->Inheritance;
		$data['form_module'] = $this->Modulelist;
		$data['form_theme'] = $this->Theme;

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
	public function pages($data, $layout = 'main')
	{
		//Chech allowed Access
		if ($this->CoreLoad->auth($this->Access)) { //Authentication
			//Layout
			$this->load->view("admin/layouts/$layout", $data);
		} else {
			$this->CoreLoad->notAllowed(); //Not Allowed To Access
		}
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

		//Model Query

		//Table Select & Clause

		//Notification

		//Open Page
		$this->open('general');
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
		if ($type == 'general') {

			$updateData = $this->CoreLoad->input(); //Input Data

			//Form Validation Values
			$this->form_validation->set_rules("site_title", "Site Title", "trim|required|min_length[1]|max_length[800]");
			$this->form_validation->set_rules("site_slogan", "Site Slogan", "trim|required|min_length[1]|max_length[800]");
			$this->form_validation->set_rules("site_status", "Site Status", "trim|required|min_length[1]|max_length[10]");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				if ($this->update($updateData)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$this->open($type); //Redirect to Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$this->open($type); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type, $message); //Open Page
			}
		} elseif ($type == 'site') {

			$updateData = $this->CoreLoad->input(); //Input Data

			//Form Validation Values
			$this->form_validation->set_rules("site_url", "Site URL", "trim|required|min_length[1]|max_length[800]");
			$this->form_validation->set_rules("api_url", "Api URL", "trim|required|min_length[1]|max_length[800]");

			$this->form_validation->set_rules("session_key", "Session Key", "trim|required|min_length[9]|max_length[10]");

			$this->form_validation->set_rules("token_name", "Token Name", "trim|required|min_length[1]|max_length[10]");
			$this->form_validation->set_rules("token_length", "Token Length", "trim|required|less_than_equal_to[25]|integer");
			$this->form_validation->set_rules("token_use", "Token Use", "trim|required|less_than_equal_to[60]|integer");
			$this->form_validation->set_rules("token_time", "Token Time", "trim|required|integer");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				if ($this->update($updateData)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$this->open($type); //Redirect to Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$this->open($type); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type, $message); //Open Page
			}
		} elseif ($type == 'link') {

			$updateData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("current_url", "Current Url", "trim|required|min_length[1]|max_length[50]");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				if ($this->update($updateData)) {

					//Update Blog URL
					$postTitle = $this->db->select('blog_id')->get('blogs');
					$postData = $postTitle->result();

					if (count($postData) > 0) {
						foreach ($postData as $row) {
							$post_id = $row->blog_id; //Post ID
							$url = $this->CoreCrud->postURL($post_id, null, 'blog');

							$sql = "UPDATE `blogs` SET `blog_url` = '$url' WHERE `blog_id` = '$post_id' ";
							$results = $this->db->query($sql); //site_title
						}
					}

					//Update POST URL
					$postTitle = $this->db->select('page_id')->get('pages');
					$postData = $postTitle->result();

					if (count($postData) > 0) {
						foreach ($postData as $row) {
							$post_id = $row->page_id; //Post ID
							$url = $this->CoreCrud->postURL($post_id);

							$sql = "UPDATE `pages` SET `page_url` = '$url' WHERE `page_id` = '$post_id' ";
							$results = $this->db->query($sql); //site_title
						}
					}

					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$this->open($type); //Redirect to Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$this->open($type); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type, $message); //Open Page
			}
		} elseif ($type == 'mail') {

			$updateData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("mail_protocol", "Mail Protocol", "trim|required|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("smtp_host", "Smtp Host", "trim|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("smtp_user", "Smtp User", "trim|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("smtp_pass", "Smtp Pass", "trim|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("smtp_port", "Smtp Port", "trim|integer|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("smtp_timeout", "Smtp Timeout", "trim|integer|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("smtp_crypto", "Smtp Crypto", "trim|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("wordwrap", "Wordwrap", "trim|required|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("wrapchars", "Wrapchars", "trim|required|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("mailtype", "Mailtype", "trim|required|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("charset", "Charset", "trim|required|min_length[1]|max_length[50]");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				if ($this->update($updateData)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$this->open($type); //Redirect to Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$this->open($type); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type, $message); //Open Page
			}
		} elseif ($type == 'blog') {

			$updateData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("home_display", "Home Display", "trim|required|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("home_post", "Home Post", "trim|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("home_page", "Home Page", "trim|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("post_per_page", "Post Per Page", "trim|required|integer|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("page_pagination", "Page Pagination", "trim|required|integer|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("post_show", "Post Show", "trim|required|min_length[1]|max_length[50]");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				if ($this->update($updateData)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$this->open($type); //Redirect to Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$this->open($type); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type, $message); //Open Page
			}
		} elseif ($type == 'seo') {

			$updateData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("seo_visibility", "Seo Visibility", "trim|required|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("seo_global", "Seo Global", "trim|required|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("seo_description", "Seo Description", "trim|max_length[8000]");
			$this->form_validation->set_rules("seo_keywords", "Seo Keywords", "trim|max_length[8000]");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				if ($this->update($updateData)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$this->open($type); //Redirect to Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$this->open($type); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type, $message); //Open Page
			}
		} elseif ($type == 'inheritance') {

			$updateData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("inheritance_data", "Inheritance Type Data", "trim");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				if ($this->update($updateData)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$this->open($type); //Redirect to Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$this->open($type); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type, $message); //Open Page
			}
		} elseif ($type == 'module') {

			$updateData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("module_list", "Module List", "trim");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				if ($this->update($updateData)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$this->open($type); //Redirect to Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$this->open($type); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type, $message); //Open Page
			}
		} elseif ($type == 'theme') {

			$updateData = $this->CoreLoad->input(); //Input Data

			//Form Validation Values
			$this->form_validation->set_rules("theme_name", "Main Theme Name", "trim|required|min_length[1]|max_length[800]");
			$this->form_validation->set_rules("child_theme", "Child Theme Name", "trim|max_length[800]");

			// Lowercase , Escape
			$theme_name = str_replace(' ', '_', trim($updateData['theme_name']));
			$theme_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $theme_name);
			$themeData['theme_name'] = strtolower($theme_name);

			// Lowercase , Escape
			$child_theme = str_replace(' ', '_', trim($updateData['child_theme']));
			$child_theme = preg_replace('/[^A-Za-z0-9\-]/', '_', $child_theme);
			$themeData['child_theme'] = strtolower($child_theme);

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				if ($this->update($themeData)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$this->open($type); //Redirect to Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$this->open($type); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open($type, $message); //Open Page
			}
		} else {
			$this->session->set_flashdata('notification', 'notify'); //Notification Type
			$this->index(); //Redirect Index Module
		}
	}

	/**
	 * The function is used to update data in the table
	 * First parameter is the data to be updated 
	 *  N:B the data needed to be in an associative array form E.g $data = array('name' => 'theName');
	 *      the array key will be used as column name and the value as inputted Data
	 * 
	 */
	public function update($updateData)
	{

		//Chech allowed Access
		if ($this->CoreLoad->auth($this->Access)) { //Authentication

			//Pluralize Module
			$tableName = $this->plural->pluralize($this->Module);

			//Update Data In The Table
			foreach ($updateData as $key => $value) {
				$sql = "UPDATE `$tableName` SET `setting_value` = '$value' WHERE  `setting_title` = '$key' ";
				$results = $this->db->query($sql); //site_title
			}

			if ($results) {

				return true; //Data Updated
			} else {

				return false; //Data Updated Failed
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

/** End of file Users.php */
/** Location: ./application/controllers/Users.php */
