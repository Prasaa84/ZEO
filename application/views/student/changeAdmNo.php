<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
  foreach( $this->session as $user_data ){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if( $role_id == '2' ){
      $school_name = $user_data['school_name'];
      $census_id = $user_data['census_id'];
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
        <div class="col-lg-6 col-sm-6">
            <div class="card mb-6" id="">
                <div class="card-header">
                    <i class="fa fa-building"></i> Change Admission Number
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-12 my-auto">
                        <?php
                        if(!empty($this->session->flashdata('msg'))) {
                            $message = $this->session->flashdata('msg');  ?>
                            <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
                        <?php } ?>
                        <?php
                        $attributes = array("class" => "form-horizontal", "id" => "update-uname", "name" => "update-uname");
                        echo form_open("Student/changeAdmNo", $attributes);?>
                        <div id="user_info">
                        <fieldset>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <label for="username"> Current Admission Number </label>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <input class="form-control form-control-sm" id="cur_adm_no_txt" name="cur_adm_no_txt" placeholder="--- Type here ---" type="text" />
                                        <span class="text-danger"><?php echo form_error('cur_adm_no_txt'); ?></span>
                                    </div>
                                </div> <!-- /row -->
                            </div> <!-- /form group -->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <label for="current password"> New Admission Number </label>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <input class="form-control form-control-sm" id="new_adm_no_txt" name="new_adm_no_txt" placeholder="---Type here---" type="text" />
                                        <span class="text-danger"><?php echo form_error('new_adm_no_txt'); ?></span>
                                    </div>
                                </div> <!-- /row -->
                            </div> <!-- /form group -->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6"></div>
                                    <div class="col-lg-6 col-sm-6 ">
                                        <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>" />
                                        <input id="btn_change_adm_no" name="btn_change_adm_no" type="submit" class="btn btn-primary mr-2 mt-2 btn-sm" value="Change" />
                                        <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-danger mt-2 mr-2 btn-sm" value="Clear" style="margin-top: 10px;" />
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
        </div> <!-- /col-lg-6 col-sm-6 -->
        <div class="col-lg-6 col-sm-6">
            <div class="card mb-12" id="">
                <div class="card-header">
                    <i class="fa fa-building"></i> Availability
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 my-auto">
                            <h5 align="center"> Current Number </h5>
                            <div id="current_adm_no_status_div" class="table-responsive" >

                            </div>
                        </div> <!-- /col-sm-12 -->  
                        <div class="col-sm-6 my-auto">
                            <h5 align="center"> New Number </h5>
                            <div id="new_adm_no_status_div" class="table-responsive">

                            </div>
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
    </div> <!-- /main row -->
</div> <!-- /container-fluid -->
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
        $('#cur_adm_no_txt').keyup(function(){
            var adm_no = $('#cur_adm_no_txt').val();
            var census_id = $('#census_id_hidden').val();
            alert(census_id);
            $.ajax({  
		    	url:"<?php echo base_url(); ?>Student/findStudentByAdmNo",  
                dataSrc: "Data",
		        method:"POST",  
		        data:{census_id:census_id,adm_no:adm_no}, 
		        success:function(data)  
		        {  
		        	if(data){
                        alert(data);
						$('#current_adm_no_status_div').html(data);
	              	}else{
	              		$('#current_adm_no_status_div').html('Error'); 	
	              	}
		       	}, 
	          	error: function(xhr, status, error) {
	            	alert(xhr.responseText);
	          	} 
	     	})
        });
        $('#new_adm_no_txt').keyup(function(){
            var new_adm_no = $('#new_adm_no_txt').val();
            var census_id = $('#census_id_hidden').val();
            alert(census_id);
            $.ajax({  
		    	url:"<?php echo base_url(); ?>Student/findStudentByAdmNo",  
                dataSrc: "Data",
		        method:"POST",  
		        data:{census_id:census_id,adm_no:new_adm_no}, 
		        success:function(data)  
		        {  
		        	if(data){
                        alert(data);
						$('#new_adm_no_status_div').html(data);
	              	}else{
	              		$('#new_adm_no_status_div').html('Error'); 	
	              	}
		       	}, 
	          	error: function(xhr, status, error) {
	            	alert(xhr.responseText);
	          	} 
	     	})
        });
    });
</script>
