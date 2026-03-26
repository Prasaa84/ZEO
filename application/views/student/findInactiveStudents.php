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
          <a href="<?php echo base_url(); ?>Student">Students</a>
        </li>
        <li class="breadcrumb-item active">Inactive Students</li>
      </ol>
      <?php
        if(!empty($this->session->flashdata('stActivateMsg'))) {
          $message = $this->session->flashdata('stActivateMsg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php } ?> 
<?php if($role_id=='1'){ // admin ?>
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
                      echo form_open("Student/viewInactiveStudents", $attributes); ?>
                        <fieldset>
                          <div class="form-group form-group-sm">
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
                            <div class="row">
                              <div class="col-lg-1 col-sm-1">
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
<?php } ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                  Inactive Students
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 my-auto">
                    <div class="table table-responsive" id="inactive_students_data">
                      <table class="table table-striped table-hover ">
                        <tr><th>Index No</th><th>Name</th><th>Gender</th><th>Grade</th><th>Class</th><th>Inserted On</th><th>Updated On</th><th>Activate</th><th>Remove</th></tr>
                <?php   if(!empty($allInactiveStudents)){ ?>
                <?php     foreach ($allInactiveStudents as $row) { 
                            $st_id = $row->st_id;
                            $index_no = $row->index_no;
                            $name_with_ini = $row->name_with_initials;
                            $gender = $row->gender_name;
                            $grade = $row->grade;
                            $class = $row->class;
                            $insert_date = $row->insert_dt;
                            $update_date = $row->update_dt;
                            $census_id = $row->update_dt;
                ?>
                          <tr id="<?php echo 'tbrow'.$st_id; ?>">
                            <td><?php echo $index_no; ?></td><td><?php echo $name_with_ini; ?></td><td><?php echo $gender; ?></td>
                            <td><?php echo $grade; ?></td>
                            <td><?php echo $class;  ?></td>
                            <td><?php echo $insert_date; ?></td>
                            <td><?php echo $update_date; ?></td>
                  <?php     $attributes = array("class" => "form-inline", "id" => "student_activate_form", "name" => "student_activate_form", "role" => "search", "enctype" => "multipart/form-data");
                            echo form_open("Student/activateStudent", $attributes); ?>
                              <input type="hidden" id="st_id_hidden" name="st_id_hidden" value="<?php echo $st_id; ?>" />
                              <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
                              <input type="hidden" id="index_no_hidden" name="index_no_hidden" value="<?php echo $index_no; ?>" />
                              <td>
                                <button class="btn btn-primary btn-sm" type="submit" name="confirm_btn" value="Change">Activate</button>
                              </td>
                              <td>
                                <a type="button" name="" class="btn btn-danger btn-sm btn_delete_student" value="Cancel" data-toggle="tooltip" title="Delete this student" data-id="<?php echo $st_id; ?>" ><i class="fa fa-trash-o"></i></a>
                              </td>
                  <?php     echo form_close(); ?>
                          </tr>
                <?php     } ?>
                  <?php }else{ echo '<tr><td colspan="7">No records found!!!</td></tr>'; }  ?>
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
    </div> <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
<script type="text/javascript">
 // Delete a student from the system temporaly. this must be included out side this statement
  // $(document).ready(function(){
  // otherwise when click on other pages in datatable, its not working
  $(".btn_delete_student").click(function(){
    var row_id = $(this).parents("tr").attr("id");
    var sid = $(this).attr("data-id");
    //alert(sid);
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
          url:"<?php echo base_url(); ?>Student/removeStudent",  
          method:"POST",  
          data:{sid:sid}, 
          error: function() {
            alert('Something is wrong');
          },
          success: function(data) {
              if(data.trim()=='1'){
                swal("Error!", "Term test marks exists.", "error");
              }else if(data.trim()=='2'){
                $("#"+row_id).remove();
                swal("Deleted!", "Student removed.", "success");
              }else{
                swal("Error!", "Error!!!.", "error");
              }
          }
        });
      } 
    });
   
  });
</script>