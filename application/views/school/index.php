  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>user">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">School</li>
        <?php //echo $this->session->userdata['userrole_id']; 
              //print_r($this->session->all_userdata());
        ?>

      </ol>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-building"></i>
              </div>
              <div class="mr-5">
                <?php
                  foreach($this->session as $user_data){
                    $userrole = $user_data['userrole'];
                    $userid = $user_data['userid'];
                  }
                  if($userrole=='System Administrator'){
                    echo 'Insert School Details';
                  }else if($userrole=='School User'){
                    echo 'Update School Details';
                  }else{ echo 'Search School Details'; }
                ?>
              
              </div>
            </div>
            <?php if($userrole=='System Administrator'){ ?>
              <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>school/viewAddSchoolPage">
            <?php }else ?>
            <?php if($userrole=='School User'){ ?>
              <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>school/viewUpdateSchoolPage/<?php echo $userid; ?>">
            <?php } ?>              
            <span class="float-left">Go to form</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div> <!-- /Card Messages-->
        </div> <!-- /col-xl-3 col-sm-6 mb-3-->
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-search"></i>
              </div>
              <div class="mr-5">Find Schools</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>school/findSchoolPage">
              <span class="float-left">Go to search</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-laptop"></i>
              </div>
              <div class="mr-5">Computer Lab</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>computerLab/viewDetails">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-book"></i>
              </div>
              <div class="mr-5">Library</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>library/viewDetails">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-search"></i>
              </div>
              <div class="mr-5">Furniture Items</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>furniture/viewDetails">
              <span class="float-left">Go to search</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /Card Messages-->
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-search"></i>
              </div>
              <div class="mr-5">Physical Resources</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>physicalResource/viewAddPhysicalResourcePage">
              <span class="float-left">Go to search</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-secondary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-building"></i>
              </div>
              <div class="mr-5">Buildings</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>building/viewDetails">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-info o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-search"></i>
              </div>
              <div class="mr-5">Sanitary Items</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo base_url(); ?>Sanitary/viewDetails">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div><!-- /card-->
        </div>
      </div><!-- /row1-->

    </div> <!-- /.container-fluid-->
    <!-- /.content-wrapper-->