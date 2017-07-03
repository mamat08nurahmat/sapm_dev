<!--START HEADER==================================================================-->
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
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo PLUGINS_DATEPICKER_CSS ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo PLUGINS_DATERANGEPICKER_CSS ?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo PLUGINS_BOOTSTRAP_WYSIHTML5_CSS ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
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
        <span class="sr-only">Toggle navigation</span>&nbsp;&nbsp;<span style="font-family:arial; text-transform:uppercase">Sales Activity & <strong>Performance Management</strong></span>
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
                  <a href="<?php echo site_url('login/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
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

        <!-- menu home -->
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-circle-o text-red"></i> <span>Home</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('home') ?>"><i class="fa fa-share-square-o"></i> Home</a></li>
            <li><a href="<?php echo site_url('home/point') ?>"><i class="fa fa-share-square-o"></i> Program SGP</a></li>
          </ul>
        </li>
        <!-- end menu home -->

        <!-- menu flagging -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-yellow"></i> <span>Flagging</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('self_flagging') ?>"><i class="fa fa-share-square-o"></i> Admin Sales</a></li>
            <li><a href="<?php echo site_url('self_flagging/spv') ?>"><i class="fa fa-share-square-o"></i> SPV</a></li>
            <li><a href="#"><i class="fa fa-share-square-o"></i> PEMIMPIN/Pemimpin Cabang</a></li>
            <li><a href="#"><i class="fa fa-share-square-o"></i> SLN</a></li>
            <li><a href="#"><i class="fa fa-share-square-o"></i> Report</a></li>
          </ul>
        </li>
        <!-- end menu flagging -->

        <!-- report top 20/10 -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-aqua"></i> <span>Report TOP 20/10</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Report</a></li>
            <li><a href="#"><i class="fa fa-share-square-o"></i> Rekap Activity</a></li>
            <li><a href="#"><i class="fa fa-share-square-o"></i> ADMIN TOP</a></li>
            <li><a href="#"><i class="fa fa-share-square-o"></i> Reset Password Mobile</a></li>
          </ul>
        </li>
        <!-- report top 20/10 -->

        <!-- report tunjangan performance -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o text-red"></i><span>Report Tunjangan Perform</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-share-square-o"></i>Tunjangan Performance</a></li>
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
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Aktivasi Harian</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Akt. Sdh Realisasi</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Akt. Blm Realisasi</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Akt. Harian 500046</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Akt. Sdh Realisasi 500046</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Akt. Blm Realisasi 500046</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Aktivasi Per Nasabah</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Nasabah Kelolaan Sales</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> AUM Nasabah Kel.Sales</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Realisasi Sales</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Performa Sales</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Performa Sales Bulanan</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Performa Sales Tahunan</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> DPK Sales</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Outstanding DPK Bulanan</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Audit Trail</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> User Active</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> User Non Active</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> NOC Sales</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> NOA Sales</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Penj. Krdt Konsumtif Sales</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Penj. Kartu Kredit Sales</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Rek. DPLK Sales</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Report Pipeline (Tgl)</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Report Pipeline (Jumlah)</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Report Worksheet Pipeline (Sales)</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Report Grouping Pipeline (Wilayah)</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Report Grouping Pipeline </a></li>

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
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Staging List</a></li>
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
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Manajemen Nasabah</a></li>
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
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Sales Target</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Realisasi Target Sales</a></li>
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
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Upload Pencapaian Manual</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Upload Tambahan DPK</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Upload Pengurangan DPK</a></li>
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
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Status Non Sales</a></li>
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
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Berita SAPM</a></li>
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
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Audit Trail</a></li>
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
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Report</a></li>
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
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> User Management</a></li>
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Unregister Mobile</a></li>
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
            <li><a href="index.html"><i class="fa fa-share-square-o"></i> Report Account Planning</a></li>
          </ul>
        </li>
        <!-- end account planning -->

        <!-- logout -->
        <li class="treeview">
          <a href="<?php echo site_url('login/logout'); ?>">
            <i class="fa fa-circle-o text-red"></i> <span>Logout</span>
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

<!-- END HEADER================================================================== -->
<!--START CONTENT==================================================================-->

    <!-- Main content -->
   	<section class="content2">
        <!-- START CUSTOM TABS -->
        <h2 class="page-header">Program SGP</h2>

        <div class="row">
          <div class="col-xs-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">INFO POINT</a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 -->
                <div class="tab-pane active" id="tab_1">
                    <form style="margin:10px" action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
                        <table class="table-responsive table-condensed" width="" cellspacing="5" cellpadding="5" border="0">
                        <tbody>
                        <tr>
                            <td align="left">NPP </td>
                	        <td colspan="4">&nbsp;
                  	        <input name="ID" id="ID" size="20" readonly="readonly" class="input" type="text">
                            </td>
                        </tr>

                        <tr>
                            <td align="left">NAMA </td>
                	        <td colspan="4">&nbsp;
                  	        <input name="USER_NAME" id="USER_NAME" size="20" readonly="readonly" class="input" type="text">
                            </td>
                        </tr>

                        <tr>
                	         <td align="left">SALES TYPE </td>
                	         <td colspan="4">&nbsp;
                  	         <input name="SALES_TYPE" id="SALES_TYPE" size="20" readonly="readonly" class="input" type="text">
                             </td>
                        </tr>

                        <tr>
                	          <td align="left">PERIODE </td>
                              <td>&nbsp; <input name="START" id="START" size="20" readonly="readonly" class="input hasDatepicker" type="text"></td>
                              <td>to <input name="END" id="END" size="20" readonly="readonly" class="input hasDatepicker" type="text"></td>
                              <td><input name="submit" class="btn btn-primary" id="submit" value="Generate" type="button"></td>
                              <!--td><input name="export" id="export" type="button" value="Export to XLS"></td-->
                        </tr>
                        </tbody></table>
                    </form><br><br>

                    	<div id="trx" style="height: auto; width: 100%; font-size: 12px; overflow: auto;"><table name="trx" class="table-responsive table-bordered table-condensed table-striped" width="100%" cellspacing="1" cellpadding="10" bgcolor="#cccccc">
						<thead>
						<tr bgcolor="#A5D3FA">
							<th class="kecil" align="center">NO</th>
							<th class="kecil" align="center">TANGGAL TRX</th>
							<th class="kecil" align="center">NPP</th>
							<th class="kecil" align="center">NAMA</th>
							<th class="kecil" align="center">JENIS</th>
							<th class="kecil" align="center">CABANG</th>
							<th class="kecil" align="center">POIN REDEEM</th>
							<th class="kecil" align="center">HARGA BARANG</th>
							<th class="kecil" align="center">FILE INVOICE</th>
							<th class="kecil" align="center">TANGGAL PEMBAYARAN</th>
							<th class="kecil" align="center">FILE PEMBAYARAN</th>
							<th class="kecil" align="center">STATUS</th>
							<th class="kecil" align="center">Aksi</th>
							<th class="kecil" align="center">Ulasan</th>
						</tr>
						</thead>

						<tbody>	
						<tr bgcolor="#ffffff">
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="left">22-OCT-16</td> 
							<td class="kecil" width="" align="left">35052</td> 
							<td class="kecil" width="" align="left">ANDITYA WIRAWAN</td> 
							<td class="kecil" width="" align="left">PBA STA</td> 
							<td class="kecil" width="" align="left">DUKUH BAWAH</td> 
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="right">Rp. 100,001.00</td> 
							<input name="GB2" id="GB2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button  class="btn btn-block btn-default btn-sm" onclick="view(2)">View</button></td> 
							<td class="kecil" width="" align="center"></td> 
							<input name="GBY2" id="GBY2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="viewbt(2)" disabled="disabled">View</button></td> 
							<td class="kecil" width="" align="center">PENDING</td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openbayar(188)">Bayar</button></td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openfeedback(188)" disabled="disabled">Feedback</button></td> 
						</tr>
						<tr bgcolor="#ffffff">
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="left">22-OCT-16</td> 
							<td class="kecil" width="" align="left">35052</td> 
							<td class="kecil" width="" align="left">ANDITYA WIRAWAN</td> 
							<td class="kecil" width="" align="left">PBA STA</td> 
							<td class="kecil" width="" align="left">DUKUH BAWAH</td> 
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="right">Rp. 100,001.00</td> 
							<input name="GB2" id="GB2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button  class="btn btn-block btn-default btn-sm" onclick="view(2)">View</button></td> 
							<td class="kecil" width="" align="center"></td> 
							<input name="GBY2" id="GBY2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="viewbt(2)" disabled="disabled">View</button></td> 
							<td class="kecil" width="" align="center">PENDING</td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openbayar(188)">Bayar</button></td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openfeedback(188)" disabled="disabled">Feedback</button></td> 
						</tr>
						<tr bgcolor="#ffffff">
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="left">22-OCT-16</td> 
							<td class="kecil" width="" align="left">35052</td> 
							<td class="kecil" width="" align="left">ANDITYA WIRAWAN</td> 
							<td class="kecil" width="" align="left">PBA STA</td> 
							<td class="kecil" width="" align="left">DUKUH BAWAH</td> 
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="right">Rp. 100,001.00</td> 
							<input name="GB2" id="GB2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button  class="btn btn-block btn-default btn-sm" onclick="view(2)">View</button></td> 
							<td class="kecil" width="" align="center"></td> 
							<input name="GBY2" id="GBY2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="viewbt(2)" disabled="disabled">View</button></td> 
							<td class="kecil" width="" align="center">PENDING</td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openbayar(188)">Bayar</button></td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openfeedback(188)" disabled="disabled">Feedback</button></td> 
						</tr>
						<tr bgcolor="#ffffff">
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="left">22-OCT-16</td> 
							<td class="kecil" width="" align="left">35052</td> 
							<td class="kecil" width="" align="left">ANDITYA WIRAWAN</td> 
							<td class="kecil" width="" align="left">PBA STA</td> 
							<td class="kecil" width="" align="left">DUKUH BAWAH</td> 
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="right">Rp. 100,001.00</td> 
							<input name="GB2" id="GB2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button  class="btn btn-block btn-default btn-sm" onclick="view(2)">View</button></td> 
							<td class="kecil" width="" align="center"></td> 
							<input name="GBY2" id="GBY2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="viewbt(2)" disabled="disabled">View</button></td> 
							<td class="kecil" width="" align="center">PENDING</td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openbayar(188)">Bayar</button></td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openfeedback(188)" disabled="disabled">Feedback</button></td> 
						</tr>
						<tr bgcolor="#ffffff">
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="left">22-OCT-16</td> 
							<td class="kecil" width="" align="left">35052</td> 
							<td class="kecil" width="" align="left">ANDITYA WIRAWAN</td> 
							<td class="kecil" width="" align="left">PBA STA</td> 
							<td class="kecil" width="" align="left">DUKUH BAWAH</td> 
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="right">Rp. 100,001.00</td> 
							<input name="GB2" id="GB2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button  class="btn btn-block btn-default btn-sm" onclick="view(2)">View</button></td> 
							<td class="kecil" width="" align="center"></td> 
							<input name="GBY2" id="GBY2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="viewbt(2)" disabled="disabled">View</button></td> 
							<td class="kecil" width="" align="center">PENDING</td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openbayar(188)">Bayar</button></td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openfeedback(188)" disabled="disabled">Feedback</button></td> 
						</tr>
						<tr bgcolor="#ffffff">
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="left">22-OCT-16</td> 
							<td class="kecil" width="" align="left">35052</td> 
							<td class="kecil" width="" align="left">ANDITYA WIRAWAN</td> 
							<td class="kecil" width="" align="left">PBA STA</td> 
							<td class="kecil" width="" align="left">DUKUH BAWAH</td> 
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="right">Rp. 100,001.00</td> 
							<input name="GB2" id="GB2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button  class="btn btn-block btn-default btn-sm" onclick="view(2)">View</button></td> 
							<td class="kecil" width="" align="center"></td> 
							<input name="GBY2" id="GBY2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="viewbt(2)" disabled="disabled">View</button></td> 
							<td class="kecil" width="" align="center">PENDING</td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openbayar(188)">Bayar</button></td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openfeedback(188)" disabled="disabled">Feedback</button></td> 
						</tr>
						<tr bgcolor="#ffffff">
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="left">22-OCT-16</td> 
							<td class="kecil" width="" align="left">35052</td> 
							<td class="kecil" width="" align="left">ANDITYA WIRAWAN</td> 
							<td class="kecil" width="" align="left">PBA STA</td> 
							<td class="kecil" width="" align="left">DUKUH BAWAH</td> 
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="right">Rp. 100,001.00</td> 
							<input name="GB2" id="GB2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button  class="btn btn-block btn-default btn-sm" onclick="view(2)">View</button></td> 
							<td class="kecil" width="" align="center"></td> 
							<input name="GBY2" id="GBY2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="viewbt(2)" disabled="disabled">View</button></td> 
							<td class="kecil" width="" align="center">PENDING</td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openbayar(188)">Bayar</button></td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openfeedback(188)" disabled="disabled">Feedback</button></td> 
						</tr>
						<tr bgcolor="#ffffff">
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="left">22-OCT-16</td> 
							<td class="kecil" width="" align="left">35052</td> 
							<td class="kecil" width="" align="left">ANDITYA WIRAWAN</td> 
							<td class="kecil" width="" align="left">PBA STA</td> 
							<td class="kecil" width="" align="left">DUKUH BAWAH</td> 
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="right">Rp. 100,001.00</td> 
							<input name="GB2" id="GB2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button  class="btn btn-block btn-default btn-sm" onclick="view(2)">View</button></td> 
							<td class="kecil" width="" align="center"></td> 
							<input name="GBY2" id="GBY2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="viewbt(2)" disabled="disabled">View</button></td> 
							<td class="kecil" width="" align="center">PENDING</td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openbayar(188)">Bayar</button></td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openfeedback(188)" disabled="disabled">Feedback</button></td> 
						</tr>
						<tr bgcolor="#ffffff">
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="left">22-OCT-16</td> 
							<td class="kecil" width="" align="left">35052</td> 
							<td class="kecil" width="" align="left">ANDITYA WIRAWAN</td> 
							<td class="kecil" width="" align="left">PBA STA</td> 
							<td class="kecil" width="" align="left">DUKUH BAWAH</td> 
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="right">Rp. 100,001.00</td> 
							<input name="GB2" id="GB2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button  class="btn btn-block btn-default btn-sm" onclick="view(2)">View</button></td> 
							<td class="kecil" width="" align="center"></td> 
							<input name="GBY2" id="GBY2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="viewbt(2)" disabled="disabled">View</button></td> 
							<td class="kecil" width="" align="center">PENDING</td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openbayar(188)">Bayar</button></td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openfeedback(188)" disabled="disabled">Feedback</button></td> 
						</tr>
						
					</tbody></table></div><br/> <div id="report" class="text-center">Silahkan isi range periode report</div>	
                </div>
                <!-- end tab1 -->
                <!-- /.tab-pane -->

                <!-- tab2 -->
                <!-- <div class="tab-pane" id="tab_2">
                  The European languages are members of the same family. Their separate existence is a myth.
                  For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                  in their grammar, their pronunciation and their most common words. Everyone realizes why a
                  new common language would be desirable: one could refuse to pay expensive translators. To
                  achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                  words. If several languages coalesce, the grammar of the resulting language is more simple
                  and regular than that of the individual languages.
                </div> -->
                <!-- end tab2 -->
                <!-- /.tab-pane -->

                <!-- tab3 -->
                <!-- <div class="tab-pane" id="tab_3">
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                  Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                  when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                  It has survived not only five centuries, but also the leap into electronic typesetting,
                  remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                  sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                  like Aldus PageMaker including versions of Lorem Ipsum.
                </div> -->
                <!-- end tab3 -->
                <!-- /.tab-pane -->

              </div>
              <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
          </div>
          <!-- /.col -->


        </div>
         <!-- / end class .row -->

<!--END CONTENT==================================================================-->
<!--START FOOTER==================================================================-->
		 
    </section>
    <!-- /.content -->
    <br/>
  </div>
  <!-- /.content-wrapper -->


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
<!-- daterangepicker -->
<script type="text/javascript" src="<?php echo MOMENTJS ?>"></script>
<script type="text/javascript" src="<?php echo DATERANGEPICKERJS ?>"></script>
<!-- datepicker -->
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
</body>
</html>
