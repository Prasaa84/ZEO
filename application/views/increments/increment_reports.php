<style type="text/css">
  tr{ line-height: auto;}
  #all_phy_res th{ vertical-align:middle;} 
  #all_phy_res td{ vertical-align:middle; padding: .1rem;} 
  #all_phy_res #td_btn{text-align: center;}
  #all_phy_res_status th{ vertical-align:middle;} 
  #all_phy_res_status td{ vertical-align:middle; padding: .1rem;} 
  .card-header{background-color:#999999;color: #ffffff;}
</style>
<style type="text/css">
  th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        height: 200px;
        width: 1200px;
        margin: 0 auto;
    }
</style>
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script type="text/javascript">



</script>
  <?php
    foreach($this->session as $user_data){
      $userid = $user_data['userid'];
      $userrole = $user_data['userrole'];
      $role_id = $user_data['userrole_id'];
    }
  ?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>user">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>increment">Increment</a>
        </li>
        <li class="breadcrumb-item active">Increment Reports</li>
      </ol> 
  <?php
    if($role_id=='1' || $role_id=='2' || $role_id=='7' || $role_id=='8' || $role_id=='9'){  ?>  <!-- check for system admin login -->
      <div class="row" id="search-bar-row">     <!-- search bar is availabel for admin only -->
        <div class="col-lg-12 col-sm-12">
          <div class="row">
            <div class="col-lg-6 col-sm-6">
              <form class="navbar-form" role="search" id="find_tr_inc_not_submit_by_year" name="find_tr_inc_not_submit_by_year" action="<?php echo base_url(); ?>Increment/viewTeachersNotSubmitIncrement" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <label for="name" class="form-control-label" style="margin-right: 5px;"> වැටුප් වර්ධක ලබා නොදුන් ගුරුවරුන් </label>
                    <select class="form-control" id="inc_year_select" name="inc_year_select" title="Please select">
                      <option value="" selected> Select the year </option>
                      <?php 
                        $current_year = date('Y')-1;
                        foreach (range($current_year, 2019 ) as $value){ ?>
                          <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                      <?php } ?>                              
                    </select>
                    <button type="submit" class="btn btn-default input-group-addon" name="btn_view_inc_not_submit" value="View"><i class="fa fa-search"></i></button>
                  </div> <!-- /input-group -->
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->
            <div class="col-lg-6 col-sm-6">
              <form class="navbar-form" role="search" action="<?php echo base_url(); ?>Increment/viewTeachersAccordingtoIncStatus" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <label for="name" class="form-control-label" style="margin-right: 5px;"> මෙම වර්ෂයේ වැටුප් වර්ධක ලබා දුන් ගුරුවරුන් </label>
                    <select class="form-control" id="inc_status_select" name="inc_status_select" title="Please select">
                      <option value="" selected> Select the Status </option>
              <?php     foreach ($this->all_increment_status as $row){ 
                          if($role_id == 7){
                            if($row->inc_status_id==1 || $row->inc_status_id==2 || $row->inc_status_id==3){
              ?>
                              <option value="<?php echo $row->inc_status_id; ?>"><?php echo $row->inc_status; ?></option>
              <?php         }   ?> 
              <?php       }elseif($role_id == 8){  
                            if($row->inc_status_id==3 || $row->inc_status_id==4 || $row->inc_status_id==5){
              ?>
                              <option value="<?php echo $row->inc_status_id; ?>"><?php echo $row->inc_status; ?></option>
              <?php         }
                          }elseif($role_id == 9){  
                            if($row->inc_status_id==5 || $row->inc_status_id==6){ 
              ?>
                              <option value="<?php echo $row->inc_status_id; ?>"><?php echo $row->inc_status; ?></option>                
              <?php         } 
                          }else{
              ?>
                              <option value="<?php echo $row->inc_status_id; ?>"><?php echo $row->inc_status; ?></option>
              <?php              
                          }
                        }
              ?>                              
                    </select>
                    <button type="submit" class="btn btn-default input-group-addon" name="btn_view_tr_inc_status" value="View"><i class="fa fa-search"></i></button>
                  </div> <!-- /input-group -->
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->
            
          </div> <!-- /.row -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / #search-bar-row -->
    <?php } ?>

    <?php
      if(!empty($this->session->flashdata('msg'))) {
        $message = $this->session->flashdata('msg');  ?>
        <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
    <?php } ?>
    <?php if(!empty($tr_increment_status)) { //print_r($increment_data); die(); ?> 
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>මෙම වර්ෂයේ වැටුප් වර්ධක ලබා දුන් ගුරුවරුන්
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h6 align="center">මෙම වර්ෂයේ වැටුප් වර්ධක ලබා දුන් ගුරුවරුන්</h6>
                  <div class="table-responsive">
                    <table id="dataTable2" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> නම </th>
                          <th> පාසල </th>
                          <th>හැඳුනුම්පත් අංකය</th>
                          <th>ස්ත්‍රී/පුරුෂ</th>
                          <th> දු.ක.</th>
                          <th>තනතුර</th>
                          <th>මුල් පත්විමේ දිනය </th>
                          <th>වැටුප් වර්ධක දිනය </th>
                          <th> ලබාදුන් දිනය </th>
                          <th> යාවත්කාලීන වූ දිනය </th>
                          <th> තත්වය </th>  
                          <th> අඩුපාඩු </th>  
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($tr_increment_status as $row){  
                          $staff_id = $row->stf_id;
                          $census_id = $row->census_id;
                          //$census_id = $row->census_id;
                          $name_with_ini = $row->name_with_ini;
                          $school = $row->sch_name;
                          $nic_no = $row->nic_no;
                          $gender_name = $row->gender_name;
                          if($row->phone_mobile1==''){
                            $phone_mobile = $row->phone_mobile2;
                          }else{
                            $phone_mobile = $row->phone_mobile1;
                          }
                          $desig_type = $row->desig_type;
                          $inc_status = $row->inc_status;
                          $first_app_date = $row->first_app_dt;
                          $sal_incr_dt = $row->sal_incr_dt;
                          $date_added = $row->inc_date_added;
                          $update_dt = $row->last_update;
                          $remarks = $row->remarks;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr title="<?php echo $staff_id; ?>" data-toggle="tooltip">
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                          <td style="vertical-align:middle" ><?php echo $school; ?></td>
                          <td style="vertical-align:middle" ><?php echo $nic_no; ?></td>
                          <td style="vertical-align:middle" ><?php echo $gender_name; ?></td>
                          <td style="vertical-align:middle" ><?php echo $phone_mobile; ?></td>
                          <td style="vertical-align:middle" ><?php echo $desig_type; ?></td>
                          <td style="vertical-align:middle" ><?php echo $first_app_date; ?></td>
                          <td style="vertical-align:middle" ><?php echo $sal_incr_dt; ?></td>
                          <td style="vertical-align:middle" ><?php echo $date_added; ?></td>
                          <td style="vertical-align:middle" ><?php echo $update_dt; ?></td>
                          <td style="vertical-align:middle" ><?php echo $inc_status; ?></td>
                          <td style="vertical-align:middle" ><?php echo $remarks; ?></td>
                        </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
              </div> 
            </div> <!-- /col-lg-12 -->
            </div>
            <div class="card-footer small text-muted">
              <?Php 
                
              ?>
            </div>
          </div>
        </div>
      </div> <!-- /row -->
    <?php } ?>
    <?php if(!empty($stf_data_no_increment)) { //print staff details who have not submitted their increment forms ?> 
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
               <?php echo $academic_year; ?> වර්ෂයේ වැටුප් වර්ධක ලබා නොදුන් ගුරුවරුන්</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h6 align="center"> මෙම වර්ෂයේ  වැටුප් වර්ධක ලබා නොදුන් ගුරුවරුන්</h6>
                  <div class="table-responsive">
                    <table id="dataTable2" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> නම </th>
                          <th> පාසල </th>
                          <th> හැඳුනුම්පත් අංකය </th>
                          <th> ස්ත්‍රී/පුරුෂ </th>
                          <th> දු.ක.</th>
                          <th> තනතුර </th>
                          <th> මුල් පත්විමේ දිනය </th>
                          <th> වැටුප් වර්ධක දිනය </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($stf_data_no_increment as $row){  
                          $staff_id = $row[0]->stf_id;
                          $census_id = $row[0]->census_id;
                          //$census_id = $row->census_id;
                          $name_with_ini = $row[0]->name_with_ini;
                          $school = $row[0]->sch_name;
                          $nic_no = $row[0]->nic_no;
                          $gender_name = $row[0]->gender_name;
                          if($row[0]->phone_mobile1==''){
                            $phone_mobile = $row[0]->phone_mobile2;
                          }else{
                            $phone_mobile = $row[0]->phone_mobile1;
                          }
                          $desig_type = $row[0]->desig_type;
                          $first_app_date = $row[0]->first_app_dt;
                          $sal_incr_dt = $row[0]->sal_incr_dt;
                          $no = $no + 1;  ?>
                        <tr>
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                          <td style="vertical-align:middle" ><?php echo $school; ?></td>
                          <td style="vertical-align:middle" ><?php echo $nic_no; ?></td>
                          <td style="vertical-align:middle" ><?php echo $gender_name; ?></td>
                          <td style="vertical-align:middle" ><?php echo $phone_mobile; ?></td>
                          <td style="vertical-align:middle" ><?php echo $desig_type; ?></td>
                          <td style="vertical-align:middle" ><?php echo $first_app_date; ?></td>
                          <td style="vertical-align:middle" ><?php echo $sal_incr_dt; ?></td>
                        </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
              </div> 
            </div> <!-- /col-lg-12 -->
            </div>
            <div class="card-footer small text-muted">
              <?Php 
                
              ?>
            </div>
          </div>
        </div>
      </div> <!-- /row -->
    <?php } ?>
     <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
              මෙම වර්ෂයේ <?php echo date("Y:m:d"); ?> දින දක්වා වැටුප් වර්ධක ලබා නොදුන් ගුරුවරුන්</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h6 align="center"> මෙම වර්ෂයේ <?php echo date("Y:m:d"); ?> දින දක්වා වැටුප් වර්ධක ලබා නොදුන් ගුරුවරුන්</h6>
                  <?php if(!empty($tr_not_submit_increment_upto_now)) { //print_r($increment_data); die(); ?>   
                  <div class="table-responsive">
                    <table id="dataTable1" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> නම </th>
                          <th> පාසල </th>
                          <th>හැඳුනුම්පත් අංකය</th>
                          <th>ස්ත්‍රී/පුරුෂ</th>
                          <th> දු.ක.</th>
                          <th>තනතුර</th>
                          <th>මුල් පත්විමේ දිනය </th>
                          <th>වැටුප් වර්ධක දිනය </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($tr_not_submit_increment_upto_now as $row){  
                          $staff_id = $row[0]->stf_id;
                          $census_id = $row[0]->census_id;
                          //$census_id = $row->census_id;
                          $name_with_ini = $row[0]->name_with_ini;
                          $school = $row[0]->sch_name;
                          $nic_no = $row[0]->nic_no;
                          $gender_name = $row[0]->gender_name;
                          if($row[0]->phone_mobile1==''){
                            $phone_mobile = $row[0]->phone_mobile2;
                          }else{
                            $phone_mobile = $row[0]->phone_mobile1;
                          }
                          $desig_type = $row[0]->desig_type;
                          $first_app_date = $row[0]->first_app_dt;
                          $sal_incr_dt = $row[0]->sal_incr_dt;
                          $update_dt = $row[0]->last_update;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr>
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                          <td style="vertical-align:middle" ><?php echo $school; ?></td>
                          <td style="vertical-align:middle" ><?php echo $nic_no; ?></td>
                          <td style="vertical-align:middle" ><?php echo $gender_name; ?></td>
                          <td style="vertical-align:middle" ><?php echo $phone_mobile; ?></td>
                          <td style="vertical-align:middle" ><?php echo $desig_type; ?></td>
                          <td style="vertical-align:middle" ><?php echo $first_app_date; ?></td>
                          <td style="vertical-align:middle" ><?php echo $sal_incr_dt; ?></td>
                        </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php }else{ // if empty($acStaffDetails)
                      echo '<h4 align="center">No Records!!!</h4>'; 
                    }
                   ?>  
              </div> 
            </div> <!-- /col-lg-12 -->
            </div>
            <div class="card-footer small text-muted">
              <?Php 
                
              ?>
            </div>
          </div>
        </div>
      </div>
<script type="text/javascript">
  $(document).ready(function() {
    $('#dataTable1').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    } );
    $('#dataTable2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    } );
  });
</script>