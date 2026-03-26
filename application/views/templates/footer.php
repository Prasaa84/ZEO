    <!-- This is public site footer -->
    <section id="bottom">
        <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
            <div class="row">
                 <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>Navigation</h3>
                        <ul>
                            <li><a href="<?php echo base_url(); ?>">මුල් පිටුව</a></li>
                            <li><a href="<?php echo base_url(); ?>GeneralInfo/aboutUs">අප ගැන</a></li>
                            <li><a href="<?php echo base_url(); ?>GeneralInfo/director">කලාප අධ්‍යාපන අධ්‍යක්ෂ තුමිය</a></li>
                            <li><a href="<?php echo base_url(); ?>GeneralInfo/assDirectors">සහකාර අධ්‍යාපන අධ්‍යකෂක වරු</a></li>
                            <li><a href="<?php echo base_url(); ?>GeneralInfo/Contact">සම්බන්ධ වීම</a></li>
                        </ul>
                    </div>
                </div><!--/.col-md-3-->
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>කොට්ඨාශ</h3>
                        <ul>
                            <li><a href="<?php echo base_url(); ?>GeneralInfo/morawakaDiv">මොරවක</a></li>
                            <li><a href="<?php echo base_url(); ?>GeneralInfo/kotapolaDiv">කොටපොල</a></li>
                            <li><a href="<?php echo base_url(); ?>GeneralInfo/pasgodaDiv">පස්ගොඩ</a></li>
                        </ul>
                    </div>
                </div><!--/.col-md-3-->
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>ප්‍රතිඵල විශ්ලේෂණය</h3>
                        <ul>
                            <li><a href="#">අ.පො.ස. සා/පෙළ(O/L)</a></li>
                            <li><a href="#">අ.පො.ස. උ/පෙළ(A/L)</a></li>
                            <li><a href="#">ශිෂ්‍යත්ව විභාගය(Grade 5)</a></li>
                        </ul>
                    </div>
                </div><!--/.col-md-3-->
                <div class="col-md-3 col-sm-6">
                    <div class="widget">
                        <h3>අංශ</h3>
                        <ul>
                            <li><a href="<?php echo base_url(); ?>TeacherInstitution">ගුරු ආයතන අංශය</a></li>
                            <li><a href="<?php echo base_url(); ?>GeneralControl">සාමාන‍්‍ය පාලන අංශය</a></li>
                            <li><a href="<?php echo base_url(); ?>PlanningSection">සැළසුම් අංශය</a></li>
                            <li><a href="<?php echo base_url(); ?>DevelopmentSection">සංවර්ධන අංශය</a></li>
                            <li><a href="<?php echo base_url(); ?>salarySection">වැටුප් අංශය</a></li>
                            <li><a href="<?php echo base_url(); ?>AccountSection">ගිණුම් අංශය</a></li>
                        </ul>
                    </div>
                </div><!--/.col-md-3-->
            </div>
        </div>
    </section><!--/#bottom-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; <?php echo date("Y");  ?> <a target="_blank" href="http://shapebootstrap.net/" title="Free Twitter Bootstrap WordPress Themes and HTML templates">Deniyaya Zonal Education Office</a>. All Rights Reserved.
                    <br />
                    Designed and Developed by MGP Prasanna
                </div>
                <div class="col-sm-6">
                    <ul class="pull-right">
                        <li><a href="<?php echo base_url(); ?>">මුල් පිටුව</a></li>
                        <li><a href="<?php echo base_url(); ?>GeneralInfo/aboutUs">අප ගැන</a></li>
                        <li><a href="<?php echo base_url(); ?>GeneralInfo/Contact">සම්බන්ධ වීම</a></li>
                        <li><a href="<?php echo base_url(); ?>GeneralInfo/loginPage"> Login </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->

    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.prettyPhoto.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.isotope.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
    <!-- sweet alert-->
    <script src="<?php echo base_url(); ?>assets/js/sweetalert/sweetalert.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>

    <script src="<?php echo base_url(); ?>assets/fullcalendar/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/fullcalendar/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.min.js"></script>    

    <script type="text/javascript">
        $(document).ready(function(){
            var calendar = $('#calendar').fullCalendar({
                editable:true,
                header:{
                    //left:'prev,next today',
                    left:'title',
                    //center:'title',
                    //right:'month,agendaWeek,agendaDay'
                    right:'prev,next today',
                },
                events:"<?php echo base_url(); ?>FullCalendar/load",
                selectable:true,
                selectHelper:true,
                fixedWeekCount: false,
                contentHeight:"parent",
                contentHeight: 300,
                //height: 200 ,
                handleWindowResize:true,
                
                eventMouseover: function (data, event, view) {
                    tooltip = '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#f59d3f;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%; border-radius: 10px; color:#000000;">' + 'title: ' + ': ' + data.title + '</br>' + 'description: ' + ': ' + data.description + '</div>';
                    $("body").append(tooltip);
                    $(this).mouseover(function (e) {
                        $(this).css('z-index', 10000);
                        $('.tooltiptopicevent').fadeIn('500');
                        $('.tooltiptopicevent').fadeTo('10', 1.9);
                    }).mousemove(function (e) {
                        $('.tooltiptopicevent').css('top', e.pageY + 10);
                        $('.tooltiptopicevent').css('left', e.pageX + 20);
                    });
                },
                eventMouseout: function (data, event, view) {
                    $(this).css('z-index', 8);
                    $('.tooltiptopicevent').remove();
                },
                dayClick: function () {
                    tooltip.hide()
                },
                eventResizeStart: function () {
                    tooltip.hide()
                },
                eventDragStart: function () {
                    tooltip.hide()
                },
                viewDisplay: function () {
                    tooltip.hide()
                },
            });
        });
    </script>
</body>
</html>
