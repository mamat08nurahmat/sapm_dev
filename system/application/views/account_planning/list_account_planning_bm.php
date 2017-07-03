
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
			
			//kirim usulan ke supervisor
			$('#kirim_usulan_bm').live('click', function() {
				var id = <?php echo $_SESSION['ID'] ?>;
					<?php 
						$tanggal=date('Y-m-d');
						$day=date('d');
						#$w=date("W",$tanggal);
						switch($day){
							case ($day>= 1 and $day<=7):
								$week = 1;
								break;
							case ($day>= 8 and $day<=14):
								$week = 2;
								break;
							case ($day>= 15 and $day<=21):
								$week = 3;
								break;
							case ($day>= 22):
								$week = 4;
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
					var week = <?php echo $week?>;
					var year = <?php echo date('Y')?>;
				//var jml_segmentasi = $('#tbl_naskel tr.nas_kel').size();
				//var is_emerald = '<?php echo in_array($_SESSION['SALES_ID'], array(1,2,21,22,33,34)) ?>';
				//var is_pba = '<?php echo in_array($_SESSION['SALES_ID'], array(3,11,23,24,35,36)) ?>';
				//if(is_pba && jml_segmentasi < 100 && jml_segmentasi > 150 || is_emerald && jml_segmentasi < 50 && jml_segmentasi > 75)
					//alert('Jumlah Nasabah Belum Sesuai Segmentasi (PBA 100-150 Nasabah/Emerald 50-75 Nasabah');
				//else
					{
						if(confirm('Anda akan mengirimkan usulan ini ke Supervisor untuk direview, klik tombol OK untuk melanjutkan atau Cancel untuk kembali'))
						{
						$.post('<?php echo site_url('account_planning/kirim_usulan_bm/') ?>/'+ id +'/'+ week + '/' + month + '/' + year,{},
						 function(data){
							if(data == 1)
								{
									getDataNasabahUsulan();
								}
							}
						);
					}
					}
			});
			
			//cek total
			$('#cek_total').live('click', function() {
				getDataNasabahUsulan();
			 });
			
			//remove nasabah usulan
			$(".remove").live('click', function() {
				var cif = $(this).attr('id');
				$.post('<?php echo site_url('/account_planning/remove') ?>',{cif:cif}
				,function(data){
					if(data == 1)
						{
							$('#search_list').flexReload();
							getDataNasabahUsulan();
						}
				});
			});


			// Dialog Alasan Reject
			$("#dialog-form").dialog({
				close: function(event, ui) {
					$('#dialog-form #rcif,#dialog-form #alasan').val('');
				},
				autoOpen: false,
				height: 180,
				width: 350,
				modal: true,
				buttons: {
					Submit: function() {
						var that = $(this);
						$.post('<?php echo site_url('/usulan_nasabah/reject') ?>',
										$("#dialog-form form").serialize(),
										function(data) {
											if (data == 1)
											{
												getDataNasabahUsulan();
												that.dialog("close");
											}
											else
												alert('Terdapat error pada system');
										}
						);

					},
					Cancel: function() {
						$(this).dialog("close");
					}
				}
			});

			$(".reject").live('click', function() {
				$("#dialog-form").dialog("open");
				$('#dialog-form #rcif').val($(this).attr('id'));
			});


			//------------------------------------------------
			//	Tambah Nasabah Usulan
			//------------------------------------------------
<?php
if (!isset($data))
{

	?>
				$('#add_ap_bm').live('click', function() {
					window.location ="<?php echo site_url('/activity/add_account_planning_bm') ?>";
				});
<?php } ?>

			//------------------------------
			//	Search jQuery Dialog Box
			//------------------------------
			$("#search").dialog({
				width: 980,
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
				if ($('.trSelected', grid).length > 0) {
					// to provide value in ie 6 suck
					var arrData = getSelectedRow();
					var arrCIF = new Array();
					for (var i = 0; i < arrData.length; i++)
					{
						arrCIF.push(arrData[i][0]);
					}
					$('.trSelected', grid).remove();
					$('#search').dialog('close');

					var id = <?php echo $_SESSION['ID'] ?>;
					var urls = '<?php echo site_url('/usulan_nasabah/get_list/') ?>/' + id;
					$("#report_msg").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
					$("#report_msg").load(urls, {arrCIF: arrCIF});
				} else {
					alert('Pilih minimal 1 data!');
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

		function getDataNasabahUsulan()
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
			var urls = '<?php echo site_url('/account_planning/get_ap_bm/') ?>/' + id +'/'+week+'/'+month+'/'+year;
			$("#report_msg").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
			$("#report_msg").load(urls);
		}

			$(document).ready(function() {
				getDataNasabahUsulan();
			});

	</script>


	<div id='content_x'>
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Usulan Pipeline</a></li>
			</ul>
			<div id="tabs-1">
				<br />
				<!--<button id="create-user">Create new user</button>-->
				<div id='report_msg'></div>
			</div>
		</div>

    <div id="search" title="SALES DATA">
<?php echo $js_grid; ?><table id="search_list" style="display:none"></table>
    </div>

		<div id="dialog-form" title="ALASAN REJECT">
			<form>
				<fieldset>
					<textarea rows="5" cols="45" id="alasan" name="alasan"></textarea>
					<input type="hidden" name="rcif" id="rcif"/>
				</fieldset>
			</form>
		</div>

	</div><!-- close div content -->
</td>
</tr>
</table>

<script type="text/javascript">
<?php
$level = $_SESSION['USER_LEVEL'];
$i = 7;
$html = "\$(function(){\$( '#accordion' ).accordion({ active:$i});});";
echo $html;

?>
</script>
<?php $this->load->view('default/footer') ?>