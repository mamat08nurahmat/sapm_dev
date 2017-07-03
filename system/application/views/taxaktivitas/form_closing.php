<!-----------------load header------------------>
<?php echo $this->load->view('layout_taxamnesty/header'); ?>
<!-----------------load header------------------>

        <!-- row -->
        <div class="row" >
            <!-- left content -->
            <div class="col-md-2">

			   <!-- menu acordion -->
			   <?php echo $this->load->view('layout_taxamnesty/menu'); ?>
			   <!-- end menu acordion -->

				<div class="informasi-atas">
                    INFORMASI USER
                </div>
                <div class="informasi-content">
				    <table border="0" cellspacing="2" style="font-size:11px; font-weight:bold;">
                      <tr>
                        <td align="left"><div style="padding:2px">Username</div></td>
                        <td>: </td>
                        <td width="100%" align="left"><div style="padding:2px"> <?php echo $this->session->userdata('ID'); ?></div></td>
                      </tr>

                      <tr>
                        <td align="left"><div style="padding:2px">Nama</div></td>
                        <td>: </td>
                        <td align="left"><div style="padding:2px"> <?php echo $this->session->userdata('USERNAME'); ?></div></td>
                      </tr>

                      <tr>
                        <td align="left"><div style="padding:2px">Level</div></td>
                        <td>: </td>
                        <td align="left"><div style="padding:2px"> <?php echo $this->session->userdata('NAMA_ROLE'); ?></div></td>
                      </tr>

					  <!--
					  <tr>
                        <td align="left"><div style="padding:2px">Region</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"></div></td>
                      </tr>-->

                      <tr>
                        <td align="left"><div style="padding:2px">Branch</div></td>
                        <td>: </td>
                        <td align="left"><div style="padding:2px"> <?php echo $this->session->userdata('BRANCH_NAME'); ?></div></td>
                      </tr>

					  <!--
					  <tr>
                        <td align="left"><div style="padding:2px">Grade</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"></div></td>
                      </tr>-->

				    </table>
                </div>
				<br /><br />
			</div>            <!-- end left content -->


			<!-- right content -->
            <div class="col-md-10">

				<div class="panel panel-default">
					<div class="panel-heading" style="background-color:#008080; color:#fff;"><strong>CLOSING</strong></div><br />
					<div class="table-responsive" style="margin:10px; overflow:visible;">
						 <form class="form-horizontal" role="form" id="frmlogin" method="post" action="<?php echo site_url('aktivitas/proses_tambah_closing'); ?>">
							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Nama Nasabah</p></label>
							  <div class="col-sm-5">
								<input type="hidden" name="id_prospek"   class="form-control" value="<?php echo $data->ID_PROSPEK; ?>">
								<input type="text" name="nama_nasabah" class="form-control"  placeholder="" value="<?php echo $data->NAMA_NASABAH; ?>">
							  </div>
							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Tanggal</p></label>
							  <div class="col-sm-3">
								<input type="text" id="tanggal1" name="tanggal" class="form-control" required>
							  </div>
							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Produk</p></label>
							  <div class="col-sm-2">
									<select class="form-control" name="produk" required>
										 <?php foreach ($lookupproduk as $row) { ?>
    										<option value="<?php echo $row->ID; ?>"><?php echo $row->KETERANGAN; ?></option>
                                        <?php } ?>
									</select>
							  </div>
							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">Jenis Closing</p></label>
							  <div class="col-sm-10">
								<div class="checkbox">
									<label class="radio-inline"><input type="radio" name="jenis" value="1" onChange="disabledfield();" required>Deklarasi</label>
									<label class="radio-inline"><input type="radio" name="jenis" value="2" onChange="disabledfield();" required>Repatriasi</label>
									<label class="radio-inline"><input type="radio" name="jenis" value="3" onChange="disabledfield();" id="yes_radio">Batal</label>
								</div>
							  </div>
							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for="email"><p class="text-left">No Rekening</p></label>
							  <div class="col-sm-5">
								<input type="text" name="no_rekening" class="form-control" id="textbox_A" placeholder="" required>
								* semua yang sudah masuk di rekening tax amnesty.
							  </div>
							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for=""><p class="text-left">SKPP</p></label>
							  <div class="col-sm-10">
								<div class="checkbox">
									<label class="radio-inline"><input type="radio" name="skpp" value="1" required>Sudah Terbit</label>
									<label class="radio-inline"><input type="radio" name="skpp" value="2" required>Belum Terbit</label>
								</div>
							  </div>
							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for="pwd"><p class="text-left" required>Nominal</p></label>
							  <div class="col-sm-5">
								<input type="text" name="nominal" class="form-control" id="textbox_B" placeholder="">
							  </div>
							</div>

							<div class="form-group">
							  <label class="control-label col-sm-2" for="email"><p class="text-left">Keterangan</p></label>
							  <div class="col-sm-8">
									<textarea name="keterangan" class="form-control" rows="3" id="textbox_C" required></textarea>
									* Untuk di rinci asset lokasi dana repatriasi (Deposito, Tabungan, Reksadana, Obligasi, dll).
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
			</div>
		</div><br /><br />

<!-----------------load footer------------------>
<?php echo $this->load->view('layout_taxamnesty/footer'); ?>
<!-----------------load footer------------------>


<!-----------------javascript disabled textbox------------------>
<script type="text/javascript">

	///////////////input rupiah///////////////////
	$(document).ready(function(){
		//$('#angka1').maskMoney();
		//$('#angka2').maskMoney({prefix:'US$'});
		$('#textbox_B').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});
		//$('#angka4').maskMoney();
	});
	///////////////input rupiah///////////////////

	function disabledfield() {

		if (document.getElementById('yes_radio').checked == 1){
			document.getElementById('textbox_A').disabled = 'disabled';
			document.getElementById('textbox_B').disabled = 'disabled';
			document.getElementById('textbox_C').focus();
			//document.getElementById('name_nasabah').focus();
		} else {
			document.getElementById('textbox_A').disabled = '';
			document.getElementById('textbox_B').disabled = '';
			document.getElementById('textbox_A').focus();
		}

	}

	function disabledfield2() {

		if (document.getElementById('yes_radio2').checked == 1){
			document.getElementById('textbox_A').disabled = 'disabled';
			document.getElementById('textbox_B').disabled = 'disabled';
			//document.getElementById('name_nasabah').focus();
		} else {
			document.getElementById('textbox_A').disabled = '';
			document.getElementById('textbox_B').disabled = '';
			document.getElementById('textbox_B').focus();
		}

	}
</script>
<!-----------------javascript disabled textbox------------------>
