  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>    
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js" type="text/javascript"></script>  -->
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
  <script type="text/javascript">
    $( document ).ready(function() { 
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c'; 
<?php if($role_id != 2){  ?>
        // schools count devision wise (කොට්ඨාස අනුව)
        var cData = JSON.parse(`<?php echo $this->count_schools_by_devision; ?>`);  
        var total_schools = 0;
        for (i = 0; i < cData.sch_count.length; ++i) {
          total_schools = total_schools + parseInt(cData.sch_count[i]);  
        }   
        $('#total_schools_span').html(total_schools);
        var ctx = document.getElementById("noOfSchoolsDevisionWisePieChart");
        var myPieChart = new Chart(ctx, {
          type:"pie",
          data:{
            //labels:["ජාතික පාසල්","1AB පාසල්","1C පාසල්","2 වර්ගයේ පාසල්","3 වර්ගයේ පාසල්"],
            labels: cData.division,
            datasets:[{
              data: cData.sch_count,
              backgroundColor:["#007bff","#dc3545","#ffc107"],
            }],
          },
        });
        // Schoool count type wise (1AB,1C....)
        var cData = JSON.parse(`<?php echo $this->count_schools_by_type; ?>`);  
        var ctx = document.getElementById("noOfSchoolsTypeWisePieChart");
        var myPieChart = new Chart(ctx, {
          type:"pie",
          data:{
            labels: cData.sch_type,
            datasets:[{
              data: cData.sch_count,
              backgroundColor:["#007bff","#dc3545","#ffc107","#28a745"],
            }],
          },
        });
        // schools count national or provincial wise 
        var cData = JSON.parse(`<?php echo $this->count_schools_by_belongsTo; ?>`);  
        var ctx = document.getElementById("noOfSchoolsProAndNationalWisePieChart");
        var myPieChart = new Chart(ctx, {
          type:"pie",
          data:{
            labels: cData.div_name,
            datasets:[{
              data: cData.sch_count,
              backgroundColor:["#007bff","#dc3545","#ffc107"],
            }],
          },
        });
<?php }  ?>
      // staff count gender wise (if user is not school, count of all the staff in the zone)
      var cData = JSON.parse(`<?php echo $this->all_academic_staff_count_genderwise; ?>`);  
      //alert(cData.stf_count); // 152,535
      var total_staff = 0;
      //alert(cData.stf_count.length); // 2 (male and female)
      for (i = 0; i < cData.stf_count.length; ++i) {
        total_staff = total_staff + parseInt(cData.stf_count[i]);  
      } 
      //alert(total_staff)  // 687
      $('#total_staff_span').html(total_staff);
      var ctx = document.getElementById("pieChartTotalStaffGenderWise");
      var myPieChart = new Chart(ctx, {
        type:"pie",
        data:{
          labels: cData.gender,
          datasets:[{
            data: cData.stf_count,
            backgroundColor:["#007bff","#dc3545"],
          }],
        },
      });
      // student count gender wise (if user is not school, count of all the students in the zone)
      var cData = JSON.parse(`<?php echo $this->all_student_count_genderwise; ?>`);  
      //alert(cData.std_count); // 152,535
      var total_student = 0;
      //alert(cData.stf_count.length); // 2 (male and female)
      for (i = 0; i < cData.std_count.length; ++i) {
        total_student = total_student + parseInt(cData.std_count[i]);  
      } 
      //alert(total_staff)  // 687
      $('#total_student_span').html(total_student);
      var ctx = document.getElementById("pieChartTotalStudentsGenderWise");
      var myPieChart = new Chart(ctx, {
        type:"pie",
        data:{
          labels: cData.gender,
          datasets:[{
            data: cData.std_count,
            backgroundColor:["#007bff","#dc3545"],
          }],
        },
      });
    });
  </script>
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
        <div class="col-xl-2 col-sm-3 mb-2">
          <div class="card text-white bg-primary o-hidden h-80">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-comments"></i>
              </div>
              <div class="mr-5">Messages!</div>
              <h2><?php echo $this->new_msg_count; ?> </h2>
            </div>
<!--             <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>UserMessages">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a> -->
          </div><!-- /Card Messages-->
        </div>
<?php if( $role_id != 2 ){ ?>
        <div class="col-xl-2 col-sm-3 mb-2">
          <div class="card text-white bg-warning o-hidden h-80">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-building"></i>
              </div>
              <div class="mr-5">Schools</div>
              <h2><?php echo $this->all_schools_count;  ?></h2>
            </div>
          </div>
        </div>
<?php } ?>
        <div class="col-xl-2 col-sm-3 mb-2">
          <div class="card text-white bg-success o-hidden h-80">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-child"></i>
              </div>
              <div class="mr-5">Students</div>
              <h2><?php echo $this->all_students_count; ?></h2>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-sm-3 mb-2">
          <div class="card text-white bg-danger o-hidden h-80">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-users"></i>
              </div>
              <div class="mr-5">Ac. Staff</div>
              <h2><?php echo $this->all_ac_staff_count; ?></h2>
            </div>
          </div>
        </div>
        <div class="col-xl-2 col-sm-3 mb-2">
          <div class="card text-white bg-info o-hidden h-80">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-bar-chart"></i>
              </div>
              <div class="mr-5">Term Test</div>
              <h2><?php echo '10%'; ?></h2>
            </div>
            <!-- <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>Marks">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a> -->
          </div>
        </div>
        <div class="col-xl-2 col-sm-3 mb-2">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-building"></i>
              </div>
              <div class="mr-5">Resources</div>
              <h2><?php echo '5%'; ?></h2>
            </div>
            <!-- <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>physicalResource/viewAddPhysicalResourcePage">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a> -->
          </div>
        </div>
<?php //echo $this->session->userdata['userrole']; ?>
      </div><!-- /row1-->
<?php if($this->session->userdata['userrole'] != 'School User'){ ?>
      <div class="row">
        <div class="col-lg-4">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-bar-chart"></i> කොට්ටාසය අනුව මුළු පාසල් ප්‍රමාණය - 
              <span id="total_schools_span"></span>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <canvas id="noOfSchoolsDevisionWisePieChart" width="100" height="60"></canvas>
                </div>
              </div>
            </div>
            <div class="card-footer small text-muted">
             
            </div>
          </div>
        </div><!-- /col-lg-4 -->
        <div class="col-lg-4">
          <!-- Example Pie Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-pie-chart"></i> පාසල් වර්ගීකරණය
            </div>
            <div class="card-body">
              <canvas id="noOfSchoolsTypeWisePieChart" width="100" height="60">
                <!-- the pie chart is displayed here -->
              </canvas>
            </div>
            <div class="card-footer small text-muted">

            </div>
          </div>
        </div><!-- /col-lg-4-->
        <div class="col-lg-4">
          <!-- Example Pie Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-pie-chart"></i> ජාතික සහ පලාත් පාසල් ප්‍රමාණය 
            </div>
            <div class="card-body">
              <canvas id="noOfSchoolsProAndNationalWisePieChart" width="100" height="60">
                <!-- the pie chart is displayed here -->
              </canvas>
            </div>
            <div class="card-footer small text-muted">

            </div>
          </div>
        </div><!-- /col-lg-4-->
      </div><!-- /row2-->
<?php   } ?>
<?php   //if($this->session->userdata['userrole'] == 'School User'){ ?>
      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-pie-chart"></i>     
        <?php   if($this->session->userdata['userrole'] == 'School User'){ 
                  echo 'සියළුම අධ්‍යයන කාර්ය මණ්ඩලය - '; 
                }else{ echo 'කලාපය තුළ සියළුම අධ්‍යයන කාර්ය මණ්ඩලය - '; }
        ?>
              <span id="total_staff_span"></span>
            </div>
            <div class="card-body">
              <canvas id="pieChartTotalStaffGenderWise" width="100" height="60"></canvas>
            </div>
            <div class="card-footer small text-muted" id="">

            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-pie-chart"></i>     
        <?php   if($this->session->userdata['userrole'] == 'School User'){ 
                  echo 'සියළුම ළමුන් සංඛ්‍යාව  - '; 
                }else{ echo 'කලාපය තුළ සිටින සියළුම ළමුන් සංඛ්‍යාව - '; }
        ?>
              <span id="total_student_span"></span>
            </div>
            <div class="card-body">
              <canvas id="pieChartTotalStudentsGenderWise" width="100" height="60"></canvas>
            </div>
            <div class="card-footer small text-muted" id="">

            </div>
          </div>
        </div>
      </div><!-- /row2-->
              <?php // }//echo md5('07001'); ?>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->