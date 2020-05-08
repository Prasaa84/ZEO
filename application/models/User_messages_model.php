<?php
class User_messages_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    public function get_message_history(){ // this is not used yet. this method is in incriment_model too. it is used in increment controller
        $this->db->select('*');
        $this->db->from('message_tbl mt');
        $this->db->join('staff_tbl st','st.stf_id = mt.stf_id'); // gender 
        $this->db->where('mt.stf_id',$sid);
        $this->db->where('mt.academic_year',$year);   
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        } 
    }
    public function get_new_message_count($condition){
        //$year = date("Y");
        $this->db->select('*');
        $this->db->from('message_tbl');
        $this->db->where('is_read','0');
        if(!empty($condition)){
            $this->db->where($condition);
        }
        $this->db->order_by('date_added');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_new_message_count_by_category($condition){
        //$year = date("Y");
        $this->db->select('mct.msg_category,count(mt.msg_cat_id) as msg_count');
        $this->db->from('message_tbl mt');
        $this->db->join('msg_category_tbl mct','mt.msg_cat_id = mct.msg_cat_id'); 
        $this->db->where('is_read','0');
        $this->db->where($condition);
        $this->db->group_by('mt.msg_cat_id');
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        } 
    }
    public function get_all_new_messages_by($condition){
        $this->db->select('*,mt.date_added as send_date');
        $this->db->from('message_tbl mt');
        $this->db->join('msg_category_tbl mct','mt.msg_cat_id = mct.msg_cat_id'); 
        $this->db->join('staff_tbl st','mt.stf_id = st.stf_id','left');
        $this->db->join('school_details_tbl sdt','mt.to_whom = sdt.census_id','left');
        $this->db->join('user_role_tbl urt','mt.to_whom = urt.role_id','left');
        $this->db->where($condition);   
        //$this->db->where('mt.is_read','0'); 
        $this->db->order_by('mt.date_added','desc');  
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        } 
    }
    public function get_message_by_id($id){
        $this->db->select('*,mt.date_added as send_date');
        $this->db->from('message_tbl mt');
        $this->db->join('msg_category_tbl mct','mt.msg_cat_id = mct.msg_cat_id'); 
        $this->db->where('mt.msg_id',$id);   
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        } 
    }
    // insert guest user message
    function send_message($data){
        $this->db->insert('message_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    // set is_read as 1, when message is read
    function update_message($msg_id){
        $now = date('Y-m-d H:i:s');
        $this->db->set('is_read','1');
        $this->db->set('when_read',$now);
        $this->db->where('msg_id',$msg_id);
        $this->db->update('message_tbl'); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    
}

?>