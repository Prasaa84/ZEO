<?php
class User_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    //get the username & password from tbl_usrs
    function get_user($usr, $pwd){
        $sql = "select * from user_tbl,user_role_tbl where username = '" . $usr . "' and password = '" . md5($pwd) . "' and status_id = 1 and user_tbl.is_deleted = 0";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    //get all user status from user_status_tbl
    function get_all_user_status(){
        $this->db->select('*');
        $this->db->from('user_status_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    //get all user status from user_status_tbl
    function get_all_user_roles(){
        $this->db->select('*');
        $this->db->from('user_role_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    //get all user activities such as login/update/insert......
    function get_all_user_acts(){
        $this->db->select('*');
        $this->db->from('user_act_type_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // get the current user details
    function get_current_user($usr, $pwd){
        $sql = "select * from user_tbl,user_role_tbl where username = '" . $usr . "' and password = '" . md5($pwd) . "' and status_id = 1 and user_tbl.role_id = user_role_tbl.role_id and user_tbl.is_deleted = 0";
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result_array();
        }
    }
    // when add a school, create the user too
    function add_user($data){
        $this->db->insert('user_tbl', $data);
        if($this->db->affected_rows()>0){
            $id = $this->db->insert_id();
            return $id;
        }else{
            return false;
        }
    }
    function get_last_added_user(){ // used when add a school
        $query = $this->db->get('user_tbl');
        return $query->result();
    }
    function delete_user($user_id){ // when delete a user, is_deleted is set to 1
        $this->db->set('is_deleted','1'); // the user is not physically deleted from db
        $this->db->where('user_id',$user_id);
        $this->db->update('user_tbl');
        //echo $this->db->affected_rows(); die();
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function view_all_users(){ 
        $this->db->select('*,ut.user_id as u_id,ut.date_added as added_dt,ut.date_updated as updated_dt');
        $this->db->from('user_tbl ut');
        $this->db->join('school_details_tbl sdt','ut.user_id = sdt.user_id','left');
        $this->db->join('user_role_tbl urt','ut.role_id = urt.role_id','left');
        $this->db->join('user_status_tbl ust','ut.status_id = ust.status_id','left');
        $this->db->where('ut.is_deleted','0');
        $this->db->order_by('ut.user_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // here user_updated_dt is used in the user setting view to show last updated date of username and password
    function get_user_info_by_userid($user_id){
        $this->db->select('*,ut.user_id as u_id,ut.date_updated as user_updated_dt');
        $this->db->from('user_tbl ut');
        $this->db->join('user_role_tbl urt','ut.role_id = urt.role_id','left');
        $this->db->join('user_status_tbl ust','ut.status_id = ust.status_id','left');
        $this->db->join('school_details_tbl sdt','ut.user_id = sdt.user_id','left');
        $this->db->where('ut.user_id',$user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // change user status (active/inactive)
    function update_user_status($user,$user_status){
        foreach ($user as $user) {
            $this->db->set('status_id',$user_status); // update status id in user table
            $this->db->where('user_id',$user);
            $this->db->update('user_tbl');        
        }
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    // change user role (admin/school user......)
    function update_to_def_uname_pwd($user,$username,$password){
        $this->db->set('username',$username);
        $this->db->set('password',$password); 
        $this->db->where('user_id',$user);
        $this->db->update('user_tbl');        
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    // change user role (admin/school user......)
    function update_user_role($user,$user_role){
        foreach ($user as $user) {
            $this->db->set('role_id',$user_role); // change user role in user table
            $this->db->where('user_id',$user);
            $this->db->update('user_tbl');        
        }
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    // find user role of a user id to set default username and password
    function get_user_role($user){
        $this->db->select('role_id');    
        $this->db->from('user_tbl');
        $this->db->where('user_id',$user);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function add_user_act($data){ // insert user activity
        $this->db->insert('user_track_tbl', $data);
    }
    // get user activity by user id
    function view_user_log_by_user_id($user_id){
        $this->db->select('*,utt.date_added as userlog_added_dt,utt.user_id');
        $this->db->from('user_track_tbl utt');
        $this->db->join('user_act_type_tbl uact','utt.act_type_id = uact.act_type_id','left');
        $this->db->join('school_details_tbl sdt','utt.user_id = sdt.user_id','left');
        $this->db->where('utt.user_id',$user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }
    // get user activity by census id 
    function view_user_log_by_census_id($census_id){
        $this->db->select('*,utt.date_added as userlog_added_dt,utt.user_id,sdt.census_id');
        $this->db->from('user_track_tbl utt');
        $this->db->join('user_act_type_tbl uact','utt.act_type_id = uact.act_type_id','left');
        $this->db->join('school_details_tbl sdt','utt.user_id = sdt.user_id','left');
        $this->db->where('sdt.census_id',$census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }
    // get user activity by period
    function view_user_log_by_period($from_dt,$to_dt){
        $this->db->select('*,utt.date_added as userlog_added_dt,utt.user_id,sdt.census_id');
        $this->db->from('user_track_tbl utt');
        $this->db->join('user_act_type_tbl uact','utt.act_type_id = uact.act_type_id','left');
        $this->db->join('school_details_tbl sdt','utt.user_id = sdt.user_id','left');
        $this->db->where('utt.date_added >=',$from_dt);
        $this->db->where('utt.date_added <=',$to_dt);        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }
    // get user activity by action
    function view_user_log_by_action($user_act){
        $this->db->select('*,utt.date_added as userlog_added_dt,utt.user_id,sdt.census_id');
        $this->db->from('user_track_tbl utt');
        $this->db->join('user_act_type_tbl uact','utt.act_type_id = uact.act_type_id','left');
        $this->db->join('school_details_tbl sdt','utt.user_id = sdt.user_id','left');
        $this->db->where('utt.act_type_id',$user_act);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }
    function view_user_log_by_date($date){
        echo $date; die();
        $this->db->select('*,utt.date_added as userlog_added_dt,utt.user_id,sdt.census_id');
        $this->db->from('user_track_tbl utt');
        $this->db->join('user_act_type_tbl uact','utt.act_type_id = uact.act_type_id','left');
        $this->db->join('school_details_tbl sdt','utt.user_id = sdt.user_id','left');
        $this->db->where('utt.date_added',$date);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }
    //check whether the email exists
    function check_email_exists($email){
        $this->db->select('*');
        $this->db->from('school_details_tbl');
        $this->db->where('email',$email);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    //check whether the username exists with id
    function check_unm_exists($uid,$unm){
        $this->db->select('*');
        $this->db->from('user_tbl');
        $this->db->where('user_id',$uid);
        $this->db->where('username',$unm);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    //check whether the username exists, this is used in adding new user in user controller by admin
    function check_unm_exist($unm){
        $this->db->select('*');
        $this->db->from('user_tbl');
        $this->db->where('username',$unm);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // change username
    function change_username($uid,$new_unm){
        $now = date('Y-m-d H:i:s');
        $this->db->set('username',$new_unm);
        $this->db->set('date_updated',$now);
        $this->db->where('user_id',$uid);
        $this->db->update('user_tbl');        
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
     //check whether the username exists
    function check_pwd_exists($uid,$cur_pwd){
        $this->db->select('*');
        $this->db->from('user_tbl');
        $this->db->where('user_id',$uid);
        $this->db->where('password',$cur_pwd);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // change username
    function change_pwd($uid,$new_pwd){
        $now = date('Y-m-d H:i:s');
        $this->db->set('password',$new_pwd);
        $this->db->set('date_updated',$now);
        $this->db->where('user_id',$uid);
        $this->db->update('user_tbl');        
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
}