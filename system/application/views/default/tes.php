	<?php $this->load->view('default/header');?>


    <!-- Main content -->
   	<section class="content2">
        <!-- START CUSTOM TABS -->
        <h2 class="page-header">Program SGP</h2>

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
<!------------------>
                        <tr>
                	          <td align="left">PERIODE </td>
                              <td>&nbsp; <input name="START" id="START" size="20" readonly="readonly" class="input hasDatepicker" type="text"></td>
                              <td>to <input name="END" id="END" size="20" readonly="readonly" class="input hasDatepicker" type="text"></td>
                              <td><input name="submit" class="btn btn-primary" id="submit" value="Generate" type="button"></td>
                              <!--td><input name="export" id="export" type="button" value="Export to XLS"></td-->
                        </tr>
                        </tbody></table>
                    </form><br><br>

                    	<div id="trx" style="height: auto; width: 100%; font-size: 12px; overflow: auto;"><table name="trx" class="table-responsive table-bordered table-condensed table-striped" width="100%" cellspacing="1" cellpadding="10" bgcolor="#cccccc">
						<thead>
						<tr bgcolor="#A5D3FA">
							<th class="kecil" align="center">NO</th>
							<th class="kecil" align="center">TANGGAL TRX</th>
							<th class="kecil" align="center">NPP</th>
							<th class="kecil" align="center">NAMA</th>
							<th class="kecil" align="center">JENIS</th>
							<th class="kecil" align="center">CABANG</th>
							<th class="kecil" align="center">POIN REDEEM</th>
							<th class="kecil" align="center">HARGA BARANG</th>
							<th class="kecil" align="center">FILE INVOICE</th>
							<th class="kecil" align="center">TANGGAL PEMBAYARAN</th>
							<th class="kecil" align="center">FILE PEMBAYARAN</th>
							<th class="kecil" align="center">STATUS</th>
							<th class="kecil" align="center">Aksi</th>
							<th class="kecil" align="center">Ulasan</th>
						</tr>
						</thead>
<?php

/*
$sql = "SELECT * FROM PRODUCT ";

$query=mysql_query($sql) or die (mysql_error());
	return $query;
$result = $this->db->query($sql);
print_r($result);
*/
/*
        while ($data = $result->fetch_array()) {
			
			print_r($data);

//            $hasil[] = $data;
			//echo "$data[ID]";
        }
*/



		
?>
						<tbody>	
						<tr bgcolor="#ffffff">
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="left">22-OCT-16</td> 
							<td class="kecil" width="" align="left">35052</td> 
							<td class="kecil" width="" align="left">ANDITYA WIRAWAN</td> 
							<td class="kecil" width="" align="left">PBA STA</td> 
							<td class="kecil" width="" align="left">DUKUH BAWAH</td> 
							<td class="kecil" width="" align="right">1</td> 
							<td class="kecil" width="" align="right">Rp. 100,001.00</td> 
							<input name="GB2" id="GB2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button  class="btn btn-block btn-default btn-sm" onclick="view(2)">View</button></td> 
							<td class="kecil" width="" align="center"></td> 
							<input name="GBY2" id="GBY2" value="http://brftst.bni.co.id/" style="display:none" type="hidden"> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="viewbt(2)" disabled="disabled">View</button></td> 
							<td class="kecil" width="" align="center">PENDING</td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openbayar(188)">Bayar</button></td> 
							<td class="kecil" width="" align="center"><button class="btn btn-block btn-default btn-sm" onclick="openfeedback(188)" disabled="disabled">Feedback</button></td> 
						</tr>
<!----
--->						
						
					</tbody>
					</table>
					
					</div><br/> 
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
    

  
    <?php $this->load->view('default/footer');?>
