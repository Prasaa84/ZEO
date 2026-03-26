<?php
class YearPlan_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    function get_event($event_id){
        $this->db->select('*');
        $this->db->from('year_plan_tbl');
        $this->db->where('id',$event_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_all_events($limitNo){
        // here get all events related to only current year
        $cur_year = date("Y"); // get current year
        $this->db->select('*');
        $this->db->from('year_plan_tbl');
        $this->db->order_by('date_added','desc');
        $this->db->where('year(start_event)',$cur_year)->where('is_deleted','0');
        if(!empty($limitNo)){
            $this->db->limit($limitNo);   // limit the result
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    // used to make archive in public year plan page (events page) and also in admin news index page
    function get_event_start_date(){
        $this->db->select('start_event');
        $this->db->from('year_plan_tbl');
        $this->db->group_by('date_format(start_event,"%Y-%m")');
        $this->db->order_by('start_event','desc');
        $this->db->where('is_deleted','0');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // 
    function get_event_by_id($event_id){ 
        $this->db->select('*');
        $this->db->from('year_plan_tbl');
        $this->db->where('id',$event_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function update_event($data){
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('year_plan_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function get_event_by($condition){
        $this->db->select('*');
        $this->db->from('year_plan_tbl');
        $this->db->where($condition);
        $this->db->where('is_deleted','0');
        $this->db->order_by('date_added','desc');
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        } 
    }
    // insert new news
    function add_event($data){
        $this->db->insert('year_plan_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    function get_last_event(){ // not used
        $this->db->select('*');
        $this->db->from('year_plan_tbl');
        // $this->db->where('is_deleted',0); // auto increment of event_id and there are is_deleted = 1 also
        $this->db->order_by('date_added','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
    function delete_event($event_id,$now){
        $this->db->set('is_deleted','1'); // the event is not physically deleted from db
        $this->db->set('date_updated',$now); // the event is not physically deleted from db
        $this->db->where('id',$event_id);
        $this->db->update('year_plan_tbl');
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
}

?>