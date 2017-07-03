<!doctype html>

<?php
$this->load->view('template/head');
?>

<!--tambahkan custom css disini-->
<!-- iCheck -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/iCheck/flat/blue.css') ?>" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/morris/morris.css') ?>" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.css') ?>" rel="stylesheet" type="text/css" />
<!-- Date Picker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css') ?>" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="<?php echo base_url('assets/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker-bs3.css') ?>" rel="stylesheet" type="text/css" />

<!-------+++++++++++++++++++++++++++++++------>



        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
<!-----
        <style>
            body{
                padding: 15px;
            }
        </style>
---->        

<!-------+++++++++++++++++++++++++++++++------>

<?php
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>



<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Manajemen sales
        <small>Sales List</small>
    </h1>
<!------
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
-->

</section>


<!-- Main content -->
<section class="content">

<!-------+++++++++++++++++++++++++++++++------>



        <h2 style="margin-top:0px">Sales <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Npp <?php echo form_error('npp') ?></label>
            <input type="text" class="form-control" name="npp" id="npp" placeholder="Npp" value="<?php echo $npp; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Sales Type <?php echo form_error('sales_type') ?></label>
            <input type="text" class="form-control" name="sales_type" id="sales_type" placeholder="Sales Type" value="<?php echo $sales_type; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama <?php echo form_error('nama') ?></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
	    <div class="form-group">
            <label for="enum">Status <?php echo form_error('status') ?></label>
            <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Upliner <?php echo form_error('upliner') ?></label>
            <input type="text" class="form-control" name="upliner" id="upliner" placeholder="Upliner" value="<?php echo $upliner; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Keterangan <?php echo form_error('keterangan') ?></label>
            <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" value="<?php echo $keterangan; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Alamat <?php echo form_error('alamat') ?></label>
            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">OfficeID <?php echo form_error('officeID') ?></label>
            <input type="text" class="form-control" name="officeID" id="officeID" placeholder="OfficeID" value="<?php echo $officeID; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Phone <?php echo form_error('phone') ?></label>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="<?php echo $phone; ?>" />
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('sales') ?>" class="btn btn-default">Cancel</a>
	</form>
        
<!-------+++++++++++++++++++++++++++++++---------->

</section>
<!-- End content -->

    </body>
</html>