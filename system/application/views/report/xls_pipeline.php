<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	if(isset($user))
	{
		$ket = '';
				if($staging == 1) $ket = 'LEADS';
				if($staging == 2) $ket = 'CALLS';
				if($staging == 3) $ket = 'OPPORTUNITY';
				if($staging == 4) $ket = 'APPOINTMENT';
				if($staging == 5) $ket = 'APPLICATION';
				if($staging == 6) $ket = 'APPROVAL';
				if($staging == 7) $ket = 'ACCEPTANCE';
				if($staging == 8) $ket = 'DRAWDOWN';
	
		//echo $staging;
		echo "<tr><td colspan='5'><b>REPORT STAGING PIPELINE BERDASARKAN TANGGAL " .$ket."</br></td></tr>";
		echo "<tr><td colspan='5'>&nbsp;</td></tr>";
		echo "<tr><td colspan='5'><b>".$user[0]->ID;
		echo " ".strtoupper($user[0]->USER_NAME)." ";
		echo "(".$user[0]->SALES_TYPE.")</b></td></tr>";
	}
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr><td colspan='5'><b>Periode " .$ket. " : ";
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
    <th bgcolor="#FFCC00">SUMBER LEADS</th>
    <th bgcolor="#FFCC00">CIF</th>
    <th bgcolor="#FFCC00">CUST NAME</th>
    <th bgcolor="#FFCC00">PRODUK</th>
	<th bgcolor="#FFCC00">LEADS</th>
	<th bgcolor="#FFCC00">CALLS</th>
	<th bgcolor="#FFCC00">OPPORTUNITY</th>
	<th bgcolor="#FFCC00">APPOINTMENT</th>
	<th bgcolor="#FFCC00">APPLICATION</th>
	<th bgcolor="#FFCC00">APPROVAL</th>
	<th bgcolor="#FFCC00">ACCEPTANCE</th>
	<th bgcolor="#FFCC00">DRAWDOWN</th>
	<th bgcolor="#FFCC00">CLOSING</th>
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
			<td align='center' width='100' bgcolor='$color'>".$row->SOURCE_DATA."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->CIF."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->CUST_NAME."</td>
			<td align='center' width='100' bgcolor='$color'>".$row->PRODUCT_NAME."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->LEADS."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->CALLS."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->OPPORTUNITY."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPOINTMENT."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPLICATION."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPROVAL."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACCEPTANCE."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->DRAWDOWN."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->NOMINAL."</td>
		</tr>";
	}
}
?>
</table>