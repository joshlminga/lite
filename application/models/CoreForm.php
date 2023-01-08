<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CoreForm extends CI_Model
{


	/**
	 *
	 * To load libraries/Model/Helpers/Add custom code which will be used in this Model
	 * This can ease the loading work 
	 * 
	 */
	public function __construct()
	{

		parent::__construct();

		//libraries

		//Helpers

		//Models

		// Your own constructor code

	}


	/**
	 *
	 * Get Table Column Name and Column Type
	 * Function accept Module name then it pluralize it to get table name
	 * 
	 */
	public function get_column_data($module)
	{
		//Get Table Name
		$table = $this->plural->pluralize($module);
		$database = $this->db->database;

		//Query
		$query = $this->db->query("SELECT COLUMN_NAME, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$table' ");
		return $query->result();
	}

	/**
	 *
	 * This function help you to check if Table exist
	 *
	 * 1: Pass Tablename
	 *
	 */
	public function checkTable($tableName)
	{
		// Get Custom Field Title
		$tableName = $this->plural->pluralize($tableName);

		// Show DB Tables
		$result = $this->db->query("SHOW TABLES LIKE '" . $tableName . "'");
		if ($result->result_id->num_rows == 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 *
	 * Function to generate columns name or Type Array
	 * Pass columns Name & Type array
	 * 
	 */
	public function get_column_name_type($column_name_type, $get = 'name')
	{
		//Array to store Data
		$name_type = array();
		//Get Type/Name
		if (strtolower($get) == 'type') {
			//Get Type
			for ($i = 0; $i < count($column_name_type); $i++) {
				$name_type[$i] = $column_name_type[$i]->COLUMN_TYPE; // Assign Column Type
			}
		} else {
			//Get Name
			for ($i = 0; $i < count($column_name_type); $i++) {
				$name_type[$i] = $column_name_type[$i]->COLUMN_NAME; // Assign Column Name
			}
		}

		//Return Data
		return $name_type;
	}

	/**
	 *
	 * The function generate proper multiple/single column names
	 * The function accepts
	 * 1: Module Name
	 * 2: Column simple name(s)
	 * 
	 */
	public function get_column_name($module, $column)
	{
		//Singularize Module
		$module = $this->plural->singularize($module);

		if (!is_array($column) && strpos($column, ",") == False) {
			$column_name = $module . '_' . $column; //Column Name
		} else {
			if (!is_array($column) && strpos($column, ",") == True) {
				$column = explode(",", $column);
				/** Get Column Name */
			}
			for ($i = 0; $i < count($column); $i++) {
				$column_name[$i] = $this->get_column_name($module, $column[$i]); //Column Name
			}
		}

		return $column_name; //Column Name
	}

	/**
	 *
	 * Function to remove column Name and Return Label Name
	 * Pass columns name(s) array/string
	 * Pass Table/Module/Filter/Route Name (Optional)
	 * 
	 */
	public function get_label_name($column, $module = null)
	{
		// Table
		$module = (is_null($module)) ? null : $this->plural->singularize($module);

		//Check If Value Passed is Not Array
		if (!is_array($column) && strpos($column, ",") == False) {
			// Module
			if (!is_null($module)) {
				$table_column = explode($module, $column);
				$column = (array_key_exists(1, $table_column)) ? $table_column[1] : $column;
			}
			$label =  substr($column, strpos($column, "_") + 1); //Get Current Label Name
		} else {
			if (!is_array($column) && strpos($column, ",") == True) {
				$column = explode(",", $column);
				/** Get Column Name */
			}
			//Remove Module Name
			for ($i = 0; $i < count($column); $i++) {
				$column_name = $column[$i]; //Set Current Column Name
				// Module
				if (!is_null($module)) {
					$table_column = explode($module, $column_name);
					$column_name = (array_key_exists(1, $table_column)) ? $table_column[1] : $column_name;
				}
				$label[$i] =  substr($column_name, strpos($column_name, "_") + 1); //Get Current Label Name
			}
		}

		return $label; //Return Label List
	}

	/**
	 *
	 * Set Validation Session Data
	 *
	 * This function allow you to change validation Session Data with Ease during validation Process
	 * This function accept
	 *
	 * Session Data as Array=>Key
	 * 
	 */
	public function validation_session($validation)
	{
		//Set Session Data
		$filename = (array_key_exists("file_name", $validation)) ? $validation['file_name'] : $this->session->file_name; //File Name
		$required = (array_key_exists("file_required", $validation)) ? $validation['file_required'] : $this->session->file_required; //Required

		//Set Upload File Values
		$file_upload_session = array('file_name' => $filename, 'file_required' => $required);
		$this->session->set_userdata($file_upload_session);
	}

	/**
	 *
	 * Get User Profile
	 * This function is used to get user profile is isset
	 *
	 * Pass user ID (If null -> session ID will be take)
	 * Pass user Profile Keyname (By default is user-profile)
	 * Pass Default Optional Profile [Pass either yes/no] (By default it will use level from user_level)
	 */
	public function userProfile($userId = null, $profileKey = 'user_profile', $userDefault = null)
	{
		//User ID
		$user = (is_null($userId)) ? $this->CoreLoad->session('id') : $userId;
		//User Level
		$level =  $this->CoreCrud->selectSingleValue('users', 'level', array('id' => $user));

		//Default Profile
		$userDefault = $this->CoreCrud->selectSingleValue('levels', 'default', array('name' => $level));
		//Profile Name
		$optionalProfile = ($userDefault == 'yes') ? 'assets/admin/img/profile-pics/admin.jpg' : 'assets/admin/img/profile-pics/user.jpg';

		//Get Profile
		$details = $this->CoreCrud->selectSingleValue('users', 'details', array('id' => $user));
		$detail = json_decode($details, True);
		//Check Profile
		if (!is_null($detail)) {
			if (array_key_exists($profileKey, $detail)) {
				$user_profile = json_decode($detail[$profileKey], True); //User Profile Array
				if (is_array($user_profile)) {
					$profile = $user_profile[0]; //Profile Picture
				} else {
					$profile = null; //No Profile Set
				}
			} else {
				$profile = null; //No Profile Set
			}
		} else {
			$profile = null; //No Profile Set
		}

		//Get Profile
		$profile = (is_null($profile)) ? $optionalProfile : $profile;
		return $profile;
	}

	/**
	 *
	 * Form Save Field
	 * This function will prepaire data to be saved
	 *
	 * Function will return form Data Ready To Save
	 *
	 * This function accept 
	 * 1: Form Data To Save
	 * 2: Input ID To Get CustomFields
	 * 3: Pass unsetData By Default is null
	 * 4: Pass Unset Before/After NB: By Default it will unset Before, To Unset After Pass | after
	 * 5: Additional Optional Filters
	 * 6: Module affeted => By Defult is 'field'
	 * 
	 */
	public function saveFormField($formData, $inputID, $unsetData = null, $unsetKey = 'before', $addFilters = null, $Module = 'field')
	{

		//Check Field -> Stamp | Default | Flg
		$stamp_column = strtolower($this->get_column_name($Module, 'stamp'));
		$default_column = strtolower($this->get_column_name($Module, 'default'));
		$flg_column = strtolower($this->get_column_name($Module, 'flg'));
		$formCheck = $formData;
		$formData = $this->CoreCrud->unsetData($formData, array('stamp', $stamp_column, 'default', $default_column, 'flg', $flg_column));

		//Table Select & Clause
		$customFieldTable = $this->plural->pluralize('customfields');

		//Columns
		$columns = array('title as title,filters as filters,inputs as inputs,keys as keys,default as default');

		//Check Field Type
		$whereTYPE = (is_numeric($inputID)) ? 'id' : 'title';
		$where = array($whereTYPE => $inputID);

		//Select
		$fieldList = $this->CoreCrud->selectCRUD($customFieldTable, $where, $columns);

		$field_title = $fieldList[0]->title; //Title Title
		$field_filter = json_decode($fieldList[0]->filters, True); //FIlter List
		$field_key = json_decode($fieldList[0]->keys, True); //All Inputs
		$field_default = $fieldList[0]->default; //Default

		// Trigger For Plain Helper
		$this->load->model('CoreTrigger');
		$plainHelper = $this->plural->singularize($field_title) . '_fieldPlain';
		$formData = ((method_exists('CoreTrigger', $plainHelper))) ? $this->CoreTrigger->$plainHelper($formData) : $formData;

		// Values For Plain
		$newPlainDataValue = array();
		if (is_array($field_key)) {
			// UsePlain
			$usePlainHelper = $this->plural->singularize($field_title) . '_fieldUsePlain';
			$usePlain = ((method_exists('CoreTrigger', $usePlainHelper))) ? $this->CoreTrigger->$usePlainHelper() : true;
			if ($usePlain) {
				// Loop $field_show
				foreach ($field_key as $key => $value) {
					$value = trim($value);
					$key_value = "plain_" . $value;
					if (array_key_exists($key_value, $formData) && !array_key_exists($value, $newPlainDataValue)) {
						if (!is_array($formData[$key_value])) {
							$newPlainDataValue[$value] = strip_tags(stripcslashes(strtolower($formData[$key_value])));
						}
					} else {
						// Check If Key Exists
						if (array_key_exists($value, $formData)) {
							if (!is_array($formData[$value])) {
								$newPlainDataValue[$value] = strip_tags(stripcslashes(strtolower($formData[$value])));
							}
						}
					}
				}
			}
		}

		//UnSet ID
		$formData = $this->CoreCrud->unsetData($formData, array('id'));
		// Remove unescaped
		foreach ($formData as $key => $value) {
			$key_name = "plain_" . $key;
			if (array_key_exists($key_name, $formData)) {
				$formData = $this->CoreCrud->unsetData($formData, array($key_name)); //Unset Data
			}
		}

		// Loop to check missing $field_filter values
		foreach ($field_filter as $key => $value) {
			if (!array_key_exists($value, $formData)) {
				$formData[$value] = "filter_key: $value is missing.";
			}
		}

		// Loop to check unwanted extra values
		foreach ($field_key as $key => $value) {
			(array_key_exists($value, $formData)) ? $saveData[$value] = $formData[$value] : $saveData[$value] = null;
		}

		//Set Field Data
		$column_data = strtolower($this->get_column_name($Module, 'data'));
		$formData[$column_data] = json_encode($saveData); //Set Data

		//Prepaire Data To Store
		foreach ($formData as $key => $value) {
			if ($key !== $column_data) {
				$children[$key] = $value;
				$formData = $this->CoreCrud->unsetData($formData, array($key)); //Unset Data
			}
		}

		//Set Title/Name
		$column_title = strtolower($this->get_column_name($Module, 'title'));
		$formData[$column_title] = $field_title; //Set Title

		//Set Plain
		$column_plain = strtolower($this->get_column_name($Module, 'plain'));
		$tempo_plain = (count($newPlainDataValue) > 0) ? implode(' ', $newPlainDataValue) : null;
		$tempo_plain = iconv('UTF-8', 'ASCII//TRANSLIT', $tempo_plain);
		// Assign
		$formData[$column_plain] = (!is_null($tempo_plain) && !empty($tempo_plain)) ? json_encode($tempo_plain) : null;

		/** Set Plain */

		//Details Column Update
		$details = strtolower($this->get_column_name($Module, 'details'));

		//Apply Field -> Stamp | Default | Flg
		$formData = $this->applyCheckFieldTable($formData, $formCheck, $Module);

		//Check Unset Key
		if (strtolower($unsetKey) == 'before') {
			$formData = $this->CoreCrud->unsetData($formData, $unsetData); //Unset Data
			$form_detail = [
				'field_data' => $formData['field_data'],
				'field_title' => $formData['field_title'],
			];
			$formData[$details] = json_encode($form_detail); //Details
		} else {
			$form_detail = [
				'field_data' => $formData['field_data'],
				'field_title' => $formData['field_title'],
			];
			$formData[$details] = json_encode($form_detail); //Details
			$formData = $this->CoreCrud->unsetData($formData, $unsetData); //Unset Data
		}

		//Form Data
		return $formData;
	}

	/**
	 *
	 * Form Update Field
	 * This function will prepaire data to be updated
	 *
	 * Function will return form Data Ready To Update
	 *
	 * This function accept 
	 * 1: Form Data To Update
	 * 2: Input ID To Get CustomFields
	 * 3: Pass unsetData By Default is null
	 * 4: Pass Unset Before/After NB: By Default it will unset Before, To Unset After Pass | after
	 * 5: Additional Optional Filters
	 * 6: Module affeted => By Defult is 'field'
	 * 
	 */
	public function updateFormField($updateData, $inputID, $unsetData = null, $unsetKey = 'before', $addFilters = null, $Module = 'field')
	{

		//Check Field -> Stamp | Default | Flg
		$stamp_column = strtolower($this->get_column_name($Module, 'stamp'));
		$default_column = strtolower($this->get_column_name($Module, 'default'));
		$flg_column = strtolower($this->get_column_name($Module, 'flg'));
		$formCheck = $updateData;

		//Unset Stamp,Default,flg
		$updateData = $this->CoreCrud->unsetData($updateData, array('stamp', $stamp_column, 'default', $default_column, 'flg', $flg_column));

		//Table
		$customFieldTable = $this->plural->pluralize('customfields');

		//Check Field Type
		$whereTYPE = (is_numeric($inputID)) ? 'id' : 'title';
		$where = array($whereTYPE => $inputID);

		//Table Select & Clause
		$columns = array('id as id,title as title,data as data,plain as show,details as details');

		$resultList = $this->CoreCrud->selectCRUD($Module, $where, $columns);

		//Table Select & Clause
		$columns = array('id as id,title as title,filters as filters,keys as keys,default as default');
		$where = array('title' => $resultList[0]->title);
		$fieldList = $this->CoreCrud->selectCRUD($customFieldTable, $where, $columns, 'like');

		//FIlter List
		$field_title = $fieldList[0]->title; //Title Title
		$field_filter = json_decode($fieldList[0]->filters, True); //FIlter List
		$field_key = json_decode($fieldList[0]->keys, True); //Show
		$field_default = $fieldList[0]->default; //Default

		//Get Current Data
		$current_data = json_decode($resultList[0]->data, True);

		// Arrange Data
		foreach ($current_data as $key => $value) {
			if (!array_key_exists($key, $updateData)) {
				$updateData[$key] = $value;
			}
		}
		// Trigger For Plain Helper
		$this->load->model('CoreTrigger');
		$plainHelper = $this->plural->singularize($field_title) . '_fieldPlain';
		$updateData = ((method_exists('CoreTrigger', $plainHelper))) ? $this->CoreTrigger->$plainHelper($updateData) : $updateData;

		// Values For Show
		$newPlainDataValue = array();
		if (is_array($field_key)) {
			// UsePlain
			$usePlainHelper = $this->plural->singularize($field_title) . '_fieldUsePlain';
			$usePlain = ((method_exists('CoreTrigger', $usePlainHelper))) ? $this->CoreTrigger->$usePlainHelper() : true;
			if ($usePlain) {
				// Loop $field_show
				foreach ($field_key as $key => $value) {
					$value = trim($value);
					$key_value = "plain_" . $value;
					if (array_key_exists($key_value, $updateData) && !array_key_exists($value, $newPlainDataValue)) {
						if (!is_array($updateData[$key_value])) {
							$newPlainDataValue[$value] = strip_tags(stripcslashes(strtolower($updateData[$key_value])));
						}
					} else {
						// Check If Key Exists
						if (array_key_exists($value, $updateData)) {
							if (!is_array($updateData[$value])) {
								$newPlainDataValue[$value] = strip_tags(stripcslashes(strtolower($updateData[$value])));
							}
						}
					}
				}
			}
		}

		//UnSet ID
		$updateData = $this->CoreCrud->unsetData($updateData, array('id'));
		// Remove unesacped
		foreach ($updateData as $key => $value) {
			$key_name = "plain_" . $key;
			if (array_key_exists($key_name, $updateData)) {
				$updateData = $this->CoreCrud->unsetData($updateData, array($key_name)); //Unset Data
			}
		}

		// Loop to check unwanted extra values
		foreach ($field_key as $key => $value) {
			if (array_key_exists($value, $updateData)) {
				$editData[$value] = $updateData[$value];
			}
		}

		//Set Field Data
		$column_data = strtolower($this->get_column_name($Module, 'data'));
		$updateData[$column_data] = json_encode($editData); //Set Data

		//Prepaire Data To Store
		foreach ($updateData as $key => $value) {
			if ($key !== $column_data) {
				$children[$key] = $value;
				$updateData = $this->CoreCrud->unsetData($updateData, array($key)); //Unset Data
			}
		}

		//Set Plain
		$column_plain = strtolower($this->get_column_name($Module, 'plain'));
		$tempo_plain = (count($newPlainDataValue) > 0) ? implode(' ', $newPlainDataValue) : null;
		$tempo_plain = iconv('UTF-8', 'ASCII//TRANSLIT', $tempo_plain);
		// Assign
		$updateData[$column_plain] = (!is_null($tempo_plain) && !empty($tempo_plain)) ? json_encode($tempo_plain) : null;
		/** Set Plain */

		//Details Column Update
		$details = strtolower($this->get_column_name($Module, 'details'));
		$current_details = json_decode($resultList[0]->details, true);

		//Apply Field -> Stamp | Default | Flg
		$updateData = $this->applyCheckFieldTable($updateData, $formCheck, $Module);

		//Check Unset Key
		if (strtolower($unsetKey) == 'before') {
			$updateData = $this->CoreCrud->unsetData($updateData, $unsetData); //Unset Data
			foreach ($updateData as $key => $value) {
				if ($key != 'field_plain') {
					$current_details["$key"] = $value;
					/** Update -> Details */
				}
			}
			$updateData["$details"] = json_encode($current_details);
		} else {
			foreach ($updateData as $key => $value) {
				if ($key != 'field_plain') {
					$current_details["$key"] = $value;
					/** Update -> Details */
				}
			}
			$updateData["$details"] = json_encode($current_details);
			$updateData = $this->CoreCrud->unsetData($updateData, $unsetData); //Unset Data
		}

		//Update Data
		return $updateData;
	}

	/**
	 * 
	 * This function will apply stamp | default | flg
	 *
	 * This function accept 
	 * 1: Current Form Data
	 * 2: Reserved Form Data
	 * 3: Module affeted => By Defult is 'field'
	 *
	 */
	public function applyCheckFieldTable($formData, $formCheck, $Module = 'field')
	{

		//Columns
		$stamp_column = strtolower($this->get_column_name($Module, 'stamp'));
		$default_column = strtolower($this->get_column_name($Module, 'default'));
		$flg_column = strtolower($this->get_column_name($Module, 'flg'));

		//Check Stamp
		$stamp = (array_key_exists('stamp', $formCheck)) ? $formCheck['stamp'] : null;
		$stamp = (array_key_exists($stamp_column, $formCheck)) ? $formCheck[$stamp_column] : $stamp;
		$formData[$stamp_column] = $stamp;

		//Check Default
		$default = (array_key_exists('default', $formCheck)) ? $formCheck['default'] : null;
		$default = (array_key_exists($default_column, $formCheck)) ? $formCheck[$default_column] : $default;
		$formData[$default_column] = $default;

		//Check Flg
		$flg = (array_key_exists('flg', $formCheck)) ? $formCheck['flg'] : null;
		$flg = (array_key_exists($flg_column, $formCheck)) ? $formCheck[$flg_column] : $flg;
		$formData[$flg_column] = $flg;

		//Remove Null Values
		foreach ($formData as $key => $value) {
			$formData = (is_null($value)) ? $this->CoreCrud->unsetData($formData, array($key)) : $formData;
		}

		//Return Data
		return $formData;
	}

	/**
	 * 
	 * This function will apply stamp | default | flg
	 * -> This is only used for Filter Table
	 *
	 * This function accept 
	 * 1: Current Form Data
	 * 2: Reserved Form Data
	 * 3: Module affeted
	 *
	 */
	public function applyCheckFilterTable($formData, $formCheck, $Module)
	{
		//Columns
		$stamp_column = strtolower($this->get_column_name($Module, 'stamp'));
		$default_column = strtolower($this->get_column_name($Module, 'default'));
		$flg_column = strtolower($this->get_column_name($Module, 'flg'));

		//Check Stamp
		$stamp = (array_key_exists('field_stamp', $formCheck)) ? $formCheck['field_stamp'] : date('Y-m-d H:i:s', time());
		$formData[$stamp_column] = $stamp;

		//Check Default
		$default = (array_key_exists('field_default', $formCheck)) ? $formCheck['field_default'] : null;
		$formData[$default_column] = $default;

		//Check Flg
		$flg = (array_key_exists('field_flg', $formCheck)) ? $formCheck['field_flg'] : null;
		$formData[$flg_column] = $flg;

		//Remove Null Values
		foreach ($formData as $key => $value) {
			$formData = (is_null($value)) ? $this->CoreCrud->unsetData($formData, array($key)) : $formData;
		}

		//Return Data
		return $formData;
	}

	/**
	 *
	 * Get Form and Set Data into Field Format
	 *
	 * 1: Pass FormData 
	 * 2: Pass 'customfields' ID/Title to macth the Field Form
	 * 3: Pass unsetData By Default is null
	 * 4: Pass Unset Before/After NB: By Default it will unset Before, To Unset After Pass | after
	 *
	 * retuned DATA is ready for Inserting
	 */
	public function getFieldFormatData($formData, $fieldSet, $unsetData = null, $unsetKey = 'before')
	{

		//FormData
		$formData = $this->saveFormField($formData, $fieldSet);
		return $formData; //Return Data
	}

	/**
	 *
	 * Get Form and Set Data into Field Format
	 *
	 * 
	 * 1: Pass FormData 
	 * 2: Pass 'customfields' ID/Title to macth the Field Form
	 * 3: Pass unsetData By Default is null
	 * 4: Pass Unset Before/After NB: By Default it will unset Before, To Unset After Pass | after
	 *
	 * retuned DATA is ready for Updating
	 */
	public function getFieldUpdateData($updateData, $fieldSet, $unsetData = null, $unsetKey = 'before')
	{

		//FormData
		$updateData = $this->updateFormField($updateData, $fieldSet);
		return $updateData; //Return Data
	}

	/**
	 *
	 * This function is to check if array key Exist
	 * 1: Pass key Required (can be single value, array, ore string separated by comma)
	 * 2: Optional ArrayData to check if it has a particular key | else set this using session 'arrayData'
	 * 
	 * NB:
	 * If you pass single key value, the result will be True/False
	 * Else is an array will be returned
	 * 
	 */
	public function checkKeyExist($key, $array = null)
	{

		//By Default - Not Found
		$found = array();

		//Check Array Data
		$arrayData = (!is_null($array)) ? $array : $this->session->arrayData;

		//Check Passed Data
		if (count($arrayData) > 0) {
			//If Key Is not array
			if (!is_array($key)) {
				$keyData = explode(',', $key);
			}

			//Check Data
			for ($i = 0; $i < count($keyData); $i++) {
				$currentKey = $keyData[0];
				if (array_key_exists($currentKey, $arrayData)) {
					$found[$currentKey] = true; //Found
				} else {
					$found[$currentKey] = false; //Not Found
				}
			}

			//Count Found | if is equal to 1 return single value else return array of results
			if (count($found) == 1) {
				$arratKeys = array_keys($found); //Found Key
				$foundKey = $arratKeys[0]; //Single Key
				$found = $found[$foundKey]; //Return Value
			}
		}

		return $found; //Found-NotFound (True,False)   
	}

	/**
	 *
	 * This function checks if directory/file exists
	 * 1: Pass dir/file full path/ path & name | as required by Core Lite
	 * 2: Create dir/file (By default dir/file will be created)
	 * 3: Permission By default is 0755
	 *
	 * NB:
	 * You can override this by creating function dirCreate() in CoreTrigger
	 * -> This will return false if director do not exist
	 * -> Also you can overide permission form 0755
	 *
	 * --> By default dir will be created hence returned TRUE
	 * 
	 */
	public function checkDir($path, $create = true, $defaultpath = '../assets/media', $permission = 0755, $recursive = true)
	{
		//load ModelField
		$this->load->model('CoreTrigger');

		//Folder Path
		$pathFolder = realpath(APPPATH . $defaultpath); //Real Path
		$newDirectory = $pathFolder . $path; // New Path | New APPATH Directory

		//Check Additonal Config
		if (method_exists('CoreTrigger', 'changeDirData')) {
			//Config
			$configDir = $this->CoreTrigger->changeDirData($newDirectory, $permission, $recursive);
			$newDirectory = $configDir['dir']; // New Path | New APPATH Directory
			$permission = $configDir['permission']; //Deafault
			$recursive = $configDir['recursive']; //Deafult
		}

		//Check Dir/File 
		if (!file_exists($newDirectory)) {
			if ($create) {
				mkdir($newDirectory, $permission, $recursive); // Create Directory
				$status = true; // //Folder or file created
			} else {
				$status = false; // Folder or file could not be created
			}
		} else {
			$status = true; // //Folder or file exist
		}

		return $status; //Return Status
	}

	/**
	 *
	 * Get Parent Children
	 * Pass Parent Element ID
	 * 
	 */
	public function childTreee($parent_id = 0, $sub_mark = '', $selectedID = null, $type = null)
	{
		$setChildTree = false;

		//load ModelField
		if (is_null($type)) {
			$this->load->model('CoreTrigger');
			$setChildTree = ((method_exists('CoreTrigger', 'setChildTree'))) ? $this->CoreTrigger->setChildTree() : $setChildTree;

			//Set Type
			$type = (!$setChildTree) ? 'category' : $setChildTree;
		}

		//Select Data
		$inheritance = $this->CoreCrud->selectInheritanceItem(
			array('parent' => $parent_id, 'flg' => 1, 'type' => $type),
			'id,parent,title'
		);

		// Check IF Result Found
		if (count($inheritance) > 0) {
			for ($i = 0; $i < count($inheritance); $i++) {
				$parent = $inheritance[$i]->inheritance_parent; //Parent
				$title = $inheritance[$i]->inheritance_title; //Title
				$id = $inheritance[$i]->inheritance_id; //Id

				//Echo Data
				if ($selectedID == $id) {
					echo "<option class='$id' value='$id' selected>";
					echo $sub_mark . ucwords($title);
					echo "</option>";
				} else {
					echo "<option class='$id' value='$id'>";
					echo $sub_mark . ucwords($title);
					echo "</option>";
				}

				//Check More Child
				return $this->childTreee($id, $sub_mark = '---', $selectedID);
			}
		}
	}

	/**
	 *
	 * Get Element Parent ID
	 *
	 * Pass elementID and it will return it's Parent ID
	 * 
	 */
	public function getParentInheritance($inheritanceID, $parentID = 0)
	{
		//Select Parent
		$parent = $this->CoreCrud->selectSingleValue('inheritances', 'parent', array('id' => $inheritanceID));

		//Check If is Parent
		if ($parent == $parentID) {
			return $inheritanceID; //Parent Value
		} else {
			return $this->getParentInheritance($parent); //Find Parent
		}
	}

	/**
	 *
	 * Email
	 * Get email data & configuration
	 * 
	 */
	public function email_config()
	{
		//Get Send Data
		$settings['mail_protocol'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'mail_protocol'));
		$settings['smtp_host'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'smtp_host'));
		$settings['smtp_user'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'smtp_user'));
		$settings['smtp_pass'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'smtp_pass'));
		$settings['smtp_port'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'smtp_port'));
		$settings['smtp_timeout'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'smtp_timeout'));
		$settings['smtp_crypto'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'smtp_crypto'));
		$settings['wordwrap'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'wordwrap'));
		$settings['wrapchars'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'wrapchars'));
		$settings['mailtype'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'mailtype'));
		$settings['charset'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'charset'));

		//load ModelField
		$this->load->model('CoreTrigger');
		$emailConfig = ((method_exists('CoreTrigger', 'emailConfig'))) ? $this->CoreTrigger->emailConfig() : false;

		//Configs
		if ($emailConfig) {
			foreach ($emailConfig as $key => $value) {
				$settings[$key] = $value; //Settings
			}
		}

		//Check For Null Values
		foreach ($settings as $key => $value) {
			if (is_null($value) || empty($value)) {
				$this->CoreCrud->unsetData($settings, array($key));
			} else {
				$config[$key] = $value; //Clean Values
			}
		}

		return $config; //Return Configs
	}

	/**
	 *
	 * This function help user to access / get account profile picture
	 * Account Profile
	 */
	public function accountProfile($useraccount = null, $profile_name = 'user_profile')
	{
		//Check Account
		$account = (is_null($useraccount)) ? array('id' => $this->CoreLoad->session('id')) : $useraccount;
		//User Details
		$userDetails = json_decode($this->CoreCrud->selectSingleValue('user', 'details', $account), True);
		$profile = (array_key_exists($profile_name, $userDetails)) ? json_decode($userDetails[$profile_name]) : array(null);

		//Check Found
		$profile = (!is_null($profile[0]) && !empty($profile[0])) ? $profile[0] : null;
		$userProfile[$profile_name] = $profile; //Profile

		//Return Data
		return $userProfile;
	}

	/**
	 *
	 *
	 * This function help you to get file name
	 *
	 * 1: Pass file line
	 * 2: State if you want extension returned of not | Default 'True'
	 * 3: Pass file separator value | Default '/'
	 *
	 * Get File Name From Attached Link
	 */
	public function getfileName($assetLink, $ext = true, $separator = '/')
	{
		//Change link to array
		$file_link = (!is_array($assetLink)) ? explode($separator, $assetLink) : $assetLink;

		//Get end of array
		$file_full = end($file_link);
		if (!$ext) {
			$get = explode('.', $file_full);
			$file_name = $get[0];
		} else {
			$file_name = $file_full;
		}

		//File Name
		return $file_name;
	}

	/**
	 *
	 * This function is a subfunction of getting file name, this function will only retur extension of the file
	 *
	 * 1: Pass file line
	 * 2: State if you want extension returned of not | Default 'True'
	 * 3: Pass file separator value | Default '/'
	 *
	 * Get File Extension Only
	 */
	public function getfileExt($assetLink, $file = false, $separator = '/')
	{
		//Get File Name
		$file_name = (!$file) ? $this->getfileName($assetLink, true, $separator) : $assetLink;

		//Get Extension
		$get = explode('.', $file_name);
		$extension = end($get);

		//File Extension
		return $extension;
	}

	/**
	 *
	 * This function help you to get filter table columns ready to match filter custom field values
	 *
	 * 1: Pass customfield title/id
	 * 2: Pass Addirional Columns (as array or as comma separated string)
	 * 3: Pass escaped values (Values you wish system to handle ot it's own) | id,details,stamp,default,flg
	 *
	 * Get Filter Tables
	 */
	public function getFilterColumns($titleID, $pusharray = null, $escaped_columns = array('id', 'details', 'stamp', 'default', 'flg'))
	{

		// Get Custom Field Title
		if (is_numeric($titleID)) {
			$titleID = $this->CoreCrud->selectSingleValue('customfields', 'title', array('id' => $titleID)); // Title ID
		}
		$tableName = $this->plural->pluralize($titleID);

		$table_desc = $this->get_column_data($tableName);
		$columns = $this->get_column_name_type($table_desc);

		// Escape Columns
		if (!is_null($escaped_columns)) {
			for ($i = 0; $i < count($escaped_columns); $i++) {
				$escape = $escaped_columns[$i];

				// Columns Name
				$column_escape = strtolower($this->get_column_name($tableName, $escape));
				if (in_array($column_escape, $columns)) {
					$key = array_search($column_escape, $columns);
					$columns = $this->CoreCrud->unsetData($columns, $key); //Unset Data
				}
			}
			// Set Array
			$columns = array_values($columns);
		}

		// Get Labels
		$filter_columns_name = $this->get_label_name($columns, $tableName);

		// Push Columns
		if (!is_null($pusharray)) {
			if (!is_array($pusharray)) {
				$pusharray = explode(',', $pusharray);
			}
			for ($i = 0; $i < count($pusharray); $i++) {
				array_push($filter_columns_name, $pusharray[$i]);
			}
		}

		// Return Columns
		return $filter_columns_name;
	}

	/**
	 * This functions takes your custom filter data and assign them to insert array 
	 *
	 * 1: Pass Filter Columns
	 * 2: Pass Insert Data
	 *
	 */
	public function fieldFiltered($columns, $data)
	{

		// Decode Filter Data
		$filter_data = json_decode($data, True);

		// Insert Data
		$insertData = null;

		// Columns
		for ($i = 0; $i < count($columns); $i++) {
			$key = strtolower($columns[$i]);
			if (array_key_exists($key, $filter_data)) {
				$insertData[$key] = $filter_data[$key];
			}
		}

		// Return
		return $insertData;
	}

	/**
	 * This functions takes your form data and pick filters out of it 
	 *
	 * 1: Pass Form Data
	 * 2: Pass CustomField Title/ID
	 * 
	 */
	public function fieldFilterData($passedData, $titleID)
	{
		// Title
		$title = $this->plural->singularize($titleID);
		// Get Custom Field Title
		if (is_numeric($titleID)) {
			$title = $this->CoreCrud->selectSingleValue('customfields', 'title', array('id' => $titleID)); // Title ID
		}

		// Form
		$formFilters = [];

		// Get Filters
		$filtersJson = $this->CoreCrud->selectSingleValue('customfields', 'filters', array('title' => $title));
		if (!is_null($filtersJson)) {
			// Decode
			$filters = json_decode($filtersJson, True);
			// Array
			$fromData = (!is_array($passedData)) ? json_decode($passedData, True) : $passedData;
			// Loop
			for ($l = 0; $l < count($filters); $l++) {
				if (array_key_exists($filters[$l], $fromData)) {
					$key = $filters[$l]; // Key
					$value = $fromData[$key]; // Value
					// Set Values
					$formFilters[$key] = $value;
				}
			}
		}

		// Return
		return json_encode($formFilters);
	}

	/**
	 *
	 * Base URL
	 *
	 * This function help you to get proper base/site URL
	 * 1: Pass Page URL
	 * 2: Pass Type [base_url | site_url]
	 */
	public function proper_url($url, $type = 'base_url')
	{
		// Load Settings
		$url = (is_array($url)) ? $url[0] : $url;
		$urlsettings = ((method_exists('CoreTrigger', 'urlSettings'))) ? $this->CoreTrigger->urlSettings() : false;
		if ($urlsettings) {
			$site_url = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'site_url', 'flg' => 1));
			$last_url = substr($site_url, -1);
			if ($last_url != '/') {
				$site_url = $site_url . '/';
			}
			// URL
			$url = $site_url . $url;
		} else {
			$url = (strtolower($type) == 'base_url') ? base_url($url) : site_url($url);
		}

		// Return
		return $url;
	}

	/**
	 * --- Variable Format : #{[variable_name]} ---
	 * Preg Match Varible Settings
	 * Pass String
	 * 
	 */
	public function get_variable($string, $variables = null, $skip = false)
	{
		// Load
		$data = $this->CoreLoad->load();
		if ($skip == false) {
			if (is_array($variables) && !is_null($variables)) {
				$data = array_merge($data, $variables);
			}
		} else {
			$data = $variables;
		}

		// Session
		$_SESSION["data"] = $data;
		$_SESSION["variables"] = $variables;

		// Check Pregmatch Settings
		if (!function_exists('replace_variable')) {
			function replace_variable($string)
			{
				// Get Data
				$CoreCrud = new CoreCrud;
				$CoreTrigger = new CoreTrigger;
				$CI = &get_instance();

				// Data
				$data =  $_SESSION["data"];
				$variables = $_SESSION["variables"];

				// Match
				$match = $CoreCrud->selectSingleValue('settings', 'value', array('title' => 'string_variable', 'flg' => 1));
				$show_variable = ((method_exists('CoreTrigger', 'showGetVaribale'))) ? $CoreTrigger->showGetVaribale() : true;
				if ($match) {

					// Find Replace
					if (is_array($string)) {
						$key = $string[1];

						// Chech Data If is Array
						if (is_array($data) && !is_null($data)) {
							if (array_key_exists($key, $data)) {
								$replace_output = $data[$key];
							} else {
								// Assign
								$value = $string[1];
								// $value = $$value;
								if (is_array($variables)) {
									if (array_key_exists($value, $variables)) {
										$replace_output = $variables[$value];
									} else {
										$replace_output = ($show_variable) ? "_{[$value]}" : '';
									}
								} else {
									$replace_output = ($show_variable) ? "_{[$value]}" : '';
								}
							}
						} else {
							// Assign
							$value = $string[1];
							// $value = $$value;
							if (is_array($variables)) {
								if (array_key_exists($value, $variables)) {
									$replace_output = $variables[$value];
								} else {
									$replace_output = ($show_variable) ? "_{[$value]}" : '';
								}
							} else {
								$replace_output = ($show_variable) ? "_{[$value]}" : '';
							}
						}

						// Write
						$string = $replace_output;
					}

					// Replace
					return preg_replace_callback($match, 'replace_variable', $string);
				} else {
					return $string;
				}
			}
		} else {
			return replace_variable($string);
		}
		return replace_variable($string);
	}

	/**
	 * meta URL
	 * 
	 * This method is used to convert string to URL
	 * 
	 * 1: Pass String
	 * 2: Pass String length limit (optional) | default is 500
	 * 
	 * @return formated URL
	 */
	public function metaUrl($title, $limit = 500)
	{
		//Clean Title
		$title = str_replace("&&", "and", strtolower(trim($title)));
		$title = str_replace("&", "and", strtolower(trim($title)));
		$title = str_replace("@", "at", strtolower(trim($title)));
		$title = str_replace("_", "-", strtolower(trim($title)));

		//Check If Current URL
		$meta_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($title)), 0, $limit);
		$meta_url = str_replace(" ", "-", strtolower(trim($meta_url))); //Clean URL

		// Return
		return $meta_url;
	}

	/**
	 * metaGenerateUrl
	 * 
	 * This method is used to generate URL and check if it already exist
	 * - If you have a premade url and you want to use it, just pass it to this method
	 * - If you don't have a premade url, just pass the title to this method
	 * - If you have a url and you would like to check if it exist, just pass the url to this method as second argument
	 * [In most of cases simply use metaGetUrl() method instead of this method]
	 * 
	 * 1: Pass Title (optional)
	 * 2: Pass Current URL (optional)
	 * 3: Pass URL Length Limit (optional) | default is 500
	 * 4: Pass limiter for random string (optional) | default is 10
	 * 
	 * @return formated URL
	 */
	public function metaGenerateUrl($title = null, $currenturl = null, $limit = 500, $rand = 10)
	{
		//Check Title
		$title = (!is_null($title) && !empty($title)) ? $title : $this->CoreLoad->random($rand, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ') . time();

		//Check If Current URL
		if (!is_null($currenturl)) {
			$meta_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($currenturl)), 0, $limit);
			$meta_url = str_replace(" ", "-", strtolower(trim($meta_url))); //Clean URL
		} else {
			$meta_url = $this->metaUrl($title, $limit);
		}

		//Check If Exist
		if ($this->metaCheckUrl($meta_url)) {
			$unique = $this->CoreLoad->random($rand, 'abcdefghijklmnpqrstuvwxyz123456789');
			return $meta_url . '-' . $unique;
		} else {
			return $meta_url;
		}
	}

	/**
	 * metaCheckUrl
	 * 
	 * This method is used to check if URL already exist and can generate new one (if current exist)
	 * - This method work perfect is you already have $typeid (metaterm_typeid)
	 * 
	 * 1: Pass URL
	 * 2: Pass Type ID (optional) metaterm_typeid
	 * 3: Pass generate [optional] | default is false (if url exist it won't generate new one)
	 * 4: Pass limiter for random string (optional) | default is 10
	 * 
	 * @return formated URL or True| False
	 */
	public function metaCheckUrl($url, $typeid = null, $generate = false, $rand = 10)
	{

		// Table
		$table = $this->plural->pluralize('metaterms');
		$column_module = $this->CoreForm->get_column_name($table, 'module');
		$column_type = $this->CoreForm->get_column_name($table, 'type');
		$column_typeid = $this->CoreForm->get_column_name($table, 'typeid');
		$column_url = $this->CoreForm->get_column_name($table, 'url');

		$meta_url = strtolower(trim($url)); // URL

		//Check If Exist
		$query = $this->db->query("SELECT $column_url as `url`,$column_typeid as `metaid`,$column_module as `module`,$column_type as `filter` FROM $table WHERE $column_url LIKE '$meta_url' LIMIT 1");
		$meta_query = $query->result();
		if (!empty($meta_query)) {
			// Check If Updating
			if (!is_null($typeid)) {
				$generated_url = ($meta_query[0]->metaid == $typeid) ? $meta_query[0]->url : $meta_query[0]->url . '-' . $this->CoreLoad->random($rand, 'abcdefghijklmnpqrstuvwxyz123456789');
			} else {
				$generated_url = $this->metaUrl($meta_query[0]->url . '-' . $this->CoreLoad->random($rand, 'abcdefghijklmnpqrstuvwxyz123456789'));
				return $this->metaCheckUrl($generated_url, null, true);
			}
			return ($generate) ? $generated_url : true; //URL exist
		}
		// Return
		return ($generate) ? $meta_url : false; //URL does not exist (Or is used by current updated entry)
	}

	/**
	 * metaExistingUrl
	 * 
	 * Unline metaCheckUrl() method, this method is used to return URL for the metaterm requested
	 * 
	 * 1: Pass $module  (Table Name) | pages,blogs
	 * 2: Pass $ud ID () page_id | blog_id
	 * 3: Pass $generate True|False - if true it will return the URL incase the module in request has no url
	 * 
	 * @return formated URL | or null incase $generate = false nad url does not exist
	 */
	public function metaExistingUrl($module, $id, $generate = false)
	{

		// Check Module
		$table_name = $this->plural->pluralize(strtolower(trim($module)));
		$metaterm_type = $this->plural->singularize(strtolower(trim($module)));
		if ($table_name == 'fields' || $table_name == 'autofields') {
			$metaterm_type = $this->plural->singularize($this->CoreCrud->selectSingleValue($table_name, 'title', ['id' => $id]));
		} elseif ($table_name == 'inheritances') {
			$metaterm_type = $this->plural->singularize($this->CoreCrud->selectSingleValue($table_name, 'type', ['id' => $id]));
		}

		// Check Existing URL
		$exist_url = $this->CoreCrud->selectSingleValue('metaterms', 'url', ['module' => $table_name, 'typeid' => $id]);
		if (!is_null($exist_url)) {
			return $exist_url;
		} else {
			return ($generate) ? $this->metaGetUrl($module, $id) : null;
		}
	}

	/**
	 * metaGetUrl
	 * 
	 * This method is used to generate URL for the metaterm requested
	 * - This method comes in handy when you don't have a premade url or title
	 * - Also incase you want to utilise _urlhelper to generate url | Note inheritance will start with in{Typename ucfirst} _urlhelper
	 * 
	 * 1: Pass $module  (Table Name) | pages,blogs
	 * 2: Pass $ud ID () page_id | blog_id
	 * 3: Pass Title (optional) {incase you have generate a title to be converted}
	 * 
	 * - This method will also check if the URL already exist and can make url unique
	 * 
	 * @return formated URL
	 */
	public function metaGetUrl($module, $id, $title = null)
	{

		// Check Module
		$table_name = $this->plural->pluralize(strtolower(trim($module)));
		if ($table_name == 'fields') {
			$filter = $this->plural->singularize($this->CoreCrud->selectSingleValue($table_name, 'title', ['id' => $id]));
			$column_title = $this->CoreCrud->selectSingleValue($table_name, 'title', ['id' => $id]);
			// Check Title
			if (is_null($title) || empty($title)) {
				//load ModelField
				$customHelper = $filter . '_urlhelper';
				$this->load->model('CoreTrigger');
				$title = ((method_exists('CoreTrigger', $customHelper))) ? $this->CoreTrigger->$customHelper($id) : $title;
			}
			// MetaTerm Type
			$metaterm_type = $this->plural->singularize(strtolower(trim($filter)));
		} elseif ($table_name == 'autofields') {
			$filter = $this->plural->singularize($this->CoreCrud->selectSingleValue($table_name, 'title', ['id' => $id]));
			$auto_select = $this->CoreCrud->selectSingleValue($table_name, 'select', ['id' => $id]);
			$auto_title = $this->CoreCrud->selectSingleValue($table_name, 'title', ['id' => $id]);
			$column_title = (!is_null($auto_select) && !empty($auto_select)) ? $auto_select : $auto_title;

			// Check Title
			if (is_null($title) || empty($title)) {
				//load ModelField
				$customHelper = $filter . '_urlhelper';
				$this->load->model('CoreTrigger');
				$title = ((method_exists('CoreTrigger', $customHelper))) ? $this->CoreTrigger->$customHelper($id) : $title;
			}
			// MetaTerm Type
			$metaterm_type = $this->plural->singularize(strtolower(trim($filter)));
		} elseif ($table_name == 'inheritances') {
			$filter = $this->plural->singularize($this->CoreCrud->selectSingleValue($table_name, 'type', ['id' => $id]));
			$column_title = $this->CoreCrud->selectSingleValue($table_name, 'title', ['id' => $id]);
			// Check Title
			if (is_null($title) || empty($title)) {
				//load ModelField
				$helper = 'in' . ucfirst($filter);
				$customeHelper = $helper . '_urlhelper';
				$this->load->model('CoreTrigger');
				$title = ((method_exists('CoreTrigger', $customeHelper))) ? $this->CoreTrigger->$customeHelper($id) : $title;
			}
			// MetaTerm Type
			$metaterm_type = $this->plural->singularize(strtolower(trim($filter)));
		} else {
			if ($table_name == 'users') {
				$column_title = $this->CoreCrud->selectSingleValue($table_name, 'logname', ['id' => $id]);
			} elseif ($table_name == 'levels') {
				$column_title = $this->CoreCrud->selectSingleValue($table_name, 'name', ['id' => $id]);
			} elseif ($this->CoreForm->checkTable($table_name)) {
				$column_title = $this->CoreCrud->selectSingleValue($table_name, 'title', ['id' => $id]);
			}
			// Check Title
			if (is_null($title) || empty($title)) {
				//load ModelField
				$customeHelper = $this->plural->singularize($table_name) . '_urlhelper';
				$this->load->model('CoreTrigger');
				$title = ((method_exists('CoreTrigger', $customeHelper))) ? $this->CoreTrigger->$customeHelper($id) : $title;
			}
			// MetaTerm Type
			$metaterm_type = $this->plural->singularize(strtolower(trim($module)));
		}
		// Check Existing URL
		$exist_url = $this->CoreCrud->selectSingleValue('metaterms', 'url', ['module' => $table_name, 'typeid' => $id]);
		if (!is_null($exist_url)) {
			$title = $exist_url;
		}

		// Check Title | URL
		$title = (!is_null($title) && !empty($title)) ? $title : $column_title;
		// Title to URL
		$meta_url = $this->metaUrl($title);

		// Check If Exist
		return $this->metaCheckUrl($meta_url, $id, true);
	}

	/**
	 * Meta Get Item/Data URL
	 * 
	 * This method is used to retrive URL from the metaterm module for the passed id/item
	 * - This method is useful when you wish to get url for the item with ease
	 * - Also when using $this->CoreCrud->selectInheritanceMeta to get inheritance this method is used to add url for each inheritance
	 *
	 * 1: Pass type id which will be compaired against metaterms.metaterm_typeid 
	 * 2: (optional) pass module (metaterms.metaterm_module) make user is alread pluralize/singularize
	 * 3: (optional) pass type (metaterms.metaterm_type) 
	 *
	 * - By default url will be returned if is found or null will be returned if URL was not found.
	 *
	 * NB: THIS METHOD IS NOT SIMMILAR TO *metaGetUrl* The two serve different purpose.
	 * + metaGetUrl -> will generate new or return existing current URL from given data (avoid using since it does not record URL into metaterms)
	 * + metaFindUrl -> will return existing url or null 
	 * + for inhertance data use ** $this->CoreCrud->selectInheritanceMeta() ** works the same as ** $this->CoreCrud->selectInheritanceItem() **
	 * ++ but with benefit of returning additional key metaurl with your url
	 *
	 */
	public function metaFindUrl($typeid, $module = null, $type = null)
	{
		// Get Meta Data
		$search['typeid'] = $typeid;
		($module) ? $search['module'] = $module : null;
		($type) ? $search['type'] = $type : null;

		// Get Meta Data
		$meta_url = $this->CoreCrud->selectSingleValue('metaterms', 'url', $search);

		// Return
		return $meta_url;
	}
}

/** End of file CoreForm.php */
/** Location: ./application/models/CoreForm.php */
