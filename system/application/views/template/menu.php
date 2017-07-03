		
 			<?php 
/*
			if($this->session->userdata('ID') <> ''){  $level = $this->session->userdata('USER_LEVEL'); 
			$sales_type = $this->session->userdata('SALES_ID');
			$id = $this->session->userdata('ID');
*/			
$level = $_SESSION['USER_LEVEL'];
$sales_type = $_SESSION['SALES_ID'];

			
			?>

<!-----------

        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span>Account Planning</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('tap/list_tap') ?>"><i class="fa fa-circle-o"></i> Usulan Account Planning </a></li>
            <li><a href="<?php echo site_url('tap/report') ?>"><i class="fa fa-circle-o"></i> Report Account Planning </a></li>
          </ul>
        </li>

----------->
			
<!----======================================================================================================================================----> 
<!-- SALES MENU SALES TYPE 9-->
<?php  if($level == 'SALES' && $sales_type == 9 ) { ?>


        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span>Account Planning</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('tap/list_tap') ?>"><i class="fa fa-circle-o"></i> Usulan Account Planning </a></li>
            <li><a href="<?php echo site_url('tap/report') ?>"><i class="fa fa-circle-o"></i> Report Account Planning </a></li>
          </ul>
        </li>



<!---
<h3><a href="#">Account Planning</a></h3>
<div id="box-body">					
<a href="<?php echo site_url('tap/list_tap'); ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Usulan Account Planning</a>
<a href="<?php echo site_url('tap/report'); ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Account Planning</a>
</div>
--->
			
<!----======================================================================================================================================----> 
<!-- SALES MENU $sales_type == 15 || $sales_type == 11 || $sales_type == 10 || $sales_type == 12)-->	
<?php } if($level == 'SALES' && $sales_type == 15 || $sales_type == 11 || $sales_type == 10 || $sales_type == 12){?>
<!-----
			<h3><a href="#">Home</a></h3>
                <div id='box-body'>
                     <a href="<?php echo site_url('/home/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Home</a>
               </div>
			<h3><a href="#">Report</a></h3>
            <div id='box-body'>
				<a href="<?php echo site_url('/report/performance/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales</a>
				<a href="<?php echo site_url('/report/realisasi/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales</a>
			</div>
			<h3><a href="#">Manajemen Leads</a></h3>
            <div id='box-body'>
                <a href="<?php echo site_url('/sales/cust_ind') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Manajemen Leads</a>	
            </div>
----->
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span>Home</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('/home') ?>"><i class="fa fa-circle-o"></i> home </a></li>
          </ul>
        </li>

        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('/report/performance') ?>"><i class="fa fa-circle-o"></i> Performance Sales </a></li>
            <li><a href="<?php echo site_url('/report/realisasi') ?>"><i class="fa fa-circle-o"></i> Realisasi Sales </a></li>
          </ul>
        </li>

        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span>Manajemen Leads</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('/sales/cust_ind') ?>"><i class="fa fa-circle-o"></i> Manajemen Leads </a></li>
          </ul>
        </li>
		


<!----======================================================================================================================================----> 
<!-- SALES MENU $sales_type < 9 || $sales_type == 13 || $sales_type == 14 || $sales_type>=20-->	
<?php   } if($level == 'SALES' && $sales_type < 9 || $sales_type == 13 || $sales_type == 14 || $sales_type>=20) { ?>
 
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
		
		
<!----======================================================================================================================================----> 
<!-- SALES MENU $sales_type == 7 || $sales_type == 8-->	
<?php } if($level == 'SALES' && $sales_type == 7 || $sales_type == 8) { ?>
			<!--<h3><a href="#">Usulan Flagging 2016</a></h3>
				<div id='box-body'>
					<!--<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penugasan Nasabah</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/approval') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Approval</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah_all') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />List Nasabah</a>
					
					<a href="<?php echo site_url('/usulan_nasabah_v1/report_flagging_2016') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
				</div>-->
				
<!----======================================================================================================================================----> 
<!-- SUPERVISOR MENU || $level == 'SUPER VISOR'-->					
<?php } if($level == 'SUPERVISOR' || $level == 'SUPER VISOR') { ?>

        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo site_url('/home/') ?>"><i class="fa fa-circle-o"></i> Home </a></li>
            <li><a href="<?php echo site_url('/dashboard/') ?>"><i class="fa fa-circle-o"></i> Dashboard </a></li>
          </ul>
        </li>				
				
				
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span>Flagging</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('/self_flagging/spv') ?>"><i class="fa fa-circle-o"></i> Sales Baru </a></li>
            <li><a href="<?php echo site_url('/self_flagging/list_nasabah_tambahan') ?>"><i class="fa fa-circle-o"></i> Sales Lama </a></li>
            <li><a href="<?php echo site_url('/self_flagging/report') ?>"><i class="fa fa-circle-o"></i> Report Sales Baru  </a></li>
          </ul>
        </li>				
				

        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span>Management Leads</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('/sales/cust_ind') ?>"><i class="fa fa-circle-o"></i> Management Leads </a></li>
          </ul>
        </li>				
				
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span> Staging & Activity </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('/activity/') ?>"><i class="fa fa-circle-o"></i> Staging & Activity </a></li>
          </ul>
        </li>				
				
			
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span> Report Tunjangan Performance </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('/report/performance_sup_tunjangan/') ?>"><i class="fa fa-circle-o"></i> Tunjangan Performance </a></li>
          </ul>
        </li>			
			
			
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard text-aqua"></i> <span> Report </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo site_url('/report/activity_sup/') ?>            "><i class="fa fa-circle-o"></i> Aktivitas Harian</a></li>
            <li><a href="<?php echo site_url('/report/activity_realisasi/') ?>		"><i class="fa fa-circle-o"></i> Akt. Sudah Realisasi</a></li>
            <li><a href="<?php echo site_url('/report/activity_belum/') ?>			"><i class="fa fa-circle-o"></i> Akt. Belum terealisasi</a></li>
            <li><a href="<?php echo site_url('/report/activity_tele/') ?>			"><i class="fa fa-circle-o"></i> Akt. Harian Leads 500046</a></li>
            <li><a href="<?php echo site_url('/report/activity_realisasi_tele/') ?>	"><i class="fa fa-circle-o"></i> Akt. Sdh Realisasi 500046</a></li>
            <li><a href="<?php echo site_url('/report/activity_belum_tele/') ?>		"><i class="fa fa-circle-o"></i> Akt. Blm Realisasi 500046</a></li>
            <li><a href="<?php echo site_url('/report/cust_daily/') ?>				"><i class="fa fa-circle-o"></i> Aktivitas per Nasabah</a>             </li>
            <li><a href="<?php echo site_url('/report/kriteria_bisnis/') ?>			"><i class="fa fa-circle-o"></i> Report Kriteria Bisnis</a>            </li>
            <li><a href="<?php echo site_url('/report/other_product/') ?>			"><i class="fa fa-circle-o"></i> Produk Lain Nasabah</a>               </li>
            <li><a href="<?php echo site_url('/report/cust_planning_daily/') ?>		"><i class="fa fa-circle-o"></i> Perencanaan Aktivitas</a> </li>
            <li><a href="<?php echo site_url('/report/follow_up/') ?>				"><i class="fa fa-circle-o"></i> Tindak Lanjut</a> </li>
            <li><a href="<?php echo site_url('/report/daily_closed/') ?>			"><i class="fa fa-circle-o"></i> Penutupan Penjualan</a> </li>
            <li><a href="<?php echo site_url('/report/oportunity/') ?>				"><i class="fa fa-circle-o"></i> Rasio Aktivitas Sales</a></li>
            <li><a href="<?php echo site_url('/report/bni_product_1/') ?>			"><i class="fa fa-circle-o"></i> Produk BNI Nasabah</a></li>
            <li><a href="<?php echo site_url('/report/nasabah_sup/') ?>				"><i class="fa fa-circle-o"></i> Nasabah Kelolaan Sales</a></li>
            <li><a href="<?php echo site_url('/report/kelolaan_year/') ?>			"><i class="fa fa-circle-o"></i> DPK Sales</a></li>
            <li><a href="<?php echo site_url('/report/realisasi_sup/') ?>			"><i class="fa fa-circle-o"></i> Realisasi Sales</a></li>
            <li><a href="<?php echo site_url('/report/real_year/') ?>				"><i class="fa fa-circle-o"></i> Realisasi Sales Tahunan</a></li>
            <li><a href="<?php echo site_url('/report/performance_sup/') ?>			"><i class="fa fa-circle-o"></i> Performa Sales</a></li>
            <li><a href="<?php echo site_url('/report/monthly_performance/') ?>		"><i class="fa fa-circle-o"></i> Performa Sales Bulanan</a></li>
            <li><a href="<?php echo site_url('/report/perform_year/') ?>			"><i class="fa fa-circle-o"></i> Performa Sales Tahunan</a></li>
            <li><a href="<?php echo site_url('/report/new_customer_sup/') ?>		"><i class="fa fa-circle-o"></i> NOC Sales</a></li>
            <li><a href="<?php echo site_url('/report/new_account_sup/') ?>			"><i class="fa fa-circle-o"></i> NOA Sales</a> </li>
            <li><a href="<?php echo site_url('/report/konsumer_sup/') ?>			"><i class="fa fa-circle-o"></i> Penj. Krdt Konsumtif Sales</a>	</li>
            <li><a href="<?php echo site_url('/report/cc_sup/') ?>					"><i class="fa fa-circle-o"></i> Penj. Kartu Kredit Sales</a>	</li>
            <li><a href="<?php echo site_url('/report/dplk_sup/') ?>				"><i class="fa fa-circle-o"></i> Rek. DPLK Sales</a>					</li>
            <li><a href="<?php echo site_url('/report/nasabah/') ?>					"><i class="fa fa-circle-o"></i> Nasabah Kel. Non Sales</a></li>
            <li><a href="<?php echo site_url('/report/pipeline_sup/') ?>			"><i class="fa fa-circle-o"></i> Report Pipeline (Tgl)</a></li>
            <li><a href="<?php echo site_url('/report/pipeline_count_sup/') ?>		"><i class="fa fa-circle-o"></i> Report Pipeline (Jumlah)</a>	</li>
            <li><a href="<?php echo site_url('/report/pipeline_coach_sup/') ?>		"><i class="fa fa-circle-o"></i> Report Pipeline Worksheet (Sales)</a></li>
            <li><a href="<?php echo site_url('/report/pipeline_coach_spv/') ?>		"><i class="fa fa-circle-o"></i> Report Pipeline Worksheet</a></li>
          </ul>
        </li>
<!---
                <h3><a href="#">Report</a></h3>
                <div id='box-body'>
				
					<a href="<?php echo site_url('/report/activity_sup/') ?>               								" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Harian</a>
                    <a href="<?php echo site_url('/report/activity_realisasi/') ?>		    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Sudah Realisasi</a>
                    <a href="<?php echo site_url('/report/activity_belum/') ?>			    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Belum terealisasi</a>
                    <a href="<?php echo site_url('/report/activity_tele/') ?>			    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Harian Leads 500046</a>
					<a href="<?php echo site_url('/report/activity_realisasi_tele/') ?>    								" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Sdh Realisasi 500046</a>
					<a href="<?php echo site_url('/report/activity_belum_tele/') ?>		    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Blm Realisasi 500046</a>
					<a href="<?php echo site_url('/report/cust_daily/') ?>				    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas per Nasabah</a>                
               		<a href="<?php echo site_url('/report/kriteria_bisnis/') ?>			    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Kriteria Bisnis</a>                
               		<a href="<?php echo site_url('/report/other_product/') ?>			    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Produk Lain Nasabah</a>                
               		<a href="<?php echo site_url('/report/cust_planning_daily/') ?>		    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Perencanaan Aktivitas</a> 
                    <a href="<?php echo site_url('/report/follow_up/') ?>				    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Tindak Lanjut</a> 
                    <a href="<?php echo site_url('/report/daily_closed/') ?>			    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penutupan Penjualan</a> 
                    <a href="<?php echo site_url('/report/oportunity/') ?>				    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rasio Aktivitas Sales</a>
					<a href="<?php echo site_url('/report/bni_product_1/') ?>			    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Produk BNI Nasabah</a>
                	<a href="<?php echo site_url('/report/nasabah_sup/') ?>				    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan Sales</a>
					<a href="<?php echo site_url('/report/kelolaan_year/') ?>			    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />DPK Sales</a>
                    <a href="<?php echo site_url('/report/realisasi_sup/') ?>			    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales</a>
					<a href="<?php echo site_url('/report/real_year/') ?>				    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales Tahunan</a>
                    <a href="<?php echo site_url('/report/performance_sup/') ?>			    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales</a>
                    <a href="<?php echo site_url('/report/monthly_performance/') ?>		    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Bulanan</a>
					<a href="<?php echo site_url('/report/perform_year/') ?>			    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Tahunan</a>
					<a href="<?php echo site_url('/report/new_customer_sup/') ?>		    							" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOC Sales</a>
					<a href="<?php echo site_url('/report/new_account_sup/') ?>				 " class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOA Sales</a> 
					<a href="<?php echo site_url('/report/konsumer_sup/') ?>				 " class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Krdt Konsumtif Sales</a>	
					<a href="<?php echo site_url('/report/cc_sup/') ?>					     " class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Kartu Kredit Sales</a>	
					<a href="<?php echo site_url('/report/dplk_sup/') ?>					 " class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rek. DPLK Sales</a>					
					<a href="<?php echo site_url('/report/nasabah/') ?>					       						   " class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0"  />Nasabah Kel. Non Sales</a>
					<a href="<?php echo site_url('/report/pipeline_sup/') ?>				 " class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Tgl)</a>
					<a href="<?php echo site_url('/report/pipeline_count_sup/') ?>			 " class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Jumlah)</a>	
					<a href="<?php echo site_url('/report/pipeline_coach_sup/') ?>			 " class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline Worksheet (Sales)</a>
					<a href="<?php echo site_url('/report/pipeline_coach_spv/') ?>					" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline Worksheet</a>
 </div>
-->			
 
					<!--<a href="<?php echo site_url('/report/pipeline_coach_sourcedata/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline Worksheet(Sumber Leads)</a>-->
 
 
                
				
				<!--<h3><a href="#">Usulan Nasabah Kelolaan 2015</a></h3>
				<div id='box-body'>
                <a href="<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2015</a>	
				 <a href="<?php echo site_url('/report_usulan_nasabah_kel/report') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Nasabah Kelolaan 2015</a>	
				</div>-->
				
				<!--<h3><a href="#">Usulan Flagging 2016</a></h3>
				<div id='box-body'>
					<!--<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penugasan Nasabah</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/approval') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Approval</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah_all') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />List Nasabah</a>
					
					<a href="<?php echo site_url('/usulan_nasabah_v1/report_flagging_2016') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
				</div>-->
                
				<!--h3><a href="#">Usulan Nasabah Kelolaan 2017</a></h3>
            <div id='box-body'>
                <a href="<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2017</a>
				<a href='<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2017</a>
				<br/><a href='<?php echo site_url('/usulan_nasabah/list_nasabah_rem') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Remove 2017</a> 
				<a href='<?php echo site_url('/usulan_nasabah/list_nasabah_tambahan') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Usulan Tambah di Luar Bucket</a> 
				<a href='<?php echo site_url('/usulan_nasabah/report_list_nasabah') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Nasabah Kelolaan 2017</a> 
				 <a href="<?php echo site_url('/report_usulan_nasabah_kel/report') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Nasabah Kelolaan 2017</a>	
            </div-->
                
                <?php } if($level == 'WILAYAH' || $level == 'CABANG') { ?>
             	
                <!-- WILAYAH MENU -->                
                <h3><a href="#">Dashboard</a></h3>
            	<div id='box-body'>
                    <a href="<?php echo site_url('/home/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Home</a>
                    <a href="<?php echo site_url('/dashboard/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Dashboard Sales</a>
                </div>
				<h3><a href="#">Report Tunjangan Performance</a></h3>
			<div id='box-body'>
				<a href="<?php echo site_url('/report/performance_sup_tunjangan/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Tunjangan Performance</a>
			</div>
                <h3><a href="#">Report</a></h3>
                <div id='box-body'>
					<!--
                    <a href="<?php echo site_url('/report/activity_realisasi/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Sdh Realisasi</a>
					<a href="<?php echo site_url('/report/activity_realisasi_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Sdh Realisasi 500046</a>
					<a href="<?php echo site_url('/report/activity_belum_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Belum Realisasi 500046</a>
					<a href="<?php echo site_url('/report/cust_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas per Nasabah</a>
					<a href="<?php echo site_url('/report/oportunity/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rasio Aktivitas Sales</a>                
               		<a href="<?php echo site_url('/report/cust_planning_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Perencanaan Aktivitas</a> 
                    <a href="<?php echo site_url('/report/daily_closed/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penutupan Penjualan</a--> 
                	<a href="<?php echo site_url('/report/nasabah_cab/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan Sales</a>
					<!--<a href="<?php echo site_url('/report/nasabah_cab_aum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />AUM Nasabah Kel. Sales</a>-->
					<a href="<?php echo site_url('/report/kelolaan_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />DPK Sales</a>
                    <a href="<?php echo site_url('/report/realisasi_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales</a> 
					<a href="<?php echo site_url('/report/realisasi_cab/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales Bulanan</a>
                    <a href="<?php echo site_url('/report/real_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales Tahunan</a>					
                    <a href="<?php echo site_url('/report/performance_cab2/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales</a>
                    <!--a href="<?php echo site_url('/report/performance_cab/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Cabang</a> -->
					<a href="<?php echo site_url('/report/monthly_performance/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Bulanan</a>
					<a href="<?php echo site_url('/report/perform_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Tahunan</a>
                    <!--<a href="<?php echo site_url('/report/nasabah/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kel. Non Sales</a>-->
				    <a href="<?php echo site_url('/report/new_customer_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOC Sales</a>
					<a href="<?php echo site_url('/report/new_account_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOA Sales</a> 
					<!--<a href="<?php echo site_url('/report/nasabah_aum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />AUM Nasabah Kel. Non Sales</a>-->
                    <a href="<?php echo site_url('/report/konsumer_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Krdt Konsumtif Sales</a>	
					<a href="<?php echo site_url('/report/cc/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Kartu Kredit Sales</a>		
					<a href="<?php echo site_url('/report/dplk/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rek. DPLK Sales</a>
					 <a href="<?php echo site_url('/report/user_aktif/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />User Active</a>
					 <a href="<?php echo site_url('/report/user_nonaktif/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />User Non Active</a>
					<a href="<?php echo site_url('/report/pipeline_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Tgl)</a>	
					<!--<a href="<?php echo site_url('/report/pipeline_coach_sourcedata/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline Worksheet(Sumber Leads)</a>-->
					<a href="<?php echo site_url('/report/pipeline_count_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Jumlah)</a>	
					<a href="<?php echo site_url('/report/pipeline_coach_reg/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Grouping Pipeline</a>
					
<!--                <a href="<?php echo site_url('/report/perform_sales_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performance Sales Tahunan</a>
 -->                </div>
                <h3><a href="#">Manajemen Leads</a></h3>
             	<div id='box-body'>
                    <a href="<?php echo site_url('/sales/cust_ind') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Manajemen Leads</a>	
                </div>
                
				
				<!--<h3><a href="#">Usulan Nasabah Kelolaan 2015</a></h3>
				<div id='box-body'>
				 <a href="<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2015</a>	
				 <a href="<?php echo site_url('/report_usulan_nasabah_kel/report') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Nasabah Kelolaan 2015</a>	
				</div>-->
				
				<!--<h3><a href="#">Usulan Flagging 2016</a></h3>
				<div id='box-body'>
					<!--<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penugasan Nasabah</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/approval') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Approval</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah_all') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />List Nasabah</a>
					
					<a href="<?php echo site_url('/usulan_nasabah_v1/report_flagging_2016') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
				</div>-->
				
				<h3><a href="#">Activity</a></h3>
             	<div id='box-body'>
                    <a href="<?php echo site_url('/activity/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Agenda</a>
                </div>
				
				<?php 
				$cekjam = date('H'); 
				if ($cekjam >= 15 or $cekjam < 6) { 
				?>
				<h3><a href="#">Data Segmentasi</a></h3>
				<div id='box-body'>
				 <a href="<?php echo site_url('/segmentasi/upload') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Download Data</a>
				 <!--a href="<?php echo site_url('/segmentasi/audit') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Audit Trail</a-->
				</div>
				<?php } ?>

				 <?php } if($level == 'PIMPINAN_WILAYAH' || $level == 'PIMPINAN_CABANG' || $level == 'PEMIMPIN_CABANG' || $level == 'PEMIMPIN_KLN-KK') { ?>
             	
                <!-- WILAYAH MENU -->                
                <h3><a href="#">Dashboard</a></h3>
            	<div id='box-body'>
                    <a href="<?php echo site_url('/home/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Home</a>
                    <a href="<?php echo site_url('/dashboard/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Dashboard Sales</a>
                </div>
				 <?php if($level == 'PEMIMPIN_CABANG' || $level == 'PEMIMPIN_KLN-KK' || $level == 'PIMPINAN_WILAYAH') { 
				 #if($level == 'PEMIMPIN_CABANG'){?>
				<!--h3><a href="#">TOP 20</a></h3>
				<?php #}elseif($level == 'PEMIMPIN_KLN-KK'){?>
				<h3><a href="#">TOP 10</a></h3>
				<?php #} 
				#elseif($level == 'PIMPINAN_WILAYAH'){?>
				<h3><a href="#">Report TOP 20/10</a></h3>
				<?php #} ?>
            	<div id='box-body'>
					<?php #if($level== 'PEMIMPIN_CABANG' || $level=='PEMIMPIN_KLN-KK'){?>
                    <a href="<?php echo site_url('/report/nasabah_bm') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Kelolaan</a>
					<?php #} ?>
					<?php #if($level== 'PEMIMPIN_CABANG'){?>
                    <a href="<?php echo site_url('/report/nasabah_bm_sum') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
					<?php #} ?>
					<?php #if($level== 'PIMPINAN_WILAYAH'){?>
                    <a href="<?php echo site_url('/report/nasabah_bm_sum_wil') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
					<?php #} ?>
					<a href="<?php echo site_url('/activity_bm/get_rekap_outlet') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rekap Activity</a>
				</div-->
				<?php } ?>
				<h3><a href="#">Flagging</a></h3>
                <div id='box-body'>                    
				<a href="<?php echo site_url('/self_flagging/bm') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Baru</a>
				<a href="<?php echo site_url('/self_flagging/list_nasabah_tambahan') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Lama</a>
				<a href="<?php echo site_url('/self_flagging/report') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Sale Baru</a>
				</div>
				<h3><a href="#">Report Tunjangan Performance</a></h3>
			<div id='box-body'>
				<a href="<?php echo site_url('/report/performance_sup_tunjangan/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Tunjangan Performance</a>
			</div>
			<?php if($level!= 'PEMIMPIN_KLN-KK'){?>
                <h3><a href="#">Report</a></h3>
                <div id='box-body'>
					<!--
                    <a href="<?php echo site_url('/report/activity_realisasi/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Sdh Realisasi</a>
					<a href="<?php echo site_url('/report/activity_realisasi_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Sdh Realisasi 500046</a>
					<a href="<?php echo site_url('/report/activity_belum_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Belum Realisasi 500046</a>
					<a href="<?php echo site_url('/report/cust_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas per Nasabah</a>
					<a href="<?php echo site_url('/report/oportunity/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rasio Aktivitas Sales</a>                
               		<a href="<?php echo site_url('/report/cust_planning_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Perencanaan Aktivitas</a> 
                    <a href="<?php echo site_url('/report/daily_closed/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penutupan Penjualan</a--> 
                	<a href="<?php echo site_url('/report/nasabah_cab/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan Sales</a>
					<!--<a href="<?php echo site_url('/report/nasabah_cab_aum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />AUM Nasabah Kel. Sales</a>-->
					<a href="<?php echo site_url('/report/kelolaan_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />DPK Sales</a>
                    <a href="<?php echo site_url('/report/realisasi_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales</a> 
					<a href="<?php echo site_url('/report/realisasi_cab/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales Bulanan</a>
                    <a href="<?php echo site_url('/report/real_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales Tahunan</a>					
                    <a href="<?php echo site_url('/report/performance_cab2/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales</a>
                    <!--a href="<?php echo site_url('/report/performance_cab/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Cabang</a> -->
					<a href="<?php echo site_url('/report/monthly_performance/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Bulanan</a>
					<a href="<?php echo site_url('/report/perform_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Tahunan</a>
                    <!--<a href="<?php echo site_url('/report/nasabah/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kel. Non Sales</a>-->
				    <a href="<?php echo site_url('/report/new_customer_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOC Sales</a>
					<a href="<?php echo site_url('/report/new_account_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOA Sales</a> 
					<!--<a href="<?php echo site_url('/report/nasabah_aum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />AUM Nasabah Kel. Non Sales</a>-->
                    <a href="<?php echo site_url('/report/konsumer_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Krdt Konsumtif Sales</a>	
					<!--<a href="<?php echo site_url('/report/cc_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Kartu Kredit Sales</a>		
					<a href="<?php echo site_url('/report/dplk_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rek. DPLK Sales</a>
					-->
					<a href="<?php echo site_url('/report/user_aktif/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />User Active</a>
					 <a href="<?php echo site_url('/report/user_nonaktif/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />User Non Active</a>
					<a href="<?php echo site_url('/report/pipeline_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Tgl)</a>	
					<!--<a href="<?php echo site_url('/report/pipeline_coach_sourcedata/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline Worksheet(Sumber Leads)</a>-->
					<a href="<?php echo site_url('/report/pipeline_count_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Jumlah)</a>	
					<a href="<?php echo site_url('/report/pipeline_coach_reg/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Grouping Pipeline</a>
					
<!--                <a href="<?php echo site_url('/report/perform_sales_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performance Sales Tahunan</a>
 -->                </div>
                <h3><a href="#">Manajemen Leads</a></h3>
             	<div id='box-body'>
                    <a href="<?php echo site_url('/sales/cust_ind') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Manajemen Leads</a>	
                </div>
                
				
				<!--<h3><a href="#">Usulan Nasabah Kelolaan 2015</a></h3>
				<div id='box-body'>
				 <a href="<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2015</a>	
				 <a href="<?php echo site_url('/report_usulan_nasabah_kel/report') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Nasabah Kelolaan 2015</a>	
				</div>-->
				
				<!--<h3><a href="#">Usulan Flagging 2016</a></h3>
				<div id='box-body'>
					<!--<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penugasan Nasabah</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/approval') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Approval</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah_all') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />List Nasabah</a>
					
					<a href="<?php echo site_url('/usulan_nasabah_v1/report_flagging_2016') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
					
					<a href="<?php echo site_url('/usulan_nasabah_v1/cr_sales_pengelola') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Usulan Perubahan Pengelola</a>
					
				</div>-->
			
				<h3><a href="#">Activity</a></h3>
             	<div id='box-body'>
                    <a href="<?php echo site_url('/activity/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Staging & Activity</a>
                </div>
				<?php
				if ($this->session->userdata('ID') == '21308') { ?>
				
				<h3><a href="#">Req Data</a></h3>
             	<div id='box-body'>
                    <a href="<?php echo site_url('../data.zip') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Request Data</a>
                </div>
				<?php
				}
				
				?>
				<?php 
				$cekjam = date('H'); 
				if ($cekjam >= 15 or $cekjam < 6) {
				?>
				<h3><a href="#">Data Segmentasi</a></h3>
				<div id='box-body'>
				 <a href="<?php echo site_url('/segmentasi/upload') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Download Data</a>
				 <!--a href="<?php echo site_url('/segmentasi/audit') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Audit Trail</a-->
				</div>
				<?php } ?>
				<?php } ?>
				<!--h3><a href="#">Usulan Nasabah Kelolaan 2017</a></h3>
            <div id='box-body'>
                <a href="<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2017</a>
				<a href='<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2017</a>
				<br/><a href='<?php echo site_url('/usulan_nasabah/list_nasabah_rem') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Remove 2017</a> 
				<a href='<?php echo site_url('/usulan_nasabah/list_nasabah_tambahan') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Usulan Tambah di Luar Bucket</a>
				<a href='<?php echo site_url('/usulan_nasabah/report_list_nasabah') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Nasabah Kelolaan 2017</a>
				<a href="<?php echo site_url('/report_usulan_nasabah_kel/report') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Nasabah Kelolaan 2017</a>	
            </div-->
				<?php } if($level == 'UPLOADER') { ?>
             	
                <!-- WILAYAH MENU -->                
                <h3><a href="#">Home</a></h3>
                <div id='box-body'>
                     <a href="<?php echo site_url('/home/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Home</a>
               </div>
			   <h3><a href="#">Report TOP 20/10</a></h3>
			<div id='box-body'>
				<a href="<?php echo site_url('/report/nasabah_bm_sum_sln/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
				<a href="<?php echo site_url('/activity_bm/get_rekap_outlet') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rekap Activity</a>
			</div>
			   <h3><a href="#">Report</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/report/activity_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Harian</a>
                    <a href="<?php echo site_url('/report/activity_realisasi/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Sdh Realisasi</a>
                    <a href="<?php echo site_url('/report/activity_belum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Blm Realisasi</a>
                    <a href="<?php echo site_url('/report/activity_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Harian 500046</a>
                <a href="<?php echo site_url('/report/activity_realisasi_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Sdh Realisasi 500046</a>
                <a href="<?php echo site_url('/report/activity_belum_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Blm Realisasi 500046</a>
                
					<a href="<?php echo site_url('/report/cust_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas per Nasabah</a>                
               		<!--<a href="<?php echo site_url('/report/kriteria_bisnis/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Kriteria Bisnis</a> -->                
               		<a href="<?php echo site_url('/report/other_product/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Produk Lain Nasabah</a>   
					<a href="<?php echo site_url('/report/oportunity/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rasio Aktivitas</a>
               		<a href="<?php echo site_url('/report/cust_planning_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Perencanaan Aktivitas</a> 
                    <a href="<?php echo site_url('/report/follow_up/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Tindak Lanjut</a> 
                    <a href="<?php echo site_url('/report/daily_closed/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penutupan Penjualan</a> 
                    <a href="<?php echo site_url('/report/bni_product_1/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Produk BNI Nasabah</a>                
                	<a href="<?php echo site_url('/report/nasabah_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan Sales</a>  
					<a href="<?php echo site_url('/report/nasabah_sup_aum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />AUM Nasabah Kel. Sales</a>					
                    <a href="<?php echo site_url('/report/realisasi_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales</a>                    
                    <a href="<?php echo site_url('/report/performance_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales</a>
                    <!--<a href="<?php echo site_url('/report/performance_cab/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Cabang</a> -->
                    <a href="<?php echo site_url('/report/monthly_performance/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Bulanan</a>					
                    <a href="<?php echo site_url('/report/perform_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Tahunan</a>
                    <!--<a href="<?php echo site_url('/report/real_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales Tahunan</a> -->
                    <a href="<?php echo site_url('/report/kelolaan_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />DPK Sales</a>
					<a href="<?php echo site_url('/report/kelolaan_month/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Outstanding DPK Bulanan</a>
					<a href="<?php echo site_url('/report/audit_trail/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Audit Trail</a>
					<a href="<?php echo site_url('/report/new_customer_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOC Sales</a>
					<a href="<?php echo site_url('/report/new_account_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOA Sales</a> 
					<a href="<?php echo site_url('/report/konsumer_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Krdt Konsumtif Sales</a>	
					<a href="<?php echo site_url('/report/cc_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Kartu Kredit Sales</a>
					<a href="<?php echo site_url('/report/dplk_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rek. DPLK Sales</a>
					<!--<a href="<?php echo site_url('/report/perform_sales_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performance Sales Tahunan</a>-->                
					<a href="<?php echo site_url('/report/pipeline_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Tgl)</a>		
					<a href="<?php echo site_url('/report/pipeline_count_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Jumlah)</a>	
				</div>
			   
			    <h3><a href="#">Target</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/target/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Target</a>
                    <!-- <a href="<?php echo site_url('/realisasi/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Target Sales</a> -->
               	</div>
				
                <h3><a href="#">Upload</a></h3>
                <div id='box-body'>
                    <!-- <a href="<?php echo site_url('csv/download'); ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Download Realisasi</a> -->
                    <a href="<?php echo site_url('csv/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Pencapaian Manual</a>                                                   
					<a href="<?php echo site_url('upload_dpk2/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Tambahan DPK</a>                 
					<a href="<?php echo site_url('upload_dpk3/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Pengurangan DPK</a>                   
          <!--a href="<?php echo site_url('upload_account_planning/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Account Planning</a-->                   
               
			   </div>
			   <h3><a href="#">Status Non Sales</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/status/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Status Non Sales</a>
               	</div>
                
                <?php } if($level == 'SDM') { ?>
             	
                <!-- WILAYAH MENU -->                
                <h3><a href="#">Home</a></h3>
                <div id='box-body'>
                     <a href="<?php echo site_url('/home/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Home</a>
               </div>
                <h3><a href="#">Report</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/report/performance_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales</a>
                    <a href="<?php echo site_url('/report/perform_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Tahunan</a>
                </div>
				
				<?php } if($level == 'HLB') { ?>
				<!--<h3><a href="#">Usulan Flagging 2016</a></h3>
				<div id='box-body'>
					<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penugasan Nasabah</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/approval') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Approval</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah_all') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />List Nasabah</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/report_flagging_2016') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/change_pengelola_sln') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Approval Perubahan Pengelola</a>
				</div>-->
				
				<?php } if($level == 'SALES_ADMIN') { ?>
				<h3><a href="#">Upload</a></h3>
                <div id='box-body'>
                    <!-- <a href="<?php echo site_url('csv/download'); ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Download Realisasi</a> -->
                    <!-- a href="<?php echo site_url('csv/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Pencapaian Manual</a>                                                   
					<a href="<?php echo site_url('upload_dpk2/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Tambahan DPK</a>                 
					<a href="<?php echo site_url('upload_dpk3/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Pengurangan DPK</a-->                   
					<!--<a href="<?php echo site_url('upload_account_planning/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Account Planning</a>-->          
				</div>
				
				<?php } if($level == 'ADMIN') { ?>
                
                <!-- ADMIN MENU -->
                <h3><a href="#">Home</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/home/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Home</a>
					<a href="<?php echo site_url('/home/point') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Program SGP</a>
				</div>
				<h3><a href="#">Flagging</a></h3>
                <div id='box-body'>                    
                <a href="<?php echo site_url('/self_flagging/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Admin Sales</a>
                <a href="<?php echo site_url('/self_flagging/spv') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />SPV</a>
				<a href="<?php echo site_url('/self_flagging/bm') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />PEMIMPIN/PIMPINAN Cabang</a>
                <a href="<?php echo site_url('/self_flagging/sln') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />SLN</a>
				<a href="<?php echo site_url('/self_flagging/report') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
				</div>
				<h3><a href="#">Report TOP 20/10</a></h3>
			<div id='box-body'>
				<a href="<?php echo site_url('/report/nasabah_bm_sum_sln/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
				<a href="<?php echo site_url('/activity_bm/get_rekap_outlet') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rekap Activity</a>
				<?php #if($id==91641 || $id==91169) { ?>
				<a href="<?php echo site_url('/activity_bm/update_top') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Admin TOP</a>
				<a href="<?php echo site_url('/mobile/reset') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Reset Password Mobile</a>
				<?php #}?>
			</div>
                <h3><a href="#">Report Tunjangan Performance</a></h3>
			<div id='box-body'>
				<a href="<?php echo site_url('/report/performance_sup_tunjangan/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Tunjangan Performance</a>
			</div>
                <h3><a href="#">Report</a></h3>
                <div id='box-body'>
					<a href="<?php echo site_url('/report/activity_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Harian</a>
                    <a href="<?php echo site_url('/report/activity_realisasi/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Sdh Realisasi</a>
                    <a href="<?php echo site_url('/report/activity_belum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Blm Realisasi</a>
                    <a href="<?php echo site_url('/report/activity_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Harian 500046</a>
                <a href="<?php echo site_url('/report/activity_realisasi_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Sdh Realisasi 500046</a>
                <a href="<?php echo site_url('/report/activity_belum_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Blm Realisasi 500046</a>
                
					<a href="<?php echo site_url('/report/cust_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Nasabah</a>                
               		<!--<a href="<?php echo site_url('/report/kriteria_bisnis/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Kriteria Bisnis</a> --> 
					<a href="<?php echo site_url('/report/oportunity/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rasio Aktivitas Sales</a>
               		<a href="<?php echo site_url('/report/other_product/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Produk Lain Nasabah</a>                
               		<a href="<?php echo site_url('/report/cust_planning_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Perencanaan Aktivitas</a> 
                    <a href="<?php echo site_url('/report/follow_up/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Tindak Lanjut</a> 
                    <a href="<?php echo site_url('/report/daily_closed/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penutupan Penjualan</a> 
                    <a href="<?php echo site_url('/report/bni_product_1/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Produk BNI Nasabah</a>                
                	<a href="<?php echo site_url('/report/nasabah_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan Sales</a>                    
                    <a href="<?php echo site_url('/report/nasabah_sup_aum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />AUM Nasabah Kelolaan Sales</a> 
					<a href="<?php echo site_url('/report/realisasi_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales</a>                    
                    <a href="<?php echo site_url('/report/performance_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales</a>
                   <!--  <a href="<?php echo site_url('/report/performance_cab/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Cabang</a> -->                    
                    <a href="<?php echo site_url('/report/perform_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Tahunan Sales</a>
                    <a href="<?php echo site_url('/report/real_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales Tahunan</a>
                    <a href="<?php echo site_url('/report/kelolaan_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />DPK Sales</a>
					<a href="<?php echo site_url('/report/audit_trail/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Audit Trail</a>
					<a href="<?php echo site_url('/report/new_customer_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOC Sales</a>
					<a href="<?php echo site_url('/report/new_account_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOA Sales</a> 
					<!--<a href="<?php echo site_url('/report/user_nonaktif/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />User Non Active</a>-->
					<a href="<?php echo site_url('/report/user_aktif/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />User Active</a>
					 <a href="<?php echo site_url('/report/user_nonaktif/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />User Non Active</a>
					<a href="<?php echo site_url('/report/konsumer_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Krdt Konsumtif Sales</a>	
					<a href="<?php echo site_url('/report/cc_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Kartu Kredit Sales</a>
					<a href="<?php echo site_url('/report/dplk_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rek. DPLK Sales</a>
					<a href="<?php echo site_url('/report/status/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Status Non Sales</a>
					<!--<a href="<?php echo site_url('/report/perform_sales_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performance Sales Tahunan</a>-->                
					<a href="<?php echo site_url('/report/pipeline_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Tgl)</a>		
				<a href="<?php echo site_url('/report/pipeline_count_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Jumlah)</a>	
				<a href="<?php echo site_url('/report/pipeline_coach_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Worksheet Pipeline (Sales)</a>
					<a href="<?php echo site_url('/report/pipeline_coach_reg/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Grouping Pipeline (Wilayah)</a>
					<a href="<?php echo site_url('/report/pipeline_coach_kb/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Grouping Pipeline </a>
				</div>
                
                <h3><a href="#">Incentive</a></h3>
                    <div id='box-body'>
                    <a href="<?php echo site_url('/report/incentive/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Incentive</a>
                    </div>
            
                <h3><a href="#">Setting Parameter</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/sales_activity/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Activity</a>
                    <a href="<?php echo site_url('/response/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Response</a>
                    <a href="<?php echo site_url('/salestype/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Type</a>
                    <a href="<?php echo site_url('/sales_product/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Type Product</a>
                    <a href="<?php echo site_url('/product/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />BNI Product</a>
                    <a href="<?php echo site_url('/product_kpi/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Tabel KPI</a>
                    <a href="<?php echo site_url('/bobot_kpi/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Bobot per Product KPI</a>
                    <a href="<?php echo site_url('/map_kpi/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Mapping KPI vs Product</a>
                    <a href="<?php echo site_url('/incentive/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Tabel Incentive</a>
                    <a href="<?php echo site_url('/mapping_kpi_sales/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Mapping KPI per Sales</a>
                    <a href="<?php echo site_url('/parameter/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />PARAMETER</a>
                </div>
                
                <h3><a href="#">Admin</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('user'); ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />User Management</a>
                    <a href="<?php echo site_url('cabang'); ?>" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Data Cabang</a>    
					<a href="<?php echo site_url('/mobile/unregister') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Unregister Mobile</a>
				</div>
				
				<h3><a href="#">Data DPK</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('dpk'); ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Proses Otomasi DPK</a>
                    <!-- <a href="<?php echo site_url('hitung_performance'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Hitung Performance</a>   -->                                             
				</div>
                
                <h3><a href="#">Upload</a></h3>
                <div id='box-body'>
                    <!-- <a href="<?php echo site_url('csv/download'); ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Download Realisasi</a> -->
                    <a href="<?php echo site_url('csv/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Realisasi</a>
					<a href="<?php echo site_url('flagging/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Flagging</a>                                                   
					<a href="<?php echo site_url('upload_dpk2/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Tambahan</a>                                                   
					<a href="<?php echo site_url('csv/upload_sln'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Pencapaian SLN</a>                                                   
					<a href="<?php echo site_url('upload_dpk2/upload_sln'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Tambahan SLN</a>                                      
					<a href="<?php echo site_url('upload_dpk3/upload_sln'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Pengurangan</a> 
					<!--<a href="<?php echo site_url('upload_account_planning/upload'); ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Upload Account Planning</a>-->          
				</div>
				
				 <h3><a href="#">Target</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/target/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Target</a>
                    <a href="<?php echo site_url('/realisasi/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Target Sales</a>
               	</div>
				
				<h3><a href="#">Berita</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/berita/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Berita SAPM</a>
               	</div>
				
				<h3><a href="#">Status Non Sales</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/status/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Status Non Sales</a>
               	</div>
				
				<h3><a href="#">Web Statistic</a></h3>
                <div id='box-body'>
                    <a href="http://brftst.bni.co.id/awstats/awstats.pl?config=sapmprod" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Web Statistic</a>
               	</div>
				<h3><a href="#">Usulan Nasabah Kelolaan 2015</a></h3>
				<div id='box-body'>
                <a href="<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2015</a>	
				 <a href="<?php echo site_url('/report_usulan_nasabah_kel/report') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Nasabah Kelolaan 2015</a>	
				</div>
				
				<h3><a href="#">Usulan Nasabah Kelolaan 2017</a></h3>
            <div id='box-body'>
                <!--a href="<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2017</a-->
				<a href='<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2017</a>
				<br/><a href='<?php echo site_url('/usulan_nasabah/list_nasabah_rem') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Remove 2017</a> 
				<a href='<?php echo site_url('/usulan_nasabah/list_nasabah_tambahan') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Usulan Tambah di Luar Bucket</a>
				 <!--a href="<?php echo site_url('/report_usulan_nasabah_kel/report') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Nasabah Kelolaan 2017</a-->	
            </div>
			
				<h3><a href="#">Data Segmentasi</a></h3>
				<div id='box-body'>
				 <a href="<?php echo site_url('/segmentasi/upload') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Download Data</a>
				 <a href="<?php echo site_url('/segmentasi/audit') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Audit Trail</a>
				</div>
				
				<h3><a href="#">Usulan Flagging 2016</a></h3>
				<div id='box-body'>
					<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penugasan Nasabah</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/approval') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Approval</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/list_nasabah_all') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />List Nasabah</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/report_flagging_2016') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
					<a href="<?php echo site_url('/usulan_nasabah_v1/change_pengelola_sln') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Approval Perubahan Pengelola</a>
				</div>
		
             
				<?php } if($level == 'TIM') { ?>
                
                <!-- TIM MENU -->
                <h3><a href="#">Home</a></h3>
                <div id='box-body'>                    
                <a href="<?php echo site_url('/home/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Home</a>
                </div>
                <h3><a href="#">Report TOP 20/10</a></h3>
			<div id='box-body'>
				<a href="<?php echo site_url('/report/nasabah_bm_sum_sln/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report</a>
				<a href="<?php echo site_url('/activity_bm/get_rekap_outlet') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rekap Activity</a>
			</div>
                <h3><a href="#">Report</a></h3>
                <div id='box-body'>
                    <!--a href="<?php echo site_url('/report/activity_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Harian</a>
                    <a href="<?php echo site_url('/report/activity_realisasi/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Sdh Realisasi</a>
                    <a href="<?php echo site_url('/report/activity_belum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Blm Realisasi</a>
                    <a href="<?php echo site_url('/report/activity_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Harian 500046</a>
                <a href="<?php echo site_url('/report/activity_realisasi_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Sdh Realisasi 500046</a>
                <a href="<?php echo site_url('/report/activity_belum_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Blm Realisasi 500046</a>
                
					<a href="<?php echo site_url('/report/cust_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas per Nasabah</a>                
               		<!--<a href="<?php echo site_url('/report/kriteria_bisnis/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Kriteria Bisnis</a> -->                
               		<!--a href="<?php echo site_url('/report/other_product/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Produk Lain Nasabah</a>   
					<a href="<?php echo site_url('/report/oportunity/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rasio Aktivitas</a>
               		<a href="<?php echo site_url('/report/cust_planning_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Perencanaan Aktivitas</a> 
                    <a href="<?php echo site_url('/report/follow_up/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Tindak Lanjut</a> 
                    <a href="<?php echo site_url('/report/daily_closed/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penutupan Penjualan</a> 
                    <a href="<?php echo site_url('/report/bni_product_1/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Produk BNI Nasabah</a>                
                	-->
					<a href="<?php echo site_url('/report/nasabah_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan Sales</a>  
					<!--a href="<?php echo site_url('/report/nasabah_sup_aum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />AUM Nasabah Kel. Sales</a-->					
                    <a href="<?php echo site_url('/report/realisasi_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales</a>                    
                    <a href="<?php echo site_url('/report/performance_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales</a>
                    <!--<a href="<?php echo site_url('/report/performance_cab/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Cabang</a> -->
                    <a href="<?php echo site_url('/report/monthly_performance/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Bulanan</a>					
                    <a href="<?php echo site_url('/report/perform_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Tahunan</a>
                    <!--<a href="<?php echo site_url('/report/real_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales Tahunan</a> -->
                    <a href="<?php echo site_url('/report/kelolaan_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />DPK Sales</a>
					<a href="<?php echo site_url('/report/kelolaan_month/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Outstanding DPK Bulanan</a>
					<a href="<?php echo site_url('/report/audit_trail/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Audit Trail</a>
					<a href="<?php echo site_url('/report/new_customer_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOC Sales</a>
					<a href="<?php echo site_url('/report/new_account_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />NOA Sales</a> 
					<a href="<?php echo site_url('/report/konsumer_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Krdt Konsumtif Sales</a>	
					<a href="<?php echo site_url('/report/cc_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Kartu Kredit Sales</a>
					<a href="<?php echo site_url('/report/dplk_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rek. DPLK Sales</a>
					<!--<a href="<?php echo site_url('/report/perform_sales_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performance Sales Tahunan</a>-->                
					<a href="<?php echo site_url('/report/pipeline_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Tgl)</a>		
					<a href="<?php echo site_url('/report/pipeline_count_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Jumlah)</a>	
					<a href="<?php echo site_url('/report/pipeline_coach_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Worksheet Pipeline (Sales)</a>
					<a href="<?php echo site_url('/report/pipeline_coach_reg/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Grouping Pipeline (Wilayah)</a>
					<a href="<?php echo site_url('/report/pipeline_coach_kb/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Grouping Pipeline </a>
				</div>
                
                <h3><a href="#">Cust contact management</a></h3>
             	<div id='box-body'>
                    <a href="<?php echo site_url('/activity/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Aktivitas Harian</a>
                </div>
				
				<h3><a href="#">Data Segmentasi</a></h3>
				<div id='box-body'>
				 <!--a href="<?php echo site_url('/segmentasi/upload') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Download Data</a-->
				 <a href="<?php echo site_url('/segmentasi/audit') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Audit Trail</a>
				</div>
                
				<h3><a href="#">Status Non Sales</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/status/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Status Non Sales</a>
               	</div>
				
                <!--h3><a href="#">Leads Management</a></h3>
             	<div id='box-body'>
                    <a href="<?php echo site_url('/sales/cust_ind') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Manajemen Nasabah</a>	
                </div>
				-->
                 <!--
				 <h3><a href="#">Target</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/target/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Target</a>
                    <a href="<?php echo site_url('/realisasi/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Target Sales</a>
               	</div>
                <h3><a href="#">Realisasi</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/realisasi/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Target Sales</a>
               	</div>
				<h3><a href="#">Berita</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/news/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Berita SAPM</a>
               	</div>
                -->
<?php } if($level == 'WEM' ||$level=='HLB') { ?>
                
                <!-- TIM MENU -->
                <h3><a href="#">Home</a></h3>
                <div id='box-body'>                    
                <a href="<?php echo site_url('/home/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Home</a>
                </div>
				<h3><a href="#">Flagging</a></h3>
                <div id='box-body'>                    
                <!--<a href="<?php echo site_url('/self_flagging/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Admin Sales</a>
                <a href="<?php echo site_url('/self_flagging/spv') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />SPV</a>
				<a href="<?php echo site_url('/self_flagging/bm') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />PEMIMPIN/PIMPINAN Cabang</a>-->
                <a href="<?php echo site_url('/self_flagging/sln') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Baru</a>
				<a href="<?php echo site_url('/self_flagging/list_nasabah_tambahan') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Lama</a>
				<a href="<?php echo site_url('/self_flagging/report') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Sales Baru</a>
				</div>
                <h3><a href="#">Report</a></h3>
                <div id='box-body'>
                    <!--a href="<?php echo site_url('/report/activity_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas Harian</a>
                    <a href="<?php echo site_url('/report/activity_realisasi/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Sdh Realisasi</a>
                    <a href="<?php echo site_url('/report/activity_belum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Blm Realisasi</a>
                    <a href="<?php echo site_url('/report/activity_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Harian 500046</a>
                <a href="<?php echo site_url('/report/activity_realisasi_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Sdh Realisasi 500046</a>
                <a href="<?php echo site_url('/report/activity_belum_tele/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Akt. Blm Realisasi 500046</a>
                
					<a href="<?php echo site_url('/report/cust_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Aktivitas per Nasabah</a>                
               		<!--<a href="<?php echo site_url('/report/kriteria_bisnis/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Kriteria Bisnis</a> -->                
               		<!--a href="<?php echo site_url('/report/other_product/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Produk Lain Nasabah</a>   
					<a href="<?php echo site_url('/report/oportunity/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rasio Aktivitas</a>
               		<a href="<?php echo site_url('/report/cust_planning_daily/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Perencanaan Aktivitas</a> 
                    <a href="<?php echo site_url('/report/follow_up/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Tindak Lanjut</a> 
                    <a href="<?php echo site_url('/report/daily_closed/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penutupan Penjualan</a> 
                    <a href="<?php echo site_url('/report/bni_product_1/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Produk BNI Nasabah</a>                
                	-->
					<a href="<?php echo site_url('/report/nasabah_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan Sales</a>  
					<!--a href="<?php echo site_url('/report/nasabah_sup_aum/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />AUM Nasabah Kel. Sales</a-->					
                    <a href="<?php echo site_url('/report/realisasi_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales</a>                    
                    <a href="<?php echo site_url('/report/performance_sup/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales</a>
                    <!--<a href="<?php echo site_url('/report/performance_cab/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Cabang</a> -->
                    <a href="<?php echo site_url('/report/monthly_performance/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Bulanan</a>					
                    <a href="<?php echo site_url('/report/perform_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performa Sales Tahunan</a>
                    <!--<a href="<?php echo site_url('/report/real_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Sales Tahunan</a> -->
					<a href="<?php echo site_url('/report/audit_trail/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Audit Trail</a>
					<a href="<?php echo site_url('/report/cc_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Penj. Kartu Kredit Sales</a>
					<a href="<?php echo site_url('/report/dplk_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Rek. DPLK Sales</a>
					<!--<a href="<?php echo site_url('/report/perform_sales_year/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Performance Sales Tahunan</a>-->                
					<a href="<?php echo site_url('/report/pipeline_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Tgl)</a>		
					<a href="<?php echo site_url('/report/pipeline_count_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Pipeline (Jumlah)</a>	
					<a href="<?php echo site_url('/report/pipeline_coach_sup/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Worksheet Pipeline (Sales)</a>
					<a href="<?php echo site_url('/report/pipeline_coach_reg/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Grouping Pipeline (Wilayah)</a>
					<a href="<?php echo site_url('/report/pipeline_coach_kb/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Grouping Pipeline </a>
				</div>
                
                <h3><a href="#">Leads Management</a></h3>
             	<div id='box-body'>
                    <a href="<?php echo site_url('/sales/cust_ind') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Manajemen Nasabah</a>	
                </div>
				<!--h3><a href="#">Usulan Nasabah Kelolaan 2017</a></h3>
            <div id='box-body'>
                <a href="<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2017</a>
				<a href='<?php echo site_url('/usulan_nasabah/list_nasabah_kel') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Kelolaan 2017</a>
				<br/><a href='<?php echo site_url('/usulan_nasabah/list_nasabah_rem') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Nasabah Remove 2017</a> 
				<a href='<?php echo site_url('/usulan_nasabah/list_nasabah_tambahan') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Usulan Tambah di Luar Bucket</a>
				<a href='<?php echo site_url('/usulan_nasabah/report_list_nasabah') ?>'" class="side" ><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Nasabah Kelolaan 2017</a>
				<a href="<?php echo site_url('/report_usulan_nasabah_kel/report') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Report Nasabah Kelolaan 2017</a>	
            </div-->
                 <!--
				 <h3><a href="#">Target</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/target/') ?>" class="side"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Sales Target</a>
                    <a href="<?php echo site_url('/realisasi/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Target Sales</a>
               	</div>
                <h3><a href="#">Realisasi</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/realisasi/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Realisasi Target Sales</a>
               	</div>
				<h3><a href="#">Berita</a></h3>
                <div id='box-body'>
                    <a href="<?php echo site_url('/news/') ?>" class="side" style="border-bottom:none"><img src="<?php echo ICONS ?>arrow_right.gif" alt="arrow" border="0" />Berita SAPM</a>
               	</div>
                -->

		
		
		
		
		
 <?php }?>

