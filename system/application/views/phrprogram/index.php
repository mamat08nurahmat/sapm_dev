<?php
	$this->load->view('layout_phr_nasabah/header.php'); 	
?>
	<!-- jQuery Flexigrid -->
	<link href="<?php echo CSS.'flexigrid.css' ?>" rel="stylesheet" type="text/css" />  
	<script type="text/javascript" src="<?php echo JQ ?>"></script> 
	<script type="text/javascript" src="<?php echo JUI ?>"></script>
	<script type="text/javascript" src="<?php echo JSFLEX ?>"></script>
	<script type="text/javascript" src="<?php echo JSNUM?>"></script>
	<script type="text/javascript" src="<?php echo JSMON?>"></script>
	<script type="text/javascript" src="<?php echo JS ?>number_format.js"></script>
	<!-- jQuery Flexigrid -->
	
      
        
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
				
				<script type="text/javascript">
   
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
							var id      = arrData[0][0];
							var nama	= arrData[0][1];
							
							var konfirmasi = '';
							
							var items = $('.trSelected',grid);

								konfirmasi = confirm('Apakah anda ingin menghapus program : '+nama+'?');
								
								if (konfirmasi){
									//var itemlist =items[0].id.substr(3);
									var urls = '<?php echo site_url("/phr_program/del_program")?>'+'/'+id;
									window.location = urls ; 
								}

							
							} else { 
								alert('Pilih satu data saja !'); 
							}
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
								var id      = arrData[0][0];
								
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
								var id      = arrData[0][0];
								
								var items = $('.trSelected',grid);
								//var itemlist =items[0].id.substr(3);
								var urls = '<?php echo site_url("/phr_program/edt_program")?>'+'/'+id;
									window.location = urls ; 
								} else { 
									alert('Pilih satu data saja !'); 
								}
							}          
					}

					function add(com,grid)
					{
						if (com=='Add')
						{
							var urls = '<?php echo site_url("/phr_program/add_program")?>';
							window.location = urls; 
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

				</script><br />
				<?php
					$pesan = $this->session->flashdata('pesan');
					if (! empty($pesan)){
						echo $pesan;
					}
				?>
				 <div class="panel panel-default">	
					<div class="panel-heading" style="background-color:#8FC0D8; color:#fff;"><STRONG>LIST PROGRAM</STRONG></div>
					<?php echo $js_grid; ?>
					<table id="result_list" style="display:none"></table>
				 </div>
                </div>
            </div>
        </div>
  
 <?php
	$this->load->view('layout_phr_nasabah/footer.php'); 	
?> 