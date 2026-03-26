<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subjects extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('School_model');
        $this->load->model('Subject_model');
        $this->load->model('Grade_model');
        if(is_logged_in()){
            $this->userrole = $this->session->userdata['userrole'];
            $this->userrole_id = $this->session->userdata['userrole_id']; 
        }
    }

    // view sanitary items details page
    public function index(){
        if(is_logged_in()){
            $userrole = $this->session->userdata['userrole'];
            if($userrole != 'School User'){
                if($this->userrole_id == '7'){
                    $eduDivId = $this->session->userdata['div_id'];
                    $data['allSchools'] = $this->Common_model->get_all_schools($eduDivId);
                }else{
                    $data['allSchools']  = $this->Common_model->get_all_schools();
                }
            }
            $data['title'] = 'Subject Details';
            if($this->userrole_id == '7'){
                $data['user_header'] = 'user_edu_division_header';
            }else{
                $data['user_header'] = 'user_admin_header';
            }
            $data['user_content'] = 'subjects/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function viewSubjectsOfGrades(){
        if(is_logged_in()){
            $userrole = $this->session->userdata['userrole'];
            //if($userrole == 'School User' || $userrole == 'System Administrator'){
                if( $this->userrole_id != 2 ){
                    $this->form_validation->set_rules("school_select","School","required");
                }
                $this->form_validation->set_rules("year_select","Year","required");
                $this->form_validation->set_rules("grade_select","Grade","required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'All fields are required!','class' => 'alert alert-danger'));
                    redirect('Subjects');
                }else{
                    if($userrole == 'School User'){
                        $censusId = $this->session->userdata['census_id'];
                    }else{
                        $censusId = $this->input->post('school_select');
                    }
                    $gradeId = $this->input->post('grade_select');
                    $year = $this->input->post('year_select'); 
                    $sectionId = $this->Grade_model->get_section_of_a_grade($gradeId);
                    $subjectsOfSection = $this->Subject_model->get_subjects_section_wise($sectionId); 
                    //print_r($subjects); die();
                    $subjectsOfGrade = array();
                    $i = 0;
                    foreach ($subjectsOfSection as $subject) {
                        $subjectsOfGrade[$i]['sub_id']=$subject->subject_id;
                        $subjectsOfGrade[$i]['sub_name']=$subject->subject;
                        $subjectId = $subject->subject_id;
                        $selectedSubjects = $this->Subject_model->get_subjects_of_a_grade($censusId,$gradeId,$subjectId,$year); 
                        //if grade and class has been set for current year, set grade and class for view
                        if(!empty($selectedSubjects)){
                            $subjectsOfGrade[$i]['selected']='yes'; 
                            foreach ($selectedSubjects as $sel_subj) {
                                $subj_upd_dt = $sel_subj->subj_upd_dt; 
                                $subjectsOfGrade[$i]['subj_upd_dt']=$subj_upd_dt;
                                //$subjectsOfGrade[$i]['grade_id'] = $sel_subj->grade_id;

                            }                        
                        }else{
                            // if subjects are not selected for current year, set selected as 'no'
                            $subjectsOfGrade[$i]['selected']='no'; 
                        }
                        $subjectsOfGrade[$i]['sub_cat_name']=$subject->sub_cat_name;
                        $subjectsOfGrade[$i]['year']=$year; 
                        $subjectsOfGrade[$i]['census_id']=$censusId; 
                        $i++;
                    }
                    $data['gradeName'] = $this->Grade_model->get_grade_name($gradeId);
                    $data['subjectsForGrade'] = $subjectsOfGrade;
                }
                $data['gradeId'] = $gradeId;
                $data['title'] = 'Subject Details';
                if($this->userrole_id==7){
                    $data['user_header'] = 'user_edu_division_header';
                    $eduDivId = $this->session->userdata['div_id'];
                    $allSchools = $this->Common_model->get_all_schools($eduDivId);
                }else{
                    $data['user_header'] = 'user_admin_header';
                    $allSchools = $this->Common_model->get_all_schools(); 
                }
                $data['allSchools'] = $allSchools;
                $data['user_content'] = 'subjects/index';
                $this->load->view('templates/user_template', $data);
            //}   
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // used in positionOnMarks view to load subjects when a grade is selected.
    public function viewSubjectsOfAGrade(){

        $censusId = $_POST['census_id'];
        $year = $_POST['year'];
        $gradeId = $_POST['grade_id'];

        $sectionId = $this->Grade_model->get_section_of_a_grade($gradeId);

		$this->load->model('Subject_model');
    	$data = $this->Subject_model->get_selected_subjects_of_a_grade($censusId, $gradeId, $year, $sectionId);

        echo json_encode($data);  
    }

    public function addSubjectsToGrade(){
        if(is_logged_in()){
            $role_id = $this->session->userdata['userrole_id'];
            if($this->input->post('btn_save_subjects_to_grade')=='Save'){
                $gradeId = $this->input->post('grade_id_hidden');
                $year = $this->input->post('year_hidden'); 
                if($role_id==2){
                    $censusId = $this->input->post('census_id_hidden');
                }else{
                    $censusId = $this->input->post('census_id_hidden');
                }
                if(!empty($this->input->post('chkbox'))){
                    //$censusId = $this->input->post('census_id_hidden');
                    //echo $gradeId = $this->input->post('grade_id_hidden'); die();
                    $subjects = $this->input->post('chkbox'); // all selected subjects 
                    $mainSubjCount = 0;
                    $mainSubjCountWithoutReligion = 0;
                    $religionCount = 0;
                    $op1Count = 0;
                    $op2Count = 0;
                    $op3Count = 0;
                    foreach( $subjects as $subject_id ){
                        if( $subject_id==5 || $subject_id==6 || $subject_id==7 || $subject_id==8 || $subject_id==9 ){
                            $religionCount += 1;
                        }
                        if( $subject_id==10 || $subject_id==12 || $subject_id==13 || $subject_id==14 || $subject_id==15 ){
                            $mainSubjCountWithoutReligion += 1;
                        }
                        $subjectData = $this->Subject_model->get_subject_by_subj_id($subject_id);
                        foreach ($subjectData as $subjectData) {
                            if( $subjectData->sub_cat_id == 1 ){
                                $mainSubjCount += 1;
                            }elseif($subjectData->sub_cat_id == 2){
                                $op1Count += 1;
                            }elseif($subjectData->sub_cat_id == 3){
                                $op2Count += 1;
                            }elseif($subjectData->sub_cat_id == 4){
                                $op3Count += 1;
                            }
                        }
                    }
                    //echo $gradeId;
                    if( $gradeId==1 || $gradeId==2 || $gradeId==3 || $gradeId==4 || $gradeId==5 ){
                        $minMainSubjects = 4;
                        $minOP1 = 0;
                        $minOp2 = 0;
                        $minOp3 = 0; 
                    }elseif( $gradeId==6 || $gradeId==7 || $gradeId==8 || $gradeId==9 ){
                        $minMainSubjects = 6;
                        $minOP1 = 0;
                        $minOp2 = 1;
                        $minOp3 = 0;
                    }elseif( $gradeId==10 || $gradeId==11 ){
                        $minMainSubjects = 6;
                        $minOP1 = 1;
                        $minOp2 = 1;
                        $minOp3 = 1;
                    }else{
                        $minMainSubjects = 3;
                        $minOP1 = 0;
                        $minOp2 = 0;
                        $minOp3 = 0; 
                    }

                    //die();
                    if ( $mainSubjCount < $minMainSubjects ) {
                        $error = 'Minimum '.$minMainSubjects .' main subjects needed!!!';
                        $this->session->set_flashdata('msg', array('text' => 'Minimum '.$minMainSubjects .' main subjects needed!!!','class' => 'alert alert-danger'));
                    }
                    if( $op1Count < $minOP1 ){
                        $error = 'Minimum '.$minOP1 .' OP1 subject needed!!!';
                        $this->session->set_flashdata('msg', array('text' => 'Minimum '.$minOP1 .' OP1 subject needed!!!','class' => 'alert alert-danger'));
                    }elseif( $op2Count < $minOp2 ){
                        $error = 'Minimum '.$minOp2 .' OP2 subjects needed!!!';
                        $this->session->set_flashdata('msg', array('text' => 'Minimum '.$minOp2 .' OP2 subjects needed!!!','class' => 'alert alert-danger'));
                    }elseif( $op3Count < $minOp3 ){
                        $error = 'Minimum '.$minOp3 .' OP3 subjects needed!!!';
                        $this->session->set_flashdata('msg', array('text' => 'Minimum '.$minOp3 .' OP3 subjects needed!!!','class' => 'alert alert-danger'));
                    }
                    if ( ( $gradeId==6 || $gradeId==7 || $gradeId==8 || $gradeId==9 || $gradeId==10 || $gradeId==11 ) and $religionCount < 1 ) {
                        $error = 'Please select atleast one religion subject';
                    }elseif ( ( $gradeId==6 || $gradeId==7 || $gradeId==8 || $gradeId==9 || $gradeId==10 || $gradeId==11 ) and $mainSubjCountWithoutReligion < 5 ) {
                        $error = 'සිංහල භාෂාව හා සාහිත්‍යය, ඉංග්‍රීසි භාෂාව, ගණිතය, ඉතිහාසය, විද්‍යාව are compulsory main subjects!!!';
                    }

                    if( !empty($error) ){
                        $this->session->set_flashdata('msg', array('text' => $error,'class' => 'alert alert-danger'));
                    }else{
                        $selectedSubjects = $this->Subject_model->check_subjects_of_grade_exist($censusId,$gradeId,$year); 
                        if(!$selectedSubjects){
                            // all subjects will be inserted using a for loop in Subject_model
                            $result = $this->Subject_model->add_subjects_to_grade($censusId,$gradeId,$subjects,$year);
                        }else{
                            $this->Subject_model->delete_subjects_of_grade($censusId,$gradeId,$year);
                            $result = $this->Subject_model->add_subjects_to_grade($censusId,$gradeId,$subjects,$year);
                        }
                        if($result){
                            $this->session->set_flashdata('msg', array('text' => 'Subjects added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('msg', array('text' => 'Error in inserting subjects','class' => 'alert alert-danger'));
                        }
                    }                    
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'Please select subjects','class' => 'alert alert-danger'));
                }
            }
            //echo $gradeId; die();
            $sectionId = $this->Grade_model->get_section_of_a_grade($gradeId);
            // to load all subjects belong to the section of the grade ex- primary, 6-11, 12-13
            $subjectsOfSection = $this->Subject_model->get_subjects_section_wise($sectionId); 
            //print_r($subjects); die();
            $subjectsOfGrade = array();
            $i = 0;
            foreach ($subjectsOfSection as $subject) {
                $subjectsOfGrade[$i]['sub_id']=$subject->subject_id;
                $subjectsOfGrade[$i]['sub_name']=$subject->subject;
                $subjectId = $subject->subject_id;
                $selectedSubjects = $this->Subject_model->get_subjects_of_a_grade($censusId,$gradeId,$subjectId,$year); 
                if(!empty($selectedSubjects)){
                    $subjectsOfGrade[$i]['selected']='yes'; 
                    foreach ($selectedSubjects as $sel_subj) {
                        $subj_upd_dt = $sel_subj->subj_upd_dt; 
                        $subjectsOfGrade[$i]['subj_upd_dt']=$subj_upd_dt;
                    }
                }else{
                    // if subjects are not selected for current year, set selected as 'no'
                    $subjectsOfGrade[$i]['selected']='no'; 
                }
                $subjectsOfGrade[$i]['sub_cat_name']=$subject->sub_cat_name;
                $subjectsOfGrade[$i]['year']=$year; 
                $subjectsOfGrade[$i]['census_id']=$censusId; 
                $i++;
            }
            if($role_id == '1'){
                $allSchools = $this->School_model->view_all_schools(); 
                $data['allSchools'] = $allSchools;
            }
            $data['gradeName'] = $this->Grade_model->get_grade_name($gradeId);
            $data['subjectsForGrade'] = $subjectsOfGrade;
            $data['gradeId'] = $gradeId;
            $data['title'] = 'Subject Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'subjects/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }
    }
}