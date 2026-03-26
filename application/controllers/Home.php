<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct(){
        parent::__construct();
        //$this->load->model('Staff_model');
        //$this->load->model('Common_model');
        $this->load->model('News_model');
    }

	public function index()
	{
		$data['title'] = 'Zonal Education Deniyaya';
		$limit = 4;
        $latestNews = $this->News_model->get_all_news($limit);
        $newsAddedDate = $this->News_model->get_news_added_date(); // to make archive in the view
        $data['news'] = $latestNews;
        $data['newsAddedDate'] = $newsAddedDate; 
        $data['content'] = 'index';
        $this->load->view('templates/template', $data);
	}

}
