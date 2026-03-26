<?php
class Sanitary_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }


    function view_item_status_by_census_id($census_id){
        $this->db->select('*,sidt.date_updated as last_update');
        $this->db->from('sanitary_item_details_tbl sidt');
        $this->db->join('school_details_tbl','sidt.census_id = school_details_tbl.census_id');
        $this->db->join('sanitary_item_tbl','sidt.san_item_id = sanitary_item_tbl.san_item_id','left');
        $this->db->where('sidt.census_id',$census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
   	function add_new_item($data){
        $this->db->insert('sanitary_item_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
   	public function view_all_items(){
        $this->db->select('*');
        $this->db->from('sanitary_item_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	function check_item_status_details_exists($census_id,$san_item_id){
	    $this->db->select('*');
	    $this->db->from('sanitary_item_details_tbl');
	    $this->db->where('census_id',$census_id)->where('san_item_id',$san_item_id);
	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	        return $query->result();
	    } else {
	        return false;
	    }
	}
   	function add_new_item_status_details($data){
        $this->db->insert('sanitary_item_details_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }        
    }
    function view_item_by_id($id){
	    $this->db->select('*');
	    $this->db->from('sanitary_item_tbl');
	    $this->db->where('san_item_id',$id);
	    $this->db->limit(1);
	    $query = $this->db->get();
	    if ($query->num_rows() > 0) {
	        return $query->result();
	    } else {
	        return false;
	    }
    }
    function update_item($data){
        $id = $data['san_item_id'];
        $this->db->where('san_item_id',$id);
        $this->db->update('sanitary_item_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function delete_item($id){
        $this->db->where('san_item_id',$id);
        $this->db->delete('sanitary_item_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // according to sanitary item details id 
    function view_item_status_details_by_id($id){ 
        $this->db->select('*,sidtbl.date_added as details_date_added,sidtbl.date_updated as details_date_updated');
        $this->db->from('sanitary_item_details_tbl sidtbl');
        $this->db->join('sanitary_item_tbl','sidtbl.san_item_id = sanitary_item_tbl.san_item_id','left');
        $this->db->join('school_details_tbl','sidtbl.census_id = school_details_tbl.census_id');
        $this->db->where('sidtbl.san_item_details_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function update_item_status_details($data){
        $san_item_details_id = $data['san_item_details_id'];
        $this->db->where('san_item_details_id',$san_item_details_id);
        $this->db->update('sanitary_item_details_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function delete_item_status_details($id){
        $this->db->where('san_item_details_id',$id);
        $this->db->delete('sanitary_item_details_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
      // used for header notifications, this will get which items to be updated for this year
    function get_shortage_of_sanitary_details($census_id,$year){
        $items = $this->get_count_all_sanitary_items(); // get number of items
        if($items){
            $this->db->select('*');
            $this->db->from('sanitary_item_details_tbl sidt');
            $this->db->where('sidt.census_id',$census_id)->where('year(sidt.date_updated)',$year);
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
     // used by get_shortage_of_com_lab_details() in this model
    function get_count_all_sanitary_items(){
        $this->db->select('*');
        $this->db->from('sanitary_item_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
}

?>