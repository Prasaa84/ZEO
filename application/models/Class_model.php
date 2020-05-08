<?php
class Class_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

   	public function view_all_classes(){
        $this->db->select('*');
        $this->db->from('student_classes_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}

?>