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
            <a href="<?php echo base_url(); ?>userMessages">Messages</a>
        </li>
        <li class="breadcrumb-item active">Message</li>
      </ol>
<?php
        if(!empty($this->session->flashdata('msg'))) {
            $response = $this->session->flashdata('msg');  ?>
            <div class="<?php echo $response['class']; ?>" ><?php echo $response['text']; ?></div>
<?php   } ?> 

      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-message"></i>
                Message
              </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
          <?php   if(!empty($message)) { //print_r($increment_data); die(); ?>   
                  <div class="table-responsive">
                    <table id="" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th class="col-sm-2"></th>
                          <th class="col-sm-10"></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($message as $row){ 
                          $msg_id = $row->msg_id; 
                          $msg_cat_id = $row->msg_cat_id;
                          $msg_category = $row->msg_category;
                          //$census_id = $row->census_id;
                          $message = $row->message;
                          $by_whom = $row->by_whom;
                          if($this->session->userdata['userrole_id'] == '1'){
                            $to_whom = 'Administrator';
                          }if($this->session->userdata['userrole_id'] == '2'){
                            $name = $row->name_with_ini;
                            $to_whom = $row->sch_name;
                          }elseif($this->session->userdata['userrole_id'] == '7'){
                            $name = $this->session->userdata['div_id'];
                            $to_whom = $name;
                          }else{
                            $to_whom = $userrole;
                            $name = $row->name;
                          }
                          if($msg_cat_id==3){
                            $academic_year = '';
                          }else{
                            $academic_year = $row->academic_year;
                          }
                          if($row->is_read==0){
                            $is_read = 'No';
                            $style = 'style="font-weight: 700;" ';
                          }else{
                            $is_read = 'Yes';
                            $style = '';
                          }
                          $name = $row->name;
                          $company = $row->company;
                          $tel = $row->phone_no;
                          $email = $row->email;
                          $read_on = $row->when_read;
                          $send_date = $row->send_date;
                          $replied_by = $row->replied_by;
                          $replied_on = $row->replied_on;
                          $no = $no + 1;  
                        ?>
                        <tr>
                          <th> Name </th>
                          <td style="vertical-align:middle" ><?php echo $name; ?></td>
                        </tr>
                        <tr>
                          <th> Company </th>
                          <td style="vertical-align:middle" ><?php echo $company; ?></td>
                        </tr>
                        <tr>
                          <th> Phone No </th>
                          <td style="vertical-align:middle" ><?php echo $tel; ?></td>
                        </tr>
                        <tr>
                          <th> Email </th>
                          <td style="vertical-align:middle" ><?php echo $email; ?></td>
                        </tr>
                        <tr>
                          <th>Category</th>
                          <td style="vertical-align:middle;"><?php echo $msg_category; ?></td>
                        </tr>
                        <tr>
                          <th>Message</th>
                          <td style="vertical-align:middle;"><?php echo $message; ?></td>
                        </tr>
                        <tr>
                          <th>By Whom</th>
                          <td style="vertical-align:middle;"><?php echo $by_whom; ?></td>
                        </tr>
                        <tr>
                          <th>To Whom</th>
                          <td style="vertical-align:middle;"><?php echo $to_whom; ?></td>
                        </tr>
                <?php   if ($msg_cat_id != 3) {  ?>
                          <tr>
                            <th> Year </th>
                            <td style="vertical-align:middle;"><?php echo $academic_year; ?></td>
                          </tr>
                <?php   }   ?>
                        <tr>
                          <th>Is Read</th>
                          <td style="vertical-align:middle;"><?php echo $is_read; ?></td>
                        </tr>
                        <tr>
                          <th>Read On</th>
                          <td style="vertical-align:middle;"><?php echo $read_on; ?></td>
                        </tr>
                        <tr>
                          <th>Received On</th>
                          <td style="vertical-align:middle;"><?php echo $send_date; ?></td>
                        </tr>
                        <tr>
                          <th>Replied By</th>
                          <td style="vertical-align:middle;"><?php echo $replied_by; ?></td>
                        </tr>
                        <tr>
                          <th>Replied On</th>
                          <td style="vertical-align:middle;"><?php echo $replied_on; ?></td>
                        </tr>
                  <?php if( empty( $replied_by ) ) { ?>
                        <tr>
                          <th></th>
                          <td><input type="button" id="reply" name="reply" data-toggle="modal" data-target="#message" value="Reply" class="btn btn-primary btn-sm"></td>
                        </tr>
                  <?php } ?>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
          <?php   } ?>  
              </div> 
            </div> <!-- /col-lg-12 -->
            </div>
            <div class="card-footer small text-muted">
              <?Php 
                
              ?>
            </div>
          </div>
        </div>
      </div>
      <!-- ------------ following bootstrap model used to view message ------------------------------------------ -->
      <div class="modal fade" id="message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Reply to Message </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                <?php
                  $attributes = array("class" => "form-horizontal", "id" => "reply_message_form", "name" => "reply_message_form", "accept-charset" => "UTF-8" );
                  echo form_open("UserMessages/replyToMessage", $attributes); ?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label"> Name <font color="#ff0000"> * </font></label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="name_txt" name="name_txt" type="email" value="<?php echo $name; ?>" readonly />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label"> Email <font color="#ff0000"> * </font></label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="email_txt" name="email_txt" type="email" value="<?php echo $email; ?>" readonly />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label"> Subject of Email <font color="#ff0000"> * </font></label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="subject_txt" name="subject_txt" type="text" value=""  />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="full name" class="control-label">Reply<font color="#ff0000"> * </font> </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input type="hidden" name="msg_id" value="<?php echo $msg_id; ?>" id="msg_id_hidden" name="msg_id_hidden "/>
                          <input class="form-control" name="reply_message_txtarea" rows="5" type="textarea" id="reply_message_txtarea" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                </div>
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-primary" type="submit">Reply</button>
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div> <!-- /modal-footer -->
            </fieldset>
            <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
    </div> <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
  <script type="text/javascript">
    // display message history through a bootstrap modal
    $(document).on('click', '.btn_view_message', function(){  
       var msg_id = $(this).attr("id");
       $.ajax({  
            url:"<?php echo base_url(); ?>UserMessages/viewMessage",  
            method:"POST",  
            data:{msg_id:msg_id},  
            dataType:"json",  
            success:function(data)  
            {  
                $('#message').modal('show'); 
                $('.messageDiv').html(data);    
            }, 
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            } 
       })  
    });
  </script>