<?php $this->load->view('default/header') ?>	

<td  valign="top" align="left">
<div id='content_x'>
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> PIPELINE
    </div>

	<div id="tabs">
        <ul>
            <li><a href="#tabs-1">Tambah PIPELINE</a></li>
        </ul>
        <div id="tabs-1" >
			<form action="<?php echo site_url('/activity/add_account_planning_bm') ?>" method="post" enctype="application/x-www-form-urlencoded" name="frmCustomer" id="frmCustomer">

			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td>
						<?php
							$tanggal=date("d-M-Y");
							$d=date("d");
							#$d=31;
							$m=date("m");
							$y=date("Y");
							#$w=date("W",$tanggal);
							switch($d){
							case ($d>= 1 and $d<=7):
								$w = 1;
								break;
							case ($d>= 8 and $d<=14):
								$w = 2;
								break;
							case ($d>= 15 and $d<=21):
								$w = 3;
								break;
							case ($d>= 22):
								$w = 4;
								break;
							}
						?>
						<!--
						<input type="hidden" name="STAGING_ID" id="STAGING_ID" value="<?php echo $this->_activity->get_first_stage_id();?>">
						<input type="hidden" name="SOURCE_ID" id="SOURCE_ID" value="">
						<input type="hidden" name="SALES_ID" id="SALES_ID" value="<?php echo $_SESSION[ID];?>">
						-->
						<input type="hidden" name="DATE" id="DATE" value="<?php echo $tanggal;?>">
						<?php
							if($w==1 && $d>=25)
							{
						?>
						<input type="hidden" name="M" id="M" value="<?php echo $m+1;?>">
						<?php
							}else{
						?>
						<input type="hidden" name="M" id="M" value="<?php echo $m;?>">
						<?php
						}
						?>
						<input type="hidden" name="Y" id="Y" value="<?php echo $y;?>">
						<input type="hidden" name="save" value="1">
						
						<div  class="ui-corner-all" style="padding:10px; margin-right:10px; border:1px #BAD7F5 solid;" >
							<table width="" border="0" cellspacing="0" class="frmtable">
								<tr>
									<td align="left">No CIF <span style="color:#F00">*</span></td>
									<td align="center" width="20">:</td>
									<td align="left"><input name="CIF" type="text" id="CIF" value="" width="30" readonly></td>
								</tr>           
								<tr>
									<td>Nama Customer <span style="color:#F00">*</span></td>
									<td align="center">:</td>
									<td align="left"><input name="CUST_NAME" type="text" id="CUST_NAME" size="30"  readonly class="harusisi" width="30"></td>
								</tr>
								<!--<tr>
									<td>Kategori <span style="color:#F00">*</span></td>
									<td align="center">:</td>
									<td align="left"><select name="CAT_ID" id="CAT_ID" class="harusisi" onchange="changeKategori(this.value)">
										<option value=""></option>
										<?php foreach($list_category as $row) { ?>
										<option value="<?php echo $row->ID;?>"><?php echo $row->KATEGORI;?></option>
										<?php } ?>
									</select></td>
								</tr>-->
								<tr>
									<td>Produk <span style="color:#F00">*</span></td>
									<td align="center">:</td>
									<td align="left"><select name="PRODUCT_ID" id="PRODUCT_ID" class="harusisi">
										<option value="2">TABUNGAN</option>
									</select></td>
								</tr>
								<tr>
									<td align="left">PIPELINE (Rp.) <span style="color:#F00">*</span></td>
									<td align="center">:</td>
									<td align="left"><input name="RENCANA" type="text" id="RENCANA" value="" width="30" style="width:100px;" onkeydown="return numberOnly(event)" onkeyup="numberFormato(this)" class="harusisi" /></td>
								</tr>
								<tr>
									<td align="left">Periode (Minggu)<span style="color:#F00">*</span></td>
									<td align="center">:</td>
									<?php switch($w){
									case 1:?>
									<td align="left"><input name="WEEK" type="text" id="WEEK" value="1" width="30" style="width:100px;" onkeydown="return numberOnly(event)" onkeyup="numberFormato(this)" class="harusisi" readonly /></td>
									<?php break;
									case 2:?>
									<td align="left"><input name="WEEK" type="text" id="WEEK" value="2" width="30" style="width:100px;" onkeydown="return numberOnly(event)" onkeyup="numberFormato(this)" class="harusisi" readonly /></td>
									<?php break;
									 case 3:?>
									<td align="left"><input name="WEEK" type="text" id="WEEK" value="3" width="30" style="width:100px;" onkeydown="return numberOnly(event)" onkeyup="numberFormato(this)" class="harusisi" readonly /></td>
									<?php break;
									case 4:?>
									<td align="left"><input name="WEEK" type="text" id="WEEK" value="4" width="30" style="width:100px;" onkeydown="return numberOnly(event)" onkeyup="numberFormato(this)" class="harusisi" readonly /></td>
									<?php break;}?>
								</tr>
								<tr>
									<td align="left" colspan="3" height="30"></td>
								</tr>
								<tr>
									<td align="left" colspan="3"><input name="simpan" id="simpan" type="button" value="Simpan" style="background:#FFC488"> <input name="batal" type="button" value="Batal"  onclick="window.location.href='<?php echo site_url('account_planning/list_account_planning_bm');?>'" style="background:#FFC488"></td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</td>
</tr>
</table>

<div id='search' title="Data Leads Management" style="display:none">
	<div id="tabs2">
		<ul>
			<li><a href="#tabs2-1">Leads Kelolaan</a></li>
			<?php if($_SESSION['SALES_ID']==5) {?>
			<li><a href="#tabs2-2">Leads Prospek</a></li>
			<?php } ?>
		</ul>
		<div id="tabs2-1">
			<?php echo $js_grid; ?><table id="search_list" style="display:none"></table>
		</div>
		<?php if($_SESSION['SALES_ID']==5) {?>
		<div id="tabs2-2">
			<?php echo $js_grid_2; ?><table id="search_list2" style="display:none"></table>
		</div>
		<?php } ?>
	</div>
</div>

<script type="text/javascript">
var list_produk=<?php echo json_encode($list_produk);?>;

function changeKategori(v){
	var html='<option value=""></option>';
	if(v){
		var obj='CAT_'+v;
		if(typeof(list_produk[obj])!='undefined'){
			$.each(list_produk[obj], function (i, itm){
				html+='<option value="'+itm.value+'">'+itm.innerHTML+'</option>';
			});
		}
	}
	
	$('#PRODUCT_ID').html(html);
}	

function pilih_data(com,grid){
	if (com=='Pilih'){
		if($('.trSelected',grid).length>0 && $('.trSelected',grid).length<2) {
			// to provide value in ie 6 suck
			var arrData = getSelectedRow();
			var cif;
			if(arrData[0][1].length < 9){cif = '';} else {cif = arrData[0][1];}
			$('#CIF').val(cif);
			$('#CUST_NAME').val(arrData[0][2]);
			$('#SOURCE_ID').val(<?php echo $kelolaan_source_id;?>);
			$('#search').dialog('close');
		} else {
			alert('Pilih satu data saja !'); 
		}
	}
}

function pilih_data2(com,grid){
	if (com=='Pilih'){
		if($('.trSelected',grid).length>0 && $('.trSelected',grid).length<2) {
			// to provide value in ie 6 suck
			var arrData = getSelectedRow();
			var cif;
			if(arrData[0][1].length < 9){cif = '';} else {cif = arrData[0][1];}
			$('#CIF').val(cif);
			$('#CUST_NAME').val(arrData[0][2]);
			$('#SOURCE_ID').val(<?php echo $prospek_source_id;?>);
			$('#search').dialog('close');
		} else {
			alert('Pilih satu data saja !'); 
		}
	}
}

function pilih_data3(com,grid){
	if (com=='Pilih'){
		if($('.trSelected',grid).length>0 && $('.trSelected',grid).length<2) {
			// to provide value in ie 6 suck
			var arrData = getSelectedRow();
			var cif;
			if(arrData[0][1].length < 9){cif = '';} else {cif = arrData[0][1];}
			$('#CIF').val(cif);
			$('#CUST_NAME').val(arrData[0][2]);
			$('#SOURCE_ID').val(<?php echo $tele_source_id;?>);
			$('#search').dialog('close');
		} else {
			alert('Pilih satu data saja !'); 
		}
	}
}

function pilih_data4(com,grid){
	if (com=='Pilih'){
		if($('.trSelected',grid).length>0 && $('.trSelected',grid).length<2) {
			// to provide value in ie 6 suck
			var arrData = getSelectedRow();
			var cif;
			if(arrData[0][1].length < 9){cif = '';} else {cif = arrData[0][1];}
			$('#CIF').val(cif);
			$('#CUST_NAME').val(arrData[0][2]);
			$('#SOURCE_ID').val(<?php echo $propensity_source_id;?>);
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
	$('#CIF, #CUST_NAME').click(function(){			
		$('#search').dialog('open');
	});
	
	$('#TANGGAL').datepicker({minDate:-3, maxDate:0, dateFormat:'dd-M-yy'});
	
	//user_dialog
	$("#search").dialog({
		width		: 500,
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
	
	$('#simpan').click(function(){
		var lanjut=true;
		$('#frmCustomer .harusisi').each(function(){
			if($.trim(this.value)==''){
				lanjut=false;
				this.focus();
				alert('Kolom bertanda asterik wajib diisi');
				return false;
			}	
		});

		if(lanjut){
		$("#frmCustomer").submit();
		}
	});
	
	$("#tabs").tabs();
	$("#tabs2").tabs();

	$( "#accordion" ).accordion({ active:2 });
});
</script>	

<?php $this->load->view('default/footer') ?>
