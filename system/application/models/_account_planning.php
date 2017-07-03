<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _account_planning extends Model {

	function _account_planning()
	{
		parent::Model();
		$this->CI =& get_instance();
	}

	#-------------------------------------
	# 	Get Account Planning Report
	#-------------------------------------	
	function get_report_by_sales1($id, $m, $y)
	{	
		$where = ($id) ? array('SALES_ID'=>$id,'MONTH' => $m,'YEAR'=>$y) : array('MONTH' => $m,'YEAR'=>$y);
		//$where = array('SALES_ID'=>$id,'MONTH' => $m,'YEAR'=>$y);
		//$this->db->where('SALES_ID',$id);
		//$this->db->where('MONTH',$m);
		//$this->db->where('YEAR',$y);
		$this->db->where($where);
		return $this->db->get('ACCOUNT_PLANNING')->result_array();
	}	
	
	function get_report_by_sales($id, $m, $y)
	{	
		$sql="
				select 
				a.ID,
				a.SALES_ID,
				a.CIF_KEY,
				a.CUST_NAME,
				a.PRODUCT_ID,
				b.PRODUCT_NAME,
				a.CAT_ID,
				c.kategori,
				a.RENCANA,
				a.TARGET,
				a.MONTH,
				a.YEAR,
				a.upload_date,
				a.is_check
				from new_account_planning a
				join PIPE_LOOKUP_PRODUCT b
				on a.product_id = b.id
				join PIPELINE_CATEGORY c
				on a.cat_id = c.id
				where sales_id ='$id' and month='$m' and year='$y' and a.is_check = 2
			";
		return $this->db->query($sql)->result_array();
		
	}	
	
	function get_report_tmp_ap($id, $m, $y)
	{	
		$sql="
				select 
				a.ID,
				a.SALES_ID,
				a.CIF_KEY,
				a.CUST_NAME,
				a.PRODUCT_ID,
				b.PRODUCT_NAME,
				a.CAT_ID,
				c.kategori,
				a.RENCANA,
				a.TARGET,
				a.MONTH,
				a.YEAR,
				a.upload_date,
				a.is_check,
				CASE
					WHEN a.is_check = 0 then ''
					WHEN a.is_check = 1 then 'DIAJUKAN KE SPV'
					WHEN a.is_check = 2 then 'SELESAI'
					WHEN a.is_check = 3 then 'CABANG'
				END AS VERIFY_BY
				from new_account_planning a
				join PIPE_LOOKUP_PRODUCT b
				on a.product_id = b.id
				join PIPELINE_CATEGORY c
				on a.cat_id = c.id
				where sales_id ='$id' and month='$m' and year='$y'
			";
		return $this->db->query($sql)->result_array();
		
	}	
	
	#BM
	function get_report_tmp_ap_bm($id, $w, $m, $y)
	{	
		$sql="
				select 
				a.ID,
				a.SALES_ID,
				a.CIF_KEY,
				a.CUST_NAME,
				a.PRODUCT_ID,
				'TABUNGAN' PRODUCT_NAME,
				NVL(a.RENCANA,0) RENCANA,
				NVL(b.DELTA_TABUNGAN,0) DELTA_TABUNGAN,
				NVL(b.DELTA_TABUNGAN,0) + NVL(a.RENCANA,0) DELTA_RENCANA,
				a.MONTH,
				a.YEAR,
				a.upload_date,
				a.is_check,
				CASE
					WHEN a.is_check = 0 then ''
					WHEN a.is_check = 1 then 'DIAJUKAN KE SPV'
					WHEN a.is_check = 2 then 'SELESAI'
					WHEN a.is_check = 3 then 'CABANG'
				END AS VERIFY_BY
				from PIPELINE_BM a
				left join
				(
					select 
					a.bni_cif_key,
					nvl(a.tabungan_cur,0) - nvl(b.tabungan_cur,0) DELTA_TABUNGAN_CUR,
					nvl(a.tabungan,0) - nvl(b.tabungan,0) DELTA_TABUNGAN
					 from tmp_nasabah_kelolaan  a
					left join
					(select sales_id,cif_key,sum(bni_cur_book_bal_idr) tabungan_cur,sum(avg_book_bal) tabungan
					 from tmp_baseline_2016_top where product_id = 2 
					 group by sales_id,cif_key)b
					 on(a.bni_cif_key = b.cif_key)   
					where last_month = 0					 
				)b 
				on a.cif_key = b.bni_cif_key
				where sales_id ='$id' and week ='$w' and month='$m' and year='$y' 
			";
		return $this->db->query($sql)->result_array();
		
	}	
	
		public function kirim_nasabah_usulan($npp)
	{
		$this->db->where(array('SALES_ID' => $npp));
		$this->db->update('NEW_ACCOUNT_PLANNING', array('IS_CHECK' => 1));
		
		return 1;
	}
	
		public function kirim_nasabah_usulan_bm($id,$w,$m,$y)
	{
		$this->db->where(array('SALES_ID' => $id,'WEEK' => $w,'MONTH' => $m,'YEAR' => $y));
		$this->db->update('PIPELINE_BM', array('IS_CHECK' => 1));
		
		return 1;
	}
	
	public function cek_status_ap($npp)
	{
		$day=date('d');
		$year=date('Y');
		if($day >= 1 and $day <=6)
		{
			$m=date('m');
		}else{
			$m=date('m')+1;
		}
		$response;
		
		$this->db->from('NEW_ACCOUNT_PLANNING');
		$this->db->where(array('SALES_ID' => $npp));
		$this->db->where('MONTH',$m);
		$this->db->where('YEAR',$year);
		$this->db->select('IS_CHECK');
		$data = $this->db->get()->row();
		
//		return $data->IS_CHECK;
		
	}
	public function cek_status_ap_bm($id,$w,$m,$y)
	{
		$day=date('d');
		#$week = date("W",date("Y-m-d"));
		switch($day){
				case ($day >= 1 and $day<=7):
					$week = 1;
					break;
				case ($day >= 8 and $day<=14):
					$week = 2;
					break;
				case ($day >= 15 and $day<=21):
					$week = 3;
					break;
				case ($day >= 22):
					$week = 4;
					break;
				}
		$year=date('Y');
		if($day>= 25 and $week==1)
		{
			$m=date('m')+1;
		}else{
			$m=date('m');
		}
		$response;
		
		$this->db->from('PIPELINE_BM');
		$this->db->where(array('SALES_ID' => $id));
		$this->db->where('WEEK',$w);
		$this->db->where('MONTH',$m);
		$this->db->where('YEAR',$y);
		$this->db->select('IS_CHECK');
		$data = $this->db->get()->row();
		
		return $data->IS_CHECK;
		
	}
	
	public function cek_own_ap_bm($id,$w,$m,$y)
	{
		$day=date('d');
		#$week = date("W",date("Y-m-d"));
		switch($day){
				case ($day >= 1 and $day<=7):
					$week = 1;
					break;
				case ($day >= 8 and $day<=14):
					$week = 2;
					break;
				case ($day >= 15 and $day<=21):
					$week = 3;
					break;
				case ($day >= 22):
					$week = 4;
					break;
				}
		$year=date('Y');
		if($day>= 25 and $week==1)
		{
			$m=date('m')+1;
		}else{
			$m=date('m');
		}
		$response;
		
		$this->db->from('PIPELINE_BM');
		$this->db->where(array('SALES_ID' => $id));
		$this->db->where('WEEK',$w);
		$this->db->where('MONTH',$m);
		$this->db->where('YEAR',$y);
		$this->db->select('SALES_ID');
		$data = $this->db->get()->row();
		
		return $data->SALES_ID;
		
	}
	
	public function total_nasabah($npp)
	{
		$sql = "SELECT 
				SALES_ID,
				SUM(DPK) TOTAL_DPK,
				SUM(AUM) TOTAL_AUM,
				COUNT(CIF_KEY) TOTAL_CIF
				FROM LIST_NAS_KEL_SALES
				WHERE SALES_ID = '$npp'
				GROUP BY SALES_ID ";
		#die();
		return $this->db->query($sql)->result();
	}
	
	function get_list_account_planning($id)
	{
	
	}
	
	public function remove_ap_from_list($cif)
	{
		$this->db->trans_start();
		$this->db->delete('NEW_ACCOUNT_PLANNING', array('ID' => $cif));
		
		$this->db->trans_complete();
		
		
		
		return $response = $this->db->trans_status() ? 1 : 0;
	}
	
	//GET List Sales yg nasabahnya sedang diusulkan
	public function get_sales_ap() 
	{
		$this->db->from('VW_AP_DISTINC');
		$npp = $this->session->userdata('ID');
		
		$where = array("SPV"=>"$npp","is_check" => 1);
		
		$this->db->where($where);		
		$this->CI->flexigrid->build_query();
		
		#Get contents
		$return['records'] = $this->db->get();
		
		#Build count query
		$this->db->from('VW_AP_DISTINC');
		$this->db->select("COUNT(SALES_ID) AS RECORD_COUNT",FALSE);
		$this->db->where($where);
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		#Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
		
		#Get Data Behavior
		
	
		#Return all
		return $return;
		
	}
	
	//GET List Sales yg nasabahnya sedang diusulkan
	public function get_sales_ap_bm() 
	{
		$this->db->select('SALES_ID,USER_NAME,BRANCH_NAME');
		$this->db->select('SPV');
		$this->db->from('VW_AP_BM');
		$npp = $this->session->userdata('ID');
		$user_level = $this->session->userdata('USER_LEVEL');
		$region = $_SESSION['REGION'];
		if($user_level=='PIMPINAN_WILAYAH')
		{
			$where = array("REGION"=>"$region","is_check" => 1);
		}
		else if($user_level=='PEMIMPIN_CABANG')
		{
			$where = array("SPV"=>"$npp","is_check" => 1);
		}
		
		$this->db->where($where);		
		$this->CI->flexigrid->build_query();
		
		#Get contents
		$return['records'] = $this->db->get();
		
		#Build count query
		$this->db->from('VW_AP_BM');
		$this->db->select("COUNT(SALES_ID) AS RECORD_COUNT",FALSE);
		$this->db->where($where);
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		#Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
		
		#Get Data Behavior
		
	
		#Return all
		return $return;
		
	}
	
	public function approval_ap($mode,$npp,$month,$year)
	{
		$new_flag = strcmp($mode, 'approve') ? 0: 2;
		
		$this->db->where(array('SALES_ID' => $npp));
		$this->db->where(array('MONTH' => $month));
		$this->db->where(array('YEAR' => $year));
		$this->db->update('NEW_ACCOUNT_PLANNING', array('IS_CHECK' => $new_flag));
		
		return 1;
	}

	public function approval_ap_bm($mode,$id,$week,$month,$year)
	{
		$new_flag = strcmp($mode, 'approve_bm') ? 0: 2;
		
		$this->db->where(array('SALES_ID' => $id));
		$this->db->where(array('WEEK' => $week));
		$this->db->where(array('MONTH' => $month));
		$this->db->where(array('YEAR' => $year));
		$this->db->update('PIPELINE_BM', array('IS_CHECK' => $new_flag));
		
		return 1;
	}
	
	public function reject($mode,$id,$week,$month,$year)
	{
		$new_flag = strcmp($mode, 'approve_bm') ? 0: 0;
		
		$this->db->where(array('SALES_ID' => $id));
		$this->db->where(array('WEEk' => $week));
		$this->db->where(array('MONTH' => $month));
		$this->db->where(array('YEAR' => $year));
		$this->db->update('PIPELINE_BM', array('IS_CHECK' => $new_flag));
		
		return 1;
	}
	
		public function approval_ap1($mode,$npp,$month,$year)
	{
		$new_flag = strcmp($mode, 'reject') ? 0: 0;
		
		$this->db->where(array('SALES_ID' => $npp));
		$this->db->where(array('MONTH' => $month));
		$this->db->where(array('YEAR' => $year));
		$this->db->update('NEW_ACCOUNT_PLANNING', array('IS_CHECK' => $new_flag));
		
		return 1;
	}
	
	function save_pipeline_master($npp)
	{
			$sql="  insert into pipeline_master
					select SEQ_PIPELINE_MASTER.NEXTVAL ID,a.*
					from
					(
						select
						cif_key,
						cust_name,
						50 SOURCE_ID,
						product_id,
						cat_id,
						$npp userid,
						1 last_staging,
						sysdate as as_of_date,
						0 END_STAGING,
						NULL LEADS_ID
						from
						new_account_planning
						where sales_id = $npp and is_check = 2)a
				";
			$this->db->query($sql);
			return null;
	}	
	
	function save_pipeline_staging($data)
	{
		//$this->db->set('PIPELINE_ID', $data['PIPELINE_ID']);
		//$this->db->set('AS_OF_DATE', "TO_DATE('{$data['AS_OF_DATE']}', 'DD-MM-YYYY HH24:MI:SS')", false);
		//$this->db->set('STAGING_ID', $data['STAGING_ID']);
		//$this->db->set('NOMINAL', $data['NOMINAL']);
		//$this->db->insert('PIPELINE_STAGING');
		$day=date('d');
		$month=date('n');
		$year = date('Y');
		$pipeline_id = $data['PIPELINE_ID'];
		$npp = $data['npp'];
		if($day >= 1 and $day <=6)
			{
				$where = "b.month = $month";
				$where2= "extract(month from a.staging_update) = $month";
			}else{
			$where = "b.month = $month+1";
			$where2= "extract(month from a.staging_update) = $month+1";
			}
		$sql="	insert into pipeline_staging(PIPELINE_ID,AS_OF_DATE,STAGING_ID,NOMINAL)
                select a.id pipeline_id,sysdate as_of_date,1 staging_id,b.rencana nominal from pipeline_master a
                join new_account_planning b
                on a.cif=b.CIF_KEY
                where  a.source_id = 50 and b.sales_id = $npp and b.is_check =2 and $where and b.year = $year
				and $where2 and extract(year from a.staging_update) =$year";
		$this->db->query($sql);
		return false;
	}
	
	function report_pipeline_combine($productid,$month,$year)
	{
		$lvl=$_SESSION['USER_LEVEL'];
		$cbg=$_SESSION['BRANCH_ID'];
		$reg=$_SESSION['REGION'];
		if($lvl=='PEMIMPIN_CABANG')
		{
			$where = "and branch_code = ".$cbg;
		}
		if($lvl=='PIMPINAN_WILAYAH')
		{
			$where = "and REGION = ".$reg;
			$order = "order by a.branch_name";
		}
		if($lvl=='SLN'||$lvl=='TIM'||$lvl=='ADMIN')
		{
			$where = "and REGION <=16";
			$order = "order by a.region,a.branch_name";
		}
		if($productid ==  0)
		{
			$produk_pipeline ="";
		}else
		{
			$produk_pipeline ="and c.product_category =".$productid." ";
		}
		$sql="select a.branch_code,a.branch_name,a.region,a.region_name,a.MONTH,a.YEAR,nvl(b.RENCANA,0) SALES,nvl(d.rencana,0) as PEMIMPIN_KLNKK,nvl(c.rencana,0) PEMIMPIN_CABANG,nvl(b.rencana,0)+nvl(d.rencana,0)+nvl(c.rencana,0) Total_pipeline from
				(select
				a.branch_code,
				a.branch_name,
				a.region,
				b.region_name,
				".$month." MONTH,
				".$year." YEAR
				from
				branch a
				join branch_region b 
				on a.region = b.region_code
				where 
				branch_code in(select distinct branch from user_tst where user_level='SALES' and status=1) $where)a
				left join
				(select
				'SALES' JENIS,
				branch,
				region,
				month,
				year,
				sum(nvl(rencana,0)) rencana
				from
				new_account_planning a
				join (select a.id,a.branch,b.region from user_tst a join branch b on a.branch = b.branch_code where a.user_level='SALES') b
				on a.sales_id = b.id
				join pipe_lookup_product c
                on a.product_id = c.id
				where month=".$month." and year=".$year." and is_check=2 ".$produk_pipeline."
				group by branch,region,month,year
				)b
				on a.month = b.month and a.year = b.year and a.branch_code = b.branch
				left join
				(select
				'PEMIMPIN_CABANG' JENIS,
				branch,
				b.region,
				month,
				year,
				sum(nvl(rencana,0)) rencana
				from
				pipeline_bm a
				join (select a.id,a.branch,b.region from user_tst a join branch b on a.branch = b.branch_code where a.user_level='PEMIMPIN_CABANG') b
				on a.sales_id = b.id
				join pipe_lookup_product c
                on a.product_id = c.id
				where month=".$month." and year=".$year." ".$produk_pipeline."
				group by branch,region,month,year)c
				on a.month = c.month and a.year = c.year and a.branch_code = c.branch
				left join(
				select
				'PEMIMPIN_KLN-KK' JENIS,
				branch,
				region,
				month,
				year,
				sum(nvl(rencana,0)) rencana
				from
				pipeline_bm a
				join (select a.id,a.branch,b.region from user_tst a join branch b on a.branch = b.branch_code where a.user_level='PEMIMPIN_CABANG') b
				on a.sales_id = b.id
				join pipe_lookup_product c
                on a.product_id = c.id
				where month=".$month." and year=".$year." ".$produk_pipeline."
				group by branch,region,month,year)d
				on a.month = d.month and a.year = d.year and a.branch_code = d.branch
				".$order."";
			return $this->db->query($sql)->result_array();
	}
}
?>