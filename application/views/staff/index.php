<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<style type="text/css">
.card a {
    text-decoration: none;
    color: #ffffff;
}

#addNewStaffInfo li a {
    display: inline-block;
    height: 40px;
    width: 150px;
    margin: 0 2px 0 2px;
    padding: 2px;
    text-align: center;
}

#addNewStaffInfo li a:hover {
    text-decoration: none;
    color: blue;
    background-color: #eeeeee;
}

.navPaneDown {
    margin-bottom: 5px;
}

.active {
    border: 1px 1px 0px 1px;
    border-color: black;
}

.imgPrw {
    max-width: 90px;
    max-height: 120px;
}

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
        }]
    });

    $('#dataTable2').DataTable({
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
        // fixedColumns: {
        //   //leftColumns:2
        // },
        //scrollX: true   
    });

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
            <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>staff">Staff</a></li>
        </ol>
        <?php
        if (!empty($this->session->flashdata('msg'))) {
            $message = $this->session->flashdata('msg');  ?>
        <div class="<?php echo $message['class']; ?>"><?php echo $message['text']; ?></div>
        <?php   } ?>
        <?php
        if (!empty($this->session->flashdata('uploadSuccess'))) {
            $message = $this->session->flashdata('uploadSuccess');  ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
        <?php } ?>
        <?php
        if (!empty($this->session->flashdata('uploadError'))) {
            $message = $this->session->flashdata('uploadError');
            foreach ($message as $item => $value) {
                echo '<div class="alert alert-danger" >' . $item . ' : ' . $value . '</div>';
            }
        } ?>
        <!-- Icon Cards-->
        <div class="row">
            <?php
            $total = 0;
            $updated = 0;
            $not_updated = 0;
            if (!empty($staff_count_schoolwise)) {
                foreach ($staff_count_schoolwise as $row) {
                    $total = $total + $row->stf_count;
                    $updated = $updated + $row->stf_count_this_month;
                    $not_updated = $total - $updated;
                }
            }
            ?>
            <div class="col-xl-3 col-sm-3 mb-2">
                <div class="card text-white bg-primary o-hidden h-80">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-users"></i>
                        </div>
                        <div class="mr-5">Total Teachers</div>
                        <h2><?php echo $total; ?> </h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-3 mb-2">
                <div class="card text-white bg-success o-hidden h-80">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-users"></i>
                        </div>
                        <div class="mr-5"> Updated to <?php echo $month = date('F Y'); ?> </div>
                        <h2><?php echo $updated; ?> </h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-3 mb-2" title="Click to See" data-toggle="tooltip">
                <div class="card text-white bg-danger o-hidden h-80">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-users"></i>
                        </div>
                        <div class="mr-1">Not Updated to <?php echo $month = date('F Y'); ?></div>
                        <h2><a href="<?php echo base_url(); ?>Staff/notUpdated"> <?php echo $not_updated; ?> </a>
                        </h2>
                    </div>
                </div>
            </div>
        </div> <!-- /row-->
        <div class="row" id="staff_details_by_nic">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-table"></i> අධ්‍යයන කාර්යමණ්ඩල තොරතුරු
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 my-auto">
                                <h5 align="center">
                                    <?php
                                    if ($userrole == 'School User') {
                                        //echo $school_name; 
                                    } else {
                                    }
                                    ?>
                                </h5>
                                <?php if (!empty($acStaffDetails)) { ?>
                                <div style="overflow-x:auto;" class="">
                                    <table id="staffTable" class="stripe row-border order-column ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th> නම </th>
                                                <th> පාසල </th>
                                                <th>හැඳුනුම්පත් අංකය</th>
                                                <th>ස්ත්‍රී/පුරුෂ</th>
                                                <th> දු.ක.</th>
                                                <th>තනතුර</th>
                                                <th>අධ්‍යාපන </th>
                                                <th>වෘත්තීය සුදුසුකම්</th>
                                                <?php if (($userrole == 'System Administrator') || ($userrole == 'School User')) { ?>
                                                <th></th>
                                                <th></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 0;
                                                $latest_upd_dt = 0;
                                                foreach ($acStaffDetails as $row) {
                                                    $stf_id = $row->staff_id;
                                                    $census_id = $row->census_id;
                                                    $name_with_ini = $row->name_with_ini;
                                                    $school = $row->sch_name;
                                                    $nic_no = $row->nic_no;
                                                    $gender_name = $row->gender_name;
                                                    $phone_mobile1 = $row->phone_mobile1;
                                                    $desig_type = $row->desig_type;
                                                    $edu_qual = $row->edu_q_name;
                                                    $prof_qual = $row->prof_q_description;
                                                    $update_dt = $row->last_update;
                                                    if ($latest_upd_dt < $update_dt) {
                                                        $latest_upd_dt = $update_dt;
                                                    }
                                                    $no = $no + 1;  ?>
                                            <tr id="<?php echo 'tbrow' . $stf_id; ?>">
                                                <th><?php echo $no; ?></th>
                                                <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                                                <td style="vertical-align:middle"><?php echo $school; ?></td>
                                                <td style="vertical-align:middle"><?php echo $nic_no; ?></td>
                                                <td style="vertical-align:middle"><?php echo $gender_name; ?></td>
                                                <td style="vertical-align:middle"><?php echo $phone_mobile1; ?></td>
                                                <td style="vertical-align:middle"><?php echo $desig_type; ?></td>
                                                <td style="vertical-align:middle"><?php echo $edu_qual; ?></td>
                                                <td style="vertical-align:middle"><?php echo $prof_qual; ?></td>
                                                <?php if (($role_id == '1') || ($role_id == '2')) { ?>
                                                <td id="td_btn" style="vertical-align:middle">
                                                    <a href="<?php echo base_url(); ?>Staff/editStaffView/<?php echo $stf_id; ?>"
                                                        type="button" id="btn_edit_building_info"
                                                        name="btn_edit_building_info" type="button"
                                                        class="btn btn-info btn-sm btn_edit_phy_res" value="edit"
                                                        title="Update this details" data-toggle="tooltip" data-hidden=""
                                                        onclick="get(<?php //echo $b_info_id; 
                                                                                                                                                                                                                                                                                                                                                                            ?>)"><i
                                                            class="fa fa-pencil"></i></a>
                                                </td>
                                                <td id="td_btn" style="vertical-align:middle">
                                                    <!-- when delete, census id must be sent, since it is used to go back after delete -->
                                                    <a type="button" name="btn_delete_phy_res_status_details"
                                                        class="btn btn-danger btn-sm btn_delete_staff" value="Cancel"
                                                        data-toggle="tooltip" title="Delete this student"
                                                        data-id="<?php echo $stf_id; ?>"><i
                                                            class="fa fa-trash-o"></i></a>
                                                </td>
                                                <?php } ?>
                                            </tr>
                                            <?php } // end foreach 
                                                ?>
                                        </tbody>
                                    </table>
                                </div> <!-- /table-responsive -->
                                <?php } else { // if empty($acStaffDetails)
                                    if (($userrole == 'School User') && empty($acStaffDetails)) {
                                        echo '<h4 align="center">No Records!!!</h4>';
                                    } else if (($userrole == 'Administrator') && empty($acStaffDetails)) {
                                        echo '<h4 align="center">Add or Search Records!!!</h4>';
                                    } else {
                                        echo '<h4 align="center">Search Details</h4>';
                                    }
                                } ?>
                            </div>
                        </div> <!-- /col-lg-12 -->
                        <button id="btn_add_new_building_info" name="btn_add_new_building_info" type="button"
                            class="btn btn-primary btn-sm" value="Add" data-toggle="modal"
                            data-target="#addNewStaffInfo"><i class="fa fa-plus"></i> Add New</button>
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

        <!-- /following bootstrap model used to insert school academic staff -->
        <div class="modal fade" id="addNewStaffInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Insert Staff
                            Details</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 my-auto">
                                <div role="tabpanel">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#personalDetailsTab"
                                                aria-controls="personalDetailsTab" role="tab" data-toggle="tab">
                                                පෞද්ගලික තොරතුරු </a></li>
                                        <li role="presentation"><a href="#serviceDetailsTab"
                                                aria-controls="serviceDetailsTab" role="tab" data-toggle="tab"> සේවා
                                                තොරතුරු </a></li>
                                        <li role="presentation"><a href="#schDetailsTab" aria-controls="schDetailsTab"
                                                role="tab" data-toggle="tab"> සේවා ස්ථානය </a></li>
                                        <li role="presentation"><a href="#taskTab" aria-controls="taskTab" role="tab"
                                                data-toggle="tab"> ඉටුකරන කාර්යය</a></li>
                                        <li role="presentation"><a href="#currentServiceDetailsTab"
                                                aria-controls="currentServiceDetailsTab" role="tab" data-toggle="tab">
                                                සේවා තත්ත්වය </a></li>
                                        <li role="presentation"><a href="#photoTab" aria-controls="photoTab" role="tab"
                                                data-toggle="tab"> පින්තූරය </a></li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content mt-3">
                                        <div role="tabpanel" class="tab-pane active" id="personalDetailsTab">
                                            <?php
                                            $attributes = array("class" => "form-horizontal", "id" => "insert_staff_info_form", "name" => "insert_staff_info_form", "accept-charset" => "UTF-8");
                                            echo form_open_multipart("Staff/addStaff", $attributes); ?>
                                            <fieldset>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="Index Number"> Title <font color="#ff0000">*
                                                                </font> </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <select class="form-control" id="title_select"
                                                                name="title_select">
                                                                <option value="" selected>---ක්ලික් කරන්න---</option>
                                                                <option value="Ven">Ven.</option>
                                                                <option value="Mr">Mr.</option>
                                                                <option value="Miss">Miss.</option>
                                                                <option value="Mrs">Mrs.</option>
                                                            </select>
                                                            <span class="text-danger"
                                                                id=""><?php echo form_error('title_select'); ?></span>
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="Name with initials" class="control-label">
                                                                මුලකුරු සමඟ නම </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <input class="form-control" id="name_with_ini_txt"
                                                                name="name_with_ini_txt" placeholder="---ටයිප් කරන්න---"
                                                                type="text" value="" />
                                                            <span class="text-danger"
                                                                id=""><?php echo form_error('name_with_ini_txt'); ?></span>
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="full name" class="control-label"> සම්පූර්ණ නම
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <input class="form-control" id="full_name_txt"
                                                                name="full_name_txt" placeholder="---ටයිප් කරන්න---"
                                                                type="text" value="" />
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="nick name" class="control-label"> භාවිත නාමය
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <input class="form-control" id="nick_name_txt"
                                                                name="nick_name_txt" placeholder="---ටයිප් කරන්න---"
                                                                type="text" value="" />
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="Address 1" class="control-label"> ලිපින පේළිය 1
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <input class="form-control" id="address1_txt"
                                                                name="address1_txt" placeholder="---ටයිප් කරන්න---"
                                                                type="text" value="" size="60" />
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="Address 2" class="control-label"> ලිපින පේළිය 2
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <input class="form-control" id="address2_txt"
                                                                name="address2_txt" placeholder="---ටයිප් කරන්න---"
                                                                type="text" value="" />
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="NIC" class="control-label"> ජා.හැ.අංකය </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <input class="form-control" id="nic_txt" name="nic_txt"
                                                                placeholder="---ටයිප් කරන්න---" type="text" value=""
                                                                size="60" />
                                                            <span class="text-danger"
                                                                id=""><?php echo form_error('nic_txt'); ?></span>
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="dob" class="control-label"> උපන් දිනය </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <input class="form-control datepicker" id="dob_txt"
                                                                name="dob_txt" placeholder="---ක්ලික් කරන්න ---"
                                                                type="text" value="" size="60" />
                                                            <span class="text-danger"
                                                                id=""><?php echo form_error('dob_txt'); ?></span>
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="new category" class="control-label"> ආගම
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <select class="form-control" id="religion_select"
                                                                name="religion_select">
                                                                <option value="" selected>---ක්ලික් කරන්න---</option>
                                                                <?php foreach ($this->all_religion as $row) { ?>
                                                                <!-- from Building controller constructor method -->
                                                                <option value="<?php echo $row->religion_id; ?>">
                                                                    <?php echo $row->religion; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="new category" class="control-label"> ජාතිය
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <select class="form-control" id="ethnicity_select"
                                                                name="ethnicity_select">
                                                                <option value="" selected>---ක්ලික් කරන්න---</option>
                                                                <?php foreach ($this->all_ethnic_groups as $row) { ?>
                                                                <!-- from Staff controller constructor method -->
                                                                <option value="<?php echo $row->ethnic_group_id; ?>">
                                                                    <?php echo $row->ethnic_group; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="wide" class="control-label"> ස්ත්‍රී/පුරුෂ භාවය
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <select class="form-control" id="gender_select"
                                                                name="gender_select">
                                                                <option value="" selected>---ක්ලික් කරන්න---</option>
                                                                <option value="2"> ස්ත්‍රී </option>
                                                                <option value="1"> පුරුෂ </option>
                                                            </select>
                                                            <span class="text-danger"
                                                                id=""><?php echo form_error('gender_select'); ?></span>
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="new category" class="control-label">
                                                                විවාහක/අවිවාහක බව </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <select class="form-control" id="civil_status_select"
                                                                name="civil_status_select">
                                                                <option value="" selected>---ක්ලික් කරන්න---</option>
                                                                <?php foreach ($this->all_civil_status as $row) { ?>
                                                                <!-- from Staff controller constructor method -->
                                                                <option value="<?php echo $row->civil_status_id; ?>">
                                                                    <?php echo $row->civil_status_type; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <span class="text-danger"
                                                                id=""><?php echo form_error('civil_status_select'); ?></span>
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="Mobile 1" class="control-label"> ජංගම දු.ක. 1
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <input class="form-control" id="tel_txt" name="tel1_txt"
                                                                placeholder="---ටයිප් කරන්න---" type="text" value="" />
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="Mobile 2" class="control-label"> ජංගම දු.ක. 2
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <input class="form-control" id="tel2_txt" name="tel2_txt"
                                                                placeholder="---ටයිප් කරන්න---" type="text" value="" />
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="Mobile 2" class="control-label"> දු.ක. අංකය -
                                                                නිවස </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <input class="form-control" id="tel_home_txt"
                                                                name="tel_home_txt" placeholder="---ටයිප් කරන්න---"
                                                                type="text" value="" />
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="email" class="control-label"> විද්‍යුත් තැපෑල
                                                            </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <input class="form-control" id="email_txt" name="email_txt"
                                                                placeholder="---ටයිප් කරන්න---" type="text" value="" />
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group" id="vehicle_no_1">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="educational qualification"
                                                                class="control-label"> ඉහළම අධ්‍යාපන සුදුසුකම් </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <select class="form-control" id="high_edu_select"
                                                                name="high_edu_select">
                                                                <option value="" selected>---ක්ලික් කරන්න---</option>
                                                                <?php foreach ($this->all_edu_qual as $row) { ?>
                                                                <!-- from Staff controller constructor method -->
                                                                <option value="<?php echo $row->edu_q_id; ?>">
                                                                    <?php echo $row->edu_q_name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                                <div class="form-group" id="vehicle_no_1">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-sm-3">
                                                            <label for="Professional qualification"
                                                                class="control-label"> ඉහළම වෘත්තීය සුදුසුකම් </label>
                                                        </div>
                                                        <div class="col-lg-9 col-sm-9">
                                                            <select class="form-control" id="prof_edu_select"
                                                                name="prof_edu_select">
                                                                <option value="" selected>---ක්ලික් කරන්නe---</option>
                                                                <?php foreach ($this->all_prof_qual as $row) { ?>
                                                                <!-- from Staff controller constructor method -->
                                                                <option value="<?php echo $row->prof_q_id; ?>">
                                                                    <?php echo $row->prof_q_description; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div> <!-- /row -->
                                                </div> <!-- /form group -->
                                        </div> <!-- /privateDetailsTab -->
                                        <!-- -------------serviceDetailsTab begins------------------------------------------------------------------------- -->
                                        <div role="tabpanel" class="tab-pane" id="serviceDetailsTab">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="staff type" class="control-label"> කාර්ය මණ්ඩල වර්ගය
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="stf_type_select"
                                                            name="stf_type_select">
                                                            <option value="1" selected> අධ්‍යයන </option>
                                                            <?php foreach ($this->all_stf_types as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->stf_type_id; ?>">
                                                                <?php echo $row->stf_type; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span
                                                            class="text-danger"><?php echo form_error('stf_type_select'); ?></span>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="first appointment date" class="control-label">
                                                            වත්මන් සේවයේ මුල් පත්වීම් දිනය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input class="form-control datepicker" id="f_app_dt_txt"
                                                            name="f_app_dt_txt" placeholder="---ක්ලික් කරන්න---"
                                                            type="text" value="" />
                                                        <span
                                                            class="text-danger"><?php echo form_error('f_app_dt_txt'); ?></span>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="first appointment date" class="control-label"> මෙම
                                                            වර්ෂයේ වැටුප් වර්ධක දිනය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input class="form-control datepicker" id="sal_incr_dt_txt"
                                                            name="sal_incr_dt_txt" placeholder="---ක්ලික් කරන්න---"
                                                            type="text" value="" />
                                                        <span
                                                            class="text-danger"><?php echo form_error('sal_incr_dt_txt'); ?></span>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Name with ini"> පත්වීම් වර්ගය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="app_type_select"
                                                            name="app_type_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_appoint_types as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->app_type_id; ?>">
                                                                <?php echo $row->app_type; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span
                                                            class="text-danger"><?php echo form_error('app_type_select'); ?></span>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Name with ini"> පත්වීම් විෂය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="app_sub_select"
                                                            name="app_sub_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_appoint_subjects as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->app_subj_id; ?>">
                                                                <?php echo $row->app_subj; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span
                                                            class="text-danger"><?php echo form_error('app_sub_select'); ?></span>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Name with ini"> පත්වීම් මාධ්‍යය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="app_medium_select"
                                                            name="app_medium_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_subj_medium as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->subj_med_id; ?>">
                                                                <?php echo $row->subj_med_type; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span
                                                            class="text-danger"><?php echo form_error('app_medium_select'); ?></span>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Designation" class="control-label"> පත්වීමේ ස්වභාවය
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="stf_status_select"
                                                            name="stf_status_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_staff_status as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->stf_status_id; ?>">
                                                                <?php echo $row->stf_status; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Name with ini"> වත්මන් සේවා ශ්‍රේණිය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="service_grade_select"
                                                            name="service_grade_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_service_grades as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->serv_grd_id; ?>">
                                                                <?php echo $row->serv_grd_type; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span
                                                            class="text-danger"><?php echo form_error('service_grade_select'); ?></span>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="dob" class="control-label"> වත්මන් ශ්‍රේණියට පත්වූ
                                                            දිනය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input class="form-control datepicker" id="service_grd_dt_txt"
                                                            name="service_grd_dt_txt" placeholder="---ක්ලික් කරන්න---"
                                                            type="text" value="" size="60" data-toggle="tooltip"
                                                            title="Date of your current service grade" />
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                        </div> <!-- /serviceDetailsTab -->
                                        <!-- -------------schDetailsTab begins------------------------------------------------------------------------- -->
                                        <div role="tabpanel" class="tab-pane" id="schDetailsTab">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="staff number"> පාසල </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="school_select"
                                                            name="school_select">
                                                            <?php if ($role_id == '2') {
                                                                $census_id = $user_data['census_id']; ?>
                                                            <!-- check for school user login -->
                                                            <option value="<?php echo $census_id; ?>" selected>
                                                                <?php echo $school_name; ?></option>
                                                            <?php   } else { ?>
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_schools as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->census_id; ?>">
                                                                <?php echo $row->sch_name; ?></option>
                                                            <?php }
                                                            } ?>
                                                        </select>
                                                        <span
                                                            class="text-danger"><?php echo form_error('school_select'); ?></span>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="staff number"> පාසලේ ගුරු අංකය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input class="form-control" id="stf_no_txt" name="stf_no_txt"
                                                            placeholder="ටයිප් කරන්න" type="text" value="" />
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="staff number"> වැටුප් අංකය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input class="form-control" id="salary_no_txt"
                                                            name="salary_no_txt" placeholder="ටයිප් කරන්න" type="text"
                                                            value="" />
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="This School first date" class="control-label"> මෙම
                                                            පාසලට පත්වූ දිනය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input class="form-control datepicker" id="this_sch_dt_txt"
                                                            name="this_sch_dt_txt" placeholder="---ක්ලික් කරන්න---"
                                                            type="text" value="" />
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Designation" class="control-label"> පාසලේ දරන තනතුර
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="desig_select"
                                                            name="desig_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_designations as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->desig_id; ?>">
                                                                <?php echo $row->desig_type; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Assign to a game" class="control-label"> අංශය
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="section_select"
                                                            name="section_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_sections as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->section_id; ?>">
                                                                <?php echo $row->section_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Assign to a game" class="control-label"> අංශයේ
                                                            භූමිකාව </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="section_role_select"
                                                            name="section_role_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_section_roles as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->sec_role_id; ?>">
                                                                <?php echo $row->sec_role_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                        </div> <!-- /schDetailsTab -->
                                        <!-- -------------currentServiceDetailsTab begins------------------------------------------------------------------------- -->
                                        <div role="tabpanel" class="tab-pane" id="currentServiceDetailsTab">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Task Involved" class="control-label"> වර්තමාන සේවා
                                                            තත්වය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="current_service_status_select"
                                                            name="current_service_status_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_service_status as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->service_status_id; ?>">
                                                                <?php echo $row->service_status; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Task Involved" class="control-label"> අනුයුක්ත පළාත
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="province_select"
                                                            name="province_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_province as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->prov_name; ?>">
                                                                <?php echo $row->prov_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Task Involved" class="control-label"> අනුයුක්ත කලාපය
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="zone_select"
                                                            name="zone_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_zones as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->edu_zone; ?>">
                                                                <?php echo $row->edu_zone; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Task Involved" class="control-label"> අනුයුක්ත පාසල
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="attached_sch_select"
                                                            name="attached_sch_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_schools as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->sch_name; ?>">
                                                                <?php echo $row->sch_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="dob" class="control-label"> අනුයුක්ත ආයතනය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input class="form-control" id="attached_institute_txt"
                                                            name="attached_institute_txt"
                                                            placeholder="---ටයිප් කරන්න---" type="text" value="" />
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="dob" class="control-label"> ක්‍රියාත්මක වන දිනය
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input class="form-control datepicker" id="started_dt_txt"
                                                            name="started_dt_txt" placeholder="---ක්ලික් කරන්න---"
                                                            type="text" value="" size="60" />
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="dob" class="control-label"> කාලය </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input class="form-control" id="period_txt" name="period_txt"
                                                            placeholder="---ටයිප් කරන්න---" type="text" value="" />
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                        </div> <!-- /currentServiceDetailsTab -->
                                        <!-- -------------taskTab begins------------------------------------------------------------------------- -->
                                        <div role="tabpanel" class="tab-pane" id="taskTab">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Assign to a game" class="control-label"> වැඩිම
                                                            කාලයක් නිරතවන කාර්යය</label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="task1_select"
                                                            name="task1_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_tasks_involved as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->involved_task_id; ?>">
                                                                <?php echo $row->inv_task; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Assign to a game" class="control-label"> වැඩිම
                                                            කාලයක් උගන්වන අංශය</label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="section1_select"
                                                            name="section1_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_sections as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->section_id; ?>">
                                                                <?php echo $row->section_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Assign to a game" class="control-label"> වැඩිම
                                                            කාලයක් උගන්වන විෂය</label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="subject1_select"
                                                            name="subject1_select">
                                                            <option value="" selected>---පළමුව අංශය තෝරන්න---</option>
                                                            <?php //foreach ($this->all_subjects as $row){ 
                                                            ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <!--                        <option value="<?php //echo $row->subject_id; 
                                                                                                        ?>"><?php //echo $row->subject; 
                                                                                                            ?></option> -->
                                                            <?php //} 
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Assign to a game" class="control-label"> දෙවනුව
                                                            වැඩිම කාලයක් නිරතවන කාර්යය
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="task2_select"
                                                            name="task2_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_tasks_involved as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->involved_task_id; ?>">
                                                                <?php echo $row->inv_task; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Assign to a game" class="control-label"> දෙවනුව
                                                            වැඩිම කාලයක් උගන්වන අංශය
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="section2_select"
                                                            name="section2_select">
                                                            <option value="" selected>---ක්ලික් කරන්න---</option>
                                                            <?php foreach ($this->all_sections as $row) { ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <option value="<?php echo $row->section_id; ?>">
                                                                <?php echo $row->section_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="Assign to a game" class="control-label"> දෙවනුව
                                                            වැඩිම කාලයක් උගන්වන විෂය
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select class="form-control" id="subject2_select"
                                                            name="subject2_select">
                                                            <option value="" selected>---පළමුව අංශය තෝරන්න---</option>
                                                            <?php //foreach ($this->all_subjects as $row){ 
                                                            ?>
                                                            <!-- from Staff controller constructor method -->
                                                            <!--                               <option value="<?php //echo $row->subject_id; 
                                                                                                                ?>"><?php //echo $row->subject; 
                                                                                                                    ?></option>
 --> <?php //} 
        ?>
                                                        </select>
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                        </div> <!-- /taskTab -->
                                        <div role="tabpanel" class="tab-pane" id="photoTab">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                        <label for="select image" class="control-label"> පින්තූරය තෝරන්න
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input type="file" name="stf_image" size="20" id="stf_image" />
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-3">
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <img id="imgPrw" src="#" alt="Preview" class="imgPrw" />
                                                    </div>
                                                </div> <!-- /row -->
                                            </div> <!-- /form group -->
                                            <!-- <fieldset> -->
                                        </div> <!-- /photoTab -->
                                    </div> <!-- /col-sm-12 -->
                                </div>
                            </div> <!-- /row -->
                        </div> <!-- /modal-body -->
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit" name="btn_add_new_stf_info"
                                value="Add_New">Save</button>
                        </div> <!-- /modal-footer -->
                        </fieldset>
                        <?php echo form_close(); ?>
                    </div> <!-- /#bootstrap model content -->
                </div> <!-- /#bootstrap model dialog -->
            </div> <!-- / .modal fade -->
        </div> <!-- /container-fluid -->
        <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.colVis.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
        <script type="text/javascript">
        $('#addNewStaffInfo a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
            $(this).css('border-color', 'blue');
        })

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgPrw').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function() {

            $("#stf_image").change(function() {
                readURL(this);
            });

            $('#staffTable').DataTable({
                fixedHeader: true,
                //dom: 'Bfrtip',
                // buttons: [
                //   {
                //     extend: 'excel',
                //     text: 'Save',
                //     exportOptions: {
                //         modifier: {
                //             //page: 'current'
                //             page: 'all'
                //         }
                //     }
                //   }
                // ],  
                //paging: false,      
                //scrollY: "600px",
                fixedColumns: {
                    leftColumns: 2
                },
                fixedHeader: {
                    header: true,
                    headerOffset: 45,
                },
                //scrollX: true   
            });
        })
        </script>
        <script type="text/javascript">
        $(document).ready(function() {
            // date picker
            $('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                yearRange: '1955:',
            })

        });
        $(".btn_delete_staff").click(function() {
            var row_id = $(this).parents("tr").attr("id");
            var stf_id = $(this).attr("data-id");
            //alert(stf_id);
            swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this record!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: "<?php echo base_url(); ?>Staff/deleteStaff",
                            method: "POST",
                            data: {
                                stf_id: stf_id
                            },
                            error: function() {
                                alert('Something is wrong');
                            },
                            success: function(data) {
                                if (data.trim() == 'true') {
                                    $("#" + row_id).remove();
                                    swal("Deleted!", "Staff details has been deleted.",
                                        "success");
                                } else {
                                    swal("Error!", "Staff details not deleted.", "error");
                                }
                            }
                        });
                    }
                });
        });
        // වැඩිම කාලයක් නිරතවන කාර්යය තෝරා අදාල අංශය තෝරන විට මෙය භාවිත වේ. 
        $(document).on('change', '#section1_select', function() {
            var sec_id = $(this).val();
            //alert(stream_id);
            $.ajax({
                url: "<?php echo base_url(); ?>Staff/viewSubjectsSectionWise",
                method: "POST",
                data: {
                    sec_id: sec_id
                },
                dataType: "json",
                success: function(subjects) {
                    $('select#subject1_select').html('');
                    $.each(subjects, function(key, value) {
                        $('select[name="subject1_select"]').append('<option value="' + value
                            .subject_id + '">' + value.subject + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            })
        });
        // දෙවනුව වැඩිම කාලයක් නිරතවන කාර්යය තෝරා අදාල අංශය තෝරන විට මෙය භාවිත වේ. 
        $(document).on('change', '#section2_select', function() {
            var sec_id = $(this).val();
            //alert(stream_id);
            $.ajax({
                url: "<?php echo base_url(); ?>Staff/viewSubjectsSectionWise",
                method: "POST",
                data: {
                    sec_id: sec_id
                },
                dataType: "json",
                success: function(subjects) {
                    $('select#subject2_select').html('');
                    $.each(subjects, function(key, value) {
                        $('select[name="subject2_select"]').append('<option value="' + value
                            .subject_id + '">' + value.subject + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            })
        });
        </script>