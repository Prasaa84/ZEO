<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section id="schools">
        <div class="container">
            <div class="wow fadeInDown">
                <div class="col-sm-1"></div>
                <div class="col-sm-9">
                    <div class="row">
                        <h2 class="h2 center">School Details</h2>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8">
                            <?php $attributes = array("class" => "form-inline", "id" => "devisionform", "name" => "devisionform");
                            echo form_open("School/viewSchool", $attributes); ?>
                                <div class="form-group">
                                    <label for="sel1">Select the devision:</label>
                                    <select class="form-control" id="sel1" name="devision">
                                        <option value="">All</option>
                                        <option value="d1">Morawaka</option>
                                        <option value="d2">Kotapola</option>
                                        <option value="d3">Pasgoda</option>
                                    </select>
                                </div>
                                <input id="btn_login" name="btn_submit" type="submit" class="btn btn-primary" value="Submit" />
                            <?php echo form_close(); ?>
                        </div>
                        <div class="col-sm-2"></div>
                    </div>
                    <?php
                    if(empty($schools)) {   ?>
                    <div class="alert alert-success" style="padding: 5px 5px 5px 0px;">
                        <?php echo 'No records!!!'; ?>
                    </div>
                    <?php }else{ ?>
                    <div class="row">
                        <table class="table table-responsive table-hover">
                            <tr><th>Census ID</th><th>Name</th><th>Address</th><th>Email</th><th>Devision</th></tr>
                            <?php     foreach($schools as $school){  ?>
                            <tr>
                                <td width="100"><?php echo $school['id']; ?></td>
                                <td><?php echo $school['sname']; ?></td>
                                <td><?php echo $school['address']; ?></td>
                                <td width=""><?php echo $school['email']; ?></td>
                                <td width=""><?php echo $school['devision_id']; ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
    </section><!-- end section school -->