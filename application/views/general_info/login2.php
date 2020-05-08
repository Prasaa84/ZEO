    <section id="login">
        <div class="container">
            <div class="wow fadeInDown">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="">
                      <?php echo validation_errors(); ?>
                      <?php echo form_open();?>

                      <div class="panel panel-primary">
                          <div class="panel-heading" style="background-color: #e6e6e6;">
                            <h3>Log in</h3>
                          </div>
                          <div class="panel-body">
                            <p>Please log in using your credentials</p>
                            <table class="table table-responsive">
                                <tr>
                                    <td>Email</td>
                                    <td><?php echo form_input('email'); ?></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td><?php echo form_password('password'); ?></td>
                                </tr>
                                <tr>
                                    <td>name</td>
                                    <td><?php echo form_input('name'); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php echo form_submit('submit', 'Log in', 'class="btn btn-primary"'); ?></td>
                                </tr>
                            </table>
                          </div>
                          <?php echo form_close();?>
                      </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </section><!--/about-us-->