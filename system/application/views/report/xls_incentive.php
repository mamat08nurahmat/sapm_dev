<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	
	$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
	
	if(isset($cabang))
	{
		echo "<tr><td colspan='5'><h3>REPORT INCENTIVE CABANG : $cabang</h3></td></tr>";
		
		echo "<tr><td colspan='5'><h3>PERIODE : ";
		if(isset($month))
		{
			echo strtoupper($bulan[$month]);
		}
		if(isset($year))
		{
			echo " ".$year."</h3></td></tr>";
		}
	}
	echo "<tr><td>&nbsp;</td></tr>";
	
?>
</table>


<table width='' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th align='center' class='kecil' bgcolor="#FFCC00">NO.</th>
    <th align='left'   class='kecil' bgcolor="#FFCC00">BRANCH</th>
    <th align='center' class='kecil' bgcolor="#FFCC00">NPP</th>
    <th align='center' class='kecil' bgcolor="#FFCC00">NAMA SALES</th>
    <th align='center' class='kecil' bgcolor="#FFCC00">PERFORMANCE</th>
    <th align='left'   class='kecil' bgcolor="#FFCC00">CATEGORY</th>
    <th align='left'   class='kecil' bgcolor="#FFCC00">% INCENTIVE</th>
    <th align='left'   class='kecil' bgcolor="#FFCC00">NOMINAL</th>
</tr>
<?php 

if(isset($data)){
	$i = 1;
	$color = '#ffffff';
	$html = '';
	foreach($data as $row){		
		$cat   = ($row->BOBOT_CAT == 1)?'FINANCIAL':'KICKERS';
		$color = ($i%2)?"#ffffff":"#eeeeee";
		$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center'	>".$i++."</td> \n";
				$html .= "<td width='' align='left'  	>".$row->CABANG."</td> \n";
				$html .= "<td width='' align='left'		>".$row->SALES_ID."</td> \n";
				$html .= "<td width='' align='left'		>".$row->NAMA."</td> \n";
				$html .= "<td width='' align='center'	>".$row->BOBOT_PCT."%</td> \n";
				$html .= "<td width='' align='center'	>".$cat."</td> \n";
				$html .= "<td width='' align='center'  	>".$row->PCT_INCENTIVE."%</td> \n";
				$html .= "<td width='' align='right' 	>".number_format($row->NOMINAL,2,'.',',')."</td> \n";
				$html .= "</tr> \n";
	}
	echo $html;
}
?>
</table>