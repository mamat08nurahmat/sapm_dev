</section>
</div>
<footer class="main-footer">
    <div class="">
      <!--<b>version</b> sapm-->
    </div>

    <strong>Hak Cipta &copy; 2012 - 2016<a href="#"> PT BANK NEGARA INDONESIA</a></strong>Tbk (Persero)
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!---
          <a href="<?php echo site_url('login/logout'); ?>">
            <i class="fa fa-circle-o text-red"></i> <span>Logout</span>
          </a>
-->		

<!-- Modal 
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Logut ?</h4>
      </div>
      <div class="modal-body">
	  
          <a href="<?php echo site_url('login/logout'); ?>">
        <button type="button" class="btn btn-primary">Logout</button>
          </a>	  
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
  
</div>
-->

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
	   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	   

	  <h4>Logout <i class="fa fa-lock"></i></h4>

	  </div>
      <div class="modal-body"><i class="fa fa-question-circle"></i> Are you sure you want to logout?</div>
      <div class="modal-footer">
	  <a href="<?php echo site_url('login/logout'); ?>" class="btn btn-primary btn-block">Logout</a></div>
    </div>
  </div>
</div>



<!-- jQuery 2.2.3 -->
<script type="text/javascript" src="<?php echo JQUERY_2_2_3_JS ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script type="text/javascript" src="<?php echo JQUERY_1_11_4_JS ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 --> 
<script type="text/javascript" src="<?php echo BOOTSTRAP_NEWJS ?>bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script type="text/javascript" src="<?php echo RAPHAEL_MIN_JS ?>"></script>
<script type="text/javascript" src="<?php echo PLUGINS_MORRISJS ?>"></script>
<!-- Sparkline -->
<script type="text/javascript" src="<?php echo PLUGINS_SPARKLINEJS ?>"></script>
<!-- jvectormap -->
<script type="text/javascript" src="<?php echo PLUGINS_JVECTORMAP_1_1_2_JS ?>"></script>
<script type="text/javascript" src="<?php echo PLUGINS_JVECTORMAP_WORLDJS ?>"></script>
<!-- jQuery Knob Chart -->
<script type="text/javascript" src="<?php echo PLUGINS_KNOBJS ?>"></script>

<script type="text/javascript" src="<?php echo MOMENTJS ?>"></script>
<!-- daterangepicker 
-->
<script type="text/javascript" src="<?php echo DATERANGEPICKERJS ?>"></script>
<!-- datepicker 
<script src="http://192.168.3.14/new_sapm/assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
-->
<script type="text/javascript" src="<?php echo DATEPICKERJS ?>"></script>



<!-- Bootstrap WYSIHTML5 -->
<script type="text/javascript" src="<?php echo PLUGINS_BOOTSTRAP_WYSIHTML5JS ?>"></script>
<!-- Slimscroll -->
<script type="text/javascript" src="<?php echo PLUGINS_SLIMSCROLLJS ?>"></script>
<!-- FastClick -->
<script type="text/javascript" src="<?php echo PLUGINS_FASTCLICKJS ?>"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="<?php echo DIST_APP_MIN_JS ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script type="text/javascript" src="<?php echo DIST_DASHBOARD_JS ?>"></script>
<!-- AdminLTE for demo purposes -->
<script type="text/javascript" src="<?php echo DIST_DEMO_JS ?>"></script>


<script src="http://192.168.3.14/new_sapm/assets/datatables/js/dataTables.bootstrap.js"></script>
<!-----
<script src="http://192.168.3.14/new_sapm/assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
-->


</body>
</html>