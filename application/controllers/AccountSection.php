<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccountSection extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->helper('url_helper');
	}
	
      // ------------------------------------------
      // Following functions load the public information php files 
      // related to teacher institution section in the zonal office
      // ------------------------------------------

      public function index(){
            $data['title'] = 'The Account Section';
            $data['content'] = 'account_section/index';
            $this->load->view('templates/template', $data);
      }
      public function foodVoucherPayment(){
            $data['title'] = 'Food Voucher Payment';
            $data['content'] = 'account_section/food_voucher_payment';
            $this->load->view('templates/template', $data);
      }
      public function pgdCourseFeeClaim(){
            $data['title'] = 'PGD Course Fee Claim';
            $data['content'] = 'account_section/pgd_course_fee_claim';
            $this->load->view('templates/template', $data);
      }
      public function irragularCourseFeePayment(){
            $data['title'] = 'Irragular Course Fee Payment';
            $data['content'] = 'account_section/irragular_course_fee_payment';
            $this->load->view('templates/template', $data);
      }
      public function officeProcurement(){
            $data['title'] = 'Office Procurement';
            $data['content'] = 'account_section/office_procurement';
            $this->load->view('templates/template', $data);
      }
     
}