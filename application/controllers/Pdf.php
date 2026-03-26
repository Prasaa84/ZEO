<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdf extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function staffInfo()
    {

        $nic = $this->uri->segment(3);
        $condition = 'st.nic_no = "' . $nic . '" ';

        $this->load->model('Staff_model');
        $result = $this->Staff_model->get_stf_by_condition($condition); // get only one person
        $data['stf_info'] = $result;

        $filename = $nic . "_staff_info.pdf";

        $html = $this->load->view('staff/staff_info_report', $data, true);

        $this->load->library('M_pdf');
        $style = '<style type="text/css">
                    th, td { white-space: nowrap; font-size:12px;}
                    .tbl_heading{ font-weight: bold; }
                    @page { margin-top:15px; margin-bottom:20px;}
                    #staff_photo{margin:0 auto;}
                    #signature{float:right; font-size:15px;}
                    #who_print(font-size:5px;)
                 </style>';
        $stylesheet1 = file_get_contents(base_url() . 'assets/vendor/bootstrap/css/bootstrap.min.css');
        $stylesheet2 = file_get_contents(base_url() . 'assets/vendor/font-awesome/css/font-awesome.min.css');
        $this->m_pdf->pdf->WriteHTML($stylesheet1, 1); // CSS Script goes here.
        $this->m_pdf->pdf->WriteHTML($stylesheet2, 1); // CSS Script goes here.
        $this->m_pdf->pdf->WriteHTML($style, 1); // CSS Script goes here.

        $this->m_pdf->pdf->WriteHTML($html);

        //download it D save F.
        $this->m_pdf->pdf->Output($filename, "D");
        exit;
    }

    public function studentInfo()
    {

        $censusId = $this->uri->segment(3);
        $admNo = $this->uri->segment(4);

        $this->load->model('Student_model');
        $result = $this->Student_model->get_stu_info_by_index($admNo, $censusId); // get only one person
        $std_co_cur_info = $this->Student_model->get_std_ex_cur_info($admNo, $censusId);
        $std_ex_cur_info = $this->Student_model->get_std_game_info($admNo, $censusId);
        $std_win_info = $this->Student_model->get_std_winnings($admNo, $censusId);

        $data['std_info'] = $result;
        $data['std_co_cur_info'] = $std_co_cur_info;
        $data['std_ex_cur_info'] = $std_ex_cur_info;
        $data['std_win_info'] = $std_win_info;

        $filename = $censusId . '_' . $admNo . "_student_info.pdf";

        $html = $this->load->view('student/student_info_by_index_for_pdf_report', $data, true);

        $this->load->library('M_pdf');
        $style = '<style type="text/css">
                    th, td { white-space: nowrap; font-size:12px;}
                    .tbl_heading{ font-weight: bold; font-size:12px;}
                    @page { margin-top:15px; margin-bottom:20px;}
                    #staff_photo{margin:0 auto;}
                    #co_curricular_tbl{min:height:500px;}
                    #signature{float:right; font-size:15px;}
                    #who_print(font-size:5px;)
                 </style>';
        $stylesheet1 = file_get_contents(base_url() . 'assets/vendor/bootstrap/css/bootstrap.min.css');
        $stylesheet2 = file_get_contents(base_url() . 'assets/vendor/font-awesome/css/font-awesome.min.css');
        $this->m_pdf->pdf->WriteHTML($stylesheet1, 1); // CSS Script goes here.
        $this->m_pdf->pdf->WriteHTML($stylesheet2, 1); // CSS Script goes here.
        $this->m_pdf->pdf->WriteHTML($style, 1); // CSS Script goes here.

        $this->m_pdf->pdf->WriteHTML($html);

        //download it D save F.
        $this->m_pdf->pdf->Output($filename, "D");
        exit;
    }
}
