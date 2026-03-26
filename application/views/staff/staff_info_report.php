<style type="text/css">
  th, td { white-space: nowrap; }
  .tbl_heading{ font-weight: bold; }
  table{line-height: 5px;}
</style>

<?php if( !empty($stf_info) ) { 
        $latest_upd_dt = 0;
        foreach ( $stf_info as $row ){ 
          $name_with_ini = $row->name_with_ini;
        }
      }else{
          $name_with_ini = 'No records!!!';
      }
?>
<div class="content-wrapper">
    <div class="container-fluid">
<?php if( !empty($stf_info) ) { 
        $pers_info_upd_dt = 0;
        foreach ($stf_info as $row){ 
          $stf_id = $row->staff_id;
          $census_id = $row->census_id;
          $name_with_ini = $row->name_with_ini;
          $full_name = $row->full_name;
          $address = $row->stf_address1.' '.$row->stf_address2;
          $school = $row->sch_name;
          $nic_no = $row->nic_no;
          $dob = $row->dob;
          $gender_name = $row->gender_name;
          $civil_status = $row->civil_status_type;
          $ethnic_group = $row->ethnic_group;
          $religion = $row->religion;
          $phone_home = $row->phone_home;
          $mobile1 = $row->phone_mobile1;
          $mobile2 = $row->phone_mobile2;
          $email = $row->email;
          $edu_qual = $row->edu_q_name;
          $prof_qual = $row->prof_q_description;
    //-----------------------------------
          $staff_type = $row->stf_type; // කාර්ය මණ්ඩල වර්ගය - academic/non academic
          $desig_type = $row->desig_type; // තනතුර - ගුරුවරයා / විදුහල්පති 
          $staff_status = $row->stf_status; // තනතුර - ගුරුවරයා / විදුහල්පති 
          $cur_serv_grd = $row->serv_grd_type;
          $serv_grd_effective_dt = $row->serv_grd_effective_dt;
          $stf_status = $row->stf_status; // පත්වීමේ ස්වභාවය 
          $first_app_dt = $row->first_app_dt;  // මුල් පත්වීමේ දිනය 
          $sal_incr_dt = $row->sal_incr_dt; // වැටුප් වර්ධක දිනය 
          $start_dt_this_sch = $row->start_dt_this_sch;
          $cur_serv_status = $row->service_status; // වර්තමාන සේවා තත්ත්වය - ප්‍රසූත නිවාඩු 
          $app_type = $row->app_type;   // පත්විම් වර්ගය - ජාතික ශික්ෂණ විද්‍යා ඩිප්ලෝමා
          $app_subject = $row->app_subj;
          $app_medium = $row->subj_med_type;
          $salary_no = $row->salary_no;
          $staff_no = $row->stf_no;
          $section_name = $row->section_name;
          $section_role_name = $row->sec_role_name;
          $update_dt = $row->last_update;

          if($pers_info_upd_dt < $update_dt){
            $pers_info_upd_dt = $update_dt;
          }
        }

?>    
      <h3 align="center"><?php echo $school; ?></h3>
      <center><div style="font-size: 15px;">ගුරු තොරතුරු</div></center><hr>
      <div class="row" id="printDiv">
        
                <div class="col-sm-4" style="float:left; width: 300px;">
                  <div class="card mb-3">
                    <div class="card-header">
                      <i class="fa fa-table"></i> පෞද්ගලික තොරතුරු 
                    </div>
                    <div class="card-body">
                      <center>
              <?php 
                        if( file_exists("./assets/uploaded/stf_images/'".$stf_id."'.jpg") ){ 
              ?>
                          <img src="<?php echo base_url(); ?>assets/uploaded/stf_images/<?php echo $stf_id; ?>.jpg" class="img-circle" alt="Staff Photo" style="border-radius: 50%; width:75px;" id="staff_photo" >
              <?php     }else{ ?>
                          <img src="<?php echo base_url(); ?>assets/uploaded/stf_images/default_profile_image.png" class="img-circle" alt="Default Photo" style="border-radius: 50%; width: 75px; margin: 0 auto;" id="staff_photo" >
              <?php     }   ?>
                      </center>
                      <table class="table table-hover" id="" style="line-height: 10px;" width="100%">
                        <tr><td class="tbl_heading">නම</td><td><?php echo $name_with_ini; ?></td></tr>
                        <tr><td class="tbl_heading">සම්පූර්ණ නම</td><td><?php echo $full_name; ?></td></tr>
                        <tr><td class="tbl_heading">ලිපිනය</td><td><?php echo $address; ?></td></tr>
                        <tr><td class="tbl_heading">පාසල</td><td><?php echo $school; ?></td></tr>
                        <tr><td class="tbl_heading">ජා.හැ.අ.</td><td><?php echo $nic_no; ?></td></tr>
                        <tr><td class="tbl_heading">උපන් දිනය</td><td><?php echo $dob; ?></td></tr>
                        <tr><td class="tbl_heading">ස්ත්‍රී/පුරුෂ</td><td><?php echo $gender_name; ?></td></tr>
                        <tr><td class="tbl_heading">විවාහක/අවිවාහක බව</td><td><?php echo $civil_status; ?></td></tr>
                        <tr><td class="tbl_heading">ජාතිය</td><td><?php echo $ethnic_group; ?></td></tr>
                        <tr><td class="tbl_heading">ආගම</td><td><?php echo $religion; ?></td></tr>
                        <tr><td class="tbl_heading">නිවසේ දු.ක.</td><td><?php echo $phone_home; ?></td></tr>
                        <tr><td class="tbl_heading">ජංගම දු.ක. 1 </td><td><?php echo $mobile1; ?></td></tr>
                        <tr><td class="tbl_heading">ජංගම දු.ක. 2</td><td><?php echo $mobile2; ?></td></tr>
                        <tr><td class="tbl_heading">විද්‍යුත් තැපැල් ලිපිනය </td><td><?php echo $email; ?></td></tr>
                        <tr><td class="tbl_heading">ඉහළම අධ්‍යාපන සුදුසුකම් </td><td><?php echo $edu_qual; ?></td></tr>
                        <tr><td class="tbl_heading">ඉහළම වෘත්තීය සුදුසුකම් </td><td><?php echo $prof_qual; ?></td></tr>
                      </table>
                    </div><!-- <div class="card-body"> -->
<!--                     <div class="card-footer small text-muted">
              <?php 
                      // $pers_info_upd_dt = 0;
                      // foreach ($stf_info as $row){
                      //   if($pers_info_upd_dt < $row->last_update){
                      //     $pers_info_upd_dt = $row->last_update;
                      //   }
                      // }
                      // if(!empty($pers_info_upd_dt)) { 
                      //   $pers_info_upd_dt = strtotime($pers_info_upd_dt);
                      //   $update_dt = date("j F Y",$pers_info_upd_dt);
                      //   $update_tm = date("h:i A",$pers_info_upd_dt);
                      //   echo 'Updated on '.$update_dt.' at '.$update_tm;
                      // }
              ?>
                    </div>  -->
                  </div><!-- <div class="card mb-3"> -->
                  <div class="card mb-3">
                    <div class="card-header">
                      <i class="fa fa-table"></i> ඉගැන්වීම සිදු කරන පන්ති 
                    </div>
                    <div class="card-body">
                      <table class="table table-hover" width="">
                        <thead>
                          <tr>
                            <th class="">පන්තිය</th> <th class=""> භූමිකාව </th>
                          </tr>
                        </thead>
                        <tbody>
                <?php 
                        $ci = & get_instance();
                        $ci->load->model('Staff_model');
                        $classes = $ci->Staff_model->get_stf_grd_cls($stf_id);

                        if( !empty($classes) ){
                          $latest_upd_dt = 0;
                          foreach ( $classes as $class ) {
                ?>
                            <tr>
                              <td><?php echo $class->grade.$class->class; ?></td><td><?php echo $class->sec_role_name ?></td>
                            </tr>
                <?php  
                            if($latest_upd_dt < $class->last_update){
                              $latest_upd_dt = $class->last_update;
                            }    
                          }
                        }else{ 
                ?>
                            <tr>
                              <td colspan="2" style="color: red;">No records found!!!</td>
                            </tr>
                <?php   }   ?>
                        </tbody>

                      </table>
                    </div><!-- <div class="card-body"> -->
                    <!-- <div class="card-footer small text-muted">
              <?php 
                      // if(!empty($classes)) { 
                      //   $latest_upd_dt = strtotime($latest_upd_dt);
                      //   $building_update_dt = date("j F Y",$latest_upd_dt);
                      //   $building_update_tm = date("h:i A",$latest_upd_dt);
                      //   echo 'Updated on '.$building_update_dt.' at '.$building_update_tm;
                      // }
              ?>
                    </div>  -->
                  </div><!-- <div class="card mb-3"> -->
                </div><!-- <div class="col-sm-6"> -->
                <div class="col-sm-4" style="float:left; width: 300px;">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="card mb-3">
                        <div class="card-header">
                          <i class="fa fa-table"></i> සේවා තොරතුරු 
                        </div>
                        <div class="card-body">
                          <table class="table table-hover" >
                            <tr><td class="tbl_heading">කාර්ය මණ්ඩල වර්ගය</td><td><?php echo $staff_type; ?></td></tr>
                            <tr><td class="tbl_heading">තනතුර </td><td><?php echo $desig_type; ?></td></tr>
                            <tr><td class="tbl_heading">තනතුරේ ස්වභාවය</td><td><?php echo $staff_status; ?></td></tr>
                            <tr><td class="tbl_heading">වත්මන් සේවයේ මුල් පත්වීම් දිනය</td><td><?php echo $first_app_dt; ?></td></tr>
                            <tr><td class="tbl_heading">පත්වීම් වර්ගය</td><td><?php echo $app_type; ?></td></tr>
                            <tr><td class="tbl_heading">පත්වීම් විෂය</td><td><?php echo $app_subject; ?></td></tr>
                            <tr><td class="tbl_heading">පත්වීම් මාධ්‍යය</td><td><?php echo $app_medium; ?></td></tr>
                            <tr><td class="tbl_heading">වත්මන් සේවා ශ්‍රේණිය</td><td><?php echo $cur_serv_grd; ?></td></tr>
                            <tr><td class="tbl_heading">වැටුප් වර්ධක දිනය</td><td><?php echo $sal_incr_dt; ?></td></tr>
                            <tr><td class="tbl_heading">වැටුප් අංකය</td><td><?php echo $salary_no; ?></td></tr>
                            <tr><td class="tbl_heading">වර්ථමාන සේවා තත්ත්වය </td><td><?php echo $cur_serv_status; ?></td></tr>
                          </table>
                        </div><!-- <div class="card-body"> -->
                      </div><!-- <div class="card mb-3"> -->
                    </div>
                    <div class="col-sm-4" style="width: 300px;">
                      <div class="card mb-3">
                        <div class="card-header">
                          <i class="fa fa-table"></i> සේවා ස්ථානය  
                        </div>
                        <div class="card-body">
                          <table class="table table-hover" >
                            <tr><td class="tbl_heading">පාසල</td><td><?php echo $school; ?></td></tr>
                            <tr><td class="tbl_heading">ගුරු අංකය </td><td><?php echo $staff_no; ?></td></tr>
                            <tr><td class="tbl_heading">මෙම පාසලට පත්වූ දිනය</td><td><?php echo $start_dt_this_sch; ?></td></tr>
                            <tr><td class="tbl_heading">පාසලේ දරන තනතුර</td><td><?php echo $desig_type; ?></td></tr>
                            <tr><td class="tbl_heading">අංශය</td><td><?php echo $section_name; ?></td></tr>
                            <tr><td class="tbl_heading">අංශයේ භූමිකාව</td><td><?php echo $section_role_name; ?></td></tr>
                          </table>
                        </div><!-- <div class="card-body"> -->
                      </div><!-- <div class="card mb-3"> -->
                    </div>
                  </div>
                </div><!-- <div class="col-sm-6"> -->
           
                <div class="col-sm-12" style="clear: both;line-height: 10px;">
                  <div class="card mb-3">
                    <div class="card-header">
                      <i class="fa fa-table"></i> ඉටුකරන කාර්්‍යය 
                    </div>
                    <div class="card-body">
                      <table class="table table-hover" width="200">
                        <thead>
                          <tr>
                            <th class="">කාර්ය වර්ගය</th> <th class="">කාර්යය </th>
                            <th class=""> අංශය</th> <th class=""> විෂයය </th>
                          </tr>
                        </thead>
                        <tbody>
                
                  <?php 
                          $ci = & get_instance();
                          $ci->load->model('Staff_model');
                          $task = $ci->Staff_model->get_staff_involved_task($stf_id);
                          if( !empty($task) ){
                            $latest_upd_dt = 0;
                            foreach ( $task as $task ) {
                  ?>
                              <tr>
                                <td><?php echo $task->involved_task_type; ?></td><td><?php echo $task->inv_task ?></td>
                                <td><?php echo $task->section_name; ?></td><td><?php echo $task->subject; ?></td>
                              </tr>
                  <?php  
                              if($latest_upd_dt < $task->last_update){
                                $latest_upd_dt = $task->last_update;
                              }    
                            }
                          }else{ 
                  ?>
                            <tr>
                              <td colspan="2" style="color: red;">No records found!!!</td>
                            </tr>
                  <?php   }   ?>
                        </tbody>
                      </table>
                    </div><!-- <div class="card-body"> -->
                  </div><!-- <div class="card mb-3"> -->
                </div><!-- <div class="col-sm-12"> -->
                <br><br><br><br><br><br><br><br><br>
                <div class="col-sm-12" style="width: 100%;margin-top: 75px;">
                  <div class="card mb-0">
                    <div class="card-header">
                      <i class="fa fa-table"></i> විෂය සමගාමී කටයුතු  
                    </div>
                    <div class="card-body">
                      <table class="table table-hover" width="100%" >
                        <thead>
                          <tr>
                            <th class="">ක්‍රියාකාරකම </th> <th class=""> භූමිකාව </th>
                          </tr>
                        </thead>
                        <tbody>
                  <?php 
                          $ci = & get_instance();
                          $ci->load->model('Staff_model');
                          $extra_cur = $ci->Staff_model->get_stf_extra_curri_info($stf_id);
                          if( !empty($extra_cur) ){
                            $latest_upd_dt = 0;
                            foreach ( $extra_cur as $extra_cur ) {
                  ?>
                              <tr>
                                <td><?php echo $extra_cur->extra_curri_type; ?></td><td><?php echo $extra_cur->ex_cu_role_name ?></td>
                              </tr>
                  <?php  
                              if( $latest_upd_dt < $extra_cur->last_update ){
                                $latest_upd_dt = $extra_cur->last_update;
                              }    
                            }
                          }else{ ?>
                            <tr>
                              <td colspan="2" style="color: red;">No records found!!!</td>
                            </tr>
                  <?php   }   ?>
                        </tbody>
                      </table>
                    </div><!-- <div class="card-body"> -->
                    <!-- <div class="card-footer small text-muted">
              <?php 
                      // if(!empty($extra_cur)) { 
                      //   $latest_upd_dt = strtotime($latest_upd_dt);
                      //   $update_dt = date("j F Y",$latest_upd_dt);
                      //   $update_tm = date("h:i A",$latest_upd_dt);
                      //   echo 'Updated on '.$update_dt.' at '.$update_tm;
                      // }
              ?>
                    </div>  -->
                  </div><!-- <div class="card mb-3"> -->
                </div><!-- <div class="col-sm-12"> -->

      </div> <!-- /row # -->
      <div class="row" style="margin-top: 20px;">
  <?php
        foreach($this->session as $user_data){
          $userid = $user_data['userid'];
          $userrole = $user_data['userrole'];
          $role_id = $user_data['userrole_id'];

        }
  ?>

        <div class="col-sm-6" style="font-size: 12px;">
          <div style="width: 100%;" id="signature" >
          ..................... <br>
    <?php   if ( $role_id==1 ) {
              echo 'Admin';
            }elseif( $role_id==2 ) {
              echo 'විදුහල්පති ';
            }else{
              echo $userrole;
            } 
    ?>
          </div>
        </div>
        <div class="col-sm-6" style="float: left;">
          <div style="float: left; font-size: 10px;" id="who_print">
    <?php   echo 'Printed by '.$userrole.' - '.date('Y-m-d H:i:s'); ?>
          </div>
        </div>
      </div>
<?php }else{ ?>
        <div class="alert alert-danger" >No records found!!!</div>
<?php } ?>  <!-- end of By task report -->
 </div> <!-- /container-fluid -->
