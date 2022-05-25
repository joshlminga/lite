<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiState extends CI_Model
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
	 * * Generate Method to Validate Token passed by API
	 * 1:Pass Token Value
	 * 2:Pass Extra value you wish to be returned [id as id, access as access] (optional | default = null) 
	 * 3: Pass Host name / Owner as optinal
	 * 
	 * Return token Id if token is valid and false is token is invalid
	 */
	public function validate($token, $select = null, $host = null)
	{
		//Check if token is valid
		$token_id = $this->tokenVerify($token, $host);
		// Check
		if ($token_id) {
			// Token Info
			if (!is_null($select)) {
				return $this->CoreCrud->selectMultipleValue('token', $select, ['id' => $token_id]);
			} else {
				return $token_id;
			}
		} else {
			// Token is invalid
			return false;
		}
	}

	/**
	 * * Generate/Request Token
	 * 1: Pass Settings as Array ( Optional ) | If You pass Int, it will be treated as Time 
	 * 2: Pass Time in seconds (Optional | default = null)
	 * 3: Pass Token Access Level (This is useful if the Token is to allow sensitive CRUD functinality)
	 */
	public function tokenGenerate($setting = array(), $time = null, $access = null)
	{

		// Security Helper
		$this->load->library('encryption');

		// Table
		$tableName =  $this->plural->pluralize('token');

		// Time
		(is_int($setting)) ? $time = $setting : $setting;
		$timeDB = $this->CoreCrud->selectSingleValue('setting', 'value', array('title' => 'token_time', 'flg' => 1));
		$timeDB = (!is_null($timeDB) && !empty($timeDB)) ? $timeDB : 300;
		$time = (!is_null($time) && !empty($time)) ? $time : $timeDB;

		// Token Date
		date_default_timezone_set('Africa/Nairobi');
		$created = date('Y-m-d H:i:s', time());
		$expiry = date('Y-m-d H:i:s', strtotime("+$time seconds", strtotime($created)));

		// Check Values in $setting
		$setting = (is_array($setting)) ? $setting : array();

		// Access (expirey updated after every usage of token) | session (expirey updated after every usage of token) | api (does not expire)
		$type = (array_key_exists('type', $setting)) ? $setting['type'] : 'session';
		$owner = (array_key_exists('owner', $setting)) ? $setting['owner'] : null;
		$access = (array_key_exists('access', $setting)) ? $access['access'] : $access;
		// Limit
		$limit = (array_key_exists('limit', $setting)) ? $setting['limit'] : 1;
		$limit = ($type == 'access' || $type == 'session') ? 1 : $limit;

		// Token Lenght
		$length = $this->CoreCrud->selectSingleValue('setting', 'value', array('title' => 'token_length'));
		$length = (array_key_exists('length', $setting)) ? $setting['length'] : $length;

		// Token
		$token = $this->CoreLoad->random($length, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		$token_value = $this->encryption->encrypt($token);
		// Expry
		$expiry = ($limit == 0 && $type == 'api') ? null : $expiry;

		// Data
		$insertData = array(
			'token_type' => $type,
			'token_key' => $token,
			'token_value' => $token_value,
			'token_owner' => $owner,
			'token_access' => $access,
			'token_limit' => $limit,
			'token_created' => $created,
			'token_expiry' => $expiry,
		);

		//Insert Data Into Table
		return ($this->db->insert($tableName, $insertData)) ? $token : null;
	}

	/**
	 * * Verify Token
	 * 1: Pass Token
	 * 2: Pass Token Owner (Optional) Default is null
	 */
	public function tokenVerify($token, $ownerInfo = null)
	{
		// Security Helper
		$this->load->library('encryption');

		// Table
		$tableName =  $this->plural->pluralize('token');
		$token_decrypt = null;

		// Check Token
		$token_id = $this->CoreCrud->selectSingleValue($tableName, 'id', array('key' => $token, 'flg' => 1));
		if ($token_id) {

			// Token Info
			$select_token = "value as value,type as type,owner as owner,access as access,limit as limit,count as count,expiry as expiry,stamp as stamp";
			$tokenInfo = $this->CoreCrud->selectMultipleValue($tableName, $select_token, ['id' => $token_id]);

			// Date
			$todayNow = date('Y-m-d H:i:s', time());

			// Token Data
			$token_value = $tokenInfo[0]->value;
			$token_decrypt = $this->encryption->decrypt($token_value);

			// Token Veryfy
			$where['key'] = $token_decrypt;

			// Token Limit
			$token_limit = $tokenInfo[0]->limit;
			($token_limit == 1) ? $where['expiry >='] = $todayNow : null;

			// Token Type
			$token_type = $tokenInfo[0]->type;
			($token_type == 'api') ? $where['owner'] = $ownerInfo : $where['expiry >='] = $todayNow;

			// If Owner !is_null
			(!is_null($ownerInfo)) ? $where['owner'] = $ownerInfo : null;

			print_r($where);
			die;
			// Check Token
			if ($this->CoreCrud->selectSingleValue($tableName, 'id', $where)) {
				$token_count = $tokenInfo[0]->count; // Count Token
				$tokenUsage = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'token_use'));

				// For Session
				if ($tokenInfo[0]->type == 'session') {
					if ($token_count < $tokenUsage) {
						$this->db->update($tableName, ['token_count' => $token_count + 1], ['token_id' => $token_id]);
					} else {
						// Delete
						$this->db->delete($tableName, ['token_id' => $token_id]);
					}
				} elseif ($tokenInfo[0]->type == 'access') {
					$stamp = strtotime($tokenInfo[0]->stamp);
					$expiry = strtotime($tokenInfo[0]->expiry);

					$second = round(abs($expiry - $stamp));
					$next_expiry = date('Y-m-d H:i:s', strtotime("+$second seconds", strtotime($todayNow)));
					$this->db->update($tableName, ['token_count' => $token_count + 1, 'token_expiry' => $next_expiry], ['token_id' => $token_id]);
				} elseif ($tokenInfo[0]->type == 'api') {
					$this->db->update($tableName, ['token_count' => $token_count + 1], ['token_id' => $token_id]);
				} else {
					$this->db->update($tableName, ['token_count' => $token_count + 1, 'token_flg' => 0], ['token_id' => $token_id]);
				}

				//Return
				return $token_id;
			}
		}
		// Failed
		return false;
	}

	/**
	 * Response Code
	 * Pass code number default is 400
	 * 
	 * Return arry code as status=>passed code number and value as code meaning
	 */
	public function response_code($code = 400)
	{
		// Example 400 => Bad Request
		$response_code = array(
			'200' => 'Success',
			'400' => 'Bad Request',
			'401' => 'Unauthorized',
			'402' => 'Payment Required',
			'403' => 'Forbidden',
			'404' => 'Not Found',
			'405' => 'Method Not Allowed',
			'406' => 'Not Acceptable',
			'407' => 'Proxy Authentication Required',
			'408' => 'Request Timeout',
			'409' => 'Conflict',
			'410' => 'Gone',
			'411' => 'Length Required',
			'412' => 'Precondition Failed',
			'413' => 'Request Entity Too Large',
			'414' => 'Request-URI Too Long',
			'415' => 'Unsupported Media Type',
			'416' => 'Requested Range Not Satisfiable',
			'417' => 'Expectation Failed',
			'500' => 'Internal Server Error',
			'501' => 'Not Implemented',
			'502' => 'Bad Gateway',
			'503' => 'Service Unavailable',
			'504' => 'Gateway Timeout',
			'505' => 'HTTP Version Not Supported',
		);

		http_response_code($code);

		// Check the code passed and return the code and meaning
		if (array_key_exists($code, $response_code)) {
			return array('status' => $code, 'value' => $response_code[$code]);
		} else {
			return array('status' => '500', 'value' => 'Internal Server Error');
		}
	}

	/**
	 * Check Auth Permission
	 * 
	 * Pass Access Level
	 * Pass UserID or String User Access Level
	 * 
	 * Return Status
	 */
	public function auth($access, $passed = 'member')
	{
		// Check IF $passsed is numeric
		if (is_numeric($passed)) {
			// select single from user 
			$level = $this->CoreCrud->selectSingleValue('user', 'level', array('id' => $passed, 'flg' => 1));
		} else {
			// Level
			$level = strtolower(trim($passed));
		}

		// Validate Auth
		return $this->CoreLoad->auth($access, $level);
	}

	/**
	 * Process Received Data
	 * 
	 * Pass Data
	 */
	public function process($data, $tokenName = null)
	{
		// System Token Name
		if (is_null($tokenName)) {
			$tokenNameDB = $this->CoreCrud->selectSingleValue('settings', 'value', array('title' => 'token_name'));
			$tokenNameDB = preg_replace("/[^ \w-]/", "", stripcslashes($tokenNameDB));
			// Capitalize
			$tokenName = ucwords($tokenNameDB);
			// Replace Space,underscore with dash
			$tokenName = str_replace(array(' ', '_'), '-', $tokenName);
		}

		// Get Headers
		$headers = $this->input->request_headers();
		// token value
		$response['userToken'] = (array_key_exists($tokenName, $headers)) ? $headers[$tokenName] : null;

		// Headers - Test
		if (array_key_exists('coretest', $data)) {
			$response['headers'] = $headers;
		}

		// Return
		return $response;
	}

	/**
	 * Process Error Meesage
	 * 
	 * Pass Validation Errors
	 */
	public function error_response($errors)
	{
		// Remove new line,<p> and replace with space
		$errors = str_replace(array("\r", "\n", "<p>", '"'), '', $errors);
		// Explode string to array
		$errors = explode('</p>', $errors);
		// Remove empty array
		$errors = array_filter($errors);
		// Pick the 2nd and 3rd word from each array
		$keys = array_map(function ($error) {
			// FInd the word in 2nd position
			$first = explode(' ', $error)[1];
			$second = explode(' ', $error)[2];

			return strtolower(trim($first . '_' . $second));
		}, $errors);

		// Set $keys[0] as array key for $errors[0] and so on
		$response_errors  = array_combine($keys, $errors);

		// Return
		return $response_errors;
	}

	/**
	 * Decode Each value in array
	 * 
	 * Pass the array
	 * Return the array
	 */
	public function decode_array($array)
	{
		// Loop through each value
		foreach ($array as $key => $value) {
			// Check if value is value is in Json format
			if (is_string($value) && is_array(json_decode($value, true)) && (json_last_error() == JSON_ERROR_NONE)) {
				// Decode value
				$array[$key] = json_decode($value, true);
			} else {
				// Decode value
				$array[$key] = html_entity_decode($value);
			}
		}
		// Return
		return $array;
	}
}


/** End of file ApiState.php */
/** Location: ./application/models/ApiState.php */
