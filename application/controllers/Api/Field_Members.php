<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Field_Members extends CI_Controller
{

	/**
	 *
	 * The main controller for Administrator Backend
	 * -> The controller require to login as Administrator
	 */

	private $Module = 'field'; //Module

	private $AllowedFile = null; //Set Default allowed file extension, remember you can pass this upon upload to override default allowed file type. Allowed File Extensions Separated by | also leave null to validate using jpg|jpeg|png|doc|docx|pdf|xls|txt change this on validation function at the bottom

	private $Route = 'member'; //If you have different route Name to Module name State it here |This wont be pluralized

	private $FieldName = 'member'; // Custom Field Name for this Module 

	private $Unset = null; //Unset the following fields from the response | leave null to not unset any field

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
		$this->load->model('Api/AppNotify', 'AppNotify');
		$this->load->model('Api/ApiState', 'AppState');

		// Your own constructor code
		$this->db = $this->load->database('api', TRUE);

		// Your own constructor code

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
		global $Unset;

		// Image Data
		$allowed_files = $this->AllowedFile; //Set Allowed Files
		$upoadDirectory = "../assets/media"; //Custom Upload Location

		//Receive the RAW post data.

		$content = trim(file_get_contents("php://input")); // Takes raw data from the request
		$decoded = json_decode($content, true); // Converts it into a PHP object
		// Check Data
		$decoded = (!is_null($decoded) && !empty($decoded)) ? $decoded : $this->CoreLoad->input(null, 'get');

		// Token and Other Response
		$pre_response = $this->AppState->process($decoded);

		// load Token Model
		$token = $this->AppState->validate($pre_response['userToken']);
		$pre_response = $this->CoreCrud->unsetData($pre_response, ['userToken']);

		// Unset Headers
		$unsetData = (array_key_exists('coreunset', $decoded)) ? $decoded['coreunset'] : '';

		$decoded = $this->CoreCrud->unsetData($decoded, ['coretest', 'coreunset']);
		// Generate new array errors and assign empty value '' to each key found in decoded
		$errors = array_fill_keys(array_keys($decoded), '');

		//Check Validation
		if ($type == 'save' && $token) {

			$formData = $decoded; //Input Data
			/*** Allowing Codeigniter To Validate Via Get */
			$this->form_validation->set_data($formData);
			/***/

			$this->form_validation->set_rules('name', 'Full Name', 'trim|required|min_length[5]|max_length[50]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[50]|valid_email');
			$this->form_validation->set_rules("mobile", "Phone Number", "required|trim|min_length[10]|max_length[15]|callback_mobilecheck");
			$this->form_validation->set_rules("gender", "Gender", "trim|max_length[8]");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {

				$formData = $this->CoreCrud->unsetData($formData, array('id')); //Unset Data

				// Save Data
				$savedData = $this->CoreForm->saveFormField($formData, $this->FieldName);

				// Return QueryResponse
				$queryResponse = $this->create($savedData, $unsetData);

				if (is_numeric($queryResponse)) {

					// Status - Precondition Failed
					$response = $this->AppState->response_code(200);

					//Notification Message	
					$message = 'Data was saved successful'; //Notification Message
					$notification = $this->AppNotify->success($message);
					$response['message'] = $notification;

					// Set $keys[0] as array key for $errors[0] and so on
					$response['errors']  = [];
					$response['response'] = [
						['field_id' => $queryResponse]
					];
				} else {
					// Status - Precondition Failed
					$response = $this->AppState->response_code(412);

					//Notification Message	
					$notification = $this->AppNotify->error();
					$response['message'] = $notification;

					// Set $keys[0] as array key for $errors[0] and so on
					$response['errors']  = [
						'corelite' => 'system could not save the data, might be sql error, duplicate entry,invalid data or access level permission',
					];
				}
			} else {
				// Status - Bad Request
				$response = $this->AppState->response_code();

				//Notification Message	
				$message = 'Please check the fields, and try again';
				$notification = $this->AppNotify->error($message);
				$response['message'] = $notification;

				$response['errors'] = $this->AppState->error_response(validation_errors()); //Error Message
			}
		} elseif ($type == 'update' && $token) {

			$updateData = $decoded; //Input Data
			/*** Allowing Codeigniter To Validate Via Get */
			$this->form_validation->set_data($updateData);
			/***/

			//Input ID
			$inputID = $updateData['id'];

			$this->form_validation->set_rules('name', 'Full Name', 'trim|required|min_length[5]|max_length[50]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[50]|valid_email');
			$this->form_validation->set_rules("mobile", "Phone Number", "required|trim|min_length[10]|max_length[15]|callback_mobilecheck");
			$this->form_validation->set_rules("gender", "Gender", "trim|max_length[8]");

			//Form Validation
			if ($this->form_validation->run() == TRUE) {

				// Upload Data
				$updatedData = $this->CoreForm->updateFormField($updateData, $inputID);

				// Return QueryResponse
				$queryResponse = $this->update($updatedData, $inputID);

				if (is_numeric($queryResponse)) {

					// Status - Precondition Failed
					$response = $this->AppState->response_code(200);

					//Notification Message	
					$message = 'Data was updated successful'; //Notification Message
					$notification = $this->AppNotify->success($message);
					$response['message'] = $notification;

					// Set $keys[0] as array key for $errors[0] and so on
					$response['errors']  = [];
					$response['response'] = [
						['field_id' => $queryResponse]
					];
				} else {
					// Status - Precondition Failed
					$response = $this->AppState->response_code(412);

					//Notification Message	
					$notification = $this->AppNotify->error();
					$response['message'] = $notification;

					// Set $keys[0] as array key for $errors[0] and so on
					$response['errors']  = [
						'corelite' => 'system could not save the data, might be sql error, duplicate entry,invalid data or access level permission',
					];
				}
			} else {
				// Status - Bad Request
				$response = $this->AppState->response_code();

				//Notification Message	
				$message = 'Please check the fields, and try again';
				$notification = $this->AppNotify->error($message);
				$response['message'] = $notification;

				$response['errors'] = $this->AppState->error_response(validation_errors()); //Error Message
			}
		} elseif ($type == 'delete' && $token) {

			$deleteData = $decoded; //Input Data

			/*** Allowing Codeigniter To Validate Via Get */
			$this->form_validation->set_data($deleteData);
			/***/

			//Input ID
			$inputID = $deleteData['id'];

			$this->form_validation->set_rules('id', 'Field ID', 'trim|required|integer|min_length[1]|max_length[20]');

			//Form Validation
			if ($this->form_validation->run() == TRUE) {
				// Return QueryResponse
				$queryResponse = $this->delete($inputID);

				if ($queryResponse) {

					// Status - Precondition Failed
					$response = $this->AppState->response_code(200);

					//Notification Message	
					$message = 'Data was deleted successful'; //Notification Message
					$notification = $this->AppNotify->success($message);
					$response['message'] = $notification;

					// Set $keys[0] as array key for $errors[0] and so on
					$response['errors']  = [];
					$response['response'] = [];
				} else {
					// Status - Precondition Failed
					$response = $this->AppState->response_code(412);

					//Notification Message	
					$notification = $this->AppNotify->error();
					$response['message'] = $notification;

					// Set $keys[0] as array key for $errors[0] and so on
					$response['errors']  = [
						'corelite' => 'system could not save the data, might be sql error, duplicate entry,invalid data or access level permission',
					];
				}
			} else {
				// Status - Bad Request
				$response = $this->AppState->response_code();

				//Notification Message	
				$message = "Please check the fields, and try again.";
				$notification = $this->AppNotify->error($message);
				$response['message'] = $notification;

				$response['errors'] = $this->AppState->error_response(validation_errors()); //Error Message
			}
		} else {
			// Status - Unauthorized
			$response = $this->AppState->response_code(401);

			//Notification Message	
			$message = 'Wrong Request or Token';
			$notification = $this->AppNotify->error($message);
			$response['message'] = $notification;

			// Set $keys[0] as array key for $errors[0] and so on
			$response['errors']  = [
				'corelite' => 'check api route url or check token'
			];
		}

		// Update $errors with $response['errors'] 
		$response['errors'] = array_merge($errors, $response['errors']);
		// Other
		$code_feedback = ['params' => $decoded, 'module' => $this->Module, 'route' => $this->Route, 'controller' => $this->router->fetch_class() . '.php', 'queryResponse' => $this->db->error()];
		$response['feedback'] = (count($pre_response) > 0) ? array_merge($pre_response, $code_feedback) : ['test_response' => 'hidden'];
		// Set header Json
		header('Content-type: application/json');
		// Show Response
		echo json_encode($response);
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
		//Save
		$savedData = $this->CoreCrud->saveField($insertData);
		if ($this->CoreCrud->fieldStatus($savedData)) {
			$fieldID = $savedData['id'];

			return $fieldID; //Data Inserted
		} else {

			return false; //Data Insert Failed
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
		//Updated
		$updatedData = $this->CoreCrud->updateField($updateData, $valueWhere);
		if ($this->CoreCrud->fieldStatus($updatedData)) {
			$fieldID = $updatedData['id'];

			return $fieldID; //Data Inserted
		} else {

			return false; //Data Insert Failed
		}
	}

	/**
	 * The function is used to delete data in the table
	 * First parameter is the values to be passed in where clause N:B the data needed to be in an associative array form E.g $data = array('column' => 'value');
	 * 
	 */
	public function delete($fieldValue)
	{

		//Deleted Data In The Table
		$deleteData = $this->CoreCrud->deleteField($fieldValue);
		if ($this->CoreCrud->fieldStatus($deleteData)) {

			return true; //Data Deleted
		} else {

			return false; //Data Deletion Failed
		}
	}

	**
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
						$default_dial_code = (method_exists('CoreField',  'defaultDialCode')) ? $this->CoreField->defaultDialCode() : $country_code;

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

/** End of file Field_Members.php */
/** Location: ./application/controllers/API/Field_Members.php */
