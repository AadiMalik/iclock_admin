<!-- footer -->
<?php
             include('../connect.php');
             $sql_footer = "select * from manage_website"; 
             $result_footer = $conn->query($sql_footer);
             $row_footer = mysqli_fetch_array($result_footer);
             ?>
            <footer class="footer"> © <?=date('Y')?> . All rights reserved | Design by <a href="#"><?php echo $row_footer['footer'];?></a></footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="../uses/js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../uses/js/lib/bootstrap/js/popper.min.js"></script>
    <script src="../uses/js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../uses/js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="../uses/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../uses/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>


    

    <script src="../uses/js/lib/weather/jquery.simpleWeather.min.js"></script>
    <script src="../uses/js/lib/weather/weather-init.js"></script>
    <script src="../uses/js/lib/owl-carousel/owl.carousel.min.js"></script>
    <script src="../uses/js/lib/owl-carousel/owl.carousel-init.js"></script>


    
    <!--Custom JavaScript -->
    <script src="../uses/js/custom.min.js"></script>
	
	<script src="../uses/bower_components/moment/min/moment.min.js"></script>
	<script src="../uses/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script src="../uses/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	
    <script src="../uses/js/lib/datatables/new_datatables.min.js"></script>
    <script src="../uses/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="../uses/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="../uses/js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="../uses/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="../uses/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="../uses/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="../uses/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
   <script src="../uses/js/lib/datatables/new_datatables-init.js"></script>
	<!--<script src="js/lib/chartist/chartist.min.js"></script>
    <script src="js/lib/chartist/chartist-plugin-tooltip.min.js"></script>
    <script src="js/lib/chartist/chartist-init.js"></script>-->
	
	<script src="../uses/js/lib/calendar-2/moment.latest.min.js"></script>
    <!-- scripit init-->
    <script src="../uses/js/lib/calendar-2/semantic.ui.min.js"></script>
    <!-- scripit init-->
    <script src="../uses/js/lib/calendar-2/prism.min.js"></script>
    <!-- scripit init-->
    <script src="../uses/js/lib/calendar-2/pignose.calendar.min.js"></script>
    <!-- scripit init-->
    <script src="../uses/js/lib/calendar-2/pignose.init.js"></script>

    <script src="../uses/js/nicEdit.js"></script>
    <!-- Security JS start -->
<!--<script src="js/f12_disable.js"></script>
<script src="js/disable_r_click.js"></script>
<script src="js/disable_everything.js"></script>
<script src="js/disable_ctrl_u.js"></script>
<script src="js/printscreen_disable.js"></script>
                    -->
        <!-- Security JS end -->
    <script>

    window.setTimeout(function() {
        $(".alert").fadeTo(400, 0).slideUp(400, function(){
            $(this).remove(); 
        });
    }, 4000);
  </script>
	

