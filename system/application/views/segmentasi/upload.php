<?php $this->load->view('default/header') ?>	
<td  valign="top" align="left">

<script type="text/javascript">
	$(function() {
		//------------------------------------
		//	set tabbed windows	
		//------------------------------------	
		$(function() { $("#tabs").tabs(); });

		$('#upload').click(function(){$('#frmUpload').submit();})
	});
</script>


<div id='content_x'>
	<div id="tabs">
        <ul>
            <li><a href="#tabs-1">DOWNLOAD DATA SEGMENTASI</a></li>
            <!-- <li><a href="#tabs-2">DATA UPLOADED</a></li> -->
        </ul>
        <div id="tabs-1">
			
            <!--div id='report' style="text-align:center; background:#efe"></div>
			<br /-->
			<?php echo $js_grid; ?>
			<table id="result_list" style="display:none"></table>
			<br />
			
		</div>
        
        <!-- 
		<div id="tabs-2">
        	<?php #echo $js_grid; ?>
			<table id="result_list" style="display:none"></table>            
        </div> 
		-->
	</div>

</div><!-- close div content -->

<div id='process'  style="display:none;">
	<div align='center'>Procesing data<br /><br />Please close after finish.</div>
</div>

</td>
</tr>
</table>
<script type="text/javascript">

function hideAnchor(itm){
	/*var text=$(itm).html();
	var p=$(itm).parent();
	$(itm).remove();
	p.append(text); */
	//$('#result_list').flexReload();
	//$('#report').html(data);
	//$("#flexigrid")[0].grid.populate()
$.ajax({
								type: "POST",
								url: "<?php echo site_url("");?>",
								data: "items=",
								success: function(data)
									{
										$('#result_list').flexReload();
										$('#report').html(data);
									}
							});
}

function del(com,grid)
{
    if (com=='Select All')
    {
		$('.bDiv tbody tr',grid).addClass('trSelected');
    }
    
    if (com=='DeSelect All')
    {
		$('.bDiv tbody tr',grid).removeClass('trSelected');
    }
    
    if (com=='Delete')
	{
		if($('.trSelected',grid).length>0)
			{
				if(confirm('Delete ' + $('.trSelected',grid).length + ' items?'))
					{
						var items = $('.trSelected',grid);
						var itemlist ='';
						for(i=0;i<items.length;i++)
							{
								itemlist+= items[i].id.substr(3)+",";
							}
						$.ajax({
								type: "POST",
								url: "<?php echo site_url("/csv/delete");?>",
								data: "items="+itemlist,
								success: function(data)
									{
										$('#result_list').flexReload();
										$('#report').html(data);
									}
							});
						}
						} else {
							return false;
					} 
			}          
	}


function proses(com,grid)
{
    if (com=='Proses')
		{
		   if($('.trSelected',grid).length == 1) 
			   {
					
					var arrData = getSelectedRow();
					var id 	= arrData[0][0];
					var status 	= arrData[0][3];
					if(status.match("UPLOADED") != 'UPLOADED'){
						$('#process').dialog('open');
						var urls  = '<?php echo site_url("/csv/do_proses")?>'+'/'+id;
						window.location = urls ;
					} else {
						alert('File telah diproses, silahkan pilih file dengan status NEW'); 	
					}
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

$('#process').dialog({
			width		: 300,
			height		: 150,
			modal		: true,
			autoOpen	: false,
			buttons		: 	{
								'Close'	: function(){
									$('#result_list').flexReload();
									$(this).dialog('close'); 									
									$('#report').html('<span style=\"color:green\">Process completed</span>');
								}							
							}
		});


$(function(){
	$( "#accordion" ).accordion({ active:1});
});	
</script>
<?php $this->load->view('default/footer') ?>