<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	
	$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
	
	if(isset($user))
	{
		echo "<tr><td colspan='5'><h3>REPORT OTHER PRODUCT";
		if(isset($ket))
		{
			echo strtoupper($ket);
		}
		echo "<tr><td colspan='5'>&nbsp;</td></tr>";
		echo "<tr><td colspan='5'><b>".$user[0]->ID;
		echo " ".strtoupper($user[0]->USER_NAME)." ";
		echo "(".$user[0]->SALES_TYPE.")</b></td></tr>";
	}
#	echo "<tr><td>PERIODE : ".date('d F Y', strtotime($start))." s/d ".date('d F Y', strtotime($end))."</td></tr>";
	echo "<tr><td>&nbsp;</td></tr>";
?>
</table>


<table width='' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">NO.</th>
    <th align="left" bgcolor="#FFCC00">PRODUCT DARI BANK LAIN</th>
    <th bgcolor="#FFCC00">JUMLAH</th>
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
		$html .= "<td width='' align='left' class='kecil'>".$row->PRODUCT."</td> \n";
		$html .= "<td width='' align='center' class='kecil'>".$row->JUMLAH."</td> \n";
		$html .= "</tr>";
	}
	echo $html;
}
?>
</table>