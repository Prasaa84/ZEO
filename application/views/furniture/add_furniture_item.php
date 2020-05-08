<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>user">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>school">School</a>
        </li>
        <li class="breadcrumb-item active">Furniture Items</li>
      </ol>
      <div class="row">
        <div class="col-lg-8">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-building"></i> ලී බඩු තොරතුරු ඇතුළත් කිරීම
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                    $attributes = array("class" => "form-horizontal", "id" => "insert-furniture", "name" => "insert-furniture");
                    echo form_open("Furniture/addFurnitureDetails", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="census id">සංඝණන අංකය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="census_id" name="census_id" title="Please select">
                            <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                            <option value="">27025</option>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="library item">අයිතමය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="lib_item" name="lib_item">
                            <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                            <option value="">ළදරු ඩෙස්ක් (1-4 ශ්‍රේණි)-C වර්ගය</option>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="library item">තත්ත්වය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="lib_item" name="lib_item">
                            <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                            <option>භාවිතයට ගතහැකි</option>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="quantity" class="control-label">තිබෙන ප්‍රමාණය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="quantity" name="quantity" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('quantity'); ?>" />
                          <span class="text-danger"><?php echo form_error('quantity'); ?></span>
                        </div>
                      </div>
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3"></div>
                        <div class="col-lg-9 col-sm-9 ">
                          <input id="btn_insert_school" name="btn_insert_school" type="submit" class="btn btn-primary mr-2 mt-2" value="Submit" />
                          <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-warning mt-2" value="Cancel" style="margin-top: 10px;" />
                        </div>
                      </div>
                    </div> <!-- /form group -->
                  </fieldset>
                  <?php echo form_close(); ?>
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /card body -->
          </div> <!-- /card -->
          <hr class="mt-2">
        </div> <!-- /col-lg-8 -->
        <div class="col-lg-4">
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-building"></i> ලී බඩු අයිතම ඇතුළත් කිරීම
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                    $attributes = array("class" => "form-horizontal", "id" => "insert-furniture", "name" => "insert-furniture");
                    echo form_open("Furniture/addFurnitureItem", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="library item">තිබෙන අයිතම</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="lib_item" name="lib_item">
                            <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                            <option>ළදරු ඩෙස්ක් (1-4 ශ්‍රේණි)-C වර්ගය</option>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="quantity" class="control-label">නව අයිතමය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="quantity" name="quantity" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('quantity'); ?>" />
                          <span class="text-danger"><?php echo form_error('quantity'); ?></span>
                        </div>
                      </div>
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3"></div>
                        <div class="col-lg-9 col-sm-9 ">
                          <input id="btn_insert_school" name="btn_insert_school" type="submit" class="btn btn-primary mr-2 mt-2" value="Submit" />
                          <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-warning mt-2" value="Cancel" style="margin-top: 10px;" />
                        </div>
                      </div>
                    </div> <!-- /form group -->
                  </fieldset>
                  <?php echo form_close(); ?>
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /card body -->
          </div> <!-- /card -->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-building"></i> ලී බඩු අයිතම තත්ත්වය ඇතුළත් කිරීම
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
                  <?php
                    $attributes = array("class" => "form-horizontal", "id" => "insert-furniture-status", "name" => "insert-furniture-status");
                    echo form_open("Furniture/addFurnitureItemStatus", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="library item">තිබේන ත්ත්ත්වය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <select class="form-control" id="lib_item" name="lib_item">
                            <option value="" selected>මෙහි ක්ලික් කරන්න</option>
                            <option>භාවිතයට ගතහැකි</option>
                          </select>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="quantity" class="control-label">නව තත්ත්වය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input class="form-control" id="fur_item_status" name="fur_item_status" placeholder="ඇතුළත් කරන්න" type="text" value="<?php echo set_value('fur_item_status'); ?>" />
                          <span class="text-danger"><?php echo form_error('fur_item_status'); ?></span>
                        </div>
                      </div>
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3"></div>
                        <div class="col-lg-9 col-sm-9 ">
                          <input id="btn_insert_school" name="btn_insert_school" type="submit" class="btn btn-primary mr-2 mt-2" value="Submit" />
                          <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-warning mt-2" value="Cancel" style="margin-top: 10px;" />
                        </div>
                      </div>
                    </div> <!-- /form group -->
                  </fieldset>
                  <?php echo form_close(); ?>
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /card body -->
          </div> <!-- /card -->
        </div> <!-- /col-lg-8 -->
      </div> <!-- /row -->
    </div> <!-- /container-fluid -->