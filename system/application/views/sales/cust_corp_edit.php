<?php $this->load->view('default/header') ?>	

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
		$("#ANUAL_INCOME").numeric();
		$("#EMPLOYEE").numeric();
	});
	
	$(function() {
		$("#DATE_CREATED").datepicker({
			showOn: 'button',
			buttonImage: '<?php echo ICONS ?>calendar.gif',
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#DATE_CREATED').datepicker('option', {dateFormat: 'd-M-y'});
		$('#DATE_CREATED').datepicker('option', $.datepicker.regional['id']);
	});
</script>


<!--

CIF_KEY
COMPANY_NAME
BUSS_CRITERIA
DATE_CREATED
ADDRESS
EMPLOYEE
PHONE_1
PHONE_2
BUSS_SCOPE
INDUSTRY
SUB_INDUSTRY
ANUAL_INCOME
OTHER_DESCRIPTION
IS_PROSPECT
CUR_BOOK_BAL_IDR
AS_OF_DATE
AVG_BOOK_BAL
KEY_PERSON
BRANCH_CODE
SEGMENT
PROD_REC
BNI_COMMITMENT_BAL_IDR
LAST_ACTIVITY_KEY
LAST_ACTIVITY_DATE
BNI_SALES_ID
ID

-->

<td  valign="top" align="left">

<div id='content_x'>
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> SALES CUSTOMER MANAGEMENT
    </div>
	<div id="tabs">
        <ul>
            <li><a href="#tabs-1">Customer Corporate</a></li>
        </ul>
        <div id="tabs-1">
        <form action="<?php echo site_url('/sales/save_cust_corp/') ?>" method="post" enctype="application/x-www-form-urlencoded" name="frmCustomer" id="frmCustomer">
            <input type="hidden" name="ID" id="ID" value="">
            <table width="100%" border="0" cellspacing="0" class="frmtable">
 				<tr>
                	<td width="200" align="left">No CIF</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="CIF_KEY" type="text" id="CIF_KEY" value="" style='width:250px' readonly></td>
                </tr>           
                <tr>
                    <td width="200" align="left">Nama Perusahaan <span style="color:#F00">*</span></td>
                    <td width="5">:</td>
                  	<td align="left"><input name="COMPANY_NAME" type="text" id="COMPANY_NAME" value="" style='width:250px'></td>
                </tr>
                <tr>
                	<td width="200" align="left">Tanggal Berdiri <span style="color:#F00">*</span></td>
                    <td width="5">:</td>
                  	<td align="left"><input name="DATE_CREATED" type="text" id="DATE_CREATED" value="" style='width:100px'></td>
                </tr>
                <tr>
                	<td width="200" align="left" valign="top">Alamat Perusahaan <span style="color:#F00">*</span></td>
                    <td width="5">:</td>
               	  	<td align="left" valign="top"><textarea name="ADDRESS" rows="4" id="ADDRESS" style='width:250px'></textarea></td>
                </tr>
                <tr>
                	<td width="200" align="left">Jumlah Pegawai</td>
                  	<td width="5">:</td>
                  	<td align="left"><input name="EMPLOYEE" type="text" id="EMPLOYEE" value="0" style='width:250px'></td>
                </tr>
                <tr>
                	<td width="200" align="left">Kriteria Bisnis<span style="color:#F00"> *</span></td>
                    <td width="5">:</td>
                  	<td align="left"><input name="BUSS_CRITERIA" type="text" value="" id="BUSS_CRITERIA" style='width:250px'></td>
                </tr>
                <tr>
                  <td align="left">Telepon <span style="color:#F00">*</span></td>
                  <td>:</td>
                  <td align="left"><input name="PHONE_1" type="text" id="PHONE_1" value="" style='width:250px'></td>
                </tr>
                <tr>
                  <td align="left">Fax</td>
                  <td>:</td>
                  <td align="left"><input name="PHONE_2" type="text" id="PHONE_2" value="" style='width:250px'></td>
                </tr>
                <tr>
                	<td width="200" align="left">Scope Bisnis <span style="color:#F00">*</span></td>
                    <td width="5">:</td>
                  	<td align="left"><input name="BUSS_SCOPE" type="text" id="BUSS_SCOPE" value="" style='width:250px'></td>
                </tr>
                <tr>
                	<td width="200" align="left">Industri <span style="color:#F00">*</span></td>
                    <td width="5">:</td>
                  	<td align="left"><input name="INDUSTRY" type="text" id="INDUSTRY" style='width:250px'></td>
                </tr>
                <tr>
                    <td align="left">Pendapatan pertahun</td>
                    <td>:</td>
                    <td align="left"><input name="ANUAL_INCOME" type="text" id="ANUAL_INCOME" value="0" style='width:250px'></td>
              	</tr>
                <tr>
                  	<td align="left" valign="top">Keterangan Lain</td>
                  	<td valign="top">:</td>
                  	<td align="left" valign="top"><textarea name="OTHER_DESCRIPTION" rows="4" id="OTHER_DESCRIPTION" style='width:250px'></textarea></td>
                </tr>
                <tr>
                	<td width="200" align="left">PIC</td>
                    <td width="5">:</td>
                  	<td align="left"><input name="KEY_PERSON" type="text" id="KEY_PERSON" value="" style='width:250px'></td>
                </tr>
                <tr>
                	<td align="left" colspan="3"><hr></td>
                </tr>
                <tr>
                	<td align="left" colspan="3"><input name="simpan" id="simpan" type="button" value="Simpan" class="reset"> <input name="batal" type="button" value="Batal"  onclick="history.back()"  class="reset"></td>
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
			if(validation() != ''){ alert(validation()); }
				else $("#frmCustomer").submit();
			});
		
			function validation(){
				var msg = '';
				msg =  valid('#COMPANY_NAME', 'Nama Perusahaan');
				msg += valid('#DATE_CREATED', 'Tanggal Berdiri');
				msg += valid('#ADDRESS', 'Alamat Perusahaan');
				//msg += valid('#BUSS_CRITERIA', 'Kriteria Bisnis');
				//msg += valid('#INDUSTY', 'Industri');
				//msg += valid('#BUSS_SCOPE', 'sScope Bisnis');
				//msg += valid('#email_contact');
				//if(! checkMail($('#email_contact').val() + $('#email_ext').val() )){ msg += 'Pls insert valid email ! \n'; }
				if(! checkNumber($('#ANUAL_INCOME').val())){ msg += 'Pendapatan pertahun harus angka! \n'; }
				if(! checkNumber($('#EMPLOYEE').val())){ msg += 'Jumlah pegawai harus angka! \n'; }
				msg += valid('#PHONE_1', 'Telepon');
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
$(function(){
	$( "#accordion" ).accordion({ active:3 });
});
</script>	

<?php $this->load->view('default/footer') ?>