<?php
    $this->load->view('layout_phr_nasabah/header.php');
?>
	<!-- jQuery Flexigrid -->
	<link href="<?php echo CSS.'flexigrid.css' ?>" rel="stylesheet" type="text/css" />  
	<script type="text/javascript" src="<?php echo JQ ?>"></script> 
	<script type="text/javascript" src="<?php echo JUI ?>"></script>
	<script type="text/javascript" src="<?php echo JSFLEX ?>"></script>
	<script type="text/javascript" src="<?php echo JSNUM?>"></script>
	<script type="text/javascript" src="<?php echo JSMON?>"></script>
	<script type="text/javascript" src="<?php echo JS ?>number_format.js"></script>
	<!-- jQuery Flexigrid -->

<!-- Konten Isi -->
<div class="container">

    <!-- Marketing Icons Section -->
    <div class="row">
        <div class="col-lg-12">
			<br />
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#8FC0D8; color:#fff;">
                    <strong style="font-weight:bold">LIST PROGRAM CIF</strong>
                </div>
                <?php echo $js_grid; ?>
				<table id="result_list" style="display:none"></table>
            </div><br /><br />

        </div>
        <!-- end col -->


    </div>
    <!-- /.row -->
</div>
<!-- /.End Konten Isi -->

<?php
	$this->load->view("layout_phr_nasabah/footer.php");
?>
