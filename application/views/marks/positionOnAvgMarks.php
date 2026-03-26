<link href="<?php echo base_url(); ?>assets/css/sweetalert/sweetalert.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/buttons.dataTables.min.css" rel="stylesheet">

<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
<script type="text/javascript">
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
<style type="text/css">
  .swal1-popup {
    font-size: 2px;
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
        <li class="breadcrumb-item active">Student Position on Average Marks</li>
      </ol>
      <?php
        if(!empty($this->session->flashdata('msg'))) {
          $message = $this->session->flashdata('msg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php } ?> 
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
                Select following fields to search students' position
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <?php $attributes = array("class" => "form-inline", "id" => "import_marks_form", "name" => "import_marks_form", "role" => "search", "enctype" => "multipart/form-data");
                    echo form_open("Marks/import", $attributes); ?>
                      <fieldset>
                        <div class="form-group">
                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                              <label for="Year" class="label label-sm"> Year </label>
                            </div>
                            <div class="col-lg-1 col-sm-1">
                              <select class="form-control form-control-sm" id="year_select" name="year_select" title="Please select">
                                <option value="" selected>---Select---</option>
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
                    <?php if( $role_id != '2' ){ // admin ?>
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
                              <label for="Term"> Term </label>
                            </div>
                            <div class="col-lg-1 col-sm-1">
                              <select class="form-control form-control-sm" id="term_select" name="term_select">
                                <option value="" selected>---Select---</option>
                                <option value="1" > Term 1 </option>
                                <option value="2" > Term 2 </option>
                                <option value="3" > Term 3 </option>
                              </select>
                              <span class="text-danger" id="grade_error"><?php echo form_error('term_select'); ?></span>
                            </div>
                          </div> <!-- /row -->
                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                              <label for="Grade"> Grade </label>
                            </div>
                            <div class="col-lg-1 col-sm-1">
                              <select class="form-control form-control-sm" id="grade_select" name="grade_select" data-toggle="tooltip" title="Select a Grade">
                                <option value="" selected>------</option>
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
                              <label for="Class"> Class </label>
                            </div>
                            <div class="col-lg-1 col-sm-1">
                              <select class="form-control form-control-sm mb-1" id="class_select" name="class_select" data-toggle="tooltip" title="Select a Class">
                                <option value="" selected>------</option>
                              </select>
                              <span class="text-danger" id="class_error"><?php echo form_error('class_select'); ?></span>
                            </div>
                          </div> <!-- /row -->
                          <div class="row">
                            <div class="col-sm-12">
                        <?php if( $role_id=='2' ){ // school ?>
                                <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
                        <?php } ?>
                                <!-- Show button -->
                              <button id="btn_show" name="btn_show" type="button" class="btn btn-primary mr-1 btn-sm" value="Show"><i class="fa fa-fw fa-eye mr-1"> </i>Show</button>
                            </div>
                          </div>
                          <div class="row">   
                            <div class="col-sm-2 mt-0">
                              <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#helpModal"><i class="fa fa-question"></i></button>
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
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
                Students'Positions
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto"> 
                  <div class="table-responsive" id="termtest_data">

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
    </div> <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-child"></i> ශිෂ්‍යයන්ගේ ස්ථාන තේරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  1. Year තේරූ විට පමණක් Grade දිස්වේ. <br>
                  2. Grade තේරූ විට පමණක් Class දිස්වේ.  <br>
                  3. Class ‌තේරීම අනිවාර්ය නොවේ.<br>
                  

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#btn_show').click(function(){
        load_data();
      })
      function load_data(){
  <?php if( $role_id == 2 ){ // school ?>
          var census_id = $('#census_id_hidden').val();
  <?php }else{ ?>
          var census_id = $('#school_select').val();
  <?php } ?> 

        var year = $('#year_select').val();
        var term = $('#term_select').val();
        var grade = $('#grade_select').val();
        var class_id = $('#class_select').val();
        var subject_id = $('#subject_select').val();

        if( census_id=='' || year=='' || term=='' || grade=='' ){
          swal('Year, Term and Grade are required!!!');
        }else{
          $.ajax({
            url:"<?php echo base_url(); ?>Marks/positionOnAvgMarks",
            dataSrc: "Data",
            method:"POST",
            data:{census_id:census_id,year:year,term:term,grade_id:grade,class_id:class_id,subject_id:subject_id}, 
            success:function(data){
              if(data){
                $('#termtest_data').html(data);
                $('#btn_delete_marks').show();
              }
            }
          })
        }
      } // load_data()
     
    // ශ්‍රේණිය තෝරනවිට පන්තිය ලෝඩ් කිරීමට යොදා ගැනේ. 
    $(document).on('change', '#grade_select', function(){  
      var grade_id = $(this).val();
      var year = $('#year_select').val();
      //role_id-1=admin, role_id-2=school_user
  <?php if( $role_id == 2 ){ // school ?>
          var census_id = $('#census_id_hidden').val();
  <?php }else{ ?>
          var census_id = $('#school_select').val();
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
              if(!classes){
                swal('Classes not found!!!!')
                $('select#class_select').html('');
                $('select[name="class_select"]').append('<option value="">---No Classes---</option>').attr("selected", "true");   
              }else{
                $('select#class_select').html('');
                $('select[name="class_select"]').append('<option value="">---Select---</option>').attr("selected", "true");
                $.each(classes, function(key,value) {
                    $('select[name="class_select"]').append('<option value="'+ value.class_id +'">'+ value.class +'</option>');
                });
              }  
            }, 
            error: function(xhr, status, error) {
              alert(xhr.responseText);
            } 
        }) 
      }
    });
    // පාසල තෝරනවිට ශ්‍රේණිය ලෝඩ් කිරීමට යොදා ගැනේ. 
    // used by admin and other users except school
    <?php if( $role_id != '2' ){ // if user is not a school ?>
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
              if(!classes){ // here not classes but grades
                swal('Grades not found!!!!')
                $('select#grade_select').html('');
                $('select[name="grade_select"]').append('<option value="">---No Grades---</option>').attr("selected", "true");
                $('select#class_select').html('');
                $('select[name="class_select"]').append('<option value="">---No Classes---</option>').attr("selected", "true");
              }else{
                $('select#grade_select').html('');
                $('select[name="grade_select"]').append('<option value="">---Select Grade---</option>').attr("selected", "true");
                $('select#class_select').html('');
                $('select[name="class_select"]').append('<option value="">---Select Grade---</option>').attr("selected", "true");
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
                    $('select[name="class_select"]').append('<option value="">---Select Grade---</option>').attr("selected", "true");
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

<?php } // if user is a school ?>

  });
  </script>