<style type="text/css">
  .responsive {
    max-width: 600px;
      height: auto;
      border: 7px solid #f6f6f6;
  }
  #archive ul li a:hover{
            text-decoration: none;
            text-decoration: underline;
  }
  #archive ul li a{font-size: 13px; color:#7b8989;}
  #pageHeading{margin-bottom: 20px;}
  #btn_add_news{ color:ffffff;}
  .imgPrw{
    max-width: 400px; max-height: 300px;
  }
  .deleteNews:hover{text-decoration: underline;}
  .deleteNews{color:#0000ff;}
</style>
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>user">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?php echo base_url(); ?>news">News</a>
        </li>
      </ol>
      <?php
        if(!empty($this->session->flashdata('msg'))) {
          $message = $this->session->flashdata('msg');  ?>
          <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
      <?php } ?> 
      <?php
        if(!empty($this->session->flashdata('imgUploadSuccess'))) {
          $message = $this->session->flashdata('imgUploadSuccess');  ?>
          <div class="alert alert-success" ><?php echo $message; ?></div>
      <?php } ?> 
      <?php
        if(!empty($this->session->flashdata('imgUploadError'))) {
          $message = $this->session->flashdata('imgUploadError');  
            foreach ($message as $item => $value){
              echo '<div class="alert alert-danger" >'.$item.' : '.$value.'</div>';
            }
       } ?> 
      <div class="row">     
        <div class="col-lg-12 col-sm-12">
          <div class="row">
            <div class="col-lg-9 col-sm-9">
        <?php   $userRole = $this->session->userdata['userrole']; 
                if($userRole=='System Administrator' || $userRole=='Zonal User'){ ?>
                  <a id="btn_add_news" name="btn_add_news" type="button" class="btn btn-primary btn-sm" value="Add" data-toggle="modal" data-target="#addNewsModal"><i class="fa fa-plus"></i> Add New</a>
        <?php   } ?>

              <center><h2 id="pageHeading"><?php echo $heading; ?></h2></center>
        <?php if(empty($news)){ ?>
                <div class="alert alert-danger"> No recent news found  </div>
        <?php }else{
                foreach ($news as $news) { $news_id = $news->news_id; ?>
                    <div class="news<?php echo $news_id?>">
                        <h4><?php echo $news->news_title; ?></h4>
                  <?php   if(file_exists("./assets/images/news/$news_id.jpg")){ ?>
                                  <img src="<?php echo base_url(); ?>assets/images/news/<?php echo $news_id; ?>.jpg" style="" class="responsive" >
                  <?php   }  ?>
                        <p><?php echo $news->news_text; ?></p>
                <?php   $added_dt_tm = strtotime($news->date_added);
                        $added_dt = date("j F Y",$added_dt_tm);
                        $added_tm = date("h:i A",$added_dt_tm);
                ?>
                        <p><small><?php echo 'Added on '.$added_dt.' at '.$added_tm.' by '.$news->by_whom; ?></small>
                    <?php 
                        // echo $this->session->userdata['userrole'];
                        if($this->session->userdata['userrole'] == 'System Administrator'){
                          echo ' <small><a href="'.base_url().'news/newsUpdateView/'.$news_id.'"> Edit </a> or <a href="" class="deleteNews" data-id="'.$news_id.'"> Remove </a></small>';
                        }
                    ?>
                        </p>
                    </div>
        <?php   }
              }       
        ?>
            </div> <!--/ .col-lg-8 col-sm-8 -->
            <div class="col-lg-3 col-sm-3" id="archive">
                <h2>Archive</h2>
          <?php   if(!empty($newsAddedDate)){ ?>
                      <ul type="circle" style="padding-left: 10px; ">
              <?php   foreach ($newsAddedDate as $newsAddedDate) {
                          $added_dt_tm = strtotime($newsAddedDate->date_added);
                          $year_month = date("Y F",$added_dt_tm);  // month name
                          $year_month2 = date("Y-m",$added_dt_tm); // month number
                          echo '<li><a href="'.base_url().'news/viewNewsByMonth/'.$year_month2.' ">'.$year_month.'</a></li>'; 
                          echo '<hr style="margin-top:5px;margin-bottom:5px;">';
                          ?>

          <?php       }   ?>
                      </ul>
          <?php   }   ?>
            </div><!--/ .col-lg-3 col-sm-3 -->
          </div> <!-- /.row -->
        </div> <!-- /.col-lg-12 col-sm-12 -->
      </div> <!-- / row -->
      <!-- /following bootstrap model used to insert school students -->
      <div class="modal fade" id="addNewsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-building"></i> පුවත් ඇතුළත් කිරීම</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
           <?php
                  $attributes = array("class" => "form-horizontal", "id" => "add_news_form", "name" => "add_news_form", "accept-charset" => "UTF-8" );
                  echo form_open_multipart("News/addNews", $attributes);?>
                  <fieldset>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="census id">සිරස්තලය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <textarea class="form-control" id="title_txtarea" name="title_txtarea" rows="1"></textarea>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="item name">පුවත් විස්තරය</label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <textarea class="form-control" id="text_txtarea" name="text_txtarea" rows="5"></textarea>
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="featured image" class="control-label"> Featured Image </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <input type="file" name="featured_image" size="20" id="featured_image" title="Change Image" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-3 col-sm-3">
                          <label for="featured image Preview" class="control-label">  </label>
                        </div>
                        <div class="col-lg-9 col-sm-9">
                          <img id="imgPrw" src="#" alt="" class="imgPrw" />
                        </div>
                      </div> <!-- /row -->
                    </div> <!-- /form group -->
                  <!-- <fieldset> -->
                </div> <!-- /col-sm-12 -->
              </div> <!-- /row -->
            </div> <!-- /modal-body -->
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit" name="btn_add" value="Add_New">Add</button>
            </div> <!-- /modal-footer -->
            </fieldset>
                <?php echo form_close(); ?>
          </div> <!-- /#bootstrap model content -->
        </div> <!-- /#bootstrap model dialog -->
      </div> <!-- / .modal fade -->
    </div><!-- / container-fluid -->
<!--     here jquery.min.js is loaded again because image upload preview not displayed -->    
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#imgPrw').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $(document).ready(function() {    
    $("#featured_image").change(function(){
          readURL(this);
      });
  });
  $(".deleteNews").click(function(e){
      e.preventDefault();
      var div_id = $(this).parents("div").attr("class");
      var news_id = $(this).attr("data-id");
      //alert(news_id);
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
            url:"<?php echo base_url(); ?>news/deleteNews",  
            method:"POST",  
            data:{news_id:news_id}, 
            error: function() {
              alert('Something is wrong');
            },
             success: function(data) {
                  if(data.trim()=='true'){
                    $("."+div_id).remove();
                    swal("Deleted!", "News has been deleted.", "success");
                  }else{
                    swal("Error!", "News not deleted.", "error");
                  }
             }
          });
        } 
      });
     
    });
</script>