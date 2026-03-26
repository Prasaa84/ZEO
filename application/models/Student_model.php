<?php
class Student_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    function add_parent($data)
    {
        $this->db->insert('guardian_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            $parent_id = $this->db->insert_id();
            return $parent_id;
        } else {
            return false;
        }
    }
    // add student to system 
    function add_student($data)
    {
        $this->db->insert('student_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // add bulk students to system
    function insert_bulk_students($data)
    {
        $this->db->insert_batch('student_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // add bulk students to system
    function add_student_history($data)
    {
        $this->db->insert('student_history_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // add individual student to a class
    // used when update student's academic info by school or admin. Student controller line 969 updateStudentAcademicInfo() 
    function add_student_to_a_class($data)
    {
        $this->db->insert('student_grade_class_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // add bulk students to a class
    function insert_bulk_students_to_class($data)
    {
        $this->db->insert_batch('student_grade_class_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used to check whether student exists in the system, when adding a new student to the system using bulk upload
    // used when adding individual student
    function check_student_exist($index_no, $census_id)
    {
        $this->db->select('*');
        $this->db->from('student_tbl st');
        $this->db->where('index_no', $index_no)->where('census_id', $census_id);
        //$this->db->where('st.is_deleted',0); // if the index no is already exists, bus student has been deleted, see him in inactive students. if the student with this index no. has been deleted, you cant insert a student with same index no. but you can active him by admin  
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used when insert a student to a class using bulk upload by school
    // used to check whether student exists in a class in this year
    // used when a student academic info is updated by school or admin. Student controller line 961
    function check_student_exist_in_a_class($index_no, $census_id, $year)
    {
        $this->db->select('*');
        $this->db->from('student_grade_class_tbl');
        $this->db->where('index_no', $index_no)->where('census_id', $census_id)->where('year', $year);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used when load student index page by a school user
    function view_students_school_wise($census_id)
    { // view students according to census id
        $this->db->select('*,st.index_no as index_no, st.date_updated as last_update');
        $this->db->from('student_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left');
        $this->db->join('gender_tbl g', 'g.gender_id = st.gender_id', 'left');
        $this->db->where('st.census_id', $census_id)->where('st.is_deleted', '0');
        $this->db->order_by('st.census_id', 'asc')->order_by('st.index_no');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used when load student index page by admin
    // student controller index method line no, 
    public function get_all_students()
    {
        $this->db->select('*,st.index_no as index_no,st.date_updated as last_update,gt.gender_name');
        $this->db->from('student_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id');
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left');
        if ($this->session->userdata['userrole_id'] == 7) {
            $div_id = $this->session->userdata['div_id'];
            $this->db->where('sdt.div_id', $div_id);
        } elseif ($this->session->userdata['userrole_id'] == '2') {
            $census_id = $this->session->userdata['census_id'];
            $this->db->where('st.census_id', $census_id);
        }
        $this->db->where('st.is_deleted', '0');
        $this->db->order_by('st.census_id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used school user in student reports view
    public function get_all_students_for_report($gender = '', $religion = '', $ethnic = '', $status = '', $census_id = '')
    {
        $this->db->select('*,st.index_no as index_no,st.date_updated as last_update,gt.gender_name');
        $this->db->from('student_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id');
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left');
        $this->db->join('ethnic_group_tbl egt', 'st.ethnic_group_id = egt.ethnic_group_id', 'left');
        $this->db->join('religion_tbl rt', 'st.religion_id = rt.religion_id', 'left');
        $this->db->join('student_status_tbl sst', 'st.st_status_id = sst.st_status_id', 'left');
        $year = date('Y');
        if (!empty($census_id)) {
            $this->db->where('st.census_id', $census_id);
        }
        if ($this->session->userdata['userrole_id'] == 7) {
            $div_id = $this->session->userdata['div_id'];
            $this->db->where('sdt.div_id', $div_id);
        }
        if (!empty($gender)) {
            $this->db->where('st.gender_id', $gender);
        }
        if (!empty($religion)) {
            $this->db->where('st.religion_id', $religion);
        }
        if (!empty($ethnic)) {
            $this->db->where('st.ethnic_group_id', $ethnic);
        }
        if (!empty($status)) {
            $this->db->where('st.st_status_id', $status);
        }
        $this->db->where('st.is_deleted', '0');
        $this->db->order_by('st.census_id')->order_by('st.index_no');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // // used school user in student reports view
    // public function get_all_students_for_report_by($condition){
    //     $this->db->select('*,st.index_no as index_no,st.date_updated as last_update,gt.gender_name');
    //     $this->db->from('student_tbl st');
    //     $this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id');
    //     $this->db->join('gender_tbl gt','st.gender_id = gt.gender_id','left');
    //     $this->db->join('ethnic_group_tbl egt','st.ethnic_group_id = egt.ethnic_group_id','left');
    //     $this->db->join('religion_tbl rt','st.religion_id = rt.religion_id','left');
    //     $this->db->join('student_status_tbl sst','st.st_status_id = sst.st_status_id','left');
    //     $year = date('Y');   
    //     if( $this->session->userdata['userrole_id'] == '2' ){
    //         $census_id = $this->session->userdata['census_id'];
    //         $this->db->where('st.census_id',$census_id);
    //     }
    //     $this->db->where($condition);
    //     $this->db->where('st.is_deleted','0');
    //     $this->db->order_by('st.census_id')->order_by('st.index_no');         
    //     $query = $this->db->get();      
    //     if ($query->num_rows() > 0) {
    //         return $query->result();
    //     } else {
    //         return false;
    //     }  
    // }

    // not used
    function get_student_current_grade_class2($index_no, $census_id, $year)
    {
        $this->db->select('*');
        $this->db->from('student_grade_class_tbl stgct');
        $this->db->join('grade_tbl gt', 'stgct.grade_id = gt.grade_id', 'left');  // please keep left join here...
        $this->db->join('class_tbl ct', 'stgct.class_id = ct.class_id', 'left');
        $this->db->where('stgct.index_no', $index_no)->where('stgct.census_id', $census_id)->where('stgct.year', $year);
        $this->db->order_by('stgct.grade_id', 'asc')->order_by('stgct.class_id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used in Student controller line no 72, student index view
    // used when update student academic details, used in student individual reports
    function get_student_current_grade_class($index_no, $census_id)
    {
        $this->db->select('*,max(stgct.year) as year,stgct.date_updated as last_update');
        $this->db->from('student_grade_class_tbl stgct');
        $this->db->join('grade_tbl gt', 'stgct.grade_id = gt.grade_id', 'left');  // please keep left join here...
        $this->db->join('class_tbl ct', 'stgct.class_id = ct.class_id', 'left');
        $this->db->where('stgct.index_no', $index_no)->where('stgct.census_id', $census_id);
        $this->db->order_by('stgct.grade_id', 'asc')->order_by('stgct.class_id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used when loading student data update page by school user but without grade and class
    // used by admin when update a student in student controller - editStudentInfoPage - line 839, line 947
    function get_stu_info($st_id)
    {
        //$year = date("Y"); // get current year, bcz grade and class must be present values
        $this->db->select('*,st.index_no as index_no, st.address1 as st_adr_1, st.address2 as st_adr_2, st.census_id as census_id,st.date_added as added_date,st.date_updated as last_update,g.gender_name,st.is_deleted as std_is_deleted');
        $this->db->from('student_tbl st');
        $this->db->join('gender_tbl g', 'st.gender_id = g.gender_id', 'left');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left');
        //$this->db->join('grade_tbl gt','stgct.grade_id = gt.grade_id','left');
        //$this->db->join('class_tbl ct','stgct.class_id = ct.class_id','left');
        $this->db->join('guardian_tbl gdt', 'st.index_no = gdt.index_no', 'left');
        $this->db->join('ethnic_group_tbl egt', 'st.ethnic_group_id = egt.ethnic_group_id', 'left'); // ethnic group
        $this->db->join('religion_tbl rt', 'st.religion_id = rt.religion_id', 'left');   // religion 
        $this->db->join('student_status_tbl sst', 'st.st_status_id = sst.st_status_id', 'left');   // religion 
        $this->db->where('st.st_id', $st_id);
        //$this->db->where('st.st_id',$st_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used in student controller - findStudentsForReports() to send data to students reports view
    function get_stu_info_by_index($index_no, $census_id)
    {
        $this->db->select('*,st.date_updated as last_update,st.date_added as added_date, st.address1 as std_address1, st.address2 as std_address2 ');
        $this->db->from('student_tbl st');
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id');
        $this->db->join('student_status_tbl sst', 'st.st_status_id = sst.st_status_id', 'left');
        $this->db->join('ethnic_group_tbl egt', 'st.ethnic_group_id = egt.ethnic_group_id', 'left');
        $this->db->join('religion_tbl rt', 'st.religion_id = rt.religion_id', 'left');

        $this->db->where('st.index_no', $index_no)->where('st.census_id', $census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used in student controller - findStudentByAdmNo() to send data to changeAdmNo view via ajax
    function get_stu_info_by_adm_no($index_no, $census_id)
    {
        $this->db->select('*,st.date_updated as last_update,st.date_added as added_date, st.address1 as std_address1, st.address2 as std_address2 ');
        $this->db->from('student_tbl st');
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id');
        $this->db->join('student_status_tbl sst', 'st.st_status_id = sst.st_status_id', 'left');
        $this->db->join('ethnic_group_tbl egt', 'st.ethnic_group_id = egt.ethnic_group_id', 'left');
        $this->db->join('religion_tbl rt', 'st.religion_id = rt.religion_id', 'left');
        $this->db->join('ethnic_group_tbl egt', 'st.ethnic_group_id = egt.ethnic_group_id', 'left');
        $this->db->join('religion_tbl rt', 'st.religion_id = rt.religion_id', 'left');
        $this->db->where('st.index_no', $index_no)->where('st.census_id', $census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function count_stu_by_grd($census_id)
    {
        $this->db->select('count(*)');
        $this->db->from('student_tbl st');
        $this->db->group_by('st.grade_id');
        $this->db->order_by('st.grade_id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    /*function count_student_gradewise($census_id){
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
    }*/
    function count_student_schoolwise()
    {
        $this->db->select('sdt.sch_name, sdt.census_id, count(st.census_id) as no_of_students, max(st.date_updated) as date_updated');
        $this->db->from('student_tbl st');
        $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left');
        $this->db->group_by('sdt.census_id');
        //$this->db->order_by('st.census_id','asc');         
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used in admin dashboard and edu. div user dashboard
    function count_student_genderwise()
    {
        $this->db->select('gt.gender_name,count(st.gender_id) as std_count');
        $this->db->from('student_tbl st');
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left');
        if ($this->session->userdata['userrole'] == 'School User') {
            $census_id = $this->session->userdata['census_id'];
            $this->db->where('st.census_id', $census_id);
        } elseif ($this->session->userdata['userrole_id'] == '7') {
            $edu_div_id = $this->session->userdata['div_id'];
            $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left');
            $this->db->where('sdt.div_id', $edu_div_id);
        }
        $this->db->where('st.is_deleted', 0);
        $this->db->group_by('st.gender_id');
        $this->db->order_by('st.gender_id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used in admin dashboard and edu. div user dashboard, school user dashboard
    function count_all_students()
    {
        $this->db->select('*');
        $this->db->from('student_tbl st');
        if ($this->session->userdata['userrole_id'] == '2') {
            $census_id = $this->session->userdata['census_id'];
            $this->db->where('st.census_id', $census_id);
        } elseif ($this->session->userdata['userrole_id'] == '7') {
            $edu_div_id = $this->session->userdata['div_id'];
            $this->db->join('school_details_tbl sdt', 'st.census_id = sdt.census_id', 'left');
            $this->db->where('sdt.div_id', $edu_div_id);
        }
        $this->db->where('st.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    // used in school classes index page to view current total of students in this class (students who are inserted annually to the classes are taken class wise)
    function get_student_count_of_a_class($census_id, $grade_id, $class_id, $year)
    {
        $this->db->select('*');
        $this->db->from('student_grade_class_tbl stgct');
        $this->db->join('student_tbl st', 'stgct.index_no = st.index_no');
        $this->db->where('stgct.census_id', $census_id)->where('stgct.grade_id', $grade_id)->where('stgct.class_id', $class_id)->where('stgct.year', $year)->where('st.census_id', $census_id)->where('st.is_deleted', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
    // used in school grades index page to view current total of students(who are inserted to the classes annually are taken grade wise) in this grade.
    function get_student_count_of_a_grade($census_id, $grade_id, $year)
    {
        $this->db->select('*');
        $this->db->from('student_grade_class_tbl stgct');
        $this->db->join('student_tbl st', 'stgct.index_no = st.index_no');
        $this->db->where('stgct.census_id', $census_id)->where('stgct.grade_id', $grade_id)->where('stgct.year', $year)->where('st.census_id', $census_id)->where('st.is_deleted', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return false;
        }
    }
    // students current class is maintained in student_grade_class_tbl
    // this is used when deleting a class in class->index view and SchoolClasses controller-deleteSchoolClass method
    function check_students_exists_in_a_class($census_id, $grade_id, $class_id, $year)
    {
        $this->db->select('*');
        $this->db->from('student_grade_class_tbl stgct');
        $this->db->where('stgct.census_id', $census_id)->where('stgct.grade_id', $grade_id)->where('stgct.class_id', $class_id)->where('stgct.year', $year);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // this is used in studentBulkUploadView line 247. used in deleteMarks() in Marks controller
    // used in marks controller to view template of the marksheet in line 172
    function get_students_in_a_class($census_id, $grade_id, $class_id, $year = "")
    {
        //echo $year; die();
        $this->db->select('*,stgct.date_updated as last_update');
        $this->db->from('student_grade_class_tbl stgct');
        $this->db->join('student_tbl st', 'stgct.index_no = st.index_no');
        $this->db->where('stgct.census_id', $census_id)->where('stgct.grade_id', $grade_id)->where('stgct.class_id', $class_id)->where('stgct.year', $year)->where('st.census_id', $census_id); //this statement is necessary. when student not in school but in a class in same school, then that student to be removed from student classes view
        $this->db->order_by('st.index_no', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // not used yet
    function delete_student_from_class($adm_no, $census_id, $year)
    {
        $this->db->where('index_no', $adm_no)->where('census_id', $census_id)->where('year', $year);
        $this->db->delete('student_grade_class_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // get student's grade and class. Student controller line 578
    function get_student_grade_class($adm_no, $census_id, $year)
    {
        $this->db->select('*,sgct.date_added as added_date');
        $this->db->from('student_grade_class_tbl sgct');
        $this->db->join('grade_tbl gt', 'sgct.grade_id = gt.grade_id', 'left');
        $this->db->join('class_tbl ct', 'sgct.class_id = ct.class_id', 'left');
        $this->db->where('sgct.index_no', $adm_no)->where('sgct.census_id', $census_id)->where('sgct.year', $year);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // update student class details, used in editStudent page by admin and school user
    // student controller updateStudentAcademicInfo() line 962
    function update_student_grade_class($data)
    {
        $id = $data['st_gr_cl_id'];
        $this->db->where('st_gr_cl_id', $id);
        $this->db->update('student_grade_class_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // update student class details, used when delete student by school user
    // student controller->deleteStudent()
    function delete_student_grade_class($data)
    {
        $index_no = $data['index_no'];
        $census_id = $data['census_id'];
        $year = $data['year'];
        $this->db->where('index_no', $index_no)->where('census_id', $census_id)->where('year', $year);
        $this->db->update('student_grade_class_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used by admin and school user when update academic info. Student controller line 957. used when delete student from the system by school user. ex- is_deleted = 1. Student controller - deleteStudent method. used when activate the deleted student in activateStudent method Student controller
    function update_student_personal_info($data)
    {
        $id = $data['st_id'];
        $this->db->where('st_id', $id);
        $this->db->update('student_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // change the admission number of a student by admission number and census id 
    // used in Student controller -> changeAdmNo(){
    function change_std_adm_no($census_id, $cur_adm_no, $new_adm_no)
    {
        $this->db->set('index_no', $new_adm_no);
        $this->db->where('census_id', $census_id)->where('index_no', $cur_adm_no);
        $this->db->update('student_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used when update student data
    function update_student_history($data)
    {
        $index_no = $data['index_no'];
        $census_id = $data['census_id'];
        $this->db->where('index_no', $index_no)->where('census_id', $census_id);
        $this->db->update('student_history_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function add_guardian($data)
    {
        $this->db->insert('guardian_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // get student's parents or guardian's data. Student controller line 853
    function get_guardian($index_no, $census_id)
    {
        $this->db->select('*,gt.date_updated as last_update');
        $this->db->from('guardian_tbl gt');
        $this->db->where('gt.index_no', $index_no)->where('gt.census_id', $census_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function update_guardian($data)
    {
        $id = $data['id'];
        $this->db->where('id', $id);
        $this->db->update('guardian_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // used when add bulk students to a class in Student controller line 681 addBulkStudentsToClass method
    // used when delete all students in studentsinClass view using ajax, Student contr. deleteAllStudentsInAClass method
    function delete_all_students_from_class($grade_id, $class_id, $year, $census_id)
    {
        $this->db->where('grade_id', $grade_id)->where('class_id', $class_id)->where('year', $year)->where('census_id', $census_id);
        $this->db->delete('student_grade_class_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // student controller viewInactiveStudents method. is_deleted = 1 
    public function get_inactive_students($census_id)
    {
        $this->db->select('*,st.date_added as insert_dt, st.date_updated as update_dt');
        $this->db->from('student_tbl st');
        //$this->db->join('school_details_tbl sdt','st.census_id = sdt.census_id','left');
        $this->db->join('gender_tbl gt', 'st.gender_id = gt.gender_id', 'left');
        $this->db->join('student_grade_class_tbl stgct', 'st.index_no = stgct.index_no', 'left');
        $this->db->join('grade_tbl sgt', 'stgct.grade_id = sgt.grade_id', 'left');
        $this->db->join('class_tbl ct', 'stgct.class_id = ct.class_id', 'left');
        //$this->db->join('guardian_tbl gdt','st.index_no = gdt.index_no','left');      
        $this->db->where('st.census_id', $census_id)->where('st.is_deleted', '1');
        $this->db->order_by('st.census_id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // used in inactive student view
    // to delete an inactive student physically from the system by admin
    function delete_student($id)
    { // id is st_id
        $this->db->where('st_id', $id);
        $this->db->delete('student_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // add students game information
    // used when update student's extra curriculam activities. Student controller - AssignToNewGame()
    function insert_std_game_info($data)
    {
        $this->db->insert('student_game_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // get student's game info. Student controller - viewEditStudentViewAfterUpdate()
    function get_std_game_info($index_no, $census_id)
    {
        $this->db->select('*, sgt.date_updated as last_update');
        $this->db->from('student_game_tbl sgt');
        $this->db->join('games_tbl gt', 'sgt.game_id = gt.game_id');
        $this->db->join('student_game_roles_tbl sgrt', 'sgt.std_gm_role_id = sgrt.std_gm_role_id');
        $this->db->where('sgt.index_no', $index_no)->where('sgt.census_id', $census_id);
        $this->db->order_by('sgt.date_added')->order_by('sgt.game_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // this is used when updating student data in student update view
    // Student controller - deleteGameInfo()
    function delete_student_game($id)
    { // id is student game id 
        $this->db->where('st_gm_id', $id);
        $this->db->delete('student_game_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // this is used when adding a game for a student in student update view and Student controller-AssignToNewGame()
    // there must be only one captain for a game on a particular date
    function check_game_captancy_exist($game_id, $game_role_id, $date = '', $year = '')
    {
        $this->db->select('*');
        $this->db->from('student_game_tbl stgt');
        $this->db->where('stgt.game_id', $game_id)->where('stgt.std_gm_role_id', $game_role_id);
        if (!empty($date)) {
            $this->db->where('stgt.date', $date);
        }
        if (!empty($year)) {
            $this->db->where('stgt.year', $year);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // check the member ship of a game of a student - Student controller -> AssignToNewGame()
    function check_game_membership_exist($census_id, $index_no, $game_id)
    {
        $this->db->select('*');
        $this->db->from('student_game_tbl sgt');
        $this->db->where('sgt.census_id', $census_id)->where('sgt.index_no', $index_no)->where('sgt.game_id', $game_id);
        $this->db->where('sgt.std_gm_role_id', 1);   // id 7 = member     
        if (!empty($year)) {
            $this->db->where('stect.year', $year);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // get extra curriculum name
    // used in Studen controller - AssignToNewExtraCurri()
    function get_game_name($game_id)
    {
        $this->db->select('game_name');
        $this->db->from('games_tbl gt');
        $this->db->where('gt.game_id', $game_id);
        $row = $this->db->get()->row();
        if (isset($row)) {
            return $row->game_name;
        } else {
            return false;
        }
    }
    // check extra curriculam activity already has this position(role) for this year
    // student controller -> AssignToNewExtraCurri()
    function check_std_ex_cur_role_exist($census_id, $ex_cu_id, $ex_cu_role_id, $year = "")
    {
        $this->db->select('*');
        $this->db->from('student_extra_curri_tbl stect');
        $this->db->where('stect.census_id', $census_id)->where('stect.extra_curri_id', $ex_cu_id)->where('stect.std_ex_cur_role_id', $ex_cu_role_id);
        if (!empty($year)) {
            $this->db->where('stect.year', $year);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // check the member ship of a student - Student controller -> AssignToNewExtraCurri()
    function check_ex_cur_membership_exist($census_id, $index_no, $ex_cu_id)
    {
        $this->db->select('*');
        $this->db->from('student_extra_curri_tbl stect');
        $this->db->where('stect.census_id', $census_id)->where('stect.index_no', $index_no)->where('stect.extra_curri_id', $ex_cu_id);
        $this->db->where('stect.std_ex_cur_role_id', 7);   // id 7 = member     
        if (!empty($year)) {
            $this->db->where('stect.year', $year);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // check that student has another postion except membership - Student controller -> AssignToNewExtraCurri()
    function is_student_has_position_except_ex_cur_membership($census_id, $index_no, $ex_cu_id, $year)
    {
        $this->db->select('*');
        $this->db->from('student_extra_curri_tbl stect');
        $this->db->where('stect.census_id', $census_id)->where('stect.index_no', $index_no)->where('stect.extra_curri_id', $ex_cu_id)->where('stect.year', $year);
        $this->db->where('stect.std_ex_cur_role_id !=', 7);   // id 7 = member     

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // get extra curriculum name
    // used in Studen controller - AssignToNewExtraCurri()
    function get_ex_cur_name($ex_cur_id)
    {
        $this->db->select('extra_curri_type');
        $this->db->from('extra_curri_tbl exct');
        $this->db->where('exct.extra_curri_id', $ex_cur_id);
        $row = $this->db->get()->row();
        if (isset($row)) {
            return $row->extra_curri_type;
        } else {
            return false;
        }
    }
    // get extra curriculum role name
    // used in Studen controller - AssignToNewExtraCurri()
    function get_ex_cur_role_name($ex_cur_role_id)
    {
        $this->db->select('std_ex_cur_role_name');
        $this->db->from('student_extra_curri_roles_tbl excrt');
        $this->db->where('excrt.std_ex_cur_role_id', $ex_cur_role_id);
        $row = $this->db->get()->row();
        if (isset($row)) {
            return $row->std_ex_cur_role_name;
        } else {
            return false;
        }
    }
    // add students extra curriculum information
    // used when update student's extra curriculam activities. Student controller - AssignToNewExtraCurri()
    function insert_std_ex_cur_info($data)
    {
        $this->db->insert('student_extra_curri_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // get student's extra curriculum info. Student controller - viewEditStudentViewAfterUpdate()
    function get_std_ex_cur_info($index_no, $census_id)
    {
        $this->db->select('*, stect.date_updated as last_update');
        $this->db->from('student_extra_curri_tbl stect');
        $this->db->join('extra_curri_tbl ect', 'stect.extra_curri_id = ect.extra_curri_id');
        $this->db->join('student_extra_curri_roles_tbl stecrt', 'stect.std_ex_cur_role_id = stecrt.std_ex_cur_role_id');
        $this->db->where('stect.index_no', $index_no)->where('stect.census_id', $census_id);
        $this->db->order_by('stect.year', 'desc')->order_by('stect.extra_curri_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // this is used when updating student data in student update view
    // Student controller - deleteGameInfo()
    function delete_std_ex_cur_info($id)
    { // id is student game id 
        $this->db->where('std_ex_cur_id', $id);
        $this->db->delete('student_extra_curri_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // add students winning information
    // used when update student's winnings. Student controller - AddStudentWin()
    function insert_std_winning_info($data)
    {
        $this->db->insert('student_winnings_tbl', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // get student's winnings info. Student controller - viewEditStudentViewAfterUpdate()
    function get_std_winnings($index_no, $census_id)
    {
        $this->db->select('*, swt.date_updated as last_update');
        $this->db->from('student_winnings_tbl swt');
        $this->db->join('extra_curri_tbl ect', 'swt.extra_curri_id = ect.extra_curri_id', 'left');
        $this->db->join('student_extra_curri_roles_tbl stecrt', 'swt.std_ex_cur_role_id = stecrt.std_ex_cur_role_id', 'left');
        $this->db->join('games_tbl gt', 'swt.game_id = gt.game_id', 'left');
        $this->db->join('student_game_roles_tbl sgrt', 'swt.std_gm_role_id = sgrt.std_gm_role_id', 'left');
        $this->db->join('student_win_type_tbl swtt', 'swt.win_type_id = swtt.win_type_id', 'left');
        $this->db->where('swt.index_no', $index_no)->where('swt.census_id', $census_id);
        $this->db->order_by('swt.date_held', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // this is used when updating student data in student update view
    // Student controller - deleteStdWinInfo()
    function delete_std_win_info($id)
    { // id is student winning id (auto increment)
        $this->db->where('std_win_id', $id);
        $this->db->delete('student_winnings_tbl');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
