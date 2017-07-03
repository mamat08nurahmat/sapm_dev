<?php $this->load->view('default/header') ?>	

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
</script>

<!------------------------------>
<!--Start Section class content2 -->
<section class="content2">
<!------------------------------>
<!------------------------------>
<section class="content-header">
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> 
                    <strong>LEADS MANAGEMENT</strong>
    </div>
</section>	
<!------------------------------>
        <div class="row">
          <div class="col-xs-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab"><strong>Leads Kelolaan</strong></a></li>
                <!-- <li><a href="#tab_2" data-toggle="tab">Tab 2</a></li>
                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li> -->
                <!-- <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li> -->
              </ul>
              <div class="tab-content">
                <!-- tab1 -->
<div class="tab-pane active" id="tab_1">

<!-- Row 1 -->
<div class="row" >

    <div class="col-xs-6">
		<div class="panel panel-info">
				  
		  <div class="panel-heading">
			<h3 class="panel-title">

			
			</h3>
		  </div>		  
		  
		  <div class="panel-body">

<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Pribadi Nasabah</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_pribadi) && $data_pribadi)
                    {	
                        $n = 1;
						
                        foreach($data_pribadi[0] as $row => $val){
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
												if($row == 'Penghasilan Pribadi')
														$val = number_format($val, 2, ',', '.');
                ?>
                      <tr bgcolor="<?php echo $color ?>">
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
</table>
						<br />
<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Produk Bank BNI</strong></th>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk DPK yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										unset($data_prod_bni[0]['CIF']);
										$prod_bni = str_replace('_',' ', str_replace('PROD_','',implode(', ',array_keys($data_prod_bni[0],'1'))));
										$prod_bni = ucwords(strtolower($prod_bni));
									?>
									<div style="padding:2px"><?php echo $prod_bni ?></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk Kredit Konsumer yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['NAMA_PRODUK']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk Investasi yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<div style="padding:2px"></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk Asuransi yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['NAMA_PRODUK']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk Kartu Kredit yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									
									<div style="padding:2px"></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk E-Banking yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['NAMA_PRODUK']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Lain-Lain</div>
								</td>
								<td>:</td>
								<td>
									
									<div style="padding:2px"></div>
								</td>
							</tr>
</table>
						<br />
<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Produk Bank Lain</strong></th>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk DPK yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['DPK_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk Kredit Konsumer yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['KREDIT_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk Investasi yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['INVESTASI_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk Asuransi yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['ASURANSI_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk Kartu Kredit yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['CC_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk E-Banking yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['EBANKING_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Lain-Lain</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['LAIN2_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
 </table>
						<br />
<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Sales</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_sales) && $data_sales)
                    {	
                        $n = 1;
												
                        foreach($data_sales[0] as $row => $val){
													if($row == 'CIF')	continue;
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
                ?>
                      <tr bgcolor="<?php echo $color ?>">
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
</table>		  

		  
		  
		  
		  
		  </div>
		  
		</div>
	</div>
		

    <div class="col-xs-6">
		<div class="panel panel-info">
				  
		  <div class="panel-heading">
			<h3 class="panel-title">

			
			</h3>
		  </div>		  
		  
		  <div class="panel-body">

<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Pekerjaan</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_pekerjaan) && $data_pekerjaan)
                    {	
                        $n = 1;
												
                        foreach($data_pekerjaan[0] as $row => $val){
													if($row == 'CIF')	continue;
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
                ?>
                      <tr bgcolor="<?php echo $color ?>">
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
            </table>
						<br />
						<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Family Tree</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_pasangan) && $data_pasangan)
                    {	
                        $n = 1;
												
                        foreach($data_pasangan[0] as $row => $val){
													if($row == 'CIF')	continue;
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
                ?>
                      <tr bgcolor="<?php echo $color ?>"class="<?php echo str_replace(" ","_",$row) ?>" >
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px" class="value"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
            </table>
						<br />
						<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Bisnis</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_bisnis) && $data_bisnis)
                    {	
                        $n = 1;
												
                        foreach($data_bisnis[0] as $row => $val){
													if($row == 'CIF')	continue;
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
													if($row == 'Total AUM dengan BNI' || $row == 'Total Loan' || $row == 'Posisi Tabungan')
														$val = number_format($val, 2, ',', '.');
                ?>
                      <tr bgcolor="<?php echo $color ?>">
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
            </table>
						<br />
						<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Lain-lain</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_lain) && $data_lain)
                    {	
                        $n = 1;
												
                        foreach($data_lain[0] as $row => $val){
													if($row == 'CIF')	continue;
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
                ?>
                      <tr bgcolor="<?php echo $color ?>">
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
</table>		  
		  
		  
		  </div>
		  
		</div>
	</div>
	
</div>	


<!-- Row 2 
<div class="row" >

    <div class="col-xs-6">
		<div class="panel panel-info">
				  
		  <div class="panel-heading">
			<h3 class="panel-title">
			<img src='<?php echo ICONS ?>icon-32-edit.png' />
			XXXXXXXXX
			</h3>
		  </div>		  
		  
		  <div class="panel-body">

		  
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX		
		  
		  
		  </div>
		  
		</div>
	</div>
		

    <div class="col-xs-6">
		<div class="panel panel-info">
				  
		  <div class="panel-heading">
			<h3 class="panel-title">
			<img src='<?php echo ICONS ?>icon-32-edit.png' />
			XXXXXXXXX
			</h3>
		  </div>		  
		  
		  <div class="panel-body">

		  
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX		
		  
		  
		  </div>
		  
		</div>
	</div>
	
</div>	
-->
	

	

</div>		
		
				
				
				
					
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




<!--
<div id='content_x'>
	<div class="ui-state-default ui-corner-all" style="padding:5px; margin-bottom:10px;">
    	<img src="<?php echo APP ?>" align="middle" /> LEADS MANAGEMENT
    </div>
	<div id="tabs">
        <ul>
            <li><a href="#tabs-1">Leads Kelolaan</a></li>
        </ul>
        <div id="tabs-1">
		
<div style="float: left;display: block;width: 50%">

<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Pribadi Nasabah</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_pribadi) && $data_pribadi)
                    {	
                        $n = 1;
						
                        foreach($data_pribadi[0] as $row => $val){
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
												if($row == 'Penghasilan Pribadi')
														$val = number_format($val, 2, ',', '.');
                ?>
                      <tr bgcolor="<?php echo $color ?>">
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
</table>
						<br />
<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Produk Bank BNI</strong></th>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk DPK yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										unset($data_prod_bni[0]['CIF']);
										$prod_bni = str_replace('_',' ', str_replace('PROD_','',implode(', ',array_keys($data_prod_bni[0],'1'))));
										$prod_bni = ucwords(strtolower($prod_bni));
									?>
									<div style="padding:2px"><?php echo $prod_bni ?></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk Kredit Konsumer yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['NAMA_PRODUK']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk Investasi yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<div style="padding:2px"></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk Asuransi yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['NAMA_PRODUK']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk Kartu Kredit yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									
									<div style="padding:2px"></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk E-Banking yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['NAMA_PRODUK']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Lain-Lain</div>
								</td>
								<td>:</td>
								<td>
									
									<div style="padding:2px"></div>
								</td>
							</tr>
</table>
						<br />
<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Produk Bank Lain</strong></th>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk DPK yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['DPK_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk Kredit Konsumer yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['KREDIT_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk Investasi yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['INVESTASI_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk Asuransi yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['ASURANSI_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Produk Kartu Kredit yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['CC_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#ffffff">
								<td>
									<div style="padding:2px">Produk E-Banking yang dimiliki</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['EBANKING_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
							<tr bgcolor="#eeeeee">
								<td>
									<div style="padding:2px">Lain-Lain</div>
								</td>
								<td>:</td>
								<td>
									<?php
										$prod_banklain = $data_prod_bank_lain[0]['LAIN2_BANK_LAIN']
									?>
									<div style="padding:2px"><?php echo $prod_banklain ?></div>
								</td>
							</tr>
 </table>
						<br />
<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Sales</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_sales) && $data_sales)
                    {	
                        $n = 1;
												
                        foreach($data_sales[0] as $row => $val){
													if($row == 'CIF')	continue;
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
                ?>
                      <tr bgcolor="<?php echo $color ?>">
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
</table>
</div>
					
					
	



	
					
<div style="float: right;display: block;width: 50%">

<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Pekerjaan</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_pekerjaan) && $data_pekerjaan)
                    {	
                        $n = 1;
												
                        foreach($data_pekerjaan[0] as $row => $val){
													if($row == 'CIF')	continue;
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
                ?>
                      <tr bgcolor="<?php echo $color ?>">
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
            </table>
						<br />
						<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Family Tree</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_pasangan) && $data_pasangan)
                    {	
                        $n = 1;
												
                        foreach($data_pasangan[0] as $row => $val){
													if($row == 'CIF')	continue;
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
                ?>
                      <tr bgcolor="<?php echo $color ?>"class="<?php echo str_replace(" ","_",$row) ?>" >
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px" class="value"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
            </table>
						<br />
						<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Bisnis</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_bisnis) && $data_bisnis)
                    {	
                        $n = 1;
												
                        foreach($data_bisnis[0] as $row => $val){
													if($row == 'CIF')	continue;
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
													if($row == 'Total AUM dengan BNI' || $row == 'Total Loan' || $row == 'Posisi Tabungan')
														$val = number_format($val, 2, ',', '.');
                ?>
                      <tr bgcolor="<?php echo $color ?>">
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
            </table>
						<br />
						<table width="100%" border="0" cellspacing="0">
              <tr>
								<th colspan="3"><strong>Data Lain-lain</strong></th>
							</tr>
                <?php 
                    #print_r($data);
                    if(isset($data_lain) && $data_lain)
                    {	
                        $n = 1;
												
                        foreach($data_lain[0] as $row => $val){
													if($row == 'CIF')	continue;
                            $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
                ?>
                      <tr bgcolor="<?php echo $color ?>">
                        <td>
													<div style="padding:2px"><?php echo str_replace("_"," ",$row) ?></div>
												</td>
												<td>:</td>
												<td>
													<div style="padding:2px"><?php echo $val ?></div>
												</td>
                      </tr>
                 <?php $n++; }} ?>
</table>
			
					</div>
					
					
					<div style="clear: both;display: block"></div>
		</div>
    </div>
</div>
	<div align="center"><input name="Back" type="button" value="Back" onclick="history.back()" /></div>
</td>
-->
<!---
</tr>
</table>	
-->
<!------------------------------>
</section>
 <!-- / end section class content2 -->
<!------------------------------>
<script type="text/javascript">
$(function(){
	$( "#accordion" ).accordion({ active:3 });
	var jmlAnak = $('.Jumlah_Anak .value').html();
	for(var i = 3; i > jmlAnak ; i--)
	{
		$(".Usia_Anak_"+i).hide();
		$(".Pekerjaan_Anak_"+i).hide();
	}
	$('#tabs table').css('border','1px solid #ccc');
	$('#tabs table').css('background-color','azure');
	$('#tabs table th').css('height','21px');
	$('#tabs table td').css('vertical-align','top');
});
</script>

<?php $this->load->view('default/footer') ?>