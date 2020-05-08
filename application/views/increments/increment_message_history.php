              <div class="row">
                <div class="col-lg-12 col-sm-12 my-auto">
                  <?php if(!empty($message_history)) { //print_r($increment_data); die(); ?>   
                  <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-hover" cellspacing="0">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th> Name </th>
                          <th> Message </th>
                          <th> Increment Year</th>
                          <th> Is read?</th>
                          <th> When read</th>
                          <th> By whom?</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $no = 0;
                        //$latest_upd_dt = 0;
                        foreach ($message_history as $row){  
                          $name_with_ini = $row->name_with_ini;
                          $message = $row->message;
                          //$census_id = $row->census_id;
                          $academic_year = $row->academic_year;
                          $is_read = $row->is_read;
                          $when_read = $row->when_read;
                          $by_whom = $row->by_whom;
                      ?>
                        <tr>
                          <th><?php //echo $no; ?></th>
                          <td style="vertical-align:middle;"><?php echo $name_with_ini; ?></td>
                          <td style="vertical-align:middle" ><?php echo $message; ?></td>
                          <td style="vertical-align:middle" ><?php echo $academic_year; ?></td>
                          <td style="vertical-align:middle" ><?php echo $is_read; ?></td>
                          <td style="vertical-align:middle" ><?php echo $when_read; ?></td>
                          <td style="vertical-align:middle" ><?php echo $by_whom; ?></td>
                        </tr>
                  <?php } // end foreach ?>
                      </tbody>
                    </table>
                  </div> <!-- /table-responsive -->
                <?php 
                  } ?>  
              </div> 
            </div> <!-- /col-lg-12 -->     
