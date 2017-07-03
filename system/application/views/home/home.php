<?php $this->load->view('template/header') ?>
<!---==============================CUSTOM CSS================================================-->		
<!--tambahkan custom css disini-->
<!-- iCheck -->
<link href="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<!-- Date Picker -->
<link href="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<!---+++++++++++++++++++++++++++CUSTOM CSS END+++++++++++++++++++++++++++++++++++--->		
	
<?php $this->load->view('template/topbar') ?>	
<?php $this->load->view('template/sidebar') ?>	
<!----------------------------------------------------->
<!--tambahkan custom Js disini-->

<!-- jQuery 2.1.3 ???-->
<!-- Bootstrap 3.3.2 JS ???-->
<!---
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
--->

<!---=====================================--->
  <!-- Main content -->
 <section class="content">	
<!----===============================---->

	
	<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
            Selamat Datang : <strong><?php echo $_SESSION['USER_NAME'];?></strong>
    </div>
</section>	


<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="http://192.168.3.14/new_sapm/public/images/toolbar/icon-48-article.png" align="middle" /> 
                    Berita <strong>SAPM</strong>
    </div>
</section>	

  <!-- ROW -->
    <div class="row">
        <div class="col-xs-12">
<br/>
<?php
// print_r($news);   
	foreach($news as $row){
?>		
			

                <ul>
                   <li>
				   <font color="blue">
				   <b><?php echo $row->JUDUL." "."(".$row->TANGGAL.")"  ; ?></b>
				   </font>
				   </li>

                	<div style="color:#000; margin:0px 0px">
					<?php echo $row->ISI; ?>
                	</div>
                </ul>			
			
<!----
                <ul>
                   <li><font color="blue"><b>Perpanjangan Waktu Redeem Poin Program SGP ( 10-OCT-16 )</b></font></li>

                	<div style="color:#000; margin:0px 0px">
                		Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting
                	</div>
                </ul>
---->			



         
    <!-- /.content -->
    <br/>
<?php			
		}
?>

		
		

         </div>
    </div>
  <!-- ROW END-->

<!----===============================---->
</section>
<!----===============================---->
<!------------------------------------------------------------->
<?php $this->load->view('template/js') ?>	
<!---====================CUSTOM JS=========================================--->		
<!--tambahkan custom js disini-->
<!-- Sparkline -->
<script src="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- datepicker -->
<script src="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/chartjs/Chart.min.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/dist/js/pages/dashboard2.js" type="text/javascript"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/dist/js/demo.js" type="text/javascript"></script>
<!---===============================CUSTOM JS END================================================--->		

<?php $this->load->view('template/footer') ?>	
