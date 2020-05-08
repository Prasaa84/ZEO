<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DevelopmentSection extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->helper('url_helper');
	}
	
      // ------------------------------------------
      // Following functions load the public information php files 
      // related to teacher institution section in the zonal office
      // ------------------------------------------

      public function index(){
            $data['title'] = 'The Development Section';
            $data['content'] = 'development_section/index';
            $this->load->view('templates/template', $data);
      }
      public function approveEducationalTrips(){
            $data['title'] = 'The Development Section';
            $data['content'] = 'development_section/requirements_for_educational_trips';
            $this->load->view('templates/template', $data);
      }
      public function schoolLeaveCertificate(){
            $data['title'] = 'How to get the second copy of School Leave Certificate';
            $data['content'] = 'development_section/requirements_for_school_leave_certificate';
            $this->load->view('templates/template', $data);
      }
      public function grade5Scholarship(){
            $data['title'] = 'How to get grade 5 scholarship funds';
            $data['content'] = 'development_section/requirements_for_grade5_scholarship';
            $this->load->view('templates/template', $data);
      }
      public function hallPlaygroundBooking(){
            $data['title'] = 'Hall and Play Ground Booking';
            $data['content'] = 'development_section/hall_n_play_ground_booking';
            $this->load->view('templates/template', $data);
      }
      public function courses(){
            $data['title'] = 'Courses';
            $data['content'] = 'development_section/courses';
            $this->load->view('templates/template', $data);
      }
      public function public_results_page(){
            $data['title'] = 'Results Analysis';
            $data['content'] = 'development_section/results';
            $this->load->view('templates/template', $data);
      }
     
}