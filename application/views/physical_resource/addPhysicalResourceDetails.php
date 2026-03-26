<style type="text/css">
  tr{ line-height: auto;}
  #all_phy_res th{ vertical-align:middle;} 
  #all_phy_res td{ vertical-align:middle; padding: .1rem;} 
  #all_phy_res #td_btn{text-align: center;}
  #all_phy_res_status th{ vertical-align:middle;} 
  #all_phy_res_status td{ vertical-align:middle; padding: .1rem;} 
  .card-header{background-color:#999999;color: #ffffff;}
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
    $( document ).ready(function() {    
      // following code will display physical resource status according to selected item
      $('#phy_res_item_select').on('change',function(){   
        var item_id = $(this).val();
        //alert(item_id);
        if(item_id==''){
          $('#phy_res_item_status_select').prop('disabled', true);
        }else{
          //alert(item_id);
          $('#phy_res_item_status_select').prop('disabled', false);
          $.ajax({
            url:"<?php echo base_url(); ?>PhysicalResource/viewStatus",
            type:"POST",
            data:{'item_id':item_id},
            dataType:'json',
            success:function(data){
              $('#phy_res_item_status_select').html(data);
            },
            error:function(){
              alert('Error occur!!!');
            }
          });
        }
      });
      $('#all_school_phy_res_details_summary_tbl').DataTable({
        dom: 'Bfrtip',
        buttons: [
          {
            extend: 'excel',
            text: 'Save',
            exportOptions: {
                modifier: {
                    page: 'current'
                }
            }
          }
        ]
      });
    });
    </script>
  <?php
    foreach($this->session as $user_data){
      $userid = $user_data['userid'];
      $userrole = $user_data['userrole'];
      $userrole_id = $user_data['userrole_id'];
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
        <li class="breadcrumb-item active">Physical Resource</li>
      </ol> 
      
  <?php
    if( $userrole_id != '2' ){  ?>  
      <div class="row" id="search-bar-row">     <!-- search bar is not availabel for school users -->
        <div class="col-lg-12 col-sm-12">
          <div class="row">
            <div class="col-lg-2 col-sm-2">
              <form class="navbar-form" role="search" id="srch_phy_res_items_by_censusid" name="srch_phy_res_items_by_censusid" action="<?php echo base_url(); ?>PhysicalResource/viewItemStatusByCensusId" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <input class="form-control form-control-sm" placeholder="Census ID..." name="censusid_txt" id="censusid_txt" type="text" value="<?php echo set_value('censusid_txt'); ?>">
                    <button type="submit" class="btn btn-default input-group-addon btn-sm" name="btn_view_details_by_census" value="View"><i class="fa fa-search"></i></button>
                  </div> <!-- /input-group -->
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->
            <div class="col-lg-2 col-sm-2">
              <form class="navbar-form" role="search" action="<?php echo base_url(); ?>PhysicalResource/viewItemStatusAllSchools" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <input class="form-control form-control-sm" placeholder="View all" name="srch_by_censusid_txt" id="srch_by_censusid_txt" type="text" readonly="true">
                    <button type="submit" class="btn btn-default input-group-addon btn-sm"><i class="fa fa-search"></i></button>
                  </div> <!-- /input-group -->
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->
            <div class="col-lg-2 col-sm-2">
              <form class="navbar-form" role="search" action="<?php echo base_url(); ?>PhysicalResource/viewItemStatusAllSchoolsDivWise" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <select class="form-control form-control-sm" id="edu_div_id" name="edu_div_id" title="Please select">
                    <option value="" selected>Devision</option>
              <?php   foreach ( $this->all_edu_divisions as $row ){ // from PhysicalResource controller constructor method -->
                        if( $row->div_id==101 || $row->div_id==102 ||$row->div_id==103 ){ 
              ?>
                          <option value="<?php echo $row->div_id; ?>"><?php echo $row->div_name; ?></option>
              <?php          
                        }
                      } 
              ?>                                
                    </select>
                    <button type="submit" class="btn btn-default input-group-addon btn-sm"><i class="fa fa-search"></i></button>
                  </div> <!-- /input-group -->
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->
            <div class="col-lg-6 col-sm-6">
              <form class="form-inline"role="search" id="srch_schools_by_item_status" name="srch_schools_by_item_status" action="<?php echo base_url(); ?>PhysicalResource/viewSchoolsByItemStatus" method="POST">
                <div class="form-group col-sm-6">
                  <div class="input-group addon">
                    <select class="form-control form-control-sm" id="phy_res_cat_id" name="select_phy_res_cat_id" title="Please select">
                    <option value="<?php echo set_value('select_phy_res_cat_id'); ?>" selected>View by item</option>
                    <?php foreach ($this->all_items as $row){ ?>
                      <option value="<?php echo $row['phy_res_cat_id']; ?>"><?php echo $row['phy_res_category']; ?></option>
                    <?php } ?>                                
                    </select>
                  </div> <!-- /.input-group addon -->
                </div> <!-- /.form-group -->
                <div class="form-group col-sm-6">
                  <div class="input-group addon">
                    <select class="form-control form-control-sm" id="phy_res_status_id" name="select_phy_res_status_id" title="Please select">
                    <option value="<?php echo set_value('select_phy_res_status_id'); ?>" selected>Status...</option>
                    <?php foreach ($this->all_status as $row){ ?>
                      <option value="<?php echo $row['phy_res_status_id']; ?>"><?php echo $row['phy_res_status_type']; ?></option>
                    <?php } ?>                                
                    </select>
                    <button type="submit" class="btn btn-default input-group-addon btn-sm"><i class="fa fa-search"></i></button>
                  </div> <!-- /.input-group addon -->
                </div> <!-- /.form-group -->
              </form> <!-- /form -->
            </div> <!-- /.col-lg-3 col-sm-3 -->
          </div> <!-- /.row -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / #search-bar-row -->
    <?php } ?>

    <?php
      if(!empty($this->session->flashdata('msg'))) {
        $message = $this->session->flashdata('msg');  ?>
        <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
    <?php } ?>
        <div class="row" id="school_item_status_by_censusID">
          <div class="col-lg-12">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-table"></i> භෞතික සම්පත් තොරතුරු</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 my-auto">
                    <h5 align="center">
                <?php if($userrole == 'School User'){
                        echo $school_name; 
                      }
                ?>
                    </h5>
            <?php
                    if( !empty( $school_item_status_by_census ) ) { // find physical resource item status by census id (school wise)
                      foreach ( $school_item_status_by_census as $row ){  
                        $school_name = $row->sch_name;
                      }
                      // view database updated date and time
                      foreach( $school_item_status_last_update as $row ){
                        $item_status_last_update = $row->date_updated; // from PhysicalResource controller constructor method
                      }
            ?>
                      <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-hover" cellspacing="0" width="">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>අයිතමය</th>
                              <th>තත්ත්වය</th>
                              <th></th>
                      <?php   if($userrole_id=='1'){  ?>
                                <th></th>
                      <?php   } ?>
                            </tr>
                          </thead>
                          <tbody>
                  <?php 
                          $no = 0;
                          foreach ($school_item_status_by_census as $row){  
                            $census_id = $row->census_id;
                            $item_status_details_id = $row->phy_res_detail_id;
                            $item = $row->phy_res_category;
                            $item_status = $row->phy_res_status_type;
                            //$last_update_dt = $row->date_updated;
                            $no = $no + 1;  ?>
                            <tr>
                              <th><?php echo $no; ?></th>
                              <td style="vertical-align:middle"><?php echo $item; ?></td>
                              <td style="vertical-align:middle"><?php echo $item_status; ?></td>
                              <td id="td_btn">
                                <a href="<?php echo base_url(); ?>PhysicalResource/editItemStatusDetailsLoadView/<?php echo $item_status_details_id; ?>" type="button" id="btn_edit_phy_res_status_details" name="btn_edit_phy_res_status_details" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this item" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $item_status_details_id; ?>)"><i class="fa fa-pencil"></i></a>
                              </td>
                      <?php   if($userrole_id=='1'){  ?>
                                <td id="td_btn">
                                  <button href="<?php echo base_url(); ?>PhysicalResource/deleteItemStatusDetails/<?php echo $item_status_details_id; ?>/<?php echo $census_id; ?>" type="button" name="btn_delete_phy_res_status_details" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemStatusDetailsDelete();"><i class="fa fa-trash-o"></i></button>
                                </td>
                      <?php   }  ?>
                            </tr>
                  <?php   } // foreach() ?>
                          </tbody>
                        </table>
                      </div> <!-- /table-responsive -->
              <?php } else{  // if(!empty($school_item_status_by_census)) {
                      if(($userrole=='School User') && empty($school_item_status_by_census)){
                        echo '<h4 align="center">Add Records!!!</h4>'; 
                      }else if(($userrole=='Administrator') && empty($school_item_status_by_census)){
                        echo '<h4 align="center">Add or Search Records!!!</h4>'; 
                      }else{
                        echo '<h4 align="center">Search Details</h4>';
                      }
                    } ?>
                  </div> <!-- /col-lg-12 col-sm-12 -->
                </div> <!-- /row -->  
        <?php   if( $userrole_id == '1' || $userrole_id == '2' ){ ?>
                  <a href="#" id="btn_add_new_details" name="btn_add_new_details" type="button" class="btn btn-primary btn-sm" style="margin-top: 10px;"  data-toggle="modal" data-target="#addNewPhyResDetailsModal"> <i class="fa fa-fw fa-plus mr-1"></i>Add New </a>
        <?php   } ?>          
      <?php   if(!empty($school_item_status_by_census)) {    ?>   
                <a href="<?php echo base_url(); ?>ExcelExport/printPhyResDetailsByCensusId/<?php echo $census_id; ?>" id="btn_add_new_details" name="btn_print_phy_res_info" type="button" class="btn btn-success btn-sm" style="margin-top: 10px;"><i class="fa fa-fw fa-print mr-1"></i> Print</a>    
      <?php   } ?>
              </div> <!-- /card-body -->
              <div class="card-footer small text-muted">
        <?php if( !empty($school_item_status_by_census) ) { 
                $last_update_dt = strtotime($item_status_last_update);
                $phy_res_details_last_updated_on_date = date("j F Y",$last_update_dt);
                $phy_res_details_last_updated_on_time = date("h:i A",$last_update_dt);
                echo 'Updated on '.$phy_res_details_last_updated_on_date.' at '.$phy_res_details_last_updated_on_time;
              }
        ?>
              </div> <!-- /card-footer -->            
            </div> <!-- /card -->
          </div> <!-- /col-lg-12 -->
        </div> <!-- /row #school_item_status_by_censusID -->
<?php
    if(!empty($schools_by_item_status)) { // find school info by item status
      foreach ($schools_by_item_status as $row) {
        $phy_res_category = $row->phy_res_category;
        $status = $row->phy_res_status_type;
      }
?>
      <div class="row" id="school_info_by_item_status">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> භෞතික සම්පත් වලට අනුව පාසල් තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">භෞතික සම්පත් වලට අනුව පාසල් තොරතුරු</h5>
                  <h6 align="center"><?php echo $phy_res_category.' - '.$status; ?></h6>
                  <div class="table-responsive">
                    <table class="table table-hover" id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="">
                      <thead>
                        <tr>
                          <th scope="col" class="">නම</th>
                          <th scope="col" class="">සංඝණන අංකය</th>
                          <th scope="col" class="">විභාග අංකය</th>
                          <th scope="col" class="">දුරකථන අංකය</th>
                          <th scope="col" class="">ලිපිනය</th>
                          <th scope="col" class="">වර්ගය</th>
                          <th scope="col" class="">විද්‍යුත් තැපෑල</th>
                          <th scope="col" class="">ග්‍රාම නි.කො.</th>
                        </tr>
                      </thead>
                      <tbody>
              <?php 
                        $latest_upd_dt = 0;
                        foreach ( $schools_by_item_status as $row ){  
                          $phy_res_cat_id = $row->phy_res_cat_id;
                          $phy_res_status_id = $row->phy_res_status_id;
                          $last_update_dt = $row->details_date_added; 
                          if( $last_update_dt > $latest_upd_dt ){ // get latest update date
                            $latest_upd_dt = $last_update_dt;
                          } 
              ?>
                          <tr>
                            <td style="vertical-align:middle"><?php echo $row->sch_name; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->census_id; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->exam_no; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->contact_no; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->address1,', ',$row->address2; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->sch_type; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->email; ?></td>
                            <td style="vertical-align:middle"><?php echo $row->gs_div_name; ?></td>
                          </tr>
              <?php     } // end foreach ($schools_by_item_status as $row){  ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                </div>
              </div> <!-- /row -->
              <a href="<?php echo base_url(); ?>ExcelExport/printSchoolByItemStatus/<?php echo $phy_res_cat_id; ?>/<?php echo $phy_res_status_id; ?>" id="btn_print_sch_details" name="btn_print_sch_details" type="button" class="btn btn-success mt-2" style="margin-top: 10px;"> Print </a>
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
      </div> <!-- /row #school_info_by_type -->
<?php }   ?> 
      <?php
      if(!empty($all_schools_phy_res_details)) { // find all
      ?>
      <div class="row" id="all_schools_phy_res_details">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> භෞතික සම්පත් තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">සියළුම පාසල් වල</h5>
                  <h6 align="center">භෞතික සම්පත් වල තත්ත්වය</h6>
                  <?php //print_r($this->all_schools); ?>
                  <div class="table-responsive">
                    <table class="table table-hover" id="all_school_phy_res_details_summary_tbl" class="table table-striped table-bordered" cellspacing="0" width="">
                      <thead>
                        <tr>
                          <th scope="col" class="col-sm-1"></th>
                          <th scope="col" class="col-sm-1">පාසල</th>
                          <th scope="col" class="col-sm-1">සංගණන අංකය</th>
                          <th scope="col" class="col-sm-1">වර්ගය</th>
                          <?php  
                            foreach($this->all_items as $row){  ?>
                              <th scope="col" class="col-sm-1"><?php echo $row['phy_res_category']; ?></th>
                          <?php
                            }
                          ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 1;
                        $latest_update_dt=0;
                        foreach ($all_schools_by_item_status as $school_by_item_status) { ?>
                          <?php $census_id1 = $school_by_item_status->census_id; // used in line no 415 ?>
                          <tr>
                                <th scope="row"><?php echo $no; ?></th>
                                <td style="vertical-align:middle"><?php echo $school_by_item_status->sch_name; ?></td>
                                <td style="vertical-align:middle"><?php echo $census_id1; ?></td>
                                <td style="vertical-align:middle"><?php echo $school_by_item_status->sch_type_id; ?></td> 
                          <?php
                                $last_cat_id = 11; // first time $last_cat_id defualt value. this is used to print <td> html tag
                                foreach ($all_schools_phy_res_details as $details){ 
                                  $current_cat_id = $details->phy_res_cat_id; 
                                  $item_status = $details->phy_res_status_type;
                                  $last_update_dt = $details->details_date_updated;
                                  if($last_update_dt > $latest_update_dt){
                                    $latest_update_dt = $last_update_dt;
                                  }
                                  if($census_id1 == $details->census_id){ // school is checked
                                      $current_cat_id = $details->phy_res_cat_id;
                                      for ($i=$last_cat_id; $i < $current_cat_id; $i++) { 
                                          echo '<td>'.'</td>'; // set empty <td> tags
                                      } 
                                      foreach ($this->all_items as $phy_item){ 
                                        if($details->phy_res_cat_id == $phy_item['phy_res_cat_id']){ ?>
                                          <td style="vertical-align:middle"><?php echo $item_status; ?></td>
                                          <?php break; ?>
                                <?php   }
                                      }
                                  $last_cat_id = $current_cat_id+1;  
                                  }
                                }                              
                          echo '</tr>'; $no++; 
                        }   ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                </div>
              </div> 
           
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php  
                //view database updated date and time
                //foreach($school_item_status_last_update as $row){
                  //$item_status_last_update = $row->date_updated; // from PhysicalResource controller constructor method
                //}
                $last_update_dt = strtotime($latest_update_dt);
                $phy_res_details_last_updated_on_date = date("j F Y",$last_update_dt);
                $phy_res_details_last_updated_on_time = date("h:i A",$last_update_dt);
                echo 'Updated on '.$phy_res_details_last_updated_on_date.' at '.$phy_res_details_last_updated_on_time;
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row #find all -->
      <?php } ?>
    <?php if($userrole_id=='1' || $userrole_id=='3'){  ?>  <!-- check for system admin or zonal user login -->
      <div class="row" id="main row">       
        <div class="col-lg-6 col-sm-6">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> භෞතික සම්පත් </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <div class="table-responsive">
                    <table class="table table-hover" id="all_phy_res_tbl" class="table table-striped table-bordered" cellspacing="0" width="">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th scope="col" class="col-sm-9">අයිතමය</th>
                    <?php if($userrole_id=='1' || $userrole_id=='3'){  ?> 
                            <th scope="col" class="col-sm-1"></th>
                            <th scope="col" class="col-sm-1"></th>
                    <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 0; 
                        if(!empty($this->all_items)){
                          foreach ($this->all_items as $row){
                            $no = $no+1; // from PhysicalResource controller constructor method
                            ?>
                            <tr>
                              <th scope="row"><?php echo $no; ?></th>
                              <td style="vertical-align:middle"><?php echo $row['phy_res_category']; ?></td>
                      <?php   if($userrole_id=='1'){  ?> 
                                <td id="td_btn">
                                  <a href="<?php echo base_url(); ?>PhysicalResource/editItemLoadView/<?php echo $row['phy_res_cat_id']; ?>" type="button" id="btn_edit_phy_res" name="btn_edit_phy_res" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this item" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $row['phy_res_cat_id']; ?>)"><i class="fa fa-pencil"></i></a>
                                </td>
                                <td id="td_btn">
                                  <a href="<?php echo base_url(); ?>PhysicalResource/deleteItem/<?php echo $row['phy_res_cat_id']; ?>" type="button" name="btn_delete_phy_res" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                                </td>
                      <?php   } ?>
                              <td id="td_item_id"><span id="<?php $row['phy_res_cat_id']; ?>" name="<?php $row['phy_res_cat_id']; ?>"></span></td>
                            </tr>
                          <?php
                          } 
                        } ?>
                <?php   if( $userrole_id=='1' ){  ?> 
                          <tr>
                            <th scope="row"></th>
                            <td colspan="2">
                              <button id="btn_add_new_phy_res" name="btn_add_new_phy_res" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewPhyResModel" ><i class="fa fa-plus"></i> Add New</button>
                            </td>
                            <td></td>
                            <td></td>
                          </tr>
                <?php   } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                </div><!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
                <?php  
                  // view database updated date and time
                  if(!empty($this->all_items)){
                    $item_upd_dt = 0;
                    foreach ($this->all_items as $row){
                      if($item_upd_dt < $row['date_updated']){
                        $item_upd_dt = $row['date_updated'];
                      }
                    }
                    $phy_res_last_updated_on = strtotime($item_upd_dt);
                    $phy_res_last_updated_on_date = date("j F Y",$phy_res_last_updated_on);
                    $phy_res_last_updated_on_time = date("h:i A",$phy_res_last_updated_on);
                    echo 'Updated on '.$phy_res_last_updated_on_date.' at '.$phy_res_last_updated_on_time;
                  }else{echo 'No records!!!';}
                ?>
            </div>            
          </div> <!-- /card -->            
        </div> <!-- /col-lg-6 col-sm-6 -->
        <div class="col-lg-6">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> තත්ත්වය </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <div class="table-responsive">
                    <table class="table table-hover" id="all_phy_res_status">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th class="col-sm-10">තත්ත්වය</th>
                          <th class="col-sm-2"> කාණ්ඩය </th>
                <?php     if( $userrole_id=='1' ){  ?> 
                            <th scope="col" class="col-sm-1"></th>
                            <th scope="col" class="col-sm-1"></th>
                <?php     } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $no = 0; 
                      if(!empty($this->all_status)){
                        foreach ($this->all_status as $row){
                        $no = $no+1; // from PhysicalResource controller constructor method
                      ?>
                        <tr>
                          <th scope="row"><?php echo $no; ?></th>
                          <td style="vertical-align:middle"><?php echo $row['phy_res_status_type']; ?></td>
                          <td style="vertical-align:middle"><center><?php echo $row['status_group_id']; ?></center></td>
                <?php     if( $userrole_id=='1' ){  ?> 
                            <td id="td_btn">
                              <a href="<?php echo base_url(); ?>PhysicalResource/editStatusLoadView/<?php echo $row['phy_res_status_id']; ?>" type="button" id="btn_edit_status" name="btn_edit_status" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this status" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $row['phy_res_status_id']; ?>)"><i class="fa fa-pencil"></i></a>
                            </td>
                            <td id="td_btn">
                              <a href="<?php echo base_url(); ?>PhysicalResource/deleteStatus/<?php echo $row['phy_res_status_id']; ?>" type="button" name="btn_delete_status" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this status" onClick="return confirmStatusDelete();"><i class="fa fa-trash-o"></i></a>
                            </td>
                <?php     } ?>
                        </tr>
                  <?php
                    } }
                  ?>
                <?php   if( $userrole_id=='1' ){  ?> 
                          <tr>
                            <th scope="row"></th>
                            <td colspan="2">
                              <button id="btn_add_new_phy_res_status" name="btn_add_new_phy_res_status" type="button" class="btn btn-primary btn-sm" value="Add" data-toggle="modal" data-target="#addNewPhyResStatusModel"><i class="fa fa-plus"></i> Add New</button>
                            </td>
                            <td></td>
                          </tr>
                <?php   } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                </div>
              </div>
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php  
                // view database updated date and time
                if(!empty($this->all_status)){
                  $status_upd_dt = 0;
                  foreach ($this->all_status as $row){
                    if($status_upd_dt < $row['date_updated']){
                      $status_upd_dt = $row['date_updated'];
                    } 
                  }
                  $phy_res_last_updated_on = strtotime($status_upd_dt);
                  $phy_res_last_updated_on_date = date("j F Y",$phy_res_last_updated_on);
                  $phy_res_last_updated_on_time = date("h:i A",$phy_res_last_updated_on);
                  echo 'Updated on '.$phy_res_last_updated_on_date.' at '.$phy_res_last_updated_on_time;
                }else{ echo 'No records!!!';}
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-6 --> <!-- /check for system admin login -->
      <?php } ?> 
      </div> <!-- /main row -->
      <div class="modal fade" id="addNewPhyResDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> භෞතික සම්පත් වල තත්ත්වයන් ඇතුළත් කිරීම </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                        $attributes = array("class" => "form-horizontal", "id" => "insert-physical-resource-details", "name" => "insert-physical-resource");
                        echo form_open("PhysicalResource/addPhysicalResourceDetails", $attributes);?>
                      <fieldset>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-3 col-sm-3">
                              <label for="census id">සංඝණන අංකය</label>
                            </div>
                            <div class="col-lg-9 col-sm-9">
                              <select class="form-control" id="census_id_select" name="census_id_select" title="Please select">
                                <?php 
                                foreach($this->session as $user_data){
                                  if($user_data['userrole']=='School User'){ 
                                    $census_id = $user_data['census_id']; 
                                    echo '<option value="'.$census_id.'" selected>'.$census_id.'</option>';
                                  }else{
                                ?>
                                <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                                <?php foreach ($this->all_schools as $row){ ?><!-- from PhysicalResource controller constructor method -->
                                  <option value="<?php echo $row->census_id; ?>"><?php echo $row->census_id; ?></option>
                                <?php } ?> 
                                <?php
                                  }
                                }
                                ?>
                               
                              </select>
                              <span class="text-danger"><?php echo form_error('census_id'); ?></span>
                              <?php //echo md5(0712636761); ?>
                            </div>
                          </div> <!-- /row -->
                        </div> <!-- /form group -->
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-3 col-sm-3">
                              <label for="library item">අයිතමය</label>
                            </div>
                            <div class="col-lg-9 col-sm-9">
                              <select class="form-control" id="phy_res_item_select" name="phy_res_item_select">
                                <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                                <?php foreach ($this->all_items as $row){ ?> <!-- from PhysicalResource controller constructor method -->
                                  <option value="<?php echo $row['phy_res_cat_id']; ?>"><?php echo $row['phy_res_category']; ?></option>
                                <?php } ?>
                              </select>
                              <span class="text-danger"><?php echo form_error('phy_res_item'); ?></span>
                            </div>
                          </div> <!-- /row -->
                        </div> <!-- /form group -->
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-3 col-sm-3">
                              <label for="library item">තත්ත්වය</label>
                            </div>
                            <div class="col-lg-9 col-sm-9">
                              <select class="form-control" id="phy_res_item_status_select" name="phy_res_item_status_select" disabled="">
                                <option value="">අයිතමය තෝරන්න</option>
                              </select>
                              <span class="text-danger"><?php echo form_error('phy_res_item_status'); ?></span>
                            </div>
                          </div> <!-- /row -->
                        </div> <!-- /form group -->
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-3 col-sm-3"></div>
                            <div class="col-lg-9 col-sm-9 ">
                              <input id="btn_insert_phy_res_details" name="btn_insert_phy_res_details" type="submit" class="btn btn-primary mr-2 mt-2" value="Submit" />
                              <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-success mt-2" value="Cancel" style="margin-top: 10px;" data-dismiss="modal"/>
                            </div>
                          </div>
                        </div> <!-- /form group -->
                      </fieldset>
                      <?php echo form_close(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- /addNewPhyResModel -->
      <div class="modal fade" id="addNewPhyResModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> අළුතින් භෞතික සම්පත් ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_new_phy_res_form", "name" => "insert_new_phy_res_form", "accept-charset" => "UTF-8" );
                  echo form_open("PhysicalResource/addPhysicalResource", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new item" class="control-label">නව අයිතමය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="new_phy_res_txt" name="new_phy_res_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('new_phy_res_txt'); ?>" />
                          <span class="text-danger"><?php echo form_error('new_phy_res_txt'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_item" href="" value="Add_New">Save</a>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div>
        </div>
      </div> <!-- /addNewPhyResModel -->
      <!-- This model used to add new physical resource status -->
      <div class="modal fade" id="addNewPhyResStatusModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> අළුතින් භෞතික සම්පත් තත්වයන් ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_new_phy_res_status_form", "name" => "insert_new_phy_res_status_form", "accept-charset" => "UTF-8" );
                  echo form_open("PhysicalResource/addPhysicalResourceStatus", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new item" class="control-label">නව තත්වය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="new_phy_res_status_txt" name="new_phy_res_status_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('new_phy_res_status_txt'); ?>" />
                          <span class="text-danger"><?php echo form_error('new_phy_res_status_txt'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new item" class="control-label">කාණ්ඩය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="status_group_no_txt" name="status_group_no_txt" placeholder="කාණ්ඩ අංකය ඇතුළත් කරන්න" type="text" value="<?php echo set_value('status_group_no_txt'); ?>" />
                          <span class="text-danger"><?php echo form_error('status_group_no_txt'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_status" href="" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div>
        </div>
      </div> <!-- /addNewPhyResStatusModel -->

    </div> <!-- /container-fluid -->
   