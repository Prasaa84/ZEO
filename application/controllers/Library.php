<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Library extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('School_model');
        $this->load->model('Library_model');
        $this->all_lib_items = $this->view_all_items();
        $this->all_schools = $this->view_all_schools();
    }

    // view library resources details page
    public function viewDetails(){
        if(is_logged_in()){
            $userrole = $this->session->userdata['userrole'];
            if($userrole == 'School User'){ // if the user is school, then com lab res. details must be displayed by census id
                $censusId = $this->session->userdata['census_id'];
                //$result = $this->School_model->get_logged_school($userid); 
                $LibDetails = $this->Library_model->view_item_status_by_census_id($censusId); 
                if(!$LibDetails){
                    $this->session->set_flashdata('no_lib_info', array('text' => 'No records found!!!','class' => 'alert alert-danger'));
                }else{
                    $data['lib_info_by_census'] = $LibDetails;
                }
            }
            $data['title'] = 'Library Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'library/viewLibrary';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // add library resource status
    public function addLibInfo(){
        if(is_logged_in()){ 
            if ($this->input->post('btn_add_new_item_info') == "Add_New"){
                $this->form_validation->set_rules("lib_res_item_select","Item","trim|required");
                $this->form_validation->set_rules("quantity_txt","Quantity","trim|required");               
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                    $this->viewDetails();
                }else{
                    $censusId = $this->input->post('census_id_select');
                    $itemId = $this->input->post('lib_res_item_select');
                    $working = $this->input->post('quantity_txt');
                    $exists = $this->Library_model->check_item_status_details_exists($censusId,$itemId);
                    if(!$exists){
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'lib_res_details_id' => '',
                            'census_id' => $this->input->post('census_id_select'),
                            'lib_res_id' => $this->input->post('lib_res_item_select'),
                            'quantity' => $this->input->post('quantity_txt'),
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                        );
                        $result = $this->Library_model->add_new_lib_res_details($data);
                        if($result){
                            $this->session->set_flashdata('msg', array('text' => 'Details added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('msg', array('text' => 'Error in inserting data!!!','class' => 'alert alert-danger'));
                        }
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'This item already exists!!!','class' => 'alert alert-danger'));
                    }
                    redirect('Library/viewDetails');
                }
            }else{
                redirect('Library/viewDetails');
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }  
    }
    // add new library resource item
    public function addLibItem(){
        if(is_logged_in()){
            $this->form_validation->set_rules("new_item_txt","Item Name","trim|required");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('addItemMsg', array('text' => 'Item name is required!','class' => 'alert alert-danger'));
                redirect('library/viewDetails');
            }else{
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'lib_res_id' => '',
                    'lib_res_type' => $this->input->post('new_item_txt'),
                    'date_added' => $now,
                    'date_updated' => $now,
                    'is_deleted' => '',
                );
                $result = $this->Library_model->add_new_item($data);
                if($result){
                    $this->session->set_flashdata('addItemMsg', array('text' => 'Item added successfully','class' => 'alert alert-success'));
                    redirect('library/viewDetails');
                }
            }
        }
    }
    // this method loaded by this construct method to view all library items
    public function view_all_items(){ 
        return $this->Library_model->view_all_items();
    }
    // this method loaded by this construct method to view available schools in db
    public function view_all_schools(){
        return $this->School_model->view_all_schools();
    }
    // Library resource item update page 
    public function editItemPage(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Library_model->view_item_by_id($id);
            $data['item_result'] = $result;
            $data['title'] = 'Library Resource Item Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'library/editItem';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update library resource item
    public function updateItem(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_lib_res_item') == "Update"){
                $this->form_validation->set_rules("item_name_txt","Item Name","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Item name is required!','class' => 'alert alert-danger'));
                    redirect('library/viewDetails');
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'lib_res_id' => $this->input->post('item_id_txt'),
                        'lib_res_type' => $this->input->post('item_name_txt'),
                        'date_added' => $this->input->post('date_added_txt'),
                        'date_updated' => $now,
                        'is_deleted' => $this->input->post('is_deleted'),
                    );      
                    $result = $this->Library_model->update_item($data);
                    if($result){
                        $this->session->set_flashdata('msg', array('text' => 'Item updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'Item not updated!!!','class' => 'alert alert-danger','update'=>'false'));
                    }
                    redirect("library/viewDetails");
                }
            }else{
                redirect("library/viewDetails");
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } 
    // delete item from the database table
    public function deleteItem(){
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Library_model->delete_item($id);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Item deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Item couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            redirect("library/viewDetails");
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } 
    // Load library resource item status details update page
    public function editItemStatusDetailsPage(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Library_model->view_item_status_details_by_id($id);
            $data['item_status_details_result'] = $result;
            $data['title'] = 'Library Resources Status Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'library/editItemStatusInfo';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // this is used to go back from item status details update page without updating
    public function goBackFromUpdate(){ 
        if(is_logged_in()){
            $censusId = $this->uri->segment(3);
            $result = $this->Library_model->view_item_status_by_census_id($censusId);
            $data['lib_info_by_census'] = $result;
            $data['title'] = 'Library Resources Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'library/viewLibrary';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update the library item status details
    public function updateItemStatusDetails(){
        if(is_logged_in()){
            if($this->input->post('btn_edit_lib_res_item_status_details') == "Update"){
                $now = date('Y-m-d H:i:s');
                $censusId = $this->input->post('census_id_txt');
                $data = array(
                    'lib_res_details_id' => $this->input->post('lib_res_detail_id'),
                    'census_id' => $this->input->post('census_id_txt'),
                    'lib_res_id' => $this->input->post('lib_res_item_select'),
                    'quantity' => $this->input->post('quantity_txt'),
                    'date_added' => $this->input->post('date_added_txt'),
                    'date_updated' => $now,
                    'is_deleted' => 0,
                    );      
                $result = $this->Library_model->update_item_status_details($data);
                if($result){
                    $this->session->set_flashdata('msg', array('text' => 'Item details updated successfully','class' => 'alert alert-success','update'=>'true'));
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'Item details could n\'t updated','class' => 'alert alert-danger','update'=>'false'));
                }
                $this->afterUpdateItemStatusDetails($censusId);
            }else{
                redirect('Library/viewDetails');                    
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // this is used to go back after item status details are updated
    public function afterUpdateItemStatusDetails($censusId){ 
        if(is_logged_in()){
            $result = $this->Library_model->view_item_status_by_census_id($censusId);
            $data['lib_info_by_census'] = $result;
            $data['title'] = 'Library Resources Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'library/viewLibrary';
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
            $result = $this->Library_model->delete_item_status_details($id);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Library resource details deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Library resource details couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            $this->afterUpdateItemStatusDetails($censusId);
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
                    redirect('Library/viewDetails');
                }else{  
                    $censusId = $this->input->post('censusid_txt');
                    $result = $this->Library_model->view_item_status_by_census_id($censusId);
                    //print_r($result); die();
                    if($result){
                        $condition = 'census_id='.$censusId;
                        $data['lib_info_by_census'] = $result;
                        $data['title'] = 'Library Resource Details';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'library/viewLibrary';
                        $this->load->view('templates/user_template', $data);
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'No record found!','class' => 'alert alert-danger'));
                        redirect('Library/viewDetails');
                    }
                }
            }else{
                redirect('Library/viewDetails');
            }
        }else{
            redirect('GeneralInfo/loginPage');
        } 
     }
}