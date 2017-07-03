<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Usulan_tambahan Read</h2>
        <table class="table">
	    <tr><td>Jenis</td><td><?php echo $jenis; ?></td></tr>
	    <tr><td>Cif</td><td><?php echo $cif; ?></td></tr>
	    <tr><td>Jenis Cif</td><td><?php echo $jenis_cif; ?></td></tr>
	    <tr><td>Nama Nasabah</td><td><?php echo $nama_nasabah; ?></td></tr>
	    <tr><td>Cif Utama</td><td><?php echo $cif_utama; ?></td></tr>
	    <tr><td>Hubungan Degan Utama</td><td><?php echo $hubungan_degan_utama; ?></td></tr>
	    <tr><td>Status</td><td><?php echo $status; ?></td></tr>
	    <tr><td>Approval</td><td><?php echo $approval; ?></td></tr>
	    <tr><td>Tanggal Kirim</td><td><?php echo $tanggal_kirim; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('usulan_tambahan') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>