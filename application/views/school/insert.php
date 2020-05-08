    <section id="insert-school">
        <div class="container">
            <div class="wow fadeInDown">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                  <?php
                    if($this->session->flashdata('msg')) {   ?>
                      <div class="alert alert-success" style="padding: 5px 5px 5px 0px;">
                          <?php echo $this->session->flashdata('msg'); ?>
                      </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-sm-8" style="padding-left: 0px;">
                            <h1 align="" class="h1">Insert School Details</h1><br />
                        </div>
                    </div>
                      <?php
                      $attributes = array("class" => "form-horizontal", "id" => "insert-school", "name" => "insert-school");
                      echo form_open("School/createSchool", $attributes);?>
                      <fieldset>
                           <div class="form-group">
                             <div class="row">
                               <div class="col-lg-3 col-sm-3">
                                    <label for="txt_census_id" class="control-label">Census ID</label>
                               </div>
                               <div class="col-lg-9 col-sm-9">
                                    <input class="form-control" id="txt_census_id" name="txt_census_id" placeholder="School ID" type="text" value="<?php echo set_value('txt_census_id'); ?>" />
                                    <span class="text-danger"><?php echo form_error('txt_census_id'); ?></span>
                               </div>
                             </div>
                           </div>
                           <div class="form-group">
                             <div class="row">
                                <div class="col-lg-3 col-sm-3">
                                  <label for="txt_school_name" class="control-label">School Name</label>
                                </div>
                                <div class="col-lg-9 col-sm-9">
                                  <input class="form-control" id="txt_school_name" name="txt_school_name" placeholder="School Name" type="text" value="<?php echo set_value('txt_school_name'); ?>" />
                                  <span class="text-danger"><?php echo form_error('txt_school_name'); ?></span>
                                </div>
                             </div>
                           </div>
                           <div class="form-group">
                             <div class="row">
                                <div class="col-lg-3 col-sm-3">
                                  <label for="txt_address" class="control-label">Address</label>
                                </div>
                                <div class="col-lg-9 col-sm-9">
                                  <input class="form-control" id="txt_address" name="txt_address" placeholder="School Address" type="text" value="<?php echo set_value('txt_address'); ?>" />
                                  <span class="text-danger"><?php echo form_error('txt_address'); ?></span>
                                </div>
                             </div>
                           </div>
                           <div class="form-group">
                             <div class="row">
                                <div class="col-lg-3 col-sm-3">
                                  <label for="txt_email" class="control-label">Email</label>
                                </div>
                                <div class="col-lg-9 col-sm-9">
                                  <input class="form-control" id="txt_email" name="txt_email" placeholder="School Email" type="text" value="<?php echo set_value('txt_email'); ?>" />
                                  <span class="text-danger"><?php echo form_error('txt_email'); ?></span>
                                </div>
                             </div>
                           </div>
                           <div class="form-group">
                            <div class="row">
                              <div class="col-lg-3 col-sm-3"></div>
                              <div class="col-lg-9 col-sm-9 ">
                                  <input id="btn_insert_school" name="btn_insert_school" type="submit" class="btn btn-primary" value="Submit" />
                                  <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-warning" value="Cancel" style="margin-top: 10px;" />
                              </div>
                            </div>
                           </div>
                      </fieldset>
                      <?php echo form_close(); ?>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </section><!--/about-us-->