<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Alert extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('School_model');
        $this->load->model('Physical_resource_model');
        $this->load->model('Computer_lab_model');
        $this->load->model('Library_model');
        $this->load->model('Furniture_model');
        $this->load->model('Building_model');
        $this->load->model('Sanitary_model');
        $this->load->model('Marks_model');
        $this->load->model('Alert_model');
        //$this->phy_res_alert = $this->viewPhyResAlert(); // when user comes to dashboard view alerts, if available
    }
    // not used
    public function viewPhyResAlert111()
    {
        if ($this->session->userdata['userrole'] == 'School User') {
            $censusId = $this->session->userdata['census_id'];
            //$censusId = '07065';
            return $this->Alert_model->view_alert_by_to_whom($censusId);
        } else {
            $cat_id = '1'; // physical_resource category
            return $this->Alert_model->view_alerts_by_category($cat_id);
        }
    }
    // used by user_admin_header to view notifications
    public function viewAlert()
    {
        $year = date('Y');
        if ($this->session->userdata['userrole'] == 'School User') {
            $censusId = $this->session->userdata['census_id'];
            //$censusId = '07065';
            //return $this->Alert_model->view_alert_by_to_whom($censusId);
            //echo $censusId.$year;
            $alertArray = [];
            $alertArray[1] = $this->Physical_resource_model->get_shortage_of_phy_res_details($censusId, $year);
            $alertArray[2] = $this->Computer_lab_model->get_shortage_of_com_lab_details($censusId, $year);
            $alertArray[3] = $this->Library_model->get_shortage_of_library_details($censusId, $year);
            $alertArray[4] = $this->Furniture_model->get_shortage_of_furniture_details($censusId, $year);
            //$build = $this->Building_model->get_shortage_of_building_details($censusId,$year);
            $alertArray[5] = $this->Sanitary_model->get_shortage_of_sanitary_details($censusId, $year);
            $term = '';
            $month = date('m'); // current month number
            if ($month < 6 and $month > 2) { // month january must view term 3 term test notifications of last year
                $term = 1; // if current month is in this range, notifications for term1 term test to be viewed
            } elseif ($month < 10) {
                $term = 2; // month september must view term 2
            } else {
                $term = 3; // in january too, term test 3 of last year
            }
            //echo $term; 
            //die();
            $alertArray[6] = $this->Marks_model->get_shortage_of_term_test_marks($censusId, $year, $term);
            for ($i = 1; $i < 7; $i++) {
                //echo $alertArray[$i].',';
            }
            $output = ' <h6 class="dropdown-header"> New Alerts : </h6>
                            <div class="dropdown-divider"></div>';
            if (!empty($alertArray)) {
                for ($i = 1; $i < 7; $i++) {
                    //echo $alertArray[$i].'-';

                    if ($alertArray[$i]) {
                        $alertCategory = '';
                        switch ($i) {
                            case "1":
                                $alertCategory = "Physical Resources";
                                break;
                            case "2":
                                $alertCategory = "Computer Laboratory";
                                break;
                            case "3":
                                $alertCategory = "Library Details";
                                break;
                            case "4":
                                $alertCategory = "Furniture Items";
                                break;
                            case "5":
                                $alertCategory = "Sanitary Details";
                                break;
                            case "6":
                                $alertCategory = "Term Test Marks";
                                break;
                            default:
                                $alertCategory = "Not found!!!";
                        }
                        if ($i == 6) {
                            $desc = 'Classe(s) to be updated...';
                        } else {
                            $desc = 'items to be updated......';
                        }
                        $output .=  '
                                    <div style="max-height:450;">
                                        <a class="dropdown-item" href="#">
                                            <span class="text-success">
                                                <strong>
                                                    <i class="fa fa-long-arrow-up fa-fw"></i>' . $alertCategory . '
                                                </strong>
                                            </span><br>
                                            <span class="small float-right text-muted">' . date("Y-m-d") . ' ' . date("h:i A") . '</span>
                                            <div class="dropdown-message small">
                                                ' . $alertArray[$i] . ' ' . $desc . '
                                            </div>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    </div>';
                    } // if($alertArray[$i]){ if not empty
                } // foreach($i=1; $i < 7 ; $i++) { 
                //$output .= '<a class="dropdown-item small" href="#">View all alerts</a>';       
            } else {
                $output .=  'No new alerts';
            }
        } else { // if not school user
            $term = ''; // for term test marks notifications
            $month = date('m'); // current month number
            if ($month < 6 and $month > 2) { // month january must view term 3 term test notifications of last year
                $term = 1; // if current month is in this range, notifications for term1 term test to be viewed
            } elseif ($month < 10) {
                $term = 2; // month september must view term 2
            } else {
                $term = 3; // in january too, term test 3 of last year
            }
            $sani_count = 0;
            $phy_count = 0;
            $com_lab_count = 0;
            $lib_count = 0;
            $fur_count = 0;
            $term_term_marks_count = 0;
            $output = ' <h6 class="dropdown-header"> New Alerts : </h6>
                        <div class="dropdown-divider"></div>';
            $alertArray = [];
            $allSchools = $this->School_model->view_all_schools();
            foreach ($allSchools as $school) {
                $censusId = $school->census_id;
                if ($this->Sanitary_model->get_shortage_of_sanitary_details($censusId, $year)) {
                    $sani_count += 1;
                }
                if ($this->Physical_resource_model->get_shortage_of_phy_res_details($censusId, $year)) {
                    $phy_count += 1;
                }
                if ($this->Computer_lab_model->get_shortage_of_com_lab_details($censusId, $year)) {
                    $com_lab_count += 1;
                }
                if ($this->Library_model->get_shortage_of_library_details($censusId, $year)) {
                    $lib_count += 1;
                }
                if ($this->Furniture_model->get_shortage_of_furniture_details($censusId, $year)) {
                    $fur_count += 1;
                }
                if ($this->Marks_model->get_shortage_of_term_test_marks($censusId, $year, $term)) {
                    $term_term_marks_count += 1;
                }
                //$build_count = $this->Building_model->get_shortage_of_building_details($censusId,$year);
            }
            //echo $term_term_marks_count; die();
            $alertArray[1] = $phy_count;
            $alertArray[2] = $com_lab_count;
            $alertArray[3] = $lib_count;
            $alertArray[4] = $fur_count;
            $alertArray[5] = $sani_count;
            $alertArray[6] = $term_term_marks_count;
            if (!empty($alertArray)) {
                for ($i = 1; $i < 7; $i++) {
                    if ($alertArray[$i]) {
                        $alertCategory = '';
                        switch ($i) {
                            case "1":
                                $alertCategory = "Physical Resources";
                                break;
                            case "2":
                                $alertCategory = "Computer Laboratory";
                                break;
                            case "3":
                                $alertCategory = "Library Details";
                                break;
                            case "4":
                                $alertCategory = "Furniture Items";
                                break;
                            case "5":
                                $alertCategory = "Sanitary Details";
                                break;
                            case "6":
                                $alertCategory = "Term Test Marks";
                                break;
                            default:
                                $alertCategory = "Not found!!!";
                        }
                        //if($i == 6){
                        //$desc = 'Classe(s) to be updated...';
                        //}else{
                        $desc = 'School(s) to be updated......';
                        //}
                        $output .=  '   <div style="max-height:450;">
                                            <a class="dropdown-item" href="">
                                                <span class="text-success">
                                                    <strong>
                                                        <i class="fa fa-long-arrow-up fa-fw"></i>' . $alertCategory . '
                                                    </strong>
                                                </span><br>
                                                <span class="small float-right text-muted">' . date("Y-m-d") . ' ' . date("h:i A") . '</span>
                                                <div class="dropdown-message small">
                                                    ' . $alertArray[$i] . ' ' . $desc . '
                                                </div>
                                            </a>
                                            <div class="dropdown-divider"></div>
                                        </div>';
                    } // if($alertArray[$i]){
                } // for ($i=1; $i < 6 ; $i++) { 
                //$output .= '<a class="dropdown-item small" href="#">View all alerts</a>';       
            } else { // if(!empty($alertArray)){
                $output .=  'No new alerts';
            }
            //$cat_id = '1'; // physical_resource category
            //return $this->Alert_model->view_alerts_by_category($cat_id);
        }
        echo $output;
    }
    // called in user header alert notifications
    // when user click on the alerts one by one 
    public function viewAlertPageById()
    {
        if (is_logged_in()) {
            if ($this->session->userdata['userrole'] == 'School User') {
                // if the user is School, when he click on alert, the alert must be updated as 'read' 
                $alertId = $this->uri->segment(3);
                $this->Alert_model->update_alert_by_id($alertId);
                $data['alert_info'] = $this->Alert_model->view_alert_by_alert_id($alertId);
            }
            if ($this->session->userdata['userrole'] == 'System Administrator') {
                $alertCatId = $this->uri->segment(3);
                $data['alert_info'] = $this->Alert_model->view_alert_by_alert_cat_id($alertCatId);
            }
            $data['title'] = 'User Alerts';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'alert/viewAlert';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }
    // called in user header alert notifications, under view all alerts button
    public function viewAllAlertsPage()
    {
        if (is_logged_in()) {
            if ($this->session->userdata['userrole'] == 'School User') {
                // if the user is School, gets only that school's all alerts 
                $censusId = $this->session->userdata['census_id'];
                $this->Alert_model->update_all_alerts_by_user($censusId);
                $alert = $this->Alert_model->view_alert_by_to_whom($censusId);
            } else {
                // if the user is not school, gets all alerts
                $alert = $this->Alert_model->view_all_alerts();
            }
            $data['alert_info'] = $alert;
            $data['title'] = 'User Alerts';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'alert/viewAlert';
            $this->load->view('templates/user_template', $data);
        } else {
            redirect('GeneralInfo/loginPage');
        }
    }
}
