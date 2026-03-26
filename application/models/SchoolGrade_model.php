<?php
class SchoolGrade_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    // check school Grade already exists
    function check_school_grade_exists( $census_id,$grade_id,$year ){
        $this->db->select('*');
        $this->db->from('school_grade_tbl');
        $this->db->where('census_id',$census_id)->where('grade_id',$grade_id)->where('year',$year);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
    // not used yet
    function check_grade_head_exists_in_this_grade( $census_id,$grade_id,$grade_head,$year ){
        $this->db->select('*');
        $this->db->from('school_grade_tbl');
        $this->db->where('census_id',$census_id)->where('grade_id',$grade_id)->where('stf_nic',$grade_head)->where('year',$year);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
    // check school grade head already exists in another grade  - SchoolGrades Controller when update grade
    function check_grade_head_exists_in_another_grade( $census_id,$grade_head,$grade_id,$year ){
        $this->db->select('*');
        $this->db->from('school_grade_tbl');
        $this->db->where('census_id',$census_id)->where('stf_nic',$grade_head)->where('year',$year)->where('grade_id !=',$grade_id); // not equal to this grade
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    // insert new grade by admin and school - SchoolGrade controller AddSchGrade method
    function insert_school_grade($data){
        //echo $censusId; 
        $this->db->insert('school_grade_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    // no of students must be in a class is entered when a new class is created by the school.
    // sum of those no of students is taken grade wise.
    function get_student_count_of_a_grade($census_id,$grade_id,$year){
        $this->db->select('sum(student_count) as student_count');
        $this->db->from('school_grade_class_tbl sgct');

        $this->db->where('sgct.census_id',$census_id)->where('sgct.grade_id',$grade_id)->where('sgct.year',$year);
        $this->db->order_by('sgct.grade_id');
        //$this->db->group_by('sgct.grade_id');
        $row = $this->db->get()->row();
        if (isset($row)) {
            return $row->student_count;
        } else {
            return false;
        }   
    }

    // get all grades availble in the grade_tbl in db according to grade span of a school 
    // used in SchoolGrades controller index method when the user is school
    function get_grades_by_grade_span($grd_span_id){
        $this->db->select('grade_id, grade');
        $this->db->from('grade_tbl gt');
        if($grd_span_id==1){
            $this->db->where('gt.grade_id <= 5'); // grade span = 1-5
        }
        if($grd_span_id==2){
            $this->db->where('gt.grade_id <= 9'); // grade span = 1-9
        }
        if($grd_span_id==3){
            $this->db->where('gt.grade_id <= 11'); // grade span = 1-11
        }
        if($grd_span_id==4){
            $this->db->where('gt.grade_id >= 1'); // grade span = 1-13
        }
        if($grd_span_id==5){
            $this->db->where('gt.grade_id >= 6'); // grade span = 6-13
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }

    // get school's grades that are only assigned for the current year 
    // used when insert bulk students for a grade
    // used when load marks index page // used when load details of school grades // grades->index view - when add new class by admin
    function get_school_grades_by_census_id($census_id, $year){
        $this->db->select('sgt.sch_grd_id, sgt.grade_id, gt.grade, sgt.stf_nic, st.name_with_ini, st.phone_mobile1,sgt.census_id as school_id, sdt.sch_name, sgt.date_updated as updated_dt, sgt.year');
        $this->db->from('school_grade_tbl sgt');
        $this->db->join('grade_tbl gt','sgt.grade_id = gt.grade_id');
        $this->db->join('staff_tbl st','sgt.stf_nic = st.nic_no','left'); // sgt table is left table 
        $this->db->join('school_details_tbl sdt','sgt.census_id = sdt.census_id');
        $this->db->where('sgt.census_id',$census_id)->where('sgt.year',$year);
        $this->db->order_by('sgt.grade_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }
    // get school's grade span id 
    // used in SchoolGrades controller, Index method
    function get_grade_span_by_census_id($census_id){
        $this->db->select('grd_span_id');
        $this->db->from('school_details_tbl sdt');
        $this->db->where('sdt.census_id',$census_id);
        $row = $this->db->get()->row();
        if (isset($row)) {
            return $row->grd_span_id;
        } else {
            return false;
        }  
    }
    // get grade id
    function get_grade_id($sch_grd_cls_id){
        $this->db->select('grade_id');
        $this->db->from('school_grade_class_tbl sgct');
        $this->db->where('sgct.sch_grd_cls_id',$sch_grd_cls_id);
        $row = $this->db->get()->row();
        if (isset($row)) {
            return $row->grade_id;
        } else {
            return false;
        }  
    }
    // get grade info by sch_grd_id - school grade id
    function get_grade_info($sch_grd_id){
        $this->db->select('*');
        $this->db->from('school_grade_tbl sgt');
        $this->db->where('sgt.sch_grd_id',$sch_grd_id);
        $row = $this->db->get()->row();
        if (isset($row)) {
            return $row->grade_id;
        } else {
            return false;
        }  
    }
    // update school grade details by admin or school in grades->index view
    function update_school_grade($data){
        $id = $data['sch_grd_id'];
        $this->db->where('sch_grd_id',$id);
        $this->db->update('school_grade_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    // delete school grade by admin or school in grades->index view 
    function delete_school_grade($sch_grd_id){
        $this->db->where('sch_grd_id',$sch_grd_id);
        $this->db->delete('school_grade_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}