<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneralInfo extends CI_Controller {

	public function __construct(){
	      parent::__construct();
            $this->load->model('News_model');
            $this->load->model('School_model');
	}
	public function contact(){
            $data['title'] = 'Contact Us';
	      $data['content'] = 'general_info/contact';
            $this->load->view('templates/template', $data);
	}
      public function aboutUs(){
            $data['title'] = 'About Us';
            $data['content'] = 'general_info/about_us';
            $this->load->view('templates/template', $data);
      }
      public function kotapolaDiv(){
            $divId = 103;
            $result = $this->School_model->view_school_data_by_division($divId);
            if($result){
                  $data['schools'] = $result;
                  $data['title'] = 'Schools of Kotapola Division';
            }else{
                  $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
            }
            $data['content'] = 'general_info/kotapola_div';
            $this->load->view('templates/template', $data);
      }
      public function morawakaDiv(){
            $divId = 101;
            $result = $this->School_model->view_school_data_by_division($divId);
            if($result){
                  $data['schools'] = $result;
                  $data['title'] = 'Schools of Morawaka Division';
            }else{
                  $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
            }
            $data['content'] = 'general_info/morawaka_div';
            $this->load->view('templates/template', $data);
      }
      public function pasgodaDiv(){
            $divId = 102;
            $result = $this->School_model->view_school_data_by_division($divId);
            if($result){
                  $data['schools'] = $result;
                  $data['title'] = 'Schools of Pasgoda Division';
            }else{
                  $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
            }
            $data['content'] = 'general_info/pasgoda_div';
            $this->load->view('templates/template', $data);
      }
      public function director(){
            $data['title'] = 'Zonal Education Director';
            $data['content'] = 'general_info/director';
            $this->load->view('templates/template', $data);
      }
      public function assDirectors(){
            $data['title'] = 'Assistant Education Directors';
            $data['content'] = 'general_info/ass_directors';
            $this->load->view('templates/template', $data);
      }
      public function divDirectors(){
            $data['title'] = 'Divisional Education Directors';
            $data['content'] = 'general_info/div_directors';
            $this->load->view('templates/template', $data);
      }
      public function adminOfficer(){
            $data['title'] = 'Administrative Officer';
            $data['content'] = 'general_info/admin_officer';
            $this->load->view('templates/template', $data);
      }
      public function accountant(){
            $data['title'] = 'Accountant';
            $data['content'] = 'general_info/accountant';
            $this->load->view('templates/template', $data);
      }
      public function otherStaff(){
            $data['title'] = 'Other Staff';
            $data['content'] = 'general_info/other_staff';
            $this->load->view('templates/template', $data);
      }
      public function loginPage(){
            $data['title'] = 'User Login Window';
            $data['content'] = 'general_info/login';
            $this->load->view('templates/template', $data);
      }
      public function gallery(){
            $data['title'] = 'Gallery';
            $data['content'] = 'general_info/gallery';
            $this->load->view('templates/template', $data);
      }
      public function news(){
            $limit = 10;
            $latestNews = $this->News_model->get_all_news($limit);
            $limit = '';
            $newsAddedDate = $this->News_model->get_news_added_date(); // to make archive in the view
            $data['title'] = 'Recent News';
            $data['heading'] = 'නවතම පුවත්';
            $data['news'] = $latestNews;
            $data['newsAddedDate'] = $newsAddedDate;     // data for archive       
            $data['content'] = 'general_info/news';
            $this->load->view('templates/template', $data);
      }
}