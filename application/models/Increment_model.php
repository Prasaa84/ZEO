<?php
class Increment_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        if(is_logged_in()){
            $this->userrole = $this->session->userdata['userrole'];
            $this->userrole_id = $this->session->userdata['userrole_id']; 
        }
    }
    function get_all_increment_status(){
        $this->db->select('*'); //ex - කොට්ටාස කාර්යාලයට භාරදුනි, කොට්ටාස කාර්යාලයෙන් අනුමත කරන ලදි.....
        $this->db->from('teacher_increment_status_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_stf_increment_not_submit($stf_id){
        $this->db->select('*');
        $this->db->from('teacher_increment_tbl tit');
        $year = date("Y"); 
        $this->db->where('tit.increment_year',$year);
        $this->db->where('tit.stf_id',$stf_id);
        $query = $this->db->get();      
        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }  
    }
    public function get_stf_increment_not_submit_by($condition){
        $this->db->select('*');
        $this->db->from('teacher_increment_tbl tit'); 
        $this->db->join('staff_tbl st','st.stf_id = tit.stf_id','left');
        $year = date("Y");
        $month = date("m")-1;
        $this->db->where('tit.increment_year',$year);
        $this->db->where('st.first_app_dt',$month);
        $this->db->order_by('date_format(st.first_app_dt,"%m-%d")');
        $query = $this->db->get();      
        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }  
    }
    // get teachers increments within 30 days
    // used in Increment controller - viewRecentIncrements()
    public function get_recent_increments($condition){ 
        $this->db->select('*, st.stf_id as staff_id, st.address1 as stf_address1, st.address2 as stf_address2, st.email as stf_email,st.date_added as stf_date_added, st.date_updated as last_update, st.is_deleted as stf_is_deleted, ');
        $this->db->from('staff_tbl st');
        $this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id','left'); // gender 
        $this->db->join('gender_tbl gt','st.gender_id = gt.gender_id','left'); // gender 
        $this->db->join('ethnic_group_tbl egt','st.ethnic_group_id = egt.ethnic_group_id','left'); // ethnic group
        $this->db->join('designation_tbl des','st.desig_id = des.desig_id','left');     // designation
        $this->db->join('staff_type_tbl stt','st.stf_type_id = stt.stf_type_id','left');        // staff type
        $this->db->join('staff_status_tbl sst','st.stf_status_id = sst.stf_status_id','left');  // status
        //$this->db->join('involved_task_tbl inv','st.involved_task_id = inv.involved_task_id','left'); // task
        $this->db->join('subject_medium_tbl smt','st.subj_med_id = smt.subj_med_id','left');         // app sub cat
        $this->db->join('section_tbl sec','st.sec_id = sec.section_id','left');             // section
        //$this->db->join('teacher_increment_inform_tbl tiit','st.stf_id = tiit.stf_id','left');
        $this->db->where($condition);
        $this->db->order_by('date_format(st.first_app_dt,"%m-%d")');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //print_r($query->result()); die();
            return $query->result();
        } else {
            return false;
        }  
    }
    // check email status
    public function is_increment_email_sent($stf_id, $incrementYear){
        $this->db->select('*');
        $this->db->from('teacher_increment_inform_tbl');
        $this->db->where('stf_id', $stf_id);
        $this->db->where('increment_year', $incrementYear);
        $this->db->where('email_sent',1); // 1 = sent, 0 = not sent
        $query = $this->db->get();
        if($query->num_rows() == 1){ 
            return true;
        }else{ 
            return false; 
        }
    }
    // check sms status
    public function is_increment_sms_sent( $sid, $year ){
        $this->db->select('*');
        $this->db->from('teacher_increment_inform_tbl');
        $this->db->where('stf_id', $sid);
        $this->db->where('increment_year',$year);
        $this->db->where('sms_sent',1); // 1 = sent, 0 = not sent
        $query = $this->db->get();
        if($query->num_rows() == 1){ 
            return true;
        }else{ 
            return false; 
        }
    }
     // check whether email or sms has already been sent
     public function is_increment_info_sent( $stf_id, $increment_year ){
        $this->db->select('*');
        $this->db->from('teacher_increment_inform_tbl');
        $this->db->where('stf_id', $stf_id);
        $this->db->where('increment_year',$increment_year);
        $query = $this->db->get();
        if($query->num_rows() == 1){ 
            return true;
        }else{ 
            return false; 
        }
    }
    // when the sms is sent, record the information
    // this is used when email record already not there. if email record is available it is updated with sms info using update_increment_msg_info() method
    function insert_sms_result( $data ){
        $this->db->insert('teacher_increment_inform_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    // when the email is sent, record the information,
    // this is only used when sms records are not there. If sms record is available it is updated with email info using update_increment_msg_info() method given below
    function insert_email_result( $data ){
        $this->db->insert('teacher_increment_inform_tbl', $data);
        if( $this->db->affected_rows()>0 ){
            return true;
        }else{
            return false;
        }
    }
    // when the sms is sent, if the email has already been sent, that record to be updated in the table
    function update_increment_msg_info( $data ){
        $stf_id = $data['stf_id'];
        //$increment_year = $data['increment_year'];
        $this->db->where('stf_id', $stf_id);
        $this->db->update('teacher_increment_inform_tbl', $data); 
        if( $this->db->affected_rows() > 0 ){         
            return true; 
        }else{
            return false; 
        }
    }
    // get inforamtion about sent increment sms 
    public function get_sms_info( $sid, $year ){
        $this->db->select('*');
        $this->db->from('teacher_increment_inform_tbl');
        $this->db->where('stf_id',$sid);
        $this->db->where('increment_year',$year);   
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        } 
    }
    // insert sms details when it send
    function send_increment_msg( $data ){
        $this->db->insert('message_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    // get message sent for the schools
    public function get_message_history( $sid, $year ){
        $this->db->select('*');
        $this->db->from('message_tbl mt');
        $this->db->join('staff_tbl st','st.stf_id = mt.stf_id'); // staff 
        $this->db->where('mt.stf_id',$sid);
        $this->db->where('mt.academic_year',$year);   
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        } 
    }
    // view all handovered increments
    public function view_increments($condition){
        $this->db->select('*, tit.date_added as inc_date_added, tit.date_updated as last_update, tit.is_deleted as inc_is_deleted');
        $this->db->from('teacher_increment_tbl tit');
        $this->db->join('staff_tbl st','st.stf_id = tit.stf_id'); // staff 
        $this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id'); // school 
        $this->db->join('gender_tbl gt','gt.gender_id = st.gender_id'); // gender
        $this->db->join('designation_tbl dt','dt.desig_id = st.desig_id'); // school 
        $this->db->join('teacher_increment_status_tbl tist','tist.inc_status_id = tit.inc_status_id'); // school 
        $this->db->where($condition);
        $this->db->where('st.is_deleted',0);
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        } 
    } 
    // view increment status of a teacher
    public function view_increments_by_nic($nic_no,$year){
        $this->db->select('*, tit.date_added as inc_date_added, tit.date_updated as last_update, tit.is_deleted as inc_is_deleted');
        $this->db->from('teacher_increment_tbl tit');
        $this->db->join('staff_tbl st','st.stf_id = tit.stf_id'); // staff 
        $this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id'); // school 
        $this->db->join('teacher_increment_status_tbl tist','tist.inc_status_id = tit.inc_status_id'); // school 
        $this->db->where('st.nic_no',$nic_no)->where('tit.increment_year',$year);
        $userRole = $this->session->userdata['userrole'];
        if($userRole == 'School User'){
            $census_id = $this->session->userdata['census_id'];
            $this->db->where('st.census_id',$census_id);
        }
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        } 
    }
    // before insert new increment, it is checked whether it exists
    function check_increment_exists($stf_id,$year){
        $this->db->select('*');
        $this->db->from('teacher_increment_tbl');
        $this->db->where('stf_id',$stf_id)->where('increment_year',$year);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }  
    // when insert new increment, the apply date must be greater than increment date. it is checked here.
    function check_increment_date($stf_id,$inc_date){
        $inc_date = strtotime($inc_date);
        $inc_date = date("m-j",$inc_date); 
        $this->db->select('*');
        $this->db->from('staff_tbl');
        $this->db->where('date_format(first_app_dt,"%m-%d") <= "'.$inc_date.'" ');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    } 
            //$condition2 = 'date_format(st.first_app_dt,"%m-%d") >= "'.$from.'" and date_format(st.first_app_dt,"%m-%d") <= "'.$to.'" ';  // "%m-%d" means picking only month and day from first appoinment date
             //$first_app_date = strtotime($row->first_app_dt); 
             //   $inc_date = date("m-j",$first_app_date); 
    // insert new increment form
    function insert_new_increment($data){
        $this->db->insert('teacher_increment_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    function update_increment($data){
        $inc_id = $data['tr_inc_id'];
        $this->db->where('tr_inc_id',$inc_id);
        $this->db->update('teacher_increment_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function delete_increment_info($inc_id){
        $this->db->where('tr_inc_id',$inc_id);
        $this->db->delete('teacher_increment_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used in increments index view to display count in the cards ex- received, approved, submitted
    function count_increment_by_condition($condition){
        $this->db->select('*');
        $this->db->from('teacher_increment_tbl tit');
        $this->db->where($condition);
        if( $this->userrole_id==2 ){
            $census_id = $this->session->userdata['census_id']; 
            $this->db->join('staff_tbl st','st.stf_id = tit.stf_id'); // staff 
            //$this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id'); // school 
            $this->db->where('st.census_id',$census_id);
        }elseif ($this->userrole_id==7) {
            $div_id = $this->session->userdata['div_id']; 
            $this->db->join('staff_tbl st','st.stf_id = tit.stf_id'); // staff 
            $this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id'); // school 
            $this->db->where('sdt.div_id',$div_id);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    // used in increments index view to display defects count in the defect card
    function count_increment_with_defects($year){
        $this->db->select('*');
        $this->db->from('teacher_increment_tbl tit');
        if( $this->userrole_id == 7 ){
            $this->db->where('tit.inc_status_id','1')->where('tit.defects','1')->where('tit.increment_year',$year);
        }elseif( $this->userrole_id == 8 ){
            $this->db->where('tit.inc_status_id','3')->where('tit.defects','1')->where('tit.increment_year',$year);
        }elseif( $this->userrole_id == 9 ){
            $this->db->where('tit.inc_status_id','5')->where('tit.defects','1')->where('tit.increment_year',$year);
        }else{
            $this->db->where('tit.defects','1')->where('tit.increment_year',$year);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
}

?>