<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Increment extends CI_Controller {

    //public $userRole = $this->session->userdata['userrole'];

    public function __construct(){
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Common_model');
        $this->load->model('Increment_model');
        $this->all_increment_status = $this->viewAllIncrementStatus();
        $this->sendIncrementSms();
        $this->userRole = $this->session->userdata['userrole'];
        if($this->userRole == 'System Administrator'){
            //$this->staff_count_schoolwise = $this->view_all_school_staff_count_schoolwise(); // for bar chart in admin dashboard
            //$this->staff_count_genderwise = $this->view_all_school_staff_count_genderwise(); // for bar chart in admin dashboard        
        }
        if($this->userRole == 'School User'){
            //$this->staff_count_schoolwise= $this->view_all_school_staff_count_schoolwise(); // for bar chart in staff dashboard
            //$this->staff_count_genderwise = $this->view_staff_count_genderwise(); // for bar chart in staff dashboard        
        }
    }
    public function viewAllIncrementStatus(){
        return $this->Increment_model->get_all_increment_status();
    }
    // increments
    public function index(){
        if(is_logged_in()){
            //$userId = $this->session->userdata['user_id'];
            if($this->userRole == 'System Administrator' || $this->userRole == 'Divisional User' || $this->userRole == 'Zonal User'){
                $current_month_date = date("m-d"); // get the current month and date
                //$condition = 'date_format(st.first_app_dt,"%m-%d") >= "'.$from.'" and date_format(st.first_app_dt,"%m-%d") <= "'.$to.'" ';  // "%m-%d" means picking only month and day from first appoinment date
            	$condition1 = 'date_format(st.first_app_dt,"%m-%d") <= "'.$current_month_date.'" ';	// next month to be ignored
                //die();
            }else if($this->userRole == 'School User'){
                $current_month_date = date("m-d"); // get the current month and date
                $censusId = $this->session->userdata['census_id'];
                $condition1 = 'date_format(st.first_app_dt,"%m-%d") <= "'.$current_month_date.'" and st.census_id = "'.$censusId.'" ';    // next month to be ignored
                //die();
            }
            $all_teachers = $this->Staff_model->get_stf_by_condition($condition1); // find all teacher of staff_tbl whos month of first app date is less than or equal to current month, bcz next month to be avoided
            //print_r($all_teachers); die();
            if($all_teachers){
                foreach ($all_teachers as $teacher) {
                    $stfId = $teacher->stf_id;
                    //$app_date = $teacher->first_app_dt;
                    $this->Increment_model->get_stf_increment_not_submit($stfId); // current year is checked in increment_model
                    if($this->Increment_model->get_stf_increment_not_submit($stfId)){
                        $condition = 'st.stf_id = "'.$stfId.'" ';
                        $increment_data[] = $this->Staff_model->get_stf_by_condition($condition);
                    }
                }  
                if(empty($increment_data)){
                    $increment_data = '';
                } 
            }else{
                $increment_data = '';
            }
             
            //die();
            //print_r($increment_data); die();
            if($this->viewRecentIncrements()){
                $coming_salary_increments = $this->viewRecentIncrements(); 
            }else{
                $coming_salary_increments = '';
            }
        	$data['coming_salary_increments'] = $coming_salary_increments;
        	$data['increment_data'] = $increment_data;
    		$data['title'] = 'Increment Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'increments/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('Login');
        }
    }
    // view coming increments from today upto 30 days
    public function viewRecentIncrements(){
        $userRole = $this->session->userdata['userrole'];
        $from = date("m-d"); // get the current date
        $to = date('m-d', strtotime(' + 30 days')); // add 30 days to current date
        if($userRole == 'System Administrator' || $userRole == 'Divisional User' || $userRole == 'Zonal User'){
            $condition = 'date_format(st.first_app_dt,"%m-%d") >= "'.$from.'" and date_format(st.first_app_dt,"%m-%d") <= "'.$to.'" ';  // "%m-%d" means picking only month and day from first appoinment date
            $coming_salary_increments = $this->Increment_model->get_recent_increments($condition);
        }else if($userRole == 'School User'){
            $censusId = $this->session->userdata['census_id'];
            $condition = 'date_format(st.first_app_dt,"%m-%d") >= "'.$from.'" and date_format(st.first_app_dt,"%m-%d") <= "'.$to.'" ';  // "%m-%d" means picking only month and day from first appoinment date
            $condition .= 'and st.census_id = "'.$censusId.'"'; 
            $coming_salary_increments = $this->Increment_model->get_recent_increments($condition);
        }
        return $coming_salary_increments;
    }
    public function sendIncrementSms(){ 
        //echo date("Y-m-d h:i:sa"); die();
        $coming_salary_increments = $this->viewRecentIncrements();
        //print_r($coming_salary_increments); die();
        if($coming_salary_increments){
            foreach ($coming_salary_increments as $teacher) {
                $staff_id = $teacher->staff_id;
                $currentYear = date("Y");
                if($this->Increment_model->check_increment_sms_status($staff_id,$currentYear)){
                    $gender_id = $teacher->gender_id;
                    $civil_status = $teacher->civil_status_id;
                    if($gender_id==1){
                        $salutation = 'Mr';
                    }else{
                        if($civil_status_id==1){
                            $salutation = 'Mrs';
                        }else if($civil_status_id==2){
                            $salutation = 'Ms';
                        }else{ $salutation = ''; }
                    }
                    $name = $salutation.' '.$teacher->name_with_ini;
                    $incrementDate = date('m-d', strtotime($teacher->first_app_dt));
                    $incrementDate = $currentYear.'-'.$incrementDate;
                    if($teacher->phone_mobile1 != ''){
                        $phoneNo = $teacher->phone_mobile1;
                    }else if($teacher->phone_mobile2 != ''){
                        $phoneNo = $teacher->phone_mobile2;
                    }
                    $message = $name.', your salary increment date is '.$incrementDate;
                    if($this->sendSms($phoneNo,$message)){
                        $remarks = 'Sent the message to '.$phoneNo.' successfully';
                        $this->recordSmsResult($staff_id,$currentYear,$remarks);
                    }else{
                        $remarks = 'Message was not sent to '.$phoneNo.' ';
                        $this->recordSmsResult($staff_id,$currentYear,$remarks);
                    }
                }
            }
        }
    }
    public function sendSms($phoneNo,$message){
        $user = "942018052101";
        $password = "2518";
        $text = urlencode($message);
        $to = $phoneNo;
         
        $baseurl ="http://www.textit.biz/sendmsg";
        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
        $ret = file($url);
         
        $res= explode(":",$ret[0]);
         
        if (trim($res[0])=="OK"){
            return true;
        }else{
            return false;
        }
    }
    public function recordSmsResult($id,$year,$remarks){
        $time = date("Y-m-d h:i:sa");
        $data = array(
            'stf_id' => $id,
            'increment_year' => $year,
            'sms_sent' => 1,
            'remarks' => $remarks,
            'sms_sent_date' => $time
        );
        if($this->Increment_model->insert_sms_result($data)){
            return true;
        }else{ return false; }
    }
    public function viewSmsStatus(){
        $output = array();  
        $year = date("Y");
        $staff_id = $_POST['staff_id']; //die();
        $data = $this->Increment_model->get_sms_info($staff_id,$year);  
        foreach($data as $row)  {  
            $output['tr_inc_inform_id'] = $row->tr_inc_inform_id;  
            $output['increment_year'] = $row->increment_year;  
            $output['sms_sent'] = $row->sms_sent;  
            $output['remarks'] = $row->remarks; 
            $output['sms_sent_date'] = $row->sms_sent_date;             
        }  
        echo json_encode($output);  
    }
    public function getDatatoSendMessage(){
        $output = array();  
        $year = date("Y");
        $staff_id = $_POST['staff_id']; //die();
        $condition = 'st.stf_id = "'.$staff_id.'" ';
        $result = $this->Staff_model->get_stf_by_condition($condition);
        foreach ($result as $row) {
            $output['stf_id'] = $staff_id;
            $output['stf_name'] = $row->name_with_ini;
            $output['census_id'] = $row->census_id;
            $output['sch_name'] = $row->sch_name;
            $output['increment_year'] = $year;
        }
        echo json_encode($output);  
    }
    public function sendIncrementReminderMessage(){
            $date = date("Y-m-d");
            $census_id = $this->input->post('census_id_hidden');
            $stfid = $this->input->post('stfid_txt');
            $msg = $this->input->post('message_txtarea');
            $academic_year = $this->input->post('incre_year_txt');
            //die();
            $data = array(
                'msg_id' => '',
                'msg_cat_id' => 1,
                'stf_id' => $stfid,             
                'message' => $msg,
                'by_whom' => 'Divisional Education Office',
                'to_whom' => $census_id,
                'academic_year' => $academic_year,
                'date_added' => $date,
                'date_updated' => $date,
                'is_deleted' => '',
                'is_read' => '',
                'when_read' => ''
            );
            $result = $this->Increment_model->send_increment_msg($data);
            if($result){
                echo 'Sent';
            }
    }
    public function viewMessageHistory(){
        $output = array();  
        $year = date("Y");
        $staff_id = $_POST['staff_id']; //die();
        $message_history = $this->Increment_model->get_message_history($staff_id,$year);  
        //print_r($message_history); die();
        if(!empty($message_history)){
            $output = '<table id="dataTable" class="table table-striped table-hover" cellspacing="0" width="300px;"><tr><th> Name </th>
                          <th> Message </th>
                          <th> Is read?</th>
                              <th> When read</th>';
            foreach ($message_history as $row) {
                $output .= '<tr>';
                $output .= '<td>'.$row->name_with_ini.'</td>';
                $output .= '<td>'.$row->message.'</td>';
                if($row->is_read==1){
                    $output .= '<td> ඔව් </td>';
                }else{
                    $output .= '<td> නැත </td>';
                }
                $output .= '<td>'.$row->when_read.'</td>';
                $output .= '</tr>';
            }
            $output .= '</table>'; 
        }else{
            $output = 'Informed messages not sent'; 
        }
        echo json_encode($output);  
    }
    // view all increments submitted in this year
    public function viewIncrements(){
        if(is_logged_in()){
            $userRole = $this->session->userdata['userrole'];
            $userId = $this->session->userdata['userid'];
            $year = date("Y");
            if($userRole == 'School User'){
                $censusId = $this->session->userdata['census_id'];
                $condition = 'to_whom = "'.$censusId.'" ';
                $condition = 'increment_year = "'.$year.'" and st.census_id = "'.$censusId.'" ';
            }else if($userRole == 'System Administrator'){
                $condition = 'increment_year = "'.$year.'" ';
                //$condition = 'st.census_id = "'.$censusId.'" ';
            }else if($userRole == 'Divisional User'){
                $condition = 'increment_year = "'.$year.'" ';
                //$condition = 'st.census_id = "'.$censusId.'" ';
            }else if($userId = '24'){
                //$current_month_date = date("m-d"); // get the current month and date
                $condition = 'increment_year = "'.$year.'" ';
                $condition .= 'and tit.inc_status_id = 3';
            }else if($userId = '23'){
                //$current_month_date = date("m-d"); // get the current month and date
                $condition = 'increment_year = "'.$year.'" ';
                $condition .= 'and tit.inc_status_id = 5';
            }
            $increments = $this->Increment_model->view_increments($condition);
            //print_r($newMessages); die();
            $data['title'] = 'Hand overed salary increments';
            $data['increments'] = $increments;
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'increments/new_increments';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('Login');
        }
    }
    // view increment by incriment id to view on increment update modal in new increment view
    public function viewIncrement_by_id(){
        $year = date("Y");
        $inc_id = $_POST['inc_id']; //die();
        $condition = 'tit.tr_inc_id = "'.$inc_id.'" ';
        $result = $this->Increment_model->view_increments($condition);
        foreach ($result as $row) {
            $output['inc_id'] = $inc_id;
            $output['stf_id'] = $row->stf_id;
            $output['stf_name'] = $row->name_with_ini;
            $output['nic'] = $row->nic_no;            
            $output['census_id'] = $row->census_id;
            $output['sch_name'] = $row->sch_name;
            $first_app_date = strtotime($row->first_app_dt); 
            $inc_date = date("m-j",$first_app_date);            // remove year from the date to make this year increment date
            $inc_date = $year.'-'.$inc_date;                    // add current year to make increment date
            $output['inc_date'] = $inc_date;
            $output['increment_year'] = $row->increment_year;
            $output['inc_status_id'] = $row->inc_status_id;
            $output['inc_status'] = $row->inc_status;
            $output['defect_id'] = $row->defects;
            $output['remarks'] = $row->remarks;
            $output['date_added'] = $row->inc_date_added;
            $output['date_updated'] = $row->last_update;
        }
        echo json_encode($output); 
    }
    // view increment by incriment id to view on increment update modal in new increment view
    public function viewIncrementByTeacher(){
        if(is_logged_in()){
            $year = date("Y");
            $nic_no = $_POST['nic_no']; //die();
            $inc_status = $this->Increment_model->view_increments_by_nic($nic_no,$year);  
            if(!$inc_status){
                $msg = 'No records found!!!';
                $output = '<div class="alert alert-danger" >'.$msg.'</div>';
            }else{
                foreach ($inc_status as $row) {
                    $status_id = $row->inc_status_id;
                }
                switch ($status_id) {
                    case 1:
                        $progress = 20;
                        break;
                    case 2:
                        $progress = 40;
                        break;
                    case 3:
                        $progress = 60;
                        break;
                    case 4:
                        $progress = 80;
                        break;
                    case 5:
                        $progress = 90;
                        break;
                    case 6:
                        $progress = 100;
                        break;
                }
                $output = array();
                $output = '<p>Progress of salary increment processing</p>';
                $output .= '<div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="width:'.$progress.'% ">
                                '.$progress.'% </div>
                            </div><br />';                  
                $output .= '<div class="table-responsive">';
                $output .= '<table id="dataTable" class="table table-striped table-hover" cellspacing="0" width="300px;">
                                <th> Name </th>
                                <th> Year </th>
                                <th> Status </th>
                                <th> Defects </th>
                                <th> Remarks </th>
                                <th> Submited on </th>';
                foreach ($inc_status as $row) {
                    $output .= '<tr>';
                    $output .= '<td>'.$row->name_with_ini.'</td>';
                    $output .= '<td>'.$row->increment_year.'</td>';
                    $output .= '<td>'.$row->inc_status.'</td>';
                    if($row->defects==1){
                        $output .= '<td> ඇත </td>';
                    }else{
                        $output .= '<td> නැත </td>';
                    }
                    $output .= '<td>'.$row->remarks.'</td>';
                    $output .= '<td>'.$row->inc_date_added.'</td>';
                    $output .= '</tr>';
                }
                $output .= '</table>';
                $output .= '</div>';
            }
            echo json_encode($output); 
        } 
    }
    public function addNewIncrement(){
        if(is_logged_in()){ 
            if ($this->input->post('btn_add_increment') == "Add"){
                $this->form_validation->set_rules("nic_txt","NIC number","trim|required");               
                $this->form_validation->set_rules("stf_id_hidden","Staff ID","trim|required");               
                $this->form_validation->set_rules("school_txt","School","trim|required");
                $this->form_validation->set_rules("inc_date_txt","Increment date","trim|required");
                $this->form_validation->set_rules("inc_year_select","Increment year","trim|required");               
                $this->form_validation->set_rules("increment_status_select","Increment status","trim|required"); 
                $this->form_validation->set_rules("defects_select","Defects","trim|required");               

                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('increment_add_msg', array('text' => 'Name, NIC No, School, Increment date, Increment year, Defects and Submit date fields are required!','class' => 'alert alert-danger'));
                    $this->viewIncrements();
                }else{
                    $stf_id = $this->input->post('stf_id_hidden');
                    $inc_year = $this->input->post('inc_year_select');
                    $inc_date = $this->input->post('inc_date_txt');
                    $inc_status_id = $this->input->post('increment_status_select');
                    $defect_id = $this->input->post('defects_select');                    
                    $submit_dt = $this->input->post('submit_dt_txt');
                    if($submit_dt < $inc_date){
                        // if submit date is less than the increment date, stop applying increment
                        $this->session->set_flashdata('increment_add_msg', array('text' => 'Please apply the increment after your increment date!','class' => 'alert alert-danger'));
                        $this->viewIncrements();
                    }else{
                        $exists = $this->Increment_model->check_increment_exists($stf_id,$inc_year);
                        if(!$exists){
                            $now = date('Y-m-d');
                            $data = array(
                                'tr_inc_id' => '',
                                'stf_id' => $stf_id,
                                'increment_year' => $inc_year,
                                'inc_status_id' => $inc_status_id,
                                'defects' => $defect_id,
                                'remarks' => '',
                                'date_added' => $submit_dt,
                                'date_updated' => $now,
                                'is_deleted' => '',
                            );
                            $result = $this->Increment_model->insert_new_increment($data);
                            if($result){
                                $this->session->set_flashdata('increment_add_msg', array('text' => 'Salary increment details added successfully','class' => 'alert alert-success'));
                            }else{
                                $this->session->set_flashdata('increment_add_msg', array('text' => 'Error in inserting data!!!','class' => 'alert alert-danger'));
                            }
                        }else{
                            $this->session->set_flashdata('increment_add_msg', array('text' => 'This salary increment already exists!!!','class' => 'alert alert-danger'));
                        }
                        redirect('increment/viewIncrements');   
                    }    
                }
            }else{
                redirect('increment/viewIncrements');
            }
        }else{
            redirect('Login');
        }  
    }
     // updating increment information
    public function updateIncrementInfo(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_increment') == "Update"){
                $inc_id = $this->input->post('inc_id_hidden_upd'); 
                $stf_id = $this->input->post('stf_id_hidden_upd'); 
                $year   = $this->input->post('inc_year_select_upd'); 
                $this->form_validation->set_rules("name_txt_upd","Name","trim|required");              
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('updateIncMsg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                    $this->viewIncrements();
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'tr_inc_id' => $this->input->post('inc_id_hidden_upd'),
                        'stf_id' => $stf_id,
                        'increment_year' => $this->input->post('inc_year_select_upd'),
                        'inc_status_id' => $this->input->post('inc_status_select_upd'),
                        'defects' => $this->input->post('defects_select_upd'),
                        'remarks' => $this->input->post('remarks_txtarea_upd'),
                        'date_added' => $this->input->post('submit_dt_txt_upd'),
                        'date_updated' => $now,
                        'is_deleted' => 0,
                    );
                    //print_r($data); die();      
                    $result = $this->Increment_model->update_increment($data);

                    if($result){
                        $this->session->set_flashdata('updateIncMsg', array('text' => 'Increment details updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('updateIncMsg', array('text' => 'Error in updating!!!','class' => 'alert alert-danger','update'=>'false'));
                    }
                    $this->viewIncrements();
                }
            }else{
                $this->viewIncrements();
            }
        }else{
            redirect('Login');
        }
    } 
    public function deleteIncrementInfo(){
        $inc_id = $this->input->post('inc_id');
        if($this->Increment_model->delete_increment_info($inc_id)){
            echo 'true';
        }else{
            echo 'false';
        }
    }
    // Go to Increment reports page
    public function viewIncrementReports(){
        if(is_logged_in()){
            $userRole = $this->session->userdata['userrole'];
            if($userRole == 'System Administrator' || $this->userRole == 'Divisional User' ){
                $current_month_date = date("m-d"); // get the current month and date
                $condition1 = 'date_format(st.first_app_dt,"%m-%d") <= "'.$current_month_date.'" '; // next month to be ignored
                //die();
            }else if($userRole == 'School User'){
                $current_month_date = date("m-d"); // get the current month and date
                $censusId = $this->session->userdata['census_id'];
                $condition1 = 'date_format(st.first_app_dt,"%m-%d") <= "'.$current_month_date.'" and st.census_id = "'.$censusId.'" ';    // next month to be ignored
                //die();
            }
            
            $all_teachers = $this->Staff_model->get_stf_by_condition($condition1); // find all teacher of staff_tbl whos month of first app date is less than or equal to current month, bcz next month to be avoided
            //print_r($all_teachers); die();
            if($all_teachers){
                foreach ($all_teachers as $teacher) {
                    $stfId = $teacher->stf_id;
                    //$app_date = $teacher->first_app_dt;
                    $this->Increment_model->get_stf_increment_not_submit($stfId);
                    if($this->Increment_model->get_stf_increment_not_submit($stfId)){
                        $condition = 'st.stf_id = "'.$stfId.'" ';
                        $tr_not_submit_increment_upto_now[] = $this->Staff_model->get_stf_by_condition($condition);
                    }
                    if(empty($tr_not_submit_increment_upto_now)){
                        $tr_not_submit_increment_upto_now = '';
                    }
                }   
            }else{
                $tr_not_submit_increment_upto_now = '';
            }
             
            //$increments = $this->Increment_model->view_increments($condition);
            //print_r($newMessages); die();
            $data['title'] = 'Salary Increment Reports';
            $data['tr_not_submit_increment_upto_now'] = $tr_not_submit_increment_upto_now;
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'increments/increment_reports';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('Login');
        }
    }
    // following function used in increment reports page
    // used by viewTeachersNotSubmitIncrement()
    public function findTeachersNotSubmitIncrementThisYearUptoNow(){
            $year = date("Y");
            $condition = 'increment_year = "'.$year.'" ';
            $month = date("m"); // get the current month
            $condition1 = 'month(st.first_app_dt) <= "'.$month.'" ';    // next month to be ignored
            $all_teachers = $this->Staff_model->get_stf_by_condition($condition1); // find all teacher of staff_tbl whos month of first app date is less than or equal to current month, bcz next month to be avoided
            //print_r($all_teachers); die();
            if($all_teachers){
                foreach ($all_teachers as $teacher) {
                    $stfId = $teacher->stf_id;
                    //$app_date = $teacher->first_app_dt;
                    $this->Increment_model->get_stf_increment_not_submit($stfId);
                    if($this->Increment_model->get_stf_increment_not_submit($stfId)){
                        $condition = 'st.stf_id = "'.$stfId.'" ';
                        $tr_not_submit_increment_upto_now[] = $this->Staff_model->get_stf_by_condition($condition);
                    }
                }   
            }else{
                $tr_not_submit_increment_upto_now = '';
            }
            return $tr_not_submit_increment_upto_now;
    }
    // view teachers who have not submitted the salary increment reports by year 
    public function viewTeachersNotSubmitIncrement(){
        if(is_logged_in()){
            if ($this->input->post('btn_view_inc_not_submit') == "View"){
                $this->form_validation->set_rules("inc_year_select","Increment Year","trim|required");             
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Increment Year is required!','class' => 'alert alert-danger'));
                    $this->viewIncrementReports();
                }else{
                    $year = $this->input->post('inc_year_select');
                    $condition = 'st.stf_type_id = 1';    // only the academic staff
                    $academic_staff = $this->Staff_model->get_stf_by_condition($condition);
                    //print_r($academic_staff); die();
                     if($academic_staff){
                        foreach ($academic_staff as $teacher) {
                            $stfId = $teacher->stf_id;
                            //$app_date = $teacher->first_app_dt;
                            $this->Increment_model->check_increment_exists($stfId,$year);
                            if(!$this->Increment_model->check_increment_exists($stfId,$year)){
                                $condition = 'st.stf_id = "'.$stfId.'" ';
                                $stf_data_no_increment[] = $this->Staff_model->get_stf_by_condition($condition);
                            }
                        }   
                    }
                    //if()
                    //print_r($stf_data_no_increment); die();
                    $data['tr_not_submit_increment_upto_now'] = $this->findTeachersNotSubmitIncrementThisYearUptoNow(); 
                    $data['academic_year'] = $year;
                    $data['title'] = 'Salary Increment Reports';
                    $data['stf_data_no_increment'] = $stf_data_no_increment;
                    $data['user_header'] = 'user_admin_header';
                    $data['user_content'] = 'increments/increment_reports';
                    $this->load->view('templates/user_template', $data);
                }
            }else{
                redirect('Increment/viewIncrementReports');
            }
        }else{
            redirect('Login');
        }
    }
    // view teachers according to their increment form status in current year
    public function viewTeachersAccordingtoIncStatus(){
        if(is_logged_in()){
            if ($this->input->post('btn_view_tr_inc_status') == "View"){
                $this->form_validation->set_rules("inc_status_select","Increment Status","trim|required");             
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Increment Status is required!','class' => 'alert alert-danger'));
                    $this->viewIncrementReports();
                }else{
                    $year = date('Y');
                    $inc_status = $this->input->post('inc_status_select');
                    //die();
                    //$condition = 'st.stf_id = "'.$stfId.'" ';
                    $condition = 'tit.inc_status_id = '.$inc_status.' and tit.increment_year = '.$year;    // only the academic staff
                    $tr_increment_status = $this->Increment_model->view_increments($condition);
                    //if()
                    //print_r($stf_data_no_increment); die();
                    if($tr_increment_status){
                        $data['tr_not_submit_increment_upto_now'] = $this->findTeachersNotSubmitIncrementThisYearUptoNow(); 
                        $data['title'] = 'Salary Increment Reports';
                        $data['tr_increment_status'] = $tr_increment_status;
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'increments/increment_reports';
                        $this->load->view('templates/user_template', $data); 
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'No records found!','class' => 'alert alert-danger'));
                        redirect('Increment/viewIncrementReports');
                    }                    
                }
            }else{
                redirect('Increment/viewIncrementReports');
            }
        }else{
            redirect('Login');
        }
    }
}