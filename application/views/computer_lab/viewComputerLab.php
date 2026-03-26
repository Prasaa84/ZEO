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
<style type="text/css">
    th span{ 
      color:blue; 
      writing-mode: vertical-lr;
      transform: rotate(180deg);
      vertical-align: center;
      min-width: 20px;
      max-height: auto;
      white-space: nowrap; 
    }
    th, td { white-space: nowrap; }
</style>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>user">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Computer Laboratory</li>
      </ol>
      <?php
    if($userrole_id != '2'){  ?>  
      <div class="row" id="search-bar-row">     <!-- search bar is not availabel for school -->
        <div class="col-lg-12 col-sm-12">
          <div class="row mb-1">
            <!-- search school wise -->
            <form class="navbar-form form-inline col-lg-3 col-md-3 col-sm-3" role="search" id="srch_com_lab_item_info_by_censusid" name="srch_com_lab_item_info_by_censusid" action="<?php echo base_url(); ?>ComputerLab/viewItemStatusByCensusId" method="POST">
              <fieldset>
                <div class="form-group">
                  <div class="input-group addon">
                    <input class="form-control form-control-sm col-sm-12" placeholder="School..." name="school_txt" id="school_txt" type="text" value="<?php echo set_value('school_txt'); ?>" title="Type the school name or census id"  data-toggle="tooltip">
                    <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo set_value('census_id_hidden'); ?>">
                    <button type="submit" class="btn btn-default input-group-addon btn-sm" name="btn_view_details_by_census" value="View"><i class="fa fa-search"></i></button>
                  </div> <!-- /input-group -->
                </div>
              </fieldset>
            </form> <!-- /form -->
            <!-- view full report of all schools -->
            <form class="navbar-form form-inline col-lg-8 col-md-8 col-sm-8" role="search" action="<?php echo base_url(); ?>ComputerLab/viewItemStatusAllSchools" method="POST">
              <fieldset>
                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-1 col-sm-1">
                      <label for="Name with ini" class="label label-sm"> Division </label>
                    </div>
                    <div class="col-lg-1 col-sm-1">
                      <select class="form-control form-control-sm" id="edu_div_id_select" name="edu_div_id_select" title="Please select" data-toggle="tooltip">
                        <option value="" selected> සියළුම කොට්ඨාස </option>
                <?php   foreach ($this->all_edu_divisions as $row){ //  from ComputerLab controller constructor method 
                          if( $row->div_id==101 || $row->div_id==102 ||$row->div_id==103 ){ 
                ?>
                            <option value="<?php echo $row->div_id; ?>"><?php echo $row->div_name; ?></option>
                <?php
                          }
                ?>
                <?php   } ?>                                
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-1 col-sm-1">
                      <label for="Name with ini"> Status </label>
                    </div>
                    <div class="col-lg-1 col-sm-1">
                      <select class="form-control form-control-sm" id="status_select" name="status_select" title="Please select" data-toggle="tooltip">
                        <option value="q" selected> තිබෙන ප්‍රමාණය  </option>
                        <option value="w" > ක්‍රියාකාරී සංඛ්‍යාව </option>
                        <option value="r" > සකස් කල හැකි ප්‍රමාණය  </option>
                        <option value="nr" > සකස් කල නොහැකි ප්‍රමාණය </option>
                      </select>
                    </div>
                  </div> <!-- /row -->
                  <div class="row">
                    <div class="col-lg-1 col-sm-1">
                      <label for="Name with ini">  </label>
                    </div>
                    <div class="col-lg-1 col-sm-1">
                        <!-- Show button -->
                      <button id="btn_view_status" name="btn_view_status" type="submit" class="btn btn-primary mr-1 btn-sm mb-1" value="Show"><i class="fa fa-fw fa-eye mr-1"> </i>Show</button>
                    </div>
                  </div>
                </div> <!-- /form-group -->
              </fieldset>
            </form> <!-- /form -->

          </div> <!-- /.row -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / #search-bar-row -->
    <?php } ?>

<?php
    if( !empty( $all_schools_com_lab_info ) ) { // find all
      $status_id = $status;
      switch ( $status_id ) {
        case 'w':
          $detail_status = ' ක්‍රියාකාරී සංඛ්‍යාව ';
          break;
        case 'r':
          $detail_status = 'සකස්කල හැකි ප්‍රමාණය';
          break;
        case 'nr':
          $detail_status = 'සකස්කල නොහැකි ප්‍රමාණය';
          break;
        default:
          $detail_status = 'තිබෙන ප්‍රමාණය ';
          break;
      }
      ?>
      <div class="row" id="all_schools_computer_lab_details">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> පරිගණක තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">සියළුම පාසල් වල</h5>
                  <h6 align="center">පරිගනක සම්පත් - <?php echo $detail_status; ?> </h6>
                  <?php //print_r($this->all_schools); ?>
                  <div class="table-responsive">
                    <table class="table table-hover" id="dataTableAllSchools" class="" cellspacing="0" width="">
                      <thead>
                        <tr>
                          <th scope="col" class="col-sm-1" ></th>
                          <th scope="col" class="col-sm-1" >පාසල</th>
                          <th scope="col" class="col-sm-1" ><span>සංගණන අංකය</span></th>
                          <th scope="col" class="col-sm-1" ><span>පාසල් වර්ගය</span></th>
                    <?php  
                            $resource_count = 0;
                            foreach( $this->all_com_res_items as $row ){  
                              //$last_item = $row->com_lab_res_id;
                              $resource_count += 1;
                    ?>
                              <th scope="col" class="col-sm-1" width=100 ><span><?php echo  $row->com_lab_res_type; ?></span></th>
                    <?php   }   ?>
                        </tr>
                      </thead>
                      <tbody>
                  <?php 
                        $no = 1;
                        $latest_update_dt=0;
                        foreach ( $all_schools as $school ) { ?>
                    <?php $census_id1 = $school->census_id; // used in line no 415 ?>
                          <tr>
                            <td><?php echo $no; ?></td>
                            <td style="vertical-align:middle"><?php echo $school->sch_name; ?></td>
                            <td style="vertical-align:middle"><?php echo $census_id1; ?></td>
                            <td style="vertical-align:middle"><center><?php echo $school->sch_type_id; ?></center></td> 
                    <?php
                            $last_order_id = 1; 
                            foreach ( $all_schools_com_lab_info as $details ){ 
                              $resource_id = $details->com_lab_res_id; 

                              $status_id = $status;
                              switch ( $status_id ) {
                                case 'q': // තිබෙන ප්‍රමාණය
                                  $quantity = $details->quantity;
                                  break;
                                case 'w':  // ක්‍රියාකාරී සංඛ්‍යාව 
                                  $quantity = $details->working;
                                  break;
                                case 'r':  // අළුත්වැඩියා කල හැකි ප්‍රමාණය
                                  $quantity = $details->repairable;
                                  break;
                                case 'nr': // අළුත්වැඩියා කල නොහැකි ප්‍රමාණය
                                  $quantity = $details->quantity - ( $details->working + $details->repairable );
                                  break;
                              }
                              $current_order_id = $details->order_id;

                              $last_update_dt = $details->details_date_updated;
                              if( $last_update_dt > $latest_update_dt ){
                                $latest_update_dt = $last_update_dt;
                              }
                              if( $census_id1 == $details->census_id ){ // school match with resource details
                                  for ( $i=$last_order_id; $i < $current_order_id; $i++ ) { 
                                      echo '<td></td>'; // set empty <td> tags
                                  } 
                                  foreach ( $this->all_com_res_items as $com_item ){ 
                                    if( $details->com_lab_res_id == $com_item->com_lab_res_id ){ ?>
                                      <td style="vertical-align:middle"><center><?php echo $quantity; ?></center></td>
                            <?php   }
                                  }
                                $last_order_id = $current_order_id + 1;  
                              }else{
                                //if($last_order_id != $current_order_id){
                                  //for( $a=$last_order_id; $a <= $resource_count; $a++ ) { 
                                     //echo '<td></td>';
                                  //}
                                //}
                                //echo '</tr>'; 
                                //$last_order_id = $current_order_id + 1;  

                              }
                            }                              
                          echo '</tr>'; 
                          $no++; 
                        }   ?>
                        <tr>
                          <td colspan="4">ඒකතුව</td>
                <?php       $last_order_id_of_all = 1;

                              foreach ( $all_schools_com_lab_item_total as $available_item ) {

                                $current_order_id_of_all = $available_item->order_id;
                                for ( $i=$last_order_id_of_all; $i < $current_order_id_of_all; $i++ ) { 
                                  echo '<td><center></center></td>'; // set empty <td> tags
                                }
                                foreach( $this->all_com_res_items as $all_items ){  
                                  if( $available_item->com_lab_res_id == $all_items->com_lab_res_id ){
                                    echo '<td><center>'.$available_item->total.'</center></td>';
                                    break;
                                  }
                                }
                                $last_order_id_of_all = $current_order_id_of_all + 1;  
                              }
                                             
                ?>      </tr>
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
                $latest_update_dt = strtotime($latest_update_dt);
                $phy_res_details_last_updated_on_date = date("j F Y",$latest_update_dt);
                $phy_res_details_last_updated_on_time = date("h:i A",$latest_update_dt);
                echo 'Updated on '.$phy_res_details_last_updated_on_date.' at '.$phy_res_details_last_updated_on_time;
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row #find all -->
<?php } ?>

  <?php 
        if(!empty($this->session->flashdata('msg'))) {
          $message = $this->session->flashdata('msg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
 <?php  } ?>      
      <div class="row" id="com_lab_res_status_by_censusID">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> පරිගණක ඒකකයේ තොරතුරු </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">
            <?php   if( $userrole=='School User' ){
                            echo $school_name; 
                    }else{
                      if( !empty( $com_lab_info_by_census ) ) { 
                        foreach ( $com_lab_info_by_census as $row ){  
                          $school_name = $row->sch_name;
                        }
                        echo $school_name;
                      }
                    }
            ?>
                  </h5>
                  <h6 align="center">පරිගණක ඒකකයේ තොරතුරු</h6>
            <?php
                  if(!empty($com_lab_info_by_census)) { ?>

                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th >#</th>
                          <th class="col-sm-4">අයිතමය</th>
                          <th class="col-sm-2">තිබෙන සංඛ්‍යාව</th>
                          <th class="col-sm-2">ක්‍රියාකාරී සංඛ්‍යාව</th>
                          <th class="col-sm-2">සකස්කල හැකි ප්‍රමාණය</th>
                          <th class="col-sm-2">සකස්කල නොහැකි ප්‍රමාණය</th>
                          <?php if(($userrole=='School User') || ($userrole=='Administrator')){ ?>
                            <th class="col-sm-1"></th><th class="col-sm-1"></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($com_lab_info_by_census as $row){  
                          $com_lab_res_info_id = $row->com_lab_res_info_id;
                          $census_id = $row->census_id;
                          $item = $row->com_lab_res_type;
                          $quantity = $row->quantity;
                          $working = $row->working;
                          $repairable = $row->repairable;
                          $not_repairable = $quantity - ($working + $repairable);
                          $update_dt = $row->last_update;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr>
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $item; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $quantity; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $working; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $repairable; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $not_repairable; ?></td>
                    <?php if(($userrole=='School User') || ($userrole=='Administrator')){ ?>
                            <td id="td_btn" style="vertical-align:middle">
                              <a href="<?php echo base_url(); ?>ComputerLab/editItemStatusDetailsPage/<?php echo $com_lab_res_info_id; ?>" type="button" id="btn_edit_com_res_status_details" name="btn_edit_com_res_status_details" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this details" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $com_lab_res_info_id; ?>)"><i class="fa fa-pencil"></i></a>
                            </td>
                            <td id="td_btn" style="vertical-align:middle">
                              <a href="<?php echo base_url(); ?>ComputerLab/deleteItemStatusDetails/<?php echo $com_lab_res_info_id; ?>/<?php echo $census_id; ?>" type="button" name="btn_delete_com_res_status_details" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this details" onClick="return confirmItemStatusDetailsDelete();"><i class="fa fa-trash-o"></i></a>
                            </td>
                    <?php } ?>
                        </tr>
                  <?php } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php } else{ 
                    if(($userrole=='School User') && empty($com_lab_info_by_census)){
                      echo '<h4 align="center">Add Records!!!</h4>'; 
                    }else if(($userrole=='Administrator') && empty($com_lab_info_by_census)){
                      echo '<h4 align="center">Add or Search Records!!!</h4>'; 
                    }else{
                      echo '<h4 align="center">Search Details</h4>';
                    }
                  } ?>
                </div>
              </div>  <!-- /row -->
              <button id="btn_add_new_com_res_info" name="btn_add_new_com_res_info" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewComLabResInfo" ><i class="fa fa-plus"></i> Add New</button>
              <?php 
                if(!empty($com_lab_info_by_census)) {    ?>           
                  <a href="<?php echo base_url(); ?>ExcelExport/printComResInfoByCensusId/<?php echo $census_id; ?>" id="btn_print_com_res_details" name="btn_print_com_res_details" type="button" class="btn btn-success btn-sm" ><i class="fa fa-print"></i> Save to Print </a>
              <?php } ?>
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php 
                if(!empty($com_lab_info_by_census)) { 
                  $latest_upd_dt = strtotime($latest_upd_dt);
                  $com_lab_update_dt = date("j F Y",$latest_upd_dt);
                  $com_lab_update_tm = date("h:i A",$latest_upd_dt);
                  echo 'Updated on '.$com_lab_update_dt.' at '.$com_lab_update_tm;
                }
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row #com_lab_res_status_by_censusID -->
      <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login --> 
      <div class="row">        
        <div class="col-lg-6">
          <div class="card mb-3" id="viewItemsCard">
            <div class="card-header">
              <i class="fa fa-table"></i> පරිගණක ඒකකයක සතු සම්පත් </div>
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
                          if(!empty($this->all_com_res_items)){
                            foreach ($this->all_com_res_items as $row){
                              $no = $no+1; // from ComputerLab controller constructor method
                              $item_update_dt = $row->date_updated;
                              if ($item_last_update_dt < $item_update_dt) {
                                $item_last_update_dt = $item_update_dt;
                              }
                        ?>
                            <tr>
                              <th><?php echo $no; ?></th>
                              <td style="vertical-align:middle"><?php echo $row->com_lab_res_type; ?></td>
                              <td id="td_btn">
                                <a href="<?php echo base_url(); ?>ComputerLab/editItemPage/<?php echo $row->com_lab_res_id; ?>" type="button" id="btn_edit_phy_res" name="btn_edit_phy_res" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this item" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $row->com_lab_res_id; ?>)"><i class="fa fa-pencil"></i></a>
                              </td>
                              <td id="td_btn">
                                <a href="<?php echo base_url(); ?>ComputerLab/deleteItem/<?php echo $row->com_lab_res_id; ?>" type="button" name="btn_delete_phy_res" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                              </td>
                            </tr>
                          <?php
                          } 
                        }else{ echo 'No records found!!!'; } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <button id="btn_add_new_phy_res" name="btn_add_new_phy_res" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewComLabItem" ><i class="fa fa-plus"></i> Add New</button>
                </div><!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
            <?php  
              // view database updated date and time
              if(!empty($this->all_com_res_items)){
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
      <!-- /following bootstrap model used to insert computer lab resources status -->
      <div class="modal fade" id="addNewComLabResInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> පරිගණක ඒකකයේ තොරතුරු ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_com_lab_res_info_form", "name" => "insert_com_lab_res_info_form", "accept-charset" => "UTF-8" );
                  echo form_open("computerLab/addComResInfo", $attributes);?>
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
                                <?php foreach ($this->all_schools as $row){ ?><!-- from ComputerLab controller constructor method -->
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
                          <select class="form-control" id="com_res_item_select" name="com_res_item_select">
                            <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                            <?php foreach ($this->all_com_res_items as $row){ ?> <!-- from ComputerLab controller constructor method -->
                              <option value="<?php echo $row->com_lab_res_id; ?>"><?php echo $row->com_lab_res_type; ?></option>
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
                          <input class="form-control" id="quantity_txt" name="quantity_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('not_working_txt'); ?>" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="new item" class="control-label">ක්‍රියාකාරී සංඛ්‍යාව</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control" id="working_txt" name="working_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('working_txt'); ?>" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="new item" class="control-label">නැවත සකස් කළ හැකි ප්‍රමාණය</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control" id="repairable_txt" name="repairable_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('repairable_txt'); ?>" />
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
      <!-- /following bootstrap model used to insert computer lab item -->
      <div class="modal fade" id="addNewComLabItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  $attributes = array("class" => "form-horizontal", "id" => "insert_com_lab_item_form", "name" => "insert_com_lab_item_form", "accept-charset" => "UTF-8" );
                  echo form_open("computerLab/addComResItem", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new item" class="control-label">අයිතමය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
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
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $( document ).ready(function() {    
    $('#dataTableAllSchools').DataTable({
      fixedHeader: true,
      dom: 'Bfrtip',
      //"pageLength": 25,
      buttons: [
        {
          extend: 'excel',
          text: 'Save',
          exportOptions: {
              modifier: {
                  page: 'all'
              }
          }
        }
      ],
      paging: false,      
      scrollY: "500px",
          fixedColumns: {
            leftColumns:1
          },
          // fixedHeader: {
          //   header: true,
          //   headerOffset: 45,
          // },
          //scrollX: true   
    });
    // auto complete when type school name
    $( "#school_txt" ).autocomplete({
      source: function( request, response ) {
        // Fetch data
        $.ajax({
          url: "<?=base_url()?>School/viewSchoolList",
          type: 'post',
          dataType: "json",
          data: {
            search: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
      //appendTo: "#school_txt",
      select: function (event, ui) {
        // Set selection
        $('#school_txt').val(ui.item.label); // display the selected text
        $('#census_id_hidden').val(ui.item.value); // save selected id to input
        //alert(ui.item.value);
        return false;
      }
    });

    // clear school name when click on it
    $('#school_txt').focus(function() {
        $(this).val('');
    });

  });
</script>