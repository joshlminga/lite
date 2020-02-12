<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreForm extends CI_Model {


    /*
    *
    * To load libraries/Model/Helpers/Add custom code which will be used in this Model
    * This can ease the loading work 
    * 
    */
    public function __construct(){

        parent::__construct();

        //libraries
        
        //Helpers

        //Models
        
        // Your own constructor code
        
    }


    /*
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

    /*
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
        $result = $this->db->query("SHOW TABLES LIKE '".$tableName."'");
        if ($result->result_id->num_rows == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    /*
    *
    * Function to generate columns name or Type Array
    * Pass columns Name & Type array
    * 
    */
    public function get_column_name_type($column_name_type,$get='name')
    {
        //Array to store Data
        $name_type = array();
        //Get Type/Name
        if (strtolower($get) == 'type') {
            //Get Type
            for($i = 0; $i < count($column_name_type); $i++){
                $name_type[$i] = $column_name_type[$i]->COLUMN_TYPE;// Assign Column Type
            }
        }else{
            //Get Name
            for($i = 0; $i < count($column_name_type); $i++){
                $name_type[$i] = $column_name_type[$i]->COLUMN_NAME;// Assign Column Name
            }
        }

        //Return Data
        return $name_type;
    }

    /*
    *
    * The function generate proper multiple/single column names
    * The function accepts
    * 1: Module Name
    * 2: Column simple name(s)
    * 
    */
    public function get_column_name($module,$column)
    {
        //Singularize Module
        $module = $this->plural->singularize($module);

        if (!is_array($column) && strpos($column,",") == False) {
            $column_name = $module.'_'.$column; //Column Name
        }else{
            if (!is_array($column) && strpos($column,",") == True) { $column = explode(",", $column); /* Get Column Name */ }
            for($i = 0; $i < count($column); $i++){
                $column_name[$i] = $this->get_column_name($module,$column[$i]); //Column Name
            }
        }

        return $column_name; //Column Name
    }

    /*
    *
    * Function to remove column Name and Return Label Name
    * Pass columns name(s) array/string
    * 
    */
    public function get_label_name($column)
    {
        //Check If Value Passed is Not Array
        if (!is_array($column) && strpos($column,",") == False) {
            $label =  substr($column,strpos($column, "_") +1); //Get Current Label Name
        }else{            
            if (!is_array($column) && strpos($column,",") == True) { $column = explode(",", $column); /* Get Column Name */ }
            //Remove Module Name
            for($i = 0; $i < count($column); $i++){
                $column_name = $column[$i]; //Set Current Column Name
                $label[$i] =  substr($column_name,strpos($column_name, "_") +1); //Get Current Label Name
            }
        }
        
        return $label;//Return Label List
    }

    /*
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
        $filename = (array_key_exists("file_name",$validation))? $validation['file_name'] : $this->session->file_name; //File Name
        $required = (array_key_exists("file_required",$validation))? $validation['file_required'] : $this->session->file_required; //Required

        //Set Upload File Values
        $file_upload_session = array('file_name'=>$filename,'file_required'=>$required);
        $this->session->set_userdata($file_upload_session);
    }

    /*
    *
    * Get User Profile
    * This function is used to get user profile is isset
    *
    * Pass user ID (If null -> session ID will be take)
    * Pass user Profile Keyname (By default is user-profile)
    * Pass Default Optional Profile [Pass either yes/no] (By default it will use level from user_level)
    */
    public function userProfile($userId=null,$profileKey='user_profile',$userDefault=null)
    {
        //User ID
        $user = (is_null($userId))? $this->CoreLoad->session('id') : $userId;
        //User Level
        $level =  $this->CoreCrud->selectSingleValue('users','level',array('id'=>$user));

        //Default Profile
        $userDefault = $this->CoreCrud->selectSingleValue('levels','default',array('name'=>$level));
        //Profile Name
        $optionalProfile = ($userDefault == 'yes')? 'assets/admin/img/profile-pics/admin.jpg' : 'assets/admin/img/profile-pics/user.jpg';

        //Get Profile
        $details = $this->CoreCrud->selectSingleValue('users','details',array('id'=>$user));
        $detail = json_decode($details, True);
        //Check Profile
        if (array_key_exists($profileKey,$detail)){
            $user_profile = json_decode($detail[$profileKey], True); //User Profile Array
            $profile = $user_profile[0]; //Profile Picture
        }else{
            $profile = null; //No Profile Set
        }

        //Get Profile
        $profile = (is_null($profile)) ? $optionalProfile : $profile;
        return $profile;
    }

    /*
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
    public function saveFormField($formData,$inputID,$unsetData=null,$unsetKey='before',$addFilters=null,$Module='field')
    {

        //Check Field -> Stamp | Default | Flg
        $stamp_column = strtolower($this->CoreForm->get_column_name($Module,'stamp'));
        $default_column = strtolower($this->CoreForm->get_column_name($Module,'default'));
        $flg_column = strtolower($this->CoreForm->get_column_name($Module,'flg'));
        $formCheck = $formData; 
        $formData = $this->CoreCrud->unsetData($formData,array('stamp',$stamp_column,'default',$default_column,'flg',$flg_column));

        //Table Select & Clause
        $customFieldTable = $this->plural->pluralize('customfields');

        //Columns
        $columns = array('title as title,filters as filters,default as default');

        //Check Field Type
        $whereTYPE = (is_numeric($inputID))? 'id' : 'title';
        $where = array($whereTYPE => $inputID);

        //Select
        $fieldList = $this->CoreCrud->selectCRUD($customFieldTable,$where,$columns);

        $field_title = $fieldList[0]->title; //Title Title
        $field_filter = json_decode($fieldList[0]->filters, True); //FIlter List
        $field_default = $fieldList[0]->default; //Default

        //UnSet ID
        $formData = $this->CoreCrud->unsetData($formData,array('id'));

        //Set Values For Filter
        for($i = 0; $i < count($field_filter); $i++){
          $valueFilter = trim($field_filter[$i]); //Current Value
          $newFilterDataValue[$valueFilter] = $formData[$valueFilter];
        }

        //Check Additional Filters
        $dataFilters = (!is_null($addFilters))? array_merge($newFilterDataValue,$addFilters) : $newFilterDataValue;
        $tempo_filter = json_encode($dataFilters); /* Set Filters */

        //Set Field Data
        $column_data = strtolower($this->CoreForm->get_column_name($Module,'data'));
        $formData[$column_data] = json_encode($formData); //Set Data

        //Prepaire Data To Store
        foreach ($formData as $key => $value) {
          if ($key !== $column_data) {
            $children[$key] = $value;
            $formData = $this->CoreCrud->unsetData($formData,array($key)); //Unset Data
          }
        }

        //Set Filters
        $column_filters = strtolower($this->CoreForm->get_column_name($Module,'filters'));
        $formData[$column_filters] = $tempo_filter; /* Set Filters */

        //Set Title/Name
        $column_title = strtolower($this->CoreForm->get_column_name($Module,'title'));
        $formData[$column_title] = $field_title; //Set Title

        //Details Column Update
        $details = strtolower($this->CoreForm->get_column_name('field','details'));

        //Apply Field -> Stamp | Default | Flg
        $formData = $this->applyCheckFieldTable($formData,$formCheck,$Module);

        //Check Unset Key
        if (strtolower($unsetKey) == 'before') {
            $formData = $this->CoreCrud->unsetData($formData,$unsetData); //Unset Data
            $formData[$details] = json_encode($formData); //Details
        }else{

            $formData[$details] = json_encode($formData); //Details
            $formData = $this->CoreCrud->unsetData($formData,$unsetData); //Unset Data
        }

        //Form Data
        $formData = $this->applyCheckFieldTable($formData,$formCheck,$Module);

        //Form Data
        return $formData;
    }

    /*
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
    public function updateFormField($updateData,$inputID,$unsetData=null,$unsetKey='before',$addFilters=null,$Module='field')
    {

        //Check Field -> Stamp | Default | Flg
        $stamp_column = strtolower($this->CoreForm->get_column_name($Module,'stamp'));
        $default_column = strtolower($this->CoreForm->get_column_name($Module,'default'));
        $flg_column = strtolower($this->CoreForm->get_column_name($Module,'flg'));
        $formCheck = $updateData; 
        $updateData = $this->CoreCrud->unsetData($updateData,array('stamp',$stamp_column,'default',$default_column,'flg',$flg_column));

        //Table
        $customFieldTable = $this->plural->pluralize('customfields');

        //Check Field Type
        $whereTYPE = (is_numeric($inputID))? 'id' : 'title';
        $where = array($whereTYPE => $inputID);

        //Table Select & Clause
        $columns = array('id as id,title as title,data as data,details as details');
        $resultList = $this->CoreCrud->selectCRUD($Module,$where,$columns);

        //Table Select & Clause
        $columns = array('id as id,required as required,optional as optional,filters as filters,default as default');
        $where = array('title' => $resultList[0]->title);
        $fieldList = $this->CoreCrud->selectCRUD($customFieldTable,$where,$columns,'like');

        //FIlter List
        $field_filter = json_decode($fieldList[0]->filters, True); //FIlter List
        $field_default = $fieldList[0]->default; //Default

        //Get Current Data
        $current_data = json_decode($resultList[0]->data, True);
        //Set Filters
        $column_filters = strtolower($this->CoreForm->get_column_name($Module,'filters'));

        //Set Values FOr Filter
        for($i = 0; $i < count($field_filter); $i++){
          $valueFilter = $field_filter[$i]; //Current Value
          $newFilterDataValue[$valueFilter] = $updateData[$valueFilter];
        }

        //Check Additional Filters
        $dataFilters = (!is_null($addFilters))? array_merge($newFilterDataValue,$addFilters) : $newFilterDataValue;
        $tempo_filter = json_encode($dataFilters); /* Set Filters */

        //Set Field Data
        $column_data = strtolower($this->CoreForm->get_column_name($Module,'data'));
        $updateData[$column_data] = json_encode($updateData); //Set Data

        //Prepaire Data To Store
        foreach ($updateData as $key => $value) {
          if ($key !== $column_data) {
            $children[$key] = $value;
            $updateData = $this->CoreCrud->unsetData($updateData,array($key)); //Unset Data
          }
        }

        //Set Filters
        $updateData[$column_filters] = $tempo_filter; /* Set Filters */

        //Details Column Update
        $details = strtolower($this->CoreForm->get_column_name('field','details'));
        $current_details = json_decode($resultList[0]->details, true);

        //Check Unset Key
        if (strtolower($unsetKey) == 'before') {
            $updateData = $this->CoreCrud->unsetData($updateData,$unsetData); //Unset Data
            foreach ($updateData as $key => $value) { $current_details["$key"] = $value; /* Update -> Details */ }
            $updateData["$details"] = json_encode($current_details);
        }else{
            foreach ($updateData as $key => $value) { $current_details["$key"] = $value; /* Update -> Details */ }
            $updateData["$details"] = json_encode($current_details);
            $updateData = $this->CoreCrud->unsetData($updateData,$unsetData); //Unset Data
        }

        //Update Data
        return $updateData;
    }

    /*
    * 
    * This function will apply stamp | default | flg
    *
    * This function accept 
    * 1: Current Form Data
    * 2: Reserved Form Data
    * 3: Module affeted => By Defult is 'field'
    *
    */
    public function applyCheckFieldTable($formData,$formCheck,$Module='field')
    {

        //Columns
        $stamp_column = strtolower($this->CoreForm->get_column_name($Module,'stamp'));
        $default_column = strtolower($this->CoreForm->get_column_name($Module,'default'));
        $flg_column = strtolower($this->CoreForm->get_column_name($Module,'flg'));

        //Check Stamp
        $stamp = (array_key_exists('stamp', $formCheck))? $formCheck['stamp'] : null;
        $stamp = (array_key_exists($stamp_column, $formCheck))? $formCheck[$stamp_column] : $stamp;
        $formData[$stamp_column] = $stamp;

        //Check Default
        $default = (array_key_exists('default', $formCheck))? $formCheck['default'] : null;
        $default = (array_key_exists($default_column, $formCheck))? $formCheck[$default_column] : $default;
        $formData[$default_column] = $default;

        //Check Flg
        $flg = (array_key_exists('flg', $formCheck))? $formCheck['flg'] : null;
        $flg = (array_key_exists($flg_column, $formCheck))? $formCheck[$flg_column] : $flg;
        $formData[$flg_column] = $flg;



        //Remove Null Values
        foreach ($formData as $key => $value) {
            $formData = (is_null($value)) ? $this->CoreCrud->unsetData($formData,array($key)) : $formData;
        }

        //Return Data
        return $formData;
    }

    /*
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
    public function getFieldFormatData($formData,$fieldSet,$unsetData=null,$unsetKey='before')
    {

        //FormData
        $formData = $this->saveFormField($formData,$fieldSet);
        return $formData; //Return Data
    }

    /*
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
    public function getFieldUpdateData($updateData,$fieldSet,$unsetData=null,$unsetKey='before')
    {

        //FormData
        $updateData = $this->updateFormField($updateData,$fieldSet);
        return $updateData; //Return Data
    }

    /*
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
    public function checkKeyExist($key,$array=null)
    {

        //By Default - Not Found
        $found = false;

        //Check Array Data
        $arrayData = (!is_null($array))? $array : $this->session->arrayData;

        //Check Passed Data
        if (count($arrayData) > 0) {
            //If Key Is not array
            if (!is_array($key)) {
                $keyData = explode(',',$key);
            }

            //Check Data
            for ($i=0; $i < count($keyData); $i++) { 
                $currentKey = $keyData[0];
                if (array_key_exists($currentKey,$arrayData)) {
                    $found[$currentKey] = true; //Found
                }else{
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

    /*
    *
    * This function checks if directory/file exists
    * 1: Pass dir/file full path/ path & name | as required by Core Lite
    * 2: Create dir/file (By default dir/file will be created)
    * 3: Permission By default is 0755
    *
    * NB:
    * You can override this by creating function dirCreate() in CoreField
    * -> This will return false if director do not exist
    * -> Also you can overide permission form 0755
    *
    * --> By default dir will be created hence returned TRUE
    * 
    */
    public function checkDir($path,$create=true,$defaultpath='../assets/media',$permission=0755,$recursive=true)
    {
        //load ModelField
        $this->load->model('CoreField');  

        //Folder Path
        $pathFolder = realpath(APPPATH . $defaultpath); //Real Path
        $newDirectory = $pathFolder.$path;// New Path | New APPATH Directory

        //Check Additonal Config
        if (method_exists('CoreField', 'changeDirData')) {
            //Config
            $configDir = $this->CoreField->changeDirData($newDirectory,$permission,$recursive);
            $newDirectory = $configDir['dir']; // New Path | New APPATH Directory
            $permission = $configDir['permission']; //Deafault
            $recursive = $configDir['recursive']; //Deafult
        }

        //Check Dir/File 
        if (!file_exists($newDirectory)) {
            if ($create) {
                mkdir($newDirectory, $permission, $recursive); // Create Directory
                $status = true;// //Folder or file created
            }else{
                $status = false;// Folder or file could not be created
            }
        }else{
            $status = true;// //Folder or file exist
        }

        return $status; //Return Status
    }

    /*
    *
    * Get Parent Children
    * Pass Parent Element ID
    * 
    */
    public function childTreee($parent_id=0,$sub_mark='',$selectedID=null,$type=null)
    {

        //load ModelField
        if (is_null($type)) {
            $this->load->model('CoreField');  
            $setChildTree = ((method_exists('CoreField', 'setChildTree')))? $this->CoreField->setChildTree(): false;

            //Set Type
            $type = (!setChildTree)?'category' : $setChildTree;
        }

        //Select Data
        $inheritance = $this->CoreCrud->selectInheritanceItem(array('parent' =>$parent_id,'flg'=>1,'type'=>$type)
            ,'id,parent,title');

        // Check IF Result Found
        if (count($inheritance) > 0) {
            for ($i=0; $i < count($inheritance); $i++) { 
                $parent = $inheritance[$i]->inheritance_parent; //Parent
                $title = $inheritance[$i]->inheritance_title; //Title
                $id = $inheritance[$i]->inheritance_id; //Id

                //Echo Data
                if ($selectedID == $id) {
                    echo "<option class='$id' value='$id' selected>";
                        echo $sub_mark.ucwords($title);
                    echo "</option>";
                }else{
                    echo "<option class='$id' value='$id'>";
                        echo $sub_mark.ucwords($title);
                    echo "</option>";
                }

                //Check More Child
                return $this->childTreee($id,$sub_mark='---',$selectedID);
            }
        }
    }

    /*
    *
    * Get Element Parent ID
    *
    * Pass elementID and it will return it's Parent ID
    * 
    */
    public function getParentInheritance($inheritanceID,$parentID=0)
    {
        //Select Parent
        $parent = $this->CoreCrud->selectSingleValue('inheritances','parent',array('id'=>$inheritanceID));

        //Check If is Parent
        if ($parent == $parentID) {
            return $inheritanceID; //Parent Value
        }else{
            return $this->getParentInheritance($parent); //Find Parent
        }
    }

    /*
    *
    * Email
    * Get email data & configuration
    * 
    */
    public function email_config()
    {
        //Get Send Data
        $settings['mail_protocol'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'mail_protocol'));
        $settings['smtp_host'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_host'));
        $settings['smtp_user'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_user'));
        $settings['smtp_pass'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_pass'));
        $settings['smtp_port'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_port'));
        $settings['smtp_timeout'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_timeout'));
        $settings['smtp_crypto'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'smtp_crypto'));
        $settings['wordwrap'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'wordwrap'));
        $settings['wrapchars'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'wrapchars'));
        $settings['mailtype'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'mailtype'));
        $settings['charset'] = $this->CoreCrud->selectSingleValue('settings','value',array('title'=>'charset'));

        //load ModelField
        $this->load->model('CoreField');  
        $emailConfig = ((method_exists('CoreField', 'emailConfig')))? $this->CoreField->emailConfig(): false;

        //Configs
        if ($emailConfig) {
            foreach ($emailConfig as $key => $value) {
              $settings[$key] = $value; //Settings
            }
        }

        //Check For Null Values
        foreach ($settings as $key => $value) {
            if (is_null($value) || empty($value)) {
                $this->CoreCrud->unsetData($settings,array($key));
            }else{
                $config[$key] = $value; //Clean Values
            }
        }

        return $config; //Return Configs
    }

    /*
    *
    * This function help user to access / get account profile picture
    * Account Profile
    */
    public function accountProfile($useraccount=null,$profile_name='user_profile')
    {
        //Check Account
        $account = (is_null($useraccount)) ? array('id'=>$this->CoreLoad->session('id')) : $useraccount;
        //User Details
        $userDetails = json_decode($this->CoreCrud->selectSingleValue('user','details',$account), True); 
        $profile = (array_key_exists($profile_name, $userDetails))? json_decode($userDetails[$profile_name]) : array(null);

        //Check Found
        $profile = (!is_null($profile[0]) && !empty($profile[0]))? $profile[0] : null;
        $userProfile[$profile_name] = $profile; //Profile

        //Return Data
        return $userProfile;
    }

    /*
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
    public function getfileName($assetLink,$ext=true,$separator='/')
    {
        //Change link to array
        $file_link = (!is_array($assetLink))? explode($separator,$assetLink) : $assetLink;

        //Get end of array
        $file_full = end($file_link);
        if (!$ext) {
            $get = explode('.', $file_full);
            $file_name = $get[0];
        }else{
            $file_name = $file_full;
        }

        //File Name
        return $file_name;
    }

    /*
    *
    * This function is a subfunction of getting file name, this function will only retur extension of the file
    *
    * 1: Pass file line
    * 2: State if you want extension returned of not | Default 'True'
    * 3: Pass file separator value | Default '/'
    *
    * Get File Extension Only
    */
    public function getfileExt($assetLink,$file=false,$separator='/')
    {
        //Get File Name
        $file_name = (!$file) ? $this->getfileName($assetLink,true,$separator) : $assetLink;

        //Get Extension
        $get = explode('.', $file_name);
        $extension = end($get);

        //File Extension
        return $extension;
    }

    /*
    *
    * This function help you to get filter table columns ready to match filter custom field values
    *
    * 1: Pass customfield title/id
    * 2: Pass Addirional Columns (as array or as comma separated string)
    * 3: Pass escaped values (Values you wish system to handle ot it's own) | id,details,stamp,default,flg
    *
    * Get Filter Tables
    */
    public function getFilterColumns($titleID,$pusharray=null,$escaped_columns=array('id','details','stamp','default','flg'))
    {

        // Get Custom Field Title
        if (is_numeric($titleID)) {
            $titleID = $this->CoreCrud->selectSingleValue('customfields','title',array('id'=>$titleID)); // Main Site URL
        }
        $tableName = $this->plural->pluralize($titleID);

        $table_desc = $this->CoreForm->get_column_data($tableName);
        $columns = $this->CoreForm->get_column_name_type($table_desc);

        // Escape Columns
        if (!is_null($escaped_columns)) {
            for ($i=0; $i < count($escaped_columns); $i++) {
                $escape = $escaped_columns[$i];

                // Columns Name
                $column_escape = strtolower($this->CoreForm->get_column_name($tableName,$escape));
                if (in_array($column_escape,$columns)) {
                    $key = array_search ($column_escape, $columns);
                    $columns = $this->CoreCrud->unsetData($columns,$key); //Unset Data
                }
            }
            // Set Array
            $columns = array_values($columns);
        }        

        // Get Labels
        $filter_columns_name = $this->CoreForm->get_label_name($columns);

        // Push Columns
        if (!is_null($pusharray)) {
            if (!is_array($pusharray)) {
                $pusharray = explode(',',$pusharray);
            }
            for ($i=0; $i < count($pusharray); $i++) { 
                array_push($filter_columns_name,$pusharray[$i]);
            }
        }

        // Return Columns
        return $filter_columns_name;
    }

    /*
    * This functions takes your custom filter data and assign them to insert array 
    *
    * 1: Pass Filter Columns
    * 2: Pass Insert Data
    *
    */
    public function fieldFiltered($columns,$data)
    {

        // Decode Filter Data
        $filter_data = json_decode($data, True);

        // Insert Data
        $insertData = null;

        // Columns
        for ($i=0; $i < count($columns); $i++) { 
            $key = strtolower($columns[$i]);
            if (array_key_exists($key,$filter_data)) {
                $insertData[$key] = $filter_data[$key];
            }
        }

        // Return
        return $insertData;
    }
}

/* End of file CoreForm.php */
/* Location: ./application/models/CoreForm.php */