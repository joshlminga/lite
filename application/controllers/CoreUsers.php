<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CoreUsers extends CI_Controller {

	/*
	*
	* The main controller for Administrator Backend
	* -> The controller require user to login as Administrator
	*
	* Functions
	* -> __construct () = Load the most required operations E.g Class Module
	* 
	* 
	*/

	public function __construct()
	{
		parent::__construct();

		//Libraries
		$this->load->library('form_validation');
		
        //Models
        
	}


    //Load repetitive/common operation
	public function load($page_id=null){

		//Model

		//Model Query
		$data = $this->CoreLoad->open();
		$passed = $this->passed();
		$data = array_merge($data,$passed);

		return $data;
	}

	//Additional Passed Data
	public function passed()
	{
	
		//Time Zone
		date_default_timezone_set('Africa/Nairobi');
		$data['str_to_time'] = strtotime(date('Y-m-d, H:i:s'));

		return $data;
	}

    //Load repetitive/common pages
    public function pages($data,$layout='main')
    {

    	//Chech allowed Access
		// $auth = 'check if authentication is true'; //Authentication

		// if ($auth) {

			//Layout
			$this->load->view("administrator/layouts/$layout",$data);

		// }else{

		// 	echo 'if failed say not allowed';
		// }
    }

	public function index($page_id=null,$error=null)
	{

		//Value

		//Page Template

		//Model Query
		$data = $this->load();

		//Call Page
		$this->pages($data);
		
	}

	//Addiitonal Open Page
	public function open($message=null,$page=null,$layout=null)
	{

		//values
		$notify = $this->session->flashdata('notification'); // Get Notification From the Session
		$notification = (empty($notify) || is_null($notify)) ? 'blank' : $notify;

		//Model

		//Call Operations

		//Model Query
		$data = 'Get opened page data';
		$data['notify'] = 'set notification (Blank,Success, Error)';

		//Call Page		
		$this->pages($data,$layout);
	}

	//Valid
	public function valid($value)
	{
		if ($value == 'check Value if true') {

		}
		else{

			//Open Index
			redirect('Page','refresh');
		}
	}

}

/* End of file CoreUsers.php */
/* Location: ./application/controllers/CoreUsers.php */