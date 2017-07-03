<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	
	$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
	
	if(isset($user))
	{
		echo "<tr><td colspan='5'><h3>REPORT NASABAH KELOLAAN - ";
		if(isset($ket))
		{
			echo strtoupper($ket);
		}
		echo "<tr><td colspan='5'>&nbsp;</td></tr>";
		echo "<tr><td colspan='5'><b>".$user[0]->ID;
		echo " ".strtoupper($user[0]->USER_NAME)." ";
		echo "(".$user[0]->SALES_TYPE.")</b></td></tr>";
	}
	echo "<tr><td>&nbsp;</td></tr>";
	#print_r($user);
?>
</table>


<table width='' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">NO.</th>
    <th align="left" bgcolor="#FFCC00">TANGGAL</th>
    <th bgcolor="#FFCC00">CIF</th>
    <th bgcolor="#FFCC00">CABANG</th>
    <th bgcolor="#FFCC00">NAMA NASABAH</th>
    <th bgcolor="#FFCC00">GIRO</th>
    <th bgcolor="#FFCC00">TABUNGAN</th>
    <th bgcolor="#FFCC00">DEPOSITO</th>
    <th bgcolor="#FFCC00">TOTAL DPK</th>
</tr>
<?php 

if(isset($data)){
	$i 			= 1;
	$color 		= '#ffffff';
	$html 		= '';
	$tabungan 	= 0;
	$giro 		= 0;
	$deposito 	= 0;
	$total 		= 0;
	foreach($data as $row){
		$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
		$color = ($i%2)?"#eeeeee":"#ffffff";
		$html .= "<tr>";
		$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
		$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
		$html .= "<td width='' align='center' class='kecil'>".$row->BNI_CIF_KEY."</td> \n";
		#$html .= "<td width='' align='left' class='kecil'>".$row->BRANCH."</td> \n";
		$html .= "<td width='' align='left' class='kecil'>$branch2</td> \n";
		$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
		$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO,2,'.',',')."</td> \n";
		$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
		$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO,2,'.',',')."</td> \n";
		$html .= "<td width='' align='right' class='kecil'>".number_format(($row->GIRO+$row->TABUNGAN+$row->DEPOSITO),2,'.',',')."</td> \n";
		$html .= "</tr>";
		$tabungan 	= $tabungan + $row->TABUNGAN;
		$giro 		= $giro + $row->GIRO;
		$deposito 	= $deposito + $row->DEPOSITO;
		$total 		= $total + ($row->GIRO+$row->TABUNGAN+$row->DEPOSITO); 
		
	}	
		$html .= "<tr  bgcolor='#DDDDDD'>";
		$html .= "<td colspan=5 align='center' class='kecil'><b>TOTAL</b></td> \n";
		$html .= "<td width='' align='right' class='kecil'>".number_format($giro,2,'.',',')."</td> \n";
		$html .= "<td width='' align='right' class='kecil'>".number_format($tabungan,2,'.',',')."</td> \n";
		$html .= "<td width='' align='right' class='kecil'>".number_format($deposito,2,'.',',')."</td> \n";
		$html .= "<td width='' align='right' class='kecil'>".number_format($total,2,'.',',')."</td> \n";
		$html .= "</tr>";
	echo $html;
}
?>
</table>