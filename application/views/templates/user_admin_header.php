<?php
  foreach($this->session as $user_data){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if($userrole=='School User'){
      $school_name = $user_data['school_name'];
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
  <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
<!--   <link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
 -->  
 <link href="<?php echo base_url(); ?>assets/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
 <link href="<?php echo base_url(); ?>assets/datatables/css/buttons.dataTables.min.css" rel="stylesheet">
  
  <!-- Date picker -->
  <link href="<?php echo base_url(); ?>assets/datepicker/css/datepicker.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
  <!-- Sweet alert-->
  <link href="<?php echo base_url(); ?>assets/css/sweetalert/sweetalert.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="<?php echo base_url(); ?>assets/css/admin_custom.css" rel="stylesheet">
  <style type="text/css">
     .dropdown-message{overflow:hidden;max-width:none;text-overflow:ellipsis}
  </style>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">කලාප අධ්‍යාපන කාර්යාලය - දෙනියාය</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="<?php echo base_url(); ?>user/index">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-building"></i>
            <span class="nav-link-text">School</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseComponents">
            <li>
            <?php if($role_id=='1'){ ?>
              <a href="<?php echo base_url(); ?>school/viewAddSchoolPage">Insert</a>
            <?php }else if($role_id=='2'){ ?>
              <a href="<?php echo base_url(); ?>school/viewUpdateSchoolPage/<?php echo $userid; ?>">Update</a>
            <?php } ?>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>school/findSchoolPage">Search</a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>computerLab/viewDetails">Computer Laboratory</a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>library/viewDetails">Library</a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>furniture/viewAddFurniturePage">Furniture</a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>physicalResource/viewAddPhysicalResourcePage">Physical Resources</a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>building/viewDetails">Buildings</a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>sanitary/viewDetails">Sanitary Items</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-child"></i>
            <span class="nav-link-text">Teachers</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti">
            <li>
              <a href="#">Second Level Item</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
          <a class="nav-link" href="#">
            <i class="fa fa-fw fa-child"></i>
            <span class="nav-link-text">Students</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
          <a class="nav-link" href="#">
            <i class="fa fa-fw fa-bar-chart"></i>
            <span class="nav-link-text">Student Marks</span>
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-envelope"></i>
            <span class="d-lg-none">Messages
              <span class="badge badge-pill badge-primary">12 New</span>
            </span>
            <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="messagesDropdown">
            <h6 class="dropdown-header">New Messages:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>David Miller</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>Jane Smith</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>John Doe</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all messages</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">Alerts
              <span class="badge badge-pill badge-warning">6 New</span>
            </span>
            <span class="indicator text-warning d-none d-lg-block">
              <?php if(!empty($this->phy_res_alert)){ // check whether physical resource alerts empty
                      foreach($this->session as $user_data){
                        if($user_data['userrole']=='School User'){ // check whether the user is school
                          foreach ($this->phy_res_alert as $row) { // check whether the school has read the alert before
                            $read = $row->is_read;
                          }
                          if(!$read){ // if the school has not read the alerts yet echo the circle
                            echo '<i class="fa fa-fw fa-circle"></i>';
                          }else{ 
                            // if alert has been read by the user, no need to view the circle
                          }
                        }else{ 
                          // if not a school user, show the circle
                          echo '<i class="fa fa-fw fa-circle"></i>'; 
                        }
                      } // end session foreach
                    } // end checking the alerts
              ?>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header"> New Alerts : </h6>
            <div class="dropdown-divider"></div>
            <div style="overflow-y:scroll; max-height:450px;">
              <?php
               if($user_data['userrole']=='School User'){  
                foreach($this->phy_res_alert as $row) {
                  $id = $row->alert_id;
                  $alert_cat_id = $row->alert_cat_id;
                  $censusId = $row->to_whom;
                  $date_updated = $row->date_updated;
                  $date_updated = strtotime($date_updated);
                  $date = date("Y-m-d",$date_updated);
                  $time = date("h:i A",$date_updated);
              ?>
            <?php   if($user_data['userrole']=='School User'){ // check whether the user is school ?>
              <a class="dropdown-item" href="<?php echo base_url(); ?>alert/viewAlertPageById/<?php echo $id; ?>">
            <?php } ?>
            <?php   if($user_data['userrole']=='System Administrator'){ // check whether the user is Admin ?>
              <a class="dropdown-item" href="<?php echo base_url(); ?>alert/viewAlertPageById/<?php echo $alert_cat_id; ?>">
            <?php } ?>
                <span class="text-success">
                  <strong>
                    <i class="fa fa-long-arrow-up fa-fw"></i><?php echo $row->alert_category." to be updated "; ?></strong>
                </span>
                <span class="small float-right text-muted"><?php echo $date.' '.$time; ?></span>
                <div class="dropdown-message small"><?php echo $row->alert_desc; ?></div>
              </a>
              <div class="dropdown-divider"></div>
              <?php } } ?>
              <?php
               if($user_data['userrole']=='System Administrator'){  
                //print_r($this->phy_res_alert); die();
                foreach($this->phy_res_alert as $row) {
                  $count = $row->count;
                  $alert_cat_id = $row->alert_cat_id;
                  $date_updated = $row->date_updated;
                  $date_updated = strtotime($date_updated);
                  $date = date("Y-m-d",$date_updated);
                  $time = date("h:i A",$date_updated);
              ?>
              <a class="dropdown-item" href="<?php echo base_url(); ?>alert/viewAlertPageById/<?php echo $alert_cat_id; ?>">
                <span class="text-success">
                  <strong>
                    <i class="fa fa-long-arrow-up fa-fw"></i><?php echo $row->alert_category." to be updated "; ?></strong>
                </span>
                <span class="small float-right text-muted"><?php echo $date.' '.$time; ?></span>
                <div class="dropdown-message small"><?php echo $count.' Schools'; ?></div>
              </a>
              <div class="dropdown-divider"></div>
              <?php } } ?>
            </div>
            <?php   if($user_data['userrole']=='School User'){ // check whether the user is school
            ?>
              <a class="dropdown-item small" href="<?php echo base_url(); ?>alert/viewAllAlertsPage/<?php echo $censusId; ?>">View all alerts</a>
            <?php }else{ ?> 
              <a class="dropdown-item small" href="<?php echo base_url(); ?>alert/viewAllAlertsPage">View all alerts</a>
            <?php } ?>
          </div>
        </li>
        <li class="nav-item" id="header_welcome_user">
          <a class="nav-link">
            <?php 
              foreach($this->session as $user_data){
                if($user_data['userrole']=='School User'){
                  echo $user_data['school_name'];
                }else{
                  echo 'Welcome ',$user_data['userrole'];
                }
              }
            ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>