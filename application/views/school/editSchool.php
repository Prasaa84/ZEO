<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-wrapper">
 	<div class="container-fluid">
      	<!-- Breadcrumbs-->
    	<ol class="breadcrumb">
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Dashboard</a></li>
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

					$pro_id = $school->pro_id;
		      		$pro_name = $school->pro_name; // province
		      		$dis_id = $school->dis_id;
		      		$dis_name = $school->dis_name;  // district
		      		$zone_id = $school->zone_id;
		      		$zone_name = $school->zone_name; // zone
		      		$edu_div_id = $school->div_id;	
		      		$edu_div_name = $school->div_name;	// adhayapana kottashaya
		      		$div_sec_id = $school->div_sec_id; 
		      		$div_sec_name = $school->div_sec_name_si; // sinhala name - divisional secretary
		      		$gs_div_id = $school->gs_div_id;
		      		$gs_div_name = $school->gs_name_si; // sinhala name - grama niladhari kottashaya

		      		$sch_type_id = $school->sch_type_id;
		      		$sch_belongs_to_id = $school->belongs_to_id;
		      		$sch_belongs_to_name = $school->belongs_to_name;   
		      		$grd_span_id = $school->grd_span_id;
		      		$grd_span = $school->grd_span;    		
		      		$sch_type_name = $school->sch_type;     		
		      		$user_id = $school->user_id;
		      		$date_added = $school->school_details_add_dt;	
		      		$date_updated = $school->school_details_upd_dt;
		      		$is_deleted = $school->is_deleted;
      			} ?>
		<div class="row" id="main row">
	        <div class="col-lg-9">
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
		                    							<label for="select_province" class="control-label">පලාත</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
                          								<select class="form-control" id="select_province" name="select_province" title="Please select" data-toggle="tooltip">
							                                <option value="<?php echo $pro_id; ?>" selected><?php echo $pro_name; ?></option>
		                    								<?php 
		                    								//if(!empty($this->all_edu_div)){
		                    									foreach ($all_provinces as $row){ ?><!-- from PhysicalResource controller constructor method -->
		                    										<option value="<?php echo $row->pro_id; ?>"><?php echo $row->pro_name; ?></option>
		                    									<?php } 
		                    								//}else{ ?>
		                    									<!--<option value="" >No records found!!!</option> -->
		                    								<?php //} ?>                                
		                    							</select>
		                    							<span class="text-danger"><?php echo form_error('select_province'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="select_district" class="control-label">දිස්ත්‍රික්කය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
                          								<select class="form-control" id="select_district" name="select_district" title="Please select" data-toggle="tooltip">					
							                                <option value="<?php echo $dis_id; ?>" selected><?php echo $dis_name; ?></option>
							                            </select>
		                    							<span class="text-danger"><?php echo form_error('select_district'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="select_zone" class="control-label">අධ්‍යාපන කලාපය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
                          								<select class="form-control" id="select_zone" name="select_zone" title="Please select" data-toggle="tooltip">                         	
							                                <option value="<?php echo $zone_id; ?>" selected><?php echo $zone_name; ?></option>
		                    							</select>
		                    							<span class="text-danger"><?php echo form_error('select_zone'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="select_edu_div" class="control-label">අධ්‍යාපන කොට්ඨාසය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
                          								<select class="form-control" id="select_edu_div" name="select_edu_div" title="Please select" data-toggle="tooltip">		
							                                <option value="<?php echo $edu_div_id; ?>" selected><?php echo $edu_div_name; ?></option>
														</select>
		                    							<span class="text-danger"><?php echo form_error('select_edu_div'); ?></span>
		                    						</div>
		                    					</div>
		                    				</div> <!-- /form group -->
		                    				<div class="form-group">
		                    					<div class="row">
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="select_div_sec" class="control-label">ප්‍රාදේශීය ලේකම් කොට්ඨාසය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
                          								<select class="form-control" id="select_div_sec" name="select_div_sec" title="Please select" data-toggle="tooltip">		
							                                <option value="<?php echo $div_sec_id; ?>" selected><?php echo $div_sec_name; ?></option>
														</select>
		                    							<span class="text-danger"><?php echo form_error('select_div_sec'); ?></span>
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
		                    						<div class="col-lg-3 col-sm-3">
		                    							<label for="txt_edudiv" class="control-label">පන්ති පරාසය</label>
		                    						</div>
		                    						<div class="col-lg-9 col-sm-9">
                          								<select class="form-control" id="select_grade_span" name="select_grade_span" title="Please select" data-toggle="tooltip">
							                                <option value="<?php echo $grd_span_id; ?>" selected><?php echo $grd_span; ?></option>
		                    								<?php 
								                              if(!empty($this->all_grade_span)){
								                                foreach ($this->all_grade_span as $row){ ?><!-- from PhysicalResource controller constructor method -->
								                                <option value="<?php echo $row->grd_span_id; ?>"><?php echo $row->grd_span; ?></option>
								                            <?php } }else{ ?>
								                                <option value="" selected>No records found!!!</option>
								                            <?php } ?>  
		                    							</select>
		                    							<span class="text-danger"><?php echo form_error('select_grade_span'); ?></span>
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
<script type="text/javascript">
	// used to load districts when a province is selected
    $(document).on('change', '#select_province', function(){  
      var pro_id = $(this).val();
     
      if(!pro_id){
        swal('Please select a province');
      }else{
        $.ajax({  
            url:"<?php echo base_url(); ?>School/viewDistricts",  
            method:"POST",  
            data:{pro_id:pro_id},  
            dataType:"json",  
            success:function(districts)  
            {  
				if(!districts){
					swal('Districts not found!!!!')
					$('select#select_district').html('');
					$('select[name="select_district"]').append('<option value="">---Not found---</option>').attr("selected", "true");   
				}else{
					$('select#select_district').html('');
					$('select#select_zone').html('');
					$('select#select_edu_div').html('');
					$('select#select_div_sec').html('');
					$('select#select_gs_div').html('');
	                $('select[name="select_district"]').append('<option value="">---Select---</option>').attr("selected", "true");   
	                $.each(districts, function(key,value) {
	                    $('select[name="select_district"]').append('<option value="'+ value.dis_id +'">'+ value.dis_name +'</option>');
	                });
              	}  
            }, 
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            } 
        }) 
      }
    });
    // used to load zones when a district is selected
    $(document).on('change', '#select_district', function(){  
      var dis_id = $(this).val();
     
      if(!dis_id){
        swal('Please select a district');
      }else{
        $.ajax({  
            url:"<?php echo base_url(); ?>School/viewZones",  
            method:"POST",  
            data:{dis_id:dis_id},  
            dataType:"json",  
            success:function(zones)  
            {  
				if(!zones){
					swal('Zones not found!!!!')
					$('select#select_zone').html('');
					$('select[name="select_zone"]').append('<option value="">---Not found---</option>').attr("selected", "true");   
				}else{
					$('select#select_zone').html('');
					$('select#select_edu_div').html('');
	                $('select[name="select_zone"]').append('<option value="">---Select---</option>').attr("selected", "true");   
	                $.each(zones, function(key,value) {
	                    $('select[name="select_zone"]').append('<option value="'+ value.zone_id +'">'+ value.zone_name +'</option>');
	                });
              	}  
            }, 
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            } 
        }) 
      }
    });
    // used to load edu. divisions when a zone is selected
    $(document).on('change', '#select_zone', function(){  
      var zone_id = $(this).val();
     
      if(!zone_id){
        swal('Please select a Zone');
      }else{
        $.ajax({  
            url:"<?php echo base_url(); ?>School/viewDivisions",  
            method:"POST",  
            data:{zone_id:zone_id},  
            dataType:"json",  
            success:function(divisions)  
            {  
				if(!divisions){
					swal('Divisions not found!!!!')
					$('select#select_edu_div').html('');
					$('select[name="select_edu_div"]').append('<option value="">---Not found---</option>').attr("selected", "true");   
				}else{
					$('select#select_edu_div').html('');
	                $('select[name="select_edu_div"]').append('<option value="">---Select---</option>').attr("selected", "true");   
	                $.each(divisions, function(key,value) {
	                    $('select[name="select_edu_div"]').append('<option value="'+ value.div_id +'">'+ value.div_name +'</option>');
	                });
              	}  
            }, 
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            } 
        }) 
      }
    });
    // used to load divisional secretariat when a district is selected
    $(document).on('change', '#select_district', function(){  
      var dis_id = $(this).val();
     
      if(!dis_id){
        swal('Please select a Zone');
      }else{
        $.ajax({  
            url:"<?php echo base_url(); ?>School/viewDivSecretariat",  
            method:"POST",  
            data:{dis_id:dis_id},  
            dataType:"json",  
            success:function(divSec)  
            {  
				if(!divSec){
					swal('Divisionsal secretariat not found!!!!')
					$('select#select_div_sec').html('');
					$('select[name="select_div_sec"]').append('<option value="">---Not found---</option>').attr("selected", "true");   
				}else{
					$('select#select_div_sec').html('');
	                $('select[name="select_div_sec"]').append('<option value="">---Select---</option>').attr("selected", "true");   
	                $.each(divSec, function(key,value) {
	                    $('select[name="select_div_sec"]').append('<option value="'+ value.div_sec_id +'">'+ value.div_sec_name_si +'</option>');
	                });
              	}  
            }, 
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            } 
        }) 
      }
    });
    // used to load gs divisions when a divisional secretariat is selected
    $(document).on('change', '#select_div_sec', function(){  
      var div_sec_id = $(this).val();

      var dis_id = $('#select_district').val();
      if(!div_sec_id){
        swal('Please select the divisional secretariat');
      }else if(!dis_id){
        swal('Select the district to view grama niladhari divisions');
      }else{
        $.ajax({  
            url:"<?php echo base_url(); ?>School/viewGsDivisions",  
            method:"POST",  
            data:{dis_id:dis_id,div_sec_id:div_sec_id},  
            dataType:"json",  
            success:function(divSec)  
            {  
				if(!divSec){
					swal('Grama Niladhari Divisions not found!!!!')
					$('select#select_gs_div').html('');
					$('select[name="select_gs_div"]').append('<option value="">---Not found---</option>').attr("selected", "true");   
				}else{
					$('select#select_gs_div').html('');
	                $('select[name="select_gs_div"]').append('<option value="">---Select---</option>').attr("selected", "true");   
	                $.each(divSec, function(key,value) {
	                    $('select[name="select_gs_div"]').append('<option value="'+ value.gs_div_id +'">'+ value.gs_name_si +'</option>');
	                });
              	}  
            }, 
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            } 
        }) 
      }
    });
</script>