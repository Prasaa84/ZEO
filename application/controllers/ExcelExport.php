<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExcelExport extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->model('School_model');
		$this->load->library("excel/excel");
		//$object = new PHPExcel();
    }

	function index(){

	}
	// used to print school details, when a school logged and to school update window
	// used by admin to print school details
	public function printSchoolById(){
        if(is_logged_in()){
			$id = $this->uri->segment(3);
			$object = new PHPExcel();
			$object->setActiveSheetIndex(0);
			$table_columns = array("", "");

			$column = 0;

			foreach($table_columns as $field)
			{
				$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
				$column++;
			}

			$this->load->model('School_model');
			$result = $this->School_model->view_school_data_by_id($id);

			foreach($result as $row){
				$census_id = $row->census_id;
				$exam_no = $row->exam_no;
				$name = $row->sch_name;
				$address1 = $row->address1;
				$address2 = $row->address2;
				$contact_no = $row->contact_no;
				$email = $row->email;
				$web_address = $row->web_address;
				$gs_div = $row->gs_division;
				$div_name = $row->div_name;
				$sch_type = $row->sch_type;
				$school_details_add_dt = $row->school_details_add_dt;
				$school_details_upd_dt = $row->school_details_upd_dt;
			}
			$last_update_dt = strtotime($school_details_upd_dt);
			$sch_details_last_updated_date = date("j F Y",$last_update_dt);
            $sch_details_last_updated_time = date("h:i A",$last_update_dt);

			$address = $address1.', '.$address2;
			$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
			$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
			$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
			$object->getActiveSheet()->getStyle("B1")->getFont()->setSize(15);
			$object->getActiveSheet()->getStyle("A3:B14")->getFont()->setSize(13);
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 1, $name);
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 3, 'සංගණන අංකය'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 3, $census_id); 		// column 2, row 3
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 4, 'විභාග අංකය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 4, $exam_no);
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 5, 'ලිපිනය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 5, $address);
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 6, 'දුරකථන අංකය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 6, $contact_no);
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 7, 'විද්‍යුත් තැපෑල');
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 7, $email);
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 8, 'වෙබ් ලිපිනය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 8, $web_address);
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 9, 'ග්‍රාම නිළධාරී කොට්ඨාසය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 9, $gs_div);
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 10, 'අධ්‍යාපන කොට්ඨාසය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 10, $div_name);
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 11, 'පාසල් වර්ගය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 11, $sch_type);
			
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 16, 'Updated on '.$sch_details_last_updated_date.' at '.$sch_details_last_updated_time);
			$whoPrint = $this->whoPrint(); 
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 17, 'Printed by '.$whoPrint);

			$filename = $census_id.'_school_info.xlsx';	
			$this->makeExcelFile($object,$filename);		
			
		}else{
            redirect('GeneralInfo/loginPage');
        }    
	}
	// used to print school details, when a school logged and to school update window
	// used by admin to print school details
	public function printSchoolByDiv(){
        if(is_logged_in()){
			$id = $this->uri->segment(3);
			$object = new PHPExcel();
			$object->setActiveSheetIndex(0);
			$table_columns = array("", "");

			$column = 0;

			foreach($table_columns as $field)
			{
				$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
				$column++;
			}

			$this->load->model('School_model');
			$result = $this->School_model->view_school_data_by_division($id);
			foreach($result as $row){
				$div_name = $row->div_name;
			}
			$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
			$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
			$object->getActiveSheet()->getStyle("B1")->getFont()->setSize(15);
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 1, $div_name.' කොට්ඨාසය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 3, 'නම'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 3, 'සංගණන අංකය'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, 3, 'විභාග අංකය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, 3, 'ලිපිනය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, 3, 'දුරකථන අංකය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, 3, 'විද්‍යුත් තැපෑල');
			$object->getActiveSheet()->setCellValueByColumnAndRow(6, 3, 'ග්‍රාම නිළධාරී කොට්ඨාසය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, 3, 'පාසල් වර්ගය');
			$latest_upd_dt = 0;
			$excel_row = 4;
			foreach($result as $row){
				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->sch_name);
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->census_id);
				$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->exam_no);
				$address1 = $row->address1;
				$address2 = $row->address2;
				$address = $address1.', '.$address2;
				$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $address);
				$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->contact_no);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->email);
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->gs_division);
				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->sch_type);
				$excel_row++;
				$school_details_upd_dt = $row->school_details_upd_dt;
				if($latest_upd_dt < $school_details_upd_dt){
					$latest_upd_dt = $school_details_upd_dt;
				}
			}
			$latest_upd_dt = strtotime($latest_upd_dt);
			$sch_details_last_updated_date = date("j F Y",$latest_upd_dt);
            $sch_details_last_updated_time = date("h:i A",$latest_upd_dt);
			$cell = $excel_row;
			$object->getActiveSheet()->getStyle("A3:H".$cell)->getFont()->setSize(13); // font size set to 13 from A4 to last cell in column H
			//$object->getActiveSheet()->getStyle("A".$excel_row+3)->getFont()->setSize(10); // set font size to 10 of the cell after last dynamic row+3
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Updated on '.$sch_details_last_updated_date.' at '.$sch_details_last_updated_time);
			$whoPrint = $this->whoPrint(); 
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+4, 'Printed by '.$whoPrint);

			$filename = $div_name.'_division_schools_info.xlsx';	
			$this->makeExcelFile($object,$filename);		
		}else{
            redirect('GeneralInfo/loginPage');
        }    
	}
	// used to print school details, when a school logged and to school update window
	// used by admin to print school details
	public function printSchoolByType(){
		$id = $this->uri->segment(3);
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('School_model');
		$result = $this->School_model->view_school_data_by_type($id);
		foreach($result as $row){
			$sch_type = $row->sch_type;
		}
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("B1")->getFont()->setSize(15);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 1, $sch_type.' වර්ගයේ පාසල් තොරතුරු');
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 3, 'නම'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 3, 'සංගණන අංකය'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, 3, 'විභාග අංකය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, 3, 'ලිපිනය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, 3, 'දුරකථන අංකය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, 3, 'විද්‍යුත් තැපෑල');
			$object->getActiveSheet()->setCellValueByColumnAndRow(6, 3, 'ග්‍රාම නිළධාරී කොට්ඨාසය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, 3, 'කොට්ඨාසය');
			$latest_upd_dt = 0;
			$excel_row = 4;
			foreach($result as $row){
				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->sch_name);
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->census_id);
				$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->exam_no);
				$address1 = $row->address1;
				$address2 = $row->address2;
				$address = $address1.', '.$address2;
				$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $address);
				$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->contact_no);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->email);
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->gs_division);
				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->div_name);
				$excel_row++;
				$school_details_upd_dt = $row->school_details_upd_dt;
				if($latest_upd_dt < $school_details_upd_dt){
					$latest_upd_dt = $school_details_upd_dt;
				}
			}
			$latest_upd_dt = strtotime($latest_upd_dt);
			$sch_details_last_updated_date = date("j F Y",$latest_upd_dt);
			$sch_details_last_updated_time = date("h:i A",$latest_upd_dt);
			$cell = $excel_row;
			$object->getActiveSheet()->getStyle("A3:H".$cell)->getFont()->setSize(13); // font size set to 13 from A4 to last cell in column H
			//$object->getActiveSheet()->getStyle("A".$excel_row+3)->getFont()->setSize(10); // set font size to 10 of the cell after last dynamic row+3
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Updated on '.$sch_details_last_updated_date.' at '.$sch_details_last_updated_time);
			$whoPrint = $this->whoPrint(); 
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+4, 'Printed by '.$whoPrint);

			$filename = $sch_type.'_schools_info.xlsx';	
			$this->makeExcelFile($object,$filename);		   
	}
	// used to print school details, when a school logged and to school update window
	// used by admin to print school details
	public function printAllSchools(){
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('School_model');
		$result = $this->School_model->view_all_schools_order_by('edu_div_id');

		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("C1")->getFont()->setSize(15);
		$object->getActiveSheet()->setCellValueByColumnAndRow(2, 1, ' දෙනියාය අධ්‍යාපන කලාපයේ සියළුම පාසල් තොරතුරු');
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 3, 'නම'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValueByColumnAndRow(2, 3, 'සංගණන අංකය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(3, 3, 'විභාග අංකය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(4, 3, 'ලිපිනය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(5, 3, 'දුරකථන අංකය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(6, 3, 'විද්‍යුත් තැපෑල');
		$object->getActiveSheet()->setCellValueByColumnAndRow(7, 3, 'ග්‍රාම නිළධාරී කොට්ඨාසය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(8, 3, 'කොට්ඨාසය');
		$latest_upd_dt = 0;
		$excel_row = 4;
		$no = 1;
		foreach($result as $row){
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $no);
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->sch_name);
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->census_id);
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->exam_no);
			$address1 = $row->address1;
			$address2 = $row->address2;
			$address = $address1.', '.$address2;
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $address);
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->contact_no);
			$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->email);
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->gs_division);
			$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->div_name);
			$excel_row++;
			$no++;
			$school_details_upd_dt = $row->school_details_upd_dt;
			if($latest_upd_dt < $school_details_upd_dt){
				$latest_upd_dt = $school_details_upd_dt;
			}
		}
		$latest_upd_dt = strtotime($latest_upd_dt);
		$sch_details_last_updated_date = date("j F Y",$latest_upd_dt);
		$sch_details_last_updated_time = date("h:i A",$latest_upd_dt);
		$cell = $excel_row;
		$object->getActiveSheet()->getStyle("A3:I".$cell)->getFont()->setSize(13); // font size set to 13 from A4 to last cell in column H
		//$object->getActiveSheet()->getStyle("A".$excel_row+3)->getFont()->setSize(10); // set font size to 10 of the cell after last dynamic row+3
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Updated on '.$sch_details_last_updated_date.' at '.$sch_details_last_updated_time);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+4, 'Printed by '.$whoPrint);

		$filename = 'all_schools_info.xlsx';	
		$this->makeExcelFile($object,$filename);		   
	}
	// used by admin to print national school details
	public function printNationalSchools(){
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('School_model');
		$result = $this->School_model->view_national_schools();
		foreach($result as $row){
			$sch_type = $row->sch_type;
		}
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("B1")->getFont()->setSize(15);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'ජාතික පාසල් තොරතුරු');
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, 3, 'නම'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 3, 'සංගණන අංකය'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, 3, 'විභාග අංකය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, 3, 'ලිපිනය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, 3, 'දුරකථන අංකය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, 3, 'විද්‍යුත් තැපෑල');
			$object->getActiveSheet()->setCellValueByColumnAndRow(6, 3, 'ග්‍රාම නිළධාරී කොට්ඨාසය');
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, 3, 'කොට්ඨාසය');
			$latest_upd_dt = 0;
			$excel_row = 4;
			foreach($result as $row){
				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->sch_name);
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->census_id);
				$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->exam_no);
				$address1 = $row->address1;
				$address2 = $row->address2;
				$address = $address1.', '.$address2;
				$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $address);
				$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->contact_no);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->email);
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->gs_division);
				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->div_name);
				$excel_row++;
				$school_details_upd_dt = $row->school_details_upd_dt;
				if($latest_upd_dt < $school_details_upd_dt){
					$latest_upd_dt = $school_details_upd_dt;
				}
			}
			$latest_upd_dt = strtotime($latest_upd_dt);
			$sch_details_last_updated_date = date("j F Y",$latest_upd_dt);
			$sch_details_last_updated_time = date("h:i A",$latest_upd_dt);
			$cell = $excel_row;
			$object->getActiveSheet()->getStyle("A3:H".$cell)->getFont()->setSize(13); // font size set to 13 from A4 to last cell in column H
			//$object->getActiveSheet()->getStyle("A".$excel_row+3)->getFont()->setSize(10); // set font size to 10 of the cell after last dynamic row+3
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Updated on '.$sch_details_last_updated_date.' at '.$sch_details_last_updated_time);
			$whoPrint = $this->whoPrint(); 
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+4, 'Printed by '.$whoPrint);

			$filename = 'national_schools_info.xlsx';	
			$this->makeExcelFile($object,$filename);		   
	}
	function makeExcelFile($object,$filename){
		//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5'); // excel 2003
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007'); // excel 2007
		//header('Content-Type: application/vnd.ms-excel'); 	// excel 2003
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');		// excel 2007
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		$object_writer->save('php://output');	
	}
	function whoPrint(){
		$userrole = $this->session->userdata['userrole'];
        $userid = $this->session->userdata['userid'];
        if($userrole == 'School User'){ // if the user is school, then physical res. details must be displayed by census id
        	$result = $this->School_model->get_logged_school($userid); 
            foreach ($result as $row) {
            	$censusId = $row->census_id;
            }
			$userrole = $censusId.'_'.$userrole; 
			return $userrole; 
		}else{
			return $userrole;
		}
	}
	// used to print physical resource details of a school, when they logged 
	public function printPhyResDetailsByCensusId(){
        if(is_logged_in()){
			$censusId = $this->uri->segment(3);			// get census id
			$recentUpdateDT = $this->uri->segment(4);	// get last update date and time
			$object = new PHPExcel();
			$object->setActiveSheetIndex(0);
			$table_columns = array("අයිතමය", "තත්ත්වය");

			$column = 0;

			foreach($table_columns as $field)
			{
				$object->getActiveSheet()->setCellValueByColumnAndRow($column, 4, $field);
				$column++;
			}

			$this->load->model('Physical_resource_model');
			$result = $this->Physical_resource_model->view_item_status_by_census_id($censusId);
			
			foreach($result as $row){
				$sch_name = $row->sch_name;
			}

            $last_update_dt = strtotime($recentUpdateDT);
			$phy_res_details_last_updated_date = date("j F Y",$last_update_dt);
            $phy_res_details_last_updated_time = date("h:i A",$last_update_dt);

			$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
			$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
			$object->getActiveSheet()->getStyle("B1")->getFont()->setSize(16);
			$object->getActiveSheet()->getStyle("B2")->getFont()->setSize(15);
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 1, $sch_name);
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, 2, 'භෞතික සම්පත් විස්තර');

			$excel_row = 5;
			foreach($result as $row){
				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->phy_res_category);
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->phy_res_status_type);
				$excel_row++;
			}
			$cell = $excel_row;
			$object->getActiveSheet()->getStyle("A4:B".$cell)->getFont()->setSize(13); // font size set to 13 from A4 to last cell in column B
			$object->getActiveSheet()->getStyle("A".$excel_row+3)->getFont()->setSize(10); // set font size to 10 of the cell after last dynamic row+3
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Updated on '.$phy_res_details_last_updated_date.' at '.$phy_res_details_last_updated_time);
			$whoPrint = $this->whoPrint(); 
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+4, 'Printed by '.$whoPrint);

			$filename = $censusId.'_school_phy_res_info.xlsx';	
			$this->makeExcelFile($object,$filename);		
			
		}else{
            redirect('GeneralInfo/loginPage');
        }    
	}
	public function printSchoolByItemStatus(){ // print school details according to physical resource item status
		$catId = $this->uri->segment(3);	// physical resource category ID
		$statusId = $this->uri->segment(4);	// physical resource status ID
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('Physical_resource_model');
		$result = $this->Physical_resource_model->view_schools_by_item_status($catId,$statusId);
		foreach($result as $row){
            $phy_res_category = $row->phy_res_category;
            $status = $row->phy_res_status_type;
		}
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("B1:B2")->getFont()->setSize(15);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'පාසල් තොරතුරු');
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 2, $phy_res_category.' - '.$status);
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, 4, 'නම'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 4, 'සංගණන අංකය'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValueByColumnAndRow(2, 4, 'විභාග අංකය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(3, 4, 'වර්ගය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(4, 4, 'ලිපිනය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(5, 4, 'දුරකථන අංකය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(6, 4, 'විද්‍යුත් තැපෑල');
		$object->getActiveSheet()->setCellValueByColumnAndRow(7, 4, 'ග්‍රාම නිළධාරී කොට්ඨාසය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(8, 4, 'අධ්‍යාපන කොට්ඨාසය');
		$latest_upd_dt = 0;
		$excel_row = 5;
			foreach($result as $row){
				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->sch_name);
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->census_id);
				$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->exam_no);
				$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->sch_type);
				$address1 = $row->address1;
				$address2 = $row->address2;
				$address = $address1.', '.$address2;
				$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $address);
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->contact_no);
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->email);
				$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->gs_division);
				$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->div_name);				
				$excel_row++;
				$school_details_upd_dt = $row->details_date_added;
				if($latest_upd_dt < $school_details_upd_dt){
					$latest_upd_dt = $school_details_upd_dt;
				}
			}
			$latest_upd_dt = strtotime($latest_upd_dt);
			$sch_details_last_updated_date = date("j F Y",$latest_upd_dt);
			$sch_details_last_updated_time = date("h:i A",$latest_upd_dt);
			$cell = $excel_row;
			$object->getActiveSheet()->getStyle("A3:I".$cell)->getFont()->setSize(13); // font size set to 13 from A4 to last cell in column H
			//$object->getActiveSheet()->getStyle("A".$excel_row+3)->getFont()->setSize(10); // set font size to 10 of the cell after last dynamic row+3
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Updated on '.$sch_details_last_updated_date.' at '.$sch_details_last_updated_time);
			$whoPrint = $this->whoPrint(); 
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+4, 'Printed by '.$whoPrint);
			$filename = $phy_res_category.'_'.$status.'_schools_info.xlsx';	
			//$filename = '_schools_info.xlsx';	
			$this->makeExcelFile($object,$filename);		 
	}
	// print computer lab resources school wise
	public function printComResInfoByCensusId(){ // print school details according to physical resource item status
		$censusId = $this->uri->segment(3);	// census ID
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('Computer_lab_model');
		$result = $this->Computer_lab_model->view_item_status_by_census_id($censusId);
		foreach($result as $row){
            $sch_name = $row->sch_name;
		}
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("B1:B2")->getFont()->setSize(15);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 1, $sch_name);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 2, 'පරිගණක ඒකකයේ තොරතුරු');
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, 4, '#'); // 0 is column1, 4 is row4
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 4, 'අයිතමය'); // 0 is column1,  is row3
		$object->getActiveSheet()->setCellValueByColumnAndRow(2, 4, 'තිබෙන ප්‍රමාණය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(3, 4, 'ක්‍රියාකාරී සංඛ්‍යාව');
		$object->getActiveSheet()->setCellValueByColumnAndRow(4, 4, 'සකස්කළ හැකි ප්‍රමාණය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(5, 4, 'සකස්කළ නොහැකි ප්‍රමාණය');
		$latest_upd_dt = 0;
		$excel_row = 5;
		$no=0;
		foreach($result as $row){
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $no);
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->com_lab_res_type);
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->quantity);
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->working);
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->repairable);
			$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->quantity-($row->working+$row->repairable));			
			$no++;		
			$excel_row++;
			$last_update = $row->last_update;
			if($latest_upd_dt < $last_update){
				$latest_upd_dt = $last_update;
			}
		}
		$latest_upd_dt = strtotime($latest_upd_dt);
		$last_updated_date = date("j F Y",$latest_upd_dt);
		$last_updated_time = date("h:i A",$latest_upd_dt);
		$cell = $excel_row;
		$object->getActiveSheet()->getStyle("A3:I".$cell)->getFont()->setSize(13); // font size set to 13 from A4 to last cell in column H
		//$object->getActiveSheet()->getStyle("A".$excel_row+3)->getFont()->setSize(10); // set font size to 10 of the cell after last dynamic row+3
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Updated on '.$last_updated_date.' at '.$last_updated_time);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+4, 'Printed by '.$whoPrint);
		$filename = $censusId.'_com_res_info.xlsx';	
		//$filename = '_schools_info.xlsx';	
		$this->makeExcelFile($object,$filename);		 
	}
	// print library resources school wise
	public function printLibResInfoByCensusId(){ 
		$censusId = $this->uri->segment(3);	// census ID
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('Library_model');
		$result = $this->Library_model->view_item_status_by_census_id($censusId);
		foreach($result as $row){
            $sch_name = $row->sch_name;
		}
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("B1:B2")->getFont()->setSize(15);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 1, $sch_name);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 2, 'පුස්තකාල සම්පත් තොරතුරු');
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, 4, '#'); // 0 is column1, 4 is row4
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 4, 'අයිතමය'); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(2, 4, 'තිබෙන ප්‍රමාණය');
		$latest_upd_dt = 0;
		$excel_row = 5;
		$no=1;
		foreach($result as $row){
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $no);
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->lib_res_type);
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->quantity);
			$no++;		
			$excel_row++;
			$last_update = $row->last_update;
			if($latest_upd_dt < $last_update){
				$latest_upd_dt = $last_update;
			}
		}
		$latest_upd_dt = strtotime($latest_upd_dt);
		$last_updated_date = date("j F Y",$latest_upd_dt);
		$last_updated_time = date("h:i A",$latest_upd_dt);
		$cell = $excel_row;
		$object->getActiveSheet()->getStyle("A3:I".$cell)->getFont()->setSize(13); // font size set to 13 from A4 to last cell in column H
		//$object->getActiveSheet()->getStyle("A".$excel_row+3)->getFont()->setSize(10); // set font size to 10 of the cell after last dynamic row+3
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Updated on '.$last_updated_date.' at '.$last_updated_time);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+4, 'Printed by '.$whoPrint);
		$filename = $censusId.'_com_res_info.xlsx';	
		//$filename = '_schools_info.xlsx';	
		$this->makeExcelFile($object,$filename);		 
	}
	// print sanitary info school wise
	public function printSanitaryInfoByCensusId(){ 
		$censusId = $this->uri->segment(3);	// census ID
		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('Sanitary_model');
		$result = $this->Sanitary_model->view_item_status_by_census_id($censusId);
		foreach($result as $row){
            $sch_name = $row->sch_name;
		}
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("B1:B2")->getFont()->setSize(15);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 1, $sch_name);
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 2, 'සනීපාරක්ෂක පහසුකම් පිළබඳ තොරතුරු');
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, 4, '#'); // 0 is column1, 4 is row4
		$object->getActiveSheet()->setCellValueByColumnAndRow(1, 4, 'අයිතමය'); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(2, 4, 'තිබෙන ප්‍රමාණය');
		$object->getActiveSheet()->setCellValueByColumnAndRow(3, 4, 'භාවිතයට ගත හැකි ප්‍රමාණය'); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(4, 4, 'ප්‍රතිසංස්කරණය කළ හැකි ප්‍රමාණය');
		$latest_upd_dt = 0;
		$excel_row = 5;
		$no=1;
		foreach($result as $row){
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $no);
			$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->san_item_name);
			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->quantity);
			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->usable);
			$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->repairable);
			$no++;		
			$excel_row++;
			$last_update = $row->last_update;
			if($latest_upd_dt < $last_update){
				$latest_upd_dt = $last_update;
			}
		}
		$latest_upd_dt = strtotime($latest_upd_dt);
		$last_updated_date = date("j F Y",$latest_upd_dt);
		$last_updated_time = date("h:i A",$latest_upd_dt);
		$cell = $excel_row;
		$object->getActiveSheet()->getStyle("A3:I".$cell)->getFont()->setSize(13); // font size set to 13 from A4 to last cell in column H
		//$object->getActiveSheet()->getStyle("A".$excel_row+3)->getFont()->setSize(10); // set font size to 10 of the cell after last dynamic row+3
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Updated on '.$last_updated_date.' at '.$last_updated_time);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+4, 'Printed by '.$whoPrint);
		$filename = $censusId.'_sanitary_info.xlsx';	
		//$filename = '_schools_info.xlsx';	
		$this->makeExcelFile($object,$filename);		 
	}
	
}

















































	