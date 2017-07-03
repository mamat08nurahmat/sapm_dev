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
                <li class="active"><a href="#tab_1" data-toggle="tab">REKAP KEGIATAN</a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 -->
                <div class="tab-pane active" id="tab_1">
                    <form style="margin:10px" action="" method="post" enctype="application/x-www-form-urlencoded" name="frmReport" id="frmReport">
                        <table class="table-responsive table-condensed" width="" cellspacing="5" cellpadding="5" border="0">
                        <tbody>

                        <tr>
                              <td><input name="submit" class="btn btn-primary" id="submit" value="Generate" type="button"></td>
                              <!--td><input name="export" id="export" type="button" value="Export to XLS"></td-->
                        </tr>
                        </tbody></table>
                    </form><br><br>

<?php
/*
		$sql="
				select 
				 a.REGION_CODE,
				 c.REGION_NAME,
				 SUM(a.CALL) CALL,
				 SUM(a.CALL_TIDAK) CALL_TIDAK,
				 SUM(a.CALL_YA) CALL_YA,
				 SUM(a.VISIT) VISIT,
				 SUM(a.VISIT_TIDAK) VISIT_TIDAK,
				 SUM(a.VISIT_YA) VISIT_YA
				  from vw_rangkuman_top2010 a
				  join branch b
				  on a.branch_code = b.branch_code
				  join branch_region c
				  on b.region = c.region_code
				  group by a.region_code,c.region_name
				  order by a.region_code
			";
$sql = "SELECT * FROM vw_rangkuman_top2010";
		$data =  $this->db->query($sql)->result();
print_r($data);
		$news = $this->db->query("select * from vw_rangkuman_top2017")->result();		
		print_r($news);
*/
?>					
					
                    	<div id="trx" style="height: auto; width: 100%; font-size: 12px; overflow: auto;"><table name="trx" class="table-responsive table-bordered table-condensed table-striped" width="100%" cellspacing="1" cellpadding="10" bgcolor="#cccccc">
						<thead>
						<tr bgcolor="#A5D3FA">
							<th class="kecil" align="center">NO</th>
							<th class="kecil" align="center">WILAYAH</th>
							<th class="kecil" align="center">REALISASI JUMLAH CALL</th>
							<th class="kecil" align="center">REALISASI JUMLAH VISIT</th>
							<th class="kecil" align="center">TOTAL CALL</th>
							<th class="kecil" align="center">TOTAL VISIT</th>
							<th class="kecil" align="center">DETAIL</th>
						</tr>
						</thead>
<?php

/*
$sql = "SELECT * FROM PRODUCT ";

$query=mysql_query($sql) or die (mysql_error());
	return $query;
*/
/*
$result = $this->db->query($sql);
print_r($result);
        while ($data = $result->fetch_array()) {
			
			print_r($data);

//            $hasil[] = $data;
			//echo "$data[ID]";
        }
*/



		
?>
						<tbody>	
						<tr bgcolor="#ffffff">
							<td class="kecil" width="" align="center">1</td> 
							<td class="kecil" width="" align="center">DUKUH BAWAH</td> 
							<td class="kecil" width="" align="center">999</td> 
							<td class="kecil" width="" align="center">999</td> 
							<td class="kecil" width="" align="center">999</td> 
							<td class="kecil" width="" align="center">999</td> 
							<td class="kecil" width="" align="center"><button  class="btn btn-block btn-default btn-sm"  >Detail</button></td> 
							 
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
