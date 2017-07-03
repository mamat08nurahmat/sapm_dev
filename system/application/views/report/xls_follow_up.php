<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	echo "<tr><td colspan='6'><b>REPORT FOLLOW UP DAILY ACTIVITY CUSTOMER</br></td></tr>";
	if(isset($user))
	{					
		echo "<tr><td colspan='6'><b>".$user[0]->ID;
		echo " ".strtoupper($user[0]->USER_NAME)." ";
		echo "(".$user[0]->SALES_TYPE.")</b></td></tr>";
	}
	if(isset($cabang))
	{
		echo "<tr><td colspan='6'><b>CABANG : ".$cabang[0]->BRANCH_NAME."</b></td></tr>";	
	}
	echo "<tr><td colspan='6'><b>Periode : ";
	if(isset($start))
	{
		echo $start;
	}
	if(isset($end))
	{
		echo " s/d ".$end."</b></td></tr>";
	}
	echo "<tr><td>&nbsp;</td></tr>";

?>
</table>


<table width='900' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">No.</th>
    <th bgcolor="#FFCC00">Tanggal</th>
    <th align="left" bgcolor="#FFCC00">Nama Customer</th>
    <th bgcolor="#FFCC00">Aktifitas</th>
    <th bgcolor="#FFCC00">Tujuan</th>
    <th bgcolor="#FFCC00">Respon</th>
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
			<td align='center' width='60' bgcolor='$color'>".$row->START_TIME."</td>
			<td align='left' bgcolor='$color' width='200'>".$row->CUST_NAME."</td>
			<td align='left' width='60' bgcolor='$color'>".$row->ACTIVITY."</td>
			<td align='left' width='60' bgcolor='$color'>".$row->PURPOSE."</td>
			<td align='left' width='60' bgcolor='$color'>".$row->RESPONSE."</td>
		</tr>";
	}
}
?>
</table>