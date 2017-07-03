<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Account_planning extends Controller
{

	function Account_planning()
	{
		parent::Controller();

		$this->load->helper('form');
		$this->load->library('PHPExcel/IOFactory');
		$this->load->library('PHPExcel');
		if ($_SESSION['ID'] == '')
		{
			redirect('login');
		}
		$this->load->model('_handler');
		$this->load->model('_news');
		$this->load->model('_account_planning');
		$this->load->model('_report');
date_default_timezone_set('Asia/Jakarta');
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");
		$this->_handler->update_session($now, $session_id);
	}

	function index()
	{
		echo"AAAAAAAAAAAAAA";
	}
	
	function remove()
	{
		$cif = $_POST['cif'];
		$response = $this->_account_planning->remove_ap_from_list($cif);
		echo $response;
	}

	function report()
	{
		$data = $this->list_user();
		$this->load->view('account_planning/report',$data);
	/*
	echo"XXXXXXXXXXXXXXXXXXXXXX";
	*/	
	}
	
	function report_new()
	{
		$data = $this->list_user();
		$this->load->view('account_planning/report_new',$data);
	/*
	echo"XXXXXXXXXXXXXXXXXXXXXX";
	*/	
	}
	
//------------------
	function get_report_new($id,$month, $year)
	{

		$user	= $this->_report->get_user($id);
#print_r($user); die();
		if ($_SESSION['USER_LEVEL'] == 'USERMGT')
			redirect('forbiden/index/2');

		$data = $this->_account_planning->get_report_by_sales($id, $month, $year);
#print_r($data); die();
		$npp = $user[0]->ID;
		$sales = $user[0]->SALES_TYPE;
		$name = strtoupper($user[0]->USER_NAME);
		$ket = ($month != 0) ? date('F Y', strtotime("01-$month-$year")) : '';

		$html = "";
		$html .= "NPP : " . $npp . "<br />\n";
		$html .= "NAMA : " . $name . "<br />\n";
		$html .= "SALES TYPE : " . $sales . "<br />\n";
		$html .= "PERIODE : " . strtoupper($ket) . "<br /><br />\n";
		$html .= "\n";
		$html .= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html .= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>SALES</th>\n
						<th align='center' class='kecil'>CIF</th>\n		
						<th align='center' class='kecil'>NAMA</th>\n						
						<th align='center' class='kecil'>PRODUCT</th>\n
						<th align='right' class='kecil'>RENCANA</th>\n
						<th align='right' class='kecil'>TARGET</th>\n
					</tr>\n";

		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if ($data)
		{
			foreach ($data as $row)
			{
				$color = ($i % 2) ? "#ffffff" : "#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>" . $i++ . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['SALES_ID'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CIF_KEY'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_NAME'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['PRODUCT_NAME'] . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['RENCANA'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['TARGET'], 2, '.', ',') . "</td> \n";
				$html .= "</tr> \n";
			}
		}
		else
		{
			$html .= "<tr>\n";
			$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";
			$html .= "</tr>\n";
		}
		$html .= "</table> \n";

		echo $html;
/*
*/		
	}

//-----------------	
	
	function report_combine()
	{
		$data = $this->list_user();
		$this->load->view('account_planning/report_pipeline_combine',$data);
	}
	
	function get_report($id,$month, $year)
	{
		$user	= $this->_report->get_user($id);
#print_r($user); die();
		if ($_SESSION['USER_LEVEL'] == 'USERMGT')
			redirect('forbiden/index/2');

		$data = $this->_account_planning->get_report_by_sales($id, $month, $year);

		$npp = $user[0]->ID;
		$sales = $user[0]->SALES_TYPE;
		$name = strtoupper($user[0]->USER_NAME);
		$ket = ($month != 0) ? date('F Y', strtotime("01-$month-$year")) : '';

		$html = "";
		$html .= "NPP : " . $npp . "<br />\n";
		$html .= "NAMA : " . $name . "<br />\n";
		$html .= "SALES TYPE : " . $sales . "<br />\n";
		$html .= "PERIODE : " . strtoupper($ket) . "<br /><br />\n";
		$html .= "\n";
		$html .= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html .= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>SALES</th>\n
						<th align='center' class='kecil'>CIF</th>\n		
						<th align='center' class='kecil'>NAMA</th>\n						
						<th align='center' class='kecil'>PRODUCT</th>\n
						<th align='right' class='kecil'>RENCANA</th>\n
						<th align='right' class='kecil'>TARGET</th>\n
					</tr>\n";

		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if ($data)
		{
			foreach ($data as $row)
			{
				$color = ($i % 2) ? "#ffffff" : "#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>" . $i++ . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['SALES_ID'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CIF_KEY'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_NAME'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['PRODUCT_NAME'] . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['RENCANA'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['TARGET'], 2, '.', ',') . "</td> \n";
				$html .= "</tr> \n";
			}
		}
		else
		{
			$html .= "<tr>\n";
			$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";
			$html .= "</tr>\n";
		}
		$html .= "</table> \n";

		echo $html;
	}

	// create report in excel
	function xls_report($id = 0,$m = 0, $y = 0)
	{
		$ket = ($m != 0) ? date('F Y', strtotime("01-$m-$y")) : '';
		
		$user	= $this->_report->get_user($id);

		$dbdata = $this->_account_planning->get_report_by_sales($id, $m, $y);
		
		$npp = $user[0]->ID;
		$sales = $user[0]->SALES_TYPE;
		$name = strtoupper($user[0]->USER_NAME);

		$fields = array('SALES_ID', 'CIF_KEY', 'CUST_NAME', 'PRODUCT_NAME', 'RENCANA', 'TARGET');
		$header = array('SALES', 'CIF', 'NAMA', 'PRODUCT', 'RENCANA', 'TARGET');
		$number_format = array(0, 0, 0, 0, 1, 1);
		$addition = array('Report' => 'ACCOUNT PLANNING', 'Npp' => $npp, 'Nama' => $name, 'Sales' => $sales, 'Periode' => $ket);
		$title = 'ACCOUNT PLANNING';
		$file_name = 'report_account_planning' . $param['ID'] . '.xls';
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
	}
	
	function xls_report1($id = 0,$m = 0,$y = 0)
	{
		$ket = ($m != 0) ? date('F Y', strtotime("01-$m-$y")) : '';
		
		$user	= $this->_report->get_user($id);

		$dbdata = $this->_account_planning->get_report_tmp_ap($id, $m, $y);
		
		$npp = $user[0]->ID;
		$sales = $user[0]->SALES_TYPE;
		$name = strtoupper($user[0]->USER_NAME);

		$fields = array('SALES_ID', 'CIF_KEY', 'PRODUCT_NAME', 'RENCANA', 'TARGET' , 'MONTH' ,'YEAR');
		$header = array('SALES', 'CIF', 'PRODUCT', 'RENCANA', 'TARGET','BULAN' , 'TAHUN');
		$number_format = array(0, 0, 0, 1, 1);
		$addition = array('Report' => 'ACCOUNT PLANNING', 'Npp' => $npp, 'Nama' => $name, 'Sales' => $sales, 'Periode' => $ket);
		$title = 'ACCOUNT PLANNING';
		$file_name = 'account_planning' . $param['ID'] . '.xls';
		$this->to_excela($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
	}

	function to_excel($header, $addition, $fields, $datadb, $title, $filename, $number_format, $sum)
	{
		# variable data
		#$header = array('Npp','Nama','Email','Kode Cabang');
		#$fields = array('npp','nama','email','kode_cabang');		
		#$title = 'List User';
		#$filename = 'list_user.xls';
		$creator = 'SAPM';
		$chr = range('A', 'Z');
		$num_fields = count($header);
		$row_start = 6;

		# create new object
		$objPHPExcel = new PHPExcel();

		# Set properties
		$objPHPExcel->getProperties()->setCreator($creator);

		# Add aditional Header
		$x = 1;
		foreach ($addition as $arr => $row)
		{
			$objPHPExcel->getActiveSheet()->mergeCells("B$x:H$x");
			$objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $x, $arr);
			$objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $x, $row);
			$x++;
		}

		# Add data header
		for ($i = 1; $i <= $num_fields; $i++)
		{
			$objPHPExcel->setActiveSheetIndex()->setCellValue($chr[$i - 1] . $row_start, $header[$i - 1]);
		}

		# get Data from database
		$result = $datadb;
		$data = $result;

		if(!empty($data))
		{
			# write data to cell
			$cell = '';
			$value = '';
			for ($i = 1; $i <= $num_fields; $i++)
			{
				$start = $row_start + 1;
				foreach ($data as $row)
				{
					$cell = $chr[$i - 1] . ($start++);
					$value = $row[$fields[$i - 1]];
					$objPHPExcel->setActiveSheetIndex()->setCellValue($cell, $value);
					if ($number_format[$i - 1] != 0)
						$objPHPExcel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0.00');
				}
			}
			
			# SUM collumn
			for ($i = 0; $i <= $num_fields - 1; $i++)
			{
				if ($sum[$i] == 1)
				{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($chr[$i] . $start, '=SUM(' . $chr[$i] . ($row_start + 1) . ':' . $chr[$i] . ($start - 1) . ')');
					$objPHPExcel->getActiveSheet()->getStyle($chr[$i] . $start)->getNumberFormat()->setFormatCode('#,##0.00');
					$objPHPExcel->getActiveSheet()->getStyle($chr[$i] . $start)->getFont()->setSize(12)->getColor()->setARGB('FFFFFFFF');
					$objPHPExcel->getActiveSheet()->getStyle($chr[$i] . $start)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle($chr[$i] . $start)->getFill()->getStartColor()->setARGB('FF555555');
				}
			}
			
			# format cell (make cell width autosize)
			for ($i = 1; $i <= $num_fields; $i++)
			{
				$objPHPExcel->getActiveSheet()->getColumnDimension($chr[$i - 1])->setAutoSize(true);
			}
			
			# format cell (coloring header)
			$objPHPExcel->getActiveSheet()->getStyle($chr[0] . $row_start . ':' . $chr[$num_fields - 1] . $row_start)->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFAADDFF');
			
			# format cell (make all cell have border)
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('argb' => 'FF000000'),
					),
				),
			);
			$cell_start = $chr[0] . $row_start;
			$cell_end = $chr[$num_fields - 1] . $start;
			$objPHPExcel->getActiveSheet()->getStyle("$cell_start:$cell_end")->applyFromArray($styleArray);
			# Add format number
			for ($j = 0; $j < count($number_format); $j++)
			{
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getNumberFormat()->setFormatCode('#,##0.00');
			}
		}
		# Add title Active Sheet 		
		$objPHPExcel->getActiveSheet()->setTitle($title);

		# set default Active sheet		
		$objPHPExcel->setActiveSheetIndex(0);

		# set header for download
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	
	function to_excela($header, $addition, $fields, $datadb, $title, $filename, $number_format, $sum)
	{
		# variable data
		#$header = array('Npp','Nama','Email','Kode Cabang');
		#$fields = array('npp','nama','email','kode_cabang');		
		#$title = 'List User';
		#$filename = 'list_user.xls';
		$creator = 'SAPM';
		$chr = range('A', 'Z');
		$num_fields = count($header);
		$row_start = 6;

		# create new object
		$objPHPExcel = new PHPExcel();

		# Set properties
		$objPHPExcel->getProperties()->setCreator($creator);

		# Add aditional Header
		$x = 1;
		foreach ($addition as $arr => $row)
		{
			$objPHPExcel->getActiveSheet()->mergeCells("B$x:H$x");
			$objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $x, $arr);
			$objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $x, $row);
			$x++;
		}

		# Add data header
		for ($i = 1; $i <= $num_fields; $i++)
		{
			$objPHPExcel->setActiveSheetIndex()->setCellValue($chr[$i - 1] . $row_start, $header[$i - 1]);
		}

		# get Data from database
		$result = $datadb;
		$data = $result;

		if(!empty($data))
		{
			# write data to cell
			$cell = '';
			$value = '';
			for ($i = 1; $i <= $num_fields; $i++)
			{
				$start = $row_start + 1;
				foreach ($data as $row)
				{
					$cell = $chr[$i - 1] . ($start++);
					$value = $row[$fields[$i - 1]];
					$objPHPExcel->setActiveSheetIndex()->setCellValue($cell, $value);
					if ($number_format[$i - 1] != 0)
						$objPHPExcel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0.00');
				}
			}
			
			# SUM collumn
			for ($i = 0; $i <= $num_fields - 1; $i++)
			{
				if ($sum[$i] == 1)
				{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($chr[$i] . $start, '=SUM(' . $chr[$i] . ($row_start + 1) . ':' . $chr[$i] . ($start - 1) . ')');
					$objPHPExcel->getActiveSheet()->getStyle($chr[$i] . $start)->getNumberFormat()->setFormatCode('#,##0.00');
					$objPHPExcel->getActiveSheet()->getStyle($chr[$i] . $start)->getFont()->setSize(12)->getColor()->setARGB('FFFFFFFF');
					$objPHPExcel->getActiveSheet()->getStyle($chr[$i] . $start)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
					$objPHPExcel->getActiveSheet()->getStyle($chr[$i] . $start)->getFill()->getStartColor()->setARGB('FF555555');
				}
			}
			
			# format cell (make cell width autosize)
			for ($i = 1; $i <= $num_fields; $i++)
			{
				$objPHPExcel->getActiveSheet()->getColumnDimension($chr[$i - 1])->setAutoSize(true);
			}
			
			# format cell (coloring header)
			$objPHPExcel->getActiveSheet()->getStyle($chr[0] . $row_start . ':' . $chr[$num_fields - 1] . $row_start)->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFAADDFF');
			
			# format cell (make all cell have border)
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('argb' => 'FF000000'),
					),
				),
			);
			$cell_start = $chr[0] . $row_start;
			$cell_end = $chr[$num_fields - 1] . $start;
			$objPHPExcel->getActiveSheet()->getStyle("$cell_start:$cell_end")->applyFromArray($styleArray);
			# Add format number
			for ($j = 0; $j < count($number_format); $j++)
			{
				$objPHPExcel->getActiveSheet()->getStyle('A1')->getNumberFormat()->setFormatCode('#,##0.00');
			}
		}
		
		// Add disclosure
		
		$disX = count($data) + 10;
		$disY = count($data) + 11;
		$objPHPExcel->getActiveSheet()->mergeCells("A$disX:I$disX");
		$objPHPExcel->getActiveSheet()->mergeCells("A$disY:I$disY");
		$objPHPExcel->getActiveSheet()->getStyle("A$disX:I$disX")->getFont()->setSize(10)->getColor()->setRGB('F54E57');
		$objPHPExcel->getActiveSheet()->getStyle("A$disX:I$disX")->getFont()->setItalic(true);
		$objPHPExcel->getActiveSheet()->getStyle("A$disY:I$disY")->getFont()->setSize(10)->getColor()->setRGB('F54E57');
		$objPHPExcel->getActiveSheet()->getStyle("A$disY:I$disY")->getFont()->setItalic(true);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $disX, 'Disclosure : Bahwa data yang dikirim adalah data yang sebenarnya dan disepakati bersama serta telah mendapatkan persetujuan pimpinan unit. Apabila terdapat perbedaan data, maka yang digunakan adalah data system.');
		
		
		$ttdX = $disX + 3;
		$ttdY = $ttdX - 1;
		$ttd1 = $ttdX + 5;
		$ttd2 = $ttdX + 6;
		
		$objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $ttdX, 'Sales');
		$objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $ttdX, 'Supervisor');
		$objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $ttdX, 'Menyetujui :');
		$objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $ttdY, '.............. ,'.  date("j M Y"));
		
		$objPHPExcel->getActiveSheet()->getStyle("A$ttd2:I$ttd2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
		$objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $ttd1, $addition['Nama']);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $ttd2, $addition['Npp']);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $ttd1, $_SESSION['USER_NAME']);
		$objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $ttd2, $_SESSION['ID']);
		
		# Add title Active Sheet 		
		$objPHPExcel->getActiveSheet()->setTitle($title);

		# set default Active sheet		
		$objPHPExcel->setActiveSheetIndex(0);

		# set header for download
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	
	#-------------------------------------
	# 	Get Data Sales
	#-------------------------------------

	function get_sales()
	{
		$this->load->library('flexigrid');

		$valid_fields = array('ID', 'USER_NAME', 'SALES_TYPE', 'SPV', 'BRANCH_NAME', 'KODE', 'REGION');

		$this->flexigrid->validate_post('ID', 'asc', $valid_fields);
		$id = ($this->session->userdata('BRANCH_ID') <> '') ? $this->session->userdata('BRANCH_ID') : 0;
		$records = $this->_report->get_neo_search($id);
		$this->output->set_header($this->config->item('json_header'));

		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->ID,
				$row->ID,
				strtoupper($row->USER_NAME),
				$row->SALES_TYPE,
				$row->SPV,
				$row->BRANCH_NAME,
				$row->KODE,
				$row->REGION
			);
		}
		//Print please
		if (isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}

	
	function list_account_planning()
	{
		if($_SESSION['USER_LEVEL'] == 'SALES')
		{
				$data = $this->list_user_ap();
			$this->load->view('account_planning/list_account_planning',$data);
		}
		ELSE
		{
			$data = $this->list_user_ap();
			$this->load->view('account_planning/list_account_planning_spv',$data);
		}
	}
//----------------------------------------------------------------
	function list_account_planning_new()
	{
		if($_SESSION['USER_LEVEL'] == 'SALES')
		{
				$data = $this->list_user_ap();
			$this->load->view('account_planning/list_account_planning_new',$data);
		}
		ELSE
		{
			$data = $this->list_user_ap();
			$this->load->view('account_planning/list_account_planning_spv',$data);
		}
	}
	
	
	
	function list_account_planning_bm()
	{
		if($_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG' || $_SESSION['USER_LEVEL']=='PEMIMPIN_KLN-KK')
		{
			$this->load->view('account_planning/list_account_planning_bm',$data);
		}
	}
	
	function list_account_planning_spv_bm()
	{
		if($_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG' || $_SESSION['USER_LEVEL']=='PIMPINAN_WILAYAH')
		{
			$data = $this->list_user_ap_bm();
			$this->load->view('account_planning/list_account_planning_spv_bm',$data);
		}
	}
	
	function get_ap($id,$month, $year)
	{
//echo$id,$month, $year ;		
		$user	= $this->_report->get_user($id);
#print_r($user); die();

		if ($_SESSION['USER_LEVEL'] == 'USERMGT')
			redirect('forbiden/index/2');

		$data = $this->_account_planning->get_report_tmp_ap($id, $month, $year);
#print_r($data); die();
		$is_check = $this->_account_planning->cek_status_ap($id);
		
#print_r($is_check); die();
		
		$npp = $user[0]->ID;
		$sales = $user[0]->SALES_TYPE;
		$name = strtoupper($user[0]->USER_NAME);
		$ket = ($month != 0) ? date('F Y', strtotime("01-$month-$year")) : '';

		$html = "";
		$html .= "NPP : " . $npp . "<br />\n";
		$html .= "NAMA : " . $name . "<br />\n";
		$html .= "SALES TYPE : " . $sales . "<br />\n";
		$html .= "PERIODE : " . strtoupper($ket) . "<br /><br />\n";
		$html .= "\n";
//		if(($_SESSION['USER_LEVEL'] == 'SALES' || $_SESSION['USER_LEVEL'] == 'PIMPINAN_CABANG')&& $is_check== 0)
		if(($_SESSION['USER_LEVEL'] == 'SALES' || $_SESSION['USER_LEVEL'] == 'PIMPINAN_CABANG'))
		{
//		$html .= "<button id='add_ap'>Tambah Account Plan</button>&nbsp;&nbsp";
		
//		$html .= "<input name='add_ap' id='add_ap' type='button' value='Tambah Account Plan' href='google.com' >&nbsp;&nbsp";
		$html .= "<a href='http://192.168.3.14/new_sapm/index.php/activity/add_account_planning' ><button>Tambah Account Plan</button></a>&nbsp;&nbsp";

		
		
//		$html .= "<button id='kirim_usulan'>Kirim Usulan</button><br />";
		$html .= "<a href='/activity/add_account_planning' ><button>Kirim Usulan</button></a>&nbsp;&nbsp";

		$html .= "\n";
		}
		else if(($_SESSION['USER_LEVEL'] == 'SUPERVISOR' || $_SESSION['USER_LEVEL'] == 'CABANG' || $_SESSION['USER_LEVEL'] == 'WILAYAH' || $_SESSION['USER_LEVEL'] == 'PEMIMPIN_KLN-KK'  || $_SESSION['USER_LEVEL'] == 'PIMPINAN_CABANG' || $_SESSION['USER_LEVEL'] == 'PEMIMPIN_CABANG' || $_SESSION['USER_LEVEL'] == 'PIMPINAN_WILAYAH') && $is_check == 1)
		{
		
			//$a = date("j");
			//if ($a>=9)
			//{
			$html .= "<button id='btn_approve' rev='approve'>Approve</button> &nbsp;&nbsp;
								<button id='btn_reject' rev='reject'>Tolak</button> &nbsp;&nbsp;
								<button id='export'>Export to Excel</button>
								<br /><br />\n";
			//}
			//else
			//{
			//$html .= "
			//					<button id='btn_reject' rev='reject'>Tolak</button> &nbsp;&nbsp;
			//					<button id='export'>Export to Excel</button>
			//					<br /><br />\n";
			//}

		}
		$html .= "<br />";
		$html .= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html .= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n";
//		if($_SESSION['USER_LEVEL'] == 'SALES' && $is_check == 0)
		if($_SESSION['USER_LEVEL'] == 'SALES' )
				{
		$html .="	<th align='center' class='kecil'>Action</th>\n";		
				};				
		$html .="	<th align='center' class='kecil'>CIF</th>\n";
		
		$html .=	"<th align='center' class='kecil'>NAMA NASABAH</th>\n	
					<th align='center' class='kecil'>PRODUCT</th>\n
					<th align='right' class='kecil'>RENCANA</th>\n
					<th align='right' class='kecil'>TARGET</th>\n
					<th align='center' class='kecil'>STATUS VERIFIKASI</th>\n
					</tr>\n";

		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if ($data)
		{
			foreach ($data as $row)
			{
				$color = ($i % 2) ? "#ffffff" : "#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>" . $i++ . "</td> \n";
//				if($_SESSION['USER_LEVEL'] == 'SALES' && $is_check == 0)
				if($_SESSION['USER_LEVEL'] == 'SALES' )
				{
					$html .="<th align='right' class='kecil'><a class ='remove' id='".$row['ID']."' href='#'>Remove</a> </th>\n";
				}
				$html .= "<td width='' align='center' class='kecil'>" . $row['CIF_KEY'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_NAME'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['PRODUCT_NAME'] . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['RENCANA'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['TARGET'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['VERIFY_BY'] . "</td> \n";
				$html .= "</tr> \n";
			}
		}
		else
		{
			$html .= "<tr>\n";
			$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";
			$html .= "</tr>\n";
		}
		$html .= "</table> \n";

		echo $html;
/*
*/		
	}
	
	
	function kirim_usulan()
	{
		//if(!$this->isAjax())
			//redirect('forbiden/index/2');
		
		$npp_sales = $_SESSION['ID'];
		$response = $this->_account_planning->kirim_nasabah_usulan($npp_sales);
		
		echo $response;
	}
	
	function kirim_usulan_bm($id,$w,$m,$y)
	{
		//if(!$this->isAjax())
			//redirect('forbiden/index/2');
		
		$npp_sales = $_SESSION['ID'];
		$response = $this->_account_planning->kirim_nasabah_usulan_bm($id,$w,$m,$y);
		
		echo $response;
	}
	
	function get_sales_ap()
	{
		$this->load->library('flexigrid');

		$valid_fields = array('SALES_ID', 'USER_NAME', 'SPV');

		$this->flexigrid->validate_post('SALES_ID', 'asc', $valid_fields);
	
		$records = $this->_account_planning->get_sales_ap();
		$this->output->set_header($this->config->item('json_header'));

		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->SALES_ID,
				$row->SALES_ID,
				strtoupper($row->USER_NAME),
				$row->SPV
			);
		}
		//Print please
		if (isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
		function get_sales_ap_bm()
	{
		$this->load->library('flexigrid');

		$valid_fields = array('SALES_ID', 'USER_NAME', 'BRANCH_NAME');

		$this->flexigrid->validate_post('SALES_ID', 'asc', $valid_fields);
	
		$records = $this->_account_planning->get_sales_ap_bm();
		$this->output->set_header($this->config->item('json_header'));

		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->SALES_ID,
				$row->SALES_ID,
				strtoupper($row->USER_NAME),
				$row->BRANCH_NAME
			);
		}
		//Print please
		if (isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function list_user()
	{
		$this->load->helper('flexigrid');

		$colModel['ID'] = array('NPP', 40, TRUE, 'center', 2);
		$colModel['USER_NAME'] = array('NAMA', 200, TRUE, 'left', 1);
		$colModel['SPV'] = array('SPV', 50, TRUE, 'left', 1);

		$gridParams = array(
			'width' => 460,
			'height' => 300,
			'rp' => 10,
			'rpOptions' => '[10,25,50,100]',
			'pagestat' => '{from} to {to} of {total} items.',
			'blockOpacity' => 0.5,
			'title' => 'LIST DATA SALES',
			'showTableToggleBtn' => false
		);

		$buttons[] = array('Pilih', 'add', 'pilih_data');
		$buttons[] = array('separator');
		$grid_js = build_grid_js('search_list_user', site_url("/account_planning/get_sales"), $colModel, 'a.ID', 'ASC', $gridParams, $buttons);
		$data['js_grid'] = $grid_js;
		return $data;
	}
	
	function list_user_ap()
	{
		$this->load->helper('flexigrid');

		$colModel['SALES_ID'] = array('NPP', 40, TRUE, 'center', 2);
		$colModel['USER_NAME'] = array('NAMA', 200, TRUE, 'left', 1);
		$colModel['SPV'] = array('SPV', 50, TRUE, 'left', 1);

		$gridParams = array(
			'width' => 460,
			'height' => 300,
			'rp' => 10,
			'rpOptions' => '[10,25,50,100]',
			'pagestat' => '{from} to {to} of {total} items.',
			'blockOpacity' => 0.5,
			'title' => 'LIST DATA SALES',
			'showTableToggleBtn' => false
		);

		$buttons[] = array('Pilih', 'add', 'pilih_data');
		$buttons[] = array('separator');
		$grid_js = build_grid_js('search_list_user', site_url("/account_planning/get_sales_ap"), $colModel, 'a.SALES_ID', 'ASC', $gridParams, $buttons);
		$data['js_grid'] = $grid_js;
		return $data;
	}
	
	function list_user_ap_bm()
	{
		$this->load->helper('flexigrid');

		$colModel['SALES_ID'] = array('NPP', 40, TRUE, 'center', 2);
		$colModel['USER_NAME'] = array('NAMA', 200, TRUE, 'left', 1);
		$colModel['BRANCH_NAME'] = array('CABANG', 120, TRUE, 'left', 1);
		$colModel['SPV'] = array('SPV', 50, TRUE, 'left', 1);
		
		$gridParams = array(
			'width' => 460,
			'height' => 300,
			'rp' => 10,
			'rpOptions' => '[10,25,50,100]',
			'pagestat' => '{from} to {to} of {total} items.',
			'blockOpacity' => 0.5,
			'title' => 'LIST DATA PEMIMPIN',
			'showTableToggleBtn' => false
		);

		$buttons[] = array('Pilih', 'add', 'pilih_data_bm');
		$buttons[] = array('separator');
		$grid_js_bm = build_grid_js('search_list_user_bm', site_url("/account_planning/get_sales_ap_bm"), $colModel, 'SALES_ID', 'ASC', $gridParams, $buttons);
		$data['js_grid_bm'] = $grid_js_bm;
		return $data;
	}
	
	function approve()
	{
		#if(!$this->isAjax())
			#redirect('forbiden/index/2');
		
		$mode = $_POST['mode'];
		$npp_sales = $_POST['npp'];
		$month = $_POST['month'];
		$year = $_POST['year'];
		
			
		$response = $this->_account_planning->approval_ap($mode, $npp_sales,$month,$year);
		
		echo $response;
		$this->_account_planning->save_pipeline_master($npp_sales);
		$data['npp']=$npp_sales;
		$this->_account_planning->save_pipeline_staging($data);
	}
	
	function approve_bm()
	{
		#if(!$this->isAjax())
			#redirect('forbiden/index/2');
		
		$mode = $_POST['mode'];
		$id= $_POST['npp'];
		$week = $_POST['week'];
		$month = $_POST['month'];
		$year = $_POST['year'];
		
			
		$response = $this->_account_planning->approval_ap_bm($mode, $id,$week,$month,$year);
		
		echo $response;
	}
	
	function approve1()
	{
		#if(!$this->isAjax())
			#redirect('forbiden/index/2');
		
		$mode = $_POST['mode'];
		$npp_sales = $_POST['npp'];
		$month = $_POST['month'];
		$year = $_POST['year'];
	
		$response = $this->_account_planning->approval_ap1($mode, $npp_sales,$month,$year);
		
		echo $response;
		//$this->_account_planning->save_pipeline_master($npp_sales);
		//$data['npp']=$npp_sales;
		//$this->_account_planning->save_pipeline_staging($data);
	}
	
	function reject()
	{
		#if(!$this->isAjax())
			#redirect('forbiden/index/2');
		
		$mode = $_POST['mode'];
		$id= $_POST['npp'];
		$week = $_POST['week'];
		$month = $_POST['month'];
		$year = $_POST['year'];
		
			
		$response = $this->_account_planning->reject($mode, $id,$week,$month,$year);
		
		echo $response;
	}
	
	function get_ap_bm($id, $week, $month, $year)
	{
		$user	= $this->_report->get_user($id);

		if ($_SESSION['USER_LEVEL'] == 'USERMGT')
			redirect('forbiden/index/2');

		$data = $this->_account_planning->get_report_tmp_ap_bm($id, $week, $month, $year);
		$is_check = $this->_account_planning->cek_status_ap_bm($id,$week, $month, $year);
		$is_own = $this->_account_planning->cek_own_ap_bm($id,$week, $month, $year);
		
		$npp = $user[0]->ID;
		#$sales = $user[0]->SALES_TYPE;
		$name = strtoupper($user[0]->USER_NAME);
		$ket = ($month != 0) ? date('F Y', strtotime("01-$month-$year")) : '';

		$html = "";
		#$html .= "NPP : " . $npp . "<br />\n";
		#$html .= "NAMA : " . $name . "<br />\n";
		#$html .= "SALES TYPE : " . $sales . "<br />\n";
		$html .= "PERIODE : " . strtoupper($ket) . "<br /><br />\n";
		$html .= "WEEK : " . strtoupper($week) . "<br /><br />\n";
		$html .= "\n";
		if(($_SESSION['USER_LEVEL'] == 'PEMIMPIN_KLN-KK' || $_SESSION['USER_LEVEL'] == 'PEMIMPIN_CABANG')&& $is_check== 0)
		{
		$html .= "<button id='add_ap_bm'>Tambah PIPELINE</button>&nbsp;&nbsp";
		$html .= "<button id='kirim_usulan_bm'>Kirim Usulan</button><br />";
		$html .= "\n";
		}
		else if(($_SESSION['USER_LEVEL'] == 'SUPERVISOR' || $_SESSION['USER_LEVEL'] == 'WILAYAH' || $_SESSION['USER_LEVEL'] == 'PIMPINAN_WILAYAH'|| $_SESSION['USER_LEVEL'] == 'PEMIMPIN_CABANG') && $_SESSION['ID'] != $is_own && $is_check == 1)
		{
		
			//$a = date("j");
			//if ($a>=9)
			//{
			$html .= "<button id='btn_approve_bm' rev='approve_bm'>Approve</button> &nbsp;&nbsp;
								<button id='btn_reject_bm' rev='reject_bm'>Tolak</button> &nbsp;&nbsp;
								<button id='export'>Export to Excel</button>
								<br /><br />\n";
			//}
			//else
			//{
			//$html .= "
			//					<button id='btn_reject' rev='reject'>Tolak</button> &nbsp;&nbsp;
			//					<button id='export'>Export to Excel</button>
			//					<br /><br />\n";
			//}

		}
		$html .= "<br />";
		$html .= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html .= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n";
		if($_SESSION['USER_LEVEL'] == 'SALES' && $is_check == 0)
				{
		$html .="	<th align='center' class='kecil'>Action</th>\n";		
				};				
		$html .="	<th align='center' class='kecil'>CIF</th>\n";
		
		$html .=	"<th align='center' class='kecil'>NAMA NASABAH</th>\n	
					<th align='center' class='kecil'>PRODUCT</th>\n
					<th align='right' class='kecil'>PIPELINE</th>\n
					<th align='right' class='kecil'>REALISASI</th>\n
					<th align='right' class='kecil'>&Delta; PIPELINE</th>\n
					<th align='center' class='kecil'>STATUS VERIFIKASI</th>\n
					</tr>\n";

		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if ($data)
		{
			foreach ($data as $row)
			{
				$color = ($i % 2) ? "#ffffff" : "#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>" . $i++ . "</td> \n";
				if($_SESSION['USER_LEVEL'] == 'SALES' && $is_check == 0)
				{
					$html .="<th align='right' class='kecil'><a class ='remove' id='".$row['ID']."' href='#'>Remove</a> </th>\n";
				}
				$html .= "<td width='' align='center' class='kecil'>" . $row['CIF_KEY'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_NAME'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['PRODUCT_NAME'] . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['RENCANA'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['DELTA_TABUNGAN'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['DELTA_RENCANA'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['VERIFY_BY'] . "</td> \n";
				$html .= "</tr> \n";
			}
		}
		else
		{
			$html .= "<tr>\n";
			$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";
			$html .= "</tr>\n";
		}
		$html .= "</table> \n";

		echo $html;
	}
	
	function get_report_pipeline_combine($productid,$month, $year)
	{
		$user	= $this->_report->get_user($id);

		if ($_SESSION['USER_LEVEL'] == 'USERMGT')
			redirect('forbiden/index/2');

		$data = $this->_account_planning->report_pipeline_combine($productid,$month, $year);
		
		$npp = $user[0]->ID;
		$sales = $user[0]->SALES_TYPE;
		$name = strtoupper($user[0]->USER_NAME);
		$ket = ($month != 0) ? date('F Y', strtotime("01-$month-$year")) : '';
		
		SWITCH($productid)
		{
			CASE 0 :
			$produk = "ALL";
			break;
			CASE 1:
			$produk = "Giro";
			break;
			CASE 2:
			$produk = "Tabungan";
			break;
			CASE 3:
			$produk = "Giro";
			break;
			CASE 7:
			$produk = "Investasi";
			break;
			CASE 8:
			$produk="Smart Forex";
			break;
			CASE 9:
			$produk="OTR";
			break;
			CASE 13:
			$produk="Bancassurance";
			break;
			CASE 17:
			$produk="Kartu Kredit";
			break;
			CASE 18:
			$produk="Griya";
			break;
			CASE 19:
			$produk="C3";
			break;
			CASE 20:
			$produk="Fleksi";
			break;
		}
		$html = "";
		$html .= "PRODUK : " . $produk . "<br />\n";
		$html .= "PERIODE : " . strtoupper($ket) . "<br /><br />\n";
		$html .= "\n";
		$html .= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html .= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>WILAYAH</th>\n
						<th align='center' class='kecil'>CABANG</th>\n
						<th align='center' class='kecil'>PIPELINE SALES</th>\n
						<th align='center' class='kecil'>PIPELINE PEMIMPIN KLN-KK</th>\n		
						<th align='center' class='kecil'>PIPELINE PEMIMPIN CABANG</th>\n						
						<th align='center' class='kecil'>PIPELINE TOTAL</th>\n
					</tr>\n";

		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if ($data)
		{
			foreach ($data as $row)
			{
				$color = ($i % 2) ? "#ffffff" : "#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>" . $i++ . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" .$row['REGION_NAME']. "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" .$row['BRANCH_NAME']. "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['SALES'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['PEMIMPIN_KLNKK'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['PEMIMPIN_CABANG'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['TOTAL_PIPELINE'], 2, '.', ',') . "</td> \n";
				$html .= "</tr> \n";
			}
		}
		else
		{
			$html .= "<tr>\n";
			$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";
			$html .= "</tr>\n";
		}
		$html .= "</table> \n";

		echo $html;
	}
}