<?php $this->load->view('template/header') ?>	


<?php $this->load->view('template/topbar') ?>	
<?php $this->load->view('template/sidebar') ?>	
<!----------------------------------------------------->
<!--tambahkan custom Js disini-->

<!-- jQuery 2.1.3 ???-->
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS ???-->
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<!---=====================================--->
<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	
		$("#tgl").datepicker({
			showOn: 'button',
			buttonImage: '<?php echo ICONS ?>calendar.gif',
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#tgl').datepicker('option', {dateFormat: 'd-m-yy'});
	});
	
	
</script>

	<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> SALES DASHBOARD
    </div>


</section>

    <!-- Main content -->
   	<section class="content">
        <!-- START CUSTOM TABS -->



<!----===============================---->

            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">SALES DASHBOARD</a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 
        <div class="row">
				-->
           <div class="tab-pane active" id="tab_1">



<!-- Main content -->
<section class="content">

<!-- Row 1 -->
<div class="row" id='todo_birthday' >

    <div class="col-xs-6">
		<div class="panel panel-info">
		
		  <div class="panel-heading">
			<h3 class="panel-title">
			<img src='<?php echo ICONS ?>icon-32-edit.png' />
			PERIKSA NASKEL
			&nbsp; 
			<input type="text" value="" name='cif' id='cif' style='width:90px' placeholder='Input CIF' />
			&nbsp;
<!---
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Check</button>
--->
			
			
			<button id='cifpress'>Periksa</button>
			</h3>			
		  </div>

		  <div class="panel-body">
			
			<div id='cifchecker_ajax' style='height:50px;overflow:auto;'>
             <?php //if(isset($cifchecker)) echo $cifchecker ?>
			</div>
			
		  </div>		  
		  
		  <div class="panel-heading">
			<h3 class="panel-title">
			<img src='<?php echo ICONS ?>icon-32-edit.png' />
			AGENDA SALES
			&nbsp; 
			<input type="text" value="" name='tgl' id='tgl' style='width:80px' readonly="readonly" />
			&nbsp;
			</h3>
		  </div>		  
		  
		  <div class="panel-body">
		  
            <div id='todo_ajax' style='height:270px;overflow:auto;'>
            <?php if(isset($todo)) echo $todo ?>
            </div> 
			
		  </div>
		  
		</div>
	</div>
		

    <div class="col-xs-6">
		<div class="panel panel-info">
		
		  <div class="panel-heading">
			<h3 class="panel-title">
			<img src='<?php echo ICONS ?>icon-32-date.gif' />
			Nasabah yg Ulang Tahun
			</h3>
		  </div>
		  
		  <div class="panel-body">
			
			<?php //if(isset($bday)) echo $bday ?>
            <div id='box_bday' style="padding:10px;height:350px;overflow:auto;">
			<?php //echo "<span style='color:#090'><img src='".LOAD."' alt='Loading'> Loading ... </span>"?>
						
			</div>
		  </div>
		  
		</div>
	</div>		

</div>		
		


<!-- Row 2 -->
<div class="row" id='target_realisasi'>

    <div class="col-xs-6">
		<div class="panel panel-info">
		  <div class="panel-heading">
			<h3 class="panel-title">
			<img src='<?php echo ICONS ?>icon-32-default.png' />
			Target Bulan Ini
			</h3>
		  </div>
		  <div class="panel-body">
		  
		<?php //if(isset($target)) echo $target ?>
          <div id='box_target' style="padding:10px;">
		<?php echo "<span style='color:#090'><img src='".LOAD."' alt='Loading'> Loading ... </span>"?>
		  </div>
		  
		  </div>
		</div>
	</div>
		

    <div class="col-xs-6">
		<div class="panel panel-info">
		  <div class="panel-heading">
			<h3 class="panel-title">
			<img src='<?php echo ICONS ?>icon-32-default.png' />
			Realisasi Bulan Lalu
			</h3>
		  </div>
		  <div class="panel-body">
			
			<?php //if(isset($realisasi)) echo $realisasi ?>
            <div id='box_realisasi' style="padding:10px;">
	<!---
			<?php //echo "<span style='color:#090'><img src='".LOAD."' alt='Loading'> Loading ... </span>"?>		  
	-->		
			</div>
		  </div>
		</div>
	</div>		

</div>		
		


<!-- Row 3 -->
<div class="row" id='delta_individu' >

    <div class="col-xs-6">
		<div class="panel panel-info">
		  <div class="panel-heading">
			<h3 class="panel-title">
			<img src='<?php echo ICONS ?>icon-32-up.png' />
			10 Nasabah dgn Kenaikan Tertinggi
			</h3>
		  </div>
		  <div class="panel-body">
			<?php //if(isset($cust_ind_up)) echo $cust_ind_up ?> 
            <div id='box_top_indv' style="padding:10px; height:350px">
			<?php //echo "<span style='color:#090'><img src='".LOAD."' alt='Loading'> Loading ... </span>"?>
             </div>
		  </div>
		</div>
	</div>
		

    <div class="col-xs-6">
		<div class="panel panel-info">
		  <div class="panel-heading">
			<h3 class="panel-title">
			<img src='<?php echo ICONS ?>icon-32-down.png' />
			10 Nasabah dgn Penurunan Tertinggi
			</h3>
		  </div>
		  <div class="panel-body">
            <?php //if(isset($cust_ind_down)) echo $cust_ind_down ?>
            <div id='box_lose_indv' style="padding:10px; height:350px">
			<?php //echo "<span style='color:#090'><img src='".LOAD."' alt='Loading'> Loading ... </span>"?>
            </div> 
		  </div>
		</div>
	</div>		

</div>		
		
		
		
		
                <!-- end tab1 -->
                <!-- /.tab-pane -->

                <!-- tab2 -->
                <!-- <div class="tab-pane" id="tab_2">
                  The European languages are members of the same family. Their separate existence is a myth.
                  For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                  in their grammar, their pronunciation and their most common words. Everyone realizes why a
                  new common language would be desirable: one could refuse to pay expensive translators. To
                  achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                  words. If several languages coalesce, the grammar of the resulting language is more simple
                  and regular than that of the individual languages.
                </div> -->
                <!-- end tab2 -->
                <!-- /.tab-pane -->

                <!-- tab3 -->
                <!-- <div class="tab-pane" id="tab_3">
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                  Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                  when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                  It has survived not only five centuries, but also the leap into electronic typesetting,
                  remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                  sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                  like Aldus PageMaker including versions of Lorem Ipsum.
                </div> -->
                <!-- end tab3 -->
                <!-- /.tab-pane -->

              </div>
              <!-- /.tab-content 
            </div>
			  -->
            <!-- nav-tabs-custom -->
          </div>
          <!-- /.col -->


        </div>
         <!-- / end class .row -->
<!----===============================---->


<!----===============================---->
</section>
<!----===============================---->
<script type="text/javascript">
$(document).ready(function(){
	
	$("#cifpress").click(function(){

		var cif = $('#cif').val();
		var urls = '<?php echo site_url('/dashboard/get_ajax_cifchecker') ?>/'+cif;

/*
		$("#cifchecker_ajax").html("<div class='items_dashboard' style='border:none;' align='center'><img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span></div>");
	
	//	alert(urls);
*/
		$("#cifchecker_ajax").load(urls);

	});
	
//row show	
	var level = '<?php echo strtoupper($_SESSION['USER_LEVEL'])?>';
	switch(level){
		case 'SALES':
			$('#todo_birthday').show();
			$('#target_realisasi').show();
			$('#delta_individu').show();
			$('#delta_corporate').show();
			break;
		case 'SUPERVISOR':
			$('#todo_birthday').hide();
			$('#target_realisasi').hide();
			$('#delta_individu').show();
			$('#delta_corporate').show();
			break;
		default:
			$('#todo_birthday').hide();
			$('#target_realisasi').hide();
			$('#delta_individu').show();
			$('#delta_corporate').show();
		}

	
});
/*
$(function() {	
	$('#tgl').change(function(){
		var tgl = $('#tgl').val();
		var urls = '<?php echo site_url('/dashboard/get_ajax_todo') ?>/'+tgl;
		$('#todo_ajax').html("<div class='items_dashboard' style='border:none;' align='center'><img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span></div>");
		$('#todo_ajax').load(urls);
	});
	
	$('#cifpress').click(function(){
		var cif = $('#cif').val();
		var urls = '<?php echo site_url('/dashboard/get_ajax_cifchecker') ?>/'+cif;
		$('#cifchecker_ajax').html("<div class='items_dashboard' style='border:none;' align='center'><img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span></div>");
		$('#cifchecker_ajax').load(urls);
		
	});
	
	var level = '<?php echo strtoupper($_SESSION['USER_LEVEL'])?>';
	switch(level){
		case 'SALES':
			$('#todo_birthday').show();
			$('#target_realisasi').show();
			$('#delta_individu').show();
			$('#delta_corporate').show();
			break;
		case 'SUPERVISOR':
			$('#todo_birthday').hide();
			$('#target_realisasi').hide();
			$('#delta_individu').show();
			$('#delta_corporate').show();
			break;
		default:
			$('#todo_birthday').hide();
			$('#target_realisasi').hide();
			$('#delta_individu').show();
			$('#delta_corporate').show();
		}
});
*/		

$(function(){
	
	$("#box_target").load("<?php echo site_url('/dashboard/get_target/0/0') ?>", function() {
	$("#box_realisasi").load("<?php echo site_url('/dashboard/get_realisasi/0/0') ?>", function(){
		
	$("#box_top_indv").load("<?php echo site_url('/dashboard/get_cust_ind/DESC') ?>", function() { 
	$("#box_lose_indv").load("<?php echo site_url('/dashboard/get_cust_ind/ASC') ?>", function() {

	$("#box_bday").load("<?php echo site_url('/dashboard/get_bday') ?>"); }); }); }); }); //}); });
	
	$( "#accordion" ).accordion({ active:0 });
});
</script>	

<!----===============================---->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">SALES DATA</h4>
      </div>
      <div class="modal-body">
	  
        <p id="list_modal" >Some text in the modal.</p>

		<script type="text/javascript">
/**/		
		$(document).ready(function(){
//+++++AJAXXX
			
		var cif = $('#cif').val();

		var urls = '<?php echo site_url('/dashboard/get_cifchecker_new') ?>/'+123456;

		$("#list_modal").load(urls);
//		$("#list_modal").load("<?php echo site_url('/dashboard/get_cifchecker_new/123456') ?>");
		
		});
		
		</script>

		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal END-->
<!------------------------------------------------------------->
<?php $this->load->view('template/js') ?>	
<?php $this->load->view('template/footer') ?>	
