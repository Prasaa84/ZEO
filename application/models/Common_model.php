<?php
class Common_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    public function get_all_schools(){
        $this->db->select('*');
        $this->db->from('school_details_tbl');
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
    public function get_all_appointment_category(){
        $this->db->select('*');
        $this->db->from('appointment_cat_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function get_all_appointment_sub_category(){
        $this->db->select('*');
        $this->db->from('appointment_sub_cat_tbl');
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
}

?>