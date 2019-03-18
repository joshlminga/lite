<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreCrud extends CI_Model {

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
  * Set Where clause
  * 1: Pass Module Name 
  * 2: Where clause values as Array
  */
 	public function set_whereCRUD($module,$where)
 	{

  	$module = $this->plural->singularize($module); //Make Sure Module Is Singular

  	foreach ($where as $key => $value) {
  		//Set Clomun names
  		$column = $module.'_'.$key;
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
 	public function set_selectCRUD($module,$column)
 	{

    $module = $this->plural->singularize($module); //Make Sure Module Is Singular

    //Get Array
    $column = explode(',',$column[0]);

  	$i = 0; // Set Array Counter
  	foreach ($column as $key) {

  		//Check If Column Requested As
  		if (strpos(strtolower($key), 'as') !== false) {

  			$exploded = explode("as",strtolower($key)); //Get Column name in Key 0 and As value Name in Key 1

  			$column_name = $module.'_'.$exploded[0];//Set Column name
  			$columns[$i] = $column_name.'AS'.$exploded[1];//Set Column name as
  		}else{
  			
  			$columns[$i] = $module.'_'.$key;//Set Clomun names
  		}
  		$i++;//Count
    }

  	//Return The Array
  	return implode(',',$columns);
 	}

  /*
  * Use this function to select datble values from the database
  * Select function accept 
  * 1: Module name pluralized to match Table Name
  * 2: Clause (You can Pass Null to get all)
  * 3: what to select (You can Pass Null to get any)
  */
 	public function selectCRUD($module,$where=null,$select=null,$clause='where')
 	{
	
  	$module = $this->plural->singularize($module); //Make Sure Module Is Singular
   		
 		//Get Table Name
 		$table = $this->plural->pluralize($module);

 		if (!is_null($select)) {

 			$columns = $this->set_selectCRUD($module,$select);
      $this->db->select($columns);
 		}
  	if (!is_null($where)) {	

  		$where = $this->set_whereCRUD($module,$where);
  		$this->db->$clause($where);
  	}

  	$this->db->from($table);
  	$query = $this->db->get();

  	return $query->result();
  }

  /*
  *
  * Upload File Data
  * -> Pass Input Name
  * -> Pass Input Location (Upload location)
  * 
  */
  public function upload($inputName,$location,$rule='jpg|jpeg|png',$link=true)
  {

    //Upload Data
    $uploaded = $this->uploadFile($_FILES[$inputName],$rule,$location,$link);
    if (!is_null($uploaded)) {
      $file_link = json_encode($uploaded, true);
    }else{
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
  public function uploadFile($input=null,$valid='jpg|jpeg|png|doc|docx|pdf|xls|txt',$file='../assets/admin/images/upload',$link=false)
  {
    
    //Library
    $this->load->library('upload');

    if (!is_null($input)) {

      //Upload        
      $config['upload_path'] = realpath(APPPATH . $file);
      $config['allowed_types'] = $valid;
      // $config['max_size'] = 500;
      $config['encrypt_name'] = TRUE;

      $this->upload->initialize($config);

      $key = 0;
      for($i = 0; $i < count($input['name']); $i++){

        $_FILES['photo']['name']     = $input['name'][$i];
        $_FILES['photo']['type']     = $input['type'][$i];
        $_FILES['photo']['tmp_name'] = $input['tmp_name'][$i];
        $_FILES['photo']['error']     = $input['error'][$i];
        $_FILES['photo']['size']     = $input['size'][$i];


        if ($this->upload->do_upload('photo')) {
          $data_upload = array('upload_data' => $this->upload->data());
          //Uploaded
          $file_name = $data_upload['upload_data']['file_name'];
          if ($link == true) {
            $file_uploaded[$key] = trim(str_replace("../", " ",trim($file)).'/'.$file_name);
            $key++;
          }else{
            $file_uploaded[$key] = $file_name;
            $key++;
          }
        }else{
            $file_uploaded[$key] = null;
        }
      }
      return $file_uploaded;
    }else{

      return null;
    }
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
    $file = "../".$path;

    //Base FIle URL
    $realpath = realpath(APPPATH . $file);

    //Check If File Exist
    if (file_exists($realpath)) {
      //Delete FIle
      unlink($realpath);
    }
  }

  /*
  *
  * Generate Url From Title
  * 
  */
  public function postURL($postID,$currURL=null,$module='page')
  {

    //Modules
    $module = $this->plural->singularize($module);
    $table = $this->plural->pluralize($module);

    //Columns
    $page_column_id = $module."_id";
    $page_column_title = $module."_title";
    $page_column_createdat = $module."_createdat";
    $page_column_url = $module."_url";

    //Select Post
    $postTitle = $this->db->select("$page_column_id,$page_column_title")->where("$page_column_id",$postID)
                          ->order_by("$page_column_createdat desc")->limit(1)->get("$table");
    $postData = $postTitle->result();

    //Url Format
    $current_url = $this->db->select('setting_value')->where('setting_title','current_url')->get('settings')->row()->setting_value;

    if (strtolower($current_url) == 'title') {

      if (!is_null($currURL)) {
          $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($currURL)),0, 50);
      }else{
        $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($postData[0]->$page_column_title)),0, 50);
      }
      
      $url = str_replace(" ", "-",strtolower(trim($post_url)));
      $ExistingURL = $this->db->select("$page_column_url")->like("$page_column_url",$url,"both")
                            ->order_by("$page_column_createdat desc")->limit(1)->get("$table");
      $URL = $ExistingURL->result();
      if (!empty($URL)) {
        $post_url = $url.'-'.$postData[0]->page_id;
      }else{
        $post_url = $url;
      }    
    }
    elseif (strtolower($current_url) == 'get') {
      if (!is_null($currURL)) {
          $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($currURL)),0, 50);
      }else{
        $post_url = substr(preg_replace("/[^ \w-]/", "", stripcslashes($postData[0]->page_title)),0, 50);
      }
      
      $url = str_replace(" ", "-",strtolower(trim($post_url)));
      $ExistingURL = $this->db->select("$page_column_url")->like("$page_column_url",$url,"both")
                            ->order_by("$page_column_createdat desc")->limit(1)->get("$table");
      $URL = $ExistingURL->result();
      if (!empty($URL)) {
        $post_url = '?p='.$url.'-'.$postData[0]->$page_column_id;
      }else{
        $post_url = '?p='.$url;
      }    
    }else{
        $post_url = $postData[0]->$page_column_id;
    }

    return $post_url;
  }

  /*
  *
  * Check If Same URL Exist 
  */
  public function checkURL($currURL,$currPOST,$module='page')
  {

    //Modules
    $module = $this->plural->singularize($module);
    $table = $this->plural->pluralize($module);

    //Columns
    $page_column_id = $module."_id";
    $page_column_title = $module."_title";
    $page_column_createdat = $module."_createdat";
    $page_column_url = $module."_url";

    $ExistingURL = $this->db->select("$page_column_id,$page_column_title,$page_column_url")->where("$page_column_id",$currPOST)
                          ->order_by("$page_column_createdat desc")->limit(1)->get("$table");
    $URL = $ExistingURL->result();
    if ($URL[0]->$page_column_url == $currURL) {
      return $currURL;
    }else{
      return $this->postURL($URL[0]->$page_column_id,$currURL);
    }
  }


}

/* End of file CoreCrud.php */
/* Location: ./application/models/CoreCrud.php */