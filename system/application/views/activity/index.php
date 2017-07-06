
<?php $this->load->view('default/header') ?>		
<style>


table{
border:  solid #25BAE4;
border-collapse:collapse;
margin-top: 10px;
margin-left: 10px;
}
td{
width: 50px;
height: 50px;
text-align: center;
border: 1px solid #e2e0e0;
font-size: 18px;
font-weight: bold;
}
th{
height: 50px;
padding-bottom: 8px;
background:#25BAE4;
font-size: 20px;
}
.prev_sign a, .next_sign a{
color:white;
text-decoration: none;
}
tr.week_name{
font-size: 16px;
font-weight:400;
color:red;
width: 10px;
background-color: #efe8e8;
}
.highlight{
background-color:#25BAE4;
color:white;
height: 27px;
padding-top: 13px;
padding-bottom: 7px;
}


</style>
<!-- =============================================== -->
   	<section class="content2">

	
<!---=====================================--->
<script type="text/javascript">

	$(function() {
		$("#tabs").tabs();
	
		$("#START").datepicker({
			showOn: 'button',
			buttonImage: '<?php echo ICONS ?>calendar.gif',
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#START').datepicker('option', {dateFormat: 'd-m-yy'});
		
		$("#END").datepicker({
			showOn: 'button',
			buttonImage: '<?php echo ICONS ?>calendar.gif',
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#END').datepicker('option', {dateFormat: 'd-m-yy'});
		
		//-------------------------------------
		//	Set action if submit 
		//-------------------------------------
		$('#submit').click(function(){
			//alert("submit");
			getReport(0);	
		})

		//--------------------------------------------
		//	Function to get ajax content of report
		//--------------------------------------------
		function getReport(ex){
			var start = $('#START').val();
			var end = $('#END').val();
			var id = '';
			//var id = '<?php echo $id = ($this->session->userdata('USER_LEVEL')=='SALES')?$this->session->userdata('ID'):0; ?>';
			var id = '16622';
			
			if( id!=0 ){
				id = id; 
			}else id = $('#ID').val();
			
			
			
				if(ex == 0){
					
					if(id ==0){alert('NPP tidak boleh kosong');}
					else
					if(start == ''){alert('Tanggal mulai tidak boleh kosong');}
					else
					if(end == ''){alert('Tanggal akhir tidak boleh kosong');}
					else{
					//---------------------------	
					<?php $type =  (isset($type))?$type:0; ?>
					/*
					alert(start);
					alert(end);
					alert(id);
					*/
				var urls = '<?php echo site_url('/report/getcc/')?>/'+id + '/'+<?php echo $type ?>+ '/' +start+'/'+end; 
/*

					$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
					$("#report").load(urls)
*/
//				var urls = '<?php echo site_url('/tes/tabel/')?>';
//				var urls = '<?php echo site_url('/report/getcc/')?>/'+id +'/'+<?php echo $type ?>+'/'+start+'/'end; 

				$("#report").load(urls);
				//alert("alert get respon 0");
					//---------------------------					
					}
			
				}
			
		}		
		
		
		
		
	});
</script>		
	
<!-- Content Wrapper. Contains page content 
<div class="content-wrapper">
-->
<!-- Content Header (Page header) -->

	<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> SALES DASHBOARD
    </div>


</section>

            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">SALES DASHBOARD</a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
			  
              <div class="tab-content">
                <!-- tab1 
        <div class="row">
				-->
           <div class="tab-pane active" id="tab_1">


<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-6 col-xs-6">
         
 
 <?php
 echo $calendar;
 ?>
 
        </div><!-- ./col -->
		
        <div class="col-lg-6 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>100<sup style="font-size: 20px">%</sup></h3>
                    <p><input name="START" id="START" type="text" size="20" readonly="readonly" class="input"></p>
					<p><button name="START" id="START" >XXXXXXXXXXXX</button></p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
		<!-- ./col -->
		

    </div><!-- /.row -->
	


</section><!-- /.content -->


              <!-- /.tab-content 
            </div>
			  -->
            <!-- nav-tabs-custom -->
          </div>
          <!-- /.col -->


        </div>
         <!-- / end class .row -->
<!----===============================---->


</div><!-- /.content-wrapper -->
<script>
$().fullCalender({
	
	
	
});

</script>

<footer class="main-footer">

		
				<!--p style="float:right;">Valid <a href="http://validator.w3.org/check?uri=referer">HTML</a> &amp; <a href="http://jigsaw.w3.org/css-validator/">CSS</a><--/p>
				<!-- If you wish to delete this line of code please purchase our commercial license http://www.sixshootermedia.com/shop/commercial-license/ -->
                <p align=center>Hak Cipta © 2012 - 2017 PT BANK NEGARA INDONESIA, Tbk (Persero)</p>


</footer>
<!-- 
</div>
./wrapper -->

<!-- jQuery 2.1.3 -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src='http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/dist/js/app.min.js" type="text/javascript"></script>
<!--tambahkan custom js disini-->
<!-- jQuery UI 1.11.2 -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/js/jquery-ui.min.js" type="text/javascript"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Morris.js charts -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/js/raphael-min.js"></script>
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/knob/jquery.knob.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- datepicker -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/dist/js/pages/dashboard.js" type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<script src="http://192.168.3.14/new_sapm/ciadminlte/assets/AdminLTE-2.0.5/dist/js/demo.js" type="text/javascript"></script>

    </body>
</html>