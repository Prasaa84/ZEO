<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Furniture extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('School_model');
        $this->load->model('Furniture_model');
        $this->furniture_items = $this->view_all_furniture_items();
        $this->all_schools = $this->view_all_schools();
    }

    public function index(){ 
        if(is_logged_in()){
            $data['title'] = 'School Furniture Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'furniture/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // view building details page
    public function viewDetails(){
        if(is_logged_in()){
            $userrole = $this->session->userdata['userrole'];
            if($userrole == 'School User'){ // if the user is school, then building details must be displayed by census id
                $censusId = $this->session->userdata['census_id'];
                //$result = $this->School_model->get_logged_school($userid); 
                $furnitureDetails = $this->Furniture_model->view_furniture_info_by_census_id($censusId); 
                if(!$furnitureDetails){
                    $this->session->set_flashdata('no_furniture_info', array('text' => 'No records found!!!','class' => 'alert alert-danger'));
                }else{
                    $data['furniture_info_by_census'] = $furnitureDetails;
                }
            }
            $data['title'] = 'Furniture Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'furniture/viewFurniture';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // this method loaded by this construct method to view all building sizes in db
    public function view_all_furniture_items(){ 
        return $this->Furniture_model->view_all_items();
    }
    // this method loaded by this construct method to view available schools in db
    public function view_all_schools(){
        return $this->School_model->view_all_schools();
    }
    // add new furniture item by admin
    public function addNewFurnitureItem(){
        if(is_logged_in()){
            $this->form_validation->set_rules("item_name_txt","Item Name","trim|required");
            if ($this->form_validation->run() == FALSE){
                //validation fails
                $this->session->set_flashdata('addItemMsg', array('text' => 'Item name is required!','class' => 'alert alert-danger'));
                redirect('Furniture/viewDetails');
            }else{
                $now = date('Y-m-d H:i:s');
                $data = array(
                    'fur_item_id' => '',
                    'fur_item' => $this->input->post('item_name_txt'),
                    'date_added' => $now,
                    'date_updated' => $now,
                    'is_deleted' => '',
                );
                $result = $this->Furniture_model->add_new_item($data);
                if($result){
                    $this->session->set_flashdata('addItemMsg', array('text' => 'Item added successfully','class' => 'alert alert-success'));
                    redirect('Furniture/viewDetails');
                }
            }
        }
    }
    // add furniture items details by school or admin
    public function addSchoolFurnitureInfo(){
        if(is_logged_in()){ 
            if ($this->input->post('btn_add_new_furniture_info') == "Add_New"){
                //echo $this->input->post('repaired_chkbox'); die(); 
                $this->form_validation->set_rules("fur_item_select","Furniture Item","trim|required");
                $this->form_validation->set_rules("qty_txt","Quantity","numeric|trim|required");
                $this->form_validation->set_rules("usable_txt","Usable Quantity","numeric|trim|required");
                //$this->form_validation->set_rules("repairable_txt","Repairable Quantity","trim|required");               
               // $this->form_validation->set_rules("needed_more_txt","Needed more","trim|required");               
                 if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'All the fields are required!','class' => 'alert alert-danger'));
                    $this->viewDetails();
                }else{
                    $censusId = $this->input->post('census_id_select');
                    $furItemId = $this->input->post('fur_item_select');
                    $qty = $this->input->post('qty_txt');
                    $usable = $this->input->post('usable_txt');
                    $repairable = $this->input->post('repairable_txt');
                    $repairable = $this->input->post('needed_more_txt');                    
                    $exists = $this->Furniture_model->check_furniture_info_exists($censusId,$furItemId);
                    if(!$exists){
                        $now = date('Y-m-d H:i:s');
                        $data = array(
                            'fur_item_count_id' => '',
                            'census_id' => $this->input->post('census_id_select'),
                            'fur_item_id' => $this->input->post('fur_item_select'),
                            'quantity' => $this->input->post('qty_txt'),
                            'usable' => $this->input->post('usable_txt'),
                            'repairable' => $this->input->post('repairable_txt'),
                            'needed_more' => $this->input->post('needed_more_txt'),                            
                            'date_added' => $now,
                            'date_updated' => $now,
                            'is_deleted' => '',
                        );
                        $result = $this->Furniture_model->add_new_fur_info($data);
                        if($result){
                            $this->session->set_flashdata('msg', array('text' => 'Details added successfully','class' => 'alert alert-success'));
                        }else{
                            $this->session->set_flashdata('msg', array('text' => 'Error in inserting data!!!','class' => 'alert alert-danger'));
                        }
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'This furniture item details already exists!!!','class' => 'alert alert-danger'));
                    }
                    redirect('Furniture/viewDetails');
                }
            }else{
                redirect('Furniture/viewDetails');
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }  
    }
    public function viewAddFurniturePage(){
        if(is_logged_in()){
            $data['title'] = 'Furniture Details';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'furniture/add_furniture_item';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }

}