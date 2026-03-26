<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<style type="text/css">
  tr{ line-height: auto;}
  #all_phy_res th{ vertical-align:middle;} 
  #all_phy_res td{ vertical-align:middle; padding: .1rem;} 
  #all_phy_res #td_btn{text-align: center;}
  #all_phy_res_status th{ vertical-align:middle;} 
  #all_phy_res_status td{ vertical-align:middle; padding: .1rem;} 
  .card-header{background-color:#999999;color: #ffffff;}
</style>
  <?php
    foreach($this->session as $user_data){
      $userid = $user_data['userid'];
      $userrole = $user_data['userrole'];
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
          <a href="<?php echo base_url(); ?>user/viewUsers">User</a>
        </li>
        <li class="breadcrumb-item active">User Log</li>
      </ol>
    <?php
      if(!empty($this->session->flashdata('userLogMsg'))) {
        $message = $this->session->flashdata('userLogMsg');  ?>
        <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
    <?php } ?>
      <div class="row" id="search-bar-row">    
        <div class="col-lg-12 col-sm-12">
          <div class="row">
            <div class="col-lg-12 col-sm-12">
              <div class="row">
              <form class="navbar-form form-inline" role="search" id="srch_user_log" name="srch_user_log" action="<?php echo base_url(); ?>User/viewUserLog" method="POST">
                <div class="form-group col-lg-2 col-sm-2">
                  <div class="input-group addon">
                    <input class="form-control form-control-sm" placeholder="User ID..." name="userid_txt" id="userid_txt" type="text" value="<?php echo set_value('userid_txt'); ?>" data-toggle="tooltip" title="User ID">
                  </div> <!-- /input-group -->
                </div>
                <div class="form-group col-lg-2 col-sm-2">
                  <div class="input-group addon">
                    <input class="form-control form-control-sm" placeholder="Census ID..." name="censusid_txt" id="censusid_txt" type="text" value="<?php echo set_value('censusid_txt'); ?>" data-toggle="tooltip" title="Census ID">
                  </div> <!-- /input-group -->
                </div>
                <div class="form-group col-lg-2 col-sm-2">
                  <div class="input-group addon">
                    <input class="form-control datepicker form-control-sm" name="frmdate_txt" id="frmdate_txt" type="date" data-toggle="tooltip" title="From Date" value="<?php echo set_value('frmdate_txt'); ?>" >
                  </div> <!-- /input-group -->
                </div>
                <div class="form-group col-lg-2 col-sm-2">
                  <div class="input-group addon">
                    <input class="form-control datepicker form-control-sm" name="todate_txt" id="todate_txt" type="date" data-toggle="tooltip" title="To Date" value="<?php echo set_value('todate_txt'); ?>" >
                  </div> <!-- /input-group -->
                </div>
                <div class="form-group col-lg-2 col-sm-2">
                  <div class="input-group addon">
                    <select class="form-control form-control-sm" id="select_user_act" name="select_user_act" data-toggle="tooltip" title="User Action">
                      <option value="" selected>User Act</option>
                      <?php foreach ($this->all_user_acts as $row){ ?><!-- from School controller constructor method -->
                      <option value="<?php echo $row->act_type_id; ?>"><?php echo $row->act_type; ?></option>
                      <?php } ?>                                
                    </select>
                  </div> <!-- /input-group -->
                </div>
                <div class="form-group col-lg-2 col-sm-2">
                  <input id="btn_view_userlog" name="btn_view_userlog" type="submit" class="btn btn-primary btn-sm" value="Submit" />
                </div> <!-- /.form-group -->
              </form> <!-- /form -->
              </div>
            </div> <!-- /.col-lg-3 col-sm-3 -->
          </div> <!-- /.row -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / #search-bar-row -->
      
      <div class="row" id="user_log_info">
        <div class="col-lg-12">
          <div class="card mb-3 mt-3">
            <div class="card-header">
              <i class="fa fa-table"></i> User Log Details </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
        <?php   if(!empty($user_log_details)) { // ?>
                  <h5 align="center"> User Log Details </h5>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="userLogTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th scope="col" class="">User Id</th>
                          <th scope="col" class="">Census Id</th>
                          <th scope="col" class="">Row</th>
                          <th scope="col" class="">Table</th>
                          <th scope="col" class="">Act type</th>
                          <th scope="col" class="">Note</th>
                          <th scope="col" class="">Date</th>                        
                        </tr>
                      </thead>
                      <tbody>
                <?php 
                        $latest_upd_dt = 0;
                        foreach ($user_log_details as $row){  
                          $userlog_added_dt = $row->userlog_added_dt; 
                          if($userlog_added_dt > $latest_upd_dt){ // get latest update date
                            $latest_upd_dt = $userlog_added_dt;
                          }
                ?>
                          <tr>
                            <td style="vertical-align:middle"><?php echo $row->user_id; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->census_id; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->key_on_row; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->tbl_name; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->act_type; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->note; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->userlog_added_dt; ?></td>
                          </tr>
                <?php   } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
          <?php   }   ?> 
                </div>
              </div> 
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php  
                if( !empty($user_log_details) ) {
                  $latest_upd_dt = strtotime($latest_upd_dt);
                  $sch_last_updated_on_date = date("j F Y",$latest_upd_dt);
                  $sch_last_updated_on_time = date("h:i A",$latest_upd_dt);
                  echo 'Updated on '.$sch_last_updated_on_date.' at '.$sch_last_updated_on_time;
                }
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row #user_log_info -->
    </div> <!-- /container-fluid -->

  <script type="text/javascript">
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    var lastyear = today.getFullYear()-1;
     if(dd<10){
            dd='0'+dd
        } 
        if(mm<10){
            mm='0'+mm
        } 

    today = yyyy+'-'+mm+'-'+dd;
    var lastday = lastyear+'-'+mm+'-'+dd;;
    document.getElementById("frmdate_txt").setAttribute("max", today);
    document.getElementById("todate_txt").setAttribute("max", today);
    document.getElementById("frmdate_txt").setAttribute("min", lastday);
    document.getElementById("todate_txt").setAttribute("min", lastday);

    $(document).ready(function() {

      $('#userLogTable').DataTable( {
        "order": [[ 6 , "desc" ]]
      } );

    });
  </script>