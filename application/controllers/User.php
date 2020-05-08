<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('School_model');
        $this->load->model('Physical_resource_model');
        $this->load->model('Alert_model');
        $this->load->model('User_messages_model');
        if(is_logged_in()){
            $this->new_msg_count = $this->new_message_count();
        }
        //print_r($this->new_msg_count); die();
        $this->no_of_national_schools = $this->count_national_schools(); // for pie chart in dashboard home
        $this->count_schools_by_type = $this->count_schools_by_type(); // for pie chart in dashboard home
        $this->recent_update_dt_school = $this->view_recent_sch_update_dt(); // for pie chart in dashboard update time
        $this->setPhysicalResourceAlert();  // when user comes to dashboard set alerts or update alerts
        $this->all_user_acts = $this->view_all_user_act();
        if(is_logged_in()){
            // when user comes to dashboard view alerts, if available        
            $this->phy_res_alert = $this->viewPhyResAlert(); 
        }
        $this->user_status = $this->user_status();
        $this->user_roles = $this->user_roles();
    }
    public function login(){
        // get the posted values
        $username = $this->input->post("txt_username");
        $password = $this->input->post("txt_password");

        // set validations
        $this->form_validation->set_rules("txt_username","Username","required");
        $this->form_validation->set_rules("txt_password","Password","required");
        if ($this->form_validation->run() == FALSE){
            //validation fails
            $this->viewLoginPage();
        }else{
            // validation succeeds
            if ($this->input->post('btn_login') == "Login"){
                //echo md5($password); die();
                //check if username and password is correct
                $usr_result = $this->User_model->get_user($username, $password);
                if ($usr_result > 0) {  //active user record is present
                    // get logged user's role 
                    $users = $this->User_model->get_current_user($username, $password);
                    foreach($users as $user){
                        $userid = $user['user_id'];
                        $role_id = $user['role_id'];
                        $rolename = $user['roll_name'];
                    }
                    if($rolename == "School User"){ // if logged user's role is School User
                        $school = $this->School_model->get_logged_school($userid);
                        foreach ($school as $row) {
                            $census_id = $row->census_id; // get logged school's id
                            $sch_name = $row->sch_name; // get logged school's name
                        }
                        // set session data
                        $sessiondata = array(
                            'census_id' =>$census_id,
                            'school_name' => $sch_name, 
                            'userid' => $userid,
                            'username' => $username,
                            'loginuser' => TRUE,
                            'userrole_id' => $role_id,
                            'userrole' => $rolename
                        );
                    }else{
                        $sessiondata = array( // set session data without school name
                            'userid' => $userid,
                            'username' => $username,
                            'loginuser' => TRUE,
                            'userrole_id' => $role_id,
                            'userrole' => $rolename
                        );
                    }   
                    $this->session->set_userdata($sessiondata); 
                    // when user comes to dashboard view alerts, if available
                    $this->phy_res_alert = $this->viewPhyResAlert(); 
                    // show message count
                    $this->new_msg_count = $this->new_message_count();
                    // insert data to user track table
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'user_track_id' => '',
                        'user_id' => $userid, // logged user
                        'key_on_row' => '',
                        'tbl_name' => '',
                        'act_type_id'=>'1',
                        'note' => 'Logged in to the system',
                        'date_added' => $now,
                        'is_deleted' => '',
                    );
                    $user_track = $this->User_model->add_user_act($data);
                    //print_r($this->session->userdata); die();
                    // check which user
                    if($role_id==1){
                        $data['title'] = 'System Administrator';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    }if($role_id==2){
                        $data['title'] = 'School User';
                        //$data['user_header'] = 'user_school_clerk_header';
                        //$data['user_content'] = 'user/clerk_school_dashboard';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    }if($role_id==3){
                        $data['title'] = 'Zonal User';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    }if($role_id==5){
                        $data['title'] = 'Zonal Director';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    }if($role_id==7){
                        $data['title'] = 'Divisioanl User';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    }
                    $this->load->view('templates/user_template', $data);
                }else{  // user does not exist
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                    redirect('GeneralInfo/loginPage');
                }
            }else{
                    redirect('GeneralInfo/loginPage');
            }
        }
    }  // end login 
    public function viewLoginPage(){
        $data['title'] = 'User Login Window';
        $data['content'] = 'general_info/login';
        $this->load->view('templates/template', $data);
    } 
    public function index(){
        if($this->session->userdata('loginuser')==1){
            if($this->session->userdata('userrole_id')==1){
                $data['title'] = 'System Administrator';
            }elseif($this->session->userdata('userrole_id')==2){
                $data['title'] = 'School User';
            }elseif($this->session->userdata('userrole_id')==3){
                $data['title'] = 'School Teacher';
            }elseif($this->session->userdata('userrole_id')==4){
                $data['title'] = 'Department User';
            }elseif($this->session->userdata('userrole_id')==5){
                $data['title'] = 'Zonal User';
            }elseif($this->session->userdata('userrole_id')==6){
                $data['title'] = 'Divisioanl User';
            }
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'user/admin_dashboard';              
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
        
    }
    public function logout(){
        $this->session->unset_userdata('session_data');
        $this->session->sess_destroy();
        redirect(base_url().'GeneralInfo/loginPage');
    }
    // this method called by this construct method to view all user status
    public function user_status(){ 
        return $this->User_model->get_all_user_status();
    } 
    // this method called by this construct method to get all user roles
    public function user_roles(){ 
        return $this->User_model->get_all_user_roles();
    }
    // this method called by this construct method to get all user roles
    public function view_all_user_act(){ 
        return $this->User_model->get_all_user_acts();
    }
    // this method called by this construct method
    public function count_national_schools(){ 
        return $this->School_model->count_national_schools();
    } 
    // this method called by this construct method
    public function count_1AB_schools1(){ 
        return $this->School_model->count_1AB_schools();
    }
    // this method called by this construct method
    public function count_1C_schools1(){ 
        return $this->School_model->count_1C_schools();
    }  
    // this method called by this construct method
    public function count_type2_schools1(){ 
        return $this->School_model->count_type2_schools();
    }   
    // this method called by this construct method
    public function count_type3_schools1(){ 
        return $this->School_model->count_type3_schools();
    } 
    // this method called by this construct method
    // no of school type wise is needed for pie chart in dashboard
    public function count_schools_by_type(){ 
        return $this->School_model->count_schools_by_type();
    } 
    // this method called by this construct method
    // view new messages count in dashboard
    public function new_message_count(){ 
        $userRole = $this->session->userdata['userrole'];
        if( $userRole == 'School User'){
            $censusId = $this->session->userdata['census_id'];
            //$censusId = '07065';
            $condition = 'to_whom = '.$censusId;
        }else if($userRole == 'System Administrator'){
            $condition = 'to_whom = "1" ';
        }
        return $this->User_messages_model->get_new_message_count($condition);
    }
    // view recent updated date and time of school details
    // this is called by construct method
    public function view_recent_sch_update_dt(){ 
        return $this->School_model->view_recent_sch_update_dt();
    } 
    public function setPhysicalResourceAlert(){
        $allSchools = $this->School_model->view_all_schools();
        foreach ($allSchools as $row) {
            $censusId = $row->census_id;
            $result = $this->Physical_resource_model->get_short_phy_res_details($censusId); // $result = shortage of physical resource updation
            if($result){
                $to = $censusId; $cat_id = '1'; // cat_id = 1 means physical resource in alert categories
                $add = $this->Alert_model->addAlert($result,$to,$cat_id);
            }
        }
    } 
    // view physical resource alerts
    // this is called by construct method
    public function viewPhyResAlert(){ 
        if($this->session->userdata['userrole'] == 'School User'){
            $censusId = $this->session->userdata['census_id'];
            //$censusId = '07065';
            return $this->Alert_model->view_alert_by_to_whom($censusId);
        }else{
            $cat_id = '1';
            return $this->Alert_model->view_alerts_by_category($cat_id);
        }
    } 
    public function viewUsers(){
        if(is_logged_in()){
            $userrole = $this->session->userdata['userrole_id'];
            if($userrole == 1){ // check admin
                $userDetails = $this->User_model->view_all_users(); 
                if(!$userDetails){
                    $this->session->set_flashdata('user_msg', array('text' => 'No records found!!!','class' => 'alert alert-danger'));
                }else{
                    $data['user_details'] = $userDetails;
                }
            }
            $data['title'] = 'User Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'user/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // Ajax call to viewUsers view, when click on view data button
    public function viewUserInfoByUserId(){
        $userId = $this->input->post('userId');
        $userDetails = $this->User_model->get_user_info_by_userid($userId); 
        if(!empty($userDetails)){
            $output = '';
            foreach($userDetails as $row){
                $output .= '
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped table-hover" align="center" id="userInfoTblAjax">
                                <tr>
                                    <th class="col-lg-4"> User ID </th>
                                    <td class="col-lg-8">'.$row->u_id.'</td>
                                </tr>
                                <tr>
                                    <th> User Name </th>
                                    <td>'.$row->username.'</td>                                   
                                </tr>                                   
                                <tr>
                                    <th><b>User Role</b></th>
                                    <td>'.$row->roll_name.'</td>                                    
                                </tr>   
                                <tr>
                                    <th><b>User Status</b></th>
                                    <td>'.$row->status_type.'</td>                                  
                                </tr>
                                <tr>
                                    <th><b> School </b></th>
                                    <td>'.$row->sch_name.'</td>                                  
                                </tr>
                                <tr>
                                    <th><b> Census ID </b></th>
                                    <td>'.$row->census_id.'</td>                                  
                                </tr>
                            </table>
                        </div>
                    </div>';
            }
            echo $output;
        }else{
            echo 'No records found!!!';
        }
    }
    public function changeUser(){
        if(is_logged_in() && $this->session->userdata('loginuser')==1){ // only the admin allowed
            if($this->input->post('btn_change_user')=='ChangeStatus'){
                if(!empty($this->input->post('select_user_status')) && !empty($this->input->post('chkbox'))){
                    $userStatus = $this->input->post('select_user_status');
                    //echo $userStatus;
                    $user = $this->input->post('chkbox'); 
                    //print_r($user); die();
                    $result = $this->User_model->update_user_status($user,$userStatus);
                    if($result){
                        $this->session->set_flashdata('userChangeMsg', array('text' => 'User status has been changed successfully','class' => 'alert alert-success'));
                    }else{
                        $this->session->set_flashdata('userChangeMsg', array('text' => 'Error in changing user status','class' => 'alert alert-danger'));
                    }
                }else{
                    $this->session->set_flashdata('userChangeMsg', array('text' => 'Please select both user and user status','class' => 'alert alert-danger'));
                }
            }
            if($this->input->post('btn_change_user')=='ChangeRole'){
                if(!empty($this->input->post('select_user_role')) && !empty($this->input->post('chkbox'))){
                    $userRole = $this->input->post('select_user_role');
                    //echo $userStatus;
                    $user = $this->input->post('chkbox'); 
                    //print_r($user); die();
                    $result = $this->User_model->update_user_role($user,$userRole);
                    if($result){
                        $this->session->set_flashdata('userChangeMsg', array('text' => 'User role has been changed successfully','class' => 'alert alert-success'));
                    }else{
                        $this->session->set_flashdata('userChangeMsg', array('text' => 'Error in changing user role','class' => 'alert alert-danger'));
                    }
                }else{
                    $this->session->set_flashdata('userChangeMsg', array('text' => 'Please select both user and user role','class' => 'alert alert-danger'));
                }
            }
            if($this->input->post('btn_change_user')=='setDefUnamePwd'){
                if(!empty($this->input->post('chkbox'))){
                    $user = $this->input->post('chkbox'); 
                    $successCount = 0;
                    $errorCount = 0;
                    foreach ($user as $user) {
                        $userRole = $this->User_model->get_user_role($user);  
                        foreach($userRole as $userRole){
                            $userRoleId = $userRole->role_id;
                        }
                        //echo $userRoleId; die();
                        if($userRoleId==1){ // school user
                            $username = 'admin';
                            $password = md5('admin');
                        }else if($userRoleId==2){ // school user
                            $username = 'school_user';
                            $result = $this->School_model->find_census_by_userid($user);
                            foreach($result as $result){
                                $censusId= $result->census_id;
                            } 
                            // die();
                            $password = md5($censusId);
                            //echo $password; die();
                        }else if($userRoleId==3){ // Zonal user
                            $username = 'zonal_user';
                            $password = md5('zonaluser');
                        }else if ($userRoleId==4) { // department user
                            $username = 'department_user';
                            $password = md5('depuser');
                        }else if ($userRoleId==5) { // director
                            $username = 'director';
                            $password = md5('director');
                        }else if ($userRoleId==6) { // assdirector
                            $username = 'assdirector';
                            $password = md5('assdirector');
                        }  
                        $result = $this->User_model->update_to_def_uname_pwd($user,$username,$password);
                        //die();
                        if($result==true){
                            $successCount++;
                        }else{
                            $errorCount++;
                        }
                    }
                    if($successCount>0){
                        $this->session->set_flashdata('userChangeMsg', array('text' => $successCount.' Successfull, '.$errorCount.' not Successfull','class' => 'alert alert-success'));
                    }else{
                        $this->session->set_flashdata('userChangeMsg', array('text' => $errorCount.' not Successfull','class' => 'alert alert-danger'));
                    }
                }else{
                    $this->session->set_flashdata('userChangeMsg', array('text' => 'Please select a user','class' => 'alert alert-danger'));
                }
            }
            $this->viewUsers();
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function viewUserLogPage(){
        if(is_logged_in() && $this->session->userdata('loginuser')==1){ // only the admin allowed
            $data['title'] = 'User Log Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'user/userLog';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function viewUserLog(){
        if(is_logged_in() && $this->session->userdata('loginuser')==1){
            $userId = $this->input->post('userid_txt');
            $censusId = $this->input->post('censusid_txt');
            $fromDate = $this->input->post('frmdate_txt');
            $toDate = $this->input->post('todate_txt');
            $userAct = $this->input->post('select_user_act');
            if(empty($userId) && empty($censusId) && empty($fromDate) && empty($toDate) && empty($userAct)){
                $this->session->set_flashdata('userLogMsg', array('text' => 'Please feed data to atleast one field','class' => 'alert alert-danger'));
            }else{
                if(!empty($userId)){
                    $userLogDetails = $this->User_model->view_user_log_by_user_id($userId); 
                }else if(!empty($censusId)){
                    $userLogDetails = $this->User_model->view_user_log_by_census_id($censusId);
                }else if(!empty($fromDate) && !empty($toDate)){
                    $userLogDetails = $this->User_model->view_user_log_by_period($fromDate,$toDate);
                }else if(!empty($userAct)){
                    $userLogDetails = $this->User_model->view_user_log_by_action($userAct);
                }else if(!empty($fromDate)){
                    $date = new DateTime($fromDate);
                    $newDate = $date->format('Y-m-d');
                    $userLogDetails = $this->User_model->view_user_log_by_date($newDate);
                    print_r($userLogDetails); die();
                }else if(!empty($toDate)){
                    $date = new DateTime($toDate);
                    $newDate = $date->format('Y-m-d');
                    $userLogDetails = $this->User_model->view_user_log_by_date($newDate);
                }
                $data['user_log_details'] = $userLogDetails;
            }
            $data['title'] = 'User Log Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'user/userLog';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function loginRecover(){
        if($this->input->post('btn_recover')=='RecoverUnPwd'){
            $this->form_validation->set_rules("email_txt","Email","required|valid_email");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"> Required a correct email!</div>');
                $this->viewLoginPage();
                //redirect('GeneralInfo/loginPage');
            }else{
                $email = $this->input->post('email_txt');
                $emailExists = $this->User_model->check_email_exists($email);
                if($emailExists){
                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center"> Your username and password has been sent to email!</div>');
                }else{
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"> Email does not exists!</div>');
                }
            }
        }
        redirect('GeneralInfo/loginPage');
    }
    // load username and password change view for every user
    public function UnmPwdChangeView(){
        if(is_logged_in()){ // only the logged users allowed
            $userId = $this->session->userdata('userid');
            $userData = $this->User_model->get_user_info_by_userid($userId);
            $data['userData'] = $userData;
            $data['title'] = 'User Settings';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'user/unm_pwd_change';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // change username by user
    public function changeUnm(){
        if(is_logged_in() && $this->input->post('btn_change_unm')=='Change'){ // only the admin allowed
            $this->form_validation->set_rules("cur_uname_txt","Current Username","required");
            $this->form_validation->set_rules("new_uname_txt","New Username","required|min_length[5]|max_length[11]");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->UnmPwdChangeView();
            }else{
                $userId = $this->input->post('user_id_hidden');
                $curUserName = $this->input->post('cur_uname_txt');
                $newUserName = $this->input->post('new_uname_txt');
                $curUserNameExists = $this->User_model->check_unm_exists($userId,$curUserName);
                if($curUserNameExists){
                    $changeUnm = $this->User_model->change_username($userId,$newUserName); 
                    if($changeUnm){
                         $now = date('Y-m-d H:i:s');
                        $data = array(
                            'user_track_id' => '',
                            'user_id' => $userId, // logged user
                            'key_on_row' => $userId,
                            'tbl_name' => 'user_tbl',
                            'act_type_id'=>'3', // update
                            'note' => 'Changed the username',
                            'date_added' => $now,
                            'is_deleted' => '',
                        );
                        $user_track = $this->User_model->add_user_act($data);
                        $this->session->set_flashdata('changeMsg', array('text' => 'Username changed successfully','class' => 'alert alert-success'));
                    }else{
                        $this->session->set_flashdata('changeMsg', array('text' => 'Username not changed','class' => 'alert alert-danger'));
                    }
                }else{
                    $this->session->set_flashdata('changeMsg', array('text' => 'Username does not exist','class' => 'alert alert-danger'));
                }
                $this->UnmPwdChangeView();
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // change password by user
    public function changePwd(){
        if(is_logged_in() && $this->input->post('btn_change_pwd')=='Change'){ // only the user allowed
            $this->form_validation->set_rules("old_pwd_txt","Current Password","required");
            $this->form_validation->set_rules("new_pwd_txt","New Password","required|min_length[5]|max_length[10]");
            $this->form_validation->set_rules("confirm_new_pwd_txt","New Password confirmation","required|matches[new_pwd_txt]");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->UnmPwdChangeView();
            }else{
                $userId = $this->input->post('user_id_hidden');
                $curPwd = $this->input->post('old_pwd_txt');
                $newPwd = $this->input->post('new_pwd_txt');
                $confirmNewPwd = $this->input->post('confirm_new_pwd_txt');
                //if()
                $curPwdExists = $this->User_model->check_pwd_exists($userId,md5($curPwd));
                if($curPwdExists){
                    $changePwd = $this->User_model->change_pwd($userId,md5($newPwd)); 
                    if($changePwd){
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'user_track_id' => '',
                            'user_id' => $userId, // logged user
                            'key_on_row' => $userId,
                            'tbl_name' => 'user_tbl',
                            'act_type_id'=>'3', // update
                            'note' => 'Changed the password',
                            'date_added' => $now,
                            'is_deleted' => '',
                        );
                        //$user_track = $this->User_model->add_user_act($data); 
                        $userInfo = $this->User_model->get_user_info_by_userid($userId);
                        foreach ($userInfo as $user) {
                            $email = $user->email;
                        }
                        //echo $email; die();
                        if(!empty($email)){
                            // set email
                            $ci = get_instance();
                            $ci->load->library('email');
                            $config['protocol'] = "smtp";
                            $config['smtp_host'] = "ssl://smtp.gmail.com";
                            $config['smtp_port'] = "465";
                            $config['smtp_user'] = "mgpprasan@gmail.com"; 
                            $config['smtp_pass'] = "babi2015";
                            $config['charset'] = "utf-8";
                            $config['mailtype'] = "html";
                            $config['newline'] = "\r\n";

                            $ci->email->initialize($config);

                            $ci->email->from('mgpprasan@gmail.com', 'Deniyaya Zonal Education Office');
                            //$list = "mgpprasan@yahoo.com";
                            $ci->email->to($email);

                            $this->email->reply_to('mgpprasan@gmail.com', 'Reply with your comments..');
                            $this->email->subject('Confirmation Message');
                            $message = '';
                            $message .= '<p>Your user password is :<strong>&nbsp;'.$newPwd.'</strong>,</p>';
                            $message .= '<p>Your account details were changed as above. Please use above details with zonal office system</p>';
                            $message .='<p>Thank you!</p>';
                            $this->email->message($message);
                             //Send mail 
                            if($this->email->send()){ 
                                $this->session->set_flashdata("email_sent",array('text' => 'Email sent successfully','class' => 'alert alert-success')); 
                            }else {
                                $this->session->set_flashdata("email_sent",array('text' => 'Error in sending Email.','class' => 'alert alert-danger')); 
                            }    
                        }else{
                            
                        }
                        //echo $this->email->print_debugger(); die();
                        $this->session->set_flashdata('changePwdMsg', array('text' => 'Password changed successfully','class' => 'alert alert-success'));
                    }else{
                        $this->session->set_flashdata('changePwdMsg', array('text' => 'Password not changed!','class' => 'alert alert-danger'));
                    }
                }else{
                    $this->session->set_flashdata('changePwdMsg', array('text' => 'Current password is wrong!','class' => 'alert alert-danger'));
                }
                $this->UnmPwdChangeView();
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } // end changePwd method
    public function addUserByAdmin(){
        if(is_logged_in()){ // only the logged users allowed
            //$this->form_validation->set_rules("userid_txt","User ID","required");
            $this->form_validation->set_rules("user_role_select","User Role","required");
            $this->form_validation->set_rules("usernm_txt","User Name","required");
            $this->form_validation->set_rules("user_status_select","User Status","required");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">All the fields are required!</div>');
                $this->viewUsers();
            }else{
                $uid = $this->input->post('userid_txt');
                $uname = $this->input->post('usernm_txt');
                if($this->User_model->check_unm_exist($uname)){
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Username already exists!!!</div>');
                    $this->viewUsers();  
                }else{
                    $pwd = $uname.'123';
                    $pwd = md5($pwd); 
                    $now = date("Y-m-d H:i:s");
                    //die();
                    $data = array(
                        'user_id' => '', // admin
                        'role_id' => $this->input->post('user_role_select'), 
                        'username' => $this->input->post('usernm_txt'),
                        'password' => $pwd,                    
                        'status_id'=> $this->input->post('user_status_select'),
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    $result = $this->User_model->add_user($data);
                    if(!$result){
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">User was not added!</div>');
                    }else{
                        $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User was added successfully</div>');
                        $this->viewUsers();
                    }
                }
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } 
    public function deleteUser(){
         if(is_logged_in() && $this->session->userdata['userrole'] == 'System Administrator'){
            $uid = $this->uri->segment(3);
            $user = $this->User_model->get_user_info_by_userid($uid);
            foreach ($user as $row) {
                $user_role_id = $row->role_id;
            }
            //die();
            if($user_role_id==1 or $user_role_id==2){
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Admin or School user can not be deleted!</div>');
            }else{
                $deleteUser = $this->User_model->delete_user($uid);  // delete user data from user_tbl
                //die();
                if($deleteUser){
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User deleted successfully </div>');
                }else{
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">User could not be deleted!</div>');
                }
            }
            $this->viewUsers();
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }   

}
?>