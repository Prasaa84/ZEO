<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('School_model');
        $this->load->model('Student_model');
        $this->load->model('User_model');
        $this->load->model('Alert_model');
        $this->load->model('Grade_model');
        $this->load->model('Class_model');        
        $this->all_edu_div = $this->view_all_edu_divisions(); // view divisions in find school page
        if($this->session->userdata['userrole'] == 'System Administrator' || $this->session->userdata['userrole'] == 'Divisional User'){
            $this->student_count = $this->view_student_count_schoolwise(); // for bar chart in admin dashboard
            $this->student_count_genderwise = $this->view_student_count_genderwise(); // for bar chart in admin dashboard        
        }
        if($this->session->userdata['userrole'] == 'School User'){
            //$this->no_of_stu_by_grade = $this->count_stu_by_grd(); // for bar chart in student dashboard
            $this->student_count= $this->view_student_count_gradewise(); // for bar chart in student dashboard
            $this->student_count_genderwise = $this->view_student_count_genderwise(); // for bar chart in student dashboard        
        }
        //print_r($this->no_of_stu_by_grade); print_r($this->grades_available);die();
        $this->all_sch_types = $this->view_all_sch_types(); // view school types in find school page
        $this->all_grades = $this->view_all_grades();
        $this->all_classes = $this->view_all_classes();        
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
            return $this->Alert_model->view_all_alerts();
        }
    }  
    public function index(){ 
        if(is_logged_in()){
            $data['title'] = 'Student Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'student/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // view recent updated date and time of school details
    // this is called by construct method
    public function view_recent_std_update_dt(){ 
        return $this->Student_model->view_recent_sch_update_dt();
    }  
    // this method called by this construct method
    public function view_all_edu_divisions(){ 
        return $this->School_model->view_all_edu_divisions();
    }
    // this method called by this construct method
    public function view_all_sch_types(){ 
        return $this->School_model->view_all_sch_types();
    } 
    // this method called by this construct method
    public function view_all_grades(){ 
        return $this->Grade_model->view_all_grades();
    }
    // this method called by this construct method
    public function view_all_classes(){ 
        return $this->Class_model->view_all_classes();
    }
    // this method called by this construct method
    public function count_stu_by_grd(){ 
       // if($this->session->userdata['userrole_id'] == '2'){
            $censusId = $this->session->userdata['census_id'];
            //return $this->Student_model->count_stu_by_grd($censusId);
            $data = $this->Student_model->count_stu_by_grd($censusId);
            return(json_encode($data));
       // }
    }
    // this method called by this construct method for student login
    public function view_student_count_gradewise(){ 
        $censusId = $this->session->userdata['census_id'];
        $grades = $this->Student_model->count_student_gradewise($censusId);
        if(!empty($grades)){
            $data = [];
            $last_update_date = '';
            foreach ($grades as $grade) {
                if($grade->date_updated > $last_update_date){
                    $last_update_date = $grade->date_updated;
                }
            }
            foreach($grades as $row) {
                $data['label'][] = $row->grade_id;
                $data['data'][] = $row->no_of_students;
                $data['date_updated'][] = $last_update_date;
            }
            return(json_encode($data));
        }
    }
    // this method called by this construct method for student login
    public function view_student_count_genderwise(){ 
        //$censusId = $this->session->userdata['census_id'];
        $stds = $this->Student_model->count_student_genderwise();
        if(!empty($stds)){
            $data = [];
            foreach($stds as $row) {
                $data['gender'][] = $row->gender_name;
                $data['std_count'][] = $row->std_count;
            }
            return(json_encode($data));
        }
    }
    // this method called by this construct method for admin login
    public function view_student_count_schoolwise(){ 
        $st_data = $this->Student_model->count_student_schoolwise();

        if(!empty($st_data)){
            $data = [];
            $last_update_date = '';
            foreach ($st_data as $st) {
                if($st->date_updated > $last_update_date){
                    $last_update_date = $st->date_updated;
                }
            }
            foreach($st_data as $row) {
                $data['label'][] = $row->census_id;
                $data['data'][] = $row->no_of_students;
                $data['date_updated'][] = $last_update_date;
            }  
        }
        //print_r(json_encode($data)); die();
        return(json_encode($data));
    }
    public function addStudent(){
        if(is_logged_in()){
            if ($this->input->post('btn_add_new_student_info') == "Add_New"){
                //set validations
                $this->form_validation->set_rules("index_no_txt","Index number","required|numeric");
                $this->form_validation->set_rules("full_name_txt","Full Name","required");
                $this->form_validation->set_rules("name_with_ini_txt","Name with initials","required");
                $this->form_validation->set_rules("gender_select","Gender","required");            
                $this->form_validation->set_rules("grade_select","Grade","required");
                $this->form_validation->set_rules("class_select","Class","required");
                
                if ($this->form_validation->run() == false){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Index Number, Full Name, Name with initials, Gender, Grade and Class are required!','class' => 'alert alert-danger'));
                    $this->viewStudent();
                }else{
                    // validation succeeds
                    $index_no= $this->input->post('index_no_txt');
                    $student_exist = $this->Student_model->view_student_by_id($index_no); 
                    if($student_exist){
                        $this->session->set_flashdata('msg', array('text' => 'Index No - '.$index_no.' already exists!!!','class' => 'alert alert-danger'));
                        redirect('Student/viewStudent');                       
                    }else{
                        if(!empty($this->input->post('response_person_name_txt'))){
                            $now = date('Y-m-d H:i:s');
                            $data = array(
                                'response_person_id' => '',
                                'res_p_name' => $this->input->post('response_person_name_txt'),
                                'phone_no' => $this->input->post('response_person_tel_txt'),
                                'occupation' => $this->input->post('response_person_job_txt'),
                                'relationship' => $this->input->post('response_person_relationship_txt'),
                                'date_added' => $now,
                                'date_updated' => $now,
                                'is_deleted' => '',
                            ); 
                            $parent_id = $this->Student_model->add_parent($data); 
                            if(empty($parent_id)){
                                $this->session->set_flashdata('msg', array('text' => 'could n\'t add parent details!!!','class' => 'alert alert-danger'));
                                redirect('Student/viewStudent');
                            }
                        }else{
                            $parent_id = '';
                        }
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'st_id' => '',
                            'index_no' => $this->input->post('index_no_txt'),
                            'fullname' => $this->input->post('full_name_txt'),
                            'name_with_initials' => $this->input->post('name_with_ini_txt'),
                            'address1' => $this->input->post('address1_txt'),
                            'address2' => $this->input->post('address2_txt'),
                            'phone_no' => $this->input->post('tel_txt'),
                            'dob' => $this->input->post('dob_txt'),
                            'gender_id' => $this->input->post('gender_select'),
                            'd_o_admission' => $this->input->post('gender_select'),
                            'census_id' => $this->input->post('census_id_select'),
                            'grade_id' => $this->input->post('grade_select'),
                            'class_id' => $this->input->post('class_select'),
                            'response_person_id' => $parent_id,
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                            );
                        if(!empty($_FILES['student_image']['name'])){
                            $config['upload_path']          = './assets/uploaded/studentImage/';
                            $config['allowed_types']        = 'gif|jpg|png';
                            $config['max_size']             = 100; // 100KB
                            $config['max_width']            = 1024;
                            $config['max_height']           = 768;
                            $config['file_name']            = $this->input->post('index_no_txt');
                            $config['overwrite']           = TRUE;

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('student_image')){
                                $uploadError = array('error' => $this->upload->display_errors());
                                $this->session->set_flashdata('uploadError',$uploadError);
                            }else{
                                $uploadSuccess = 'Image uploaded successfully';
                                $this->session->set_flashdata('uploadSuccess',$uploadSuccess);
                            }
                        }
                        $result = $this->Student_model->add_student($data); 
                        if($result){
                            $this->session->set_flashdata('msg', array('text' => 'Student added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('msg', array('text' => 'could n\'t add student details!!!','class' => 'alert alert-danger'));
                        }
                        redirect('Student/viewStudent');
                    }
                }   
            }else{redirect('Student/viewStudent'); }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }  // view student after added
    public function viewStudent(){
        if(is_logged_in()){
            $userrole = $this->session->userdata['userrole'];
            if($userrole == 'School User'){ // if the user is school, then student details must be displayed by census id
                $censusId = $this->session->userdata['census_id'];
                //$result = $this->School_model->get_logged_school($userid); 
                $studentDetails = $this->Student_model->view_students_school_wise($censusId); 
                if(!$studentDetails){
                    $this->session->set_flashdata('no_student_info', array('text' => 'No records found!!!','class' => 'alert alert-danger'));
                }else{
                    $data['student_info_by_census'] = $studentDetails;
                }
            }
            $data['title'] = 'Student Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'student/viewStudent';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
   
    
    public function editStudentInfoPage(){ // this is used by school user
        if(is_logged_in()){
            $stuId = $this->uri->segment(3);
            $censusId = $this->uri->segment(4);
            $result = $this->Student_model->get_stu_info($stuId,$censusId);
            $data['student_result'] = $result;
            $data['title'] = 'Update student details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'student/editStudent';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } // end viewUpdateSchoolPage by school user
    public function studentReportsPage(){ 
        if(is_logged_in()){             // a user login to system and find schools (school_user and admin)
            $data['title'] = 'Student Reports';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'student/findStudents';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function findStudentByIndex(){
        if(is_logged_in() && $this->input->post('btn_view_stu_by_index') == "View"){
            $this->form_validation->set_rules("index_no_txt","Index Number","trim|required|regex_match[/^[0-9]{4}$/]");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('msg', array('text' => 'Index Number is not correct!','class' => 'alert alert-danger'));
                redirect('Student/studentReportsPage');
            }else{
                $indexNo = $this->input->post('index_no_txt');
                $result = $this->Student_model->get_stu_info_by_index($indexNo);
                if($result){
                    $data['student_info'] = $result;
                    $data['title'] = 'Student Details';
                    $data['user_header'] = 'user_admin_header';
                    $data['user_content'] = 'Student/findStudents';
                    $this->load->view('templates/user_template', $data);
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                    redirect('Student/studentReportsPage');                    
                }
            }

        }else{
            redirect('GeneralInfo/loginPage');
        }
    }    
}