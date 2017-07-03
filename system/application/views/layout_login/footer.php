<div class="container-fluid">
      <!-- Footer -->
      <footer>
          <div class="row">
              <div class="col-lg-12 col-sm-12" style="background-color:#055D67; height: 50px; line-height: 50px;">
                  <div class="container" style="font-size: 80%; color: #fff; ">Copyright &copy; 2012 - 2016 PT BANK NEGARA INDONESIA, Tbk (Persero)</div> <!-- #16434E -->
              </div>
          </div>
      </footer>
  </div>
  <!-- /.container -->

  <!-- jQuery -->
  <script src="<?php echo NEWJS.'jquery.js' ?>"></script>
  <script src="<?php echo NEWJS.'bootstrap.min.js' ?>"></script>
  <script src="<?php echo NEWJS.'html5shiv.js' ?>"></script>

  <!-- datetimepicker -->
  <script src="<?php echo NEWJS.'moment.js' ?>"></script>
  <script src="<?php echo NEWJS.'bootstrap-datetimepicker.min.js' ?>"></script>
  <!-- end datetimepicker -->

  <script src="<?php echo NEWJS.'respond.min.js' ?>"></script>


  <script type="text/javascript">
  /* Javascript validasi login */
   $("#btnlogin").click(function(){
      if($("#username").val() == ''){
          alert ('Username Anda Tidak Boleh Kosong');
          username.focus();
          return false;
      }
      else if($("#password").val() == ''){
          alert ('Password Anda Tidak Boleh Kosong');
          password.focus();
          return false;
      } else {
          $("#btnlogin").hide();
          $("#box_login").show();
          $("#frmlogin").submit();
      }
  });

  $(function () {
      var d=new Date();
      var month = d.getMonth();
      $('#start').datetimepicker({
          format: 'DD-MMM-YYYY',
          // //locale: 'id'
      });

      $('#end').datetimepicker({
          format: 'DD-MMM-YYYY',
          // //locale: 'id'
      });
      $('#end').datetimepicker({
          useCurrent: false //Important! See issue #1075
      });
        $("#start").on("dp.change", function (e) {
          $('#end').data("DateTimePicker").minDate(e.date);
          $('#end').data("DateTimePicker").maxDate(e.date.add(1, 'M').toDate());
      });
      $("#end").on("dp.change", function (e) {
          $('#start').data("DateTimePicker").maxDate(e.date);
      });
      // $('#start').datetimepicker();
      // $('#end').datetimepicker({
          // useCurrent: false //Important! See issue #1075
      // });

      // $("#start").on("dp.change", function (e) {
          // $('#end').data("DateTimePicker").minDate(e.date);
          // $('#end').datetimepicker('setStartDate',e.date);
      // });
      // $("#start").on("dp.change", function (e) {
          // $('#end').data("DateTimePicker").maxDate(e.date);
      // });
  });

  </script>


</body>
</html>
