<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
	// this page used to update the item status details
?>

<div class="content-wrapper">
 	<div class="container-fluid">
      	<!-- Breadcrumbs-->
    	<ol class="breadcrumb">
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Dashboard</a></li>
	        <li class="breadcrumb-item">
	          <a href="<?php echo base_url(); ?>physicalResource/viewAddPhysicalResourcePage">Physical Resources</a>
	        </li>
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Library/viewDetails">Library</a></li>
        	<li class="breadcrumb-item active">Sanitary Item Status Update</li>
      	</ol>
	        <?php
				if(empty($item_status_details_result)) {   ?>
                	<div class="alert alert-danger" style="">
                        <?php echo 'No records!!!'; ?>
                    </div>
                    <?php }else{ ?>
 			<?php 	foreach($item_status_details_result as $item){  
			 			$san_item_details_id = $item->san_item_details_id;
			 			$census_id = $item->census_id;
			 			$san_item_id = $item->san_item_id;
			 			$item_name = $item->san_item_name;
			 			$qty = $item->quantity;
			 			$usable = $item->usable;
			 			$repairable = $item->repairable;
			 			$date_added = $item->details_date_added;	
			 			$date_updated = $item->details_date_updated;
 					}
 			?>
		<div class="row" id="main row">
	        <div class="col-lg-7">
	         	<div class="row">
		            <div class="col-lg-12 col-sm-12">
		              <div class="card mb-3">
		                <div class="card-header">
		                  <i class="fa fa-building"></i> සනීපාරක්ෂක අයිතම තොරතුරු යාවත්කාලීන කිරීම
		                </div>
		                	<div class="card-body">
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
	                      <?php $attributes = array("class" => "form-horizontal", "id" => "update-sanitary-item-status-details", "name" => "update-sanitary-item-status-details");
	                        	echo form_open("Sanitary/updateItemStatusDetails", $attributes);	?>
			                    		<fieldset>
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="census id">සංගණන අංකය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="census_id_txt" name="census_id_txt" value="<?php echo $census_id; ?>" readonly="true"/>
			                    						<input type="hidden" name="san_item_details_id" value="<?php echo $san_item_details_id ; ?>" />
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
											<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="item name">අයිතමය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<select class="form-control" id="san_item_select" name="san_item_select">
							                                <option value="<?php echo $san_item_id; ?>" selected><?php echo $item_name; ?></option>
						                              	</select>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="item status">තිබෙන ප්‍රමාණය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="quantity_txt" name="quantity_txt" value="<?php echo $qty; ?>" />
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="item status">භාවිතයට ගත හැකි ප්‍රමාණය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="usable_txt" name="usable_txt" value="<?php echo $usable; ?>" />
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="item status">ප්‍රතිසංස්කරණය කළ හැකි ප්‍රමාණය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="repairable_txt" name="repairable_txt" value="<?php echo $repairable; ?>" />
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
			                    						<input id="btn_edit_lib_res_item_status_details" name="btn_edit_san_item_status_details" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    						<a href="<?php echo base_url(); ?>Sanitary/goBackFromUpdate/<?php echo $census_id; ?>" id="btn_back" name="btn_back" type="button" class="btn btn-success mt-2" value="Back" style="margin-top: 10px;" >Back</a>
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
