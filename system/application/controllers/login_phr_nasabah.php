<?php
/*
| Web Development : Panji Asmoro
| Email : pandjiasmoroart@gmail.com
| 24 Oktober 2016
*/
class login_phr_nasabah extends Controller {

	function login_phr_nasabah()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form', 'file'));
        $this->load->library(array('table','validation', 'session', 'ldap', 'nusoap_loader'));
		$this->load->model('_userloginphr', 'user', TRUE);

		date_default_timezone_set('Asia/Jakarta');

	}

	function index()
	{
		$this->load->view('login_phr_nasabah/login_form_phr');
	}

	function gologin()
	{

		redirect('home_phr_nasabah');
	}

	public function check_login_form(){
		#fungsi untuk check field form
		$username	= strtoupper($this->input->post('username'));
		$password	= $this->input->post('password');

		//reset session kalo user lupa logout
		$resetsession = ($this->input->post('password')=='sesihapus');
		if ($resetsession){
			//$this->user->terminate_session($username);
			$this->reset_session($username);
		}

		elseif(empty($username) && empty($password)){#username dan passwordnya kosong
			// $json['error']		= TRUE;
			// $json['error_msg']	= 'Username dan Password anda kosong!';
			// $json['error_field'][0]='username';
			// $json['error_field'][1]='password';
			?>
			<script type="text/javascript">
				alert('Username dan Password anda kosong! ');
				var urls = '<?php echo site_url('/login_phr_nasabah/')?>';
				window.location.replace(urls)
			</script>
			<?php echo "Username dan Password anda kosong!"; ?>
		<?php
		}elseif(empty($username)){#username kosong
			// $json['error']		= TRUE;
			// $json['error_msg']	= 'Username anda kosong!';
			// $json['error_field'][0]= 'username';

		?>
			<script type="text/javascript">
				alert('Username anda kosong! ');
				var urls = '<?php echo site_url('/login_phr_nasabah/')?>';
				window.location.replace(urls)
			</script>

			<?php echo "Username anda kosong!"; ?>

		<?php
		}elseif(empty($password)){#passwordnya kosong
			// $json['error']		= TRUE;
			// $json['error_msg']	= 'Password anda kosong!';
			// $json['error_field'][0]='password';
		?>
			<script type="text/javascript">
				alert('Password anda kosong! ');
				var urls = '<?php echo site_url('/login_phr_nasabah/')?>';
				window.location.replace(urls)
			</script>

			<?php echo "Password anda kosong!"; ?>

		<?php
		}else{#username dan password tidak kosong redirect ke function find_me_hcms
			// $json['error']		= FALSE;
			// $json['error_msg']	= NULL;
			// $fin['url']		    = BASE_URL.'login_tax_amnesty/find_me_on_hcms/';
			$this->find_me_on_hcms();


		}
		// $jsonSend = json_encode($json); #tampilkan data json
		// $jsonSend = str_replace('\\', ' ', $jsonSend);
		// echo $jsonSend;

	}//end function cek_login

	// public function find_me_on_hcms(){
		// #fungsi cek user di LDAP
		// $username	= $this->input->post('username');
		// $password	= $this->input->post('password');
		// echo $this->user->check_on_ldap($username,$password);
	// }
	function find_me_on_hcms()
	{
		#fungsi cek user di LDAP
		$username	= strtoupper($this->input->post('username'));
		$password	= $this->input->post('password');

		$client = $this->nusoap_loader->load_cliento();
		$params = array(
			'username' => $username,
			'password' => $password
		);
		$result = $client->call('doAuth', $params);
		//echo $result;
		$err = $client->getError();
		//echo $err;
		if ($client->fault || $err) {
			#failed message

		} else {
			$lanjut=false;
			//get data user
			$data = $this->user->get_by_username($username);
			if(empty($data)){
			       #error message user tidak terdaftar
				   ?>
						<script type="text/javascript">
							alert('Anda belum terdaftar di database! ');
							var urls = '<?php echo site_url('/login_phr_nasabah/')?>';
							window.location.replace(urls)
						</script>
				   <?php
				   echo "Anda belum terdaftar di database ";
				} elseif($result==2) {
					#error message koneksi dengan HCMS bermasalah
					?>
					<script type="text/javascript">
						alert('koneksi dengan HCMS bermasalah! ');
						var urls = '<?php echo site_url('/login_phr_nasabah/')?>';
						window.location.replace(urls)
					</script>

					<?php
					echo " koneksi dengan HCMS bermasalah ";
				} elseif($result==0) {
					?>
					<script type="text/javascript">
						alert('Password anda salah! ');
						var urls = '<?php echo site_url('/login_phr_nasabah/')?>';
						window.location.replace(urls)
					</script>
					<?php
					echo " Password anda salah! ";
				}else {
					$lanjut=true;
					#session_create, goto home_tax_amnesty
					$data = $this->user->get_by_username($username);
					if ($data){

					//cek user login hanya yang aktif saja status = 1
					if ($data[0]->STATUS == 1) {

					// buat session
					$userdata = array(	'ID' 		  => $data[0]->ID,
										'USERNAME'    => strtoupper($data[0]->USERNAME),
										//'POSISI'	  => $data[0]->POSISI,
										'EMAIL'		  => $data[0]->EMAIL,
										'BRANCH_NAME' => $data[0]->UNIT_ID,
										'ROLE_ID'	  => $data[0]->ROLE_ID,
										'NAMA_ROLE'	  => $data[0]->NAMA_ROLE,
									);
					$now = date("Y-m-d H:i:s");
					$this->session->set_userdata($userdata);
					$session_id = $this->session->userdata('session_id');

					//cek user yang sedang login aplikasi
					$datases = $this->user->cekSession(substr($data[0]->ID, -7,7));
					if ($datases) {
						$session_id = $datases[0]->SESSION_ID;
						$ipnow = $_SERVER['REMOTE_ADDR'];
						$now = time();
						$last = strtotime($datases[0]->TIME);
						$ip_addr = $datases[0]->IP_ADDRESS;
						$browser = $datases[0]->BROWSER;
						$diff = abs($now - $last);
						$minute = floor($diff / 60);
						//$browser = get_browser(null, true);
						$this->load->library('user_agent');
						$browsernow = $this->agent->browser() . ' ' . $this->agent->version();

						if ($minute < 15) {
							echo("<br><h2><center>
								  <p>Maaf User ini telah Login, </p>
								  </center></h2>
								  <a href=\"../login_phr_nasabah/login_force/" . $data[0]->ID . "\"> <center><h4>Klik di sini untuk Login Ulang</center></h4></a>");
							$this->session->sess_destroy();
						}
						elseif ($minute<15 && $session_id!='') {
							echo("<br><h2><center>
							<p>This user has already signed in, please use another user id!</p>
							<p>If your session is locked, please wait for 15 minutes.</p>
							<p>If you need help, Please call SLN Helpdesk for information 021-29713000.</p>
							<p>Or 021-29946000 Helpdesk Technology information(only for kill session user at 18.00 - 24.00 and holidays).</p>
							</center></h2>
							<a href=\"../login_phr_nasabah/login_force/" . $data[0]->ID . "\"> <center><h4>Klik di sini untuk Login</center></h4></a>");
							$this->session->sess_destroy();
						}
						else
						{
							$this->user->roll_back(SUBSTR($data[0]->ID,-7,7));
							$username = $_SESSION['ID'];
							$this->user->reg_session($session_id,SUBSTR($data[0]->ID,-7,7));
							$this->user->insertLoginLog($username);
							$this->gologin();
						}
					}//end datases
					else
					{
						$username = $_SESSION['ID'];
						$this->user->reg_session($session_id,SUBSTR($data[0]->ID,-7,7));
						$this->user->insertLoginLog($username);
						$this->gologin();
					}

					} //end if status = 1
					else
					{
						echo ("<br><h2><center>
							   <p>User Ini Sudah Tidak Aktif</p>
							   <p>Tolong Telepon Helpdesk SLN Untuk Informasi Lebih Lanjut</p>
							   </center></h2>
							   <a href=\"../login_phr_nasabah\"> <center><h4>Klik di sini untuk Login</center></h4></a>");
					}



				} //end if data

			}
		}
	}

	// function login_force($username)
	// {
	// 	redirect('login_phr_nasabah');
	// }


	function reset_session($username)
	{
		$data = $this->user->get_by_username($username);
				if ($data)
				{
					if ($data[0]->STATUS == 1) {
						$userdata = array(	'ID' 		  => $data[0]->ID,
							'USERNAME'    => strtoupper($data[0]->USERNAME),
							//'POSISI'	  => $data[0]->POSISI,
							'EMAIL'		  => $data[0]->EMAIL,
							'BRANCH_NAME' => $data[0]->UNIT_ID,
							'ROLE_ID'	  => $data[0]->ROLE_ID,
							'NAMA_ROLE'	  => $data[0]->NAMA_ROLE,
						);
						$now = date("Y-m-d H:i:s");
						$this->session->set_userdata($userdata);
						$session_id = $this->session->userdata('session_id');
						//cek user yang sedang login aplikasi
						$datases = $this->user->cekSession(substr($data[0]->ID, -7,7));
						if ($datases)
						{
							$username = $_SESSION['ID'];
							$this->user->reg_session_upd($session_id,SUBSTR($data[0]->ID,-7,7));
							$this->user->insertLoginLog($username);
							$this->gologin();
						}
					} // end if status = 1

				} //end if data
	}

	function login_force($username)
	{
		$data = $this->user->get_by_username($username);
		if ($data)
		{
			if ($data[0]->STATUS == 1) {
				$userdata = array(	'ID' 		  => $data[0]->ID,
					'USERNAME'    => strtoupper($data[0]->USERNAME),
					//'POSISI'	  => $data[0]->POSISI,
					'EMAIL'		  => $data[0]->EMAIL,
					'BRANCH_NAME' => $data[0]->UNIT_ID,
					'ROLE_ID'	  => $data[0]->ROLE_ID,
					'NAMA_ROLE'	  => $data[0]->NAMA_ROLE,
				);
				$now = date("Y-m-d H:i:s");
				$this->session->set_userdata($userdata);
				$session_id = $this->session->userdata('session_id');
				//cek user yang sedang login aplikasi
				$datases = $this->user->cekSession(substr($data[0]->ID, -7,7));
				if ($datases)
				{
					$username = $_SESSION['ID'];
					$this->user->reg_session_upd($session_id,SUBSTR($data[0]->ID,-7,7));
					$this->user->insertLoginLog($username);
					$this->gologin();
				}
			} // end if status = 1

		} //end if data
	}

	function logout()
	{
		$session_id = $_SESSION['ID'];
		$this->user->terminate_session($session_id);
		$this->session->unset_userdata(array('ID' => '', 'LOGIN' => FALSE));
        $this->session->sess_destroy();
        redirect('login_phr_nasabah');
	}






}
/* End of file visit.php */
/* Location: ./system/application/controllers/visit.php */
