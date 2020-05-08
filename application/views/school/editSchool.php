<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
 	<div class="container-fluid">
      	<!-- Breadcrumbs-->
    	<ol class="breadcrumb">
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Dashboard</a></li>
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>school">School</a></li>
        	<li class="breadcrumb-item active">Update School Details</li>
      	</ol>
      	<?php
        if(!empty($this->session->flashdata('msg'))) {
        	$message = $this->session->flashdata('msg');  ?>
          	<div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      	<?php } ?>
      	<?php
      	if(empty($school_details_result)) {   ?>
      	<div class="alert alert-danger" style="">
      		<?php echo 'No records!!!'; ?>
      	</div>
      	<?php }else{ ?>
      	<?php 	foreach($school_details_result as $school){  
		      		$census_id = $school->census_id;
		      		$exam_no = $school->exam_no;
		      		$name = $school->sch_name;
		      		$address1 = $school->address1;
		      		$address2 = $school->address2;
		      		$contact = $school->contact_no;
		      		$email = $school->email;	
		      		$webaddress = $school->web_address;
		      		$gs_div_id = $school->gs_div_id;
		      		$gs_div_name = $school->gs_div_name;
		      		$edu_div_id = $school->edu_div_id;	
		      		$edu_div_name = $school->div_name;	
		      		$sch_type_id = $school->sch_type_id;
		      		$sch_belongs_to_id = $school->belongs_to_id;
		      		$sch_belongs_to_name = $school->belongs_to_name;      		
		      		$sch_type_name = $school->sch_type;     		
		      		$user_id = $school->user_id;
		      		$date_added = $school->school_details_add_dt;	
		      		$date_updated = $school->school_details_upd_dt;
		      		$is_deleted = $school->is_deleted;
      			} ?>
		<div class="row" id="main row">
	        <div class="col-lg-8">
	         	<div class="row">
		            <div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3" id="">
			                <div class="card-header">
			                  <i class="fa fa-building"></i> පාසලේ තොරතුරු යාවත්කාලීන කිරීම
			                </div>
		                	<div class="card-body" id="printDiv">
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
		                    			<?php
		                    			$attributes = array("class" => "form-horizontal", "id" => "update-school", "name" => "update-school");
		                    			echo form_open("School/updateSchool", $attributes);?>
		                    			<div id="school_info">
		                    			<fieldset>
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="census id">සංඝනන අංකය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
		                    							<input class="form-control" id="txt_census_id" name="txt_census_id" placeholder="--- සංඝනන අංකය ---" type="text" value="<?php echo $census_id; ?>" />
		                    							<span class="text-danger"><?php echo form_error('txt_census_id'); ?></span>
		                    						</div>
		                    					</div> <!-- /row -->
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="sch exam no">විභාග අංකය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
		                    							<input class="form-control" id="txt_exam_no" name="txt_exam_no" placeholder="---විභාග අංකය---" type="text" value="<?php echo $exam_no; ?>" />
		                    							<span class="text-danger"><?php echo form_error('txt_exam_no'); ?></span>
		                    						</div>
		                    					</div> <!-- /row -->
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="school_name" class="control-label">පාසලේ නම</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
		                    							<input class="form-control" id="txt_school_name" name="txt_school_name" placeholder="---පාසලේ නම---" type="text" value="<?php echo $name; ?>" />
		                    							<span class="text-danger"><?php echo form_error('txt_school_name'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="school_type" class="control-label">පාසල් වර්ගය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
		                    							<select class="form-control" id="select_sch_type" name="select_sch_type" title="Please select" data-toggle="tooltip">
							                                <option value="<?php echo $sch_type_id; ?>" selected><?php echo $sch_type_name; ?></option>
		                    								<?php 
		                    								if(!empty($this->all_sch_types)){
		                    									foreach ($this->all_sch_types as $row){ ?><!-- from PhysicalResource controller constructor method -->
		                    									<option value="<?php echo $row->sch_type_id; ?>"><?php echo $row->sch_type; ?></option>
		                    									<?php } }else{ ?>
		                    									<option value="" selected>No records found!!!</option>
		                    									<?php } ?>     
		                    							</select>
		                    							<span class="text-danger"><?php echo form_error('select_sch_type'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="txt_address1" class="control-label">ලිපිනය 1</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
		                    							<input class="form-control" id="txt_address1" name="txt_address1" placeholder="---ලිපිනය 1---" type="text" value="<?php echo $address1; ?>" />
		                    							<span class="text-danger"><?php echo form_error('txt_address1'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="txt_address2" class="control-label">ලිපිනය 2</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
		                    							<input class="form-control" id="txt_address2" name="txt_address2" placeholder="---ලිපිනය 2---" type="text" value="<?php echo $address2; ?>" />
		                    							<span class="text-danger"><?php echo form_error('txt_address2'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="" class="control-label">දුරකථන අංකය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
		                    							<input class="form-control" id="txt_contact" name="txt_contact" placeholder="---දුරකථන අංකය---" type="text" value="<?php echo $contact; ?>" />
		                    							<span class="text-danger"><?php echo form_error('txt_contact'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="txt_email" class="control-label">විද්‍යුත් තැපෑල</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
		                    							<input class="form-control" id="txt_email" name="txt_email" placeholder="---විද්‍යුත් තැපෑල් ලිපිනය---" type="text" value="<?php echo $email; ?>" />
		                    							<span class="text-danger"><?php echo form_error('txt_email'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="txt_webaddress" class="control-label">වෙබ් ලිපිනය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
		                    							<input class="form-control" id="txt_webaddress" name="txt_webaddress" placeholder="---වෙබ් ලිපිනය---" type="text" value="<?php echo $webaddress; ?>" />
		                    							<span class="text-danger"><?php echo form_error('txt_webaddress'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="txt_edudiv" class="control-label">අධ්‍යාපන කොට්ඨාසය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
                          								<select class="form-control" id="select_edu_div" name="select_edu_div" title="Please select" data-toggle="tooltip">
							                                <option value="<?php echo $edu_div_id; ?>" selected><?php echo $edu_div_name; ?></option>
		                    								<?php 
		                    								if(!empty($this->all_edu_div)){
		                    									foreach ($this->all_edu_div as $row){ ?><!-- from PhysicalResource controller constructor method -->
		                    										<option value="<?php echo $row->edu_div_id; ?>"><?php echo $row->div_name; ?></option>
		                    									<?php } 
		                    								}else{ ?>
		                    									<option value="" selected>No records found!!!</option>
		                    								<?php } ?>                                
		                    							</select>
		                    							<span class="text-danger"><?php echo form_error('select_edu_div'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="txt_gsdivision" class="control-label">ග්‍රාම නිළධාරී කොට්ඨාසය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
														<select class="form-control" id="select_gs_div" name="select_gs_div" title="Please select" data-toggle="tooltip">
								                            <option value="<?php echo $gs_div_id; ?>" selected><?php echo $gs_div_name; ?></option>
								                            <?php 
								                              if(!empty($this->all_gs_div)){
								                                foreach ($this->all_gs_div as $row){ ?><!-- from PhysicalResource controller constructor method -->
								                                <option value="<?php echo $row->gs_div_id; ?>"><?php echo $row->gs_div_name; ?></option>
								                            <?php } }else{ ?>
								                                <option value="" selected>No records found!!!</option>
								                            <?php } ?>     
							                          </select>                          
							                          <span class="text-danger"><?php echo form_error('select_gs_div'); ?></span>             
							                      	</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="txt_edudiv" class="control-label">කුමන පාසලක්ද?</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
                          								<select class="form-control" id="select_belongs_to" name="select_belongs_to" title="Please select" data-toggle="tooltip">
							                                <option value="<?php echo $sch_belongs_to_id; ?>" selected><?php echo $sch_belongs_to_name; ?></option>
		                    								<option value="1">පළාත් පාසලකි</option>
		                    								<option value="2">ජාතික පාසලකි</option>
		                    							</select>
		                    							<span class="text-danger"><?php echo form_error('select_belongs_to'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3"></div>
		                    						<div class="col-lg-9 col-sm-9 ">
		                    						<?php 
		                    						?>
		                    							<input type="hidden" name="user_id_hidden" value="<?php echo $user_id; ?>" />
		                    							<input type="hidden" name="date_added_hidden" value="<?php echo $date_added; ?>" />
		                    							<input type="hidden" name="is_deleted_hidden" value="<?php echo $is_deleted; ?>" />
		                    							<input id="btn_update_school" name="btn_update_school" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
		                    							<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-warning mt-2 mr-2" value="Cancel" style="margin-top: 10px;" />
														<a href="<?php echo base_url(); ?>ExcelExport/printSchoolById/<?php echo $census_id; ?>" type="button" class="btn btn-success mt-2" name="btn_print" id="btn_print" >Print</a>	                    							
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    			</fieldset>
		                    			</div> <!-- / #school_info -->
		                    			<?php echo form_close(); ?>
		                    		</div> <!-- /col-sm-12 -->	
	                    		</div> <!-- /row -->
	                		</div> <!-- /card body -->
	                		<div class="card-footer small text-muted">
				              <?php  
				                // view database updated date and time
		                    	$last_update_dt = strtotime($date_updated);
                				$phy_res_details_last_updated_on_date = date("j F Y",$last_update_dt);
                				$phy_res_details_last_updated_on_time = date("h:i A",$last_update_dt);
				                echo 'Updated on '.$phy_res_details_last_updated_on_date.' at '.$phy_res_details_last_updated_on_time;
				              ?>
				            </div>  
	              		</div> <!-- /card -->
	            	</div> <!-- /col-lg-12 col-sm-12 -->
	            </div>
	        	<?php } ?>
	      	</div>
	  	</div>
	</div> <!-- /container-fluid -->
