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
<table class="table table-bordered table-striped" >
        <thead>
            <tr>
				<th>No</th>
                <th>Jenis Nasabah</th>
                <th>Cif/ ID Nasabah</th>
                <th>Nama Nasabah</th>
                <th>Potensi</th>
				<th>Aktivitas Terakhir</th>
				<th>Tanggal Aktivitas</th>
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
            </tr>
        </thead>
		<?php foreach($aktivitas as $no=> $data): $no++ ?>

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
					<td><?php echo $data->CABANG; ?></td>
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
        </tr>
        <?php endforeach; ?>
 </table>
  </div><br />
 <p class="text-right"><?php echo $link_excel; ?></p>
