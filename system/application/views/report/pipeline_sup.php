<?php $this->load->view('template/header') ?>	
<?php $this->load->view('template/topbar') ?>	
<?php $this->load->view('template/sidebar') ?>	
<!----------------------------------------------------->
<!--tambahkan custom Js disini-->

<!-- jQuery 2.1.3 ???-->
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<!-- Bootstrap 3.3.2 JS ???-->
<script src="http://192.168.3.14/new_sapm/assetsLTE/AdminLTE-2-3-11/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<!---=====================================--->
    <!-- Main content -->
   	<section class="content">
        <!-- START CUSTOM TABS -->

<!-- main lama 
<td  valign="top" align="left">
 -->
<!---=====================================--->
<script type="text/javascript">

	$(function() {
		$("#tabs").tabs();
	
		$("#START").datepicker({
			showOn: 'button',
			buttonImage: '<?php echo ICONS ?>calendar.gif',
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#START').datepicker('option', {dateFormat: 'd-m-yy'});
		
		$("#END").datepicker({
			showOn: 'button',
			buttonImage: '<?php echo ICONS ?>calendar.gif',
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#END').datepicker('option', {dateFormat: 'd-m-yy'});
		
		//-------------------------------------
		//	Set action if submit 
		//-------------------------------------
		$('#export').click(function(){
			//alert("export");
			getReport(0);	
		})

		//--------------------------------------------
		//	Function to get ajax content of report
		//--------------------------------------------
		function getReport(ex){
			var start = $('#START').val();
			var end = $('#END').val();
			var id = '';
			//var id = '<?php echo $id = ($this->session->userdata('USER_LEVEL')=='SALES')?$this->session->userdata('ID'):0; ?>';
			var id = '16622';
			
			if( id!=0 ){
				id = id; 
			}else id = $('#ID').val();
			
			
			
				if(ex == 0){
					
					if(id ==0){alert('NPP tidak boleh kosong');}
					else
					if(start == ''){alert('Tanggal mulai tidak boleh kosong');}
					else
					if(end == ''){alert('Tanggal akhir tidak boleh kosong');}
					else{
					//---------------------------	
					<?php $type =  (isset($type))?$type:0; ?>
					/*
					alert(start);
					alert(end);
					alert(id);
					*/
				var urls = '<?php echo site_url('/report/xlsPipeline/')?>/'+id + '/'+<?php echo $type ?>+ '/' +start+'/'+end; 
//				var urls = '<?php echo site_url('/db/tabel/')?>'; 
/*

					$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
					$("#report").load(urls)
*/
//				var urls = '<?php echo site_url('/tes/tabel/')?>';
//				var urls = '<?php echo site_url('/report/getcc/')?>/'+id +'/'+<?php echo $type ?>+'/'+start+'/'end; 

				$("#report").load(urls);
				//alert("alert get respon 0");
					//---------------------------					
					}
			
				}
			
		}		
		
		
		
		
	});
	

/*

	$(function() {
	
		//-------------------------------------
		//	Set active tabbed window
		//-------------------------------------		
		$(function() { $("#tabs").tabs(); });
		
		//-------------------------------------
		//	Set datepicker
		//-------------------------------------	
		$("#START").datepicker({
			//showOn: 'button',
			//buttonImage: '<?php echo ICONS ?>calendar.gif',
			//buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#START').datepicker('option', {dateFormat: 'd-M-yy'});
		
		$("#END").datepicker({
			//showOn: 'button',
			//buttonImage: '<?php echo ICONS ?>calendar.gif',
			//buttonImageOnly: true,
			changeMonth: true,
			changeYear: true
		});
		$('#END').datepicker('option', {dateFormat: 'd-M-yy'});
		
		
		//-------------------------------------
		//	Set action if submit 
		//-------------------------------------
		$('#submit').click(function(){
			getReport(0);	
		})
		
		//-------------------------------------
		//	Set action if export 
		//-------------------------------------
		$('#export').click(function(){
			getReport(1);			
		})
		
		//--------------------------------------------
		//	Function to get ajax content of report
		//--------------------------------------------
		function getReport(ex){
			var start = $('#START').val(); 
			var end = $('#END').val(); 
			var id = '';
			var id = '<?php echo $id = ($this->session->userdata('USER_LEVEL')=='SALES')?$this->session->userdata('ID'):0; ?>';
			var staging = $('#STAGING').val();
			
			if( id!=0 ) { id = id; }
			else id = $('#ID').val();
			
			var msg = '';
			if(id == 0) {msg += 'NPP tidak boleh kosong \n';}
			if(start == '') {msg += 'Tanggal mulai tidak boleh kosong \n';}
			if(end == ''){msg +='Tanggal akhir tidak boleh kosong';}
					
			<?php $type =  (isset($type))?$type:0; ?>
			
			if(msg){alert(msg); return false;}
			else {
				//alert(start+' s/d '+end);
				if(ex == 0){
					var urls = '<?php echo site_url('/report/getPipeline/')?>/'+id + '/'+staging + '/' +start+'/'+end; 
					$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
					$("#report").load(urls)
				} else {
					var urls = '<?php echo site_url('/report/xlsPipeline/')?>/'+id + '/'+staging +'/'+start+'/'+end;  
					//alert(urls);
					window.location = urls;
				}
			}
		}
		
	
	//------------------------------------------------
	//	Choose SALES ID from dialog box if clicked
	//------------------------------------------------
	<?php if(! isset($data)){ ?>
		$('#ID').click(function(){			
			$('#search').dialog('open');
			
		});	
		$('#USER_NAME').click(function(){			
			$('#search').dialog('open');
		});			
	<?php } ?>
	
	//------------------------------
	//	Search jQuery Dialog Box
	//------------------------------
	$("#search").dialog({
		width		: 500,
		height		: 550,
		modal		: true,
		autoOpen	: false,
		buttons		: {'Close'	: function(){$(this).dialog('close');} }
	});

	//------------------------------------
	//	Show all select if dialog close
	//------------------------------------
	$( "#search" ).dialog({
  	 	close: function(event, ui) { $('select').show(); }
	});
	
});


//-------------------------------------
//	Choose SALES ID from dialog box
//-------------------------------------
function pilih_data(com,grid)
	{
		if (com=='Pilih')
			{
			   if($('.trSelected',grid).length>0 && $('.trSelected',grid).length<2) {
					// to provide value in ie 6 suck
					var arrData = getSelectedRow();
					var nama = arrData[0][1].toUpperCase();
					$('#ID').val(arrData[0][0]);
					$('#USER_NAME').val(nama);
					$('#SALES_TYPE').val(arrData[0][2]);
					$('#search').dialog('close');
				}  else { alert('Pilih satu data saja !'); }	
			}          
	}

//------------------------------------------
//	Get selected row value from flexygrid
//------------------------------------------			
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



*/	
</script>

<!---=====================================--->

        <div class="row">
          <div class="col-xs-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><strong>STAGING PIPELINE</strong></a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 -->
                <div class="tab-pane active" id="tab_1">
		
                    <form style="margin:10px" action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
                        <table class="table-responsive table-condensed" width="" cellspacing="5" cellpadding="5" border="0">

              <?php 
			  		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
					if($lvl <> 'SALES') {
			  ?>						
                        <tbody>
                        <tr>
                            <td align="left">NPP </td>
                	        <td colspan="4">&nbsp;
								<input name="ID" id="ID" type="text" size="20" readonly="readonly" class="input">
                            </td>
                        </tr>
						<tr>
						<td align="left">NAMA : </td>
						<td colspan="4">&nbsp;
						<input name="USER_NAME" id="USER_NAME" type="text" size="20" readonly="readonly" class="input">
						</td>
						</tr>
						<tr>
						<td align="left">SALES TYPE : </td>
						<td colspan="4">&nbsp;
						<input name="SALES_TYPE" id="SALES_TYPE" type="text" size="20" readonly="readonly" class="input">
						</td>
						</tr>
				  <?php } ?>
				  
			  <tr>
              	<td align="left">STAGING: </td>
              	<td colspan="4">&nbsp;
                	<select name="STAGING" id="STAGING">
					<option value=1>LEADS</option>
					<option value=2>CALLS</option>
					<option value=3>OPPORTUNITY </option>
					<option value=4>APPOINTMENT</option>
					<option value=5>APPLICATION</option>
					<option value=6>APPROVAL</option>
					<option value=7>ACCEPTANCE</option>
					<option value=8>DRAWDOWN</option>
					</select>
                </td>
              </tr>
				  
				  
						<tr>
						<td align="left">PERIODE : </td>
						<td>&nbsp; <input name="START" id="START" type="text" size="20" readonly="readonly" class="input"></td>
						<td>to <input name="END" id="END" type="text" size="20" readonly="readonly" class="input"></td>
					<!--
						<td><input name="submit" id="submit" type="button" value="Generate"></td>
					-->	
						<td><input name="export" id="export" type="button" value="Export to XLS"></td>
					    </tr>
					<!-----------
                        <tr>
                	          <td align="left">PERIODE </td>
                              <td>&nbsp; <input name="START" id="START" size="20" readonly="readonly" class="input hasDatepicker" type="text"></td>
                              <td>to <input name="END" id="END" size="20" readonly="readonly" class="input hasDatepicker" type="text"></td>
                              <td><input name="submit" class="btn btn-primary" id="submit" value="Generate" type="button"></td>
                              <!--td><input name="export" id="export" type="button" value="Export to XLS"></td>
                        </tr>
------->
                        </tbody>
						</table>
                    </form>
					<br><br>

					
<!---
					</table>
					</div><br/> 
--->					
					<div id="report" class="text-center">Silahkan isi range periode report</div>	
                </div>
                <!-- end tab1 -->
                <!-- /.tab-pane -->

                <!-- tab2 -->
                <!-- <div class="tab-pane" id="tab_2">
                  The European languages are members of the same family. Their separate existence is a myth.
                  For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                  in their grammar, their pronunciation and their most common words. Everyone realizes why a
                  new common language would be desirable: one could refuse to pay expensive translators. To
                  achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                  words. If several languages coalesce, the grammar of the resulting language is more simple
                  and regular than that of the individual languages.
                </div> -->
                <!-- end tab2 -->
                <!-- /.tab-pane -->

                <!-- tab3 -->
                <!-- <div class="tab-pane" id="tab_3">
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                  Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                  when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                  It has survived not only five centuries, but also the leap into electronic typesetting,
                  remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                  sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                  like Aldus PageMaker including versions of Lorem Ipsum.
                </div> -->
                <!-- end tab3 -->
                <!-- /.tab-pane -->

              </div>
              <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
          </div>
          <!-- /.col -->

    <div id="search" title="SALES DATA">
		<?php echo $js_grid; ?><table id="search_list" style="display:none"></table>
    </div>		  

        </div>
         <!-- / end class .row -->
<!---=====================================--->		

<!----
<div id='content_x'>
	<div id="tabs">
        <ul>
            <li>
            	
            	<a href="#tabs-1">HASIL PENJUALAN KARTU KREDIT</a>
            </li>
        </ul>
        <div id="tabs-1">
            <form action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
            <table width="" border="0" cellspacing="5" cellpadding="0">
              <?php 
			  		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
					if($lvl <> 'SALES') {
			  ?>
              <tr>
              	<td align="left">NPP : </td>
              	<td colspan="4">&nbsp;
                	<input name="ID" id="ID" type="text" size="20" readonly="readonly" class="input">
                </td>
              </tr>
              	
              <tr>
                <td align="left">NAMA : </td>
              	<td colspan="4">&nbsp;
                	<input name="USER_NAME" id="USER_NAME" type="text" size="20" readonly="readonly" class="input">
                </td>
              </tr>
              <tr>
              	<td align="left">SALES TYPE : </td>
              	<td colspan="4">&nbsp;
                	<input name="SALES_TYPE" id="SALES_TYPE" type="text" size="20" readonly="readonly" class="input">
                </td>
              </tr>
              <?php } ?>
              <tr>
              	<td align="left">PERIODE : </td>
                <td>&nbsp; <input name="START" id="START" type="text" size="20" readonly="readonly" class="input"></td>
                <td>to <input name="END" id="END" type="text" size="20" readonly="readonly" class="input"></td>
                <td><input name="submit" id="submit" type="button" value="Generate"></td>
                <!--td><input name="export" id="export" type="button" value="Export to XLS"></td>
              </tr>
            </table>
            </form>
            <br />
            <div id='report'>Silahkan isi range periode report</div>
         </div>
	</div>
    
    <div id="search" title="SALES DATA">
		<?php echo $js_grid; ?><table id="search_list" style="display:none"></table>
    </div>

</div><!-- close div content -->
<!--
</td>
</tr>
</table>
---->

<!----===============================---->
</section>
<!----===============================---->

<script type="text/javascript">
<?php 
	$level 	= $_SESSION['USER_LEVEL'];
	$i		= 1;
	$html 	= "\$(function(){\$( '#accordion' ).accordion({ active:$i});});";
	echo $html;
?>
</script>
<?php $this->load->view('default/footer') ?>