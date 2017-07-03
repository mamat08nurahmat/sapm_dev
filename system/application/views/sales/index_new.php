<?php $this->load->view('template/header') ?>	
<?php $this->load->view('template/topbar') ?>	
<?php $this->load->view('template/sidebar') ?>	
<!----------------------------------------------------->

<script type="text/javascript">

			$(document).ready(function() {
				getTabel1();
							
				
			});

		function getTabel1()
		{
/*
			var urls = '<?php echo site_url('/account_planning/get_ap/') ?>/' + id +'/'+month+'/'+year;
			$("#report_msg").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
			$("#report_msg").load(urls);
//			var id = <?php echo $_SESSION['ID'] ?>;
			var id = '15057';
			var urls = '<?php echo site_url('/self_flagging/get_list_tambahan/') ?>/' + id;
			var urls2 = '<?php echo site_url('/usulan_nasabah/usulan_tambah/') ?>/';
*/			


//var urls = '<?php echo site_url('/db/tabel/')?>';		
var urls = '<?php echo site_url('/sales/tabel1/')?>';		

$("#tabel1").load(urls);
		}


			
			
</script>
	
<!----------------------------------------------------->
    <!-- Main content -->
   	<section class="content">
        <!-- START CUSTOM TABS -->

	<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> LEADS MANAGEMENT 
    </div>


</section>
<!-- ----------- -->
	<?php if($_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG'|| $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='SUPERVISOR' ) { ?>
	<div id="dlg_list_sales" title="Pilih Sales" style="diplay:none">
		<div id="form_input">
		<form method="post" action="<?php echo site_url('sales_ajax/append_sales_propensity');?>" id="frm_append_sales">
			<select name="sales_id" style="width:100%;padding:2px 0px 2px 2px">
				<option value=""></option>
				<?php foreach($list_sales as $value=>$text) { ?>
				<option value="<?php echo $value;?>"><?php echo $text;?></option>
				<?php } ?>
			</select>
			<div id="tampung_buat_cif" style="display:none">
				<input type="hidden" name="id[]" value="" />
			</div>
			<input type="submit" style="display:none" value="Submit" />
		</form>
		</div>
		
		<div id="loading_box" style="display:none">
			<img src="<?php echo ICONS;?>loading_bar.gif" alt="Loading...." width="350" height="19" />
		</div>
	</div>
	<?php } ?>

	<?php if($_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG'|| $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='SUPERVISOR') { ?>
	<div id="dlg_list_sales2" title="Pilih Sales" style="diplay:none">
		<div id="form_input2">
		<form method="post" action="<?php echo site_url('sales_ajax/append_sales_500046');?>" id="frm_append_sales2">
			<select name="sales_id" style="width:100%;padding:2px 0px 2px 2px">
				<option value=""></option>
				<?php foreach($list_sales as $value=>$text) { ?>
				<option value="<?php echo $value;?>"><?php echo $text;?></option>
				<?php } ?>
			</select>
			<div id="tampung_buat_cif2" style="display:none">
				<input type="hidden" name="id[]" value="" />
			</div>
			<input type="submit" style="display:none" value="Submit" />
		</form>
		</div>
		
		<div id="loading_box2" style="display:none">
			<img src="<?php echo ICONS;?>loading_bar.gif" alt="Loading...." width="350" height="19" />
		</div>
	</div>
	<?php } ?>

	
	<?php if($_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG'|| $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='SUPERVISOR') { ?>
	<div id="dlg_list_sales3" title="Pilih Sales" style="diplay:none">
		<div id="form_input3">
		<form method="post" action="<?php echo site_url('sales_ajax/append_sales_offensive');?>" id="frm_append_sales3">
			<select name="sales_id" style="width:100%;padding:2px 0px 2px 2px">
				<option value=""></option>
				<?php foreach($list_sales as $value=>$text) { ?>
				<option value="<?php echo $value;?>"><?php echo $text;?></option>
				<?php } ?>
			</select>
			<div id="tampung_buat_cif3" style="display:none">
				<input type="hidden" name="id[]" value="" />
			</div>
			<input type="submit" style="display:none" value="Submit" />
		</form>
		</div>
		
		<div id="loading_box3" style="display:none">
			<img src="<?php echo ICONS;?>loading_bar.gif" alt="Loading...." width="350" height="19" />
		</div>
	</div>
	<?php } ?>
	
<!------------- -->

	
            <!-- Custom Tabs -->
 <div class="nav-tabs-custom">

			  <ul class="nav nav-pills">

			  
			  <?php
			if($_SESSION['USER_LEVEL']=='SALES' && ($_SESSION['SALES_ID'] < 9||$_SESSION['SALES_ID'] >19))
			{  
			  ?>
                <li class="active"><a href="#tab_1" data-toggle="tab">Leads offensive</a></li>
                <li><a href="#tab_2" data-toggle="tab">Leads Propensity</a></li>
                <li><a href="#tab_3" data-toggle="tab">Leads 500046</a></li> 
				<li><a href="#tab_4" data-toggle="tab">Leads Kelolaan</a></li>
                <li><a href="#tab_5" data-toggle="tab">Leads Prospek</a></li>
		<?php } ?>			  

              </ul>
			 
			 
			 
<!------
----->			 
<div class="tab-content">

    <div class="tab-pane active" id="tab_1">

<h5><strong>DATA LEADS OFFENSIVE</strong></h5>
<!---
        <table id="table1" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
			
                <tr>
                    <th>ID</th>
                    <th>CIF</th>
                    <th>NAMA</th>
                    <th>No HP</th>
                    <th>PROGRAM</th>
                    <th>PRODUK</th>
                    <th style="width:50px;">Action</th>
                </tr>

            </thead>
            <tbody>
            </tbody>

        </table>

--->        
<!-------------------->
              <table id="example1" class="table table-bordered table-striped">
			  
                <thead>
                <tr>
                    <th>ID</th>
                    <th>CIF</th>
                    <th>NAMA</th>
                    <th>No HP</th>
                    <th>PROGRAM</th>
                    <th>PRODUK</th>
                    <th style="width:50px;">Action</th>                
				</tr>
                </thead>
				
                <tbody>
<?php
foreach($data_tab4 as $row){
?>	

                <tr>
                  <td><?php echo $row->ID ?></td>
                  <td><?php echo $row->CIF ?></td>
                  <td><?php echo $row->CUST_NAME ?></td>
                  <td><?php echo $row->AGE ?></td>
                  <td><?php echo $row->TOTAL_AUM_BNI ?></td>
                  <td><?php echo $row->TOTAL_LOAN_BNI ?></td>
                  <td>
					  <a href="<?php echo site_url('/sales/tab_1_view/')?>" class="btn btn-default" type="button" ><span class="glyphicon glyphicon glyphicon-zoom-in" aria-hidden="true"></span></a>
				 </td>
                  
                </tr>
<?php	
}
?>								
				
                

                </tbody>
				
				
              </table>
				
<!-------------------->				


    </div>


    <div class="tab-pane " id="tab_2">
        
                <h5><strong>DATA LEADS PROPENSITY</strong></h5>
<!--
        <table id="table2" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CIF KEY</th>
                    <th>EMAIL</th>                    
                    <th>BRANCH</th>
                    <th>BNI HP NO</th>
                    <th>PROGRAM PENJUALAN</th>
					<th>PRODUK</th>
                    <th>JANGKA WAKTU PR</th>
                    <th style="width:50px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>


        </table>
--->
<!-------------------->
              <table id="example2" class="table table-bordered table-striped">
			  
                <thead>
                <tr>
                <tr>
                    <th>ID</th>
                    <th>CIF KEY</th>
                    <th>EMAIL</th>                    
                    <th>BRANCH</th>
                    <th>BNI HP NO</th>
                    <th>PROGRAM PENJUALAN</th>
					<th>PRODUK</th>
                    <th>JANGKA WAKTU PR</th>
                    <th style="width:50px;">Action</th>
                </tr>
                </thead>
				
                <tbody>
<?php
foreach($data_tab4 as $row){
?>	

                <tr>
                  <td><?php echo $row->ID ?></td>
                  <td><?php echo $row->CIF ?></td>
                  <td><?php echo $row->CUST_NAME ?></td>
                  <td><?php echo $row->AGE ?></td>
                  <td><?php echo $row->TOTAL_AUM_BNI ?></td>
                  <td><?php echo $row->TOTAL_LOAN_BNI ?></td>
                  <td><?php echo $row->BNI_SALES_ID ?></td>
                  <td><?php echo $row->BRANCH_NAME ?></td>
				  <td>
				  <a href="<?php echo site_url('/sales/tab_2_view/')?>" class="btn btn-default" type="button" ><span class="glyphicon glyphicon glyphicon-zoom-in" aria-hidden="true"></span></a>
				  </td>

                </tr>
<?php	
}
?>								
				
                

                </tbody>
				
				
              </table>
				
<!-------------------->				


    </div>

    <div class="tab-pane " id="tab_3">
        
                <h5><strong>DATA LEADS 150046</strong></h5>
<!----
        <table id="table3" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>SAPM_DATE</th>
                    <th>CIF</th>
                    <th>NAMA</th>
                    <th>NO HP</th>
                    <th>KOTA</th>
                    <th>JENIS_PRODUK</th>
                    <th>KODE_CABANG</th>
                    <th style="width:50px;">Action</th>
            </thead>
                </tr>
            <tbody>
            </tbody>


        </table>
---->
<!-------------------->
              <table id="example3" class="table table-bordered table-striped">
			  
                <thead>
                <tr>
                    <th>ID</th>
                    <th>SAPM_DATE</th>
                    <th>CIF</th>
                    <th>NAMA</th>
                    <th>NO HP</th>
                    <th>KOTA</th>
                    <th>JENIS_PRODUK</th>
                    <th>KODE_CABANG</th>
                    <th style="width:50px;">Action</th>
                </tr>
                </thead>
				
                <tbody>
<?php
foreach($data_tab4 as $row){
?>	

                <tr>
                  <td><?php echo $row->ID ?></td>
                  <td><?php echo $row->CIF ?></td>
                  <td><?php echo $row->CUST_NAME ?></td>
                  <td><?php echo $row->AGE ?></td>
                  <td><?php echo $row->TOTAL_AUM_BNI ?></td>
                  <td><?php echo $row->TOTAL_LOAN_BNI ?></td>
                  <td><?php echo $row->BNI_SALES_ID ?></td>
                  <td><?php echo $row->BRANCH_NAME ?></td>
				 <td>
				 <a href="<?php echo site_url('/sales/tab_3_view/')?>" class="btn btn-default" type="button" ><span class="glyphicon glyphicon glyphicon-zoom-in" aria-hidden="true"></span></a>
				 </td>
                </tr>
<?php	
}
?>								
				
                

                </tbody>
				
				
              </table>
				
<!-------------------->				




    </div>

    <div class="tab-pane " id="tab_4">
        
                <h5><strong>DATA LEADS KELOLAAN</strong></h5>


<!-------------------->
              <table id="example4" class="table table-bordered table-striped">
			  
                <thead>
                <tr>
                    <th>ID</th>
                    <th>SAPM_DATE</th>
                    <th>CIF</th>
                    <th>NAMA</th>
                    <th>NO HP</th>
                    <th>KOTA</th>
                    <th>JENIS_PRODUK</th>
                    <th>KODE_CABANG</th>
					<th style="width:50px;">Action</th>
                </tr>
                </thead>
				
                <tbody>
<?php
foreach($data_tab4 as $row){
?>	

                <tr>
                  <td><?php echo $row->ID ?></td>
                  <td><?php echo $row->CIF ?></td>
                  <td><?php echo $row->CUST_NAME ?></td>
                  <td><?php echo $row->AGE ?></td>
                  <td><?php echo $row->TOTAL_AUM_BNI ?></td>
                  <td><?php echo $row->TOTAL_LOAN_BNI ?></td>
                  <td><?php echo $row->BNI_SALES_ID ?></td>
                  <td><?php echo $row->BRANCH_NAME ?></td>
				  <td>
				  <a href="<?php echo site_url('/sales/tab_4_view/0/'.$_SESSION['ID'])?>" class="btn btn-default" type="button" ><span class="glyphicon glyphicon glyphicon-zoom-in" aria-hidden="true"></span></a>
				  </td>
                </tr>
<?php	
}
?>								
				
                

                </tbody>
				
				
              </table>
				
<!-------------------->				
				
				
    </div>

    <div class="tab-pane " id="tab_5">
        
                    <h5><strong>DATA LEADS PROSPEK</strong></h5>
<!---
        <table id="table5" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
               <tr>
                    <th>ID</th>
                    <th>CIF</th>
                    <th>NAMA</th>
                    <th>UMUR</th>
                    <th style="width:50px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

        </table>
--->
<!-------------------->
              <table id="example5" class="table table-bordered table-striped">
			  
                <thead>
                <tr>
					<th>ID</th>
                    <th>CIF</th>
                    <th>NAMA</th>
                    <th>UMUR</th>
                    <th style="width:50px;">Action</th>
                </tr>
                </thead>
				
                <tbody>
<?php
foreach($data_tab4 as $row){
?>	

                <tr>
                  <td><?php echo $row->ID ?></td>
                  <td><?php echo $row->CIF ?></td>
                  <td><?php echo $row->CIF ?></td>
                  <td><?php echo $row->CUST_NAME ?></td>
				  <td>
				  <a href="<?php echo site_url('/sales/tab_5_view/')?>" class="btn btn-default" type="button" ><span class="glyphicon glyphicon glyphicon-zoom-in" aria-hidden="true"></span></a>
				  <a href="<?php echo site_url('/sales/tab_5_add/')?>" class="btn btn-default" type="button" ><span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span></a>
				  <a href="<?php echo site_url('/sales/tab_5_edit/')?>" class="btn btn-default" type="button" ><span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
				  <a href="<?php echo site_url('/sales/tab_5_delete/')?>" class="btn btn-default" type="button" ><span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span></a>
				  </td>
                </tr>
<?php	
}
?>								
				
                

                </tbody>
				
				
              </table>
				
<!-------------------->				


    </div>


</div>


</div>
         <!-- / end class .row -->

		 

<!--------------------->
</section>
<!--------------------->


	
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.8
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

  
  
  
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    //$("#example1").DataTable();

    $('#example1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });


	
    $('#example3').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });

//t	
    $('#example4').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });

    $('#example5').DataTable({
      paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });

	
  });
</script>
</body>
</html>

	
<!------------------------------------------------------------->
<?php// $this->load->view('template/js') ?>	
<?php //$this->load->view('template/footer') ?>