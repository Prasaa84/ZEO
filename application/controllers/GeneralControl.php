<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneralControl extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->helper('url_helper');
            $this->load->library('breadcrumbs');
            // add breadcrumbs

            // unshift crumb
            $this->breadcrumbs->unshift('Home', '/');
	}
      
      // ------------------------------------------
      // Following functions load the public php files 
      // related to general control section in the zonal office
      // ------------------------------------------
      //$this->breadcrumbs->show();
      public function index(){
            $data['title'] = 'General Control Section';
            $data['content'] = 'general_control_section/index';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionLeaveDetails(){
            $this->breadcrumbs->push('Leave', '/section');
            $this->breadcrumbs->push('Page', '/section/page');
            $data['title'] = 'General Control Section';
            $data['content'] = 'general_control_section/general_control_section_leave_approve';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionMaternityLeavesWithFullPay(){
            $this->breadcrumbs->push('Leave Details', '/section');
            $this->breadcrumbs->push('Maternity Leave with Full Pay', '/section/page');
            $data['title'] = 'Maternity Leave with Full Pay';
            $data['content'] = 'general_control_section/general_control_section_maternity_leave_full_pay';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionMaternityLeavesWithHalfPay(){
            $data['title'] = 'Maternity Leave with Half Pay';
            $data['content'] = 'general_control_section/general_control_section_maternity_leave_half_pay';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionMaternityLeavesWithNoPay(){
            $data['title'] = 'Maternity Leave with No Pay';
            $data['content'] = 'general_control_section/general_control_section_maternity_leave_no_pay';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionPaternalLeave(){
            $data['title'] = 'Paternal Leave';
            $data['content'] = 'general_control_section/general_control_section_paternal_leave';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionAccidentLeave(){
            $data['title'] = 'Accident Leave';
            $data['content'] = 'general_control_section/general_control_section_accident_leave';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionAbroadLeave(){
            $data['title'] = 'Abroad Leave';
            $data['content'] = 'general_control_section/general_control_section_abroad_leave';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionServiceRelated(){
            $data['title'] = 'Abroad Leave';
            $data['content'] = 'general_control_section/general_control_section_service_relatated';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionServiceGetPermanent(){
            $data['title'] = 'How to get permanent';
            $data['content'] = 'general_control_section/general_control_section_service_get_permanent';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionServiceGetExtend(){
            $data['title'] = 'How to get extend the service';
            $data['content'] = 'general_control_section/general_control_section_service_get_extend';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionServiceGetPension(){
            $data['title'] = 'How to get extend the service';
            $data['content'] = 'general_control_section/general_control_section_service_get_pension';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionServiceGetResign(){
            $data['title'] = 'How to get extend the service';
            $data['content'] = 'general_control_section/general_control_section_service_get_resign';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionPersonalFile(){
            $data['title'] = 'About your personal file';
            $data['content'] = 'general_control_section/general_control_section_personal_file';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionManagementAssistanceService(){
            $data['title'] = 'Management Assistance Service';
            $data['content'] = 'general_control_section/general_control_section_management_assistance_service';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionNonAcademicService(){
            $data['title'] = 'Non Academic Service';
            $data['content'] = 'general_control_section/general_control_section_non_academic_service';
            $this->load->view('templates/template', $data);
      }
      public function generalControlSectionDevelopmentOfficerService(){
            $data['title'] = 'Development Officer Service';
            $data['content'] = 'general_control_section/general_control_section_development_officer_service';
            $this->load->view('templates/template', $data);
      }

}
