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
}

/* End of file CoreCrud.php */
/* Location: ./application/models/CoreCrud.php */