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
                </div><br /><br />

			</div>            <!-- end left content -->

			<?PHP
			/*================== ROLE ===================*/
			$role_id = $_SESSION['ROLE_ID'];
			/*================== ROLE ===================*/


			// if ($closing->ID == 1) {
				// $disabled = 'disabled';
			// } else {
				// $disabled = '';
			// }
			?>

			<!-- right content -->
            <div class="col-md-10">
			<!------------ notifikasi pesan ------------->
			<?php
				$pesan = $this->session->flashdata('pesan');
				if (! empty($pesan)){
					echo $pesan;
				}
			?>
			<!------------ notifikasi pesan ------------->
				<div class="panel panel-default">
					<div class="panel-heading" style="background-color:#008080; color:#fff;">
					<?php
						//admin || kantor_besar || hcr || bm
						if ($role_id == 1 || $role_id == 2 || $role_id == 3 || $role_id == 4 || $role_id == 5) {
					?>
						<strong>LIST AKTIVITAS</strong>
					<?php
						//jika super_admin dan pic
						} else {
					?>
						<a href="<?php echo site_url('aktivitas/tambah_aktivitas'); ?>"><button class="btn btn-warning" type="button">Input Aktivitas</button></a>
					<?php
						}
					?>
					</div><br />
					<div class="table-responsive">
					<table id="example" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Jenis Nasabah</th>
							<th>Cif / ID Nasabah</th>
							<th>Nama Nasabah</th>
							<th>Potensi</th>
							<th>Akt Terakhir</th>
							<th>Tgl Aktivitas</th>
							<th>Komitmen</th>
							<th>Nominal</th>
							<?php
								//ROLE PIC
								if ($role_id == 6) {

								}
								else {
							?>
									<th>NPP</th>
							<?php
								}
							?>

							<?php
								//ROLE PIC
								if ($role_id == 6) {

								}
								else {
							?>
									<th>Nama PIC</th>
							<?php
								}
							?>

							<?php
								//ROLE PIC
								if ($role_id == 5 || $role_id == 6) {

								}
								else {
							?>
									<th>Cabang</th>
							<?php
								}
							?>

							<?php
								//ROLE PIC
								if ($role_id == 4 || $role_id == 5 || $role_id == 6) {

								}
								else {
							?>
									<th>Wilayah</th>
							<?php
								}
							?>
							<th>History</th>
							<?php
								//admin || kantor_besar || hcr || bm
								if ($role_id == 1 || $role_id == 2 || $role_id == 3 || $role_id == 4 || $role_id == 5) {

								}
								else {
							?>
								<th>Closing</th>
							<?php
								}
							?>
						</tr>
					</thead>

					<tbody>
					<?php foreach($tampil as $no => $data) { $no++  ?>
					<?php
						// if ($data->ID_CLOSING == TRUE) {
							// $disabled = 'disabled';
						// }
						// else {
							// $disabled = '';
						// }
					?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $data->JENIS_NASABAH; ?></td>
							<td><?php echo $data->ID_NASABAH; ?></td>
							<td><?php echo $data->NAMA_NASABAH; ?></td>
							<td><?php echo "Rp. " . number_format($data->POTENSI, 0, ".", "."); ?></td>
							<td><?php echo $data->AKTIVITAS_TERAKHIR; ?></td>
							<td><?php echo $data->TANGGAL_AKTIVITAS; ?></td>
							<td><?php echo $data->KOMITMEN; ?></td>
							<td><?php echo "Rp. " . number_format($data->NOMINAL, 0, ".", "."); ?></td>
							<?php
								//ROLE PIC
								if ($role_id == 6) {

								}
								else {
							?>
									<td><?php echo $data->ID_PIC; ?></td>
							<?php
								}
							?>

							<?php
								//ROLE PIC
								if ($role_id == 6) {

								}
								else {
							?>
									<td><?php echo $data->NAMA_PIC; ?></td>
							<?php
								}
							?>

							<?php
								//ROLE PIC
								if ($role_id == 5 || $role_id == 6) {

								}
								else {
							?>
									<td><?php echo $data->BRANCH_NAME; ?></td>
							<?php
								}
							?>

							<?php
								//ROLE PIC
								if ($role_id == 4 || $role_id == 5 || $role_id == 6) {

								}
								else {
							?>
									<td><?php echo $data->WILAYAH; ?></td>
							<?php
								}
							?>
							<td><a href="<?php echo site_url('aktivitas/history/'.$data->ID_PROSPEK); ?>"><button class="btn btn-primary" type="button">History</button></a> </td>
							<?php
								//admin || kantor_besar || hcr || bm
								if ($role_id == 1 || $role_id == 2 || $role_id == 3 || $role_id == 4 || $role_id == 5) {

								}
								else {
							?>
									<td>
									<?php if(!in_array($data->ID_PROSPEK,$arr_closing)) { ?>
									<a href="<?php echo site_url('aktivitas/closing/'.$data->ID_PROSPEK); ?>"><button class="btn btn-success" type="button" >Input Closing</button></a>
									<?php } else { ?>
									<button class="btn btn-danger" type="button" disabled>Sudah Closing</button>
									</td>
									<?php } ?>
							<?php
								}
							?>
						</tr>
					<?php } ?>
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
