<style type="text/css">
  #userInfoTblAjax tr th{text-align: right;}
  #addNewStudentInfo li a{
    display: inline-block;
    height: 40px; width: 150px;
    margin: 0 2px 0 2px;
    padding: 2px;
    text-align: center;
   }
  #addNewStudentInfo li a:hover{
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
</style>
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
          <a href="<?php echo base_url(); ?>user/viewUsers">Users</a>
        </li>
        <li class="breadcrumb-item active">User Information</li>
      </ol>
      <?php
        if(!empty($this->session->flashdata('userChangeMsg'))) {
          $message = $this->session->flashdata('userChangeMsg');  ?>
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
       <?php
        if(!empty($this->session->flashdata('msg'))) {
          echo $this->session->flashdata('msg');
       } ?>  
      <div class="row" id="">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> User Details </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <a id="btn_monitor_user" name="btn_monitor_user" type="button" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>User/viewUserLogPage"><i class="fa fa-search"></i> User Log </a>
                  <h6 align="center"> User Details </h6>
                  <?php
                    if(!empty($user_details)) {                              
                      $attributes = array("class" => "form-horizontal", "id" => "update-user", "name" => "update-user");
                      echo form_open("user/changeUser", $attributes);?>                  
                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover " cellspacing="0">
                      <thead>
                        <tr>
                          <th><input type="checkbox" id="chkbox_all_select" /></th>
                          <th>#</th>
                          <th class="col-sm-2"> User ID </th>
                          <th class="col-sm-2">Role</th>
                          <th class="col-sm-2"> User Name </th>
                          <th class="col-sm-2"> Status </th>
                          <th class="col-sm-2"> Census ID </th>
                          <th class="col-sm-1"></th>
                          <th class="col-sm-1"></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($user_details as $user){  
                          $u_id = $user->u_id;
                          $role_id = $user->role_id;
                          $role_name = $user->roll_name;
                          $u_name = $user->username;
                          $status_id = $user->status_id;
                          $status = $user->status_type;
                          $census_id = $user->census_id;
                          $add_dt = $user->added_dt;
                          $upd_dt = $user->updated_dt;                          
                          if($latest_upd_dt < $upd_dt){
                            $latest_upd_dt = $upd_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr>
                          <td>
                            <input type="checkbox" name="chkbox[]" value="<?php echo $u_id; ?>" class="checkbox">
                          </td>
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $u_id; ?></td>
                          <td style="vertical-align:middle" ><?php echo $role_name; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $u_name; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $status; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $census_id; ?></td>
                          <td id="td_btn" style="vertical-align:middle">
                            <center><input type="button" class="btn btn-info btn-sm view_data" value="View Info" id="<?php echo $u_id; ?>"></center>
                          </td>
                          <td id="td_btn" style="vertical-align:middle">
                              <!-- when delete, census id must be sent, since it is used to go back after delete -->
                            <a href="<?php echo base_url(); ?>User/deleteUser/<?php echo $u_id; ?>" type="button" name="btn_delete_user" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete" onClick="return confirmItemStatusDetailsDelete();"><i class="fa fa-trash-o"></i></a>
                          </td>
                        </tr>
                  <?php } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                </div>
              </div><!-- /row -->
              <div class="row">
                <div class="col-lg-2 col-sm-2"> 
                  <button id="btn_add_new_user" name="btn_add_new_user" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewUserModal" ><i class="fa fa-plus"></i> Add New</button>
                </div>
                <div class="col-lg-3 col-sm-3">
                  <div class="form-group">
                    <div class="input-group addon">
                      <select class="form-control" id="select_user_status" name="select_user_status" title="Please select">
                      <option value="" selected>---Change Status---</option>
                        <?php foreach ($this->user_status as $row){ ?><!-- from School controller constructor method -->
                        <option value="<?php echo $row->status_id; ?>"><?php echo $row->status_type; ?></option>
                        <?php } ?>                                
                      </select>
                      <button type="submit" class="btn btn-default input-group-addon" name="btn_change_user" value="ChangeStatus"> Go </button>
                    </div> <!-- /input-group -->
                  </div>
                </div>
                <div class="col-lg-3 col-sm-3">
                  <div class="form-group">
                    <div class="input-group addon">
                      <select class="form-control" id="select_user_role" name="select_user_role" title="Please select">
                      <option value="" selected>---Change Role---</option>
                        <?php foreach ($this->user_roles as $row){ ?><!-- from School controller constructor method -->
                        <option value="<?php echo $row->role_id; ?>"><?php echo $row->roll_name; ?></option>
                        <?php } ?>                                
                      </select>
                      <button type="submit" class="btn btn-default input-group-addon" name="btn_change_user" value="ChangeRole"> Go </button>
                    </div> <!-- /input-group -->
                  </div>
                </div>
                <div class="col-lg-2 col-sm-2"> 
                  <button id="btn_change_usernm_pwd" name="btn_change_user" type="submit" class="btn btn-success btn-sm" value="setDefUnamePwd" style="margin:5px;"> Set to Default Username and Password</button>
                </div>
              </div><!-- /row -->
              <?php echo form_close(); ?>
                <?php
                  } else{ 
                      echo '<h4 align="center"> Add Users </h4>';
                    //}
                  } ?>
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php 
                if(!empty($user_details)) { 
                  $latest_upd_dt = strtotime($latest_upd_dt);
                  $user_update_dt = date("j F Y",$latest_upd_dt);
                  $user_update_tm = date("h:i A",$latest_upd_dt);
                  echo 'Updated on '.$user_update_dt.' at '.$user_update_tm;
                }
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row -->
      <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> User Details </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <div id="user_result"></div>
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div> <!-- /modal-footer -->
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
      <div class="modal fade" id="addNewUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Add New User </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_user_form", "name" => "insert_user_form", "accept-charset" => "UTF-8" );
                  echo form_open("User/addUserByAdmin", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="User Role" class="control-label"> User Role </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="user_role_select" name="user_role_select">
                            <option value="" selected>---Click here---</option>
                            <?php foreach ($this->user_roles as $row){ ?> 
                            <option value="<?php echo $row->role_id; ?>"><?php echo $row->roll_name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="User ID" class="control-label"> User Name </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control" id="usernm_txt" name="usernm_txt" placeholder="---Type here---" type="text" value="<?php echo set_value('usernm_txt'); ?>" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="User Status" class="control-label"> User Status </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <select class="form-control" id="user_status_select" name="user_status_select">
                            <option value="" selected>---Click here---</option>
                            <?php foreach ($this->user_status as $row){ ?> 
                            <option value="<?php echo $row->status_id; ?>"><?php echo $row->status_type; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
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
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#dataTable').DataTable({
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
        });
        $('#chkbox_all_select').click(function(){ // check boxes are checked using one chkbox
          if($(this).is(':checked')){
            $('#dataTable .checkbox').prop('checked',true);
          }else{
            $('#dataTable .checkbox').prop('checked',false);
          }
        });
      });

      $(document).ready(function(){
      // Start jQuery click function to view Bootstrap modal when view info button is clicked
        $('#dataTable').delegate('.view_data','click',function(){
          // Get the id of selected user and assign it in a variable called userData
            var userId = $(this).attr('id');
            //alert(userId);
            // Start AJAX function
            $.ajax({
            // Path for controller function which fetches selected user data
            url: "<?php echo base_url() ?>User/viewUserInfoByUserId",
            // Method of getting data
            method: "POST",
            // Data is sent to the server
            data: {userId:userId},
            // Callback function that is executed after data is successfully sent and recieved
            success: function(data){
              // Print the fetched data of the selected user in the section called #user_result 
              // within the Bootstrap modal
                $('#user_result').html(data);
                // Display the Bootstrap modal
                $('#userInfoModal').modal('show');
            }
          });
          // End AJAX function
        });
      });
  </script>
