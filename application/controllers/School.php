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
        $this->all_gs_div = $this->view_all_gs_divisions(); // view divisions in find school page
        $this->all_edu_div = $this->view_all_edu_divisions(); // view divisions in find school page
        $this->all_sch_types = $this->view_all_sch_types(); // view school types in find school page
        $this->recent_update_dt_school = $this->view_recent_sch_update_dt(); // view latest school details update date
        $this->no_of_national_schools = $this->count_national_schools(); // needed count of national schools in find schools page
        $this->no_of_1AB_schools = $this->count_1AB_schools(); // needed count of school types in find schools page
        $this->no_of_1C_schools = $this->count_1C_schools();    // needed count of school types in find schools page
        $this->no_of_type2_schools = $this->count_type2_schools();  // needed count of school types in find schools page
        $this->no_of_type3_schools = $this->count_type3_schools();  // needed count of school types in find schools page
        $this->phy_res_alert = $this->viewPhyResAlert(); // when user goes through pages view physical resource alerts, if available
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
    public function index(){ 
        if(is_logged_in()){
            $data['title'] = 'School Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'school/index';
            $this->load->view('templates/user_template', $data);
        }else{
            //die();
            redirect('GeneralInfo/loginPage');
        }    
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
    public function view_all_gs_divisions(){ 
        return $this->School_model->view_all_gs_divisions();
    }
    // this method called by this construct method
    public function view_all_sch_types(){ 
        return $this->School_model->view_all_sch_types();
    } 
    // this method called by this construct method
    public function count_national_schools(){ 
        return $this->School_model->count_national_schools();
    } 
    // this method called by this construct method
    public function count_1AB_schools(){ 
        return $this->School_model->count_1AB_schools();
    }
    // this method called by this construct method
    public function count_1C_schools(){ 
        return $this->School_model->count_1C_schools();
    }  
    // this method called by this construct method
    public function count_type2_schools(){ 
        return $this->School_model->count_type2_schools();
    }   
    // this method called by this construct method
    public function count_type3_schools(){ 
        return $this->School_model->count_type3_schools();
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
            if ($this->input->post('btn_insert_school') == "Submit"){
                //set validations
                $this->form_validation->set_rules("txt_census_id","Census ID","required|numeric|min_length[5]|max_length[5]");
                $this->form_validation->set_rules("txt_school_name","School Name","required");
                $this->form_validation->set_rules("select_sch_type","School type","required");
                $this->form_validation->set_rules("txt_email","Email","required|valid_email");            
                $this->form_validation->set_rules("select_edu_div","Education Devision","required");
                $this->form_validation->set_rules("select_belongs_to","Which School","required");
                
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->viewAddSchoolPage();
                }else{
                    // validation succeeds
                    $id = $this->input->post('txt_census_id');
                    $school_exist = $this->School_model->view_school_by_id($id); 
                    if($school_exist){
                        $this->session->set_flashdata('msg', array('text' => 'This School with census id - '.$id.' already exists!!!','class' => 'alert alert-danger'));
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
                        if(!$id){
                            $this->session->set_flashdata('msg', array('text' => 'Could n\'t add school user!!!','class' => 'alert alert-danger'));
                            redirect('School/viewAddSchoolPage');                   
                        }else{ 
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
                                'gs_division' => '',
                                'edu_div_id' => $this->input->post('select_edu_div'),
                                'sch_type_id' => $this->input->post('select_sch_type'),
                                'belongs_to_id' => $this->input->post('select_belongs_to'),
                                'user_id' => $user_id,
                                'date_added' => $now,
                                'date_updated' => $now,
                                'is_deleted' => '',
                                );
                            $result = $this->School_model->add_school($data);
                            if($result){
                                // insert data to user track table
                                $data = array(
                                    'user_track_id' => '',
                                    'user_id' => '1', // admin
                                    'key_on_row' => $this->input->post('txt_census_id'),
                                    'tbl_name' => 'school_details_tbl',
                                    'act_type_id'=> '2',
                                    'note' => 'School details added',
                                    'date_added' => $now,
                                    'is_deleted' => $this->input->post('is_deleted_hidden'),
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
            }else{redirect('School/viewAddSchoolPage'); }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function updateSchool(){     // this is used by school user and system admin
        if(is_logged_in()){
            if ($this->input->post('btn_update_school') == "Update"){
                // when admin try to update school data, he needs to keep census id
                // therefore this code is used
                if($this->session->userdata['userrole'] == 'System Administrator'){
                    $censusId = $this->input->post('txt_census_id');                    
                    $this->session->set_userdata('censusid',$censusId);
                }
                //set validations
                $this->form_validation->set_rules("txt_census_id","Census ID","required|numeric|min_length[5]|max_length[5]");
                $this->form_validation->set_rules("txt_exam_no","Examination ID","required|numeric|min_length[5]|max_length[5]");
                $this->form_validation->set_rules("txt_school_name","School Name","required");
                $this->form_validation->set_rules("select_sch_type","School type","required");
                //$this->form_validation->set_rules("txt_address1","Address 1","required");
                //$this->form_validation->set_rules("txt_address2","Address 2","required");
                //$this->form_validation->set_rules("txt_contact","Telephone number","required|numeric|min_length[10]|max_length[10]");
                //$this->form_validation->set_rules("txt_email","Email","required|valid_email");            
                $this->form_validation->set_rules("select_gs_div","Grama Niladhari Devision","required");
                $this->form_validation->set_rules("select_edu_div","Education Devision","required");
                echo 'hi1';
                //echo ($this->form_validation->run()); die();
                if ($this->form_validation->run() == FALSE){
                    //echo 'false'; die();
                    //validation fails
                    if($this->session->userdata['userrole'] == 'System Administrator'){
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
                        'gs_div_id' => $this->input->post('select_gs_div'),
                        'edu_div_id' => $this->input->post('select_edu_div'),
                        'sch_type_id' => $this->input->post('select_sch_type'),
                        'belongs_to_id' => $this->input->post('select_belongs_to'),
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
                            'is_deleted' => $this->input->post('is_deleted_hidden'),
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
    // delete school details from database
    public function deleteSchool(){
        if(is_logged_in() && $this->session->userdata['userrole'] == 'System Administrator'){
            $censusId = $this->uri->segment(3);
            $school = $this->School_model->view_school_data_by_id($censusId);
            foreach ($school as $row) {
                $userId = $row->user_id;
            }
            $deleteUser = $this->User_model->delete_user($userId);  // delete user data from user_tbl
            $deleteSchool = $this->School_model->delete_school($censusId); // delete school data from school_details_tbl
            if($deleteUser && $deleteSchool){
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
            $data['title'] = 'View school details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'school/findSchoolByUser';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function findSchoolByCensusId(){
        if(is_logged_in() && $this->input->post('btn_view_sch_by_censusid') == "View"){
            $this->form_validation->set_rules("censusid_txt","Census ID","trim|required|regex_match[/^[0-9]{5}$/]");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('msg', array('text' => 'Census ID is not correct!','class' => 'alert alert-danger'));
                redirect('School/findSchoolPage');
            }else{
                $censusId = $this->input->post('censusid_txt');
                $result = $this->School_model->view_school_data_by_id($censusId);
                if($result){
                    $data['school_info_by_census'] = $result;
                    $data['title'] = 'School Details';
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
                    $data['user_content'] = 'School/findSchoolByUser';
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
                $result = $this->School_model->view_school_data_by_type($typeId);
                if($result){
                    $data['school_info_by_type'] = $result;
                    $data['title'] = 'School Details by Type';
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
    public function findAllSchools(){
        if($this->input->post('btn_view_all_sch') == "View"){
            $orderByDivision = $this->input->post('checkOrderByDivision'); 
            if($orderByDivision){ // if the user need to order by division
                $orderBy = 'edu_div_id';
                $result = $this->School_model->view_all_schools_order_by($orderBy);
            }else{
                $result = $this->School_model->view_all_schools();
            }
            if($result){
                $data['all_school_info'] = $result;
                $data['title'] = 'All School Details';
                $data['user_header'] = 'user_admin_header';
                $data['user_content'] = 'school/findSchoolByUser';
                $this->load->view('templates/user_template', $data);
            }else{
                $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                redirect('school/findSchoolPage');                    
            }
        }else{
            redirect('School/findSchoolPage');                    
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
}
?>