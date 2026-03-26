<?php
class News_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }
    function get_news($news_id){
        $this->db->select('*');
        $this->db->from('news_tbl');
        $this->db->where('news_id',$news_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function get_all_news($limitNo){
        $this->db->select('*');
        $this->db->from('news_tbl');
        $this->db->order_by('date_added','desc');
        $this->db->where('is_deleted','0');
        if(!empty($limitNo)){
            $this->db->limit($limitNo);   // limit the result
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    // used to make archive in public news and events page and also in admin news index page
    function get_news_added_date(){
        $this->db->select('date_added');
        $this->db->from('news_tbl');
        $this->db->group_by('date_format(date_added,"%Y-%m")');
        $this->db->order_by('date_added','desc');
        $this->db->where('is_deleted','0');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // 
    function view_news_by_id($id){ 
        $this->db->select('*');
        $this->db->from('news_tbl');
        $this->db->where('news_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }  
    }
    function update_news($data){
        $id = $data['news_id'];
        $this->db->where('news_id',$id);
        $this->db->update('news_tbl',$data); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    function get_news_by($condition){
        $this->db->select('*');
        $this->db->from('news_tbl');
        $this->db->where($condition);
        $this->db->order_by('date_added','desc');
        $this->db->where('is_deleted','0');
        $query = $this->db->get();
        if($query->num_rows() > 0){ 
            return $query->result();
        }else{ 
            return false; 
        } 
    }
    // insert new news
    function add_news($data){
        $this->db->insert('news_tbl', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    function get_last_news(){ // not used
        $this->db->select('*');
        $this->db->from('news_tbl');
        // $this->db->where('is_deleted',0); // auto increment of news_id and there are is_deleted = 1 also
        $this->db->order_by('date_added','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
    function delete_news($news_id,$now){
        $this->db->set('is_deleted','1'); // the news is not physically deleted from db
        $this->db->set('date_updated',$now); // the news is not physically deleted from db
        $this->db->where('news_id',$news_id);
        $this->db->update('news_tbl');
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
}

?>