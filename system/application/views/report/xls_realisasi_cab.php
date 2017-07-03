<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	
	$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
	
	if(isset($user))
	{
		echo "<tr><td colspan='5'><h3>REPORT REALISASI - ";
		if(isset($month))
		{
			echo strtoupper($bulan[$month]);
		}
		if(isset($year))
		{
			echo " ".$year."</h3></td></tr>";
		}
		#echo "<tr><td colspan='5'>&nbsp;</td></tr>";
		if($this->session->userdata('USER_LEVEL') == 'WILAYAH')
		{
			echo "<tr><td colspan='5'><h3>WILAYAH ".$this->session->userdata('REGION')."</h3></td></tr>";
		} else
		{
			echo "<tr><td colspan='5'><h3>CABANG : ".$this->session->userdata('BRANCH_NAME')."</h3></td></tr>";
		}
	}
	echo "<tr><td>&nbsp;</td></tr>";
	
?>
</table>


<table width='' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">No.</th>
    <th bgcolor="#FFCC00">Cabang</th>
    <th bgcolor="#FFCC00">Sales Id</th>
    <th bgcolor="#FFCC00">Nama</th>
    <th align="left" bgcolor="#FFCC00">Product Name</th>
    <th bgcolor="#FFCC00">Target</th>
    <th bgcolor="#FFCC00">Pencapaian</th>
    <th bgcolor="#FFCC00">Realisasi %</th>
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
			<td  bgcolor='$color' width='150' valign='top'>".$row->BRANCH_NAME."</td>
			<td  bgcolor='$color' width='80' valign='top'>".$row->SALES_ID."</td>
			<td  bgcolor='$color' width='200' valign='top'>".$row->USER_NAME."</td>
			<td  bgcolor='$color' width='200' valign='top'>".$row->PRODUCT_NAME."</td>
			<td align='right' width='60' bgcolor='$color' valign='top'>".number_format($row->TARGET+$row->OUTSTANDING,2,'.',',')."</td>
			<td align='right' width='60' bgcolor='$color' valign='top'>".number_format($row->PENCAPAIAN,2,'.',',')."</td>
			<td align='right' width='60' bgcolor='$color' valign='top'>".number_format($row->REALISASI,2,'.',',')."</td>
		</tr>";
	}
}
?>
</table>