<!DOCTYPE html>
<html>
    <head>
	  <meta charset="UTF-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>SAPM | Sales Activity Performance and Activity</title>
 
 <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->		

<!--tambahkan custom Js disini-->

<!-- jQuery 2.1.3 ???-->
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS ???
-->
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

  
<!-- jQuery 2.1.3 -->
<!-- Bootstrap 3.3.2 JS -->
<!-- SlimScroll -->
<!-- FastClick -->
<!-- AdminLTE App -->
<!---
---->
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
<script src='http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/fastclick/fastclick.min.js'></script>
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/dist/js/app.min.js" type="text/javascript"></script>


<!--tambahkan custom css disini-->
 <!-- DataTables -->
  <link rel="stylesheet" href="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/datatables/dataTables.bootstrap.css">		

 <link rel="stylesheet" href="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">		

<!---
<link href="http://192.168.3.14/new_sapm//public/css/layout.css" rel="stylesheet" type="text/css" />
---->
<link href="http://192.168.3.14/new_sapm//public/css/flexigrid.css" rel="stylesheet" type="text/css" />
<link href="http://192.168.3.14/new_sapm//public/css/jquery.numeric.css" rel="stylesheet" type="text/css" />
<link href="http://192.168.3.14/new_sapm//public/css/jquery.treeview.css" rel="stylesheet" type="text/css" />
<link href="http://192.168.3.14/new_sapm//public/css/smart_wizard.css" rel="stylesheet" type="text/css" />
<link href="http://192.168.3.14/new_sapm//public/css/jui/1.8.4/redmond/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="http://192.168.3.14/new_sapm//public/css/flipclock.css" />
<!----
-->		

<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/jquery-ui-1.8.4.custom.min.js"></script>
<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/flexigrid.pack.js"></script>
<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/jquery.numeric.pack.js"></script>
<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/jquery.maskMoney.js"></script>
<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/number_format.js"></script>
<!--
--->

<!-------HEAD----------->		