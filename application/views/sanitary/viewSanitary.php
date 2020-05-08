<?php
  foreach($this->session as $user_data){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if($userrole=='School User'){
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
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>school">School</a>
        </li>
        <li class="breadcrumb-item active">Sanitary Information</li>
      </ol>
      <?php
    if($role_id=='1'){  ?>  <!-- check for system admin login -->
      <div class="row" id="search-bar-row">     <!-- search bar is availabel for admin only -->
        <div class="col-lg-12 col-sm-12">
          <div class="row">
            <div class="col-lg-5 col-sm-5">
              <form class="navbar-form" role="search" id="srch_san_item_info_by_censusid" name="srch_san_item_info_by_censusid" action="<?php echo base_url(); ?>Sanitary/viewItemStatusByCensusId" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <label>සංඝණන අංකය ඇතුලත් කරන්න &nbsp;</label>
                    <input class="form-control" placeholder="Census ID..." name="censusid_txt" id="censusid_txt" type="text" value="<?php echo set_value('censusid_txt'); ?>">
                    <button type="submit" class="btn btn-default input-group-addon" name="btn_view_details_by_census" value="View"><i class="fa fa-search"></i></button>
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
      <?php   } ?>      
      <div class="row" id="san_item_status_by_censusID">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> සනීපාරක්ෂක තොරතුරු </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">
                    <?php if($userrole=='School User'){
                            echo $school_name; 
                          }else{
                            if(!empty($sanitary_info_by_census)) { 
                              foreach ($sanitary_info_by_census as $row){  
                                $school_name = $row->sch_name;
                              }
                              echo $school_name;
                            }
                          }
                    ?></h5>
                  <h6 align="center">සනීපාරක්ෂක තොරතුරු</h6>
                  <?php
                    if(!empty($sanitary_info_by_census)) { ?>

                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th class="col-sm-3">අයිතමය</th>
                          <th class="col-sm-3">තිබෙන ප්‍රමාණය</th>
                          <th class="col-sm-3">භාවිතයට ගත හැකි ප්‍රමාණය</th>
                          <th class="col-sm-3">ප්‍රතිසංස්කරණය කළ හැකි ප්‍රමාණය</th>
                      <?php if(($role_id=='1') || ($role_id=='2')){ ?>
                            <th class="col-sm-1"></th><th class="col-sm-1"></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($sanitary_info_by_census as $row){  
                          $san_item_details_id = $row->san_item_details_id;
                          $census_id = $row->census_id;
                          $san_item_id = $row->san_item_id;
                          $item = $row->san_item_name;
                          $quantity = $row->quantity;
                          $usable = $row->usable;
                          $repairable = $row->repairable;
                          $update_dt = $row->last_update;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr>
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $item; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $quantity; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $usable; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $repairable; ?></td>
                    <?php if(($role_id=='1') || ($role_id=='2')){ ?>
                            <td id="td_btn" style="vertical-align:middle">
                              <a href="<?php echo base_url(); ?>Sanitary/editItemStatusDetailsPage/<?php echo $san_item_details_id; ?>" type="button" id="btn_edit_san_item_status_details" name="btn_edit_san_item_status_details" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this details" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $san_item_details_id; ?>)"><i class="fa fa-pencil"></i></a>
                            </td>
                            <td id="td_btn" style="vertical-align:middle">
                              <!-- when delete, census id must be sent, since it is used to go back after delete -->
                              <a href="<?php echo base_url(); ?>Sanitary/deleteItemStatusDetails/<?php echo $san_item_details_id; ?>/<?php echo $census_id; ?>" type="button" name="btn_delete_san_item_status_details" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this details" onClick="return confirmItemStatusDetailsDelete();"><i class="fa fa-trash-o"></i></a>
                            </td>
                    <?php } ?>
                        </tr>
                  <?php } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php } else{ 
                    if(($userrole=='School User') && empty($sanitary_info_by_census)){
                      echo '<h4 align="center">Add Records!!!</h4>'; 
                    }else if(($userrole=='Administrator') && empty($sanitary_info_by_census)){
                      echo '<h4 align="center">Add or Search Records!!!</h4>'; 
                    }else{
                      echo '<h4 align="center">Search Details</h4>';
                    }
                  } ?>
                </div>
              </div> 
              <button id="btn_add_new_san_info" name="btn_add_new_san_info" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewSanitaryDetails" ><i class="fa fa-plus"></i> Add New</button>
              <?php 
                if(!empty($sanitary_info_by_census)) {    ?>           
                  <a href="<?php echo base_url(); ?>ExcelExport/printSanitaryInfoByCensusId/<?php echo $census_id; ?>" id="btn_print_lib_res_details" name="btn_print_lib_res_details" type="button" class="btn btn-success btn-sm" ><i class="fa fa-print"></i> Save to Print </a>
              <?php } ?>
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php 
                if(!empty($sanitary_info_by_census)) { 
                  $latest_upd_dt = strtotime($latest_upd_dt);
                  $com_lab_update_dt = date("j F Y",$latest_upd_dt);
                  $com_lab_update_tm = date("h:i A",$latest_upd_dt);
                  echo 'Updated on '.$com_lab_update_dt.' at '.$com_lab_update_tm;
                }
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row #lib_res_status_by_censusID -->
      <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login --> 
      <div class="row">        
        <div class="col-lg-6">
          <div class="card mb-3" id="viewItemsCard">
            <div class="card-header">
              <i class="fa fa-table"></i> සනීපාරක්ෂක අයිතමයන් </div>
            <div class="card-body">
              <?php 
                if(!empty($this->session->flashdata('addItemMsg'))) {
                  $message = $this->session->flashdata('addItemMsg');  ?>
                  <div class="<?php echo $message['class']; ?>"><?php echo $message['text']; ?></div>
              <?php   } ?> 
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <div class="table-responsive">
                    <table id="all_com_res_tbl" class="table table-hover table-striped" cellspacing="0" width="">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>අයිතමය</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 0; 
                          $item_last_update_dt = 0;
                          if(!empty($this->all_san_items)){
                            foreach ($this->all_san_items as $row){
                              $no = $no+1; // from Library controller constructor method
                              $item_update_dt = $row->date_updated;
                              if ($item_last_update_dt < $item_update_dt) {
                                $item_last_update_dt = $item_update_dt;
                              }
                        ?>
                            <tr>
                              <th><?php echo $no; ?></th>
                              <td style="vertical-align:middle"><?php echo $row->san_item_name; ?></td>
                              <td id="td_btn">
                                <a href="<?php echo base_url(); ?>Sanitary/editItemPage/<?php echo $row->san_item_id; ?>" type="button" id="btn_edit_san_item" name="btn_edit_san_item" type="button" class="btn btn-info btn-sm btn_edit_san_item" value="edit" title="Update this item" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $row->san_item_id; ?>)"><i class="fa fa-pencil"></i></a>
                              </td>
                              <td id="td_btn">
                                <a href="<?php echo base_url(); ?>Sanitary/deleteItem/<?php echo $row->san_item_id; ?>" type="button" name="btn_delete_san_item" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                              </td>
                            </tr>
                          <?php
                          } 
                        }else{ echo 'No records found!!!'; } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <button id="btn_add_new_san_item" name="btn_add_new_san_item" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewSanitaryItem" ><i class="fa fa-plus"></i> Add New</button>
                </div><!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
            <?php  
              // view database updated date and time
              if(!empty($this->all_san_items)){
                $item_last_update_dt = strtotime($item_last_update_dt);
                $item_last_update_date = date("j F Y",$item_last_update_dt);
                $item_last_update_time = date("h:i A",$item_last_update_dt);
                echo 'Updated on '.$item_last_update_date.' at '.$item_last_update_time;
              }else{echo 'No records!!!';}
            ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-5 --> <!-- /check for system admin login -->
      <?php } ?> 
      </div> <!-- /main row -->
      <!-- /following bootstrap model used to insert sanitary item status -->
      <div class="modal fade" id="addNewSanitaryDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> සනීපාරක්ෂක තොරතුරු ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_san_info_form", "name" => "insert_san_info_form", "accept-charset" => "UTF-8" );
                  echo form_open("Sanitary/addSanInfo", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="census id">සංඝණන අංකය</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="census_id_select" name="census_id_select" title="Please select">
                            <?php 
                            foreach($this->session as $user_data){
                              if($user_data['userrole']=='School User'){ 
                                echo $census_id = $user_data['census_id']; 
                                echo '<option value="'.$census_id.'" selected>'.$census_id.'</option>';
                              }else{
                            ?>
                                <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                                <?php foreach ($this->all_schools as $row){ ?><!-- from PhysicalResource controller constructor method -->
                                  <option value="<?php echo $row->census_id; ?>"><?php echo $row->census_id; ?></option>
                            <?php } ?> 
                        <?php } 
                            }   ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('census_id'); ?></span>
                          <?php //echo md5(0712636761); ?>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="new item" class="control-label">අයිතමය</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="san_item_select" name="san_item_select">
                            <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                            <?php foreach ($this->all_san_items as $row){ ?> <!-- from PhysicalResource controller constructor method -->
                              <option value="<?php echo $row->san_item_id; ?>"><?php echo $row->san_item_name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="new item" class="control-label">තිබෙන මුළු ප්‍රමාණය</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control" id="quantity_txt" name="quantity_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('working_txt'); ?>" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="new item" class="control-label">භාවිතයට ගත හැකි ප්‍රමාණය</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control" id="usable_txt" name="usable_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('working_txt'); ?>" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="new item" class="control-label">ප්‍රතිසංස්කරණය කළ හැකි ප්‍රමාණය</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control" id="repairable_txt" name="repairable_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('working_txt'); ?>" title="Please type 0, if no repairable quantity." data-toggle="tooltip"/>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_item_info" href="" value="Add_New">Save</a>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
      <!-- /following bootstrap model used to insert sanitary item -->
      <div class="modal fade" id="addNewSanitaryItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> නව අයිතමයක් ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_san_item_form", "name" => "insert_san_item_form", "accept-charset" => "UTF-8" );
                  echo form_open("Sanitary/addSanItem", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new item" class="control-label">අයිතමය</label>
                        </div>
                        <div class="col-lg-9 col-sm-3">
                          <input class="form-control" id="new_item_txt" name="new_item_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('new_item_txt'); ?>" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_item" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
    </div> <!-- /container-fluid -->