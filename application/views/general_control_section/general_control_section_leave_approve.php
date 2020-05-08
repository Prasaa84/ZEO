    <section id="feature" >
        <div class="container">
            <div class="breadcrumb">
                <?php 
                    //echo $path = $_SERVER["PHP_SELF"]; // /zonal_ci/index.php
                    //$path = $_SERVER["HTTP_REFERER"];
                    $path = $_SERVER["PHP_SELF"];
                    $parts = explode('/',$path);
                    echo count($parts);
                    if (count($parts) <= 5){
                        echo("home");
                    }else{
                        echo ("<a href= ".base_url()." >home</a> &raquo; ");
                        for ($i = 4; $i < count($parts); $i++){
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
                            }
                        }
                    }  
                ?>
            </div>
            <div class="center wow fadeInDown">
                <h2>නිවාඩු අනුමත කිරීම</h2>
            </div>
            <div class="row">
                <div class="leave_approve">
                	‍<div class="row">
                        <div class="col-md-4 col-sm-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionMaternityLeavesWithFullPay"><i class="fa fa-home"></i></a>
                                <h2>වැටුප් සහිත ප්‍රසූත නිවාඩු</h2>
                                <p></p>
                                <h3>වැටුප් සහිත ප්‍රසූත නිවාඩු අනුමත කිරීම හා අජීවි දරු උපතකදී...</h3>
                            </div>
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionMaternityLeavesWithHalfPay"><i class="fa fa-home"></i></a>
                                <h2>අඩ වැටුප් සහිත ප්‍රසූත නිවාඩු</h2>
                                <h3>ප‍ළමු දින 84 සඳහා ප්‍රසූත නිවාඩු අනුමත වී තිබිය යුතු අතර...</h3>
                            </div>
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionMaternityLeavesWithNoPay">
                                <i class="fa fa-home"></i></a>
                                <h2>වැටුප් රහිත ප්‍රසූත නිවාඩු</h2>
                                <h3>ප‍ළමු දින 84 සහ අඩ වැටුප් දින 84 සඳහා ප්‍රසූත නිවාඩු අනුමත වී...</h3>
                            </div>
                        </div><!--/.col-md-4-->
                    </div><!--/.row -->
                	‍<div class="row">
                        <div class="col-md-4 col-sm-4 wow fadeInDown right" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap right">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionPaternalLeave">
                                <i class="fa fa-home"></i></a>
                                <h2>පීතෘත්ව නිවාඩු </h2>
                                <h3>අනුමත කිරීම සඳහා අව‍‍හ‍ය ලිය කියවිලි...</h3>
                            </div>
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-4 wow fadeInDown left" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionAccidentLeave">
                                <i class="fa fa-bed"></i></a>
                                <h2>හදිසි අනතුරු නිවාඩු</h2>
                                <h3>හදිසි අනතුරු නිවාඩු අනුමත කිරීම සහ හදිසි අනතුරු වන්දි ගෙවීම</h3>
                            </div>
                        </div><!--/.col-md-4-->
                        <div class="col-md-4 col-sm-4 wow fadeInDown right" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <div class="feature-wrap">
                                <a href="<?php echo base_url(); ?>GeneralControl/generalControlSectionAbroadLeave">
                                <i class="fa fa-plane"></i></a>
                                <h2>විදේශ නිවාඩු </h2>
                                <h3>විදේශ නිවාඩු අනුමත කිරීමට අව‍‍‍ශ්‍ය ලිය කියවිලි</h3>
                            </div>
                        </div>
                    </div><!--/.row -->
                </div><!--/.leave approve-->
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#feature-->