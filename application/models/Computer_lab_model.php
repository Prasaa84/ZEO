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
        $this->db->order_by('order_id');
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
    // used for header notifications, this will get which items to be updated for this year
    function get_shortage_of_com_lab_details($census_id,$year){
        $items = $this->get_count_all_com_lab_items(); // get number of items
        if($items){
            $this->db->select('*');
            $this->db->from('computer_lab_resource_details_tbl clrdt');
            $this->db->where('clrdt.census_id',$census_id)->where('year(clrdt.date_updated)',$year);
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
    function get_count_all_com_lab_items(){
        $this->db->select('*');
        $this->db->from('computer_lab_resource_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }

    }
    function view_item_status_details_all_schools( $division='' ){ // all schools computer resource details summery 
        $this->db->select('*,clrdt.census_id,sch_name,sch_type_id,clrdt.com_lab_res_id,clrt.order_id,clrdt.date_updated as details_date_updated');
        $this->db->from('computer_lab_resource_details_tbl clrdt');
        $this->db->join('school_details_tbl sdt','clrdt.census_id = sdt.census_id');
        $this->db->join('computer_lab_resource_tbl clrt','clrdt.com_lab_res_id = clrt.com_lab_res_id');
        if( !empty($division) ){
            $this->db->where('sdt.div_id', $division);
        }
        $this->db->order_by('clrdt.census_id')->order_by('clrt.order_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    // not used yet
    function get_item_wise_total_quantity_on( $field, $division='' ){ // all schools computer resource details summery 
        if( $field == 'not_repairable' ){
            $this->db->select( 'clrdt.com_lab_res_id, (sum(clrdt.quantity)-(sum(clrdt.working)+sum(clrdt.repairable))) as total, clrt.order_id' );
        }else{
            $this->db->select( 'clrdt.com_lab_res_id, sum(clrdt.'.$field.') as total, clrt.order_id' );
        }
        $this->db->from('computer_lab_resource_details_tbl clrdt');
        // $this->db->join('school_details_tbl sdt','clrdt.census_id = sdt.census_id');
        $this->db->join('computer_lab_resource_tbl clrt','clrdt.com_lab_res_id = clrt.com_lab_res_id');

        if( !empty( $division ) ){
            $this->db->join('school_details_tbl sdt','clrdt.census_id = sdt.census_id');
            $this->db->where('sdt.div_id', $division);
        }

        $this->db->group_by('clrdt.com_lab_res_id');
        $this->db->order_by('clrt.order_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
}

?>