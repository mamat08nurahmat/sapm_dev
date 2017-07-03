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
		//alert("submit");
			getReport(0);	
		})
		
		$('#export').click(function(){
			getReport(1);
            //alert("export");
		})
		
		$('#oldperformance').click(function(){
			getReport(2);
            //alert("oldperformance");
		})
        

		function getReport(ex){
//    var table = "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'><tr><td>NO</td><td>NAMA</td></tr><tr><td>99999</td><td>XXXX</td></tr><table>";              // Create text with HTML
			
			var month 	= $('#MONTH').val(); 
			var year 	= $('#YEAR').val(); 
			var msg 	= '';
			var id = '16622';
			//var id 		= '<?php echo $this->session->userdata('ID'); ?>';
			//var id = '24660';
//			var salestype= '<?php echo $_SESSION['SALES_TYPE'];?>';
			//var salestype= 'ASISTEN PENJUALAN';
/*
*/
			
			if(ex == 0){
var urls = '<?php echo site_url('/report/get_realisasi_new/')?>/'+id+ '/' +month+ '/' +year;			
$("#report").load(urls);
/*
*/				

			
//alert('Generate Clickxxxx');

/*
var urls = '<?php echo site_url('/report/getRealisasi/')?>/'+id+ '/' +year+ '/' +month;	
$("#report").load(urls);
*/

			/*
				
				
			*/	
				
			} else if(ex==1){
				var urls = '<?php echo site_url('/report/xlsRealisasi/')?>/'+id + '/' +month+'/'+year; 
				//alert(urls);
				window.location = urls;
			} else if(ex==2){
				var urls = '<?php echo 'http://brftst.bni.co.id/sapm_prod/pdf_report/realisasi_report.php?npp='?>'+id+'&m='+month;
				window.location = urls;
			} else {
				var urls = '<?php echo 'http://brftst.bni.co.id/sapm_prod/index.php/report/realisasi'?>';
				window.location = urls;
			}
			
		}

});


/*
	$(function() {
		//-----------------------------
		//	Set Active menu and tabs
		//-----------------------------
		$(function() { $("#tabs").tabs(); });
		
		//---------------------------
		//	Action on click
		//---------------------------
		$('#submit').click(function(){
			getReport(0);	
		})
		
		$('#export').click(function(){
			getReport(1);			
		})
		
		$('#pdf').click(function(){
			getReport(2);
		})
		$('#oldrealisasi').click(function(){
			getReport(3);
		})
		
		function getReport(ex){
			var year 	= $('#YEAR').val(); 
			var month 	= $('#MONTH').val(); 
			var msg 	= '';
			var id 		= '<?php echo $this->session->userdata('ID'); ?>';
					
			if(ex == 0){
				var urls = '<?php echo site_url('/report/getRealisasi/')?>/'+id + '/' +month+'/'+year; 
				$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
				$("#report").load(urls)
			} else if(ex==1){
				var urls = '<?php echo site_url('/report/xlsRealisasi/')?>/'+id + '/' +month+'/'+year; 
				//alert(urls);
				window.location = urls;
			} else if(ex==2){
				var urls = '<?php echo 'http://brftst.bni.co.id/sapm_prod/pdf_report/realisasi_report.php?npp='?>'+id+'&m='+month;
				window.location = urls;
			} else {
				var urls = '<?php echo 'http://brftst.bni.co.id/sapm_prod/index.php/report/realisasi'?>';
				window.location = urls;
			}
			
		}
		
	});
*/
</script>
<!------------------------------>
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> 
                    REPORT <strong>REALISASI</strong>
    </div>
</section>	
<!------------------------------>

    <!-- Main content -->
   	<section class="content">
        <!-- START CUSTOM TABS -->

<!-- main lama 
<td  valign="top" align="left">
 -->
        <div class="row">
          <div class="col-xs-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">REPORT REALISASI</a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 -->
                <div class="tab-pane active" id="tab_1">
		
                    <form style="margin:10px" action="<?php  ?>" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
                        <table class="table-responsive table-condensed" width="" cellspacing="5" cellpadding="5" border="0">
                        <tbody>
                        <tr>
                            <td align="left">Tahun </td>
                	        <td colspan="4">&nbsp;
                  	        <select name="YEAR" id="YEAR" onchange="get_month(this.value)">
                    	<?php 
							$date = getdate(strtotime(NOW));
							$year = $date['year'];
							for($i=($year-1);$i<=$year;$i++)
							{
								$selected = ($i == $year)?'selected':'';
								echo "<option value='$i' $selected>$i</option>\n";
							}
						?>
							</select>
							
                            </td>
                        </tr>

                        <tr>
                            <td align="left">Bulan </td>
                	        <td colspan="4">&nbsp;
					<?php 
                        $bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
                        $html  = '';
                        $html .= "<select name='MONTH' id='MONTH' style='width:110px'>";
                        for($i=1;$i<=12;$i++)
                        {
                            $html .= "<option value='$i'>".$bulan[$i]."</option>"; 	
                        }
                        $html .= "</select>";
                        echo $html;
                    ?>
							
                            </td>
                        </tr>

                <tr>
                	<td colspan='2' style="width:100px;">&nbsp;</td>
					<td style="width:400px"><input name="submit" id="submit" type="button" value="Generate"> &nbsp; 
					<input name="export" id="export" 
type="button" value="Export to XLS"> &nbsp; 
<input name="oldrealisasi" id="oldrealisasi" type="button" value="Realisasi Jan-Jul 2015"></td>
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


        </div>
         <!-- / end class .row -->

		
<!------------------------------>
</section>
 <!-- / end section class content -->

 <!--====================================================--->
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
 <!--====================================================--->
