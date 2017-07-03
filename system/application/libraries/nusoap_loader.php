<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('nusoap.php');

class nusoap_loader{
	function load_cliento(){
		return new nusoap_client(HCMS_WSDL, true);
	}	
}