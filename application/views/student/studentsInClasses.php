<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script type="text/javascript">
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
<style type="text/css">
  input[type='file'] {
    display: none;
  }
  .table thead tr{
    height: 20px;
  }
  .table-responsive{height: 450px;}
  .dataTable{font-size: 13px;}
  .dataTable tr{height: 10px;}
  div.dataTables_wrapper {
        width: 400px;
        margin: 0 auto;
  }
</style>
  <?php
  foreach($this->session as $user_data){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if($role_id=='2'){
      //$class = $user_data['grade'].' '.$user_data['class'];
      echo $school_name = $user_data['school_name'];
      $census_id = $user_data['census_id'];
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
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>student">Students </a>
        </li>
        <li class="breadcrumb-item active">Students in Classes</li>
      </ol>
      <?php
        if(!empty($this->session->flashdata('grdClsMsg'))) {
          $message = $this->session->flashdata('grdClsMsg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php   } ?>       
      <?php 
        if(!empty($this->session->flashdata('msg'))) {
          $message = $this->session->flashdata('msg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php   } ?> 
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
                පන්ති වල සිසුන් 
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h6 align="center">  </h6>
                  <form class="form-inline" role="search" id="show_classes_form" name="show_classes_form" action="<?php echo base_url(); ?>Student/StudentsInClasses" method="POST">
            <?php if($role_id!='2'){ // admin ?>
                    <div class="form-group col-sm-4">
                      <div class="row">
                        <div class="col-sm-1">
                          <label for="School" class="label label-sm"> School </label>
                        </div>
                        <div class="col-sm-3">
                          <select class="form-control  form-control-sm" id="school_select" name="school_select">
                            <option value="" selected>---Select---</option>
                      <?php   
                              $selected_school = set_value('school_select');
                              foreach ($this->all_schools as $school){ 
                                if($school->census_id == $selected_school){ 
                      ?>
                                  <option value="<?php echo $school->census_id; ?>" selected><?php echo $school->sch_name; ?></option>
                      <?php     }else{ ?> 
                                  <option value="<?php echo $school->census_id; ?>"><?php echo $school->sch_name.'-'.$school->census_id; ?></option>
                      <?php     } 
                              }
                      ?> 
                          </select>
                          <span class="text-danger" id="grade_error"><?php echo form_error('school_select'); ?></span>
                        </div>
                      </div>
                    </div>
            <?php }else{  ?>
                    <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
            <?php } ?> 
            <?php if($role_id=='2'){ ?>
                    <div class="form-group col-sm-2">
            <?php }else{ ?> 
                    <div class="form-group col-sm-2">
            <?php } ?>
                      <div class="input-group addon">
                        <select class="form-control form-control-sm" id="select_year" name="select_year" title="Please select the academic year" data-toggle="tooltip">
                          <option value="" selected="selected"> ---Year--- </option>
            <?php              
                            $year = date('Y');
                            for($year; $year > 2019; $year--) {
                              echo '<option value="'.$year.'" >'.$year.'</option>';
                            }  
            ?>                               
                        </select>
                      </div> <!-- /.input-group addon -->
                    </div> <!-- /.form-group -->
                    <div class="form-group col-sm-2">
                      <div class="input-group addon">
                        <select class="form-control form-control-sm" id="select_grade_of_stu" name="select_grade_of_stu" title="Please select the school, if no grades"  data-toggle="tooltip">
                          <option value="" selected>---Grade---</option>
                          <?php foreach ($schoolGrades as $row){ ?>
                            <option value="<?php echo $row->grade_id; ?>"><?php echo $row->grade; ?></option>
                          <?php } ?>                                
                        </select>
                      </div> <!-- /.input-group addon -->
                    </div> <!-- /.form-group -->
                    <div class="form-group col-sm-1">
                      <button type="submit" name="show_classes_with_students_button" value="Show" class="btn btn-info btn-sm" ><i class="fa fa-eye"></i> View </button>
                    </div>
                    <div class="form-group col-sm-3">
                      <a href="<?php echo base_url(); ?>assets/download/student/Students in Class.xlsx" type="button" class="btn btn-success mr-2 btn-sm" data-toggle="tooltip" title="Template for uploading students to a class" ><i class="fa fa-download"></i>  Template</a>
                      <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#helpModal"><i class="fa fa-question"></i></button>
                    </div>
                  </form> <!-- /form -->
                  <br />
                </div> <!-- /col-lg-12 -->
              </div> <!-- /row -->
            </div> <!-- <div class="card-body"> -->
          </div> <!-- <div class="card mb-3"> -->
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
      <?php     
                if(!empty($classes)){  
                  foreach($classes as $class){ 
                    $grade_id = $class->grade_id;
                    $grade = $class->grade;
                    $year = $class->year;
                    $census_id = $class->census_id;
                  }
                  echo $grade.' පන්තියේ සිසුන් - '.$year;
                  $ci = & get_instance();
                  $ci->load->model('Student_model');
                  $std_count_of_grade = $ci->Student_model->get_student_count_of_a_grade( $census_id, $grade_id, $year );
                  echo '<span style="float:right;">මුළු සිසුන් ගණන - '.$std_count_of_grade.'</span>';
                }else{
                  echo 'No classes found!!!';
                }
      ?>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
<!--------------- cant use iteration method to view classes since file input not working properly. there for have to manage all the classes separately. if want to view new class (Class I,J,K....) please copy the same code from <div class="col-lg-3 col-md-6 col-sm-12"> above the <div class="card mb-3"> -------------------------->
<!-------------------------------- A Classes begin -------------------------------------------------------->
                  <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="card mb-3">
                            <div class="card-header">
                              <i class="fa fa-chart-bar"></i>
                      <?php     if( !empty( $classes ) ){  
                                  $classAssigned = false;
                                  $students = '';
                                  $std_count = '';
                                  foreach ( $classes as $class ) {
                                    if( $class->class_id == 1 ){
                                      global $classAssigned;
                                      $classAssigned = true;
                                      $grade_id = $class->grade_id;
                                      echo $class->grade.' '.$class->class.' - '.$class->year;
                                      $class_id = $class->class_id; // Class A
                                      $year = $class->year;
                                      $ci = & get_instance();
                                      $ci->load->model('Student_model');
                                      $students = $ci->Student_model->get_students_in_a_class( $census_id, $grade_id, $class_id, $year );
                                      $std_count = $ci->Student_model->get_student_count_of_a_class( $census_id, $grade_id, $class_id, $year );
                                      echo '<span style="float:right;"> Total - '.$std_count.'</span>';
                                    }
                                  }
                                }
                      ?>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="table-responsive">
                      <?php       
                                  if(!empty($classes) && $classAssigned){ 
                                    if(!empty($students)){  ?>
                                      <table id="dataTable" class="table table-striped table-hover dataTable" cellspacing="0" style="width:100%">
                                        <thead>
                                          <tr>
                                            <th style="width: 2px;">#</th>
                                            <th style="width: 2px;"> ඇ.වී. අං </th>
                                            <th style="width: 150px;"> නම </th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                <?php     $no = 1;
                                          $date_updated = '';
                                          foreach($students as $student){      
                                            $adm_no = $student->index_no;
                                            $name   = $student->name_with_initials; 
                                            if (isset($student->last_update)) {
                                              $date_updated = $student->last_update;
                                            }
                              ?>            <tr>
                                              <input type="hidden" value="<?php //echo $sch_grd_cls_id; ?>" name="sch_grd_cls_id_hidden" />
                                              <th><?php echo $no; ?></th>
                                              <td><?php echo $adm_no; ?></td>
                                              <td><?php echo $name; ?></td>
                                            </tr>
                                <?php       $no++;    ?>
                                <?php     }    ?>
                                        </tbody>
                                      </table>
                              <?php }else{  // if(!empty($students)){ 
                                      echo '<div class="alert alert-info"> No students found </div>';
                                    } 
                                  }else{
                                    echo '<div class="alert alert-danger">Not assigned</div>';
                                  }
                            ?>
                                </div> <!-- table-responsive -->
                              </div> <!-- /row -->
                      <?php   if(!empty($classAssigned) && (($role_id=='1') || ($role_id=='2'))){ ?>
                                <div class="row">
                                  <form role="search" class="form-inline" name="students_form1" action="<?php echo base_url(); ?>" method="POST" id="students_form1" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="file" name="file1" id="file1" required accept=".xls, .xlsx" style="font-size: 10pt;" class="file1"/>
                                      <label for="file1" class="btn btn-sm btn-info" data-toggle="tooltip" title="Choose the excel file" ><i class="fa fa-fw fa-file-excel-o"> </i> Excel  </label>
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" name="import" value="Upload" class="btn btn-info btn-sm ml-2" data-toggle="tooltip" title="File Upload" ><i class="fa fa-upload"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                  <form role="search" class="form-inline students_delete_form" name="students_delete_form1" action="<?php echo base_url(); ?>" method="POST" id="students_delete_form1" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" id="delete_students_btn" name="delete_students_btn" value="Delete" class="btn btn-danger btn-sm ml-2 delete_students_btn" data-toggle="tooltip" title="Delete All Students" ><i class="fa fa-trash"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                </div>
                      <?php   } ?>
                            </div> <!-- / <div class="card-body"> -->
                            <div class="card-footer small text-muted">
                        <?php
                              if(!empty($classes) && $classAssigned && !empty($students) && !empty($date_updated)){
                                $last_update_dt = strtotime($date_updated);
                                $date = date("d-m-Y",$last_update_dt);
                                $time = date("h:i A",$last_update_dt);
                                echo 'Updated on '.$date.' at '.$time;
                              }
                          ?>               
                            </div>
                          </div> <!-- <div class="card mb-3"> -->
                        </div> <!-- /col-lg-3 -->
<!-------------------------------- B Class begin -------------------------------------------------------->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="card mb-3">
                            <div class="card-header">
                              <i class="fa fa-chart-bar"></i>
                      <?php     if(!empty($classes)){  
                                  $classAssigned = false;
                                  $students = '';
                                  $std_count = '';
                                  foreach ($classes as $class) {
                                    if($class->class_id==2){
                                      global $classAssigned;
                                      $classAssigned = true;
                                      $grade_id = $class->grade_id;
                                      echo $class->grade.' '.$class->class.' - '.$class->year;
                                      $class_id = $class->class_id; // Class B
                                      $year = $class->year;
                                      $ci = & get_instance();
                                      $ci->load->model('Student_model');
                                      $students = $ci->Student_model->get_students_in_a_class($census_id, $grade_id, $class_id, $year);
                                      $std_count = $ci->Student_model->get_student_count_of_a_class( $census_id, $grade_id, $class_id, $year );
                                      echo '<span style="float:right;"> Total - '.$std_count.'</span>';
                                    }
                                  }
                                }
                      ?>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="table-responsive">
                      <?php       if(!empty($classes) && $classAssigned){ 
                                        if(!empty($students)){  ?>
                                          <table id="dataTable" class="table table-striped table-hover dataTable" cellspacing="0" style="width:100%">
                                            <thead>
                                              <tr>
                                                <th style="width: 2px;">#</th>
                                                <th style="width: 2px;"> ඇ.වී. අං </th>
                                                <th style="width: 150px;"> නම </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                    <?php     $no = 1;
                                              $date_updated = '';
                                              foreach($students as $student){      
                                                $adm_no = $student->index_no;
                                                $name   = $student->name_with_initials; 
                                                if (isset($student->last_update)) {
                                                  $date_updated = $student->last_update;
                                                }
                                  ?>            <tr>
                                                  <th><?php echo $no; ?></th>
                                                  <td><?php echo $adm_no; ?></td>
                                                  <td><?php echo $name; ?></td>
                                                </tr>
                                    <?php       $no++;    ?>
                                    <?php     }    ?>
                                            </tbody>
                                          </table>
                                  <?php }else{  // if(!empty($students)){ 
                                      echo '<div class="alert alert-info"> No students found </div>';
                                    } 
                                  }else{
                                    echo '<div class="alert alert-danger">Not assigned</div>';
                                  }
                            ?>
                                </div> <!-- table-responsive -->
                              </div> <!-- /row -->
                      <?php   if(!empty($classAssigned) && (($role_id=='1') || ($role_id=='2'))){ ?>
                                <div class="row">
                                  <form role="search" class="form-inline" name="students_form2" action="<?php echo base_url(); ?>" method="POST" id="students_form2" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="file" name="file2" id="file2" required accept=".xls, .xlsx" style="font-size: 10pt;" class="file2"/>
                                      <label for="file2" class="btn btn-sm btn-info" data-toggle="tooltip" title="Choose the excel file" ><i class="fa fa-fw fa-file-excel-o"> </i> Excel  </label>
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" name="import" value="Upload" class="btn btn-info btn-sm ml-2" data-toggle="tooltip" title="File Upload" ><i class="fa fa-upload"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                  <form role="search" class="form-inline students_delete_form" name="students_delete_form1" action="<?php echo base_url(); ?>" method="POST" id="students_delete_form1" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" id="delete_students_btn" name="delete_students_btn" value="Delete" class="btn btn-danger btn-sm ml-2 delete_students_btn" data-toggle="tooltip" title="Delete All Students" ><i class="fa fa-trash"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                </div>
                      <?php   } ?>
                            </div> <!-- / <div class="card-body"> -->
                            <div class="card-footer small text-muted">
                        <?php
                              if(!empty($classes) && $classAssigned && !empty($students) && !empty($date_updated)){
                                $last_update_dt = strtotime($date_updated);
                                $date = date("d-m-Y",$last_update_dt);
                                $time = date("h:i A",$last_update_dt);
                                echo 'Updated on '.$date.' at '.$time;
                              }
                          ?>               
                            </div>
                          </div> <!-- <div class="card mb-3"> -->
                        </div> <!-- /col-lg-3 -->
<!-------------------------------- C Class begin -------------------------------------------------------->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="card mb-3">
                            <div class="card-header">
                              <i class="fa fa-chart-bar"></i>
                      <?php     if(!empty($classes)){  
                                  $classAssigned = false;
                                  $students = '';
                                  $std_count = '';
                                  foreach ($classes as $class) {
                                    if($class->class_id==3){
                                      global $classAssigned;
                                      $classAssigned = true;
                                      $grade_id = $class->grade_id;
                                      echo $class->grade.' '.$class->class.' - '.$class->year;
                                      $class_id = $class->class_id; // Class C
                                      $year = $class->year;
                                      $ci = & get_instance();
                                      $ci->load->model('Student_model');
                                      $students = $ci->Student_model->get_students_in_a_class($census_id,$grade_id,$class_id,$year);
                                      $std_count = $ci->Student_model->get_student_count_of_a_class( $census_id, $grade_id, $class_id, $year );
                                      echo '<span style="float:right;"> Total - '.$std_count.'</span>';
                                    }
                                  }
                                }
                      ?>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="table-responsive">
                      <?php       if(!empty($classes) && $classAssigned){ 
                                        if(!empty($students)){  ?>
                                          <table id="dataTable" class="table table-striped table-hover dataTable" cellspacing="0" style="width:100%">
                                            <thead>
                                              <tr>
                                                <th style="width: 2px;">#</th>
                                                <th style="width: 2px;"> ඇ.වී. අං </th>
                                                <th style="width: 150px;"> නම </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                    <?php     $no = 1;
                                              $date_updated = '';
                                              foreach($students as $student){      
                                                $adm_no = $student->index_no;
                                                $name   = $student->name_with_initials; 
                                                if (isset($student->last_update)) {
                                                  $date_updated = $student->last_update;
                                                }
                                  ?>            <tr>
                                                  <input type="hidden" value="<?php //echo $sch_grd_cls_id; ?>" name="sch_grd_cls_id_hidden" />
                                                  <th><?php echo $no; ?></th>
                                                  <td><?php echo $adm_no; ?></td>
                                                  <td  width="250"><?php echo $name; ?></td>
                                                </tr>
                                    <?php       $no++;    ?>
                                    <?php     }    ?>
                                            </tbody>
                                          </table>
                                  <?php }else{  // if(!empty($students)){ 
                                      echo '<div class="alert alert-info"> No students found </div>';
                                    } 
                                  }else{
                                    echo '<div class="alert alert-danger">Not assigned</div>';
                                  }
                            ?>
                                </div> <!-- table-responsive -->
                              </div> <!-- /row -->
                      <?php   if(!empty($classAssigned) && (($role_id=='1') || ($role_id=='2'))){ ?>
                                <div class="row">
                                  <form role="search" class="form-inline" name="students_form3" action="<?php echo base_url(); ?>" method="POST" id="students_form3" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="file" name="file3" id="file3" required accept=".xls, .xlsx" style="font-size: 10pt;" class="file3"/>
                                      <label for="file3" class="btn btn-sm btn-info" data-toggle="tooltip" title="Choose the excel file" ><i class="fa fa-fw fa-file-excel-o"> </i> Excel  </label>
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" name="import" value="Upload" class="btn btn-info btn-sm ml-2" data-toggle="tooltip" title="File Upload" ><i class="fa fa-upload"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                   <form role="search" class="form-inline students_delete_form" name="students_delete_form1" action="<?php echo base_url(); ?>" method="POST" id="students_delete_form1" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1 ml-0">
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" id="delete_students_btn" name="delete_students_btn" value="Delete" class="btn btn-danger btn-sm ml-2 delete_students_btn" data-toggle="tooltip" title="Delete All Students" ><i class="fa fa-trash"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                </div>
                      <?php   } ?>
                            </div> <!-- / <div class="card-body"> -->
                            <div class="card-footer small text-muted">
                        <?php
                              if(!empty($classes) && $classAssigned && !empty($students) && !empty($date_updated)){
                                $last_update_dt = strtotime($date_updated);
                                $date = date("d-m-Y",$last_update_dt);
                                $time = date("h:i A",$last_update_dt);
                                echo 'Updated on '.$date.' at '.$time;
                              }
                          ?>               
                            </div>
                          </div> <!-- <div class="card mb-3"> -->
                        </div> <!-- /col-lg-3 -->
<!-------------------------------- D Class begin -------------------------------------------------------->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="card mb-3">
                            <div class="card-header">
                              <i class="fa fa-chart-bar"></i>
                      <?php     if( !empty( $classes ) ){  
                                  $classAssigned = false;
                                  $students = '';
                                  $std_count = '';
                                  foreach ($classes as $class) {
                                    if($class->class_id==4){
                                      global $classAssigned;
                                      $classAssigned = true;
                                      $grade_id = $class->grade_id;
                                      echo $class->grade.' '.$class->class.' - '.$class->year;
                                      $class_id = $class->class_id; // Class D
                                      $year = $class->year;
                                      $ci = & get_instance();
                                      $ci->load->model('Student_model');
                                      $students = $ci->Student_model->get_students_in_a_class($census_id,$grade_id,$class_id,$year);
                                      $std_count = $ci->Student_model->get_student_count_of_a_class( $census_id, $grade_id, $class_id, $year );
                                      echo '<span style="float:right;"> Total - '.$std_count.'</span>';
                                    }
                                  }
                                }
                      ?>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="table-responsive">
                      <?php       if(!empty($classes) && $classAssigned){ 
                                        if(!empty($students)){  ?>
                                          <table id="dataTable" class="table table-striped table-hover dataTable" cellspacing="0" style="width:100%">
                                            <thead>
                                              <tr>
                                                <th style="width: 2px;">#</th>
                                                <th style="width: 2px;"> ඇ.වී. අං </th>
                                                <th style="width: 150px;"> නම </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                    <?php     $no = 1;
                                              $date_updated = '';
                                              foreach($students as $student){      
                                                $adm_no = $student->index_no;
                                                $name   = $student->name_with_initials; 
                                                if (isset($student->last_update)) {
                                                  $date_updated = $student->last_update;
                                                }
                                  ?>            <tr>
                                                  <input type="hidden" value="<?php //echo $sch_grd_cls_id; ?>" name="sch_grd_cls_id_hidden" />
                                                  <th><?php echo $no; ?></th>
                                                  <td><?php echo $adm_no; ?></td>
                                                  <td  width="250"><?php echo $name; ?></td>
                                                </tr>
                                    <?php       $no++;    ?>
                                    <?php     }    ?>
                                            </tbody>
                                          </table>
                                  <?php }else{  // if(!empty($students)){ 
                                      echo '<div class="alert alert-info"> No students found </div>';
                                    } 
                                  }else{
                                    echo '<div class="alert alert-danger">Not assigned</div>';
                                  }
                            ?>
                                </div> <!-- table-responsive -->
                              </div> <!-- /row -->
                      <?php   if(!empty($classAssigned) && (($role_id=='1') || ($role_id=='2'))){ ?>
                                <div class="row">
                                  <form role="search" class="form-inline" name="students_form4" action="<?php echo base_url(); ?>" method="POST" id="students_form4" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="file" name="file4" id="file4" required accept=".xls, .xlsx" style="font-size: 10pt;" class="file4"/>
                                      <label for="file4" class="btn btn-sm btn-info" data-toggle="tooltip" title="Choose the excel file" ><i class="fa fa-fw fa-file-excel-o"> </i> Excel  </label>
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" name="import" value="Upload" class="btn btn-info btn-sm ml-2" data-toggle="tooltip" title="File Upload" ><i class="fa fa-upload"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                   <form role="search" class="form-inline students_delete_form" name="students_delete_form1" action="<?php echo base_url(); ?>" method="POST" id="students_delete_form1" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" id="delete_students_btn" name="delete_students_btn" value="Delete" class="btn btn-danger btn-sm ml-2 delete_students_btn" data-toggle="tooltip" title="Delete All Students" ><i class="fa fa-trash"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                </div>
                      <?php   } ?>
                            </div> <!-- / <div class="card-body"> -->
                            <div class="card-footer small text-muted">
                        <?php
                              if(!empty($classes) && $classAssigned && !empty($students) && !empty($date_updated)){
                                $last_update_dt = strtotime($date_updated);
                                $date = date("d-m-Y",$last_update_dt);
                                $time = date("h:i A",$last_update_dt);
                                echo 'Updated on '.$date.' at '.$time;
                              }
                          ?>               
                            </div>
                          </div> <!-- <div class="card mb-3"> -->
                        </div> <!-- /col-lg-3 -->
<!-------------------------------- E Class begin -------------------------------------------------------->
                       <div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="card mb-3">
                            <div class="card-header">
                              <i class="fa fa-chart-bar"></i>
                      <?php     if(!empty($classes)){  
                                  $classAssigned = false;
                                  $students = '';
                                  foreach ($classes as $class) {
                                    if($class->class_id==5){
                                      global $classAssigned;
                                      $classAssigned = true;
                                      $grade_id = $class->grade_id;
                                      echo $class->grade.' '.$class->class.' - '.$class->year;
                                      $class_id = $class->class_id; // Class E
                                      $year = $class->year;
                                      $ci = & get_instance();
                                      $ci->load->model('Student_model');
                                      $students = $ci->Student_model->get_students_in_a_class($census_id,$grade_id,$class_id,$year);
                                    }
                                  }
                                }
                      ?>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="table-responsive">
                      <?php       if(!empty($classes) && $classAssigned){ 
                                        if(!empty($students)){  ?>
                                          <table id="dataTable" class="table table-striped table-hover dataTable" cellspacing="0" style="width:100%">
                                            <thead>
                                              <tr>
                                                <th style="width: 2px;">#</th>
                                                <th style="width: 2px;"> ඇ.වී. අං </th>
                                                <th style="width: 150px;"> නම </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                    <?php     $no = 1;
                                              $date_updated = '';
                                              foreach($students as $student){      
                                                $adm_no = $student->index_no;
                                                $name   = $student->name_with_initials; 
                                                if (isset($student->last_update)) {
                                                  $date_updated = $student->last_update;
                                                }
                                  ?>            <tr>
                                                  <input type="hidden" value="<?php //echo $sch_grd_cls_id; ?>" name="sch_grd_cls_id_hidden" />
                                                  <th><?php echo $no; ?></th>
                                                  <td><?php echo $adm_no; ?></td>
                                                  <td  width="250"><?php echo $name; ?></td>
                                                </tr>
                                    <?php       $no++;    ?>
                                    <?php     }    ?>
                                            </tbody>
                                          </table>
                                  <?php }else{  // if(!empty($students)){ 
                                      echo '<div class="alert alert-info"> No students found </div>';
                                    } 
                                  }else{
                                    echo '<div class="alert alert-danger">Not assigned</div>';
                                  }
                            ?>
                                </div> <!-- table-responsive -->
                              </div> <!-- /row -->
                      <?php   if(!empty($classAssigned) && (($role_id=='1') || ($role_id=='2'))){ ?>
                                <div class="row">
                                  <form role="search" class="form-inline" name="students_form5" action="<?php echo base_url(); ?>" method="POST" id="students_form5" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="file" name="file5" id="file5" required accept=".xls, .xlsx" style="font-size: 10pt;" class="file5"/>
                                      <label for="file5" class="btn btn-sm btn-info" data-toggle="tooltip" title="Choose the excel file" ><i class="fa fa-fw fa-file-excel-o"> </i> Excel  </label>
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" name="import" value="Upload" class="btn btn-info btn-sm ml-2" data-toggle="tooltip" title="File Upload" ><i class="fa fa-upload"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                  <form role="search" class="form-inline students_delete_form" name="students_delete_form1" action="<?php echo base_url(); ?>" method="POST" id="students_delete_form1" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" id="delete_students_btn" name="delete_students_btn" value="Delete" class="btn btn-danger btn-sm ml-2 delete_students_btn" data-toggle="tooltip" title="Delete All Students" ><i class="fa fa-trash"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                </div>
                      <?php   } ?>
                            </div> <!-- / <div class="card-body"> -->
                            <div class="card-footer small text-muted">
                        <?php
                              if(!empty($classes) && $classAssigned && !empty($students) && !empty($date_updated)){
                                $last_update_dt = strtotime($date_updated);
                                $date = date("d-m-Y",$last_update_dt);
                                $time = date("h:i A",$last_update_dt);
                                echo 'Updated on '.$date.' at '.$time;
                              }
                          ?>               
                            </div>
                          </div> <!-- <div class="card mb-3"> -->
                        </div> <!-- /col-lg-3 -->
<!-------------------------------- F Class begin -------------------------------------------------------->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="card mb-3">
                            <div class="card-header">
                              <i class="fa fa-chart-bar"></i>
                      <?php     if(!empty($classes)){  
                                  $classAssigned = false;
                                  $students = '';
                                  foreach ($classes as $class) {
                                    if($class->class_id==6){
                                      global $classAssigned;
                                      $classAssigned = true;
                                      $grade_id = $class->grade_id;
                                      echo $class->grade.' '.$class->class.' - '.$class->year;
                                      $class_id = $class->class_id; // Class F
                                      $year = $class->year;
                                      $ci = & get_instance();
                                      $ci->load->model('Student_model');
                                      $students = $ci->Student_model->get_students_in_a_class($census_id,$grade_id,$class_id,$year);
                                    }
                                  }
                                }
                      ?>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="table-responsive">
                      <?php       if(!empty($classes) && $classAssigned){ 
                                        if(!empty($students)){  ?>
                                          <table id="dataTable" class="table table-striped table-hover dataTable" cellspacing="0" style="width:100%">
                                            <thead>
                                              <tr>
                                                <th style="width: 2px;">#</th>
                                                <th style="width: 2px;"> ඇ.වී. අං </th>
                                                <th style="width: 150px;"> නම </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                    <?php     $no = 1;
                                              $date_updated = '';
                                              foreach($students as $student){      
                                                $adm_no = $student->index_no;
                                                $name   = $student->name_with_initials; 
                                                if (isset($student->last_update)) {
                                                  $date_updated = $student->last_update;
                                                }
                                  ?>            <tr>
                                                  <input type="hidden" value="<?php //echo $sch_grd_cls_id; ?>" name="sch_grd_cls_id_hidden" />
                                                  <th><?php echo $no; ?></th>
                                                  <td><?php echo $adm_no; ?></td>
                                                  <td  width="250"><?php echo $name; ?></td>
                                                </tr>
                                    <?php       $no++;    ?>
                                    <?php     }    ?>
                                            </tbody>
                                          </table>
                                 <?php }else{  // if(!empty($students)){ 
                                      echo '<div class="alert alert-info"> No students found </div>';
                                    } 
                                  }else{
                                    echo '<div class="alert alert-danger">Not assigned</div>';
                                  }
                            ?>
                                </div> <!-- table-responsive -->
                              </div> <!-- /row -->
                      <?php   if(!empty($classAssigned) && (($role_id=='1') || ($role_id=='2'))){ ?>
                                <div class="row">
                                  <form role="search" class="form-inline" name="students_form6" action="<?php echo base_url(); ?>" method="POST" id="students_form6" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="file" name="file6" id="file6" required accept=".xls, .xlsx" style="font-size: 10pt;" class="file6"/>
                                      <label for="file6" class="btn btn-sm btn-info" data-toggle="tooltip" title="Choose the excel file" ><i class="fa fa-fw fa-file-excel-o"> </i> Excel  </label>
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" name="import" value="Upload" class="btn btn-info btn-sm ml-2" data-toggle="tooltip" title="File Upload" ><i class="fa fa-upload"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                  <form role="search" class="form-inline students_delete_form" name="students_delete_form1" action="<?php echo base_url(); ?>" method="POST" id="students_delete_form1" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" id="delete_students_btn" name="delete_students_btn" value="Delete" class="btn btn-danger btn-sm ml-2 delete_students_btn" data-toggle="tooltip" title="Delete All Students" ><i class="fa fa-trash"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                </div>
                      <?php   } ?>
                            </div> <!-- / <div class="card-body"> -->
                            <div class="card-footer small text-muted">
                        <?php
                              if(!empty($classes) && $classAssigned && !empty($students) && !empty($date_updated)){
                                $last_update_dt = strtotime($date_updated);
                                $date = date("d-m-Y",$last_update_dt);
                                $time = date("h:i A",$last_update_dt);
                                echo 'Updated on '.$date.' at '.$time;
                              }
                          ?>               
                            </div>
                          </div> <!-- <div class="card mb-3"> -->
                        </div> <!-- /col-lg-3 -->
<!-------------------------------- G Class begin -------------------------------------------------------->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="card mb-3">
                            <div class="card-header">
                              <i class="fa fa-chart-bar"></i>
                      <?php     if(!empty($classes)){  
                                  $classAssigned = false;
                                  $students = '';
                                  foreach ($classes as $class) {
                                    if($class->class_id==7){
                                      global $classAssigned;
                                      $classAssigned = true;
                                      $grade_id = $class->grade_id;
                                      echo $class->grade.' '.$class->class.' - '.$class->year;
                                      echo $class_id = $class->class_id; // Class G
                                      $year = $class->year;
                                      $ci = & get_instance();
                                      $ci->load->model('Student_model');
                                      $students = $ci->Student_model->get_students_in_a_class($census_id,$grade_id,$class_id,$year);
                                    }
                                  }
                                }
                      ?>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="table-responsive">
                      <?php       if(!empty($classes) && $classAssigned){ 
                                        if(!empty($students)){  ?>
                                          <table id="dataTable" class="table table-striped table-hover dataTable" cellspacing="0" style="width:100%">
                                            <thead>
                                              <tr>
                                                <th style="width: 2px;">#</th>
                                                <th style="width: 2px;"> ඇ.වී. අං </th>
                                                <th style="width: 150px;"> නම </th>නම </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                    <?php     $no = 1;
                                              $date_updated = '';
                                              foreach($students as $student){      
                                                $adm_no = $student->index_no;
                                                $name   = $student->name_with_initials; 
                                                if (isset($student->last_update)) {
                                                  $date_updated = $student->last_update;
                                                }
                                  ?>            <tr>
                                                  <input type="hidden" value="<?php //echo $sch_grd_cls_id; ?>" name="sch_grd_cls_id_hidden" />
                                                  <th><?php echo $no; ?></th>
                                                  <td><?php echo $adm_no; ?></td>
                                                  <td  width="250"><?php echo $name; ?></td>
                                                </tr>
                                    <?php       $no++;    ?>
                                    <?php     }    ?>
                                            </tbody>
                                          </table>
                                  <?php }else{  // if(!empty($students)){ 
                                      echo '<div class="alert alert-info"> No students found </div>';
                                    } 
                                  }else{
                                    echo '<div class="alert alert-danger">Not assigned</div>';
                                  }
                            ?>
                                </div> <!-- table-responsive -->
                              </div> <!-- /row -->
                      <?php   if(!empty($classAssigned) && (($role_id=='1') || ($role_id=='2'))){ ?>
                                <div class="row">
                                  <form role="search" class="form-inline" name="students_form7" action="<?php echo base_url(); ?>" method="POST" id="students_form7" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="file" name="file7" id="file7" required accept=".xls, .xlsx" style="font-size: 10pt;" class="file7"/>
                                      <label for="file7" class="btn btn-sm btn-info" data-toggle="tooltip" title="Choose the excel file" ><i class="fa fa-fw fa-file-excel-o"> </i> Excel  </label>
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" name="import" value="Upload" class="btn btn-info btn-sm ml-2" data-toggle="tooltip" title="File Upload" ><i class="fa fa-upload"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                  <form role="search" class="form-inline students_delete_form" name="students_delete_form1" action="<?php echo base_url(); ?>" method="POST" id="students_delete_form1" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" id="delete_students_btn" name="delete_students_btn" value="Delete" class="btn btn-danger btn-sm ml-2 delete_students_btn" data-toggle="tooltip" title="Delete All Students" ><i class="fa fa-trash"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                </div>
                      <?php   } ?>
                            </div> <!-- / <div class="card-body"> -->
                            <div class="card-footer small text-muted">
                        <?php
                              if(!empty($classes) && $classAssigned && !empty($students) && !empty($date_updated)){
                                $last_update_dt = strtotime($date_updated);
                                $date = date("d-m-Y",$last_update_dt);
                                $time = date("h:i A",$last_update_dt);
                                echo 'Updated on '.$date.' at '.$time;
                              }
                          ?>               
                            </div>
                          </div> <!-- <div class="card mb-3"> -->
                        </div> <!-- /col-lg-3 -->
<!-------------------------------- H Class begin -------------------------------------------------------->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                          <div class="card mb-3">
                            <div class="card-header">
                              <i class="fa fa-chart-bar"></i>
                      <?php     if(!empty($classes)){  
                                  $classAssigned = false;
                                  $students = '';
                                  foreach ($classes as $class) {
                                    if($class->class_id==8){
                                      global $classAssigned;
                                      $classAssigned = true;
                                      $grade_id = $class->grade_id;
                                      echo $class->grade.' '.$class->class.' - '.$class->year;
                                      $class_id = $class->class_id; // Class H
                                      $year = $class->year;
                                      $ci = & get_instance();
                                      $ci->load->model('Student_model');
                                      $students = $ci->Student_model->get_students_in_a_class($census_id,$grade_id,$class_id,$year);
                                    }
                                  }
                                }
                      ?>
                            </div>
                            <div class="card-body">
                              <div class="row">
                                <div class="table-responsive">
                      <?php       if(!empty($classes) && $classAssigned){ 
                                        if(!empty($students)){  ?>
                                          <table id="dataTable" class="table table-striped table-hover dataTable" cellspacing="0" style="width:100%">
                                            <thead>
                                              <tr>
                                                <th style="width: 2px;">#</th>
                                                <th style="width: 2px;"> ඇ.වී. අං </th>
                                                <th style="width: 150px;"> නම </th>width="150"> නම </th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                    <?php     $no = 1;
                                              $date_updated = '';
                                              foreach($students as $student){      
                                                $adm_no = $student->index_no;
                                                $name   = $student->name_with_initials; 
                                                if (isset($student->last_update)) {
                                                  $date_updated = $student->last_update;
                                                }
                                  ?>            <tr>
                                                  <input type="hidden" value="<?php //echo $sch_grd_cls_id; ?>" name="sch_grd_cls_id_hidden" />
                                                  <th><?php echo $no; ?></th>
                                                  <td><?php echo $adm_no; ?></td>
                                                  <td  width="250"><?php echo $name; ?></td>
                                                </tr>
                                    <?php       $no++;    ?>
                                    <?php     }    ?>
                                            </tbody>
                                          </table>
                                  <?php }else{  // if(!empty($students)){ 
                                      echo '<div class="alert alert-info"> No students found </div>';
                                    } 
                                  }else{
                                    echo '<div class="alert alert-danger">Not assigned</div>';
                                  }
                            ?>
                                </div> <!-- table-responsive -->
                              </div> <!-- /row -->
                      <?php   if(!empty($classAssigned) && (($role_id=='1') || ($role_id=='2'))){ ?>
                                <div class="row">
                                  <form role="search" class="form-inline" name="students_form8" action="<?php echo base_url(); ?>" method="POST" id="students_form8" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="file" name="file8" id="file8" required accept=".xls, .xlsx" style="font-size: 10pt;" class="file8"/>
                                      <label for="file8" class="btn btn-sm btn-info" data-toggle="tooltip" title="Choose the excel file" ><i class="fa fa-fw fa-file-excel-o"> </i> Excel  </label>
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" name="import" value="Upload" class="btn btn-info btn-sm ml-2" data-toggle="tooltip" title="File Upload" ><i class="fa fa-upload"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                  <form role="search" class="form-inline students_delete_form" name="students_delete_form1" action="<?php echo base_url(); ?>" method="POST" id="students_delete_form1" enctype="multipart/form-data">
                                    <div class="form-group col-sm-12 col-lg-12 mt-1">
                                      <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                                      <input type="hidden" name="grade_id_hidden" id="grade_id_hidden" value="<?php echo $grade_id; ?>">
                                      <input type="hidden" name="class_id_hidden" id="class_id_hidden" value="<?php echo $class_id; ?>">
                                      <input type="hidden" name="year_hidden" id="year_hidden" value="<?php echo $year; ?>">
                                      <span class="icon-input-btn">
                                        <button type="submit" id="delete_students_btn" name="delete_students_btn" value="Delete" class="btn btn-danger btn-sm ml-2 delete_students_btn" data-toggle="tooltip" title="Delete All Students" ><i class="fa fa-trash"></i></button>
                                      </span>
                                    </div>                                 
                                  </form> <!-- /form -->
                                </div>
                      <?php   } ?>
                            </div> <!-- / <div class="card-body"> -->
                            <div class="card-footer small text-muted">
                        <?php
                              if(!empty($classes) && $classAssigned && !empty($students) && !empty($date_updated)){
                                $last_update_dt = strtotime($date_updated);
                                $date = date("d-m-Y",$last_update_dt);
                                $time = date("h:i A",$last_update_dt);
                                echo 'Updated on '.$date.' at '.$time;
                              }
                          ?>               
                            </div>
                          </div> <!-- <div class="card mb-3"> -->
                        </div> <!-- /col-lg-3 -->
<!-------------------------------- H Class End -------------------------------------------------------->
                  </div> <!-- /row -->
                </div> <!-- /col-lg-12 -->
              </div> <!-- /row -->
            </div> <!-- <div class="card-body"> -->
            <div class="card-footer small text-muted">
              
            </div>
          </div> <!-- <div class="card mb-3"> -->
        </div>
    </div> <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
<!------------------------- Help Modal - instructions for uploading bulk students to the system  --------------->
      <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> ශිෂ්‍යන් Excel File මගින් පන්තියකට (Class) ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  1. Students in Class.xlsx file තුළ sheet1 හි ඇතුලත් කර ඇති ඇ.වී. අං, මුලකුරු සමග නම අනිවාර්ය වේ. <br>
                  2. ඇ.වී.අංකය ඉලක්කම් 5 කින් සමන් විත වේ. <br>
                      එසේම පන්තියකට (Class) ඇතුළත් කළ හැක්කේ පද්ධතිය තුළ (System) සිටින ශිෂ්‍යයින් පමණි. <br>
                  3. Sheet1 tab rename නොකළ යුතුය. <br>
                  4. Students in Class.xlsx ගොනු නාමය (File name) වෙනස් කර ගත හැක. නමුත් .xlsx (File extension) වෙනස් නොකළ යුතුය. <br>
                  5. පන්තියකට excel file upload කරන විට දැනටමත් එහි පන්තියේ ඇති දත්ත මැකී ගොස් නව දත්ත ඇතුළත් වේ. <br>
                  6. ශිෂ්‍යයකු System එකෙන් Delete කළ විට, ඔහු Class එකෙන්ද ඉවත් වේ. <br>
                  7. ශිෂ්‍යයකු පන්තියකට ඇතුළත් කිරීම Student Update යටතේ වුවද එකින් එක කළ හැකිය. <br>
                  8. එසේ update කළද නැවත excel sheet මගින් නැවත එම class එකට සිසුන් ඇතුළත් කරන විට කලින් සිටි සිසුන් මැකී ගොස් excel sheet හි සිසුන් පමණක් ඇතුළත් වේ. 

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
<script>
  $(document).ready(function(){
  // printing students of a class
    $('.dataTable').DataTable({
      scrollY: 350,
      scrollX: false,
      searching: false, 
      paging: false, 
      info: false,
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'excel',
          className: 'btn btn-success btn-sm',
          text: '<i class="fa fa-download"></i>',  // icon of save to excel - download button
          titleAttr: 'Download',
          exportOptions: {
              modifier: {
                  page: 'All'
              }
          }
        }
      ],
      // need this to customize download button in datatable
      initComplete: function() {
        var btns = $('.dt-button');
        btns.removeClass('dt-button');
      },
    });
     //  Delete all students from the class
    $('.students_delete_form').on('submit', function(event){
      event.preventDefault();
      var formData = new FormData(this);
      var class_id = $('#class_id_hidden').val();
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: false,
        closeOnCancel: true
        },
        function(isConfirm) {
          if (isConfirm) {
            $.ajax({
              url:"<?php echo base_url(); ?>Student/deleteAllStudentsInAClass",
              method:"POST",
              //data:new FormData(this),
              data:formData,
              contentType:false,
              cache:false,
              processData:false,
              success:function(data){
                if(data=='0'){
                  swal('Ooops...','Somethins went wrong.','error');
                }else if(data=='1'){
                  swal('Deleted','Students deleted successfully','success');
                  location.reload();
                }else if(data=='2'){
                  swal('Sorry!','Marks have been finalized for this class','warning');
                }else{
                  swal('Error!','No enough data to delete this class','error');
                }
              },
              error:function(data, status, error ){
                console.log(data);
                console.log(status);
                console.log(error);
              }
            }) // ajax
          } // if
        } // function confirt
      ) // swal
    });
    // add students to class A
    // for each form we have to have separate ajax rather having one ajax, otherwise file input not workiing
    $('#students_form1').on('submit', function(event){
      alert('You are going to update Class A');
      event.preventDefault();
      $.ajax({
        url:"<?php echo base_url(); ?>Student/addBulkStudentsToClass",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        cache:false,
        processData:false,
        success:function(data){
          $('#file1').val('');
          alert(data);
          if(data=='Students were inserted successfully'){
            location.reload();
          }
        }
      })
    });
    // add students to class B
    $('#students_form2').on('submit', function(event){
      alert('You are going to update Class B');
      event.preventDefault();
      $.ajax({
        url:"<?php echo base_url(); ?>Student/addBulkStudentsToClass",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        cache:false,
        processData:false,
        success:function(data){
          $('#file2').val('');
          alert(data);
          if(data=='Students were inserted successfully'){
            location.reload();
          }
        }
      })
    });
    // add students to class C
    $('#students_form3').on('submit', function(event){
      alert('You are going to update Class C');
      event.preventDefault();
      $.ajax({
        url:"<?php echo base_url(); ?>Student/addBulkStudentsToClass",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        cache:false,
        processData:false,
        success:function(data){
          $('#file3').val('');
          alert(data);
          if(data=='Students were inserted successfully'){
            location.reload();
          }
        }
      })
    });
    // add students to class D
    $('#students_form4').on('submit', function(event){
      alert('You are going to update Class D');
      event.preventDefault();
      $.ajax({
        url:"<?php echo base_url(); ?>Student/addBulkStudentsToClass",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        cache:false,
        processData:false,
        success:function(data){
          $('#file4').val('');
          alert(data);
          if(data=='Students were inserted successfully'){
            location.reload();
          }
        }
      })
    });
    // add students to class E
    $('#students_form5').on('submit', function(event){
      alert('You are going to update Class E');
      event.preventDefault();
      $.ajax({
        url:"<?php echo base_url(); ?>Student/addBulkStudentsToClass",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        cache:false,
        processData:false,
        success:function(data){
          $('#file5').val('');
          alert(data);
          if(data=='Students were inserted successfully'){
            location.reload();
          }
        }
      })
    });
    // add students to class F
    $('#students_form6').on('submit', function(event){
      alert('You are going to update Class F');
      event.preventDefault();
      $.ajax({
        url:"<?php echo base_url(); ?>Student/addBulkStudentsToClass",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        cache:false,
        processData:false,
        success:function(data){
          $('#file6').val('');
          alert(data);
          if(data=='Students were inserted successfully'){
            location.reload();
          }
        }
      })
    });
    // add students to class G
    $('#students_form7').on('submit', function(event){
      alert('You are going to update Class G');
      event.preventDefault();
      $.ajax({
        url:"<?php echo base_url(); ?>Student/addBulkStudentsToClass",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        cache:false,
        processData:false,
        success:function(data){
          $('#file7').val('');
          alert(data);
          if(data=='Students were inserted successfully'){
            location.reload();
          }
        }
      })
    });
    // add students to class H
    $('#students_form8').on('submit', function(event){
      alert('You are going to update Class H');
      event.preventDefault();
      $.ajax({
        url:"<?php echo base_url(); ?>Student/addBulkStudentsToClass",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        cache:false,
        processData:false,
        success:function(data){
          $('#file8').val('');
          alert(data);
          if(data=='Students were inserted successfully'){
            location.reload();
          }
        }
      })
    });

    // පාසල  තෝරනවිට එම පාසලෙහි පවත්නා ශ්‍රේණි ලෝඩ් කිරීමට යොදා ගැනේ.
    // This is used by Admin other users except school
      $(document).on('change', '#select_year', function(){  
        //alert($(this).val());
        var year = $(this).val();
        //var year = $('#select_year').val();
  <?php if($role_id != '2'){ // if user is not a school ?>
          var census_id = $('#school_select').val();
  <?php }else{ ?>
          var census_id = $('#census_id_hidden').val();
  <?php } ?>
        //alert($census_id);
        if(!census_id){
          swal('Please select a school');
        }else if(!year){
          swal('Please select the year');
        }else{
          $.ajax({  
            url:"<?php echo base_url(); ?>SchoolGrades/viewGradesSchoolWise",  
            method:"POST",  
            data:{census_id:census_id,year:year},  
            dataType:"json",  
            success:function(classes)  
            {  
              if(!classes){
                swal('Classes not found!!!!')
                $('select#select_grade_of_stu').disabled();
                //$('select#select_grade_of_stu').html('Not Found');
              }else{
                $('select#select_grade_of_stu').html('');
                $.each(classes, function(key,value) {
                  $('select[name="select_grade_of_stu"]').append('<option value="'+ value.grade_id +'">'+ value.grade +'</option>');
                }); 
              }
            }, 
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            } 
          });
        }  
      });
<?php //} // if user is not a school ?>
  });
</script>

