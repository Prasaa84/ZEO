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
      $userrole_id = $user_data['userrole_id'];
    }
  ?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>user">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Find Schools</li>
      </ol>
      <div class="row">
        <div class="col-xl-2 col-sm-2 mb-2">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-building"></i>
              </div>
              <div class="mr-5">
                 All Schools <br>
                 <h1 align="center"> <?php echo $this->no_of_schools; ?> </h1>
              </div>
            </div>
          </div> <!-- /Card Messages-->
        </div> <!-- /col-xl-3 col-sm-6 mb-3-->
        <div class="col-xl-2 col-sm-2 mb-2">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-building"></i>
              </div>
              <div class="mr-5">
                National <br>
                 <h1 align="center"> <?php echo $this->no_of_national_schools; ?> </h1>
              </div>
            </div>
          </div> <!-- /Card Messages-->
        </div> <!-- /col-xl-3 col-sm-6 mb-3-->
        <div class="col-xl-2 col-sm-2 mb-2">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-building"></i>
              </div>
              <div class="mr-5">
                 1 AB <br>
                 <h1 align="center">
              <?php echo $this->no_of_1AB_schools; ?>  
                 </h1>
              </div>
            </div>
          </div><!-- /card-->
        </div>
        <div class="col-xl-2 col-sm-2 mb-2">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-building"></i>
              </div>
              <div class="mr-5">
                 1C Schools <br>
                 <h1 align="center"> <?php echo $this->no_of_1C_schools; ?> </h1>
              </div>
            </div>
          </div><!-- /card-->
        </div>
        <div class="col-xl-2 col-sm-2 mb-2">
          <div class="card text-white bg-secondary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-building"></i>
              </div>
              <div class="mr-5">
                 Type 2  <br>
                 <h1 align="center"> <?php echo $this->no_of_type2_schools; ?> </h1>
              </div>
            </div>
          </div><!-- /card-->
        </div>
        <div class="col-xl-2 col-sm-2 mb-2">
          <div class="card text-white bg-secondary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-building"></i>
              </div>
              <div class="mr-5">
                 Type 3  <br>
                 <h1 align="center"> <?php echo $this->no_of_type3_schools; ?> </h1>
              </div>
            </div>
          </div><!-- /card-->
        </div>
      </div><!-- /row1-->
      <div class="row" id="search-bar-row">    
        <div class="col-lg-12 col-sm-12">
          <div class="row">
            <div class="col-lg-3 col-sm-3">
              <form class="navbar-form" role="search" id="srch_sch_by_censusid" name="srch_sch_by_censusid" action="<?php echo base_url(); ?>School/findSchoolByCensusId" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <input class="form-control form-control-sm" placeholder="School Name or Census ID..." name="school_txt" id="school_txt" type="text" value="<?php echo set_value('censusid_txt'); ?>">
                    <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="">
                    <button type="submit" class="btn btn-default input-group-addon" name="btn_view_sch_by_censusid" value="View"><i class="fa fa-search"></i></button>
                  </div> <!-- /input-group -->
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->
  <?php   if($userrole_id==1){ ?>
            <div class="col-lg-2 col-sm-2">
              <form class="navbar-form" role="search" id="srch_sch_by_edu_div" name="srch_sch_by_edu_div" action="<?php echo base_url(); ?>School/findSchoolsByEduDiv" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <select class="form-control form-control-sm" id="select_edu_div" name="select_edu_div" title="Please select">
                    <option value="" selected>Devision</option>
                      <?php foreach ($this->all_edu_div as $row){ ?><!-- from School controller constructor method -->
                      <option value="<?php echo $row->div_id; ?>"><?php echo $row->div_name; ?></option>
                      <?php } ?>                                
                    </select>
                    <button type="submit" class="btn btn-default input-group-addon" name="btn_view_sch_by_edu_div" value="View"><i class="fa fa-search"></i></button>
                  </div> <!-- /input-group -->
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->
  <?php   }    ?>
            <div class="col-lg-2 col-sm-2">
              <form class="navbar-form" role="search" id="srch_sch_by_sch_type" name="srch_sch_by_sch_type" action="<?php echo base_url(); ?>School/findSchoolsByType" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <select class="form-control form-control-sm" id="select_sch_type" name="select_sch_type" title="Please select">
                    <option value="" selected>Type</option>
                    <?php foreach ($this->all_sch_types as $row){ ?>
                      <option value="<?php echo $row->sch_type_id; ?>"><?php echo $row->sch_type; ?></option>
                    <?php } ?>                                
                    </select>
                    <button type="submit" class="btn btn-default input-group-addon" name="btn_view_sch_by_type" value="View"><i class="fa fa-search"></i></button>
                  </div> <!-- /.input-group addon -->
                </div> <!-- /.form-group -->
              </form> <!-- /form -->
            </div> <!-- /.col-lg-3 col-sm-3 -->
            <div class="col-lg-5 col-sm-5">
              <form class="form-inline" role="search" id="srch_all_sch" name="srch_all_sch" action="<?php echo base_url(); ?>School/findAllSchools" method="POST">
                <div class="form-group">
                <div class="input-group addon">
                  <input class="form-control form-control-sm" placeholder="View all" name="srch_all_sch_txt" id="srch_all_sch_txt" type="text" readonly="true">
                  <button type="submit" class="btn btn-default input-group-addon" name="btn_view_all_sch" value="View"><i class="fa fa-search"></i></button>
                </div> <!-- /input-group -->
                <div class="form-check mb-2 mr-sm-2 ml-2">
                  <input class="form-control form-control-sm form-check-input" type="checkbox" id="checkOrderByDivision" name="checkOrderByDivision" value="1">
                  <label class="form-check-label" for="inlineFormCheck">
                      Order by Division</label>
                </div>
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->
          </div> <!-- /.row -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / #search-bar-row -->
    <?php
      if(!empty($this->session->flashdata('msg'))) {
        $message = $this->session->flashdata('msg');  ?>
        <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
    <?php } ?>
    <?php
      if(!empty($school_info_by_census)) { // find school info by census id
        foreach ($school_info_by_census as $row){  
          $school_name = $row->sch_name;
        } ?>
      <div class="row" id="school_info_by_censusID">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> පාසලේ තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-10 col-sm-10 my-auto" align="center">
                  <h5 align="center"><?php echo $school_name; ?></h5>
                  <h6 align="center">පාසලේ තොරතුරු</h6>
                  <center>
                  <div class="table-responsive">
                    <table width="800" class="table table-hover" id="sch_info_tbl" class="table table-striped table-bordered" cellspacing="0">
                      <thead>
                        <tr>
                          <th scope="col" class="col-sm-2"></th>
                          <th scope="col" class="col-sm-4"></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        foreach ($school_info_by_census as $row){  
                          $census_id = $row->census_id;
                          $exam_no  = $row->exam_no;
                          $sch_name = $row->sch_name;
                          $address1 = $row->address1;
                          $address2 = $row->address2;
                          $contact_no = $row->contact_no;
                          $email = $row->email;
                          $web_address = $row->web_address;
                          $gs_div = $row->gs_name_si;
                          $edu_div = $row->div_name;
                          $sch_type = $row->sch_type;
                          $last_update_dt = $row->school_details_upd_dt;
                          $userid = $row->user_id;
                          }   ?>
                        <tr>
                          <td style="vertical-align:middle">සංඝණන අංකය</td>
                          <td style="vertical-align:middle"><?php echo $census_id; ?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align:middle">විභාග අංකය</td>
                          <td style="vertical-align:middle"><?php echo $exam_no; ?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align:middle">ලිපිනය</td>
                          <td style="vertical-align:middle"><?php echo $address1,', ',$address2; ?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align:middle">දුරකථන අංකය</td>
                          <td style="vertical-align:middle"><?php echo $contact_no; ?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align:middle">විද්‍යුත් තැපෑල</td>
                          <td style="vertical-align:middle"><?php echo $email; ?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align:middle">වෙබ් ලිපිනය</td>
                          <td style="vertical-align:middle"><?php echo $web_address; ?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align:middle">ග්‍රාම නිළධාරී කොට්ඨාසය</td>
                          <td style="vertical-align:middle"><?php echo $gs_div; ?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align:middle">අධ්‍යාපන කොට්ඨාසය</td>
                          <td style="vertical-align:middle"><?php echo $edu_div; ?></td>
                        </tr>
                        <tr>
                          <td style="vertical-align:middle">පාසල් වර්ගය</td>
                          <td style="vertical-align:middle"><?php echo $sch_type; ?></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>
                            <a href="<?php echo base_url(); ?>ExcelExport/printSchoolById/<?php echo $census_id; ?>" id="btn_print_sch_details" name="btn_print_sch_details" type="button" class="btn btn-success mt-2" style="margin-top: 10px;"> Print </a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                </center>
                </div>
              </div> 
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php  
                $last_update_dt = strtotime($last_update_dt);
                $sch_last_updated_on_date = date("j F Y",$last_update_dt);
                $sch_last_updated_on_time = date("h:i A",$last_update_dt);
                echo 'Updated on '.$sch_last_updated_on_date.' at '.$sch_last_updated_on_time;
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row #school_info_by_censusID -->
  <?php   }   ?> 
      <?php
      if(!empty($school_info_by_division)) { // find school info by census id
        foreach ($school_info_by_division as $row){  
          $div_name = $row->div_name;
        } ?>
      <div class="row" id="school_info_by_division">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> <?php echo $div_name; ?> කොට්ඨාසයේ පාසැල් තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center"><?php echo $div_name; ?> කොට්ඨාසයේ</h5>
                  <h6 align="center">පාසල් තොරතුරු</h6>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th scope="col" class="">නම</th>
                          <th scope="col" class="">සංඝණන අංකය</th>
                          <th scope="col" class="">විභාග අංකය</th>
                          <th scope="col" class="">දුරකථන අංකය</th>
                          <th scope="col" class="">ලිපිනය</th>
                          <th scope="col" class="">වර්ගය</th>
                          <th scope="col" class="">විද්‍යුත් තැපෑල</th>
                          <th scope="col" class="">ග්‍රාම නි.කො.</th>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <th></th><th></th>
                    <?php } ?>                        
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $x = 1;
                        $latest_upd_dt = 0;
                        foreach ($school_info_by_division as $row){  
                          $last_update_dt = $row->school_details_upd_dt; 
                          if($last_update_dt > $latest_upd_dt){ // get latest update date
                            $latest_upd_dt = $last_update_dt;
                          }
                      ?>
                        <tr>
                          <td><?php echo $x; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_name; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->census_id; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->exam_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->contact_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->address1,', ',$row->address2; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_type; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->email; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->gs_name_si; ?></td>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/viewUpdateSchoolPageByAdmin/<?php echo $row->census_id; ?>" type="button" id="btn_update_school" name="btn_update_school" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="Update" title="Update school" data-toggle="tooltip" data-hidden=""><i class="fa fa-pencil"></i></a>
                          </td>
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/deleteSchool/<?php echo $row->census_id; ?>" type="button" name="btn_update_school" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                          </td>
                    <?php $x++; } ?>
                        </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <a href="<?php echo base_url(); ?>ExcelExport/printSchoolByDiv/<?php echo $row->edu_div_id; ?>" id="btn_print_sch_details" name="btn_print_sch_details" type="button" class="btn btn-success mt-2" style="margin-top: 10px;"> Print </a>
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
      </div> <!-- /row #school_info_by_division -->
  <?php   }   ?> 
  <?php
      if(!empty($school_info_by_type)) { // find school info by type
        foreach ($school_info_by_type as $row){  
          $sch_type = $row->sch_type;
        } ?>
      <div class="row" id="school_info_by_type">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> <?php echo $sch_type; ?> පාසල් තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">පාසල් තොරතුරු</h5>
                  <h6 align="center">වර්ගය - <?php echo $sch_type; ?></h6>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th scope="col" class="">නම</th>
                          <th scope="col" class="">සංඝණන අංකය</th>
                          <th scope="col" class="">විභාග අංකය</th>
                          <th scope="col" class="">දුරකථන අංකය</th>
                          <th scope="col" class="">ලිපිනය</th>
                          <th scope="col" class="">වර්ගය</th>
                          <th scope="col" class="">විද්‍යුත් තැපෑල</th>
                          <th scope="col" class="">ග්‍රාම නි.කො.</th>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <th></th><th></th>
                    <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $x = 1;
                        $latest_upd_dt = 0;
                        foreach ($school_info_by_type as $row){  
                          $last_update_dt = $row->school_details_upd_dt; 
                          if($last_update_dt > $latest_upd_dt){ // get latest update date
                            $latest_upd_dt = $last_update_dt;
                          } ?>
                        <tr>
                          <td><?php echo $x; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_name; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->census_id; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->exam_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->contact_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->address1,', ',$row->address2; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_type; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->email; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->gs_name_si; ?></td>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/viewUpdateSchoolPageByAdmin/<?php echo $row->census_id; ?>" type="button" id="btn_update_school" name="btn_update_school" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="Update" title="Update school" data-toggle="tooltip" data-hidden=""><i class="fa fa-pencil"></i></a>
                          </td>
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/deleteSchool/<?php echo $row->census_id; ?>" type="button" name="btn_update_school" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                          </td>
                    <?php } ?>
                        </tr>
                      <?php $x++;} ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <a href="<?php echo base_url(); ?>ExcelExport/printSchoolByType/<?php echo $row->sch_type_id; ?>" id="btn_print_sch_details" name="btn_print_sch_details" type="button" class="btn btn-success mt-2" style="margin-top: 10px;"> Print </a>
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
      </div> <!-- /row #school_info_by_type -->
  <?php   }   ?> 
  <?php
      if(!empty($all_school_info)) { // find all schools info
  ?>
      <div class="row" id="all_school_info">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> සියළුම පාසල් තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center"> සියළුම පාසල් තොරතුරු</h5>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th scope="col" class="">නම</th>
                          <th scope="col" class="">සංඝණන අංකය</th>
                          <th scope="col" class="">විභාග අංකය</th>
                          <th scope="col" class="">දුරකථන අංකය</th>
                          <th scope="col" class="">ලිපිනය</th>
                          <th scope="col" class="">වර්ගය</th>
                          <th scope="col" class="">විද්‍යුත් තැපෑල</th>
                          <th scope="col" class="">අධ්‍යාපන කොට්ඨාසය</th>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                            <th></th><th></th> 
                    <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $x=1;
                        $latest_upd_dt = 0;
                        foreach ($all_school_info as $row){  
                          $last_update_dt = $row->school_details_upd_dt; 
                          if($last_update_dt > $latest_upd_dt){
                            $latest_upd_dt = $last_update_dt;
                          } 
                        ?>
                        <tr>
                          <td><?php echo $x; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_name; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->census_id; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->exam_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->contact_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->address1,', ',$row->address2; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_type; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->email; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->div_name; ?></td>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/viewUpdateSchoolPageByAdmin/<?php echo $row->census_id; ?>" type="button" id="btn_update_school" name="btn_update_school" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="Update" title="Update school" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $row->census_id; ?>)"><i class="fa fa-pencil"></i></a>
                          </td>
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/deleteSchool/<?php echo $row->census_id; ?>" type="button" name="btn_update_school" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                          </td>
                    <?php } ?>
                        </tr>
                      <?php $x = $x+1; } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <a href="<?php echo base_url(); ?>ExcelExport/printAllSchools" id="btn_print_sch_details" name="btn_print_sch_details" type="button" class="btn btn-success mt-2" style="margin-top: 10px;"> Print </a>
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
      </div> <!-- /row #all_school_info -->
  <?php    }   ?> 
  <?php
      if(!empty($national_school_info)) { // find school info by census id
  ?>
      <div class="row" id="national_school_info">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> ජාතික පාසල් තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center"> ජාතික පාසල් තොරතුරු</h5>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th scope="col" class="">නම</th>
                          <th scope="col" class="">සංඝණන අංකය</th>
                          <th scope="col" class="">විභාග අංකය</th>
                          <th scope="col" class="">දුරකථන අංකය</th>
                          <th scope="col" class="">ලිපිනය</th>
                          <th scope="col" class="">වර්ගය</th>
                          <th scope="col" class="">විද්‍යුත් තැපෑල</th>
                          <th scope="col" class="">අධ්‍යාපන කොට්ඨාසය</th>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <th scope="col" class=""></th>
                          <th scope="col" class=""></th> 
                    <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $x=1;;
                        $latest_upd_dt = 0;
                        foreach ($national_school_info as $row){  
                          $last_update_dt = $row->school_details_upd_dt; 
                          if($last_update_dt > $latest_upd_dt){
                            $latest_upd_dt = $last_update_dt;
                          } 
                        ?>
                        <tr>
                          <td><?php echo $x; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_name; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->census_id; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->exam_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->contact_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->address1,', ',$row->address2; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_type; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->email; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->div_name; ?></td>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/viewUpdateSchoolPageByAdmin/<?php echo $row->census_id; ?>" type="button" id="btn_update_school" name="btn_update_school" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="Update" title="Update school" data-toggle="tooltip" data-hidden=""><i class="fa fa-pencil"></i></a>
                          </td>
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/deleteSchool/<?php echo $row->census_id; ?>" type="button" name="btn_update_school" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                          </td>
                    <?php } ?>
                        </tr>
                      <?php $x++; } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <a href="<?php echo base_url(); ?>ExcelExport/printNationalSchools" id="btn_print_sch_details" name="btn_print_sch_details" type="button" class="btn btn-success mt-2" style="margin-top: 10px;"> Print </a>
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
      </div> <!-- /row #national_school_info -->
  <?php   }   ?> 
  <?php
      if(!empty($oneAB_school_info)) { // find 1AB Schoolds
  ?>
      <div class="row" id="1AB_school_info">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> 1AB පාසල් තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center"> 1AB පාසල් තොරතුරු</h5>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th scope="col" class="">නම</th>
                          <th scope="col" class="">සංඝණන අංකය</th>
                          <th scope="col" class="">විභාග අංකය</th>
                          <th scope="col" class="">දුරකථන අංකය</th>
                          <th scope="col" class="">ලිපිනය</th>
                          <th scope="col" class="">වර්ගය</th>
                          <th scope="col" class="">විද්‍යුත් තැපෑල</th>
                          <th scope="col" class="">අධ්‍යාපන කොට්ඨාසය</th>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <th scope="col" class=""></th>
                          <th scope="col" class=""></th> 
                    <?php } ?>                        
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      $x=1;
                        $latest_upd_dt = 0;
                        foreach ($oneAB_school_info as $row){  
                          $last_update_dt = $row->school_details_upd_dt; 
                          if($last_update_dt > $latest_upd_dt){
                            $latest_upd_dt = $last_update_dt;
                          } 
                        ?>
                        <tr>
                          <td><?php echo $x; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_name; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->census_id; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->exam_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->contact_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->address1,', ',$row->address2; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_type; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->email; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->div_name; ?></td>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/viewUpdateSchoolPageByAdmin/<?php echo $row->census_id; ?>" type="button" id="btn_update_school" name="btn_update_school" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="Update" title="Update school" data-toggle="tooltip" data-hidden=""><i class="fa fa-pencil"></i></a>
                          </td>
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/deleteSchool/<?php echo $row->census_id; ?>" type="button" name="btn_update_school" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                          </td>
                    <?php } ?>
                        </tr>
                      <?php $x++; } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <a href="<?php echo base_url(); ?>ExcelExport/printSchoolByType/<?php echo $row->sch_type_id; ?>" id="btn_print_sch_details" name="btn_print_sch_details" type="button" class="btn btn-success mt-2" style="margin-top: 10px;"> Print </a>
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
      </div> <!-- /row #1AB_school_info -->
  <?php   }   ?> 
  <?php
    if(!empty($oneC_school_info)) { // find 1C schools
  ?>
      <div class="row" id="1C_school_info">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> 1C පාසල් තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center"> 1C පාසල් තොරතුරු</h5>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th scope="col" class="">නම</th>
                          <th scope="col" class="">සංඝණන අංකය</th>
                          <th scope="col" class="">විභාග අංකය</th>
                          <th scope="col" class="">දුරකථන අංකය</th>
                          <th scope="col" class="">ලිපිනය</th>
                          <th scope="col" class="">වර්ගය</th>
                          <th scope="col" class="">විද්‍යුත් තැපෑල</th>
                          <th scope="col" class="">අධ්‍යාපන කොට්ඨාසය</th>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <th scope="col" class=""></th>
                          <th scope="col" class=""></th> 
                    <?php } ?> 
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $x=1;
                        $latest_upd_dt = 0;
                        $no = 1; // used to print numbers in school details table
                        foreach ($oneC_school_info as $row){  
                          $last_update_dt = $row->school_details_upd_dt; 
                          if($last_update_dt > $latest_upd_dt){
                            $latest_upd_dt = $last_update_dt;
                          } 
                        ?>
                        <tr>
                          <td><?php echo $x; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_name; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->census_id; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->exam_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->contact_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->address1,', ',$row->address2; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_type; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->email; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->div_name; ?></td>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/viewUpdateSchoolPageByAdmin/<?php echo $row->census_id; ?>" type="button" id="btn_update_school" name="btn_update_school" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="Update" title="Update school" data-toggle="tooltip" data-hidden=""><i class="fa fa-pencil"></i></a>
                          </td>
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/deleteSchool/<?php echo $row->census_id; ?>" type="button" name="btn_update_school" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                          </td>
                    <?php $x++; } ?>
                        </tr>
                      <?php $no++; } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <a href="<?php echo base_url(); ?>ExcelExport/printSchoolByType/<?php echo $row->sch_type_id; ?>" id="btn_print_sch_details" name="btn_print_sch_details" type="button" class="btn btn-success mt-2" style="margin-top: 10px;"> Print </a>
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
      </div> <!-- /row #1C_school_info -->
  <?php   }   ?> 
   <?php
    if(!empty($type2_school_info)) { // find type 2 schools
  ?>
      <div class="row" id="Type2_school_info">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> 2 වර්ගයේ පාසල් තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center"> 2 වර්ගයේ පාසල් තොරතුරු</h5>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th scope="col" class="">නම</th>
                          <th scope="col" class="">සංඝණන අංකය</th>
                          <th scope="col" class="">විභාග අංකය</th>
                          <th scope="col" class="">දුරකථන අංකය</th>
                          <th scope="col" class="">ලිපිනය</th>
                          <th scope="col" class="">වර්ගය</th>
                          <th scope="col" class="">විද්‍යුත් තැපෑල</th>
                          <th scope="col" class="">අධ්‍යාපන කොට්ඨාසය</th>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                            <th scope="col" class=""></th>
                            <th scope="col" class=""></th> 
                    <?php } ?>                         
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $x=1;
                        $latest_upd_dt = 0; // used to make latest update date
                        $no = 1; // used to print numbers in school details table
                        foreach ($type2_school_info as $row){  
                          $last_update_dt = $row->school_details_upd_dt; 
                          if($last_update_dt > $latest_upd_dt){
                            $latest_upd_dt = $last_update_dt;
                          }
                        ?>
                        <tr>
                          <td><?php echo $x; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_name; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->census_id; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->exam_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->contact_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->address1,', ',$row->address2; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_type; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->email; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->div_name; ?></td>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/viewUpdateSchoolPageByAdmin/<?php echo $row->census_id; ?>" type="button" id="btn_update_school" name="btn_update_school" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="Update" title="Update school" data-toggle="tooltip" data-hidden=""><i class="fa fa-pencil"></i></a>
                          </td>
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/deleteSchool/<?php echo $row->census_id; ?>" type="button" name="btn_update_school" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                          </td>
                    <?php } ?>
                        </tr>
                      <?php $no++; } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <a href="<?php echo base_url(); ?>ExcelExport/printSchoolByType/<?php echo $row->sch_type_id; ?>" id="btn_print_sch_details" name="btn_print_sch_details" type="button" class="btn btn-success mt-2" style="margin-top: 10px;"> Print </a>
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
      </div> <!-- /row #Type2_school_info -->
  <?php   }   ?> 
  <?php
    if(!empty($type3_school_info)) { // find type 3 schools
  ?>
      <div class="row" id="Type2_school_info">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> 3 වර්ගයේ පාසල් තොරතුරු</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center"> 3 වර්ගයේ පාසල් තොරතුරු</h5>
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th scope="col" class="">නම</th>
                          <th scope="col" class="">සංඝණන අංකය</th>
                          <th scope="col" class="">විභාග අංකය</th>
                          <th scope="col" class="">දුරකථන අංකය</th>
                          <th scope="col" class="">ලිපිනය</th>
                          <th scope="col" class="">වර්ගය</th>
                          <th scope="col" class="">විද්‍යුත් තැපෑල</th>
                          <th scope="col" class="">අධ්‍යාපන කොට්ඨාසය</th>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->             
                            <th scope="col" class=""></th>
                            <th scope="col" class=""></th> 
                    <?php } ?>                         
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $x=1;
                        $latest_upd_dt = 0; // used to make latest update date
                        $no = 1; // used to print numbers in school details table
                        foreach ($type3_school_info as $row){  
                          $last_update_dt = $row->school_details_upd_dt; 
                          if($last_update_dt > $latest_upd_dt){
                            $latest_upd_dt = $last_update_dt;
                          }
                        ?>
                        <tr>
                          <td><?php echo $x; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_name; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->census_id; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->exam_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->contact_no; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->address1,', ',$row->address2; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->sch_type; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->email; ?></td>
                          <td style="vertical-align:middle"><?php echo $row->div_name; ?></td>
                    <?php if($userrole=='System Administrator'){  ?>  <!-- check for system admin login -->                          
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/viewUpdateSchoolPageByAdmin/<?php echo $row->census_id; ?>" type="button" id="btn_update_school" name="btn_update_school" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="Update" title="Update school" data-toggle="tooltip" data-hidden=""><i class="fa fa-pencil"></i></a>
                          </td>
                          <td id="td_btn">
                            <a href="<?php echo base_url(); ?>School/deleteSchool/<?php echo $row->census_id; ?>" type="button" name="btn_update_school" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this item" onClick="return confirmItemDelete();"><i class="fa fa-trash-o"></i></a>
                          </td>
                    <?php } ?>
                        </tr>
                      <?php $x++; } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                  <a href="<?php echo base_url(); ?>ExcelExport/printSchoolByType/<?php echo $row->sch_type_id; ?>" id="btn_print_sch_details" name="btn_print_sch_details" type="button" class="btn btn-success mt-2" style="margin-top: 10px;"> Print </a>
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
      </div> <!-- /row #Type2_school_info -->
  <?php   }   ?> 
    </div> <!-- /container-fluid -->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {  
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
    });
  </script>