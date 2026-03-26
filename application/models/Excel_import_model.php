<?php
class Excel_import_model extends CI_Model
{
	function select_marks($grade,$class,$census_id)
	{
        //echo $grade.$class.$census_id; die();
		//$this->db->order_by('CustomerID', 'DESC');
		//$query = $this->db->get('tbl_customer');
		//print_r($query); die();
		//return $query;
		$this->db->select('*');
        $this->db->from('student_marks_tbl smt');
        $this->db->join('student_tbl st','smt.adm_no = st.adm_no'); // 
        $this->db->join('class_subjects_tbl cst','smt.subj_id = cst.subj_id'); // 
        $this->db->where('st.grade_id',$grade)->where('st.class_id',$class)->where('st.census_id',$census_id);
        $this->db->order_by('smt.adm_no')->order_by('smt.year')->order_by('smt.term')->order_by('cst.order_id');
        //$this->db->order_by('smt.adm_no')->order_by('smt.year')->order_by('smt.term')->order_by('smt.subj_group_id')->order_by('smt.subj_id','asc');
        //$this->db->order_by('cst.order_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
	}
	function insert_bulk_students($data){
		$this->db->insert_batch('student_tbl', $data);
		//$query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }  
    }

	function insert($data)
	{
		$this->db->insert_batch('student_marks_tbl', $data);
		//$query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }  
    }
    function update_marks($data){
        $adm_no = $data['adm_no'];
        $year = $data['year'];
        $term = $data['term'];
        $subj_id = $data['subj_id'];
        $census_id = '07001';        
        //$this->db->join('student_tbl st','smt.adm_no = st.adm_no'); // gender 
        $this->db->where('adm_no',$adm_no)->where('year',$year)->where('term',$term)->where('subj_id',$subj_id);
        $this->db->update('student_marks_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    // used in importing bulk marksheet
    function selectSubjectIdBySubjectName($subj_name){
        $this->db->select('*');
        $this->db->from('subject_tbl st');
        $this->db->like('st.subj_name',$subj_name); // both is equal to %subj_name% - it means from the beginning or end of the word
        //$this->db->where('st.subj_name',$subj_name); // this is not working for some subjects
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }     
    }
    // used in importing bulk marksheet
    function select_subjects($census_id,$grade,$class){
        $this->db->select('*');
        $this->db->from('class_subjects_tbl cst');
        $this->db->join('subject_tbl st','cst.subj_id = st.subj_id'); // gender 
        $this->db->order_by('cst.order_id');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }     
    }
    // used in importing bulk marksheet
    function select_students_got_marks($grade,$class,$census_id){
        $this->db->select('*');
        $this->db->from('student_marks_tbl smt');
        $this->db->join('student_tbl st','smt.adm_no = st.adm_no'); // gender 
        $this->db->where('st.grade_id',$grade)->where('st.class_id',$class);
        $this->db->order_by('smt.adm_no');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }     
    }
    function checkStudentExistInClass($adm_no,$grade,$class,$census_id){
        $this->db->select('*');
        $this->db->from('student_tbl st');
        $this->db->where('st.adm_no',$adm_no)->where('st.grade_id',$grade)->where('st.class_id',$class)->where('st.census_id',$census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }       
    }
    function checkMarksExistInClass($adm_no,$year,$term,$subj_id){
        $this->db->select('*');
        $this->db->from('student_marks_tbl smt');
        $this->db->join('student_tbl st','smt.adm_no = st.adm_no'); // gender 
        $this->db->where('smt.adm_no',$adm_no)->where('smt.year',$year)->where('smt.term',$term)->where('smt.subj_id',$subj_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }       
    }
}
