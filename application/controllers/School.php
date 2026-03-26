<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        //print_r($this->session->userdata); die();
        $this->load->helper('login');
        $this->load->model('School_model');
        $this->load->model('User_model');
        $this->load->model('Alert_model');
        $this->load->model('Common_model');
        if(is_logged_in()){
            $this->userId = $this->session->userdata['userid'];
            $this->userRole = $this->session->userdata['userrole'];
            $this->userRoleId = $this->session->userdata['userrole_id'];
        }else{
            redirect('User');
        } 
        $this->all_grade_span = $this->view_all_grade_span(); // view divisions in find school page
        $this->all_gs_div = $this->view_all_gs_divisions(); // view divisions in find school page
        $this->all_edu_div = $this->view_all_edu_divisions(); // view divisions in find school page
        $this->all_sch_types = $this->view_all_sch_types(); // view school types in find school page
        $this->recent_update_dt_school = $this->view_recent_sch_update_dt(); // view latest school details update date
        $this->no_of_schools = $this->count_all_schools(); // needed count of national schools in find schools page
        $this->no_of_national_schools = $this->count_national_schools(); // needed count of national schools in find schools page
        $this->no_of_1AB_schools = $this->count_1AB_schools(); // needed count of school types in find schools page
        $this->no_of_1C_schools = $this->count_1C_schools();    // needed count of school types in find schools page
        $this->no_of_type2_schools = $this->count_type2_schools();  // needed count of school types in find schools page
        $this->no_of_type3_schools = $this->count_type3_schools();  // needed count of school types in find schools page
        //$this->all_academic_staff_count_genderwise = $this->view_all_school_staff_count_genderwise(); // for bar chart in admin dashboard   
            
    }

    // view recent updated date and time of school details
    // this is called by construct method
    public function view_recent_sch_update_dt(){ 
        return $this->School_model->view_recent_sch_update_dt();
    }  
    // this method called by this construct method
    public function view_all_edu_divisions(){ 
        return $this->School_model->view_all_edu_divisions();
    }
    // this method called by this construct method
    public function view_all_grade_span(){ 
        return $this->School_model->view_all_grade_span();
    }
    // this method called by this construct method
    public function view_all_gs_divisions(){ 
        return $this->School_model->view_all_gs_divisions();
    }
    // this method called by this construct method
    public function view_all_sch_types(){ 
        return $this->School_model->view_all_sch_types();
    } 
    // this method called by this construct method
    public function count_all_schools(){ 
        if( $this->userRoleId == 7 ){
            $eduDivId = $this->session->userdata['div_id'];
            return $this->School_model->count_all_schools($eduDivId);
        }else{
            return $this->School_model->count_all_schools();
        }
    } 
    // this method called by this construct method
    public function count_national_schools(){ 
        if( $this->userRoleId == 7 ) {
            $eduDivId = $this->session->userdata['div_id'];
            return $this->School_model->count_national_schools($eduDivId);
        }else{
            return $this->School_model->count_national_schools();
        }
    } 
    // this method called by this construct method
    public function count_1AB_schools(){ 
        if( $this->userRoleId == 7 ) {
            $eduDivId = $this->session->userdata['div_id'];
            return $this->School_model->count_1AB_schools($eduDivId);
        }else{
            return $this->School_model->count_1AB_schools();
        }
    }
    // this method called by this construct method
    public function count_1C_schools(){ 
        if( $this->userRoleId == 7 ) {
            $eduDivId = $this->session->userdata['div_id'];
            return $this->School_model->count_1C_schools($eduDivId);
        }else{
            return $this->School_model->count_1C_schools();
        }
    }  
    // this method called by this construct method
    public function count_type2_schools(){ 
        if( $this->userRoleId == 7 ) {
            $eduDivId = $this->session->userdata['div_id'];
            return $this->School_model->count_type2_schools($eduDivId);
        }else{
            return $this->School_model->count_type2_schools();
        }
    }   
    // this method called by this construct method
    public function count_type3_schools(){ 
        if( $this->userRoleId == 7 ) {
            $eduDivId = $this->session->userdata['div_id'];
            return $this->School_model->count_type3_schools($eduDivId);
        }else{
            return $this->School_model->count_type3_schools();
        }
    }  
    public function viewAddSchoolPage(){
        if(is_logged_in()){
            $data['title'] = 'Insert School Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'school/addSchool';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }

    public function addSchool(){
        if(is_logged_in()){
            if ( $this->input->post('btn_insert_school') == "Submit" ){
                //set validations
                $this->form_validation->set_rules("txt_census_id","Census ID","required|numeric|min_length[5]|max_length[5]");
                $this->form_validation->set_rules("txt_school_name","School Name","required");
                $this->form_validation->set_rules("select_sch_type","School type","required");
                $this->form_validation->set_rules("txt_email","Email","required|valid_email");            
                //$this->form_validation->set_rules("select_edu_div","Education Division","required");
                //$this->form_validation->set_rules("select_gs_div","Grama Niladhari Division","required");
                //$this->form_validation->set_rules("select_belongs_to","Which School","required");
                
                if ( $this->form_validation->run() == FALSE ){
                    //validation fails
                    $this->viewAddSchoolPage();
                }else{
                    // validation succeeds
                    $id = $this->input->post('txt_census_id');
                    $school_exist = $this->School_model->view_school_by_id($id); // by census id
                    if($school_exist){
                        $this->session->set_flashdata('msg', array('text' => 'This School with census id - '.$id.' already exists!!!','class' => 'alert alert-danger'));
                        redirect('School/viewAddSchoolPage');                       
                    }else{
                        $email = $this->input->post('txt_email');
                        $emailExist = $this->School_model->view_school_by_email($email);
                        //print_r($emailExist); die();
                        if( $emailExist ){
                            $this->session->set_flashdata('msg', array('text' => $email.' has already taken by another user!!!','class' => 'alert alert-danger'));
                            redirect('School/viewAddSchoolPage');                   
                        }else{
                            $now = date('Y-m-d H:i:s');
                            $data = array(
                                'user_id' => '',
                                'role_id' => '2',
                                'username' => 'school_user',
                                'password' => md5($this->input->post('txt_census_id')),
                                'status_id' => '1',
                                'date_added' => $now,
                                'date_updated' => $now,
                                'is_deleted' => '',
                            );
                            $id = $this->User_model->add_user($data); 
                            if( !$id ){
                                $this->session->set_flashdata('msg', array('text' => 'Could n\'t add school user!!!','class' => 'alert alert-danger'));
                                redirect('School/viewAddSchoolPage');                   
                            }else{ 
                                $toEmail = $this->input->post('txt_email');
                                $subject = 'Deniyaya Zeo Login Details';
                                $username = 'school_user';
                                $password = $this->input->post('txt_census_id');
                                $message = 'Please click on this link to access Management Information System of your school<br>';
                                $message .= '<a href="'.base_url().'User" >Click here to login</a><br>';
                                $message .= 'Your login details'.'<br>';
                                $message .= 'User name - '.$username.'<br>';
                                $message .= 'Password - '.$password.'<br>';
                                $message .= 'You can change your username and password after log in to the system';
                                if( $this->Common_model->send_mail( $toEmail, $subject, $message ) ){
                                    $this->session->set_flashdata('emailStatus', array('text' => 'Username and password sent to '.$toEmail.' successfully','class' => 'alert alert-success'));
                                }else{
                                    $this->session->set_flashdata('emailStatus', array('text' => 'Username and password could not sent!!!','class' => 'alert alert-danger'));
                                }
                                //die();
                                $user_id = $id; // from above code
                                $now = date('Y-m-d H:i:s');
                                $data = array(
                                    'census_id' => $this->input->post('txt_census_id'),
                                    'exam_no' => '',
                                    'sch_name' => $this->input->post('txt_school_name'),
                                    'address1' => '',
                                    'address2' => '',
                                    'contact_no' => '',
                                    'email' => $this->input->post('txt_email'),
                                    'web_address' => '',
                                    'pro_id' => '',
                                    'dis_id' => '',
                                    'zone_id' => '',
                                    'div_id' => '',
                                    'div_sec_id' => '',
                                    'gs_div_id' => '',
                                    'sch_type_id' => $this->input->post('select_sch_type'),
                                    'belongs_to_id' => $this->input->post('select_belongs_to'),
                                    'grd_span_id' => '',
                                    'user_id' => $user_id,
                                    'date_added' => $now,
                                    'date_updated' => $now,
                                    'is_deleted' => '',
                                    );
                                $result = $this->School_model->add_school($data);
                                if( $result ){
                                    // insert data to user track table
                                    $data = array(
                                        'user_track_id' => '',
                                        'user_id' => '1', // admin
                                        'key_on_row' => $this->input->post('txt_census_id'),
                                        'tbl_name' => 'school_details_tbl',
                                        'act_type_id'=> '2',
                                        'note' => 'School details added',
                                        'date_added' => $now,
                                        'is_deleted' => '',
                                    );
                                    $user_track = $this->User_model->add_user_act($data);
                                    $this->session->set_flashdata('msg', array('text' => 'School added successfully','class' => 'alert alert-success'));
                                }else{
                                    $this->session->set_flashdata('msg', array('text' => 'could n\'t add school details!!!','class' => 'alert alert-danger'));
                                }
                                redirect('School/viewAddSchoolPage');
                            }
                        }
                    }   
                }
            }else{
                redirect('School/viewAddSchoolPage'); 
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    
    public function updateSchool(){     // this is used by school user and system admin
        if(is_logged_in()){
            if ($this->input->post('btn_update_school') == "Update"){

                //set validations
                if($this->session->userdata['userrole'] == 'School User'){
                    $censusId = $this->input->post('txt_census_id');                    
                    $this->session->set_userdata('censusid',$censusId);
                    $this->form_validation->set_rules("txt_census_id","Census ID","required|numeric|min_length[5]|max_length[5]");
                    //$this->form_validation->set_rules("txt_exam_no","Examination ID","required|numeric|min_length[5]|max_length[5]");
                    //$this->form_validation->set_rules("txt_school_name","School Name","required");
                    //$this->form_validation->set_rules("select_sch_type","School type","required");
                    //$this->form_validation->set_rules("txt_address1","Address 1","required");
                    //$this->form_validation->set_rules("txt_address2","Address 2","required");
                    //$this->form_validation->set_rules("txt_contact","Telephone number","required|numeric|min_length[10]|max_length[10]");
                    //$this->form_validation->set_rules("txt_email","Email","required|valid_email");  
                    //$this->form_validation->set_rules("select_edu_div","Education Devision","required");
                    //$this->form_validation->set_rules("select_gs_div","Grama Niladhari Devision","required");

                }
                //set validations
                if($this->session->userdata['userrole'] == 'System Administrator'){
                    // when admin try to update school data, he needs to keep census id
                    // therefore this code is used
                    $censusId = $this->input->post('txt_census_id');                    
                    $this->session->set_userdata('censusid',$censusId);
                    $this->form_validation->set_rules("txt_census_id","Census ID","required|numeric|min_length[5]|max_length[5]");
                    //$this->form_validation->set_rules("txt_exam_no","Examination ID","required|numeric|min_length[5]|max_length[5]");
                    //$this->form_validation->set_rules("txt_school_name","School Name","required");
                    //$this->form_validation->set_rules("select_sch_type","School type","required");
                    //$this->form_validation->set_rules("txt_address1","Address 1","required");
                    //$this->form_validation->set_rules("txt_address2","Address 2","required");
                    //$this->form_validation->set_rules("txt_contact","Telephone number","required|numeric|min_length[10]|max_length[10]");
                    //$this->form_validation->set_rules("txt_email","Email","required|valid_email");  
                    //$this->form_validation->set_rules("select_edu_div","Education Devision","trim|required");
                    //$this->form_validation->set_rules("select_gs_div","Grama Niladhari Devision","required");
                }
                //echo 'hi1';
                //echo ($this->form_validation->run()); die();
                if ($this->form_validation->run() == FALSE){
                    echo 'false'; die();
                    //validation fails
                    if($this->session->userdata['userrole'] == 'System Administrator'){
                        //redirect('School/viewUpdateSchoolPageByAdmin/'.$censusId);
                        //$this->viewUpdateSchoolPageByAdmin()->$censusId;
                        $this->viewUpdateSchoolPageByAdminAfterEdit();
                    }else{
                        $this->viewUpdateSchoolPage();
                    }
                }else{
                    //echo $this->input->post('select_gs_div'); die();
                    $now = date('Y-m-d H:i:s');
                   $data = array(
                        'census_id' => $this->input->post('txt_census_id'),
                        'exam_no' => $this->input->post('txt_exam_no'),
                        'sch_name' => $this->input->post('txt_school_name'),
                        'address1' => $this->input->post('txt_address1'),
                        'address2' => $this->input->post('txt_address2'),
                        'contact_no' => $this->input->post('txt_contact'),
                        'email' => $this->input->post('txt_email'),
                        'web_address' => $this->input->post('txt_webaddress'),
                        'pro_id' => $this->input->post('select_province'),
                        'dis_id' => $this->input->post('select_district'),
                        'zone_id' => $this->input->post('select_zone'),
                        'div_id' => $this->input->post('select_edu_div'),
                        'div_sec_id' => $this->input->post('select_div_sec'),
                        'gs_div_id' => $this->input->post('select_gs_div'),
                        'sch_type_id' => $this->input->post('select_sch_type'),
                        'belongs_to_id' => $this->input->post('select_belongs_to'),
                        'grd_span_id' => $this->input->post('select_grade_span'),
                        'user_id' => $this->input->post('user_id_hidden'),
                        'date_added' => $this->input->post('date_added_hidden'),
                        'date_updated' => $now,
                        'is_deleted' => $this->input->post('is_deleted_hidden'),
                    );
                    $id = $this->input->post('txt_census_id');
                    //print_r($data); die();
                    $result = $this->School_model->update_school($data,$id);
                    if($result){
                        // insert data to user track table
                        $data = array(
                            'user_track_id' => '',
                            'user_id' => $this->input->post('user_id_hidden'),
                            'key_on_row' => $this->input->post('txt_census_id'),
                            'tbl_name' => 'school_details_tbl',
                            'act_type_id'=> '3',
                            'note' => 'School details updated',
                            'date_added' => $now,
                            'is_deleted' => '',
                        );
                        $user_track = $this->User_model->add_user_act($data);
                        $this->session->set_flashdata('msg', array('text' => 'School details updated successfully','class' => 'alert alert-success'));
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'could n\'t update the school details!!!','class' => 'alert alert-danger'));
                    }
                    if($this->session->userdata['userrole'] == 'System Administrator'){ 
                        redirect(base_url().'School/viewUpdateSchoolPageByAdminAfterEdit?data='.json_encode($data));
                    }else{
                        redirect('School/viewUpdateSchoolPage');
                    }
                }
            }else{ 
                //echo 'hii'; die();
                if($this->session->userdata['userrole'] == 'System Administrator'){ 
                    redirect(base_url().'School/viewUpdateSchoolPageByAdminAfterEdit'); 
                }else{
                    redirect('School/viewUpdateSchoolPage');
                }
            } // end check submit button
        } else{
            redirect('GeneralInfo/loginPage');
        } // end login check
    } // end addSchool
    // delete school details from database by admin
    public function deleteSchool(){
        if( is_logged_in() && $this->session->userdata['userrole'] == 'System Administrator' ){
            $censusId = $this->uri->segment(3);
            $school = $this->School_model->view_school_data_by_id($censusId);
            foreach ($school as $row) {
                $userId = $row->user_id;
            }
            $deleteUser = $this->User_model->delete_user($userId);  // delete user data from user_tbl
            $deleteSchool = $this->School_model->delete_school($censusId); // delete school data from school_details_tbl
            if($deleteUser && $deleteSchool){
                // insert data to user track table
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'user_track_id' => '',
                    'user_id' => $this->userId,
                    'key_on_row' => $censusId,
                    'tbl_name' => 'school_details_tbl',
                    'act_type_id'=> '4',
                    'note' => 'School deletad',
                    'date_added' => $now,
                    'is_deleted' => '',
                );
                $user_track = $this->User_model->add_user_act($data);
                $this->session->set_flashdata('msg', array('text' => 'School and user data deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'School and user data couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            $this->findSchoolPage();
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function viewUpdateSchoolPage(){ // this is used by school user
        if(is_logged_in()){
            $userid = $this->session->userdata['userid'];
            $result = $this->School_model->get_logged_school($userid);
            $allProvince = $this->Common_model->get_all_province();
            $data['all_provinces'] = $allProvince;
            $data['school_details_result'] = $result;
            $data['title'] = 'Update school details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'school/editSchool';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } // end viewUpdateSchoolPage by school user
    public function viewUpdateSchoolPageByAdmin(){ // this is used by Administrator to update a school
        if(is_logged_in()){
            $censusId = $this->uri->segment(3);
            $result = $this->School_model->view_school_data_by_id($censusId);
            $data['school_details_result'] = $result;
            $data['title'] = 'Update school details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'school/editSchool';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function viewUpdateSchoolPageByAdminAfterEdit(){ // this is used by Administrator to view school details after update
        if(is_logged_in()){
            //echo 'sdfd'; die();
            $censusId =  $this->session->userdata['censusid']; 
            $result = $this->School_model->view_school_data_by_id($censusId);
            //print_r($result); die();
            $data['school_details_result'] = $result;
            $data['title'] = 'Update school details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'school/editSchool';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    function viewSchool(){
        if (isset($_POST['devision']) && $_POST['devision'] != '') {
            $data['schools'] = $this->School_model->get_school_by_devision();
        }else{
            $data['schools'] = $this->School_model->get_school();
        }
        if(empty($data['schools'])){
            $this->session->set_flashdata('msg', 'No records found!');
        }
        $data['title'] = 'School Details';
        $data['admin_content'] = 'school/view';
        $this->load->view('templates/admin_template', $data);
    }
    
    public function findSchoolPage(){ 
        if(is_logged_in()){             // a user login to system and find schools (school_user and admin)
            if($this->userRoleId == 3){
                $data['user_header'] = 'user_zeo_header';
            }elseif($this->userRoleId == 7){
                $data['user_header'] = 'user_edu_division_header';
            }elseif($this->userRoleId == 8){
                $data['user_header'] = 'user_zonal_file_header';
            }elseif($this->userRoleId == 9){
                $data['user_header'] = 'user_zonal_file_header';
            }else{
                $data['user_header'] = 'user_admin_header';
            }
            $data['title'] = 'View school details';   
            $data['user_content'] = 'school/findSchoolByUser'; 
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function findSchoolByCensusId(){
        if(is_logged_in() && $this->input->post('btn_view_sch_by_censusid') == "View"){
            $this->form_validation->set_rules("census_id_hidden","Census ID","trim|required|regex_match[/^[0-9]{5}$/]");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('msg', array('text' => 'Census ID is not correct!','class' => 'alert alert-danger'));
                redirect('School/findSchoolPage');
            }else{
                $censusId = $this->input->post('census_id_hidden');
                $result = $this->School_model->view_school_data_by_id($censusId);
                if($result){
                    if($this->userRoleId == 3){
                        $data['user_header'] = 'user_zeo_header';
                    }elseif($this->userRoleId == 7){
                        $data['user_header'] = 'user_edu_division_header';
                    }elseif($this->userRoleId == 8){
                        $data['user_header'] = 'user_zonal_file_header';
                    }elseif($this->userRoleId == 9){
                        $data['user_header'] = 'user_zonal_file_header';
                    }else{
                        $data['user_header'] = 'user_admin_header';
                    }
                    $data['school_info_by_census'] = $result;
                    $data['title'] = 'School Details';
                    $data['user_content'] = 'school/findSchoolByUser';
                    $this->load->view('templates/user_template', $data);
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                    redirect('School/findSchoolPage');                    
                }
            }

        }else{
            redirect('GeneralInfo/loginPage');
        }
    } 
    // used on findSchoolByUser page
    public function findSchoolsByEduDiv(){
        if(is_logged_in() && $this->input->post('btn_view_sch_by_edu_div') == "View"){
            $this->form_validation->set_rules("select_edu_div","Division","trim|required");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('msg', array('text' => 'Division is not correct!','class' => 'alert alert-danger'));
                redirect('School/findSchoolPage');
            }else{
                $divId = $this->input->post('select_edu_div');
                $result = $this->School_model->view_school_data_by_division($divId);
                if($result){
                    $data['school_info_by_division'] = $result;
                    $data['title'] = 'Divisional School Details';
                    $data['user_header'] = 'user_admin_header';
                    $data['user_content'] = 'school/findSchoolByUser';
                    $this->load->view('templates/user_template', $data);
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                    redirect('School/findSchoolPage');                    
                }
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function findSchoolsByType(){
        if(is_logged_in() && $this->input->post('btn_view_sch_by_type') == "View"){
            $this->form_validation->set_rules("select_sch_type","Type","trim|required");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('msg', array('text' => 'School type is not correct!','class' => 'alert alert-danger'));
                redirect('School/findSchoolPage');
            }else{
                $typeId = $this->input->post('select_sch_type');
                if ($this->userRoleId==7) {
                    $eduDivId = $this->session->userdata['div_id'];
                    $result = $this->School_model->view_school_data_by_type($typeId,$eduDivId);
                }else{
                    $result = $this->School_model->view_school_data_by_type($typeId);
                }
                if($result){
                    if($this->userRoleId=='3'){
                        $data['user_header'] = 'user_zeo_header';
                    }elseif($this->userRoleId=='7'){
                        $data['user_header'] = 'user_edu_division_header';
                    }elseif($this->userRoleId=='8'){
                        $data['user_header'] = 'user_zonal_file_header';
                    }elseif($this->userRoleId=='9'){
                        $data['user_header'] = 'user_zonal_file_header';
                    }else{
                        $data['user_header'] = 'user_admin_header';
                    }
                    $data['school_info_by_type'] = $result;
                    $data['title'] = 'School Details by Type';
                    $data['user_content'] = 'school/findSchoolByUser';
                    $this->load->view('templates/user_template', $data);
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                    redirect('School/findSchoolPage');                    
                }
            }

        }else{
            redirect('GeneralInfo/loginPage');
        }
    } 
    public function findAllSchools(){
        if ($this->userRoleId==7) {
            $eduDivId = $this->session->userdata['div_id'];
            $result = $this->School_model->view_school_data_by_division($eduDivId);
        }else{
            $result = $this->School_model->view_all_schools();
        }
        if($result){
            if($this->userRoleId=='3'){
                $data['user_header'] = 'user_zeo_header';
            }elseif($this->userRoleId=='7'){
                $data['user_header'] = 'user_edu_division_header';
            }elseif($this->userRoleId=='8'){
                $data['user_header'] = 'user_zonal_file_header';
            }elseif($this->userRoleId=='9'){
                $data['user_header'] = 'user_zonal_file_header';
            }else{
                $data['user_header'] = 'user_admin_header';
            }
            $data['all_school_info'] = $result;
            $data['title'] = 'All School Details';
            $data['user_content'] = 'school/findSchoolByUser';
            $this->load->view('templates/user_template', $data);
        }else{
            $this->session->set_flashdata('msg', array('text' => 'No records found!','class' => 'alert alert-danger'));
            redirect('school/findSchoolPage');                    
        }
    }
    public function viewNationalSchools(){
        $result = $this->School_model->view_national_schools();
        if($result){
            $data['national_school_info'] = $result;
            $data['title'] = 'National School Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'school/findSchoolByUser';
            $this->load->view('templates/user_template', $data);
        }else{
            $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
            redirect('School/findSchoolPage');                    
        }

    }
    public function view1ABSchools(){
        $result = $this->School_model->view_1AB_schools(); 
        // i did not use view_school_data_by_type method, since
        // i have to pass the type id to school model method.
        if($result){
            $data['oneAB_school_info'] = $result;
            $data['title'] = '1AB School Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'school/findSchoolByUser';
            $this->load->view('templates/user_template', $data);
        }else{
            $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
            redirect('School/findSchoolPage');                    
        }
    }
    public function view1CSchools(){
        $result = $this->School_model->view_1C_schools();   
        // i did not use view_school_data_by_type method, since
        // i have to pass the type id to school model method.
        if($result){
            $data['oneC_school_info'] = $result;
            $data['title'] = '1C School Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'school/findSchoolByUser';
            $this->load->view('templates/user_template', $data);
        }else{
            $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
            redirect('School/findSchoolPage');                    
        }
    }
    public function viewType2Schools(){
        $result = $this->School_model->view_type2_schools();
        if($result){
            $data['type2_school_info'] = $result;
            $data['title'] = 'Type 2 School Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'school/findSchoolByUser';
            $this->load->view('templates/user_template', $data);
        }else{
            $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
            redirect('School/findSchoolPage');                    
        }
    }
    public function viewType3Schools(){
        $result = $this->School_model->view_type3_schools();
        if($result){
            $data['type3_school_info'] = $result;
            $data['title'] = 'Type 3 School Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'school/findSchoolByUser';
            $this->load->view('templates/user_template', $data);
        }else{
            $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
            redirect('School/findSchoolPage');                    
        }
    }
     // used when update school info by school user
    public function viewDistricts(){
        $proId = $_POST['pro_id']; 
        $condition = ' dt.pro_id="'.$proId.'" ';
        $data = $this->Common_model->get_districts($condition);  
        //print_r($data); die();
        echo json_encode($data);  
    }
    // used when update school info by school user
    public function viewZones(){
        $disId = $_POST['dis_id']; 
        $condition = ' ezt.dis_id="'.$disId.'" ';
        $data = $this->Common_model->get_zones($condition);  
        //print_r($data); die();
        echo json_encode($data);  
    }
    // used when update school info by school user 
    // get educational divisions
    public function viewDivisions(){ 
        $zoneId = $_POST['zone_id']; 
        $condition = ' edt.zone_id="'.$zoneId.'" ';
        $data = $this->Common_model->get_divisions($condition);  
        //print_r($data); die();
        echo json_encode($data);  
    }
    // used by admin when insert new edu. division user in user -> index view
    // get educational divisions
    public function viewDivisionsList(){ 
        // POST data
        $postData = $this->input->post();
        // Get data
        $data = $this->Common_model->get_divisions_list($postData);  

        echo json_encode($data); 
    }
    // used when update school info by school user 
    // get divisional secretariats
    public function viewDivSecretariat(){ 
        $disId = $_POST['dis_id']; 
        $condition = ' dst.dis_id="'.$disId.'" ';
        $data = $this->Common_model->get_div_secretariat($condition);  
        //print_r($data); die();
        echo json_encode($data);  
    }
    // used when update school info by school user 
    // get grama niladhari divisions
    public function viewGsDivisions(){ 
        $disId = $_POST['dis_id']; 
        $divSecId = $_POST['div_sec_id']; // district id
        $divSec = $this->Common_model->get_div_secretariat_by_id($divSecId);
        foreach ($divSec as $row) {
            $divSecDisId = $row->div_sec_dis_id;
        }
        $condition = ' gsdt.dis_id="'.$disId.'" and  gsdt.div_sec_dis_id="'.$divSecDisId.'"';
        $data = $this->Common_model->get_gs_divisions($condition);  
        //print_r($data); die();
        echo json_encode($data);  
    }
    // used by admin, zonal user, director when search students school wise in student -> student_reports view
    // get school list while typing the school name - auto complete
    public function viewSchoolList(){ 
        // POST data
        $postData = $this->input->post();
        // Get data
        $data = $this->Common_model->get_school_list($postData);  

        echo json_encode($data); 
    }
}
?>