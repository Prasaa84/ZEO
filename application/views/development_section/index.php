    <section id="‍institution-section">
        <div class="container">
            <div class="breadcrumb">
                <?php 
                    //echo $path = $_SERVER["PHP_SELF"]; /zonal_ci/index.php
                    $path = $_SERVER["PHP_SELF"];
                    $parts = explode('/',$path);
                    if (count($parts) < 2){
                        echo("home");
                    }else{
                        echo ("<a href= ".base_url()." >home</a> &raquo; ");
                        for ($i = 1; $i < count($parts); $i++){
                            if (!strstr($parts[$i],".")){
                                echo("<a href=\"");
                                for ($j = 0; $j <= $i; $j++){
                                    echo $parts[$j]."/";
                                };
                                echo("\">". str_replace('-', ' ', $parts[$i])."</a> » ");
                            }else{
                                $str = $parts[$i];
                                $pos = strrpos($str,".");
                                $parts[$i] = substr($str, 0, $pos);
                                echo str_replace('-', ' ', $parts[$i]);
                            };
                        };
                    };  
                ?>
            </div>
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
    					<img width="1169" height="487" src="<?php echo base_url(); ?>assets/images/staff/development_section_slide.png" class="img-responsive" alt="">
    				   </div>
    				   <div class="item">
    					<img width="1169" height="487" src="<?php echo base_url(); ?>assets/images/staff/development_section_slide.png" class="img-responsive" alt="">
    				   </div>
    				   <div class="item">
    					<img width="1169" height="487" src="<?php echo base_url(); ?>assets/images/staff/development_section_slide.png" class="img-responsive" alt="">
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
    <section id="feature" >
        <div class="container">
           <div class="center wow fadeInDown">
                <h2>සංවර්ධන අංශයේ කාර්ය භාරය</h2>
                <p class="lead"> </p>
            </div>
            <div class="row">
                <div class="features">
                	‍<div class="row">
                        <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>DevelopmentSection/approveEducationalTrips"><i class="fa fa-child"></i></a>
                                <h2>අධ්‍යාපන චාරිකා...</h2>
                                <h3>ඔබගේ පාසලේ අනුමත කරන ලද අධ්‍යාපන චාරික පිළිබඳ....</h3>
                            </div>
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>DevelopmentSection/public_results_page"><i class="fa fa-area-chart"></i></a>
                                <h2>ප්‍රතිඵල විශ්ලේෂණය </h2>
                                <h3>පසුගිය සා/පෙළ, උ/පෙළ හා 5 වසර ශිෂ්‍යත්ව විභාග ප්‍රතිඵල...</h3>
                            </div>
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>DevelopmentSection/grade5Scholarship"><i class="fa fa-money"></i></a>
                                <h2>ශිෂ්‍යාධාර ලබා ගැනීම</h2>
                                <h3>5 ශ්‍රේණියේ ශිෂ්‍යත්ව විභාගය සඳහා.....</h3>
                            </div>
                        </div>
                    </div><!--/.row -->
                	‍<div class="row">
                        <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>DevelopmentSection/schoolLeaveCertificate"><i class="fa fa-certificate"></i></a>
                                <h2>ශිෂ්‍ය කාර්ය දර්ශණය</h2>
                                <h3>ශිෂ්‍ය කාර්ය දර්ශණය ලබා ගැනීම සඳහා අවශ්‍යතා....</h3>
                            </div>    
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>DevelopmentSection/hallPlaygroundBooking"><i class="fa fa-building"></i></a>
                                <h2>ශාලා හා ක්‍රීඩා පිටි සඳහා අවසර ලබා ගැනීම</h2>
                                <h3>මේ සඳහා අවශ්‍ය ලියකියවිලි</h3>
                            </div>
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>DevelopmentSection/courses"><i class="fa fa-graduation-cap"></i></a>
                                <h2>පාඨමාලා</h2>
                                <h3>ගුරු මධ්‍යස්ථාන පාඨමාලා, නොවිධිමත් පාඨමාලා හා CRC.....</h3>
                            </div>
                        </div>
                    </div><!--/.row -->
                </div><!--/.features-->
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#feature-->