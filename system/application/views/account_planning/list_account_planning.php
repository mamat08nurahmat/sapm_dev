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
			$(document).ready(function() {
				getDataNasabahUsulan();
							
				
			});

		function getDataNasabahUsulan()
		{
			var id = <?php echo $_SESSION['ID'] ?>;
			<?php 
				$day=date('d');
				if($day >= 1 and $day <=6)
			{
			?>
			var month = <?php echo date('m') ?>;
			<?php
			}else{
			?>
			var month = <?php echo date('m') ?> + 1;
			<?php
			}
			?>
			var year = <?php echo date('Y')?>;
/*
			var urls = '<?php echo site_url('/account_planning/get_ap/') ?>/' + id +'/'+month+'/'+year;
			$("#report_msg").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
			$("#report_msg").load(urls);
*/			
//var urls = '<?php echo site_url('/db/tabel/')?>';		
//---->>> month = 2	
var urls = '<?php echo site_url('/account_planning/get_ap/')?>/'+id+ '/' +2+ '/' +year;			
$("#report_msg").load(urls);
		}
		
	
	
			

			//------------------------------------------------
			//	Tambah Nasabah Usulan
			//------------------------------------------------
				$('#add_ap').live('click', function() {
					alert("XXXXXXXXXXXXXXX");
					//window.location ="<?php echo site_url('/activity/add_account_planning') ?>";
				});
			
			
</script>

<!------------------------------>
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> 
                     <strong>Usulan Account Planning</strong>
    </div>
</section>	
<!------------------------------>



    <!-- Main content -->
   	<section class="content">


<!---
<p>This is a paragraph.</p>
<button onclick="appendText()">Append text</button>
-->

        <div class="row">
          <div class="col-xs-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Usulan Account Planning</a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 -->
                <div class="tab-pane active" id="tab_1">
				
			<div id='report_msg'></div>
			

					
					
					
					


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

				
				

<!--
    <div id="search" title="SALES DATA">
<?php //echo $js_grid; ?><table id="search_list" style="display:none"></table>
    </div>
		<div id="dialog-form" title="ALASAN REJECT">
			<form>
				<fieldset>
					<textarea rows="5" cols="45" id="alasan" name="alasan"></textarea>
					<input type="hidden" name="rcif" id="rcif"/>
				</fieldset>
			</form>
		</div>
-->
				
				
				
				
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
          </div>
          <!-- /.col -->


        </div>
         <!-- / end class .row -->
		

<!----===============================---->
</section>
<!----===============================---->

<script type="text/javascript">
function get_month(v){
	 var bulan = {	'1':'Januari', '2':'Februari', 
'3':'Maret', '4':'April',
                                        '5':'Mei', '6':'Juni', '7':'Juli', '8':'Agustus',
                                        '9':'September', '10':'Oktober', '11':'November', '12':'Desember'};
	var html='';
	if(v==2015){
			for(x=8;x<=12;x++)
			{
				html+='<option value="'+x+'">'+bulan[x]+'</option>';
			}
		}
	else if(v>=2016){
			for(x=1;x<=12;x++)
			{
				html+='<option value="'+x+'">'+bulan[x]+'</option>';
			}
		}
	
	$('#MONTH').html(html);
}	
</script>

<!------------------------------------------------------------->
<?php $this->load->view('template/js') ?>	
<?php $this->load->view('template/footer') ?>