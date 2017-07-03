<?php $this->load->view('default/excel_header'); ?>

<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<?php 
	
	$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
	
	if(isset($user))
	{
		echo "<tr><td colspan='5'>REPORT PERFORMANCE - ";
		if(isset($month))
		{
			echo strtoupper($bulan[$month]);
		}
		if(isset($year))
		{
			echo " ".$year."</td></tr>";
		}
		echo "<tr><td colspan='5'>&nbsp;</td></tr>";
		echo "<tr><td colspan='5'><b>NPP : ".$user[0]->ID."</b></td></tr>";
		echo "<tr><td colspan='5'><b>".strtoupper($user[0]->USER_NAME)."</b></td></tr>";
		echo "<tr><td colspan='5'><b>".$user[0]->SALES_TYPE."</b></td></tr>";
	}
	echo "<tr><td>&nbsp;</td></tr>";
	
?>
</table>


<table width='' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#A5D3FA">NO.</th>
    <th bgcolor="#A5D3FA">PRODUCT KPI</th>
    <th bgcolor="#A5D3FA">BOBOT</th>
    <th bgcolor="#A5D3FA">REALISASI %</th>
    <th bgcolor="#A5D3FA">REALISASI TERBOBOT %</th>
    
</tr>
<?php 
$html = '';
if(isset($data))
		{
			$fin =0; $bfin=0; $rfin=0;
			$kik=0; $bkik=0; $rkik=0;
			$x=1;
			$y=0;
			$i=1;
			foreach($data as $row)
			{
				$cat   = ($row->BOBOT_CAT == 1)?'FINANCIAL':'KICKERS';
				$color = ($i%2)?"#ffffff":"#eeeeee";
				
				
				if($row->BOBOT_CAT == 1)
				{ 
					$fin += $row->REALISASI_TERBOBOT;
					$rfin += $row->REALISASI;
					$bfin += $row->BOBOT;
				}
				else 
				{ 
					$kik += $row->REALISASI_TERBOBOT;
					$rkik += $row->REALISASI;
					$bkik += $row->BOBOT;
					$y++;
				}
				
				if($row->BOBOT_CAT != 1 && $x == 1){				
					$html .= "<tr bgcolor='#BBBBBB'>\n";
					$html .= "<td width='' align='center'>&nbsp;</td> \n";
					$html .= "<td width='' align='left'  ><b>SUB KPI FINANCIAL</b></td> \n";
					$html .= "<td width='' align='center'><b>$bfin%</b></td> \n";
					$html .= "<td width='' align='center'><b>$rfin%</b></td> \n";
					$html .= "<td width='' align='center'><b>".$fin."%</b></b></td> \n";
					#$html .= "<td width='' align='left'  ><b>FINANCIAL</b></td> \n";
					$html .= "</tr> \n";
					
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->BOBOT_NAME."</td> \n";
					$html .= "<td width='' align='center'>".$row->BOBOT."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI_TERBOBOT."%</td> \n";
					#$html .= "<td width='' align='left'  >".$cat."</td> \n";
					$html .= "</tr> \n";
				} else {				
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->BOBOT_NAME."</td> \n";
					$html .= "<td width='' align='center'>".$row->BOBOT."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI_TERBOBOT."%</td> \n";
					#$html .= "<td width='' align='left'  >".$cat."</td> \n";
					$html .= "</tr> \n";
				}
				if($row->BOBOT_CAT != 1) $x++;
			}
			
				$html .= "<tr bgcolor='#BBBBBB'>\n";
				$html .= "<td width='' align='center'>&nbsp;</td> \n";
				$html .= "<td width='' align='left'  ><b>SUB KPI KICKER</b></td> \n";
				#$html .= "<td width='' align='center'><b>".number_format(($bkik/$y),2,'.',',')."%</b></td> \n";
				$html .= "<td width='' align='center'><b>".round($bkik)."%</b></td> \n";
				$html .= "<td width='' align='center'><b>".number_format(($rkik/$y),2,'.',',')."%</b></td> \n";
				$html .= "<td width='' align='center'><b>".number_format(($kik/$y),2,'.',',')."%</b></b></td> \n";
				#$html .= "<td width='' align='left'  ><b>$cat</b></td> \n";
				$html .= "</tr> \n";
			
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		echo $html
?>
</table>