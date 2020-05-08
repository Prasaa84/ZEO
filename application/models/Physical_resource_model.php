<?php
class Physical_resource_model extends CI_Model{

        public function __construct(){
            parent::__construct();
        }

        function add_new_item($data){
            $this->db->insert('physical_res_category_tbl', $data);
            if($this->db->affected_rows()>0){
                return true;
            }else{
                return false;
            }
        }

        function view_item_by_id($id){
            $condition = "phy_res_cat_id='".$id."' ";
            $this->db->select('*');
            $this->db->from('physical_res_category_tbl');
            $this->db->where($condition);
            $this->db->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        }
        
        public function view_all_items(){
            $this->db->select('*');
            $this->db->from('physical_res_category_tbl');
            $this->db->order_by('phy_res_cat_id');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        }

        // this is called by view_recent_item_update_dt() in PhysicalResource controller
        // to view the date/time of recent updation
        function view_recent_item_update_dt(){
            $this->db->select('*');
            $this->db->from('physical_res_category_tbl');
            $this->db->limit(1);
            $this->db->order_by("date_updated","DESC");
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result_array();
            } else {
                return false;
            }
        }

        function update_item($data){
            $item_id = $data['phy_res_cat_id'];
            $this->db->where('phy_res_cat_id',$item_id);
            $this->db->update('physical_res_category_tbl',$data); 
            if($this->db->affected_rows() > 0){         
                return true; 
            }else{
                return false; 
            }
        }

        function delete_item($id){
            $this->db->where('phy_res_cat_id',$id);
            $this->db->delete('physical_res_category_tbl');
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }

        function add_new_status($data){
            $this->db->insert('physical_res_status_tbl', $data);
            if($this->db->affected_rows()>0){
                return true;
            }else{
                return false;
            }        
        }
        
        public function view_all_status(){
            $this->db->select('*');
            $this->db->from('physical_res_status_tbl');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        }
        function view_status_by_id($id){
            $condition = "phy_res_status_id='".$id."' ";
            $this->db->select('*');
            $this->db->from('physical_res_status_tbl');
            $this->db->where($condition);
            $this->db->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return false;
            }
        }
        // ajax call to view status in addphysicalresourcepage
        function view_status_by_condition($condition){
            $this->db->select('*');
            $this->db->from('physical_res_status_tbl');
            $this->db->where($condition);
            $query = $this->db->get();
            return $query->result();
        }

        function update_status($data){
            $status_id = $data['phy_res_status_id'];
            $this->db->where('phy_res_status_id',$status_id);
            $this->db->update('physical_res_status_tbl',$data); 
            if($this->db->affected_rows() > 0){         
                return true; 
            }else{
                return false; 
            }
        }

        function view_recent_status_update_dt(){
            $this->db->select('*');
            $this->db->from('physical_res_status_tbl');
            $this->db->limit(1);
            $this->db->order_by("date_updated","DESC");
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result_array();
            } else {
                return false;
            }
        }

        function delete_status($id){
            $this->db->where('phy_res_status_id',$id);
            $this->db->delete('physical_res_status_tbl');
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }

        function check_item_status_details_exists($census_id,$item_id){
            $condition = "census_id = $census_id and phy_res_cat_id = $item_id";
            $this->db->select('*');
            $this->db->from('physical_res_details_tbl');
            $this->db->where($condition);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            } else {
                return false;
            }
        }

        function add_new_phy_res_details($data){
            $this->db->insert('physical_res_details_tbl', $data);
            if($this->db->affected_rows()>0){
                return true;
            }else{
                return false;
            }        
        }

        function view_recent_item_status_update_dt($data){
            $condition = $data;
            $this->db->select('*');
            $this->db->from('physical_res_details_tbl');
            $this->db->where($condition);
            $this->db->limit(1);
            $this->db->order_by("date_updated","DESC");
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            } else {
                return false;
            }
        }

        function view_item_status_by_census_id($census_id){
            $this->db->select('*');
            $this->db->from('physical_res_details_tbl prdt');
            $this->db->join('school_details_tbl','prdt.census_id = school_details_tbl.census_id');
            $this->db->join('physical_res_category_tbl','prdt.phy_res_cat_id = physical_res_category_tbl.phy_res_cat_id','left');
            $this->db->join('physical_res_status_tbl','prdt.phy_res_status_id = physical_res_status_tbl.phy_res_status_id','left');
            $this->db->where('prdt.census_id',$census_id);
            $this->db->order_by('prdt.phy_res_cat_id');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }  
        }

        function get_logged_school_phy_res_info($userid){
            $this->db->select('*');
            $this->db->from('physical_res_details_tbl');
            $this->db->join('school_details_tbl','physical_res_details_tbl.census_id = school_details_tbl.census_id');
            $this->db->join('physical_res_category_tbl','physical_res_details_tbl.phy_res_cat_id = physical_res_category_tbl.phy_res_cat_id');
            $this->db->join('physical_res_status_tbl','physical_res_details_tbl.phy_res_status_id = physical_res_status_tbl.phy_res_status_id');
            $this->db->where('physical_res_details_tbl.census_id',$census_id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }   
        }

        function view_item_status_details_by_id($id){ // according to physical resource details id 
            $this->db->select('*,physical_res_details_tbl.date_added as details_date_added,physical_res_details_tbl.date_updated as details_date_updated');
            $this->db->from('physical_res_details_tbl');
            $this->db->join('school_details_tbl','physical_res_details_tbl.census_id = school_details_tbl.census_id');
            $this->db->join('physical_res_category_tbl','physical_res_details_tbl.phy_res_cat_id = physical_res_category_tbl.phy_res_cat_id');
            $this->db->join('physical_res_status_tbl','physical_res_details_tbl.phy_res_status_id = physical_res_status_tbl.phy_res_status_id','left');
            $this->db->where('physical_res_details_tbl.phy_res_detail_id',$id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }  
        }
        function view_item_status_details_all_schools(){ // all schools physical resource details summery 
            $this->db->select('prdt.census_id,sch_name,sch_type_id,prdt.phy_res_detail_id,prct.phy_res_cat_id,prst.phy_res_status_type,prdt.phy_res_status_id,prdt.date_updated as details_date_updated');
            $this->db->from('physical_res_details_tbl prdt');
            $this->db->join('school_details_tbl sdt','prdt.census_id = sdt.census_id');
            $this->db->join('physical_res_category_tbl prct','prdt.phy_res_cat_id = prct.phy_res_cat_id');
            $this->db->join('physical_res_status_tbl prst','prdt.phy_res_status_id = prst.phy_res_status_id');
            $this->db->order_by('prdt.census_id')->order_by('prdt.phy_res_cat_id');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }  
        }
        function find_all_school_details_by_item_status(){ // all schools'details according to physical resource status. this is used to display school census id, name and school type in the all schools physical resource summery report 
            $this->db->select('sdt.census_id,sdt.sch_name,sdt.sch_type_id');
            $this->db->from('school_details_tbl sdt');
            $this->db->join('physical_res_details_tbl prdt','sdt.census_id = prdt.census_id');
            $this->db->join('physical_res_category_tbl prct','prdt.phy_res_cat_id = prct.phy_res_cat_id');
            $this->db->join('physical_res_status_tbl prst','prdt.phy_res_status_id = prst.phy_res_status_id');
            $this->db->order_by('prdt.census_id');
            $this->db->group_by('prdt.census_id');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }  
        }
        // all schools physical resource details summery education division wise
        function view_item_status_details_all_schools_div_wise($edu_div_id){ 
            $this->db->select('prdt.census_id,sch_name,sch_type_id,prdt.phy_res_detail_id,prct.phy_res_cat_id,prst.phy_res_status_type,prdt.phy_res_status_id,prdt.date_updated as details_date_updated');
            $this->db->from('physical_res_details_tbl prdt');
            $this->db->join('school_details_tbl sdt','prdt.census_id = sdt.census_id');
            $this->db->join('physical_res_category_tbl prct','prdt.phy_res_cat_id = prct.phy_res_cat_id');
            $this->db->join('physical_res_status_tbl prst','prdt.phy_res_status_id = prst.phy_res_status_id');
            $this->db->join('edu_devision_tbl edt','sdt.edu_div_id = edt.edu_div_id');            
            $this->db->where('sdt.edu_div_id',$edu_div_id);
            $this->db->order_by('prdt.census_id')->order_by('prdt.phy_res_cat_id');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }  
        }
        // all schools physical resource details summery education division wise
        function find_all_school_details_by_item_status_div_wise($edu_div_id){ // all schools'details according to physical resource status. this is used to display school census id, name and school type in the all schools physical resource summery report 
            $this->db->select('sdt.census_id,sdt.sch_name,sdt.sch_type_id');
            $this->db->from('school_details_tbl sdt');
            $this->db->join('physical_res_details_tbl prdt','sdt.census_id = prdt.census_id');
            $this->db->join('physical_res_category_tbl prct','prdt.phy_res_cat_id = prct.phy_res_cat_id');
            $this->db->join('physical_res_status_tbl prst','prdt.phy_res_status_id = prst.phy_res_status_id');
            $this->db->join('edu_devision_tbl edt','sdt.edu_div_id = edt.edu_div_id');            
            $this->db->where('sdt.edu_div_id',$edu_div_id);
            $this->db->order_by('prdt.census_id');
            $this->db->group_by('prdt.census_id');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }  
        }
        public function view_count_item_status_details_all_schools(){
            $this->db->select('census_id,count(*) as status_count');
            $this->db->from('physical_res_details_tbl');
            $this->db->group_by('census_id');
            $this->db->order_by('census_id');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
        // following method shows schools according to item status
        // admin and zonal user need to view schools according to resource status
        function view_schools_by_item_status($cat_id,$status_id){
            $this->db->select('*,prdt.date_updated as details_date_added');
            $this->db->from('school_details_tbl as sdt','physical_res_details_tbl as prdt','physical_res_category_tbl as prct','physical_res_status_tbl as prst','school_type_tbl as stt','edu_devision_tbl as edt','gs_devision_tbl as gsdt');
            $this->db->join('school_type_tbl as stt','sdt.sch_type_id = stt.sch_type_id','left');
            $this->db->join('edu_devision_tbl as edt','sdt.edu_div_id = edt.edu_div_id','left');
            $this->db->join('gs_devision_tbl as gsdt','sdt.gs_div_id = gsdt.gs_div_id','left');
            $this->db->join('physical_res_details_tbl as prdt','sdt.census_id = prdt.census_id');
            $this->db->join('physical_res_category_tbl as prct','prdt.phy_res_cat_id = prct.phy_res_cat_id');
            $this->db->join('physical_res_status_tbl as prst','prdt.phy_res_status_id = prst.phy_res_status_id');
            $this->db->where('prdt.phy_res_cat_id',$cat_id)->where('prdt.phy_res_status_id',$status_id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }  
        }
        // following method shows schools according to item status
        function view_school_name_by_item_status($cat_id,$status_id){
            $this->db->select('sdt.census_id,sdt.sch_name,prdt.date_added as details_date_added,prdt.date_updated as details_date_updated,stt.sch_type');
            $this->db->from('physical_res_details_tbl prdt');
            $this->db->join('school_details_tbl sdt','prdt.census_id = sdt.census_id');
            $this->db->join('physical_res_category_tbl prct','prdt.phy_res_cat_id = prct.phy_res_cat_id');
            $this->db->join('physical_res_status_tbl prst','prdt.phy_res_status_id = prst.phy_res_status_id');
            $this->db->join('school_type_tbl stt','sdt.sch_type_id = stt.sch_type_id');
            $this->db->join('edu_devision_tbl edt','sdt.edu_div_id = edt.edu_div_id');
            $this->db->where('prdt.phy_res_cat_id',$cat_id)->where('prdt.phy_res_status_id',$status_id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }  
        }
        //following method counts schools according to item status
        function count_sch_by_phy_res_status($cat_id,$status_id){
            $this->db->select('count(*) as count');
            $this->db->from('physical_res_details_tbl');
            $this->db->join('school_details_tbl','physical_res_details_tbl.census_id = school_details_tbl.census_id');
            $this->db->join('physical_res_category_tbl','physical_res_details_tbl.phy_res_cat_id = physical_res_category_tbl.phy_res_cat_id');
            $this->db->join('physical_res_status_tbl','physical_res_details_tbl.phy_res_status_id = physical_res_status_tbl.phy_res_status_id');
            $this->db->join('school_type_tbl','school_details_tbl.sch_type_id = school_type_tbl.sch_type_id');
            $this->db->join('edu_devision_tbl','school_details_tbl.edu_div_id = edu_devision_tbl.edu_div_id');
            $this->db->where('physical_res_details_tbl.phy_res_cat_id',$cat_id)->where('physical_res_details_tbl.phy_res_status_id',$status_id);
            $this->db->group_by(array("physical_res_details_tbl.phy_res_cat_id", "physical_res_details_tbl.phy_res_status_id"));
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }  
        }
        function update_item_status_details($data){
            //print_r($data); die();
            //$condition = "phy_res_cat_id = ".$data['phy_res_cat_id'];
            $phy_res_detail_id = $data['phy_res_detail_id'];
            //echo $item_id; die();
            $this->db->where('phy_res_detail_id',$phy_res_detail_id);
            $this->db->update('physical_res_details_tbl',$data); 
            if($this->db->affected_rows() > 0){         
                return true; 
            }else{
                return false; 
            }
        }

    function delete_item_status_details($id){
        $this->db->where('phy_res_detail_id',$id);
        $this->db->delete('physical_res_details_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used for header notifications
    function get_short_phy_res_details($census_id){
        $items = $this->get_count_all_phy_res_items(); // get number of items
        if($items){
            $this->db->select('*');
            $this->db->from('physical_res_details_tbl');
            $this->db->where('physical_res_details_tbl.census_id',$census_id);
            $query = $this->db->get();
            $details = $query->num_rows();
            if($details < $items) {
                // every school must have physical resource details equal to number of items
                // other wise difference must be shown as a notification
                return $items - $details;
            } else {
                return false;
            }   
        }
    }
    // used for header notifications
    function get_count_all_phy_res_items(){
        $this->db->select('*');
        $this->db->from('physical_res_category_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }

    }
}