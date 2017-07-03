<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	
	$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
	
		$level = (isset($lvl))?$lvl:'';
		echo "<tr><td colspan='5'><h3>REPORT OPORTUNITY - $level ";
		if(isset($month))
		{
			echo strtoupper($bulan[$month]);
		}
		if(isset($year))
		{
			echo " ".$year."</h3></td></tr>";
		}
		echo "<tr><td colspan='5'>&nbsp;</td></tr>";
		#echo "<tr><td colspan='5'><b>".$user[0]->ID;
		#echo " ".strtoupper($user[0]->USER_NAME)." ";
		#echo "(".$user[0]->SALES_TYPE.")</b></td></tr>";
	echo "<tr><td>&nbsp;</td></tr>";
	
?>
</table>


<table width='' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#A5D3FA">No.</th>
    <th align="left" bgcolor="#A5D3FA">Npp</th>
    <th bgcolor="#A5D3FA">Nama Sales</th>
    <th bgcolor="#A5D3FA">Rasio Janji</th>
    <th bgcolor="#A5D3FA">Rasio Presentasi</th>
    <th bgcolor="#A5D3FA">Rasio Penutupan</th>
</tr>
<?php 

if(isset($data)){
	$i = 1;
	$color = '#ffffff';
	foreach($data as $row){
		$color = ($i%2)?"#eeeeee":"#ffffff";
		echo "
		<tr>
			<td align='center' width='60' bgcolor='$color' valign='top'>".$i++."</td>
			<td  bgcolor='$color' width='200' valign='top'>".$row->USERID."</td>
			<td align='right' width='60' bgcolor='$color' valign='top'>".$row->USER_NAME."</td>
			<td align='right' width='60' bgcolor='$color' valign='top'>".$row->T."</td>
			<td align='right' width='60' bgcolor='$color' valign='top'>".$row->P."</td>
			<td align='right' width='60' bgcolor='$color' valign='top'>".$row->J."</td>
		</tr>";
	}
}
?>
</table>