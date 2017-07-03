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
		echo "<tr><td colspan='5'>&nbsp;</td></tr>";
		echo "<tr><td colspan='5'><b>".$user[0]->ID;
		echo " ".strtoupper($user[0]->USER_NAME)." ";
		echo "(".$user[0]->SALES_TYPE.")</b></td></tr>";
	}
	echo "<tr><td>&nbsp;</td></tr>";
	
?>
</table>


<table width='' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">No.</th>
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
		$target = 0;
				$pencapaian = 0;
				$realisasi = 0;
				
				$target = ($row->PROC_ID == '8' || $row->PROC_ID == '10' || $row->PROC_ID == '16' )?$row->TARGET:$row->TARGET+$row->OUTSTANDING;				
				
				$pencapaian = $row->PENCAPAIAN;
				$baseline = $row->OUTSTANDING;
				$proc = $row->PROC_ID;
				$product_id=$row->PRODUCT_ID;
				if($proc==1 || $proc==2 || $proc==3 || $proc==4 || $proc==5 || $proc==6)
				{ 
						$target = $row->TARGET;
						$pencapaian = $row->PENCAPAIAN - $baseline ;
				}
				elseif($proc == 16)
				{
				$pencapaian = number_format($row->PENCAPAIAN,2,'.',',');
				} 
				if($target <> 0)
				#{ $realisasi = ($pencapaian/$target)*100 ;}
				{ 
					if($proc == 1 || $proc == 2 || $proc == 3)
						$realisasi = (($row->PENCAPAIAN-$baseline)/(($baseline+$target)-$baseline))*100;
					else
						$realisasi = ($pencapaian/$target)*100;
				}
				else $realisasi = 0;
				
				#$realisasi = ($realisasi > 20000)?200:$realisasi;
				$realisasi = ($realisasi < 0)?0:$realisasi;
				
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->PRODUCT_NAME."</td>\n";
				#$html .= "	<td>".$row->PROC_ID."</td>\n";
				if($product_id == 38 )
				{
				$html .= "	<td align='right'>".number_format($target,2,'.',',')."</td>\n";
				}else{
				$html .= "	<td align='right'>".number_format($target,0,'.',',')."</td>\n";
				}
				if($product_id == 38 )
				{
				$html .= "	<td align='right'>".number_format($pencapaian,2,'.',',')."</td>\n";
				}else{
				$html .= "	<td align='right'>".number_format($pencapaian,0,'.',',')."</td>\n";
				}
				$html .= "	<td align='right'>".round($realisasi)."%</td>\n";
				$html .= "</tr>\n";
				$i++;

	}
	//added by Fredy
				$html .= "</table>\n";
				$html .= "\n";
				
				$html .= "<br>PENAMBAHAN MANUAL\n";
				$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report' border='1'>\n";
				$html 	.= "<tr  bgcolor='##FFCC00'>\n
						<th align='center'>No.</th>\n
						<th>Jenis DPK</th>\n						
						<th align='center'>Giro</th>\n
						<th align='center'>Tabungan</th>\n
						<th align='center'>Deposito</th>\n
						<th align='center'>Griya</th>\n
						<th align='center'>Fleksi</th>\n
						<th align='center'>Multiguna</th>\n
					</tr>\n";
			
			$j=1;			
				foreach($data2 as $row)
			{
				$dpk_tambahan[$j] = $row->DPK_TAMBAHAN;
				$j++;
			}
			
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>1</td>\n";
				$html .= "	<td>PERORANGAN</td>\n";
				$html .= "	<td align='right'>".number_format($dpk_tambahan[2],0,'.',',')."</td>\n";
				$html .= "	<td align='right'>".number_format($dpk_tambahan[1],0,'.',',')."</td>\n";
				$html .= "	<td align='right'>".number_format($dpk_tambahan[3],0,'.',',')."</td>\n";
				$html .= "	<td align='right'>".number_format($dpk_tambahan[4],0,'.',',')."</td>\n";
				$html .= "	<td align='right'>".number_format($dpk_tambahan[5],0,'.',',')."</td>\n";
				$html .= "	<td align='right'>".number_format($dpk_tambahan[6],0,'.',',')."</td>\n";
				$html .= "</tr>\n";
		
		//added by Fredy
				$html .= "</table>\n";
				$html .= "\n";
				
				$html .= "<br><span style='color:#c00'>Pengurangan Manual\n</span>";
				$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report' border='1'>\n";
				$html 	.= "<tr  bgcolor='##FFCC00'>\n
						<th align='center'><span style='color:#c00'>No.</span></th>\n
						<th><span style='color:#c00'>Jenis DPK</span></th>\n						
						<th align='center'><span style='color:#c00'>Giro</span></th>\n
						<th align='center'><span style='color:#c00'>Tabungan</span></th>\n
						<th align='center'><span style='color:#c00'>Deposito</span></th>\n
						<th align='center'><span style='color:#c00'>Griya</span></th>\n
						<th align='center'><span style='color:#c00'>Fleksi</span></th>\n
						<th align='center'><span style='color:#c00'>Multiguna</span></th>\n
					</tr>\n";
			
			$r=1;			
				foreach($data3 as $row)
			{
				$dpk_kurang[$r] = $row->DPK_KURANG;
				$r++;
			}
			
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'><span style='color:#c00'>1</span></td>\n";
				$html .= "	<td><span style='color:#c00'>PERORANGAN</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[2],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[1],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[3],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[4],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[5],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[6],0,'.',',')."</span></td>\n";
				$html .= "</tr>\n";
				
				
	echo $html;
}
?>
</table>