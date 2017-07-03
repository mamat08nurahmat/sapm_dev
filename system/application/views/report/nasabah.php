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

$(document).ready(function(){
	
	
/*
	$(function() {
$("#btnSubmit").click(function(){
        alert("button");
    });  
*/

$('#submit').click(function(){
			getReport(0);	
		})
		
		$('#list').click(function(){
			getReport(1);
		})
		
		$('#base').click(function(){
			getReport(2);
		})
        

		function getReport(ex){

			var year = '<?php echo date('Y');?>';
			var bulan = '<?php echo date('n');?>';
			var month = $('#MONTH').val(); 
			var product =$('#PRODUCT').val();
			var tipe = $('#TIPE').val();
			//var id = '<?php echo $this->session->userdata('ID'); ?>';
			//var id = '24660';
			var id = '16622';
/*-------
*/
			
			if(ex == 0){
				var urls = '<?php echo site_url('/report/get_nasabah_tab/')?>/'+id + '/' +month + '/' +product+ '/' +tipe;
				$("#report").load(urls);
				//alert("alert get respon 0");
				
			
			} else if (ex == 1){
//				alert("alert list get respon 1");
				var urls = '<?php echo site_url('/report/get_list_nasabah/')?>/'+id;
				$("#report").load(urls);
			/*
				var urls = '<?php echo site_url('/report/get_list_nasabah/')?>/'+id; 
				//alert(urls);
				$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
				$("#report").load(urls)
			*/	
				
			} else if (ex == 2){
//				alert("alert base get respon 2");
				var urls = '<?php echo site_url('/report/get_baseline/')?>/'+id;
				$("#report").load(urls);

			/*
				var urls = '<?php echo site_url('/report/get_baseline/')?>/'+id + '/' +year + '/' +bulan; 
				//alert(urls);
				$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
				$("#report").load(urls)
			*/	
			}
		}

});



/*
	$(function() {
	
		//set tabbed windows
		
		$(function() { $("#tabs").tabs(); });
		//set numeric only in input box	
	
		//------------------------------------
		//	Button Action
		//------------------------------------		
		$('#submit').click(function(){
			getReport(0);	
		})
		
		$('#export').click(function(){
			getReport(1);			
		})
		
		$('#list').click(function(){
			getReport(2);			
		})
		
		$('#base').click(function(){
			getReport(4);			
		})
		
		function getReport(ex){
			var year = '<?php echo date('Y');?>';
			var bulan = '<?php echo date('n');?>';
			var month = $('#MONTH').val(); 
			var product =$('#PRODUCT').val();
			var tipe = $('#TIPE').val();
			var id = '<?php echo $this->session->userdata('ID'); ?>';
			//var id = '24660';
			if(ex == 0){
				var urls = '<?php echo site_url('/report/get_nasabah_tab/')?>/'+id + '/' +month + '/' +product+ '/' +tipe;
				$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
				$("#report").load(urls)
			} else if ( ex == 1) {
				//var urls = '<?php echo site_url('/report/xls_nasabah/')?>/'+id + '/' +month; 
				//alert(urls);
				//$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>exporting data to xls, please be patient ... </span>");
				//window.location = urls;
				//$("#report").html("Silahkan isi periode report");
			} else if ( ex == 4) {
				var urls = '<?php echo site_url('/report/get_baseline/')?>/'+id + '/' +year + '/' +bulan; 
				//alert(urls);
				$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
				$("#report").load(urls)
			} 
			else {
				var urls = '<?php echo site_url('/report/get_list_nasabah/')?>/'+id; 
				//alert(urls);
				$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
				$("#report").load(urls)
				//window.location = urls;
			}
			
		}
		
	});
*/
</script>


<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> 
                    REPORT <strong>PERFORMANCE</strong>
    </div>
</section>	

    <!-- Main content -->
   	<section class="content">
 <!-- Custom Tabs -->
        <div class="row">
          <div class="col-xs-12">
	
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">NASABAH KELOLAAN</a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 -->
                <div class="tab-pane active" id="tab_1">
		
                    <form style="margin:10px" action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
					
<!---
<input  id="export" name="export"  type="button" value="Export">
<input  id="oldperformance" name="oldperformance"  type="button" value="Old Performance">
-->
					
					
            <table class="table-responsive table-condensed" width="" cellspacing="5" cellpadding="5" border="0">
                   <tbody>
                     <tr>
						
                        <td align="left">
						<select name='TIPE' id='TIPE'>
                    	<option value="0">CR</option>
                        <option value="1">BB</option>
						<!--<option value="2">Yesterday Flagging</option>
						<option value="3">Last Month Flagging</option>-->
						</select>
						</td>
						<td align="left">
						<select name='PRODUCT' id='PRODUCT'>
                    	<option value="1">Giro</option>
                        <option value="2">Tabungan</option>
						<option value="3">Deposito</option>
						<option value="4">Investasi</option>
						<option value="5">Bancas</option>
						<option value="6">AUM</option>
						<!--<option value="2">Yesterday Flagging</option>
						<option value="3">Last Month Flagging</option>-->
						</select>
						<td align="left">
						<select name='MONTH' id='MONTH'>
                    	<option value="0">Yesterday All</option>
                        <option value="1">Last Month All</option>
						<!--<option value="2">Yesterday Flagging</option>
						<option value="3">Last Month Flagging</option>-->
						</select>	                	    
                         </td>
						<td>
						<input name="submit" id="submit" type="button" value="Generate">
						</td>
                <!--td><input name="export" id="export" type="button" value="Export to XLS"--></td>
						<td>
						<input name="list" id="list" type="button" value="CIF Nasabah Kelolaan">
						</td>
						<td>
						<input name="base" id="base" type="button" value="Baseline Kelolaan">
						</td>
						
				  </tr>
              </tbody>
			</table>
                    </form>
					<br><br>

					
<!---
					</table>
					</div><br/> 
--->					
<?php
?>
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


        </div>
         <!-- / end class .row -->

</section>



<!------------------------------------------------------------->
<?php $this->load->view('template/js') ?>	
<?php $this->load->view('template/footer') ?>	
