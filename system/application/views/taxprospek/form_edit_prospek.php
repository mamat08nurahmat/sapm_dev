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
				    <table border="0" cellspacing="2" style="font-size:11px;">
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

			<?PHP
				if ($prospek->JENIS_NASABAH == 1) {
					$readonly = 'readonly';
				}
				else{
					$readonly = '';
				}
			?>
			<!-- right content -->
            <div class="col-md-10">

				<div class="panel panel-default">
					<div class="panel-heading" style="background-color:#008080; color:#fff;"><strong>EDIT PROSPEK</strong></div><br />
					<div class="table-responsive" style="margin:10px; overflow:hidden;">
						 <form class="form-horizontal" role="form" method="post" action="<?php echo site_url('prospek/proses_edit_prospek'); ?>">
							<div class="form-group">
							  <label class="control-label col-sm-2" for="pwd"><p class="text-left">Jenis Nasabah</p></label>
							  <div class="col-sm-10">
								<div class="checkbox">
									<input type="hidden" name="id" class="form-control" placeholder="" value="<?php echo $prospek->ID; ?>" >
									<label class="radio-inline"><input type="radio" name="jenis"  onChange="disabledfield();" value="1"
									<?php echo set_value('jenis', $prospek->JENIS_NASABAH) == 1 ? "checked" : "";?>>Nasabah</label>
									<label class="radio-inline"><input type="radio" name="jenis"  onChange="disabledfield();" value="2"
									<?php echo set_value('jenis', $prospek->JENIS_NASABAH) == 2 ? "checked" : "";?>>Non Nasabah</label>
								</div>
								<!--<div class="checkbox">
									<label class="radio-inline"><input type="radio" name="jenis"  onChange="disabledfield();" value="" required>Existing</label>
									<label class="radio-inline"><input type="radio" name="jenis" onChange="disabledfield();" value="" required>Non Existing</label>
								</div>-->
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-2" for="email"><p class="text-left" >CIF / ID Nasabah</p></label>
							  <div class="col-sm-7">
								<input type="text" name="cif" class="form-control" placeholder=""  value="<?php echo $prospek->ID_NASABAH; ?>" <?php echo $readonly; ?>>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-2" for="pwd"><p class="text-left" >Nama Nasabah</p></label>
							  <div class="col-sm-7">
								<input type="text" name="nama" id="name_nasabah" class="form-control"  placeholder="" value="<?php echo $prospek->NAMA_NASABAH; ?>">
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-2" for="email"><p class="text-left" >Referral ID</p></label>
							  <div class="col-sm-5">
								<input type="text" maxlength="7" name="referral_id" class="form-control" placeholder="" value="<?php echo $prospek->REFERRAL_ID; ?>">
								* input npp anda jika tidak ada yang mereferralkan
							  </div>
							</div>
							<div class="form-group ">
							  <label class="control-label col-sm-2" for="pwd"><p class="text-left">Status</p></label>
							  <div class="col-sm-10">
								<div class="checkbox">
									<label class="radio-inline"><input type="radio" name="status" value="1"
									<?php echo set_value('status', $prospek->STATUS) == 1 ? "checked" : "";  ?> >Prospek</label>
									<label class="radio-inline"><input type="radio" name="status" value="2"
									<?php echo set_value('status', $prospek->STATUS) == 2 ? "checked" : "";  ?> >Peminat</label>
								</div>
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-2" for="pwd" ><p class="text-left">Potensi</p></label>
							  <div class="col-sm-4">
								<input type="text" name="potensi" id="rupiah" class="form-control"  placeholder="" value="<?php echo $prospek->POTENSI; ?>" >
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
		$('#rupiah').maskMoney({prefix:'', thousands:'.', decimal:',', precision:0});
		//$('#angka4').maskMoney();
	});
	///////////////input rupiah///////////////////

	function disabledfield() {

		if (document.getElementById('yes_radio').checked == 1) {
			document.getElementById('textbox_A').disabled = 'disabled';
			document.getElementById('name_nasabah').focus();
		} else {
			document.getElementById('textbox_A').disabled = '';
			document.getElementById('textbox_A').focus();
		}

	}
</script>
