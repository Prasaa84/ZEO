<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SalarySection extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->helper('url_helper');
	}
	
      // ------------------------------------------
      // Following functions load the public information php files 
      // related to teacher institution section in the zonal office
      // ------------------------------------------

      public function index(){
            $data['title'] = 'The Salary Section';
            $data['content'] = 'salary_section/index';
            $this->load->view('templates/template', $data);
      }
      public function travelingClaim(){
            $data['title'] = 'Traveling Expenses';
            $data['content'] = 'salary_section/traveling_expenses_claim';
            $this->load->view('templates/template', $data);
      }
      public function requestPaySheet(){
            $data['title'] = 'How to request pay sheets';
            $data['content'] = 'salary_section/request_paysheet';
            $this->load->view('templates/template', $data);
      }
      public function salaryIncrement(){
            $data['title'] = 'Salary Increment';
            $data['content'] = 'salary_section/salary_increment';
            $this->load->view('templates/template', $data);
      }
      public function salaryPayment(){
            $data['title'] = 'Salary';
            $data['content'] = 'salary_section/salary_payment';
            $this->load->view('templates/template', $data);
      }
     
     
}