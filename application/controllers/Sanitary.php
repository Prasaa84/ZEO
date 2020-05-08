<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sanitary extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('School_model');
        $this->load->model('Sanitary_model');
        $this->load->model('User_model');
        $this->all_san_items = $this->view_all_items();
        $this->all_schools = $this->view_all_schools();
    }

    // view sanitary items details page
    public function viewDetails(){
        if(is_logged_in()){
            $userrole = $this->session->userdata['userrole'];
            if($userrole == 'School User'){ // if the user is school, then sanitary details must be displayed by census id
                $censusId = $this->session->userdata['census_id'];
                //$result = $this->School_model->get_logged_school($userid); 
                $LibDetails = $this->Sanitary_model->view_item_status_by_census_id($censusId); 
                if(!$LibDetails){
                    $this->session->set_flashdata('no_san_info', array('text' => 'No records found!!!','class' => 'alert alert-danger'));
                }else{
                    $data['sanitary_info_by_census'] = $LibDetails;
                }
            }
            $data['title'] = 'Sanitary Item Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'sanitary/viewSanitary';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // add sanitary item status details
    public function addSanInfo(){
        if(is_logged_in()){ 
            if ($this->input->post('btn_add_new_item_info') == "Add_New"){
                $this->form_validation->set_rules("san_item_select","Item","trim|required");
                $this->form_validation->set_rules("quantity_txt","Quantity","trim|required");               
                $this->form_validation->set_rules("usable_txt","Usable Quantity","trim|required");               
                $this->form_validation->set_rules("repairable_txt","Repairable Quantity","trim|required");               
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                    $this->viewDetails();
                }else{
                    $censusId = $this->input->post('census_id_select');
                    $itemId = $this->input->post('san_item_select');
                    $qty = $this->input->post('quantity_txt');
                    $usable = $this->input->post('usable_txt');
                    $repairable = $this->input->post('repairable_txt');
                    $exists = $this->Sanitary_model->check_item_status_details_exists($censusId,$itemId);
                    if(!$exists){
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'san_item_details_id' => '',
                            'census_id' => $this->input->post('census_id_select'),
                            'san_item_id' => $this->input->post('san_item_select'),
                            'quantity' => $this->input->post('quantity_txt'),
                            'usable' => $this->input->post('usable_txt'),
                            'repairable' => $this->input->post('repairable_txt'),
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                        );
                        $result = $this->Sanitary_model->add_new_item_status_details($data);
                        if($result){
                            //$id = $this->Sanitary_model->get_last_modified_row('sanitary_item_details_tbl');
                            // insert data to user track table
                            $userid = $this->session->userdata['userid'];
                            $data = array(
                                'user_track_id' => '',
                                'user_id' => $userid,
                                'key_on_row' => '',
                                'tbl_name' => 'sanitary_item_details_tbl',
                                'act_type_id'=> '2',
                                'note' => 'Sanitary details Inserted',
                                'date_added' => $now,
                                'is_deleted' => '',
                            );
                            $user_track = $this->User_model->add_user_act($data);
                            $this->session->set_flashdata('msg', array('text' => 'Details added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('msg', array('text' => 'Error in inserting data!!!','class' => 'alert alert-danger'));
                        }
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'This item already exists!!!','class' => 'alert alert-danger'));
                    }
                    redirect('Sanitary/viewDetails');
                }
            }else{
                redirect('Sanitary/viewDetails');
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }  
    }
    // add new sanitary item
    public function addSanItem(){
        if(is_logged_in()){
            $this->form_validation->set_rules("new_item_txt","Item Name","trim|required");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('addItemMsg', array('text' => 'Item name is required!','class' => 'alert alert-danger'));
                redirect('Sanitary/viewDetails');
            }else{
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'san_item_id' => '',
                    'san_item_name' => $this->input->post('new_item_txt'),
                    'date_added' => $now,
                    'date_updated' => $now,
                    'is_deleted' => '',
                );
                $result = $this->Sanitary_model->add_new_item($data);
                if($result){
                    $this->session->set_flashdata('addItemMsg', array('text' => 'Item added successfully','class' => 'alert alert-success'));
                    redirect('Sanitary/viewDetails');
                }
            }
        }
    }
    // this method loaded by this construct method to view all sanitary items
    public function view_all_items(){ 
        return $this->Sanitary_model->view_all_items();
    }
    // this method loaded by this construct method to view available schools in db
    public function view_all_schools(){
        return $this->School_model->view_all_schools();
    }
    // Load sanitary item update page 
    public function editItemPage(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Sanitary_model->view_item_by_id($id);
            $data['item_result'] = $result;
            $data['title'] = 'Sanitary Item Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'sanitary/editItem';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update sanitary item
    public function updateItem(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_san_item') == "Update"){
                $this->form_validation->set_rules("item_name_txt","Item Name","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'Item name is required!','class' => 'alert alert-danger'));
                    redirect('Sanitary/viewDetails');
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'san_item_id' => $this->input->post('item_id_txt'),
                        'san_item_name' => $this->input->post('item_name_txt'),
                        'date_added' => $this->input->post('date_added_txt'),
                        'date_updated' => $now,
                        'is_deleted' => $this->input->post('is_deleted'),
                    );      
                    $result = $this->Sanitary_model->update_item($data);
                    if($result){
                        $this->session->set_flashdata('msg', array('text' => 'Item updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'Item not updated!!!','class' => 'alert alert-danger','update'=>'false'));
                    }
                    redirect("Sanitary/viewDetails");
                }
            }else{
                redirect("Sanitary/viewDetails");
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } 
    // delete item from the database table
    public function deleteItem(){
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Sanitary_model->delete_item($id);
            if($result){
                $this->session->set_flashdata('msg', array('text' => 'Item deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Item couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
            }
            redirect("Sanitary/viewDetails");
        }else{
            redirect('GeneralInfo/loginPage');
        }
    } 
    // Load sanitary item status details update page
    public function editItemStatusDetailsPage(){ 
        if(is_logged_in()){
            $id = $this->uri->segment(3);
            $result = $this->Sanitary_model->view_item_status_details_by_id($id);
            $data['item_status_details_result'] = $result;
            $data['title'] = 'Sanitary Item Status Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'sanitary/editItemStatusInfo';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // this is used to go back from item status details update page without updating
    public function goBackFromUpdate(){ 
        if(is_logged_in()){
            $censusId = $this->uri->segment(3);
            $result = $this->Sanitary_model->view_item_status_by_census_id($censusId);
            $data['sanitary_info_by_census'] = $result;
            $data['title'] = 'Sanitary Item Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'sanitary/viewSanitary';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update the sanitary item status details
    public function updateItemStatusDetails(){
        if(is_logged_in()){
            if($this->input->post('btn_edit_san_item_status_details') == "Update"){
                $now = date('Y-m-d H:i:s');
                $censusId = $this->input->post('census_id_txt');
                $data = array(
                    'san_item_details_id' => $this->input->post('san_item_details_id'),
                    'census_id' => $this->input->post('census_id_txt'),
                    'san_item_id' => $this->input->post('san_item_select'),
                    'quantity' => $this->input->post('quantity_txt'),
                    'usable' => $this->input->post('usable_txt'),
                    'repairable' => $this->input->post('repairable_txt'),
                    'date_added' => $this->input->post('date_added_txt'),
                    'date_updated' => $now,
                    'is_deleted' => 0,
                    );      
                $result = $this->Sanitary_model->update_item_status_details($data);
                if($result){
                    // insert data to user track table
                    $userid = $this->session->userdata['userid'];
                    $data = array(
                        'user_track_id' => '',
                        'user_id' => $userid,
                        'key_on_row' => '',
                        'tbl_name' => 'sanitary_item_details_tbl',
                        'act_type_id'=> '3',
                        'note' => 'Sanitary details updated',
                        'date_added' => $now,
                        'is_deleted' => '',
                    );
                    $user_track = $this->User_model->add_user_act($data);
                    $this->session->set_flashdata('msg', array('text' => 'Item details updated successfully','class' => 'alert alert-success','update'=>'true'));
                }else{
                    $this->session->set_flashdata('msg', array('text' => 'Item details could n\'t updated','class' => 'alert alert-danger','update'=>'false'));
                }
                $this->afterUpdateItemStatusDetails($censusId);
            }else{
                redirect('Sanitary/viewDetails');                    
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // this is used to go back after item status details are updated
    public function afterUpdateItemStatusDetails($censusId){ 
        if(is_logged_in()){
            $result = $this->Sanitary_model->view_item_status_by_census_id($censusId);
            $data['sanitary_info_by_census'] = $result;
            $data['title'] = 'Sanitary Item Update';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'sanitary/viewSanitary';
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
            $result = $this->Sanitary_model->delete_item_status_details($id);
            if($result){
                // insert data to user track table
                $userid = $this->session->userdata['userid'];
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'user_track_id' => '',
                    'user_id' => $userid,
                    'key_on_row' => '',
                    'tbl_name' => 'sanitary_item_details_tbl',
                    'act_type_id'=> '4',
                    'note' => 'Sanitary details deleted',
                    'date_added' => $now,
                    'is_deleted' => '',
                );
                $user_track = $this->User_model->add_user_act($data);
                $this->session->set_flashdata('msg', array('text' => 'Sanitary item details deleted successfully','class' => 'alert alert-success','delete'=>'true'));
            }else{
                $this->session->set_flashdata('msg', array('text' => 'Sanitary item details couldn\'t delete!!!','class' => 'alert alert-danger','delete'=>'false'));
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
                    redirect('Sanitary/viewDetails');
                }else{  
                    $censusId = $this->input->post('censusid_txt');
                    $result = $this->Sanitary_model->view_item_status_by_census_id($censusId);
                    //print_r($result); die();
                    if($result){
                        $data['sanitary_info_by_census'] = $result;
                        $data['title'] = 'Sanitary Item Details';
                        $data['user_header'] = 'user_admin_header';
                        $data['user_content'] = 'sanitary/viewSanitary';
                        $this->load->view('templates/user_template', $data);
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'No records found!','class' => 'alert alert-danger'));
                        redirect('Sanitary/viewDetails');
                    }
                }
            }else{
                redirect('Sanitary/viewDetails');
            }
        }else{
            redirect('GeneralInfo/loginPage');
        } 
    }
}