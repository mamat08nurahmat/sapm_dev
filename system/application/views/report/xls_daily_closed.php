<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='100%' cellpadding='5' cellspacing='1' border="0">
<?php 
	echo "<tr><td colspan='5'><b>REPORT DAILY CLOSED ACTIVITY CUSTOMER</br></td></tr>";
	if(isset($user))
	{					
		echo "<tr><td colspan='5'><b>".$user[0]->ID;
		echo " ".strtoupper($user[0]->USER_NAME)." ";
		echo "(".$user[0]->SALES_TYPE.")</b></td></tr>";
	}
	if(isset($cabang))
	{
		echo "<tr><td colspan='5'><b>CABANG : ".$cabang[0]->BRANCH_NAME."</b></td></tr>";	
	}
	echo "<tr><td>&nbsp;</td></tr>";

?>
</table>


<table width='100%' cellpadding='10' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">No.</th>
    <th align="left" bgcolor="#FFCC00">Nama Customer</th>
    <th align="center"bgcolor="#FFCC00">Tanggal</th>
    <th align="left"bgcolor="#FFCC00">Product</th>
    <th align="center"bgcolor="#FFCC00">Nominal</th>
</tr>
<?php 

if(isset($data)){
	$i = 1;
	$color = '#ffffff';
	foreach($data as $row){
		$color = ($i%2)?"#eeeeee":"#ffffff";
		$value = (preg_replace('/[^0-9]/','',$row->DESC2) == '')?0:number_format(preg_replace('/[^0-9]/','',$row->DESC2),0,'',',');
		echo "
		<tr>
			<td align='center' width='60' bgcolor='$color'>".$i++."</td>
			<td align='left' bgcolor='$color' width='200'>".$row->CUST_NAME."</td>
			<td align='center' width='100' bgcolor='$color'>".date('d M Y', strtotime($row->START_TIME))."</td>
			<td align='left' width='60' bgcolor='$color'>".$row->DESC1."</td>
			<td align='right' width='60' bgcolor='$color'>".$value."</td>
		</tr>";
	}
}
?>
</table>