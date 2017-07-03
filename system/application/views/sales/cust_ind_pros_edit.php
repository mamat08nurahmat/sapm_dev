<?php $this->load->view('default/header') ?>	

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
		$("#form_rtgs").hide();
		$("#SL").hide();
		$("#RLI").hide();
		$("#CS").hide();
		$("#CT").hide();
		$("#rtt_rtgs").hide();
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
	
	$(function() {
		$("#ry_rtgs").click(function(){
			$("#form_rtgs").show();
			$("#SL").hide();
			$("#RLI").show();
			$("#CS").show();
			$("#CT").hide();
			$("#rtt_rtgs").show();
		});
		$("#rt_rtgs").click(function(){
			$("#form_rtgs").hide();
			$("#SL").hide();
			$("#RLI").hide();
			$("#CS").hide();
			$("#CT").hide();
			$("#rtt_rtgs").hide();
			$("#source_leads").val('');
			$("#refferal_leads_id").val('');
			$("#cabang").val('');
		});
		$("#cst_rtgs").click(function(){
			$("#CT").show();
			$("#BRANCH").val('');
		});
		$("#csy_rtgs").click(function(){
			var cbng = '<?php echo $_SESSION['BRANCH_ID'];?>';
			$("#CT").hide();
			$('select[name="BRANCH"] option:selected').attr("selected",null);
			$('select[name="BRANCH"] option[value='+cbng+']').attr("selected","selected");
			//alert(cbng);
		});
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
            <li><a href="#tabs-1">Leads Prospek</a></li>
        </ul>
        <div id="tabs-1">
        <form action="<?php echo site_url('/sales/save_cust_ind_pros/') ?>" method="post" enctype="application/x-www-form-urlencoded" name="frmCustInd" id="frmCustInd">
            <input type="hidden" name="ID" id="ID" value="">
            <table width="100%" border="0" cellspacing="0" class="frmtable">
 				<tr>
                	<td width="200" align="left">Nama Customer <span style="color:#F00">*</span></td>
                    <td width="5">:</td>
                  	<td align="left"><input name="CUST_NAME" type="text" id="CUST_NAME" value="" size="30" width="30"></td>
                    <td width="30"></td>
                    <td width="250" align="left">Hal yang dianggap penting</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="IMPORTANT" id="IMPORTANT" type="text" size="30" width="30"></td>
                </tr>           
                <tr>
                	<td width="200" align="left">No CIF</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="CIF_KEY" type="text" id="CIF_KEY" value="" size="30" width="30"></td>
                    <td width="30"></td>
                    <td width="200" align="left">Tempat Liburan</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="VACATION" id="VACATION" type="text" size="30" width="30"></td>
                </tr>
                <tr>
                	<td width="200" align="left">Nama Perusahaan</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="COMPANY_NAME" type="text" id="COMPANY_NAME" value="" size="30" width="30"></td>
                    <td width="30"></td>
                    <td width="200" align="left">Kerabat Penting</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="KINSMAN" id="KINSMAN" type="text" size="30" width="30"></td>
                </tr>
                <tr>
                	<td width="200" align="left">Jabatan</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="OCCUPATION" type="text" id="OCCUPATION" value="" size="30" width="30"></td>
                    <td width="30"></td>
                    <td width="200" align="left">Biaya hidup/bulan</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="COST_OF_LIVING" id="COST_OF_LIVING" type="text" size="30" width="30" value="0"></td>
                </tr>
                <tr>
                	<td width="200" align="left">Tempat Lahir </td>
                  <td width="5">:</td>
                  	<td align="left"><input name="PLACE_OF_BIRTH" type="text" id="PLACE_OF_BIRTH" value="" size="30" width="30"></td>
                    <td width="30"></td>
                    <td width="200" align="left">Keahlian/Hobi</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="HOBBY" id="HOBBY" type="text" size="30" width="30"></td>
                </tr>
                <tr>
                	<td width="200" align="left">Tanggal Lahir </td>
                  <td width="5">:</td>
                  	<td align="left"><input name="DATE_OF_BIRTH" type="text" value="" style="width:100px"  id="DATE_OF_BIRTH" readonly></td>
                    <td width="30"></td>
                    <td width="200" align="left">Produk BNI 1</td>
                    <td width="5px">:</td>
                  	<td align="left">
                    <select name="BNI_PRODUCT_CD_1" id="BNI_PRODUCT_CD_1">
                    	<option value="">-- Pilih Produk --</option>
                    	<?php 
						if(isset($bni_product)){
							foreach($bni_product as $row)
							{
								if( stristr($row->PRODUCT_NAME, 'jumlah') === false)
								{
									echo "<option value ='".$row->PRODUCT_NAME."'>".$row->PRODUCT_NAME."</option>\n";
								}
							}
						}
						?>
                    </select>
                  </td>
                </tr>
                <tr>
                	<td width="200" align="left">Jenis Kelamin </td>
                  <td width="5">:</td>
                  	<td align="left">
                    <select name="SEX_CD" id="SEX_CD">
                  	  <option value="M">Pria</option>
                  	  <option value="F">Wanita</option>
               	  </select></td>
                    <td width="30"></td>
                    <td width="200" align="left">Produk BNI 2</td>
                    <td width="5px">:</td>
                  	<td align="left">
                    <select name="BNI_PRODUCT_CD_2" id="BNI_PRODUCT_CD_2">
                    	<option value="">-- Pilih Produk --</option>
                    	<?php 
						if(isset($bni_product)){
							foreach($bni_product as $row)
							{
								if( stristr($row->PRODUCT_NAME, 'jumlah') === false)
								{
									echo "<option value ='".$row->PRODUCT_NAME."'>".$row->PRODUCT_NAME."</option>\n";
								}
							}
						}
						?>
                    </select>
                  </td>
                </tr>
                <tr>
                	<td width="200" align="left">Sekertaris</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="SECRETARY" type="text" id="SECRETARY" value="" size="30" width="30"></td>
                    <td width="30"></td>
                    <td width="200" align="left">Produk BNI 3</td>
                    <td width="5px">:</td>
                  	<td align="left">
                    <select name="BNI_PRODUCT_CD_3" id="BNI_PRODUCT_CD_3">
                    	<option value="">-- Pilih Produk --</option>
                    	<?php 
						if(isset($bni_product)){
							foreach($bni_product as $row)
							{
								if( stristr($row->PRODUCT_NAME, 'jumlah') === false)
								{
									echo "<option value ='".$row->PRODUCT_NAME."'>".$row->PRODUCT_NAME."</option>\n";
								}
							}
						}
						?>
                    </select>
                    </td>
                </tr>
                <tr>
                	<td width="200" align="left" valign="top">Alamat Rumah </td>
                  <td width="5" valign="top">:</td>
                  	<td align="left" valign="top"><textarea name="ADDRESS" cols="30" rows="4" id="ADDRESS" width="30"></textarea></td>
                  <td width="30"></td>
                    <td width="200" align="left" valign="top">Produk BNI 4</td>
                    <td width="5px" valign="top">:</td>
                    <td align="left" valign="top">
                    <select name="BNI_PRODUCT_CD_4" id="BNI_PRODUCT_CD_4">
                    	<option value="">-- Pilih Produk --</option>
                        <?php 
                        if(isset($bni_product)){
                            foreach($bni_product as $row)
                            {
                                if( stristr($row->PRODUCT_NAME, 'jumlah') === false)
								{
									echo "<option value ='".$row->PRODUCT_NAME."'>".$row->PRODUCT_NAME."</option>\n";
								}
                            }
                        }
                        ?>
                    </select>
                  </td>
                </tr>
                <tr>
                	<td width="200" align="left">Status Pernikahan </td>
                  <td width="5">:</td>
                  	<td align="left"><select name="MARITAL_CD" id="MARITAL_CD">
                  	  <option value="S">Single</option>
                  	  <option value="M">Menikah</option>
                                                                                                                        </select></td>
               	  <td width="30"></td>
                    <td width="200" align="left">Produk Bank Lain 1</td>
                    <td width="5px">:</td>
                  	<td align="left"> 
                    <select name="OTHER_PRODUCT_CD_1" id="OTHER_PRODUCT_CD_1">
                        <option value="">-- Pilih Produk --</option>
						<?php 
                        if(isset($other_product)){
                            foreach($other_product as $row)
                            {
                                echo "<option value ='".$row->PRODUCT."'>".$row->PRODUCT."</option>\n";
                            }
                        }
                        ?>
                  </select></td>
                </tr>
                <tr>
                	<td width="200" align="left">Jumlah Anak</td>
                    <td width="5">:</td>
                  	<td align="left">
                    <select name="CHILDREN" id="CHILDREN">
                    <?php 
						for($i=0;$i<=20;$i++) echo "<option value='$i'>$i</option>\n";
					?>
                    </select>
                    <td width="30"></td>
                    <td width="200" align="left">Produk Bank Lain 2</td>
                    <td width="5px">:</td>
                  	<td align="left">
                     <select name="OTHER_PRODUCT_CD_2" id="OTHER_PRODUCT_CD_2">
                     	<option value="">-- Pilih Produk --</option>
                        <?php 
                        if(isset($other_product)){
                            foreach($other_product as $row)
                            {
                                echo "<option value ='".$row->PRODUCT."'>".$row->PRODUCT."</option>\n";
                            }
                        }
                        ?>
                    </select>
                    </td>
                </tr>
                <tr>
                	<td width="200" align="left">Telepon 1 <span style="color:#F00">*</span></td>
                  <td width="5">:</td>
                  	<td align="left"><input name="PHONE_1" type="text" id="PHONE_1" value="" size="30" width="30"></td>
                    <td width="30"></td>
                    <td width="200" align="left">Produk yang dibutuhkan</td>
                    <td width="5px">:</td>
                  	<td align="left"><input  name="PROD_REC" id="PROD_REC" type="text" size="30" width="30"></td>
                </tr>
                <tr>
                	<td width="200" align="left">Telepon 2</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="PHONE_2" type="text" id="PHONE_2" value="" size="30" width="30"></td>
                    <td width="30"></td>
                    <td width="200" align="left">Sifat Dominan</td>
                    <td width="5px">:</td>
                  	<td align="left"><input name="PERSONAL_TRAIT" id="PERSONAL_TRAIT" type="text" size="30" width="30"></td>
                </tr>
                <tr>
                	<td width="200" align="left" valign="top">Pendidikan Terakhir</td>
                  <td width="5" valign="top">:</td>
                  	<td align="left" valign="top"><select name="EDUCATION" id="EDUCATION">
                  	  <option value="S3">S3</option>
                  	  <option value="S2">S2</option>
                  	  <option value="S1">S1</option>
                  	  <option value="D3">D3</option>
                  	  <option value="D1">D1</option>
                  	  <option value="SMA">SMA</option>
                  	  <option value="SMP">SMP</option>
                  	  <option value="SD">SD</option>
                  	  <option value="Lainya">Lainya</option>
                                        </select></td>
               	  <td width="30"></td>
                    <td width="200" align="left" valign="top">Keterangan Lain</td>
                    <td width="5px" valign="top">:</td>
                  	<td align="left" valign="top"><textarea name="OTHER_DESCRIPTION" cols="30" rows="4" id="OTHER_DESCRIPTION" width="30"></textarea></td>
                </tr>
                <tr>
                	<td width="200" align="left">Organisasi yang diikuti</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="ORGANISATION" type="text" id="ORGANISATION" value="" size="30" width="30"></td>
                    <td colspan="4"></td>
                </tr>
				  <tr>
                	<td align="left" colspan="7"><hr></td>
                </tr>
				<tr>
					<td>Apakah data terkait refferal RTGS ?</td>
					<td>:</td>
					<td><input type="radio" name="r_rtgs" id="ry_rtgs">Ya</td>
					<td id="rtt_rtgs"><input type="radio" name="r_rtgs" id="rt_rtgs">Tidak</td>
				</tr>
				<div id="form_rtgs">
				<tr id="SL">
					<td>SUMBER LEADS</td>
					<td>:</td>
					<td><!--select name="FLAG_SOURCE" id="FLAG_SOURCE"><option value=""></option>
					<?php foreach($list_sumber_leads as $row) { ?>
					<option value="<?php echo $row->ID;?>"><?php echo $row->SOURCE_DATA?></option>
					<?php } ?>
					</select-->
					<input type="hidden" name="FLAG_SOURCE" id="FLAG_SOURCE" value="60"></td>
				</tr>
				<tr id="RLI">
					<td>REFFERAL LEADS ID</td>
					<td>:</td>
					<td><input type="text" id="REFFERAL_LEADS_ID" name="REFFERAL_LEADS_ID"></td>
				</tr>
				<tr id="CS">
					<td>Apakah data Cabang Sendiri?</td>
					<td>:</td>
					<td><input type="radio" name="cs_rtgs" id="csy_rtgs">Ya</td>
					<td id="rtt_rtgs"><input type="radio" name="cs_rtgs" id="cst_rtgs">Tidak</td>
				</tr>
				<tr id="CT">
					<td>Cabang Tujuan</td>
					<td>:</td>
					<td><select name="BRANCH" id="BRANCH"><option value=""></option>
					<?php foreach($list_cabang as $row) { ?>
					<option value="<?php echo $row->BRANCH_CODE;?>"><?php echo $row->BRANCH_NAME?></option>
					<?php } ?>
					</select></td>
				</tr>
				</div>
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
<div id='search' title="Data Leads Management" style="display:none">
		<div id="tabs1-1">
			<?php echo $js_grid_offensive; ?><table id="search_list" style="display:none"></table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
	$('#REFFERAL_LEADS_ID').click(function(){			
		$('#search').dialog('open');
	});
	
	$("#search").dialog({
		width		: 610,
		height		: 450,
		modal		: true,
		autoOpen	: false,
		beforeClose	: function(){
			$("select").show();
		},
		open		: function(){
			$("select").hide();
		},
		buttons		: {
			'Close'	: function(){
				$(this).dialog('close');
			}
		}
	});
	
		<?php
			if(isset($data)){ 
				foreach($data[0] as $row=>$val){
					echo "$('#".$row."').val('".$val."');";
				}
			}
		?>
		
		$('#simpan').click(function(){
			if(validation() != ''){ alert(validation()); }
				else $("#frmCustInd").submit();
			});
		
			function validation(){
				var msg = '';
				msg =  valid('#CUST_NAME', 'Nama Customer');
				//if(! checkMail($('#email_contact').val() + $('#email_ext').val() )){ msg += 'Pls insert valid email ! \n'; }
				if(! checkNumber($('#COST_OF_LIVING').val())){ msg += 'Biaya hidup/bulan harus angka! \n'; }
				if(! checkNumber($('#CHILDREN').val())){ msg += 'Jumlah anak harus angka! \n'; }
				msg += valid('#PHONE_1', 'Telepon');
				if ($("#ry_rtgs").is(":checked")) {
					msg += valid('#REFFERAL_LEADS_ID', 'Refferal id');
					msg += valid('#BRANCH', 'Cabang Tujuan');
				}
				return msg;
			}
			
			
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
	function pilih_data(com,grid){
	if (com=='Pilih'){
		if($('.trSelected',grid).length>0 && $('.trSelected',grid).length<2) {
			// to provide value in ie 6 suck
			var arrData = getSelectedRow();
			var cif;
			$('#REFFERAL_LEADS_ID').val(arrData[0][0]);
			$('#search').dialog('close');
		} else {
			alert('Pilih satu data saja !'); 
		}
	}
}

function getSelectedRow() {
	var arrReturn   = [];
	$('.trSelected').each(function() {
		var arrRow              = [];
		$(this).find('div').each(function() {
			arrRow.push( $(this).html() );
		});
		arrReturn.push(arrRow);
	});
	return arrReturn;
}


$(function(){
	$( "#accordion" ).accordion({ active:3 });
});
</script>	

<?php $this->load->view('default/footer') ?>