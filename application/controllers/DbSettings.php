<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DbSettings extends CI_Controller {

    public function __construct(){
        parent::__construct();
        //$this->load->model('Common_model');
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->helper('download'); // not used
        $this->load->library('zip');
        if(is_logged_in() &&  $this->session->userdata['userrole_id'] == '1'){
            $this->role_id = $this->session->userdata['userrole_id'];
        }else{
            redirect('User');
        }
      
    }
    public function index(){
        if( is_logged_in() ){
            $filename = './assets/db_backup/'.'morawakazeo.sql';
            if( file_exists($filename) ) { // if above file exist
                $backUpData = 'Last Backup : '.date( "Y-m-d H:i:s.A", filemtime($filename) );
                // filectime: when created
                // filemtime: last modified
                // fileatime: last accessed
            }else{  // if above file not exist
                $backUpData = 'No backups found';
            }
            $data['backUpData'] = $backUpData;
            $data['title'] = 'Database Settings';
            $data['user_header'] = 'user_admin_header';
            $data['user_content'] = 'db_settings/index';
            $this->load->view('templates/user_template', $data);
        }else{
            redirect('User');
        }
    }
    public function dbBackup(){
        if( is_logged_in() and $this->role_id==1 ){
            // $this->load->helper('url');
            // $this->load->helper('file');
            // $this->load->library('zip');
            $db = $this->load->dbutil(); 
            //print_r($db); die();
            $prefs = array(
				'format' => 'txt', // gzip, zip, txt
				'filename' => 'morawakazeo.sql', // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'      => FALSE,
                'foreign_key_checks'      => 0
            );
            $backup =& $this->dbutil->backup($prefs);
            //$db_name = 'backup_on_'.date('Y-m-d H:i:s').'.zip';
            $location = 'assets/db_backup/'.'morawakazeo.sql';
            if( write_file( $location, $backup) ){
                $this->session->set_flashdata('backupMsg', array('text' => 'Backed up the DB successfully','class' => 'alert alert-success'));
            }else{
                $this->session->set_flashdata('backupMsg', array('text' => 'Back up the DB was not successful!!!','class' => 'alert alert-danger'));
            }
            redirect('DbSettings');
        }else{
            redirect('User');
        }
    }
    public function dbRestore(){
        if( is_logged_in() and $this->role_id==1 ){
            $filename = './assets/db_backup/'.'morawakazeo.sql';
            if( file_exists($filename) ) { // if above file exist
                $sql_contents = file_get_contents('assets/db_backup/'.'morawakazeo.sql'); 
                //$sql_contents = file_get_contents($file);
                $sql_contents = explode(";", $sql_contents);
                //print_r($sql_contents); die();
                $sql = 'DROP DATABASE morawakazeo';
                if( $this->db->query($sql) ){
                    $sql_create_db = 'create database morawakazeo';
                    $this->db->query($sql_create_db);
                    $sql_select_db = 'select database("morawakazeo")';
                    $this->db->query($sql_select_db);
                    foreach($sql_contents as $query){
                        $pos = strpos($query,'ci_sessions');
                        var_dump($pos);
                        if($pos == false){
                            $result = $this->db->query($query);
                        }else{
                            continue;
                        }
                    }
                    $this->session->set_flashdata('restoreMsg', array('text' => 'Restored the database successfully','class' => 'alert alert-success'));
                }else{
                    $this->session->set_flashdata('restoreMsg', array('text' => 'Could not delete the current database!!!','class' => 'alert alert-danger'));
                }
            }else{
                $this->session->set_flashdata('restoreMsg', array('text' => 'Could not find the database file!!!','class' => 'alert alert-danger'));
            }
            redirect('DbSettings');
        }else{
            redirect('User');
        }
    } 

}