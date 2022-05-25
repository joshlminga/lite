<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CoreApi extends CI_Controller
{

	/**
	 *
	 * The main controller for Administrator Backend
	 * -> The controller require user to login as Administrator
	 */

	private $Module = ''; //Module
	private $Route = 'api'; //If you have different route Name to Module name State it here |This wont be pluralized | set it null to use default


	/** Functions
	 * -> __construct () = Load the most required operations E.g Class Module
	 * 
	 */
	public function __construct()
	{
		parent::__construct();

		//Libraries

		//Helpers

		//Models
		$this->load->model('Api/AppNotify', 'AppNotify');
		$this->load->model('Api/ApiState', 'AppState');

		// Your own constructor code
	}

	/**
	 *
	 * Failed Response
	 */
	public function failed()
	{

		//Receive the RAW post data.
		$content = trim(file_get_contents("php://input")); // Takes raw data from the request
		$decoded = json_decode($content, true); // Converts it into a PHP object
		// Check Data
		$decoded = (!is_null($decoded) && !empty($decoded)) ? $decoded : $this->CoreLoad->input(null, 'get');

		// Check if $decoded is Not null
		if (!is_null($decoded) && count($decoded) > 0) {
			// Token and Other Response
			$pre_response = $this->AppState->process($decoded);

			// load Token Model
			$token = $this->AppState->validate($pre_response['userToken']);
			$pre_response = $this->CoreCrud->unsetData($pre_response, ['userToken']);

			// Unset Headers
			$unset = (array_key_exists('coreunset', $decoded)) ? $decoded['coreunset'] : array();
			$decoded = $this->CoreCrud->unsetData($decoded, ['coretest', 'coreunset']);
			// Generate new array errors and assign empty value '' to each key found in decoded
			$errors = array_fill_keys(array_keys($decoded), '');

			// Status - Unauthorized
			$response = $this->AppState->response_code(404);

			//Notification Message	
			$message = 'API request failed. No callback was found.';
			$notification = $this->AppNotify->error($message);
			$response['message'] = $notification;

			// Set $keys[0] as array key for $errors[0] and so on
			$response['errors']  = [
				'corelite' => 'check api route url or check token'
			];

			// Update $errors with $response['errors'] 
			$response['errors'] = array_merge($errors, $response['errors']);

			// Other
			$code_feedback = ['params' => $decoded, 'module' => $this->Module, 'route' => $this->Route, 'controller' => $this->router->fetch_class() . '.php'];
			$response['feedback'] = (count($pre_response) > 0) ? array_merge($pre_response, $code_feedback) : ['test_response' => 'hidden'];

			// Set header Json
			header('Content-type: application/json');
			// Show Response
			echo json_encode($response);
		}
	}

	/**
	 * 
	 * Generate Token
	 */
	public function getToken()
	{

		// Configs
		$config = [
			// 'type' => 'session',
			'limit' => 0, //No Expirey
			// 'length' => 15,
		];

		$token = $this->AppState->tokenGenerate($config, 60);
		echo $token;
	}

	/**
	 *
	 * Get Inheritance
	 * 
	 * Pass the type
	 * 
	 */
	public function getInheritance($type = null)
	{
		// Check if $decoded is Not null
		$type = (is_null($type)) ? 'inheritance' : $type;

		//Receive the RAW post data.
		$content = trim(file_get_contents("php://input")); // Takes raw data from the request
		$decoded = json_decode($content, true); // Converts it into a PHP object
		// Check Data
		$decoded = (!is_null($decoded) && !empty($decoded)) ? $decoded : $this->input->get();

		// Token and Other Response
		$pre_response = $this->AppState->process($decoded);

		// load Token Model
		$token = $this->AppState->validate($pre_response['userToken']);
		$pre_response = $this->CoreCrud->unsetData($pre_response, ['userToken']);

		// Check Token
		if ($token) {
			$formData = $decoded; //Passed Data
			// Status - Precondition Failed
			$response = $this->AppState->response_code(200);

			//Notification Message	
			$message = 'Data was retrived successful'; //Notification Message
			$notification = $this->AppNotify->success($message);
			$response['message'] = $notification;

			// Queries params
			$where = (array)json_decode($formData['where']);
			$order = (array_key_exists('order', $formData)) ? (array)json_decode($formData['order']) : array('id' => 'ASC');
			$select = (array_key_exists('select', $formData)) ? $formData['select'] : 'id,type,parent,title';

			// Access The Query
			$found = $this->CoreCrud->selectInheritanceItem($where, $select, $order);

			// Response
			$response['errors']  = [];
			$response['response'] = [$type => $found];
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
		$response['errors'] = $response['errors'];
		// Other
		$code_feedback = ['params' => $decoded, 'module' => $this->Module, 'route' => $this->Route, 'controller' => $this->router->fetch_class() . '.php', 'queryResponse' => $this->db->error()];
		$response['feedback'] = (count($pre_response) > 0) ? array_merge($pre_response, $code_feedback) : ['test_response' => 'hidden'];
		// Set header Json
		header('Content-type: application/json');
		// Show Response
		echo json_encode($response);
	}

	/**
	 *
	 * Get Field
	 * 
	 * Pass the type
	 * 
	 */
	public function getField($type = null)
	{
		// Check if $decoded is Not null
		$type = (is_null($type)) ? 'field' : $type;

		//Receive the RAW post data.
		$content = trim(file_get_contents("php://input")); // Takes raw data from the request
		$decoded = json_decode($content, true); // Converts it into a PHP object
		// Check Data
		$decoded = (!is_null($decoded) && !empty($decoded)) ? $decoded : $this->input->get();

		// Token and Other Response
		$pre_response = $this->AppState->process($decoded);

		// load Token Model
		$token = $this->AppState->validate($pre_response['userToken']);
		$pre_response = $this->CoreCrud->unsetData($pre_response, ['userToken']);

		// Check Token
		if ($token) {
			$formData = $decoded; //Passed Data
			// Status - Precondition Failed
			$response = $this->AppState->response_code(200);

			//Notification Message	
			$message = 'Data was retrived successful'; //Notification Message
			$notification = $this->AppNotify->success($message);
			$response['message'] = $notification;

			// Queries params
			$where = (array)json_decode($formData['where']);
			$select = (array_key_exists('select', $formData)) ? $formData['select'] : 'all';
			$clause = (array_key_exists('clause', $formData)) ? $formData['clause'] : 'where';

			// Access The Query
			$found = $this->CoreCrud->selectFieldItem($where, $select, $clause);
			$found = (is_null($found)) ? [] : $found;

			// Response
			$response['errors']  = [];
			$response['response'] = [$type => $found];
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
		$response['errors'] = $response['errors'];
		// Other
		$code_feedback = ['params' => $decoded, 'module' => $this->Module, 'route' => $this->Route, 'controller' => $this->router->fetch_class() . '.php', 'queryResponse' => $this->db->error()];
		$response['feedback'] = (count($pre_response) > 0) ? array_merge($pre_response, $code_feedback) : ['test_response' => 'hidden'];
		// Set header Json
		header('Content-type: application/json');
		// Show Response
		echo json_encode($response);
	}

	/**
	 *
	 * Get Single
	 * 	 
	 */
	public function getSingle()
	{

		//Receive the RAW post data.
		$content = trim(file_get_contents("php://input")); // Takes raw data from the request
		$decoded = json_decode($content, true); // Converts it into a PHP object
		// Check Data
		$decoded = (!is_null($decoded) && !empty($decoded)) ? $decoded : $this->input->get();

		// Token and Other Response
		$pre_response = $this->AppState->process($decoded);

		// load Token Model
		$token = $this->AppState->validate($pre_response['userToken']);
		$pre_response = $this->CoreCrud->unsetData($pre_response, ['userToken']);

		// Check Token
		if ($token) {
			$formData = $decoded; //Passed Data
			// Status - Precondition Failed
			$response = $this->AppState->response_code(200);

			//Notification Message	
			$message = 'Data was retrived successful'; //Notification Message
			$notification = $this->AppNotify->success($message);
			$response['message'] = $notification;

			// Queries params
			$module = $formData['module'];
			$select = $formData['select'];
			$where = (array)json_decode($formData['where']);
			$clause = (array_key_exists('clause', $formData)) ? $formData['clause'] : null;
			// Access The Query
			$found = $this->CoreCrud->selectSingleValue($module, $select, $where,  $clause);

			// Response
			$response['errors']  = [];
			$response['response'] = $found;
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
		$response['errors'] = $response['errors'];
		// Other
		$code_feedback = ['params' => $decoded, 'module' => $this->Module, 'route' => $this->Route, 'controller' => $this->router->fetch_class() . '.php', 'queryResponse' => $this->db->error()];
		$response['feedback'] = (count($pre_response) > 0) ? array_merge($pre_response, $code_feedback) : ['test_response' => 'hidden'];
		// Set header Json
		header('Content-type: application/json');
		// Show Response
		echo json_encode($response);
	}

	/**
	 *
	 * Get Multiple
	 * 	 
	 */
	public function getMultiple()
	{

		//Receive the RAW post data.
		$content = trim(file_get_contents("php://input")); // Takes raw data from the request
		$decoded = json_decode($content, true); // Converts it into a PHP object
		// Check Data
		$decoded = (!is_null($decoded) && !empty($decoded)) ? $decoded : $this->input->get();

		// Token and Other Response
		$pre_response = $this->AppState->process($decoded);

		// load Token Model
		$token = $this->AppState->validate($pre_response['userToken']);
		$pre_response = $this->CoreCrud->unsetData($pre_response, ['userToken']);

		// Check Token
		if ($token) {
			$formData = $decoded; //Passed Data
			// Status - Precondition Failed
			$response = $this->AppState->response_code(200);

			//Notification Message	
			$message = 'Data was retrived successful'; //Notification Message
			$notification = $this->AppNotify->success($message);
			$response['message'] = $notification;

			// Queries params
			$module = $formData['module'];
			$select = $formData['select'];
			$where = (array)json_decode($formData['where']);
			$clause = (array_key_exists('clause', $formData)) ? $formData['clause'] : null;
			// Access The Query
			$found = $this->CoreCrud->selectMultipleValue($module, $select, $where,  $clause);

			// Response
			$response['errors']  = [];
			$response['response'] = [$found];
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
		$response['errors'] = $response['errors'];
		// Other
		$code_feedback = ['params' => $decoded, 'module' => $this->Module, 'route' => $this->Route, 'controller' => $this->router->fetch_class() . '.php', 'queryResponse' => $this->db->error()];
		$response['feedback'] = (count($pre_response) > 0) ? array_merge($pre_response, $code_feedback) : ['test_response' => 'hidden'];
		// Set header Json
		header('Content-type: application/json');
		// Show Response
		echo json_encode($response);
	}

	/**
	 *
	 * Get AutoFiels
	 * 	 
	 */
	public function getAutoData()
	{

		//Receive the RAW post data.
		$content = trim(file_get_contents("php://input")); // Takes raw data from the request
		$decoded = json_decode($content, true); // Converts it into a PHP object
		// Check Data
		$decoded = (!is_null($decoded) && !empty($decoded)) ? $decoded : $this->input->get();

		// Token and Other Response
		$pre_response = $this->AppState->process($decoded);

		// load Token Model
		$token = $this->AppState->validate($pre_response['userToken']);
		$pre_response = $this->CoreCrud->unsetData($pre_response, ['userToken']);

		// Check Token
		if ($token) {
			$formData = $decoded; //Passed Data
			// Status - Precondition Failed
			$response = $this->AppState->response_code(200);

			//Notification Message	
			$message = 'Data was retrived successful'; //Notification Message
			$notification = $this->AppNotify->success($message);
			$response['message'] = $notification;

			// Queries params
			$where = (array)json_decode($formData['where']);
			$return = (array_key_exists('return', $formData)) ? $formData['return'] : null;
			$table = (array_key_exists('table', $formData)) ? $formData['table'] : 'autofields';
			$select = (array_key_exists('select', $formData)) ? $formData['select'] : 'data';
			// Access The Query
			$found = $this->CoreLoad->loadAutoData($where, $return, $table, $select);

			// Response
			$response['errors']  = [];
			$response['response'] = [$found];
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
		$response['errors'] = $response['errors'];
		// Other
		$code_feedback = ['params' => $decoded, 'module' => $this->Module, 'route' => $this->Route, 'controller' => $this->router->fetch_class() . '.php', 'queryResponse' => $this->db->error()];
		$response['feedback'] = (count($pre_response) > 0) ? array_merge($pre_response, $code_feedback) : ['test_response' => 'hidden'];
		// Set header Json
		header('Content-type: application/json');
		// Show Response
		echo json_encode($response);
	}

	/**
	 *
	 * Get Load Data
	 * From CoreField Load
	 */
	public function getLoad()
	{

		//Receive the RAW post data.
		$content = trim(file_get_contents("php://input")); // Takes raw data from the request
		$decoded = json_decode($content, true); // Converts it into a PHP object
		// Check Data
		$decoded = (!is_null($decoded) && !empty($decoded)) ? $decoded : $this->input->get();

		// Token and Other Response
		$pre_response = $this->AppState->process($decoded);

		// load Token Model
		$token = $this->AppState->validate($pre_response['userToken']);
		$pre_response = $this->CoreCrud->unsetData($pre_response, ['userToken']);

		// Check Token
		if ($token) {
			$formData = $decoded; //Passed Data
			// Status - Precondition Failed
			$response = $this->AppState->response_code(200);

			//Notification Message	
			$message = 'Data was retrived successful'; //Notification Message
			$notification = $this->AppNotify->success($message);
			$response['message'] = $notification;

			// Params
			$return = (array_key_exists('return', $formData)) ? explode(',', $formData['return']) : null;
			// Access The Query
			$load = $this->CoreLoad->open();
			// Get Load Keys
			$keys = array_keys($load);

			// Check IF return is array
			if (is_array($return)) {
				// Lood what to return
				foreach ($keys as $value) {
					if (!in_array($value, $return)) {
						$load = $this->CoreCrud->unsetData($load, $value);
					}
				}
			}

			// Response
			$response['errors']  = [];
			$response['response'] = $load;
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
		$response['errors'] = $response['errors'];
		// Other
		$code_feedback = ['params' => $decoded, 'module' => $this->Module, 'route' => $this->Route, 'controller' => $this->router->fetch_class() . '.php', 'queryResponse' => $this->db->error()];
		$response['feedback'] = (count($pre_response) > 0) ? array_merge($pre_response, $code_feedback) : ['test_response' => 'hidden'];
		// Set header Json
		header('Content-type: application/json');
		// Show Response
		echo json_encode($response);
	}
}

/** End of file CoreApi.php */
/** Location: ./application/models/CoreApi.php */
