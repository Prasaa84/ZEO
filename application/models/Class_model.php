<?php
class Class_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

   	public function view_all_classes(){
        $this->db->select('*');
        $this->db->from('class_tbl');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_class_name($class_id){
        $this->db->select('class');
        $this->db->from('class_tbl');
        $this->db->where('class_id',$class_id);
        return $this->db->get()->row('class');
    }
}

?>