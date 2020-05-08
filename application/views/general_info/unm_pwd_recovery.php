    <?php //echo md5('teacher')."<br />"; echo md5('clerk_school');
      if(isset($this->session->userdata)){
        //echo $this->session->userdata('userrole_id');
        //echo md5('07027');
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
                    $attributes = array("class" => "form-horizontal", "id" => "unm_pwd_recovery_form", "name" => "unm_pwd_recovery_form");
                    echo form_open("User/login", $attributes);?>
                    <fieldset>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-4 col-sm-4">
                            <label for="txt_username" class="control-label">Username</label>
                          </div>
                          <div class="col-lg-8 col-sm-8">
                            <input class="form-control" id="txt_username" name="txt_username" placeholder="Username" type="text" value="<?php echo set_value('txt_username'); ?>" data-toggle="tooltip" title="Default is School census ID"/>
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
                            <input class="form-control" id="txt_password" name="txt_password" placeholder="Password" type="password" value="<?php echo set_value('txt_password'); ?>" data-toggle="tooltip" title="Default is user NIC"/>
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
                    </fieldset>
                    <?php echo form_close(); ?>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </section><!--/about-us-->
