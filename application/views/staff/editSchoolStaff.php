<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
	// this page used to edit item
?>
  <style type="text/css">
	.imgPrw{
		max-width: 120px; max-height: 120px;
		margin-top: 20px; margin-bottom: 20px;
	}
  </style>
  <?php
    foreach($this->session as $user_data){
      $userid = $user_data['userid'];
      $userrole = $user_data['userrole'];
      $userrole_id = $user_data['userrole_id'];
    }
  ?>
<div class="content-wrapper">
 	<div class="container-fluid">
      	<!-- Breadcrumbs-->
    	<ol class="breadcrumb">
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Dashboard</a></li>
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Staff/viewAcademicStaff">Staff</a></li>
        	<li class="breadcrumb-item active">Update Academic Staff</a></li>
      	</ol>
	        <?php
				if(empty($stf_result)) {   ?>
                	<div class="alert alert-danger" style="">
                        <?php echo 'No records!!!'; ?>
                    </div>
                    <?php }else{ ?>
 			<?php 	foreach($stf_result as $staff){  
			 			$staff_id = $staff->staff_id;
			 			$name_with_ini = $staff->name_with_ini;
			 			$full_name = $staff->full_name;			 			
			 			$nick_name = $staff->nick_name;
			 			$census_id = $staff->census_id;
			 			$school_name = $staff->sch_name;
			 			$address1 = $staff->stf_address1;
			 			$address2 = $staff->stf_address2;
			 			$nic_no = $staff->nic_no;
			 			if($staff->dob=='0000-00-00'){
			 				$dob = '';
			 			}else{
			 				$dob = $staff->dob;
			 			}
			 			$gender_id = $staff->gender_id;
			 			$gender_type = $staff->gender_name;
			 			$civ_id = $staff->civil_status_id;
			 			$civ_name = $staff->civil_status_type;
			 			$ethnic_group_id = $staff->ethnic_group_id;
			 			$ethnic_group = $staff->ethnic_group;
			 			$religion_id = $staff->religion_id;
			 			$religion = $staff->religion;
			 			$phone_home = $staff->phone_home;
			 			$phone_mobile1 = $staff->phone_mobile1;
			 			$phone_mobile2 = $staff->phone_mobile2;
			 			$vehicle_no1 = $staff->vehicle_no1;
			 			$vehicle_no2 = $staff->vehicle_no2;
			 			$email = $staff->email;
			 			$edu_q_id = $staff->edu_q_id;
			 			$edu_q_name = $staff->edu_q_name;
			 			$prof_q_id = $staff->prof_q_id;
			 			$prof_q_name = $staff->prof_q_name;
			 			$desig_id = $staff->desig_id;
			 			$desig_name = $staff->desig_type;
			 			$service_grade_id = $staff->serv_grd_id;
			 			$service_grade_name = $staff->serv_grd_type;			 			
			 			$section_id = $staff->section_id;
			 			$section_name = $staff->section_name;
			 			//$grade_id = $staff->grade_id;
			 			//$grade_name = $staff->grade;
			 			//$class_id = $staff->class_id;
			 			//$class_name = $staff->class;
			 			$section_role_id = $staff->sec_role_id;
			 			$section_role_name = $staff->sec_role_name;
			 			$stf_type_id = $staff->stf_type_id;
			 			$stf_type = $staff->stf_type;
			 			$stf_status_id = $staff->stf_status_id;
			 			$stf_status = $staff->stf_status;
			 			if($staff->first_app_dt=='0000-00-00'){
			 				$f_app_dt = '';
			 			}else{
			 				$f_app_dt = $staff->first_app_dt;
			 			}
			 			$app_sub_cat_id = $staff->app_sub_cat_id;
			 			$app_sub_cat_type = $staff->app_sub_cat_type;
			 			$app_cat_id = $staff->app_cat_id;
			 			$app_cat_type = $staff->app_cat_type;

			 			$app_med_id = $staff->subj_med_id;
			 			$app_med_type = $staff->subj_med_type;
			 			if($staff->start_dt_this_sch=='0000-00-00'){
			 				$start_dt_this_sch = '';
			 			}else{
			 				$start_dt_this_sch = $staff->start_dt_this_sch;
			 			}
			 			$stf_no = $staff->stf_no;
			 			$sal_no = $staff->salary_no;			 			
			 			$involved_task_id = $staff->involved_task_id;
			 			$involved_task = $staff->inv_task;
			 			//$extra_curri_id	= $staff->extra_curri_id;
			 			//$extra_curri_name = $staff->extra_curri_type;
			 			//$extra_curri_role_id = $staff->ex_cu_role_id;
			 			//$extra_curri_role_name = $staff->ex_cu_role_name;			 			
			 			$user_id = $staff->user_id;
			 			$date_added = $staff->stf_date_added;
			 			$date_updated = $staff->last_update;
			 			$is_deleted = $staff->stf_is_deleted;
 					}
 			?>
		<div class="row" id="main row">
	        <div class="col-lg-6">
	         	<div class="row">
		            <div class="col-lg-12 col-sm-12">
		              <div class="card mb-3">
		                <div class="card-header">
		                  <i class="fa fa-building"></i> Personal Details
		                </div>
		                	<div class="card-body">
		                		<div class="row">
		                    		<div class="col-sm-12">
								  <?php
								    if(!empty($this->session->flashdata('updateSuccessMsg'))) {
								      	$message = $this->session->flashdata('updateSuccessMsg'); 
								     	echo '<div class="alert alert-danger" >'.$message['text'].'</div>';
								   } ?> 
								  <?php
								    if(!empty($this->session->flashdata('updateErrorMsg'))) {
								      	$message = $this->session->flashdata('updateErrorMsg');  
								      	echo '<div class="alert alert-danger" >'.$message['text'].'</div>';
								   } ?> 		                		
       								</div>
       							</div>
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
	                      <?php $attributes = array("class" => "form-horizontal", "id" => "update_stf_pers_info_form", "name" => "update_stf_pers_info_form");
	                        	echo form_open("Staff/updateStfPersonalInfo", $attributes);	?>
			                    		<fieldset>
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<?php  $staff_id; ?>
			                    						<label for="Name with ini">Name with ini.</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="name_with_ini_txt" name="name_with_ini_txt" value="<?php echo $name_with_ini; ?>" />
                            							<span class="text-danger"><?php echo form_error('name_with_ini_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
                    						<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Full name">Full Name</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="fullname_txt" name="fullname_txt" value="<?php echo $full_name; ?>" />
                            							<span class="text-danger"><?php echo form_error('fullname_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->			                    			
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Nick Name">Nick Name</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="nick_name_txt" name="nick_name_txt" value="<?php echo $nick_name; ?>" />
                            							<span class="text-danger"><?php echo form_error('nick_name_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Address">Address 1</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="address1_txt" name="address1_txt" value="<?php echo $address1; ?>" />
                            							<span class="text-danger"><?php echo form_error('address1_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Address">Address 2</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="address2_txt" name="address2_txt" value="<?php echo $address2; ?>" />
                            							<span class="text-danger"><?php echo form_error('address2_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Address"> NIC </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="nic_txt" name="nic_txt" value="<?php echo $nic_no; ?>" />
                            							<span class="text-danger"><?php echo form_error('nic_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
											<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date of birth">Date of Birth</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control datepicker" id="dob_txt" name="dob_txt" value="<?php echo $dob; ?>" />
                            							<span class="text-danger"><?php echo form_error('dob_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 1"> Religion </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
                            							<select class="form-control" id="religion_select" name="religion_select">
								                            <option value="<?php echo $religion_id; ?>" selected><?php echo $religion; ?></option>
								                            <?php foreach ($this->all_religion as $row){ ?> <!-- from Building controller constructor method -->
								                              <option value="<?php echo $row->religion_id; ?>"><?php echo $row->religion; ?></option>
								                            <?php } ?>
							                          	</select>
                            							<span class="text-danger"><?php echo form_error('religion_select'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->	
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 2">Ethnicity</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
                            							<select class="form-control" id="ethnicity_select" name="ethnicity_select">
								                            <option value="<?php echo $ethnic_group_id; ?>" selected><?php echo $ethnic_group; ?></option>
								                            <?php foreach ($this->all_ethnic_groups as $row){ ?> <!-- from Building controller constructor method -->
								                              <option value="<?php echo $row->ethnic_group_id; ?>"><?php echo $row->ethnic_group; ?></option>
								                            <?php } ?>
								                         </select>
                            							<span class="text-danger"><?php echo form_error('ethnicity_select'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->	
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Civil Status">Gender</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
			                    						<select class="form-control" id="gender_select" name="gender_select">
								                            <option value="<?php echo $gender_id; ?>" selected><?php echo $gender_type; ?></option>
								                            <option value="1" > Male </option>
								                            <option value="2" > Female </option>
                          								</select>
                            							<span class="text-danger"><?php echo form_error('gender_select'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->	
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Civil Status">Civil Status</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
                            							<select class="form-control" id="civil_status_select" name="civil_status_select">
								                            <option value="<?php echo $civ_id; ?>" selected><?php echo $civ_name; ?></option>
								                            <?php foreach ($this->all_civil_status as $row){ ?> <!-- from Building controller constructor method -->
								                              <option value="<?php echo $row->civil_status_id; ?>"><?php echo $row->civil_status_type; ?></option>
								                            <?php } ?>
                          								</select>
                            							<span class="text-danger"><?php echo form_error('civil_status_select'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->	
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 2">Mobile 1</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="phone1_txt" name="phone1_txt" value="<?php echo $phone_mobile1; ?>" />
                            							<span class="text-danger"><?php echo form_error('phone1_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 2">Mobile 2</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="phone2_txt" name="phone2_txt" value="<?php echo $phone_mobile2; ?>" />
                            							<span class="text-danger"><?php echo form_error('phone2_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->	
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 2">Home Phone</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="phoneHome_txt" name="phoneHome_txt" value="<?php echo $phone_home; ?>" />
                            							<span class="text-danger"><?php echo form_error('phoneHome_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->	
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 2">Email</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="email_txt" name="email_txt" value="<?php echo $email; ?>" />
                            							<span class="text-danger"><?php echo form_error('email_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->	
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 2">Vehicle No 1</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="vehicle1_txt" name="vehicle1_txt" value="<?php echo $vehicle_no1; ?>" />
                            							<span class="text-danger"><?php echo form_error('vehicle1_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->	
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 2">Vehicle No 2</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="vehicle2_txt" name="vehicle2_txt" value="<?php echo $vehicle_no2; ?>" />
                            							<span class="text-danger"><?php echo form_error('vehicle2_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->	
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 2">Edu. Qu.</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
                            							<select class="form-control" id="high_edu_select" name="high_edu_select">
								                            <option value="<?php echo $edu_q_id; ?>" selected><?php echo $edu_q_name; ?></option>
								                            <?php foreach ($this->all_edu_qual as $row){ ?> <!-- from Building controller constructor method -->
								                              <option value="<?php echo $row->edu_q_id; ?>"><?php echo $row->edu_q_name; ?></option>
								                            <?php } ?>
								                         </select>
                            							<span class="text-danger"><?php echo form_error('phone2_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 2">Prof. Qu.</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
                            							<select class="form-control" id="prof_edu_select" name="prof_edu_select">
								                            <option value="<?php echo $prof_q_id; ?>" selected><?php echo $prof_q_name; ?></option>
								                            <?php foreach ($this->all_prof_qual as $row){ ?> <!-- from Building controller constructor method -->
								                              <option value="<?php echo $row->prof_q_id; ?>"><?php echo $row->prof_q_name; ?></option>
								                            <?php } ?>
								                         </select>
                            							<span class="text-danger"><?php echo form_error('prof_edu_select'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date added">Date Added</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="dateadded_txt" name="dateadded_txt" value="<?php echo $date_added; ?>" readonly="true"/>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date updated">Last Update</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="date_updated" name="date_updated" value="<?php echo $date_updated; ?>" readonly="true"/>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3"></div>
			                    					<div class="col-lg-9 col-sm-9 ">
		                      							<input type="hidden" name="stf_id_hidden" value="<?php echo $staff_id; ?>" />
			                    						<input id="btn_edit_stf_pers_info" name="btn_edit_stf_pers_info" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    						<span name="is_deleted" value="<?php echo $is_deleted; ?>"></span>
			                    						<a href="<?php echo base_url(); ?>Staff/viewAcademicStaff" id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-success mt-2" value="Cancel" style="margin-top: 10px;" >Cancel</a>
			                    					</div>
			                    				</div>
			                    			</div> <!-- /form group -->
			                    		</fieldset>
			                    		<?php echo form_close(); ?>
	                    			</div> <!-- /col-sm-12 -->
	                    		</div> <!-- /row -->
	                		</div> <!-- /card body -->
	              		</div> <!-- /card -->
	            	</div> <!-- /col-lg-12 col-sm-12 personal details--> 
	            </div> <!-- /row -->
	      	</div><!-- /col-lg-6 -->
	      	<div class="col-lg-6">
	         	<div class="row">
	         		<div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3">
			                <div class="card-header">
			                  <i class="fa fa-building"></i> Profile Picture
			                </div>
		                	<div class="card-body">
		                		<div class="row">
		                    		<div class="col-sm-12">
								  <?php
								    if(!empty($this->session->flashdata('stfImgUploadSuccess'))) {
								      $message = $this->session->flashdata('stfImgUploadSuccess');  ?>
								      <div class="alert alert-success" ><?php echo $message; ?></div>
								  <?php } ?> 
								  <?php
								    if(!empty($this->session->flashdata('stfImgUploadError'))) {
								      $message = $this->session->flashdata('stfImgUploadError');  
								        foreach ($message as $item => $value){
								          echo '<div class="alert alert-danger" >'.$item.' : '.$value.'</div>';
								        }
								   } ?> 
								   <?php
								    if(!empty($this->session->flashdata('noImageError'))) {
								      	$message = $this->session->flashdata('noImageError');  
								    	echo '<div class="alert alert-danger" >'.$message.'</div>';
								   } ?> 		                		
       								</div>
       							</div>
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
		                  <?php $attributes = array("class" => "form-horizontal", "id" => "update_stf_image_form", "name" => "update_stf_image_form");
		                    	echo form_open_multipart("Staff/uploadStaffImage", $attributes);	?>
			                    		<fieldset>
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-6 col-sm-6">
		                      							<div class="row">
				                    						<div class="col-lg-12 col-sm-12">
		                      									<center><h4><?php echo $name_with_ini; ?></h4></center>
		                      									<center><h5><?php echo $staff_id; ?></h5></center>
		                      								</div>
		                      							</div>
		                      							<div class="row">
				                    						<div class="col-lg-6 col-sm-6">
		                      									<center><input type="file" name="stf_image" size="20" id="stf_image" title="Change Image" /></center>
		                      								</div> 
				                    						<div class="col-lg-6 col-sm-6">
				                    							<img id="imgPrw" src="#" alt="" class="imgPrw" />
		                      								</div> 
		                      							</div>
		                      							<div class="row">
		                      								<div class="col-lg-6 col-sm-6">
		                      									<input type="hidden" name="stf_id_hidden" value="<?php echo $staff_id; ?>" />
			                    							</div>
		                      							</div>
		                      							<div class="row">
		                      								<div class="col-lg-6 col-sm-6">
              													<button class="btn btn-primary" type="submit" name="btn_upload_stf_img" value="upload_stf_image" style="margin:5 0 5 0; "> Upload </button>
			                    							</div>
		                      							</div>
			                    					</div>
			                    					<div class="col-lg-6 col-sm-6">
			                    						<center>
			                    							<?php 
			                    								if(file_exists("./assets/uploaded/stf_images/$staff_id.jpg")){ 
			                    							?>
			                    							<img src="<?php echo base_url(); ?>assets/uploaded/stf_images/<?php echo $staff_id; ?>.jpg" style="">
			                    							<?php }else{ ?>
			                    							<img src="<?php echo base_url(); ?>assets/uploaded/stf_images/default_profile_image.png" style="">
			                    							<?php } ?>
			                    						</center>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    		</fieldset>
			                    		<?php echo form_close(); ?>
			                    	</div>
			                    </div>
			                </div> <!-- /card-body -->
		            	</div> <!-- /card mb-3 -->
		        	</div>  <!-- /col-lg-12 col-sm-12 -->
  <!-- ------------- Service Details begins------------------------------------------------------------------------- -->
		            <div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3">
			                <div class="card-header">
			                  <i class="fa fa-building"></i> Service Details
			                </div>
		                	<div class="card-body">
		                		<div class="row">
		                    		<div class="col-sm-12">
								  <?php
								    if(!empty($this->session->flashdata('servInfoUpdateSuccessMsg'))) {
								      	$message = $this->session->flashdata('servInfoUpdateSuccessMsg'); 
								     	echo '<div class="alert alert-danger" >'.$message['text'].'</div>';
								   } ?> 
								  <?php
								    if(!empty($this->session->flashdata('servInfoUpdateErrorMsg'))) {
								      	$message = $this->session->flashdata('servInfoUpdateErrorMsg');  
								      	echo '<div class="alert alert-danger" >'.$message['text'].'</div>';
								   } ?> 		                		
       								</div>
       							</div>
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
		                  <?php $attributes = array("class" => "form-horizontal", "id" => "update_stf_serv_info_form", "name" => "update_stf_serv_info_form");
		                    	echo form_open("Staff/updateStfServInfo", $attributes);	?>
			                    		<fieldset>
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Name with ini">First Ap. Date</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control datepicker" id="f_app_dt_txt" name="f_app_dt_txt" value="<?php echo $f_app_dt; ?>" />
		                    							<span class="text-danger"><?php echo form_error('f_app_dt_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="Employee Type" class="control-label"> Employee Type </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <select class="form-control" id="emp_type_select" name="emp_type_select">
						                            <option value="<?php echo $stf_type_id; ?>" selected><?php echo $stf_type; ?></option>
						                            <?php foreach ($this->all_stf_types as $row){ ?> <!-- from Building controller constructor method -->
						                              <option value="<?php echo $row->stf_type_id; ?>"><?php echo $row->stf_type; ?></option>
						                            <?php } ?>
						                          </select>                          
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group --> 
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="Appointment category" class="control-label"> Appointment Category </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <select class="form-control" id="app_cat_select" name="app_cat_select">
						                            <option value="<?php echo $app_cat_id; ?>" selected><?php echo $app_cat_type; ?></option>
						                            <?php foreach ($this->all_appoint_cat as $row){ ?> <!-- from Building controller constructor method -->
						                              <option value="<?php echo $row->app_cat_id; ?>"><?php echo $row->app_cat_type; ?></option>
						                            <?php } ?>
						                          </select>                          
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group --> 
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="Appointment sub category" class="control-label"> Appointment Sub Category </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <select class="form-control" id="app_sub_cat_select" name="app_sub_cat_select">
						                            <option value="<?php echo $app_sub_cat_id; ?>" selected><?php echo $app_sub_cat_type; ?></option>
						                            <?php foreach ($this->all_appoint_sub_cat as $row){ ?> <!-- from  controller constructor method -->
						                              <option value="<?php echo $row->app_sub_cat_id; ?>"><?php echo $row->app_sub_cat_type; ?></option>
						                            <?php } ?>
						                          </select>                          
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group --> 
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="guardian telephone" class="control-label"> Appointment Medium </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <select class="form-control" id="app_medium_select" name="app_medium_select">
						                            <option value="<?php echo $app_med_id; ?>" selected><?php echo $app_med_type; ?></option>
						                            <?php foreach ($this->all_subj_medium as $row){ ?> <!-- from Building controller constructor method -->
						                              <option value="<?php echo $row->subj_med_id; ?>"><?php echo $row->subj_med_type; ?></option>
						                            <?php } ?>
						                          </select>  
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group --> 
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="service grade" class="control-label"> Service Grade </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <select class="form-control" id="serv_gr_select" name="serv_gr_select">
						                            <option value="<?php echo $service_grade_id; ?>" selected><?php echo $service_grade_name; ?></option>
						                            <?php foreach ($this->all_service_grades as $row){ ?> <!-- from Building controller constructor method -->
						                              <option value="<?php echo $row->serv_grd_id; ?>"><?php echo $row->serv_grd_type; ?></option>
						                            <?php } ?>
						                          </select>                        
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group --> 
						                    <div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3"></div>
			                    					<div class="col-lg-9 col-sm-9 ">
		                      							<input type="hidden" name="stf_id_hidden" value="<?php echo $staff_id; ?>" />
			                    						<input id="btn_edit_stf_serv_info" name="btn_edit_stf_serv_info" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    						<span name="is_deleted" value="<?php echo $is_deleted; ?>"></span>
			                    						<a href="<?php echo base_url(); ?>Staff/viewAcademicStaff" id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-success mt-2" value="Cancel" style="margin-top: 10px;" >Cancel</a>
			                    					</div>
			                    				</div>
			                    			</div> <!-- /form group -->
			                    		</fieldset>
			                    		<?php echo form_close(); ?>
			                    	</div>
			                    </div>
			                </div>
		            	</div> <!-- /card mb-3 -->
		        	</div><!-- /col-lg-12 col-sm-12 service details-->
  <!-- ------------- School Details begins------------------------------------------------------------------------- -->
		            <div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3">
			                <div class="card-header">
			                  <i class="fa fa-building"></i> School Details
			                </div>
		                	<div class="card-body">
		                		<div class="row">
		                    		<div class="col-sm-12">
								  <?php
								    if(!empty($this->session->flashdata('schInfoUpdateSuccessMsg'))) {
								      	$message = $this->session->flashdata('schInfoUpdateSuccessMsg'); 
								     	echo '<div class="alert alert-danger" >'.$message['text'].'</div>';
								   } ?> 
								  <?php
								    if(!empty($this->session->flashdata('schInfoUpdateErrorMsg'))) {
								      	$message = $this->session->flashdata('schInfoUpdateErrorMsg');  
								      	echo '<div class="alert alert-danger" >'.$message['text'].'</div>';
								   } ?> 		                		
       								</div>
       							</div>
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
		                  <?php $attributes = array("class" => "form-horizontal", "id" => "update_sch_info_form", "name" => "update_sch_info_form");
		                    	echo form_open("Staff/updateSchoolInfo", $attributes);	?>
			                    		<fieldset>
			                    			<div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="Designation" class="control-label"> School </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <select class="form-control" id="school_select" name="school_select">
						                            <option value="<?php echo $census_id; ?>" selected><?php echo $school_name; ?></option>
						                            <?php foreach ($this->all_schools as $row){ ?> <!-- from Building controller constructor method -->
						                              <option value="<?php echo $row->census_id; ?>"><?php echo $row->sch_name; ?></option>
						                            <?php } ?>
						                          </select>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
			                    			<div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="staff number"> Staff Number </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <input class="form-control" id="stf_no_txt" name="stf_no_txt" placeholder="Type here" type="text" value="<?php echo $stf_no; ?>" />
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="staff number"> Salary No </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <input class="form-control" id="salary_no_txt" name="salary_no_txt" placeholder="Type here" type="text" value="<?php echo $sal_no; ?>" />
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="start_this_date" class="control-label"> Start Date of this School </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <input class="form-control datepicker" id="start_this_dt_txt" name="start_this_dt_txt" placeholder="---Click here---" type="text" value="<?php echo $start_dt_this_sch; ?>" data-date-end-date="0d"/>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="Designation" class="control-label"> Designation </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <select class="form-control" id="desig_select" name="desig_select">
						                            <option value="<?php echo $desig_id; ?>" selected><?php echo $desig_name; ?></option>
						                            <?php foreach ($this->all_designations as $row){ ?> <!-- from Building controller constructor method -->
						                              <option value="<?php echo $row->desig_id; ?>"><?php echo $row->desig_type; ?></option>
						                            <?php } ?>
						                          </select>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="Designation" class="control-label"> Job Status </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <select class="form-control" id="job_status_select" name="job_status_select">
						                            <option value="<?php echo $stf_status_id; ?>" selected><?php echo $stf_status; ?></option>
						                            <?php foreach ($this->all_staff_status as $row){ ?> <!-- from Building controller constructor method -->
						                              <option value="<?php echo $row->stf_status_id; ?>"><?php echo $row->stf_status; ?></option>
						                            <?php } ?>
						                          </select>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="Section" class="control-label"> Section </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <select class="form-control" id="section_select" name="section_select">
						                            <option value="<?php echo $section_id; ?>" selected><?php echo $section_name; ?></option>
						                            <?php foreach ($this->all_sections as $row){ ?> <!-- from Building controller constructor method -->
						                              <option value="<?php echo $row->section_id; ?>"><?php echo $row->section_name; ?></option>
						                            <?php } ?>
						                          </select>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="Section Role" class="control-label"> Section Role </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <select class="form-control" id="section_role_select" name="section_role_select">
						                            <option value="<?php echo $section_role_id; ?>" selected><?php echo $section_role_name; ?></option>
						                            <?php foreach ($this->all_section_roles as $row){ ?> <!-- from Building controller constructor method -->
						                              <option value="<?php echo $row->sec_role_id; ?>"><?php echo $row->sec_role_name; ?></option>
						                            <?php } ?>
						                          </select>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
						                      <div class="row"> 
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="Task Involved" class="control-label"> Involved Task </label>
						                        </div>
						                        <div class="col-lg-9 col-sm-9">
						                          <select class="form-control" id="task_inv_select" name="task_inv_select">
						                            <option value="<?php echo $involved_task_id; ?>" selected><?php echo $involved_task; ?></option>
						                            <?php foreach ($this->all_tasks_involved as $row){ ?> <!-- from Building controller constructor method -->
						                              <option value="<?php echo $row->involved_task_id; ?>"><?php echo $row->inv_task; ?></option>
						                            <?php } ?>
						                          </select>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3"></div>
			                    					<div class="col-lg-9 col-sm-9 ">
		                      							<input type="hidden" name="stf_id_hidden" value="<?php echo $staff_id; ?>" />
			                    						<input id="btn_edit_stf_school_info" name="btn_edit_stf_school_info" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    						<span name="is_deleted" value="<?php echo $is_deleted; ?>"></span>
			                    						<a href="<?php echo base_url(); ?>Staff/viewAcademicStaff" id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-success mt-2" value="Cancel" style="margin-top: 10px;" >Cancel</a>
			                    					</div>
			                    				</div>
			                    			</div> <!-- /form group -->
			                    		</fieldset>
			                    		<?php echo form_close(); ?>
			                    	</div>
			                    </div>
			                </div>
		            	</div> <!-- /card mb-3 -->
		        	</div><!-- /col-lg-12 col-sm-12 rich details-->
	        	</div><!-- /row -->
	    	</div><!-- /col-lg-6 -->
	  	</div><!-- /row main_row-->
	  	<div class="row" id="main_row">
	  		<div class="col-lg-4">
	  			<div class="row">
		        	<div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3 md">
			                <div class="card-header">
			                  <i class="fa fa-building"></i> Teaching Grades and Classes
			                </div>
		                	<div class="card-body">
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
	                    		    <?php 
								      if(!empty($this->session->flashdata('gradeClassMsg'))) {
								        $gradeClassMsg = $this->session->flashdata('gradeClassMsg');  ?>
								        <div class="<?php echo $gradeClassMsg['class']; ?>" ><?php echo $gradeClassMsg['text']; ?></div>
								    <?php   } ?>  
		                    		<?php if(empty($stf_grd_cls_info)){
		                    				echo '<h4>Not Assigned!!!</h4>';
		                    			}else{
 									?>
							          <div class="table-responsive">
					                    <table class="table table-hover" id="grade_info_tbl" class="table table-striped table-bordered" cellspacing="0" width="">
					                      <thead>
					                        <tr>
					                          <th scope="col" class="col-sm-4"> Class </th>
					                          <th scope="col" class="col-sm-4"> Role </th>
<!-- 					                          <th scope="col" class="col-sm-2"> </th>
 -->					                          
 												<th scope="col" class="col-sm-2"> </th>					                          
					                        </tr>
					                      </thead>
					                      <tbody>
					                      <?php 
					                        foreach($stf_grd_cls_info as $gc_info){
		                    					$stf_grd_cls_id = $gc_info->stf_grd_cls_id;  
		                    					$grd_id = $gc_info->grade_id;
									 			$cls_id = $gc_info->class_id;
		                    					$grade = $gc_info->grade;
									 			$class = $gc_info->class;
									 			$class_role_id = $gc_info->sec_role_id;
									 			$class_role_name = $gc_info->sec_role_name;
									 		 ?>
					                        <tr>
					                          <td style="vertical-align:middle"><?php echo $grade.' '.$class; ?></td>
					                          <td style="vertical-align:middle"><?php echo $class_role_name; ?></td>
						                     <!--  <td id="td_btn">
						                        <a type="button" id="btn_edit_gc_info" name="btn_edit_gc_info" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update" data-toggle="tooltip" href="<?php echo base_url(); ?>Staff/editStaffGradeClassView/<?php echo $stf_grd_cls_id; ?>/<?php echo $staff_id; ?>"><i class="fa fa-pencil"></i></a>
						                      </td> -->
				                              <td id="td_btn">
				                                <a href="<?php echo base_url(); ?>Staff/deleteStaffGrdClsInfo/<?php echo $stf_grd_cls_id; ?>/<?php echo $staff_id; ?>" type="button" name="btn_delete_gc_info" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete" onClick="return confirmStatusDelete();"><i class="fa fa-trash-o"></i></a>
				                              </td>					                        
				                            </tr>
									 	<?php	} } ?>
				                            <tr>
				                              <td>
				                                <button id="btn_add_new_grd_cls_info" name="btn_add_new_grd_cls_info" type="button" class="btn btn-primary btn-sm" value="Add" data-toggle="modal" data-target="#AssignToNewGradeClass"><i class="fa fa-plus"></i> Assign </button>
				                              </td>
				                              <td></td><td></td><td></td><td></td>
                            				</tr>
					                      </tbody>
					                    </table>
					                  </div> <!-- /table-responsive -->
			                    	</div>
			                    </div>
			                </div>
		            	</div> <!-- /card mb-3 -->
		        	</div><!-- /col-lg-12 col-sm-12 -->
		   		</div> <!-- /row -->
		    </div> <!-- /col-lg-6 col-sm-12 -->
	  		<div class="col-lg-4">
	  			<div class="row">
	  				<div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3">
			                <div class="card-header">
			                  <i class="fa fa-building"></i> Games Info
			                </div>
		                	<div class="card-body">
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
		                    		<?php 
								      if(!empty($this->session->flashdata('gameMsg'))) {
								        $gameMsg = $this->session->flashdata('gameMsg');  ?>
								        <div class="<?php echo $gameMsg['class']; ?>" ><?php echo $gameMsg['text']; ?></div>
								    <?php   } ?>  
		                    		<?php if(empty($stf_game_info)){
		                    				echo '<h4>Not Assigned!!!</h4>';
		                    			}else{
 									?>
							          <div class="table-responsive">
					                    <table class="table table-hover" id="games_info_tbl" class="table table-striped table-bordered" cellspacing="0" width="">
					                      <thead>
					                        <tr>
					                          <th scope="col" class="col-sm-2"> Game Name</th>
					                          <th scope="col" class="col-sm-4"> Role </th>
<!-- 					                          <th scope="col" class="col-sm-2"> </th>
 -->					                      <th scope="col" class="col-sm-4"> </th>					                          
					                        </tr>
					                      </thead>
					                      <tbody>
					                      <?php 
					                        $no = 0;
					                        foreach($stf_game_info as $game_info){
		                    					$stgm_id = $game_info->stf_gm_id;  
		                    					$stf_id = $game_info->stf_id;
									 			$game_id = $game_info->game_id;
									 			$game_name = $game_info->game_name;	
									 			$game_role_id = $game_info->gm_role_id;	
									 			$game_role = $game_info->gm_role_name;
									 		 ?>
					                        <tr>
					                          <td style="vertical-align:middle"><?php echo $game_name; ?></td>
					                          <td style="vertical-align:middle"><?php echo $game_role; ?></td>
						                     <!--  <td id="td_btn">
						                        <a href="<?php echo base_url(); ?>Staff/editGameInfo/<?php echo $stgm_id; ?>/<?php echo $stf_id; ?>" type="button" id="btn_edit_game_info" name="btn_edit_game_info" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this details" data-toggle="tooltip" data-hidden="" onclick=""><i class="fa fa-pencil"></i></a>
						                      </td> -->
				                              <td id="td_btn">
				                                <a href="<?php echo base_url(); ?>Staff/deleteGameInfo/<?php echo $stgm_id; ; ?>/<?php echo $stf_id; ?>" type="button" name="btn_delete_game_info" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this details" onClick="return confirmStatusDelete();"><i class="fa fa-trash-o"></i></a>
				                              </td>					                        
				                            </tr>
									 	<?php	} ?>
				                            <tr>
				                              <td>
				                                <button id="btn_add_new_game_info" name="btn_add_new_game_info" type="button" class="btn btn-primary btn-sm" value="Add" data-toggle="modal" data-target="#AssignToNewGame"><i class="fa fa-plus"></i> Add New</button>
				                              </td>
				                              <td></td>
                            				</tr>
					                      </tbody>
					                    </table>
					                  </div> <!-- /table-responsive -->
					                <?php } ?>
			                    	</div>
			                    </div>
			                </div>
		            	</div> <!-- /card mb-3 -->
		        	</div><!-- /col-lg-12 col-sm-12 -->
		        </div> <!-- /row -->
		    </div> <!-- /col-lg-6 col-sm-12 -->
		    <div class="col-lg-4">
	  			<div class="row">
		        	<div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3">
			                <div class="card-header">
			                  <i class="fa fa-building"></i> Extra Curricular Info
			                </div>
		                	<div class="card-body">
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
		                    		<?php 
								      if(!empty($this->session->flashdata('exCurMsg'))) {
								        $exCurMsg = $this->session->flashdata('exCurMsg');  ?>
								        <div class="<?php echo $exCurMsg['class']; ?>" ><?php echo $exCurMsg['text']; ?></div>
								    <?php   } ?>  
		                    		<?php if(empty($stf_EC_info)){
		                    				echo '<h4>Not Assigned!!!</h4>';
		                    			}else{
 									?>
							          <div class="table-responsive">
					                    <table class="table table-hover" id="extracu_info_tbl" class="table table-striped table-bordered" cellspacing="0" width="">
					                      <thead>
					                        <tr>
					                          <th scope="col" class="col-sm-6"> Extra cu. activity</th>
					                          <th scope="col" class="col-sm-4"> Role </th>
					                          <th scope="col" class="col-sm-2"> </th>					                          
					                        </tr>
					                      </thead>
					                      <tbody>
					                      <?php 
					                        $no = 0;
					                        foreach($stf_EC_info as $ec_info){
		                    					$stfec_id = $ec_info->stf_extra_curri_id;  
		                    					$stf_id = $ec_info->stf_id;
									 			$ec_id = $ec_info->extra_curri_id;
									 			$ec_name = $ec_info->extra_curri_type;
									 			$ec_role_id = $ec_info->ex_cu_role_id;	
									 			$ec_role = $ec_info->ex_cu_role_name;	
									 		 ?>
					                        <tr>
					                          <td style="vertical-align:middle"><?php echo $ec_name; ?></td>
					                          <td style="vertical-align:middle"><?php echo $ec_role; ?></td>
				                              <td id="td_btn">
				                                <a href="<?php echo base_url(); ?>Staff/deleteExtraCurriInfo/<?php echo $stfec_id; ; ?>" type="button" name="btn_delete_ec_info" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete" onClick="return confirmStatusDelete();"><i class="fa fa-trash-o"></i></a>
				                              </td>					                        
				                            </tr>
									 	<?php	} }?>
				                            <tr>
				                              <td>
				                                <button id="btn_add_new_ec_info" name="btn_add_new_ec_info" type="button" class="btn btn-primary btn-sm" value="Add" data-toggle="modal" data-target="#AssignToNewExtraCurri"><i class="fa fa-plus"></i> Add New</button>
				                              </td>
				                              <td></td>
                            				</tr>
					                      </tbody>
					                    </table>
					                  </div> <!-- /table-responsive -->
					                <?php //} ?>
			                    	</div>
			                    </div>
			                </div>
		            	</div> <!-- /card mb-3 -->
		        	</div><!-- /col-lg-12 col-sm-12 -->
		   		</div> <!-- /row -->
		    </div> <!-- /col-lg-6 col-sm-12 -->
		    
	  	</div> <!-- /row main_row-->
<?php } ?> <!-- if not empty $stf_result -->
	  	<!-- /following bootstrap model used to assign games to staff-->
      <div class="modal fade" id="AssignToNewGame" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Assign to a new game </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_stf_game_info_form", "name" => "insert_stf_game_info_form", "accept-charset" => "UTF-8" );
                  echo form_open("Staff/AssignToNewGame", $attributes);?>
                  <fieldset>
                    <div class="form-group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Assign to a game" class="control-label"> Game </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="game_select" name="game_select">
	                        <option value="" selected>---Select---</option>
	                        <?php foreach ($this->all_games as $row){ ?> <!-- from Building controller constructor method -->
	                          <option value="<?php echo $row->game_id; ?>"><?php echo $row->game_name; ?></option>
	                        <?php } ?>
	                      </select>
	                    </div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
	                <div class="form-group" id="game_role_select_form_group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Assign to a game" class="control-label"> Game Role </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="game_role_select" name="game_role_select">
	                        <option value="" selected>---Select---</option>
	                        <?php foreach ($this->all_game_roles as $row){ ?> <!-- from Building controller constructor method -->
	                          <option value="<?php echo $row->gm_role_id; ?>"><?php echo $row->gm_role_name; ?></option>
	                        <?php } ?>
	                      </select>
	                      <input type="hidden" name="stf_no_hidden" value="<?php echo $staff_id; ?>"> <!-- here $staff_id from top of the page --> 
	                    </div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_game_info" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
            <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
	  <!-- /following bootstrap model used to assign extra curry. to staff--> 
      <div class="modal fade" id="AssignToNewExtraCurri" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Assign to an extra curricular activity </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_ex_curri_form", "name" => "insert_ex_curri_form", "accept-charset" => "UTF-8" );
                  echo form_open("Staff/AssignToNewExtraCurri", $attributes);?>
                  <fieldset>
                    <div class="form-group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Assign to a extra cu." class="control-label"> Activity </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="extra_cu_select" name="extra_cu_select">
	                        <option value="" selected>---Select---</option>
	                        <?php foreach ($this->all_extra_curri as $row){ ?> <!-- from Building controller constructor method -->
	                          <option value="<?php echo $row->extra_curri_id; ?>"><?php echo $row->extra_curri_type; ?></option>
	                        <?php } ?>
	                      </select>
	                    </div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
	                <div class="form-group" id="game_role_select_form_group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Assign to a game" class="control-label"> Extra Cu. Role </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="ex_curri_role_select" name="ex_curri_role_select">
	                        <option value="" selected>---Select---</option>
	                        <?php foreach ($this->all_extra_curri_roles as $row){ ?> <!-- from Building controller constructor method -->
	                          <option value="<?php echo $row->ex_cu_role_id; ?>"><?php echo $row->ex_cu_role_name; ?></option>
	                        <?php } ?>
	                      </select>
	                      <input type="hidden" name="stf_no_hidden" value="<?php echo $staff_id; ?>"> <!-- here $staff_id from top of the page --> 
	                    </div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_extra" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
      <!-- /following bootstrap model used to assign grade and class to staff--> 
      <div class="modal fade" id="AssignToNewGradeClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Assign to an extra curricular activity </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_ex_curri_form", "name" => "insert_ex_curri_form", "accept-charset" => "UTF-8" );
                  echo form_open("Staff/AssignToNewGradeClass", $attributes);?>
                  <fieldset>
                    <div class="form-group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Assign to a Grade" class="control-label"> Grade </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="grade_select" name="grade_select">
	                        <option value="" selected>---Select---</option>
	                        <?php foreach ($this->all_grades as $row){ ?> <!-- from Building controller constructor method -->
	                          <option value="<?php echo $row->grade_id; ?>"><?php echo $row->grade; ?></option>
	                        <?php } ?>
	                      </select>
	                    </div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
	                <div class="form-group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Assign to a Class" class="control-label"> Class </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="class_select" name="class_select">
	                        <option value="" selected>---Select---</option>
	                        <?php foreach ($this->all_classes as $row){ ?> <!-- from Building controller constructor method -->
	                          <option value="<?php echo $row->class_id; ?>"><?php echo $row->class; ?></option>
	                        <?php } ?>
	                      </select>
	                    </div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
	                <div class="form-group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Class Role" class="control-label"> Class Role </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="class_role_select" name="class_role_select">
	                        <option value="3"> Class Teacher </option>
	                        <option value="4" selected> Teacher </option>
	                        <option value="5"> Not Assigned </option>
	                      </select>
	                      <input type="hidden" name="stf_no_hidden" value="<?php echo $staff_id; ?>"> <!-- here $staff_id from top of the page --> 
	                      <input type="hidden" name="section_no_hidden" value="<?php echo $section_id; ?>"> <!-- here $staff_id from top of the page --> 
						</div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_grdcls" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
      <!-- /following bootstrap model used to assign grade and class to staff--> 
      <div class="modal fade" id="editGradeClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Change grade and class </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_ex_curri_form", "name" => "insert_ex_curri_form", "accept-charset" => "UTF-8" );
                  echo form_open("Staff/editGradeClass", $attributes);?>
                  <fieldset>
                    <div class="form-group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Assign to a Grade" class="control-label"> Grade </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="grade_select" name="grade_select">
	                        <option value="<?php echo $grade_id; ?>" selected><?php echo $grade_name; ?></option>
	                        <?php foreach ($this->all_grades as $row){ ?> <!-- from Building controller constructor method -->
	                          <option value="<?php echo $row->grade_id; ?>"><?php echo $row->grade; ?></option>
	                        <?php } ?>
	                      </select>
	                    </div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
	                <div class="form-group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Assign to a Class" class="control-label"> Class </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="class_select" name="class_select">
	                        <option value="<?php echo $class_id; ?>" selected><?php echo $class_name; ?></option>
	                        <?php foreach ($this->all_classes as $row){ ?> <!-- from Building controller constructor method -->
	                          <option value="<?php echo $row->class_id; ?>"><?php echo $row->class; ?></option>
	                        <?php } ?>
	                      </select>
	                    </div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
	                <div class="form-group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Class Role" class="control-label"> Class Role </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="class_role_select" name="class_role_select">
	                        <option value="<?php echo $section_role_id; ?>" selected><?php echo $section_role_name; ?></option>
	                        <option value="3"> Class Teacher </option>
	                        <option value="4"> Teacher </option>
	                        <option value="5"> Not Assigned </option>
	                      </select>
	                      <input type="hidden" name="stf_no_hidden" value="<?php echo $staff_id; ?>"> <!-- here $staff_id from top of the page --> 
	                      <input type="hidden" name="section_no_hidden" value="<?php echo $section_id; ?>"> <!-- this is not used yet --> 
						</div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_grdcls" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
      <!-- /following bootstrap model used to edit extra cur. acti. of a staff--> 
      <div class="modal fade" id="editExCu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Change extra curricular activity </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "edit_ex_curri_form", "name" => "edit_ex_curri_form", "accept-charset" => "UTF-8" );
                  echo form_open("Staff/editExCu", $attributes);?>
                  <fieldset>
                    <div class="form-group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Assign to a Grade" class="control-label"> Ex. curri. Act. </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="ex_cu_select" name="ex_cu_select">
	                        <option value="<?php echo $ec_id; ?>" selected><?php echo $ec_name ; ?></option>
	                        <?php foreach ($this->all_extra_curri as $row){ ?> <!-- from Staff controller constructor method -->
	                          <option value="<?php echo $row->extra_curri_id; ?>"><?php echo $row->extra_curri_type; ?></option>
	                        <?php } ?>
	                      </select>
	                    </div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
	                <div class="form-group">
	                  <div class="row">
	                    <div class="col-lg-3 col-sm-3">
	                      <label for="Assign to a Class" class="control-label"> Ex. Curri. Role </label>
	                    </div>
	                    <div class="col-lg-9 col-sm-9">
	                      <select class="form-control" id="ex_cu_role_select" name="ex_cu_role_select">
	                        <option value="<?php echo $ec_role_id; ?>" selected><?php echo $ec_role; ?></option>
	                        <?php foreach ($this->all_extra_curri_roles as $row){ ?> <!-- from Staff controller constructor method -->
	                          <option value="<?php echo $row->ex_cu_role_id; ?>"><?php echo $row->ex_cu_role_name; ?></option>
	                        <?php } ?>
	                      </select>
	                      <input type="hidden" name="stfec_no_hidden" value="<?php echo $stfec_id; ?>"> <!-- here $staff_id from top of the page --> 
	                    </div>
	                  </div> <!-- /row -->
	                </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_grdcls" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
	</div> <!-- /container-fluid -->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document ).ready(function() {    
        // date picker
	  	$('.datepicker').datepicker({
	    	format: 'yyyy-mm-dd'
	  	})
    })
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgPrw').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document ).ready(function() {    
    	$("#stf_image").change(function(){
            readURL(this);
        });
    })
</script>