<?php
  foreach($this->session as $user_data){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if( $role_id == '2' ){
      $school_name = $user_data['school_name'];
      $census_id = $user_data['census_id'];
    }elseif( $role_id == '7' ){
      $div_id = $user_data['div_id'];
      $div_name = $user_data['div_name'];
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?php echo $title; ?></title>
  <!-- Bootstrap core CSS-->
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
<!--   <link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
 -->  
 <link href="<?php echo base_url(); ?>assets/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
 <link href="<?php echo base_url(); ?>assets/datatables/css/buttons.dataTables.min.css" rel="stylesheet">
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/datatables/css/fixedColumns.dataTables.min.css">
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
  <!-- Sweet alert-->
  <link href="<?php echo base_url(); ?>assets/css/sweetalert/sweetalert.css" rel="stylesheet">
  <!-- Date picker-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/datepicker/css/datepicker.css" rel="stylesheet" type="text/css">
  <!-- Custom CSS -->
  <link href="<?php echo base_url(); ?>assets/css/admin_custom.css" rel="stylesheet">
  <style type="text/css">
    .dropdown-message{overflow:hidden;max-width:none;text-overflow:ellipsis}
    #exampleAccordion{ line-height: 2px; }
    #logout_btn:hover {
      color: white;
    }

  </style>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="<?php echo base_url(); ?>user/index">කලාප අධ්‍යාපන කාර්යාලය - දෙනියාය</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="<?php echo base_url(); ?>user/index">
            <i class="fa fa-fw fa-dashboard" style="color:#FF8C00;"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-building" style="color:#800080;"></i>
            <span class="nav-link-text">School</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents">
            <li>
              <a href="<?php echo base_url(); ?>School/findSchoolPage">Search Schools</a>
            </li>            
          </ul>
        </li> 
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti1" data-parent="#exampleAccordion" >
            <i class="fa fa-fw fa-book" style="color:#ffaa12;"></i>
            <span class="nav-link-text">Grades</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti1">
            <li>
              <a href="<?php echo base_url(); ?>SchoolGrades/viewGradeReports">View</a>
            </li>
          </ul>
        </li> 
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti2" data-parent="#exampleAccordion" >
            <i class="fa fa-fw fa-book" style="color:#12ffaa;"></i>
            <span class="nav-link-text">Classes</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti2">
            <li>
              <a href="<?php echo base_url(); ?>SchoolClasses/viewClassReports">View</a>
            </li>
          </ul>
        </li>      
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti3" data-parent="#exampleAccordion" >
            <i class="fa fa-fw fa-book" style="color:#cc3300;"></i>
            <span class="nav-link-text">Subjects</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti3">
            <li>
              <a href="<?php echo base_url(); ?>Subjects">View</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti7" data-parent="#exampleAccordion" >
            <i class="fa fa-fw fa-child" style="color:#00ff12;"></i>
            <span class="nav-link-text">Academic Staff</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti7">
      <?php //if($role_id=='1'){ ?>
              <li>
                <a href="<?php echo base_url(); ?>Staff/staffReportsView">Reports</a>
              </li>
      <?php //} ?>
          </ul>
        </li>
<!-- Academic staff salary increments -->        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti8" data-parent="#exampleAccordion" >
            <i class="fa fa-fw fa-money" style="color:#FFC0CB;"></i>
            <span class="nav-link-text">Salary Increments</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti8">
            <li>
              <a href="<?php echo base_url(); ?>Increment">View</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
          <a class="nav-link" href="<?php echo base_url(); ?>User/UnmPwdChangeView">
            <i class="fa fa-fw fa-dashboard" style="color:#FFFF00;"></i>
            <span class="nav-link-text">User Settings</span>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        
        <li class="nav-item" id="header_welcome_user">
          <a class="nav-link">
            <?php 
              foreach($this->session as $user_data){
                if( $role_id=='7' ){
                  echo 'Welcome ',$div_name.' කොට්ඨාස කාර්යාලය';
                }
              }
            ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal" id="logout_btn">
            <i class="fa fa-fw fa-sign-out" style="color:#FF8C00;"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>