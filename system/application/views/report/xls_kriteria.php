<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	
	$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
	
	if(isset($user))
	{
		echo "<tr><td colspan='5'><h3>REPORT KRITERIA BISNIS";
		if(isset($ket))
		{
			echo strtoupper($ket);
		}
		echo "<tr><td colspan='5'>&nbsp;</td></tr>";
		echo "<tr><td colspan='5'><b>".$user[0]->ID;
		echo " ".strtoupper($user[0]->USER_NAME)." ";
		echo "(".$user[0]->SALES_TYPE.")</b></td></tr>";
	}
	echo "<tr><td>PERIODE : ".date('d F Y')."</td></tr>";
	echo "<tr><td>&nbsp;</td></tr>";
	#print_r($user);
?>
</table>


<table width='' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">NO.</th>
    <th align="left" bgcolor="#FFCC00">NAMA CUSTOMER</th>
    <th bgcolor="#FFCC00">KRITERIA</th>
</tr>
<?php 

if(isset($data)){
	$i = 1;
	$color = '#ffffff';
	$html = '';
	foreach($data as $row){
		$color = ($i%2)?"#eeeeee":"#ffffff";
		$html .= "<tr>";
		$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
		$html .= "<td width='' align='left' class='kecil'>".$row->COMPANY_NAME."</td> \n";
		$html .= "<td width='' align='center' class='kecil'>".$row->SEGMENT."</td> \n";
		$html .= "</tr>";
	}
	echo $html;
}
?>
</table>