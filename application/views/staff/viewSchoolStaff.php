  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <style type="text/css">
   #addNewStaffInfo li a{
    display: inline-block;
    height: 40px; width: 150px;
    margin: 0 2px 0 2px;
    padding: 2px;
    text-align: center;
   }
  #addNewStaffInfo li a:hover{
    text-decoration: none;
    color: blue;
    background-color: #eeeeee;
   }
  .navPaneDown{margin-bottom: 5px;}
  .active{
      border:1px 1px 0px 1px;
      border-color: black;
  }
  .imgPrw{
    max-width: 90px; max-height: 120px;
  }
   //.datepicker{font-size: 15px;}
  </style>
  <script type="text/javascript">
    $( document ).ready(function() {    
     $('#dataTable').DataTable({
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
    $role_id = $user_data['userrole_id'];
    if($role_id=='2'){
      //$class = $user_data['grade'].' '.$user_data['class'];
      echo $school_name = $user_data['school_name'];
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
        <li class="breadcrumb-item active">Staff</li>
      </ol>
      <?php
    if($role_id=='1' || $role_id=='2' ){  ?>  <!-- check for system admin login -->
      <div class="row" id="search-bar-row">     <!-- search bar is availabel for admin only -->
        <div class="col-lg-12 col-sm-12">
          <div class="row">
            <div class="col-lg-5 col-sm-5">
              <form class="navbar-form" role="search" id="srch_stf_info_by_nic" name="srch_stf_info_by_nic" action="<?php echo base_url(); ?>Staff/viewStaffByNic" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <label>NIC No &nbsp;</label>
                    <input class="form-control" placeholder="NIC Number..." name="nic_no_txt" id="nic_no_txt" type="text" value="<?php echo set_value('nic_no_txt'); ?>">
                    <button type="submit" class="btn btn-default input-group-addon" name="btn_view_staff_by_nic" value="View"><i class="fa fa-search"></i></button>
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
      <?php
        if(!empty($this->session->flashdata('uploadSuccess'))) {
          $message = $this->session->flashdata('uploadSuccess');  ?>
          <div class="alert alert-success" ><?php echo $message; ?></div>
      <?php } ?> 
      <?php
        if(!empty($this->session->flashdata('uploadError'))) {
          $message = $this->session->flashdata('uploadError');  
            foreach ($message as $item => $value){
              echo '<div class="alert alert-danger" >'.$item.' : '.$value.'</div>';
            }
       } ?> 
        <div class="row" id="staff_details_by_nic">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> කාර්යමණ්ඩල තොරතුරු 
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">
                    <?php if($userrole=='School User'){
                            echo $school_name; 
                          }else{
                            if(!empty($acStaffDetails)) { 
                              foreach ($acStaffDetails as $row){  
                                $school_name = $row->sch_name;
                              }
                              echo $school_name;
                            }
                          }
                    ?></h5>
                  <h6 align="center">කාර්යමණ්ඩල තොරතුරු</h6>
                  <?php if(!empty($acStaffDetails)) { ?>   
                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> නම </th>
                          <th> පාසල </th>
                          <th>හැඳුනුම්පත් අංකය</th>
                          <th>ස්ත්‍රී/පුරුෂ</th>
                          <th> දු.ක.</th>
                          <th>තනතුර</th>
                          <th>අධ්‍යාපන </th>
                          <th>වෘත්තීය සුදුසුකම්</th>
                      <?php if(($userrole=='System Administrator') || ($userrole=='School User')){ ?>
                            <th ></th><th></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($acStaffDetails as $row){  
                          $staff_id = $row->staff_id;
                          $census_id = $row->census_id;
                          $name_with_ini = $row->name_with_ini;
                          $school = $row->sch_name;
                          $nic_no = $row->nic_no;
                          $gender_name = $row->gender_name;
                          $phone_mobile1 = $row->phone_mobile1;
                          $desig_type = $row->desig_type;
                          $edu_qual = $row->edu_q_name;
                          $prof_qual = $row->prof_q_name;
                          $update_dt = $row->last_update;
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
                          <td style="vertical-align:middle" ><?php echo $phone_mobile1; ?></td>
                          <td style="vertical-align:middle" ><?php echo $desig_type; ?></td>
                          <td style="vertical-align:middle" ><?php echo $edu_qual; ?></td>
                          <td style="vertical-align:middle" ><?php echo $prof_qual; ?></td>
                    <?php if(($role_id=='1') || ($role_id=='2')){ ?>
                            <td id="td_btn" style="vertical-align:middle">
                              <a href="<?php echo base_url(); ?>Staff/editStaffView/<?php echo $staff_id; ?>" type="button" id="btn_edit_building_info" name="btn_edit_building_info" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this details" data-toggle="tooltip" data-hidden="" onclick="get(<?php //echo $b_info_id; ?>)"><i class="fa fa-pencil"></i></a>
                            </td>
                            <td id="td_btn" style="vertical-align:middle">
                              <!-- when delete, census id must be sent, since it is used to go back after delete -->
                              <a href="<?php echo base_url(); ?>Staff/deleteStaff/<?php echo $staff_id; ?>" type="button" name="btn_delete_building_info" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this details" onClick="return confirmItemStatusDetailsDelete();"><i class="fa fa-trash-o"></i></a>
                            </td>
                    <?php } ?>
                        </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php }else{ // if empty($acStaffDetails)
                    if(($userrole=='School User') && empty($acStaffDetails)){
                      echo '<h4 align="center">No Records!!!</h4>'; 
                    }else if(($userrole=='Administrator') && empty($acStaffDetails)){
                      echo '<h4 align="center">Add or Search Records!!!</h4>'; 
                    }else{
                      echo '<h4 align="center">Search Details</h4>';
                    }
                  } ?>  
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
      <?php //} ?>  
      
      <!-- /following bootstrap model used to insert school academic staff -->
      <div class="modal fade" id="addNewStaffInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Insert Staff Details</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs " role="tablist">
                        <li role="presentation" class="active"><a href="#personalDetailsTab" aria-controls="personalDetailsTab" role="tab" data-toggle="tab"> Personal Details </a></li>
                        <li role="presentation"><a href="#serviceDetailsTab" aria-controls="serviceDetailsTab" role="tab" data-toggle="tab"> Service Details </a></li>
                        <li role="presentation"><a href="#schDetailsTab" aria-controls="schDetailsTab" role="tab" data-toggle="tab"> School Details </a></li>
                        <li role="presentation"><a href="#photoTab" aria-controls="photoTab" role="tab" data-toggle="tab"> Profile Picture </a></li>
                    </ul>
                    <!-- Tab panes -->
                  <div class="tab-content mt-3">
                    <div role="tabpanel" class="tab-pane active" id="personalDetailsTab">      
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_staff_info_form", "name" => "insert_staff_info_form", "accept-charset" => "UTF-8" );
                  echo form_open_multipart("Staff/addStaff", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Name with initials" class="control-label">Name with initials </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="name_with_ini_txt" name="name_with_ini_txt" placeholder="---Type here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="full name" class="control-label"> Full Name </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="full_name_txt" name="full_name_txt" placeholder="---Type here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="nick name" class="control-label"> Nick Name </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="nick_name_txt" name="nick_name_txt" placeholder="---Type here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Address 1" class="control-label"> Address 1 </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="address1_txt" name="address1_txt" placeholder="---Type here---" type="text" value="" size="60" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Address 2" class="control-label"> Address 2 </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="address2_txt" name="address2_txt" placeholder="---Type here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="NIC" class="control-label"> NIC No </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="nic_txt" name="nic_txt" placeholder="---Type here---" type="text" value="" size="60" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="dob" class="control-label"> Date of Birth </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control datepicker" id="dob_txt" name="dob_txt" placeholder="---Type here---" type="text" value="" size="60" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new category" class="control-label"> Religion </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="religion_select" name="religion_select">
                            <option value="" selected>---Click here---</option>
                            <?php foreach ($this->all_religion as $row){ ?> <!-- from Building controller constructor method -->
                              <option value="<?php echo $row->religion_id; ?>"><?php echo $row->religion; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->  
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new category" class="control-label"> Ethnicity </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="ethnicity_select" name="ethnicity_select">
                            <option value="" selected>---Click here---</option>
                            <?php foreach ($this->all_ethnic_groups as $row){ ?> <!-- from Staff controller constructor method -->
                              <option value="<?php echo $row->ethnic_group_id; ?>"><?php echo $row->ethnic_group; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new category" class="control-label"> Civil Status </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="civil_status_select" name="civil_status_select">
                            <option value="" selected>---Click here---</option>
                            <?php foreach ($this->all_civil_status as $row){ ?> <!-- from Staff controller constructor method -->
                              <option value="<?php echo $row->civil_status_id; ?>"><?php echo $row->civil_status_type; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->                 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Mobile 1" class="control-label">Mobile 1 </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="tel_txt" name="tel1_txt" placeholder="---Type here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Mobile 2" class="control-label">Mobile 2 </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="tel2_txt" name="tel2_txt" placeholder="---Type here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Mobile 2" class="control-label"> Home phone </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="tel_home_txt" name="tel_home_txt" placeholder="---Type here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="email" class="control-label"> E-Mail </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="email_txt" name="email_txt" placeholder="---Type here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="wide" class="control-label"> Gender </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="gender_select" name="gender_select">
                            <option value="" selected>---Click here---</option>
                            <option value="1" > ස්ත්‍රී </option>
                            <option value="2" > පුරුෂ  </option>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="vehicle number1" class="control-label"> Vehicle Number 1 </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="vehicle_no1_txt" name="vehicle_no1_txt" placeholder="---Type here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group" id="vehicle_no_1">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="vehicle number2" class="control-label"> Vehicle Number 2 </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="vehicle_no2_txt" name="vehicle_no2_txt" placeholder="---Type here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group" id="vehicle_no_1">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="educational qualification" class="control-label"> High. Edu. Qualification </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="high_edu_select" name="high_edu_select">
                            <option value="" selected>---Click here---</option>
                            <?php foreach ($this->all_edu_qual as $row){ ?> <!-- from Staff controller constructor method -->
                              <option value="<?php echo $row->edu_q_id; ?>"><?php echo $row->edu_q_name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group" id="vehicle_no_1">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Professional qualification" class="control-label"> High. Prof. Qualification </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="prof_edu_select" name="prof_edu_select">
                            <option value="" selected>---Click here---</option>
                            <?php foreach ($this->all_prof_qual as $row){ ?> <!-- from Staff controller constructor method -->
                              <option value="<?php echo $row->prof_q_id; ?>"><?php echo $row->prof_q_name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  </div> <!-- /privateDetailsTab -->
  <!-- -------------serviceDetailsTab begins------------------------------------------------------------------------- -->
                  <div role="tabpanel" class="tab-pane" id="serviceDetailsTab">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="staff type" class="control-label"> Staff Type </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="stf_type_select" name="stf_type_select">
                            <option value="" selected>---Click here---</option>
                              <?php foreach ($this->all_stf_types as $row){ ?> <!-- from Staff controller constructor method -->
                                <option value="<?php echo $row->stf_type_id; ?>"><?php echo $row->stf_type; ?></option>
                              <?php } ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('stf_type_select'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="first appointment date" class="control-label"> First Appointment Date </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control datepicker" id="f_app_dt_txt" name="f_app_dt_txt" placeholder="---Click here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Name with ini">App. Category </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="app_cat_select" name="app_cat_select">
                            <option value="" selected>---Click here---</option>
                              <?php foreach ($this->all_appoint_cat as $row){ ?> <!-- from Staff controller constructor method -->
                                <option value="<?php echo $row->app_cat_id; ?>"><?php echo $row->app_cat_type; ?></option>
                              <?php } ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('app_cat_select'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Name with ini">App. Sub Category</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="app_sub_cat_select" name="app_sub_cat_select">
                            <option value="" selected>---Click here---</option>
                              <?php foreach ($this->all_appoint_sub_cat as $row){ ?> <!-- from Staff controller constructor method -->
                                <option value="<?php echo $row->app_sub_cat_id; ?>"><?php echo $row->app_sub_cat_type; ?></option>
                              <?php } ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('app_sub_cat_select'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->         
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Name with ini">App. Medium</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="app_medium_select" name="app_medium_select">
                            <option value="" selected>---Click here---</option>
                              <?php foreach ($this->all_subj_medium as $row){ ?> <!-- from Staff controller constructor method -->
                                <option value="<?php echo $row->subj_med_id; ?>"><?php echo $row->subj_med_type; ?></option>
                              <?php } ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('app_medium_select'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Name with ini">Serv. Grade</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="service_grade_select" name="service_grade_select">
                            <option value="" selected>---Click here---</option>
                              <?php foreach ($this->all_service_grades as $row){ ?> <!-- from Staff controller constructor method -->
                                <option value="<?php echo $row->serv_grd_id; ?>"><?php echo $row->serv_grd_type; ?></option>
                              <?php } ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('service_grade_select'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  </div> <!-- /schoolDetailsTab -->
  <!-- -------------schDetailsTab begins------------------------------------------------------------------------- -->
                  <div role="tabpanel" class="tab-pane" id="schDetailsTab">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="staff number"> School </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="school_select" name="school_select">
                    <?php   if($role_id=='2' ){ $census_id = $user_data['census_id']; ?>  <!-- check for school user login -->
                              <option value="<?php echo $census_id; ?>" selected><?php echo $school_name; ?></option>
                    <?php   }else{ ?>
                            <option value="" selected>---Click here---</option>
                              <?php foreach ($this->all_schools as $row){ ?> <!-- from Staff controller constructor method -->
                                <option value="<?php echo $row->census_id; ?>"><?php echo $row->sch_name; ?></option>
                              <?php } } ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('school_select'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="staff number"> Salary Number </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="stf_no_txt" name="stf_no_txt" placeholder="Type here" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="staff number"> Salary Number </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="salary_no_txt" name="salary_no_txt" placeholder="Type here" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="This School first date" class="control-label"> Start Date of this school </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control datepicker" id="this_sch_dt_txt" name="this_sch_dt_txt" placeholder="---Click here---" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Designation" class="control-label"> Designation </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="desig_select" name="desig_select">
                            <option value="" selected>---Click Here---</option>
                            <?php foreach ($this->all_designations as $row){ ?> <!-- from Staff controller constructor method -->
                              <option value="<?php echo $row->desig_id; ?>"><?php echo $row->desig_type; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Assign to a game" class="control-label"> Staff Status </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="stf_status_select" name="stf_status_select">
                            <option value="" selected>---Click Here---</option>
                            <?php foreach ($this->all_staff_status as $row){ ?> <!-- from Staff controller constructor method -->
                              <option value="<?php echo $row->stf_status_id; ?>"><?php echo $row->stf_status; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Assign to a game" class="control-label"> Assign to a section </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="stf_status_select" name="section_select">
                            <option value="" selected>---Click Here---</option>
                            <?php foreach ($this->all_sections as $row){ ?> <!-- from Staff controller constructor method -->
                              <option value="<?php echo $row->section_id; ?>"><?php echo $row->section_name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Assign to a game" class="control-label"> Assign a role </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="section_role_select" name="section_role_select">
                            <option value="" selected>---Click Here---</option>
                            <?php foreach ($this->all_section_roles as $row){ ?> <!-- from Staff controller constructor method -->
                              <option value="<?php echo $row->sec_role_id; ?>"><?php echo $row->sec_role_name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Task Involved" class="control-label"> Assign to a Task </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="task_inv_select" name="task_inv_select">
                            <option value="" selected>---Click Here---</option>
                            <?php foreach ($this->all_tasks_involved as $row){ ?> <!-- from Staff controller constructor method -->
                              <option value="<?php echo $row->involved_task_id; ?>"><?php echo $row->inv_task; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  </div> <!-- /schoolDetailsTab -->
                  <div role="tabpanel" class="tab-pane" id="photoTab">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="select image" class="control-label"> Select the Picture </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input type="file" name="stf_image" size="20" id="stf_image" />                 
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <img id="imgPrw" src="#" alt="Preview" class="imgPrw" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->                     
                  <!-- <fieldset> -->
                  </div> <!-- /parentDetailsTab -->

                </div> <!-- /col-sm-12 -->
                </div>
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_stf_info" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
    </div> <!-- /container-fluid -->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
    <script type="text/javascript">
      $('#addNewStaffInfo a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
        $(this).css('border-color', 'blue');
      })
      function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgPrw').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
      }
      $(document ).ready(function() {    
        $("#stf_image").change(function(){
            readURL(this);
        });
      })
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
      $('#game_role_select_form_group').hide();
        $('#game_select').change(function(e){
          //alert('hello');  
          $('#game_role_select_form_group').toggle('fade');
      }) 
      $('#extra_curri_role_select_form_group').hide();
        $('#extra_curri_select').change(function(e){
          //alert('hello');  
          $('#extra_curri_role_select_form_group').toggle('fade');
      }) 
        // date picker
      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
      })

    });
  </script>