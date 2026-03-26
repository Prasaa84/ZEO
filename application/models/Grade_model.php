<?php
class Grade_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

   	public function view_all_grades(){
        $this->db->select('*');
        $this->db->from('grade_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // return section id of a grade
    public function get_section_of_a_grade($grade_id){
        $this->db->select('section_id');
        $this->db->from('grade_tbl');
        $this->db->where('grade_id',$grade_id);
        return $this->db->get()->row('section_id');
    }
    // return grade name
    public function get_grade_name($grade_id){
        $this->db->select('grade');
        $this->db->from('grade_tbl');
        $this->db->where('grade_id',$grade_id);
        return $this->db->get()->row('grade');
    }
    
}

?>