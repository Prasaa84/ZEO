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
        $this->load->model('SchoolGrade_model');
        $this->load->model('SchoolClass_model');
        $this->load->model('Marks_model');
        $this->load->model('Common_model');
        $this->load->library("excel/excel");
        $this->all_edu_div = $this->view_all_edu_divisions(); // view divisions in find school page
        $this->all_religion = $this->view_all_religion();
        $this->all_ethnic_groups = $this->view_all_ethnic_groups();
        $this->all_genders = $this->view_all_genders();
        $this->all_student_status = $this->Common_model->get_all_student_status();
        $this->all_games = $this->Common_model->get_all_games();
        $this->all_game_roles_of_student = $this->Common_model->get_all_game_roles_of_student();
        $this->all_extra_curriculum = $this->Common_model->get_all_extra_curri();
        $this->all_ex_cur_roles_of_student = $this->Common_model->get_all_std_extra_curri_roles();
        $this->all_win_types = $this->Common_model->get_all_win_types();

        if(is_logged_in()){
            $this->userrole = $this->session->userdata['userrole'];
            $this->userrole_id = $this->session->userdata['userrole_id']; 
        }
        if( $this->userrole_id != '2'){
            //$this->student_count = $this->view_student_count_schoolwise(); // for bar chart in admin dashboard
            //$this->student_count_genderwise = $this->view_student_count_genderwise(); // for bar chart in admin dashboard       
            $this->all_sch_types = $this->view_all_sch_types(); // view school types in find school page
            $this->all_grades = $this->view_all_grades();
            $this->all_classes = $this->view_all_classes(); 
            $this->all_schools = $this->view_all_schools(); 
        }
        if( $this->userrole_id == '2'){
            //$this->no_of_stu_by_grade = $this->count_stu_by_grd(); // for bar chart in student dashboard
            //$this->student_count= $this->view_student_count_gradewise(); // for bar chart in student dashboard
            //$this->student_count_genderwise = $this->view_student_count_genderwise(); // for bar chart in student dashboard 
            $this->censusId = $this->session->userdata['census_id']; 
            $year = date('Y');
            $this->all_grades = $this->SchoolGrade_model->get_school_grades_by_census_id($this->censusId,$year);
            $this->all_classes = $this->SchoolClass_model->get_school_classes_by_census_id($this->censusId,$year);     
        }         
    }
  
    public function index(){
        if(is_logged_in()){
            $userrole_id = $this->session->userdata['userrole_id'];
            if($userrole_id == '2'){ // if the user is school, then student details must be displayed by census id
                $censusId = $this->session->userdata['census_id'];
                $students = $this->Student_model->view_students_school_wise($censusId); 
            }else{
                $students = $this->Student_model->get_all_students(); 
            }
            if(!$students){
                $this->session->set_flashdata('no_student_info', array('text' => 'No records found!!!','class' => 'alert alert-danger'));
            }else{
                $year = date("Y");
                $student_info = array();
                $i = 0;
                // $students array is created again as  $student_info to include current grade and class
                foreach ($students as $student) {
                    $student_info[$i]['st_id']=$student->st_id;
                    $student_info[$i]['index_no']=$student->index_no;
                    $student_info[$i]['name']=$student->name_with_initials;
                    $student_info[$i]['census_id']=$student->census_id;
                    $student_info[$i]['school_name']=$student->sch_name;
                    $student_info[$i]['gender_name']=$student->gender_name;
                    $student_info[$i]['last_update']=$student->last_update;
                    $indexNo = $student->index_no;
                    $censusId = $student->census_id;
                    // current year not passed, max record will be fetched (max academic year)
                    $studentGradeClassInfo = $this->Student_model->get_student_current_grade_class($indexNo,$censusId);
                    //print_r($studentGradeClassInfo);
                    //if grade and class has been set for current year, set grade and class for view
                    if(!empty($studentGradeClassInfo)){
                        foreach ($studentGradeClassInfo as $row) {
                            $student_info[$i]['grade']=$row->grade;
                            $student_info[$i]['class']=$row->class;
                        }  
                    }else{
                        // if students' grade and class not found for current year, set grade and class as not available
                        $student_info[$i]['grade']= 'N/A';
                        $student_info[$i]['class']= '';
                    }
                    $i++;
                }
                $data['student_info'] = $student_info;
            }
                //print_r($studentGradeClassInfo); die();
            //print_r($student_info); die();
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
    public function view_all_schools(){ 
        return $this->School_model->view_all_schools();
    }
    // not used yet
    /*public function count_stu_by_grd(){ 
            $censusId = $this->session->userdata['census_id'];
            $data = $this->Student_model->count_stu_by_grd($censusId);
            return(json_encode($data));
    }*/
    // this method loaded by this construct method to view all religion in db
    public function view_all_religion(){
        return $this->Common_model->get_all_religion();
    }
    // this method loaded by this construct method to view all religion in db
    public function view_all_ethnic_groups(){
        return $this->Common_model->get_all_ethnic_groups();
    }
    // this method loaded by this construct method to view available genders in db
    public function view_all_genders(){
        return $this->Common_model->get_all_genders();
    }    
    // not used
    /*public function view_student_count_gradewise(){ 
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
    }*/
    // not used yet
    /*public function view_student_count_genderwise(){ 
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
    }*/
    // not used yet
    /*public function view_student_count_schoolwise(){ 
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
    }*/
    // through excel sheet
    public function addBulkStudents(){
        if(is_logged_in()){
            if(isset($_FILES["file"]["name"])){
                //echo 'hi...'; 
                $path = $_FILES["file"]["tmp_name"]; 
                $object = PHPExcel_IOFactory::load($path);
                //$object->getSheetByName('Data');
                $userrole = $this->session->userdata['userrole'];
                if($userrole == 'School User'){ 
                    $censusId = $this->session->userdata['census_id'];
                }
                // excel sheet validating part
                foreach($object->getWorksheetIterator() as $worksheet){
                    // following codes are used to check students exists 
                    $sheet = $object->getSheet(0);
                    //print_r($sheet); die();
                    $highestRow = $sheet->getHighestRow();
                    $studentsNotExistsArray = [];
                    $studentCount = 0;
                    for($row=2; $row<=$highestRow; $row++){
                        //set validations
                        if($sheet->getCellByColumnAndRow(0, $row)->getValue()){
                            $admNo = $sheet->getCellByColumnAndRow(0, $row)->getValue(); // get adm_no from excel
                        }
                        // if the user is admin, he has to take census id from the excel
                        if( $userrole == 'System Administrator' ){ 
                            $censusId = $sheet->getCellByColumnAndRow(11, $row)->getValue(); // get census_id from excel
                            if(!is_numeric($censusId) || strlen($censusId) != 5){
                                echo 'Error with Census Id!!!... You have logged as Admin and use correct template';
                                die();
                            }
                        }
                        $studentExists = $this->Student_model->check_student_exist($admNo, $censusId); 
                        if($studentExists){
                            $nameWithIni = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                            $studentsNotExistsArray[$row]['adm_no'] = $admNo;
                            $studentsNotExistsArray[$row]['stu_name'] = $nameWithIni;   
                        }
                    }
                    if(!empty($studentsNotExistsArray)){
                        foreach ($studentsNotExistsArray as $student) {
                            echo nl2br($student['adm_no'].' - '.$student['stu_name']);
                        }
                        echo ' Already exists';
                        die();
                    }

                    $admissionError = [];
                    $fullNameError = [];
                    $nameWithIniError = [];
                    $tel1Error = []; // mobile phone
                    $tel2Error = []; // whatsApp no
                    $tel3Error = []; // home phone
                    $dobError = [];
                    $genderError = [];
                    $natError = [];
                    $relError = [];
                    $doaError = [];
                    for($row=2; $row<=$highestRow; $row++){
                        $admNo = $sheet->getCellByColumnAndRow(0, $row)->getFormattedValue(); // get adm_no from excel. 0 is first column
                        $fullName = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                        $nameWithIni = $sheet->getCellByColumnAndRow(2, $row)->getValue();
                        $address1 = $sheet->getCellByColumnAndRow(3, $row)->getValue();
                        $address2 = $sheet->getCellByColumnAndRow(4, $row)->getValue();
                        $tel1 = $sheet->getCellByColumnAndRow(5, $row)->getFormattedValue();
                        $tel2 = $sheet->getCellByColumnAndRow(6, $row)->getFormattedValue();
                        $tel3 = $sheet->getCellByColumnAndRow(7, $row)->getFormattedValue();
                        $dob = $sheet->getCellByColumnAndRow(8, $row)->getFormattedValue();
                        $gender = $sheet->getCellByColumnAndRow(9, $row)->getFormattedValue();
                        $nat = $sheet->getCellByColumnAndRow(10, $row)->getValue();
                        $rel = $sheet->getCellByColumnAndRow(11, $row)->getValue();
                        $doa = $sheet->getCellByColumnAndRow(12, $row)->getFormattedValue();
                        //$grd = $sheet->getCellByColumnAndRow(11, $row)->getValue();
                        //$cls = $sheet->getCellByColumnAndRow(12, $row)->getValue();
                        if( !is_numeric($admNo) || (strlen($admNo) < 4) || (strlen($admNo) > 5) ){
                            $admissionError[$row]['adm_no'] = $admNo;
                        }
                        if(!is_string($fullName)){
                            $fullNameError[$row]['adm_no'] = $fullName;
                        }
                        if(!is_string($nameWithIni) || empty($nameWithIni)){
                            $nameWithIniError[$row]['adm_no'] = $nameWithIni;
                        }
                        // if(!is_numeric($tel)){
                        //     $telError[$row]['adm_no'] = $admNo;
                        // }
                        $tel1Error = '';
                        $tel2Error = '';
                        $tel3Error = '';
                        // if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $dob)){
                        //     $dobError[$row]['adm_no'] = $admNo;
                        // }
                        $dobError = '';
                        if( ($gender != 'ස්ත්‍රී') && ($gender != 'පුරුෂ')){
                            $genderError[$row]['adm_no'] = $gender;
                        }
                        // if( ($nat != 'සිංහල') && ($nat != 'ඉන්දියානු දෙමළ') && ($nat != 'ශ්‍රී ලංකා දෙමළ') && ($nat != 'මුස්ලිම්')){
                        //     $natError[$row]['adm_no'] = $admNo;
                        // }
                        if( ($rel != 'බෞද්ධ') && ($rel != 'ක්‍රිස්තියානි') && ($rel != 'හින්දු') && ($rel != 'ඉස්ලාම්') && ($rel != 'කතෝලික') && ($rel != 'වෙනත්')){
                            $relError[$row]['adm_no'] = $nat;
                        }

                        if( ($nat != 'සිංහල') && ($nat != 'ශ්‍රී ලංකා දෙමළ') && ($nat != 'ඉන්දියානු දෙමළ') && ($nat != 'මුස්ලිම්') && ($nat != 'වෙනත්')){
                            $natError[$row]['adm_no'] = $nat;
                        }
                        // if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $doa)){
                        //     $doaError[$row]['adm_no'] = $admNo;
                        // }
                        $doaError = '';
                        //$grdError = '';
                        //$clsError = '';
                        //if(strlen($grd) > 3){
                        //    $grdError[$row]['adm_no'] = $admNo;
                        //}
                        //if(!is_string($cls) || strlen($cls) > 1){
                        //    $clsError[$row]['adm_no'] = $admNo;
                        //}
                    }   // for($row=2; $row<=$highestRow; $row++){
                    if(!empty($admissionError)){
                        echo 'These admission numbers not in correct format!!!'.' - ';
                        foreach ($admissionError as $admissionError) {
                            echo $admissionError['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($fullNameError)){
                        echo 'These full names are not in correct format!!!'.' - ';
                        foreach ($fullNameError as $fullNameError) {
                            echo $fullNameError['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($nameWithIniError)){
                        echo 'These name with initials are not in correct format!!!'.' - ';
                        foreach ($nameWithIniError as $nameWithIniError) {
                            echo $nameWithIniError['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($tel1Error)){
                        echo 'These mobile numbers are not in correct format!!!'.' - ';
                        foreach ($tel1Error as $tel1Error) {
                            echo $tel1Error['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($tel2Error)){
                        echo 'These whatsApp numbers are not in correct format!!!'.' - ';
                        foreach ($tel2Error as $tel2Error) {
                            echo $tel2Error['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($tel3Error)){
                        echo 'These home telephone numbers are not in correct format!!!'.' - ';
                        foreach ($tel3Error as $tel3Error) {
                            echo $tel3Error['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($dobError)){
                        echo 'These birth dates are not in correct format!!!'.' - ';
                        foreach ($dobError as $dobError) {
                            echo $dobError['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($genderError)){
                        echo 'These gender names are not in correct format!!!'.' - ';
                        foreach ($genderError as $genderError) {
                            echo $genderError['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($natError)){
                        echo 'These nationalities are not in correct format!!!'.' - ';
                        foreach ($natError as $natError) {
                            echo $natError['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($relError)){
                        echo 'These relegion names are not in correct format!!!'.' - ';
                        foreach ($relError as $relError) {
                            echo $relError['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($doaError)){
                        echo 'These admission dates are not in correct format!!!'.' - ';
                        foreach ($doaError as $doaError) {
                            echo $doaError['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($grdError)){
                        echo 'These grades are not in correct format!!!'.' - ';
                        foreach ($grdError as $grdError) {
                            echo $grdError['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                    if(!empty($clsError)){
                        echo 'These classes are not in correct format!!!'.' - ';
                        foreach ($clsError as $clsError) {
                            echo $clsError['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                        }
                        die(); 
                    }
                } // foreach($object->getWorksheetIterator() as $worksheet){
                // start adding excel sheet
                //foreach($object->getWorksheetIterator() as $worksheet){
                $sheet = $object->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $st_count = 0;
                $insertCount = 0;
                for($row=2; $row<=$highestRow; $row++){

                    $admNo = $sheet->getCellByColumnAndRow(0, $row)->getValue(); // get adm_no from excel
                    $fullName = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                    if(empty($fullName)){
                        echo $fullName ='';
                    }
                    $nameWithIni = $sheet->getCellByColumnAndRow(2, $row)->getValue();
                    $address1 = $sheet->getCellByColumnAndRow(3, $row)->getValue();
                    if(empty($address1)){
                        echo $address1 ='';
                    }
                    $address2 = $sheet->getCellByColumnAndRow(4, $row)->getValue();
                    if(empty($address2)){
                        echo $address2 ='';
                    }
                    $tel1 = $sheet->getCellByColumnAndRow(5, $row)->getValue();
                    if(empty($tel1)){
                        echo $tel1 ='';
                    }
                    $tel2 = $sheet->getCellByColumnAndRow(5, $row)->getValue();
                    if(empty($tel2)){
                        echo $tel2 ='';
                    }
                    $tel3 = $sheet->getCellByColumnAndRow(5, $row)->getValue();
                    if(empty($tel3)){
                        echo $tel3 ='';
                    }
                    $dob = $sheet->getCellByColumnAndRow(6, $row)->getFormattedValue();
                    if(empty($dob)){
                        echo $dob ='';
                    }
                    $gender = $sheet->getCellByColumnAndRow(7, $row)->getValue();
                    if(empty($gender)){
                        echo $gender ='';
                    }
                    $nat = $sheet->getCellByColumnAndRow(8, $row)->getValue();
                    if(empty($nat)){
                        echo $nat ='';
                    }
                    $rel = $sheet->getCellByColumnAndRow(9, $row)->getValue();
                    if(empty($rel)){
                        echo $rel ='';
                    }
                    $doa = $sheet->getCellByColumnAndRow(10, $row)->getFormattedValue();
                    if(empty($doa)){
                        echo $doa ='';
                    }
                    //$censusId = $sheet->getCellByColumnAndRow(11, $row)->getValue();
                    //if(empty($censusId)){
                       // echo $censusId ='';
                    //}
                    // $cls = $sheet->getCellByColumnAndRow(12, $row)->getValue();
                    // if(empty($cls)){
                    //     echo $cls ='';
                    // }
                    $now = date('Y-m-d H:i:s');
                    // gender is checked above and its compulsory
                    switch ($gender) {
                        case 'ස්ත්‍රී':
                            $gender_id = 2;
                            break;                               
                        default:
                            $gender_id = 1;
                    }
                    // optional when bulk upload
                    switch ($nat) {
                        case 'සිංහල':
                            $nat_id = 1;
                            break;
                        case 'ශ්‍රී ලංකා දෙමළ':
                            $nat_id = 2;
                            break;
                        case 'ඉන්දියානු දෙමළ':
                            $nat_id = 3;
                            break; 
                        case 'මුස්ලිම්':
                            $nat_id = 4;
                            break;   
                        case 'වෙනත්':
                            $nat_id = 5;
                            break;                           
                        default:
                            $nat_id = '';
                    }
                    // optional
                    switch ($rel) { 
                        case 'බෞද්ධ':
                            $rel_id = 1;
                            break;
                        case 'හින්දු':
                            $rel_id = 2;
                            break;
                        case 'ඉස්ලාම්':
                            $rel_id = 3;
                            break;
                        case 'කතෝලික':
                            $rel_id = 4;
                            break;
                        case 'ක්‍රිස්තියානි':
                            $rel_id = 5;
                            break;
                        case 'වෙනත්':
                            $rel_id = 6;
                            break;
                        default:
                            $rel_id = '';
                    }
                    // optional
                    // switch ($grd) {
                    //     case 'G10':
                    //         $grade_id = 10;
                    //         break;  
                    //     case 'G11':
                    //         $grade_id = 11;
                    //         break;                              
                    //     default:
                    //         $grade_id = '';
                    // }
                    // optional
                    // switch ($cls) {
                    //     case 'A':
                    //         $class_id = 1;
                    //         break;                               
                    //     case 'B':
                    //         $class_id = 2;
                    //         break;
                    //     case 'C':
                    //         $class_id = 3;
                    //         break;                               
                    //     case 'D':
                    //         $class_id = 4;
                    //         break;
                    //     case 'E':
                    //         $class_id = 5;
                    //         break;                               
                    //     case 'F':
                    //         $class_id = 6;
                    //         break;
                    //     case 'G':
                    //         $class_id = 7;
                    //         break; 
                    //     case 'H':
                    //         $class_id = 8;
                    //         break;                              
                    //     default:
                    //         $class_id = '';
                    // }
                    //$data = []; // $data array must be empty for this iteration
                    //$data  = array();
                    $data = []; 
                    $data[] = array(
                        'st_id' =>  '',
                        'index_no' =>  $admNo,
                        'fullname' =>  $fullName,
                        'name_with_initials' =>  $nameWithIni,
                        'address1' =>  $address1,
                        'address2' =>  $address2,
                        'phone_no_1' =>  $tel1,
                        'phone_no_2' =>  $tel2,
                        'phone_home' =>  $tel3,
                        'dob' =>  $dob,
                        'gender_id'     => $gender_id,
                        'ethnic_group_id'     => $nat_id,
                        'religion_id'     => $rel_id,
                        'd_o_admission'     => $doa,
                        'census_id'     => $censusId,
                        'st_status_id'     => 1,
                        'date_added'    => $now,
                        'date_updated'  => $now,
                        'is_deleted' => ''
                    );

                    $studentHistory = '';
                    $studentHistory = array(
                        'st_hist_id' => '',
                        'index_no' => $admNo,
                        'census_id' => $censusId,
                        'admit_date' => $doa,
                        'st_status_id' => 1,
                        'left_date' => '',
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    // check student exists in the system. checked it earlier too in the db before starting inserting excel sheet data. But there may be duplicate admNo in the excel sheet.  
                    $studentExists = $this->Student_model->check_student_exist($admNo,$censusId); 
                    if(!$studentExists){
                        if($this->Student_model->insert_bulk_students($data)){
                            $addToHistory = $this->Student_model->add_student_histor($studentHistory);
                            $insertCount += 1;
                        }else{
                            echo 'Error in inserting data '.$admNo.' !!!';
                            die();
                        }
                    }else{
                        echo $admNo.' inserted earlier';
                        die();
                    }
                } //for($row=2; $row<=$highestRow; $row++) 
                if($insertCount>0){
                    if($insertCount==1){
                        echo '1 Student inserted successfully';
                    }else{
                        echo $insertCount.' Students inserted successfully';
                    }
                }                       
            } // if(isset($_FILES["file"]["name"])){

        }else{ 
            redirect('GeneralInfo/loginPage');
        }
    }
    public function file_check($value,$class_id){
        // here $class_id is included as the second parameter. thats why next line is used (line 591)
        $class_id = $class_id['1']; 
        $allowed_mime_type_arr = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel');
        $mime = get_mime_by_extension($_FILES["file".$class_id]['name']);
        if( isset($_FILES["file".$class_id]['name']) && $_FILES["file".$class_id]['name']!="" ){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                //$this->form_validation->set_message('file_check', 'Please select only pdf/gif/jpg/png file.');
                return false;
            }
        }else{
            //$this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }
    // add bulk students to a class. used in studentsInClasses view
    public function addBulkStudentsToClass(){
        if(is_logged_in()){
            $this->load->helper('file');  // used to validate excel file type
            $censusId = $this->session->userdata['census_id'];
            $class_id = $this->input->post('class_id_hidden');
            $grade_id = $this->input->post('grade_id_hidden');
            $year = $this->input->post('year_hidden');
            if(isset($_FILES["file".$class_id]["name"])){
                $this->form_validation->set_rules('file'.$class_id, '', 'callback_file_check["'.$class_id.'"]');
                if($this->form_validation->run() == false){
                    echo 'Incorrect file type!!!'; 
                    die();
                }else{    
                    $path = $_FILES["file".$class_id]["tmp_name"];
                    $object = PHPExcel_IOFactory::load($path);
                    //$object->getSheetByName('Data');
                    $censusId = $this->session->userdata['census_id'];
                    // excel sheet validating part
                    // following codes are used to validate admission number
                    foreach($object->getWorksheetIterator() as $worksheet){
                        $sheet = $object->getSheet(0);
                        $highestRow = $sheet->getHighestRow();
                        $admissionError = [];
                        for($row=2; $row<=$highestRow; $row++){
                            $admNo = $sheet->getCellByColumnAndRow(0, $row)->getFormattedValue(); // get adm_no from excel
                            //echo $admNo; die();
                            $nameWithIni = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                            //echo (!is_numeric($admNo)); die();
                            if(!is_numeric($admNo) ||  (strlen($admNo) < 4) || (strlen($admNo) > 5) ){
                                $admissionError[$row]['adm_no'] = $admNo;
                            }
                            
                        }   // for($row=2; $row<=$highestRow; $row++){
                        if(!empty($admissionError)){
                            echo 'These admission numbers not in correct format!!!'.' - ';
                            foreach ($admissionError as $admissionError) {
                                echo $admissionError['adm_no'].' ,'; // nl2br() function inserts HTML line breaks (<br> or <br />) in front of each newline (\n) in a string.
                            }
                            die(); 
                        }
                        // following codes are used to check students exists 
                        $highestRow = $sheet->getHighestRow();
                        $studentsNotExistsArray = [];
                        for($row=2; $row<=$highestRow; $row++){
                            //set validations
                            if($sheet->getCellByColumnAndRow(0, $row)->getValue()){
                                $admNo = $sheet->getCellByColumnAndRow(0, $row)->getValue(); // get adm_no from excel
                            }
                            // check whether students are in the system. here not check the class
                            $studentExists = $this->Student_model->check_student_exist($admNo,$censusId); 
                            if(!$studentExists){ // if not exists
                                $nameWithIni = $sheet->getCellByColumnAndRow(1, $row)->getValue();
                                $studentsNotExistsArray[$row]['adm_no'] = $admNo;
                                $studentsNotExistsArray[$row]['stu_name'] = $nameWithIni;   
                            }
                        }
                        if(!empty($studentsNotExistsArray)){
                            foreach ($studentsNotExistsArray as $student) {
                                echo nl2br($student['adm_no'].' - '.$student['stu_name']).', ';
                            }
                            echo ' not found in the system!!!';
                            die();
                        }
                    } // foreach($object->getWorksheetIterator() as $worksheet){

                    // start adding excel sheet
                    //foreach($object->getWorksheetIterator() as $worksheet){
                    $sheet = $object->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $st_count = 0;
                    $grade_id = $this->input->post('grade_id_hidden');
                    $class_id = $this->input->post('class_id_hidden');
                    $year = $this->input->post('year_hidden');
                    $updateCount=0;
                    $insertCount=0;

                    // deleting existing records in this class
                    $this->Student_model->delete_all_students_from_class($grade_id, $class_id, $year, $censusId); 
                    
                    for($row=2; $row<=$highestRow; $row++){

                        $admNo = $sheet->getCellByColumnAndRow(0, $row)->getValue(); // get adm_no from excel
                        $now = date('Y-m-d H:i:s');
                       
                        //$data = []; // $data array must be empty for this iteration
                        //$data  = array();
                        $insertData = []; 
                        $insertData[] = array(
                            'st_gr_cl_id' =>  '', 
                            'index_no' =>  $admNo, // only the admNo fetch from excel, other data fetched from the form
                            'grade_id' =>  $grade_id,
                            'class_id' =>  $class_id,
                            'census_id' =>  $censusId,
                            'year' =>  $year,
                            'date_added'    => $now,
                            'date_updated'  => $now,
                            'is_deleted' => ''
                        );
                                    //print_r($insertData); 
                        // check whether student is in a class this year
                        $exist = $this->Student_model->check_student_exist_in_a_class($admNo,$censusId,$year);
                        if($exist){ // if student is in a class
                            // get data of class where he exists
                            $student = $this->Student_model->get_student_grade_class($admNo,$censusId,$year);
                            foreach ($student as $student) {
                                $st_gr_cl_id = $student->st_gr_cl_id;
                                $grade = $student->grade_id;
                                $gradeName = $student->grade;
                                $class = $student->class_id;
                                $className = $student->class;
                                $date_added = $student->added_date;
                            }
                            if($grade_id==$grade && $class_id==$class){
                                $updateData = []; 
                                $updateData = array(
                                    'st_gr_cl_id' => $st_gr_cl_id,
                                    'index_no' =>  $admNo,
                                    'grade_id' =>  $grade_id,
                                    'class_id' =>  $class_id,
                                    'census_id' =>  $censusId,
                                    'year' =>  $year,
                                    'date_added'    => $date_added,
                                    'date_updated'  => $now,
                                    'is_deleted' => ''
                                ); 
                                if($this->Student_model->update_student_grade_class($updateData)){
                                    $updateCount += 1;
                                }
                            }else{ // if the student exist in another class
                                echo $admNo.' already exists in '.$gradeName.' '.$className;
                                die();  
                            }
                        }else{  // if($exist){ // if student is in a class
                            // add student to class
                            if($this->Student_model->insert_bulk_students_to_class($insertData)){
                                $insertCount += 1;
                            }else{
                                echo 'Error in inserting data '.$admNo.' !!!';
                                die();
                            }
                        }
                    } //for($row=2; $row<=$highestRow; $row++) 
                    // if($updateCount > 0 ){
                    //     echo $updateCount.' students were updated';   
                    // }
                    if($insertCount > 0){ 
                        // here cant echo the no of students inserted because of location.reload method in jquery in studentInClasses view page
                        echo 'Students were inserted successfully';   
                    }   
                }
            }else{ // if(isset($_FILES["file"]["name"])){
                echo 'No file selected!!!';
            } 

        }else{ 
            redirect('GeneralInfo/loginPage');
        }
    }

    // add individual students to the system
    public function addStudent(){
        if(is_logged_in()){
            if ($this->input->post('btn_add_new_student_info') == "Add_New"){
                //set validations
                $this->form_validation->set_rules("index_no_txt","Index number","required|numeric|min_length[4]|max_length[5]");
                $this->form_validation->set_rules("full_name_txt","Full Name","required");
                $this->form_validation->set_rules("name_with_ini_txt","Name with initials","required");
                $this->form_validation->set_rules("gender_select","Gender","required");            
                //$this->form_validation->set_rules("grade_select","Grade","required");
                //$this->form_validation->set_rules("class_select","Class","required");
                //$this->form_validation->set_rules("phone_home_txt","Index number","required|numeric|min_length[10]|max_length[10]");
                //$this->form_validation->set_rules("phone_txt","Index number","required|numeric|min_length[4]|max_length[5]");
                //$this->form_validation->set_rules("census_id_select","Class","required");

                if ($this->form_validation->run() == false){
                    //validation fails
                    if ( $this->session->userdata['userrole_id'] == 1 ) {
                        $this->session->set_flashdata('msg', array('text' => 'Index Number, Full Name, Name with initials, Gender and Census ID are required!','class' => 'alert alert-danger'));
                    }
                    if( $this->session->userdata['userrole_id'] == 2 ){
                        $this->session->set_flashdata('msg', array('text' => 'Index Number, Full Name, Name with initials and Gender are required!','class' => 'alert alert-danger'));
                    }
                    $this->index();
                }else{
                    // validation succeeds
                    $censusId = $this->input->post('census_id_select');
                    $indexNo= $this->input->post('index_no_txt');
                    $student_exist = $this->Student_model->check_student_exist($indexNo,$censusId); 
                    if( $student_exist ){
                        $this->session->set_flashdata('msg', array('text' => 'Index No - '.$indexNo.' already exists in the system!!!','class' => 'alert alert-danger'));
                        redirect('Student');                       
                    }else{
                        $now = date('Y-m-d H:i:s');
                        $studentData = array(
                            'st_id' => '',
                            'index_no' => $this->input->post('index_no_txt'),
                            'fullname' => $this->input->post('full_name_txt'),
                            'name_with_initials' => $this->input->post('name_with_ini_txt'),
                            'address1' => $this->input->post('address1_txt'),
                            'address2' => $this->input->post('address2_txt'),
                            'phone_no_1' => $this->input->post('phone_no_1_txt'),
                            'phone_no_2' => $this->input->post('phone_no_2_txt'),
                            'phone_home' => $this->input->post('phone_home_txt'),
                            'dob' => $this->input->post('dob_txt'),
                            'gender_id' => $this->input->post('gender_select'),
                            'ethnic_group_id' => $this->input->post('ethnicity_select'),
                            'religion_id' => $this->input->post('religion_select'),
                            'd_o_admission' => $this->input->post('admission_date_txt'),
                            'census_id' => $this->input->post('census_id_select'),
                            'st_status_id' => 1,  // active
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                        );
                        $studentHistory = array(
                            'st_hist_id' => '',
                            'index_no' => $this->input->post('index_no_txt'),
                            'census_id' => $this->input->post('census_id_select'),
                            'admit_date' => $this->input->post('admission_date_txt'),
                            'st_status_id' => 1,
                            'left_date' => '',
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                        );
                        $gradeData = array(
                            'st_gr_cl_id' => '',
                            'index_no' => $this->input->post('index_no_txt'),
                            'grade_id' => $this->input->post('grade_select'),
                            'class_id' => $this->input->post('class_select'),
                            'census_id' => $this->input->post('census_id_select'),
                            'year' => $this->input->post('select_year'),
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                        );
                        $guardianData = array(
                            'id' => '',
                            'index_no' => $indexNo,
                            'census_id' => $this->input->post('census_id_select'),
                            'f_name' => $this->input->post('fa_name_txt'),
                            'f_job' => $this->input->post('fa_job_txt'),
                            'f_mobile' => $this->input->post('fa_tel_txt'),
                            'm_name' =>$this->input->post('mo_name_txt'),
                            'm_job' => $this->input->post('mo_job_txt'),
                            'm_mobile' => $this->input->post('mo_tel_txt'),
                            'g_name' => $this->input->post('guard_name_txt'),
                            'g_job' => $this->input->post('guard_job_txt'),
                            'g_mobile' => $this->input->post('guard_tel_txt'),
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                        ); 
                        $this->Student_model->add_parent($guardianData); 
                        if( !empty($_FILES['student_image']['name']) ){
                            $config['upload_path']          = './assets/uploaded/student_images/';
                            $config['allowed_types']        = 'gif|jpg|png';
                            $config['max_size']             = 100; // 100KB
                            $config['max_width']            = 1024;
                            $config['max_height']           = 768;
                            $config['file_name']            = $this->input->post('census_id_select').'_'.$this->input->post('index_no_txt');
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
                        $result = $this->Student_model->add_student($studentData); 
                        $addToHistory = $this->Student_model->add_student_history($studentHistory);
                        $gradeResult = $this->Student_model->add_student_to_a_class($gradeData); 
                        if($result){
                            $this->session->set_flashdata('msg', array('text' => 'Student added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('msg', array('text' => 'could n\'t add student details!!!','class' => 'alert alert-danger'));
                        }
                        redirect('Student');
                    }
                }   
            }else{redirect('Student'); }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }  // view student after added  
    // this method view student update page by school user and admin
    public function editStudentInfoPage(){ // this is used by school user
        if( is_logged_in() ){
            $stuId = $this->uri->segment(3);
            $indexNo = $this->uri->segment(4);
            $censusId = $this->uri->segment(5);
            $studentData = $this->Student_model->get_stu_info($stuId);
            $std_game_info = $this->Student_model->get_std_game_info($indexNo, $censusId);
            $std_ex_cur_info = $this->Student_model->get_std_ex_cur_info($indexNo, $censusId);
            $std_winnings = $this->Student_model->get_std_winnings($indexNo, $censusId);
            //$stuentGradeClass = $this->Student_model->get_student_current_grade_class($indexNo,$censusId,$year);
            //$studentGuardian = $this->Student_model->get_guardian($indexNo,$censusId);
            $data['studentData'] = $studentData;
            $data['std_game_info'] = $std_game_info;
            $data['std_ex_cur_info'] = $std_ex_cur_info;
            $data['std_winnings'] = $std_winnings;
            //$data['stuentGradeClass'] = $stuentGradeClass;
            //$data['studentGuardian'] = $studentGuardian;
            $data['title'] = 'Update student details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'student/editStudent';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } // end editStudentInfoPage by school user
    public function updateStudentPersonalInfo(){
        if(is_logged_in()){
            if ( $this->input->post('btn_edit_student_pers_info') == "Update" ){
                $stId = $this->input->post('st_id_hidden'); 
                $censusId = $this->input->post('census_id_hidden'); 
                $indexNo = $this->input->post('index_no_txt'); 
                //$this->form_validation->set_rules("index_no_txt","Admission Number","trim|required");   
                $this->form_validation->set_rules("name_with_ini_txt","Name with initials","trim|required|callback_alpha_dot_space");   
                $this->form_validation->set_rules("fullname_txt","Full name","trim|required|callback_alpha_dot_space");  
                if ( $this->input->post('phone_no_1_txt') ) {
                    $this->form_validation->set_rules("phone_no_1_txt","Mobile Number","trim|required|numeric|min_length[10]|max_length[10]"); 
                }
                if ( $this->input->post('phone_no_2_txt') ) {
                    $this->form_validation->set_rules("phone_no_2_txt","WhatsApp Number","trim|required|numeric|min_length[10]|max_length[10]"); 
                }
                if ( $this->input->post('phone_home_txt') ) {
                    $this->form_validation->set_rules("phone_home_txt","Home Number","trim|required|numeric|min_length[10]|max_length[10]"); 
                }
                if ( $this->form_validation->run() == FALSE ){
                    //validation fails
                    $this->viewEditStudentViewAfterUpdate( $stId, $indexNo, $censusId );
                //} 
                // if($this->Student_model->check_student_exist($indexNo, $censusId)){
                //     $this->session->set_flashdata('updateErrorMsg', array('text' => $indexNo.' already exists!','class' => 'alert alert-danger'));
                //     $this->viewEditStudentViewAfterUpdate($stId, $indexNo, $censusId);
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'st_id' => $stId,
                        'index_no' => $this->input->post('index_no_txt'),
                        'fullname' => $this->input->post('fullname_txt'),
                        'name_with_initials' => $this->input->post('name_with_ini_txt'),
                        'address1' => $this->input->post('address1_txt'),
                        'address2' => $this->input->post('address2_txt'),
                        'phone_no_1' => $this->input->post('phone_no_1_txt'),
                        'phone_no_2' => $this->input->post('phone_no_2_txt'),
                        'phone_home' => $this->input->post('phone_home_txt'),
                        'dob' => $this->input->post('dob_txt'),
                        'gender_id' => $this->input->post('gender_select'),
                        'ethnic_group_id' => $this->input->post('ethnicity_select'),
                        'religion_id' => $this->input->post('religion_select'),
                        'd_o_admission' => $this->input->post('d_o_admission_txt'),
                        'census_id' => $this->input->post('census_id_hidden'),
                        'st_status_id' => $this->input->post('stu_status_select'),
                        'date_added' => $this->input->post('date_added_hidden'),
                        'date_updated' => $now,
                        'is_deleted' => 0,
                    );      
                    $result = $this->Student_model->update_student_personal_info($data);
                    $statusid = $this->input->post('stu_status_select');
                    if( ($statusid == 2) || ($statusid == 3) ){
                        $indexNo = $this->input->post('index_no_txt');
                        $censusId = $this->input->post('census_id_hidden');
                        $stuHistory = array(
                            'index_no' => $indexNo,
                            'census_id' => $censusId,
                            'st_status_id' => $statusid,
                            'date_updated' => $now,
                            'is_deleted' => '',
                        );
                        $this->Student_model->update_student_history($stuHistory);
                    }
                    if( $result ){
                        $this->session->set_flashdata('updateSuccessMsg', array('text' => 'Student updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('updateErrorMsg', array('text' => 'Student not updated!!!','class' => 'alert alert-danger','update'=>'false'));
                    }
                    //$stId and $indexNo both needed to go back. bcz $indexNo is foreign key of other tables
                    $this->viewEditStudentViewAfterUpdate($stId,$indexNo,$censusId);
                }
            }else{
                $this->index();
            }
        }else{
            redirect('User');
        }
    } 
    public function updateStudentAcademicInfo(){
        if( is_logged_in() ){
            $role_id = $this->session->userdata['userrole_id'];
            if ($this->input->post('btn_edit_stu_ac_info') == "Update"){
                $stId = $this->input->post('st_id_hidden'); 
                $indexNo = $this->input->post('index_no_hidden'); 
                $this->form_validation->set_rules("grade_select","Grade","trim|required");   
                $this->form_validation->set_rules("class_select","Class","trim|required");
                if($role_id==1){ // if the user is admin
                    $this->form_validation->set_rules("school_select","School","trim|required");  
                    $censusId = $this->input->post('school_select'); 
                }
                if($role_id==2){ // if the user is school
                    $censusId = $this->input->post('census_id_hidden'); 
                }
                //die();
                if ( $this->form_validation->run() == FALSE ){
                    if($role_id==1){
                        $this->session->set_flashdata('acInfoUpdateErrorMsg', array('text' => 'School, Grade and Class are required!','class' => 'alert alert-danger'));
                    }else if($role_id==2){
                        $this->session->set_flashdata('acInfoUpdateErrorMsg', array('text' => 'Grade and Class are required!','class' => 'alert alert-danger'));
                    }
                    $this->viewEditStudentViewAfterUpdate( $stId, $indexNo, $censusId );
                }else{                
                    $stGrClId = $this->input->post('st_gr_cl_id_hidden'); 
                    $stId = $this->input->post('st_id_hidden'); 
                    $year = $this->input->post('select_year');
                    $now = date('Y-m-d H:i:s');
                    $gradeData = array(
                        'st_gr_cl_id' => $stGrClId,
                        'index_no' => $indexNo,
                        'grade_id' => $this->input->post('grade_select'),
                        'class_id' => $this->input->post('class_select'),
                        'census_id' => $censusId,
                        'year' => $year,
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    if( $role_id==1 ){
                        $result = $this->Student_model->get_stu_info($stId);
                        foreach ( $result as $row ) {
                            $school = $row->census_id;
                        }
                        if( empty( $school ) ){
                            $schoolData = array(
                                'st_id' => $stId,
                                'census_id' => $censusId,
                                'date_updated' => $now,
                            );
                            $this->Student_model->update_student_personal_info($schoolData);
                        }
                    }
                    
                    if($this->Student_model->check_student_exist_in_a_class( $indexNo, $censusId, $year)){  // if student is in a class this year, his class is updated
                        $result = $this->Student_model->update_student_grade_class($gradeData); 
                        if($result){
                            $this->session->set_flashdata('acInfoUpdateSuccessMsg', array('text' => 'Student academic data updated successfully','class' => 'alert alert-success','update'=>'true'));
                        }else{
                            $this->session->set_flashdata('acInfoUpdateErrorMsg', array('text' => 'Student academic data not updated!!!','class' => 'alert alert-danger','update'=>'false'));
                        } 
                    }else{ // when he is not in a class this year, insert to the class
                        $result = $this->Student_model->add_student_to_a_class($gradeData); 
                        if($result){
                            $this->session->set_flashdata('acInfoUpdateSuccessMsg', array('text' => 'Student academic data added successfully','class' => 'alert alert-success','update'=>'true'));
                        }else{
                            $this->session->set_flashdata('acInfoUpdateErrorMsg', array('text' => '1Student academic data not added!!!','class' => 'alert alert-danger','update'=>'false'));
                        } 
                    }
                    $this->viewEditStudentViewAfterUpdate($stId,$indexNo,$censusId);
                }
            }else{
                $this->index();
            }
        }else{
            redirect('User');
        }
    } 
    // used in updateStudentGuardianInfo()
    public function alpha_dot_space($fullname){
        if (! preg_match('/^[a-zA-Z\s.]+$/', $fullname)) {
            $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters, dots and White spaces');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function updateStudentGuardianInfo(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_stu_guard_info') == "Update"){
                $stId = $this->input->post('st_id_hidden');
                $indexNo = $this->input->post('index_no_hidden'); 
                $censusId = $this->input->post('census_id_hidden');  
                $guardianId = $this->input->post('guardian_id_hidden');  
                $fa_name = $this->input->post('fa_name_txt');
                $mo_name = $this->input->post('mo_name_txt');
                $g_name = $this->input->post('g_name_txt');
                // $this->form_validation->set_rules("index_no_txt","Admission Number","trim");   
                //$this->form_validation->set_rules("fa_name_txt","Name with initials","required");   
                //$this->form_validation->set_rules("mo_name_txt","Full name","trim");  
                // $this->form_validation->set_rules("gender_select","Gender","trim");  
                if ( $this->input->post('fa_name_txt') ) {
                    $this->form_validation->set_rules("fa_name_txt","Father Name","trim|required|callback_alpha_dot_space"); 
                }if ( $this->input->post('fa_job_txt') ) {
                    $this->form_validation->set_rules("fa_job_txt","Father Job","trim|required|callback_alpha_dot_space"); 
                }if ( $this->input->post('fa_tel_txt') ) {
                    $this->form_validation->set_rules("fa_tel_txt","Mobile Number","trim|required|numeric|min_length[10]|max_length[10]"); 
                }
                if ( $this->input->post('mo_name_txt') ) {
                    $this->form_validation->set_rules("mo_name_txt","Mother Name","trim|required|callback_alpha_dot_space"); 
                }if ( $this->input->post('mo_job_txt') ) {
                    $this->form_validation->set_rules("mo_job_txt","Mother Job","trim|required|callback_alpha_dot_space"); 
                }if ( $this->input->post('mo_tel_txt') ) {
                    $this->form_validation->set_rules("mo_tel_txt","Mobile Number","trim|required|numeric|min_length[10]|max_length[10]"); 
                }
                if ( $this->input->post('g_name_txt') ) {
                    $this->form_validation->set_rules("g_name_txt","Guardian Name","trim|required|callback_alpha_dot_space"); 
                }if ( $this->input->post('g_job_txt') ) {
                    $this->form_validation->set_rules("g_job_txt","Guardian Job","trim|required|callback_alpha_dot_space"); 
                }if ( $this->input->post('g_tel_txt') ) {
                    $this->form_validation->set_rules("g_tel_txt","Mobile Number","trim|required|numeric|min_length[10]|max_length[10]"); 
                }
                if( $this->form_validation->run() == FALSE ){
                    //validation fails
                    //$this->session->set_flashdata('updateGuardErrorMsg', array('text' => 'Atleast One parent name is required!','class' => 'alert alert-danger'));
                    $this->viewEditStudentViewAfterUpdate( $stId, $indexNo, $censusId );
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $guardianNewdata = array(
                        'id' => $guardianId,
                        'index_no' => $indexNo,
                        'census_id' => $censusId,
                        'f_name' => $this->input->post('fa_name_txt'),
                        'f_job' => $this->input->post('fa_job_txt'),
                        'f_mobile' => $this->input->post('fa_tel_txt'),
                        'm_name' => $this->input->post('mo_name_txt'),
                        'm_job' => $this->input->post('mo_job_txt'),
                        'm_mobile' => $this->input->post('mo_tel_txt'),
                        'g_name' => $this->input->post('g_name_txt'),
                        'g_job' => $this->input->post('g_job_txt'),
                        'g_mobile' => $this->input->post('g_tel_txt'),
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => 0,
                    );      
                    //print_r($data); die();
                    if( !empty( $guardianId ) ){
                        $result = $this->Student_model->update_guardian( $guardianNewdata );
                        if( $result ){
                            $this->session->set_flashdata('updateGuardSuccessMsg', array('text' => 'Guardian updated successfully','class' => 'alert alert-success','update'=>'true'));
                        }else{
                            $this->session->set_flashdata('updateGuardErrorMsg', array('text' => 'Guardian not updated!!!','class' => 'alert alert-danger','update'=>'false'));
                        }
                    }else{
                        $result = $this->Student_model->add_guardian( $guardianNewdata );
                        if( $result ){
                            $this->session->set_flashdata('updateGuardSuccessMsg', array('text' => 'Guardian added successfully','class' => 'alert alert-success','update'=>'true'));
                        }else{
                            $this->session->set_flashdata('updateGuardErrorMsg', array('text' => 'Guardian not added!!!','class' => 'alert alert-danger','update'=>'false'));
                        }
                    }
                    //echo $result; die();
                    $this->viewEditStudentViewAfterUpdate($stId,$indexNo,$censusId);
                }
            }else{
                $this->index();
            }
        }else{
            redirect('User');
        }
    } 
    public function uploadStudentImage(){
        if( is_logged_in() ){
            if( $this->input->post('btn_upload_stu_img')=='upload_stu_image' ){
                $stId = $this->input->post('stu_id_hidden');
                $indexNo = $this->input->post('index_no_hidden'); 
                $censusId = $this->input->post('census_id_hidden');
                if(!empty($_FILES['stu_image']['name'])){
                    $config['upload_path']          = './assets/uploaded/student_images/';
                    $config['allowed_types']        = 'jpg';
                    $config['max_size']             = 400; // 100KB
                    $config['max_width']            = 250;
                    $config['max_height']           = 250;
                    $config['file_name']            = $censusId.'_'.$indexNo;
                    $config['overwrite']           = TRUE;
                    $this->load->library('upload', $config);
                    if(!$this->upload->do_upload('stu_image')){
                        $uploadError = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('stdImgUploadError', $uploadError);
                    }else{
                        $uploadSuccess = 'Image uploaded successfully';
                        $this->session->set_flashdata('stdImgUploadSuccess', $uploadSuccess);
                    }
                }else{
                    $noImageError = 'Please select the image';
                    $this->session->set_flashdata('noImageError',$noImageError);
                }
                $this->viewEditStudentViewAfterUpdate($stId,$indexNo,$censusId);
            }else{
                $this->index();
            }
        }else{
            redirect('User');
        }
    }
    // add a new game info to student
    public function AssignToNewGame(){
        if( is_logged_in() ){
            $this->form_validation->set_rules("game_select","Game","trim|required");
            $this->form_validation->set_rules("game_role_select","Student Role","trim|required");
            //$this->form_validation->set_rules("year_select","Year","trim|required");
            $stId = $this->input->post('st_id_hidden');
            $censusId = $this->input->post('census_id_hidden');
            $indexNo = $this->input->post('index_no_hidden');
            if( $this->form_validation->run() == FALSE ){
                //echo 'hi'; die();
                //validation fails
                $this->session->set_flashdata('stdGameMsg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                $this->viewEditStudentViewAfterUpdate($stId, $indexNo, $censusId);
            }else{
                $gameId = $this->input->post('game_select');
                $gameRoleId = $this->input->post('game_role_select');
                $year = $this->input->post('year_select');
                $date = $this->input->post('game_effective_date_txt');
                //die();
                //$gameExists = $this->Staff_model->check_std_game_exists($censusId, $indexNo, $gameId, $gameRoleId, $year);
                // if( !$gameExists ){
                //     if( $gameRoleId == 1 ){
                //         $extraCurMic = $this->Staff_model->check_extra_curri_mic_exists( $extraCurId, $extraCurRoleId);
                //         if( $extraCurMic ){
                //             $this->session->set_flashdata('extCurMsg', array('text' => 'The MIC already exists for this activity','class' => 'alert alert-danger'));
                //             $this->viewEditStudentViewAfterUpdate($stId, $indexNo, $censusId);
                //         }
                //     }
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'st_gm_id' => '',
                    'census_id' => $censusId,
                    'index_no' => $indexNo,
                    'game_id' => $gameId,
                    'std_gm_role_id' => $gameRoleId,
                    'year' => $year,
                    'date' => $date,
                    'date_added' => $now,
                    'date_updated' => $now
                );
                $member = $this->Student_model->check_game_membership_exist( $censusId, $indexNo, $gameId );
                $gameName = $this->Student_model->get_game_name( $gameId );
                if( $member ){
                    if( $gameRoleId == 1 ){
                        $this->session->set_flashdata('stdGameMsg', array('text' => 'Student is already a member!!!','class' => 'alert alert-danger'));
                    }elseif( $gameRoleId == 3 ){
                        $captancyExist = $this->Student_model->check_game_captancy_exist( $gameId, $gameRoleId, $date );
                        if( $captancyExist ){
                            $this->session->set_flashdata('stdGameMsg', array('text' => 'Captancy has already been assigned for '.$gameName.' in '.$year.'!','class' => 'alert alert-danger'));
                        }else{
                            $result = $this->Student_model->insert_std_game_info($data);
                            if( $result ){
                                $this->session->set_flashdata('stdGameMsg', array('text' => 'Game details added successfully','class' => 'alert alert-success'));
                            }else{
                                $this->session->set_flashdata('stdGameMsg', array('text' => 'Game details not added!!!','class' => 'alert alert-danger'));
                            }
                        }
                    }else{
                        $result = $this->Student_model->insert_std_game_info($data);
                        if( $result ){
                            $this->session->set_flashdata('stdGameMsg', array('text' => 'Game details added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('stdGameMsg', array('text' => 'Game details not added!!!','class' => 'alert alert-danger'));
                        }
                    }
                }else{
                    if( $gameRoleId == 1 ){
                        $result = $this->Student_model->insert_std_game_info( $data );
                        if( $result ){
                            $this->session->set_flashdata('stdGameMsg', array('text' => 'Game details added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('stdGameMsg', array('text' => 'Game details not added!!!','class' => 'alert alert-danger'));
                        }
                    }else{
                        $this->session->set_flashdata('stdGameMsg', array('text' => 'Student must be a member of the game first!!!','class' => 'alert alert-danger'));
                    }
                }                
                $this->viewEditStudentViewAfterUpdate( $stId, $indexNo, $censusId );
            }
        }else{
            redirect('User');
        }
    }
    // add a new extra curriculum to student
    public function AssignToNewExtraCurri(){
        if( is_logged_in() ){
            $this->form_validation->set_rules("ex_cur_select","Game","trim|required");
            $this->form_validation->set_rules("std_ex_cur_role_select","Student Role","trim|required");
            $this->form_validation->set_rules("ex_cu_year_select","Year","trim|required");
            $stId = $this->input->post('st_id_hidden');
            $censusId = $this->input->post('census_id_hidden');
            $indexNo = $this->input->post('index_no_hidden');
            if( $this->form_validation->run() == FALSE ){
                //validation fails
                $this->session->set_flashdata('stdGameMsg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                $this->viewEditStudentViewAfterUpdate($stId, $indexNo, $censusId);
            }else{
                $exCurId = $this->input->post('ex_cur_select');
                $exCurRoleId = $this->input->post('std_ex_cur_role_select');
                $year = $this->input->post('ex_cu_year_select');
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'std_ex_cur_id' => '',
                    'census_id' => $censusId,
                    'index_no' => $indexNo,
                    'extra_curri_id' => $exCurId,
                    'std_ex_cur_role_id' => $exCurRoleId,
                    'year' => $year,
                    'date_added' => $now,
                    'date_updated' => $now
                );
                $membershipExist = $this->Student_model->check_ex_cur_membership_exist( $censusId, $indexNo, $exCurId );
                if( $membershipExist ){
                    if( $exCurRoleId == 7 ){
                        $this->session->set_flashdata('stdexCurMsg', array('text' => 'Student is already a member!!!','class' => 'alert alert-danger'));
                    }else{
                        $exCurName = $this->Student_model->get_ex_cur_name( $exCurId );
                        $roleName = $this->Student_model->get_ex_cur_role_name( $exCurRoleId );
                        $positionExist = $this->Student_model->is_student_has_position_except_ex_cur_membership( $censusId, $indexNo, $exCurId, $year );
                        if($positionExist){
                            $this->session->set_flashdata('stdexCurMsg', array('text' => ' Student is in another position for '.$year.'!','class' => 'alert alert-danger'));
                        }else{
                            $roleExist = $this->Student_model->check_std_ex_cur_role_exist($censusId, $exCurId, $exCurRoleId, $year );
                            if($roleExist){
                                $this->session->set_flashdata('stdexCurMsg', array('text' => $roleName. ' has already been assigned to '.$exCurName.' in '.$year.'!','class' => 'alert alert-danger'));
                                //$this->viewEditStudentViewAfterUpdate($stId, $indexNo, $censusId);
                                //break;
                            }else{
                                $result = $this->Student_model->insert_std_ex_cur_info($data);
                                if( $result ){
                                    $this->session->set_flashdata('stdexCurMsg', array('text' => 'Extra Curriculum details added successfully','class' => 'alert alert-success'));
                                }else{
                                    $this->session->set_flashdata('stdexCurMsg', array('text' => 'Extra Curriculum details not added!!!','class' => 'alert alert-danger'));
                                }
                            }
                        }
                    }
                }else{
                    if( $exCurRoleId == 7 ){
                        $result = $this->Student_model->insert_std_ex_cur_info($data);
                        if( $result ){
                            $this->session->set_flashdata('stdexCurMsg', array('text' => 'Extra Curriculum details added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('stdexCurMsg', array('text' => 'Extra Curriculum details not added!!!','class' => 'alert alert-danger'));
                        }
                    }else{
                        $this->session->set_flashdata('stdexCurMsg', array('text' => 'Student must be a member first!!!','class' => 'alert alert-danger'));
                    }
                }            
                $this->viewEditStudentViewAfterUpdate($stId, $indexNo, $censusId);
            }
        }else{
            redirect('User');
        }
    }
     // add a new game info to student
     public function AddStudentWin(){
        if( is_logged_in() ){
            $this->form_validation->set_rules("main_type_select","Main type","trim|required");
            $stId = $this->input->post('st_id_hidden');
            $censusId = $this->input->post('census_id_hidden');
            $indexNo = $this->input->post('index_no_hidden');
            if( $this->form_validation->run() == FALSE ){
                //validation fails
                $this->session->set_flashdata('stdGameMsg', array('text' => 'Main type is required!','class' => 'alert alert-danger'));
                $this->viewEditStudentViewAfterUpdate($stId, $indexNo, $censusId);
            }else{
                $mainType = $this->input->post('main_type_select');
                $exCurId = $this->input->post('win_ex_cur_select');
                $exCurRoleId = $this->input->post('win_std_ex_cur_role_select');
                $gameId = $this->input->post('win_game_select');
                $gameRoleId = $this->input->post('win_game_role_select');
                $contest = $this->input->post('contest_text_area');
                $winTypeId = $this->input->post('win_type_select');
                $remarks = $this->input->post('win_remarks_text_area');
                $date = $this->input->post('date_held_txt');
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'std_win_id' => '',
                    'census_id' => $censusId,
                    'index_no' => $indexNo,
                    'main_type' => $mainType,
                    'extra_curri_id' => $exCurId,
                    'std_ex_cur_role_id' => $exCurRoleId,
                    'game_id' => $gameId,
                    'std_gm_role_id' => $gameRoleId,
                    'contest' => $contest,
                    'win_type_id' => $winTypeId,
                    'remarks' => $remarks,
                    'date_held' => $date,
                    'date_added' => $now,
                    'date_updated' => $now
                );
                $result = $this->Student_model->insert_std_winning_info($data);
                if( $result ){
                    $this->session->set_flashdata('stdWinMsg', array('text' => 'Winning added successfully','class' => 'alert alert-success'));
                }else{
                    $this->session->set_flashdata('stdWinMsg', array('text' => 'Winning details not added!!!','class' => 'alert alert-danger'));
                }
                $this->viewEditStudentViewAfterUpdate( $stId, $indexNo, $censusId );
            }
        }else{
            redirect('User');
        }
    }
    public function viewEditStudentViewAfterUpdate($stId, $indexNo, $censusId){
        if(is_logged_in()){
            //echo $stId; die();
            $studentData = $this->Student_model->get_stu_info($stId);
            $year = date("Y");
            $stuentGradeClass = $this->Student_model->get_student_current_grade_class($indexNo,$censusId,$year);
            $studentGuardian = $this->Student_model->get_guardian($indexNo,$censusId);
            $std_game_info = $this->Student_model->get_std_game_info($indexNo, $censusId);
            $std_ex_cur_info = $this->Student_model->get_std_ex_cur_info($indexNo, $censusId);
            $std_winnings = $this->Student_model->get_std_winnings($indexNo, $censusId);
            $data['studentData'] = $studentData;
            $data['stuentGradeClass'] = $stuentGradeClass;
            $data['studentGuardian'] = $studentGuardian;
            $data['std_game_info'] = $std_game_info;
            $data['std_ex_cur_info'] = $std_ex_cur_info;
            $data['std_winnings'] = $std_winnings;
            $data['title'] = 'Update student details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'student/editStudent';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }
    }
    // delete student game info from the database table by AJAX call
    // used in student update view
    public function deleteGameInfo(){
        if(is_logged_in()){
            $student_game_id = $this->input->post('stgm_id');
            $result = $this->Student_model->delete_student_game($student_game_id);
            if($result){
                echo 'true';
            }else{
                echo 'false';
            }
        }else{
            redirect('User');
        }
    }
    // delete student extra curriculum info from the database table by AJAX call and used in student update view
    public function deleteStdExCurInfo(){
        if(is_logged_in()){
            $st_ex_cur_id = $this->input->post('st_ex_cur_id');
            $result = $this->Student_model->delete_std_ex_cur_info($st_ex_cur_id);
            if($result){
                echo 'true';
            }else{
                echo 'false';
            }
        }else{
            redirect('User');
        }
    }
    // delete student winning info from the database table by AJAX call and used in student update view
    public function deleteStdWinInfo(){
        if(is_logged_in()){
            $std_win_id = $this->input->post('std_win_id');
            $result = $this->Student_model->delete_std_win_info($std_win_id);
            if($result){
                echo 'true';
            }else{
                echo 'false';
            }
        }else{
            redirect('User');
        }
    }
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
            $this->form_validation->set_rules("index_no_txt","Index Number","trim|required|regex_match[/^[0-9]{5}$/]");
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
    // used in change admission number view
    public function findStudentByAdmNo(){
        if( is_logged_in() ){
            $censusId = $_POST['census_id']; 
            $admNo = $_POST['adm_no']; 
            $output = '';
            $result = $this->Student_model->get_stu_info_by_index( $admNo, $censusId );
            if( $result ){
                foreach ( $result as $result ) {
                    $admNo = $result->index_no;
                    $fullName = $result->fullname;
                    $school = $result->sch_name;
                    if( $result->is_deleted == 1 ){
                        $status = 'Yes';
                    }else{
                        $status = 'No';
                    }
                }
                $currentClass = $this->Student_model->get_student_current_grade_class( $admNo, $censusId );
                foreach ( $currentClass as $row ) {
                    $class = $row->grade.$row->class;
                    $year = $row->year;
                }
                $output .= '
                <table id="" class="stripe row-border order-column table-hover">
                        <thead>
                            <tr>
                                <th class="col-sm-6"></th><th class="col-sm-6"></th>
                            </tr>
                        </thead>
                    ';
                $output .= '
                        <tbody>
                            <tr><th>ඇ. වීමේ අංකය </th><td>'.$admNo.'</td></tr>
                            <tr><th> සම්පූර්ණ නම  </th><td>'.$fullName.'</td></tr>
                            <tr><th> පන්තිය  </th><td>'.$class.'</td></tr>
                            <tr><th> වර්ෂය  </th><td>'.$year.'</td></tr>
                            <tr><th> පාසල  </th><td>'.$school.'</td></tr>
                            <tr><th> Is Deleted?  </th><td>'.$status.'</td></tr>
                        </tbody>';
                $output .= '</table>';
            }else{
                $output .= 'Not found';                    
            }
            echo $output;
        }else{
            redirect('User');
        }
    }
    public function bulkUploadView(){
        if(is_logged_in()){            
            $userrole = $this->session->userdata['userrole'];
            if($userrole == 'School User'){ 
                $censusId = $this->session->userdata['census_id'];
                $schoolGrades = $this->SchoolClass_model->get_school_grades_by_census_id($censusId); 
            }
            $data['title'] = 'Students Bulk Upload';
            $data['schoolGrades'] = $schoolGrades;
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'student/studentBulkUpload';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } 
    // view students classes page  
    public function viewStudentsInClasses(){
        if(is_logged_in()){   
            $userrole = $this->session->userdata['userrole'];
            if($userrole == 'School User'){ 
                $censusId = $this->session->userdata['census_id'];
                $year = date('Y');
                $schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId,$year); 
                $gradeId = $this->input->post('select_grade_of_stu');
            }else{
                $allSchools = $this->School_model->view_all_schools(); 
                $data['allSchools'] = $allSchools;
                $schoolGrades = '';
            }
            $data['title'] = 'Students In Classes';
            $data['schoolGrades'] = $schoolGrades;
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'student/studentsInClasses';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // view students class wise when select grade and year. used in above view (studentsInClasses)
    public function StudentsInClasses(){
        if(is_logged_in()){
            if ($this->input->post('show_classes_with_students_button') == "Show"){
                $this->form_validation->set_rules("select_year","Year","required|numeric");
                $this->form_validation->set_rules("select_grade_of_stu","Grade","required");
                if ($this->form_validation->run() == false){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Please select Year and Grade!','class' => 'alert alert-danger'));
                    redirect('Student/viewStudentsInClasses');
                    //$this->bulkUploadView();
                }else{
                    $userrole = $this->session->userdata['userrole'];
                    $year = $this->input->post('select_year');
                    if($userrole == 'School User'){ 
                        $censusId = $this->session->userdata['census_id'];
                        $schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId,$year); 
                    }else{
                        $censusId= $this->input->post('school_select');
                        $schoolGrades = '';
                    }
                    $gradeId= $this->input->post('select_grade_of_stu');
                    $condition = 'sgct.grade_id = '.$gradeId.' and sgct.census_id ='.$censusId.' and sgct.year ='.$year;
                    $classes = $this->SchoolClass_model->get_classes_grade_wise($condition);   
                    if(!empty($classes)){
                        $data['schoolGrades'] = $schoolGrades;
                        $data['classes'] = $classes;
                        $data['title'] = 'Students in Classes';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'student/studentsInClasses';
                        $this->load->view('templates/user_template', $data); 
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'No classes found for '.$censusId. ' in '.$year.'!!!','class' => 'alert alert-danger'));
                        redirect('Student/viewStudentsInClasses');
                    }
                }
            }else{
                redirect('Student/viewStudentsInClasses');
            }
        }else{ 
            redirect('GeneralInfo/loginPage');
        }
    }
    // delete student temporarily using ajax in student -> index view
    // but not physically deleted. is_deleted is updated to 1, used by school user
    public function deleteStudent(){
        if(is_logged_in()){
            $stId =  $this->input->post('sid');
            $stInfo = $this->Student_model->get_stu_info($stId);
            foreach ($stInfo as $student) {
                $indexNo = $student->index_no;
                $censusId = $student->census_id;
            }
            $marksExist = $this->Marks_model->check_marks_of_a_student_exist($indexNo, $censusId);
            if($marksExist){ // if marks of this student exist 
                echo '1'; // error msg in view - Marks exist, cant delete
            }else{

                $now = date('Y-m-d H:i:s');
                $stPersonaldata = array(
                    'st_id' => $stId,
                    'date_updated' => $now,
                    'is_deleted' => 1,
                );

                $year = date('Y');
                $stGrClData = array(
                    'index_no' => $indexNo,
                    'census_id' => $censusId,
                    'year' => $year,
                    'date_updated' => $now,
                    'is_deleted' => 1,
                ); 

                $deleteStPersonaldata = $this->Student_model->update_student_personal_info($stPersonaldata);
                $deleteStGrClData = $this->Student_model->delete_student_grade_class($stGrClData);
                
                if($deleteStPersonaldata){
                    echo '2'; // success msg
                }else{
                    echo '3'; // eror msg
                }
            }
        }else{
            redirect('Login');
        }
    } 
    // used by admin to remove a student from the system physically
    public function removeStudent(){
        if(is_logged_in()){
            $stId =  $this->input->post('sid');   
            $stInfo = $this->Student_model->get_stu_info($stId);
            foreach ($stInfo as $student) {
                $indexNo = $student->index_no;
                $censusId = $student->census_id;
            }
            $marksExist = $this->Marks_model->check_marks_of_a_student_exist($indexNo, $censusId);
            if($marksExist){ // if marks of this student exist 
                echo '1'; // error msg in view - Marks exist, cant delete
            }else{
                $result = $this->Student_model->delete_student($stId);
                if($result){
                    echo '2';
                }else{
                    echo '3';
                }
            }
        }else{
            redirect('Login');
        }
    } 
    // delete all students from a class using ajax in studentsInClasses view
    public function deleteAllStudentsInAClass(){
        if(is_logged_in()){
            $gradeId = $this->input->post('grade_id_hidden');
            $classId = $this->input->post('class_id_hidden');
            $year = $this->input->post('year_hidden');
            $censusId = $this->input->post('census_id_hidden');
            if(!empty($gradeId) && !empty($classId) && !empty($year) && !empty($censusId)){
                $this->load->model('Marks_model');
                // confirmed whether marks are available in this class.
                $marksFinalized = $this->Marks_model->check_marks_completed_in_a_class($censusId,$gradeId,$classId,$year);
                if(!$marksFinalized){ // if no marks
                    $result = $this->Student_model->delete_all_students_from_class($gradeId, $classId, $year, $censusId); 
                    if($result){
                        echo '1'; // deleted
                    }else{
                        echo '0'; // not deleted
                    }
                }else{
                    // if marks are there, can not delete the class
                    echo '2'; // No permission since marks confirmed
                }
                
            }else{
                echo '3'; // empty fields
            }
        }else{
            redirect('Login');
        }
    }
    // display find inactive students page
    // used by school user and admin
    public function viewInactiveStudents(){
        if(is_logged_in()){
            $userrole_id = $this->session->userdata['userrole_id'];
            if($userrole_id != '2'){
                $censusId = $this->input->post('school_select');
                $allSchools = $this->School_model->view_all_schools(); 
                $data['allSchools'] = $allSchools;
            }else{ // school user
                $censusId = $this->session->userdata['census_id'];               
            }
            $allInactiveStudents = $this->Student_model->get_inactive_students($censusId); 
            $data['allInactiveStudents'] = $allInactiveStudents; 
            $data['title'] = 'Inactive Students';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'student/findInactiveStudents';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // Activate student by admin or school user
    public function activateStudent(){
        if(is_logged_in()){
            $userrole_id = $this->session->userdata['userrole_id'];
            if($userrole_id != '2'){
                $censusId = $this->input->post('school_select');
                $allSchools = $this->School_model->view_all_schools(); 
                $data['allSchools'] = $allSchools;
            }else{ // school user
                $censusId = $this->session->userdata['census_id'];               
            }
            $stId = $this->input->post('st_id_hidden');
            $now = date('Y-m-d H:i:s');
            $stPersonaldata = array(
                'st_id' => $stId,
                'date_updated' => $now,
                'is_deleted' => 0,
            );  
            $result = $this->Student_model->update_student_personal_info($stPersonaldata);
            if($result){
                $this->session->set_flashdata('stActivateMsg', array('text' => 'Student activated successfully','class' => 'alert alert-success'));
            }else{
                $this->session->set_flashdata('stActivateMsg', array('text' => 'Student activation failed!!!','class' => 'alert alert-danger'));
            }
            redirect('Student/viewInactiveStudents');
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // view student reports generating page. can search students gender, status, religion wise..... and print to excel
    public function studentReportsView(){ 
        if(is_logged_in()){
            if($this->userrole_id == '2'){ // school user
                //$censusId = $this->session->userdata['census_id'];
                $std_all_info = $this->Student_model->get_all_students_for_report($genderId='', $religionId='', $ethnicGroupId='', $statusid='', $this->censusId);
                $data['std_all_info'] = $std_all_info;
            }else{
                $censusId = '';
                $data['std_all_info'] = '';
            }
            $data['title'] = 'Students Report';
            if($this->userrole_id == '3'){ // zonal user
                $data['user_header'] = 'user_zeo_header';
            }elseif($this->userrole_id == '5'){ // zonal director
                $data['user_header'] = 'user_zonal_director_header';
            }elseif($this->userrole_id == '7'){ // edu. divisional user
                $data['user_header'] = 'user_edu_division_header';
            }elseif($this->userrole_id == '8'){ // zonal file user
                $data['user_header'] = 'user_zonal_file_header';
            }elseif($this->userrole_id == '9'){ // zonal salary user
                $data['user_header'] = 'user_zonal_salary_header';
            }else{
                $data['user_header'] = 'user_admin_header';
            }
            $data['user_content'] = 'student/student_reports';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }
    }
    public function findStudentsForReports(){
        if( is_logged_in() && $this->input->post('std_search_btn') == "View" ){
            // logged user is checked in the model - ex- devision, school
            if( $this->userrole_id != '2' ){
                $censusId = $this->input->post('census_id_hidden');
            }else{
                $censusId = $this->censusId;
            }
            //die();
            $admNo = $this->input->post('index_no_txt');
            $genderId = $this->input->post('gender_select');
            $religionId = $this->input->post('religion_select');
            $ethnicGroupId = $this->input->post('ethnic_group_select');
            $statusid = $this->input->post('status_select');
            // below $censusId is set in the construct method if the logged user is school, else it must be selected by the other users
            if( empty($censusId) && empty($admNo) && empty($genderId) && empty($religionId) && empty($ethnicGroupId) && empty($statusid) ){
                $this->session->set_flashdata('msg', array('text' => 'No fields selected!','class' => 'alert alert-danger'));
                redirect('Student/studentReportsView');
                die();                    
            }else{
                $std_all_info = $this->Student_model->get_all_students_for_report( $genderId, $religionId, $ethnicGroupId, $statusid, $censusId );
                //print_r($std_all_info);
                if( empty( $std_all_info ) ){
                    $this->session->set_flashdata('msg', array('text' => 'No records found!','class' => 'alert alert-danger'));
                    redirect('Student/studentReportsView');
                    die();
                }else{
                    $data['std_all_info'] = $std_all_info;
                }
            }
            if( !empty( $admNo ) ){
                if( empty($censusId) ){ // censusId is set above
                    $this->session->set_flashdata('msg', array('text' => 'School is required!','class' => 'alert alert-danger'));
                    redirect('Student/studentReportsView');
                    die();
                }
                $this->form_validation->set_rules("index_no_txt","Index Number","trim|required|min_length[4]|max_length[5]|numeric");
                if ( $this->form_validation->run() == FALSE ){
                    //echo $censusId; die();
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Admission Number is not correct!','class' => 'alert alert-danger'));
                    redirect('Student/studentReportsView');
                    die();
                }else{
                    //$condition = 'st.census_id="'.$censusId.'" and st.index_no="'.$admNo.'"';
                    $std_info = $this->Student_model->get_stu_info_by_index( $admNo, $censusId );
                    $std_co_cur_info = $this->Student_model->get_std_ex_cur_info( $admNo, $censusId );
                    $std_ex_cur_info = $this->Student_model->get_std_game_info( $admNo, $censusId );
                    $std_win_info = $this->Student_model->get_std_winnings( $admNo, $censusId );
                    if( empty($std_info) ){
                        $this->session->set_flashdata('msg', array('text' => 'No student found!','class' => 'alert alert-danger'));
                        redirect('Student/studentReportsView');
                        die();
                    }else{
                        $data['std_info'] = $std_info;
                        $data['std_co_cur_info'] = $std_co_cur_info;
                        $data['std_ex_cur_info'] = $std_ex_cur_info;
                        $data['std_win_info'] = $std_win_info;
                    }
                }
            }
            
            if($this->userrole_id == '3'){ // zonal user
                $data['user_header'] = 'user_zeo_header';
            }elseif($this->userrole_id == '5'){ // zonal director
                $data['user_header'] = 'user_zonal_director_header';
            }elseif($this->userrole_id == '7'){ // edu. divisional user
                $data['user_header'] = 'user_edu_division_header';
            }elseif($this->userrole_id == '8'){ // zonal file user
                $data['user_header'] = 'user_zonal_file_header';
            }elseif($this->userrole_id == '9'){ // zonal salary user
                $data['user_header'] = 'user_zonal_salary_header';
            }else{
                $data['user_header'] = 'user_admin_header';
            }
            $data['title'] = 'Students Report';
            if ( !empty( $std_info ) ) {
                $data['user_content'] = 'student/student_info_by_index';
            }else{
                $data['user_content'] = 'student/student_reports';
            }

            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }
    }
    // this method view student update page by school user and admin
    public function AdmNumberChangeView(){ // this is used by school user
        if( is_logged_in() ){
            $data['title'] = 'Change Student Admission Number';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'student/changeAdmNo';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }
    }
    public function changeAdmNo(){
        if(is_logged_in()){
            if ( $this->input->post('btn_change_adm_no') == "Change" ){
                $curAdmNo = $this->input->post('cur_adm_no_txt'); 
                $newAdmNo = $this->input->post('new_adm_no_txt'); 
                $censusId = $this->input->post('census_id_hidden'); 
                //$this->form_validation->set_rules("index_no_txt","Admission Number","trim|required");   
                $this->form_validation->set_rules("cur_adm_no_txt","Old admission number","required|numeric|min_length[4]|max_length[5]");   
                $this->form_validation->set_rules("new_adm_no_txt","New admission number","required|numeric|min_length[4]|max_length[5]");  
                if ( $this->form_validation->run() == FALSE ){
                    //validation fails
                    //redirect('Student/AdmNumberChangeView'); 
                    $this->AdmNumberChangeView();
                }elseif( $this->Student_model->check_student_exist( $newAdmNo, $censusId ) ){
                    $this->session->set_flashdata('msg', array('text' => $newAdmNo.' already exists!','class' => 'alert alert-danger'));
                    $this->AdmNumberChangeView();
                }else{       
                    $result = $this->Student_model->change_std_adm_no( $censusId, $curAdmNo, $newAdmNo );
                    if( $result ){
                        $this->session->set_flashdata('msg', array('text' => 'Admission number changed successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'Error!!!','class' => 'alert alert-danger','update'=>'false'));
                    }
                    //$stId and $indexNo both needed to go back. bcz $indexNo is foreign key of other tables
                    $this->AdmNumberChangeView();
                }
            }else{
                $this->index();
            }
        }else{
            redirect('User');
        }
    }
}