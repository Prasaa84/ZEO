<?php
class Student_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    function add_parent($data){
        $this->db->insert('response_person_tbl', $data);
        if($this->db->affected_rows()>0){
            $parent_id = $this->db->insert_id();
            return $parent_id;
        }else{
            return false;
        }
    }
    function add_student($data){
        $this->db->insert('student_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    function view_student_by_id($index_no){ // used to check whether student exists when add a new student
        $this->db->select('*');
        $this->db->from('student_tbl');
        $this->db->where('index_no',$index_no);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function view_students_school_wise($census_id){ // view students according to census id view student page
        $this->db->select('*,st.date_updated as last_update');
        $this->db->from('student_tbl st');
        $this->db->join('gender_tbl g','g.gender_id = st.gender_id','left');
        $this->db->join('student_grades_tbl gr','gr.grade_id = st.grade_id','left');
        $this->db->join('student_classes_tbl cl','cl.class_id = st.class_id','left');
        $this->db->join('response_person_tbl rp','rp.response_person_id = st.response_person_id','left');
        $this->db->where('census_id',$census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_stu_info($st_id, $census_id){
        $this->db->select('*,st.date_updated as last_update,gt.gender_name,sgt.grade_name,sct.class_name');
        $this->db->from('student_tbl st');
        $this->db->join('gender_tbl gt','st.gender_id = gt.gender_id','left');
        $this->db->join('student_grades_tbl sgt','st.grade_id = sgt.grade_id','left');
        $this->db->join('student_classes_tbl sct','st.class_id = sct.class_id','left');
        $this->db->join('response_person_tbl rpt','st.response_person_id = rpt.response_person_id','left');       
        $this->db->where('st.st_id',$st_id)->where('st.census_id',$census_id);
        $query = $this->db->get();      
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function get_stu_info_by_index($index_no){
        $this->db->select('*,st.date_updated as last_update,gt.gender_name,sgt.grade_name,sct.class_name');
        $this->db->from('student_tbl st');
        $this->db->join('gender_tbl gt','st.gender_id = gt.gender_id','left');
        $this->db->join('student_grades_tbl sgt','st.grade_id = sgt.grade_id','left');
        $this->db->join('student_classes_tbl sct','st.class_id = sct.class_id','left');
        $this->db->join('response_person_tbl rpt','st.response_person_id = rpt.response_person_id','left');       
        $this->db->where('st.index_no',$index_no);
        $query = $this->db->get();      
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function count_stu_by_grd($census_id){
        $this->db->select('count(*)');
        $this->db->from('student_tbl st');
        $this->db->group_by('st.grade_id'); 
        $this->db->order_by('st.grade_id','asc');         
        $query = $this->db->get();      
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function count_student_gradewise($census_id){
        $this->db->select('grade_id,count(grade_id) as no_of_students, max(date_updated) as date_updated');
        $this->db->from('student_tbl st');
        $this->db->where('st.census_id',$census_id);
        $this->db->group_by('st.grade_id'); 
        $this->db->order_by('st.grade_id','asc');         
        $query = $this->db->get();      
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function count_student_schoolwise(){
        $this->db->select('sch_name, st.census_id, count(st.census_id) as no_of_students, max(st.date_updated) as date_updated');
        $this->db->from('student_tbl st');
        $this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id','left');
        $this->db->group_by('st.census_id'); 
        $this->db->order_by('st.census_id','asc');         
        $query = $this->db->get();      
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function count_student_genderwise(){
        $this->db->select('gt.gender_name,count(st.gender_id) as std_count');
        $this->db->from('student_tbl st');
        $this->db->join('gender_tbl gt','st.gender_id = gt.gender_id','left');
        if($this->session->userdata['userrole'] == 'School User'){
            $census_id = $this->session->userdata['census_id'];
            $this->db->where('st.census_id',$census_id);
        }
        $this->db->group_by('st.gender_id'); 
        $this->db->order_by('st.gender_id','asc');         
        $query = $this->db->get();      
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }

}