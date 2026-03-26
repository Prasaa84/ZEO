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
    input[type='file'] {
    /* display: none; */
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
    if($role_id=='15'){  ?>  <!-- check for system admin login. needed to hide this search bar. thats why $role_id=15. -->
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
      <div class="row" id="students_by_censusID">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> ශිෂ්‍ය තොරතුරු </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <div class="row">
                    <div class="col-lg-4">
              <?php if( ($role_id=='1') || ($role_id=='2') ){ ?>
                      <button id="btn_add_new_stu_info1" name="btn_add_new_stu_info" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewStudentInfo" ><i class="fa fa-plus"></i> Add New</button>
              <?php } ?>
                    </div>
                  </div>
                  <h5 align="center">
                    <?php if( $userrole=='School User' ){
                            echo $school_name; 
                          }else{
                            echo 'දෙනියාය අධ්‍යාපන කලාපය'; 
                          }
                    ?></h5>
                  <h6 align="center">ශිෂ්‍ය තොරතුරු</h6>
        <?php   if( !empty( $student_info ) ) { ?>
                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover " cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>ඇතුළත් වීමේ අංකය </th>
                          <th>නම</th>
                          <th>පන්තිය</th>
                          <th>ස්ත්‍රී/පුරුෂ</th>
                  <?php   if($role_id!=2){ ?>
                            <th>පාසල</th>
                  <?php   }  ?>                  
                  <?php   if(($role_id=='1') || ($role_id=='2')){ ?>
                            <th></th><th></th>
                  <?php   }else{ ?>
                            <th></th>
                  <?php   } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ($student_info as $row){  
                          $st_id = $row['st_id'];
                          $index_no = $row['index_no'];
                          $name_with_ini = $row['name'];
                          $census_id = $row['census_id'];
                          $school = $row['school_name'];
                          $grade = $row['grade'];
                          $class = $row['class'];
                          $gender_name = $row['gender_name'];
                          $update_dt = $row['last_update'];
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }
                          $no = $no + 1;  ?>
                        <tr id="<?php echo 'tbrow'.$st_id; ?>">
                          <th><?php echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $index_no; ?></td>
                          <td style="vertical-align:middle" ><?php echo $name_with_ini; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $grade.' '.$class; ?></td>
                          <td style="vertical-align:middle" align="center"><?php echo $gender_name; ?></td>
                  <?php   if($role_id!=2){ ?>
                            <td style="vertical-align:middle" ><?php echo $school; ?></td>
                  <?php   }  ?>
                    <?php if(($role_id=='1') || ($role_id=='2')){ ?>
                            <td id="td_btn" style="vertical-align:middle">
                              <a href="<?php echo base_url(); ?>Student/editStudentInfoPage/<?php echo $st_id; ?>/<?php echo $index_no; ?>/<?php echo $census_id; ?>" type="button" id="btn_edit_student_details" name="btn_edit_student_details" type="button" class="btn btn-info btn-sm btn_edit_phy_res" value="edit" title="Update this details" data-toggle="tooltip" data-hidden="" onclick="get(<?php echo $st_id; ?>)"><i class="fa fa-pencil"></i></a>
                            </td>
                            <td id="td_btn" style="vertical-align:middle">
                              <!-- this code is to be used in future needs, when more data is needed in student deletion. so do not delete this form code
                                <form role="search" class="form-inline student_delete_form" name="student_delete_form" action="" method="POST" id="student_delete_form" enctype="multipart/form-data"> -->
                                
                                <input type="hidden" value="<?php echo $st_id; ?>" id="st_id_hidden" name="st_id_hidden" />
                                <input type="hidden" value="<?php echo $census_id; ?>" id="census_id_hidden" name="census_id_hidden" />
                                <input type="hidden" value="<?php echo $index_no; ?>" id="index_no_hidden" name="index_no_hidden" />
                                <a type="button" name="" class="btn btn-danger btn-sm btn_delete_student" value="Cancel" data-toggle="tooltip" title="Delete this student" data-id="<?php echo $st_id; ?>" ><i class="fa fa-trash-o"></i></a>
                              <!-- </form> --> <!-- /form -->
                            </td>
                    <?php }else{ ?>
                            <td id="td_btn" style="vertical-align:middle">
                              <a href="<?php echo base_url(); ?>Student/editStudentInfoPage/<?php echo $st_id; ?>/<?php echo $index_no; ?>/<?php echo $census_id; ?>" type="button" id="btn_edit_student_details" name="btn_edit_student_details" type="button" class="btn btn-info btn-sm" value="edit" title="More Details" data-toggle="tooltip""><i class="fa fa-eye"></i></a>
                            </td>
                    <?php } ?>
                        </tr>
                  <?php } ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
        <?php   }else{ 
                  if(($userrole=='School User') && empty($student_info)){
                    echo '<h4 align="center">Add Records!!!</h4>'; 
                  }else if(($userrole=='Administrator') && empty($student_info)){
                    echo '<h4 align="center">No Student Records Found!!!</h4>'; 
                  }else{
                    echo '<h4 align="center">Search Details</h4>';
                  }
                } ?>
                </div>
              </div> 
              <br>
              <div class="row">
                <div class="col-lg-12">
                  <form class="form-inline" role="search" id="students_bulk_upload_form" name="students_bulk_upload_form" action="<?php echo base_url(); ?>Student/addBulkStudents" method="POST">
            <?php   if($role_id==1 || $role_id==2){ ?>
                      <div class="mr-1">
                        <button id="btn_add_new_stu_info2" name="btn_add_new_stu_info" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewStudentInfo" data-toggle="tooltip" title="Add individual students to the system"><i class="fa fa-plus"></i> Add New</button>
                      </div>
                      <div class="mr-1">
                        <input type="file" name="file" id="file" required accept=".xls, .xlsx" style="font-size: 10pt; display: none;" class="file"/>
                        <label for="file" class="btn btn-sm btn-info" data-toggle="tooltip" title="Choose the excel file" ><i class="fa fa-fw fa-file-excel-o"> </i> Excel  </label>
                      </div>
                      <div class="mr-1">
                        <button type="submit" name="student_bulk_upload" value="Upload" class="btn btn-info btn-sm"><i class="fa fa-upload"></i> Upload</button> 
                      </div>
            <?php   } ?>
                      <div class="mr-1">
            <?php       if($role_id==1){
                          $file='Students - for admin.xlsx';
                        }else{
                          $file = 'Students.xlsx';
                        } ?>
                          <a href="<?php echo base_url(); ?>assets/download/student/<?php echo $file; ?>" type="button" class="btn btn-success btn-sm" data-toggle="tooltip" title="Template for uploading students to the system" ><i class="fa fa-download"></i> Download Template</a> 
                      </div>
                      <div class="mr-1">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#helpModal"><i class="fa fa-question"></i> Help</button>
                      </div>
                  </form> <!-- /form -->
                </div>
              </div>
               <br>
              <div class="row">
                <div class="col-lg-12">
                  <form class="form-inline" role="search" id="students_bulk_upload_form" name="students_bulk_upload_form" action="<?php echo base_url(); ?>Student/addBulkStudents" method="POST">
            <?php   if($role_id==1 || $role_id==2){ ?>
                      <div class="mr-1">
                        <button id="btn_add_new_stu_info2" name="btn_add_new_stu_info" type="button" class="btn btn-primary btn-sm" value="Add"  data-toggle="modal" data-target="#addNewStudentInfo" data-toggle="tooltip" title="Add individual students to the system"><i class="fa fa-plus"></i> Add New</button>
                      </div>
                      <div class="mr-1">
                        <input type="file" name="file" id="file" required accept=".xls, .xlsx" style="font-size: 10pt; display: none;" class="file"/>
                        <label for="file" class="btn btn-sm btn-info" data-toggle="tooltip" title="Choose the excel file" ><i class="fa fa-fw fa-file-excel-o"> </i> Excel  </label>
                      </div>
                      <div class="mr-1">
                        <button type="submit" name="student_bulk_upload" value="Upload" class="btn btn-info btn-sm"><i class="fa fa-upload"></i> Upload</button> 
                      </div>
            <?php   } ?>
                      <div class="mr-1">
            <?php       if($role_id==1){
                          $file='Students - for admin.xlsx';
                        }else{
                          $file = 'Students.xlsx';
                        } ?>
                          <a href="<?php echo base_url(); ?>assets/download/student/<?php echo $file; ?>" type="button" class="btn btn-success btn-sm" data-toggle="tooltip" title="Template for uploading students to the system" ><i class="fa fa-download"></i> Download Template</a> 
                      </div>
                      <div class="mr-1">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#helpModal"><i class="fa fa-question"></i> Help</button>
                      </div>
                  </form> <!-- /form -->
                </div>
              </div>
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php 
                if(!empty($student_info)) { 
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
                          <label for="index number" class="control-label">ඇතුළත් වීමේ අංකය<font color="#ff0000"> * </font></label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="index_no_txt" name="index_no_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="full name" class="control-label">සම්පූර්ණ නම<font color="#ff0000"> * </font> </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="full_name_txt" name="full_name_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="name with initials" class="control-label">මුලකුරු සමග නම<font color="#ff0000"> * </font>  </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="name_with_ini_txt" name="name_with_ini_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label">ලිපිනය (පේළිය 1) </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="address1_txt" name="address1_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" size="60" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label">ලිපිනය (පේළිය 2) </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="address2_txt" name="address2_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label">ජංගම දුරකථන අංකය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="phone_no_1_txt" name="phone_no_1_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label"> WhatsApp අංකය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="phone_no_2_txt" name="phone_no_2_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label">නිවසේ දුරකථන අංකය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="phone_home_txt" name="phone_home_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="index number" class="control-label">උපන් දිනය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control datepicker" id="dob_txt" name="dob_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" readonly/>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="wide" class="control-label">ස්ත්‍රී/පුරුෂ<font color="#ff0000"> * </font> </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="gender_select" name="gender_select">
                            <option value="" selected>---ක්ලික් කරන්න---</option>
                            <option value="2" > ස්ත්‍රී</option>
                            <option value="1" > පුරුෂ </option>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new category" class="control-label"> ආගම  </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="religion_select" name="religion_select">
                            <option value="" selected>---ක්ලික් කරන්න---</option>
                            <?php foreach ($this->all_religion as $row){ ?> <!-- from Building controller constructor method -->
                              <option value="<?php echo $row->religion_id; ?>"><?php echo $row->religion; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new category" class="control-label"> ජාතිය  </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="ethnicity_select" name="ethnicity_select">
                            <option value="" selected>---ක්ලික් කරන්න---</option>
                            <?php foreach ($this->all_ethnic_groups as $row){ ?> <!-- from Staff controller constructor method -->
                              <option value="<?php echo $row->ethnic_group_id; ?>"><?php echo $row->ethnic_group; ?></option>
                            <?php } ?>
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
                                  <option value="<?php echo $row->census_id; ?>"><?php echo $row->sch_name.'-'.$row->census_id; ?></option>
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
                          <label for="new category" class="control-label">අධ්‍යයන වර්ෂය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="select_year" name="select_year" title="Please select">
                          <?php 
                            $starting_year = 2015;
                            $current_year = date('Y');
                            for($starting_year; $starting_year <= $current_year; $starting_year++) {
                              if($starting_year == date('Y')) {
                                  echo '<option value="'.$starting_year.'" selected="selected">'.$starting_year.'</option>';
                              }else{ 
                                  echo '<option value="'.$starting_year.'">'.$starting_year.'</option>';
                              }
                            }  
                          ?>                               
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="new category" class="control-label">ශ්‍රේණිය<font color="#ff0000"> * </font>  </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
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
                          <label for="wide" class="control-label">පන්තිය<font color="#ff0000"> * </font> </label>
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
                          <input class="form-control datepicker" id="admission_date_txt" name="admission_date_txt" placeholder="ඇතුළත් කරන්න" type="text" value=""  readonly />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                  </div> <!-- /schoolDetailsTab -->
                  <div role="tabpanel" class="tab-pane" id="parentDetailsTab">
                    <div class="form-group">
                      <font color="#ff0000">*</font> එක් අයකුගේ තොරතුරු පමණක් සෑහේ. තවද එක් අයකුගේ තොරතුරු සියල්ල ඇතුළත් කළ යුතුය.
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="guardian" class="control-label"> පියාගේ නම </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="fa_name_txt" name="fa_name_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="guardian telephone" class="control-label"> දුරකථන අංකය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="fa_tel_txt" name="fa_tel_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="donated by" class="control-label"> රැකියාව </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="fa_job_txt" name="fa_job_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="guardian" class="control-label"> මවගේ නම </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="mo_name_txt" name="mo_name_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="guardian telephone" class="control-label"> දුරකථන අංකය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="mo_tel_txt" name="mo_tel_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="donated by" class="control-label"> රැකියාව </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="mo_job_txt" name="mo_job_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="guardian" class="control-label"> භාරකරුගේ නම </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="guard_name_txt" name="guard_name_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="guardian telephone" class="control-label"> දුරකථන අංකය </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="guard_tel_txt" name="guard_tel_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group --> 
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="donated by" class="control-label"> රැකියාව </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="guard_job_txt" name="guard_job_txt" placeholder="ඇතුළත් කරන්න" type="text" value="" />
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
<!------------------------- Help Modal - instructions for uploading bulk students to the system-------------------->
      <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> ශිෂ්‍ය තොරතුරු Excel File මගින් පද්ධතියට ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  1. Bulk Upload Template (Template of Excel Sheet) එක Download කර ගැනීමට Download Template බට්න් ක්ලික් කරන්න. <br>
                  2. Excel sheet තුළ type කරන විට, <u>sinhala unicode font (iskoolapotha)</u> පමණක් භාවිත කරන්න.<br>
                  3. Students.xlsx file තුළ sheet1 හි ඇතුලත් කර ඇති ඇ.වී.අංකය, සම්පූර්ණ නම,  මුලකුරු සමග නම, ස්ත්‍රී/පුරුෂ,  ජාතිය සහ ආගම අනිවාර්ය වේ. <br>
                  4. අනෙකුත් තීරු අනිවාර්ය නොවේ. <br>
                  5. Sheet1, Sheet2 tabs rename නොකළ යුතුය. එසේම Sheet2 tab ඉවත් නොකළ යුතුය. <br>
                  6. Students.xlsx ගොනු නාමය (File name) වෙනස් කර ගත හැක. නමුත් .xlsx (File extension) වෙනස් නොකළ යුතුය. <br>
                  7. ඇ.වී.අංකය <u>ඉලක්කම් 4 හෝ 5 කින්</u> සමන් විත වේ. <br>
                  ඔබ පාසලේ භාවිත කරන්නේ ඉලක්කකම් 4 ක් පමණක් නම් එය වලංගු වේ. එම නිසා ඉදිරියෙන් 0 ඇතුළත් නොකරන්න. ex - 02790 මෙය වැරදි ඇතුලත් වීමේ අංකයකි.  <br>
                  8. ශිෂ්‍යයකුට අදාළ අනෙකුත් තොරතුරු student update තුළින් update කරගත හැකිය. <br>
                  9. ස්ත්‍රී/පුරුෂ,  ජාතිය සහ ආගම යන තීරු drop down menu පමණක් භාවිත කර සම්පූර්ණ කරන්න. <br>
                  10. ඇතුළත් කරන ලද සිසුන් <u>Delete</u> කළහොත් නැවත එම ඇතුළත් වීමේ අංකයට වෙනත් සිසුවකු ඇතුළත් කල නොහැක. <br>
                  එම නිසා සිසුවකුගේ දත්ත නිවැරදි නොවේි නම්, එම සිසුවා Delete නොකර Update තුළින් ඔහුගේ දත්ත නිවැරදි කරන්න. <br>
                  11. දැනට වාර විභාග ලකුණු ඇතුළත් කර ඇති සිසුන් Delete කල නොහැක.  <br>
                  12. Excel බට්න් ක්ලික් කර Mark sheet එක තෝරා Upload බට්න් ක්ලික් කරන්න.  <br>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
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
              extend: 'excel',
              text: 'Save'
            },
            {
              extend: 'pdf',
              messageBottom: null
            },
          ],
          select: true
      } );
    });
    $(document).ready(function() {  
      // date picker
      $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeYear: true,
        yearRange:'1955:',
        maxDate:0
      })
    });
// ශ්‍රේණිය තෝරනවිට පන්තිය ලෝඩ් කිරීමට යොදා ගැනේ. 
  $(document).on('change', '#grade_select', function(){  
    var grade_id = $(this).val();
    var census_id = $('#census_id_select').val();
    var year = $('#select_year').val();
    if(!year){
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
  $(document).ready(function(){
    // To view help modal, because it didn't load properly
    $("#helpModal").prependTo("body");

  // add bulk students to the system using excel file
    $('#students_bulk_upload_form').on('submit', function(event){
      event.preventDefault();
      $.ajax({
        url:"<?php echo base_url(); ?>Student/addBulkStudents",
        method:"POST",
        data:new FormData(this),
        contentType:false,
        cache:false,
        processData:false,
        success:function(data){
          $('#file').val('');
          swal(data);
          if(data=='Students inserted successfully'){
            location.reload();
          }
        }
      })
    });
  }); 
  // Delete a student from the system temporaly. this must be included out side this statement
  // $(document).ready(function(){
  // otherwise when click on other pages in datatable, its not working
  $(".btn_delete_student").click(function(){
    var row_id = $(this).parents("tr").attr("id");
    var sid = $(this).attr("data-id");
    alert(row_id);
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
          url:"<?php echo base_url(); ?>Student/deleteStudent",  
          method:"POST",  
          data:{sid:sid}, 
          error: function() {
            alert('Something is wrong');
          },
            success: function(data) {
                if(data.trim()=='2'){
                  $("#"+row_id).remove();
                  swal("Deleted!", "Student details has been deleted.", "success");
                }else if(data.trim()=='1'){
                  swal("Not Deleted!", "Term test marks exist.", "error");
                }else if(data.trim()=='3'){
                  swal("Error!", "Student details not deleted.", "error");
                }
            }
        });
      } 
    });
   
  });
    //  Delete a students from the system. above code was used to delete a student. if want more data other than st_id, this code to be used since this is a form submitting
    $('.student_delete_form1').on('submit', function(event){
      event.preventDefault();
      var formData = new FormData(this);
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
              url:"<?php echo base_url(); ?>Student/deleteStudent",
              method:"POST",
              data:formData,
              contentType:false,
              cache:false,
              processData:false,
              success:function(data){
                if(data){
                  swal('Students deleted successfully');
                  location.reload();
                }else{
                  swal('Students not deleted!!!');
                }
              }
            }) // ajax
          } // if
        } // function confirm
      ) // swal
    });
</script>
