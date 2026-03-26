<?php
	defined('BASEPATH') OR exit('No direct script access allowed'); 
	// this page used to update the item status details
?>
<style type="text/css">
	.responsive {
	 	max-width: 100%;
	  	height: auto;
	}
</style>
<div class="content-wrapper">
 	<div class="container-fluid">
      	<!-- Breadcrumbs-->
    	<ol class="breadcrumb">
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Dashboard</a></li>
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>YearPlan">Year Plan</a></li>
        	<li class="breadcrumb-item active">Event Update</a></li>
      	</ol>
    <?php
        	if(!empty($this->session->flashdata('msg'))) {
          		$message = $this->session->flashdata('msg');  ?>
          		<div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
    <?php 	} ?>  
	        <?php
				if(empty($event)) {   ?>
                	<div class="alert alert-danger" style="">
                        <?php echo 'No Event Found!!!'; ?>
                    </div>
          <?php }else{ ?>
 		<?php 		foreach($event as $event){  
			 			$event_id = $event->id;
			 			$title = $event->title;
			 			$text = $event->description;
			 			$start = $event->start_event;
			 			$end = $event->end_event;
			 			$date_added = $event->date_added;
			 			$date_updated = $event->date_updated;
			 			$delete = $event->is_deleted;
 					}
 		?>
		<div class="row" id="main row">
	        <div class="col-lg-7">
	         	<div class="row">
		            <div class="col-lg-12 col-sm-12">
		              <div class="card mb-3">
		                <div class="card-header">
		                  <i class="fa fa-building"></i> Event යාවත්කාලීන කිරීම
		                </div>
		                	<div class="card-body">
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
	                      <?php $attributes = array("class" => "form-horizontal", "id" => "update-event-details", "name" => "update-event-details");
	                        	echo form_open("YearPlan/updateEvent", $attributes);	?>
			                    		<fieldset>
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="census id">මාතෘකාව</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<textarea class="form-control" id="title_txtarea" name="title_txtarea" rows="2"><?php echo $title; ?></textarea>
                         								<span class="text-danger"><?php echo form_error('title_txtarea'); ?></span>
			                    						<input type="hidden" name="event_id_hidden" value="<?php echo $event_id; ?>" />
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
											<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="item name">විස්තරය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<textarea class="form-control" id="text_txtarea" name="text_txtarea" rows="5"><?php echo $text; ?></textarea>
                         								<span class="text-danger"><?php echo form_error('text_txtarea'); ?></span>
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date added">ආරම්භක දිනය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
                          								<input type="text" name="start_event_txt" class="form-control datepicker" value="<?php echo $start; ?>">
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="date updated">අවසන් දිනය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
                          								<input type="text" name="end_event_txt" class="form-control datepicker" value="<?php echo $end; ?>">
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3"></div>
			                    					<div class="col-lg-9 col-sm-9 ">
			                    						<input id="btn_edit_event" name="btn_edit_event" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    						<a href="<?php echo base_url(); ?>YearPlan" id="btn_back" name="btn_back" type="button" class="btn btn-success mt-2" value="Back" style="margin-top: 10px;" >Back</a>
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
	            </div> <!-- /row -->
	      	</div> <!-- /col-lg-7 col-sm-7 -->
	      	
	  	</div> <!-- /main row -->
	        	<?php } ?>
	</div> <!-- /container-fluid -->
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {  
    // date picker
    $('.datepicker').datepicker({
      dateFormat: 'yy-mm-dd',
      changeYear: true,
      yearRange:'1955:'
    })
  });
</script>