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
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Building/viewDetails">Buildings</a></li>
        	<li class="breadcrumb-item active">Building Details Update</a></li>
      	</ol>
	        <?php
				if(empty($building_info_result)) {   ?>
                	<div class="alert alert-danger" style="">
                        <?php echo 'No records!!!'; ?>
                    </div>
                    <?php }else{ ?>
 			<?php 	foreach($building_info_result as $row){  
			 			$b_info_id = $row->b_info_id;
			 			$census_id = $row->census_id;
			 			$b_cat_floor_id = $row->b_cat_floor_id;
			 			$category = $row->b_cat_name;
			 			$size_id = $row->b_size_id;
			 			$floor = $row->b_floor;
			 			$length = $row->length;
			 			$width = $row->width;
			 			$usage_id = $row->b_usage_id;
			 			$usage = $row->b_usage;
			 			$donatedby = $row->donated_by;
			 			$built_year = $row->built_year;
			 			$date_added = $row->details_date_added;	
			 			$date_updated = $row->details_date_updated;
 					}
 			?>
		<div class="row" id="main row">
	        <div class="col-lg-7">
	         	<div class="row">
		            <div class="col-lg-12 col-sm-12">
		              <div class="card mb-3">
		                <div class="card-header">
		                  <i class="fa fa-building"></i> ගොඩනැඟිලි තොරතුරු යාවත්කාලීන කිරීම
		                </div>
		                	<div class="card-body">
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
	                      <?php $attributes = array("class" => "form-horizontal", "id" => "update-building-info", "name" => "update-building-info");
	                        	echo form_open("Building/updateBuildingInfo", $attributes);	?>
			                    		<fieldset>
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="census id">සංගණන අංකය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="census_id_txt" name="census_id_txt" value="<?php echo $census_id; ?>" readonly="true"/>
			                    						<input type="hidden" name="b_info_id" value="<?php echo $b_info_id ; ?>" />
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
											<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="item name">ගොඩනැගිලි වර්ගය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<select class="form-control" id="category_select" name="category_select">
							                                <option value="<?php echo $b_cat_floor_id; ?>" selected><?php echo $category.' '.$floor; ?></option>
								                            <?php foreach ($this->building_cat_floor as $row){ ?> <!-- from Building controller constructor method -->
								                              <option value="<?php echo $row->b_cat_floor_id; ?>"><?php echo $row->b_cat_name.' - '.$row->b_floor; ?></option>
								                            <?php } ?>
						                              	</select>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="length">ප්‍රමාණය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
			                    						<select class="form-control" id="size_select" name="size_select">
                            								<option value="<?php echo $size_id;?>" selected><?php echo $length.' * '.$width.' m<sup>2</sup> '; ?></option>
                            								<?php foreach ($this->all_building_sizes as $row){ ?> <!-- from Building controller constructor method -->
                              								<option value="<?php echo $row->b_size_id; ?>"><?php echo $row->length.' * '.$row->width.' m<sup>2</sup> '; ?></option>
                            								<?php } ?>
                            								<option value="" data-toggle="modal" data-target="#addNewSize">නව ප්‍රමාණයක් ඇතුළත් කිරීම</option>
                         	 							</select>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="usage">භාවිතය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
			                    						<select class="form-control" id="usage_select" name="usage_select">
                            								<option value="<?php echo $usage_id;?>" selected><?php echo $usage; ?></option>
                            								<?php foreach ($this->building_usage as $row){ ?> <!-- from Building controller constructor method -->
                              								<option value="<?php echo $row->b_usage_id; ?>"><?php echo $row->b_usage; ?></option>
                            								<?php } ?>
                         	 							</select>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="donatedby">ආධාර ලබාදුන් ආයතනය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control" id="donatedby_txt" name="donatedby_txt" value="<?php echo $donatedby; ?>" />
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
											<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="donatedby">ඉදිකල වර්ෂය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<input type="text" class="form-control datepicker" id="built_year_txt" name="built_year_txt" value="<?php echo $built_year; ?>" />
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
			                    						<input id="btn_edit_building_info" name="btn_edit_building_info" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    						<a href="<?php echo base_url(); ?>Building/goBackFromUpdate/<?php echo $census_id; ?>" id="btn_back" name="btn_back" type="button" class="btn btn-success mt-2" value="Back" style="margin-top: 10px;" >Back</a>
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
	  	<div class="modal fade" id="addNewSize" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> නව ප්‍රමාණයන් ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_new_size_form", "name" => "insert_new_size_form", "accept-charset" => "UTF-8" );
                  echo form_open("Building/addNewBuildingSize", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="length" class="control-label">දිග</label>
                        </div>
                        <div class="col-lg-9 col-sm-3">
                          <input class="form-control" id="length_txt" name="length_txt" placeholder="--මීටර් වලින් ඇතුළත් කරන්න--" type="text" value="<?php echo set_value('length_txt'); ?>" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="width" class="control-label">පළල</label>
                        </div>
                        <div class="col-lg-9 col-sm-3">
                          <input class="form-control" id="width_txt" name="width_txt" placeholder="--මීටර් වලින් ඇතුළත් කරන්න--" type="text" value="<?php echo set_value('width_txt'); ?>" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_size" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
	</div> <!-- /container-fluid -->
<script type="text/javascript">
	$(document).ready(function() {  
		// date picker
		$('.datepicker').datepicker({
			dateFormat: 'yy',
			changeYear: true,
			yearRange:'1955:',
		})
	});
</script>
