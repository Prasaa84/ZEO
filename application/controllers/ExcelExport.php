<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExcelExport extends CI_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->model('School_model');
		$this->load->library("excel/Excel");
		//$object = new PHPExcel();
    }

	function index(){

	}
	function makeExcelFile($object,$filename){
		//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5'); // excel 2003
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007'); // excel 2007
		ob_end_clean();
		//header('Content-Type: application/vnd.ms-excel'); 	// excel 2003
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');		// excel 2007
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		$object_writer->save('php://output');
		exit;	
	}
	function whoPrint(){
		$userrole = $this->session->userdata['userrole'];
        $userid = $this->session->userdata['userid'];
        if($userrole == 'School User'){ 
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
				$province = $row->pro_name;
				$district = $row->dis_name;
				$zone = $row->zone_name;
				$div_name = $row->div_name;
				$div_sec = $row->div_sec_name_si;
				$gs_div = $row->gs_name_si;
				$sch_type = $row->sch_type;
				$belongs_to_name = $row->belongs_to_name;
				$grade_span = $row->grd_span_desc;

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
			$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);
			$object->getActiveSheet()->mergeCells('A1:B1');
			$object->getActiveSheet()->getStyle("A3:B17")->getFont()->setSize(13);
			$object->getActiveSheet()->setCellValue('A1', $name);
			$object->getActiveSheet()->setCellValue('A3', 'සංගණන අංකය'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValue('B3', $census_id); 		// column 2, row 3
			$object->getActiveSheet()->setCellValue('A4', 'විභාග අංකය');
			$object->getActiveSheet()->setCellValue('B4', $exam_no);
			$object->getActiveSheet()->setCellValue('A5', 'ලිපිනය');
			$object->getActiveSheet()->setCellValue('B5', $address);
			$object->getActiveSheet()->setCellValue('A6', 'දුරකථන අංකය');
			$object->getActiveSheet()->setCellValue('B6', $contact_no);
			$object->getActiveSheet()->setCellValue('A7', 'විද්‍යුත් තැපෑල');
			$object->getActiveSheet()->setCellValue('B7', $email);
			$object->getActiveSheet()->setCellValue('A8', 'වෙබ් ලිපිනය');
			$object->getActiveSheet()->setCellValue('B8', $web_address);
			$object->getActiveSheet()->setCellValue('A9', 'පලාත');
			$object->getActiveSheet()->setCellValue('B9', $province);
			$object->getActiveSheet()->setCellValue('A10', 'දිස්ත්‍රික්කය');
			$object->getActiveSheet()->setCellValue('B10', $district);
			$object->getActiveSheet()->setCellValue('A11', 'අධ්‍යාපන කලාපය');
			$object->getActiveSheet()->setCellValue('B11', $zone);
			$object->getActiveSheet()->setCellValue('A12', 'අධ්‍යාපන කොට්ඨාසය');
			$object->getActiveSheet()->setCellValue('B12', $div_name);
			$object->getActiveSheet()->setCellValue('A13', 'ප්‍රාදේශීය ලේකම් කොට්ඨාසය');
			$object->getActiveSheet()->setCellValue('B13', $div_sec);
			$object->getActiveSheet()->setCellValue('A14', 'ග්‍රාම නිළධාරී කොට්ඨාසය');
			$object->getActiveSheet()->setCellValue('B14', $gs_div);			
			$object->getActiveSheet()->setCellValue('A15', 'පාසල් වර්ගය');
			$object->getActiveSheet()->setCellValue('B15', $sch_type);
			$object->getActiveSheet()->setCellValue('A16', 'කුමන පාසලක්ද?');
			$object->getActiveSheet()->setCellValue('B16', $belongs_to_name);			
			$object->getActiveSheet()->setCellValue('A17', 'පන්ති පරාසය');
			$object->getActiveSheet()->setCellValue('B17', $grade_span);
			
			$object->getActiveSheet()->setCellValue('A19', 'Updated on '.$sch_details_last_updated_date.' at '.$sch_details_last_updated_time);
			$whoPrint = $this->whoPrint(); 
			$object->getActiveSheet()->setCellValue('A20', 'Printed by '.$whoPrint);

			// add borders to each column separately
			$styleArray = '';
			$styleArray = array(
		        'borders' => array(
		            'outline' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
	        	)
	    	);

			// text align = center
			$textAlignStyle = array(
        		'alignment' => array(
            		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        		)
    		);

    		$object->getActiveSheet()->getStyle("A1:B1")->applyFromArray($textAlignStyle);
			//$object->getActiveSheet()->getStyle('A3:B3')->applyFromArray($styleArray); // 
			$object->getActiveSheet()->getStyle('A3:A17')->applyFromArray($styleArray); // 
			$object->getActiveSheet()->getStyle('B3:B17')->applyFromArray($styleArray); // 

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
			//die();
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
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->gs_div_name);
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
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->gs_name_si);
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
			$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->gs_div_name);
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
	// used to print physical resource details of a school, when they logged 
	public function printPhyResDetailsByCensusId(){
        if(is_logged_in()){
			$censusId = $this->uri->segment(3);			// get census id
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
			$object->getActiveSheet()->mergeCells('A1:B1');
			$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);
			$object->getActiveSheet()->mergeCells('A2:B2');
			$object->getActiveSheet()->getStyle("A2")->getFont()->setSize(13);
			$object->getActiveSheet()->setCellValue('A1', $sch_name);
			$object->getActiveSheet()->setCellValue('A2', 'භෞතික සම්පත් විස්තර');
			$latest_upd_dt = 0;
			$excel_row = 5;
			foreach( $result as $row ){
				$object->getActiveSheet()->setCellValue('A'.$excel_row, $row->phy_res_category);
				$object->getActiveSheet()->setCellValue('B'.$excel_row, $row->phy_res_status_type);
				$excel_row++;
				$last_update = $row->last_update;
				if( $latest_upd_dt < $last_update ){
					$latest_upd_dt = $last_update;
				}
			}
			$latest_upd_dt = strtotime($latest_upd_dt);
			$last_updated_date = date("j F Y",$latest_upd_dt);
			$last_updated_time = date("h:i A",$latest_upd_dt);
			$cell = $excel_row;
			$object->getActiveSheet()->getStyle("A4:B".$cell)->getFont()->setSize(12); // font size set to 12 from A4 to last cell in column B
			$object->getActiveSheet()->getStyle("A".$excel_row+2)->getFont()->setSize(10); // set font size to 10 of the cell after last dynamic row+3
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+2, 'Updated on '.$last_updated_date.' at '.$last_updated_time);
			$whoPrint = $this->whoPrint(); 
			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Printed by '.$whoPrint);

			// add borders to each column separately
			$styleArray = '';
			$styleArray = array(
		        'borders' => array(
		            'outline' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
	        	)
	    	);

			// text align = center
			$textAlignStyle = array(
        		'alignment' => array(
            		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        		)
    		);

    		$object->getActiveSheet()->getStyle("A1:B1")->applyFromArray($textAlignStyle);
    		$object->getActiveSheet()->getStyle("A2:B2")->applyFromArray($textAlignStyle);
    		$object->getActiveSheet()->getStyle("A4:B4")->applyFromArray($textAlignStyle);
			$object->getActiveSheet()->getStyle('A4')->applyFromArray($styleArray); // 
			$object->getActiveSheet()->getStyle('B4')->applyFromArray($styleArray); // 
			$cell = $cell - 1;
			$object->getActiveSheet()->getStyle('A4:A'.$cell)->applyFromArray($styleArray); // 
			$object->getActiveSheet()->getStyle('B4:B'.$cell)->applyFromArray($styleArray); // 
			$object->getActiveSheet()->getStyle("A4:B4")->getFont()->setBold( true );

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
            $phy_res_category = $row->phy_res_category; // used below
            $status = $row->phy_res_status_type;
		}

		// cell formatting in table column
		$styleArray = array(
	        'font' => array(
	            'bold' => true
	        ),
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
    	$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$object->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$object->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$object->getActiveSheet()->getPageSetup()->setFitToHeight(0);

		$object->getActiveSheet()->getStyle("A3:J3")->applyFromArray($styleArray);
		$object->getActiveSheet()->getColumnDimension('A')->setWidth('3');	
		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('C')->setWidth('8');	
		$object->getActiveSheet()->getColumnDimension('D')->setWidth('8');	
		$object->getActiveSheet()->getColumnDimension('E')->setWidth('8');		
		$object->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);	
		$object->getActiveSheet()->getColumnDimension('G')->setWidth('12');
		$object->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);	
		$object->getActiveSheet()->getColumnDimension('I')->setAutoSize(TRUE);	
		$object->getActiveSheet()->getColumnDimension('J')->setWidth('12');	
		$object->getActiveSheet()->getColumnDimension('K')->setWidth('20');	
		$object->getActiveSheet()->getStyle('C3:K3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->mergeCells('A1:K1');
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);
		$object->getActiveSheet()->setCellValue('A1', $phy_res_category.' - '.$status. ' තත්ත්වයේ පාසල් වල තොරතුරු');

		$object->getActiveSheet()->setCellValue('A3', '#'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValue('B3', 'නම'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValue('C3', 'සංගණන අංකය'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValue('D3', 'විභාග අංකය');
		$object->getActiveSheet()->setCellValue('E3', 'වර්ගය');
		$object->getActiveSheet()->setCellValue('F3', 'ලිපිනය');
		$object->getActiveSheet()->setCellValue('G3', 'දුරකථන අංකය');
		$object->getActiveSheet()->setCellValue('H3', 'විද්‍යුත් තැපෑල');
		$object->getActiveSheet()->setCellValue('I3', 'ග්‍රාම නිළධාරී කොට්ඨාසය');
		$object->getActiveSheet()->setCellValue('J3', 'අධ්‍යාපන කොට්ඨාසය');
		$object->getActiveSheet()->setCellValue('K3', 'යාවත්කලීන කල දිනය');
		$latest_upd_dt = 0;
		$excel_row = 4;
		$no=1;
		foreach($result as $row){
			$object->getActiveSheet()->setCellValue('A'.$excel_row, $no);
			$object->getActiveSheet()->setCellValue('B'.$excel_row, $row->sch_name);
			$object->getActiveSheet()->setCellValue('C'.$excel_row, $row->census_id);
			$object->getActiveSheet()->setCellValue('D'.$excel_row, $row->exam_no);
			$object->getActiveSheet()->setCellValue('E'.$excel_row, $row->sch_type);
			$object->getActiveSheet()->setCellValue('F'.$excel_row, $row->address1.', '.$row->address2);	
			$object->getActiveSheet()->setCellValue('G'.$excel_row, $row->contact_no);
			$object->getActiveSheet()->setCellValue('H'.$excel_row, $row->email);
			$object->getActiveSheet()->setCellValue('I'.$excel_row, $row->gs_div_name);
			$object->getActiveSheet()->setCellValue('J'.$excel_row, $row->div_name);
			$object->getActiveSheet()->setCellValue('K'.$excel_row, $row->details_date_added);			
			$no++;		
			$excel_row++;
			$last_update = $row->details_date_added;
			if($latest_upd_dt < $last_update){
				$latest_upd_dt = $last_update;
			}
		}


		$latest_upd_dt = strtotime($latest_upd_dt);
		$sch_details_last_updated_date = date("j F Y",$latest_upd_dt);
		$sch_details_last_updated_time = date("h:i A",$latest_upd_dt);
		$cell = $excel_row;
		$object->getActiveSheet()->setCellValue('A'.($excel_row+2), 'Updated on '.$sch_details_last_updated_date.' at '.$sch_details_last_updated_time);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValue('A'.($excel_row+3), 'Printed by '.$whoPrint);

		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);

		// text align = center
		$textAlignStyle = array(
    		'alignment' => array(
        		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    		)
		);

		$object->getActiveSheet()->getStyle("A1")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A3:K3")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A3:K3")->applyFromArray($styleArray);  
		$cell = $cell - 1;
		$object->getActiveSheet()->getStyle('A4:A'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('B4:B'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('C4:C'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('D4:D'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('E4:E'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('F4:F'.$cell)->applyFromArray($styleArray); 
		$object->getActiveSheet()->getStyle('G4:G'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('H4:H'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('I4:I'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('J4:J'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('K4:K'.$cell)->applyFromArray($styleArray); 

		$object->getActiveSheet()->getStyle("A3:K3")->getFont()->setBold( true );

		$filename = $phy_res_category.'_'.$status.'_schools_info.xlsx';	
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
		// cell formatting in table column
		$styleArray = array(
	        'font' => array(
	            'bold' => true
	        ),
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
		$object->getActiveSheet()->getStyle("A4:F4")->applyFromArray($styleArray);
		$object->getActiveSheet()->getColumnDimension('A')->setWidth('5');		
		$object->getActiveSheet()->getColumnDimension('D')->setWidth('12');	
		$object->getActiveSheet()->getColumnDimension('E')->setWidth('12');		
		$object->getActiveSheet()->getColumnDimension('F')->setWidth('12');		
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle('C4:F4')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->mergeCells('A1:F1');
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);
		$object->getActiveSheet()->mergeCells('A2:F2');
		$object->getActiveSheet()->getStyle("A2")->getFont()->setSize(13);
		$object->getActiveSheet()->setCellValue('A1', $sch_name);
		$object->getActiveSheet()->setCellValue('A2', 'පරිගණක ඒකකයේ තොරතුරු');

		$object->getActiveSheet()->setCellValue('A4', '#'); // 0 is column1, 4 is row4
		$object->getActiveSheet()->setCellValue('B4', 'අයිතමය'); // 0 is column1,  is row3
		$object->getActiveSheet()->setCellValue('C4', 'තිබෙන ප්‍රමාණය');
		$object->getActiveSheet()->setCellValue('D4', 'ක්‍රියාකාරී සංඛ්‍යාව');
		$object->getActiveSheet()->setCellValue('E4', 'සකස්කළ හැකි ප්‍රමාණය');
		$object->getActiveSheet()->setCellValue('F4', 'සකස්කළ නොහැකි ප්‍රමාණය');
		$latest_upd_dt = 0;
		$excel_row = 5;
		$no=1;
		foreach($result as $row){
			$object->getActiveSheet()->setCellValue('A'.$excel_row, $no);
			$object->getActiveSheet()->setCellValue('B'.$excel_row, $row->com_lab_res_type);
			$object->getActiveSheet()->setCellValue('C'.$excel_row, $row->quantity);
			$object->getActiveSheet()->setCellValue('D'.$excel_row, $row->working);
			$object->getActiveSheet()->setCellValue('E'.$excel_row, $row->repairable);
			$object->getActiveSheet()->setCellValue('F'.$excel_row, $row->quantity-($row->working+$row->repairable));			
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
		$object->getActiveSheet()->getStyle("A4:F".$cell)->getFont()->setSize(13); // font size set to 13 from A4 to last cell in column H
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+2, 'Updated on '.$last_updated_date.' at '.$last_updated_time);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Printed by '.$whoPrint);

		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);

		// text align = center
		$textAlignStyle = array(
    		'alignment' => array(
        		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    		)
		);

		$object->getActiveSheet()->getStyle("A1")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A2")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A4:F4")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A4:F4")->applyFromArray($styleArray); // 
		$cell = $cell - 1;
		$object->getActiveSheet()->getStyle('A4:A'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('B4:B'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('C4:C'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('D4:D'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('E4:E'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('F4:F'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle("A4:F4")->getFont()->setBold( true );

		$filename = $censusId.'_com_res_info.xlsx';	
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
		$object->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
		$object->getActiveSheet()->mergeCells('A1:C1');
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);
		$object->getActiveSheet()->mergeCells('A2:C2');
		$object->getActiveSheet()->getStyle("A2")->getFont()->setSize(13);

		$object->getActiveSheet()->setCellValue('A1', $sch_name);
		$object->getActiveSheet()->setCellValue('A2', 'පුස්තකාල සම්පත් තොරතුරු');
		$object->getActiveSheet()->setCellValue('A4', '#'); // 0 is column1, 4 is row4
		$object->getActiveSheet()->setCellValue('B4', 'අයිතමය'); 
		$object->getActiveSheet()->setCellValue('C4', 'තිබෙන ප්‍රමාණය');
		$latest_upd_dt = 0;
		$excel_row = 5;
		$no=1;
		foreach($result as $row){
			$object->getActiveSheet()->setCellValue('A'.$excel_row, $no);
			$object->getActiveSheet()->setCellValue('B'.$excel_row, $row->lib_res_type);
			$object->getActiveSheet()->setCellValue('C'.$excel_row, $row->quantity);
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
		$object->getActiveSheet()->setCellValue('A'.($cell+2), 'Updated on '.$last_updated_date.' at '.$last_updated_time);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValue('A'.($cell+3), 'Printed by '.$whoPrint);
		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);

		// text align = center
		$textAlignStyle = array(
    		'alignment' => array(
        		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    		)
		);

		$object->getActiveSheet()->getStyle("A1")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A2")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A4:C4")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A4:C4")->applyFromArray($styleArray); // 
		$cell = $cell - 1;
		$object->getActiveSheet()->getStyle('A4:A'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('B4:B'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('C4:C'.$cell)->applyFromArray($styleArray); //
		$object->getActiveSheet()->getStyle('C4:C'.$cell)->applyFromArray($textAlignStyle); //
		$object->getActiveSheet()->getStyle('A4:A'.$cell)->applyFromArray($textAlignStyle); // 
		$object->getActiveSheet()->getStyle("A4:C4")->getFont()->setBold( true );		
		
		$filename = $censusId.'_com_res_info.xlsx';	
		$this->makeExcelFile($object,$filename);		 
	}

	// print furniture info school wise
	public function printFurnitureInfoByCensusId(){ 

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

		$this->load->model('Furniture_model');
		$result = $this->Furniture_model->view_furniture_info_by_census_id($censusId);
		foreach( $result as $row ){
            $sch_name = $row->sch_name;
		}
		// cell formatting in table column
		$styleArray = array(
	        'font' => array(
	            'bold' => true
	        ),
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);

		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$object->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$object->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$object->getActiveSheet()->getPageSetup()->setFitToHeight(0);

		$object->getActiveSheet()->getStyle("A4:H4")->applyFromArray($styleArray);
		$object->getActiveSheet()->getColumnDimension('A')->setWidth('5');	
		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth('12');	
		$object->getActiveSheet()->getColumnDimension('E')->setWidth('12');	
		//$object->getActiveSheet()->getColumnDimension('E')->setWidth('12');		
		$object->getActiveSheet()->getColumnDimension('F')->setWidth('15');		
		$object->getActiveSheet()->getColumnDimension('G')->setWidth('12');		
		$object->getActiveSheet()->getColumnDimension('H')->setWidth('24');		
		$object->getActiveSheet()->getStyle('C4:H4')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->mergeCells('A1:H1');
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);
		$object->getActiveSheet()->mergeCells('A2:H2');
		$object->getActiveSheet()->getStyle("A2")->getFont()->setSize(13);
		$object->getActiveSheet()->setCellValue('A1', $sch_name);
		$object->getActiveSheet()->setCellValue('A2', 'ගෘහ භාණ්ඩ තොරතුරු');

		$object->getActiveSheet()->setCellValue('A4', '#'); // 0 is column1, 4 is row4
		$object->getActiveSheet()->setCellValue('B4', 'අයිතමය'); // 0 is column1,  is row3
		$object->getActiveSheet()->setCellValue('C4', 'තිබෙන ප්‍රමාණය');
		$object->getActiveSheet()->setCellValue('D4', 'භාවිතයට ගත හැකි ප්‍රමාණය');
		$object->getActiveSheet()->setCellValue('E4', 'අළුත්වැඩියා කල හැකි ප්‍රමාණය');
		$object->getActiveSheet()->setCellValue('F4', 'අළුත්වැඩියා කල නොහැකි ප්‍රමාණය');
		$object->getActiveSheet()->setCellValue('G4', 'තවදුරටත් අවශ්‍ය ප්‍රමාණය');
		$object->getActiveSheet()->setCellValue('H4', 'යාවත්කාලීන කල දිනය');

		$latest_upd_dt = 0;
		$excel_row = 5;
		$no=1;
		foreach($result as $row){
			$object->getActiveSheet()->setCellValue('A'.$excel_row, $no);
			$object->getActiveSheet()->setCellValue('B'.$excel_row, $row->fur_item);
			$object->getActiveSheet()->setCellValue('C'.$excel_row, $row->quantity);
			$object->getActiveSheet()->setCellValue('D'.$excel_row, $row->usable);
			$object->getActiveSheet()->setCellValue('E'.$excel_row, $row->repairable);
			$object->getActiveSheet()->setCellValue('F'.$excel_row, $row->quantity-($row->usable+$row->repairable));	
			$object->getActiveSheet()->setCellValue('G'.$excel_row, $row->needed_more);
			$object->getActiveSheet()->setCellValue('H'.$excel_row, $row->updated_date);			
			$no++;		
			$excel_row++;
			$last_update = $row->updated_date;
			if($latest_upd_dt < $last_update){
				$latest_upd_dt = $last_update;
			}
		}
		$latest_upd_dt = strtotime($latest_upd_dt);
		$last_updated_date = date("j F Y",$latest_upd_dt);
		$last_updated_time = date("h:i A",$latest_upd_dt);
		$cell = $excel_row;
		$object->getActiveSheet()->getStyle("A4:H".$cell)->getFont()->setSize(13); // font size set to 13 from A4 to last cell in column H
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+2, 'Updated on '.$last_updated_date.' at '.$last_updated_time);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Printed by '.$whoPrint);

		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);

		// text align = center
		$textAlignStyle = array(
    		'alignment' => array(
        		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    		)
		);

		$object->getActiveSheet()->getStyle("A1")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A2")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A4:H4")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A4:H4")->applyFromArray($styleArray);  
		$cell = $cell - 1;
		$object->getActiveSheet()->getStyle('A4:A'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('B4:B'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('C4:C'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('D4:D'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('E4:E'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('F4:F'.$cell)->applyFromArray($styleArray); 
		$object->getActiveSheet()->getStyle('G4:G'.$cell)->applyFromArray($styleArray);  
		$object->getActiveSheet()->getStyle('H4:H'.$cell)->applyFromArray($styleArray);
		$object->getActiveSheet()->getStyle('C4:C'.$cell)->applyFromArray($textAlignStyle);  
		$object->getActiveSheet()->getStyle('D4:D'.$cell)->applyFromArray($textAlignStyle);  
		$object->getActiveSheet()->getStyle('E4:E'.$cell)->applyFromArray($textAlignStyle);  
		$object->getActiveSheet()->getStyle('F4:F'.$cell)->applyFromArray($textAlignStyle); 
		$object->getActiveSheet()->getStyle('G4:G'.$cell)->applyFromArray($textAlignStyle);

		$object->getActiveSheet()->getStyle("A4:H4")->getFont()->setBold( true );

		$filename = $censusId.'_furniture_info.xlsx';	
		$this->makeExcelFile($object,$filename);		 
	}

	// print building info school wise
	public function printBuildingInfoByCensusId(){ 
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

		$this->load->model('Building_model');
		$result = $this->Building_model->view_building_info_by_census_id($censusId);
		foreach($result as $row){
            $sch_name = $row->sch_name;
		}
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$object->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$object->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$object->getActiveSheet()->getPageSetup()->setFitToHeight(0);

		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
		$object->getActiveSheet()->mergeCells('A1:G1');
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);
		$object->getActiveSheet()->mergeCells('A2:G2');
		$object->getActiveSheet()->getStyle("A2")->getFont()->setSize(13);

		$object->getActiveSheet()->setCellValue('A1', $sch_name);
		$object->getActiveSheet()->setCellValue('A2', 'ගොඩනැඟිලි පිළබඳ තොරතුරු');
		$object->getActiveSheet()->setCellValue('A4', '#'); 
		$object->getActiveSheet()->setCellValue('B4', 'වර්ගය'); 
		$object->getActiveSheet()->setCellValue('C4', 'මහල් සංඛ්‍යාව');
		$object->getActiveSheet()->setCellValue('D4', 'භාවිතය'); 
		$object->getActiveSheet()->setCellValue('E4', 'දිග(m)');
		$object->getActiveSheet()->setCellValue('F4', 'පළල(m)');
		$object->getActiveSheet()->setCellValue('G4', 'ආධාර ලබාදුන් ආයතනය');
		$object->getActiveSheet()->setCellValue('H4', 'යාවත්කාලීන වූ දිනය');
		$latest_upd_dt = 0;
		$excel_row = 5;
		$no=1;
		foreach($result as $row){
			$object->getActiveSheet()->setCellValue('A'.$excel_row, $no);
			$object->getActiveSheet()->setCellValue('B'.$excel_row, $row->b_cat_name);
			$object->getActiveSheet()->setCellValue('C'.$excel_row, $row->b_floor);
			$object->getActiveSheet()->setCellValue('D'.$excel_row, $row->b_usage);
			$object->getActiveSheet()->setCellValue('E'.$excel_row, $row->length);
			$object->getActiveSheet()->setCellValue('F'.$excel_row, $row->width);
			$object->getActiveSheet()->setCellValue('G'.$excel_row, $row->donated_by);
			$object->getActiveSheet()->setCellValue('H'.$excel_row, $row->last_update);
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
		$object->getActiveSheet()->setCellValue('A'.($excel_row+2), 'Updated on '.$last_updated_date.' at '.$last_updated_time);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValue('A'.($excel_row+3), 'Printed by '.$whoPrint);

		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);

		// text align = center
		$textAlignStyle = array(
    		'alignment' => array(
        		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    		)
		);

		$object->getActiveSheet()->getStyle("A1")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A2")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A4:H4")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A4:H4")->applyFromArray($styleArray); // 

		$cell = $cell - 1;
		$object->getActiveSheet()->getStyle('A4:A'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('B4:B'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('C4:C'.$cell)->applyFromArray($styleArray); //
		$object->getActiveSheet()->getStyle('D4:D'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('E4:E'.$cell)->applyFromArray($styleArray); //
		$object->getActiveSheet()->getStyle('F4:F'.$cell)->applyFromArray($styleArray); 
		$object->getActiveSheet()->getStyle('G4:G'.$cell)->applyFromArray($styleArray); 
		$object->getActiveSheet()->getStyle('H4:H'.$cell)->applyFromArray($styleArray); 
		$object->getActiveSheet()->getStyle('C4:C'.$cell)->applyFromArray($textAlignStyle); //
		$object->getActiveSheet()->getStyle('E4:E'.$cell)->applyFromArray($textAlignStyle); //
		$object->getActiveSheet()->getStyle('F4:F'.$cell)->applyFromArray($textAlignStyle); //
		$object->getActiveSheet()->getStyle('H4:H'.$cell)->applyFromArray($textAlignStyle); //
		$object->getActiveSheet()->getStyle('A4:A'.$cell)->applyFromArray($textAlignStyle); //
		$object->getActiveSheet()->getColumnDimension('A')->setWidth('5');	
		$object->getActiveSheet()->getStyle('C4')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getColumnDimension('C')->setWidth('10');	
		$object->getActiveSheet()->getStyle('D4')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('E4')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth('10');	
		$object->getActiveSheet()->getStyle('F4')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth('10');	
		$object->getActiveSheet()->getStyle('G4')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('H4')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getColumnDimension('H')->setWidth('22');	
		$object->getActiveSheet()->getStyle("A4:H4")->getFont()->setBold( true ); // columnt headers are bold

		$filename = $censusId.'_building_info.xlsx';	
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
		$object->getActiveSheet()->mergeCells('A1:F1');
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);
		$object->getActiveSheet()->mergeCells('A2:F2');
		$object->getActiveSheet()->getStyle("A2")->getFont()->setSize(13);

		$object->getActiveSheet()->setCellValue('A1', $sch_name);
		$object->getActiveSheet()->setCellValue('A2', 'සනීපාරක්ෂක පහසුකම් පිළබඳ තොරතුරු');
		$object->getActiveSheet()->setCellValue('A4', '#'); 
		$object->getActiveSheet()->setCellValue('B4', 'අයිතමය'); 
		$object->getActiveSheet()->setCellValue('C4', 'තිබෙන ප්‍රමාණය');
		$object->getActiveSheet()->setCellValue('D4', 'භාවිතයට ගත හැකි ප්‍රමාණය'); 
		$object->getActiveSheet()->setCellValue('E4', 'ප්‍රතිසංස්කරණය කළ හැකි ප්‍රමාණය');
		$object->getActiveSheet()->setCellValue('F4', 'ප්‍රතිස. කළ නොහැකි ප්‍රමාණය');

		$latest_upd_dt = 0;
		$excel_row = 5;
		$no=1;
		foreach($result as $row){
			$object->getActiveSheet()->setCellValue('A'.$excel_row, $no);
			$object->getActiveSheet()->setCellValue('B'.$excel_row, $row->san_item_name);
			$object->getActiveSheet()->setCellValue('C'.$excel_row, $row->quantity);
			$object->getActiveSheet()->setCellValue('D'.$excel_row, $row->usable);
			$object->getActiveSheet()->setCellValue('E'.$excel_row, $row->repairable);
			$object->getActiveSheet()->setCellValue('F'.$excel_row, ($row->quantity)-($row->usable+$row->repairable));
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
		$object->getActiveSheet()->setCellValue('A'.($excel_row+2), 'Updated on '.$last_updated_date.' at '.$last_updated_time);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValue('A'.($excel_row+3), 'Printed by '.$whoPrint);

		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);

		// text align = center
		$textAlignStyle = array(
    		'alignment' => array(
        		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    		)
		);

		$object->getActiveSheet()->getStyle("A1")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A2")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A4:F4")->applyFromArray($textAlignStyle);
		$object->getActiveSheet()->getStyle("A4:F4")->applyFromArray($styleArray); // 

		$cell = $cell - 1;
		$object->getActiveSheet()->getStyle('A4:A'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('B4:B'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('C4:C'.$cell)->applyFromArray($styleArray); //
		$object->getActiveSheet()->getStyle('D4:D'.$cell)->applyFromArray($styleArray); // 
		$object->getActiveSheet()->getStyle('E4:E'.$cell)->applyFromArray($styleArray); //
		$object->getActiveSheet()->getStyle('F4:F'.$cell)->applyFromArray($styleArray); //
		$object->getActiveSheet()->getStyle('C4:C'.$cell)->applyFromArray($textAlignStyle); //
		$object->getActiveSheet()->getStyle('D4:D'.$cell)->applyFromArray($textAlignStyle); //
		$object->getActiveSheet()->getStyle('E4:E'.$cell)->applyFromArray($textAlignStyle); //
		$object->getActiveSheet()->getStyle('F4:F'.$cell)->applyFromArray($textAlignStyle); //
		$object->getActiveSheet()->getStyle('A4:A'.$cell)->applyFromArray($textAlignStyle); //
		$object->getActiveSheet()->getColumnDimension('A')->setWidth('5');	
		$object->getActiveSheet()->getStyle('C4')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getColumnDimension('C')->setWidth('10');	
		$object->getActiveSheet()->getStyle('D4')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getColumnDimension('D')->setWidth('12');	
		$object->getActiveSheet()->getStyle('E4')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getColumnDimension('E')->setWidth('16');	
		$object->getActiveSheet()->getStyle('F4')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getColumnDimension('F')->setWidth('15');	
		$object->getActiveSheet()->getStyle("A4:F4")->getFont()->setBold( true );

		$filename = $censusId.'_sanitary_info.xlsx';	
		$this->makeExcelFile($object,$filename);		 
	}
	// used to print school details, when a school logged and to school update window
	// used by admin to print school details
	public function printSchoolClasses(){

		$censusId = $this->uri->segment(3);
		$year = $this->uri->segment(4);

		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('SchoolClass_model');
        $schoolClasses = $this->SchoolClass_model->get_school_classes_by_census_id($censusId,$year); 
		//$result = $this->School_model->view_school_data_by_type($id);

		foreach($schoolClasses as $row){
			$sch_name = $row->sch_name;
			$year = $row->year;
		}
		
		// cell formatting in table column
		$styleArray = array(
	        'font' => array(
	            'bold' => true
	        ),
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
    	// This must be loaded before using setAutoSize() method, otherwise it makes extra spaces in the cell
    	// this code not working on  the live server
		// PHPExcel_Shared_Font::setTrueTypeFontPath('C:/Windows/Fonts/');
		// PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
		
		$object->getActiveSheet()->getStyle('A3:H3')->applyFromArray($styleArray);	
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		$object->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$object->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('F3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		//$object->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
		//$object->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);

		$object->getActiveSheet()->setCellValue('A1',$sch_name.' - සමාන්තර පන්ති තොරතුරු - '.$year);
		$object->getActiveSheet()->setCellValue('A3','#'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValue('B3', 'පන්තිය'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValue('C3', 'අනුමත ළමුන් සංඛ්‍යාව'); // 
		$object->getActiveSheet()->setCellValue('D3', 'සිටින ළමුන් සංඛ්‍යාව'); // 
		$object->getActiveSheet()->setCellValue('E3', 'ඇතුළත් කල ළමුන් සංඛ්‍යාව');
		$object->getActiveSheet()->setCellValue('F3', 'ඇතුලත් කල ප්‍රතිශතය');
		$object->getActiveSheet()->setCellValue('G3', 'පන්ති භාර ගුරුවරයා');
		$object->getActiveSheet()->setCellValue('H3', 'දු.ක. අංකය');
		$latest_upd_dt = 0;
		$excel_row = 4;
		$i=1;
		$totalStdCount = 0;
        $totalExistStdCount = 0;
		$TotalApprovedStdCount = 0;
        $this->load->model('Student_model');
		foreach($schoolClasses as $row){
			$gradeId = $row->grade_id;
			$grade = $row->grade;
			$classId = $row->class_id;
			$class = $row->class;                          
			$censusId = $row->school_id;
			$phone = $row->phone_mobile1;
			$cls_tr = $row->name_with_ini;
			$approved_std_count = $row->approved_std_count; // approved std_count is to be insserted when the class is created or updated
			$TotalApprovedStdCount += $approved_std_count;
			$stdCount = $row->std_count; // std_count is to be insserted when the class is created or updated
			$totalStdCount += $stdCount;
			$updateDt = $row->updated_dt;
			if($latest_upd_dt < $updateDt){
				$latestUpdDt = $updateDt;
			}
			// get actual inserted students in the class
			$existStdCount = $this->Student_model->get_student_count_of_a_class($censusId,$gradeId,$classId,$year); 
			if(!$existStdCount){
				$existStdCount = 0;
			}
            $totalExistStdCount += $existStdCount;
            // count percentage of inserted students out of total students
            if($stdCount != 0){
				$stdPercentage = round(($existStdCount/$stdCount)*100,2);
				$stdPercentage .= ' %';
            }else{
				$stdPercentage = '-';
            }
            // add vaues to cells
			$object->getActiveSheet()->setCellValue('A'.$excel_row, $i);
			$object->getActiveSheet()->setCellValue('B'.$excel_row, $grade.' '.$class); // class
			$object->getActiveSheet()->setCellValue('C'.$excel_row, $approved_std_count);
			$object->getActiveSheet()->setCellValue('D'.$excel_row, $stdCount);
			$object->getActiveSheet()->setCellValue('E'.$excel_row, $existStdCount);
			$object->getActiveSheet()->setCellValue('F'.$excel_row, $stdPercentage);
			$object->getActiveSheet()->setCellValue('G'.$excel_row, $cls_tr); // class teacher
			$object->getActiveSheet()->setCellValue('H'.$excel_row, $phone); // phone no
			$excel_row++;
            $i++; // index no (not student admission no)
		} // foreach
		// add borders to each column separately
		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
		$object->getActiveSheet()->getStyle('A4:A'.($excel_row-1))->applyFromArray($styleArray); 	// index no	
		$object->getActiveSheet()->getStyle('B4:B'.($excel_row-1))->applyFromArray($styleArray);	// class
		$object->getActiveSheet()->getStyle('C4:C'.($excel_row-1))->applyFromArray($styleArray);	// approved student count
		$object->getActiveSheet()->getStyle('D4:C'.($excel_row-1))->applyFromArray($styleArray);	// student count
		$object->getActiveSheet()->getStyle('E4:E'.($excel_row-1))->applyFromArray($styleArray);	// eixisting st count
		$object->getActiveSheet()->getStyle('F4:F'.($excel_row-1))->applyFromArray($styleArray);	// percentage
		$object->getActiveSheet()->getStyle('G4:G'.($excel_row-1))->applyFromArray($styleArray);	// class teacher
		$object->getActiveSheet()->getStyle('H4:H'.($excel_row-1))->applyFromArray($styleArray);	// phone number
		
		// creating total row
		$object->getActiveSheet()->setCellValue('A'.$excel_row, '');
		$object->getActiveSheet()->setCellValue('B'.$excel_row, 'එකතුව'); 
		$object->getActiveSheet()->setCellValue('C'.$excel_row, $TotalApprovedStdCount); 
		$object->getActiveSheet()->setCellValue('D'.$excel_row, $totalStdCount); 
		$object->getActiveSheet()->setCellValue('E'.$excel_row, $totalExistStdCount);
		// // add borders to total row
		$styleArray3 = array(
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
		$object->getActiveSheet()->getStyle('B'.$excel_row.':E'.$excel_row)->applyFromArray($styleArray3);	

		$latestUpdDt = strtotime($latestUpdDt);
		$classLastUpdatedDate = date("j F Y",$latestUpdDt);
		$classLastUpdatedTime = date("h:i A",$latestUpdDt);
		$cell = $excel_row;
		$object->getActiveSheet()->getStyle("A3:H".$cell)->getFont()->setSize(12); // font size set to 13 from A4 to last cell in column H

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+2, 'Updated on '.$classLastUpdatedDate.' at '.$classLastUpdatedTime);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Printed by '.$whoPrint);

		$filename = $censusId.'_'.$year.'_school_classes.xlsx';	
		$this->makeExcelFile($object,$filename);	// makeExcelFile is a custom function	   
	}
	// used to print school details, when a school logged and to school update window
	// used by admin to print school details
	public function printSchoolGrades(){

		$censusId = $this->uri->segment(3);
		$year = $this->uri->segment(4);

		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}
		$this->load->model('SchoolGrade_model');
        $schoolGrades = $this->SchoolGrade_model->get_school_grades_by_census_id($censusId,$year);    		
        //$result = $this->School_model->view_school_data_by_type($id);

		foreach($schoolGrades as $row){
			$sch_name = $row->sch_name;
			$year = $row->year;
		}
		
		// cell formatting in table column
		$styleArray = array(
	        'font' => array(
	            'bold' => true
	        ),
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
    	// This must be loaded before using setAutoSize() method, otherwise it makes extra spaces in the cell
    	// this code not working on  the live server
		// PHPExcel_Shared_Font::setTrueTypeFontPath('C:/Windows/Fonts/');
		// PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
		
		$object->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleArray);	
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		$object->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$object->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('F3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);

		$object->getActiveSheet()->setCellValue('A1',$sch_name.' - ශ්‍රේණි තොරතුරු - '.$year);
		$object->getActiveSheet()->setCellValue('A3','#'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValue('B3', 'ශ්‍රේණිය'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValue('C3', 'සිටින ළමුන් සංඛ්‍යාව'); // 
		$object->getActiveSheet()->setCellValue('D3', 'ඇතුළත් කර ඇති ළමුන් සංඛ්‍යාව');
		$object->getActiveSheet()->setCellValue('E3', 'ප්‍රතිශතය');
		$object->getActiveSheet()->setCellValue('F3', 'ශ්‍රේණි භාර ගුරුවරයා');
		$object->getActiveSheet()->setCellValue('G3', 'දු.ක. අංකය');
		$latest_upd_dt = 0;
		$excel_row = 4;
		$i=1;
		$totalStdCount = 0;
        $totalExistStdCount = 0;
        $this->load->model('Student_model');
		$no = 0;
		$latest_upd_dt = 0;
		$total_std_count = 0;
		$total_exist_std_count = 0;
		foreach ($schoolGrades as $row){  
			$grade_id = $row->grade_id;
			$grade = $row->grade;
			$census_id = $row->school_id;
			$stf_nic = $row->stf_nic;
			$phone = $row->phone_mobile1;
			$grade_head = $row->name_with_ini;
			$update_dt = $row->updated_dt;
			$year = $row->year;
			if($latest_upd_dt < $update_dt){
				$latest_upd_dt = $update_dt;
			}
			$no = $no + 1;  
			$ci = & get_instance();
			$ci->load->model('SchoolGrade_model');
			// get total students that must be in a grade
			$student_count = $ci->SchoolGrade_model->get_student_count_of_a_grade($census_id,$grade_id,$year);
			$total_std_count += $student_count;
			// get total students that actually in a grade now. (sum of students grade wise)
			$exist_std_count = $ci->Student_model->get_student_count_of_a_grade($census_id,$grade_id,$year);
			if(!$exist_std_count){
				$exist_std_count = 0;
			}
			$total_exist_std_count += $exist_std_count;
			if($student_count != 0){
				$std_percentage = round(($exist_std_count/$student_count)*100,2);
				$std_percentage .= ' %';
			}else{
				$std_percentage = '-';
			}
            // add vaues to cells
			$object->getActiveSheet()->setCellValue('A'.$excel_row, $i);
			$object->getActiveSheet()->setCellValue('B'.$excel_row, $grade); // grade name
			$object->getActiveSheet()->setCellValue('C'.$excel_row, $student_count);	
			$object->getActiveSheet()->setCellValue('D'.$excel_row, $exist_std_count);
			$object->getActiveSheet()->setCellValue('E'.$excel_row, $std_percentage);
			$object->getActiveSheet()->setCellValue('F'.$excel_row, $grade_head); // grade head
			$object->getActiveSheet()->setCellValue('G'.$excel_row, $phone); // phone no
			$excel_row++;
            $i++; // index no (not student admission no)
		} // foreach
		// add borders to each column separately
		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
		$object->getActiveSheet()->getStyle('A4:A'.($excel_row-1))->applyFromArray($styleArray); // index no column
		$object->getActiveSheet()->getStyle('B4:B'.($excel_row-1))->applyFromArray($styleArray);	// class
		$object->getActiveSheet()->getStyle('C4:C'.($excel_row-1))->applyFromArray($styleArray);	// student count
		$object->getActiveSheet()->getStyle('D4:D'.($excel_row-1))->applyFromArray($styleArray);	// ixisting st count
		$object->getActiveSheet()->getStyle('D4:E'.($excel_row-1))->applyFromArray($styleArray);	// percentage
		$object->getActiveSheet()->getStyle('D4:F'.($excel_row-1))->applyFromArray($styleArray);	// class teacher
		$object->getActiveSheet()->getStyle('D4:G'.($excel_row-1))->applyFromArray($styleArray);	// phone number
		
		// creating total row
		$object->getActiveSheet()->setCellValue('A'.$excel_row, '');
		$object->getActiveSheet()->setCellValue('B'.$excel_row, 'එකතුව'); 
		$object->getActiveSheet()->setCellValue('C'.$excel_row, $total_std_count); 
		$object->getActiveSheet()->setCellValue('D'.$excel_row, $total_exist_std_count);
		// // add borders to total row
		$styleArray3 = array(
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
		$object->getActiveSheet()->getStyle('B'.$excel_row.':D'.$excel_row)->applyFromArray($styleArray3);	

		$latestUpdDt = strtotime($latest_upd_dt);
		$gradeLastUpdatedDate = date("j F Y",$latestUpdDt);
		$gradeLastUpdatedTime = date("h:i A",$latestUpdDt);
		$cell = $excel_row;
		$object->getActiveSheet()->getStyle("A3:H".$cell)->getFont()->setSize(12); // font size set to 13 from A4 to last cell in column H

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+2, 'Updated on '.$gradeLastUpdatedDate.' at '.$gradeLastUpdatedTime);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Printed by '.$whoPrint);

		$filename = $census_id.'_'.$year.'_school_grades.xlsx';	
		$this->makeExcelFile($object,$filename);	// makeExcelFile is a custom function	   
	}

	// used by school user to print student rank on term test average marks
	public function printPositionOnAvgMarks(){

		$censusId = $this->uri->segment(3);
		$year = $this->uri->segment(4);
		$term = $this->uri->segment(5);
		$gradeId = $this->uri->segment(6);
		$classId = $this->uri->segment(7);

		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('Marks_model');
    	$results = $this->Marks_model->get_position_on_avg_marks($censusId, $year, $term, $gradeId, $classId);

        //$results = $this->School_model->view_school_data_by_type($id);
    	$latest_upd_dt = '';
		$this->load->model('Grade_model');
        $gradeName = $this->Grade_model->get_grade_name($gradeId);
        //print_r($marks); //die();
         foreach ($results as $result) {
            if($latest_upd_dt < $result->last_update){
            	$schName = $result->sch_name;
                $latest_upd_dt = $result->last_update;
            }
        }
        $latest_upd_dt = strtotime($latest_upd_dt);
        $update_dt = date("j F Y",$latest_upd_dt);
        $update_tm = date("h:i A",$latest_upd_dt);
        $dt = 'Updated on '.$update_dt.' at '.$update_tm;

       	if( !empty($classId) ){
			$this->load->model('Class_model');
            $className = $this->Class_model->get_class_name($classId);
        }else{
            $classId = '';
            $className = '';
        }

		// cell formatting in table column
		$styleArray = array(
	        'font' => array(
	            'bold' => true
	        ),
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
    	// This must be loaded before using setAutoSize() method, otherwise it makes extra spaces in the cell
    	// this code not working on  the live server
		// PHPExcel_Shared_Font::setTrueTypeFontPath('C:/Windows/Fonts/');
		// PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
		
		$object->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleArray);	
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		//$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('B3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('F3')->getAlignment()->setWrapText(true);
		//$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
		//$object->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
		//$object->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);

		$object->getActiveSheet()->setCellValue('A1',$schName);
		$object->getActiveSheet()->setCellValue('A2','සිසුන් ලබා ඇති ස්ථාන - '.$gradeName.' '.$className.' - '.$year.' - Term '.$term);
		$object->getActiveSheet()->setCellValue('A3','#'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValue('B3', 'ඇ. වීමේ අංකය');
		$object->getActiveSheet()->setCellValue('C3', 'නම'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValue('D3', 'පන්තිය'); // 
		$object->getActiveSheet()->setCellValue('E3', 'මුළු ලකුණු');
		$object->getActiveSheet()->setCellValue('F3', 'සාමාන්‍ය');
		$object->getActiveSheet()->setCellValue('G3', 'ස්ථානය');

		$latest_upd_dt = 0;
		$excel_row = 4;
		$i=1;
		$no = 0;
		$latest_upd_dt = 0;
	
		foreach ($results as $row){  
			$admNo = $row->adm_no;
			$name = $row->name_with_initials;
			$class = $row->grade.' '.$row->class;
			$total = $row->total;
			$average = $row->average;
			$update_dt = $row->last_update;
			//$year = $row->year;
			if($latest_upd_dt < $update_dt){
				$latest_upd_dt = $update_dt;
			}
			$no = $no + 1;  
			
            // add vaues to cells
			$object->getActiveSheet()->setCellValue('A'.$excel_row, $i);
			$object->getActiveSheet()->setCellValue('B'.$excel_row, $admNo); // grade name
			$object->getActiveSheet()->setCellValue('C'.$excel_row, $name);	
			$object->getActiveSheet()->setCellValue('D'.$excel_row, $class);
			$object->getActiveSheet()->setCellValue('E'.$excel_row, $total);
			$object->getActiveSheet()->setCellValue('F'.$excel_row, $average);
			$object->getActiveSheet()->setCellValue('G'.$excel_row, $i); // grade head
			$excel_row++;
            $i++; // index no (not student admission no)
		} // foreach
		// add borders to each column separately
		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
		$object->getActiveSheet()->getStyle('A4:A'.($excel_row-1))->applyFromArray($styleArray); // index no column
		$object->getActiveSheet()->getStyle('B4:B'.($excel_row-1))->applyFromArray($styleArray);	// class
		$object->getActiveSheet()->getStyle('C4:C'.($excel_row-1))->applyFromArray($styleArray);	// student count
		$object->getActiveSheet()->getStyle('D4:D'.($excel_row-1))->applyFromArray($styleArray);	// ixisting st count
		$object->getActiveSheet()->getStyle('D4:E'.($excel_row-1))->applyFromArray($styleArray);	// percentage
		$object->getActiveSheet()->getStyle('D4:F'.($excel_row-1))->applyFromArray($styleArray);	// class teacher
		$object->getActiveSheet()->getStyle('D4:G'.($excel_row-1))->applyFromArray($styleArray);	// phone number
		
		

		$latestUpdDt = strtotime($latest_upd_dt);
		$lastUpdatedDate = date("j F Y",$latestUpdDt);
		$lastUpdatedTime = date("h:i A",$latestUpdDt);
		$cell = $excel_row;
		$object->getActiveSheet()->getStyle("A3:H".$cell)->getFont()->setSize(12); // font size set to 13 from A4 to last cell in column H

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+2, 'Updated on '.$lastUpdatedDate.' at '.$lastUpdatedTime);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Printed by '.$whoPrint);

		$filename = $censusId.'_'.$year.'_term_'.$term.'_'.$gradeName.$className.'_student_position.xlsx';	
		$this->makeExcelFile($object,$filename);	// makeExcelFile is a custom function	   
	}

	// used by school user to print student rank on subject marks
	public function printPositionOnSubjectMarks(){

		$censusId = $this->uri->segment(3);
		$year = $this->uri->segment(4);
		$term = $this->uri->segment(5);
		$gradeId = $this->uri->segment(6);
		$subjectId = $this->uri->segment(7);
		$classId = $this->uri->segment(8);

		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('Marks_model');
    	$results = $this->Marks_model->get_position_on_subject_marks($censusId, $year, $term, $gradeId, $classId, $subjectId);

    	$latest_upd_dt = '';
		$this->load->model('Grade_model');
        $gradeName = $this->Grade_model->get_grade_name($gradeId);
        //print_r($marks); //die();
         foreach ($results as $result) {
            if($latest_upd_dt < $result->last_update){
            	$schName = $result->sch_name;
                $latest_upd_dt = $result->last_update;
            }
        }
        $latest_upd_dt = strtotime($latest_upd_dt);
        $update_dt = date("j F Y",$latest_upd_dt);
        $update_tm = date("h:i A",$latest_upd_dt);
        $dt = 'Updated on '.$update_dt.' at '.$update_tm;

       	if( !empty($classId) ){
			$this->load->model('Class_model');
            $className = $this->Class_model->get_class_name($classId);
        }else{
            $classId = '';
            $className = '';
        }
		// get subject name
		$this->load->model('Subject_model');
		$subjectName = $this->Subject_model->get_subject_name($subjectId);

		// cell formatting in table column
		$styleArray = array(
	        'font' => array(
	            'bold' => true
	        ),
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
    	// This must be loaded before using setAutoSize() method, otherwise it makes extra spaces in the cell
    	// this code not working on  the live server
		PHPExcel_Shared_Font::setTrueTypeFontPath('C:/Windows/Fonts/');
		PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
		if( $censusId == 'All' ){
			$object->getActiveSheet()->getStyle('A3:H3')->applyFromArray($styleArray);	
		}else{
			$object->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleArray);	
		}
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);	
		$object->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$object->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$object->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		//$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('B3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('F3')->getAlignment()->setWrapText(true);
		//$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
		//$object->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);

		if( $censusId == 'All' ){
			$object->getActiveSheet()->setCellValue('A1','දෙනියාය අධ්‍යාපන කලාපය');
			$object->getActiveSheet()->setCellValue('A2','සිසුන් ලබා ඇති ස්ථාන - '.$gradeName.' '.$className.' - '.$year.' - Term '.$term.' - '.$subjectName.' විෂය');
			$object->getActiveSheet()->setCellValue('A3','#'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValue('B3', 'ඇ. වීමේ අංකය');
			$object->getActiveSheet()->setCellValue('C3', 'නම'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValue('D3', 'පන්තිය'); // 
			$object->getActiveSheet()->setCellValue('E3', 'පාසල');
			$object->getActiveSheet()->setCellValue('F3', 'විෂය');
			$object->getActiveSheet()->setCellValue('G3', 'ලකුණු');
			$object->getActiveSheet()->setCellValue('H3', 'ස්ථානය');
		}else{
			$object->getActiveSheet()->setCellValue('A1',$schName);
			$object->getActiveSheet()->setCellValue('A2','සිසුන් ලබා ඇති ස්ථාන - '.$gradeName.' '.$className.' - '.$year.' - Term '.$term.' - '.$subjectName);
			$object->getActiveSheet()->setCellValue('A3','#'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValue('B3', 'ඇ. වීමේ අංකය');
			$object->getActiveSheet()->setCellValue('C3', 'නම'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValue('D3', 'පන්තිය'); // 
			$object->getActiveSheet()->setCellValue('E3', 'විෂය');
			$object->getActiveSheet()->setCellValue('F3', 'ලකුණු');
			$object->getActiveSheet()->setCellValue('G3', 'ස්ථානය');
		}

		$latest_upd_dt = 0;
		$excel_row = 4;
		$i=1;
		$no = 0;
		$latest_upd_dt = 0;
	
		foreach ($results as $row){  
			$admNo = $row->adm_no;
			$name = $row->name_with_initials;
			$class = $row->grade.' '.$row->class;
			$school = $row->sch_name;
			$subject = $row->subject;
			$marks = $row->marks;
			$update_dt = $row->last_update;
			//$year = $row->year;
			if($latest_upd_dt < $update_dt){
				$latest_upd_dt = $update_dt;
			}
			$no = $no + 1;  
			
            // add vaues to cells
			if( $censusId == 'All' ){
				$object->getActiveSheet()->setCellValue('A'.$excel_row, $i);
				$object->getActiveSheet()->setCellValue('B'.$excel_row, $admNo); // grade name
				$object->getActiveSheet()->setCellValue('C'.$excel_row, $name);	
				$object->getActiveSheet()->setCellValue('D'.$excel_row, $class);
				$object->getActiveSheet()->setCellValue('E'.$excel_row, $school);
				$object->getActiveSheet()->setCellValue('F'.$excel_row, $subject);
				$object->getActiveSheet()->setCellValue('G'.$excel_row, $marks);
				$object->getActiveSheet()->setCellValue('H'.$excel_row, $i); // grade head
			}else{
				$object->getActiveSheet()->setCellValue('A'.$excel_row, $i);
				$object->getActiveSheet()->setCellValue('B'.$excel_row, $admNo); // grade name
				$object->getActiveSheet()->setCellValue('C'.$excel_row, $name);	
				$object->getActiveSheet()->setCellValue('D'.$excel_row, $class);
				$object->getActiveSheet()->setCellValue('E'.$excel_row, $subject);
				$object->getActiveSheet()->setCellValue('F'.$excel_row, $marks);
				$object->getActiveSheet()->setCellValue('G'.$excel_row, $i); // grade head
			}
			$excel_row++;
            $i++; // index no (not student admission no)
		} // foreach
		// add borders to each column separately
		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
		$object->getActiveSheet()->getStyle('A4:A'.($excel_row-1))->applyFromArray($styleArray); // index no column
		$object->getActiveSheet()->getStyle('B4:B'.($excel_row-1))->applyFromArray($styleArray);	// admission no
		$object->getActiveSheet()->getStyle('C4:C'.($excel_row-1))->applyFromArray($styleArray);	// name
		$object->getActiveSheet()->getStyle('D4:D'.($excel_row-1))->applyFromArray($styleArray);	// class
		$object->getActiveSheet()->getStyle('D4:E'.($excel_row-1))->applyFromArray($styleArray);	// subject
		$object->getActiveSheet()->getStyle('D4:F'.($excel_row-1))->applyFromArray($styleArray);	// marks
		$object->getActiveSheet()->getStyle('D4:G'.($excel_row-1))->applyFromArray($styleArray);	// rank
		if( $censusId == 'All' ){
			$object->getActiveSheet()->getStyle('D4:H'.($excel_row-1))->applyFromArray($styleArray);	// rank
		}

		$latestUpdDt = strtotime($latest_upd_dt);
		$lastUpdatedDate = date("j F Y",$latestUpdDt);
		$lastUpdatedTime = date("h:i A",$latestUpdDt);
		$cell = $excel_row;
		$object->getActiveSheet()->getStyle("A3:H".$cell)->getFont()->setSize(12); // font size set to 13 from A4 to last cell in column H

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+2, 'Updated on '.$lastUpdatedDate.' at '.$lastUpdatedTime);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Printed by '.$whoPrint);

		$filename = $censusId.'_'.$year.'_term_'.$term.'_'.$gradeName.$className.'_student_position_on_'.$subjectName.'.xlsx';	
		$this->makeExcelFile($object,$filename);	// makeExcelFile is a custom function	   
	}

	// used by school user to print student list in a specific range of marks
	public function printStudentListInARange(){

		$censusId = $this->uri->segment(3);
		$year = $this->uri->segment(4);
		$term = $this->uri->segment(5);
		$gradeId = $this->uri->segment(6);
		$subjectId = $this->uri->segment(7);
		$from = $this->uri->segment(8);
		$to = $this->uri->segment(9);		
		$classId = $this->uri->segment(10);

		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('Marks_model');
    	$results = $this->Marks_model->get_student_list_in_a_range($censusId, $year, $term, $gradeId, $classId, $subjectId, $from, $to);
		//print_r($results); die();
    	$latest_upd_dt = '';
		$this->load->model('Grade_model');
        $gradeName = $this->Grade_model->get_grade_name($gradeId);
        //print_r($marks); //die();
         foreach ($results as $result) {
            if($latest_upd_dt < $result->last_update){
            	$schName = $result->sch_name;
                $latest_upd_dt = $result->last_update;
            }
        }
        $latest_upd_dt = strtotime($latest_upd_dt);
        $update_dt = date("j F Y",$latest_upd_dt);
        $update_tm = date("h:i A",$latest_upd_dt);
        $dt = 'Updated on '.$update_dt.' at '.$update_tm;

       	if( !empty( $classId ) ){
			$this->load->model('Class_model');
            $className = $this->Class_model->get_class_name($classId);
        }else{
            $classId = '';
            $className = '';
        }
		// get subject name
		$this->load->model('Subject_model');
		$subjectName = $this->Subject_model->get_subject_name($subjectId);

		// cell formatting in table column
		$styleArray = array(
	        'font' => array(
	            'bold' => true
	        ),
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
    	// This must be loaded before using setAutoSize() method, otherwise it makes extra spaces in the cell
    	// this code not working on  the live server
		// PHPExcel_Shared_Font::setTrueTypeFontPath('C:/Windows/Fonts/');
		// PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
		if( $censusId == 'All' ){
			$object->getActiveSheet()->getStyle('A3:H3')->applyFromArray($styleArray);	
		}else{
			$object->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleArray);	
		}
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);	
		$object->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$object->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$object->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		//$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('B3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('F3')->getAlignment()->setWrapText(true);

		//$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
			//$object->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);

		if( $censusId == 'All' ){
			$object->getActiveSheet()->setCellValue('A1','දෙනියාය අධ්‍යාපන කලාපය');
			$object->getActiveSheet()->setCellValue('A2',$gradeName.' '.$className.' - '.$year.' - Term '.$term.' - '.$subjectName.'ට ලකුණු '.$from.'-'.$to.' දක්වා ලකුණු ලබාගත් සිසුන්');
			$object->getActiveSheet()->setCellValue('A3','#'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValue('B3', 'ඇ. වීමේ අංකය');
			$object->getActiveSheet()->setCellValue('C3', 'නම'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValue('D3', 'පන්තිය'); // 
			$object->getActiveSheet()->setCellValue('E3', 'පාසල');
			$object->getActiveSheet()->setCellValue('F3', 'විෂය');
			$object->getActiveSheet()->setCellValue('G3', 'ලකුණු');
			$object->getActiveSheet()->setCellValue('H3', 'ස්ථානය');
		}else{
			$object->getActiveSheet()->setCellValue('A1',$schName);
			$object->getActiveSheet()->setCellValue('A2',$gradeName.' '.$className.' - '.$year.' - Term '.$term.' - '.$subjectName.'ට ලකුණු '.$from.'-'.$to.' දක්වා ලකුණු ලබාගත් සිසුන්');
			$object->getActiveSheet()->setCellValue('A3','#'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValue('B3', 'ඇ. වීමේ අංකය');
			$object->getActiveSheet()->setCellValue('C3', 'නම'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValue('D3', 'පන්තිය'); // 
			$object->getActiveSheet()->setCellValue('E3', 'විෂය');
			$object->getActiveSheet()->setCellValue('F3', 'ලකුණු');
			$object->getActiveSheet()->setCellValue('G3', 'ස්ථානය');
		}

		$latest_upd_dt = 0;
		$excel_row = 4;
		$i=1;
		$no = 0;
		$latest_upd_dt = 0;
		//print_r($results); die();
		foreach ( $results as $row ){  
			$admNo = $row->adm_no;
			echo $name = $row->name_with_initials;
			$class = $row->grade.' '.$row->class;
			$school = $row->sch_name;
			$subject = $row->subject;
			$marks = $row->marks;
			$update_dt = $row->last_update;
			//$year = $row->year;
			if($latest_upd_dt < $update_dt){
				$latest_upd_dt = $update_dt;
			}
			$no = $no + 1;  
			
            // add vaues to cells
			if( $censusId == 'All' ){
				$object->getActiveSheet()->setCellValue('A'.$excel_row, $i);
				$object->getActiveSheet()->setCellValue('B'.$excel_row, $admNo); // 
				$object->getActiveSheet()->setCellValue('C'.$excel_row, $name);	
				$object->getActiveSheet()->setCellValue('D'.$excel_row, $class);
				$object->getActiveSheet()->setCellValue('E'.$excel_row, $school);
				$object->getActiveSheet()->setCellValue('F'.$excel_row, $subject);
				$object->getActiveSheet()->setCellValue('G'.$excel_row, $marks);
				$object->getActiveSheet()->setCellValue('H'.$excel_row, $i); // 
			}else{
				$object->getActiveSheet()->setCellValue('A'.$excel_row, $i);
				$object->getActiveSheet()->setCellValue('B'.$excel_row, $admNo); // 
				$object->getActiveSheet()->setCellValue('C'.$excel_row, $name);	
				$object->getActiveSheet()->setCellValue('D'.$excel_row, $class);
				$object->getActiveSheet()->setCellValue('E'.$excel_row, $subject);
				$object->getActiveSheet()->setCellValue('F'.$excel_row, $marks);
				$object->getActiveSheet()->setCellValue('G'.$excel_row, $i); // 
			}
			$excel_row++;
            $i++; // index no (not student admission no)
		} // foreach
		// add borders to each column separately
		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
		$object->getActiveSheet()->getStyle('A4:A'.($excel_row-1))->applyFromArray($styleArray); // index no column
		$object->getActiveSheet()->getStyle('B4:B'.($excel_row-1))->applyFromArray($styleArray);	// admission no
		$object->getActiveSheet()->getStyle('C4:C'.($excel_row-1))->applyFromArray($styleArray);	// name
		$object->getActiveSheet()->getStyle('D4:D'.($excel_row-1))->applyFromArray($styleArray);	// class
		$object->getActiveSheet()->getStyle('D4:E'.($excel_row-1))->applyFromArray($styleArray);	// subject
		$object->getActiveSheet()->getStyle('D4:F'.($excel_row-1))->applyFromArray($styleArray);	// marks
		$object->getActiveSheet()->getStyle('D4:G'.($excel_row-1))->applyFromArray($styleArray);	// rank
		if( $censusId == 'All' ){
			$object->getActiveSheet()->getStyle('D4:H'.($excel_row-1))->applyFromArray($styleArray);	// rank
		}		

		$latestUpdDt = strtotime($latest_upd_dt);
		$lastUpdatedDate = date("j F Y",$latestUpdDt);
		$lastUpdatedTime = date("h:i A",$latestUpdDt);
		$cell = $excel_row;
		$object->getActiveSheet()->getStyle("A3:H".$cell)->getFont()->setSize(12); // font size set to 13 from A4 to last cell in column H

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+2, 'Updated on '.$lastUpdatedDate.' at '.$lastUpdatedTime);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Printed by '.$whoPrint);

		$filename = $censusId.'_'.$year.'_term_'.$term.'_'.$gradeName.$className.'_student_list_'.$subjectName.'_'.$from.'_'.$to.'.xlsx';	
		$this->makeExcelFile($object,$filename);	// makeExcelFile is a custom function	   
	}

	public function printSelectedSubjectsOfGrade(){

		$censusId = $this->uri->segment(3);
		$gradeId = $this->uri->segment(4);
		$year = $this->uri->segment(5);


		$object = new PHPExcel();
		$object->setActiveSheetIndex(0);
		$table_columns = array("", "");

		$column = 0;

		foreach($table_columns as $field)
		{
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$this->load->model('Grade_model');
        $gradeName = $this->Grade_model->get_grade_name($gradeId);
        $sectionId = $this->Grade_model->get_section_of_a_grade($gradeId);

		$this->load->model('Subject_model');
    	$results = $this->Subject_model->get_selected_subjects_of_a_grade($censusId, $gradeId, $year, $sectionId);
         foreach ($results as $result) {
            $schName = $result->sch_name; 				// needed to view the topic of excel sheet
        }

		// cell formatting in table column
		$styleArray = array(
	        'font' => array(
	            'bold' => true
	        ),
	        'alignment' => array(
	            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        ),
	        'borders' => array(
	            'allborders' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
    	// This must be loaded before using setAutoSize() method, otherwise it makes extra spaces in the cell
    	// this code not working on  the live server
		// PHPExcel_Shared_Font::setTrueTypeFontPath('C:/Windows/Fonts/');
		// PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
		
		$object->getActiveSheet()->getStyle('A3:E3')->applyFromArray($styleArray);	
		$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
		//$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle('A3')->getAlignment()->setWrapText(true);	
		//$object->getActiveSheet()->getStyle('B3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('C3')->getAlignment()->setWrapText(true);	
		$object->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
		$object->getActiveSheet()->getStyle('E3')->getAlignment()->setWrapText(true);
		//$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
		//$object->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
		//$object->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
		$object->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
		$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);

		$object->getActiveSheet()->setCellValue('A1',$schName);
		$object->getActiveSheet()->setCellValue('A2','සියළුම විෂයයන් - '.$gradeName.' - '.$year);
		$object->getActiveSheet()->setCellValue('A3','#'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValue('B3', 'විෂය');
		$object->getActiveSheet()->setCellValue('C3', 'වර්ගය'); // 0 is column1, 3 is row3
		$object->getActiveSheet()->setCellValue('D3', 'පන්තිය'); // 
		$object->getActiveSheet()->setCellValue('E3', 'වර්ෂය');

		$this->load->model('Subject_model');
    	$results = $this->Subject_model->get_selected_subjects_of_a_grade($censusId, $gradeId, $year, $sectionId);

		$latest_upd_dt = 0;
		$excel_row = 4;
		$i=1;
		$no = 0;
		$latest_upd_dt = 0;
	
		foreach ($results as $row){  
			$subject = $row->subject;
			$category = $row->sub_cat_name;
			$grade = $row->grade;
			$year = $row->year;
			$update_dt = $row->last_update;
			//$year = $row->year;
			if($latest_upd_dt < $update_dt){
				$latest_upd_dt = $update_dt;
			}
			$no = $no + 1;  
			
            // add vaues to cells
			$object->getActiveSheet()->setCellValue('A'.$excel_row, $i);
			$object->getActiveSheet()->setCellValue('B'.$excel_row, $subject); // grade name
			$object->getActiveSheet()->setCellValue('C'.$excel_row, $category);	
			$object->getActiveSheet()->setCellValue('D'.$excel_row, $grade);
			$object->getActiveSheet()->setCellValue('E'.$excel_row, $year);
			$excel_row++;
            $i++; // index no (not student admission no)
		} // foreach
		// add borders to each column separately
		$styleArray = '';
		$styleArray = array(
	        'borders' => array(
	            'outline' => array(
	                'style' => PHPExcel_Style_Border::BORDER_THIN
	            )
        	)
    	);
		$object->getActiveSheet()->getStyle('A4:A'.($excel_row-1))->applyFromArray($styleArray); // index no column
		$object->getActiveSheet()->getStyle('B4:B'.($excel_row-1))->applyFromArray($styleArray);	// class
		$object->getActiveSheet()->getStyle('C4:C'.($excel_row-1))->applyFromArray($styleArray);	// student count
		$object->getActiveSheet()->getStyle('D4:D'.($excel_row-1))->applyFromArray($styleArray);	// ixisting st count
		$object->getActiveSheet()->getStyle('D4:E'.($excel_row-1))->applyFromArray($styleArray);	// percentage	
		
		$latestUpdDt = strtotime($latest_upd_dt);
		$lastUpdatedDate = date("j F Y",$latestUpdDt);
		$lastUpdatedTime = date("h:i A",$latestUpdDt);
		$cell = $excel_row;
		$object->getActiveSheet()->getStyle("A3:H".$cell)->getFont()->setSize(12); // font size set to 13 from A4 to last cell in column H

		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+2, 'Updated on '.$lastUpdatedDate.' at '.$lastUpdatedTime);
		$whoPrint = $this->whoPrint(); 
		$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row+3, 'Printed by '.$whoPrint);

		$filename = $censusId.'_'.$gradeName.'_'.$year.'_'.'selected_subjects.xlsx';	
		$this->makeExcelFile($object,$filename);	// makeExcelFile is a custom function	   
	}
	// not used yet
	public function printStaffByNic(){
        if(is_logged_in()){
			$nic = $this->uri->segment(3);
			$object = new PHPExcel();
			$object->setActiveSheetIndex(0);
			$table_columns = array("", "");

			$column = 0;

			foreach($table_columns as $field)
			{
				$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
				$column++;
			}

			$this->load->model('Staff_model');

            $nic = $this->uri->segment(3);
            $condition = 'st.nic_no = "'.$nic.'" ';
            $result = $this->Staff_model->get_stf_by_condition($condition); // get only one person

			$pers_info_upd_dt = 0;
	        foreach ( $result as $row ){ 
				$stf_id = $row->staff_id;
				$name_with_ini = $row->name_with_ini;
				$full_name = $row->full_name;
				$address = $row->stf_address1.' '.$row->stf_address2;
				$school = $row->sch_name;
				$nic_no = $row->nic_no;
				$dob = $row->dob;
				$gender_name = $row->gender_name;
				$civil_status = $row->civil_status_type;
				$ethnic_group = $row->ethnic_group;
				$religion = $row->religion;
				$phone_home = $row->phone_home;
				$mobile1 = $row->phone_mobile1;
				$mobile2 = $row->phone_mobile2;
				$email = $row->email;
				$edu_qual = $row->edu_q_name;
				$prof_qual = $row->prof_q_description;
				//-----------------------------------
				$staff_type = $row->stf_type; // කාර්ය මණ්ඩල වර්ගය - academic/non academic
				$desig_type = $row->desig_type; // තනතුර - ගුරුවරයා / විදුහල්පති 
				$staff_status = $row->stf_status; // තනතුර - ගුරුවරයා / විදුහල්පති 
				$cur_serv_grd = $row->serv_grd_type;
				$serv_grd_effective_dt = $row->serv_grd_effective_dt;
				$stf_status = $row->stf_status; // පත්වීමේ ස්වභාවය 
				$first_app_dt = $row->first_app_dt;  // මුල් පත්වීමේ දිනය 
				$sal_incr_dt = $row->sal_incr_dt; // වැටුප් වර්ධක දිනය 
				$start_dt_this_sch = $row->start_dt_this_sch;
				$cur_serv_status = $row->service_status; // වර්තමාන සේවා තත්ත්වය - ප්‍රසූත නිවාඩු 
				$app_type = $row->app_type;   // පත්විම් වර්ගය - ජාතික ශික්ෂණ විද්‍යා ඩිප්ලෝමා
				$app_subject = $row->app_subj;
				$app_medium = $row->subj_med_type;
				$salary_no = $row->salary_no;
				$staff_no = $row->stf_no;
				$section_name = $row->section_name;
				$section_role_name = $row->sec_role_name;
				$update_dt = $row->last_update;

				if( $pers_info_upd_dt < $update_dt ){
					$pers_info_upd_dt = $update_dt;
				}
	        }
			$last_update_dt = strtotime($pers_info_upd_dt);
			$pers_info_last_updated_date = date("j F Y",$last_update_dt);
            $pers_info_last_updated_time = date("h:i A",$last_update_dt);

			$address = $address1.', '.$address2;
			$object->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);		
			$object->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
			$object->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
			$object->getActiveSheet()->getStyle("A1")->getFont()->setSize(15);
			$object->getActiveSheet()->mergeCells('A1:B1');
			$object->getActiveSheet()->mergeCells('A2:B2');
			$object->getActiveSheet()->getStyle("A3:B17")->getFont()->setSize(13);
			$object->getActiveSheet()->setCellValue('A1', $school);
			$object->getActiveSheet()->setCellValue('A3', 'නම'); // 0 is column1, 3 is row3
			$object->getActiveSheet()->setCellValue('B3', $name_with_ini); 		// column 2, row 3
			$object->getActiveSheet()->setCellValue('A4', 'සම්පූර්ණ නම');
			$object->getActiveSheet()->setCellValue('B4', $full_name);
			$object->getActiveSheet()->setCellValue('A5', 'ලිපිනය');
			$object->getActiveSheet()->setCellValue('B5', $address);
			$object->getActiveSheet()->setCellValue('A6', 'පාසල');
			$object->getActiveSheet()->setCellValue('B6', $contact_no);
			$object->getActiveSheet()->setCellValue('A7', 'ජා.හැ.අ.');
			$object->getActiveSheet()->setCellValue('B7', $nic_no);
			$object->getActiveSheet()->setCellValue('A8', 'උපන් දිනය');
			$object->getActiveSheet()->setCellValue('B8', $dob);
			$object->getActiveSheet()->setCellValue('A9', 'ස්ත්‍රී/පුරුෂ');
			$object->getActiveSheet()->setCellValue('B9', $gender_name);
			$object->getActiveSheet()->setCellValue('A10', 'විවාහක/අවිවාහක බව');
			$object->getActiveSheet()->setCellValue('B10', $civil_status);
			$object->getActiveSheet()->setCellValue('A11', 'ජාතිය');
			$object->getActiveSheet()->setCellValue('B11', $ethnic_group);
			$object->getActiveSheet()->setCellValue('A12', 'ආගම');
			$object->getActiveSheet()->setCellValue('B12', $religion);
			$object->getActiveSheet()->setCellValue('A13', 'නිවසේ දු.ක.');
			$object->getActiveSheet()->setCellValue('B13', $phone_home);
			$object->getActiveSheet()->setCellValue('A14', 'ජංගම දු.ක. 1 ');
			$object->getActiveSheet()->setCellValue('B14', $religion1);			
			$object->getActiveSheet()->setCellValue('A15', 'ජංගම දු.ක. 2');
			$object->getActiveSheet()->setCellValue('B15', $religion2);
			$object->getActiveSheet()->setCellValue('A16', 'විද්‍යුත් තැපැල් ලිපිනය');
			$object->getActiveSheet()->setCellValue('B16', $email);			
			$object->getActiveSheet()->setCellValue('A17', 'ඉහළම අධ්‍යාපන සුදුසුකම්');
			$object->getActiveSheet()->setCellValue('B17', $edu_qual);
			$object->getActiveSheet()->setCellValue('A18', 'ඉහළම වෘත්තීය සුදුසුකම්');
			$object->getActiveSheet()->setCellValue('B18', $prof_qual);

			$object->getActiveSheet()->setCellValue('A18', 'Updated on '.$pers_info_last_updated_date.' at '.$pers_info_last_updated_time);

			// add borders to each column separately
			$styleArray = '';
			$styleArray = array(
		        'borders' => array(
		            'outline' => array(
		                'style' => PHPExcel_Style_Border::BORDER_THIN
		            )
	        	)
	    	);

			// text align = center
			$textAlignStyle = array(
        		'alignment' => array(
            		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        		)
    		);

    		$object->getActiveSheet()->getStyle("A1:B1")->applyFromArray($textAlignStyle);
			//$object->getActiveSheet()->getStyle('A3:B3')->applyFromArray($styleArray); // 
			$object->getActiveSheet()->getStyle('A3:A17')->applyFromArray($styleArray); // 
			$object->getActiveSheet()->getStyle('B3:B17')->applyFromArray($styleArray); // 

			$filename = $nic_no.'_staff_info.xlsx';	
			$this->makeExcelFile($object,$filename);		
			
		}else{
            redirect('GeneralInfo/loginPage');
        }    
	}


	
}

















































	