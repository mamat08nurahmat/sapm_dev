<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	if(isset($user))
	{			
		echo "<tr><td colspan='5'><b>REPORT DAILY CUSTOMER</br></td></tr>";
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
	<th bgcolor="#A5D3FA">No.</th>
    <th align="left" bgcolor="#A5D3FA">Nama Customer</th>
    <th bgcolor="#A5D3FA">Contact Existing Cust</th>
    <th bgcolor="#A5D3FA">Contact New Prospect</th>
    <th bgcolor="#A5D3FA">Mendapatkan janji pertemuan</th>
    <th bgcolor="#A5D3FA">Menggali Kebutuhan Nasabah</th>
    <th bgcolor="#A5D3FA">Melakukan Presentasi</th>
    <th bgcolor="#A5D3FA">Mendapatkan Penjualan</th>
    <th bgcolor="#A5D3FA">Mendapatkan Referensi Baik</th>
    <th bgcolor="#A5D3FA">Melakukan Pelayanan Nasabah</th>
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
			<td  bgcolor='$color' width='200'>".$row->CUST_NAME."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACT1."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACT2."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACT3."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACT4."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACT5."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACT6."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACT7."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACT8."</td>
		</tr>";
	}
}
?>
</table>