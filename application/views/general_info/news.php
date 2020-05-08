    <style type="text/css">
        #archive ul li a:hover{
            text-decoration: none;
            text-decoration: underline;
        }
        #archive ul li a{font-size: 13px; color:#7b8989;}
        #news{padding-right: 50px;}
        #news p{ color:#7b8989; text-align: justify; }
        #news h1{ color:#5492cf; }
        .responsive {
            max-width: 650px;
            height: auto;
            border: 7px solid #f6f6f6;
        }
    </style>
    <section id="portfolio">
        <div class="container">
            <div class="center" style="margin-bottom: 0; padding-bottom: 0;">
               <h2><?php echo $heading; ?></h2>
               <h3>Recent News </h3>
            </div>
            <div class="row wow fadeInDown">
                <div class="col-lg-9 col-sm-9" id="news">
                    <?php if(empty($news)){ ?>
                            <div class="alert alert-danger"> No recent news found  </div>
                    <?php }else{
                            foreach ($news as $news) { 
                                $news_id = $news->news_id;
                    ?>
                                <div class="">
                                    <h1><?php echo $news->news_title; ?></h1>
                            <?php   if(file_exists("./assets/images/news/$news_id.jpg")){ ?>
                                        <img src="<?php echo base_url(); ?>assets/images/news/<?php echo $news_id; ?>.jpg" style="" class="responsive" >
                            <?php   }  ?>
                                    <p><?php echo $news->news_text; ?></p>
                            <?php   $added_dt_tm = strtotime($news->date_added);
                                    $added_dt = date("j F Y",$added_dt_tm);
                                    $added_tm = date("h:i A",$added_dt_tm);
                            ?>
                                    <p><small><?php echo 'Added on '.$added_dt.' at '.$added_tm.' by '.$news->by_whom; ?></small></p>
                                </div>
                    <?php   }
                          }       
                    ?>
                </div> <!--/ .col-lg-8 col-sm-8 -->
                <div class="col-lg-3 col-sm-3" id="archive">
                    <h2>Archive</h2>
                    <?php   if(!empty($newsAddedDate)){ ?>
                                <ul type="circle" style="padding-left: 10px; ">
                        <?php   foreach ($newsAddedDate as $newsAddedDate) {
                                    $added_dt_tm = strtotime($newsAddedDate->date_added);
                                    $year_month = date("Y F",$added_dt_tm);
                                    $year_month2 = date("Y-m",$added_dt_tm);
                                    echo '<li><a href="'.base_url().'news/viewNewsByMonth/'.$year_month2.' ">'.$year_month.'</a></li>'; 
                                    echo '<hr style="margin-top:5px;margin-bottom:5px;">';
                                    ?>

                    <?php       }   ?>
                                </ul>
                    <?php   }   ?>
                </div><!--/ .col-lg-4 col-sm-4 -->
            </div>
        </div>
    </section><!--/#portfolio-item-->