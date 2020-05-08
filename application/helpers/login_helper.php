<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	function is_logged_in(){
		$ci =& get_instance();
		$loginuser = $ci->session->userdata('loginuser'); 
		//print_r($loginuser);
		//die();
		if($loginuser){
			return true;
		}else{
			return false;
		}
	}
?>
