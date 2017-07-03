<?php $this->load->view('default/header') ?>		

<td  valign="top" align="left">
<div id='content_x'>

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});

//$( "#accordion" ).accordion({ active:1 });

function del2(com,grid)
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
           if($('.trSelected',grid).length>0){
			   if(confirm('Delete ' + $('.trSelected',grid).length + ' items?')){
		            var items = $('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
						itemlist+= items[i].id.substr(3)+",";
					}
					$.ajax({
					   type: "POST",
					   url: "<?php echo site_url("/target_ajax/delete");?>",
					   data: "items="+itemlist,
					   success: function(data){
					   	$('#target_list').flexReload();
					  	alert(data);
					   }
					});
				}
			} else {
				return false;
			} 
        }          
}

function del(com,grid)
{
    if (com=='Delete')
        {
           if($('.trSelected',grid).length>0 && $('.trSelected',grid).length<2) {
			var arrData = getSelectedRow();
			var id 		= arrData[0][0];
			var year 	= arrData[0][3];
			var nama	= arrData[0][1];
			
			var ok = '';
			var warning ='';
			
			warning = confirm('Menghapus target akan menghapus data pencapaian dan performance sales tersebut, pastikan pencapaian dan performancenya sudah dibackup.Jika terjadi perubahan jenis Sales, lakukan delete target pada posisi lama sales');
			ok = confirm('Benar ingin menghapus data target : '+id+' '+nama+' '+year+'?');
			if(ok)
			{
				$.ajax({
						   type: "POST",
						   url: "<?php echo site_url("/target_ajax/delete");?>",
						   data: "id="+id+'&'+'year='+year,
						   success: function(data){
								$('#target_list').flexReload();
								alert(data);
						   }
						});
				}
        	}  else { alert('Pilih satu data saja !'); }
		}       
}


function sel(com,grid)
{
    if (com=='Select All')
    {
		$('.bDiv tbody tr',grid).addClass('trSelected');
    }
    
    if (com=='DeSelect All')
    {
		$('.bDiv tbody tr',grid).removeClass('trSelected');
    }
} 


function view(com,grid)
{
    if (com=='View')
        {
           if($('.trSelected',grid).length>0 && $('.trSelected',grid).length<2) {
			  
			var arrData = getSelectedRow();
			var id 		= arrData[0][0];
			
			var items = $('.trSelected',grid);
			//var itemlist =items[0].id.substr(3);
			var urls = '<?php echo site_url("/berita/view")?>'+'/'+id;
			window.location = urls ; 
			} else { alert('Pilih satu data saja !'); }
        }       
}

function edit(com,grid)
{
    if (com=='Edit')
        {
           if($('.trSelected',grid).length>0 && $('.trSelected',grid).length<2) {
			  
			var arrData = getSelectedRow();
			var id 		= arrData[0][0];
			
			var items = $('.trSelected',grid);
			//var itemlist =items[0].id.substr(3);
			var urls = '<?php echo site_url("/berita/edit")?>'+'/'+id;
			window.location = urls ; 
			} else { alert('Pilih satu data saja !'); }
        }          
}

function add(com,grid)
{
    if (com=='Add')
        {
			var urls = '<?php echo site_url("/berita/add")?>';
			window.location = urls ; 
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

</script>
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> List Berita
    </div>


    <div id="tabs">
        <ul>
        	<li><a href="#tabs-1">List Berita</a></li>
        </ul>       
        <div id="tabs-1"><?php echo $js_grid ; ?><table id="berita_list" style="display:none"></table></div>
    </div>
</div>

</td>
          </tr>
        </table>	

<script type="text/javascript">
$(function(){
	$( "#accordion" ).accordion({ active:3});
});	
</script>

<?php $this->load->view('default/footer') ?>