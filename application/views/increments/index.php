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
            if( data.email_sent == 1 ){
              $('#emal_status_txt').val('Yes').css('color','green');  
              $('#email_sent_date_txt').val(data.email_sent_date); 
            }else{
              $('#emal_status_txt').val('No').css('color','red');  
              $('#email_sent_date_txt').val(''); 
            }
            $('#email_info_txtarea').val(data.email_info); 
            if( data.sms_sent == 1 ){
              $('#sms_status_txt').val('Yes').css('color','green');  
              $('#sms_sent_date_txt').val(data.sms_sent_date);  
            }else{
              $('#sms_status_txt').val('No').css('color','red');  
              $('#sms_sent_date_txt').val('');  
            }
            $('#sms_info_txtarea').val(data.sms_info); 
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
  <style type="text/css">
    th, td { white-space: nowrap; }
      div.dataTables_wrapper {
          height: 200px;
          width: 1200px;
          margin: 0 auto;
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
      $census_id = $user_data['census_id'];
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
        <div class="col-xl-2 col-sm-2 mb-3">
          <div class="card text-white bg-info o-hidden h-60">
            <div class="card-body">
              <div class="mr-5">Submitted </div>
      <?php
              $status = ''; // කොට්ඨාස කාර්යාලයට බාර දුනි 
              $ci = & get_instance();
              $ci->load->model('Increment_model');
              if($role_id==2){
                $condition = '(tit.inc_status_id=1 or tit.inc_status_id=2 or tit.inc_status_id=3) and tit.increment_year='.date("Y");
              }else{
                $condition = '(tit.inc_status_id=1 or tit.inc_status_id=2 or tit.inc_status_id=3) and tit.increment_year='.date("Y");
              }
              $received = $ci->Increment_model->count_increment_by_condition($condition);
      ?>  
              <a class="text-white clearfix small z-1" href="<?php echo base_url(); ?>Increment/viewIncrements/1"> <h1 align="center"> <?php echo $received; ?> </h1></a>
            </div>
          </div><!-- /card-->
        </div>
        <div class="col-xl-2 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-60">
            <div class="card-body">
              <div class="mr-5">Defects</div>
      <?php
              // increments with defects. 
              $ci = & get_instance();
              $ci->load->model('Increment_model');
              $defects = $ci->Increment_model->count_increment_with_defects(date("Y"));
      ?>
              <a class="text-white clearfix small z-1" href="<?php echo base_url(); ?>Increment/viewIncrements/1/1"> <h1 align="center"> <?php echo $defects; ?> </h1></a>
            </div>
          </div><!-- /card-->
        </div>
        <div class="col-xl-2 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
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
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
                ඉදිරි දින 30 තුළ වැටුප් වර්ධක අයදුම්පත් ලබාදිය යුතු ගුරුවරුන් 
              </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h6 align="center"> ඉදිරි දින 30 තුළ වැටුප් වර්ධක අයදුම්පත් ලබාදිය යුතු ගුරුවරුන් </h6>
                  <?php if(!empty($coming_salary_increments)) { //print_r($increment_data); die(); ?>   
                  <div class="table-responsive">
                    <table id="dataTable1" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> නම </th>
                          <th> පාසල </th>
                          <th>හැඳුනුම්පත් අංකය</th>
                          <th>ස්ත්‍රී/පුරුෂ</th>
                          <th> දු.ක.</th>
                          <th>තනතුර</th>
                          <th>මුල් පත්විමේ දිනය </th>
                          <th>SMS</th><th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($coming_salary_increments as $row){  
                          $staff_id = $row->stf_id;
                          $census_id = $row->census_id;
                          //$census_id = $row->census_id;
                          $name_with_ini = $row->name_with_ini;
                          $school = $row->sch_name;
                          $nic_no = $row->nic_no;
                          $gender_name = $row->gender_name;
                          $phone_mobile1 = $row->phone_mobile1;
                          $desig_type = $row->desig_type;
                          $first_app_date = $row->first_app_dt;
                          $update_dt = $row->last_update;
                          //$sms_status = $row->sms_sent;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr>
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                          <td style="vertical-align:middle" ><?php echo $school; ?></td>
                          <td style="vertical-align:middle" ><?php echo $nic_no; ?></td>
                          <td style="vertical-align:middle" ><?php echo $gender_name; ?></td>
                          <td style="vertical-align:middle" ><?php echo $phone_mobile1; ?></td>
                          <td style="vertical-align:middle" ><?php echo $desig_type; ?></td>
                          <td style="vertical-align:middle" ><?php echo $first_app_date; ?></td>
                          <td id="td_btn" style="vertical-align:middle" align="center">
                            <input type="hidden" value="<?php echo $staff_id; ?>" name="staff_id" id="staff_id">
                            <a type="button" id="<?php echo $staff_id; ?>" name="btn_view_sms_status" type="button" class="btn btn-info btn-sm btn_edit_phy_res btn_view_sms_status" value="<?php echo $staff_id; ?>" title="<?php echo $staff_id; ?>" data-toggle="tooltip" data-hidden="" ><i class="fa fa-eye"></i></a>
                          </td>
                          <td id="td_btn" style="vertical-align:middle">
                            
                          </td>
                        </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php }else{ // if empty($acStaffDetails)
                    if(($userrole=='School User') && empty($acStaffDetails)){
                      echo '<h4 align="center">No Records!!!</h4>'; 
                    }else if(($userrole=='Administrator') && empty($acStaffDetails)){
                      echo '<h4 align="center">Add or Search Records!!!</h4>'; 
                    }else{
                      echo '<h4 align="center">Search Details</h4>';
                    }
                  } ?>  
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
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
              මෙම වර්ෂයේ <?php echo date("Y:m:d"); ?> දින දක්වා වැටුප් වර්ධක ලබා නොදුන් ගුරුවරුන්</div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h6 align="center"> මෙම වර්ෂයේ <?php echo date("Y:m:d"); ?> දින දක්වා වැටුප් වර්ධක ලබා නොදුන් ගුරුවරුන්</h6>
                  <?php if( !empty( $increment_data ) ) { //print_r($increment_data); die(); ?>   
                  <div class="table-responsive">
                    <table id="dataTable2" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> නම </th>
                          <th> පාසල </th>
                          <th>හැඳුනුම්පත් අංකය</th>
                          <th>ස්ත්‍රී/පුරුෂ</th>
                          <th> දු.ක.</th>
                          <th>තනතුර</th>
                          <th>මුල් පත්විමේ දිනය </th>
                          <th>Informed?</th>
              <?php     if($userrole != 'School User'){ ?>
                          <th>Inform</h>
              <?php     }  ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($increment_data as $row){  
                          $staff_id = $row[0]->stf_id;
                          $census_id = $row[0]->census_id;
                          //$census_id = $row->census_id;
                          $name_with_ini = $row[0]->name_with_ini;
                          $school = $row[0]->sch_name;
                          $nic_no = $row[0]->nic_no;
                          $gender_name = $row[0]->gender_name;
                          if($row[0]->phone_mobile1==''){
                            $phone_mobile = $row[0]->phone_mobile2;
                          }else{
                            $phone_mobile = $row[0]->phone_mobile1;
                          }
                          $desig_type = $row[0]->desig_type;
                          $first_app_date = $row[0]->first_app_dt;
                          $update_dt = $row[0]->last_update;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr>
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                          <td style="vertical-align:middle" ><?php echo $school; ?></td>
                          <td style="vertical-align:middle" ><?php echo $nic_no; ?></td>
                          <td style="vertical-align:middle" ><?php echo $gender_name; ?></td>
                          <td style="vertical-align:middle" ><?php echo $phone_mobile; ?></td>
                          <td style="vertical-align:middle" ><?php echo $desig_type; ?></td>
                          <td style="vertical-align:middle" ><?php echo $first_app_date; ?></td>
                          <td align="center"style="vertical-align:middle"><a type="button" id="<?php echo $staff_id; ?>" name="btn_view_inform_history" type="button" class="btn btn-info btn-sm btn_edit_phy_res btn_view_inform_history" value="<?php echo $staff_id; ?>" title="Click to see message history" data-toggle="tooltip" data-hidden="" ><i class="fa fa-search"></i></a></td>
              <?php     if($userrole != 'School User'){ ?>
                          <td style="vertical-align:middle" align="center">
                            <a type="button" id="<?php echo $staff_id; ?>" name="btn_view_sms_status" type="button" class="btn btn-info btn-sm btn_edit_phy_res btn_view_msg_modal" value="<?php echo $staff_id; ?>" title="Click to send a message" data-toggle="tooltip" data-hidden="" ><i class="fa fa-envelope"></i></a> 
                          </td>
              <?php     }  ?>
                        </tr>
              <?php   } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php }else{ // if empty($acStaffDetails)
                    if(($userrole=='School User') && empty($acStaffDetails)){
                      echo '<h4 align="center">No Records!!!</h4>'; 
                    }else if(($userrole=='Administrator') && empty($acStaffDetails)){
                      echo '<h4 align="center">Add or Search Records!!!</h4>'; 
                    }else{
                      echo '<h4 align="center">Search Details</h4>';
                    }
                  } ?>  
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
                          <label for="sms status" class="control-label"> Email Sent? </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="emal_status_txt" name="emal_status_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="remarks" class="control-label"> Email Details   </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <textarea class="form-control" id="email_info_txtarea" name="email_info_txtarea" placeholder=""></textarea> 
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="sent date" class="control-label"> Email Sent Date   </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="email_sent_date_txt" name="email_sent_date_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="sms status" class="control-label"> SMS Sent? </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="sms_status_txt" name="sms_status_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="remarks" class="control-label"> SMS Details   </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <textarea class="form-control" id="sms_info_txtarea" name="sms_info_txtarea" placeholder=""></textarea> 
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="sent date" class="control-label"> SMS Sent Date   </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="sms_sent_date_txt" name="sms_sent_date_txt" placeholder="" type="text" value="" />
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
                          <label for="id" class="control-label"> ජා.හැ.අංකය (NIC No)  </label>
                        </div>
                        <div class="col-lg-3 col-sm-3">
                          <input class="form-control" id="nic_no_to_find_inc_status_txt" name="nic_no_to_find_inc_status_txt" placeholder="" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group"  class="col-lg-6 col-sm-6">
                      <div class="row">
                        <div class="col">
                          <label for="Employee Type" class="control-label"> වැටුප් වර්ධක වර්ෂය  </label>
                        </div>
                        <div class="col">
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