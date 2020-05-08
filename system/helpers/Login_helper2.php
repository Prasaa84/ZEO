<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	function is_logged_in1(){
		$ci =& get_instance();
		$loginuser = $ci->session->userdata('loginuser');
		if($loginuser){
			return true;
		}else{
			return false;
		}
	}
?>
