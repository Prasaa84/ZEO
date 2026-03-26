<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

include_once APPPATH.'/third_party/mpdf/mpdf.php';

class M_pdf {

    public $param;
    public $pdf;

    public function __construct(){
        $this->param = "'c', 'A4-P'";
        $this->pdf = new mPDF($this->param);
        //$this->pdf->allow_charset_conversion = true;
		$this->pdf->autoScriptToLang = true;
		$this->pdf->autoLangToFont   = true;
		//$this->pdf->shrink_tables_to_fit = 1;

    }
}