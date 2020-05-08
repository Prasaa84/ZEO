<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
	// this page used to edit item
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
				if(empty($student_result)) {   ?>
                	<div class="alert alert-danger" style="">
                        <?php echo 'No records!!!'; ?>
                    </div>
                    <?php }else{ ?>
 			<?php 	foreach($student_result as $student){  
			 			$st_id = $student->st_id;
			 			$index_no = $student->index_no;
			 			$full_name = $student->fullname;
			 			$name_with_ini = $student->name_with_initials;
			 			$address1 = $student->address1;
			 			$address2 = $student->address2;
			 			$phone_no = $student->phone_no;
			 			$dob = $student->dob;
			 			$gender_id = $student->gender_id;
			 			$gender = $student->gender_name;
			 			$admit_dt = $student->d_o_admission;
			 			$census_id = $student->census_id;
			 			$grd_id = $student->grade_id;
			 			$grd = $student->grade_name;
			 			$cls_id = $student->class_id;
			 			$cls = $student->class_name;
			 			$resp_p_id = $student->response_person_id;
			 			$resp_p_nm = $student->res_p_name;			 			
			 			$date_added = $student->date_added;
			 			$date_updated = $student->last_update;
			 			$is_deleted = $student->is_deleted;
 					}
 			?>
		<div class="row" id="main row">
	        <div class="col-lg-7">
	         	<div class="row">
		            <div class="col-lg-12 col-sm-12">
		              <div class="card mb-3">
		                <div class="card-header">
		                  <i class="fa fa-building"></i> සිසුන් යාවත්කාලීන කිරීම
		                </div>
		                	<div class="card-body">
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
	                      <?php $attributes = array("class" => "form-horizontal", "id" => "update-student", "name" => "update-student");
	                        	echo form_open("Student/editStudent", $attributes);	?>
			                    		<fieldset>
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="student id">ඇතුලත් වීමේ අංකය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="st_id_txt" name="st_id_txt" value="<?php echo $st_id; ?>" readonly="true"/>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
											<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="full name">සම්පූර්ණ නම</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="full_name_txt" name="full_name_txt" value="<?php echo $full_name; ?>" />
                            							<span class="text-danger"><?php echo form_error('item_name_txt'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date added">ඇතුළත් කළ දිනය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="date_added_txt" name="date_added_txt" value="<?php echo $date_added; ?>" readonly="true"/>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date updated">යාවත්කාලීන කළ දිනය</label>
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
			                    						<input id="btn_edit_st" name="btn_edit_st" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    						<span name="is_deleted" value="<?php echo $is_deleted; ?>"></span>
			                    						<a href="<?php echo base_url(); ?>Student/viewStudent" id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-success mt-2" value="Cancel" style="margin-top: 10px;" >Cancel</a>
			                    					</div>
			                    				</div>
			                    			</div> <!-- /form group -->
			                    		</fieldset>
			                    		<?php echo form_close(); ?>
	                    			</div> <!-- /col-sm-12 -->
	                    		</div> <!-- /row -->
	                		</div> <!-- /card body -->
	              		</div> <!-- /card -->
	            	</div> <!-- /col-lg-12 col-sm-12 -->
	            </div>
	        	<?php } ?>
	      	</div>
	  	</div>
	</div> <!-- /container-fluid -->
