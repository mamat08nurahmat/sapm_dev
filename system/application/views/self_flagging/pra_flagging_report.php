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
	<script type="text/javascript">
$(function(){
	
	$("#report").load("<?php echo site_url('/self_flagging/detail_report/') ?>", function() {

	}); //}); });
	

});
	
/*
	$(function() {
	//-------------------------------------
		//	Set active tabbed window
		//-------------------------------------		
		$(function() { $("#tabs").tabs(); });
		
		$( "#detail_spv" ).dialog({
			autoOpen :false,
			modal : true,
				height: 'auto',
				width: 'auto',
		});
		
		$(window).load(function(){
		var salesid = <?php echo $_SESSION['ID']?>;
			var urls = '<?php echo site_url('/self_flagging/detail_report/')?>/'; 
					$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
					$("#report").load(urls);	
		})		
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
		
		function kirimsales()
		{
			var id = $('#ID').val();;
			
			if( id!=0 ) { id = id; }
			else id = $('#ID').val();
			
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
				var urls = '<?php echo site_url('/self_flagging/detaildetail_report/')?>/'+npp; 
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
*/	
	
	</script>


<!------------------------------>
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> 
                    <strong>FLAGGING</strong>
    </div>
</section>	
<!------------------------------>
    <!-- Main content -->
   	<section class="content">


        <div class="row">
          <div class="col-xs-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">FLAGGING</a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 -->
                <div class="tab-pane active" id="tab_1">
		
				<div id='report'>
				<div id='report1'></div>
				<div id='detail_spv'></div>
				</div>
		
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


        </div>
         <!-- / end class .row -->
		



</section>
<!-- /.content -->


<!------------------------------------------------------------->
<?php $this->load->view('template/js') ?>	
<?php $this->load->view('template/footer') ?>	



