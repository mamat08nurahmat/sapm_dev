<?php
class Tes extends Controller {
	
	function Tes()
	{
		parent::Controller();
	/**/	
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('table','validation', 'session', 'ldap'));
		$this->load->model('_login', 'login', TRUE);
		 $this->load->model('_news');
		 $this->load->model('_activity');
		 //$this->load->model('_home');
				 $this->load->model('_report');
 
		$this->load->model('_agenda_bm');		 
		date_default_timezone_set('Asia/Jakarta');
		if($_SESSION['ID'] == ''){ redirect('login/logout/');}
		$this->load->model('_handler');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
		/*
		*/
	}
	
//    function index($tabel='')
    function index()
    {
//$news = $this->db->query("SELECT * FROM REALISASI ")->result();

		$news = $this->db->query("SELECT * FROM NEW_REALISASI WHERE ROWNUM <= 10 ")->result();
		print_r($news);
		
//        $this->load->view('default/home' , array('news' => $news));	

	}

function tabel($cek='news'){
	
	$quert = $this->db->query("SELECT * FROM $cek WHERE ROWNUM <= 10")->result();
	
	print_r($quert);
}



	function cekData($npp)
	{
		$this->db->select('a.*, b.SALES_TYPE, c.BRANCH_NAME, c.REGION ',false);
		$this->db->from('USER_TST a');
		$this->db->join('SALES_TYPE b', 'a.SALES = b.ID', 'LEFT');
		$this->db->join('BRANCH c','a.BRANCH = c.BRANCH_CODE');
		$this->db->where('a.ID', $npp);
		print_r($this->db->get()->result());
//		return $this->db->get()->result();
	}


	function get_user($id)
	{
		$this->db->select('*');
		$this->db->from('USER_TST ');
//		$this->db->join('SALES_TYPE b', 'a.SALES = b.ID');
		$this->db->where('ID','$id');
		
		/*
		$this->db->select('a.ID, a.USER_NAME,a.sales, b.SALES_TYPE, a.SPV');
		$this->db->from('USER_TST a');
		$this->db->join('SALES_TYPE b', 'a.SALES = b.ID');
		$this->db->where('SUBSTR((TRIM(a.ID)),-5,5)',"$id");
		*/
		//return $this->db->get()->result();
		print_r($this->db->get()->result());
	}



public xls(){
/*
$id = 16622;
$month=1;
$year=2017;	
$where2 =" AND A.SOURCE_DATA ='Account Plan'";
$where21="A.SOURCE_DATA,";
*/

		#----------------------------------------
		#	Query mode
		#----------------------------------------
		$sql = "select  
*                        from vw_produk_target WHERE ROWNUM <= 10
 						";		
			echo $sql;die();
		
		print_r($this->db->query($sql)->result());
}
	
	
	
	
function flexigrid(){
//	$this->load->view("default/flexigrid");
		//ver lib
		
		//load model
		$this->load->model('flexigrid_model');
		$records = $this->flexigrid_model->get_select_countries();
		
		$options = '';
		foreach( $records as $v ) {
			$options .= $v['name'] . ';';
		}
		$options = substr($options, 0, -1);

		/*
		 * 0 - display name
		 * 1 - width
		 * 2 - sortable
		 * 3 - align
		 * 4 - searchable (2 -> yes and default, 1 -> yes, 0 -> no.)
		 */
		$colModel['id'] 			= array('ID',40,TRUE,'center',2);
		$colModel['judul'] 			= array('JUDUL',40,TRUE,'center',0);
		$colModel['isi'] 			= array('ISI',180,TRUE,'left',1);
		//$colModel['printable_name'] = array('Printable Name',120,TRUE,'left',1);
		//$colModel['iso3'] 			= array('ISO3',130, TRUE,'left',1, 'options' => array('type' => 'select', 'edit_options' => $options));
		//$colModel['numcode'] = array('Number Code',80, TRUE, 'right',1, 'options' => array('type' => 'select', 'edit_options' => ":All;AND:AND;KK:KK;RE:RE"));
		//$colModel['created_date'] = array('Date',80,TRUE,'left',1,'options' => array('type' => 'date'));
		$colModel['actions'] = array('Actions',80, FALSE, 'right',0);
		
		
		/*
		 * Aditional Parameters
		 */
		$gridParams = array(
		'width' => 'auto',
		'height' => 'auto',
		'rp' => 15,
		'rpOptions' => '[10,15,20,25,40]',
		'pagestat' => 'Displaying: {from} to {to} of {total} items.',
		'blockOpacity' => 0.5,
		'title' => 'News',
		'showTableToggleBtn' => true
		);
		
		/*
		 * 0 - display name
		 * 1 - bclass
		 * 2 - onpress
		 */
		$buttons[] = array('separator');
		$buttons[] = array('Delete','delete','test');
		$buttons[] = array('separator');
		$buttons[] = array('Select All','add','test');
		$buttons[] = array('separator');
		$buttons[] = array('DeSelect All','delete','test');
		$buttons[] = array('separator');

		//SHS for Flexigrid issue site_url()
		$this->load->helper('url');

		//Build js
		//View helpers/flexigrid_helper.php for more information about the params on this function
		$grid_js = build_grid_js('flex1',site_url("/flexigrid_feed"),$colModel,'id','desc',$gridParams,$buttons);
		$data['js_grid'] = $grid_js;
		$data['version'] = "0.36";
		$data['download_file'] = "Flexigrid_CI_v0.36.rar";
		
		$this->load->view('default/flexigrid',$data);
	
}


	function get_cifchecker($cif=0)

	{
/*
echo $cif;
*/
//		$this->db->select('a.SALES_ID,a.CIF_KEY,a.CUST_NAME,b.USER_NAME,d.SALES_TYPE,c.branch_name',false);
		$this->db->select('a.SALES_ID,a.CIF_KEY,a.CUST_NAME');
		$this->db->from('CR_FLAGGING a');
//		$this->db->join('USER_TST b','a.SALES_ID = b.ID');
//		$this->db->join('BRANCH c','b.BRANCH=c.BRANCH_CODE');
//		$this->db->join('SALES_TYPE d','b.SALES = d.ID');
		$this->db->where('a.CIF_KEY',$cif);
		$data =  $this->db->get()->result();	
print_r($data);	
/*
$this->db->select('SALES_ID,CUST_NAME');		
$this->db->from('CR_FLAGGING');		
$this->db->where('CIF_KEY',9403241296);		
print_r($this->db->get()->result());	
*/		

	}
		
		
		
}

