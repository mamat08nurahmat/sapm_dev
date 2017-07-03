<?php
	$this->load->view('layout_phr_nasabah/header.php'); 
?>
	<!-- jQuery -->
	<script src="<?php echo NEWJS.'jquery.js' ?>"></script>
    <!-- datetimepicker -->
	<script src="<?php echo NEWJS.'moment.js' ?>"></script>
	<script src="<?php echo NEWJS.'bootstrap-datetimepicker.min.js' ?>"></script>	
	<script type="text/javascript">
    	

    	// datepicker
    	$(function(){

    		// $("#tanggal1").datepicker({
    			// format: 'd-m-yyyy'
    		// });
    		$('#tanggal1').datetimepicker({
                format: 'DD-MMM-YYYY',

    			// //locale: 'id'
            });

            $('#tanggal').datetimepicker({
                format: 'DD-MMM-YYYY',

    			// //locale: 'id'
            });
			//validase start date less then end date
			 $("#tanggal1").on("dp.change",function (e) {
				$('#tanggal').data("DateTimePicker").minDate(e.date);
			});
			$("#tanggal").on("dp.change",function (e) {
				$('#tanggal1').data("DateTimePicker").maxDate(e.date);
			});
    		


    	})
    </script>
	<!-- end datetimepicker -->

<!-- Konten Isi -->
<div class="container">

    <!-- Marketing Icons Section -->
    <div class="row">
        <div class="col-lg-12">
            <br />
            <?php
                $pesan = $this->session->flashdata('pesan');
                if (! empty($pesan)){
                    echo $pesan;
                }
            ?>
           
            <div class="panel panel-default">
					<div class="panel-heading" style="background-color:#339AAF; color:#fff;"><strong>INPUT PROGRAM</strong></div><br />
					<div class="table-responsive" style="margin:10px; overflow:visible">
						 <form class="form-horizontal" method="post" role="form" id="frmlogin" action="<?php echo site_url('phr_program/save_program_action'); ?>">
							<div class="form-group">
                                <label class="control-label col-sm-2" for=""><p class="text-left">Nama Program</p></label>
  							    <div class="col-sm-3">
                                    <?php echo form_error('nama_program', '<div style="color:red">', '</div>');  ?>
  								    <input type="text" name="nama_program" class="form-control" >
  							    </div>

							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Periode Awal</p></label>
							  <div class="col-sm-3">
                                  <?php echo form_error('tgl_awal', '<div style="color:red">', '</div>');  ?>
								<input type="text" id="tanggal1" name="tgl_awal" class="form-control">
							  </div>

							</div>

                            <div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Periode Akhir</p></label>
							  <div class="col-sm-3">
                                <?php echo form_error('tgl_akhir', '<div style="color:red">', '</div>');  ?>
								<input type="text" id="tanggal" name="tgl_akhir" class="form-control">
							  </div>

							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for="email"><p class="text-left">Penjelasan Program</p></label>
							  <div class="col-sm-8">
                                   <?php echo form_error('penjelasan_program', '<div style="color:red">', '</div>');  ?>
									<textarea name="penjelasan_program" class="form-control" rows="3"></textarea>
							  </div>
							</div>

							<div class="form-group">
							  <div class="col-sm-offset-2 col-sm-10">
								<input type="submit" name="simpan" class="btn btn-primary" value="Simpan" />
								<input type="button" name="batal" class="btn btn-warning" onclick=self.history.back() value="Batal" />
							  </div>
							</div>


						  </form>
					 </div>
				 </div>

                 <br />
                 <div class="panel panel-default">
 					<div class="panel-heading" style="background-color:#49BAA8; color:#fff;"><STRONG>UPLOAD DATA PROGRAM CIF</STRONG>

 					</div><br />
 					<div class="form-horizontal" style="margin:10px">
 						<div class="form-group">
 							<div class="col-lg-5">
 								<a href="<?php echo site_url('phr_program/download_program'); ?>"><input type="submit" class="btn btn-warning" name="userfile" size="20" value="Unduh Format Upload" /></a>
 							</div>
 						</div><br />

 						<h4>Upload data program cif dengan file excel 97-2003 ekstensi.xls</h4>
 						<br />
 						<?php echo form_open_multipart('phr_program/proses_upload_program');?>
 						<div class="form-inline">
 							<div class="form-group">
 								<div class="col-lg-5">

 									<input type="file" id="file_upload" name="userfile" size="20" />
 								</div>
 							</div>
 							<input  type="submit" class="btn btn-sm btn-primary" name="upload" value="Upload Data" />
 						</div>
 						<?php echo form_close();?>

 					</div>
 					<br />



 				</div><br /><br />



        </div>
        <!-- end col -->


    </div>
    <!-- /.row -->
</div>
<!-- /.End Konten Isi -->

<?php
	$this->load->view('layout_phr_nasabah/footer.php'); 	
?>
