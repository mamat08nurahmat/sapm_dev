<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _home extends Model 
{
	public function _home()
    {
        parent::Model();
		$this->CI =& get_instance();
    }
	
	public function get_neo_search($id = 0) 
	{
		$table_name = "USER_TST a";
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
		#$this->db->select("* $sql",FALSE);	
		$this->db->from('VW_CR_LIST_SALES');
		$npp = $this->session->userdata('ID');
		$where = '';
			
		$lvl = strtoupper($this->session->userdata('USER_LEVEL'));
		$cab = strtoupper($this->session->userdata('BRANCH_ID'));
		$wil = strtoupper($this->session->userdata('REGION'));
		
		switch ($lvl) {
			case 'SUPERVISOR':
				$where = array("SPV"=>"$npp",'USER_LEVEL'=>'SALES');
				break;
			case 'PEMIMPIN_CABANG':
			case 'CABANG':
				$where = array("BRANCH"=>$cab,'USER_LEVEL'=>'SALES');
				break;
			case 'WILAYAH':
				$where = array("REGION"=>$wil,'USER_LEVEL'=>'SALES');
				break;
			case 'PIMPINAN_CABANG':
				$where = array("BRANCH"=>$cab,'USER_LEVEL'=>'SALES');
				break;
			case 'PIMPINAN_WILAYAH':
				$where = array("REGION"=>$wil,'USER_LEVEL'=>'SALES');
				break;
			case 'SALES':
				$where = array("ID"=>$npp,'USER_LEVEL'=>'SALES');
				break;
			default:			
				$where = array("ID >"=>0,'USER_LEVEL'=>'SALES');
		}
		
		$this->db->where($where);
		$this->db->where('SALES <','7');
		$this->db->where('REGION <>','88');
		$this->CI->flexigrid->build_query();
		
		#Get contents
		$return['records'] = $this->db->get();
		
		#Build count query
		$this->db->from('VW_CR_LIST_SALES');
		$this->db->select("COUNT(ID) AS RECORD_COUNT",FALSE);
		$this->db->where($where);
		$this->db->where('SALES <','7');
		$this->db->where('REGION <>','88');
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		#Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		#Return all
		return $return;
	}
	
	function save($data)
	{
		$npp = $data['npp'];
		$vote = 1;
		$negara = $data['negara'];
		//$date = date("Y-m-d"); 
		//$sql="
			//	UPDATE ATW SET VOTE = 1,NEGARA = $negara WHERE ID = $npp
			//";
		
		//$data = array(
             //  'vote' => $vote,
               //'negara' => $negara,
			   //'as_of_date' => $date
            //);
		//$this->db->where('id', $npp);
		//$this->db->update('ATW', $data); 
		$sql="
				update atw set vote = $vote,negara = '$negara' , as_of_date = sysdate
				where id = $npp
			";
		$this->db->query($sql);
	}
	
	
	function get_vote($npp)
	{
		$this->db->where('ID', $npp);
		return $this->db->get('ATW')->result();		
	}
	
	function update($data)
	{
		$npp = $data['id'];
		$juklak = $data['juklak'];
		$this->db->where('id', $npp);
		$this->db->update('ATW', $data); 
	}
	
	function save_kpatw($data){
	$npp = $data['NPP'];
	$user_level = $data['USER_LEVEL'];
	$q1 = $data['Q1'];
	$alasan1 = $data['ALASAN1'];
	$q2 = $data['Q2'];
	$alasan2 = $data['ALASAN2'];
	$q3 = $data['Q3'];
	$alasan3 = $data['ALASAN3'];
	$alasan4 = $data['ALASAN4'];
	$status=$data['STATUS'];
	
	$sql="UPDATE KPATW SET Q1 = '$q1',ALASAN1 = '$alasan1',Q2 = '$q2',ALASAN2 = '$alasan2',Q3 = '$q3',ALASAN3 = '$alasan3',ALASAN4 = '$alasan4',STATUS = '$status',AS_OF_DATE = SYSDATE
			WHERE NPP = $npp
		";
	$this->db->query($sql);	
	}
	
	function sudah_kuesioner_kpatw($npp)
	{
		$this->db->where('NPP', $npp);
		return $this->db->get('KPATW')->result();	
	}
	function get_detail_point($id,$start,$end)
	{
		$sql="SELECT AS_OF_DATE,SALES_ID,NVL(CC_BIRU,0) CC_BIRU,NVL(CC_GOLD,0) CC_GOLD,NVL(CC_PREMIUM,0)CC_PREMIUM,FLOOR(NVL(CC_BIRU,0)/3)+NVL(CC_GOLD,0)+NVL(CC_PREMIUM,0) POINT 
				FROM POINT_PROGRAM WHERE sales_id =$id and AS_OF_DATE between '$start' and '$end' order by as_of_date";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	function get_sum_point($id)
	{
		$sql="SELECT SALES_ID,POINT,REDEEM,SISA_POINT,SALDO from VW_POINT_SUM where SALES_ID=$id";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	function save_files($data, $tbl_name)
	{
		#echo "<pre>"; print_r($data); die();
		$this->db->insert($tbl_name, $data);
		#return $this->db->insert_id();
	}
	function save_trx($datatrx)
	{
		$sql="INSERT INTO TRX_POINT(ID,AS_OF_DATE,SALES_ID,REDEEM,FILE_NAME,NOMINALREDEEM,BIAYA_KIRIM) 
				VALUES
				(SEQ_POINT.NEXTVAL,SYSDATE,
				".$datatrx['SALES_ID'].",
				".$datatrx['REDEEM'].",
				'".$datatrx['FILE_NAME']."',
				".$datatrx['NOMINALREDEEM'].",
				".$datatrx['BIAYAKIRIM'].")";
		$this->db->query($sql);
	}
	function update_trx($datatrx)
	{
		$sql="UPDATE TRX_POINT SET TGL_TRF = SYSDATE,ADMIN_ID=".$datatrx['ADMIN_ID'].",FILE_BT = '".$datatrx['FILE_NAME']."',STATUS ='DIBAYAR' WHERE ID=".$datatrx['TRXID'];
		$this->db->query($sql);
	}
	function update_comment($data)
	{
		$sql="UPDATE TRX_POINT SET STATUS='SELESAI',IS_PUAS=".$data['IS_PUAS'].",KETERANGAN = '".$data['KETERANGAN']."' WHERE ID=".$data['FBID'];
		$this->db->query($sql);
	}
	function list_trx($id)
	{
		if($_SESSION['USER_LEVEL']=='SALES')
		{
			$this->db->where('SALES_ID',$id);
		}
		$this->db->select('a.*,b.user_name,c.sales_type,d.branch_name');
		$this->db->from('TRX_POINT a');
		$this->db->join('USER_TST b','a.sales_id=b.id');
		$this->db->join('SALES_TYPE c','b.sales=c.id');
		$this->db->join('BRANCH d','b.branch=d.branch_code');
		$this->db->order_by('AS_OF_DATE',desc);
		return $this->db->get()->result();
		$this->db->close();
	}
	function trxpendingpoint()
	{
		$this->db->where('STATUS','PENDING');
		$this->db->select('count(id) PENDING');
		return $this->db->get('TRX_POINT')->result();
		$this->db->close();
	}
	function point_national()
	{
		return $this->db->get('VW_POINT_NASIONAL')->result();
		$this->db->close();
	}
	function get_kmtr($id)
	{
		$this->db->where('IS_PUAS IS NOT','NULL');
		$this->db->select('ID,IS_PUAS,KETERANGAN');
		return $this->db->get('TRX_POINT')->result();
		$this->db->close();
	}
	function status_leads($branch)
	{
		$this->db->where('BRANCH',$branch);
		$this->db->select('*');
		return $this->db->get('VW_STATUS_LEADS')->result();
		$this->db->close();
	}
	function save_kuesioner($data){
	$sales_id = $data['SALES_ID'];
	$user_level = $data['USER_LEVEL'];
	$Q1=$data['Q1'];
	$Q2=$data['Q2'];
	$Q3=$data['Q3'];
	$Q4=$data['Q4'];
	$Q5=$data['Q5'];
	$Q6=$data['Q6'];
	$Q7=$data['Q7'];
	$Q8=$data['Q8'];
	$Q9=$data['Q9'];
	$Q10=$data['Q10'];
	$Q11=$data['Q11'];
	$Q12=$data['Q12'];
	$Q13=$data['Q13'];
	$Q14=$data['Q14'];
	$Q15=$data['Q15'];
	$Q16=$data['Q16'];
	$Q17=$data['Q17'];
	$Q18=$data['Q18'];
	$Q19=$data['Q19'];
	$Q20=$data['Q20'];
	$Q21=$data['Q21'];
	$Q22=$data['Q22'];
	$Q23=$data['Q23'];
	$Q24=$data['Q24'];
	$Q25=$data['Q25'];
	$Q26=$data['Q26'];
	$status=$data['STATUS'];
	
	$sql="INSERT INTO KUESIONER (SALES_ID,USER_LEVEL,Q1,Q2,Q3,Q4,Q5,Q6,Q7,Q8,Q9,Q10,Q11,Q12,Q13,Q14,Q15,Q16,Q17,Q18,Q19,Q20,Q21,Q22,Q23,Q24,Q25,Q26,STATUS,AS_OF_DATE)
			VALUES
			(
				$sales_id,'$user_level','$Q1','$Q2','$Q3','$Q4','$Q5','$Q6','$Q7','$Q8','$Q9','$Q10','$Q11','$Q12','$Q13','$Q14','$Q15','$Q16','$Q17','$Q18','$Q19','$Q20','$Q21','$Q22','$Q23','$Q24','$Q25','$Q26',$status,SYSDATE
			)
		";
	$this->db->query($sql);	
	}
	function sudah_kuesioner($npp)
	{
		$this->db->where('SALES_ID', $npp);
		return $this->db->get('KUESIONER')->result();	
	}
}
?>