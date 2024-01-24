<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('MHome');	
	}

	public function index(){
		$this->MHome->ceklogin();
		$data['beranda'] = 'active';	

		$this->template->load('Home/template','Home/beranda', $data);
	}

}
