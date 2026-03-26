<?php
class Staff_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // used in Increment->addNewIncrement() 
    public function get_stf_by_condition($condition)
    {
        $this->db->select('*, st.stf_id as staff_id, st.address1 as stf_address1, st.address2 as stf_address2, st.email as stf_email, st.date_added as stf_date_added, st.date_updated as last_update, st.is_deleted as stf_is_deleted, ');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left'); // gender 
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left'); // gender 
        $this->db->join('civil_status_tbl cv', 'st.civil_status_id = cv.civil_status_id', 'left'); //civil status
        $this->db->join('ethnic_group_tbl egt', 'st.ethnic_group_id = egt.ethnic_group_id', 'left'); // ethnic group
        $this->db->join('religion_tbl rt', 'st.religion_id = rt.religion_id', 'left');   // religion             
        $this->db->join('edu_quali_tbl edu', 'st.edu_q_id = edu.edu_q_id', 'left');       // edu. qualifi
        $this->db->join('prof_quali_tbl prof', 'st.prof_q_id = prof.prof_q_id', 'left');  // prof. qualifi
        $this->db->join('designation_tbl des', 'st.desig_id = des.desig_id', 'left');     // designation
        $this->db->join('service_grade_tbl serv', 'st.serv_grd_id = serv.serv_grd_id', 'left');   // service grade
        $this->db->join('staff_type_tbl stt', 'st.stf_type_id = stt.stf_type_id', 'left');        // staff type
        $this->db->join('staff_status_tbl sst', 'st.stf_status_id = sst.stf_status_id', 'left');  // status
        //$this->db->join('involved_task_tbl inv','st.involved_task_id = inv.involved_task_id','left'); // task
        $this->db->join('subject_medium_tbl smt', 'st.subj_med_id = smt.subj_med_id', 'left');         // app sub cat

        //$this->db->join('staff_grade_class_tbl stgct','st.stf_id = stgct.stf_id','left');
        //$this->db->join('grade_tbl grdt','stgct.grade_id = grdt.grade_id','left');
        //$this->db->join('class_tbl clst','stgct.class_id = clst.class_id','left');
        $this->db->join('section_tbl sec', 'st.sec_id = sec.section_id', 'left');             // section
        $this->db->join('section_role_tbl secrt', 'st.sec_role_id = secrt.sec_role_id', 'left');             // section
        $this->db->join('appointment_type_tbl att', 'st.app_type_id = att.app_type_id', 'left');  // app type
        $this->db->join('appointment_subject_tbl ast', 'st.app_subj_id = ast.app_subj_id', 'left'); // app subject
        $this->db->join('service_status_tbl sest', 'st.service_status_id = sest.service_status_id', 'left'); // app subject
        $this->db->where($condition);
        $this->db->where('st.is_deleted', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //print_r($query->result()); die();
            return $query->result();
        } else {
            return false;
        }
    }

    // this will return school wise count of staff
    public function count_academic_staff_schoolwise()
    {
        //stf_count_this_month - no of teachers updated to current month
        $this->db->select('sdt.census_id, sdt.sch_name, count(st.census_id) as stf_count, COUNT(CASE WHEN MONTH(st.date_updated) = MONTH(CURRENT_DATE()) THEN 1 END) AS stf_count_this_month, max(st.date_updated) as date_updated');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left');
        if ($this->session->userdata['userrole'] == 'School User') {
            $census_id = $this->session->userdata['census_id'];
            $this->db->where('st.census_id', $census_id);
        }
        $this->db->where('st.is_deleted', 0)->where('sdt.is_deleted', 0);
        $this->db->group_by('st.census_id');
        $this->db->order_by('st.census_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // used to view staff not updated status notification in user header
    public function get_count_of_staff_not_updated()
    {
        $this->db->select('*');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left');
        if ($this->session->userdata['userrole_id'] == '2') {
            $census_id = $this->session->userdata['census_id'];
            $this->db->where('st.census_id', $census_id);
        }
        $this->db->where('st.is_deleted', 0)->where('sdt.is_deleted', 0)->where('MONTH(st.date_updated) !=', date("m"));
        if ($this->session->userdata['userrole_id'] != '2') {
            $this->db->group_by('st.census_id');
        }
        $this->db->order_by('st.census_id');
        $query = $this->db->get();
        return $query->num_rows();
    }

    // get staff who are not updated to current month
    public function get_staff_not_updated_yet($census_id = '')
    {
        $this->db->select('*, st.stf_id as staff_id, st.address1 as stf_address1, st.address2 as stf_address2, st.email as stf_email, st.date_added as stf_date_added, st.date_updated as last_update');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left'); // gender 
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left'); // gender 
        $this->db->join('civil_status_tbl cv', 'st.civil_status_id = cv.civil_status_id', 'left'); //civil status
        $this->db->join('ethnic_group_tbl egt', 'st.ethnic_group_id = egt.ethnic_group_id', 'left'); // ethnic group
        $this->db->join('religion_tbl rt', 'st.religion_id = rt.religion_id', 'left');   // religion   
        if ($census_id != '') {
            $this->db->where('st.census_id', $census_id);
        }
        $this->db->where('st.is_deleted', 0)->where('sdt.is_deleted', 0)->where('MONTH(st.date_updated) !=', date("m"));
        $this->db->order_by('st.census_id')->order_by('st.stf_id');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // all teachers gender wise, used in user dashboard page
    public function count_academic_staff_genderwise()
    {
        $this->db->select('gt.gender_name,count(st.gender_id) as stf_count');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left');
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left');
        if ($this->session->userdata['userrole'] == 'School User') {
            $census_id = $this->session->userdata['census_id'];
            $this->db->where('st.census_id', $census_id);
        } elseif ($this->session->userdata['userrole_id'] == '7') {  // if the user is edu. division user
            $edu_div_id = $this->session->userdata['div_id'];
            $this->db->where('sdt.div_id', $edu_div_id);
        }
        $this->db->where('st.is_deleted', 0)->where('sdt.is_deleted', 0);
        $this->db->group_by('st.gender_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // used in admin dashboard and edu. div user dashboard, school user dashboard 
    function count_all_academic_staff($census_id = '', $eduDivId = '')
    {
        $this->db->select('*');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left');
        if (!empty($census_id)) {
            $this->db->where('st.census_id', $census_id);
        } elseif (!empty($eduDivId)) {
            $edu_div_id = $this->session->userdata['div_id'];
            $this->db->where('sdt.div_id', $eduDivId);
        }
        $this->db->where('st.is_deleted', 0)->where('sdt.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // used in staff reports view to display all staff
    public function get_all_academic_staff()
    {
        $this->db->select('*, st.email as stf_email, st.address1 as stf_address1, st.address2 as stf_address2, st.stf_id as staff_id, st.date_added as stf_date_added, st.date_updated as last_update, st.is_deleted as stf_is_deleted');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left'); // school 
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left'); // gender 
        $this->db->join('civil_status_tbl cv', 'st.civil_status_id = cv.civil_status_id', 'left'); //civil status
        $this->db->join('ethnic_group_tbl egt', 'st.ethnic_group_id = egt.ethnic_group_id', 'left'); // ethnic group
        $this->db->join('religion_tbl rt', 'st.religion_id = rt.religion_id', 'left');   // religion             
        $this->db->join('edu_quali_tbl edu', 'st.edu_q_id = edu.edu_q_id', 'left');       // edu. qualifi
        $this->db->join('prof_quali_tbl prof', 'st.prof_q_id = prof.prof_q_id', 'left');  // prof. qualifi
        $this->db->join('designation_tbl des', 'st.desig_id = des.desig_id', 'left');     // designation
        $this->db->join('service_grade_tbl serv', 'st.serv_grd_id = serv.serv_grd_id', 'left');   // service grade
        $this->db->join('staff_type_tbl stt', 'st.stf_type_id = stt.stf_type_id', 'left');        // staff type
        $this->db->join('staff_status_tbl sst', 'st.stf_status_id = sst.stf_status_id', 'left');  // status
        $this->db->join('service_status_tbl servst', 'st.service_status_id = servst.service_status_id', 'left'); // task
        $this->db->join('appointment_type_tbl att', 'st.app_type_id = att.app_type_id', 'left');  // app type
        $this->db->join('appointment_subject_tbl ast', 'st.app_subj_id = ast.app_subj_id', 'left'); // app subject
        $this->db->join('subject_medium_tbl smt', 'st.subj_med_id = smt.subj_med_id', 'left');         // subject medium
        if ($this->session->userdata['userrole_id'] == '2') {
            $census_id = $this->session->userdata['census_id'];
            $this->db->where('st.census_id', $census_id);
        } elseif ($this->session->userdata['userrole_id'] == '7') {
            $div_id = $this->session->userdata['div_id'];
            $this->db->where('sdt.div_id', $div_id);
        }
        $this->db->order_by('sdt.census_id')->order_by('st.stf_id');
        $this->db->where('st.is_deleted', 0)->where('sdt.is_deleted', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // all teachers task wise
    public function get_academic_staff_taskwise($id)
    {
        $this->db->select('*,sitt.date_updated last_update,');
        $this->db->from('staff_involved_task_tbl sitt');
        $this->db->join('staff_tbl st', 'sitt.stf_id = st.stf_id', 'left');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left'); // school 
        $this->db->join('section_tbl sec', 'sitt.section_id = sec.section_id', 'left'); // section
        $this->db->join('subject_tbl sub', 'sitt.subject_id = sub.subject_id', 'left'); // section
        $this->db->join('appointment_subject_tbl ast', 'st.app_subj_id = ast.app_subj_id', 'left'); // app subject
        $this->db->join('involved_task_type_tbl ittt', 'sitt.involved_task_type_id = ittt.involved_task_type_id', 'left');
        $this->db->join('involved_task_tbl itt', 'sitt.involved_task_id = itt.involved_task_id', 'left');
        if ($this->session->userdata['userrole_id'] == '2') {
            $census_id = $this->session->userdata['census_id'];
            if ($id != 'All') {
                $this->db->where('sitt.involved_task_id', $id)->where('sitt.census_id', $census_id);
            } else {
                $this->db->where('sitt.census_id', $census_id);
            }
        }
        if ($this->session->userdata['userrole_id'] == '7') {
            $div_id = $this->session->userdata['div_id'];
            if ($id != 'All') {
                $this->db->where('sitt.involved_task_id', $id)->where('sdt.div_id', $div_id);
            } else {
                $this->db->where('sdt.div_id', $div_id);
            }
        } else {
            if ($id != 'All') {
                $this->db->where('sitt.involved_task_id', $id);
            }
        }
        $this->db->where('st.is_deleted', 0);
        $this->db->order_by('sitt.stf_id')->order_by('ittt.involved_task_type_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used in staff_info view to load involved tasks of a staff 
    public function get_staff_involved_task($stf_id)
    {
        $this->db->select('*,sitt.date_updated last_update,');
        $this->db->from('staff_involved_task_tbl sitt');
        $this->db->join('staff_tbl st', 'sitt.stf_id = st.stf_id');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id'); // school 
        $this->db->join('section_tbl sec', 'sitt.section_id = sec.section_id', 'left'); // section
        $this->db->join('subject_tbl sub', 'sitt.subject_id = sub.subject_id', 'left'); // subject
        $this->db->join('appointment_subject_tbl ast', 'st.app_subj_id = ast.app_subj_id'); // app subject
        $this->db->join('involved_task_type_tbl ittt', 'sitt.involved_task_type_id = ittt.involved_task_type_id', 'left');
        $this->db->join('involved_task_tbl itt', 'sitt.involved_task_id = itt.involved_task_id');
        $this->db->where('sitt.stf_id', $stf_id)->where('st.is_deleted', 0);
        $this->db->order_by('ittt.involved_task_type_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // get staff id according to nic
    public function get_staff_id($nic)
    {
        $this->db->select('stf_id');
        $this->db->from('staff_tbl');
        $this->db->where('nic_no', $nic);
        $row = $this->db->get()->row();
        if (isset($row)) {
            return $row->stf_id;
        } else {
            return false;
        }
    }
    // used when inserting staff data
    // used when updating staff data in staff update view
    function check_serv_grd_exists($stf_id, $census_id, $serv_grd_id)
    { // check Teacher's service grade already exists
        $this->db->select('*');
        $this->db->from('staff_service_grade_tbl');
        $this->db->where('stf_id', $stf_id)->where('census_id', $census_id)->where('serv_grd_id', $serv_grd_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used when inserting staff data
    // used when updating staff data in staff update view
    public function set_stf_serv_grd($data)
    { // insert teacher's service grade details
        $this->db->insert('staff_service_grade_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // this is used when deleting staff data by schools
    // stf_id is used to catch records
    function delete_staff_service_grade($id)
    { // id is stf_id
        $this->db->where('stf_id', $id);
        $this->db->delete('staff_service_grade_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // this is used when updating staff data in staff update view
    // stf_serv_grd_id is used to catch records
    function delete_staff_service_grade_by_stf_serv_grd_id($id)
    { // id is stf_serv_grd_id
        $this->db->where('stf_serv_grd_id', $id);
        $this->db->delete('staff_service_grade_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // updating teachers current service grade
    function update_stf_cur_serv_grd($data)
    {
        $id = $data['stf_id'];
        $this->db->where('stf_id', $id);
        $this->db->update('staff_service_grade_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used in inserting academic staff data
    // used in updating staff data in academic staff update view
    function check_serv_status_exists($stf_id, $census_id, $cur_serv_status_id)
    { // check Teacher's current service status already exists
        $is_current = '1';
        $this->db->select('*');
        $this->db->from('staff_service_status_tbl');
        $this->db->where('stf_id', $stf_id)->where('census_id', $census_id)->where('is_current', $is_current);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // get all service status of a teacher including current status too.
    public function get_stf_service_status($stf_id)
    { // by staff id
        $this->db->select('*');
        $this->db->from('staff_service_status_tbl stfsst');
        $this->db->join('service_status_tbl sst', 'stfsst.status_id = sst.service_status_id', 'left');
        $this->db->where('stfsst.stf_id', $stf_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // updating teachers current service status - used in addCurrentServiceStatus() in Staff controller
    function update_stf_current_service_status($data)
    {
        echo $id = $data['stf_id'];
        $this->db->set('is_current', 0);
        $this->db->set('date_updated', date('Y-m-d H:i:s'));
        $this->db->where('stf_id', $id);
        $this->db->update('staff_service_status_tbl');
        if ($this->db->affected_rows() > 0) {
            echo 'Yes';
            return true;
        } else {
            echo 'No';
            return false;
        }
    }
    // used in academic staff update view
    // used in inserting staff data
    public function set_stf_serv_status($data)
    { // insert teacher's service status details
        $this->db->insert('staff_service_status_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used in academic staff update view 
    // to delete service status using stf_serv_status_id
    function delete_service_status($id)
    { // id is stf_serv_status_id
        $this->db->where('stf_serv_status_id', $id);
        $this->db->delete('staff_service_status_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // this is used when updating data in update view
    function check_involved_task_type_exists($stf_id, $census_id, $task_type)
    { // check Teacher's first engaged task already exists
        $this->db->select('*');
        $this->db->from('staff_involved_task_tbl');
        $this->db->where('stf_id', $stf_id)->where('census_id', $census_id)->where('involved_task_type_id', $task_type);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // this is used when inserting staff data 
    function check_involved_task_exists($stf_id, $census_id, $task1, $type)
    { // check Teacher's first engaged task already exists
        $this->db->select('*');
        $this->db->from('staff_involved_task_tbl');
        $this->db->where('stf_id', $stf_id)->where('census_id', $census_id)->where('involved_task_type_id', $type)->where('involved_task_id', $task1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // this is used in inserting staff data 
    // and also in updating staff data 
    public function set_involved_task($data)
    { // insert teacher's first engaged task
        $this->db->insert('staff_involved_task_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function delete_involved_task($id)
    { // id is stf_inv_task_id
        $this->db->where('stf_inv_task_id', $id);
        $this->db->delete('staff_involved_task_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // this is used when inserting staff data 
    function check_involved_task2_exists($stf_id, $census_id, $task1)
    { // check Teacher's first engaged task already exists
        $this->db->select('*');
        $this->db->from('staff_involved_task_tbl');
        $this->db->where('stf_id', $stf_id)->where('census_id', $census_id)->where('involved_task_type_id', '2')->where('involved_task_id', $task2);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function set_involved_task2($data)
    { // insert teacher's first engaged task
        $this->db->insert('staff_involved_task_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function check_gc_exists($stf_id, $grd_id, $cls_id, $role_id)
    { // check grade and class already exists for a staff member
        $this->db->select('*');
        $this->db->from('staff_grade_class_tbl');
        $this->db->where('stf_id', $stf_id)->where('grade_id', $grd_id)->where('class_id', $cls_id)->where('sec_role_id', $role_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function check_cls_tr_exists($grd_id, $cls_id, $role_id)
    { // check class teacher already exists
        $this->db->select('*');
        $this->db->from('staff_grade_class_tbl');
        $this->db->where('grade_id', $grd_id)->where('class_id', $cls_id)->where('sec_role_id', $role_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function check_exCstf_exists($stf_id, $extra_cur_id, $extra_cur_role_id)
    { // check this teacher already has this extra curricular activity
        $this->db->select('*');
        $this->db->from('staff_extra_curri_tbl sect');
        $this->db->where('sect.stf_id', $stf_id)->where('sect.extra_curri_id', $extra_cur_id)->where('ex_cu_role_id', $extra_cur_role_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function check_extra_curri_mic_exists($extra_cur_id, $extra_cur_role_id)
    { // check mic already exists
        $this->db->select('*');
        $this->db->from('staff_extra_curri_tbl sect');
        $this->db->where('sect.extra_curri_id', $extra_cur_id)->where('sect.ex_cu_role_id', $extra_cur_role_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function set_staff_extra_curri($data)
    { // insert teacher's extra curricular activities
        $this->db->insert('staff_extra_curri_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // get extra curriculam of a teacher - used in edit staff page, staff report by nic
    public function get_stf_extra_curri_info($stf_id)
    {
        $this->db->select('*,stfect.date_updated as last_update');
        $this->db->from('staff_extra_curri_tbl stfect');
        $this->db->join('extra_curri_tbl ect', 'stfect.extra_curri_id = ect.extra_curri_id', 'left');
        $this->db->join('extra_curri_role_tbl ecrt', 'stfect.ex_cu_role_id = ecrt.ex_cu_role_id', 'left');
        $this->db->where('stfect.stf_id', $stf_id);
        $this->db->order_by('stfect.extra_curri_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used in staff edit view
    function delete_stf_extra_curri_info($id)
    { // delete teacher's extra curricular activities
        $this->db->where('stf_extra_curri_id', $id);
        $this->db->delete('staff_extra_curri_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function get_stf_serv_grd($stf_id)
    { // by staff id
        $this->db->select('*');
        $this->db->from('staff_service_grade_tbl stfsgt');
        $this->db->join('service_grade_tbl sgt', 'stfsgt.serv_grd_id = sgt.serv_grd_id', 'left');
        $this->db->where('stfsgt.stf_id', $stf_id);
        $this->db->order_by('stfsgt.effective_date');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // get teaching classes of current year 
    public function get_stf_grd_cls($stf_id)
    { // by staff id
        $this->db->select('*,stfgct.date_updated as last_update');
        $this->db->from('staff_grade_class_tbl stfgct');
        $this->db->join('grade_tbl gt', 'stfgct.grade_id = gt.grade_id', 'left');
        $this->db->join('class_tbl ct', 'stfgct.class_id = ct.class_id', 'left');
        $this->db->join('section_role_tbl srt', 'stfgct.sec_role_id = srt.sec_role_id', 'left');
        $this->db->where('stfgct.stf_id', $stf_id)->where('stfgct.year', date('Y')); // current year
        $this->db->order_by('stfgct.grade_id')->order_by('stfgct.class_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_stf_grd_cls_by_id($id)
    { // according to stf_grd_cls_id
        $this->db->select('*');
        $this->db->from('staff_grade_class_tbl stfgct');
        //$this->db->join('staff_game_tbl stfgt','stf.stf_id = stfgt.stf_id','left');
        $this->db->join('grade_tbl gt', 'stfgct.grade_id = gt.grade_id', 'left');
        $this->db->join('class_tbl ct', 'stfgct.class_id = ct.class_id', 'left');
        $this->db->join('section_role_tbl srt', 'stfgct.sec_role_id = srt.sec_role_id', 'left');
        $this->db->join('staff_tbl stf', 'stfgct.stf_id = stf.stf_id', 'left');
        $this->db->where('stfgct.stf_grd_cls_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function set_stf_grd_cls($data)
    {
        $this->db->insert('staff_grade_class_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function update_stf_grd_cls($data)
    {
        $id = $data['stf_grd_cls_id'];
        $this->db->where('stf_grd_cls_id', $id);
        $this->db->update('staff_grade_class_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function get_non_academic_staff()
    {
        $this->db->select('*');
        $this->db->from('staff_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function insert_staff($data)
    {
        $this->db->insert('staff_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function check_staff_exists($nic)
    {
        $this->db->select('*');
        $this->db->from('staff_tbl');
        $this->db->where('nic_no', $nic);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function update_staff($data)
    {
        $id = $data['stf_id'];
        $this->db->where('stf_id', $id);
        $this->db->update('staff_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // delete completely from database
    function delete_staff($id)
    { // id is staff id
        $this->db->where('stf_id', $id);
        $this->db->delete('staff_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // delete completely from database
    function delete_staff1($id)
    { // id is staff id
        $this->db->where('stf_id', $id);
        $this->db->delete('staff_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function delete_staff_service_status($id)
    { // id is staff id
        $this->db->where('stf_id', $id);
        $this->db->delete('staff_service_status_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function delete_staff_grd_cls_info($id)
    { // id is index number
        $this->db->where('stf_grd_cls_id', $id);
        $this->db->delete('staff_grade_class_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function get_stf_game_info($stf_id)
    {
        $this->db->select('*');
        //$this->db->from('staff_tbl stf');
        $this->db->from('staff_game_tbl stfgt');
        //$this->db->join('staff_game_tbl stfgt','stf.stf_id = stfgt.stf_id','left');
        //$this->db->join('staff_game_tbl stfgt','stf.stf_id = stfgt.stf_id','left');
        $this->db->join('games_tbl gt', 'stfgt.game_id = gt.game_id', 'left');
        $this->db->join('game_roles_tbl grt', 'stfgt.gm_role_id = grt.gm_role_id', 'left');
        $this->db->where('stfgt.stf_id', $stf_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used in staff update page, staff_info page (reports by nic)
    public function get_stf_involved_task_info($stf_id)
    {
        $this->db->select('*');
        $this->db->from('staff_involved_task_tbl sitt');
        $this->db->join('involved_task_tbl itt', 'sitt.involved_task_id = itt.involved_task_id', 'left');
        $this->db->join('involved_task_type_tbl ittt', 'sitt.involved_task_type_id = ittt.involved_task_type_id', 'left');
        $this->db->join('section_tbl sect', 'sitt.section_id = sect.section_id', 'left');
        $this->db->join('subject_tbl subt', 'sitt.subject_id = subt.subject_id', 'left');
        $this->db->where('sitt.stf_id', $stf_id);
        $this->db->order_by('sitt.involved_task_type_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // i think this function not used 
    public function get_all_academic_staff_()
    {
        $this->db->select('*');
        $this->db->from('staff_tbl');
        if ($this->session->userdata['userrole'] == 'School User') { // used in add grade and classes in class/index view
            $census_id = $this->session->userdata['census_id'];    // to assign grade heads of the logged school
            $this->db->where('staff_tbl.census_id', $census_id)->where('staff_tbl.is_deleted', '0');
        }
        $this->db->where('staff_tbl.is_deleted', '0');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used in inserting school grades in grades index view 
    // when search grades by admin in SchoolGrades Controller ->viewSchoolGrades
    public function get_all_academic_staff_school_wise($census_id)
    {
        $this->db->select('*');
        $this->db->from('staff_tbl');
        $this->db->where('staff_tbl.census_id', $census_id)->where('staff_tbl.is_deleted', '0');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_who_not_class_teachers($census_id)
    {
        $this->db->select('*');
        $this->db->from('staff_tbl st');
        $this->db->join('school_grade_class_tbl sgct', 'st.stf_id = sgct.stf_id', 'left'); // school 
        $this->db->where('st.census_id', $census_id)->where('st.is_deleted', '0');
        $this->db->where('sgct.sec_role_id ', '!=3');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // used in staff reports view
    public function get_staff_by_monthly_update($census_id, $year, $month)
    {
        $this->db->select('st.name_with_ini, st.nic_no, gt.gender_name, sdt.sch_name, st.date_added as stf_date_added, st.date_updated as last_update');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id'); // school 
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left'); // gender 
        $this->db->where('st.census_id', $census_id);
        $this->db->where('YEAR(st.date_updated)', $year);
        $this->db->where('MONTH(st.date_updated)', $month);
        $this->db->where('st.is_deleted', '0')->where('sdt.is_deleted', '0');
        $this->db->order_by('st.census_id')->order_by('st.stf_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used by admin and other zonal users in staff reports view
    public function get_staff_by($census_id = '', $serv_status_id = '', $serv_grd_id = '', $app_subj_id = '', $app_type_id = '', $stf_status_id = '')
    {
        $this->db->select('*, st.email as stf_email, st.address1 as stf_address1, st.address2 as stf_address2, st.stf_id as staff_id, st.date_added as stf_date_added, st.date_updated as last_update, st.is_deleted as stf_is_deleted');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left'); // school 
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left'); // gender 
        $this->db->join('civil_status_tbl cv', 'st.civil_status_id = cv.civil_status_id', 'left'); //civil status
        $this->db->join('ethnic_group_tbl egt', 'st.ethnic_group_id = egt.ethnic_group_id', 'left'); // ethnic group
        $this->db->join('religion_tbl rt', 'st.religion_id = rt.religion_id', 'left');   // religion             
        $this->db->join('edu_quali_tbl edu', 'st.edu_q_id = edu.edu_q_id', 'left');       // edu. qualifi
        $this->db->join('prof_quali_tbl prof', 'st.prof_q_id = prof.prof_q_id', 'left');  // prof. qualifi
        $this->db->join('designation_tbl des', 'st.desig_id = des.desig_id', 'left');     // designation
        $this->db->join('service_grade_tbl serv', 'st.serv_grd_id = serv.serv_grd_id', 'left');   // service grade
        $this->db->join('staff_type_tbl stt', 'st.stf_type_id = stt.stf_type_id', 'left');        // staff type
        $this->db->join('staff_status_tbl sst', 'st.stf_status_id = sst.stf_status_id', 'left');  // status
        $this->db->join('service_status_tbl servst', 'st.service_status_id = servst.service_status_id', 'left'); // task
        $this->db->join('appointment_type_tbl att', 'st.app_type_id = att.app_type_id', 'left');  // app type
        $this->db->join('appointment_subject_tbl ast', 'st.app_subj_id = ast.app_subj_id', 'left'); // app subject
        $this->db->join('subject_medium_tbl smt', 'st.subj_med_id = smt.subj_med_id', 'left');         // subject medium
        //staff_service_grade_tbl
        $year = date('Y');
        if (!empty($census_id)) {
            $this->db->where('st.census_id', $census_id);
        }
        // if the user is divisional user
        if ($this->session->userdata['userrole_id'] == 7) {
            $div_id = $this->session->userdata['div_id'];
            $this->db->where('sdt.div_id', $div_id);
        }
        if (!empty($serv_status_id)) {
            $this->db->where('st.service_status_id', $serv_status_id);
        }
        if (!empty($serv_grd_id)) {
            $this->db->where('st.serv_grd_id', $serv_grd_id);
        }
        if (!empty($app_subj_id)) {
            $this->db->where('st.app_subj_id', $app_subj_id);
        }
        if (!empty($app_type_id)) {
            $this->db->where('st.app_type_id', $app_type_id);
        }
        if (!empty($stf_status_id)) {
            $this->db->where('st.stf_status_id', $stf_status_id);
        }
        $this->db->where('st.is_deleted', '0');
        $this->db->order_by('st.census_id')->order_by('st.stf_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used by school user to view the academic staff of a grade or class
    public function get_staff_of_a_grade($year, $grade_id, $class_id = '', $census_id = '')
    {
        //echo $year.$grade_id.$class_id.$census_id; die();
        $this->db->select('*, st.email as stf_email, st.address1 as stf_address1, st.address2 as stf_address2, st.stf_id as staff_id, st.date_added as stf_date_added, st.date_updated as last_update, st.is_deleted as stf_is_deleted');

        $this->db->from('staff_grade_class_tbl sgct');
        $this->db->join('staff_tbl st', 'sgct.stf_id = st.stf_id'); // staff 
        $this->db->join('grade_tbl grdt', 'sgct.grade_id = grdt.grade_id'); // grade 
        $this->db->join('class_tbl ct', 'sgct.class_id = ct.class_id'); // class 
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id'); // school 

        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left'); // gender 
        $this->db->join('civil_status_tbl cv', 'st.civil_status_id = cv.civil_status_id', 'left'); //civil status
        $this->db->join('ethnic_group_tbl egt', 'st.ethnic_group_id = egt.ethnic_group_id', 'left'); // ethnic group
        $this->db->join('religion_tbl rt', 'st.religion_id = rt.religion_id', 'left');   // religion             
        $this->db->join('edu_quali_tbl edu', 'st.edu_q_id = edu.edu_q_id', 'left');       // edu. qualifi
        $this->db->join('prof_quali_tbl prof', 'st.prof_q_id = prof.prof_q_id', 'left');  // prof. qualifi
        $this->db->join('designation_tbl des', 'st.desig_id = des.desig_id', 'left');     // designation
        $this->db->join('service_grade_tbl serv', 'st.serv_grd_id = serv.serv_grd_id', 'left');   // service grade
        $this->db->join('staff_type_tbl stt', 'st.stf_type_id = stt.stf_type_id', 'left');        // staff type
        $this->db->join('staff_status_tbl sst', 'st.stf_status_id = sst.stf_status_id', 'left');  // status
        $this->db->join('service_status_tbl servst', 'st.service_status_id = servst.service_status_id', 'left'); // task
        $this->db->join('appointment_type_tbl att', 'st.app_type_id = att.app_type_id', 'left');  // app type
        $this->db->join('appointment_subject_tbl ast', 'st.app_subj_id = ast.app_subj_id', 'left'); // app subject
        $this->db->join('subject_medium_tbl smt', 'st.subj_med_id = smt.subj_med_id', 'left');         // subject medium
        //$year = date('Y'); 
        if (!empty($year)) {
            $this->db->where('sgct.year', $year);
        }
        if (!empty($grade_id)) {
            $this->db->where('sgct.grade_id', $grade_id);
        }
        if (!empty($class_id)) {
            $this->db->where('sgct.class_id', $class_id);
        }
        if (!empty($census_id)) {
            $this->db->where('st.census_id', $census_id);
        }
        // if the user is divisional user
        if ($this->session->userdata['userrole_id'] == 7) {
            $div_id = $this->session->userdata['div_id'];
            $this->db->where('sdt.div_id', $div_id);
        }

        $this->db->where('st.is_deleted', '0');
        $this->db->order_by('st.census_id')->order_by('st.stf_id');

        if (empty($class_id)) {
            $this->db->group_by('sgct.stf_id');
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}
