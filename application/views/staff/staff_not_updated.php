<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<style type="text/css">
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
            paging: false,
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
            <li class="breadcrumb-item "><a href="#">Not Updated</a></li>
        </ol>
        <?php
        if (!empty($this->session->flashdata('msg'))) {
            $message = $this->session->flashdata('msg');  ?>
            <div class="<?php echo $message['class']; ?>"><?php echo $message['text']; ?></div>
        <?php   } ?>
        <?php
        if (!empty($staff_not_updated_count)) {
            $total = 0;
            $updated = 0;
            foreach ($staff_not_updated_count as $row) {
                $total = $total + $row->stf_count;
                $updated = $updated + $row->stf_count_this_month;
                $not_updated = $total - $updated;
            }
        } else {
            $not_updated = 0;
        }
        ?>
        <div class="row" id="staff_details_by_nic">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-table"></i> <?php echo $month = date('Y F'); ?> මාසයට යාවත්කාලීන නොවූ අධ්‍යයන
                        කාර්යමණ්ඩලය <?php echo $not_updated; ?>
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
                                <?php if (!empty($staff_not_updated)) { ?>
                                    <div style="overflow-x:auto;" class="">
                                        <table id="dataTable1" class="stripe row-border order-column ">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th> නම </th>
                                                    <th> පාසල </th>
                                                    <th>හැඳුනුම්පත් අංකය</th>
                                                    <th>ස්ත්‍රී/පුරුෂ</th>
                                                    <th> දු.ක.</th>
                                                    <?php if (($userrole == 'System Administrator') || ($userrole == 'School User')) { ?>
                                                        <th></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 0;
                                                $latest_upd_dt = 0;
                                                foreach ($staff_not_updated as $row) {
                                                    $stf_id = $row->staff_id;
                                                    $census_id = $row->census_id;
                                                    $name_with_ini = $row->name_with_ini;
                                                    $school = $row->sch_name;
                                                    $nic_no = $row->nic_no;
                                                    $gender_name = $row->gender_name;
                                                    $phone_mobile1 = $row->phone_mobile1;
                                                    $update_dt = $row->last_update;
                                                    if ($latest_upd_dt < $update_dt) {
                                                        $latest_upd_dt = $update_dt;
                                                    }
                                                    $no = $no + 1;  ?>
                                                    <tr id="<?php echo 'tbrow' . $stf_id; ?>" title="<?php echo $name_with_ini; ?>" data-toggle="tooltip">
                                                        <th><?php echo $no; ?></th>
                                                        <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                                                        <td style="vertical-align:middle"><?php echo $school; ?></td>
                                                        <td style="vertical-align:middle"><?php echo $nic_no; ?></td>
                                                        <td style="vertical-align:middle"><?php echo $gender_name; ?></td>
                                                        <td style="vertical-align:middle"><?php echo $phone_mobile1; ?></td>
                                                        <?php if (($role_id == '1') || ($role_id == '2')) { ?>
                                                            <td id="td_btn" style="vertical-align:middle">
                                                                <a href="<?php echo base_url(); ?>Staff/editStaffView/<?php echo $stf_id; ?>" type="button" id="btn_edit_building_info" name="btn_edit_building_info" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this details" data-toggle="tooltip" data-hidden="" onclick="get(<?php //echo $b_info_id; 
                                                                                                                                                                                                                                                                                                                                                                            ?>)"><i class="fa fa-pencil"></i></a>
                                                            </td>

                                                        <?php } ?>
                                                    </tr>
                                                <?php } // end foreach 
                                                ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- /table-responsive -->
                                <?php } else { // if empty($acStaffDetails)
                                    if (($userrole == 'School User') && empty($staff_not_updated)) {
                                        echo '<h4 align="center">No Records!!!</h4>';
                                    } else if (($userrole == 'Administrator') && empty($staff_not_updated)) {
                                        echo '<h4 align="center">Add or Search Records!!!</h4>';
                                    } else {
                                        echo '<h4 align="center">Search Details</h4>';
                                    }
                                } ?>
                            </div>
                        </div> <!-- /col-lg-12 -->
                    </div> <!-- /card-body -->
                    <div class="card-footer small text-muted">
                        <?php
                        if (!empty($staff_not_updated)) {
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

    </div> <!-- /container-fluid -->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>