<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
      <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user"> User </a></li>
      <li class="breadcrumb-item active"> User Settings </li>
    </ol>
    <div class="row" id="main row">
      <div class="col-lg-6">
        <div class="row">
          <div class="col-lg-12 col-sm-12">
            <div class="card mb-3" id="">
              <div class="card-header">
                <i class="fa fa-building"></i> Change Username
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 my-auto">
                    <?php
                      if(!empty($this->session->flashdata('changeMsg'))) {
                        $message = $this->session->flashdata('changeMsg');  ?>
                          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
                    <?php } ?>
                    <?php
                    $attributes = array("class" => "form-horizontal", "id" => "update-uname", "name" => "update-uname");
                    echo form_open("User/changeUnm", $attributes);?>
                    <div id="user_info">
                      <fieldset>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-3 col-sm-3">
                              <label for="username"> Current User Name </label>
                            </div>
                            <div class="col-lg-9 col-sm-9">
                              <input class="form-control" id="cur_uname_txt" name="cur_uname_txt" placeholder="--- Type here ---" type="text" />
                              <span class="text-danger"><?php echo form_error('cur_uname_txt'); ?></span>
                            </div>
                          </div> <!-- /row -->
                        </div> <!-- /form group -->
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-3 col-sm-3">
                              <label for="current password"> New User Name </label>
                            </div>
                            <div class="col-lg-9 col-sm-9">
                              <input class="form-control" id="new_uname_txt" name="new_uname_txt" placeholder="---Type here---" type="text" />
                              <span class="text-danger"><?php echo form_error('new_uname_txt'); ?></span>
                            </div>
                          </div> <!-- /row -->
                        </div> <!-- /form group -->
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-3 col-sm-3"></div>
                            <div class="col-lg-9 col-sm-9 ">
                            <?php 
                            ?>
                              <input type="hidden" name="user_id_hidden" value="<?php echo $userid; ?>" />
                              <input id="btn_change_unm" name="btn_change_unm" type="submit" class="btn btn-primary mr-2 mt-2" value="Change" />
                              <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-warning mt-2 mr-2" value="Cancel" style="margin-top: 10px;" />
                            </div>
                          </div>
                        </div> <!-- /form group -->
                      </fieldset>
                    </div> <!-- / #user_info -->
                    <?php echo form_close(); ?>
                  </div> <!-- /col-sm-12 -->  
                </div> <!-- /row -->
              </div> <!-- /card body -->
              <div class="card-footer small text-muted">
              <?php
                if(!empty($userData)) {   
                  foreach($userData as $row){  
                    $user_updated_dt = $row->user_updated_dt;
                  }
                  $last_update_dt = strtotime($user_updated_dt);
                  $user_details_last_updated_date = date("j F Y",$last_update_dt);
                  $user_details_last_updated_time = date("h:i A",$last_update_dt);
                  echo 'Updated on '.$user_details_last_updated_date.' at '.$user_details_last_updated_time;
                }
              ?>
              </div>  
            </div> <!-- /card -->
          </div> <!-- /col-lg-12 col-sm-12 -->
        </div> <!-- /row -->
      </div> <!-- /col-lg-6 col-sm-6 -->
      <div class="col-lg-6">
        <div class="row">
          <div class="col-lg-12 col-sm-12">
            <div class="card mb-3" id="">
              <div class="card-header">
                <i class="fa fa-building"></i> Change Password
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 my-auto">
                    <?php
                      if(!empty($this->session->flashdata('changePwdMsg'))) {
                        $message = $this->session->flashdata('changePwdMsg');  ?>
                          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
                    <?php } ?>
                    <?php
                      if(!empty($this->session->flashdata('email_sent'))) {
                        $message = $this->session->flashdata('email_sent');  ?>
                          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
                    <?php } ?>
                    <?php
                    $attributes = array("class" => "form-horizontal", "id" => "update-pwd", "name" => "update-pwd");
                    echo form_open("User/changePwd", $attributes);?>
                    <div id="user_info">
                      <fieldset>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-3 col-sm-3">
                              <label for="username"> Current Password </label>
                            </div>
                            <div class="col-lg-9 col-sm-9">
                              <input class="form-control" id="old_pwd_txt" name="old_pwd_txt" placeholder="--- Type here ---" type="text" />
                              <span class="text-danger"><?php echo form_error('old_pwd_txt'); ?></span>
                            </div>
                          </div> <!-- /row -->
                        </div> <!-- /form group -->
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-3 col-sm-3">
                              <label for="current password"> New Password </label>
                            </div>
                            <div class="col-lg-9 col-sm-9">
                              <input class="form-control" id="new_pwd_txt" name="new_pwd_txt" placeholder="---Type here---" type="text" />
                              <span class="text-danger"><?php echo form_error('new_pwd_txt'); ?></span>
                            </div>
                          </div> <!-- /row -->
                        </div> <!-- /form group -->
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-3 col-sm-3">
                              <label for="current password"> Confirm New Password </label>
                            </div>
                            <div class="col-lg-9 col-sm-9">
                              <input class="form-control" id="confirm_new_pwd_txt" name="confirm_new_pwd_txt" placeholder="---Type here---" type="text" />
                              <span class="text-danger"><?php echo form_error('confirm_new_pwd_txt'); ?></span>
                            </div>
                          </div> <!-- /row -->
                        </div> <!-- /form group -->
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-3 col-sm-3"></div>
                            <div class="col-lg-9 col-sm-9 ">
                            <?php 
                            ?>
                              <input type="hidden" name="user_id_hidden" value="<?php echo $userid; ?>" />
                              <input id="btn_change_pwd" name="btn_change_pwd" type="submit" class="btn btn-primary mr-2 mt-2" value="Change" />
                              <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-warning mt-2 mr-2" value="Cancel" style="margin-top: 10px;" />
                            </div>
                          </div>
                        </div> <!-- /form group -->
                      </fieldset>
                    </div> <!-- / #user_info -->
                    <?php echo form_close(); ?>
                  </div> <!-- /col-sm-12 -->  
                </div> <!-- /row -->
              </div> <!-- /card body -->
              <div class="card-footer small text-muted">
              </div>  
            </div> <!-- /card -->
          </div> <!-- /col-lg-12 col-sm-12 -->
        </div> <!-- /row -->
      </div> <!-- /col-lg-6 col-sm-6 -->
    </div> <!-- /main row -->
  </div> <!-- /container-fluid -->
