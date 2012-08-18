<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Alert
 * 
 * @package Alert
 * @author TyCamTech - Stuart Duncan
 * @copyright 2012
 * @version 1
 * @access public
 */
class Alert {

	/** Place holder vars **/
	private $msg;
	private $layout;

	/** List of available layout (can be a template name or a class name) options for alerts **/
	private $acceptable_layouts = array('error' => 'error', 'warning' => 'warning', 'info' => 'info', 'success' => 'message');

	/** If true, only a layout name in the array above is allowed. If false, pass anything through. **/
	private $enforce_layouts = false;

	/**
	 * This is the default message to display when an ID is missing (such as a tampered URL string)
	 * This can be set in the params
	 **/
	private $default_id_msg = 'ID is required. Please go back and try again.';

	/**
	 * On construct of this class...
	 **/
	public function __construct(){
	}

	/**
	 * Display an alert to the screen
	 * @param $msg string
	 * @param $layout - OPTIONAL - can be message, error
	 **/
	public function show($msg = null, $layout = 'message', $url = null){

		// Verify the layout is acceptable
		if( $this->verify_layout($layout) === false )
			return false;

		// Clean it up.
		$msg = $this->clean_msg($msg);

		// Retrieve the CI controller
        $this->_CI = &get_instance();

		// If there is no redirect, we don't need to use flashdata, since flashdata is for showing AFTER a redirect
		if( empty($url) ){
			$this->_CI->data['alert'] = array($msg, $layout);
		}
		else {
			// Set to flash
			$this->_CI->session->set_flashdata('msg', $msg);
			$this->_CI->session->set_flashdata('layout', $layout);

			redirect($url);
		}

		return;
	}

	/**
	 * Auto checks for an empty id, since they should never be empty
	 * Pass in a custom message or use the default
	 * Pass in a url to redirect if it's empty or leave null to stay on page
	 * @param $id int
	 * @param $url string
	 * @param $msg string
	 * 
	 * Calls $this->show() if id is null
	 **/
	public function idEmpty($id = null, $url = null, $msg = null){
		// $id is empty? Then we need an error presented.
		if( empty($id) ){
			// If the $msg is empty, set a generic message
			if( empty($msg) ) $msg = $this->default_id_msg;

			// Send to show. No need to clean msg or anything, it's done in show()
			// A missing ID is always an error.
			$this->show($msg, $this->acceptable_layouts['error'], $url);

			// Pass just in case $url is null and the calling controller needs a response
			return true;
		}
		// $id is empty, no need to do anything
		return false;
	}

	/**
	 * Clean up the msg, to ensure no slashes or white spaces
	 **/
	private function clean_msg($msg = null){
		if( is_array($msg) ){
			$new_msg = array();
			foreach( $msg as $m ){
				$new_msg[] = trim(stripslashes($m));
			}
			return $new_msg;
		}
		else {
			return trim(stripslashes($msg));
		}
	}

	/**
	 * Verify that only certain alerts are allowed
	 **/
	private function verify_layout($layout = null){
		// Enforcing strict layout names but the layout passed is not in the list?
		if( $this->enforce_layouts && !in_array($layout, $this->acceptable_layouts) ){
			return false;
		}

		// Anything else, return true
		$this->layout = $layout;
		return true;
	}
}
?>