<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
<style type="text/css">
  th, td { white-space: nowrap; }
  div.dataTables_wrapper {
      height: 200px;
      width: 1200px;
      margin: 0 auto;
  }
</style>
<script type="text/javascript">
  $( document ).ready(function() {    
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
<?php
  foreach($this->session as $user_data){
    $userid = $user_data['userid'];
    $userrole = $user_data['userrole'];
    $role_id = $user_data['userrole_id'];
    if($role_id=='2'){
      //$class = $user_data['grade'].' '.$user_data['class'];
      $school_name = $user_data['school_name'];
      $census_id = $user_data['census_id'];
    }else{
      $census_id = '';
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
        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Student">Students</a></li>
        <li class="breadcrumb-item active">Reports</li>
      </ol>
      <div class="row" id="search-bar-row">     <!-- search bar is availabel for admin only -->
        <div class="col-lg-12 col-sm-12">
          <form class="navbar-form" role="search" action="<?php echo base_url(); ?>Student/findStudentsForReports" method="POST">
            <div class="row">
    <?php     if ( $role_id != 2 ) { ?>
                <div class="form-group col-lg-3 col-sm-3">
                  <div class="input-group addon">
                    <input class="form-control form-control-sm" placeholder="පාසල..." name="school_txt" id="school_txt" type="text" value="<?php echo set_value('school_txt'); ?>">
                    <input type="hidden" id="census_id_hidden" name="census_id_hidden" value="<?php echo set_value('census_id_hidden'); ?>">
                  </div> <!-- /input-group -->
                </div>
    <?php     }  ?>
              <div class="form-group col-lg-2 col-sm-2">
                <div class="input-group addon">
                  <input class="form-control  form-control-sm" placeholder="ඇතු. වීමේ අංකය..." name="index_no_txt" id="index_no_txt" type="text" value="<?php echo set_value('index_no_txt'); ?>">
                </div> <!-- /input-group -->
              </div>
              <div class="form-group col-lg-1 col-sm-1">
                <div class="input-group addon">
                  <select class="form-control form-control-sm" id="gender_select" name="gender_select" title="Select the gender">
                  <option value="" selected>ස්ත්‍රී/පුරුෂ...</option>
            <?php   foreach ($this->all_genders as $row){ ?><!-- from PhysicalResource controller constructor method -->
                      <option value="<?php echo $row->gender_id; ?>"><?php echo $row->gender_name; ?></option>
            <?php   } ?>  
                  </select>
                </div> <!-- /input-group -->
              </div>
              <div class="form-group col-lg-1 col-sm-1">
                <div class="input-group addon">
                  <select class="form-control form-control-sm" id="religion_select" name="religion_select" title="Select the religion">
                  <option value="" selected>ආගම...</option>
            <?php   foreach ($this->all_religion as $row){ ?><!-- from PhysicalResource controller constructor method -->
                      <option value="<?php echo $row->religion_id; ?>"><?php echo $row->religion; ?></option>
            <?php   } ?>  
                  </select>
                </div> <!-- /input-group -->
              </div>
              <div class="form-group col-lg-2 col-sm-2">
                <div class="input-group addon">
                  <select class="form-control form-control-sm" id="ethnic_group_select" name="ethnic_group_select" title="Select the ethnic group">
                  <option value="" selected>ජාතිය...</option>
                    <?php foreach ($this->all_ethnic_groups as $row){ ?><!-- from PhysicalResource controller constructor method -->
                    <option value="<?php echo $row->ethnic_group_id; ?>"><?php echo $row->ethnic_group; ?></option>
                    <?php } ?>  
                  </select>
                </div> <!-- /input-group -->
              </div>
              <div class="form-group col-lg-1 col-sm-1">
                <div class="input-group addon">
                  <select class="form-control form-control-sm" id="status_select" name="status_select" title="Select the status">
                  <option value="" selected>Status...</option>
                    <?php foreach ($this->all_student_status as $row){ ?><!-- from PhysicalResource controller constructor method -->
                    <option value="<?php echo $row->st_status_id; ?>"><?php echo $row->st_status; ?></option>
                    <?php } ?>  
                  </select>
                </div> <!-- /input-group -->
              </div>
              <div class="form-group col-lg-1 col-sm-1">
                <div class="input-group addon">
                  <button type="submit" class="btn btn-primary btn-sm" id="std_search_btn" name="std_search_btn" title="Submit" value="View"><i class="fa fa-search"></i> View</button>
                  <button type="button" class="btn btn-success btn-sm ml-2" data-toggle="modal" data-target="#helpModal"><i class="fa fa-question"></i></button>
                  <button type="reset" class="btn btn-danger btn-sm ml-2" id="student_search_form_reset_btn"> Reset </button>
                </div> <!-- /input-group -->
              </div>
            </div> <!-- /row -->
          </form> <!-- /form -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / #search-bar-row -->
<!-- ------------------------------------------------------------------------------------------------------------------- -->
<?php
      if(!empty($this->session->flashdata('msg'))) {
          $message = $this->session->flashdata('msg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
<?php } ?> 
      <div class="row" id="">
        <div class="col-lg-12">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> ශිෂ්‍ය තොරතුරු 
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <h5 align="center">
              <?php if( $role_id == '2' ){
                      echo $school_name; 
                    }else{

                    }
              ?>
                  </h5>
          <?php if( !empty($std_all_info) ) { ?>   
                  <div class="">
                    <table id="studentTable" class="stripe row-border order-column table-responsive table-hover" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> ඇතුළත් වීමේ අංකය  </th>
                          <th> මුලකුරු සමඟ නම </th>
                          <th> සම්පූර්ණ නම </th>
                          <th> පාසැල </th>
                          <th> පන්තිය  </th>
                          <th> ලිපිනය </th>
                          <th> දු.ක. (Mobile) 1</th>
                          <th> දු.ක. (WhatsApp) 2</th>
                          <th> දු.ක. (Home)</th>
                          <th>උපන් දිනය</th>
                          <th>ස්ත්‍රී/පුරුෂ</th>
                          <th>ජාතිය</th>
                          <th>ආගම</th>
                          <th>ඇතුළත් වූ දිනය </th>
                          <th> තත්වය </th>
                          <th>යාවත්කාලීන වූ දිනය</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        $latest_upd_dt = 0;
                        foreach ( $std_all_info as $row ){ 
                          $st_id = $row->st_id;
                          $index_no = $row->index_no;
                          $name_with_initials = $row->name_with_initials;
                          $full_name = $row->fullname;
                          $address = $row->address1.', '.$row->address2;
                          $phone_no_1 = $row->phone_no_1;
                          $phone_no_2 = $row->phone_no_2;
                          $phone_home = $row->phone_home;
                          $school = $row->sch_name;
                          $dob = $row->dob;
                          $gender_name = $row->gender_name;
                          $ethnic_group = $row->ethnic_group;
                          $religion = $row->religion;
                          $d_o_admission = $row->d_o_admission;
                          $census_id = $row->census_id;
                          $st_status = $row->st_status; // active/inactive/left the school
                          $update_dt = $row->last_update;
                          if($latest_upd_dt < $update_dt){
                            $latest_upd_dt = $update_dt;
                          }

                          $ci = & get_instance();
                          $ci->load->model('Student_model');
                          //$year = date('Year');
                          $results = $ci->Student_model->get_student_current_grade_class($index_no, $census_id);
                          if ( !empty($results) ) {
                            foreach ($results as $result) {
                              $class = $result->grade.' '.$result->class;
                            }
                          }else{
                            $class = 'N/A';
                          }
                        $no = $no + 1;  ?>
                        <tr id="<?php echo 'tbrow'.$st_id; ?>">
                          <td><?php echo $no; ?></td>
                          <td style="vertical-align:middle" ><?php echo $index_no; ?></td>
                          <td style="vertical-align:middle;"><?php echo $name_with_initials; ?></td>
                          <td style="vertical-align:middle;"><?php echo $full_name; ?></td>
                          <td style="vertical-align:middle" ><?php echo $school; ?></td>
                          <td style="vertical-align:middle" ><?php echo $class; ?></td>
                          <td style="vertical-align:middle;"><?php echo $address; ?></td>
                          <td style="vertical-align:middle" ><?php echo $phone_no_1; ?></td>
                          <td style="vertical-align:middle" ><?php echo $phone_no_2; ?></td>
                          <td style="vertical-align:middle" ><?php echo $phone_home; ?></td>
                          <td style="vertical-align:middle" ><?php echo $dob; ?></td>
                          <td style="vertical-align:middle" ><?php echo $gender_name; ?></td>
                          <td style="vertical-align:middle" ><?php echo $ethnic_group; ?></td>
                          <td style="vertical-align:middle" ><?php echo $religion; ?></td>
                          <td style="vertical-align:middle" ><?php echo $d_o_admission; ?></td>
                          <td style="vertical-align:middle" ><?php echo $st_status; ?></td>
                          <td style="vertical-align:middle" ><?php echo $update_dt; ?></td>
                        </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
            <?php }else{ echo 'Search Students';} ?>  <!-- end of By task report -->
                </div> <!-- /col-lg-12 --> 
              </div> <!-- /row -->
            </div> <!-- /card-body -->
            <div class="card-footer small text-muted">
              <?php 
                if( !empty($std_all_info) ) { 
                  $latest_upd_dt = strtotime($latest_upd_dt);
                  $building_update_dt = date("j F Y",$latest_upd_dt);
                  $building_update_tm = date("h:i A",$latest_upd_dt);
                  echo 'Updated on '.$building_update_dt.' at '.$building_update_tm;
                }
              ?>
            </div>            
          </div> <!-- /card -->
        </div> <!-- /col-lg-12 -->
      </div> <!-- /row # -->
    </div> <!-- /container-fluid -->
    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> ශිෂ්‍ය වාර්ථා ලබා ගැනීම </h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  1. එක් සිසුවකුගේ detail report එකක් ලබා ගැනීමට ඇතලත් වීමේ අංකය ඇතුළත් කර View ක්ලික් කරන්න. <br>
                  2. දී ඇති drop down menu භාවිත කර අනෙකුත් ශිෂ්‍ය තොරතුරු ලබා ගත හැකිය. <br>
                  

                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.select.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#staffTable111').DataTable( {
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
    </script>
  <script type="text/javascript">
    $(document).ready(function() {  
      $('#school_txt').focus(function() {
        $(this).val('');
    });
      $("#student_search_form_reset_btn").click(function(){
        //$('#census_id_hidden').val('');
        //$('#school_txt').html('');
      });
        // date picker
      $('.datepicker').datepicker({
          dateFormat: 'yy-mm-dd',
          changeYear: true,
          yearRange:'1955:',
      })

      $('#studentTable').DataTable({
        //pageLength: '15',
        dom: 'Bfrtip',
        buttons: [
          {
            extend: 'excel',
            text: 'Save',
            exportOptions: {
                modifier: {
                    //page: 'current'
                    page: 'all'
                }
            }
          }
        ],  
        //paging: false,      
        //scrollY: "600px",
        // fixedColumns: {
        //   leftColumns:3
        // },
        // scrollX: true   
      });

      // auto complete when type school name
      $( "#school_txt" ).autocomplete({
        source: function( request, response ) {
          // Fetch data
          $.ajax({
            url: "<?=base_url()?>School/viewSchoolList",
            type: 'post',
            dataType: "json",
            data: {
              search: request.term
            },
            success: function( data ) {
              response( data );
            }
          });
        },
        //appendTo: "#school_txt",
        select: function (event, ui) {
          // Set selection
          $('#school_txt').val(ui.item.label); // display the selected text
          $('#census_id_hidden').val(ui.item.value); // save selected id to input
          //alert(ui.item.value);
          return false;
        }
      });
    });
  </script>