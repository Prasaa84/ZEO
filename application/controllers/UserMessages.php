<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserMessages extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Common_model');
        $this->load->model('User_messages_model');
      
    }
   
    public function index(){
        if(is_logged_in()){
            if($this->session->userdata['userrole'] == 'School User'){
                $censusId = $this->session->userdata['census_id'];
                $condition = 'to_whom = "'.$censusId.'" ';
                $newMessages = $this->User_messages_model->get_all_new_messages_by($condition);
                $newMessageCount = $this->User_messages_model->get_new_message_count_by_category($condition);
            }else if($this->session->userdata['userrole'] == 'System Administrator'){
                //$to_whom = 'admin';
                //$to_whom = '07065';
                $condition = 'to_whom = "1" ';
                //$condition = 'to_whom = "'.$to_whom.'" ';
                //$condition = 'st.census_id = "'.$censusId.'" ';
                $newMessages = $this->User_messages_model->get_all_new_messages_by($condition);
                $newMessageCount = $this->User_messages_model->get_new_message_count_by_category($condition);
            }
            //print_r($newMessages); die();
            $data['title'] = 'New Messages';
            $data['newMessages'] = $newMessages;
            $data['newMessageCount'] = $newMessageCount;
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'messages/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('Login');
        }
    }
    public function sendMessage(){
        if ($this->input->post('submit') == "Send_message"){
            $date = date("Y-m-d");
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $company = $this->input->post('company');
            $toWhom = $this->input->post('to_whom_select');
            $subject = $this->input->post('subject');
            $msg = $this->input->post('message_txtarea');
            //die();
            $data = array(
                'msg_id' => '',
                'msg_cat_id' => 3,
                'stf_id' => '',  
                'name' => $name,
                'company' => $company,
                'phone_no' => $phone,   
                'email' => $email,                           
                'message' => $msg,
                'by_whom' => 'Guest User',
                'to_whom' => $toWhom,
                'academic_year' => '',
                'date_added' => $date,
                'date_updated' => $date,
                'is_deleted' => '',
                'is_read' => '',
                'when_read' => ''
            );
            $result = $this->User_messages_model->send_message($data);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Message sent successfully','class' => 'alert alert-success'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Message not sent!!!','class' => 'alert alert-danger'));
            }
        }
        redirect('GeneralInfo/contact#contact-page');   
    }
    public function viewMessage(){
        $output = array();  
        $year = date("Y");
        $msgId = $_POST['msg_id']; //die();
        $message = $this->User_messages_model->get_message_by_id($msgId);  
        //print_r($message_history); die();
        if(!empty($message)){
            $this->User_messages_model->update_message($msgId); 
            $output = '<table id="dataTable" class="table table-striped table-hover" cellspacing="0" width="300px;"><tr>
                          <th> Message </th><th> Sent Date </th><th> Read on </th>';
            foreach ($message as $row) {
                $output .= '<tr>';
                $output .= '<td>'.$row->message.'</td>';
                $output .= '<td>'.$row->date_added.'</td>';
                $output .= '<td>'.$row->when_read.'</td>';
                $output .= '</tr>';
            }
            $output .= '</table>'; 
        }else{
            $output = 'No message to view'; 
        }
        echo json_encode($output);  
    }

}