<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<style type="text/css">
/* .datepicker{font-size: 15px;} */
</style>
<style type="text/css">
th,
td {
    white-space: nowrap;
}

div.dataTables_wrapper {
    height: 200px;
    width: 1200px;
    margin: 0 auto;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
<?php
foreach ($this->session as $user_data) {
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if ($role_id == '2') {
        //$class = $user_data['grade'].' '.$user_data['class'];
        $school_name = $user_data['school_name'];
        $census_id = $user_data['census_id'];
    } else {
        $census_id = '';
    }
}
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url(); ?>user">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Staff/staffReportsView">Staff Reports</a></li>
            <li class="breadcrumb-item active">Reports</li>
        </ol>
        <div class="row" id="search-bar-row">
            <div class="col-lg-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-2 col-sm-2">
                        <form class="navbar-form" role="search" action="<?php echo base_url(); ?>Staff/viewStaffByNic"
                            method="POST">
                            <div class="form-group">
                                <div class="input-group addon">
                                    <input class="form-control  form-control-sm" placeholder="NIC No..." name="nic_txt"
                                        id="nic_txt" type="text" value="<?php echo set_value('nic_txt'); ?>"
                                        title="Type NIC no of teacher" data-toggle="tooltip">
                                    <input type="hidden" class="census_id_hidden" name="census_id_hidden"
                                        value="<?php echo $census_id; ?>">
                                    <button type="submit" class="btn btn-default input-group-addon"
                                        name="btn_view_staff_by_nic" value="View"><i class="fa fa-search"></i></button>
                                </div> <!-- /input-group -->
                            </div>
                        </form> <!-- /form -->
                    </div> <!-- /.col-lg-2 col-sm-2 -->
                    <div class="col-lg-2 col-sm-2">
                        <form class="navbar-form" role="search"
                            action="<?php echo base_url(); ?>Staff/viewStaffTaskWise" method="POST">
                            <div class="form-group">
                                <div class="input-group addon">
                                    <select class="form-control form-control-sm" id="task_id_select"
                                        name="task_id_select" title="Select the task" data-toggle="tooltip">
                                        <option value="" selected>By Task</option>
                                        <?php foreach ($this->all_tasks_involved as $row) { ?>
                                        <!-- from PhysicalResource controller constructor method -->
                                        <option value="<?php echo $row->involved_task_id; ?>">
                                            <?php echo $row->inv_task; ?></option>
                                        <?php } ?>
                                        <option value="All">All</option>
                                    </select>
                                    <button type="submit" class="btn btn-default input-group-addon"
                                        name="btn_view_by_task" value="Task"><i class="fa fa-search"></i></button>
                                </div> <!-- /input-group -->
                            </div>
                        </form> <!-- /form -->
                    </div> <!-- /.col-lg-2 col-sm-2 -->

                    <!-- Filter by staff update monthly -->
                    <div class="col-lg-8 col-sm-8">
                        <form class="navbar-form row" role="search"
                            action="<?php echo base_url(); ?>Staff/ViewStaffUpdateStatus" method="POST">
                            <div class="form-group col-lg-2 col-sm-2">
                                <div class="input-group addon">
                                    <input class="form-control form-control-sm school_txt"
                                        placeholder="School Name or Census ID..." name="school_txt" id="school_txt"
                                        type="text" value="<?php echo set_value('censusid_txt'); ?>"
                                        title="Type Census ID or School Name" data-toggle="tooltip">
                                    <input type="hidden" class="census_id_hidden" id="census_id_hidden"
                                        name="census_id_hidden" value="">
                                </div> <!-- /input-group -->
                            </div>
                            <div class="form-group col-lg-2 col-sm-2">
                                <select class="form-control mb-2 mr-sm-2 form-control-sm" id="year_select"
                                    name="year_select" title="Select the year">
                                    <option value="" selected>---Year---</option>
                                    <?php
                                    $year = date('Y');
                                    $selected_year = set_value('year_select');
                                    for ($year; $year > 2019; $year--) {
                                        if ($year == $selected_year) {
                                            echo '<option value="' . $year . '" >' . $year . '</option>';
                                        } else {
                                            echo '<option value="' . $year . '" >' . $year . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-2 col-sm-2">
                                <select class="form-control form-control-sm" id="month_select" name="month_select"
                                    title="Select the service grade" data-toggle="tooltip">
                                    <option value="" selected>---Month---</option>
                                    <option value="1">ජනවාරි</option>
                                    <option value="2">පෙබරවාරි</option>
                                    <option value="3">මාරතු </option>
                                    <option value="4">අප්‍රේල්</option>
                                    <option value="5">මැයි</option>
                                    <option value="6">ජුනි</option>
                                    <option value="7">ජූලි</option>
                                    <option value="8">අගෝස්තු</option>
                                    <option value="9">සැප්තැම්බර්</option>
                                    <option value="10">ඔක්තෝබර්</option>
                                    <option value="11">නොවැම්බර්</option>
                                    <option value="12">දෙසැම්බර්</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-sm-3">
                                <button type="submit" class="btn btn-primary btn-sm" id="stf_update_search_btn"
                                    name="stf_update_search_btn" title="Select all fields and click this button"
                                    value="View" data-toggle="tooltip"><i class="fa fa-search"></i> View</button>
                                <input class="btn btn-danger btn-sm" type="reset" value="Reset">
                            </div>

                        </form> <!-- /form -->
                    </div> <!-- /.col-lg-2 col-sm-2 -->
                    <!-- /. Filter by staff update monthly -->

                    <?php if ($role_id == '2') {  ?>
                    <div class="col-lg-8 col-sm-8">
                        <form class="navbar-form" role="search"
                            action="<?php echo base_url(); ?>Staff/viewAcStaffOfAGrade" method="POST">
                            <div class="row">
                                <div class="form-group col-lg-2 col-sm-2">
                                    <select class="form-control form-control-sm" id="year_select" name="year_select"
                                        title="Please select">
                                        <option value="" selected>---වර්ෂය---</option>
                                        <?php
                                            //$year = 2018;
                                            $year = date('Y');
                                            for ($year; $year > 2019; $year--) {
                                                echo '<option value="' . $year . '" >' . $year . '</option>';
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2 col-sm-2">
                                    <select class="form-control form-control-sm" id="grade_select" name="grade_select"
                                        data-toggle="tooltip" title="Select a Grade">
                                        <option value="" selected>---ශ්‍රේණිය---</option>
                                        <?php   //if($role_id=='2'){
                                            $selected_grade = set_value('grade_select');
                                            foreach ($allGrades as $grade) {
                                                if ($grade->grade_id == $selected_grade) {
                                            ?>
                                        <option value="<?php echo $grade->grade_id; ?>" selected>
                                            <?php echo $grade->grade; ?></option>
                                        <?php       } else { ?>
                                        <option value="<?php echo $grade->grade_id; ?>"><?php echo $grade->grade; ?>
                                        </option>
                                        <?php       }
                                            }
                                            // }//else{ 
                                            ?>

                                    </select>
                                </div>
                                <div class="form-group col-lg-2 col-sm-2">
                                    <select class="form-control form-control-sm mb-1" id="class_select"
                                        name="class_select">
                                        <!-- values are loaded by ajax -->
                                        <option value="" selected>---පන්තිය---</option>
                                    </select>
                                    <span class="text-danger"
                                        id="class_error"><?php echo form_error('class_select'); ?></span>
                                </div>
                                <div class="form-group col-lg-4 col-sm-4">
                                    <input type="hidden" id="census_id_hidden" name="census_id_hidden"
                                        value="<?php echo $census_id; ?>">
                                    <button type="submit" class="btn btn-primary btn-sm" id="stf_search_btn"
                                        name="stf_search_btn" title="Select atleast one and click this button"
                                        value="View" data-toggle="tooltip"><i class="fa fa-search"></i> View</button>
                                    <input class="btn btn-danger btn-sm" type="reset" value="Reset"
                                        id="reset_btn_find_staff_grade_wise_form">
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#helpModal"><i class="fa fa-question"></i></button>
                                </div>
                            </div> <!-- /.row -->
                        </form> <!-- /form -->
                    </div>
                    <?php }  ?>
                </div> <!-- /.row -->
            </div> <!-- /.col-lg-12 col-sm-12 -->
        </div> <!-- / #search-bar-row -->
        <?php if ($role_id != '2') {  ?>
        <div class="row" id="search-bar-row">
            <!-- search bar is available for admin only -->
            <div class="col-lg-12 col-sm-12">
                <form class="navbar-form" role="search" action="<?php echo base_url(); ?>Staff/StaffReports"
                    method="POST">
                    <div class="row">
                        <div class="form-group col-lg-2 col-sm-2">
                            <div class="input-group addon">
                                <input class="form-control form-control-sm school_txt"
                                    placeholder="School Name or Census ID..." name="school_txt" id="school_txt"
                                    type="text" value="<?php echo set_value('censusid_txt'); ?>"
                                    title="Type Census ID or School Name" data-toggle="tooltip">
                                <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="">
                            </div> <!-- /input-group -->
                        </div>
                        <div class="form-group col-lg-2 col-sm-2">
                            <select class="form-control form-control-sm" id="service_status_select"
                                name="service_status_select" title="Select the Service Status" data-toggle="tooltip">
                                <option value="" selected>සේවා තත්ත්වය...</option>
                                <?php foreach ($this->all_service_status as $row) { ?>
                                <!-- from PhysicalResource controller constructor method -->
                                <option value="<?php echo $row->service_status_id; ?>">
                                    <?php echo $row->service_status; ?></option>
                                <?php   } ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-1 col-sm-1">
                            <select class="form-control form-control-sm" id="service_grade_select"
                                name="service_grade_select" title="Select the service grade" data-toggle="tooltip">
                                <option value="" selected>ශ්‍රේණිය...</option>
                                <?php foreach ($this->all_service_grades as $row) { ?>
                                <!-- from PhysicalResource controller constructor method -->
                                <option value="<?php echo $row->serv_grd_id; ?>"><?php echo $row->serv_grd_type; ?>
                                </option>
                                <?php   } ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-sm-2">
                            <select class="form-control form-control-sm" id="app_subject_select"
                                name="app_subject_select" title="Select the appointment subject" data-toggle="tooltip">
                                <option value="" selected>පත්වීම් විෂය...</option>
                                <?php foreach ($this->all_appoint_subjects as $row) { ?>
                                <!-- from PhysicalResource controller constructor method -->
                                <option value="<?php echo $row->app_subj_id; ?>"><?php echo $row->app_subj; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-sm-2">
                            <select class="form-control form-control-sm" id="app_type_select" name="app_type_select"
                                title="Select the appointment type" data-toggle="tooltip">
                                <option value="" selected>පත්වීම් වර්ගය...</option>
                                <?php foreach ($this->all_appoint_types as $row) { ?>
                                <!-- from PhysicalResource controller constructor method -->
                                <option value="<?php echo $row->app_type_id; ?>"><?php echo $row->app_type; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-1 col-sm-1">
                            <select class="form-control form-control-sm" id="stf_status_select" name="stf_status_select"
                                title="Select the staff status" data-toggle="tooltip">
                                <option value="" selected> ස්වභාවය...</option>
                                <?php foreach ($this->all_staff_status as $row) { ?>
                                <!-- from PhysicalResource controller constructor method -->
                                <option value="<?php echo $row->stf_status_id; ?>"><?php echo $row->stf_status; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-sm-2">
                            <button type="submit" class="btn btn-primary btn-sm" id="stf_search_btn"
                                name="stf_search_btn" title="Select atleast one and click this button" value="View"
                                data-toggle="tooltip"><i class="fa fa-search"></i> View</button>
                            <input class="btn btn-danger btn-sm" type="reset" value="Reset">
                        </div>
                    </div> <!-- /row -->
                </form> <!-- /form -->
            </div> <!-- /.col-lg-12 col-sm-12 -->
        </div> <!-- / #search-bar-row -->
        <?php }  ?>
        <?php
        if (!empty($this->session->flashdata('msg'))) {
            $message = $this->session->flashdata('msg');  ?>
        <div class="<?php echo $message['class']; ?>"><?php echo $message['text']; ?></div>
        <?php } ?>
        <!-- ------------------------------------------------------------------------------------------------------------------- -->
        <?php if (!empty($stf_task_info)) { ?>
        <div class="row" id="">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-table"></i> නිරතවන කාර්යය අනුව අධ්‍යයන කාර්යමණ්ඩල තොරතුරු
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 my-auto">
                                <h5 align="center">
                                    <?php if ($userrole == 'School User') {
                                            echo $school_name;
                                        } else {
                                        }
                                        ?></h5>
                                <h6 align="center">නිරතවන කාර්යය අනුව අධ්‍යයන කාර්යමණ්ඩල තොරතුරු </h6>
                                <div class="">
                                    <table id="dataTable1" class="table table-striped table-hover " cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>නම</th>
                                                <th>පාසල</th>
                                                <th>හැඳුනුම්පත් අංකය</th>
                                                <th>පත්වීම් විෂය</th>
                                                <th>වැඩිම කාලයක් නිරතවන කාර්යය</th>
                                                <th>අංශය </th>
                                                <th>විෂය</th>
                                                <th>දෙවනුව වැඩිම කාලයක් නිරතවන කාර්යය</th>
                                                <th>අංශය </th>
                                                <th>විෂය</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 1;
                                                $latest_upd_dt = 0;
                                                $lastStf_id = '';
                                                foreach ($stf_task_info as $row) {
                                                    $stf_id = $row->stf_id;
                                                    //$census_id = $row->census_id;
                                                    $name_with_ini = $row->name_with_ini;
                                                    $school = $row->sch_name;
                                                    $nic_no = $row->nic_no;
                                                    $app_subject = $row->app_subj;
                                                    $involved_task_type_id = $row->involved_task_type_id;
                                                    $involved_task_type = $row->involved_task_type;
                                                    $involved_task_id = $row->involved_task_id;
                                                    $inv_task = $row->inv_task;
                                                    $section_id = $row->section_id;
                                                    $section_name = $row->section_name;
                                                    $subject_id = $row->subject_id;
                                                    $subject = $row->subject;
                                                    $app_subj = $row->app_subj;
                                                    $update_dt = $row->last_update;
                                                    if ($latest_upd_dt < $update_dt) {
                                                        $latest_upd_dt = $update_dt;
                                                    }
                                                ?>
                                            <?php if ($stf_id != $lastStf_id) {
                                                    ?>
                                            <tr>
                                                <td><?php echo $no; ?></td>
                                                <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                                                <td style="vertical-align:middle;"><?php echo $school; ?></td>
                                                <td style="vertical-align:middle"><?php echo $nic_no; ?></td>
                                                <td style="vertical-align:middle"><?php echo $app_subj; ?></td>
                                                <?php if ($involved_task_type_id == 1) { ?>
                                                <td style="vertical-align:middle"><?php echo $inv_task; ?></td>
                                                <td style="vertical-align:middle"><?php echo $section_name; ?></td>
                                                <td style="vertical-align:middle"><?php echo $subject; ?></td>
                                                <?php     } else { ?>
                                                <td style="vertical-align:middle"></td>
                                                <td style="vertical-align:middle"></td>
                                                <td style="vertical-align:middle"></td>
                                                <td style="vertical-align:middle"><?php echo $inv_task; ?></td>
                                                <td style="vertical-align:middle"><?php echo $section_name; ?></td>
                                                <td style="vertical-align:middle"><?php echo $subject; ?></td>
                                                <?php
                                                            }
                                                            $no = $no + 1;
                                                        } else { ?>
                                                <td style="vertical-align:middle"><?php echo $inv_task; ?></td>
                                                <td style="vertical-align:middle"><?php echo $section_name; ?></td>
                                                <td style="vertical-align:middle"><?php echo $subject; ?></td>
                                            </tr>
                                            <?php   } // else
                                                        $lastStf_id = $stf_id;
                                                    } // end foreach 
                                                ?>
                                        </tbody>
                                    </table>
                                </div> <!-- /table-responsive -->
                            </div>
                        </div> <!-- /col-lg-12 -->
                    </div> <!-- /card-body -->
                    <div class="card-footer small text-muted">
                        <?php
                            if (!empty($acStaffDetails)) {
                                $latest_upd_dt = strtotime($latest_upd_dt);
                                $building_update_dt = date("j F Y", $latest_upd_dt);
                                $building_update_tm = date("h:i A", $latest_upd_dt);
                                echo 'Updated on ' . $building_update_dt . ' at ' . $building_update_tm;
                            }
                            ?>
                    </div>
                </div> <!-- /card -->
            </div> <!-- /col-lg-12 -->
        </div> <!-- /row # -->
        <?php } ?>
        <!-- ------------------------------------------------------------------------------------------------------------------- -->
        <!-- All staff info -->
        <?php if (!empty($stf_all_info)) { ?>
        <div class="row" id="">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-table"></i> අධ්‍යයන කාර්යමණ්ඩල තොරතුරු
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 my-auto">
                                <h5 align="center">
                                    <?php if ($userrole == 'School User') {
                                            echo $school_name;
                                        } else {
                                        }
                                        ?></h5>
                                <div class="">
                                    <table id="staffTable" class="stripe row-border order-column" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th> නම </th>
                                                <th> සම්පූර්ණ නම </th>
                                                <th> ලිපිනය </th>
                                                <th> පාසල </th>
                                                <th>හැඳුනුම්පත් අංකය</th>
                                                <th>උපන් දිනය</th>
                                                <th>ස්ත්‍රී/පුරුෂ</th>
                                                <th>විවාහක/අවිවාහක බව</th>
                                                <th>ජාතිය</th>
                                                <th>ආගම</th>
                                                <th>දු.ක. (නිවස)</th>
                                                <th> දු.ක. (ජංගම) 1</th>
                                                <th> දු.ක. (ජංගම) 2</th>
                                                <th>Email</th>
                                                <th>තනතුරු </th>
                                                <th>අධ්‍යාපන සුදුසුකම්</th>
                                                <th>වෘත්තීය සුදුසුකම්</th>
                                                <th>වත්මන් සේවයේ ශ්‍රේණිය</th>
                                                <th>වත්මන් සේවයට පත්වූ දිනය </th>
                                                <th>පත්වීම් වර්ගය</th>
                                                <th>පත්වීමේ ස්වභාවය</th>
                                                <th>පත්වීම් විෂය</th>
                                                <th>පත්වීම් මාධ්‍යය</th>
                                                <th>පළමු පත්වීම් දිනය</th>
                                                <th>වැටුප් වර්ධක දිනය</th>
                                                <th>මෙම පාසලට පත්වූ දිනය</th>
                                                <th>වර්ථමාන සේවා තත්වය</th>
                                                <th>වැටුප් අංකය </th>
                                                <th>යාවත්කාලීන වූ දිනය </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 0;
                                                $latest_upd_dt = 0;
                                                foreach ($stf_all_info as $row) {
                                                    $stf_id = $row->staff_id;
                                                    $census_id = $row->census_id;
                                                    $name_with_ini = $row->name_with_ini;
                                                    $full_name = $row->full_name;
                                                    $address = $row->stf_address1 . ' ' . $row->stf_address2;
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
                                                    $email = $row->stf_email;
                                                    $desig_type = $row->desig_type;
                                                    $edu_qual = $row->edu_q_name;
                                                    $prof_qual = $row->prof_q_description;
                                                    $cur_serv_grd = $row->serv_grd_type;
                                                    $serv_grd_effective_dt = $row->serv_grd_effective_dt;
                                                    $app_type = $row->app_type;
                                                    $stf_status = $row->stf_status; // පත්වීමේ ස්වභාවය 
                                                    $first_app_dt = $row->first_app_dt;
                                                    $sal_incr_dt = $row->sal_incr_dt;
                                                    $start_dt_this_sch = $row->start_dt_this_sch;
                                                    $cur_serv_status = $row->service_status;
                                                    $app_type = $row->app_type;
                                                    $app_subject = $row->app_subj;
                                                    $app_medium = $row->subj_med_type;
                                                    $salary_no = $row->salary_no;
                                                    $update_dt = $row->last_update;
                                                    if ($latest_upd_dt < $update_dt) {
                                                        $latest_upd_dt = $update_dt;
                                                    }
                                                    $no = $no + 1;  ?>
                                            <tr id="<?php echo 'tbrow' . $stf_id; ?>">
                                                <td><?php echo $no; ?></td>
                                                <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                                                <td style="vertical-align:middle;"><?php echo $full_name; ?></td>
                                                <td style="vertical-align:middle;"><?php echo $address; ?></td>
                                                <td style="vertical-align:middle"><?php echo $school; ?></td>
                                                <td style="vertical-align:middle"><?php echo $nic_no; ?></td>
                                                <td style="vertical-align:middle"><?php echo $dob; ?></td>
                                                <td style="vertical-align:middle"><?php echo $gender_name; ?></td>
                                                <td style="vertical-align:middle"><?php echo $civil_status; ?></td>
                                                <td style="vertical-align:middle"><?php echo $ethnic_group; ?></td>
                                                <td style="vertical-align:middle"><?php echo $religion; ?></td>
                                                <td style="vertical-align:middle"><?php echo $phone_home; ?></td>
                                                <td style="vertical-align:middle"><?php echo $mobile1; ?></td>
                                                <td style="vertical-align:middle"><?php echo $mobile2; ?></td>
                                                <td style="vertical-align:middle"><?php echo $email; ?></td>
                                                <td style="vertical-align:middle"><?php echo $desig_type; ?></td>
                                                <td style="vertical-align:middle"><?php echo $edu_qual; ?></td>
                                                <td style="vertical-align:middle"><?php echo $prof_qual; ?></td>
                                                <td style="vertical-align:middle"><?php echo $cur_serv_grd; ?></td>
                                                <td style="vertical-align:middle"><?php echo $serv_grd_effective_dt; ?>
                                                </td>
                                                <td style="vertical-align:middle"><?php echo $app_type; ?></td>
                                                <td style="vertical-align:middle"><?php echo $stf_status; ?></td>
                                                <!-- පත්වීමේ ස්වභාවය  -->
                                                <td style="vertical-align:middle"><?php echo $app_subject; ?></td>
                                                <td style="vertical-align:middle"><?php echo $app_medium; ?></td>
                                                <td style="vertical-align:middle"><?php echo $first_app_dt; ?></td>
                                                <td style="vertical-align:middle"><?php echo $sal_incr_dt; ?></td>
                                                <td style="vertical-align:middle"><?php echo $start_dt_this_sch; ?></td>
                                                <td style="vertical-align:middle"><?php echo $cur_serv_status; ?></td>
                                                <td style="vertical-align:middle"><?php echo $salary_no; ?></td>
                                                <td style="vertical-align:middle"><?php echo $update_dt; ?></td>
                                            </tr>
                                            <?php } // end foreach 
                                                ?>
                                        </tbody>
                                    </table>
                                </div> <!-- /table-responsive -->
                            </div>
                        </div> <!-- /col-lg-12 -->
                    </div> <!-- /card-body -->
                    <div class="card-footer small text-muted">
                        <?php
                            if (!empty($acStaffDetails)) {
                                $latest_upd_dt = strtotime($latest_upd_dt);
                                $building_update_dt = date("j F Y", $latest_upd_dt);
                                $building_update_tm = date("h:i A", $latest_upd_dt);
                                echo 'Updated on ' . $building_update_dt . ' at ' . $building_update_tm;
                            }
                            ?>
                    </div>
                </div> <!-- /card -->
            </div> <!-- /col-lg-12 -->
        </div> <!-- /row # -->
        <?php } ?>
        <!-- end of staff info report -->
        <?php if (!empty($staff_teaching_classes_info)) { ?>
        <div class="row" id="">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-table"></i> අධ්‍යයන කාර්යමණ්ඩල තොරතුරු
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 my-auto">
                                <h5 align="center">
                                    <?php if ($userrole == 'School User') {
                                            echo $school_name;
                                        } else {
                                        }
                                        ?></h5>
                                <div class="">
                                    <table id="staffTeachingClasses" class="stripe row-border order-column"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th> නම </th>
                                                <th> ලිපිනය </th>
                                                <th> පාසල </th>
                                                <th> වර්ෂය </th>
                                                <th> පන්තිය </th>
                                                <th>උපන් දිනය</th>
                                                <th>ස්ත්‍රී/පුරුෂ</th>
                                                <th>ජාතිය</th>
                                                <th>ආගම</th>
                                                <th>දු.ක. (නිවස)</th>
                                                <th> දු.ක. (ජංගම) 1</th>
                                                <th> දු.ක. (ජංගම) 2</th>
                                                <th>Email</th>
                                                <th>තනතුරු </th>
                                                <th>අධ්‍යාපන සුදුසුකම්</th>
                                                <th>වෘත්තීය සුදුසුකම්</th>
                                                <th>වත්මන් සේවයේ ශ්‍රේණිය</th>
                                                <th>වත්මන් සේවයට පත්වූ දිනය </th>
                                                <th>පත්වීම් වර්ගය</th>
                                                <th>පත්වීමේ ස්වභාවය</th>
                                                <th>පත්වීම් විෂය</th>
                                                <th>පත්වීම් මාධ්‍යය</th>
                                                <th>මෙම පාසලට පත්වූ දිනය</th>
                                                <th>වර්ථමාන සේවා තත්වය</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 0;
                                                $latest_upd_dt = 0;
                                                foreach ($staff_teaching_classes_info as $row) {
                                                    $stf_id = $row->staff_id;
                                                    $census_id = $row->census_id;
                                                    $name_with_ini = $row->name_with_ini;
                                                    $address = $row->stf_address1 . ' ' . $row->stf_address2;
                                                    $school = $row->sch_name;
                                                    $year = $row->year;
                                                    $grade = $row->grade;
                                                    $class = $row->class;
                                                    $dob = $row->dob;
                                                    $gender_name = $row->gender_name;
                                                    $civil_status = $row->civil_status_type;
                                                    $ethnic_group = $row->ethnic_group;
                                                    $religion = $row->religion;
                                                    $phone_home = $row->phone_home;
                                                    $mobile1 = $row->phone_mobile1;
                                                    $mobile2 = $row->phone_mobile2;
                                                    $email = $row->stf_email;
                                                    $desig_type = $row->desig_type;
                                                    $edu_qual = $row->edu_q_name;
                                                    $prof_qual = $row->prof_q_description;
                                                    $cur_serv_grd = $row->serv_grd_type;
                                                    $serv_grd_effective_dt = $row->serv_grd_effective_dt;
                                                    $app_type = $row->app_type;
                                                    $stf_status = $row->stf_status; // පත්වීමේ ස්වභාවය 
                                                    $first_app_dt = $row->first_app_dt;
                                                    $sal_incr_dt = $row->sal_incr_dt;
                                                    $start_dt_this_sch = $row->start_dt_this_sch;
                                                    $cur_serv_status = $row->service_status;
                                                    $app_type = $row->app_type;
                                                    $app_subject = $row->app_subj;
                                                    $app_medium = $row->subj_med_type;
                                                    $salary_no = $row->salary_no;
                                                    $update_dt = $row->last_update;
                                                    if ($latest_upd_dt < $update_dt) {
                                                        $latest_upd_dt = $update_dt;
                                                    }
                                                    $no = $no + 1;  ?>
                                            <tr id="<?php echo 'tbrow' . $stf_id; ?>">
                                                <td><?php echo $no; ?></td>
                                                <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                                                <td style="vertical-align:middle;"><?php echo $address; ?></td>
                                                <td style="vertical-align:middle;"><?php echo $school; ?></td>
                                                <td style="vertical-align:middle;"><?php echo $year; ?></td>
                                                <td style="vertical-align:middle"><?php echo $grade . ' ' . $class; ?>
                                                </td>
                                                <td style="vertical-align:middle"><?php echo $dob; ?></td>
                                                <td style="vertical-align:middle"><?php echo $gender_name; ?></td>
                                                <td style="vertical-align:middle"><?php echo $ethnic_group; ?></td>
                                                <td style="vertical-align:middle"><?php echo $religion; ?></td>
                                                <td style="vertical-align:middle"><?php echo $phone_home; ?></td>
                                                <td style="vertical-align:middle"><?php echo $mobile1; ?></td>
                                                <td style="vertical-align:middle"><?php echo $mobile2; ?></td>
                                                <td style="vertical-align:middle"><?php echo $email; ?></td>
                                                <td style="vertical-align:middle"><?php echo $desig_type; ?></td>
                                                <td style="vertical-align:middle"><?php echo $edu_qual; ?></td>
                                                <td style="vertical-align:middle"><?php echo $prof_qual; ?></td>
                                                <td style="vertical-align:middle"><?php echo $cur_serv_grd; ?></td>
                                                <td style="vertical-align:middle"><?php echo $serv_grd_effective_dt; ?>
                                                </td>
                                                <td style="vertical-align:middle"><?php echo $app_type; ?></td>
                                                <td style="vertical-align:middle"><?php echo $stf_status; ?></td>
                                                <!-- පත්වීමේ ස්වභාවය  -->
                                                <td style="vertical-align:middle"><?php echo $app_subject; ?></td>
                                                <td style="vertical-align:middle"><?php echo $app_medium; ?></td>
                                                <td style="vertical-align:middle"><?php echo $start_dt_this_sch; ?></td>
                                                <td style="vertical-align:middle"><?php echo $cur_serv_status; ?></td>
                                            </tr>
                                            <?php } // end foreach 
                                                ?>
                                        </tbody>
                                    </table>
                                </div> <!-- /table-responsive -->
                            </div>
                        </div> <!-- /col-lg-12 -->
                    </div> <!-- /card-body -->
                    <div class="card-footer small text-muted">
                        <?php
                            if (!empty($staff_teaching_classes_info)) {
                                $latest_upd_dt = strtotime($latest_upd_dt);
                                $building_update_dt = date("j F Y", $latest_upd_dt);
                                $building_update_tm = date("h:i A", $latest_upd_dt);
                                echo 'Updated on ' . $building_update_dt . ' at ' . $building_update_tm;
                            }
                            ?>
                    </div>
                </div> <!-- /card -->
            </div> <!-- /col-lg-12 -->
        </div> <!-- /row # -->
        <?php } ?>
        <!-- end of staff teaching classes report -->
    </div> <!-- /container-fluid -->
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> ගුරු තොරතූරු සෙවීම
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 my-auto">
                            1. එක් ගුරුවරයකුගේ වාර්තාවක් ලබා ගැනිමට පළමු කොටුව තුළ NIC No ඇතුළත් කර එයත් සමග ඇති කුඩා
                            Button මත ක්ලික් කරන්න. <br>
                            2. නිරතවන කාර්යය මත ගුරුවරුන්ගේ වාර්තාවක් ලබා ගැනීමට දෙවැනි කොටුව තුළ ඇති By Task මත ක්ලික්
                            කර ඒ අසලම ඇති කුඩා Button මත ක්ලික් කරන්න. <br>
                            3. යම් ශ්‍රේණියක හෝ පන්තියක ඉගැන්වීම් සිදු කරනු ලබන ගුරුවරුන්ගේ තොරතුරු ලබා ගැනීමට අධ්‍යයන
                            වර්ෂය, ශ්‍රේණිය සහ පන්තිය තෝරා View Button මත click කරන්න. <br>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#reset_btn_find_staff_grade_wise_form').click(function() {
            $('select#year_select').val('------');
            $('select#grade_select').html('');
            $('select#class_select').html('');
        });
        // වර්ෂය තෝරනවිට ශ්‍රේණිය ලෝඩ් කිරීමට යොදා ගැනේ. 
        // used by school user
        $(document).on('change', '#year_select', function() {
            var year = $(this).val();
            var census_id = $('#census_id_hidden').val();
            if (!year) {
                $('select#grade_select').html('');
                alert('Please select the year')
            } else {
                $.ajax({
                    url: "<?php echo base_url(); ?>SchoolGrades/viewGradesSchoolWise",
                    method: "POST",
                    data: {
                        census_id: census_id,
                        year: year
                    },
                    dataType: "json",
                    success: function(classes) {
                        if (!classes) {
                            swal('Grades not found!!!!')
                            $('select#grade_select').html('');
                            $('select[name="grade_select"]').append(
                                '<option value="">---No Grades---</option>').attr(
                                "selected", "true");
                            $('select#class_select').html('');
                            $('select[name="class_select"]').append(
                                '<option value="">---No Classes---</option>').attr(
                                "selected", "true");
                            //$('select#select_grade_of_stu').html('Not Found');
                        } else {
                            $('select#grade_select').html('');
                            $('select[name="grade_select"]').append(
                                '<option value="">---Select Grade---</option>').attr(
                                "selected", "true");
                            $('select#class_select').html('');
                            $('select[name="class_select"]').append(
                                '<option value="">------</option>').attr("selected",
                                "true");
                            $.each(classes, function(key, value) {
                                $('select[name="grade_select"]').append(
                                    '<option value="' + value.grade_id + '">' +
                                    value.grade + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                    }
                })
            }
        });

        // ශ්‍රේණිය තෝරනවිට පන්තිය ලෝඩ් කිරීමට යොදා ගැනේ. 
        $(document).on('change', '#grade_select', function() {
            var grade_id = $(this).val();
            var year = $('#year_select').val();
            //role_id-1=admin, role_id-2=school_user
            <?php if ($role_id == 1) { ?>
            var census_id = $('#school_select').val();
            <?php } ?>
            <?php if ($role_id == 2) { ?>
            var census_id = $('#census_id_hidden').val();
            <?php } ?>
            if (!census_id) {
                swal('Please select a school');
            } else if (!year) {
                swal('Please select the year');
                $('select#class_select').html('');
            } else if (!grade_id) {
                swal('Please select the grade');
                $('select#class_select').html('');
            } else {
                $.ajax({
                    url: "<?php echo base_url(); ?>SchoolClasses/viewClassesGradeWise",
                    method: "POST",
                    data: {
                        grade_id: grade_id,
                        census_id: census_id,
                        year: year
                    },
                    dataType: "json",
                    success: function(classes) {
                        if (!classes) {
                            swal('Classes not found!!!!')
                            $('select#class_select').html('');
                            $('select[name="class_select"]').append(
                                '<option value="">---No Classes---</option>').attr(
                                "selected", "true");
                        } else {
                            $('select#class_select').html('');
                            $('select[name="class_select"]').append(
                                '<option value="">---Select Class---</option>').attr(
                                "selected", "true");
                            $.each(classes, function(key, value) {
                                $('select[name="class_select"]').append(
                                    '<option value="' + value.class_id + '">' +
                                    value.class + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                    }
                })
            }
        });
        $('#staffTable111').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    text: 'Print'
                },
                {
                    extend: 'pdf',
                    messageBottom: null
                },
            ],
            select: true
        });
        // auto complete when type school name
        $(".school_txt").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "<?= base_url() ?>School/viewSchoolList",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            //appendTo: "#school_txt",
            select: function(event, ui) {
                // Set selection
                $('.school_txt').val(ui.item.label); // display the selected text
                $('.census_id_hidden').val(ui.item.value); // save selected id to input
                //alert(ui.item.value);
                return false;
            }
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        // date picker
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            yearRange: '1955:',
        })

        $('#staffTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                text: 'Save',
                exportOptions: {
                    modifier: {
                        //page: 'current'
                        page: 'all'
                    }
                }
            }],
            //paging: false,      
            //scrollY: "600px",
            fixedColumns: {
                leftColumns: 2
            },
            scrollX: true
        });

        $('#staffTeachingClasses').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                text: 'Save',
                exportOptions: {
                    modifier: {
                        //page: 'current'
                        page: 'all'
                    }
                }
            }],
            //paging: false,      
            //scrollY: "600px",
            fixedColumns: {
                leftColumns: 2
            },
            scrollX: true
        });

        $('#dataTable1').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excel',
                text: 'Save',
                exportOptions: {
                    modifier: {
                        page: 'All'
                    }
                }
            }],
            fixedColumns: {
                leftColumns: 2
            },
            scrollX: true
        });

    });
    </script>