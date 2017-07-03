<?php $this->load->view('default/header') ?>	

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
	
	$(function() {
		$("#TGL_LAHIR_PASANGAN").datepicker({
			showOn: 'button',
			buttonImage: '<?php echo ICONS ?>calendar.gif',
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#TGL_LAHIR_PASANGAN').datepicker('option', {dateFormat: 'mmddyy'});
		$('#TGL_LAHIR_PASANGAN').datepicker('option', $.datepicker.regional['id']);
		
		$("#USIA_ANAK_1").datepicker({
			showOn: 'button',
			buttonImage: '<?php echo ICONS ?>calendar.gif',
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#USIA_ANAK_1').datepicker('option', {dateFormat: 'd-M-yy'});
		$('#USIA_ANAK_1').datepicker('option', $.datepicker.regional['id']);
		
		$("#USIA_ANAK_2").datepicker({
			showOn: 'button',
			buttonImage: '<?php echo ICONS ?>calendar.gif',
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#USIA_ANAK_2').datepicker('option', {dateFormat: 'd-M-yy'});
		$('#USIA_ANAK_2').datepicker('option', $.datepicker.regional['id']);
		
		$("#USIA_ANAK_3").datepicker({
			showOn: 'button',
			buttonImage: '<?php echo ICONS ?>calendar.gif',
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#USIA_ANAK_3').datepicker('option', {dateFormat: 'd-M-yy'});
		$('#USIA_ANAK_3').datepicker('option', $.datepicker.regional['id']);
		
		
	});
	
</script>

<?php 
	function bni_product(){
		if(isset($bni_product)){
			$html = '';
			foreach($bni_product as $row)
			{
				$html .= "<option value ='".$row->ID."'>".$row->PRODUCT_NAME."</option>\n";
			}
			return $html;
		}
	}
?>

<td  valign="top" align="left">

<div id='content_x'>
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> LEADS MANAGEMENT
    </div>
	<div id="tabs">
        <ul>
            <li><a href="#tabs-1">Leads Kelolaan</a></li>
        </ul>
        <div id="tabs-1">
        <form action="<?php echo site_url('/sales/save_cust_ind/') ?>" method="post" enctype="application/x-www-form-urlencoded" name="frmCustInd" id="frmCustInd">
            <table width="100%" border="0" cellspacing="0" class="frmtable">
							<tr>
                	<td width="200" align="left">CIF</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="readonly[CIF]" type="text" id="CIF" value="" size="30" width="30" readonly></td>
                    <td width="30"></td>
                    <td width="200" align="left">CIF Anak 1</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="CIF_ANAK_1" type="text" id="CIF_ANAK_1" value="" size="30" width="30" readonly></td>
                </tr>
 				<tr>
                	<td width="200" align="left">Nama Nasabah </td>
                    <td width="5">:</td>
                  	<td align="left"><input name="readonly[CUST_NAME]" type="text" id="CUST_NAME" value="" size="30" width="30" readonly></td>
                    <td width="30"></td>
                    <td width="200" align="left">Tgl Lahir Anak 1</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="USIA_ANAK_1" type="text" id="USIA_ANAK_1" value="" width="30" style="width:100px;"  readonly="readonly" /></td>
                </tr>           
                <tr>
                	<td width="200" align="left">Relationship</td>
                    <td width="5">:</td>
                  	<td align="left">
											<select name="RELATION_ID" id="RELATION_ID">
                    	<option value="">-- Pilih Relationship --</option>
                    	<?php 
											if(isset($param_relationship))
											{
												foreach($param_relationship as $row)
													echo "<option value ='".$row->ID."'>".$row->RELATION_NAME."</option>\n";
											}
											?>
                    </select>
										</td>
                    <td width="30"></td>
                    <td width="200" align="left">Pekerjaan Anak 1</td>
                    <td width="5px">:</td>
                  	<td align="left">
                    <select name="PEKERJAAN_ANAK_ID_1" id="PEKERJAAN_ANAK_ID_1">
                    	<option value="">-- Pilih Pekerjaan --</option>
                    	<?php 
											if(isset($param_pekerjaan))
											{
												foreach($param_pekerjaan as $row)
													echo "<option value ='".$row->ID."'>".$row->NAMA_PEKERJAAN."</option>\n";
											}
											?>
                    </select>
                  </td>
                </tr>
                <tr>
                	<td width="200" align="left">Hobby</td>
                    <td width="5">:</td>
                  	<td align="left">
											<select name="HOBBY_ID" id="HOBBY_ID">
                    	<option value="">-- Pilih Hobby --</option>
                    	<?php 
											if(isset($param_hobby))
											{
												foreach($param_hobby as $row)
													echo "<option value ='".$row->ID."'>".$row->HOBBY."</option>\n";
											}
											?>
                    </select>
										</td>
                    <td width="30"></td>
                    <td width="200" align="left">Nama Anak 2</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="NAMA_ANAK_2" type="text" id="NAMA_ANAK_2" value="" width="30" style="width:100px;" /></td>
					
                </tr>
                <tr>
                	<td width="200" align="left">Jabatan</td>
                  <td width="5">:</td>
                  	<td align="left">
											<select name="JABATAN_ID" id="JABATAN_ID">
                    	<option value="">-- Pilih Jabatan --</option>
                    	<?php 
											if(isset($param_jabatan))
											{
												foreach($param_jabatan as $row)
													echo "<option value ='".$row->ID."'>".$row->NAMA_JABATAN."</option>\n";
											}
											?>
                    </select>
										</td>
                    <td width="30"></td>
					 <td width="200" align="left">CIF Anak 2</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="CIF_ANAK_2" type="text" id="CIF_ANAK_2" value="" width="30" style="width:100px;" /></td>
					
                </tr>
                <tr>
                	<td width="200" align="left">Info Sekretaris</td>
                  <td width="5">:</td>
                  	<td align="left"><input name="CONTACT_SEKRETARIS" id="CONTACT_SEKRETARIS" type="text" size="30" width="30"></td>
                    <td width="30"></td>
                    <td width="200" align="left">Tgl Lahir Anak 2</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="USIA_ANAK_2" type="text" id="USIA_ANAK_2" value="" width="30" style="width:100px;"  readonly="readonly" /></td>
					
					
                </tr>
                <tr>
                	<td width="200" align="left">Organisasi yang diikuti</td>
                  <td width="5">:</td>
                  	<td align="left">
                    <select name="ORGANISASI_ID" id="ORGANISASI_ID">
                    	<option value="">-- Pilih Organisasi --</option>
                    	<?php 
											if(isset($param_org))
											{
												foreach($param_org as $row)
													echo "<option value ='".$row->ID."'>".$row->NAMA_ORG."</option>\n";
											}
											?>
                    </select>
										</td>
                    <td width="30"></td>
                    <td width="200" align="left">Pekerjaan Anak 2</td>
                    <td width="5px">:</td>
                  	<td align="left">
                    <select name="PEKERJAAN_ANAK_ID_2" id="PEKERJAAN_ANAK_ID_2">
                    	<option value="">-- Pilih Pekerjaan --</option>
                    	<?php 
											if(isset($param_pekerjaan))
											{
												foreach($param_pekerjaan as $row)
													echo "<option value ='".$row->ID."'>".$row->NAMA_PEKERJAAN."</option>\n";
											}
											?>
                    </select>
                  </td>
					
					
                </tr>
                <tr>
                	<td width="200" align="left">Tempat Favorit</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="TEMPAT_FAVORIT" type="text" id="TEMPAT_FAVORIT" value="" size="30" width="30"></td>
                    <td width="30"></td>
                    <td width="200" align="left">Nama Anak 3</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="NAMA_ANAK_3" type="text" id="NAMA_ANAK_3" value="" width="30" style="width:100px;"  /></td>
					
                </tr>
                <tr>
                	<td width="200" align="left" valign="top">Biaya Hidup / Bulan</td>
                  <td width="5" valign="top">:</td>
                  	<td align="left" valign="top">
											<select name="BIAYA_HIDUP_ID" id="BIAYA_HIDUP_ID">
                    	<option value="">-- Pilih Biaya --</option>
                    	<?php 
											if(isset($param_biaya_hidup))
											{
												foreach($param_biaya_hidup as $row)
													echo "<option value ='".$row->ID."'>".$row->RANGE_BIAYA."</option>\n";
											}
											?>
                    </select>
										</td>
                  <td width="30"></td>
                   <td width="200" align="left">CIF Anak 3</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="CIF_ANAK_3" type="text" id="CIF_ANAK_3" value="" width="30" style="width:100px;"  /></td>
					
                </tr>
                <tr>
                	<td width="200" align="left">Produk DPK yang dimiliki di Bank Lain</td>
                  <td width="5">:</td>
                  <td align="left"><input name="DPK_BANK_LAIN" type="text" id="DPK_BANK_LAIN" value="" size="30" width="30" /></td>	
										</td>
               	  <td width="30"></td>
				 <td width="200" align="left">Tgl Lahir Anak 3</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="USIA_ANAK_3" type="text" id="USIA_ANAK_3" value="" width="30" style="width:100px;"  readonly="readonly" /></td>
					
                </tr>
                <tr>
                	<td width="200" align="left">Produk Kredit Konsumer yang dimiliki di Bank lain</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="KREDIT_BANK_LAIN" type="text" id="KREDIT_BANK_LAIN" value="" size="30" width="30" /></td>
                    <td width="30"></td>
					
                   <td width="200" align="left">Pekerjaan Anak 3</td>
                    <td width="5px">:</td>
                  	<td align="left">
                    <select name="PEKERJAAN_ANAK_ID_3" id="PEKERJAAN_ANAK_ID_3">
                    	<option value="">-- Pilih Pekerjaan --</option>
                    	<?php 
											if(isset($param_pekerjaan))
											{
												foreach($param_pekerjaan as $row)
													echo "<option value ='".$row->ID."'>".$row->NAMA_PEKERJAAN."</option>\n";
											}
											?>
                    </select>
                  </td>
                </tr>
				
				
				<tr>
                	<td width="200" align="left">Nama Pasangan</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="NAMA_PASANGAN" id="NAMA_PASANGAN" type="text" size="30" width="30"></td>
                    <td width="30"></td>
					<td width="200" align="left">Nama Ayah</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="NAMA_AYAH" id="NAMA_AYAH" type="text" size="30" width="30"></td>
                </tr>
				
				<tr>
                	<td width="200" align="left">CIF Pasangan</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="CIF_PASANGAN" id="CIF_PASANGAN" type="text" size="30" width="30"></td>
                    <td width="30"></td>
					<td width="200" align="left">CIF Ayah</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="CIF_AYAH" id="CIF_AYAH" type="text" size="30" width="30"></td>
                    <td width="30"></td>
                </tr>
				<tr>
                	 <td width="200" align="left">Tgl Lahir Pasangan</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="TGL_LAHIR_PASANGAN" type="text" id="TGL_LAHIR_PASANGAN" value="" width="30" style="width:100px;"  readonly="readonly" /></td>
                    <td width="30"></td>
                    <td width="200" align="left">Nama Ibu</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="NAMA_IBU" id="NAMA_IBU" type="text" size="30" width="30"></td>
                </tr>
				<tr>
                	<td width="200" align="left">Pekerjaan Pasangan</td>
                    <td width="5px">:</td>
                  	<td align="left">
											<select name="PEKERJAAN_PASANGAN_ID" id="PEKERJAAN_PASANGAN_ID">
                    	<option value="">-- Pilih Pekerjaan --</option>
                    	<?php 
											if(isset($param_pekerjaan))
											{
												foreach($param_pekerjaan as $row)
													echo "<option value ='".$row->ID."'>".$row->NAMA_PEKERJAAN."</option>\n";
											}
											?>
                    </select>
										</td>
                    <td width="30"></td>
                   <td width="200" align="left">CIF Ibu</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="CIF_IBU" id="CIF_IBU" type="text" size="30" width="30"></td>
                </tr>
				<tr>
                	<td width="250" align="left">Jumlah Anak</td>
                    <td width="5px">:</td>
                  	<td align="left">
											<select name="JUMLAH_ANAK" id="JUMLAH_ANAK">
												<option value="">-- Pilih Jumlah --</option>
												<option value="0">0</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
											</select>
										</td>
                    <td width="30"></td>
                    <td width="200" align="left">Nama Kakak 1</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="NAMA_KAKAK_1" type="text" id="NAMA_KAKAK_1" value="" size="30" width="30" /></td>
					
                </tr>
				<tr>
                	<td width="200" align="left">Nama Anak 1</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="NAMA_ANAK_1" type="text" id="NAMA_ANAK_1" value="" size="30" width="30" /></td>
                    <td width="30"></td>
                   <td width="200" align="left">CIF Kakak 1</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="CIF_KAKAK_1" type="text" id="CIF_KAKAK_1" value="" size="30" width="30" /></td>
                </tr>
				<tr>
                	<td width="200" align="left">Nama Kakak 2</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="NAMA_KAKAK_2" type="text" id="NAMA_KAKAK_2" value="" size="30" width="30" /></td>
                    <td width="30"></td>
                   <td width="200" align="left">CIF Kakak 2</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="CIF_KAKAK_2" type="text" id="CIF_KAKAK_2" value="" size="30" width="30" /></td>
                </tr>
				<tr>
                	<td width="200" align="left">Nama Adik 1</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="NAMA_ADIK_1" type="text" id="NAMA_ADIK_1" value="" size="30" width="30" /></td>
                    <td width="30"></td>
                   <td width="200" align="left">CIF Adik 1</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="CIF_ADIK_1" type="text" id="CIF_ADIK_1" value="" size="30" width="30" /></td>
                </tr>
				<tr>
                	<td width="200" align="left">Nama Adik 2</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="NAMA_ADIK_2" type="text" id="NAMA_ADIK_2" value="" size="30" width="30"/></td>
                    <td width="30"></td>
                   <td width="200" align="left">CIF Adik 2</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="CIF_ADIK_2" type="text" id="CIF_ADIK_2" value="" size="30" width="30" /></td>
                </tr>
				<tr>
                	<td width="200" align="left">Nama Ipar</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="NAMA_IPAR" type="text" id="NAMA_IPAR" value="" size="30" width="30" /></td>
                    <td width="30"></td>
                   <td width="200" align="left">CIF Ipar</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="CIF_IPAR" type="text" id="CIF_IPAR" value="" size="30" width="30" /></td>
                </tr>
				 <tr>
                	<td width="200" align="left">Produk Investasi yang dimiliki di Bank lain</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="INVESTASI_BANK_LAIN" type="text" id="INVESTASI_BANK_LAIN" value="" size="30" width="30" /></td>
                    <td width="30"></td>
					<td width="200" align="left">Produk Asuransi yang dimiliki di Bank lain</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="ASURANSI_BANK_LAIN" type="text" id="ASURANSI_BANK_LAIN" value="" size="30" width="30" /></td>
                </tr>
				 <tr>
                	<td width="200" align="left">Produk Kartu Kredit yang dimiliki di Bank lain</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="CC_BANK_LAIN" type="text" id="INVESTASI_BANK_LAIN" value="" size="30" width="30" /></td>
                    <td width="30"></td>
					<td width="200" align="left">Produk E-Banking yang dimiliki di Bank lain</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="EBANKING_BANK_LAIN" type="text" id="EBANKING_BANK_LAIN" value="" size="30" width="30" /></td>
                </tr>
				 <tr>
                	<td width="200" align="left">Produk Lain-lain yang dimiliki di Bank lain</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="LAIN2_BANK_LAIN" type="text" id="LAIN2_BANK_LAIN" value="" size="30" width="30" /></td>
                    <td width="30"></td>
                </tr>
                <tr>
                	<td align="left" colspan="7"><hr></td>
                </tr>
                <tr>
                	<td align="left" colspan="7"><input name="simpan" id="simpan" type="button" value="Simpan" class="reset"> <input name="batal" type="button" value="Batal"  onclick="history.back()"  class="reset"></td>
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
		
		
				
		function showHideAnak(jmlAnak)
		{
			$("input[name*='NAMA_ANAK']").hide();
			$("input[name*='CIF_ANAK']").hide();
			$("input[name*='USIA_ANAK']").hide();
			$("select[name*='PEKERJAAN_ANAK_ID']").hide();
			if(jmlAnak != 0)
			{
				for(var i=1 ; i <= jmlAnak; i++)
				{
					$("#NAMA_ANAK_"+i).show();
					$("#CIF_ANAK_"+i).show();
					$("#USIA_ANAK_"+i).show();
					$("#PEKERJAAN_ANAK_ID_"+i).show();
				}
			}		
		}
		
		var jmlAnak = $('#JUMLAH_ANAK').val();
		showHideAnak(jmlAnak);
		
		$('#JUMLAH_ANAK').change(function(){
			var jmlhAnak = $('#JUMLAH_ANAK').val();
			showHideAnak(jmlhAnak);
		});
		
		$('#simpan').click(function(){
			if(validation() != ''){ alert(validation()); }
				else $("#frmCustInd").submit();
			});
		
			function validation(){
				var msg = '';
//				msg =  valid('#CUST_NAME', 'Nama Customer');
				//if(! checkMail($('#email_contact').val() + $('#email_ext').val() )){ msg += 'Pls insert valid email ! \n'; }
//				if(! checkNumber($('#COST_OF_LIVING').val())){ msg += 'Biaya hidup/bulan harus angka! \n'; }
//				if(! checkNumber($('#CHILDREN').val())){ msg += 'Jumlah anak harus angka! \n'; }
//				msg += valid('#PHONE_1', 'Telepon');
				return msg;
			}
	})	
$(function(){
	$( "#accordion" ).accordion({ active:3 });
});
</script>

<?php $this->load->view('default/footer') ?>