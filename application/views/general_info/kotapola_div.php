    <section id="about-us">
        <div class="container">
	<!-- morawaka slider -->
	<div id="about-slider">
		<div id="carousel-slider" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
		  	<ol class="carousel-indicators visible-xs">
			    <li data-target="#carousel-slider" data-slide-to="0" class="active"></li>
			    <li data-target="#carousel-slider" data-slide-to="1"></li>
			    <li data-target="#carousel-slider" data-slide-to="2"></li>
		  	</ol>
			<div class="carousel-inner">
			   <div class="item active">
				<img src="<?php echo base_url(); ?>assets/images/divisions/kotapola_division_slider.png" class="img-responsive" alt="">
			   </div>
			   <div class="item">
				<img src="<?php echo base_url(); ?>assets/images/divisions/kotapola_division_slider.png" class="img-responsive" alt="">
			   </div>
			   <div class="item">
				<img src="<?php echo base_url(); ?>assets/images/divisions/kotapola_division_slider.png" class="img-responsive" alt="">
			   </div>
			</div>

			<a class="left carousel-control hidden-xs" href="#carousel-slider" data-slide="prev">
				<i class="fa fa-angle-left"></i>
			</a>

			<a class=" right carousel-control hidden-xs"href="#carousel-slider" data-slide="next">
				<i class="fa fa-angle-right"></i>
			</a>
		</div> <!--/#carousel-slider-->
	</div><!--/#about-slider-->
       </div><!--/#container-->
    </section><!--/about-us-->
        <section id="schools_div">
    	<div class="container">
	    	<div class="wow fadeInDown" style="">
		    	<h2 class="h2 center">Schools in Kotapola division </h2>
		    	<table class="table table-responsive table-hover">
		    		<tr><th></th><th>Census ID</th><th>Exam No</th><th>Name</th><th>Address</th><th>Tel:</th><th>Email</th><th>Division</th></tr>
		   <?php    	
		   				$x=1;
		   				foreach($schools as $school){  ?>
                            <tr>
                            	<th><?php echo $x; ?></th>
                                <td width="100"><?php echo $school->census_id; ?></td>
                                <td><?php echo $school->exam_no; ?></td>
                                <td><?php echo $school->sch_name; ?></td>
                                <td><?php echo $school->address1.', '.$school->address2; ?></td>
                                <td><?php echo $school->contact_no; ?></td>
                                <td width=""><?php echo $school->email; ?></td>
                                <td width=""><?php echo $school->div_name; ?></td>
                            </tr>
            <?php 		$x++; 
        				} 		?>
		    	</table>
		</div>
    	</div>
    </section>