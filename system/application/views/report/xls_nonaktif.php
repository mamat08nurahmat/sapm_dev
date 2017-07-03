<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	
	
	echo "<tr><td colspan='5'><b>REPORT USER NON AKTIF</br></td></tr>";
	echo "<tr><td colspan='5'>&nbsp;</td></tr>";
	
?>
</table>


<table width='900' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">No.</th>
    <th align="left" bgcolor="#FFCC00">NPP</th>
    <th bgcolor="#FFCC00">Nama</th>
    <th bgcolor="#FFCC00">User Level</th>
    <th bgcolor="#FFCC00">Unit</th>
	<th bgcolor="#FFCC00">Last Login</th>
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
			<td  bgcolor='$color' width='200'>".$row->ID."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->USER_NAME."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->USER_LEVEL."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->BRANCH_NAME."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->LAST_LOGIN."</td>
		</tr>";
	}
}
?>
</table>