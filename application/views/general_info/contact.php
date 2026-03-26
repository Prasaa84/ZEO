    <?php
$seg = $this->uri->segment(3);
if($seg !=''){
$segment = $seg;
}else{
   $segment = '';
 
}
     ?>
    <section id="contact-info">
        <div class="center">
            <h2>How to Reach Us?</h2>
        </div>
        <div class="gmap-area">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <div class="gmap">
<!--                             <img src="<?php echo base_url(); ?>assets/images/gmap1.png" />
 -->                            
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13339.890979551335!2d80.49031213123914!3d6.267239635481367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x245577121baf25cc!2sZonal+Education+Office!5e0!3m2!1sen!2slk!4v1462421950232" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-sm-7 map-content">
                        <ul class="row">
                            <li class="col-sm-6">
                                <address>
                                    <h2>කලාප අධ්‍යාපන කාර්යාලය</h2>
                                    <p> මිල්ල ඇල <br>
                                    මොරවක</p>
                                    <p>Phone:041 22 82345 <br>
                                    Email Address:morawakazeo@gmail.com</p>
                                </address>
                                <address>
                                    <h4>මොරවක කොට්ඨාස අධ්‍යාපන කාර්යාලය</h4>
                                    <p>මිල්ල ඇල, <br>
                                    මොරවක</p>
                                    <p>Phone:041 22 82345<br>
                                    Email Address:morawakazeo@domain.com</p>
                                </address>
                            </li>
                            <li class="col-sm-6">
                                <br />
                                <address>
                                    <h4>කොටපොල කොට්ඨාස අධ්‍යාපන කාර්යාලය</h4>
                                    <p>කොටපොල <br>
                                    <p>Phone:041 22 82345 <br>
                                    Email Address:morawakazeo@domain.com</p>
                                </address>
                                <address>
                                    <h4>පස්ගොඩ කොට්ඨාස අධ්‍යාපන කාර්යාලය</h4>
                                    <p>පස්ගොඩ <br>
                                    <p>Phone:041 34 84865 <br>
                                    Email Address:morawakazeo@domain.com</p>
                                </address>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>  <!--/gmap_area -->
    <section id="contact-page" >
        <input  type="hidden" id="hiddenSeg" value="<?php echo $segment; ?>">
        <div class="container" >
            <div class="center">
                <h2>Drop Your Message</h2>
                <p class="lead">ඔබගේ දුක් ගැනවිල්ල අපවෙත ඉදිරිපත් කරන්න</p>
            </div>
            <div class="row contact-wrap" style="border: 1px solid #eeeeee; padding: 20px; ">
        <?php   if($this->session->flashdata('msg')) {
                    $message = $this->session->flashdata('msg');  ?>
                    <div class="<?php echo $message['class']; ?>" ><?php echo $message['text']; ?></div>
        <?php   } ?> 
                <div class="col-sm-5 col-sm-offset-1">
                        <div class="status alert alert-success" style="display: none"></div>
        <?php       $attributes = array("class" => "form-horizontal contact-form", "id" => "contact-form", "name" => "contact-form", "accept-charset" => "UTF-8" );
                    echo form_open_multipart("UserMessages/sendMessage", $attributes);?>
                    <fieldset>
                            <div class="form-group">
                                <label>Name *</label>
                                <input type="text" name="name" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Email </label>
                                <input type="email" name="email" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Phone *</label>
                                <input type="text" name="phone" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Company Name</label>
                                <input type="text" name="company" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>To whom *</label>
                                <select class="form-control" id="to_whom_select" name="to_whom_select">
                                    <option value="" selected> Click to select </option>
                                    <option value="1" > System Administrator</option> <!-- here value=1 is 
                                    user_role_id -->
                                    <option value="3" > Zonal Education Office </option> <!-- here value=3 is user_role_id -->
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Subject *</label>
                                <input type="text" name="subject" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Message *</label>
                                <textarea name="message_txtarea" id="message" required="required" class="form-control" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" value="Send_message" class="btn btn-primary btn-lg" required="required">Submit Message</button>
                            </div>
                        </div>
                    </fieldset>
                <?php echo form_close(); ?>
            </div><!--/.col-sm-5-->
        </div><!--/.container-->
    </section><!--/#contact-page-->
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        var seg_id = $('#hiddenSeg').val();
        //alert(seg_id);
        if(seg_id != ""){
            $('html, body').animate({
                scrollTop: $('#contact-page').offset().top
            }, 'slow');
        }

    });
</script>