<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    //public $userRole = $this->session->userdata['userrole'];

    public function __construct(){
        parent::__construct();
        //$this->load->model('Staff_model');
        //$this->load->model('Common_model');
        $this->load->model('News_model');
    }
    public function index(){
        if(is_logged_in()){
            $limit = 10;
            $latestNews = $this->News_model->get_all_news($limit);
            $limit = '';
            $newsAddedDate = $this->News_model->get_news_added_date(); // to make archive in the view
            $data['title'] = 'News';
            $data['heading'] = 'Recent News';
            $data['news'] = $latestNews;
            $data['newsAddedDate'] = $newsAddedDate; 
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'news/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('Login');
        }
    }
     // loading news update view
    public function newsUpdateView(){ 
        if(is_logged_in()){
            $newsId = $this->uri->segment(3);
            $result = $this->News_model->view_news_by_id($newsId);
            //print_r($result); die();
            $data['news'] = $result;
            $data['title'] = 'Updating News';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'news/editNews';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // update physical resource item
    public function updateNews(){
        if(is_logged_in()){
            if ($this->input->post('btn_edit_news') == "Update"){
                $newsId = $this->input->post('news_id_hidden');
                $this->form_validation->set_rules("title_txtarea","News Title","trim|required");
                $this->form_validation->set_rules("text_txtarea","News Text","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    //redirect('news/newsUpdateView/'.$newsId);
                    $this->afterUpdateNews($newsId);
                }else{  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'news_id' => $this->input->post('news_id_hidden'),
                        'news_title' => $this->input->post('title_txtarea'), // news heading
                        'news_text' => $this->input->post('text_txtarea'),  // news text
                        'date_added' => $this->input->post('date_added_txt'),  // news text
                        'date_updated' => $now,
                        'is_deleted' => $this->input->post('text_txtarea'),  // news text
                    );      
                    //print_r($data); die();    
                    $result = $this->News_model->update_news($data);
                    if($result){
                        $this->session->set_flashdata('msg', array('text' => 'News updated successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'Error in updating the news','class' => 'alert alert-danger','update'=>'false'));
                    }
                    $this->afterUpdateNews($newsId);
                }
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }    
    }
    // this is used to go back after item status details are updated
    public function afterUpdateNews($id){ 
        if(is_logged_in()){
            $newsId = $id; 
            $result = $this->News_model->view_news_by_id($newsId);
            $data['news'] = $result;
            $data['title'] = 'Updating News';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'news/editNews';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    // upload featured image
    public function addFeaturedImage(){
        if($this->input->post('btn_upload_featured_img')=='upload_image'){
            $news_id = $this->input->post('news_id_hidden');
            if(!empty($_FILES['featured_image']['name'])){
                $config['upload_path']          = './assets/images/news/';
                $config['allowed_types']        = 'jpg';
                //$config['max_size']             = 400; // 100KB
                $config['max_width']            = 1024;
                $config['max_height']           = 768;
                $config['file_name']            = $news_id;
                $config['overwrite']           = TRUE;
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('featured_image')){
                    $uploadError = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('imgUploadError',$uploadError);
                }else{
                    $uploadSuccess = 'Image uploaded successfully';

                    $this->session->set_flashdata('imgUploadSuccess',$uploadSuccess);
                }
            }else{
                $noImageError = 'Please select the image';
                $this->session->set_flashdata('noImageError',$noImageError);
            }
            redirect('news/newsUpdateView/'.$news_id);
            //$this->afterUpdateNews($news_id);
        }
    }
    public function viewNewsByMonth(){
        $yearMonth = $this->uri->segment(3);
        $parts = explode('-', $yearMonth);
        $year = $parts[0];
        $month = $parts[1]; // month number
        $monthName = date("F", mktime(0, 0, 0, $month, 10)); // convert month number to month name
        $condition = 'date_format(date_added,"%Y-%m") = "'.$yearMonth.'" ';
        $result = $this->News_model->get_news_by($condition);
        $newsAddedDate = $this->News_model->get_news_added_date(); // to make archive in the view
        //print_r($result); die();
            $data['title'] = 'News for the Month of '.$monthName.', '.$year;
            $data['heading'] = 'News for the Month of '.$monthName.', '.$year;
            $data['news'] = $result; // this news variable is used in index function too
            $data['newsAddedDate'] = $newsAddedDate;  // to create the archive in news index page 
        if(is_logged_in()){
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'news/index';
            $this->load->view('templates/user_template', $data);    
        }else{
            $data['content'] = 'general_info/news';
            $this->load->view('templates/template', $data);
        }  
    }
    public function addNews(){ 
        if(is_logged_in()){
            if ($this->input->post('btn_add') == "Add_New"){
                $this->form_validation->set_rules("title_txtarea","News Title","trim|required");
                $this->form_validation->set_rules("text_txtarea","News Text","trim|required");
                if ($this->form_validation->run() == FALSE){
                    //validation fails
                    $this->session->set_flashdata('msg', array('text' => 'News title and news text fields are required!','class' => 'alert alert-danger'));
                    redirect('news');
                }else{ 
                    if(!empty($_FILES['featured_image']['name'])){
                        $lastNews = $this->News_model->get_last_news();
                        foreach ($lastNews as $news) {
                            $newsId = $news->news_id; // recent news id 
                        }
                        $newId = $newsId + 1; // this is new news id and image is renamed with it
                        $newId;
                        //die();
                        $config['upload_path']          = './assets/images/news/';
                        $config['allowed_types']        = 'jpg';
                        //$config['max_size']             = 400; // 100KB
                        $config['max_width']            = 1024;
                        $config['max_height']           = 768;
                        $config['file_name']            = $newId; // name the image with new news_id
                        $config['overwrite']           = TRUE;
                        $this->load->library('upload', $config);
                        if(!$this->upload->do_upload('featured_image')){
                            $uploadError = array('error' => $this->upload->display_errors());
                            $this->session->set_flashdata('imgUploadError',$uploadError);
                            redirect('news');
                        }else{
                            $uploadSuccess = 'Image uploaded successfully';
                            $this->session->set_flashdata('imgUploadSuccess',$uploadSuccess);
                        }
                    }
                    $userRole = $this->session->userdata['userrole'];  
                    $now = date('Y-m-d H:i:s');
                    $data = array(
                        'news_id' => '',
                        'news_title' => $this->input->post('title_txtarea'), // news heading
                        'news_text' => $this->input->post('text_txtarea'),  // news text
                        'by_whom' => $userRole,
                        'date_added' => $now, 
                        'date_updated' => $now,
                        'is_deleted' => ''
                    );      
                    //print_r($data); die();    
                    $result = $this->News_model->add_news($data);
                    if($result){
                        $this->session->set_flashdata('msg', array('text' => 'News inserted successfully','class' => 'alert alert-success','update'=>'true'));
                    }else{
                        $this->session->set_flashdata('msg', array('text' => 'Error in inserting the news','class' => 'alert alert-danger','update'=>'false'));
                    }
                    redirect('news');
                }
            }
        }else{
            redirect('GeneralInfo/loginPage');
        }
    }
    public function deleteNews(){
        $newsId = $this->input->post('news_id');
        $now = date('Y-m-d H:i:s');     
        //print_r($data); die();    
        $result = $this->News_model->delete_news($newsId,$now);
        if(file_exists("./assets/images/news/$newsId.jpg")){
            unlink('./assets/images/news/'.$newsId.'.jpg');
        }
        if($result){
            echo 'true';
        }else{
            echo 'false';
        }
    }

}