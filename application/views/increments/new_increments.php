<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script type="text/javascript">


</script>
  <style type="text/css">

  </style>
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
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>increment">Increments</a>
        </li>
        <li class="breadcrumb-item active">New Salary Increments</li>
      </ol>
      <?php if(!empty($this->session->flashdata('increment_add_msg'))) {
              $message = $this->session->flashdata('increment_add_msg');  ?>
              <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php } ?> 
      <?php if(!empty($this->session->flashdata('updateIncMsg'))) {
              $message = $this->session->flashdata('updateIncMsg');  ?>
              <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php } ?> 
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
                Details of salary increment forms of <?php echo date("Y"); ?>
              </div>
            <div class="card-body">
      <?php   if($userrole=='System Administrator' || $userrole=='Divisional User'){ ?>
                <button id="btn_add_new_inc_info" name="btn_add_new_inc_info" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewIncrement" ><i class="fa fa-plus"></i> Add New</button>
      <?php   }  ?>
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h6 align="center"> Handovered Salary Increment forms - <?php echo date("Y"); ?> </h6>
                  <?php if(!empty($increments)) { //print_r($increment_data); die(); ?>   
                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> Name </th>
                          <th> School </th>
                          <th> Increment Year </th>
                          <th> Status </th>
                          <th> Submit Date</th>
                          <th> Date updated </th>
                          <th></th>
                  <?php   if($userrole=='System Administrator' || $userrole=='Divisional User'){ ?>
                            <th></th><th></th>
                  <?php   }  ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($increments as $row){ 
                          $inc_id = $row->tr_inc_id;
                          $stf_id = $row->stf_id;
                          $tr_name = $row->name_with_ini;
                          $school_name = $row->sch_name;
                          $inc_year = $row->increment_year; 
                          $inc_status_id = $row->inc_status_id;
                          $inc_status = $row->inc_status;
                          $defects = $row->defects;
                          $remarks = $row->remarks;
                          $date_added = $row->inc_date_added;
                          $date_updated = $row->last_update;

                          $no = $no + 1;  ?>
                        <tr id="<?php echo 'tbrow'.$inc_id; ?>">
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle" ><?php echo $tr_name; ?></td>
                          <td style="vertical-align:middle;"><?php echo $school_name; ?></td>
                          <td style="vertical-align:middle" ><?php echo $inc_year; ?></td>
                          <td style="vertical-align:middle" ><?php echo $inc_status; ?></td>
                          <td style="vertical-align:middle" ><?php echo $date_added; ?></td>
                          <td style="vertical-align:middle" ><?php echo $date_updated; ?></td>
                          <td style="vertical-align: middle;" align="center">
                            <a type="button" id="<?php echo $inc_id; ?>" name="btn_view_inc_status" type="button" class="btn btn-info btn-sm btn_edit_phy_res btn_view_inc_status_modal" value="<?php echo $stf_id; ?>" title="Click to see status" data-toggle="tooltip" data-hidden="" ><i class="fa fa-info"></i></a> 
                          </td>
                  <?php   if($userrole=='System Administrator' || $userrole=='Divisional User'){ ?>
                          <td>
                            <a type="button" id="<?php echo $inc_id; ?>" id="btn_edit_inc_status" name="btn_edit_inc_status" type="button" class="btn btn-info btn-sm btn_edit_phy_res btn_edit_inc_status" value="<?php echo $stf_id; ?>" title="Click to edit" data-toggle="tooltip" data-hidden="" ><i class="fa fa-edit"></i></a>
                          </td>
                          <td>
                            <a type="button" id="btn_delete_inc_status" name="btn_delete_inc_status" type="button" class="btn btn-info btn-sm btn_edit_phy_res btn_delete_inc_status" value="<?php echo $inc_id; ?>" title="Click to Delete" data-toggle="tooltip" data-hidden="" data-id="<?php echo $inc_id; ?>" ><i class="fa fa-trash"></i></a>
                          </td>
                  <?php   } ?>
                        </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php }else{ // if empty($increments)
                    if(($userrole=='School User') && empty($newMessages)){
                      echo '<h4 align="center">No Records!!!</h4>'; 
                    }else if(($userrole=='Administrator') && empty($newMessages)){
                      echo '<h4 align="center">No Records!!!</h4>'; 
                    }else{
                      echo '<h4 align="center">No Records!!!</h4>';
                    }
                  } ?>  
              </div> <!-- /col-lg-12 -->
            </div>  <!-- /row -->
          </div> <!-- /card body -->
            <div class="card-footer small text-muted">
              <?Php 
                
              ?>
            </div>
          </div>
        </div>
        
      </div>
      <!-- /following bootstrap model used to insert salary increment form  -->
      <div class="modal fade" id="addNewIncrement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> නව වැටුප් වර්ධක අයදුම්පතක් ඇතුළත් කිරීම </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_new_increment_form", "name" => "insert_new_increment_form", "accept-charset" => "UTF-8" );
                  echo form_open("increment/addNewIncrement", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="id" class="control-label"> NIC  </label>
                        </div>
                        <div class="col-lg-88 col-sm-8">
                          <input class="form-control" id="nic_txt" name="nic_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="id" class="control-label"> Name  </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input type="hidden" value="" id="stf_id_hidden" name="stf_id_hidden" >
                          <input class="form-control" id="name_txt" name="name_txt" placeholder="" type="text" value="" readonly="" />
                          <span class="text-danger" id="staff_name_span"></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="id" class="control-label"> School </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control" id="school_txt" name="school_txt" placeholder="" type="text" value="" readonly="" />
                          <span class="text-danger" id="school_name_span"></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="id" class="control-label"> Increment Date </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control" id="inc_date_txt" name="inc_date_txt" placeholder="" type="text" value="" readonly="" />
                          <span class="text-danger" id="inc_date_txt"></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="year" class="control-label"> Increment Year  </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="inc_year_select" name="inc_year_select">
                            <option value="" selected>---Click here---</option>
                              <?php 
                                $current_year = date('Y');
                                foreach (range(2010, $current_year) as $value){ ?>
                                  <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                              <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="Name with ini">Increment Status</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="increment_status_select" name="increment_status_select">
                            <option value="" selected>---Click here---</option>
                              <?php foreach ($this->all_increment_status as $row){ ?> <!-- from Staff controller constructor method -->
                                <option value="<?php echo $row->inc_status_id; ?>"><?php echo $row->inc_status; ?></option>
                              <?php } ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('increment_status_select'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="sms status" class="control-label"> Submitted date </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control datepicker" id="submit_dt_txt" name="submit_dt_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="Name with ini"> Defects </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="defects_select" name="defects_select">
                            <option value="" selected>---Click here---</option>
                            <option value="0" > නැත </option>
                            <option value="1" > තිබේ </option>
                          </select>
                          <span class="text-danger"><?php echo form_error('defects_select'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="remarks" class="control-label"> Remarks   </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <textarea class="form-control" id="remarks_txtarea" name="remarks_txtarea" placeholder=""></textarea> 
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-primary" type="submit" name="btn_add_increment" id="btn_add_increment" value="Add"> Add </button>
              <button class="btn btn-secondary" type="button" data-dismiss="modal" >Cancel</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
<!-- ----------/following bootstrap model used to UPDATE salary increment form info----------------------------------------- -->
      <div class="modal fade" id="updateIncrement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> වැටුප් වර්ධක අයදුම්පත්  තොරතුරු යාවත්කාලීන කිරීම </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "update_increment_form_info", "name" => "update_increment_form_info", "accept-charset" => "UTF-8" );
                  echo form_open("increment/updateIncrementInfo", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="id" class="control-label"> NIC  </label>
                        </div>
                        <div class="col-lg-88 col-sm-8">
                          <input type="hidden" name="inc_id_hidden_upd" id="inc_id_hidden_upd">
                          <input class="form-control" id="nic_txt_upd" name="nic_txt_upd" placeholder="" type="text" value="" readonly="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="id" class="control-label"> Name  </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input type="hidden" value="" id="stf_id_hidden_upd" name="stf_id_hidden_upd" >
                          <input class="form-control" id="name_txt_upd" name="name_txt_upd" placeholder="" type="text" value="" readonly="" />
                          <span class="text-danger" id="staff_name_span"></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="id" class="control-label"> School </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control" id="school_txt_upd" name="school_txt_upd" placeholder="" type="text" value="" readonly="" />
                          <span class="text-danger" id="school_name_span"></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="year" class="control-label"> Increment Year  </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="inc_year_select_upd" name="inc_year_select_upd">
                            <option value="" selected>---Click here---</option>
                              <?php 
                                $current_year = date('Y');
                                foreach (range(2010, $current_year) as $value){ ?>
                                  <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                              <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="Name with ini">Increment Status</label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="inc_status_select_upd" name="inc_status_select_upd">
                            <option value="" selected>---Click here---</option>
                              <?php foreach ($this->all_increment_status as $row){ ?> <!-- from Staff controller constructor method -->
                                <option value="<?php echo $row->inc_status_id; ?>"><?php echo $row->inc_status; ?></option>
                              <?php } ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('increment_status_select'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->  
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="Name with ini"> Defects </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="defects_select_upd" name="defects_select_upd">
                            <option value="" selected>---Click here---</option>
                            <option value="0" > නැත </option>
                            <option value="1" > ඇත </option>
                          </select>
                          <span class="text-danger"><?php echo form_error('defects_select_upd'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="remarks" class="control-label"> Remarks   </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <textarea class="form-control" id="remarks_txtarea_upd" name="remarks_txtarea_upd" placeholder=""></textarea> 
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="sms status" class="control-label"> Submitted date </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control datepicker" id="submit_dt_txt_upd" name="submit_dt_txt_upd" placeholder="" type="text" value="" readonly=""/>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-primary" type="submit" name="btn_edit_increment" id="btn_edit_increment" value="Update"> Add </button>
              <button class="btn btn-secondary" type="button" data-dismiss="modal" >Cancel</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
<!-- ----------/following bootstrap model used to view salary increment status info----------------------------------------- -->
      <div class="modal fade" id="incrementInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> වැටුප් වර්ධක අයදුම්පත්  තොරතුරු </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                   <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover" cellspacing="0">
                      <thead></thead>
                      <tbody>
                        <tr>
                          <th> නම </th>
                          <td id="name_td"></td>
                        </tr>
                        <tr>
                          <th> ජා.හැ. අංකය  </th>
                          <td id="nic_td"></td>
                        </tr>
                        <tr>
                          <th> පාසල </th>
                          <td id="school_td"></td>
                        </tr>
                        <tr>
                          <th>වැටුප් වර්ධක දිනය </th>
                          <td id="inc_date_td"></td>
                        </tr>
                        <tr>
                          <th> වැටුප් වර්ධක වර්ෂය </th>
                          <td id="inc_year_td"></td>
                        </tr>
                        <tr>
                          <th> භාරදුන් දිනය </th>
                          <td id="submit_date_td"></td>
                        </tr>
                        <tr>
                          <th> තත්වය </th>
                          <td id="status_td"></td>
                        </tr>
                        <tr>
                          <th> අඩුපාඩු </th>
                          <td id="defect_td"></td>
                        </tr>
                        <tr>
                          <th> වෙනත් </th>
                          <td id="remarks_td"></td>
                        </tr>
                        <tr>
                          <th> යාවත්කාලීන  කල දිනය  </th>
                          <td id="last_upd_dt_td"></td>
                        </tr>
                      </tbody>
                    </table>
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal" >Cancel</button>
            </div> <!-- /modal-footer -->
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
    </div> <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <script type="text/javascript">
      $(document).ready(function() { 

        $('#nic_txt').keyup(function(){ // when the nic is typed in model text box, fill the teacher name and school automatically
          var nic = this.value;
          findTeacherInfo(nic);
        })

        function findTeacherInfo(nic){
          $.ajax({
          url:"<?php echo base_url(); ?>Staff/findStaffByNic",  // get teacher info from staff table and view it on the model
            type: 'POST',
            dataType: 'json',
            data: {nic: nic},
            success: function(data) {
              if(!data){
                $("#name_txt").val('');
                $("#stf_id_hidden").val('');
                $("#school_txt").val('');
                $("#staff_name_span").text('Not found!!!');
                $("#school_name_span").text('Not found!!!');
                $("#inc_date_txt").text('Not found!!!');
              }else{                
                $("#staff_name_span").text('');
                $("#school_name_span").text('');
                $("#name_txt").val(data.stf_name);
                $("#stf_id_hidden").val(data.stf_id);
                $("#school_txt").val(data.sch_name);
                $("#inc_date_txt").val(data.inc_date);           
              }  
            }
          }); 
        }
        // date picker
        $('.datepicker').datepicker({
          format: 'yyyy-mm-dd',
          endDate: new Date()
        })
        // empty field validation when insert new increment form
        $("#insert_new_increment_form").submit(function(){
          var nic = $('#nic_txt').val();
          var name = $('#name_txt').val();
          var school = $('#school_txt').val();
          var inc_date = $('#inc_date_txt').val();
          var year = $('#inc_year_select').val();
          var status = $('#increment_status_select').val();
          var defects_select = $('#defects_select').val();
          var remarks_txtarea = $('#remarks_txtarea').val();
          var submit_date = $('#submit_dt_txt').val();

          if(nic == ''){
              swal("Error!", "Require the correct nic number", "warning");
              return false;    
          }else if(name == ''){
              swal("Error!", "Require the name", "warning");
              return false;        
          }else if(school == ''){
              swal("Error!", "Require the school name", "warning");
              return false; 
          }else if(inc_date == ''){
              swal("Error!", "Require the increment date", "warning");
              return false;       
          }else if(year == ''){
              swal("Error!", "Require the increment year", "warning");
              return false;       
          }else if(status == ''){
              swal("Error!", "Require the status on increment form", "warning");
              return false;       
          }else if(defects_select == ''){
              swal("Error!", "Require the defect field", "warning");
              return false;       
          }else if(defects_select == 1 && remarks_txtarea == ''){
              swal("Error!", "If defects are there, Remarks are required", "warning");
              return false;       
          }else if(submit_date == ''){
              swal("Error!", "Require the submit date", "warning");
              return false;       
          }else{ return true; }
        });

      });
  // displaying update increment form info window through a bootstrap modal
  $(document).on('click', '.btn_edit_inc_status', function(){  
     var inc_id = $(this).attr("id");
     //alert(inc_id);
     $.ajax({  
          url:"<?php echo base_url(); ?>increment/viewIncrement_by_id",  
          method:"POST",  
          data:{inc_id:inc_id},  
          dataType:"json",  
          success:function(data)  
          {  
              //alert(data);
               $('#updateIncrement').modal('show');  
               $('#inc_id_hidden_upd').val(data.inc_id);  // hidden inc id
               $('#stf_id_hidden_upd').val(data.stf_id);  // hidden stf_id
               $('#nic_txt_upd').val(data.nic);  
               $('#name_txt_upd').val(data.stf_name); 
               $('#school_txt_upd').val(data.sch_name); 
               $('#inc_year_select_upd :selected').val(data.increment_year);
               $('#inc_year_select_upd :selected').text(data.increment_year);
               $('#inc_status_select_upd :selected').val(data.inc_status_id);
               $('#inc_status_select_upd :selected').text(data.inc_status);
               $('#defects_select_upd :selected').val(data.defect_id);
               //alert(data.defect_id);
               if(data.defect_id==0){
                  $('#defects_select_upd :selected').text('නැත');
               }else{
                  $('#defects_select_upd :selected').text('ඇත');
               }
               $('#remarks_txtarea_upd').val(data.remarks); 
               $('#submit_dt_txt_upd').val(data.date_added); 
          }, 
          error: function(xhr, status, error) {
            alert(xhr.responseText);
          } 
     })  
  });
  // display submited increment form status through a bootstrap modal
  $(document).on('click', '.btn_view_inc_status_modal', function(){  
     var inc_id = $(this).attr("id");
     $.ajax({  
          url:"<?php echo base_url(); ?>increment/viewIncrement_by_id",  
          method:"POST",  
          data:{inc_id:inc_id},  
          dataType:"json",  
          success:function(data)  
          {  
              $('#incrementInfo').modal('show');  
              $('#name_td').text(data.stf_name);  
              $('#nic_td').text(data.nic); 
              $('#school_td').text(data.sch_name);  
              $('#inc_date_td').text(data.inc_date);  
              $('#inc_year_td').text(data.increment_year); 
              $('#status_td').text(data.inc_status);  
              $('#submit_date_td').text(data.date_added); 
              if(data.defect_id==1){
                $('#defect_td').text('ඇත'); 
              }else{
                $('#defect_td').text('නැත'); 
              }
               $('#remarks_td').text(data.remarks);  
               $('#last_upd_dt_td').text(data.date_updated);  
          }, 
          error: function(xhr, status, error) {
            alert(xhr.responseText);
          } 
     })  
  });
  $(document).ready(function() {
    $('#dataTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf', 'print'
        ]
    } );
  });
  $(".btn_delete_inc_status").click(function(){
      var row_id = $(this).parents("tr").attr("id");
      var inc_id = $(this).attr("data-id");
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: false,
        closeOnCancel: true
      },
      function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            url:"<?php echo base_url(); ?>increment/deleteIncrementInfo",  
            method:"POST",  
            data:{inc_id:inc_id}, 
            error: function() {
              alert('Something is wrong');
            },
             success: function(data) {
                  if(data.trim()=='true'){
                    $("#"+row_id).remove();
                    swal("Deleted!", "Inrement details has been deleted.", "success");
                  }else{
                    swal("Error!", "Inrement details not deleted.", "error");
                  }
             }
          });
        } 
      });
     
    });

</script>
  