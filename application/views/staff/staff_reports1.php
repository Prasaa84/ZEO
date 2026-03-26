<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
  <style type="text/css">

  </style>
  <script type="text/javascript">
    $( document ).ready(function() {    
      $('#dataTable1').DataTable({
        dom: 'Bfrtip',
        buttons: [
          {
            extend: 'excel',
            text: 'Save',
            exportOptions: {
                modifier: {
                    page: 'All'
                }
            }
          }
        ]
      });

      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
<?php
  foreach($this->session as $user_data){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if($role_id=='2'){
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
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>staff">Staff</a></li>
        <li class="breadcrumb-item active">Reports</li>
      </ol>
      <?php
    if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->
      <div class="row" id="search-bar-row">     <!-- search bar is availabel for admin only -->
        <div class="col-lg-12 col-sm-12">
          <div class="row">
            <div class="col-lg-2 col-sm-2">
              <form class="navbar-form" role="search" id="srch_stf_info_by_censusid" name="srch_stf_info_by_censusid" action="<?php echo base_url(); ?>Staff/viewStaffByNic" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <input class="form-control" placeholder="NIC..." name="nic_txt" id="nic_txt" type="text" value="<?php echo set_value('nic_txt'); ?>">
                    <button type="submit" class="btn btn-default input-group-addon" name="btn_view_details_by_nic" value="View"><i class="fa fa-search"></i></button>
                  </div> <!-- /input-group -->
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->
            <div class="col-lg-2 col-sm-2">
              <form class="navbar-form" role="search" action="" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <input class="form-control" placeholder="View all" name="view_all_txt" id="view_all_txt" type="text" readonly="true">
                    <a type="button" class="btn btn-default input-group-addon" href="<?php echo base_url(); ?>Staff/staffReportsView"><i class="fa fa-search"></i></a>
                  </div> <!-- /input-group -->
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->
            <div class="col-lg-2 col-sm-2">
              <form class="navbar-form" role="search" action="<?php echo base_url(); ?>Staff/viewStaffTaskWise" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <select class="form-control" id="task_id_select" name="task_id_select" title="Please select">
                    <option value="" selected>By Task</option>
                      <?php foreach ($this->all_tasks_involved as $row){ ?><!-- from PhysicalResource controller constructor method -->
                      <option value="<?php echo $row->involved_task_id; ?>"><?php echo $row->inv_task; ?></option>
                      <?php } ?>  
                      <option value="All">All</option>
                    </select>
                    <button type="submit" class="btn btn-default input-group-addon" name="btn_view_by_task" value="Task"><i class="fa fa-search"></i></button>
                  </div> <!-- /input-group -->
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->
          </div> <!-- /.row -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / #search-bar-row -->
    <?php } ?>
<!-- ------------------------------------------------------------------------------------------------------------------- -->
    <?php if(!empty($stf_task_info)) { ?>   
      <div class="row" id="staff_details_by_nic">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> නිරතවන කාර්යය අනුව අධ්‍යයන කාර්යමණ්ඩල තොරතුරු 
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">
                    <?php if($userrole=='School User'){
                            echo $school_name; 
                          }else{

                          }
                    ?></h5>
                  <h6 align="center">නිරතවන කාර්යය අනුව අධ්‍යයන කාර්යමණ්ඩල තොරතුරු </h6>
                  <div class="table-responsive">
                    <table id="dataTable1" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> නම </th>
                          <th> පාසල </th>
                          <th>හැඳුනුම්පත් අංකය</th>
                          
                          <th>කාර්ය වර්ගය</th>
                          <th>කාර්යය</th>
                          <th>අංශය </th>
                          <th>විෂය</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($stf_task_info as $row){ 
                          //$stf_id = $row->staff_id;
                          //$census_id = $row->census_id;
                          $name_with_ini = $row->name_with_ini;
                          $school = $row->sch_name;
                          $nic_no = $row->nic_no;
                         
                          $involved_task_type_id = $row->involved_task_type_id;
                          $involved_task_type = $row->involved_task_type;
                          $involved_task_id = $row->involved_task_id;
                          $inv_task = $row->inv_task;
                          $section_id = $row->section_id;
                          $section_name = $row->section_name;
                          $subject_id = $row->subject_id;
                          $subject = $row->subject;
                          $update_dt = $row->last_update;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr id="<?php //echo 'tbrow'.$stf_id; ?>">
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                          <td style="vertical-align:middle;"><?php echo $school; ?></td>
                          <td style="vertical-align:middle" ><?php echo $nic_no; ?></td>
                          <td style="vertical-align:middle" ><?php echo $involved_task_type; ?></td>
                          <td style="vertical-align:middle" ><?php echo $inv_task; ?></td>
                          <td style="vertical-align:middle" ><?php echo $section_name; ?></td>
                          <td style="vertical-align:middle" ><?php echo $subject; ?></td>
                        </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
              </div> 
            </div> <!-- /col-lg-12 -->
            <button id="btn_add_new_building_info" name="btn_add_new_building_info" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewStaffInfo" ><i class="fa fa-plus"></i> Add New</button>
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php 
                if(!empty($acStaffDetails)) { 
                  $latest_upd_dt = strtotime($latest_upd_dt);
                  $building_update_dt = date("j F Y",$latest_upd_dt);
                  $building_update_tm = date("h:i A",$latest_upd_dt);
                  echo 'Updated on '.$building_update_dt.' at '.$building_update_tm;
                }
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row # -->
<?php } ?>  
<!-- ------------------------------------------------------------------------------------------------------------------- -->
<?php if(!empty($stf_all_info)) { ?>   
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
                    <?php if($userrole=='School User'){
                            echo $school_name; 
                          }else{

                          }
                    ?></h5>
                  <h6 align="center">අධ්‍යයන කාර්යමණ්ඩල තොරතුරු</h6>
                  <div class="table-responsive">
                    <table id="dataTable1" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> නම </th>
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
                          <th>පත්වීම් වර්ගය</th>
                          <th>පත්වීමේ ස්වභාවය</th>
                          <th>පළමු පත්වීම් දිනය</th>
                          <th>මෙම පාසලට පත්වූ දිනය</th>
                          <th>වර්ථමාන සේවා තත්වය</th>
                          <th>පත්වීම් විෂය</th>
                          <th>පත්වීම් මාධ්‍යය</th>
                          <th>වැටුප් අංකය </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($stf_all_info as $row){ 
                          $stf_id = $row->staff_id;
                          $census_id = $row->census_id;
                          $name_with_ini = $row->name_with_ini;
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
                          $email = $row->stf_email;
                          $desig_type = $row->desig_type;
                          $edu_qual = $row->edu_q_name;
                          $prof_qual = $row->prof_q_description;
                          $cur_serv_grd = $row->serv_grd_type;
                          $app_type = $row->app_type;
                          $stf_status = $row->stf_status; // පත්වීමේ ස්වභාවය 
                          $first_app_dt = $row->first_app_dt;
                          $start_dt_this_sch = $row->start_dt_this_sch;
                          $cur_serv_status = $row->service_status;
                          $app_subject = $row->app_subj;
                          $app_medium = $row->subj_med_type;
                          $salary_no = $row->salary_no;
                          $update_dt = $row->last_update;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr id="<?php echo 'tbrow'.$stf_id; ?>">
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                          <td style="vertical-align:middle;"><?php echo $address; ?></td>
                          <td style="vertical-align:middle" ><?php echo $school; ?></td>
                          <td style="vertical-align:middle" ><?php echo $nic_no; ?></td>
                          <td style="vertical-align:middle" ><?php echo $dob; ?></td>
                          <td style="vertical-align:middle" ><?php echo $gender_name; ?></td>
                          <td style="vertical-align:middle" ><?php echo $civil_status; ?></td>
                          <td style="vertical-align:middle" ><?php echo $ethnic_group; ?></td>
                          <td style="vertical-align:middle" ><?php echo $religion; ?></td>
                          <td style="vertical-align:middle" ><?php echo $phone_home; ?></td>
                          <td style="vertical-align:middle" ><?php echo $mobile1; ?></td>
                          <td style="vertical-align:middle" ><?php echo $mobile2; ?></td>
                          <td style="vertical-align:middle" ><?php echo $email; ?></td>
                          <td style="vertical-align:middle" ><?php echo $desig_type; ?></td>
                          <td style="vertical-align:middle" ><?php echo $edu_qual; ?></td>
                          <td style="vertical-align:middle" ><?php echo $prof_qual; ?></td>
                          <td style="vertical-align:middle" ><?php echo $cur_serv_grd; ?></td>
                          <td style="vertical-align:middle" ><?php echo $app_type; ?></td>
                          <td style="vertical-align:middle" ><?php echo $stf_status; ?></td> <!-- පත්වීමේ ස්වභාවය  -->
                          <td style="vertical-align:middle" ><?php echo $first_app_dt; ?></td>
                          <td style="vertical-align:middle" ><?php echo $start_dt_this_sch; ?></td>
                          <td style="vertical-align:middle" ><?php echo $cur_serv_status; ?></td>
                          <td style="vertical-align:middle" ><?php echo $app_subject; ?></td>
                          <td style="vertical-align:middle" ><?php echo $app_medium; ?></td>
                          <td style="vertical-align:middle" ><?php echo $salary_no; ?></td>
                        </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
              </div> 
            </div> <!-- /col-lg-12 -->
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php 
                if(!empty($acStaffDetails)) { 
                  $latest_upd_dt = strtotime($latest_upd_dt);
                  $building_update_dt = date("j F Y",$latest_upd_dt);
                  $building_update_tm = date("h:i A",$latest_upd_dt);
                  echo 'Updated on '.$building_update_dt.' at '.$building_update_tm;
                }
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row # -->
<?php } ?>  
    </div> <!-- /container-fluid -->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#staffTable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              {
                extend: 'print',
                text: 'Print'
              },
              {
                extend: 'pdf',
                messageBottom: null
              },
            ],
            select: true
        } );
      });
    </script>
    <script type="text/javascript">
      $(document).ready(function() {  
        // date picker
        $('.datepicker').datepicker({
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange:'1955:',
        })

      });
    </script>