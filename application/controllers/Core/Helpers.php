<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Helpers extends CI_Controller
{

	/**
	 *
	 * The main controller for Administrator Backend
	 * -> The controller require to login as Administrator
	 */

	private $Module = 'settings'; //Module
	private $Folder = 'configs'; //Set Default Folder For html files and Front End Use
	private $SubFolder = '/helper'; //Set Default Sub Folder For html files and Front End Use Start with /

	private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

	private $Route = 'helpers'; //If you have different route Name to Module name State it here |This wont be pluralized
	private $Access = 'helper'; // For Access Control | Matches ModuleList for Access Level

	private $New = 'helpers/new'; //New 
	private $Save = 'helpers/save'; //Add New 
	private $Edit = 'helpers/update'; //Update 

	private $ModuleName = 'Setting Helpers'; //Module Name

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
		//Pluralize Module
		$module = $this->plural->pluralize($this->Module);

		//Model Query
		$data = $this->load($this->plural->pluralize($this->Folder) . $this->SubFolder . "/list");

		//Table Select & Clause
		$where_in = json_decode($this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'setthelper']), true);
		$resultList = $this->db->select('setting_id as id,setting_title as title,setting_default as type,setting_flg as status')->where_in('setting_default', $where_in)->get('settings');
		$data['dataList'] = $resultList->result();

		//Notification
		$notify = $this->CoreNotify->notify();
		$data['notify'] = $this->CoreNotify->$notify($notifyMessage);

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
			$columns = array('id as id,title as title,value as value,default as default,flg as flg');
			$data['resultList'] = $this->CoreCrud->selectCRUD($module, $where, $columns);

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

			//Form Validation Values
			$this->form_validation->set_rules('setting_title', 'Setting Title', 'trim|required|min_length[1]|max_length[200]|callback_titlenot');
			$this->form_validation->set_rules('setting_default', 'Default Value', 'trim|max_length[25]|callback_mustnotbe');
			// Default
			$formData['setting_default'] = (!is_null($formData['setting_default']) && !empty($formData['setting_default'])) ? $formData['setting_default'] : 'helper';
			if (is_null($formData['general_value']) || empty($formData['general_value'])) {
				$this->form_validation->set_rules(
					'general_key[]',
					'Entry Value',
					'trim|required',
					array(
						'required' => 'You must input atleast one "Entry Value" below or "Data As String/Json" above.'
					)
				);
			} elseif (empty($formData['general_key'][0]) || is_null($formData['general_key'][0])) {
				$this->form_validation->set_rules(
					'general_value',
					'Data',
					'trim|required',
					array(
						'required' => '"Data As String/Json" above must not be empty, if you have not added atleast one "Entry Value" below.'
					)
				);
			}

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				// General
				$setting_value = (!empty($formData['general_key'][0]) && !is_null($formData['general_key'][0])) ? json_encode($formData['general_key']) : null;
				// Additional
				$general_value = $this->input->post('general_value');
				if (!is_null($general_value) && !empty($general_value)) {
					$additionalArray = json_decode($general_value, True);
					if (is_array($additionalArray)) {
						// Check $setting_value
						if (!is_null($setting_value)) {
							// decode
							$setting_value = json_decode($setting_value, True);
							$setting_value = array_merge($setting_value, $additionalArray);
						} else {
							$setting_value = $additionalArray;
						}
						// Encode
						$setting_value = json_encode($setting_value);
					} else {
						$setting_value = $general_value; //General Value
					}
				}

				// Setting Title & setting_default replace space with underscore & replace special characters with underscore & trim & lowercase
				$setting_title = str_replace(' ', '_', trim($formData['setting_title']));
				$setting_title = preg_replace('/[^A-Za-z0-9\-]/', '_', $setting_title);
				$setting_title = strtolower($setting_title);

				$setting_default = str_replace(' ', '_', trim($formData['setting_default']));
				$setting_default = preg_replace('/[^A-Za-z0-9\-]/', '_', $setting_default);
				$setting_default = strtolower($setting_default);

				// Value
				$saveHelper = [
					'setting_title' => $setting_title,
					'setting_value' => $setting_value,
					'setting_default' => $setting_default,
					'setting_flg' => 1,
				];
				//More Data
				if ($this->create($saveHelper)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$message = 'Data was saved successful'; //Notification Message				
					$this->index($message); //Open Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$this->open('add'); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->open('add', $message); //Open Page
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
							$this->update(array($column_flg => 1), array($column_id => $value_id)); //Call Update Function
						} elseif (strtolower($action) == 'deactivate') { //Item/Data Deactivation
							$this->update(array($column_flg => 0), array($column_id => $value_id)); //Call Update Function
						} elseif (strtolower($action) == 'delete') { //Item/Data Deletion
							$this->delete(array($column_id => $value_id)); //Call Delete Function
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
			$column_id = strtolower($this->CoreForm->get_column_name($this->Module, 'id')); //Column ID
			$value_id = $this->CoreLoad->input('id'); //Input Value

			//Form Validation Values
			$this->form_validation->set_rules('setting_title', 'Setting Title', 'trim|required|min_length[1]|max_length[200]|callback_titlenot');
			$this->form_validation->set_rules('setting_default', 'Default Value', 'trim|max_length[25]|callback_mustnotbe');
			// Default
			$updateData['setting_default'] = (!is_null($updateData['setting_default']) && !empty($updateData['setting_default'])) ? $updateData['setting_default'] : 'helper';
			if (is_null($updateData['general_value']) || empty($updateData['general_value'])) {
				$this->form_validation->set_rules(
					'general_key[]',
					'Entry Value',
					'trim|required',
					array(
						'required' => 'You must input atleast one "Entry Value" below or "Data As String/Json" above.'
					)
				);
			} elseif (empty($updateData['general_key'][0]) || is_null($updateData['general_key'][0])) {
				$this->form_validation->set_rules(
					'general_value',
					'Data',
					'trim|required',
					array(
						'required' => '"Data As String/Json" above must not be empty, if you have not added atleast one "Entry Value" below.'
					)
				);
			}

			//Select Value To Unset 
			$unsetData = array('id');/*valude To Unset*/

			//Form Validation
			if ($this->form_validation->run() == TRUE) {

				// General
				$setting_value = (!empty($updateData['general_key'][0]) && !is_null($updateData['general_key'][0])) ? json_encode($updateData['general_key']) : null;
				// Additional
				$general_value = $this->input->post('general_value');
				if (!is_null($general_value) && !empty($general_value)) {
					$additionalArray = json_decode($general_value, True);
					if (is_array($additionalArray)) {
						// Check $setting_value
						if (!is_null($setting_value)) {
							// decode
							$setting_value = json_decode($setting_value, True);
							$setting_value = array_merge($setting_value, $additionalArray);
						} else {
							$setting_value = $additionalArray;
						}
						// Encode
						$setting_value = json_encode($setting_value);
					} else {
						$setting_value = $general_value; //General Value
					}
				}

				// Setting Title & setting_default replace space with underscore & replace special characters with underscore & trim & lowercase
				$setting_title = str_replace(' ', '_', trim($updateData['setting_title']));
				$setting_title = preg_replace('/[^A-Za-z0-9\-]/', '_', $setting_title);
				$setting_title = strtolower($setting_title);

				$setting_default = str_replace(' ', '_', trim($updateData['setting_default']));
				$setting_default = preg_replace('/[^A-Za-z0-9\-]/', '_', $setting_default);
				$setting_default = strtolower($setting_default);

				// Value
				$updateHelper = [
					'setting_title' => $setting_title,
					'setting_value' => $setting_value,
					'setting_default' => $setting_default,
				];

				//Update Table
				if ($this->update($updateHelper, [$column_id => $value_id], $unsetData)) {
					$this->session->set_flashdata('notification', 'success'); //Notification Type
					$message = 'Data was updated successful'; //Notification Message				
					$this->edit('edit', 'id', $value_id); //Open Page
				} else {
					$this->session->set_flashdata('notification', 'error'); //Notification Type
					$this->edit('edit', 'id', $value_id); //Open Page
				}
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				$message = 'Please check the fields, and try again'; //Notification Message				
				$this->edit('edit', 'id', $value_id, $message); //Open Page
			}
		} elseif ($type == 'delete') {
			$value_id = $this->input->get('inputID'); //Get Selected Data
			$column_id = strtolower($this->CoreForm->get_column_name($this->Module, 'id'));

			if ($this->delete(array($column_id => $value_id)) == TRUE) { //Call Delete Function
				$this->session->set_flashdata('notification', 'success'); //Notification Type
				redirect($routeURL, 'refresh'); //Redirect Index Module
			} else {
				$this->session->set_flashdata('notification', 'error'); //Notification Type
				redirect($routeURL, 'refresh'); //Redirect Index Module
			}
		} else {
			$this->session->set_flashdata('notification', 'notify'); //Notification Type
			redirect($routeURL, 'refresh'); //Redirect Index Module
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

			//Pluralize Module
			$tableName = $this->plural->pluralize($this->Module);

			//Column Stamp
			$stamp = strtolower($this->CoreForm->get_column_name($this->Module, 'stamp'));
			$insertData["$stamp"] = date('Y-m-d H:i:s', time());

			//Insert Data Into Table
			$this->db->insert($tableName, $insertData);
			if ($this->db->affected_rows() > 0) {

				// Check setting_default
				$setting_default = $insertData['setting_default'];
				$setthelper = json_decode($this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'setthelper']), true);
				// check if setting_default is in the setthelper array
				if (!in_array($setting_default, $setthelper) && $setting_default != 'helper') {
					// push setting_default to where_in array
					array_push($setthelper, $setting_default);
					// Reset array
					$setthelper = array_values(array_unique($setthelper));
					// Encode
					$setting_value = json_encode($setthelper);
					// update the setting_default value to the new value
					// $this->update(['setting_value' => $setting_value], ['setting_title' => 'setthelper']);
					$this->db->update($tableName, ['setting_value' => $setting_value], ['setting_title' => 'setthelper']);
				}

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

			//Pluralize Module
			$tableName = $this->plural->pluralize($this->Module);
			// older default
			$oldDefault = $this->CoreCrud->selectSingleValue('settings', 'default', ['id' => $valueWhere['setting_id']]);

			//Update Data In The Table
			$this->db->update($tableName, $updateData, $valueWhere);
			if ($this->db->affected_rows() > 0) {
				// Check setting_default exist
				if (array_key_exists('setting_default', $updateData)) {
					$setting_default = $updateData['setting_default'];
					$setthelper = json_decode($this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'setthelper']), true);

					// Check old default
					if (is_null($this->CoreCrud->selectSingleValue('settings', 'id', ['default' => $oldDefault]))) {
						// remove value $oldDefault from the setthelper array
						if ($oldDefault != 'helper') {
							$key = array_search($oldDefault, $setthelper);
							unset($setthelper[$key]);
							// Reset array
							$setthelper = array_values(array_unique($setthelper));
						}
					}
					// check if setting_default is in the setthelper array
					if (!in_array($setting_default, $setthelper)) {
						// push setting_default to where_in array
						array_push($setthelper, $setting_default);
						// Reset array
						$setthelper = array_values(array_unique($setthelper));
					}
					// Encode
					$setting_value = json_encode($setthelper);
					// update the setting_default value to the new value
					$this->db->update($tableName, ['setting_value' => $setting_value], ['setting_title' => 'setthelper']);
				}
				return true; //Data Updated
			} else {

				return false; //Data Updated Failed
			}
		}
	}

	/**
	 * The function is used to delete data in the table
	 * First parameter is the values to be passed in where clause N:B the data needed to be in an associative array form E.g $data = array('column' => 'value');
	 * 
	 */
	public function delete($valueWhere)
	{

		if ($this->CoreLoad->auth($this->Access)) { //Authentication

			//Pluralize Module
			$tableName = $this->plural->pluralize($this->Module);
			$setthelper = json_decode($this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'setthelper']), true);
			$default = $this->CoreCrud->selectSingleValue('settings', 'default', ['id' => $valueWhere['setting_id']]);
			if (in_array($default, $setthelper)) {
				//Deleted Data In The Table
				$this->db->delete($tableName, $valueWhere);
				if ($this->db->affected_rows() > 0) {
					$setthelper = json_decode($this->CoreCrud->selectSingleValue('settings', 'value', ['title' => 'setthelper']), true);

					// Check old default
					if (is_null($this->CoreCrud->selectSingleValue('settings', 'id', ['default' => $default])) && $default != 'helper') {
						// remove value $oldDefault from the setthelper array
						$key = array_search($default, $setthelper);
						unset($setthelper[$key]);
						// Reset array
						$setthelper = array_values(array_unique($setthelper));
						// Encode
						$setting_value = json_encode($setthelper);
						// update the setting_default value to the new value
						$this->db->update($tableName, ['setting_value' => $setting_value], ['setting_title' => 'setthelper']);
					}

					return true; //Data Deleted
				} else {
					return false; //Data Deletion Failed
				}
			} else {
				return false; //Data Deletion Failed
			}
		}
	}

	/**
	 * Must not be
	 */
	public function mustnotbe($str)
	{
		//Value
		$setting_default = str_replace(' ', '_', trim($str));
		$setting_default = preg_replace('/[^A-Za-z0-9\-]/', '_', $setting_default);
		$setting_default = strtolower($setting_default);

		// Reserved Title names
		$where_in = ['field_menu', 'extension_menu', 'control_menu', 'menu_menu', 'route_menu', 'route', 'other', 'field', 'extension', 'control', 'yes', 'no', 'theme', 'keys', 'key'];
		$reserved = $this->db->select('setting_title as title')->where_in('setting_default', $where_in)->get('settings')->result();
		// Convert this object $reserved[index]->title to index based array 
		$reserved = array_column($reserved, 'title');
		// push mustnotbe
		$mustnotbe = ['field_menu', 'extension_menu', 'control_menu', 'menu_menu', 'route_menu', 'yes', 'no', 'route', 'theme', 'keys', 'key'];
		// merge mustnotbe and reserved
		$mustnotbe = array_merge($mustnotbe, $reserved);
		// remove duplicate values
		$reserved = array_unique($mustnotbe);

		// Check if value is in array
		if (in_array($setting_default, $reserved)) {
			$this->form_validation->set_message('mustnotbe', "'$str' cannot be used as type. '$str' is a reserved value");
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Setting_title titlenot
	 */
	public function titlenot($str)
	{
		// Value
		$setting_title = str_replace(' ', '_', trim($str));
		$setting_title = preg_replace('/[^A-Za-z0-9\-]/', '_', $setting_title);
		$setting_title = strtolower($setting_title);

		// Reserved Title names
		$where_in = ['field_menu', 'extension_menu', 'control_menu', 'menu_menu', 'route_menu', 'route', 'other', 'field', 'extension', 'control', 'yes', 'no', 'theme', 'keys', 'key'];
		$reserved = $this->db->select('setting_title as title')->where_in('setting_default', $where_in)->get('settings')->result();
		// Convert this object $reserved[index]->title to index based array 
		$reserved = array_column($reserved, 'title');
		// push mustnotbe
		$mustnotbe = ['field_menu', 'extension_menu', 'control_menu', 'menu_menu', 'route_menu', 'yes', 'no', 'route', 'theme', 'keys', 'key'];
		// merge mustnotbe and reserved
		$mustnotbe = array_merge($mustnotbe, $reserved);
		// remove duplicate values
		$reserved = array_unique($mustnotbe);

		// Check if value is in array
		if (in_array($setting_title, $reserved)) {
			$this->form_validation->set_message('titlenot', "'$str' cannot be used. Try another Title");
			return false;
		} else {
			return true;
		}
	}
}

/* End of file Helpers.php */
