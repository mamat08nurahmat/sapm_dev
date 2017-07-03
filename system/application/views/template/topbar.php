</head>

<?php  
//$npp = 16622;
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
/*
else
{
*/
?>
<!-----
<body class="skin-blue">
--->
<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
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

	
	
<!-------------TOPBAR------------------------------>		
<!-------------template/topbar.php----------------->		
