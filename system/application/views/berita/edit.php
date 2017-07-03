<?php $this->load->view('default/header') ?>	

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
		$("#COST_OF_LIVING").numeric();
	});
	
	$(function() {
		
		$("#DATE_OF_BIRTH").datepicker({
			defaultDate:'+1m-50y',
			maxDate: '+1m -5y',
			showOn: 'button',
			buttonImage: '<?php echo ICONS ?>calendar.gif',
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#DATE_OF_BIRTH').datepicker('option', {dateFormat: 'd-M-y'});
		$('#DATE_OF_BIRTH').datepicker('option', $.datepicker.regional['id']);
	});
</script>

<?php 
	function sales_id(){
		if(isset($sales_id)){
			$html = '';
			foreach($sales_id as $row)
			{
				$html .= "<option value ='".$row->ID."'>".$row->USERNAME."</option>\n";
			}
			return $html;
		}
	}

	
	$ceka=$data[0]->IS_ACTIVE;
	
	if($ceka==1)
	{
	  $dis="enable";
	}else
	{
		$dis="disabled";
	}
?>
<td  valign="top" align="left">

<div id='content_x'>
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> EDIT BERITA
    </div>
	<div id="tabs">
        <ul>
            <li><a href="#tabs-1">Edit Berita</a></li>
        </ul>
        <div id="tabs-1">
        <form action="<?php echo site_url('/berita/save_berita/') ?>" method="post" enctype="application/x-www-form-urlencoded" name="frmCustInd" id="frmCustInd">
            <input type="hidden" name="ID" id="ID" value="">
            <table width="100%" border="0" cellspacing="0" class="frmtable">
				<tr>
                	<td width="200" align="left">Tanggal Berita <span style="color:#F00">*</span></td>
                    <td width="5">:</td>
                  	<td align="left"><input name="TANGGAL" type="text" id="TANGGAL" value="" size="30" width="30" readonly></td>
				</tr>
				
				<tr>
                	<td width="200" align="left">Judul Berita <span style="color:#F00">*</span></td>
                    <td width="5">:</td>
                  	<td align="left"><input name="JUDUL" type="text" id="JUDUL" value="" size="60" width="30" <?php echo $dis;?>></td>
				</tr>
				 <tr>
                    <td width="200" align="left" valign="top">Isi Berita </td>
					<td width="5" valign="top">:</td>
                  	<td align="left" valign="top"><textarea name="ISI" cols="30" rows="4" id="ISI" width="30" <?php echo $dis;?>></textarea></td>
                </tr>
                <tr>
                	<td width="200" align="left">Active</td>
                    <td width="5">:</td>
                  	<td align="left">
					<select name="IS_ACTIVE">
					<?php if ($ceka==1){?>
					<option value="1">Aktif</option>
					<option value="0">Non Aktif</option>
					<?php }else{?>
					<option value="0">Non Aktif</option>
					<option value="1">Aktif</option>
					<?php } ?>
					</select>
					</td>
                </tr>
                <tr>
                	<td align="left" colspan="7"><hr></td>
                </tr>
                <tr>
                	<td align="left" colspan="7"><input name="simpan" id="simpan" type="button" value="Simpan" class="reset"> <input name="batal" type="button" value="Kembali"  onclick="history.back()"  class="reset"></td>
                </tr>
            </table>
            </form>
		</div>
    </div>
</div>
</tr>
</table>
<script type="text/javascript">
	$(function(){
		
		<?php
			if(isset($data)){ 
				foreach($data[0] as $row=>$val){
					echo "$('#".$row."').val('".$val."');";
				}
			}
		?>
		
		$('#simpan').click(function(){
		
			$("#frmCustInd").submit();
			});
		
			
			function checkMail(email){
				var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if (filter.test(email)) {
					return true;
				}
				return false;
			}
			
			function checkNumber(number){
				var filter  = /^([0-9])+$/;
				if (filter.test(number)) {
					return true;
				}
				return false;
			}
			
			function valid(frm, nama){
				var msg = '';
				if($(frm).val() == '' || $(frm).val() == '0')
				msg = nama + ' Tidak boleh kosong ! \n';
				msg = msg.replace('#','');
				return msg;
			}
	})	
$(function(){
	$( "#accordion" ).accordion({ active:3 });
});
</script>	

<?php $this->load->view('default/footer') ?>