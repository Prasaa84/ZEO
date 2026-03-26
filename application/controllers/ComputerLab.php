<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ComputerLab extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('School_model');
        $this->load->model('Common_model');
        $this->load->model('Computer_lab_model');
        $this->all_com_res_items = $this->view_all_items();
        $this->userrole_id = $this->session->userdata['userrole_id'];
        if($this->userrole_id != '2'){ 
            $this->all_schools = $this->view_all_schools();
            $this->all_edu_divisions = $this->Common_model->get_divisions(); 
        }
    }
    public function index(){ 
        if(is_logged_in()){
            $data['title'] = 'Computer Laboratory Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'computerLab/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // view computer lab resources details page
    public function viewDetails(){
        if(is_logged_in()){
            //$userrole = $this->session->userdata['userrole'];
            if( $this->userrole_id == '2' ){ // if the user is school, then com lab res. details must be displayed by census id
                $censusId = $this->session->userdata['census_id'];
                //$result = $this->School_model->get_logged_school($userid); 
                $comLabDetails = $this->Computer_lab_model->view_item_status_by_census_id($censusId); 
                if(!$comLabDetails){
                    $this->session->set_flashdata('no_com_lab_info', array('text' => 'No records found!!!','class' => 'alert alert-danger'));
                }else{
                    $data['com_lab_info_by_census'] = $comLabDetails;
                }
            }
            $data['title'] = 'Computer Laboratory Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'computer_lab/viewComputerLab';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // add computer resource item status
    public function addComResInfo(){
        if(is_logged_in()){ 
            if ($this->input->post('btn_add_new_item_info') == "Add_New"){
                $this->form_validation->set_rules("com_res_item_select","Item","trim|required");
                $this->form_validation->set_rules("quantity_txt","Not working quantity","trim|required");
                $this->form_validation->set_rules("working_txt","Working quantity","trim|required");
                
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                    $this->viewDetails();
                }else{
                    $censusId = $this->input->post('census_id_select');
                    $itemId = $this->input->post('com_res_item_select');
                    $working = $this->input->post('quantity_txt');
                    $notWorking = $this->input->post('working_txt');
                    $repairable = $this->input->post('repairable_txt');                    
                    $exists = $this->Computer_lab_model->check_item_status_details_exists($censusId,$itemId);
                    if(!$exists){
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'com_lab_res_info_id' => '',
                            'census_id' => $this->input->post('census_id_select'),
                            'com_lab_res_id' => $this->input->post('com_res_item_select'),
                            'quantity' => $this->input->post('quantity_txt'),
                            'working' => $this->input->post('working_txt'),
                            'repairable' => $this->input->post('repairable_txt'),
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                        );
                        $result = $this->Computer_lab_model->add_new_com_res_details($data);
                        if($result){
                            $this->session->set_flashdata('msg', array('text' => 'Details added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('msg', array('text' => 'Error in inserting data!!!','class' => 'alert alert-danger'));
                        }
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'This item already exists!!!','class' => 'alert alert-danger'));
                    }
                    redirect('computerLab/viewDetails');
                }
            }else{
                redirect('computerLab/viewDetails');
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }  
    }
    // add new computer resource item
    public function addComResItem(){
        if(is_logged_in()){
            $this->form_validation->set_rules("new_item_txt","Item Name","trim|required");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('addItemMsg', array('text' => 'Item name is required!','class' => 'alert alert-danger'));
                redirect('computerLab/viewDetails#viewItemsCard');
            }else{
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'com_lab_res_id' => '',
                    'com_lab_res_type' => $this->input->post('new_item_txt'),
                    'date_added' => $now,
                    'date_updated' => $now,
                    'is_deleted' => '',
                );
                $result = $this->Computer_lab_model->add_new_item($data);
                if($result){
                    $this->session->set_flashdata('addItemMsg', array('text' => 'Item added successfully','class' => 'alert alert-success'));
                    redirect('computerLab/viewDetails#viewItemsCard');
                }
            }
        }
    }
    // this method loaded by this construct method
    public function view_all_items(){ 
        return $this->Computer_lab_model->view_all_items();
    }
    // this method loaded by this construct method to view available schools in db
    public function view_all_schools(){
        return $this->School_model->view_all_schools();
    }
    // Computer resource item update page 
    public function editItemPage(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Computer_lab_model->view_item_by_id($id);
            $data['item_result'] = $result;
            $data['title'] = 'Computer Lab Resource Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'computer_lab/editItem';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update computer resource item
    public function updateItem(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_com_res_item') == "Update"){
                $this->form_validation->set_rules("item_name_txt","Item Name","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Item name is required!','class' => 'alert alert-danger'));
                    redirect('computerLab/viewDetails');
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'com_lab_res_id' => $this->input->post('item_id_txt'),
                        'com_lab_res_type' => $this->input->post('item_name_txt'),
                        'date_added' => $this->input->post('date_added_txt'),
                        'date_updated' => $now,
                        'is_deleted' => $this->input->post('is_deleted'),
                    );      
                    //print_r($data); die();    
                    $result = $this->Computer_lab_model->update_item($data);
                    if($result){
                        $this->session->set_flashdata('msg', array('text' => 'Item updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'Item not updated!!!','class' => 'alert alert-danger','update'=>'false'));
                    }
                    redirect("computerLab/viewDetails");
                }
            }else{
                redirect("computerLab/viewDetails");
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } 
    // delete item from the database table
    public function deleteItem(){
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Computer_lab_model->delete_item($id);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Item deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Item couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            redirect("computerLab/viewDetails");
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } 
    // computer resource item status details update page
    public function editItemStatusDetailsPage(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Computer_lab_model->view_item_status_details_by_id($id);
            $data['item_status_details_result'] = $result;
            $data['title'] = 'Computer Resources Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'computer_lab/editItemStatusInfo';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
        // this is used to go back from item status details update page without updating
    public function goBackFromUpdate(){ 
        if(is_logged_in()){
            $censusId = $this->uri->segment(3);
            $result = $this->Computer_lab_model->view_item_status_by_census_id($censusId);
            //$condition = 'census_id='.$censusId;
            //$last_update_dt = $this->Computer_lab_model->view_recent_item_status_update_dt($condition); 
            //$data['school_item_status_last_update'] = $last_update_dt; // get the latest updated record to show updated date/time
            $data['com_lab_info_by_census'] = $result;
            $data['title'] = 'Computer Resources Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'computer_lab/viewComputerLab';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update the item status details
    public function updateItemStatusDetails(){
        if(is_logged_in()){
            if($this->input->post('btn_edit_com_res_item_status_details') == "Update"){
                $now = date('Y-m-d H:i:s');
                $censusId = $this->input->post('census_id_txt');
                $data = array(
                    'com_lab_res_info_id' => $this->input->post('phy_res_detail_id'),
                    'census_id' => $this->input->post('census_id_txt'),
                    'com_lab_res_id' => $this->input->post('com_res_item_select'),
                    'quantity' => $this->input->post('quantity_txt'),
                    'working' => $this->input->post('working_txt'),
                    'repairable' => $this->input->post('repairable_txt'),
                    'date_added' => $this->input->post('date_added_txt'),
                    'date_updated' => $now,
                    'is_deleted' => 0,
                    );      
                    //print_r($data); die();    
                $result = $this->Computer_lab_model->update_item_status_details($data);
                if($result){
                    $this->session->set_flashdata('msg', array('text' => 'Item details updated successfully','class' => 'alert alert-success','update'=>'true'));
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'Item details could n\'t updated','class' => 'alert alert-danger','update'=>'false'));
                }
                $this->afterUpdateItemStatusDetails($censusId);
            }else{
                redirect('computerLab/viewDetails');                    
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // this is used to go back after item status details are updated
    public function afterUpdateItemStatusDetails($censusId){ 
        if(is_logged_in()){
            $result = $this->Computer_lab_model->view_item_status_by_census_id($censusId);
            //$condition = 'census_id='.$censusId;
            //$last_update_dt = $this->Physical_resource_model->view_recent_item_status_update_dt($condition); 
            //$data['school_item_status_last_update'] = $last_update_dt; // get the latest updated record to show updated date/time
            $data['com_lab_info_by_census'] = $result;
            $data['title'] = 'Computer Resources Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'computer_lab/viewComputerLab';
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
            $result = $this->Computer_lab_model->delete_item_status_details($id);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Computer resource details deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Computer resource details couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            $this->afterUpdateItemStatusDetails($censusId);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function viewItemStatusByCensusId(){
        if( is_logged_in() ){
            if ( $this->input->post('btn_view_details_by_census') == "View" ){ // check the submit button
                // echo 'hi'; die();
                // $this->form_validation->set_rules("census_id_hidden","Census ID","trim|required|regex_match[/^[0-9]{5}$/]");
                // if ( $this->form_validation->run() == FALSE ){
                //     //validation fails
                //     $this->session->set_flashdata('msg', array('text' => 'Census ID is not correct!','class' => 'alert alert-danger'));
                //     redirect('computerLab/viewDetails');
                // }else{  
                    $censusId = $this->input->post('census_id_hidden');
                    $result = $this->Computer_lab_model->view_item_status_by_census_id( $censusId );
                    //print_r($result); die();
                    if( $result ){
                        $condition = 'census_id='.$censusId;
                        $data['com_lab_info_by_census'] = $result;
                        $data['title'] = 'Computer Laboratory Resource Details';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'computer_lab/viewComputerLab';
                        $this->load->view('templates/user_template', $data);
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                        redirect('computerLab/viewDetails');
                    }
                // }
            }else{
                redirect('computerLab/viewDetails');
            }
        }else{
            redirect('GeneralInfo/loginPage');
        } 
    }
    // used by admin, zonal office to make summery report of all schools' computer resource status
    public function viewItemStatusAllSchools(){
        if( is_logged_in() ){
            if ( $this->input->post('btn_view_status') == "Show"  ){ 
                $division = $this->input->post('edu_div_id_select');
                $status = $this->input->post('status_select');
                if( $status == 'q' ){
                    $pageTitle = 'තිබෙන ප්‍රමාණය ';
                    $field = 'quantity';
                }
                if( $status == 'w' ){
                    $pageTitle = ' ක්‍රියාකාරී සංඛ්‍යාව ';
                    $field = 'working';
                }
                if( $status == 'r' ){
                    $pageTitle = ' ක්සකස්කල හැකි ප්‍රමාණය ';
                    $field = 'repairable';
                }
                if( $status == 'nr' ){
                    $pageTitle = ' ක්සකස්කල නොහැකි ප්‍රමාණය ';
                    $field = 'not_repairable';
                }
                
                // switch ( $status ) {
                // case 'w':
                //     $pageTitle = ' ක්‍රියාකාරී සංඛ්‍යාව ';
                //     $field = 'working';
                //     break;
                // case 'r':
                //     $pageTitle = 'සකස්කල හැකි ප්‍රමාණය';
                //     $field = 'repairable';
                //     break;
                // case 'nr':
                //     $pageTitle = 'සකස්කල නොහැකි ප්‍රමාණය';
                //     $field = 'not_repairable';
                //     break;
                // default:
                //     $pageTitle = 'තිබෙන ප්‍රමාණය ';
                //     $field = 'quantity';
                //     break;
                // }
                $result1 = $this->Computer_lab_model->view_item_status_details_all_schools( $division );
                if( $result1 ){
                    //$result2 is not used yet. get total of each item all schools have
                    $result2 = $this->Computer_lab_model->get_item_wise_total_quantity_on( $field, $division );
                    //print_r($result2); die();   
                    $data['title'] = 'පරිගණක විද්‍යාගාරයේ සම්පත් - '.$pageTitle;
                    $data['all_schools'] = $this->School_model->view_all_schools($division);
                    $data['all_schools_com_lab_info'] = $result1;
                    $data['all_schools_com_lab_item_total'] = $result2;
                    $data['status'] = $status;                    
                    $data['user_header'] = 'user_admin_header';
                    $data['user_content'] = 'computer_lab/viewComputerLab';
                    $this->load->view('templates/user_template', $data);
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                    redirect('computerLab/viewDetails');                    
                }
            }else{
                redirect('computerLab/viewDetails');                    
            }
        }else{
            redirect('GeneralInfo/loginPage');
        } 
    }
}