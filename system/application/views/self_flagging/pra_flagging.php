<?php $this->load->view('default/header') ?>	
	<td  valign="top" align="left">
	<script type="text/javascript">
	$(function() {
	//-------------------------------------
		//	Set active tabbed window
		//-------------------------------------		
		$(function() { $("#tabs").tabs(); });
		
		<?php
		if(isset($msg))
			{
				$txt = "<b><span style='color:#555'>Pastikan file yang akan diupload adalah file .XLS dengan format Excel 97-2003 Workbook yang sudah ditentukan</b>";
				$msgs = ($msg == '')?$txt:"<span style='color:#090'>$msg</span>";
			}
			if(isset($err))
			{
				$msgs = ($err == '')?$msgs:"<span style='color:#f00'>$err</span>";
			}
			echo "$('#report1').html(\"$msgs\");";
		?>
		
		$("#usulan_sales").dialog({
				width		: 364,
				height		: 210,
				modal		: true,
				<?php foreach($ceksales as $row) { 
				if(!empty($row->NPP)){
				?>
				autoOpen	: false,
				<?php 
					}
					else
					{?>
						autoOpen	: true,
					<?php
					}
				} ?>
				//buttons		: {'Close'	: function(){$(this).dialog('close');} }
				closeOnEscape: false,
				open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
				overlay: {
			backgroundColor: '#000',
			opacity: 1
		},
		buttons: {
			Kirim:function(){
				//$('#frm_kirimdetail').submit();
				$.ajax({
					type:'post',
					url:"<?php echo site_url('self_flagging_ajax/ajax_update_sales/')?>",
					beforeSend: function(){
						$('#usulan_sales #frmSales').hide();
						$('#usulan_sales #loading_box').show();
						$('#usulan_sales').dialog({title:'Saving'});
					},
					cache: false,
					complete: function(){
						$('#usulan_sales').dialog('close');
					},
					dataType:'json',
					data: $('#frmSales').serialize(),
					success: function(data){
						if(!data.result){
							alert(data.msg);
						}
					}, 
					error : function (XMLHttpRequest, textStatus, errorThrown) {
						$('#usulan_sales').show();
						alert(XMLHttpRequest.responseText);
					}
				});
			return false;
			},
			Reset:function(){
				$('#SALES_ID').val('');
				$('#BRANCH_ID').val('');
				$('#KLN_ID').val('');
			}
		},
		resizable: false
			});
	
		//-------------------------------------
		//	Set action if submit 
		//-------------------------------------
		$('#submit').click(function(){
			getReport(0);	
		})
		
		$('#upload').click(function(){$('#frmUpload').submit();})
		
			 var nme= document.getElementsByName("mysubmit");
		$("input[name='mysubmit']").click(function(){
		if ($("input[name='userfile']").get(0).files.length === 0){
        alert('Anda belum memilih file upload!');
        $("input[name='userfile']").focus();
        return false;
		}
			})
		//--------------------------------------------
		//	Function to get ajax content of report
		//--------------------------------------------
		function getReport(ex){
			var id = $('#ID').val();;
			
			if( id!=0 ) { id = id; }
			else id = $('#ID').val();
			
			var msg = '';
			if(id == 0) {msg += 'NPP tidak boleh kosong \n';}
					
			//if(msg){alert(msg); return false;}
				if(ex == 0){
					var urls = '<?php echo site_url('/self_flagging/status/')?>/'+id ; 
					$("#report1").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
					$("#report1").load(urls);
					var urlsx = '<?php echo site_url('/self_flagging/detail/')?>/'+id ; 
					$("#report2").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
					$("#report2").load(urlsx)
				} 
		}
	});
	
		function hapus()
		{
			var id = $('#ID').val();;
			
			if( id!=0 ) { id = id; }
			else id = $('#ID').val();
			
			var msg = '';
			if(id == 0) {msg += 'NPP tidak boleh kosong \n';}
			//alert('test!');
			var url ='<?php echo site_url('/self_flagging/hapus/')?>/'+id;
			var r=confirm('Apakah anda yakin menghapus usulan '+id+' ini ?');
			if(r==true)
			{
				alert('Usulan '+id+' berhasil dihapus.');
				window.location.replace(url);
			}
		}
		
		function kirimspv()
		{
			var id = $('#ID').val();;
			
			if( id!=0 ) { id = id; }
			else id = $('#ID').val();
			
			var msg = '';
			if(id == 0) {msg += 'NPP tidak boleh kosong \n';}
			//alert('test!');
			var url ='<?php echo site_url('/self_flagging/kirimspv/')?>/'+id;
			var r=confirm('Apakah anda yakin mengajukan usulan '+id+' ini ke SPV?\n note:Semua data yang keterangan selain OK akan dihapus permanen!');
			if(r==true)
			{
				alert('Usulan '+id+' berhasil diajukan.');
				window.location.replace(url);
			}
		}
	</script>
<div id='content_x'>
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> FLAGGING
    </div>
	<div id="tabs">
		<ul>
            <li><a href="#tabs-1">FLAGGING</a></li>
        </ul>
			<div id="tabs-1" >
				<?php
				/*echo form_open_multipart($action);
				
				
				echo '<div class="form-group">';
				echo '<label>Silahkan upload data usulan flagging dengan file excel 97-2003 extensi .xls</label>';
				echo '</div>';
				
				echo '</br>';
				echo '</br>';
				
				echo '<div class="form-group">';
				echo '<label>File ' . $error . '</label>'; // show error upload
				//echo form_upload('userfile','accept="application/vnd.ms-excel"');
				echo '<input name="userfile" type="file" id="userfile" accept="application/vnd.ms-excel" width="30"/>';
				echo form_submit('mysubmit', 'Upload', 'class="btn btn-primary"');
				echo "&nbsp;<a href='http://brftst.bni.co.id/new_sam/public/file/xls/format_upload_flagging.xls'>Download Format</a>";
				echo form_close();
				echo '</div>';
				echo '</br>';*/
				?>
				<?php if($_SESSION['USER_LEVEL']=='SALES'){?>
				 <form action="<?php echo site_url('self_flagging/proses_sales') ?>" method="post" enctype="multipart/form-data" name="frmUpload" id="frmUpload">
				<?php } else {?>
				 <form action="<?php echo site_url('self_flagging/proses') ?>" method="post" enctype="multipart/form-data" name="frmUpload" id="frmUpload">
				<?php } ?>
		   <table width="" border="0" cellspacing="5" cellpadding="0" >
                <tr>
                    <td colspan='2'>&nbsp;</td>
                    <td><input type="file" name="userfile" id="userfile" size="40" accept="application/vnd.ms-excel" /></td>
					<td colspan='2'>&nbsp;</td>
                    <td><input name="upload" id="upload" type="button" value="Upload"></td>
					<td>Belum punya template? download <a href='http://brftst.bni.co.id/new_sam/public/file/xls/format_upload_flagging.xls'>disini</a></td>
                </tr>
            </table>
            </form>
				<form action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
					<table cellpadding="0" cellspacing="0" border="0">
						<tr>
							<?php if($_SESSION['USER_LEVEL']<>'SALES')
							{?>
							<td align="left">NPP</td>
							<td>:</td>
							<td colspan="4"><input name="ID" id="ID" type="text" size="10" class="input">&nbsp;
							<?php } else {?>
							<input name="ID" id="ID" type="hidden" size="10" value=<?php echo $_SESSION['ID'];?> class="input">
							<?php } ?>
							&nbsp;&nbsp;&nbsp;<input name="submit" id="submit" type="button" value="Generate"></td>
						</tr>
					</table>
				</form>
				<br />
				<div id='report'>
				<div id='report1'>Silahkan input npp untuk mengenerate report</div>
				<div id='report2'></div>
				</div>
				<div id='usulan_sales' title="Update">
			<!-- isi disini-->
				<form action="#" method="post" enctype="multipart/form-data" name="frmSales" id="frmSales">
					<table cellpadding="0" cellspacing="0" border="0">
						<input type="hidden" id="NPP" name="NPP" value="<?php echo $_SESSION['ID']?>">
						<tr>
							<td align="left">Jenis Sales</td>
							<td align="center" width="20">:</td>
							<td align="left"><select name="SALES_ID" id="SALES_ID" class="harusisi">
								<option value=""></option>
								<?php foreach($list_salestype as $row) { ?>
								<option value="<?php echo $row->ID;?>"><?php echo $row->SALES_TYPE;?></option>
								<?php } ?>
								</select></td>
						<img src="<?php echo IMAGES;?>load.gif" id="img_load" style="display:none" /></td>
						</tr>
						<tr>
							<td colspan=3><br></td>
						</tr>
						<tr id='ply'>
							<td align="left">Cabang</td>
							<td align="center" width="20">:</td>
							<td align="left"><select name="BRANCH_ID" id="BRANCH_ID" class="harusisi" onchange="changeCabang(this.value)">
								<option value=""></option>
								<?php foreach($list_cabang as $row) { ?>
								<option value="<?php echo $row->BRANCH_CODE;?>"><?php echo $row->BRANCH_NAME;?></option>
								<?php } ?>
								</select></td>
						<img src="<?php echo IMAGES;?>load.gif" id="img_load" style="display:none" /></td>
						</tr>
						<tr>
							<td colspan=3><br></td>
						</tr>
						<tr id='kmtr'>
							<td align="left">Outlet Penempatan</td>
							<td align="center" width="20">:</td>
							<td align="left"><select name="KLN_ID" id="KLN_ID" class="harusisi">
										<option value=""></option>
									</select></td>
						</tr>
						<tr>
							<td colspan=3><br></td>
						</tr>
						<tr id='krm'>
							<td align="center" colspan="3"><input name="update" id="update" type="submit" value="Simpan" style="background:#FFC488;Display:none;"> <input name="batal" type="reset" value="Reset" style="background:#FFC488;display:none;"></td>
						</tr>
					</table>
				</form>
				</div>
			</div>
			<div id="loading_box" style="display:none">
			<img src="<?php echo ICONS;?>loading_bar.gif" alt="Loading...." width="350" height="19" />
		</div>
	</div>
</div>
</div>
</td>
</tr>
</table>
<script type="text/javascript">
var list_kln=<?php echo json_encode($list_kln);?>;

function changeCabang(v){
	var html='<option value=""></option>';
	if(v){
		var obj='BRANCH_'+v;
		if(typeof(list_kln[obj])!='undefined'){
			$.each(list_kln[obj], function (i, itm){
				html+='<option value="'+itm.value+'">'+itm.innerHTML+'</option>';
			});
		}
	}
	
	$('#KLN_ID').html(html);
}	

$(function(){
$("#tabs").tabs();
	$( "#accordion" ).accordion({ active:1 });
});
</script>
<?php $this->load->view('default/footer') ?>	