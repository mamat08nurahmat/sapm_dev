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
			//$level = @$_SESSION['ROLE_ID'];
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

					<a href="<?php echo site_url('usertax/tambah_usertax'); ?>"><button class="btn btn-warning" type="button">Tambah</button></a>
									</div><br />
					<div class="table-responsive">

					<table id="example" class="display" cellspacing="0" width="100%">

					<thead>
						<tr>
							<th>No</th>
							<th>NPP</th>
							<th>Nama User</th>
							<th>Email</th>
							<th>Unit ID</th>
							<th>Level</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>

					<tbody>
					<?php foreach($tampil as $no => $data) { $no++  ?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $data->NPP; ?></td>
							<td><?php echo $data->USERNAME; ?></td>
							<td><?php echo $data->EMAIL; ?></td>
							<td><?php echo $data->CABANG; ?></td>
							<td><?php echo $data->NAMA_ROLE; ?></td>
							<?php
								if ($data->STATUS == 1) {
									$status = "Aktif";
								}
								else{
									$status = "Non Aktif";
								}
							?>
							<td><?php echo $status; ?></td>
							<td><center>
							    <a href="<?php echo site_url('usertax/edit_usertax/' . $data->NPP); ?>"><button class="btn btn-info" type="button">Edit</button></a> |
								<a href="<?php echo site_url('usertax/hapus_usertax/' . $data->NPP); ?>" ><button onclick="return confirmDelete();" class="btn btn-danger" type="button">Hapus</button></a>
							</center></td>
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
<script type="text/javascript">
    function confirmDelete() {
        return confirm('Apakah anda yakin ingin menghapus data user');
    }
</script>
