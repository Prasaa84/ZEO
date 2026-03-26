<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
	// this page used to edit status
?>

<div class="content-wrapper">
 	<div class="container-fluid">
      	<!-- Breadcrumbs-->
    	<ol class="breadcrumb">
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Dashboard</a></li>
	        <li class="breadcrumb-item">
	          <a href="<?php echo base_url(); ?>physicalResource/viewAddPhysicalResourcePage">Physical Resources</a>
	        </li>
        	<li class="breadcrumb-item active">Physical Resource Status Update</a></li>
      	</ol>
	        <?php
				if(empty($status_result)) {   ?>
                	<div class="alert alert-danger" style="">
                        <?php echo 'No records!!!'; ?>
                    </div>
                    <?php }else{ ?>
 			<?php 	foreach($status_result as $status){  
			 			$status_id = $status['phy_res_status_id'];
			 			$status_type = $status['phy_res_status_type'];
			 			$group_id = $status['status_group_id'];
			 			$date_added = $status['date_added'];
			 			$date_updated = $status['date_updated'];
			 			$is_deleted = $status['is_deleted'];
 					}
 			?>
		<div class="row" id="main row">
	        <div class="col-lg-7">
	         	<div class="row">
		            <div class="col-lg-12 col-sm-12">
		              <div class="card mb-3">
		                <div class="card-header">
		                  <i class="fa fa-building"></i> තත්වයන් යාවත්කාලීන කිරීම
		                </div>
		                <div class="card-body">
		                	<div class="row">
		                		<div class="col-sm-12 my-auto">
		                			<?php $attributes = array("class" => "form-horizontal", "id" => "update-status", "name" => "update-status");
		                			echo form_open("PhysicalResource/updateStatus", $attributes);	?>
		                			<fieldset>
		                				<div class="form-group">
		                					<div class="row">
		                						<div class="col-lg-3 col-sm-3">
		                							<label for="item id">තත්ත්ව අංකය</label>
		                						</div>
		                						<div class="col-lg-9 col-sm-9">
		                							<input type="text" class="form-control" id="status_id_txt" name="status_id_txt" value="<?php echo $status_id; ?>" readonly="true"/>
		                						</div>
		                					</div> <!-- /row -->
		                				</div> <!-- /form group -->
		                				<div class="form-group">
		                					<div class="row">
		                						<div class="col-lg-3 col-sm-3">
		                							<label for="status type">තත්ත්වය</label>
		                						</div>
		                						<div class="col-lg-9 col-sm-9">
		                							<input type="text" class="form-control" id="status_type_txt" name="status_type_txt" value="<?php echo $status_type; ?>" />
		                							<span class="text-danger"><?php echo form_error('status_type_txt'); ?></span>
		                						</div>
		                					</div> <!-- /row -->
		                				</div> <!-- /form group -->
		                				<div class="form-group">
		                					<div class="row">
		                						<div class="col-lg-3 col-sm-3">
		                							<label for="status type">කාණ්ඩය</label>
		                						</div>
		                						<div class="col-lg-9 col-sm-9">
		                							<input type="text" class="form-control" id="status_group_id_txt" name="status_group_id_txt" value="<?php echo $group_id; ?>" />
		                							<span class="text-danger"><?php echo form_error('status_group_id_txt'); ?></span>
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
		                						<div class="col-lg-3 col-sm-3">
		                						</div>
		                						<div class="col-lg-9 col-sm-9">
		                							<input type="hidden" name="is_deleted_hidden" value="<?php echo $is_deleted; ?>" />
		                						</div>
		                					</div> <!-- /row -->
		                				</div> <!-- /form group -->
		                				<div class="form-group">
		                					<div class="row">
		                						<div class="col-lg-3 col-sm-3"></div>
		                						<div class="col-lg-9 col-sm-9 ">
		                							<input id="btn_edit_status" name="btn_edit_status" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
		                							<a href="<?php echo base_url(); ?>PhysicalResource/viewAddPhysicalResourcePage" id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-success mt-2" value="Cancel" style="margin-top: 10px;" >Cancel</a>
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
