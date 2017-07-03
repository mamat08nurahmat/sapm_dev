<?php 
	$filename = "report_".date("d-M-Y_h-i-s");
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Expires: 0");
	header("Content-type: application/vnd.ms-excel"); 
	header("Content-Disposition: attachment; filename=".$filename.".xls");
?>