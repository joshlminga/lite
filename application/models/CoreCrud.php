<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CoreCrud extends CI_Model
{

  /*
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
    $this->load->model('CoreForm');

    // Your own constructor code
  }

  /*
  *
  * Set Where clause
  * 1: Pass Module Name 
  * 2: Where clause values as Array
  */
  public function set_whereCRUD($module, $where)
  {

    $module = $this->plural->singularize($module); //Make Sure Module Is Singular

    foreach ($where as $key => $value) {
      //Set Clomun names
      $column = $this->CoreForm->get_column_name($module, $key);
      //Set key as column name and assign the value to look 
      $select_where[$column] = $value;
    }

    //Return The Array
    return $select_where;
  }

  /*
  *
  * Set value To Select
  * 1: Pass module name
  * 2: Pass Column names as sting
  */
  public function set_selectCRUD($module, $column)
  {

    $module = $this->plural->singularize($module); //Make Sure Module Is Singular

    //Get Array
    $column = explode(',', $column[0]);

    $i = 0; // Set Array Counter
    foreach ($column as $key) {

      //Check If Column Requested As
      if (strpos(strtolower($key), 'as') !== false) {

        $exploded = explode(" as ", strtolower($key)); //Get Column name in Key 0 and As value Name in Key 1

        $column_name = $this->CoreForm->get_column_name($module, $exploded[0]); //Set Column name
        $columns[$i] = $column_name . ' AS ' . $exploded[1]; //Set Column name as
      } else {

        $columns[$i] = $this->CoreForm->get_column_name($module, $key); //Set Column name
      }
      $i++; //Count
    }

    //Return The Array
    return implode(',', $columns);
  }

  /*
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

      $columns = $this->set_selectCRUD($module, $select);
      $this->db->select($columns);
    }
    if (!is_null($where)) {

      $where = $this->set_whereCRUD($module, $where);
      $this->db->$clause($where);
    }

    $this->db->from($table);
    $query = $this->db->get();

    $checkData = $this->checkResultFound($query); //Check If Value Found
    $queryData = ($checkData == true) ? $query->result() : null;

    return $queryData;
  }

  /*
  *
  * This function is to help user select Inheritance Data
  *
  * By default the function will select inheritance_id,inheritance_type,inheritance_parent.inheritance_title unless specified other wise
  *  
  * 1: Pass The where clause as array('id'=>id_number,'parent'=>parent_id)
  * 2: Pass selected values separated by comma | by default it will select id,type,parent,title
  * 3: Pass Sort By Column => Value | by default array('id'=>'ASC')
  *
  */
  public function selectInheritanceItem($inheritance_where, $inheritance_select = 'id,type,parent,title', $sort = array('id' => 'ASC'))
  {

    $module = 'inheritances'; //Module Name
    $module = $this->plural->singularize($module); //Make Sure Module Is Singular

    // Select Inheritance Data
    $columns = array($inheritance_select);

    $where = $inheritance_where; //Where
    $select = $columns; //Columns

    //Sort By
    foreach ($sort as $key => $value) {
      $order_by = $this->CoreForm->get_column_name($module, $key); //Set Column name
      $order_type = trim(strtoupper($value));
    }

    //Get Table Name
    $table = $this->plural->pluralize($module);

    if (!is_null($select)) {
      $columns = $this->CoreCrud->set_selectCRUD($module, $select);
      $this->db->select($columns);
    }
    if (!is_null($where)) {
      $where = $this->CoreCrud->set_whereCRUD($module, $where);
      $this->db->where($where);
    }

    $this->db->from($table);
    $this->db->order_by($order_by, $order_type);
    $query = $this->db->get();

    $checkData = $this->CoreCrud->checkResultFound($query); //Check If Value Found
    $queryData = ($checkData == true) ? $query->result() : null;

    return $queryData;
  }

  /*
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

  /*
  *
  * This function help you to select and retun specific column value
  * You can only select single column value
  *
  * In this function you pass
  *
  * 1: Module name / Table name
  *  -> This will be singularize and used to generate column Name
  *  -> Also pluralize for Table Name
  *
  * 2: Pass the selected column name
  * 3: Pass the comparison values
  *  array('column'=>'value')
  *
  * 4: Pass clause if you want to use Like etc.
  *
  * NB: Full Column Name -- will be added by the function 
  * 
  */
  public function selectSingleValue($module, $select, $where, $clause = null)
  {

    //Modules
    $module = $this->plural->singularize($module);
    $table = $this->plural->pluralize($module);

    //Columns
    $select_column = $this->CoreForm->get_column_name($module, $select);
    foreach ($where as $key => $value) {

      $column = $this->CoreForm->get_column_name($module, $key);
      $where_column[$column] = $value; //Set Proper Column Name 
    }

    //Check If Clause specified
    if (!is_null($clause)) {

      $selectData = $this->db->select($select_column)->$clause($where_column)->limit(1)->get($table);
      $checkData = $this->checkResultFound($selectData); //Check If Value Found
      $value = ($checkData == true) ? $selectData->row()->$select_column : null;
    } else {

      $selectData = $this->db->select($select_column)->where($where_column)->limit(1)->get($table);
      $checkData = $this->checkResultFound($selectData); //Check If Value Found
      $value = ($checkData == true) ? $selectData->row()->$select_column : null;
    }

    //Return Data
    return $value;
  }

  /*
  *
  * This function help you to select and retun multiple value
  * You can only select passed column value(s)
  *
  * In this function you pass
  *
  * 1: Module name / Table name
  *  -> This will be singularize and used to generate column Name
  *  -> Also pluralize for Table Name
  *
  * 2: Pass the selected column name(s)
  * 3: Pass the comparison values
  *  array('column'=>'value')
  *
  * 4: Pass clause if you want to use Like etc.
  *
  * NB: Full Column Name -- will be added by the function 
  * 
  */
  public function selectMultipleValue($module, $select, $where, $clause = null)
  {

    //Modules
    $module = $this->plural->singularize($module);
    $table = $this->plural->pluralize($module);

    //Check if select passed is not an array
    if (!is_array($select)) {
      $select = explode(',', $select); //string to Array
    }

    //Set-Up Columns
    for ($i = 0; $i < count($select); $i++) {

      $column = $this->CoreForm->get_column_name($module, $select[$i]);
      $select_column[$i] = $column; //Set Proper Column Name 
    }

    //Set the column array to string
    if (is_array($select_column)) {
      //Columns
      $select_column = implode(',', $select_column); //Array to string
    }

    //Where - Comparison
    foreach ($where as $key => $value) {

      $column = $this->CoreForm->get_column_name($module, $key);
      $where_column[$column] = $value; //Set Proper Column Name 
    }

    //Check If Clause specified
    if (!is_null($clause)) {

      $values = $this->db->select($select_column)->$clause($where_column)->get($table)->result(); //Select Data
    } else {
      $values = $this->db->select($select_column)->where($where_column)->get($table)->result(); //Select Data
    }

    //Return Data
    return $values;
  }



  /*
  *
  * Custom Field Handler
  * This function will save custom field Data
  * Note that once data is saved the function will return the input (insert ID) as array('id'=>inputIDNO)
  * 
  * If you opt for field_data data to be returned set data option as TRUE
  *   array('field_data'=>data)
  *
  ** By Default is True
  *
  * 
  * This function accept 
  * 1: Data to Insert
  * 2: return Data Option
  * 
  */
  public function saveField($insertData, $returnData = true, $pushData = null, $esacapeData = array('id', 'details', 'stamp', 'default', 'flg'))
  {

    //Pluralize Module
    $tableName = $this->plural->pluralize('field');

    //Insert Data Into Table
    $this->db->insert($tableName, $insertData);
    if ($this->db->affected_rows() > 0) {

      $fieldID = $this->db->insert_id(); //Insert ID

      // Check Filter Table
      $field_title = $this->plural->pluralize($insertData['field_title']);
      if ($this->CoreForm->checkTable($field_title)) {
        $filter_columns = $this->CoreForm->getFilterColumns($field_title, $pushData, $esacapeData);

        // InsertFilter
        $insertFilter = $this->CoreForm->fieldFiltered($filter_columns, $insertData['field_filters']);
        $insertFilter['field'] = $fieldID;

        // Get Columns Name
        foreach ($insertFilter as $key => $value) {
          $new_key = strtolower($this->CoreForm->get_column_name($field_title, $key));
          $newFilterData[$new_key] = $value;
        }

        //Stamp,Default,Flg
        $newFilterData = $this->CoreForm->applyCheckFilterTable($newFilterData, $insertData, $field_title);

        // Details
        $details = strtolower($this->CoreForm->get_column_name($field_title, 'details'));
        $newFilterData[$details] = json_encode($newFilterData);

        // Insert Data
        $this->db->insert($field_title, $newFilterData);
      }

      // Return
      $field_data = json_decode($insertData['field_data'], true); //Field Data
      return ($returnData == true) ? array('id' => $fieldID, 'field_data' => $field_data) : array('id' => $fieldID); //Data Inserted
    } else {
      return false; //Data Insert Failed
    }
  }

  /*
  *
  * Custom Field Handler
  * This function will update custom field Data
  * Note that once data is updated the function will return the input (insert ID) as array('id'=>inputIDNO)
  * 
  * If you opt for field_data data to be returned set data option as TRUE
  *   array('field_data'=>data)
  *
  ** By Default is True
  * 
  *
  * This function accept 
  * 1: Data to Updated
  * 2: field ID (Where to afftect)
  * 3: return Data Option
  *
  */
  public function updateField($updateData, $fieldID, $returnData = true, $pushData = null, $esacapeData = array('id', 'details', 'stamp', 'default', 'flg'))
  {

    //Pluralize Module
    $tableName = $this->plural->pluralize('field');

    //Check Field Type
    $whereTYPE = (is_numeric($fieldID)) ? 'id' : 'title';
    $column_id = strtolower($this->CoreForm->get_column_name($tableName, $whereTYPE)); //Column ID
    $where = array($column_id => $fieldID);

    //Update Data In The Table
    $this->db->update($tableName, $updateData, $where);
    if ($this->db->affected_rows() > 0) {

      // Filter Table Name
      $field_title = $this->plural->pluralize($this->selectSingleValue('field', 'title', array($whereTYPE => $fieldID)));
      if (array_key_exists('field_data', $updateData)) {
        // Check Filter Table
        if ($this->CoreForm->checkTable($field_title)) {
          $filter_columns = $this->CoreForm->getFilterColumns($field_title, $pushData, $esacapeData);

          // UpdateFilter
          $updateFilter = $this->CoreForm->fieldFiltered($filter_columns, $updateData['field_filters']);

          // Get Columns Name
          foreach ($updateFilter as $key => $value) {
            $new_key = strtolower($this->CoreForm->get_column_name($field_title, $key));
            $newFilterData[$new_key] = $value;
          }

          //Stamp,Default,Flg
          $newFilterData = $this->CoreForm->applyCheckFilterTable($newFilterData, $updateData, $field_title);

          // Details
          $details = strtolower($this->CoreForm->get_column_name($field_title, 'details'));
          $newFilterData[$details] = json_encode($newFilterData);

          // Where
          $column_filter = strtolower($this->CoreForm->get_column_name($field_title, 'field'));
          $whereFilter = array($column_filter => $fieldID);

          // Updated Data
          $this->db->update($field_title, $newFilterData, $whereFilter);
          $field_data = json_decode($updateData['field_data'], true); //Field Data
          return ($returnData == true) ? array('id' => $fieldID, 'field_data' => $field_data) : array('id' => $fieldID); //Data Updated
        } else {
          // Return
          $field_data = json_decode($updateData['field_data'], true); //Field Data
          return ($returnData == true) ? array('id' => $fieldID, 'field_data' => $field_data) : array('id' => $fieldID); //Data Inserted
        }
      } else {
        if ($this->CoreForm->checkTable($field_title)) {
          $column_set = strtolower($this->CoreForm->get_column_name($field_title, 'field')); //Column ID
          $where_filter = array($column_set => $fieldID);

          // Updated Data
          $filterUpdate = null;
          $keys_values = array_keys($updateData);
          for ($i = 0; $i < count($keys_values); $i++) {
            $key = $keys_values[$i];
            $value = $updateData[$key];

            $column_label = $this->CoreForm->get_label_name($key, $tableName);
            $column_set = strtolower($this->CoreForm->get_column_name($field_title, $column_label)); //Column ID
            $filterUpdate[$column_set] = $value;
          }

          //Stamp,Default,Flg
          $filterUpdate = $this->CoreForm->applyCheckFilterTable($filterUpdate, $updateData, $field_title);

          // Update Filter
          if (!is_null($filterUpdate)) {
            $this->db->update($field_title, $filterUpdate, $where_filter); //Update Data 
          }
        }
        return true; //Data Updated
      }
    } else {
      return false; //Data Updated Failed
    }
  }

  /*
  *
  * Custom Field Handler
  * This function will delete custom field Data
  * Note that once data is delete the function will return the input (insert ID) as array('id'=>inputIDNO)
  *  
  *
  * This function accept 
  * 1: fieldID (Where to afftect)
  * 2: Module affeted => By Defult is 'field'
  *
  */
  public function deleteField($fieldID)
  {

    //Pluralize Module
    $tableName = $this->plural->pluralize('fields');

    //Check Field Type
    $whereTYPE = (is_numeric($fieldID)) ? 'id' : 'title';
    $column_id = strtolower($this->CoreForm->get_column_name($tableName, $whereTYPE)); //Column ID
    $where = array($column_id => $fieldID);

    // Filter Table Name
    $field_title = $this->plural->pluralize($this->selectSingleValue('field', 'title', array($whereTYPE => $fieldID)));

    //Deleted Data In The Table
    if ($this->db->delete($tableName, $where)) {
      // Filter Table
      if ($this->CoreForm->checkTable($field_title)) {
        $column_set = strtolower($this->CoreForm->get_column_name($field_title, 'field')); //Column ID
        $where_filter = array($column_set => $fieldID);
        $this->db->delete($field_title, $where_filter);
      }
      return array('id' => $fieldID); //Data Deleted
    } else {
      return false; //Data Deletion Failed
    }
  }

  /*
  * This Function Manage CustomFields Data
  * By default CoreLite will save data and return response
  *
  *
  * This function accept 
  * 1: Status (save|update|delete)
  * 2: Route (NB: this must match your customfield -> title)
  * 3: FormData (field_data) Values
  * 4: fieldID (fieldID)
  *
  */
  public function customFieldAuto($status, $route = null, $formValues, $fieldID = null)
  {

    //Check Route
    if (!is_null($route)) {
      //Table Name
      $table = $this->plural->pluralize($route);

      //Check If Table Exist
      if ($this->db->table_exists($table)) {

        //load ModelField
        $this->load->model('CoreField');
        $autosave = ((method_exists('CoreField', 'customFieldAuto'))) ? $this->CoreField->customFieldAuto($route) : true;

        //Check Auto Save
        if ($autosave) {
          //Get Columns
          $column_data = $this->get_column_data($table);
          $column_type = $this->CoreForm->get_column_name_type($column_data);

          $columns = $this->CoreForm->get_label_name($column_type, $table);
          $columns = array_values($this->unsetData($columns, array(0)));

          //Check Field Data
          if (array_key_exists('field_data', $formValues)) {

            $field_data = $formValues['field_data']; //Field Data
            $formData['field'] = (!is_null($fieldID)) ? $fieldID : $formValues['id']; //Field ID

            //Assign Data
            for ($i = 0; $i < count($columns); $i++) {
              $column_name = $columns[$i];
              if (array_key_exists($column_name, $field_data)) {
                $formData[$column_name] = $field_data[$column_name]; //Field Value
              }
            }

            //Flg, Default & Time Stamp
            $formData['stamp'] = $this->selectSingleValue('fields', 'stamp', array('id' => $fieldID));
            $formData['default'] = $this->selectSingleValue('fields', 'default', array('id' => $fieldID));
            $formData['flg']  = $this->selectSingleValue('fields', 'flg', array('id' => $fieldID));
            //Details
            $formData['details'] = json_encode($formData);

            //Get Column Names
            foreach ($formData as $key => $value) {
              $column_name = $this->CoreForm->get_column_name($table, $key);
              $extendData[$column_name] = $value;
            }
          } else {
            //Flg, Default & Time Stamp
            $formData['stamp'] = $this->selectSingleValue('fields', 'stamp', array('id' => $fieldID));
            $formData['default'] = $this->selectSingleValue('fields', 'default', array('id' => $fieldID));
            $formData['flg']  = $this->selectSingleValue('fields', 'flg', array('id' => $fieldID));

            //Get Column Names
            foreach ($formData as $key => $value) {
              $column_name = $this->CoreForm->get_column_name($table, $key);
              $extendData[$column_name] = $value;
            }
          }

          //Check Status
          $status = strtolower($status);
          switch ($status) {
            case 'save':
              $this->db->insert($table, $extendData); //Insert Data Into Table
              if ($this->db->affected_rows() > 0) {
                return $this->db->insert_id();
              } else {
                return false;
              }
              break;

            case 'update':
              //Check Field Data
              $field_column = $this->CoreForm->get_column_name($table, 'fields');
              $this->db->update($table, $extendData, array($field_column => $fieldID)); //Update Data 
              if ($this->db->affected_rows() > 0) {
                return $fieldID;
              } else {
                return false;
              }
              break;

            case 'delete':
              //Check Field Data
              $field_column = $this->CoreForm->get_column_name($table, 'fields');
              $this->db->delete($table, array($field_column => $fieldID)); //Delete Data
              if ($this->db->affected_rows() > 0) {
                return $fieldID;
              } else {
                return false;
              }
              break;

            default:
              return false; //Failed
              break;
          }
        } else {
          return $fieldID; //Return ID
        }
      } else {
        return false; //Not Successful
      }
    } else {
      return false; //Not Successful
    }
  }

  /*
  *
  * Custom Field Auto Manager Helper
  *
  * This helper will help the operation of SAVE & UPDATE
  * NB: This helper will also affect customfields *extended* tables
  *
  *
  * This function accept 
  * 1: Status (save|update|delete)
  * 2: FormData (field_data) Values
  * 3: fieldID (fieldID)
  * 4: Route (NB: this must match your customfield -> title)
  * 5: return Data Option
  *
  */
  public function customFieldHelper($status, $formData, $fieldID = null, $route = null, $returnData = true)
  {

    //Check Status
    $status = strtolower($status);
    switch ($status) {
      case 'save':
        //Save Data
        $formData = $this->saveField($formData, $returnData, 'fields');
        $this->customFieldAuto($status, $route, $formData, $fieldID);
        break;
      case 'update':
        //Update Data
        $formData = $this->updateField($formData, $fieldID, $returnData, 'fields');
        $this->customFieldAuto($status, $route, $formData, $fieldID);
        break;
      case 'delete':
        //Update Data
        $formData = $this->deleteField($fieldID, 'fields');
        $this->customFieldAuto($status, $route, $formData, $fieldID);
        break;
      default:
        $formData = array('id' => false);
        break;
    }

    //Check Action
    return ($formData['id']) ? true : false;
  }

  /*
  * 
  * This function Check field Helpers Status
  *
  * 1: Passed Returned Data
  */
  public function fieldStatus($returnedData)
  {
    //Check If is array
    if (is_array($returnedData)) {
      $status = (array_key_exists('id', $returnedData)) ? $returnedData['id'] : false;
    } else {
      $status = ($returnedData > 0) ? true : false;
    }

    return $status; //Return Status
  }

  /*
  *
  * Count Table Rows
  * This function will return number of rows in a table selected
  * By Default the function will do selection query only by ID (this is to speedup the selection process) 
  * Then it will count the number of retuned results
  * and return the number
  *
  * This function accept 
  * 1: Table Name | passed as string
  * 2: Clase, a where clause if you want to check specific column value
  *  NB: pass as an array | array('column_name' => 'match_value');
  * 
  */
  public function countTableRows($table, $where = null)
  {

    //Get Table Name
    $table = $this->plural->pluralize($table);

    //Check if Clause Specified
    if (!is_null($where)) {

      //Select
      $columns = array('id');
      $where = array($where);
      $data = $this->selectCRUD($table, $where, $columns);
    } else {

      $columns = array('id');
      $data = $this->selectCRUD($table, null, $columns);
    }

    //Count Number of result
    if (is_array($data)) {
      $row_num = count($data);
    } else {
      $row_num = 0;
    }

    return $row_num; //Number Of Rows
  }


  /*
  *
  * Upload File Data
  * -> Pass Input Name
  * -> Pass Input Location (Upload location)
  * 
  */
  public function upload($inputName, $location = '../assets/media', $rule = 'jpg|jpeg|png|doc|docx|pdf|xls|txt', $link = true, $configs = null)
  {

    //Upload Data
    $uploaded = $this->uploadFile($_FILES[$inputName], $rule, $location, $link, $configs);
    if (!is_null($uploaded)) {
      $file_link = json_encode($uploaded, true);
    } else {
      $file_link = json_encode(null);
    }
    return $file_link;
  }

  /*
  *
  * Upload File Class
  * The function accept the input data, 
  * validation string and 
  * Upload Location
  * Return Link or Name | By Default it return Name
  * 
  */
  public function uploadFile($input = null, $valid = 'jpg|jpeg|png|doc|docx|pdf|xls|txt', $file = '../assets/media', $link = false, $configs = null)
  {

    //Library
    $this->load->library('upload');

    //Default COnfig Settings
    $filePath = $this->uploadDirecory($file);
    $file = $filePath[1];
    $config['upload_path'] = $filePath[0];
    $config['allowed_types'] = $valid;
    $config['max_size'] = 2048;
    $config['encrypt_name'] = TRUE;

    //load ModelField
    $this->load->model('CoreField');
    $customConfig = ((method_exists('CoreField', 'uploadSettings'))) ? $this->CoreField->uploadSettings() : false;
    if ($customConfig) {
      foreach ($customConfig as $key => $value) {
        $config[$key] = $value; //Ovewrite Settings
      }
    }

    //Additional Configs - Passed Through FUnction
    if (!is_null($configs)) {
      foreach ($configs as $key => $value) {
        $config[$key] = $value; //Ovewrite Settings
      }
    }

    //Check Input
    if (!is_null($input)) {

      $this->upload->initialize($config);

      $key = 0;
      for ($i = 0; $i < count($input['name']); $i++) {

        $_FILES['photo']['name']     = $input['name'][$i];
        $_FILES['photo']['type']     = $input['type'][$i];
        $_FILES['photo']['tmp_name'] = $input['tmp_name'][$i];
        $_FILES['photo']['error']     = $input['error'][$i];
        $_FILES['photo']['size']     = $input['size'][$i];


        if ($this->upload->do_upload('photo')) {
          $data_upload = array('upload_data' => $this->upload->data());

          //Uploaded
          $file_name = $data_upload['upload_data']['file_name'];

          //Return
          if ($link == true) {
            $file_uploaded[$key] = trim(str_replace("../", " ", trim($file)) . '/' . $file_name);
            $key++;
          } else {
            $file_uploaded[$key] = $file_name;
            $key++;
          }
        } else {
          $file_uploaded[$key] = null;
        }
      }
      return $file_uploaded;
    } else {

      return null;
    }
  }

  /*
  *
  * File Path/Directory
  * -> Pass where you wish file to be uploaded.
  *
  * This function will check if in the director Folder arranged by
  * == Year - Month - Date
  *
  * If not it will create the folders and return appropiate URL to upload
  *
  * NB: To overide this function | pass FALSE after URL
  * 
  */
  public function uploadDirecory($path = '../assets/media', $default = true)
  {

    //Check Default
    $default = ((method_exists('CoreField', 'uploadDefault'))) ? $this->CoreField->uploadDefault() : true;


    //Check IF Deafult
    if ($default) {
      $file_path = '/' . date('Y') . '/' . date('m') . '/' . date('d'); //Suggested Path
      $pathFolder = realpath(APPPATH . $path); //Real Path

      $newDirectory = $pathFolder . $file_path; // New Path | New APPATH Directory
      $permission = 0755; //Deafault
      $recursive = True; //Deafult

      //Check Additonal Config
      if (method_exists('CoreField', 'changeDirData')) {
        //Config
        $configDir = $this->CoreField->changeDirData($newDirectory, $permission, $recursive);
        $newDirectory = $configDir['dir']; // New Path | New APPATH Directory
        $permission = $configDir['permission']; //Deafault
        $recursive = $configDir['recursive']; //Deafult
      }

      // Create Directory
      if (!file_exists($newDirectory)) {
        mkdir($newDirectory, $permission, $recursive);
      }

      $uploadTo = $path . $file_path; //New Path
      $path_url = array($newDirectory, $uploadTo); //Upload Path
    } else {
      $path_url = array(realpath(APPPATH . $path), $path);
    }

    return $path_url; // Return PATH
  }

  /*
  *
  * Delete Image/File Class
  * The function accept the file stored path, 
  *
  */
  public function deleteFile($path)
  {

    //File URL
    $file = "../" . $path;

    //Base FIle URL
    $filelocated = realpath(APPPATH . $file); //New APPATH Directory

    if ($filelocated) {
      //Check If File Exist
      if (file_exists($filelocated) === True) {
        //Check Default
        $unlick = ((method_exists('CoreField', 'unlinkSetting'))) ? $this->CoreField->unlinkSetting() : true;
        if ($unlick) {
          //Delete FIle
          unlink($filelocated);
        }
      }
    }
  }

  /*
  *
  * Generate Image Size
  * This method will return image size as array('width' => , 'height' => )
  *
  * 1: Pass Custom Size
  * 2: Pass Default Size | should never be null array('width' => , 'height' => )
  */
  public function imageSize($config, $default)
  {

    //Width & Size
    $width = null;
    $height = null;

    //Config Size
    if (is_array($config)) {
      $width_config = (array_key_exists('width', $config)) ? $config['width'] : $width;
      $height_config = (array_key_exists('height', $config)) ? $config['height'] : $height;

      //New Width & Height
      $width = (is_null($width)) ? $width_config : $width;
      $height = (is_null($height)) ? $height_config : $height;
    }

    //Default
    $default = (is_null($default) || !is_array($default)) ? array('width' => 20, 'height' => 20) : $default;

    //Size
    $config['width'] = (is_null($width)) ? $default['width'] : $width;
    $config['height'] = (is_null($height)) ? $default['height'] : $height;

    //Return
    return $config;
  }


  /*
  * Add Thumbnail
  * -> This method will add a thumbnail for your image
  *
  * 1: Pass image path (where the image is found) as per what is returned by ->uploadFile() *Required*
  * 2: Pass cofiguration, optional you can use the default or declaire custom in CoreField->thumbConfig()
  **/
  public function addThumbnail($file_name, $custom_config = array())
  {
    //File Path
    $file_path = trim(str_replace("../", " ", trim($file_name)));

    //Default Size
    $defaultSize = array('width' => 70, 'height' => 70);

    //Default Config
    $config['image_library'] = 'GD2';
    $config['source_image'] = './' . $file_path;
    $config['maintain_ratio'] = false;
    $config['overwrite'] = False;
    $config['quality'] = '100%';
    $config['create_thumb'] = True;
    $config['thumb_marker'] = '_thumb';

    //Custom Thumbnail Configuration
    $thumbConfig = ((method_exists('CoreField', 'thumbConfig'))) ? $this->CoreField->thumbConfig() : array();

    //CoreField Configs
    foreach ($thumbConfig as $key => $value) {
      $config[$key] = $value;
    }

    // Passed Config
    foreach ($custom_config as $key => $value) {
      $config[$key] = $value;
    }

    //Get Image Size
    $config = $this->imageSize($config, $defaultSize);

    // Load Image Lib
    $this->load->library('image_lib', $config);
    $this->image_lib->initialize($config);
    if (!$this->image_lib->resize()) {
      echo $this->image_lib->display_errors();
    }
    $this->image_lib->clear();
  }

  /*
  * Add Watermark
  * -> This method will add a watermark for your image
  *
  * 1: Pass image path (where the image is found) as per what is returned by ->uploadFile() *Required*
  * 2: Pass cofiguration, optional you can use the default or declaire custom in CoreField->watermarkConfig()
  *
  * NB: Add watermark then resize
  **/
  public function addWatermark($file_name, $custom_config = array())
  {
    //File Path
    $file_path = trim(str_replace("../", " ", trim($file_name)));
    $logo = $this->CoreLoad->ext_asset('/images/logo', 'assets') . "/core.fw.png";

    //Default Config
    $config['image_library'] = 'GD2';
    $config['source_image'] = './' . $file_path;
    $config['wm_type'] = 'overlay';
    $config['wm_overlay_path'] = './' . $logo;
    $config['wm_opacity'] = 50;
    $config['wm_vrt_alignment'] = 'middle';
    $config['wm_hor_alignment'] = 'center';
    $config['wm_padding'] = 20;
    $config['overwrite'] = True;

    //Custom Watermark Configuration
    $watermarkConfig = ((method_exists('CoreField', 'watermarkConfig'))) ? $this->CoreField->watermarkConfig() : array();

    //CoreField Configs
    foreach ($watermarkConfig as $key => $value) {
      $config[$key] = $value;
    }

    // Passed Config
    foreach ($custom_config as $key => $value) {
      $config[$key] = $value;
    }

    //Add Watermark
    $this->load->library('image_lib', $config);
    $this->image_lib->initialize($config);
    if (!$this->image_lib->watermark()) {
      echo $this->image_lib->display_errors();
    }
    $this->image_lib->clear();
  }

  /*
  *  Resize Image
  * -> This method will resize your image
  *
  * 1: Pass image path (where the image is found) as per what is returned by ->uploadFile() *Required*
  * 2: Pass the dimession (Size) & Background Color, optional you can use the default or declaire custom in CoreField->resizeImageConfig()
  *
  * NB: Only For JPG(JPEG), PNG and GIF
  **/
  public function resizeImage($file_name, $custom_config = array())
  {
    //File Path
    $source_image_path = trim(str_replace("../", " ", trim($file_name)));
    $thumbnail_image_path = trim(str_replace("../", " ", trim($file_name)));

    //Default Size
    $defaultSize = array('width' => 564, 'height' => 396);
    //Default RGB Color
    $config['color'] = array(4, 20, 26);

    //Config
    $resizeImageConfig = ((method_exists('CoreField', 'resizeImageConfig'))) ? $this->CoreField->resizeImageConfig() : $custom_config;
    foreach ($resizeImageConfig as $key => $value) {
      $config[$key] = $value;
    }

    // Passed Config
    foreach ($custom_config as $key => $value) {
      $config[$key] = $value;
    }

    //Get Image Size
    $config = $this->imageSize($config, $defaultSize);

    // Colors
    $colors = array_values($config['color']);
    for ($i = 0; $i < 3; $i++) {
      $rgb[$i] = (array_key_exists($i, $colors)) ? $colors[$i] : 0;
    }

    $THUMBNAIL_IMAGE_MAX_WIDTH = $config['width'];
    $THUMBNAIL_IMAGE_MAX_HEIGHT = $config['height'];

    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
    switch ($source_image_type) {
      case IMAGETYPE_GIF:
        $source_gd_image = imagecreatefromgif($source_image_path);
        break;
      case IMAGETYPE_JPEG:
        $source_gd_image = imagecreatefromjpeg($source_image_path);
        break;
      case IMAGETYPE_PNG:
        $source_gd_image = imagecreatefrompng($source_image_path);
        break;
    }
    if ($source_gd_image === false) {
      return false;
    }
    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = $THUMBNAIL_IMAGE_MAX_WIDTH / $THUMBNAIL_IMAGE_MAX_HEIGHT;
    if ($source_image_width <= $THUMBNAIL_IMAGE_MAX_WIDTH && $source_image_height <= $THUMBNAIL_IMAGE_MAX_HEIGHT) {
      $thumbnail_image_width = $source_image_width;
      $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
      $thumbnail_image_width = (int) ($THUMBNAIL_IMAGE_MAX_HEIGHT * $source_aspect_ratio);
      $thumbnail_image_height = $THUMBNAIL_IMAGE_MAX_HEIGHT;
    } else {
      $thumbnail_image_width = $THUMBNAIL_IMAGE_MAX_WIDTH;
      $thumbnail_image_height = (int) ($THUMBNAIL_IMAGE_MAX_WIDTH / $source_aspect_ratio);
    }
    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);

    $img_disp = imagecreatetruecolor($THUMBNAIL_IMAGE_MAX_WIDTH, $THUMBNAIL_IMAGE_MAX_HEIGHT);
    $backcolor = imagecolorallocate($img_disp, $rgb[0], $rgb[1], $rgb[2]);
    imagefill($img_disp, 0, 0, $backcolor);

    imagecopy($img_disp, $thumbnail_gd_image, (imagesx($img_disp) / 2) - (imagesx($thumbnail_gd_image) / 2), (imagesy($img_disp) / 2) - (imagesy($thumbnail_gd_image) / 2), 0, 0, imagesx($thumbnail_gd_image), imagesy($thumbnail_gd_image));

    imagejpeg($img_disp, $thumbnail_image_path, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    imagedestroy($img_disp);
    return true;
  }

  /*
  * 
  * Compress Image 
  * -> This method will compress your image
  *
  * 1: Pass image path (where the image is found) as per what is returned by ->uploadFile() *Required*
  * 2: Pass cofiguration, optional you can use the default or declaire custom in CoreField->compressImageConfig()
  *
  * NB: Add watermark then resize
  **/
  public function compressImage($file_name, $custom_config = null)
  {
    //File Path
    $file_path = trim(str_replace("../", " ", trim($file_name)));

    //Default Size
    $defaultSize = array('width' => 564, 'height' => 396);

    //Default Config
    $config['image_library'] = 'GD2';
    $config['source_image'] = './' . $file_path;
    $config['maintain_ratio'] = True;
    $config['overwrite'] = True;
    $config['quality'] = '90%';

    //Custom Compress Configuration
    $compressImageConfig = ((method_exists('CoreField', 'compressImageConfig'))) ? $this->CoreField->compressImageConfig() : array();

    //CoreField Configs
    foreach ($compressImageConfig as $key => $value) {
      $config[$key] = $value;
    }

    // Passed Config
    foreach ($custom_config as $key => $value) {
      $config[$key] = $value;
    }

    //Get Image Size
    $config = $this->imageSize($config, $defaultSize);

    // Load Image Lib
    $this->load->library('image_lib', $config);
    $this->image_lib->initialize($config);
    if (!$this->image_lib->resize()) {
      echo $this->image_lib->display_errors();
    }
    $this->image_lib->clear();
  }

  /*
  *
  * Generate Url From Title
  * 
  */
  public function postURL($postID, $currURL = null, $module = 'page')
  {

    //Modules
    $module = $this->plural->singularize($module);
    $table = $this->plural->pluralize($module);

    //Columns
    $page_column_id = $this->CoreForm->get_column_name($module, 'id');
    $page_column_title = $this->CoreForm->get_column_name($module, 'title');
    $page_column_createdat = $this->CoreForm->get_column_name($module, 'createdat');
    $page_column_url = $this->CoreForm->get_column_name($module, 'url');

    //Select Post
    $postTitle = $this->db->select("$page_column_id,$page_column_title")->where("$page_column_id", $postID)
      ->order_by("$page_column_createdat desc")->limit(1)->get("$table");
    $postData = $postTitle->result();

    //Url Format
    $current_url = $this->db->select('setting_value')->where('setting_title', 'current_url')->get('settings')->row()->setting_value;

    if (strtolower($current_url) == 'title') {

      if (!is_null($currURL)) {
        $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($currURL)), 0, 50);
      } else {
        $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($postData[0]->$page_column_title)), 0, 50);
      }

      $url = str_replace(" ", "-", strtolower(trim($post_url)));
      $ExistingURL = $this->db->select("$page_column_url")->like("$page_column_url", $url, "both")
        ->order_by("$page_column_createdat desc")->limit(1)->get("$table");
      $URL = $ExistingURL->result();
      if (!empty($URL)) {
        $post_url = $url . '-' . $postData[0]->$page_column_id;
      } else {
        $post_url = $url;
      }
    } elseif (strtolower($current_url) == 'get') {
      if (!is_null($currURL)) {
        $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($currURL)), 0, 50);
      } else {
        $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($postData[0]->$page_column_title)), 0, 50);
      }

      $url = str_replace(" ", "-", strtolower(trim($post_url)));
      $ExistingURL = $this->db->select("$page_column_url")->like("$page_column_url", $url, "both")
        ->order_by("$page_column_createdat desc")->limit(1)->get("$table");
      $URL = $ExistingURL->result();
      if (!empty($URL)) {
        $post_url = '?p=' . $url . '-' . $postData[0]->$page_column_id;
      } else {
        $post_url = '?p=' . $url;
      }
    } else {
      $post_url = $postData[0]->$page_column_id;
    }

    return $post_url;
  }

  /*
  *
  * Check If Same URL Exist 
  */
  public function checkURL($currURL, $currPOST, $module = 'page')
  {

    //Modules
    $module = $this->plural->singularize($module);
    $table = $this->plural->pluralize($module);

    //Columns
    $page_column_id = $this->CoreForm->get_column_name($module, 'id');
    $page_column_title = $this->CoreForm->get_column_name($module, 'title');
    $page_column_createdat = $this->CoreForm->get_column_name($module, 'createdat');
    $page_column_url = $this->CoreForm->get_column_name($module, 'url');

    $ExistingURL = $this->db->select("$page_column_id,$page_column_title,$page_column_url")->where("$page_column_id", $currPOST)
      ->order_by("$page_column_createdat desc")->limit(1)->get("$table");
    $URL = $ExistingURL->result();
    if ($URL[0]->$page_column_url == $currURL) {
      return $currURL;
    } else {
      return $this->postURL($URL[0]->$page_column_id, $currURL);
    }
  }

  /*
  *
  * This function allow user to remove array key and it's value from the data
  * The two parameters passed are
  * 1: $passedData - the array containing full data
  * 2: $unsetData - the value you wish to be removed from the array
  *
  *  -> The function will return the remaining of the data
  */
  public function unsetData($passedData, $unsetData = null)
  {
    if (!is_null($unsetData)) {
      //Set Array If it is String
      if (!is_array($unsetData)) {
        $unsetData = explode(',', $unsetData); //Produce Array
      }

      //Unset Data
      for ($i = 0; $i < count($unsetData); $i++) {
        $unset = $unsetData[$i]; //Key Value To Remove
        unset($passedData["$unset"]); //Remove Item
      }

      return $passedData; //Remaining Data AFter Unset
    } else {
      return $passedData; //All Data Without Unset
    }
  }

  /*
  *
  * This function allow query to be counted before selection
  * Means when you want to select a value use this query to make sure the value exist
  * It will avoid error
  * NB: This is mostly used by the system  
  * 
  */
  public function checkResultFound($query)
  {
    if ($query->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  /*
  *
  * Destroy Data Session
  *  This function will destroy all page session values
  *  For specific session pass session ID/name as array
  *  
  */
  public function destroySession($sessionData = null)
  {

    //Check If Session Key(name/id) was Passed
    if (!is_null($sessionData)) {

      //Destroy specific session item
      for ($i = 0; $i < count($sessionData); $i++) {

        $item = $sessionData[$i]; //Destroy Session Item

        //Check If Session Key is Set
        if (isset($this->session->$item)) {
          $this->session->unset_userdata($item); //Destroy Session
        }
      }
    } else {
      $this->session->sess_destroy(); // Destroy all session data
    }
  }

  /*
  *
  * Get Table Column Name and Column Type
  * Function accept Module name then it pluralize it to get table name
  * 
  */
  public function get_column_data($module, $database = null)
  {
    //Get Table Name
    $table = $this->plural->pluralize($module);
    $database = (is_null($database)) ? $this->db->database : $database;

    //Query
    $query = $this->db->query("SELECT COLUMN_NAME, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$database' 
        AND TABLE_NAME = '$table'");

    //Return
    return $query->result();
  }

  /*
    *
    * Load Json Formated Data (THE DATA HAS TO BE IN JSON FORMAT)
    * -> Works best for Settings and AutoFields. 
    * -> NB: For Fields use CoreCrud->selectField
    *
    * Pass
    * 1: Where condition, for sql search in autofields | array('title'=>'extension_menu','flg'=>1)
    * 2: Pass (optional. By default all key will be returned) what to be returned by it's key name | menu_path
    * 3: Pass table name (optional) | by default 'settings'
    * 4: Pass column name to select from (optional) | By default 'value' column will be selected
    * 
    * -> Returned data will be array(key => value)
    */
  public function loadJsonData($where, $return = null, $table = 'settings', $select = 'value')
  {

    $data = null; //Storage
    if (is_array($where)) {
      $jsonData = $this->selectSingleValue($table, $select, $where); // Select Json Formatted Data
      //Check Selected
      if (!is_null($jsonData) && !empty($jsonData)) {
        $json_array = json_decode($jsonData, True);
        if (is_array($json_array)) {
          if (!is_null($return)) {
            if (array_key_exists($return, $json_array)) {
              $data[$return] = $json_array[$return];
            }
          } else {
            foreach ($json_array as $key => $value) {
              $data[$key] = $value;
            }
          }
        }
      }
    }

    //Return Data
    return (!is_null($data) && is_array($data)) ? $data : null;
  }
}

/* End of file CoreCrud.php */
/* Location: ./application/models/CoreCrud.php */