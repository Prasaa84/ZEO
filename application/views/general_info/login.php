    <?php //echo md5('teacher')."<br />"; echo md5('clerk_school');
      if(isset($this->session->userdata)){
        //echo $this->session->userdata('userrole_id');
        // echo md5('morawaka_div_user123');
      } 
    ?>

    <section id="login">
        <div class="container">
            <div class="wow fadeInDown">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-sm-4" align="center">
                      <i class="fa fa-key fa-4x" style="color: green;" align="center"></i>
                    </div>
                    <div class="col-sm-8">
                      <h1 align="" class="h1">User Login</h1>

                    </div>
                  </div>
                  <?php
                    $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform");
                    echo form_open("User/login", $attributes);?>
                    <fieldset>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4 col-sm-4">
                            <label for="txt_username" class="control-label">Username</label>
                          </div>
                          <div class="col-lg-8 col-sm-8">
                            <input class="form-control" id="txt_username" name="txt_username" placeholder="Username" type="text" value="<?php echo set_value('txt_username'); ?>" data-toggle="tooltip" title="Username"/>
                            <span class="text-danger"><?php echo form_error('txt_username'); ?></span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4 col-sm-4">
                            <label for="txt_password" class="control-label">Password</label>
                          </div>
                          <div class="col-lg-8 col-sm-8">
                            <input class="form-control" id="txt_password" name="txt_password" placeholder="Password" type="password" value="<?php echo set_value('txt_password'); ?>" data-toggle="tooltip" title="Password"/>
                            <span class="text-danger"><?php echo form_error('txt_password'); ?></span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-12 col-sm-12 text-center">
                            <input id="btn_login" name="btn_login" type="submit" class="btn btn-success" value="Login" onclick="submitBasicFeedback();"/>
                            <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-warning" value="Cancel" />
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4 col-sm-4">
                          </div>
                          <div class="col-lg-8 col-sm-8">
                            <a href="#" data-toggle="modal" data-target="#unmPwdRecoveryModal"> Forgot Username or Password? </a>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <?php echo form_close(); ?>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
            </div>
        </div>
    </section><!--/about-us-->
      <div class="modal fade" id="unmPwdRecoveryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Username and Password Recovery </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "unm_pwd_recover_form", "name" => "unm_pwd_recover_form", "accept-charset" => "UTF-8" );
                  echo form_open("User/loginRecover", $attributes);?>
                  <fieldset>
                    <div class="form-group" style="margin:10px;">
                      <div class="row">
                        <div class="col-lg-4 col-sm-4">
                          <label for="Email" class="control-label"> Email </label>
                        </div>
                        <div class="col-lg-8 col-sm-8">
                          <input class="form-control" id="email_txt" name="email_txt" placeholder="---Type here---" type="text" value="<?php echo set_value('email_txt'); ?>" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal"> Cancel </button>
              <button class="btn btn-primary" type="submit" name="btn_recover" value="RecoverUnPwd"> Submit </button>
            </div> <!-- /modal-footer -->
                </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
