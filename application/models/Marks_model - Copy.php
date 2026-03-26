<?php
class Marks_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    // used in viewAddedMarks in Marks Controller
   	function get_marks($census_id,$year,$term,$grade_id,$class_id){
        $this->db->select('ttmt.index_no as adm_no,name_with_initials,sbt.sub_cat_id,subj_id,marks,order_id,ttmt.date_updated as marks_last_update');
        $this->db->from('term_test_marks_tbl ttmt');
        $this->db->join('student_tbl st','ttmt.index_no = st.index_no'); // 
        $this->db->join('subjects_grade_tbl sgt','ttmt.subj_id = sgt.subject_id'); // 
        $this->db->join('student_grade_class_tbl sgct','ttmt.index_no = sgct.index_no'); //
        $this->db->join('subject_tbl sbt','ttmt.subj_id = sbt.subject_id'); // 
        
        $this->db->where('ttmt.census_id',$census_id)->where('ttmt.year',$year)->where('ttmt.term',$term)->where('sgct.grade_id',$grade_id)->where('sgct.year',$year)->where('sgct.class_id',$class_id)->where('sgct.census_id',$census_id)->where('sgt.census_id',$census_id)->where('sgt.year',$year)->where('sgt.grade_id',$grade_id)->where('st.census_id',$census_id);
        $this->db->order_by('ttmt.index_no')->order_by('ttmt.year')->order_by('ttmt.term')->order_by('sgt.order_id');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }
    // used in viewAddedMarks in Marks Controller
    function get_term_test_results($census_id,$year,$term,$index_no){
        $this->db->select('*');
        $this->db->from('term_test_results_tbl ttrt');
        $this->db->join('student_tbl st','ttrt.index_no = st.index_no'); //
        $this->db->join('student_grade_class_tbl stgct','ttrt.index_no = stgct.index_no'); // 
        $this->db->join('grade_tbl gt','stgct.grade_id = gt.grade_id');
        $this->db->join('class_tbl ct','stgct.class_id = ct.class_id');
        $this->db->where('ttrt.census_id',$census_id)->where('ttrt.index_no',$index_no)->where('ttrt.year',$year)->where('ttrt.term',$term);
        $this->db->order_by('ttrt.index_no');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }
    // not used yet
    function get_term_test_absentees($census_id,$year,$term,$index_no){
        $this->db->select('*');
        $this->db->from('term_test_absentees_tbl ttat');
        $this->db->join('student_tbl st','ttat.index_no = st.index_no'); //
        $this->db->join('student_grade_class_tbl stgct','ttat.index_no = stgct.index_no'); // 
        $this->db->join('grade_tbl gt','stgct.grade_id = gt.grade_id');
        $this->db->join('class_tbl ct','stgct.class_id = ct.class_id');
        $this->db->join('subject_tbl sbt','ttat.subj_id = sbt.subject_id'); // 
        $this->db->where('ttat.census_id',$census_id)->where('ttat.index_no',$index_no)->where('ttat.year',$year)->where('ttat.term',$term);
        $this->db->order_by('ttat.index_no');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }
    // Marks controller - viewAddedMarks() line 118
    function check_term_test_absent($census_id,$year,$term,$index_no,$subj_id){
        $this->db->select('*');
        $this->db->from('term_test_absentees_tbl ttat');
        $this->db->where('ttat.census_id',$census_id)->where('ttat.index_no',$index_no)->where('ttat.year',$year)->where('ttat.term',$term)->where('ttat.subj_id',$subj_id);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }  
    }   
    
    // insert marks from excel by fetching one by one 
    // Marks controller - import() line 504
    function insert($data){
        $this->db->insert_batch('term_test_marks_tbl', $data);
        //$query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }  
    }
    // insert total and average marks from excel by fetching row by row
    // Marks controller - import() line 534
    function insert_term_test_result($data){
        $this->db->insert_batch('term_test_results_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }  
    }
    // insert absentees (AB)  from excel mark sheet by fetching cell by cell 
    // Marks controller - import() line 553
    function insert_term_test_absentee($data){
        $this->db->insert_batch('term_test_absentees_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }  
    }
    // not used yet
    function update_marks($data){
        $index_no = $data['index_no'];
        $year = $data['year'];
        $term = $data['term'];
        $subj_id = $data['subj_id'];
        $census_id = $data['census_id'];       
        //$this->db->join('student_tbl st','smt.adm_no = st.adm_no'); // gender 
        $this->db->where('index_no',$index_no)->where('year',$year)->where('term',$term)->where('subj_id',$subj_id)->where('census_id',$census_id);
        $this->db->update('term_test_marks_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    // used in importing bulk marksheet
    function selectSubjectIdBySubjectName($subj_name,$section_id){
        //$subj_name = explode(" ", $subj_name);
        //$subj_name=urldecode($subj_name);        
        $this->db->select('*');
        $this->db->from('subject_tbl st');
        //$this->db->like('st.subject',strtolower($subj_name[0])); 
        //$this->db->or_like('st.subject',strtolower($subj_name[1])); 
        //$this->db->like('st.subject',$subj_name); // both is equal to %subj_name% - it means from the beginning or end of the word
        $this->db->where('st.subject',$subj_name)->where('st.section_id',$section_id); // this is not working for some subjects
        // $this->db->where('st.section_id',$section_id); 
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }     
    }
    // check whether the subject has been assigned to grade
    function check_subject_exist_in_grade($census_id,$grade_id,$subject_id,$year){
        //echo $census_id,$grade_id,$subject_id,$year; die();
        $this->db->select('*');
        $this->db->from('subjects_grade_tbl sgt');
        $this->db->join('subject_tbl st','sgt.subject_id = st.subject_id'); // gender 
        $this->db->where('census_id',$census_id)->where('grade_id',$grade_id)->where('sgt.subject_id',$subject_id)->where('year',$year);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }     
    }
    // used in viewing marksheet - marks controller line 51
    function select_subjects($census_id,$grade_id,$year){ 
        $this->db->select('*');
        $this->db->from('subjects_grade_tbl sgt');
        $this->db->join('subject_tbl st','sgt.subject_id = st.subject_id');
        $this->db->join('subject_category_tbl sct','st.sub_cat_id = sct.sub_cat_id');
        $this->db->where('sgt.census_id',$census_id)->where('sgt.grade_id',$grade_id)->where('sgt.year',$year); // this is not working for some subjects
        $this->db->order_by('sgt.order_id');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }     
    }
    // used in viewing marksheet - marks controller line 52
    // count all subjects assigned to a grade
    function count_subjects($census_id,$grade_id,$year){ 
        $this->db->select('count(*) as subj_count');
        $this->db->from('subjects_grade_tbl sgt');
        $this->db->join('subject_tbl st','sgt.subject_id = st.subject_id');
        $this->db->join('subject_category_tbl sct','st.sub_cat_id = sct.sub_cat_id');
        $this->db->where('sgt.census_id',$census_id)->where('sgt.grade_id',$grade_id)->where('sgt.year',$year); // this is not working for some subjects
        $this->db->order_by('sgt.order_id');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            $row = $query->row();
            return $row->subj_count;
        } else {
            return false;
        }     
    }
    // used in importing bulk marksheet
    /*function select_students_got_marks($grade,$class,$census_id){
        $this->db->select('*');
        $this->db->from('term_test_marks_tbl ttmt');
        $this->db->join('student_tbl st','ttmt.adm_no = st.adm_no'); // gender 
        $this->db->where('st.grade_id',$grade)->where('st.class_id',$class);
        $this->db->order_by('ttmt.adm_no');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }     
    }*/
    // used in import() method in Marks Controller
    function check_student_exist_in_Class($index_no,$grade_id,$class_id,$census_id){
        $this->db->select('*');
        $this->db->from('student_grade_class_tbl sgct');
        $this->db->join('student_tbl st','sgct.index_no = st.index_no'); // gender 
        $this->db->where('sgct.index_no',$index_no)->where('sgct.grade_id',$grade_id)->where('sgct.class_id',$class_id)->where('sgct.census_id',$census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }       
    }
    // not used yet
    function check_marks_exist_in_class($index_no,$year,$term,$census_id){
        $this->db->select('*');
        $this->db->from('term_test_marks_tbl ttmt');
        //$this->db->join('student_tbl st','ttmt.adm_no = st.adm_no'); // gender 
        $this->db->where('ttmt.index_no',$index_no)->where('ttmt.year',$year)->where('ttmt.term',$term)->where('ttmt.census_id',$census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }       
    }
    // deleting marks using adm_no. grade_id or class_id field is not in term_test_marks_tbl
    // used in Marks controller import() line 552
    function delete_student_marks($adm_no,$year,$term,$census_id){
        $this->db->where('index_no',$adm_no)->where('year',$year)->where('term',$term)->where('census_id',$census_id);
        $this->db->delete('term_test_marks_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used in Marks controller import() line
    function delete_student_term_test_results($adm_no,$year,$term,$census_id){
        $this->db->where('index_no',$adm_no)->where('year',$year)->where('term',$term)->where('census_id',$census_id);
        $this->db->delete('term_test_results_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used in Marks controller import() line 485
    // 
    function delete_term_test_absentees($adm_no,$year,$term,$census_id){
        $this->db->where('index_no',$adm_no)->where('year',$year)->where('term',$term)->where('census_id',$census_id);
        $this->db->delete('term_test_absentees_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // when delete all students of a class in StudentsInClasses view
    // used in Student controller deleteAllStudentsInAClass method to check whether the marks of this class finallized
    // term is not considered. if marks are finalized in this year for any term, class can not be deleted.
    // used in deleting marks of a class in Marks controller-deleteMarks()(term is considered here)
    // Marks controller - import() uses
    function check_marks_completed_in_a_class($census_id,$grade_id,$class_id,$year,$term=""){
        $this->db->select('*');
        $this->db->from('term_test_marks_confirm_tbl ttmct');
        $this->db->where('ttmct.census_id',$census_id)->where('ttmct.grade_id',$grade_id)->where('ttmct.class_id',$class_id)->where('ttmct.year',$year)->where('ttmct.term',$term);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }       
    }
    // used in Marks controller in confirmMarks method to confirm marks after inserting
    // then user not allowed to edit them. when finalized marks of a class, a record will be added this table.
    function confirm_marks($data){
        $this->db->insert('term_test_marks_confirm_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    // used in marksConfirm view to view the confirm status
    function get_confirm_status($census_id,$year,$term,$grade_id='',$class_id=''){
        $this->db->select('*,ttmct.date_updated as update_date');
        $this->db->from('term_test_marks_confirm_tbl ttmct');
        $this->db->join('grade_tbl gt','ttmct.grade_id = gt.grade_id');
        $this->db->join('class_tbl ct','ttmct.class_id = ct.class_id');
        $this->db->where('ttmct.census_id',$census_id)->where('ttmct.year',$year)->where('ttmct.term',$term);
        if(!empty($grade_id)){
            $this->db->where('ttmct.grade_id',$grade_id);   
        }
        if(!empty($grade_id) && !empty($class_id)){
            $this->db->where('ttmct.class_id',$class_id);
        }
        $this->db->order_by('ttmct.census_id')->order_by('ttmct.grade_id')->order_by('ttmct.class_id');
        $query = $this->db->get();
        if($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }       
    }
    // here not deleting  marks. but deleting finalizing data from marks confirm table
    function delete_confirmed_marks($marks_conf_id){
        $this->db->where('marks_conf_id',$marks_conf_id);
        $this->db->delete('term_test_marks_confirm_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}