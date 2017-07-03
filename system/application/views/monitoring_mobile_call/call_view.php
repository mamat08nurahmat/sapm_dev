<!-----------------load header------------------>
<?php echo $this->load->view('layout_mobile_monitoring/header'); ?>
<!-----------------load header------------------>

        <!-- row -->
        <div class="row" >
            <!-- left content -->
            <div class="col-md-2">

			   <!-- menu acordion -->
			   <?php echo $this->load->view('layout_mobile_monitoring/menu'); ?>
			   <!-- end menu acordion -->

				<div class="informasi-atas">
                    INFORMASI USER
                </div>
                <div class="informasi-content">
				    <table border="0" cellspacing="2">
                      <tr>
                        <td align="left"><div style="padding:2px">NPP</div></td>
                        <td>:</td>
                        <td width="100%" align="left"><div style="padding:2px"><?php echo $this->session->userdata('ID'); ?></div></td>
                      </tr>
                      <tr>
                        <td align="left"><div style="padding:2px">Nama</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"><?php echo $this->session->userdata('USER_NAME'); ?></div></td>
                      </tr>
                      <tr>
                        <td align="left"><div style="padding:2px">Level</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"><?php echo $this->session->userdata('USER_LEVEL'); ?></div></td>
                      </tr>


					                        <tr>
                        <td align="left"><div style="padding:2px">Region</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"><?php echo $this->session->userdata('REGION'); ?></div></td>
                      </tr>
                      <tr>
                        <td align="left"><div style="padding:2px">Branch</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"><?php echo $this->session->userdata('BRANCH_NAME'); ?></div></td>
                      </tr>
                                            <tr>
                        <td align="left"><div style="padding:2px">Grade</div></td>
                        <td>:</td>
                        <td align="left"><div style="padding:2px"><?php echo $this->session->userdata('GRADE'); ?></div></td>
                      </tr>
                    </table>
                </div>

			</div>
            <!-- end left content -->

			<!-- right content -->
            <div class="col-md-10">
				<div class="panel panel-default">
					<div class="panel-heading" style="background-color:#008080; color:#fff;">List Visit</div><br />
					<div class="table-responsive">
					<table id="example" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>NPP</th>
							<th>Nama Pemimpin</th>
							<th>Cabang</th>
							<th>Nama Nasabah</th>
							<th>Hasil Call</th>
							<th>Hasil</th>
							<th>TLP</th>
							<th>Durasi</th>
							<th>Tanggal</th>
							<th>Waktu</th>
							<th>Location</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($data->result() as $no => $hasil): $no++



					?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $hasil->NPP; ?></td>
							<td><?php echo $hasil->NAMA_SALES; ?></td>
							<td><?php echo $hasil->CABANG; ?></td>
							<td><?php echo $hasil->NAMA; ?></td>
							<td><?php echo $hasil->NAMA_HASIL_CALL; ?></td>
							<td><?php echo $hasil->KETERANGAN; ?></td>
							<td><?php echo $hasil->NOTLP; ?></td>
							<td><?php echo $hasil->DURASI; ?></td>
							<td><?php echo $hasil->TANGGAL; ?></td>
							<td><?php echo $hasil->WAKTU; ?></td>
							<td><a data-toggle="modal"  href="<?php echo site_url('call_mobile_monitoring/detail/'.$hasil->IDCALL); ?>"> <button type="button" class="btn btn-primary">View Maps</button></a></td>
							<!--  echo $hasil->LAT .',' .$hasil->LNG   -->
						</tr>
					<?php endforeach ?>
					</tbody>
					</table>
					</div>
					</div>
				</div>
            </div>
			<!-- end right content -->

<!-----------------load footer------------------>
<?php echo $this->load->view('layout_mobile_monitoring/footer'); ?>
<!-----------------load footer------------------>
