<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends Controller {

	function Report()
	{
		parent::Controller();
		$this->load->model('_report');
		$this->load->model('_otomasi');
		$this->load->model('_realisasi');
		$this->load->model('_agenda_bm');
		$this->load->model('_status');
		$this->load->helper('form');
		$this->load->library('PHPExcel/IOFactory');
        $this->load->library('PHPExcel');	
		if($_SESSION['ID'] == ''){ redirect('login');}
		$this->load->model('_handler');
		$this->load->model('_news');

		date_default_timezone_set('Asia/Jakarta');		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
		
	}
	
	function index()
	{
//		echo"SSSSSSSSSSSSSSSSSSSSSSSS";
	}
	
function nasabah_bm_sum_slh(){
	
	echo"REPORT (report/nasabah_bm_sum_slh)";
	
}	
	
	
	function status()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$this->load->view('report/status', $data);
	}
	
	#-------------------------------------
	# 	Get Data Sales
	#-------------------------------------
	function get_sales()
	{
		$this->load->library('flexigrid');
		
		$valid_fields = array('ID', 'USER_NAME', 'SALES_TYPE', 'SPV', 'BRANCH_NAME', 'KODE', 'REGION');
		
		$this->flexigrid->validate_post('ID','asc',$valid_fields);
		$id 		= ($this->session->userdata('BRANCH_ID') <> '')?$this->session->userdata('BRANCH_ID'):0;
		$records 	= $this->_report->get_neo_search($id);
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
		 $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
         else
         $this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	
	function list_user()
	{
		$this->load->helper('flexigrid');
		
		$colModel['ID'] 			= array('NPP',40,TRUE,'center',2);
		$colModel['USER_NAME'] 		= array('NAMA',200,TRUE,'left',1);
		$colModel['SALES_TYPE'] 	= array('SALES TYPE',150,TRUE,'left',1);
		$colModel['SPV'] 			= array('SPV',50,TRUE,'left',1);
		$colModel['BRANCH_NAME'] 	= array('BRANCH',100,TRUE,'left',1);		
		$colModel['KODE'] 			= array('REGION',70,TRUE,'center',1);
		$colModel['REGION'] 		= array('REGION ID',50,TRUE,'left',1);

		$gridParams = array(
			'width' 			=> 460,
			'height' 			=> 300,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST DATA SALES',
			'showTableToggleBtn'=> false
		);

		$buttons[] 			= array('Pilih','add','pilih_data');
		$buttons[] 			= array('separator');
		$grid_js 			= build_grid_js('search_list',site_url("/report/get_sales"),$colModel,'a.ID','ASC',$gridParams,$buttons);
		$data['js_grid'] 	= $grid_js;
		return $data;
	}
	
	#-------------------------------------
	# 	Report Daily Activity per Sales
	#-------------------------------------	
	function activity()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] = 0;
		$this->load->view('report/activity_sup', $data);
	}
	
	function pipeline()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] = 0;
		$this->load->view('report/pipeline_sup', $data);
	}
	
	function pipeline_count()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] = 0;
		$this->load->view('report/pipeline_count_sup', $data);
	}
	
	function pipeline_coach()
	{
	
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] = 0;
		
		$this->load->view('report/pipelinecoach', $data);
	
	}

	function pipeline_coach_sourcedata()
	{
	
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] = 0;
		$data = $this->list_user();	
		if ($lvl<>'SALES')
		{
		$this->load->view('report/pipeline_coach_sourcedata_sup', $data);
		} 
		else
		{
		$this->load->view('report/pipelinecoach_sourcedata', $data);
		}
	}

function pipeline_coach_spv()
	{
	
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] = 0;
		
		$this->load->view('report/pipelinecoach_spv', $data);
	
}

function pipeline_coach_reg()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] = 0;
		if($lvl == 'SLN' || $lvl == 'TIM')
		{
		$this->load->view('report/pipeline_coach_kb', $data);
		}
		else if($lvl=='WILAYAH')
		{
		$this->load->view('report/pipeline_coach_region', $data);
		}
		else
		{
		$this->load->view('report/pipeline_coach_branch', $data);
		}
*/	
echo"Report Grouping Pipeline (Wilayah) c->report/pipeline_coach_reg";

}


function pipeline_coach_sup()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPERVISOR');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] = 0;
		$data = $this->list_user();	
		
		$this->load->view('report/pipelinecoach_sup', $data);
*/	
echo"Report Worksheet Pipeline (Jumlah) c->report/pipeline_coach_sup";		
}

function pipeline_coach_kb()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPERVISOR');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] = 0;
		$data = $this->list_user();	
		
		$this->load->view('report/pipeline_coach_kb_sup', $data);
*/	
echo"Report Worksheet Pipeline c->report/pipeline_coach_kb";
		
}
	
	#-------------------------------------
	# 	Report Daily Kartu Kredit per Sales
	#-------------------------------------	
	function cc()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		//$this->load->view('report/cc', $data);
		$this->load->view('report/cc');
	}
	
	#-------------------------------------
	# 	Report Daily Kartu Kredit per Sales
	#-------------------------------------	
	function dplk()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		//$this->load->view('report/dplk', $data);
		$this->load->view('report/dplk');
	}
	
	#-------------------------------------
	# 	Report Daily Activity per Sales
	#-------------------------------------	
	function activity_realisasi()
	{
echo"Akt. Sdh Realisasi c->report/activity_realisasi";		
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES','SUPERVISOR');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data = $this->list_user();	
		$data['type'] = 1;
		$this->load->view('report/activity_sup', $data);
*/		
	}
	#-------------------------------------
	# 	Report Daily Activity per Sales
	#-------------------------------------	
	function activity_belum()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES','SUPERVISOR');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data = $this->list_user();	
		$data['type'] = 2;
		$this->load->view('report/activity_sup', $data);
*/
echo"Akt. Blm Realisasi c->report/activity_belum";		
	}
	
	## Tele Sudah Realisasi ##
	function activity_realisasi_tele()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES','SUPERVISOR');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data = $this->list_user();	
		$data['type'] = 3;
		$this->load->view('report/activity_sup', $data);
*/		
echo"Akt. Sdh Realisasi 500046 c->report/activity_realisasi_tele
";
	}
	
	## Tele Belum Realisasi ##
	function activity_belum_tele()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES','SUPERVISOR');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data = $this->list_user();	
		$data['type'] = 4;
		$this->load->view('report/activity_sup', $data);
*/
echo"Akt. Blm Realisasi 500046 c->report/activity_belum_tele";		
	}
	
	## Activity Tele ##
	function activity_tele()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] = 5;
		$this->load->view('report/activity_sup', $data);
*/
echo"Akt. Harian 500046 c->report/activity_tele";
	}
	
	
	// ajax report
	function getActivity($id = 0,$type = 0, $start = NOW, $end = NOW)
	{
		$user			= $this->_report->get_user($id);
		//get data activity by npp
		$data 	= $this->_report->get_activity($id, $type, $start, $end);
		
		$html 	=  "";
		$html 	.= "NPP : ".$user[0]->ID."<br />\n";
		$html 	.= "NAMA : ".strtoupper($user[0]->USER_NAME)."<br />\n";
		$html 	.= "SALES TYPE : ".$user[0]->SALES_TYPE."<br />\n";
		$html 	.= "PERIODE : ".$start." s/d ".$end."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>Aktivitas</th>\n
						<th align='center'>Jumlah</th>\n
						<th align='center'>Bobot</th>\n
						<th align='center'>Volume</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->ACTIVITY."</td>\n";
				$html .= "	<td align='center'>".$row->JUMLAH."</td>\n";
				$html .= "	<td align='center'>".$row->BOBOT."</td>\n";
				$html .= "	<td align='center'>".$row->VOLUME."</td>\n";
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Tidak ada akitivitas</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	

	
	
	// ajax report
	function getcc($id = 0,$type = 0, $start = NOW, $end = NOW)
	{
/*
		$tgl1 	= date('m/d/Y', strtotime($start));
		$tgl2 	= date('m/d/Y', strtotime($end));
		
		$start 	= getdate(strtotime($start));
		$d1		= $start['mday'];
		$m1		= $start['mon'];
		$y1		= $start['year'];
		$end 	= getdate(strtotime($end));
		$d2		= $end['mday'];
		$m2		= $end['mon'];
		$y2		= $end['year'];		
	
		
echo $id;
echo"<br>";
echo $type;
echo"<br>";
echo $tgl1;
echo"<br>";
echo $tgl2;
*/
$id= '';
/*
	
*/		
		#$user			= $this->_report->get_user($id);
		$user_id = $this->session->userdata('ID');
		$user_name = $this->session->userdata('USER_NAME');
		$salestypenew = $this->session->userdata('SALES_TYPE');		
		$gradeuser = $this->session->userdata('GRADE');
		$areauser = $this->session->userdata('REGION');		
		
		//get data activity by npp
//		$data 	= $this->_report->get_cc($id, $start, $end);
//print_r($data);		
		$html 	=  "";
		$html 	.= "NPP : ".$user_id."<br />\n";
		$html 	.= "NAMA : ".strtoupper($user_name)."<br />\n";
		$html 	.= "SALES TYPE : ".$salestypenew."<br />\n";
		$html 	.= "PERIODE : ".$start." s/d ".$end."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>Tanggal</th>\n
						<th>ORG</th>\n
						<th align='center'>Logo</th>\n
						<th align='center'>Card No</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
/*
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->AS_OF_DATE."</td>\n";
				$html .= "	<td>".$row->ORG."</td>\n";
				$html .= "	<td align='center'>".$row->LOGO."</td>\n";
				$html .= "	<td align='center'>".$row->CARDNO."</td>\n";
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Tidak ada Data</span></td>\n";	
				$html .= "</tr>\n";
		}
	*/	
		$html .= "</table>";
		echo $html;
	}
	
	// ajax report
	function getdplk($id = 0,$type = 0, $start = NOW, $end = NOW)
	{

		$tgl1 	= date('m/d/Y', strtotime($start));
		$tgl2 	= date('m/d/Y', strtotime($end));
		
		$start 	= getdate(strtotime($start));
		$d1		= $start['mday'];
		$m1		= $start['mon'];
		$y1		= $start['year'];
		$end 	= getdate(strtotime($end));
		$d2		= $end['mday'];
		$m2		= $end['mon'];
		$y2		= $end['year'];			
/*
		$user			= $this->_report->get_user($id);
		#print_r($user);
		//get data activity by npp
		$data 	= $this->_report->get_dplk($id, $start, $end);
		#print_r($data);
*/		
		$user_id = $this->session->userdata('ID');
		$user_name = $this->session->userdata('USER_NAME');
		$salestypenew = $this->session->userdata('SALES_TYPE');		
		$gradeuser = $this->session->userdata('GRADE');
		$areauser = $this->session->userdata('REGION');		
		
		$html 	=  "";
		$html 	.= "NPP : ".$user_id."<br />\n";
		$html 	.= "NAMA : ".strtoupper($user_name)."<br />\n";
		$html 	.= "SALES TYPE : ".$salestypenew."<br />\n";
		$html 	.= "PERIODE : ".$start." s/d ".$end."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>Tanggal Buka</th>\n
						<th>Cabang</th>\n
						<th align='center'>No Rekening</th>\n
						<th align='center'>Nama</th>\n
						<th align='center'>Saldo Akhir</th>\n
					</tr>\n";
/*
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->TGLBUKA."</td>\n";
				$html .= "	<td>".$row->BRANCH_NAME."</td>\n";
				$html .= "	<td align='center'>".$row->NOREK."</td>\n";
				$html .= "	<td align='center'>".$row->NAMALKP."</td>\n";
				$html .= "	<td align='center'>".number_format($row->SDOAKHIR)."</td>\n";
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Tidak ada Data</span></td>\n";	
				$html .= "</tr>\n";
		}
*/		
		$html .= "</table>";
		echo $html;
	}
	
	
	function audit_trail()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SLN','ADMIN','USERMGT');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		//$data['type'] = 0;
		$this->load->view('report/audit_trail');
*/		
echo"Audit Trail c->report/audit_trail";
	}
	
	function getAudit($start = 0, $end = 0)
	{
		
		$awl = strtotime($start);
		$akh = strtotime($end);
		$selisih = $akh - $awl;
		
		if($selisih <= 2592000)
		
		{
		
		$data 	= $this->_report->get_audit($start, $end);
		
		$html 	.= "PERIODE : ".$start." s/d ".$end."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>NPP</th>\n
						<th align='center'>Action</th>\n
						<th align='center'>Info</th>\n
						<th align='center'>Create Date</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->NPP."</td>\n";
				$html .= "	<td align='center'>".$row->ACTION."</td>\n";
				$html .= "	<td align='left'>".$row->INFO."</td>\n";
				$html .= "	<td align='center'>".$row->DATE_CREATED."</td>\n";
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Tidak ada Data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		}
		else
		{
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Periode tidak boleh lebih dari 30 hari</span></td>\n";	
				$html .= "</tr>\n";
		}
		echo $html;
	}
	
	function xlsAudit($start = 0, $end = 0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SLN','ADMIN');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['start']	= $start;
		$data['end']	= $end;
		$data['data'] = $this->_report->get_audit($start, $end);
		$this->load->view('report/xls_audit', $data);
	}
	
	//User Non Aktif
	function user_nonaktif()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SLN','ADMIN','USERMGT','WILAYAH','CABANG','PIMPINAN_CABANG','PIMPINAN_WILAYAH','PEMIMPIN_CABANG');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		//$data['type'] = 0;
		$data['list_wilayah']=$this->_report->get_wilayah1();
		$data['list_cabang']=$this->_report->get_cabang_json();
		$this->load->view('report/non_aktif',$data);
*/		
echo"User Non Active c->report/user_nonaktif";		
	}
	
	function user_aktif($wil=0,$cab=0,$start=0,$end=0)
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('ADMIN','SLN','WILAYAH','CABANG','PIMPINAN_CABANG','PIMPINAN_WILAYAH','PEMIMPIN_AKTIF');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		//$data['type'] = 0;
		$data['list_wilayah']=$this->_report->get_wilayah1();
		$data['list_cabang']=$this->_report->get_cabang_json();
		$this->load->view('report/user_aktif',$data);
*/		
echo"User active c->report/user_aktif";
	}
	
	function getnonaktif($wil=0,$cab=0)
	{
		
		$data 	= $this->_report->get_nonaktif($wil,$cab);
		
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>NPP</th>\n
						<th align='center'>Nama</th>\n
						<th align='center'>User Level</th>\n
						<th align='center'>Unit</th>\n
						<th align='center'>Region</th>\n
						<th align='center'>Last Login</th>\n
				
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->ID."</td>\n";
				$html .= "	<td align='center'>".$row->USER_NAME."</td>\n";
				$html .= "	<td align='left'>".$row->USER_LEVEL."</td>\n";
				$html .= "	<td align='center'>".$row->BRANCH_NAME."</td>\n";
				$html .= "	<td align='center'>".$row->REGION."</td>\n";
				$html .= "	<td align='center'>".$row->LAST_LOGIN."</td>\n";
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Tidak ada Data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		
		echo $html;
	}
	
	function getnonaktifwil($branch=0)
	{
		
		$data 	= $this->_report->get_nonaktifwil($branch);
		
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>NPP</th>\n
						<th align='center'>Nama</th>\n
						<th align='center'>User Level</th>\n
						<th align='center'>Unit</th>\n
						<th align='center'>Last Login</th>\n
				
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->ID."</td>\n";
				$html .= "	<td align='center'>".$row->USER_NAME."</td>\n";
				$html .= "	<td align='left'>".$row->USER_LEVEL."</td>\n";
				$html .= "	<td align='center'>".$row->BRANCH_NAME."</td>\n";
				$html .= "	<td align='center'>".$row->LAST_LOGIN."</td>\n";
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Tidak ada Data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		
		echo $html;
	}
	
	function gettotallogin($wil=0,$cab=0,$start=1,$end=0)
	{
		
		$data 	= $this->_report->get_total_login($wil,$cab,$start,$end);
		
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>NPP</th>\n
						<th align='center'>Nama</th>\n
						<th align='center'>User Level</th>\n
						<th align='center'>Cabang</th>\n
						<th align='center'>Region</th>\n
						<th align='center'>Tanggal</th>\n
						<th align='center'>Total Login</th>\n
				
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->USER_ID."</td>\n";
				$html .= "	<td align='center'>".$row->USER_NAME."</td>\n";
				$html .= "	<td align='left'>".$row->USER_LEVEL."</td>\n";
				$html .= "	<td align='center'>".$row->BRANCH_NAME."</td>\n";
				$html .= "	<td align='center'>".$row->REGION."</td>\n";
				$html .= "	<td align='center'>".$row->TANGGAL."</td>\n";
				$html .= "	<td align='center'>".$row->JUMLAH_LOGIN."</td>\n";
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='8' align='center'><span style='color:#c00'>Tidak ada Data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		
		echo $html;
	}
	
	function delete_aktif($npp)
	{
		$data = $this->_report->delete_aktif($npp);
	}
	
	function getaktif()
	{
		
		$data 	= $this->_report->get_aktif();
		
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>NPP</th>\n
						<th align='center'>Nama</th>\n
						<th align='center'>User Level</th>\n
						<th align='center'>Unit</th>\n
						<th align='center'>Time Login</th>\n
						<th align='center'>Action</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->ID."</td>\n";
				$html .= "	<td align='center'>".$row->USER_NAME."</td>\n";
				$html .= "	<td align='left'>".$row->USER_LEVEL."</td>\n";
				$html .= "	<td align='center'>".$row->BRANCH_NAME."</td>\n";
				$html .= "	<td align='center'>".$row->TIME."</td>\n";
				if($row->USER_LEVEL == "ADMIN")
				{
				$html .= "	<td align='center'>No Action</td>\n";
				}
				else
				{
				$html .= "  <td><input name='delete' id='delete' type='button' value='Kill Session' onclick='killsession(".$row->ID.")'></td>\n";
				}
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Tidak ada Data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		
		echo $html;
	}
	
	
	function xlsnonaktif()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SLN','ADMIN');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['data'] = $this->_report->get_nonaktif();
		$this->load->view('report/xls_nonaktif', $data);
	}
	
	
	// create report in excel
	function xlsActivity($id = 0, $type=0,  $start = NOW, $end = NOW)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] 	= $type;
		$data['user']	= $this->_report->get_user($id);
		$data['start']	= $start;
		$data['end']	= $end;
		$data['data'] 	= $this->_report->get_activity($id, $type, $start, $end);
		$this->load->view('report/xls_activity', $data);
	}
	
	// create report in excel
	function xlsPipeline($id = 0, $type=0,  $start = NOW, $end = NOW)
	{
/*
*/		
echo $id;		
echo $type;		
echo $start;		
echo $end;		
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['staging'] 	= $staging;
		$data['user']	= $this->_report->get_user($id);
		$data['start']	= $start;
		$data['end']	= $end;
		$data['data'] 	= $this->_report->get_pipeline($id, $staging, $start, $end);
		$this->load->view('report/xls_pipeline', $data);
*/		
	}
	
	function xlsPipelineCount($id = 0, $staging=0,  $start = NOW, $end = NOW)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['staging'] 	= $staging;
		$data['user']	= $this->_report->get_user($id);
		$data['start']	= $start;
		$data['end']	= $end;
		$data['data'] 	= $this->_report->get_pipeline_count($id, $staging, $start, $end);
		$this->load->view('report/xls_pipeline_count', $data);
	}
	
	function xlsPipelineCoach($id = 0, $sourcedata=0, $m=0,  $y = 0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		
		$data['user']	= $this->_report->get_user($id);
		$data['sourcedata']=$sourcedata;
		$data['month']	= $m;
		$data['year']	= $y;
		$data['data'] 	= $this->_report->get_pipeline_coach($id, $sourcedata, $m, $y);
		$data['data1'] 	= $this->_report->get_pipeline_coach1($id, $sourcedata, $m, $y);
		$data['data2'] 	= $this->_report->get_pipeline_coach2($id, $sourcedata, $m, $y);
		$data['data3'] 	= $this->_report->get_pipeline_coach_kategori($id, $sourcedata, $m, $y);
		$data['data4'] 	= $this->_report->get_pipeline_coach_kategori1($id, $sourcedata, $m, $y);
		$data['data5'] 	= $this->_report->get_pipeline_coach_kategori2($id, $sourcedata, $m, $y);
		$data['data6'] 	= $this->_report->get_pipeline_coach_target($id, $sourcedata, $m, $y);
		$this->load->view('report/xls_pipeline_coach', $data);
	}
	
	function xlsPipelineCoachSourceData($id = 0, $m=0,  $y = 0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		
		$data['user']	= $this->_report->get_user($id);
		$data['month']	= $m;
		$data['year']	= $y;
		$data['data'] 	= $this->_report->get_pipeline_coach_sourcedata($id, $m, $y);
		$this->load->view('report/xls_pipeline_sourcedata', $data);
	}
	
	function xlsPipelineCoachSpv($id = 0, $m=0,  $y = 0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPERVISOR');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		
		$data['id']	= $this->_report->get_penyelia($cab);
		$data['month']	= $m;
		$data['year']	= $y;
		$data['data'] 	= $this->_report->get_pipeline_coach_spv($id, $m, $y);
		$this->load->view('report/xls_pipeline_coach_spv', $data);
	}
	
	function xlsPipelineCoachBranch($branch = 0, $m=0,  $y = 0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('CABANG','PIMPINAN_CABANG');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		
		$data['branch']	= $this->_report->get_penyelia($cab);
		$data['month']	= $m;
		$data['year']	= $y;
		$data['data'] 	= $this->_report->get_pipeline_coach_branch($branch, $m, $y);
		$this->load->view('report/xls_pipeline_coach_branch', $data);
	}
	
	function xlsPipelineCoachRegion($region = 0, $m=0,  $y = 0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('WILAYAH','PIMPINAN_WILAYAH');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		
		$data['region']	= $this->_report->get_penyelia($cab);
		$data['month']	= $m;
		$data['year']	= $y;
		$data['data'] 	= $this->_report->get_pipeline_coach_region($region, $m, $y);
		$this->load->view('report/xls_pipeline_coach_region', $data);
	}
	
	function xlsPipelineCoachRegionSum($region = 0, $m=0,  $y = 0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('WILAYAH','PIMPINAN_WILAYAH');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		
		$data['region']	= $this->_report->get_penyelia($cab);
		$data['month']	= $m;
		$data['year']	= $y;
		$data['data'] 	= $this->_report->get_pipeline_coach_region_sum($region, $m, $y);
		$this->load->view('report/xls_pipeline_coach_region_sum', $data);
	}
	
		function xlsPipelineCoachKbSum($m=0,  $y = 0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SPV');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		
		$data['region']	= $this->_report->get_penyelia($cab);
		$data['month']	= $m;
		$data['year']	= $y;
		$data['data'] 	= $this->_report->get_pipeline_coach_kb_sum($m, $y);
		$this->load->view('report/xls_pipeline_coach_kb_sum', $data);
	}
	
	#-------------------------------------
	# 	Report Daily Activity per Cabang
	#-------------------------------------	
	function activity_sup()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data = $this->list_user();	
		
		$this->load->view('report/activity_sup', $data);		
*/
echo"Aktivitas Harian  c->report/activity_sup";
	}
	
	function pipeline_sup()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data = $this->list_user();	
		
		$this->load->view('report/pipeline_sup', $data);		
/*
echo"Report Pipeline (Tgl) c->report/pipeline_sup";		
*/
	}
	
	function pipeline_count_sup()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data = $this->list_user();	
		
		$this->load->view('report/pipeline_count_sup', $data);		
/*
echo"Report Pipeline (Jumlah) c->report/pipeline_count_sup";
*/		
	}
	
	#-------------------------------------
	# 	Report Daily Activity per Cabang
	#-------------------------------------	
	function cc_sup()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN','WILAYAH','CABANG','PIMPINAN_CABANG','PIMPINAN_WILAYAH');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data = $this->list_user();	
		
		$this->load->view('report/cc', $data);		
*/	
echo"Penj. Kartu Kredit Sales c->report/cc_sup";	
	}
	
		#-------------------------------------
	# 	Report Daily Activity per Cabang
	#-------------------------------------	
	function dplk_sup()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data = $this->list_user();	
		
		$this->load->view('report/dplk', $data);		
*/		
echo"Rek. DPLK Sales c->report/dplk_sup";
	}
	
	
	
	function get_pencapaian($id,  $month, $year)
	{
		#-------------------------------------------
		#	Update DPK dari tbl SALES_EOY_BAL
		#-------------------------------------------			
		$this->_otomasi->get_dpk($id,$month,$year,1);
		$this->_otomasi->get_dpk($id,$month,$year,2);
		$this->_otomasi->get_dpk($id,$month,$year,3);
		#-------------------------------------------
		#	Update Pencapaian RASIO
		#-------------------------------------------
		$this->_otomasi->get_rasio($id,$month,$year);
		#-------------------------------------------
		#	Update Pencapaian NEW_CUST_DPK
		#-------------------------------------------
		$this->_otomasi->get_new_cust($id,$month,$year);
		#-------------------------------------------
		#	Update Pencapaian NEW_ACCOUNT_DPK
		#-------------------------------------------
		$this->_otomasi->get_new_account($id,$month,$year);
	}
	
	#----------------------------------
	# 	Report Realisasi per Sales
	#----------------------------------	
	function realisasi()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/4');}
		$this->load->view('report/realisasi');
	}

//==========================================
	function get_realisasi_new($id =0, $m=0, $y = 0 )
	{

		//id = 41241;
		$bulan = array(	'1'=>'Januari', 
						'2'=>'Februari', 
						'3'=>'Maret', 
						'4'=>'April',
						'5'=>'Mei', 
						'6'=>'Juni', 
						'7'=>'Juli', 
						'8'=>'Agustus',
						'9'=>'September', 
						'10'=>'Oktober', 
						'11'=>'November', 
						'12'=>'Desember');
		
		$user	= $this->_report->get_user($id);
		#$usergrade	= $this->_report->get_user_grade($id,$m,$y);
		//$getretensi = $this->_report->get_parameter_retensi($id,$m,$y);
//----------------------------------------		
		$getretensi = $this->db->query("SELECT 
		SALES_ID,
		TARGET
		PENCAPAIAN,
		(PENCAPAIAN - TARGET) RETENSI,
		M,
		Y	
		FROM NEW_REALISASI 
		WHERE 
		SALES_ID = 27424 
  ")->result();

/*
*/				
		#print_r($getretensi);
//		$retensi = $getretensi[0]->RETENSI;
		#print_r($retensi);
/*
*/
	
		//$status = $this->_status->get_status_cek($id);
		//foreach ($status as $row)
		//{
			//$npp = $row->NPP;
			//$awal = $row->BLN_AWAL;
			//$akhir = $row->BLN_AKHIR;
			//$thnawal = $row->THN_AWAL;
			//$thnakhir = $row->THN_AKHIR;
			//$tglawal = $row->TGL_AWAL;
			//$tglakhir = $row->TGL_AKHIR;
		//}
//-----------------------------
/*
		$sql ="WITH T AS (
							SELECT NPP,TGL_AWAL START_DATE,TGL_AKHIR END_DATE FROM STATUS_NONSALES WHERE NPP= 41241
						)
              SELECT
			NPP,
			START_DATE,
			END_DATE,
			CASE
			WHEN SUBSTR(TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'MM'),1,1) =0 THEN
			SUBSTR(TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'MM'),2,1)
			ELSE TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'MM') 
			END AS MONTH,
            TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'YYYY') YEAR
			FROM  T WHERE TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'YYYY') =$y and
            TO_CHAR(ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1),'MM') =$m
			CONNECT BY TRUNC(END_DATE,'MM') >= ADD_MONTHS(TRUNC(START_DATE,'MM'),LEVEL - 1) 
			";		
			
				$status = $this->db->query($sql)->result();	
			print_r($status);		
*/		
/*
//$status = $this->_status->get_status_cek1($id,$m,$y);
		foreach ($status as $row)
		{
			$npp = $row->NPP;
			$month = $row ->MONTH;
			$year = $row->YEAR;
			$tglawal = $row->START_DATE;
			$tglakhir = $row->END_DATE;
		}
		
			$gradeuser=$usergrade[0]->GRADETARGET;
			$areauser=$usergrade[0]->KODE_AREA;
			$salestypenew=$usergrade[0]->SALES_TYPE;
			$salestypenewid=$usergrade[0]->SALES;
*/		
/*
		#-------------------------------------------
		#	Update pencapaian
		#-------------------------------------------	
		$m_now = date('n');
		$y_now = date('Y');
		$d = date('d');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		if(($m==$m_now && $y==$y_now) ||($d <= 10 && $m==$bulanlalu && $y==$y_now) )
//|| ($m==$bulanlalu && $y==$y_now-1) || ($y==$y_now)			
		{
			
			#$this->get_pencapaian($id, $m, $y);
			#-------------------------------------------
			#	Update Pencapaian DPK
			#-------------------------------------------
			$this->_realisasi->get_daily_dpk($id,$m,$y);	
			$this->_realisasi->get_daily_dpk_bb($id,$m,$y);				
			#-------------------------------------------
			#	Update Pencapaian RASIO
			#-------------------------------------------
			#$this->_realisasi->get_rasio($id,$m,$y);
			#-------------------------------------------
			#	Update Pencapaian NEW_CUST_DPK
			#-------------------------------------------
			#$this->_realisasi->get_new_cust($id,$m,$y);
			#$this->_realisasi->get_new_cust_bb($id,$m,$y);
			#-------------------------------------------
			#	Update Pencapaian NEW_ACCOUNT_DPK
			#-------------------------------------------
			#$this->_realisasi->get_new_account($id,$m,$y);
			
		//ADD ELO & CCOS
			if(($m>= 3 && $y >= 2016))
			{
			#---------------------------------------------
			#Update Pencapaian Kredit Konsumtif From ELO
			#-----------------------------------------------
			#$this->_realisasi->get_daily_griya($id,$m,$y);
			#$this->_realisasi->get_daily_fleksi($id,$m,$y);
			#$this->_realisasi->get_daily_multiguna($id,$m,$y);
			#$this->_realisasi->get_daily_bwu($id,$m,$y);
			#$this->_realisasi->get_acc_konsumer($id,$m,$y);
			#$this->_realisasi->get_acc_ritel($id,$m,$y);
			#$this->_realisasi->get_approval_rate($id,$m,$y);
			#---------------------------------------------
			#Update Pencapaian Kartu Kredit From CCOS
			#-----------------------------------------------
			$this->_realisasi->get_daily_ccos($id,$m,$y);
			#---------------------------------------------
			#Update Pencapaian DPLK From DPLK
			#-----------------------------------------------
			$this->_realisasi->get_daily_dplk($id,$m,$y);
			$this->_realisasi->get_daily_dplk_bb($id,$m,$y);
			}
		//END OF ELO & CCOS & DPLK
		
			#-------------------------------------------
			#	HITUNG INDIVIDU PERFORMANCE
			#-------------------------------------------
			//$this->_realisasi->hitung_performance($m, $y, $id);
		}
		
		
*/	
		
		
		//$this->_realisasi->hitung_performance($m, $y, $id);
		
		#$this->_realisasi->update_performance_sales($id);

//-------------------------------
			$sql="
				SELECT a.ID, a.SALES_ID, a.TARGET_ID, a.PRODUCT_ID, a.PROC_ID, a.OUTSTANDING
				, a.SEGMENT, a.Y, a.M, TO_NUMBER(a.TARGET) as TARGET, TO_NUMBER(a.PENCAPAIAN) as PENCAPAIAN, TO_NUMBER
				(a.REALISASI) as REALISASI, b.PRODUCT_NAME
				FROM NEW_REALISASI a
				JOIN PRODUCT b ON a.PRODUCT_ID = b.ID
				JOIN BRANCH c ON a.BRANCH_CODE = c.BRANCH_CODE
				WHERE SUBSTR((TRIM(SALES_ID)),-5,5)  = '37632'
				AND M = '0'
				AND Y = '2015'
				ORDER BY PRODUCT_ID ASC
			 ";
		$data = $this->db->query($sql)->result();	 
		#print_r($data);
//-------------------------------------------------

/*
		#array of condition
		$datacek = array('SUBSTR((TRIM(SALES_ID)),-5,5) '=>"$37632", 'M'=>'0', 'Y'=>'2015', 'PRODUCT_ID <'=>7);
		#select all data
		$this->db->select("	a.ID, 
							a.SALES_ID, 
							a.TARGET_ID, 
							a.PRODUCT_ID, 
							a.PROC_ID,
							a.OUTSTANDING,
							a.Y, 
							a.M,  
							TO_NUMBER(NVL(a.PENCAPAIAN2,0)) as DPK_TAMBAHAN,  
							b.PRODUCT_NAME");
		$this->db->from('REALISASI a');
		$this->db->join('PRODUCT b', 'a.PRODUCT_ID = b.ID');
		$this->db->join('BRANCH c','a.BRANCH_CODE = c.BRANCH_CODE');
		$this->db->order_by('a.PRODUCT_ID','ASC');
		$this->db->where($datacek);
		$data2 = $this->db->get()->result();
*/
		//$datacek = array('SUBSTR((TRIM(SALES_ID)),-5,5) '=>"$37632", 'M'=>'0', 'Y'=>'2015', 'PRODUCT_ID <'=>7);
			$sql2="
				SELECT a.ID, a.SALES_ID, a.TARGET_ID, a.PRODUCT_ID, a.PROC_ID, a.OUTSTANDING
				, a.SEGMENT, a.Y, a.M, TO_NUMBER(NVL(a.PENCAPAIAN2,0)) as DPK_TAMBAHAN,b.PRODUCT_NAME
				FROM NEW_REALISASI a
				JOIN PRODUCT b ON a.PRODUCT_ID = b.ID
				JOIN BRANCH c ON a.BRANCH_CODE = c.BRANCH_CODE
				WHERE SUBSTR((TRIM(SALES_ID)),-5,5)  = '37632'
				ORDER BY a.PRODUCT_ID ASC
			 ";
		$data2 = $this->db->query($sql2)->result();	 
		#print_r($data2);
//--------------------------------------------------
						$sql3="select
							a.ID, 
                            a.SALES_ID, 
                            a.TARGET_ID, 
                            a.PRODUCT_ID, 
                            a.PROC_ID,
                            a.OUTSTANDING,
                            a.Y, 
                            a.M,  
                            TO_NUMBER(NVL(a.PENCAPAIAN3,0)) as DPK_KURANG,  
                            b.PRODUCT_NAME
                            from
                            NEW_REALISASI a
                            join PRODUCT b
                            on a.PRODUCT_ID = b.ID
                            join BRANCH c
                            on a.BRANCH_CODE = c.BRANCH_CODE
                            where
                            SUBSTR((TRIM(SALES_ID)),-5,5) = '37632' 
                            order by product_id asc";
		$data3 =  $this->db->query($sql3)->result();
		#print_r($data3);
//--------------------------------------------------------------------------							
/*
		$data 	= $this->_report->get_realisasi_new($id, $m, $y,$salestypenewid);
		$data2  = $this->_report->get_dpk_tambahan($id, $m, $y);
		$data3  = $this->_report->get_dpk_kurang($id, $m, $y, $salestypenewid);
*/

/*		
		if($user)
		{
			$user_id	= ($user[0]->ID != '')?$user[0]->ID:0;
			$user_name	= ($user[0]->USER_NAME != '')?$user[0]->USER_NAME:0;
			$user_sales	= ($user[0]->SALES_TYPE != '')?$user[0]->SALES_TYPE:0;
			$user_salesid	= ($user[0]->SALES != '')?$user[0]->SALES:0;
		} else {
			$user_id	= '';
			$user_name	= '';
			$user_sales	= '';
			$user_salesid	= '';
		}
*/				

//---------------------------ambil session--------------------------------------
		$user_id = $this->session->userdata('ID');
		$user_name = $this->session->userdata('USER_NAME');
		$salestypenew = $this->session->userdata('SALES_TYPE');		
		$gradeuser = $this->session->userdata('GRADE');
		$areauser = $this->session->userdata('REGION');		
//-----------------------------------------------------------------
		
//		
		$html 	=  "";
		//$html 	.= "NPP : ".$user[0]->ID."<br />\n";
		$html 	.= "NPP : ".$user_id."<br />\n";
		$html 	.= "NAMA : ".strtoupper($user_name)."<br />\n";
		$html 	.= "SALES TYPE : ".$salestypenew."<br />\n";
		$html 	.= "GRADE TARGET: ".$gradeuser."<br />\n";
		$html 	.= "AREA TARGET: ".$areauser."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($bulan[$m])." ".$y."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th>Kategori</th>\n	
						<th align='center'>No.</th>\n
						<th>Product</th>\n						
						<th align='center'>Target</th>\n
						<th align='center'>Pencapaian</th>\n
						<th align='center'>Realisasi %</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		
		
/*
		if($data){
			if($y==$year && $id==$npp && $m == $month)
			{
			
			$html 	=  "";
			//$html 	.= "NPP : ".$user[0]->ID."<br />\n";
			$html 	.= "NPP : ".$user_id."<br />\n";
			$html 	.= "NAMA : ".strtoupper($user_name)."<br />\n";
			$html 	.= "SALES TYPE : ".$user_sales."<br />\n";
			$html 	.= "PERIODE : ".strtoupper($bulan[$m])." ".$y."<br /><br />\n";
			$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>Product</th>\n						
						<th align='center'>Target</th>\n
						<th align='center'>Pencapaian</th>\n
						<th align='center'>Realisasi %</th>\n
					</tr>\n";
			$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Terdaftar posisi Non Sales Sejak ".$tglawal." s/d ".$tglakhir."</span></td>\n";	
				$html .= "</tr>\n";			
		
			}
			//elseif($y!=$year && $id==$npp && $m!=$month)
			//{
			//$html 	=  "";
			//$html 	.= "NPP : ".$user[0]->ID."<br />\n";
			//$html 	.= "NPP : ".$user_id."<br />\n";
			//$html 	.= "NAMA : ".strtoupper($user_name)."<br />\n";
			//$html 	.= "SALES TYPE : ".$user_sales."<br />\n";
			//$html 	.= "PERIODE : ".strtoupper($bulan[$m])." ".$y."<br /><br />\n";
			//$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
			//$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						//<th align='center'>No.</th>\n
						//<th>Product</th>\n						
						//<th align='center'>Target</th>\n
						//<th align='center'>Pencapaian</th>\n
						//<th align='center'>Realisasi %</th>\n
					//</tr>\n";
			//$html .= "<tr>\n";
				//$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Terdaftar posisi Non Sales Sejak ".$tglawal." s/d ".$tglakhir."</span></td>\n";	
				//$html .= "</tr>\n";	
			//}
			else
			{
*/				
//---------------------------------------------------------------------		
			foreach($data as $row)
			{
				
				$target = 0;
				$pencapaian = 0;
				$realisasi = 0;
				$target = $row->TARGET;				
				$baseline = $row->OUTSTANDING;
				$proc = $row->PROC_ID;
				$product=$row->PRODUCT_ID;
//----------
$pencapaian = number_format($row->PENCAPAIAN,0,'.',',');		

$realisasi = ($row->PENCAPAIAN/$target)*100;		
				
/*
							if($proc==1 || $proc==2 || $proc==3 || $proc==9 || $proc == 10 || $proc==11 || $proc==12)
							{ 
									$target = $row->TARGET;
									$pencapaian = $row->PENCAPAIAN - $baseline ;
									$pencapaian = ($pencapaian<1)?'<span style="color:#f00">'.number_format($pencapaian,0,'.',',').'</span>':number_format($pencapaian,0,'.',',');
							}
							elseif($proc==4 || $proc==5 || $proc==6)
							{ 
									$target = $row->TARGET;
									$pencapaian = $row->PENCAPAIAN - $baseline ;
									$pencapaian = ($pencapaian<1)?'<span style="color:#f00">'.number_format($pencapaian,0,'.',',').'</span>':number_format($pencapaian,0,'.',',');
							}
							elseif($proc == 16)
							{
							$pencapaian = number_format($row->PENCAPAIAN,2,'.',',');
							} 
							elseif($product == 701)
							{
							$pencapaian = number_format($row->PENCAPAIAN,2,'.',',');
							} 
							else {$pencapaian = number_format($row->PENCAPAIAN,0,'.',',');} 
				
				if($target <> 0)
				{ 
					if($proc == 1 || $proc == 2 || $proc == 3 || $proc == 9 || $proc == 10 || $proc==11 || $proc==12)
					{
						$realisasi = (($row->PENCAPAIAN-$baseline)/(($baseline+$target)-$baseline))*100;
						if($retensi >=0 and $user_salesid < 6)
						{
						$realisasi = ($realisasi <= 0)?0:$realisasi;
						}
					}
					elseif($proc == 4 || $proc == 5 || $proc ==6)
					{
						$realisasi = (($row->PENCAPAIAN-$baseline)/(($baseline+$target)-$baseline))*100;
						#$realisasi = ($realisasi <= 0)?0:$realisasi;
					}
					elseif($proc==13)
					{
						$realisasi =($row->PENCAPAIAN/$target)*100;
						$realisasih = ($row->PENCAPAIAN/$target)*100;
					}
					elseif($user_salesid==31 && $proc == 14 && $realisasih <75)
					{
						$realisasi = 0;
					}
					else{
						
						$realisasi = ($row->PENCAPAIAN/$target)*100;
					}
				}
				else 
				{
					//echo "boo";die();
					$realisasi = 0;
					$pencapaian = 0;
					$data=array('PENCAPAIAN'=>$realisasi);
					$this->_realisasi->update_pencapaian($row->ID,$data);
	
				}
				#----------------------------
				#	update realisasi
				#----------------------------
				$data=array('REALISASI'=>$realisasi);
				//print_r($data);
				$this->_realisasi->update($row->ID,$data);
				if($y >= 2017)
			{
				$this->_realisasi->hitung_performance($m, $y, $id, $user_salesid);
			}
*/
				
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
// <TR>				

			
				
//----- <TH> 1
/*			
				if ($product == 1)
				{
				$html .= " <th rowspan = '3'>CR</th>\n";
				}
				#if (($product == 1 && $user_salesid != 10)||($product == 1 && $user_salesid != 12))
				#{
				#$html .= " <th rowspan = '3'>CR</th>\n";
				#}
				#if (($product == 1 && $user_salesid==10)||($product == 1 && $user_salesid==12))
				#{
				#$html .= " <th rowspan = '2'></th>\n";
				#}
				if ($product == 4)
				{
				$html .= " <th rowspan = '3'>BB</th>\n";
				}
				if ($product == 7)
				{
				$html .= " <th rowspan = '3'>CR</th>\n";
				}
				if ($product == 10)
				{
				$html .= " <th rowspan = '3'>BB</th>\n";
				}
				if ($product == 13)
				{
				$html .= " <th rowspan = '1'>CR</th>\n";
				}
				if ($product == 14)
				{
				$html .= " <th rowspan = '1'>BB</th>\n";
				}
				if ($product == 15)
				{
				$html .= " <th rowspan = '1'>CR</th>\n";
				}
				if ($product == 16)
				{
				$html .= " <th rowspan = '1'>BB</th>\n";
				}
				if($product == 17)
				{
				$html .= " <th rowspan = '1'>CR</th>\n";
				}
				#if(($product == 17 && $user_salesid != 10)||($product == 17 && $user_salesid != 12))
				#{
				#$html .= " <th rowspan = '1'>CR</th>\n";
				#}
				#if(($product == 17 && $user_salesid==10)||($product == 17 && $user_salesid==12))
				#{
				#$html .= " <th rowspan = '1'></th>\n";
				#}
				if($product == 18)
				{
				$html .= " <th rowspan = '3'>CR</th>\n";
				}
				if ($product == 21)
				{
				$html .= " <th rowspan = '1'>CR</th>\n";
				}
				if ($product == 22)
				{
				$html .= " <th rowspan = '1'>BB</th>\n";
				}
				if ($product == 23)
				{
				$html .= " <th rowspan = '1'>CR</th>\n";
				}
				if ($product == 24)
				{
				$html .= " <th rowspan = '1'>BB</th>\n";
				}
//				if ($product >= 25 && $product <=47)
//				{
//				$html .= " <th rowspan = '1'>  </th>\n";
//				}
//				if ($product >= 49)
//				{
//				$html .= " <th rowspan = '1'> </th>\n";
//				}
				//$html .= "<th>".$row->SEGMENT."</th>\n";
//------- <TH> 2
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
//------- <TH> 3			
				$html .= "	<td>".$row->PRODUCT_NAME."</td>\n";
//------- <TH> 4
				if($proc==16 || $product==701)
				{
				$html .= "	<td align='right'>".number_format($target,2,'.',',')."</td>\n";
				}
				else
				{
				$html .= "	<td align='right'>".number_format($target,0,'.',',')."</td>\n";
				}
//------- <TH> 5
				if($pencapaian<0)
				{
				$html .= "	<td align='right'><span style='color:#f00'>".$pencapaian."</span></td>\n";
				}
				else
				{
				$html .= "	<td align='right'>".$pencapaian."</td>\n";
				}
//------- <TH> 6							
				if(round($realisasi)<0)
				{
				$html .= "	<td align='right'><span style='color:#f00'>".round($realisasi)."%</span></td>\n";
				}
				else
				{
				$html .= "	<td align='right'>".round($realisasi)."%</td>\n";
				}
*/		
$html .= " <th>CR</th>\n";
//$html .= "<th>".$row->SEGMENT."</th>\n";
$html .= "	<td width='20' align='center'>".$i."</td>\n";
$html .= "	<td>".$row->PRODUCT_NAME."</td>\n";
$html .= "	<td align='right'>".number_format($target,2,'.',',')."</td>\n";
$html .= "	<td align='right'><span style='color:#f00'>".$pencapaian."</span></td>\n";
$html .= "	<td align='right'><span style='color:#f00'>".round($realisasi)."%</span></td>\n";

//------------------------------

				$html .= "</tr>\n";
				$i++;
				}
/*
*/			
//---------------------------------------------------------------------				
				
				//added by Fredy
				$html .= "</table>\n";
				$html .= "\n";
				
				$html .= "<br>PENAMBAHAN MANUAL\n";
				$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
				$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>Jenis DPK</th>\n						
						<th align='center'>Giro</th>\n
						<th align='center'>Tabungan</th>\n
						<th align='center'>Deposito</th>\n
						<!--<th align='center'>Griya</th>\n
						<th align='center'>Fleksi</th>\n
						<th align='center'>Multiguna</th>\n-->
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
				$html .= "	<td align='right'>".number_format($dpk_tambahan[1],0,'.',',')."</td>\n";
				$html .= "	<td align='right'>".number_format($dpk_tambahan[2],0,'.',',')."</td>\n";
				$html .= "	<td align='right'>".number_format($dpk_tambahan[3],0,'.',',')."</td>\n";
				//$html .= "	<td align='right'>".number_format($dpk_tambahan[4],0,'.',',')."</td>\n";
				//$html .= "	<td align='right'>".number_format($dpk_tambahan[5],0,'.',',')."</td>\n";
				//$html .= "	<td align='right'>".number_format($dpk_tambahan[6],0,'.',',')."</td>\n";
				$html .= "</tr>\n";
					$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'><span style='color:#c00'>2</span></td>\n";
				$html .= "	<td><span style='color:#c00'>NON PERORANGAN</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_tambahan[4],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_tambahan[5],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_tambahan[6],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[4],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[5],0,'.',',')."</span></td>\n";
				#html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[6],0,'.',',')."</span></td>\n";
				$html .= "</tr>\n";
/*
*/				
	//---------------------------------------------------------------------				

		//added by Fredy
				$html .= "</table>\n";
				$html .= "\n";
				
				$html .= "<br><span style='color:#c00'>PENGURANGAN MANUAL\n</span>";
				$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
				$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'><span style='color:#c00'>No.</span></th>\n
						<th><span style='color:#c00'>Jenis DPK</span></th>\n						
						<th align='center'><span style='color:#c00'>Giro</span></th>\n
						<th align='center'><span style='color:#c00'>Tabungan</span></th>\n
						<th align='center'><span style='color:#c00'>Deposito</span></th>\n
						<!--th align='center'><span style='color:#c00'>Griya</span></th>\n
						<th align='center'><span style='color:#c00'>Fleksi</span></th>\n
						<th align='center'><span style='color:#c00'>Multiguna</span></th-->\n
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
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[1],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[2],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[3],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[4],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[5],0,'.',',')."</span></td>\n";
				#html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[6],0,'.',',')."</span></td>\n";
				$html .= "</tr>\n";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'><span style='color:#c00'>2</span></td>\n";
				$html .= "	<td><span style='color:#c00'>NON PERORANGAN</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[4],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[5],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[6],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[4],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[5],0,'.',',')."</span></td>\n";
				#html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[6],0,'.',',')."</span></td>\n";
				$html .= "</tr>\n";
/*
*/	
				
//---------------------------------------------------------------------				
/*
		}
		}
		
		else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
*/	
		
		$html .= "</table>";
		echo $html;
	
	
	
	}	
//==========================================
	
	function getRealisasi($id = 0, $m = 1, $y = '0')
	{
//		
		
		$bulan = array(	'1'=>'Januari', 
						'2'=>'Februari', 
						'3'=>'Maret', 
						'4'=>'April',
						'5'=>'Mei', 
						'6'=>'Juni', 
						'7'=>'Juli', 
						'8'=>'Agustus',
						'9'=>'September', 
						'10'=>'Oktober', 
						'11'=>'November', 
						'12'=>'Desember');
		
		$user	= $this->_report->get_user($id);
		$usergrade	= $this->_report->get_user_grade($id,$m,$y);
		$getretensi = $this->_report->get_parameter_retensi($id,$m,$y);
		$retensi = $getretensi[0]->RETENSI;
		//$status = $this->_status->get_status_cek($id);
		//foreach ($status as $row)
		//{
			//$npp = $row->NPP;
			//$awal = $row->BLN_AWAL;
			//$akhir = $row->BLN_AKHIR;
			//$thnawal = $row->THN_AWAL;
			//$thnakhir = $row->THN_AKHIR;
			//$tglawal = $row->TGL_AWAL;
			//$tglakhir = $row->TGL_AKHIR;
		//}
		
		$status = $this->_status->get_status_cek1($id,$m,$y);
		foreach ($status as $row)
		{
			$npp = $row->NPP;
			$month = $row ->MONTH;
			$year = $row->YEAR;
			$tglawal = $row->START_DATE;
			$tglakhir = $row->END_DATE;
		}
		
			$gradeuser=$usergrade[0]->GRADETARGET;
			$areauser=$usergrade[0]->KODE_AREA;
			$salestypenew=$usergrade[0]->SALES_TYPE;
			$salestypenewid=$usergrade[0]->SALES;
		#-------------------------------------------
		#	Update pencapaian
		#-------------------------------------------	
		$m_now = date('n');
		$y_now = date('Y');
		$d = date('d');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
	
		if(($m==$m_now && $y==$y_now) ||($d <= 10 && $m==$bulanlalu && $y==$y_now) /*|| ($m==$bulanlalu && $y==$y_now-1) || ($y==$y_now)*/)
		{
			
			#$this->get_pencapaian($id, $m, $y);
			#-------------------------------------------
			#	Update Pencapaian DPK
			#-------------------------------------------
			$this->_realisasi->get_daily_dpk($id,$m,$y);	
			$this->_realisasi->get_daily_dpk_bb($id,$m,$y);				
			#-------------------------------------------
			#	Update Pencapaian RASIO
			#-------------------------------------------
			#$this->_realisasi->get_rasio($id,$m,$y);
			#-------------------------------------------
			#	Update Pencapaian NEW_CUST_DPK
			#-------------------------------------------
			#$this->_realisasi->get_new_cust($id,$m,$y);
			#$this->_realisasi->get_new_cust_bb($id,$m,$y);
			#-------------------------------------------
			#	Update Pencapaian NEW_ACCOUNT_DPK
			#-------------------------------------------
			#$this->_realisasi->get_new_account($id,$m,$y);
			
		//ADD ELO & CCOS
			if(($m>= 3 && $y >= 2016))
			{
			#---------------------------------------------
			#Update Pencapaian Kredit Konsumtif From ELO
			#-----------------------------------------------
			#$this->_realisasi->get_daily_griya($id,$m,$y);
			#$this->_realisasi->get_daily_fleksi($id,$m,$y);
			#$this->_realisasi->get_daily_multiguna($id,$m,$y);
			#$this->_realisasi->get_daily_bwu($id,$m,$y);
			#$this->_realisasi->get_acc_konsumer($id,$m,$y);
			#$this->_realisasi->get_acc_ritel($id,$m,$y);
			#$this->_realisasi->get_approval_rate($id,$m,$y);
			#---------------------------------------------
			#Update Pencapaian Kartu Kredit From CCOS
			#-----------------------------------------------
			$this->_realisasi->get_daily_ccos($id,$m,$y);
			#---------------------------------------------
			#Update Pencapaian DPLK From DPLK
			#-----------------------------------------------
			$this->_realisasi->get_daily_dplk($id,$m,$y);
			$this->_realisasi->get_daily_dplk_bb($id,$m,$y);
			}
		//END OF ELO & CCOS & DPLK
		
			#-------------------------------------------
			#	HITUNG INDIVIDU PERFORMANCE
			#-------------------------------------------
			//$this->_realisasi->hitung_performance($m, $y, $id);
		}
		
		
		
		
		//$this->_realisasi->hitung_performance($m, $y, $id);
		
		#$this->_realisasi->update_performance_sales($id);
		
		$data 	= $this->_report->get_realisasi($id, $m, $y,$salestypenewid);
		$data2  = $this->_report->get_dpk_tambahan($id, $m, $y);
		$data3  = $this->_report->get_dpk_kurang($id, $m, $y, $salestypenewid);
				
		if($user)
		{
			$user_id	= ($user[0]->ID != '')?$user[0]->ID:0;
			$user_name	= ($user[0]->USER_NAME != '')?$user[0]->USER_NAME:0;
			$user_sales	= ($user[0]->SALES_TYPE != '')?$user[0]->SALES_TYPE:0;
			$user_salesid	= ($user[0]->SALES != '')?$user[0]->SALES:0;
		} else {
			$user_id	= '';
			$user_name	= '';
			$user_sales	= '';
			$user_salesid	= '';
		}
		$html 	=  "";
		//$html 	.= "NPP : ".$user[0]->ID."<br />\n";
		$html 	.= "NPP : ".$user_id."<br />\n";
		$html 	.= "NAMA : ".strtoupper($user_name)."<br />\n";
		$html 	.= "SALES TYPE : ".$salestypenew."<br />\n";
		$html 	.= "GRADE TARGET: ".$gradeuser."<br />\n";
		$html 	.= "AREA TARGET: ".$areauser."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($bulan[$m])." ".$y."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th>Kategori</th>\n	
						<th align='center'>No.</th>\n
						<th>Product</th>\n						
						<th align='center'>Target</th>\n
						<th align='center'>Pencapaian</th>\n
						<th align='center'>Realisasi %</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		
		if($data){
			if($y==$year && $id==$npp && $m == $month)
			{
			
			$html 	=  "";
			//$html 	.= "NPP : ".$user[0]->ID."<br />\n";
			$html 	.= "NPP : ".$user_id."<br />\n";
			$html 	.= "NAMA : ".strtoupper($user_name)."<br />\n";
			$html 	.= "SALES TYPE : ".$user_sales."<br />\n";
			$html 	.= "PERIODE : ".strtoupper($bulan[$m])." ".$y."<br /><br />\n";
			$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>Product</th>\n						
						<th align='center'>Target</th>\n
						<th align='center'>Pencapaian</th>\n
						<th align='center'>Realisasi %</th>\n
					</tr>\n";
			$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Terdaftar posisi Non Sales Sejak ".$tglawal." s/d ".$tglakhir."</span></td>\n";	
				$html .= "</tr>\n";			
		
			}
			//elseif($y!=$year && $id==$npp && $m!=$month)
			//{
			//$html 	=  "";
			//$html 	.= "NPP : ".$user[0]->ID."<br />\n";
			//$html 	.= "NPP : ".$user_id."<br />\n";
			//$html 	.= "NAMA : ".strtoupper($user_name)."<br />\n";
			//$html 	.= "SALES TYPE : ".$user_sales."<br />\n";
			//$html 	.= "PERIODE : ".strtoupper($bulan[$m])." ".$y."<br /><br />\n";
			//$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
			//$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						//<th align='center'>No.</th>\n
						//<th>Product</th>\n						
						//<th align='center'>Target</th>\n
						//<th align='center'>Pencapaian</th>\n
						//<th align='center'>Realisasi %</th>\n
					//</tr>\n";
			//$html .= "<tr>\n";
				//$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Terdaftar posisi Non Sales Sejak ".$tglawal." s/d ".$tglakhir."</span></td>\n";	
				//$html .= "</tr>\n";	
			//}
			else
			{
			foreach($data as $row)
			{
				
				$target = 0;
				$pencapaian = 0;
				$realisasi = 0;
				$target = $row->TARGET;				
				$baseline = $row->OUTSTANDING;
				$proc = $row->PROC_ID;
				$product=$row->PRODUCT_ID;
				
				if($proc==1 || $proc==2 || $proc==3 || $proc==9 || $proc == 10 || $proc==11 || $proc==12)
				{ 
						$target = $row->TARGET;
						$pencapaian = $row->PENCAPAIAN - $baseline ;
						$pencapaian = ($pencapaian<1)?'<span style="color:#f00">'.number_format($pencapaian,0,'.',',').'</span>':number_format($pencapaian,0,'.',',');
				}
				elseif($proc==4 || $proc==5 || $proc==6)
				{ 
						$target = $row->TARGET;
						$pencapaian = $row->PENCAPAIAN - $baseline ;
						$pencapaian = ($pencapaian<1)?'<span style="color:#f00">'.number_format($pencapaian,0,'.',',').'</span>':number_format($pencapaian,0,'.',',');
				}
				elseif($proc == 16)
				{
				$pencapaian = number_format($row->PENCAPAIAN,2,'.',',');
				} 
				elseif($product == 701)
				{
				$pencapaian = number_format($row->PENCAPAIAN,2,'.',',');
				} 
				else {$pencapaian = number_format($row->PENCAPAIAN,0,'.',',');} 
				
				if($target <> 0)
				{ 
					if($proc == 1 || $proc == 2 || $proc == 3 || $proc == 9 || $proc == 10 || $proc==11 || $proc==12)
					{
						$realisasi = (($row->PENCAPAIAN-$baseline)/(($baseline+$target)-$baseline))*100;
						if($retensi >=0 and $user_salesid < 6)
						{
						$realisasi = ($realisasi <= 0)?0:$realisasi;
						}
					}
					elseif($proc == 4 || $proc == 5 || $proc ==6)
					{
						$realisasi = (($row->PENCAPAIAN-$baseline)/(($baseline+$target)-$baseline))*100;
						#$realisasi = ($realisasi <= 0)?0:$realisasi;
					}
					elseif($proc==13)
					{
						$realisasi =($row->PENCAPAIAN/$target)*100;
						$realisasih = ($row->PENCAPAIAN/$target)*100;
					}
					elseif($user_salesid==31 && $proc == 14 && $realisasih <75)
					{
						$realisasi = 0;
					}
					else
						$realisasi = ($row->PENCAPAIAN/$target)*100;
				}
				else 
				{
					//echo "boo";die();
					$realisasi = 0;
					$pencapaian = 0;
					$data=array('PENCAPAIAN'=>$realisasi);
					$this->_realisasi->update_pencapaian($row->ID,$data);
	
				}
				#----------------------------
				#	update realisasi
				#----------------------------
				$data=array('REALISASI'=>$realisasi);
				//print_r($data);
				$this->_realisasi->update($row->ID,$data);
				if($y >= 2017)
			{
				$this->_realisasi->hitung_performance($m, $y, $id, $user_salesid);
			}
				
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				/*if ($product == 1)
				{
				$html .= " <th rowspan = '3'>CR</th>\n";
				}
				#if (($product == 1 && $user_salesid != 10)||($product == 1 && $user_salesid != 12))
				#{
				#$html .= " <th rowspan = '3'>CR</th>\n";
				#}
				#if (($product == 1 && $user_salesid==10)||($product == 1 && $user_salesid==12))
				#{
				#$html .= " <th rowspan = '2'></th>\n";
				#}
				if ($product == 4)
				{
				$html .= " <th rowspan = '3'>BB</th>\n";
				}
				if ($product == 7)
				{
				$html .= " <th rowspan = '3'>CR</th>\n";
				}
				if ($product == 10)
				{
				$html .= " <th rowspan = '3'>BB</th>\n";
				}
				if ($product == 13)
				{
				$html .= " <th rowspan = '1'>CR</th>\n";
				}
				if ($product == 14)
				{
				$html .= " <th rowspan = '1'>BB</th>\n";
				}
				if ($product == 15)
				{
				$html .= " <th rowspan = '1'>CR</th>\n";
				}
				if ($product == 16)
				{
				$html .= " <th rowspan = '1'>BB</th>\n";
				}
				if($product == 17)
				{
				$html .= " <th rowspan = '1'>CR</th>\n";
				}
				#if(($product == 17 && $user_salesid != 10)||($product == 17 && $user_salesid != 12))
				#{
				#$html .= " <th rowspan = '1'>CR</th>\n";
				#}
				#if(($product == 17 && $user_salesid==10)||($product == 17 && $user_salesid==12))
				#{
				#$html .= " <th rowspan = '1'></th>\n";
				#}
				if($product == 18)
				{
				$html .= " <th rowspan = '3'>CR</th>\n";
				}
				#if(($product == 18 && $user_salesid != 10)||($product == 18 && $user_salesid != 12))
				#{
				#$html .= " <th rowspan = '3'>CR</th>\n";
				#}
				#if(($product == 18 && $user_salesid==10)||($product == 18 && $user_salesid==12))
				#{
				#$html .= " <th rowspan = '2'></th>\n";
				#}
				if ($product == 21)
				{
				$html .= " <th rowspan = '1'>CR</th>\n";
				}
				if ($product == 22)
				{
				$html .= " <th rowspan = '1'>BB</th>\n";
				}
				if ($product == 23)
				{
				$html .= " <th rowspan = '1'>CR</th>\n";
				}
				if ($product == 24)
				{
				$html .= " <th rowspan = '1'>BB</th>\n";
				}
				if ($product >= 25 && $product <=47)
				{
				$html .= " <th rowspan = '1'>  </th>\n";
				}
				if ($product >= 49)
				{
				$html .= " <th rowspan = '1'> </th>\n";
				}*/
				$html .= "<th>".$row->SEGMENT."</th>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->PRODUCT_NAME."</td>\n";
				if($proc==16 || $product==701)
				{
				$html .= "	<td align='right'>".number_format($target,2,'.',',')."</td>\n";
				}
				else
				{
				$html .= "	<td align='right'>".number_format($target,0,'.',',')."</td>\n";
				}
				if($pencapaian<0)
				{
				$html .= "	<td align='right'><span style='color:#f00'>".$pencapaian."</span></td>\n";
				}
				else
				{
				$html .= "	<td align='right'>".$pencapaian."</td>\n";
				}
				if(round($realisasi)<0)
				{
				$html .= "	<td align='right'><span style='color:#f00'>".round($realisasi)."%</span></td>\n";
				}
				else
				{
				$html .= "	<td align='right'>".round($realisasi)."%</td>\n";
				}
				$html .= "</tr>\n";
				$i++;
				}
			
				
				//added by Fredy
				$html .= "</table>\n";
				$html .= "\n";
				
				$html .= "<br>PENAMBAHAN MANUAL\n";
				$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
				$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>Jenis DPK</th>\n						
						<th align='center'>Giro</th>\n
						<th align='center'>Tabungan</th>\n
						<th align='center'>Deposito</th>\n
						<!--<th align='center'>Griya</th>\n
						<th align='center'>Fleksi</th>\n
						<th align='center'>Multiguna</th>\n-->
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
				$html .= "	<td align='right'>".number_format($dpk_tambahan[1],0,'.',',')."</td>\n";
				$html .= "	<td align='right'>".number_format($dpk_tambahan[2],0,'.',',')."</td>\n";
				$html .= "	<td align='right'>".number_format($dpk_tambahan[3],0,'.',',')."</td>\n";
				//$html .= "	<td align='right'>".number_format($dpk_tambahan[4],0,'.',',')."</td>\n";
				//$html .= "	<td align='right'>".number_format($dpk_tambahan[5],0,'.',',')."</td>\n";
				//$html .= "	<td align='right'>".number_format($dpk_tambahan[6],0,'.',',')."</td>\n";
				$html .= "</tr>\n";
					$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'><span style='color:#c00'>2</span></td>\n";
				$html .= "	<td><span style='color:#c00'>NON PERORANGAN</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_tambahan[4],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_tambahan[5],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_tambahan[6],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[4],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[5],0,'.',',')."</span></td>\n";
				#html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[6],0,'.',',')."</span></td>\n";
				$html .= "</tr>\n";
				
	
		//added by Fredy
				$html .= "</table>\n";
				$html .= "\n";
				
				$html .= "<br><span style='color:#c00'>PENGURANGAN MANUAL\n</span>";
				$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
				$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'><span style='color:#c00'>No.</span></th>\n
						<th><span style='color:#c00'>Jenis DPK</span></th>\n						
						<th align='center'><span style='color:#c00'>Giro</span></th>\n
						<th align='center'><span style='color:#c00'>Tabungan</span></th>\n
						<th align='center'><span style='color:#c00'>Deposito</span></th>\n
						<!--th align='center'><span style='color:#c00'>Griya</span></th>\n
						<th align='center'><span style='color:#c00'>Fleksi</span></th>\n
						<th align='center'><span style='color:#c00'>Multiguna</span></th-->\n
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
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[1],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[2],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[3],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[4],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[5],0,'.',',')."</span></td>\n";
				#html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[6],0,'.',',')."</span></td>\n";
				$html .= "</tr>\n";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'><span style='color:#c00'>2</span></td>\n";
				$html .= "	<td><span style='color:#c00'>NON PERORANGAN</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[4],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[5],0,'.',',')."</span></td>\n";
				$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[6],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[4],0,'.',',')."</span></td>\n";
				#$html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[5],0,'.',',')."</span></td>\n";
				#html .= "	<td align='right'><span style='color:#c00'>".number_format($dpk_kurang[6],0,'.',',')."</span></td>\n";
				$html .= "</tr>\n";
				
		}
		}
		
		else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	
	//==================
	// create report in excel
	function xlsRealisasi($id = 0, $m = 0, $y = 0)
	{
		
/*
	echo $id;
	echo $m;
	echo $y;
*/
		
	/*
		
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES','ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/4');}
		//$status = $this->_status->get_status_cek($id);
		$status = $this->_status->get_status_cek1($id,$m,$y);
		foreach ($status as $row)
		{
			$npp = $row->NPP;
			$month = $row ->MONTH;
			$year = $row->YEAR;
			$tglawal = $row->START_DATE;
			$tglakhir = $row->END_DATE;
		}
		
		if($y==$year && $id==$npp && $m == $month)
			{
		$data['user']	= $this->_report->get_user($id);
		$data['month']	= $m;
		$data['year']	= $y;
		$data['data']   = 'Terdaftar sebagai Posisi Non Sales';
		}
		else
		{
		$data['user']	= $this->_report->get_user($id);
		$data['month']	= $m;
		$data['year']	= $y;
		$data['data'] 	= $this->_report->get_realisasi($id, $m, $y);
		$data['data2']  = $this->_report->get_dpk_tambahan($id, $m, $y);
		$data['data3']  = $this->_report->get_dpk_kurang($id, $m, $y);
		
		}
	*/	
//----------------
		$data['user']	= $this->_report->get_user($id);
		$data['month']	= $m;
		$data['year']	= $y;
		$data['data']   = 'Terdaftar sebagai Posisi Non Sales';


		$this->load->view('report/xls_realisasi', $data);
	}
	
	#---------------------------------------
	# 	Report Realisasi Cabang / Wilayah
	#---------------------------------------	
	function realisasi_cab()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('WILAYAH', 'CABANG','PIMPINAN_CABANG','PIMPINAN_WILAYAH');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/4');}
		
		$this->load->view('report/realisasi_cab');
	}
	
	#----------------------------------------------
	# 	Report Realisasi Cabang / Wilayah excel
	#----------------------------------------------	
	function xlsRealisasiCab($id = 0, $m = 0, $y = 0, $cab, $wil)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('WILAYAH','CABANG','PIMPINAN_CABANG','PIMPINAN_WILAYAH');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/4');}
		$bln = $this->nama_bulan($m);
		$result	= $this->_report->get_cabang_detail($cab);
		$cabang = ($result)?$result[0]->BRANCH_NAME:'';		
		$dbdata 		= $this->_report->get_realisasi_cab($id, $m, $y, $cab, $wil, 1);		
		$fields 		= array('SALES_ID','USER_NAME','PRODUCT_NAME','TARGET','PENCAPAIAN','REALISASI');
		$header 		= array('NPP','SALES','PRODUK','TARGET','PENCAPAIAN','REALISASI');
		$number_format	= array(0,0,0,0,0,0);
		$addition		= array('Report'=>'REALISASI SALES (CABANG)','PERIODE'=>"$bln $y",'CABANG'=>strtoupper($cabang));
		$title 			= 'Realisasi Sales (Cabang)';
		$file_name 		= "realisasi_sales_$cabang_$m_$y.xls";
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
	}
	
	
	#---------------------------------------
	# 	Report Realisasi Cabang / Wilayah
	#---------------------------------------	
	function performance_cab()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('WILAYAH', 'CABANG','PIMPINAN_CABANG','PIMPINAN_WILAYAH');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/4');}
		
		$this->load->view('report/performance_sup');
	}
	
	#----------------------------------------------
	# 	Report Realisasi Cabang / Wilayah excel
	#----------------------------------------------	
	function xlsPerformanceCab($m = 0, $y = 0, $cab, $wil)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('WILAYAH','CABANG','PIMPINAN_CABANG','PIMPINAN_WILAYAH');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/4');}
		
		#$data['user']	= $this->_report->get_user($id);
		$data['month']	= $m;
		$data['year']	= $y;
		$data['cab'] = $this->_report->get_cabang_detail($cab);
		$data['wil'] = $wil;
		$data['data'] 	= $this->_report->get_performance_cab($m, $y, $cab, $wil);
		$this->load->view('report/xls_performance_cab', $data);
	}
	
	#-------------------------------------
	# 	Report Realisasi per Cabang
	#-------------------------------------
	
	function realisasi_sup()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}
		
		$data = $this->list_user();	
		
		$this->load->view('report/realisasi_sup', $data);		
*/
echo"Realisasi Sales c->report/realisasi_sup";		
	}
	
	#-------------------------------------
	# 	Report AUM
	#-------------------------------------	
	function nasabah_aum()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
	
		$this->load->view('report/nasabah_aum');
	}
	
	function get_nasabah_aum($id =0, $m=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_nasabah_kelolaan_aum($id, $m);
		#$ket 	= ($m == 1)?'Last Month':'Yesterday';
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}

		
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>TANGGAL</th>\n
						<th align='center' class='kecil'>CIF</th>\n
						<th align='left' class='kecil'>BRANCH</th>\n						
						<th align='left' class='kecil'>NAMA</th>\n
						<th align='right' class='kecil'>TOTAL DPK</th>\n
						<th align='right' class='kecil'>INVESTASI</th>\n
						<th align='right' class='kecil'>BANCASSURANCE</th>\n
						<th align='right' class='kecil'>TOTAL AUM</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->BNI_CIF_KEY."</td> \n";
				//$html .= "<td width='' align='left' class='kecil'>".$row->BRANCH_NAME.' - '.$row->BRANCH."</td> \n";
				#$html .= "<td width='' align='left' class='kecil'>$branch</td> \n";
				$html .= "<td width='' align='left' class='kecil'>$branch2</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format(($row->GIRO+$row->TABUNGAN+$row->DEPOSITO),2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->INVESTASI,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->BANCAS,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format(($row->GIRO+$row->TABUNGAN+$row->DEPOSITO+$row->INVESTASI+$row->BANCAS),2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		echo $html;
	}
	
	// create report in excel aum
	function xls_nasabah_aum($id = 0, $m = 0)
	
	{
				switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPER VISOR', 'SUPERVISOR');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		
		$user 			= $this->_report->get_user($id);
		$dbdata 		= $this->_report->get_neo_nasabah_kelolaan($id, $m);
			
		$fields 		= array('AS_OF_DATE','BNI_CIF_KEY','OPEN_BRANCH','CUST_NAME','DPK','AMOUNT',0,'AUM');
		$header 		= array('TANGGAL','CIF','CABANG','NASABAH','DPK','INVESTASI','BANCASSURANCE','AUM');
		$number_format	= array(0,0,0,0,1,1,1,1);
		$addition		= array('Report'=>'NASABAH KELOLAAN '.strtoupper($ket),'Npp'=>'['.$user[0]->ID.']','Nama'=>$user[0]->USER_NAME,'Sales'=>$user[0]->SALES_TYPE);
		$title 			= 'Nasabah Kelolaan AUM';
		$file_name 		= 'nasabah_keloaan_aum_'.$id.'.xls';
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
	}
	
	// create report in excel konsumer
	function xls_konsumer($id = 0, $m = 0)
	{
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
		}
		
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPER VISOR', 'SUPERVISOR');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		
		$user 			= $this->_report->get_user($id);
		$dbdata 		= $this->_report->get_nasabah_konsumer($id, $m);
			
		$fields 		= array('AS_OF_DATE','APP_REGNO','GROUP_NAME','PRODUCT_NAME','CUST_NAME','AMOUNT','APPLY_DATE','APPROVE_DATE','BOOKING_DATE');
		$header 		= array('TANGGAL','APPREGNO','GROUPNAME','PRODUCTNAME','CUSTNAME','AMOUNT','TGLAPPLY','TGLAPPROVE','TGLBOOKING');
		$number_format	= array(0,0,0,0,0,1,0,0,0);
		$addition		= array('Report'=>'NASABAH KREDIT KONSUMTIF '.strtoupper($ket),'Npp'=>'['.$user[0]->ID.']','Nama'=>$user[0]->USER_NAME,'Sales'=>$user[0]->SALES_TYPE);
		$title 			= 'Nasabah Kredit Kosnumtif';
		$file_name 		= 'nasabah_kredit_konsumtif_'.$id.'.xls';
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
	}
	
	## xls cc
		// create report in excel
	function xlscc($id = 0, $type=0,  $start = NOW, $end = NOW)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] 	= $type;
		$data['user']	= $this->_report->get_user($id);
		$data['start']	= $start;
		$data['end']	= $end;
		$data['data'] 	= $this->_report->get_cc($id,$start, $end);
		$this->load->view('report/xls_cc', $data);
	}
	
	## xls dplk
		// create report in excel
	function xlsdplk($id = 0, $type=0,  $start = NOW, $end = NOW)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] 	= $type;
		$data['user']	= $this->_report->get_user($id);
		$data['start']	= $start;
		$data['end']	= $end;
		$data['data'] 	= $this->_report->get_dplk($id,$start, $end);
		$this->load->view('report/xls_dplk', $data);
	}
	
	
	#-------------------------------------
	# 	Report Nasabah kelolaan
	#-------------------------------------	
	function nasabah()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
	
		$this->load->view('report/nasabah');
/*
echo"Nasabah Kelolaan Sales c->report/nasabah";
*/		
	}
	
	function get_list_nasabah($id=0)
	{
		#$user = $this->_report->get_user($id);
		$data = $this->_report->get_list_nasabah($id);
/*
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
*/		
		
		$html 	=  "";
/*
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
*/		
		$html 	.= "NPP : 12345 <br />\n";
		$html 	.= "NAMA : XXXXXX <br />\n";
		$html 	.= "SALES TYPE : XXXXX <br />\n";
		
		$html   .= "<font color=red>Ket : Posisi Saldo Rata-Rata Baseline menggunakan posisi saldo rata-rata<br /></font>\n";
		$html 	.= "<table width='75%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>Tgl Baseline</th>\n
						<th align='center' class='kecil'>CIF</th>\n
						<th align='center' class='kecil'>Tipe</th>\n
						<th align='center' class='kecil'>Nama Nasabah</th>\n
						<th align='center' class='kecil'>Rekening</th>\n
						<th align='center' class='kecil'>Produk</th>\n
						<th align='center' class='kecil'>Saldo Rata-rata</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		#print_r($data);
		if($data)
		{
			foreach($data as $row)
			{
//$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				//$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				//$color = ($i%2)?"#ffffff":"#eeeeee";
			$color = "#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->BASELINE_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CIF_KEY."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CUST_TYPE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->ID_NUMBER."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->PRODUCT_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".number_format(($row->AVG_BOOK_BAL),2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
/*
*/		
		$html .= "</table> \n";
		echo $html;	
	}
	
	function get_list_nasabah_bb($id=0)
	{
		$user = $this->_report->get_user($id);
		$data = $this->_report->get_list_nasabah_bb($id);
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html   .= "<font color=red>Ket : Posisi Saldo Rata-Rata Baseline menggunakan posisi saldo rata-rata<br /></font>\n";
		$html 	.= "<table width='75%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>Tgl Baseline</th>\n
						<th align='center' class='kecil'>CIF</th>\n
						<th align='center' class='kecil'>Nama Nasabah</th>\n
						<th align='center' class='kecil'>Rekening</th>\n
						<th align='center' class='kecil'>Produk</th>\n
						<th align='center' class='kecil'>Saldo Rata-rata</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->BASELINE_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CIF_KEY."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->ID_NUMBER."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->PRODUCT_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".number_format(($row->AVG_BOOK_BAL),2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		echo $html;	
	}
	
	function get_baseline($id=0,$year=2011,$bulan=0)
	{
		//$user = $this->_report->get_user($id);
		$data = $this->_report->get_baseline($id,$year,$bulan);
/*
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
*/		
		$html 	=  "";
/*
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
*/		
		$html 	.= "NPP : 12345 <br />\n";
		$html 	.= "NAMA : XXXXXX <br />\n";
		$html 	.= "SALES TYPE : Xxxxxxx <br />\n";
		
		$html   .= "<font color=red>Ket : Saldo Baseline menggunakan data saldo rata-rata<br /></font>\n";
		$html 	.= "<table width='50%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>TGL BASELINE</th>\n
						<th align='center' class='kecil'>TIPE</th>\n
						<th align='center' class='kecil'>PRODUCT NAME</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->BASELINE_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CUST_TYPE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->PRODUCT_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".number_format($row->OUTSTANDING,2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		echo $html;	
	}
	
	function get_baseline_bb($id=0,$year=2011,$bulan=0)
	{
		$user = $this->_report->get_user($id);
		$data = $this->_report->get_baseline_bb($id,$year,$bulan);
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html   .= "<font color=red>Ket : Saldo Baseline menggunakan data saldo rata-rata<br /></font>\n";
		$html 	.= "<table width='50%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>TGL BASELINE</th>\n
						<th align='center' class='kecil'>PRODUCT NAME</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->BASELINE_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->PRODUCT_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".number_format($row->OUTSTANDING,2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		echo $html;	
	}
	
	function get_baseline_aum($id=0)
	{
		$user = $this->_report->get_user($id);
		$data = $this->_report->get_baseline_aum($id);
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html   .= "<font color=red>Ket : Saldo Baseline menggunakan data saldo rata-rata<br /></font>\n";
		$html 	.= "<table width='50%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>TGL BASELINE</th>\n
						<th align='center' class='kecil'>CIF</th>\n
						<th align='center' class='kecil'>NAMA</th>\n
						<th align='center' class='kecil'>DPK</th>\n
						<th align='center' class='kecil'>INVESTASI</th>\n
						<th align='center' class='kecil'>BANCASSURANCE</th>\n
						<th align='center' class='kecil'>AUM</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->BASELINE_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CIF_KEY."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".number_format($row->DPK,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".number_format($row->INVESTASI,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".number_format($row->BANCAS,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".number_format($row->AUM,2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		echo $html;	
	}
	
	
	function get_nasabah($id =0, $m=0 ,$tipe=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_nasabah_kelolaan($id, $m, $tipe);
		#$ket 	= ($m == 1)?'Last Month':'Yesterday';
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		switch ($tipe)
		{
			case 0:
				$cust_type = "CR";
				break;
			case 1:
				$cust_type = "BB";
				break;
		}
		
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html   .= "CUST TYPE : ".$cust_type."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<div STYLE='height: auto; width: auto; font-size: 12px; overflow: auto;'>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil' rowspan ='2'>NO.</th>\n
						<th align='center' class='kecil' rowspan ='2'>TANGGAL</th>\n
						<th align='center' class='kecil' rowspan ='2'>CIF</th>\n
						<th align='center' class='kecil' rowspan ='2'>BRANCH</th>\n						
						<th align='center' class='kecil' rowspan ='2'>NAMA</th>\n
						<th align='center' class='kecil' rowspan ='2'>NASABAH</th>\n
						<th align='center' class='kecil' colspan='3'>GIRO</th>\n
						<th align='center' class='kecil' colspan='3'>TABUNGAN</th>\n
						<th align='center' class='kecil' colspan='3'>DEPOSITO</th>\n
						<th align='center' class='kecil' colspan='3'>DPK</th>\n
					</tr>\n";
					
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CIF_KEY."</td> \n";
				//$html .= "<td width='' align='left' class='kecil'>".$row->BRANCH_NAME.' - '.$row->BRANCH."</td> \n";
				#$html .= "<td width='' align='left' class='kecil'>$branch</td> \n";
				$html .= "<td width='' align='left' class='kecil'>$branch2</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->KET."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_GIRO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_DEPOSITO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DPK,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DPK_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_DPK,2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='17' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		$html .= "</div>";
		echo $html;
	}
	
	function get_nasabah_bm_tab($id =0, $m=0 ,$tipe=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_nasabah_kelolaan4($id, $m, $tipe);
		#$sumdata = $this->_report->get_nasabah_sum_kelolaan4($id, $m, $tipe);
		#$ket 	= ($m == 1)?'Last Month':'Yesterday';
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		switch ($tipe)
		{
			case 0:
				$cust_type = "CR";
				break;
			case 1:
				$cust_type = "BB";
				break;
		}
		
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		#$html 	.= "NPP : ".$npp."<br />\n";
		#$html 	.= "NAMA : ".$sales."<br />\n";
		#$html 	.= "SALES TYPE : ".$name."<br />\n";
		#$html   .= "CUST TYPE : ".$cust_type."<br />\n";
		#$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<div STYLE='height: auto; width: auto; font-size: 12px; overflow: auto;'>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil' rowspan ='2'>NO.</th>\n
						<th align='center' class='kecil' rowspan ='2'>TANGGAL</th>\n
						<th align='center' class='kecil' rowspan ='2'>CIF</th>\n
						<th align='center' class='kecil' rowspan ='2'>BRANCH</th>\n						
						<th align='center' class='kecil' rowspan ='2'>NAMA</th>\n
						<th align='center' class='kecil' colspan='5'>TABUNGAN</th>\n
						<th align='center' class='kecil' rowspan ='2'>AKSI</th>\n
					";
					
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>&Delta; TABUNGAN</th>\n
						<th align='center' class='kecil'>PIPELINE</th>\n
						<th align='center' class='kecil'>&Delta; PIPELINE</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
			#echo "<pre>"; print_r($data); die();
		if($data)
		{
		
			$sumtabungan = 0;
			$sumbaseline = 0;
			$sumdeltatabungan = 0;
			$sumrencana =0;
			$sumdeltarencana =0;
			foreach($data as $row)
			{
				$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'><a href='#' class='popup' onclick='getActivity($i);getProduk($i);getNasabah($i)'>".$row->CIF_KEY."</a></td> \n";
				$html .= "<input type='hidden' name='CF".$i."' id='CF".$i."' value='".$row->CIF_KEY."'>";
				//$html .= "<td width='' align='left' class='kecil'>".$row->BRANCH_NAME.' - '.$row->BRANCH."</td> \n";
				#$html .= "<td width='' align='left' class='kecil'>$branch</td> \n";
				$html .= "<td width='' align='left' class='kecil'>$branch2</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<input type='hidden' name='CN".$i."' id='CN".$i."' value='".$row->CUST_NAME."'>";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN_BASELINE,2,'.',',')."</td> \n";
				switch($row->STATUS_TABUNGAN)
				{
					case 'LEAK':
					$html .= "<td width='' align='right' class='kecil' bgcolor='red'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
					break;
					case 'PAR':
					$html .= "<td width='' align='right' class='kecil' bgcolor='yellow'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</td> \n";
					break;
					case 'RAISE':
					$html .= "<td width='' align='right' class='kecil' bgcolor='green'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
					break;
				}
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->RENCANA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_RENCANA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<input type='hidden' name='S".$i."' id='S".$i."' value='".$row->STATUS_TABUNGAN."'>";
				#switch($row->STATUS_TABUNGAN)
				#{
				#	case 'LEAK':
				#	$html .= "<td width='' align='center' class='kecil' bgcolor='red'><font color='#FFF'>".$row->STATUS_TABUNGAN."</font></td> \n";
				#	break;
				#	case 'PAR':
				#	$html .= "<td width='' align='center' class='kecil' bgcolor='yellow'>".$row->STATUS_TABUNGAN."</td> \n";
				#	break;
				#	case 'RAISE':
				#	$html .= "<td width='' align='center' class='kecil' bgcolor='green'><font color='#FFF'>".$row->STATUS_TABUNGAN."</font></td> \n";
				#	break;
				#}
				switch ($row->AKTIFITAS)
				{
					CASE 0:
					$html .= "<td width='' align='center' class='kecil'><button onclick='catat_agenda(".$i.")'>Aksi</button></td> \n";
					break;
				    CASE 1:
					$html .= "<td width='' align='center' class='kecil'><button onclick='catat_agenda(".$i.")' disabled>Aksi</button></td> \n";
				    break;
				}
				$html .= "</tr> \n";
			$sumtabungan = $sumtabungan + $row->TABUNGAN;
			$sumbaseline = $sumbaseline + $row->TABUNGAN_BASELINE;
			$sumdeltatabungan = $sumdeltatabungan + $row->DELTA_TABUNGAN;
			$sumrencana = $sumrencana + $row->RENCANA_TABUNGAN;
			$sumdeltarencana = $sumdeltarencana + $row->DELTA_RENCANA_TABUNGAN;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='17' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html 	.= "<tr  bgcolor='#66FF66'>\n";
		$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Total</span></td>\n";	
		
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumtabungan,2,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumbaseline,2,'.',',')."</b></td> \n";
				if($sumdeltatabungan < 0 )
				{
				$html .= "<td width='' align='right' class='kecil' bgcolor='red'><font color='#FFF'><b>".number_format($sumdeltatabungan,2,'.',',')."</b></font></td> \n";
				}
				if($sumdeltatabungan==0)
				{
				$html .= "<td width='' align='right' class='kecil' bgcolor='yellow'><b>".number_format($sumdeltatabungan,2,'.',',')."</b></td> \n";
				}
				if($sumdeltatabungan>0)
				{
				$html .= "<td width='' align='right' class='kecil' bgcolor='green'><font color='#FFF'><b>".number_format($sumdeltatabungan,2,'.',',')."</b></font></td> \n";
				}
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumrencana,2,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumdeltarencana,2,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b></b></td> \n";
		$html .= "</table> \n";
		$html .= "</div>";
		echo $html;
	}
	
	function get_nasabah_bm_tab_detail($id =0, $m=0 ,$tipe=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_nasabah_kelolaan4($id, $m, $tipe);
		#$sumdata = $this->_report->get_nasabah_sum_kelolaan4($id, $m, $tipe);
		#$ket 	= ($m == 1)?'Last Month':'Yesterday';
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		switch ($tipe)
		{
			case 0:
				$cust_type = "CR";
				break;
			case 1:
				$cust_type = "BB";
				break;
		}
		
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		#$html 	.= "NPP : ".$npp."<br />\n";
		#$html 	.= "NAMA : ".$sales."<br />\n";
		#$html 	.= "SALES TYPE : ".$name."<br />\n";
		#$html   .= "CUST TYPE : ".$cust_type."<br />\n";
		#$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<div STYLE='height: auto; width: auto; font-size: 12px; overflow: auto;'>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil' rowspan ='2'>NO.</th>\n
						<th align='center' class='kecil' rowspan ='2'>TANGGAL</th>\n
						<th align='center' class='kecil' rowspan ='2'>CIF</th>\n
						<th align='center' class='kecil' rowspan ='2'>BRANCH</th>\n						
						<th align='center' class='kecil' rowspan ='2'>NAMA</th>\n
						<th align='center' class='kecil' colspan='5'>TABUNGAN</th>\n
					";
					
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>&Delta; TABUNGAN</th>\n
						<th align='center' class='kecil'>PIPELINE</th>\n
						<th align='center' class='kecil'>&Delta; PIPELINE</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
			#echo "<pre>"; print_r($data); die();
		if($data)
		{
		
			$sumtabungan = 0;
			$sumbaseline = 0;
			$sumdeltatabungan = 0;
			$sumrencana =0;
			$sumdeltarencana =0;
			foreach($data as $row)
			{
				$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
				#$html .= "<td width='' align='center' class='kecil'>".$row->CIF_KEY."</td> \n";
				$html .= "<input type='hidden' name='CF".$i."' id='CF".$i."' value='".$row->CIF_KEY."'>";
				$html .= "<td width='' align='center' class='kecil'><a href='#' class='popup' onclick='getActivity($i);getProduk($i);getNasabah($i)'>".$row->CIF_KEY."</a></td> \n";
				//$html .= "<td width='' align='left' class='kecil'>".$row->BRANCH_NAME.' - '.$row->BRANCH."</td> \n";
				#$html .= "<td width='' align='left' class='kecil'>$branch</td> \n";
				$html .= "<td width='' align='left' class='kecil'>$branch2</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<input type='hidden' name='CN".$i."' id='CN".$i."' value='".$row->CUST_NAME."'>";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN_BASELINE,2,'.',',')."</td> \n";
				switch($row->STATUS_TABUNGAN)
				{
					case 'LEAK':
					$html .= "<td width='' align='right' class='kecil' bgcolor='red'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
					break;
					case 'PAR':
					$html .= "<td width='' align='right' class='kecil' bgcolor='yellow'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</td> \n";
					break;
					case 'RAISE':
					$html .= "<td width='' align='right' class='kecil' bgcolor='green'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
					break;
				}
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->RENCANA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_RENCANA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<input type='hidden' name='S".$i."' id='S".$i."' value='".$row->STATUS_TABUNGAN."'>";
				#switch($row->STATUS_TABUNGAN)
				#{
				#	case 'LEAK':
				#	$html .= "<td width='' align='center' class='kecil' bgcolor='red'><font color='#FFF'>".$row->STATUS_TABUNGAN."</font></td> \n";
				#	break;
				#	case 'PAR':
				#	$html .= "<td width='' align='center' class='kecil' bgcolor='yellow'>".$row->STATUS_TABUNGAN."</td> \n";
				#	break;
				#	case 'RAISE':
				#	$html .= "<td width='' align='center' class='kecil' bgcolor='green'><font color='#FFF'>".$row->STATUS_TABUNGAN."</font></td> \n";
				#	break;
				#}
				switch ($row->AKTIFITAS)
				{
					CASE 0:
					#$html .= "<td width='' align='center' class='kecil'><button onclick='catat_agenda(".$i.")'>Aksi</button></td> \n";
					break;
				    CASE 1:
					#$html .= "<td width='' align='center' class='kecil'><button onclick='catat_agenda(".$i.")' disabled>Aksi</button></td> \n";
				    break;
				}
				$html .= "</tr> \n";
			$sumtabungan = $sumtabungan + $row->TABUNGAN;
			$sumbaseline = $sumbaseline + $row->TABUNGAN_BASELINE;
			$sumdeltatabungan = $sumdeltatabungan + $row->DELTA_TABUNGAN;
			$sumrencana = $sumrencana + $row->RENCANA;
			$sumdeltarencana = $sumdeltarencana + $row->DELTA_RENCANA_TABUNGAN;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='17' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html 	.= "<tr  bgcolor='#66FF66'>\n";
		$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Total</span></td>\n";	
		
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumtabungan,2,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumbaseline,2,'.',',')."</b></td> \n";
				if($sumdeltatabungan < 0 )
				{
				$html .= "<td width='' align='right' class='kecil' bgcolor='red'><font color='#FFF'><b>".number_format($sumdeltatabungan,2,'.',',')."</b></font></td> \n";
				}
				if($sumdeltatabungan==0)
				{
				$html .= "<td width='' align='right' class='kecil' bgcolor='yellow'><b>".number_format($sumdeltatabungan,2,'.',',')."</b></td> \n";
				}
				if($sumdeltatabungan>0)
				{
				$html .= "<td width='' align='right' class='kecil' bgcolor='green'><font color='#FFF'><b>".number_format($sumdeltatabungan,2,'.',',')."</b></font></td> \n";
				}
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumrencana,2,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumdeltarencana,2,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b></b></td> \n";
		$html .= "</table> \n";
		$html .= "</div>";
		echo $html;
	}
	
	function get_nasabah_bm_tab_sum($branch =0, $m=0 ,$tipe=0)
	{
		$user	= $this->_report->get_user($id);
		$data   = $this->_report->get_nasabah_sum_kelolaan4($branch, $m, $tipe);
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		switch ($tipe)
		{
			case 0:
				$cust_type = "CR";
				break;
			case 1:
				$cust_type = "BB";
				break;
		}
		
		
		#if($user){
			#$npp 	= $user[0]->ID;
		#	$sales 	= strtoupper($user[0]->USER_NAME);
		#	$name 	= $user[0]->SALES_TYPE;
		#} else {
		#	$npp 	= '';
		#	$sales 	= '';
		#	$name 	= '';
		#}
		
		$html 	=  "";
		#$html 	.= "NPP : ".$npp."<br />\n";
		#$html 	.= "NAMA : ".$sales."<br />\n";
		#$html 	.= "SALES TYPE : ".$name."<br />\n";
		#$html   .= "CUST TYPE : ".$cust_type."<br />\n";
		#$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<div STYLE='height: auto; width: auto; font-size: 12px; overflow: auto;'>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil' rowspan ='2'>NO.</th>\n
						<th align='center' class='kecil' rowspan ='2'>NPP</th>\n
						<th align='center' class='kecil' rowspan ='2'>NAMA</th>\n						
						<th align='center' class='kecil' rowspan ='2'>BRANCH</th>\n
						<th align='center' class='kecil' rowspan ='2'>OUTLET</th>\n
						<th align='center' class='kecil' colspan='6'>TABUNGAN</th>\n
					";
					
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>&Delta; TABUNGAN</th>\n
						<th align='center' class='kecil'>PIPELINE</th>\n
						<th align='center' class='kecil'>&Delta; PIPELINE</th>\n
						<th align='center' class='kecil'>Aksi</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		#echo "<pre>"; print_r($data); die();
		if($data)
		{
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->SALES_ID."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->USER_NAME."</td> \n";
				#$html .= "<td width='' align='center' class='kecil'>".$row->USER_LEVEL."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->BRANCH_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->KLN_NAME."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN_BASELINE,2,'.',',')."</td> \n";
				switch($row->STATUS_TABUNGAN)
				{
					case 'LEAK':
					$html .= "<td width='' align='right' class='kecil' bgcolor='red'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
					break;
					case 'PAR':
					$html .= "<td width='' align='right' class='kecil' bgcolor='yellow'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</td> \n";
					break;
					case 'RAISE':
					$html .= "<td width='' align='right' class='kecil' bgcolor='green'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
					break;
				}
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->RENCANA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_RENCANA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'><button onclick='get_detail(".$row->SALES_ID.")'>Detail</button></td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='17' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		$html .= "</div>";
		echo $html;
	}
	
	function get_nasabah_bm_tab_sum_wil($region =0, $m=0 ,$tipe=0)
	{
		$user	= $this->_report->get_user($id);
		$data   = $this->_report->get_nasabah_sum_kelolaan4_wil($region, $m, $tipe);
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		switch ($tipe)
		{
			case 0:
				$cust_type = "CR";
				break;
			case 1:
				$cust_type = "BB";
				break;
		}
		
		
		#if($user){
			#$npp 	= $user[0]->ID;
		#	$sales 	= strtoupper($user[0]->USER_NAME);
		#	$name 	= $user[0]->SALES_TYPE;
		#} else {
		#	$npp 	= '';
		#	$sales 	= '';
		#	$name 	= '';
		#}
		
		$html 	=  "";
		#$html 	.= "NPP : ".$npp."<br />\n";
		#$html 	.= "NAMA : ".$sales."<br />\n";
		#$html 	.= "SALES TYPE : ".$name."<br />\n";
		#$html   .= "CUST TYPE : ".$cust_type."<br />\n";
		#$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<div STYLE='height: auto; width: auto; font-size: 12px; overflow: auto;'>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil' rowspan ='2'>NO.</th>\n
						<th align='center' class='kecil' rowspan ='2'>CABANG</th>\n
						<th align='center' class='kecil' colspan='6'>TABUNGAN</th>\n
					";
					
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>&Delta; TABUNGAN</th>\n
						<th align='center' class='kecil'>PIPELINE</th>\n
						<th align='center' class='kecil'>&Delta; PIPELINE</th>\n
						<th align='center' class='kecil'>Aksi</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		#echo "<pre>"; print_r($data); die();
		if($data)
		{
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>
				".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->BRANCH_NAME."</td> \n";
				$html .= "<input type='hidden' name='branch' id='branch' value='".$row->BRANCH."'>";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN_BASELINE,2,'.',',')."</td> \n";
				switch($row->STATUS_TABUNGAN)
				{
					case 'LEAK':
					$html .= "<td width='' align='right' class='kecil' bgcolor='red'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
					break;
					case 'PAR':
					$html .= "<td width='' align='right' class='kecil' bgcolor='yellow'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</td> \n";
					break;
					case 'RAISE':
					$html .= "<td width='' align='right' class='kecil' bgcolor='green'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
					break;
				}
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->RENCANA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_RENCANA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'><button onclick='get_detailwil(".$row->BRANCH.")'>Detail</button></td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='17' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		$html .= "</div>";
		echo $html;
	}
	
	function get_nasabah_bm_tab_sum_sln($m=0 ,$tipe=0)
	{
		$user	= $this->_report->get_user($id);
		$data   = $this->_report->get_nasabah_sum_kelolaan4_sln($m, $tipe);
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		switch ($tipe)
		{
			case 0:
				$cust_type = "CR";
				break;
			case 1:
				$cust_type = "BB";
				break;
		}
		
		
		#if($user){
			#$npp 	= $user[0]->ID;
		#	$sales 	= strtoupper($user[0]->USER_NAME);
		#	$name 	= $user[0]->SALES_TYPE;
		#} else {
		#	$npp 	= '';
		#	$sales 	= '';
		#	$name 	= '';
		#}
		
		$html 	=  "";
		#$html 	.= "NPP : ".$npp."<br />\n";
		#$html 	.= "NAMA : ".$sales."<br />\n";
		#$html 	.= "SALES TYPE : ".$name."<br />\n";
		#$html   .= "CUST TYPE : ".$cust_type."<br />\n";
		#$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<div STYLE='height: auto; width: auto; font-size: 12px; overflow: auto;'>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil' rowspan ='2'>NO.</th>\n
						<th align='center' class='kecil' rowspan ='2'>WILAYAH</th>\n
						<th align='center' class='kecil' colspan='6'>TABUNGAN</th>\n
					";
					
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>&Delta; TABUNGAN</th>\n
						<th align='center' class='kecil'>PIPELINE</th>\n
						<th align='center' class='kecil'>&Delta; PIPELINE</th>\n
						<th align='center' class='kecil'>Aksi</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		#echo "<pre>"; print_r($data); die();
		if($data)
		{
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>
				".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->REGION_NAME."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN_BASELINE,2,'.',',')."</td> \n";
				switch($row->STATUS_TABUNGAN)
				{
					case 'LEAK':
					$html .= "<td width='' align='right' class='kecil' bgcolor='red'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
					break;
					case 'PAR':
					$html .= "<td width='' align='right' class='kecil' bgcolor='yellow'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</td> \n";
					break;
					case 'RAISE':
					$html .= "<td width='' align='right' class='kecil' bgcolor='green'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
					break;
				}
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->RENCANA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_RENCANA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'><button onclick='get_detailsln(".$row->REGION.")'>Detail</button></td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='17' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		$html .= "</div>";
		echo $html;
	}

	public function get_nasabah_bm_gir($id =0, $m=0 ,$tipe=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_nasabah_kelolaan4($id, $m, $tipe);
		#$ket 	= ($m == 1)?'Last Month':'Yesterday';
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		switch ($tipe)
		{
			case 0:
				$cust_type = "CR";
				break;
			case 1:
				$cust_type = "BB";
				break;
		}
		
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html   .= "CUST TYPE : ".$cust_type."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<div STYLE='height: auto; width: auto; font-size: 12px; overflow: auto;'>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil' rowspan ='2'>NO.</th>\n
						<th align='center' class='kecil' rowspan ='2'>TANGGAL</th>\n
						<th align='center' class='kecil' rowspan ='2'>CIF</th>\n
						<th align='center' class='kecil' rowspan ='2'>BRANCH</th>\n						
						<th align='center' class='kecil' rowspan ='2'>NAMA</th>\n
						<th align='center' class='kecil' rowspan ='2'>NASABAH</th>\n
						<th align='center' class='kecil' colspan='4'>GIRO</th>\n
						<th align='center' class='kecil' colspan='4'>TABUNGAN</th>\n
						<th align='center' class='kecil' colspan='4'>DEPOSITO</th>\n
						<th align='center' class='kecil' colspan='4'>DPK</th>\n
					</tr>\n";
					
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CIF_KEY."</td> \n";
				//$html .= "<td width='' align='left' class='kecil'>".$row->BRANCH_NAME.' - '.$row->BRANCH."</td> \n";
				#$html .= "<td width='' align='left' class='kecil'>$branch</td> \n";
				$html .= "<td width='' align='left' class='kecil'>$branch2</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->KET."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_GIRO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_GIRO."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_TABUNGAN."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_DEPOSITO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_DEPOSITO."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DPK,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DPK_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_DPK,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_DPK."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='17' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		$html .= "</div>";
		echo $html;
	}
	
	function get_nasabah_bm_dep($id =0, $m=0 ,$tipe=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_nasabah_kelolaan4($id, $m, $tipe);
		#$ket 	= ($m == 1)?'Last Month':'Yesterday';
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		switch ($tipe)
		{
			case 0:
				$cust_type = "CR";
				break;
			case 1:
				$cust_type = "BB";
				break;
		}
		
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html   .= "CUST TYPE : ".$cust_type."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<div STYLE='height: auto; width: auto; font-size: 12px; overflow: auto;'>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil' rowspan ='2'>NO.</th>\n
						<th align='center' class='kecil' rowspan ='2'>TANGGAL</th>\n
						<th align='center' class='kecil' rowspan ='2'>CIF</th>\n
						<th align='center' class='kecil' rowspan ='2'>BRANCH</th>\n						
						<th align='center' class='kecil' rowspan ='2'>NAMA</th>\n
						<th align='center' class='kecil' rowspan ='2'>NASABAH</th>\n
						<th align='center' class='kecil' colspan='4'>GIRO</th>\n
						<th align='center' class='kecil' colspan='4'>TABUNGAN</th>\n
						<th align='center' class='kecil' colspan='4'>DEPOSITO</th>\n
						<th align='center' class='kecil' colspan='4'>DPK</th>\n
					</tr>\n";
					
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CIF_KEY."</td> \n";
				//$html .= "<td width='' align='left' class='kecil'>".$row->BRANCH_NAME.' - '.$row->BRANCH."</td> \n";
				#$html .= "<td width='' align='left' class='kecil'>$branch</td> \n";
				$html .= "<td width='' align='left' class='kecil'>$branch2</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->KET."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_GIRO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_GIRO."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_TABUNGAN."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_DEPOSITO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_DEPOSITO."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DPK,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DPK_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_DPK,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_DPK."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='17' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		$html .= "</div>";
		echo $html;
	}
//ok---------------------------	
	function get_nasabah_tab($id =0, $m=0 ,$product=0,$tipe=0)

	{

		$user	= $this->_report->get_user($id);
		
		$data 	= $this->_report->get_nasabah_kelolaan5($id, $m, $product, $tipe);
		#print_r($user);
		#print_r($data);





		#$sumdata = $this->_report->get_nasabah_sum_kelolaan4($id, $m, $tipe);
		$ket 	= ($m == 1)?'Last Month':'Yesterday';
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		switch ($tipe)
		{
			case 0:
				$cust_type = "CR";
				break;
			case 1:
				$cust_type = "BB";
				break;
		}
		
		
/*
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
*/
//ambil dari session
$npp = $this->session->userdata('ID');
//sales type ????
$name = $this->session->userdata('USER_NAME');
$sales_type = $this->session->userdata('SALES_TYPE');

		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."  <br />\n";
		$html 	.= "NAMA : ".$name." <br />\n";
		$html 	.= "SALES TYPE : ".$sales_type."<br />\n";
		$html   .= "CUST TYPE : ".$cust_type."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<div STYLE='height: auto; width: auto; font-size: 12px; overflow: auto;'>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil' rowspan ='2'>NO.</th>\n
						<th align='center' class='kecil' rowspan ='2'>TANGGAL</th>\n
						<th align='center' class='kecil' rowspan ='2'>CIF</th>\n
						<th align='center' class='kecil' rowspan ='2'>BRANCH</th>\n						
						<th align='center' class='kecil' rowspan ='2'>NAMA</th>\n
						<th align='center' class='kecil' rowspan ='2'>NASABAH</th>\n";
#print_r($data);
		if($product==1)
		{
			$html	.="<th align='center' class='kecil' colspan='5'>GIRO</th>\n";
		}
		if($product==2)
		{
			$html	.="<th align='center' class='kecil' colspan='5'>TABUNGAN</th>\n";
		}
		if($product==3)
		{
			$html	.="<th align='center' class='kecil' colspan='5'>DEPOSITO</th>\n";
		}
		if($product==4)
		{
			$html	.="<th align='center' class='kecil' colspan='4'>INVESTASI</th>\n";
		}
		if($product==5)
		{
			$html	.="<th align='center' class='kecil' colspan='4'>BANCAS</th>\n";
		}
		if($product==6)
		{
			$html	.="<th align='center' class='kecil' colspan='4'>AUM</th>\n";
		}
		
		$html	.=	"<!--th align='center' class='kecil' rowspan ='2'>AKSI</th-->\n";
		
		if($product<=3)
		{
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n";
		}
		if($product==4)
		{
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>INVESTASI</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>&Delta; INVESTASI</th>\n
						</tr>\n";
		}
		if($product==5)
		{
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>BANCAS</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>&Delta; BANCAS</th>\n
						</tr>\n";
		}
		if($product==6)
		{
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>DPK ".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>INVESTASI</th>\n
						<th align='center' class='kecil'>BANCAS</th>\n
						<th align='center' class='kecil'>AUM</th>\n
						</tr>\n";
		}
		if($product==1)
		{
			$html	.="<th align='center' class='kecil'>&Delta; GIRO</th>\n";
		}
		if($product==2)
		{
			$html	.="<th align='center' class='kecil'>&Delta; TABUNGAN</th>\n";
		}
		if($product==3)
		{
			$html	.="<th align='center' class='kecil'>&Delta; DEPOSITO</th>\n";
		}				
		if($product<=3)
		{
		$html	.=		"<th align='center' class='kecil'>PIPELINE</th>\n
						<th align='center' class='kecil'>&Delta; PIPELINE</th>\n
					</tr>\n";
		}		
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
			#echo "<pre>"; print_r($data); die();
		if($data)
		{
		
			$sumtabungan = 0;
			$sumbaseline = 0;
			$sumdeltatabungan = 0;
			$sumrencana =0;
			$sumdeltarencana =0;
			foreach($data as $row)
			{
				//CR error
				//$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				//BB error				
				//$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH : $row->BRANCH_NAME;
				
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
				#$html .= "<td width='' align='center' class='kecil'><a href='#' class='popup' onclick='getActivity($i);getProduk($i);getNasabah($i)'>".$row->CIF_KEY."</a></td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CIF_KEY."</td> \n";
				$html .= "<input type='hidden' name='CF".$i."' id='CF".$i."' value='".$row->CIF_KEY."'>";
				//$html .= "<td width='' align='left' class='kecil'>".$row->BRANCH_NAME.' - '.$row->BRANCH."</td> \n";
				#$html .= "<td width='' align='left' class='kecil'>$branch</td> \n";
				$html .= "<td width='' align='left' class='kecil'>$branch2</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<input type='hidden' name='CN".$i."' id='CN".$i."' value='".$row->CUST_NAME."'>";
				$html .= "<td width='' align='left' class='kecil'>".$row->KET."</td> \n";
				if($product==1)
				{
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO_BASELINE,2,'.',',')."</td> \n";
					switch($row->STATUS_GIRO)
					{
						case 'LEAK':
						$html .= "<td width='' align='right' class='kecil' bgcolor='red'><font color='#FFF'>".number_format($row->DELTA_GIRO,2,'.',',')."</font></td> \n";
						break;
						case 'PAR':
						$html .= "<td width='' align='right' class='kecil' bgcolor='yellow'>".number_format($row->DELTA_GIRO,2,'.',',')."</td> \n";
						break;
						case 'RAISE':
						$html .= "<td width='' align='right' class='kecil' bgcolor='green'><font color='#FFF'>".number_format($row->DELTA_GIRO,2,'.',',')."</font></td> \n";
						break;
					}
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->RENCANA_GIRO,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_RENCANA_GIRO,2,'.',',')."</td> \n";
					$html .= "<input type='hidden' name='S".$i."' id='S".$i."' value='".$row->STATUS_GIRO."'>";
				}
				if($product==2)
				{
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN_BASELINE,2,'.',',')."</td> \n";
					switch($row->STATUS_TABUNGAN)
					{
						case 'LEAK':
						$html .= "<td width='' align='right' class='kecil' bgcolor='red'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
						break;
						case 'PAR':
						$html .= "<td width='' align='right' class='kecil' bgcolor='yellow'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</td> \n";
						break;
						case 'RAISE':
						$html .= "<td width='' align='right' class='kecil' bgcolor='green'><font color='#FFF'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</font></td> \n";
						break;
					}
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->RENCANA_TABUNGAN,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_RENCANA_TABUNGAN,2,'.',',')."</td> \n";
					$html .= "<input type='hidden' name='S".$i."' id='S".$i."' value='".$row->STATUS_TABUNGAN."'>";
				}
				if($product==3)
				{
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO_BASELINE,2,'.',',')."</td> \n";
					switch($row->STATUS_DEPOSITO)
					{
						case 'LEAK':
						$html .= "<td width='' align='right' class='kecil' bgcolor='red'><font color='#FFF'>".number_format($row->DELTA_DEPOSITO,2,'.',',')."</font></td> \n";
						break;
						case 'PAR':
						$html .= "<td width='' align='right' class='kecil' bgcolor='yellow'>".number_format($row->DELTA_DEPOSITO,2,'.',',')."</td> \n";
						break;
						case 'RAISE':
						$html .= "<td width='' align='right' class='kecil' bgcolor='green'><font color='#FFF'>".number_format($row->DELTA_DEPOSITO,2,'.',',')."</font></td> \n";
						break;
					}
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->RENCANA_DEPOSITO,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_RENCANA_DEPOSITO,2,'.',',')."</td> \n";
					$html .= "<input type='hidden' name='S".$i."' id='S".$i."' value='".$row->STATUS_DEPOSITO."'>";
				}
				if($product==4)
				{
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->INVESTASI,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->BASELINE_INVESTASI,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_INVESTASI,2,'.',',')."</td> \n";
				}
				if($product==5)
				{
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->BANCAS,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->BASELINE_BANCAS,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->BASELINE_BANCAS,2,'.',',')."</td> \n";
				}
				if($product==6)
				{
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->DPK,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->INVESTASI,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->BANCAS,2,'.',',')."</td> \n";
					$html .= "<td width='' align='right' class='kecil'>".number_format($row->AUM,2,'.',',')."</td> \n";
				}
/*
--------------------------------
*/				

				
				/*switch ($row->AKTIFITAS)
				{
					CASE 0:
					$html .= "<td width='' align='center' class='kecil'><button onclick='catat_agenda(".$i.")'>Aksi</button></td> \n";
					break;
				    CASE 1:
					$html .= "<td width='' align='center' class='kecil'><button onclick='catat_agenda(".$i.")' disabled>Aksi</button></td> \n";
				    break;
				}*/
				
				
				$html .= "</tr> \n";
				if($product==1)
				{
				$sumtabungan = $sumtabungan + $row->GIRO;
				$sumbaseline = $sumbaseline + $row->GIRO_BASELINE;
				$sumdeltatabungan = $sumdeltatabungan + $row->DELTA_GIRO;
				$sumrencana = $sumrencana + $row->RENCANA_GIRO;
				$sumdeltarencana = $sumdeltarencana + $row->DELTA_RENCANA_GIRO;
				}
				if($product==2)
				{
				$sumtabungan = $sumtabungan + $row->TABUNGAN;
				$sumbaseline = $sumbaseline + $row->TABUNGAN_BASELINE;
				$sumdeltatabungan = $sumdeltatabungan + $row->DELTA_TABUNGAN;
				$sumrencana = $sumrencana + $row->RENCANA_TABUNGAN;
				$sumdeltarencana = $sumdeltarencana + $row->DELTA_RENCANA_TABUNGAN;
				}
				if($product==3)
				{
				$sumtabungan = $sumtabungan + $row->DEPOSITO;
				$sumbaseline = $sumbaseline + $row->DEPOSITO_BASELINE;
				$sumdeltatabungan = $sumdeltatabungan + $row->DELTA_DEPOSITO;
				$sumrencana = $sumrencana + $row->RENCANA_DEPOSITO;
				$sumdeltarencana = $sumdeltarencana + $row->DELTA_RENCANA_DEPOSITO;
				}
				if($product==4)
				{
				$sumtabungan = $sumtabungan + $row->INVESTASI;
				$sumbaseline = $sumbaseline + $row->BASELINE_INVESTASI;
				$sumdeltarencana = $sumdeltarencana + $row->DELTA_INVESTASI;
				}
				if($product==5)
				{
				$sumtabungan = $sumtabungan + $row->BANCAS;
				$sumbaseline = $sumbaseline + $row->BASELINE_BANCAS;
				$sumdeltarencana = $sumdeltarencana + $row->DELTA_BANCAS;
				}
				if($product==6)
				{
				$sumtabungan = $sumtabungan + $row->DPK;
				$sumbaseline = $sumbaseline + $row->INVESTASI;
				$sumrencana = $sumrencana + $row->BANCAS;
				$sumdeltarencana = $sumdeltarencana + $row->AUM;
				}
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='17' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html 	.= "<tr  bgcolor='#66FF66'>\n";
		$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Total</span></td>\n";	
		
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumtabungan,2,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumbaseline,2,'.',',')."</b></td> \n";
				if($product<=3)
				{
					if($sumdeltatabungan < 0 )
					{
					$html .= "<td width='' align='right' class='kecil' bgcolor='red'><font color='#FFF'><b>".number_format($sumdeltatabungan,2,'.',',')."</b></font></td> \n";
					}
					if($sumdeltatabungan==0)
					{
					$html .= "<td width='' align='right' class='kecil' bgcolor='yellow'><b>".number_format($sumdeltatabungan,2,'.',',')."</b></td> \n";
					}
					if($sumdeltatabungan>0)
					{
					$html .= "<td width='' align='right' class='kecil' bgcolor='green'><font color='#FFF'><b>".number_format($sumdeltatabungan,2,'.',',')."</b></font></td> \n";
					}
				}
				if($product<=3||$product>=6)
				{
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumrencana,2,'.',',')."</b></td> \n";
				}
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumdeltarencana,2,'.',',')."</b></td> \n";
				//$html .= "<td width='' align='right' class='kecil'><b></b></td> \n";
/*---------------
*/		
		$html .= "</table> \n";
		$html .= "</div>";
		echo $html;
	}
	
	function get_nasabah_bm_dpk($id =0, $m=0 ,$tipe=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_nasabah_kelolaan4($id, $m, $tipe);
		#$ket 	= ($m == 1)?'Last Month':'Yesterday';
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		switch ($tipe)
		{
			case 0:
				$cust_type = "CR";
				break;
			case 1:
				$cust_type = "BB";
				break;
		}
		
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html   .= "CUST TYPE : ".$cust_type."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<div STYLE='height: auto; width: auto; font-size: 12px; overflow: auto;'>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil' rowspan ='2'>NO.</th>\n
						<th align='center' class='kecil' rowspan ='2'>TANGGAL</th>\n
						<th align='center' class='kecil' rowspan ='2'>CIF</th>\n
						<th align='center' class='kecil' rowspan ='2'>BRANCH</th>\n						
						<th align='center' class='kecil' rowspan ='2'>NAMA</th>\n
						<th align='center' class='kecil' rowspan ='2'>NASABAH</th>\n
						<th align='center' class='kecil' colspan='4'>GIRO</th>\n
						<th align='center' class='kecil' colspan='4'>TABUNGAN</th>\n
						<th align='center' class='kecil' colspan='4'>DEPOSITO</th>\n
						<th align='center' class='kecil' colspan='4'>DPK</th>\n
					</tr>\n";
					
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>STATUS</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CIF_KEY."</td> \n";
				//$html .= "<td width='' align='left' class='kecil'>".$row->BRANCH_NAME.' - '.$row->BRANCH."</td> \n";
				#$html .= "<td width='' align='left' class='kecil'>$branch</td> \n";
				$html .= "<td width='' align='left' class='kecil'>$branch2</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->KET."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_GIRO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_GIRO."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_TABUNGAN."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_DEPOSITO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_DEPOSITO."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DPK,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DPK_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_DPK,2,'.',',')."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->STATUS_DPK."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='17' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		$html .= "</div>";
		echo $html;
	}
	
	function get_nasabah_bb($id =0, $m=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_nasabah_kelolaan_bb($id, $m);
		#$ket 	= ($m == 1)?'Last Month':'Yesterday';
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}

		
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>TANGGAL</th>\n
						<th align='center' class='kecil'>CIF</th>\n
						<th align='left' class='kecil'>BRANCH</th>\n						
						<th align='left' class='kecil'>NAMA</th>\n
						<th align='right' class='kecil'>GIRO</th>\n
						<th align='right' class='kecil'>TABUNGAN</th>\n
						<th align='right' class='kecil'>DEPOSITO</th>\n
						<th align='right' class='kecil'>TOTAL DPK</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->BNI_CIF_KEY."</td> \n";
				//$html .= "<td width='' align='left' class='kecil'>".$row->BRANCH_NAME.' - '.$row->BRANCH."</td> \n";
				#$html .= "<td width='' align='left' class='kecil'>$branch</td> \n";
				$html .= "<td width='' align='left' class='kecil'>$branch2</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format(($row->GIRO+$row->TABUNGAN+$row->DEPOSITO),2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		echo $html;
	}
	
	function get_nasabah_bb1($id =0, $m=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_nasabah_kelolaan_bb($id, $m);
		#$ket 	= ($m == 1)?'Last Month':'Yesterday';
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}

		
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<div STYLE='height: auto; width: auto; font-size: 12px; overflow: auto;'>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil' rowspan ='2'>NO.</th>\n
						<th align='center' class='kecil' rowspan ='2'>TANGGAL</th>\n
						<th align='center' class='kecil' rowspan ='2'>CIF</th>\n
						<th align='center' class='kecil' rowspan ='2'>BRANCH</th>\n						
						<th align='center' class='kecil' rowspan ='2'>NAMA</th>\n
						<th align='center' class='kecil' rowspan ='2'>NASABAH</th>\n
						<th align='center' class='kecil' colspan='3'>GIRO</th>\n
						<th align='center' class='kecil' colspan='3'>TABUNGAN</th>\n
						<th align='center' class='kecil' colspan='3'>DEPOSITO</th>\n
						<th align='center' class='kecil' colspan='3'>DPK</th>\n
					</tr>\n";
					
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
						<th align='center' class='kecil'>".strtoupper($ket)."</th>\n
						<th align='center' class='kecil'>BASELINE</th>\n
						<th align='center' class='kecil'>DELTA</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$branch = (isset ($row->BRANCH_NAME))?$row->BRANCH_NAME.':'.$row->BRANCH:$row->BRANCH;
				$branch2 = (isset ($row->OPEN_BRANCH))?$row->OPEN_BRANCH:$row->BRANCH;
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->CIF_KEY."</td> \n";
				//$html .= "<td width='' align='left' class='kecil'>".$row->BRANCH_NAME.' - '.$row->BRANCH."</td> \n";
				#$html .= "<td width='' align='left' class='kecil'>$branch</td> \n";
				$html .= "<td width='' align='left' class='kecil'>$branch2</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->KET."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->GIRO_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_GIRO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->TABUNGAN_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_TABUNGAN,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DEPOSITO_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_DEPOSITO,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DPK,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DPK_BASELINE,2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->DELTA_DPK,2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='18' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		$html .= "</div>";
		echo $html;
	}
	
	// create report in excel
	function xls_nasabah($id = 0, $m = 0)
	{
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPER VISOR', 'SUPERVISOR');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		
		$user 			= $this->_report->get_user($id);
		$dbdata 		= $this->_report->get_neo_nasabah_kelolaan($id, $m);		
		$fields 		= array('AS_OF_DATE','BNI_CIF_KEY','BRANCH','CUST_NAME','GIRO','TABUNGAN','DEPOSITO','DPK');
		$header 		= array('TANGGAL','CIF','CABANG','NASABAH','GIRO','TABUNGAN','DEPOSITO','DPK');
		$number_format	= array(0,0,0,0,1,1,1,1);
		$addition		= array('Report'=>'NASABAH KELOLAAN '.strtoupper($ket),'Npp'=>'['.$user[0]->ID.']','Nama'=>$user[0]->USER_NAME,'Sales'=>$user[0]->SALES_TYPE);
		$title 			= 'Nasabah Kelolaan';
		$file_name 		= 'nasabah_keloaan_'.$id.'.xls';
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
	}
	
	
	###### REPORT ELO #####
	#-------------------------------------
	# 	Report Nasabah kelolaan
	#-------------------------------------	
	function konsumer()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
	
		$this->load->view('report/konsumer');
	}
	
	
	function get_nasabah_konsumer($id =0, $m=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_nasabah_konsumer($id, $m);
		#$ket 	= ($m == 1)?'Last Month':'Yesterday';
		
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
		}

		
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>TANGGAL</th>\n
						<th align='center' class='kecil'>APPREGNO</th>\n
						<th align='center' class='kecil'>GROUP NAME</th>\n
						<th align='center' class='kecil'>PRODUCT NAME</th>\n
						<th align='center' class='kecil'>CUST NAME</th>\n						
						<th align='left' class='kecil'>AMOUNT BOOKING</th>\n
						<th align='center' class='kecil'>TGL APPLY</th>\n
						<th align='center' class='kecil'>TGL APPROVE</th>\n
						<th align='center' class='kecil'>TGL BOOKING</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->AS_OF_DATE."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row->APP_REGNO."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->GROUPNAME."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->PRODUCTNAME."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->CUST_NAME."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row->AMOUNT,2,'.',',')."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->APPLY_DATE."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->APPROVE_DATE."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row->BOOKING_DATE."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='10' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		echo $html;
	}
	
	// create report in excel
	function xls_nasabah_konsumer($id = 0, $m = 0)
	{
		switch ($m) 
		{
			case 0:
				$ket = "Yesterday";
				break;
			case 1:
				$ket = "Last Month";
				break;
			case 2:
				$ket = "Yesterday (Flagging)";
				break;
			case 3:
				$ket = "Last Month (Flagging)";
				break;
		}
		
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPER VISOR', 'SUPERVISOR');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		
		$user 			= $this->_report->get_user($id);
		$dbdata 		= $this->_report->get_neo_nasabah_kelolaan($id, $m);		
		$fields 		= array('AS_OF_DATE','BNI_CIF_KEY','BRANCH','CUST_NAME','GIRO','TABUNGAN','DEPOSITO','DPK');
		$header 		= array('TANGGAL','CIF','CABANG','NASABAH','GIRO','TABUNGAN','DEPOSITO','DPK');
		$number_format	= array(0,0,0,0,1,1,1,1);
		$addition		= array('Report'=>'NASABAH KELOLAAN '.strtoupper($ket),'Npp'=>'['.$user[0]->ID.']','Nama'=>$user[0]->USER_NAME,'Sales'=>$user[0]->SALES_TYPE);
		$title 			= 'Nasabah Kelolaan';
		$file_name 		= 'nasabah_keloaan_'.$id.'.xls';
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
	}
	## END #####
	
	#-------------------------------------
	# 	Report Nasabah kelolaan Cabang
	#-------------------------------------	
	function nasabah_cab()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = $_SESSION['BRANCH_ID'];
		$arrlvl = array('SALES', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		$data['penyelia'] = $this->get_penyelia($cab);
		$data['sales_penyelia'] = $this->_report->get_sales_penyelia('All', $cab);
		$this->load->view('report/nasabah_cab', $data);
	}
	
	function konsumer_cab()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = $_SESSION['BRANCH_ID'];
		$arrlvl = array('SALES', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		$data['penyelia'] = $this->get_penyelia($cab);
		$data['sales_penyelia'] = $this->_report->get_sales_penyelia('All', $cab);
		$this->load->view('report/konsumer_cab', $data);
	}
	
	#-------------------------------------
	# 	Report Nasabah kelolaan Cabang
	#-------------------------------------	
	function performance_cab2()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = $_SESSION['BRANCH_ID'];
		$arrlvl = array('SALES', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		$data['penyelia'] = $this->get_penyelia($cab);
		$data['sales_penyelia'] = $this->_report->get_sales_penyelia('All', $cab);
		$this->load->view('report/performance_cab', $data);
	}
	
	function get_penyelia($cab)
	{
		
		$data = $this->_report->get_penyelia($cab);
		#echo "<pre>"; print_r($data); die();
		#return $html = form_dropdown('PENYELIA', $data, 'All', "id='PENYELIA' onChange='get_sales()'");
		return $data;
	}
	
	function get_sales_penyelia($penyelia, $cab)
	{
		$data = $this->_report->get_sales_penyelia($penyelia, $cab);
		#echo form_dropdown('SALES', $data, "id='ID'");
		return $data;
	}
	
	function get_sales_ajax($penyelia, $cab)
	{
		$data = $this->_report->get_sales_penyelia($penyelia, $cab);
		echo form_dropdown('SALES', array('Pilih Sales',$data),'', "id='ID' onChange='get_salestype()'");
	}
	
	function get_salestype_ajax($salesid)
	{
		$data = $this->_report->get_salestype($salesid);
		foreach($data as $row)
		{
		echo "<input type='hidden' name='salestypeid' id='salestypeid' value='$row->SALES_TYPE'>";
		}
	}
	
	function new_customer()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		$this->load->view('report/new_customer');
	}
	
	function get_new_customer($id =0, $m=0, $y=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_new_customer($id, $m, $y);
		$data2 	= $this->_report->get_new_customer_nosegmen($id, $m, $y);
		$ket 	= ($m != 0)?date('F Y', strtotime("01-$m-$y")):'';
		
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "<b>NOC Sesuai Segmen</b>\n";
		$html   .= "\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>CIF</th>\n												
						<th align='left' class='kecil'>NAMA</th>\n
						<th align='left' class='kecil'>TGL BUKA CIF</th>\n
						<th align='right' class='kecil'>JML REKENING</th>\n
						<th align='right' class='kecil'>AVG</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$product = array(1=>'GIRO', 2=>'TABUNGAN', 3=>'DEPOSITO');
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row['BNI_CIF_KEY']."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row['CUST_NAME']."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".date('d M Y', strtotime($row['OPEN_CIF_DATE']))."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row['JML_REK']."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row['AVG_BOOK_BAL'],2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		$html .= "<br>";
		
		//tambahan
		
		$html   .= "\n";
		$html   .= "<b>NOC belum sesuai segmen</b>\n";
		$html   .= "\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>CIF</th>\n												
						<th align='left' class='kecil'>NAMA</th>\n
						<th align='left' class='kecil'>TGL BUKA CIF</th>\n
						<th align='right' class='kecil'>JML REKENING</th>\n
						<th align='right' class='kecil'>AVG</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data2)
		{
			foreach($data2 as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$product = array(1=>'GIRO', 2=>'TABUNGAN', 3=>'DEPOSITO');
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row['BNI_CIF_KEY']."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row['CUST_NAME']."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".date('d M Y', strtotime($row['OPEN_CIF_DATE']))."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row['JML_REK']."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row['AVG_BOOK_BAL'],2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		
		echo $html;
	}
	
	// create report in excel
	function xls_new_customer($id = 0, $m = 0, $y=0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPER VISOR', 'SUPERVISOR');
		$ket 	= ($m != 0)?date('F Y', strtotime("01-$m-$y")):'';
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		
		$user 			= $this->_report->get_user($id);
		$dbdata 		= $this->_report->get_new_customer($id, $m, $y);		
		$fields 		= array('BNI_CIF_KEY','CUST_NAME','OPEN_CIF_DATE','JML_REK','AVG_BOOK_BAL');
		$header 		= array('CIF','NASABAH','TGL BUKA CIF','JML REKENING','AVG');
		$number_format	= array(0,0,0,0,1,1);
		$addition		= array('Report'=>'NEW CUSTOMER','Npp'=>$user[0]->ID,'Nama'=>$user[0]->USER_NAME,'Sales'=>$user[0]->SALES_TYPE, 'Periode'=>$ket);
		$title 			= 'NEW CUSTOMER';
		$file_name 		= 'new_customer_segmen_'.$id.'.xls';
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
	}
	
	function new_account()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		$this->load->view('report/new_account');
	}
	
	function get_new_account($id =0, $m=0, $y=0)
	{
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_new_account($id, $m, $y);
		$data2 	= $this->_report->get_new_account_nosegmen($id, $m, $y);
		$ket 	= ($m != 0)?date('F Y', strtotime("01-$m-$y")):'';
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($ket)."<br /><br />\n";
		$html   .= "\n";
		$html   .= "<b>NOA Sesuai Segmen</b>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>CIF</th>\n													
						<th align='left' class='kecil'>NAMA</th>\n
						<th align='left' class='kecil'>ACCOUNT NO</th>\n
						<th align='left' class='kecil'>TGL BUKA REK</th>\n
						<th align='left' class='kecil'>TGL BUKA CIF</th>\n
						<th align='right' class='kecil'>CUR</th>\n
						<th align='right' class='kecil'>AVG</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$product = array(1=>'GIRO', 2=>'TABUNGAN', 3=>'DEPOSITO');
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row['BNI_CIF_KEY']."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row['CUST_NAME']."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row['ID_NUMBER']."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".date('d M Y', strtotime($row['OPEN_DATE']))."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".date('d M Y', strtotime($row['OPEN_CIF_DATE']))."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row['CUR_BOOK_BAL'],2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row['AVG_BOOK_BAL'],2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		$html   .= "<br>";
		$html   .= "\n";
		$html   .= "<b>NOA belum sesuai segmen</b>";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>CIF</th>\n													
						<th align='left' class='kecil'>NAMA</th>\n
						<th align='left' class='kecil'>ACCOUNT NO</th>\n
						<th align='left' class='kecil'>TGL BUKA REK</th>\n
						<th align='left' class='kecil'>TGL BUKA CIF</th>\n
						<th align='right' class='kecil'>CUR</th>\n
						<th align='right' class='kecil'>AVG</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data2)
		{
			foreach($data2 as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$product = array(1=>'GIRO', 2=>'TABUNGAN', 3=>'DEPOSITO');
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>".$i++."</td> \n";
				$html .= "<td width='' align='center' class='kecil'>".$row['BNI_CIF_KEY']."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row['CUST_NAME']."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".$row['ID_NUMBER']."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".date('d M Y', strtotime($row['OPEN_DATE']))."</td> \n";
				$html .= "<td width='' align='left' class='kecil'>".date('d M Y', strtotime($row['OPEN_CIF_DATE']))."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row['CUR_BOOK_BAL'],2,'.',',')."</td> \n";
				$html .= "<td width='' align='right' class='kecil'>".number_format($row['AVG_BOOK_BAL'],2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		
		echo $html;
	}
	
	// create report in excel
	function xls_new_account($id = 0, $m = 0, $y=0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPER VISOR', 'SUPERVISOR');
		$ket 	= ($m != 0)?date('F Y', strtotime("01-$m-$y")):'';
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		
		$user 			= $this->_report->get_user($id);
		$dbdata 		= $this->_report->get_new_account($id, $m, $y);		
		$fields 		= array('BNI_CIF_KEY','CUST_NAME','ID_NUMBER','OPEN_DATE','OPEN_CIF_DATE','CUR_BOOK_BAL','AVG_BOOK_BAL');
		$header 		= array('CIF','NASABAH','REKENING','TGL BUKA REK','TGL BUKA CIF','CUR','AVG');
		$number_format	= array(0,0,0,0,0,1,1);
		$addition		= array('Report'=>'NEW ACCOUNT','Npp'=>$user[0]->ID,'Nama'=>$user[0]->USER_NAME,'Sales'=>$user[0]->SALES_TYPE, 'Periode'=>$ket);
		$title 			= 'NEW ACCOUNT';
		$file_name 		= 'new_account_segmen_'.$id.'.xls';
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
	}
	
	#-------------------------------------
	# 	Report New Customer
	#-------------------------------------
	
	function new_customer_sup()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}	
		$data = $this->list_user();		
		$this->load->view('report/new_customer_sup', $data);		
*/	
echo"NOC Sales c->report/new_customer_sup";	
	}
	#-------------------------------------
	# 	Report New Account
	#-------------------------------------
	
	function new_account_sup()
	{
/*
	$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}	
		$data = $this->list_user();		
		$this->load->view('report/new_account_sup', $data);		
*/
echo"NOA Sales c->report/new_account_sup";
	}
	
	#-------------------------------------
	# 	Report Nasabah kelolaan per Cabang
	#-------------------------------------
	
	function nasabah_bm()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN' ,'BM');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}
		$data['getDataActivity'] = base_url().index_page()."/report/getDataActivity";
		$data['getDataProduk'] = base_url().index_page()."/report/getDataproduk";
		$data['getDataNasabah'] = base_url().index_page()."/report/getDataNasabah";		
		$this->load->view('report/nasabah_bm', $data);		
	}
	
	function nasabah_bm_sum()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN' ,'BM');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}
		$data['getDataActivity'] = base_url().index_page()."/report/getDataActivity";
		$data['getDataProduk'] = base_url().index_page()."/report/getDataproduk";
		$data['getDataNasabah'] = base_url().index_page()."/report/getDataNasabah";		
		$this->load->view('report/nasabah_bm_sum', $data);		
	}
	
	function nasabah_bm_sum_wil()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN' ,'BM');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}
		$data['getDataActivity'] = base_url().index_page()."/report/getDataActivity";
		$data['getDataProduk'] = base_url().index_page()."/report/getDataproduk";
		$data['getDataNasabah'] = base_url().index_page()."/report/getDataNasabah";		
		$this->load->view('report/nasabah_bm_sum_wil', $data);		
	}
	
	function nasabah_bm_sum_sln()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN' ,'BM');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}
		$data['getDataActivity'] = base_url().index_page()."/report/getDataActivity";
		$data['getDataProduk'] = base_url().index_page()."/report/getDataproduk";
		$data['getDataNasabah'] = base_url().index_page()."/report/getDataNasabah";		
		$this->load->view('report/nasabah_bm_sum_sln', $data);		
	}
	#-------------------------------------
	# 	Report Nasabah kelolaan per Cabang
	#-------------------------------------
	
	function nasabah_sup()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}	
		$data = $this->list_user();		
		$this->load->view('report/nasabah_sup', $data);		
	}
	
	#-------------------------------------
	# 	Report Nasabah Konsumtif per Cabang
	#-------------------------------------
	
	function konsumer_sup()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}	
		$data = $this->list_user();		
		$this->load->view('report/konsumer_sup', $data);		
*/
echo"Penj. krdt Konsumtif Sales c->report/konsumer_sup";		
	}
	
	// Report AUM per cabang
	
	function nasabah_sup_aum()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}	
		$data = $this->list_user();		
		$this->load->view('report/nasabah_sup_aum', $data);		
	}
	
	// Report AUM Cabang
	
	function nasabah_cab_aum()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = $_SESSION['BRANCH_ID'];
		$arrlvl = array('SALES', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		$data['penyelia'] = $this->get_penyelia($cab);
		$data['sales_penyelia'] = $this->_report->get_sales_penyelia('All', $cab);
		$this->load->view('report/nasabah_cab', $data);
	}
	
	// Report Konsumer Cabang
	
	function konsumer_cab_()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = $_SESSION['BRANCH_ID'];
		$arrlvl = array('SALES', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		$data['penyelia'] = $this->get_penyelia($cab);
		$data['sales_penyelia'] = $this->_report->get_sales_penyelia('All', $cab);
		$this->load->view('report/konsumer_cab', $data);
	}
	
	
	#-------------------------------------
	# 	Report Performance
	#-------------------------------------
	
	function performance()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/4');}
	
		$this->load->view('report/performance');
	}
	
	function performance_tunjangan()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/4');}
	
		$this->load->view('report/performance_tunjangan');
	}
	
	function nama_bulan($id=1)
	{
		$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
		return $bulan[$id];
	}
	
//===================================================================	

function get_news(){
//echo"HELLLLOOOOOO";
		$sql = "
				SELECT 
					SALES_ID, 
					MM, 
					YYYY, 
					SUM(REALISASI_TERBOBOT) PERFORMANCE
				FROM PERFORMANCE
				WHERE 
					SALES_ID = '27522'
					AND YYYY=2015
				GROUP BY SALES_ID,
					MM,
					YYYY
					ORDER BY MM ASC
				";
//$news = $this->db->query("SELECT * FROM NEWS WHERE IS_ACTIVE = 1 ORDER BY TANGGAL DESC ")->result();
$news = $this->db->query($sql)->result();
print_r($news);
/*
		$html 	=  "";

		
		$html 	.= "<table width='100%'  bgcolor='#cccccc' >\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
		
						<th align='center' class='kecil'>ID.</th>\n
						<th align='left' class='kecil'>JUDUL</th>\n
						<th align='center' class='kecil'>TANGGAL</th>\n
												
					</tr>\n";

foreach($news as $row){
	
	
	
					
		$html 	.= "<tr  bgcolor='#BBBBBB'>\n
			
						<th align='center' class='kecil'>$row->ID</th>\n
						<th align='left' class='kecil'>$row->JUDUL</th>\n
						<th align='center' class='kecil'>$row->TANGGAL</th>\n
						
					</tr>\n";
		
}
					

			$html	.="</table>";		
			
			
			echo $html;
*/

			
/*
*/	
	
}
	
//===================================================================	
	
	
	function get_performance($id =0, $m=0, $y = 0)
	{
		$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
		$user	= $this->_report->get_user($id);
		#---------------------------
		#	update perfomance
		#---------------------------
		#$this->_report->update_performance_sales($id);
		#$data 	= $this->_report->get_performance($id, $m, $y);
		$data 	= $this->_report->get_performa_sales($id, $m, $y);
		$usergrade	= $this->_report->get_user_grade($id,$m,$y);
		//$status = $this->_status->get_status_cek($id);
		#print_r($data); die();
		$salestypenew=$usergrade[0]->SALES_TYPE;
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
		//foreach ($status as $row)
		//{
			//$npp = $row->NPP;
			//$awal = $row->BLN_AWAL;
			//$akhir = $row->BLN_AKHIR;
			//$thnawal = $row->THN_AWAL;
			//$thnakhir = $row->THN_AKHIR;
			//$tglawal = $row->TGL_AWAL;
			//$tglakhir = $row->TGL_AKHIR;
		//}
		
		$status = $this->_status->get_status_cek1($id,$m,$y);
		foreach ($status as $row)
		{
			$npp = $row->NPP;
			$month = $row ->MONTH;
			$year = $row->YEAR;
			$tglawal = $row->START_DATE;
			$tglakhir = $row->END_DATE;
		}
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$salestypenew."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($bulan[$m])." ".$y."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='left' class='kecil'>KPI</th>\n
						<th align='center' class='kecil'>TYPE KPI</th>\n
						<th align='center' class='kecil'>BOBOT</th>\n						
						<th align='center' class='kecil'>REALISASI</th>\n
						<th align='center' class='kecil'>PERFORMANCE</th>\n						
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		
		#print_r($data); die();
		
		if($data)
		{
			if($id==$npp && $m==$month && $y == $year)
			{
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Anda terdaftar posisi Non Sales Sejak ".$tglawal." s/d ".$tglakhir."</span></td>\n";	
				$html .= "</tr>\n";
			}
			else
			{
			$fin =0; $bfin=0; $rfin=0;
			$kik=0; $bkik=0; $rkik=0;
			$x=1;
			$y=0;
			foreach($data as $row)
			{
				$cat   = ($row->BOBOT_CAT == 1)?'FINANCIAL':'KICKERS';
				$color = ($i%2)?"#ffffff":"#eeeeee";				
				
				if($row->BOBOT_CAT == 1)
				{ 
					$fin += $row->REALISASI_TERBOBOT;
					$rfin += $row->BOBOT_CAP;
					$bfin += $row->BOBOT;
					$xfin += $row->REALISASI;
				}
				else 
				{ 
					$kik += $row->REALISASI_TERBOBOT;
					$rkik += $row->BOBOT_CAP;
					$bkik += $row->BOBOT;
					$y++;
				}
				
				switch($row->IS_CAP)
				{
					case '0':
						$cap = 'NON CAP';
					break;
					case '1':
						$cap = 'CAP';
					break;
					case '2':
						$cap = 'KEY';
					break;
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
					$html .= "<td width='' align='center'>".$cap."</td> \n";
					$html .= "<td width='' align='center'>".$row->BOBOT."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI."%</td> \n";
					#$html .= "<td width='' align='center'>".$row->BOBOT_CAP."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI_TERBOBOT."%</td> \n";
					#$html .= "<td width='' align='left'  >".$cat."</td> \n";
					$html .= "</tr> \n";
				} else {				
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->BOBOT_NAME."</td> \n";
					$html .= "<td width='' align='center'>".$cap."</td> \n";
					$html .= "<td width='' align='center'>".$row->BOBOT."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI."%</td> \n";
					#$html .= "<td width='' align='center'>".$row->BOBOT_CAP."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI_TERBOBOT."%</td> \n";
					#$html .= "<td width='' align='left'  >".$cat."</td> \n";
					$html .= "</tr> \n";
				}
				if($row->BOBOT_CAT != 1) $x++;
			}
			
				$html .= "<tr bgcolor='#BBBBBB'>\n";
				$html .= "<td width='' align='center'>&nbsp;</td> \n";
				$html .= "<td width='' align='left'  ><b>TOTAL KPI</b></td> \n";
				#$html .= "<td width='' align='center'><b>".number_format(($bkik),2,'.',',')."%</b></td> \n";
				$html .= "<td width='' align='center'>&nbsp;</b></td> \n";
				$html .= "<td width='' align='center'><b>".round($bfin)."%</b></td> \n";
				#$html .= "<td width='' align='center'><b>".number_format(($xfin),1,'.',',')."%</b></td> \n";
				$html .= "<td width='' align='center'><b>".number_format(($rfin),1,'.',',')."%</b></td> \n";
				$html .= "<td width='' align='center'><b>".number_format(($fin),1,'.',',')."%</b></b></td> \n";
				#$html .= "<td width='' align='left'  ><b>$cat</b></td> \n";
				$html .= "</tr> \n";
			
		}} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		echo $html;
	}
	
//========================================================================	
	function get_performance_new($id =0, $m=0, $y = 0 )
	{

/*
		$data = $this->db->query("SELECT * FROM VW_CR_PERFORMANCE WHERE ROWNUM <= 10 ")->result();
		print_r($data);
*/			

		$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
//$user	= $this->_report->get_user($id);
		#---------------------------
		#	update perfomance
		#---------------------------
		#$this->_report->update_performance_sales($id);
		#$data 	= $this->_report->get_performance($id, $m, $y);
$data 	= $this->_report->get_performa_sales($id, $m, $y);
//$usergrade	= $this->_report->get_user_grade($id,$m,$y);
		//$status = $this->_status->get_status_cek($id);
		#print_r($data); die();
		
//$salestypenew=$usergrade[0]->SALES_TYPE;
		$npp = $this->session->userdata('ID');
		$sales = $this->session->userdata('USER_NAME');
		$salestypenew = $this->session->userdata('SALES_TYPE');
/*
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
*/		
		

		
//$status = $this->_status->get_status_cek1($id,$m,$y);
/*
		foreach ($status as $row)
		{
			$npp = $row->NPP;
			$month = $row ->MONTH;
			$year = $row->YEAR;
			$tglawal = $row->START_DATE;
			$tglakhir = $row->END_DATE;
		}
*/		
		
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$salestypenew."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($bulan[$m])." ".$y."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='left' class='kecil'>KPI</th>\n
						<th align='center' class='kecil'>TYPE KPI</th>\n
						<th align='center' class='kecil'>BOBOT</th>\n						
						<th align='center' class='kecil'>REALISASI</th>\n
						<th align='center' class='kecil'>PERFORMANCE</th>\n						
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		
		#print_r($data); die();
		if($data)
		{
/*
			if($id==$npp && $m==$month && $y == $year)
			{
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Anda terdaftar posisi Non Sales Sejak ".$tglawal." s/d ".$tglakhir."</span></td>\n";	
				$html .= "</tr>\n";
			}
			else
			{
*/		
			$fin =0; $bfin=0; $rfin=0;
			$kik=0; $bkik=0; $rkik=0;
			$x=1;
			$y=0;
			foreach($data as $row)
			{
				$cat   = ($row->BOBOT_CAT == 1)?'FINANCIAL':'KICKERS';
				$color = ($i%2)?"#ffffff":"#eeeeee";				
				
				if($row->BOBOT_CAT == 1)
				{ 
					$fin += $row->REALISASI_TERBOBOT;
					$rfin += $row->BOBOT_CAP;
					$bfin += $row->BOBOT;
					$rfin += $row->REALISASI;
				}
				else 
				{ 
					$kik += $row->REALISASI_TERBOBOT;
					$rkik += $row->BOBOT_CAP;
					$bkik += $row->BOBOT;
					$y++;
				}
				
				switch($row->IS_CAP)
				{
					case '0':
						$cap = 'NON CAP';
					break;
					case '1':
						$cap = 'CAP';
					break;
					case '2':
						$cap = 'KEY';
					break;
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
					$html .= "<td width='' align='center'>".$cap."</td> \n";
					$html .= "<td width='' align='center'>".$row->BOBOT."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI."%</td> \n";
					#$html .= "<td width='' align='center'>".$row->BOBOT_CAP."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI_TERBOBOT."%</td> \n";
					#$html .= "<td width='' align='left'  >".$cat."</td> \n";
					$html .= "</tr> \n";
				} else {				
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->BOBOT_NAME."</td> \n";
					$html .= "<td width='' align='center'>".$cap."</td> \n";
					$html .= "<td width='' align='center'>".$row->BOBOT."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI."%</td> \n";
					#$html .= "<td width='' align='center'>".$row->BOBOT_CAP."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI_TERBOBOT."%</td> \n";
					#$html .= "<td width='' align='left'  >".$cat."</td> \n";
					$html .= "</tr> \n";
				}
				if($row->BOBOT_CAT != 1) $x++;
			}
			
				$html .= "<tr bgcolor='#BBBBBB'>\n";
				$html .= "<td width='' align='center'>&nbsp;</td> \n";
				$html .= "<td width='' align='left'  ><b>TOTAL KPI</b></td> \n";
				#$html .= "<td width='' align='center'><b>".number_format(($bkik),2,'.',',')."%</b></td> \n";
				$html .= "<td width='' align='center'>&nbsp;</b></td> \n";
				$html .= "<td width='' align='center'><b>".round($bfin)."%</b></td> \n";
				#$html .= "<td width='' align='center'><b>".number_format(($xfin),1,'.',',')."%</b></td> \n";
				$html .= "<td width='' align='center'><b>".number_format(($rfin),1,'.',',')."%</b></td> \n";
				$html .= "<td width='' align='center'><b>".number_format(($fin),1,'.',',')."%</b></b></td> \n";
				#$html .= "<td width='' align='left'  ><b>$cat</b></td> \n";
				$html .= "</tr> \n";
/*
		}} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
*/			
		}
		
		$html .= "</table> \n";
		echo $html;	
/*
*/		


/*
$html 	=  "";
		$html 	.= "NPP : npp <br />\n";
		$html 	.= "NAMA : sales <br />\n";
		$html 	.= "SALES TYPE : salestypenew<br />\n";
		$html 	.= "PERIODE : MMMM YYYYY <br /><br />\n";

		
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report' border='1'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='center' class='kecil'>KPI</th>\n
						<th align='center' class='kecil'>TYPE KPI</th>\n
						<th align='center' class='kecil'>BOBOT</th>\n						
						<th align='center' class='kecil'>REALISASI</th>\n
						<th align='center' class='kecil'>REALISASI THRESHOLD</th>\n						
						<th align='center' class='kecil'>PERFORMANCE</th>\n
						<th align='center' class='kecil'>PERFORMANCE INSENTIF</th>\n						
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
//------------------------------------------------		
		$html 	.= "<tr  bgcolor='#ffffff'>\n";
					

		$html .= "<td width='' align='center'>1</td> \n";					
		$html .= "<td width='' align='center'>99%</td> \n";					
		$html .= "<td width='' align='center'>99%</td> \n";					
		$html .= "<td width='' align='center'>99%</td> \n";					
		$html .= "<td width='' align='center'>99%</td> \n";					
		$html .= "<td width='' align='center'>99%</td> \n";					
		$html .= "<td width='' align='center'>99%</td> \n";					
		$html .= "<td width='' align='center'>99%</td> \n";					

		$html 	.= "</tr'>\n";
		
//------------------------------------------------			
		$html .= "</table> \n";
		echo $html;		
*/
	
	
	}
//===========================	
	function get_performance_tunjangan_new($id =0, $m=0, $y = 0,$salestipe = 0)
{
/*
echo $id;
echo "<br>";
echo $m;
echo "<br>";
echo $y;
echo "<br>";
echo $salestipe;
*/		
		$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
		$user	= $this->_report->get_user($id);
		#print_r($user); die();
		#---------------------------
		#	update perfomance
		#---------------------------
		#$this->_report->update_performance_sales($id);
		#$data 	= $this->_report->get_performance($id, $m, $y);
			//$tipe=$user[0]->SALES_ID;
		$data 	= $this->_report->get_performa_sales_tunjangan($id, $m, $y,$salestipe);
/*
		print_r($data); die();
*/			
		
		if($user){
			$npp 	= $user[0]->ID;
			$sales 	= strtoupper($user[0]->USER_NAME);
			$name 	= $user[0]->SALES_TYPE;
		} else {
			$npp 	= '';
			$sales 	= '';
			$name 	= '';
		}
		
/*
		$status = $this->_status->get_status_cek1($id,$m,$y);
		print_r($status); die();
		foreach ($status as $row)
		{
			$npp = $row->NPP;
			$month = $row ->MONTH;
			$year = $row->YEAR;
			$tglawal = $row->START_DATE;
			$tglakhir = $row->END_DATE;
		}
		
*/
//----------manual
$npp = $_SESSION['ID'];
			$month = 1;
			$year = 2017;
			$tglawal = 1;
			$tglakhir = 20;
//-----------------
		$html 	=  "";
		$html 	.= "NPP : ".$npp."<br />\n";
		$html 	.= "NAMA : ".$sales."<br />\n";
		$html 	.= "SALES TYPE : ".$name."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($bulan[$m])." ".$y."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='left' class='kecil'>KPI</th>\n						
						<th align='center' class='kecil'>REALISASI</th>\n	
						<th align='center' class='kecil'>TARGET</th>\n
						<th align='center' class='kecil'>PENCAPAIAN</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		
		#print_r($data); die();
/*
*/		
		if($data)
		{
			if($id==$npp && $m==$month && $y == $year)
			{
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Anda terdaftar posisi Non Sales Sejak ".$tglawal." s/d ".$tglakhir."</span></td>\n";	
				$html .= "</tr>\n";
			}
			else
			{
			$fin =0; $bfin=0; $rfin=0; $tpfin =0;
			$kik=0; $bkik=0; $rkik=0;
			$x=1;
			$y=0;
			foreach($data as $row)
			{
				$cat   = ($row->BOBOT_CAT == 1)?'FINANCIAL':'KICKERS';
				$color = ($i%2)?"#ffffff":"#eeeeee";				
				
				if($row->BOBOT_CAT == 1)
				{ 
					$fin += $row->REALISASI_TERBOBOT;
					$rfin += $row->BOBOT_CAP;
					$bfin += $row->BOBOT;
					$xfin += $row->REALISASI;
					$tpfin += $row->PENCAPAIAN;
				}
				else 
				{ 
					$kik += $row->REALISASI_TERBOBOT;
					$rkik += $row->BOBOT_CAP;
					$bkik += $row->BOBOT;
					$tpfin += $row->PENCAPAIAN;
					$y++;
				}
				
				switch($row->IS_CAP)
				{
					case '0':
						$cap = 'NON CAP';
					break;
					case '1':
						$cap = 'CAP';
					break;
					case '2':
						$cap = 'KEY';
					break;
				}
				if($row->BOBOT_CAT != 1 && $x == 1){				
					#$html .= "<tr bgcolor='#BBBBBB'>\n";
					#$html .= "<td width='' align='center'>&nbsp;</td> \n";
					#$html .= "<td width='' align='left'  ><b>SUB KPI FINANCIAL</b></td> \n";
					#$html .= "<td width='' align='center'><b>$bfin%</b></td> \n";
					#$html .= "<td width='' align='center'><b>$rfin%</b></td> \n";
					#$html .= "<td width='' align='center'><b>".$fin."%</b></b></td> \n";
					#$html .= "<td width='' align='left'  ><b>FINANCIAL</b></td> \n";
					#$html .= "</tr> \n";
					
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->BOBOT_NAME."</td> \n";
					#$html .= "<td width='' align='center'>".$cap."</td> \n";
					#$html .= "<td width='' align='center'>".$row->BOBOT."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI."%</td> \n";
					$html .= "<td width='' align='center'>".$row->TARGET."%</td> \n";
					$html .= "<td width='' align='center'>".$row->PENCAPAIAN."%</td> \n";
					#$html .= "<td width='' align='left'  >".$cat."</td> \n";
					$html .= "</tr> \n";
				} else {				
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->BOBOT_NAME."</td> \n";
					#$html .= "<td width='' align='center'>".$cap."</td> \n";
					#$html .= "<td width='' align='center'>".$row->BOBOT."%</td> \n";
					$html .= "<td width='' align='center'>".$row->REALISASI."%</td> \n";
					$html .= "<td width='' align='center'>".$row->TARGET."%</td> \n";
					$html .= "<td width='' align='center'>".$row->PENCAPAIAN."%</td> \n";
					##$html .= "<td width='' align='left'  >".$cat."</td> \n";
					$html .= "</tr> \n";
				}
				if($row->BOBOT_CAT != 1) $x++;
			}
			
				$html .= "<tr bgcolor='#BBBBBB'>\n";
				$html .= "<td width='' align='center'>&nbsp;</td> \n";
				$html .= "<td width='' align='left'  ><b>TOTAL KPI</b></td> \n";
				#$html .= "<td width='' align='center'><b>".number_format(($bkik),2,'.',',')."%</b></td> \n";
				$html .= "<td width='' align='center'>&nbsp;</b></td> \n";
				$html .= "<td width='' align='center'>&nbsp;</b></td> \n";
				$html .= "<td width='' align='center'><b>".round($tpfin)."%</b></td> \n";
				#$html .= "<td width='' align='center'><b>".number_format(($xfin),1,'.',',')."%</b></td> \n";
				#$html .= "<td width='' align='center'><b>".number_format(($rfin),1,'.',',')."%</b></td> \n";
				#$html .= "<td width='' align='center'><b>".number_format(($fin),1,'.',',')."%</b></b></td> \n";
				#$html .= "<td width='' align='left'  ><b>$cat</b></td> \n";
				$html .= "</tr> \n";
			
		}} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		
		$html .= "</table> \n";
		echo $html;


		

}
	
	// create report in excel
	function xls_performance_lama($id = 0, $m = 0, $y=0)
//	function xls_performance_lama()
	{
//		$id =16622 ; 
	//	$m = 1; 
		//$y=2017;
		//echo "apa";die();
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/4');}
	
		$data['month']	= $m;
		$data['year']	= $y;
		$data['user']	= $this->_report->get_user($id);
		$data['data'] 	= $this->_report->get_performance($id, $m, $y);
		#print_r($data);die();
		$this->load->view('report/xls_performance', $data);
	}
	
	
	function xls_performance($id = 0, $m = 0, $y=0)
//	function xls_performance()
	{
		
/*
		$id = '16622'; 
		$m = '1'; 
		$y='2016';
*/		
		
//		$tgl = date('d-M-Y', strtotime($date));
		$tgl = date('d-M-Y');
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPER VISOR', 'SUPERVISOR','SLN','CABANG','WILAYAH','PIMPINAN_CABANG','PIMPINAN_WILAYAH');		
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		
		$bln = $this->nama_bulan($m);
		$ket = "($bln $y)";
		
		$status = $this->_status->get_status_cek($id);
		foreach ($status as $row)
		{
			$npp = $row->NPP;
			$awal = $row->BLN_AWAL;
			$akhir = $row->BLN_AKHIR;
			$thnawal = $row->THN_AWAL;
			$thnakhir = $row->THN_AKHIR;
			$tglawal = $row->TGL_AWAL;
			$tglakhir = $row->TGL_AKHIR;
		}
*/		
		
/*
		if($id==$npp && $m >= $awal && $m <= $akhir && $y >= $thnawal && $y <= $thnakhir)
		{		
		echo "Terdaftar Sebagai Posisi Non Sales";
		}
		else
		{
*/			
		$dbdata 		= $this->_report->get_performa_sales($id, $m, $y, 1);		
		$fields 		= array('BOBOT_NAME','BOBOT','REALISASI','REALISASI_TERBOBOT');
		$header 		= array('KPI','BOBOT KPI','REALISASI','PERFORMANCE');
		$number_format	= array(0,1,1,1,1);
		$user 			= $this->_report->get_user($id);
		//$addition		= array('REPORT'=>'PERFORMANCE '.strtoupper($ket),'NPP'=>'['.$user[0]->ID.']','NAMA'=>$user[0]->USER_NAME,'SALES'=>$user[0]->SALES_TYPE);
		$addition		= array('REPORT'=>'PERFORMANCE ','NPP'=>'16622','NAMA'=>'XXXX','SALES'=>'XXXXX');

		$title 			= 'PERFORMANCE';
		$file_name 		= 'performance_sales'.$tgl.'.xls';
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
		
		//}
		
	}
	
	
	#-------------------------------------
	# 	Report Nasabah kelolaan per Cabang
	#-------------------------------------
	
	function performance_sup()
	{
	$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}
		
		$data = $this->list_user();	
		
		$this->load->view('report/performance_sup', $data);		
/*
echo"Performa Sales c->report/performance_sup";
*/
	}
	
	function performance_sup_tunjangan()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}
		
		$data = $this->list_user();	
		
		$this->load->view('report/performance_sup_tunjangan', $data);		
*/
echo"Tunjangan Performance (report/performance_sup_tunjangan)";
	}
	
	#-------------------------------------
	# 	Report Incentive
	#-------------------------------------
	
	function incentive()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/5');}
		
		$data['cabang'] = $this->_report->get_cabang();
		$this->load->view('report/incentive', $data);
	}
	
	function get_incentive($id =0, $m=0, $y = 0)
	{
		$bulan = array(	'1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April',
                                        '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus',
                                        '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');
		$result	= $this->_report->get_cabang_detail($id);
		$data 	= $this->_report->get_incentive($id, $m, $y);
		
		if($result){
			$cabang = $result[0]->BRANCH_NAME;
		} else {
			$cabang = '';
		}
		
		$html 	=  "";
		$html 	.= "CABANG : ".$cabang."<br />\n";
		$html 	.= "PERIODE : ".strtoupper($bulan[$m])." ".$y."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' >NO.</th>\n
						<th align='left'   >BRANCH</th>\n
						<th align='center' >NPP</th>\n
						<th align='left' >NAMA SALES</th>\n
						<th align='center' >PERFORMANCE</th>\n
						<th align='left'   >CATEGORY</th>\n
						<th align='center'   >% INCENTIVE</th>\n
						<th align='right'   >NOMINAL</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data)
		{
			foreach($data as $row)
			{
				$prfmc = '';
				$prfmc = ($row->BOBOT_PCT > 129)?130:$row->BOBOT_PCT;
				$cat   = ($row->BOBOT_CAT == 1)?'FINANCIAL':'KICKERS';
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "<td width='' align='center'	>".$i++."</td> \n";
				$html .= "<td width='' align='left'  	>".$row->CABANG."</td> \n";
				$html .= "<td width='' align='left'		>".$row->SALES_ID."</td> \n";
				$html .= "<td width='' align='left'		>".$row->NAMA."</td> \n";
				//$html .= "<td width='' align='center'	>".$row->BOBOT_PCT."%</td> \n";
				$html .= "<td width='' align='center'	>".$prfmc."%</td> \n";

				$html .= "<td width='' align='left'	>".$cat."</td> \n";
				$html .= "<td width='' align='center'  	>".$row->PCT_INCENTIVE."%</td> \n";
				$html .= "<td width='' align='right' 	>".number_format($row->NOMINAL,2,'.',',')."</td> \n";
				$html .= "</tr> \n";
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='8' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table> \n";
		echo $html;
	}
	
	// create report in excel
	function xls_incentive($id = 0, $m = 0, $y=0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/5');}
		
		$data['month']	= $m;
		$data['year']	= $y;
		$result			= $this->_report->get_cabang_detail($id);
		$data['cabang']	= $result[0]->BRANCH_NAME;
		$data['data'] 	= $this->_report->get_incentive($id, $m, $y);
		#print_r($data);die();
		$this->load->view('report/xls_incentive', $data);
	}
	
	#-------------------------------------------
	#	Report Daily Customer
	#-------------------------------------------
	function cust_daily()
	{
/*
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data = $this->list_user();	
		$data['type'] = 2;
		$this->load->view('report/cust_daily', $data);
*/
echo"Aktivasi per Nasabah c->report/cust_daily";		
	}
	
	// ajax report
	function get_cust_daily($id = 0, $start = NOW, $end = NOW)
	{
		$user			= $this->_report->get_user($id);
		//get data activity by npp
		$data 	= $this->_report->get_daily_cust($id, $start, $end);
		
		$html 	=  "";
		$html 	.= "NPP : ".$user[0]->ID."<br />\n";
		$html 	.= "NAMA : ".strtoupper($user[0]->USER_NAME)."<br />\n";
		$html 	.= "SALES TYPE : ".$user[0]->SALES_TYPE."<br />\n";
		$html 	.= "PERIODE : ".$start." s/d ".$end."<br /><br />\n";
		$html 	.= "<br />\n";
		$html 	.= "<b>LEGEND ACTIVITY :</b><br />\n";
		$html 	.= "<table width='70%' cellpadding='10' cellspacing='0' class='tbl_report'>\n";
		$html 	.= "	<tr><td>1. Kontak Nasabah lama</td>
							<td>5. Melakukan Presentasi</td><tr>\n
						
						<tr><td>2. Kontak Calon Nasabah</td>
							<td>6. Mendapatkan Penjualan</td><tr>\n
						
						<tr><td>3. Mendapatkan janji pertemuan</td>
						<td>7. Mendapatkan Referensi Baik</td><tr>\n
						
						<tr><td>4. Menggali Kebutuhan Nasabah</td>
						<td>8. Melakukan Pelayanan Nasabah</td></tr>\n";
		$html 	.= "</table>\n";
		$html 	.= "<br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#777777' class='tbl_report'>\n";
		$html	.= "<tr  bgcolor='#A5D3FA'><th align='center' rowspan=2>No.</th>\n<th  rowspan=2>Customer</th>\n<td colspan=8 align='center'>Activity</td></tr>";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						
						
						<th align='center'>1</th>\n
						<th align='center'>2</th>\n
						<th align='center'>3</th>\n
						<th align='center'>4</th>\n
						<th align='center'>5</th>\n
						<th align='center'>6</th>\n
						<th align='center'>7</th>\n
						<th align='center'>8</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$act1 = ($row->ACT1==0)?'':$row->ACT1;
				$act2 = ($row->ACT2==0)?'':$row->ACT2;
				$act3 = ($row->ACT3==0)?'':$row->ACT3;
				$act4 = ($row->ACT4==0)?'':$row->ACT4;
				$act5 = ($row->ACT5==0)?'':$row->ACT5;
				$act6 = ($row->ACT6==0)?'':$row->ACT6;
				$act7 = ($row->ACT7==0)?'':$row->ACT7;
				$act8 = ($row->ACT8==0)?'':$row->ACT8;
				
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->CUST_NAME."</td>\n";
				$html .= "	<td align='center'>".$act1."</td>\n";
				$html .= "	<td align='center'>".$act2."</td>\n";
				$html .= "	<td align='center'>".$act3."</td>\n";
				$html .= "	<td align='center'>".$act4."</td>\n";
				$html .= "	<td align='center'>".$act5."</td>\n";
				$html .= "	<td align='center'>".$act6."</td>\n";
				$html .= "	<td align='center'>".$act7."</td>\n";
				$html .= "	<td align='center'>".$act8."</td>\n";
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada akitivitas</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	
	// create report in excel
	function xls_cust_daily($id = 0, $start = NOW, $end = NOW)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['user']	= $this->_report->get_user($id);
		$data['start']	= $start;
		$data['end']	= $end;
		$data['data'] 	= $this->_report->get_daily_cust($id, $start, $end);
		$this->load->view('report/xls_cust_daily', $data);
	}
	
	#-------------------------------------------
	#	Report Planing Daily Customer
	#-------------------------------------------
	function cust_planning_daily()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		$data = $this->list_user();	
		$data['type'] = 2;
		$this->load->view('report/planning_cust', $data);
	}
	
	// ajax report
	function get_planning_cust($id = 0, $start = NOW, $end = NOW)
	{
		$user			= $this->_report->get_user($id);
		//get data activity by npp
		$data 	= $this->_report->get_planning_cust($id, $start, $end);
		
		$html 	=  "";
		$html 	.= "NPP : ".$user[0]->ID."<br />\n";
		$html 	.= "NAMA : ".strtoupper($user[0]->USER_NAME)."<br />\n";
		$html 	.= "SALES TYPE : ".$user[0]->SALES_TYPE."<br />\n";
		$html 	.= "PERIODE : ".$start." s/d ".$end."<br /><br />\n";
		$html 	.= "<br />\n";
		$html 	.= "<b>LEGEND ACTIVITY :</b><br />\n";
		$html 	.= "<table width='70%' cellpadding='10' cellspacing='0' class='tbl_report'>\n";
		$html 	.= "	<tr><td>1. Kontak Nasabah lama</td>
							<td>5. Melakukan Presentasi</td><tr>\n
						
						<tr><td>2. Kontak Calon Nasabah</td>
							<td>6. Mendapatkan Penjualan</td><tr>\n
						
						<tr><td>3. Mendapatkan janji pertemuan</td>
						<td>7. Mendapatkan Referensi Baik</td><tr>\n
						
						<tr><td>4. Menggali Kebutuhan Nasabah</td>
						<td>8. Melakukan Pelayanan Nasabah</td></tr>\n";
		$html 	.= "</table>\n";
		$html 	.= "<br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#777777' class='tbl_report'>\n";
		$html	.= "<tr  bgcolor='#A5D3FA'><th align='center' rowspan=2>No.</th>\n<th  rowspan=2>Customer</th>\n<td colspan=8 align='center'>Activity</td></tr>";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>1</th>\n
						<th align='center'>2</th>\n
						<th align='center'>3</th>\n
						<th align='center'>4</th>\n
						<th align='center'>5</th>\n
						<th align='center'>6</th>\n
						<th align='center'>7</th>\n
						<th align='center'>8</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->CUST_NAME."</td>\n";
				$html .= "	<td align='center'>".$row->ACT1."</td>\n";
				$html .= "	<td align='center'>".$row->ACT2."</td>\n";
				$html .= "	<td align='center'>".$row->ACT3."</td>\n";
				$html .= "	<td align='center'>".$row->ACT4."</td>\n";
				$html .= "	<td align='center'>".$row->ACT5."</td>\n";
				$html .= "	<td align='center'>".$row->ACT6."</td>\n";
				$html .= "	<td align='center'>".$row->ACT7."</td>\n";
				$html .= "	<td align='center'>".$row->ACT8."</td>\n";
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='10' align='center'><span style='color:#c00'>Tidak ada akitivitas</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	
	// create report in excel
	function xls_planning_cust($id = 0, $start = NOW, $end = NOW)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['user']	= $this->_report->get_user($id);
		$data['start']	= $start;
		$data['end']	= $end;
		$data['data'] 	= $this->_report->get_planning_cust($id, $start, $end);
		$this->load->view('report/xls_planning', $data);
	}
	
	
	#-------------------------------------------
	#	Report Kriteria Bisnis
	#-------------------------------------------
	function kriteria_bisnis()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['type'] = 2;
		$data['segment']	= $this->_report->get_segment();
		$this->load->view('report/kriteria', $data);
	}
	
	// ajax report
	function get_kriteria_bisnis($cat)
	{
		#$user	= $this->_report->get_user($id);
		//get data activity by npp
		$id = $this->session->userdata('ID');
		$segment = $this->_report->get_segment();
		$n=1;
		$arr_cat = array();
		foreach($segment as $row)
		{
			$arr_cat[$n++] = $row->SEGMENT;
		}
		$user	= $this->_report->get_user($id);
		$data 	= $this->_report->get_kriteria($id, $arr_cat[$cat]);
		$tgl	= date('d F Y');
		$html 	=  "";
		$html 	.= "NPP : ".$user[0]->ID."<br />\n";
		$html 	.= "NAMA : ".strtoupper($user[0]->USER_NAME)."<br />\n";
		$html 	.= "SALES TYPE : ".$user[0]->SALES_TYPE."<br />\n";
		$html 	.=  "BISNIS KRITERIA : ".$arr_cat[$cat]."<br />";
		$html 	.= "PERIODE : ".$tgl."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>Nama Perusahaan</th>\n
						<th align='center'>Kriteria</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td>".$row->COMPANY_NAME."</td>\n";
				$html .= "	<td align='center'>".$row->SEGMENT."</td>\n";
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
					$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Data tidak ada</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	
	// create report in excel
	function xls_kriteria_bisnis($cat)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$segment = $this->_report->get_segment();
		$n=1;
		$arr_cat = array();
		foreach($segment as $row)
		{
			$arr_cat[$n++] = $row->SEGMENT;
		}
		$id = $this->session->userdata('ID');
		$data['user']	= $this->_report->get_user($id);
		$data['data'] 	= $this->_report->get_kriteria($id, $arr_cat[$cat]);
		
		$this->load->view('report/xls_kriteria', $data);
	}
	
	#-------------------------------------
	# 	Report Other Product
	#-------------------------------------	
	function other_product()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		$data = $this->list_user();	
		
		$data['type'] = 0;
		$this->load->view('report/other_product', $data);
	}
	
	// ajax report
	function get_other_product($id=0)
	{
		#$id		= $this->session->userdata('ID');
		$user	= $this->_report->get_user($id);
		//get data activity by npp
		$data 	= $this->_report->get_other($id);
		
		$html 	=  "";
		$html 	.= "NPP : ".$user[0]->ID."<br />\n";
		$html 	.= "NAMA : ".strtoupper($user[0]->USER_NAME)."<br />\n";
		$html 	.= "SALES TYPE : ".$user[0]->SALES_TYPE."<br />\n";
		#$html 	.= "PERIODE : ".$start." s/d ".$end."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th>Nama Product Lain</th>\n
						<th align='center'>Jumlah</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";
				$html .= "	<td align='left'>".$row->PRODUCT."</td>\n";
				$html .= "	<td align='center'>".$row->JUMLAH."</td>\n";
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='5' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	
	// create report in excel
	function xls_other_product($id=0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['user']	= $this->_report->get_user($id);
		$data['data'] 	= $this->_report->get_other($id);
		$this->load->view('report/xls_other_product', $data);
	}
	
	function xls_audit_trail($id=0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['user']	= $this->_report->get_user($id);
		//$data['data'] 	= $this->_report->get_other($id);
		$this->load->view('report/xls_audit_trail', $data);
	}
	
	#-------------------------------------
	# 	REPORT FOLLOW UP
	#-------------------------------------	
	function follow_up()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		#$data['cabang'] = $this->_report->get_cabang();
		$data = $this->list_user();
		$data['type'] = ($lvl == 'SALES')?0:1;
		$this->load->view('report/follow_up', $data);
	}
	
	// create report in excel
	function xls_follow_up($npp=0, $start = NOW, $end = NOW)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		#$data['cabang'] = $this->_report->get_cabang_detail($branch);
		#if($lvl == 'SALES')
		$data['user']	= $this->_report->get_user($npp);	
		$data['start']	= $start;
		$data['end']	= $end;
		$data['data'] 	= $this->_report->get_follow_up($npp, $start, $end);
		$this->load->view('report/xls_follow_up', $data);
	}
	
	#-------------------------------------
	# 	REPORT DAILY CLOSED
	#-------------------------------------	
	function daily_closed()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		$data = $this->list_user();
		$this->load->view('report/daily_closed', $data);
	}
	
	// create report in excel
	function xls_daily_closed($npp=0, $start = NOW, $end = NOW)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['user']	= $this->_report->get_user($npp);	
		$data['data'] 	= $this->_report->get_daily_closed($npp, $start, $end);
		$this->load->view('report/xls_daily_closed', $data);
	}
	
	#-------------------------------------
	# 	REPORT BNI PRODUCT 1
	#-------------------------------------	
	function bni_product_1()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		#$data['cabang'] = $this->_report->get_cabang();
		
		$data = $this->list_user();
		$data['type'] = 0;
		$this->load->view('report/bni_product_1', $data);
	}
	
	// create report in excel
	function xls_bni_product_1($npp=0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['user']	= $this->_report->get_user($npp);	
		#-------------------------------------
		# 	type: 0->Sales, 1->supervisor
		#-------------------------------------	
		$data['data'] 	= $this->_report->get_bni_product_1($npp);
		$this->load->view('report/xls_bni_product_1', $data);
	}
	
	#-------------------------------------
	# 	REPORT OPORTUNITY
	#-------------------------------------
	function oportunity()
	{
		$data = $this->list_user();
		$data['type'] = 0;
		$data['rpt_name'] = 'OPPORTUNITY SALES';
		$data['url_data'] = site_url('/report/get_oportunity/');
		$data['js'] = 0;
		$this->load->view('report/rpt_master', $data);
	}
	
	function get_oportunity($m=0, $y=0, $cab=0, $wil=0)
	{
		$data = $this->_report->get_oportunity($m, $y, $cab, $wil);
		
		$html 	=  "";
		#$html 	.= "NPP : ".$user[0]->ID."<br />\n";
		#$html 	.= "NAMA : ".strtoupper($user[0]->USER_NAME)."<br />\n";
		#$html 	.= "SALES TYPE : ".$user[0]->SALES_TYPE."<br />\n";
		#$html 	.= "PERIODE : ".$start." s/d ".$end."<br /><br />\n";
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n						
						<th align='center'>NPP</th>\n
						<th align='center'>NAMA SALES</th>\n
						<th align='center'>Rasio Janji</th>\n
						<th align='center'>Rasio Presentasi</th>\n
						<th align='center'>Rasio Penutupan</th>\n
					</tr>\n";
		
		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if($data){
			foreach($data as $row)
			{
				$color = ($i%2)?"#ffffff":"#eeeeee";
				$html .= "<tr bgcolor='$color'>\n";
				$html .= "	<td width='20' align='center'>".$i."</td>\n";				
				$html .= "	<td align='center'>".$row->USERID."</td>\n";
				$html .= "	<td align='left'>".$row->USER_NAME."</td>\n";
				$html .= "	<td align='center'>".$row->T."%</td>\n";
				$html .= "	<td align='center'>".$row->P."%</td>\n";
				$html .= "	<td align='center'>".$row->J."%</td>\n";				
				$html .= "</tr>\n";
				$i++;
			}
		} else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='9' align='center'><span style='color:#c00'>Tidak ada akitivitas</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	
	function xls_oportunity($m=0, $y=0, $cab=0, $wil=0)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'SUPER VISOR', 'SUPERVISOR', 'ADMIN');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
		
		$data['lvl'] = $lvl;
		$data['month'] = $m;
		$data['year'] = $y;
		$data['data'] 	= $this->_report->get_oportunity($m, $y, $cab, $wil);
		$this->load->view('report/xls_oportunity', $data);
	}
	
	function perform_year()
	{
/*
		$data = $this->list_user();
		$data['rpt_name'] = 'PERFORMANCE BY SALES (YEARLY)';
		$data['url_data'] = site_url('/report/get_perform_year/');
		$data['type'] = 1;
		$data['js'] = 1;
		$this->load->view('report/rpt_master',$data);
*/
echo"Performa Sales Tahunan c->report/perform_year";		
	}

	function kelola_year()
	{
/*
		$data = $this->list_user();
		$data['rpt_name'] = 'PERFORMANCE BY SALES (YEARLY)';
		$data['url_data'] = site_url('/report/get_perform_year/');
		$data['type'] = 1;
		$data['js'] = 1;
		$this->load->view('report/rpt_master',$data);
*/
echo"DPK Sales c->report/kelola_year";		
	}

	
	function real_year()
	{
		$data = $this->list_user();
		$data['rpt_name'] = 'REALISASI BY SALES (YEARLY)';
		$data['url_data'] = site_url('/report/get_perform_year/');
		$data['type'] = 2;
		$data['js'] = 1;
		$this->load->view('report/rpt_master',$data);
	}
	
	function monthly_performance()
	{
/*
		$data['rpt_name'] = 'PERFORMA SALES PER BULAN';
		$data['url_data'] = site_url('/report/get_monthly_performance/');
		$this->load->view('report/monthly_performance',$data);
*/	
echo"Performa Sales Bulanan c->report/monthly_performance";	
	}
	
	function get_monthly_performance($m, $y)
	{
		$data = $this->_report->data_monthly_performance($m, $y);
		
		$html 	.= "REPORT : PERFORMANCE BULANAN <br>";
		$html 	.= "PERIODE : ".strtoupper($this->nama_bulan($m))." $y<br /><br />\n";
		$html 	.= "<table width='750' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n						
						<th align='center'>NPP</th>\n
						<th align='center'>NAMA SALES</th>\n						
						<th align='center'>SALES</th>\n						
						<th align='center'>CABANG</th>\n						
						<th align='center'>WIL</th>\n						
						<th align='center'>BULAN</th>\n						
						<th align='center'>TAHUN</th>\n						
						<th align='center'>%</th>\n						
					</tr>\n";
		$color = "#ffffff";
		if($data)
		{	
			$i = 1;
			foreach($data as $row)
			{
					$bln = $this->nama_bulan($row->MM);
					$color = ($i%2)?"#ffffff":"#eeeeee";
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td align='center'>".$i++."</td>";
					$html .= "<td align='center'>".$row->SALES_ID."</td>";
					$html .= "<td align='left'>".$row->USER_NAME."</td>";
					$html .= "<td align='left'>".$row->SALES_TYPE."</td>";
					$html .= "<td align='center'>".$row->BRANCH_NAME."</td>";
					$html .= "<td align='center'>".$row->KODE."</td>";
					$html .= "<td align='center'>".$bln."</td>";
					$html .= "<td align='center'>".$row->YYYY."</td>";
					$html .= "<td align='center'>".$row->PERFORMANCE." %</td>";
					$html .= "</tr>";
			}
		} else
		{
			$html .= "<tr bgcolor='#ffffff'><td colspan=8 align='center'>Tidak ada data</td></tr>";
		}
		
		
		echo $html;
		
	}
	
	function get_monthly_performance_xls($m, $y, $wil)
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPER VISOR', 'SUPERVISOR','SLN');		
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		$wil = ($wil==0)?$_SESSION['REGION']:$wil;
		$wilayah = $this->_report->get_wilayah_detail($wil);
		
		$dbdata 		= $this->_report->data_monthly_performance($m, $y, 1, $wil);		
		$fields 		= array('SALES_ID','USER_NAME','SALES_TYPE','SPV', 'BRANCH_NAME','REGION_NAME','MM','YYYY','PERFORMANCE');
		$header 		= array('NPP','NAME SALES','SALES','PENYELIA','CABANG','WILAYAH','BULAN','TAHUN','PERFORMANCE %');
		$number_format	= array(0,0,0,0,0,0,0,0,0);
		$addition		= array('REPORT'=>'PERFORMANCE BULANAN','PERIODE'=>strtoupper($this->nama_bulan($m)).' '.$y,'WILAYAH'=>strtoupper($wilayah[0]->REGION_NAME));
		$title 			= 'PERFORMANCE BULAN';
		$file_name 		= 'sales_perfromance_bulan_'.$m.'_'.$y.'.xls';
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
	}
	
	function get_perform_year($type=1, $npp, $y)
	{
		$user	= $this->_report->get_user($npp);
		$npp = $user[0]->ID;
		$nama = strtoupper($user[0]->USER_NAME);
		$sales = $user[0]->SALES_TYPE;
		if($type==0)
		{
			$data = $this->_report->get_performance_year ($npp, $y, $type);
			$html 	=  "";
			$html 	.= "NPP : ".$npp."<br />\n";
			$html 	.= "NAMA : ".$nama."<br />\n";
			$html 	.= "SALES TYPE : ".$sales."<br />\n";
			$html 	.= "PERIODE : $y<br /><br />\n";
			$html 	.= "<table width='300' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
							<th align='center'>No.</th>\n						
							<th align='center'>BULAN</th>\n
							<th align='center'>PERFORMANCE</th>\n						
						</tr>\n";
			$color = "#ffffff";
			if($data)
			{	
				$i = 1;
				foreach($data as $row)
				{
						$bln = $this->nama_bulan($row->MM);
						$color = ($i%2)?"#ffffff":"#eeeeee";
						$html .= "<tr bgcolor='$color'>\n";
						$html .= "<td align='center'>".$i++."</td>";
						$html .= "<td align='center'>".$bln."</td>";
						$html .= "<td align='center'>".$row->PERFORMANCE." %</td>";
						$html .= "</tr>";
				}
			}
			
			echo $html;
		} else 
		
		{
			#$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
			#$arrlvl = array('SALES', 'ADMIN', 'SUPER VISOR', 'SUPERVISOR','SLN');		
			#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
			$dbdata = $this->_report->get_performance_year ($npp, $y, $type);
			$fields 		= array('MM','YYYY','PERFORMANCE');
			$header 		= array('BULAN','TAHUN','PERFORMANCE');
			$number_format	= array(0,0,0);
			$addition		= array('REPORT'=>'PERFORMANCE TAHUNAN SALES '.$y,'NPP'=>"($npp)",'NAMA'=>$nama,'SALES'=>$sales);
			$title 			= 'PERFORMANCE TAHUNAN SALES';
			$file_name 		= 'performance_tahunan_sales_'.$npp.'_'.$y.'.xls';
			$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
		}
	}
	
	
	function kelolaan_year()
	{
		$data['url_data'] = site_url('/report/get_kelolaan_year/');
		$data['url_data2'] = site_url('/report/get_dpk_year/');
		$data['rpt_name'] = 'DPK SALES H-2';
		$this->load->view('report/nasabah_year',$data); 	
	}
	
	function get_dpk_year($wil=1, $cab=0)
	{
		$user	= $this->_report->get_user($npp);
		$cabang = $this->_report->get_cabang_detail($cab);
		$wilayah = $this->_report->get_wilayah_detail($wil);
		
		$ket = ($wil !=0)?$wilayah[0]->REGION_NAME:'ALL SALES';
		$ket = ($cab !=0)?'CABANG '.$cabang[0]->BRANCH_NAME:$ket;
		$data 		= $this->_report->get_kelolaan_year($wil,$cab);
		$tgl = ($data)?$data[0]->TGL:'';
		$html 	=  "";
		$html 	.= "CABANG : ".$ket."<br />\n";
		$html 	.= "PERIODE : ".$tgl."<br /><br />\n";
		$html 	.= "<table width='750' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n						
						<th align='center'>TGL</th>\n						
						<th align='center'>NPP</th>\n
						<th align='center'>NAMA SALES</th>\n						
						<th align='center'>CIF</th>\n						
						<th align='center'>GIRO</th>\n						
						<th align='center'>TABUNGAN</th>\n						
						<th align='center'>DEPOSITO</th>\n						
						<th align='center'>DPK</th>\n						
					</tr>\n";
		$color = "#ffffff";
		if($data)
		{	
			$i = 1;
			foreach($data as $row)
			{
					$color = ($i%2)?"#ffffff":"#eeeeee";
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td align='center'>".$i++."</td>";
					$html .= "<td align='center'>".$row->TGL."</td>";
					$html .= "<td align='center'>".$row->NPP."</td>";
					$html .= "<td align='left'>".$row->SALES."</td>";
					$html .= "<td align='center'>".$row->CIF."</td>";
					$html .= "<td align='right'>".number_format($row->G,0,'.',',')."</td>";
					$html .= "<td align='right'>".number_format($row->T,0,'.',',')."</td>";
					$html .= "<td align='right'>".number_format($row->D,0,'.',',')."</td>";
					$html .= "<td align='right'>".number_format($row->DPK,0,'.',',')."</td>";
					$html .= "</tr>";
			}
		}
		
		echo $html;
	}
	
	function get_kelolaan_year($wil=1, $cab=0, $y)
	{
		
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPER VISOR', 'SUPERVISOR','SLN');		
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		
		$cabang = $this->_report->get_cabang_detail($cab);
		$wilayah = $this->_report->get_wilayah_detail($wil);
		
		$ket = ($wil !=0)?$wilayah[0]->REGION_NAME:'ALL SALES';
		$ket = ($cab !=0)?'CABANG '.$cabang[0]->BRANCH_NAME:$ket;
		$dbdata 		= $this->_report->get_kelolaan_year($wil, $cab,1);
		$tgl = ($dbdata)?$dbdata[0]['TGL']:'';		
		$fields 		= array('TGL','NPP','SALES','BRANCH_NAME', 'CIF','G','T','D','DPK');
		$header 		= array('TANGGAL','NPP','NAME SALES','CABANG','CIF','GIRO','TABUNGAN','DEPOSITO','DPK');
		$number_format	= array(0,0,0,0,1,1,1,1,1);
		$addition		= array('REPORT'=>'DPK CABANG','PERIODE'=>'['.$tgl.']','LAPORAN'=>$ket);
		$title 			= 'DPK CABANG';
		$file_name 		= 'dpk_cabang'.$date.'.xls';
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);

	}
	
	function kelolaan_month()
	{
/*
		$data['url_data'] = site_url('/report/xls_kelolaan_month/');
		$data['tanggal'] = $this->_report->get_tgl_dpk();
		$data['rpt_name'] = 'OUTSTANDING DPK PERBULAN';
		$this->load->view('report/rpt_kelolaan_month',$data); 	
*/
echo"Outstanding DPK Bulanan c->report/kelolaan_month";

	}
	
	// create report in excel
	function xls_kelolaan_month($date=0, $wil=0, $cab=0)
	{
		$tgl = date('d M Y', strtotime($date));
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPER VISOR', 'SUPERVISOR','SLN');		
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		$cabang = $this->_report->get_cabang_detail($cab);
		$wilayah = $this->_report->get_wilayah_detail($wil);
		$ket = ($wil !=0)?$wilayah[0]->REGION_NAME:'ALL SALES';
		$ket = ($cab !=0)?'CABANG '.$cabang[0]->BRANCH_NAME:$ket;
		$dbdata 		= $this->_report->get_kelolaan_month($date, $wil, $cab);		
		$fields 		= array('AS_OF_DATE','SALES_ID','USER_NAME','SALES_TYPE','GRADE','SPV','BRANCH_NAME','AVG_GIRO','AVG_TABUNGAN','AVG_DEPOSITO', 'AVG_DPK');
		$header 		= array('TANGGAL','NPP','NAME SALES','SALES','GRADE','PENYELIA','CABANG','GIRO','TABUNGAN','DEPOSITO','DPK');
		$number_format	= array(0,0,0,0,0,0,0,1,1,1,1);
		$addition		= array('REPORT'=>'KELOLAAN PER BULAN','PERIODE'=>$tgl,'LAPORAN'=>$ket);
		$title 			= 'KELOLAAN BULAN';
		$file_name 		= 'kelolaan_perbulan_'.$date.'.xls';
		$this->to_excel($header, $addition, $fields, $dbdata, $title, $file_name, $number_format, $number_format);
	}
	
	function get_cabang($id)
	{
		echo form_dropdown('CABANG',$this->_report->get_cabang_wil($id), '', 'id="CABANG"'); 
	}
	
	function to_excel($header, $addition, $fields, $datadb, $title, $filename, $number_format, $sum)
    {
        # variable data
		#$header = array('Npp','Nama','Email','Kode Cabang');
		#$fields = array('npp','nama','email','kode_cabang');		
		#$title = 'List User';
		#$filename = 'list_user.xls';
		$creator = 'SAPM';
		$chr = range('A','Z');		
		$num_fields = count($header);
		$row_start = 6;
		
		# create new object
		$objPHPExcel = new PHPExcel();
 
        # Set properties
        $objPHPExcel->getProperties()->setCreator($creator);
        
        # Add aditional Header
		$x=1;
		foreach($addition as $arr=>$row)
		{		
			$objPHPExcel->getActiveSheet()->mergeCells("B$x:H$x");
			$objPHPExcel->setActiveSheetIndex()->setCellValue('A'.$x, $arr);
			$objPHPExcel->setActiveSheetIndex()->setCellValue('B'.$x, $row);
			$x++;
		}
		
		# Add data header
        for($i=1;$i<=$num_fields;$i++)
		{		
			$objPHPExcel->setActiveSheetIndex()->setCellValue($chr[$i-1].$row_start, $header[$i-1]);
		}
		
		# get Data from database
        $result = $datadb;		
        $data = $result;        
		
		# write data to cell
		$cell = '';
		$value = '';
		for($i=1;$i<=$num_fields;$i++)
		{
			$start = $row_start + 1;
			foreach($data as $row)
			{
				$cell = $chr[$i-1].($start++);
				$value = $row[$fields[$i-1]];
				$objPHPExcel->setActiveSheetIndex()->setCellValue($cell, $value);
				if($number_format[$i-1] != 0)
				$objPHPExcel->getActiveSheet()->getStyle($cell)->getNumberFormat()->setFormatCode('#,##0.00');
			}
		}
		
		# SUM collumn
		for($i=0;$i<=$num_fields-1;$i++)
		{
			if($sum[$i] == 1)
			{
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($chr[$i].$start,'=SUM('.$chr[$i].($row_start+1).':'.$chr[$i].($start-1).')');
				$objPHPExcel->getActiveSheet()->getStyle($chr[$i].$start)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->getStyle($chr[$i].$start)->getFont()->setSize(12)->getColor()->setARGB('FFFFFFFF');
				$objPHPExcel->getActiveSheet()->getStyle($chr[$i].$start)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle($chr[$i].$start)->getFill()->getStartColor()->setARGB('FF555555');

			}
		}
		# format cell (make cell width autosize)
		for($i=1;$i<=$num_fields;$i++)
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($chr[$i-1])->setAutoSize(true);
		}
		# format cell (coloring header)
		$objPHPExcel->getActiveSheet()->getStyle($chr[0].$row_start.':'.$chr[$num_fields-1].$row_start)->getFill()
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
		$cell_start = $chr[0].$row_start;
		$cell_end = $chr[$num_fields-1].$start;
		$objPHPExcel->getActiveSheet()->getStyle("$cell_start:$cell_end")->applyFromArray($styleArray);
		# Add format number
		for($j=0;$j<count($number_format);$j++)
		{
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getNumberFormat()->setFormatCode('#,##0.00');
		}
        # Add title Active Sheet 		
        $objPHPExcel->getActiveSheet()->setTitle($title);
		
		# set default Active sheet		
        $objPHPExcel->setActiveSheetIndex(0);        
		
        # set header for download
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }	
	public function getDataNasabah(){

	$xxx = $_POST["id"];
		$data = $this->_agenda_bm->get_data_nasabah($_POST["id"]);
		$value .="<table>";
		foreach($data as $item){
			
				$value.="<tr><td>No CIF</td><td>:</td><td>$item->CIF</td></tr>
				<tr><td>Nama</td><td>:</td><td>$item->NAMA_NASABAH</td></tr> 
				<tr><td>Tanggal lahir</td><td>:</td><td>$item->TANGGAL_LAHIR</td></tr> 
				<tr><td>Sales Pengelola</td><td>:</td><td>$item->BNI_SALES_ID - $item->NAMA_SALES - $item->SALES_TYPE</td></tr>
				<tr><td>Posisi Tabungan</td><td>:</td><td>Rp. ".number_format($item->CUR_BOOK_BAL_TAB , 2, '.', ',')." (".$item->AS_OF_DATE.")</td></tr>";
				$value .="<tr></tr>";
			}
			$value .= "</table>";
		echo $value;
	}
	public function getDataProduk(){
		$xxx = $_POST["id"];
		$data = $this->_agenda_bm->get_data_product($_POST["id"]);
		$value .="<table>";
		foreach($data as $item){
		unset($item[0]['CIF']);
		$prod_bni = str_replace('_',' ', str_replace('PROD_','',implode(', ',array_keys($data[0],'1'))));
	    $prod_bni = ucwords(strtolower($prod_bni));
				$value .="<tr><td>Produk yang dimiliki di BNI</td><td>:</td><td>".$prod_bni."</td></tr>";
				$value .="<tr></tr>";
			}
			$value .= "</table>";
		echo $value;
	}
	public function getDataActivity(){
		$xxx = $_POST["id"];
		$data = $this->_agenda_bm->get_list_activity($_POST["id"]);
		$value .="Daftar Kegiatan BM<table>";
		foreach($data as $item){
				$value.="<tr><td colspan='3' align='center'>$item->CREATED_DATE</td></tr>
				<tr><td>KEGIATAN</td><td>:</td><td>$item->KEGIATAN</td></tr>
				<!--<tr><td>Tanggal Aktifitas</td><td>:</td><td>$item->TANGGAL_KEGIATAN</td></tr>-->
				<tr><td>Realisasi</td><td>:</td><td>$item->REALISASI</td></tr> 
				<tr><td>KETERANGAN</td><td>:</td><td>$item->KETERANGAN</td></tr>
				<!--<tr><td>STATUS</td><td>:</td><td>$item->STATUS</td></tr>-->";
				$value .="<tr></tr>";
				$value .="<tr></tr>";
			}
			$value .= "</table>";
		echo $value;
	}
}
