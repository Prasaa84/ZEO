<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlanningSection extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->helper('url_helper');
	}
	
      // ------------------------------------------
      // Following functions load the public information php files 
      // related to teacher institution section in the zonal office
      // ------------------------------------------

      public function index(){
            $data['title'] = 'The Planning Section';
            $data['content'] = 'planning_section/index';
            $this->load->view('templates/template', $data);
      }
     
}