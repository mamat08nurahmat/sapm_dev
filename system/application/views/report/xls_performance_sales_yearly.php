<?php $this->load->view('default/excel_header'); ?>

<?php 
	if(isset($user))
	{
		$txt = ($type==1)?'PERFORMANCE':'REALISASI';
		echo "<b>REPORT TAHUNAN $txt  PER SALES </b><br>";
		echo "<br>";
		echo "NPP : ".$user[0]->ID."<br>";
		echo "NAMA : ".$user[0]->USER_NAME."<br>";
		echo "SALES : ".$user[0]->SALES_TYPE."<br>";
		echo "PENYELIA : ".$user[0]->SPV."<br>";
		echo "TAHUN : ".$thn."<br>";
		echo "<br>";
		
	}
	
	$txt2 = ($type==1)?'PERFORMANCE (Bobot * Pencapaian)':'PENCAPAIAN REALISASI (Realisasi/Target )';
?>
<table width="auto" border="1" cellspacing="0" cellpadding="3">
  <tr bgcolor="#A5D3FA">
    <th rowspan="2" align="center">No</th>
    <th rowspan="2" align="left">PRODUCT KPI</th>
    <th rowspan="2" align="center">BOBOT</th>
    <th colspan="12"><div align="center"><?php echo $txt2 ?></div></th>
  </tr>
  <tr bgcolor="#A5D3FA">
    <th align="center">JAN</th>
    <th align="center">FEB</th>
    <th align="center">MAR</th>
    <th align="center">APR</th>
    <th align="center">MEI</th>
    <th align="center">JUN</th>
    <th align="center">JUL</th>
    <th align="center">AUG</th>
    <th align="center">SEP</th>
    <th align="center">OKT</th>
    <th align="center">NOV</th>
    <th align="center">DES</th>
  </tr>
  <?php 
  if(isset($data))
  {
  	$i=1;
	foreach($data as $rs)
	{
	  echo "<tr>
			<td>".$i++."</td>
			<td>".$rs['product']."</td>
			<td align='right'>".number_format($rs['bobot'],1,'.',',')."</td>";
			
		for($x=1;$x<=12;$x++)
		{echo "<td align='center'>".number_format($rs[$x],1,'.',',')."</td>";}	
		
		echo "</tr>";
	  
		  if($i == $fin['row']+1){
		  echo "<tr bgcolor='#CCCCCC'>
				<td colspan=2 align='center'><b>SUB TOTAL KPI FINANCIAL</b></td>
				<td align='center'><b>".number_format($fin['bobot'],1,'.',',')."</b></td>";

		for($x=1;$x<=12;$x++)
		{echo "<td align='center'>".number_format($fin[$x],1,'.',',')."</td>";}
		
		echo "</tr>";	
	  }
	 }
  } 
  echo "<tr bgcolor='#CCCCCC'>
		<td colspan=2 align='center'><b>SUB TOTAL KPI KICKERS</b></td>
		<td align='center'><b>".number_format($kik['bobot'],1,'.',',')."</b></td>";
		
		for($x=1;$x<=12;$x++)
		{echo "<td align='center'>".number_format($kik[$x],1,'.',',')."</td>";}
		
	  echo "</tr>";
	
	echo "<tr bgcolor='#CCCCCC'>
		<td colspan=2 align='center'><b>TOTAL KPI</b></td>
			<td align='center'><b>".number_format(($kik['bobot']+$fin['bobot']),1,'.',',')."</b></td>";
		for($x=1;$x<=12;$x++)
		{echo "<td align='center'>".number_format(($kik[$x]+$fin[$x]),1,'.',',')."</td>";}
	
	echo "</tr>";
  
  ?>
</table>

<?php 
	#echo "<pre>"; print_r($result);
?>
