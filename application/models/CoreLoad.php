<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreLoad extends CI_Model {

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
    * This function is used to load all data requred to be present for the system/website to oparate well
    * E.g Site Menu, Meta Data e.t.c
    * All values are return as one array (data)
    * 
    */
    public function load()
    {
    	//Values Assets
		$data['assets'] = 'assets/admin';
		$data['extension_dir'] = 'application/views/extensions/';

		//Site Title
		$data['site_title'] = $this->db->select('setting_value')->where('setting_title','site_title')->where('setting_default','yes')
		->where('setting_flg',1)->get('settings')->row()->setting_value;

		$data['description'] = $this->db->select('setting_value')->where('setting_title','seo_description')->where('setting_default','yes')
		->where('setting_flg',1)->get('settings')->row()->setting_value;
		$data['keywords'] = $this->db->select('setting_value')->where('setting_title','seo_keywords')->where('setting_default','yes')
		->where('setting_flg',1)->get('settings')->row()->setting_value;
		$data['seo_data'] = $this->db->select('setting_value')->where('setting_title','seo_meta_data')->where('setting_default','yes')
		->where('setting_flg',1)->get('settings')->row()->setting_value;

   		//returned DATA
    	return $data;
    }

    /*
    *
    * This function help the system to load the values needed for a particular page to oparate
    * Thing like page articles, page templates etc are loaded here
    * It accept value page ID/ page Template (if you do not wish to load other page assest)
    * 
    */
   	public function open($pageSET=null)
   	{

		//Call Requred Site Data
		$data = $this->load();
   		//Check Page Type
   		if (is_numeric($pageSET)) {
	    	//Values
   		}else{
	    	//Page Name
	    	$data['site_page'] = $pageSET;
   		}
   		//returned DATA
   		return $data;
   	}

   	/*
   	*
   	* This Function is for checking if the system is set to be online.
   	* When this function is called it will check if site_status on settings table is set to be online
   	* if is online it will return TRUE else it will return FALSE
   	* 
   	*/
   	public function site_status()
   	{
   		//Site Status
		$status = $this->db->select('setting_value')->where('setting_title','site_status')->get('settings')->row()->setting_value;

		//Check if is online
		if (strtolower($status) == 'online') {
			return TRUE; //Site is online
		}else{
			return FALSE; //Site is offline
		}
   	}

    /*
    * This function allow user to generate random string or integer to be used as unique ID
    * The function accept variable lenght as integer 
    *  -- This variable set the lenght of your random string or variable, by default is set to 4
    *
    * The second parameter is values to be used to generate the random string au integer
    * E.g If you pass '12345' the random integer will be generated from randomized number 1 2 3 4 5  
    *     If you do not pass anything here we advise you only do this when generating password
    */
    public function random($length=4, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ{[}}-+*#')
    {
	    // $pieces = [];
	    // $max = mb_strlen($keyspace, '8bit') - 1;
	    // for ($i = 0; $i < $length; ++$i) {
	    //     $pieces []= $keyspace[random_int(0, $max)];
	    // }
   		// //returned DATA
	    // return implode('', $pieces);

		$min=0; $max=999; $quantity=2;

	    $numbers = range($min, $max);
	    shuffle($numbers);
	    $numbers1 = array_slice($numbers, 0, $quantity);

		$rand = implode("",$numbers1);

		return $rand;
    }

    /*
    *
    *  This function clean and return the inputs from your POST or Get request
    *  The function accept two parameters
    *  1: The value is the post data array you wish to get
    *     E.g <input name='firstName' value="">
    *         This form in Post or Get request it array Key name is firstName
    *         That is the $value to be passed |i.e $value = 'firstName';
    *
    *    If this is left as null or passed as null, the function will return all data inside your post/get request. 
    *    This is best if you want to store all data in one array or as JSON data later
    *
    *  2: the rule parameter is to determine if you want data from POST/GET value
    *  
    */
    public function input($value=null,$rule='post')
    {
    	//Set the rule to lower string
		$rule = strtolower($rule);
    	//Input Value
		if (is_null($value)) {
			//Check the whole Post/Get Array
			$input = $this->db->escape_str($this->input->$rule());
		}else{
			//Check specific value in Post/Get Array
			$input = $this->db->escape_str($this->input->$rule($value));
		}
   		//returned DATA
		return $input;
    }



    /*
    *
    *  This is function to help get corret URL
    *  N:B site_url and base_url can do simillar thing
    * 
    */
	public function siteURL($url=null) {

	    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";	    
	    $domainName = $_SERVER['HTTP_HOST'] . '/';

   		//returned DATA
	    return $protocol . $domainName.$url;
	}

	/*
	* This is Authentication Level Process
	* N:B we do not use this to authenticate user password or username if they are valid. For that is done by Authentication Model
	* 
	* -> This function accept module(array) : You can pass module allowed 
	* -> Second it accept level 
	*    N:B if the user has logged in you do not need to send the level (pass the level variable) in the function
	*        if user has not logged in you have to pass the level else the authentication will fail.
	*    The second value has to be a string e.g admin, client, report etc
	*
	*  How It Works
	*   -> Module : they are more like access level allowed to access the particluar modules
	*   -> level : the currect level of the user as in users(Table) - user_level(column)
	*              by default the level is accessed by the system via user logged session data $this->session->level so it's not must you pass the user level
	*
	*   -> If user hasn't logged in it will return FALSE
	*   -> If user access level doesn't allow him/her to access the Module it will break the process and oped Access Not Allowed Page
	*
	*   -> If all permission are true/valid it will return TRUE
	* 
	*/
	public function auth($module,$level=null)
	{
		//Check If Loged In
		if ($this->session->logged) {
			$level = (is_null($level))? $this->session->level : $level; //Access Level	

			$module = $this->plural->singularize($module); //Module Name
			$modules_list = $this->db->select('level_module')->where('level_name',$level)->get('levels')->row()->level_module; //Module List
			$modules = explode(",",strtolower($modules_list)); //Allowed Modules

			if (in_array(strtolower($module), $modules)) { 
				return true;//Auth Allowed
			}elseif (strtolower($level) == 'admin') {
				return true;//Auth Allowed
			}else{
				return false;//Auth Not Allowed
			}
		}else{
			return false;//User Not Logged In
		}
	}

	/*
	*
	* This function is a substute to AUTH
	* The function checks if user has logged in Only
	* The function should only be used to the pages that does not require access level
	*
	* Remember you can do this direct by just checking with if statement $this->session->logged
	* This function does not accept paramenters
	*/
	public function logged()
	{
		//Check If Logged In
		if ($this->session->logged) {
			return true; //Logged IN
		}else{
			return false; //Not logged In
		}
		
	}

	/*
	*
	* This function is a substute to AUTH
	* The function checks if user access level Only
	* The function should only be used to the pages that require access level
	*
	* Remember you can do this direct by just checking with if statement $this->session->level
	* This function does not accept paramenters
	*/
	public function level()
	{
		//Check If Logged In
		if ($this->session->level) {
			return true; //Logged IN
		}else{
			return false; //Not logged In
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
	public function unsetData($passedData,$unsetData=null)
	{
		if (!is_null($unsetData)) {

			//Unset Data
			for($i = 0; $i < count($unsetData); $i++){

				$unset = $unsetData[$i]; //Key Value To Remove
				
				unset($passedData["$unset"]); //Remove Item
			}

			return $passedData; //Remaining Data AFter Unset
		}
		else{
			return $passedData; //All Data Without Unset
		}
	}

	/*
	* 
	* This are messages displayed when system/website is offline 
	* 
	*/
	public function siteOffline()
	{
		//Offline Message
		$offlineMessage = $this->db->select('setting_value')->where('setting_title','offline_message')
		->get('settings')->row()->setting_value;

		//Message
		$htmlDetails = htmlspecialchars_decode($offlineMessage);

		//Return
		echo $htmlDetails; 
	}

	/*
	*
	* User access level is invalid E.g Client tries to access Administartor Page
	* 
	*/
	public function notAllowed($error=null)
	{
		//Quick Load
		$invalidAccessMessage = 'You are not allowed To Access This Page';

		//Message
		$htmlDetails = htmlspecialchars_decode($invalidAccessMessage);

		//Return
		redirect("CoreErrors/open");
		//echo $htmlDetails; 
	}

	/*
	*
	* Load Custom / Extension Styles Css
	* 
	*/
	public function load_style()
	{
		$style = array('/custom/custom.css'

		);

		return $style;
	}

	/*
	*
	* Load Custom / Extension Script Js 
	* 
	*/
	public function load_script()
	{
		$script = array('/custom/custom.js'

		);

		return $script;
	}

}

/* End of file CoreLoad.php */
/* Location: ./application/models/CoreLoad.php */