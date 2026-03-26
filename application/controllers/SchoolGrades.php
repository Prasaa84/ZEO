<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Define Grade and classes of school
class SchoolGrades extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('SchoolGrade_model'); 
        $this->load->model('SchoolClass_model'); // grades also handled by this model
        $this->load->model('Staff_model');
        $this->load->model('Student_model');
        if(is_logged_in()){
            $this->userrole = $this->session->userdata['userrole'];
            $this->userrole_id = $this->session->userdata['userrole_id']; 
        }
    }

    public function index(){ 
        if(is_logged_in()){
            if($this->userrole_id == '2'){ 
                $censusId = $this->session->userdata['census_id'];
                $year = date('Y');
                $grd_span_id = $this->SchoolGrade_model->get_grade_span_by_census_id($censusId);
                // get existing grades of the school to view in grades->index page
                $schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId,$year); 
                $data['schoolGrades'] = $schoolGrades;                
                // get all the grades available in db according to grade span
                // when add new grade this is needed
                $allGrades = $this->SchoolGrade_model->get_grades_by_grade_span($grd_span_id);
                $data['allGrades'] = $allGrades;  
                $schoolStaff = $this->Staff_model->get_all_academic_staff_school_wise($censusId);
                $data['schoolStaff'] = $schoolStaff;
            }else{
                $data['all_schools'] = $this->Common_model->get_all_schools();
                $data['allGrades'] = '';                
            }
            $data['title'] = 'School Grades';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'grades/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }   
    }
    public function view_all_academic_staff(){ 
        return $this->Staff_model->get_all_academic_staff_();
    }
    // add new grade by school and admin
    public function addSchoolGrade(){
        if(is_logged_in()){
            if($this->input->post('btn_add_sch_grd')){
                $this->form_validation->set_rules("year_select_new_grade","Grade","required");
                $this->form_validation->set_rules("grade_select","Grade","required");
                if( $this->userrole_id == '1' ){
                    $this->form_validation->set_rules("select_school_in_modal_form","School","required");
                }
                if ( $this->form_validation->run() == false ){
                    //validation fails
                    if($this->userrole_id == '2'){
                        $this->session->set_flashdata('grdMsg', array('text' => 'Year and Grade are required!!!','class' => 'alert alert-danger'));
                    }else{
                        $this->session->set_flashdata('grdMsg', array('text' => 'School, Year and the Grade are required!!!','class' => 'alert alert-danger'));
                    }
                    redirect('SchoolGrades');
                }else{
                    if( $this->userrole_id == '2' ){
                        $censusId = $this->session->userdata['census_id'];
                    }else{
                        $censusId = $this->input->post('select_school_in_modal_form'); // fetch from bootstrap modal form
                    }
                    $year = $this->input->post('year_select_new_grade');
                    $gradeId = $this->input->post('grade_select');
                    $gradeHead = $this->input->post('grd_head_select');
                    $gradeExists = $this->SchoolGrade_model->check_school_grade_exists($censusId,$gradeId,$year);
                    //echo($gradeExists); die();
                    if(!$gradeExists){
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'sch_grd_id' => '',
                            'census_id' => $censusId, 
                            'grade_id' => $gradeId,
                            'stf_nic' => $gradeHead,
                            'year' => $year,  // current year
                            'date_added' => $now,
                            'date_updated'=> $now, // update
                            'is_deleted' => '',
                        );                        
                        if(!empty($gradeHead)){
                            $gradeHeadExistsInAnotherGrade = $this->SchoolGrade_model->check_grade_head_exists_in_another_grade($censusId,$gradeHead,$gradeId,$year);
                            if($gradeHeadExistsInAnotherGrade){
                                $this->session->set_flashdata('grdMsg', array('text' => 'Teacher is already a grade head in another grade!!!','class' => 'alert alert-danger','update'=>'true'));
                                redirect('SchoolGrades');
                            }else{
                                $result = $this->SchoolGrade_model->insert_school_grade($data);
                            }
                        }else{
                            $result = $this->SchoolGrade_model->insert_school_grade($data);
                        }
                        if($result){
                            $this->session->set_flashdata('grdMsg', array('text' => 'Grade added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('grdClsMsg', array('text' => 'Error in inserting the grade!!!','class' => 'alert alert-danger'));
                        }
                    }else{
                        $this->session->set_flashdata('grdMsg', array('text' => 'This grade already exists in " '.$year.'"','class' => 'alert alert-danger'));
                    }
                }
                redirect('SchoolGrades');
            }else{
                redirect('User');
            }
        }else{
            redirect('User');
        }
    }
    // update the Grade info by admin
    public function updateSchoolGrade(){
        if(is_logged_in()){
            if( $this->userrole_id==1 || $this->userrole_id==2 ){
                if($this->input->post('btn_update_sch_grd') == "Save"){
                    $censusId = $this->input->post('census_id_hidden'); // school census id
                    $sch_grd_id = $this->input->post('sch_grd_id_hidden'); // auto increment primary key of db table
                    $gradeHead = $this->input->post('grade_head_select'); // fetch staff nic no 
                    $gradeId = $this->input->post('grd_id_hidden');
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'sch_grd_id' => $sch_grd_id,
                        'stf_nic' => $gradeHead,
                        'date_updated' => $now,
                    ); 
                    $year = date('Y');
                    if( !empty($gradeHead) ){
                        // check grade head already exists in a grade this year
                        $gradeHeadExistsInAnotherGrade = $this->SchoolGrade_model->check_grade_head_exists_in_another_grade($censusId,$gradeHead,$gradeId,$year);
                        //echo $gradeHeadExistsInAnotherGrade; die();
                        if($gradeHeadExistsInAnotherGrade){
                            $this->session->set_flashdata('grdMsg', array('text' => 'Teacher is already in another grade!!!','class' => 'alert alert-danger','update'=>'true'));
                            redirect('SchoolGrades');
                        }else{
                            $result = $this->SchoolGrade_model->update_school_grade($data);
                        } 
                    }else{
                        $result = $this->SchoolGrade_model->update_school_grade($data);
                    }
                    if( $result ){
                        $this->session->set_flashdata('grdMsg', array('text' => 'Grade updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('grdMsg', array('text' => 'Grade could n\'t updated','class' => 'alert alert-danger','update'=>'false'));
                    }   
                    redirect('SchoolGrades');
                }
            }else{
                redirect('GeneralInfo/loginPage');
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    } 
    // this is used by admin in viewing school students classes in studentsInClasses view
    // classes->index view - to select grade when add a new class by admin
    // used in editStudent page - when change academic year, the school grades are loaded
    // used in editSchoolStaff page - when teacher is added to a classes. when select the year, grades are loaded
    public function viewGradesSchoolWise(){
        $censusId = $_POST['census_id'];
        $year = $_POST['year'];
        if($censusId=='All'){
            $data = $this->Common_model->get_all_grades();
        }else{
            $data = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId, $year);  
        }
        //print_r($data); die();
        echo json_encode($data);  
    }
    // this is used by admin in viewing grades according to the grade span of a school (grades index view)
    public function viewGradesAsGradeSpanWise(){
        $censusId = $_POST['census_id'];
        $grd_span_id = $this->SchoolGrade_model->get_grade_span_by_census_id($censusId);
        $data = $this->SchoolGrade_model->get_grades_by_grade_span($grd_span_id); // get grades from grades table according to grade span
        echo json_encode($data);  
    }
    // used in edit student page
    // public function viewSchoolGradesYearWise(){
    //     $censusId = $_POST['census_id'];
    //     $year = $_POST['year']; 
    //     $condition = 'sgct.census_id="'.$censusId.'" and sgct.year="'.$year.'" ';
    //     $data = $this->SchoolGrade_model->get_classes_grade_wise($condition);  
    //     //print_r($data); die();
    //     echo json_encode($data);  
    // } 
    // view grades assigned for the school in a specific year(Not all the grades available in db)
    // used by school user and admin
    public function viewSchoolGrades(){ 
        if(is_logged_in()){
            $role_id = $this->session->userdata['userrole_id'];
            $all_schools = $this->Common_model->get_all_schools();
            $data['all_schools'] = $all_schools; // passed to view to select the schools by admin
            if( $this->input->post('btn_view_grades_by_school') == 'View' ){ 
                $this->form_validation->set_rules("year_select","Year","required");
                if( $role_id != 2){
                    $this->form_validation->set_rules("select_school","School","required");
                }
                if( $this->form_validation->run() == false ){
                    //validation fails
                    if( $role_id != 2){
                        $this->session->set_flashdata('grdMsg', array('text' => 'Year and School are required','class' => 'alert alert-danger'));
                    }else{
                        $this->session->set_flashdata('grdMsg', array('text' => 'Year is required','class' => 'alert alert-danger'));
                    }
                    redirect('SchoolGrades');
                }else{
                    if( $role_id != 2){
                        $censusId = $this->input->post('select_school');
                    }else{
                        $censusId = $this->input->post('census_id_hidden');
                    }
                    $year = $this->input->post('year_select'); 
                    $schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId,$year);
                    if( empty($schoolGrades) ){
                        $this->session->set_flashdata('grdMsg', array('text' => 'No grades found in '.$year,'class' => 'alert alert-danger'));
                    }else{
                        $data['schoolGrades'] = $schoolGrades; 
                    }

                    $grd_span_id = $this->SchoolGrade_model->get_grade_span_by_census_id($censusId);
                    // get all the grades available in db according to grade span
                    // when add new grade this is needed
                    $allGrades = $this->SchoolGrade_model->get_grades_by_grade_span($grd_span_id);
                    $data['allGrades'] = $allGrades;  
                    $schoolStaff = $this->Staff_model->get_all_academic_staff_school_wise($censusId);
                    $data['schoolStaff'] = $schoolStaff;
                }                        
            }
            $data['title'] = 'Grades of the school';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'grades/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }   
    }
    // used by admin and school
    public function viewGradeReports(){ 
        if(is_logged_in()){
            $role_id = $this->session->userdata['userrole_id'];
            if( $role_id == '2' ){ 
                $year = date('Y'); 
                $censusId = $this->session->userdata['census_id'];
                $schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId,$year); 
                $data['schoolGrades'] = $schoolGrades;
            }
            if( $role_id != '2' ){
                if( $this->userrole_id==7 ) {
                    $eduDivId = $this->session->userdata['div_id'];
                    $all_schools = $this->Common_model->get_all_schools($eduDivId);
                }else{
                    $all_schools = $this->Common_model->get_all_schools();
                }
                $data['all_schools'] = $all_schools;
                if($this->input->post('btn_view_grades_by_school') == 'View'){ 
                    $this->form_validation->set_rules("select_school","School","required");
                    $this->form_validation->set_rules("select_year","Year","required");
                    if ($this->form_validation->run() == false){
                        //validation fails
                        $this->session->set_flashdata('grdMsg', array('text' => 'Please select school and Year!','class' => 'alert alert-danger'));
                        redirect('SchoolGrades/viewGradeReports');
                    }else{
                        $censusId = $this->input->post('select_school');
                        $year = date('Y');
                        $schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId,$year);    
                        $data['schoolGrades'] = $schoolGrades; 
                    }                        
                }else{
                    $this->session->set_flashdata('grdClsMsg', array('text' => 'Please click on search button','class' => 'alert alert-danger'));
                } 
            }
            $data['title'] = 'Grade Reports';
            if( $role_id == '3' ){
                $data['user_header'] = 'user_zeo_header';
            }elseif( $role_id == '7' ){
                $data['user_header'] = 'user_edu_division_header';
            }else{
                $data['user_header'] = 'user_admin_header';
            }
            $data['user_content'] = 'grades/gradeReports';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }   
    }
    // used by admin and school in grades->gradeReports view
    public function gradeReports(){ 
        if(is_logged_in()){
            if($this->input->post('btn_view_grades_by_school') == 'View'){ 
                $role_id = $this->session->userdata['userrole_id'];
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
                        $this->session->set_flashdata('grdMsg', array('text' => 'Please select the Year!','class' => 'alert alert-danger'));
                    }else{
                        $this->session->set_flashdata('grdMsg', array('text' => 'Please select Year and the School!','class' => 'alert alert-danger'));
                    }
                    redirect('SchoolGrades/viewGradeReports');
                }else{ 
                    $year = $this->input->post('year_select');
                    if( $this->userrole_id != '2' ){
                        $all_schools = $this->Common_model->get_all_schools();
                        $data['all_schools'] = $all_schools;
                    }
                    $schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId,$year);
                    if(empty($schoolGrades)){
                        $this->session->set_flashdata('grdMsg', array('text' => 'No grades found in '.$year,'class' => 'alert alert-danger'));
                    }
                    $data['schoolGrades'] = $schoolGrades;
                    $data['title'] = 'Grade Reports';
                    if($role_id == '3'){ // edu. divisional user`
                        $data['user_header'] = 'user_zeo_header';
                    }elseif($role_id == '7'){ // edu. divisional user
                        $data['user_header'] = 'user_edu_division_header';
                    }else{
                        $data['user_header'] = 'user_admin_header';
                    }
                    $data['user_content'] = 'grades/gradeReports';
                    $this->load->view('templates/user_template', $data); 
                }                
            }else{
                $this->session->set_flashdata('grdClsMsg', array('text' => 'Please click on View button','class' => 'alert alert-danger'));
                $this->viewGradeReports();
            }              
        }else{
            redirect('User');
        }   
    }
    // delete school grade by ajax in grades->index view
    public function deleteSchoolGrade(){
        if( is_logged_in() ){
            $sch_grd_id = $this->input->post('sch_grd_id');
            $gradeInfo = $this->SchoolGrade_model->get_grade_info( $sch_grd_id );
            //print_r($gradeInfo); die();
            foreach ( $gradeInfo as $grade ) {
                echo $censusId = $grade->census_id;
                $gradeId = $grade->grade_id;
                $year = $grade->year;
            }
            $classesExists = $this->SchoolClass_model->check_classes_exists( $gradeId, $censusId, $year ); 
            if( $classesExists ){
                echo '1'; // classes exists
            }else{
                if($this->SchoolGrade_model->delete_school_grade($sch_grd_id)){
                    echo '2';  // deletion success
                }else{
                    echo '3';  // deletion not success
                }
            }
        }else{
            redirect('User');
        } 
    }

}