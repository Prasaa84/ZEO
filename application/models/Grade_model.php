<?php
class Grade_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

   	public function view_all_grades(){
        $this->db->select('*');
        $this->db->from('student_grades_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}

?>