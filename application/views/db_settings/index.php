<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Dashboard</a></li>
      <li class="breadcrumb-item active"> DB Settings </li>
    </ol>
    <div class="row" id="main row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12 col-sm-12">
            <div class="card mb-3" id="">
              <div class="card-header">
                <i class="fa fa-database"></i> Database
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 my-auto">
                    <?php
                      if(!empty($this->session->flashdata('backupMsg'))) {
                        $message = $this->session->flashdata('backupMsg');  ?>
                          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
                    <?php } ?>
                    <?php
                    $attributes = array("class" => "form-horizontal", "id" => "db-backup", "name" => "db-backup");
                    echo form_open("DbSettings/dbBackup", $attributes);?>
                    <div id="user_info">
                      <fieldset>
                        <div class="form-group">
                            <div class="col-lg-12 col-sm-12">
                              <label for="username"> <?php echo $backUpData; ?> </label>
                            </div>
                        </div> <!-- /form group -->
                        <div class="form-group">
                            <div class="col-lg-3 col-sm-3">
                              <input id="btn_change_unm" name="btn_do_db_backup" type="submit" class="btn btn-primary btn-block" value="Backup" />
                            </div>
                        </div> <!-- /form group -->
                      </fieldset>
                    </div> <!-- / #user_info -->
                    <?php echo form_close(); ?>
                  </div> <!-- /col-sm-12 -->  
                </div> <!-- /row -->
              </div> <!-- /card body --> 
            </div> <!-- /card -->
          </div> <!-- /col-lg-12 col-sm-12 -->
        </div> <!-- /row -->
      </div> <!-- /col-lg-6 col-sm-6 -->

    </div> <!-- /main row -->
  </div> <!-- /container-fluid -->
