<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('School_model');
        $this->load->model('Physical_resource_model');
        $this->load->model('Alert_model');
        // load chart when user login 
        $this->no_of_national_schools = $this->count_national_schools();
        $this->count_schools_by_type = $this->count_schools_by_type();    
        $this->recent_update_dt_school = $this->view_recent_sch_update_dt();
        // alerts
    }
    public function index(){
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
                $usr_result = $this->login_model->get_user($username, $password);
                if ($usr_result > 0) {  //active user record is present
                    // get logged user's role 
                    $users = $this->login_model->get_current_user($username, $password);
                    foreach($users as $user){
                        $userid = $user['user_id'];
                        $role_id = $user['role_id'];
                        $rolename = $user['roll_name'];
                    }
/*                    //set the session variables
                    $sessiondata = array(
                        'userid' => $userid,
                        'username' => $username,
                        'loginuser' => TRUE,
                        'userrole_id' => $role_id,
                        'userrole' => $rolename
                    );  */
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
                    $this->setPhysicalResourceAlert();
                    $this->phy_res_alert = $this->viewPhyResAlert();
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
                        $data['title'] = 'School Teacher';
                        //$data['user_header'] = 'user_school_teacher_header';
                        //$data['user_content'] = 'user/teacher_dashboard';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    }
                    //redirect("index");
                    $this->load->view('templates/user_template', $data);
                }else{  // user does not exist
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                    redirect('GeneralInfo/loginPage');
                }
            }else{
                    redirect('GeneralInfo/loginPage');
            }
        }
    }
    public function viewLoginPage(){
        $data['title'] = 'User Login Window';
        $data['content'] = 'general_info/login';
        $this->load->view('templates/template', $data);
    }
    // this method called by this construct method
    public function count_national_schools(){ 
        return $this->School_model->count_national_schools();
    } 
    // this method called by this construct method
    public function count_schools_by_type(){ 
        return $this->School_model->count_schools_by_type();
    }
    // view recent updated date and time of school details
    // this is called by construct method
    public function view_recent_sch_update_dt(){ 
        return $this->School_model->view_recent_sch_update_dt();
    }
    public function setPhysicalResourceAlert(){
        $censusId = '07065';
        $result = $this->Physical_resource_model->get_short_phy_res_details($censusId);
        if($result){
            $to = '07065'; $cat_id = '1';
            $add = $this->Alert_model->addAlert($result,$to,$cat_id);
        }
    }  
    // view physical resource alerts
    // this is called by construct method
    public function viewPhyResAlert(){ 
        $censusId = '07065';
        return $this->Alert_model->view_alert_by_to_whom($censusId);
    } 
}