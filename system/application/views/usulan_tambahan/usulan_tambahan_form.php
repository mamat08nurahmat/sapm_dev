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
        <h2 style="margin-top:0px">Usulan_tambahan <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Jenis <?php echo form_error('jenis') ?></label>
            <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Jenis" value="<?php echo $jenis; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Cif <?php echo form_error('cif') ?></label>
            <input type="text" class="form-control" name="cif" id="cif" placeholder="Cif" value="<?php echo $cif; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Jenis Cif <?php echo form_error('jenis_cif') ?></label>
            <input type="text" class="form-control" name="jenis_cif" id="jenis_cif" placeholder="Jenis Cif" value="<?php echo $jenis_cif; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Nasabah <?php echo form_error('nama_nasabah') ?></label>
            <input type="text" class="form-control" name="nama_nasabah" id="nama_nasabah" placeholder="Nama Nasabah" value="<?php echo $nama_nasabah; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Cif Utama <?php echo form_error('cif_utama') ?></label>
            <input type="text" class="form-control" name="cif_utama" id="cif_utama" placeholder="Cif Utama" value="<?php echo $cif_utama; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Hubungan Degan Utama <?php echo form_error('hubungan_degan_utama') ?></label>
            <input type="text" class="form-control" name="hubungan_degan_utama" id="hubungan_degan_utama" placeholder="Hubungan Degan Utama" value="<?php echo $hubungan_degan_utama; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Status <?php echo form_error('status') ?></label>
            <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Approval <?php echo form_error('approval') ?></label>
            <input type="text" class="form-control" name="approval" id="approval" placeholder="Approval" value="<?php echo $approval; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Tanggal Kirim <?php echo form_error('tanggal_kirim') ?></label>
            <input type="text" class="form-control" name="tanggal_kirim" id="tanggal_kirim" placeholder="Tanggal Kirim" value="<?php echo $tanggal_kirim; ?>" />
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('usulan_tambahan') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>