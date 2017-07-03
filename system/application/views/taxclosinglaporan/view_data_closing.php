<style>
	th {
		background-color:#27AE60;
		text-transform:uppercase;
		text-align:center;
		padding:0.5em;
		color: #fff;
	}
</style>
<br /><br />

<?PHP
/*================== ROLE ===================*/
$role_id = $_SESSION['ROLE_ID'];
/*================== ROLE ===================*/
?>
<div class="table-responsive">
<table class="table table-bordered table-striped ">
        <thead>
            <tr>
				<th>No</th>
                <th>Jenis Nasabah</th>
                <th>No Rekening</th>
                <th>Nama Nasabah</th>
                <th>Nominal</th>
				<th>Jenis Closing</th>
				<th>Tanggal Closing</th>
				<th>Produk</th>
				<th>SKPP</th>
				<th>Keterangan</th>
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
						<th>Unit</th>
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
            </tr>
        </thead>
        <?php foreach($laporan as $no=> $data): $no++ ?>

        <tr>
			<td><?php echo $no; ?></td>
            <td><?php echo $data->JENIS_NASABAH;?></td>
            <td><?php echo $data->NO_REKENING;?></td>
            <td><?php echo $data->NAMA_NASABAH;?></td>
		    <td><?php echo "Rp. " . number_format($data->NOMINAL, 0, ".", "."); ?></td>
			<td><?php echo $data->JENIS_CLOSING; ?></td>
			<td><?php echo $data->TANGGAL_CLOSING;?></td>
			<td><?php echo $data->PRODUK; ?></td>
  			<td><?php echo $data->SKPP; ?></td>
			<td><?php echo $data->KETERANGAN; ?></td>
			<?php
				//ROLE PIC
				if ($role_id == 6) {

				}
				else {
			?>
					<td><?php echo $data->NPP; ?></td>
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
					<td><?php echo $data->UNIT; ?></td>
			<?php
				}
			?>

			<?php
				//ROLE PIC
				if ($role_id == 4 || $role_id == 5 ||$role_id == 6) {

				}
				else {
			?>
					<td><?php echo $data->WILAYAH; ?></td>
			<?php
				}
			?>
        </tr>
        <?php endforeach; ?>
 </table>
 </div><br />
<!--<p class="text-right"><a href=""><button class="btn btn-warning" type="button">Export Excel</button></a></a></p>-->
<p class="text-right"><?php echo $link_excel; ?></p> 
