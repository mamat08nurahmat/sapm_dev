<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_ajax_new extends Controller {

	function Activity_ajax_new()
	{
		///**
		parent::Controller();

		$this->load->model('_activity_tab_1');
	}

	public function index()
	{
		//**
		$this->load->helper('url');
		$this->load->view('person_view');
/*
echo"XXXXXXX";		
*/		
	}

//--------------------------------------------
	public function ajax_list_tab_1()
	{
		$list = $this->_activity_tab_1->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
//			$row[] = $no;
			$row[] = $person->CIF;
			$row[] = $person->USER_NAME;
			$row[] = $person->EMAIL;
			$row[] = $person->ID;
			$row[] = $person->USER_NAME;
			$row[] = $person->EMAIL;
			//$row[] = $person->dob0

			
			//add html for action
			$row[] = '
			<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_data('."'".$person->ID."'".')"><i class="glyphicon glyphicon-zoom-in"></i> VIEW</a>			
			<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_data('."'".$person->ID."'".')"><i class="glyphicon glyphicon-zoom-in"></i> ADD</a>			
			<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_data('."'".$person->ID."'".')"><i class="glyphicon glyphicon-zoom-in"></i> Next Stagging</a>			
			';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->_sales_tab->count_all(),
						"recordsFiltered" => $this->_sales_tab->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

//-----	
	public function ajax_list_tab_2()
	{
		$list = $this->_sales_tab_2->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
//			$row[] = $no;
			$row[] = $person->ID;
			$row[] = $person->CIF_KEY;
			$row[] = $person->NAMA;
			$row[] = $person->BRANCH;
			$row[] = $person->HANDPHONE;
			$row[] = $person->PROGRAM_NAME;
			$row[] = $person->PRODUK;
			$row[] = $person->EXPIRED_PROGRAM;
			//$row[] = $person->dob0

			
			//add html for action
			$row[] = '
			<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_data_tab_2('."'".$person->ID."'".')"><i class="glyphicon glyphicon-zoom-in"></i> VIEW</a>		
			';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->_sales_tab_2->count_all(),
						"recordsFiltered" => $this->_sales_tab_2->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	
	}

//----------
	public function ajax_list_tab_3()
	{
		$list = $this->_sales_tab_3->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
//			$row[] = $no;
			$row[] = $person->ID;
			$row[] = $person->SAPM_DATE;
			$row[] = $person->CIF;
			$row[] = $person->NAMA;
			$row[] = $person->HP;
			$row[] = $person->KOTA;
			$row[] = $person->JENIS_PRODUK;
			$row[] = $person->KODE_CABANG;
			//$row[] = $person->dob0

			
			//add html for action
			$row[] = '
			<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_data('."'".$person->ID."'".')"><i class="glyphicon glyphicon-zoom-in"></i> VIEW</a>		
			
			';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->_sales_tab_3->count_all(),
						"recordsFiltered" => $this->_sales_tab_3->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	
	}

//------------
	public function ajax_list_tab_4()
	{
		$list = $this->_sales_tab->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
//			$row[] = $no;
			$row[] = $person->ID;
			$row[] = $person->USER_NAME;
			$row[] = $person->ID;
			$row[] = $person->USER_NAME;
			$row[] = $person->EMAIL;
			$row[] = $person->ID;
			$row[] = $person->USER_NAME;
			$row[] = $person->EMAIL;
			//$row[] = $person->dob0

			
			//add html for action
			$row[] = '
			<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_data('."'".$person->ID."'".')"><i class="glyphicon glyphicon-zoom-in"></i> VIEW</a>		
			<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->ID."'".')"><i class="glyphicon glyphicon-pencil"></i> EDIT</a>
			';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->_sales_tab->count_all(),
						"recordsFiltered" => $this->_sales_tab->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


//-------------
	public function ajax_list_tab_5()
	{
		$list = $this->_sales_tab->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
//			$row[] = $no;
			$row[] = $person->ID;
			$row[] = $person->USER_NAME;
			$row[] = $person->ID;
			$row[] = $person->USER_NAME;

			//$row[] = $person->dob0

			
			//add html for action
			$row[] = '
			<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_data_tab_5('."'".$person->ID."'".')"><i class="glyphicon glyphicon-zoom-in"></i> VIEW</a>		
			<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Edit" onclick="edit_data_tab_5('."'".$person->ID."'".')"><i class="glyphicon glyphicon-pencil"></i> EDIT</a>
			<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Add" onclick="add_data_tab_5('."'".$person->ID."'".')"><i class="glyphicon glyphicon-plus"></i> ADD</a>		
			<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_data_tab_5('."'".$person->ID."'".')"><i class="glyphicon glyphicon-trash"></i> DELETE</a>

			';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->_sales_tab->count_all(),
						"recordsFiltered" => $this->_sales_tab->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	
	}

//----------------------------------	

	public function get_view_tabel_modal5($id)
	{

	echo"XXXXXXXXXXXXXXXXXXXXXX";
	echo $id;
	
	}


	public function ajax_view2($id)
	{
		$data = $this->_sales_tab_2->get_by_id($id);
		//$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	
/*
//--=-=-=-=-=-
		$html 	=  "";
		$html 	.= "NPP : XXXXXXX <br />\n";
		$html 	.= "NAMA : XXXXX<br />\n";

		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
		$html 	.= "<tr  bgcolor='#A5D3FA'>\n
						<th align='center' class='kecil'>NO.</th>\n
						<th align='left' class='kecil'>KPI</th>\n
						<th align='center' class='kecil'>TYPE KPI</th>\n
						<th align='center' class='kecil'>BOBOT</th>\n						
						<th align='center' class='kecil'>REALISASI</th>\n
						<th align='center' class='kecil'>PERFORMANCE</th>\n						
					</tr>\n";


				
		$html .= "</table> \n";
		echo $html;	

*/		



	public function ajax_list()
	{
		$list = $this->_sales_tab->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $person->ID;
			$row[] = $person->USER_NAME;
			$row[] = $person->EMAIL;
			//$row[] = $person->dob;

			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->ID."'".')"><i class="glyphicon glyphicon-zoom-in"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->ID."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->_sales_tab->count_all(),
						"recordsFiltered" => $this->_sales_tab->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
/*
*/

	public function ajax_edit($id)
	{
		$data = $this->_sales_tab->get_by_id($id);
		$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'firstName' => $this->input->post('firstName'),
				'lastName' => $this->input->post('lastName'),
				'gender' => $this->input->post('gender'),
				'address' => $this->input->post('address'),
				'dob' => $this->input->post('dob'),
			);
		$insert = $this->_sales_tab->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'firstName' => $this->input->post('firstName'),
				'lastName' => $this->input->post('lastName'),
				'gender' => $this->input->post('gender'),
				'address' => $this->input->post('address'),
				'dob' => $this->input->post('dob'),
			);
		$this->_sales_tab->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->_sales_tab->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('firstName') == '')
		{
			$data['inputerror'][] = 'firstName';
			$data['error_string'][] = 'First name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('lastName') == '')
		{
			$data['inputerror'][] = 'lastName';
			$data['error_string'][] = 'Last name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('dob') == '')
		{
			$data['inputerror'][] = 'dob';
			$data['error_string'][] = 'Date of Birth is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('gender') == '')
		{
			$data['inputerror'][] = 'gender';
			$data['error_string'][] = 'Please select gender';
			$data['status'] = FALSE;
		}

		if($this->input->post('address') == '')
		{
			$data['inputerror'][] = 'address';
			$data['error_string'][] = 'Addess is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
/*
*/	

}
