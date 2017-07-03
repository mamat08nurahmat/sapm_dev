<!-----------------load header------------------>
<?php echo $this->load->view('layout_taxamnesty/header'); ?>
<!-----------------load header------------------>
<script>
function doconfirm()
{
    hapus = confirm("Apakah anda yakin akan menghapus");
    if(hapus!=true)
    {
        return false;
    }
}
</script>

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


			<!-- right content -->
			<?PHP
			/*================== ROLE ===================*/
			$role_id = $_SESSION['ROLE_ID'];
			/*================== ROLE ===================*/
			?>

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
						<strong>LIST PROSPEK</strong>
					<?php
						//jika super_admin dan pic
						} else {
					?>
					<a href="<?php echo site_url('prospek/tambah_prospek'); ?>"><button class="btn btn-warning" type="button">Tambah</button></a>

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
							<th>Referral ID</th>
							<th>Nama</th>
							<th>Status</th>
							<th>Potensi</th>
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

							<!----------------------------->
							<?php
								if ($role_id == 5 || $role_id == 6) {

								}
								else {
								//selain itu tampilkan cabangya
							?>
									<th>Cabang</th>
							<?php
								}
							?>
							<!----------------------------->

							<!----------------------------->
							<?php
								//jika wilayah atau bm
								if ($role_id == 4 || $role_id == 5 || $role_id == 6) {

								}
								else {
							?>
								<th>Wilayah</th>
							<?php
								}
							?>
							<!----------------------------->

							<?php
								//jika wilayah atau bm
								if ($role_id == 2 || $role_id == 3 || $role_id == 4 || $role_id == 5) {

								}
								else {
							?>
							<th>Aksi</th>
							<?php
								}
							?>
						</tr>
					</thead>

					<tbody>

					<?php


						foreach($tampil as $no => $data) { $no++

					?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $data->JENIS_NASABAH; ?></td>
							<td><?php echo $data->ID_NASABAH; ?></td>
							<td><?php echo $data->REFERRAL_ID; ?></td>
							<td><?php echo $data->NAMA_NASABAH; ?></td>
							<td><?php echo $data->STATUS; ?></td>
							<td><?php echo "Rp. " . number_format($data->POTENSI, 0, ".", "."); ?></td>
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
								if ($role_id == 5 || $role_id == 6) {

								}
								else {
									//selain itu tampilkan cabangya
							?>
									<td><?php echo $data->BRANCH_NAME; ?></td>
							<?php
								}
							?>


							<?php
								//FIELD WILAYAH
								if ($role_id == 4 || $role_id == 5 || $role_id == 6) {

								}
								else {
							?>
								<td><?php echo $data->WILAYAH; ?></td>
							<?php
								}
							?>

							<?php
								//AKSI EDIT
								if ($role_id == 2 || $role_id == 3 || $role_id == 4 || $role_id == 5) {

								}
								else {
							?>
							<td><center><a href="<?php echo site_url('prospek/edit_prospek/' . $data->ID); ?>"><button class="btn btn-info" type="button">Edit</button></a></center></td>
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
