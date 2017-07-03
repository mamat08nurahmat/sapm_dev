<?php
class phr_user extends Controller {

	function phr_user()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form', 'file','flexigrid','html','array'));
        $this->load->library(array('table','validation', 'session', 'ldap', 'nusoap_loader','form_validation','flexigrid'));
		$this->load->model('_phr_user', 'phr_user', TRUE);

		date_default_timezone_set('Asia/Jakarta');

		if($_SESSION['USERNAME'] == ''){ redirect('login_phr_nasabah/logout/');}

	}

	// function index()
	// {
		// $id_user = $_SESSION['ID'];
		// $data['tampil'] = $this->phr_user->getAll($id_user);
        // $this->load->view("phr_user_view", $data);
	// }
	
	function index()
	{
		// $connection = $this->load->database('default', TRUE);
		// if ($connection){
		// 	echo "Connection Success"; die();
		// }
		// else{
		// 	echo "Connection Failed"; die();
		// }
		$this->load->helper('form');
		$this->load->helper('html');
		
		$colModel['NPP'] 	    = array('NPP',80,TRUE,'center',1);
        $colModel['USERNAME']   = array('USERNAME',200,TRUE,'left',1);
        $colModel['EMAIL'] 	    = array('EMAIL',250,TRUE,'left',1);
        $colModel['STATUS']     = array('STATUS',250,TRUE,'left',1);
        $colModel['CABANG']  	= array('CABANG',150,TRUE,'left',1);
        $colModel['NAMA_ROLE']  = array('NAMA_ROLE',100,TRUE,'left',1);

		$gridParams = array(
			//'width' 			=> 'auto',
			'width' 			=> 'auto', //610
			'height' 			=> 300,
			'rp' 				=> 11,
			'rpOptions' 		=> '[10,25,50,100]',
			'pagestat' 			=> 'Displaying: {from} to {to} of {total} items.',
			'blockOpacity' 		=> 0.5,
			'title' 			=> '',
			'showTableToggleBtn'=> true
		);

		/*
		 * 0 - display name
		 * 1 - bclass
		 * 2 - onpress
		 */
		$buttons[] = array('Add','add','add');
		$buttons[] = array('Edit','edit','edit');
		$buttons[] = array('Delete','delete','del');
		//$buttons[] = array('separator');
		#$buttons[] = array('Delete','delete','del');
		#$buttons[] = array('Select All','add','sel');
		#$buttons[] = array('DeSelect All','delete','sel');
		#$buttons[] = array('separator');

		$grid_js = build_grid_js('result_list',site_url("/phr_user/ajax_list/"),$colModel,'NPP','DESC',
			$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

		$this->load->view('phruser/index',$data);
		
	}
	
	function ajax_list()
	{
		
		$valid_fields = array('NPP','USERNAME','EMAIL','STATUS','CABANG','NAMA_ROLE');
		
		$this->flexigrid->validate_post('NPP','asc',$valid_fields);
		$records = $this->phr_user->getList();
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
			
			$record_items[] = array($row->NPP,
				$row->NPP,
				$row->USERNAME,
				$row->EMAIL,
				$row->STATUS,
				$row->CABANG,
				$row->NAMA_ROLE
			);
		}
		
		//Print please
		if (isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
        else
         	$this->output->set_output('{"page":"1","total":"0","rows":[]}');
		
		
	}

	function add_user()
	{
		$id_user = $_SESSION['ID'];
		$data['lookuprole'] = $this->phr_user->getLookupRole($id_user);
		$this->load->view('phruser/phr_user_add', $data);
	}

	function save_user_action()
	{
		$id_user       = strtoupper($this->input->post('npp'));
		$nama_user     = $this->input->post('nama_user');
		$email         = $this->input->post('email');
		$id_unit       = $this->input->post('id_unit');
		$level         = $this->input->post('level');
		$created_by    = $_SESSION['ID'];
		$modified_by   = $_SESSION['ID'];


		$cek = $this->phr_user->cekUser($id_user);
		if ($cek->num_rows() > 0) {
			?>
			<script type="text/javascript">
				alert("User sudah ada! ");
				var urls = '<?php echo site_url('/phr_user/')?>';
				window.location.replace(urls)
			</script>
			<?php
			echo "user sudah ada";
		}
		else {

			$this->phr_user->insertUser($id_user, $nama_user, $email, $id_unit, $level, $created_by);


			$this->session->set_flashdata("pesan","<div class='alert alert-block alert-success'>
										 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>

										<p>
											<strong>
												<i class='icon-ok'></i>
												Tambah
											</strong>
											Data berhasil...!
										</p>
									</div>");

			redirect('phr_user');

			//echo "belum ada";
		}
	}

	function edt_user()
	{
		$id_user = $_SESSION['ID'];
		$data['lookuprole'] = $this->phr_user->getLookupRole($id_user);
		$id = $this->uri->segment(3);
		$data['usertax'] = $this->phr_user->selectByUser($id)->row();
		$this->load->view('phruser/phr_user_edit', $data);
	}

	function update_user()
	{
		$id_user       = $this->input->post('npp');
		$nama_user     = $this->input->post('nama_user');
		$email         = $this->input->post('email');
		$id_unit       = $this->input->post('id_unit');
		$level         = $this->input->post('level');
		$status        = $this->input->post('status');
		$modified_by   = $_SESSION['ID'];

		$this->phr_user->updateUser($id_user, $nama_user, $email, $id_unit, $level, $status, $modified_by);

		$this->session->set_flashdata("pesan","<div class='alert alert-block alert-success'>
										 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>

										<p>
											<strong>
												<i class='icon-ok'></i>
												Update
											</strong>
											Data berhasil...!
										</p>
									</div>");

		redirect('phr_user');

	}

	function del_user($id)
	{

		$this->phr_user->deleteUser($id);

		$this->session->set_flashdata("pesan","<div class='alert alert-block alert-success'>
										 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>

										<p>
											<strong>
												<i class='icon-ok'></i>
												Hapus
											</strong>
											Data berhasil...!
										</p>
									</div>");

		redirect('phr_user');
	}

	function cari_unit()
	{
		//$id_user = $_SESSION['ID'];
		$cari = $this->input->post('cariunit');
		$data['unit'] = $this->phr_user->searchUnit($cari);
		$this->load->view('pencarian_unitid', $data);
	}


}
/* End of file visit.php */
/* Location: ./system/application/controllers/visit.php */

?>
