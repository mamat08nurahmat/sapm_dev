<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Self_flagging extends Controller
{
	function Self_flagging()
	{
		parent::Controller();
	}
	
    function __construct()
    {
        parent::__construct();
        // load helper dan library
		$this->load->library('flexigrid');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		$this->load->model('_login', 'login', TRUE);
		$this->load->model('_news');
		$this->load->model('_activity');
		//$this->load->model('_home');
		$this->load->model('_report');
		$this->load->model('_agenda_bm');
		$this->load->model('_self_flagging');
		if($_SESSION['ID'] == ''){ redirect('login/logout/');}
		$this->load->model('_handler');

		date_default_timezone_set('Asia/Jakarta');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
    }
 
	#untuk modul upload sales baru
    function index($msg='',$err='')
    {
		$tgl=date('j');
		$data['err'] = $err;
		$data['msg'] = $msg;
        //$data = array(
        //    'action' => site_url('self_flagging/proses'),
        //    'judul' => set_value('judul'),
        //    'error' => $error['error'] // ambil parameter error
        //);
		
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES','SLN','ADMIN');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/3');}
		$ceknpp=$this->_self_flagging->cekupload($_SESSION['ID']);
		$salesid=$ceknpp[0]->NPP;
		if($_SESSION['ID']==$salesid) {redirect('self_flagging/waiting');}
        $this->load->view('self_flagging/pra_flagging', $data);
    }
	
	private function isAjax()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest';
	}
	
	function sales($msg='',$err='')
    {

		$tgl=date('j');
		$npp=$_SESSION['ID'];
		$data['err'] = $err;
		$data['msg'] = $msg;

        /*$data = array(
            'action' => site_url('self_flagging/proses_sales'),
            'judul' => set_value('judul'),
			'id'=>'formUpload',
            'error' => $error['error'] // ambil parameter error
        );*/
		$data['ceksales'] = $this->_self_flagging->ceksales($npp);
		$data['list_salestype'] = $this->_self_flagging->get_salestype();
		$data['list_cabang'] = $this->_agenda_bm->get_cabang();
		$data['list_kln'] = $this->_agenda_bm->get_kln();
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES','SLN','ADMIN');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/3');}
		$ceknpp=$this->_self_flagging->cekupload($_SESSION['ID']);
		$salesid=$ceknpp[0]->NPP;
		$ceklama = $this->_self_flagging->cek_sales_lama($_SESSION['ID']);
		$saleslama=$ceklama[0]->JUMLAH;
//---------->>		
		if($saleslama>0){redirect('self_flagging/sales_tambah');}
		if($_SESSION['ID']==$salesid) {redirect('self_flagging/waiting');}
		if($tgl >=1 && $tgl <=7 && $npp!=15057){redirect('self_flagging/tutup');}
		
        $this->load->view('self_flagging/pra_flagging', $data);
	
    }
 
    public function proses()
    {
        // validasi judul
       // $this->form_validation->set_rules('judul', 'judul', 'trim|required');
 
       // if ($this->form_validation->run() == FALSE) {
            // jika validasi judul gagal
           // $this->index();
       // } else {
            // config upload
            $nmfile = "usulan_flagging_".$salesid."_".time().".xls";
            $config['upload_path'] = PRA_FLAGGING;
            $config['allowed_types'] = 'xls';
            $config['max_size'] = '10000';
			$config['file_name'] = $nmfile;
            $this->load->library('upload', $config);
 
             if ( ! $this->upload->do_upload('userfile')) {
                // jika validasi file gagal, kirim parameter error ke index
                //$error = array('error' => $this->upload->display_errors());
                //$this->sales($error);
				$err = $this->upload->display_errors('','');
				//redirect(site_url('self_flagging/sales'));
            } else {
              // jika berhasil upload ambil data dan masukkan ke database
              $upload_data = $this->upload->data();
 
              // load library Excell_Reader
              $this->load->library('Excel_reader/Excel_reader');
 
              //tentukan file
              $this->excel_reader->setOutputEncoding('230787');
              $file = $upload_data['full_path'];
              $this->excel_reader->read($file);
              error_reporting(E_ALL ^ E_NOTICE);
 
              // array data
              $data = $this->excel_reader->sheets[0];
              $dataexcel = Array();
              for ($i = 2; $i <= $data['numRows']; $i++) {
                   if ($data['cells'][$i][1] == '')
                       break;
                   $dataexcel[$i - 2]['NPP'] = $data['cells'][$i][1];
                   $dataexcel[$i - 2]['CIF_KEY'] = $data['cells'][$i][2];
                   $dataexcel[$i - 2]['CUST_NAME'] = $data['cells'][$i][3];
              }
              
              //load model
              $this->load->model('_self_flagging');
              $this->_self_flagging->loaddata($dataexcel);
 
              //delete file
              $file = $upload_data['file_name'];
              $path = PRA_FLAGGING .$file;
              //unlink($path);
			    $msg 		= 'Your file was successfully uploaded!';
           // }
        //redirect ke halaman awal
        //redirect(site_url('self_flagging'));
        }
		$this->index($msg,$err);
    }
	
	 public function proses_sales()
    {
		$salesid=$_SESSION['ID'];
        // validasi judul
       // $this->form_validation->set_rules('judul', 'judul', 'trim|required');
 
       // if ($this->form_validation->run() == FALSE) {
            // jika validasi judul gagal
           // $this->sales();
       // } else {
            // config upload
			$nmfile = "usulan_flagging_".$salesid."_".time().".xls";
            $config['upload_path'] = PRA_FLAGGING;
            $config['allowed_types'] = 'xls';
            $config['max_size'] = '10000';
			$config['file_name'] = $nmfile;
            $this->load->library('upload', $config);
 
            if ( ! $this->upload->do_upload('userfile')) {
                // jika validasi file gagal, kirim parameter error ke index
                //$error = array('error' => $this->upload->display_errors());
                //$this->sales($error);
				$err = $this->upload->display_errors('','');
				//redirect(site_url('self_flagging/sales'));
            } else {
              // jika berhasil upload ambil data dan masukkan ke database
              $upload_data = $this->upload->data();
 
              // load library Excell_Reader
              $this->load->library('Excel_reader/Excel_reader');
 
              //tentukan file
              $this->excel_reader->setOutputEncoding('230787');
              $file = $upload_data['full_path'];
              $this->excel_reader->read($file);
              //error_reporting(E_ALL ^ E_NOTICE);
 
              // array data
              $data = $this->excel_reader->sheets[0];
              $dataexcel = Array();
              for ($i = 2; $i <= $data['numRows']; $i++) {
                   if ($data['cells'][$i][1] == '')
                       break;
                   #$dataexcel[$i - 2]['NPP'] = $data['cells'][$i][1];
                   $dataexcel[$i - 2]['CIF_KEY'] = $data['cells'][$i][1];
                   $dataexcel[$i - 2]['CUST_NAME'] = $data['cells'][$i][2];
              }
              
              //load model
              $this->load->model('_self_flagging');
              $this->_self_flagging->loaddatasales($dataexcel);
 
              //delete file
              $file = $upload_data['file_name'];
              $path = PRA_FLAGGING .$file;
              //unlink($path);
			  $msg 		= 'Your file was successfully uploaded!';
           // }
        //redirect ke halaman awal
       // redirect(site_url('self_flagging/sales'));
        }
		$this->sales($msg,$err);
    }
	
	function status($npp=0)
	{
		$data=$this->_self_flagging->get_jumlah($npp);
		$data2=$this->_self_flagging->get_valid_data($npp);
		if($data2)
		{
			$cekstatus=$data2[0]->STATUS_CODE;
		}
		else
		{
			$cekstatus=99;
		}
			$html    ="";
			if($cekstatus==0)
			{
				$html   .="<button id='kirimspv' onclick='kirimspv()'>Kirim</button>&nbsp;<button id='hapus' onclick='hapus()'>Hapus</button>\n";
			}
			else
			{
				$html   .="";
			}
			$html   .="<br/>";
			$html   .="<br/>";
			$html   .="Report Status Usulan Flagging";
			$html 	.= "<table width='50%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>NPP</th>\n						
						<th align='center'>KETERANGAN</th>\n
						<th align='center'>JUMLAH CIF</th>\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
			foreach($data as $row)
			{
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->NPP."</td> \n";
					$html .= "<td width='' align='center'>".$row->KETERANGAN."</td> \n";
					$html .= "<td width='' align='center'>".$row->JUMLAH_CIF."</td> \n";
					$html .= "</tr> \n";
			}
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='4' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	
	function detail($npp=0)
	{
		$data=$this->_self_flagging->get_valid_data($npp);
		
			$html    ="";
			$html   .="Report Detail Usulan Flagging";
			$html 	.= "<table width='80%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report1'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>TANGGAL UPLOAD</th>\n
						<th align='center'>NPP</th>\n
						<th align='center'>CIF</th>\n							
						<th align='center'>NAMA</th>\n
						<th align='center'>KETERANGAN</th>\n
						<th align='center'>STATUS</th>\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
			foreach($data as $row)
			{
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='center'>".$row->CREATED_DATE."</td> \n";
					$html .= "<td width='' align='left'  >".$row->NPP."</td> \n";
					$html .= "<td width='' align='center'>".$row->CIF_KEY."</td> \n";
					$html .= "<td width='' align='center'>".$row->CUST_NAME."</td> \n";
					$html .= "<td width='' align='center'>".$row->KETERANGAN."</td> \n";
					$html .= "<td width='' align='center'>".$row->STATUS."</td> \n";
					$html .= "</tr> \n";
			}
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	
	function hapus($npp)
	{
		$hapus=$this->_self_flagging->delete($npp);
		redirect(site_url('self_flagging/sales'));
	}
	
	function kirimsales($npp)
	{
		$kirim_spv=$this->_self_flagging->kirim_sales($npp);
		//redirect(site_url('self_flagging/spv'));
	}
	
	function kirimspv($npp)
	{
		$kirim_spv=$this->_self_flagging->kirim_spv($npp);
		redirect(site_url('self_flagging'));
	}
	
	function kirimspvs($npp)
	{
		$kirim_spv=$this->_self_flagging->kirim_spv($npp);
		redirect(site_url('self_flagging/bm'));
	}
	
	function kirimbm($npp)
	{
		$kirim_bm=$this->_self_flagging->kirim_bm($npp);
		redirect(site_url('self_flagging/spv'));
	}
	
	function kirimbms($npp)
	{
		$kirim_bm=$this->_self_flagging->balik_bm($npp);
		redirect(site_url('self_flagging/sln'));
	}
	
	function kirimsln($npp)
	{
		$kirim_sln=$this->_self_flagging->kirim_sln($npp);
		redirect(site_url('self_flagging/bm'));
	}
	
	function generatenaskel($npp)
	{
		$kirim_sln=$this->_self_flagging->generate_naskel($npp);
		redirect(site_url('self_flagging/sln'));
	}
	
	function detail_report()
	{
	/*
		echo"HELLLOOOOOO";
	*/	
		$data=$this->_self_flagging->get_detail_detail_report();
		
			$html    ="";
			$html   .="Report Detail Usulan Flagging";
			$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report1'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>NPP</th>\n
						<th align='center'>NAMA</th>\n
						<th align='center'>SALES TYPE</th>\n
						<th align='center'>CR</th>\n		
						<th align='center'>BB</th>\n	
						<th align='center'>TOTAL</th>\n
						<th align='center'>AUM CR</th>\n
						<th align='center'>AUM BB</th>\n
						<th align='center'>TOTAL AUM</th>\n
						<th align='center'>Detail</th>\n
						<th align='center'>KETERANGAN</th>\n
						<th align='center'>PROSES</th>\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
			foreach($data as $row)
			{
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SALES_ID."</td> \n";
					$html .= "<td width='' align='center'  >".$row->USER_NAME."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SALES_TYPE."</td> \n";
					$html .= "<td width='' align='center'>".$row->CR."</td> \n";
					$html .= "<td width='' align='center'>".$row->BB."</td> \n";
					$html .= "<td width='' align='center'>".$row->JUMLAH_CIF."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUMCR,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUMBB,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUM,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'><button onclick='detail(".$row->SALES_ID."".$row->STATUS.")'>Info</button></td> \n";
					$html .= "<td width='' align='center'>".$row->KETERANGAN."</td> \n";
					$html .= "<td width='' align='center'>".$row->PROSES."</td> \n";
					$html .= "</tr> \n";
			}
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='13' align='center'><span style='color:#c00'>Data muncul setelah 1 hari pengajuan ke Supervisor</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	
	function detaildetail_report($npp)
	{
		$data=$this->_self_flagging->get_detail_report($npp);
		
			$html    ="";
			$html .= "<form method='post' action='".site_url('self_flagging/kirimdetailsspv/')."' id='frm_kirimdetail'>\n";
			$html   .="DPK menggunakan Saldo Rata - Rata";
			$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report1'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>TANGGAL</th>\n
						<th align='center'>NPP</th>\n
						<th align='center'>CIF</th>\n
						<th align='center'>TYPE</th>\n	
						<th align='center'>NAMA</th>\n
						<th align='center'>DPK</th>\n	
						<th align='center'>INVESTASI</th>\n
						<th align='center'>BANCAS</th>\n
						<th align='center'>AUM</th>\n
						<th align='center'>SEGMENT</th>\n
						<!--th align='center'>AKSI <input type='checkbox' id='selectall' onclick='check();'></th-->\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
		$sumdpk = 0;
			$suminvestasi = 0;
			$sumbancas = 0;
			$sumaum=0;
			foreach($data as $row)
			{
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->BASELINE_DATE."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SALES_ID."</td> \n";
					$html .= "<input type='hidden' id='salesid' name='salesid' value='".$row->SALES_ID."' />\n";
					$html .= "<td width='' align='center'  >".$row->CIF_KEY."</td> \n";
					$html .= "<td width='' align='center'>".$row->CUST_TYPE."</td> \n";
					$html .= "<td width='' align='center'  >".$row->CUST_NAME."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->DPK,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->INVESTASI,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->BANCAS,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->AUM,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SEGMENTASI."</td> \n";
					#$html .= " <td width='' align='center'  ><input type='checkbox' name='cek[]' id='cek[]' value='".$row->CIF_KEY."'></td> \n";
					$html .= "</tr> \n";
					$sumdpk = $sumdpk + $row->DPK;
				$suminvestasi = $suminvestasi + $row->INVESTASI;
				$sumbancas = $sumbancas + $row->BANCAS;
				$sumaum = $sumaum + $row->AUM;
			}
				
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='11' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html 	.= "<tr  bgcolor='#66FF66'>\n";
		$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Total</span></td>\n";	
		
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumdpk,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($suminvestasi,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumbancas,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumaum,0,'.',',')."</b></td> \n";
				#$html .= "<td width='' colspan='2' align='center' class='kecil'><input type='submit' value='Kirim' />&nbsp;<button onclick=kirimbm(".$row->SALES_ID.")>Kirim Semua</button>&nbsp;<button onclick=kirimsales(".$row->SALES_ID.")>Tolak</button></td> \n";
		$html 	.= "</tr>\n";
		$html .= "</table>\n";
		$html .="</form>\n";
		echo $html;
	}
	
	function detail_spv()
	{
		$data=$this->_self_flagging->get_detail_detail_spv();
		
			$html    ="";
			$html   .="Report Detail Usulan Flagging";
			$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report1'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>NPP</th>\n
						<th align='center'>NAMA</th>\n
						<th align='center'>SALES TYPE</th>\n
						<th align='center'>CR</th>\n		
						<th align='center'>BB</th>\n	
						<th align='center'>TOTAL</th>\n
						<th align='center'>AUM CR</th>\n
						<th align='center'>AUM BB</th>\n
						<th align='center'>TOTAL AUM</th>\n
						<th align='center'>Detail</th>\n
						<th align='center'>KETERANGAN</th>\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
			foreach($data as $row)
			{
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SALES_ID."</td> \n";
					$html .= "<td width='' align='center'  >".$row->USER_NAME."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SALES_TYPE."</td> \n";
					$html .= "<td width='' align='center'>".$row->CR."</td> \n";
					$html .= "<td width='' align='center'>".$row->BB."</td> \n";
					$html .= "<td width='' align='center'>".$row->JUMLAH_CIF."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUMCR,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUMBB,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUM,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'><button onclick='detail(".$row->SALES_ID.")'>Info</button></td> \n";
					$html .= "<td width='' align='center'>".$row->KETERANGAN."</td> \n";
					$html .= "</tr> \n";
			}
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='12' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	
	function detaildetail_spv($npp)
	{
		$data=$this->_self_flagging->get_detail_spv($npp);
		
			$html    ="";
			$html .= "<form method='post' action='".site_url('self_flagging/kirimdetailsspv/')."' id='frm_kirimdetail'>\n";
			$html   .="DPK menggunakan Saldo Rata - Rata";
			$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report1'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>TANGGAL</th>\n
						<th align='center'>NPP</th>\n
						<th align='center'>CIF</th>\n
						<th align='center'>TYPE</th>\n	
						<th align='center'>NAMA</th>\n
						<th align='center'>DPK</th>\n	
						<th align='center'>INVESTASI</th>\n
						<th align='center'>BANCAS</th>\n
						<th align='center'>AUM</th>\n
						<th align='center'>SEGMENT</th>\n
						<th align='center'>AKSI <input type='checkbox' id='selectall' onclick='check();'></th>\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
		$sumdpk = 0;
			$suminvestasi = 0;
			$sumbancas = 0;
			$sumaum=0;
			foreach($data as $row)
			{
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->BASELINE_DATE."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SALES_ID."</td> \n";
					$html .= "<input type='hidden' id='salesid' name='salesid' value='".$row->SALES_ID."' />\n";
					$html .= "<td width='' align='center'  >".$row->CIF_KEY."</td> \n";
					$html .= "<td width='' align='center'>".$row->CUST_TYPE."</td> \n";
					$html .= "<td width='' align='center'  >".$row->CUST_NAME."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->DPK,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->INVESTASI,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->BANCAS,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->AUM,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SEGMENTASI."</td> \n";
					$html .= " <td width='' align='center'  ><input type='checkbox' name='cek[]' id='cek[]' value='".$row->CIF_KEY."'></td> \n";
					$html .= "</tr> \n";
					$sumdpk = $sumdpk + $row->DPK;
				$suminvestasi = $suminvestasi + $row->INVESTASI;
				$sumbancas = $sumbancas + $row->BANCAS;
				$sumaum = $sumaum + $row->AUM;
			}
				
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='11' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html 	.= "<tr  bgcolor='#66FF66'>\n";
		$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Total</span></td>\n";	
		
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumdpk,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($suminvestasi,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumbancas,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumaum,0,'.',',')."</b></td> \n";
				$html .= "<td width='' colspan='2' align='center' class='kecil'><input type='submit' value='Kirim' style='display:none' />&nbsp;<button onclick=kirimbm(".$row->SALES_ID.") style='display:none'>Kirim Semua</button>&nbsp;<button onclick=kirimsales(".$row->SALES_ID.") style='display:none'>Tolak</button></td> \n";
		$html 	.= "</tr>\n";
		$html .= "</table>\n";
		$html .="</form>\n";
		echo $html;
	}
	
	function detaildetail_bm($npp)
	{
		$data=$this->_self_flagging->get_detail_bm($npp);
		
			$html    ="";
			$html .= "<form method='post' action='".site_url('self_flagging/kirimdetailsbm/')."' id='frm_kirimdetail'>\n";
			$html   .="DPK menggunakan Saldo Rata - Rata";
			$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report1'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>TANGGAL</th>\n
						<th align='center'>NPP</th>\n
						<th align='center'>CIF</th>\n
						<th align='center'>TYPE</th>\n	
						<th align='center'>NAMA</th>\n
						<th align='center'>DPK</th>\n	
						<th align='center'>INVESTASI</th>\n
						<th align='center'>BANCAS</th>\n
						<th align='center'>AUM</th>\n
						<th align='center'>SEGMENT</th>\n
						<th align='center'>AKSI <input type='checkbox' id='selectall' onclick='check();'></th>\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
		$sumdpk = 0;
			$suminvestasi = 0;
			$sumbancas = 0;
			$sumaum=0;
			foreach($data as $row)
			{
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->BASELINE_DATE."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SALES_ID."</td> \n";
					$html .= "<input type='hidden' id='salesid' name='salesid' value='".$row->SALES_ID."' />\n";
					$html .= "<input type='hidden' id='salestype' name='salestype' value='".$row->SALES."' />\n";
					$html .= "<td width='' align='center'  >".$row->CIF_KEY."</td> \n";
					$html .= "<td width='' align='center'>".$row->CUST_TYPE."</td> \n";
					$html .= "<td width='' align='center'  >".$row->CUST_NAME."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->DPK,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->INVESTASI,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->BANCAS,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->AUM,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SEGMENTASI."</td> \n";
					$html .= " <td width='' align='center'  ><input type='checkbox' name='cek[]' id='cek[]' onclick='checkkcl();' value='".$row->CIF_KEY."'></td> \n";
					$html .= "</tr> \n";
					$sumdpk = $sumdpk + $row->DPK;
				$suminvestasi = $suminvestasi + $row->INVESTASI;
				$sumbancas = $sumbancas + $row->BANCAS;
				$sumaum = $sumaum + $row->AUM;
			}
				
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='11' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html 	.= "<tr  bgcolor='#66FF66'>\n";
		$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Total</span></td>\n";	
		
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumdpk,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($suminvestasi,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumbancas,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumaum,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='center' colspan='2' class='kecil'><input type='submit' value='Kirim' style='display:none'/></td> \n";
				//$html .= "<td width='' align='center' class='kecil'><button onclick=kirimbm(".$row->SALES_ID.")><b>Kirim</b></button></td> \n";
		$html 	.= "</tr>\n";
		$html .= "</table> \n";
		$html .= "</form> \n";
		echo $html;
	}
	
	function spv()
	{
		#$this->detail_spv();
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SUPERVISOR','SLN','ADMIN');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/3');}
		$this->load->view('self_flagging/pra_flagging_spv');
	}
	
	function report()
	{
		
		/*
		*/
		#$this->detail_spv();
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES','SUPERVISOR','PEMIMPIN_CABANG','PIMPINAN_CABANG','SLN','ADMIN','HLB','WEM');
	//	if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/3');}
		$this->load->view('self_flagging/pra_flagging_report');
	}
	
	function detail_bm()
	{
		$data=$this->_self_flagging->detail_bm();
		
			$html    ="";
			$html   .="Report Detail Usulan Flagging";
			$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report1'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>NPP</th>\n
						<th align='center'>NAMA</th>\n
						<th align='center'>SALES TYPE</th>\n
						<th align='center'>CR</th>\n		
						<th align='center'>BB</th>\n	
						<th align='center'>TOTAL</th>\n
						<th align='center'>AUM CR</th>\n
						<th align='center'>AUM BB</th>\n
						<th align='center'>TOTAL AUM</th>\n
						<th align='center'>INFO</th>\n
						<th align='center'>KEPUTUSAN</th>\n
						<th align='center'>KETERANGAN</th>\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
			foreach($data as $row)
			{
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->SALES_ID."</td> \n";
					$html .= "<td width='' align='center'>".$row->USER_NAME."</td> \n";
					$html .= "<td width='' align='center'>".$row->SALES_TYPE."</td> \n";
					$html .= "<td width='' align='center'>".$row->CR."</td> \n";
					$html .= "<td width='' align='center'>".$row->BB."</td> \n";
					$html .= "<td width='' align='center'>".$row->JUMLAH_CIF."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUMCR,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUMBB,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUM,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'><button onclick='detailbm(".$row->SALES_ID.")'>Detail</button></td> \n";
					$html .= "<td width='' align='center'><button onclick='kirimsln(".$row->SALES_ID.")'>Setuju</button>&nbsp;<button onclick='balikspv(".$row->SALES_ID.")'>Tidak Setuju</button></td> \n";
					$html .= "<td width='' align='center'>".$row->KETERANGAN."</td> \n";
					$html .= "</tr> \n";
					$i++;
			}
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='13' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	function bm()
	{
		#$this->detail_spv();
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('PEMIMPIN_CABANG', 'PIMPINAN_CABANG','PEMIMPIN_KLN-KK','SLN','ADMIN');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/3');}
		$this->load->view('self_flagging/pra_flagging_bm');
	}
	
	function detail_sln()
	{
		$data=$this->_self_flagging->detail_sln();
		
			$html    ="";
			$html   .="Report Detail Usulan Flagging";
			$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report1'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>NPP</th>\n
						<th align='center'>NAMA</th>\n		
						<th align='center'>SALES TYPE</th>\n
						<th align='center'>CR</th>\n		
						<th align='center'>BB</th>\n	
						<th align='center'>TOTAL</th>\n
						<th align='center'>AUM CR</th>\n
						<th align='center'>AUM BB</th>\n
						<th align='center'>TOTAL AUM</th>\n
						<th align='center'>INFO</th>\n
						<th align='center'>AKSI</th>\n
						<th align='center'>KETERANGAN</th>\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
			foreach($data as $row)
			{
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->SALES_ID."</td> \n";
					$html .= "<td width='' align='center'>".$row->USER_NAME."</td> \n";
					$html .= "<td width='' align='center'>".$row->SALES_TYPE."</td> \n";
					$html .= "<td width='' align='center'>".$row->CR."</td> \n";
					$html .= "<td width='' align='center'>".$row->BB."</td> \n";
					$html .= "<td width='' align='center'>".$row->JUMLAH_CIF."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUMCR,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUMBB,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'>".number_format($row->AUM,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'><button onclick='detailsln(".$row->SALES_ID.")'>Detail</button></td> \n";
					$html .= "<td width='' align='center'><button onclick='generate_naskel(".$row->SALES_ID.")'>Generate Naskel</button>&nbsp;<button onclick='balikbm(".$row->SALES_ID.")'>Tolak</button></td> \n";
					$html .= "<td width='' align='center'>".$row->KETERANGAN."</td> \n";
					$html .= "</tr> \n";
			}
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='13' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	function sln()
	{
		#$this->detail_spv();
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('ADMIN','SLN','HLB','WEM');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/3');}
		$this->load->view('self_flagging/pra_flagging_sln');
	}
	function detaildetail_sln($npp)
	{
		$data=$this->_self_flagging->get_detail_sln($npp);
		
			$html    ="";
			$html   .="<div id='form_detail'>";
			$html .= "<form method='post' action='".site_url('self_flagging/kirimdetails/')."' id='frm_kirimdetail'>\n";
			$html   .="DPK menggunakan Saldo Rata - Rata";
			$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report1'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>TANGGAL</th>\n
						<th align='center'>NPP</th>\n
						<th align='center'>CIF</th>\n
						<th align='center'>TYPE</th>\n	
						<th align='center'>NAMA</th>\n
						<th align='center'>DPK</th>\n	
						<th align='center'>INVESTASI</th>\n
						<th align='center'>BANCAS</th>\n
						<th align='center'>AUM</th>\n
						<th align='center'>SEGMENT</th>\n
						<th align='center'>AKSI <input type='checkbox' id='selectall' onclick='check();'></th>\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
		$sumdpk = 0;
			$suminvestasi = 0;
			$sumbancas = 0;
			$sumaum=0;
			foreach($data as $row)
			{
					
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='left'  >".$row->BASELINE_DATE."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SALES_ID."</td> \n";
					$html .= "<input type='hidden' id='salesid' name='salesid' value='".$row->SALES_ID."' />\n";
					$html .= "<td width='' align='center'  >".$row->CIF_KEY."</td> \n";
					$html .= "<td width='' align='center'>".$row->CUST_TYPE."</td> \n";
					$html .= "<td width='' align='center'  >".$row->CUST_NAME."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->DPK,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->INVESTASI,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->BANCAS,0,'.',',')."</td> \n";
					$html .= "<td width='' align='right'>".number_format($row->AUM,0,'.',',')."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SEGMENTASI."</td> \n";
					$html .= " <td width='' align='center'  ><input type='checkbox' name='cek[]' id='cek[]' value='".$row->CIF_KEY."'></td> \n";
					#$html .= " <td width='' align='center'  >".form_checkbox('cek[]',$row->CIF_KEY,FALSE)."</td> \n";
					$html .= "</tr> \n";
					$sumdpk = $sumdpk + $row->DPK;
				$suminvestasi = $suminvestasi + $row->INVESTASI;
				$sumbancas = $sumbancas + $row->BANCAS;
				$sumaum = $sumaum + $row->AUM;
			}
				
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='11' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html 	.= "<tr  bgcolor='#66FF66'>\n";
		$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Total</span></td>\n";	
		
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumdpk,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($suminvestasi,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumbancas,0,'.',',')."</b></td> \n";
				$html .= "<td width='' align='right' class='kecil'><b>".number_format($sumaum,0,'.',',')."</b></td> \n";
				$html .= "<td width='' colspan='2' align='center' class='kecil'><input type='submit' value='Kirim' style='Display:none;'/></td> \n";
				#$html .= "<td width='' align='center' class='kecil'><button onclick='kirimdetail(".$row->SALES_ID.")'>Kirim</button></td> \n";
		$html 	.= "</tr>\n";
		$html .= "</table>\n";
		$html .= "</form>\n";
		$html .="<div id='loading_box' style='display:none'>";
		$html .="<img src='".ICONS."loading_bar.gif' alt='Loading....' width='350' height='19' />";
		$html .="</div>";
		echo $html;
	}
	function kirimdetailsspv()
	{
		$npp=$this->input->post('salesid');
		foreach ($this->input->post('cek') as $key => $value)
		{
			#echo "Index {$key}'s value is {$value}.";
			$kirim_sln=$this->_self_flagging->kirim_detail_bm($npp,$value);
		}
		
		redirect(site_url('self_flagging/spv'));
	}
	function kirimdetailsbm()
	{
		$npp=$this->input->post('salesid');
		foreach ($this->input->post('cek') as $key => $value)
		{
			#echo "Index {$key}'s value is {$value}.";
			$kirim_sln=$this->_self_flagging->kirim_detail_sln($npp,$value);
		}
		
		redirect(site_url('self_flagging/bm'));
	}
	function kirimdetails()
	{
		$npp=$this->input->post('salesid');
		foreach ($this->input->post('cek') as $key => $value)
		{
			#echo "Index {$key}'s value is {$value}.";
			$kirim_sln=$this->_self_flagging->generate_naskel_detail($npp,$value);
		}
		
		redirect(site_url('self_flagging/sln'));
	}
	//untuk sales lama
	function kirimdetailslama()
	{
		$npp=$this->input->post('salesid');
		foreach ($this->input->post('cek') as $key => $value)
		{
			#echo "Index {$key}'s value is {$value}.";
			$kirim_sln=$this->_self_flagging->generate_naskel_detail($npp,$value);
		}
		
		redirect(site_url('self_flagging/sln'));
	}
	function waiting()
	{
		$this->load->view('self_flagging/waiting');
	}
	function tutup()
	{
		$this->load->view('self_flagging/tutup');
	}
	function unflag()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SLN', 'ADMIN');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}
		
		$data = $this->list_user();	
		
		$this->load->view('self_flagging/unflagging', $data);		
	}
	function unflageceran()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SLN', 'ADMIN');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}
		
		$data = $this->list_user();	
		
		$this->load->view('self_flagging/unflaggingeceran', $data);		
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
		$grid_js 			= build_grid_js('search_list',site_url("/self_flagging/get_sales"),$colModel,'a.ID','ASC',$gridParams,$buttons);
		$data['js_grid'] 	= $grid_js;
		return $data;
	}
	function unflagnaskel($npp)
	{
		$kirim_sln=$this->_self_flagging->unflag_naskel($npp);
		redirect(site_url('self_flagging/unflag'));
	}
	
		function unflagnaskeleceran()
	{
		$data['cif']=$this->input->post('cif');
		$kirim_sln=$this->_self_flagging->unflag_naskel_eceran($data);
		redirect(site_url('self_flagging/unflageceran'));
	}
	function unflagsuper()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SLN', 'ADMIN');
		if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/6');}
		
		$data = $this->list_user();	
		
		$this->load->view('self_flagging/unflaggingsuper', $data);		
	}
	function unflagnaskelsuper()
	{
		$data['npp']=$this->input->post('npp');
		$kirim_sln=$this->_self_flagging->reject_naskel($data);
		redirect(site_url('self_flagging/unflagsuper'));
	}
	function getNaskel($npp=0)
	{
		$data=$this->_self_flagging->get_naskel($npp);
		
			$html    ="";
			$html   .="Report Naskel";
			$html 	.= "<table width='50%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report1'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>NPP</th>\n
						<th align='center'>JUMLAH NASKEL</th>\n
						<th align='center' colspan=2>AKSI</th>\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
			foreach($data as $row)
			{
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SALES_ID."</td> \n";
					$html .= "<td width='' align='center'  >".$row->JUMLAH."</td> \n";
					$html .= "<td width='' align='center'  ><button onclick='detail(".$row->SALES_ID.")'>Detail    </button></td> \n";
					$html .= "<td width='' align='center'  ><button onclick='unflag_naskel(".$row->SALES_ID.")'>UNFLAG ALL</button></td> \n";
					$html .= "</tr> \n";
			}
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='4' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
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
	function getNaskelDetail($npp=0)
	{
		$data=$this->_self_flagging->get_naskel_detail($npp);
		
			$html    ="";
			$html   .="Report Naskel";
			$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report1'>\n";
			$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center'>No.</th>\n
						<th align='center'>NPP</th>\n
						<th align='center'>CIF KEY</th>\n
						<th align='center'>TYPE</th>\n
						<th align='center'>NAMA</th>\n
						<th align='center' colspan=2>AKSI</th>\n
					</tr>\n";
		if($data){
		$i = 1; //counter untuk nomer
		$color = ($i%2)?"#ffffff":"#eeeeee";
			foreach($data as $row)
			{
					$html .= "<tr bgcolor='$color'>\n";
					$html .= "<td width='' align='center'>".$i++."</td> \n";
					$html .= "<td width='' align='center'  >".$row->SALES_ID."</td> \n";
					$html .= "<td width='' align='center'  >".$row->CIF_KEY."</td> \n";
					$html .= "<td width='' align='center'  >".$row->CUST_TYPE."</td> \n";
					$html .= "<td width='' align='center'  >".$row->CUST_NAME."</td> \n";
					$html .= " <td width='' align='center'  ><input type='checkbox' name='cek[]' id='cek[]' value='".$row->CIF_KEY."'></td> \n";
					$html .= "</tr> \n";
			}
		}else {
				$html .= "<tr>\n";
				$html .= "	<td bgcolor='#ffffff' colspan='6' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";	
				$html .= "</tr>\n";
		}
		$html .= "</table>";
		echo $html;
	}
	
	#untuk modul insert naskel sales lama
	function sales_tambah()
	{
		$tgl=date('j');
		$data= $this->list_nasabah_ft();
		if($tgl >=1 && $tgl <=7){redirect('self_flagging/tutup');}
		$this->load->view('self_flagging/sales_tambah',$data);
	}
	
#==============================================
	function sales_tambah_new()
	{
		$tgl=date('j');
		$data= $this->list_nasabah_ft();
		if($tgl >=1 && $tgl <=7){redirect('self_flagging/tutup');}
		$this->load->view('self_flagging/sales_list',$data);
	}

    
    public function json() {
        header('Content-Type: application/json');
        echo $this->_self_flagging->json();
    }

	

#==============================================

	
	function get_list_tambahan($id)
	{
			$sales = $_SESSION['SALES_ID'];
			$grade = $_SESSION['GRADE'];
			$sumtambahcr = $this->_self_flagging->total_tambah_CR($id);
		
			if($sumtambahcr)
			{
				$sumcrcif = $sumtambahcr[0]->TOTAL_CR;
			}
			else
			{
				$sumcrcif = 0;
			}
			$sumtambahbb =  $this->_self_flagging->total_tambah_BB($id);
			
			if($sumtambahbb)
			{
			$sumbbcif = $sumtambahbb[0]->TOTAL_BB;
			}
			else
			{
				$sumbbcif = 0;
			}
			
			$sudahcek = $this->_self_flagging->sudah_cek($id);
			
			if($sudahcek)
			{
				$sudahcekid = $sudahcek[0]->ACTION_CEK;
			}
			else
			{
				$sudahcekid = 0;
			}
			
			$sudahkirim = $this->_self_flagging->sudah_kirim($id);
			
			if($sudahkirim)
			{
				$sudahkirimid = $sudahkirim[0]->STATUS_APP;
			}
			else
			{
				$sudahkirimid = 0;
			}
			
			$data = $this->_self_flagging->get_list_nasabah_tambahan($id);
			
			if($sudahkirimid==1)
			{
				$html = "<button disabled>Tambah Nasabah</button>";
			}
			else
			{
				if(((($sales==3||$sales==4||$sales==5||$sales==6||$sales>=23)||(($sales==1||$sales==2)&&($grade>=7&&$grade<=9))) && ($sumcrcif<150||$sumbbcif<25))||(($sales==7||$sales==8)&& ($sumbbcif<150||$sumcrcif<25))||(($sales==1||$sales==2||$sales==20||$sales==21||$sales==22)&&($grade>=9)&& $sumcrcif<150))
				{
					
					$html = "<button class='tambah'>Tambah Nasabah</button>";
					#$html = "<button disabled>Tambah Nasabah</button>";
				}
				else
				{
					$html = "<button disabled>Tambah Nasabah</button>";
				}
			}
			
			if($sudahkirimid==1)
			{
			$html.= "&nbsp;<button disabled>Cek Usulan</button>\n";
			}
			else
			{
			$html.= "&nbsp;<button class='cek'>Cek Usulan</button>\n";
			}
			
			if($sudahcekid==1&&$sudahkirimid==0)
			{
			$html.= "&nbsp;<button class='clean'>Cleansing</button>\n";
			$html.= "&nbsp;<button class='kirim'>Kirim Usulan</button>\n";
			}
			else
			{
			$html.= "&nbsp;<button disabled>Cleansing</button>\n";
			$html.= "&nbsp;<button disabled>Kirim Usulan</button>\n";
			}
			
			$html.= "\n";
			$html.= "<table width='70%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' id='tbl_tambah'>\n";
			$html.= "<tr bgcolor='#A5D3FA'>\n";
			$html.= "<th align='center' class='kecil'>No</th>\n";
			$html.= "<th align='center' class='kecil'>JENIS</th>\n";
			$html.= "<th align='center' class='kecil'>CIF</th>\n";
			$html.= "<th align='center' class='kecil'>JENIS CIF</th>\n";
			$html.= "<th align='center' class='kecil'>NAMA NASABAH</th>\n";
			$html.= "<th align='center' class='kecil'>CIF UTAMA</th>\n";
			$html.= "<th align='center' class='kecil'>HUBUNGAN DENGAN UTAMA</th>";
			$html.= "<th align='center' class='kecil'>STATUS</th>\n";
			$html.= "<th align='center' class='kecil'>APPROVAL</th>\n";
			$html.= "<th align='center' class='kecil'>TANGGAL KIRIM</th>\n";
			$html.= "</tr>\n";
			$i = 1; //counter untuk nomer
			$color = "#ffffff";
			if ($data)
			{
				foreach ($data as $row)
				{
					$color = ($i % 2) ? "#ffffff" : "#eeeeee";
					$html.= "<tr bgcolor='$color'>\n";
					$html.= "<td align='center' class='kecil'>$i</td>\n";
					$html.= "<td align='center' class='kecil'>".$row['JENIS_TAMBAHAN']."</td>\n";
					$html.= "<td align='center' class='kecil'>".$row['CIF_KEY']."</td>\n";
					$html.= "<td align='center' class='kecil'>".$row['CUST_TYPE']."</td>\n";
					$html.= "<td align='center' class='kecil'>".$row['CUST_NAME']."</td>\n";
					$html.= "<td align='center' class='kecil'>".$row['CIF_UTAMA']."</td>\n";
					$html.= "<td align='center' class='kecil'>".$row['HUBUNGAN_DENGAN_UTAMA']."</td>\n";
					$html.= "<td align='center' class='kecil'>".$row['STATUS']."</td>\n";
					$html.= "<td align='center' class='kecil'>".$row['STATUS_APP']."</td>\n";
					$html.= "<td align='center' class='kecil'>".$row['SEND_DATE']."</td>\n";
					$html.= "</tr>\n";
					$i++;
				}
			}
			$html.= "</table>\n";
			echo $html;
	}
	
	function get_nasabah_ft($id)
	{
		$salesid = $_SESSION['SALES_ID'];
		$npp = $_SESSION['ID'];
		$this->load->library('flexigrid');

		$valid_fields = array('CIF_KEY', 'CUST_TYPE','NAMA_NASABAH');

		$this->flexigrid->validate_post('CIF', 'asc', $valid_fields);
		
		$branchcode = $_SESSION['BRANCH_ID'];
		$records = $this->_self_flagging->nasabah_ft($npp);
		$this->output->set_header($this->config->item('json_sheader'));

		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array(
				$row->CIF,
				$row->CIF,
				$row->CUST_TYPE,
				strtoupper($row->NAMA_NASABAH),
			);
		}
		//Print please
		if (isset($record_items))
		{
			$this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
		
		}
		else
		{
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
		}
	}
	function list_nasabah_ft()
	{
		$this->load->helper('flexigrid');

		$colModel['CIF'] = array('CIF', 100, TRUE, 'center', 1);
		$colModel['CUST_TYPE'] = array('TIPE', 20, TRUE, 'left', 1);
		$colModel['CUST_NAME'] = array('CUST_NAME', 200, TRUE, 'left', 0);
		

		$gridParams = array(
			'width' => '330',
			'height' => 'auto',
			'rp' => 10,
			'rpOptions' => '[10,25,50,100]',
			'pagestat' => '{from} to {to} of {total} items.',
			'blockOpacity' => 0.5,
			'title' => 'LIST ',
			'showTableToggleBtn' => false
		);
			$buttons[] = array('Pilih', 'add', 'pilih_data');
		$buttons[] = array('separator');
		$grid_js = build_grid_js('search_list', site_url("/self_flagging/get_nasabah_ft"), $colModel, 'CIF', 'ASC', $gridParams, $buttons);
		$data['js_grid'] = $grid_js;
		return $data;
	}
	function list_nasabah_tambahan()
	{
		switch($_SESSION['USER_LEVEL'])
		{
			#case 'SALES':
			#	$this->load->view('usulan_nasabah/list_nasabah_remove_page');
			#break;
			case 'SUPERVISOR':
			case 'PEMIMPIN_KLN-KK':
				$data = $this->list_user_tambahan();
				$this->load->view('self_flagging/list_nasabah_tambahan_spv',$data);
			break;
			case 'PEMIMPIN_CABANG':
			case 'PIMPINAN_CABANG':
				$data = $this->list_user_tambahan();
				$this->load->view('self_flagging/list_nasabah_tambahan_bm',$data);
			break;
			case 'SLN':
			case 'HLB':
			case 'WEM':
				$data = $this->list_user_tambahan();
				$this->load->view('self_flagging/list_nasabah_tambahan_sln',$data);
			break;
		}
	}
	function list_user_tambahan()
	{
		$this->load->helper('flexigrid');

		$colModel['ID'] = array('NPP', 40, TRUE, 'center', 2);
		$colModel['USER_NAME'] = array('NAMA', 200, TRUE, 'center', 1);
		$colModel['SALES_TYPE'] = array('SALES', 50, TRUE, 'center', 1);
		$colModel['SPV'] = array('SPV', 50, TRUE, 'left', 1);
		$colModel['BRANCH_NAME'] = array('BRANCH', 100, TRUE, 'center', 1);
		$colModel['REGION'] = array('REGION', 20, TRUE, 'center', 1);

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
		$grid_js = build_grid_js('search_list_user3', site_url("/self_flagging/get_sales_tambahan"), $colModel, 'a.ID', 'ASC', $gridParams, $buttons);
		$data['js_grid'] = $grid_js;
		return $data;
	}
	function get_sales_tambahan()
	{
		$this->load->library('flexigrid');

		$valid_fields = array('ID', 'USER_NAME', 'SALES_TYPE', 'SPV' ,'BRANCH_NAME' ,'REGION');

		$this->flexigrid->validate_post('ID', 'asc', $valid_fields);
	
		$records = $this->_self_flagging->get_sales_nas_kelu();
		$this->output->set_header($this->config->item('json_header'));

		foreach ($records['records']->result() as $row)
		{
			$record_items[] = array($row->ID,
				$row->ID,
				strtoupper($row->USER_NAME),
				strtoupper($row->SALES_TYPE),
				$row->SPV,
				$row->BRANCH_NAME,
				$row->REGION
			);
		}
		//Print please
		if (isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
		else
			$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}
	function tolak_all_tambahan()
	{
		if(!$this->isAjax())
			redirect('forbiden/index/2');
		
		$npp= $_POST['npp'];
		#$this->_nasabah_kel_usulan->log_tolak_tambahan_all($npp);
		$response = $this->_self_flagging->tolak_tambahan_all($npp);
		echo $response;
	}
	function get_list_tambahan_sln($id)
	{
		
		$user	= $this->_report->get_user_usulan_tambahan_lama($id);
		$data = $this->_self_flagging->get_list_nasabah_tambahan25($id);
		
		$npp = $user[0]->ID;
		$salesid = $user[0]->SALES;
		$sales = $user[0]->SALES_TYPE;
		$name = strtoupper($user[0]->USER_NAME);
		$grade =$user[0]->GRADE;
		$branch=$user[0]->BRANCH;
		$spv = $user[0]->SPV;
		$ket = ($month != 0) ? date('F Y', strtotime("01-$month-$year")) : '';
		
		$html = "";
		$html .= "NPP : " . $npp . "<br />\n";
		$html .= "NAMA : " . $name . "<br />\n";
		$html .= "SALES TYPE : " . $sales . "<br />\n";
		$html .= "<br />\n";
		$html .= "<br />\n";

		$html .= "<div id='dtbl_naskel_tambah'>\n";
		$html .= "<button onclick='setujusln()'>Submit</button>&nbsp;&nbsp;";
		$html .= "<button class='tolakall' style='display:none'>Tidak Setuju</button>&nbsp;&nbsp;";
		$html .= "<form method='post' action='#' id='frm_tambahan'>\n";
		$html .= "<table cellpadding='10' cellspacing='1' bgcolor='#cccccc' id='tbl_naskel_tambahan'>\n";
		$html .= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n 
						<th align='center' class='kecil'>PILIH<br />ALL<input type='checkbox' id='selectall' onclick='check();'></th>\n ";
		$html .="
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>JENIS PENAMBAHAN</th>\n
						<th align='center' class='kecil'>CIF USULAN</th>\n
						<th align='center' class='kecil'>JENIS CIF</th>\n								
						<th align='center' class='kecil'>NAMA NASABAH</th>\n
						<th align='right' class='kecil'>DPK USULAN</th>\n
						<th align='right' class='kecil'>AUM USULAN</th>\n
						<th align='right' class='kecil'>CIF UTAMA</th>\n
						<th align='center' class='kecil'>NAMA NASABAH</th>\n
						<th align='center' class='kecil'>HUBUNGAN DENGAN USULAN</th>\n
						<th align='right' class='kecil'>DPK UTAMA</th>\n
						<th align='right' class='kecil'>AUM UTAMA</th>\n
						<th align='center' class='kecil'>APPROVAL</th>\n
						";
		
		$html .="</tr>\n";
					

		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if ($data)
		{
			foreach ($data as $row)
			{
				$color = ($i % 2) ? "#ffffff" : "#eeeeee";
				$html .= "<tr class='nas_kel_tambah' id='".$row['CIF_KEY']."' bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>" . $i++ . "</td> \n";
				if(substr($row['STATUS'],0,2)=='OK')
				{
					$html .= "<td width='' align='center' class='kecil'><input type='checkbox' name='cek[]' id='cek[]' value='".$row[CIF_KEY]."'></td> \n";
				}
				else
				{
					$html .= "<td width='' align='center' class='kecil'></td> \n";
				}
				$html .= "<input type='hidden' id='salesid' name='salesid' value='".$row['SALES_ID']."' />\n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['STATUS']. "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['JENIS_PENAMBAHAN'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CIF_KEY'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_TYPE'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_NAME'] . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['DPK'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['AUM'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CIF_UTAMA'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_NAME_UTAMA'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['HUBUNGAN_DENGAN_UTAMA'] . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['DPK_UTAMA'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['AUM_UTAMA'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['STATUS_APRROVAL'] . "</td> \n";
				
				$html .= "</tr> \n";
			}
		}
		else
		{
			$html .= "<tr>\n";
			$html .= "	<td bgcolor='#ffffff' colspan='16' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";
			$html .= "</tr>\n";
		}
		$html .= "</table>  <br /> </div>\n";
		$html .="</form>\n";
		
		
		echo $html;
	}
	function get_list_tambahan_spv($id)
	{
		
		$user	= $this->_report->get_user_usulan_tambahan_lama($id);
		$data = $this->_self_flagging->get_list_nasabah_tambahan25($id);
		
		$npp = $user[0]->ID;
		$salesid = $user[0]->SALES;
		$sales = $user[0]->SALES_TYPE;
		$name = strtoupper($user[0]->USER_NAME);
		$grade =$user[0]->GRADE;
		$branch=$user[0]->BRANCH;
		$spv = $user[0]->SPV;
		$ket = ($month != 0) ? date('F Y', strtotime("01-$month-$year")) : '';
		
		$html = "";
		$html .= "NPP : " . $npp . "<br />\n";
		$html .= "NAMA : " . $name . "<br />\n";
		$html .= "SALES TYPE : " . $sales . "<br />\n";
		$html .= "<br />\n";
		$html .= "<br />\n";

		$html .= "<div id='dtbl_naskel_tambah'>\n";
		$html .= "<button onclick='setujuspv()'>Submit</button>&nbsp;&nbsp;";
		$html .= "<button class='tolakall' style='display:none'>Tidak Setuju</button>&nbsp;&nbsp;";
		$html .= "<form method='post' action='#' id='frm_tambahan'>\n";
		$html .= "<table cellpadding='10' cellspacing='1' bgcolor='#cccccc' id='tbl_naskel_tambahan'>\n";
		$html .= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n 
						<th align='center' class='kecil'>PILIH<br />ALL<input type='checkbox' id='selectall' onclick='check();'></th>\n ";
		$html .="
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>JENIS PENAMBAHAN</th>\n
						<th align='center' class='kecil'>CIF USULAN</th>\n
						<th align='center' class='kecil'>JENIS CIF</th>\n								
						<th align='center' class='kecil'>NAMA NASABAH</th>\n
						<th align='right' class='kecil'>DPK USULAN</th>\n
						<th align='right' class='kecil'>AUM USULAN</th>\n
						<th align='right' class='kecil'>CIF UTAMA</th>\n
						<th align='center' class='kecil'>NAMA NASABAH</th>\n
						<th align='center' class='kecil'>HUBUNGAN DENGAN USULAN</th>\n
						<th align='right' class='kecil'>DPK UTAMA</th>\n
						<th align='right' class='kecil'>AUM UTAMA</th>\n
						<th align='center' class='kecil'>APPROVAL</th>\n
						";
		
		$html .="</tr>\n";
					

		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if ($data)
		{
			foreach ($data as $row)
			{
				$color = ($i % 2) ? "#ffffff" : "#eeeeee";
				$html .= "<tr class='nas_kel_tambah' id='".$row['CIF_KEY']."' bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>" . $i++ . "</td> \n";
				if(substr($row['STATUS'],0,2)=='OK')
				{
					$html .= "<td width='' align='center' class='kecil'><input type='checkbox' name='cek[]' id='cek[]' value='".$row[CIF_KEY]."'></td> \n";
				}
				else
				{
					$html .= "<td width='' align='center' class='kecil'></td> \n";
				}
				$html .= "<input type='hidden' id='salesid' name='salesid' value='".$row['SALES_ID']."' />\n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['STATUS']. "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['JENIS_PENAMBAHAN'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CIF_KEY'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_TYPE'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_NAME'] . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['DPK'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['AUM'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CIF_UTAMA'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_NAME_UTAMA'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['HUBUNGAN_DENGAN_UTAMA'] . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['DPK_UTAMA'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['AUM_UTAMA'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['STATUS_APRROVAL'] . "</td> \n";
				
				$html .= "</tr> \n";
			}
		}
		else
		{
			$html .= "<tr>\n";
			$html .= "	<td bgcolor='#ffffff' colspan='16' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";
			$html .= "</tr>\n";
		}
		$html .= "</table>  <br /> </div>\n";
		$html .="</form>\n";
		
		
		echo $html;
	}
	function get_list_tambahan_bm($id)
	{
		
		$user	= $this->_report->get_user_usulan_tambahan($id);
		$data = $this->_self_flagging->get_list_nasabah_tambahan25($id);
		
		$npp = $user[0]->ID;
		$salesid = $user[0]->SALES;
		$sales = $user[0]->SALES_TYPE;
		$name = strtoupper($user[0]->USER_NAME);
		$grade =$user[0]->GRADE;
		$branch=$user[0]->BRANCH;
		$spv = $user[0]->SPV;
		$ket = ($month != 0) ? date('F Y', strtotime("01-$month-$year")) : '';
		
		$html = "";
		$html .= "NPP : " . $npp . "<br />\n";
		$html .= "NAMA : " . $name . "<br />\n";
		$html .= "SALES TYPE : " . $sales . "<br />\n";
		$html .= "<br />\n";
		$html .= "<br />\n";

		$html .= "<div id='dtbl_naskel_tambah'>\n";
		$html .= "<button onclick='setujubm()'>Submit</button>&nbsp;&nbsp;";
		$html .= "<button class='tolakall' style='display:none'>Tidak Setuju</button>&nbsp;&nbsp;";
		$html .= "<form method='post' action='#' id='frm_tambahan'>\n";
		$html .= "<table cellpadding='10' cellspacing='1' bgcolor='#cccccc' id='tbl_naskel_tambahan'>\n";
		$html .= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n 
						<th align='center' class='kecil'>PILIH<br />ALL<input type='checkbox' id='selectall' onclick='check();'></th>\n ";
		$html .="
						<th align='center' class='kecil'>STATUS</th>\n
						<th align='center' class='kecil'>JENIS PENAMBAHAN</th>\n
						<th align='center' class='kecil'>CIF USULAN</th>\n
						<th align='center' class='kecil'>JENIS CIF</th>\n								
						<th align='center' class='kecil'>NAMA NASABAH</th>\n
						<th align='right' class='kecil'>DPK USULAN</th>\n
						<th align='right' class='kecil'>AUM USULAN</th>\n
						<th align='right' class='kecil'>CIF UTAMA</th>\n
						<th align='center' class='kecil'>NAMA NASABAH</th>\n
						<th align='center' class='kecil'>HUBUNGAN DENGAN USULAN</th>\n
						<th align='right' class='kecil'>DPK UTAMA</th>\n
						<th align='right' class='kecil'>AUM UTAMA</th>\n
						<th align='center' class='kecil'>APPROVAL</th>\n
						";
		
		$html .="</tr>\n";
					

		$i = 1; //counter untuk nomer
		$color = "#ffffff";
		if ($data)
		{
			foreach ($data as $row)
			{
				$color = ($i % 2) ? "#ffffff" : "#eeeeee";
				$html .= "<tr class='nas_kel_tambah' id='".$row['CIF_KEY']."' bgcolor='$color'>\n";
				$html .= "<td width='' align='center' class='kecil'>" . $i++ . "</td> \n";
				if(substr($row['STATUS'],0,2)=='OK')
				{
					$html .= "<td width='' align='center' class='kecil'><input type='checkbox' name='cek[]' id='cek[]' value='".$row[CIF_KEY]."'></td> \n";
				}
				else
				{
					$html .= "<td width='' align='center' class='kecil'></td> \n";
				}
				$html .= "<input type='hidden' id='salesid' name='salesid' value='".$row['SALES_ID']."' />\n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['STATUS']. "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['JENIS_PENAMBAHAN'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CIF_KEY'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_TYPE'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_NAME'] . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['DPK'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['AUM'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CIF_UTAMA'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['CUST_NAME_UTAMA'] . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['HUBUNGAN_DENGAN_UTAMA'] . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['DPK_UTAMA'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='right' class='kecil'>" . number_format($row['AUM_UTAMA'], 2, '.', ',') . "</td> \n";
				$html .= "<td width='' align='center' class='kecil'>" . $row['STATUS_APRROVAL'] . "</td> \n";
				
				$html .= "</tr> \n";
			}
		}
		else
		{
			$html .= "<tr>\n";
			$html .= "	<td bgcolor='#ffffff' colspan='16' align='center'><span style='color:#c00'>Tidak ada data</span></td>\n";
			$html .= "</tr>\n";
		}
		$html .= "</table>  <br /> </div>\n";
		$html .="</form>\n";
		
		
		echo $html;
	}
}