<?php
foreach ($this->session as $user_data) {
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if ($userrole == 'School User') {
        $school_name = $user_data['school_name'];
        $census_id = $user_data['census_id'];
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
        .fa-circle {
            font-size: 16px;
        }

        .points-indicator {
            position: absolute;
            color: white;
            font-weight: bold;
            top: 1px;
            left: 4px;
            width: 5px;
            height: 5px;
            font-size: 10px;
            line-height: 16px;
            text-align: center;
        }

        .dropdown-message {
            overflow: hidden;
            max-width: none;
            text-overflow: ellipsis
        }

        #navbarResponsive .nav-item {
            margin-right: 5px;
        }

        #exampleAccordion {
            line-height: 5px;
        }

        #logout_btn:hover {
            color: white;
        }
    </style>
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <a class="navbar-brand" href="<?php echo base_url(); ?>User">කලාප අධ්‍යාපන කාර්යාලය - දෙනියාය</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a class="nav-link" href="<?php echo base_url(); ?>User">
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
                        <?php if ($role_id == '1') { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>School/viewAddSchoolPage">Insert School</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>School/findSchoolPage">Search Schools</a>
                            </li>
                        <?php } elseif ($role_id == '2') { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>School/viewUpdateSchoolPage/<?php echo $userid; ?>">Update
                                    School</a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>School/findSchoolPage">Search Schools</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti1" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-book" style="color:#ffaa12;"></i>
                        <span class="nav-link-text">Grades</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseMulti1">
                        <li>
                            <a href="<?php echo base_url(); ?>SchoolGrades">View</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>SchoolGrades/viewGradeReports">Grade Reports</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti2" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-book" style="color:#12ffaa;"></i>
                        <span class="nav-link-text">Classes</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseMulti2">
                        <li>
                            <a href="<?php echo base_url(); ?>SchoolClasses">View</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>SchoolClasses/viewClassReports">Class Reports</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti3" data-parent="#exampleAccordion">
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
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti4" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-child" style="color:#12aaff;"></i>
                        <span class="nav-link-text">Students</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseMulti4">
                        <li>
                            <a href="<?php echo base_url(); ?>Student">View</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>Student/viewStudentsInClasses">Students In Classes</a>
                        </li>
                        <?php if ($role_id == '1') { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>Student/viewInactiveStudents">Inactive Students</a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo base_url(); ?>Student/AdmNumberChangeView">Change Adm No</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>Student/studentReportsView">Reports</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti5" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-bar-chart" style="color:#FF1493;"></i>
                        <span class="nav-link-text">Term Test Marks</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseMulti5">
                        <li>
                            <a href="<?php echo base_url(); ?>Marks">View</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>Marks/viewMarksConfirm">Confirm Marks</a>
                        </li>
                        <li>
                            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti5_1" data-parent="#collapseMulti5">Reports</a>
                            <ul class="sidenav-third-level collapse" id="collapseMulti5_1">
                                <li>
                                    <a href="<?php echo base_url(); ?>Marks/viewPositionOnAvgMarks">Rank by Average</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>Marks/viewPositionOnSubjectMarks">Rank by
                                        Subject</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>Marks/viewListOnRange">List by Range</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti6" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-building" style="color:#ffaa45;"></i>
                        <span class="nav-link-text">Resources</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseMulti6">
                        <li>
                            <a href="<?php echo base_url(); ?>physicalResource/viewAddPhysicalResourcePage">Physical
                                Resources</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>computerLab/viewDetails">Computer Laboratory</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>library/viewDetails">Library</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>furniture/viewDetails">Furniture</a>
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
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti7" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-child" style="color:#00ff12;"></i>
                        <span class="nav-link-text">Academic Staff</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseMulti7">
                        <?php if ($role_id == '1') { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>Staff/viewStaffCount"> View Count </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo base_url(); ?>Staff"> View All </a>
                        </li>
                        <?php if ($role_id == '1') { ?>
                            <li>
                                <a href="<?php echo base_url(); ?>Staff/viewDeletedStaff"> Deleted Staff </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo base_url(); ?>Staff/staffReportsView">Reports</a>
                        </li>
                    </ul>
                </li>
                <!-- Academic staff salary increments -->
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Menu Levels">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti8" data-parent="#exampleAccordion">
                        <i class="fa fa-fw fa-money" style="color:#FFC0CB;"></i>
                        <span class="nav-link-text">Salary Increments</span>
                    </a>
                    <ul class="sidenav-second-level collapse" id="collapseMulti8">
                        <li>
                            <a href="<?php echo base_url(); ?>Increment">View</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>Increment/viewIncrementReports">Reports</a>
                        </li>
                    </ul>
                </li>

                <?php if ($userrole == 'System Administrator') { ?>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
                        <a class="nav-link" href="<?php echo base_url(); ?>News">
                            <i class="fa fa-fw fa-newspaper-o" style="color:#12aaff;"></i>
                            <span class="nav-link-text">News & Events</span>
                        </a>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
                        <a class="nav-link" href="<?php echo base_url(); ?>YearPlan">
                            <i class="fa fa-fw fa-calendar" style="color:#11fa85;"></i>
                            <span class="nav-link-text">Year Plan</span>
                        </a>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
                        <a class="nav-link" href="<?php echo base_url(); ?>User/viewUsers">
                            <i class="fa fa-fw fa-user" style="color:#C71585;"></i>
                            <span class="nav-link-text">User Track</span>
                        </a>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
                        <a class="nav-link" href="<?php echo base_url(); ?>DbSettings">
                            <i class="fa fa-fw fa-database" style="color:#00ff12;"></i>
                            <span class="nav-link-text">DB Settings</span>
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
                    <a class="nav-link" href="<?php echo base_url(); ?>User/UnmPwdChangeView">
                        <i class="fa fa-fw fa-person" style="color:#FFFF00;"></i>
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mr-lg-2" id="staffUpdateStatusDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-fw fa-user"></i>
                        <span class="d-lg-none">Staff Not Updated
                            <span class="badge badge-pill badge-danger stf-sts-indicator-mob"></span>
                        </span>
                        <span class="indicator text-primary d-none d-lg-block">
                            <span class="badge badge-pill badge-danger stf-sts-indicator"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="staffUpdateStatusDropdown" id="dropdown-menu-staffstatus" style="overflow-y:scroll; max-height:450px; width: 340px;">
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mr-lg-2" id="birthDayAlertDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-fw fa-birthday-cake"></i>
                        <span class="d-lg-none">BirthDay
                            <span class="badge badge-pill badge-primary bday-indicator-mob"></span>
                        </span>
                        <span class="indicator text-primary d-none d-lg-block">
                            <span class="badge badge-pill badge-primary bday-indicator"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="birthDayAlertDropdown" id="dropdown-menu-birthDay" style="overflow-y:scroll; max-height:450px; width: 340px;">
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-fw fa-envelope"></i>
                        <span class="d-lg-none">Messages
                            <span class="badge badge-pill badge-success msg-indicator-mob"></span>
                        </span>
                        <span class="indicator text-primary d-none d-lg-block">
                            <span class="badge badge-pill badge-success msg-indicator"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="messagesDropdown" id="dropdown-menu-messages" style="overflow-y:scroll; max-height:450px; width: 340px;">
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-fw fa-bell"></i>
                        <span class="d-lg-none">Alerts
                            <span class="badge badge-pill badge-warning">6 New</span>
                        </span>
                        <span class="indicator text-warning d-none d-lg-block">
                            <?php if (!empty($this->phy_res_alert)) { // check whether physical resource alerts empty
                                foreach ($this->session as $user_data) {
                                    if ($user_data['userrole'] == 'School User') { // check whether the user is school
                                        foreach ($this->phy_res_alert as $row) { // check whether the school has read the alert before
                                            $read = $row->is_read;
                                        }
                                        if (!$read) { // if the school has not read the alerts yet echo the circle
                                            echo '<i class="fa fa-fw fa-circle"></i>';
                                        } else {
                                            // if alert has been read by the user, no need to view the circle
                                        }
                                    } else {
                                        // if not a school user, show the circle
                                        echo '<i class="fa fa-fw fa-circle"></i>';
                                    }
                                } // end session foreach
                            } // end checking the alerts
                            ?>
                        </span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="alertsDropdown" id="dropdown-menu" style="overflow-y:scroll; max-height:450px; width: 340px;">

                    </div>
                </li>
                <li class="nav-item" id="header_welcome_user">
                    <a class="nav-link">
                        <?php
                        foreach ($this->session as $user_data) {
                            if ($user_data['userrole'] == 'School User') {
                                echo $user_data['school_name'];
                            } else {
                                echo 'Welcome ', $user_data['userrole'];
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
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            load_staffstatus_notification_circle();
            load_birthday_alert_circle();
            load_msg_notification_circle();

            function load_staffstatus_notification_circle() { // red circle on staff status notification
                $.ajax({
                    url: "<?php echo base_url(); ?>Staff/countStaffNotUpdatedToCurrentMonth",
                    success: function(data) {
                        if (data > 0) {
                            $('.stf-sts-indicator-mob').text(data + ' New');
                            $('.stf-sts-indicator').text(data);
                        } else {
                            $('.stf-sts-indicator-mob').text();
                            $('.stf-sts-indicator').text();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            }

            function load_birthday_alert_circle() { // yellow circle on birthday notification
                $.ajax({
                    url: "<?php echo base_url(); ?>BirthDayMessage/countNewBirthDays",
                    success: function(data) {
                        if (data > 0) {
                            $('.bday-indicator').text(data);
                            $('.bday-indicator-mob').text(data + ' New');
                        } else {
                            $('.bday-indicator').text();
                            $('.bday-indicator-mob').text();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            }

            function load_msg_notification_circle() { // blue circle on message notification
                $.ajax({
                    url: "<?php echo base_url(); ?>UserMessages/countNewMessages",
                    success: function(data) {
                        if (data > 0) {
                            $('.msg-indicator-mob').text(data + ' New');
                            $('.msg-indicator').text(data);
                        } else {
                            $('.msg-indicator-mob').text();
                            $('.msg-indicator').text();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            }

            // alerts/notifications
            $('#alertsDropdown').on('click', function() {
                $.ajax({
                    url: "<?php echo base_url(); ?>Alert/viewAlert",
                    success: function(data) {
                        $('#dropdown-menu').html('');
                        $('#dropdown-menu').html(data);
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            });
            // messages notification
            $('#messagesDropdown').on('click', function() {
                $.ajax({
                    url: "<?php echo base_url(); ?>UserMessages/viewMessageNotifications",
                    success: function(data) {
                        $('#dropdown-menu-messages').html('');
                        $('#dropdown-menu-messages').html(data);
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            });
            // birthday notification
            $('#birthDayAlertDropdown').on('click', function() {
                $.ajax({
                    url: "<?php echo base_url(); ?>BirthDayMessage/viewBirthDayNotifications",
                    success: function(data) {
                        $('#dropdown-menu-birthDay').html('');
                        $('#dropdown-menu-birthDay').html(data);
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            });
        });
    </script>