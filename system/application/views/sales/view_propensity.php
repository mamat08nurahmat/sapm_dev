<?php $this->load->view('default/header') ?>	

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
	
	function changeSales(v){
		if(v){
			if(confirm('Assign data ke sales '+v+'?')){
				window.location.href='<?php echo site_url('sales/append_sales_propensity/'.$cif_key);?>/'+v;
			}
		}
	}
</script>

<td  valign="top" align="left">
<div id='content_x'>
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> LEADS MANAGEMENT
	<div id="tabs">
        <ul>
            <li><a href="#tabs-1">DATA LEADS PROPENSITY</a></li>
        </ul>
        <div id="tabs-1">
              
			<?php if(!empty($result)) {	?>
			<h3>CIF KEY : <?php echo $result->CIF_KEY;?></h3>
			
            <table width="100%" border="0">
				<tr>
					<td width="50%" colspan="3" style="background-color:#eeeeee;padding:3px;font-weight:bold">Data Pribadi Nasabah</td>
					<td width="50%" colspan="3" style="background-color:#eeeeee;padding:3px;font-weight:bold">Data Bisnis</td>
				</tr>
				
				<tr>
					<td style="padding:3px">CIF</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php echo $result->CIF_KEY;?></td>
					<td style="padding:3px;">Estimasi Penjualan DPK</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php echo number_format($result->ESTIMASI_DPK, 2, ',', '.');?></td>
				</tr>
				
				<tr>
					<td style="padding:3px">Nama Nasabah</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php echo $result->NAMA;?></td>
					<td style="padding:3px;">Estimasi Penjualan Loan</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php echo number_format($result->ESTIMASI_LOAN, 2, ',', '.');?></td>
				</tr>
				
				<tr>
					<td style="padding:3px">Life Time</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php echo $result->LIFE_TIME;?></td>
					<td style="padding:3px;">Estimasi Penjualan Investasi</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php echo number_format($result->ESTIMASI_INVESTASI, 2, ',', '.');?></td>
				</tr>
				
				<tr>
					<td style="padding:3px">No Handphone</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php echo $result->HANDPHONE;?></td>
					<td style="padding:3px;">Macro Segment</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php echo $result->MACRO_SEGMENT;?></td>
				</tr>
				
				<tr>
					<td style="padding:3px">Alamat Terkini</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php echo $result->ALAMAT;?></td>
					<td style="padding:3px;">Micro Segment</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php echo $result->MICRO_SEGMENT;?></td>
				</tr>
				
				<tr><td colspan="6" height="50px"></td></tr>
				
				<tr>
					<td width="50%" colspan="3" style="background-color:#eeeeee;padding:3px;font-weight:bold">Data Sales</td>
					<td width="50%" colspan="3" style="background-color:#eeeeee;padding:3px;font-weight:bold">Data Program</td>
				</tr>
				
				<tr>
					<td style="padding:3px">BNI Sales ID</td>
					<td style="padding:3px;width:3%;text-align:center;">:</td>
					<td style="padding:3px;"><?php 
						if($_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG' || $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='CABANG') {
							/*echo '<select name="id" style="width:200px;padding:2px 0px 2px 2px" onchange=" changeSales(this.value)">';
							echo '<option value="">--Pilih Sales--</option>';
							foreach($list_sales as $value=>$text) {
								echo '<option value="'.$value.'" '.($result->SALES_ID==$value? 'checked="checked"':'').'>'.$text.'</option>';
							}
							echo '</select>';*/
							echo $result->SALES_ID;
						} elseif(!empty($result->SALES_ID)) {
							echo $result->SALES_ID;
						} else {
							echo '-';
						}
					?></td>
					<td style="padding:3px;">Program Penjualan</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php echo $result->PROGRAM_NAME;?></td>
				</tr>
				
				<tr>
					<td colspan="3"></td>
					<td style="padding:3px;">Jangka Waktu Program</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php echo $result->EXPIRED_PROGRAM;?></td>
				</tr>
				
				<tr>
					<td colspan="3"></td>
					<td style="padding:3px;">Produk</td>
					<td style="padding:3px;width:3%text-align:center;">:</td>
					<td style="padding:3px;text-align:right"><?php echo $result->PRODUK;?></td>
				</tr>
				
            </table>
			 <?php } ?>
		</div>
    </div>
</div>
	<div align="center"><input name="Back" type="button" value="Back" onclick="history.back()" /></div>
</td>
</tr>
</table>	
<script type="text/javascript">
$(function(){
	$( "#accordion" ).accordion({ active:<?php echo ($_SESSION['USER_LEVEL']=='SALES')? 3:2;?> });
});
</script>

<?php $this->load->view('default/footer') ?>
