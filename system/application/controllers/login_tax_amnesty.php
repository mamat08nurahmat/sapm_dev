<?php
/*
	Web Development : panji asmoro
	email           : pandjiasmoroart@gmail.com
*/
class Login_tax_amnesty extends Controller {

	function login_tax_amnesty()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form', 'file'));
        $this->load->library(array('table','validation', 'session', 'ldap', 'nusoap_loader'));
		$this->load->model('_userlogintax', 'user', TRUE);
		// $this->load->model('_user', 'user', TRUE);

		date_default_timezone_set('Asia/Jakarta');

	}

	function index()
	{
		$this->load->view('login_tax_amnesty/v_login_tax_amnesty');
	}

	function gologin()
	{
		redirect('home_tax_amnesty');
	}

	public function check_login_form(){
		#fungsi untuk check field form
		$username	= strtoupper($this->input->post('username'));
		$password	= $this->input->post('password');

		if(empty($username) && empty($password)){#username dan passwordnya kosong
			// $json['error']		= TRUE;
			// $json['error_msg']	= 'Username dan Password anda kosong!';
			// $json['error_field'][0]='username';
			// $json['error_field'][1]='password';
			?>
			<script type="text/javascript">
				alert('Username dan Password anda kosong! ');
				var urls = '<?php echo site_url('/login_tax_amnesty/')?>';
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
				var urls = '<?php echo site_url('/login_tax_amnesty/')?>';
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
				var urls = '<?php echo site_url('/login_tax_amnesty/')?>';
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
	}

	// public function find_me_on_hcms(){
		// #fungsi cek user di LDAP
		// $username	= $this->input->post('username');
		// $password	= $this->input->post('password');
		// echo $this->user->check_on_ldap($username,$password);
	// }

	public function find_me_on_hcms()
	{
		#fungsi cek user di LDAP
		$username	= $this->input->post('username');
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
							var urls = '<?php echo site_url('/login_tax_amnesty/')?>';
							window.location.replace(urls)
						</script>
				   <?php
				   echo "Anda belum terdaftar di database ";
				} elseif($result==2) {
					#error message koneksi dengan HCMS bermasalah
					?>
					<script type="text/javascript">
						alert('koneksi dengan HCMS bermasalah! ');
						var urls = '<?php echo site_url('/login_tax_amnesty/')?>';
						window.location.replace(urls)
					</script>

					<?php
					echo " koneksi dengan HCMS bermasalah ";
				} elseif($result==0) {
					?>
					<script type="text/javascript">
						alert('Password anda salah! ');
						var urls = '<?php echo site_url('/login_tax_amnesty/')?>';
						window.location.replace(urls)
					</script>
					<?php
					echo " Password anda salah! ";
				}else {
					$lanjut=true;
					#session_create, goto home_tax_amnesty
					$userdata = array(	'ID' 		  => $data[0]->ID,
									'USERNAME'    => strtoupper($data[0]->USERNAME),
									'POSISI'	  => $data[0]->POSISI,
									'EMAIL'		  => $data[0]->EMAIL,
									'BRANCH_NAME' => $data[0]->UNIT_ID,
									'ROLE_ID'	  => $data[0]->ROLE_ID,
									'NAMA_ROLE'	  => $data[0]->NAMA_ROLE,
								);
					$this->session->set_userdata($userdata);
					//$session_id = $this->session->userdata('session_id');
					$this->gologin();

			}
		}

	}


	function logout()
	{
		$session_id = $_SESSION['ID'];
		$this->session->sess_destroy($session_id);
        redirect('login_tax_amnesty');
	}






}
/* End of file visit.php */
/* Location: ./system/application/controllers/visit.php */
