<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BirthDayMessage extends CI_Controller {

    public function __construct(){

        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Common_model');
        $this->load->model('BirthDay_message_model');
        if(is_logged_in()){
            $this->userId = $this->session->userdata['userid'];
            $this->userRole = $this->session->userdata['userrole'];
            $this->userRoleId = $this->session->userdata['userrole_id'];
        } 
    }
    // used to view yellow circle in user header
    public function countNewBirthDays(){
        if(is_logged_in()){
            $today = date("m-d");  // today month and date ex - 01-23 - 23rd january
            if( $this->session->userdata['userrole_id'] == '1' ) { // admin
              $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
            }elseif( $this->session->userdata['userrole_id'] == '2' ){ // school
              $censusId = $this->session->userdata['census_id'];
              $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" and st.census_id = "'.$censusId.'" ';
            }elseif( $this->session->userdata['userrole_id'] == '3' ){ // zonal user
              $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
            }elseif( $this->session->userdata['userrole_id'] == '4' ){ // department user
              $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
            }elseif( $this->session->userdata['userrole_id'] == '5' ){ // zonal director
              $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
            }elseif( $this->session->userdata['userrole_id'] == '6' ){ // zonal assistant director
              $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
            }elseif( $this->session->userdata['userrole_id'] == '7' ){ // divisional user
              $divId = $this->session->userdata['div_id'];
              $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" and sdt.div_id = "'.$divId.'"  ';
            }elseif( $this->session->userdata['userrole_id'] == '8' ){ // zonal file section
              $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
            }elseif( $this->session->userdata['userrole_id'] == '9' ){ // zonal salary section 
              $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
            }
            echo $newBirthDayCount = $this->BirthDay_message_model->get_new_birthday_count($condition);
        }
    }
     // used by user_admin_header to view notifications, when click on birthday cake icon
     public function viewBirthDayNotifications(){ 
        $today = date("m-d");  // today month and date ex - 01-23 - 23rd january
        if( $this->session->userdata['userrole_id'] == '1' ) { // admin
            $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
        }elseif( $this->session->userdata['userrole_id'] == '2' ){ // school
            $censusId = $this->session->userdata['census_id'];
            $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" and st.census_id = "'.$censusId.'" ';
        }elseif( $this->session->userdata['userrole_id'] == '3' ){ // zonal user
            $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
        }elseif( $this->session->userdata['userrole_id'] == '4' ){ // department user
            $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
        }elseif( $this->session->userdata['userrole_id'] == '5' ){ // zonal director
            $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
        }elseif( $this->session->userdata['userrole_id'] == '6' ){ // zonal assistant director
            $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
        }elseif( $this->session->userdata['userrole_id'] == '7' ){ // divisional user
            $divId = $this->session->userdata['div_id'];
            $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" and sdt.div_id = "'.$divId.'"  ';
        }elseif( $this->session->userdata['userrole_id'] == '8' ){ // zonal file section
            $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
        }elseif( $this->session->userdata['userrole_id'] == '9' ){ // zonal salary section 
            $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
        }
        $staffInfo = $this->BirthDay_message_model->get_all_new_birthdays($condition);
        //return $this->Alert_model->view_alert_by_to_whom($censusId);
        //echo $censusId.$year;

        $output = ' <h6 class="dropdown-header"> Today Birthdays : </h6>
                        <div class="dropdown-divider"></div>';
        if(!empty($staffInfo)){
            foreach ($staffInfo as $staff) {
                $dob = strtotime($staff->dob);
                $date = date("Y-m-d",$dob);
                if($this->userRoleId==2){
                    $desc = 'Happy Birthday';
                }else{
                    $desc = $staff->sch_name;
                }
                $output .=  '
                        <a class="dropdown-item" href="'.base_url().'BirthDayMessage">
                            <span style="color:orange;">
                                <strong><i class="fa fa-fw fa-birthday-cake"></i>'.$staff->name_with_ini.'</strong>
                            </span>
                                <span class="small float-right text-muted">'.$date.'</span>
                            <div class="dropdown-message small">
                                '.$desc.'
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>';
            }
            $output .= '<a class="dropdown-item small" href=" '.base_url().'BirthDayMessage ">View all Messages</a>';       
        }else{
            $output .=  '<a class="dropdown-item small" href="#">No Birthdays</a>';
        }
        echo $output;
    }
    // sending birthday wish through email, this function to be added as a cron job in live server
    public function sendBirthDayWishEmail(){
        $today = date("m-d");  // today month and date ex - 01-23 - 23rd january
        $year = date('Y');
        $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
        $staffInfo = $this->BirthDay_message_model->get_all_new_birthdays($condition);
        $success = 0;
        $fail = 0;
        $alreadySent = 0;
        $birthDayCount = 0;
        foreach( $staffInfo as $staff ) {
            $title = $staff->title;
            $stfId = $staff->stf_id;
            $stfName = $staff->name_with_ini;
            $toEmail = $staff->stf_email;
            $subject = 'Happy Birth Day';
            $message = 'Happy birth day '.$title.'&nbsp; '.$stfName.'<br>';
            $message .= 'We are wishing you a wonderful birthday today!'.'<br>';
            $message .= '<br>';
            $message .= 'From<br>';
            $message .= 'Zonal Education Office, Deniyaya';
            //$designation = $staff->desig_type;
            $emailSent = $this->BirthDay_message_model->get_birthday_message_email($stfId, $year);
            if( !$emailSent ){                
                if( $this->Common_model->send_mail($toEmail,$subject,$message) ){
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'bm_id' => '',
                        'stf_id' => $stfId,
                        'email_sent_dt' => $now,
                        'sms_sent_dt' => '',
                    );
                    $this->BirthDay_message_model->insert_birthday_message_sending_info($data);
                    $success += 1;
                }else{
                    $fail += 1;
                }
            }else{
                $alreadySent += 1;
            }
            $birthDayCount += 1;
        }
        echo 'All Birthdays Count : '.$birthDayCount.'<br>';
        echo 'Success Count : '.$success.'<br>';
        echo 'Fail Count : '.$fail.'<br>';
        echo 'Sent Earlier Count : '.$alreadySent.'<br>';
        //die();
    }
    // send birthday wish through sms. this function to be added as a cron job in live server
    public function sendBirthDayWishSms(){
        $today = date("m-d");  // today month and date ex - 01-23 - 23rd january
        $year = date('Y');
        $condition = 'date_format(st.dob,"%m-%d") = "'.$today.'" ';
        $staffInfo = $this->BirthDay_message_model->get_all_new_birthdays($condition);
        $success = 0;
        $fail = 0;
        $alreadySent = 0;
        $birthDayCount = 0;
        foreach ( $staffInfo as $staff ) {
            $title = $staff->title;
            $stfName = $staff->name_with_ini;
            $stfId = $staff->stf_id;
            if ( !empty($staff->phone_mobile1) ) {
                $phoneNo = $staff->phone_mobile1;
            }else{
                $phoneNo = $staff->phone_mobile2;
            }
            $smsMessage = 'Happy Birthday '.$title.' '.$stfName;
            $smsMessage .= "\n From: ZEO,Deniyaya";
            $emailMessage = $this->BirthDay_message_model->get_birthday_message_email($stfId, $year); // check the email message has been sent 
            //print_r($message); die();
            //if($phoneNo=='0715885993'){
            $sendSms = $this->Common_model->send_sms($phoneNo, $smsMessage); // send sms
            //}
            $now = date('Y-m-d H:i:s');
            // store the sms sending information in database
            if( $sendSms ){
                if( !empty($emailMessage) ){ // if email messages has been sent, update the record
                    foreach ($emailMessage as $row) {
                        $id = $row->bm_id;
                    }
                    $data = array(
                        'bm_id' => $id,
                        'stf_id' => $stfId,
                        'sms_sent_dt' => $now,
                    );
                    $this->BirthDay_message_model->update_birthday_message_sending_info($data);
                }else{ // if email message not sent, insert new record.
                    $data = array(
                        'bm_id' => '',
                        'stf_id' => $stfId,
                        'email_sent_dt' => '',
                        'sms_sent_dt' => $now,
                    );
                    $this->BirthDay_message_model->insert_birthday_message_sending_info($data);
                }  
                $success += 1;                      
            }else{
                $fail += 1;
            }
            $birthDayCount += 1;
        }
        echo 'All Birthdays Count : '.$birthDayCount.'<br>';
        echo 'Success Count : '.$success.'<br>';
        echo 'Fail Count : '.$fail.'<br>';
        echo 'Sent Earlier Count : '.$alreadySent.'<br>';
    }
   

}