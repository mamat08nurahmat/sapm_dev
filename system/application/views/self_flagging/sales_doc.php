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
        <h2>Sales List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Npp</th>
		<th>Sales Type</th>
		<th>Nama</th>
		<th>Status</th>
		<th>Upliner</th>
		<th>Keterangan</th>
		<th>Alamat</th>
		<th>OfficeID</th>
		<th>Phone</th>
		
            </tr><?php
            foreach ($sales_data as $sales)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $sales->npp ?></td>
		      <td><?php echo $sales->sales_type ?></td>
		      <td><?php echo $sales->nama ?></td>
		      <td><?php echo $sales->status ?></td>
		      <td><?php echo $sales->upliner ?></td>
		      <td><?php echo $sales->keterangan ?></td>
		      <td><?php echo $sales->alamat ?></td>
		      <td><?php echo $sales->officeID ?></td>
		      <td><?php echo $sales->phone ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>