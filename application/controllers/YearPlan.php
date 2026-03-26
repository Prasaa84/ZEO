<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class YearPlan extends CI_Controller {

    //public $userRole = $this->session->userdata['userrole'];

    public function __construct(){
        parent::__construct();
        //$this->load->model('Staff_model');
        //$this->load->model('Common_model');
        $this->load->model('YearPlan_model');
    }
    public function index(){
        if(is_logged_in()){
            $limit = 10;
            $latestEvents = $this->YearPlan_model->get_all_events($limit);
            $limit = '';
            $eventStartDate = $this->YearPlan_model->get_event_start_date(); // to make archive in the view
            $data['title'] = 'Recent Events';
            $data['heading'] = 'Recent Events of the Year Plan';
            $data['events'] = $latestEvents;
            $data['eventStartDate'] = $eventStartDate; 
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'yearplan/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('Login');
        }
    }
     // loading event update view
    public function eventUpdateView(){ 
        if(is_logged_in()){
            $eventId = $this->uri->segment(3);
            $result = $this->YearPlan_model->get_event_by_id($eventId);
            //print_r($result); die();
            $data['event'] = $result;
            $data['title'] = 'Updating Event';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'yearplan/editEvent';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update 
    public function updateEvent(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_event') == "Update"){
                $eventId = $this->input->post('event_id_hidden');
                $this->form_validation->set_rules("title_txtarea","Event Title","trim|required");
                $this->form_validation->set_rules("text_txtarea","Event Description","trim|required");
                $this->form_validation->set_rules("start_event_txt","Event Start Time","trim|required");
                $this->form_validation->set_rules("end_event_txt","Event End Time","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    //redirect('news/newsUpdateView/'.$newsId);
                    $this->afterUpdateEvent($eventId);
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'id' => $this->input->post('event_id_hidden'),
                        'title' => $this->input->post('title_txtarea'), // news heading
                        'description' => $this->input->post('text_txtarea'),  // news text

                        'start_event' => $this->input->post('start_event_txt'),  // news text
                        'date_updated' => $now,
                        'end_event' => $this->input->post('end_event_txt'),  // news text
                    );      
                    //print_r($data); die();    
                    $result = $this->YearPlan_model->update_event($data);
                    if($result){
                        $this->session->set_flashdata('msg', array('text' => 'Event updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'Error in updating the event','class' => 'alert alert-danger','update'=>'false'));
                    }
                    $this->afterUpdateEvent($eventId);
                }
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // this is used to go back after item status details are updated
    public function afterUpdateEvent($id){ 
        if(is_logged_in()){
            $eventId = $id; 
            $result = $this->YearPlan_model->get_event_by_id($eventId);
            $data['event'] = $result;
            $data['title'] = 'Updating Event';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'yearplan/editEvent';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function viewEventsByMonth(){
        $yearMonth = $this->uri->segment(3);
        $parts = explode('-', $yearMonth);
        $year = $parts[0];
        $month = $parts[1]; // month number
        $monthName = date("F", mktime(0, 0, 0, $month, 10)); // convert month number to month name
        $condition = 'date_format(start_event,"%Y-%m") = "'.$yearMonth.'" ';
        $result = $this->YearPlan_model->get_event_by($condition);
        $eventStartDate = $this->YearPlan_model->get_event_start_date(); // to make archive in the view
        //print_r($result); die();
            $data['title'] = 'Events for the Month of '.$monthName.', '.$year;
            $data['heading'] = 'Events for the Month of '.$monthName.', '.$year;
            $data['events'] = $result; // this news variable is used in index function too
            $data['eventStartDate'] = $eventStartDate;  // to create the archive in news index page 
        if(is_logged_in()){
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'yearplan/index';
            $this->load->view('templates/user_template', $data);    
        }else{
            //$data['content'] = 'general_info/news';
            redirect('GeneralInfo/loginPage');
            //$this->load->view('templates/template', $data);
        }  
    }
    public function addEvent(){ 
        if(is_logged_in()){
            if ($this->input->post('btn_add') == "Add_New"){
                $this->form_validation->set_rules("title_txtarea","Event Title","trim|required");
                $this->form_validation->set_rules("text_txtarea","Event Description","trim|required");
                $this->form_validation->set_rules("start_event_txt","Event Begin","trim|required");
                $this->form_validation->set_rules("end_event_txt","Event End","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                    redirect('YearPlan');
                }else{ 
                    $userRole = $this->session->userdata['userrole'];  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'id' => '',
                        'title' => $this->input->post('title_txtarea'), // news heading
                        'description' => $this->input->post('text_txtarea'),  // news text
                        'start_event' => $this->input->post('start_event_txt'),  // news text
                        'end_event' => $this->input->post('end_event_txt'),  // news text
                        'date_added' => $now, 
                        'date_updated' => $now,
                        'is_deleted' => ''
                    );      
                    //print_r($data); die();    
                    $result = $this->YearPlan_model->add_event($data);
                    if($result){
                        $this->session->set_flashdata('msg', array('text' => 'Event inserted successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'Error in inserting the event','class' => 'alert alert-danger','update'=>'false'));
                    }
                    redirect('YearPlan');
                }
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function deleteEvent(){
        $eventId = $this->input->post('event_id');
        $now = date('Y-m-d H:i:s');     
        //print_r($data); die();    
        $result = $this->YearPlan_model->delete_event($eventId,$now);
        if($result){
            echo 'true';
        }else{
            echo 'false';
        }
    }

}