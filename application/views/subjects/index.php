<link href="<?php echo base_url(); ?>assets/css/sweetalert/sweetalert.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/datatables/css/buttons.dataTables.min.css" rel="stylesheet">

<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
  <?php
  foreach($this->session as $user_data){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if($role_id=='2'){
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
        <li class="breadcrumb-item active">Subjects</li>
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
                Select a Grade
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <?php $attributes = array("class" => "form-inline", "id" => "update_stf_pers_info_form", "name" => "find_subjects_of_grade", "role" => "search");
                    echo form_open("Subjects/viewSubjectsOfGrades", $attributes); ?>
                      <fieldset>
                        <div class="form-group">
                    <?php if( $role_id=='1' || $role_id=='7' ){ // admin ?>

                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                              <label for="Name with ini"> School </label>
                            </div>
                            <div class="col-lg-2 col-sm-2">
                              <select class="form-control form-control-sm" id="school_select" name="school_select">
                                <option value="" selected>Select</option>
                          <?php   
                                  $selected_school = set_value('school_select');
                                  foreach ($allSchools as $school){ 
                                    if($school->census_id == $selected_school){ 
                          ?>
                                      <option value="<?php echo $school->census_id; ?>" selected><?php echo $school->sch_name.'-'.$school->census_id; ?></option>
                          <?php     }else{ ?> 
                                      <option value="<?php echo $school->census_id; ?>"><?php echo $school->sch_name.'-'.$school->census_id; ?></option>
                          <?php     } 
                                  }
                          ?> 
                              </select>
                              <span class="text-danger" id="grade_error"><?php echo form_error('school_select'); ?></span>
                            </div>
                          </div> <!-- /row -->
                    <?php } ?>
                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                              <label for="Name with ini"> Year </label>
                            </div>
                            <div class="col-lg-2 col-sm-2">
                              <select class="form-control" id="year_select" name="year_select" title="Please select">
                                <option value="" selected>---Select Year---</option>
                                <?php 
                                  //$year = 2018;
                                  $year = date('Y');
                                  for($year; $year > 2019; $year--) {
                                    echo '<option value="'.$year.'" >'.$year.'</option>';
                                  }  
                                ?>                               
                              </select>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-1 col-sm-1">
                              <label for="Name with ini"> Grade </label>
                            </div>
                            <div class="col-lg-2 col-sm-2">
                              <select class="form-control" id="grade_select" name="grade_select">
                                <option value="" selected>---First Select Year---</option>
                              </select>
                              <span class="text-danger" id="grade_error"><?php echo form_error('grade_select'); ?></span>
                            </div>
                          </div> <!-- /row -->
                          <div class="row">
                            <div class="col-lg-2 col-sm-2">
                          <?php if($role_id=='2'){ // admin ?>
                                  <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
                          <?php } ?>
                                <!-- submit button -->
                              <input id="btn_view_subjects" name="btn_view_subjects" type="submit" class="btn btn-primary mr-2 mt-2" value="Show" />
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
                Subjects
              </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
            <?php if( !empty( $subjectsForGrade ) ) { //print_r($increment_data); die(); 
                    $attributes = array("class" => "form-horizontal", "id" => "add-subjects-for-grade", "name" => "add-subjects-for-grade");
                    echo form_open("Subjects/addSubjectsToGrade", $attributes);  
            ?>  
                  <fieldset>
                  <input type="hidden" name="grade_id_hidden" value="<?php echo $gradeId; ?>" />
                  <div class="table-responsive">
                    <table id="" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Subject</th> 
                          <th>Selected</th> 
                          <th>Category</th>   
                          <th>Year</th>
                          <th>Grade</th>                                                  
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 1;
                        $latest_upd_dt = 0;
                        foreach ($subjectsForGrade as $row){ 
                          $subj_id = $row['sub_id']; 
                          $subj_name = $row['sub_name'];
                          $selected = $row['selected'];
                          $year = $row['year'];
                          $subj_cat = $row['sub_cat_name'];  
                          //$grade_id = $row['grade_id'];  
                          $grade = $gradeName;  
                          $census_id = $row['census_id'];
                          if (isset($row['subj_upd_dt'])) {
                            $date_updated = $row['subj_upd_dt'];
                          } 
                        ?>
                        <tr>
                          <th width="100"><?php echo $no; ?></th>
                          <td style="vertical-align:middle"  width="400"><?php echo $subj_name; ?></td>
                          <td align="center">
                            <input type="checkbox" name="chkbox[]" value="<?php echo $subj_id; ?>" class="checkbox" style="float: left;" <?php if($selected=='yes'){ echo 'checked'; } ?> >
                          </td>
                          <td style="vertical-align:middle"  width="400"><?php echo $subj_cat; ?></td>
                          <td style="vertical-align:middle"  width="200"><?php echo $year; ?></td>
                          <td style="vertical-align:middle"  width="200"><?php echo $grade; ?></td>
                        </tr>
                  <?php $no++; } // end foreach($subjectsForGrade as $row){  ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3"></div>
                        <div class="col-lg-5 col-sm-5">
                          <input type="hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
                          <input type="hidden" name="year_hidden" value="<?php echo $year; ?>" />
                            <!-- submit button -->
            <?php if($role_id=='1' || $role_id=='2'){ // admin or school ?>
                          <input id="btn_save_subjects_to_grade" name="btn_save_subjects_to_grade" type="submit" class="btn btn-primary mr-2 mt-2" value="Save" />
                          <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#helpModal"><i class="fa fa-question"></i></button>
            <?php } // school ?>
                          <a href="<?php echo base_url(); ?>ExcelExport/printSelectedSubjectsOfGrade/<?php echo $census_id; ?>/<?php echo $gradeId ?>/<?php echo $year ?>" id="print" name="print" type="button" class="btn btn-success mt-2" style="margin-top: 10px;"><i class="fa fa-fw fa-print mr-1"></i> Print</a>
                        </div>
                        <div class="col-sm-2">
                        </div>
                      </div>
                    </div> <!-- /form group -->
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-3 col-sm-3"></div>
                          <div class="col-lg-5 col-sm-5">
                              <!-- submit button -->
                          </div>
                          <div class="col-sm-2">
                          </div>
                        </div>
                      </div> <!-- /form group -->
                    </fieldset>
                <?php echo form_close(); ?>
                <?php }else{ // if empty($acStaffDetails)
                    if(($userrole=='School User') && empty($acStaffDetails)){
                      echo '<h4 align="center">Please select a grade</h4>'; 
                    }else if(($userrole=='Administrator') && empty($acStaffDetails)){
                      echo '<h4 align="center">Add or Search Records!!!</h4>'; 
                    }else{
                      echo '<h4 align="center">Search Details</h4>';
                    }
                  } ?>  
              </div> 
            </div> <!-- /col-lg-12 -->
            </div>
            <div class="card-footer small text-muted">
              <?Php 
                // view database updated date and time
                if(!empty($date_updated)){
                  $last_update_dt = strtotime($date_updated);
                  $phy_res_details_last_updated_on_date = date("j F Y",$last_update_dt);
                  $phy_res_details_last_updated_on_time = date("h:i A",$last_update_dt);
                  echo 'Updated on '.$phy_res_details_last_updated_on_date.' at '.$phy_res_details_last_updated_on_time;
                }
                
              ?>
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
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> ශ්‍රේණියකට විෂයයන් ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  1. මුලින් වර්ෂය තෝරා ඉන්පසු ශ්‍රේණිය තෝරන්න. <br>
                  2. ඉන්පසු Show button ක්ලික් කරන්න. <br>
                  3. එවිට ශ්‍රේණිය අයත් අංශයට අදාළ සියළුම විෂයන් පෙන්නුම් කරයි. <br>
                  4. එවිට ශ්‍රේණිය අයත් අංශයට (1-5/6-11/12-13) අදාළ සියළුම විෂයන් පෙන්නුම් කරයි. <br>
                  5. ඔබගේ ශ්‍රේණියට අයත් විෂයන් තෝරා Save ක්ලික් කරන්න. <br>
                  6. නැවත පිටුව reload වන විට Save කරන ලද විෂයයන් Select වී ඇති බව දැකිය හැක. <br>
                  7. නැවත වරක් තවත් විෂයක් ඇතුළත් කිරීමට අවශ්‍ය වුවහොත් එම විෂය තෝරා නැවත Save කරන්න. <br>
                  8. ඇතුළත් කරන ලද විෂයන් අතරින්, විෂයන් ඉවත් කිරීමට අවශ්‍ය වුවහොත්, එම විෂයන් Deselect කර නැවත Save කරන්න. <br>
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
    <?php //if($role_id == '2'){ // if the user is school ?>
              // වර්ෂය තෝරනවිට ශ්‍රේණිය ලෝඩ් කිරීමට යොදා ගැනේ. 
              // used by school user
              $(document).on('change', '#year_select', function(){  
                var year = $(this).val();
          <?php if($role_id == '2'){ // if the user is school ?>
                  var census_id = $('#census_id_hidden').val();
          <?php }else{  ?>
                  var census_id = $('#school_select').val();
          <?php } ?>
                if(!census_id){
                  swal('Please select the school')
                }else{
                  $.ajax({  
                      url:"<?php echo base_url(); ?>SchoolGrades/viewGradesSchoolWise",  
                      method:"POST",  
                      data:{census_id:census_id,year:year},  
                      dataType:"json",  
                      success:function(grades)  
                      {  
                        if(!grades){
                          swal('Grades not found!!!!')
                          $('select#grade_select').html('');
                          $('select[name="grade_select"]').append('<option value="">---No Grades---</option>').attr("selected", "true");
                        }else{
                          $('select#grade_select').html('');
                          $('select[name="grade_select"]').append('<option value="">---Select Grade---</option>').attr("selected", "true");
                          $.each(grades, function(key,value) {
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
    <?php  //} // if user is not a school ?>
  })
</script>