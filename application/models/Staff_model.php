<?php
class Staff_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }


    public function get_stf_by_condition($condition){
        $this->db->select('*, st.stf_id as staff_id, st.address1 as stf_address1, st.address2 as stf_address2, st.date_added as stf_date_added, st.date_updated as last_update, st.is_deleted as stf_is_deleted, ');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id','left'); // gender 
        $this->db->join('gender_tbl gt','st.gender_id = gt.gender_id','left'); // gender 
        $this->db->join('civil_status_tbl cv','st.civil_status_id = cv.civil_status_id','left'); //civil status
        $this->db->join('ethnic_group_tbl egt','st.ethnic_group_id = egt.ethnic_group_id','left'); // ethnic group
        $this->db->join('religion_tbl rt','st.religion_id = rt.religion_id','left');   // religion             
        $this->db->join('edu_quali_tbl edu','st.edu_q_id = edu.edu_q_id','left');       // edu. qualifi
        $this->db->join('prof_quali_tbl prof','st.prof_q_id = prof.prof_q_id','left');  // prof. qualifi
        $this->db->join('designation_tbl des','st.desig_id = des.desig_id','left');     // designation
        $this->db->join('service_grade_tbl serv','st.serv_grd_id = serv.serv_grd_id','left');   // service grade
        $this->db->join('staff_type_tbl stt','st.stf_type_id = stt.stf_type_id','left');        // staff type
        $this->db->join('staff_status_tbl sst','st.stf_status_id = sst.stf_status_id','left');  // status
        $this->db->join('involved_task_tbl inv','st.involved_task_id = inv.involved_task_id','left'); // task
        $this->db->join('subject_medium_tbl smt','st.subj_med_id = smt.subj_med_id','left');         // app sub cat
            
        //$this->db->join('staff_grade_class_tbl stgct','st.stf_id = stgct.stf_id','left');
        //$this->db->join('grade_tbl grdt','stgct.grade_id = grdt.grade_id','left');
        //$this->db->join('class_tbl clst','stgct.class_id = clst.class_id','left');
        $this->db->join('section_tbl sec','st.sec_id = sec.section_id','left');             // section
        $this->db->join('section_role_tbl secrt','st.sec_role_id = secrt.sec_role_id','left');             // section
        $this->db->join('appointment_sub_cat_tbl asct','st.app_sub_cat_id = asct.app_sub_cat_id','left');  // app sub cat
        $this->db->join('appointment_cat_tbl act','asct.app_cat_id = act.app_cat_id','left');
        $this->db->where($condition);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //print_r($query->result()); die();
            return $query->result();
        } else {
            return false;
        }  
    }
    public function count_staff_schoolwise(){
        $this->db->select('sdt.sch_name, st.census_id, count(st.census_id) as no_of_staff, max(st.date_updated) as date_updated');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id','left');
        $this->db->group_by('st.census_id'); 
        $this->db->order_by('st.census_id','asc');  
        if($this->session->userdata['userrole'] == 'School User'){
            $census_id = $this->session->userdata['census_id'];
            $this->db->where('st.census_id',$census_id);
        }      
        $query = $this->db->get();      
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    public function count_staff_genderwise(){
        $this->db->select('gt.gender_name,count(st.gender_id) as stf_count');
        $this->db->from('staff_tbl st');
        $this->db->join('gender_tbl gt','st.gender_id = gt.gender_id','left');
        if($this->session->userdata['userrole'] == 'School User'){
            $census_id = $this->session->userdata['census_id'];
            $this->db->where('st.census_id',$census_id);
        }
        $this->db->group_by('st.gender_id'); 
        $this->db->order_by('st.gender_id','asc');         
        $query = $this->db->get();      
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }

    public function get_all_academic_staff(){
        $this->db->select('*, st.stf_id as staff_id, st.date_added as stf_date_added, st.date_updated as last_update, st.is_deleted as stf_is_deleted');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id','left'); // school 
        $this->db->join('gender_tbl gt','st.gender_id = gt.gender_id','left'); // gender 
        $this->db->join('civil_status_tbl cv','st.civil_status_id = cv.civil_status_id','left'); //civil status
        $this->db->join('ethnic_group_tbl egt','st.ethnic_group_id = egt.ethnic_group_id','left'); // ethnic group
        $this->db->join('religion_tbl rt','st.religion_id = rt.religion_id','left');   // religion             
        $this->db->join('edu_quali_tbl edu','st.edu_q_id = edu.edu_q_id','left');       // edu. qualifi
        $this->db->join('prof_quali_tbl prof','st.prof_q_id = prof.prof_q_id','left');  // prof. qualifi
        $this->db->join('designation_tbl des','st.desig_id = des.desig_id','left');     // designation
        $this->db->join('service_grade_tbl serv','st.serv_grd_id = serv.serv_grd_id','left');   // service grade
        $this->db->join('staff_type_tbl stt','st.stf_type_id = stt.stf_type_id','left');        // staff type
        $this->db->join('staff_status_tbl sst','st.stf_status_id = sst.stf_status_id','left');  // status
        $this->db->join('involved_task_tbl inv','st.involved_task_id = inv.involved_task_id','left'); // task
        $this->db->join('stf_app_sub_cat_tbl sasct','st.stf_id = sasct.stf_id','left');         // app sub cat
        $this->db->join('subject_medium_tbl smt','st.subj_med_id = smt.subj_med_id','left');         // subject medium
            
        //$this->db->join('staff_grade_class_tbl stgct','st.stf_id = stgct.stf_id','left');   // grade class
        //$this->db->join('grade_tbl grdt','stgct.grade_id = grdt.grade_id','left');          // grade
        //$this->db->join('class_tbl clst','stgct.class_id = clst.class_id','left');          // class
        //$this->db->join('section_role_tbl secrt2','stgct.sec_role_id = secrt2.sec_role_id','left'); 
        //$this->db->where('st.stf_id','5');  
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        } 
    }
    function check_gc_exists($stf_id,$grd_id,$cls_id,$role_id){ // check grade and class already exists for a staff member
        $this->db->select('*');
        $this->db->from('staff_grade_class_tbl');
        $this->db->where('stf_id',$stf_id)->where('grade_id',$grd_id)->where('class_id',$cls_id)->where('sec_role_id',$role_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return false;
        }
    }
    function check_cls_tr_exists($grd_id,$cls_id,$role_id){ // check class teacher already exists
        $this->db->select('*');
        $this->db->from('staff_grade_class_tbl');
        $this->db->where('grade_id',$grd_id)->where('class_id',$cls_id)->where('sec_role_id',$role_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return false;
        }
    }
    function check_exCstf_exists($stf_id,$exc_id,$exc_role_id){ // check staff extra curri. info already exists
        $this->db->select('*');
        $this->db->from('staff_extra_curri_tbl');
        $this->db->where('stf_id',$stf_id)->where('extra_curri_id',$exc_id)->where('ex_cu_role_id',$exc_role_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_stf_grd_cls($stf_id){ // by staff id
        $this->db->select('*');
        $this->db->from('staff_grade_class_tbl stfgct');
        //$this->db->join('staff_game_tbl stfgt','stf.stf_id = stfgt.stf_id','left');
        //$this->db->join('staff_game_tbl stfgt','stf.stf_id = stfgt.stf_id','left');
        $this->db->join('grade_tbl gt','stfgct.grade_id = gt.grade_id','left');
        $this->db->join('class_tbl ct','stfgct.class_id = ct.class_id','left');
        $this->db->join('section_role_tbl srt','stfgct.sec_role_id = srt.sec_role_id','left');
        $this->db->where('stfgct.stf_id',$stf_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_stf_grd_cls_by_id($id){ // according to stf_grd_cls_id
        $this->db->select('*');
        $this->db->from('staff_grade_class_tbl stfgct');
        //$this->db->join('staff_game_tbl stfgt','stf.stf_id = stfgt.stf_id','left');
        $this->db->join('grade_tbl gt','stfgct.grade_id = gt.grade_id','left');
        $this->db->join('class_tbl ct','stfgct.class_id = ct.class_id','left');
        $this->db->join('section_role_tbl srt','stfgct.sec_role_id = srt.sec_role_id','left');
        $this->db->join('staff_tbl stf','stfgct.stf_id = stf.stf_id','left');
        $this->db->where('stfgct.stf_grd_cls_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function set_stf_grd_cls($data){
        $this->db->insert('staff_grade_class_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    public function update_stf_grd_cls($data){
        $id = $data['stf_grd_cls_id'];
        $this->db->where('stf_grd_cls_id',$id);
        $this->db->update('staff_grade_class_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    public function get_non_academic_staff(){
        $this->db->select('*');
        $this->db->from('staff_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

   	function insert_staff($data){
        $this->db->insert('staff_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    function check_staff_exists($nic){
        $this->db->select('*');
        $this->db->from('staff_tbl');
        $this->db->where('nic_no',$nic);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return false;
        }
    }
    function update_staff($data){
        $id = $data['stf_id'];
        $this->db->where('stf_id',$id);
        $this->db->update('staff_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function delete_staff($id){ // id is staff id
        $this->db->where('stf_id',$id);
        $this->db->delete('staff_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function delete_staff_grd_cls_info($id){ // id is index number
        $this->db->where('stf_grd_cls_id',$id);
        $this->db->delete('staff_grade_class_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function get_stf_game_info($stf_id){
        $this->db->select('*');
        //$this->db->from('staff_tbl stf');
        $this->db->from('staff_game_tbl stfgt');
        //$this->db->join('staff_game_tbl stfgt','stf.stf_id = stfgt.stf_id','left');
        //$this->db->join('staff_game_tbl stfgt','stf.stf_id = stfgt.stf_id','left');
        $this->db->join('games_tbl gt','stfgt.game_id = gt.game_id','left');
        $this->db->join('game_roles_tbl grt','stfgt.gm_role_id = grt.gm_role_id','left');
        $this->db->where('stfgt.stf_id',$stf_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_stf_ectra_curri_info($stf_id){
        $this->db->select('*');
        //$this->db->from('staff_tbl stf');
        $this->db->from('staff_extra_curri_tbl stfect');
        //$this->db->join('staff_game_tbl stfgt','stf.stf_id = stfgt.stf_id','left');
        //$this->db->join('staff_game_tbl stfgt','stf.stf_id = stfgt.stf_id','left');
        $this->db->join('extra_curri_tbl ect','stfect.extra_curri_id = ect.extra_curri_id','left');
        $this->db->join('extra_curri_role_tbl ecrt','stfect.ex_cu_role_id = ecrt.ex_cu_role_id','left');
        $this->db->where('stfect.stf_id',$stf_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_academic_staff_(){
        $this->db->select('*');
        $this->db->from('staff_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}

?>