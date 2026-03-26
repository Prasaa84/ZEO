    <style type="text/css">
        #calendar .fc-today{
            background-color: #e6e6e6;
        }
        #calendar .fc-event{
            box-shadow: 2px 2px 2px #706868;
        }
        #calendar .fc-agenda-axis, #calendar .fc-widget-header{
            background-color: #f59d3f;
            border-color: #AED0EA;
            font-weight: normal;
            padding: 3px;
            border-radius: 3px;
        }
        #calendar {
            width:400px; height: 300px;
        }
        #news_thumbnail_div{
            width: 100px;
            height: auto;
            float: left;
        }
        .news_thumbnail {
            max-width: 100px;
            height: auto;
            border: 5px solid #fafafa;
        }
        #news_description_div{
            width: auto;
            float: left;
            padding: 2px;
        }
        #news_title:hover{ text-decoration: underline;}
    </style>
    <section id="main-slider" class="no-margin" style="height:530px; width:auto;">
        <div class="carousel slide">
            <ol class="carousel-indicators">
                <li data-target="#main-slider" data-slide-to="0" class="active"></li>
                <li data-target="#main-slider" data-slide-to="1"></li>
                <li data-target="#main-slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" style="height: 530px;">
                <div class="item active" style="background-image: url(<?php echo base_url(); ?>assets/images/slider/b2.png); height:530px;">
                    <div class="container">
                        <div class="row slide-margin">
                            <div class="col-sm-6">
                                <div class="carousel-content">
                                    <h1 class="animation animated-item-1">අපගේ දැක්ම</h1>
                                    <h2 class="animation animated-item-2">පෙරගමන් කරුවන්ට පෙර ගමන් කරුවන් වීම...</h2>
                                    <a class="btn-slide animation animated-item-3" href="<?php echo base_url(); ?>GeneralInfo/aboutUs#vision">Read More</a>
                                </div>
                            </div>
                            <div class="col-sm-2">

                            </div>
                            <div class="col-sm-4 hidden-xs animation animated-item-4">
                                <div class="slider-img">
                                    <img src="<?php echo base_url(); ?>assets/images/slider/zonal_badge2.png" class="img-responsive">
                                </div>
                            </div>

                        </div>
                    </div>
                </div><!--/.item-->

                <div class="item" style="background-image: url(<?php echo base_url(); ?>assets/images/slider/b3.png); height:530px;">
                    <div class="container">
                        <div class="row slide-margin">
                            <div class="col-sm-6">
                                <div class="carousel-content">
                                    <h1 class="animation animated-item-1">අපගේ මෙහෙවර</h1>
                                    <h2 class="animation animated-item-2">ධරණීය සංවර්ධනයට උරදිය හැකි මනා පෙෘරුෂයකින් හෙබි ගුණ නුවණින් යුතු දරු කැලක්.....</h2>
                                    <a class="btn-slide animation animated-item-3" href="<?php echo base_url(); ?>GeneralInfo/aboutUs#mission">Read More</a>
                                </div>
                            </div>
                            <div class="col-sm-2">

                            </div>
                            <div class="col-sm-4 hidden-xs animation animated-item-4">
                                <div class="slider-img">
                                    <img src="<?php echo base_url(); ?>assets/images/slider/student1.png" class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->

                <div class="item" style="background-image: url(<?php echo base_url(); ?>assets/images/slider/b4.png); height:530px;">
                    <div class="container">
                        <div class="row slide-margin">
                            <div class="col-sm-6">
                                <div class="carousel-content">
                                    <h1 class="animation animated-item-1">අධ්‍යාපනය යනු........</h1>
                                    <h2 class="animation animated-item-2">අධ්‍යාපනය යනු යම්කිසි හැකියාවන් ගොන්නක් විධිමත් ලෙස ඉගැන්විම හා ඉගෙනගැනීමයි. තවත් විදර්ශනාත්මක කිවහොත්, අධ්‍යාපනය යනු දැනුම, සුභවාදී චින්තනය සහ ඥාණය ඛෙදාහදා ගැනීමයි...</h2>
                                    <a class="btn-slide animation animated-item-3" href="#">Read More</a>
                                </div>
                            </div>
                            <div class="col-sm-2">

                            </div>
                            <div class="col-sm-4 hidden-xs animation animated-item-4">
                                <div class="slider-img">
                                    <img src="<?php echo base_url(); ?>assets/images/slider/student2.png" class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="fa fa-chevron-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="fa fa-chevron-right"></i>
        </a>
    </section><!--/#main-slider-->

    <section id="feature" style="padding-bottom: 80px;" class="wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
        <div class="container">
            <div class="center wow fadeInDown" style="padding-bottom: 2px;">
                <h2>NEWS & EVENTS</h2>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="">
                        <h2 style="color:#505050;">ANNOUNCEMENTS - දැනුම් දීම්</h2> 
                <?php   if(empty($news)){ ?>
                            <div class="alert alert-danger"> No recent news found  </div>
                <?php   }else{
                            foreach ($news as $news) { $news_id = $news->news_id; ?>
                                <div class="news<?php echo $news_id?>" style="margin-bottom: 10px;">
                                    <div class="col-lg-2 col-sm-2">
                                    <a href="<?php echo base_url(); ?>News/viewNewsById/<?php echo $news_id; ?>">
                    <?php               if(file_exists("./assets/images/news/thumbnail/$news_id._thumb.jpg")){ ?>
                                            <img src="<?php echo base_url(); ?>assets/images/news/thumbnail<?php echo $news_id; ?>_thumb.jpg" style="" class="news_thumbnail" >
                    <?php               }else if(file_exists("./assets/images/news/$news_id.jpg")){ ?>
                                            <img src="<?php echo base_url(); ?>assets/images/news/<?php echo $news_id; ?>.jpg" style="" class="news_thumbnail" >
                    <?php               }else{  ?>
                                            <img src="<?php echo base_url(); ?>assets/images/news/recent_news_default_thumbnail.png" style="" class="news_thumbnail" >
                    <?php               }  ?> 
                                    </a>                       
                                    </div>
                                    <div class="col-lg-10 col-sm-10" style="">
                                        <h4 style="margin-top: 0px; color:#040f40;"><?php echo '<a href='.base_url().'News/viewNewsById/'.$news_id.' style="color:#f59d40" id="news_title">'.$news->news_title.'</a>'; ?></h4>         
                                        <?php $string = $news->news_text; ?>
                                        <?php
                                            $string = strip_tags($string);
                                            if (strlen($string) > 200) {

                                                // truncate string
                                                $stringCut = substr($string, 0, 200);
                                                $endPoint = strrpos($stringCut, ' ');

                                                //if the string doesn't contain any space then it will cut without word basis.
                                                $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                $string .= '...';
                                                //$string .= '... <a href=" '.base_url().'News/viewNewsById/'.$news_id.'">Read More</a>';
                                            }
                                            echo $string;
                                        ?>
                                        <br>
                    <?php               $added_dt_tm = strtotime($news->date_added);
                                        $added_dt = date("j F Y",$added_dt_tm);
                                        $added_tm = date("h:i A",$added_dt_tm);
                    ?>                  
                                        <small><?php echo $added_dt; ?></small>

                                    </div>  
                                    <div style="clear: both;"></div>                              
                                </div>
                <?php       }
                        }    ?>
                        <div id=""></div>         
                    </div> <!-- /card --> 
                </div><!--/.services-->
                <div class="col-lg-4">
                    <div class="card mb-3">
                        <h2 style="color:#505050;">EVENTS OF THE YEAR PLAN </h2> 
                        <!-- java script code for below calendar is included footer.php in templates folder -->
                        <div id="calendar"></div>         
                    </div> <!-- /card -->
                </div><!--/.services-->
            </div><!--/.row-->
        </div><!--/.container-->
    </section><!--/#feature-->
    <section id="partner" style="padding-top: 20px;">
        <div class="container">
            <div class="center wow fadeInDown">
                <h2>Quick Access</h2>
                <p class="lead">These links are helpful to find information related to educational system</p>
            </div>

            <div class="partners">
                <ul>
                    <li> <a href="http://www.edupub.gov.lk/"><img class="img-responsive wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms" src="<?php echo base_url(); ?>assets/images/quickAccess/ebp.png"></a></li>
                    <li> <a href="http://nie.lk/"><img class="img-responsive wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms" src="<?php echo base_url(); ?>assets/images/quickAccess/nie.png"></a></li>
                    <li> <a href="https://www.doenets.lk/"><img class="img-responsive wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="900ms" src="<?php echo base_url(); ?>assets/images/quickAccess/doe.png"></a></li>
                    <li> <a href="http://moe.gov.lk/"><img class="img-responsive wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="1200ms" src="<?php echo base_url(); ?>assets/images/quickAccess/moe.png"></a></li>
                    <li> <a href="https://www.schoolnet.lk/"><img class="img-responsive wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="1500ms" src="<?php echo base_url(); ?>assets/images/quickAccess/schoolnet.png"></a></li>
                </ul>
            </div>
        </div><!--/.container-->
    </section><!--/#partner-->
    