<?php
	echo "<b>REPORT NASABAH KELOLAAN</b><br>";
	echo "<b>CABANG : ".$cab[0]->BRANCH_NAME." </b><br>";
	echo "<b>TAHUN : $year</b><br>";
	echo "<br>";
?>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr bgcolor="#A5D3FA">
    <th rowspan="2" align='center'>No</th>
    <th rowspan="2" align='center'>Npp</th>
    <th rowspan="2" align='center'>Nama Sales</th>
    <th rowspan="2" align='center'>CIF</th>
    <th colspan="3" align='center'>REKENING</th>
    <th rowspan="2" align='center'>Total DPK</th>
  </tr>
  <tr bgcolor="#A5D3FA">
    <th align='center'>Tabungan</th>
    <th align='center'>Giro</th>
    <th align='center'>Deposito</th>
  </tr>
  
  <?php
  	if(isset($data))
	{ 
		$i=1;
		$html='';
		foreach($data as $row)
		{
			$html.="<tr>";
			$html.="<td align='center'>".$i++."</td>";
			$html.="<td align='center'>".$row->NPP."</td>";
			$html.="<td>".$row->SALES."</td>";
			$html.="<td align='center'>".$row->CIF."</td>";
			$html.="<td align='right'>".number_format($row->T,2,'.',',')."</td>";
			$html.="<td align='right'>".number_format($row->G,2,'.',',')."</td>";
			$html.="<td align='right'>".number_format($row->D,2,'.',',')."</td>";
			$html.="<td align='right'>".number_format($row->DPK,2,'.',',')."</td>";
			$html.="<tr>";
		}
	}
	echo $html;
?>
</table>
