<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	
	
	echo "<tr><td colspan='5'><b>REPORT AUDIT TRAIL</br></td></tr>";
	echo "<tr><td colspan='5'>&nbsp;</td></tr>";
	
	echo "<tr><td>&nbsp;</td></tr>";
	echo "<tr><td colspan='5'><b>Periode : ";
	//if(isset($start))
	//{
		echo $start;
	//}
	//if(isset($end))
	//{
		echo " s/d ".$end."</b></td></tr>";
	//}
?>
</table>


<table width='900' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">No.</th>
    <th align="left" bgcolor="#FFCC00">NPP</th>
    <th bgcolor="#FFCC00">Action</th>
    <th bgcolor="#FFCC00">Info</th>
    <th bgcolor="#FFCC00">Create Date</th>
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
			<td  bgcolor='$color' width='200'>".$row->NPP."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACTION."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->INFO."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->DATE_CREATED."</td>
		</tr>";
	}
}
?>
</table>