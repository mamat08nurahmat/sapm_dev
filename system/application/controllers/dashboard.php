<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Controller {

	function Dashboard()
	{
		parent::Controller();
		$this->load->helper('flexigrid');
		$this->load->helper('text');
		$this->load->model('_dashboard');
		if($_SESSION['ID'] == ''){ redirect('login');}
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/');}
		$this->load->model('_handler');
		$this->load->model('_news');
		
		date_default_timezone_set('Asia/Jakarta');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
		
	}
	
	function index($year = 0, $month = 0)
	{
		$data['todo'] = $this->get_todo(0,0,0);
		#$data['bday'] = $this->get_bday();
		#$data['target'] = $this->get_target(0,0);
		#$data['realisasi'] = $this->get_realisasi(0,0);
		#$data['cust_ind_up'] = $this->get_cust_ind('DESC');
		#$data['cust_ind_down'] = $this->get_cust_ind('ASC');
		#$data['cust_corp_up'] = $this->get_cust_corp('DESC');
		#$data['cust_corp_down'] = $this->get_cust_corp('ASC');
		
		
		//print_r($data); die();
		
		$this->load->view('dashboard/index', $data);
		
		//$news = $this->db->query("SELECT * FROM NEWS WHERE IS_ACTIVE = 1 ORDER BY TANGGAL DESC ")->result();		
		//print_r($news);
		
	}
	
	function dashboard1(){
		//echo"HELLO";
		$this->load->view('dashboard/dashboard1');
	}
	
	function get_bday()
	{
echo"get_bday";
/*
		$data = $this->_dashboard->get_bday();
		$html = '';
		foreach($data as $row)
		{
			$html  .= "<div class='items_dashboard' style='clear:both; height:18px;'>";
			$hari 	= date('d');
			$bln  	=date('m');
			if($hari == $row->HARI && $bln == $row->BULAN){
				
				$html .= "<span style='float:left; color:#00f; '>".anchor(base_url().'index.php/sales/view_cust_ind/1/'.$row->CIF_KEY,strtoupper($row->CUST_NAME),"style='text-decoration:none;color:#00f'")." <img src='".ICONS."birthday-cake.gif' width='15' alt='ultah' align='top'> </span>";
				$html .= "<span style='float:right; color:#00f'>".$row->HARI." ".$row->BULAN."</span></div>";
			} else {
				$html .= "<span style='float:left'>".anchor(base_url().'index.php/sales/view_cust_ind/1/'.$row->CIF_KEY,strtoupper($row->CUST_NAME),"style='text-decoration:none'")."</span>";
				$html .= "<span style='float:right;'>".$row->HARI." ".$row->BULAN."</span></div>";
			}
		}
		$html = ($html == '')?"<div class='items_dashboard' style='color:#c00; border:none' align='center'>Tidak ada data !</div>":$html;
		echo $html;		
*/		

	}
	
	function get_todo($d=0, $m=0, $y=0)
	{	if($d == 0){
			$date = getdate();
			$d = $date['mday'];
			$m = $date['mon'];
			$y = $date['year'];
		}
		$data = $this->_dashboard->get_todo($d, $m, $y);
		$html = '';
		foreach($data as $row)
		{
			$html .=  "<div class='items_dashboard'>".$row->H.":".$row->I." - <b>'".$row->NAMANASABAH."'</b>";
			//$html .=  "<div style='margin-left:37px'><b>".$row->TODO."</b></div></div>\n";
			$html .=  "<div style='margin-left:37px'>".$row->TODO."</div></div>\n";
		}
		$html = ($html == '')?"<div class='items_dashboard' style='color:#c00; border:none' align='center'>Tidak ada data !</div>":$html;
		return $html;
	}
	
	function get_cifchecker($cif=0)
	{	
/*
echo"<pre>";
echo $cif;	
*/
		$data = $this->_dashboard->get_cifchecker($cif);
		//print_r($data);
		$html = '';
		foreach($data as $row)
		{
			//$html .=  "<div class='items_dashboard'>".$row->H.":".$row->I." - <b>'".$row->NAMANASABAH."'</b>";
			//$html .=  "<div style='margin-left:37px'><b>".$row->TODO."</b></div></div>\n";
			//$html .=  "<div style='margin-left:37px'>".$row->TODO."</div></div>\n";
/*
			$html .=  "<div class='items_dashboard'>".$row->CIF_KEY." - ".$row->CUST_NAME." dikelola oleh ".$row->USER_NAME." - NPP : ".$row->SALES_ID."\n";
			$html .=  "Sales ".$row->SALES_TYPE." di Cabang ".$row->BRANCH_NAME."</div>";
*/
			$html .=  "<div class='items_dashboard'>".$row->CIF_KEY." - ".$row->CUST_NAME."\n";
			$html .=  "Sales ID".$row->SALES_ID."</div>";			
		}
//$html = ($html == '')?"<div class='items_dashboard' style='color:#00cc00; border:none' align='center'>".$row->CIF_KEY." Belum dikelola</div>":$html;
		return $html;
/*
*/	
		
	}
	
//---------------------
	function get_cifchecker_new($cif=0)
	{	
//		$data = $this->_dashboard->get_cifchecker($cif);	
echo $cif;		
//$html = '';
/*
		foreach($data as $row)
		{

			echo  "<div class='items_dashboard'>".$row->CIF_KEY." - ".$row->CUST_NAME."\n";
			echo   "Sales ID".$row->SALES_ID."</div>";			
		}	
*/

//$html = ($html == '')?"<div class='items_dashboard' style='color:#00cc00; border:none' align='center'>".$row->CIF_KEY." Belum dikelola</div>":$html;
		//return $html;


	}
	
	
	
	function get_ajax_todo($date=0)
	{	
		$date = getdate(strtotime($date));
		$d = $date['mday'];
		$m = $date['mon'];
		$y = $date['year'];
		$html = $this->get_todo($d, $m, $y);
		
		$html = ($html == '')?"<div class='items_dashboard' style='color:#c00; border:none' align='center'>Tidak ada data !</div>":$html;
		echo $html;
	}

//----------
	function get_modal_cifchecker($cif=0)
	{	
/*
echo $cif;	
*/	
		$html = $this->get_cifchecker($cif);
		//$html == '';
		
		$html = ($html == '')?"<div class='items_dashboard' style='color:#c00; border:none' align='center'>Tidak ada data !</div>":$html;
		echo $html;
		
	}
	
	function get_ajax_cifchecker($cif=0)
	{	
/*
echo $cif;	
*/	
		$html = $this->get_cifchecker($cif);
		//$html == '';
		
		$html = ($html == '')?"<div class='items_dashboard' style='color:#c00; border:none' align='center'>Tidak ada data !</div>":$html;
		echo $html;
		
	}
	
	function get_target($m=0, $y=0)
	{
echo"get_target";
/*
		if($m == 0){
			$date = getdate();
			$m = $date['mon'];
			$y = $date['year'];
		}
		$data = $this->_dashboard->get_target($m, $y);
//		print_r($data);
		$html = '';
		foreach($data as $row)
		{
			$curr = ($row->TYPE == 'CURRENCY')?'Rp':'';
			#$target = ($row->PROC_ID == 8 || $row->PROC_ID == 10)?$row->TARGET:$row->TARGET+$row->OUTSTANDING;
			$target = ($row->PROC_ID == 8 || $row->PROC_ID == 10 || $row->PROC_ID == 38)?$row->TARGET+$row->OUTSTANDING:$row->TARGET;
			$html .=  "<div class='items_dashboard' style='clear:both; height:18px;'><span style='float:left'>".$row->PRODUCT_NAME."</span><span style='float:right'>$curr ".number_format($target,2,'.',',')."</span></div>\n";
		}
		#return $html;
		$html = ($html == '')?"<div class='items_dashboard' style='color:#c00; border:none' align='center'>Tidak ada data !</div>":$html;
		echo $html;
*/		
	}
	
	function get_realisasi($m=0, $y=0)
	{
#echo"get_realisasi";
/*
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahun = date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		
		
		if($m == 0 || $y == 0){
			$date 	= getdate();			
			$bln 	= ($date['mon'] == 1)?12:$date['mon']-1;
			$yr 	= ($bln == 12 && $m == 1)?$date['year']-1:$date['year'];
			
		} else {
			$bln = ($m == 1)?12:$m-1;
			$yr = ($bln == 12 && $m == 1)?$y-1:$y;	
		}
*/
		#$data = $this->_dashboard->get_target($bln, $yr);
		//$data = $this->_dashboard->get_target($bulanlalu, $tahun);
		//$data = $this->db->query("SELECT * FROM NEWS WHERE ROWNUM <= 10")->result();
		$data = $db->tabel();
		print_r($data);
	/*
		$html = '';
		
			
		
		foreach($data as $row)
		{
			
			$target = ($row->PROC_ID == 8 || $row->PROC_ID == 10 || $row->PROC_ID == 38 )?$row->TARGET+$row->OUTSTANDING:$row->TARGET;
			if($row->PROC_ID <= 6)
			{
			$pencapaian = $row->PENCAPAIAN-$row->OUTSTANDING;			
			}
			else
			{
			$pencapaian = $row->PENCAPAIAN;
			}
			if($row->TARGET <> 0){			
				$realisasi = ((($pencapaian/$target)*100)>200)?200:($pencapaian/$target)*100;
			} else $realisasi = 0;
			
			if($realisasi < 0)
			{
				$realisasi = 0;
			}
			if($realisasi > 75) $color = '#080';
			else if ($realisasi <= 75 && $realisasi > 50) $color ='#00f';
			else if ($realisasi <= 50) $color = '#f00';
			$curr = ($row->TYPE == 'CURRENCY')?'Rp':'';
			$html .=  "<div class='items_dashboard' style='clear:both; height:18px;'><span style='float:left'>".$row->PRODUCT_NAME."</span><span style='float:right; width:40px; text-align:right; color:$color;'> ".number_format($realisasi,0,'.',',')."%</span><span style='float:right'>$curr ".number_format($pencapaian,2,'.',',')."</span></div>\n";
		}
		#return $html;
		$html = ($html == '')?"<div class='items_dashboard' style='color:#c00; border:none' align='center'>Tidak ada data !</div>":$html;
		echo $html;
*/		
	}
	
	function get_ajax_target($m=0, $y=0)
	{	
		$data = $this->get_target($m, $y);
		echo $data;
	}
	
	function get_cust_ind($sort='DESC')
	{
/*
echo"get_cust_ind";		
echo"<br>";
echo $sort;		
*/
$sql ="
SELECT * FROM (SELECT BNI_CIF_KEY CIF_KEY, CUST_NAME, 
               ( A.DPK - B.DPK_BASELINE) AS SALDO 
                FROM tmp_nasabah_kelolaan A
                 JOIN VW_DPK_BASELINE B
                 ON A.BNI_CIF_KEY = B.CIF_KEY
                   WHERE last_month=0 AND TRIM(SUBSTR(BNI_SALES_ID,-5,5)) = '16622'
                    ORDER BY SALDO $sort
                     ) WHERE ROWNUM <= 10
";
						
		$data = $this->db->query($sql)->result();		
		#print_r($query);
		
		//$data 	= $this->_dashboard->get_cust_ind($sort);
		#echo "<pre>";print_r($data); die();
		
		
		$html 	= '';
		$img 	= '';
		$cust_name = '';
		
		foreach($data as $row)
		{
			if($row->SALDO > 0) $img = 'up';
			if($row->SALDO < 0) $img = 'down';
			if($row->SALDO == 0) $img = '';
			$cust_name =  character_limiter($row->CUST_NAME, 25);
		
			if($sort == 'DESC'){
				if($row->SALDO > 0){
					$html .=  "<div class='items_dashboard' style='clear:both; height:18px;'><span style='float:left'>".anchor(base_url().'index.php/sales/view_cust_ind/1/'.$row->CIF_KEY,$cust_name,"style='text-decoration:none;color:#00f'")."</span> ";
					$html .=  "<span style='float:right'>Rp ".number_format($row->SALDO,2,'.',',')."<img src='".ICONS."$img.gif' align='top' /></span></div>\n";
				} else $html .= '';
			}
			
			if($sort == 'ASC'){
				if($row->SALDO < 0){
					$html .=  "<div class='items_dashboard' style='clear:both; height:18px;'><span style='float:left'>".anchor(base_url().'index.php/sales/view_cust_ind/1/'.$row->CIF_KEY,$cust_name,"style='text-decoration:none;color:#00f'")."</span> ";
					$html .=  "<span style='float:right'>Rp ".number_format($row->SALDO,2,'.',',')."<img src='".ICONS."$img.gif' align='top' /></span></div>\n";
				} else $html .= '';
			}
		}
		$html = ($html == '')?"<div class='items_dashboard' style='color:#c00; border:none' align='center'>Tidak ada data !</div>":$html;
		#return $html;
		echo $html;	


				//if($row->SALDO > 0){
					
/*
*/		

	}
	
	function get_cust_corp($sort='DESC')
	{
		$data 	= $this->_dashboard->get_cust_corp($sort);
		$html 	= '';
		$img 	= '';
		$cust_name =  character_limiter($row->CUST_NAME, 25);
		foreach($data as $row)
		{
			if($row->SALDO > 0) $img = 'up';
			if($row->SALDO < 0) $img = 'down';
			if($row->SALDO == 0) $img = '';
			
			if($sort == 'DESC'){
				if($row->SALDO > 0){
					$html .=  "<div class='items_dashboard' style='clear:both; height:18px;'><span style='float:left'>".$cust_name."</span><span style='float:right'>Rp ".number_format($row->SALDO,2,'.',',')."<img src='".ICONS."$img.gif' align='top' /></span></div>\n";
				} else $html .= "";
			}
			
			if($sort == 'ASC'){
				if($row->SALDO < 0){
					$html .=  "<div class='items_dashboard' style='clear:both; height:18px;'><span style='float:left'>".$cust_name."</span><span style='float:right'>Rp ".number_format($row->SALDO,2,'.',',')."<img src='".ICONS."$img.gif' align='top' /></span></div>\n";
				} else $html .= '';
			}
		}
		$html = ($html == '')?"<div class='items_dashboard' style='color:#c00; border:none' align='center'>Tidak ada data !</div>":$html;
		#return $html;
		echo $html;
	}
}
?>