<?php
class Prospek extends Controller {

	function Prospek()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form', 'download'));
        $this->load->library(array('table','validation', 'session', 'ldap'));
		//$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
        $this->load->model('_prospek', 'prospek');
		$this->load->model('_userlogintax', 'user', TRUE);
		$this->load->model('_logtax', 'log', TRUE);

		if($_SESSION['ID'] == ''){ redirect('login_tax_amnesty/logout/');}

		date_default_timezone_set('Asia/Jakarta');
	}

	function index()
	{
		$id_user = $_SESSION['ID'];
		$data['tampil'] = $this->prospek->getAll($id_user);
		$this->load->view('taxprospek/index', $data);
	}

	function tambah_prospek()
	{
		$this->load->view('taxprospek/form_tambah_prospek');
	}

	function proses_tambah_prospek()
	{
		//cif / id_nasabah
		$jenis          = $this->input->post('jenis');
		$cif            = $this->input->post('cif');
		$nama_nasabah   = $this->input->post('nama');
		$status         = $this->input->post('status');
		$potensi        = $this->input->post('potensi');
		$potensi        = str_replace(".", "",$potensi);
		$create_by      = $_SESSION['ID'];
		$referral_id    = $this->input->post('referral_id');

		$cek = $this->prospek->cekNasabahProspek($cif);
		if ($cek->num_rows() > 0) {
			?>
			<script type="text/javascript">
				alert("Nasabah prospek sudah ada! ");
				var urls = '<?php echo site_url('/prospek/')?>';
				window.location.replace(urls)
			</script>
			<?php
			//echo "Sudah Ada";
		}
		//kalo blm ada inser ke table prospek
		else {
			$this->prospek->insertProspek($cif, $nama_nasabah, $jenis, $status, $potensi, $create_by, $referral_id);

			//buat insert log
			$action = "Telah Melakukan Operasi Tambah Prospek Dengan ID_NASABAH = $cif";
			$this->log->insertLog($create_by, $action);

			$this->session->set_flashdata("pesan","<div class='alert alert-block alert-success'>
										 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>

										<p>
											<strong>
												<i class='icon-ok'></i>
												Tambah
											</strong>
											Data prospek berhasil...!
										</p>
									</div>");

			redirect('prospek');
			//echo "Belumada";
		}
	}

	function edit_prospek($id)
	{
		$data['prospek'] = $this->prospek->selectByProspek($id)->row();
		$this->load->view('taxprospek/form_edit_prospek', $data);
	}

	function proses_edit_prospek()
	{
		$id             = $this->input->post('id');
		$jenis          = $this->input->post('jenis');
		$cif            = $this->input->post('cif');
		$nama_nasabah   = $this->input->post('nama');
		$status         = $this->input->post('status');
		$potensi        = $this->input->post('potensi');
		$potensi        = str_replace(".", "",$potensi);
		$modified_by    = $_SESSION['ID'];
		$referral_id    = $this->input->post('referral_id');

		$this->prospek->updateProspek($id, $cif, $nama_nasabah, $jenis, $status, $potensi, $modified_by, $referral_id);

		//buat insert log
		$create_by = $_SESSION['ID'];
		$action = "Telah Melakukan Operasi Edit Prospek Dengan ID_NASABAH = $cif";
		$this->log->insertLog($create_by, $action);

		$this->session->set_flashdata("pesan","<div class='alert alert-block alert-success'>
									 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>

									<p>
										<strong>
											<i class='icon-ok'></i>
											Update
										</strong>
										Data prospek berhasil...!
									</p>
								</div>");

		redirect('prospek');
	}

	function hapus_prospek($id)
	{
		$this->prospek->deleteProspek($id);
		redirect('prospek');
	}

	function upload_prospek()
	{
		$this->load->view('taxprospek/form_upload_prospek');
	}

	function proses_upload_prospek()
	{
		$create_by = $_SESSION['ID'];
		// config upload
		$config['upload_path']   = UPLOAD_PROSPEK2;
		$config['allowed_types'] = 'xls';
		$config['max_size']      = '10000';
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('userfile')) {
			// jika validasi file gagal, kirim parameter error ke index
			$error = array('error' => $this->upload->display_errors());
			$this->upload_prospek($error);
		} else {
		  // jika berhasil upload ambil data dan masukkan ke database
		  $upload_data = $this->upload->data();

		  // load library Excell_Reader
		  $this->load->library('Excel_reader/Excel_reader');

		  //tentukan file
		  $this->excel_reader->setOutputEncoding('230787');
		  $file = $upload_data['full_path'];
		  $this->excel_reader->read($file);
		  error_reporting(E_ALL ^ E_NOTICE);

		  // array data
		  $data = $this->excel_reader->sheets[0];
		  $dataexcel = Array();
		  for ($i = 2; $i <= $data['numRows']+1; $i++) {
			   if ($data['cells'][$i][1] == '')
			   break;

			   $dataexcel[$i-2]['ID_NASABAH']    = $data['cells'][$i][1];
			   $dataexcel[$i-2]['NAMA_NASABAH']  = $data['cells'][$i][2];
			   $dataexcel[$i-2]['JENIS_NASABAH'] = $data['cells'][$i][3];
			   $dataexcel[$i-2]['STATUS']        = $data['cells'][$i][4];
			   $dataexcel[$i-2]['POTENSI']       = $data['cells'][$i][5];
			   $dataexcel[$i-2]['CREATED_BY']    = $data['cells'][$i][6];
		  }

		  //load model
		  $this->load->model('_prospek', 'prospek');
		  $this->prospek->upload_data_prospek($dataexcel);

		  $this->session->set_flashdata("pesan","<div class='alert alert-block alert-success'>
										 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>

										<p>
											<strong>
												<i class='icon-ok'></i>
												Upload
											</strong>
											Data berhasil...!
										</p>
									</div>");

		  //insert buat log
		  $action = "User Dengan ID_USER = $create_by Telah Melakukan Upload Data Prospek";
		  $this->log->insertLog($create_by, $action);

		  //hapus file di server apabila data sudah di insert kedatabase
		  $file = $upload_data['file_name'];
		  $path = UPLOAD_PROSPEK2.$file;
		  unlink($path);

		  //redirect ke halaman awal
		  redirect(site_url('prospek'));
		}
	}

	function download_prospek()
	{
		$this->load->helper('download');
		//$name = base_url()."/upload/download.pdf";
		$name = 'format_upload.rar';
		$direktori  = file_get_contents(DOWNLOAD_PRSOPEK.$name);
		force_download($name,$direktori);

	}



}
