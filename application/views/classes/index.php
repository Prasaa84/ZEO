<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
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
  foreach($this->session as $user_data){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if($role_id=='2'){
      $census_id = $user_data['census_id'];
      echo $school_name = $user_data['school_name'];
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
        <li class="breadcrumb-item active">Classes</li>
      </ol>
<?php
      if( !empty($this->session->flashdata('clsMsg')) ) {
        $message = $this->session->flashdata('clsMsg');  ?>
        <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
<?php } ?>
      <div class="row" id="search-bar-row">    
        <div class="col-lg-12 col-sm-12">
          <form class="form-inline mb-1" id="srch_classes_by_school" name="srch_classes_by_school" action="<?php echo base_url(); ?>SchoolClasses/viewSchoolClasses" method="POST">
            <label for="year_select" class="mb-2 ml-2 mr-sm-2 label-sm" >Academic Year : </label>
            <select class="form-control form-control-sm mb-2 mr-sm-2" id="year_select" name="year_select" title="Please select">
                <option value="" selected>---Select the Year---</option>
            <?php 
                $year = date('Y');
                $selected_year = set_value('year_select');
                for($year; $year > 2019; $year--) {
                  if($year == $selected_year){ 
                    echo '<option value="'.$year.'" >'.$year.'</option>';
                  }else{ 
                    echo '<option value="'.$year.'" >'.$year.'</option>';
                  } 
                }
            ?>                              
            </select>
    <?php if( $role_id != '2' ){ ?>
            <label for="select_school" class="mb-2 mr-sm-2 label-sm" > School : </label>
            <select class="form-control form-control-sm mb-2 mr-sm-2" id="select_school" name="select_school" title="Please select">
              <option value="" selected>---Select the School---</option>
        <?php   
                $selected_school = set_value('select_school');
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
    <?php }else{  ?>
              <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo $census_id; ?>" />
    <?php } ?> 
            <button type="submit" class="btn btn-info mb-2 mr-sm-2 btn-sm" name="btn_view_classes" value="View" id="btn_view_classes"><i class="fa fa-search"></i> View </button>
            </div> <!-- /input-group -->
          </form> <!-- /form -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / #search-bar-row -->
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
                පාසල තුළ පවත්නා සමාන්තර පන්ති 
              </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">  
                    <?php 
                      if(!empty($schoolClasses)){
                        foreach ($schoolClasses as $row) {
                          $sch_name = $row->sch_name;
                          $year = $row->year; 
                        }
                        echo $sch_name.' - '.$year;
                      }
                    ?>
                  </h5>
                  <div >
                    <button type="button" name="" class="btn btn-success btn-sm" value="" data-toggle="modal" data-target="#addClassModal" ><i class="fa fa-plus"></i>  New Class</button>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#helpModal"><i class="fa fa-question"></i></button>
                  </div>
                  <br>
                  <?php if(!empty($schoolClasses)) { //print_r($increment_data); die(); ?>   
                  <div class="table-responsive">
                    <table id="dataTable1" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> පන්තිය </th>
                          <th> අනුමත සිසුන් සංඛ්‍යාව</th>
                          <th> සිටින සිසුන් සංඛ්‍යාව</th>
                          <th> ඇතුළත් කරන ලද සංඛ්‍යාව</th>
                          <th> පන්ති භාරකාරත්වය </th>
                  <?php     if($userrole=='System Administrator' || $userrole=='School User'){ ?>
                              <th></th><th></th>
                  <?php     }  ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($schoolClasses as $row){  
                          $sch_grd_cls_id = $row->sch_grd_cls_id;
                          $grade_id = $row->grade_id;
                          $grade = $row->grade;
                          $class_id = $row->class_id;
                          $class = $row->class;
                          $census_id = $row->school_id;
                          $cls_tr_nic = $row->stf_nic;
                          $cls_tr_name = $row->name_with_ini;
                          $approved_std_count = $row->approved_std_count;
                          $std_count = $row->std_count;
                          $year = $row->year; 
                          $update_dt = $row->updated_dt;
                          //$sms_status = $row->sms_sent;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                                            
                          <tr id="<?php echo 'tbrow'.$sch_grd_cls_id; ?>">
                    <?php
                        $attributes = array("class" => "form-horizontal", "class" => "update-classes", "name" => "update-classes");
                        echo form_open("SchoolClasses/updateSchoolClass", $attributes); ?> 
                            <input type="hidden" value="<?php echo $sch_grd_cls_id; ?>" name="sch_grd_cls_id_hidden" />
                            <input type="hidden" value="<?php echo $class_id; ?>" name="class_id_hidden" />
                            <input type="hidden" value="<?php echo $census_id; ?>" name="census_id_hidden" id="census_id_hidden"/>
                            <input type="hidden" value="<?php echo $year; ?>" name="year_hidden" id="year_hidden" class="year_hidden" />
                            <th><?php echo $no; ?></th>
                            <td style="vertical-align:middle;"><?php echo $grade.' '.$class; ?></td>
                            <td style="vertical-align:middle" >
                              <input class="form-control" id="approved_std_count_txt" name="approved_std_count_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo $approved_std_count; ?>" size="2" />
                            </td>
                            <td style="vertical-align:middle" >
                              <input class="form-control" id="std_count_txt" name="std_count_txt" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo $std_count; ?>" size="2" />
                            </td>
                    <?php   $ci = & get_instance();
                            $ci->load->model('Student_model');
                            // get actually inserted students to the class
                            $exist_std_count = $ci->Student_model->get_student_count_of_a_class($census_id, $grade_id, $class_id,$year); 
                            if(!$exist_std_count){
                              $exist_std_count = 0;
                            }
                    ?>    
                            <td style="vertical-align:middle" >
                              <input class="form-control" id="exist_std_count_txt" name="exist_std_count_txt" type="text" value="<?php echo $exist_std_count; ?>" size="2" disabled/>
                            </td>
                            <td style="vertical-align:middle" >
                              <select class="form-control" id="cls_tr_select" name="cls_tr_select">
                        <?php   if(!empty($cls_tr_nic)){ ?>
                                  <option value="<?php echo $cls_tr_nic; ?>" selected><?php echo $cls_tr_name; ?></option>
                        <?php   }else{ ?>
                                  <option value="">---Select---</option>
                        <?php   }     ?>
                        <?php   
                                $ci = & get_instance();
                                $ci->load->model('SchoolClass_model');
                                // get actually inserted students to the class
                                
                                foreach ($schoolStaff as $row){ 
                                  $nic = $row->nic_no;
                                  echo $exist = $ci->SchoolClass_model->check_cls_tr_exists_in_another_grade($census_id, $nic, $year); 
                                  if( !$exist ){
                        ?> 
                                    <option value="<?php echo $row->nic_no; ?>"><?php echo $row->name_with_ini; ?></option>
                        <?php     } 
                                }
                        ?>
                                <option value="">---Select---</option>
                              </select>
                            </td>
                    <?php   if( $userrole=='System Administrator' || $userrole=='School User' ){ ?>
                              <td style="vertical-align:middle" >
                                <button class="btn btn-primary btn-sm" type="submit" name="btn_update_sch_cls" value="Save" ><i class="fa fa-floppy-o"></i> Save </button>
                              </td>
                              <td>
                                <a type="button" id="btn_delete_class" name="btn_delete_class" type="button" class="btn btn-info btn-sm btn_delete_class" value="<?php echo $sch_grd_cls_id; ?>" title="Click to Delete" data-toggle="tooltip" data-hidden="" data-id="<?php echo $sch_grd_cls_id; ?>" ><i class="fa fa-trash"></i></a>
                              </td>
                    <?php   }  ?>
                  <?php echo form_close(); ?>
                          </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php }else{ // if empty($acStaffDetails)
                        if(($userrole=='School User') && empty($acStaffDetails)){
                          echo '<h4 align="center">No Records!!!</h4>'; 
                        }
                      } ?>  
              </div> 
            </div> <!-- /col-lg-12 -->
            </div>
            <div class="card-footer small text-muted">
              <?php 
                if(!empty($schoolClasses)) { 
                  $latest_upd_dt = strtotime($latest_upd_dt);
                  $grade_update_dt = date("j F Y",$latest_upd_dt);
                  $grade_update_tm = date("h:i A",$latest_upd_dt);
                  echo 'Updated on '.$grade_update_dt.' at '.$grade_update_tm;
                }
              ?>
            </div>
          </div>
        </div>
        
      </div>
      
        
      <!-- /following bootstrap model used to assign grades to a school  -->
      <div class="modal fade" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> පන්ති ඇතුළත් කිරීම </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                   <?php
                      $attributes = array("class" => "form-horizontal", "id" => "assign-classes", "name" => "assign-classes");
                      echo form_open("SchoolClasses/addSchClasses", $attributes); ?>                  
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
                                <select class="form-control mb-2 mr-sm-2" id="year_select_new_class" name="year_select_new_class" title="Please select">
                                  <option value="" selected>---ක්ලික් කරන්න---</option>
                              <?php 
                                  $year = date('Y');
                                  $selected_year = set_value('year_select_new_class');
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
                                  <?php foreach ($schoolGrades as $row){ ?> <!-- from Building controller constructor method -->
                                    <option value="<?php echo $row->grade_id; ?>"><?php echo $row->grade; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                            </div> <!-- /row -->
                          </div> <!-- /form group --> 
                          <div class="form-group">
                            <div class="row">
                              <div class="col-lg-5 col-sm-5">
                                <label for="NIC" class="control-label"> සමාන්තර පන්ති ගණන </label>
                              </div>
                              <div class="col-lg-7 col-sm-7">
                                <select class="form-control" id="no_of_cls_select" name="no_of_cls_select">
                                  <option value="" selected>---ක්ලික් කරන්න---</option>
                            <?php for ($x = 1; $x <= 10; $x++) { ?> <!-- from Building controller constructor method -->
                                      <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                            <?php } ?>
                                </select>
                              </div>
                            </div> <!-- /row -->
                          </div> <!-- /form group -->
                          <div class="form-group">
                            <div class="row">
                              <div class="col-lg-5 col-sm-5">
                                <label for="NIC" class="control-label"> පන්තියකට අනුමත සිසුන් සංඛ්‍යාව </label>
                              </div>
                              <div class="col-lg-7 col-sm-7">
                                <select class="form-control" id="no_of_std" name="no_of_std">
                                  <option value="35" selected>35</option>
                            <?php for ($x = 36; $x <= 50; $x++) { ?> <!-- from Building controller constructor method -->
                                      <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                            <?php } ?>
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
              <button class="btn btn-primary" type="submit" name="btn_add_sch_cls" value="Add_Classes">Add</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
      <!-- /following bootstrap model used to send message -->
<!------------------------- Help Modal - instructions for inserting new classes  --------------->
      <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> නව පන්ති ඇතුළත් කිරීම </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  1. New Class මත ක්ලික් කරන්න. <br>
                  2. ලැබෙන modal dialog box තුළින් වර්ෂය සහ ශ්‍රේණිය තෝරන්න. <br>
                     Drop down menu තුළින් ලැබෙනුයේ ඔබ විසින් තෝරන ලද වසර සඳහා ඇතුළත් කරන ලද ශ්‍රේණි පමණි. <br>
                     ඔබට අවශ්‍ය ශ්‍රේණිය ඒ තුළ නොමැති නම් මුලින් ශ්‍රේණිය ඇතුළත් කළ යුතුය.<br>
                  3. තෝරන ලද ශ්‍රේණියට අදාළ සමාන්තර පන්ති ගණන ලබා දෙන්න. <br>
                     සමාන්තර පන්තියක් පසුව ඇතුළත් කිරීමට අවශ්‍ය වුවහොත්, දැනට ඇතුළත් කර ඇති පන්ති ගණනට අළුතින් ඇතුළත් කරන පන්ති ගණන එකතු කර ලැබෙන මුළු පන්ති ගණන ලබා දෙන්න. <br>
                  4. උදාහරණ -  <br>
                     දැනට 11 ශ්‍රේණියේ පන්ති 2 ක් ඇතුළත් කර ඇත්නම් සහ තවත් පන්ති 1 ක් ඇතුළත් කිරීමට අවශ්‍ය නම් සමාන්තර පන්ති ගණන 3 ක් ලෙස ලබා දෙන්න. <br>
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
    <!-- /.content-wrapper-->
<script type="text/javascript">
  // delete a school class
    $(".btn_delete_class").click(function(){
      var row_id = $(this).parents("tr").attr("id");
      var sch_grd_cls_id = $(this).attr("data-id");
      var census_id = $('#census_id_hidden').val(); 
      var year = $('#year_hidden').val(); 
      //alert(year);
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
            url:"<?php echo base_url(); ?>SchoolClasses/deleteSchoolClass",  
            method:"POST",  
            data:{sch_grd_cls_id:sch_grd_cls_id,census_id:census_id,year:year}, 
            error: function(data) {
              swal('Something is wrong!!!',"error");
            },
            success: function(data) {
              //alert(data)
              if(data=='1'){
                $("#"+row_id).remove();
                swal("Deleted!", "Class deleted successfully", "success");
              }else if(data=='2'){
                swal("Error!", "Sorry, Students exist!!!", "error");
              }
            }
          });
        } 
      });
     
    });
    // empty field validation in add new class bootstrap modal
    $("#assign-classes").submit(function(){
      var year = $('#year_select_new_class').val(); 
      var grade = $('#grade_select').val(); 
      var no_of_cls_select = $('#no_of_cls_select').val();     
      if(!(year)){
        swal("Error!", "Require the Year", "warning");
        return false;    
      }else if(!(grade)){
        swal("Error!", "Require the Grade", "warning");
        return false;    
      }else if(!(no_of_cls_select)){
        swal("Error!", "Require the number of Classes", "warning");
        return false;
      }else
        <?php if($this->userrole_id != '2'){ ?> // php
                if(!(grade)){                   // js
                  swal("Error!", "Require the Grade", "warning"); //js
                  return false;     // js
                }else               // js
        <?php } ?>                  // php
      { return true; }              // js
    });
    // පාසල තෝරනවිට ශ්‍රේණිය ලෝඩ් (Only the grades assigned to selected school) කිරීමට යොදා ගැනේ. 
    // used by admin
<?php if($role_id == '1'){ // if user is not a school ?>
      $(document).on('change', '#select_school_in_modal_form', function(){  
        var census_id = $(this).val();
        if(!census_id){
          swal('Please select the school');
        }else{
          var year = $('#census_id_hidden').val();
          var year = new Date().getFullYear(); // current year
          $.ajax({  
            url:"<?php  echo base_url(); ?>SchoolGrades/viewGradesSchoolWise",  
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
<?php } // if user is not a school ?>

  $(document).ready(function(){
    $('#dataTable1').DataTable({
      pageLength: '26',
    });

    // වර්ෂය තෝරනවිට ශ්‍රේණිය ලෝඩ් කිරීමට යොදා ගැනේ. 
    $(document).on('change', '#year_select_new_class', function(){  
      var year = $(this).val();
  <?php if( $role_id==2 ){ // school ?>
          var census_id = $('#census_id_hidden').val();
  <?php }else{ // if not chool ?>
          var census_id = $('#select_school_in_modal_form').val();
  <?php } ?> 
      if( !year ){
        swal('Please select the year')
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
  })
</script>