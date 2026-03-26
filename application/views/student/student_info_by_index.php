<style type="text/css">
  th, td { white-space: nowrap; }
  .tbl_heading{ font-weight: bold; }
</style>

<?php
  foreach( $this->session as $user_data ){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if( $role_id=='2' ){
      //$class = $user_data['grade'].' '.$user_data['class'];
      $school_name = $user_data['school_name'];
    }
  }
?>
<?php if( !empty($std_info) ) { 
        $latest_upd_dt = 0;
        foreach ( $std_info as $row ){ 
          $name_with_ini = $row->name_with_initials;
        }
      }else{
          $name_with_ini = 'No records!!!';
      }
?>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>user">Dashboard</a>
        </li>
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Student/studentReportsView">Student Reports</a></li>
        <li class="breadcrumb-item active"><?php echo $name_with_ini; ?></li>
      </ol>

<?php if( !empty($std_info) ) { 
        foreach ($std_info as $row){ 
          $census_id = $row->st_id;
          $adm_no = $row->index_no;
          $fullname = $row->fullname;
          $name_with_ini = $row->name_with_initials;
          $address = $row->std_address1.' '.$row->std_address2;
          $mobile1 = $row->phone_no_1;
          $mobile2 = $row->phone_no_2;
          $phone_home = $row->phone_home;
          $dob = $row->dob;
          $gender_name = $row->gender_name;
          $ethnic_group = $row->ethnic_group;
          $religion = $row->religion;
          $d_o_admission = $row->d_o_admission;
          $census_id = $row->census_id;
          $status = $row->st_status; // active, inactive, left the school
          $date_added = $row->added_date;
          $last_update_dt = $row->last_update;
          $school = $row->sch_name;
        } // end foreach
?>   
        <div class="row" id="printDiv">
          <div class="col-sm-6">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-table"></i> පෞද්ගලික තොරතුරු 
              </div>
              <div class="card-body">
                <center>
        <?php 
                  $file_name = $census_id.'_'.$adm_no;		
									if( file_exists("./assets/uploaded/student_images/$file_name.jpg") ){ 
        ?>
                    <img src="<?php echo base_url(); ?>assets/uploaded/student_images/<?php echo $census_id.'_'.$adm_no; ?>.jpg" class="img-circle" alt="Staff Photo" style="border-radius: 50%; width: 150px;"  >
        <?php     }else{ ?>
                    <img src="<?php echo base_url(); ?>assets/uploaded/student_images/default_stu_profile_image.png" class="img-circle" alt="Default Photo" style="border-radius: 50%; width: 150px;" >
        <?php     }   ?>
                </center>
                <table class="table table-hover" id="" style="line-height: 10px; font-size: 15px;" width="100%">
                  <tr><td class="tbl_heading">ඇතුලත් වීමේ අංකය </td><td><?php echo $adm_no; ?></td></tr>
                  <tr><td class="tbl_heading">නම</td><td><?php echo $name_with_ini; ?></td></tr>
                  <tr><td class="tbl_heading">සම්පූර්ණ නම</td><td><?php echo $fullname; ?></td></tr>
                  <tr><td class="tbl_heading">ලිපිනය</td><td><?php echo $address; ?></td></tr>
                  <tr><td class="tbl_heading">පාසල</td><td><?php echo $school; ?></td></tr>
                  <tr><td class="tbl_heading">උපන් දිනය</td><td><?php echo $dob; ?></td></tr>
                  <tr><td class="tbl_heading">ස්ත්‍රී/පුරුෂ</td><td><?php echo $gender_name; ?></td></tr>
                  <tr><td class="tbl_heading">ජාතිය</td><td><?php echo $ethnic_group; ?></td></tr>
                  <tr><td class="tbl_heading">ආගම</td><td><?php echo $religion; ?></td></tr>
                  <tr><td class="tbl_heading">නිවසේ දු.ක.</td><td><?php echo $phone_home; ?></td></tr>
                  <tr><td class="tbl_heading">ජංගම දු.ක. 1 </td><td><?php echo $mobile1; ?></td></tr>
                  <tr><td class="tbl_heading">ජංගම දු.ක. 2</td><td><?php echo $mobile2; ?></td></tr>
                </table>
              </div><!-- <div class="card-body"> -->
              <div class="card-footer small text-muted">
        <?php 
              if(!empty($std_info)) { 
                $last_update_dt = strtotime($last_update_dt);
                $update_dt = date("j F Y",$last_update_dt);
                $update_tm = date("h:i A",$last_update_dt);
                echo 'Updated on '.$update_dt.' at '.$update_tm;
              }
        ?>
              </div> 
            </div><!-- <div class="card mb-3"> -->
          </div><!-- <div class="col-sm-6"> -->
          <?php 
            $ci = & get_instance();
            $ci->load->model('Student_model');
            $study_details = $ci->Student_model->get_student_current_grade_class( $adm_no, $census_id );
            foreach ($study_details as $row){
              $academic_year = $row->year;
              $grade_class = $row->grade.' '.$row->class;
            }
          ?>
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-12">
                <div class="card mb-3">
                  <div class="card-header">
                    <i class="fa fa-table"></i> අධ්‍යයන තොරතුරු                      
                  </div>
                  <div class="card-body">
                    <table class="table table-hover" style="line-height: 10px; font-size: 15px;" >
                      <tr><td class="tbl_heading">අධ්‍යයන වර්ෂය </td><td><?php echo $academic_year; ?></td></tr>
                      <tr><td class="tbl_heading">ශ්‍රේණිය සහ පන්තිය </td><td><?php echo $grade_class; ?></td></tr>
                    </table>
                  </div><!-- <div class="card-body"> -->
                  <div class="card-footer small text-muted">
            <?php 
                    $study_info_upd_dt = 0;
                    foreach ($study_details as $row){
                      if($study_info_upd_dt < $row->last_update){
                        $study_info_upd_dt = $row->last_update;
                      }
                    }
                    if(!empty($study_info_upd_dt)) { 
                      $study_info_upd_dt = strtotime($study_info_upd_dt);
                      $update_dt = date("j F Y",$study_info_upd_dt);
                      $update_tm = date("h:i A",$study_info_upd_dt);
                      echo 'Updated on '.$update_dt.' at '.$update_tm;
                    }
            ?>
                  </div> 
                </div><!-- <div class="card mb-3"> -->
              </div>
          <?php 
            $ci = & get_instance();
            $ci->load->model('Student_model');
            $studentGuardian = $ci->Student_model->get_guardian($adm_no,$census_id);
            
            if ( empty($studentGuardian) ) {
              $guardian_id = '';
              $index_no = '';
              $census_id = '';
              $fa_name = '';
              $fa_job = '';
              $fa_mobile = '';
              $mo_name = '';
              $mo_job = '';
              $mo_mobile = '';
              $g_name = '';
              $g_job = '';
              $g_mobile = '';
              $g_date_added = '';
              $g_date_updated = '';

            }else{
              foreach ($studentGuardian as $row) {
                $guardian_id = $row->id;
                $index_no = $row->index_no;
                $census_id = $row->census_id;
                $fa_name = $row->f_name;
                $fa_job = $row->f_job;
                $fa_mobile = $row->f_mobile;
                $mo_name = $row->m_name;
                $mo_job = $row->m_job;
                $mo_mobile = $row->m_mobile;
                $g_name = $row->g_name;
                $g_job = $row->g_job;
                $g_mobile = $row->g_mobile;
                $g_date_added = $row->date_added;
                $g_date_updated = $row->last_update;
              }            
            }
          ?>
              <div class="col-sm-12">
                <div class="card mb-3">
                  <div class="card-header">
                    <i class="fa fa-table"></i> භාරකරු   
                  </div>
                  <div class="card-body">
                    <table class="table table-hover" style="line-height: 10px; font-size: 15px;" width="100%">
                      <tr><td class="tbl_heading">පියාගේ නම</td><td><?php echo $fa_name; ?></td></tr>
                      <tr><td class="tbl_heading">දුරකථන අංකය </td><td><?php echo $fa_mobile; ?></td></tr>
                      <tr><td class="tbl_heading">රැකියාව</td><td><?php echo $fa_job; ?></td></tr>
                      <tr><td class="tbl_heading">මවගේ නම</td><td><?php echo $mo_name; ?></td></tr>
                      <tr><td class="tbl_heading">දුරකථන අංකය </td><td><?php echo $mo_mobile; ?></td></tr>
                      <tr><td class="tbl_heading">රැකියාව</td><td><?php echo $mo_job; ?></td></tr>
                      <tr><td class="tbl_heading">භාරකරුගේ නම</td><td><?php echo $g_name; ?></td></tr>
                      <tr><td class="tbl_heading">දුරකථන අංකය </td><td><?php echo $g_mobile; ?></td></tr>
                      <tr><td class="tbl_heading">රැකියාව</td><td><?php echo $g_job; ?></td></tr>
                    </table>
                  </div><!-- <div class="card-body"> -->
                  <div class="card-footer small text-muted">
          <?php
                    if( !empty( $g_date_updated ) ) { 
                      $g_info_upd_dt = strtotime($g_date_updated);
                      $update_dt = date("j F Y",$g_info_upd_dt);
                      $update_tm = date("h:i A",$g_info_upd_dt);
                      echo 'Updated on '.$update_dt.' at '.$update_tm;
                    }else{
                      echo 'No parents data found!!!';
                    }
          ?>
                  </div> 
                </div><!-- <div class="card mb-3"> -->
              </div>
            </div>
          </div><!-- <div class="col-sm-6"> -->         
        </div> <!-- /row # -->
<!-- ------------------------------ Co curriculum activities --------------------------------  -->
        <div class="row">
          <div class="col-sm-6">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-table"></i> විෂය සමගාමී ක්‍රියාකාරකම්                       
              </div>
              <div class="card-body">
                <table class="table table-hover" style="line-height: 10px; font-size: 15px;" >
                  <thead>
                    <tr>
                      <th>ක්‍රියාකාරකම</th><th>තනතුර</th><th>වර්ෂය</th>
                    </tr>
                  </thead>
                  <tbody>
            <?php   if( !$std_co_cur_info ){      ?>
                      <tr><td colspan="4">No records found</td></tr>
            <?php   }else{ 
                        $latest_upd_dt = 0;
                        foreach( $std_co_cur_info as $co_cur_info ){
                        $std_ex_cur_id = $co_cur_info->std_ex_cur_id;  
                        $census_id = $co_cur_info->census_id;
                        $index_no = $co_cur_info->index_no;
                        $co_cu_id = $co_cur_info->extra_curri_id;
                        $co_cu_type = $co_cur_info->extra_curri_type;	
                        $co_cu_role_id = $co_cur_info->std_ex_cur_role_id;	
                        $role_name = $co_cur_info->std_ex_cur_role_name;
                        $year = $co_cur_info->year; 
                        $last_update = $co_cur_info->last_update; 
                        if($latest_upd_dt < $last_update){
                          $latest_upd_dt = $last_update;
                        }
            ?>
                        <tr>
                          <td style="vertical-align:middle"><?php echo $co_cu_type; ?></td>
                          <td style="vertical-align:middle"><?php echo $role_name; ?></td>
                          <td style="vertical-align:middle"><?php echo $year; ?></td>
                        </tr>
						<?php	    }
                    }   ?>
                  </tbody>
                </table>
              </div><!-- <div class="card-body"> -->
              <div class="card-footer small text-muted">
        <?php 
                if( !empty( $std_co_cur_info ) ) {
                  if( !empty( $latest_upd_dt ) ) { 
                    $g_info_upd_dt = strtotime($latest_upd_dt);
                    $update_dt = date("j F Y",$g_info_upd_dt);
                    $update_tm = date("h:i A",$g_info_upd_dt);
                    echo 'Updated on '.$update_dt.' at '.$update_tm;
                  }
                }else{
                  echo 'No co-curricular activities found!!!';
                }
        ?>
              </div> 
            </div> <!-- <div class="card mb-3"> -->
          </div> <!-- <div class="col-sm-6"> -->
<!-- ------------------------------ Extra curriculum activities (Sports) --------------------------------  -->         
          <div class="col-sm-6">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-table"></i> විෂය බාහිර ක්‍රියාකාරකම්                       
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" style="line-height: 10px; font-size: 15px;" >
                    <thead>
                      <tr>
                        <th> ක්‍රීඩාව </th><th> තනතුර </th><th> වර්ෂය </th><th> දිනය </th> 
                      </tr>
                    </thead>
                    <tbody>
              <?php   if( !$std_ex_cur_info ){      ?>
                        <tr><td colspan="4">No records found</td></tr>
              <?php   }else{ 
                        $latest_upd_dt = 0;
                        foreach( $std_ex_cur_info as $game_info ){
                          $stgm_id = $game_info->st_gm_id;  
                          $index_no = $game_info->index_no;
                          $game_id = $game_info->game_id;
                          $game_name = $game_info->game_name;	
                          $game_role_id = $game_info->std_gm_role_id;	
                          $game_role = $game_info->std_gm_role_name;
                          $game_year = $game_info->year;
                          $game_date = $game_info->date; 
                          $game_last_update = $game_info->last_update; 
                          if($latest_upd_dt < $game_last_update){
                            $latest_upd_dt = $game_last_update;
                          }
              ?>
                          <tr>
                            <td style="vertical-align:middle"><?php echo $game_name; ?></td>
                            <td style="vertical-align:middle"><?php echo $game_role; ?></td>
                            <td style="vertical-align:middle"><?php echo $game_year; ?></td>
                            <td style="vertical-align:middle"><?php echo $game_date; ?></td>
                          </tr>
              <?php	    }
                      }   ?>
                    </tbody>
                  </table>
                </div>  <!-- <div class="table-responsive"> -->
              </div><!-- <div class="card-body"> -->
              <div class="card-footer small text-muted">
        <?php 
                if( !empty( $std_ex_cur_info ) ) {
                  if( !empty( $latest_upd_dt ) ) { 
                    $g_info_upd_dt = strtotime($latest_upd_dt);
                    $update_dt = date("j F Y",$g_info_upd_dt);
                    $update_tm = date("h:i A",$g_info_upd_dt);
                    echo 'Updated on '.$update_dt.' at '.$update_tm;
                  }
                }else{
                  echo 'No co-curricular activities found!!!';
                }
        ?>
              </div> 
            </div><!-- <div class="card mb-3"> -->
          </div> <!-- <div class="col-sm-6"> -->
        </div> <!-- /row  -->
<!-- ------------------------------ Student's Winnings ---------------------------------------------  -->      
        <div class="row">
          <div class="col-sm-12">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-table"></i> තරඟ ජයග්‍රහණයන්                       
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" style="line-height: 10px; font-size: 15px;" >
                    <thead>
                      <tr>
                        <th scope="col" class="col-sm-1"> වර්ගය </th>
                        <th scope="col" class="col-sm-2"> ක්‍රියාකාරකම </th>
                        <th scope="col" class="col-sm-1"> භූමිකාව </th>
                        <th scope="col" class="col-sm-1"> ක්‍රීඩාව </th>
                        <th scope="col" class="col-sm-1"> භූමිකාව </th>
                        <th scope="col" class="col-sm-2"> තරඟය </th>
                        <th scope="col" class="col-sm-1"> ජයග්‍රහණය </th>
                        <th scope="col" class="col-sm-2"> විස්තරය </th>
                        <th scope="col" class="col-sm-1"> දිනය </th>
                      </tr>
                    </thead>
                    <tbody>
              <?php   if( !$std_win_info ){      ?>
                        <tr><td colspan="4">No records found</td></tr>
              <?php   }else{ 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach( $std_win_info as $std_win ){
                          $std_win_id = $std_win->std_win_id;  
                          $census_id = $std_win->census_id;
                          $index_no = $std_win->index_no;
                          if( $std_win->main_type == 1 ){
                            $main_type = 'විෂය සමගාමී';
                          }elseif( $std_win->main_type == 2 ){
                            $main_type = 'විෂය බාහිර';
                          }else{
                            $main_type = 'වෙනත්';
                          }

                          $extra_curri_type = $std_win->extra_curri_type;	
                          $extra_curri_role = $std_win->std_ex_cur_role_name;	
                          $game_name = $std_win->game_name;	
                          $game_role = $std_win->std_gm_role_name;	
                          $contest = $std_win->contest;	
                          $win_type = $std_win->win_type;
                          $remarks = $std_win->remarks;
                          $date_held = $std_win->date_held;
                          $win_last_update = $std_win->last_update;
                          if($latest_upd_dt < $win_last_update){
                            $latest_upd_dt = $win_last_update;
                          }
                        ?>
                          <tr>
                            <td style="vertical-align:middle"><?php echo $main_type; ?></td>
                            <td style="vertical-align:middle"><?php echo $extra_curri_type; ?></td>
                            <td id="td_btn"><?php echo $extra_curri_role; ?></td>
                            <td style="vertical-align:middle"><?php echo $game_name; ?></td>
                            <td style="vertical-align:middle"><?php echo $game_role; ?></td>
                            <td id="td_btn"><?php echo $contest; ?></td>
                            <td id="td_btn"><?php echo $win_type; ?></td>
                            <td id="td_btn"><?php echo $remarks; ?></td>
                            <td id="td_btn"><?php echo $date_held; ?></td>
                          </tr>
                <?php		} 
                      }   ?>
                    </tbody>
                  </table>
                </div>  <!-- <div class="table-responsive"> -->
              </div> <!-- <div class="card-body"> -->
              <div class="card-footer small text-muted">
        <?php 
                if( !empty( $std_win_info ) ) {
                  if( !empty( $win_last_update ) ) { 
                    $g_info_upd_dt = strtotime($win_last_update);
                    $update_dt = date("j F Y",$g_info_upd_dt);
                    $update_tm = date("h:i A",$g_info_upd_dt);
                    echo 'Updated on '.$update_dt.' at '.$update_tm;
                  }
                }else{
                  echo 'No co-curricular activities found!!!';
                }
        ?>
              </div> 
            </div> <!-- <div class="card mb-3"> -->
          </div> <!-- <div class="col-sm-12"> --> 
        </div> <!-- /row  -->
<?php }else{ //if( !empty($std_info) )?>
        <div class="alert alert-danger" >No records found!!!</div>
<?php } ?>  <!-- end of By task report -->
      <a type="button" href="<?php echo base_url(); ?>Student/studentReportsView" class="btn btn-info btn-sm mb-3"><i class="fa fa-back"></i>Back</a>
<?php if( !empty($std_info) ) { 
        foreach ($std_info as $row){ 
          $census_id = $row->census_id;
          $adm_no = $row->index_no;
        }
?>
        <a type="button" href="<?php echo base_url(); ?>Pdf/studentInfo/<?php echo $census_id; ?>/<?php echo $adm_no; ?>" class="btn btn-success btn-sm mb-3"><i class="fa fa-printer"></i> Print </a>
<?php } ?>
      <!-- <a type="button" href="<?php //echo base_url(); ?>ExcelExport/printStaffByNic/<?php //echo $nic_no; ?>" class="btn btn-success btn-sm mb-3"><i class="fa fa-printer"></i> Print </a> -->
  </div> <!-- /container-fluid -->
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
