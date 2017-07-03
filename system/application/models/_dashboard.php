<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _dashboard extends Model 
{
	public function _dashboard()
    {
        parent::Model();
		$this->CI =& get_instance();
    }

	function get_todo($d=0, $m=0, $y=0)
	{
		$id = $this->session->userdata('ID');
		$this->db->select('a.ID, a.USERID, a.D, a.M, a.Y, a.H, a.I,A.CUST_NAME AS NAMANASABAH,A.KETERANGAN AS TODO', false);
		$this->db->from('AGENDA a');
		$this->db->order_by('H, I','ASC');
		$where = array('D'=>$d, 'M'=>$m,'Y'=>$y, 'USERID'=>"$id");
		$this->db->where($where, false);
		return $this->db->get()->result();
	}
	
	function get_cifchecker($cif=0)
	{
//		$this->db->select('a.SALES_ID,a.CIF_KEY,a.CUST_NAME,b.USER_NAME,d.SALES_TYPE,c.branch_name',false);
		$this->db->select('a.SALES_ID,a.CIF_KEY,a.CUST_NAME');
		$this->db->from('CR_FLAGGING a');
//		$this->db->join('USER_TST b','a.SALES_ID = b.ID');
//		$this->db->join('BRANCH c','b.BRANCH=c.BRANCH_CODE');
//		$this->db->join('SALES_TYPE d','b.SALES = d.ID');
		$this->db->where('a.CIF_KEY',$cif);
			return $this->db->get()->result();
/*
		$this->db->select('a.SALES_ID,a.CIF_KEY,a.CUST_NAME,b.USER_NAME,d.SALES_TYPE,c.branch_name',false);
		$this->db->from('CR_FLAGGING a');
		$this->db->join('USER_TST b','a.SALES_ID = b.ID');
		$this->db->join('BRANCH c','b.BRANCH=c.BRANCH_CODE');
		$this->db->join('SALES_TYPE d','b.SALES = d.ID');
		$this->db->where('a.CIF_KEY',$cif);
		return $this->db->get()->result();	
*/		
	}
	
	function get_target($m=0, $y=0)
	{
		$id = $this->session->userdata('ID');
		$this->db->select('a.ID, a.SALES_ID, a.PRODUCT_ID, a.PROC_ID, b.PRODUCT_NAME, a.TARGET, a.PENCAPAIAN, a.REALISASI, a.TARGET_ID, b.TYPE, a.OUTSTANDING', false);
		$this->db->from('NEW_REALISASI a');
		$this->db->join('PRODUCT b','a.PRODUCT_ID = b.ID');
		$this->db->order_by('PRODUCT_ID','ASC');
		$where = array('M'=>$m,'Y'=>$y, 'SALES_ID'=>"$id");
		$this->db->where($where, false);
		return $this->db->get()->result();
	}
		
	function get_cust_ind2($sort='DESC')
	{
		$id = $this->session->userdata('ID');
		$sql = "SELECT CIF_KEY, CUST_NAME, (CUR_BOOK_BAL_IDR - AVG_BOOK_BAL) AS SALDO FROM CUST_INDV
				WHERE ROWNUM <= 10 AND IS_PROSPECT <> 1 AND BNI_SALES_ID LIKE '%$id'
				ORDER BY SALDO $sort";
		return $this->db->query($sql)->result();
	}
	
	function get_cust_ind($sort='DESC')
	{
		$id = $this->session->userdata('ID');
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = ($_SESSION['BRANCH_ID'] != '')?$_SESSION['BRANCH_ID']:'';
		$wil = ($_SESSION['REGION'] != '')?$_SESSION['REGION']:'';
		
		$whereX = ($sort=='DESC')?' > ':' < ';
		
		$sql_sales = "SELECT * FROM (
						SELECT BNI_CIF_KEY CIF_KEY, CUST_NAME, 
                        ( A.DPK - B.DPK_BASELINE) AS SALDO 
                        FROM tmp_nasabah_kelolaan A
						JOIN VW_DPK_BASELINE B
						ON A.BNI_CIF_KEY = B.CIF_KEY
						WHERE last_month=0 AND TRIM(SUBSTR(BNI_SALES_ID,-5,5)) = '$id'
					    ORDER BY SALDO $sort
                        ) WHERE ROWNUM <= 10";
		
		$sql_spv = "
				SELECT * FROM (
                SELECT  a.BNI_CIF_KEY CIF_KEY, TRIM(a.CUST_NAME) CUST_NAME, ( a.DPK - c.DPK_BASELINE) AS SALDO, TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) NPP 
                FROM TMP_NASABAH_KELOLAAN a
                LEFT JOIN USER_TST b ON TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) = b.ID
				JOIN VW_DPK_BASELINE C
				ON A.BNI_CIF_KEY = C.CIF_KEY
                WHERE 
                    a.last_month=0 and
                    TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) IS NOT NULL
                    AND b.SPV = '$id'
                    AND ROUND( a.DPK - c.DPK_BASELINE) $whereX 1
                ORDER BY SALDO $sort
                ) WHERE ROWNUM <= 10";
				
		$sql_cab = "
				SELECT * FROM (
				SELECT  a.BNI_CIF_KEY CIF_KEY, TRIM(a.CUST_NAME) CUST_NAME, ( a.DPK - c.DPK_BASELINE) AS SALDO, TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) NPP 
				FROM TMP_NASABAH_KELOLAAN a
				LEFT JOIN USER_TST b ON TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) = b.ID
				JOIN VW_DPK_BASELINE C
				ON A.BNI_CIF_KEY = C.CIF_KEY
				WHERE 
					TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) IS NOT NULL
					AND b.BRANCH = '$cab'
					AND ROUND(a.DPK - c.DPK_BASELINE) $whereX 1
					AND a.last_month = 0
				ORDER BY SALDO $sort
				) WHERE ROWNUM <= 10";
		
		$sql_wil ="
				SELECT * FROM (
				SELECT  a.BNI_CIF_KEY CIF_KEY, TRIM(a.CUST_NAME) CUST_NAME, ( a.DPK - c.DPK_BASELINE) AS SALDO, TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) NPP 
				FROM TMP_NASABAH_KELOLAAN a
				LEFT JOIN USER_TST b ON TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) = b.ID
				JOIN VW_DPK_BASELINE C
				ON A.BNI_CIF_KEY = C.CIF_KEY
				WHERE 
					TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) IS NOT NULL
					AND b.BRANCH IN (SELECT BRANCH_CODE FROM BRANCH WHERE REGION = '$wil')
					AND ROUND(a.DPK - c.DPK_BASELINE) $whereX 1
					AND a.last_month=0
				ORDER BY SALDO $sort
				) WHERE ROWNUM <= 10";
		
		
		switch ($lvl) {
		case 'SUPERVISOR':
			$sql = $sql_spv;
			break;
		case 'CABANG':
			$sql = $sql_cab;
			break;
		case 'WILAYAH':
			$sql = $sql_wil;
			break;
		case 'PIMPINAN_CABANG':
			$sql = $sql_cab;
			break;
		case 'PEMIMPIN_CABANG':
			$sql = $sql_cab;
			break;
		case 'PIMPINAN_WILAYAH':
			$sql = $sql_wil;
			break;
		default:
			$sql = $sql_sales;
		}

		
		return $this->db->query($sql)->result();
	}
	
	
		
	function get_cust_corp2($sort='DESC')
	{
		$id = $this->session->userdata('ID');
		$sql = "SELECT CIF_KEY, COMPANY_NAME, (CUR_BOOK_BAL_IDR - AVG_BOOK_BAL) AS SALDO FROM CUST_CORP
				WHERE ROWNUM <= 10 AND IS_PROSPECT <> 1 AND BNI_SALES_ID LIKE '%$id'
				ORDER BY SALDO $sort";
		return $this->db->query($sql)->result();
	}
	
	
	function get_cust_corp($sort='DESC')
	{
		$id = $this->session->userdata('ID');
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$cab = ($_SESSION['BRANCH_ID'] != '')?$_SESSION['BRANCH_ID']:'';
		$wil = ($_SESSION['REGION'] != '')?$_SESSION['REGION']:'';
		
		$sql_sales = "SELECT CIF_KEY, COMPANY_NAME, (CUR_BOOK_BAL_IDR - AVG_BOOK_BAL) AS SALDO FROM CUST_CORP
				WHERE ROWNUM <= 10 AND IS_PROSPECT <> 1 AND BNI_SALES_ID LIKE '%$id'
				ORDER BY SALDO $sort";
		
		$sql_spv = "SELECT  a.CIF_KEY, TRIM(a.COMPANY_NAME) COMPANY_NAME, (a.CUR_BOOK_BAL_IDR - a.AVG_BOOK_BAL) AS SALDO, TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) NPP 
				FROM CUST_CORP a
				LEFT JOIN USER_TST b ON TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) = b.ID
				WHERE 
					TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) IS NOT NULL
					AND b.SPV = '$id'
					AND ROWNUM <= 10 AND a.IS_PROSPECT <> 1
				ORDER BY SALDO $sort";
				
		$sql_cab = "SELECT  a.CIF_KEY, TRIM(a.COMPANY_NAME) COMPANY_NAME, (a.CUR_BOOK_BAL_IDR - a.AVG_BOOK_BAL) AS SALDO, TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) NPP 
				FROM CUST_CORP a
				LEFT JOIN USER_TST b ON TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) = b.ID
				WHERE 
					TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) IS NOT NULL
					AND b.BRANCH = '$cab'
					AND ROWNUM <= 10 AND a.IS_PROSPECT <> 1
				ORDER BY SALDO $sort";
		
		$sql_wil ="SELECT  a.CIF_KEY, TRIM(a.COMPANY_NAME) COMPANY_NAME, (a.CUR_BOOK_BAL_IDR - a.AVG_BOOK_BAL) AS SALDO, TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) NPP 
				FROM CUST_CORP a
				LEFT JOIN USER_TST b ON TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) = b.ID
				WHERE 
					TRIM(SUBSTR(a.BNI_SALES_ID,-5,5)) IS NOT NULL
					AND b.BRANCH IN (SELECT BRANCH_CODE FROM BRANCH WHERE REGION = '$wil')
					AND ROWNUM <= 10 AND a.IS_PROSPECT <> 1
				ORDER BY SALDO $sort";
		
		
		switch ($lvl) {
		case 'SUPERVISOR':
			$sql = $sql_spv;
			break;
		case 'BM':
			$sql = $sql_cab;
			break;
		case 'WIL':
			$sql = $sql_wil;
			break;
		default:
			$sql = $sql_sales;
		}

		
		return $this->db->query($sql)->result();
	}
	
	function get_bday3()
	{
		$id = $this->session->userdata('ID');
		$sql = "SELECT * FROM(
						select 
						id,
						bni_sales_id,
						cif CIF_KEY,
						nama_nasabah CUST_NAME,
						DATE_OF_BIRTH,
						substr(tanggal_lahir,1,2) Tanggal,
						substr(tanggal_lahir,3,2) Bulan,     
						case 
						when substr(tanggal_lahir,3,1) <> 0 then 
						to_date(
						                           CAST(EXTRACT(YEAR FROM SYSDATE) AS VARCHAR(4))
						                           || '/' ||
						                           substr(tanggal_lahir,3,2)
						                           || '/' ||
						                           substr(tanggal_lahir,1,2),'yyyy/mm/dd')
						when substr(tanggal_lahir,3,1) = 0 then
						to_date(
						CAST(EXTRACT(YEAR FROM SYSDATE) AS VARCHAR(4))
						                           || '/' ||
						                           substr(tanggal_lahir,4,1)
						                           || '/' ||
						                           substr(tanggal_lahir,1,2),'yyyy/mm/dd')
						END AS TGL
						FROM
						CUSTOMER_INDIVIDU
						WHERE
						                        BNI_SALES_ID LIKE '%$id'
						                    ORDER BY TGL ASC )
						 WHERE SYSDATE BETWEEN TGL - INTERVAL '7' DAY AND TGL+1
                ORDER BY TGL";
		return $this->db->query($sql)->result();
	}
	
	
	function get_bday2()
	{
		$id = $this->session->userdata('ID');
		$sql ="SELECT * FROM
				(
					SELECT    
							ID,
							BNI_SALES_ID, 
							CIF_KEY, CUST_NAME, 
							DATE_OF_BIRTH, 
							TO_NUMBER(TO_CHAR(DATE_OF_BIRTH, 'DD')) HARI, 
							TO_CHAR(DATE_OF_BIRTH, 'MON') BULAN, 
							
							CASE
							WHEN EXTRACT(MONTH FROM DATE_OF_BIRTH) = 2 AND MOD(EXTRACT(YEAR FROM DATE_OF_BIRTH),4) = 0
							AND EXTRACT(DAY FROM DATE_OF_BIRTH) = 29
							THEN
								TO_DATE(CAST(EXTRACT(YEAR FROM SYSDATE) AS VARCHAR(4))
							  || '/' ||
							  CAST(EXTRACT(MONTH FROM DATE_OF_BIRTH) AS VARCHAR(2))
							  || '/' ||
							  '28', 'YYYY/MM/DD')
							ELSE
							   TO_DATE(CAST(EXTRACT(YEAR FROM SYSDATE) AS VARCHAR(4))
							  || '/' ||
							  CAST(EXTRACT(MONTH FROM DATE_OF_BIRTH) AS VARCHAR(2))
							  || '/' ||
							  CAST(EXTRACT(DAY FROM DATE_OF_BIRTH) AS VARCHAR(2)), 'YYYY/MM/DD')
							END TGL
					
					FROM CUST_INDV
					--WHERE TRIM(BNI_SALES_ID) IS NOT NULL AND DATE_OF_BIRTH IS NOT NULL
					WHERE BNI_SALES_ID LIKE '%$id' AND DATE_OF_BIRTH IS NOT NULL
				)				
				
				WHERE TGL BETWEEN SYSDATE AND SYSDATE+7
				ORDER BY TGL
				";

			return $this->db->query($sql)->result();
	}
	
	function get_bday()
	{
		$id = $this->session->userdata('ID');
		$sql = "SELECT * FROM TMP_BIRTHDAY WHERE BNI_SALES_ID = '$id'
						AND SYSDATE BETWEEN TGL - INTERVAL '7' DAY AND TGL+1
						order by TGL";
		return $this->db->query($sql)->result();
	}
	
	
	
}

?>