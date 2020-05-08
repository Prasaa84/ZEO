<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TeacherInstitution extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->helper('url_helper');
	}
	
      // ------------------------------------------
      // Following functions load the public information php files 
      // related to teacher institution section in the zonal office
      // ------------------------------------------

      public function index(){
            $data['title'] = 'Teacher Institution Section';
            $data['content'] = 'teacher_institution/index';
            $this->load->view('templates/template', $data);
      }
      public function leaveDetails(){
            $data['title'] = 'General Control Section';
            $data['content'] = 'teacher_institution/leave_approve';
            $this->load->view('templates/template', $data);
      }
      public function maternityLeavesWithFullPay(){
            $data['title'] = 'Maternity Leave with Full Pay';
            $data['content'] = 'teacher_institution/maternity_leave_full_pay';
            $this->load->view('templates/template', $data);
      }
      public function maternityLeavesWithHalfPay(){
            $data['title'] = 'Maternity Leave with Half Pay';
            $data['content'] = 'teacher_institution/maternity_leave_half_pay';
            $this->load->view('templates/template', $data);
      }
      public function maternityLeavesWithNoPay(){
            $data['title'] = 'Maternity Leave with No Pay';
            $data['content'] = 'teacher_institution/maternity_leave_no_pay';
            $this->load->view('templates/template', $data);
      }
      public function paternalLeave(){
            $data['title'] = 'Paternal Leave';
            $data['content'] = 'teacher_institution/paternal_leave';
            $this->load->view('templates/template', $data);
      }
      public function accidentLeave(){
            $data['title'] = 'Accident Leave';
            $data['content'] = 'teacher_institution/accident_leave';
            $this->load->view('templates/template', $data);
      }
      public function abroadLeave(){
            $data['title'] = 'Abroad Leave';
            $data['content'] = 'teacher_institution/abroad_leave';
            $this->load->view('templates/template', $data);
      }
      public function serviceRelated(){
            $data['title'] = 'Abroad Leave';
            $data['content'] = 'teacher_institution/service_relatated';
            $this->load->view('templates/template', $data);
      }
      public function serviceGetPermanent(){
            $data['title'] = 'How to get permanent';
            $data['content'] = 'teacher_institution/service_get_permanent';
            $this->load->view('templates/template', $data);
      }
      public function serviceGetExtend(){
            $data['title'] = 'How to get extend the service';
            $data['content'] = 'teacher_institution/service_get_extend';
            $this->load->view('templates/template', $data);
      }
      public function serviceGetPension(){
            $data['title'] = 'How to get extend the service';
            $data['content'] = 'teacher_institution/service_get_pension';
            $this->load->view('templates/template', $data);
      }
      public function serviceGetResign(){
            $data['title'] = 'How to get extend the service';
            $data['content'] = 'teacher_institution/service_get_resign';
            $this->load->view('templates/template', $data);
      }
      public function personalFile(){
            $data['title'] = 'About your personal file';
            $data['content'] = 'teacher_institution/personal_file';
            $this->load->view('templates/template', $data);
      }
}