<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script type="text/javascript">
  $(document ).ready(function() {  
    // BAr chart for student count grade wise in student index page
    var cData = JSON.parse(`<?php echo $this->staff_count_schoolwise; ?>`);      
    var ctx = document.getElementById("barChartStudents");
      var myLineChart = new Chart(ctx, {
        type: 'bar',
        data: {
          //labels: [1, 2, "3", "4", "5", "6",],
          labels: cData.label,          
          datasets: [{
            label: "Number of Staff",
            backgroundColor: "rgba(2,117,216,1)",
            borderColor: "rgba(2,117,216,1)",
            data: cData.data,
            //data: [253, 215, 116, 218, 119, 135,],
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
                max: 100,
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
      // Pie chart for student count gender wise in student index page
      // Set new default font family and font color to mimic Bootstrap's default styling
      Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = '#292b2c';
      var cData = JSON.parse(`<?php echo $this->staff_count_genderwise; ?>`);      
      // Pie Chart Example
      var ctx = document.getElementById("pieChartTotalStudentsGenderWise");
      var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ["Male", "Female"],
          //labels: cData.gender_name,          
          datasets: [{
            //data: [12.21, 15.58, 11.25, 8.32],
            data: cData.stf_count,
            backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
          }],
        },
      });  
    });
    $('#addNewStudentInfo a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
      $(this).css('border-color', 'blue');
    })
    function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function (e) {
              $('#imgPrw').attr('src', e.target.result);
          }
          
          reader.readAsDataURL(input.files[0]);
      }
    }
  $(document ).ready(function() {    
      $("#imgInp").change(function(){
          readURL(this);
      });
  })
  </script>
  <style type="text/css">
   #addNewStudentInfo li a{
    display: inline-block;
    height: 40px; width: 150px;
    margin: 0 2px 0 2px;
    padding: 2px;
    text-align: center;
   }
  #addNewStudentInfo li a:hover{
    text-decoration: none;
    color: blue;
    background-color: #eeeeee;
   }
   .navPaneDown{margin-bottom: 5px;}
   .active{
      border:1px 1px 0px 1px;
      border-color: black;
   }
   .imgPrw{
      max-width: 90px; max-height: 120px;
   }
  </style>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>user">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Staff</li>
      </ol>
      <?php
        if(!empty($this->session->flashdata('msg'))) {
          $message = $this->session->flashdata('msg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php } ?> 
      <?php
        if(!empty($this->session->flashdata('uploadSuccess'))) {
          $message = $this->session->flashdata('uploadSuccess');  ?>
          <div class="alert alert-success" ><?php echo $message; ?></div>
      <?php } ?> 
      <?php
        if(!empty($this->session->flashdata('uploadError'))) {
          $message = $this->session->flashdata('uploadError');  
            foreach ($message as $item => $value){
              echo '<div class="alert alert-danger" >'.$item.' : '.$value.'</div>';
            }
       } ?> 
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-2 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-child"></i>
              </div>
              <div class="mr-5">Add Staff</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>Staff/viewAcademicStaff">
              <span class="float-left">Go to Form</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
        <div class="col-xl-2 col-sm-6 mb-3">
          <div class="card text-white bg-info o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-search"></i>
              </div>
              <div class="mr-5">Staff Reports</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>Staff/staffReportsPage">
              <span class="float-left">Go -></span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
      </div><!-- /row1-->
      <div class="row">
        <div class="col-lg-8">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
              Number of Staff School Wise</div>
            <div class="card-body">
              <canvas id="barChartStudents" width="100%" height="50"></canvas>
            </div>
            <div class="card-footer small text-muted">
              <?Php 
                $stdata = json_decode($this->staff_count_schoolwise,true);
                $st_last_upd = $stdata['date_updated'][0];
                $st_last_upd = strtotime($st_last_upd);
                $st_updated_date = date("j F Y",$st_last_upd);
                $st_updated_time = date("h:i A",$st_last_upd);
                echo 'Updated on '.$st_updated_date.' at '.$st_updated_time;
              ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-pie"></i>
              Total Staff Gender Wise</div>
            <div class="card-body">
              <canvas id="pieChartTotalStudentsGenderWise" width="100%" height="100"></canvas>

            </div>
            <div class="card-footer small text-muted" id="date_updated_div2">
              <?Php 
                $stdata = json_decode($this->staff_count_schoolwise,true);
                $st_last_upd = $stdata['date_updated'][0];
                $st_last_upd = strtotime($st_last_upd);
                $st_updated_date = date("j F Y",$st_last_upd);
                $st_updated_time = date("h:i A",$st_last_upd);
                echo 'Updated on '.$st_updated_date.' at '.$st_updated_time;
              ?>
            </div>
          </div>
        </div>
      </div>
      <!-- /following bootstrap model used to insert school students -->
      <div class="modal fade" id="addNewStudentInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> ශිෂ්‍ය තොරතුරු ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                <div role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs " role="tablist">
                        <li role="presentation" class="active"><a href="#privateDetailsTab" aria-controls="privateDetailsTab" role="tab" data-toggle="tab"> පෞද්ගලික තොරතුරු </a></li>
                        <li role="presentation"><a href="#schoolDetailsTab" aria-controls="schoolDetailsTab" role="tab" data-toggle="tab"> පාසලේ තොරතුරු </a></li>
                        <li role="presentation"><a href="#parentDetailsTab" aria-controls="parentDetailsTab" role="tab" data-toggle="tab"> භාරකරු </a></li>
                        <li role="presentation"><a href="#imageTab" aria-controls="imageTab" role="tab" data-toggle="tab"> පින්තූරය </a></li>
                    </ul>
                    <!-- Tab panes -->
                  <div class="tab-content mt-3">
                    <div role="tabpanel" class="tab-pane active" id="privateDetailsTab"> 
                        
                  <?php
                  $attributes = array("class" => "form-horizontal", "id" => "insert_student_info_form", "name" => "insert_student_info_form", "accept-charset" => "UTF-8" );
                  echo form_open_multipart("Student/addStudent", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label">ඇතුළත් වීමේ අංකය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="index_no_txt" name="index_no_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="full name" class="control-label">සම්පූර්ණ නම </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="full_name_txt" name="full_name_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="name with initials" class="control-label">මුලකුරු සමග නම </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="name_with_ini_txt" name="name_with_ini_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label">ලිපිනය 1 </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="address1_txt" name="address1_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" size="60" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label">ලිපිනය 2 </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="address2_txt" name="address2_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label">දුරකථන අංකය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="tel_txt" name="tel_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label">උපන් දිනය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="dob_txt" name="dob_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="wide" class="control-label">ස්ත්‍රී/පුරුෂ</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="gender_select" name="gender_select">
                            <option value="" selected>---ක්ලික් කරන්න---</option>
                            <option value="1" > ස්ත්‍රී</option>
                            <option value="2" > පුරුෂ </option>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  </div> <!-- /privateDetailsTab -->
                  <div role="tabpanel" class="tab-pane" id="schoolDetailsTab">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="census id">සංඝණන අංකය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="census_id_select" name="census_id_select" title="Please select">
                            <?php 
                            foreach($this->session as $user_data){
                              if($user_data['userrole']=='School User'){ 
                                echo $census_id = $user_data['census_id']; 
                                echo '<option value="'.$census_id.'" selected>'.$census_id.'</option>';
                              }else{
                            ?>
                                <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                                <?php foreach ($this->all_schools as $row){ ?><!-- from Building controller constructor method -->
                                  <option value="<?php echo $row->census_id; ?>"><?php echo $row->census_id; ?></option>
                            <?php } ?> 
                        <?php } 
                            }   ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('census_id'); ?></span>
                          <?php //echo md5(0712636761); ?>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new category" class="control-label">ශ්‍රේණිය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="grade_select" name="grade_select">
                            <option value="" selected>---ක්ලික් කරන්න---</option>
                            <?php foreach ($this->all_grades as $row){ ?> <!-- from Building controller constructor method -->
                              <option value="<?php echo $row->grade_id; ?>"><?php echo $row->grade_name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="wide" class="control-label">පන්තිය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="class_select" name="class_select">
                            <option value="" selected>---ක්ලික් කරන්න---</option>
                            <?php foreach ($this->all_classes as $row){ ?> <!-- from Building controller constructor method -->
                              <option value="<?php echo $row->class_id; ?>"><?php echo $row->class_name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="admission date" class="control-label"> ඇතුළත් වූ දිනය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="admission_date_txt" name="admission_date_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                  </div> <!-- /schoolDetailsTab -->
                  <div role="tabpanel" class="tab-pane" id="parentDetailsTab">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="guardian" class="control-label"> භාරකරුගේ නම </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="response_person_name_txt" name="response_person_name_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="guardian telephone" class="control-label"> දුරකථන අංකය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="response_person_tel_txt" name="response_person_tel_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="donated by" class="control-label"> රැකියාව </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="response_person_job_txt" name="response_person_job_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="donated by" class="control-label"> සම්බන්ධතාවය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="response_person_relationship_txt" name="response_person_relationship_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->    
                  </div> <!-- /parentDetailsTab -->
                  <div role="tabpanel" class="tab-pane" id="imageTab">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="select image" class="control-label"> පින්තූරය තෝරන්න </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input type="file" name="student_image" size="20" id="imgInp" />                 
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <img id="imgPrw" src="#" alt="Preview" class="imgPrw" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->   
                  <!-- <fieldset> -->
                  </div> <!-- /imageTab -->
                </div> <!-- /col-sm-12 -->
                </div>
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add_new_student_info" value="Add_New">Save</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
    </div> <!-- /.container-fluid-->
    <!-- /.content-wrapper-->