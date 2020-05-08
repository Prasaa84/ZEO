<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $title; ?></title>

    <link rel="shortcut icon" type="image/x-icon"  href="<?php echo base_url(); ?>assets/images/bootstrap.min.css" />
    <!-- core CSS -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" >
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/prettyPhoto.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo base_url(); ?>assets/css/sweetalert/sweetalert.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>assets/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url(); ?>assets/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url(); ?>assets/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>assets/images/ico/apple-touch-icon-57-precomposed.png">

</head><!--/head-->

<body class="homepage">

    <header id="header">
        <div class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-xs-4">
                        <div class="top-number"><p><i class="fa fa-phone-square"></i>  +9441 228 23 45</p></div>
                    </div>
                    <div class="col-sm-6 col-xs-8">
                        <div class="social">
                            <ul class="social-share">
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                    <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                    <li><a href="#"><i class="fa fa-skype"></i></a></li>
                                </ul>
                            <div class="search">
                                <form role="form">
                                    <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                                    <i class="fa fa-search"></i>
                                </form>
                           </div>
                       </div>
                    </div>
                </div>
            </div><!--/.container-->
        </div><!--/.top-bar-->

        <nav class="navbar navbar-inverse" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/logo2.png" alt="logo"></a>
                </div>

                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo base_url(); ?>">මුල් පිටුව</a></li>
                        <li><a href="<?php echo base_url(); ?>GeneralInfo/aboutUs">අප ගැන</a></li>
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">කොට්ඨාශ <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>GeneralInfo/morawakaDiv">මොරවක</a></li>
                                <li><a href="<?php echo base_url(); ?>GeneralInfo/kotapolaDiv">කොටපොල</a></li>
                                <li><a href="<?php echo base_url(); ?>GeneralInfo/pasgodaDiv">පස්ගොඩ</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">කාර්ය මණ්ඩලය <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url(); ?>GeneralInfo/director">කලාප අධ්‍යාපන අධ්‍යක්ෂ තුමිය</a></li>
                                <li><a href="<?php echo base_url(); ?>GeneralInfo/assDirectors">සහකාර අධ්‍යාපන අධ්‍යකෂක වරු</a></li>
                                <li><a href="<?php echo base_url(); ?>GeneralInfo/divDirectors">කොට්ඨාශ අධ්‍යාපන අධ්‍යක්ෂක වරු</a></li>
                                <li><a href="<?php echo base_url(); ?>GeneralInfo/adminOfficer">පරිපාලන නිළධාරී</a></li>
                                <li><a href="<?php echo base_url(); ?>GeneralInfo/accountant">ගණකාධි කාරී තුමා</a></li>
                                <li><a href="<?php echo base_url(); ?>GeneralInfo/otherStaff">වෙනත්</a></li>
                            </ul>
                        </li>
                        <!--<li><a href="<?php echo base_url(); ?>GeneralInfo/Gallery">ගැලරිය</a></li>-->                        
                        <li><a href="<?php echo base_url(); ?>GeneralInfo/news">පුවත්</a></li>
                        <li><a href="<?php echo base_url(); ?>GeneralInfo/contact">සම්බන්ධ වීම</a></li>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->

    </header><!--/header-->