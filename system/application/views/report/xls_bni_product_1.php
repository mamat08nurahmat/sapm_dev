<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='100%' cellpadding='5' cellspacing='1' border="0">
<?php 
	echo "<tr><td colspan='5'><b>REPORT PRODUCT BNI 1</br></td></tr>";
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


<table width='100%' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">No.</th>
    <th bgcolor="#FFCC00">Product</th>
    <th bgcolor="#FFCC00">Jumlah</th>
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
			<td align='left' width='60' bgcolor='$color'>".$row->PRODUCT."</td>
			<td align='left' width='60' bgcolor='$color'>".$row->JUMLAH."</td>
		</tr>";
	}
}
?>
</table>