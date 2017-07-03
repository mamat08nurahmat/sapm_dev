
<?php $this->load->view('default/header') ?>	
<!---=====================================--->
    <!-- Main content -->
   	<section class="content2">
        <!-- START CUSTOM TABS -->

<!-- main lama 
<td  valign="top" align="left">
 -->
<!---=====================================--->

	<script type="text/javascript">
		$(function() {

			//-------------------------------------
			//	Set active tabbed window
			//-------------------------------------		
			$(function() {
				$("#tabs").tabs();
			});
			
			$('#export').live('click',function(){
				$('#report_msg').html("<img src='<?php echo LOAD ?>' alt='loading'> <span style='color:#080'>exporting report ...</span>");
				getReport(1);
			});
			
			$('#export1').live('click',function(){
				$('#report_msg1').html("<img src='<?php echo LOAD ?>' alt='loading'> <span style='color:#080'>exporting report ...</span>");
				getReport(2);
			});
			
			function getReport(ex) {
				var id = $('#ID').val();
				var msg = '';
				if ($('#ID').val() == '') {
					msg += 'NPP tidak boleh kosong \n';
				}
				if (msg) {
					alert(msg);
					return false;
				}
				if(ex==1)
				{
				var id = <?php echo $_SESSION['ID'] ?>;
					<?php 
						$tanggal=date('Y-m-d');
						$day=date('d');
						#$w=date("W",$tanggal);
						switch($day){
							case ($day >= 1 and $day<=7):
								$w = 1;
								break;
							case ($day >= 8 and $day<=14):
								$w = 2;
								break;
							case ($day >= 15 and $day<=21):
								$w = 3;
								break;
							case ($day >= 22):
								$w = 4;
								break;
							}
						if($day >= 25 and $w==1)
					{
					?>
					var month = <?php echo date('m') ?> + 1;
					<?php
					}else{
					?>
					var month = <?php echo date('m') ?>;
					<?php
					}
					?>
					var week = <?php echo $w?>;
					var year = <?php echo date('Y')?>;
				var urls = '<?php echo site_url('/account_planning/xls_report1/') ?>/' + id + '/' + month+ '/' + year;
				window.location = urls;
				}
				else if(ex==2)
				{
				var urls = '<?php echo site_url('/usulan_nasabah/xls_report_remove/') ?>/' + id;
				window.location = urls;
				}
				
			}
			
			$('#btn_approve_bm').live('click',function(){
					<?php 
						$tanggal=date('Y-m-d');
						$day=date('d');
						#$w=date("W",$tanggal);
						switch($day){
							case ($day >= 1 and $day<=7):
								$w = 1;
								break;
							case ($day >= 8 and $day<=14):
								$w = 2;
								break;
							case ($day >= 15 and $day<=21):
								$w = 3;
								break;
							case ($day >= 22):
								$w = 4;
								break;
							}
						if($day >= 25 and $w==1)
					{
					?>
					var month = <?php echo date('m') ?> + 1;
					<?php
					}else{
					?>
					var month = <?php echo date('m') ?>;
					<?php
					}
					?>
					var week = <?php echo $w?>;
					var year = <?php echo date('Y')?>;
				var npp = $('#ID').val();
				var mode = $(this).attr('rev');
				if(confirm('Dengan mengklik tombol Approve, Anda menyatakan bahwa usulan Account Planning Pemimpin ini telah mendapat approval dari pimpinan unit dan disetujui dan menjadi dasar list pipeline.Silahkan klik tombol OK untuk melanjutkan atau Cancel untuk kembali'))
				{
				$.post('<?php echo site_url('/account_planning/approve_bm') ?>',{npp:npp,mode:mode,week:week,month:month,year:year},
					function(data){
						if(data == 1)
						{
//							getDataNasabahUsulan(npp);
							$('#ID,#USER_NAME').val('');
							$('#search_list').flexReload();
							$('#report_msg').html('Approval Sukses. Silahkan pilih Pemimpin untuk mengenerate list kelolaan');
						}
				});
				}
			});	
			
			$('#btn_reject_bm').live('click',function(){
				<?php 
						$tanggal=date('Y-m-d');
						$day=date('d');
						#$w=date("W",$tanggal);
						switch($day){
							case ($day >= 1 and $day<=7):
								$w = 1;
								break;
							case ($day >= 8 and $day<=14):
								$w = 2;
								break;
							case ($day >= 15 and $day<=21):
								$w = 3;
								break;
							case ($day >= 22):
								$w = 4;
								break;
							}
						if($day >= 25 and $w==1)
					{
					?>
					var month = <?php echo date('m') ?> + 1;
					<?php
					}else{
					?>
					var month = <?php echo date('m') ?>;
					<?php
					}
					?>
					var week = <?php echo $w?>;
					var year = <?php echo date('Y')?>;
				var npp = $('#ID').val();
				var mode = $(this).attr('rev');
				if(confirm('Anda akan mengembalikan list usulan Account Planning ke Pemimpin, klik tombol OK untuk melanjutkan atau Cancel untuk kembali'))
				{
				$.post('<?php echo site_url('/account_planning/reject') ?>',{npp:npp,mode:mode,week:week,month:month,year:year},
					function(data){
						if(data == 1)
						{
//							getDataNasabahUsulan(npp);
							$('#ID,#USER_NAME').val('');
							$('#search_list').flexReload();
							$('#report_msg').html('Tolak Sukses. Silahkan pilih Pemimpin untuk mengenerate list kelolaan');
						}
				});
				}
			});	

			//------------------------------------------------
			//	Choose SALES ID from dialog box if clicked
			//------------------------------------------------
<?php if (!isset($data))
{

	?>
				$('#ID').click(function() {
					$('#search_bm').dialog('open');
					//$('select').hide();
				});
				$('#USER_NAME').click(function() {
					$('#search_bm').dialog('open');
					//$('select').hide();
				});
				
<?php } ?>

			//------------------------------
			//	Search jQuery Dialog Box
			//------------------------------
			$("#search_bm").dialog({
				width: 500,
				height: 550,
				modal: true,
				autoOpen: false,
				buttons: {'Close': function() {
						$(this).dialog('close');
						$('select').show();
					}}
			});
			

			//------------------------------------
			//	Show all select if dialog close
			//------------------------------------
			$("#search_bm").dialog({
				close: function(event, ui) {
					$('select').show();
				}
			});
			
		});


		//-------------------------------------
		//	Choose SALES ID from dialog box and get the data with ajax
		//-------------------------------------
		function pilih_data_bm(com, grid)
		{
			if (com == 'Pilih')
			{
				if ($('.trSelected', grid).length > 0 && $('.trSelected', grid).length < 2) {
					// to provide value in ie 6 suck
					var arrData = getSelectedRow();
					var nama = arrData[0][1].toUpperCase();
					$('#ID').val(arrData[0][0]);
					$('#USER_NAME').val(nama);
					$('#search_bm').dialog('close');
					
					var id = $('#ID').val();
					<?php 
						$tanggal=date('Y-m-d');
						$day=date('d');
						#$w=date("W",$tanggal);
						switch($day){
							case ($day >= 1 and $day<=7):
								$w = 1;
								break;
							case ($day >= 8 and $day<=14):
								$w = 2;
								break;
							case ($day >= 15 and $day<=21):
								$w = 3;
								break;
							case ($day >= 22):
								$w = 4;
								break;
							}
						if($day >= 25 and $w==1)
					{
					?>
					var month = <?php echo date('m') ?> + 1;
					<?php
					}else{
					?>
					var month = <?php echo date('m') ?>;
					<?php
					}
					?>
					var week = <?php echo $w?>;
					var year = <?php echo date('Y')?>;
					var urls = '<?php echo site_url('/account_planning/get_ap_bm/') ?>/' + id +'/'+week+'/'+month+'/'+year;
					$("#report_msg").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
					$("#report_msg").load(urls);
				
				} else {
					alert('Pilih satu data saja !');
				}
			}
			
		}

		function getSelectedRow() {
			var arrReturn = [];
			$('.trSelected').each(function() {
				var arrRow = [];
				$(this).find('div').each(function() {
					arrRow.push($(this).html());
				});
				arrReturn.push(arrRow);
			});
			return arrReturn;
		}
		
		function getDataNasabahUsulan(sales_npp)
		{
			var id = sales_npp
			<?php 
						$tanggal=date('Y-m-d');
						$day=date('d');
						$w=date("W",$tanggal);
						if($day >= 25 and $w==1)
					{
					?>
					var month = <?php echo date('m') ?> + 1;
					<?php
					}else{
					?>
					var month = <?php echo date('m') ?>;
					<?php
					}
					?>
					var week = <?php echo $w?>;
					var year = <?php echo date('Y')?>;
			var urls = '<?php echo site_url('/account_planning/get_ap_bm/') ?>/' + id +'/'+month+'/'+year;
			$("#report_msg").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
			$("#report_msg").load(urls);
		}

<?php if($_SESSION['USER_LEVEL'] == 'SALES'): ?>
	$( document ).ready(function() {
			var id = <?php echo $_SESSION['ID'] ?>;
			<?php 
						$tanggal=date('Y-m-d');
						$day=date('d');
						$w=date("W",$tanggal);
						if($day >= 25 and $w==1)
					{
					?>
					var month = <?php echo date('m') ?> + 1;
					<?php
					}else{
					?>
					var month = <?php echo date('m') ?>;
					<?php
					}
					?>
					var week = <?php echo $w?>;
					var year = <?php echo date('Y')?>;
			var urls = '<?php echo site_url('/account_planning/get_ap_bm/') ?>/' + id +'/'+month+'/'+year;
			$("#report_msg").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
			$("#report_msg").load(urls);
	});
<?php endif; ?>


	</script>

<!---=====================================--->
        <h2 class="page-header">Program SGP</h2>

        <div class="row">
          <div class="col-xs-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active">
				<?php $jenis = array(0=>'', 1=>'SUDAH REALISASI', '2'=>'BELUM REALISASI') ?>
				<a href="#tab_1" data-toggle="tab">STAGING PIPELINE <?php echo $jenis[$type]; ?></a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 -->
                <div class="tab-pane active" id="tab_1">
		
                    <form style="margin:10px" action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
                        <table class="table-responsive table-condensed" width="" cellspacing="5" cellpadding="5" border="0">

              <?php 
			  		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
					if($lvl <> 'SALES') {
			  ?>						
                        <tbody>
                        <tr>
                            <td align="left">NPP </td>
                	        <td colspan="4">&nbsp;
								<input name="ID" id="ID" type="text" size="20" readonly="readonly" class="input">
                            </td>
                        </tr>
						<tr>
						<td align="left">NAMA : </td>
						<td colspan="4">&nbsp;
						<input name="USER_NAME" id="USER_NAME" type="text" size="20" readonly="readonly" class="input">
						</td>
						</tr>
						<tr>
						<td align="left">SALES TYPE : </td>
						<td colspan="4">&nbsp;
						<input name="SALES_TYPE" id="SALES_TYPE" type="text" size="20" readonly="readonly" class="input">
						</td>
						</tr>
				  <?php } ?>
					  <tr>
						<td align="left">STAGING: </td>
						<td colspan="4">&nbsp;
							<select name="STAGING" id="STAGING">
							<option value=1>LEADS</option>
							<option value=2>CALLS</option>
							<option value=3>OPPORTUNITY </option>
							<option value=4>APPOINTMENT</option>
							<option value=5>APPLICATION</option>
							<option value=6>APPROVAL</option>
							<option value=7>ACCEPTANCE</option>
							<option value=8>DRAWDOWN</option>
							</select>
						</td>
					  </tr>
              
              <tr>
              	<td align="left">PERIODE : </td>
                <td>&nbsp; <input name="START" id="START" type="text" size="20" readonly="readonly" class="input"></td>
                <td>to <input name="END" id="END" type="text" size="20" readonly="readonly" class="input"></td>
                <!--<td><input name="submit" id="submit" type="button" value="Generate"></td>-->
 
                <td><input name="export" id="export" type="button" value="Export to XLS"></td>
              </tr>

                        </tbody>
						</table>
                    </form>
					<br><br>

					
<!---
					</table>
					</div><br/> 
--->					
					<div id="report" class="text-center">Silahkan isi range periode report</div>	
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
              <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
          </div>
          <!-- /.col -->

    <div id="search" title="SALES DATA">
		<?php// echo $js_grid; ?><table id="search_list" style="display:none"></table>
    </div>		  

        </div>
         <!-- / end class .row -->
<!---=====================================--->		

<!----
	<div id='content_x'>
		<div id="tabs"> 
			<ul>
				<li><a href="#tabs-1">List Account Plan Pemimpin</a></li>
			</ul>
			
			<div id="tabs-1">
			<?php if($_SESSION['USER_LEVEL'] != 'SALES'): ?>
				<form action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
					<table width="" border="0" cellspacing="5" cellpadding="0">
						<tr>
							<td align="left">NPP</td>
							<td>:</td>
							<td colspan="4">
								<input name="ID" id="ID" type="text" size="20" readonly="readonly" class="input">
							</td>
						</tr>

						<tr>
							<td align="left">NAMA</td>
							<td>:</td>
							<td colspan="4">
								<input name="USER_NAME" id="USER_NAME" type="text" size="20" readonly="readonly" class="input">
							</td>
						</tr>
						
					</table>
				</form> 
				<?php endif; ?>
				
				<br />
				<div id='report_msg'>Silahkan pilih Pemimpin untuk mengenerate list kelolaan</div>
			</div>
		

    <div id="search_bm" title="PEMIMPIN DATA">
<?php echo $js_grid_bm; ?><table id="search_list_user_bm" style="display:none"></table>
    
			</div>
			
		</div>

    
	

	</div><!-- close div content -->
<!--
</td>
</tr>
</table>
---->	
	
<!----===============================---->
</section>
<!----===============================---->
	
	
<?php //print_r($_SESSION) ?>
<script type="text/javascript">
<?php

$level = $_SESSION['USER_LEVEL'];
$i = 7;
$html = "\$(function(){\$( '#accordion' ).accordion({ active:$i});});";
echo $html;

?>
</script>
<?php $this->load->view('default/footer') ?>