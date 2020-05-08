<?php
class Alert_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    // add new alert
    // $data is used to get no. of items, $to=alert goes to whom, $cat_id=alert category ex- regarding physical resource
    function addAlert($data,$to,$cat_id){
        $alert_exist = $this->check_alert_exist($to,$cat_id);
        if ($alert_exist) {
            $now = date('Y-m-d H:i:s');
            $this->db->set('alert_desc',$data.' physical resource item details to be updated');
            $this->db->set('date_updated',$now);
            $this->db->where('to_whom',$to)->where('alert_cat_id',$cat_id);
            $this->db->update('alert_tbl');
        }else{
            $now = date('Y-m-d H:i:s');
            $data = array(
                'alert_id' => '',
                'alert_cat_id' => '1',
                'alert_desc' => $data.' physical resource item details to be updated',
                'by_whom' => 'System',
                'to_whom' => $to,
                'date_added' => $now,
                'date_updated' => $now,
                'is_deleted' => '0',
                'is_read' => '0', 
                'when_read'=> ''           
            );
            $this->db->insert('alert_tbl', $data);
            if($this->db->affected_rows()>0){
                return true;
            }else{
                return false;
            }
        }
    }
    function view_alert_by_to_whom($to){ // view alerts user wise
        $this->db->select('*,alert_tbl.date_updated');
        $this->db->from('alert_tbl');
        $this->db->join('alert_category_tbl','alert_tbl.alert_cat_id = alert_category_tbl.alert_cat_id','left');
        $this->db->where('to_whom',$to);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function check_alert_exist($to,$cat_id){
        $this->db->select('*');
        $this->db->from('alert_tbl');
        $this->db->join('alert_category_tbl','alert_tbl.alert_cat_id = alert_category_tbl.alert_cat_id','left');
        $this->db->where('to_whom',$to)->where('alert_tbl.alert_cat_id',$cat_id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }    
    }
    function view_alerts_by_category($cat_id){
        $this->db->select('count(*) as count,alert_category,alert_tbl.alert_cat_id,MAX(alert_tbl.date_updated) as date_updated');
        $this->db->from('alert_tbl');
        $this->db->join('alert_category_tbl','alert_tbl.alert_cat_id = alert_category_tbl.alert_cat_id','left');
        $this->db->where('alert_tbl.alert_cat_id',$cat_id);
        //$this->db->group_by('alert_tbl.alert_cat_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // when user clicks view all alerts in notification
    function view_all_alerts(){
        $this->db->select('*,alert_tbl.date_updated,school_details_tbl.sch_name');
        $this->db->from('alert_tbl');
        $this->db->join('alert_category_tbl','alert_tbl.alert_cat_id = alert_category_tbl.alert_cat_id','left');
        $this->db->join('school_details_tbl','alert_tbl.to_whom= school_details_tbl.census_id','left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function view_alert_by_alert_id($id){
        $this->db->select('*,alert_tbl.date_added,alert_tbl.date_updated, school_details_tbl.sch_name');
        $this->db->from('alert_tbl');
        $this->db->join('alert_category_tbl','alert_tbl.alert_cat_id = alert_category_tbl.alert_cat_id','left');
        $this->db->join('school_details_tbl','alert_tbl.to_whom= school_details_tbl.census_id','left');
        $this->db->where('alert_id',$id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    function view_alert_by_alert_cat_id($alert_cat_id){
        $this->db->select('*,alert_tbl.date_added,alert_tbl.date_updated, school_details_tbl.sch_name');
        $this->db->from('alert_tbl');
        $this->db->join('alert_category_tbl','alert_tbl.alert_cat_id = alert_category_tbl.alert_cat_id','left');
        $this->db->join('school_details_tbl','alert_tbl.to_whom = school_details_tbl.census_id','left');
        $this->db->where('alert_tbl.alert_cat_id',$alert_cat_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    // when user click on alert, it is updated as read
    function update_alert_by_id($id){
        $now = date('Y-m-d H:i:s');
        $this->db->set('is_read','1');
        $this->db->set('when_read',$now);
        $this->db->where('alert_id',$id);
        $this->db->update('alert_tbl'); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    // when user click on view all alerts, all alert records are updated as read
    // if the user is school the $to is census id 
    function update_all_alerts_by_user($census_id){
        $now = date('Y-m-d H:i:s');
        $this->db->set('is_read','1');
        $this->db->set('when_read',$now);
        $this->db->where('to_whom',$census_id);
        $this->db->update('alert_tbl'); 
        if($this->db->affected_rows() > 0){         
            return true; 
        }else{
            return false; 
        }
    }
    // still not using following methods        
    function delete_alert($id){
            $this->db->where('phy_res_cat_id',$id);
            $this->db->delete('physical_res_category_tbl');
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }

        
}