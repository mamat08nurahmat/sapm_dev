<?php
class Sales extends Controller {
	
	function Sales()
	{
		parent::Controller();
		$this->load->helper('flexigrid');
		$this->load->model('_sales');
		if($_SESSION['ID'] == ''){ redirect('login');}
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES');
		#if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/2');}
		$this->load->model('_handler');
		$this->load->model('_news');

		date_default_timezone_set('Asia/Jakarta');
		
		$session_id = $_SESSION['ID'];
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
	}
	
    function index()
    {
        $this->load->view('default/sales');
    }
//------------------------------------------------------------------
	function cust_ind()
	{

/*
		$tabel1 = $this->db->query("SELECT * FROM news WHERE ROWNUM <= 100")->result();
		#print_r($tabel1);die();

		$data1 = array(
		'data_tabel1' => $tabel1
		);
$this->load->view('sales/index_new',$data1);		
*/	

//$id = ($this->session->userdata('ID') <> '')?$this->session->userdata('ID'):0;
/*
*/
$id = $_SESSION['ID'];
		$tab1 = $this->_sales->get_cust_ind_new($id);		
		$tab2 = $this->_sales->get_cust_ind_new($id);		
		$tab3 = $this->_sales->get_cust_tele_new($id);		
		$tab4 = $this->_sales->get_cust_ind_new($id);		
		$tab5 = $this->_sales->get_cust_ind_new($id);		
		#print_r($tab3);die();
/*
		$data = array(
		'data_tab1' => $tab4
		'data_tab2' => $tab2
		);
*/
$data['data_tab1'] = $tab1;		
$data['data_tab2'] = $tab2;		
$data['data_tab3'] = $tab3;		
$data['data_tab4'] = $tab4;		
$data['data_tab5'] = $tab5;		
$this->load->view('sales/index_new',$data);		
/*
	foreach($tabel1 as $row){
			
<?php echo $row->ID; ?>
		}

		

//			$this->load->view('sales/index',$data);
			$this->load->view('sales/index_new',$data1);
*/		

		
	}

function tab_1_view(){
	
	echo"TAB 1 VIEW";
}	
	
function tab_2_view(){
	
	echo"TAB 2 VIEW";
}	
	
function tab_3_view(){
	
	echo"TAB 3 VIEW";
}	
	
function tab_4_view($type,$id){

		
		if($type==0)
		{
			$data['data'] = $this->_sales->get_data_cust($type, $id,'CUST_INDV_PROS');
			//$view = 'cust_ind_view';
		//	echo"type 0";
		print_r($data);die();
		}
		else
		{
			$data['data_pribadi'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_PRIBADI');
			$data['data_pekerjaan'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_PEKERJAAN');
			$data['data_pasangan'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_PASANGAN_ANAK');
			$data['data_bisnis'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_BISNIS');
			$data['data_lain'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_LAIN');
			$data['data_prod_bni'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_PROD_BNI');
			$data['data_prod_bank_lain'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_PROD_BANK_LAIN');
			$data['data_sales'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_SALES');
			//$view = 'cust_ind_view_non_pros';
	//	echo"NON PROS";
	print_r($data_pribadi);die();
		}
		
//		$this->load->view('sales/'.$view, $data);
	
}	
	
function tab_5_view(){
	
	echo"TAB 5 VIEW";
}	
	
function tab_5_add(){
	
	echo"TAB 5 ADD";
}	
	
function tab_5_edit(){
	
	echo"TAB 5 EDIT";
}	
	
function tab_5_delete(){
	
	echo"TAB 5 DELETE";
}	
	
	
function tabel1(){
	
//	echo "XXXXXXXXXXXXXXXXXXXXXX";


$html ="";
$html .="XXXXXXXXXXXX";
$html .="<br>";
$html .="YYYYYYYYYYYY";
$html .="

";
$html .='
              <table id="example1" class="table table-bordered table-striped">
';

$html .="

                <thead>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </thead>
";


$html .="

				
                <tbody>
				
                <tr>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 4.0
                  </td>
                  <td>Win 95+</td>
                  <td> 4</td>
                  <td>X</td>
                </tr>
				
                <tr>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 5.0
                  </td>
                  <td>Win 95+</td>
                  <td>5</td>
                  <td>C</td>
                </tr>
				
                <tr>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 5.5
                  </td>
                  <td>Win 95+</td>
                  <td>5.5</td>
                  <td>A</td>
                </tr>
				
                

                </tbody>
				
";		
$html .="

                <tfoot>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </tfoot>
";	  

$html .="				
              </table>
";





echo $html;
	
}
	
	function cust_ind_lama()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		//echo $lvl;die();
		//ver lib
		
		/*
		 * 0 - display name
		 * 1 - width
		 * 2 - sortable
		 * 3 - align
		 * 4 - searchable (2 -> yes and default, 1 -> yes, 0 -> no.)
		 */
#---------------------------------------------------		
#	Get contents Individu per sales id
#---------------------------------------------------		
		$colModel['ID'] 				= array('ID',30,TRUE,'center',1);
		$colModel['CIF'] 			= array('CIF',60,TRUE,'center',2);
		$colModel['CUST_NAME'] 			= array('NAMA',200,TRUE,'left',0);
		$colModel['AGE'] 				= array('UMUR',40,TRUE,'center',1);
		$colModel['TOTAL_AUM_BNI'] 	= array('TOTAL AUM',100,TRUE,'right',1);
		$colModel['TOTAL_LOAN_BNI'] 		= array('TOTAL LOAN',100,TRUE,'right',1);		
		$colModel['BNI_SALES_ID']		= array('SALES',60, TRUE,'center',1);
		$colModel['BRANCH_NAME']		= array('CABANG',60, TRUE,'center',1);
//		$colModel['STATUS']				= array('STATUS',60, TRUE,'center',0);
		
		/*
		 * Aditional Parameters
		 */
		$gridParams = array(
			//'width' 			=> 'auto',
			'width' 			=> 750,
			'height' 			=> 750,
			'rp' 				=> 150,
			'rpOptions' 		=> '[10,25,50,100,150,200]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA LEADS KELOLAAN',
			'showTableToggleBtn'=> true
		);
		
		/*
		 * 0 - display name
		 * 1 - bclass
		 * 2 - onpress
		 */
		$buttons[] = array('View','view','view_ind');
		if($lvl == 'SALES')	$buttons[] = array('Edit','edit','edit_ind');
		$buttons[] = array('separator');

		$grid_js = build_grid_js('sales_ind_list',site_url("/sales_ajax/cust_ind"),$colModel,'CUST_NAME','ASC',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;
		
#------------------------------------------------		
#	Get contents Customer Prospek
#------------------------------------------------
		$colModel4['ID'] 				= array('ID',65,TRUE,'center',1);
		$colModel4['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel4['CUST_NAME'] 		= array('NAMA',200,TRUE,'left',2);
		$colModel4['AGE'] 				= array('UMUR',100,TRUE,'center',0);
		
		$gridParams4 = array(
			//'width' 			=> 'auto',
			'width' 			=> 750,
			'height' 			=> 300,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA LEADS PROSPEK',
			'showTableToggleBtn'=> true
		);

		$buttons4[] = array('View','view','view_ind');
		$buttons4[] = array('Edit','edit','edit_ind_pros');
		$buttons4[] = array('Add','add','add_ind_pros');
		$buttons4[] = array('Delete','delete','test');
		$buttons4[] = array('separator');

		$grid_js4 = build_grid_js('sales_ind_pros_list',site_url("/sales_ajax/cust_ind_pros"),$colModel4,'CUST_NAME','ASC',$gridParams4,$buttons4);
		
		$data['js_grid_ind_pros'] = $grid_js4;
		
#------------------------------------------------------		
#	Get contents Customer Corp Prospek
#------------------------------------------------------
		$colModel3['ID'] 				= array('ID',30,TRUE,'center',1);
		$colModel3['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel3['CUST_NAME'] 		= array('NAMA',200,TRUE,'left',2);
		$colModel3['AGE'] 				= array('UMUR',40,TRUE,'center',1);
		$colModel3['CUR_BOOK_BAL_IDR'] 	= array('TOTAL SALDO',100,TRUE,'right',1);
		$colModel3['AVG_BOOK_BAL'] 		= array('RATA2 SALDO',100,TRUE,'right',1);		
		$colModel3['BRANCH_CODE']		= array('CABANG',60, TRUE,'center',1);
		$colModel3['STATUS']			= array('STATUS',60, TRUE,'center',0);
		
		$gridParams3 = array(
			'width' 			=> 'auto',
			'height' 			=> 300,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA LEADS KELOLAAN CABANG',
			'showTableToggleBtn'=> true
		);

		$buttons3[] = array('View','view','view_ind');
		$buttons3[] = array('separator');

		$grid_js3 = build_grid_js('sales_ind_cab_list',site_url("/sales_ajax/cust_ind_cab"),$colModel3,'CUST_NAME','ASC',$gridParams3,$buttons3);
		
		$data['js_grid_ind_cab'] = $grid_js3;


#--------------------------------------		
#	Get contents Corporate
#--------------------------------------
		$colModel2['ID'] 				= array('ID',30,TRUE,'center',1);
		$colModel2['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel2['COMPANY_NAME']		= array('NAMA PERUSAHAAN',200,TRUE,'left',2);
		$colModel2['CUR_BOOK_BAL_IDR'] 	= array('TOTAL SALDO',120,TRUE,'right',1);
		$colModel2['AVG_BOOK_BAL'] 		= array('RATA2 SALDO',120,TRUE,'right',1);		
		$colModel2['BRANCH_CODE']		= array('CABANG',60, TRUE,'center',1);
		$colModel2['STATUS']			= array('STATUS',60, TRUE,'center',0);
		
		$gridParams2 = array(
			//'width' 			=> 'auto',
			'width' 			=> 750,
			'height' 			=> 300,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA CUSTOMER CORPORATE',
			'showTableToggleBtn'=> true
		);

		$buttons2[] = array('View','view','view_corp');
		$buttons2[] = array('Edit','edit','edit_corp');
		$buttons2[] = array('separator');

		$grid_js2 = build_grid_js('sales_corp_list',site_url("/sales_ajax/cust_corp"),$colModel2,'COMPANY_NAME','ASC',$gridParams2,$buttons2);
		
		$data['js_grid_corp'] = $grid_js2;

#----------------------------------------		
#	Get contents Corporate Pros		#
#----------------------------------------
		$colModel5['ID'] 				= array('ID',30,TRUE,'center',1);
		$colModel5['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel5['COMPANY_NAME']		= array('NAMA PERUSAHAAN',200,TRUE,'left',2);
		
		$gridParams5 = array(
			//'width' 			=> 'auto',
			'width' 			=> 750,
			'height' 			=> 300,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA CUSTOMER PROSPEK CORPORATE',
			'showTableToggleBtn'=> true
		);

		$buttons5[] = array('View','view','view_corp');
		$buttons5[] = array('Edit','edit','edit_corp');
		$buttons5[] = array('Add','add','add_corp_pros');
		$buttons5[] = array('Delete','delete','del_corp');
		$buttons5[] = array('separator');

		$grid_js5 = build_grid_js('sales_corp_pros_list',site_url("/sales_ajax/cust_corp_pros"),$colModel5,'COMPANY_NAME','ASC',$gridParams5,$buttons5);
		
		$data['js_grid_corp_pros'] = $grid_js5;
		
		#DATA TELESALES INBOUND

#------------------------------------------------------		
#	Get contents Customer Corp Prospek
#------------------------------------------------------
		
		$colModel6['ID'] 				= array('ID',60,TRUE,'center',1);
		$colModel6['SAPM_DATE'] 		= array('SAPM_DATE',80,TRUE,'center',1);
		$colModel6['CIF'] 				= array('CIF',60,TRUE,'center',1);
		$colModel6['NAMA']		 		= array('NAMA',200,TRUE,'left',2);
		$colModel6['HP'] 				= array('HP',60,TRUE,'center',1);
		$colModel6['KOTA'] 				= array('KOTA',60,TRUE,'center',1);
		$colModel6['JENIS_PRODUK'] 		= array('JENIS_PRODUK',100,TRUE,'center',1);		
		$colModel6['KODE_CABANG']		= array('KODE_CABANG',60, TRUE,'center',1);
		
		$gridParams6 = array(
			'width' 			=> 'auto',
			'height' 			=> 300,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA LEADS 150046',
			'showTableToggleBtn'=> true
		);
		
		if($_SESSION['USER_LEVEL']=='PEMIMPINS'||$_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG')
		{
		$buttons6[] = array('Append to sales','add','appendToSales2');
		$buttons6[] = array('Edit','edit','edit_tele');
		$buttons6[] = array('separator');
		}
		//else if($_SESSION['USER_LEVEL']=='SUPERVISOR')
			else
		{
		$buttons6[] = array('Edit','edit','edit_tele');
		$buttons6[] = array('separator');
		}

		$grid_js6 = build_grid_js('sales_tele',site_url("/sales_ajax/cust_tele"),$colModel6,'NAMA','ASC',$gridParams6,$buttons6);
		
		$data['js_grid_tele'] = $grid_js6;
		
		//TELE SALES
		
		$colModel7['ID'] 				= array('ID',60,TRUE,'center',1);
		$colModel7['SAPM_DATE'] 		= array('SAPM_DATE',80,TRUE,'center',1);
		$colModel7['CIF'] 				= array('CIF',60,TRUE,'center',1);
		$colModel7['NAMA']		 		= array('NAMA',200,TRUE,'left',2);
		$colModel7['HP'] 				= array('HP',60,TRUE,'center',1);
		$colModel7['KOTA'] 				= array('KOTA',60,TRUE,'center',1);
		$colModel7['JENIS_PRODUK'] 		= array('JENIS_PRODUK',100,TRUE,'center',1);		
		$colModel7['KODE_CABANG']		= array('KODE_CABANG',60, TRUE,'center',1);
		
		$gridParams7 = array(
			'width' 			=> 'auto',
			'height' 			=> 300,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA LEADS 150046',
			'showTableToggleBtn'=> true
		);
		
		$buttons7[] = array('View','view','view_tele');
		$buttons7[] = array('separator');

		$grid_js7 = build_grid_js('sales_tele1',site_url("/sales_ajax/cust_tele"),$colModel7,'NAMA','ASC',$gridParams7,$buttons7);
		
		$data['js_grid_tele1'] = $grid_js7;
		//

		
		//propensity
		
		$colModel8['ID'] 				= array('ID',50,TRUE,'center',1);
		$colModel8['CIF_KEY'] 				= array('CIF KEY',100,TRUE,'center',1);
		$colModel8['NAMA'] 					= array('NAME',200,TRUE,'left',1);
		$colModel8['BRANCH'] 				= array('BRANCH',80,TRUE,'center',1);
		$colModel8['HANDPHONE'] 			= array('BNI HP NO',80,TRUE,'center',1);		
		$colModel8['PROGRAM_NAME']			= array('PROGRAM PENJUALAN',150, TRUE,'left',1);
		$colModel8['PRODUK']				= array('PRODUK',150, TRUE,'left',1);
		$colModel8['EXPIRED_PROGRAM']		= array('JANGKA WAKTU PROGRAM',80, TRUE,'center',1);
		
		
		$gridParams8 = array(
			'width' 			=> 'auto',
			'height' 			=> 300,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA LEADS PROPENSITY',
			'showTableToggleBtn'=> true
		);
		
		$data['list_sales']=array();
		$buttons8=array();
		if($_SESSION['USER_LEVEL']=='PEMIMPINS'||$_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='SUPERVISOR' || $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' )
		{
			//$buttons8[] = array('Append to sales','add','appendToSales');
			//$buttons8[] = array('separator');
		}
		$buttons8[] = array('View','view','viewPropensity');
		$grid_js8 = build_grid_js('leads_propensity',site_url("/sales_ajax/leads_propensity"),$colModel8,'NAMA','ASC',$gridParams8,$buttons8);
		
		$data['js_grid_propensity'] = $grid_js8;
		//
		
		#OFFENSIVE
		$colModel9['ID'] 				= array('ID',30,TRUE,'center',1);
		$colModel9['CIF_KEY'] 			= array('CIF',60,TRUE,'center',2);
		$colModel9['CUST_NAME'] 			= array('NAMA',200,TRUE,'left',0);
		$colModel9['BRANCH'] 				= array('CABANG',40,TRUE,'center',1,true);
		$colModel9['PHONE_1'] 	= array('NO HP',100,TRUE,'right',1);
		$colModel9['PROGRAM_NAME'] 		= array('PROGRAM',100,TRUE,'right',1);		
		$colModel9['PRODUCT_NAME']		= array('PRODUK',120, TRUE,'center',1);
		
		
		/*
		 * Aditional Parameters
		 */
		$gridParams9 = array(
			//'width' 			=> 'auto',
			'width' 			=> 750,
			'height' 			=> 750,
			'rp' 				=> 150,
			'rpOptions' 		=> '[10,25,50,100,150,200]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA LEADS OFFENSIVE',
			'showTableToggleBtn'=> true
		);
		
		/*
		 * 0 - display name
		 * 1 - bclass
		 * 2 - onpress
		 */
		 
		$buttons9[] = array('View','view','viewOffensive');
		#if($lvl == 'SALES')	$buttons[] = array('Edit','edit','edit_ind');
		$data['list_sales']=array();
		$buttons9[] = array('separator');
		if($_SESSION['USER_LEVEL']=='PEMIMPINS'||$_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG')
		{
		$buttons9[] = array('Append to sales','add','appendToSales3');
		}
		$grid_js9 = build_grid_js('leads_offensive',site_url("/sales_ajax/leads_offensive"),$colModel9,'CUST_NAME','ASC',$gridParams9,$buttons9);
		
		$data['js_grid_offensive'] = $grid_js9;
		
		
		if($_SESSION['USER_LEVEL']=='PEMIMPINS'||$_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG')
		{
			//load model user
			$this->load->model('_user');
			foreach($this->_user->get_sales_by_cabang($_SESSION['BRANCH_ID']) as $row)
			{
				$data['list_sales'][$row->ID]="{$row->USER_NAME}-{$row->SALES_TYPE} ({$row->ID})";
			}
		}
		elseif($_SESSION['USER_LEVEL']=='SUPERVISOR')
		{
			$this->load->model('_user');
			foreach($this->_user->get_sales_by_spv($_SESSION['ID']) as $row)
			{
				$data['list_sales'][$row->ID]="{$row->USER_NAME}-{$row->SALES_TYPE} ({$row->ID})";
			}
		}
		else
		{
			$data['list_sales']=array();
		}

		
#------------------------------------------------		
#	Get contents Customer Prospek
#------------------------------------------------
		$colModel4['ID'] 				= array('ID',65,TRUE,'center',1);
		$colModel4['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel4['CUST_NAME'] 		= array('NAMA',200,TRUE,'left',2);
		$colModel4['AGE'] 				= array('UMUR',100,TRUE,'center',0);
		
		$gridParams4 = array(
			//'width' 			=> 'auto',
			'width' 			=> 750,
			'height' 			=> 300,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA LEADS PROSPEK',
			'showTableToggleBtn'=> true
		);

		$buttons4[] = array('View','view','view_ind');
		$buttons4[] = array('Edit','edit','edit_ind_pros');
		$buttons4[] = array('Add','add','add_ind_pros');
		$buttons4[] = array('Delete','delete','test');
		$buttons4[] = array('separator');

		$grid_js4 = build_grid_js('sales_ind_pros_list',site_url("/sales_ajax/cust_ind_pros"),$colModel4,'CUST_NAME','ASC',$gridParams4,$buttons4);
		
		$data['js_grid_ind_pros'] = $grid_js4;
		
#------------------------------------------------------		
#	Get NEWS XXXX
#------------------------------------------------------
		$colModel99['ID'] 				= array('ID',30,TRUE,'center',1);
		$colModel99['JUDUL'] 			= array('CIF',60,TRUE,'center',1);
		$colModel99['ISI'] 		= array('NAMA',200,TRUE,'left',2);
/*
		$colModel3['AGE'] 				= array('UMUR',40,TRUE,'center',1);
		$colModel3['CUR_BOOK_BAL_IDR'] 	= array('TOTAL SALDO',100,TRUE,'right',1);
		$colModel3['AVG_BOOK_BAL'] 		= array('RATA2 SALDO',100,TRUE,'right',1);		
		$colModel3['BRANCH_CODE']		= array('CABANG',60, TRUE,'center',1);
		$colModel3['STATUS']			= array('STATUS',60, TRUE,'center',0);
*/		
		
		$gridParams99 = array(
			'width' 			=> 'auto',
			'height' 			=> 300,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA NEWS XXXX',
			'showTableToggleBtn'=> true
		);

		$buttons99[] = array('View','view','view_ind');
		$buttons99[] = array('separator');

//		$grid_js3 = build_grid_js('sales_ind_cab_list',site_url("/sales_ajax/cust_ind_cab"),$colModel3,'CUST_NAME','ASC',$gridParams3,$buttons3);
		$grid_js99 = build_grid_js('sales_news99_list',site_url("/sales_ajax/news99"),$colModel99,'JUDUL','ASC',$gridParams99,$buttons99);
		
		$data['js_grid_news99'] = $grid_js99;		
		
		
		$this->load->view('sales/index',$data);
//		echo '<pre>';
//		var_dump($data);
//		echo '</pre>';
	}
	
#---------------------------------
#	Customer for editing		#
#---------------------------------
	function edit_cust_ind_pros()
	{
		#OFFENSIVE
		$colModel9['ID'] 				= array('ID',30,TRUE,'center',1);
		$colModel9['CIF_KEY'] 			= array('CIF',60,TRUE,'center',2);
		$colModel9['CUST_NAME'] 			= array('NAMA',200,TRUE,'left',0);
		$colModel9['BRANCH'] 				= array('CABANG',40,TRUE,'center',1,true);
		$colModel9['PHONE_1'] 	= array('NO HP',100,TRUE,'right',1);
		$colModel9['PROGRAM_NAME'] 		= array('PROGRAM',100,TRUE,'right',1);		
		$colModel9['PRODUCT_NAME']		= array('PRODUK',120, TRUE,'center',1);
		
		
		/*
		 * Aditional Parameters
		 */
		$gridParams9 = array(
			//'width' 			=> 'auto',
			'width' 			=> 610,
			'height' 			=> 180,
			'rp' 				=> 150,
			'rpOptions' 		=> '[10,25,50,100,150,200]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'DATA LEADS OFFENSIVE',
			'showTableToggleBtn'=> true
		);
		
		/*
		 * 0 - display name
		 * 1 - bclass
		 * 2 - onpress
		 */
		$buttons9[] = array('Pilih','add','pilih_data');
		$grid_js9 = build_grid_js('search_list',site_url("/sales_ajax/leads_offensive"),$colModel9,'CUST_NAME','ASC',$gridParams9,$buttons9);
		$data['js_grid_offensive'] = $grid_js9;
		$data['bni_product']	=  $this->_sales->get_bni_product();
		$data['other_product']	=  $this->_sales->get_other_product($this->session->userdata('BRANCH_ID'));
		$data['list_sumber_leads'] = $this->_sales->get_sumber_leads();
		$data['list_cabang'] = $this->_sales->get_cabang();
		$this->load->view("sales/cust_ind_pros_edit", $data);
	}
	
	function save_cust_ind_pros()
	{
		$id = ($this->input->post('ID'))?$this->input->post('ID'):'';
		$cek = ($this->input->post('REFFERAL_LEADS_ID'))?$this->input->post('REFFERAL_LEADS_ID'):'';
		$cekcbg = ($this->input->post('BRANCH'))?$this->input->post('BRANCH'):'';
		#echo "<pre>"; print_r($_REQUEST); 
		$jml_array = count ($_REQUEST); 
		$data = array();
		if($jml_array > 30)
		{
			$data1 = array_splice($_REQUEST,1,1);
			$data2 = array_splice($_REQUEST,1,1);
			$data3 = array_splice($_REQUEST,1,1);
			$data4 = array_splice($_REQUEST,1,13);
			$data5 = array_splice($_REQUEST,1,1);
			$data6 = array_splice($_REQUEST,1,5);
			$data7 = array_splice($_REQUEST,1,1);
			$data8 = array_splice($_REQUEST,1,6);
			$data9 = array_splice($_REQUEST,1,1);
			$data10 = array_splice($_REQUEST,1,1);
			$data11 = array_splice($_REQUEST,1,1);
			$data12 = array_splice($_REQUEST,1,1);
			$data13 = array_splice($_REQUEST,1,1);
		}
		#$cek_rtgs = array_splice($_REQUEST,31,1);
		$data_pros = array_merge($data1,$data2,$data3,$data4,$data5,$data6,$data7,$data8);
		$data_offe = array_merge($data1,$data3,$data5,$data7,$data10,$data11,$data13);
		##$data_rtgs = array_splice($_REQUEST);
		if($id == ''){
			$this->data_save($data_pros, 1, 'CUST_INDV_PROS');
			if($cek != '' && $cekcbg!=$_SESSION['BRANCH_ID'])
			{
				$this->data_save_offensive($data_offe,1, 'LEADS_OFFENSIVE');
			}elseif($cek != '' && $cekcbg==$_SESSION['BRANCH_ID'])
			{
				$this->data_save_offensive($data_offe,0, 'LEADS_OFFENSIVE');
			}
		} else {
			$tbl_name = (strlen($this->input->post('CIF_KEY')) < 9 )?'CUST_INDV_PROS':'CUST_INDV_PROS';
			$this->data_edit($id, $data_pros, $tbl_name);	
		}
		
		redirect('sales/cust_ind');
	}
	
	function save_cust_ind()
	{
		$readonly = $_POST['readonly'];
		unset($_POST['readonly']);
		$data = $_POST;
		$this->data_edit_cust_ind($readonly['CIF'], $data, 'CUSTOMER_SALES_DATA');
		redirect('sales/cust_ind');
	}
			
	function save_cust_corp()
	{		
		$id = ($this->input->post('ID'))?$this->input->post('ID'):'';
		if($id == ''){
			array_shift($_REQUEST);
			$data = $this->unset_array($_REQUEST);			
			$this->data_save_corp($data, 1, 'CUST_CORP');
		} else {
			$data = $this->unset_array($_REQUEST);
			$this->data_edit($id, $data, 'CUST_CORP');	
		}
		if(strlen($data['CIF_KEY']) < 9){		
			redirect('sales/cust_ind');
		} else { redirect('sales/cust_ind'); }
	}
	
	function save_cust_tele()
	{		
		$id = ($this->input->post('ID'));
		//echo $id;die();
		if($id == ''){
			array_shift($_REQUEST);
			$data = $this->unset_array($_REQUEST);			
			$this->data_save($data, 1, 'TELE_INBOUND');
		} else {
			$data = $this->unset_array($_REQUEST);
			$this->data_edit($id, $data, 'TELE_INBOUND');	
		}
		if(strlen($data['CIF_KEY']) < 9){		
			redirect('sales/cust_ind');
		} else { redirect('sales/cust_ind'); }
	}
	
	
	function unset_array($data){
		if (array_key_exists('ci_session', $data)) {
    		unset($data['ci_session']);
		}
		if (array_key_exists('PHPSESSID', $data)) {
    		unset($data['PHPSESSID']);
		}
		return $data;
	}
	
	
	function data_save($arr, $prospek = 0, $tbl_name)
	{
		$npp = $this->session->userdata('ID');
		$arrplus	= ($prospek == 1)?array('IS_PROSPECT'=>'1', 'BNI_SALES_ID'=>$npp):array('IS_PROSPECT'=>'0', 'BNI_SALES_ID'=>$npp);
		$arr 		= array_merge($arr, $arrplus);
		
		#echo "<pre>"; print_r($arr); die();
		$this->_sales->save($arr, $tbl_name );
	}
	
	function data_save_offensive($arr, $prospek = 0, $tbl_name)
	{
		$npp = $this->session->userdata('ID');
		$arrplus	= ($prospek == 1)?array( 'SALES_ID'=>0):array( 'SALES_ID'=>$npp);
		$arr 		= array_merge($arr, $arrplus);
		
		#echo "<pre>"; print_r($arr); die();
		$this->_sales->save_offensive($arr, $tbl_name );
	}
	
	function data_save_corp($arr, $prospek = 0, $tbl_name)
	{
		#array_pop($arr);
		$npp = $this->session->userdata('ID');
		$arrplus	= ($prospek == 1)?array('IS_PROSPECT'=>'1', 'BNI_SALES_ID'=>$npp):array('IS_PROSPECT'=>'0', 'BNI_SALES_ID'=>$npp);
		$arr 		= array_merge($arr, $arrplus);
		$this->_sales->save_corp($arr, $tbl_name );
	}
	
	function data_edit($id, $arr, $tbl_name)
	{
		$this->_sales->update($id, $arr, $tbl_name );
	}
	
	function data_edit_cust_ind($id, $arr, $tbl_name)
	{
		$this->_sales->update_cust_ind($id, $arr, $tbl_name );
	}
	
	
	
#---------------------------------
#	Create View for each grid	#
#---------------------------------
	
	function view_cust_ind($type, $id)
	{
		
		if($type==0)
		{
			$data['data'] = $this->_sales->get_data_cust($type, $id,'CUST_INDV_PROS');
			$view = 'cust_ind_view';
		}
		else
		{
			$data['data_pribadi'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_PRIBADI');
			$data['data_pekerjaan'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_PEKERJAAN');
			$data['data_pasangan'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_PASANGAN_ANAK');
			$data['data_bisnis'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_BISNIS');
			$data['data_lain'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_LAIN');
			$data['data_prod_bni'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_PROD_BNI');
			$data['data_prod_bank_lain'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_PROD_BANK_LAIN');
			$data['data_sales'] = $this->_sales->get_data_cust($type, $id,'VW_CUSTIND_DATA_SALES');
			$view = 'cust_ind_view_non_pros';
		}
		
		$this->load->view('sales/'.$view, $data);
	}
	
	function view_cust_corp($type, $id)
	{
		$data['data'] = $this->_sales->get_data_cust($type, $id,'CUST_CORP');
		$this->load->view('sales/cust_ind_corp', $data);
	}

#---------------------------------
#	Create Edit for each grid	#
#---------------------------------

	function edit_cust_ind($type, $id)
	{
		if($type == 0)
		{
			$data['bni_product']	=  $this->_sales->get_bni_product();
			$data['other_product']	=  $this->_sales->get_other_product($this->session->userdata('BRANCH_ID'));
			$view = 'cust_ind_pros_edit';
			$tbl_name = 'CUST_INDV_PROS';
		}
		else if($type == 1)
		{
			$data['param_relationship']	=  $this->_sales->get_param('relationship');
			$data['param_jabatan']	=  $this->_sales->get_param('jabatan');
			$data['param_biaya_hidup']	=  $this->_sales->get_param('biaya_hidup');
			$data['param_pekerjaan']	=  $this->_sales->get_param('pekerjaan');
			$data['param_rencana_keuangan']	=  $this->_sales->get_param('rencana_keuangan');
			$data['param_jk_rkeu']	=  $this->_sales->get_param('jk_rkeu');
			$data['param_org']	=  $this->_sales->get_param('org');
			$data['param_bank']	=  $this->_sales->get_param('nama_bank');
			$data['param_produk']	=  $this->_sales->get_param('produk_banklain');
			$data['param_hobby']	=  $this->_sales->get_param('hobby');
			$view = 'cust_ind_edit';
			$tbl_name = 'VW_CUSTOMER_UPDT';
		}
		
		$data['data'] = $this->_sales->get_data_cust($type ,$id,$tbl_name);
		$this->load->view('sales/'.$view, $data);
	}
	
	function edit_cust_tele($id)
	{
		$data['sales_id']	=  $this->_sales->get_branch_sales($this->session->userdata('BRANCH_ID'));
		$data['data'] = $this->_sales->get_data_tele($id);
		$this->load->view("sales/cust_tele_edit", $data);
	}
	
	function view_cust_tele($id)
	{
		//$data['sales_id']	=  $this->_sales->get_branch_sales($this->session->userdata('BRANCH_ID'));
		$data['data'] = $this->_sales->get_data_tele($id);
		$this->load->view("sales/cust_tele_view", $data);
	}
	
	function view_propensity($cif_key,$id)
	{
		$data['list_sales']=array();
		if($_SESSION['USER_LEVEL']=='PEMIMPINS'||$_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG')
		{
			//load model user
			$this->load->model('_user');
			foreach($this->_user->get_sales_by_cabang($_SESSION['BRANCH_ID']) as $row)
			{
				$data['list_sales'][$row->ID]="{$row->USER_NAME} ({$row->ID})";
			}
		}
		elseif($_SESSION['USER_LEVEL']=='SUPERVISOR')
		{
			$this->load->model('_user');
			foreach($this->_user->get_sales_by_spv($_SESSION['ID']) as $row)
			{
				$data['list_sales'][$row->ID]="{$row->USER_NAME} ({$row->ID})";
			}
		}
		
		$data['cif_key']=$cif_key;
		$data['id']=$id;
		$data['result'] = $this->_sales->get_detail_propensity($cif_key,$id);
		$this->load->view("sales/view_propensity", $data);
	}
	
	function view_offensive($id)
	{
		$data['list_sales']=array();
		if($_SESSION['USER_LEVEL']=='PEMIMPINS'||$_SESSION['USER_LEVEL']=='CABANG' || $_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' || $_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG')
		{
			//load model user
			$this->load->model('_user');
			foreach($this->_user->get_sales_by_cabang($_SESSION['BRANCH_ID']) as $row)
			{
				$data['list_sales'][$row->ID]="{$row->USER_NAME} ({$row->ID})";
			}
		}
		elseif($_SESSION['USER_LEVEL']=='SUPERVISOR')
		{
			$this->load->model('_user');
			foreach($this->_user->get_sales_by_spv($_SESSION['ID']) as $row)
			{
				$data['list_sales'][$row->ID]="{$row->USER_NAME} ({$row->ID})";
			}
		}
		
		$data['cif_key']=$cif_key;
		$data['id']=$id;
		$data['result'] = $this->_sales->get_detail_offensive($id);
		$this->load->view("sales/view_offensive", $data);
	}
	
	function edit_cust_corp($type, $id = '')
	{
		$data['data'] = $this->_sales->get_data_cust($id,'CUST_CORP');
		$this->load->view('sales/cust_corp_edit', $data);
	}
	
	function add_cust_corp()
	{
		$this->load->view('sales/cust_corp_edit');
	}
	
	function append_sales_propensity($id='', $sales_id='')
	{
		if($_SESSION['USER_LEVEL']=='PEMIMPINS'||$_SESSION['USER_LEVEL']=='CABANG' ||$_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' ||$_SESSION['USER_LEVEL']=='SUPERVISOR' )
		{
			$this->load->model('_sales');
			$this->load->model('_user');
			
			if($sales_id && $id)
			{
				//cek apakah sales di cabang ini
				if($this->_user->is_user_exists($sales_id, $_SESSION['BRANCH_ID']))
				{
					$this->_sales->save_leads_poropensity_sales($id, $sales_id, $_SESSION['BRANCH_ID']);
				}
			}
			redirect('sales/cust_ind');
		}
		else
		{
			show_404();
		}
	}
	
		function append_sales_offensive($id='', $sales_id='')
	{
		if($_SESSION['USER_LEVEL']=='PEMIMPINS'||$_SESSION['USER_LEVEL']=='CABANG' ||$_SESSION['USER_LEVEL']=='PIMPINAN_CABANG' ||$_SESSION['USER_LEVEL']=='PEMIMPIN_CABANG'||$_SESSION['USER_LEVEL']=='SUPERVISOR' )
		{
			$this->load->model('_sales');
			$this->load->model('_user');
			
			if($sales_id && $id)
			{
				//cek apakah sales di cabang ini
				if($this->_user->is_user_exists($sales_id, $_SESSION['BRANCH_ID']))
				{
					$this->_sales->save_leads_offensive_sales($id, $sales_id, $_SESSION['BRANCH_ID']);
				}
			}
			redirect('sales/cust_ind');
		}
		else
		{
			show_404();
		}
	}
}
?>
	