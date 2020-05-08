<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicInfo extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->helper('url_helper');
	}
	public function contact(){
            $data['title'] = 'Contact Us';
	      $data['content'] = 'public_info/contact';
            $this->load->view('templates/template', $data);
	}
      public function aboutUs(){
            $data['title'] = 'About Us';
            $data['content'] = 'public_info/about_us';
            $this->load->view('templates/template', $data);
      }
      public function kotapolaDiv(){
            $data['title'] = 'Kotapola education division';
            $data['content'] = 'public_info/kotapola_div';
            $this->load->view('templates/template', $data);
      }
      public function morawakaDiv(){
            $data['title'] = 'Morawaka education division';
            $data['content'] = 'public_info/morawaka_div';
            $this->load->view('templates/template', $data);
      }
      public function pasgodaDiv(){
            $data['title'] = 'Pasgoda education division';
            $data['content'] = 'public_info/pasgoda_div';
            $this->load->view('templates/template', $data);
      }
      public function director(){
            $data['title'] = 'Zonal Education Director';
            $data['content'] = 'public_info/director';
            $this->load->view('templates/template', $data);
      }
      public function assDirectors(){
            $data['title'] = 'Assistant Education Directors';
            $data['content'] = 'public_info/ass_directors';
            $this->load->view('templates/template', $data);
      }
      public function divDirectors(){
            $data['title'] = 'Divisional Education Directors';
            $data['content'] = 'public_info/div_directors';
            $this->load->view('templates/template', $data);
      }
      public function adminOfficer(){
            $data['title'] = 'Administrative Officer';
            $data['content'] = 'public_info/admin_officer';
            $this->load->view('templates/template', $data);
      }
      public function loginPage(){
            $data['title'] = 'User Login Window';
            $data['content'] = 'public_info/login';
            $this->load->view('templates/template', $data);
      }
}
