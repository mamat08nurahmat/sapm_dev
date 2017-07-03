<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class hal extends Controller {

	public function dashboard1()
	{
		$this->load->view('dashboard1');
	}	
	
	public function dashboard2()
	{
		$this->load->view('dashboard2');
	}
}
