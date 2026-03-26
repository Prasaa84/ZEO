<?php
class SchoolClass_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    // used when add new classes in SchoolClasses Controller - addSchClasses()
    // check school class already exists
    function check_school_class_exists($grade_id,$class_id,$census_id,$year){
        $this->db->select('*');
        $this->db->from('school_grade_class_tbl');
        $this->db->where('grade_id',$grade_id)->where('class_id',$class_id)->where('census_id',$census_id)->where('year',$year);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
    // check classes already exists in a particular grade, used when delete a grade
    // used in SchoolGrades controller - deleteSchoolGrade
    function check_classes_exists($grade_id, $census_id, $year){
        $this->db->select('*');
        $this->db->from('school_grade_class_tbl');
        $this->db->where('grade_id',$grade_id)->where('census_id',$census_id)->where('year',$year);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
    // insert grades by school
    function insert_school_classes($data){
        //echo $censusId; 
        //print_r($grades); die();
        $this->db->insert('school_grade_class_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    // update school class details by school
    function update_school_class($data){
        $id = $data['sch_grd_cls_id'];
        $this->db->where('sch_grd_cls_id',$id);
        $this->db->update('school_grade_class_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    // not used yet
    function check_cls_tr_exists_in_this_class($sch_grd_cls_id,$stf_id){
        $this->db->select('*');
        $this->db->from('school_grade_class_tbl');
        $this->db->where('sch_grd_cls_id',$sch_grd_cls_id)->where('stf_id',$stf_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
    // check school class teacher already exists in another class  - SchoolClasses Controller when insert classes 
    function check_cls_tr_exists_in_another_grade( $census_id, $cls_tr_nic, $year){
        $this->db->select('*');
        $this->db->from('school_grade_class_tbl');
        $this->db->where('census_id',$census_id)->where('stf_nic',$cls_tr_nic)->where('year',$year); // not equal to this grade
        // if( !empty($grade_id) ){
        //     $this->db->where('grade_id',$grade_id);
        // }
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    // get school's classes that are already assigned  classes->index view
    // used in grade class reports also
    function get_school_classes_by_census_id($census_id,$year){
        $this->db->select('sgct.grade_id, gt.grade, sgct.stf_nic,st.name_with_ini,st.phone_mobile1,sgct.census_id as school_id,sgct.date_updated as updated_dt,sgct.approved_std_count as approved_std_count,sgct.student_count as std_count,sgct.class_id,ct.class,sgct.sch_grd_cls_id,sgct.year,sdt.sch_name');
        $this->db->from('school_grade_class_tbl sgct');
        $this->db->join('school_grade_tbl sgt','sgct.grade_id = sgt.grade_id');
        $this->db->join('grade_tbl gt','sgct.grade_id = gt.grade_id');
        $this->db->join('class_tbl ct','sgct.class_id = ct.class_id');
        $this->db->join('staff_tbl st','sgct.stf_nic = st.nic_no','left'); 
        $this->db->join('school_details_tbl sdt','sgct.census_id = sdt.census_id');
        $this->db->where('sgct.census_id',$census_id)->where('sgct.year',$year)->where('sgt.census_id',$census_id)->where('sgt.year',$year);
        $this->db->order_by('sgct.grade_id')->order_by('sgct.class_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }   
    }

    // get classes of selected grade of logged school
    // used in student controller line 1149
    public function get_classes_grade_wise($condition){
        $this->db->select('*');
        $this->db->from('school_grade_class_tbl sgct');
        $this->db->join('grade_tbl gt','gt.grade_id = sgct.grade_id','left');
        $this->db->join('class_tbl ct','ct.class_id = sgct.class_id','left');
        $this->db->join('school_details_tbl sdt','sgct.census_id = sdt.census_id');
        $this->db->where($condition);
        $this->db->order_by('sgct.class_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // get class count of a selected grade of logged school
    // used in student controller - StudentsInClasses method- line 1210
    public function get_class_count_grade_wise($grade_id,$census_id,$year){
        $this->db->select('*');
        $this->db->from('school_grade_class_tbl sgct');
        $this->db->where('sgct.grade_id',$grade_id)->where('sgct.census_id',$census_id)->where('sgct.year',$year);
        $query = $this->db->get();
        return $query->num_rows();
    }
    // get class count of a selected school in this year
    // used in marks model - get_shortage_of_term_test_marks() method- line 318 to view alert notification
    public function get_class_count_school_wise($census_id,$year){
        $this->db->select('*');
        $this->db->from('school_grade_class_tbl sgct');
        $this->db->where('sgct.census_id',$census_id)->where('sgct.year',$year);
        $query = $this->db->get();
        return $query->num_rows();
    }
    // delete school class 
    function delete_class($sch_grd_cls_id){
        $this->db->where('sch_grd_cls_id',$sch_grd_cls_id);
        $this->db->delete('school_grade_class_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // get class id when delete a class in class -> index view using ajax
    // grade_class_id is passed to this method
    function get_class_id($sch_grd_cls_id){
        $this->db->select('class_id');
        $this->db->from('school_grade_class_tbl sgct');
        $this->db->where('sgct.sch_grd_cls_id',$sch_grd_cls_id);
        $row = $this->db->get()->row();
        if (isset($row)) {
            return $row->class_id;
        } else {
            return false;
        }  
    }
    // get grade id when delete a class in class -> index view using ajax
    // grade_class_id is passed to this method
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
}