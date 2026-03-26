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
        	<li class="breadcrumb-item active">Physical Resource Item Status Update</a></li>
      	</ol>
	        <?php
				if(empty($item_status_details_result)) {   ?>
                	<div class="alert alert-danger" style="">
                        <?php echo 'No records!!!'; ?>
                    </div>
                    <?php }else{ ?>
 			<?php 	foreach($item_status_details_result as $item){  
			 			$phy_res_detail_id = $item->phy_res_detail_id;
			 			$census_id = $item->census_id;
			 			$item_id = $item->phy_res_cat_id;
			 			$item_name = $item->phy_res_category;
			 			$status_id = $item->phy_res_status_id;
			 			$status_type = $item->phy_res_status_type;
			 			//$date_added = $item->date_added;	
			 			//$date_updated = $item->date_updated;
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
		                  <i class="fa fa-building"></i> අයිතමයන් වල තත්ත්වයන් යාවත්කාලීන කිරීම
		                </div>
		                	<div class="card-body">
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
	                      <?php $attributes = array("class" => "form-horizontal", "id" => "update-physical-resource-status-details", "name" => "update-physical-resource-status-details");
	                        	echo form_open("PhysicalResource/updateItemStatusDetails", $attributes);	?>
			                    		<fieldset>
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="census id">සංගණන අංකය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="census_id_txt" name="census_id_txt" value="<?php echo $census_id; ?>" readonly="true"/>
			                    						<input type="hidden" name="phy_res_detail_id" value="<?php echo $phy_res_detail_id ; ?>" />
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
											<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="item name">අයිතමය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<select class="form-control" id="phy_res_item_select" name="phy_res_item_select">
							                                <option value="<?php echo $item_id; ?>" selected><?php echo $item_name; ?></option>
						                              	</select>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="item status">තත්ත්වය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
			                    						<select class="form-control" id="phy_res_item_status_select" name="phy_res_item_status_select">
							                            	<option value="<?php echo $status_id; ?>" selected><?php echo $status_type; ?></option>
							                                <?php foreach ($this->all_status as $row){ ?> <!-- from PhysicalResource controller constructor method -->
							                                  <option value="<?php echo $row['phy_res_status_id']; ?>"><?php echo $row['phy_res_status_type']; ?></option>
							                                <?php } ?>
							                             </select>
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
			                    						<input id="btn_edit_phy_res_item_status_details" name="btn_edit_phy_res_item_status_details" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    						<a href="<?php echo base_url(); ?>PhysicalResource/goBackFromUpdate/<?php echo $census_id; ?>" id="btn_back" name="btn_back" type="button" class="btn btn-success mt-2" value="Back" style="margin-top: 10px;" >Back</a>
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
