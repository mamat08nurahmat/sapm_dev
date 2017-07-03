<?php $this->load->view('default/header') ?>	
	<td  valign="top" align="left">
	<script type="text/javascript">
	$(function() {
	//-------------------------------------
		//	Set active tabbed window
		//-------------------------------------		
		$(function() { $("#tabs").tabs(); });
		
		$(window).load(function(){
			var urls = '<?php echo site_url('/self_flagging/detail_spv/')?>/' ; 
					$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
					$("#report").load(urls);	
		})		
		
		$( "#detail_spv" ).dialog({
			autoOpen :false,
			modal : true,
				height: 'auto',
				width: 'auto',
				overlay: {
			backgroundColor: '#000',
			opacity: 1
		},
		buttons: {
			Kirim:function(){
				//$('#frm_kirimdetail').submit();
				if(confirm('Yakin ingin mengirimkan Usulan ke Pemimpin/Pimpinan Cabang?')){
				$.ajax({
					type:'post',
					url:"<?php echo site_url('self_flagging_ajax/ajax_kirim_spv/')?>",
					beforeSend: function(){
						$('#detail_spv #frm_kirimdetail').hide();
						$('#detail_spv #loading_box').show();
						$('#detail_spv').dialog({title:'Saving'});
					},
					cache: false,
					complete: function(){
						$('#detail_spv').dialog('close');
						alert('Usulan berhasil dikirim!');
						var urls = '<?php echo site_url('/self_flagging/detail_spv/')?>/' ; 
						$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
						$("#report").load(urls);
					},
					dataType:'json',
					data: $('#frm_kirimdetail').serialize(),
					success: function(data){
						if(!data.result){
							alert(data.msg);
						}
					}, 
					error : function (XMLHttpRequest, textStatus, errorThrown) {
						alert(XMLHttpRequest.responseText);
					}
				});
			return false;
				}
			},
			Tolak:function(){
				//$('#frm_kirimdetail').submit();
				if(confirm('Yakin ingin mengembalikan usulan ini?')){
					$.ajax({
						type:'post',
						url:"<?php echo site_url('self_flagging_ajax/ajax_kirim_cek/')?>",
						beforeSend: function(){
							$('#detail_spv #frm_kirimdetail').hide();
							$('#detail_spv #loading_box').show();
							$('#detail_spv').dialog({title:'Saving'});
						},
						cache: false,
						complete: function(){
							$('#detail_spv').dialog('close');
							var urls = '<?php echo site_url('/self_flagging/detail_spv/')?>/' ; 
							$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
							$("#report").load(urls);
							alert('Usulan berhasil dikembalikan!');
						},
						dataType:'json',
						data: $('#frm_kirimdetail').serialize(),
						success: function(data){
							if(!data.result){
								alert(data.msg);
							}
						}, 
						error : function (XMLHttpRequest, textStatus, errorThrown) {
							alert(XMLHttpRequest.responseText);
						}
					});
				return false;
				}
			},
			Batal:function(){
				$(this).dialog('close');
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
		
		function kirimsales(id)
		{
			//var id = $('#ID').val();;
			
			//if( id!=0 ) { id = id; }
			//else id = $('#ID').val();
			
			var msg = '';
			if(id == 0) {msg += 'NPP tidak boleh kosong \n';}
			//alert('test!');
			var url ='<?php echo site_url('/self_flagging/kirimsales/')?>/'+id;
			var r=confirm('Apakah anda yakin mengembalikan usulan '+id+' ini ke Sales?\n');
			if(r==true)
			{
				alert('Usulan '+id+' berhasil dikembalikan.');
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
		
		function detail(npp)
		{
			//alert('ambil report dengan npp '+npp);
				var urls = '<?php echo site_url('/self_flagging/detaildetail_spv/')?>/'+npp; 
				$("#detail_spv").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
				$("#detail_spv").load(urls);
				$('#detail_spv').dialog('open');
		}
		
		function kirimbm(npp)
		{
			//var id = $('#ID').val();;
			
			//if( id!=0 ) { id = id; }
			//else id = $('#ID').val();
			
			//var msg = '';
			//if(id == 0) {msg += 'NPP tidak boleh kosong \n';}
			//alert('test!');
			var url ='<?php echo site_url('/self_flagging/kirimbm/')?>/'+npp;
			var r=confirm('Apakah anda yakin mengajukan usulan '+npp+' ini ke PEMIMPIN/PIMPINAN?');
			if(r==true)
			{
				alert('Usulan '+npp+' berhasil diteruskan ke PEMIMPIN/PIMPINAN.');
				window.location.replace(url);
			}
		}
		function check()
		{
			//alert("just for check");
		   $('input:checkbox').each(function() {
            $(this).attr('checked',!$(this).attr('checked'));
			});
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
				
				<form action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
					<table cellpadding="0" cellspacing="0" border="0">
						<!--tr>
							<td align="left">NPP</td>
							<td>:</td>
							<td colspan="4"><input name="ID" id="ID" type="text" size="10" class="input">&nbsp;<input name="submit" id="submit" type="button" value="Generate"></td>
						</tr-->
					</table>
				</form>
				<br />
				<div id='report'>
				<div id='report1'></div>
				<div id='detail_spv'></div>
				</div>
				<div id="loading_box" style="display:none">
					<img src="<?php echo ICONS;?>loading_bar.gif" alt="Loading...." width="350" height="19" />
				</div>
			</div>
	</div>
</div>
</div>
</td>
</tr>
</table>
<script type="text/javascript">
$(function(){
$("#tabs").tabs();
	$( "#accordion" ).accordion({ active:1 });
});
</script>
<?php $this->load->view('default/footer') ?>	