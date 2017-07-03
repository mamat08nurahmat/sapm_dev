
<?php $this->load->view('default/header') ?>	
<td  valign="top" align="left">

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
				<?php 
				$day=date('d');
				if($day >= 1 and $day <=6)
				{
				?>
				var month = <?php echo date('m') ?>;
				<?php
				}else{
				?>
				var month = <?php echo date('m') ?> + 1;
				<?php
				}
				?>
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
			
			$('#btn_approve').live('click',function(){
			<?php 
						$day=date('d');
						if($day >= 1 and $day <=6)
						{
					?>
					var month = <?php echo date('m') ?>;
					<?php
						}else{
					?>
					var month = <?php echo date('m') ?> + 1;
					<?php
					}
					?>
				var year = <?php echo date('Y')?>;
				var npp = $('#ID').val();
				var mode = $(this).attr('rev');
				if(confirm('Dengan mengklik tombol Approve, Anda menyatakan bahwa usulan Account Planning sales ini telah mendapat approval dari pimpinan unit dan disetujui dan menjadi dasar list staging pipeline.Silahkan klik tombol OK untuk melanjutkan atau Cancel untuk kembali'))
				{
				$.post('<?php echo site_url('/account_planning/approve') ?>',{npp:npp,mode:mode,month:month,year:year},
					function(data){
						if(data == 1)
						{
//							getDataNasabahUsulan(npp);
							$('#ID,#USER_NAME').val('');
							$('#search_list').flexReload();
							$('#report_msg').html('Approval Sukses. Silahkan pilih sales untuk mengenerate list kelolaan');
						}
				});
				}
			});	
			
			$('#btn_reject').live('click',function(){
				<?php 
						$day=date('d');
						if($day >= 1 and $day <=6)
						{
					?>
					var month = <?php echo date('m') ?>;
					<?php
						}else{
					?>
					var month = <?php echo date('m') ?> + 1;
					<?php
					}
					?>
				var year = <?php echo date('Y')?>;
				var npp = $('#ID').val();
				var mode = $(this).attr('rev');
				if(confirm('Anda akan mengembalikan list usulan Account Planning ke sales, klik tombol OK untuk melanjutkan atau Cancel untuk kembali'))
				{
				$.post('<?php echo site_url('/account_planning/approve1') ?>',{npp:npp,mode:mode,month:month,year:year},
					function(data){
						if(data == 1)
						{
//							getDataNasabahUsulan(npp);
							$('#ID,#USER_NAME').val('');
							$('#search_list').flexReload();
							$('#report_msg').html('Tolak Sukses. Silahkan pilih sales untuk mengenerate list kelolaan');
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
					$('#search').dialog('open');
					//$('select').hide();
				});
				$('#USER_NAME').click(function() {
					$('#search').dialog('open');
					//$('select').hide();
				});
				
<?php } ?>

			//------------------------------
			//	Search jQuery Dialog Box
			//------------------------------
			$("#search").dialog({
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
			$("#search").dialog({
				close: function(event, ui) {
					$('select').show();
				}
			});
			
		});


		//-------------------------------------
		//	Choose SALES ID from dialog box and get the data with ajax
		//-------------------------------------
		function pilih_data(com, grid)
		{
			if (com == 'Pilih')
			{
				if ($('.trSelected', grid).length > 0 && $('.trSelected', grid).length < 2) {
					// to provide value in ie 6 suck
					var arrData = getSelectedRow();
					var nama = arrData[0][1].toUpperCase();
					$('#ID').val(arrData[0][0]);
					$('#USER_NAME').val(nama);
					$('#search').dialog('close');
					
					var id = $('#ID').val();
					<?php 
						$day=date('d');
						if($day >= 1 and $day <=6)
						{
					?>
					var month = <?php echo date('m') ?>;
					<?php
						}else{
					?>
					var month = <?php echo date('m') ?> + 1;
					<?php
					}
					?>
					var year = <?php echo date('Y')?>;
					var urls = '<?php echo site_url('/account_planning/get_ap/') ?>/' + id +'/'+month+'/'+year;
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
						$day=date('d');
						if($day >= 1 and $day <=6)
						{
					?>
					var month = <?php echo date('m') ?>;
					<?php
						}else{
					?>
					var month = <?php echo date('m') ?> + 1;
					<?php
					}
					?>
					var year = <?php echo date('Y')?>;
			var urls = '<?php echo site_url('/account_planning/get_ap/') ?>/' + id +'/'+month+'/'+year;
			$("#report_msg").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
			$("#report_msg").load(urls);
		}

<?php if($_SESSION['USER_LEVEL'] == 'SALES'): ?>
	$( document ).ready(function() {
			var id = <?php echo $_SESSION['ID'] ?>;
			<?php 
						$day=date('d');
						if($day >= 1 and $day <=6)
						{
					?>
					var month = <?php echo date('m') ?>;
					<?php
						}else{
					?>
					var month = <?php echo date('m') ?> + 1;
					<?php
					}
					?>
					var year = <?php echo date('Y')?>;
			var urls = '<?php echo site_url('/account_planning/get_ap/') ?>/' + id +'/'+month+'/'+year;
			$("#report_msg").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
			$("#report_msg").load(urls);
	});
<?php endif; ?>


	</script>


	<div id='content_x'>
		<div id="tabs"> 
			<ul>
				<li><a href="#tabs-1">List Account Plan Sales</a></li>
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
				<div id='report_msg'>Silahkan pilih sales untuk mengenerate list kelolaan</div>
			</div>
		

    <div id="search" title="SALES DATA">
<?php echo $js_grid; ?><table id="search_list_user" style="display:none"></table>
    
			</div>
			
		</div>

    
	

	</div><!-- close div content -->

</td>
</tr>
</table>
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