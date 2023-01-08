<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CoreLoad extends CI_Model
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
		$this->load->model('CoreField');
		$this->load->model('CoreCrud');
		$this->load->model('CoreTrigger');

		// Your own constructor code 

	}

	/**
	 *
	 * This function is used to load all data requred to be present for the system/website to operate well
	 * E.g Site Menu, Meta Data e.t.c
	 * All values are return as one array (data)
	 * 
	 */
	public function load()
	{

		//Loading Core CMS Version
		$data['version'] = '5.51';
		$data['copyright_footer_1'] = "v" . $data['version'];
		$data['copyright_footer_2'] = "Published 08-JAN-2023";

		//Values Assets
		$data['assets'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'assets', 'flg' => 1));
		$data['ext_dir'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'ext_dir', 'flg' => 1));
		$data['ext_assets'] = $this->ext_asset();

		//Theme Assets
		$data['theme_name'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'theme_name', 'flg' => 1));
		$data['theme_dir'] = 'themes/'.$data['theme_name'];
		$data['theme_assets'] = 'application/views/'.$data['theme_dir'];


		//Site Title
		$data['site_title'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'site_title', 'flg' => 1));
		$data['description'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'seo_description', 'flg' => 1));
		$data['keywords'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'seo_keywords', 'flg' => 1));
		$data['site_robots'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'seo_visibility', 'flg' => 1));
		$data['site_global'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'seo_global', 'flg' => 1));
		$data['seo_data'] = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'seo_meta_data', 'flg' => 1));

		//Load Custom Data
		$customData = $this->CoreField->load();
		$data = array_merge($data, $customData);

		//returned DATA
		return $data;
	}

	/**
	 *
	 * This function help the system to load the values needed for a particular page to oparate
	 * Thing like page articles, page templates etc are loaded here
	 * It accept value page ID/ page Template (if you do not wish to load other page assest)
	 * Pass passed data to be merged
	 */
	public function open($pageSET = null, $passed = array())
	{

		//Call Requred Site Data
		$data = $this->load();

		//Page Name
		$data['site_page'] = $pageSET;

		//Merge Data
		foreach ($passed as $key => $value) {
			$data[$key] = $value;
		}

		//returned DATA
		return $data;
	}

	/**
	 *
	 * This Function is for checking if the system is set to be online.
	 * When this function is called it will check if site_status on settings table is set to be online
	 * if is online it will return TRUE else it will return FALSE
	 * 
	 */
	public function site_status()
	{
		//Site Status
		$status = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'site_status', 'flg' => 1));

		//Check if is online
		if (strtolower($status) == 'online') {
			return TRUE; //Site is online
		} else {
			return FALSE; //Site is offline
		}
	}

	/**
	 * This function allow user to generate random string or integer to be used as unique ID
	 * The function accept variable lenght as integer 
	 *  -- This variable set the lenght of your random string or variable, by default is set to 4
	 *
	 * The second parameter is values to be used to generate the random string au integer
	 * E.g If you pass '12345' the random integer will be generated from randomized number 1 2 3 4 5  
	 *     If you do not pass anything here we advise you only do this when generating password
	 */
	public function random($length = 4, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ{[}}-+*#')
	{

		//Generate Random String
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		return $randomString; // Return Random String
	}

	/**
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
	public function input($value = null, $rule = 'post')
	{
		//Set the rule to lower string
		$rule = strtolower($rule);
		//Input Value
		if (is_null($value)) {
			//Check the whole Post/Get Array
			$input = $this->db->escape_str($this->input->$rule());
		} else {
			//Check specific value in Post/Get Array
			$input = $this->db->escape_str($this->input->$rule($value));
		}
		//returned DATA
		return $input;
	}


	/**
	 *
	 *  This is function to help get corret URL
	 *  N:B site_url and base_url can do simillar thing
	 * 
	 */
	public function siteURL($url = null)
	{

		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$domainName = $_SERVER['HTTP_HOST'] . '/';

		//returned DATA
		return $protocol . $domainName . $url;
	}

	/**
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
	 *              by default the level is accessed by the system via user logged session data $this->CoreLoad->session('level') so it's not must you pass the user level
	 *
	 *   -> If user hasn't logged in it will return FALSE
	 *   -> If user access level doesn't allow him/her to access the Module it will break the process and oped Access Not Allowed Page
	 *
	 *   -> If all permission are true/valid it will return TRUE
	 * 
	 */
	public function auth($module, $level = null)
	{
		//Check If Loged In
		if ($this->CoreLoad->session('logged')) {
			$level = (is_null($level)) ? $this->CoreLoad->session('level') : $level; //Access Level	

			$module = $this->plural->singularize($module); //Module Name
			$modules_list = $this->CoreCrud->selectSingleValue('levels', 'module', array('name' => $level, 'flg' => 1)); //Module List
			$modules = explode(",", strtolower($modules_list)); //Allowed Modules

			if (in_array(strtolower($module), $modules)) {
				return true; //Auth Allowed
			} elseif (strtolower($level) == 'superadmin') {
				return true; //Auth Allowed
			} else {
				return false; //Auth Not Allowed
			}
		} else {
			// Check Cookie
			if (!$this->CoreLoad->logged()) {
				if ($this->CoreLoad->authCookie()) {
					redirect(uri_string(), 'refresh');
				} else {
					return false; //User Not Logged In
				}
			} else {
				return false; //Auth Not Allowed
			}
		}
	}

	/**
	 *
	 * This function help to log user back by checking if cookie is available
	 * 	By default cookie name is 'logged'
	 *
	 *	If you wish to change just use custom filed
	 *	add function setCookie and setup array like
	 *
        // CookieSetup
        $cookie = array(
            'status' => true,
            'name' => 'remember'
        );

        // Check
        return (array_key_exists($name,$cookie)) ? $cookie[$name] : false;
	 * 
	 * 
	 */
	public function authCookie()
	{

		// CookieName
		$cookie_name = ((method_exists('CoreTrigger', 'setCookie'))) ? $this->CoreTrigger->setCookie('name') : 'logged';

		// Check Cookie
		$cookie_value = $this->cookie($cookie_name);
		if (!is_null($cookie_value)) {

			//Pluralize Module
			$tableName = $this->plural->pluralize('user');
			$column_id = $this->CoreForm->get_column_name($tableName, 'id'); //ID Column
			$column_logname = $this->CoreForm->get_column_name($tableName, 'logname'); //Logname Column
			$column_password = $this->CoreForm->get_column_name($tableName, 'password'); //Password Column
			$column_stamp = $this->CoreForm->get_column_name($tableName, 'stamp'); //Stamp Column
			$column_level = $this->CoreForm->get_column_name($tableName, 'level'); //Stamp Level
			$column_flg = $this->CoreForm->get_column_name($tableName, 'flg'); //Stamp FLG

			// Check User Account
			if ($this->db->select($column_flg)->where($column_id, $cookie_value)->get($tableName)->row()->$column_flg) {
				$where = array($column_id => $cookie_value); // Where Clause
				$query = $this->db->select("$column_id, $column_level")->where($where)->limit(1)->get($tableName)->result(); //Set Query Select

				if ($query) {

					//Session ID
					$session_id = $this->sessionName('id');
					$newsession[$session_id] = $query[0]->$column_id;

					//Session LEVEL
					$session_level = $this->sessionName('level');
					$newsession[$session_level] = $query[0]->$column_level;

					//Session LOGGED
					$session_logged = $this->sessionName('logged');
					$newsession[$session_logged] = TRUE;

					$this->session->set_userdata($newsession); //Create Session

					// Return 
					return true;
				}
			}
		}

		// If Failes any where
		return false;
	}

	/**
	 *
	 * This function is a substute to AUTH
	 * The function checks if user has logged in Only
	 * The function should only be used to the pages that does not require access level
	 *
	 * Remember you can do this direct by just checking with if statement $this->CoreLoad->session('logged')
	 * This function does not accept paramenters
	 * 
	 */
	public function logged()
	{
		//Check If Logged In
		if ($this->CoreLoad->session('logged')) {
			return $this->CoreLoad->session('id'); //Session ID
		} else {
			return false; //Not logged In
		}
	}

	/**
	 *
	 * This function is a substute to AUTH
	 * The function checks if user access level Only
	 * The function should only be used to the pages that require access level
	 *
	 * Remember you can do this direct by just checking with if statement $this->CoreLoad->session('level')
	 * 
	 * 1: Pass Level/Access Name (Optional)
	 */
	public function level($access = null)
	{
		//Check If Logged In
		if ($this->CoreLoad->session('level')) {
			// Check Access
			if (is_null($access)) {
				return $this->CoreLoad->session('level'); //Session Level
			} else {
				if ($this->CoreLoad->session('level') == strtolower(trim($access))) {
					return true; //Access Allowed
				} else {
					return false; //Access Not Allowed
				}
			}
		} else {
			return false; //Not logged In
		}
	}

	/**
	 *
	 * Set session name
	 * -> This function used to generate session names
	 * 1: Pass name of the session you wish to generate
	 * 2: Pass Optional custom prefix
	 */
	public function sessionName($name, $prefix = null)
	{

		//Check if prefix is given
		$prefix = (is_null($prefix)) ? $this->CoreCrud->selectSingleValue('setting', 'value', array('title' => 'session_key', 'flg' => 1)) : $prefix;
		$prefix = substr(preg_replace("/[^ \w-]/", "", stripcslashes($prefix)), 0, 10);
		$prefix = str_replace(" ", "", trim($prefix));

		//Return Session Name
		$session = $prefix . "_" . $name;
		return $session;
	}

	/**
	 *
	 *
	 * This Function help you to get Session Value
	 * 1:Pass session name
	 * Return Session Value
	 */
	public function session($session)
	{
		//Get Session Full Name
		$name = $this->sessionName($session);
		return $this->session->$name;
	}

	/**
	 *
	 * Set cookie name
	 * -> This function used to generate cookie names
	 * 1: Pass name of the cookie you wish to generate
	 * 2: Pass Optional custom prefix
	 */
	public function getCookieName($name = 'logged', $prefix = null)
	{
		// Security Helper
		$this->load->helper('security');

		// CookieName
		if ($name == 'logged') {
			$cookie_name = ((method_exists('CoreTrigger', 'setCookie'))) ? $this->CoreTrigger->setCookie('name') : 'logged';
			$name = (!is_null($cookie_name) && $cookie_name != false) ? $cookie_name : $name;
		}

		//Check if prefix is given
		$prefix = (is_null($prefix)) ? $this->CoreCrud->selectSingleValue('setting', 'value', array('title' => 'session_key', 'flg' => 1)) : $prefix;
		$prefix = substr(preg_replace("/[^ \w-]/", "", stripcslashes($prefix)), 0, 10);
		$prefix = str_replace(" ", "", trim($prefix));

		//Return Cookie Name
		$cookie_name = $prefix . "_" . $name;
		$cookie = do_hash($cookie_name);

		return $cookie;
	}

	/**
	 *
	 *
	 * This Function help you to get cookie Value
	 * 1:Pass cookie name
	 * Return cookie Value
	 */
	public function cookie($cookie = 'logged')
	{
		// Encryption Library
		$this->load->library('encryption');
		$this->load->helper('cookie');
		$cookie_value = null;

		//Get Cookie Full Name
		$name = $this->getCookieName($cookie);
		$value = get_cookie($name);
		if (!empty($value) && !is_null($value)) {
			$cookie_value = $this->encryption->decrypt($value);
		}

		return $cookie_value;
	}

	/**
	 *
	 * Get Domain Name
	 * Fore Cookie USE
	 * 
	 */
	public function getDomainName($url = null, $return = 'host')
	{
		//URL
		$url = (is_null($url) || empty($url)) ? base_url() : $url;
		$url = parse_url($url); //Base URL

		$host_path['host'] = str_replace('www.', '', $url['host']); //Host

		$path = (array_key_exists('path', $url)) ? $url['path'] : ''; //Get Path
		$path = (substr($path, -1) == '/') ? substr_replace($path, "", -1) : $path; //Remove last '/' from string

		$host_path['path'] = $path; //Get Path

		return ($return == 'all') ? $host_path : $host_path[$return]; //Return Data
	}

	/**
	 * 
	 * This are messages displayed when system/website is offline 
	 * 
	 */
	public function siteOffline()
	{
		//Offline Message
		$offlineMessage = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'offline_message', 'flg' => 1)); //Module List

		//Message
		$htmlDetails = htmlspecialchars_decode($offlineMessage);

		//Return
		echo $htmlDetails;
	}

	/**
	 *
	 * User access level is invalid E.g Client tries to access Administartor Page
	 * 
	 */
	public function notAllowed($error = null)
	{

		//Return
		redirect("not-allowed");
	}

	/**
	 *
	 * This Function is used to load Administrator Menus
	 * Pass menu type Eg. Extension,Control,Field or Menu
	 * It will look mached menu Category in Setting Table
	 * Kindly note set title as extension_menu and in value add JSON ARRAY {"menu_path":"pathfolder/pathfile"}
	 *
	 * If it wont find any menu it will retun null
	 * 
	 */
	public function menuLoad($loadMenu = null)
	{
		if (!is_null($loadMenu)) {
			$findMenu = $this->plural->singularize($loadMenu); //Make It Singular
			$findMenu = $findMenu . '_menu';

			$path = null;
			//Menu Found
			$foundMenu = $this->CoreCrud->selectMultipleValue('setting', 'value', array('title' => $findMenu, 'flg' => 1));
			for ($i = 0; $i < count($foundMenu); $i++) {
				$menuData = $foundMenu[$i]->setting_value; //Menu Data
				$menu = json_decode($menuData, True);

				if (array_key_exists('menu_path', $menu)) {
					$path[$i] = $menu['menu_path']; // Menu Path
				}
			}

			$path = (is_array($path) && count($path) > 0) ? array_values($path) : null;
			$menuLoaded = (!is_null($path)) ? $path : null;
		} else {
			$menuLoaded = null;
		}

		return $menuLoaded; //Return Menu Loaded
	}

	/**
	 * Quick get path to your  Extends Assests
	 * By Default path start by including Extend Folder and /customfields-or-extensions/filed-or-extension folername
	 * 
	 */
	public function ext_asset($type = '', $load = 'ext_assets')
	{
		// Extension Path
		$ext_path = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => $load, 'flg' => 1));
		$path = $ext_path . $type; //New Path

		return $path; //Return Path
	}

	/**
	 *
	 * Access ext_Assets and Return proper url path and URL
	 * Return URL
	 *
	 */
	public function loadAssets($ext, $type = 'extensions')
	{

		$load = "/$type/$ext"; //Load Path
		$asset = base_url($this->ext_asset($load));
		return $asset; //Return Aseets
	}

	/**
	 *
	 * Load Auto Complete, By default from autofields set
	 * 
	 * 1: Pass where condintion as an array('column'=>value)
	 * 2: What to return (from the json data), set null for all
	 * 3: Pass table name by default autofields
	 * 4: Which column to select by default is 'data'
	 *
	 * Return value as array
	 */
	public function autoData($where, $return = null, $table = 'autofields', $select = 'data')
	{
		//load Ext
		return $this->extData($where, $return, $table, $select);
	}

	/**
	 *
	 * Load EXT Data, By default from settings set
	 * 
	 * 1: Pass where condintion as an array('column'=>value)
	 * 2: What to return (from the json data), set null for all
	 * 3: Pass table name by default settings
	 * 4: Which column to select by default is 'value'
	 *
	 * Return value as array
	 */
	public function extData($where, $return = null, $table = 'settings', $select = 'value')
	{

		$data = null; //Storage
		if (is_array($where)) {
			$extseo = $this->CoreCrud->selectSingleValue($table, $select, $where); // Select Ext SEO
			//Check Selected
			if (!is_null($extseo) && !empty($extseo)) {
				$extseo_array = json_decode($extseo, True);
				if (is_array($extseo_array)) {
					if (!is_null($return)) {
						if (array_key_exists($return, $extseo_array)) {
							$data[$return] = $extseo_array[$return];
						}
					} else {
						foreach ($extseo_array as $key => $value) {
							$data[$key] = $value;
						}
					}
				}
			}
		}

		//Return Data
		return (!is_null($data) && is_array($data)) ? $data : null;
	}

	/**
	 * loadAutoData | QuickLoadData in Json-format
	 *
	 * Pass
	 * 1: Where condition, for sql search in autofields | array('title'=>'auto_field','flg'=>1)
	 * 2: Pass (optional. By default all key will be returned) what to be returned by it's key(label name) | add_item_1
	 * 3: Pass table name (optional) | by default 'autofields'
	 * 4: Pass column name to select from (optional) | By default 'data' column will be selected
	 * 
	 */
	public function loadAutoData($where, $return = null, $table = 'autofields', $select = 'data')
	{
		//Return Data Found
		return $this->CoreCrud->loadJsonData($where, $return, $table, $select);
	}

	/**
	 * Meta :-> meat_url
	 *
	 * meat_url has been more common than $this->CoreForm->metaFindUrl, we advice you use $this->CoreForm->metaFindUrl over meat_url
	 *
	 * However for popular demand we have added support for meat_url
	 * - To understand what this method do kindly check $this->CoreForm->metaFindUrl()
	 * - They are smae methods doing same thing.
	 * 
	 */
	public function meat_url($typeid, $module = null, $type = null)
	{
		// Return
		return $this->CoreForm->metaFindUrl($typeid, $module, $type);
	}
}

/** End of file CoreLoad.php */
/** Location: ./application/models/CoreLoad.php */
