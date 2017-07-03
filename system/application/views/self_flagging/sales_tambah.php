<?php $this->load->view('template/header') ?>	
<!--tambahkan custom Js disini-->

<!-- jQuery 2.1.3 ???-->
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS ???
-->
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<!-- DataTables 
  <link href="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/datatables/dataTables.bootstrap.css">
-->

 <?php $this->load->view('template/topbar') ?>	
<?php $this->load->view('template/sidebar') ?>	
<!----------------------------------------------------->

    <!-- Content Header (Page header) 
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>
	-->

	
<script type="text/javascript">
			$(document).ready(function() {
				getDataNasabahUsulan();
							
				
			});

		function getDataNasabahUsulan()
		{
/*
			var urls = '<?php echo site_url('/account_planning/get_ap/') ?>/' + id +'/'+month+'/'+year;
			$("#report_msg").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
			$("#report_msg").load(urls);
*/			
//			var id = <?php echo $_SESSION['ID'] ?>;
			var id = '15057';
			var urls = '<?php echo site_url('/self_flagging/get_list_tambahan/') ?>/' + id;
			var urls2 = '<?php echo site_url('/usulan_nasabah/usulan_tambah/') ?>/';


//var urls = '<?php echo site_url('/db/tabel/')?>';		
//---->>> month = 2	
			$("#report_msg").load(urls);
		}


			
			
</script>
	
	
    <!-- Main content -->
    <section class="content">
	  
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
		  
            <div class="box-header">
              <h3 class="box-title">Usulan Tambah Nasabah Berjalan</h3>

<!---
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
--->			  
            </div>
<div id='report_msg'></div>			
            <!-- /.box-header -->
<!----
--->			
            <div class="box-body table-responsive no-padding">
				<br><br>
				<button type="button" class="btn  btn-default btn-sm ">Tambah Nasabah</button>
				<button type="button" class="btn  btn-default btn-sm ">Cek Usulan</button>
				<button type="button" class="btn  btn-default btn-sm ">Cleansing</button>
				<button type="button" class="btn  btn-default btn-sm ">Kirim usulan</button>
				<br><br>			
			
			  <table class="table table-striped">
                <tr>
				
                  <th>No</th>
                  <th>JENIS</th>
                  <th>CIF</th>
                  <th>JENIS CIF</th>
                  <th>NAMA NASABAH</th>
                  <th>CIF UTAMA</th>
                  <th>HUB DENGAN UTAMA</th>
                  <th>STATUS </th>
                  <th>APPROVAL</th>
                  <th>TANGGAL KIRIM</th>
				  
                </tr>

                <tr>
                  <td>1</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Approved</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>                  <td>183</td>
                  <td>John Doe</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Approved</span></td>
                  <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                </tr>


              </table>
			  
            </div>
			
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>	  
	  
	  
    </section>
    <!-- /.content -->
	



<!------------------------------------------------------------->
<?php $this->load->view('template/js') ?>	

<!-- DataTables
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/datatables/dataTables.bootstrap.min.js"></script>
 -->

<?php $this->load->view('template/footer') ?>	
