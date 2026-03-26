<?php
class Subject_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    // advanced level subjects according to stream 
    public function get_all_subjects(){
        $this->db->select('*');
        $this->db->from('subject_tbl st');
        $this->db->order_by('st.subject');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // get subject name according to subject id. used in Marks Controller->positionOnMarks()
    public function get_subject_name($subject_id){
        $this->db->select('subject');
        $this->db->from('subject_tbl');
        $this->db->where('subject_id',$subject_id);
        return $this->db->get()->row('subject');
    }
    // used when insert staff data, update staff data
    public function get_subjects_section_wise($section_id){
        $this->db->select('*');
        $this->db->from('subject_tbl st');
        $this->db->join('subject_category_tbl sct','st.sub_cat_id = sct.sub_cat_id','left');
        $this->db->where('section_id',$section_id);
        $this->db->order_by('st.sub_cat_id')->order_by('st.subject_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used when subjects are assigned to grades in Subjects Controller -> addSubjectsToGrade()
    public function get_subject_by_subj_id($subject_id){
        $this->db->select('*');
        $this->db->from('subject_tbl st');
        //$this->db->join('subject_category_tbl sct','st.sub_cat_id = sct.sub_cat_id','left');
        $this->db->where('subject_id',$subject_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // this is used to view selected subjects by schoool,
    public function get_subjects_of_a_grade($census_id,$grade_id,$subject_id,$year){
        $this->db->select('*,sgt.date_updated as subj_upd_dt');
        $this->db->from('subjects_grade_tbl sgt');
        $this->db->join('grade_tbl gt','sgt.grade_id = gt.grade_id','left');
        $this->db->where('sgt.census_id',$census_id)->where('sgt.grade_id',$grade_id)->where('sgt.subject_id',$subject_id)->where('sgt.year',$year);
        //$this->db->order_by('st.subject');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used to print(export) to excel selected subjects by schoool,
    // section id is used to fetch subject name from subject table since same subject name may be in many sections
    // used in positionOnMarks view too to load subjects when a grade is selected
    public function get_selected_subjects_of_a_grade($census_id, $grade_id, $year, $section_id){
        $this->db->select('*,sgt.date_updated as last_update');
        $this->db->from('subjects_grade_tbl sgt');
        $this->db->join('grade_tbl gt','sgt.grade_id = gt.grade_id');
        $this->db->join('subject_tbl st','sgt.subject_id = st.subject_id');
        $this->db->join('subject_category_tbl sct','st.sub_cat_id = sct.sub_cat_id');
        $this->db->join('school_details_tbl sdt','sgt.census_id = sdt.census_id');
        if( $census_id == 'All' ){
            $this->db->where('sgt.grade_id',$grade_id)->where('sgt.year',$year)->where('st.section_id',$section_id);
            $this->db->group_by('sgt.subject_id');
        }else{
            $this->db->where('sgt.census_id',$census_id)->where('sgt.grade_id',$grade_id)->where('sgt.year',$year)->where('st.section_id',$section_id);
        }
        //$this->db->order_by('st.subject');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // this is used to delete already selected subjects by schoool, when select and save subjects again.
    // subject controller line no 101
    public function check_subjects_of_grade_exist($census_id,$grade_id,$year){
        $this->db->select('*');
        $this->db->from('subjects_grade_tbl sgt');
        $this->db->where('census_id',$census_id)->where('grade_id',$grade_id)->where('year',$year);
        //$this->db->order_by('st.subject');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // add subjects to a grade
    function add_subjects_to_grade($census_id,$grade_id,$subjects,$year){
        $now = date('Y-m-d H:i:s');
        $x=1;
        foreach ($subjects as $subject) {
            $data = array(
                'subj_grd_id' => '',
                'census_id' => $census_id,
                'grade_id' => $grade_id,
                'subject_id' => $subject,
                'year' => $year,
                'order_id' => $x,
                'date_added' => $now,
                'date_updated' => $now,
            );
            $this->db->insert('subjects_grade_tbl', $data);    
            $x++;  
        }
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    // delete school class 
    function delete_subjects_of_grade($census_id,$grade_id,$year){
        $this->db->where('census_id',$census_id)->where('grade_id',$grade_id)->where('year',$year);
        $this->db->delete('subjects_grade_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }    
   
}

?>