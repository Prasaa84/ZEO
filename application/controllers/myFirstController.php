<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class myFirstController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('myFirstForm');

	}
	public function displayMessage(){
		return 'Hello World!';
	}
	public function validateMe(){
		$name = $this->input->post('studentname');
		$email = $this->input->post('email');
		$this->form_validation->set_rules('studentname','studentname','required');
		$this->form_validation->set_rules('email','email','required|valid_email');

		if($this->form_validation->run()){
			$this->load->view('success');
		}else{
			$this->load->view('myFirstForm');
		}
	}
}
