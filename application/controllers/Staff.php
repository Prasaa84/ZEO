<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Common_model');
        $this->all_grades = $this->view_all_grades();
        $this->all_classes = $this->view_all_classes();
        $this->all_schools = $this->view_all_schools();
        $this->all_section_roles = $this->view_all_section_roles();        
        $this->all_religion = $this->view_all_religion();
        $this->all_ethnic_groups = $this->view_all_ethnic_groups();        
        $this->all_civil_status = $this->view_all_civil_status();        
        $this->all_service_grades = $this->view_all_service_grades();
        $this->all_tasks_involved = $this->view_all_task_involved();
        $this->all_edu_qual = $this->view_all_edu_qual();
        $this->all_prof_qual = $this->view_all_prof_qual();
        $this->all_appoint_cat = $this->view_all_appointment_category();
        $this->all_appoint_sub_cat = $this->view_all_appointment_sub_category();
        $this->all_subj_medium = $this->view_all_subj_medium();
        $this->all_designations = $this->view_all_designations();
        $this->all_staff_status = $this->view_all_stf_status();
        $this->all_stf_types = $this->view_all_stf_types();
        $this->all_sections = $this->view_all_sections();
        if($this->session->userdata['userrole'] == 'System Administrator'){
            $this->staff_count_schoolwise = $this->view_all_school_staff_count_schoolwise(); // for bar chart in admin dashboard
            $this->staff_count_genderwise = $this->view_all_school_staff_count_genderwise(); // for bar chart in admin dashboard        
        }
        if($this->session->userdata['userrole'] == 'School User'){
            $this->staff_count_schoolwise= $this->view_all_school_staff_count_schoolwise(); // for bar chart in staff dashboard
            $this->staff_count_genderwise = $this->view_staff_count_genderwise(); // for bar chart in staff dashboard        
        }
    }
    public function index(){ 
        if(is_logged_in()){
            $data['title'] = 'Staff Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'staff/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // view staff details page
    public function viewAcademicStaff(){
        if(is_logged_in()){
        	$userrole = $this->session->userdata['userrole'];
            if($userrole == 'System Administrator'){ // if the user is school, then staff details must be displayed by census id
                $acStaffDetails = $this->Staff_model->get_all_academic_staff(); 
                //print_r($acStaffDetails);die();
          	}
	        if($userrole == 'School User'){ // if the user is grade 9 must be displayed by census id
	            $censusId = $this->session->userdata['census_id'];
	            $condition = 'st.census_id = "'.$censusId.'" ';
	            $acStaffDetails = $this->Staff_model->get_stf_by_condition($condition); 
	        }
            if(!$acStaffDetails){
                $this->session->set_flashdata('no_staff_info', array('text' => 'No records found!!!','class' => 'alert alert-danger'));
            }else{
                $data['acStaffDetails'] = $acStaffDetails;
            }
            $data['title'] = 'Academic Staff Details';
            $data['user_header'] = 'user_admin_header';
        	$data['user_content'] = 'Staff/viewSchoolStaff';
        	$this->load->view('templates/user_template', $data);
    	}else{
        	redirect('Login');
    	}
    }
    // this is used in increment controller. when nic is typed find name and school
    public function findStaffByNic(){
        $year = date("Y");
        $output = array();  
        $nic = $_POST['nic']; //die();
        $condition = 'st.nic_no = "'.$nic.'" ';
        $result = $this->Staff_model->get_stf_by_condition($condition);
        if(!empty($result)){
            foreach ($result as $row) {
                $output['stf_id'] = $row->stf_id;
                $output['stf_name'] = $row->name_with_ini;
                $output['census_id'] = $row->census_id;
                $output['sch_name'] = $row->sch_name;
                $first_app_date = strtotime($row->first_app_dt); 
                $inc_date = date("m-j",$first_app_date);           // remove year from the date to make this year increment date
                $inc_date = $year.'-'.$inc_date;                   // add current year to make increment date
                $output['inc_date'] = $inc_date;
            }           
        }else{
            $output = '';
        }
        echo json_encode($output);  
    }

    // add staff details
    public function addStaff(){
        if(is_logged_in()){ 
            if ($this->input->post('btn_add_new_stf_info') == "Add_New"){
            	//echo 'asdf'; die();
                $this->form_validation->set_rules("name_with_ini_txt","Name with Initials","trim|required");               
                //$this->form_validation->set_rules("full_name_txt","Full Name","trim|required");               
                $this->form_validation->set_rules("nic_txt","NIC number","trim|required");               
                $this->form_validation->set_rules("f_app_dt_txt","First Appointment Date","trim|required");
                $this->form_validation->set_rules("school_select","School name ","trim|required");               
                //$this->form_validation->set_rules("stf_no_txt","Staff Number","trim|required");               
                $this->form_validation->set_rules("civil_status_select","Designation","trim|required");               
                $this->form_validation->set_rules("gender_select","Gender","trim|required");               
                //$this->form_validation->set_rules("section_select","Section","trim|required");               
                //$this->form_validation->set_rules("emp_type_select","Employee type","trim|required");               

                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Name with initials, NIC No, School name, First Appointment Date, Civil status and Gender fields are required!','class' => 'alert alert-danger'));
                    $this->viewAcademicStaff();
                }else{
                    // personal details
                    $id = '';
                    $name_with_ini = $this->input->post('name_with_ini_txt');
                    $full_name = $this->input->post('full_name_txt');
                    $nick_name = $this->input->post('nick_name_txt');
                    $address1 = $this->input->post('address1_txt');
                    $address2 = $this->input->post('address2_txt');
                    $nic = $this->input->post('nic_txt');
                    $dob = $this->input->post('dob_txt');
                    $gender_id = $this->input->post('gender_select');
                    $civil_status_id = $this->input->post('civil_status_select');
                    $ethnic_group_id = $this->input->post('ethnicity_select');
                    $religion_id = $this->input->post('religion_select');
                    $home_phone = $this->input->post('tel_home_txt');
                    $mobile1 = $this->input->post('tel1_txt');
                    $mobile2 = $this->input->post('tel2_txt');
                    $email = $this->input->post('email_txt');
                    $vehicle1 = $this->input->post('vehicle_no1_txt');
                    $vehicle2 = $this->input->post('vehicle_no2_txt');
                    $edu_q_id = $this->input->post('high_edu_select');
                    $prof_q_id = $this->input->post('prof_edu_select');
                    // Service details
                    $first_app_dt = $this->input->post('f_app_dt_txt'); //ok
                    $stf_type_id = $this->input->post('stf_type_select'); //ok
                    $app_sub_cat_id = $this->input->post('app_sub_cat_select'); // this is stored in stf_app_sub_cat_tbl
                    $app_medium_id = $this->input->post('app_medium_select');
                    $serv_gr_id = $this->input->post('service_grade_select'); //ok
                    // School details
                    $census_id = $this->input->post('school_select');
                    $stf_no = $this->input->post('stf_no_txt');
                    $salary_no = $this->input->post('salary_no_txt');
                    $this_sch_dt = $this->input->post('this_sch_dt_txt'); //ok
                    $desig_id = $this->input->post('desig_select');
                    $status_id = $this->input->post('stf_status_select'); //ok  
                    $section_id = $this->input->post('section_select'); //ok
                    $sec_role_id = $this->input->post('section_role_select'); //ok
                    $task_id = $this->input->post('task_inv_select'); 
                    //$grd_id = $this->input->post('grade_select');
                    //$cls_id = $this->input->post('class_select');
                    
                    // Image
                    $stf_image = $this->input->post('stf_image');
                    $exists = $this->Staff_model->check_staff_exists($nic);
                    if(!$exists){
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'stf_id' => $id,
                            'census_id' => $census_id,
                            'name_with_ini' => $name_with_ini,
                            'full_name' => $full_name,
                            'nick_name' => $nick_name,
                            'address1' => $address1,
                            'address2' => $address2,
                            'nic_no' => $nic,
                            'dob' => $dob,
                            'gender_id' => $gender_id,
                            'civil_status_id' => $civil_status_id,
                            'ethnic_group_id' => $ethnic_group_id,
                            'religion_id' => $religion_id,
                            'phone_home' => $home_phone,
                            'phone_mobile1' => $mobile1,
                            'phone_mobile2' => $mobile2,
                            'vehicle_no1' => $vehicle1,
                            'vehicle_no2' => $vehicle2,
                            'email' => $email,
                            'edu_q_id' => $edu_q_id,
                            'prof_q_id' => $prof_q_id,
                            'desig_id' => $desig_id,
                            'serv_grd_id' => $serv_gr_id,
                            'sec_id' => $section_id,
                            'sec_role_id' => $sec_role_id,
                            'stf_type_id' => $stf_type_id,
                            'stf_status_id' => $status_id,
                            'first_app_dt' => $first_app_dt,
                            'start_dt_this_sch' => $this_sch_dt,
                            'user_id' => '',
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                            'involved_task_id' => $task_id,
                            'subj_med_id' => $app_medium_id,
                            'app_sub_cat_id' => $app_sub_cat_id,
                            'stf_no' => $stf_no,                                                        
                            'salary_no' => $salary_no,
                        );
                        if(!empty($_FILES['stf_image']['name'])){
                            //die();
                            $config['upload_path']          = './assets/uploaded/stf_images/';
                            $config['allowed_types']        = 'gif|jpg|png';
                            $config['max_size']             = 400; // 100KB
                            $config['max_width']            = 1024;
                            $config['max_height']           = 768;
                            $config['file_name']            = $this->input->post('stf_no_txt');
                            $config['overwrite']           = TRUE;

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('stf_image')){
                                $uploadError = array('error' => $this->upload->display_errors());
                                $this->session->set_flashdata('uploadError',$uploadError);
                            }else{
                                $uploadSuccess = 'Image uploaded successfully';
                                $this->session->set_flashdata('uploadSuccess',$uploadSuccess);
                            }
                        }
                        $result = $this->Staff_model->insert_staff($data);
                        if($result){
                            $this->session->set_flashdata('msg', array('text' => 'Details added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('msg', array('text' => 'Error in inserting data!!!','class' => 'alert alert-danger'));
                        }
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'This staff member already exists!!!','class' => 'alert alert-danger'));
                    }
                    redirect('Staff/viewAcademicStaff');
                }
            }else{
                redirect('Staff/viewAcademicStaff');
            }
        }else{
            redirect('Login');
        }  
    }
    public function uploadStaffImage(){
        if($this->input->post('btn_upload_stf_img')=='upload_stf_image'){
            $stf_id = $this->input->post('stf_id_hidden'); 
            if(!empty($_FILES['stf_image']['name'])){
                $stf_id = $this->input->post('stf_id_hidden');
                $stf_no = $this->input->post('stf_no_hidden');
                $config['upload_path']          = './assets/uploaded/stf_images/';
                $config['allowed_types']        = 'jpg';
                $config['max_size']             = 400; // 100KB
                $config['max_width']            = 250;
                $config['max_height']           = 250;
                $config['file_name']            = $this->input->post('stf_id_hidden');
                $config['overwrite']           = TRUE;
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('stf_image')){
                    $uploadError = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('stfImgUploadError',$uploadError);
                }else{
                    $uploadSuccess = 'Image uploaded successfully';
                    $this->session->set_flashdata('stfImgUploadSuccess',$uploadSuccess);
                }
            }else{
                $noImageError = 'Please select the image';
                $this->session->set_flashdata('noImageError',$noImageError);
            }
            $this->viewEditStaffViewAfterUpdate($stf_id);
        }
    }
    public function viewEditStaffViewAfterUpdate($id){
        if(is_logged_in()){
            $stfId = $id; 
            $condition = 'st.stf_id="'.$stfId.'" ';
            $stf_result = $this->Staff_model->get_stf_by_condition($condition);
            //print_r($stf_result);die();
            $stf_game_info = $this->Staff_model->get_stf_game_info($stfId);
            $stf_ext_cur_info = $this->Staff_model->get_stf_ectra_curri_info($stfId);
            $stf_grd_cls_info = $this->Staff_model->get_stf_grd_cls($stfId);
            //print_r($stf_grd_cls_info); die();
            $data['stf_result'] = $stf_result;
            $data['stf_game_info'] = $stf_game_info;
            $data['stf_EC_info'] = $stf_ext_cur_info;
            $data['stf_grd_cls_info'] = $stf_grd_cls_info;            
            $data['title'] = 'Staff Update';
            $data['user_header'] = 'user_admin_header';
        	$data['user_content'] = 'Staff/editSchoolStaff';
        	$this->load->view('templates/user_template', $data);
        }else{
            redirect('Login');
        }
    }
    // update staff details not used here
    public function updateStfPersonalInfo(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_stf_pers_info') == "Update"){
                $staff_id = $this->input->post('stf_id_hidden'); 
                $this->form_validation->set_rules("name_with_ini_txt","Index Number","trim|required");              
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    //$this->session->set_flashdata('msg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'stf_id' => $staff_id,
                        'name_with_ini' => $this->input->post('name_with_ini_txt'),
                        'full_name' => $this->input->post('fullname_txt'),
                        'nick_name' => $this->input->post('nick_name_txt'),
                        'address1' => $this->input->post('address1_txt'),
                        'address2' => $this->input->post('address2_txt'),
                        'nic_no' => $this->input->post('nic_txt'),
                        'dob' => $this->input->post('dob_txt'),
                        'religion_id' => $this->input->post('religion_select'),
                        'ethnic_group_id' => $this->input->post('ethnicity_select'),
                        'gender_id' => $this->input->post('gender_select'),
                        'civil_status_id' => $this->input->post('civil_status_select'),
                        'phone_mobile1' => $this->input->post('phone1_txt'),
                        'phone_mobile2' => $this->input->post('phone2_txt'),
                        'phone_home' => $this->input->post('phoneHome_txt'),
                        'email' => $this->input->post('email_txt'),
                        'vehicle_no1' => $this->input->post('vehicle1_txt'),
                        'vehicle_no2' => $this->input->post('vehicle2_txt'),
                        'edu_q_id' => $this->input->post('high_edu_select'),
                        'prof_q_id' => $this->input->post('prof_edu_select'),
                        'date_added' => $this->input->post('dateadded_txt'),
                        'date_updated' => $now,
                        'is_deleted' => $this->input->post('is_deleted'),
                    );      
                    $result = $this->Staff_model->update_staff($data);
                    if($result){
                        $this->session->set_flashdata('updateSuccessMsg', array('text' => 'Staff details updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('updateErrorMsg', array('text' => 'Staff not updated!!!','class' => 'alert alert-danger','update'=>'false'));
                    }
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                    //redirect("Staff/viewEditStaffViewAfterUpdate/");
                }
            }else{
               	$this->viewEditStaffViewAfterUpdate($staff_id);
            }
        }else{
            redirect('Login');
        }
    } 
    // update staff service infomation
    public function updateStfServInfo(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_stf_serv_info') == "Update"){
                $staff_id = $this->input->post('stf_id_hidden'); 
                $f_app_dt = $this->input->post('f_app_dt_txt'); 
                $this->form_validation->set_rules("f_app_dt_txt","First appoinment date","trim|required");              
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    //$this->session->set_flashdata('msg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'stf_id' => $staff_id,
                        'first_app_dt' => $f_app_dt,
                        'stf_type_id' => $this->input->post('emp_type_select'),
                        'app_sub_cat_id' => $this->input->post('app_sub_cat_select'),
                        'subj_med_id' => $this->input->post('app_medium_select'),
                        'serv_grd_id' => $this->input->post('serv_gr_select'),
                        'date_updated' => $now,
                    );      
                    $result = $this->Staff_model->update_staff($data);
                    if($result){
                        $this->session->set_flashdata('servInfoUpdateSuccessMsg', array('text' => 'Staff details updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('servInfoUpdateErrorMsg', array('text' => 'Staff not updated!!!','class' => 'alert alert-danger','update'=>'false'));
                    }
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                    //redirect("Staff/viewEditStaffViewAfterUpdate/");
                }
            }else{
               	$this->viewEditStaffViewAfterUpdate($staff_id);
            }
        }else{
            redirect('Login');
        }
    }
    // update school information
    public function updateSchoolInfo(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_stf_school_info') == "Update"){
                $staff_id = $this->input->post('stf_id_hidden'); 
                $this->form_validation->set_rules("school_select","School","trim|required");               
                //$this->form_validation->set_rules("class_select","Class","trim|required");               
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'School name field is required!','class' => 'alert alert-danger'));
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'stf_id' => $staff_id,
                        'census_id' => $this->input->post('school_select'),
                		'stf_no' => $this->input->post('stf_no_txt'), 
                		'salary_no' => $this->input->post('salary_no_txt'),
                		'start_dt_this_sch' => $this->input->post('start_this_dt_txt'),
                		// = $this->input->post('salary_no_txt'); 
                        'desig_id' => $this->input->post('desig_select'),
                        'stf_status_id' => $this->input->post('job_status_select'),
                        'sec_id' => $this->input->post('section_select'),
                        'sec_role_id' => $this->input->post('section_role_select'),
                       	'involved_task_id' => $this->input->post('task_inv_select'),
                        'date_updated' => $now
                    );      
                    $result = $this->Staff_model->update_staff($data);
                    if($result){
                        $this->session->set_flashdata('schInfoUpdateSuccessMsg', array('text' => 'School details updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('schInfoUpdateErrorMsg', array('text' => 'School details not updated!!!','class' => 'alert alert-danger','update'=>'false'));
                    }
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                    //redirect("Staff/viewEditStaffViewAfterUpdate/");
                }
            }else{
               	$this->viewEditStaffViewAfterUpdate($staff_id);
            }
        }else{
            redirect('Login');
        }
    }
    // Load staff update page 
    public function editStaffView(){ 
        if(is_logged_in()){
            $stf_id = $this->uri->segment(3);
            $condition = 'st.stf_id="'.$stf_id.'" ';
            $stf_result = $this->Staff_model->get_stf_by_condition($condition);
            //print_r($stf_result); die();
            $stf_grd_cls_info = $this->Staff_model->get_stf_grd_cls($stf_id);
            $stf_game_info = $this->Staff_model->get_stf_game_info($stf_id);
            $stf_ext_cur_info = $this->Staff_model->get_stf_ectra_curri_info($stf_id);
            //print_r($stf_grd_cls_info); die();
            $data['stf_result'] = $stf_result;
            $data['stf_grd_cls_info'] = $stf_grd_cls_info;            
            $data['stf_game_info'] = $stf_game_info;
            $data['stf_ext_cur_info'] = $stf_ext_cur_info;            
            $data['title'] = 'Staff Update';
            $data['user_header'] = 'user_admin_header';
        	$data['user_content'] = 'Staff/editSchoolStaff';
        	$this->load->view('templates/user_template', $data);
        }else{
            redirect('Login');
        }
    }
     // add a new grade and class for a teacher
    public function AssignToNewGradeClass(){
        if(is_logged_in()){
            $this->form_validation->set_rules("grade_select","Grade","trim|required");
            $this->form_validation->set_rules("class_select","Class","trim|required");
            $this->form_validation->set_rules("class_role_select","Role","trim|required");
            $stfId = $this->input->post('stf_no_hidden');
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('gradeClassMsg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                $this->viewEditStaffViewAfterUpdate($stfId);
                //redirect('Staff/viewAcademicStaff');
            }else{
                $stfId = $this->input->post('stf_no_hidden');
                $sectionId = $this->input->post('section_no_hidden');
                $gradeId = $this->input->post('grade_select');
                $classId = $this->input->post('class_select');
                $clsRoleId = $this->input->post('class_role_select');
                $grdclsExists = $this->Staff_model->check_gc_exists($stfId,$gradeId,$classId,$clsRoleId);
                if(!$grdclsExists){
                    if($clsRoleId==3){
                        $clsTeacherExists = $this->Staff_model->check_cls_tr_exists($gradeId,$classId,$clsRoleId);
                        if($clsTeacherExists){
                            $this->session->set_flashdata('gradeClassMsg', array('text' => 'The class teacher already exists for this class','class' => 'alert alert-danger'));
                            $this->viewEditStaffViewAfterUpdate($stfId);
                        }
                    }
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'stf_grd_cls_id' => '',
                        'stf_id' => $this->input->post('stf_no_hidden'),
                        'grade_id' => $this->input->post('grade_select'),
                        'class_id' => $this->input->post('class_select'),
                        'sec_role_id' => $this->input->post('class_role_select'),
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    $result = $this->Staff_model->set_stf_grd_cls($data);
                    if($result){
                        $this->session->set_flashdata('gradeClassMsg', array('text' => 'Grade and Class set successfully','class' => 'alert alert-success'));
                    }
                }else{
                    $this->session->set_flashdata('gradeClassMsg', array('text' => 'This is already exists!!!','class' => 'alert alert-danger'));
                }
                $this->viewEditStaffViewAfterUpdate($stfId);
            }
        }
    }
    // Loading Staff grade class update page 
    public function editStaffGradeClassView(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $stfId = $this->uri->segment(4);
            $gc_result = $this->Staff_model->get_stf_grd_cls_by_id($id);
            $data['gc_result'] = $gc_result;
            $data['title'] = 'Staff Grade Class Update';
            $this->load->view('user_header',$data);
            $this->load->view('staff/editStaffGradeClass');
            $this->load->view('user_footer');
        }else{
            redirect('Login');
        }
    } 
    // Update staff grade class details 
    public function editStaffGradeClass(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_stf_gc') == "Update"){  
                    $stfId = $this->input->post('stf_id_hidden');
                    $gradeId = $this->input->post('grade_select');
                    $classId = $this->input->post('class_select');
                    $clsRoleId = $this->input->post('class_role_select');      //die();                 
                    $grdclsExists = $this->Staff_model->check_gc_exists($stfId,$gradeId,$classId,$clsRoleId);
                    if(!$grdclsExists){
                        if($clsRoleId==3){
                            $clsTeacherExists = $this->Staff_model->check_cls_tr_exists($gradeId,$classId,$clsRoleId);
                            if($clsTeacherExists){
                                $this->session->set_flashdata('gradeClassMsg', array('text' => 'The class teacher already exists for this class','class' => 'alert alert-danger'));
                                $this->viewEditStaffViewAfterUpdate($stfId);
                            }
                        }
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'stf_grd_cls_id' => $this->input->post('stf_gc_id_hidden'),
                            'stf_id' => $this->input->post('stf_id_hidden'),
                            'grade_id' => $this->input->post('grade_select'),
                            'class_id' => $this->input->post('class_select'),
                            'sec_role_id' => $this->input->post('class_role_select'),                        
                            'date_added' => $this->input->post('date_added_hidden'),
                            'date_updated' => $now,
                            'is_deleted' => '',
                        ); 
                        $result = $this->Staff_model->update_stf_grd_cls($data);
                        $stfId = $this->input->post('stf_id_hidden');
                        if($result){
                            $this->session->set_flashdata('gradeClassMsg', array('text' => 'Staff grade and class updated successfully','class' => 'alert alert-success','update'=>'true'));
                        }else{
                            $this->session->set_flashdata('gradeClassMsg', array('text' => 'Staff grade and class not updated!!!','class' => 'alert alert-danger','update'=>'false'));
                        }
                    }else{
                        $this->session->set_flashdata('gradeClassMsg', array('text' => 'This is already exists!!!','class' => 'alert alert-danger'));
                    }
                    $this->viewEditStaffViewAfterUpdate($stfId);
            }else{
                $this->viewEditStaffViewAfterUpdate($stfId);
            }
        }else{
            redirect('Login');
        }
    }   
    // this method loaded by this construct method to view all schools
    public function view_all_schools(){ 
        return $this->Common_model->get_all_schools();
    }
    // this method loaded by this construct method to view all grades
    public function view_all_grades(){ 
        return $this->Common_model->get_all_grades();
    }
    // this method loaded by this construct method to view all classes in db
    public function view_all_classes(){
        return $this->Common_model->get_all_classes();
    }
    // this method loaded by this construct method to view all classes in db
    public function view_all_sections(){
        return $this->Common_model->get_all_sections();
    }
    // this method loaded by this construct method to view all classes in db
    public function view_all_section_roles(){
        return $this->Common_model->get_all_section_roles();
    }
    // this method loaded by this construct method to view all religion in db
    public function view_all_religion(){
        return $this->Common_model->get_all_religion();
    }
    // this method loaded by this construct method to view all religion in db
    public function view_all_ethnic_groups(){
        return $this->Common_model->get_all_ethnic_groups();
    }
    // this method loaded by this construct method to view available civil status in db
    public function view_all_civil_status(){
        return $this->Common_model->get_all_civil_status();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_service_grades(){
        return $this->Common_model->get_all_service_grades();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_task_involved(){
        return $this->Common_model->get_all_task_involved();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_edu_qual(){
        return $this->Common_model->get_all_edu_qual();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_prof_qual(){
        return $this->Common_model->get_all_prof_qual();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_appointment_category(){
        return $this->Common_model->get_all_appointment_category();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_appointment_sub_category(){
        return $this->Common_model->get_all_appointment_sub_category();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_subj_medium(){
        return $this->Common_model->get_all_appointment_medium();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_designations(){
        return $this->Common_model->get_all_designations();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_stf_types(){
        return $this->Common_model->get_all_stf_types();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_stf_status(){
        return $this->Common_model->get_all_stf_status();
    }
    // this method loaded by this construct method to view all staff count in db gender wise for staff index bar chart
    public function view_all_school_staff_count_schoolwise(){
        $st_data = $this->Staff_model->count_staff_schoolwise();
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
                $data['data'][] = $row->no_of_staff;
                $data['date_updated'][] = $last_update_date;
            }  
        }
        return(json_encode($data));
    }
    // this method loaded by this construct method to view all staff count in db gender wise for staff index pie chart
    public function view_all_school_staff_count_genderwise(){
        $stf_data = $this->Staff_model->count_staff_genderwise();
        if(!empty($stf_data)){
            $data = [];
            foreach($stf_data as $row) {
                $data['gender'][] = $row->gender_name;
                $data['stf_count'][] = $row->stf_count;
            }
            return(json_encode($data));
        }
        return(json_encode($data));
    }
    // this method loaded by this construct method to view all staff count in db gender wise for staff index pie chart
    public function view_staff_count_genderwise(){ // if the user is school
		$censusId = $this->session->userdata['census_id']; 
		$stf_data = $this->Staff_model->count_staff_genderwise($censusId); 
		//print_r($stf_data);die();
        if(!empty($stf_data)){
            $data = [];
            foreach($stf_data as $row) {
                $data['gender'][] = $row->gender_name;
                $data['stf_count'][] = $row->stf_count;
            }
            return(json_encode($data));
        }
        return(json_encode($data));
    }
    public function viewAllStaff(){
        if(is_logged_in()){
            $userrole = $this->session->userdata['userrole'];
            if($userrole == 'School User'){ // if the user is school, then staff details must be displayed by census id
                $censusId = $this->session->userdata['census_id'];
                $condition = "'census_id','$censusId'";
                $staffDetails = $this->Staff_model->get_stf_by_condition($condition); 
            }else{

                $staffDetails = $this->Staff_model->get_all_academic_staff(); 
            }
	        if(!$staffDetails){
	            $this->session->set_flashdata('no_staff_info', array('text' => 'No records found!!!','class' => 'alert alert-danger'));
	        }else{
	            $data['staff_info_by_census'] = $staffDetails;
	        }
            $data['title'] = 'Staff Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'staff/viewStaff';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
   
    // delete item from the database table
    public function deleteStaff(){
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Staff_model->delete_staff($id);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Staff member deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Staff member couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            redirect("Staff/viewSchoolStaff");
        }else{
            redirect('Login');
        }
    }
    // delete item from the database table
    public function deleteStaffGrdClsInfo(){
        if(is_logged_in()){
            $id = $this->uri->segment(3); // grade_class_info_id
            $stfId = $this->uri->segment(4);   // staff_id      
            $result = $this->Staff_model->delete_staff_grd_cls_info($id);
            if($result){
                $this->session->set_flashdata('gradeClassMsg', array('text' => 'Staff class deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('gradeClassMsg', array('text' => 'Staff class couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            $this->viewEditStaffViewAfterUpdate($stfId);      
        }else{
            redirect('Login');
        }
    }
    // increments
    public function viewIncrementInfo(){
        if(is_logged_in()){
        	$this->load->model('Increment_model');
        	$month = date("m"); // get the current month
        	$condition1 = 'month(st.first_app_dt) <= "'.$month.'" ';	// next month to be ignored
        	$all_teachers = $this->Staff_model->get_stf_by_condition($condition1); // find all teacher of staff_tbl whos month of first app date is less than or equal to current month, bcz next month to be avoided
        	//print_r($all_teachers); die();
        	foreach ($all_teachers as $teacher) {
        		$stfId = $teacher->stf_id;
        		$app_date = $teacher->first_app_dt;
        		//$this->Increment_model->get_stf_increment_not_submit($stfId);
        		if($this->Increment_model->get_stf_increment_not_submit($stfId)){
            		$condition = 'st.stf_id = "'.$stfId.'" ';
        			$increment_data[] = $this->Staff_model->get_stf_by_condition($condition);
        		}
        	}
        	//print_r($increment_data); 
        	$from = date("m-d"); // get the current date
        	$to = date('m-d', strtotime(' + 30 days')); // add 30 days to current date
        	$condition2 = 'date_format(st.first_app_dt,"%m-%d") >= "'.$from.'" and date_format(st.first_app_dt,"%m-%d") <= "'.$to.'" ';  // "%m-%d" means picking only month and day from first appoinment date
        	$coming_salary_increments = $this->Staff_model->get_stf_by_condition($condition2);
        	//print_r($coming_salary_increments); die();
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
}