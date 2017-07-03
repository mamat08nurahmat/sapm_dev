<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! class_exists('ldap'))
{
     require_once(APPPATH.'libraries/ldap'.EXT);
}

$obj =& get_instance();
$obj->ldap = new ldap();
$obj->ci_is_loaded[] = 'ldap';

class Ldap{
	function Ldap(){
	}
	
	private function connect(){
		$CI =& get_instance();
		//$connect = ldap_connect($CI->config->item('ldap_uri'), $CI->config->item('ldap_port'));
		$connect = ldap_connect('192.168.46.147',389);
		//$connect = ldap_connect('172.23.202.155',389);
		
		return $connect;
	}
	
	private function bind($username, $password){
		$CI =& get_instance();
		$connect = $this->connect();
		
		if($connect){
			$ldaprdn  = "uid=$username,ou=Accounts,o=bni,dc=co,dc=id"; 
			$ldapbind = @ldap_bind($connect, $ldaprdn, $password);
						
			if ($ldapbind) {
		        $sr=ldap_search($connect,$ldaprdn, "uid=$username"); 
				$info = ldap_get_entries($connect, $sr);
				if(!empty($info)){
					return $info[0];
				}else {
					return false;
				}
		    } else {
		        return false;
		    }
		}
	}
	
	public function check_user($username, $password){
		$check = $this->bind($username,$password);
		return $check;
	}
	
	public function get_user_name($uid){
		$CI =& get_instance();
		$connect = $this->connect();
		
		if($connect){
			$ldaprdn  = "ou=Accounts,o=bni,dc=co,dc=id"; 
			$ldapbind = @ldap_bind($connect);
			
			if ($ldapbind) {
		        $sr=ldap_search($connect,$ldaprdn, "uid=$uid"); 
				$info = ldap_get_entries($connect, $sr);
				if(!empty($info[0]['cn'][0])){
					return $info[0]['cn'][0];
				}
		    }
			return false;
		}
	}
	
	public function get_user_name_email($uid){
		$CI =& get_instance();
		$connect = $this->connect();
		
		if($connect){
			$ldaprdn  = "ou=Accounts,o=bni,dc=co,dc=id"; 
			$ldapbind = @ldap_bind($connect);
			
			if ($ldapbind) {
		        $sr=ldap_search($connect,$ldaprdn, "uid=$uid"); 
				$info = ldap_get_entries($connect, $sr);
				if(!empty($info[0]['cn'][0])){
					return array($info[0]['cn'][0],$info[0]['mail'][0]);
				}
		    }
			return array();
		}
	}
	
	public function is_user_valid($uid){
		$CI =& get_instance();
		$connect = $this->connect();
		
		if($connect){
			$ldaprdn  = "ou=Accounts,o=bni,dc=co,dc=id"; 
			$ldapbind = @ldap_bind($connect);
			
			if ($ldapbind) {
		        $sr=ldap_search($connect,$ldaprdn, "uid=$uid"); 
				$info = ldap_get_entries($connect, $sr);
				if(!empty($info)){
					return true;
				}
		    }
			return false;
		}
	}
	
}