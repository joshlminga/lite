<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CoreMigrate extends CI_Model
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
		$this->migratedb = $this->load->database('migrate', TRUE);
	}

	/**
	 * Migrate Method
	 * 
	 * For loading all module/table data
	 */
	public function load($data, $table)
	{
		// Check Version
		$version = floatval($data['version']);

		// Load Migrate DB
		$data['dataList'] = null;

		// Module
		$module = ($table == 'fieldgroup') ? 'fields' : $this->plural->pluralize($table);
		$data['Module'] = $module;

		// Check If Table Exists
		if ($this->CoreForm->checkTable($module) && $version >= 5.3) {
			// Case
			$case = $this->plural->singularize($table);
			// Swicth
			switch ($case) {
				case 'autofield':
					//Table Select & Clause
					$select = array('id as id,title as title,title as key,flg as status');
					break;

				case 'blog':
					//Table Select & Clause
					$select = array('id,category as category,title as title,flg as status');
					break;

				case 'page':
					//Table Select & Clause
					$select = array('id,title as title,flg as status');
					break;

				case 'inheritance':
					//Table Select & Clause
					$select = array('id,title as title,type as type,flg as status');
					break;

				case 'customfield':
					//Table Select & Clause
					$select = array('id as id,title as title,title as table,flg as status');
					break;

				case 'field':
					//Table Select & Clause
					$select = array('id as id,title as title,flg as status');
					break;

				case 'fieldgroup':

					//Table Select & Clause
					$select = null;
					$group = $this->CoreForm->get_column_name($module, 'title'); //Set Column name
					// CRUD 
					$columns = $this->CoreCrud->set_selectCRUD($module, ['id as id,title as title,flg as status']);
					$this->migratedb->select($columns);
					$this->migratedb->from($module);
					$this->migratedb->group_by($group);
					$query = $this->migratedb->get();
					$checkData = $this->CoreCrud->checkResultFound($query); //Check If Value Found
					$data['dataList'] = ($checkData == true) ? $query->result() : null;
					break;
				case 'level':
					//Table Select & Clause
					$select = array('id,name as access_name,flg as status');
					break;

				case 'user':
					//Table Select & Clause
					$select = array('id,level as level,logname as username,name as full_name,email as email,flg as status');
					break;

				case 'setting':
					//Table Select & Clause
					$select = array('id,title as title,flg as status');
					break;

				default:
					$select = null;
					break;
			}

			// CRUD 
			if (!is_null($select)) {
				$columns = $this->CoreCrud->set_selectCRUD($module, $select);
				$this->migratedb->select($columns);
				$this->migratedb->from($module);
				$query = $this->migratedb->get();
				$checkData = $this->CoreCrud->checkResultFound($query); //Check If Value Found
				$data['dataList'] = ($checkData == true) ? $query->result() : null;
			}
		}

		// Return
		return $data;
	}

	/** 
	 * MIGRATE Method
	 */
	public function migrate($module, $inputID = null)
	{
		// Migratiion
		$this->checkMigrationTable();

		// Module
		$table = ($module == 'fieldgroup') ? 'fields' : $this->plural->pluralize($module);
		$table = $this->plural->pluralize($table);
		$module = $this->plural->singularize($module);

		// Check $inputID
		if (is_null($inputID) || empty($inputID)) {
			return null;
		}

		// Value
		if ($this->plural->singularize($module) == 'fieldgroup') {
			$name = (is_numeric($inputID)) ? 'id' : 'title';
			$select_column = $this->CoreForm->get_column_name($table, $name);

			// Grouped
			$selectData = $this->migratedb->select('field_title')->where([$select_column => $inputID])->limit(1)->get($table);
			$checkData = $this->CoreCrud->checkResultFound($selectData); //Check If Value Found
			$inputID = ($checkData == true) ? $selectData->row()->field_title : null;

			// Column
			$data = $this->migratedb->select('*')->where("field_title", $inputID)->get($table)->result(); //Select Data
		} else {
			if ($inputID == 'all') {
				$data = $this->migratedb->select('*')->get($table)->result(); //Select Data
			} else {
				$column = $this->CoreForm->get_column_name($table, 'id');
				$data = $this->migratedb->select('*')->where("$column", $inputID)->get($table)->result(); //Select Data
			}
		}

		// Get Data
		if ($table == 'fields') {
			// Loop $data
			foreach ($data as $key => $value) {
				// Check If Data Exists
				$title = $value->field_title;
				$id = $value->field_id;

				// Trancate Customfields
				$migrate = $this->CoreCrud->selectSingleValue('migrates', 'id', ['table' => 'customfields']);
				if (is_null($migrate)) {
					// Truncate 
					$this->db->truncate('customfields');
				}

				// Get CustomField
				$selectData = $this->migratedb->select('*')->where(['customfield_title' => $title])->limit(1)->get('customfields')->result();
				$custom_found = (count($selectData) > 0) ? $selectData : null;
				// Update CustomField
				$updatedField = $this->customfield($custom_found);

				// Check Custom Field
				$custom_found = $this->CoreCrud->selectSingleValue('customfields', 'id', ['title' => $title]);
				if (is_null($custom_found)) {

					// Insert CustomField
					$this->db->insert('customfields', $updatedField);

					// Migrate
					$this->db->insert('migrates', ['migrate_table' => 'customfields', 'migrate_value' => $title]);
				}

				//load Field Migrate Helper
				$this->load->model('CoreTrigger');
				$customHelper = $this->plural->singularize($title) . '_fieldMigrateHelper';

				// Migrate Field Data
				$migrateFieldData =	json_decode($this->selectFieldItem(['id' => $id])[0], True);
				if (method_exists('CoreTrigger', $customHelper)) {
					$migrateFieldData = $this->CoreTrigger->$customHelper($migrateFieldData, $id);
				}
				// Prepaire Data
				$savedData = $this->CoreForm->saveFormField($migrateFieldData, $title);

				// Plain Input
				if ($this->migratedb->field_exists('field_show', 'fields')) {
					$showData = $this->migratedb->select('field_show')->where(['field_id' => $id])->limit(1)->get('fields');
					$checkShow = $this->CoreCrud->checkResultFound($showData); //Check If Value Found
					$field_show = ($checkShow == true) ? $showData->row()->field_show : null;
					if (strlen($field_show) > 20) {
						$savedData['field_plain'] = $field_show;
					}
				}

				$field_found = $this->CoreCrud->selectSingleValue('fields', 'id', ['id' => $id, 'title' => $title]);
				if ($field_found) {
					// Update Field
					$this->updateField($savedData, $id);
				} else {
					// Insert Field
					$this->insertField($savedData);
				}

				// Migrate
				$migrate_check = $this->CoreCrud->selectSingleValue('migrates', 'id', ['table' => $table, 'value' => $id]);
				if (is_null($migrate_check)) {
					$this->db->insert('migrates', ['migrate_table' => 'fields', 'migrate_value' => $id]);
				}
			}
		} elseif ($table == 'customfields') {
			// Trancate Customfields
			$migrate = $this->CoreCrud->selectSingleValue('migrates', 'id', ['table' => $table]);
			if (is_null($migrate)) {
				// Truncate 
				$this->db->truncate($table);
			}

			// Update CustomField
			$title = $data[0]->customfield_title;
			$updatedField = $this->customfield($data);

			// Check Custom Field
			$custom_found = $this->CoreCrud->selectSingleValue('customfields', 'id', ['title' => $title]);
			if (is_null($custom_found)) {
				// Insert CustomField
				$this->db->insert('customfields', $updatedField);

				// Migrate
				$this->db->insert('migrates', ['migrate_table' => 'customfields', 'migrate_value' => $title]);
			}
		} else {
			// Trancate Customfields
			$migrate = $this->CoreCrud->selectSingleValue('migrates', 'id', ['table' => $table]);
			if (is_null($migrate)) {
				// Truncate 
				$this->db->truncate($table);
			}

			// Loop $data
			for ($i = 0; $i < count($data); $i++) {
				// Check If Data Exists
				$found = (array) $data[$i];
				if (count($found) > 0) {
					$column = $this->CoreForm->get_column_name($table, 'id');
					$id = $found[$column];

					// For Settings
					if ($table == 'settings') {
						$found['setting_flg'] = ($found['setting_title']  == 'field_menu' || $found['setting_title'] == 'extension_menu') ? 0 : 1;
					}

					$field_found = $this->CoreCrud->selectSingleValue($table, 'id', ['id' => $id]);
					if ($field_found) {
						// Update Field
						$this->update($table, $found, [$column => $id]);
					} else {
						// Insert
						$this->create($table, $found);
					}

					// Migrate
					$migrate_check = $this->CoreCrud->selectSingleValue('migrates', 'id', ['table' => $table, 'value' => $id]);
					if (is_null($migrate_check)) {
						$this->db->insert('migrates', ['migrate_table' => $table, 'migrate_value' => $id]);
					}
				}
			}
		}
	}

	/**
	 * MIGRATE ALL METHOD
	 */
	public function migrateAll($module = null)
	{
		// Migratiion
		$this->checkMigrationTable();

		// Check Module
		if (is_null($module) || empty($module)) {
			$module = ['settings', 'levels', 'users', 'inheritances', 'autofields', 'blogs', 'pages', 'customfields', 'fields'];
		}

		// Module Array
		$modules = (is_array($module)) ? $module : [$module];

		// Loop
		for ($m = 0; $m < count($modules); $m++) {
			$table = $this->plural->pluralize($modules[$m]);
			$module = $this->plural->singularize($modules[$m]);

			// Trancate Customfields
			$migrate = $this->CoreCrud->selectSingleValue('migrates', 'id', ['table' => $table]);
			if (is_null($migrate)) {
				// Truncate 
				$this->db->truncate($table);
			}

			// Get Data
			$data = $this->migratedb->select('*')->get($table)->result(); //Select Data
			// Loop $data
			for ($i = 0; $i < count($data); $i++) {
				$column_id = $this->CoreForm->get_column_name($table, 'id');
				// Check If Data Exists
				$found = $data[$i]->$column_id;

				// Check If customfields has beed migrted for fields
				if ($table == 'fields') {
					$column_title = $this->CoreForm->get_column_name($table, 'title');
					$title = $data[$i]->$column_title;

					$migrate = $this->CoreCrud->selectSingleValue('migrates', 'id', ['table' => 'customfields', 'value' => $title]);
					if (is_null($migrate)) {
						// Return
						return false;
					}
				}
				// Migrate
				$this->migrate($table, $found);
			}

			// Return
			return true;
		}
	}

	/**
	 * This function help you to select specific fields value from Field Table
	 * Kindly not this function wont check if your Field value is Active (field_flg = 1) by default
	 * -- It will also not compaire against filter value (If you use filter)
	 * 
	 * 
	 * 1: First parameter to pass is $field_where = To the idetifier value E.g id=>17,title=>User etc. | It has to be an array
	 * 2: Pass field value you want to select | also you can pass to return value as e.g registration_date as date, full_name as name
	 * N.B must match the field names
	 * If you want to select all values from field data, just do not pass second parameter
	 * 
	 * 3: Optional search type| by default it will search using where you can add like etc
	 *
	 * Kindly remember these values are selected on field_data column and field_id will be selected by default
	 * The function will loop through field_data value to match against your field_select value keys
	 *
	 * ----> To view the data Decode the Json json_decode($returned_data[array_position],True) 
	 * 
	 */
	public function selectFieldItem($field_where, $fiel_select = 'all', $clause = 'where')
	{

		//Check if fiel_select passed is not an array
		if (!is_array($fiel_select)) {
			$fiel_select = explode(',', $fiel_select); //string to Array
		}

		//Select Data
		$columns = array('id as id,data as data');
		$field_data = $this->selectCRUD('fields', $field_where, $columns, $clause);

		//Check if Query Exceuted And Has Data
		if ($field_data) {

			//Loop through returned field Data
			for ($i = 0; $i < count($field_data); $i++) {

				$field_data_id = $field_data[$i]->id; //Field Data ID
				$field_data_values = json_decode($field_data[$i]->data, True); //Field Data Values

				//Check if user want to select all data
				if ($fiel_select[0] == 'all') {

					$selected = $field_data_values; //Field Data
					$selected['id'] = $field_data_id; //Data ID

					$data[$i] = json_encode($selected, True); // All selected Data
				} else {

					//Loop through selected values
					for ($f = 0; $f < count($fiel_select); $f++) {
						$select = $fiel_select[$f]; //Selectd value
						if (strpos($select, 'as') !== false) {
							$key_as = explode(' as ', $select); //Get array Key and As value
							$key = trim($key_as[0]); //Set Key
							$as = trim($key_as[1]); //Set As value
							$field_values[$as] = $field_data_values[$key]; //Set Value
						} else {
							if (array_key_exists($select, $field_data_values)) {
								$field_values[$select] = $field_data_values[$select]; //Set Values
							} else {
								$field_values[$select] = null; //Set Values
							}
						}
					}

					//Set Values
					$selected = $field_values; //Field Data
					$selected['id'] = $field_data_id; //Data ID

					$data[$i] = json_encode($selected, True); // All selected Data
				}
			}
			return $data; //return Data
		} else {
			return null; //return null for no data
		}
	}

	/**
	 * Use this function to select datble values from the database
	 * Select function accept 
	 * 1: Module name pluralized to match Table Name
	 * 2: Clause (You can Pass Null to get all)
	 * 3: what to select (You can Pass Null to get any)
	 */
	public function selectCRUD($module, $where = null, $select = null, $clause = 'where')
	{

		$module = $this->plural->singularize($module); //Make Sure Module Is Singular

		//Get Table Name
		$table = $this->plural->pluralize($module);

		if (!is_null($select)) {
			$columns = $this->CoreCrud->set_selectCRUD($module, $select);
			$this->migratedb->select($columns);
		}
		if (!is_null($where)) {
			$where = $this->CoreCrud->set_whereCRUD($module, $where);
			$this->migratedb->$clause($where);
		}

		$this->migratedb->from($table);
		$query = $this->migratedb->get();

		$checkData = $this->CoreCrud->checkResultFound($query); //Check If Value Found
		$queryData = ($checkData == true) ? $query->result() : null;

		return $queryData;
	}

	/**
	 * Insert
	 * 
	 */
	public function create($table, $insertData)
	{

		//Pluralize Module
		$tableName = $this->plural->pluralize($table);

		//Insert Data Into Table
		if ($this->CoreCrud->insertData($tableName, $insertData)) {

			// Migrate
			$extension_check = $this->CoreCrud->selectSingleValue('settings', 'id', ['default' => 'migration']);
			if (is_null($extension_check)) {
				// MIgration
				$migrationData = [
					'setting_title' => 'extension_menu',
					'setting_value' => '{"menu_path":"migrate/menu","route":{"migrate":"Extension/Ex_Migrate/open/manage","migrate/save":"Extension/Ex_Migrate/valid/all", "migrate/multiple":"Extension/Ex_Migrate/valid/bulk", "migrate/(:any)":"Extension/Ex_Migrate/migrate/$1"}}',
					'setting_stamp' => date('Y-m-d H:i:s'),
					'setting_default' => 'route',
					'setting_flg' => 1,
				];
				$this->CoreCrud->insertData('settings', $migrationData);
			}

			return true; //Data Inserted
		} else {

			return false; //Data Insert Failed
		}
	}

	/**
	 * Update
	 */
	public function update($table, $updateData, $valueWhere, $unsetData = null)
	{
		//Pluralize Module
		$tableName = $this->plural->pluralize($table);

		//Update Data In The Table
		if ($this->CoreCrud->updateData($tableName, $updateData, $valueWhere)) {

			return true; //Data Updated
		} else {

			return false; //Data Updated Failed
		}
	}

	/**
	 * Field Insert
	 */
	public function insertField($insertData, $unsetData = null)
	{
		//Save
		$savedData = $this->CoreCrud->saveField($insertData);
		if ($this->CoreCrud->fieldStatus($savedData)) {
			// ID
			return $savedData['id'];
		} else {
			return false;
		}
	}

	/**
	 * Field Update
	 */
	public function updateField($updateData, $valueWhere, $unsetData = null)
	{
		//Updated
		$updatedData = $this->CoreCrud->updateField($updateData, $valueWhere);
		if ($this->CoreCrud->fieldStatus($updatedData)) {

			return true; //Data Inserted
		} else {

			return false; //Data Insert Failed
		}
	}

	/**
	 * CustomField
	 */
	public function customfield($custom_field)
	{
		// Check Data
		if (is_null($custom_field) || empty($custom_field)) {
			return false;
		}

		//load CustomField Migrate Helper
		$customHelper = $this->plural->singularize($custom_field[0]->customfield_title) . '_customFieldMigrateHelper';
		$this->load->model('CoreTrigger');
		$custom_found = ((method_exists('CoreTrigger', $customHelper))) ? $this->CoreTrigger->$customHelper($custom_field) : $custom_field;

		// Get Data
		$customfield_id = $custom_found[0]->customfield_id;
		$customfield_title = $custom_found[0]->customfield_title;

		// Check if property 'customfield_required' exist
		$customfield_required = (property_exists($custom_found[0], 'customfield_required')) ? json_decode($custom_found[0]->customfield_required) : [];
		// Check if property 'customfield_options' exist
		$customfield_optional = (property_exists($custom_found[0], 'customfield_optional')) ? json_decode($custom_found[0]->customfield_optional) : [];
		$customfield_filters = json_decode($custom_found[0]->customfield_filters);
		$customfield_stamp = $custom_found[0]->customfield_stamp;
		$customfield_default = $custom_found[0]->customfield_default;
		$customfield_flg = $custom_found[0]->customfield_flg;

		$customfield_inputs = (property_exists($custom_found[0], 'customfield_inputs')) ? json_decode($custom_found[0]->customfield_inputs) : array_merge($customfield_required, $customfield_optional);
		$customfield_inputs = array_unique($customfield_inputs); // Remove Duplicate Keys
		$customfield_inputs = array_values($customfield_inputs); // Re-index Array

		// Remove Special Characteres
		for ($k = 0; $k < count($customfield_inputs); $k++) {

			$clean = preg_replace("/[^ \w-]/", "", trim($customfield_inputs[$k]));
			$clean_input = preg_replace('/-+/', '-', $clean);
			// Replace - & space with _
			$keys = strtolower(str_replace("-", "_", str_replace(" ", "_", $clean_input)));
			$customfield_keys[$k] = $keys; // Keys
		}

		// Filters
		for ($f = 0; $f < count($customfield_filters); $f++) {
			$key = strtolower(str_replace("_", "-", str_replace("_", " ", trim($customfield_filters[$f]))));

			$clean = preg_replace("/[^ \w-]/", "", trim($key));
			$clean_input = preg_replace('/-+/', '-', $clean);
			// Replace - & space with _
			$keys = strtolower(str_replace("-", "_", str_replace(" ", "_", $clean_input)));
			$customfield_filters[$f] = $keys; // Keys
		}
		$customfield_filters = array_unique($customfield_filters); // Remove Duplicate Keys
		$customfield_filters = array_values($customfield_filters); // Re-index Array

		// New CustomField
		$customfield = [
			'customfield_id' => $customfield_id,
			'customfield_title' => $customfield_title,
			'customfield_inputs' => json_encode($customfield_inputs),
			'customfield_filters' => json_encode($customfield_filters),
			'customfield_keys' => json_encode($customfield_keys),
			'customfield_stamp' => $customfield_stamp,
			'customfield_default' => $customfield_default,
			'customfield_flg' => $customfield_flg,
		];

		// Details
		$customfield['customfield_details'] = json_encode($customfield);
		return $customfield;
	}

	/**
	 * Check MIgration Table
	 */
	public function checkMigrationTable()
	{
		if (!$this->CoreForm->checkTable('migrates')) {
			// Create Table

			$sql = "CREATE TABLE `migrates` (
				`migrate_id` bigint(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				`migrate_table` varchar(100) NOT NULL,
				`migrate_value` varchar(100) DEFAULT NULL,
				`migrate_status` varchar(20) DEFAULT 'success',
				`migrate_flg` int(1) NOT NULL DEFAULT '1'
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			";

			// Execute Query
			$this->db->query($sql);
		}
	}
}

/* End of file CoreMigrate.php */
