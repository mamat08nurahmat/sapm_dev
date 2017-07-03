<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _realisasi extends Model 
{
	public function _realisasi()
    {
        parent::Model();
		$this->CI =& get_instance();
    }
	
	public function get_sales_wilayah($region)
	{
			$sql = "SELECT ID FROM USER_TST WHERE BRANCH IN (SELECT BRANCH_CODE FROM BRANCH WHERE REGION = $region)";
			$result = $this->db->query($sql)->result();
			$list  = '';
			if($result){
				foreach($result as $row){
						$list .= $row->ID.',';
				}
				$list = rtrim($list,',');
				return '('.$list.')';
			} else { return false; }
	}
	
	public function get_target() 
	{		
		//Build contents query
		$table_name = 'VIEW_TARGET';
		$region = $this->session->userdata('REGION'); 
		$branch = $this->session->userdata('BRANCH_ID');		
		$this->db->select('ID, USER_NAME, SALES_TYPE, SPV, YEAR');	
		
		$npp = $this->session->userdata('ID');
		$where = '';
		$lvl = $this->session->userdata('USER_LEVEL');
		if($lvl == 'SUPERVISOR' || $lvl == 'SUPER VISOR' )
			$where = array("SPV"=>"$npp");
		else if($lvl == 'TIM' || $lvl == 'SLN') 
			$where = array("ID <> "=>"X");
		else if($lvl == 'CABANG') 
			$where = array("BRANCH"=>"$branch");
		else if($lvl == 'WILAYAH')
		{
			//$list = $this->get_sales_wilayah($region);
			//$where = "ID IN $list";
			
			$where = array("SPV"=>"$npp");
		}
		
		$this->db->where($where);
		
		$this->db->from($table_name);
		
		$this->CI->flexigrid->build_query();
		
		//Get contents
		$return['records'] = $this->db->get();
		
		//Build count query
		$this->db->select('count(ID) as RECORD_COUNT')->from($table_name);
		$this->db->where($where);
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		//Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		//Return all
		return $return;
	}
	
	function hitung_performance($bln, $thn, $npp ,$salestype)
	{
		if($thn>=2017&&($salestype==23||$salestype==25))
		{
			$sql= "CALL INDIVIDU_PERFORMANCE_NEW($bln, $thn, '$npp')";
		}
		else if($thn>=2017&&$bln>=2&&($salestype==20||$salestype==21||$salestype==22))
		{
			$sql= "CALL INDIVIDU_PERFORMANCE_EMERALD($bln, $thn, '$npp')";
		}
		else
		{
			$sql = "CALL INDIVIDU_PERFORMANCE($bln, $thn, '$npp')";
		}
		$this->db->query($sql);
	}
	
	function manual_performance($bln, $thn)
	{
		$sql = "CALL MANUAL_HITUNG_PERFORMANCE($bln, $thn)";
		$this->db->query($sql);
	}

	function get_dpk($npp, $m, $y, $proc)
	{
		$sql="UPDATE REALISASI SET PENCAPAIAN = ROUND((
				
				SELECT SUM(AVG_BOOK_BAL) FROM
					(				
						SELECT AVG_BOOK_BAL FROM SALES_EOY_BAL 
						WHERE SUBSTR(SALES_ID,-5,5) = '$npp'
						AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
						AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
						AND PROC_ID = $proc 
						GROUP BY AS_OF_DATE, SALES_ID, PROC_ID, CUR_BOOK_BAL, AVG_BOOK_BAL						
					)
				),0
			) 
			WHERE SALES_ID = '$npp'
			AND M=$m
			AND Y=$y
			AND PROC_ID = $proc";
			
		return $this->db->query($sql);
	}
	
	function get_daily_griya($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(4=>0);
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME LIKE '%GRIYA%'
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[4] = $row->NOMINAL_BOOKING;
				}		
				
		} 
		
		else if($tgl < 3 and $m==$m_now-1)
		{
			
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME LIKE '%GRIYA%'
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 1
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[4] = $row->NOMINAL_BOOKING;
				}	
			}			
		} 
		
		else
		{
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME LIKE '%GRIYA%'
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[4] = $row->NOMINAL_BOOKING;
				}		
				
		}
		}
		
		
		if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{
			
				
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[4]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 4";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 4";
				
					if($product[4] == 0) {
						$this->db->query($sqle);
				
					}
					else
					{
						$this->db->query($sqlx);
					}
									
				}
				
		}			
	}
	
	function get_daily_fleksi($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(5=>0);
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME LIKE '%FLEKSI%'
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[5] = $row->NOMINAL_BOOKING;
				}		
				
		} 
		
		else if($tgl < 3 and $m==$m_now-1)
		{
			
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME LIKE '%FLEKSI%'
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 1
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[5] = $row->NOMINAL_BOOKING;
				}	
			}			
		} 
		
		else
		{
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME LIKE '%FLEKSI%'
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[5] = $row->NOMINAL_BOOKING;
				}		
				
		}
		}
		
		
		if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{
			
				
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[5]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 5";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 5";
				
					if($product[5] == 0) {
						$this->db->query($sqle);
				
					}
					else
					{
						$this->db->query($sqlx);
					}
									
				}
				
		}			
	}
	
	function get_daily_multiguna($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(6=>0);
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME = 'BNI MULTIGUNA'
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[6] = $row->NOMINAL_BOOKING;
				}		
				
		} 
		
		else if($tgl < 3 and $m==$m_now-1)
		{
			
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME LIKE '%FLEKSI%'
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 1
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[6] = $row->NOMINAL_BOOKING;
				}	
			}			
		} 
		
		else
		{
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME LIKE '%FLEKSI%'
					AND PRODUCT_NAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[6] = $row->NOMINAL_BOOKING;
				}		
				
		}
		}
		
		
		if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{
			
				
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[6]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 6";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 6";
				
					if($product[6] == 0) {
						$this->db->query($sqle);
				
					}
					else
					{
						$this->db->query($sqlx);
					}
									
				}
				
		}			
	}
	
	function get_daily_bwu($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(8=>0);
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME LIKE '%WIRAUSAHA%'
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[8] = $row->NOMINAL_BOOKING;
				}		
				
		} 
		
		else if($tgl < 3 and $m==$m_now-1)
		{
			
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME LIKE '%WIRAUSAHA%'
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 1
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[8] = $row->NOMINAL_BOOKING;
				}	
			}			
		} 
		
		else
		{
			$sql = "SELECT NVL(SUM(NOMINAL_BOOKING),0) NOMINAL_BOOKING,
                    SUM(TOTAL_BOOKING) TOTAL_BOOKING
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
                    AND GROUP_NAME LIKE '%WIRAUSAHA%'
					AND PRODUCT_NAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[8] = $row->NOMINAL_BOOKING;
				}		
				
		}
		}
		
		
		if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{
			
				
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[8]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 8";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 8";
				
					if($product[8] == 0) {
						$this->db->query($sqle);
				
					}
					else
					{
						$this->db->query($sqlx);
					}
									
				}
				
		}			
	}
	
	function get_acc_konsumer($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(25=>0);
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			$sql = "SELECT NVL(SUM(TOTAL_BOOKING),0) JUMLAH
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND GROUP_NAME NOT LIKE '%WIRAUSAHA%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[25] = $row->JUMLAH;
				}		
				
		} 
		
		else if($tgl < 3 and $m==$m_now-1)
		{
			
			$sql = "SELECT  NVL(SUM(TOTAL_BOOKING),0) JUMLAH
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND GROUP_NAME NOT LIKE '%WIRAUSAHA%'
					AND LAST_MONTH = 1
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[25] = $row->JUMLAH;
				}	
			}			
		} 
		
		else
		{
			$sql = "SELECT  NVL(SUM(TOTAL_BOOKING),0) JUMLAH
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND GROUP_NAME NOT LIKE '%WIRAUSAHA%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[25] = $row->JUMLAH;
				}		
				
		}
		}
		
		
		if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{
			
				
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[25]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 25";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 25";
				
					if($product[25] == 0) {
						$this->db->query($sqle);
				
					}
					else
					{
						//echo $sqlx;die();
						$this->db->query($sqlx);
					}
									
				}
				
		}			
	}
	
	function get_acc_ritel($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(26=>0);
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			$sql = "SELECT  NVL(SUM(TOTAL_BOOKING),0) JUMLAH
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND GROUP_NAME LIKE '%WIRAUSAHA%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[26] = $row->JUMLAH;
				}		
				
		} 
		
		else if($tgl < 3 and $m==$m_now-1)
		{
			
			$sql = "SELECT  NVL(SUM(TOTAL_BOOKING),0) JUMLAH
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND GROUP_NAME LIKE '%WIRAUSAHA%'
					AND LAST_MONTH = 1
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[26] = $row->JUMLAH;
				}	
			}			
		} 
		
		else
		{
			$sql = "SELECT  NVL(SUM(TOTAL_BOOKING),0)JUMLAH
                    FROM
                    (
                    SELECT NPP_SALES,GROUP_NAME,TOTAL_BOOKING,NOMINAL_BOOKING 
                    FROM SAPM_ELO_BOOKING 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND GROUP_NAME LIKE '%WIRAUSAHA%'
					AND LAST_MONTH = 0
                    GROUP BY GROUP_NAME,NPP_SALES,TOTAL_BOOKING,NOMINAL_BOOKING
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[26] = $row->JUMLAH;
				}		
				
		}
		}
		
		
		if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{
			
				
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[26]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 26";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 26";
				
					if($product[26] == 0) {
						$this->db->query($sqle);
				
					}
					else
					{
						$this->db->query($sqlx);
					}
									
				}
				
		}			
	}
	
	function get_approval_rate($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(37=>0);
		$apply=0;
		$approve=0;
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			$sql = "SELECT NVL(SUM(APPLY_APP),0) APPLY
                    FROM
                    (
                    SELECT NPP_SALES, APPLY_APP
                    FROM SAPM_ELO_APPLY 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY NPP_SALES,APPLY_APP
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$apply = $row->APPLY;
				}
				}
		
		$sql2 = "SELECT NVL(SUM(APPR_APP),0) APPROVE
                    FROM
                    (
                    SELECT NPP_SALES, APPR_APP
                    FROM SAPM_ELO_APPROVAL 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY NPP_SALES,APPR_APP
					)";	
			$result2 = $this->db->query($sql2)->result();	
			
			if($result2) {
				foreach($result2 as $row2)
				{
					$approve = $row2->APPROVE;
				}
				
			$product[37]=($approve*100)/$apply;
				
		} 
		}
		
		else if($tgl < 3 and $m==$m_now-1)
		{
			
			$sql = "SELECT NVL(SUM(APPLY_APP),0) APPLY
                    FROM
                    (
                    SELECT NPP_SALES, APPLY_APP
                    FROM SAPM_ELO_APPLY 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 1
                    GROUP BY NPP_SALES,APPLY_APP
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$apply = $row->APPLY;
				}
				}
		
		$sql2 = "SELECT NVL(SUM(APPR_APP),0) APPROVE
                    FROM
                    (
                    SELECT NPP_SALES, APPR_APP
                    FROM SAPM_ELO_APPROVAL 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m-1
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 1
                    GROUP BY NPP_SALES,APPR_APP
					)";	
			$result2 = $this->db->query($sql2)->result();	
			
			if($result2) {
				foreach($result2 as $row2)
				{
					$approve = $row2->APPROVE;
				}
				}
			
			if($apply == 0 )
			{
			$product[37]=0;
			}
			else
			{
			$product[37]=($approve*100)/$apply;
			}
		} 
		
		else
		{
			$sql = "SELECT NVL(SUM(APPLY_APP),0) APPLY
                    FROM
                    (
                    SELECT NPP_SALES, APPLY_APP
                    FROM SAPM_ELO_APPLY 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY NPP_SALES,APPLY_APP
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$apply = $row->APPLY;
				}
				}
		
		$sql2 = "SELECT NVL(SUM(APPR_APP),0) APPROVE
                    FROM
                    (
                    SELECT NPP_SALES, APPR_APP
                    FROM SAPM_ELO_APPROVAL 
                    WHERE SUBSTR(NPP_SALES,-5,5) = '$npp'
                    AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
                    AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					AND PRODUCTNAME NOT LIKE '%TOP UP%'
					AND LAST_MONTH = 0
                    GROUP BY NPP_SALES,APPR_APP
					)";	
			$result2 = $this->db->query($sql2)->result();	
			
			if($result2) {
				foreach($result2 as $row2)
				{
					$approve = $row2->APPROVE;
				}
				}
				
			if($apply == 0 )
			{
			$product[37]=0;
			}
			else
			{
			$product[37]=($approve*100)/$apply;
			}
		}
		
		
		if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{
			
				
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[37]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 37";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 37";
				
					if($product[37] == 0) {
						$this->db->query($sqle);
				
					}
					else
					{
						$this->db->query($sqlx);
					}
									
				}
				
		}			
	
	function get_daily_ccos($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(17=>0);
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			$sql = "SELECT NVL(SUM(CC_APPR),0) JUMLAH_CC
					FROM SAPM_CC
					WHERE SUBSTR(SALES_ID,-5,5) = '$npp'
					AND EXTRACT(MONTH FROM TO_DATE(AS_OF_DATE)) = $m
					AND EXTRACT(YEAR FROM TO_DATE(AS_OF_DATE)) = $y
					AND LAST_MONTH = 0
					";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[17] = $row->JUMLAH_CC;
				}		
				
		} 
		}
		
		else if($tgl < 3 and $m==$m_now-1)
		{
			
			$sql = "SELECT NVL(SUM(CC_APPR),0) JUMLAH_CC
					FROM SAPM_CC
					WHERE SUBSTR(SALES_ID,-5,5) = '$npp'
					AND EXTRACT(MONTH FROM TO_DATE(AS_OF_DATE)) = $m
					AND EXTRACT(YEAR FROM TO_DATE(AS_OF_DATE)) = $y
					AND LAST_MONTH = 1
					";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[17] = $row->JUMLAH_CC;
				}		
		} 
		}
		
		else
		{
			$sql = "SELECT NVL(SUM(CC_APPR),0) JUMLAH_CC
					FROM SAPM_CC
					WHERE SUBSTR(SALES_ID,-5,5) = '$npp'
					AND EXTRACT(MONTH FROM TO_DATE(AS_OF_DATE)) = $m
					AND EXTRACT(YEAR FROM TO_DATE(AS_OF_DATE)) = $y
					AND LAST_MONTH = 1
					";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[17] = $row->JUMLAH_CC;
				}
				
		}
		}
		
		/*
		if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{*/
			
				
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[17]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 17";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 17";
				
					if($product[17] == 0) {
						$this->db->query($sqle);
				
					}
					else
					{
						$this->db->query($sqlx);
					}
									
				}
				
		//}

function get_daily_dplk($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(21=>0);
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			$sql = "SELECT NVL(COUNT(NOREK),0) JUMLAH_DPLK
					FROM SAPM_DPLK
					WHERE SUBSTR(SALESID,-5,5) = '$npp'
					AND EXTRACT(MONTH FROM TO_DATE(TGLBUKA)) = $m
					AND EXTRACT(YEAR FROM TO_DATE(TGLBUKA)) = $y
					";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[21] = $row->JUMLAH_DPLK;
				}		
				
		} 
		}
		
		else if($tgl < 3 and $m==$m_now-1)
		{
			
			$sql = "SELECT NVL(COUNT(NOREK),0) JUMLAH_DPLK
					FROM SAPM_DPLK
					WHERE SUBSTR(SALESID,-5,5) = '$npp'
					AND EXTRACT(MONTH FROM TO_DATE(TGLBUKA)) = $m
					AND EXTRACT(YEAR FROM TO_DATE(TGLBUKA)) = $y
					";
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[21] = $row->JUMLAH_DPLK;
				}		
		} 
		}
		
		else
		{
			$sql = "SELECT NVL(COUNT(NOREK),0) JUMLAH_DPLK
					FROM SAPM_DPLK
					WHERE SUBSTR(SALESID,-5,5) = '$npp'
					AND EXTRACT(MONTH FROM TO_DATE(TGLBUKA)) = $m
					AND EXTRACT(YEAR FROM TO_DATE(TGLBUKA)) = $y
					";
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[21] = $row->JUMLAH_DPLK;
				}
				
		}
		}
		
		
		/*if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{*/
		
			
				
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[21]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 21";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 21";
				
					if($product[21] == 0) {
						$this->db->query($sqle);
				
					}
					else
					{
						$this->db->query($sqlx);
					}
									
				}
	
	
		//}			
	
function get_daily_dplk_bb($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(22=>0);
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			$sql = "SELECT NVL(COUNT(NOREK),0) JUMLAH_DPLK
					FROM SAPM_DPLK_BB
					WHERE SUBSTR(SALESID,-5,5) = '$npp'
					AND EXTRACT(MONTH FROM TO_DATE(TGLBUKA)) = $m
					AND EXTRACT(YEAR FROM TO_DATE(TGLBUKA)) = $y
					";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[22] = $row->JUMLAH_DPLK;
				}		
				
		} 
		}
		
		else if($tgl < 3 and $m==$m_now-1)
		{
			
			$sql = "SELECT NVL(COUNT(NOREK),0) JUMLAH_DPLK
					FROM SAPM_DPLK_BB
					WHERE SUBSTR(SALESID,-5,5) = '$npp'
					AND EXTRACT(MONTH FROM TO_DATE(TGLBUKA)) = $m
					AND EXTRACT(YEAR FROM TO_DATE(TGLBUKA)) = $y
					";
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[22] = $row->JUMLAH_DPLK;
				}		
		} 
		}
		
		else
		{
			$sql = "SELECT NVL(COUNT(NOREK),0) JUMLAH_DPLK
					FROM SAPM_DPLK_BB
					WHERE SUBSTR(SALESID,-5,5) = '$npp'
					AND EXTRACT(MONTH FROM TO_DATE(TGLBUKA)) = $m
					AND EXTRACT(YEAR FROM TO_DATE(TGLBUKA)) = $y
					";
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[22] = $row->JUMLAH_DPLK;
				}
				
		}
		}
		
		
		/*if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{*/
		
			
				
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[22]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 22";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PRODUCT_ID = 22";
				
					if($product[22] == 0) {
						$this->db->query($sqle);
				
					}
					else
					{
						$this->db->query($sqlx);
					}
									
				}	
	
	function get_daily_dpk($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(1=>0,2=>0,3=>0);
		
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			/*$sql = "SELECT 
						SUM(TABUNGAN) TABUNGAN, 
						SUM(DEPOSITO) DEPOSITO, 
						SUM(GIRO) GIRO, 
						SUM(DPK) DPK 
					FROM
					(                
						SELECT BNI_CIF_KEY,TABUNGAN, DEPOSITO, GIRO, DPK FROM TMP_NASABAH_KELOLAAN 
						WHERE SUBSTR(BNI_SALES_ID,-5,5) = '$npp'
							AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
							AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
							AND LAST_MONTH = 0 
							AND CUST_TYPE IN (1,5)
						    GROUP BY AS_OF_DATE,BNI_CIF_KEY,SUBSTR(BNI_SALES_ID,-5,5), TABUNGAN, DEPOSITO, GIRO, DPK                  
					)";	*/
					
			$sql="SELECT 
						SUM(TABUNGAN) TABUNGAN, 
						SUM(DEPOSITO) DEPOSITO, 
						SUM(GIRO) GIRO,
						SUM(SUM(TABUNGAN)+SUM(GIRO)+SUM(DEPOSITO)) DPK
					FROM
					(                
						select d.as_of_date,x.sales_id,x.cif_key,
                CASE
                 WHEN e.status_id = 0 then nvl(d.tabungan,0) 
                 WHEN e.status_id = 1 and nvl(d.tabungan,0) -nvl(a.tabungan,0) < 0 then nvl(a.tabungan,0)
                 else nvl(d.tabungan,0)
                END AS TABUNGAN,
                 CASE
                 WHEN e.status_id = 0 then nvl(d.giro,0) 
                 WHEN e.status_id = 1 and nvl(d.giro,0) -nvl(b.giro,0) < 0 then nvl(b.giro,0)
                 else nvl(d.giro,0)
                END AS GIRO,
                 CASE
                 WHEN e.status_id = 0 then nvl(d.deposito,0) 
                 WHEN e.status_id = 1 and nvl(d.deposito,0) -nvl(c.deposito,0) < 0 then nvl(c.deposito,0)
                 else nvl(d.deposito,0)
                END AS DEPOSITO         
                    from
                (
                    select bni_cif_key cif_key,bni_sales_id sales_id from TMP_NASABAH_KELOLAAN where bni_sales_id = $npp and LAST_MONTH = 0
					and CUST_TYPE IN(1,5) 
                    union
                    select cif_key,to_char(sales_id)  from TMP_BASELINE_2016 where sales_id = $npp and CUST_TYPE = 'CR'
                )x
                left join
                (    select 
                    sales_id,cif_key,sum(bni_cur_book_bal_idr) giro_cur,sum(avg_book_bal) giro
                    from TMP_BASELINE_2016 where product_id = 1 
					and sales_id = $npp
                    group by sales_id,cif_key) b
                on x.sales_id = b.sales_id and x.cif_key = b.cif_key
                left join
                (select 
                    sales_id,cif_key,sum(bni_cur_book_bal_idr) tabungan_cur,sum(avg_book_bal) tabungan
                    from TMP_BASELINE_2016 where product_id = 2 
					and sales_id = $npp
                    group by sales_id,cif_key)a
                on x.sales_id = a.sales_id and x.cif_key = a.cif_key
                left join
                ( select 
                    sales_id,cif_key,sum(bni_cur_book_bal_idr) DEPOSITO_cur,sum(avg_book_bal) DEPOSITO
                    from TMP_BASELINE_2016 where product_id = 3
					and sales_id = $npp
                    group by sales_id,cif_key) c
                    on x.sales_id = c.sales_id and x.cif_key = c.cif_key
                    left join
                (select 
                    as_of_date,bni_cif_key,cust_name,branch_name,open_branch,bni_sales_id,TABUNGAN_CUR,TABUNGAN,GIRO_CUR,GIRO,DEPOSITO_CUR,DEPOSITO
                    from TMP_NASABAH_KELOLAAN where  bni_sales_id = $npp and LAST_MONTH = 0 and CUST_TYPE IN(1,5)) d
                    on x.sales_id = d.bni_sales_id and x.cif_key = d.bni_cif_key
                    left join flagging_status e
                    on x.cif_key||'$npp' = e.id   
					WHERE EXTRACT(MONTH FROM d.AS_OF_DATE) = $m 
							AND EXTRACT(YEAR FROM d.AS_OF_DATE) = $y					
					)
					GROUP BY TABUNGAN,GIRO,DEPOSITO";
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[1] = $row->GIRO;
					$product[2] = $row->TABUNGAN;
					$product[3] = $row->DEPOSITO;
                    //echo $product[1];
					//echo "boo";
				}	
			}		
				//if($product[1] = ' ') { $product[1] = 0; }
				//else if ($product[2] = ' ') { $product[2] = 0; }
				//else if ($product[3] = ' ') { $product[3] = 0; }
				
		} 
		
		else if($tgl < 5 and $m==$m_now-1)
		{
			//echo $m;die();
			/*$sql = "SELECT 
						SUM(TABUNGAN) TABUNGAN, 
						SUM(DEPOSITO) DEPOSITO, 
						SUM(GIRO) GIRO, 
						SUM(DPK) DPK 
					FROM
					(                
						SELECT TABUNGAN, DEPOSITO, GIRO, DPK FROM TMP_NASABAH_KELOLAAN 
						WHERE SUBSTR(BNI_SALES_ID,-5,5) = '$npp'
							AND EXTRACT(MONTH FROM AS_OF_DATE) = $m
							AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
							AND LAST_MONTH = 0 
							AND CUST_TYPE IN (1,5)
						    GROUP BY AS_OF_DATE, SUBSTR(BNI_SALES_ID,-5,5), TABUNGAN, DEPOSITO, GIRO, DPK                  
					)";	*/
					
			$sql="SELECT 
						SUM(TABUNGAN) TABUNGAN, 
						SUM(DEPOSITO) DEPOSITO, 
						SUM(GIRO) GIRO,
						SUM(SUM(TABUNGAN)+SUM(GIRO)+SUM(DEPOSITO)) DPK
					FROM
					(                
						select d.as_of_date,x.sales_id,x.cif_key,
                CASE
                 WHEN e.status_id = 0 then nvl(d.tabungan,0) 
                 WHEN e.status_id = 1 and nvl(d.tabungan,0) -nvl(a.tabungan,0) < 0 then nvl(a.tabungan,0)
                 else nvl(d.tabungan,0)
                END AS TABUNGAN,
                 CASE
                 WHEN e.status_id = 0 then nvl(d.giro,0) 
                 WHEN e.status_id = 1 and nvl(d.giro,0) -nvl(b.giro,0) < 0 then nvl(b.giro,0)
                 else nvl(d.giro,0)
                END AS GIRO,
                 CASE
                 WHEN e.status_id = 0 then nvl(d.deposito,0) 
                 WHEN e.status_id = 1 and nvl(d.deposito,0) -nvl(c.deposito,0) < 0 then nvl(c.deposito,0)
                 else nvl(d.deposito,0)
                END AS DEPOSITO         
                    from
                (
                    select bni_cif_key cif_key,bni_sales_id sales_id from TMP_NASABAH_KELOLAAN where bni_sales_id = $npp and LAST_MONTH = 0
					and CUST_TYPE IN(1,5) 
                    union
                    select cif_key,to_char(sales_id)  from TMP_BASELINE_2016 where sales_id = $npp and CUST_TYPE = 'CR'
                )x
                left join
                (    select 
                    sales_id,cif_key,sum(bni_cur_book_bal_idr) giro_cur,sum(avg_book_bal) giro
                    from TMP_BASELINE_2016 where product_id = 1 
					and sales_id = $npp
                    group by sales_id,cif_key) b
                on x.sales_id = b.sales_id and x.cif_key = b.cif_key
                left join
                (select 
                    sales_id,cif_key,sum(bni_cur_book_bal_idr) tabungan_cur,sum(avg_book_bal) tabungan
                    from TMP_BASELINE_2016 where product_id = 2 
					and sales_id = $npp
                    group by sales_id,cif_key)a
                on x.sales_id = a.sales_id and x.cif_key = a.cif_key
                left join
                ( select 
                    sales_id,cif_key,sum(bni_cur_book_bal_idr) DEPOSITO_cur,sum(avg_book_bal) DEPOSITO
                    from TMP_BASELINE_2016 where product_id = 3
					and sales_id = $npp
                    group by sales_id,cif_key) c
                    on x.sales_id = c.sales_id and x.cif_key = c.cif_key
                    left join
                (select 
                    as_of_date,bni_cif_key,cust_name,branch_name,open_branch,bni_sales_id,TABUNGAN_CUR,TABUNGAN,GIRO_CUR,GIRO,DEPOSITO_CUR,DEPOSITO
                    from TMP_NASABAH_KELOLAAN where  bni_sales_id = $npp and LAST_MONTH = 0 and CUST_TYPE IN(1,5)) d
                    on x.sales_id = d.bni_sales_id and x.cif_key = d.bni_cif_key
                    left join flagging_status e
                    on x.cif_key||'$npp' = e.id  
					WHERE EXTRACT(MONTH FROM d.AS_OF_DATE) = $m 
							AND EXTRACT(YEAR FROM d.AS_OF_DATE) = $y	
					)
					GROUP BY TABUNGAN,GIRO,DEPOSITO";
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[1] = $row->GIRO;
					$product[2] = $row->TABUNGAN;
					$product[3] = $row->DEPOSITO;
                    //echo $product[1];
					//echo "boo";
				}	
			}			
		} 
		
		
		#-------------------------------------------------
		#	cek jika bln lalu ambil realisasi lastmonth
		#-------------------------------------------------
		#remark by fredy
		//else if(($m==$m_now && $y==$y_now) ||($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu) || ($y==$y_now))
		else
		{
			//echo "masuk sini";die();
			$sql = "SELECT SUM(AVG_BOOK_BAL) SALDO, PROC_ID FROM SALES_EOY_BAL 
					WHERE 
						SUBSTR(SALES_ID,-5,5) = '$npp'
						AND EXTRACT(MONTH FROM AS_OF_DATE) = $m
						AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					GROUP BY PROC_ID
					ORDER BY PROC_ID";
			
			$result = $this->db->query($sql)->result();
			$i = 1;
			if($result) {
				foreach($result as $row)
				{
					$product[$i] = $row->SALDO;
					//echo $product[$i]; echo "<br>";
					//echo "boo";
					$i++;				
				}
			}		
		}
		
		if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{
				$dpk=0;
				for($i=1;$i<=3;$i++)
				{
					//echo "masuk sini";die();
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[$i]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PROC_ID = $i";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PROC_ID = $i";
					//echo "$sqlx";
					//if($product[$i])
					//echo $sqlx;die();
					//echo $product[$i];die();
					if($product[$i] == 0) {
					//echo "boo";die();
					$this->db->query($sqle);
					}
					else
					{
					$this->db->query($sqlx);
					}
					$dpk += $product[$i]; 					
				}
				
				$sql = "UPDATE REALISASI SET PENCAPAIAN = ROUND($dpk)
						WHERE SALES_ID = '$npp'
									AND M=$m
									AND Y=$y
									AND PROC_ID =99";
				$this->db->query($sql);
				
			#-------------------------------------------------
			#	UPDATE total penurunan dpk
			#-------------------------------------------------
			$this->update_total_penurunan_dpk ($npp, $m, $y);
			#-------------------------------------------------
			#	UPDATE total penurunan AUM
			#-------------------------------------------------
			$this->update_total_penurunan_aum ($npp, $m, $y);
		}			
	}
	
	function get_daily_dpk_bb($npp, $m, $y)
	{	
		#--------------------------------------------
		#	simpan data bulan dan tahun active
		#--------------------------------------------
		$tgl = date('j');
		$m_now = date('n');
		$y_now = date('Y');
		$bulanlalu 	= date('n', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$tahunbulanlalu 	= date('Y', mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
		$product = array(4=>0,5=>0,6=>0);
		
		
		$lastmonth = (($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu))?1:0;
		
		#--------------------------------------------
		#	cek jika bln = bln skr ambil realisasi harian
		#--------------------------------------------
		if($m_now==$m && $y==$y_now)
		{
			$sql = "SELECT 
						SUM(TABUNGAN) TABUNGAN, 
						SUM(DEPOSITO) DEPOSITO, 
						SUM(GIRO) GIRO, 
						SUM(DPK) DPK 
					FROM
					(                
						SELECT BNI_CIF_KEY,TABUNGAN, DEPOSITO, GIRO, DPK FROM TMP_NASABAH_KELOLAAN_BB
						WHERE SUBSTR(BNI_SALES_ID,-5,5) = '$npp'
							AND EXTRACT(MONTH FROM AS_OF_DATE) = $m 
							AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
							AND LAST_MONTH = 0 
							AND CUST_TYPE IN (2,3,4)
						    GROUP BY AS_OF_DATE,BNI_CIF_KEY,SUBSTR(BNI_SALES_ID,-5,5), TABUNGAN, DEPOSITO, GIRO, DPK                  
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[4] = $row->GIRO;
					$product[5] = $row->TABUNGAN;
					$product[6] = $row->DEPOSITO;
                    //echo $product[1];
					//echo "boo";
				}	
			}		
				//if($product[1] = ' ') { $product[1] = 0; }
				//else if ($product[2] = ' ') { $product[2] = 0; }
				//else if ($product[3] = ' ') { $product[3] = 0; }
				
		} 
		
		else if($tgl < 3 and $m==$m_now-1)
		{
			//echo $m;die();
			$sql = "SELECT 
						SUM(TABUNGAN) TABUNGAN, 
						SUM(DEPOSITO) DEPOSITO, 
						SUM(GIRO) GIRO, 
						SUM(DPK) DPK 
					FROM
					(                
						SELECT TABUNGAN, DEPOSITO, GIRO, DPK FROM TMP_NASABAH_KELOLAAN_BB 
						WHERE SUBSTR(BNI_SALES_ID,-5,5) = '$npp'
							AND EXTRACT(MONTH FROM AS_OF_DATE) = $m
							AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
							AND LAST_MONTH = 0 
							AND CUST_TYPE IN (2,3,4)
						    GROUP BY AS_OF_DATE, SUBSTR(BNI_SALES_ID,-5,5), TABUNGAN, DEPOSITO, GIRO, DPK                  
					)";	
			$result = $this->db->query($sql)->result();	
			
			if($result) {
				foreach($result as $row)
				{
					$product[4] = $row->GIRO;
					$product[5] = $row->TABUNGAN;
					$product[6] = $row->DEPOSITO;
                    //echo $product[1];
					//echo "boo";
				}	
			}			
		} 
		
		
		#-------------------------------------------------
		#	cek jika bln lalu ambil realisasi lastmonth
		#-------------------------------------------------
		#remark by fredy
		//else if(($m==$m_now && $y==$y_now) ||($m==$bulanlalu && $y==$y_now) || ($m==$bulanlalu && $y==$tahunbulanlalu) || ($y==$y_now))
		else
		{
			//echo "masuk sini";die();
			$sql = "SELECT SUM(AVG_BOOK_BAL) SALDO, PROC_ID FROM SALES_EOY_BAL_BB 
					WHERE 
						SUBSTR(SALES_ID,-5,5) = '$npp'
						AND EXTRACT(MONTH FROM AS_OF_DATE) = $m
						AND EXTRACT(YEAR FROM AS_OF_DATE) = $y
					GROUP BY PROC_ID
					ORDER BY PROC_ID";
			
			$result = $this->db->query($sql)->result();
			$i = 4;
			if($result) {
				foreach($result as $row)
				{
					$product[$i] = $row->SALDO;
					//echo $product[$i]; echo "<br>";
					//echo "boo";
					$i++;				
				}
			}		
		}
		
		if( ($m==$m_now && $y==$y_now) ||
			($m==$bulanlalu && $y==$y_now) || 
			($m==$bulanlalu && $y==$y_now-1) ||
			($y=$y_now))
		{
				$dpk=0;
				for($i=4;$i<=6;$i++)
				{
					//echo "masuk sini";die();
					$sqlx="UPDATE REALISASI SET PENCAPAIAN = NVL(ROUND((".$product[$i]."),0),0) 
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PROC_ID = $i";
							
					$sqle = "UPDATE REALISASI SET PENCAPAIAN = 0
							WHERE SALES_ID = '$npp'
							AND M=$m
							AND Y=$y
							AND PROC_ID = $i";
					//echo "$sqlx";
					//if($product[$i])
					//echo $sqlx;die();
					//echo $product[$i];die();
					if($product[$i] == 0) {
					//echo "boo";die();
					$this->db->query($sqle);
					}
					else
					{
						//echo $sqlx;
					$this->db->query($sqlx);
					}
					$dpk += $product[$i]; 					
					//echo $sqlx;
				}
				
				$sql = "UPDATE REALISASI SET PENCAPAIAN = ROUND($dpk)
						WHERE SALES_ID = '$npp'
									AND M=$m
									AND Y=$y
									AND PROC_ID =99";
				$this->db->query($sql);
				
			#-------------------------------------------------
			#	UPDATE total penurunan dpk
			#-------------------------------------------------
			$this->update_total_penurunan_dpk ($npp, $m, $y);
			#-------------------------------------------------
			#	UPDATE total penurunan AUM
			#-------------------------------------------------
			$this->update_total_penurunan_aum ($npp, $m, $y);
		}			
	}
	
	function update_total_penurunan_dpk ($npp, $m, $y)
	{
		#-----------------------------------------
		# Sql formula target with 0,75% (obsolete)
		#-----------------------------------------
		#$sql_bak = "UPDATE REALISASI SET TARGET = (
		#				SELECT NVL((ROUND(SUM(TARGET)*0.75)),0)+NVL(ROUND(SUM(OUTSTANDING)),0) TARGET FROM REALISASI 
		#				WHERE SALES_ID = '$npp' AND M = $m AND Y = $y
		#				AND PROC_ID IN (1,2,3)
		#			) 
		#			WHERE 
		#			SALES_ID = '$npp' AND M = $m AND Y = $y
		#			AND PROC_ID = 10";
		
		#-----------------------------------------
		#get lastmonth from parameter month & year
		#-----------------------------------------
		$m2 = date('n', mktime(0, 0, 0, $m - 1, 1, $y));
		$y2 = date('Y', mktime(0, 0, 0, $m - 1, 1, $y));			
		#---------------------------------------------------
		#get lastmonth realisasi from parameter month & year
		#---------------------------------------------------
		
		$sql = "SELECT NVL(SUM(PENCAPAIAN),0) PENCAPAIAN FROM REALISASI WHERE SALES_ID = $npp AND M = $m2 AND Y = $y2 AND PROC_ID IN (1,2,3)";
		$result = $this->db->query($sql)->result();
		
		
		if($result && $result[0]->PENCAPAIAN==0 || $m==1)
		{ $var='OUTSTANDING'; $m2=$m; $y2=$y; $proc_id = "1,2,3";}		
		else { $var='PENCAPAIAN'; $proc_id = "1,2,3";}
		
		$sql = "UPDATE REALISASI SET TARGET = (
						SELECT NVL(SUM(NVL($var,0)),0) PENCAPAIAN FROM REALISASI 
						WHERE SALES_ID = '$npp' AND M = $m2 AND Y = $y2
						AND PROC_ID IN ($proc_id)
					) 
					WHERE 
					SALES_ID = '$npp' AND M = $m AND Y = $y
					AND PROC_ID = 99";
		
		$result = $this->db->query($sql);
	}
	
	function update_total_penurunan_aum ($npp, $m, $y)
	{
		/*$sql3 = "UPDATE REALISASI SET TARGET = 0 , REALISASI = 0						
					WHERE 
					SALES_ID = '$npp' AND M = $m AND Y = $y
					AND PROC_ID = 8";
		$result = $this->db->query($sql3);
		#-----------------------------------------
		#	update TARGET total penurunan AUM
		#-----------------------------------------
		
		#$sql_bak = "UPDATE REALISASI SET TARGET = (
		#				SELECT NVL((ROUND(SUM(TARGET)*0.75)),0)+NVL(ROUND(SUM(OUTSTANDING)),0) TARGET FROM REALISASI 
		#				WHERE SALES_ID = '$npp' AND M = $m AND Y = $y
		#				AND PROC_ID IN (1,2,3,11,12)
		#			) 
		#			WHERE 
		#			SALES_ID = '$npp' AND M = $m AND Y = $y
		#			AND PROC_ID = 8";
		
		#-----------------------------------------
		#get lastmonth from parameter month & year
		#-----------------------------------------
		$m2 = date('n', mktime(0, 0, 0, $m - 1, 1, $y));
		$y2 = date('Y', mktime(0, 0, 0, $m - 1, 1, $y));
		
		$sql = "SELECT NVL(SUM(PENCAPAIAN),0) PENCAPAIAN FROM REALISASI WHERE SALES_ID = $npp AND M = $m2 AND Y = $y2 AND PROC_ID IN (1,2,3)";
		$result = $this->db->query($sql)->result();
		
		if($result && $result[0]->PENCAPAIAN==0 || $m==1 || !$result)
		{ $var='OUTSTANDING'; $m2=$m; $y2=$y; $proc_id = "1,2,3,8";}		
		else { $var='PENCAPAIAN'; $proc_id = "1,2,3,11,12";}
		
		$sql = "UPDATE REALISASI SET TARGET = (
						SELECT NVL(SUM(NVL($var,0)),0) PENCAPAIAN FROM REALISASI 
						WHERE SALES_ID = '$npp' AND M = $m2 AND Y = $y2
						AND PROC_ID IN ($proc_id)
					) 
					WHERE 
					SALES_ID = '$npp' AND M = $m AND Y = $y
					AND PROC_ID = 8";
		
		$result = $this->db->query($sql);
		
		$sql2 = "UPDATE REALISASI SET PENCAPAIAN = (
						SELECT NVL(SUM(NVL(PENCAPAIAN,0)),0) PENCAPAIAN FROM REALISASI 
						WHERE SALES_ID = '$npp' AND M = $m AND Y = $y
						AND PROC_ID IN (1,2,3,11,12)
					) 
					WHERE 
					SALES_ID = '$npp' AND M = $m AND Y = $y
					AND PROC_ID = 8";
					
		$result2 = $this->db->query($sql2);*/
	}
	
	function cek_dpk($npp, $m, $y)
	{
		$sql="SELECT PENCAPAIAN, PROC_ID FROM REALISASI 
				WHERE 
				SALES_ID = '$npp'
				AND M=$m
				AND Y=$y
				AND PROC_ID IN (1,2,3) ";
		return $this->db->query($sql)->result();
	}
	
	function get_data($id, $year)
	{	
		$this->db->where("ID",$id);
		$this->db->where("YEAR",$year);
		return $this->db->get('VIEW_TARGET')->result();	
	}
	
	function get_new_cust($npp, $m, $y)
	{
		$sql="
			  UPDATE REALISASI SET PENCAPAIAN = (
			      	SELECT COUNT(A.SALES_ID) JUMLAH
    					FROM
    					(
						SELECT 
						distinct
                        SALES_ID, 
                        CUST_NAME,
                        BNI_CIF_KEY, 
                        OPEN_CIF_DATE,
                        AVG_BOOK_BAL
						FROM NOC_FINAL
						WHERE 
                        TO_CHAR( EXTRACT(MONTH FROM AS_OF_DATE)) = $m 
                        AND TO_CHAR(EXTRACT(YEAR FROM AS_OF_DATE)) = $y
                        AND SUBSTR(SALES_ID,-5,5) = '$npp'
						AND FLAG = 1
						GROUP BY
                        SALES_ID, 
                        CUST_NAME, 
                        OPEN_CIF_DATE,
                        BNI_CIF_KEY,
                        AVG_BOOK_BAL
						ORDER BY
                        OPEN_CIF_DATE
                        ) A
               LEFT JOIN USER_TST B
               ON A.SALES_ID = B.ID 
               WHERE 
               (B.SALES in (3,11) AND A.AVG_BOOK_BAL >= 100000000)
               OR (B.SALES in (1,2) AND A.AVG_BOOK_BAL >= 1000000000)
               OR (B.SALES not in (1,2,3,11) AND A.AVG_BOOK_BAL > 0)
			   OR (B.SALES  in (5,6) AND A.AVG_BOOK_BAL > 0)
			  ) 
				WHERE SALES_ID = $npp AND M=$m AND Y=$y AND PRODUCT_ID =  23
				";
		//echo $this->db->query($sql);die;
		return $this->db->query($sql);
	}
	
	function get_new_cust_bb($npp, $m, $y)
	{
		$sql="
			  UPDATE REALISASI SET PENCAPAIAN = (
			      	SELECT COUNT(A.SALES_ID) JUMLAH
    					FROM
    					(
						SELECT 
						distinct
                        SALES_ID, 
                        CUST_NAME,
                        BNI_CIF_KEY, 
                        OPEN_CIF_DATE,
                        AVG_BOOK_BAL
						FROM NOC_BB_FINAL
						WHERE 
                        TO_CHAR( EXTRACT(MONTH FROM AS_OF_DATE)) = $m 
                        AND TO_CHAR(EXTRACT(YEAR FROM AS_OF_DATE)) = $y
                        AND SUBSTR(SALES_ID,-5,5) = '$npp'
						AND FLAG = 1
						GROUP BY
                        SALES_ID, 
                        CUST_NAME, 
                        OPEN_CIF_DATE,
                        BNI_CIF_KEY,
                        AVG_BOOK_BAL
						ORDER BY
                        OPEN_CIF_DATE
                        ) A
               LEFT JOIN USER_TST B
               ON A.SALES_ID = B.ID 
               WHERE 
               (B.SALES in (3,11) AND A.AVG_BOOK_BAL >= 100000000)
               OR (B.SALES in (1,2) AND A.AVG_BOOK_BAL >= 1000000000)
               OR (B.SALES not in (1,2,3,11) AND A.AVG_BOOK_BAL > 0)
			   OR (B.SALES  in (5,6) AND A.AVG_BOOK_BAL > 0)
			  ) 
				WHERE SALES_ID = $npp AND M=$m AND Y=$y AND PRODUCT_ID =  24
				";
		//echo $this->db->query($sql);die;
		return $this->db->query($sql);
	}
	
	function get_new_account($npp, $m, $y)
	{
		$sql="
				UPDATE REALISASI SET PENCAPAIAN = (
				    SELECT COUNT(A.SALES_ID)JUMLAH
						FROM
    					(
    					SELECT
						DISTINCT
                        SALES_ID,
                        CUST_NAME,
                        BNI_CIF_KEY, 
                        OPEN_DATE,
                        AVG_BOOK_BAL
						FROM NOA_FINAL 
						WHERE 
							TO_CHAR( EXTRACT(MONTH FROM AS_OF_DATE)) = $m 
							AND TO_CHAR(EXTRACT(YEAR FROM AS_OF_DATE)) = $y
							AND SUBSTR(SALES_ID,-5,5) = '$npp'
							AND FLAG = 1
						ORDER BY
						OPEN_DATE
                        ) A
						LEFT JOIN USER_TST B
						ON A.SALES_ID = B.ID 
						WHERE 
						(B.SALES in (3,11) AND A.AVG_BOOK_BAL >= 100000000)
						OR (B.SALES in (1,2) AND A.AVG_BOOK_BAL >= 1000000000)
						OR (B.SALES not in (1,2,3,11) AND A.AVG_BOOK_BAL > 0)
						) 
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

        //$result[0]->C = ($result[0]->C) - 10;		
		$result[0]->T = ($result[0]->T > $result[0]->JML)?$result[0]->JML:$result[0]->T;
		$result[0]->P = ($result[0]->P > $result[0]->JML)?$result[0]->JML:$result[0]->P;
		$result[0]->C = ($result[0]->C > $result[0]->JML)?$result[0]->JML:$result[0]->C;
		//echo $result[0]->C;
		
		$data['1'] = ($result[0]->JML==0)?0:round(($result[0]->T/$result[0]->JML)*100);
		$data['2'] = ($result[0]->JML==0)?0:round(($result[0]->P/$result[0]->JML)*100);
		$data['3'] = ($result[0]->JML==0)?0:round(($result[0]->C/$result[0]->JML)*100);
		//echo $data['3'];
				
		$sql="  SELECT PENCAPAIAN FROM REALISASI WHERE PRODUCT_ID IN (16,17,18)
				AND M=$m
				AND Y=$y
				AND SALES_ID = '$npp' ORDER BY PRODUCT_ID";
		$cekRasio = $this->db->query($sql)->result();
		
		$n = 3;
		foreach($cekRasio as $row)
		{
			$pencapaian = ($data[$n] > 100)?100:$data[$n];
			$sql="UPDATE REALISASI SET PENCAPAIAN = ".$pencapaian."
					WHERE PRODUCT_ID = ". (15+$n) ."
					AND SALES_ID = '$npp'
					AND M=$m
					AND Y=$y";
			$this->db->query($sql);
			
			#echo '<pre>'.$sql;
			$n++;
		}
		#die();
	}
	
	function get_investasi($id,$m,$y)
	{
		$m = ($m == 12)?1:$m+1;
		$where = array('M'=>$m, 'Y'=>$y, 'SALES_ID'=>$id, 'PROC_ID'=>8);
		$this->db->where($where);
		return $this->db->get('REALISASI')->result();	
	}
	
	function get_product_target($id, $year)
	{	$this->db->select("a.ID, TO_NUMBER(a.TARGET) as TARGET , b.PRODUCT_NAME, a.PRODUCT_ID");
		$this->db->from('TARGET a');
		$this->db->join('PRODUCT b', 'a.PRODUCT_ID = b.ID');
		$this->db->where("a.SALES_ID",$id);
		$this->db->where("a.YEAR",$year);
		return $this->db->get()->result();	
	}
	
	function get_realisasi($id,$year,$month)
	{
		//array of condition
		$data = array('SALES_ID'=>$id, 'Y'=>$year, 'M'=>$month);
		//select all data
		$this->db->select("	a.ID, 
							a.SALES_ID, 
							a.TARGET_ID, 
							a.PRODUCT_ID,
							a.PROC_ID, 
							a.OUTSTANDING,
							a.Y, 
							a.M, 
							TO_NUMBER(a.TARGET) as TARGET, 
							TO_NUMBER(a.PENCAPAIAN) as PENCAPAIAN, 
							TO_NUMBER(a.REALISASI) as REALISASI, 
							b.PRODUCT_NAME,
							b.OWNER");
							
		$this->db->from('REALISASI a');
		$this->db->join('PRODUCT b', 'a.PRODUCT_ID = b.ID');
		$this->db->where($data);
		return $this->db->get()->result();
	}
	
	function save($data)
	{		
		$field = "";
		$value = "'";
		foreach($data as $row=>$val){
			$field 	.= $row.",";
			$value	.= $val."','"; 
		}
		$row = rtrim($field,",");
		$sql = "INSERT INTO TARGET (ID, DATE_CREATED, ".$row.") VALUES (SEQ_TARGET.NEXTVAL, SYSDATE, ".rtrim($value,",'")."')";
		#print_r($sql); die();
		$this->db->simple_query($sql);
	}
	
	function update_maret($where,$data)
	{		
		#print_r($data);die();
		$this->db->where($where);
		$this->db->update('REALISASI', $data);
	}
	
	function update($id,$data)
	{		
		//echo $id;
		//print_r($data);die();
		$this->db->where('ID',$id);
		$this->db->update('REALISASI', $data);
	}
	
	function update_pencapaian($id,$data)
	{		
		//echo $id;
		//print_r($data);die();
		$this->db->where('ID',$id);
		$this->db->update('REALISASI', $data);
	}
	
	public function delete($id, $tbl_name) 
	{
		$this->db->where('ID',$id);
		$this->db->delete($tbl_name);
		#$delete = $this->db->query('DELETE FROM '.$tbl_name.' WHERE id='.$id);
		return TRUE;
	}
	
	function cek_data_realisasi($id)
	{
		$this->db->where('ID',$id);
		return $this->db->get('REALISASI')->result();		
	}
	
	function get_param()
	{
		$this->db->where('GROUPS','RealisasiTime');
		$this->db->where('NAME','From');
		$result = $this->db->get('PARAMETER')->row();		
		$data['From'] = $result->VALUE;
		
		$this->db->where('GROUPS','RealisasiTime');
		$this->db->where('NAME','Until');
		$result = $this->db->get('PARAMETER')->row();		
		$data['Until'] = $result->VALUE;
		
		return $data;
	}
	
	
		function tampil()
	{

	$sql = "SELECT * FROM product WHERE CATEGORY = 'Financial' AND SEGMENT = 'CR' ";
	$data = $this->db->query($sql)->result();
		return $data;
	}
}
?>