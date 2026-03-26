<?php
class BirthDay_message_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    // used to view new birthday icon in notifications in user header
    public function get_new_birthday_count($condition){
        //$year = date("Y");
        $this->db->select('*');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id'); 
        if(!empty($condition)){
            $this->db->where($condition);
        }
        $this->db->where('st.is_deleted','0'); 
        $query = $this->db->get();
        return $query->num_rows();
    }
    // used to view all the new birthdays when click on birthday cake icon in user admin header
    public function get_all_new_birthdays($condition){
        $this->db->select('*,st.email as stf_email');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id'); 
        $this->db->join('designation_tbl dt','st.desig_id = dt.desig_id','left');
        $this->db->where($condition);
        $this->db->where('st.is_deleted','0'); 
        $this->db->order_by('st.census_id')->order_by('st.start_dt_this_sch');  
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        } 
    }
    // used to keep the history, when the email sent successfully.
    public function insert_birthday_message_sending_info($data){
        $this->db->insert('birthday_message_info_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    // used when sms is sent, BirthDayMessage controller->sendBirthDayWishSms()
    function get_birthday_message_email( $stf_id, $year ){ 
        $this->db->select('*');
        $this->db->from('birthday_message_info_tbl bmit');
        $this->db->where('stf_id',$stf_id)->where('year(bmit.email_sent_dt)',$year);       
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        }
    }
    // when the sms is sent, if the email has already been sent, that record to be updated in the table
    function update_birthday_message_sending_info($data){
        $id = $data['bm_id'];
        $this->db->where('bm_id',$id);
        $this->db->update('birthday_message_info_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }

    
}

?>