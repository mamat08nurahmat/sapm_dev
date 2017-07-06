<?php $this->load->view('template/header') ?>	
<!---==============================CUSTOM CSS================================================-->		
<!--tambahkan custom css disini-->
<!-- iCheck 
<link href="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
-->
<!-- Morris chart 
<link href="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
-->
<!-- jvectormap 
<link href="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
-->
<!-- Date Picker 
<link href="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
-->
<!-- Daterange picker 
<link href="<?php echo $this->config->item('base_url') ?>assetsLTE/AdminLTE-2.0.5/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
-->
<!-- bootstrap wysihtml5 - text editor 
<link rel="stylesheet" href="<?php echo $this->config->item('base_url');?>assetsLTE/AdminLTE-2-3-11/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
-->

<!----------------------------------------------------->
<!----
<link href="http://192.168.3.14/new_sapm//public/css/layout.css" rel="stylesheet" type="text/css" />
--->
<link href="<?php echo $this->config->item('base_url') ?>public/css/flexigrid.css" rel="stylesheet" type="text/css" />

<link href="<?php echo $this->config->item('base_url') ?>public/css/jui/1.8.4/redmond/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" />
<!---
<link href="<?php echo $this->config->item('base_url') ?>public/css/jquery.numeric.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('base_url') ?>public/css/jquery.treeview.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config->item('base_url') ?>public/css/smart_wizard.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="<?php echo $this->config->item('base_url') ?>public/css/flipclock.css" />
-->
<!----------------------------------------------------->

<!---+++++++++++++++++++++++++++CUSTOM CSS END+++++++++++++++++++++++++++++++++++--->		

<!---+++++++++++++++++++++++++++CUSTOM JS+++++++++++++++++++++++++++++++++++--->		

<!------------------JS ----------------------------------->
<script type="text/javascript" src="<?php echo $this->config->item('base_url') ?>public/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url') ?>public/js/flexigrid.pack.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url') ?>public/js/jquery-ui-1.8.4.custom.min.js"></script>
<!--
<script type="text/javascript" src="<?php echo $this->config->item('base_url') ?>public/js/jquery.numeric.pack.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url') ?>public/js/jquery.maskMoney.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url') ?>public/js/number_format.js"></script>
-->

<!-----------------------------------------------------> 	
<!---+++++++++++++++++++++++++++CUSTOM JS END+++++++++++++++++++++++++++++++++++--->		


<?php $this->load->view('template/topbar') ?>	
<?php $this->load->view('template/sidebar') ?>	


<!--Start Section class content2 -->
<section class="content">
<!------------------------------>

 

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
					var urls = 'http://192.168.3.14/new_sapm//index.php/account_planning/get_report/' + id + '/' + month + '/' + year;
					$("#report_msg").html("<img src='http://192.168.3.14/new_sapm//public/images/icons/loading.gif'> <span style='color:#080'>loading</span>");
					$("#report_msg").load(urls)
				} else if (ex == 1) {
					if (msg) {
						alert(msg);
						return false;
					}
					var urls = 'http://192.168.3.14/new_sapm//index.php/account_planning/xls_report/' + id + '/' + month + '/' + year;
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
<!-------++++++++++++++++++++++++++++--------->		

<!------------------------------>
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> 
                    REPORT <strong>ACCOUNT PLAN</strong>
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
                <li class="active"><a href="#tab_1" data-toggle="tab">REPORT PERFORMANCE NEW</a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 -->
                <div class="tab-pane active" id="tab_1">
<!-------++++++++++++++++++++++++++++--------->		
	
				<form action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
					<table width="" border="0" cellspacing="5" cellpadding="0">
						<tr>
							<td align="left">NPP</td>
							<td>:</td>
							<td colspan="4">
								<input name="ID" id="ID" type="text" size="20" readonly="readonly" class="input">
							</td>
						</tr>

						<tr>
							<td align="left">NAMA</td>
							<td>:</td>
							<td colspan="4">
								<input name="USER_NAME" id="USER_NAME" type="text" size="20" readonly="readonly" class="input">
							</td>
						</tr>
						<tr>
							<td align="left">SALES TYPE</td>
							<td>:</td>
							<td colspan="4">
								<input name="SALES_TYPE" id="SALES_TYPE" type="text" size="20" readonly="readonly" class="input">
							</td>
						</tr>
						<tr>
							<td align="left">PERIODE</td>
							<td>:</td>
							<td align="left">
								<select name="YEAR" id="YEAR">
									<option value='2016' >2016</option>
									<option value='2017' selected>2017</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="left">Bulan</td>
							<td>:</td>
							<td align="left">
							
							<select name='MONTH' id='MONTH' style='width:110px'>
							<option value='1'>Januari</option>
							<option value='2'>Februari</option>
							<option value='3'>Maret</option>
							<option value='4'>April</option>
							<option value='5'>Mei</option>
							<option value='6'>Juni</option>
							<option value='7'>Juli</option>
							<option value='8'>Agustus</option>
							<option value='9'>September</option>
							<option value='10'>Oktober</option>
							<option value='11'>November</option>
							<option value='12'>Desember</option>
							</select>							
							
							</td>
						</tr>
						<tr>
							<td colspan='2'>&nbsp;</td>
							<td><input name="submit" id="submit" type="button" value="Generate"> &nbsp; 
								<input name="export" id="export" type="button" value="Export to XLS">&nbsp;
								<!--<input name="exportAll" id="exportAll" type="button" value="Export All Sales to XLS">&nbsp;-->
							</td>
						</tr>
					</table>
				</form>
				<br />
				
				
				<div id='report_msg'>Silahkan pilih sales untuk mengenerate report</div>
<!-----++++++++---->				
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
<script type="text/javascript">
$(document).ready(function(){
	$("#search_list_user").flexigrid({url: 'http://192.168.3.14/new_sapm//index.php/account_planning/get_sales',
	dataType: 'json',
	sortname: 'a.ID',
	sortorder: 'ASC',
	usepager: true,
	useRp: true,
	width: 460,
	height: 300,
	rp: 10,
	rpOptions: [10,25,50,100],
	pagestat: '{from} to {to} of {total} items.',
	blockOpacity: 0.5,
	title: 'LIST DATA SALES',
	showTableToggleBtn: false,
	colModel : [{display: 'NPP', name : 'ID', 
	sortable: true, 
	width : 40, 
	align: 'center'},
	{display: 'NAMA', 
	name : 'USER_NAME', 
	sortable: true, 
	width : 200, 
	align: 'left'},
	{display: 'SPV', 
	name : 'SPV', 
	sortable: true, 
	width : 50, 
	align: 'left'}],
	searchitems : 
	[{display: 'NPP', 
	name : 'ID', 
	isdefault: true},
	{display: 'NAMA', 
	name : 'USER_NAME'},
	{display: 'SPV', 
	name : 'SPV'}],
	buttons : [{name: 'Pilih', 
	bclass : 'add', 
	onpress : pilih_data},
	{separator: true}]
	}); 
	})
	</script>
	<table id="search_list_user" style="display:none"></table>
    </div>
<!------------------------------>
</section>
 <!-- / end section class content2 -->
<!------------------------------>
