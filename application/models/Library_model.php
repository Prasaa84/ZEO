<?php
class Library_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }


    function view_item_status_by_census_id($census_id){
        $this->db->select('*,lrdt.date_updated as last_update');
        $this->db->from('library_resource_details_tbl lrdt');
        $this->db->join('school_details_tbl','lrdt.census_id = school_details_tbl.census_id');
        $this->db->join('library_resource_tbl','lrdt.lib_res_id = library_resource_tbl.lib_res_id','left');
        $this->db->where('lrdt.census_id',$census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
   	function add_new_item($data){
        $this->db->insert('library_resource_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
   	public function view_all_items(){
        $this->db->select('*');
        $this->db->from('library_resource_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	function check_item_status_details_exists($census_id,$lib_res_id){
	    $this->db->select('*');
	    $this->db->from('library_resource_details_tbl');
	    $this->db->where('census_id',$census_id)->where('lib_res_id',$lib_res_id);
	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	        return $query->result();
	    } else {
	        return false;
	    }
	}
   	function add_new_lib_res_details($data){
        $this->db->insert('library_resource_details_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }        
    }
    function view_item_by_id($id){
	    $this->db->select('*');
	    $this->db->from('library_resource_tbl');
	    $this->db->where('lib_res_id',$id);
	    $this->db->limit(1);
	    $query = $this->db->get();
	    if ($query->num_rows() > 0) {
	        return $query->result();
	    } else {
	        return false;
	    }
    }
    function update_item($data){
        $id = $data['lib_res_id'];
        $this->db->where('lib_res_id',$id);
        $this->db->update('library_resource_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function delete_item($id){
        $this->db->where('lib_res_id',$id);
        $this->db->delete('library_resource_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // according to library resource details id 
    function view_item_status_details_by_id($id){ 
        $this->db->select('*,lrdtbl.date_added as details_date_added,lrdtbl.date_updated as details_date_updated');
        $this->db->from('library_resource_details_tbl lrdtbl');
        $this->db->join('library_resource_tbl','lrdtbl.lib_res_id = library_resource_tbl.lib_res_id','left');
        $this->db->join('school_details_tbl','lrdtbl.census_id = school_details_tbl.census_id');
        $this->db->where('lrdtbl.lib_res_details_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function update_item_status_details($data){
        $lib_res_details_id = $data['lib_res_details_id'];
        $this->db->where('lib_res_details_id',$lib_res_details_id);
        $this->db->update('library_resource_details_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function delete_item_status_details($id){
        $this->db->where('lib_res_details_id',$id);
        $this->db->delete('library_resource_details_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

?>