<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usulan_tambahan extends Controller
{
    function Usulan_tambahan ()
    {
        parent::Controller();
        $this->load->model('usulan_tambahan_model');
        $this->load->library('form_validation');        
	#$this->load->library('datatables');
    }

    public function index()
    {
		#echo"INDEX ";
        $this->load->view('usulan_tambahan/usulan_tambahan_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->usulan_tambahan_model->json();
    }

    public function read($id) 
    {
        $row = $this->Usulan_tambahan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'jenis' => $row->jenis,
		'cif' => $row->cif,
		'jenis_cif' => $row->jenis_cif,
		'nama_nasabah' => $row->nama_nasabah,
		'cif_utama' => $row->cif_utama,
		'hubungan_degan_utama' => $row->hubungan_degan_utama,
		'status' => $row->status,
		'approval' => $row->approval,
		'tanggal_kirim' => $row->tanggal_kirim,
	    );
            $this->load->view('usulan_tambahan/usulan_tambahan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('usulan_tambahan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('usulan_tambahan/create_action'),
	    'id' => set_value('id'),
	    'jenis' => set_value('jenis'),
	    'cif' => set_value('cif'),
	    'jenis_cif' => set_value('jenis_cif'),
	    'nama_nasabah' => set_value('nama_nasabah'),
	    'cif_utama' => set_value('cif_utama'),
	    'hubungan_degan_utama' => set_value('hubungan_degan_utama'),
	    'status' => set_value('status'),
	    'approval' => set_value('approval'),
	    'tanggal_kirim' => set_value('tanggal_kirim'),
	);
        $this->load->view('usulan_tambahan/usulan_tambahan_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'jenis' => $this->input->post('jenis',TRUE),
		'cif' => $this->input->post('cif',TRUE),
		'jenis_cif' => $this->input->post('jenis_cif',TRUE),
		'nama_nasabah' => $this->input->post('nama_nasabah',TRUE),
		'cif_utama' => $this->input->post('cif_utama',TRUE),
		'hubungan_degan_utama' => $this->input->post('hubungan_degan_utama',TRUE),
		'status' => $this->input->post('status',TRUE),
		'approval' => $this->input->post('approval',TRUE),
		'tanggal_kirim' => $this->input->post('tanggal_kirim',TRUE),
	    );

            $this->Usulan_tambahan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('usulan_tambahan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Usulan_tambahan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('usulan_tambahan/update_action'),
		'id' => set_value('id', $row->id),
		'jenis' => set_value('jenis', $row->jenis),
		'cif' => set_value('cif', $row->cif),
		'jenis_cif' => set_value('jenis_cif', $row->jenis_cif),
		'nama_nasabah' => set_value('nama_nasabah', $row->nama_nasabah),
		'cif_utama' => set_value('cif_utama', $row->cif_utama),
		'hubungan_degan_utama' => set_value('hubungan_degan_utama', $row->hubungan_degan_utama),
		'status' => set_value('status', $row->status),
		'approval' => set_value('approval', $row->approval),
		'tanggal_kirim' => set_value('tanggal_kirim', $row->tanggal_kirim),
	    );
            $this->load->view('usulan_tambahan/usulan_tambahan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('usulan_tambahan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'jenis' => $this->input->post('jenis',TRUE),
		'cif' => $this->input->post('cif',TRUE),
		'jenis_cif' => $this->input->post('jenis_cif',TRUE),
		'nama_nasabah' => $this->input->post('nama_nasabah',TRUE),
		'cif_utama' => $this->input->post('cif_utama',TRUE),
		'hubungan_degan_utama' => $this->input->post('hubungan_degan_utama',TRUE),
		'status' => $this->input->post('status',TRUE),
		'approval' => $this->input->post('approval',TRUE),
		'tanggal_kirim' => $this->input->post('tanggal_kirim',TRUE),
	    );

            $this->Usulan_tambahan_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('usulan_tambahan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Usulan_tambahan_model->get_by_id($id);

        if ($row) {
            $this->Usulan_tambahan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('usulan_tambahan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('usulan_tambahan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('jenis', 'jenis', 'trim|required');
	$this->form_validation->set_rules('cif', 'cif', 'trim|required');
	$this->form_validation->set_rules('jenis_cif', 'jenis cif', 'trim|required');
	$this->form_validation->set_rules('nama_nasabah', 'nama nasabah', 'trim|required');
	$this->form_validation->set_rules('cif_utama', 'cif utama', 'trim|required');
	$this->form_validation->set_rules('hubungan_degan_utama', 'hubungan degan utama', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');
	$this->form_validation->set_rules('approval', 'approval', 'trim|required');
	$this->form_validation->set_rules('tanggal_kirim', 'tanggal kirim', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "usulan_tambahan.xls";
        $judul = "usulan_tambahan";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis");
	xlsWriteLabel($tablehead, $kolomhead++, "Cif");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Cif");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Nasabah");
	xlsWriteLabel($tablehead, $kolomhead++, "Cif Utama");
	xlsWriteLabel($tablehead, $kolomhead++, "Hubungan Degan Utama");
	xlsWriteLabel($tablehead, $kolomhead++, "Status");
	xlsWriteLabel($tablehead, $kolomhead++, "Approval");
	xlsWriteLabel($tablehead, $kolomhead++, "Tanggal Kirim");

	foreach ($this->Usulan_tambahan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis);
	    xlsWriteLabel($tablebody, $kolombody++, $data->cif);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_cif);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_nasabah);
	    xlsWriteLabel($tablebody, $kolombody++, $data->cif_utama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->hubungan_degan_utama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->status);
	    xlsWriteLabel($tablebody, $kolombody++, $data->approval);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tanggal_kirim);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=usulan_tambahan.doc");

        $data = array(
            'usulan_tambahan_data' => $this->Usulan_tambahan_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('usulan_tambahan/usulan_tambahan_doc',$data);
    }

}

/* End of file Usulan_tambahan.php */
/* Location: ./application/controllers/Usulan_tambahan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-06-09 09:01:26 */
/* http://harviacode.com */