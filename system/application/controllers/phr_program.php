<?php
class phr_program extends Controller {

	function phr_program()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form', 'file','flexigrid','html','array'));
        $this->load->library(array('table','validation', 'session', 'ldap', 'nusoap_loader','form_validation','flexigrid'));
		$this->load->model('_phr_program', 'phr_program', TRUE);

		date_default_timezone_set('Asia/Jakarta');

		if($_SESSION['USERNAME'] == ''){ redirect('login_phr_nasabah/logout/');}

	}

	function index()
	{
		// $data["tampil"] = $this->phr_program->getAll();
        // $this->load->view("phrprogram/index", $data);
		
		$this->load->helper('form');
		$this->load->helper('html');
		
		$colModel['ID_PROGRAM']   		= array('ID_PROGRAM',80,TRUE,'center',1);
        $colModel['NAMA_PROGRAM'] 		= array('NAMA_PROGRAM',250,TRUE,'left',1);
		$colModel['TGL_AWAL']     		= array('TGL_AWAL',150,TRUE,'left',1);
		$colModel['TGL_AKHIR']    		= array('TGL_AKHIR',150,TRUE,'left',1);
		$colModel['PENJELASAN_PROGRAM'] = array('PENJELASAN_PROGRAM',500,TRUE,'left',1);		  

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

		$grid_js = build_grid_js('result_list',site_url("/phr_program/ajax_program_list/"),$colModel,'ID_PROGRAM','DESC',
			$gridParams,$buttons);

		$data['js_grid'] = $grid_js;

		$this->load->view('phrprogram/index',$data);
	}
	
	function ajax_program_list()
	{
		$valid_fields = array('ID_PROGRAM','NAMA_PROGRAM','TGL_AWAL','TGL_AKHIR','PENJELASAN_PROGRAM');
		
		$this->flexigrid->validate_post('ID_PROGRAM','asc',$valid_fields);
		$records = $this->phr_program->getListProgram();
		$this->output->set_header($this->config->item('json_header'));
		
		foreach ($records['records']->result() as $row)
		{
			
			$record_items[] = array($row->ID_PROGRAM,
				$row->ID_PROGRAM,
				$row->NAMA_PROGRAM,
				$row->TGL_AWAL,
				$row->TGL_AKHIR,
				$row->PENJELASAN_PROGRAM
			);
		}
		
		//Print please
		if (isset($record_items))
			$this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));
        else
         	$this->output->set_output('{"page":"1","total":"0","rows":[]}');
	}

    function add_program()
    {
        $this->load->view("phrprogram/phr_program_add");
    }

    function save_program_action()
    {
		$nama_program        = $this->input->post('nama_program');
		$tgl_awal            = $this->input->post('tgl_awal');
		$tgl_akhir           = $this->input->post('tgl_akhir');
		$penjelasan_program  = $this->input->post('penjelasan_program');

		// $simpan = array(
		// 	'NAMA_PROGRAM'       => $nama_program,
		// 	'TGL_AWAL'           => $tgl_awal,
		// 	'TGL_AKHIR'          => $tgl_akhir,
		// 	'PENJELASAN_PROGRAM' => $penjelasan_program
		// );
		// echo "<pre>";
		// print_r($simpan);
		// echo "</pre>";

		//$this->form_validation->set_rules('nama_program','Nama','required');

		// if ($this->form_validation->run()==FALSE)
		// {
		// 	$this->load->view('phr_program_add');
		// }

		if ($this->phr_program->validasi_tambah())
		{
			//notifikasi tambah data berhasil
			$tambah = $this->phr_program->save_program($nama_program, $tgl_awal, $tgl_akhir, $penjelasan_program);
			$this->session->set_flashdata("pesan","<div class='alert alert-block alert-success'>
							 				  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
												<p>
												<strong>
												<i class='icon-ok'></i>
												Tambah
												</strong>
												Data berhasil...!
												</p></div>");

			redirect('phr_program/add_program');

		}
		else
		{
			$this->load->view('phrprogram/phr_program_add');
		}



    }

    function edt_program()
    {
		$id_program   = $this->uri->segment(3);
		//pastikan id_program yg di edit ada
		if (! empty($id_program)) {
			$data["programedit"] = $this->phr_program->getIdProgram($id_program)->row();
			$this->load->view('phrprogram/phr_program_edit', $data);
		}
		else{
			//kalau tidak ada parameter id_program redirect ke halaman awal
			redirect("phr_program");
		}

    }

    function update_program()
    {
		$id_program          = $this->input->post('id_program');
		$nama_program        = $this->input->post('nama_program');
		$tgl_awal            = $this->input->post('tgl_awal');
		$tgl_akhir           = $this->input->post('tgl_akhir');
		$penjelasan_program  = $this->input->post('penjelasan_program');
		
		if ($this->phr_program->validasi_tambah()==true)
		{
		$this->phr_program->UpdatingProgram($id_program, $nama_program, $tgl_awal, $tgl_akhir, $penjelasan_program);

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
		redirect('phr_program');
		}
		else
		{
			$data["programedit"] = $this->phr_program->getIdProgram($id_program)->row();
            $this->load->view('phrprogram/phr_program_edit',$data);   
		}
		

    }

	function del_program($id_program)
	{
		$this->phr_program->hapusData($id_program);

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

		redirect('phr_program');
	}

	function download_program()
	{
		$this->load->helper('download');
		//$name = base_url()."/upload/download.pdf";
		$name = 'program_cif.rar';
		$direktori  = file_get_contents(DOWNLOAD_PRSOPEK.$name);
		force_download($name,$direktori);

	}

	function proses_upload_program()
	{
		// config upload
		$config['upload_path']   = UPLOAD_PROSPEK2;
		$config['allowed_types'] = 'xls';
		$config['max_size']      = '10000';
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('userfile')) {
			// jika validasi file gagal, kirim parameter error ke index
			$error = array('error' => $this->upload->display_errors());
			$this->add_program($error);
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

		  $tertinggi = $this->phr_program->max_data();
		  foreach ($tertinggi as $row) {
		  		$id_program = $row->ID_PROGRAM;
		  }

		  // array data
		  $data = $this->excel_reader->sheets[0];
		  $dataexcel = Array();
		  for ($i = 2; $i <= $data['numRows']+1; $i++) {
			   if ($data['cells'][$i][1] == '')
			   break;

			   $dataexcel[$i-2]['ID_PROGRAM']    = $id_program;
			   $dataexcel[$i-2]['CIF']  	     = $data['cells'][$i][1];
		  }

		  //load model
		  $this->load->model('_phr_program', 'phr_program');
		  $this->phr_program->upload_data_program($dataexcel);

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

		  //hapus file di server apabila data sudah di insert kedatabase
		  $file = $upload_data['file_name'];
		  $path = UPLOAD_PROSPEK2.$file;
		  unlink($path);

		  //redirect ke halaman awal
		  redirect(site_url('phr_program/add_program'));
		}


	}





}
/* End of file visit.php */
/* Location: ./system/application/controllers/visit.php */
