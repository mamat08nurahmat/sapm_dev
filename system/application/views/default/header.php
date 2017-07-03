<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SAPM - Sales Activity Performance Management New</title>
  <link rel="shortcut icon" href="<?php echo favicon.'favicon.jpg' ?>"><!-- Favicon and touch icons -->

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 --> 
  <link rel="stylesheet" href="<?php echo BOOTSTRAP_NEWCSS ?>bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo FONT_AWESOME_CSS ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo IONIC_CONS_CSS ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo NEWSAPMSTYLE_CSS ?>">
  
  <link rel="stylesheet" href="<?php echo DISK_SKINS_CSS ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo PLUGINS_ICHECK_CSS ?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo PLUGINS_MORRIS_CSS ?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo PLUGINS_JVECTORMAP_CSS ?>">
  <!-- Date Picker 
 http://192.168.3.14/new_sapm/plugins/daterangepicker/daterangepicker.js 
  <link href="http://192.168.3.14/new_sapm/assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
  -->
  
  <link rel="stylesheet" href="<?php echo PLUGINS_DATEPICKER_CSS ?>">
  
  
  <!-- Daterange picker 
  -->
  <link rel="stylesheet" href="<?php echo PLUGINS_DATERANGEPICKER_CSS ?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo PLUGINS_BOOTSTRAP_WYSIHTML5_CSS ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
<link href="<?php echo CSS.'flexigrid.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS.'jquery.numeric.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS.'jquery.treeview.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS.'smart_wizard.css' ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_JUI ?>" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="http://brftst.bni.co.id/new_sam/public/css/flipclock.css" />

<script type="text/javascript" src="<?php echo JQ ?>"></script>
<script type="text/javascript" src="<?php echo JUI ?>"></script>
<script type="text/javascript" src="<?php echo JSFLEX ?>"></script>
<script type="text/javascript" src="<?php echo JSNUM?>"></script>
<script type="text/javascript" src="<?php echo JSMON?>"></script>
<script type="text/javascript" src="<?php echo JS ?>number_format.js"></script>

<script type="text/javascript">
	$(function() {
		$("#accordion").accordion();
	});
</script>

    <link href="http://192.168.3.14/new_sapm/assets/datatables/css/dataTables.bootstrap.css" rel="stylesheet">
<!---
    <link href="http://192.168.3.14/new_sapm/assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">  
-->	
  
</head>

<?php  
$npp = 16622;
/*
$npp = $_SESSION['ID'];
$ceks=$this->_login->CekOldSession($_SESSION['ID']);
$old_ip_address=$ceks[0]->IP_ADDRESS;
$sesidold = $ceks[0]->SESSION_ID_OLD;
$sesidnew = $ceks[0]->SESSION_ID;
$new_ip_address = $_SERVER['REMOTE_ADDR'];
$oldbrowser=$ceks[0]->BROWSER;
$sesid=$this->session->userdata('session_id');
$sesnow = session_id();
#$newbrowser =$this->agent->browser().' '.$this->agent->version();
if($sesnow!=$sesidnew)
{
	?>
	<script type="text/javascript">
	var url='<?php echo site_url('/login') ?>/';
	var urlx='<?php echo site_url('/login/login_force/'.$npp.'') ?>/';
	//alert('User sedang login di tempat lain!');
	var r = confirm('User sedang login di tempat lain!.Ingin tetap login degan user ini?');
	if(r == true)
	{
		window.location.href = urlx;
	}
	else
	{
		window.location.href = url;
	}
	</script>
	<?php
}elseif($sesidnew=="")
{
	?>
	<script type="text/javascript">
	var url='<?php echo site_url('/login') ?>/';
		window.location.href = url;
	</script>
	<?php
}
else
{
*/
?>


<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SA</b>PM</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SAPM</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>&nbsp;&nbsp;<span style="font-family:arial; text-transform:uppercase"><strong>Sales Activity & Performance Management</strong></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!-- Notifications: style can be found in dropdown.less -->
          <!-- Tasks: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo IMAGES_USER_PROFILE.'user-default.jpg' ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><strong>USER PROFILE</strong></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
              	 <p><?php echo $_SESSION['USER_NAME']; ?></p>	
                <img src="<?php echo IMAGES_USER_PROFILE.'user-default.jpg' ?>" class="img-circle" alt="User Image">

                <p class="text-center">
                  <small>LEVEL : <?php echo $_SESSION['USER_LEVEL']; ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#"><small>NPP   : <?php echo $_SESSION['ID']; ?></small></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#"><small>Region : <?php echo $_SESSION['REGION']; ?></small></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#"><small>Grade : <?php echo $_SESSION['GRADE']; ?></small></a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                	<p><small><?php echo $_SESSION['BRANCH_NAME']; ?></small></p>
                </div>
                <div class="pull-right">
				  <a href="<?php ?>" data-toggle="modal" data-target=".bs-example-modal-sm" class="btn btn-default btn-flat" >
					<i class="fa fa-lock text-red"></i> <span>Logout</span>
				  </a>
                 </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>

  <!---sidebar kiri -->
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo IMAGES_USER_PROFILE. 'user-default.jpg' ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['USER_NAME']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->


      <!-- sidebar menu: : style can be found in sidebar.less -->
      <br /><br />
      <ul class="sidebar-menu">
        <!-- <li class="header">MAIN NAVIGATION</li> -->

        <!-- menu Dasboard -->
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span>Dasboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('/home/') ?>"><i class="fa fa-circle-o"></i> Home</a></li>
            <li><a href="<?php echo site_url('/dashboard/') ?>"><i class="fa fa-circle-o"></i> Dasboard</a></li>
          </ul>
        </li>
        <!-- end menu home -->

        <!-- menu -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th text-aqua"></i> <span>Flagging</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="<?php echo site_url('self_flagging/sales') ?>"><i class="fa fa-circle-o"></i>Sales</a></li>
            <li><a href="<?php echo site_url('self_flagging/report') ?>"><i class="fa fa-circle-o"></i>report</a></li>
            
          </ul>
        </li>
        <!-- end menu  -->


        <!-- menu -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th text-aqua"></i> <span>Manajemen Leads</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="<?php echo site_url('sales/cust_ind') ?>"><i class="fa fa-circle-o"></i>Manajemen Leads</a></li>            

		  </ul>
        </li>
        <!-- end menu  -->		


        <!-- menu -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th text-aqua"></i> <span>Stagging & Activity</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="<?php echo site_url('activity') ?>"><i class="fa fa-circle-o"></i>Stagging & Activity</a></li>            

		  </ul>
        </li>
        <!-- end menu  -->		
		

        <!-- menu -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th text-aqua"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="<?php echo site_url('report/performance') ?>"><i class="fa fa-circle-o"></i>Performance Sales</a></li>            
            <li><a href="<?php echo site_url('report/realisasi') ?>"><i class="fa fa-circle-o"></i>Realisasi Sales</a></li>            
            <li><a href="<?php echo site_url('report/nasabah') ?>"><i class="fa fa-circle-o"></i>Nasabah kelolaan</a></li>            
            <li><a href="<?php echo site_url('report/cc') ?>"><i class="fa fa-circle-o"></i>penjualan Kartu Kredit</a></li>            
            <li><a href="<?php echo site_url('report/dplk') ?>"><i class="fa fa-circle-o"></i>Rekening DPLK</a></li>            
            <li><a href="<?php echo site_url('report/pipeline_sup') ?>"><i class="fa fa-circle-o"></i>Report Pipeline (Tgl)</a></li>            
            <li><a href="<?php echo site_url('report/pipeline_count_sup') ?>"><i class="fa fa-circle-o"></i>Report Pipeline (Jumlah)</a></li>            
            <li><a href="<?php echo site_url('report/pipeline_coach') ?>"><i class="fa fa-circle-o"></i>Report Pipeline Worksheet</a></li>            

		  </ul>
        </li>
        <!-- end menu  -->		
		
        <!-- menu -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th text-aqua"></i> <span>Performance Tunjangan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="<?php echo site_url('report/performance_tunjangan') ?>"><i class="fa fa-circle-o"></i>Performance Tunjangan</a></li>            

		  </ul>
        </li>
        <!-- end menu  -->		
		

<!-- Account Planning-->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th text-aqua"></i> <span>Account Planning</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="<?php echo site_url('account_planning/list_account_planning') ?>"><i class="fa fa-circle-o"></i>Usulan</a></li>
            <li><a href="<?php echo site_url('account_planning/report') ?>"><i class="fa fa-circle-o"></i>Report </a></li>
            
          </ul>
        </li>
        <!-- end -->




<?php
/*
		
        <!-- report tunjangan performance -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-red"></i><span>Report Tunjangan Perform</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i>Tunjangan Performance</a></li>
          </ul>
        </li>
        <!-- end report tunjangan performance -->

        <!-- report -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-yellow"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Aktivasi Harian</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Akt. Sdh Realisasi</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Akt. Blm Realisasi</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Akt. Harian 500046</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Akt. Sdh Realisasi 500046</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Akt. Blm Realisasi 500046</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Aktivasi Per Nasabah</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Nasabah Kelolaan Sales</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> AUM Nasabah Kel.Sales</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Realisasi Sales</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Performa Sales</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Performa Sales Bulanan</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Performa Sales Tahunan</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> DPK Sales</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Outstanding DPK Bulanan</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Audit Trail</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> User Active</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> User Non Active</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> NOC Sales</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> NOA Sales</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Penj. Krdt Konsumtif Sales</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Penj. Kartu Kredit Sales</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Rek. DPLK Sales</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Report Pipeline (Tgl)</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Report Pipeline (Jumlah)</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Report Worksheet Pipeline (Sales)</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Report Grouping Pipeline (Wilayah)</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Report Grouping Pipeline </a></li>

          </ul>
        </li>
        <!-- end report -->

        <!-- staging & activity management -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-aqua"></i><span>Staging & Activity Manage</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Staging List</a></li>
          </ul>
        </li>
        <!-- end staging & activity management -->

        <!-- customer management -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-red"></i> <span>Customer Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Manajemen Nasabah</a></li>
          </ul>
        </li>
        <!-- end customer management -->

        <!-- target -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-yellow"></i> <span>Target</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Sales Target</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Realisasi Target Sales</a></li>
          </ul>
        </li>
        <!-- end target -->

        <!-- upload -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-aqua"></i> <span>Upload</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Upload Pencapaian Manual</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Upload Tambahan DPK</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Upload Pengurangan DPK</a></li>
          </ul>
        </li>
        <!-- end upload -->

        <!-- status non sales -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-red"></i> <span>Status Non Sales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Status Non Sales</a></li>
          </ul>
        </li>
        <!-- end upload -->

        <!-- berita -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-yellow"></i> <span>Berita</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Berita SAPM</a></li>
          </ul>
        </li>
        <!-- end berita -->


        <!-- data segmentasi -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-aqua"></i> <span>Data Segmentasi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Audit Trail</a></li>
          </ul>
        </li>
        <!-- end data segmentasi -->

        <!-- usulan flagging 2016 -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-red"></i> <span>Usulan Flagging 2016</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Report</a></li>
          </ul>
        </li>
        <!-- end usulan flagging 2016 -->

        <!-- admin -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-yellow"></i> <span>Admin</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> User Management</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Unregister Mobile</a></li>
          </ul>
        </li>
        <!-- end admin -->

        <!-- account planning -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-aqua"></i> <span>Account Planning</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Report Account Planning</a></li>
          </ul>
        </li>
        <!-- end account planning -->

?>
<?php
*/
?>
		
        <!-- logout -->
        <li class="treeview">
<!---
          <a href="<?php echo site_url('login/logout'); ?>">
            <i class="fa fa-circle-o text-red"></i> <span>Logout</span>
          </a>
-->		
          <a href="<?php ?>" data-toggle="modal" data-target=".bs-example-modal-sm" >
            <i class="fa fa-lock text-red"></i> <span>Logout</span>
          </a>
		  
        </li>
        <!-- end logout -->
		
        </ul><!-- end class sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- end sidebar kiri -->
  
  

  
  
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header2"></section>
<!-- 
<section class="content2">
	<div class="row">
 -->	