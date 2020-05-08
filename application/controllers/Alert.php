<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alert extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('School_model');
        $this->load->model('Physical_resource_model');
        $this->load->model('Alert_model');
        $this->phy_res_alert = $this->viewPhyResAlert(); // when user comes to dashboard view alerts, if available
    }
    // view physical resource alerts
    // this is called by construct method
    public function viewPhyResAlert(){ 
        if($this->session->userdata['userrole'] == 'School User'){
            $censusId = $this->session->userdata['census_id'];
            //$censusId = '07065';
            return $this->Alert_model->view_alert_by_to_whom($censusId);
        }else{
            $cat_id = '1'; // physical_resource category
            return $this->Alert_model->view_alerts_by_category($cat_id);
        }
    } 
    // called in user header alert notifications
    // when user click on the alerts one by one 
    public function viewAlertPageById(){
        if(is_logged_in()){
            if($this->session->userdata['userrole'] == 'School User'){
                // if the user is School, when he click on alert, the alert must be updated as 'read' 
                $alertId = $this->uri->segment(3);
                $this->Alert_model->update_alert_by_id($alertId);   
                $data['alert_info'] = $this->Alert_model->view_alert_by_alert_id($alertId);
            }
            if($this->session->userdata['userrole'] == 'System Administrator'){
                $alertCatId = $this->uri->segment(3);
                $data['alert_info'] = $this->Alert_model->view_alert_by_alert_cat_id($alertCatId);
            }
            $data['title'] = 'User Alerts';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'alert/viewAlert';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // called in user header alert notifications, under view all alerts button
    public function viewAllAlertsPage(){
        if(is_logged_in()){
            if($this->session->userdata['userrole'] == 'School User'){
                // if the user is School, gets only that school's all alerts 
                $censusId = $this->session->userdata['census_id'];
                $this->Alert_model->update_all_alerts_by_user($censusId);   
                $alert = $this->Alert_model->view_alert_by_to_whom($censusId);
            }else{
                // if the user is not school, gets all alerts
                $alert = $this->Alert_model->view_all_alerts();
            }           
            $data['alert_info'] = $alert;
            $data['title'] = 'User Alerts';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'alert/viewAlert';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
}
?>