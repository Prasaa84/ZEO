<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#dataTable1').DataTable({
      pageLength: '15',
        //dom: 'Bfrtip',
        // buttons: [
        //   {
        //     extend: 'excel',
        //     text: 'Save',
        //     exportOptions: {
        //         modifier: {
        //             page: 'All'
        //         }
        //     }
        //   }
        // ]
      });
  });
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
  <?php
  foreach( $this->session as $user_data ){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if( $role_id=='2'){
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
        <li class="breadcrumb-item active">Grades</li>
      </ol>
<?php
      if(!empty($this->session->flashdata('grdMsg'))) {
        $message = $this->session->flashdata('grdMsg');  ?>
        <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
<?php } ?> 
      <div class="row" id="search-bar-row">    
        <div class="col-lg-12 col-sm-12">
          <form class="form-inline mb-1" id="srch_grades_by_school" name="srch_grades_by_school" action="<?php echo base_url(); ?>SchoolGrades/viewSchoolGrades" method="POST">
            <label for="year_select" class="mb-2 ml-2 mr-sm-2 label label-sm" >Academic Year : </label>
            <select class="form-control mb-2 mr-sm-2 form-control-sm" id="year_select" name="year_select" title="Please select">
                <option value="" selected>---Select the Year---</option>
            <?php 
                $year = date('Y');
                $selected_year = set_value('year_select');
                for( $year; $year > 2019; $year-- ) {
                  if( $year == $selected_year ){ 
                    echo '<option value="'.$year.'" >'.$year.'</option>';
                  }else{ 
                    echo '<option value="'.$year.'" >'.$year.'</option>';
                  } 
                }
            ?>                              
            </select>
            <span class="text-danger" id="year_error"><?php //echo form_error('year_select'); ?></span>
      <?php if( $role_id != '2' ){ ?>
              <label for="select_school" class="mb-2 mr-sm-2 label label-sm" > School : </label>
              <select class="form-control form-control-sm mb-2 mr-sm-2" id="select_school" name="select_school" title="Please select">
                <option value="" selected>---Select the School---</option>
          <?php   
                  $selected_school = set_value('select_school');
                  foreach ( $all_schools as $school ){ 
                    if( $school->census_id == $selected_school ){ 
          ?>
                      <option value="<?php echo $school->census_id; ?>" selected><?php echo $school->sch_name; ?></option>
          <?php     }else{ ?> 
                      <option value="<?php echo $school->census_id; ?>"><?php echo $school->sch_name.' '.$school->census_id; ?></option>
          <?php     } 
                  }
          ?> 
              </select>
      <?php }else{  ?>
              <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
      <?php } ?> 
            <button type="submit" class="btn btn-info mb-2 mr-2 btn-sm" name="btn_view_grades_by_school" value="View" id="btn_view_grades_by_school"><i class="fa fa-search"></i> View </button>
          </form> <!-- /form -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / #search-bar-row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
                පාසල තුළ පවත්නා ශ්‍රේණි 
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">  
                    <?php 
                      if(!empty($schoolGrades)){ //existing grades for this school
                        foreach ($schoolGrades as $school) {
                          $sch_name = $school->sch_name;
                          $year = $school->year; 
                        }
                        echo $sch_name.' - '.$year;
                      }
                    ?>
                  </h5>
                  <div>
                    <button type="button" name="" class="btn btn-success btn-sm" value="" data-toggle="modal" data-target="#addNewGrade" id="btn_add_new_grade"><i class="fa fa-plus"></i> New Grade </button> 
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#helpModal"><i class="fa fa-question"></i></button>
                  </div>
                  <br>
                  <?php if(!empty($schoolGrades)) { //print_r($increment_data); die(); ?>   
                  <div class="table-responsive">
                    <table id="dataTable1" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> වර්ෂය </th>
                          <th> ශ්‍රේණි </th>
                          <th> මුළු ළමයින් සංඛ්‍යාව</th>
                          <th> ඇතුළත් කරන ලද ළමයින් සංඛ්‍යාව</th>
                          <th> ශ්‍රේණි භාරකාරත්වය </th>
                          <th></th><th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ( $schoolGrades as $row ){  
                          $sch_grd_id = $row->sch_grd_id; // used to delete
                          $grade_id = $row->grade_id;
                          $grade = $row->grade;
                          $census_id = $row->school_id;
                          $year = $row->year;
                          $stf_nic = $row->stf_nic;
                          $grade_head = $row->name_with_ini;
                          $update_dt = $row->updated_dt;
                          $year = $row->year;
                          if( $latest_upd_dt < $update_dt ){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  
                          $ci = & get_instance();
                          $ci->load->model('SchoolGrade_model');
                          // no of students that must be in a grade
                          $student_count = $ci->SchoolGrade_model->get_student_count_of_a_grade($census_id,$grade_id,$year);
                          $exist_std_count = $ci->Student_model->get_student_count_of_a_grade($census_id,$grade_id,$year);

                    ?>
                                            
                        <tr id="<?php echo 'tbrow'.$sch_grd_id; ?>">
                      <?php
                        $attributes = array("class" => "form-horizontal", "class" => "update-grades", "name" => "update-grades");
                        echo form_open("SchoolGrades/updateSchoolGrade", $attributes); ?> 
                          <input type="hidden" value="<?php echo $sch_grd_id; ?>" name="sch_grd_id_hidden" />
                          <input type="hidden" value="<?php echo $census_id; ?>" name="census_id_hidden" />
                          <input type="hidden" value="<?php echo $grade_id; ?>" name="grd_id_hidden" />
                          <th style="vertical-align:middle;"><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $year; ?></td>
                          <td style="vertical-align:middle;"><?php echo $grade; ?></td>
                          <td style="vertical-align:middle" ><center><?php echo $student_count; ?></center> </td>
                          <td style="vertical-align:middle" ><center><?php echo $exist_std_count; ?> </center> </td>
                          <td style="vertical-align:middle" >
                            <select class="form-control" id="grade_head_select" name="grade_head_select">
                      <?php   if(!empty($grade_head)){ ?>
                                <option value="<?php echo $stf_nic; ?>" selected><?php echo $grade_head; ?></option>
                      <?php   }else{ ?>
                                <option value="">---Select---</option>
                      <?php   }     ?>
                      <?php   foreach ($schoolStaff as $row){ ?> 
                                <option value="<?php echo $row->nic_no; ?>"><?php echo $row->name_with_ini; ?></option>
                      <?php   } ?>
                              <option value="">---Select---</option>
                            </select>
                          </td>
                    <?php if( $role_id == 1 || $role_id==2 ){  ?>
                            <td style="vertical-align:middle" >
                              <button class="btn btn-primary btn-sm" type="submit" name="btn_update_sch_grd" value="Save" ><i class="fa fa-floppy-o"></i> Update</button>
                            </td>
                            <td style="vertical-align:middle" >
                              <a type="button" id="btn_delete_grade" name="btn_delete_grade" type="button" class="btn btn-info btn-sm btn_delete_grade" value="delete_grade" title="Click to Delete" data-toggle="tooltip" data-hidden="" data-id="<?php echo $sch_grd_id; ?>" ><i class="fa fa-trash"></i></a>
                            </td>
                    <?php } ?>
                    <?php echo form_close(); ?>
                        </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php }else{ // if empty($acStaffDetails)
                        if(($userrole=='School User') && empty($schoolGrades)){
                          echo '<h4 align="center">No Records!!!... Please assign grades to your school.</h4>'; 
                        }else{
                          echo 'No Grades Found!!!';
                        }
                      } ?>  
                </div> <!-- /col-lg-12 -->
              </div> <!-- /row -->
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php 
                if(!empty($schoolGrades)) { 
                  $latest_upd_dt = strtotime($latest_upd_dt);
                  $grade_update_dt = date("j F Y",$latest_upd_dt);
                  $grade_update_tm = date("h:i A",$latest_upd_dt);
                  echo 'Updated on '.$grade_update_dt.' at '.$grade_update_tm;
                }
              ?>
            </div> <!-- /footer -->
          </div> <!-- /card mb-3 -->
        </div> <!-- /col lg-10-->      
      </div>  <!-- /row--> 
       
    </div> <!-- /.container-fluid-->
  </div> <!-- /.content-wrapper-->
        
  <!-- /following bootstrap model used to assign grades to a school  -->
  <div class="modal fade" id="addNewGrade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> ශ්‍රේණි ඇතුළත් කිරීම </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 my-auto">
                <?php
                  $attributes = array("class" => "form-horizontal", "id" => "assign-grades", "name" => "assign-grades");
                  echo form_open("SchoolGrades/addSchoolGrade", $attributes); ?>                  
                    <fieldset>
                <?php if($role_id != '2'){ // if user is not a school ?>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-5 col-sm-5">
                            <label for="new category" class="control-label"> පාසල </label>
                          </div>
                          <div class="col-lg-7 col-sm-7">
                              <select class="form-control" id="select_school_in_modal_form" name="select_school_in_modal_form" title="Please select">
                                  <option value="" selected>---Select the School---</option>
                            <?php   
                                    $selected_school = set_value('select_school_in_modal_form');
                                    foreach ($all_schools as $school){ 
                                      if($school->census_id == $selected_school){ 
                            ?>
                                        <option value="<?php echo $school->census_id; ?>" selected><?php echo $school->sch_name; ?></option>
                            <?php     }else{ ?> 
                                        <option value="<?php echo $school->census_id; ?>"><?php echo $school->sch_name.' '.$school->census_id; ?></option>
                            <?php     } 
                                    }
                            ?> 
                              </select>
                          </div>
                        </div> <!-- /row -->
                      </div> <!-- /form group --> 
              <?php   } // if user is not a school ?> 
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-5 col-sm-5">
                            <label for="new category" class="control-label"> වර්ෂය </label>
                          </div>
                          <div class="col-lg-7 col-sm-7">
                            <select class="form-control mb-2 mr-sm-2" id="year_select_new_grade" name="year_select_new_grade" title="Please select">
                              <option value="" selected>---ක්ලික් කරන්න---</option>
                          <?php 
                              $year = date('Y');
                              $selected_year = set_value('year_select_new_grade');
                              for( $year; $year > 2019; $year-- ) {
                                if( $year == $selected_year ){ 
                                  echo '<option value="'.$year.'" >'.$year.'</option>';
                                }else{ 
                                  echo '<option value="'.$year.'" >'.$year.'</option>';
                                } 
                              }
                          ?>                              
                            </select>
                          </div>
                        </div> <!-- /row -->
                      </div> <!-- /form group --> 
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-5 col-sm-5">
                            <label for="new category" class="control-label"> ශ්‍රේණිය   </label>
                          </div>
                          <div class="col-lg-7 col-sm-7">
                            <select class="form-control" id="grade_select" name="grade_select">
                              <option value="" selected>---ක්ලික් කරන්න---</option>
                              <?php foreach ($allGrades as $row){ ?> <!-- all the grades as in grade span -->
                                <option value="<?php echo $row->grade_id; ?>"><?php echo $row->grade; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div> <!-- /row -->
                      </div> <!-- /form group --> 
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-5 col-sm-5">
                            <label for="new category" class="control-label"> ශ්‍රේණි භාරකාරත්වය    </label>
                          </div>
                          <div class="col-lg-7 col-sm-7">
                            <select class="form-control" id="grd_head_select" name="grd_head_select">
                              <option value="" selected>---ක්ලික් කරන්න---</option>
                        <?php   if($role_id == '2'){ // if user is a school ?>
                        <?php     foreach ($schoolStaff as $row){ ?> 
                                    <option value="<?php echo $row->nic_no; ?>"><?php echo $row->name_with_ini; ?></option>
                        <?php   } } ?>
                            </select>
                          </div>
                        </div> <!-- /row -->
                      </div> <!-- /form group -->
                    </fieldset> 
              <!-- <fieldset> -->
            </div> <!-- /col-sm-12 -->
          </div> <!-- /row -->
        </div> <!-- /modal-body -->
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" type="submit" name="btn_add_sch_grd" value="Add_Classes">Add</button>
        </div> <!-- /modal-footer -->
        </fieldset>
            <?php echo form_close(); ?>
      </div> <!-- /#bootstrap model content -->
    </div> <!-- /#bootstrap model dialog -->
  </div> <!-- / .modal fade -->
  <!------------------------- Help Modal - instructions for inserting new classes  --------------->
  <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> නව ශ්‍රේණි ඇතුළත් කිරීම </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  1. New Grade මත ක්ලික් කරන්න. <br>
                  2. ලැබෙන modal dialog box තුළින් වර්ෂය සහ ශ්‍රේණිය තෝරන්න.Drop down menu තුළින් ලැබෙනුයේ ඔබේ පාසලේ පන්ති පරාසයට අදාළ ශ්‍රේණි පමණි. <br>
                  3. ශ්‍රේණි භාරකාරත්වය අනිවාර්ය නොවන අතර එය පසුව ද යාවත්කාලීන කල හැකිය. <br>
                  5. ක්ලික් Add Button. <br> 
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- /.container-fluid-->
      <!-- /following bootstrap model used to send message -->
  <script type="text/javascript">
    $(document).ready(function(){
      // පාසල තෝරනවිට ශ්‍රේණිය ලෝඩ් (Not school grades but according to grade span wise) කිරීමට යොදා ගැනේ. 
      // used by admin
    <?php if($role_id == '1'){ // if user is not a school ?>
      $(document).on('change', '#select_school_in_modal_form', function(){  
        var census_id = $(this).val();
        if(!census_id){
          swal('Please select the school');
        }else{
          $.ajax({  
            url:"<?php  echo base_url(); ?>SchoolGrades/viewGradesAsGradeSpanWise",  
            method:"POST",  
            data:{census_id:census_id},  
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
      // පාසල තෝරනවිට staff ලෝඩ් කිරීමට යොදා ගැනේ. 
      // used by admin
      $(document).on('change', '#select_school_in_modal_form', function(){  
        var census_id = $(this).val();
        if(!census_id){
          swal('Please select the school');
        }else{
          $.ajax({  
            url:"<?php  echo base_url(); ?>Staff/viewStaffSchoolWise",  
            method:"POST",  
            data:{census_id:census_id},  
            dataType:"json",  
            success:function(staff)  
            {  
              if(!staff){
                swal('Staff not found!!!!')
                $('select#grd_head_select').html('');
                $('select[name="grd_head_select"]').append('<option value="">---No Staff---</option>').attr("selected", "true");
              }else{
                $('select#grd_head_select').html('');
                $('select[name="grd_head_select"]').append('<option value="">---Select Staff---</option>').attr("selected", "true");
                $.each(staff, function(key,value) {
                  $('select[name="grd_head_select"]').append('<option value="'+ value.nic +'">'+ value.name_with_ini +'</option>');
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

    // delete a school grade
  $(".btn_delete_grade").click(function(){
      var row_id = $(this).parents("tr").attr("id");
      var sch_grd_id = $(this).attr("data-id");
      //alert(sch_grd_id);
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
            url:"<?php echo base_url(); ?>SchoolGrades/deleteSchoolGrade",  
            method:"POST",  
            data:{sch_grd_id:sch_grd_id}, 
            error: function() {
              alert('Something is wrong, confirm classes and students exist');
            },
            success: function(data) {
              console.log(data);
              if( data.trim()=='2' ){
                $("#"+row_id).remove();
                swal("Deleted!", "Grade deleted successfully.", "success");
              }else if( data.trim()=='1' ){
                swal("Oooops!", "Classes exists!!!", "error");
              }else if( data.trim()=='3' ){
                swal("Error!", "Grade not deleted!!!", "error");
              }else{
                swal("Error!", "Something is wrong  !!!", "error");
              }
            }
          });
        } 
      });
     
    });
    // empty field validation in add new class bootstrap modal
    $("#assign-grades").submit(function(){

      var year = $('#year_select_new_grade').val(); 
      var grade = $('#grade_select').val(); 

      if( !(year) ){
        swal("Error!", "Require the Year", "warning");
        return false;    
      }else if( !(grade) ){
        swal("Error!", "Require the Grade", "warning");
        return false;    
      }else{ return true; }    

    });
  });

</script>

