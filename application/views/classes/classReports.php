<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#dataTable1').DataTable({
      pageLength: '15',
/*    dom: 'Bfrtip'
      buttons: [
        {
          extend: 'excel',
          text: 'Save',
          exportOptions: {
              modifier: {
                  page: 'All'
              }
          }
        }
      ]*/
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
   th, td { white-space: nowrap; }
  </style>
  <?php
  foreach($this->session as $user_data){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if($role_id=='2'){
      //$class = $user_data['grade'].' '.$user_data['class'];
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
        <li class="breadcrumb-item">Classes</li>
        <li class="breadcrumb-item active">Reports</li>
      </ol>
      <?php
        if(!empty($this->session->flashdata('clsMsg'))) {
          $message = $this->session->flashdata('clsMsg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php   } ?> 
      <div class="row" id="search-bar-row">    
        <div class="col-lg-12 col-sm-12">
          <form class="form-inline mb-1" id="srch_cls_by_school" name="srch_cls_by_school" action="<?php echo base_url(); ?>SchoolClasses/classReports" method="POST">
            <label for="year_select" class="mb-2 ml-2 mr-sm-2" >Academic Year : </label>
            <select class="form-control mb-2 mr-sm-2 form-control-sm" id="year_select" name="year_select" title="Please select">
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
            <span class="text-danger" id="year_error"><?php //echo form_error('year_select'); ?></span>
      <?php if($role_id != '2'){ ?>
              <label for="select_school" class="mb-2 mr-sm-2" > School : </label>
              <select class="form-control mb-2 mr-sm-2 form-control-sm" id="select_school" name="select_school" title="Please select">
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
      <?php } ?>
            <button type="submit" class="btn btn-info mb-2 mr-sm-2 btn-sm" name="btn_view_classes_in_reports" value="View" id="btn_view_classes_in_reports"><i class="fa fa-search"></i> View </button>
          </form> <!-- /form -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / #search-bar-row -->
      <div class="row">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-bar"></i>
                පාසල තුළ පවත්නා පන්ති  
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
          <?php 
                if(!empty($schoolClasses)) {  ?>   
                  <div class="table-responsive">
                    <table id="dataTable1" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> ශ්‍රේණි </th>
                          <th> අනුමත ළමුන් සංඛ්‍යාව</th>
                          <th> සිටින ළමුන් සංඛ්‍යාව</th>
                          <th> ඇතුළත් කල සංඛ්‍යාව</th>
                          <th> ඇතුළත් කල ළමුන්ගේ ප්‍රතිශතය</th>
                          <th> පන්ති භාරකාරත්වය </th>
                          <th> දු.ක. අංකය  </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        $total_approved_std_count = 0;
                        $total_std_count = 0;
                        $total_exist_std_count = 0;
                        foreach ($schoolClasses as $row){  
                          //$sch_grd_cls_id = $row->sch_grd_cls_id;
                          $grade_id = $row->grade_id;
                          $grade = $row->grade;
                          $class_id = $row->class_id;
                          $class = $row->class;                          
                          $census_id = $row->school_id;
                          $stf_nic = $row->stf_nic;
                          $phone = $row->phone_mobile1;
                          $cls_tr = $row->name_with_ini;
                          $approved_std_count = $row->approved_std_count;  // no of students approved by ministry to a class
                          $total_approved_std_count += $approved_std_count;
                          $std_count = $row->std_count;  // no of students in a class accroding to the registry of the class
                          $total_std_count += $std_count;
                          $update_dt = $row->updated_dt;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  
                          /*$ci = & get_instance();
                          $ci->load->model('SchoolClass_model');
                          $grade_head = '';*/
                          $ci = & get_instance();
                          $ci->load->model('Student_model');
                          $exist_std_count = $ci->Student_model->get_student_count_of_a_class($census_id,$grade_id,$class_id,$year); // no of students entered to the system
                          if(!$exist_std_count){
                            $exist_std_count = 0;
                          }
                          $total_exist_std_count += $exist_std_count;
                          if($std_count != 0){
                            $std_percentage = round(($exist_std_count/$std_count)*100,2);
                            $std_percentage .= ' %';
                          }else{
                            $std_percentage = '-';
                          }
                    ?>
                    <?php
                      $attributes = array("class" => "form-horizontal", "class" => "assign-grades", "name" => "assign-grades");
                      echo form_open("SchoolClasses/updateSchoolClass", $attributes); ?>                         
                        <tr>
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $grade.' '.$class; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $approved_std_count; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $std_count; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $exist_std_count; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $std_percentage; ?></td>
                          <td style="vertical-align:middle" ><?php echo $cls_tr; ?></td>
                          <td style="vertical-align:middle" ><?php echo $phone; ?></td>
                        </tr>
                <?php echo form_close(); ?>
                  <?php } // end foreach ?>
                      </tbody>
                <?php 
                      if($total_std_count != 0){
                        $total_std_percentage = round(($total_exist_std_count/$total_std_count)*100,2);
                        $total_std_percentage .= ' %';
                      }else{
                        $total_std_percentage = '-';
                      }
                ?>
                      <tbody>
                        <tr>
                          <th></th>
                          <td style="vertical-align:middle;"><b>එකතුව</b></td>
                          <td style="vertical-align:middle" align="center"><b><?php echo $total_approved_std_count; ?></b></td>
                          <td style="vertical-align:middle" align="center"><b><?php echo $total_std_count; ?></b></td>
                          <td style="vertical-align:middle" align="center"><b><?php echo $total_exist_std_count; ?></b></td>
                          <td style="vertical-align:middle" align="center"><b><?php echo $total_std_percentage; ?></b></td>
                          <td style="vertical-align:middle" ></td>
                          <td style="vertical-align:middle" ></td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="col ml-1 mb-1">
                      <a href="<?php echo base_url(); ?>ExcelExport/printSchoolClasses/<?php echo $census_id; ?>/<?php echo $year; ?>" type="button" class="btn btn-success mt-2 btn-sm" name="btn_print" id="btn_print" ><i class="fa fa-fw fa-file-excel-o"> </i> Export</a>
                    </div>
          <?php }else{ // if empty($acStaffDetails)
                  if(($userrole=='School User') && empty($schoolClasses)){
                    echo '<h4 align="center">No Records!!!... Please set classes to grades.</h4>'; 
                  }else{
                    echo 'No records!!!';
                  }
                }     ?>  
                </div> <!-- /col-lg-12 -->
              </div> <!-- /row -->
            </div> <!-- /card-body -->
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
          </div> <!-- /card mb-3 -->
        </div>  <!-- /col-lg-12 -->       
      </div> <!-- /row -->
    </div> <!-- /.container-fluid-->
    <!-- /.content-wrapper-->