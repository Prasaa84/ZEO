<?php
  foreach($this->session as $user_data){
    $role_id = $user_data['userrole_id'];
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
          <a href="<?php echo base_url(); ?>school">School</a>
        </li>
        <li class="breadcrumb-item active">Add School</li>
      </ol>
      <?php
        if(!empty($this->session->flashdata('msg'))) {
          $message = $this->session->flashdata('msg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php } ?>   
      <?php
        if(!empty($this->session->flashdata('emailStatus'))) {
          $message = $this->session->flashdata('emailStatus');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php } ?>   
      <div class="row">
        <div class="col-lg-8">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-building"></i> පාසලේ තොරතුරු ඇතුළත් කිරීම
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                    $attributes = array("class" => "form-horizontal", "id" => "insert-school", "name" => "insert-school");
                    echo form_open("School/addSchool", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="census id">සංඝනන අංකය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="txt_census_id" name="txt_census_id" placeholder="--- සංඝනන අංකය ---" type="text" value="<?php echo set_value('txt_census_id'); ?>" />
                          <span class="text-danger"><?php echo form_error('txt_census_id'); ?></span>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="school_name" class="control-label">පාසලේ නම</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="txt_school_name" name="txt_school_name" placeholder="---පාසලේ නම---" type="text" value="<?php echo set_value('txt_school_name'); ?>" />
                          <span class="text-danger"><?php echo form_error('txt_school_name'); ?></span>
                        </div>
                      </div>
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="txt_email" class="control-label">විද්‍යුත් තැපෑල</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="txt_email" name="txt_email" placeholder="---විද්‍යුත් තැපෑල් ලිපිනය---" type="text" value="<?php echo set_value('txt_email'); ?>" />
                          <span class="text-danger"><?php echo form_error('txt_email'); ?></span>
                        </div>
                      </div>
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="school_type" class="control-label">පාසල් වර්ගය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="select_sch_type" name="select_sch_type" title="Please select" data-toggle="tooltip">
                            <option value="" selected>---ක්ලික් කරන්න---</option>
                            <?php 
                              if(!empty($this->all_sch_types)){
                                foreach ($this->all_sch_types as $row){ ?><!-- from PhysicalResource controller constructor method -->
                                <option value="<?php echo $row->sch_type_id; ?>"><?php echo $row->sch_type; ?></option>
                            <?php } }else{ ?>
                                <option value="" selected>No records found!!!</option>
                            <?php } ?>     
                          </select>
                          <span class="text-danger"><?php echo form_error('select_sch_type'); ?></span>
                        </div>
                      </div>
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="txt_edudiv" class="control-label">කුමන පාසලක්ද?</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="select_belongs_to" name="select_belongs_to" title="Please select" data-toggle="tooltip">
                          <option value="" selected>---ක්ලික් කරන්න---</option>
                            <option value="1">පළාත් පාසලකි</option>
                            <option value="2">ජාතික පාසලකි</option>
                          </select>
                          <span class="text-danger"><?php echo form_error('select_belongs_to'); ?></span>
                        </div>
                      </div>
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3"></div>
                        <div class="col-lg-9 col-sm-9 ">
                          <input id="btn_insert_school" name="btn_insert_school" type="submit" class="btn btn-primary mr-2 mt-2" value="Submit" />
                          <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-warning mt-2" value="Cancel" style="margin-top: 10px;" />
                        </div>
                      </div>
                    </div> <!-- /form group -->
                  </fieldset>
                  <?php echo form_close(); ?>
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /card body -->
          </div> <!-- /card -->
          <hr class="mt-2">
        </div> <!-- /col-lg-8 -->
        <div class="col-lg-4">

        </div>
      </div> <!-- /row -->
    </div> <!-- /container-fluid -->