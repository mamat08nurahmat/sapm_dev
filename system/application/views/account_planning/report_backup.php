<?php $this->load->view('default/header') ?>	

    <!-- Main content -->
   	<section class="content2">


<script type="text/javascript">
$(document).ready(function(){
	

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

	var year = $('#YEAR').val();
	var month = $('#MONTH').val();
	var id = $('#ID').val();
	var msg = '';
	if ($('#ID').val() == '') {
	msg += 'NPP tidak boleh kosong \n';
	}
		
			if(ex == 0){
//alert('Generate Clickxxxx');

	if (msg) {
		alert(msg);
		return false;
		}
		
//var urls = '<?php echo site_url('/db/tabel/')?>';			

var urls = '<?php echo site_url('/account_planning/get_report_new/')?>/'+id+ '/' +month+ '/' +year;			
$("#report_msg").load(urls);



// $("#report").append(table);     // Append new elements
//var urls = '<?php echo site_url('/report/get_news/')?>'; 
//$("#report").load(urls);

//$("#report").load('<?php echo site_url('/report/get_news/')?>');

//var urls = '<?php echo site_url('/report/get_performance_new/')?>/'+16622+ '/' +month+ '/' +year;			
//var urls = '<?php echo site_url('/report/get_performance_new/16622/1/2017')?>';			

/*
var urls = '<?php echo site_url('/report/get_performance_new/')?>/'+id+ '/' +month+ '/' +year;			
$("#report").load(urls);
*/

			/*
				if(year>=2017&&(salestype=='ANALIS PENJUALAN CR'||salestype=='ASISTEN PENJUALAN'))
					{
						var urls = '<?php echo site_url('/report/get_performance_new/')?>/'+id+ '/' +month+ '/' +year; 
					}
					else if(year>=2017&&month>=2&&(salestype=='SRM'||salestype=='CRO MGR'||salestype=='CRO AMGR'))
					{
						var urls = '<?php echo site_url('/report/get_performance_new/')?>/'+id + '/' + month + '/' +year; 
					}
					else if(year==2017&&month==1&&(salestype=='SRM'||salestype=='CRO MGR'||salestype=='CRO AMGR'))
					{
						var urls = '<?php echo site_url('/report/get_performance_new/')?>/'+id + '/' + month + '/' +year; 
					}
					else
					{
						var urls = '<?php echo site_url('/report/get_performance_new/')?>/'+id + '/' + month + '/' +year; 
					} 
				$("#report").html("<img src='<?php echo LOAD ?>'> <span style='color:#080'>loading</span>");
				$("#report").load(urls);
			*/	
				
			} else if (ex == 1){
				alert("alert get respon 1");
			/*
				var urls = '<?php echo site_url('/report/xls_performance/')?>/'+id + '/' + month + '/' +year; 
				//alert(urls);
				window.location = urls;
			*/	
				
			} else {
			alert("alert get respon else");
			/*
				var urls = '<?php echo 'http://brftst.bni.co.id/sapm_prod/index.php/report/performance'?>'; 
				//alert(urls);
				window.location = urls;
			*/	
			}
		}

});


</script>



<!------------------------------>
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> 
                    REPORT <strong>PERFORMANCE</strong>
    </div>
</section>	
<!------------------------------>

<!---
<p>This is a paragraph.</p>
<button onclick="appendText()">Append text</button>
-->

        <div class="row">
          <div class="col-xs-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">REPORT PERFORMANCE</a></li>
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
							<td align="left">NPP</td>
							<td>:</td>
							<td colspan="4">
								<input name="ID" id="ID" type="text" size="20" readonly="readonly" class="input" value="<?php echo $_SESSION['ID'] ?>" >
							</td>
						</tr>

						<tr>
							<td align="left">NAMA</td>
							<td>:</td>
							<td colspan="4">
								<input name="USER_NAME" id="USER_NAME" type="text" size="20" readonly="readonly" class="input"  value="<?php echo $_SESSION['USER_NAME'] ?>"  >
							</td>
						</tr>
						<tr>
							<td align="left">SALES TYPE</td>
							<td>:</td>
							<td colspan="4">
								<input name="SALES_TYPE" id="SALES_TYPE" type="text" size="20" readonly="readonly" class="input" value="<?php echo $_SESSION['SALES_TYPE'] ?>" >
							</td>
						</tr>
						
                        <tr>
                            <td align="left">PERIODE </td>
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
                	<td colspan='2'>&nbsp;</td>
                	<td>
					<input name="submit" id="submit" type="button" value="Generate"> &nbsp; 
					<input name="export" id="export" type="button" value="Export to XLS">&nbsp    

<!---
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>
-->					

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
				<div id='report_msg'>Silahkan pilih sales untuk mengenerate report</div>

<!---
					</table>
					</div><br/> 
--->					
<?php
?>
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
<!--
    <div id="search" title="SALES DATA">
<?php echo $js_grid; ?><table id="search_list_user" style="display:none"></table>
    </div>		  
-->		  

		  

        </div>
         <!-- / end class .row -->
	
		

<!----===============================---->
</section>
<!----===============================---->

<!-- Button trigger modal 
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>
-->

<!-- Modal 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="save"class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
-->




<script type="text/javascript">
$('#save').on('click', function() {
/*
	var value = 999999 ;
	$('#ID').val(value);
	$('#myModal').modal('hide');
*/	
alert("XXXXXXXXXXX");	
});


<?php
$level = $_SESSION['USER_LEVEL'];
$i = 7;
$html = "\$(function(){\$( '#accordion' ).accordion({ active:$i});});";
echo $html;

?>
</script>
<?php $this->load->view('default/footer') ?>