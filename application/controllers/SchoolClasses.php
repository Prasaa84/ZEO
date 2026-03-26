<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Define Grade and classes of school
class SchoolClasses extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('SchoolGrade_model'); 
        $this->load->model('SchoolClass_model'); 
        $this->load->model('Staff_model');
        $this->load->model('Student_model');
        if(is_logged_in()){
            $this->userrole = $this->session->userdata['userrole'];
            $this->userrole_id = $this->session->userdata['userrole_id']; 
        }
    }
    public function index(){ 
        if(is_logged_in()){
            if( $this->userrole_id == '2' ){ 
                $censusId = $this->session->userdata['census_id'];
                $year = date('Y');
                $schoolClasses = $this->SchoolClass_model->get_school_classes_by_census_id($censusId,$year); 
                //$schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId,$year);
                $schoolStaff = $this->Staff_model->get_all_academic_staff_school_wise($censusId);
                $data['schoolStaff'] = $schoolStaff; 
            }else{
                $data['all_schools'] = $this->Common_model->get_all_schools();
                $schoolClasses = '';
                $schoolGrades = '';
            }
            $data['title'] = 'School Classes';
            $data['user_header'] = 'user_admin_header';
            //$data['schoolGrades'] = $schoolGrades;
            $data['schoolClasses'] = $schoolClasses;
            $data['user_content'] = 'classes/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }   
    }
    // add new class to a schoool grade by school user or admin
    public function addSchClasses(){
        if(is_logged_in()){
            if($this->input->post('btn_add_sch_cls')){
                $this->form_validation->set_rules("grade_select","Grade","required");
                if($this->userrole_id != '2'){
                    $this->form_validation->set_rules("select_school_in_modal_form","School","required");
                }
                if ($this->form_validation->run() == false){
                    //validation fails
                    if($this->userrole_id != '2'){
                        $this->session->set_flashdata('grdMsg', array('text' => 'School and the Grade are required!!!','class' => 'alert alert-danger'));
                    }else{
                        $this->session->set_flashdata('grdMsg', array('text' => 'Grade is required!!!','class' => 'alert alert-danger'));
                    }
                    redirect('SchoolGrades');
                }else{
                    if($this->userrole_id == '2'){
                        $censusId = $this->session->userdata['census_id'];
                    }else{
                        $censusId = $this->input->post('select_school_in_modal_form'); // fetch from bootstrap modal form
                    }
                    $year = $this->input->post('year_select_new_class');
                    $gradeId = $this->input->post('grade_select');
                    $noOfCls = $this->input->post('no_of_cls_select');
                    $approvedStd = $this->input->post('no_of_std');
                    for ($i=1; $i <= $noOfCls; $i++) { 
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'sch_grd_cls_id' => '',
                            'grade_id' => $gradeId, 
                            'class_id' => $i,
                            'census_id' => $censusId, // logged user school
                            'stf_nic' => '', // can update this later in class update view
                            'approved_std_count' => $approvedStd, 
                            'student_count' => '', // can update this later in class update view
                            'year' => $year,  // current year
                            'date_added' => $now,
                            'date_updated'=> $now, // update
                            'is_deleted' => '',
                        ); 
                        // check class_id exists for this year in this grade of this school
                        $classExists = $this->SchoolClass_model->check_school_class_exists($gradeId,$i,$censusId,$year);
                        if(!$classExists){
                            $result = $this->SchoolClass_model->insert_school_classes($data);
                        }
                    }
                }
                if($result){
                    $this->session->set_flashdata('clsMsg', array('text' => 'Classes added successfully','class' => 'alert alert-success'));
                }else{
                    $this->session->set_flashdata('clsMsg', array('text' => 'Error or already exists!!!','class' => 'alert alert-danger'));
                }
            }else{
                $this->session->set_flashdata('grdClsMsg', array('text' => 'Please select the grades','class' => 'alert alert-danger'));
            }
            redirect('SchoolClasses');
        }else{
            redirect('User');
        }
    }
    // update the Class info
    public function updateSchoolClass(){
        if(is_logged_in()){
            if($this->input->post('btn_update_sch_cls') == "Save"){
                $sch_grd_cls_id = $this->input->post('sch_grd_cls_id_hidden');
                $censusId = $this->input->post('census_id_hidden'); // school census id
                $classId = $this->input->post('class_id_hidden'); // school census id
                $approvedStd = $this->input->post('approved_std_count_txt');
                $std_count = $this->input->post('std_count_txt');
                $cls_tr = $this->input->post('cls_tr_select'); 
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'sch_grd_cls_id' => $sch_grd_cls_id,
                    'approved_std_count' => $approvedStd,
                    'student_count' => $std_count,
                    'stf_nic' => $cls_tr,
                    'date_updated' => $now,
                ); 
                $year = date('Y');
                if( !empty($cls_tr) ){
                    // check class teacher already exists in a class this year
                    $classTeacherExistsInAnotherClass = $this->SchoolClass_model->check_cls_tr_exists_in_another_grade( $censusId, $cls_tr, $year);
                    //echo $gradeHeadExistsInAnotherGrade; die();
                    if($classTeacherExistsInAnotherClass){
                        $this->session->set_flashdata('clsMsg', array('text' => 'Teacher is already in another class!!!','class' => 'alert alert-danger'));
                        redirect('SchoolClasses');
                    }else{
                        $result = $this->SchoolClass_model->update_school_class($data);
                    } 
                }else{
                    $result = $this->SchoolClass_model->update_school_class($data);
                }
                if($result){
                    $this->session->set_flashdata('clsMsg', array('text' => 'Class updated successfully','class' => 'alert alert-success','update'=>'true'));
                }else{
                    $this->session->set_flashdata('clsMsg', array('text' => 'Class could n\'t updated','class' => 'alert alert-danger','update'=>'false'));
                }   
                redirect('SchoolClasses');
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // when upload bulk students data, this is used
    // used in marks index page and student index page(insert model)
    public function viewClassesGradeWise(){
        $gradeId = $_POST['grade_id']; 
        $censusId = $_POST['census_id'];
        $year = $_POST['year'];        
        $condition = 'sgct.grade_id="'.$gradeId.'" and sgct.census_id="'.$censusId.'" and sgct.year="'.$year.'" ';
        $data = $this->SchoolClass_model->get_classes_grade_wise($condition);  
        //print_r($data); die();
        echo json_encode($data);  
    } 
    // view grades assigned for the school (Not all the grades available in db)
    // used by only the admin
    public function viewSchoolClasses(){ 
        if(is_logged_in()){
            $all_schools = $this->Common_model->get_all_schools();
            $data['all_schools'] = $all_schools;
            if( $this->input->post('btn_view_classes') == 'View' ){ 
                $this->form_validation->set_rules("year_select","Year","required");
                if( $this->userrole_id != 2){
                    $this->form_validation->set_rules("select_school","School","required");
                }
                if ( $this->form_validation->run() == false ){
                    //validation fails
                    //echo $year = $this->input->post('year_select'); die();
                    if( $this->userrole_id != 2){
                        $this->session->set_flashdata('clsMsg', array('text' => 'Year and School are required','class' => 'alert alert-danger'));
                    }else{
                        $this->session->set_flashdata('clsMsg', array('text' => 'Year is required','class' => 'alert alert-danger'));
                    }    
                    redirect('SchoolClasses');
                }else{
                    if( $this->userrole_id != 2 ){
                        $censusId = $this->input->post('select_school');
                    }else{
                        $censusId = $this->input->post('census_id_hidden');
                    }
                    $year = $this->input->post('year_select');
                    $schoolClasses = $this->SchoolClass_model->get_school_classes_by_census_id($censusId,$year); 
                    if( empty($schoolClasses) ){
                        $this->session->set_flashdata('clsMsg', array('text' => 'No classes found in '.$year,'class' => 'alert alert-danger'));
                    }else{
                        $data['schoolClasses'] = $schoolClasses;
                    }
                }                        
            }
            $schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id( $censusId, $year );
            $schoolStaff = $this->Staff_model->get_all_academic_staff_school_wise( $censusId );
            //$schoolStaff = $this->Staff_model->get_who_not_class_teachers( $censusId );
            $data['schoolStaff'] = $schoolStaff;
            $data['schoolGrades'] = $schoolGrades;
            $data['title'] = 'Classes of the school';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'classes/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }   
    }
    public function viewClassReports(){ 
        if(is_logged_in()){
            $role_id = $this->session->userdata['userrole_id'];
            if($role_id == '2'){ 
                $censusId = $this->session->userdata['census_id'];
                $year = date('Y');
                $schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId,$year); 
                $data['schoolGrades'] = $schoolGrades;
                $schoolClasses = $this->SchoolClass_model->get_school_classes_by_census_id($censusId,$year); 
                $data['schoolClasses'] = $schoolClasses; 
            }
            if($role_id != '2'){
                if( $this->userrole_id==7 ) {
                    $eduDivId = $this->session->userdata['div_id'];
                    $all_schools = $this->Common_model->get_all_schools($eduDivId);
                }else{
                    $all_schools = $this->Common_model->get_all_schools();
                }
                $data['all_schools'] = $all_schools;
                if($this->input->post('btn_view_grades_by_school') == 'View'){ 
                    $this->form_validation->set_rules("select_school","School","required");
                    if ($this->form_validation->run() == false){
                        //validation fails
                        $this->session->set_flashdata('clsMsg', array('text' => 'Please select school!','class' => 'alert alert-danger'));
                        //redirect('SchoolClasses/viewGradeClassReports');
                    }else{
                        $censusId = $this->input->post('select_school');
                        $schoolGrades = $this->SchoolClass_model->get_school_grades_by_census_id($censusId);               
                        $data['schoolGrades'] = $schoolGrades; 
                        $schoolClasses = $this->SchoolClass_model->get_school_classes_by_census_id($censusId,$year); 
                        $data['schoolClasses'] = $schoolClasses; 
                    }                        
                }
            }
            if($role_id == '7'){
            	$data['user_header'] = 'user_edu_division_header';
            }else{
            	$data['user_header'] = 'user_admin_header';
            }
            $data['title'] = 'Class Reports';
            $data['user_content'] = 'classes/classReports';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }   
    }
    // used by admin and school in classes->classReports view
    public function classReports(){ 
        if(is_logged_in()){
            if($this->input->post('btn_view_classes_in_reports') == 'View'){ 
                //echo $year = $this->input->post('year_select');
                //echo $censusId = $this->input->post('select_school'); die();
                $this->form_validation->set_rules("year_select","Year","required");
                if($this->userrole_id == '2'){ 
                    $censusId = $this->session->userdata['census_id'];
                }else{
                    $this->form_validation->set_rules("select_school","School","required");
                    $censusId = $this->input->post('select_school');
                }
                if ($this->form_validation->run() == false){
                    //validation fails
                    if($this->userrole_id == '2'){ 
                        $this->session->set_flashdata('clsMsg', array('text' => 'Please select the Year!','class' => 'alert alert-danger'));
                    }else{
                        $this->session->set_flashdata('clsMsg', array('text' => 'Please select Year and the School!','class' => 'alert alert-danger'));
                    }
                    redirect('SchoolClasses/viewClassReports');
                }else{ 
                    $year = $this->input->post('year_select');
                    if($this->userrole_id != '2'){
                        $all_schools = $this->Common_model->get_all_schools();
                        $data['all_schools'] = $all_schools;
                    }
                    $schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId,$year);
                    $data['schoolGrades'] = $schoolGrades;
                    $schoolClasses = $this->SchoolClass_model->get_school_classes_by_census_id($censusId,$year); 
                    if(empty($schoolClasses)){
                        $this->session->set_flashdata('clsMsg', array('text' => 'No classes found in '.$year,'class' => 'alert alert-danger'));
                		//$this->viewClassReports();
                    	redirect('SchoolClasses/viewClassReports');
                    }else{
                    	if($this->userrole_id == '7'){
		            		$data['user_header'] = 'user_edu_division_header';
			            }else{
			            	$data['user_header'] = 'user_admin_header';
			            }                    
			            $data['schoolClasses'] = $schoolClasses;
	                    $data['title'] = 'Class Reports';
	                    $data['user_content'] = 'classes/classReports';
	                    $this->load->view('templates/user_template', $data); 
                    }
                }                
            }else{
                $this->session->set_flashdata('grdClsMsg', array('text' => 'Please click on View button','class' => 'alert alert-danger'));
                $this->viewClassReports();
            }              
        }else{
            redirect('User');
        }   
    }
    // delete school class by ajax in class->index view
    public function deleteSchoolClass(){
        if(is_logged_in()){
            $sch_grd_cls_id = $this->input->post('sch_grd_cls_id');
            $censusId = $this->input->post('census_id');
            $year = $this->input->post('year');
            $gradeId = $this->SchoolClass_model->get_grade_id($sch_grd_cls_id); 
            $classId = $this->SchoolClass_model->get_class_id($sch_grd_cls_id);
            $studentsExist = $this->Student_model->check_students_exists_in_a_class($censusId,$gradeId,$classId,$year); 
            //echo $studentsExist;
            //die();
            if(!$studentsExist){ // if false
                if($this->SchoolClass_model->delete_class($sch_grd_cls_id)){
                    echo '1';
                }else{
                    echo 'false';
                }  
            }else{
                echo '2';
            } 
        }else{
            redirect('User');
        }  
    }

}