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
        <h2 style="margin-top:0px">Sales Read</h2>
        <table class="table">
	    <tr><td>Npp</td><td><?php echo $npp; ?></td></tr>
	    <tr><td>Sales Type</td><td><?php echo $sales_type; ?></td></tr>
	    <tr><td>Nama</td><td><?php echo $nama; ?></td></tr>
	    <tr><td>Status</td><td><?php echo $status; ?></td></tr>
	    <tr><td>Upliner</td><td><?php echo $upliner; ?></td></tr>
	    <tr><td>Keterangan</td><td><?php echo $keterangan; ?></td></tr>
	    <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
	    <tr><td>OfficeID</td><td><?php echo $officeID; ?></td></tr>
	    <tr><td>Phone</td><td><?php echo $phone; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('sales') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>