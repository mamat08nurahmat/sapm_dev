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
					<div class="panel-heading" style="background-color:#339AAF; color:#fff;"><strong>EDIT PROGRAM</strong></div><br />
					<div class="table-responsive" style="margin:10px; overflow:visible">
						 <form class="form-horizontal" method="post" role="form" id="frmlogin" action="<?php echo site_url('phr_program/update_program'); ?>">
							<div class="form-group">
                                <label class="control-label col-sm-2" for=""><p class="text-left">Nama Program</p></label>
  							    <div class="col-sm-3">
                                    <?php echo form_error('nama_program', '<div style="color:red">', '</div>');  ?>
                                    <input type="hidden" name="id_program" class="form-control" value="<?php echo $programedit->ID_PROGRAM; ?>">
  								    <input type="text" name="nama_program" class="form-control" value="<?php echo $programedit->NAMA_PROGRAM; ?>">
  							    </div>

							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Periode Awal</p></label>
							  <div class="col-sm-3">
                                  <?php echo form_error('tgl_awal', '<div style="color:red">', '</div>');  ?>
								<input type="text" id="tanggal1" name="tgl_awal" class="form-control" value="<?php echo $programedit->TGL_AWAL; ?>">
							  </div>

							</div>

                            <div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Periode Akhir</p></label>
							  <div class="col-sm-3">
                                <?php echo form_error('tgl_akhir', '<div style="color:red">', '</div>');  ?>
								<input type="text" id="tanggal" name="tgl_akhir" class="form-control" value="<?php echo $programedit->TGL_AKHIR; ?>">
							  </div>

							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for="email"><p class="text-left">Penjelasan Program</p></label>
							  <div class="col-sm-8">
                                   <?php echo form_error('penjelasan_program', '<div style="color:red">', '</div>');  ?>
									<textarea name="penjelasan_program" class="form-control" rows="3"><?php echo $programedit->PENJELASAN_PROGRAM; ?></textarea>
							  </div>
							</div>

							<div class="form-group">
							  <div class="col-sm-offset-2 col-sm-10">
								<input type="submit" name="update" class="btn btn-primary" value="Update" />
								<input type="button" name="batal" class="btn btn-warning" onclick=self.history.back() value="Batal" />
							  </div>
							</div>


						  </form>
					 </div>
				 </div>





        </div>
        <!-- end col -->


    </div>
    <!-- /.row -->
</div>
<!-- /.End Konten Isi -->

<?php
    $this->load->view('layout_phr_nasabah/footer.php');
?>