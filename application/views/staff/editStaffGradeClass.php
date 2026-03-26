<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
	// this page used to edit item
?>

<div class="content-wrapper">
 	<div class="container-fluid">
      	<!-- Breadcrumbs-->
    	<ol class="breadcrumb">
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Dashboard</a></li>
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Staff/viewAcademicStaff">Staff</a></li>
        	<li class="breadcrumb-item active">Staff Grade Class Update</a></li>
      	</ol>
	        <?php
				if(empty($gc_result)) {   ?>
                	<div class="alert alert-danger" >
                        <?php echo 'No records!!!'; ?>
                    </div>
                    <?php }else{ ?>
 			<?php 	foreach($gc_result as $row){  
			 			$stf_grd_cls_id = $row->stf_grd_cls_id;
			 			$staff_id = $row->stf_id;
			 			$grade_id = $row->grade_id;
			 			$grade_name = $row->grade;
			 			$class_id = $row->class_id;
			 			$class_name = $row->class;
			 			$class_role_id = $row->sec_role_id;
			 			$class_role_name = $row->sec_role_name;
			 			$date_added = $row->date_added;
			 			$date_updated = $row->date_updated;
			 			$is_deleted = $row->is_deleted;
 					}
 			?>
		<div class="row" id="main row">
	        <div class="col-lg-7">
	         	<div class="row">
		            <div class="col-lg-12 col-sm-12">
		              <div class="card mb-3">
		                <div class="card-header">
		                  <i class="fa fa-building"></i> Update Staff Grade Class Details
		                </div>
		                	<div class="card-body">
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
	                      <?php $attributes = array("class" => "form-horizontal", "id" => "update_stf_grade_cls_info_form", "name" => "update_stf_grade_cls_info_form");
	                        	echo form_open("Staff/editStaffGradeClass", $attributes);	?>
			                    		<fieldset>
									      	<div class="form-group">
							                  <div class="row">
							                    <div class="col-lg-3 col-sm-3">
							                      <label for="Assign to a Grade" class="control-label"> Grade </label>
							                    </div>
							                    <div class="col-lg-9 col-sm-9">
							                      <select class="form-control" id="grade_select" name="grade_select">
							                        <option value="<?php echo $grade_id; ?>" selected><?php echo $grade_name; ?></option>
							                        <?php foreach ($this->all_grades as $row){ ?> <!-- from Staff controller constructor method -->
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
							                        <?php foreach ($this->all_classes as $row){ ?> <!-- from Staff controller constructor method -->
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
							                        <option value="<?php echo $class_role_id; ?>" selected><?php echo $class_role_name; ?></option>
							                        <option value="3"> Class Teacher </option>
							                        <option value="4"> Teacher </option>
							                        <option value="5"> Not Assigned </option>
							                      </select>
							                      <input type="hidden" name="stf_gc_id_hidden" value="<?php echo $stf_grd_cls_id; ?>"> <!-- here $staff_id from top of the page --> 
							                      <input type="hidden" name="stf_id_hidden" value="<?php echo $staff_id; ?>"> <!-- here $staff_id from top of the page --> 
							                      <input type="hidden" name="date_added_hidden" value="<?php echo $date_added; ?>"> <!-- here $staff_id from top of the page --> 												
												</div>
							                  </div> <!-- /row -->
							                </div> <!-- /form group -->
							                <div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3"></div>
			                    					<div class="col-lg-9 col-sm-9 ">
			                    						<input id="btn_edit_stf_gc" name="btn_edit_stf_gc" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    						<a href="<?php echo base_url(); ?>Staff/editStaffView/<?php echo $staff_id; ?>" id="btn_back" name="btn_back" type="reset" class="btn btn-success mt-2" value="Back" style="margin-top: 10px;" > Back </a>
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
