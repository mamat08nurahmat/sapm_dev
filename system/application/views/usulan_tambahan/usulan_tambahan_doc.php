<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Usulan_tambahan List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Jenis</th>
		<th>Cif</th>
		<th>Jenis Cif</th>
		<th>Nama Nasabah</th>
		<th>Cif Utama</th>
		<th>Hubungan Degan Utama</th>
		<th>Status</th>
		<th>Approval</th>
		<th>Tanggal Kirim</th>
		
            </tr><?php
            foreach ($usulan_tambahan_data as $usulan_tambahan)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $usulan_tambahan->jenis ?></td>
		      <td><?php echo $usulan_tambahan->cif ?></td>
		      <td><?php echo $usulan_tambahan->jenis_cif ?></td>
		      <td><?php echo $usulan_tambahan->nama_nasabah ?></td>
		      <td><?php echo $usulan_tambahan->cif_utama ?></td>
		      <td><?php echo $usulan_tambahan->hubungan_degan_utama ?></td>
		      <td><?php echo $usulan_tambahan->status ?></td>
		      <td><?php echo $usulan_tambahan->approval ?></td>
		      <td><?php echo $usulan_tambahan->tanggal_kirim ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>