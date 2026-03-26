<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marks extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('School_model');
        $this->load->model('SchoolClass_model');
        $this->load->model('Subject_model');
        $this->load->model('Grade_model');
        $this->load->model('Class_model');
        $this->load->model('Marks_model');
        $this->load->model('Student_model');
        $this->load->model('Common_model');
        $this->load->library("excel/Excel");
        if(is_logged_in()){
            $this->userRole = $this->session->userdata['userrole'];
            $this->userRoleId = $this->session->userdata['userrole_id'];
        }else{
            echo 'Please log in to the system!!!';
        }
        //$this->all_subjects = $this->view_all_subjects();
    }
    // view marks insertion and viewing page
    public function index(){
        if(is_logged_in()){
            if( $this->userRoleId != '2' ){
                $allSchools = $this->School_model->view_all_schools(); 
                $allGrades = $this->Grade_model->view_all_grades();
                $data['allSchools'] = $allSchools;
            }
            if( $this->userRoleId == 3 ){
                $data['user_header'] = 'user_zeo_header';
            }elseif( $this->userRoleId == 7 ){
                $data['user_header'] = 'user_edu_division_header';
                $eduDivId = $this->session->userdata['div_id'];
                $allSchools = $this->Common_model->get_all_schools($eduDivId);
                $data['allSchools'] = $allSchools;
            }else{
                $data['user_header'] = 'user_admin_header';
            }
            $data['title'] = 'Student Marks';
            $data['user_content'] = 'marks/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    function viewAddedMarks(){ // used when user search marks
        if(is_logged_in()){ 
            if(empty($_POST['census_id']) || empty($_POST['year']) || empty($_POST['term']) || empty($_POST['grade_id']) || empty($_POST['class_id'])){
                $output = 'Year, Term, Grade and Class are Needed!!!';
            }else{
                $censusId = $_POST['census_id'];
                $year = $_POST['year'];
                $term = $_POST['term'];
                $gradeId = $_POST['grade_id']; 
                $classId = $_POST['class_id'];
                $marks = $this->Marks_model->get_marks($censusId, $year, $term, $gradeId, $classId);
                $all_subjects = $this->Marks_model->select_subjects($censusId,$gradeId,$year);
                $subj_count = $this->Marks_model->count_subjects($censusId,$gradeId,$year); // used to iterate
                $gradeName = $this->Grade_model->get_grade_name($gradeId);
                $className = $this->Class_model->get_class_name($classId);
                //print_r($marks); //die();
                if(!empty($marks)){
                    $latest_upd_dt = 0;
                    foreach ($marks as $mark) {
                        if($latest_upd_dt < $mark->marks_last_update){
                            $latest_upd_dt = $mark->marks_last_update;
                        }
                    }
                    $latest_upd_dt = strtotime($latest_upd_dt);
                    $marks_update_dt = date("j F Y",$latest_upd_dt);
                    $marks_update_tm = date("h:i A",$latest_upd_dt);
                    $dt = 'Updated on '.$marks_update_dt.' at '.$marks_update_tm;
                    //print_r($marks); die();
                    // following jquery function used to make the html table to a datatable. Otherwise its not working in the view
                    $output = '
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#dataTable1").DataTable({
                                dom: "Bfrtip",
                                buttons: [
                                  {
                                    extend: "excel",
                                    text: "Save",
                                    exportOptions: {
                                        modifier: {
                                            page: "All"
                                        }
                                    }
                                  }
                                ],  
                                fixedColumns: {
                                  leftColumns:1
                                }
                            });
                            $("#updated_dt_span").text("'.$dt.'");
                        });
                    </script>
                    <style type="text/css">
                        th span{ 
                            color:blue; 
                            writing-mode: vertical-lr;
                            transform: rotate(180deg);
                            vertical-align: center;
                            min-width: 20px;
                            max-height: auto;
                            white-space: nowrap; 
                        }
                        // when give word wrap to column header, the following line is overridden
                        th, td { white-space: nowrap; }
                    </style>
                    <h6 align="center">Term Test '.$term.' Marks '.$year.' - '.$gradeName.' '.$className.' </h6>
                    <div class="table-responsive">
                    <table id="dataTable1" class="table table-striped table-bordered table-hover" >
                        <thead>
                        <tr>
                            <th><span>ඇ. වීමේ අංකය </span></th>
                            <th style=""><span> නම </span></th>
                        ';
                        foreach($all_subjects as $row){
                            if($row->sub_cat_id==2){
                                $subj_name = 'OP1_'.$row->subject;
                            }elseif($row->sub_cat_id==3){
                                $subj_name = 'OP2_'.$row->subject;
                            }elseif($row->sub_cat_id==4){
                                $subj_name = 'OP3_'.$row->subject;
                            }else{
                                $subj_name = $row->subject; // sub_cat_id=1 is Main subject
                            }
                            $output .= '<th><span>'.$subj_name.'</span></th>';
                        } // foreach($subjects as $row){
                        $output .= '<th scope="col" class="col-sm-1"><span> එකතුව</span> </th><th scope="col" class="col-sm-1"><span> සාමාන්‍ය </span></th></tr></thead><tbody>'; // end of first row - column names
                        $last_order_id = 1; // first time $last_subj_id default value. this is used to print <td> html tag
                        $previousAdmNo = '';
                        foreach ($marks as $marks){ 
                            $admNo = $marks->adm_no; // this variable used in below codes
                            $nameWithIni = $marks->name_with_initials;
                            $current_order_id = $marks->order_id; 
                            $mark = $marks->marks;
                            $marks_sub_cat_id = $marks->sub_cat_id;  // subject categories are op1,op2,op3,main.....
                            if($marks->adm_no == $previousAdmNo){ // student is checked
                                //$current_subj_id = $marks->subj_id;
                                for ($i=$last_order_id; $i < $current_order_id; $i++) { 
                                    $output .= '<td class="emptyTd">'.'</td>'; // set empty <td> tags
                                    // example 
                                    // if $i=6 and $marks->subj_id=9, there must be two empty <td> before marks <td> of subject_id=9 
                                } 
                                foreach ($all_subjects as $subject){ 
                                    if(($subject->sub_cat_id == $marks_sub_cat_id) && ($subject->subject_id == $marks->subj_id)){
                                        $ci = & get_instance();
                                        $ci->load->model('Marks_model');
                                        // check whether the student is absent for this subject
                                        $absent = $ci->Marks_model->check_term_test_absent($censusId,$year,$term,$admNo,$marks->subj_id);
                                        if($absent){ // if absent print AB
                                            $output .= '<td align="center" style="vertical-align:middle;color:#ffaacd;"> AB'.'</td>';
                                        }else{ // if not absent print marks
                                            $output .= '<td style="vertical-align:middle" align="center">'.$mark.'</td>';
                                        }
                                    }
                                }
                                $last_order_id = $current_order_id + 1;  
                            }else{ // if($admNo != $previousAdmNo){ // student is checked
                                // complete the last <td> tags of a table row
                                if( $last_order_id != $current_order_id ){
                                    for ( $a=$last_order_id; $a <= $subj_count+2; $a++ ) { 
                                        if( $a==$subj_count+1 ){ // if it is total cell
                                            $ci = & get_instance();
                                            $ci->load->model('Marks_model');
                                            $results = $ci->Marks_model->get_term_test_results($censusId,$year,$term,$previousAdmNo);
                                            //print_r($results); 
                                            if( $results ){
                                                foreach ( $results as $result ) {
                                                    if($previousAdmNo==$result->index_no){
                                                        $output .= '<td style="vertical-align:middle">'.$result->total.'</td>'; 
                                                        break;
                                                    }else{
                                                        $output .= '<td></td>'; 
                                                    }
                                                }
                                            }else{
                                                $output .= '<td></td>'; 
                                            }
                                            
                                        }elseif($a==$subj_count+2) { // if it is average cell
                                            $ci = & get_instance();
                                            $ci->load->model('Marks_model');
                                            $results = $ci->Marks_model->get_term_test_results($censusId,$year,$term,$previousAdmNo);
                                            //print_r($results);
                                            if($results){
                                                foreach ($results as $result) {
                                                    if($previousAdmNo==$result->index_no){
                                                        $output .= '<td style="vertical-align:middle">'.$result->average.'</td>'; 
                                                        break;
                                                    }else{
                                                        $output .= '<td></td>'; 
                                                    }
                                                }
                                            }else{
                                                $output .= '<td></td>'; 
                                            }
                                        }else{ // empty cells to complete the row.
                                            $output .= '<td></td>'; 
                                        }
                                    }
                                }
                                $output .= '</tr>'; 
                                $output .= '<td style="vertical-align:middle">'.$admNo.'</td>';
                                $output .= '<td style="vertical-align:middle;width:400px;">'.$nameWithIni.'</td>';
                                $last_order_id = 1; // from the first mark of a new student
                                for ($i=$last_order_id; $i < $current_order_id; $i++) { 
                                    $output .= '<td>'.'</td>'; // set empty <td> tags
                                    // example 
                                    // if $i=6 and $marks->subj_id=9, there must be two empty <td> before marks <td> of subject_id=9 
                                } 
                                foreach ($all_subjects as $subject){ 
                                    if(($subject->sub_cat_id == $marks_sub_cat_id) && ($subject->subject_id == $marks->subj_id)){
                                        $ci = & get_instance();
                                        $ci->load->model('Marks_model');
                                        // check whether the student is absent for this subject
                                        $absent = $ci->Marks_model->check_term_test_absent($censusId,$year,$term,$admNo,$marks->subj_id);
                                        if($absent){ // if absent print AB
                                            $output .= '<td align="center" style="ertical-align:middle;color:#ffaacd;"> AB-'.' </td>';
                                        }else{ // if not absent print marks
                                            $output .= '<td style="vertical-align:middle" align="center">'.$mark.'</td>';
                                        }
                                    }
                                }
                                $last_order_id = $current_order_id+1; 
                            } // student is checked
                            $previousAdmNo = $admNo;
                        } // foreach ($marks as $mark){
                        // complete the last <td> tags of a table row. This is used to complete the last <tr> of the table (last students total and average)
                        if($last_order_id != $current_order_id){
                            for ($a=$last_order_id; $a <= $subj_count+2; $a++) { 
                                if($a==$subj_count+1){ // if it is total cell
                                    $ci = & get_instance();
                                    $ci->load->model('Marks_model');
                                    $results1 = $ci->Marks_model->get_term_test_results($censusId,$year,$term,$previousAdmNo);
                                    //print_r($results1);
                                    if($results1){
                                        foreach ($results1 as $results1) {
                                            if($previousAdmNo==$results1->index_no){
                                                $output .= '<td style="vertical-align:middle">'.$results1->total.'</td>'; 
                                                break;
                                            }else{
                                                $output .= '<td></td>'; 
                                            }
                                        }
                                    }else{
                                        $output .= '<td></td>'; 
                                    }
                                }else if ($a==$subj_count+2) { // if it is average cell
                                    $ci = & get_instance();
                                    $ci->load->model('Marks_model');
                                    $results2 = $ci->Marks_model->get_term_test_results($censusId,$year,$term,$previousAdmNo);
                                    if($results2){
                                        foreach ($results2 as $results2) {
                                            if($previousAdmNo==$results2->index_no){
                                                $output .= '<td style="vertical-align:middle">'.$results2->average.'</td>'; 
                                                break;
                                            }else{
                                                $output .= '<td></td>'; 
                                            }
                                        }
                                    }else{
                                        $output .= '<td></td>'; 
                                    }
                                }else{ // empty cells to complete the row.
                                    $output .= '<td></td>'; 
                                }
                            }   // for ($a=$last_order_id; $a <= $subj_count+2; $a++) { 
                        }   // if($last_order_id != $current_order_id){
                    //$output .= '<tr><td colspan="'.($subj_count+4).'">'.$dt.'</td></tr>';
                    $output .= '</tbody></table></div>';
                }else{    // if(!empty($marks)){
                    $all_subjects = $this->Marks_model->select_subjects($censusId,$gradeId,$year);
                    if(empty($all_subjects)){
                        $output = '
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $("#updated_dt_span").text("No marks found!!!"); 
                                })
                            </script>';
                        $output .= "No subjects assigned to this class";
                    }else{ // if subjects available
                        $output = '
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $("#dataTable1").DataTable({
                                        dom: "Bfrtip",
                                        buttons: [
                                        {
                                            extend: "excel",
                                            text: "Save",
                                            exportOptions: {
                                                modifier: {
                                                    page: "All"
                                                }
                                            }
                                        }
                                        ],  
                                        fixedColumns: {
                                        leftColumns:1
                                        }
                                    });
                                    $("#updated_dt_span").text("No marks found!!!");
                                });
                            </script>
                            <style type="text/css">
                                th span{ 
                                    color:blue; 
                                    writing-mode: vertical-lr;
                                    transform: rotate(180deg);
                                    vertical-align: center;
                                    min-width: 20px;
                                    max-height: auto;
                                    white-space: nowrap; 
                                }
                                // when give word wrap to column header, the following line is overridden
                                th, td { white-space: nowrap; }
                            </style>
                            <h6 align="center">Term Test '.$term.' Marks '.$year.' - '.$gradeName.' '.$className.' </h6>
                            <table id="dataTable1" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th scope="col" class="col-sm-1"><span>ඇ. වීමේ අංකය</span> </th>
                                    <th scope="col" class="col-sm-1"><span> නම </span></th>
                                ';
                                foreach($all_subjects as $row){
                                    if($row->sub_cat_id==2){
                                        $subj_name = 'OP1_'.$row->subject;
                                    }elseif($row->sub_cat_id==3){
                                        $subj_name = 'OP2_'.$row->subject;
                                    }elseif($row->sub_cat_id==4){
                                        $subj_name = 'OP3_'.$row->subject;
                                    }else{
                                        $subj_name = $row->subject; // sub_cat_id=1 is Main subject
                                    }
                                    $output .= '<th scope="col" class="col-sm-1"><span>'.$subj_name.'</span></th>';
                                } // foreach($subjects as $row){
                                $output .= '</tr></thead><tbody>'; // end of first row - subject names
                                $studentsInClass = $this->Student_model->get_students_in_a_class($censusId, $gradeId, $classId, $year);
                                //print_r($studentsInClass); die();
                                if(!empty($studentsInClass)){
                                    foreach ($studentsInClass as $student){ 
                                        $output .= '<tr><th>'.$student->index_no.'</th>'; 
                                        $output .= '<td>'.$student->name_with_initials.'</td>'; 
                                        for ($a=1; $a <= $subj_count; $a++) { 
                                            $output .= '<td></td>'; 
                                        }
                                    }
                                    $output .= '</tr>'; 
                                }
                        $output .= '</tbody></table>';
                    } // if(empty($all_subjects)){
                } // if(!empty($marks)){
            } //   if(empty($censusId) || empty($year) || empty($term) || empty($gradeId) || empty($classId)){
            echo $output;
        }
        //die();
    } // function fetch()
    // uploaded file validation. only excel files are allowed
    public function file_check($str){
        $allowed_mime_type_arr = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel');
        $mime = get_mime_by_extension($_FILES["file"]['name']);
        if(isset($_FILES["file"]['name']) && $_FILES["file"]['name']!=""){
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
    function import(){
        if(is_logged_in()){
            $this->load->helper('file');  // used to validate excel file type

            if($this->userRole == 'System Administrator'){
                $censusId = $this->input->post('school_select'); // school census id
            }else if($this->userRole == 'School User'){
                $censusId = $this->input->post('census_id_hidden'); // school census id
            }
            $classId = $this->input->post('class_select'); // select class of the students
            $gradeId = $this->input->post('grade_select');
            $year = $this->input->post('year_select'); // select academic year of the student
            $term = $this->input->post('term_select'); // select academic year of the student

            if(isset($_FILES["file"]["name"])){
                $this->form_validation->set_rules('file', '', 'callback_file_check');
                if($this->form_validation->run() == false){
                    echo 'Incorrect file type!!!'; 
                    die();
                }else{ 
                    $this->load->model('Marks_model');
                    // check whether marks confirmation is available to this class.
                    if($this->Marks_model->check_marks_completed_in_a_class($censusId,$gradeId,$classId,$year,$term)){ // if marks confirmed
                        echo 'Can not perform this since marks has already been finalized!!!';
                    }else{ // if marks not confirmed yet
                        $path = $_FILES["file"]["tmp_name"];
                        $object = PHPExcel_IOFactory::load($path);
                        // excel sheet validating part
                        foreach($object->getWorksheetIterator() as $worksheet){
                            $highestColumn = $worksheet->getHighestColumn(); // highest column name ex- 'AB'
                            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // highest column index no
                            $noOfSubjectColumns = $highestColumnIndex-1; // remove last column (it is empty)
                            for($col=2; $col<=$noOfSubjectColumns; $col++){
                                $subjName = $worksheet->getCellByColumnAndRow($col, 1)->getValue(); // get subject name from excel
                                //echo $subjName.'---';
                                if(empty($subjName)){
                                    echo 'Subject column is empty!!!';
                                    die();
                                }
                                $subjName = explode('_', $subjName);
                                if(isset($subjName[1])){
                                    $subjName = $subjName[1];
                                }else{
                                    $subjName = $subjName[0];
                                }
                                //select the grade
                                $sectionId = $this->Grade_model->get_section_of_a_grade($gradeId);
                                // first find the id of subject by its name and section from main subject table
                                $subject = $this->Marks_model->selectSubjectIdBySubjectName($subjName,$sectionId);
                                //print_r($subject); die();
                                if(!$subject){ // if subject name not found in the system
                                    echo $subjName.' not exist in the system!!!';
                                    die();
                                }else{
                                    foreach ($subject as $row) {
                                        $subjectId = $row->subject_id; 
                                    }
                                    $year = $this->input->post('year_select'); // select academic year of the student
                                    $term = $this->input->post('term_select'); // select academic year of the student
                                    //die();
                                    // check subjects are already assigned to the grade 
                                    $subjectAssignedToGrade = $this->Marks_model->check_subject_exist_in_grade($censusId,$gradeId,$subjectId,$year);
                                    if(!$subjectAssignedToGrade){
                                        echo $subjName.' not selected to this grade!!!'; 
                                        die();
                                    }  
                                }
                                
                            }
                            //die();
                            // following codes are used to check students exists 
                            $highestRow = $worksheet->getHighestRow(); 
                            $studentsNotExistsArray = [];
                            $classId = $this->input->post('class_select');
                            $x=1;
                            for($row=2; $row<=$highestRow; $row++){
                                if($worksheet->getCellByColumnAndRow(0, $row)->getValue()){
                                    $indexNo = $worksheet->getCellByColumnAndRow(0, $row)->getValue(); // get adm_no from excel
                                    $x = $x + 1;
                                }else{
                                    echo 'An admission number is empty!!!';
                                    die();
                                }
                                if(($indexNo==NULL) || ($indexNo==0) || ($indexNo=='')){
                                    echo 'Admission Number '.$x.' is empty!!!';
                                    die();
                                }
                                $nameWithIni = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                                $studentExists = $this->Marks_model->check_student_exist_in_Class($indexNo,$gradeId,$classId,$censusId); 
                                if(!$studentExists){
                                    $studentsNotExistsArray[$row]['adm_no'] = $indexNo;
                                    $studentsNotExistsArray[$row]['stu_name'] = $nameWithIni;   
                                }

                            }
                            //die();
                            //print_r($studentsNotExistsArray); die();
                            if(!empty($studentsNotExistsArray)){
                                foreach ($studentsNotExistsArray as $student) {
                                    echo nl2br($student['adm_no'].'-'.$student['stu_name']).', ';
                                }
                                echo ' not in this class';
                                die();
                            }
                            //die();
                            // following codes used to count op subjects in excel sheet
                            $highestRow = $worksheet->getHighestRow(); //die();
                            for($row=2; $row<=$highestRow; $row++){
                                $op1_count = 0;
                                $op2_count = 0;
                                $op3_count = 0;
                                if($worksheet->getCellByColumnAndRow(0, $row)->getValue()){
                                    $admNo = $worksheet->getCellByColumnAndRow(0, $row)->getValue(); // get adm_no from excel
                                    $highestColumn = $worksheet->getHighestColumn(); // highest column name ex- 'AB'
                                    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // highest column index no ex- 'AB' = 27, 'A' = 1
                                    $noOfSubjectColumns = $highestColumnIndex-1; // remove last column (it is empty)
                                    // for loop is iterated upto value of $noOfColumns 
                                    for($col=2; $col<=$noOfSubjectColumns; $col++){
                                        $subjName = $worksheet->getCellByColumnAndRow($col, 1)->getValue(); // get subject name
                                        if(!empty($subjName)){
                                            // only the cells with marks are taken. empty cells are ignored below
                                            if(!empty($worksheet->getCellByColumnAndRow($col, $row)->getValue())){ // empty cells are ignored
                                                //$subjName = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
                                                $subjName = explode('_', $subjName);
                                                //echo $subjName[0];
                                                if(isset($subjName[0])){
                                                    $op_prefix = $subjName[0];
                                                    if($op_prefix=='OP1'){
                                                        $op1_count += 1;
                                                    }
                                                    if($op_prefix=='OP2'){
                                                        $op2_count += 1;
                                                    }
                                                    if($op_prefix=='OP3'){
                                                        $op3_count += 1;
                                                    }
                                                }
                                            }
                                        }
                                    } // for($col=2; $col<=$noOfColumns; $col++){
                                    if($op1_count>1){
                                        echo 'More than one OP1 subjects with '.$admNo.' student!!!!!!';
                                        die();  
                                    }
                                    if($op2_count>1){
                                        echo 'More than one OP2 subjects with '.$admNo.' student!!!!!!';
                                        die();  
                                    }
                                    if($op3_count>1){
                                        echo 'More than one OP3 subjects with '.$admNo.' student!!!!!!';
                                        die();  
                                    }
                                } // if     
                            } // for($row=2; $row<=$highestRow; $row++){
                            // following codes are used to marks count for a student 
                        }
                        // counting number of marks of one student
                        if($gradeId==10 || $gradeId==11){
                            $y=9; // nine subjects
                        }else{ 
                            $y=12; // twelve subjects
                        }
                        // counting number of marks of one student
                        foreach($object->getWorksheetIterator() as $worksheet){           
                            for($row=2; $row<=$highestRow; $row++){
                                $admNo = $worksheet->getCellByColumnAndRow(0, $row)->getValue(); // get adm_no from excel
                                $nameWithIni = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                                $highestRow = $worksheet->getHighestRow();
                                $highestColumn = $worksheet->getHighestColumn(); // highest column name ex- 'AB'
                                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // get index no of highest column with data
                                $noOfSubjectColumns = $highestColumnIndex-1; // remove last column (it is empty)
                                $z = 0;
                                // for loop is iterated upto value of $noOfSubjectColumns
                                for($col=2; $col<=$noOfSubjectColumns; $col++){
                                    // here $col=2 means third column - Religion and 1 means first row of the worksheet 
                                        // only the cells with marks are taken. empty cells are ignored below
                                        if(!empty($worksheet->getCellByColumnAndRow($col, $row)->getValue())){ // empty cells are ignored
                                            $marks = ( $worksheet->getCellByColumnAndRow($col, $row)->getValue() );
                                            if( $marks>100 || $marks<0 ){
                                                echo $admNo.' has invalid marks!';
                                                die();
                                            }elseif(is_numeric($marks) || $marks=='AB'){
                                                $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue(); 
                                                $z = $z + 1;
                                            }else{
                                                echo $admNo.' has non numeric data!!!';
                                                die();
                                            }
                                        } // check empty cells
                                } // for loop for($col=2; $col<=$noOfSubjectColumns; $col++){
                                if($z<$y){ // only nine or 12 subjects are allowed
                                    echo $marksCountMsg =  $admNo.' has less than '.$y.' subjects';
                                    die();
                                }elseif($z>$y){ 
                                     echo $marksCountMsg = $admNo.' has less than '.$y.' subjects';
                                    die();
                                }
                            } //for($row=2; $row<=$highestRow; $row++)
                        } // foreach($object->getWorksheetIterator() as $worksheet)
                        // get existing students of a class
                        $classId = $this->input->post('class_select'); // select the class
                        $classStudents = $this->Student_model->get_students_in_a_class($censusId,$gradeId,$classId,$year); 
                        //print_r($classStudents); die();
                        // delete term test marks from term test marks table, before insert new excel marks
                        foreach ($classStudents as $student) {
                            $indexNo = $student->index_no;
                            // deleting existing marks of above students
                            $this->Marks_model->delete_student_marks($indexNo,$year,$term,$censusId);
                        }
                        // delete term test marks from term test results (total,average) table, before insert new excel marks
                        foreach ($classStudents as $student) {
                            $indexNo = $student->index_no;
                            // deleting existing results of above students
                            $this->Marks_model->delete_student_term_test_results($indexNo,$year,$term,$censusId);
                        }
                        // delete term test absentees from term test absentees table, before insert new excel marks
                        foreach ($classStudents as $student) {
                            $indexNo = $student->index_no;
                            // deleting existing absentee info of above students
                            $this->Marks_model->delete_term_test_absentees($indexNo,$year,$term,$censusId);
                        }

                        // start adding excel sheet
                        foreach($object->getWorksheetIterator() as $worksheet){ 
                            $noOfStudents = 0;          
                            for($row=2; $row<=$highestRow; $row++){
                                $admNo = $worksheet->getCellByColumnAndRow(0, $row)->getValue(); // get adm_no from excel
                                $nameWithIni = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                                $highestRow = $worksheet->getHighestRow();
                                $highestColumn = $worksheet->getHighestColumn(); // highest column name ex- 'AB'
                                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // get index no of highest column with data
                                $noOfSubjectColumns = $highestColumnIndex-1; // remove last column (it is empty)
                                $total = 0;
                                $average = 0;
                                // for loop is iterated upto value of $noOfSubjectColumns
                                for($col=2; $col<=$noOfSubjectColumns; $col++){
                                    // here $col=2 means third column - Religion and 1 means first row of the worksheet 
                                    $subjName = $worksheet->getCellByColumnAndRow($col, 1)->getValue(); // get subject name
                                    if(!empty($subjName)){
                                        // only the cells with marks are taken. empty cells are ignored below
                                        if(!empty($worksheet->getCellByColumnAndRow($col, $row)->getValue())){ // empty cells are ignored
                                            //$subjName = $worksheet->getCellByColumnAndRow($col, 1)->getValue();
                                            $subjNameArray = explode('_', $subjName);
                                            if(isset($subjNameArray[1])){
                                                $subjName = $subjNameArray[1];
                                            }else{
                                                $subjName = $subjNameArray[0];
                                            }
                                            // find the subj_id of given subject name as in excel
                                            $subject = $this->Marks_model->selectSubjectIdBySubjectName($subjName,$sectionId); 

                                            foreach ($subject as $subject) {
                                                $subj_id = $subject->subject_id;
                                            }
                                            $marks = $worksheet->getCellByColumnAndRow($col, $row)->getValue(); 
                                            $total = $total + $marks;
                                            $now = date('Y-m-d H:i:s');

                                            $gradeId = $this->input->post('grade_select');
                                            $year = $this->input->post('year_select'); // select academic year of the student
                                            $term = $this->input->post('term_select');
                                            if($this->userRole == 'System Administrator'){
                                                $censusId = $this->input->post('school_select'); // school census id
                                            }else if($this->userRole == 'School User'){
                                                $censusId = $this->input->post('census_id_hidden'); // school census id
                                            }
                                            $classId = $this->input->post('class_select'); // select class of the students
                                            
                                            // check absentees
                                            if($marks=='AB'){
                                                $absenteeData = [];
                                                $absenteeData[] = array(
                                                    'absent_id' =>  '',
                                                    'index_no'    =>  $admNo,
                                                    'year'      =>  $year,   
                                                    'term'      =>  $term,
                                                    'subj_id'   =>  $subj_id,
                                                    'census_id'     =>  $censusId,
                                                    'date_added'    => $now,
                                                    'date_updated'  => $now
                                                );
                                                // Insert absentees data
                                                if(!empty($absenteeData)){
                                                    $this->Marks_model->insert_term_test_absentee($absenteeData); 
                                                }
                                            }

                                            $data = []; // $data array must be empty when next iteration
                                            $data[] = array(
                                                'st_mrk_id' =>  '',
                                                'index_no'    =>  $admNo,
                                                'year'      =>  $year,   
                                                'term'      =>  $term,
                                                'subj_id'   =>  $subj_id,
                                                'marks'     =>  $marks,
                                                'census_id'     =>  $censusId,
                                                'date_added'    => $now,
                                                'date_updated'  => $now
                                            );
                                            // insert marks to database
                                            if(!$this->Marks_model->insert($data)){
                                                //$recordCount++;
                                                //$msg = $subj_id.'-Data inserted successfully';
                                                echo 'Error in inserting data with '.$admNo.' - '.$subjName.'!!!';
                                                die();
                                            }                                  
                                        } // check empty cells
                                    } //if(!empty($subjName)){
                                } // for loop for($col=2; $col<=$noOfColumns; $col++){
                                if(($gradeId==10) || ($gradeId==11)){
                                    $division = 9;
                                }else{
                                    $division = 12;
                                }
                                // calculating average of one student
                                $average = $total / $division;

                                $data = []; // $data array must be empty for next iteration
                                $data[] = array(
                                    'result_id' =>  '',
                                    'census_id'    =>  $censusId,
                                    'index_no'      =>  $admNo,   
                                    'year'      =>  $year,
                                    'term'   =>  $term,
                                    'total'     =>  $total,
                                    'average'     =>  $average,
                                    'date_added'    => $now,
                                    'date_updated'  => $now
                                );
                                // inserting total and average of one student
                                $this->Marks_model->insert_term_test_result($data);
                                $noOfStudents = $noOfStudents + 1;
                            } //for($row=2; $row<=$highestRow; $row++)
                            echo 'Marks of '.$noOfStudents.' students were inserted successfully';
                        } // foreach($object->getWorksheetIterator() as $worksheet)
                    } // if($this->Marks_model->check_marks_completed_in_a_class($ce
                } // if($this->form_validation->run() == false){
            } // if(isset($_FILES["file"]["name"])){
        }else{ // if not logged in
            echo $output = 'Please log in to system!!!';
        }
    }
    function deleteMarks(){ // used when school user delete marks
        if(is_logged_in() && $this->userRoleId==2){ 
            if(empty($_POST['census_id']) || empty($_POST['year']) || empty($_POST['term']) || empty($_POST['grade_id']) || empty($_POST['class_id'])){
                echo '!!';
                echo (json_encode(array('a' => 'Sorry...', 'b' => 'Year, Term, Grade and Class are Needed!', 'c' => 'warning')));
            }else{
                $censusId = $_POST['census_id'];                
                $gradeId = $_POST['grade_id']; 
                $classId = $_POST['class_id'];
                $year = $_POST['year'];
                $term = $_POST['term']; 
                $classStudents = $this->Student_model->get_students_in_a_class($censusId,$gradeId,$classId,$year); 
                if(!$classStudents){
                    echo (json_encode(array('a' => 'Oops...', 'b' => 'No Students found!', 'c' => 'warning')));
                    die();
                }
                $i=0; // used to count how many marks records exists
                foreach ($classStudents as $student) {
                    $indexNo = $student->index_no;
                    $marksExist = $this->Marks_model->check_marks_exist_in_class($indexNo,$year,$term,$censusId);
                    if($marksExist){ // if marks found
                        $i = $i + 1; // add 1 to $i
                    }
                }
                if($i<1){ // if marks not found
                    echo (json_encode(array('a' => 'Oops...', 'b' => 'No marks found!', 'c' => 'warning')));
                }else{
                    //  check whether marks have been finalized
                    $marksConfirmed = $this->Marks_model->check_marks_completed_in_a_class($censusId,$gradeId,$classId,$year,$term);
                    if(!$marksConfirmed){ // if marks are not finalized
                        foreach ($classStudents as $student) {
                            $indexNo = $student->index_no;
                            // deleting inserted marks of the students in this class
                            $deleteMarks = $this->Marks_model->delete_student_marks($indexNo,$year,$term,$censusId);
                            $deleteResult = $this->Marks_model->delete_student_term_test_results($indexNo,$year,$term,$censusId);
                            $deleteAbsentee = $this->Marks_model->delete_term_test_absentees($indexNo,$year,$term,$censusId);
                        }
                        if($deleteMarks){
                            echo '';
                            echo (json_encode(array('a' => 'Deleted!', 'b' => 'Marks has been deleted', 'c' => 'success')));
                        }else{
                            echo (json_encode(array('a' => 'Oops...!', 'b' => 'Something went wrong!', 'c' => 'warning')));
                        }
                    }else{ // if marks have been finalized
                        echo (json_encode(array('a' => 'Sorry', 'b' => 'Marks have been finalized', 'c' => 'warning')));
                    }
                }                
            }
        }else{
            echo 'You do not have permission to do this task!!!';
        }
    }
    // display marks confirm page
    public function viewMarksConfirm(){
        if(is_logged_in()){
            if($this->userRoleId == '1'){
                $allSchools = $this->School_model->view_all_schools(); 
                //$allGrades = $this->Grade_model->view_all_grades();
                $data['allSchools'] = $allSchools;
                //$data['allGrades'] = $allGrades;
            }elseif($this->userRoleId == '2'){
                $censusId = $this->session->userdata['census_id'];
                //$allGrades = $this->SchoolClass_model->get_school_grades_by_census_id($censusId); 
                //$data['allGrades'] = $allGrades;
            }
            //print_r($allGrades); die(); 
            $data['title'] = 'Confirming Student Marks';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'marks/marksConfirm';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // confirm marks after inserting, then user not allowed to edit them
    public function confirmMarks(){
        if(is_logged_in()){
            if($this->userRoleId == '1'){
                $censusId = $this->input->post('school_select'); // select academic year of the class
                $allSchools = $this->School_model->view_all_schools(); 
                $data['allSchools'] = $allSchools;
            }elseif($this->userRoleId == '2'){
                $censusId = $this->session->userdata['census_id'];
            }
            $year = $this->input->post('year_select'); // select academic year of the class
            $term = $this->input->post('term_select'); // select term of the class
            $gradeId = $this->input->post('grade_select'); // select grade
            $classId = $this->input->post('class_select'); // select class
            if($this->input->post('btn_confirm_marks')=='Confirm'){
                if(!empty($year) && !empty($term) && !empty($gradeId) && !empty($classId)){
                    $confirmResult = $this->Marks_model->check_marks_completed_in_a_class($censusId,$gradeId,$classId,$year,$term);
                    $grade = $this->Grade_model->get_grade_name($gradeId);
                    $class = $this->Class_model->get_class_name($classId);
                    if(!empty($confirmResult)){
                        $this->session->set_flashdata('marksConfirmMsg', array('text' => 'Marks of '.$grade.' '.$class.' class has already been finalized!!!','class' => 'alert alert-danger'));  
                        redirect('Marks/viewMarksConfirm');
                    }else{
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'marks_conf_id' => '',
                            'census_id' => $censusId,
                            'grade_id' => $gradeId,
                            'class_id' => $classId,
                            'year' => $year,
                            'term' => $term,
                            'is_completed' => 1,
                            'date_added' => $now,
                            'date_updated' => $now,
                        ); 
                        if($this->Marks_model->confirm_marks($data)){ // if inserted properly
                            $this->session->set_flashdata('marksConfirmMsg', array('text' => 'Finalized the marks of  '.$grade.' '.$class.' class successfully','class' => 'alert alert-success'));
                        }else{ // if not inserted
                            $this->session->set_flashdata('marksConfirmMsg', array('text' => 'Could not finalized '.$grade.' '.$class.' !!!','class' => 'alert alert-danger'));                
                        }
                    }
                }else{ // if fields are empty
                    $this->session->set_flashdata('marksConfirmMsg', array('text' => 'All the fields are required!!!','class' => 'alert alert-danger'));
                }
            }
            if($this->input->post('btn_view_confirm_status')=='Check'){
                if(!empty($year) && !empty($term)){
                    $gradeId = (empty($gradeId)) ? '' : $gradeId; // if grade is not selected it is kept empty
                    $classId = (empty($classId)) ? '' : $classId; // if class is not selected its kept empty
                    $confirmResult = $this->Marks_model->get_confirm_status($censusId,$year,$term,$gradeId,$classId);
                    if($confirmResult){
                        $data['confirmResult'] = $confirmResult;
                    }else{
                        $this->session->set_flashdata('marksConfirmMsg', array('text' => 'No classes found!!!','class' => 'alert alert-danger'));
                    }
                }else{
                    $this->session->set_flashdata('marksConfirmMsg', array('text' => 'Year and term fields are  required!!!','class' => 'alert alert-danger'));
                }
            }
            $data['title'] = 'Confirming Student Marks';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'marks/marksConfirm';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // unconfirm marks after confirming that allows users to edit marks again
    public function unConfirmMarks(){
        if(is_logged_in()){
            echo $marks_conf_id = $this->input->post('id_hidden'); 
            echo $result = $this->Marks_model->delete_confirmed_marks($marks_conf_id); //die();
            if($result){ // if deleted properly
                $this->session->set_flashdata('marksConfirmMsg', array('text' => 'Removed the finalized status of term test marks successfully','class' => 'alert alert-success'));
            }else{ // if not inserted
                 $this->session->set_flashdata('marksConfirmMsg', array('text' => 'Could not remove finalized status of term test marks!!!','class' => 'alert alert-danger'));                
            }
            redirect('Marks/viewMarksConfirm');
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // display marks report page - view student position on average marks
    public function viewPositionOnAvgMarks(){
        if(is_logged_in()){
            if( $this->userRoleId != '2' ){
                $allSchools = $this->School_model->view_all_schools(); 
                $allGrades = $this->Grade_model->view_all_grades();
                $data['allSchools'] = $allSchools;
                //$data['allGrades'] = $allGrades;
            }
            if( $this->userRoleId == 3 ){
                $data['user_header'] = 'user_zeo_header';
            }elseif( $this->userRoleId == 7 ){
                $data['user_header'] = 'user_edu_division_header';
                $eduDivId = $this->session->userdata['div_id'];
                $allSchools = $this->Common_model->get_all_schools($eduDivId);
            }else{
                $data['user_header'] = 'user_admin_header';
            }
            //print_r($allGrades); die(); 
            $data['title'] = 'Student Rank by Average Marks';
            $data['user_content'] = 'marks/positionOnAvgMarks';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // find student position on average marks
    function positionOnAvgMarks(){ // 
        if(is_logged_in()){ 
            if( empty($_POST['census_id']) || empty($_POST['year']) || empty($_POST['term']) || empty($_POST['grade_id']) ){
                $output = 'Year, Term and Grade are Needed!!!';
            }else{
                $censusId = $_POST['census_id'];
                $year = $_POST['year'];
                $term = $_POST['term'];
                $gradeId = $_POST['grade_id']; 
                if( !empty($_POST['class_id'] )){
                    $classId = $_POST['class_id'];
                    $className = $this->Class_model->get_class_name($classId);
                }else{
                    $classId = '';
                    $className = '';
                }
                if( !empty($_POST['subject_id'] )){ 
                    // get position on subject marks
                    $subjectId = $_POST['subject_id'];
                    $subjectName = $this->Subject_model->get_subject_name($subjectId);
                    $results = $this->Marks_model->get_position_on_subject_marks($censusId, $year, $term, $gradeId, $classId, $subjectId);
                }else{ 
                    // get position on average marks of the term test
                    $subjectId = '';
                    $subjectName = '';
                    $results = $this->Marks_model->get_position_on_avg_marks($censusId, $year, $term, $gradeId, $classId, $subjectId);
                }
                //print_r($result); die();
                $latest_upd_dt = '';
                $gradeName = $this->Grade_model->get_grade_name($gradeId);
                //print_r($marks); //die();
                if( !empty( $results ) ){
                    foreach ($results as $result) {
                        if($latest_upd_dt < $result->last_update){
                            $latest_upd_dt = $result->last_update;
                        }
                    }
                    $latest_upd_dt = strtotime($latest_upd_dt);
                    $update_dt = date("j F Y",$latest_upd_dt);
                    $update_tm = date("h:i A",$latest_upd_dt);
                    $dt = 'Updated on '.$update_dt.' at '.$update_tm;
                    //print_r($marks); die();
                    // following jquery function used to make the html table to a datatable. Otherwise its not working in the view
                    $output = '
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#dataTable1").DataTable({
                                dom: "Bfrtip",
                                buttons: [
                                  {
                                    extend: "excel",
                                    text: "Save",
                                    exportOptions: {
                                        modifier: {
                                            page: "All"
                                        }
                                    }
                                  }
                                ]
                            });
                            $("#updated_dt_span").text("'.$dt.'");
                        });
                    </script>
                    <style type="text/css">
                        //.emptyTd{background-color:#FF0000;}
                        #dataTable1 #name_column{width:400px;}
                    </style>
                    <h5 align="center">Students Position - Term Test '.$term.' of '.$year.' - '.$gradeName.' '.$className.' </h5>
                    <table id="dataTable1" class="stripe row-border order-column table-hover">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>ඇ. වීමේ අංකය </th>
                                <th> නම  </th>
                                <th> පන්තිය  </th>
                                <th> වර්ෂය  </th>
                                <th> වාරය   </th>
                                <th> මුළු ලකුණු   </th>
                                <th> සාමාන්‍ය   </th>
                                <th> ස්ථානය  </th>
                            </tr>
                        </thead>
                    ';
                    $i = 1;
                    foreach ($results as $result) {
                        $output .= '
                        <tbody>
                            <tr>
                                <td>'.$i.'</td>
                                <td>'.$result->adm_no.'</td>
                                <td>'.$result->name_with_initials.'</td>
                                <td>'.$result->grade.$result->class.'</td>
                                <td>'.$result->year.'</td>
                                <td>'.$result->term.'</td>
                                <td>'.$result->total.'</td>
                                <td>'.$result->average.'</td>
                                <td>'.$i.'</td>
                            </tr>
                        </tbody>';
                        $i++;
                    } // end of foreach ($results as $result) {
                    $output .= '</table>';
                    $output .= '<a href=" '. base_url().'ExcelExport/printPositionOnAvgMarks/'.$censusId.'/'.$year.'/'.$term.'/'.$gradeId.'/'.$classId.' " id="btn_add_new_details" name="btn_print_phy_res_info" type="button" class="btn btn-success mt-2 btn-sm" style="margin-top: 10px;"><i class="fa fa-fw fa-print mr-1"></i> Print</a>';
                }else{
                    $output = ' <script type="text/javascript">
                        $(document).ready(function(){
                            $("#updated_dt_span").text(" ");
                        });
                    </script>';
                    echo $output .= 'No records found!';
                } // end of if(!empty($results)){
            } //   end of if(empty($censusId) || empty($year) || empty($term) || empty($gradeId) || empty($classId)){
            echo $output;
        }
    } // end of function positionOnAvgMarks()

    // display marks report page - view student position on subject marks
    public function viewPositionOnSubjectMarks(){
        if(is_logged_in()){
            if( $this->userRoleId != '2' ){
                $allSchools = $this->Common_model->get_all_schools(); 
                //$allGrades = $this->Grade_model->view_all_grades();
                $data['allSchools'] = $allSchools;
            }
            if($this->userRoleId == '2'){
                $censusId = $this->session->userdata['census_id'];
            }
            if( $this->userRoleId == 3 ){
                $data['user_header'] = 'user_zeo_header';
            }elseif( $this->userRoleId == 7 ){
                $data['user_header'] = 'user_edu_division_header';
                $eduDivId = $this->session->userdata['div_id'];
                $allSchools = $this->Common_model->get_all_schools($eduDivId);
            }else{
                $data['user_header'] = 'user_admin_header';
            }
            $data['title'] = 'Student Rank by Subject Marks';
            $data['user_content'] = 'marks/positionOnSubjectMarks';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // find student position on average marks
    function positionOnSubjectMarks(){ // 
        if(is_logged_in()){ 
            if( empty($_POST['census_id']) || empty($_POST['year']) || empty($_POST['term']) || empty($_POST['grade_id']) || empty($_POST['subject_id'])){
                $output = 'Year, Term, Grade and Subject are Needed!!!';
            }else{
                $censusId = $_POST['census_id'];
                $year = $_POST['year'];
                $term = $_POST['term'];
                $gradeId = $_POST['grade_id']; 
                if( !empty( $_POST['class_id'] )){
                    $classId = $_POST['class_id'];
                    $className = $this->Class_model->get_class_name( $classId );
                }else{
                    $classId = '';
                    $className = '';
                }
                
                // get position on subject marks
                $subjectId = $_POST['subject_id'];
                $subjectName = $this->Subject_model->get_subject_name( $subjectId );
                $results = $this->Marks_model->get_position_on_subject_marks( $censusId, $year, $term, $gradeId, $classId, $subjectId );
                //print_r($result); die();
                $latest_upd_dt = '';
                $gradeName = $this->Grade_model->get_grade_name( $gradeId );
                //print_r($marks); //die();
                if( !empty( $results ) ){
                    foreach ( $results as $result ) {
                        if( $latest_upd_dt < $result->last_update ){
                            $latest_upd_dt = $result->last_update;
                        }
                    }
                    $latest_upd_dt = strtotime( $latest_upd_dt );
                    $update_dt = date("j F Y",$latest_upd_dt);
                    $update_tm = date("h:i A",$latest_upd_dt);
                    $dt = 'Updated on '.$update_dt.' at '.$update_tm;
                    //print_r($marks); die();
                    // following jquery function used to make the html table to a datatable. Otherwise its not working in the view
                    $output = '
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#dataTable1").DataTable({
                                dom: "Bfrtip",
                                buttons: [
                                    {
                                    extend: "excel",
                                    text: "Save",
                                    exportOptions: {
                                        modifier: {
                                            page: "All"
                                        }
                                    }
                                    }
                                ]
                            });
                            $("#updated_dt_span").text("'.$dt.'");
                        });
                    </script>
                    <style type="text/css">
                        //.emptyTd{background-color:#FF0000;}
                        #dataTable1 #name_column{width:40px;}
                    </style>
                    <h5 align="center">Students Position - Term Test '.$term.' of '.$year.' - '.$gradeName.' '.$className.' - '.$subjectName.' </h5>
                    <table id="dataTable1" class="stripe row-border order-column table-hover">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>ඇ. වීමේ අංකය </th>
                                <th> නම  </th>
                                <th> පන්තිය  </th>';
                                if( $censusId == 'All' ){
                                    $output .= '<th>පාසල</th>';
                                }
                    $output .= '            
                                <th> වර්ෂය  </th>
                                <th> වාරය   </th>
                                <th>විෂය</th>
                                <th> ලකුණු   </th>
                                <th> ස්ථානය  </th>
                            </tr>
                        </thead>
                    ';
                    $i = 1;
                    foreach ( $results as $result ) {
                        $output .= '
                        <tbody>
                            <tr>
                                <td>'.$i.'</td>
                                <td>'.$result->adm_no.'</td>
                                <td>'.$result->name_with_initials.'</td>
                                <td>'.$result->grade.$result->class.'</td>';
                                if( $censusId == 'All' ){
                                    $output .= '<td>'.$result->sch_name.'</td>';
                                }
                        $output .= '        
                                <td>'.$result->year.'</td>
                                <td>'.$result->term.'</td>
                                <td>'.$result->subject.'</td>
                                <td>'.$result->marks.'</td>
                                <td>'.$i.'</td>
                            </tr>
                        </tbody>';
                        $i++;
                    } // end of foreach ($results as $result) {
                    $output .= '</table>';
                    $output .= '<a href=" '. base_url().'ExcelExport/printPositionOnSubjectMarks/'.$censusId.'/'.$year.'/'.$term.'/'.$gradeId.'/'.$subjectId.'/'.$classId.' " id="btn_add_new_details" name="btn_print_phy_res_info" type="button" class="btn btn-success mt-2 btn-sm" style="margin-top: 10px;"><i class="fa fa-fw fa-print mr-1"></i> Print</a>';
                }else{
                    $output = ' <script type="text/javascript">
                        $(document).ready(function(){
                            $("#updated_dt_span").text(" ");
                        });
                    </script>';
                    echo $output .= 'No records found!';
                } // end of if(!empty($results)){
            } //   end of if(empty($censusId) || empty($year) || empty($term) || empty($gradeId) || empty($classId)){
            echo $output;
        }
    } // end of function positionOnSubjectMarks()

    // display marks report page - view students who are in a specific marks range
    public function viewListOnRange(){
        if(is_logged_in()){
            if( $this->userRoleId != '2' ){
                $allSchools = $this->School_model->view_all_schools(); 
                $allGrades = $this->Grade_model->view_all_grades();
                $data['allSchools'] = $allSchools;
            }
            if( $this->userRoleId == 3 ){
                $data['user_header'] = 'user_zeo_header';
            }elseif( $this->userRoleId == 7 ){
                $data['user_header'] = 'user_edu_division_header';
                $eduDivId = $this->session->userdata['div_id'];
                $allSchools = $this->Common_model->get_all_schools($eduDivId);
                $data['allSchools'] = $allSchools;
            }else{
                $data['user_header'] = 'user_admin_header';
            }
            //print_r($allGrades); die(); 
            $data['title'] = 'List by Range';
            $data['user_content'] = 'marks/listOnRange';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
     // find students who are in a specific marks range
     function listOnRange(){ // 
        if(is_logged_in()){ 
            if( empty($_POST['census_id']) || empty($_POST['year']) || empty($_POST['term']) || empty($_POST['grade_id']) || empty($_POST['subject_id']) || empty($_POST['marks_from']) || empty($_POST['marks_to'])){
                $output = 'Year, Term, Grade, Subject, Marks from, Marks to are Needed!!!';
            }else{
                $censusId = $_POST['census_id'];
                $year = $_POST['year'];
                $term = $_POST['term'];
                $gradeId = $_POST['grade_id']; 
                if( !empty( $_POST['class_id'] )){
                    $classId = $_POST['class_id'];
                    $className = $this->Class_model->get_class_name($classId);
                }else{
                    $classId = '';
                    $className = '';
                }
                // get subject name
                $subjectId = $_POST['subject_id'];
                $subjectName = $this->Subject_model->get_subject_name($subjectId);
                $marksFrom = $_POST['marks_from'];
                $marksTo = $_POST['marks_to'];

                $results = $this->Marks_model->get_student_list_in_a_range($censusId, $year, $term, $gradeId, $classId, $subjectId, $marksFrom, $marksTo);
                //print_r($result); die();
                $gradeName = $this->Grade_model->get_grade_name($gradeId);
                //print_r($marks); //die();
                $latest_upd_dt = '';
                if( !empty( $results ) ){
                    foreach ($results as $result) {
                        if($latest_upd_dt < $result->last_update){
                            $latest_upd_dt = $result->last_update;
                        }
                    }
                    $latest_upd_dt = strtotime($latest_upd_dt);
                    $update_dt = date("j F Y",$latest_upd_dt);
                    $update_tm = date("h:i A",$latest_upd_dt);
                    $dt = 'Updated on '.$update_dt.' at '.$update_tm;
                    //print_r($marks); die();
                    // following jquery function used to make the html table to a datatable. Otherwise its not working in the view
                    $output = '
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#dataTable1").DataTable({
                                dom: "Bfrtip",
                                buttons: [
                                    {
                                    extend: "excel",
                                    text: "Save",
                                    exportOptions: {
                                        modifier: {
                                            page: "All"
                                        }
                                    }
                                    }
                                ]
                            });
                            $("#updated_dt_span").text("'.$dt.'");
                        });
                    </script>
                    <style type="text/css">
                        //.emptyTd{background-color:#FF0000;}
                        #dataTable1 #name_column{width:400px;}
                    </style>
                    <h5 align="center">Students Position - Term Test '.$term.' of '.$year.' - '.$gradeName.' '.$className.' - '.$subjectName.' </h5>
                    <h6 align="center">Marks between '.$marksFrom.' and '.$marksTo.' </h6>
                    <table id="dataTable1" class="stripe row-border order-column table-hover">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>ඇ. වීමේ අංකය </th>
                                <th> නම  </th>
                                <th> පන්තිය  </th>';
                                if( $censusId == 'All' ){
                                    $output .= '<th>පාසල</th>';
                                }
                    $output .=' <th> වර්ෂය  </th>
                                <th> වාරය   </th>
                                <th>විෂය</th>
                                <th> ලකුණු   </th>
                                <th> ස්ථානය  </th>
                            </tr>
                        </thead>
                    ';
                    $i = 1;
                    foreach ($results as $result) {
                        $output .= '
                        <tbody>
                            <tr>
                                <td>'.$i.'</td>
                                <td>'.$result->adm_no.'</td>
                                <td>'.$result->name_with_initials.'</td>
                                <td>'.$result->grade.$result->class.'</td>';
                                if( $censusId == 'All' ){
                                    $output .= '<td>'.$result->sch_name.'</td>';
                                }
                        $output .= ' 
                                <td>'.$result->year.'</td>
                                <td>'.$result->term.'</td>
                                <td>'.$result->subject.'</td>
                                <td>'.$result->marks.'</td>
                                <td>'.$i.'</td>
                            </tr>
                        </tbody>';
                        $i++;
                    } // end of foreach ($results as $result) {
                    $output .= '</table>';
                    $output .= '<a href=" '. base_url().'ExcelExport/printStudentListInARange/'.$censusId.'/'.$year.'/'.$term.'/'.$gradeId.'/'.$subjectId.'/'.$marksFrom.'/'.$marksTo.'/'.$classId.' " id="btn_add_new_details" name="btn_print_phy_res_info" type="button" class="btn btn-success mt-2 btn-sm" style="margin-top: 10px;"><i class="fa fa-fw fa-print mr-1"></i> Print</a>';
                }else{
                    $output = ' <script type="text/javascript">
                        $(document).ready(function(){
                            $("#updated_dt_span").text(" ");
                        });
                    </script>';
                    echo $output .= 'No records found!';
                } // end of if(!empty($results)){
            } //   end of if(empty($censusId) || empty($year) || empty($term) || empty($gradeId) || empty($classId)){
            echo $output;
        }
    } // end of function positionOnSubjectMarks()
    // used in marks index view to show the absentees
    public function viewTermTestAbsentees(){
        if( is_logged_in() ){
            $censusId = $_POST['census_id']; 
            $year = $_POST['year']; 
            $term = $_POST['term']; 
            $grade = $_POST['grade_id']; 
            $class = $_POST['class_id']; 
            $output = '';
            $result = $this->Marks_model->get_term_test_absentees( $censusId, $year, $term, $grade, $class );
            if( !$result ){
                $output = '<div class="alert alert-danger" >No absentees found!!!</div>';
            }else{
                $output .= '
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#dataTable").DataTable({
                            dom: "Bfrtip",
                            buttons: [
                              {
                                extend: "excel",
                                text: "Save",
                                exportOptions: {
                                    modifier: {
                                        page: "All"
                                    }
                                }
                              }
                            ],  
                            fixedColumns: {
                              leftColumns:1
                            }
                        });
                    });
                </script>
                <style type="text/css">
                    th span{ 
                        color:blue; 
                        writing-mode: vertical-lr;
                        transform: rotate(180deg);
                        vertical-align: center;
                        min-width: 20px;
                        max-height: auto;
                        white-space: nowrap; 
                    }
                    // when give word wrap to column header, the following line is overridden
                    th, td { white-space: nowrap; }
                </style>
                <div class="table-responsive">
                    <table id="dataTable" class="stripe row-border order-column table-hover">
                        <thead>
                            <tr>
                                <th>Index No</th><th>Name</th><th>Year</th><th>Term</th><th>Subject</th><th>Grade</th><th>Class</th>
                            </tr>
                        </thead>
                        <tbody>';
                        if( $result ){
                            foreach ( $result as $result ) {
                                $output .= '<tr><td>'.$result->index_no.'</td><td>'.$result->name_with_initials.'</td><td>'.$result->year.'</td><td>'.$result->term.'</td><td>'.$result->subject.'</td><td>'.$result->grade.'</td><td>'.$result->class.'</td></tr>';
                            }
                        }else{
                            $output .= '<tr><td>Not found</td></tr>';
                        }
                $output .= '</tbody></table></div>';
            }
            echo json_encode($output); 
        }else{
            redirect('User');
        }
    }

}