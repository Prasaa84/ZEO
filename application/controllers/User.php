<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('School_model');
        $this->load->model('Staff_model');
        $this->load->model('Physical_resource_model');
        $this->load->model('Alert_model');
        $this->load->model('User_messages_model');
        $this->load->model('Student_model');
        $this->load->model('Common_model');
        if (is_logged_in()) {
            $this->all_schools_count = $this->count_all_schools(); // for cards in dashboard home
            $this->all_students_count = $this->count_all_students(); // for cards in dashboard home 
            $this->all_ac_staff_count = $this->count_all_academic_staff(); // for cards in dashboard home 
            $this->new_msg_count = $this->new_message_count();
            $this->count_schools_by_type = $this->count_schools_by_type(); // for pie chart in dashboard home
            $this->count_schools_by_devision = $this->count_schools_by_division(); // for pie chart in dashboard home
            $this->count_schools_by_belongsTo = $this->count_schools_by_belongsTo(); // for pie chart in dashboard home
            $this->all_academic_staff_count_genderwise = $this->view_all_school_staff_count_genderwise(); // for pie chart in dashboard home
            $this->all_student_count_genderwise = $this->view_all_student_count_genderwise(); // for dashboard
            //print_r($this->all_student_count_genderwise); die();
            $this->userrole = $this->session->userdata['userrole'];
            $this->userrole_id = $this->session->userdata['userrole_id'];
        }
        //$this->setPhysicalResourceAlert();  // when user comes to dashboard set alerts or update alerts
        $this->all_user_acts = $this->view_all_user_act();
        //if(is_logged_in()){
        // when user comes to dashboard view alerts, if available        
        //$this->phy_res_alert = $this->viewPhyResAlert(); 
        //}
        $this->user_status = $this->user_status();
        $this->user_roles = $this->user_roles();
    }
    public function login()
    {
        // get the posted values
        $username = $this->input->post("txt_username");
        $password = $this->input->post("txt_password");

        // set validations
        $this->form_validation->set_rules("txt_username", "Username", "required");
        $this->form_validation->set_rules("txt_password", "Password", "required");
        if ($this->form_validation->run() == FALSE) {
            //validation fails
            $this->viewLoginPage();
        } else {
            // validation succeeds
            if ($this->input->post('btn_login') == "Login") {
                //check if username and password is correct
                $usr_result = $this->User_model->get_user($username, $password);
                if ($usr_result > 0) {  //active user record is present
                    // get logged user's role 
                    $users = $this->User_model->get_current_user($username, $password);
                    foreach ($users as $user) {
                        $userid = $user['user_id'];
                        $role_id = $user['role_id'];
                        $rolename = $user['roll_name'];
                    }
                    if ($role_id == "2") { // if logged user's role is School User
                        $school = $this->School_model->get_logged_school($userid);
                        foreach ($school as $row) {
                            $census_id = $row->census_id; // get logged school's id
                            $sch_name = $row->sch_name; // get logged school's name
                        }
                        // set session data
                        $sessiondata = array(
                            'census_id' => $census_id,
                            'school_name' => $sch_name,
                            'userid' => $userid,
                            'username' => $username,
                            'loginuser' => TRUE,
                            'userrole_id' => $role_id,
                            'userrole' => $rolename
                        );
                    } elseif ($role_id == 7) { // if edu. division user
                        foreach ($users as $user) {
                            $div_id = $user['div_id'];
                        }
                        $division = $this->Common_model->get_division($div_id);
                        foreach ($division as $row) {
                            //$census_id = $row->census_id; // 
                            $div_name = $row->div_name; // get logged division name (කොට්ඨාස කාර්යාලය)
                        }
                        $sessiondata = array( // set session data without school name
                            'userid' => $userid,
                            'username' => $username,
                            'loginuser' => TRUE,
                            'userrole_id' => $role_id,
                            'userrole' => $rolename,
                            'div_id' => $div_id, // edu. division id ex- 101=morawaka
                            'div_name' => $div_name // edu. division id ex- 101=morawaka
                        );
                    } else {
                        $sessiondata = array( // set session data without school name
                            'userid' => $userid,
                            'username' => $username,
                            'loginuser' => TRUE,
                            'userrole_id' => $role_id,
                            'userrole' => $rolename
                        );
                    }
                    $this->session->set_userdata($sessiondata);
                    // show message count
                    $this->new_msg_count = $this->new_message_count();
                    // insert data to user track table
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'user_track_id' => '',
                        'user_id' => $userid, // logged user
                        'key_on_row' => '',
                        'tbl_name' => '',
                        'act_type_id' => '1',
                        'note' => 'Logged in to the system',
                        'date_added' => $now,
                        'is_deleted' => '',
                    );
                    $user_track = $this->User_model->add_user_act($data);
                    // check which user
                    if ($role_id == 1) { // admin
                        $data['title'] = 'Admin Dashboard';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    } elseif ($role_id == 2) { // school user
                        $data['title'] = 'School Dashboard';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    } elseif ($role_id == 3) { // zonal user
                        $data['title'] = 'ZEO User Dashboard';
                        $data['user_header'] = 'user_zeo_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    } elseif ($role_id == 4) {
                        $data['title'] = 'Department Dashboard';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    } elseif ($role_id == 5) {
                        $data['title'] = 'ZEO Director';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    } elseif ($role_id == 6) {
                        $data['title'] = 'ZEO Assistant Director';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'user/admin_dashboard';
                    } elseif ($role_id == 7) {
                        $data['title'] = 'Division Dashboard';
                        $data['user_header'] = 'user_edu_division_header';
                        $data['user_content'] = 'user/edu_div_user_dashboard';
                    } elseif ($role_id == 8) {
                        $data['title'] = 'ZEO File Dashboard';
                        $data['user_header'] = 'user_zonal_file_header';
                        $data['user_content'] = 'user/zonal_file_user_dashboard';
                    } elseif ($role_id == 9) {
                        $data['title'] = 'ZEO Salary Dashboard';
                        $data['user_header'] = 'user_zonal_file_header';
                        $data['user_content'] = 'user/zonal_file_user_dashboard';
                    }
                    $this->all_schools_count = $this->count_all_schools(); // for cards in dashboard home
                    $this->all_students_count = $this->count_all_students(); // for cards in dashboard home
                    $this->all_ac_staff_count = $this->count_all_academic_staff(); // for cards in dashboard home 
                    // for pie chart in dashboard home
                    // these are loaded in construct method too. but when login charts are not working.
                    // thats why these are loaded again in this login method too.
                    $this->count_schools_by_type = $this->count_schools_by_type(); // for pie chart in dashboard home
                    $this->count_schools_by_devision = $this->count_schools_by_division(); // for pie chart in dashboard home
                    $this->count_schools_by_belongsTo = $this->count_schools_by_belongsTo(); // for pie chart in dashboard home
                    $this->all_academic_staff_count_genderwise = $this->view_all_school_staff_count_genderwise(); // for pie chart in dashboard home
                    $this->all_student_count_genderwise = $this->view_all_student_count_genderwise(); // for pie chart in dashboard home
                    $this->load->view('templates/user_template', $data);
                } else {  // user does not exist
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                    redirect('GeneralInfo/loginPage');
                }
            } else {
                redirect('GeneralInfo/loginPage');
            }
        }
    }  // end login 
    public function viewLoginPage()
    {
        $data['title'] = 'User Login Window';
        $data['content'] = 'general_info/login';
        $this->load->view('templates/template', $data);
    }
    // here index method load the dashboard, when we are in another page and if we want to come to dashboard, this is used
    public function index()
    {
        if ($this->session->userdata('loginuser') == 1) {
            if ($this->session->userdata('userrole_id') == 1) { // admin
                $data['title'] = 'Admin Dashboard';
                $data['user_header'] = 'user_admin_header';
                $data['user_content'] = 'user/admin_dashboard';
            } elseif ($this->session->userdata('userrole_id') == 2) { // school user
                $data['title'] = 'School Dashboard';
                $data['user_header'] = 'user_admin_header';
                $data['user_content'] = 'user/admin_dashboard';
            } elseif ($this->session->userdata('userrole_id') == 3) {  // zonal user
                $data['title'] = 'ZEO User Dashboard';
                $data['user_header'] = 'user_zeo_header';
                $data['user_content'] = 'user/admin_dashboard';
            } elseif ($this->session->userdata('userrole_id') == 4) {  // department user
                $data['title'] = 'Department Dashboard';
                $data['user_header'] = 'user_admin_header';
                $data['user_content'] = 'user/admin_dashboard';
            } elseif ($this->session->userdata('userrole_id') == 5) {  // zonal director
                $data['title'] = 'ZEO Director';
                $data['user_header'] = 'user_admin_header';
                $data['user_content'] = 'user/admin_dashboard';
            } elseif ($this->session->userdata('userrole_id') == 6) {  // zonal assistant director
                $data['title'] = 'ZEO Assistant Director';
                $data['user_header'] = 'user_admin_header';
                $data['user_content'] = 'user/admin_dashboard';
            } elseif ($this->session->userdata('userrole_id') == 7) {  // edu. divisional user
                $data['title'] = 'Divisioan Dashboard';
                $data['user_header'] = 'user_edu_division_header';
                $data['user_content'] = 'user/edu_div_user_dashboard';
            } elseif ($this->session->userdata('userrole_id') == 8) {   // zonal file section
                $data['title'] = 'ZEO File Dashboard';
                $data['user_header'] = 'user_zonal_file_header';
                $data['user_content'] = 'user/zonal_file_user_dashboard';
            } elseif ($this->session->userdata('userrole_id') == 9) {   // zonal salary section
                $data['title'] = 'ZEO Salary Dashboard';
                $data['user_header'] = 'user_zonal_salary_header';
                $data['user_content'] = 'user/edu_div_user_dashboard';
            }
            //$data['count_schools_by_type'] = $this->count_schools_by_type();

            $this->load->view('templates/user_template', $data);
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('session_data');
        $this->session->sess_destroy();
        redirect(base_url() . 'GeneralInfo/loginPage');
    }
    // this method called by this construct method to view all user status
    public function user_status()
    {
        return $this->User_model->get_all_user_status();
    }
    // this method called by this construct method to get all user roles
    public function user_roles()
    {
        return $this->User_model->get_all_user_roles();
    }
    // this method called by this construct method to get all user roles
    public function view_all_user_act()
    {
        return $this->User_model->get_all_user_acts();
    }
    // this method called by this construct method
    public function count_national_schools()
    {
        return $this->School_model->count_national_schools();
    }
    // this method called by this construct method
    public function count_1AB_schools1()
    {
        return $this->School_model->count_1AB_schools();
    }
    // this method called by this construct method
    public function count_1C_schools1()
    {
        return $this->School_model->count_1C_schools();
    }
    // this method called by this construct method
    public function count_type2_schools1()
    {
        return $this->School_model->count_type2_schools();
    }
    // this method called by this construct method
    public function count_type3_schools1()
    {
        return $this->School_model->count_type3_schools();
    }
    // this method called by this construct method
    public function count_all_schools()
    {
        $this->userrole_id = $this->session->userdata['userrole_id'];
        if ($this->userrole_id == 7) {
            $eduDivId = $this->session->userdata['div_id'];
            return $this->School_model->count_all_schools($eduDivId);
        } else {
            return $this->School_model->count_all_schools();
        }
    }
    // this method called by this construct method, used in user dashboard - cards
    public function count_all_students()
    {
        return $this->Student_model->count_all_students();
    }

    // this method called by this construct method, used in user dashboard - cards
    public function count_all_academic_staff()
    {
        if ($this->userrole_id == 7) {
            $eduDivId = $this->session->userdata['div_id'];
            return $this->Staff_model->count_all_academic_staff($eduDivId);
        } elseif ($this->userrole_id == 2) {
            $censusId = $this->session->userdata['census_id'];
            return $this->Staff_model->count_all_academic_staff($censusId);
        } else {
            return $this->Staff_model->count_all_academic_staff();
        }
    }
    // this method called by this construct method
    // no of school type wise is needed for pie chart in dashboard
    public function count_schools_by_type()
    {
        $result = $this->School_model->count_schools_by_type();
        if (!empty($result)) {
            $data = [];
            foreach ($result as $row) {
                $data['sch_type'][] = $row->sch_type;
                $data['sch_count'][] = $row->sch_count;
                $data['date_updated'][] = $row->date_updated;
            }

            return (json_encode($data));
        }
    }
    // this method called by this construct method
    // no of school division wise is needed for pie chart in dashboard
    public function count_schools_by_division()
    {
        $result = $this->School_model->count_schools_by_division();
        if (!empty($result)) {
            $data = [];
            foreach ($result as $row) {
                $data['division'][] = $row->div_name;
                $data['sch_count'][] = $row->sch_count;
                $data['date_updated'][] = $row->date_updated;
            }
            return (json_encode($data));
        }
    }
    // this method called by this construct method
    // no of school national or province wise is needed for pie chart in dashboard
    public function count_schools_by_belongsTo()
    {
        $result = $this->School_model->count_schools_by_belongsTo();
        if (!empty($result)) {
            $data = [];
            foreach ($result as $row) {
                $data['div_name'][] = $row->belongs_to_name;
                $data['sch_count'][] = $row->sch_count;
                $data['date_updated'][] = $row->date_updated;
            }
            return (json_encode($data));
        }
    }
    // this method loaded by this construct method
    // no of all academic staff count gender wise for pie chart in dashboard
    public function view_all_school_staff_count_genderwise()
    {
        $stf_data = $this->Staff_model->count_academic_staff_genderwise();
        if (!empty($stf_data)) {
            $data = [];
            foreach ($stf_data as $row) {
                $data['gender'][] = $row->gender_name;
                $data['stf_count'][] = $row->stf_count;
                //$data['date_updated'][] = $row->date_updated;
            }
            return (json_encode($data));
        }
    }
    // this method loaded by this construct method
    // no of all student count gender wise for pie chart in dashboard
    public function view_all_student_count_genderwise()
    {
        $std_data = $this->Student_model->count_student_genderwise();
        if (!empty($std_data)) {
            $data = [];
            foreach ($std_data as $row) {
                $data['gender'][] = $row->gender_name;
                $data['std_count'][] = $row->std_count;
                //$data['date_updated'][] = $row->date_updated;
            }
            return (json_encode($data));
        }
    }
    // this method called by this construct method
    // view new messages count in dashboard
    public function new_message_count()
    {
        $userRoleId = $this->session->userdata['userrole_id'];
        if ($userRoleId == '2') {
            $censusId = $this->session->userdata['census_id'];
            //$censusId = '07065';
            $condition = 'to_whom = ' . $censusId;
        } else if ($userRoleId == '1') {
            $condition = 'to_whom = "1" ';
        } else if ($userRoleId == '3') {
            $condition = 'to_whom = "3" ';
        } else if ($userRoleId == 'Zonal User') {
            $condition = 'to_whom = "3" ';
        } else {
            $condition = 'to_whom = " " ';
        }
        return $this->User_messages_model->get_new_message_count($condition);
    }
    // view recent updated date and time of school details
    // this is called by construct method
    public function view_recent_sch_update_dt()
    {
        return $this->School_model->view_recent_sch_update_dt();
    }
    // public function setPhysicalResourceAlert(){
    //     $allSchools = $this->School_model->view_all_schools();
    //     foreach ($allSchools as $row) {
    //         $censusId = $row->census_id;
    //         $result = $this->Physical_resource_model->get_short_phy_res_details($censusId); // $result = shortage of physical resource updation
    //         if($result){
    //             $to = $censusId; $cat_id = '1'; // cat_id = 1 means physical resource in alert categories
    //             $add = $this->Alert_model->addAlert($result,$to,$cat_id);
    //         }
    //     }
    // } 

    // // view physical resource alerts
    // // this is called by construct method
    // public function viewPhyResAlert1(){ 
    //     if($this->session->userdata['userrole'] == 'School User'){
    //         $censusId = $this->session->userdata['census_id'];
    //         //$censusId = '07065';
    //         return $this->Alert_model->view_alert_by_to_whom($censusId);
    //     }else{
    //         $cat_id = '1';
    //         return $this->Alert_model->view_alerts_by_category($cat_id);
    //     }
    // } 
    // view all the users available in this system. used by admin to change user role, add user and etc....
    public function viewUsers()
    {
        if (is_logged_in()) {
            $userrole = $this->session->userdata['userrole_id'];
            if ($userrole == 1) { // check admin
                $userDetails = $this->User_model->view_all_users();
                if (!$userDetails) {
                    $this->session->set_flashdata('user_msg', array('text' => 'No records found!!!', 'class' => 'alert alert-danger'));
                } else {
                    $data['user_details'] = $userDetails;
                }
            }
            $data['title'] = 'User Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'user/index';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }
    // Ajax call to viewUsers view, when click on view data button
    public function viewUserInfoByUserId()
    {
        $userId = $this->input->post('userId');
        $userDetails = $this->User_model->get_user_info_by_userid($userId);
        if (!empty($userDetails)) {
            $output = '';
            foreach ($userDetails as $row) {
                $output .= '
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped table-hover" align="center" id="userInfoTblAjax">
                                <tr>
                                    <th class="col-lg-4"> User ID </th>
                                    <td class="col-lg-8">' . $row->u_id . '</td>
                                </tr>
                                <tr>
                                    <th> User Name </th>
                                    <td>' . $row->username . '</td>                                   
                                </tr>                                   
                                <tr>
                                    <th><b>User Role</b></th>
                                    <td>' . $row->roll_name . '</td>                                    
                                </tr>   
                                <tr>
                                    <th><b>User Status</b></th>
                                    <td>' . $row->status_type . '</td>                                  
                                </tr>
                                <tr>
                                    <th><b> School </b></th>
                                    <td>' . ($row->role_id != '2' ? '' : $row->sch_name) . '</td>                                  
                                </tr>
                                <tr>
                                    <th><b> Census ID </b></th>
                                    <td>' . ($row->role_id != '2' ? '' : $row->census_id) . '</td>                                  
                                </tr>
                            </table>
                        </div>
                    </div>';
            }
            echo $output;
        } else {
            echo 'No records found!!!';
        }
    }
    // change user role
    public function changeUser()
    {
        if (is_logged_in() && $this->session->userdata('loginuser') == 1) { // only the admin allowed
            if ($this->input->post('btn_change_user') == 'ChangeStatus') {
                if (!empty($this->input->post('select_user_status')) && !empty($this->input->post('chkbox'))) {
                    $userStatus = $this->input->post('select_user_status');
                    //echo $userStatus;
                    $user = $this->input->post('chkbox');
                    //print_r($user); die();
                    $result = $this->User_model->update_user_status($user, $userStatus);
                    if ($result) {
                        $this->session->set_flashdata('userChangeMsg', array('text' => 'User status has been changed successfully', 'class' => 'alert alert-success'));
                    } else {
                        $this->session->set_flashdata('userChangeMsg', array('text' => 'Error in changing user status', 'class' => 'alert alert-danger'));
                    }
                } else {
                    $this->session->set_flashdata('userChangeMsg', array('text' => 'Please select both user and user status', 'class' => 'alert alert-danger'));
                }
            }
            if ($this->input->post('btn_change_user') == 'ChangeRole') {
                if (!empty($this->input->post('select_user_role')) && !empty($this->input->post('chkbox'))) {
                    $userRole = $this->input->post('select_user_role');
                    //echo $userStatus;
                    $user = $this->input->post('chkbox');
                    //print_r($user); die();
                    $result = $this->User_model->update_user_role($user, $userRole);
                    if ($result) {
                        $this->session->set_flashdata('userChangeMsg', array('text' => 'User role has been changed successfully', 'class' => 'alert alert-success'));
                    } else {
                        $this->session->set_flashdata('userChangeMsg', array('text' => 'Error in changing user role', 'class' => 'alert alert-danger'));
                    }
                } else {
                    $this->session->set_flashdata('userChangeMsg', array('text' => 'Please select both user and user role', 'class' => 'alert alert-danger'));
                }
            }
            if ($this->input->post('btn_change_user') == 'setDefUnamePwd') {
                if (!empty($this->input->post('chkbox'))) {
                    $user = $this->input->post('chkbox');
                    $successCount = 0;
                    $errorCount = 0;
                    foreach ($user as $user) {
                        //echo $user;
                        $userRole = $this->User_model->get_user_role($user);
                        foreach ($userRole as $userRole) {
                            $userRoleId = $userRole->role_id;
                        }
                        //echo $userRoleId; die();
                        if ($userRoleId == 1) {                 // admin
                            $username = 'admin';
                            $password = md5('admin');
                        } else if ($userRoleId == 2) {           // school user
                            $username = 'school_user';
                            $result = $this->School_model->find_census_by_userid($user);
                            foreach ($result as $result) {
                                $censusId = $result->census_id;
                            }
                            //die();
                            $password = md5($censusId);
                            //echo $password; die();
                        } else if ($userRoleId == 3) {           // Zonal user
                            $username = 'zonal_user';
                            $password = md5('zonaluser');
                        } else if ($userRoleId == 4) {         // department user
                            $username = 'department_user';
                            $password = md5('depuser');
                        } else if ($userRoleId == 5) {         // zonal director
                            $username = 'director';
                            $password = md5('director');
                        } else if ($userRoleId == 6) {         // zonal assistant director
                            $username = 'assdirector';
                            $password = md5('assdirector');
                        } else if ($userRoleId == 7) {         // divisional edu. office user
                            $username = 'div_user';
                            $result = $this->User_model->get_edu_division($user);
                            foreach ($result as $division) {
                                $password = $division->div_id . $division->div_id; // ex- password = 101101 ( if div id = 101)
                            }
                            $password = md5($password);
                        } else if ($userRoleId == 8) {         // zonal file section
                            $username = 'zonal_file';
                            $password = md5('zonal_file_123');
                        } else if ($userRoleId == 9) {         // zonal salary section
                            $username = 'zonal_salary';
                            $password = md5('zonal_salary_123');
                        }
                        //echo $user.' '.$username.' '.$password;
                        $result = $this->User_model->update_to_def_uname_pwd($user, $username, $password);
                        //die();
                        if ($result == true) {
                            $successCount++;
                        } else {
                            $errorCount++;
                        }
                    }
                    if ($successCount > 0) {
                        $this->session->set_flashdata('userChangeMsg', array('text' => $successCount . ' Successfull, ' . $errorCount . ' not Successfull', 'class' => 'alert alert-success'));
                    } else {
                        $this->session->set_flashdata('userChangeMsg', array('text' => $errorCount . ' not Successfull', 'class' => 'alert alert-danger'));
                    }
                } else {
                    $this->session->set_flashdata('userChangeMsg', array('text' => 'Please select a user', 'class' => 'alert alert-danger'));
                }
            }
            $this->viewUsers();
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }
    public function viewUserLogPage()
    {
        if (is_logged_in() && $this->session->userdata('loginuser') == 1) { // only the admin allowed
            $data['title'] = 'User Log Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'user/userLog';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }
    public function viewUserLog()
    {
        if (is_logged_in() && $this->session->userdata('loginuser') == 1) {
            $userId = $this->input->post('userid_txt');
            $censusId = $this->input->post('censusid_txt');
            $fromDate = $this->input->post('frmdate_txt');
            $toDate = $this->input->post('todate_txt');
            $userAct = $this->input->post('select_user_act');
            if (!empty($censusId)) {
                $userId = $this->School_model->find_user_id($censusId); // find the user_id related to census_id
            }
            $userLogDetails = $this->User_model->get_user_log($userId, $fromDate, $toDate, $userAct);
            $data['user_log_details'] = $userLogDetails;
            $data['title'] = 'User Log Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'user/userLog';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('User');
        }
    }
    public function loginRecover()
    {
        if ($this->input->post('btn_recover') == 'RecoverUnPwd') {
            $this->form_validation->set_rules("email_txt", "Email", "required|valid_email");
            if ($this->form_validation->run() == FALSE) {
                //validation fails
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"> Required a correct email!</div>');
                $this->viewLoginPage();
                //redirect('GeneralInfo/loginPage');
            } else {
                $email = $this->input->post('email_txt');
                $emailFound = $this->User_model->check_email_exists($email);
                if ($emailFound) {
                    $result = $this->School_model->view_school_by_email($email);
                    foreach ($result as $school) {
                        $schoolName = $school->sch_name;
                        $censusId = $school->census_id;
                        $email = $school->email;
                        $password = $school->census_id;
                    }
                    $username = 'school_user';
                    $userId = $this->School_model->find_user_id($censusId);
                    $result = $this->User_model->update_to_def_uname_pwd($userId, $username, md5($password));
                    if ($result) {
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'user_track_id' => '',
                            'user_id' => $userId, // logged user
                            'key_on_row' => $userId,
                            'tbl_name' => 'User_tbl',
                            'act_type_id' => '3',
                            'note' => 'Set to default username and password through login recovery',
                            'date_added' => $now,
                            'is_deleted' => '',
                        );
                        $user_track = $this->User_model->add_user_act($data);

                        $toEmail = $email;
                        $subject = 'Login recovered successfully';
                        $message = 'Hello ' . $schoolName . '<br>';
                        $message .= 'Your user name and password has been set to default<br>';
                        $message .= 'User name : ' . $username . '<br>';
                        $message .= 'Password : ' . $password . '<br>';
                        $message .= '<a href="http://deniyayazeo.lk/User">Click here to login into the system and change your login details as soon as possible</a><br>';
                        $message .= '<br><br><br>';
                        $message .= 'From<br>';
                        $message .= 'Zonal Education Office, Deniyaya';
                        if ($this->Common_model->send_mail($toEmail, $subject, $message)) {
                            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center"> Your username and password has been sent to email!</div>');
                        } else {
                            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"> Sending email is fail!!!</div>');
                        }
                    } else {
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"> Error occured!</div>');
                    }
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center"> Email does not exists!</div>');
                }
            }
        }
        redirect('GeneralInfo/loginPage');
    }
    // load username and password change view for every user
    public function UnmPwdChangeView()
    {
        if (is_logged_in()) { // only the logged users allowed
            $userId = $this->session->userdata('userid');
            $userData = $this->User_model->get_user_info_by_userid($userId);
            $data['userData'] = $userData;
            $data['title'] = 'User Settings';
            if ($this->userrole_id == '7') { // edu. divisional user
                $data['user_header'] = 'user_edu_division_header';
            } elseif ($this->userrole_id == '8') { // edu. divisional user
                $data['user_header'] = 'user_zonal_file_header';
            } elseif ($this->userrole_id == '9') { // edu. divisional user
                $data['user_header'] = 'user_zonal_file_header';
            } else {
                $data['user_header'] = 'user_admin_header';
            }
            $data['user_content'] = 'user/unm_pwd_change';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }
    // change username by user
    public function changeUnm()
    {
        if (is_logged_in() && $this->input->post('btn_change_unm') == 'Change') { // only the admin allowed
            $this->form_validation->set_rules("cur_uname_txt", "Current Username", "required");
            $this->form_validation->set_rules("new_uname_txt", "New Username", "required|min_length[5]|max_length[11]");
            if ($this->form_validation->run() == FALSE) {
                //validation fails
                $this->UnmPwdChangeView();
            } else {
                $userId = $this->input->post('user_id_hidden');
                $curUserName = $this->input->post('cur_uname_txt');
                $newUserName = $this->input->post('new_uname_txt');
                $curUserNameExists = $this->User_model->check_unm_exists($userId, $curUserName);
                if ($curUserNameExists) {
                    $changeUnm = $this->User_model->change_username($userId, $newUserName);
                    if ($changeUnm) {
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'user_track_id' => '',
                            'user_id' => $userId, // logged user
                            'key_on_row' => $userId,
                            'tbl_name' => 'user_tbl',
                            'act_type_id' => '3', // update
                            'note' => 'Changed the username',
                            'date_added' => $now,
                            'is_deleted' => '',
                        );
                        $user_track = $this->User_model->add_user_act($data);
                        $this->session->set_flashdata('changeMsg', array('text' => 'Username changed successfully', 'class' => 'alert alert-success'));
                    } else {
                        $this->session->set_flashdata('changeMsg', array('text' => 'Username not changed', 'class' => 'alert alert-danger'));
                    }
                } else {
                    $this->session->set_flashdata('changeMsg', array('text' => 'Username does not exist', 'class' => 'alert alert-danger'));
                }
                $this->UnmPwdChangeView();
            }
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }
    // change password by user
    public function changePwd()
    {
        if (is_logged_in() && $this->input->post('btn_change_pwd') == 'Change') { // only the user allowed
            $this->form_validation->set_rules("old_pwd_txt", "Current Password", "required");
            $this->form_validation->set_rules("new_pwd_txt", "New Password", "required|min_length[5]|max_length[10]");
            $this->form_validation->set_rules("confirm_new_pwd_txt", "New Password confirmation", "required|matches[new_pwd_txt]");
            if ($this->form_validation->run() == FALSE) {
                //validation fails
                $this->UnmPwdChangeView();
            } else {
                $userId = $this->input->post('user_id_hidden');
                $curPwd = $this->input->post('old_pwd_txt');
                $newPwd = $this->input->post('new_pwd_txt');
                $confirmNewPwd = $this->input->post('confirm_new_pwd_txt');
                //if()
                $curPwdExists = $this->User_model->check_pwd_exists($userId, md5($curPwd));
                if ($curPwdExists) {
                    $changePwd = $this->User_model->change_pwd($userId, md5($newPwd));
                    if ($changePwd) {
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'user_track_id' => '',
                            'user_id' => $userId, // logged user
                            'key_on_row' => $userId,
                            'tbl_name' => 'user_tbl',
                            'act_type_id' => '3', // update
                            'note' => 'Changed the password',
                            'date_added' => $now,
                            'is_deleted' => '',
                        );
                        $user_track = $this->User_model->add_user_act($data);
                        $userInfo = $this->User_model->get_user_info_by_userid($userId);
                        foreach ($userInfo as $user) {
                            $email = $user->email;
                            if ($this->userrole_id == 2) {
                                $school = $user->sch_name;
                            }
                        }
                        //echo $email; die();
                        if (!empty($email)) {

                            $toEmail = $email;
                            $subject = 'Password Confirmation Message';
                            $message = 'Hello ' . $school . '<br>';
                            $message .= '<p>Your user password is :<strong>&nbsp;' . $newPwd . '</strong>,</p>';
                            $message .= '<p>Your account details were changed as above. Please use above details with zonal office system</p>';
                            $message .= '<p>Thank you!</p>';
                            $message .= '<br><br><br>';
                            $message .= 'From<br>';
                            $message .= 'Zonal Education Office, Deniyaya';

                            if ($this->Common_model->send_mail($toEmail, $subject, $message)) {
                                $this->session->set_flashdata("email_sent", array('text' => 'New password was sent to email successfully', 'class' => 'alert alert-success'));
                            } else {
                                $this->session->set_flashdata("email_sent", array('text' => 'Error in sending Email.', 'class' => 'alert alert-danger'));
                            }
                        }
                        $this->session->set_flashdata('changePwdMsg', array('text' => 'Password changed successfully', 'class' => 'alert alert-success'));
                    } else {
                        $this->session->set_flashdata('changePwdMsg', array('text' => 'Password not changed!', 'class' => 'alert alert-danger'));
                    }
                } else {
                    $this->session->set_flashdata('changePwdMsg', array('text' => 'Current password is wrong!', 'class' => 'alert alert-danger'));
                }
                $this->UnmPwdChangeView();
            }
        } else {
            redirect('GeneralInfo/loginPage');
        }
    } // end changePwd method
    public function addUserByAdmin()
    {
        if (is_logged_in()) { // only the logged users allowed
            //$this->form_validation->set_rules("userid_txt","User ID","required");
            $this->form_validation->set_rules("user_role_select", "User Role", "required");
            $this->form_validation->set_rules("usernm_txt", "User Name", "required");
            $this->form_validation->set_rules("user_status_select", "User Status", "required");
            if ($this->form_validation->run() == FALSE) {
                //validation fails
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">All the fields are required!</div>');
                $this->viewUsers();
            } else {
                $uid = $this->input->post('userid_txt');
                $uname = $this->input->post('usernm_txt');
                $roleId = $this->input->post('user_role_select');
                if ($this->User_model->check_unm_exist($uname)) {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Username already exists!!!</div>');
                    $this->viewUsers();
                } else {
                    if ($roleId == 7) {
                        $divId = $this->input->post('edu_div_id_hidden');
                        $pwd = $divId . $divId;
                    } else {
                        $divId = '';
                        $pwd = $uname . '123';
                    }
                    $pwd = md5($pwd);
                    $now = date("Y-m-d H:i:s");
                    //die();
                    $data = array(
                        'user_id' => '', // admin
                        'role_id' => $roleId,
                        'username' => $this->input->post('usernm_txt'),
                        'password' => $pwd,
                        'div_id' => $divId,
                        'status_id' => $this->input->post('user_status_select'),
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    $result = $this->User_model->add_user($data);
                    if (!$result) {
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">User was not added!</div>');
                    } else {
                        $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User was added successfully</div>');
                        $this->viewUsers();
                    }
                }
            }
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }
    public function deleteUser()
    {
        if (is_logged_in() && $this->session->userdata['userrole'] == 'System Administrator') {
            $uid = $this->uri->segment(3);
            $user = $this->User_model->get_user_info_by_userid($uid);
            foreach ($user as $row) {
                $user_role_id = $row->role_id;
            }
            //die();
            if ($user_role_id == 1 or $user_role_id == 2) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Admin or School user can not be deleted!</div>');
            } else {
                $deleteUser = $this->User_model->delete_user($uid);  // delete user data from user_tbl
                //die();
                if ($deleteUser) {
                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User deleted successfully </div>');
                } else {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">User could not be deleted!</div>');
                }
            }
            $this->viewUsers();
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }
    public function userList()
    {
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->User_model->getUsers($postData);

        echo json_encode($data);
    }
}
