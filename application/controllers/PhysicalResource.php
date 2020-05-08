<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PhysicalResource extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('School_model');
        $this->load->model('Physical_resource_model');
        $this->recent_update_phy_res_dt = $this->view_recent_item_update_dt();
        $this->recent_update_status_dt = $this->view_recent_status_update_dt();
        $this->all_items = $this->view_all_items(); // used to view all schools resource status
        //print_r($this->view_all_status); die();       
        $this->all_status = $this->view_all_status();
        //print_r($this->view_all_status); die();       
        //$this->all_status_count = $this->view_all_status_count(); 
        //print_r($this->all_status_count); die();       
        $this->all_schools = $this->view_all_schools(); // used to view all schools resource status
        $this->all_edu_divisions = $this->view_all_edu_divisions();
        $this->count_sch_no_internet = $this->count_sch_no_internet(); // for bar chart in addPhysicalResourcePage
        $this->count_sch_no_water = $this->count_sch_no_water(); // for bar chart in addPhysicalResourcePage
        $this->count_sch_no_guidance = $this->count_sch_no_guidance(); // for bar chart in addPhysicalResourcePage
        $this->count_sch_no_com_lab = $this->count_sch_no_com_lab(); // for bar chart in addPhysicalResourcePage
        $this->count_sch_no_easthatic_unit = $this->count_sch_no_easthatic_unit(); // for bar chart in addPhysicalResourcePage
        $this->phy_res_alert = $this->viewPhyResAlert(); // when user goes through pages view physical resource alerts, if available
    } 
    // view physical resource alerts
    // this is called by construct method
    public function viewPhyResAlert(){ 
        if($this->session->userdata['userrole'] == 'School User'){
            $censusId = $this->session->userdata['census_id'];
            //$censusId = '07065';
            return $this->Alert_model->view_alert_by_to_whom($censusId);
        }else{
            $cat_id = '1';
            return $this->Alert_model->view_alerts_by_category($cat_id);
        }
    }  
    public function index(){ 
        if(is_logged_in()){
            $data['title'] = 'Physical Resource Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'computerLab/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }

    public function viewAddPhysicalResourcePage(){
        if(is_logged_in()){
            $userrole = $this->session->userdata['userrole'];
            $userid = $this->session->userdata['userid'];
            if($userrole == 'School User'){ // if the user is school, then physical res. details must be displayed by census id
                $result = $this->School_model->get_logged_school($userid); 
                foreach ($result as $row) {
                    $censusId = $row->census_id;
                }
                $result = $this->Physical_resource_model->view_item_status_by_census_id($censusId);
                if($result){
                    $condition = 'census_id ='.$censusId;
                    $data['school_item_status_last_update'] = $this->Physical_resource_model->view_recent_item_status_update_dt($condition);
                    $data['school_item_status_by_census'] = $result;
                }
            }
            $data['title'] = 'Physical Resource Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'physical_resource/addPhysicalResourceDetails';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // add new item
    public function addPhysicalResource(){
        if(is_logged_in()){ 
            if ($this->input->post('btn_add_new_item') == "Add_New"){
                $this->form_validation->set_rules("new_phy_res_txt","Item Name","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Item name is required!','class' => 'alert alert-danger'));
                    redirect('PhysicalResource/viewAddPhysicalResourcePage');
                }else{
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'phy_res_cat_id' => '',
                        'phy_res_category' => $this->input->post('new_phy_res_txt'),
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    $result = $this->Physical_resource_model->add_new_item($data);
                    if($result){
                        $this->session->set_flashdata('msg', array('text' => 'Item added successfully','class' => 'alert alert-success'));
                        redirect('PhysicalResource/viewAddPhysicalResourcePage#');
                    }
                }
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
 
    public function addPhysicalResourceDetails(){
        $this->input->post('census_id_select');   
        $this->input->post('phy_res_item_select');   
        $this->input->post('phy_res_item_status_select');  
        if(is_logged_in()){ 
            if ($this->input->post('btn_insert_phy_res_details') == "Submit"){
                $this->form_validation->set_rules("census_id_select","Census ID","trim|required");
                $this->form_validation->set_rules("phy_res_item_select","Item Name","trim|required");
                $this->form_validation->set_rules("phy_res_item_status_select","Status","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->viewAddPhysicalResourcePage();
                }else{
                    $census_id = $this->input->post('census_id_select');
                    $item_id = $this->input->post('phy_res_item_select');
                    $exists = $this->Physical_resource_model->check_item_status_details_exists($census_id,$item_id);
                    if(!$exists){
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'phy_res_detail_id' => '',
                            'census_id' => $this->input->post('census_id_select'),
                            'phy_res_cat_id' => $this->input->post('phy_res_item_select'),
                            'phy_res_status_id' => $this->input->post('phy_res_item_status_select'),
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                        );
                        $result = $this->Physical_resource_model->add_new_phy_res_details($data);
                        if($result){
                            $this->session->set_flashdata('msg', array('text' => 'Details added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('msg', array('text' => 'Error in inserting data!!!','class' => 'alert alert-danger'));
                        }
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'This item already exists!!!','class' => 'alert alert-danger'));
                    }
                    redirect('PhysicalResource/viewAddPhysicalResourcePage#');
                }
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }  
    }
    public function addPhysicalResourceStatus(){
        if(is_logged_in()){ 
            if ($this->input->post('btn_add_new_status') == "Add_New"){
                $this->form_validation->set_rules("new_phy_res_status_txt","Status Name","trim|required");
                $this->form_validation->set_rules("status_group_no_txt","Group ID","trim|required|numeric");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'All fields are required!','class' => 'alert alert-danger'));
                    redirect('PhysicalResource/viewAddPhysicalResourcePage');
                }else{
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'phy_res_status_id' => '',
                        'phy_res_status_type' => $this->input->post('new_phy_res_status_txt'),
                        'status_group_id' => $this->input->post('status_group_no_txt'),                        
                        'date_added' => $now,
                        'date_updated' => $now,
                        'is_deleted' => '',
                    );
                    $result = $this->Physical_resource_model->add_new_status($data);
                    if($result){
                        $this->session->set_flashdata('msg', array('text' => 'Status added successfully','class' => 'alert alert-success'));
                        redirect('PhysicalResource/viewAddPhysicalResourcePage#');
                    }
                }
            }
        }else{
            redirect('GeneralInfo/loginPage');
        } 
    }
    // view last inserted date and time of physical resources
    // this is called by construct method
    public function view_recent_item_update_dt(){ 
        return $this->Physical_resource_model->view_recent_item_update_dt();
    }
    // view last inserted date and time of physical resources status
    // this is called by construct method
    public function view_recent_status_update_dt(){ 
        return $this->Physical_resource_model->view_recent_status_update_dt();
    }
    // this method loaded by this construct method
    public function view_all_items(){ 
        return $this->Physical_resource_model->view_all_items();
    }
    // this method loaded by this construct method to view available status in db
    public function view_all_status(){
        return $this->Physical_resource_model->view_all_status();
    }
    // this method loaded by this construct method to view available schools in db
    public function view_all_schools(){
        return $this->School_model->view_all_schools();
    }
    // this method loaded by this construct method to view count of census_id in db
    public function view_all_status_count(){
        return $this->Physical_resource_model->view_count_item_status_details_all_schools();
    }
    // this method loaded by this construct method to view available schools in db
    public function view_all_edu_divisions(){
        return $this->School_model->view_all_edu_divisions();
    }
    // this method loaded by this construct method to count schools by physical resource status
    public function count_sch_no_internet(){
        $catId = '13'; $statusId = '6';
        return $this->Physical_resource_model->count_sch_by_phy_res_status($catId,$statusId);
    }
    // this method loaded by this construct method to count schools by physical resource status
    public function count_sch_no_water(){
        $catId = '14'; $statusId = '6';
        return $this->Physical_resource_model->count_sch_by_phy_res_status($catId,$statusId);
    }
    // this method loaded by this construct method to count schools by physical resource status
    public function count_sch_no_guidance(){
        $catId = '16'; $statusId = '6';
        return $this->Physical_resource_model->count_sch_by_phy_res_status($catId,$statusId);
    }
    // this method loaded by this construct method to count schools by physical resource status
    public function count_sch_no_easthatic_unit(){
        $catId = '29'; $statusId = '6';
        return $this->Physical_resource_model->count_sch_by_phy_res_status($catId,$statusId);
    }
    // this method loaded by this construct method to count schools by physical resource status
    public function count_sch_no_com_lab(){
        $catId = '26'; $statusId = '6';
        return $this->Physical_resource_model->count_sch_by_phy_res_status($catId,$statusId);
    }
    // Physical resource item update view 
    public function editItemLoadView(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Physical_resource_model->view_item_by_id($id);
            $data['item_result'] = $result;
            $data['title'] = 'Physical Resource Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'physical_resource/editItem';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update physical resource item
    public function updateItem(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_phy_res_item') == "Update"){
                $this->form_validation->set_rules("item_name_txt","Item Name","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Item name is required!','class' => 'alert alert-danger'));
                    redirect('PhysicalResource/viewAddPhysicalResourcePage');
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'phy_res_cat_id' => $this->input->post('item_id_txt'),
                        'phy_res_category' => $this->input->post('item_name_txt'),
                        'date_added' => $this->input->post('date_added_txt'),
                        'date_updated' => $now,
                        'is_deleted' => $this->input->post('item_delete_select'),
                    );      
                    //print_r($data); die();    
                    $result = $this->Physical_resource_model->update_item($data);
                    if($result){
                        $this->session->set_flashdata('msg', array('text' => 'Item updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'Item not updated successfully','class' => 'alert alert-danger','update'=>'false'));
                    }
                    redirect("PhysicalResource/viewAddPhysicalResourcePage");
                }
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // delete item from the database table
    public function deleteItem(){
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Physical_resource_model->delete_item($id);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Item deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Item couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            redirect("PhysicalResource/viewAddPhysicalResourcePage");
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // status update view
    public function editStatusLoadView(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Physical_resource_model->view_status_by_id($id);
            $data['status_result'] = $result;
            $data['title'] = 'Physical Resource Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'physical_resource/editStatus';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update the selected status
    public function updateStatus(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_status') == "Update"){
                $this->form_validation->set_rules("status_type_txt","Status type","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Status type is required!','class' => 'alert alert-danger'));
                    redirect('PhysicalResource/editItemLoadView');
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'phy_res_status_id' => $this->input->post('status_id_txt'),
                        'phy_res_status_type' => $this->input->post('status_type_txt'),
                        'status_group_id' => $this->input->post('status_group_id_txt'),
                        'date_added' => $this->input->post('date_added_txt'),
                        'date_updated' => $now,
                        'is_deleted' => $this->input->post('is_deleted_hidden'),
                    );      
                    //print_r($data); die();    
                    $result = $this->Physical_resource_model->update_status($data);
                    if($result){
                        $this->session->set_flashdata('msg', array('text' => 'Status updated successfully','class' => 'alert alert-success','update'=>'true'));
                        redirect("PhysicalResource/viewAddPhysicalResourcePage");
                    }

                }
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // delete the selected status from database
    public function deleteStatus(){
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Physical_resource_model->delete_status($id);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Status deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Status couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            redirect("PhysicalResource/viewAddPhysicalResourcePage");
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function viewItemStatusByCensusId(){
        if(is_logged_in()){
            if ($_SERVER["REQUEST_METHOD"] == "POST"){ // check the submit button
                $this->form_validation->set_rules("censusid_txt","Census ID","trim|required|regex_match[/^[0-9]{5}$/]");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Census ID is not correct!','class' => 'alert alert-danger'));
                    redirect('PhysicalResource/viewAddPhysicalResourcePage');
                }else{  
                    $censusId = $this->input->post('censusid_txt');
                    $result = $this->Physical_resource_model->view_item_status_by_census_id($censusId);
                    //print_r($result); die();
                    if($result){
                        $condition = 'census_id='.$censusId;
                        $last_update_dt = $this->Physical_resource_model->view_recent_item_status_update_dt($condition); 
                        $data['school_item_status_last_update'] = $last_update_dt; // get the latest updated record
                        $data['school_item_status_by_census'] = $result;
                        $data['title'] = 'Physical Resource Details';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'physical_resource/addPhysicalResourceDetails';
                        $this->load->view('templates/user_template', $data);
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                        redirect('PhysicalResource/viewAddPhysicalResourcePage');                    
                    }
                }
            }else{
                redirect('PhysicalResource/viewAddPhysicalResourcePage');                    
            }
        }else{
            redirect('GeneralInfo/loginPage');
        } 
     }
     // used by admin, zonal office to make summery report of all schools' physical resource status
     public function viewItemStatusAllSchools(){
        if(is_logged_in()){
            if ($_SERVER["REQUEST_METHOD"] == "POST"){ // check the submit button
                $result1 = $this->Physical_resource_model->view_item_status_details_all_schools();
                $result2 = $this->Physical_resource_model->find_all_school_details_by_item_status();
                if($result1){
                    $data['title'] = 'Physical Resource Details';
                    $data['all_schools_phy_res_details'] = $result1;
                    $data['all_schools_by_item_status'] = $result2;                    
                    $data['user_header'] = 'user_admin_header';
                    $data['user_content'] = 'physical_resource/addPhysicalResourceDetails';
                    $this->load->view('templates/user_template', $data);
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                    redirect('PhysicalResource/viewAddPhysicalResourcePage');                    
                }
            }else{
                redirect('PhysicalResource/viewAddPhysicalResourcePage');                    
            }
        }else{
            redirect('GeneralInfo/loginPage');
        } 
     }
     // used by admin, zonal office to make summery report of all schools' physical resource status division wise
     public function viewItemStatusAllSchoolsDivWise(){
        if(is_logged_in()){
            if ($_SERVER["REQUEST_METHOD"] == "POST"){ // check the submit button
                //$result1 = $this->Physical_resource_model->view_item_status_details_all_schools();
                //print_r($result1); die();
                //$result2 = $this->Physical_resource_model->find_all_school_details_by_item_status();
                $this->form_validation->set_rules("edu_div_id","Education Division","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Education Division no selected!','class' => 'alert alert-danger'));
                    redirect('PhysicalResource/viewAddPhysicalResourcePage');
                }else{  
                    $eduDivId = $this->input->post('edu_div_id'); // select menu
                    $result1 = $this->Physical_resource_model->view_item_status_details_all_schools_div_wise($eduDivId);
                    $result2 = $this->Physical_resource_model->find_all_school_details_by_item_status_div_wise($eduDivId);
                    //print_r($result2); die();
                    if($result1){
                        $data['title'] = 'Physical Resource Details';
                        $data['all_schools_phy_res_details'] = $result1;
                        $data['all_schools_by_item_status'] = $result2;                    
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'physical_resource/addPhysicalResourceDetails';
                        $this->load->view('templates/user_template', $data);
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                        redirect('PhysicalResource/viewAddPhysicalResourcePage');                    
                    }
                }
            }else{
                redirect('PhysicalResource/viewAddPhysicalResourcePage');                    
            }
        }else{
            redirect('GeneralInfo/loginPage');
        } 
     }
     // used by zonal user and admin
     public function viewSchoolsByItemStatus(){
        if(is_logged_in()){
            if ($_SERVER["REQUEST_METHOD"] == "POST"){ // check the submit button
                $this->form_validation->set_rules("select_phy_res_cat_id","Physical Resource Item","trim|required");
                $this->form_validation->set_rules("select_phy_res_status_id","Status","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Item or Status not selected!','class' => 'alert alert-danger'));
                    redirect('PhysicalResource/viewAddPhysicalResourcePage');
                }else{  
                    $catId = $this->input->post('select_phy_res_cat_id');
                    $statusId = $this->input->post('select_phy_res_status_id');
                    $result = $this->Physical_resource_model->view_schools_by_item_status($catId,$statusId);
                    //print_r($result); die();
                    if($result){
                        $data['schools_by_item_status'] = $result; // get the latest updated record
                        $data['title'] = 'Physical Resource Details';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'physical_resource/addPhysicalResourceDetails';
                        $this->load->view('templates/user_template', $data);
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                        redirect('PhysicalResource/viewAddPhysicalResourcePage');                    
                    }
                }
            }else{
                redirect('PhysicalResource/viewAddPhysicalResourcePage');                    
            }
        }else{
            redirect('GeneralInfo/loginPage');
        } 
     }
    // Physical resource item status details update view
    public function editItemStatusDetailsLoadView(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Physical_resource_model->view_item_status_details_by_id($id);
            $data['item_status_details_result'] = $result;
            $data['title'] = 'Physical Resource Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'physical_resource/editItemStatus';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // this is used to go back from item status details update page without updating
    public function goBackFromUpdate(){ 
        if(is_logged_in()){
            $censusId = $this->uri->segment(3);
            $result = $this->Physical_resource_model->view_item_status_by_census_id($censusId);
            $condition = 'census_id='.$censusId;
            $last_update_dt = $this->Physical_resource_model->view_recent_item_status_update_dt($condition); 
            $data['school_item_status_last_update'] = $last_update_dt; // get the latest updated record to show updated date/time
            $data['school_item_status_by_census'] = $result;
            $data['title'] = 'Physical Resource Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'physical_resource/addPhysicalResourceDetails';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
     // update the item status details
    public function updateItemStatusDetails(){
        if(is_logged_in()){
            if($this->input->post('btn_edit_phy_res_item_status_details') == "Update"){
                $now = date('Y-m-d H:i:s');
                $censusId = $this->input->post('census_id_txt');
                $data = array(
                    'phy_res_detail_id' => $this->input->post('phy_res_detail_id'),
                    'census_id' => $this->input->post('census_id_txt'),
                    'phy_res_cat_id' => $this->input->post('phy_res_item_select'),
                    'phy_res_status_id' => $this->input->post('phy_res_item_status_select'),
                    'date_added' => $this->input->post('date_added_txt'),
                    'date_updated' => $now,
                    'is_deleted' => 0,
                    );      
                    //print_r($data); die();    
                $result = $this->Physical_resource_model->update_item_status_details($data);
                if($result){
                    $this->session->set_flashdata('msg', array('text' => 'Item details updated successfully','class' => 'alert alert-success','update'=>'true'));
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'Item details could n\'t updated','class' => 'alert alert-success','update'=>'false'));
                }
                $this->afterUpdateItemStatusDetails($censusId);
            }else{
                redirect('PhysicalResource/viewAddPhysicalResourcePage');                    
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // this is used to go back after item status details are updated
    public function afterUpdateItemStatusDetails($id){ 
        if(is_logged_in()){
            $censusId = $id;
            $result = $this->Physical_resource_model->view_item_status_by_census_id($censusId);
            $condition = 'census_id='.$censusId;
            $last_update_dt = $this->Physical_resource_model->view_recent_item_status_update_dt($condition); 
            $data['school_item_status_last_update'] = $last_update_dt; // get the latest updated record to show updated date/time
            $data['school_item_status_by_census'] = $result;
            $data['title'] = 'Physical Resource Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'physical_resource/addPhysicalResourceDetails';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // delete the item status details from database
    public function deleteItemStatusDetails(){
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $censusId = $this->uri->segment(4);
            $result = $this->Physical_resource_model->delete_item_status_details($id);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Physical resource details deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Physical resource details couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            $this->afterUpdateItemStatusDetails($censusId);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // AJAX call in addPhysicalResourceDetails page
    public function viewStatus(){
        $itemId = $this->input->post('item_id'); // item id is passed from ajax function 
        switch ($itemId) { // according to selected item id, the status are loaded 
            case '15':
                $condition='status_group_id=5';
                break;
            case '17':
                $condition='status_group_id=1 or status_group_id=2';
                break;
            case '18':
                $condition='status_group_id=1 or status_group_id=2';
                break;
            case '19':
                $condition='status_group_id=1 or status_group_id=2';
                break;
            case '33':
                $condition='status_group_id=1 or status_group_id=4';
                break; 
            case '14':
                $condition='status_group_id=1 or status_group_id=3';
                break;               
            default:
                $condition='status_group_id=1';
                break;
        }
        $status = $this->Physical_resource_model->view_status_by_condition($condition);
        if($status){
            $status_select_box = '';
            $status_select_box .='<option value="">--- තත්ත්වය තෝරන්න ---</option>';
            foreach ($status as $status) {
                $status_select_box .='<option value="'.$status->phy_res_status_id.'">'.$status->phy_res_status_type.'</option>';
            }
            echo json_encode($status_select_box);
        }
    }

}