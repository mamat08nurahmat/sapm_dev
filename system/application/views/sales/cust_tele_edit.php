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
?>

<td  valign="top" align="left">

<div id='content_x'>
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> LEADS 500046
    </div>
	<div id="tabs">
        <ul>
            <li><a href="#tabs-1">Leads 500046</a></li>
        </ul>
        <div id="tabs-1">
        <form action="<?php echo site_url('/sales/save_cust_tele/') ?>" method="post" enctype="application/x-www-form-urlencoded" name="frmCustInd" id="frmCustInd">
            <input type="hidden" name="ID" id="ID" value="">
            <table width="100%" border="0" cellspacing="0" class="frmtable">
				<tr>
                	<td width="200" align="left">Tanggal Data <span style="color:#F00">*</span></td>
                    <td width="5">:</td>
                  	<td align="left"><input name="SAPM_DATE" type="text" id="SAPM_DATE" value="" size="30" width="30" readonly></td>
				</tr>
				
				<tr>
                	<td width="200" align="left">Nama Customer <span style="color:#F00">*</span></td>
                    <td width="5">:</td>
                  	<td align="left"><input name="NAMA" type="text" id="NAMA" value="" size="30" width="30" readonly></td>
				</tr>
				<tr>
                    <td width="200" align="left">Tgl Lahir</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="DOB" id="DOB" type="text" size="30" width="30" readonly></td>
                </tr>           
                <tr>
                	<td width="200" align="left">Telepon Rumah</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="TLP_RUMAH" type="text" id="TLP_RUMAH" value="" size="30" width="30" readonly></td>
                </tr>
				<tr>
                    <td width="200" align="left">Nomor Handphone</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="HP" id="HP" type="text" size="30" width="30" readonly></td>
                </tr>
                <tr>
                    <td width="200" align="left">Email</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="EMAIL" id="EMAIL" type="text" size="30" width="30" readonly></td>
                </tr>
				 <tr>
                    <td width="200" align="left" valign="top">Alamat Rumah </td>
					<td width="5" valign="top">:</td>
                  	<td align="left" valign="top"><textarea name="ALAMAT_KONFIRMASI" cols="30" rows="4" id="ALAMAT_KONFIRMASI" width="30" readonly></textarea></td>
                </tr>
                <tr>
                	<td width="200" align="left">Kota</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="KOTA" type="text" id="KOTA" value="" size="30" width="30" readonly></td>
                </tr>
				 <tr>
                	<td width="200" align="left">Jenis Produk</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="JENIS_PRODUK" type="text" id="JENIS_PRODUK" value="" size="30" width="30" readonly></td>
                </tr>
				<tr>
					<td width="200" align="left">Sales ID</td>
                    <td width="5">:</td>
                   	<td align="left">
                    <select name="SALES_ID" id="SALES_ID">
                    	<option value="">-- Pilih Sales ID --</option>
                    	<?php 
						if(isset($sales_id)){
							foreach($sales_id as $row)
							{
								if( stristr($row->ID, 'jumlah') === false)
								{
									echo "<option value ='".$row->ID."'>".$row->ID." - ".$row->USER_NAME." - ".$row->SALES_TYPE."</option>\n";
								}
							}
						}
						?>
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