<link href="<?php echo base_url(); ?>assets/css/sweetalert/sweetalert.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/buttons.dataTables.min.css" rel="stylesheet">

<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
<style type="text/css">
  .swal1-popup {
    font-size: 2px;
  }
  .swal2-popup {
    font-size: 2px;
    font-family: Georgia, serif;
  }
  .sweet-alert{
    font-size: 5px;
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
          <a href="<?php echo base_url(); ?>Marks">Marks</a>
        </li>
        <li class="breadcrumb-item active">Finalize Marks</li>
      </ol>
      <?php
        if(!empty($this->session->flashdata('marksConfirmMsg'))) {
          $message = $this->session->flashdata('marksConfirmMsg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php } ?> 
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
                Select a Grade
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <?php $attributes = array("class" => "form-inline", "id" => "import_marks_form", "name" => "import_marks_form", "role" => "search", "enctype" => "multipart/form-data");
                    echo form_open("Marks/confirmMarks", $attributes); ?>
                      <fieldset>
                        <div class="form-group form-group-sm">
                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                              <label for="Name with ini" class="label-sm"> Year </label>
                            </div>
                            <div class="col-lg-1 col-sm-1">
                              <select class="form-control form-control-sm" id="year_select" name="year_select" title="Please select">
                                <option value="" selected>---Select Year---</option>
                                <?php 
                                  //$year = 2018;
                                  $year = date('Y');
                                  for($year; $year > 2019; $year--) {
                                    echo '<option value="'.$year.'" >'.$year.'</option>';
                                  }  
                                ?>                               
                              </select>
                              <span class="text-danger" id="grade_error"><?php echo form_error('year_select'); ?></span>
                            </div>
                          </div>
                    <?php if($role_id=='1'){ // admin ?>
                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                              <label for="school"> School </label>
                            </div>
                            <div class="col-lg-1 col-sm-1">
                              <select class="form-control form-control-sm" id="school_select" name="school_select">
                                <option value="" selected>Select</option>
                          <?php   
                                  $selected_school = set_value('school_select');
                                  foreach ($allSchools as $school){ 
                                    if($school->census_id == $selected_school){ 
                          ?>
                                      <option value="<?php echo $school->census_id; ?>" selected><?php echo $school->sch_name; ?></option>
                          <?php     }else{ ?> 
                                      <option value="<?php echo $school->census_id; ?>"><?php echo $school->sch_name.' '.$school->census_id; ?></option>
                          <?php     } 
                                  }
                          ?> 
                              </select>
                              <span class="text-danger" id="school_error"><?php echo form_error('school_select'); ?></span>
                            </div>
                          </div> <!-- /row -->
                    <?php } ?>
                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                              <label for="Name with ini"> Term </label>
                            </div>
                            <div class="col-lg-1 col-sm-1">
                              <select class="form-control form-control-sm" id="term_select" name="term_select">
                                <option value="" selected>---Select a term---</option>
                                <option value="1" > Term 1 </option>
                                <option value="2" > Term 2 </option>
                                <option value="3" > Term 3 </option>
                              </select>
                              <span class="text-danger" id="grade_error"><?php echo form_error('term_select'); ?></span>
                            </div>
                          </div> <!-- /row -->
                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                              <label for="Name with ini"> Grade </label>
                            </div>
                            <div class="col-lg-1 col-sm-1">
                              <select class="form-control form-control-sm" id="grade_select" name="grade_select" data-toggle="tooltip" title="Select a Grade">
                                <option value="" selected>---First Select Year---</option>
                          <?php   //if($role_id=='2'){
                                    $selected_grade = set_value('grade_select');
                                    foreach ($allGrades as $grade){ 
                                      if($grade->grade_id == $selected_grade){ 
                          ?>
                                        <option value="<?php echo $grade->grade_id; ?>" selected><?php echo $grade->grade; ?></option>
                          <?php       }else{ ?> 
                                        <option value="<?php echo $grade->grade_id; ?>"><?php echo $grade->grade; ?></option>
                          <?php       } 
                                    }
                                 // }//else{ ?>

                              </select>
                              <span class="text-danger" id="grade_error"><?php echo form_error('grade_select'); ?></span>
                            </div>
                          </div> <!-- /row -->
                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                              <label for="Name with ini"> Class </label>
                            </div>
                            <div class="col-lg-1 col-sm-1">
                              <select class="form-control form-control-sm" id="class_select" name="class_select">
                                <option value="" selected>---First Select Grade---</option>
                              </select>
                              <span class="text-danger" id="class_error"><?php echo form_error('class_select'); ?></span>
                            </div>
                          </div> <!-- /row -->
                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                        <?php if($role_id=='2'){ //  ?>
                                <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
                        <?php } ?>
                                <!-- Show button -->
                              <input id="btn_confirm_marks" name="btn_confirm_marks" type="submit" class="btn btn-primary mr-2 btn-sm" value="Confirm" title="Confirm marks"/>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                        <?php if($role_id=='2'){ //  ?>
                                <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
                        <?php } ?>
                                <!-- Show button -->
                              <button id="btn_view_confirm_status" name="btn_view_confirm_status" type="submit" class="btn btn-info mr-2 btn-sm" value="Check" title="Check the status"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
                          </div>
                        </div> <!-- /form group -->
                      </fieldset>
                    <?php echo form_close(); ?>
                </div> <!-- /col-lg-12 -->
              </div> <!-- /row -->
            </div> <!-- /card-body -->
          </div> <!-- /card mb-3 -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row -->
<?php if(!empty($confirmResult)){ ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                  Confirmation Status
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 my-auto">
                    <div class="table-responsive" id="termtest_confirm_data">
                      <table class="table table-hover" id="dataTable">
                        <thead>
                          <tr><th>Year</th><th>Term</th><th>Grade</th><th>Class</th><th>Status</th><th>Updated On</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                <?php     foreach ($confirmResult as $row) { 
                            $marks_conf_id = $row->marks_conf_id;
                            $census_id = $row->census_id;
                            $grade_id = $row->grade_id;
                            $class_id = $row->class_id;
                            $year = $row->year;
                            $term = $row->term;
                ?>
                          <tr>
                            <td><?php echo $row->year; ?></td><td><?php echo $row->term; ?></td><td><?php echo $row->grade; ?></td>
                            <td><?php echo $row->class; ?></td>
                            <td><?php if($row->is_completed){ echo 'Çonfirmed'; }else{ echo 'Not Confirmed'; } ?></td>
                            <td><?php echo $row->update_date; ?></td>
                  <?php     $attributes = array("class" => "form-inline", "id" => "import_marks_form", "name" => "import_marks_form", "role" => "search", "enctype" => "multipart/form-data");
                            echo form_open("Marks/unConfirmMarks", $attributes); ?>
                              <input type="hidden" id="id_hidden" name="id_hidden" value="<?php echo $marks_conf_id; ?>" />
                              <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
                              <input type="hidden" id="grade_id_hidden" name="grade_id_hidden" value="<?php echo $grade_id; ?>" />
                              <input type="hidden" id="class_id_hidden" name="class_id_hidden" value="<?php echo $class_id; ?>" />
                              <input type="hidden" id="year_hidden" name="year_hidden" value="<?php echo $year; ?>" />
                              <input type="hidden" id="term_hidden" name="term_hidden" value="<?php echo $term; ?>" />
                            <td>
                  <?php       if($row->is_completed){ ?>
                                <button class="btn btn-primary btn-sm" type="submit" name="unconfirm_btn" value="Change">Unconfirm</button>
                  <?php       }else{ ?>
                                <button class="btn btn-primary btn-sm" type="submit" name="confirm_btn" value="Change">Confirm</button>
                  <?php       } ?>
                            </td>
                  <?php     echo form_close(); ?>
                          </tr>
                <?php     } ?>
                        </tbody>
                      </table>
                    </div>                    
                  </div> 
                </div> <!-- /col-lg-12 -->
              </div>
              <div class="card-footer small text-muted">
                <span id="updated_dt_span"></span>
              </div>
            </div>
          </div>
        </div>
<?php }  ?>
    </div> <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
<script type="text/javascript">
  $(document).ready(function(){

    $('#dataTable').DataTable({
      pageLength: '15'
    });

    // ශ්‍රේණිය තෝරනවිට පන්තිය ලෝඩ් කිරීමට යොදා ගැනේ. 
    $(document).on('change', '#grade_select', function(){  
      var grade_id = $(this).val();
      var year = $('#year_select').val();
      //role_id-1=admin, role_id-2=school_user
      <?php if($role_id==1){ ?>
              var census_id = $('#school_select').val();
      <?php } ?> 
      <?php if($role_id==2){ ?>
              var census_id = $('#census_id_hidden').val();
      <?php } ?> 
      if(!census_id){
        swal('Please select a school');
      }else if(!year){
        swal('Please select the year');
      }else{
        $.ajax({  
            url:"<?php echo base_url(); ?>SchoolClasses/viewClassesGradeWise",  
            method:"POST",  
            data:{grade_id:grade_id,census_id:census_id,year:year},  
            dataType:"json",  
            success:function(classes)  
            {  
               $('select#class_select').html('');
                $.each(classes, function(key,value) {
                    $('select[name="class_select"]').append('<option value="'+ value.class_id +'">'+ value.class +'</option>');
                }); 
            }, 
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            } 
        }) 
      }
    });

    // පාසල තෝරනවිට ශ්‍රේණිය ලෝඩ් කිරීමට යොදා ගැනේ. 
    // used by admin and other users except school
    <?php if($role_id != '2'){ // if user is not a school ?>
      $(document).on('change', '#school_select', function(){  
        var census_id = $(this).val();
        var year = $('#year_select').val();
        if(!year){
          swal('Please select the year');
        }else{
          $.ajax({  
            url:"<?php  echo base_url(); ?>SchoolGrades/viewGradesSchoolWise",  
            method:"POST",  
            data:{census_id:census_id,year:year},  
            dataType:"json",  
            success:function(classes)  
            {  
              if(!classes){
                swal('Grades not found!!!!')
                $('select#grade_select').html('');
                $('select[name="grade_select"]').append('<option value="">---No Grades---</option>').attr("selected", "true");
                $('select#class_select').html('');
                $('select[name="class_select"]').append('<option value="">---No Classes---</option>').attr("selected", "true");
              }else{
                $('select#grade_select').html('');
                $('select[name="grade_select"]').append('<option value="">---Select Grade---</option>').attr("selected", "true");
                $('select#class_select').html('');
                $('select[name="class_select"]').append('<option value="">---Select Class---</option>').attr("selected", "true");
                $.each(classes, function(key,value) {
                  $('select[name="grade_select"]').append('<option value="'+ value.grade_id +'">'+ value.grade +'</option>');
                }); 
              }
            }, 
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            } 
          })
        }  
      });
    <?php  } // if user is not a school ?>
    <?php if($role_id == '2'){ // if the user is school ?>
              // වර්ෂය තෝරනවිට ශ්‍රේණිය ලෝඩ් කිරීමට යොදා ගැනේ. 
              // used by school user
              $(document).on('change', '#year_select', function(){  
                var year = $(this).val();
                var census_id = $('#census_id_hidden').val();
                if(!year){
                  alert('Please select the year')
                }else{
                  $.ajax({  
                      url:"<?php echo base_url(); ?>SchoolGrades/viewGradesSchoolWise",  
                      method:"POST",  
                      data:{census_id:census_id,year:year},  
                      dataType:"json",  
                      success:function(classes)  
                      {  
                        if(!classes){
                          swal('Grades not found!!!!')
                          $('select#grade_select').html('');
                          $('select[name="grade_select"]').append('<option value="">---No Grades---</option>').attr("selected", "true");
                          $('select#class_select').html('');
                          $('select[name="class_select"]').append('<option value="">---No Classes---</option>').attr("selected", "true");
                          //$('select#select_grade_of_stu').html('Not Found');
                        }else{
                          $('select#grade_select').html('');
                          $('select[name="grade_select"]').append('<option value="">---Select Grade---</option>').attr("selected", "true");
                          $('select#class_select').html('');
                          $('select[name="class_select"]').append('<option value="">---Select Class---</option>').attr("selected", "true");
                          $.each(classes, function(key,value) {
                            $('select[name="grade_select"]').append('<option value="'+ value.grade_id +'">'+ value.grade +'</option>');
                          }); 
                        }
                      }, 
                      error: function(xhr, status, error) {
                        alert(xhr.responseText);
                      } 
                  }) 
                }
              });
    <?php  } // if user is not a school ?>

  });
  </script>