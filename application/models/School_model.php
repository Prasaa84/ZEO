<?php
class School_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    function add_school($data){
        $this->db->insert('school_details_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    function view_school_by_id($id){ // used to check school exists when add a new school
        $this->db->select('*');
        $this->db->from('school_details_tbl');
        $this->db->where('census_id',$id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // this used by admin to edit school details
    // used to get details of a school by census id
    function view_school_data_by_id($id){ 
        $this->db->select('*,sdt.date_added as school_details_add_dt,sdt.date_updated as school_details_upd_dt,');    // school details updated date and time also
        $this->db->from('school_details_tbl sdt');
        $this->db->join('edu_devision_tbl edt','sdt.edu_div_id = edt.edu_div_id','left');
        $this->db->join('school_type_tbl stt','sdt.sch_type_id = stt.sch_type_id','left');
        $this->db->join('school_belongs_tbl sbt','sdt.belongs_to_id = sbt.belongs_to_id','left'); 
        $this->db->join('gs_devision_tbl gdt','sdt.gs_div_id = gdt.gs_div_id','left');        
        $this->db->where('sdt.census_id',$id)->where('sdt.is_deleted','0');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_logged_school($user_id){ // used when school user log and try to update school details
        $this->db->select('*,school_details_tbl.date_added as school_details_add_dt,school_details_tbl.date_updated as school_details_upd_dt,');    // school details updated date and time also
        $this->db->from('school_details_tbl');
        $this->db->join('gs_devision_tbl gdt','school_details_tbl.gs_div_id = gdt.gs_div_id','left');
        $this->db->join('edu_devision_tbl','school_details_tbl.edu_div_id = edu_devision_tbl.edu_div_id','left');
        $this->db->join('school_type_tbl','school_details_tbl.sch_type_id = school_type_tbl.sch_type_id','left');
        $this->db->join('school_belongs_tbl','school_details_tbl.belongs_to_id = school_belongs_tbl.belongs_to_id','left');        
        $this->db->where('school_details_tbl.user_id',$user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_logged_school_census_id($user_id){ 
        $this->db->select('census_id');    
        $this->db->from('school_details_tbl');
        $this->db->where('school_details_tbl.user_id',$user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function update_school($data,$id){
        $this->db->where('census_id',$id);
        $this->db->update('school_details_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function delete_school($census_id){ // when delete a school, is_deleted is set to 1
        $this->db->set('is_deleted','1'); // the school is not physically deleted from db
        $this->db->where('census_id',$census_id);
        $this->db->update('school_details_tbl');
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function view_school_data_by_division($div_id){  // this is used by users and also public user
        $div_id;
        $this->db->select('*,sdt.date_added as school_details_add_dt,sdt.date_updated as school_details_upd_dt,');    // school details updated date and time also
        $this->db->from('school_details_tbl sdt');
        $this->db->join('edu_devision_tbl edt','sdt.edu_div_id = edt.edu_div_id','left');
        $this->db->join('school_type_tbl stt','sdt.sch_type_id = stt.sch_type_id','left');
        $this->db->join('school_belongs_tbl sbt','sdt.belongs_to_id = sbt.belongs_to_id','left');  
        $this->db->join('gs_devision_tbl gdt','sdt.gs_div_id = gdt.gs_div_id','left'); 
        $this->db->where('sdt.edu_div_id',$div_id)->where('sdt.is_deleted','0');
        $this->db->order_by('sdt.census_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function view_school_data_by_type($type_id){  // this is used by users and also public user
        $this->db->select('*,sdt.date_added as school_details_add_dt,sdt.date_updated as school_details_upd_dt,');    // school details updated date and time also
        $this->db->from('school_details_tbl sdt');
        $this->db->join('edu_devision_tbl','sdt.edu_div_id = edu_devision_tbl.edu_div_id','left');
        $this->db->join('school_type_tbl','sdt.sch_type_id = school_type_tbl.sch_type_id','left');
        $this->db->join('school_belongs_tbl','sdt.belongs_to_id = school_belongs_tbl.belongs_to_id','left');
        $this->db->join('gs_devision_tbl gdt','sdt.gs_div_id = gdt.gs_div_id','left');  
        $this->db->where('sdt.sch_type_id',$type_id)->where('sdt.is_deleted','0');
        $this->db->order_by('sdt.census_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function view_all_schools(){
        $this->db->select('*, school_details_tbl.date_updated as school_details_upd_dt,');    // school details updated date and time also
        $this->db->from('school_details_tbl');
        $this->db->join('edu_devision_tbl','school_details_tbl.edu_div_id = edu_devision_tbl.edu_div_id','left');
        $this->db->join('school_type_tbl','school_details_tbl.sch_type_id = school_type_tbl.sch_type_id','left');
        $this->db->join('school_belongs_tbl','school_details_tbl.belongs_to_id = school_belongs_tbl.belongs_to_id','left');        
        $this->db->where('school_details_tbl.is_deleted','0');
        $this->db->order_by('school_details_tbl.census_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function view_national_schools(){
        $this->db->select('*, school_details_tbl.date_updated as school_details_upd_dt,');    // school details updated date and time also
        $this->db->from('school_details_tbl');
        $this->db->join('edu_devision_tbl','school_details_tbl.edu_div_id = edu_devision_tbl.edu_div_id','left');
        $this->db->join('school_type_tbl','school_details_tbl.sch_type_id = school_type_tbl.sch_type_id','left');
        $this->db->join('school_belongs_tbl','school_details_tbl.belongs_to_id = school_belongs_tbl.belongs_to_id','left');        
        $this->db->where('school_details_tbl.belongs_to_id','2')->where('school_details_tbl.is_deleted','0');
        $this->db->order_by('school_details_tbl.census_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function view_1AB_schools(){
        $this->db->select('*, school_details_tbl.date_updated as school_details_upd_dt,');    // school details updated date and time also
        $this->db->from('school_details_tbl');
        $this->db->join('edu_devision_tbl','school_details_tbl.edu_div_id = edu_devision_tbl.edu_div_id','left');
        $this->db->join('school_type_tbl','school_details_tbl.sch_type_id = school_type_tbl.sch_type_id','left');
        $this->db->join('school_belongs_tbl','school_details_tbl.belongs_to_id = school_belongs_tbl.belongs_to_id','left');        
        $this->db->where('school_details_tbl.sch_type_id','1')->where('school_details_tbl.is_deleted','0');
        $this->db->order_by('school_details_tbl.census_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function view_1C_schools(){
        $this->db->select('*, school_details_tbl.date_updated as school_details_upd_dt,');    // school details updated date and time also
        $this->db->from('school_details_tbl');
        $this->db->join('edu_devision_tbl','school_details_tbl.edu_div_id = edu_devision_tbl.edu_div_id','left');
        $this->db->join('school_type_tbl','school_details_tbl.sch_type_id = school_type_tbl.sch_type_id','left');
        $this->db->join('school_belongs_tbl','school_details_tbl.belongs_to_id = school_belongs_tbl.belongs_to_id','left');
        $this->db->where('school_details_tbl.sch_type_id','2')->where('school_details_tbl.is_deleted','0');
        $this->db->order_by('school_details_tbl.census_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function view_type2_schools(){
        $this->db->select('*, school_details_tbl.date_updated as school_details_upd_dt,');    // school details updated date and time also
        $this->db->from('school_details_tbl');
        $this->db->join('edu_devision_tbl','school_details_tbl.edu_div_id = edu_devision_tbl.edu_div_id','left');
        $this->db->join('school_type_tbl','school_details_tbl.sch_type_id = school_type_tbl.sch_type_id','left');
        $this->db->join('school_belongs_tbl','school_details_tbl.belongs_to_id = school_belongs_tbl.belongs_to_id','left');
        $this->db->where('school_details_tbl.sch_type_id','3')->where('school_details_tbl.is_deleted','0');
        $this->db->order_by('school_details_tbl.census_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function view_all_schools_order_by($order_by){
        $this->db->select('*, school_details_tbl.date_updated as school_details_upd_dt,');    // school details updated date and time also
        $this->db->from('school_details_tbl');
        $this->db->join('edu_devision_tbl','school_details_tbl.edu_div_id = edu_devision_tbl.edu_div_id','left');
        $this->db->join('school_type_tbl','school_details_tbl.sch_type_id = school_type_tbl.sch_type_id','left');
        $this->db->join('school_belongs_tbl','school_details_tbl.belongs_to_id = school_belongs_tbl.belongs_to_id','left');        
        $this->db->order_by('school_details_tbl.'.$order_by,'asc');
        $this->db->where('school_details_tbl.is_deleted','0');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        } 
    }
    // this is called by view_recent_item_update_dt() in School controller
    // to view the date/time of recent updation
    function view_recent_sch_update_dt(){
        $this->db->select('*');
        $this->db->from('school_details_tbl');
        $this->db->limit(1);
        $this->db->order_by("date_updated","DESC");
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result_array();
        } else {
            return false;
        }
    }
    function view_all_gs_divisions(){
        $this->db->select('*');
        $this->db->from('gs_devision_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function view_all_edu_divisions(){
        $this->db->select('*');
        $this->db->from('edu_devision_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function view_all_sch_types(){
        $this->db->select('*');
        $this->db->from('school_type_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function count_national_schools(){
        $this->db->select('*');
        $this->db->from('school_details_tbl');
        $this->db->where('belongs_to_id','2')->where('is_deleted','0');
        $query = $this->db->get();
        return $query->num_rows();
    }  
    // the following 4 methds are used in find school page 
    function count_1AB_schools(){
        $this->db->select('*');
        $this->db->from('school_details_tbl');
        $this->db->where('sch_type_id','1')->where('is_deleted','0');
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_1C_schools(){
        $this->db->select('*');
        $this->db->from('school_details_tbl');
        $this->db->where('sch_type_id','2')->where('is_deleted','0');
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_type2_schools(){
        $this->db->select('*');
        $this->db->from('school_details_tbl');
        $this->db->where('sch_type_id','3')->where('is_deleted','0');
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_type3_schools(){
        $this->db->select('*');
        $this->db->from('school_details_tbl');
        $this->db->where('sch_type_id','4')->where('is_deleted','0');
        $query = $this->db->get();
        return $query->num_rows();
    }
    // this method is used to count schools by sch type
    // the count data are used in pie chart in dashboard home
    function count_schools_by_type(){
        $this->db->select('school_type_tbl.sch_type,count(*) as count');
        $this->db->from('school_type_tbl');
        $this->db->join('school_details_tbl','school_type_tbl.sch_type_id = school_details_tbl.sch_type_id','left');
        $this->db->where('school_details_tbl.is_deleted','0');
        $this->db->group_by('school_type_tbl.sch_type_id');
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function find_census_by_userid($user_id){ 
        $this->db->select('census_id');    
        $this->db->from('school_details_tbl');
        $this->db->where('school_details_tbl.user_id',$user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}