<?php
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class _self_flagging extends Model {
 
 function _self_flagging()
	{
		parent::Model();
		$this->CI =& get_instance();
	}
	
    public $table = 'PRA_FLAGGING';
	public $table_report = 'PRA_FLAGGING_REPORT';
	public $monthnow = 3;
	public $lastmonth = 2;
	public $lastyear=2017;
	public $year=2017;
	public $asofdate='28-FEB-2017';
 
 //==================================
 	    function json() {
        $this->datatables->select('JUDUL');
        $this->datatables->from('news');
        //add this line for join
        //$this->datatables->join('table2', 'sales.field = table2.field');
    //    $this->datatables->add_column('action', anchor(site_url('sales/read/$1'),'Read')." | ".anchor(site_url('sales/update/$1'),'Update')." | ".anchor(site_url('sales/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id');
        return $this->datatables->generate();
    }
	
 //==================================

   
	#cek dulu sebelum masuk menu upload
	function cekupload($npp)
	{
		$sql="select distinct npp from pra_flagging where npp=$npp and status>0";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	#cek dulu sebelum masuk menu upload thp 2
	function ceksales($npp)
	{
		$sql="select distinct npp from user_sales_usulan where npp=$npp";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
    //ini untuk memasukkan kedalam tabel pegawai
    function loaddata($dataarray) {
	$tgl=date('d-M-Y');
		$sid=$_SESSION['ID'];
		$lvl=$_SESSION['USER_LEVEL'];
		/*if($lvl=='SALES')
		{
			$xid=$sid;
			
		}else{
			$xid="$dataarray[$i]['NPP']";
		}*/
        for ($i = 0; $i < count($dataarray); $i++) {
            $data = array(
				'NPP' => $dataarray[$i]['NPP'],
				'CIF_KEY' => $dataarray[$i]['CIF_KEY'],
				'CREATED_DATE' => $tgl,
                'CUST_NAME' => str_replace("'", "",$dataarray[$i]['CUST_NAME'])
            );
            //ini untuk menambahkan apakah dalam tabel sudah ada data yang sama
            //apabila data sudah ada maka data di-skip
            // saya contohkan kalau ada data nama yang sama maka data tidak dimasukkan
            //$this->db->where('CIF_KEY', $this->input->post('CIF_KEY'));            
           // if ($cek) {
                $this->db->insert($this->table, $data);
				 $this->db->insert($this->table_report, $data);
				
           // }
        }
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sid,'$ip','UPLOAD USULAN FLAGGING BY SLN/HLB/WEM',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	
	function loaddatasales($dataarray) {
	$tgl=date('d-M-Y');
		$sid=$_SESSION['ID'];
		$lvl=$_SESSION['USER_LEVEL'];
		$xxx='SEQ_PRA_FLAGGING.nextval';
		/*if($lvl=='SALES')
		{
			$xid=$sid;
			
		}else{
			$xid="$dataarray[$i]['NPP']";
		}*/
        for ($i = 0; $i < count($dataarray); $i++) {
            $data = array(
				'NPP' => $sid,
				'CIF_KEY' => $dataarray[$i]['CIF_KEY'],
				'CREATED_DATE' => $tgl,
                'CUST_NAME' => str_replace("'", "",$dataarray[$i]['CUST_NAME'])
            );
            //ini untuk menambahkan apakah dalam tabel sudah ada data yang sama
            //apabila data sudah ada maka data di-skip
            // saya contohkan kalau ada data nama yang sama maka data tidak dimasukkan
            //$this->db->where('CIF_KEY', $this->input->post('CIF_KEY'));            
           // if ($cek) {
                $this->db->insert($this->table, $data);
				 $this->db->insert($this->table_report, $data);
				
           // }
        }
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sid,'$ip','UPLOAD USULAN FLAGGING',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	
	function get_valid_data($npp)
	{
		$sql ="select * from self_flagging_cek where npp=$npp";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	
	function get_jumlah($npp)
	{
		$lvl=$_SESSION['USER_LEVEL'];
		$salesid=$_SESSION['ID'];
		if($lvl=='SALES')
		{
			$sid=$salesid;
		}
		else
		{
			$sid=$npp;
		}
		$sql="
			select npp,keterangan,sum(jumlah_cif) JUMLAH_CIF from(
			select
			npp,
			CASE
			WHEN KETERANGAN='OK' OR KETERANGAN='DOUBLE' THEN KETERANGAN
			ELSE SUBSTR(keterangan,1,8)
			end as keterangan,
			count(cif_key) jumlah_cif
			from
			self_flagging_cek
			where npp=$sid
			group by npp,keterangan)
			group by npp,keterangan";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	
	function delete($npp)
	{
		$npp_eks=$_SESSION['ID'];
		$sql="delete from pra_flagging where npp=$npp";
		$sqla="delete from pra_flagging_report where npp=$npp";
		$this->db->query($sql);
		$this->db->query($sqla);
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$npp,'$ip','DELETE USULAN',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	
	function kirim_sales($npp)
	{
		#$sqla="DELETE FROM PRA_FLAGGING where cif_key in(select cif_key from self_flagging_cek where npp=$npp and KETERANGAN<>'OK')";
		$sqlb="UPDATE PRA_FLAGGING SET STATUS=0 WHERE NPP = $npp AND STATUS = 1";
		$sqlb1="UPDATE PRA_FLAGGING_REPORT SET STATUS=0 WHERE NPP = $npp and STATUS=1";
		#$this->db->query($sqla);
		$this->db->query($sqlb);
		$this->db->query($sqlb1);
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$npp,'$ip','KIRIM SALES',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	
	function kirim_spv($npp)
	{
		$sales=$_SESSION['SALES_ID'];
		$sqla="DELETE FROM PRA_FLAGGING where cif_key||nomor in(select cif_key||nomor from self_flagging_cek where npp=$npp and KETERANGAN<>'OK')";
		$sqlb="UPDATE PRA_FLAGGING SET STATUS=1 WHERE NPP = $npp";
		$sqlc="UPDATE PRA_FLAGGING SET STATUS=2 WHERE NPP = $npp";
		$sqld="UPDATE PRA_FLAGGING SET STATUS=3 WHERE NPP = $npp";
		$sqla1="DELETE FROM PRA_FLAGGING_REPORT where cif_key||nomor in(select cif_key||nomor from self_flagging_cek where npp=$npp and KETERANGAN<>'OK')";
		$sqlb1="UPDATE PRA_FLAGGING_REPORT SET STATUS=1 WHERE NPP = $npp";
		$sqlc1="UPDATE PRA_FLAGGING_REPORT SET STATUS=2 WHERE NPP = $npp";
		$sqld1="UPDATE PRA_FLAGGING_REPORT SET STATUS=3 WHERE NPP = $npp";
		$this->db->query($sqla);
		switch($sales){
		case 1 :
		case 2 : 
		case 20 : 
		case 21 : 
		case 22 : 
		$this->db->query($sqlc);
		break;
		default:
		$this->db->query($sqlb);
		}
		switch($npp)
		{
			case 20792:
			case 40277:
			case 52331:
			case 24068:
			case 28632:
			case 20561:
			case 18733:
			$this->db->query($sqld);
			break;
		}
		$this->db->query($sqla1);
		switch($sales){
		case 1 :
		case 2 :
		case 20 :
		case 21 :
		case 22 :
		$this->db->query($sqlc1);
		break;
		default:
		$this->db->query($sqlb1);
		}
		switch($npp)
		{
			case 20792:
			case 40277:
			case 52331:
			case 24068:
			case 28632:
			case 20561:
			case 18733:
			$this->db->query($sqld1);
			break;
		}
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$npp,'$ip','KIRIM KE SPV',$npp_eks)
				";
		$this->db->query($track);		
		$this->db->close();
	}
	
	function kirim_bm($npp)
	{
		#$sqla="DELETE FROM PRA_FLAGGING where cif_key in(select cif_key from self_flagging_cek where npp=$npp and KETERANGAN<>'OK')";
		$sqlb="UPDATE PRA_FLAGGING SET STATUS=2 WHERE NPP = $npp and STATUS=1";
		$sqlb1="UPDATE PRA_FLAGGING_REPORT SET STATUS=2 WHERE NPP = $npp and STATUS=1";
		#$this->db->query($sqla);
		$this->db->query($sqlb);
		$this->db->query($sqlb1);
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$npp,'$ip','KIRIM KE BM',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	
	function balik_bm($npp)
	{
		#$sqla="DELETE FROM PRA_FLAGGING where cif_key in(select cif_key from self_flagging_cek where npp=$npp and KETERANGAN<>'OK')";
		$sqlb="UPDATE PRA_FLAGGING SET STATUS=2 WHERE NPP = $npp and STATUS=3";
		$sqlb1="UPDATE PRA_FLAGGING_REPORT SET STATUS=2 WHERE NPP = $npp and STATUS=3";
		#$this->db->query($sqla);
		$this->db->query($sqlb);
		$this->db->query($sqlb1);
		$this->db->close();
	}
	
	function kirim_sln($npp)
	{
		#$sqla="DELETE FROM PRA_FLAGGING where cif_key in(select cif_key from self_flagging_cek where npp=$npp and KETERANGAN<>'OK')";
		$sqlb="UPDATE PRA_FLAGGING SET STATUS=3 WHERE NPP = $npp and STATUS=2";
		$sqlb1="UPDATE PRA_FLAGGING_REPORT SET STATUS=3 WHERE NPP = $npp and STATUS=2";
		#$this->db->query($sqla);
		$this->db->query($sqlb);
		$this->db->query($sqlb1);
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$npp,'$ip','KIRIM KE SLN/HLB/WEM',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	
	function generate_naskel($npp)
	{
		#$sqla="DELETE FROM PRA_FLAGGING where cif_key in(select cif_key from self_flagging_cek where npp=$npp and KETERANGAN<>'OK')";
		$sqlb="UPDATE PRA_FLAGGING SET STATUS=4 WHERE NPP = $npp AND STATUS=3";
		$sqlb1="UPDATE PRA_FLAGGING_REPORT SET STATUS=4 WHERE NPP = $npp AND STATUS=3";
		#$this->db->query($sqla);
		$this->db->query($sqlb);
		$this->db->query($sqlb1);
		$sql1="	insert into cr_flagging
				select 
				NPP sales_id,
				cif_key,
				created_date,
				null,
				cust_name
				 from pra_flagging where npp= $npp and status = 4
				";
		$this->db->query($sql1);
		$sql2="update pra_tmp_baseline set product_id=4 where cust_type='BB' and product_id = 1 and sales_id =$npp";
		$this->db->query($sql2);
		$sql3="update pra_tmp_baseline set product_id=5 where cust_type='BB' and product_id = 2 and sales_id =$npp";
		$this->db->query($sql3);
		$sql4="update pra_tmp_baseline set product_id=6 where cust_type='BB' and product_id = 3 and sales_id =$npp";
		$this->db->query($sql4);
		$sql5="		insert into tmp_baseline_2017
				 select 
				 *
				 from
				 pra_tmp_baseline where sales_id = $npp
				";
		$this->db->query($sql5);	
		$sql6="delete from baseline_2017 where sales_id =$npp";
		$this->db->query($sql6);
		$sql7="
				insert into baseline_2017
				select sales_id,CUST_TYPE,product_id,sum(avg_book_bal) base_avg_bal,baseline_date
				from tmp_baseline_2017
				where sales_id in
				(
					$npp
				)
				group by product_id,sales_id,cust_type,baseline_date 
				order by sales_id
				";
		$this->db->query($sql7);
		$sql8="
				update realisasi set outstanding = 0 where proc_id in(1,2,3,4,5,6) and m>=$this->lastmonth and y=$this->year 
				and sales_id in
				(
				$npp
				)
				";
		$this->db->query($sql8);
		$sql9="
				MERGE INTO REALISASI A
				USING(
				select 
				sales_id,
				product_id,
				sum(base_avg_bal) base_avg_bal
				 from baseline_2017 where sales_id in 
				 (
				   $npp	
					)
				group by sales_id,product_id)b 
				ON (A.PRODUCT_ID = B.PRODUCT_ID AND A.SALES_ID = B.SALES_ID AND A.Y=$this->year AND A.M>=$this->lastmonth)
				WHEN MATCHED THEN UPDATE SET
				A.OUTSTANDING = B.BASE_AVG_BAL
				";
		$this->db->query($sql9);
		$sql10="insert into TMP_BASELINE_AUM
				select
				a.cif_key,
				a.sales_id,
				NVL(SUM(AVG_BOOK_BAL),0) DPK,
				NVL(b.aum_investasi,0) investasi,
				NVL(c.aum_bancas,0) bancas,
				NVL(SUM(AVG_BOOK_BAL),0)+NVL(b.aum_investasi,0)+NVL(c.aum_bancas,0) AUM,
				$this->lastmonth MONTH,
				$this->year YEAR,
				a.CUST_NAME,
				a.BASELINE_DATE
				from
				(select * from tmp_baseline_2017 where cif_key in(select cif_key from pra_flagging where npp=$npp and status = 4)) a
				left join (select * from aum_investasi where m=$this->lastmonth and y=$this->year) b
				on a.cif_key = b.cif_key
				left join (select * from aum_bancas where m=$this->lastmonth and y=$this->year) c
				on a.cif_key = c.cif_key
				where a.cust_type ='CR' and sales_id 
				in
				(
				$npp
				)
				group by
				a.cif_key,
				a.sales_id,
				b.aum_investasi,
				c.aum_bancas,
				a.CUST_NAME,
				a.BASELINE_DATE
				";
		$this->db->query($sql10);
		$sqlb2="DELETE FROM PRA_FLAGGING WHERE NPP = $npp and STATUS=4";
		$this->db->query($sqlb2);
		$sqlb3="DELETE PRA_TMP_BASELINE WHERE BNI_CIF_KEY||SALES_ID IN(SELECT CIF_KEY||NPP FROM PRA_FLAGGING WHERE NPP = $npp and STATUS=4)";
		$this->db->query($sqlb3);
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$npp,'$ip','GENERATE NASKEL',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	
	function get_detail_report($npp)
	{
		$sql="select
                A.baseline_date, 
                a.sales_id,
                e.user_name,
                e.sales_type,
                e.branch_name,
                e.region,
                a.cif_key,
                a.cust_type,
                a.cust_name,
                nvl(a.DPK,0) DPK,
                nvl(c.aum_investasi,0) INVESTASI,
                nvl(d.aum_bancas,0) BANCAS,
                nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
                CASE
                  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
                ELSE 'MASS'
                END AS SEGMENTASI
                 from (
                select 
                a.sales_id,
                b.status,
                a.bni_cif_key cif_key,
                a.cust_type,
                a.cust_name,
                sum(a.avg_book_bal) DPK,
                '$this->asofdate' baseline_date
                from pra_tmp_baseline_report a
                join pra_flagging_report b
                on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
                group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name,b.status)a
                left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
                on a.cif_key = c.cif_key
                left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
                on a.cif_key = d.cif_key
                join (
                select a.id,a.user_name,b.sales,a.grade,c.sales_type,a.spv,b.branch,d.branch_name,d.region from user_tst a
                            join user_sales_usulan b on a.id = b.npp join sales_type c on b.sales = c.id
                            join branch d on b.branch = d.branch_code
                            where a.user_level='SALES' and status = 1
                )e on a.sales_id = e.id
                where a.sales_id||a.status = $npp
                order by sales_id,aum desc";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	
	function get_detail_spv($npp)
	{
		$sql="select
				A.baseline_date, 
				a.sales_id,
				e.user_name,
				e.sales_type,
				e.branch_name,
				e.region,
				a.cif_key,
				a.cust_type,
				a.cust_name,
				nvl(a.DPK,0) DPK,
				nvl(c.aum_investasi,0) INVESTASI,
				nvl(d.aum_bancas,0) BANCAS,
				nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
				CASE
				  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
				ELSE 'MASS'
				END AS SEGMENTASI
				 from (
				select 
				a.sales_id,
				a.bni_cif_key cif_key,
				a.cust_type,
				a.cust_name,
				sum(a.avg_book_bal) DPK,
				'$this->asofdate' baseline_date
				from pra_tmp_baseline a
				join pra_flagging b
				on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
				where b.status = 1
				group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
				left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
				on a.cif_key = c.cif_key
				left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
				on a.cif_key = d.cif_key
				join (
				select a.id,a.user_name,b.sales,a.grade,c.sales_type,a.spv,b.branch,d.branch_name,d.region from user_tst a
							join user_sales_usulan b on a.id = b.npp join sales_type c on b.sales = c.id
							join branch d on b.branch = d.branch_code
							where a.user_level='SALES' and status = 1
				)e on a.sales_id = e.id
				where a.sales_id = $npp
				order by sales_id,aum desc";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	
	function get_sales_flagging()
	{
		$sql="select
				*
				from
				vw_cr_list_sales
				where sales> 0 and sales < 9
				and branch <> '970'
				and id in(select distinct npp from pra_flagging)
				order by id";
		return $this->db->query($sql)->result();
		$this->db->close();		
	}
	

	function get_detail_detail_report()
	{
		$lvl=$_SESSION['USER_LEVEL'];
		$salesid=$_SESSION['ID'];
		$branch=$_SESSION['BRANCH_ID'];
		switch ($lvl){
			case 'SALES':
			$where_spv = "where x.sales_id = '$salesid'";
			break;
			case 'SUPERVISOR':
			$where_spv = "where e.spv = '$salesid'";
			break;
			case 'PEMIMPIN_CABANG':
			$where_spv = "where e.branch = '$branch'";
			break;
			case 'PIMPINAN_CABANG':
			$where_spv = "where e.branch = '$branch'";
			break;
			case 'ADMIN':
			$where_spv = "";
			break;
			case 'SLN':
			$where_spv = "";
			break;
			case 'HLB':
			$where_spv = "";
			break;
			case 'WEM':
			$where_spv = "";
			break;
		}
		
		$sql="
				select x.sales_id,x.status,e.user_name,e.grade,e.sales,e.sales_type,e.spv,e.branch,e.branch_name,e.region,NVL(b.jumlah_cif,0) CR,NVL(c.jumlah_cif,0) BB,NVL(b.jumlah_cif,0)+NVL(c.jumlah_cif,0) JUMLAH_CIF,
                    NVL(b.AUM,0) AUMCR,NVL(c.AUM,0) AUMBB,NVL(b.AUM,0)+NVL(c.AUM,0) AUM,f.PROSES,
                     CASE
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 450000000000 AND NVL(b.jumlah_cif,0) >= 30 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 450000000000 AND NVL(b.jumlah_cif,0) <  30 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  450000000000 AND NVL(b.jumlah_cif,0) >= 30 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  450000000000 AND NVL(b.jumlah_cif,0) <  30 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 250000000000 AND NVL(b.jumlah_cif,0) >= 50 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 250000000000 AND NVL(b.jumlah_cif,0) <  50 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  250000000000 AND NVL(b.jumlah_cif,0) >= 50 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  250000000000 AND NVL(b.jumlah_cif,0) <  50 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(7,8,9) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 150000000000 AND NVL(b.jumlah_cif,0) >= 100 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(7,8,9) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 150000000000 AND NVL(b.jumlah_cif,0) <  100 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(7,8,9) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  150000000000 AND NVL(b.jumlah_cif,0) >= 100 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(7,8,9) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  150000000000 AND NVL(b.jumlah_cif,0) <  100 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR dan BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG dan JUMLAH CIF BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'  
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'                    
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR dan BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG dan JUMLAH CIF BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG' 
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG' 
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'                    
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'
                    END AS KETERANGAN
                      from
                    (
                    select sales_id,status,count(cif_key) jumlah_cif,sum(aum) AUM from
                    (
                            select
                            A.baseline_date, 
                            a.sales_id,
                            a.status,
                            a.cif_key,
                            a.cust_type,
                            a.cust_name,
                            nvl(a.DPK,0) DPK,
                            nvl(c.aum_investasi,0) INVESTASI,
                            nvl(d.aum_bancas,0) BANCAS,
                            nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
                            CASE
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
                            ELSE 'MASS'
                            END AS SEGMENTASI
                             from (
                            select 
                            a.sales_id,
                            b.status,
                            a.bni_cif_key cif_key,
                            a.cust_type,
                            a.cust_name,
                            sum(a.avg_book_bal) DPK,
                            '$this->asofdate' baseline_date
                            from pra_tmp_baseline_report a
                            join pra_flagging_report b
                            on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
                            where b.status>=1
                            group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name,b.status)a
                            left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
                            on a.cif_key = c.cif_key
                            left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
                            on a.cif_key = d.cif_key
                            order by sales_id,status
                    )
                    group by sales_id,status
                    )x
                    left join
                    (
                    select sales_id,status,cust_type,count(cif_key) jumlah_cif,sum(aum) AUM from
                    (
                            select
                            A.baseline_date, 
                            a.sales_id,
                            a.status,
                            a.cif_key,
                            a.cust_type,
                            a.cust_name,
                            nvl(a.DPK,0) DPK,
                            nvl(c.aum_investasi,0) INVESTASI,
                            nvl(d.aum_bancas,0) BANCAS,
                            nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
                            CASE
                              WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
                            ELSE 'MASS'
                            END AS SEGMENTASI
                             from (
                            select 
                            a.sales_id,
                            b.status,
                            a.bni_cif_key cif_key,
                            a.cust_type,
                            a.cust_name,
                            sum(a.avg_book_bal) DPK,
                            '$this->asofdate' baseline_date
                            from pra_tmp_baseline_report a
                            join pra_flagging_report b
                            on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
                            where b.status>=1 and cust_type='CR'
                            group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name,b.status)a
                            left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
                            on a.cif_key = c.cif_key
                            left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
                            on a.cif_key = d.cif_key
                            order by sales_id,status
                    )
                    group by sales_id,cust_type,status)b
                    on x.sales_id = b.sales_id and x.status = b.status
                    left join
                    (
                    select sales_id,status,count(cif_key) jumlah_cif,sum(aum) AUM from
                    (
                            select
                            A.baseline_date, 
                            a.sales_id,
                            a.status,
                            a.cif_key,
                            a.cust_type,
                            a.cust_name,
                            nvl(a.DPK,0) DPK,
                            nvl(c.aum_investasi,0) INVESTASI,
                            nvl(d.aum_bancas,0) BANCAS,
                            nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
                            CASE
                              WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
                            ELSE 'MASS'
                            END AS SEGMENTASI
                             from (
                            select 
                            a.sales_id,
                            b.status,
                            a.bni_cif_key cif_key,
                            a.cust_type,
                            a.cust_name,
                            sum(a.avg_book_bal) DPK,
                            '$this->asofdate' baseline_date
                            from pra_tmp_baseline_report a
                            join pra_flagging_report b
                            on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
                            where b.status>=1 and cust_type = 'BB'
                            group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name,b.status)a
                            left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
                            on a.cif_key = c.cif_key
                            left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
                            on a.cif_key = d.cif_key
                            order by sales_id
                    )
                    group by sales_id,status)c
                    on x.sales_id = c.sales_id and x.status = b.status
                    join (
                            select a.id,a.user_name,b.sales,a.grade,c.sales_type,a.spv,b.branch,d.branch_name,d.region from user_tst a
                            join user_sales_usulan b on a.id = b.npp join sales_type c on b.sales = c.id
                            join branch d on b.branch = d.branch_code
                            where a.user_level='SALES' and status = 1
                        )e on x.sales_id = e.id
                    join 
                    (
                        select
                        distinct
                        npp,
                        status,
                        CASE
                        WHEN STATUS = 1 THEN 'DI SUPERVISOR'
                        WHEN STATUS = 2 THEN 'DI PEMIMPIN/PIMPINAN CABANG'
                        WHEN STATUS = 3 THEN 'DI SLN/HLB/WEM'
                        WHEN STATUS = 4 THEN 'SELESAI'
                        END AS PROSES
                        from
                        pra_flagging_report
                    )f
                    on x.sales_id = f.npp and x.status = f.status
					$where_spv
                    order by sales_id
				";
		return $this->db->query($sql)->result();
		$this->db->close();	
	}
	
	function get_detail_detail_spv()
	{
		$spv=$_SESSION['USER_LEVEL'];
		$spvid=$_SESSION['ID'];
		if($spv=='SUPERVISOR')
		$where_spv = "where e.spv = '$spvid'";
		$sql="
				select x.sales_id,e.user_name,e.grade,e.sales,e.sales_type,e.spv,e.branch,e.branch_name,e.region,NVL(b.jumlah_cif,0) CR,NVL(c.jumlah_cif,0) BB,NVL(b.jumlah_cif,0)+NVL(c.jumlah_cif,0) JUMLAH_CIF,
					NVL(b.AUM,0) AUMCR,NVL(c.AUM,0) AUMBB,NVL(b.AUM,0)+NVL(c.AUM,0) AUM,
					 CASE
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 450000000000 AND NVL(b.jumlah_cif,0) >= 30 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 450000000000 AND NVL(b.jumlah_cif,0) <  30 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  450000000000 AND NVL(b.jumlah_cif,0) >= 30 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  450000000000 AND NVL(b.jumlah_cif,0) <  30 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 250000000000 AND NVL(b.jumlah_cif,0) >= 50 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 250000000000 AND NVL(b.jumlah_cif,0) <  50 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  250000000000 AND NVL(b.jumlah_cif,0) >= 50 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  250000000000 AND NVL(b.jumlah_cif,0) <  50 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 150000000000 AND NVL(b.jumlah_cif,0) >= 100 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 150000000000 AND NVL(b.jumlah_cif,0) <  100 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  150000000000 AND NVL(b.jumlah_cif,0) >= 100 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  150000000000 AND NVL(b.jumlah_cif,0) <  100 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR dan BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG dan JUMLAH CIF BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'  
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'                    
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR dan BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG dan JUMLAH CIF BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG' 
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG' 
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'                    
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'
                    END AS KETERANGAN
					  from
					(
					select sales_id,count(cif_key) jumlah_cif,sum(aum) AUM from
					(
							select
							A.baseline_date, 
							a.sales_id,
							a.cif_key,
							a.cust_type,
							a.cust_name,
							nvl(a.DPK,0) DPK,
							nvl(c.aum_investasi,0) INVESTASI,
							nvl(d.aum_bancas,0) BANCAS,
							nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
							CASE
							  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
							ELSE 'MASS'
							END AS SEGMENTASI
							 from (
							select 
							a.sales_id,
							a.bni_cif_key cif_key,
							a.cust_type,
							a.cust_name,
							sum(a.avg_book_bal) DPK,
							'$this->asofdate' baseline_date
							from pra_tmp_baseline a
							join pra_flagging b
							on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
							where b.status=1
							group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
							left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
							on a.cif_key = c.cif_key
							left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
							on a.cif_key = d.cif_key
							order by sales_id
					)
					group by sales_id
					)x
					left join
					(
					select sales_id,cust_type,count(cif_key) jumlah_cif,sum(aum) AUM from
					(
							select
							A.baseline_date, 
							a.sales_id,
							a.cif_key,
							a.cust_type,
							a.cust_name,
							nvl(a.DPK,0) DPK,
							nvl(c.aum_investasi,0) INVESTASI,
							nvl(d.aum_bancas,0) BANCAS,
							nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
							CASE
							  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
							ELSE 'MASS'
							END AS SEGMENTASI
							 from (
							select 
							a.sales_id,
							a.bni_cif_key cif_key,
							a.cust_type,
							a.cust_name,
							sum(a.avg_book_bal) DPK,
							'$this->asofdate' baseline_date
							from pra_tmp_baseline a
							join pra_flagging b
							on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
							where b.status=1 and cust_type='CR'
							group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
							left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
							on a.cif_key = c.cif_key
							left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
							on a.cif_key = d.cif_key
							order by sales_id
					)
					group by sales_id,cust_type)b
					on x.sales_id = b.sales_id
					left join
					(
					select sales_id,count(cif_key) jumlah_cif,sum(aum) AUM from
					(
							select
							A.baseline_date, 
							a.sales_id,
							a.cif_key,
							a.cust_type,
							a.cust_name,
							nvl(a.DPK,0) DPK,
							nvl(c.aum_investasi,0) INVESTASI,
							nvl(d.aum_bancas,0) BANCAS,
							nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
							CASE
							  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
							ELSE 'MASS'
							END AS SEGMENTASI
							 from (
							select 
							a.sales_id,
							a.bni_cif_key cif_key,
							a.cust_type,
							a.cust_name,
							sum(a.avg_book_bal) DPK,
							'$this->asofdate' baseline_date
							from pra_tmp_baseline a
							join pra_flagging b
							on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
							where b.status=1 and cust_type = 'BB'
							group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
							left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
							on a.cif_key = c.cif_key
							left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
							on a.cif_key = d.cif_key
							order by sales_id
					)
					group by sales_id)c
					on x.sales_id = c.sales_id
					join (
							select a.id,a.user_name,b.sales,a.grade,c.sales_type,a.spv,b.branch,d.branch_name,d.region from user_tst a
							join user_sales_usulan b on a.id = b.npp join sales_type c on b.sales = c.id
							join branch d on b.branch = d.branch_code
							where a.user_level='SALES' and status = 1
						)e on x.sales_id = e.id
						$where_spv
					order by sales_id
				";
		return $this->db->query($sql)->result();
		$this->db->close();	
	}
	
	function detail_bm()
	{
		$lvl=$_SESSION['USER_LEVEL'];
		$cabang=$_SESSION['BRANCH_ID'];
		//if($lvl=='PEMIMPIN_CABANG'||$lvl=='PIMPINAN_CABANG'||$lvl=='PEMIMPIN_KLN-KK')
		$where_cabang = "where e.branch = $cabang";
		$sql="
				select x.sales_id,e.user_name,e.grade,e.sales,e.sales_type,e.spv,e.branch,e.branch_name,e.region,NVL(b.jumlah_cif,0) CR,NVL(c.jumlah_cif,0) BB,NVL(b.jumlah_cif,0)+NVL(c.jumlah_cif,0) JUMLAH_CIF,
					NVL(b.AUM,0) AUMCR,NVL(c.AUM,0) AUMBB,NVL(b.AUM,0)+NVL(c.AUM,0) AUM,
					 CASE
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 450000000000 AND NVL(b.jumlah_cif,0) >= 30 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 450000000000 AND NVL(b.jumlah_cif,0) <  30 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  450000000000 AND NVL(b.jumlah_cif,0) >= 30 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  450000000000 AND NVL(b.jumlah_cif,0) <  30 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 250000000000 AND NVL(b.jumlah_cif,0) >= 50 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 250000000000 AND NVL(b.jumlah_cif,0) <  50 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  250000000000 AND NVL(b.jumlah_cif,0) >= 50 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  250000000000 AND NVL(b.jumlah_cif,0) <  50 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 150000000000 AND NVL(b.jumlah_cif,0) >= 100 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 150000000000 AND NVL(b.jumlah_cif,0) <  100 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  150000000000 AND NVL(b.jumlah_cif,0) >= 100 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  150000000000 AND NVL(b.jumlah_cif,0) <  100 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR dan BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG dan JUMLAH CIF BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'  
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'                    
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR dan BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG dan JUMLAH CIF BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG' 
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG' 
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'                    
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'
                    END AS KETERANGAN
					  from
					(
					select sales_id,count(cif_key) jumlah_cif,sum(aum) AUM from
					(
							select
							A.baseline_date, 
							a.sales_id,
							a.cif_key,
							a.cust_type,
							a.cust_name,
							nvl(a.DPK,0) DPK,
							nvl(c.aum_investasi,0) INVESTASI,
							nvl(d.aum_bancas,0) BANCAS,
							nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
							CASE
							  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
							ELSE 'MASS'
							END AS SEGMENTASI
							 from (
							select 
							a.sales_id,
							a.bni_cif_key cif_key,
							a.cust_type,
							a.cust_name,
							sum(a.avg_book_bal) DPK,
							'$this->asofdate' baseline_date
							from pra_tmp_baseline a
							join pra_flagging b
							on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
							where b.status=2
							group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
							left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
							on a.cif_key = c.cif_key
							left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
							on a.cif_key = d.cif_key
							order by sales_id
					)
					group by sales_id
					)x
					left join
					(
					select sales_id,cust_type,count(cif_key) jumlah_cif,sum(aum) AUM from
					(
							select
							A.baseline_date, 
							a.sales_id,
							a.cif_key,
							a.cust_type,
							a.cust_name,
							nvl(a.DPK,0) DPK,
							nvl(c.aum_investasi,0) INVESTASI,
							nvl(d.aum_bancas,0) BANCAS,
							nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
							CASE
							  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
							ELSE 'MASS'
							END AS SEGMENTASI
							 from (
							select 
							a.sales_id,
							a.bni_cif_key cif_key,
							a.cust_type,
							a.cust_name,
							sum(a.avg_book_bal) DPK,
							'$this->asofdate' baseline_date
							from pra_tmp_baseline a
							join pra_flagging b
							on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
							where b.status=2 and cust_type='CR'
							group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
							left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
							on a.cif_key = c.cif_key
							left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
							on a.cif_key = d.cif_key
							order by sales_id
					)
					group by sales_id,cust_type)b
					on x.sales_id = b.sales_id
					left join
					(
					select sales_id,count(cif_key) jumlah_cif,sum(aum) AUM from
					(
							select
							A.baseline_date, 
							a.sales_id,
							a.cif_key,
							a.cust_type,
							a.cust_name,
							nvl(a.DPK,0) DPK,
							nvl(c.aum_investasi,0) INVESTASI,
							nvl(d.aum_bancas,0) BANCAS,
							nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
							CASE
							  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
							ELSE 'MASS'
							END AS SEGMENTASI
							 from (
							select 
							a.sales_id,
							a.bni_cif_key cif_key,
							a.cust_type,
							a.cust_name,
							sum(a.avg_book_bal) DPK,
							'$this->asofdate' baseline_date
							from pra_tmp_baseline a
							join pra_flagging b
							on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
							where b.status=2 and cust_type = 'BB'
							group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
							left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
							on a.cif_key = c.cif_key
							left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
							on a.cif_key = d.cif_key
							order by sales_id
					)
					group by sales_id)c
					on x.sales_id = c.sales_id
					join (
						select a.id,a.user_name,b.sales,a.grade,c.sales_type,a.spv,b.branch,d.branch_name,d.region from user_tst a
							join user_sales_usulan b on a.id = b.npp join sales_type c on b.sales = c.id
							join branch d on b.branch = d.branch_code
							where a.user_level='SALES' and status = 1
						)e on x.sales_id = e.id
						$where_cabang
					order by sales_id
				";
		return $this->db->query($sql)->result();
		$this->db->close();	
	}
	function get_detail_bm($npp)
	{
		$sql="select
				A.baseline_date, 
				a.sales_id,
				e.sales,
				a.cif_key,
				a.cust_type,
				a.cust_name,
				nvl(a.DPK,0) DPK,
				nvl(c.aum_investasi,0) INVESTASI,
				nvl(d.aum_bancas,0) BANCAS,
				nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
				CASE
				  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
				ELSE 'MASS'
				END AS SEGMENTASI
				 from (
				select 
				a.sales_id,
				a.bni_cif_key cif_key,
				a.cust_type,
				a.cust_name,
				sum(a.avg_book_bal) DPK,
				'$this->asofdate' baseline_date
				from pra_tmp_baseline a
				join pra_flagging b
				on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
				where b.status = 2
				group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
				left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
				on a.cif_key = c.cif_key
				left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
				on a.cif_key = d.cif_key
				join user_sales_usulan e
				on a.sales_id =  e.npp
				where sales_id=$npp
				order by sales_id,aum desc";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	function detail_sln()
	{
		$lvl=$_SESSION['USER_LEVEL'];
		switch($lvl)
		{
			case 'SLN':
			$sales ='where e.sales in(1,2,3,4,5,6,7,8,20,21,22,23,24,25)';
			break;
			case 'HLB':
			$sales ='where e.sales in(7,8)';
			break;
			case 'WEM':
			$sales ='where e.sales in(1,2,20,21,22)';
			break;
		}
		$sql="
				select x.sales_id,e.user_name,e.grade,e.sales,e.sales_type,e.spv,e.branch,e.branch_name,e.region,NVL(b.jumlah_cif,0) CR,NVL(c.jumlah_cif,0) BB,NVL(b.jumlah_cif,0)+NVL(c.jumlah_cif,0) JUMLAH_CIF,
					NVL(b.AUM,0) AUMCR,NVL(c.AUM,0) AUMBB,NVL(b.AUM,0)+NVL(c.AUM,0) AUM,
					 CASE
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 450000000000 AND NVL(b.jumlah_cif,0) >= 30 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 450000000000 AND NVL(b.jumlah_cif,0) <  30 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  450000000000 AND NVL(b.jumlah_cif,0) >= 30 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(12,13) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  450000000000 AND NVL(b.jumlah_cif,0) <  30 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 250000000000 AND NVL(b.jumlah_cif,0) >= 50 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 250000000000 AND NVL(b.jumlah_cif,0) <  50 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  250000000000 AND NVL(b.jumlah_cif,0) >= 50 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN(10,11) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  250000000000 AND NVL(b.jumlah_cif,0) <  50 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 150000000000 AND NVL(b.jumlah_cif,0) >= 100 THEN 'NASKEL AUM,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 150000000000 AND NVL(b.jumlah_cif,0) <  100 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  150000000000 AND NVL(b.jumlah_cif,0) >= 100 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK'
                    WHEN SALES IN(1,2) AND GRADE IN( 9,10) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  150000000000 AND NVL(b.jumlah_cif,0) <  100 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR dan BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG dan JUMLAH CIF BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'  
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB OK'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'                    
                    WHEN SALES IN(3,4) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  30000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR dan BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM,JUMLAH CIF CR KURANG dan JUMLAH CIF BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG' 
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) >= 15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM OK,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG' 
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB OK'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) >= 150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR OK dan JUMLAH CIF BB KURANG'
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) >= 15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'                    
                    WHEN SALES IN(5) AND NVL(b.AUM,0)+NVL(c.AUM,0) <  15000000000 AND NVL(b.jumlah_cif,0) <  150 AND NVL(c.jumlah_cif,0) <  15 THEN 'NASKEL AUM KURANG,JUMLAH CIF CR KURANG dan JUMLAH CIF BB KURANG'
                    END AS KETERANGAN
					  from
					(
					select sales_id,count(cif_key) jumlah_cif,sum(aum) AUM from
					(
							select
							A.baseline_date, 
							a.sales_id,
							a.cif_key,
							a.cust_type,
							a.cust_name,
							nvl(a.DPK,0) DPK,
							nvl(c.aum_investasi,0) INVESTASI,
							nvl(d.aum_bancas,0) BANCAS,
							nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
							CASE
							  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
							ELSE 'MASS'
							END AS SEGMENTASI
							 from (
							select 
							a.sales_id,
							a.bni_cif_key cif_key,
							a.cust_type,
							a.cust_name,
							sum(a.avg_book_bal) DPK,
							'$this->asofdate' baseline_date
							from pra_tmp_baseline a
							join pra_flagging b
							on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
							where b.status=3
							group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
							left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
							on a.cif_key = c.cif_key
							left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
							on a.cif_key = d.cif_key
							order by sales_id
					)
					group by sales_id
					)x
					left join
					(
					select sales_id,cust_type,count(cif_key) jumlah_cif,sum(aum) AUM from
					(
							select
							A.baseline_date, 
							a.sales_id,
							a.cif_key,
							a.cust_type,
							a.cust_name,
							nvl(a.DPK,0) DPK,
							nvl(c.aum_investasi,0) INVESTASI,
							nvl(d.aum_bancas,0) BANCAS,
							nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
							CASE
							  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
							ELSE 'MASS'
							END AS SEGMENTASI
							 from (
							select 
							a.sales_id,
							a.bni_cif_key cif_key,
							a.cust_type,
							a.cust_name,
							sum(a.avg_book_bal) DPK,
							'$this->asofdate' baseline_date
							from pra_tmp_baseline a
							join pra_flagging b
							on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
							where b.status=3 and cust_type='CR'
							group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
							left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
							on a.cif_key = c.cif_key
							left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
							on a.cif_key = d.cif_key
							order by sales_id
					)
					group by sales_id,cust_type)b
					on x.sales_id = b.sales_id
					left join
					(
					select sales_id,count(cif_key) jumlah_cif,sum(aum) AUM from
					(
							select
							A.baseline_date, 
							a.sales_id,
							a.cif_key,
							a.cust_type,
							a.cust_name,
							nvl(a.DPK,0) DPK,
							nvl(c.aum_investasi,0) INVESTASI,
							nvl(d.aum_bancas,0) BANCAS,
							nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
							CASE
							  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
							ELSE 'MASS'
							END AS SEGMENTASI
							 from (
							select 
							a.sales_id,
							a.bni_cif_key cif_key,
							a.cust_type,
							a.cust_name,
							sum(a.avg_book_bal) DPK,
							'$this->asofdate' baseline_date
							from pra_tmp_baseline a
							join pra_flagging b
							on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
							where b.status=3 and cust_type = 'BB'
							group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
							left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
							on a.cif_key = c.cif_key
							left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
							on a.cif_key = d.cif_key
							order by sales_id
					)
					group by sales_id)c
					on x.sales_id = c.sales_id
					join (select a.id,a.user_name,b.sales,a.grade,c.sales_type,a.spv,b.branch,d.branch_name,d.region from user_tst a
							join user_sales_usulan b on a.id = b.npp join sales_type c on b.sales = c.id
							join branch d on b.branch = d.branch_code
							where a.user_level='SALES' and status = 1
						)e on x.sales_id = e.id
						$sales
					order by sales_id
				";
		return $this->db->query($sql)->result();
		$this->db->close();	
	}
	function get_detail_sln($npp)
	{
		$sql="select
				A.baseline_date, 
				a.sales_id,
				a.cif_key,
				a.cust_type,
				a.cust_name,
				nvl(a.DPK,0) DPK,
				nvl(c.aum_investasi,0) INVESTASI,
				nvl(d.aum_bancas,0) BANCAS,
				nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) AUM,
				CASE
				  WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) >=15000000000 THEN 'PRIVATE BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 5000000000 and 14999999999 THEN 'PRIORITY BANKING'
							WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 500000000 and 4999999999 THEN 'PERSONAL BANKING'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 100000000 and 499999999 THEN 'AFFLUENT'
                            WHEN nvl(a.DPK,0)+nvl(c.aum_investasi,0)+nvl(d.aum_bancas,0) between 10000000 and 99999999 THEN 'UPPERMASS'
				ELSE 'MASS'
				END AS SEGMENTASI
				 from (
				select 
				a.sales_id,
				a.bni_cif_key cif_key,
				a.cust_type,
				a.cust_name,
				sum(a.avg_book_bal) DPK,
				'$this->asofdate' baseline_date
				from pra_tmp_baseline a
				join pra_flagging b
				on a.bni_cif_key||a.sales_id = b.cif_key||b.npp
				where b.status = 3
				group by a.sales_id,a.bni_cif_key,a.cust_type,a.cust_name)a
				left join (select cif_key,aum_investasi from aum_investasi where m=$this->lastmonth and y=$this->year)c
				on a.cif_key = c.cif_key
				left join (select cif_key,aum_bancas from aum_bancas where m=$this->lastmonth and y=$this->year)d
				on a.cif_key = d.cif_key
				where sales_id=$npp
				order by sales_id,aum desc";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	function kirim_detail_bm($npp,$val)
	{
		$sqla="UPDATE PRA_FLAGGING SET STATUS=2 WHERE NPP = $npp and CIF_KEY in($val)";
		$sqlb="UPDATE PRA_FLAGGING_REPORT SET STATUS=2 WHERE NPP = $npp and CIF_KEY in($val)";
		$this->db->query($sqla);
		$this->db->query($sqlb);
		$this->db->close();
	}
	function kirim_detail_sln($npp,$val)
	{
		$sqla="UPDATE PRA_FLAGGING SET STATUS=3 WHERE NPP = $npp and CIF_KEY in($val)";
		$sqlb="UPDATE PRA_FLAGGING_REPORT SET STATUS=3 WHERE NPP = $npp and CIF_KEY in($val)";
		$this->db->query($sqla);
		$this->db->query($sqlb);
		$this->db->close();
	}
	function generate_naskel_detail($npp,$val)
	{
		#$sqla="DELETE FROM PRA_FLAGGING where cif_key in(select cif_key from self_flagging_cek where npp=$npp and KETERANGAN<>'OK')";
		$sqla="UPDATE PRA_FLAGGING SET STATUS=4 WHERE NPP = $npp and CIF_KEY in($val)";
		$sqlb1="UPDATE PRA_FLAGGING_REPORT SET STATUS=4 WHERE NPP = $npp and CIF_KEY in($val)";
		$this->db->query($sqla);
		$this->db->query($sqlb1);
		$sql1="	insert into cr_flagging
				select 
				NPP sales_id,
				cif_key,
				created_date,
				null,
				cust_name
				 from pra_flagging where npp= $npp and CIF_KEY in($val)
				";
		$this->db->query($sql1);
		$sql2="update pra_tmp_baseline set product_id=4 where cust_type='BB' and product_id = 1 and sales_id =$npp and BNI_CIF_KEY in($val)";
		$this->db->query($sql2);
		$sql3="update pra_tmp_baseline set product_id=5 where cust_type='BB' and product_id = 2 and sales_id =$npp and BNI_CIF_KEY in($val)";
		$this->db->query($sql3);
		$sql4="update pra_tmp_baseline set product_id=6 where cust_type='BB' and product_id = 3 and sales_id =$npp and BNI_CIF_KEY in($val)";
		$this->db->query($sql4);
		$sql5="		insert into tmp_baseline_2017
				 select 
				 *
				 from
				 pra_tmp_baseline where sales_id = $npp and BNI_CIF_KEY in($val)
				";
		$this->db->query($sql5);	
		$sql6="delete from baseline_2017 where sales_id =$npp";
		$this->db->query($sql6);
		$sql7="
				insert into baseline_2017
				select sales_id,CUST_TYPE,product_id,sum(avg_book_bal) base_avg_bal,baseline_date
				from tmp_baseline_2017
				where sales_id in
				(
					$npp
				)
				group by product_id,sales_id,cust_type,baseline_date 
				order by sales_id
				";
		$this->db->query($sql7);
		$sql8="
				update realisasi set outstanding = 0 where proc_id in(1,2,3,4,5,6) and m>=$this->monthnow and y=$this->year 
				and sales_id in
				(
				$npp
				)
				";
		$this->db->query($sql8);
		$sql9="
				MERGE INTO REALISASI A
				USING(
				select 
				sales_id,
				product_id,
				sum(base_avg_bal) base_avg_bal
				 from baseline_2017 where sales_id in 
				 (
				   $npp	
					)
				group by sales_id,product_id)b 
				ON (A.PRODUCT_ID = B.PRODUCT_ID AND A.SALES_ID = B.SALES_ID AND A.Y=$this->year AND A.M>=$this->monthnow)
				WHEN MATCHED THEN UPDATE SET
				A.OUTSTANDING = B.BASE_AVG_BAL
				";
		$this->db->query($sql9);
		$sql10="insert into TMP_BASELINE_AUM
				select
				a.cif_key,
				a.sales_id,
				NVL(SUM(AVG_BOOK_BAL),0) DPK,
				NVL(b.aum_investasi,0) investasi,
				NVL(c.aum_bancas,0) bancas,
				NVL(SUM(AVG_BOOK_BAL),0)+NVL(b.aum_investasi,0)+NVL(c.aum_bancas,0) AUM,
				$this->lastmonth MONTH,
				$this->year YEAR,
				a.CUST_NAME,
				a.BASELINE_DATE
				from
				(select * from tmp_baseline_2017 where cif_key in(select cif_key from pra_flagging where npp=$npp)) a
				left join (select * from aum_investasi where m=$this->lastmonth and y=$this->year) b
				on a.cif_key = b.cif_key
				left join (select * from aum_bancas where m=$this->lastmonth and y=$this->year) c
				on a.cif_key = c.cif_key
				where a.cust_type ='CR' and sales_id 
				in
				(
				$npp
				)and a.CIF_KEY in($val)
				group by
				a.cif_key,
				a.sales_id,
				b.aum_investasi,
				c.aum_bancas,
				a.CUST_NAME,
				a.BASELINE_DATE
				";
		$this->db->query($sql10);
		$sqlb2="DELETE FROM PRA_FLAGGING WHERE NPP = $npp and CIF_KEY in($val)";
		$this->db->query($sqlb2);
		$sqlb3="DELETE FROM pra_tmp_baseline WHERE SALES_ID = $npp and BNI_CIF_KEY in($val)";
		$this->db->query($sqlb3);
		$this->db->close();
	}
	function generate_naskel_detail_lama($npp,$val)
	{
		#$sqla="DELETE FROM PRA_FLAGGING where cif_key in(select cif_key from self_flagging_cek where npp=$npp and KETERANGAN<>'OK')";
		$sqla="UPDATE USULAN_FLAGGING SET STATUS_APP=4 WHERE SALES_ID = $npp and CIF_KEY in($val)";
		$this->db->query($sqla);
		$sqla1="UPDATE CR_FLAGGING SET SALES_ID = $npp where CIF_KEY in(select cif_key from usulan_flagging where cif_key in($val) and jenis_tambahan=1 and sales_id=$npp and UPPER(status) like '%DIKELOLA%')";
		$this->db->query($sqla1);
		$sqla2="insert into tmp_baseline_2017
				select 
				sales_id,
				cif_key,
				cust_type,
				cust_name,
				id_number,
				product_id,
				-bni_cur_book_bal_idr,
				-avg_book_bal,
				'$this->asofdate' baseline_date,
				'$this->asofdate' baseline_date2
				from
				tmp_baseline_2017 where cif_key
				in
				(
					select cif_key from usulan_flagging where cif_key in($val) and jenis_tambahan=1 and sales_id=$npp and UPPER(status) like '%DIKELOLA%'
				)";
		$this->db->query($sqla2);
		$sqla3="UPDATE tmp_baseline_2017 set SALES_ID=$npp where avg_book_bal >=0 and cif_key in(select cif_key from usulan_flagging where cif_key in($val) and jenis_tambahan=1 and sales_id=$npp and UPPER(status) like '%DIKELOLA%')";
		$this->db->query($sqla3);
		$sqla4="UPDATE tmp_baseline_aum set SALES_ID=$npp where cif_key in(select cif_key from usulan_flagging where cif_key in($val) and jenis_tambahan=1 and sales_id=$npp and UPPER(status) like '%DIKELOLA%')";
		$this->db->query($sqla3);
		$sql1="	insert into cr_flagging
				select 
				sales_id,
				cif_key,
				created_date,
				null,
				cust_name
				 from USULAN_FLAGGING where sales_id= $npp and CIF_KEY in($val) and UPPER(status) not like '%DIKELOLA%'
				";
		$this->db->query($sql1);
		$sql2="update usulan_tmp_baseline set product_id=4 where cust_type='BB' and product_id = 1 and sales_id =$npp and BNI_CIF_KEY in($val)";
		$this->db->query($sql2);
		$sql3="update usulan_tmp_baseline set product_id=5 where cust_type='BB' and product_id = 2 and sales_id =$npp and BNI_CIF_KEY in($val)";
		$this->db->query($sql3);
		$sql4="update usulan_tmp_baseline set product_id=6 where cust_type='BB' and product_id = 3 and sales_id =$npp and BNI_CIF_KEY in($val)";
		$this->db->query($sql4);
		$sql5="		insert into tmp_baseline_2017
				 select 
				 *
				 from
				 usulan_tmp_baseline where sales_id = $npp and BNI_CIF_KEY in($val)
				";
		$this->db->query($sql5);	
		$sql6="delete from baseline_2017 where sales_id =$npp";
		$this->db->query($sql6);
		$sql7="
				insert into baseline_2017
				select sales_id,CUST_TYPE,product_id,sum(avg_book_bal) base_avg_bal,baseline_date
				from tmp_baseline_2017
				where sales_id in
				(
					$npp
				)
				group by product_id,sales_id,cust_type,baseline_date 
				order by sales_id
				";
		$this->db->query($sql7);
		$sql8="
				update realisasi set outstanding = 0 where proc_id in(1,2,3,4,5,6) and m>=$this->monthnow and y=$this->year 
				and sales_id in
				(
				$npp
				)
				";
		$this->db->query($sql8);
		$sql9="
				MERGE INTO REALISASI A
				USING(
				select 
				sales_id,
				product_id,
				sum(base_avg_bal) base_avg_bal
				 from baseline_2017 where sales_id in 
				 (
				   $npp	
					)
				group by sales_id,product_id)b 
				ON (A.PRODUCT_ID = B.PRODUCT_ID AND A.SALES_ID = B.SALES_ID AND A.Y=$this->year AND A.M>=$this->monthnow)
				WHEN MATCHED THEN UPDATE SET
				A.OUTSTANDING = B.BASE_AVG_BAL
				";
		$this->db->query($sql9);
		$sql10="insert into TMP_BASELINE_AUM
				select
				a.cif_key,
				a.sales_id,
				NVL(SUM(AVG_BOOK_BAL),0) DPK,
				NVL(b.aum_investasi,0) investasi,
				NVL(c.aum_bancas,0) bancas,
				NVL(SUM(AVG_BOOK_BAL),0)+NVL(b.aum_investasi,0)+NVL(c.aum_bancas,0) AUM,
				$this->lastmonth MONTH,
				$this->year YEAR,
				a.CUST_NAME,
				a.BASELINE_DATE
				from
				(select * from tmp_baseline_2017 where cif_key in(select cif_key from usulan_flagging where sales_id=$npp and UPPER(status) not like '%DIKELOLA%')) a
				left join (select * from aum_investasi where m=$this->lastmonth and y=$this->year) b
				on a.cif_key = b.cif_key
				left join (select * from aum_bancas where m=$this->lastmonth and y=$this->year) c
				on a.cif_key = c.cif_key
				where a.cust_type ='CR' and sales_id 
				in
				(
				$npp
				)and a.CIF_KEY in($val)
				group by
				a.cif_key,
				a.sales_id,
				b.aum_investasi,
				c.aum_bancas,
				a.CUST_NAME,
				a.BASELINE_DATE
				";
		$this->db->query($sql10);
		#$sqlb2="DELETE FROM PRA_FLAGGING WHERE NPP = $npp and CIF_KEY in($val)";
		#$this->db->query($sqlb2);
		#$sqlb3="DELETE FROM pra_tmp_baseline WHERE SALES_ID = $npp and BNI_CIF_KEY in($val)";
		#$this->db->query($sqlb3);
		$this->db->close();
	}
	function kirim_cek_ajax($ID, $SALES_ID)
	{
		$this->db->where('CIF_KEY', $ID);
		$this->db->where('NPP', $SALES_ID);
		$this->db->set('STATUS', 0);
		return $this->db->update('PRA_FLAGGING');
	}
	function kirim_sales_ajax($ID, $SALES_ID ,$SALES_TYPE)
	{
		$this->db->where('CIF_KEY', $ID);
		$this->db->where('NPP', $SALES_ID);
		switch($SALES_TYPE){
		case 1:
		case 2:
		$this->db->set('STATUS', 0);
		break;
		default:
		$this->db->set('STATUS', 1);
		}
		$this->db->update('PRA_FLAGGING_REPORT');
		$this->db->where('CIF_KEY', $ID);
		$this->db->where('NPP', $SALES_ID);
		switch($SALES_TYPE){
		case 1:
		case 2:
		$this->db->set('STATUS', 0);
		break;
		default:
		$this->db->set('STATUS', 1);
		}
		return $this->db->update('PRA_FLAGGING');
	}
	function kirim_spv_ajax($ID, $SALES_ID)
	{
		$this->db->where('CIF_KEY', $ID);
		$this->db->where('NPP', $SALES_ID);
		$this->db->set('STATUS', 2);
		$this->db->update('PRA_FLAGGING_REPORT');
		$this->db->where('CIF_KEY', $ID);
		$this->db->where('NPP', $SALES_ID);
		$this->db->set('STATUS', 2);
		return $this->db->update('PRA_FLAGGING');
	}
	function kirim_bm_ajax($ID, $SALES_ID)
	{
		$this->db->where('CIF_KEY', $ID);
		$this->db->where('NPP', $SALES_ID);
		$this->db->set('STATUS', 3);
		$this->db->update('PRA_FLAGGING_REPORT');
		$this->db->where('CIF_KEY', $ID);
		$this->db->where('NPP', $SALES_ID);
		$this->db->set('STATUS', 3);
		return $this->db->update('PRA_FLAGGING');
	}
	function get_salestype()
	{
		$sql ="select ID,UPPER(SALES_TYPE) SALES_TYPE from sales_type
				where id <=8
				order by id";
		return $this->db->query($sql)->result();
	}
	function insert_sales_ajax($NPP, $SALES_ID , $BRANCH_ID , $KLN_ID)
	{
		$sql = "INSERT INTO USER_SALES_USULAN (NPP,SALES,BRANCH,OUTLET,CREATED_DATE) 
				VALUES ('$NPP','$SALES_ID','$BRANCH_ID','$KLN_ID',SYSDATE)
			   ";
		return $this->db->query($sql);
	}
	function unflag_naskel($npp)
	{
		$qa="delete from target where year=$this->year and sales_id =$npp";
		$qb="delete from realisasi where m>=$this->monthnow and y=$this->year  and sales_id=$npp";
		$qc="delete from performance where mm>=$this->monthnow and yyyy>=$this->year and sales_id=$npp";
        $qd="delete from cr_flagging where sales_id=$npp";
        $qe="delete from tmp_baseline_$this->year where sales_id=$npp";
		$qf="delete from baseline_$this->year where sales_id=$npp";
		$qg="delete from customer_individu where bni_sales_id=$npp";
		$qh="delete from tmp_nasabah_kelolaan where last_month = 0  and bni_sales_id=$npp";
		$qi="delete from tmp_baseline_aum where sales_id=$npp";
		$qj="delete from tmp_posisi_aum where month >=$this->monthnow and year = $this->year and sales_id=$npp";
		$qk="delete from flagging_status where substr(id,-5,5)='$npp'";
		$this->db->query($qa);
		$this->db->query($qb);
		$this->db->query($qc);
		$this->db->query($qd);
		$this->db->query($qe);
		$this->db->query($qf);
		$this->db->query($qg);
		$this->db->query($qh);
		$this->db->query($qi);
		$this->db->query($qj);
		$this->db->query($qk);
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$npp,'$ip','UNFLAG ALL',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function unflag_naskel_eceran($data)
	{
		$cif=$data['cif'];
		$qa="delete from cr_flagging where cif_key in($cif)";
		$qb="insert into tmp_baseline_2017
				select 
				sales_id,
				cif_key,
				cust_type,
				cust_name,
				id_number,
				product_id,
				-bni_cur_book_bal_idr,
				-avg_book_bal,
				'$this->asofdate' baseline_date,
				'$this->asofdate' baseline_date2
				from
				tmp_baseline_2017 where cif_key
				in
				(
					$cif
				)";
		$qb2="delete from tmp_baseline_aum where cif_key in($cif)";
		$qc="drop table npp_unflag";
        $qd="create table npp_unflag as
				select 
				distinct
				sales_id
				from
				tmp_baseline_2017 where cif_key
				in
				(
					$cif
				)";
        $qe="merge into realisasi a using(
				select 
				sales_id,
				25 product_id,
				round(sum(aum),0) AUM,
				$this->monthnow m,
				$this->year y
				from tmp_baseline_aum
				where
				sales_id 
				in
				(
				select * from npp_unflag
				)
				group by sales_id)b
				on(a.sales_id = b.sales_id and a.product_id = b.product_id and a.m >=$this->monthnow and a.y = b.y)
				when matched then update set
				a.target = b.aum";
			$qf="delete from baseline_2017 where sales_id in(select * from npp_unflag)";
			$qg="insert into baseline_2017
					select sales_id,CUST_TYPE,product_id,sum(avg_book_bal) base_avg_bal,baseline_date2
				from tmp_baseline_2017
				where sales_id in
				(
					select * from npp_unflag
				)
				group by product_id,sales_id,cust_type,baseline_date2
				order by sales_id";
		$qh="update realisasi set outstanding = 0 where proc_id in(1,2,3,4,5,6) and m>=$this->monthnow and y=$this->year and sales_id in(select * from npp_unflag)";
		$qi="MERGE INTO REALISASI A
				USING(
				select 
				sales_id,
				product_id,
				sum(base_avg_bal) base_avg_bal
				 from baseline_2017 where sales_id in(select * from npp_unflag)
				group by sales_id,product_id)b 
				ON (A.PRODUCT_ID = B.PRODUCT_ID AND A.SALES_ID = B.SALES_ID AND A.Y=$this->year AND A.M>=$this->monthnow)
				WHEN MATCHED THEN UPDATE SET
				A.OUTSTANDING = B.BASE_AVG_BAL";
		$this->db->query($qa);
		$this->db->query($qb);
		$this->db->query($qb2);
		$this->db->query($qc);
		$this->db->query($qd);
		$this->db->query($qe);
		$this->db->query($qf);
		$this->db->query($qg);
		$this->db->query($qh);
		$this->db->query($qi);
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$npp_eks,'$ip','UNFLAG BY CIF',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function reject_naskel($data)
	{
		$npp=$data['npp'];
		$qa="update pra_flagging set status=0 where npp in($npp)";
		$qb="update pra_flagging_report set status=0 where npp in($npp)";
		$this->db->query($qa);
		$this->db->query($qb);
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$npp_eks,'$ip','REJECT SUPER',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function get_naskel($npp)
	{
		$sql="select sales_id,count(cif_key) jumlah from cr_flagging where sales_id = $npp
			  group by sales_id";
		return $this->db->query($sql)->result();
		$this->db->close();	
	}
	function get_naskel_detail($npp)
	{
		$sql="SELECT A.SALES_ID,A.CIF_KEY,B.CUST_TYPE,A.CUST_NAME FROM CR_FLAGGING A 
                JOIN (SELECT DISTINCT CIF_KEY,CUST_TYPE FROM TMP_BASELINE_2016 WHERE SALES_ID = $npp) B
				ON A.CIF_KEY = B.CIF_KEY
				WHERE A.SALES_ID=$npp ORDER BY B.CUST_TYPE,A.CUST_NAME";
		return $this->db->query($sql)->result();
		$this->db->close();	
	}
	function log_spv_ajax($sales_id)
	{
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sales_id,'$ip','KIRIM KE PEMIMPIN/PIMPINAN CABANG',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function log_bm_ajax($sales_id)
	{
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sales_id,'$ip','KIRIM KE SLN/HLB/WEM',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function log_generate_naskel_detail_ajax($sales_id)
	{
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sales_id,'$ip','GENERATE NASKEL OLEH SLN/HLB/WEM',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function log_cek_ajax($sales_id)
	{
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sales_id,'$ip','KEMBALIKAN KE SALES',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function log_sales_ajax($sales_id)
	{
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sales_id,'$ip','KEMBALIKAN KE SPV',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function log_tolakkebm_ajax($sales_id)
	{
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sales_id,'$ip','KEMBALIKAN KE PEMIMPIN/PIMPINAN_CABANG',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	public function total_tambah_CR($id)
	{
		$sql = "select
				sales_id,
				NVL(count(cif_key),0) TOTAL_CR
				from
				usulan_flagging
				where cust_type='CR' and sales_id=$id
				group by sales_id";
		#die();
		return $this->db->query($sql)->result();
	}
	public function total_tambah_BB($id)
	{
		$sql = "select
				sales_id,
				NVL(count(cif_key),0) TOTAL_BB
				from
				usulan_flagging
				where cust_type='BB' and sales_id=$id
				group by sales_id";
		#die();
		return $this->db->query($sql)->result();
	}
	function sudah_cek($id)
	{
		$sql=" select CASE WHEN sum(action_cek)=count(action_cek) THEN 1 ELSE 0 END AS ACTION_CEK 
				from usulan_flagging where sales_id = $id
				";
		return $this->db->query($sql)->result();
	}
	function sudah_kirim($id)
	{	
		$sql="select distinct 1 status_app from usulan_flagging
		where sales_id = $id and action_cek = 1 and status is not null and status_app in(1,2,3)";
		return $this->db->query($sql)->result();
	}
	function get_list_nasabah_tambahan($id)
	{
			$query="select
					ID,
					CIF_KEY,
					CUST_TYPE,
					CUST_NAME,
					CASE
					WHEN JENIS_TAMBAHAN = 1 THEN 'FAMILY TREE'
					WHEN JENIS_TAMBAHAN = 2 THEN 'PROSPEK'
					END AS JENIS_TAMBAHAN,
					CIF_UTAMA,
					CASE
					WHEN HUBUNGAN_DENGAN_UTAMA=1 THEN 'IBU KANDUNG'
					WHEN HUBUNGAN_DENGAN_UTAMA=2 THEN 'AYAH KANDUNG'
					WHEN HUBUNGAN_DENGAN_UTAMA=3 THEN 'KAKAK KANDUNG'
					WHEN HUBUNGAN_DENGAN_UTAMA=4 THEN 'ADIK KANDUNG'
					WHEN HUBUNGAN_DENGAN_UTAMA=5 THEN 'ANAK KANDUNG'
					WHEN HUBUNGAN_DENGAN_UTAMA=6 THEN 'SUAMI'
					WHEN HUBUNGAN_DENGAN_UTAMA=7 THEN 'ISTRI'
					END AS HUBUNGAN_DENGAN_UTAMA,
					SALES_ID,
					CREATED_DATE,
					STATUS,
					CASE
					WHEN STATUS_APP = 0 THEN 'DI SALES'
					WHEN STATUS_APP = 1 THEN 'MENUNGGU PERSETUJUAN PENYELIA'
					WHEN STATUS_APP = 2 THEN 'MENUNGGU PERSETUJUAN PEMIMPIN_CABANG/PIMPINAN_CABANG'
					WHEN STATUS_APP = 3 THEN 'MENUNGGU PERSETUJUAN SLN/HLB/WEM'
					WHEN STATUS_APP = 4 THEN 'SELESAI'
					END AS STATUS_APP,
					SEND_DATE
					from
					usulan_flagging
					WHERE SALES_ID=$id
					order by id";
			return $this->db->query($query)->result_array();
			$this->db->close();
	}
	public function insert_nasabah_tambahan($cif,$custtype,$namanasabah,$jp,$cifutama,$hdu,$salesid)
	{
		$sql="insert into usulan_flagging (CIF_KEY,CUST_TYPE,CUST_NAME,JENIS_TAMBAHAN,CIF_UTAMA,HUBUNGAN_DENGAN_UTAMA,SALES_ID,CREATED_DATE)
				values
				($cif,'$custtype','$namanasabah',$jp,'$cifutama','$hdu',$salesid,SYSDATE)
				";
		$sql1="insert into usulan_flagging_bak (CIF_KEY,CUST_TYPE,CUST_NAME,JENIS_TAMBAHAN,CIF_UTAMA,HUBUNGAN_DENGAN_UTAMA,SALES_ID,CREATED_DATE)
				values
				($cif,'$custtype','$namanasabah',$jp,'$cifutama','$hdu',$salesid,SYSDATE)
				";
		$this->db->trans_start();
		$this->db->query($sql);
		$this->db->query($sql1);
		$this->db->trans_complete();
		
		$response = $this->db->trans_status() ? 1 : 0;
				
		return $response;
	}
	public function cek_nasabah_tambahan($salesid)
	{
		$sql1="merge into usulan_flagging a using(
		select * from larangan_2017
		)b
		on(a.cif_key = b.bni_cif_key and a.sales_id=$salesid and a.action_cek=0)
		when matched then update set
		a.status = b.status";

		$sql2="merge into usulan_flagging a using(
				select cif_key||sales_id cif_sales,'Dikelola 5 Tahun' STATUS from nasabah_5tahun)b
				on(a.cif_key||a.sales_id=b.cif_sales and a.sales_id=$salesid)
				when matched then update set
				a.status = b.status";

		$sql3="merge into usulan_flagging a using(
				select
				cif_key,
				'DIKELOLA OLEH '||SALES_ID STATUS
				from
				cr_flagging)b
				on(a.cif_key=b.cif_key and a.sales_id = $salesid and a.action_cek=0)
				when matched then update set
				a.status = b.status";
				
		$sql3a="merge into usulan_flagging a using(
				select
				cif_key,
				'DIUSULKAN OLEH '||NPP STATUS
				from
				pra_flagging where status >0)b
				on(a.cif_key=b.cif_key and a.sales_id = $salesid and a.action_cek=0)
				when matched then update set
				a.status = b.status";

		$sql5="merge into usulan_flagging a using(
				select
				DISTINCT
				CIF,
				'DIKELOLA OLEH RM '||DIVISI STATUS
				from
				saldolist_hlb
				where
				tanggal_data='31-DEC-2016')b
				on(a.cif_key=b.cif and a.sales_id = $salesid and a.action_cek=0)
				when matched then update set
				a.status = b.status";
		
		$sql6="merge into usulan_flagging a using(
				select  ID,'DOUBLE' STATUS from usulan_flagging a where exists
				(select 1 from usulan_flagging where cif_key = a.cif_key and rowid < a.rowid))b
				on(a.id=b.id and a.sales_id = $salesid and a.action_cek=0)
				when matched then update set
				a.status = b.status
			";
			
		$sql7="update usulan_flagging set status='OK' where sales_id=$salesid and status is null and action_cek=0";
		$sql8="update usulan_flagging set status='OK FAMILY TREE '||status where sales_id=$salesid and jenis_tambahan=1 and status is not null and action_cek=0";
		$sql9="update usulan_flagging set action_cek=1 where sales_id=$salesid and status is not null and action_cek=0";
		
		$this->db->trans_start();
		$this->db->query($sql1);
		$this->db->query($sql2);
		$this->db->query($sql3);
		$this->db->query($sql3a);
		$this->db->query($sql5);
		$this->db->query($sql6);
		$this->db->query($sql7);
		$this->db->query($sql8);
		$this->db->query($sql9);
		$this->db->trans_complete();
		
		$response = $this->db->trans_status() ? 1 : 0;
				
		return $response;
	}
	public function cleansing_not_ok($id)
	{
		$sql="delete from usulan_flagging where sales_id=$id and substr(status,1,2) not in('OK') and action_cek=1";
		$this->db->trans_start();
		$this->db->query($sql);
		$this->db->trans_complete();
		
		$response = $this->db->trans_status() ? 1 : 0;
				
		return $response;
	}
	function kirim_sales_lama($id)
	{
		$sales=$_SESSION['SALES_ID'];
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		switch($sales)
		{
		case 1:
		case 2:
		$sql="update usulan_flagging set status_app = 2,send_date=sysdate where sales_id = $id and action_cek = 1 and substr(status,1,2) in('OK') and status_app = 0";
		break;
		default:
		$sql="update usulan_flagging set status_app = 1,send_date=sysdate where sales_id = $id and action_cek = 1 and substr(status,1,2) in('OK') and status_app = 0";
		break;
		}
		$sql2="delete from usulan_flagging where sales_id = $id and action_cek = 1 and substr(status,1,2) not in('OK') and status_app = 0";
		$sql3="delete from usulan_flagging where sales_id = $id and status is null";
		$track="
				INSERT INTO FLAGGING_TRACKING_2017 (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$npp_eks,'$ip','KIRIM USULAN TAMBAHAN KE SUPERVISOR',$npp_eks)
				";
		$this->db->trans_start();
		$this->db->query($sql);
		$this->db->query($sql2);
		$this->db->query($sql3);
		$this->db->query($track);
		$this->db->trans_complete();
		$response = $this->db->trans_status() ? 1 : 0;
				
		return $response;
	}
	
	function cek_sales_lama($npp)
	{
		$sql="select count(cif_key) jumlah from cr_flagging where sales_id=$npp";
		return $this->db->query($sql)->result();
		$this->db->close();
	}
	public function nasabah_ft($salesid)
	{
	
		$this->db->from('CUSTOMER_INDIVIDU');
		$this->db->select("BNI_SALES_ID,CUST_TYPE,CIF,NAMA_NASABAH",FALSE);
		$where = array('BNI_SALES_ID'=>$salesid,'CUST_TYPE'=>'CR');
		$this->db->where($where);
		$this->CI->flexigrid->build_query();
		
		#Get contents
		$return['records'] = $this->db->get();
		
		#Build count query
		$this->db->from('CUSTOMER_INDIVIDU');
		$this->db->select("COUNT(CIF) AS RECORD_COUNT",FALSE);
		$where = array('BNI_SALES_ID'=>$salesid,'CUST_TYPE'=>'CR');
		$this->db->where($where);	
		
		$this->CI->flexigrid->build_query(FALSE);
		$record_count = $this->db->get();
		$row = $record_count->row();
		
		#Get Record Count
		$return['record_count'] = $row->RECORD_COUNT;
		
		#Return all
		return $return;
	}
	public function get_sales_nas_kelu() 
	{
		$this->db->from('VW_USER_TAMBAHAN_LAMA');
		$npp = $_SESSION['ID'];
		$branch = $_SESSION['BRANCH_ID'];
		$region = $_SESSION['REGION'];
		switch($_SESSION['USER_LEVEL'])
		{
			case 'PEMIMPIN_CABANG':
			case 'PIMPINAN_CABANG':
				$where = array("BRANCH"=>"$branch","STATUS_APP"=>2);
			break;
			case 'SLN':
				$where = array("REGION <="=>18,"STATUS_APP"=>3);
			break;
			case 'HLB':
				$where = array("REGION <="=>18,"STATUS_APP"=>3,"SALES >="=>7,"SALES <="=>8);
			break;
			case 'WEM':
				$where = array("REGION <="=>18,"STATUS_APP"=>3,"SALES >="=>20,"SALES <="=>22);
			break;
			default :
			$where = array("SPV"=>"$npp","STATUS_APP"=>1);
			break;
		}
		$this->db->where($where);		
		$this->CI->flexigrid->build_query();
		
		#Get contents
		$return['records'] = $this->db->get();
		
		#Build count query
		$this->db->from('VW_USER_TAMBAHAN_LAMA');
		$this->db->select("COUNT(ID) AS RECORD_COUNT",FALSE);
		switch($_SESSION['USER_LEVEL'])
		{
			case 'PEMIMPIN_CABANG':
			case 'PIMPINAN_CABANG':
				$where = array("BRANCH"=>"$branch","STATUS_APP"=>2);
			break;
			case 'SLN':
			case 'HLB':
			case 'WEM':
				$where = array("REGION <="=>18,"STATUS_APP"=>3);
			break;
			default :
			$where = array("SPV"=>"$npp","STATUS_APP"=>1);
			break;
		}
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
	function log_tolak_tambahan_all($sales_id)
	{
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING_2017 (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sales_id,'$ip','DITOLAK OLEH "/$_SESSION['USER_LEVEL']."',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function tolak_tambahan_all($npp)
	{
		$lvl=$_SESSION['USER_LEVEL'];
		#$this->db->where('CIF_KEY', $ID);
		$this->db->where('SALES_ID', $npp);
		
		switch($lvl)
				{
					case 'SUPERVISOR':
						$this->db->where('STATUS_APP',1);
						$this->db->set('STATUS', 'DITOLAK OLEH SUPERVISOR');
						$this->db->set('STATUS_APP', 0);
						break;
					case 'PEMIMPIN_CABANG':
					case 'PIMPINAN_CABANG':
						$this->db->where('STATUS_APP',2);
						$this->db->set('STATUS', 'DITOLAK OLEH '.$lvl.'');
						$this->db->set('STATUS_APP', 0);
						break;
					case 'SLN':
					case 'HLB':
					case 'WEM':
						$this->db->where('STATUS_APP',3);
						$this->db->set('STATUS', 'DITOLAK OLEH '.$lvl.'');
						$this->db->set('STATUS_APP', 0);
						break;
					default : 
						$where = array('SALES_ID'=>$npp);
						break;
				}
		
		$this->db->trans_start();
		$this->db->update('USULAN_FLAGGING');
		$this->db->trans_complete();
		
		$response = $this->db->trans_status() ? 1 : 0;
				
		return $response;
	}
	function get_list_nasabah_tambahan25($id)
	{
		$npp = $this->session->userdata('ID');
				$lvl = strtoupper($this->session->userdata('USER_LEVEL'));
				$cab = $this->session->userdata('BRANCH_ID');
				$wil = $this->session->userdata('REGION');
	
			switch ($lvl)
				{
					case 'SUPERVISOR':
					case 'PEMIMPIN_KLN-KK':
						$where = array('SALES_ID'=>$id,'STATUS_APP_ID' => 1);
						break;
					case 'PEMIMPIN_CABANG':
					case 'PIMPINAN_CABANG':
						$where = array('SALES_ID'=>$id,'STATUS_APP_ID' => 2);
						break;
					case 'SLN':
					case 'HLB':
					case 'WEM':
						$where= array('SALES_ID'=>$id,'STATUS_APP_ID' => 3);
						break;
					default : 
						$where = array('SALES_ID'=>$id);
						break;
				}

		$this->db->where($where);
		#$this->db->where('is_hide',1);
		$this->db->order_by("id", "asc","CUST_NAME","ASC");
		return $this->db->get('LIST_TAMBAHAN_LAMA')->result_array();
	}
	function log_kirim_sln_tambahan($sales_id)
	{
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING_2017 (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sales_id,'$ip','DISETUJUI OLEH $npp_eks',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function kirim_sln_tambahan($ID, $SALES_ID)
	{
		$this->db->where('CIF_KEY', $ID);
		$this->db->where('SALES_ID', $SALES_ID);
		$this->db->set('STATUS_APP', 4);
		return $this->db->update('USULAN_FLAGGING');
	}
	function auto_tolak($sales_id)
	{
		$lvl=$_SESSION['USER_LEVEL'];
		#$this->db->where('CIF_KEY', $ID);
		$this->db->where('SALES_ID', $SALES_ID);
		
		switch($lvl)
				{
					case 'SUPERVISOR':
						$this->db->where('STATUS_APP',1);
						$this->db->set('STATUS', 'DITOLAK OLEH SUPERVISOR');
						$this->db->set('STATUS_APP', 0);
						break;
					case 'PEMIMPIN_CABANG':
					case 'PIMPINAN_CABANG':
						$this->db->where('STATUS_APP',2);
						$this->db->set('STATUS', 'DITOLAK OLEH '.$lvl.'');
						$this->db->set('STATUS_APP', 0);
						break;
					case 'SLN':
					case 'HLB':
					case 'WEM':
						$this->db->where('STATUS_APP',3);
						$this->db->set('STATUS', 'DITOLAK OLEH '.$lvl.'');
						$this->db->set('STATUS_APP', 0);
						break;
					default : 
						$where = array('SALES_ID'=>$id);
						break;
				}
		return $this->db->update('USULAN_FLAGGING');
	}
	function log_kirim_spv_tambahan($sales_id)
	{
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING_2017 (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sales_id,'$ip','SETUJU TAMBAHAN KIRIM KE PEMIMPIN/PIMPINAN',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function kirim_spv_tambahan($ID, $SALES_ID)
	{
		$this->db->where('CIF_KEY', $ID);
		$this->db->where('SALES_ID', $SALES_ID);
		$this->db->set('STATUS_APP', 2);
		return $this->db->update('USULAN_FLAGGING');
	}
	function log_kirim_bm_tambahan($sales_id)
	{
		$ip =$_SERVER['REMOTE_ADDR'];
		$npp_eks=$_SESSION['ID'];
		$track="
				INSERT INTO FLAGGING_TRACKING_2017 (AS_OF_DATE,NPP,IP_ADDRESS,AKSI,NPP_EKSEKUTOR)
				VALUES(SYSDATE,$sales_id,'$ip','SETUJU TAMBAHAN KIRIM KE SLN/HLB/WEM',$npp_eks)
				";
		$this->db->query($track);
		$this->db->close();
	}
	function kirim_bm_tambahan($ID, $SALES_ID)
	{
		$this->db->where('CIF_KEY', $ID);
		$this->db->where('SALES_ID', $SALES_ID);
		$this->db->set('STATUS_APP', 3);
		return $this->db->update('USULAN_FLAGGING');
	}
}