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
<style type="text/css">
  th, td { white-space: nowrap; }
</style>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>user">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>physicalResource/viewAddPhysicalResourcePage">Physical Resources</a>
        </li>
        <li class="breadcrumb-item active">Buildings</li>
      </ol>
      <?php
    if($role_id=='1'){  ?>  <!-- check for system admin login -->
      <div class="row" id="search-bar-row">     <!-- search bar is availabel for admin only -->
        <div class="col-lg-12 col-sm-12">
          <div class="row">
            <div class="col-lg-5 col-sm-5">
              <form class="navbar-form" role="search" id="srch_building_info_by_censusid" name="srch_building_info_by_censusid" action="<?php echo base_url(); ?>Building/viewBuildingInfoByCensusId" method="POST">
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
      if(!empty($this->session->flashdata('error'))) {
        $error = $this->session->flashdata('error');  ?>
        <div class="alert alert-danger" ><?php echo $error; ?></div>
    <?php   } ?> 
    <?php 
      if(!empty($this->session->flashdata('msg'))) {
        $message = $this->session->flashdata('msg');  ?>
        <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
    <?php   } ?> 
        <?php 
      if(!empty($this->session->flashdata('repairMsg'))) {
        $message = $this->session->flashdata('repairMsg');  ?>
        <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
    <?php   } ?>  
        <?php 
      if(!empty($this->session->flashdata('toBeRepairedMsg'))) {
        $message = $this->session->flashdata('toBeRepairedMsg');  ?>
        <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
    <?php   } ?>       
      <div class="row" id="building_info_by_censusID">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> ගොඩනැඟිලි තොරතුරු </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">
                    <?php if($userrole=='School User'){
                            echo $school_name; 
                          }else{
                            if(!empty($building_info_by_census)) { 
                              foreach ($building_info_by_census as $row){  
                                $school_name = $row->sch_name;
                              }
                              echo $school_name;
                            }
                          }
                    ?></h5>
                  <h6 align="center">ගොඩනැඟිලි වල තොරතුරු</h6>
                  <?php
                    if(!empty($building_info_by_census)) { ?>
                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th class="col-sm-3">වර්ගය</th>
                          <th class="col-sm-1">මහල් සංඛ්‍යාව</th>
                          <th class="col-sm-3">භාවිතය</th>
                          <th class="col-sm-1">දිග (m)</th>
                          <th class="col-sm-1">පළල (m)</th>
                          <th class="col-sm-4">අධාර ලබාදුන් ආයතනය</th>
                          <th class="col-sm-4">ඉදිකල වර්ෂය</th>
                      <?php if(($role_id=='1') || ($role_id=='2')){ ?>
                            <th class="col-sm-1"></th><th class="col-sm-1"></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($building_info_by_census as $row){  
                          $b_info_id = $row->b_info_id;
                          $census_id = $row->census_id;
                          $b_cat_floor_id = $row->b_cat_floor_id;
                          $b_category = $row->b_cat_name;
                          $b_floor = $row->b_floor;
                          $usage = $row->b_usage;
                          $b_size_id = $row->b_size_id;
                          $b_length = $row->length;
                          $b_width = $row->width;
                          $donatedby = $row->donated_by;
                          $built_year = $row->built_year;
                          $update_dt = $row->last_update;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr>
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $b_category; ?></td>
                          <td style="vertical-align:middle" ><?php echo $b_floor; ?></td>
                          <td style="vertical-align:middle" ><?php echo $usage; ?></td>
                          <td style="vertical-align:middle" ><?php echo $b_length; ?></td>
                          <td style="vertical-align:middle" ><?php echo $b_width; ?></td>
                          <td style="vertical-align:middle" ><?php echo $donatedby; ?></td>
                          <td style="vertical-align:middle" ><?php echo $built_year; ?></td>
                    <?php if(($role_id=='1') || ($role_id=='2')){ ?>
                            <td id="td_btn" style="vertical-align:middle">
                              <a href="<?php echo base_url(); ?>Building/editBuildingInfoPage/<?php echo $b_info_id; ?>" type="button" id="btn_edit_building_info" name="btn_edit_building_info" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this details" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $b_info_id; ?>)"><i class="fa fa-pencil"></i></a>
                            </td>
                            <td id="td_btn" style="vertical-align:middle">
                              <!-- when delete, census id must be sent, since it is used to go back after delete -->
                              <a href="<?php echo base_url(); ?>Building/deleteBuildingInfo/<?php echo $b_info_id; ?>/<?php echo $census_id; ?>" type="button" name="btn_delete_building_info" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this details" onClick="return confirmItemStatusDetailsDelete();"><i class="fa fa-trash-o"></i></a>
                            </td>
                    <?php } ?>
                        </tr>
                  <?php } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php }else{ 
                    if(($userrole=='School User') && empty($building_info_by_census)){
                      echo '<h4 align="center">No Records!!!</h4>'; 
                    }else if(($userrole=='Administrator') && empty($building_info_by_census)){
                      echo '<h4 align="center">Add or Search Records!!!</h4>'; 
                    }else{
                      echo '<h4 align="center">Search Details</h4>';
                    }
                  } ?>
                </div> <!-- /card-body -->
              </div> <!-- /col-lg-12 --> 
              <button id="btn_add_new_building_info" name="btn_add_new_building_info" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewBuildingInfo" ><i class="fa fa-plus"></i> Add New</button>
              <?php 
                if(!empty($building_info_by_census)) {    ?>           
                  <a href="<?php echo base_url(); ?>ExcelExport/printBuildingInfoByCensusId/<?php echo $census_id; ?>" id="btn_print_lib_res_details" name="btn_print_lib_res_details" type="button" class="btn btn-success btn-sm" ><i class="fa fa-print"></i> Save to Print </a>
              <?php } ?>
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php 
                if(!empty($building_info_by_census)) { 
                  $latest_upd_dt = strtotime($latest_upd_dt);
                  $building_update_dt = date("j F Y",$latest_upd_dt);
                  $building_update_tm = date("h:i A",$latest_upd_dt);
                  echo 'Updated on '.$building_update_dt.' at '.$building_update_tm;
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
              <i class="fa fa-table"></i> ගොඩනැඟිලි වල ප්‍රමාණයන්</div>
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
                          <th>දිග</th>
                          <th>පළල</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 0; 
                          $item_last_update_dt = 0;
                          if(!empty($this->all_building_sizes)){
                            foreach ($this->all_building_sizes as $row){
                              $no = $no+1; // from Library controller constructor method
                              $item_update_dt = $row->date_updated;
                              if ($item_last_update_dt < $item_update_dt) {
                                $item_last_update_dt = $item_update_dt;
                              }
                        ?>
                            <tr>
                              <th><?php echo $no; ?></th>
                              <td style="vertical-align:middle"><?php echo $row->length; ?></td>
                              <td style="vertical-align:middle"><?php echo $row->width; ?></td>
                              <td id="td_btn">
                                <a href="<?php echo base_url(); ?>Building/editSize/<?php echo $row->b_size_id; ?>" type="button" id="btn_edit_san_item" name="btn_edit_san_item" type="button" class="btn btn-info btn-sm btn_edit_san_item" value="edit" title="Update this item" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $row->b_size_id; ?>)"><i class="fa fa-pencil"></i></a>
                              </td>
                              <td id="td_btn">
                                <a href="<?php echo base_url(); ?>Building/editSize/<?php echo $row->b_size_id; ?>" type="button" name="btn_delete_san_item" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                              </td>
                            </tr>
                          <?php
                          } 
                        }else{ echo 'No records found!!!'; } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <button id="btn_add_new_building" name="btn_add_new_building" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewBuilding" ><i class="fa fa-plus"></i> Add New</button>
                </div><!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
            <?php  
              // view database updated date and time
              if(!empty($this->all_building_sizes)){
                $item_last_update_dt = strtotime($item_last_update_dt);
                $item_last_update_date = date("j F Y",$item_last_update_dt);
                $item_last_update_time = date("h:i A",$item_last_update_dt);
                echo 'Updated on '.$item_last_update_date.' at '.$item_last_update_time;
              }else{echo 'No records!!!';}
            ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-6 --> 
        <div class="col-lg-6">
          <div class="card mb-3" id="viewBuildingUsageCard">
            <div class="card-header">
              <i class="fa fa-table"></i> ගොඩනැඟිලි වල භාවිතයන්</div>
            <div class="card-body">
              <?php 
                if(!empty($this->session->flashdata('usageMsg'))) {
                  $message = $this->session->flashdata('usageMsg');  ?>
                  <div class="<?php echo $message['class']; ?>"><?php echo $message['text']; ?></div>
              <?php   } ?> 
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <div class="table-responsive">
                    <table id="all_com_res_tbl" class="table table-hover table-striped" cellspacing="0" width="">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>භාවිතය</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 0; 
                          $item_last_update_dt = 0;
                          if(!empty($this->building_usage)){
                            foreach ($this->building_usage as $row){
                              $no = $no+1; // from Building controller constructor method
                              $item_update_dt = $row->date_updated;
                              if ($item_last_update_dt < $item_update_dt) {
                                $item_last_update_dt = $item_update_dt;
                              }
                        ?>
                            <tr>
                              <th><?php echo $no; ?></th>
                              <td style="vertical-align:middle"><?php echo $row->b_usage; ?></td>
                              <td id="td_btn">
                                <a href="<?php echo base_url(); ?>Building/editBuildingUsagePage/<?php echo $row->b_usage_id; ?>" type="button" id="btn_edit_usage" name="btn_edit_usage" type="button" class="btn btn-info btn-sm btn_edit_san_item" value="edit" title="Update this item" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $row->b_usage_id; ?>)"><i class="fa fa-pencil"></i></a>
                              </td>
                              <td id="td_btn">
                                <a href="#" type="button" name="btn_delete_usage" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                              </td>
                            </tr>
                          <?php
                          } 
                        }else{ echo 'No records found!!!'; } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <button id="btn_add_new_usage" name="btn_add_new_usage" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewUsage" ><i class="fa fa-plus"></i> Add New</button>
                </div><!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
            <?php  
              // view database updated date and time
              if(!empty($this->all_building_sizes)){
                $item_last_update_dt = strtotime($item_last_update_dt);
                $item_last_update_date = date("j F Y",$item_last_update_dt);
                $item_last_update_time = date("h:i A",$item_last_update_dt);
                echo 'Updated on '.$item_last_update_date.' at '.$item_last_update_time;
              }else{echo 'No records!!!';}
            ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-6 --> 
      </div> <!-- /main row -->
      <?php } ?>  <!-- /check for system admin login -->
      <!-- /following bootstrap model used to insert sanitary item status -->
      <div class="modal fade" id="addNewBuildingInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> ගොඩනැඟිලි තොරතුරු ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_building_info_form", "name" => "insert_building_info_form", "accept-charset" => "UTF-8" );
                  echo form_open("Building/addBuildingInfo", $attributes);?>
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
                                <?php foreach ($this->all_schools as $row){ ?><!-- from Building controller constructor method -->
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
                          <label for="new category" class="control-label">වර්ගය</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="building_cat_select" name="building_cat_select">
                            <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                            <?php foreach ($this->building_cat_floor as $row){ ?> <!-- from Building controller constructor method -->
                              <option value="<?php echo $row->b_cat_floor_id; ?>"><?php echo $row->b_cat_name.' - '.$row->b_floor; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="new category" class="control-label">භාවිතය</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="usage_select" name="usage_select">
                            <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                            <?php foreach ($this->building_usage as $row){ ?> <!-- from Building controller constructor method -->
                              <option value="<?php echo $row->b_usage_id; ?>"><?php echo $row->b_usage; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="wide" class="control-label">ප්‍රමාණය</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="size_select" name="size_select">
                            <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                            <?php foreach ($this->all_building_sizes as $row){ ?> <!-- from Building controller constructor method -->
                              <option value="<?php echo $row->b_size_id; ?>"><?php echo $row->length.' * '.$row->width.' m<sup>2</sup> '; ?></option>
                            <?php } ?>
                            <option value="" data-toggle="modal" data-target="#addNewSize">නව ප්‍රමාණයක් ඇතුළත් කිරීම</option>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="donated by" class="control-label">ආධාර ලබාදුන් ආයතනය</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control" id="donatedby_txt" name="donatedby_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="donatedby">ඉදිකල වර්ෂය</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input type="text" class="form-control datepicker" id="built_year_txt" name="built_year_txt" value="" />
                        </div>
                      </div> <!-- /row -->
			              </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="donated by" class="control-label"></label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <label class="checkbox-inline">
                            <input type="checkbox" value="" name="repaired_chkbox[]" id="repaired_chkbox"> අළුත්වැඩියා කරන ලදි 
                          </label>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div id="repaired_info_div">
                      <div class="form-group" id="repair">
                        <div class="row" >
                          <div class="col-lg-4 col-sm-4">
                            <label for="donated by" class="control-label" >ආධාර ලබාදුන් ආයතනය</label>
                          </div>
                          <div class="col-lg-8 col-sm-8">
                            <input class="form-control" id="repaired_institute_txt" name="repaired_institute_txt" placeholder="--ඇතුළත් කරන්න--" type="text" value="" title="Please type donated institute" data-toggle="tooltip" />
                          </div>
                        </div> <!-- /row -->
                      </div> <!-- /form group -->
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4 col-sm-4">
                            <label for="repaired date" class="control-label">අළුත්වැඩියා කළ දිනය</label>
                          </div>
                          <div class="col-lg-8 col-sm-8">
                            <input class="form-control datepicker2" id="repaired_date_txt" name="repaired_date_txt" placeholder="--ඇතුළත් කරන්න--" type="text" value="" title="" data-toggle="tooltip"/>
                          </div>
                        </div> <!-- /row -->
                      </div> <!-- /form group -->
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4 col-sm-4">
                            <label for="description" class="control-label">අළුත්වැඩියා විස්තර</label>
                          </div>
                          <div class="col-lg-8 col-sm-8">
                            <textarea class="form-control" rows="2" id="repaired_info_txtarea" name="repaired_info_txtarea"></textarea>
                          </div>
                        </div> <!-- /row -->
                      </div> <!-- /form group -->
                    </div> <!-- /repaired_info_div -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="to be repaired" class="control-label"></label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <label class="checkbox-inline">
                            <input type="checkbox" value="" name="repairable_chkbox[]" id="repairable_chkbox"> අළුත්වැඩියා කල යුතුයි
                          </label>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div id="repairable_info_div">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4 col-sm-4">
                            <label for="repairable part" class="control-label">අළුත්වැඩියා කළ යුතු කොටස</label>
                          </div>
                          <div class="col-lg-8 col-sm-8">
                            <input class="form-control" id="repairable_part_txt" name="repairable_part_txt" placeholder="--ඇතුළත් කරන්න--" type="text" value="" title="" data-toggle="tooltip"/>
                          </div>
                        </div> <!-- /row -->
                      </div> <!-- /form group -->
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4 col-sm-4">
                            <label for="other details" class="control-label">වෙනත් විස්තර</label>
                          </div>
                          <div class="col-lg-8 col-sm-8">
                            <textarea class="form-control" rows="2" id="repairable_info_txtarea" name="repairable_info_txtarea"></textarea>
                          </div>
                        </div> <!-- /row -->
                      </div> <!-- /form group -->
                    </div> <!-- /repairable_info_div -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_building_info" href="" value="Add_New">Save</a>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
      <!-- /following bootstrap model used to insert new building sizes -->
      <div class="modal fade" id="addNewSize" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  $attributes = array("class" => "form-horizontal", "id" => "insert_new_size_form", "name" => "insert_new_size_form", "accept-charset" => "UTF-8" );
                  echo form_open("Building/addNewBuildingSize", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="length" class="control-label">දිග</label>
                        </div>
                        <div class="col-lg-9 col-sm-3">
                          <input class="form-control" id="length_txt" name="length_txt" placeholder="--මීටර් වලින් ඇතුළත් කරන්න--" type="text" value="<?php echo set_value('length_txt'); ?>" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="width" class="control-label">පළල</label>
                        </div>
                        <div class="col-lg-9 col-sm-3">
                          <input class="form-control" id="width_txt" name="width_txt" placeholder="--මීටර් වලින් ඇතුළත් කරන්න--" type="text" value="<?php echo set_value('width_txt'); ?>" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_size" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
      <!-- / .below model used by admin to insert new usage -->
       <div class="modal fade" id="addNewUsage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> නව භාවිතයක් ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_new_usage_form", "name" => "insert_new_usage_form", "accept-charset" => "UTF-8" );
                  echo form_open("Building/addNewBuildingUsage", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="usage" class="control-label">භාවිතය</label>
                        </div>
                        <div class="col-lg-9 col-sm-3">
                          <input class="form-control" id="usage_txt" name="usage_txt" placeholder="--ඇතුළත් කරන්න--" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_usage" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
    </div> <!-- /container-fluid -->
<script type="text/javascript">
	$(document).ready(function() {  
		// date picker used pick the built year of building
		$('.datepicker').datepicker({
			dateFormat: 'yy',
			changeYear: true,
			yearRange:'1955:',
		})
    // date picker 2 used to pick the reperaired date of building
		$('.datepicker2').datepicker({
			dateFormat: 'yy-mm-dd',
			changeYear: true,
			yearRange:'1955:',
		})
	});
</script>