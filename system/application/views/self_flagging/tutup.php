<?php $this->load->view('default/header') ?>	
<!---=====================================--->
    <!-- Main content -->
   	<section class="content2">

<!---=====================================--->



<!------------------------------>
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> 
                    <strong>WARNING!</strong>
    </div>
</section>	
<!------------------------------>
<div class="row">
	<div class="col-xs-12">


	
	<!--div style="color:#000; margin:50px 0px" align="center">Maaf Usulan Flagging ditutup dari tgl 1 s.d 7!Terima Kasih</div-->
	<div style="color:#000; margin:50px 0px" align="center">Maaf Usulan Flagging ditutup dari tgl 1 s.d 7!Terima Kasih.</div>
	<div>
    	<?php #echo "<pre>"; print_r($_SESSION); echo "</pre>" ?>
    </div>
	
	</div>
</div>
	
	

<!-- Main content End-->
   	</section>

<script type="text/javascript">
$(function(){
	$( "#accordion" ).accordion({ active:<?php echo $data ?> });
});	
</script>

<?php $this->load->view('default/footer') ?>