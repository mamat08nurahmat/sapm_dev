
<?php $this->load->view('template/header') ?>	

<!---CUSTOM---->
		
<!---remove
<link href="http://192.168.3.14/new_sapm//public/css/layout.css" rel="stylesheet" type="text/css" />
-->		


<link href="http://192.168.3.14/new_sapm//public/css/flexigrid.css" rel="stylesheet" type="text/css" />
<link href="http://192.168.3.14/new_sapm//public/css/jui/1.8.4/redmond/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" />
<!---
<link href="http://192.168.3.14/new_sapm//public/css/jquery.numeric.css" rel="stylesheet" type="text/css" />
<link href="http://192.168.3.14/new_sapm//public/css/jquery.treeview.css" rel="stylesheet" type="text/css" />
<link href="http://192.168.3.14/new_sapm//public/css/smart_wizard.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="http://192.168.3.14/new_sapm//public/css/flipclock.css" />
---->


<!---
<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/jquery.numeric.pack.js"></script>
<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/jquery.maskMoney.js"></script>
<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/number_format.js"></script>
---->
<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/jquery-ui-1.8.4.custom.min.js"></script>

<script type="text/javascript" src="http://192.168.3.14/new_sapm//public/js/flexigrid.pack.js"></script>

<?php $this->load->view('template/topbar') ?>	
<?php $this->load->view('template/sidebar') ?>	
<!----------------------------------------------------->



<!-- =============================================== -->
	<script type="text/javascript">
		$(function() {

			//-------------------------------------
			//	Set active tabbed window
			//-------------------------------------		
			$(function() {
				$("#tabs").tabs();
			});

			//-------------------------------------
			//	Set action if submit 
			//-------------------------------------
			$('#submit').click(function() {
				//alert("Submit OK");
					getReport(0);
			})

			//-------------------------------------
			//	Set action if export 
			//-------------------------------------
			$('#export').click(function() {
				$('#report_msg').html("<img src='http://192.168.3.14/new_sapm//public/images/icons/loading.gif' alt='loading'> <span style='color:#080'>exporting report ...</span>");
				getReport(1);
			})


			$('#exportAll').click(function() {
				$('#report_msg').html("<img src='http://192.168.3.14/new_sapm//public/images/icons/loading.gif' alt='loading'> <span style='color:#080'>exporting report ...</span>");
				getReport(2);
			})

			//--------------------------------------------
			//	Function to get ajax content of report
			//--------------------------------------------
			function getReport(ex) {
				var year = $('#YEAR').val();
				var month = $('#MONTH').val();
				var id = $('#ID').val();
				var msg = '';
				if ($('#ID').val() == '') {
					msg += 'NPP tidak boleh kosong \n';
				}
				if (ex == 0) {


					if (msg) {
						alert(msg);
						return false;
					}

//var urls = '<?php echo site_url('/db/tabel//')?>';			
var urls = '<?php echo site_url('/account_planning/get_report/')?>/'+id+ '/' +month+ '/' +year;			
$("#report_msg").load(urls);
				
/*
//					var urls = '/account_planning/get_report/' + id + '/' + month + '/' + year;
					var urls = '/db/tabel/';
					$("#report_msg").html("<img src='http://192.168.3.14/new_sapm//public/images/icons/loading.gif'> <span style='color:#080'>loading</span>");
					$("#report_msg").load(urls)
*/					
					
				} else if (ex == 1) {
					if (msg) {
						alert(msg);
						return false;
					}
					
					//var urls = 'http://192.168.3.14/new_sapm//index.php/account_planning/xls_report/' + id + '/' + month + '/' + year;
					var urls = '<?php echo site_url('/account_planning/xls_report/')?>/'+id+ '/' +month+ '/' +year;			

					//alert(urls);
					window.location = urls;
				}
				else if (ex == 2)
				{
					var urls = 'http://192.168.3.14/new_sapm//index.php/account_planning/xls_report/0/' + month + '/' + year;
					//alert(urls);
					window.location = urls;
				}
			}


			//------------------------------------------------
			//	Choose SALES ID from dialog box if clicked
			//------------------------------------------------
				$('#ID').click(function() {
					$('#search').dialog('open');
					//$('select').hide();
				});
				$('#USER_NAME').click(function() {
					$('#search').dialog('open');
					//$('select').hide();
				});

			//------------------------------
			//	Search jQuery Dialog Box
			//------------------------------
			$("#search").dialog({
				width: 500,
				height: 550,
				modal: true,
				autoOpen: false,
				buttons: {'Close': function() {
						$(this).dialog('close');
						$('select').show();
					}}
			});

			//------------------------------------
			//	Show all select if dialog close
			//------------------------------------
			$("#search").dialog({
				close: function(event, ui) {
					$('select').show();
				}
			});

		});


		//-------------------------------------
		//	Choose SALES ID from dialog box
		//-------------------------------------
		function pilih_data(com, grid)
		{
			if (com == 'Pilih')
			{
				if ($('.trSelected', grid).length > 0 && $('.trSelected', grid).length < 2) {
					// to provide value in ie 6 suck
					var arrData = getSelectedRow();
					var nama = arrData[0][1].toUpperCase();
					$('#ID').val(arrData[0][0]);
					$('#USER_NAME').val(nama);
					$('#SALES_TYPE').val(arrData[0][2]);
					$('#search').dialog('close');
				} else {
					alert('Pilih satu data saja !');
				}
			}
		}

		function getSelectedRow() {
			var arrReturn = [];
			$('.trSelected').each(function() {
				var arrRow = [];
				$(this).find('div').each(function() {
					arrRow.push($(this).html());
				});
				arrReturn.push(arrRow);
			});
			return arrReturn;
		}


	</script>





<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
 	<img src="<?php echo APP ?>" align="middle" /> 
                    REPORT <strong>PERFORMANCE</strong>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

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
                <li class="active"><a href="#tab_1" data-toggle="tab">REPORT PERFORMANCE</a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 -->
                <div class="tab-pane active" id="tab_1">
<!---------ISI TAB-------------->		
                    <form style="margin:10px" action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
					
<!---
<input  id="export" name="export"  type="button" value="Export">
<input  id="oldperformance" name="oldperformance"  type="button" value="Old Performance">
-->
					
					
                        <table class="table-responsive table-condensed" width="" cellspacing="5" cellpadding="5" border="0">
                        <tbody>
						<tr>
							<td align="left">NPP</td>
							<td colspan="4">
								<input name="ID" id="ID" type="text" size="20" readonly="readonly" class="input">
							</td>
						</tr>

						<tr>
							<td align="left">NAMA</td>
							<td colspan="4">
								<input name="USER_NAME" id="USER_NAME" type="text" size="20" readonly="readonly" class="input">
							</td>
						</tr>
						<tr>
							<td align="left">SALES TYPE</td>
							<td colspan="4">
								<input name="SALES_TYPE" id="SALES_TYPE" type="text" size="20" readonly="readonly" class="input">
							</td>
						</tr>
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
							<td colspan='2'>&nbsp;</td>
							<td><input name="submit" id="submit" type="button" value="Generate"> &nbsp; 
								<input name="export" id="export" type="button" value="Export to XLS">&nbsp;
								<!--<input name="exportAll" id="exportAll" type="button" value="Export All Sales to XLS">&nbsp;-->
						</tr>					<!-----------
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
<?php
?>
					<div id="report_msg" class="text-center">Silahkan isi range periode report</div>
<!---------ISI TAB END-------------->		
					
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
    <div id="search" title="SALES DATA">
<?php echo $js_grid; ?><table id="search_list_user" style="display:none"></table>
    </div>
		 
		 
		 

</section><!-- /.content -->

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
