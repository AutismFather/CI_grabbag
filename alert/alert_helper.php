<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Alert helper, displays alert/notification bars
 * 
 * Method 1:
 * Retrieves session data, looking for flashdata of msg and layout.
 * If found, builds a div and returns it with template styled alert/notification
 * 
 * Method 2:
 * Pass in msg and layout on the call, helpful for form validation and other situations
 * 
 **/
if ( ! function_exists('alert')){
function alert($msg = null, $layout = null){
    $CI =& get_instance();

	// First, check to see if alert is simply set as CI data. This avoids use of sessions as it's called on same page
	if( !empty($CI->data['alert']) && is_array($CI->data['alert']) ){
		$sess_msg = $CI->data['alert'][0];
		$sess_layout = $CI->data['alert'][1];
	}
	// If not set, check for flash data in session.
	else {
		$sess_msg = $CI->session->flashdata('msg');
		$sess_layout = $CI->session->flashdata('layout');;
	}

	// Check for CI form errors as well
	if( function_exists('validation_errors') ){
		$v_errors = validation_errors();
		if( !empty($v_errors) ){
			$msg.= $v_errors;
			$layout = 'error';
		}
	}

	// If a message is set as well as a session message, combine the two
	$msg = $msg . $sess_msg;

	// There's really no way we should be here without a layout but just in case, set a default
	if( !empty($layout) )
		$layout = $layout;
	else if ( !empty($sess_layout) )
		$layout = $sess_layout;
	else
		$layout = 'info';

	$output = null;
	// Do what ever you need to do here to make it look good.
	// Return the html, call a template, what ever.
	if( !empty($msg) ){
		$output = '<div class="' . $layout . '">' . $msg . '</div>';
	}
	return $output;
}

}
?>