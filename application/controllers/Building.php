<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Building extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('School_model');
        $this->load->model('Building_model');
        $this->all_building_sizes = $this->view_all_sizes();
        $this->building_cat_floor = $this->view_building_cat_floor();
        $this->building_usage = $this->view_building_usage();        
        $this->all_schools = $this->view_all_schools();
    }

    // view building details page
    public function viewDetails(){
        if(is_logged_in()){
            $userrole = $this->session->userdata['userrole'];
            if($userrole == 'School User'){ // if the user is school, then building details must be displayed by census id
                $censusId = $this->session->userdata['census_id'];
                //$result = $this->School_model->get_logged_school($userid); 
                $buildingDetails = $this->Building_model->view_building_info_by_census_id($censusId); 
                if(!$buildingDetails){
                    $this->session->set_flashdata('no_san_info', array('text' => 'No records found!!!','class' => 'alert alert-danger'));
                }else{
                    $data['building_info_by_census'] = $buildingDetails;
                }
            }
            $data['title'] = 'Building Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'building/viewBuildings';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // this method loaded by this construct method to view all building sizes in db
    public function view_all_sizes(){ 
        return $this->Building_model->view_all_sizes();
    }
    // this method loaded by this construct method to view available schools in db
    public function view_all_schools(){
        return $this->School_model->view_all_schools();
    }
    // this method loaded by this construct method to view available building categories and floors in db
    public function view_building_cat_floor(){
        return $this->Building_model->view_all_building_cat_floor();
    }
    // this method loaded by this construct method to view available building usages in db
    public function view_building_usage(){
        return $this->Building_model->view_all_building_usage();
    }   
    // add building details
    public function addBuildingInfo(){
        if(is_logged_in()){ 
            if ($this->input->post('btn_add_new_building_info') == "Add_New"){
                //echo $this->input->post('repaired_chkbox'); die(); 
                $this->form_validation->set_rules("building_cat_select","Building category","trim|required");
                $this->form_validation->set_rules("size_select","Building size","trim|required");
                $this->form_validation->set_rules("usage_select","Building usage","trim|required");
                $this->form_validation->set_rules("donatedby_txt","Who donated?","trim|required");               
                if(($this->input->post('repaired_chkbox')) || !empty($this->input->post('repaired_institute_txt')) || !empty($this->input->post('repaired_date_txt'))){
                    $this->form_validation->set_rules("repaired_institute_txt","Who repaired?","trim|required");               
                    $this->form_validation->set_rules("repaired_date_txt","Donator","trim|required");               
                    $this->form_validation->set_rules("repaired_info_txtarea","Repaired details","trim|required");               
                }
                if(($this->input->post('repairable_chkbox')) || !empty($this->input->post('repairable_part_txt')) || !empty($this->input->post('repairable_info_txtarea'))){
                    $this->form_validation->set_rules("repairable_part_txt","Repairable part","trim|required");               
                    $this->form_validation->set_rules("repairable_info_txtarea","Repairing details","trim|required");               
                }
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                    $this->viewDetails();
                }else{
                    $censusId = $this->input->post('census_id_select');
                    $itemId = $this->input->post('building_cat_select');
                    $qty = $this->input->post('size_select');
                    $usable = $this->input->post('donatedby_txt');
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'b_info_id' => '',
                        'census_id' => $this->input->post('census_id_select'),
                        'b_cat_floor_id' => $this->input->post('building_cat_select'),
                        'b_size_id' => $this->input->post('size_select'),
                        'b_usage_id' => $this->input->post('usage_select'),
                        'donated_by' => $this->input->post('donatedby_txt'), // donated to supply the building
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    $b_info_id = $this->Building_model->add_new_building_details($data); /// add to building_info_tbl
                    if($this->input->post('repaired_chkbox')){
                       $data = array(
                        'b_repaired_id' => '',
                        'b_info_id' => $b_info_id,
                        'repaired_by' => $this->input->post('donated_by_txt'),  // donated to repair the building
                        'repaired_date' => $this->input->post('repaired_date_txt'),
                        'description' => $this->input->post('repaired_info_txtarea'),
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                        ); 
                        $result1 = $this->Building_model->add_repaired_building_details($data); /// add to building_info_tbl
                        $this->session->set_flashdata('repairMsg', array('text' => 'Building Repaired Details added successfully','class' => 'alert alert-success'));
                    }
                    if($this->input->post('repairable_chkbox')){
                       $data = array(
                        'b_to_be_repaired_id' => '',
                        'b_info_id' => $b_info_id,
                        'repairable_part' => $this->input->post('repairable_part_txt'),
                        'description' => $this->input->post('repairable_info_txtarea'),
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                        ); 
                        $result2 = $this->Building_model->add_building_to_be_repaired_details($data); /// add to building_info_tbl
                        $this->session->set_flashdata('toBeRepairedMsg', array('text' => 'Building to be repaired details added successfully','class' => 'alert alert-success'));
                    }
                    if($b_info_id){
                        $this->session->set_flashdata('msg', array('text' => 'Building Details added successfully','class' => 'alert alert-success'));
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'Error in inserting data!!!','class' => 'alert alert-danger'));
                    }
                    redirect('Building/viewDetails');
                }
            }else{
                redirect('Building/viewDetails');
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }  
    }
    // view building details by school census id
    public function viewBuildingInfoByCensusId(){
        if(is_logged_in()){
            if ($_SERVER["REQUEST_METHOD"] == "POST"){ // check the submit button
                $this->form_validation->set_rules("censusid_txt","Census ID","trim|required|regex_match[/^[0-9]{5}$/]");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Census ID is not correct!','class' => 'alert alert-danger'));
                    redirect('Building/viewDetails');
                }else{  
                    $censusId = $this->input->post('censusid_txt');
                    $result = $this->Building_model->view_building_info_by_census_id($censusId);
                    if($result){
                        $data['building_info_by_census'] = $result;
                        $data['title'] = 'Building Details';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'building/viewBuildings';
                        $this->load->view('templates/user_template', $data);
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'No records found!','class' => 'alert alert-danger'));
                        redirect('Building/viewDetails');
                    }
                }
            }else{
                redirect('Building/viewDetails');
            }
        }else{
            redirect('GeneralInfo/loginPage');
        } 
    }
    // delete the building info from database
    public function deleteBuildingInfo(){
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $censusId = $this->uri->segment(4);
            $result = $this->Building_model->delete_building_info($id);
            $resultRepair = $this->Building_model->delete_repaired_building_info($id);
            $relultToRepair = $this->Building_model->delete_building_to_be_repaired_info($id);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Building details deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Building details couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            $this->afterUpdateBuildingInfo($censusId);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // this is used to go back after item status details are updated or deleted
    public function afterUpdateBuildingInfo($censusId){ 
        if(is_logged_in()){
            $result = $this->Building_model->view_building_info_by_census_id($censusId);
            $data['building_info_by_census'] = $result;
            $data['title'] = 'Building information';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'building/viewBuildings';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // Load building information update page
    public function editBuildingInfoPage(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Building_model->view_building_info_by_id($id);
            $data['building_info_result'] = $result;
            $data['title'] = 'Building Information Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'building/editBuildingInfo';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update the bulding information
    public function updateBuildingInfo(){
        if(is_logged_in()){
            if($this->input->post('btn_edit_building_info') == "Update"){
                $now = date('Y-m-d H:i:s');
                $censusId = $this->input->post('census_id_txt');
                $data = array(
                    'b_info_id' => $this->input->post('b_info_id'),
                    'census_id' => $this->input->post('census_id_txt'),
                    'b_cat_floor_id' => $this->input->post('category_select'),
                    'b_size_id' => $this->input->post('size_select'),
                    'b_usage_id' => $this->input->post('usage_select'),                    
                    'donated_by' => $this->input->post('donatedby_txt'),
                    'date_added' => $this->input->post('date_added_txt'),
                    'date_updated' => $now,
                    'is_deleted' => 0,
                );      
                $result = $this->Building_model->update_building_info($data);
                if($result){
                    $this->session->set_flashdata('msg', array('text' => 'Building details updated successfully','class' => 'alert alert-success','update'=>'true'));
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'Building details could n\'t updated','class' => 'alert alert-danger','update'=>'false'));
                }
                $this->afterUpdateBuildingInfo($censusId);
            }else{
                redirect('Building/viewDetails');                    
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // this is used to go back from building details update page without updating
    public function goBackFromUpdate(){ 
        if(is_logged_in()){
            $censusId = $this->uri->segment(3);
            $result = $this->Building_model->view_building_info_by_census_id($censusId);
            $data['building_info_by_census'] = $result;
            $data['title'] = 'Building Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'building/viewBuildings';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // add a new building size
    public function addNewBuildingSize(){
        if(is_logged_in()){
            $this->form_validation->set_rules("length_txt","Building Length","trim|required|numeric");
            $this->form_validation->set_rules("width_txt","Building Width","trim|required|numeric");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('msg', array('text' => 'Incorrect Width or Height!','class' => 'alert alert-danger'));
                redirect('Building/viewDetails');
            }else{
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'b_size_id' => '',
                    'length' => $this->input->post('length_txt'),
                    'width' => $this->input->post('width_txt'),
                    'date_added' => $now,
                    'date_updated' => $now,
                    'is_deleted' => '',
                );
                $result = $this->Building_model->add_new_building_size($data);
                if($result){
                    $this->session->set_flashdata('msg', array('text' => 'New building size added successfully','class' => 'alert alert-success'));
                    redirect('Building/viewDetails');
                }
            }
        }
    }
    // add a new building usage
    public function addNewBuildingUsage(){
        if(is_logged_in()){
            $this->form_validation->set_rules("usage_txt","Building Usage","trim|required");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('usageMsg', array('text' => 'Incorrect Data!','class' => 'alert alert-danger'));
                redirect('Building/viewDetails#viewBuildingUsageCard');
            }else{
                $usage = $this->input->post('usage_txt');
                $usageExists = $this->Building_model->check_usage_exists($usage);
                if(!$usageExists){
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'b_usage_id' => '',
                        'b_usage' => $this->input->post('usage_txt'),
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    $result = $this->Building_model->add_new_building_usage($data);
                    if($result){
                        $this->session->set_flashdata('usageMsg', array('text' => 'New building usage added successfully','class' => 'alert alert-success'));
                    }
                }else{
                    $this->session->set_flashdata('usageMsg', array('text' => 'This is already exists!!!','class' => 'alert alert-danger'));
                }
                redirect('Building/viewDetails#viewBuildingUsageCard');
            }
        }
    }
    // Load building usage update page
    public function editBuildingUsagePage(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Building_model->view_building_usage_by_id($id);
            $data['building_usage_result'] = $result;
            $data['title'] = 'Building Usage Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'building/editBuildingUsage';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update the bulding usage
    public function updateBuildingUsage(){
        if(is_logged_in()){
            if($this->input->post('btn_edit_building_usage_info') == "Update"){
                $usage = $this->input->post('usage_txt');
                $usageExists = $this->Building_model->check_usage_exists($usage);
                if(!$usageExists){
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'b_usage_id' => $this->input->post('b_usage_id'),
                        'b_usage' => $this->input->post('usage_txt'),
                        'date_added' => $this->input->post('date_added_txt'),
                        'date_updated' => $now,
                        'is_deleted' => 0,
                    );      
                    $result = $this->Building_model->update_building_usage($data);
                    if($result){
                        $this->session->set_flashdata('usageMsg', array('text' => 'Building usage updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('usageMsg', array('text' => 'Building usage could n\'t updated','class' => 'alert alert-danger','update'=>'false'));
                    }
                }else{
                    $this->session->set_flashdata('usageMsg', array('text' => 'This is already exists!!!','class' => 'alert alert-danger'));
                }
            }
            redirect('Building/viewDetails#viewBuildingUsageCard');                    
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }


}