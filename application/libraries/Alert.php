<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter PDF Library
 *
 * Generate PDF's in your CodeIgniter applications.
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Chris Harvey
 * @license			MIT License
 */
class alert {
    private $ci;

    public function __construct(){
        $this->ci=& get_instance();       
        //$this->load->model('User_model');
        $this->ci->load->library('Session'); 
        $this->ci->load->model('School_model'); // needs to get all census ids
        $this->ci->load->model('Physical_resource_model'); // needs for physical resource alerts
        $this->ci->load->model('Alert_model');        
        $this->setPhysicalResourceAlert();  // when user go through set alerts or update alerts
        $this->ci->phy_res_alert = $this->viewPhyResAlert(); // when user goes through pages view physical resource alerts, if available
    }

    public function setPhysicalResourceAlert(){
        if(is_logged_in()){
            $allSchools = $this->ci->School_model->view_all_schools();
            foreach ($allSchools as $row) {
                $censusId = $row->census_id;
                $year = date('Y');
                $result = $this->ci->Physical_resource_model->get_shortage_of_phy_res_details($censusId,$year); // $result = shortage of physical resource updation
                if($result){
                    $to = $censusId; $cat_id = '1'; // cat_id = 1 means physical resource in alert categories
                    $add = $this->ci->Alert_model->addAlert($result,$to,$cat_id);
                }
            }
        }
    } 
    // view physical resource alerts
    // this is called by construct method
    public function viewPhyResAlert(){ 
        if(is_logged_in()){
            if($this->ci->session->userdata['userrole'] == 'School User'){
                $censusId = $this->ci->session->userdata['census_id'];
                //$censusId = '07065';
                return $this->ci->Alert_model->view_alert_by_to_whom($censusId);
            }else{
                return $this->ci->Alert_model->view_all_alerts();
            }
        }
    } 

}