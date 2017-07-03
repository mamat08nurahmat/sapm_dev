<?php $this->load->view('default/excel_header'); ?>

<!------
<html>
<head>
<title>XXXXXXXXXXXXXXXXXXX</title>
</head>
<body>
------>



<!-- Content -->

<table width='700' cellpadding='5' cellspacing='1' border="0">
<tr><td colspan='5' ><h3>REPORT WORKSHEET SALES PIPELINE - MM - YYYYY</h3><td></tr>
<tr><td colspan='5' ><h3>SUMBER XXXX </h3><td></tr>
<tr><td colspan='5' >&nbsp;<td></tr>
<tr><td colspan='5' ><h3>ID </h3><td></tr>
<tr><td colspan='5' ><h3>USER_NAME </h3><td></tr>
<tr><td colspan='5' ><h3>SALES_TYPE </h3><td></tr>
<tr><td colspan='5' >&nbsp;<td></tr>
<?php 




/*
	$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
	
	if(isset($user))
	{
		
		echo "<tr><td colspan='5'><h3>REPORT WORKSHEET SALES PIPELINE - ";
		if(isset($month))
		{
			echo strtoupper($bulan[$month]);
		}
		if(isset($year))
		{
			echo " ".$year."</h3></td></tr>";
		}
		$ket = '';
				if($sourcedata == 0) $ket = 'ALL LEADS';
				if($sourcedata == 1) $ket = 'LEADS KELOLAAN';
				if($sourcedata == 2) $ket = 'LEADS PROSPEK';
				if(sourcedata == 3) $ket = 'LEADS 50046';
				if(sourcedata == 4) $ket = 'LEADS PROPENSITY';
				if(sourcedata == 5) $ket = 'ACCOUNT PLAN';
		echo "<tr><td colspan='5'><h3>SUMBER ".$ket."</h3></td></tr>";
		echo "<tr><td colspan='5'>&nbsp;</td></tr>";
		echo "<tr><td colspan='5'><b>".$user[0]->ID;
		echo " ".strtoupper($user[0]->USER_NAME)." ";
		echo "(".$user[0]->SALES_TYPE.")</b></td></tr>";
	}
	echo "<tr><td>&nbsp;</td></tr>";
	
*/
?>
</table>

<table width='900' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00">CALLS</th>
	<th bgcolor="#FFCC00">OPPORTUNITY</th>
	<th bgcolor="#FFCC00">APPOINTMENT</th>
	<th bgcolor="#FFCC00">APPLICATION</th>
	<th bgcolor="#FFCC00">APPROVAL</th>
	<th bgcolor="#FFCC00">ACCEPTANCE</th>
	<th bgcolor="#FFCC00">DRAWDOWN</th>
</tr>
<tr>
	<td align='center' bgcolor="#eeeeee">TARGET</th>
	<td align='center' bgcolor="#eeeeee">100 %</th>
	<td align='center' bgcolor="#eeeeee">30 %</th>
	<td align='center' bgcolor="#eeeeee">25 %</th>
	<td align='center' bgcolor="#eeeeee">10 %</th>
	<td align='center' bgcolor="#eeeeee">8 %</th>
	<td align='center' bgcolor="#eeeeee">8 %</td>
	<td align='center' bgcolor="#eeeeee">8 %</td>
</tr>                
<?php 
//MAKE TARGET STAGE
if(isset($data6)){
	$i = 1;
	$color = '#ffffff';
	foreach($data6 as $row){
		$color = ($i%2)?"#eeeeee":"#ffffff";
		echo "
		<tr>
			<td align='center' width='60' bgcolor='$color'>REALISASI</td>";
			if($row->PERSEN_C >= 100)
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#00CC33;'>".$row->PERSEN_C." %</span></td>";
				}
				else
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#FF0000;'>".$row->PERSEN_C." %</span></td>";
			}
					if($row->PERSEN_O >= 30)
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#00CC33;'>".$row->PERSEN_O." %</span></td>";
				}
				else
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#FF0000;'>".$row->PERSEN_O." %</span></td>";
			}	
				if($row->PERSEN_A >= 25)
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#00CC33;'>".$row->PERSEN_A." %</span></td>";
				}
				else
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#FF0000;'>".$row->PERSEN_A." %</span></td>";
			}
				if($row->PERSEN_APP >= 10)
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#00CC33;'>".$row->PERSEN_APP." %</span></td>";
				}
				else
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#FF0000;'>".$row->PERSEN_APP." %</span></td>";
			}
				if($row->PERSEN_APR >= 8)
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#00CC33;'>".$row->PERSEN_APR." %</span></td>";
				}
				else
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#FF0000;'>".$row->PERSEN_APR." %</span></td>";
			}
				if($row->PERSEN_ACC >= 8)
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#00CC33;'>".$row->PERSEN_ACC." %</span></td>";
				}
				else
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#FF0000;'>".$row->PERSEN_ACC." %</span></td>";
			}
			if($row->PERSEN_DD >= 8)
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#00CC33;'>".$row->PERSEN_DD." %</span></td>";
				}
				else
				{
				echo "<td align='center' width='40' bgcolor='$color'><span style='color:#FF0000;'>".$row->PERSEN_DD." %</span></td>";
			}
			echo"
		</tr>";
	}
}
?>
</table>
<?php echo "<br />";?>
<table width='900' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">No.</th>
 	<th bgcolor="#FFCC00">KATEGORI</th>
	<th bgcolor="#FFCC00">LEADS</th>
	<th bgcolor="#FFCC00">CALLS</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">OPPORTUNITY</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">APPOINTMENT</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">APPLICATION</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">APPROVAL</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">ACCEPTANCE</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">DRAWDOWN</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">ACTUAL</th>
	<th bgcolor="#FFCC00">PLAN</th>
	<th bgcolor="#FFCC00">VARIANCE</th>
</tr>
<?php 

if(isset($data3)){
	$i = 1;
	$color = '#ffffff';
	foreach($data3 as $row){
		$color = ($i%2)?"#eeeeee":"#ffffff";
		echo "
		<tr>
			<td align='center' width='60' bgcolor='$color'>".$i++."</td>
			<td align='center' width='100' bgcolor='$color'>".$row->KATEGORI."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->LEADS."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->CALLS."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_C."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->OPPORTUNITY."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_O."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPOINTMENT."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_A."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPLICATION."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APP."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPROVAL."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APR."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACCEPTANCE."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_ACC."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->DRAWDOWN."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_DD."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->NOMINAL)."</td>
						<td align='center' width='40' bgcolor='$color'>".number_format($row->RENCANA)."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->VARIANCE)."</td>
		</tr>";
	}
}
?>
</table>

<table width='900' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00"></th>
 	<th bgcolor="#FFCC00">PRODUK</th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
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
			<td align='center' width='100' bgcolor='$color'>".$row->PRODUCT_NAME."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->LEADS."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->CALLS."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_C."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->OPPORTUNITY."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_O."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPOINTMENT."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_A."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPLICATION."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APP."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPROVAL."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APR."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACCEPTANCE."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_ACC."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->DRAWDOWN."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_DD."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->NOMINAL)."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->RENCANA)."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->VARIANCE)."</td>
		</tr>";
	}
}
?>
</table>
<?php
echo "<br />";
echo "<br />";
?>

<table width='900' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">No.</th>
 	<th bgcolor="#FFCC00">KATEGORI</th>
	<th bgcolor="#FFCC00">LEADS</th>
	<th bgcolor="#FFCC00">CALLS</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">OPPORTUNITY</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">APPOINTMENT</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">APPLICATION</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">APPROVAL</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">ACCEPTANCE</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">DRAWDOWN</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">ACTUAL</th>
	<th bgcolor="#FFCC00">PLAN</th>
	<th bgcolor="#FFCC00">VARIANCE</th>
</tr>
<?php 

if(isset($data4)){
	$i = 1;
	$color = '#ffffff';
	foreach($data4 as $row){
		$color = ($i%2)?"#eeeeee":"#ffffff";
		echo "
		<tr>
			<td align='center' width='60' bgcolor='$color'>".$i++."</td>
			<td align='center' width='100' bgcolor='$color'>".$row->KATEGORI."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->LEADS."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->CALLS."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_C."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->OPPORTUNITY."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_O."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPOINTMENT."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_A."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPLICATION."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APP."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPROVAL."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APR."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACCEPTANCE."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_ACC."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->DRAWDOWN."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_DD."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->NOMINAL)."</td>
						<td align='center' width='40' bgcolor='$color'>".number_format($row->RENCANA)."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->VARIANCE)."</td>
		</tr>";
	}
}
?>
</table>

<table width='900' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00"></th>
 	<th bgcolor="#FFCC00">PRODUK</th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
</tr>
<?php 

if(isset($data1)){
	$i = 1;
	$color = '#ffffff';
	foreach($data1 as $row){
		$color = ($i%2)?"#eeeeee":"#ffffff";
		echo "
		<tr>
			<td align='center' width='60' bgcolor='$color'>".$i++."</td>
			<td align='center' width='100' bgcolor='$color'>".$row->PRODUCT_NAME."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->LEADS."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->CALLS."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_C."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->OPPORTUNITY."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_O."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPOINTMENT."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_A."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPLICATION."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APP."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPROVAL."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APR."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACCEPTANCE."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_ACC."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->DRAWDOWN."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_DD."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->NOMINAL)."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->RENCANA)."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->VARIANCE)."</td>
		</tr>";
	}
}
?>
</table>
<?php
echo "<br />";
echo "<br />";
?>
<table width='900' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00">No.</th>
 	<th bgcolor="#FFCC00">KATEGORI</th>
	<th bgcolor="#FFCC00">LEADS</th>
	<th bgcolor="#FFCC00">CALLS</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">OPPORTUNITY</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">APPOINTMENT</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">APPLICATION</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">APPROVAL</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">ACCEPTANCE</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">DRAWDOWN</th>
	<th bgcolor="#FFCC00">%</th>
	<th bgcolor="#FFCC00">ACTUAL</th>
	<th bgcolor="#FFCC00">PLAN</th>
	<th bgcolor="#FFCC00">VARIANCE</th>
</tr>
<?php 

if(isset($data5)){
	$i = 1;
	$color = '#ffffff';
	foreach($data5 as $row){
		$color = ($i%2)?"#eeeeee":"#ffffff";
		echo "
		<tr>
			<td align='center' width='60' bgcolor='$color'>".$i++."</td>
			<td align='center' width='100' bgcolor='$color'>".$row->KATEGORI."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->LEADS."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->CALLS."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_C."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->OPPORTUNITY."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_O."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPOINTMENT."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_A."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPLICATION."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APP."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPROVAL."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APR."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACCEPTANCE."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_ACC."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->DRAWDOWN."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_DD."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->NOMINAL)."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->RENCANA)."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->VARIANCE)."</td>
		</tr>";
	}
}
?>
</table>

<table width='900' cellpadding='5' cellspacing='1' border="1">
<tr>
	<th bgcolor="#FFCC00"></th>
 	<th bgcolor="#FFCC00">PRODUK</th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
	<th bgcolor="#FFCC00"></th>
</tr>
<?php 

if(isset($data2)){
	$i = 1;
	$color = '#ffffff';
	foreach($data2 as $row){
		$color = ($i%2)?"#eeeeee":"#ffffff";
		echo "
		<tr>
			<td align='center' width='60' bgcolor='$color'>".$i++."</td>
			<td align='center' width='100' bgcolor='$color'>".$row->PRODUCT_NAME."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->LEADS."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->CALLS."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_C."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->OPPORTUNITY."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_O."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPOINTMENT."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_A."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPLICATION."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APP."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->APPROVAL."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_APR."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->ACCEPTANCE."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_ACC."</td>
			<td align='center' width='60' bgcolor='$color'>".$row->DRAWDOWN."</td>
			<td align='center' width='40' bgcolor='$color'>".$row->PERSEN_DD."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->NOMINAL)."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->RENCANA)."</td>
			<td align='center' width='40' bgcolor='$color'>".number_format($row->VARIANCE)."</td>
		</tr>";
	}
}
?>
</table>


<!---
</body>
</html>
-->