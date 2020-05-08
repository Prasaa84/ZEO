    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
    <script type="text/javascript">
    $( document ).ready(function() {    
      ctx=document.getElementById("noOfSchoolsPieChart"),
      noOfSchoolsPieChart = new Chart(ctx,{
        type:"pie",
        data:{
          labels:["ජාතික පාසල්","1AB පාසල්","1C පාසල්","2 වර්ගයේ පාසල්","3 වර්ගයේ පාසල්"],
          datasets:[{
            data:[
              <?php 
                echo $this->no_of_national_schools.',';   // no of national schools is first value
                foreach ($this->count_schools_by_type as $row) { // then other type of schools
                  echo $row->count.',';         // data is needed this way -> [10,20,30,40]
                }              
              ?>
            ],
            backgroundColor:["#007bff","#dc3545","#ffc107","#28a745","#28a7aa"]
          }]
        }
      });
      // -- Bar Chart Example
      var ctx = document.getElementById("noOfSchoolsBarChart1");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ["National", "1AB", "1C", "2", "3"],
          datasets: [{
            label: "Revenue",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: [3, 15, 16, 18, 19],
          }],
        },
        options: {
          scales: {
            xAxes: [{
              time: {
                unit: 'month'
              },
              gridLines: {
                display: false
              },
              ticks: {
                maxTicksLimit: 6
              }
            }],
            yAxes: [{
              ticks: {
                min: 0,
                max: 50,
                maxTicksLimit: 5
              },
              gridLines: {
                display: true
              }
            }],
          },
          legend: {
            display: false
          }
        }
      });
    })
  </script>
  <?php
  foreach($this->session as $user_data){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if($userrole=='School User'){
      //$school_name = $user_data['school_name'];
    }
  }
?>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>user">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
        <?php //echo $this->session->userdata['userrole_id']; 
              //print_r($this->session->all_userdata());
        ?>

      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-comments"></i>
              </div>
              <div class="mr-5"><?php echo $this->new_msg_count; ?> New Messages!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>UserMessages">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /Card Messages-->
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-building"></i>
              </div>
              <div class="mr-5">Schools</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>school">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-bar-chart"></i>
              </div>
              <div class="mr-5">School Staff</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>Staff">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-bar-chart"></i>
              </div>
              <div class="mr-5">Zonal Staff</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-child"></i>
              </div>
              <div class="mr-5">Students</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>student">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-info o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-bar-chart"></i>
              </div>
              <div class="mr-5">Student Term Test Marks</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-bar-chart"></i>
              </div>
              <div class="mr-5">Student Exam Results</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-black bg-secondary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-bar-chart"></i>
              </div>
              <div class="mr-5">News and Events</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>news">
              <span class="float-left text-dark">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      <?php if($role_id==1){ ?> <!-- if the user is only admin-->
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-bar-chart"></i>
              </div>
              <div class="mr-5">User Track</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>User/viewUsers">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-dark o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-bar-chart"></i>
              </div>
              <div class="mr-5">Backup and Restore DB</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      <?php } ?>
      <!-- Account settings available for all users-->
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-dark o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-bar-chart"></i>
              </div>
              <div class="mr-5">Account Settings</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>User/UnmPwdChangeView"">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <!-- Salary increment messages -->
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-dark o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-bar-money"></i>
              </div>
              <div class="mr-5">Salary Increment Notices</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>Increment/index"">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div><!-- /row1-->
      <?php 
        $ci =& get_instance();
        $loginuser = $ci->session->userdata('loginuser'); // echo $loginuser; ?>
      <?php if(($role_id!=1) && ($role_id!=2)){ ?> <!-- if the user is only admin-->
      <div class="row">
        <div class="col-lg-8">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-bar-chart"></i> Number of Schools</div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <canvas id="noOfSchoolsBarChart1" width="100" height="50"></canvas>
                </div>
                <!-- <div class="col-sm-4 text-center my-auto">
                  <div class="h4 mb-0 text-primary">$34,693</div>
                  <div class="small text-muted">YTD Revenue</div>
                  <hr>
                  <div class="h4 mb-0 text-warning">$18,474</div>
                  <div class="small text-muted">YTD Expenses</div>
                  <hr>
                  <div class="h4 mb-0 text-success">$16,219</div>
                  <div class="small text-muted">YTD Margin</div>
                </div> -->
              </div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>
        </div><!-- /col-lg-8-->
        <div class="col-lg-4">
          <!-- Example Pie Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-pie-chart"></i> Number of Schools 
            </div>
            <div class="card-body">
              <canvas id="noOfSchoolsPieChart" width="100%" height="100">
                <!-- the pie chart is displayed here -->
              </canvas>
            </div>
            <div class="card-footer small text-muted">
            <?php 

              foreach($this->recent_update_dt_school as $row){
                $recent_update_dt_school = $row['date_updated'];
              }
              //view database updated date and time
              $last_update_dt = strtotime($recent_update_dt_school);
              $sch_last_updated_on_date = date("j F Y",$last_update_dt);
              $sch_last_updated_on_time = date("h:i A",$last_update_dt);
              echo 'Updated on '.$sch_last_updated_on_date.' at '.$sch_last_updated_on_time;
            ?>
            </div>
          </div>
        </div><!-- /col-lg-4-->
      </div><!-- /row2-->
<?php } ?>
              <?php //echo md5('assdirector'); ?>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->