<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
	// this page used to edit student data
?>
<style type="text/css">
	.imgPrw{
		max-width: 120px; max-height: 120px;
		margin-top: 20px; margin-bottom: 20px;
	}
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
    }
  ?>
<div class="content-wrapper">
 	<div class="container-fluid">
      	<!-- Breadcrumbs-->
    	<ol class="breadcrumb">
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Dashboard</a></li>
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Student">Student</a></li>
        	<li class="breadcrumb-item active"> Student Update</a></li>
      	</ol>
	        <?php
				if(empty($studentData)) {   ?>
                	<div class="alert alert-danger">
                        <?php echo 'No records!!!'; ?>
                    </div>
                    <?php }else{ ?>
 			<?php 	foreach($studentData as $student){  
			 			$st_id = $student->st_id;
			 			$index_no = $student->index_no;
			 			$full_name = $student->fullname;			 			
			 			$name_with_initials = $student->name_with_initials;
			 			$address1 = $student->st_adr_1;
			 			$address2 = $student->st_adr_2;
			 			$phone_no_1 = $student->phone_no_1;
			 			$phone_no_2 = $student->phone_no_2;
			 			$phone_home = $student->phone_home;
			 			$dob = $student->dob;
			 			$gender_id = $student->gender_id;
			 			$gender_name = $student->gender_name;
			 			$ethnic_group_id = $student->ethnic_group_id;
			 			$ethnic_group = $student->ethnic_group;
			 			$religion_id = $student->religion_id;
			 			$religion = $student->religion;
			 			$census_id = $student->census_id;
			 			$st_status_id = $student->st_status_id;
			 			$st_status = $student->st_status;
			 			$sch_name = $student->sch_name;

			 			$d_o_admission = $student->d_o_admission;

			 			$date_added = $student->added_date;
			 			$date_updated = $student->last_update;
			 			$is_deleted = $student->std_is_deleted;
 					}
 			?>
 		<div class="row">
	        <div class="col-lg-12">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
				  <li class="nav-item">
				    <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal" role="tab" aria-controls="home" aria-selected="true"> පෞද්ගලික තොරතුරු </a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link" id="academic-tab" data-toggle="tab" href="#academic" role="tab" aria-controls="academic-tab" aria-selected="false">අධ්‍යයන තොරතුරු</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link" id="guardian-tab" data-toggle="tab" href="#guardian" role="tab" aria-controls="guardian-tab" aria-selected="false"> භාරකරු</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile-picture" role="tab" aria-controls="profile-tab" aria-selected="false">Photo</a>
				  </li>	
				  <li class="nav-item">
				    <a class="nav-link" id="extra-curricular-tab" data-toggle="tab" href="#extra-curricular" role="tab" aria-controls="extra-curricular-tab" aria-selected="false"> විෂය සමගාමී ක්‍රියාකාරකම් </a>
				  </li>	
				  <li class="nav-item">
				    <a class="nav-link" id="games-tab" data-toggle="tab" href="#games" role="tab" aria-controls="games-tab" aria-selected="false"> විෂය බාහිර ක්‍රියාකාරකම් </a>
				  </li>	
				  <li class="nav-item">
				    <a class="nav-link" id="winnings-tab" data-toggle="tab" href="#winnings" role="tab" aria-controls="winnings-tab" aria-selected="false"> ලබාගත් ජයග්‍රහණ </a>
				  </li>		  
				</ul>
				<div class="tab-content" id="myTabContent">
				  	<div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab"> 
				  		<div class="row">
				  			<div class="col-lg-12">
		            	<div class="card mb-3" style="border-top: none">
		                	<div class="card-body">
		                		<div class="row">
		                    		<div class="col-sm-12">
								  <?php
								    if(!empty($this->session->flashdata('updateSuccessMsg'))) {
								      	$message = $this->session->flashdata('updateSuccessMsg'); 
								     	echo '<div class="alert alert-success" >'.$message['text'].'</div>';
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
	                        	echo form_open("Student/updateStudentPersonalInfo", $attributes);	?>
			                    		<fieldset>
			                    			<div class="row">
			                    			<div class="col-lg-9">
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<?php  $staff_id; ?>
			                    						<label for="Name with ini"> ඇතුළත් වීමේ අංකය <?php //echo $st_gr_cl_id; ?> </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="index_no_txt" name="index_no_txt" value="<?php echo $index_no; ?>" readonly />
                            							<span class="text-danger"><?php echo form_error('index_no_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->	
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<?php  $staff_id; ?>
			                    						<label for="Name with ini">මුලකුරු සමඟ නම </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="name_with_ini_txt" name="name_with_ini_txt" value="<?php echo $name_with_initials; ?>" />
                            							<span class="text-danger"><?php echo form_error('name_with_ini_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
                    						<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Full name">සම්පූර්ණ නම </label>
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
			                    						<label for="Address">ලිපින පේළිය 1 </label>
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
			                    						<label for="Address">ලිපින පේළිය 2</label>
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
			                    						<label for="address 2">ජංගම දුරකථන අංකය </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9 ">
														<input type="text" class="form-control" id="phone_no_1_txt" name="phone_no_1_txt" value="<?php echo $phone_no_1; ?>" />
                            							<span class="text-danger"><?php echo form_error('phone_no_1_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 2">WhatsApp අංකය </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9 ">
														<input type="text" class="form-control" id="phone_no_2_txt" name="phone_no_2_txt" value="<?php echo $phone_no_2; ?>" />
                            							<span class="text-danger"><?php echo form_error('phone_no_2_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 2">නිවසේ දුරකථන අංකය </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9 ">
														<input type="text" class="form-control" id="phone_home_txt" name="phone_home_txt" value="<?php echo $phone_home; ?>" />
                            							<span class="text-danger"><?php echo form_error('phone_home_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
											<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date of birth"> උපන් දිනය </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9 ">
														<input type="text" class="form-control datepicker" id="dob_txt" name="dob_txt" value="<?php echo $dob; ?>" readonly="readonly" title="Click to change" data-toggle="tooltip" />
                            							<span class="text-danger"><?php echo form_error('dob_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Civil Status">ස්ත්‍රී/පුරුෂ භාවය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
			                    						<select class="form-control" id="gender_select" name="gender_select">
								                            <option value="<?php echo $gender_id; ?>" selected><?php echo $gender_name; ?></option>
								                            <?php foreach ($this->all_genders as $row){ ?> <!-- from Building controller constructor method -->
								                              <option value="<?php echo $row->gender_id; ?>"><?php echo $row->gender_name; ?></option>
								                            <?php } ?>
                          								</select>
                            							<span class="text-danger"><?php echo form_error('gender_select'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->	
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="address 1"> ආගම </label>
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
			                    						<label for="address 2">ජාතිය</label>
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
			                    						<label for="date of admission"> මෙම පාසලට ඇතුළත් වූ දිනය </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control datepicker" id="d_o_admission_txt" name="d_o_admission_txt" value="<?php echo $d_o_admission; ?>" readonly="readonly" title="Click to change" data-toggle="tooltip"/>
                            							<span class="text-danger"><?php echo form_error('d_o_admission_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="student status"> තත්ත්වය  </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<select class="form-control" id="stu_status_select" name="stu_status_select">
								                            <option value="<?php echo $st_status_id; ?>" selected><?php echo $st_status; ?></option>
								                            <?php foreach ($this->all_student_status as $row){ ?> <!-- from Building controller constructor method -->
								                              <option value="<?php echo $row->st_status_id; ?>"><?php echo $row->st_status; ?></option>
								                            <?php } ?>
								                         </select>
								                         <span class="text-danger"><?php echo form_error('stu_status_select'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date added">දත්ක ඇතුළත් කළ දිනය </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="dateadded_txt" name="dateadded_txt" value="<?php echo $date_added; ?>" readonly="true"/>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date updated"> යාවත් කාලීන කළ දිනය </label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="date_updated" name="date_updated" value="<?php echo $date_updated; ?>" readonly="true"/>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3"></div>
			                    					<div class="col-lg-9 col-sm-9">
		                      							<input type="hidden" name="st_id_hidden" value="<?php echo $st_id; ?>" />
		                      							<input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
		                      							<input type="hidden" name="date_added_hidden" value="<?php echo $date_added; ?>" />
		                      							<input type="hidden" name="is_deleted_hidden" value="<?php echo $is_deleted; ?>" />
		                      							<!-- // submit button -->
              									<?php 	if(($role_id=='1') || ($role_id=='2')){ ?>
			                    							<input id="btn_edit_student_pers_info" name="btn_edit_student_pers_info" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" /> 
                    							<?php 	} ?>
			                    						<a href="<?php echo base_url(); ?>Student" id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-success mt-2" value="Cancel" style="margin-top: 10px;" >Cancel</a>
			                    					</div>
			                    				</div>
			                    			</div> <!-- /form group -->
			                    			</div>
			                    			<div class="col-lg-3">
			                    				<div class="col-lg-12 col-sm-12">
		                    						<center>
		                    				<?php 
		                    							$file_name = $census_id.'_'.$index_no;		
														if( file_exists("./assets/uploaded/student_images/$file_name.jpg") ){ 
		                    				?>
		                    								<img src="<?php echo base_url(); ?>assets/uploaded/student_images/<?php echo $file_name; ?>.jpg" style="">
		                    				<?php 		}else{ 		?>
		                    								<img src="<?php echo base_url(); ?>assets/uploaded/student_images/default_stu_profile_image.png" style="">
		                    				<?php 		} ?>
		                    							<h2><?php echo $index_no; ?></h2>
		                    						</center>
			                    				</div>
			                    			</div>
			                    		</div>
			                    		</fieldset>
			                    		<?php echo form_close(); ?>
	                    			</div> <!-- /col-sm-12 -->
	                    		</div> <!-- /row -->
	                		</div> <!-- /card body -->
	              		</div> <!-- /card -->
	              	</div> <!-- / col-lg-8 -->
	              </div> <!-- / row -->
				</div> <!-- / personal tab-pane fade -->
<!-- ----------------------------------------------------------------------------------------------------------------- -->
			<?php 
				$ci = & get_instance();
				$ci->load->model('Student_model');
				$year = date('Y');
				$stuentGradeClass = $ci->Student_model->get_student_current_grade_class($index_no, $census_id);
				
				//echo $index_no.'-'.$census_id;
				if( !empty( $stuentGradeClass ) ){
					//print_r($stuentGradeClass);
					foreach ( $stuentGradeClass as $row ) {
						$st_gr_cl_id = $row->st_gr_cl_id;
						//$index_no = $row->index_no;
						$grade_id = $row->grade_id;
						$grade = $row->grade;
						$class_id = $row->class_id;
						$class = $row->class;
						//$census_id = $row->census_id;
						$academic_year = $row->year;
						$grcl_date_added = $row->date_added;
						$grcl_date_updated = $row->date_updated;
					}	
				}else{
					$st_gr_cl_id = '';
					$grade_id = '';
					$grade = '';
					$class_id = '';
					$class = '';
					$academic_year = '';
					$grcl_date_added = '';
					$grcl_date_updated = '';
				}
			?>
				<div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="academic-tab"> 
	         		<div class="row">
	         		<div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3"  style="border-top: none">
		                	<div class="card-body">
		                		<div class="row">
		                    		<div class="col-sm-12">
									  <?php
									    if(!empty($this->session->flashdata('acInfoUpdateSuccessMsg'))) {
									      	$message = $this->session->flashdata('acInfoUpdateSuccessMsg'); 
									     	echo '<div class="alert alert-success" >'.$message['text'].'</div>';
									   } ?> 
									  <?php
									    if(!empty($this->session->flashdata('acInfoUpdateErrorMsg'))) {
									      	$message = $this->session->flashdata('acInfoUpdateErrorMsg');  
									      	echo '<div class="alert alert-danger" >'.$message['text'].'</div>';
									   } ?> 		                		
       								</div>
       							</div>
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
		                  <?php $attributes = array("class" => "form-horizontal", "id" => "update_school_info_form", "name" => "update_school_info_form");
		                    	echo form_open("Student/updateStudentAcademicInfo", $attributes);	?>
			                    		<fieldset>
			                    <?php 	if($role_id=='1'){ // admin ?>
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-sm-3">
						                          <label for="School"> School </label>
						                        </div>
						                        <div class="col-sm-5">
						                          <select class="form-control" id="school_select" name="school_select">
						                    <?php 	if(!empty($sch_name)){ ?>
						                            	<option value="<?php echo $census_id; ?>" selected><?php echo $sch_name; ?></option>
						                    <?php	}else{ ?> 
						                            	<option value="" selected>Select</option>
						                    <?php }	?>
						                    
						                      <?php   
						                              $selected_school = set_value('school_select');
						                              foreach ($this->all_schools as $school){ 
						                                if($school->census_id == $selected_school){ 
						                      ?>
						                                  <option value="<?php echo $school->census_id; ?>" selected><?php echo $school->sch_name.' - '.$school->census_id; ?></option>
						                      <?php     }else{ ?> 
						                                  <option value="<?php echo $school->census_id; ?>"><?php echo $school->sch_name.' - '.$school->census_id; ?></option>
						                      <?php     } 
						                              }
						                      ?> 
						                          </select>
						                          <span class="text-danger" id="grade_error"><?php echo form_error('school_select'); ?></span>
						                        </div>
						                      </div>
						                    </div>
						          <?php } ?>
			                    			<div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="Employee Type" class="control-label"> අධ්‍යයන වර්ෂය  </label>
						                        </div>
			                    				<div class="col-lg-5 col-sm-5">
					                          		<select class="form-control" id="select_year" name="select_year" title="Please select">
													  <option value="<?php echo $academic_year; ?>" selected="selected" ><?php echo $academic_year; ?></option>
							                          <?php 
							                            $starting_year = 2020;
							                            $current_year = date('Y');
							                            for($current_year; $current_year >= $starting_year; $current_year--) {
															echo '<option value="'.$current_year.'">'.$current_year.'</option>';
							                            }  
							                          ?>                               
						                        	</select>                         
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group --> 
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Name with ini">ශ්‍රේණිය </label>
			                    					</div>
			                    					<div class="col-lg-5 col-sm-5">
														<select class="form-control" id="grade_select" name="grade_select">
								                            <option value="<?php echo $grade_id; ?>" selected><?php echo $grade; ?></option>
								                    <?php 		foreach ( $this->all_grades as $row ){ ?> 
								                              		<option value="<?php echo $row->grade_id; ?>"><?php echo $row->grade; ?></option>
								                	<?php 		} ?>
								                        </select>
		                    							<span class="text-danger"><?php echo form_error('grade_select'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
						                    <div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="Appointment category" class="control-label"> පන්තිය  </label>
						                        </div>
			                    				<div class="col-lg-5 col-sm-5">
						                        	<select class="form-control" id="class_select" name="class_select" data-toggle="tooltip" title="Change the grade to load other classes">
								                    	<option value="<?php echo $class_id; ?>" selected><?php echo $class; ?></option>
						                          	</select>  
						                          	<span class="text-danger"><?php echo form_error('class_select'); ?></span>                       
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date added">දත්ක ඇතුළත් කළ දිනය </label>
			                    					</div>
			                    					<div class="col-lg-5 col-sm-5">
														<input type="text" class="form-control" id="grcl_date_added_txt" name="grcl_date_added_txt" value="<?php echo $grcl_date_added; ?>" readonly="true"/>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date updated"> යාවත් කාලීන කළ දිනය </label>
			                    					</div>
			                    					<div class="col-lg-5 col-sm-5">
														<input type="text" class="form-control" id="grcl_date_updated" name="grcl_date_updated" value="<?php echo $grcl_date_updated; ?>" readonly="true"/>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->  
						                    <div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3"></div>
			                    					<div class="col-lg-5 col-sm-5">
														<?php //echo $census_id; ?>
		                      							<input type="hidden" name="st_id_hidden" value="<?php echo $st_id; ?>" />
		                      							<input type="hidden" name="index_no_hidden" value="<?php echo $index_no; ?>" />
		                      							<input type="hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
		                      							<input type="hidden" name="st_gr_cl_id_hidden" value="<?php echo $st_gr_cl_id; ?>" />
		                      							<!-- submit button -->
              									<?php 	if( ($role_id=='1') || ($role_id=='2') ){ ?>
			                    							<input id="btn_edit_stu_ac_info" name="btn_edit_stu_ac_info" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    							<span name="is_deleted" value="<?php echo $is_deleted; ?>"></span>
			                    				<?php 	} ?>
			                    						<a href="<?php echo base_url(); ?>Student" id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-success mt-2" value="Cancel" style="margin-top: 10px;" >Cancel</a>
			                    					</div>
			                    				</div>
			                    			</div> <!-- /form group -->
			                    		</fieldset>
			                    		<?php echo form_close(); ?>
			                    	</div> <!-- /col-lg-12 col-sm-12 -->
	                    		</div> <!-- /row -->
	                		</div> <!-- /card body -->
	              		</div> <!-- /card -->
	              	</div> <!-- / col-lg-8 -->
	              </div> <!-- / row -->
				</div> <!-- / tab-pane fade school data -->
<!-- ----------------------------------------------------------------------------------------------------------------- -->
		<?php 
				$ci = & get_instance();
				$ci->load->model('Student_model');
				$year = date('Y');
				foreach($studentData as $student){  
					$st_id = $student->st_id;
					$index_no = $student->index_no;
					$census_id = $student->census_id;
				}
				$studentGuardian = $ci->Student_model->get_guardian( $index_no,$census_id );
				
				if( !empty( $studentGuardian ) ){
					foreach ( $studentGuardian as $row ) {
						$guardian_id = $row->id;
						$index_no = $row->index_no;
						$census_id = $row->census_id;
						$fa_name = $row->f_name;
						$fa_job = $row->f_job;
						$fa_mobile = $row->f_mobile;
						$mo_name = $row->m_name;
						$mo_job = $row->m_job;
						$mo_mobile = $row->m_mobile;
						$g_name = $row->g_name;
						$g_job = $row->g_job;
						$g_mobile = $row->g_mobile;
						$g_date_added = $row->date_added;
						$g_date_updated = $row->date_updated;
					}	
				}else{
					$guardian_id = '';
					$index_no = $index_no;
					$census_id = $census_id;
					$fa_name = '';
					$fa_job = '';
					$fa_mobile = '';
					$mo_name = '';
					$mo_job = '';
					$mo_mobile = '';
					$g_name = '';
					$g_job = '';
					$g_mobile = '';
					$g_date_added = '';
					$g_date_updated = '';
				}

		?>
				<div class="tab-pane fade" id="guardian" role="tabpanel" aria-labelledby="guardian-tab"> 
	         		<div class="row">
	         		<div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3"  style="border-top: none">
		                	<div class="card-body">
		                		<div class="row">
		                    		<div class="col-sm-12">
		                    <?php
								    if( !empty( $this->session->flashdata('updateGuardSuccessMsg') ) ) {
								      	$message = $this->session->flashdata('updateGuardSuccessMsg'); 
								     	echo '<div class="alert alert-success" >'.$message['text'].'</div>';
								   	} 
							?> 
							<?php
								    if( !empty($this->session->flashdata('updateGuardErrorMsg')) ) {
								      	$message = $this->session->flashdata('updateGuardErrorMsg');  
								      	echo '<div class="alert alert-danger" >'.$message['text'].'</div>';
								   	} 
							?> 		                		
       								</div>
       							</div>
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
		                  <?php $attributes = array("class" => "form-horizontal", "id" => "update_guardian_info_form", "name" => "update_guardian_info_form");
		                    	echo form_open("Student/updateStudentGuardianInfo", $attributes);	?>
			                    		<fieldset>
						                    <div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Full name">පියාගේ නම </label>
			                    					</div>
			                    					<div class="col-lg-5 col-sm-5">
														<input type="text" class="form-control" id="fa_name_txt" name="fa_name_txt" placeholder="ඇතුළත් කරන්න" value="<?php echo $fa_name; ?>" />
                            							<span class="text-danger"><?php echo form_error('fa_name_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="staff number"> පියාගේ දුරකථන අංකය </label>
						                        </div>
			                    				<div class="col-lg-5 col-sm-5">
						                          <input class="form-control" id="fa_tel_txt" name="fa_tel_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo $fa_mobile; ?>" />
                            						<span class="text-danger"><?php echo form_error('fa_tel_txt'); ?></span>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->	
			                    			<div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="staff number"> පියාගේ රැකියාව  </label>
						                        </div>
			                    				<div class="col-lg-5 col-sm-5">
						                          <input class="form-control" id="fa_job_txt" name="fa_job_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo $fa_job; ?>" />
                            						<span class="text-danger"><?php echo form_error('fa_job_txt'); ?></span>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Full name">මවගේ නම </label>
			                    					</div>
			                    					<div class="col-lg-5 col-sm-5">
														<input type="text" class="form-control" id="mo_name_txt" name="mo_name_txt" placeholder="ඇතුළත් කරන්න" value="<?php echo $mo_name; ?>" />
                            							<span class="text-danger"><?php echo form_error('mo_name_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="staff number"> මවගේ දුරකථන අංකය </label>
						                        </div>
			                    				<div class="col-lg-5 col-sm-5">
						                          <input class="form-control" id="mo_tel_txt" name="mo_tel_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo $mo_mobile; ?>" />
                            						<span class="text-danger"><?php echo form_error('mo_tel_txt'); ?></span>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->	
			                    			<div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="staff number"> මවගේ රැකියාව  </label>
						                        </div>
			                    				<div class="col-lg-5 col-sm-5">
						                          <input class="form-control" id="mo_job_txt" name="mo_job_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo $mo_job; ?>" />
                            						<span class="text-danger"><?php echo form_error('mo_job_txt'); ?></span>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="Full name">භාරකරුගේ නම </label>
			                    					</div>
			                    					<div class="col-lg-5 col-sm-5">
														<input type="text" class="form-control" id="g_name_txt" name="g_name_txt" placeholder="ඇතුළත් කරන්න" value="<?php echo $g_name; ?>" />
                            							<span class="text-danger"><?php echo form_error('g_name_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="staff number"> භාරකරුගේ දුරකථන අංකය </label>
						                        </div>
			                    				<div class="col-lg-5 col-sm-5">
						                          <input class="form-control" id="g_tel_txt" name="g_tel_txt" placeholder="ඇතුළත් කරන්න" ype="text" value="<?php echo $g_mobile; ?>" />
                            						<span class="text-danger"><?php echo form_error('g_tel_txt'); ?></span>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->	
			                    			<div class="form-group">
						                      <div class="row">
						                        <div class="col-lg-3 col-sm-3">
						                          <label for="staff number"> භාරකරුගේ රැකියාව  </label>
						                        </div>
			                    				<div class="col-lg-5 col-sm-5">
						                          <input class="form-control" id="g_job_txt" name="g_job_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo $g_job; ?>" />
                            						<span class="text-danger"><?php echo form_error('g_job_txt'); ?></span>
						                        </div>
						                      </div> <!-- /row -->
						                    </div> <!-- /form group -->
						                    <div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3"></div>
			                    					<div class="col-lg-5 col-sm-5">
		                      							<input type="hidden" name="st_id_hidden" value="<?php echo $st_id; ?>" />
		                      							<input type="hidden" name="index_no_hidden" value="<?php echo $index_no; ?>" />
		                      							<input type="hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
		                      							<input type="hidden" name="guardian_id_hidden" value="<?php echo $guardian_id; ?>" />
		                      							<!-- submit button -->
              									<?php 	if( ($role_id=='1') || ($role_id=='2') ){ ?>
			                    							<input id="btn_edit_stu_guard_info" name="btn_edit_stu_guard_info" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    							<span name="is_deleted" value="<?php echo $is_deleted; ?>"></span>
			                    				<?php 	} ?>
			                    						<a href="<?php echo base_url(); ?>Student" id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-success mt-2" value="Cancel" style="margin-top: 10px;" >Cancel</a>
			                    					</div>
			                    				</div>
			                    			</div> <!-- /form group -->
			                    		</fieldset>
			                    		<?php echo form_close(); ?>
			                    	</div> <!-- /col-lg-12 col-sm-12 -->
	                    		</div> <!-- /row -->
	                		</div> <!-- /card body -->
	              		</div> <!-- /card -->
	              	</div> <!-- / col-lg-8 -->
	              </div> <!-- / row -->
				</div> <!-- / tab-pane fade guardian-tab -->
<!-- ----------------------------------------------------------------------------------------------------------------- -->
				<div class="tab-pane fade" id="profile-picture" role="tabpanel" aria-labelledby="profile-picture-tab"> 
	         		<div class="row">
	         		<div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3"  style="border-top: none">
		                	<div class="card-body">
		                		<div class="row">
		                    		<div class="col-sm-12">
								  <?php
								    if(!empty($this->session->flashdata('stdImgUploadSuccess'))) {
								      $message = $this->session->flashdata('stdImgUploadSuccess');  ?>
								      <div class="alert alert-success" ><?php echo $message; ?></div>
								  <?php } ?> 
								  <?php
								    if(!empty($this->session->flashdata('stdImgUploadError'))) {
								      $message = $this->session->flashdata('stdImgUploadError');  
								        foreach ($message as $item => $value){
								          echo '<div class="alert alert-danger" >'.$value.'</div>';
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
		                  <?php $attributes = array("class" => "form-horizontal", "id" => "update_stu_image_form", "name" => "update_stu_image_form");
		                    	echo form_open_multipart("Student/uploadStudentImage", $attributes);	?>
			                    		<fieldset>
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-6 col-sm-6">
		                      							<div class="row">
				                    						<div class="col-lg-12 col-sm-12">
		                      									<center><h4><?php echo $name_with_initials; ?></h4></center>
		                      									<center><h5><?php echo $index_no; ?></h5></center>
		                      								</div>
		                      							</div>
		                      							<div class="row">
				                    						<div class="col-lg-6 col-sm-6">
		                      									<center><input type="file" name="stu_image" size="20" id="stu_image" title="Change Image" /></center>
		                      								</div> 
				                    						<div class="col-lg-6 col-sm-6">
				                    							<img id="imgPrw" src="#" alt="" class="imgPrw" />
		                      								</div> 
		                      							</div>
		                      							<div class="row">
		                      								<div class="col-lg-6 col-sm-6">
		                      									<input type="hidden" name="stu_id_hidden" value="<?php echo $st_id; ?>" />
		                      									<input type="hidden" name="index_no_hidden" value="<?php echo $index_no; ?>" />
		                      									<input type="hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
			                    							</div>
		                      							</div>
		                      								<div class="row">
			                      								<div class="col-lg-6 col-sm-6">
		                      							<?php 		if ($role_id==2) {  ?>
	              														<button class="btn btn-primary" type="submit" name="btn_upload_stu_img" value="upload_stu_image" style="margin:5 0 5 0; "> Upload </button>
																		<button type="button" class="btn btn-success mt-0" data-toggle="modal" data-target="#helpModal"><i class="fa fa-question"></i></button>

		                      							<?php 		}else{ echo 'Log to system as school to upload image'; }	?>	

				                    							</div>
		                      								</div>
		                      				
			                    					</div>
			                    					<div class="col-lg-6 col-sm-6">
			                    						<center>
			                    				<?php 
															$file_name = $census_id.'_'.$index_no;
															if( file_exists("./assets/uploaded/student_images/$file_name.jpg") ){ 
			                    				?>
			                    								<img src="<?php echo base_url(); ?>assets/uploaded/student_images/<?php echo $file_name; ?>.jpg" style="">
			                    				<?php 		}else{ ?>
			                    								<img src="<?php echo base_url(); ?>assets/uploaded/student_images/default_stu_profile_image.png" style="">
			                    				<?php 		} ?>
			                    						</center>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    		</fieldset>
			                    		<?php echo form_close(); ?>
			                    	</div> <!-- /col-lg-12 col-sm-12 -->
	                    		</div> <!-- /row -->
	                		</div> <!-- /card body -->
	              		</div> <!-- /card -->
	              	</div> <!-- / col-lg-8 -->
	              </div> <!-- / row -->
				</div> <!-- / tab-pane fade profile-picture -->
	<!-- ---------------------Student's extra curriculum activities are displayed here--------------------------------------  -->
				<div class="tab-pane fade" id="extra-curricular" role="tabpanel" aria-labelledby="extra-curricular-tab"> 
	         		<div class="row">
		         		<div class="col-lg-12 col-sm-12">
			              	<div class="card mb-3"  style="border-top: none">
			                	<div class="card-body">
			                		<div class="row">
			                    		<div class="col-sm-12">
			                    			<?php 
									      if(!empty($this->session->flashdata('stdexCurMsg'))) {
									        $stdexCurMsg = $this->session->flashdata('stdexCurMsg');  ?>
									        <div class="<?php echo $stdexCurMsg['class']; ?>" ><?php echo $stdexCurMsg['text']; ?></div>
									    <?php   } ?>  
			                    		<?php if( empty( $std_ex_cur_info ) ){
			                    				echo '<h4>Not Assigned!!!</h4>';
			                    			}else{
	 									?>
											<div class="table-responsive">
												<table class="table table-hover" id="extracu_info_tbl" class="table table-striped table-bordered" cellspacing="0" width="">
													<thead>
														<tr>
														<th scope="col" class="col-sm-6"> ක්‍රියාකාරකම </th>
														<th scope="col" class="col-sm-4"> භූමිකාව </th>
														<th scope="col" class="col-sm-2"> වර්ෂය </th>	
														<th scope="col" class="col-sm-2">  </th>	
														</tr>
													</thead>
													<tbody>
													<?php 
														$no = 0;
														foreach( $std_ex_cur_info as $ex_cur_info ){
															$std_ex_cur_id = $ex_cur_info->std_ex_cur_id;  
															$census_id = $ex_cur_info->census_id;
															$index_no = $ex_cur_info->index_no;
															$ec_id = $ex_cur_info->extra_curri_id;
															$ec_type = $ex_cur_info->extra_curri_type;	
															$ec_role_id = $ex_cur_info->std_ex_cur_role_id;	
															$role_name = $ex_cur_info->std_ex_cur_role_name;
															$year = $ex_cur_info->year;
														?>
														<tr id="<?php echo 'tbrow'.$std_ex_cur_id; ?>">
														<td style="vertical-align:middle"><?php echo $ec_type; ?></td>
														<td style="vertical-align:middle"><?php echo $role_name; ?></td>
														<td style="vertical-align:middle"><?php echo $year; ?></td>
														<td id="td_btn">
															<a type="button" id="btn_delete_ex_cur_info" name="btn_delete_ex_cur_info" class="btn btn-danger btn-sm btn_delete_ex_cur_info" value="Cancel" data-toggle="tooltip" title="Delete" data-id="<?php echo $std_ex_cur_id; ?>"><i class="fa fa-trash-o"></i></a>
														</td>					                        
														</tr>
													<?php	} }?>
														<tr>
														<td>
															<button id="btn_add_new_ex_cur_info" name="btn_add_new_ex_cur_info" type="button" class="btn btn-primary btn-sm" value="Add" data-toggle="modal" data-target="#AssignToNewExtraCurri"><i class="fa fa-plus"></i> Add New</button>
														</td>
														<td></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div> <!-- /col-lg-12 col-sm-12 -->
		                    		</div> <!-- /row -->
		                		</div> <!-- /card body -->
		              		</div> <!-- /card -->
		              	</div> <!-- / col-lg-8 -->
	              	</div> <!-- / row -->
				</div> <!-- / tab-pane fade extra-curricular -->
		<!-- ----------------------------------------------- Starting Games Tab------------------------------------------------------ -->
				<div class="tab-pane fade" id="games" role="tabpanel" aria-labelledby="games-tab"> 
	         		<div class="row">
	         		<div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3"  style="border-top: none">
		                	<div class="card-body">
		                		<div class="row">
		                    		<div class="col-sm-12">
		                    			<?php 
								      if(!empty($this->session->flashdata('stdGameMsg'))) {
								        $stdGameMsg = $this->session->flashdata('stdGameMsg');  ?>
								        <div class="<?php echo $stdGameMsg['class']; ?>" ><?php echo $stdGameMsg['text']; ?></div>
								    <?php   } ?>  
		                    		<?php if(empty($std_game_info)){
		                    				echo '<h4>Not Assigned!!!</h4>';
		                    			}else{
 									?>
										<div class="table-responsive">
											<table class="table table-hover" id="games_info_tbl" class="table table-striped table-bordered" cellspacing="0" width="">
												<thead>
													<tr>
														<th scope="col" class="col-sm-2"> ක්‍රීඩාව </th>
														<th scope="col" class="col-sm-4"> භූමිකාව </th>
														<th scope="col" class="col-sm-2"> වර්ෂය </th>
														<th scope="col" class="col-sm-4"> දිනය </th>
														<th></th>					                          
													</tr>
												</thead>
												<tbody>
												<?php 
													$no = 0;
													foreach($std_game_info as $game_info){
														$stgm_id = $game_info->st_gm_id;  
														$index_no = $game_info->index_no;
														$game_id = $game_info->game_id;
														$game_name = $game_info->game_name;	
														$game_role_id = $game_info->std_gm_role_id;	
														$game_role = $game_info->std_gm_role_name;
														$year = $game_info->year;
														$date = $game_info->date;
													?>
													<tr id="<?php echo 'tbrow'.$stgm_id; ?>">
													<td style="vertical-align:middle"><?php echo $game_name; ?></td>
													<td style="vertical-align:middle"><?php echo $game_role; ?></td>
													<td id="td_btn"><?php echo $year; ?></td>
													<td id="td_btn"><?php echo $date; ?></td>
													<td id="td_btn">
														<a type="button" name="btn_delete_game_info" class="btn btn-danger btn-sm btn_delete_game_info" value="Cancel" data-toggle="tooltip" title="Delete this details" data-id="<?php echo $stgm_id; ?>" ><i class="fa fa-trash-o"></i></a>
													</td>					                        
													</tr>
												<?php	} } ?>
													<tr>
													<td>
														<button id="btn_add_new_game_info" name="btn_add_new_game_info" type="button" class="btn btn-primary btn-sm" value="Add" data-toggle="modal" data-target="#AssignToNewGame"><i class="fa fa-plus"></i> Add New</button>
													</td>
													<td></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div> <!-- /col-lg-12 col-sm-12 -->
	                    		</div> <!-- /row -->
	                		</div> <!-- /card body -->
	              		</div> <!-- /card -->
	              	</div> <!-- / col-lg-8 -->
	              </div> <!-- / row -->
				</div> <!-- / tab-pane fade games -->
<!-- ----------------------------------------------- Starting Winnings Tab------------------------------------------------------ -->
				<div class="tab-pane fade" id="winnings" role="tabpanel" aria-labelledby="winnings-tab"> 
	         		<div class="row">
	         		<div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3"  style="border-top: none">
		                	<div class="card-body">
		                		<div class="row">
		                    		<div class="col-sm-12">
		                    	<?php 
								      	if( !empty( $this->session->flashdata('stdWinMsg') ) ) {
								        	$stdWinMsg = $this->session->flashdata('stdWinMsg');  ?>
								        	<div class="<?php echo $stdWinMsg['class']; ?>" ><?php echo $stdWinMsg['text']; ?></div>
							<?php   	} ?>  
										<h5 align="center">විෂය සමගාමී සහ විෂය බාහිර ක්‍රියාකාරකම් වලින් ලද ජයග්‍රහණ </h5>
										<div class="table-responsive">
											<table class="table table-hover" id="std_winings_info_tbl" class="table table-striped table-bordered" cellspacing="0" width="">
												<thead>
													<tr>
														<th scope="col" class="col-sm-1"> වර්ගය </th>
														<th scope="col" class="col-sm-2"> ක්‍රියාකාරකම </th>
														<th scope="col" class="col-sm-1"> භූමිකාව </th>
														<th scope="col" class="col-sm-1"> ක්‍රීඩාව </th>
														<th scope="col" class="col-sm-1"> භූමිකාව </th>
														<th scope="col" class="col-sm-2"> තරඟය </th>
														<th scope="col" class="col-sm-1"> ජයග්‍රහණය </th>
														<th scope="col" class="col-sm-2"> විස්තරය </th>
														<th scope="col" class="col-sm-1"> දිනය </th>
														<th></th>					                          
													</tr>
												</thead>
												<tbody>
									<?php 		if( !empty( $std_winnings ) ){
													$no = 0;
													foreach( $std_winnings as $std_win ){
														$std_win_id = $std_win->std_win_id;  
														$census_id = $std_win->census_id;
														$index_no = $std_win->index_no;
														if( $std_win->main_type == 1 ){
															$main_type = 'විෂය සමගාමී';
														}elseif( $std_win->main_type == 2 ){
															$main_type = 'විෂය බාහිර';
														}else{
															$main_type = 'වෙනත්';
														}

														$extra_curri_type = $std_win->extra_curri_type;	
														$extra_curri_role = $std_win->std_ex_cur_role_name;	
														$game_name = $std_win->game_name;	
														$game_role = $std_win->std_gm_role_name;	
														$contest = $std_win->contest;	
														$win_type = $std_win->win_type;
														$remarks = $std_win->remarks;
														$date_held = $std_win->date_held;
														$date_added = $std_win->date_added;
													?>
														<tr id="<?php echo 'tbrow'.$std_win_id; ?>">
															<td style="vertical-align:middle"><?php echo $main_type; ?></td>
															<td style="vertical-align:middle"><?php echo $extra_curri_type; ?></td>
															<td id="td_btn"><?php echo $extra_curri_role; ?></td>
															<td style="vertical-align:middle"><?php echo $game_name; ?></td>
															<td style="vertical-align:middle"><?php echo $game_role; ?></td>
															<td id="td_btn"><?php echo $contest; ?></td>
															<td id="td_btn"><?php echo $win_type; ?></td>
															<td id="td_btn"><?php echo $remarks; ?></td>
															<td id="td_btn"><?php echo $date_held; ?></td>
															<td id="td_btn">
																<a type="button" name="btn_delete_win_info" class="btn btn-danger btn-sm btn_delete_win_info" value="Cancel" data-toggle="tooltip" title="Delete this details" data-id="<?php echo $std_win_id; ?>" ><i class="fa fa-trash-o"></i></a>
															</td>					                        
														</tr>
									<?php			} 
													}else{
														echo '<tr><td colspan="6">No records available. Add winnings</td></tr>';
													} ?>
												</tbody>
											</table>
										</div>
										<button id="btn_add_new_ex_cur_win" name="btn_add_new_ex_cur_win" type="button" class="btn btn-primary btn-sm" value="Add" data-toggle="modal" data-target="#AddStudentWin"><i class="fa fa-plus"></i> Add New</button>
									</div> <!-- /col-lg-12 col-sm-12 -->
	                    		</div> <!-- /row -->
	                		</div> <!-- /card body -->
	              		</div> <!-- /card -->
	              	</div> <!-- / col-lg-8 -->
	              </div> <!-- / row -->
				</div> <!-- / tab-pane fade games -->
	    	</div> <!-- / col-lg-12 -->
 		</div> <!-- / row -->
<?php } ?> <!-- if not empty $stf_result -->
	</div> <!-- /container-fluid -->
	<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> ශිෂ්‍යයකුෙග් photo එක ඇතුළත් කිරීම </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  1. jpg file පමණක් upload කරන්න. <br>
                  2. maximum file size is 400KB. <br>
                  3. maximum width is 250px. <br>
                  4. maximum height is 250px. <br>

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
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
						$attributes = array("class" => "form-horizontal", "id" => "insert_student_game_info_form", "name" => "insert_stf_game_info_form", "accept-charset" => "UTF-8" );
						echo form_open("Student/AssignToNewGame", $attributes);?>
						<fieldset>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="Assign to a game" class="control-label"> ක්‍රීඩාව </label>
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
										<label for="Assign to a game" class="control-label"> ශිෂ්‍ය භූමිකාව </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<select class="form-control" id="game_role_select" name="game_role_select">
											<option value="" selected>---Select---</option>
											<?php foreach ($this->all_game_roles_of_student as $row){ ?> <!-- from Building controller constructor method -->
											<option value="<?php echo $row->std_gm_role_id; ?>"><?php echo $row->std_gm_role_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group -->
							<div class="form-group" id="year_select_div">
								<div class="row">
									<div class="col-lg-3 col-sm-5">
										<label for="new category" class="control-label"> වර්ෂය </label>
									</div>
									<div class="col-lg-9 col-sm-7">
									<input type="hidden" name="index_no_hidden" id="index_no_hidden" value="<?php echo $index_no; ?>"> <!-- here $st_id from top of the page --> 
										<input type="hidden" name="st_id_hidden" value="<?php echo $st_id; ?>"> <!-- here $st_id from top of the page --> 
										<input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>" />
										<select class="form-control mb-2 mr-sm-2" id="year_select" name="year_select" title="Please select">
											<option value="" selected>---Select---</option>
										<?php 
											$year = date('Y');
											$selected_year = set_value('year_select');
											for( $year; $year > 2019; $year-- ) {
												if( $year == $selected_year ){ 
													echo '<option value="'.$year.'" >'.$year.'</option>';
												}else{ 
													echo '<option value="'.$year.'" >'.$year.'</option>';
												} 
											}
										?>                              
										</select>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group --> 
							<div class="form-group" id="game_effective_date_txt_div">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="dob" class="control-label"> දිනය  </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<input class="form-control datepicker" id="game_effective_date_txt" name="game_effective_date_txt" placeholder="---ක්ලික් කරන්න---" type="text" value="" size="60" />
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
	<!-- /following bootstrap model used to assign extracurricur acts to student-->
	<div class="modal fade" id="AssignToNewExtraCurri" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          	<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> Assign to new extra curriculam  </h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12 my-auto">
						<?php
						$attributes = array("class" => "form-horizontal", "id" => "insert_student_ex_cur_info_form", "name" => "insert_student_ex_cur_info_form", "accept-charset" => "UTF-8" );
						echo form_open("Student/AssignToNewExtraCurri", $attributes);?>
						<fieldset>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="Assign to an ex cur" class="control-label"> ක්‍රියාකාරකම </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<select class="form-control" id="ex_cur_select" name="ex_cur_select">
											<option value="" selected>---Select---</option>
											<?php foreach ($this->all_extra_curriculum as $row){ ?> <!-- from Building controller constructor method -->
											<option value="<?php echo $row->extra_curri_id; ?>"><?php echo $row->extra_curri_type; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group -->
							<div class="form-group" id="game_role_select_form_group">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="Assign to a role" class="control-label"> ශිෂ්‍ය භූමිකාව </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<select class="form-control" id="std_ex_cur_role_select" name="std_ex_cur_role_select">
											<option value="" selected>---Select---</option>
											<?php foreach ($this->all_ex_cur_roles_of_student as $row){ ?> <!-- from Building controller constructor method -->
											<option value="<?php echo $row->std_ex_cur_role_id; ?>"><?php echo $row->std_ex_cur_role_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group -->
							<div class="form-group" id="ex_cu_year_select_div">
								<div class="row">
									<div class="col-lg-3 col-sm-5">
										<label for="new category" class="control-label"> වර්ෂය </label>
									</div>
									<div class="col-lg-9 col-sm-7">
										<input type="hidden" name="index_no_hidden" id="index_no_hidden" value="<?php echo $index_no; ?>"> <!-- here $st_id from top of the page --> 
										<input type="hidden" name="st_id_hidden" value="<?php echo $st_id; ?>"> <!-- here $st_id from top of the page --> 
										<input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>" />
										<select class="form-control mb-2 mr-sm-2" id="ex_cu_year_select" name="ex_cu_year_select" title="Please select">
											<option value="" selected>---Select---</option>
										<?php 
											$year = date('Y');
											$selected_year = set_value('ex_cu_year_select');
											for( $year; $year > 2019; $year-- ) {
												if( $year == $selected_year ){ 
													echo '<option value="'.$year.'" >'.$year.'</option>';
												}else{ 
													echo '<option value="'.$year.'" >'.$year.'</option>';
												} 
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
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<button class="btn btn-primary" type="submit" name="btn_add_new_extra_cur_info" value="Add_New">Save</button>
				</div> <!-- /modal-footer -->
				</fieldset>
            <?php echo form_close(); ?>
          	</div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
    </div> <!-- / .modal fade -->
	<!-- /following bootstrap model used to assign extracurricur acts to student-->
	<div class="modal fade" id="AddStudentWin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          	<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> තරඟ ජයග්‍රහණයන්  </h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12 my-auto">
						<?php
						$attributes = array("class" => "form-horizontal", "id" => "insert_student_win_form", "name" => "insert_student_win_form", "accept-charset" => "UTF-8" );
						echo form_open("Student/AddStudentWin", $attributes);?>
						<fieldset>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-3 col-sm-3"> 
										<label for="Assign to an ex cur" class="control-label"> වර්ගය </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<select class="form-control form-control-sm" id="main_type_select" name="main_type_select">
											<option value="" selected>---Select---</option>
											<option value="1" > විෂය සමගාමී </option>
											<option value="2" > විෂය බාහිර </option>
											<option value="3" > වෙනත් </option>
										</select>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group -->
							<div class="form-group" id="win_ex_cur_select_form_group">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="Assign to an ex cur" class="control-label"> ක්‍රියාකාරකම </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<select class="form-control form-control-sm" id="win_ex_cur_select" name="win_ex_cur_select">
											<option value="" selected>---Select---</option>
											<?php foreach ($this->all_extra_curriculum as $row){ ?> <!-- from Building controller constructor method -->
											<option value="<?php echo $row->extra_curri_id; ?>"><?php echo $row->extra_curri_type; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group -->
							<div class="form-group" id="win_ex_cur_role_select_form_group">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="Assign to a role" class="control-label"> ශිෂ්‍ය භූමිකාව </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<select class="form-control" id="wing_std_ex_cur_role_select" name="win_std_ex_cur_role_select">
											<option value="" selected>---Select---</option>
											<?php foreach ($this->all_ex_cur_roles_of_student as $row){ ?> <!-- from Building controller constructor method -->
											<option value="<?php echo $row->std_ex_cur_role_id; ?>"><?php echo $row->std_ex_cur_role_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group -->
							<div class="form-group" id="win_game_select_form_group">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="Assign to a game" class="control-label"> ක්‍රීඩාව </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<select class="form-control" id="win_game_select" name="win_game_select">
											<option value="" selected>---Select---</option>
											<?php foreach ($this->all_games as $row){ ?> <!-- from Building controller constructor method -->
											<option value="<?php echo $row->game_id; ?>"><?php echo $row->game_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group -->
							<div class="form-group" id="win_game_role_select_form_group">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="Assign to a game" class="control-label"> ශිෂ්‍ය භූමිකාව </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<select class="form-control" id="win_game_role_select" name="win_game_role_select">
											<option value="" selected>---Select---</option>
											<?php foreach ($this->all_game_roles_of_student as $row){ ?> <!-- from Building controller constructor method -->
											<option value="<?php echo $row->std_gm_role_id; ?>"><?php echo $row->std_gm_role_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group -->

							<div class="form-group" id="contest_text_area_form_group">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="Assign to a role" class="control-label"> තරඟය </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<textarea class="form-control form-control-sm" name="contest_text_area" id="contest_text_area" cols="30" rows="2"></textarea>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group -->
							<div class="form-group" id="win_select_form_group">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="Assign to a role" class="control-label"> ජයග්‍රහණය </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<select class="form-control form-control-sm" id="win_type_select" name="win_type_select">
											<option value="" selected>---Select---</option>
											<?php foreach ($this->all_win_types as $row){ ?> <!-- from Building controller constructor method -->
											<option value="<?php echo $row->win_type_id; ?>"><?php echo $row->win_type; ?></option>
											<?php } ?>
										</select>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group -->
							<div class="form-group" id="other_info_text_area_form_group">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="Assign to a role" class="control-label"> වෙනත් විස්තර </label>
									</div>
									<div class="col-lg-9 col-sm-9">
										<textarea class="form-control form-control-sm" name="win_remarks_text_area" id="win_remarks_text_area" cols="30" rows="5"></textarea>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group -->
							<div class="form-group">
								<div class="row">
									<div class="col-lg-3 col-sm-3">
										<label for="date of birth"> පැවැත්වූ දිනය </label>
									</div>
									<div class="col-lg-9 col-sm-9 ">
										<input type="text" class="form-control datepicker form-control-sm" id="date_held_txt" name="date_held_txt" value="<?php echo $dob; ?>" readonly="readonly" />
										<span class="text-danger"><?php echo form_error('date_held_txt'); ?></span>
									</div>
								</div> <!-- /row -->
							</div> <!-- /form group --> 
						<!-- <fieldset> -->
						</div> <!-- /col-sm-12 -->
					</div> <!-- /row -->
				</div> <!-- /modal-body -->
				<div class="modal-footer">
					<input type="hidden" name="index_no_hidden" id="index_no_hidden" value="<?php echo $index_no; ?>"> <!-- here $st_id from top of the page --> 
					<input type="hidden" name="st_id_hidden" value="<?php echo $st_id; ?>"> <!-- here $st_id from top of the page --> 
					<input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>" />
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<button class="btn btn-primary" type="submit" name="btn_add_std_win" value="Add_New">Save</button>
				</div> <!-- /modal-footer -->
				</fieldset>
            <?php echo form_close(); ?>
          	</div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
    </div> <!-- / .modal fade -->
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/buttons.colVis.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$('#year_select_div').hide();
	  	$('#game_effective_date_txt_div').hide();
		// in inserting student winnings form
		$('#win_ex_cur_select_form_group').hide();
		$('#win_ex_cur_role_select_form_group').hide();
		$('#win_game_select_form_group').hide();
		$('#win_game_role_select_form_group').hide();


		$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        	localStorage.setItem('activeTab', $(e.target).attr('href'));
    	});
    	var activeTab = localStorage.getItem('activeTab');
    	if(activeTab){
        	$('#myTab a[href="' + activeTab + '"]').tab('show');
    	}

	});
	$(document ).ready(function() {    
        // date picker
	  	$('.datepicker').datepicker({
	    	dateFormat: 'yy-mm-dd',
          	changeYear: true,
          	yearRange:'1955:',
			maxDate: 0
	  	})
    });
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
	// වර්ෂය තෝරනවිට ශ්‍රේණිය ලෝඩ් කිරීමට යොදා ගැනේ. 
	$(document).on('change', '#select_year', function(){  
    	var year = $(this).val();
    	<?php if($role_id==1){ ?>
    		var census_id = $('#school_select').val();
    	<?php }
    	if($role_id==2){ ?>
    		var census_id = $('#census_id_hidden').val();
    	<?php } ?>
    	if(!census_id){
    		swal('Select the School');
    	}else if(!year){
    		swal('Select the Year');
    	}else{
	     	$.ajax({  
		    	url:"<?php echo base_url(); ?>SchoolGrades/viewGradesSchoolWise",  
		        method:"POST",  
		        data:{census_id:census_id,year:year},  
		        dataType:"json",  
		        success:function(grades)  
		        {  
		        	if(!grades){
						$('select#grade_select').html('');
						$('select#class_select').html('');
	              		swal('Grades not found!!!!')
	              		//$('select#grade_select').disabled();
	              	}else{
	              			$('select#grade_select').html('');
						  $('select[name="grade_select"]').append('<option value="">---Select---</option>');
		                $.each(grades, function(key,value) {
		                    $('select[name="grade_select"]').append('<option value="'+ value.grade_id +'">'+ value.grade +'</option>');
		                }); 	
	              	}
		       	}, 
	          	error: function(xhr, status, error) {
	            	alert(xhr.responseText);
	          	} 
	     	})
	    }  
  	});
    // ශ්‍රේණිය තෝරනවිට පන්තිය ලෝඩ් කිරීමට යොදා ගැනේ. 
  	$(document).on('change', '#grade_select', function(){  
    	var grade_id = $(this).val();
    	var year = $('#select_year').val();
    	<?php if($role_id==1){ ?>
    		var census_id = $('#school_select').val();
    	<?php }
    	if($role_id==2){ ?>
    		var census_id = $('#census_id_hidden').val();
    	<?php } ?>
    	if(!census_id){
    		swal('Select the School');
    	}else if(!year){
    		swal('Select the Year');
    	}else{
	     	$.ajax({  
		    	url:"<?php echo base_url(); ?>SchoolClasses/viewClassesGradeWise",  
		        method:"POST",  
		        data:{grade_id:grade_id,census_id:census_id,year:year},  
		        dataType:"json",  
		        success:function(classes)  
		        {  
		        	if(!classes){
						$('select#class_select').html('');
	              		swal('Classes not found!!!!');
	              		$('select#grade_select').disabled();
	              	}else{
	              		$('select#class_select').html('');
		                $.each(classes, function(key,value) {
		                    $('select[name="class_select"]').append('<option value="'+ value.class_id +'">'+ value.class +'</option>');
		                }); 	
	              	}
		       	}, 
	          	error: function(xhr, status, error) {
	            	alert(xhr.responseText);
	          	} 
	     	})
	    }  
  	});
  	// පාසල  තෝරනවිට එම පාසලෙහි පවත්නා ශ්‍රේණි ලෝඩ් කිරීමට යොදා ගැනේ.
    // This is used by Admin
<?php if( $role_id=='1' ){ // admin ?>
		$(document).on('change', '#school_select', function(){  
			//alert($(this).val());
			var census_id = $(this).val();
			var year = $('#select_year').val();
			//alert($census_id);
			$.ajax({  
			url:"<?php echo base_url(); ?>SchoolClasses/viewGradesSchoolWise",  
			method:"POST",  
			data:{census_id:census_id},  
			dataType:"json",  
			success:function(classes)  
			{  
				if(!classes){
				swal('Classes not found!!!!')
				$('select#grade_select').disabled();
				//$('select#select_grade_of_stu').html('Not Found');
				}else{
				$('select#grade_select').html('');
				$.each(classes, function(key,value) {
					$('select[name="grade_select"]').append('<option value="'+ value.grade_id +'">'+ value.grade +'</option>');
				}); 
				}
			}, 
			error: function(xhr, status, error) {
				alert(xhr.responseText);
			} 
			})  
		});
<?php } // admin ?>
	
	// empty field validation of student game info form
	$("#insert_student_game_info_form").submit(function(){
		var game_id = $('#game_select').val();
		var game_student_role_id = $('#game_role_select').val();
		var year = $('#year_select').val();
		var effective_date = $('#game_effective_date_txt').val();
		var index_no = $('#index_no_hidden').val();
		var census_id = $('#census_id_hidden').val();
		//alert(game_id);
		if( game_id == '' ){
			swal("Error!", "Game is required", "warning");
			return false;    
		}else if( game_student_role_id == '' ){
			swal("Error!", "Student role is required", "warning");
			return false;        
		}else if( game_student_role_id == 1 && year == '' ){
			swal("Error!", "Year is required", "warning");
			return false; 
		}else if( game_student_role_id == 3 && year == '' ){
			swal("Error!", "Year is required", "warning");
			return false; 
		}else if( game_student_role_id == 2 && effective_date == '' ){
			swal("Error!", "Date is required", "warning");
			return false; 
		}else{ 
			return true; 
		}
  	});
	// used when insert student game information 
	$( "#game_role_select" ).change(function(){
		if( $(this).val() == 1 ){
			$('#year_select_div').fadeIn();
			$('#game_effective_date_txt_div').fadeOut();
		}else if( $(this).val() == 2 ){
			$('#year_select_div').fadeOut();
			$('#game_effective_date_txt_div').fadeIn();
		}else if( $(this).val() == 3 ){
			$('#year_select_div').fadeIn();
			$('#game_effective_date_txt_div').fadeOut();
		}else{
			$('#year_select_div').fadeOut();
			$('#game_effective_date_txt_div').fadeOut();
		}
	});
	// deleting student's playing games info
	$(".btn_delete_game_info").click(function(){
       	var row_id = $(this).parents("tr").attr("id");
        var stgm_id = $(this).attr("data-id");
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this record!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url:"<?php echo base_url(); ?>Student/deleteGameInfo",  
					method:"POST",  
					data:{stgm_id:stgm_id}, 
					error: function() {
						alert('Something is wrong');
					},
					success: function(data) {
							if(data.trim()=='true'){
							$("#"+row_id).remove();
							swal("Deleted!", "Game data has been deleted.", "success");
							}else{
							swal("Error!", "Game details not deleted.", "error");
							}
					}
				});
			} 
        }); 
    });
	// empty field validation of inserting student extra curriculum form
	$("#insert_student_ex_cur_info_form").submit(function(){
		var ex_cur_id = $('#ex_cur_select').val();
		var ex_cur_role_id = $('#std_ex_cur_role_select').val();
		var year = $('#ex_cu_year_select').val();
		var index_no = $('#index_no_hidden').val();
		var census_id = $('#census_id_hidden').val();
		//alert(game_id);
		if( ex_cur_id == '' ){
			swal("Error!", "Extra curriculum is required", "warning");
			return false;    
		}else if( ex_cur_role_id == '' ){
			swal("Error!", "Student role is required", "warning");
			return false;        
		}else if( year == '' ){
			swal("Error!", "Year is required", "warning");
			return false; 
		}else { 
			return true; 
		}
  	});
	// deleting student's extra curriculum info
	$(".btn_delete_ex_cur_info").click(function(){
       	var row_id = $(this).parents("tr").attr("id");
        var st_ex_cur_id = $(this).attr("data-id");
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this record!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url:"<?php echo base_url(); ?>Student/deleteStdExCurInfo",  
					method:"POST",  
					data:{st_ex_cur_id:st_ex_cur_id}, 
					error: function() {
						alert('Something is wrong');
					},
					success: function(data) {
							if(data.trim()=='true'){
							$("#"+row_id).remove();
							swal("Deleted!", "Game data has been deleted.", "success");
							}else{
							swal("Error!", "Game details not deleted.", "error");
							}
					}
				});
			} 
        }); 
    });
	// empty field validation of inserting student extra curriculum form
	$("#insert_student_ex_cur_info_form").submit(function(){
		var ex_cur_id = $('#ex_cur_select').val();
		var ex_cur_role_id = $('#std_ex_cur_role_select').val();
		var year = $('#ex_cu_year_select').val();
		var index_no = $('#index_no_hidden').val();
		var census_id = $('#census_id_hidden').val();
		//alert(game_id);
		if( ex_cur_id == '' ){
			swal("Error!", "Extra curriculum is required", "warning");
			return false;    
		}else if( ex_cur_role_id == '' ){
			swal("Error!", "Student role is required", "warning");
			return false;        
		}else if( year == '' ){
			swal("Error!", "Year is required", "warning");
			return false; 
		}else { 
			return true; 
		}
  	});
	// used when insert student winning information 
	$( "#main_type_select" ).change(function(){
		if( $(this).val() == 1 ){
			$('#win_game_select_form_group').fadeOut();
			$('#win_game_role_select_form_group').fadeOut();
			$('#win_ex_cur_select_form_group').fadeIn();
			$('#win_ex_cur_role_select_form_group').fadeIn();
		}else if( $(this).val() == 2 ){
			$('#win_ex_cur_select_form_group').fadeOut();
			$('#win_ex_cur_role_select_form_group').fadeOut();
			$('#win_game_select_form_group').fadeIn();
			$('#win_game_role_select_form_group').fadeIn();
		}else if( $(this).val() == 3 ){
			$('#win_ex_cur_select_form_group').fadeOut();
			$('#win_ex_cur_role_select_form_group').fadeOut();
			$('#win_game_select_form_group').fadeOut();
			$('#win_game_role_select_form_group').fadeOut();
		}else{
			$('#win_ex_cur_select_form_group').fadeOut();
			$('#win_ex_cur_role_select_form_group').fadeOut();
			$('#win_game_select_form_group').fadeOut();
			$('#win_game_role_select_form_group').fadeOut();
		}
	});
	// empty field validation of inserting student extra curriculum form
	$("#insert_student_win_form").submit(function(){
		var main_type = $('#main_type_select').val();
		var ex_cur = $('#win_ex_cur_select').val();
		var ex_cur_role = $('#wing_std_ex_cur_role_select').val();
		var game = $('#win_game_select').val();
		var game_role = $('#win_game_role_select').val();
		var contest = $('#contest_text_area').val(); 
		var win_type = $('#win_type_select').val();
		var remarks = $('#win_remarks_text_area').val(); 
		var date = $('#date_held_txt').val();
		var index_no = $('#index_no_hidden').val();
		var census_id = $('#census_id_hidden').val();
		//alert(game_id);
		if( main_type == '' ){
			swal("Error!", "Main type is required", "warning");
			return false;    
		}else if( main_type == 1 && ex_cur == '' ){
			swal("Error!", "Extra curriculum is required", "warning");
			return false;        
		}else if( ex_cur != '' && ex_cur_role == '' ){
			swal("Error!", "Student role in this activity is required", "warning");
			return false;        
		}else if( main_type == 2 && game == '' ){
			swal("Error!", "Game is required", "warning");
			return false; 
		}else if( game != '' && game_role == '' ){
			swal("Error!", "Student role in this game is required", "warning");
			return false;        
		}else if( contest == '' ){
			swal("Error!", "Contest is required", "warning");
			return false; 
		}else if( win_type == '' ){
			swal("Error!", "Winning type is required", "warning");
			return false; 
		}else if( date == '' ){
			swal("Error!", "Contest date is required", "warning");
			return false; 
		}else{ 
			return true; 
		}
  	});
	// deleting student's winning info
	$(".btn_delete_win_info").click(function(){
       	var row_id = $(this).parents("tr").attr("id");
        var std_win_id = $(this).attr("data-id");
		//alert(std_win_id);
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this record!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel!",
          closeOnConfirm: false,
          closeOnCancel: true
        },
        function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url:"<?php echo base_url(); ?>Student/deleteStdWinInfo",  
					method:"POST",  
					data:{std_win_id:std_win_id}, 
					error: function() {
						alert('Something is wrong');
					},
					success: function(data) {
							if(data.trim()=='true'){
								$("#"+row_id).remove();
								swal("Deleted!", "Winning data has been deleted.", "success");
							}else{
								swal("Error!", "Winning details not deleted.", "error");
							}
					}
				});
			} 
        }); 
    });
</script>