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
					<div class="panel-heading" style="background-color:#008080; color:#fff;">HISTORY AKTIVITAS |
					<button class="btn btn-warning" type="button" onclick=self.history.back()>Kembali</button>
					<span style="float: right">

						NASABAH : <strong><?php echo $getnama->NAMA_NASABAH; ?></strong></span>

					</div><br />
					<div class="table-responsive">
					<table id="example" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Aktivitas</th>
							<th>Status</th>

							<th>Keterangan</th>
						</tr>
					</thead>

					<tbody>
					<?php
						foreach($data as $no=> $hasil): $no++


					?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $hasil->TANGGAL; ?></td>

							<?php
							$call  = isset($call) ? $call : "";  //menghilangkan notice undefined index
							$visit = isset($visit) ? $visit : "";

							if ($hasil->AKTIVITAS == "Call") {
								$call++;
							?>
								<td><?php echo "Call ".$call; ?></td>
							<?php
							} else {
								$visit++;
							?>
							<td><?php echo "Visit ".$visit; ?></td>
							<?php } ?>


							<td><?php echo $hasil->STATUS; ?></td>
							<td><?php echo $hasil->KETERANGAN; ?></td>
						</tr>


					<?php endforeach ?>
					</tbody>
					</table>
					</div>
				</div><br /><br />

            </div>
			<!-- end right content -->

        </div><!-- end row content -->

<!-----------------load footer------------------>
<?php echo $this->load->view('layout_taxamnesty/footer'); ?>
<!-----------------load footer------------------>
