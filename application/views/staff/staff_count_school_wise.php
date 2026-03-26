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
        <?php if ($userrole != 'School User') {  ?>
        <!-- check for system admin login -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fa fa-table"></i> පාසල් වල අධ්‍යයන කාර්යමණ්ඩල ප්‍රමාණයන්
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 my-auto">
                                <?php if (!empty($staff_count_schoolwise)) { ?>
                                <div class="table-responsive">
                                    <table id="dataTable1" class="table table-striped table-hover" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th> පාසල </th>
                                                <th> ගුරුවරුන් ප්‍රමාණය </th>
                                                <th> යාවත්කාලීන කල </th>
                                                <th> යාවත්කාලීන නොකල </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                          $no = 0;
                          $latest_upd_dt = 0;
                          $total_staff = 0;
                          foreach ($staff_count_schoolwise as $row) {
                            $census_id = $row->census_id;
                            $school = $row->sch_name;
                            $count = $row->stf_count;
                            $total_staff += $count;
                            $updated_staff = $row->stf_count_this_month;
                            $not_updated_staff = $row->stf_count - $updated_staff;
                            $update_dt = $row->date_updated;
                            if ($latest_upd_dt < $update_dt) {
                              $latest_upd_dt = $update_dt;
                            }
                            $no = $no + 1;  ?>
                                            <tr data-toggle="tooltip" title=<?php echo $school; ?>>
                                                <th><?php echo $no; ?></th>
                                                <td style="vertical-align:middle"><?php echo $school; ?></td>
                                                <td style="vertical-align:middle"><?php echo $count; ?></td>
                                                <td style="vertical-align:middle"><?php echo $updated_staff; ?></td>
                                                <td style="vertical-align:middle"><?php echo $not_updated_staff; ?></td>
                                            </tr>
                                            <?php } // end foreach 
                          ?>
                                            <tr>
                                                <td><?php echo $total_staff; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } else {
                    echo 'No records found';
                  } ?>
                            </div> <!-- /.col-lg-12 -->
                        </div> <!-- /.row -->
                    </div><!-- /.card-body -->
                </div>
            </div> <!-- /.col-lg-12 -->
        </div> <!-- /.row -->
        <?php  }  ?>

        <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.print.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.colVis.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {

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