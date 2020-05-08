<?php
class Furniture_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }


    function view_furniture_info_by_census_id($census_id){
        $this->db->select('*,fict.date_updated as last_update');
        $this->db->from('furniture_item_count_tbl fict');
        $this->db->join('school_details_tbl','fict.census_id = school_details_tbl.census_id');
        $this->db->join('furniture_item_tbl','fict.fur_item_id = furniture_item_tbl.fur_item_id');
        //$this->db->join('furniture_item_status_tbl','fict.fur_item_status_id = furniture_item_status_tbl.fur_item_status_id');
        $this->db->where('fict.census_id',$census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
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
    function add_new_fur_info($data){
        $this->db->insert('furniture_item_count_tbl', $data);
        if($this->db->affected_rows()>0){
            return $this->db->insert_id();
        }else{
            return false;
        }        
    }
    public function view_all_building_cat_floor(){
        $this->db->select('*');
        $this->db->from('building_category_floor_tbl b_c_f_tbl');
        $this->db->join('building_category_tbl','b_c_f_tbl.b_cat_id = building_category_tbl.b_cat_id');
        $this->db->join('building_floor_tbl','b_c_f_tbl.b_floor_id = building_floor_tbl.b_floor_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function view_all_building_usage(){
        $this->db->select('*');
        $this->db->from('building_usage_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // add repaired building details
    function add_repaired_building_details($data){
        $this->db->insert('building_repaired_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }        
    }
    // add buildings to be repaired details
    function add_building_to_be_repaired_details($data){
        $this->db->insert('building_to_be_repaired_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }        
    }
    // add new building usage
    function add_new_building_usage($data){
        $this->db->insert('building_usage_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }        
    }
    // view details according to building usage id 
    function view_building_usage_by_id($id){ 
        $this->db->select('*');
        $this->db->from('building_usage_tbl');
        $this->db->where('b_usage_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function update_building_usage($data){
        $id = $data['b_usage_id'];
        $this->db->where('b_usage_id',$id);
        $this->db->update('building_usage_tbl',$data); 
        if($this->db->affected_rows() > 0){         
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
    function delete_item($id){
        $this->db->where('san_item_id',$id);
        $this->db->delete('sanitary_item_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // view details according to building information id 
    function view_building_info_by_id($id){ 
        $this->db->select('*,bit.date_added as details_date_added,bit.date_updated as details_date_updated');
        $this->db->from('building_info_tbl bit');
        $this->db->join('building_category_floor_tbl','bit.b_cat_floor_id = building_category_floor_tbl.b_cat_floor_id');
        $this->db->join('building_size_tbl','bit.b_size_id = building_size_tbl.b_size_id');        
        $this->db->join('building_usage_tbl','bit.b_usage_id = building_usage_tbl.b_usage_id','left');        
        $this->db->join('building_floor_tbl','building_category_floor_tbl.b_floor_id = building_floor_tbl.b_floor_id');
        $this->db->join('building_category_tbl','building_category_floor_tbl.b_cat_id = building_category_tbl.b_cat_id');
        $this->db->where('bit.b_info_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function update_building_info($data){
        $b_info_id = $data['b_info_id'];
        $this->db->where('b_info_id',$b_info_id);
        $this->db->update('building_info_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    // delete information related to a building
    function delete_building_info($id){
        $this->db->where('b_info_id',$id);
        $this->db->delete('building_info_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // delete information related to repaired building
    function delete_repaired_building_info($id){
        $this->db->where('b_info_id',$id);
        $this->db->delete('building_repaired_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // delete information related to building to be repaired
    function delete_building_to_be_repaired_info($id){
        $this->db->where('b_info_id',$id);
        $this->db->delete('building_to_be_repaired_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

?>