// this code was cut and pasted here from user_admin_header to test the alert function through aJax
            <h6 class="dropdown-header"> New Alerts : </h6>
            <div class="dropdown-divider"></div>
            <div style="overflow-y:scroll; max-height:450px;">
              <?php
               if($user_data['userrole']=='School User'){  
                foreach($this->phy_res_alert as $row) {
                  $id = $row->alert_id;
                  $alert_cat_id = $row->alert_cat_id;
                  $censusId = $row->to_whom;
                  $date_updated = $row->date_updated;
                  $date_updated = strtotime($date_updated);
                  $date = date("Y-m-d",$date_updated);
                  $time = date("h:i A",$date_updated);
              ?>
            <?php   if($user_data['userrole']=='School User'){ // check whether the user is school ?>
              <a class="dropdown-item" href="<?php echo base_url(); ?>alert/viewAlertPageById/<?php echo $id; ?>">
            <?php } ?>
            <?php   if($user_data['userrole']=='System Administrator'){ // check whether the user is Admin ?>
              <a class="dropdown-item" href="<?php echo base_url(); ?>alert/viewAlertPageById/<?php echo $alert_cat_id; ?>">
            <?php } ?>
                <span class="text-success">
                  <strong>
                    <i class="fa fa-long-arrow-up fa-fw"></i><?php echo $row->alert_category." to be updated "; ?>
                  </strong>
                </span>
                <span class="small float-right text-muted"><?php echo $date.' '.$time; ?></span>
                <div class="dropdown-message small"><?php echo $row->alert_desc; ?></div>
              </a>
              <div class="dropdown-divider"></div>
            <?php } } ?>
              <?php
               if($user_data['userrole']=='System Administrator'){  
                //print_r($this->phy_res_alert); die();
                foreach($this->phy_res_alert as $row) {
                  $count = $row->count;
                  $alert_cat_id = $row->alert_cat_id;
                  $date_updated = $row->date_updated;
                  $date_updated = strtotime($date_updated);
                  $date = date("Y-m-d",$date_updated);
                  $time = date("h:i A",$date_updated);
              ?>
              <a class="dropdown-item" href="<?php echo base_url(); ?>alert/viewAlertPageById/<?php echo $alert_cat_id; ?>">
                <span class="text-success">
                  <strong>
                    <i class="fa fa-long-arrow-up fa-fw"></i><?php echo $row->alert_category." to be updated "; ?>
                  </strong>
                </span>
                <span class="small float-right text-muted"><?php echo $date.' '.$time; ?></span>
                <div class="dropdown-message small"><?php echo $count.' Schools'; ?></div>
              </a>
              <div class="dropdown-divider"></div>
              <?php } } ?>
            </div>
            <?php   if($user_data['userrole']=='School User'){ // check whether the user is school
            ?>
              <a class="dropdown-item small" href="<?php echo base_url(); ?>alert/viewAllAlertsPage/<?php echo $censusId; ?>">View all alerts</a>
            <?php }else{ ?> 
              <a class="dropdown-item small" href="<?php echo base_url(); ?>alert/viewAllAlertsPage">View all alerts</a>
            <?php } ?>