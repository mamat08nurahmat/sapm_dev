<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	if(isset($user))
	{
		
		echo "<tr><td colspan='5'><b>REPORT PEMBUKAAN REKENING DPLK</br></td></tr>";
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
    <th align="left" bgcolor="#FFCC00">Tanggal Buka</th>
    <th bgcolor="#FFCC00">Cabang</th>
    <th bgcolor="#FFCC00">No Rekening</th>
    <th bgcolor="#FFCC00">Nama</th>
	 <th bgcolor="#FFCC00">Saldo Akhir</th>
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
			<td  bgcolor='$color' width='200'>".$row->TGLBUKA."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->BRANCH_NAME."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->NOREK."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->NAMALKP."</td>
			<td align='center' width='60' bgcolor='$color'>".number_format($row->SDOAKHIR)."</td>
		</tr>";
	}
}
?>
</table>