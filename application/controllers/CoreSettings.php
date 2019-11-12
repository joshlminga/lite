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
	
	private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

	private $Route = null; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default

	private $General = 'general/update'; //Settings
	private $Link = 'link/update'; //
	private $Mail = 'mail/update'; //
	private $Blog = 'blog/update'; //
	private $Seo = 'seo/update'; //
	private $Inheritance = 'inheritance/update'; //
	private $Modulelist = 'module/update'; //

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

		//Helpers
		date_default_timezone_set('Africa/Nairobi');

        //Models
		$this->load->model('CoreCrud');
		$this->load->model('CoreForm');
		
        // Your own constructor code
        
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

		//Post
		$data['posts'] = $this->CoreCrud->selectMultipleValue('pages','id,title',array('flg'=>1));

		//Form Submit URLs
		$data['form_general'] = $this->General;
		$data['form_link'] = $this->Link;
		$data['form_mail'] = $this->Mail;
		$data['form_blog'] = $this->Blog;
		$data['form_seo'] = $this->Seo;
		$data['form_inheritance'] = $this->Inheritance;
		$data['form_module'] = $this->Modulelist;

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
			$this->load->view("admin/layouts/$layout",$data);
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

		//Model Query

		//Table Select & Clause

		//Notification

		//Open Page
		$this->open('general');		
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

		//Set Allowed Files
		$allowed_files = (is_null($this->AllowedFile))? 'jpg|jpeg|png|doc|docx|pdf|xls|txt' : $this->AllowedFile;

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
							$url = $this->CoreCrud->postURL($post_id,null,'blog');

						    $sql = "UPDATE `blogs` SET `blog_url` = '$url' WHERE `blog_id` = '$post_id' ";
						    $results = $this->db->query($sql);//site_title
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
						    $results = $this->db->query($sql);//site_title
						}
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
		}elseif ($type == 'blog') {

			$updateData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("home_display", "Home Display", "trim|required|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("home_post", "Home Post", "trim|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("home_page", "Home Page", "trim|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("post_per_page", "Post Per Page", "trim|required|integer|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("post_show", "Post Show", "trim|required|min_length[1]|max_length[50]");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
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

			$this->form_validation->set_rules("seo_visibility", "Seo Visibility", "trim|required|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("seo_global", "Seo Global", "trim|required|min_length[1]|max_length[50]");
			$this->form_validation->set_rules("seo_description", "Seo Description", "trim|max_length[8000]");
			$this->form_validation->set_rules("seo_keywords", "Seo Keywords", "trim|max_length[8000]");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
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
		}elseif ($type == 'inheritance') {

			$updateData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("inheritance_data", "Inheritance Type Data", "trim");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
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
		}elseif ($type == 'module') {

			$updateData = $this->CoreLoad->input(); //Input Data

			$this->form_validation->set_rules("module_list", "Module List", "trim");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
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
		}elseif (end($page) == 'inheritance') {
			$where_in = array('inheritance_data');//Inheritance Data
		}elseif (end($page) == 'module') {
			$where_in = array('module_list');//Inheritance Data
		}else{
			$where_in = array('none');//General Update
		}

		//Search Data
		$resultList = $this->db->select('setting_title,setting_value')->where($where)
		              ->where_in('setting_title',$where_in)->get('settings');

		//Data Returned
		return $resultList->result();
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

			//Check Array
			if (array_key_exists($file_name,$_FILES)) {
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

		        //Check - validation_status
		        if (isset($validation_status)) {
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
				    $this->form_validation->set_message('validation', 'Please choose a file to upload.');
		        	return false; // Validation was successful
		        }
			}else{
			    $this->form_validation->set_message('validation', 'Please choose a file to upload.');
	        	return false; // Validation was successful
			}
	    }else{

	    	/* Your custom Validation Code Here */

	    	//Before returning validation status destroy session
	        $this->CoreCrud->destroySession($session_keys); //Destroy Session Values
	    }
    }

}

/* End of file CoreUsers.php */
/* Location: ./application/controllers/CoreUsers.php */