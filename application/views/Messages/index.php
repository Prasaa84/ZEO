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
        <li class="breadcrumb-item active">Messages</li>
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
<?php if(!empty($newMessageCount)){ //print_r($newMessageCount); ?>
        <div class="row">
  <?php   foreach ($newMessageCount as $msg) {  ?> 
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card-body bg-primary">
                <h5 class="card-title"><?php echo $msg->msg_category; ?></h5>
                <?php if($msg->msg_count > 1){ 
                        $text = ' New Messages!';
                      }else{
                        $text = ' New Message!';
                      } 
                ?>
                <p class="card-text"><?php echo $msg->msg_count.$text; ?> </p>
              </div>
            </div> <!-- /col-xl-3 col-sm-6 mb-3-->
<?php     } ?>
        </div> <!-- /row-->
  <?php } ?>
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
                New Messages
              </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h6 align="center"> New Messages</h6>
                  <?php if(!empty($newMessages)) { //print_r($increment_data); die(); ?>   
                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> Name </th>
                          <th> Message Category </th>
                          <th> By whom </th>
                          <th> To whom </th>
                          <th> Academic year</th>
                          <th> Is read? </th>
                          <th> Send date </th>
                          <th> Message </th>
                          <th> Replied By </th>
                          <th> Replied On </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($newMessages as $row){ 
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
                            $to_whom = $row->roll_name;
                            $name = $row->name;
                          }
                          $academic_year = $row->academic_year;
                          if($row->is_read==0){
                            $is_read = 'No';
                            $style = 'style="font-weight: 700;" ';
                          }else{
                            $is_read = 'Yes';
                            $style = '';
                          }
                          $send_date = $row->send_date;
                          $replied_by = $row->replied_by;
                          $replied_on = $row->replied_on;
                          $no = $no + 1;  
                        ?>
                        <tr <?php echo $style; ?> ><b>
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle" ><?php echo $name; ?></td>
                          <td style="vertical-align:middle;"><?php echo $msg_category; ?></td>
                          <td style="vertical-align:middle" ><?php echo $by_whom; ?></td>
                          <td style="vertical-align:middle" ><?php echo $to_whom; ?></td>
                          <td style="vertical-align:middle" ><?php echo $academic_year; ?></td>
                          <td style="vertical-align:middle" ><?php echo $is_read; ?></td>
                          <td style="vertical-align:middle" ><?php echo $send_date; ?></td>
                          <td align="center"style="vertical-align:middle"><a href="<?php echo base_url(); ?>UserMessages/viewMessageById/<?php echo $msg_id; ?>" type="button" id="<?php echo $msg_id; ?>" name="btn_view_message" type="button" class="btn btn-info btn-sm btn_edit_phy_res btn_view_message" value="<?php echo ''; ?>" title="Click to see message" data-toggle="tooltip" data-hidden="" ><i class="fa fa-search"></i> View</a></td>
                          <td style="vertical-align:middle" ><?php echo $replied_by; ?></td>
                          <td style="vertical-align:middle" ><?php echo $replied_on; ?></td>
                        </b>

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

    </div> <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
  <script type="text/javascript">
    // display message history through a bootstrap modal, but not used this code yet
    $(document).on('click', '.345btn_view_message', function(){  
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