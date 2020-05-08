<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


	public function index()
	{
		$data['title'] = 'Zonal Education Deniyaya';
		//$this->load->view('templates/navigation');
		//$this->load->view('templates/header', $data);
		//$this->load->view('home');
		//$this->load->view('templates/footer');
        $data['content'] = 'index';
        $this->load->view('templates/template', $data);
	}

}
