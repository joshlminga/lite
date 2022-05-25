<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AppNotify extends CI_Model
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
	 *
	 * This function is normally accessed by default in most of the notifications
	 *  This pass blank/empty/null notification
	 *  If you have no notification to call or pass on particular form use blank.
	 *   E.g when user first open contact form set notification blank
	 *       Then when submitting the form you can change to success or error 
	 */
	public function blank($value = null)
	{
		//Empty Notifiaction
		return null;
	}

	/**
	 *
	 *  This pass success notification
	 *  When opratation is successful pass this notification
	 *  The variable value passed is the message you wish user to see, by default message is set to 'Activity was successful.'
	 */
	public function success($value = null)
	{
		//Check Value
		$message = (!empty($value) && !is_null($value)) ? $value : 'Activity was successful.';

		//Message
		$notify =   "$message";

		return $notify;
	}

	/**
	 *
	 *  This pass failed/error notification
	 *  When opratation is failed pass this notification
	 *  The variable value passed is the message you wish user to see, by default message is set to 'Change a few things up and try again.'
	 */
	public function error($value = null)
	{

		//Check Value
		$message = (!is_null($value)) ? $value : 'Change a few things up and try again.';

		//Message
		$notify =   "$message";

		return $notify;
	}

	/**
	 *
	 *  This pass info/note notification
	 *  When you want to pass an info
	 *  The variable value passed is the message you wish user to see, by default message is set to 'Highlight and some info below.'
	 */
	public function attention($value = null)
	{

		//Check Value
		$message = (!is_null($value)) ? $value : 'Highlight and some info below.';

		//Message
		$notify =   "$message";

		return $notify;
	}

	/**
	 *
	 * This function can help user to check if there is any notification set in the notification KEY
	 * If there is it will return the notification method
	 * Else it will return blank
	 *  
	 */
	public function notify($key = 'notification')
	{
		//Check Inside Notification
		$notify = $this->session->flashdata("$key");

		if (!empty($notify) || !is_null($notify)) {

			return $notify; //Notification Method
		} else {

			return 'blank'; //Notification Method
		}
	}

	/**
	 *
	 *  This function help you to set-up a notification session and the message you wish to be passed
	 *  This can be used by advance users when they want to set/store a value inside session so it can be accessed later
	 *  You can use this even to store user IP address/ User ID etc
	 * 
	 */
	public function set($type = 'blank', $key = 'notification')
	{
		//Set Message
		$this->session->set_flashdata($key, $type);
	}

	/**
	 *
	 * This function can be used to clear session data
	 * Is best to clear upon redirect etc
	 * 
	 */
	public function clear($key = 'notification')
	{
		//Clear Notification
		$this->session->flashdata("$key", "");
	}

	/**
	 *
	 *  This is used by core cms to pass the system updates heads-UP
	 *  You shouldn't use this function at any time, due it can be change when system is uodated 
	 */
	public function updates($value = null)
	{
		//Check Value
		if (is_null($value)) {

			return null;
		} else {
			//Message
			$notify =   "$value";

			return $notify;
		}
	}
}

/** End of file AppNotify.php */
/** Location: ./application/models/AppNotify.php */
