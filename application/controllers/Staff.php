<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Subject_model');
        $this->load->model('Common_model');
        $this->all_grades = $this->view_all_grades();
        $this->all_classes = $this->view_all_classes();
        $this->all_schools = $this->view_all_schools();
        $this->all_section_roles = $this->view_all_section_roles();
        $this->all_religion = $this->view_all_religion();
        $this->all_ethnic_groups = $this->view_all_ethnic_groups();
        $this->all_civil_status = $this->view_all_civil_status();
        $this->all_genders = $this->view_all_genders();
        $this->all_service_grades = $this->view_all_service_grades();
        $this->all_tasks_involved = $this->view_all_task_involved();
        $this->all_task_types = $this->view_all_task_types();
        $this->all_edu_qual = $this->view_all_edu_qual();
        $this->all_prof_qual = $this->view_all_prof_qual();
        $this->all_appoint_types = $this->view_all_appointment_types();
        $this->all_appoint_subjects = $this->view_all_appointment_subjects();
        $this->all_subj_medium = $this->view_all_subj_medium();
        $this->all_designations = $this->view_all_designations();
        $this->all_staff_status = $this->view_all_stf_status();
        $this->all_stf_types = $this->view_all_stf_types();
        $this->all_sections = $this->view_all_sections();
        $this->all_service_status = $this->view_all_service_status();
        $this->all_province = $this->view_all_province();
        $this->all_zones = $this->view_all_zones();
        $this->all_subjects = $this->view_all_subjects();
        $this->all_extra_curri = $this->Common_model->get_all_extra_curri();
        $this->all_extra_curri_roles = $this->Common_model->get_all_extra_curri_roles();
        if (is_logged_in()) {
            $this->userrole = $this->session->userdata['userrole'];
            $this->userrole_id = $this->session->userdata['userrole_id'];
        }
    }
    // view staff details page
    public function index()
    {
        if (is_logged_in()) {

            $role_id = $this->session->userdata['userrole_id'];

            if ($role_id == '2') { // if the user is grade 9 must be displayed by census id
                $censusId = $this->session->userdata['census_id'];
                $condition = 'st.census_id = "' . $censusId . '" ';
                $acStaffDetails = $this->Staff_model->get_stf_by_condition($condition);
            } else {
                $acStaffDetails = $this->Staff_model->get_all_academic_staff();
            }
            if (!$acStaffDetails) {
                $this->session->set_flashdata('no_staff_info', array('text' => 'No records found!!!', 'class' => 'alert alert-danger'));
            } else {
                $data['staff_count_schoolwise'] = $this->view_all_school_staff_count_schoolwise();
                $data['acStaffDetails'] = $acStaffDetails;
            }
            $data['title'] = 'Academic Staff Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'staff/index';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('User');
        }
    }
    // view staff not updated to current month yet
    public function notUpdated()
    {
        if (is_logged_in()) {

            $role_id = $this->session->userdata['userrole_id'];

            if ($role_id == '2') { // if the user is school
                $censusId = $this->session->userdata['census_id'];
            } else {
                $censusId = '';
            }
            $stfNotUpdated  = $this->Staff_model->get_staff_not_updated_yet($censusId);
            if (!$stfNotUpdated) {
                $this->session->set_flashdata('no_staff_info', array('text' => 'No records found!!!, Staff is upto date', 'class' => 'alert alert-success'));
            } else {
                $data['staff_not_updated_count'] = $this->view_all_school_staff_count_schoolwise(); // for staf index view
                $data['staff_not_updated'] = $stfNotUpdated;
            }
            $data['title'] = 'Staff Not Updated to This Month';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'staff/staff_not_updated';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('User');
        }
    }
    // view staff count school wise page
    public function viewStaffCount()
    {
        if (is_logged_in()) {
            $role_id = $this->session->userdata['userrole_id'];
            $month = date('m');
            if ($role_id != '2') { // if the user is school, then staff details must be displayed by census id
                $staff_count_schoolwise = $this->view_all_school_staff_count_schoolwise(); // for staf index view
            }
            if (!$staff_count_schoolwise) {
                $this->session->set_flashdata('no_staff_info', array('text' => 'No records found!!!', 'class' => 'alert alert-danger'));
            } else {
                $data['staff_count_schoolwise'] = $staff_count_schoolwise;
            }
            $data['title'] = 'Academic Staff Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'staff/staff_count_school_wise';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('User');
        }
    }

    // get count of staff not updated to current month
    public function countStaffNotUpdatedToCurrentMonth()
    {
        echo $this->Staff_model->get_count_of_staff_not_updated();
    }

    // view staff reports generating page
    public function staffReportsView()
    {
        if (is_logged_in()) {
            $stf_all_info = $this->Staff_model->get_all_academic_staff();
            //print_r($stf_serv_status); die();
            $data['stf_all_info'] = $stf_all_info;
            $data['title'] = 'Staff Reports';
            if ($this->userrole_id == '3') { // edu. divisional user
                $data['user_header'] = 'user_zeo_header';
            } elseif ($this->userrole_id == '7') { // edu. divisional user
                $data['user_header'] = 'user_edu_division_header';
            } elseif ($this->userrole_id == '8') { // zonal file user
                $data['user_header'] = 'user_zonal_file_header';
            } elseif ($this->userrole_id == '9') { // zonal salary user
                $data['user_header'] = 'user_zonal_salary_header';
            } else {
                $data['user_header'] = 'user_admin_header';
            }
            $data['user_content'] = 'staff/staff_reports';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('User');
        }
    }

    // view staff update status in staff_reports view
    public function ViewStaffUpdateStatus()
    {
        if (is_logged_in()) {
            if ($this->input->post('stf_update_search_btn') == "View") {

                $this->form_validation->set_rules("school_txt", "School", "trim|required");
                $this->form_validation->set_rules("year_select", "Year", "trim|required");
                $this->form_validation->set_rules("month_select", "Month", "trim|required");

                if ($this->form_validation->run() == FALSE) {
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'School, Year and Month are required!', 'class' => 'alert alert-danger'));
                    redirect('Staff/staffReportsView');
                } else {

                    $censusId = $this->input->post('census_id_hidden');
                    $year = $this->input->post('year_select');
                    $month = $this->input->post('month_select');
                    $result = $this->Staff_model->get_staff_by_monthly_update($censusId, $year, $month);
                    print_r($result);
                    die();
                }
            } else {
                redirect('User');
            }
        } else {
            redirect('User');
        }
    }

    // this is used in increment controller. when nic is typed find name and school
    public function findStaffByNic()
    {
        $year = date("Y");
        $output = array();
        $nic = $_POST['nic']; //die();
        $condition = 'st.nic_no = "' . $nic . '" ';
        $result = $this->Staff_model->get_stf_by_condition($condition);
        if (!empty($result)) {
            foreach ($result as $row) {
                $output['stf_id'] = $row->stf_id;
                $output['stf_name'] = $row->name_with_ini;
                $output['census_id'] = $row->census_id;
                $output['sch_name'] = $row->sch_name;
                $first_app_date = strtotime($row->first_app_dt);
                //$inc_date = date("m-j",$first_app_date);           // remove year from the date to make this year increment date
                $inc_date = date("m-d", $first_app_date);
                //die();
                $inc_date = $year . '-' . $inc_date;                   // add current year to make increment date
                $output['inc_date'] = $inc_date;
            }
        } else {
            $output = '';
        }
        echo json_encode($output);
    }
    // this is used by admin in inserting school grades (grades index view)
    public function viewStaffSchoolWise()
    {
        $censusId = $_POST['census_id'];
        $data = $this->Staff_model->get_all_academic_staff_school_wise($censusId);
        echo json_encode($data);
    }
    // used in staff_reports view
    public function viewStaffTaskWise()
    {
        if (is_logged_in()) {
            if ($this->input->post('btn_view_by_task') == "Task") {
                $task_id = $this->input->post('task_id_select');
                $result = $this->Staff_model->get_academic_staff_taskwise($task_id);
                //print_r($result); die();
                if ($this->userrole_id == '3') { // edu. divisional user
                    $data['user_header'] = 'user_zeo_header';
                } elseif ($this->userrole_id == '7') { // edu. divisional user
                    $data['user_header'] = 'user_edu_division_header';
                } elseif ($this->userrole_id == '8') { // zonal file user
                    $data['user_header'] = 'user_zonal_file_header';
                } elseif ($this->userrole_id == '9') { // zonal salary user
                    $data['user_header'] = 'user_zonal_salary_header';
                } else {
                    $data['user_header'] = 'user_admin_header';
                }
                $data['stf_task_info'] = $result;
                $data['title'] = 'Staff Reports';
                $data['user_content'] = 'staff/staff_reports';
                $this->load->view('templates/user_template', $data);
            } else {
                redirect('User');
            }
        } else {
            redirect('User');
        }
    }
    // used in staff_reports view, used by admin and others except school
    public function StaffReports()
    {
        if (is_logged_in()) {
            if ($this->input->post('stf_search_btn') == "View") {
                $censusId = $this->input->post('census_id_hidden');
                $serviceStatusId = $this->input->post('service_status_select');
                $serviceGradeId = $this->input->post('service_grade_select');
                $appSubjectId = $this->input->post('app_subject_select');
                $appTypeId = $this->input->post('app_type_select');
                $stfStatusId = $this->input->post('stf_status_select');
                $result = $this->Staff_model->get_staff_by($censusId, $serviceStatusId, $serviceGradeId, $appSubjectId, $appTypeId, $stfStatusId);
                //print_r($result); die();
                if (!empty($result)) {
                    $data['stf_all_info'] = $result;
                } else {
                    $data['stf_all_info'] = '';
                    $this->session->set_flashdata('msg', array('text' => 'No records found!', 'class' => 'alert alert-danger'));
                }
                if ($this->userrole_id == '3') { // edu. divisional user
                    $data['user_header'] = 'user_zeo_header';
                } elseif ($this->userrole_id == '7') { // edu. divisional user
                    $data['user_header'] = 'user_edu_division_header';
                } elseif ($this->userrole_id == '8') { // zonal file user
                    $data['user_header'] = 'user_zonal_file_header';
                } elseif ($this->userrole_id == '9') { // zonal salary user
                    $data['user_header'] = 'user_zonal_salary_header';
                } else {
                    $data['user_header'] = 'user_admin_header';
                }
                $data['title'] = 'Staff Reports';
                $data['user_content'] = 'staff/staff_reports';
                $this->load->view('templates/user_template', $data);
            } else {
                redirect('User');
            }
        } else {
            redirect('User');
        }
    }
    // update current school information of the academic staff member
    public function viewAcStaffOfAGrade()
    {
        if (is_logged_in()) {
            if ($this->input->post('stf_search_btn') == "View") {

                $this->form_validation->set_rules("year_select", "Year", "trim|required");
                $this->form_validation->set_rules("grade_select", "Grade", "trim|required");

                if ($this->form_validation->run() == FALSE) {
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Year and Grade are required!', 'class' => 'alert alert-danger'));
                    redirect('Staff/staffReportsView');
                } else {
                    $censusId = $this->input->post('census_id_hidden');
                    $year = $this->input->post('year_select');
                    $gradeId = $this->input->post('grade_select');
                    $classId = $this->input->post('class_select');
                    $result = $this->Staff_model->get_staff_of_a_grade($year, $gradeId, $classId, $censusId);
                    //print_r($result); die();
                    if ($result) {
                        $data['staff_teaching_classes_info'] = $result;
                    } else {
                        $this->session->set_flashdata('msg', array('text' => 'Teachers not found!!!', 'class' => 'alert alert-danger', 'update' => 'false'));
                    }
                    if ($this->userrole_id == '3') { // edu. divisional user
                        $data['user_header'] = 'user_zeo_header';
                    } elseif ($this->userrole_id == '7') { // edu. divisional user
                        $data['user_header'] = 'user_edu_division_header';
                    } elseif ($this->userrole_id == '8') { // zonal file user
                        $data['user_header'] = 'user_zonal_file_header';
                    } elseif ($this->userrole_id == '9') { // zonal salary user
                        $data['user_header'] = 'user_zonal_salary_header';
                    } else {
                        $data['user_header'] = 'user_admin_header';
                    }
                    $data['title'] = 'Staff Reports';
                    $data['user_content'] = 'staff/staff_reports';
                    $this->load->view('templates/user_template', $data);
                }
            } else {
                redirect('Staff/staffReportsView');
            }
        } else {
            redirect('User');
        }
    }
    // this is used in increment controller. when nic is typed find name and school
    public function viewStaffByNic()
    {
        if (is_logged_in()) {
            if ($this->input->post('btn_view_staff_by_nic') == "View") {
                $nic = $this->input->post('nic_txt');
                if ($this->userrole_id == '2') { //
                    $censusId = $this->input->post('census_id_hidden');
                    $condition = 'st.nic_no = "' . $nic . '" and st.census_id = "' . $censusId . '" ';
                } else {
                    $condition = 'st.nic_no = "' . $nic . '" ';
                }
                $result = $this->Staff_model->get_stf_by_condition($condition); // get only one person
                //print_r($result); die();
                if ($this->userrole_id == '3') { // edu. divisional user
                    $data['user_header'] = 'user_zeo_header';
                } elseif ($this->userrole_id == '7') { // edu. divisional user
                    $data['user_header'] = 'user_edu_division_header';
                } elseif ($this->userrole_id == '8') { // zonal file user
                    $data['user_header'] = 'user_zonal_file_header';
                } elseif ($this->userrole_id == '9') { // zonal salary user
                    $data['user_header'] = 'user_zonal_salary_header';
                } else {
                    $data['user_header'] = 'user_admin_header';
                }
                $data['stf_info'] = $result;
                $data['title'] = 'Staff Reports';
                $data['user_content'] = 'staff/staff_info';
                $this->load->view('templates/user_template', $data);
            } else {
                redirect('User');
            }
        } else {
            redirect('User');
        }
    }

    // add staff details
    public function addStaff()
    {
        if (is_logged_in()) {
            if ($this->input->post('btn_add_new_stf_info') == "Add_New") {
                //echo 'asdf'; die();
                $this->form_validation->set_rules("name_with_ini_txt", "Name with Initials", "trim|required");
                //$this->form_validation->set_rules("full_name_txt","Full Name","trim|required");               
                $this->form_validation->set_rules("nic_txt", "NIC number", "trim|required");
                $this->form_validation->set_rules("f_app_dt_txt", "First Appointment Date", "trim|required");
                $this->form_validation->set_rules("school_select", "School name ", "trim|required");
                //$this->form_validation->set_rules("stf_no_txt","Staff Number","trim|required");               
                $this->form_validation->set_rules("civil_status_select", "Civil Status", "trim|required");
                $this->form_validation->set_rules("gender_select", "Gender", "trim|required");
                //$this->form_validation->set_rules("section_select","Section","trim|required");               
                //$this->form_validation->set_rules("emp_type_select","Employee type","trim|required");               

                if ($this->form_validation->run() == FALSE) {
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Name with initials, NIC No, School name, First Appointment Date, Civil status and Gender fields are required!', 'class' => 'alert alert-danger'));
                    $this->index();
                } else {
                    // personal details
                    $id = '';
                    $title = $this->input->post('title_select');
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
                    $sal_incr_dt = $this->input->post('sal_incr_dt_txt'); //ok
                    $stf_type_id = $this->input->post('stf_type_select'); //ok
                    $app_type_id = $this->input->post('app_type_select');
                    $app_subject_id = $this->input->post('app_sub_select');
                    $app_medium_id = $this->input->post('app_medium_select');
                    $serv_gr_id = $this->input->post('service_grade_select'); //ok
                    $serv_gr_dt = $this->input->post('service_grd_dt_txt'); //ok
                    // School details
                    $census_id = $this->input->post('school_select');
                    $stf_no = $this->input->post('stf_no_txt');
                    $salary_no = $this->input->post('salary_no_txt');
                    $this_sch_dt = $this->input->post('this_sch_dt_txt'); //ok
                    $desig_id = $this->input->post('desig_select');
                    $app_status_id = $this->input->post('stf_status_select'); //ok  
                    $section_id = $this->input->post('section_select'); //ok
                    $sec_role_id = $this->input->post('section_role_select'); //ok
                    $cur_serv_status = $this->input->post('current_service_status_select');
                    // task info
                    $task1 = $this->input->post('task1_select'); // engaged task for long period
                    $sec1 = $this->input->post('section1_select');
                    $sub1 = $this->input->post('subject1_select'); //ok  
                    $task2 = $this->input->post('task2_select'); //ok
                    $sec2 = $this->input->post('section2_select'); //ok
                    $sub2 = $this->input->post('subject2_select');

                    if (!empty($this->input->post('province_select'))) {
                        $attached_institute = $this->input->post('province_select');
                    } else if (!empty($this->input->post('zone_select'))) {
                        $attached_institute = $this->input->post('zone_select');
                    } else if (!empty($this->input->post('attached_sch_select'))) {
                        $attached_institute = $this->input->post('attached_sch_select');
                    } else if (!empty($this->input->post('attached_institute_txt'))) {
                        $attached_institute = $this->input->post('attached_institute_txt');
                    } else {
                        $attached_institute = '';
                    }
                    $effective_date_of_status = $this->input->post('started_dt_txt');
                    $period = $this->input->post('period_txt');

                    // Image
                    $stf_image = $this->input->post('stf_image');
                    $exists = $this->Staff_model->check_staff_exists($nic);
                    if (!$exists) {
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'stf_id' => $id,
                            'title' => $title,
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
                            'vehicle_no1' => '',
                            'vehicle_no2' => '',
                            'email' => $email,
                            'edu_q_id' => $edu_q_id,
                            'prof_q_id' => $prof_q_id,
                            'desig_id' => $desig_id,
                            'serv_grd_id' => $serv_gr_id,
                            'sec_id' => $section_id,
                            'sec_role_id' => $sec_role_id,
                            'stf_type_id' => $stf_type_id,
                            'stf_status_id' => $app_status_id, // appoinment status
                            'first_app_dt' => $first_app_dt,
                            'sal_incr_dt' => $sal_incr_dt,
                            'start_dt_this_sch' => $this_sch_dt,
                            'service_status_id' => $cur_serv_status,
                            'user_id' => '',
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                            'subj_med_id' => $app_medium_id,
                            'app_type_id' => $app_type_id,
                            'app_subj_id' => $app_subject_id,
                            'stf_no' => $stf_no,
                            'salary_no' => $salary_no,
                        );
                        if (!empty($_FILES['stf_image']['name'])) {
                            //die();
                            $config['upload_path']          = './assets/uploaded/stf_images/';
                            $config['allowed_types']        = 'gif|jpg|png';
                            $config['max_size']             = 400; // 100KB
                            $config['max_width']            = 1024;
                            $config['max_height']           = 768;
                            $config['file_name']            = $this->input->post('stf_no_txt');
                            $config['overwrite']           = TRUE;

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('stf_image')) {
                                $uploadError = array('error' => $this->upload->display_errors());
                                $this->session->set_flashdata('uploadError', $uploadError);
                            } else {
                                $uploadSuccess = 'Image uploaded successfully';
                                $this->session->set_flashdata('uploadSuccess', $uploadSuccess);
                            }
                        }
                        $result = $this->Staff_model->insert_staff($data);

                        if ($result) {
                            if (!empty($serv_gr_id) && !empty($serv_gr_dt)) {
                                $stf_id = $this->Staff_model->get_staff_id($nic);
                                $serv_grd_exists = $this->Staff_model->check_serv_grd_exists($stf_id, $census_id, $serv_gr_id);
                                if (!$serv_grd_exists) {
                                    $now = date('Y-m-d H:i:s');
                                    $data = array(
                                        'stf_serv_grd_id' => '',
                                        'stf_id' => $stf_id,
                                        'census_id' => $census_id,
                                        'serv_grd_id' => $serv_gr_id,       // service grade
                                        'effective_date' => $serv_gr_dt,    // date of service grade
                                        'is_current' => '1',
                                        'date_added' => $now,
                                        'date_updated' => $now,
                                        'is_deleted' => '',
                                    );
                                    $this->Staff_model->set_stf_serv_grd($data);
                                }
                            }
                            if ($cur_serv_status) {
                                $stf_id = $this->Staff_model->get_staff_id($nic);
                                $serv_status_exists = $this->Staff_model->check_serv_status_exists($stf_id, $census_id, $cur_serv_status);

                                if (!$serv_status_exists) {
                                    $now = date('Y-m-d H:i:s');
                                    $data = array(
                                        'stf_serv_status_id' => '',
                                        'stf_id' => $stf_id,
                                        'census_id' => $census_id,
                                        'status_id' => $cur_serv_status,
                                        'institute' => $attached_institute,
                                        'effective_date' => $effective_date_of_status,
                                        'period' => $period,
                                        'is_current' => '1',
                                        'date_added' => $now,
                                        'date_updated' => $now,
                                        'is_deleted' => '',
                                    );
                                    $this->Staff_model->set_stf_serv_status($data);
                                }
                            }
                            if ($task1) {
                                $stf_id = $this->Staff_model->get_staff_id($nic);
                                $type = '1';
                                $task1_exists = $this->Staff_model->check_involved_task_exists($stf_id, $census_id, $task1, $type);

                                if (!$task1_exists) {
                                    $now = date('Y-m-d H:i:s');
                                    $data = array(
                                        'stf_inv_task_id' => '',
                                        'stf_id' => $stf_id,
                                        'census_id' => $census_id,
                                        'involved_task_type_id' => '1',
                                        'involved_task_id' => $task1,
                                        'section_id' => $sec1,
                                        'subject_id' => $sub1,
                                        'date_added' => $now,
                                        'date_updated' => $now,
                                        'is_deleted' => '',
                                    );
                                    $this->Staff_model->set_involved_task($data);
                                }
                            }
                            if ($task2) {
                                $stf_id = $this->Staff_model->get_staff_id($nic);
                                $type = '2';
                                $task2_exists = $this->Staff_model->check_involved_task_exists($stf_id, $census_id, $task2, $type);
                                if (!$task2_exists) {
                                    $now = date('Y-m-d H:i:s');
                                    $data = array(
                                        'stf_inv_task_id' => '',
                                        'stf_id' => $stf_id,
                                        'census_id' => $census_id,
                                        'involved_task_type_id' => '2',
                                        'involved_task_id' => $task2,
                                        'section_id' => $sec2,
                                        'subject_id' => $sub2,
                                        'date_added' => $now,
                                        'date_updated' => $now,
                                        'is_deleted' => '',
                                    );
                                    $this->Staff_model->set_involved_task($data);
                                }
                            }
                            $this->session->set_flashdata('msg', array('text' => 'Data added successfully', 'class' => 'alert alert-success'));
                        } else {
                            $this->session->set_flashdata('msg', array('text' => 'Error in inserting data!!!', 'class' => 'alert alert-danger'));
                        }
                    } else { //  if(!$exists){
                        $this->session->set_flashdata('msg', array('text' => 'This staff member already exists!!!', 'class' => 'alert alert-danger'));
                    }
                    redirect('Staff');
                } // if ($this->form_validation->run() == FALSE){
            } else { // if ($this->input->post('btn_add_new_stf_info') == "Add_New"){
                redirect('Staff');
            }
        } else {
            redirect('User');
        }
    }
    public function uploadStaffImage()
    {
        if ($this->input->post('btn_upload_stf_img') == 'upload_stf_image') {
            $stf_id = $this->input->post('stf_id_hidden');
            if (!empty($_FILES['stf_image']['name'])) {
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
                if (!$this->upload->do_upload('stf_image')) {
                    $uploadError = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('stfImgUploadError', $uploadError);
                } else {
                    $uploadSuccess = 'Image uploaded successfully';
                    $this->session->set_flashdata('stfImgUploadSuccess', $uploadSuccess);
                }
            } else {
                $noImageError = 'Please select the image';
                $this->session->set_flashdata('noImageError', $noImageError);
            }
            $this->viewEditStaffViewAfterUpdate($stf_id);
        }
    }
    // when insert task related information this is used 
    // insert staff view and update staff view
    public function viewSubjectsSectionWise()
    {
        $sec_id = $_POST['sec_id'];
        $data = $this->Subject_model->get_subjects_section_wise($sec_id);
        //print_r($data); die();
        echo json_encode($data);
    }
    public function viewEditStaffViewAfterUpdate($id)
    {
        if (is_logged_in()) {
            $stf_id = $id;
            $condition = 'st.stf_id="' . $stf_id . '" ';
            $stf_result = $this->Staff_model->get_stf_by_condition($condition);
            $stf_involved_task = $this->Staff_model->get_stf_involved_task_info($stf_id);
            $stf_serv_status = $this->Staff_model->get_stf_service_status($stf_id); // get service status history (All)
            //$condition = 'stfsgt.stf_id="'.$stf_id.'" ';
            $stf_serv_grd = $this->Staff_model->get_stf_serv_grd($stf_id); // all service grades
            //print_r($stf_result);die();
            $data['stf_result'] = $stf_result;
            $data['stf_serv_grd_info'] = $stf_serv_grd;
            //$data['stf_grd_cls_info'] = $stf_grd_cls_info;            
            //$data['stf_game_info'] = $stf_game_info;
            //$data['stf_ext_cur_info'] = $stf_ext_cur_info;
            $data['stf_serv_status'] = $stf_serv_status;
            $data['stf_involved_task'] = $stf_involved_task;
            $data['title'] = 'Staff Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'staff/editSchoolStaff';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('User');
        }
    }
    // update staff details not used here
    public function updateStfPersonalInfo()
    {
        if (is_logged_in()) {
            if ($this->input->post('btn_edit_stf_pers_info') == "Update") {
                $staff_id = $this->input->post('stf_id_hidden');
                $this->form_validation->set_rules("name_with_ini_txt", "Index Number", "trim|required");
                if ($this->form_validation->run() == FALSE) {
                    //validation fails
                    //$this->session->set_flashdata('msg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                } else {
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
                    if ($result) {
                        $this->session->set_flashdata('updateSuccessMsg', array('text' => 'Staff details updated successfully', 'class' => 'alert alert-success', 'update' => 'true'));
                    } else {
                        $this->session->set_flashdata('updateErrorMsg', array('text' => 'Staff not updated!!!', 'class' => 'alert alert-danger', 'update' => 'false'));
                    }
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                    //redirect("Staff/viewEditStaffViewAfterUpdate/");
                }
            } else {
                //$this->viewEditStaffViewAfterUpdate($staff_id);
                $this->index();
            }
        } else {
            redirect('User');
        }
    }
    // update staff service infomation
    public function updateStfServInfo()
    {
        if (is_logged_in()) {
            if ($this->input->post('btn_edit_stf_serv_info') == "Update") {
                $staff_id = $this->input->post('stf_id_hidden');
                $f_app_dt = $this->input->post('f_app_dt_txt');
                $this->form_validation->set_rules("f_app_dt_txt", "First appoinment date", "trim|required");
                if ($this->form_validation->run() == FALSE) {
                    //validation fails
                    //$this->session->set_flashdata('msg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                } else {
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'stf_id' => $staff_id,
                        'stf_type_id' => $this->input->post('emp_type_select'),
                        'first_app_dt' => $f_app_dt,
                        'app_type_id' => $this->input->post('app_type_select'),
                        'app_subj_id' => $this->input->post('app_subj_select'),
                        'subj_med_id' => $this->input->post('app_medium_select'),
                        'stf_status_id' => $this->input->post('stf_status_select'),
                        'serv_grd_id' => $this->input->post('serv_gr_select'),
                        'date_updated' => $now,
                    );
                    //print_r($data); die();
                    $result = $this->Staff_model->update_staff($data);
                    if ($result) {
                        // service grades are maintained in another table. therefore it must be updated
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            //'stf_serv_grd_id' => '',
                            'stf_id' => $staff_id,
                            'serv_grd_id' => $this->input->post('serv_gr_select'),       // service grade
                            'date_updated' => $now,
                        );
                        $this->Staff_model->update_stf_cur_serv_grd($data);  // update service grade history maintained table
                        $this->session->set_flashdata('servInfoUpdateSuccessMsg', array('text' => 'Staff details updated successfully', 'class' => 'alert alert-success', 'update' => 'true'));
                    } else {
                        $this->session->set_flashdata('servInfoUpdateErrorMsg', array('text' => 'Staff not updated!!!', 'class' => 'alert alert-danger', 'update' => 'false'));
                    }
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                    //redirect("Staff/viewEditStaffViewAfterUpdate/");
                }
            } else {
                $this->index();
            }
        } else {
            redirect('User');
        }
    }
    // update current school information of the academic staff member
    public function updateCurrentSchoolInfo()
    {
        if (is_logged_in()) {
            if ($this->input->post('btn_edit_stf_school_info') == "Update") {
                $staff_id = $this->input->post('stf_id_hidden');
                $this->form_validation->set_rules("school_select", "School", "trim|required");
                //$this->form_validation->set_rules("class_select","Class","trim|required");               
                if ($this->form_validation->run() == FALSE) {
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'School name field is required!', 'class' => 'alert alert-danger'));
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                } else {
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'stf_id' => $staff_id,
                        'census_id' => $this->input->post('school_select'),     // current working school can be updated
                        'stf_no' => $this->input->post('stf_no_txt'),             // staff number given by the school
                        'salary_no' => $this->input->post('salary_no_txt'),       // Number mentioned in salary sheet
                        'start_dt_this_sch' => $this->input->post('start_this_dt_txt'),
                        // = $this->input->post('salary_no_txt'); 
                        'desig_id' => $this->input->post('desig_select'),    // designation in school
                        'sec_id' => $this->input->post('section_select'),       // section in school
                        'sec_role_id' => $this->input->post('section_role_select'), // section role in the section
                        'date_updated' => $now
                    );
                    $result = $this->Staff_model->update_staff($data);
                    if ($result) {
                        $this->session->set_flashdata('schInfoUpdateSuccessMsg', array('text' => 'School details updated successfully', 'class' => 'alert alert-success', 'update' => 'true'));
                    } else {
                        $this->session->set_flashdata('schInfoUpdateErrorMsg', array('text' => 'School details not updated!!!', 'class' => 'alert alert-danger', 'update' => 'false'));
                    }
                    $this->viewEditStaffViewAfterUpdate($staff_id);
                    //redirect("Staff/viewEditStaffViewAfterUpdate/");
                }
            } else {
                $this->index();
            }
        } else {
            redirect('User');
        }
    }
    // Load staff update page 
    public function editStaffView()
    {
        if (is_logged_in()) {
            $stf_id = $this->uri->segment(3);
            $condition = 'st.stf_id="' . $stf_id . '" ';
            $stf_result = $this->Staff_model->get_stf_by_condition($condition);
            //print_r($stf_result); die();
            $stf_serv_grd = $this->Staff_model->get_stf_serv_grd($stf_id);
            //print_r($stf_serv_grd); die();
            //$stf_grd_cls_info = $this->Staff_model->get_stf_grd_cls($stf_id);
            //print_r($stf_grd_cls_info); die();
            //$stf_game_info = $this->Staff_model->get_stf_game_info($stf_id);
            //$stf_ext_cur_info = $this->Staff_model->get_stf_extra_curri_info($stf_id);
            $stf_involved_task = $this->Staff_model->get_stf_involved_task_info($stf_id);
            $stf_serv_status = $this->Staff_model->get_stf_service_status($stf_id);
            //print_r($stf_serv_status); die();
            $data['stf_result'] = $stf_result;
            $data['stf_serv_grd_info'] = $stf_serv_grd;
            //$data['stf_grd_cls_info'] = $stf_grd_cls_info;            
            //$data['stf_game_info'] = $stf_game_info;
            //$data['stf_ext_cur_info'] = $stf_ext_cur_info;
            $data['stf_serv_status'] = $stf_serv_status;
            $data['stf_involved_task'] = $stf_involved_task;
            $data['title'] = 'Staff Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'staff/editSchoolStaff';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('User');
        }
    }

    // add a new task for a teacher
    public function AssignToTask()
    {
        if (is_logged_in()) {
            $this->form_validation->set_rules("task_type_select", "Task Type", "trim|required");
            $this->form_validation->set_rules("task_select", "Task", "trim|required");
            //$this->form_validation->set_rules("class_role_select","Role","trim|required");
            $stfId = $this->input->post('stf_id_hidden');
            if ($this->form_validation->run() == FALSE) {
                //validation fails
                $this->session->set_flashdata('taskMsg', array('text' => 'Task type and task are required!', 'class' => 'alert alert-danger'));
                $this->viewEditStaffViewAfterUpdate($stfId);
            } else {
                $censusId = $this->input->post('census_id_hidden');
                $taskTypeId = $this->input->post('task_type_select');
                $taskId = $this->input->post('task_select');
                $sectionId = $this->input->post('task_section_select');
                if (!empty($sectionId)) {
                    $subjectId = $this->input->post('subject_select');
                } else {
                    $subjectId = '';
                }
                $taskTypeExists = $this->Staff_model->check_involved_task_type_exists($stfId, $censusId, $taskTypeId);
                if ($taskTypeExists) {
                    $this->session->set_flashdata('taskMsg', array('text' => 'This task type already exists for this teacher', 'class' => 'alert alert-danger'));
                    $this->viewEditStaffViewAfterUpdate($stfId);
                } else {
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'stf_inv_task_id' => '',
                        'stf_id' => $stfId,
                        'census_id' => $censusId,
                        'involved_task_type_id' => $taskTypeId,
                        'involved_task_id' => $taskId,
                        'section_id' => $sectionId,
                        'subject_id' => $subjectId,
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    $result = $this->Staff_model->set_involved_task($data);
                    if ($result) {
                        $this->session->set_flashdata('taskMsg', array('text' => 'Task was inserted successfully', 'class' => 'alert alert-success'));
                    }
                }
                $this->viewEditStaffViewAfterUpdate($stfId);
            }
        }
    }
    // add service grade to  a teacher
    public function AssignToServiceGrade()
    {
        if (is_logged_in()) {
            $this->form_validation->set_rules("serv_grd_select", "Service Grade", "trim|required");
            $this->form_validation->set_rules("serv_grd_effective_dt_txt", "Effective Date", "trim|required");
            $this->form_validation->set_rules("is_current_select", "Is current", "trim|required");
            $stfId = $this->input->post('stf_id_hidden');
            if ($this->form_validation->run() == FALSE) {
                //validation fails
                $this->session->set_flashdata('servGrdMsg', array('text' => 'All the fields are required!', 'class' => 'alert alert-danger'));
                $this->viewEditStaffViewAfterUpdate($stfId);
            } else {
                $stfId = $this->input->post('stf_id_hidden');
                $censusId = $this->input->post('census_id_hidden');
                $servGrd = $this->input->post('serv_grd_select');
                $effDate = $this->input->post('serv_grd_effective_dt_txt');
                $isCurrent = $this->input->post('is_current_select');
                $servGrdExists = $this->Staff_model->check_serv_grd_exists($stfId, $censusId, $servGrd);
                if ($servGrdExists) {
                    $this->session->set_flashdata('servGrdMsg', array('text' => 'This service grade already exists for this teacher', 'class' => 'alert alert-danger'));
                    $this->viewEditStaffViewAfterUpdate($stfId);
                } else {
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'stf_serv_grd_id' => '',
                        'stf_id' => $stfId,
                        'census_id' => $censusId,
                        'serv_grd_id' => $servGrd,
                        'effective_date' => $effDate,
                        'is_current' => $isCurrent,
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    $result = $this->Staff_model->set_stf_serv_grd($data);
                    if ($result) {
                        $this->session->set_flashdata('servGrdMsg', array('text' => 'Service Grade was inserted successfully', 'class' => 'alert alert-success'));
                    }
                }
                $this->viewEditStaffViewAfterUpdate($stfId);
            }
        }
    }
    // add current service status - used in editSchoolStaff view
    public function addCurrentServiceStatus()
    {
        if (is_logged_in()) {
            $this->form_validation->set_rules("current_service_status_select", "Current Service Status", "trim|required");
            $stfId = $this->input->post('stf_id_hidden');
            if ($this->form_validation->run() == FALSE) {
                //validation fails
                $this->session->set_flashdata('serviceStatusMsg', array('text' => 'Current Service Status is required!', 'class' => 'alert alert-danger'));
                $this->viewEditStaffViewAfterUpdate($stfId);
            } else {
                $censusId = $this->input->post('census_id_hidden');
                $curServStatus = $this->input->post('current_service_status_select');
                if (!empty($this->input->post('province_select'))) {
                    $attached_institute = $this->input->post('province_select');
                } else if (!empty($this->input->post('zone_select'))) {
                    $attached_institute = $this->input->post('zone_select');
                } else if (!empty($this->input->post('attached_sch_select'))) {
                    $attached_institute = $this->input->post('attached_sch_select');
                } else if (!empty($this->input->post('attached_institute_txt'))) {
                    $attached_institute = $this->input->post('attached_institute_txt');
                } else {
                    $attached_institute = '';
                }
                $effective_date_of_status = $this->input->post('started_dt_txt');
                $period = $this->input->post('period_txt');
                // check current service status exists (is_current==1 in Staff_model)
                $curServStatusExists = $this->Staff_model->check_serv_status_exists($stfId, $censusId, $curServStatus);
                if ($curServStatusExists) {
                    // remove current service status from the record
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'stf_id' => $stfId,
                        'is_current' => '0',
                        'date_updated' => $now
                    );
                    $this->Staff_model->update_stf_current_service_status($data);
                    //$this->session->set_flashdata('serviceStatusMsg', array('text' => 'Current service status already exists for this teacher','class' => 'alert alert-danger'));
                }
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'stf_serv_status_id' => '',
                    'stf_id' => $stfId,
                    'census_id' => $censusId,
                    'status_id' => $curServStatus,
                    'institute' => $attached_institute,
                    'effective_date' => $effective_date_of_status,
                    'period' => $period,
                    'is_current' => '1',
                    'date_added' => $now,
                    'date_updated' => $now,
                    'is_deleted' => '',
                );
                $result = $this->Staff_model->set_stf_serv_status($data);
                if ($result) {
                    $data = array(
                        'stf_id' => $stfId,
                        'service_status_id' => $curServStatus,
                        'date_updated' => $now
                    );
                    $this->Staff_model->update_staff($data); // update service status id to this service status id in staff table too
                    $this->session->set_flashdata('serviceStatusMsg', array('text' => 'Current service status was inserted successfully', 'class' => 'alert alert-success'));
                } else {
                    $this->session->set_flashdata('serviceStatusMsg', array('text' => 'Insertion failed!!!!!', 'class' => 'alert alert-danger'));
                }
                $this->viewEditStaffViewAfterUpdate($stfId);
            }
        } else {
            redirect('User');
        }
    }
    // delete task from the database table by AJAX call
    // used in staff update view
    public function deleteInvolvedTask()
    {
        if (is_logged_in()) {
            $task_id = $this->input->post('task_id');
            $result = $this->Staff_model->delete_involved_task($task_id);
            if ($result) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            redirect('User');
        }
    }
    // delete current service status from the database table by AJAX call
    // used in staff update view
    public function deleteCurrentServiceStatus()
    {
        if (is_logged_in()) {
            $status_id = $this->input->post('status_id');
            $result = $this->Staff_model->delete_service_status($status_id);
            if ($result) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            redirect('User');
        }
    }
    // delete service grade from the database table by AJAX call
    // used in staff update view
    public function deleteServiceGrade()
    {
        if (is_logged_in()) {
            $serv_grd_id = $this->input->post('serv_grd_id');
            $result = $this->Staff_model->delete_staff_service_grade_by_stf_serv_grd_id($serv_grd_id);
            if ($result) {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            redirect('User');
        }
    }
    // add a new grade and class for a teacher
    public function AssignToNewExtraCurri()
    {
        if (is_logged_in()) {
            $this->form_validation->set_rules("extra_cu_select", "Extra Curricular", "trim|required");
            $this->form_validation->set_rules("ex_curri_role_select", "Role", "trim|required");
            $stfId = $this->input->post('stf_no_hidden');
            if ($this->form_validation->run() == FALSE) {
                //echo 'hi'; die();
                //validation fails
                $this->session->set_flashdata('extCurMsg', array('text' => 'All the fields are required!', 'class' => 'alert alert-danger'));
                $this->viewEditStaffViewAfterUpdate($stfId);
            } else {
                $stfId = $this->input->post('stf_no_hidden');
                $extraCurId = $this->input->post('extra_cu_select');
                $extraCurRoleId = $this->input->post('ex_curri_role_select');
                $extraCurExists = $this->Staff_model->check_exCstf_exists($stfId, $extraCurId, $extraCurRoleId);
                if (!$extraCurExists) {
                    if ($extraCurRoleId == 1) {
                        $extraCurMic = $this->Staff_model->check_extra_curri_mic_exists($extraCurId, $extraCurRoleId);
                        if ($extraCurMic) {
                            $this->session->set_flashdata('extCurMsg', array('text' => 'The MIC already exists for this activity', 'class' => 'alert alert-danger'));
                            $this->viewEditStaffViewAfterUpdate($stfId);
                        }
                    }
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'stf_extra_curri_id' => '',
                        'stf_id' => $stfId,
                        'extra_curri_id' => $extraCurId,
                        'ex_cu_role_id' => $extraCurRoleId,
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    $result = $this->Staff_model->set_staff_extra_curri($data);
                    if ($result) {
                        $this->session->set_flashdata('extCurMsg', array('text' => 'Extra Curricular set successfully', 'class' => 'alert alert-success'));
                    }
                } else {
                    $this->session->set_flashdata('extCurMsg', array('text' => 'Teahcer already have it!!!', 'class' => 'alert alert-danger'));
                }
                $this->viewEditStaffViewAfterUpdate($stfId);
            }
        }
    }
    // used in staff edit page
    public function deleteExtraCurriInfo()
    {
        if (is_logged_in()) {
            $id = $this->uri->segment(3); // stf_extra_curri_id
            $stfId = $this->uri->segment(4);   // staff_id is used to go back after delete     
            $result = $this->Staff_model->delete_stf_extra_curri_info($id);
            if ($result) {
                $this->session->set_flashdata('gradeClassMsg', array('text' => 'Extra curricular deleted successfully', 'class' => 'alert alert-success', 'delete' => 'true'));
            } else {
                $this->session->set_flashdata('gradeClassMsg', array('text' => 'Extra curricular couldn\'t delete!!!', 'class' => 'alert alert-danger', 'delete' => 'false'));
            }
            $this->viewEditStaffViewAfterUpdate($stfId);
        } else {
            redirect('User');
        }
    }
    // add a new grade and class for a teacher
    public function AssignToNewGradeClass()
    {
        if (is_logged_in()) {
            $this->form_validation->set_rules("grade_select", "Grade", "trim|required");
            $this->form_validation->set_rules("class_select", "Class", "trim|required");
            $this->form_validation->set_rules("class_role_select", "Role", "trim|required");
            $stfId = $this->input->post('stf_no_hidden');
            if ($this->form_validation->run() == FALSE) {
                //validation fails
                $this->session->set_flashdata('gradeClassMsg', array('text' => 'All the fields are required!', 'class' => 'alert alert-danger'));
                $this->viewEditStaffViewAfterUpdate($stfId);
            } else {
                $stfId = $this->input->post('stf_no_hidden');
                $sectionId = $this->input->post('section_no_hidden');
                $gradeId = $this->input->post('grade_select');
                $classId = $this->input->post('class_select');
                $clsRoleId = $this->input->post('class_role_select');
                $grdclsExists = $this->Staff_model->check_gc_exists($stfId, $gradeId, $classId, $clsRoleId);
                if (!$grdclsExists) {
                    if ($clsRoleId == 3) {
                        $clsTeacherExists = $this->Staff_model->check_cls_tr_exists($gradeId, $classId, $clsRoleId);
                        if ($clsTeacherExists) {
                            $this->session->set_flashdata('gradeClassMsg', array('text' => 'The class teacher already exists for this class', 'class' => 'alert alert-danger'));
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
                        'year' => date('Y'),
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    $result = $this->Staff_model->set_stf_grd_cls($data);
                    if ($result) {
                        $this->session->set_flashdata('gradeClassMsg', array('text' => 'Grade and Class set successfully', 'class' => 'alert alert-success'));
                    }
                } else {
                    $this->session->set_flashdata('gradeClassMsg', array('text' => 'This is already exists!!!', 'class' => 'alert alert-danger'));
                }
                $this->viewEditStaffViewAfterUpdate($stfId);
            }
        }
    }
    // Loading Staff grade class update page 
    public function editStaffGradeClassView()
    {
        if (is_logged_in()) {
            $id = $this->uri->segment(3);
            $stfId = $this->uri->segment(4);
            $gc_result = $this->Staff_model->get_stf_grd_cls_by_id($id);
            $data['gc_result'] = $gc_result;
            $data['title'] = 'Staff Grade Class Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'staff/editStaffGradeClass';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('User');
        }
    }

    // Update staff grade class details 
    public function editStaffGradeClass()
    {
        if (is_logged_in()) {
            if ($this->input->post('btn_edit_stf_gc') == "Update") {
                $stfId = $this->input->post('stf_id_hidden');
                $gradeId = $this->input->post('grade_select');
                $classId = $this->input->post('class_select');
                $clsRoleId = $this->input->post('class_role_select');      //die();                 
                $grdclsExists = $this->Staff_model->check_gc_exists($stfId, $gradeId, $classId, $clsRoleId);
                if (!$grdclsExists) {
                    if ($clsRoleId == 3) {
                        $clsTeacherExists = $this->Staff_model->check_cls_tr_exists($gradeId, $classId, $clsRoleId);
                        if ($clsTeacherExists) {
                            $this->session->set_flashdata('gradeClassMsg', array('text' => 'The class teacher already exists for this class', 'class' => 'alert alert-danger'));
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
                    if ($result) {
                        $this->session->set_flashdata('gradeClassMsg', array('text' => 'Staff grade and class updated successfully', 'class' => 'alert alert-success', 'update' => 'true'));
                    } else {
                        $this->session->set_flashdata('gradeClassMsg', array('text' => 'Staff grade and class not updated!!!', 'class' => 'alert alert-danger', 'update' => 'false'));
                    }
                } else {
                    $this->session->set_flashdata('gradeClassMsg', array('text' => 'This is already exists!!!', 'class' => 'alert alert-danger'));
                }
                $this->viewEditStaffViewAfterUpdate($stfId);
            } else {
                //$this->viewEditStaffViewAfterUpdate($stfId);
                $this->index();
            }
        } else {
            redirect('User');
        }
    }
    // this method loaded by this construct method to view all schools
    public function view_all_schools()
    {
        return $this->Common_model->get_all_schools();
    }
    // this method loaded by this construct method to view all grades
    public function view_all_grades()
    {
        return $this->Common_model->get_all_grades();
    }
    // this method loaded by this construct method to view all classes in db
    public function view_all_classes()
    {
        return $this->Common_model->get_all_classes();
    }
    // this method loaded by this construct method to view all classes in db
    public function view_all_sections()
    {
        return $this->Common_model->get_all_sections();
    }
    // this method loaded by this construct method to view all classes in db
    public function view_all_service_status()
    {  // academic staff service status
        return $this->Common_model->get_all_service_status();
    }
    // this method loaded by this construct method to view all classes in db
    public function view_all_province()
    {  // academic staff service status
        return $this->Common_model->get_all_province();
    }
    // this method loaded by this construct method to view all classes in db
    public function view_all_zones()
    {  // academic staff service status
        return $this->Common_model->get_all_zones();
    }
    // this method loaded by this construct method to view all classes in db
    public function view_all_section_roles()
    {
        return $this->Common_model->get_all_section_roles();
    }
    // this method loaded by this construct method to view all religion in db
    public function view_all_religion()
    {
        return $this->Common_model->get_all_religion();
    }
    // this method loaded by this construct method to view all religion in db
    public function view_all_ethnic_groups()
    {
        return $this->Common_model->get_all_ethnic_groups();
    }
    // this method loaded by this construct method to view available civil status in db
    public function view_all_civil_status()
    {
        return $this->Common_model->get_all_civil_status();
    }
    // this method loaded by this construct method to view available genders in db
    public function view_all_genders()
    {
        return $this->Common_model->get_all_genders();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_service_grades()
    {
        return $this->Common_model->get_all_service_grades();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_edu_qual()
    {
        return $this->Common_model->get_all_edu_qual();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_prof_qual()
    {
        return $this->Common_model->get_all_prof_qual();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_appointment_types()
    {
        return $this->Common_model->get_all_appointment_types();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_appointment_subjects()
    {
        return $this->Common_model->get_all_appointment_subjects();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_subj_medium()
    {
        return $this->Common_model->get_all_appointment_medium();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_designations()
    {
        return $this->Common_model->get_all_designations();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_stf_types()
    {
        return $this->Common_model->get_all_stf_types();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_stf_status()
    {
        return $this->Common_model->get_all_stf_status();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_task_involved()
    {
        return $this->Common_model->get_all_tasks();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_task_types()
    {
        return $this->Common_model->get_all_taks_types();
    }
    // this method loaded by this construct method to view available service grades in db
    public function view_all_subjects()
    {
        return $this->Common_model->get_all_subjects();
    }
    // used in index method, to view staff count school wise when admin view index page
    public function view_all_school_staff_count_schoolwise()
    {
        $stf_count = $this->Staff_model->count_academic_staff_schoolwise();
        return $stf_count;
    }
    public function viewAllStaff()
    {
        if (is_logged_in()) {
            $userrole = $this->session->userdata['userrole'];
            if ($userrole == 'School User') { // if the user is school, then staff details must be displayed by census id
                $censusId = $this->session->userdata['census_id'];
                $condition = "'census_id','$censusId'";
                $staffDetails = $this->Staff_model->get_stf_by_condition($condition);
            } else {

                $staffDetails = $this->Staff_model->get_all_academic_staff();
            }
            if (!$staffDetails) {
                $this->session->set_flashdata('no_staff_info', array('text' => 'No records found!!!', 'class' => 'alert alert-danger'));
            } else {
                $data['staff_info_by_census'] = $staffDetails;
            }
            $data['title'] = 'Staff Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'staff/viewStaff';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }

    // delete teacher from the database table by AJAX call by school
    public function deleteStaff()
    {
        if (is_logged_in()) {
            $stf_id = $this->input->post('stf_id');
            $result = $this->Staff_model->delete_staff($stf_id);
            if ($result) {
                $this->Staff_model->delete_staff_service_status($stf_id);
                $this->Staff_model->delete_staff_service_grade($stf_id);
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            redirect('User');
        }
    }
    // delete item from the database table
    public function deleteStaffGrdClsInfo()
    {
        if (is_logged_in()) {
            $id = $this->uri->segment(3); // grade_class_info_id
            $stfId = $this->uri->segment(4);   // staff_id      
            $result = $this->Staff_model->delete_staff_grd_cls_info($id);
            if ($result) {
                $this->session->set_flashdata('gradeClassMsg', array('text' => 'Staff class deleted successfully', 'class' => 'alert alert-success', 'delete' => 'true'));
            } else {
                $this->session->set_flashdata('gradeClassMsg', array('text' => 'Staff class couldn\'t delete!!!', 'class' => 'alert alert-danger', 'delete' => 'false'));
            }
            $this->viewEditStaffViewAfterUpdate($stfId);
        } else {
            redirect('User');
        }
    }
    // increments
    public function viewIncrementInfo()
    {
        if (is_logged_in()) {
            $this->load->model('Increment_model');
            $month = date("m"); // get the current month
            $condition1 = 'month(st.first_app_dt) <= "' . $month . '" ';    // next month to be ignored
            $all_teachers = $this->Staff_model->get_stf_by_condition($condition1); // find all teacher of staff_tbl whos month of first app date is less than or equal to current month, bcz next month to be avoided
            //print_r($all_teachers); die();
            foreach ($all_teachers as $teacher) {
                $stfId = $teacher->stf_id;
                $app_date = $teacher->first_app_dt;
                //$this->Increment_model->get_stf_increment_not_submit($stfId);
                if ($this->Increment_model->get_stf_increment_not_submit($stfId)) {
                    $condition = 'st.stf_id = "' . $stfId . '" ';
                    $increment_data[] = $this->Staff_model->get_stf_by_condition($condition);
                }
            }
            //print_r($increment_data); 
            $from = date("m-d"); // get the current date
            $to = date('m-d', strtotime(' + 30 days')); // add 30 days to current date
            $condition2 = 'date_format(st.first_app_dt,"%m-%d") >= "' . $from . '" and date_format(st.first_app_dt,"%m-%d") <= "' . $to . '" ';  // "%m-%d" means picking only month and day from first appoinment date
            $coming_salary_increments = $this->Staff_model->get_stf_by_condition($condition2);
            //print_r($coming_salary_increments); die();
            $data['coming_salary_increments'] = $coming_salary_increments;
            $data['increment_data'] = $increment_data;
            $data['title'] = 'Increment Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'increments/index';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('User');
        }
    }
    // I think not used yet
    function printStaffInfo()
    {
        require_once("mpdf_lib/mpdf.php");
        //gives of the variable print and canvas on what id
        $html = $this->load->view('staff/staff_info', array('print' => TRUE, 'canvas' => 'canvas'), TRUE);
        $mpdf = new mPDF();
        $mpdf->WriteHTML($html);

        if ($filename == null) {
            $filename = date("Y-m-d") . '_test.pdf';
        }

        $mpdf->Output($filename, 'I');
    }
    // display find inactive students page
    // used by school user and admin
    public function viewInactiveStaff()
    {
        if (is_logged_in()) {
            $userrole_id = $this->session->userdata['userrole_id'];
            if ($userrole_id != '2') {
                $censusId = $this->input->post('school_select');
                $allSchools = $this->School_model->view_all_schools();
                $data['allSchools'] = $allSchools;
            } else { // school user
                $censusId = $this->session->userdata['census_id'];
            }
            $allInactiveStaff = $this->Student_model->get_inactive_staff($censusId);
            $data['allInactiveStaff'] = $allInactiveStaff;
            $data['title'] = 'Inactive Students';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'student/findInactiveStaff';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }
}
