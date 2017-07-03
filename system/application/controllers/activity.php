<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Activity extends Controller {

	function Activity()
	{
		parent::Controller();
		$this->load->helper('flexigrid');
		$this->load->model('_activity');
		$this->load->model('_sales');
		$this->load->model('_log');
		$this->load->model('_handler');
		$this->load->model('_news');
		$this->load->model('_agenda_bm');
		
		$session_id = $_SESSION['ID'];
		date_default_timezone_set('Asia/Jakarta');		
		
		$now = date("Y-m-d H:i:s");	
		$this->_handler->update_session($now,$session_id);
		
		if($_SESSION['ID'] == ''){ redirect('login');}
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		$arrlvl = array('SALES', 'ADMIN', 'SUPERVISOR','CABANG', 'TIM', 'SLN', 'WILAYAH','PIMPINAN_CABANG','PIMPINAN_WILAYAH','PEMIMPIN_CABANG','PEMIMPIN_KLN-KK');
		//if( ! in_array($lvl,$arrlvl)) {redirect('forbiden/index/1');}
	}
	
//		function index_new($year = 0, $month = 0)
		function index_new()
	{
		
		//echo"ACTIVITY INDEX NEW";

$data = array(
'year' => $this->uri->segment(3),
'month' => $this->uri->segment(4)
);

// Creating template for table
$prefs['template'] = '
{table_open}<table cellpadding="1" cellspacing="2">{/table_open}

{heading_row_start}<tr>{/heading_row_start}

{heading_previous_cell}<th class="prev_sign"><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
{heading_next_cell}<th class="next_sign"><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

{heading_row_end}</tr>{/heading_row_end}

//Deciding where to week row start
{week_row_start}<tr class="week_name" >{/week_row_start}
//Deciding  week day cell and  week days
{week_day_cell}<td >{week_day}</td>{/week_day_cell}
//week row end
{week_row_end}</tr>{/week_row_end}

{cal_row_start}<tr>{/cal_row_start}
{cal_cell_start}<td>{/cal_cell_start}

{cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
{cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

{cal_cell_no_content}{day}{/cal_cell_no_content}
{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

{cal_cell_blank}&nbsp;{/cal_cell_blank}

{cal_cell_end}</td>{/cal_cell_end}
{cal_row_end}</tr>{/cal_row_end}

{table_close}</table>{/table_close}
';

$prefs['day_type'] = 'short';
$prefs['show_next_prev'] = true;
$prefs['next_prev_url'] = 'activity/index_new';

// Loading calendar library and configuring table template
$this->load->library('calendar', $prefs);
// Load view page
$this->load->view('activity/index_new', $data);
}


		
	

	
	
	function index($year = 0, $month = 0)
	{
		
		//ver lib
		
		/*
		 * 0 - display name
		 * 1 - width
		 * 2 - sortable
		 * 3 - align
		 * 4 - searchable (2 -> yes and default, 1 -> yes, 0 -> no.)
		 */

#------------------------------------------------	
#		staging list data
#------------------------------------------------		
/*
		$colModel['CIF'] 				= array('CIF',80,TRUE,'center',1);
		$colModel['CUST_NAME'] 			= array('NAMA',180,TRUE,'left',1);
		$colModel['SOURCE_DATA'] 		= array('DATA SOURCE',150,TRUE,'left',1);
		$colModel['PRODUCT_NAME'] 		= array('PRODUK',240,TRUE,'left',1);
		$colModel['USERID'] 		= array('SALES ID',50,TRUE,'left',2);
		foreach($this->_activity->get_staging_list() as $row)
		{
			$colModel[$row->STAGING_NAME] 		= array($row->STAGING_NAME,80,FALSE,'center',0);
		}
		

		$gridParams = array(
			//'width' 			=> 'auto',
			'width' 			=> 1040,
			'height' 			=> 300,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,20]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST DATA STAGING',
			'showTableToggleBtn'=> true
		);
		
		
		  //0 - display name
		  //1 - bclass
		  //2 - onpress
		 
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		
		$buttons[] = array('View','view','view');
		if($lvl == 'SALES')
		{
			$buttons[] = array('Add','add','addStage');
			$buttons[] = array('separator');
			$buttons[] = array('Next Staging','edit','nextStage');
		}
		#$buttons[] = array('Select All','add','sel');
		#$buttons[] = array('DeSelect All','delete','sel');
		#$buttons[] = array('separator');

		//Build js
		//View helpers/flexigrid_helper.php for more information about the params on this function
		$grid_js = build_grid_js('activity_list','',$colModel,'AS_OF_DATE','DESC',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;

*/
		$date 	= getdate();	 
		$year 	= ($year == 0)? $date['year']:$year;
		$month 	= ($month == 0)? $date['mon']:$month;
		$day 	= $date['mday'];
		$prefs = array (
					#'local_time' =>	time(),
               		'show_next_prev'  => TRUE,
               		'next_prev_url'   => site_url('/activity/index')
             );
/*
			 
		$prefs['template'] = '

		   {table_open}<table border="0" cellpadding="0" cellspacing="3">{/table_open}
		
		   {heading_row_start}<tr class="cal_head">{/heading_row_start}
		
		   {heading_previous_cell}<th height="30" align="center" valign="middle"><a href="{previous_url}" class="cal_next">&lt;&lt;</a></th>{/heading_previous_cell}
		   {heading_title_cell}<th colspan="{colspan}" align="center">{heading}</th>{/heading_title_cell}
		   {heading_next_cell}<th align="center" valign="middle"><a href="{next_url}" class="cal_next">&gt;&gt;</a></th>{/heading_next_cell}
		
		   {heading_row_end}</tr>{/heading_row_end}
		
		   {week_row_start}<tr  class="cal_week">{/week_row_start}
		   {week_day_cell}<td align="center" valign="middle" style="padding:5px">{week_day}</td>{/week_day_cell}
		   {week_row_end}</tr>{/week_row_end}
		
		   {cal_row_start}<tr>{/cal_row_start}
		   {cal_cell_start}<td style="border:1px solid #ddd" align="center" valign="middle" class="cal_td">{/cal_cell_start}
		
		   {cal_cell_content}<a href="{content}" class="cal_day" title="{day}-'.$month.'-'.$year.'" onclick="getAct(this.title)">{day}</a>{/cal_cell_content}
		   {cal_cell_content_today}<div class="cal_today_a"><a href="{content}"  title="{day}-'.$month.'-'.$year.'" onclick="getAct(this.title)">{day}</a></div>{/cal_cell_content_today}
		
		   {cal_cell_no_content}{day}{/cal_cell_no_content}
		   {cal_cell_no_content_today}<div class="cal_today">{day}</div>{/cal_cell_no_content_today}
		
		   {cal_cell_blank}&nbsp;{/cal_cell_blank}
		
		   {cal_cell_end}</td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}
		
		   {table_close}</table>{/table_close}
		';
		$this->load->library('calendar', $prefs);
		
		$npp = $this->session->userdata('ID');		
		$arr = array('M'=>$month,'Y'=>$year);
		$data['month'] = $date['month'];
		$data['year'] 	= $date['year'];
		
		$rows = $this->_activity->get_act_items($arr);		
		$datas = array();
		foreach($rows as $rs){
			$datas[$rs->D] = '#';
		}
		
		$data['calendar'] = $this->calendar->generate($year, $month, $datas);
*/		
		
$prefs['template'] = '
{table_open}<table cellpadding="1" cellspacing="2">{/table_open}

{heading_row_start}<tr>{/heading_row_start}

{heading_previous_cell}<th class="prev_sign"><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
{heading_next_cell}<th class="next_sign"><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

{heading_row_end}</tr>{/heading_row_end}

//Deciding where to week row start
{week_row_start}<tr class="week_name" >{/week_row_start}
//Deciding  week day cell and  week days
{week_day_cell}<td >{week_day}</td>{/week_day_cell}
//week row end
{week_row_end}</tr>{/week_row_end}

{cal_row_start}<tr>{/cal_row_start}
{cal_cell_start}<td>{/cal_cell_start}

{cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
{cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

{cal_cell_no_content}{day}{/cal_cell_no_content}
{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

{cal_cell_blank}&nbsp;{/cal_cell_blank}

{cal_cell_end}</td>{/cal_cell_end}
{cal_row_end}</tr>{/cal_row_end}

{table_close}</table>{/table_close}
';

// Loading calendar library and configuring table template
$this->load->library('calendar', $prefs);
$data['calendar'] = $this->calendar->generate($year, $month);
// Load view page
$this->load->view('activity/index', $data);


		
		
		//print layout
//		$this->load->view('activity/index',$data);		
//		$this->load->view('activity/index');		
	}

#------------------------------------------------
#	   Get items Activity		
#------------------------------------------------
function get_ajax($id)
{
	//format id yg dikirim : 30-12-2010
	$npp = $this->session->userdata('ID');
	
	$tgl = explode('-',$id);
	$data = array('D'=>$tgl[0],'M'=>$tgl[1],'Y'=>$tgl[2]);
	$result = $this->_activity->get_act_items($data);
	$html = '';
	foreach($result as $row){
		$html .= '<div class="item_act"><a href="'.site_url('/activity/edit/'.$row->ID).'">';
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		if($lvl <> 'SALES')
			$html .= "<span style='color:#800'>".$row->USERID." : ".strtoupper($row->USER_NAME)."</span><br />";
		$html .= "<b>".$row->CUST_NAME." (".$row->CIF_KEY. ") - Pukul. ".$row->H.":".$row->I." WIB </b> ";
		$html .= '<span style="color:#1761a0">'.$row->STAGING_NAME.'</span><br /><div class="purpose"><img src="'.ICONS.'pencil_blue.gif" border=0> '.$row->KETERANGAN.'</div></a></div>';
	}
	echo $html;
}


#------------------------------------------------
#	   Activity save			
#------------------------------------------------	
	function save()
	{
		if($_REQUEST){
			$tgl					= date('d-m-Y',strtotime($this->input->post('DATE_CREATED')));
			#print_r($tgl);die();
			$tgl_realisasi			= ($this->input->post('REALISATION') == 0)?'':date('d-M-y');
			$data					= array();
			#$data['ID'] 			= $this->input->post('ID');	
			$cif					= (strlen($this->input->post('CIF_KEY'))<9)?'':$this->input->post('CIF_KEY');
			$data['USERID'] 		= $this->session->userdata('ID');				
			$data['CIF_KEY ']		= $cif;
			$data['CUST_NAME'] 		= $this->input->post('CUST_NAME');
			$data['TANGGAL']	 	= date('d-M-y',strtotime($tgl));		
			$data['D'] 				= substr($tgl,0,2);
			$data['M'] 				= substr($tgl,3,2);
			$data['Y'] 				= substr($tgl,6,4);
			$data['H'] 				= $this->input->post('H');
			$data['I'] 				= $this->input->post('I');
			$data['PRODUK_ID'] 		= $this->input->post('PRODUK_ID');
			$data['STAGING_ID'] 	= $this->input->post('STAGING_ID');
			$data['KETERANGAN'] 	= $this->input->post('KETERANGAN');
			$data['REALISASI'] 	= $this->input->post('REALISASI');
			
			#echo "<pre>";print_r($data); #die();
			if($this->input->post('ID')<>''){
				$data['DATE_UPDATED'] 	= date('d-M-Y H:i:s');
				$this->_activity->update($this->input->post('ID'), $data, 'AGENDA' );
				
				#-------------------------------
				#	LOG USER ACTIVITY
				#-------------------------------
				$log = array();
				$log['NPP'] 			= $this->session->userdata('ID');
				$log['ACTION'] 			= 'UPDATE';
				$log['INFO'] 			= 'DAILY ACTIVITY ID = '.$this->input->post('ID').' ['.$this->input->post('CUST_NAME').']';
				$log['DATE_CREATED'] 	= date('d-M-Y H:i:s');
				$this->_log->logs($log);
				
				
 			} else {
				$data['DATE_CREATED'] 	= date('d-M-Y  H:i:s');
				$this->_activity->save($data, 'AGENDA' );
				
				#-------------------------------
				#	LOG USER ACTIVITY
				#-------------------------------
				$log = array();
				$log['NPP'] 			= $this->session->userdata('ID');
				$log['ACTION'] 			= 'INSERT';
				$log['INFO'] 			= 'DAILY ACTIVITY ['.$this->input->post('CUST_NAME').']';
				$log['DATE_CREATED'] 	= date('d-M-Y H:i:s');
				$this->_log->logs($log);
				
			}
		}
		redirect('activity');
	}


#------------------------------------------------
#	   Save Comment	
#------------------------------------------------	
	function save_comment()
	{
		$npp = $this->session->userdata('ID');
		$tgl = NOW;
		$comment = "$tgl <br> $npp <br> ".$this->input->post('komentar')."<br>";
		$id = $this->input->post('IDS');
		$hasil = '';
		$result = $this->_activity->get_data_act($id,'DAILY_ACTIVITY');
		if($result)
		{
			$order   = array("\r\n", "\n", "\r");
			$comment = str_replace($order, ' ', $comment."<br />".$result[0]['COMMENTS']);
			
			$data = array('COMMENTS'=>$comment);
			$this->_activity->update($id, $data, 'DAILY_ACTIVITY');
			$result = $this->_activity->get_data_act($id,'DAILY_ACTIVITY');
			$hasil = ($result)?$result[0]['COMMENTS']:'';
		}		
		echo $hasil;
	}
	
#------------------------------------------------
#	Create View & add for each grid	
#------------------------------------------------	
	function view($id='')
	{
		$pipeline_id=(int) $id;
		$data['data'] = $this->_activity->get_pipeline_master_detail($pipeline_id);
		if(empty($data['data'])){show_404();}
		$data['list_staging']=$this->_activity->get_pipeline_staging($pipeline_id);
		$data['list_komentar']=$this->_activity->get_list_pipeline_comment($pipeline_id);
		
		$this->load->view('activity/view', $data);
	}
	
	function edit($id = '')
	{
		$colModel['ID'] 				= array('ID',40,TRUE,'center',1);
		$colModel['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel['NAMA_NASABAH'] 			= array('NAMA',250,TRUE,'left',2);

		$gridParams = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST CUSTOMER',
			'showTableToggleBtn'=> TRUE
		);

		$buttons[] = array('Pilih','add','pilih_data');
		$buttons[] = array('separator');

		$grid_js = build_grid_js('search_list',site_url("/activity_ajax/search"),$colModel,'NAMA_NASABAH','ASC',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;
		
		$colModel2['ID'] 				= array('ID',100,TRUE,'center',0);
		$colModel2['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel2['CUST_NAME'] 		= array('NAMA',250,TRUE,'left',2);

		$gridParams2 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST CUSTOMER',
			'showTableToggleBtn'=> false
		);

		$buttons2[] = array('Pilih','add','pilih_data');
		$buttons2[] = array('separator');

		$grid_js2 = build_grid_js('search_list2',site_url("/activity_ajax/search_pros"),$colModel2,'CUST_NAME','ASC',$gridParams2,$buttons2);
		
		$data['js_grid_2'] = $grid_js2;
		
		//telesales
		$colModel3['ID'] 				= array('ID',50,TRUE,'center',0);
		$colModel3['CIF'] 				= array('CIF',60,TRUE,'center',1);
		$colModel3['NAMA'] 				= array('NAMA',250,TRUE,'left',2);
		$colModel3['JENIS_PRODUK']      = array('JENIS_PRODUK',200,TRUE,'center',2);

		$gridParams3 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST LEADS 500046',
			'showTableToggleBtn'=> false
		);

		$buttons3[] = array('Pilih','add','pilih_data');
		$buttons3[] = array('separator');

		$grid_js3 = build_grid_js('search_list3',site_url("/activity_ajax/search_tele"),$colModel3,'NAMA','ASC',$gridParams3,$buttons3);
		
		$data['js_grid_3'] = $grid_js3;
		//
		
		//propensity
		$colModel4['CIF_KEY'] 	= array('CIF_KEY',60,TRUE,'center',1);
		$colModel4['NAMA'] 		= array('NAMA',150,TRUE,'left',2);
		$colModel4['PRODUK']    = array('PRODUK',200,TRUE,'center',2);

		$gridParams4 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST LEADS Propensity',
			'showTableToggleBtn'=> false
		);

		$buttons4[] = array('Pilih','add','pilih_data_1');
		$buttons4[] = array('separator');

		$grid_js4 = build_grid_js('search_list4',site_url("/activity_ajax/search_propensity"),$colModel4,'NAMA','ASC',$gridParams4,$buttons4);
		
		$data['js_grid_4'] = $grid_js4;
		//
		
		$data['product']	=  $this->_activity->get_product_item();
		$data['activity']	=  $this->_activity->get_activity_item();
		$data['response']	=  $this->_activity->get_response_item();
		if($id){
			$data['data']		=  $this->_activity->get_data_act($id, 'AGENDA');
		}
		
		$data['product_list']=$this->_activity->get_pipe_produk();
		$data['staging_list']=$this->_activity->get_staging_list();
		
		$this->load->view("activity/edit", $data);
	}
	
	function add_stage()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		if($lvl <> 'SALES'){show_404();}
		
		if($this->input->post('save'))
		{
			//save pipeline_master
			$data['LEADS_ID']=$this->input->post('LEADS_ID');
			$data['CIF']=$this->input->post('CIF')? $this->input->post('CIF'):null;
			$data['CUST_NAME']=$this->input->post('CUST_NAME');
			$data['SOURCE_ID']=$this->input->post('SOURCE_ID');
			$data['PRODUCT_ID']=$this->input->post('PRODUCT_ID');
			$data['CAT_ID']=$this->input->post('CAT_ID');
			$data['USERID']=$_SESSION['ID'];
			
			if($data['PIPELINE_ID']=$this->_activity->save_pipeline_master($data))
			{
				//$data['AS_OF_DATE']=date('d-m-Y').' '.$this->input->post('JAM').':'.$this->input->post('MENIT').':00';
				$data['AS_OF_DATE']=$this->input->post('TANGGAL').' '.$this->input->post('JAM').':'.$this->input->post('MENIT').':00';
				$data['STAGING_ID']=$this->input->post('STAGING_ID');
				$data['NOMINAL']=preg_replace("#[^0-9\.]#", '', $this->input->post('NOMINAL'));
				$this->_activity->save_pipeline_staging($data);
			}
			
			$this->_activity->update_source_staging($data);
			redirect('activity#tabs-1');
		}
		
		$colModel['ID'] 				= array('ID',40,TRUE,'center',1);
		$colModel['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel['NAMA_NASABAH'] 			= array('NAMA',250,TRUE,'left',2);

		$gridParams = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST CUSTOMER',
			'showTableToggleBtn'=> TRUE
		);

		$buttons[] = array('Pilih','add','pilih_data');
		$buttons[] = array('separator');

		$grid_js = build_grid_js('search_list',site_url("/activity_ajax/search"),$colModel,'NAMA_NASABAH','ASC',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;
		
		$colModel2['ID'] 				= array('ID',100,TRUE,'center',0);
		$colModel2['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel2['CUST_NAME'] 		= array('NAMA',250,TRUE,'left',2);

		$gridParams2 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST CUSTOMER',
			'showTableToggleBtn'=> false
		);

		$buttons2[] = array('Pilih','add','pilih_data2');
		$buttons2[] = array('separator');

		$grid_js2 = build_grid_js('search_list2',site_url("/activity_ajax/search_pros"),$colModel2,'CUST_NAME','ASC',$gridParams2,$buttons2);
		
		$data['js_grid_2'] = $grid_js2;
		
		//tele
		$colModel3['ID'] 				= array('ID',100,TRUE,'center',0);
		$colModel3['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel3['NAMA'] 		= array('NAMA',250,TRUE,'left',2);

		$gridParams3 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST CUSTOMER',
			'showTableToggleBtn'=> false
		);

		$buttons3[] = array('Pilih','add','pilih_data3');
		$buttons3[] = array('separator');

		$grid_js3 = build_grid_js('search_list3',site_url("/activity_ajax/search_tele"),$colModel3,'NAMA','ASC',$gridParams3,$buttons3);
		
		$data['js_grid_3'] = $grid_js3;
		
		//propensiti
		$colModel4['ID'] 				= array('ID',20,TRUE,'center',0);
		$colModel4['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel4['NAMA'] 		= array('NAMA',150,TRUE,'left',2);
		$colModel4['PRODUK'] 		= array('PRODUK',150,TRUE,'left',2);

		$gridParams4 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST PROPENSITY',
			'showTableToggleBtn'=> false
		);

		$buttons4[] = array('Pilih','add','pilih_data4');
		$buttons4[] = array('separator');

		$grid_js4 = build_grid_js('search_list4',site_url("/activity_ajax/search_propensity"),$colModel4,'NAMA','ASC',$gridParams4,$buttons4);
		
		$data['js_grid_4'] = $grid_js4;
		
		//offensive
		$colModel5['ID'] 				= array('ID',20,TRUE,'center',0);
		$colModel5['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel5['NAMA'] 		= array('NAMA',150,TRUE,'left',2);
		$colModel5['PRODUK'] 		= array('PRODUK',150,TRUE,'left',2);

		$gridParams5 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST OFFENSIVE',
			'showTableToggleBtn'=> false
		);

		$buttons5[] = array('Pilih','add','pilih_data5');
		$buttons5[] = array('separator');

		$grid_js5 = build_grid_js('search_list5',site_url("/activity_ajax/search_offensive"),$colModel5,'CUST_NAME','ASC',$gridParams5,$buttons5);
		
		$data['js_grid_5'] = $grid_js5;
		
		$data['propensity_source_id']=10;
		$data['tele_source_id']=20;
		$data['kelolaan_source_id']=30;
		$data['prospek_source_id']=40;
		$data['offensive_source_id']=60;
		
		$data['list_category']=$this->_activity->get_pipeline_category();
		$data['list_produk']=$this->_activity->get_pipe_produk_json();
		
		$this->load->view("activity/add_stage", $data);
	}
	
	function next_stage($id = '')
	{
		$data['id']=(int) $id;
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		if($lvl != 'SALES' || !$data['id'])
		{
			show_404();
		}
		
		$data['data']=$this->_activity->get_next_stage_data($id);
		if(empty($data['data']) || empty($data['data']['STAGING']))
		{
			redirect('activity');
		}
		
		if($this->input->post('save'))
		{
			$save['PIPELINE_ID']=$data['id'];
			//$save['AS_OF_DATE']=date('d-m-Y').' '.$this->input->post('JAM').':'.$this->input->post('MENIT').':00';
			$save['AS_OF_DATE']=$this->input->post('TANGGAL').' '.$this->input->post('JAM').':'.$this->input->post('MENIT').':00';
			$save['STAGING_ID']=$this->input->post('STAGING_ID');
			$save['NOMINAL']=$data['data']['NOMINAL_WAJIB_ISI']? preg_replace("#[^0-9\.]#", '', $this->input->post('NOMINAL')):null;
			$save['NOAPLIKASI']=$data['data']['NO_APLIKASI_WAJIB_ISI']? preg_replace("#[^0-9\.]#", '', $this->input->post('NOAPLIKASI')):null;
			$save['NOCIF']=$data['data']['NO_CIF_WAJIB_ISI']? preg_replace("#[^0-9\.]#", '', $this->input->post('NOCIF')):null;
			
			$this->_activity->save_pipeline_staging($save);
			redirect('activity#tabs-1');
		}
		
		$this->load->view("activity/next_stage", $data);
	}
	
	#ADD ACCOUNT PLANNING
	function add_account_planning()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		if($lvl<>'SALES'){show_404();}

		if($this->input->post('save'))
		{
			//save new_account_planning
			$data['CIF']=$this->input->post('CIF')? $this->input->post('CIF'):null;
			$data['CUST_NAME']=$this->input->post('CUST_NAME');
			$data['PRODUCT_ID']=$this->input->post('PRODUCT_ID');
			$data['CAT_ID']=$this->input->post('CAT_ID');
			$data['RENCANA']=preg_replace("#[^0-9\.]#", '', $this->input->post('RENCANA'));
			$data['TARGET']=preg_replace("#[^0-9\.]#", '', $this->input->post('TARGET'));
			$data['USERID']=$_SESSION['ID'];
			$data['AS_OF_DATE']=$this->input->post('DATE');
			$data['MONTH']=$this->input->post('M');
			$data['YEAR']=$this->input->post('Y');
			$data['ID']=$this->input->post('ID');
			$this->_activity->save_account_planning($data);
			
			redirect('account_planning/list_account_planning');
		}
		#Leads Kelolaan
		$colModel['ID'] 				= array('ID',40,TRUE,'center',1);
		$colModel['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel['NAMA_NASABAH'] 			= array('NAMA',250,TRUE,'left',2);

		$gridParams = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST CUSTOMER',
			'showTableToggleBtn'=> TRUE
		);

		$buttons[] = array('Pilih','add','pilih_data');
		$buttons[] = array('separator');

		$grid_js = build_grid_js('search_list',site_url("/activity_ajax/search"),$colModel,'NAMA_NASABAH','ASC',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;
		#leads prospek
		$colModel2['ID'] 				= array('ID',100,TRUE,'center',0);
		$colModel2['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel2['CUST_NAME'] 		= array('NAMA',250,TRUE,'left',2);

		$gridParams2 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST CUSTOMER',
			'showTableToggleBtn'=> false
		);

		$buttons2[] = array('Pilih','add','pilih_data2');
		$buttons2[] = array('separator');

		$grid_js2 = build_grid_js('search_list2',site_url("/activity_ajax/search_pros"),$colModel2,'CUST_NAME','ASC',$gridParams2,$buttons2);
		
		$data['js_grid_2'] = $grid_js2;
		#Leads 1500046
		$colModel3['ID'] 				= array('ID',40,TRUE,'center',1);
		$colModel3['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel3['NAMA'] 			= array('NAMA',250,TRUE,'left',2);

		$gridParams3 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST CUSTOMER',
			'showTableToggleBtn'=> TRUE
		);

		$buttons3[] = array('Pilih','add','pilih_data3');
		$buttons3[] = array('separator');

		$grid_js3 = build_grid_js('search_list3',site_url("/activity_ajax/search_tele"),$colModel3,'NAMA_NASABAH','ASC',$gridParams3,$buttons3);
		
		$data['js_grid_3'] = $grid_js3;
		#Leads propensity
		$colModel4['ID'] 				= array('ID',40,TRUE,'center',1);
		$colModel4['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel4['NAMA'] 			= array('NAMA',250,TRUE,'left',2);

		$gridParams4 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST CUSTOMER',
			'showTableToggleBtn'=> TRUE
		);

		$buttons4[] = array('Pilih','add','pilih_data4');
		$buttons4[] = array('separator');

		$grid_js4 = build_grid_js('search_list4',site_url("/activity_ajax/search_propensity"),$colModel4,'NAMA_NASABAH','ASC',$gridParams4,$buttons4);
		
		$data['js_grid_4'] = $grid_js4;
		#source leads
		$data['propensity_source_id']=10;
		$data['tele_source_id']=20;
		$data['kelolaan_source_id']=30;
		$data['prospek_source_id']=40;
		
		$data['list_category']=$this->_activity->get_pipeline_category();
		$data['list_produk']=$this->_activity->get_pipe_produk_json();
		
		$this->load->view("account_planning/add", $data);
	}
	
	#ADD ACCOUNT PLANNING
	function add_tap()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		if($lvl <> 'SALES'){show_404();}
		
		if($this->input->post('save'))
		{
			//save new_account_planning
			$data['CIF']=$this->input->post('CIF')? $this->input->post('CIF'):null;
			$data['CUST_NAME']=$this->input->post('CUST_NAME');
			$data['PRODUCT_ID']=$this->input->post('PRODUCT_ID');
			$data['CAT_ID']=$this->input->post('CAT_ID');
			$data['TARGET']=preg_replace("#[^0-9\.]#", '', $this->input->post('TARGET'));
			$data['USERID']=$_SESSION['ID'];
			$data['AS_OF_DATE']=$this->input->post('DATE');
			$data['MONTH']=$this->input->post('M');
			$data['YEAR']=$this->input->post('Y');
			$data['ID']=$this->input->post('ID');
			$this->_activity->save_tap($data);
			
			redirect('tap/list_tap');
		}
		
		$colModel['ID'] 				= array('ID',40,TRUE,'center',1);
		$colModel['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel['NAMA_DEBITUR'] 			= array('NAMA_DEBITUR',250,TRUE,'left',2);

		$gridParams = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST DEBITUR',
			'showTableToggleBtn'=> TRUE
		);

		$buttons[] = array('Pilih','add','pilih_data');
		$buttons[] = array('separator');

		$grid_js = build_grid_js('search_list',site_url("/activity_ajax/search_debitur"),$colModel,'NAMA_DEBITUR','ASC',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;
		
		$colModel2['ID'] 				= array('ID',100,TRUE,'center',0);
		$colModel2['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel2['CUST_NAME'] 		= array('NAMA',250,TRUE,'left',2);

		$gridParams2 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST DEBITUR PROSPEK',
			'showTableToggleBtn'=> false
		);

		$buttons2[] = array('Pilih','add','pilih_data2');
		$buttons2[] = array('separator');

		$grid_js2 = build_grid_js('search_list2',site_url("/activity_ajax/search_debitur_pros"),$colModel2,'CUST_NAME','ASC',$gridParams2,$buttons2);
		
		$data['js_grid_2'] = $grid_js2;
		
		$data['propensity_source_id']=10;
		$data['tele_source_id']=20;
		$data['kelolaan_source_id']=30;
		$data['prospek_source_id']=40;
		
		$data['list_category']=$this->_activity->get_pipeline_category();
		$data['list_produk']=$this->_activity->get_pipe_produk_json();
		
		$this->load->view("tap/add", $data);
	}
	
	#ADD ACCOUNT PLANNING
	function add_account_planning_bm()
	{
		$lvl = ($_SESSION['USER_LEVEL'] != '')?$_SESSION['USER_LEVEL']:'';
		//if($lvl<>'SALES'){show_404();}

		if($this->input->post('save'))
		{
			//save new_account_planning
			$data['CIF']=$this->input->post('CIF')? $this->input->post('CIF'):null;
			$data['CUST_NAME']=$this->input->post('CUST_NAME');
			$data['PRODUCT_ID']=$this->input->post('PRODUCT_ID');
			$data['CAT_ID']=$this->input->post('CAT_ID');
			$data['RENCANA']=preg_replace("#[^0-9\.]#", '', $this->input->post('RENCANA'));
			#$data['TARGET']=preg_replace("#[^0-9\.]#", '', $this->input->post('TARGET'));
			$data['USERID']=$_SESSION['ID'];
			$data['AS_OF_DATE']=$this->input->post('DATE');
			$data['WEEK']=$this->input->post('WEEK');
			$data['MONTH']=$this->input->post('M');
			$data['YEAR']=$this->input->post('Y');
			$data['ID']=$this->input->post('ID');
			$this->_activity->save_account_planning_bm($data);
			
			redirect('account_planning/list_account_planning_bm');
		}
		
		$colModel['ID'] 				= array('ID',40,TRUE,'center',1,TRUE);
		$colModel['CIF_KEY'] 			= array('CIF',70,TRUE,'center',1);
		$colModel['NAMA_NASABAH'] 			= array('NAMA',250,TRUE,'left',2);

		$gridParams = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST CUSTOMER',
			'showTableToggleBtn'=> TRUE
		);

		$buttons[] = array('Pilih','add','pilih_data');
		$buttons[] = array('separator');

		$grid_js = build_grid_js('search_list',site_url("/activity_ajax/search_top_20_10"),$colModel,'NAMA_NASABAH','ASC',$gridParams,$buttons);
		
		$data['js_grid'] = $grid_js;
		
		$colModel2['ID'] 				= array('ID',100,TRUE,'center',0);
		$colModel2['CIF_KEY'] 			= array('CIF',60,TRUE,'center',1);
		$colModel2['CUST_NAME'] 		= array('NAMA',250,TRUE,'left',2);

		$gridParams2 = array(
			'width' 			=> 425,
			'height' 			=> 150,
			'rp' 				=> 10,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> '{from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> 'LIST CUSTOMER',
			'showTableToggleBtn'=> false
		);

		$buttons2[] = array('Pilih','add','pilih_data2');
		$buttons2[] = array('separator');

		$grid_js2 = build_grid_js('search_list2',site_url("/activity_ajax/search_pros"),$colModel2,'CUST_NAME','ASC',$gridParams2,$buttons2);
		
		$data['js_grid_2'] = $grid_js2;
		
		$data['propensity_source_id']=10;
		$data['tele_source_id']=20;
		$data['kelolaan_source_id']=30;
		$data['prospek_source_id']=40;
		
		$data['list_category']=$this->_activity->get_pipeline_category();
		$data['list_produk']=$this->_activity->get_pipe_produk_json();
		
		$this->load->view("account_planning/add_bm", $data);
	}
}
?>
