<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class _report extends Model {

	function _report()
	{
		parent::Model();
		$this->CI =& get_instance();
	}

	#--------------------------------------
	#	Report Activity
	#--------------------------------------
	function get_activity($id, $type=0, $start, $end)
	{
		$where2 = array();
		if($type == 0) $where2 = ' AND REALISATION <> 99 ';
		if($type == 1) $where2 = ' AND REALISATION <> 0 ';
		if($type == 2) $where2 = ' AND REALISATION = 0 ';
		if($type == 3) $where2 = ' AND REALISATION <> 0 AND CUST_NAME IN (SELECT NAMA FROM TELE_INBOUND WHERE SALES_ID =' .$id.') '; 
		if($type == 4) $where2 = ' AND REALISATION = 0 AND CUST_NAME IN (SELECT NAMA FROM TELE_INBOUND WHERE SALES_ID = '.$id.') ';
		if($type == 5) $where2 = ' AND REALISATION <> 99 AND CUST_NAME IN (SELECT NAMA FROM TELE_INBOUND WHERE SALES_ID ='. $id.') ';
		
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
		
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "SELECT 
						b.ACTIVITY, 
						COUNT(a.ACTIVITY) AS JUMLAH,  
						b.BOBOT, (b.BOBOT*COUNT(a.ACTIVITY)) AS VOLUME 
				FROM 
						DAILY_ACTIVITY a LEFT JOIN ACTIVITY b ON a.ACTIVITY = b.ID 
				WHERE 
						SUBSTR((TRIM(a.USERID)),-5,5) = '$id' 
						AND a.START_TIME 
						BETWEEN TO_DATE('$tgl1','MM/DD/YYYY') AND TO_DATE('$tgl2','MM/DD/YYYY')
						$where2
				GROUP BY 
						b.ACTIVITY, b.BOBOT";
			
		return $this->db->query($sql)->result();	
	}
	
		#--------------------------------------
	#	Report Pipeline
	#--------------------------------------
	function get_pipeline_coach($id,$sourcedata,$month,$year)
	{
		if($sourcedata==0) $where2 =" ";
		if($sourcedata==1) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads/Nasabah Kelolaan'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==2) 
		{
		$where2 =" AND A.SOURCE_DATA ='Prospek Baru'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==3)
		{
		$where2 =" AND A.SOURCE_DATA ='Telesales Inbound'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==4) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads Propensity'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==5) 
		{
		$where2 =" AND A.SOURCE_DATA ='Account Plan'";
		$where21="A.SOURCE_DATA,";
		}
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "select  
                        b.user_name nama_sales,
                        c.sales_type,
                        b.spv,
                        d.user_name nama_spv,
                        $where21
                        a.product_name,
                        sum(a.LEADS) LEADS,
                        sum(a.CALLS) CALLS,
                        round((sum(a.calls)/sum(a.leads))*100,0) persen_c,
                        sum(a.OPPORTUNITY) OPPORTUNITY,
                        round((sum(a.opportunity)/sum(a.calls))*100,0) persen_o,
                        sum(a.APPOINTMENT) appointment,
                        round((sum(a.appointment)/sum(a.calls))*100,0) persen_a,
                        sum(a.APPLICATION) application,
                        round((sum(a.application)/sum(a.calls))*100,0) persen_app,
                        sum(a.APPROVAL) approval,
                        round((sum(a.approval)/sum(a.calls))*100,0) persen_apr,
                        sum(a.ACCEPTANCE) acceptance,
                        round((sum(a.acceptance)/sum(a.calls))*100,0) persen_acc,
                        sum(a.DRAWDOWN) drawdown,
                        round((sum(a.drawdown)/sum(a.calls))*100,0) persen_dd,
						a.nominal,
						e.rencana,
						nvl(a.nominal,0) - nvl(e.rencana,0) as variance,
                        a.m,
                        a.y
                        from vw_produk_target a
                        left join user_tst b on a.npp = b.id 
                        left join sales_type c on b.sales = c.id 
                        left join user_tst d on b.spv = d.id
						left join vw_plan_ap e on a.npp = e.SALES_ID and a.m = e.month and a.y = e.year and a.PRODUCT_NAME = e.PRODUCT_NAME
                        where a.npp =$id and a.m=$month and a.y=$year and a.kategori ='Funding & FBI' $where2
                        group by $where21 b.user_name,c.sales_type,b.spv,d.user_name,a.product_name,a.nominal,e.rencana,a.m,a.y 
						";		
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
		function get_pipeline_coach1($id,$sourcedata, $month,$year)
	{
		
		if($sourcedata==0) $where2 =" ";
		if($sourcedata==1) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads/Nasabah Kelolaan'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==2) 
		{
		$where2 =" AND A.SOURCE_DATA ='Prospek Baru'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==3)
		{
		$where2 =" AND A.SOURCE_DATA ='Telesales Inbound'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==4) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads Propensity'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==5) 
		{
		$where2 =" AND A.SOURCE_DATA ='Account Plan'";
		$where21="A.SOURCE_DATA,";
		}
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "select  
                        b.user_name nama_sales,
                        c.sales_type,
                        b.spv,
                        d.user_name nama_spv,
                        $where21
                        a.product_name,
                        sum(a.LEADS) LEADS,
                        sum(a.CALLS) CALLS,
                        round((sum(a.calls)/sum(a.leads))*100,0) persen_c,
                        sum(a.OPPORTUNITY) OPPORTUNITY,
                        round((sum(a.opportunity)/sum(a.calls))*100,0) persen_o,
                        sum(a.APPOINTMENT) appointment,
                        round((sum(a.appointment)/sum(a.calls))*100,0) persen_a,
                        sum(a.APPLICATION) application,
                        round((sum(a.application)/sum(a.calls))*100,0) persen_app,
                        sum(a.APPROVAL) approval,
                        round((sum(a.approval)/sum(a.calls))*100,0) persen_apr,
                        sum(a.ACCEPTANCE) acceptance,
                        round((sum(a.acceptance)/sum(a.calls))*100,0) persen_acc,
                        sum(a.DRAWDOWN) drawdown,
                        round((sum(a.drawdown)/sum(a.calls))*100,0) persen_dd,
						a.nominal,
						e.rencana,
						nvl(a.nominal,0) - nvl(e.rencana,0) as variance,
                        a.m,
                        a.y
                        from vw_produk_target a
                        left join user_tst b on a.npp = b.id 
                        left join sales_type c on b.sales = c.id 
                        left join user_tst d on b.spv = d.id
						left join vw_plan_ap e on a.npp = e.SALES_ID and a.m = e.month and a.y = e.year and a.PRODUCT_NAME = e.PRODUCT_NAME
                        where a.npp =$id and a.m=$month and a.y=$year and a.kategori ='Lending' $where2
                        group by $where21 b.user_name,c.sales_type,b.spv,d.user_name,a.product_name,a.nominal,e.rencana,a.m,a.y 
						";		
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
		function get_pipeline_coach2($id, $sourcedata,$month,$year)
	{
		if($sourcedata==0) $where2 =" ";
		if($sourcedata==1) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads/Nasabah Kelolaan'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==2) 
		{
		$where2 =" AND A.SOURCE_DATA ='Prospek Baru'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==3)
		{
		$where2 =" AND A.SOURCE_DATA ='Telesales Inbound'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==4) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads Propensity'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==5) 
		{
		$where2 =" AND A.SOURCE_DATA ='Account Plan'";
		$where21="A.SOURCE_DATA,";
		}
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "select  
                        b.user_name nama_sales,
                        c.sales_type,
                        b.spv,
                        d.user_name nama_spv,
                        $where21
                        a.product_name,
                        sum(a.LEADS) LEADS,
                        sum(a.CALLS) CALLS,
                        round((sum(a.calls)/sum(a.leads))*100,0) persen_c,
                        sum(a.OPPORTUNITY) OPPORTUNITY,
                        round((sum(a.opportunity)/sum(a.calls))*100,0) persen_o,
                        sum(a.APPOINTMENT) appointment,
                        round((sum(a.appointment)/sum(a.calls))*100,0) persen_a,
                        sum(a.APPLICATION) application,
                        round((sum(a.application)/sum(a.calls))*100,0) persen_app,
                        sum(a.APPROVAL) approval,
                        round((sum(a.approval)/sum(a.calls))*100,0) persen_apr,
                        sum(a.ACCEPTANCE) acceptance,
                        round((sum(a.acceptance)/sum(a.calls))*100,0) persen_acc,
                        sum(a.DRAWDOWN) drawdown,
                        round((sum(a.drawdown)/sum(a.calls))*100,0) persen_dd,
						a.nominal,
						e.rencana,
						nvl(a.nominal,0) - nvl(e.rencana,0) as variance, 
                        a.m,
                        a.y
                        from vw_produk_target a
                        left join user_tst b on a.npp = b.id 
                        left join sales_type c on b.sales = c.id 
                        left join user_tst d on b.spv = d.id
						left join vw_plan_ap e on a.npp = e.SALES_ID and a.m = e.month and a.y = e.year and a.PRODUCT_NAME = e.PRODUCT_NAME
                        where a.npp =$id and a.m=$month and a.y=$year and a.kategori ='Credit Card' $where2
                        group by $where21 b.user_name,c.sales_type,b.spv,d.user_name,a.product_name,a.nominal,e.rencana,a.m,a.y 
						";			
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
		function get_pipeline_coach_kategori($id, $sourcedata, $month,$year)
	{
		
		if($sourcedata==0) $where2 =" ";
		if($sourcedata==1) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads/Nasabah Kelolaan'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==2) 
		{
		$where2 =" AND A.SOURCE_DATA ='Prospek Baru'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==3)
		{
		$where2 =" AND A.SOURCE_DATA ='Telesales Inbound'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==4) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads Propensity'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==5) 
		{
		$where2 =" AND A.SOURCE_DATA ='Account Plan'";
		$where21="A.SOURCE_DATA,";
		}
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "select  
						$where21
						b.user_name nama_sales,
						c.sales_type,
						b.spv,
						d.user_name nama_spv,
						a.KATEGORI,
						sum(a.LEADS) LEADS,
                        sum(a.CALLS) CALLS,
                        round((sum(a.calls)/sum(a.leads))*100,0) persen_c,
                        sum(a.OPPORTUNITY) OPPORTUNITY,
                        round((sum(a.opportunity)/sum(a.calls))*100,0) persen_o,
                        sum(a.APPOINTMENT) appointment,
                        round((sum(a.appointment)/sum(a.calls))*100,0) persen_a,
                        sum(a.APPLICATION) application,
                        round((sum(a.application)/sum(a.calls))*100,0) persen_app,
                        sum(a.APPROVAL) approval,
                        round((sum(a.approval)/sum(a.calls))*100,0) persen_apr,
                        sum(a.ACCEPTANCE) acceptance,
                        round((sum(a.acceptance)/sum(a.calls))*100,0) persen_acc,
                        sum(a.DRAWDOWN) drawdown,
                        round((sum(a.drawdown)/sum(a.calls))*100,0) persen_dd,
						sum(nvl(a.nominal,0)) nominal,
						sum(nvl(e.rencana,0)) rencana,
						sum(nvl(a.nominal,0)) - sum(nvl(e.rencana,0)) as variance,
						a.m,
						a.y
						from vw_kategori_target a
						left join user_tst b on a.npp = b.id 
						left join sales_type c on b.sales = c.id 
						left join user_tst d on b.spv = d.id
						left join vw_plan_cat e on a.npp = e.sales_id and a.m = e.month and a.y = e.year and a.KATEGORI = e.KATEGORI
						where a.npp = $id and a.m=$month and a.y=$year and a.kategori ='Funding & FBI' $where2
                        group by $where21 b.user_name,c.sales_type,b.spv,d.user_name,a.kategori,a.m,a.y 
						";			
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
	function get_pipeline_coach_kategori1($id, $sourcedata, $month, $year)
	{
		
		if($sourcedata==0) $where2 =" ";
		if($sourcedata==1) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads/Nasabah Kelolaan'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==2) 
		{
		$where2 =" AND A.SOURCE_DATA ='Prospek Baru'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==3)
		{
		$where2 =" AND A.SOURCE_DATA ='Telesales Inbound'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==4) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads Propensity'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==5) 
		{
		$where2 =" AND A.SOURCE_DATA ='Account Plan'";
		$where21="A.SOURCE_DATA,";
		}
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "select  
						$where21
						b.user_name nama_sales,
						c.sales_type,
						b.spv,
						d.user_name nama_spv,
						a.KATEGORI,
						sum(a.LEADS) LEADS,
                        sum(a.CALLS) CALLS,
                        round((sum(a.calls)/sum(a.leads))*100,0) persen_c,
                        sum(a.OPPORTUNITY) OPPORTUNITY,
                        round((sum(a.opportunity)/sum(a.calls))*100,0) persen_o,
                        sum(a.APPOINTMENT) appointment,
                        round((sum(a.appointment)/sum(a.calls))*100,0) persen_a,
                        sum(a.APPLICATION) application,
                        round((sum(a.application)/sum(a.calls))*100,0) persen_app,
                        sum(a.APPROVAL) approval,
                        round((sum(a.approval)/sum(a.calls))*100,0) persen_apr,
                        sum(a.ACCEPTANCE) acceptance,
                        round((sum(a.acceptance)/sum(a.calls))*100,0) persen_acc,
                        sum(a.DRAWDOWN) drawdown,
                        round((sum(a.drawdown)/sum(a.calls))*100,0) persen_dd,
						sum(nvl(a.nominal,0)) nominal,
						sum(nvl(e.rencana,0)) rencana,
						sum(nvl(a.nominal,0)) - sum(nvl(e.rencana,0)) as variance,
						a.m,
						a.y
						from vw_kategori_target a
						left join user_tst b on a.npp = b.id 
						left join sales_type c on b.sales = c.id 
						left join user_tst d on b.spv = d.id
						left join vw_plan_cat e on a.npp = e.sales_id and a.m = e.month and a.y = e.year and a.KATEGORI = e.KATEGORI
						where a.npp = $id and a.m=$month and a.y=$year and a.kategori ='Lending' $where2
                        group by $where21 b.user_name,c.sales_type,b.spv,d.user_name,a.kategori,a.m,a.y 
						";			
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
	function get_pipeline_coach_kategori2($id, $sourcedata, $month,$year)
	{
		if($sourcedata==0) $where2 =" ";
		//if($sourcedata==1) $where2 =" AND A.SOURCE_DATA ='Leads/Nasabah Kelolaan'";
		if($sourcedata==1) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads/Nasabah Kelolaan'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==2) 
		{
		$where2 =" AND A.SOURCE_DATA ='Prospek Baru'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==3)
		{
		$where2 =" AND A.SOURCE_DATA ='Telesales Inbound'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==4) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads Propensity'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==5) 
		{
		$where2 =" AND A.SOURCE_DATA ='Account Plan'";
		$where21="A.SOURCE_DATA,";
		}
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "select  
						$where21
						b.user_name nama_sales,
						c.sales_type,
						b.spv,
						d.user_name nama_spv,
						a.KATEGORI,
						sum(a.LEADS) LEADS,
                        sum(a.CALLS) CALLS,
                        round((sum(a.calls)/sum(a.leads))*100,0) persen_c,
                        sum(a.OPPORTUNITY) OPPORTUNITY,
                        round((sum(a.opportunity)/sum(a.calls))*100,0) persen_o,
                        sum(a.APPOINTMENT) appointment,
                        round((sum(a.appointment)/sum(a.calls))*100,0) persen_a,
                        sum(a.APPLICATION) application,
                        round((sum(a.application)/sum(a.calls))*100,0) persen_app,
                        sum(a.APPROVAL) approval,
                        round((sum(a.approval)/sum(a.calls))*100,0) persen_apr,
                        sum(a.ACCEPTANCE) acceptance,
                        round((sum(a.acceptance)/sum(a.calls))*100,0) persen_acc,
                        sum(a.DRAWDOWN) drawdown,
                        round((sum(a.drawdown)/sum(a.calls))*100,0) persen_dd,
						sum(nvl(a.nominal,0)) nominal,
						sum(nvl(e.rencana,0)) rencana,
						sum(nvl(a.nominal,0)) - sum(nvl(e.rencana,0)) as variance,
						a.m,
						a.y
						from vw_kategori_target a
						left join user_tst b on a.npp = b.id 
						left join sales_type c on b.sales = c.id 
						left join user_tst d on b.spv = d.id
						left join vw_plan_cat e on a.npp = e.sales_id and a.m = e.month and a.y = e.year and a.KATEGORI = e.KATEGORI
						where a.npp = $id and a.m=$month and a.y=$year and a.kategori ='Credit Card' $where2
                        group by $where21 b.user_name,c.sales_type,b.spv,d.user_name,a.kategori,a.m,a.y 
						";			
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
	function get_pipeline_coach_target($id,$sourcedata,$month,$year)
	{
		if($sourcedata==0) $where2 =" ";
		if($sourcedata==1) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads/Nasabah Kelolaan'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==2) 
		{
		$where2 =" AND A.SOURCE_DATA ='Prospek Baru'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==3)
		{
		$where2 =" AND A.SOURCE_DATA ='Telesales Inbound'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==4) 
		{
		$where2 =" AND A.SOURCE_DATA ='Leads Propensity'";
		$where21="A.SOURCE_DATA,";
		}
		if($sourcedata==5) 
		{
		$where2 =" AND A.SOURCE_DATA ='Account Plan'";
		$where21="A.SOURCE_DATA,";
		}
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		
		$sql = "select  
                           $where21
                        b.user_name nama_sales,
                        c.sales_type,
                        b.spv,
                        d.user_name nama_spv,
                        sum(a.LEADS) LEADS,
                        sum(a.CALLS) CALLS,
                        round((sum(a.calls)/sum(a.leads))*100,0) persen_c,
                        sum(a.OPPORTUNITY) OPPORTUNITY,
                        round((sum(a.opportunity)/sum(a.calls))*100,0) persen_o,
                        sum(a.APPOINTMENT) appointment,
                        round((sum(a.appointment)/sum(a.calls))*100,0) persen_a,
                        sum(a.APPLICATION) application,
                        round((sum(a.application)/sum(a.calls))*100,0) persen_app,
                        sum(a.APPROVAL) approval,
                        round((sum(a.approval)/sum(a.calls))*100,0) persen_apr,
                        sum(a.ACCEPTANCE) acceptance,
                        round((sum(a.acceptance)/sum(a.calls))*100,0) persen_acc,
                        sum(a.DRAWDOWN) drawdown,
                        round((sum(a.drawdown)/sum(a.calls))*100,0) persen_dd,
                        a.m,
                        a.y
                        from vw_all_target a
                        left join user_tst b on a.npp = b.id 
                        left join sales_type c on b.sales = c.id 
                        left join user_tst d on b.spv = d.id
                        where a.npp = $id and a.m=$month and a.y=$year $where2 
                        group by $where21 b.user_name,c.sales_type,b.spv,d.user_name,a.m,a.y
						";			
			#echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
	function get_pipeline_coach_spv($cab, $month,$year)
	{
		
		
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "select  
             a.npp,
             b.user_name nama_sales,
             c.sales_type,
             b.spv,
             d.user_name nama_spv,
             e.branch_name BRANCH,
             f.kode REGION,
             SUM(a.LEADS) LEADS,
             SUM(a.CALLS) CALLS,
             SUM(a.OPPORTUNITY) OPPORTUNITY,
             SUM(a.APPOINTMENT) APPOINTMENT,
             SUM(a.APPLICATION) APPLICATION,
             SUM(a.APPROVAL) APPROVAL,
             SUM(a.ACCEPTANCE) ACCEPTANCE,
             SUM(a.DRAWDOWN) DRAWDOWN,
             a.m,
             a.y
             from vw_all_target a
             left join user_tst b on a.npp = b.id 
             left join sales_type c on b.sales = c.id 
             left join user_tst d on b.spv = d.id
             left join branch e on b.branch=e.branch_code
             left join branch_region f on e.region = f.region_code
             where b.spv = '$cab' and a.m=$month and a.y=$year
             GROUP BY A.NPP,B.USER_NAME,C.SALES_TYPE,B.SPV,D.USER_NAME,E.BRANCH_name,f.kode,M,Y
             order by npp
						";			
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
		function get_pipeline_coach_branch($branch, $month,$year)
	{
		
		
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "select  
             a.npp,
             b.user_name nama_sales,
             c.sales_type,
             b.spv,
             d.user_name nama_spv,
             e.branch_name BRANCH,
             f.kode REGION,
             SUM(a.LEADS) LEADS,
             SUM(a.CALLS) CALLS,
             SUM(a.OPPORTUNITY) OPPORTUNITY,
             SUM(a.APPOINTMENT) APPOINTMENT,
             SUM(a.APPLICATION) APPLICATION,
             SUM(a.APPROVAL) APPROVAL,
             SUM(a.ACCEPTANCE) ACCEPTANCE,
             SUM(a.DRAWDOWN) DRAWDOWN,
             a.m,
             a.y
             from vw_all_target a
             left join user_tst b on a.npp = b.id 
             left join sales_type c on b.sales = c.id 
             left join user_tst d on b.spv = d.id
             left join branch e on b.branch=e.branch_code
             left join branch_region f on e.region = f.region_code
             where b.branch = $branch and a.m=$month and a.y=$year
			 GROUP BY A.NPP,B.USER_NAME,C.SALES_TYPE,B.SPV,D.USER_NAME,E.BRANCH_name,f.kode,M,Y
             order by c.sales_type,npp,spv
						";			
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
		function get_pipeline_coach_region($region, $month,$year)
	{
		
		
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "select  
             a.npp,
			 b.branch,
             b.user_name nama_sales,
             c.sales_type,
             b.spv,
             d.user_name nama_spv,
             e.branch_name BRANCH,
             f.kode REGION,
             sum(a.LEADS) LEADS,
             sum(a.CALLS) CALLS,
             sum(a.OPPORTUNITY) OPPORTUNITY,
             sum(a.APPOINTMENT) APPOINTMENT,
             sum(a.APPLICATION) APPLICATION,
             sum(a.APPROVAL) APPROVAL,
             sum(a.ACCEPTANCE) ACCEPTANCE,
             sum(a.DRAWDOWN) DRAWDOWN,
             a.m,
             a.y
             from vw_all_target a
             left join user_tst b on a.npp = b.id 
             left join sales_type c on b.sales = c.id 
             left join user_tst d on b.spv = d.id
             left join branch e on b.branch=e.branch_code
             left join branch_region f on e.region = f.region_code
             where e.region = $region and a.m=$month and a.y=$year
             group by a.npp,b.branch,b.user_name,c.sales_type,b.spv,d.user_name,e.branch_name,f.kode,a.m,a.y
			 order by b.branch,c.sales_type,npp,spv
						";			
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
	function get_pipeline_coach_region_sum($region, $month,$year)
	{
		
		
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "  select  
             e.branch_name BRANCH,
             f.kode REGION,
             sum(a.LEADS) leads,
             sum(a.CALLS) calls,
             sum(a.OPPORTUNITY) opportunity,
             sum(a.APPOINTMENT) appointment,
             sum(a.APPLICATION) application,
             sum(a.APPROVAL) approval,
             sum(a.ACCEPTANCE) acceptance,
             sum(a.DRAWDOWN) drawdown,
             a.m,
             a.y
             from vw_all_target a
             left join user_tst b on a.npp = b.id 
             left join sales_type c on b.sales = c.id
             left join user_tst d on b.spv = d.id
             left join branch e on b.branch=e.branch_code
             left join branch_region f on e.region = f.region_code
             where e.region = $region and a.m=$month and a.y=$year
             group by branch_name,kode,m,y
             order by branch_name
						";			
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
	function get_pipeline_coach_kb_sum($month,$year)
	{
		
		
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "  select  
							e.region reg,
             f.kode REGION,
             sum(a.LEADS) leads,
             sum(a.CALLS) calls,
             sum(a.OPPORTUNITY) opportunity,
             sum(a.APPOINTMENT) appointment,
             sum(a.APPLICATION) application,
             sum(a.APPROVAL) approval,
             sum(a.ACCEPTANCE) acceptance,
             sum(a.DRAWDOWN) drawdown,
             a.m,
             a.y
             from vw_all_target a
             left join user_tst b on a.npp = b.id 
             left join sales_type c on b.sales = c.id
             left join user_tst d on b.spv = d.id
             left join branch e on b.branch=e.branch_code
              join branch_region f on e.region = f.region_code
             where  a.m=$month and a.y=$year
             group by e.region,kode,m,y
             order by e.region
						";			
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
	function get_pipeline_coach_sourcedata($id,$month,$year)
	{
		
		
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "  select  
				  a.npp,
				  a.source_data,
				  a.LEADS,
				  a.CALLS,
				  a.OPPORTUNITY,
				  a.APPOINTMENT,
				  a.APPLICATION,
                  a.APPROVAL,
                  a.ACCEPTANCE,
                  a.DRAWDOWN,
				  a.NOMINAL,
				  a.M,
				  a.Y
				  from VW_STAGING_SOURCEDATA a
				  where  A.NPP=$id and a.M=$month and a.Y=$year
				  ORDER BY NPP
				  
						";			
			//echo $sql;die();
		
		return $this->db->query($sql)->result();
		
	}
	
	#--------------------------------------
	#	Report Pipeline
	#--------------------------------------
	function get_pipeline($id, $type, $start, $end)
	{
		
		
		$where2 = array();
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
		
		if($staging== 1) $where2 = " AND LEADS >= TO_DATE('$tgl1 00:00','MM/DD/YYYY HH24:MI') AND LEADS <= TO_DATE('$tgl2 23:59','MM/DD/YYYY HH24:MI')";
		if($staging== 2) $where2 = " AND CALLS >=TO_DATE('$tgl1 00:00','MM/DD/YYYY HH24:MI') AND CALLS <= TO_DATE('$tgl2 23:59','MM/DD/YYYY HH24:MI')";
		if($staging== 3) $where2 = " AND OPPORTUNITY >= TO_DATE('$tgl1 00:00','MM/DD/YYYY HH24:MI') AND OPPORTUNITY <= TO_DATE('$tgl2 23:59','MM/DD/YYYY HH24:MI')";
		if($staging== 4) $where2 = " AND APPOINTMENT >= TO_DATE('$tgl1 00:00','MM/DD/YYYY HH24:MI') AND APPOINTMENT <= TO_DATE('$tgl2 23:59','MM/DD/YYYY HH24:MI')";
		if($staging== 5) $where2 = " AND APPLICATION >= TO_DATE('$tgl1 00:00','MM/DD/YYYY HH24:MI') AND APPLICATION <= TO_DATE('$tgl2 23:59','MM/DD/YYYY HH24:MI')";
		if($staging== 6) $where2 = " AND APPROVAL >= TO_DATE('$tgl1 00:00','MM/DD/YYYY HH24:MI') AND APPROVAL <= TO_DATE('$tgl2 23:59','MM/DD/YYYY HH24:MI')";
		if($staging== 7) $where2 = " AND ACCEPTANCE >= TO_DATE('$tgl1 00:00','MM/DD/YYYY HH24:MI') AND ACCEPTANCE <= TO_DATE('$tgl2 23:59','MM/DD/YYYY HH24:MI')";
		if($staging== 8) $where2 = " AND DRAWDOWN >= TO_DATE('$tgl1 00:00','MM/DD/YYYY HH24:MI') AND DRAWDOWN <= TO_DATE('$tgl2 23:59','MM/DD/YYYY HH24:MI')";
		
		
				
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "SELECT
				SOURCE_DATA,
				CIF,
				CUST_NAME,
				PRODUCT_NAME,
				LEADS,
				CALLS,
				OPPORTUNITY,
				APPOINTMENT,
				APPLICATION,
				APPROVAL,
				ACCEPTANCE,
				DRAWDOWN,
				NOMINAL
				FROM 
				VW_PIPELINE_REPORT
				WHERE 
				 SUBSTR((TRIM(USERID)),-5,5) = '$id'
				 $where2
				";		
			//echo $sql;die();
		return $this->db->query($sql)->result();	
	}
	
	function get_pipeline_count($id, $staging, $start, $end)
	{
		
		
		$where2 = array();
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
		
		if($staging== 1) $where2 = " AND LEADS >= TO_DATE('$tgl1','MM/DD/YYYY') AND LEADS <= TO_DATE('$tgl2','MM/DD/YYYY')";
		if($staging== 2) $where2 = " AND CALLS >=TO_DATE('$tgl1','MM/DD/YYYY') AND CALLS <= TO_DATE('$tgl2','MM/DD/YYYY')";
		if($staging== 3) $where2 = " AND OPPORTUNITY >= TO_DATE('$tgl1','MM/DD/YYYY') AND OPPORTUNITY <= TO_DATE('$tgl2','MM/DD/YYYY')";
		if($staging== 4) $where2 = " AND APPOINTMENT >= TO_DATE('$tgl1','MM/DD/YYYY') AND APPOINTMENT <= TO_DATE('$tgl2','MM/DD/YYYY')";
		if($staging== 5) $where2 = " AND APPLICATION >= TO_DATE('$tgl1','MM/DD/YYYY') AND APPLICATION <= TO_DATE('$tgl2','MM/DD/YYYY')";
		if($staging== 6) $where2 = " AND APPROVAL >= TO_DATE('$tgl1','MM/DD/YYYY') AND APPROVAL <= TO_DATE('$tgl2','MM/DD/YYYY')";
		if($staging== 7) $where2 = " AND ACCEPTANCE >= TO_DATE('$tgl1','MM/DD/YYYY') AND ACCEPTANCE <= TO_DATE('$tgl2','MM/DD/YYYY')";
		if($staging== 8) $where2 = " AND DRAWDOWN >= TO_DATE('$tgl1','MM/DD/YYYY') AND DRAWDOWN <= TO_DATE('$tgl2','MM/DD/YYYY')";
		
		
				
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "SELECT
				a.USERID,
				b.user_name nama_sales,
				c.sales_type,
				b.spv,
				d.user_name nama_spv,
				count(a.leads) leads,
				count(a.calls) calls,
				count(a.opportunity) opportunity,
				count(a.appointment) appointment,
				count(a.application) application,
				count(a.approval) approval,
				count(a.acceptance) acceptance,
				count(a.drawdown) drawdown
				FROM 
				VW_PIPELINE_REPORT A 
				left join user_tst b on a.userid = b.id 
				left join sales_type c on b.sales = c.id 
				left join user_tst d on b.spv = d.id
				WHERE 
				 SUBSTR((TRIM(USERID)),-5,5) = '$id'
				 $where2
				 group by a.USERID,b.user_name,c.sales_type,b.spv,d.user_name
				";		
			//echo $sql;die();
		return $this->db->query($sql)->result();	
	}
	
	#--------------------------------------
	#	Report CC
	#--------------------------------------
	function get_cc($id,$start, $end)
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
echo $id;
echo "<br>";
echo $tgl1;
echo "<br>";
echo $tgl2;
*/		
		
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "SELECT TO_CHAR(AS_OF_DATE,'DD-MON-YYYY') AS_OF_DATE,
				ORG,
				LOGO,
				SUBSTR(CARDNO,1,7)||'XXXXXX'||SUBSTR(CARDNO,13,3) CARDNO  
				FROM 
						SAPM_CCOS
				WHERE 
						SUBSTR((TRIM(SALES_ID)),-5,5) = '$id' 
						AND AS_OF_DATE 
						BETWEEN TO_DATE('$tgl1 00:00','MM/DD/YYYY HH24:MI') AND TO_DATE('$tgl2 23:59','MM/DD/YYYY HH24:MI')
				";
			
		return $this->db->query($sql)->result();	
	}
	
	#--------------------------------------
	#	Report DPLK
	#--------------------------------------
	function get_dplk($id,$start, $end)
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
		
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "SELECT a.TGLBUKA,
				b.BRANCH_NAME,
				a.NOREK,
				a.NAMALKP,
				a.SDOAKHIR
				FROM 
						SAPM_DPLK a
				LEFT JOIN BRANCH b on NVL(a.KDCABANG,0)=b.BRANCH_CODE
				WHERE 
						SUBSTR((TRIM(SALESID)),-5,5) = '$id' 
						AND TGLBUKA 
						BETWEEN TO_DATE('$tgl1','MM/DD/YYYY') AND TO_DATE('$tgl2','MM/DD/YYYY')
				";
			
		return $this->db->query($sql)->result();	
	}
		
	#--------------------------------------
	#	Report Daily Customer
	#--------------------------------------
	function get_cust_daily($id, $type=0, $start, $end)
	{
		$where2 = array();
		if($type == 0) $where2 = ' AND REALISATION <> 99 ';
		if($type == 1) $where2 = ' AND REALISATION <> 0 ';
		if($type == 2) $where2 = ' AND REALISATION = 0 ';		
		
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
		
		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "SELECT 
						b.ACTIVITY, 
						COUNT(a.ACTIVITY) AS JUMLAH,  
						b.BOBOT, (b.BOBOT*COUNT(a.ACTIVITY)) AS VOLUME 
				FROM 
						DAILY_ACTIVITY a INNER JOIN ACTIVITY b ON a.ACTIVITY = b.ID 
				WHERE 
						SUBSTR((TRIM(a.USERID)),-5,5) = '$id' 
						AND a.START_TIME 
						BETWEEN TO_DATE('$tgl1','MM/DD/YYYY') AND TO_DATE('$tgl2','MM/DD/YYYY')
						$where2
				GROUP BY 
						b.ACTIVITY, b.BOBOT";			
		
		return $this->db->query($sql)->result();
	
	}
	
	function get_user($id)
	{
		$this->db->select('a.ID, a.USER_NAME,a.sales, b.SALES_TYPE, a.SPV');
		$this->db->from('USER_TST a');
		$this->db->join('SALES_TYPE b', 'a.SALES = b.ID');
		$this->db->where('SUBSTR((TRIM(a.ID)),-5,5)',"$id");
		return $this->db->get()->result();
	}
	
	function get_user_grade($id,$m,$y)
	{
		$sql="SELECT
			DISTINCT 
			A.SALES_ID,
			A.GRADETARGET,
			A.AREA KODE_AREA,
			A.M,
			A.Y,
			A.SALES,
			C.SALES_TYPE
			FROM REALISASI A
			JOIN USER_TST B
			ON A.SALES_ID=B.ID
			join sales_type c
			on a.sales = c.id
			WHERE A.SALES_ID = $id AND A.M=$m AND A.Y=$y AND A.GRADETARGET IS NOT NULL";
		return $this->db->query($sql)->result();
	}
	
	function get_parameter_retensi($id,$m,$y)
	{
		$sql="SELECT
				A.SALES_ID,
				A.TARGET,
				A.PENCAPAIAN,
				(A.PENCAPAIAN - A.TARGET) RETENSI,
				A.M,
				A.Y
			FROM NEW_REALISASI A
			WHERE A.SALES_ID = $id AND A.M=$m AND A.Y=$y ";
/*
		$sql="SELECT
				A.SALES_ID,
				A.TARGET,
				A.PENCAPAIAN,
				(A.PENCAPAIAN - A.TARGET) RETENSI,
				A.M,
				A.Y
			FROM NEW_REALISASI A
			WHERE A.SALES_ID = $id AND A.M=$m AND A.Y=$y AND PRODUCT_ID = 25";
*/		
		return $this->db->query($sql)->result();
	}
	
	function get_user_usulan($id)
	{
		$this->db->select('a.ID, a.USER_NAME,a.SALES, b.SALES_TYPE, a.SPV, a.GRADE, c.AREA_IBC');
		$this->db->from('USER_TST a');
		$this->db->join('SALES_TYPE b', 'a.SALES = b.ID');
		$this->db->join('VW_LIST_SALES c', 'a.ID = c.ID');
		$this->db->where('SUBSTR((TRIM(a.ID)),-5,5)',"$id");
		return $this->db->get()->result();
	}
	
	function get_user_usulan_tambahan($id)
	{
		$this->db->select('a.ID, a.USER_NAME,a.SALES, a.SALES_TYPE, a.SPV, a.GRADE, a.AREA_IBC');
		$this->db->from('VW_USER_TAMBAHAN a');
		$this->db->where('SUBSTR((TRIM(a.ID)),-5,5)',"$id");
		return $this->db->get()->result();
	}
	
	function get_user_usulan_tambahan_lama($id)
	{
		$this->db->select('a.ID, a.USER_NAME,a.SALES, a.SALES_TYPE, a.SPV, a.GRADE, a.AREA_IBC');
		$this->db->from('VW_USER_TAMBAHAN_LAMA a');
		$this->db->where('SUBSTR((TRIM(a.ID)),-5,5)',"$id");
		return $this->db->get()->result();
	}
	
	#-------------------------------------
	# 	Get Penyelia
	#-------------------------------------
	function get_penyelia($cab)
	{
		$npp = strtoupper($this->session->userdata('ID'));
		$lvl = strtoupper($this->session->userdata('USER_LEVEL'));
		$cab = strtoupper($this->session->userdata('BRANCH_ID'));
		$wil = strtoupper($this->session->userdata('REGION'));
		
		switch ($lvl) {
			case 'SUPERVISOR':
				$where2 = " AND BRANCH = $cab";
				break;
			case 'CABANG':
				$where2 = " AND BRANCH = $cab";
				break;
			case 'WILAYAH':
				//$where2 = " OR a.ID = '$npp' AND REGION = $wil ";
				$where2 = " AND REGION = $wil ";
				break;
			case 'PIMPINAN_CABANG':
				$where2 = " AND BRANCH = $cab";
				break;
			case 'PEMIMPIN_CABANG':
				$where2 = " AND BRANCH = $cab";
				break;
			case 'PIMPINAN_WILAYAH':
				//$where2 = " OR a.ID = '$npp' AND REGION = $wil ";
				$where2 = " AND REGION = $wil ";
				break;
			default:			
				$where2 = '';
		}
		
		$this->db->select("a.*, b.REGION");
		$this->db->from('USER_TST a');
		$this->db->join('BRANCH b', 'a.BRANCH = b.BRANCH_CODE');
		
		$where = "(USER_LEVEL = 'SUPERVISOR' OR USER_LEVEL = 'CABANG' OR USER_LEVEL ='PIMPINAN_CABANG' ) ".$where2;
		
		$this->db->where($where);
		$this->db->order_by('USER_NAME');
		$result = $this->db->get()->result();	
		$data['All'] = "All";
		foreach($result as $row)
		{
			$data[$row->ID] = "$row->ID : $row->USER_NAME";
		}	
		return $data;
	}
	
	#-------------------------------------
	# 	Get Sales per Penyelia
	#-------------------------------------
	function get_sales_penyelia($penyelia, $cab)
	{
		$npp = strtoupper($this->session->userdata('ID'));
		$lvl = strtoupper($this->session->userdata('USER_LEVEL'));
		$cab = strtoupper($this->session->userdata('BRANCH_ID'));
		$wil = strtoupper($this->session->userdata('REGION'));
		
		if($penyelia == 'All')
		{
			switch ($lvl) {
				case 'SUPERVISOR':
					$kondisi = "SPV = '$npp'";
					break;
				case 'CABANG':
					//$kondisi = "BRANCH = $cab OR SPV = '$npp'";
					$kondisi = "BRANCH = $cab";
					break;
				case 'WILAYAH':
					//$kondisi = "REGION = $wil OR SPV = '$npp'";
					$kondisi = "REGION = $wil";
					break;	
				case 'PEMIMPIN_CABANG':
				case 'PIMPINAN_CABANG':
					//$kondisi = "BRANCH = $cab OR SPV = '$npp'";
					$kondisi = "BRANCH = $cab";
					break;
				case 'PIMPINAN_WILAYAH':
					//$kondisi = "REGION = $wil OR SPV = '$npp'";
					$kondisi = "REGION = $wil";
					break;		
				default:			
					$kondisi = "SPV = '$npp'";
			}
		} else $kondisi = "SPV = '$penyelia'";
		
		#$kondisi = ($penyelia == 'All')?"BRANCH = $cab":"SPV = '$penyelia'";
		$this->db->select("a.*, b.REGION")->from('USER_TST a');
		$this->db->join('BRANCH b', 'a.BRANCH = b.BRANCH_CODE');
		
		$where = "USER_LEVEL = 'SALES' AND ".$kondisi;
		
		$this->db->where($where);
		$this->db->order_by('USER_NAME');
		$result = $this->db->get()->result();	
		if($result)
		{
			foreach($result as $row)
			{
				$data[$row->ID] = "$row->ID : $row->USER_NAME";
			}	
		} else $data['0'] = 'Tidak ada sales';
		return $data;
	}
	
	function get_salestype($salesid)
	{
		$npp = strtoupper($this->session->userdata('ID'));
		$lvl = strtoupper($this->session->userdata('USER_LEVEL'));
		$cab = strtoupper($this->session->userdata('BRANCH_ID'));
		$wil = strtoupper($this->session->userdata('REGION'));
		
		if($penyelia == 'All')
		{
			switch ($lvl) {
				case 'SUPERVISOR':
					$kondisi = "SPV = '$npp'";
					break;
				case 'CABANG':
				case 'PEMIMPIN_CABANG':
					//$kondisi = "BRANCH = $cab OR SPV = '$npp'";
					$kondisi = "BRANCH = $cab";
					break;
				case 'WILAYAH':
					//$kondisi = "REGION = $wil OR SPV = '$npp'";
					$kondisi = "REGION = $wil";
					break;	
				case 'PIMPINAN_CABANG':
					//$kondisi = "BRANCH = $cab OR SPV = '$npp'";
					$kondisi = "BRANCH = $cab";
					break;
				case 'PIMPINAN_WILAYAH':
					//$kondisi = "REGION = $wil OR SPV = '$npp'";
					$kondisi = "REGION = $wil";
					break;		
				default:			
					$kondisi = "SPV = '$npp'";
			}
		} else $kondisi = "SPV = '$penyelia'";
		
		#$kondisi = ($penyelia == 'All')?"BRANCH = $cab":"SPV = '$penyelia'";
		$this->db->select("a.*,c.SALES_TYPE, b.REGION")->from('USER_TST a');
		$this->db->join('BRANCH b', 'a.BRANCH = b.BRANCH_CODE');
		$this->db->join('SALES_TYPE c', 'a.SALES = c.ID');
		
		$where = "USER_LEVEL = 'SALES' and a.ID=".$salesid."";
		
		$this->db->where($where);
		$this->db->order_by('USER_NAME');
		$result = $this->db->get()->result();	
		//if($result)
		//{
		//	foreach($result as $row)
		//	{
		//		$data[$row->SALES_TYPE] = "$row->SALES_TYPE";
		//	}	
		//} else $data['0'] = 'Tidak ada sales';
		return $result;
	}
	
	public function get_search($id = 0) 
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
		
		$sql = "FROM(SELECT a.ID,a.USER_NAME,b.SALES_TYPE,a.USER_LEVEL,a.SALES,a.SPV,a.BRANCH,c.BRANCH_NAME,c.REGION FROM USER_TST a LEFT JOIN SALES_TYPE b ON a.SALES = b.ID LEFT JOIN BRANCH c ON a.BRANCH = c.BRANCH_CODE)";
		
		$this->db->select("* $sql",FALSE);		
		$npp = $this->session->userdata('ID');
		$where = '';
			
		$lvl = strtoupper($this->session->userdata('USER_LEVEL'));
		$cab = strtoupper($this->session->userdata('BRANCH_ID'));
		$wil = strtoupper($this->session->userdata('REGION'));
		
		switch ($lvl) {
			case 'SUPERVISOR':
				$where = array("SPV"=>"$npp",'USER_LEVEL'=>'SALES');
				break;
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
				$where = array("ID <>"=>0,'USER_LEVEL'=>'SALES');
		}
		
		$this->db->where($where);		
		$this->CI->flexigrid->build_query();
		
		#Get contents
		$return['records'] = $this->db->get();
		
		#Build count query
		$this->db->select("COUNT(ID) AS RECORD_COUNT $sql",FALSE);
		$this->db->where($where);
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		#Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		#Return all
		return $return;
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
			case 'HLB':
				$where = array("ID >"=>0,'USER_LEVEL'=>'SALES','SALES >='=>7,'SALES <='=>8);
				break;
			case 'WEM':
				$where = array("ID >"=>0,'USER_LEVEL'=>'SALES','SALES >='=>20,'SALES <='=>22);
				break;
			default:			
				$where = array("ID >"=>0,'USER_LEVEL'=>'SALES');
		}
		
		$this->db->where($where);
		$this->db->where('SALES <','9');
		$this->db->where('REGION <>','88');
		$this->CI->flexigrid->build_query();
		
		#Get contents
		$return['records'] = $this->db->get();
		
		#Build count query
		$this->db->from('VW_CR_LIST_SALES');
		$this->db->select("COUNT(ID) AS RECORD_COUNT",FALSE);
		$this->db->where($where);
		$this->db->where('SALES <','9');
		$this->db->where('REGION <>','88');
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		#Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
	
		#Return all
		return $return;
	}
	
	#--------------------------------------
	#	Report Realisasi
	#--------------------------------------	
	function get_realisasi($id,$month,$year,$salestypenewid=0)
	{
		/*#array of condition
		$data = array('SUBSTR((TRIM(SALES_ID)),-5,5) '=>"$id", 'M'=>$month, 'Y'=>$year);
		#select all data
		$this->db->select("	a.ID, 
							a.SALES_ID, 
							a.TARGET_ID, 
							a.PRODUCT_ID, 
							a.PROC_ID,
							a.OUTSTANDING,
							a.SEGMENT,
							a.Y, 
							a.M, 
							TO_NUMBER(a.TARGET) as TARGET, 
							TO_NUMBER(a.PENCAPAIAN) as PENCAPAIAN, 
							TO_NUMBER(a.REALISASI) as REALISASI, 
							b.PRODUCT_NAME");
		$this->db->from('REALISASI a');
		$this->db->join('PRODUCT b', 'a.PRODUCT_ID = b.ID');
		$this->db->join('BRANCH c','a.BRANCH_CODE = c.BRANCH_CODE');
		$this->db->order_by('a.PRODUCT_ID','ASC');
		$this->db->where($data);
		return $this->db->get()->result();*/
		#new query
		if($salestypenewid==23||$salestypenewid==25)
		{
			$ret="	union
					select
					NULL,
					SALES_ID,
					NULL,
					99 product_id,
					null proc_id,
					null,
					null,
					Y,
					M,
					SUM(NVL(TARGET,0)) TARGET,
					ROUND((SUM(NVL(PENCAPAIAN,0))+SUM(NVL(PENCAPAIAN2,0))-SUM(NVL(PENCAPAIAN3,0)))-SUM(NVL(OUTSTANDING,0))) PENCAPAIAN,
					ROUND(((SUM(NVL(PENCAPAIAN,0))+SUM(NVL(PENCAPAIAN2,0))-SUM(NVL(PENCAPAIAN3,0)))-SUM(NVL(OUTSTANDING,0))/SUM(NVL(TARGET,0)))*100),
					'Retensi Tabungan' PRODUCT_NAME
					from
					realisasi
					where
					m=$month and y=$year and sales_id = $id and product_id in(2,5)
					group by sales_id,y,m";
		}
		else if($salestypenewid==20||$salestypenewid==21||$salestypenewid==22)
		{
			$ret="	union
					select
					NULL,
					SALES_ID,
					NULL,
					99 product_id,
					null proc_id,
					null,
					null,
					Y,
					M,
					SUM(NVL(TARGET,0)) TARGET,
					ROUND((SUM(NVL(PENCAPAIAN,0))+SUM(NVL(PENCAPAIAN2,0))-SUM(NVL(PENCAPAIAN3,0)))-SUM(NVL(OUTSTANDING,0))) PENCAPAIAN,
					ROUND(((SUM(NVL(PENCAPAIAN,0))+SUM(NVL(PENCAPAIAN2,0))-SUM(NVL(PENCAPAIAN3,0)))-SUM(NVL(OUTSTANDING,0))/SUM(NVL(TARGET,0)))*100),
					'Retensi CASA' PRODUCT_NAME
					from
					realisasi
					where
					m=$month and y=$year and sales_id = $id and product_id in(1,2)
					group by sales_id,y,m";
		}
		else
		{
			$ret="";
		}
		
			$sql="
				SELECT a.ID, a.SALES_ID, a.TARGET_ID, a.PRODUCT_ID, a.PROC_ID, a.OUTSTANDING
				, a.SEGMENT, a.Y, a.M, TO_NUMBER(a.TARGET) as TARGET, TO_NUMBER(a.PENCAPAIAN) as PENCAPAIAN, TO_NUMBER
				(a.REALISASI) as REALISASI, b.PRODUCT_NAME
				FROM REALISASI a
				JOIN PRODUCT b ON a.PRODUCT_ID = b.ID
				JOIN BRANCH c ON a.BRANCH_CODE = c.BRANCH_CODE
				WHERE SUBSTR((TRIM(SALES_ID)),-5,5)  = '$id'
				AND M = '$month'
				AND Y = '$year'
				$ret
				ORDER BY PRODUCT_ID ASC
			 ";
		return $this->db->query($sql)->result();
	}
	
	function get_dpk_tambahan($id,$month,$year)
	{
		#array of condition
		$data = array('SUBSTR((TRIM(SALES_ID)),-5,5) '=>"$id", 'M'=>$month, 'Y'=>$year, 'PRODUCT_ID <'=>7);
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
		$this->db->where($data);
		return $this->db->get()->result();
	}
	
	function get_dpk_kurang($id,$month,$year,$salestypenewid)
	{
		#array of condition
		/*$data = array('SUBSTR((TRIM(SALES_ID)),-5,5) '=>"$id", 'M'=>$month, 'Y'=>$year, 'PRODUCT_ID <'=>7);
		#select all data
		$this->db->select("	a.ID, 
							a.SALES_ID, 
							a.TARGET_ID, 
							a.PRODUCT_ID, 
							a.PROC_ID,
							a.OUTSTANDING,
							a.Y, 
							a.M,  
							TO_NUMBER(NVL(a.PENCAPAIAN3,0)) as DPK_KURANG,  
							b.PRODUCT_NAME");
		$this->db->from('REALISASI a');
		$this->db->join('PRODUCT b', 'a.PRODUCT_ID = b.ID');
		$this->db->join('BRANCH c','a.BRANCH_CODE = c.BRANCH_CODE');
		$this->db->order_by('a.PRODUCT_ID','ASC');
		$this->db->where($data);
		return $this->db->get()->result();*/
					
					if($salestypenewid==23||$salestypenewid==25)
					{
					$sqlext="
							union
							select
                            null,
                            '$id' sales_id,
                            null target_id,
                            3 product_id,
                            3 proc_id,
                            0 outstanding,
                            $year y,
                            $month m,
                            0 dpk_kurang,
                            null product_name
                            from dual
                            union
                              select
                            null,
                            '$id' sales_id,
                            null target_id,
                            6 product_id,
                            6 proc_id,
                            0 outstanding,
                            $year y,
                            $month m,
                            0 dpk_kurang,
                            null product_name
                            from dual";
						}
						else
						{
							$sqlext="";
						}
						
						$sql="select
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
                            REALISASI a
                            join PRODUCT b
                            on a.PRODUCT_ID = b.ID
                            join BRANCH c
                            on a.BRANCH_CODE = c.BRANCH_CODE
                            where
                            SUBSTR((TRIM(SALES_ID)),-5,5) = '$id' and
                            m=$month and y=$year and a.product_id < 7
							$sqlext
                            order by product_id asc";
							return $this->db->query($sql)->result();
	}
	
	#--------------------------------------
	#	Report Realisasi Wilayah & cabang
	#--------------------------------------	
	function get_realisasi_cab($id, $month, $year, $cab, $wil, $type=0)
	{
		#array of condition
		$data = array('a.M'=>$month, 'a.Y'=>$year, 'a.BRANCH_CODE'=> $cab, 'c.REGION'=>$wil);

		#select all data
		$this->db->select("	a.ID, 
							a.SALES_ID, 
							d.USER_NAME, 
							a.TARGET_ID, 
							a.PRODUCT_ID,
							a.PROC_ID,							
							a.OUTSTANDING,
							a.Y, 
							a.M, 
							TO_NUMBER(a.TARGET) as TARGET, 
							CASE 
							WHEN
								a.PROC_ID = 1 OR  a.PROC_ID = 2 OR a.PROC_ID = 3
							THEN
								NVL(a.PENCAPAIAN,0)-NVL(a.OUTSTANDING,0)/((DECODE(NVL(a.TARGET,0),0,1,NVL(a.TARGET,0))+NVL(a.OUTSTANDING,0))-NVL(a.OUTSTANDING,0))
							ELSE
								NVL(a.PENCAPAIAN,0)
							END AS PENCAPAIAN,
							TO_NUMBER(a.REALISASI) as REALISASI, 
							b.PRODUCT_NAME,
							a.BRANCH_CODE,
							c.BRANCH_NAME,
							c.REGION");
							
		$this->db->from('REALISASI a');
		$this->db->join('PRODUCT b', 'a.PRODUCT_ID = b.ID');
		$this->db->join('BRANCH c','a.BRANCH_CODE = c.BRANCH_CODE');
		$this->db->join('USER_TST d', 'a.SALES_ID = d.ID');
		$this->db->where($data);
		$this->db->order_by('d.USER_NAME, b.PRODUCT_NAME','ASC');
		if($type==0)
		return $this->db->get()->result();
		else
		return $this->db->get()->result_array();
	}
	
	function get_nasabah_kelolaan2($id, $m)
	{
		switch ($m) 
		{
			case 0:
				$where = "LAST_MONTH = 0";
				break;
			case 1:
				$where = "LAST_MONTH = 1";
				break;
			case 2:
				$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
				UNION
				SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
				NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
				NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
				NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
				WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
			   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 0)
				";
				break;
			case 3:
				$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
				UNION
				SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
				NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
				NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
				NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
				WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
			   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 1)
				";
				break;
		}
	
		if ($m < 2)
		{
		$sql = "SELECT * FROM TMP_NASABAH_KELOLAAN WHERE BNI_SALES_ID = '$id' AND $where ORDER BY CUST_NAME";
		}
		else
		{
		$sql = "SELECT * FROM (SELECT * FROM TMP_NASABAH_KELOLAAN WHERE BNI_SALES_ID = '$id' AND $where) ORDER BY CUST_NAME";
		}
		return $this->db->query($sql)->result();
	}
	
	function get_nasabah_kelolaan3($id,$m,$tipe)
	{
		switch ($tipe)
		{
			case 0:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2017";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN";
						$where = "LAST_MONTH = 0 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$flagstatus = "flagging_status_2017";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 1:
						$table = "TMP_BASELINE_2017";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN";
						$where = "LAST_MONTH = 1 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$flagstatus = "flagging_status_2017";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 1)
						";
						break;
				}
				break;
			case 1:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2017";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 0 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
						$flagstatus = "flagging_status_2017";
							$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 1:
						$table = "TMP_BASELINE_2017";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 1 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
						$flagstatus = "flagging_status_2017";
						$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 1)
						";
						break;
				}
				break;
		}
		if ($m < 2)
		{
		$sql = "select d.as_of_date,x.sales_id,x.cif_key,d.cust_name,d.branch_name,d.open_branch,
				nvl(a.tabungan_cur,0)tabungan_cur_baseline,
				nvl(d.tabungan,0) tabungan,
				nvl(a.tabungan,0)tabungan_baseline,
				 CASE
                 WHEN e.status_id in(0,2)  then nvl(d.tabungan,0)-nvl(a.tabungan,0) 
                 WHEN e.status_id = 1  and nvl(d.tabungan,0) -nvl(a.tabungan,0) < 0 then 0
                 else nvl(d.tabungan,0)-nvl(a.tabungan,0)
                END AS delta_tabungan,
				nvl(b.giro_cur,0)giro_cur_baseline,
				nvl(d.giro,0) giro,
				nvl(b.giro,0)giro_baseline,
				  CASE
                 WHEN e.status_id in(0,2)  then nvl(d.giro,0)-nvl(b.giro,0) 
                 WHEN e.status_id = 1  and nvl(d.giro,0) -nvl(b.giro,0) < 0 then 0
                 else nvl(d.giro,0)-nvl(b.giro,0)
                END AS delta_giro,
				nvl(c.deposito_cur,0)deposito_cur_baseline,
				nvl(d.deposito,0) deposito,
				nvl(c.deposito,0)deposito_baseline,
				 CASE
                 WHEN e.status_id in(0,2)  then nvl(d.deposito,0)-nvl(c.deposito,0) 
                 WHEN e.status_id = 1  and nvl(d.deposito,0) -nvl(c.deposito,0) < 0 then 0
                 else nvl(d.deposito,0)-nvl(c.deposito,0)
                END AS delta_deposito, 
				nvl(d.tabungan,0)+nvl(d.giro,0)+nvl(d.deposito,0) DPK,
				nvl(a.tabungan,0)+nvl(b.giro,0)+nvl(c.deposito,0) DPK_BASELINE,
			   (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) DELTA_DPK,
				CASE 
               WHEN e.status IS NOT NULL and d.bni_cif_key is not null then e.status
			   WHEN e.status IS NULL and d.bni_cif_key is not null then 'AKUISISI'
               else ''
               end AS ket    
					from
				(
					select bni_cif_key cif_key,bni_sales_id sales_id from $table_kelolaan where $where and bni_sales_id = $id
					union
					select cif_key,to_char(sales_id) from $table where sales_id = $id $basetipe
				)x
				left join
				(	select 
					sales_id,cif_key,sum(bni_cur_book_bal_idr) giro_cur,sum(avg_book_bal) giro
					from $table where product_id = $gir 
					group by sales_id,cif_key) b
				on x.sales_id = b.sales_id and x.cif_key = b.cif_key
				left join
				(select 
					sales_id,cif_key,sum(bni_cur_book_bal_idr) tabungan_cur,sum(avg_book_bal) tabungan
					from $table where product_id = $tab 
					group by sales_id,cif_key)a
				on x.sales_id = a.sales_id and x.cif_key = a.cif_key
				left join
				( select 
					sales_id,cif_key,sum(bni_cur_book_bal_idr) DEPOSITO_cur,sum(avg_book_bal) DEPOSITO
					from $table where product_id = $dep
					group by sales_id,cif_key) c
					on x.sales_id = c.sales_id and x.cif_key = c.cif_key
					left join
				(select 
					as_of_date,bni_cif_key,cust_type,cust_name,branch_name,open_branch,bni_sales_id,TABUNGAN_CUR,TABUNGAN,GIRO_CUR,GIRO,DEPOSITO_CUR,DEPOSITO
					from $table_kelolaan where  $where) d
					on x.sales_id = d.bni_sales_id and x.cif_key = d.bni_cif_key
					left join $flagstatus e
					on x.cif_key||'$id' = e.id
					where x.sales_id = $id
					order by d.cust_name";
		}
		else
		{
		$sql = "SELECT * FROM (SELECT * FROM TMP_NASABAH_KELOLAAN WHERE BNI_SALES_ID = '$id' AND $where) ORDER BY CUST_NAME";
		}
		return $this->db->query($sql)->result();
	}
	
	function get_nasabah_kelolaan4($id,$m,$tipe)
	{
		$tanggal=date("d-M-Y");
		$week = date('W',$tanggal);
		$bln = date('m');
		$thn = date ('Y');
		switch ($tipe)
		{
			case 0:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2016_TOP";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_TOP";
						$where = "LAST_MONTH = 0 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 1:
						$table = "TMP_BASELINE_2016_TOP";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_TOP";
						$where = "LAST_MONTH = 1 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 1)
						";
						break;
				}
				break;
			case 1:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2016";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 0 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
							$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 1:
						$table = "TMP_BASELINE_2016";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 1 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
						$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 1)
						";
						break;
				}
				break;
		}
		if ($m < 2)
		{
		$sql = "select
				AS_OF_DATE    ,
				SALES_ID    ,
				CIF_KEY    ,
				CUST_NAME    ,
				BRANCH_NAME    ,
				OPEN_BRANCH    ,
				TABUNGAN_CUR    ,
				TABUNGAN_CUR_BASELINE    ,
				DELTA_TABUNGAN_CUR    ,
				TABUNGAN    ,
				TABUNGAN_BASELINE    ,
				DELTA_TABUNGAN    ,
				RENCANA_TABUNGAN    ,
				CASE 
				WHEN NVL(DELTA_TABUNGAN,0) < 0 THEN
                NVL(DELTA_TABUNGAN,0) + NVL(RENCANA_TABUNGAN,0) 
				ELSE
				NVL(DELTA_TABUNGAN,0) + NVL(RENCANA_TABUNGAN,0) 
				END AS DELTA_RENCANA_TABUNGAN,
				STATUS_TABUNGAN    ,
				GIRO_CUR    ,
				GIRO_CUR_BASELINE    ,
				DELTA_GIRO_CUR    ,
				GIRO    ,
				GIRO_BASELINE    ,
				DELTA_GIRO    ,
				RENCANA_GIRO    ,
				DELTA_GIRO + RENCANA_GIRO DELTA_RENCANA_GIRO,
				STATUS_GIRO    ,
				DEPOSITO_CUR    ,
				DEPOSITO_CUR_BASELINE    ,
				DELTA_DEPOSITO_CUR    ,
				DEPOSITO    ,
				DEPOSITO_BASELINE    ,
				DELTA_DEPOSITO    ,
				RENCANA_DEPOSITO    ,
				DELTA_DEPOSITO + RENCANA_DEPOSITO DELTA_RENCANA_DEPOSITO,
				STATUS_DEPOSITO    ,
				DPK    ,
				DPK_BASELINE    ,
				DELTA_DPK    ,
				RENCANA_DPK    ,
				DELTA_DPK + RENCANA_DPK DELTA_RENCANA_DPK,
				STATUS_DPK    ,
				KET	,
				CASE
				WHEN CIF IS NULL then 0
				ELSE 1
				END AS AKTIFITAS
				FROM
				(
					select d.as_of_date,x.sales_id,x.cif_key,d.cust_name,d.branch_name,d.open_branch,
								nvl(d.tabungan_cur,0)tabungan_cur,
								nvl(a.tabungan_cur,0)tabungan_cur_baseline,
								nvl(d.tabungan_cur,0) - nvl(a.tabungan_cur,0) DELTA_TABUNGAN_CUR,
								nvl(d.tabungan,0) tabungan,
								nvl(a.tabungan,0)tabungan_baseline,
								 CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.tabungan,0)-nvl(a.tabungan,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.tabungan,0) -nvl(a.tabungan,0) < 0 then nvl(d.tabungan,0)-nvl(a.tabungan,0) 
								 else nvl(d.tabungan,0)-nvl(a.tabungan,0)
								END AS delta_tabungan,
								NVL(f.rencana,0) RENCANA_TABUNGAN,
								CASE
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) < 0 then 'LEAK'
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) = 0 then 'PAR'
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) > 0 then 'RAISE'
								END AS status_tabungan,
								nvl(d.giro_cur,0)giro_cur,
								nvl(b.giro_cur,0)giro_cur_baseline,
								nvl(d.giro_cur,0) - nvl(b.giro_cur,0) delta_giro_cur,
								nvl(d.giro,0) giro,
								nvl(b.giro,0)giro_baseline,
								  CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.giro,0)-nvl(b.giro,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.giro,0) -nvl(b.giro,0) < 0 then nvl(d.giro,0) -nvl(b.giro,0)
								 else nvl(d.giro,0)-nvl(b.giro,0)
								END AS delta_giro,
								0 RENCANA_GIRO,
								 CASE
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) < 0 THEN 'LEAK'
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) = 0 THEN 'PAR'
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) > 0 THEN 'RAISE'
								END AS status_giro,
								nvl(d.deposito_cur,0)deposito_cur,
								nvl(c.deposito_cur,0)deposito_cur_baseline,
								nvl(d.deposito_cur,0) - nvl(c.deposito_cur,0) delta_deposito_cur,
								nvl(d.deposito,0) deposito,
								nvl(c.deposito,0)deposito_baseline,
								 CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.deposito,0)-nvl(c.deposito,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.deposito,0) -nvl(c.deposito,0) < 0 then nvl(d.deposito,0) -nvl(c.deposito,0)
								 else nvl(d.deposito,0)-nvl(c.deposito,0)
								END AS delta_deposito, 
								0 RENCANA_DEPOSITO,
								CASE
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) < 0 then 'LEAK'
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) = 0 then 'PAR'
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) > 0 then 'RAISE'
								 end as status_deposito,
								nvl(d.tabungan,0)+nvl(d.giro,0)+nvl(d.deposito,0) DPK,
								nvl(a.tabungan,0)+nvl(b.giro,0)+nvl(c.deposito,0) DPK_BASELINE,
							   (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) DELTA_DPK,
							   0 RENCANA_DPK,
							   CASE
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) < 0 THEN 'LEAK'
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) = 0 THEN 'PAR'
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) > 0 THEN 'RAISE'
							   END AS STATUS_DPK,
								CASE 
							   WHEN e.status IS NOT NULL then e.status
							   else 'AKUISISI'
							   end AS ket    
									from
								(
									select bni_cif_key cif_key,bni_sales_id sales_id from $table_kelolaan where $where and bni_sales_id = $id
									union
									select cif_key,to_char(sales_id) from  $table where sales_id = $id $basetipe
								)x
								left join
								(    select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) giro_cur,sum(avg_book_bal) giro
									from $table where product_id = $gir
									group by sales_id,cif_key) b
								on x.sales_id = b.sales_id and x.cif_key = b.cif_key
								left join
								(select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) tabungan_cur,sum(avg_book_bal) tabungan
									from $table where product_id = $tab 
									group by sales_id,cif_key)a
								on x.sales_id = a.sales_id and x.cif_key = a.cif_key
								left join
								( select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) DEPOSITO_cur,sum(avg_book_bal) DEPOSITO
									from $table where product_id = $dep
									group by sales_id,cif_key) c
									on x.sales_id = c.sales_id and x.cif_key = c.cif_key
									left join
								(select 
									as_of_date,bni_cif_key,cust_type,cust_name,branch_name,open_branch,bni_sales_id,TABUNGAN_CUR,TABUNGAN
									,GIRO_CUR,GIRO,DEPOSITO_CUR,DEPOSITO
									from $table_kelolaan where  $where) d
									on x.sales_id = d.bni_sales_id and x.cif_key = d.bni_cif_key
									left join flagging_status e
									on x.cif_key||'$id' = e.id
									left join 
									(
										select cif_key,sum(rencana) rencana,MONTH,YEAR from(
										select sales_id,CIF_KEY,sum(rencana) RENCANA,MONTH,YEAR  from new_account_planning a
										left join pipe_lookup_product b on a.product_id = b.id
										where  MONTH = $bln and Year = $thn and b.product_category = 2
										group by sales_id,cif_key,month,year
										union
										select sales_id,CIF_KEY,sum(rencana) RENCANA,MONTH,YEAR  from PIPELINE_BM a
										left join pipe_lookup_product b on a.product_id = b.id
										where  MONTH = $bln and Year = $thn 
										group by sales_id,cif_key,month,year)
										group by cif_key,MONTH,YEAR
									)f
									on d.bni_cif_key = f.cif_key
									where x.sales_id = $id
									order by d.cust_name
				)a
				left join (select cif_key cif from agenda_bm where npp = $id and realisasi is null)b
				on a.cif_key = b.cif
				order by delta_tabungan";
		}
		else
		{
		$sql = "SELECT * FROM (SELECT * FROM TMP_NASABAH_KELOLAAN WHERE BNI_SALES_ID = '$id' AND $where) ORDER BY CUST_NAME";
		}
		return $this->db->query($sql)->result();
	}
	
	function get_nasabah_sum_kelolaan4($branch,$m,$tipe)
	{
		$bln = date('m');
		$thn = date ('Y');
		switch ($tipe)
		{
			case 0:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2016_TOP";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_TOP";
						$where = "LAST_MONTH = 0 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 1:
						$table = "TMP_BASELINE_2016_TOP";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_TOP";
						$where = "LAST_MONTH = 1 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE  LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE  LAST_MONTH = 1)
						";
						break;
				}
				break;
			case 1:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2016";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 0 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
							$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 1:
						$table = "TMP_BASELINE_2016";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 1 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
						$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 1)
						";
						break;
				}
				break;
		}
		if ($m < 2)
		{
		$sql = "select
				a.SALES_ID    ,
				b.user_name,
				b.user_level,
				b.branch,
				c.branch_name,
				c.kln_name,
                SUM(NVL(TABUNGAN_CUR,0)) TABUNGAN_CUR    ,
                SUM(NVL(TABUNGAN_CUR_BASELINE,0)) TABUNGAN_CUR_BASELINE    ,
                SUM(NVL(DELTA_TABUNGAN_CUR,0)) DELTA_TABUNGAN_CUR   ,
                SUM(NVL(TABUNGAN,0)) TABUNGAN   ,
                SUM(NVL(TABUNGAN_BASELINE,0)) TABUNGAN_BASELINE    ,
                SUM(NVL(DELTA_TABUNGAN,0)) DELTA_TABUNGAN    ,
				CASE 
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) > 0 THEN 'RAISE'
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) = 0 THEN 'PAR'
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) < 0 THEN 'LEAK'
				END AS STATUS_TABUNGAN,
                SUM(NVL(RENCANA_TABUNGAN,0)) RENCANA_TABUNGAN    ,
				CASE 
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) < 0 THEN
                SUM(NVL(DELTA_TABUNGAN,0)) + SUM(NVL(RENCANA_TABUNGAN,0)) 
				ELSE
				SUM(NVL(DELTA_TABUNGAN,0)) + SUM(NVL(RENCANA_TABUNGAN,0)) 
				END AS DELTA_RENCANA_TABUNGAN,
                SUM(NVL(GIRO_CUR,0)) GIRO_CUR    ,
                SUM(NVL(GIRO_CUR_BASELINE,0)) GIRO_CUR_BASELINE    ,
                SUM(NVL(DELTA_GIRO_CUR,0)) DELTA_GIRO_CUR    ,
                SUM(NVL(GIRO,0)) GIRO    ,
                SUM(NVL(GIRO_BASELINE,0)) GIRO_BASELINE    ,
                SUM(NVL(DELTA_GIRO,0)) DELTA_GIRO    ,
                SUM(NVL(RENCANA_GIRO,0)) RENCANA_GIRO    ,
                SUM(NVL(DELTA_GIRO,0)) - SUM(NVL(RENCANA_GIRO,0)) DELTA_RENCANA_GIRO,
                SUM(NVL(DEPOSITO_CUR,0)) DEPOSITO    ,
                SUM(NVL(DEPOSITO_CUR_BASELINE,0)) DEPOSITO_CUR_BASELINE    ,
                SUM(NVL(DELTA_DEPOSITO_CUR,0)) DELTA_DEPOSITO_CUR    ,
                SUM(NVL(DEPOSITO,0)) DEPOSITO    ,
                SUM(NVL(DEPOSITO_BASELINE,0)) DEPOSITO_BASELINE    ,
                SUM(NVL(DELTA_DEPOSITO,0)) DELTA_DEPOSITO    ,
                SUM(NVL(RENCANA_DEPOSITO,0)) RENCANA_DEPOSITO    ,
                SUM(NVL(DELTA_DEPOSITO,0)) - SUM(NVL(RENCANA_DEPOSITO,0)) DELTA_RENCANA_DEPOSITO,
                SUM(NVL(DPK,0)) DPK    ,
                SUM(NVL(DPK_BASELINE,0)) DPK_BASELINE    ,
                SUM(NVL(DELTA_DPK,0)) DELTA_DPK    ,
                SUM(NVL(RENCANA_DPK,0)) RENCANA_DPK    ,
                SUM(NVL(DELTA_DPK,0)) - SUM(NVL(RENCANA_DPK,0)) DELTA_RENCANA_DPK  
				FROM
				(
					select d.as_of_date,x.sales_id,x.cif_key,d.cust_name,d.branch_name,d.open_branch,
								nvl(d.tabungan_cur,0)tabungan_cur,
								nvl(a.tabungan_cur,0)tabungan_cur_baseline,
								nvl(d.tabungan_cur,0) - nvl(a.tabungan_cur,0) DELTA_TABUNGAN_CUR,
								nvl(d.tabungan,0) tabungan,
								nvl(a.tabungan,0)tabungan_baseline,
								 CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.tabungan,0)-nvl(a.tabungan,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.tabungan,0) -nvl(a.tabungan,0) < 0 then nvl(d.tabungan,0)-nvl(a.tabungan,0) 
								 else nvl(d.tabungan,0)-nvl(a.tabungan,0)
								END AS delta_tabungan,
								nvl(f.rencana,0) RENCANA_TABUNGAN,
								CASE
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) < 0 then 'LEAK'
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) = 0 then 'PAR'
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) > 0 then 'RAISE'
								END AS status_tabungan,
								nvl(d.giro_cur,0)giro_cur,
								nvl(b.giro_cur,0)giro_cur_baseline,
								nvl(d.giro_cur,0) - nvl(b.giro_cur,0) delta_giro_cur,
								nvl(d.giro,0) giro,
								nvl(b.giro,0)giro_baseline,
								  CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.giro,0)-nvl(b.giro,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.giro,0) -nvl(b.giro,0) < 0 then nvl(d.giro,0) -nvl(b.giro,0)
								 else nvl(d.giro,0)-nvl(b.giro,0)
								END AS delta_giro,
								0 RENCANA_GIRO,
								 CASE
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) < 0 THEN 'LEAK'
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) = 0 THEN 'PAR'
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) > 0 THEN 'RAISE'
								END AS status_giro,
								nvl(d.deposito_cur,0)deposito_cur,
								nvl(c.deposito_cur,0)deposito_cur_baseline,
								nvl(d.deposito_cur,0) - nvl(c.deposito_cur,0) delta_deposito_cur,
								nvl(d.deposito,0) deposito,
								nvl(c.deposito,0)deposito_baseline,
								 CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.deposito,0)-nvl(c.deposito,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.deposito,0) -nvl(c.deposito,0) < 0 then nvl(d.deposito,0) -nvl(c.deposito,0)
								 else nvl(d.deposito,0)-nvl(c.deposito,0)
								END AS delta_deposito, 
								0 RENCANA_DEPOSITO,
								CASE
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) < 0 then 'LEAK'
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) = 0 then 'PAR'
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) > 0 then 'RAISE'
								 end as status_deposito,
								nvl(d.tabungan,0)+nvl(d.giro,0)+nvl(d.deposito,0) DPK,
								nvl(a.tabungan,0)+nvl(b.giro,0)+nvl(c.deposito,0) DPK_BASELINE,
							   (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) DELTA_DPK,
							   0 RENCANA_DPK,
							   CASE
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) < 0 THEN 'LEAK'
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) = 0 THEN 'PAR'
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) > 0 THEN 'RAISE'
							   END AS STATUS_DPK,
								CASE 
							   WHEN e.status IS NOT NULL then e.status
							   else 'AKUISISI'
							   end AS ket    
									from
								(
									select bni_cif_key cif_key,bni_sales_id sales_id from $table_kelolaan where $where 
									union
									select cif_key,to_char(sales_id) from  $table where  CUST_TYPE = 'CR'
								)x
								left join
								(    select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) giro_cur,sum(avg_book_bal) giro
									from $table where product_id = $gir
									group by sales_id,cif_key) b
								on x.sales_id = b.sales_id and x.cif_key = b.cif_key
								left join
								(select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) tabungan_cur,sum(avg_book_bal) tabungan
									from $table where product_id = $tab 
									group by sales_id,cif_key)a
								on x.sales_id = a.sales_id and x.cif_key = a.cif_key
								left join
								( select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) DEPOSITO_cur,sum(avg_book_bal) DEPOSITO
									from $table where product_id = $dep
									group by sales_id,cif_key) c
									on x.sales_id = c.sales_id and x.cif_key = c.cif_key
									left join
								(select 
									as_of_date,bni_cif_key,cust_type,cust_name,branch_name,open_branch,bni_sales_id,TABUNGAN_CUR,TABUNGAN
									,GIRO_CUR,GIRO,DEPOSITO_CUR,DEPOSITO
									from $table_kelolaan where  $where) d
									on  x.cif_key = d.bni_cif_key
									left join flagging_status e
									on x.cif_key||'$id' = e.id
									left join 
									(
										select cif_key,sum(rencana) rencana,MONTH,YEAR from(
										select sales_id,CIF_KEY,sum(rencana) RENCANA,MONTH,YEAR  from new_account_planning a
										left join pipe_lookup_product b on a.product_id = b.id
										where  MONTH = $bln and Year = $thn and b.product_category = 2
										group by sales_id,cif_key,month,year
										union
										select sales_id,CIF_KEY,sum(rencana) RENCANA,MONTH,YEAR  from PIPELINE_BM a
										left join pipe_lookup_product b on a.product_id = b.id
										where  MONTH = $bln and Year = $thn 
										group by sales_id,cif_key,month,year)
										group by cif_key,MONTH,YEAR
									)f
									on d.bni_cif_key = f.cif_key
									order by d.cust_name
				)a
				left join user_tst b
				on a.sales_id = b.id
				left join vw_kln_bm c
				on a.sales_id = c.npp
				where b.branch = $branch
				group by SALES_ID,user_name,user_level,branch,c.branch_name,c.kln_name
				order by delta_tabungan asc";
		}
		else
		{
		$sql = "SELECT * FROM (SELECT * FROM TMP_NASABAH_KELOLAAN WHERE BNI_SALES_ID = '$id' AND $where) ORDER BY CUST_NAME";
		}
		return $result=$this->db->query($sql)->result();
	}
	
	function get_nasabah_sum_kelolaan4_wil($region,$m,$tipe)
	{
		$bln = date('m');
		$thn = date ('Y');
		switch ($tipe)
		{
			case 0:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2016_TOP";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_TOP";
						$where = "LAST_MONTH = 0 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 1:
						$table = "TMP_BASELINE_2016_TOP";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_TOP";
						$where = "LAST_MONTH = 1 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE  LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE  LAST_MONTH = 1)
						";
						break;
				}
				break;
			case 1:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2016";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 0 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
							$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 1:
						$table = "TMP_BASELINE_2016";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 1 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
						$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 1)
						";
						break;
				}
				break;
		}
		if ($m < 2)
		{
		$sql = "select
				c.region,
				b.branch,
				c.branch_name,
                SUM(NVL(TABUNGAN_CUR,0)) TABUNGAN_CUR    ,
                SUM(NVL(TABUNGAN_CUR_BASELINE,0)) TABUNGAN_CUR_BASELINE    ,
                SUM(NVL(DELTA_TABUNGAN_CUR,0)) DELTA_TABUNGAN_CUR   ,
                SUM(NVL(TABUNGAN,0)) TABUNGAN   ,
                SUM(NVL(TABUNGAN_BASELINE,0)) TABUNGAN_BASELINE    ,
                SUM(NVL(DELTA_TABUNGAN,0)) DELTA_TABUNGAN    ,
				CASE 
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) > 0 THEN 'RAISE'
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) = 0 THEN 'PAR'
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) < 0 THEN 'LEAK'
				END AS STATUS_TABUNGAN,
                SUM(NVL(RENCANA_TABUNGAN,0)) RENCANA_TABUNGAN    ,
                CASE 
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) < 0 THEN
                SUM(NVL(DELTA_TABUNGAN,0)) + SUM(NVL(RENCANA_TABUNGAN,0)) 
				ELSE
				SUM(NVL(DELTA_TABUNGAN,0)) + SUM(NVL(RENCANA_TABUNGAN,0)) 
				END AS DELTA_RENCANA_TABUNGAN,
                SUM(NVL(GIRO_CUR,0)) GIRO_CUR    ,
                SUM(NVL(GIRO_CUR_BASELINE,0)) GIRO_CUR_BASELINE    ,
                SUM(NVL(DELTA_GIRO_CUR,0)) DELTA_GIRO_CUR    ,
                SUM(NVL(GIRO,0)) GIRO    ,
                SUM(NVL(GIRO_BASELINE,0)) GIRO_BASELINE    ,
                SUM(NVL(DELTA_GIRO,0)) DELTA_GIRO    ,
                SUM(NVL(RENCANA_GIRO,0)) RENCANA_GIRO    ,
                SUM(NVL(DELTA_GIRO,0)) - SUM(NVL(RENCANA_GIRO,0)) DELTA_RENCANA_GIRO,
                SUM(NVL(DEPOSITO_CUR,0)) DEPOSITO    ,
                SUM(NVL(DEPOSITO_CUR_BASELINE,0)) DEPOSITO_CUR_BASELINE    ,
                SUM(NVL(DELTA_DEPOSITO_CUR,0)) DELTA_DEPOSITO_CUR    ,
                SUM(NVL(DEPOSITO,0)) DEPOSITO    ,
                SUM(NVL(DEPOSITO_BASELINE,0)) DEPOSITO_BASELINE    ,
                SUM(NVL(DELTA_DEPOSITO,0)) DELTA_DEPOSITO    ,
                SUM(NVL(RENCANA_DEPOSITO,0)) RENCANA_DEPOSITO    ,
                SUM(NVL(DELTA_DEPOSITO,0)) - SUM(NVL(RENCANA_DEPOSITO,0)) DELTA_RENCANA_DEPOSITO,
                SUM(NVL(DPK,0)) DPK    ,
                SUM(NVL(DPK_BASELINE,0)) DPK_BASELINE    ,
                SUM(NVL(DELTA_DPK,0)) DELTA_DPK    ,
                SUM(NVL(RENCANA_DPK,0)) RENCANA_DPK    ,
                SUM(NVL(DELTA_DPK,0)) - SUM(NVL(RENCANA_DPK,0)) DELTA_RENCANA_DPK  
				FROM
				(
					select d.as_of_date,x.sales_id,x.cif_key,d.cust_name,d.branch_name,d.open_branch,
								nvl(d.tabungan_cur,0)tabungan_cur,
								nvl(a.tabungan_cur,0)tabungan_cur_baseline,
								nvl(d.tabungan_cur,0) - nvl(a.tabungan_cur,0) DELTA_TABUNGAN_CUR,
								nvl(d.tabungan,0) tabungan,
								nvl(a.tabungan,0)tabungan_baseline,
								 CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.tabungan,0)-nvl(a.tabungan,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.tabungan,0) -nvl(a.tabungan,0) < 0 then nvl(d.tabungan,0)-nvl(a.tabungan,0) 
								 else nvl(d.tabungan,0)-nvl(a.tabungan,0)
								END AS delta_tabungan,
								nvl(f.rencana,0) RENCANA_TABUNGAN,
								CASE
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) < 0 then 'LEAK'
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) = 0 then 'PAR'
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) > 0 then 'RAISE'
								END AS status_tabungan,
								nvl(d.giro_cur,0)giro_cur,
								nvl(b.giro_cur,0)giro_cur_baseline,
								nvl(d.giro_cur,0) - nvl(b.giro_cur,0) delta_giro_cur,
								nvl(d.giro,0) giro,
								nvl(b.giro,0)giro_baseline,
								  CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.giro,0)-nvl(b.giro,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.giro,0) -nvl(b.giro,0) < 0 then nvl(d.giro,0) -nvl(b.giro,0)
								 else nvl(d.giro,0)-nvl(b.giro,0)
								END AS delta_giro,
								0 RENCANA_GIRO,
								 CASE
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) < 0 THEN 'LEAK'
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) = 0 THEN 'PAR'
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) > 0 THEN 'RAISE'
								END AS status_giro,
								nvl(d.deposito_cur,0)deposito_cur,
								nvl(c.deposito_cur,0)deposito_cur_baseline,
								nvl(d.deposito_cur,0) - nvl(c.deposito_cur,0) delta_deposito_cur,
								nvl(d.deposito,0) deposito,
								nvl(c.deposito,0)deposito_baseline,
								 CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.deposito,0)-nvl(c.deposito,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.deposito,0) -nvl(c.deposito,0) < 0 then nvl(d.deposito,0) -nvl(c.deposito,0)
								 else nvl(d.deposito,0)-nvl(c.deposito,0)
								END AS delta_deposito, 
								0 RENCANA_DEPOSITO,
								CASE
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) < 0 then 'LEAK'
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) = 0 then 'PAR'
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) > 0 then 'RAISE'
								 end as status_deposito,
								nvl(d.tabungan,0)+nvl(d.giro,0)+nvl(d.deposito,0) DPK,
								nvl(a.tabungan,0)+nvl(b.giro,0)+nvl(c.deposito,0) DPK_BASELINE,
							   (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) DELTA_DPK,
							   0 RENCANA_DPK,
							   CASE
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) < 0 THEN 'LEAK'
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) = 0 THEN 'PAR'
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) > 0 THEN 'RAISE'
							   END AS STATUS_DPK,
								CASE 
							   WHEN e.status IS NOT NULL then e.status
							   else 'AKUISISI'
							   end AS ket    
									from
								(
									select bni_cif_key cif_key,bni_sales_id sales_id from $table_kelolaan where $where 
									union
									select cif_key,to_char(sales_id) from  $table where  CUST_TYPE = 'CR'
								)x
								left join
								(    select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) giro_cur,sum(avg_book_bal) giro
									from $table where product_id = $gir
									group by sales_id,cif_key) b
								on x.sales_id = b.sales_id and x.cif_key = b.cif_key
								left join
								(select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) tabungan_cur,sum(avg_book_bal) tabungan
									from $table where product_id = $tab 
									group by sales_id,cif_key)a
								on x.sales_id = a.sales_id and x.cif_key = a.cif_key
								left join
								( select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) DEPOSITO_cur,sum(avg_book_bal) DEPOSITO
									from $table where product_id = $dep
									group by sales_id,cif_key) c
									on x.sales_id = c.sales_id and x.cif_key = c.cif_key
									left join
								(select 
									as_of_date,bni_cif_key,cust_type,cust_name,branch_name,open_branch,bni_sales_id,TABUNGAN_CUR,TABUNGAN
									,GIRO_CUR,GIRO,DEPOSITO_CUR,DEPOSITO
									from $table_kelolaan where  $where) d
									on  x.cif_key = d.bni_cif_key
									left join flagging_status e
									on x.cif_key||'$id' = e.id
									left join 
									(
										select cif_key,sum(rencana) rencana,MONTH,YEAR from(
										select sales_id,CIF_KEY,sum(rencana) RENCANA,MONTH,YEAR  from new_account_planning a
										left join pipe_lookup_product b on a.product_id = b.id
										where  MONTH = $bln and Year = $thn and b.product_category = 2
										group by sales_id,cif_key,month,year
										union
										select sales_id,CIF_KEY,sum(rencana) RENCANA,MONTH,YEAR  from PIPELINE_BM a
										left join pipe_lookup_product b on a.product_id = b.id
										where  MONTH = $bln and Year = $thn 
										group by sales_id,cif_key,month,year)
										group by cif_key,MONTH,YEAR
									)f
									on d.bni_cif_key = f.cif_key
									order by d.cust_name
				)a
				left join user_tst b
				on a.sales_id = b.id
				left join branch c
				on b.branch = c.branch_code
				where c.region = $region
				group by c.region,b.branch,c.branch_name
				order by delta_tabungan asc";
		}
		else
		{
		$sql = "SELECT * FROM (SELECT * FROM TMP_NASABAH_KELOLAAN WHERE BNI_SALES_ID = '$id' AND $where) ORDER BY CUST_NAME";
		}
		return $result=$this->db->query($sql)->result();
	}
	
	function get_nasabah_sum_kelolaan4_sln($m,$tipe)
	{
		$bln = date('m');
		$thn = date ('Y');
		switch ($tipe)
		{
			case 0:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2016_TOP";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_TOP";
						$where = "LAST_MONTH = 0 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 1:
						$table = "TMP_BASELINE_2016_TOP";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_TOP";
						$where = "LAST_MONTH = 1 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE  LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE  LAST_MONTH = 1)
						";
						break;
				}
				break;
			case 1:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2016";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 0 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
							$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 1:
						$table = "TMP_BASELINE_2016";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 1 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
						$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 1)
						";
						break;
				}
				break;
		}
		if ($m < 2)
		{
		$sql = "select
				c.region,
				d.REGION_NAME,
                SUM(NVL(TABUNGAN_CUR,0)) TABUNGAN_CUR    ,
                SUM(NVL(TABUNGAN_CUR_BASELINE,0)) TABUNGAN_CUR_BASELINE    ,
                SUM(NVL(DELTA_TABUNGAN_CUR,0)) DELTA_TABUNGAN_CUR   ,
                SUM(NVL(TABUNGAN,0)) TABUNGAN   ,
                SUM(NVL(TABUNGAN_BASELINE,0)) TABUNGAN_BASELINE    ,
                SUM(NVL(DELTA_TABUNGAN,0)) DELTA_TABUNGAN    ,
				CASE 
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) > 0 THEN 'RAISE'
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) = 0 THEN 'PAR'
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) < 0 THEN 'LEAK'
				END AS STATUS_TABUNGAN,
                SUM(NVL(RENCANA_TABUNGAN,0)) RENCANA_TABUNGAN    ,
               CASE 
				WHEN SUM(NVL(DELTA_TABUNGAN,0)) < 0 THEN
                SUM(NVL(DELTA_TABUNGAN,0)) + SUM(NVL(RENCANA_TABUNGAN,0)) 
				ELSE
				SUM(NVL(DELTA_TABUNGAN,0)) + SUM(NVL(RENCANA_TABUNGAN,0)) 
				END AS DELTA_RENCANA_TABUNGAN,
                SUM(NVL(GIRO_CUR,0)) GIRO_CUR    ,
                SUM(NVL(GIRO_CUR_BASELINE,0)) GIRO_CUR_BASELINE    ,
                SUM(NVL(DELTA_GIRO_CUR,0)) DELTA_GIRO_CUR    ,
                SUM(NVL(GIRO,0)) GIRO    ,
                SUM(NVL(GIRO_BASELINE,0)) GIRO_BASELINE    ,
                SUM(NVL(DELTA_GIRO,0)) DELTA_GIRO    ,
                SUM(NVL(RENCANA_GIRO,0)) RENCANA_GIRO    ,
                SUM(NVL(DELTA_GIRO,0)) - SUM(NVL(RENCANA_GIRO,0)) DELTA_RENCANA_GIRO,
                SUM(NVL(DEPOSITO_CUR,0)) DEPOSITO    ,
                SUM(NVL(DEPOSITO_CUR_BASELINE,0)) DEPOSITO_CUR_BASELINE    ,
                SUM(NVL(DELTA_DEPOSITO_CUR,0)) DELTA_DEPOSITO_CUR    ,
                SUM(NVL(DEPOSITO,0)) DEPOSITO    ,
                SUM(NVL(DEPOSITO_BASELINE,0)) DEPOSITO_BASELINE    ,
                SUM(NVL(DELTA_DEPOSITO,0)) DELTA_DEPOSITO    ,
                SUM(NVL(RENCANA_DEPOSITO,0)) RENCANA_DEPOSITO    ,
                SUM(NVL(DELTA_DEPOSITO,0)) - SUM(NVL(RENCANA_DEPOSITO,0)) DELTA_RENCANA_DEPOSITO,
                SUM(NVL(DPK,0)) DPK    ,
                SUM(NVL(DPK_BASELINE,0)) DPK_BASELINE    ,
                SUM(NVL(DELTA_DPK,0)) DELTA_DPK    ,
                SUM(NVL(RENCANA_DPK,0)) RENCANA_DPK    ,
                SUM(NVL(DELTA_DPK,0)) - SUM(NVL(RENCANA_DPK,0)) DELTA_RENCANA_DPK  
				FROM
				(
					select d.as_of_date,x.sales_id,x.cif_key,d.cust_name,d.branch_name,d.open_branch,
								nvl(d.tabungan_cur,0)tabungan_cur,
								nvl(a.tabungan_cur,0)tabungan_cur_baseline,
								nvl(d.tabungan_cur,0) - nvl(a.tabungan_cur,0) DELTA_TABUNGAN_CUR,
								nvl(d.tabungan,0) tabungan,
								nvl(a.tabungan,0)tabungan_baseline,
								 CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.tabungan,0)-nvl(a.tabungan,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.tabungan,0) -nvl(a.tabungan,0) < 0 then nvl(d.tabungan,0)-nvl(a.tabungan,0) 
								 else nvl(d.tabungan,0)-nvl(a.tabungan,0)
								END AS delta_tabungan,
								nvl(f.rencana,0) RENCANA_TABUNGAN,
								CASE
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) < 0 then 'LEAK'
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) = 0 then 'PAR'
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) > 0 then 'RAISE'
								END AS status_tabungan,
								nvl(d.giro_cur,0)giro_cur,
								nvl(b.giro_cur,0)giro_cur_baseline,
								nvl(d.giro_cur,0) - nvl(b.giro_cur,0) delta_giro_cur,
								nvl(d.giro,0) giro,
								nvl(b.giro,0)giro_baseline,
								  CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.giro,0)-nvl(b.giro,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.giro,0) -nvl(b.giro,0) < 0 then nvl(d.giro,0) -nvl(b.giro,0)
								 else nvl(d.giro,0)-nvl(b.giro,0)
								END AS delta_giro,
								0 RENCANA_GIRO,
								 CASE
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) < 0 THEN 'LEAK'
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) = 0 THEN 'PAR'
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) > 0 THEN 'RAISE'
								END AS status_giro,
								nvl(d.deposito_cur,0)deposito_cur,
								nvl(c.deposito_cur,0)deposito_cur_baseline,
								nvl(d.deposito_cur,0) - nvl(c.deposito_cur,0) delta_deposito_cur,
								nvl(d.deposito,0) deposito,
								nvl(c.deposito,0)deposito_baseline,
								 CASE
								 WHEN e.status_id in(0,2) and d.cust_type in(1,5) then nvl(d.deposito,0)-nvl(c.deposito,0) 
								 WHEN e.status_id = 1 and d.cust_type in(1,5) and nvl(d.deposito,0) -nvl(c.deposito,0) < 0 then nvl(d.deposito,0) -nvl(c.deposito,0)
								 else nvl(d.deposito,0)-nvl(c.deposito,0)
								END AS delta_deposito, 
								0 RENCANA_DEPOSITO,
								CASE
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) < 0 then 'LEAK'
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) = 0 then 'PAR'
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) > 0 then 'RAISE'
								 end as status_deposito,
								nvl(d.tabungan,0)+nvl(d.giro,0)+nvl(d.deposito,0) DPK,
								nvl(a.tabungan,0)+nvl(b.giro,0)+nvl(c.deposito,0) DPK_BASELINE,
							   (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) DELTA_DPK,
							   0 RENCANA_DPK,
							   CASE
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) < 0 THEN 'LEAK'
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) = 0 THEN 'PAR'
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) > 0 THEN 'RAISE'
							   END AS STATUS_DPK,
								CASE 
							   WHEN e.status IS NOT NULL then e.status
							   else 'AKUISISI'
							   end AS ket    
									from
								(
									select bni_cif_key cif_key,bni_sales_id sales_id from $table_kelolaan where $where 
									union
									select cif_key,to_char(sales_id) from  $table where  CUST_TYPE = 'CR'
								)x
								left join
								(    select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) giro_cur,sum(avg_book_bal) giro
									from $table where product_id = $gir
									group by sales_id,cif_key) b
								on x.sales_id = b.sales_id and x.cif_key = b.cif_key
								left join
								(select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) tabungan_cur,sum(avg_book_bal) tabungan
									from $table where product_id = $tab 
									group by sales_id,cif_key)a
								on x.sales_id = a.sales_id and x.cif_key = a.cif_key
								left join
								( select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) DEPOSITO_cur,sum(avg_book_bal) DEPOSITO
									from $table where product_id = $dep
									group by sales_id,cif_key) c
									on x.sales_id = c.sales_id and x.cif_key = c.cif_key
									left join
								(select 
									as_of_date,bni_cif_key,cust_type,cust_name,branch_name,open_branch,bni_sales_id,TABUNGAN_CUR,TABUNGAN
									,GIRO_CUR,GIRO,DEPOSITO_CUR,DEPOSITO
									from $table_kelolaan where  $where) d
									on  x.cif_key = d.bni_cif_key
									left join flagging_status e
									on x.cif_key||'$id' = e.id
									left join 
									(
										select cif_key,sum(rencana) rencana,MONTH,YEAR from(
										select sales_id,CIF_KEY,sum(rencana) RENCANA,MONTH,YEAR  from new_account_planning a
										left join pipe_lookup_product b on a.product_id = b.id
										where  MONTH = $bln and Year = $thn and b.product_category = 2
										group by sales_id,cif_key,month,year
										union
										select sales_id,CIF_KEY,sum(rencana) RENCANA,MONTH,YEAR  from PIPELINE_BM a
										left join pipe_lookup_product b on a.product_id = b.id
										where  MONTH = $bln and Year = $thn 
										group by sales_id,cif_key,month,year)
										group by cif_key,MONTH,YEAR
									)f
									on d.bni_cif_key = f.cif_key
									order by d.cust_name
				)a
				left join user_tst b
				on a.sales_id = b.id
				left join branch c
				on b.branch = c.branch_code
				left join branch_region d
				on c.region = d.region_code
				where c.region is not null
				group by c.region,d.region_name
				order by delta_tabungan asc";
		}
		else
		{
		$sql = "SELECT * FROM (SELECT * FROM TMP_NASABAH_KELOLAAN WHERE BNI_SALES_ID = '$id' AND $where) ORDER BY CUST_NAME";
		}
		return $result=$this->db->query($sql)->result();
	}
	
	function get_nasabah_kelolaan5($id,$m,$product,$tipe)
	{
/*
	echo"<pre>";	
	echo $id;	
	echo"<pre>";	
	echo $m;	
	echo"<pre>";	
	echo $product;	
	echo"<pre>";	
	echo $tipe;	
	echo"<pre>";	
*/		
		
/*
*/		
		$tanggal=date("d-M-Y");
//?????		$week = date('W',$tanggal);
		$bln = date('m');
		$thn = date ('Y');
		switch($product)
		{
			case 1:
				$urut='order by delta_giro';
			break;
			case 2:
				$urut='order by delta_tabungan';
			break;
			case 3:
				$urut='order by delta_deposito';
			break;
			case 4:
				$urut='order by DELTA_INVESTASI';
			break;
			case 5:
				$urut='order by DELTA_BANCAS';
			break;
			case 6:
				$urut='order by AUM';
			break;
		}
		switch ($tipe)
		{
			case 0:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2017";
						$flagstatus ="FLAGGING_STATUS_2017";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN";
						$where = "LAST_MONTH = 0 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$real_baseline =" and baseline_date2 < (select distinct as_of_date from tmp_nasabah_kelolaan where last_month=0 and as_of_date is not null)";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 1:
						$table = "TMP_BASELINE_2017";
						$flagstatus ="FLAGGING_STATUS_2017";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN";
						$where = "LAST_MONTH = 1 and CUST_TYPE IN(1,5)";
						$basetipe = "and CUST_TYPE = 'CR'";
						$real_baseline =" and baseline_date2 < (select distinct as_of_date from tmp_nasabah_kelolaan where last_month=1 and as_of_date is not null)";
						$tab     = 2;
						$gir     = 1;
						$dep	 = 3;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 1)
						";
						break;
				}
				break;
				
				
			case 1:
				switch ($m) 
				{
					case 0:
						$table = "TMP_BASELINE_2017";
						$flagstatus ="FLAGGING_STATUS_2017";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 0 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
						$real_baseline =" and baseline_date2 < (select distinct as_of_date from tmp_nasabah_kelolaan where last_month=0 and as_of_date is not null)";
							$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 1:
						$table = "TMP_BASELINE_2017";
						$flagstatus ="FLAGGING_STATUS_2017";
						$table_kelolaan ="TMP_NASABAH_KELOLAAN_BB";
						$where = "LAST_MONTH = 1 and CUST_TYPE NOT IN(1,5)";
						$basetipe = "and CUST_TYPE = 'BB'";
						$real_baseline =" and baseline_date2 < (select distinct as_of_date from tmp_nasabah_kelolaan where last_month=1 and as_of_date is not null)";
						$tab     = 5;
						$gir     = 4;
						$dep	 = 6;
						break;
					case 2:
						$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 0)
						";
						break;
					case 3:
						$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')
						UNION
						SELECT NULL AS REGION,NULL AS BRANCH,NULL AS BRANCH_NAME,NULL AS USER_NAME,NULL AS SALES,NULL AS SALES_TYPE,NULL AS GRADE,
						NULL AS SPV,NULL AS AS_OF_DATE,NULL AS OPEN_BRANCH,SALES_ID AS BNI_SALES_ID,CIF_KEY AS BNI_CIF_KEY,
						NULL AS CUST_NAME,NULL AS JML,NULL AS LAST_MONTH,NULL AS GIRO_CUR,NULL AS GIRO,NULL AS TABUNGAN_CUR,NULL AS TABUNGAN,
						NULL AS DEPOSITO_CUR,NULL AS DEPOSITO,NULL AS DPK,NULL AS CUST_TYPE,NULL AS AMOUNT,NULL AS AUM FROM CR_FLAGGING 
						WHERE SALES_ID = '$id' AND CIF_KEY NOT IN 
					   (SELECT BNI_CIF_KEY FROM TMP_NASABAH_KELOLAAN WHERE SALES_ID = '$id' AND LAST_MONTH = 1)
						";
						break;
				}
				break;
		}
		if ($m < 2)
		{
		$sql = "select
				AS_OF_DATE    ,
				SALES_ID    ,
				a.CIF_KEY    ,
				CUST_NAME    ,
				BRANCH_NAME    ,
				OPEN_BRANCH    ,
				TABUNGAN_CUR    ,
				TABUNGAN_CUR_BASELINE    ,
				DELTA_TABUNGAN_CUR    ,
				TABUNGAN    ,
				TABUNGAN_BASELINE    ,
				DELTA_TABUNGAN    ,
				RENCANA_TABUNGAN    ,
				DELTA_TABUNGAN + RENCANA_TABUNGAN DELTA_RENCANA_TABUNGAN,
				STATUS_TABUNGAN    ,
				GIRO_CUR    ,
				GIRO_CUR_BASELINE    ,
				DELTA_GIRO_CUR    ,
				GIRO    ,
				GIRO_BASELINE    ,
				DELTA_GIRO    ,
				RENCANA_GIRO    ,
				DELTA_GIRO + RENCANA_GIRO DELTA_RENCANA_GIRO,
				STATUS_GIRO    ,
				DEPOSITO_CUR    ,
				DEPOSITO_CUR_BASELINE    ,
				DELTA_DEPOSITO_CUR    ,
				DEPOSITO    ,
				DEPOSITO_BASELINE    ,
				DELTA_DEPOSITO    ,
				RENCANA_DEPOSITO    ,
				DELTA_DEPOSITO + RENCANA_DEPOSITO DELTA_RENCANA_DEPOSITO,
				STATUS_DEPOSITO    ,
				DPK    ,
				DPK_BASELINE    ,
				DELTA_DPK    ,
				RENCANA_DPK    ,
				DELTA_DPK + RENCANA_DPK DELTA_RENCANA_DPK,
				STATUS_DPK    ,
				KET	,
				NVL(AUM_INVESTASI,0) INVESTASI ,
				NVL(BASELINE_INVESTASI,0) BASELINE_INVESTASI,
				NVL(DELTA_INVESTASI,0) DELTA_INVESTASI,
                NVL(AUM_BANCAS,0) BANCAS,
				NVL(BASELINE_BANCAS,0) BASELINE_BANCAS,
				NVL(DELTA_BANCAS,0) DELTA_BANCAS,
                NVL(DPK,0)+NVL(AUM_INVESTASI,0)+NVL(AUM_BANCAS,0) AUM,
				CASE
				WHEN CIF IS NULL then 0
				ELSE 1
				END AS AKTIFITAS
				FROM
				(
					select d.as_of_date,x.sales_id,x.cif_key,d.cust_name,d.branch_name,d.open_branch,
								nvl(d.tabungan_cur,0)tabungan_cur,
								nvl(a.tabungan_cur,0)tabungan_cur_baseline,
								nvl(d.tabungan_cur,0) - nvl(a.tabungan_cur,0) DELTA_TABUNGAN_CUR,
								nvl(d.tabungan,0) tabungan,
								nvl(a.tabungan,0)tabungan_baseline,
								 CASE
								 WHEN e.status_id in(0,2)  then nvl(d.tabungan,0)-nvl(a.tabungan,0) 
								 WHEN e.status_id = 1  and nvl(d.tabungan,0) -nvl(a.tabungan,0) < 0 then 0
								 else nvl(d.tabungan,0)-nvl(a.tabungan,0)
								END AS delta_tabungan,
								NVL(f.rencana,0) RENCANA_TABUNGAN,
								CASE
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) < 0 then 'LEAK'
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) = 0 then 'PAR'
								 WHEN  nvl(d.tabungan,0)-nvl(a.tabungan,0) > 0 then 'RAISE'
								END AS status_tabungan,
								nvl(d.giro_cur,0)giro_cur,
								nvl(b.giro_cur,0)giro_cur_baseline,
								nvl(d.giro_cur,0) - nvl(b.giro_cur,0) delta_giro_cur,
								nvl(d.giro,0) giro,
								nvl(b.giro,0)giro_baseline,
								  CASE
								 WHEN e.status_id in(0,2)  then nvl(d.giro,0)-nvl(b.giro,0) 
								 WHEN e.status_id = 1  and nvl(d.giro,0) -nvl(b.giro,0) < 0 then 0
								 else nvl(d.giro,0)-nvl(b.giro,0)
								END AS delta_giro,
								NVL(f.rencana,0) RENCANA_GIRO,
								 CASE
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) < 0 THEN 'LEAK'
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) = 0 THEN 'PAR'
								 WHEN nvl(d.giro,0)-nvl(b.giro,0) > 0 THEN 'RAISE'
								END AS status_giro,
								nvl(d.deposito_cur,0)deposito_cur,
								nvl(c.deposito_cur,0)deposito_cur_baseline,
								nvl(d.deposito_cur,0) - nvl(c.deposito_cur,0) delta_deposito_cur,
								nvl(d.deposito,0) deposito,
								nvl(c.deposito,0)deposito_baseline,
								 CASE
								 WHEN e.status_id in(0,2)  then nvl(d.deposito,0)-nvl(c.deposito,0) 
								 WHEN e.status_id = 1  and nvl(d.deposito,0) -nvl(c.deposito,0) < 0 then 0
								 else nvl(d.deposito,0)-nvl(c.deposito,0)
								END AS delta_deposito, 
								NVL(f.rencana,0) RENCANA_DEPOSITO,
								CASE
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) < 0 then 'LEAK'
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) = 0 then 'PAR'
								 WHEN nvl(d.deposito,0)-nvl(c.deposito,0) > 0 then 'RAISE'
								 end as status_deposito,
								nvl(d.tabungan,0)+nvl(d.giro,0)+nvl(d.deposito,0) DPK,
								nvl(a.tabungan,0)+nvl(b.giro,0)+nvl(c.deposito,0) DPK_BASELINE,
							   (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) DELTA_DPK,
							   0 RENCANA_DPK,
							   CASE
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) < 0 THEN 'LEAK'
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) = 0 THEN 'PAR'
								WHEN (nvl(d.tabungan,0)-nvl(a.tabungan,0))+(nvl(d.giro,0)-nvl(b.giro,0))+(nvl(d.deposito,0)-nvl(c.deposito,0)) > 0 THEN 'RAISE'
							   END AS STATUS_DPK,
								CASE 
							      WHEN e.status IS NOT NULL and d.bni_cif_key is not null then e.status
								WHEN e.status IS NULL and d.bni_cif_key is not null then 'AKUISISI'
								else ''
							   end AS ket    
									from
								(
									select bni_cif_key cif_key,bni_sales_id sales_id from $table_kelolaan where $where and bni_sales_id = $id
									union
									select cif_key,to_char(sales_id) from  $table where sales_id = $id $basetipe $real_baseline
								)x
								left join
								(    select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) giro_cur,sum(avg_book_bal) giro
									from $table where product_id = $gir $real_baseline
									group by sales_id,cif_key) b
								on x.sales_id = b.sales_id and x.cif_key = b.cif_key
								left join
								(select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) tabungan_cur,sum(avg_book_bal) tabungan
									from $table where product_id = $tab $real_baseline
									group by sales_id,cif_key)a
								on x.sales_id = a.sales_id and x.cif_key = a.cif_key
								left join
								( select 
									sales_id,cif_key,sum(bni_cur_book_bal_idr) DEPOSITO_cur,sum(avg_book_bal) DEPOSITO
									from $table where product_id = $dep $real_baseline
									group by sales_id,cif_key) c
									on x.sales_id = c.sales_id and x.cif_key = c.cif_key
									left join
								(select 
									as_of_date,bni_cif_key,cust_type,cust_name,branch_name,open_branch,bni_sales_id,TABUNGAN_CUR,TABUNGAN
									,GIRO_CUR,GIRO,DEPOSITO_CUR,DEPOSITO
									from $table_kelolaan where  $where) d
									on x.sales_id = d.bni_sales_id and x.cif_key = d.bni_cif_key
									left join $flagstatus e
									on x.cif_key||'$id' = e.id
									left join 
									(
										select cif_key,sum(rencana) rencana,MONTH,YEAR from(
										select sales_id,CIF_KEY,sum(rencana) RENCANA,MONTH,YEAR  from new_account_planning a
										left join pipe_lookup_product b on a.product_id = b.id
										where  MONTH = $bln and Year = $thn and sales_id = $id and b.product_category = $product
										group by sales_id,cif_key,month,year
										union
										select sales_id,CIF_KEY,sum(rencana) RENCANA,MONTH,YEAR  from PIPELINE_BM a
										left join pipe_lookup_product b on a.product_id = b.id
										where  MONTH = $bln and Year = $thn 
										group by sales_id,cif_key,month,year)
										group by cif_key,MONTH,YEAR
									)f
									on d.bni_cif_key = f.cif_key
									where x.sales_id = $id
									order by d.cust_name
				)a
				left join (select cif_key cif from agenda_bm where npp = $id and realisasi is null)b
				on a.cif_key = b.cif
				left join 
				(
					 select a.cif_key,a.aum_investasi,NVL(b.investasi,0) BASELINE_INVESTASI,a.aum_investasi-NVL(b.investasi,0) DELTA_INVESTASI from aum_investasi a
					left join ( select * from tmp_baseline_aum where baseline_date>='31-DEC_2016' and sales_id = $id)b
					on a.cif_key = b.cif_key
					where a.last_month=$m
				) c
                on a.cif_key = c.cif_key
                left join 
				(
					select a.cif_key,a.aum_bancas,NVL(b.bancas,0) BASELINE_BANCAS,a.aum_bancas-NVL(b.bancas,0) DELTA_BANCAS from aum_bancas a
					left join ( select * from tmp_baseline_aum where baseline_date>='31-DEC_2016' and sales_id = $id)b
					on a.cif_key = b.cif_key
					where a.last_month=$m
				) d
                on a.cif_key = d.cif_key
				$urut";
		}
		else
		{
		//ok	
		$sql = "SELECT * FROM (SELECT * FROM TMP_NASABAH_KELOLAAN WHERE BNI_SALES_ID = '$id' AND $where) ORDER BY CUST_NAME";
		}
		//echo $sql;die();
		return $this->db->query($sql)->result();
	}
	
	function get_list_nasabah($id)
	{
		$sql = "SELECT a.*,b.PRODUCT_NAME FROM TMP_BASELINE_2017 a LEFT JOIN PRODUCT b on a.PRODUCT_ID = b.ID WHERE a.SALES_ID = '$id' order by a.CUST_NAME";
		return $this->db->query($sql)->result();
	}
	
	function get_baseline($id,$year,$bulan)
	{	$this->db->select("a.BASELINE_DATE,a.CUST_TYPE,a.PRODUCT_ID,b.PRODUCT_NAME, NVL(a.BASE_AVG_BAL,0) OUTSTANDING");
		$this->db->from('BASELINE_2017 a');
		$this->db->join('PRODUCT b', 'a.PRODUCT_ID = b.ID');
		$this->db->where("a.SALES_ID",$id);
		//$this->db->order_by('a.PRODUCT_ID',ASC);
		
		//$this->db->get();	
		//$data = $this->db->last_query();
		//echo "$data"; die();
		//print_r $this->db->get();die();
		return $this->db->get()->result();	
	}
	
	function get_baseline_aum($id)
	{
		$this->db->select("BASELINE_DATE,CIF_KEY,CUST_NAME,DPK,INVESTASI,BANCAS,AUM");
		$this->db->from('TMP_BASELINE_AUM');
		$this->db->where("SALES_ID",$id);
		$this->db->where("BASELINE_DATE >=","31-DEC-2016");
		return $this->db->get()->result();	
	}
	
	function get_nasabah_kelolaan2_aum($id, $m)
	{
		switch ($m) 
		{
			case 2:
				$where = "A.LAST_MONTH = 0 and b.year = extract(year from sysdate)";
				break;
			case 1:
				$join  = "LEFT JOIN TMP_POSISI_AUM B ON A.BNI_CIF_KEY = B.CIF_KEY";
				$where = "A.LAST_MONTH = 1 AND B.MONTH = EXTRACT(MONTH FROM SYSDATE) - 1 and b.year = extract(year from sysdate)";
				break;
			case 0:
				$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')";
				break;
			case 3:
				$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id') and b.year = extract(year from sysdate)";
				break;
		}
		
		$sql = "SELECT * FROM TMP_NASABAH_KELOLAAN A $join WHERE BNI_SALES_ID = '$id' AND $where ORDER BY CUST_NAME";
		return $this->db->query($sql)->result();
	}
	
	
	function get_neo_nasabah_kelolaan($id, $m)
	{
		switch ($m) 
		{
			case 0:
				$where = "LAST_MONTH = 0";
				break;
			case 1:
				$where = "LAST_MONTH = 1";
				break;
			case 2:
				$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')";
				break;
			case 3:
				$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')";
				break;
		}
		
		$sql = "SELECT * FROM TMP_NASABAH_KELOLAAN WHERE BNI_SALES_ID = '$id' AND $where ORDER BY CUST_NAME";
		return $this->db->query($sql)->result_array();
	}
	
	//aum
	function get_neo_nasabah_kelolaan_aum($id, $m)
	{
		switch ($m) 
		{
			case 0:
				$where = "LAST_MONTH = 0";
				break;
			case 1:
				$where = "LAST_MONTH = 1";
				break;
			case 2:
				$where = "LAST_MONTH = 0 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')";
				break;
			case 3:
				$where = "LAST_MONTH = 1 AND BNI_CIF_KEY IN(SELECT CIF_KEY FROM CR_FLAGGING WHERE SALES_ID = '$id')";
				break;
		}
		
		$sql = "SELECT * FROM TMP_NASABAH_KELOLAAN WHERE BNI_SALES_ID = '$id' AND $where ORDER BY CUST_NAME";
		return $this->db->query($sql)->result_array();
	}
	
	
	function get_nasabah_kelolaan($id, $last_month, $tipe)
	{
		#return $this->get_nasabah_kelolaan2($id, $last_month);
		return $this->get_nasabah_kelolaan3($id, $last_month, $tipe);
	}
	
	//model nasabah_aum
	function get_nasabah_kelolaan_aum($id, $last_month)
	{
	return $this->get_nasabah_kelolaan2_aum($id, $last_month);
	}
	
	##elo
	function get_nasabah_konsumer($id, $last_month)
	{
		return $this->get_nasabah_konsumer2($id, $last_month);
	}
	
	function get_nasabah_konsumer2($id, $m)
	{
		switch ($m) 
		{
			case 0:
				$where = "LAST_MONTH = 0 AND PRODUCTNAME NOT LIKE '%TOP UP%'";
				break;
			case 1:
				$where = "LAST_MONTH = 1 AND PRODUCTNAME NOT LIKE '%TOP UP%'";
				break;
		}
	
	
		$sql = "SELECT AS_OF_DATE,
				APP_REGNO,
				GROUPNAME,
				PRODUCTNAME,
				CUST_NAME,
				AMOUNT,
				APPLY_DATE,
				CASE
				WHEN APPR_CODE = '4.1' THEN APPROVE_DATE
				ELSE TO_DATE('')
				END APPROVE_DATE,
				BOOKING_DATE
				FROM SAPM_ELO_REPORT WHERE SALES_ID = '$id' AND $where ORDER BY CUST_NAME";
		
		return $this->db->query($sql)->result();
	}
	
	##end elo
	
	
	
	#-------------------------------------
	# 	Get New Customer
	#-------------------------------------	
	function get_new_customer($id, $m, $y)
	{
		//$sql = "SELECT A.*, B.PRODUCT_NAME FROM NEW_CUSTOMER_FINAL A JOIN PRODUCT B ON A.PRODUCT_ID = B.PROC_ID WHERE A.SALES_ID = '$id' AND EXTRACT(YEAR FROM A.CREATE_DATE) = $y AND EXTRACT(MONTH FROM A.CREATE_DATE) = $m ORDER BY A.CUST_NAME";
		
		//$sql = "SELECT distinct A.*, B.PRODUCT_NAME FROM NEW_CUSTOMER_BARU A JOIN PRODUCT B ON A.PRODUCT_ID = B.PROC_ID WHERE A.SALES_ID = '$id' AND EXTRACT(YEAR FROM A.FLAG_DATE) = $y AND EXTRACT(MONTH FROM A.FLAG_DATE) = $m ORDER BY A.CUST_NAME";
		$sql = "SELECT distinct * FROM NOC_FINAL WHERE SALES_ID = '$id' AND EXTRACT(YEAR FROM AS_OF_DATE) = $y AND EXTRACT(MONTH FROM AS_OF_DATE) = $m AND FLAG = 1 ORDER BY AVG_BOOK_BAL DESC";
		
		return $this->db->query($sql)->result_array();
	}
	
	function get_new_customer_nosegmen($id, $m, $y)
	{
		//$sql = "SELECT distinct A.*, B.PRODUCT_NAME FROM NEW_CUSTOMER_FINAL A JOIN PRODUCT B ON A.PRODUCT_ID = B.PROC_ID WHERE A.SALES_ID = '$id' AND EXTRACT(YEAR FROM A.CREATE_DATE) = $y AND EXTRACT(MONTH FROM A.CREATE_DATE) = $m ORDER BY A.CUST_NAME";
		
		//$sql = "SELECT A.*, B.PRODUCT_NAME FROM NEW_CUSTOMER_BARU A JOIN PRODUCT B ON A.PRODUCT_ID = B.PROC_ID WHERE A.SALES_ID = '$id' AND EXTRACT(YEAR FROM A.FLAG_DATE) = $y AND EXTRACT(MONTH FROM A.FLAG_DATE) = $m ORDER BY A.CUST_NAME";
		
		$sql = "SELECT distinct * FROM NOC_FINAL WHERE SALES_ID = '$id' AND EXTRACT(YEAR FROM AS_OF_DATE) = $y AND EXTRACT(MONTH FROM AS_OF_DATE) = $m AND FLAG = 0 ORDER BY AVG_BOOK_BAL DESC";
		return $this->db->query($sql)->result_array();
	}
	
	
	#-------------------------------------
	# 	Get New Account
	#-------------------------------------	
	function get_new_account($id, $m, $y)
	{
		//$sql = "SELECT A.*, B.PRODUCT_NAME FROM NEW_ACCOUNT_BARU A JOIN PRODUCT B ON A.PRODUCT_ID = B.PROC_ID WHERE A.SALES_ID = '$id' AND EXTRACT(YEAR FROM A.FLAG_DATE) = $y AND EXTRACT(MONTH FROM A.OPEN_DATE) = $m ORDER BY A.FLAG_DATE";
		
		$sql = "SELECT distinct * FROM NOA_FINAL WHERE SALES_ID = '$id' AND EXTRACT(YEAR FROM AS_OF_DATE) = $y AND EXTRACT(MONTH FROM AS_OF_DATE) = $m AND FLAG = 1 ORDER BY AVG_BOOK_BAL DESC";
		return $this->db->query($sql)->result_array();
	}
	
	function get_new_account_nosegmen($id, $m, $y)
	{
		//$sql = "SELECT A.*, B.PRODUCT_NAME FROM NEW_ACCOUNT_FINAL A JOIN PRODUCT B ON A.PRODUCT_ID = B.PROC_ID WHERE A.SALES_ID = '$id' AND EXTRACT(YEAR FROM A.OPEN_DATE) = $y AND EXTRACT(MONTH FROM A.OPEN_DATE) = $m ORDER BY A.CUST_NAME";
		$sql = "SELECT distinct * FROM NOA_FINAL WHERE SALES_ID = '$id' AND EXTRACT(YEAR FROM AS_OF_DATE) = $y AND EXTRACT(MONTH FROM AS_OF_DATE) = $m AND FLAG = 0 ORDER BY AVG_BOOK_BAL DESC";
		return $this->db->query($sql)->result_array();
	}
	
	#-------------------------------------
	# 	Get Performance per Sales
	#-------------------------------------		
	function get_performa_sales($id=0, $m=0, $y=0, $type=0)
	{
		$this->db->where('SALES_ID', $id);
		$this->db->where('MM', $m);
		$this->db->where('YYYY', $y);
		$this->db->order_by('BOBOT_CAT, BOBOT_ID', 'ASC');
		if($type==0)
		return $this->db->get('VW_CR_PERFORMANCE')->result();
		else
		return $this->db->get('VW_CR_PERFORMANCE')->result_array();
	}
//=======================================	
	function get_performa_sales_new($id=0, $m=0, $y=0, $type=0)
	{
		
/*
		$this->db->where('SALES_ID', $id);
		$this->db->where('M', $m);
		$this->db->where('Y', $y);
		$this->db->order_by('BOBOT_CAT, BOBOT_ID', 'ASC');
		if($type==0)
		return $this->db->get('VW_PERFORMANCE_NEW')->result();
		else
		return $this->db->get('VW_PERFORMANCE_NEW')->result_array();
*/		
	
	}
	
	function get_performa_sales_tunjangan($id=0, $m=0, $y=0,$salestipe=0)
	{
	
		if($salestipe==1)
		{
			$bobotid = array(1,2,3,4);
		}else
		if($salestipe==2)
		{
			$bobotid=array(1,4,5,6);
		}else
		if($salestipe==3)
		{
			$bobotid=array(1,6);
		}else
		if($salestipe==4)
		{
			$bobotid=array(13);
		}
		//$this->db->where_in('BOBOT_ID',$bobotid);
		$this->db->where('SALES_ID', $id);
		$this->db->where('MM', $m);
		$this->db->where('YYYY', $y);
		$this->db->order_by('BOBOT_CAT, BOBOT_ID', 'ASC');
		$this->db->select('SALES_ID,BOBOT_ID,BOBOT_NAME,REALISASI,100 TARGET,ROUND((REALISASI/1),0) PENCAPAIAN,MM,YYYY',false);
//		if($type==0)
		if($salestipe==0)
		return $this->db->get('VW_CR_PERFORMANCE')->result();
		else
		return $this->db->get('VW_CR_PERFORMANCE')->result_array();
	}
	
	function get_performance_year ($id=0, $y=0, $type=0)
	{
		$sql = "
				SELECT 
					SALES_ID, 
					MM, 
					YYYY, 
					SUM(REALISASI_TERBOBOT) PERFORMANCE
				FROM PERFORMANCE
				WHERE 
					SALES_ID = '$id'
					AND YYYY=$y
				GROUP BY SALES_ID,
					MM,
					YYYY
					ORDER BY MM ASC
				";
		if($type==0)
		return $this->db->query($sql)->result();
		else
		return $this->db->query($sql)->result_array();
	}
	
	#-------------------------------------
	# 	Get Performance per Sales
	#-------------------------------------	
	function get_performance_cab( $m=0, $y=0, $cab, $wil)
	{
		$lvl = array('SLN', 'DIVISI', 'TIM', 'WILAYAH');
		if( in_array($this->session->userdata('USER_LEVEL'),$lvl) ) {
			$where = "WHERE BRANCH = $cab ";
		} 
		if($_SESSION['USER_LEVEL'] == 'CABANG' || $_SESSION['USER_LEVEL'] == 'PIMPINAN_CABANG') {
			$where = "WHERE BRANCH = $cab ";
		}
		
		$sql = "
				SELECT 
					B.YYYY, 
					B.MM, 
					B.SALES_ID, 
					USER_NAME,
					B.BOBOT_ID, 
					B.BOBOT_NAME, 
					A.BOBOT, 
					CASE 
						WHEN ROUND(B.REALISASI) > 200
						THEN 200
						ELSE ROUND(B.REALISASI)
					END REALISASI,
					CASE 
						WHEN ROUND(B.REALISASI) > 200
						THEN ROUND(A.BOBOT * 200 / 100)
						ELSE ROUND(A.BOBOT * REALISASI / 100)
					END REALISASI_TERBOBOT,					
					BOBOT_CAT,
                    BRANCH,
                    BRANCH_NAME,
                    REGION
				FROM 
					BOBOT_VALUE A
					INNER JOIN 
					(
						SELECT 
							A.M MM, 
							A.Y YYYY, 
							A.SALES_ID,
							C.USER_NAME, 
							GETSALESTYPE(A.SALES_ID) SALES_TYPE, 
							(SUM(A.PENCAPAIAN) / decode(SUM(A.TARGET+ A.OUTSTANDING),0,1,SUM(A.TARGET+ A.OUTSTANDING)) * 100) REALISASI,
 
                            B.BOBOT_ID, 
                            getBobotName(B.BOBOT_ID) BOBOT_NAME,
                            C.BRANCH,
                            D.BRANCH_NAME,
                            D.REGION
                        FROM 
                            REALISASI A
                            LEFT JOIN BOBOT_MAP B 
                                ON A.PRODUCT_ID = B.PRODUCT_ID
                            JOIN USER_TST C
                                ON A.SALES_ID = C.ID
                            JOIN BRANCH D
                                ON C.BRANCH = D.BRANCH_CODE
                        WHERE
                            B.BOBOT_ID IS NOT NULL
                            AND A.M = $m
                            AND A.Y = $y
                        GROUP BY
                            A.SALES_ID, 
							C.USER_NAME,
                            B.BOBOT_ID, 
                            B.BOBOT_NAME, 
                            A.M, 
                            A.Y,
                            C.BRANCH,
                            D.BRANCH_NAME,
                            D.REGION
                    ) B 
                        ON A.BOBOT_ID = B.BOBOT_ID 
                        AND A.SALES_TYPE = B.SALES_TYPE 
                        AND A.M = B.MM 
                        AND A.Y = B.YYYY
                    INNER JOIN BOBOT C
                        ON C.ID = A.BOBOT_ID
                    $where
                    ORDER BY SALES_ID,  BOBOT_CAT, BOBOT_NAME
				";
		
		return $this->db->query($sql)->result();
	}
	
	
	function data_monthly_performance($m, $y, $type=0, $wil=0)
	{	
		$npp = $this->session->userdata('ID');
		$lvl = $this->session->userdata('USER_LEVEL');
		$cab = $this->session->userdata('BRANCH_ID');
		
		
		switch($lvl){
			case 'SUPERVISOR':
				$where = " AND B.SPV = '$npp'";
			break;
			case 'CABANG':
				$where = " AND B.BRANCH = $cab";
			break;
			case 'WILAYAH':
				$region = $this->session->userdata('REGION');
				$where = " AND C.REGION = '$region'";
			break;
			case 'PIMPINAN_CABANG':
				$where = " AND B.BRANCH = $cab";
			break;
			case 'PIMPINAN_WILAYAH':
				$region = $this->session->userdata('REGION');
				$where = " AND C.REGION = '$region'";
			break;
			case 'SLN':
				$region = $wil;
				$where = " AND C.REGION = '$region'";
			break;
			case 'TIM':
				$region = $wil;
				$where = " AND C.REGION = '$region'";
			break;
			
		}
		
		$sql="SELECT A.*, B.USER_NAME, E.SALES_TYPE, C.BRANCH_NAME, C.REGION, D.REGION_NAME, D.KODE, B.SPV FROM
				(
					SELECT 
						SALES_ID, 
						MM, 
						YYYY,
						SUM(REALISASI_TERBOBOT) PERFORMANCE
					FROM PERFORMANCE 
					WHERE 
						YYYY = $y
						AND MM = $m
					GROUP BY
						SALES_ID,
						MM,
						YYYY,
						SALES_TYPE
				) A
				JOIN USER_TST B
					ON A.SALES_ID = B.ID
				JOIN BRANCH C
					ON B.BRANCH = C.BRANCH_CODE
				JOIN BRANCH_REGION D
					ON C.REGION = D.REGION_CODE
				JOIN SALES_TYPE E
					ON B.SALES = E.ID
				WHERE 1 = 1 $where
				ORDER BY BRANCH, SPV, PERFORMANCE DESC, REGION, USER_NAME";
		if($type==0)
		return $this->db->query($sql)->result();
		else
		return $this->db->query($sql)->result_array();
	}
	
	#-------------------------------------
	# 	Get Incentive per Sales
	#-------------------------------------
	function get_incentive($id=0, $m=0, $y=0)
	{
		$sql = "
				SELECT 
					PERF.BRANCH_CODE,
					GETBRANCHNAME(PERF.BRANCH_CODE) CABANG,
					ROUND(PERF.BOBOT_PCT)BOBOT_PCT,
					PERF.SALES_ID,
					GETSALESNAME(PERF.SALES_ID) NAMA,
					PERF.YYYY,
					PERF.MM,
					PERF.BOBOT_CAT,
					NVL(C.PCT_INCENTIVE,0) PCT_INCENTIVE,
				CASE 
					WHEN BOBOT_CAT = 1 
					THEN NVL(C.NOMINAL,0)*0.7 
					ELSE NVL(C.NOMINAL,0)*0.3 
				END NOMINAL
				FROM 
				(
					SELECT 
						BRANCH_CODE, 
						SUM(REALISASI_TERBOBOT) BOBOT_PCT, 
						SALES_ID, 
						YYYY, 
						MM, 
						BOBOT_CAT
					FROM 
					(
						SELECT 
							B.BRANCH_CODE, 
							B.YYYY, 
							B.MM, 
							B.SALES_ID, 
							B.BOBOT_ID, 
							B.BOBOT_NAME, 
							A.BOBOT, 
							B.REALISASI, 
							(A.BOBOT * B.REALISASI / 100) REALISASI_TERBOBOT, 
							BOBOT_CAT
						FROM 
							BOBOT_VALUE A
							INNER JOIN 
							(
								SELECT 
									A.BRANCH_CODE, 
									A.M MM, 
									A.Y YYYY, 
									A.SALES_ID, 
									GETSALESTYPE(A.SALES_ID) SALES_TYPE, 
									CASE 
                    					WHEN SUM(A.TARGET) = 0 
                    					THEN 100
                    					ELSE (SUM(A.PENCAPAIAN) / SUM(A.TARGET) * 100)
                    				END REALISASI,
                                    
                                    --(SUM(A.PENCAPAIAN) / SUM(A.TARGET) * 100) REALISASI, 
									 
									B.BOBOT_ID, 
									B.BOBOT_NAME
								FROM 
									REALISASI A
									LEFT JOIN BOBOT_MAP B 
										ON A.PRODUCT_ID = B.PRODUCT_ID
								WHERE
									B.BOBOT_ID IS NOT NULL
									AND A.M = $m
									AND A.Y = $y
									AND A.BRANCH_CODE = '$id'
								GROUP BY
									A.SALES_ID, 
									B.BOBOT_ID, 
									B.BOBOT_NAME, 
									A.M, 
									A.Y, 
									A.BRANCH_CODE
							) B 
								ON A.BOBOT_ID = B.BOBOT_ID 
								AND A.SALES_TYPE = B.SALES_TYPE 
								AND A.M = B.MM 
								AND A.Y = B.YYYY
							INNER JOIN BOBOT C
								ON C.ID = A.BOBOT_ID
					)
					GROUP BY
						SALES_ID, BOBOT_CAT, YYYY, MM, BRANCH_CODE
				) PERF    
				INNER JOIN USER_TST B
					ON PERF.SALES_ID = B.ID
				LEFT JOIN INCENTIVE C
					ON C.GRADE = B.GRADE AND C.PCT_BOBOT = case when ROUND(PERF.BOBOT_PCT) > 129 then 130 else ROUND(PERF.BOBOT_PCT) end
		";
		return $this->db->query($sql)->result();
	}
	
	#-------------------------------------
	# 	Get Cabang
	#-------------------------------------
	function get_cabang()
	{
		$this->db->order_by('BRANCH_NAME','ASC');
		return $this->db->get('BRANCH')->result();
	}
	
	function get_cabang_detail($id)
	{
		$this->db->where('BRANCH_CODE',$id);
		return $this->db->get('BRANCH')->result();
	}
	
	function get_wilayah_detail($id)
	{
		$this->db->where('REGION_CODE',$id);
		return $this->db->get('BRANCH_REGION')->result();
	}
	
	function get_cabang_wil($id)
	{
		$this->db->where('REGION',$id);
		$this->db->order_by('BRANCH_NAME','ASC');
		$result = $this->db->get('BRANCH')->result();
		$data = array();
		$data['0'] = 'ALL';
		foreach($result as $row)
		{
			$data[$row->BRANCH_CODE] = $row->BRANCH_NAME;
		}
		return $data;
	}
	
	function get_wilayah()
	{
		$this->db->where('REGION_CODE <= ',18);
		$this->db->order_by('REGION_CODE','ASC');
		$result = $this->db->get('BRANCH_REGION')->result();
		$data = array();
		#$data['0'] = 'ALL';
		foreach($result as $row)
		{
			$data[$row->REGION_CODE] = $row->REGION_NAME;
		}
		return $data;
	}
	
	function get_tgl_dpk()
	{
		$this->db->select('AS_OF_DATE');
		$this->db->group_by('AS_OF_DATE');
		$this->db->order_by('AS_OF_DATE','DESC');
		return $this->db->get('SALES_EOY_BAL')->result();
	}
	
	#-------------------------------------
	# 	Get Segment Kriteria Bisnis
	#-------------------------------------
	function get_segment()
	{
		$this->db->select("distinct SEGMENT");
		return $this->db->get('CUST_CORP')->result();		
	}
	
	function get_kriteria($id, $cat='')
	{
		$this->db->where('SEGMENT',$cat);
		$this->db->where('SUBSTR((TRIM(BNI_SALES_ID)),-5,5)','$id');
		return $this->db->get('CUST_CORP')->result();
	}
	
	#-------------------------------------
	# 	Get Other Product
	#-------------------------------------
	function get_other($id)
	{
		#$id = $this->session->userdata('ID');
		$sql = "SELECT PRODUCT, COUNT(PRODUCT) JUMLAH FROM 
				(
					SELECT  
						CASE     
							WHEN PR1 IS NULL THEN UPPER(PR2)
							WHEN PR2 IS NULL THEN UPPER(PR1)
							WHEN PR1 = PR2 THEN UPPER(PR1)
						END PRODUCT
					FROM 
						(SELECT OTHER_PRODUCT_CD_1 PR1, BNI_SALES_ID ID1 
							FROM CUST_INDV
							WHERE SUBSTR((TRIM(BNI_SALES_ID)),-5,5) = '$id'
						) A 
					FULL OUTER JOIN 
						(SELECT  OTHER_PRODUCT_CD_2 PR2, BNI_SALES_ID ID2 
							FROM CUST_INDV
							WHERE SUBSTR((TRIM(BNI_SALES_ID)),-5,5) = '$id') B 
					ON A.PR1 = B.PR2 
				) 
				GROUP BY PRODUCT 
				ORDER BY JUMLAH DESC";		
		
		return $this->db->query($sql)->result();		
	}
	
	function get_audit($awal,$akhir)
	{
		$sql = "SELECT * FROM LOG where TO_DATE(TO_DATE(DATE_CREATED,'DD-MON-YYYY HH24:MI:SS'),'DD-MM-YY') BETWEEN TO_DATE('$awal','DD-MM-YY') and TO_DATE('$akhir','DD-MM-YY') ORDER BY DATE_CREATED DESC";		
		
		return $this->db->query($sql)->result();		
	}
	
	function get_nonaktif($wil,$cab)
	{
		IF($wil==0)
		{
		$wlyh="1,2,3,4,5,6,7,8,9,10,11,12,14,15,16";
		}else
		{
		$wlyh=$wil;
		}
		IF($cab==0)
		{
		$cbng="";
		}else
		{
		$cbng="AND A.BRANCH =$cab";
		}
		//$sql = "SELECT A.*,B.BRANCH_NAME FROM USER_TST A JOIN BRANCH B ON A.BRANCH = B.BRANCH_CODE where A.STATUS=0";		
		$sql = "SELECT A.*,B.BRANCH_NAME,B.REGION FROM USER_TST A JOIN BRANCH B ON A.BRANCH = B.BRANCH_CODE 
				where A.STATUS=0
				AND B.REGION in($wlyh) $cbng
				ORDER BY A.ID
				";		
		return $this->db->query($sql)->result();		
	}
	
	function get_nonaktifwil()
	{
		$reg = $this->session->userdata('REGION');
		IF($this->session->userdata('USER_LEVEL')=='WILAYAH')
		{
			$wil="OR B.REGION = $reg";
		}
		$sql = "SELECT A.*,B.BRANCH_NAME FROM USER_TST A JOIN BRANCH B ON A.BRANCH = B.BRANCH_CODE 
				where A.STATUS=0
				AND A.BRANCH='$branch' $wil
				ORDER BY A.ID
				";		
		
		return $this->db->query($sql)->result();		
	}
	
	function get_aktif()
	{
		$sql = "SELECT A.*,B.TIME,C.BRANCH_NAME FROM USER_TST A JOIN ACTIVE_LOG B ON A.ID = B.USER_ID JOIN BRANCH C ON A.BRANCH = C.BRANCH_CODE ORDER BY B.TIME DESC";		
		
		return $this->db->query($sql)->result();		
	}
	
	function get_total_login($wil,$cab,$start,$end)
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
		$reg = $this->session->userdata('REGION');
		IF($wil==0)
		{
		$wlyh="1,2,3,4,5,6,7,8,9,10,11,12,14,15,16";
		}else
		{
		$wlyh=$wil;
		}
		IF($cab==0)
		{
		$cbng="";
		}else
		{
		$cbng="AND B.BRANCH =$cab";
		}
		$q="
			select 
			a.user_id,
			b.user_name,
			b.user_level,
			c.branch_name,
			c.region,
			a.tanggal,
			sum(a.jumlah_login) JUMLAH_LOGIN
			from vw_total_login a
			join user_tst b
			on a.user_id=b.id
			join branch c
			on b.branch=c.branch_code
			where 
			C.REGION in($wlyh) $cbng
			AND TANGGAL >= TO_DATE('$tgl1','MM/DD/YYYY') AND TANGGAL <= TO_DATE('$tgl2','MM/DD/YYYY')
			GROUP BY a.USER_ID,a.TANGGAL,b.user_name,c.branch_name,c.region,b.user_level
			order by user_id,region
			";
			return $this->db->query($q)->result();
	}
	
	function delete_aktif($npp)
	{
		$sql = "DELETE FROM ACTIVE_LOG WHERE USER_ID = '$npp'";
		return $this->db->query($sql)->result();	
	}
	
	function get_wilayah1()
	{
		$qry="select * from branch_region where region_code <=16";
		return $this->db->query($qry)->result();
	}
	
	function get_cabang_json()
	{
		$this->db->from('BRANCH');
		$this->db->order_by('REGION,BRANCH_NAME');
		$qry=$this->db->get();
		
		$result=array();
		foreach($qry->result() as $row)
		{
			$result["CAT_{$row->REGION}"][]=array('value'=>$row->BRANCH_CODE, 'innerHTML'=>$row->BRANCH_NAME);
		}
		return $result;
	}
	
	#-------------------------------------
	# 	Get report daily customer
	#-------------------------------------
	function get_daily_cust($id, $start, $end)
	{
		$start 	= ($start)?date('m/d/Y', strtotime($start)):date('m/d/Y');
		$end	= ($end)?date('m/d/Y', strtotime($end)):date('m/d/Y');
		
		#$id = $this->session->userdata('ID');
		
		$sql = "SELECT 
					CUST_NAME, SUM(ACT1) ACT1, SUM(ACT2) ACT2, 
					SUM(ACT3) ACT3, SUM(ACT4) ACT4, SUM(ACT5) ACT5, 
					SUM(ACT6) ACT6, SUM(ACT7) ACT7, SUM(ACT8) ACT8
				FROM (
				SELECT CUST_NAME,
				CASE
					WHEN ACTIVITY = 1 THEN JML ELSE 0
				END ACT1, 
				CASE
					WHEN ACTIVITY = 2 THEN JML ELSE 0
				END ACT2, 
				CASE
					WHEN ACTIVITY = 3 THEN JML ELSE 0
				END ACT3, 
				CASE
					WHEN ACTIVITY = 4 THEN JML ELSE 0
				END ACT4, 
				CASE
					WHEN ACTIVITY = 5 THEN JML ELSE 0
				END ACT5, 
				CASE
					WHEN ACTIVITY = 6 THEN JML ELSE 0
				END ACT6,
				CASE
					WHEN ACTIVITY = 7 THEN JML ELSE 0
				END ACT7,
				CASE
					WHEN ACTIVITY = 8 THEN JML ELSE 0
				END ACT8  
				
				FROM 
				(SELECT
				CUST_NAME, ACTIVITY, COUNT(ACTIVITY) JML 
				FROM DAILY_ACTIVITY
				WHERE 
					SUBSTR((TRIM(USERID)),-5,5) = '$id' 
					AND START_TIME BETWEEN TO_DATE('$start','MM/DD/YYYY') AND TO_DATE('$end','MM/DD/YYYY')
				GROUP BY ACTIVITY, CUST_NAME)
				) GROUP BY CUST_NAME";		
		
		return $this->db->query($sql)->result();		
	}
	
	
	#---------------------------------------
	# 	Get report daily planning customer
	#---------------------------------------
	function get_planning_cust($id, $start, $end)
	{
		$start 	= ($start)?date('m/d/Y', strtotime($start)):date('m/d/Y');
		$end	= ($end)?date('m/d/Y', strtotime($end)):date('m/d/Y');
		
		#$id = $this->session->userdata('ID');
		$sql = "SELECT CUST_NAME,
					CASE
						WHEN ACTIVITY = 1 THEN START_TIME
					END ACT1, 
					CASE
						WHEN ACTIVITY = 2 THEN START_TIME
					END ACT2, 
					CASE
						WHEN ACTIVITY = 3 THEN START_TIME
					END ACT3, 
					CASE
						WHEN ACTIVITY = 4 THEN START_TIME
					END ACT4, 
					CASE
						WHEN ACTIVITY = 5 THEN START_TIME
					END ACT5, 
					CASE
						WHEN ACTIVITY = 6 THEN START_TIME
					END ACT6,
					CASE
						WHEN ACTIVITY = 7 THEN START_TIME
					END ACT7, 
					CASE
						WHEN ACTIVITY = 8 THEN START_TIME
					END ACT8 					
				FROM (
				SELECT CUST_NAME, START_TIME, ACTIVITY 
				FROM DAILY_ACTIVITY
				WHERE START_TIME BETWEEN TO_DATE('$start','MM/DD/YYYY') AND TO_DATE('$end','MM/DD/YYYY')
				AND SUBSTR((TRIM(USERID)),-5,5) = '$id' 					
				)";		
		
		return $this->db->query($sql)->result();		
	}
	
	#---------------------------------------
	# 	Get report follow up
	#---------------------------------------
	function get_follow_up($npp=0, $start, $end)
	{
		$start 	= ($start)?date('m/d/Y', strtotime($start)):date('m/d/Y');
		$end	= ($end)?date('m/d/Y', strtotime($end)):date('m/d/Y');
		
		$where = '';
		$where .= ($npp == 0)?"":" AND USERID = $npp ";
		#$where .= ($branch == 0)?'':" AND d.BRANCH = $branch ";
				
		$sql = "SELECT a.START_TIME,a.cif_key, a.CUST_NAME, b.ACTIVITY, a.PURPOSE, c.RESPONSE, d.BRANCH
				FROM DAILY_ACTIVITY a
				JOIN ACTIVITY b ON a.ACTIVITY = b.ID
				JOIN RESPONSE c ON a.RESPONSE = c.ID
				JOIN USER_TST d ON a.USERID = d.ID
				WHERE CIF_KEY IS NULL
					AND a.START_TIME BETWEEN TO_DATE('$start','MM/DD/YYYY') AND TO_DATE('$end','MM/DD/YYYY')
					$where
				ORDER BY a.START_TIME DESC";
		return $this->db->query($sql)->result();	
	}
	
	#---------------------------------------
	# 	Get report DAILY CLOSED SALES
	#---------------------------------------
	function get_daily_closed($npp=0, $start, $end)
	{
		$start 	= ($start)?date('m/d/Y', strtotime($start)):date('m/d/Y');
		$end	= ($end)?date('m/d/Y', strtotime($end)):date('m/d/Y');
		
		$where = '';
		$where .= ($npp == 0)?"":" AND USERID = $npp ";
				
		$sql = "SELECT a.CUST_NAME,a.START_TIME, a.DESC1, a.DESC2, b.BRANCH
				FROM DAILY_ACTIVITY a
				JOIN USER_TST b ON a.USERID = b.ID
				WHERE a.ACTIVITY = 6
					AND a.START_TIME BETWEEN TO_DATE('$start','MM/DD/YYYY') AND TO_DATE('$end','MM/DD/YYYY')					
					$where ORDER BY A.START_TIME DESC";
		return $this->db->query($sql)->result();	
	}
	
	#---------------------------------------
	# 	Get REPORT BNI PRODUCT 1
	#---------------------------------------
	function get_bni_product_1($npp=0)
	{
		$where = '';
		$where .= ($npp == 0)?"":" AND a.BNI_SALES_ID = '$npp' ";
				
		$sql = "SELECT a.BNI_PRODUCT_CD_1 PRODUCT, COUNT(a.BNI_PRODUCT_CD_1) JUMLAH
				FROM CUST_INDV a
				JOIN USER_TST b ON a.BNI_SALES_ID = b.ID
				WHERE a.CIF_KEY IS NOT NULL
				$where				
				GROUP BY a.BNI_PRODUCT_CD_1
				ORDER BY a.BNI_PRODUCT_CD_1";
		return $this->db->query($sql)->result();	
	}
	
	#---------------------------------------
	# 	Get Rasio presentasi
	#---------------------------------------
	function get_oportunity($m, $y, $cab, $wil)
	{
		$npp = $this->session->userdata('ID');			
		$lvl = strtoupper($this->session->userdata('USER_LEVEL'));
		#$cab = strtoupper($this->session->userdata('BRANCH_ID'));
		#$wil = strtoupper($this->session->userdata('REGION'));
		$where = '';
		
		switch ($lvl) {
		case 'SUPERVISOR':
			$where = "b.SPV = $npp";
			break;
		case 'CABANG':
			$where = "b.BRANCH = $cab";
			break;
		case 'WILAYAH':
			$where = "b.BRANCH = $cab";
			break;
		case 'PIMPINAN_CABANG':
			$where = "b.BRANCH = $cab";
			break;
		case 'PIMPINAN_WILAYAH':
			$where = "b.BRANCH = $cab";
			break;
		case 'SLN':
			$where = "b.BRANCH = $cab";
			break;
		case 'SALES':
			$where = "a.USERID = $npp";
			break;
		default:			
			$where = "a.USERID <> 0";
		}
		
		$sql="SELECT USERID, USER_NAME, PRESENTASI, TEMU, CLOSED, JMLH, ROUND(NVL((TEMU/JMLH)*100,0)) T,
                    ROUND(NVL((PRESENTASI/JMLH)*100,0)) P ,
                    ROUND(NVL((CLOSED/JMLH)*100,0)) J 
                FROM 
                (
                     SELECT a.USERID, USER_NAME, TEMU, PRESENTASI, CLOSED, JMLH FROM
                    (
                        SELECT USERID, USER_NAME, COUNT(ID) JMLH FROM DAILY_ACTIVITY  a
						LEFT JOIN USER_TST b ON a.USERID = b.ID
						LEFT JOIN BRANCH c ON b.BRANCH = c.BRANCH_CODE
                        WHERE ACTIVITY IN (1,2)                        
                        AND M=$m
                        AND Y=$y
                        AND $where 
                        --b.BRANCH = 70 
                        --c.REGION = 10
                        --a.USERID = '27111'
                        --b.SPV = 23822
                        GROUP BY USERID, USER_NAME
                    ) a
                    LEFT JOIN 
                    
                    (
                        SELECT USERID, COUNT(ID) TEMU FROM DAILY_ACTIVITY 
                        WHERE 
                        ACTIVITY = 3                       
                        AND M=$m
                        AND Y=$y
                        AND REALISATION = 1
                        GROUP BY USERID                        
                    ) b
                    ON a.USERID = b.USERID 
                    LEFT JOIN 
                    (
                        SELECT USERID, COUNT(ID) PRESENTASI FROM DAILY_ACTIVITY 
                        WHERE 
                        ACTIVITY = 5                        
                        AND M=$m
                        AND Y=$y
                        AND REALISATION = 1 
                        GROUP BY USERID                       
                    ) c 
                    ON a.USERID = c.USERID
                    LEFT JOIN                 
                    (
                        SELECT USERID, COUNT(ID) CLOSED FROM DAILY_ACTIVITY 
                        WHERE 
                        ACTIVITY = 6                        
                        AND M=$m
                        AND Y=$y
                        AND REALISATION = 1 
                        GROUP BY USERID                       
                    ) d ON a.USERID = d.USERID                    
               
                ) ORDER BY USERID";
				
			return $this->db->query($sql)->result();
	}
	
	
	function get_kelolaan_year($wil, $cab, $type = 0)
	{
		$where = ($cab==0)?"C.REGION = $wil":"B.BRANCH = $cab";
		
		$sql="SELECT A.*, C.BRANCH_CODE, C.BRANCH_NAME FROM (
				SELECT 
					BNI_SALES_ID NPP,
					AS_OF_DATE TGL,					
					USER_NAME SALES, 
					COUNT(CIF) CIF, 
					SUM(T) T, 
					SUM(G) G, 
					SUM(D) D, 
					SUM(DPK) DPK 
				FROM 
				(
					SELECT 
						BNI_SALES_ID, 
						AS_OF_DATE,
						USER_NAME, 
						(BNI_CIF_KEY) CIF, 
						SUM(TABUNGAN) T, 
						SUM(GIRO) G, 
						SUM(DEPOSITO) D, 
						SUM(DPK) DPK 
					FROM 
						TMP_NASABAH_KELOLAAN
					WHERE 
						LAST_MONTH = 0
					GROUP BY 
						BNI_CIF_KEY, 
						BNI_SALES_ID, 
						USER_NAME,
						AS_OF_DATE
					ORDER 
						BY BNI_SALES_ID
				)
				GROUP BY 
					BNI_SALES_ID, 
					USER_NAME,
					AS_OF_DATE
				ORDER BY 
					BNI_SALES_ID
				) A
				JOIN 
					USER_TST B 
					ON A.NPP = B.ID
				JOIN BRANCH C
					ON B.BRANCH = C.BRANCH_CODE
				WHERE 
					$where
				ORDER BY B.BRANCH	
				";
		if($type==0)
		return $this->db->query($sql)->result();
		else
		return $this->db->query($sql)->result_array();
	}
	
	
	function get_kelolaan_month($date=0, $wil=0, $cab=0)
	{
		$where = array();
		
		if($wil!=0) $where = array('REGION'=>$wil);
		if($cab!=0) $where = array('BRANCH'=>$cab);
		$where['AS_OF_DATE'] = $date;
		if($wil==0) $where =  array('AS_OF_DATE'=>$date);
		
		$this->db->order_by('SALES_TYPE','USER_NAME','SALES_ID');
		$this->db->where($where);
		return $this->db->get('VW_SALES_EOY_BAL')->result_array();			
	}
	
	function get_griya_hunter($id,$month,$year)
	{
		$sql='select (pencapaian/target)*100 Realiasi where sales_id =$id and m = $month and y =$year';
		$this->db->query($sql)->result();
	}
	
	
}

?>