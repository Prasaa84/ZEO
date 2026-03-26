<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script type="text/javascript">
  // display increment reminder sms status through a bootstrap modal
  $(document).on('click', '.btn_view_sms_status', function(){  
     var staff_id = $(this).attr("id");
     $.ajax({  
          url:"<?php echo base_url(); ?>increment/viewSmsStatus",  
          method:"POST",  
          data:{staff_id:staff_id},  
          dataType:"json",  
          success:function(data)  
          {  
               $('#viewSmsStatus').modal('show');  
               $('#id_txt').val(data.tr_inc_inform_id);  
               $('#inc_year_txt').val(data.increment_year); 
               if(data.sms_sent==1){
                  $('#sms_status_txt').val('Sent');  
               }else{
                  $('#sms_status_txt').val('Not sent');  
               }
               $('#remarks_txtarea').val(data.remarks); 
               $('#sent_date_txt').val(data.sms_sent_date);  
               $('.modal-title').text("SMS Status");  
          }, 
          error: function(xhr, status, error) {
            alert(xhr.responseText);
          } 
     })  
  });
  // display message sending window through a bootstrap modal
  $(document).on('click', '.btn_view_msg_modal', function(){  
     var staff_id = $(this).attr("id");
     $.ajax({  
          url:"<?php echo base_url(); ?>increment/getDatatoSendMessage",  
          method:"POST",  
          data:{staff_id:staff_id},  
          dataType:"json",  
          success:function(data)  
          {  
               $('#sendMessage').modal('show');  
               $('#stfid_txt').val(data.stf_id);  
               $('#name_txt').val(data.stf_name); 
               $('#school_txt').val(data.sch_name); 
               $('#incre_year_txt').val(data.increment_year); 
               $('#message_txtarea').val(data.stf_name+' has not submited the  '+ data.increment_year+' salary increment form yet '); 
               $('#census_id_hidden').val(data.census_id); 
               $('.modal-title').text("Sending a message to school");  
          }, 
          error: function(xhr, status, error) {
            alert(xhr.responseText);
          } 
     })  
  });
  // send the message using above modal
  $(document).on('click', '#btn_msg_send', function(e){ 
      e.preventDefault();
      //alert('asdf');
      var msg = $('#message_txtarea').val(); 
      var staff_id = $(this).attr("id");
      if(msg==''){
        swal("Error!", "Message field is empty", "warning");
        return false;
      }else{
        var DataString=$("#send_message_form").serialize();
        //alert(DataString);
        $.ajax({  
          url:"<?php echo base_url(); ?>increment/sendIncrementReminderMessage",  
          method:"POST",  
          data:$("#send_message_form").serialize(),
          success:function(data)  
          {  
            if(data.trim()=='Sent'){
              swal("Success!", "The message sent successfully", "success");
            }
          }, 
          error: function(xhr, status, error) {
            alert(xhr.responseText);
          } 
        }) 
      }
  });
 // display message history through a bootstrap modal
  $(document).on('click', '.btn_view_inform_history', function(){  
     var staff_id = $(this).attr("id");
     $.ajax({  
          url:"<?php echo base_url(); ?>increment/viewMessageHistory",  
          method:"POST",  
          data:{staff_id:staff_id},  
          dataType:"json",  
          success:function(data)  
          {  
              $('#messageHistory').modal('show'); 
              $('.messageHistoryDiv').html(data);    
          }, 
          error: function(xhr, status, error) {
            alert(xhr.responseText);
          } 
     })  
  });
    // display increment status of a teacher through a bootstrap modal
    $(document).on('click', '#btn_find_inc_status', function(){
      var nic_no = $('#nic_no_to_find_inc_status_txt').val();
      var year = $('#select_inc_status_year').val();
      $.ajax({  
          url:"<?php echo base_url(); ?>increment/viewIncrementByTeacher",  
          method:"POST",  
          data:{nic_no:nic_no,year:year},  
          dataType:"json",  
          success:function(data)  
          {  
              $('#findIncStatus').modal('show'); 
              $('.incStatusDiv').html(data);    
          }, 
          error: function(xhr, status, error) {
            alert(xhr.responseText);
          } 
    })  
  });
  $(document).ready(function(){
    $('table.table').DataTable();
  });
</script>
  <style type="text/css">
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
        <li class="breadcrumb-item active">Increments</li>
      </ol>
      <?php
        if(!empty($this->session->flashdata('msg'))) {
          $message = $this->session->flashdata('msg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php } ?> 
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
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-2 col-sm-6 mb-3">
          <div class="card text-white bg-info o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
              </div>
              <div class="mr-5">Received</div>
      <?php
              $status = ''; // කොට්ඨාස කාර්යාලයට බාර දුනි 
              $ci = & get_instance();
              $ci->load->model('Increment_model');
              $condition = '(tit.inc_status_id=1 or tit.inc_status_id=2 or tit.inc_status_id=3) and tit.increment_year='.date("Y");
              // division id is checked in the model
              $received = $ci->Increment_model->count_increment_by_condition($condition);
              echo '<h1 align="center">'.$received.'</h1>';
      ?>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>Increment/viewIncrements">
              <span class="float-left"> Add new or View... </span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i> 
              </span>
            </a>
          </div><!-- /card-->
        </div>
        <div class="col-xl-2 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
              </div>
              <div class="mr-5">Defects</div>
      <?php
              // increments with defects. 
              $ci = & get_instance();
              $ci->load->model('Increment_model');
              $defects = $ci->Increment_model->count_increment_with_defects(date("Y"));
              echo '<h1 align="center">'.$defects.'</h1>';
      ?>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>Increment/viewIncrements/1/1">
              <span class="float-left"> View... </span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
        <div class="col-xl-2 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
              </div>
              <div class="mr-5">Approved</div>
      <?php
              $status = 2; // කොට්ඨාස කාර්යාලයෙන් අනුමත කරන ලදි. 
              $ci = & get_instance();
              $ci->load->model('Increment_model');
              $condition = '( tit.inc_status_id=2 or tit.inc_status_id=3 ) and tit.increment_year='.date("Y");
              $approved = $ci->Increment_model->count_increment_by_condition($condition);
              echo '<h1 align="center">'.$approved.'</h1>';
      ?>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>Increment/viewIncrements/2">
              <span class="float-left"> View... </span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
        <div class="col-xl-2 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
              </div>
              <div class="mr-5">Submitted</div>
      <?php
              $ci = & get_instance();
              $ci->load->model('Increment_model');
              $condition = '( tit.inc_status_id=3 ) and tit.increment_year='.date("Y");
              $submitted = $ci->Increment_model->count_increment_by_condition($condition);
              echo '<h1 align="center">'.$submitted.'</h1>';
      ?>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>Increment/viewIncrements/3">
              <span class="float-left"> View... </span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
        <div class="col-xl-2 col-sm-6 mb-3">
          <div class="card text-white bg-info o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-search"></i>
              </div>
              <div class="mr-5"> Reports</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>Increment/viewIncrementReports"">
              <span class="float-left">View</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
        <div class="col-xl-2 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-search"></i>
              </div>
              <div class="mr-5">Status</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="" data-toggle="modal" data-target="#findIncStatus" >
              <span class="float-left">Check</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
      </div><!-- /row1-->
      
      <!-- /following bootstrap model used to view sms status  -->
      <div class="modal fade" id="viewSmsStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> නව වැටුප් වර්ධක අයදුම්පත </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_new_increment_form", "name" => "insert_new_increment_form", "accept-charset" => "UTF-8" );
                  echo form_open("computerLab/addComResItem", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="id" class="control-label"> ID  </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="id_txt" name="id_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="year" class="control-label"> Increment Year  </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="inc_year_txt" name="inc_year_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="sms status" class="control-label"> SMS Status </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="sms_status_txt" name="sms_status_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="sent date" class="control-label"> Sent Date   </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="sent_date_txt" name="sent_date_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="remarks" class="control-label"> Remarks   </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <textarea class="form-control" id="remarks_txtarea" name="remarks_txtarea" placeholder=""></textarea> 
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <input type="hidden" value="<?php echo $staff_id; ?>" id="" name="staff_id" >
              <input type="hidden" value="<?php echo date("Y"); ?>" id="inc_year" name="inc_year" >
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
      <!-- /following bootstrap model used to send message -->
      <div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> වැටුප් වර්ධක පණිවුඩය  </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal send_message_form", "id" => "send_message_form", "name" => "send_message_form", "accept-charset" => "UTF-8" );
                  echo form_open("", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="id" class="control-label"> Staff ID  </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="stfid_txt" name="stfid_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="name" class="control-label"> Name  </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="name_txt" name="name_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="school" class="control-label"> School  </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="school_txt" name="school_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="year" class="control-label"> Increment Year  </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="incre_year_txt" name="incre_year_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Message" class="control-label"> Message </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <textarea class="form-control" id="message_txtarea" name="message_txtarea" placeholder=""></textarea> 
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <input type="hidden" value="" id="census_id_hidden" name="census_id_hidden">
              <button class="btn btn-primary" type="submit" name="btn_msg_send" id="btn_msg_send" data-dismiss="modal" value="Send"> Send </button>
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
<!-- ------------ following bootstrap model used to view message history------------------------------------------ -->
      <div class="modal fade" id="messageHistory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> වැටුප් වර්ධක පණිවුඩ </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <div id="messageHistoryDiv" class="messageHistoryDiv" align="center" style="margin:0 auto;" >
                    
                  </div> <!-- /col-sm-12 -->
                </div>
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div> <!-- /modal-footer -->
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
      <!-- ------------ following bootstrap model used to view increment status of a teacher-------------------------------- -->
      <div class="modal fade" id="findIncStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> වැටුප් වර්ධක පණිවුඩයෙහි තත්ත්වය</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal finc_inc_status_form form-inline", "id" => "finc_inc_status_form", "name" => "send_message_form", "accept-charset" => "UTF-8" );
                  echo form_open("", $attributes);?>
                    <div class="form-group" class="col-lg-6 col-sm-6">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="id" class="control-label"> NIC No  </label>
                        </div>
                        <div class="col-lg-3 col-sm-3">
                          <input class="form-control" id="nic_no_to_find_inc_status_txt" name="nic_no_to_find_inc_status_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group" class="col-lg-6 col-sm-6">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="Employee Type" class="control-label"> වැටුප් වර්ධක වර්ෂය  </label>
                        </div>
                        <div class="col-lg-3 col-sm-3">
                          <select class="form-control" id="select_inc_status_year" name="select_inc_status_year" title="Please select">
                            <option value="<?php echo date('Y'); ?>" selected="selected" ><?php echo date('Y'); ?></option>
                            <?php 
                              $starting_year = 2020;
                              $current_year = date('Y');
                              for( $current_year; $current_year >= $starting_year; $current_year-- ) {
                                echo '<option value="'.$current_year.'">'.$current_year.'</option>';
                              }  
                            ?>                               
                          </select>                         
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->                     

                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="col-sm-12 my-auto">
              <div id="incStatusDiv" class="incStatusDiv" align="center" style="margin:0 auto;" >
                    
              </div> <!-- /incStatusDiv -->
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary" type="button" name="btn_find_inc_status" id="btn_find_inc_status" value="View"> View </button>
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div> <!-- /modal-footer -->
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
    </div> <!-- /.container-fluid-->
    <!-- /.content-wrapper-->