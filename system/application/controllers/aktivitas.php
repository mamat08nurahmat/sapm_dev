<?php
class Aktivitas extends Controller {

	function Aktivitas()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form', 'to_excel'));
        $this->load->library(array('table','validation', 'session', 'ldap'));
		$this->load->model('_aktivitas', 'aktivitas');
		$this->load->model('_logtax', 'log', TRUE);
		$this->load->model('_lookup_tax_amnesty', 'lookuptax');

		if($_SESSION['ID'] == ''){ redirect('login_tax_amnesty/logout/');}

		date_default_timezone_set('Asia/Jakarta');
	}

	function index()
	{
		$arr_closing = array();
		$id_user = $_SESSION['ID'];
		$data['tampil']  = $this->aktivitas->getAll($id_user);
		$data_closing = $this->aktivitas->cekStatusClosing($id_user);
		foreach($data_closing->result() as $row)
		{
			$arr_closing[] = $row->ID_PROSPEK;
		}
		$data['arr_closing'] = $arr_closing;
		//$data['closing'] = $this->aktivitas->cekClosing($id_user)->result();
		$this->load->view('taxaktivitas/index', $data);
	}

	function tambah_aktivitas()
	{
		$this->load->view('taxaktivitas/form_tambah_aktivitas');
	}

	function proses_tambah_aktivitas()
	{
		/*
		$id_prospek      = $this->input->post('id_prospek');
		$jenis_aktivitas = $this->input->post('jenis');
		$tanggal         = $this->input->post('tanggal');
		$produk          = $this->input->post('produk');
		$keterangan      = $this->input->post('keterangan');
		$this->aktivitas->insertAktivitas($id_prospek, $jenis_aktivitas, $tanggal, $produk, $keterangan);
		redirect('aktivitas');*/

		$id_prospek      = $this->input->post('id_prospek');
		$jenis_aktivitas = $this->input->post('jenis');
		$tanggal         = $this->input->post('tanggal');
		$komitmen        = $this->input->post('komitmen');
		$nominal         = $this->input->post('nominal');
		$nominal         = str_replace(".", "",$nominal);
		$keterangan      = $this->input->post('keterangan');
		$create_by      = $_SESSION['ID'];
		$modified_by    = $_SESSION['ID'];

		//cek id_prospek klo sudah ada update aktivitas insert history
		$cek = $this->aktivitas->cekAktivitas($id_prospek);
		if ($cek->num_rows() > 0) {
			//echo "Data Sudah Ada";
			$this->aktivitas->updateAktivitasTerakhir($id_prospek, $jenis_aktivitas, $tanggal, $komitmen, $keterangan, $modified_by);
			$this->aktivitas->insertHistory($id_prospek, $jenis_aktivitas, $tanggal, $keterangan, $create_by);

			//buat insert log
			$action2 = "Telah Melakukan Operasi Update Aktivitas & Tambah History Dengan ID_Prospek = $id_prospek";
			$this->log->insertLog($create_by, $action2);

			$this->session->set_flashdata("pesan","<div class='alert alert-block alert-success'>
									 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>

									<p>
										<strong>
											<i class='icon-ok'></i>
											Update
										</strong>
										Data aktivitas berhasil...!
									</p>
								</div>");

			redirect('aktivitas');
		} else {
			//echo "Data Belum ada";

			$this->aktivitas->insertAktivitas($id_prospek, $jenis_aktivitas, $tanggal, $komitmen, $nominal, $keterangan, $create_by);
			$this->aktivitas->insertHistory($id_prospek, $jenis_aktivitas, $tanggal, $keterangan, $create_by);

			//buat insert log
			$action = "Telah Melakukan Operasi Tambah Aktivitas & Tambah History Dengan ID_Prospek = $id_prospek";
			$this->log->insertLog($create_by, $action);

			$this->session->set_flashdata("pesan","<div class='alert alert-block alert-success'>
									 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>

									<p>
										<strong>
											<i class='icon-ok'></i>
											Input
										</strong>
										Data aktivitas berhasil...!
									</p>
								</div>");

			redirect('aktivitas');
		}

	}

	function cari_nasabah()
	{
		$id_user = $_SESSION['ID'];
		$cari = $this->input->post('carinasabah');
		$data['nasabah'] = $this->aktivitas->searchProspek($cari, $id_user);
		$this->load->view('taxaktivitas/pencarian_nasabah', $data);
	}

	function history()
	{
		$id_prospek    = $this->uri->segment(3);
		$data['data']  = $this->aktivitas->getHistory($id_prospek);
		$data['getnama']  = $this->aktivitas->getHistory2($id_prospek)->row();
		$this->load->view('taxaktivitas/view_history', $data);
	}

	function closing()
	{
		$id_prospek    = $this->uri->segment(3);
		$data['data']  = $this->aktivitas->selectByClosing($id_prospek);
		$data['lookupproduk'] = $this->lookuptax->getLookupJenisProduk();
		$this->load->view('taxaktivitas/form_closing', $data);
	}

	//function proses_tambah_closing($id_prospek)
	function proses_tambah_closing()
	{
		$create_by       = $_SESSION['ID'];
		$id_prospek      = $this->input->post('id_prospek');
		$nama_nasabah    = $this->input->post('nama_nasabah');
		$tanggal         = $this->input->post('tanggal');
		$produk          = $this->input->post('produk');
		$jenis           = $this->input->post('jenis');
		$no_rekening     = $this->input->post('no_rekening');
		$nominal         = $this->input->post('nominal');
		$nominal         = str_replace(".", "",$nominal);
		$keterangan      = $this->input->post('keterangan');
		$skpp            = $this->input->post('skpp');


		$cek = $this->aktivitas->cekClosing($id_prospek);
		if ($cek->num_rows() > 0) {
			?>
			<script type="text/javascript">
				alert('Nasabah ini sudah closing! ');
				var urls = '<?php echo site_url('/aktivitas/')?>';
				window.location.replace(urls)
			</script>
			<?php
			echo "sudah closing";
		}
		//kalo blm baru insert ke database
		else {
			$this->aktivitas->insertClosing($id_prospek, $nama_nasabah, $tanggal, $produk, $jenis, $no_rekening, $nominal, $keterangan, $create_by, $skpp);
			//$this->aktivitas->deleteAktivitas($id_prospek);
			//$this->aktivitas->deleteHistory($id_prospek);

			//buat insert log
			$action = "Telah Melakukan Operasi Closing Dengan ID_PROSPEK = $id_prospek";
			$this->log->insertLog($create_by, $action);
			//buat insert log

			$this->session->set_flashdata("pesan","<div class='alert alert-block alert-success'>
								 <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>

								<p>
									<strong>
										<i class='icon-ok'></i>
										Input
									</strong>
									Closing berhasil...!
								</p>
							</div>");

			redirect('aktivitas');
		}





	}

	function vclosing()
	{
		$data['lookupclosing'] = $this->lookuptax->getLookupJenisClosing();
		$this->load->view('taxclosinglaporan/view_closing', $data);
	}

	function cari_laporan()
	{
		$id_user      = $_SESSION['ID'];
		$id_aktivitas = $this->input->post('id_aktivitas');
		$tanggal2	  = strtoupper($this->input->post('tanggal2'));
		$tanggal3	  = strtoupper($this->input->post('tanggal3'));

		$data['laporan'] = $this->aktivitas->getClosing($id_user, $id_aktivitas, $tanggal2, $tanggal3);

		//link download
		$data['link_excel'] = anchor("aktivitas/export_closing_excel/$id_aktivitas/$tanggal2/$tanggal3", 'Export To Excel', array('class' => 'btn btn-warning', 'type' => 'button'));

		$this->load->view("taxclosinglaporan/view_data_closing", $data);
	}

	function export_closing_excel($id_aktivitas, $tanggal2, $tanggal3)
	{
		// load to_excel_helper (untuk membuat laporan dengan format excel)
		 if(! empty($id_aktivitas) && ! empty($tanggal2) && ! empty($tanggal3)) {

			$id_user      = $_SESSION['ID'];

			$create_date = date('d-M-Y');

			$query =  $this->aktivitas->getReportClosing($id_user, $id_aktivitas, $tanggal2, $tanggal3);

			$nama_file = 'REPORT_CLOSING_TAX_AMNESTY_'.$create_date;

			//buat insert log
			$create_by      = $_SESSION['ID'];
			$action = 'Telah Melakukan Export Data Closing';
			$this->log->insertLog($create_by, $action);
			//buat insert log

			to_excel($query, $nama_file);
		} else {
			redirect('aktivitas/vclosing');
		}


	}

	function vaktivitas()
	{
		$data['komitmen'] = $this->lookuptax->getLookupKomitmen();
		$this->load->view('taxaktivitaslaporan/view_aktivitas_laporan', $data);

		//apabila ada lookup komitmen
		// if ($komitmen){
		// 	foreach($komitmen as $row)
		// 	{
		// 		$data['lookupkomitmen'][$row->ID] = $row->KETERANGAN;
		// 	}
		// 	$this->load->view('view_aktivitas_laporan', $data);
		// }
		// else{
		// 	$data['lookupkomitmen']['00'] = 'Data Tidak Ada';
		// 	$this->load->view('view_aktivitas_laporan', $data);
		// }

	}

	//function tampil report aktivitas
	function cari_aktivitas()
	{
		$id_user      = $_SESSION['ID'];
		$id_komitmen  = $this->input->post('id_komitmen');
		$tanggal2	  = strtoupper($this->input->post('tanggal2'));
		$tanggal3	  = strtoupper($this->input->post('tanggal3'));

		$data['aktivitas'] = $this->aktivitas->getAktivitas($id_user, $id_komitmen, $tanggal2, $tanggal3);

		$data['link_excel'] = anchor("aktivitas/export_aktivitas_excel/$id_komitmen/$tanggal2/$tanggal3", 'Export To Excel', array('class' => 'btn btn-warning', 'type' => 'button'));

		$this->load->view("taxaktivitaslaporan/view_data_aktivitas", $data);
	}

	function export_aktivitas_excel($id_komitmen, $tanggal2, $tanggal3)
	{
		// load to_excel_helper (untuk membuat laporan dengan format excel)
		if(! empty($id_komitmen) && ! empty($tanggal2) && ! empty($tanggal3)) {

			$create_date = date('d-M-Y');

			$id_user      = $_SESSION['ID'];

			$query =  $this->aktivitas->getReportAktivitas($id_user, $id_komitmen, $tanggal2, $tanggal3);

			$nama_file = 'REPORT_AKTIVITAS_TAX_AMNESTY_'.$create_date;

			//buat insert log
			$create_by      = $_SESSION['ID'];
			$action = 'Telah Melakukan Export Data Aktivitas';
			$this->log->insertLog($create_by, $action);
			//buat insert log

			to_excel($query, $nama_file);
		} else {
			redirect('aktivitas/vaktivitas');
		}
	}


}
