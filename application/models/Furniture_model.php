<?php
class Furniture_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }


    function view_furniture_info_by_census_id($census_id){
        $this->db->select('*,fict.date_updated as added_date,fict.date_updated as updated_date');
        $this->db->from('furniture_item_count_tbl fict');
        $this->db->join('school_details_tbl','fict.census_id = school_details_tbl.census_id');
        $this->db->join('furniture_item_tbl','fict.fur_item_id = furniture_item_tbl.fur_item_id');
        $this->db->where('fict.census_id',$census_id);
        $this->db->order_by('fict.date_updated','desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    // view details according to fur_item_count_id. used to update furniture item info individually by admin or school
    function view_furniture_info_by_id($id){ 
        $this->db->select('*,fict.date_updated as added_date,fict.date_updated as updated_date');
        $this->db->from('furniture_item_count_tbl fict');
        $this->db->join('school_details_tbl','fict.census_id = school_details_tbl.census_id');
        $this->db->join('furniture_item_tbl','fict.fur_item_id = furniture_item_tbl.fur_item_id');
        $this->db->where('fict.fur_item_count_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function update_furniture_info($data){
        $fur_item_count_id = $data['fur_item_count_id'];
        $this->db->where('fur_item_count_id',$fur_item_count_id);
        $this->db->update('furniture_item_count_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    public function view_all_items(){
        $this->db->select('*');
        $this->db->from('furniture_item_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // add new furniture item by admin
    function add_new_item($data){
        $this->db->insert('furniture_item_tbl', $data);
        if($this->db->affected_rows()>0){
            return $this->db->insert_id();
        }else{
            return false;
        }        
    }
    function check_furniture_info_exists($census_id, $fur_item_id){
        $this->db->select('*');
        $this->db->from('furniture_item_count_tbl');
        $this->db->where('census_id',$census_id)->where('fur_item_id',$fur_item_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return false;
        }
    }
    // add furniture item status by school
    function add_new_fur_info($data){
        $this->db->insert('furniture_item_count_tbl', $data);
        if($this->db->affected_rows()>0){
            return $this->db->insert_id();
        }else{
            return false;
        }        
    }
    // delete furniture item from item table
    function delete_item($id){
        $this->db->where('fur_item_id',$id);
        $this->db->delete('furniture_item_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // delete information related to a building
    function delete_furniture_info($id){
        $this->db->where('fur_item_count_id',$id);
        $this->db->delete('furniture_item_count_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used for header notifications, this will get which items to be updated for this year
    function get_shortage_of_furniture_details($census_id,$year){
        $items = $this->get_count_all_furniture_items(); // get number of items
        if($items){
            $this->db->select('*');
            $this->db->from('furniture_item_count_tbl fict');
            $this->db->where('fict.census_id',$census_id)->where('year(fict.date_updated)',$year);
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
    function get_count_all_furniture_items(){
        $this->db->select('*');
        $this->db->from('furniture_item_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }

    }
}

?>