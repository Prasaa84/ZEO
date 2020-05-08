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
        	<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>news">News</a></li>
        	<li class="breadcrumb-item active">News Update</a></li>
      	</ol>
    <?php
        	if(!empty($this->session->flashdata('msg'))) {
          		$message = $this->session->flashdata('msg');  ?>
          		<div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
    <?php 	} ?>  
	        <?php
				if(empty($news)) {   ?>
                	<div class="alert alert-danger" style="">
                        <?php echo 'No records!!!'; ?>
                    </div>
          <?php }else{ ?>
 		<?php 		foreach($news as $news){  
			 			$news_id = $news->news_id;
			 			$title = $news->news_title;
			 			$text = $news->news_text;
			 			$by_whom = $news->by_whom;
			 			$date_added = $news->date_added;
			 			$date_updated = $news->date_updated;
			 			$delete = $news->is_deleted;
 					}
 		?>
		<div class="row" id="main row">
	        <div class="col-lg-7">
	         	<div class="row">
		            <div class="col-lg-12 col-sm-12">
		              <div class="card mb-3">
		                <div class="card-header">
		                  <i class="fa fa-building"></i> පුවත් යාවත්කාලීන කිරීම
		                </div>
		                	<div class="card-body">
		                  		<div class="row">
		                    		<div class="col-sm-12 my-auto">
	                      <?php $attributes = array("class" => "form-horizontal", "id" => "update-news-details", "name" => "update-news-details");
	                        	echo form_open("News/updateNews", $attributes);	?>
			                    		<fieldset>
			                    			<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="census id">සිරස්තලය</label>
			                    					</div>
			                    					<div class="col-lg-9 col-sm-9">
														<textarea class="form-control" id="title_txtarea" name="title_txtarea" rows="2"><?php echo $title; ?></textarea>
                         								<span class="text-danger"><?php echo form_error('title_txtarea'); ?></span>
			                    						<input type="hidden" name="news_id_hidden" value="<?php echo $news_id; ?>" />
			                    					</div>
			                    				</div> <!-- /row -->
			                    			</div> <!-- /form group -->
											<div class="form-group">
			                    				<div class="row">
			                    					<div class="col-lg-3 col-sm-3">
			                    						<label for="item name">පුවත් විස්තරය</label>
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
			                    						<input id="btn_edit_news" name="btn_edit_news" type="submit" class="btn btn-primary mr-2 mt-2" value="Update" />
			                    						<a href="<?php echo base_url(); ?>News" id="btn_back" name="btn_back" type="button" class="btn btn-success mt-2" value="Back" style="margin-top: 10px;" >Back</a>
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
	      	<div class="col-lg-5">
	         	<div class="row">
		            <div class="col-lg-12 col-sm-12">
		              	<div class="card mb-3">
		                	<div class="card-header">
		                  		<i class="fa fa-building"></i> Featured Image
		                	</div>
		                	<div class="card-body">
		                		<div class="row">
		                    		<div class="col-sm-12">
								  <?php
								    if(!empty($this->session->flashdata('imgUploadSuccess'))) {
								      $message = $this->session->flashdata('imgUploadSuccess');  ?>
								      <div class="alert alert-success" ><?php echo $message; ?></div>
								  <?php } ?> 
								  <?php
								    if(!empty($this->session->flashdata('imgUploadError'))) {
								      $message = $this->session->flashdata('imgUploadError');  
								        foreach ($message as $item => $value){
								          echo '<div class="alert alert-danger" >'.$item.' : '.$value.'</div>';
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
			                    		<div>
				                    		<center>
	                					<?php 	if(file_exists("./assets/images/news/$news_id.jpg")){ ?>
	                								<img src="<?php echo base_url(); ?>assets/images/news/<?php echo $news_id; ?>.jpg" style="" width="" class="responsive">
	                					<?php 	}else{ echo 'Featured image has not been set'; } ?>

				                    		</center>
			                    		</div>
			                    		<div style="margin-top: 10px;">
			                    	<?php 	$attributes = array("class" => "form-horizontal", "id" => "insert_staff_info_form", "name" => "insert_staff_info_form", "accept-charset" => "UTF-8" );
                  							echo form_open_multipart("News/addFeaturedImage", $attributes);?>
                  							<fieldset>
			                    				<div class="form-group">
		                  							<input type="file" name="featured_image" size="20" id="featured_image" title="Change Image" />
		                  							<img id="imgPrw" src="#" alt="" class="imgPrw" />
				                      				<input type="hidden" name="news_id_hidden" value="<?php echo $news_id; ?>" />
		              								<button class="btn btn-primary" type="submit" name="btn_upload_featured_img" value="upload_image" style="margin:5 0 5 0; "> Upload Image</button>
              									</div>
              								</fieldset>
			                    		<?php echo form_close(); ?>
              							</div>
			            			</div> <!-- /col-sm-12 -->
		                    	</div> <!-- /row -->
	                		</div> <!-- /card body -->
	              		</div> <!-- /card -->
	              	</div> <!-- /col-lg-12 col-sm-12 -->
	            </div> <!-- /row -->
	      	</div> <!-- /col-lg-5 col-sm-5 -->
	  	</div> <!-- /main row -->
	        	<?php } ?>
	</div> <!-- /container-fluid -->
