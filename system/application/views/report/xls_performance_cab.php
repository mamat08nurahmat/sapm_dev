<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	
	$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
	
		echo "<tr><td colspan='5'>REPORT PERFORMANCE - ";
		if(isset($month))
		{
			echo strtoupper($bulan[$month]);
		}
		if(isset($year))
		{
			echo " ".$year."</td></tr>";
		}
		#echo "<tr><td colspan='5'>&nbsp;</td></tr>";
		#echo "<tr><td colspan='5'><b>".$user[0]->ID;
		#echo " ".strtoupper($user[0]->USER_NAME)." ";
		#echo "(".$user[0]->SALES_TYPE.")</b></td></tr>";
		$lvl = array('SLN', 'DIVISI', 'TIM');
		if( in_array($this->session->userdata('USER_LEVEL'),$lvl) )
		{
			echo "<tr><td colspan='5'>WILAYAH : ".$wil."</td></tr>";
			echo "<tr><td colspan='5'>CABANG : ".$cab[0]->BRANCH_NAME."</td></tr>";
		} else
		{
			echo "<tr><td colspan='5'>CABANG : ".$cab[0]->BRANCH_NAME."</td></tr>";
		}
		echo "<tr><td>&nbsp;</td></tr>";
	
?>
</table>


<table width='' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th rowspan='2' bgcolor="#A5D3FA" align="center">NO.</th>
    <th rowspan='2' bgcolor="#A5D3FA" align="center">CABANG</th>
    <th rowspan='2' bgcolor="#A5D3FA" align="center">SALES ID</th>
    <th rowspan='2' bgcolor="#A5D3FA" align="center">NAMA</th>
    <th colspan='2' bgcolor="#A5D3FA" align="center">PERFORMANCE</th>
</tr>
<tr>
    <th bgcolor="#A5D3FA" align="center">FINANCIAL</th>
    <th bgcolor="#A5D3FA" align="center">KICKERS</th>
</tr>
<?php 

if(isset($data)){
	$i = 0;
	$color = '#ffffff';
	$html = '';
	$htmls = '';
	$npp = '';
	$nama ='';
	$cabang='';
	
	foreach($data as $row){		
		$cat   = ($row->BOBOT_CAT == 1)?'FINANCIAL':'KICKERS';
		$color = ($i%2)?"#ffffff":"#eeeeee";		
	
		if(!isset($nilai[$npp]) && $npp <> ''){
				$nilai[$npp] = array('fin'=>0,'kik'=>0, 'jml'=>0, 'cabang'=>'', 'nama'=>'');
		}
		
		if($npp == $row->SALES_ID && $row->BOBOT_CAT == 1){
				$nilai[$npp]['fin'] += $row->REALISASI_TERBOBOT; 
				$nilai[$npp]['cabang'] = $cabang;
				$nilai[$npp]['nama'] = $nama;
		}
		
		if($npp == $row->SALES_ID && $row->BOBOT_CAT <> 1){
				$nilai[$npp]['kik'] += $row->REALISASI_TERBOBOT; 
				$nilai[$npp]['jml'] = $nilai[$npp]['jml'] + 1;
		}
		

		$npp = $row->SALES_ID;
		$cabang = $row->BRANCH_NAME;
		$nama = $row->USER_NAME;
			
	}

	$j=1;
	$htmlx='';
	if(isset($nilai)){
	foreach($nilai as $row=>$val){
			$htmlx .= "<tr bgcolor='$color'>\n";
			$htmlx .= "<td align='center' class='kecil'>".$j++."</td> \n";
			$htmlx .= "<td align='left' class='kecil'>".$val['cabang']."</td> \n";
			$htmlx .= "<td align='left' class='kecil'>".$row."</td> \n";
			$htmlx .= "<td align='left' class='kecil'>".$val['nama']."</td> \n";
			$htmlx .= "<td align='center' class='kecil'>".$val['fin']."%</td> \n";
			$htmlx .= "<td align='center' class='kecil'>".number_format(($val['kik']/$val['jml']),2,'.',',')."%</td> \n";
			$htmlx .= "</tr> \n";
	}
	}
	#echo "<pre>";print_r($nilai);
	
	echo $htmlx;
}
?>
</table>