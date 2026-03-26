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
    if($userrole=='School User'){
      $school_name = $user_data['school_name'];
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
          <a href="<?php echo base_url(); ?>student">Student</a>
        </li>
        <li class="breadcrumb-item active">Student Information</li>
      </ol>
      <?php //echo md5('07025'); ?>
      <?php 
    if($role_id=='1'){  ?>  <!-- check for system admin login -->
      <div class="row" id="search-bar-row">     <!-- search bar is availabel for admin only -->
        <div class="col-lg-12 col-sm-12">
          <div class="row">
            <div class="col-lg-5 col-sm-5">
              <form class="navbar-form" role="search" id="srch_student_info_by_censusid" name="srch_student_info_by_censusid" action="<?php echo base_url(); ?>Student/viewStudentByCensusId" method="POST">
                <div class="form-group">
                  <div class="input-group addon">
                    <label>සංඝණන අංකය ඇතුලත් කරන්න &nbsp;</label>
                    <input class="form-control" placeholder="Census ID..." name="censusid_txt" id="censusid_txt" type="text" value="<?php echo set_value('censusid_txt'); ?>">
                    <button type="submit" class="btn btn-default input-group-addon" name="btn_view_details_by_census" value="View"><i class="fa fa-search"></i></button>
                  </div> <!-- /input-group -->
                </div>
              </form> <!-- /form -->
            </div> <!-- /.col-lg-2 col-sm-2 -->

          </div> <!-- /.row -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / #search-bar-row -->
    <?php } ?>
      <?php 
        if(!empty($this->session->flashdata('msg'))) {
          $message = $this->session->flashdata('msg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php   } ?>    
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
      <div class="row" id="students_by_censusID">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> ශිෂ්‍ය තොරතුරු </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <button id="btn_add_new_stu_info1" name="btn_add_new_stu_info" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewStudentInfo" ><i class="fa fa-plus"></i> Add New</button>
                  <h5 align="center">
                    <?php if($userrole=='School User'){
                            echo $school_name; 
                          }else{
                            if(!empty($student_info_by_census)) { 
                              foreach ($student_info_by_census as $row){  
                                $school_name = $row->sch_name;
                                $census_id = $row->census_id;
                              }
                              echo $school_name;
                            }
                          }
                    ?></h5>
                  <h6 align="center">ශිෂ්‍ය තොරතුරු</h6>
                  <?php
                    if(!empty($student_info_by_census)) { ?>

                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover " cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>ඇතුළත් වීමේ අංකය </th>
                          <th>නම</th>
                          <th>පන්තිය</th>
                          <th>ස්ත්‍රී/පුරුෂ</th>
                      <?php if(($role_id=='1') || ($role_id=='2')){ ?>
                            <th></th><th></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($student_info_by_census as $row){  
                          $st_id = $row->st_id;
                          $index_no = $row->index_no;
                          $name_with_ini = $row->name_with_initials;
                          $census_id = $row->census_id;
                          $grade = $row->grade;
                          $class = $row->class;
                          $gender_id = $row->gender_id;
                          $gender_name = $row->gender_name;
                          $update_dt = $row->last_update;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr>
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $index_no; ?></td>
                          <td style="vertical-align:middle" ><?php echo $name_with_ini; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $grade.' '.$class; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $gender_name; ?></td>
                    <?php if(($role_id=='1') || ($role_id=='2')){ ?>
                            <td id="td_btn" style="vertical-align:middle">
                              <a href="<?php echo base_url(); ?>Student/editStudentInfoPage/<?php echo $st_id; ?>/<?php echo $census_id; ?>" type="button" id="btn_edit_student_details" name="btn_edit_student_details" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this details" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $st_id; ?>)"><i class="fa fa-pencil"></i></a>
                            </td>
                            <td id="td_btn" style="vertical-align:middle">
                              <!-- when delete, census id must be sent, since it is used to go back after delete -->
                              <a href="<?php echo base_url(); ?>Student/deleteStudentInfo/<?php echo $st_id; ?>/<?php echo $census_id; ?>" type="button" name="btn_delete_student_details" class="btn btn-danger btn-sm" value="Cancel" data-toggle="tooltip" title="Delete this details" onClick="return confirmItemStatusDetailsDelete();"><i class="fa fa-trash-o"></i></a>
                            </td>
                    <?php } ?>
                        </tr>
                  <?php } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php } else{ 
                    if(($userrole=='School User') && empty($student_info_by_census)){
                      echo '<h4 align="center">Add Records!!!</h4>'; 
                    }else if(($userrole=='Administrator') && empty($student_info_by_census)){
                      echo '<h4 align="center">Add or Search Records!!!</h4>'; 
                    }else{
                      echo '<h4 align="center">Search Details</h4>';
                    }
                  } ?>
                </div>
              </div> 
              <button id="btn_add_new_stu_info2" name="btn_add_new_stu_info" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewStudentInfo" ><i class="fa fa-plus"></i> Add New</button>
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php 
                if(!empty($student_info_by_census)) { 
                  $latest_upd_dt = strtotime($latest_upd_dt);
                  $com_lab_update_dt = date("j F Y",$latest_upd_dt);
                  $com_lab_update_tm = date("h:i A",$latest_upd_dt);
                  echo 'Updated on '.$com_lab_update_dt.' at '.$com_lab_update_tm;
                }
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row #lib_res_status_by_censusID -->
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
                        <input type="hidden" name="census_id_hidden" id="census_id_hidden" value="<?php echo $census_id; ?>">
                          <select class="form-control" id="grade_select" name="grade_select">
                            <option value="" selected>---ක්ලික් කරන්න---</option>
                            <?php foreach ($this->all_grades as $row){ ?> <!-- from Building controller constructor method -->
                              <option value="<?php echo $row->grade_id; ?>"><?php echo $row->grade; ?></option>
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
    </div> <!-- /container-fluid -->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
    <script type="text/javascript">
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
      $(document).ready(function() {
        $('#dataTable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              {
                extend: 'print',
                text: 'Print'
              },
              {
                extend: 'pdf',
                messageBottom: null
              },
            ],
            select: true
        } );
      });
  // ශ්‍රේණිය තෝරනවිට පන්තිය ලෝඩ් කිරීමට යොදා ගැනේ. 
  $(document).on('change', '#grade_select', function(){  
    var grade_id = $(this).val();
    var $census_id = $('#census_id_hidden').val();
    //alert($census_id);
     $.ajax({  
          url:"<?php echo base_url(); ?>SchoolClasses/viewClassesGradeWise",  
          method:"POST",  
          data:{grade_id:grade_id,census_id:$census_id},  
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
  });
  </script>
