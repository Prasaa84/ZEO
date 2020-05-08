<?php
class Computer_lab_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }


    function view_item_status_by_census_id($census_id){
        $this->db->select('*,clrdt.date_updated as last_update');
        $this->db->from('computer_lab_resource_details_tbl clrdt');
        $this->db->join('school_details_tbl','clrdt.census_id = school_details_tbl.census_id');
        $this->db->join('computer_lab_resource_tbl','clrdt.com_lab_res_id = computer_lab_resource_tbl.com_lab_res_id','left');
        $this->db->where('clrdt.census_id',$census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
   	function add_new_item($data){
        $this->db->insert('computer_lab_resource_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
   	public function view_all_items(){
        $this->db->select('*');
        $this->db->from('computer_lab_resource_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	function check_item_status_details_exists($census_id,$item_id){
	    $this->db->select('*');
	    $this->db->from('computer_lab_resource_details_tbl');
	    $this->db->where('census_id',$census_id)->where('com_lab_res_id',$item_id);
	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	        return $query->result();
	    } else {
	        return false;
	    }
	}
   	function add_new_com_res_details($data){
        $this->db->insert('computer_lab_resource_details_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }        
    }
    function view_item_by_id($id){
	    $this->db->select('*');
	    $this->db->from('computer_lab_resource_tbl');
	    $this->db->where('com_lab_res_id',$id);
	    $this->db->limit(1);
	    $query = $this->db->get();
	    if ($query->num_rows() > 0) {
	        return $query->result();
	    } else {
	        return false;
	    }
    }
    function update_item($data){
        $id = $data['com_lab_res_id'];
        $this->db->where('com_lab_res_id',$id);
        $this->db->update('computer_lab_resource_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function delete_item($id){
        $this->db->where('com_lab_res_id',$id);
        $this->db->delete('computer_lab_resource_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // according to computer resource details id 
    function view_item_status_details_by_id($id){ 
        $this->db->select('*,clrdtbl.date_added as details_date_added,clrdtbl.date_updated as details_date_updated');
        $this->db->from('computer_lab_resource_details_tbl clrdtbl');
        $this->db->join('computer_lab_resource_tbl','clrdtbl.com_lab_res_id = computer_lab_resource_tbl.com_lab_res_id','left');
        $this->db->join('school_details_tbl','clrdtbl.census_id = school_details_tbl.census_id');
        $this->db->where('clrdtbl.com_lab_res_info_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function update_item_status_details($data){
        $com_lab_res_info_id = $data['com_lab_res_info_id'];
        $this->db->where('com_lab_res_info_id',$com_lab_res_info_id);
        $this->db->update('computer_lab_resource_details_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function delete_item_status_details($id){
        $this->db->where('com_lab_res_info_id',$id);
        $this->db->delete('computer_lab_resource_details_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

?>