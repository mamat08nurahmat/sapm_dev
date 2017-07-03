<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	if(isset($user))
	{
		$ket = '';
				if($type == 0) $ket = '';
				if($type == 1) $ket = ' REALISASI';
				if($type == 2) $ket = ' BELUM REALISASI';
	
		echo "<tr><td colspan='5'><b>REPORT SUMMARY DAILY ACTIVITY $ket</br></td></tr>";
		echo "<tr><td colspan='5'>&nbsp;</td></tr>";
		echo "<tr><td colspan='5'><b>".$user[0]->ID;
		echo " ".strtoupper($user[0]->USER_NAME)." ";
		echo "(".$user[0]->SALES_TYPE.")</b></td></tr>";
	}
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr><td colspan='5'><b>Periode : ";
	if(isset($start))
	{
		echo $start;
	}
	if(isset($end))
	{
		echo " s/d ".$end."</b></td></tr>";
	}
?>
</table>


<table width='900' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">No.</th>
    <th align="left" bgcolor="#FFCC00">Aktivitas</th>
    <th bgcolor="#FFCC00">Jumlah</th>
    <th bgcolor="#FFCC00">Bobot</th>
    <th bgcolor="#FFCC00">Volume</th>
</tr>
<?php 

if(isset($data)){
	$i = 1;
	$color = '#ffffff';
	foreach($data as $row){
		$color = ($i%2)?"#eeeeee":"#ffffff";
		echo "
		<tr>
			<td align='center' width='60' bgcolor='$color'>".$i++."</td>
			<td  bgcolor='$color' width='200'>".$row->ACTIVITY."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->JUMLAH."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->BOBOT."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->VOLUME."</td>
		</tr>";
	}
}
?>
</table>