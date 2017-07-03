

		
<!-- =============================================== -->
<!-- Left side column. contains the sidebar -->
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
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <br /><br />
      <ul class="sidebar-menu">
        <!-- <li class="header">MAIN NAVIGATION</li> -->



<!-----------------MENU---------------------------------->
<?php $this->load->view('template/menu') ?>			
<!------------------------------------------------------->
		

		
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
<!---->		

		
		
    </section>
    <!-- /.sidebar -->
  </aside>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

