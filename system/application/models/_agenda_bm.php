<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _agenda_bm extends Model {
	function _agenda_bm()
	{
		parent::Model();
		$this->CI =& get_instance();
	}
	function save_activity($data)
	{
		$sql = "INSERT INTO AGENDA_BM 
				(ID,NPP,CIF_KEY,CUST_NAME,PRODUCT_ID,KEGIATAN,TANGGAL_KEGIATAN,CREATED_DATE,REALISASI,KETERANGAN,STATUS)
				VALUES 
				(
					SAPM_AGENDABM.NEXTVAL,".
					$data['NPP'].",'".
					$data['CIF_KEY']."','".
					$data['CUST_NAME']."',2,'".
					$data['KEGIATAN']."','".
					$data['TANGGAL']."',TO_DATE('".
					$data['CREATED_DATE']."','DD-MON-YYYY HH24:MI:SS'),'".
					$data['REALISASI']."','".
					$data['KETERANGAN']."','".
					$data['STATUS']."'
				)";
				 
		#echo "<pre>";print_r($data);
		#echo "<pre>";print_r($sql); die();
		$json = array();
		$arr_id = $data['NPP'];
				//cek apakah sales di cabang ini
					$this->db->query($sql);
					$json['result']=true;
		echo json_encode($json);
	}
	
	function get_list_activity($id)
	{
		$sql="select
				a.ID,
				a.NPP,
				a.CIF_KEY,
				a.CUST_NAME,
				b.Product_name,
				CASE
				when kegiatan = 0 then 'CALL'
				ELSE 'VISIT'
				END AS KEGIATAN,
				TANGGAL_KEGIATAN,
				CREATED_DATE,
				CASE
				WHEN REALISASI = 0 then 'TIDAK'
				WHEN REALISASI = 1 then 'YA'
				END AS REALISASI,
				KETERANGAN,
				STATUS
				from
				agenda_bm a
				join product b
				on a.product_id = b.id
				where CIF_KEY = ".$id."
				order by created_date";
		$q = $this->db->query($sql);
		$result =$q->result();
		$this->db->close();
		return $result;
	}
	
	function get_data_nasabah($id)
	{
		$sql="select a.*,b.user_name nama_sales,b.sales_type from customer_individu a left join vw_cr_list_sales b on a.bni_sales_id = b.id where a.cif=$id and b.status = 1";
		$q = $this->db->query($sql);
		$result =$q->result();
		$this->db->close();
		return $result;
	}
	
	function get_data_product($id)
	{
		$sql="select * from vw_custind_data_prod_bni where cif=$id";
		$q=$this->db->query($sql);
		$result =$q->result_array();
		$this->db->close();
		return $result;
	}
	
	function get_data_update_rencana($id)
	{
		$sql="select
				a.ID,
				a.NPP,
				a.CIF_KEY,
				a.CUST_NAME,
				b.Product_name,
				CASE
				when kegiatan = 0 then 'CALL'
				ELSE 'VISIT'
				END AS KEGIATAN,
				TANGGAL_KEGIATAN,
				CREATED_DATE,
				CASE
				WHEN REALISASI = 0 then 'TIDAK'
				WHEN REALISASI = 1 then 'YA'
				END AS REALISASI,
				KETERANGAN,
				STATUS
				from
				agenda_bm a
				join product b
				on a.product_id = b.id
				where NPP = ".$id." and realisasi is null
				order by created_date";
		$q = $this->db->query($sql);
		$result =$q->result();
		$this->db->close();
		return $result;
	}
	function update_activity($data)
	{
		$sql = "UPDATE AGENDA_BM SET REALISASI =".$data['REALISASI'].",KETERANGAN='".$data['KETERANGAN']."',UPDATE_DATE=TO_DATE('".$data['UPDATE_DATE']."','DD-MON-YYYY HH24:MI:SS') where ID=".$data['NOID']."";	 
		#echo "<pre>";print_r($data);
		#echo "<pre>";print_r($sql); die();
		$json = array();
		$arr_id = $data['NPP'];
				//cek apakah sales di cabang ini
					$this->db->query($sql);
					$json['result']=true;
		echo json_encode($json);
	}
	function get_selisih($id)
	{
		$sql = "select distinct selisih_hari from vw_exp_bm where npp = $id and selisih_hari >=3";
		$q = $this->db->query($sql);
		$result =$q->result();
		$this->db->close();
		return $result;
	}
		public function get_pemimpin_search($id = 0) 
	{
		$table_name = "VW_LIST_USER";
		/*
		---------------------------
		1. Supervisor
		2. Cabang
		3. Wilayah
		4. All		
		---------------------------
		*/
		#Build contents query
		
		#$sql = "FROM(SELECT a.ID,a.USER_NAME,b.SALES_TYPE,a.USER_LEVEL,a.SALES,a.SPV,a.BRANCH,c.BRANCH_NAME,c.REGION FROM USER_TST a LEFT JOIN SALES_TYPE b ON a.SALES = b.ID LEFT JOIN BRANCH c ON a.BRANCH = c.BRANCH_CODE)";
		$this->db->select("NPP,NAMA,USER_LEVEL,BRANCH_NAME,KODE,REGION_CODE",FALSE);	
		$this->db->from($table_name);
		//$this->db->where($where);
		$this->CI->flexigrid->build_query();
		
		#Get contents
		$return['records'] = $this->db->get();
		
		#Build count query
		$this->db->from($table_name);
		$this->db->select("COUNT(NPP) AS RECORD_COUNT",FALSE);
		//$this->db->where($where);
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		#Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		#Return all
		return $return;
	}
	public function get_pemimpin_search2($id = 0) 
	{
		$table_name = "VW_LIST_USER";
		/*
		---------------------------
		1. Supervisor
		2. Cabang
		3. Wilayah
		4. All		
		---------------------------
		*/
		#Build contents query
		
		#$sql = "FROM(SELECT a.ID,a.USER_NAME,b.SALES_TYPE,a.USER_LEVEL,a.SALES,a.SPV,a.BRANCH,c.BRANCH_NAME,c.REGION FROM USER_TST a LEFT JOIN SALES_TYPE b ON a.SALES = b.ID LEFT JOIN BRANCH c ON a.BRANCH = c.BRANCH_CODE)";
		$this->db->select("NPP,NAMA,USER_LEVEL,BRANCH_NAME,KODE,REGION_CODE",FALSE);	
		$this->db->from($table_name);
		//$this->db->where($where);
		$this->CI->flexigrid->build_query();
		
		#Get contents
		$return['records'] = $this->db->get();
		
		#Build count query
		$this->db->from($table_name);
		$this->db->select("COUNT(NPP) AS RECORD_COUNT",FALSE);
		//$this->db->where($where);
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		#Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		#Return all
		return $return;
	}
	function update_kelolaan_bm($data)
	{
		$npp_asal = $data['NPP_ASAL'];
		$npp_baru = $data['NPP_BARU'];
		$sql1="UPDATE CR_FLAGGING_TOP SET NPP = $npp_baru where npp=$npp_asal";
		$sql2="UPDATE TMP_BASELINE_2016_TOP SET SALES_ID = $npp_baru where SALES_ID=$npp_asal";
		$sql3="UPDATE TMP_NASABAH_KELOLAAN_TOP SET BNI_SALES_ID = $npp_baru where BNI_SALES_ID=$npp_asal";
		$this->db->query($sql1);	
		$this->db->query($sql2);
		$this->db->query($sql3);
	}
	function update_kelolaan_bm2($data)
	{
		$npp = $data['NPP'];
		$branch_id= $data['BRANCH_ID'];
		$kln_id = $data['KLN_ID'];
		$sql1="UPDATE CR_FLAGGING_TOP SET NPP = 0 where npp=$npp";
		$sql2="UPDATE TMP_BASELINE_2016_TOP SET SALES_ID = 0 where SALES_ID=$npp";
		$sql3="UPDATE TMP_NASABAH_KELOLAAN_TOP SET BNI_SALES_ID = 0 where BNI_SALES_ID=$npp";
		$sql4="UPDATE CR_FLAGGING_TOP SET NPP=$npp where cif_key in
				(select cif_key from mapping_kelolaan_top where branch_code = $branch_id and kln_code = $kln_id)";
		$sql5="UPDATE TMP_BASELINE_2016_TOP SET SALES_ID=$npp where cif_key in
				(select cif_key from mapping_kelolaan_top where branch_code = $branch_id and kln_code = $kln_id)";
		$sql6="UPDATE TMP_NASABAH_KELOLAAN_TOP SET BNI_SALES_ID=$npp where bni_cif_key in
				(select cif_key from mapping_kelolaan_top where branch_code = $branch_id and kln_code = $kln_id)";
		$sql7="UPDATE AGENDA_BM SET NPP = 0 where NPP = $npp";
		$sql8="UPDATE PIPELINE_BM SET SALES_ID = 0 where SALES_ID = $npp";
		$sql9="UPDATE AGENDA_BM SET NPP = $npp where cif_key in
				(select cif_key from mapping_kelolaan_top where branch_code = $branch_id and kln_code = $kln_id)";
		$sql10="UPDATE PIPELINE_BM SET SALES_ID = $npp where cif_key in
				(select cif_key from mapping_kelolaan_top where branch_code = $branch_id and kln_code = $kln_id)";
		$sql11="merge into sapm_calls a using
				(
				select * from cr_flagging_top where NPP=$npp
				)b
				on (a.IDNASABAH = b.cif_key)
				when matched then update set
				a.npp = b.npp";
		$sql12="merge into sapm_visit a using
				(
				select * from cr_flagging_top where NPP=$npp
				)b
				on (a.IDNASABAH = b.cif_key)
				when matched then update set
				a.npp = b.npp";
		$sql13="merge into sapm_nasabah_kelolaan a using
				(
				select * from cr_flagging_top where NPP=$npp
				)b
				on (a.CIF = b.cif_key)
				when matched then update set
				a.npp = b.npp";
		$sql14="merge into sapm_pegawai a using
				(
				select * from vw_user_update where npp=$npp
				)b
				on (a.npp=b.npp)
				when matched then update set
				a.unit = b.branch,
				a.role = b.role
				when not matched then 
				insert(ID,NAMA_PEGAWAI,EMAIL,NPP,UNIT,ROLE)
				values(PEG_SEQ.NEXTVAL,b.user_name,b.email,b.NPP,b.branch,b.role)";
		$sql15="merge into sapm_sales a using
				(
				select * from vw_user_update where npp=$npp
				)b
				on (a.npp=b.npp)
				when matched then update set
				a.unit = b.branch,
				a.role = b.role";
		$this->db->query($sql1);	
		$this->db->query($sql2);
		$this->db->query($sql3);
		$this->db->query($sql4);	
		$this->db->query($sql5);
		$this->db->query($sql6);
		$this->db->query($sql7);
		$this->db->query($sql8);	
		$this->db->query($sql9);
		$this->db->query($sql10);
		$this->db->query($sql11);
		$this->db->query($sql12);
		$this->db->query($sql13);
		$this->db->query($sql14);
		$this->db->query($sql15);
	}
	function get_cabang()
	{
		$sql ="select
				branch_code,
				UPPER(branch_name) branch_name
				from
				branch
				where region not in(99,98,88,80) and UPPER(branch_name) NOT LIKE 'KANTOR WILAYAH%'
				order by branch_name asc";
		return $this->db->query($sql)->result();
	}
	function get_kln()
	{
		$sql ="select
				a.branch_code,
				a.branch_name,
				b.kln_code,
				b.kln_name
				from
				branch a
				left join
				kln b
				on a.BRANCH_CODE = b.BRANCH_CODE";
		$qry=$this->db->query($sql);
		$result=array();
		foreach($qry->result() as $row)
		{
			$result["BRANCH_{$row->BRANCH_CODE}"][]=array('value'=>$row->KLN_CODE, 'innerHTML'=>$row->KLN_NAME);
		}
		return $result;
	}
	function detail_rekap_outlet($id)
	{
		$this->db->where('NPP',$id);
		return $this->db->get('VW_RANGKUMAN_TOP2010')->result();
		$this->db->close();
	}
	function detail_rekap_outletx($kln)
	{
		$this->db->where('branch_code||KLN_CODE',$kln);
		#$this->db->where('KLN_CODE',$kln);
		return $this->db->get('VW_RANGKUMAN_TOP2010')->result();
		$this->db->close();
	}
	function detail_rekap_cabang($branch)
	{
		$sql="
				select 
				 a.REGION_CODE,
				 a.BRANCH_CODE,
				 a.KLN_CODE,
				 b.KLN_NAME,
				 SUM(a.CALL) CALL,
				 SUM(a.CALL_TIDAK) CALL_TIDAK,
				 SUM(a.CALL_YA) CALL_YA,
				 SUM(a.VISIT) VISIT,
				 SUM(a.VISIT_TIDAK) VISIT_TIDAK,
				 SUM(a.VISIT_YA) VISIT_YA
				  from vw_rangkuman_top2010 a
				  left join kln b
				  on a.branch_code=b.branch_code and a.kln_code = b.kln_code
				  where a.branch_code = $branch
				  group by a.region_code,a.branch_code,a.kln_code,b.kln_name
				  ORDER BY KLN_NAME
			";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	function detail_rekap_wilayah($region)
	{
		$sql="
				select 
				 a.REGION_CODE,
				 a.BRANCH_CODE,
				 b.BRANCH_NAME,
				 SUM(a.CALL) CALL,
				 SUM(a.CALL_TIDAK) CALL_TIDAK,
				 SUM(a.CALL_YA) CALL_YA,
				 SUM(a.VISIT) VISIT,
				 SUM(a.VISIT_TIDAK) VISIT_TIDAK,
				 SUM(a.VISIT_YA) VISIT_YA
				  from vw_rangkuman_top2010 a
				  join branch b
				  on a.branch_code = b.branch_code
				  where a.region_code = $region
				  group by a.region_code,a.branch_code,b.branch_name
				  order by BRANCH_NAME
			";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	function detail_rekap_pusat()
	{
		$sql="
				select 
				 a.REGION_CODE,
				 c.REGION_NAME,
				 SUM(a.CALL) CALL,
				 SUM(a.CALL_TIDAK) CALL_TIDAK,
				 SUM(a.CALL_YA) CALL_YA,
				 SUM(a.VISIT) VISIT,
				 SUM(a.VISIT_TIDAK) VISIT_TIDAK,
				 SUM(a.VISIT_YA) VISIT_YA
				  from vw_rangkuman_top2010 a
				  join branch b
				  on a.branch_code = b.branch_code
				  join branch_region c
				  on b.region = c.region_code
				  group by a.region_code,c.region_name
				  order by a.region_code
			";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
}

?>