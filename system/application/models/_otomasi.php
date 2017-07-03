<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _otomasi extends Model 
{
	public function _otomasi()
    {
        parent::Model();
		$this->CI =& get_instance();
    }
	
	function get_all_sales()
	{
		$this->db->select('DISTINCT SALES_ID');
		$this->db->order_by('SALES_ID');
		return $this->db->get('REALISASI')->result();
	}
	
	function get_dpk($npp, $m, $y, $proc)
	{
		$sql="UPDATE REALISASI SET PENCAPAIAN = ROUND
			(
				(
					SELECT SUM(AVG_BOOK_BAL) 
					FROM SALES_EOY_BAL 
					WHERE SUBSTR(SALES_ID,-5,5) = '$npp'
						AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
						AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
						AND PROC_ID = $proc
				),0
			) 
			WHERE SALES_ID = '$npp'
			AND M=$m
			AND Y=$y
			AND PROC_ID = $proc";
			
		return $this->db->query($sql);
	}
	
	function get_new_cust($npp, $m, $y)
	{
		$sql2="
			  UPDATE REALISASI SET PENCAPAIAN = (
			  SELECT 
					COUNT(BNI_SALES_ID) JUMLAH
			  FROM (
					SELECT 
						BNI_SALES_ID, 
						TRIM(CUST_NAME) NAMA,
						BNI_CIF_KEY, 
						CUST_CREATED_DATE
					FROM TMP_TABLE_TST
					WHERE 
						TO_CHAR( EXTRACT(MONTH FROM CUST_CREATED_DATE)) = $m 
						AND TO_CHAR(EXTRACT(YEAR FROM CUST_CREATED_DATE)) = $y
						AND SUBSTR(BNI_SALES_ID,-5,5) = '$npp'
					GROUP BY
						BNI_SALES_ID, 
						CUST_NAME, 
						CUST_CREATED_DATE,
						BNI_CIF_KEY
					ORDER BY
						CUST_CREATED_DATE
				)) 
				WHERE SALES_ID = $npp AND M=$m AND Y=$y AND PROC_ID = 4
				";
				
			$sql="
			  UPDATE REALISASI SET PENCAPAIAN = (
			  SELECT 
					COUNT(BNI_SALES_ID) JUMLAH
			  FROM (
					SELECT 
						SALES_ID, 
						TRIM(CUST_NAME) NAMA,
						CIF_KEY, 
						CREATE_DATE
					FROM NEW_CUSTOMER_FINAL
					WHERE 
						TO_CHAR( EXTRACT(MONTH FROM CREATE_DATE)) = $m 
						AND TO_CHAR(EXTRACT(YEAR FROM CREATE_DATE)) = $y
						AND SUBSTR(SALES_ID,-5,5) = '$npp'
					GROUP BY
						SALES_ID, 
						CUST_NAME, 
						CREATE_DATE,
						CIF_KEY
					ORDER BY
						CREATE_DATE
				)) 
				WHERE SALES_ID = $npp AND M=$m AND Y=$y AND PROC_ID = 4
				";
				
		return $this->db->query($sql);
	}
	
	function get_new_account($npp, $m, $y)
	{
		$sql2="
				UPDATE REALISASI SET PENCAPAIAN = (
				SELECT 
					COUNT(BNI_SALES_ID) JUMLAH
				FROM (
					SELECT 
						BNI_SALES_ID, 
						TRIM(CUST_NAME) NAMA,
						ID_NUMBER, 
						ACCOUNT_OPEN_DATE
					FROM TMP_TABLE_TST
					WHERE 
						TO_CHAR( EXTRACT(MONTH FROM ACCOUNT_OPEN_DATE)) = $m 
						AND TO_CHAR(EXTRACT(YEAR FROM ACCOUNT_OPEN_DATE)) = $y
						AND SUBSTR(BNI_SALES_ID,-5,5) = '$npp'
					GROUP BY
						BNI_SALES_ID, 
						CUST_NAME, 
						ACCOUNT_OPEN_DATE,
						ID_NUMBER
					ORDER BY
						ACCOUNT_OPEN_DATE
				)) 
				WHERE SALES_ID = $npp AND M=$m AND Y=$y AND PROC_ID = 5";
				
		$sql="
				UPDATE REALISASI SET PENCAPAIAN = (
				SELECT 
					COUNT(SALES_ID) JUMLAH
				FROM (
					SELECT 
						SALES_ID, 
						TRIM(CUST_NAME) NAMA,
						ID_NUMBER, 
						OPEN_DATE
					FROM NEW_ACCOUNT_FINAL
					WHERE 
						TO_CHAR( EXTRACT(MONTH FROM OPEN_DATE)) = $m 
						AND TO_CHAR(EXTRACT(YEAR FROM OPEN_DATE)) = $y
						AND SUBSTR(SALES_ID,-5,5) = '$npp'
					GROUP BY
						SALES_ID, 
						CUST_NAME, 
						OPEN_DATE,
						ID_NUMBER
					ORDER BY
						OPEN_DATE
				)) 
				WHERE SALES_ID = $npp AND M=$m AND Y=$y AND PROC_ID = 5";
		return $this->db->query($sql);
	}
	
	function get_rasio($npp,$m,$y)
	{
		$sql="SELECT 
					(
						SELECT COUNT(ID) JML FROM DAILY_ACTIVITY 
						WHERE 
						ACTIVITY = 3
						AND USERID = '$npp'
						AND M=$m
						AND Y=$y
						AND REALISATION = 1						
					) T , 
					 
					(
						SELECT COUNT(ID) JML FROM DAILY_ACTIVITY 
						WHERE 
						ACTIVITY = 5
						AND USERID = '$npp'
						AND M=$m
						AND Y=$y
						AND REALISATION = 1						
					) P ,				
					(
						SELECT COUNT(ID) JML FROM DAILY_ACTIVITY 
						WHERE 
						ACTIVITY = 6
						AND USERID = '$npp'
						AND M=$m
						AND Y=$y
						AND REALISATION = 1						
					) C ,
					(
						SELECT COUNT(ID) JML FROM DAILY_ACTIVITY 
						WHERE ACTIVITY IN (1,2)
						AND USERID = '$npp'
						AND M=$m
						AND Y=$y
					) JML
					FROM DUAL";	
		$result = $this->db->query($sql)->result();
		
		$result[0]->T = ($result[0]->T > $result[0]->JML)?$result[0]->JML:$result[0]->T;
		$result[0]->P = ($result[0]->P > $result[0]->JML)?$result[0]->JML:$result[0]->P;
		$result[0]->C = ($result[0]->C > $result[0]->JML)?$result[0]->JML:$result[0]->C;
		
		$data['1'] = ($result[0]->JML==0)?0:round(($result[0]->T/$result[0]->JML)*100);
		$data['2'] = ($result[0]->JML==0)?0:round(($result[0]->P/$result[0]->JML)*100);
		$data['3'] = ($result[0]->JML==0)?0:round(($result[0]->C/$result[0]->JML)*100);
				
		$sql="  SELECT PENCAPAIAN FROM REALISASI WHERE PRODUCT_ID IN (16,17,18)
				AND M=$m
				AND Y=$y
				AND SALES_ID = '$npp' ";
		$cekRasio = $this->db->query($sql)->result();
		
		$n = 1;
		foreach($cekRasio as $row)
		{
			$pencapaian = ($data[$n] > 100)?100:$data[$n];
			$sql="UPDATE REALISASI SET PENCAPAIAN = ".$pencapaian."
					WHERE PRODUCT_ID = ". (15+$n) ."
					AND SALES_ID = '$npp'
					AND M=$m
					AND Y=$y";
			$this->db->query($sql);
			$n++;
		}
	}
	
}