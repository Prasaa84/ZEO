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
    					<img width="1169" height="487" src="<?php echo base_url(); ?>assets/images/staff/general_control_staff.png" class="img-responsive" alt="">
    				   </div>
    				   <div class="item">
    					<img width="1169" height="487" src="<?php echo base_url(); ?>assets/images/staff/general_control_staff.png" class="img-responsive" alt="">
    				   </div>
    				   <div class="item">
    					<img width="1169" height="487" src="<?php echo base_url(); ?>assets/images/staff/general_control_staff.png" class="img-responsive" alt="">
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
                <h2>සාමාන‍්‍ය පාලන අංශයේ කාර්ය භාරය</h2>
                <p class="lead"> </p>
            </div>
            <div class="row">
                <div class="features">
                	‍<div class="row">
                        <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionLeaveDetails"><i class="fa fa-home"></i></a>
                                <h2>නිවාඩු අනුමත කිරීම</h2>
                                <h3>ප්‍රසූත නිවාඩු, පීතෘත්ව නිවාඩු හා හදිසි අනතුරු නිවාඩු අනුමත කිරීම </h3>
                            </div>
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionServiceRelated"><i class="fa fa-home"></i></a>
                                <h2>සේවය පිළිබඳ...</h2>
                                <h3>පරිවාස කාලයෙන් පසු සේවය ස්ථීර කිරීම, සේවය දීර්‍ග කිරීම, වි‍ශ්‍රාම ගැන්වීම හා ඉල්ලා අස්වීම</h3>
                            </div>
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionPersonalFile"><i class="fa fa-home"></i></a>
                                <h2>පෞද්ගලික ලිපි ගොනුව </h2>
                                <h3>පෞද්ගලික ලිපි ගොනුව ආරම්‍‍භ කිරීම හා W & OP අංකය ලබා ගැනීම</h3>
                            </div>
                        </div><!--/.col-md-4-->
                    </div><!--/.row -->
                	‍<div class="row">
                        <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionManagementAssistanceService"><i class="fa fa-file"></i></a>
                                <h2>ක‍ළමණාකරන සහකාර සේවය</h2>
                                <h3>ක‍ළමණාකරන සහකාර සේවා ව්‍යවස්ථාව</h3>
                            </div>    
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionDevelopmentOfficerService"><i class="fa fa-file"></i></a>
                                <h2>සංවර්ධන නිලධාරි සේවය</h2>
                                <h3>අන්තර්ග්‍රහ‍ණය හා උසස් කිරීම</h3>
                            </div>
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-6 col-sm-6 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionNonAcademicService"><i class="fa fa-file"></i></a>
                                <h2>අනධ්‍යයන ක‍ණිෂ්ඨ සේවය</h2>
                                <h3>ක‍ළමණාකරන සහකාර සේවා ව්‍යවස්ථාව</h3>
                            </div>
                        </div>
                    </div><!--/.row -->
                </div><!--/.features-->
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#feature-->