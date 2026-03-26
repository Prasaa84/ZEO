<?php
class Common_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        
    }
    // send email when create school user and send user login details
    // used to send birth day wish message in sendBirthDayWish() in BirthDayMessage controller
    // used in contact page of public site
    public function send_mail($to_email,$subject,$message) { 
         //Load email library 
         $this->load->library('email'); 
         $config = Array(
            'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
            'smtp_host' => 'smtp.gmail.com', 
            'smtp_port' => 465,
            'smtp_user' => 'emorawakazeo@gmail.com',
            'smtp_pass' => 'morawakatest',
            'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
            'mailtype' => 'html', //plaintext 'text' mails or 'html'
            //'smtp_timeout' => '4', //in seconds
            'charset' => 'utf-8',
            'wordwrap' => TRUE
         );

         $from_email = "emorawakazeo@gmail.com"; 
         //$to_email = $to_email; 

         $this->email->initialize($config);
         $this->email->set_newline("\r\n");
         $this->email->from($from_email, 'Deniyaya ZEO'); 
         $this->email->to($to_email);
         $this->email->subject(utf8_encode($subject)); // utf8_decode is not working here, it is used to encode unicode chars.
         $this->email->message(utf8_encode($message)); 
   
         //Send mail 
         return $this->email->send();
         //die();
    } 
    // send sms - used to send birthday wishes
    // php script in textitbit 
    public function send_sms( $phone_no,$message ){
        //$user = "942018052101";
        //$password = "2518";
        $user = "94715885993";
        $password = "3758";
        $text = urlencode($message);
        $to = $phone_no;
            
        $baseurl ="http://www.textit.biz/sendmsg";
        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
        $ret = file($url);

        $res= explode(":",$ret[0]);
            
        if ( trim($res[0])=="OK" ){
            return true;
        }else{
            return false;
        }
    }
    public function get_division($div_id=''){
        $this->db->select('*');
        $this->db->from('edu_div_tbl edt');
        if( !empty($div_id) ) {
            $this->db->where('edt.div_id',$div_id);
        }
        $this->db->order_by('edt.div_id');
        $query = $this->db->get();
        if( $query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_schools($div_id=''){
        $this->db->select('*');
        $this->db->from('school_details_tbl sdt');
        if( !empty($div_id) ) {
            $this->db->where('sdt.div_id',$div_id);
        }
        $this->db->order_by('census_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_stf_types(){
        $this->db->select('*');
        $this->db->from('staff_type_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_grades(){
        $this->db->select('*');
        $this->db->from('grade_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_classes(){
        $this->db->select('*');
        $this->db->from('class_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_sections(){
        $this->db->select('*');
        $this->db->from('section_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_service_status(){
        $this->db->select('*');
        $this->db->from('service_status_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_province(){
        $this->db->select('*');
        $this->db->from('province_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_zones(){
        $this->db->select('*');
        $this->db->from('edu_zone_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_section_roles(){
        $this->db->select('*');
        $this->db->from('section_role_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_religion(){
        $this->db->select('*');
        $this->db->from('religion_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_civil_status(){
        $this->db->select('*');
        $this->db->from('civil_status_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_genders(){
        $this->db->select('*');
        $this->db->from('gender_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_student_status(){
        $this->db->select('*');
        $this->db->from('student_status_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_service_grades(){
        $this->db->select('*');
        $this->db->from('service_grade_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_task_involved(){
        $this->db->select('*');
        $this->db->from('involved_task_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_edu_qual(){
        $this->db->select('*');
        $this->db->from('edu_quali_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_prof_qual(){
        $this->db->select('*');
        $this->db->from('prof_quali_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_ethnic_groups(){
        $this->db->select('*');
        $this->db->from('ethnic_group_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_appointment_types(){
        $this->db->select('*');
        $this->db->from('appointment_type_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_appointment_subjects(){
        $this->db->select('*');
        $this->db->from('appointment_subject_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_appointment_medium(){
        $this->db->select('*');
        $this->db->from('subject_medium_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_games(){
        $this->db->select('*');
        $this->db->from('games_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // teacher role of a game
    public function get_all_game_roles(){
        $this->db->select('*');
        $this->db->from('game_roles_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // students role of a game
    public function get_all_game_roles_of_student(){
        $this->db->select('*');
        $this->db->from('student_game_roles_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // games win types - used in student update
    public function get_all_win_types(){
        $this->db->select('*');
        $this->db->from('student_win_type_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_extra_curri(){
        $this->db->select('*');
        $this->db->from('extra_curri_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // teachers roles or extra currriculum
    public function get_all_extra_curri_roles(){
        $this->db->select('*');
        $this->db->from('extra_curri_role_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // student's roles of extra curril.
    public function get_all_std_extra_curri_roles(){
        $this->db->select('*');
        $this->db->from('student_extra_curri_roles_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_designations(){
        $this->db->select('*');
        $this->db->from('designation_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function view_all_designations(){
        $this->db->select('*');
        $this->db->from('staff_type_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_stf_status(){
        $this->db->select('*');
        $this->db->from('staff_status_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_tasks(){
        $this->db->select('*');
        $this->db->from('involved_task_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_taks_types(){
        $this->db->select('*');
        $this->db->from('involved_task_type_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_subjects(){
        $this->db->select('*');
        $this->db->from('subject_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // School controller viewDistricts() ajax call
    public function get_districts($condition){
        $this->db->select('*');
        $this->db->from('district_tbl dt');
        $this->db->where($condition);
        $this->db->order_by('dt.dis_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // School controller viewZones() ajax call
    public function get_zones($condition){
        $this->db->select('*');
        $this->db->from('edu_zone_tbl ezt');
        $this->db->where($condition);
        $this->db->order_by('ezt.zone_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // School controller viewDivisions() ajax call
    public function get_divisions($condition=''){
        $this->db->select('*');
        $this->db->from('edu_div_tbl edt');
        if( !empty($condition) ){
            $this->db->where($condition);
        }
        $this->db->order_by('edt.div_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used in schools controller->viewDivisionsList() to autocomplete 
    // when add new divisional user User->index view
    function get_divisions_list($postData){

        $response = array();

        if(isset($postData['search']) ){
        // Select record
        $this->db->select('*');
        $this->db->where("div_name like '%".$postData['search']."%' ");

        $records = $this->db->get('edu_div_tbl')->result();

        foreach($records as $row ){
            $response[] = array("value"=>$row->div_id,"label"=>$row->div_name);
        }

        }

        return $response;
    }
    // used in schools controller->viewSchoolList() to autocomplete 
    // when search students school wise in student_reports view
    function get_school_list( $postData ){

        $response = array();

        if( isset( $postData['search'] ) ){
        // Select record
            $this->db->select('*');
            $this->db->or_like( 'sch_name', $postData['search'] );
            $this->db->or_like( 'census_id', $postData['search'] );
            $records = $this->db->get('school_details_tbl')->result();

            foreach( $records as $row ){
                $response[] = array("value"=>$row->census_id,"label"=>$row->sch_name);
            }

        }

        return $response;
    }
    // School controller viewDivSecretariat() ajax call
    public function get_div_secretariat($condition){
        $this->db->select('*');
        $this->db->from('div_secretariat_tbl dst');
        $this->db->where($condition);
        $this->db->order_by('dst.div_sec_name_si');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used to get div_sec_dis_id to view gs divisions - School Controller - viewGsDivisions();
    public function get_div_secretariat_by_id($div_sec_id){
        $this->db->select('*');
        $this->db->from('div_secretariat_tbl dst');
        $this->db->where('dst.div_sec_id',$div_sec_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // School controller viewGsDivisions() ajax call
    public function get_gs_divisions($condition){
        $this->db->select('*');
        $this->db->from('gs_divisions_tbl gsdt');
        $this->db->where($condition);
        $this->db->order_by('gsdt.gs_name_si');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}

?>