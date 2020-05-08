
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
        <li class="breadcrumb-item active">User Alert</li>
      </ol>
      
      
    <?php
      if(!empty($this->session->flashdata('msg'))) {
        $message = $this->session->flashdata('msg');  ?>
        <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
    <?php } ?>
    <?php
      if(!empty($alert_info)) { // find alert info by census id
        foreach ($alert_info as $row){  
          //$div_name = $row->div_name;
        } ?>
      <div class="row" id="alert_info">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> System Alert Information</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">Alert Information</h5>
                  <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="">
                      <thead>
                        <tr>
                          <th scope="col" class="">#</th>
                          <th scope="col" class="">Alert ID</th>
                          <th scope="col" class="">Alert Category</th>
                          <th scope="col" class="">Description</th>
                          <th scope="col" class="">By Whom</th>
                          <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->
                            <th scope="col" class="">To Whom</th>
                          <?php } ?>
                          <th scope="col" class="">Sent On</th>
                          <th scope="col" class="">Read On</th>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <th></th><th></th>
                    <?php } ?>                        
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no=1;
                        $latest_upd_dt = 0;
                        foreach ($alert_info as $row){  
                          $last_update_dt = $row->date_updated; 
                          if($last_update_dt > $latest_upd_dt){ // get latest update date
                            $latest_upd_dt = $last_update_dt;
                          }
                          $date_add = strtotime($row->date_added);
                          $date_added = date("Y-m-d",$date_add);
                          $time_added = date("h:i A",$date_add);
                          $read_on = strtotime($row->when_read);
                          $date_read_on = date("Y-m-d",$read_on);
                          $time_read_on = date("h:i A",$read_on);
                      ?>
                        <tr>
                          <td style="vertical-align:middle"><?php echo $no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->alert_id; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->alert_category; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->alert_desc; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->by_whom; ?></td>
                          <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->
                            <td style="vertical-align:middle"><?php echo $row->sch_name; ?></td>
                          <?php } ?>
                          <td style="vertical-align:middle"><?php echo $date_added.' '.$time_added; ?></td>
                          <td style="vertical-align:middle"><?php echo $date_read_on.' '.$time_read_on; ?></td>                          
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>alert/editAlert/<?php echo $row->alert_id; ?>" type="button" id="btn_update_school" name="btn_update_school" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="Update" title="Update school" data-toggle="tooltip" data-hidden=""><i class="fa fa-pencil"></i></a>
                          </td>
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>alert/deleteAlert/<?php echo $row->alert_id; ?>" type="button" name="btn_update_school" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                          </td>
                    <?php } ?>
                        </tr>
                      <?php $no++;  } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                </div>
              </div> 
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php  
                //view database updated date and time
                $last_update_dt = strtotime($latest_upd_dt);
                $sch_last_updated_on_date = date("j F Y",$last_update_dt);
                $sch_last_updated_on_time = date("h:i A",$last_update_dt);
                echo 'Updated on '.$sch_last_updated_on_date.' at '.$sch_last_updated_on_time;
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row #alert info -->
  <?php   }   ?> 
  
    </div> <!-- /container-fluid -->