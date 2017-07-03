<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CSV</title>
</head>

<body>

<?php
	$html = "<table cellpadding=5 cellspacing=1 bgcolor='#cccccc'>\n";
	$html .= "<tr>\n";
	$html .= "<th>ID</th>\n";
	$html .= "<th>NPP</th>\n";
	$html .= "<th>NAME</th>\n";
	$html .= "<th>PRODUCT</th>\n";
	$html .= "<th>PENCAPAIAN</th>\n";
	$html .= "<th>YEAR</th>\n";
	$html .= "<th>MONTH</th>\n";
	$html .= "</tr>\n";
	if($csvData)
	{
		#echo "<pre>";print_r($csvData);	echo "</pre>"; die();
		foreach ($csvData as $row)
		{
			$html .= "<tr  bgcolor='#ffffff'>";
			$html .= "<td>".$row['ID']."</td>";
			$html .= "<td>".$row['SALES_ID']."</td>";
			$html .= "<td>".$row['USER_NAME']."</td>";
			$html .= "<td>".$row['PRODUCT_NAME']."</td>";
			$html .= "<td>".$row['PENCAPAIAN']."</td>";
			$html .= "<td>".$row['Y']."</td>";
			$html .= "<td>".$row['M']."</td>";
			$html .= "<tr>\n";
		} 
	} else { $html .= "<tr><td colspan=8>Tidak ada data !</td></tr>\n"; }
	$html .= "</table>";
	
	echo $html; 
?>


</body>
</html>
