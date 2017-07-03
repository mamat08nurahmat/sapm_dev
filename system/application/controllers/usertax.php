<?php
class Usertax extends Controller {

	function Usertax()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form', 'download'));
        $this->load->library(array('table','validation', 'session', 'ldap'));
		$this->load->model('_usertax', 'usertax', TRUE);
		$this->load->model('_logtax', 'log', TRUE);
		$this->load->model('_lookup_tax_amnesty', 'lookuptax');

		//apabila suda tidak ada session . redirect kelogin
		if($_SESSION['ID'] == ''){ redirect('login_tax_amnesty/logout/');}

		date_default_timezone_set('Asia/Jakarta');
	}

	function index()
	{
		$id_user = $_SESSION['ID'];
		$data['tampil'] = $this->usertax->getAll($id_user);
		$this->load->view('taxuser/index', $data);
	}

	function tambah_usertax()
	{
		$id_user = $_SESSION['ID'];
		$data['lookuprole'] = $this->lookuptax->getLookupRole($id_user);
		$this->load->view('taxuser/form_tambah_usertax', $data);
	}

	function proses_tambah_usertax()
	{
		$id_user       = strtoupper($this->input->post('npp'));
		$nama_user     = $this->input->post('nama_user');
		$email         = $this->input->post('email');
		$id_unit       = $this->input->post('id_unit');
		$level         = $this->input->post('level');
		$created_by    = $_SESSION['ID'];
		$modified_by   = $_SESSION['ID'];


		$cek = $this->usertax->cekUser($id_user);
		if ($cek->num_rows() > 0) {
			?>
			<script type="text/javascript">
				alert("User sudah ada! ");
				var urls = '<?php echo site_url('/usertax/')?>';
				window.location.replace(urls)
			</script>
			<?php
			echo "user sudah ada";
		}
		else {
			//buat insert log
			$create_by = $_SESSION['ID'];
			$action = "Telah Melakukan Operasi Tambah User Dengan ID_USER = $id_user";
			$this->log->insertLog($create_by, $action);

			$this->usertax->insertUser($id_user, $nama_user, $email, $id_unit, $level, $created_by);


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

			redirect('usertax');

			//echo "belum ada";
		}



	}

	function edit_usertax()
	{
		$id_user = $_SESSION['ID'];
		$data['lookuprole'] = $this->lookuptax->getLookupRole($id_user);
		$id = $this->uri->segment(3);
		$data['usertax'] = $this->usertax->selectByUser($id)->row();
		$this->load->view('taxuser/form_edit_usertax', $data);
	}

	function proses_edit_usertax()
	{
		$id_user       = $this->input->post('npp');
		$nama_user     = $this->input->post('nama_user');
		$email         = $this->input->post('email');
		$id_unit       = $this->input->post('id_unit');
		$level         = $this->input->post('level');
		$status        = $this->input->post('status');
		$modified_by   = $_SESSION['ID'];

		//buat insert log
		$create_by = $_SESSION['ID'];
		$action = "Telah Melakukan Operasi Edit User Dengan ID_USER = $id_user";
		$this->log->insertLog($create_by, $action);

		$this->usertax->updateUser($id_user, $nama_user, $email, $id_unit, $level, $status, $modified_by);

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

		redirect('usertax');

	}

	function hapus_usertax($id)
	{
		//buat insert log
		$create_by = $_SESSION['ID'];
		$action = "Telah Melakukan Operasi Hapus User ";
		$this->log->insertLog($create_by, $action);

		$this->usertax->deleteUser($id);

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

		redirect('usertax');
	}

	function cari_unit()
	{
		//$id_user = $_SESSION['ID'];
		$cari = $this->input->post('cariunit');
		$data['unit'] = $this->usertax->searchUnit($cari);
		$this->load->view('taxuser/pencarian_unitid', $data);
	}



}
?>
