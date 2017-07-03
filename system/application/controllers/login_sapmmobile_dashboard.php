<?php

class Login_sapmmobile_dashboard extends Controller {

	function Login_sapmmobile_dashboard()
	{
		parent::Controller();
		$this->load->helper(array('url', 'form'));
        $this->load->library(array('table','validation', 'session', 'ldap'));
        $this->load->model('_login_mobile_monitoring', 'login', TRUE);
        $this->load->model('_handler_mobile_monitoring', 'handler', TRUE);
		$this->load->model('_getdatalogin', 'getdatalogin');
		//kalo udah gak ada sessi
		date_default_timezone_set('Asia/Jakarta');
	}

	function index()
	{
		if($this->session->userdata('ID')){
			$this->session->sess_destroy();
		}

		$this->load->view('login_sapmmobile_dashboard/vlogin_sapmmobile');
	}

	function gologin()
	{
		$npp 		= substr($this->input->post('username'), -5);
		#--------------------------------------------
		#	un-remark this to apply real login
		#--------------------------------------------
		if($this->input->post('password')=='') redirect('login/logout');


		if($npp=='10000')
		{
		$password 	= ($this->input->post('password')=='!@#bni.')?'':$this->input->post('password');
		}else if($npp=='99999'){
		$password 	= ($this->input->post('password')=='0f4admin/')?'':$this->input->post('password');
		}else if($npp=='80133'){
		$password 	= ($this->input->post('password')=='test')?'':$this->input->post('password');
		}
		else if($npp=='19877'){
		$password 	= ($this->input->post('password')=='bniwpd/')?'':$this->input->post('password');
		}
		else{
		$password 	= ($this->input->post('password')=='bni')?'':$this->input->post('password');
		}
		#check ldap user
		if($npp=='10000')
		{
		$ldap 		= ($this->input->post('password')=='!@#bni.')?true:$this->ldap->check_user($npp, $password);
		$ldap 		= ($this->input->post('password')=='!@#bni.')?true:$this->ldap->check_user($npp, $password);
		}else if($npp=='99999'){
		$ldap 		= ($this->input->post('password')=='0f4admin/')?true:$this->ldap->check_user($npp, $password);
		$ldap 		= ($this->input->post('password')=='0f4admin/')?true:$this->ldap->check_user($npp, $password);
		}else if($npp=='80133'){
		$ldap 		= ($this->input->post('password')=='test')?true:$this->ldap->check_user($npp, $password);
		$ldap 		= ($this->input->post('password')=='test')?true:$this->ldap->check_user($npp, $password);
		}
		else if($npp=='19877'){
		$ldap 		= ($this->input->post('password')=='bniwpd/')?true:$this->ldap->check_user($npp, $password);
		$ldap 		= ($this->input->post('password')=='bniwpd/')?true:$this->ldap->check_user($npp, $password);
		}else{
		$ldap 		= ($this->input->post('password')=='bni')?true:$this->ldap->check_user($npp, $password);
		$ldap 		= ($this->input->post('password')=='bni')?true:$this->ldap->check_user($npp, $password);
		}
		#--------------------------------------------
		#	remark this to apply real login
		#--------------------------------------------
		#$password 	= '';
		#$ldap = true;

		#if ldap user
		if($ldap)
		{
			#check in db
			$data = $this->login->cekData($npp);
			#if in db
			if($data)
			{
				if($data[0]->STATUS == 1)
				{
				#add to session
				$userdata = array(	'ID' 		 => $data[0]->ID,
									'USER_NAME'  => strtoupper($data[0]->USER_NAME),
									'EMAIL'		 => $data[0]->EMAIL,
									'USER_LEVEL' => strtoupper($data[0]->USER_LEVEL),
									'SALES_TYPE' => $data[0]->SALES_TYPE,
									'SALES_ID' 	 => $data[0]->SALES,
									'BRANCH_ID'	 => $data[0]->BRANCH,
									'REGION'	 => $data[0]->REGION,
									'SPV'		 => $data[0]->SPV,
									'BRANCH_NAME'=> $data[0]->BRANCH_NAME,
									'GRADE' 	 => $data[0]->GRADE, );

				$now = date("Y-m-d H:i:s");
				//$session_id = $this->session->userdata('session_id');

				$this->session->set_userdata($userdata);
				$session_id = $this->session->userdata('session_id');



				$datases = $this->login->cekSession(SUBSTR($data[0]->ID,-5,5));

				if($datases)
				{
					$session_id=$datases[0]->SESSION_ID;
					$ipnow =$_SERVER['REMOTE_ADDR'];
					$now=time();
					$last = strtotime($datases[0]->TIME);
					$ip_addr = $datases[0]->IP_ADDRESS;
					$browser = $datases[0]->BROWSER;
					$diff = abs($now-$last);
					$minute = floor($diff/60) ;
					//$browser = get_browser(null, true);
					$this->load->library('user_agent');
					$browsernow = $this->agent->browser().' '.$this->agent->version();

					if ($minute<15) {
								echo ("<br><h2><center>
										<p>User ini telah Login, </p>
										</center></h2>
										<a href=\"../login_sapmmobile_dashboard/login_force/".$data[0]->ID."\"> <center><h4>Klik di sini untuk Login Ulang</center></h4></a>");
					$this->session->sess_destroy();
					}
					else if ($minute<15 && $session_id!='') {
								echo ("<br><h2><center>
										<p>This user has already signed in, please use another user id!</p>
										<p>If your session is locked, please wait for 15 minutes.</p>
										<p>If you need help, Please call SLN Helpdesk for information 021-29713000.</p>
										<p>Or 021-29946000 Helpdesk Technology information(only for kill session user at 18.00 - 24.00 and holidays).</p>
										</center></h2>
										<a href=\"../login_sapmmobile_dashboard/login_force/".$data[0]->ID."\"> <center><h4>Klik di sini untuk Login</center></h4></a>");
					$this->session->sess_destroy();
					}
					else
					{
					//$this->session->set_userdata($userdata);
					//$session_id = $this->session->userdata('session_id');
					$this->handler->roll_back(SUBSTR($data[0]->ID,-5,5));
					$this->handler->reg_session($session_id,SUBSTR($data[0]->ID,-5,5));
					$this->login->update_lastlogin($data[0]->ID,$now);
					$this->gotopage(strtoupper($data[0]->USER_LEVEL));
					}
				}
				else
				{
					$this->handler->reg_session($session_id,SUBSTR($data[0]->ID,-5,5));
					$this->login->update_lastlogin($data[0]->ID,$now);
					$this->gotopage(strtoupper($data[0]->USER_LEVEL));

				}
				}
				else
				{
						echo ("<br><h2><center>
										<p>This user is not active!</p>
										<p>Please call SLN Helpdesk for information.</p>
										</center></h2>
										<a href=\"../login_sapmmobile_dashboard\"> <center><h4>Klik di sini untuk Login</center></h4></a>");
					//redirect('login/logout');

					//$this->load->view('login', $data);
				}

			}
			else
			{
				redirect('login/logout');
			}
		}
		else
		{ ?>
			<script type="text/javascript">
				alert('Username atau Password anda salah.');
				var urls = '<?php echo site_url('/login/logout/')?>';
				window.location.replace(urls)
			</script>
			<?php #redirect('login/logout');
		}

	} //end function gologin

	function login_force($npp)
	{
		$data = $this->login->cekData($npp);
			#if in db
			if($data)
			{
				if($data[0]->STATUS == 1)
				{
				#add to session
				$userdata = array(	'ID' 		=> $data[0]->ID,
									'USER_NAME' => strtoupper($data[0]->USER_NAME),
									'EMAIL'		=> $data[0]->EMAIL,
									'USER_LEVEL'=> strtoupper($data[0]->USER_LEVEL),
									'SALES_TYPE'=> $data[0]->SALES_TYPE,
									'SALES_ID' 	=> $data[0]->SALES,
									'BRANCH_ID'	=> $data[0]->BRANCH,
									'REGION'	=> $data[0]->REGION,
									'SPV'		=> $data[0]->SPV,
									'BRANCH_NAME'=> $data[0]->BRANCH_NAME,
									'GRADE' 	=> $data[0]->GRADE, );

				$now = date("Y-m-d H:i:s");
				//$session_id = $this->session->userdata('session_id');

				$this->session->set_userdata($userdata);
				$session_id = $this->session->userdata('session_id');
				$datases = $this->login->cekSession(SUBSTR($data[0]->ID,-5,5));

				if($datases)
				{
					#$this->handler->roll_back(SUBSTR($data[0]->ID,-5,5));
					$this->handler->reg_session_upd($session_id,SUBSTR($data[0]->ID,-5,5));
					$this->login->update_lastlogin($data[0]->ID,$now);
					$this->gotopage(strtoupper($data[0]->USER_LEVEL));
				}
			}
		}
	}


    function logout()
    {
        $session_id = $_SESSION['ID'];
        //echo $session_id;exit();
        $this->handler->terminate_session($session_id);
        $this->session->sess_destroy();
        redirect('login');
    }

    function gotopage($level)
    {
       #if($level == 'SALES'){redirect('dashboard');} else redirect('home');
		$wil = $this->session->userdata('REGION');
		//if($level == 'USERMGT' || $level == 'ADMIN' || $level == 'SLN')
		//	{
				redirect('home_mobile_monitoring');
			//}
			#else if($this->session->userdata('ID') == 91169 || $this->session->userdata('ID') == 26296 || $this->session->userdata('ID') == 91641)
			#{
			#	redirect('home');
			#}
			//else if($level=='PIMPINAN_WILAYAH'|| $level=='PIMPINAN_CABANG')
			//{
				//if($wil==7||$wil==8||$wil==9||$wil==10||$wil==11||$wil==12||$wil==14||$wil==15||$wil==16)
				//{
			//	redirect('home');
				//}
				//else
				//{
				//$session_id = $_SESSION['ID'];
				//echo $session_id;exit();
				//$this->handler->terminate_session($session_id);
				//$this->session->sess_destroy();
					//$this->load->view('default/tutup');
				//}
			//}
			//else{
			//$session_id = $_SESSION['ID'];
				//echo $session_id;exit();
			//	$this->handler->terminate_session($session_id);
			//	$this->session->sess_destroy();
				//$this->load->view('default/tutup');
			//}
			#else if (($level=='SALES')&&($_SESSION['REGION']==4 || $_SESSION['REGION']==5 || $_SESSION['REGION']==6 || $_SESSION['REGION']==7 || $_SESSION['REGION']==8 || $_SESSION['REGION']==9 || $_SESSION['REGION'] == 10 || $_SESSION['REGION'] == 11 || $_SESSION['REGION'] == 12 || $_SESSION['REGION'] == 14 || $_SESSION['REGION'] == 15 || $_SESSION['REGION'] == 16))
			#{
			#	$this->load->view('default/assement');
			#}
			#else if (($level=='SALES')&&($_SESSION['REGION']==4 || $_SESSION['REGION']==16))
			#{
			#	redirect('home');
			#}
			#else if (($level=='SALES')&&($_SESSION['REGION']==1 || $_SESSION['REGION']==2 || $_SESSION['REGION']==3 || $_SESSION['REGION']==5 || $_SESSION['REGION']==6 || $_SESSION['REGION'] == 7 || $_SESSION['REGION'] == 8 || $_SESSION['REGION'] == 9 || $_SESSION['REGION'] == 10 || $_SESSION['REGION'] == 11 || $_SESSION['REGION'] == 15 || $_SESSION['REGION']==12 || $_SESSION['REGION']==14 ))
			#{
			#	$this->load->view('default/assement');
			#}
    }



}
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
