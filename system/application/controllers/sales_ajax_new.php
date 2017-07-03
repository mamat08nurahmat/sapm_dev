<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_ajax_new extends Controller {

	function Sales_ajax_new()
	{
		///**
		parent::Controller();
		$this->load->model('_sales_tab','_sales_tab');
		$this->load->model('_sales_tab_2');
		$this->load->model('_sales_tab_3');
		$this->load->model('_sales_tab_5');
		$this->load->model('_sales');
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
		$list = $this->_sales_tab->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
//			$row[] = $no;
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
		$list = $this->_sales_tab_5->get_datatables();
/*
		$list = $this->_sales_tab->get_datatables();
*/
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
//			$row[] = $no;
/*
			$row[] = $person->ID;
			$row[] = $person->USER_NAME;
			$row[] = $person->ID;
			$row[] = $person->USER_NAME;
*/
			$row[] = $person->ID;
			$row[] = $person->CIF;
			$row[] = $person->CUST_NAME;
			$row[] = $person->AGE;

			
			//add html for action
			$row[] = '
			<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="View" onclick="view_data_tab_5('."'".$person->ID."'".')"><i class="glyphicon glyphicon-zoom-in"></i> VIEW</a>		
			<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Edit" onclick="edit_data_tab_5('."'".$person->ID."'".')"><i class="glyphicon glyphicon-pencil"></i> EDIT</a>
			<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Add" onclick="add_data_tab_5()"><i class="glyphicon glyphicon-plus"></i> ADD</a>		
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

	public function get_view_modal5($id)
	{
/*
	echo $id;
*/
//$data['data'] = $this->_sales->get_data_cust($type, $id,'CUST_INDV_PROS');
/*
$type =0;
$data 	= $this->_sales->get_data_cust($type, $id,'CUST_INDV_PROS');;
//$data = $this->db->get('CUST_INDV_PROS')->result_array();
*/
	$data = $this->db->query("SELECT * FROM CUST_INDV_PROS WHERE ID = '243613'")->result();
	
		$html 	=  "";
//		$html 	.= "NPP : ".$user[0]->ID."<br />\n";
//		$html 	.= "NAMA : ".strtoupper($user[0]->USER_NAME)."<br />\n";
//		$html 	.= "SALES TYPE : ".$user[0]->SALES_TYPE."<br />\n";
//		$html 	.= "PERIODE : ".$start." s/d ".$end."<br /><br />\n";
		//$html 	.= "ID : ".$id."<br /><br />\n";

		
        $html 	.= "<form action='#' id='form' class='form-horizontal'>";
	    $html 	.= "<input type='hidden' value='' name='id'/>";
		$html 	.= "<div class='form-body'>";
/*
*/
	
		
		$html 	.= "<table width='100%' cellpadding='10' cellspacing='1' bgcolor='#cccccc' class='tbl_report'>\n";
#print_r($data);		
if(isset($data) && $data){	
	$n = 1;
						
       foreach($data[0] as $row => $val){
         $color = (($n%2) == 0)?'#ffffff':'#eeeeee';
		$html 	.= "<tr  bgcolor=".$color.">\n
						<th align='center'>".str_replace("_"," ",$row)."</th>\n
						<th>:</th>\n
						<th align='center'>".$val."</th>\n					
					</tr>\n";
	$n++; 
	}
}						
		$html 	.= "</table'>\n";
		
/*
*/
		$html 	.= "</div>";
		$html 	.= "</form>";
		
		echo $html;
	}
//--------------------
	public function get_add_modal5()
	{
		
		$bni_product	=  $this->_sales->get_bni_product();
		$other_product	=  $this->_sales->get_other_product($this->session->userdata('BRANCH_ID'));
		$list_sumber_leads = $this->_sales->get_sumber_leads();
		$list_cabang = $this->_sales->get_cabang();
/*
						//if(isset($bni_product)){
							foreach($bni_product as $row)
							{
//if( stristr($row->PRODUCT_NAME, 'jumlah') === false)
	//							{
									$produk = $row->PRODUCT_NAME ;
								}
		//					}
						//}
*/		
/*
*/		
		
//print_r('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');		
//print_r($bni_product);		
//print_r('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');		
//--------------------------print_r($other_product);		
//print_r('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');		
//print_r($list_sumber_leads);		
//print_r('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');		
//print_r($list_cabang);		
//	$data = $this->db->query("SELECT * FROM CUST_INDV_PROS WHERE ID = '243613'")->result();
	
		$html 	=  "";
        $html 	.= "<form action='site_url('/sales/save_cust_ind_pros/')' id='form' class='form-horizontal'>";
	    $html 	.= "<input type='hidden' value='' name='id'/>";
$html   .="<div class='row' >";

//----------
	$html   .="<div class='col-xs-6' >";

		$html 	.= "<div class='form-body'>";

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Nama customers*</label>
                            <div class='col-md-9'>
                                <input name='CUST_NAME'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";		

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>No CIF</label>
                            <div class='col-md-9'>
                                <input name='CIF_KEY'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Nama Perusahaan</label>
                            <div class='col-md-9'>
                                <input name='COMPANY_NAME'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Jabatan</label>
                            <div class='col-md-9'>
                                <input name='OCCUPATION'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Tempat Lahir</label>
                            <div class='col-md-9'>
                                <input name='PLACE_OF_BIRTH'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";		

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Tanggal Lahir</label>
                            <div class='col-md-9'>
                                <input name='DATE_OF_BIRTH'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Jenis Kelamin</label>
                            <div class='col-md-9'>

					<select name='SEX_CD' id='SEX_CD'>
                  	  <option value='M'>Pria</option>
                  	  <option value='F'>Wanita</option>
					</select>
							
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Sekertaris</label>
                            <div class='col-md-9'>
                                <input name='SECRETARY'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

		$html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Alamat Rumah</label>
                            <div class='col-md-9'>
						<textarea name='ADDRESS' cols='30' rows='4' id='ADDRESS' width='30'>
						</textarea>				
                                <span class='help-block'></span>
                            </div>
                        </div>
					";		

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Status Pernikahan</label>
                            <div class='col-md-9'>
							
										<select name='MARITAL_CD' id='MARITAL_CD'>
															  <option value='S'>Single</option>
															  <option value='M'>Menikah</option>
										</select>
							
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Jumlah Anak</label>
                            <div class='col-md-9'>
                    <select name='CHILDREN' id='CHILDREN'>
                    
                  	  <option value='1'>1</option>
                  	  <option value='2'>2</option>
                  	  <option value='3'>3</option>
                  	  
                    </select>
							
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Telpon 1</label>
                            <div class='col-md-9'>
                                <input name='PHONE_1'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

		 $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Telpon 2</label>
                            <div class='col-md-9'>
                                <input name='PHONE_2'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";		

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Pendidikan Terakhir</label>
                            <div class='col-md-9'>
							
<select name='EDUCATION' id='EDUCATION'>
					<option value='S'>S3</option>
                  	  <option value='S2'>S2</option>
                  	  <option value='S1'>S1</option>
                  	  <option value='D3'>D3</option>
                  	  <option value='D1'>D1</option>
                  	  <option value='SMA'>SMA</option>
                  	  <option value='SMP'>SMP</option>
                  	  <option value='SD'>SD</option>
                  	  <option value='Lainya'>Lainya</option>        
				 
 </select>
							
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					


		
		$html 	.= "</div>";
		
	$html 	.= "</div>";
//----------	

//----------
	$html   .="<div class='col-xs-6' >";

		$html 	.= "<div class='form-body'>";

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>hal yg dianggap penting</label>
                            <div class='col-md-9'>
                                <input name='IMPORTANT'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";		

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Tempat Liburan</label>
                            <div class='col-md-9'>
                                <input name='VACATION'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Kerabat Penting</label>
                            <div class='col-md-9'>
                                <input name='KINSMAN'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Biaya hidup/bulan</label>
                            <div class='col-md-9'>
                                <input name='COST_OF_LIVING'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Keahlian/hobi</label>
                            <div class='col-md-9'>
                                <input name='HOBBY'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";		

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Produk BNI 1</label>
                            <div class='col-md-9'>
<select name='BNI_PRODUCT_CD_1' id='BNI_PRODUCT_CD_1'>							
							";

$html .= "
                	  <option value='S'>S3</option>
                  	  <option value='S2'>S2</option>
                  	  <option value='S1'>S1</option>
                  	  <option value='D3'>D3</option>
                  	  <option value='D1'>D1</option>
                  	  <option value='SMA'>SMA</option>
                  	  <option value='SMP'>SMP</option>
                  	  <option value='SD'>SD</option>
                  	  <option value='Lainya'>Lainya</option>

";

								
							

							
        $html 	.= "    </select>
						<span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Produk BNI 2</label>
                            <div class='col-md-9'>
                                <input name='ID'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Produk BNI 3</label>
                            <div class='col-md-9'>
                                <input name='ID'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

		$html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Produk BNI 4</label>
                            <div class='col-md-9'>
                                <input name='ID'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";		

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Produk BNI Lain 1</label>
                            <div class='col-md-9'>
                                <input name='ID'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Produk BNI Lain 2</label>
                            <div class='col-md-9'>
                                <input name='ID'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Produk Yg dibutuhkan</label>
                            <div class='col-md-9'>
                                <input name='ID'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					

		 $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Sifat Dominan</label>
                            <div class='col-md-9'>
                                <input name='ID'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";		

        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Keterangan Lain</label>
                            <div class='col-md-9'>
                                <input name='ID'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";					


		
		$html 	.= "</div>";
		
	$html 	.= "</div>";
//----------	

	

	

$html 	.= "</div>";//---row
/*
*/		
		
        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Organisasi yg diikuti</label>
                            <div class='col-md-9'>
                                <input name='ID'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";		
        $html 	.= "     <div class='form-group'>
                            <label class='control-label col-md-3'>Apakah data terkait refferal RTGS ?</label>
                            <div class='col-md-9'>
                                <input name='ID'  class='form-control' type='text'>
                                <span class='help-block'></span>
                            </div>
                        </div>
					";							
		
/*
*/
		
		$html 	.= "</form>";

		echo $html;
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
