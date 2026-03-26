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
            if( $this->session->userdata['userrole_id'] == '1' ) {
                $condition = 'to_whom = 1';
            }elseif( $this->session->userdata['userrole_id'] == '2' ){
                $censusId = $this->session->userdata['census_id'];
                $condition = 'to_whom = "'.$censusId.'" ';
            }elseif( $this->session->userdata['userrole_id'] == '3' ){
                $condition = 'to_whom = 3 ';
            }elseif( $this->session->userdata['userrole_id'] == '4' ){
                $condition = 'to_whom = 4 ';
            }elseif( $this->session->userdata['userrole_id'] == '5' ){
                $condition = 'to_whom = 5 ';
            }elseif( $this->session->userdata['userrole_id'] == '6' ){
                $condition = 'to_whom = 6 ';
            }elseif( $this->session->userdata['userrole_id'] == '7' ){
                $divId = $this->session->userdata['div_id'];
                $condition = 'to_whom = "'.$divId.'" ';
            }elseif( $this->session->userdata['userrole_id'] == '8' ){
                $condition = 'to_whom = 8 ';
            }elseif( $this->session->userdata['userrole_id'] == '9' ){
                $condition = 'to_whom = 9 ';
            }
            $newMessages = $this->User_messages_model->get_all_new_messages($condition);
            $newMessageCount = $this->User_messages_model->get_new_message_count_by_category($condition);
            //print_r($newMessages); die();
            $data['title'] = 'New Messages';
            $data['newMessages'] = $newMessages;
            $data['newMessageCount'] = $newMessageCount;
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'messages/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }
    }
    // used in public site contact form too
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
                'when_read' => '',
                'replied_on' => '',
                'replied_by' => ''
            );
            $result = $this->User_messages_model->send_message($data);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Message sent successfully','class' => 'alert alert-success'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Message not sent!!!','class' => 'alert alert-danger'));
            }
        }
        redirect('GeneralInfo/contact/'.'t');   
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
    // when click on individual message notification
    public function viewMessageById(){
        if( is_logged_in() ){
            $msgId = $this->uri->segment(3);
            $this->User_messages_model->update_message($msgId); 
            $message = $this->User_messages_model->get_message_by_id($msgId);  
            $data['title'] = 'Message';
            $data['message'] = $message;
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'messages/message';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        } 
    }
    // reply to message
    public function replyToMessage(){
        if( is_logged_in() ){
            $msgId = $this->input->post('msg_id');
            $this->load->helper('email');       
            $this->form_validation->set_rules("name_txt","Name","required");
            $this->form_validation->set_rules("subject_txt","Subject","trim|required|min_length[3]");
            $this->form_validation->set_rules("email_txt","Email","trim|required");
            $this->form_validation->set_rules("reply_message_txtarea","Reply Message","required|min_length[10]");
            if ( $this->form_validation->run() == false ){
                //validation fails
                $this->session->set_flashdata('msg', array('text' => 'Name, Email Address, Subject and Reply Message are required!','class' => 'alert alert-danger'));
            }else{
                $name = $this->input->post('name_txt');
                $subject = $this->input->post('subject_txt');
                $email = $this->input->post('email_txt');
                $message = $this->input->post('reply_message_txtarea');
                $userRole = $this->session->userdata['userrole'];
                $newMessage = 'Hello '.'&nbsp; '.$name.'<br>';
                $newMessage .= $message;
                if( $this->Common_model->send_mail( $email, $subject, $newMessage ) ){
                    $updateResult = $this->User_messages_model->update_message_reply( $msgId, $userRole );
                }
                if( $updateResult ){
                    $this->session->set_flashdata('msg', array('text' => 'Email sent successfully','class' => 'alert alert-success'));
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'Email not sent!!!','class' => 'alert alert-danger'));
                }
            }
            
            $message = $this->User_messages_model->get_message_by_id($msgId);  
            $data['title'] = 'Message';
            $data['message'] = $message;
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'messages/message';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        } 
    }
    // used by user_admin_header to view notifications
    public function viewMessageNotifications(){ 
        //$year = date('Y');
        if( $this->session->userdata['userrole_id'] == '1' ) {
            $condition = 'mt.to_whom = 1 and mt.is_read = 0 ';
        }elseif( $this->session->userdata['userrole_id'] == '2' ){
            $censusId = $this->session->userdata['census_id'];
            $condition = 'mt.to_whom = "'.$censusId.'"  and mt.is_read = 0 ';
        }elseif( $this->session->userdata['userrole_id'] == '3' ){
            $condition = 'mt.to_whom = 3 and mt.is_read = 0 ';
        }elseif( $this->session->userdata['userrole_id'] == '4' ){
            $condition = 'mt.to_whom = 4 and mt.is_read = 0 ';
        }elseif( $this->session->userdata['userrole_id'] == '5' ){
            $condition = 'mt.to_whom = 5 and mt.is_read = 0 ';
        }elseif( $this->session->userdata['userrole_id'] == '6' ){
            $condition = 'mt.to_whom = 6 and mt.is_read = 0 ';
        }elseif( $this->session->userdata['userrole_id'] == '7' ){
            $divId = $this->session->userdata['div_id'];
            $condition = 'mt.to_whom = "'.$divId.'" and mt.is_read = 0 ';
        }elseif( $this->session->userdata['userrole_id'] == '8' ){
            $condition = 'mt.to_whom = 8 and mt.is_read = 0 ';
        }elseif( $this->session->userdata['userrole_id'] == '9' ){
            $condition = 'mt.to_whom = 9 and mt.is_read = 0 ';
        }
            $newMessages = $this->User_messages_model->get_all_new_messages($condition);
            //return $this->Alert_model->view_alert_by_to_whom($censusId);
            //echo $censusId.$year;

            $output = ' <h6 class="dropdown-header"> New Messages : </h6>
                            <div class="dropdown-divider"></div>';
            if(!empty($newMessages)){
                foreach ($newMessages as $message) {
                    $send_date = strtotime($message->send_date);
                    $date = date("Y-m-d",$send_date);
                    $time = date("h:i A",$send_date);
                    $output .=  '
                            <a class="dropdown-item" href=" '.base_url().'UserMessages/viewMessageById/'.$message->msg_id.' ">
                                <span class="text-info">
                                    <strong>'.$message->msg_category.'</strong>
                                </span><br>
                                <span class="small float-right text-muted">'.$date.' '.$time.'</span>
                                <div class="dropdown-message small">
                                    '.$message->message.'
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>';
                }
                $output .= '<a class="dropdown-item small" href=" '.base_url().'UserMessages ">View all Messages</a>';       
            }else{
                $output .=  '<a class="dropdown-item small" href="#">No new Messages</a>';
            }
        echo $output;
    }

    public function countNewMessages(){
        if(is_logged_in()){
            if( $this->session->userdata['userrole_id'] == '1' ) {
              $condition = 'to_whom = 1 ';
            }elseif( $this->session->userdata['userrole_id'] == '2' ){
              $censusId = $this->session->userdata['census_id'];
              $condition = 'to_whom = "'.$censusId.'" ';
            }elseif( $this->session->userdata['userrole_id'] == '3' ){
              $condition = 'to_whom = 3 ';
            }elseif( $this->session->userdata['userrole_id'] == '4' ){
              $condition = 'to_whom = 4 ';
            }elseif( $this->session->userdata['userrole_id'] == '5' ){
              $condition = 'to_whom = 5  ';
            }elseif( $this->session->userdata['userrole_id'] == '6' ){
              $condition = 'to_whom = 6  ';
            }elseif( $this->session->userdata['userrole_id'] == '7' ){
              $divId = $this->session->userdata['div_id'];
              $condition = 'to_whom = "'.$divId.'"  ';
            }elseif( $this->session->userdata['userrole_id'] == '8' ){
              $condition = 'to_whom = 8  ';
            }elseif( $this->session->userdata['userrole_id'] == '9' ){
              $condition = 'to_whom = 9  ';
            }
            echo $newMessageCount = $this->User_messages_model->get_new_message_count($condition);
        }
    }

}